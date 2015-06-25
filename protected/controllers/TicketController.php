<?php

class TicketController extends Controller {
    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */

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
        $id = base64_decode($id);
        $this->render('view', array(
            'model' => $this->loadModel($id),
            'ticket_id' => $id,
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

        if (isset($_POST['Ticket'])) {
            $model->attributes = $_POST['Ticket'];
            if ($model->update())
                $this->redirect(array('view', 'id' => $model->ticket_id));
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
        $this->loadModel($id)->delete();

// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
        if (!isset($_GET['ajax']))
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
    }

    /**
     * Lists all models.
     */

    /**
     * Manages all models.
     */
    public function actionIndex() {
        
        if(Yii::app()->session['user_data']['user_role_type']==5){
            $_GET['clientsTicket'] =  base64_encode(Yii::app()->session['user_data']['user_id']);  
            
         
        }
        $model = new Ticket('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Ticket'])) {
            $model->attributes = $_GET['Ticket'];
        }

        $this->render('index', array(
            'model' => $model,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return Ticket the loaded model
     * @throws CHttpException
     */
    public function loadModel($id) {
        $model = Ticket::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param Ticket $model the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'ticket-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    public function actionassignUsers() {
        $model = new TicketAssign;
        $model_log = new TicketAssignLog;

        $assigneeList = $_POST['assigneeusers'];
        $ticket_id = $_POST['ticket_id'];

        $tmodel = $this->loadModel($ticket_id);
        $tmodel->ticket_status = 2;
        $tmodel->update();
        $model->ticket_id = $ticket_id;
        $model->fwd_by = Yii::app()->session['user_data']['user_id'];
        $model_log->ticket_id = $ticket_id;
        $model_log->fwd_by = Yii::app()->session['user_data']['user_id'];


        foreach ($assigneeList as $userId) {
            $model->fwd_to = $userId;
            $model->user_role_type = Users::model()->getUserRoleType($userId);
            $model->setIsNewRecord(true);
            $model_log->setIsNewRecord(true);
            $model_log->fwd_to = $userId;
            $result = TicketAssign::model()->findByAttributes(array("ticket_id" => $ticket_id, "fwd_to" => $userId));
            if (count($result) == 0) {
                $model->insert();
                $model->id = $model->id + 1;
            } else {
                $result->fwd_by = $model->fwd_by;
                $result->user_role_type = Users::model()->getUserRoleType($userId);
                $result->status = 1;
                $result->updated_date = Date("Y-m-d H:i:s");
                $model_log->status = 1;
                $result->update();
            }
            $model_log->insert();
            $model_log->id = $model_log->id + 1;
        }
        $userAssignee = Users::model()->getUserAssigneeList($ticket_id);
        $clientAssignee = Users::model()->getClientAssigneeList($ticket_id);
        echo json_encode(array("userAssignee" => $userAssignee, "clientAssignee" => $clientAssignee));
    }

    public function actionRemoveUser() {

        $ticket_id = $_POST['ticket_id'];
        $user_id = $_POST['user_id'];
        $model_log = new TicketAssignLog;
        $model_log->ticket_id = $ticket_id;
        $model_log->fwd_by = Yii::app()->session['user_data']['user_id'];
        $model_log->fwd_to = $user_id;
        $model_log->status = 0;
        $model_log->insert();
        $assigneeList = TicketAssign::model()->findByAttributes(array("ticket_id" => $ticket_id, "fwd_to" => $user_id));
        $assigneeList->status = 0;
        $assigneeList->updated_date = Date("Y-m-d H:i:s");
        $assigneeList->update();
        $userAssignee = Users::model()->getUserAssigneeList($ticket_id);
        $clientAssignee = Users::model()->getClientAssigneeList($ticket_id);
        echo json_encode(array("userAssignee" => $userAssignee, "clientAssignee" => $clientAssignee));
    }

    public function actionAddComments() {
        $model = new TicketThread();
        $files = array();
        $names = array();
        $ticket_id = $_POST['ticket_id'];
        $comment = $_POST['comment'];
        $user_id = Yii::app()->session['user_data']['user_id'];
        $model->ticket_id = $ticket_id;
        $model->user_id = $user_id;
        $model->descriptions = $comment;
        if (isset($_FILES['cstfile'])) {
            $files = $_FILES['cstfile'];
            for ($i = 0; $i < count($files['name']); $i++) {
                $random_name = rand(1111, 9999) . date('Ymdhis');
                $extension = strtolower(pathinfo($files['name'][$i], PATHINFO_EXTENSION));
                $filename = "{$random_name}.{$extension}";
                $names[] = $filename;
                Utils::getAttachmentpath() . $filename;
                move_uploaded_file($_FILES['cstfile']['tmp_name'][$i], Utils::getAttachmentpath() . $filename);
            }
        }

        $model->attachments = serialize($names);
        $model->save();
        return 1;
    }

    public function actionGetComments() {
        $ticket_id = $_POST['ticket_id'];
        $last_comment_id = $_POST['last_comment_id'];
        if (empty($last_comment_id)) {
            $last_comment_id = 0;
        }

        $commentsList = TicketThread::model()->findAllByAttributes(array("ticket_id" => $ticket_id, "status" => 1), array(
            'condition' => 'thread_id >:thread_id',
            'params' => array('thread_id' => $last_comment_id)
        ));

        $result = array();
        foreach ($commentsList as $internal_comment) {
            $files = unserialize($internal_comment['attachments']);
            if (!empty($files)) {
                $doclink = '<a href="' . Yii::app()->createAbsoluteUrl('ticket/createZip/' . base64_encode($internal_comment['thread_id'])) . '"><i class="fa fa-file"></i> Attachments #' . count($files) . '</a>';
            } else {
                $doclink = 'No Attachments';
            }
            $result[] = array(
                'id' => $internal_comment['thread_id'],
                'username' => Users::model()->getUserName($internal_comment['user_id']),
                'message' => $internal_comment['descriptions'],
                'datetime' => date('d M Y @ g:i A', strtotime($internal_comment['created_date'])),
                'attachment_link' => $doclink
            );
        }

        echo json_encode($result);
    }

    public function actiondownloadZip() {
        $order_id = base64_decode($_GET['id']);
        $data = Orders::model()->findByPk($order_id);
        $attrList = json_decode($data['order_Data']);        
        $clientInfo= $attrList->userdata; 
        $files = $clientInfo->userFile; 
        $path = Utils::getDownloadpath();
        $fileArr = array();
        foreach ($files as $file) {
            $file =  explode("/", $file);        
            $file=$file[count($file)-1];
            $fileArr[] = $path . $file;
        }        
        $zip = new ZipArchive();
        $zipName = "userfile_" . date("Y-m-d-H-i-s") . ".zip";
        $fizip = $path . $zipName;
        if ($zip->open($fizip, ZipArchive::CREATE) === TRUE) {
            foreach ($fileArr as $fl) {
                if (file_exists($fl)) {
                    $zip->addFile($fl, basename($fl)) or die("<p class='warning'>ERROR: Could not add file: " . $fl . "</p>");
                }
            }
        }

        $resultArr = array();
        $resultArr[] = $zip;
        $zip = $resultArr[0];       
        $size = filesize($zip->filename);
        if ($zip->filename) {
            $zip->close();
            header("Content-Description: File Transfer");
            header("Content-type: application/zip");
            header("Content-Disposition: attachment; filename=\"" . $zipName . "\"");
            header("Content-Transfer-Encoding: binary");
            ob_end_flush();
            flush();
            readfile("$path{$zipName}");
            unlink("$path{$zipName}");
        }
    }
    
     public function actionCreateZip() {
        $thread_id = base64_decode($_GET['id']);
        $data = TicketThread::model()->findByPk($thread_id);
        $files = unserialize($data->attachments);
        $path = Utils::getAttachmentpath();
        $fileArr = array();
        foreach ($files as $file) {
            $fileArr[] = $path . $file;
        }

        $zip = new ZipArchive();
        $zipName = "comment_" . date("Y-m-d-H-i-s") . ".zip";
        $fizip = $path . $zipName;
        if ($zip->open($fizip, ZipArchive::CREATE) === TRUE) {
            foreach ($fileArr as $fl) {
                if (file_exists($fl)) {
                    $zip->addFile($fl, basename($fl)) or die("<p class='warning'>ERROR: Could not add file: " . $fl . "</p>");
                }
            }
        }

        $resultArr = array();
        $resultArr[] = $zip;
        $zip = $resultArr[0];
        $size = filesize($zip->filename);
        if ($zip->filename) {
            $zip->close();
            header("Content-Description: File Transfer");
            header("Content-type: application/zip");
            header("Content-Disposition: attachment; filename=\"" . $zipName . "\"");
            header("Content-Transfer-Encoding: binary");
            ob_end_flush();
            flush();
            readfile("$path{$zipName}");
            unlink("$path{$zipName}");
        }
    }

    function actionChangeStatus() {
        $new = array();
        $TicketChangeLog = new TicketChangeLog();
        $ticket_id = $_POST['ticket_id'];
        $status_id = $_POST['status_id'];
        $remark = $_POST['remark'];
        $model = $this->loadModel($ticket_id);
        $new = array("ticket_id" => $ticket_id, "status_id" => $status_id, "remark" => $remark, "user_id" => Yii::app()->session['user_data']['user_id']);
        $TicketChangeLog->attributes = $new;
        $model->ticket_status = $status_id;
        $model->updated_date = Date("Y-m-d H:i:s");

        $result = array();

        if ($model->update()) {
            $TicketChangeLog->save();
            $result = array('flag' > 1);
        }

        echo json_encode($result);
    }

    public function actionGetRemarlList($id, $num, $flag = 0) {

        $result = array();
        $results = TicketChangeLog::model()->getRemarkList($id, $num);
        foreach ($results as $r) {
            $result[] = array(
                "id" => $r['id'],
                "status_name" => TicketStatus::model()->getStatusName($r['status_id']),
                "remark" => $r['remark'],
                "user_name" => Users::model()->getUserName($r['user_id']),
                'created_date' => date('d M Y @ g:i A', strtotime($r['created_date']))
            );
        }

        if ($flag == 0) {
            echo json_encode($result);
        } else {
            return $result;
        }
    }

    public function actionGetStatusName() {
        $ticket_id = $_POST['ticket_id'];
        $ticketInfo = Ticket::model()->findbypk($ticket_id);
        $ticketInfo = TicketStatus::model()->findByPk($ticketInfo->ticket_status);
        echo json_encode(array('name' => $ticketInfo->status_name, 'color' => $ticketInfo->color));
    }

    public function actionTicketStatusName() {
        $ts = $_POST['ticket_status'];
        $statusName = 'All Tickets';
        if ($ts) {
            $statusName = TicketStatus::model()->getStatusName($ts);
        }
        echo $statusName;
    }

    public function actionGetOrderlList() {

        $data = $_REQUEST;
        $result = array();
        $newResult = array();
        if (!empty($data)) {
            $limit = 20;
            $page = $data['page'];
            $offset = ($page - 1) * $limit;
            $user_id = $data['Client'];
            $category = $data['category'];
            $status = $data['order_status'];
            $start_date = $data['start_date'];
            $end_date = $data['end_date'];
            $condition = "";
            if (!empty($start_date)) {
                $condition = "created_date >= '$start_date' AND created_date <= '$end_date 23:59:59'";
            }
            if (!empty($category)) {
                if (!empty($condition)) {
                    $condition .= " AND ";
                }
                $condition .=" ticket_title = '" . $category . "'";
            }

            if (!in_array(Yii::app()->session['user_data']['user_role_type'], array(0, 1, 2))) {
                $ticketList = TicketAssign::model()->getTicketbyUser(Yii::app()->session['user_data']['user_id']);
                $ticket_ids = array();
                foreach ($ticketList as $ticket) {
                    $ticket_ids[] = $ticket['ticket_id'];
                }
                if (!empty($ticket_ids)) {
                    if (!empty($condition)) {
                        $condition .= " AND ";
                    }
                    $ticket_ids = implode($ticket_ids, ",");
                    $condition .= 'ticket_id in ('. $ticket_ids.')';
                } else {
                    if (!empty($condition)) {
                        $condition .= " AND ";
                    }
                    $condition .= 'ticket_id i=0';
                }

                if (!empty($condition)) {
                    $condition .= " AND ";
                }
                $condition .="ticket_status != 1 ";
            }
           // echo $condition;die; 
            $orderTotal = count(Ticket::model()->findAllByAttributes(array(), array("condition" => $condition)));
            $orderList = Ticket::model()->findAllByAttributes(array(), array("condition" => $condition, 'limit' => $limit, "offset" => $offset)
            );

            $count = 0;
            foreach ($orderList as $val) {

                if (!empty($user_id)) {
                    $orderDetails = Orders::model()->findByAttributes(array("order_id" => $val['order_id'], "client_id" => $user_id));
                } else {
                    $orderDetails = Orders::model()->findByAttributes(array("order_id" => $val['order_id']));
                }
                $paymentD = json_decode($orderDetails['order_payment']);
                if (!empty($orderDetails)) {
                    if (!empty($status)) {
                        if ($paymentD->payment_status == $status) {
                            $result[] = array(
                                "order_id" => $orderDetails['order_id'],
                                "url" => Yii::app()->createUrl("ticket/view", array("id" => base64_encode($val['ticket_id']))),
                                "client" => Users::model()->getUserName($orderDetails['client_id']),
                                "amount" => $orderDetails['order_total'],
                                "category" => $val['ticket_title'],
                                "status" => $paymentD->payment_status,
                                'date' => date('d M Y @ g:i A', strtotime($val['created_date']))
                            );
                        } else {
                            $count++;
                        }
                    } else {
                        $result[] = array(
                            "order_id" => $orderDetails['order_id'],
                            "url" => Yii::app()->createUrl("ticket/view", array("id" => base64_encode($val['ticket_id']))),
                            "client" => Users::model()->getUserName($orderDetails['client_id']),
                            "amount" => $orderDetails['order_total'],
                            "category" => $val['ticket_title'],
                            "status" => $paymentD->payment_status,
                            'date' => date('d M Y @ g:i A', strtotime($val['created_date']))
                        );
                    }
                } else {
                    $count++;
                }
            }
            if (!empty($orderList) && !empty($result)) {
                $newResult['pagination'] = $this->actionCreatePager($orderTotal - $count, $limit, $page);
                $newResult['records'] = $result;
            }
        }

        echo json_encode($newResult);
    }

    public function actionCreatePager($total, $noLink, $page) {
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
