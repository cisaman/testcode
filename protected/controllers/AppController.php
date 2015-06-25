<?php

class AppController extends Controller {

    public function actionAddOrder() {
        
    }

    public function actionAddUser() {

        $model = new Users;
        if (isset($_REQUEST['user_name']) && isset($_REQUEST['user_email'])) {
            $model->user_created_by_id = 0;
            $model->user_email = $_REQUEST['user_email'];
            $model->user_name = $_REQUEST['user_name'];
            $model->user_role_type = 5;
            $passwod = Utils::getRandomPassword();
            $model->user_password = md5($passwod);

            $userdata['user_name'] = $model->user_name;
            $userdata['user_email'] = $model->user_email;
            $userdata['user_password'] = $passwod;
            $userdata['login_url'] = Utils::getBaseUrl() . "/auth";

            $template = Template::getTemplate('log-in_mail_template');
            $subject = $template->template_subject;
            $message = $template->template_content;

            $subject = $this->replace($userdata, $subject);
            $message = $this->replace($userdata, $message);


            if ($model->save()) {
                $this->SendMail($model->user_email, $model->user_name, $subject, $message);

                echo json_encode(array("error" => FALSE, 'error_code' => "200", "Message" => "User added successfully."));
            } else {

                echo json_encode(array("error" => TRUE, 'error_code' => "201", "Message" => "User Email is already Registor."));
            }
        } else {
            echo json_encode(array("error" => TRUE, 'error_code' => "203", "Message" => "User name & Email are required."));
        }
    }

    function actionMailToUsers() {

        $this->actionEmailAssignee();
        $this->actionEmailChangeTicketStatus();
        $this->actionEmailComments();
        echo '1';
    }

    function actionEmailAssignee() {
        $template = Template::getTemplate('user_mail_on_assign_ticket_');
        $subject = $template->template_subject;
        $message = $template->template_content;
        $userdata['website_url'] = Utils::getBaseUrl();
        $results = TicketAssign::model()->findAllByAttributes(array(), array(
            'condition' => 'send_mail = :send_mail AND status=1',
            'params' => array('send_mail' => 0)
        ));

        foreach ($results as $users) {
            $userInfo = Users::model()->findByPk($users->fwd_to);
            $ticket_id = $users->ticket_id;
            $userdata['ticket_id'] = $ticket_id;
            $userdata['user_name'] = $userInfo->user_name;
            $userdata['role_name'] = UserRoles::model()->getRoleName($users->fwd_by);
            $userdata['ticket_link'] = Utils::getBaseUrl() . "/ticket/view/" . base64_encode($ticket_id);
            $subject = $this->replace($userdata, $subject);
            $message = $this->replace($userdata, $message);
            $this->SendMail($userInfo->user_email, $userInfo->user_name, $subject, $message);
            $model = TicketAssign::model()->findByPk($users->id);
            $model->send_mail = 1;
            $model->update();
        }
    }

    function actionEmailComments() {

        $template = Template::getTemplate('comment_mail_template');
        $subject = $template->template_subject;
        $message = $template->template_content;
        $userdata['website_url'] = Utils::getBaseUrl();
        $results = TicketThread::model()->findAllByAttributes(array(), array(
            'condition' => 'send_mail = :send_mail',
            'params' => array('send_mail' => 0)
        ));
        foreach ($results as $users) {

            $ticket_id = $users->ticket_id;
            $comments = $users->descriptions;
            $files = unserialize($users->attachments);
            if (!empty($files)) {
                $doclink = '<a href="' . Yii::app()->createAbsoluteUrl('ticket/createZip/' . base64_encode($users->thread_id)) . '"><i class="fa fa-file"></i> Attachments #' . count($files) . '</a>';
            } else {
                $doclink = 'No Attachments';
            }
            $userdata['user_by'] = Users::model()->getUserName($users->user_id);
            $userdata['comment'] = $comments;
            $userdata['attachments'] = $doclink;
            $userdata['ticket_id'] = $ticket_id;
            $userdata['ticket_link'] = Utils::getBaseUrl() . "/ticket/view/" . base64_encode($ticket_id);

            $assignee = TicketAssign::model()->findAllByAttributes(array(), array(
                'condition' => 'ticket_id = :ticket_id AND fwd_to !=:user_id AND status=1 ',
                'params' => array('ticket_id' => $ticket_id, user_id => $users->user_id)
            ));
            $assigneeby = TicketAssign::model()->findAllByAttributes(array(), array(
                'condition' => 'ticket_id = :ticket_id AND fwd_by !=:user_id AND status=1 ',
                'params' => array('ticket_id' => $ticket_id, user_id => $users->user_id),
                'group' => "fwd_by"
            ));
            // For Assignee mail
            foreach ($assignee as $user) {
                $userInfo = Users::model()->findByPk($user->fwd_to);
                $userdata['user_name'] = $userInfo->user_name;
                $subject = $this->replace($userdata, $subject);
                $message = $this->replace($userdata, $message);
                $this->SendMail($userInfo->user_email, $userInfo->user_name, $subject, $message);
            }
            // this is fowwarded by
            foreach ($assigneeby as $user) {
                $userInfo = Users::model()->findByPk($user->fwd_by);
                $userdata['user_name'] = $userInfo->user_name;
                $subject = $this->replace($userdata, $subject);
                $message = $this->replace($userdata, $message);
                $this->SendMail($userInfo->user_email, $userInfo->user_name, $subject, $message);
            }

            $model = TicketThread::model()->findByPk($users->thread_id);
            $model->send_mail = 1;
            $model->update();
        }
    }

    function actionEmailChangeTicketStatus() {

        $template = Template::getTemplate('ticket_status_changed_mail_template_');
        $subject = $template->template_subject;
        $message = $template->template_content;
        $results = TicketChangeLog::model()->findAllByAttributes(array(), array(
            'condition' => 'send_mail = :send_mail',
            'params' => array('send_mail' => 0)
        ));
        foreach ($results as $users) {
            $userdata['user_by'] = Users::model()->getUserName($users->user_id);
            $userInfo = Users::model()->findByPk($user->fwd_to);
            $ticket_id = $users->ticket_id;
            $remark = $users->remark;
            $userdata['user_by'] = Users::model()->getUserName($users->user_id);
            ;
            $userdata['remark'] = $remark;
            $userdata['ticket_status_name'] = TicketStatus::model()->getStatusName($users->status_id);
            $userdata['ticket_id'] = $ticket_id;
            $userdata['ticket_link'] = Utils::getBaseUrl() . "/ticket/view/" . base64_encode($ticket_id);

            $assignee = TicketAssign::model()->findAllByAttributes(array(), array(
                'condition' => 'ticket_id = :ticket_id AND fwd_to !=:user_id AND status=1 ',
                'params' => array('ticket_id' => $ticket_id, user_id => $users->user_id)
            ));
            $assigneeby = TicketAssign::model()->findAllByAttributes(array(), array(
                'condition' => 'ticket_id = :ticket_id AND fwd_by !=:user_id AND status=1 ',
                'params' => array('ticket_id' => $ticket_id, user_id => $users->user_id),
                'group' => "fwd_by"
            ));
            // For Assignee mail
            foreach ($assignee as $user) {
                $userInfo = Users::model()->findByPk($user->fwd_to);
                $userdata['user_name'] = $userInfo->user_name;
                $subject = $this->replace($userdata, $subject);
                $message = $this->replace($userdata, $message);
                $this->SendMail($userInfo->user_email, $userInfo->user_name, $subject, $message);
            }
            // this is fowwarded by
            foreach ($assigneeby as $user) {
                $userInfo = Users::model()->findByPk($user->fwd_by);
                $userdata['user_name'] = $userInfo->user_name;
                $subject = $this->replace($userdata, $subject);
                $message = $this->replace($userdata, $message);
                $this->SendMail($userInfo->user_email, $userInfo->user_name, $subject, $message);
            }

            $model = TicketChangeLog::model()->findByPk($users->id);
            $model->send_mail = 1;
            $model->update();
        }
    }

}
