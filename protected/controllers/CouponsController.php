<?php

class CouponsController extends Controller {
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
                'admin' => array(Yii::app()->user->name),
            ),
            array('allow', // allow authenticated users to access all actions
                'staff' => array(Yii::app()->user->name),
            ),
            array('allow', // allow authenticated users to access all actions
                'user' => array(Yii::app()->user->name),
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
        $model = new Coupons;

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['Coupons'])) {
            $model->attributes = $_POST['Coupons'];

            if ($model->save()) {
                Yii::app()->user->setFlash('type', 'success');
                Yii::app()->user->setFlash('message', 'Coupon added successfully.');
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

        $this->performAjaxValidation($model);

        if (isset($_POST['Coupons'])) {
            $model->attributes = $_POST['Coupons'];
            $model->updated_date = Date("Y-m-d H:i:s");

            if ($model->update()) {
                Yii::app()->user->setFlash('type', 'success');
                Yii::app()->user->setFlash('message', 'Coupon updated successfully.');
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
        // $this->loadModel($id)->delete();
        // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
        if (!isset($_GET['ajax']))
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
    }

    public function actionIndex() {
        $model = new Coupons('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Coupons']))
            $model->attributes = $_GET['Coupons'];

        $this->render('index', array(
            'model' => $model,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return Coupons the loaded model
     * @throws CHttpException
     */
    public function loadModel($id) {
        $model = Coupons::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param Coupons $model the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'coupons-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    public function actionGetOrderlList() {

        $data = $_REQUEST['Coupons'];
        $result = array();
        $newResult = array();
        if (!empty($data['coupon_code'])) {
            $limit = 20;
            $page = $data['page'];
            $offset = ($page - 1) * $limit;
            $result = array();
            $coupon_code = trim($data['coupon_code']);
            // $coupon_type = $data['coupon_type'];
            $validate_from = $data['validate_from'];
            $validate_to = $data['validate_to'];
            $Couponid = Coupons::model()->findByAttributes(array("coupon_code" => $coupon_code, "status" => 1));
           
            if (!empty($Couponid['id'])) {
                if (!empty($validate_from)) {
                    $orderTotal = count(Orders::model()->findAllByAttributes(array("coupon_id" => $Couponid['id']), array("condition" => "order_date >= '$validate_from' AND order_date <= '$validate_to 23:59:59'")));
                    $orderList = Orders::model()->findAllByAttributes(array("coupon_id" => $Couponid['id']), array("condition" => "order_date >= '$validate_from' AND order_date <= '$validate_to 23:59:59'", 'limit' => $limit, "offset" => $offset));
                } else {
                    $orderTotal = count(Orders::model()->findAllByAttributes(array("coupon_id" => $Couponid['id'])));
                    $orderList = Orders::model()->findAllByAttributes(array("coupon_id" => $Couponid['id']), array('limit' => $limit, "offset" => $offset));
                }
            }
            foreach ($orderList as $val) {
                $ticketid = Ticket::model()->findByAttributes(array("order_id" => $val['order_id']));
                $result[] = array(
                    "order_id" => $val['order_id'],
                    "url" => Yii::app()->createUrl("ticket/view", array("id" => base64_encode($ticketid['ticket_id']))),
                    "client" => Users::model()->getUserName($val['client_id']),
                    "amount" => $val['order_total'],
                    "product_name" => $ticketid['ticket_title'],
                    'date' => date('d M Y @ g:i A', strtotime($val['order_date']))
                );
            }
            if (!empty($orderList)) {
                $newResult['pagination'] = $this->actionCreatePager($orderTotal, $limit, $page);
                $newResult['records'] = $result;
            }
        }

        echo json_encode($newResult);
    }

    public
            function actionCreatePager($total, $noLink, $page) {
        $pages = new CPagination($total);
        $pages->setPageSize($noLink);
        $pages->setCurrentPage($page - 1);
        ob_start();
        $this->widget('CLinkPager', array(
            'header' => '',
            'firstPageLabel' => ' First &lt;&lt;',
            'prevPageLabel' => '&lt; Previous',
            'nextPageLabel' => 'Next &gt;',
            'lastPageLabel' => ' Last &lt;&lt;',
            'pages' => $pages,
            'htmlOptions' => array(
                'class' => 'pagination'
            )
        ));
        $str = ob_get_clean();
        return $str;
    }

}
