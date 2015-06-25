<?php

/**
 * ForgetPassword class.
 * ForgetPassword is the class for recover the password
 */
class ForgetPassword extends CFormModel {

    public $username;
    public $user_password;

    /**
     * Declares the validation rules.
     * The rules state that username and password are required,
     * and password needs to be authenticated.
     */
    public function rules() {
        return array(
            // username and password are required
            array('username', 'required', 'message' => 'Please enter {attribute}.'),
            array('username', 'email', 'message' => 'Invalid {attribute}.'),
        );
    }

    /**
     * Declares attribute labels.
     */
    public function attributeLabels() {
        return array(
            'username' => 'Email ID'
        );
    }

    /**
     * Sends the newly generated password to the email of user using the given username in the model.
     * @return boolean whether successfuly send password
     */
    public function send_password($user_id) {
        $userModel = new SuUser;
        $model = new Admin_ajax;
        $password = $userModel->random_password();
        $this->user_password = md5($password);
        $userData = $this->getUserData($user_id);
        $userData['user_password'] = $password;
///////////////////////////////////////////////////////////////////////
///////////Create Forgot password email Template //////////////////////
///////////////////////////////////////////////////////////////////////

        $tempemaildata = $model->customOneRowQuery("SELECT * FROM `su_notification_templates`  WHERE type='email' and alias='forgotpassward'");
        $emailtemplate = new Template;
        $emailtemplate->setKeys($userData);
        $emailText = $emailtemplate->replace($tempemaildata['content']);

///////////////////////////////////////////////////////////////////////
///////////End Create Forgot password email Template //////////////////
/////////////////////////////////////////////////////////////////////// 
///////////////////////////////////////////////////////////////////////
///////////Create Forgot password email Template //////////////////////
///////////////////////////////////////////////////////////////////////

        $tempsmsdata = $model->customOneRowQuery("SELECT * FROM `su_notification_templates`  WHERE type='sms' and alias='forgotpassward'");
        $smstemplate = new Template;
        $smstemplate->setKeys($userData);
        $smsText = $smstemplate->replace($tempsmsdata['content']);
//print_r($userData);die;
///////////////////////////////////////////////////////////////////////
///////////End Create Forgot password email Template //////////////////
/////////////////////////////////////////////////////////////////////// 
//        $data = array("name" => $userData["user_fname"], "email" => $userData["user_email"], "password" => $password);
//        $msg_data = 'Below are the new password for PayWayhelp account :
//        
//                   Username/Email : ' . $userData["user_email"] . '
//
//                   Password :  ' . $password;
        $insert = $this->set_password($this->user_password, $user_id);

        $admin_ajax = new Admin_ajax;
        $msg_id = '';
        // if ($insert) {
        if (isset($userData["user_notification"]) && $userData["user_notification"] == 'both') {
            //$UserEmail = new UserEmail($this->username,$this->user_password);
            $UserEmail = new UserEmail;
            //$status = $UserEmail->SendMail($userData["user_email"], 'Reset Password', 'reset_password', $data);
            $UserEmail->SendCustomMail($userData["user_email"], "Paywayhelp : Reset Password", $emailText);
            //sms api
            //$msg_id = $this->send_sms_via_gateway($userData["user_fname"], 'Reset Password', $msg_data);
            $msg_id = $this->send_sms_via_gateway($userData["user_phoneNumber"], 'Reset Password', $smsText);
            //add message data
            $admin_ajax->insert_data('su_message', array('message_id' => $msg_id, 'message_user' => $user_id, 'message_date' => date('Y-m-d H:i:s')));
        } elseif (isset($userData["user_notification"]) && $userData["user_notification"] == 'mail') {
            $UserEmail = new UserEmail;
            //$status = $UserEmail->SendMail($userData["user_email"], 'Reset Password', 'reset_password', $data);
            $UserEmail->SendCustomMail($userData["user_email"], "Paywayhelp : Reset Password", $emailText);
        } elseif (isset($userData["user_notification"]) && $userData["user_notification"] == 'sms') {
            //sms api
            $msg_id = $this->send_sms_via_gateway($userData["user_phoneNumber"], 'Reset Password', $smsText);

            //add message data
            $admin_ajax->insert_data('su_message', array('message_id' => $msg_id, 'message_user' => $user_id, 'message_date' => date('Y-m-d H:i:s')));
        }
        return $msg_id;
        /*  } else {
          return false;
          } */
    }

    public function userExist($email) {
        $res = Yii::app()->db->createCommand()
                ->select('*')
                ->from('users')
                ->where(array('user_email' => $email))
                ->queryAll();
        return $res[0];
    }

    public function set_password($password, $id) {

        $sql = 'UPDATE users set user_password = "' . $password . '"  WHERE user_id = ' . $id;
        $log_model = new Admin_ajax;
        $log_model->addLog("Update", 'users', $id, "Performed Update Operation");
        return Yii::app()->db->createCommand($sql)->execute();
    }

    public function getUserData($user_id) {
        $res = Yii::app()->db->createCommand()
                ->select('user_fname,user_lname,user_email,user_title,user_phoneNumber,user_notification')
                ->from('su_user')
                ->where('user_id=:id', array(':id' => $user_id))
                ->queryAll();
        return $res[0];
    }

    /*
     * Send SMS
     */
}
