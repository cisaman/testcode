<?php

class UsersController extends Controller {

    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    //public $layout='//layouts/column2';
    public $user_data;

    protected function beforeAction($event) {

        if (!isset(Yii::app()->session['user_data'])) {
            $this->redirect(Yii::app()->request->baseUrl . '/auth');
        }

        $this->user_data = Yii::app()->session['user_data'];

        return true;
    }

    /**
     * @return array action filters
     */
    public function filters() {
        return array(
            'accessControl', // perform access control for CRUD operations
            'postOnly + delete', // we only allow deletion via POST request
        );
    }

    /**
     * Specifies the access control rules.
     * This method is used by the 'accessControl' filter.
     * @return array access control rules
     */
    public function accessRules() {
        return array(
            array('allow', // allow authenticated users to access all actions
                'users' => array(Yii::app()->user->name),
            ),
            array('deny'),
        );
    }

    /**
     * Displays a particular model.
     * @param integer $id the ID of the model to be displayed
     */
    public function actionView($id) {
        $id = base64_decode($id);
        $this->render('view', array(
            'model' => $this->loadModel($id),
        ));
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate() {
        $model = new Users;
        $this->performAjaxValidation($model);
        if (isset($_POST['Users'])) {
            $model->attributes = $_POST['Users'];
            $model->user_created_by_id = $this->user_data['user_id'];
            $passwod = $model->user_password;
            $model->user_password = md5($passwod);

            $userdata['user_name'] = $model->user_name;
            $userdata['user_email'] = $model->user_email;
            $userdata['user_password'] = $passwod;
            $userdata['login_url'] = Utils::getBaseUrl() . "/auth";
            $userdata['website_url'] = Utils::getBaseUrl();

            $template = Template::getTemplate('log-in_mail_template');
            $subject = $template->template_subject;
            $message = $template->template_content;

            $subject = $this->replace($userdata, $subject);
            $message = $this->replace($userdata, $message);

            if (Yii::app()->session['user_data']['user_role_type'] == 3) {
                $model->user_role_type = 4;
                $model->user_department_id = Yii::app()->session['user_data']['user_department_id'];
            }

            if ($model->save()) {
                $this->SendMail($model->user_email, $model->user_name, $subject, $message);
                Yii::app()->user->setFlash('type', 'success');
                Yii::app()->user->setFlash('message', 'User added successfully.');
            } else {
                Yii::app()->user->setFlash('type', 'danger');
                Yii::app()->user->setFlash('message', 'Operation failded due to lack of connectivity. Try again later!!!');
            }
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
        }

        $this->render('create', array(
            'model' => $model,
        ));
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id) {
        $id = base64_decode($id);
        $model = $this->loadModel($id);

        $this->performAjaxValidation($model);

        if (isset($_POST['Users'])) {
            $model->attributes = $_POST['Users'];

            if ($model->update()) {
                if ($model->user_status == 0) {
                    $ticketAssign = TicketAssign::model()->findAllByAttributes(array('fwd_to' => $model->user_id));
                    foreach ($ticketAssign as $s) {
                        $newModel = TicketAssign::model()->findByPk($s->id);
                        $newModel->status = 0;
                        $newModel->update();
                    }
                }
                Yii::app()->user->setFlash('type', 'success');
                Yii::app()->user->setFlash('message', 'User updated successfully.');
            } else {
                Yii::app()->user->setFlash('type', 'danger');
                Yii::app()->user->setFlash('message', 'Operation failded due to lack of connectivity. Try again later!!!');
            }
            $this->redirect(array('index'));
        }

        $this->render('update', array(
            'model' => $model,
        ));
    }

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDelete($id) {
        $id = base64_decode($id);
        $model = $this->loadModel($id);
        $status = TicketAssign::getTicketbyUser($id);
        if (count($status)) {
            if (!isset($_GET['ajax'])) {
                Yii::app()->user->setFlash('type', 'warning');
                Yii::app()->user->setFlash('message', 'Could Not Delete User Because user has been assigned ticket.');
            } else {
                echo '<div class="alert alert-warning alert-dismissable" id="successmsg">Could Not Delete User Because user has been assigned ticket.</div>';
            }
        } else {
            $model->delete();
            if (!isset($_GET['ajax'])) {
                Yii::app()->user->setFlash('type', 'success');
                Yii::app()->user->setFlash('message', 'Could Not Delete User Because user has been assigned ticket.');
            } else {
                echo '<div class="alert alert-success alert-dismissable" id="successmsg">User removed successfully.</div>';
            }
        }
    }

    /**
     * Lists all models.
     */
    public function actionIndex() {
        $model = new Users('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Users'])) {
            $model->attributes = $_GET['Users'];
        }

        $this->render('index', array(
            'model' => $model,
        ));
    }

    /**
     * Lists all models.
     */
    public function actionClients() {
        $model = new Users('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Users'])) {
            $model->attributes = $_GET['Users'];
        }

        $this->render('clients', array(
            'model' => $model,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return Users the loaded model
     * @throws CHttpException
     */
    public function loadModel($id) {

        $model = Users::model()->findByPk($id);
        if ($model === null) {
            throw new CHttpException(404, 'The requested page does not exist.');
        }
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param Users $model the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'users-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    public function actionCustomSearch() {
        $restrictedUsers = array();
        $restrictedUsers = $_POST['restrictedUsers'];
        $ticket_id = $_POST['ticket_id'];
        $assigneeList = TicketAssign::model()->findAllByAttributes(array("ticket_id" => $ticket_id, "status" => 1));
        foreach ($assigneeList as $row) {
            $restrictedUsers[] = $row['fwd_to'];
        }
        $username = $_POST['username'];
        $deparment = $_POST['department'];
        $emailid = $_POST['email_id'];
        $userList = Users::model()->getFilterUser($username, $deparment, $restrictedUsers ,$emailid);
        if (!empty($userList)) {
            foreach ($userList as $row) {

                $userlist[$row['user_id']] = $row['user_name'] . " (". $row['user_email']. ", " . UserRoles::model()->getRoleName($row['user_role_type']) . ")";
            }
            echo CHtml::checkBoxList('userlist', '', $userlist, array('template' => '<div class="col-sm-6 removeBR">{input} {label}</div>', 'class' => 'selectAssignee'));
        } else {
            echo "<div class='col-md-12'><div class='alert alert-danger'>No users found. </div></div>";
        }
    }

    public function actionchangestatus() {
        $user_id = $_POST['user_id'];
        $user_status = $_POST['status'];
        $model = Users::model()->findByPk($user_id);
        $model->user_status = $user_status;
        $model->update();
    }

}
