<?php

class ModulePermissionController extends Controller {

    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
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
        $this->render('view', array(
            'model' => $this->loadModel($id),
        ));
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate() {
        $model = new ModulePermission;

        // Uncomment the following line if AJAX validation is needed
        $this->performAjaxValidation($model);

        if (isset($_POST['ModulePermission'])) {
            $model->attributes = $_POST['ModulePermission'];
            $model->created_id = $this->user_data['user_id'];
            $flag = 0;
            if (isset($_POST['ModulePermission']['module_id']) && !empty($_POST['ModulePermission']['module_id'])) {
                $moudule_list = $_POST['ModulePermission']['module_id'];
                ModulePermission::model()->deleteAll("user_role_type ='" . $model->user_role_type . "'");
            }
            foreach ($moudule_list as $row) {
                $model->setIsNewRecord(true);
                $model->module_id = $row;
                $model->insert();
                $model->module_permission_id = $model->module_permission_id + 1;
                $flag = 1;
            }
            if ($flag) {
                Yii::app()->user->setFlash('type', 'success');
                Yii::app()->user->setFlash('message', 'Permission added successfully.');
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
        $model = $this->loadModel($id);

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['ModulePermission'])) {
           
            $model = new ModulePermission;
            $model->attributes = $_POST['ModulePermission'];
            $model->created_id = $this->user_data['user_id'];
            $model->updated_id = $this->user_data['user_id'];
            $model->user_role_type = $id;
            $flag = 0;
            if (isset($_POST['ModulePermission']['module_id']) && !empty($_POST['ModulePermission']['module_id'])) {
                $moudule_list = $_POST['ModulePermission']['module_id'];
                ModulePermission::model()->deleteAll("user_role_type ='" . $id . "'");
            }

            foreach ($moudule_list as $row) {
                $model->setIsNewRecord(true);
                $model->module_id = $row;
                $model->insert();
                $model->module_permission_id = $model->module_permission_id + 1;
                $flag = 1;
            }
            Yii::app()->user->setFlash('type', 'success');
            Yii::app()->user->setFlash('message', 'Permission Updated successfully.');
           
            if ($flag)
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

        $status = Users::model()->checkUserRole($id);

        if ($status) {
            echo '<div class="alert alert-warning">Could Not Delete Permission Because User Role Type is Attached with Users.</div>';
        } else {
            ModulePermission::model()->deleteAll("user_role_type ='" . $id . "'");
        }

        // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
        if (!isset($_GET['ajax']))
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('/'));
    }

    /**
     * Lists all models.
     */
    public function actionIndex() {
        $model = new ModulePermission('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['ModulePermission']))
            $model->attributes = $_GET['ModulePermission'];

        $this->render('index', array(
            'model' => $model,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return ModulePermission the loaded model
     * @throws CHttpException
     */
    public function loadModel($id) {
        $model = ModulePermission::model()->findAllByAttributes(array('user_role_type' => $id));
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param ModulePermission $model the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'module-permission-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}
