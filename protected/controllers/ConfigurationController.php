<?php

class ConfigurationController extends Controller {
    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    //public $layout='//layouts/column2';

    /**
     * @return array action filters
     */
    public $user_data;

    protected function beforeAction($event) {
        if (!isset(Yii::app()->session['user_data'])) {
            $this->redirect(Yii::app()->request->baseUrl . '/auth');
        }
        $this->user_data = Yii::app()->session['user_data'];
        return true;
    }

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
        $model = new Configuration;

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['Configuration'])) {
            $model->attributes = $_POST['Configuration'];
            if ($model->save())
                $this->redirect(array('view', 'id' => $model->_id));
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

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDelete($id) {
        $this->loadModel($id)->delete();

        // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
        if (!isset($_GET['ajax']))
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
    }

    /**
     * Lists all models.
     */
    public function actionIndex() {
        $model = new Configuration();
        if ($_POST['Configuration']) {
            $att = array();
            $att = $_POST['Configuration'];

            foreach ($att as $key => $value) {
                $setmodel = $model->findByAttributes(array('name' => $key));
                $setmodel->value = $value;
                $setmodel->update();
            }
            if (isset($_FILES)) {

                $setmodel = $model->findByAttributes(array('name' => 'company_logo'));
                $filename = Utils::getBasepath() . "/img/" . $setmodel->value;
                if (!empty($_FILES['Configuration']['tmp_name']['company_logo'])) {

                    $file_size = $_FILES['Configuration']['size']['company_logo'];
                    $file_type = $_FILES['Configuration']['type']['company_logo'];
                    $acceptable = array('image/jpeg', 'image/jpg', 'image/gif', 'image/png');


                    if (($file_size > 2097152)) {
                        $message = 'File too large. File must be less than 2MB.';
                        Yii::app()->user->setFlash('type', 'danger');
                        Yii::app()->user->setFlash('message', $message);
                        $this->redirect(Yii::app()->request->baseUrl . '/configuration');
                    } elseif (!in_array($file_type, $acceptable)) {
                        $message = 'Invalid file type. Only JPG, GIF and PNG types are accepted.';
                        Yii::app()->user->setFlash('type', 'danger');
                        Yii::app()->user->setFlash('message', $message);
                        $this->redirect(Yii::app()->request->baseUrl . '/configuration');
                    }

                    move_uploaded_file($_FILES['Configuration']['tmp_name']['company_logo'], $filename);
                }
            }
            Yii::app()->user->setFlash('type', 'success');
            Yii::app()->user->setFlash('message', 'System Settings updated successfully.');
            $this->redirect(Yii::app()->request->baseUrl . '/configuration');
        }
        $model = $model->findAll();
        $this->render('view', array('model' => $model));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin() {
        $model = new Configuration('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Configuration']))
            $model->attributes = $_GET['Configuration'];

        $this->render('admin', array(
            'model' => $model,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return Configuration the loaded model
     * @throws CHttpException
     */
    public function loadModel($id) {
        $model = Configuration::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param Configuration $model the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'configuration-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}
