<?php

/**
 * Admin Ajax class.
 */
class Admin_ajax extends CFormModel {

    public function delete_data($id, $operation_on) {
        if ($id != "") {
            $table = "" . $operation_on;
            $feild_prefix = $operation_on;
            $log_model = new Admin_ajax;
            if ($_POST["operation_on"] == "department") {
                $log_model->addLog("DELETE", "su_user", $id, "Performed Delete Operation");
                $delete_data = Yii::app()->db->createCommand('Delete FROM su_user WHERE user_departmentID = "' . $id . '" ')->execute();
            }

            if ($_POST["operation_on"] == "user") {
                $delete_data_fromschedule = Yii::app()->db->createCommand('Delete FROM su_dept_head_schedule WHERE head = "' . $id . '" ')->execute();
            }
            $log_model->addLog("DELETE", $operation_on, $id, "Performed Delete Operation");

            return Yii::app()->db->createCommand('Delete FROM ' . $table . ' WHERE ' . $feild_prefix . '_id = "' . $id . '" ')->execute();
        } else {

            return false;
        }
    }

    /* check user exist in this department */

    public function check_user_department($id, $operation_on) {
        if ($id != '') {
            $connection = Yii::app()->db;
            $data = $connection->createCommand("select user_id from su_user where user_departmentID = " . $id)->queryRow();
            return $data;
        }
    }
     public function closeinfo($ticket_id) {
        if ($ticket_id != '') {
            $res = Yii::app()->db->createCommand()
                ->select('ct.closed_at,(u.user_fname ||  " " || u.user_lname) as closename')
                ->from('su_customer_ticket ct') 
                ->leftjoin('su_user u', 'ct.closed_by=u.user_id')               
                ->limit(1)            
                ->where('ct.customer_ticket_id = ' . $ticket_id);

        $result = $res->queryAll();
        return $result;
        }
    }
    public function updateinfo($ticket_id) {
        if ($ticket_id != '') {
            $sql = "SELECT ui.updated_at ,ui.update_info ,(SELECT (user_fname ||' '|| user_lname) FROM `su_user` u where u.user_id=ui.updated_by) as updated_by  FROM `su_update_info` ui WHERE ui.ticket_id=" . $ticket_id . " order by updated_at desc  limit 1 "; 
            
             $update_info = $this->executeQuery($sql);
               $updateinfo="";
              
             if(!empty($update_info)){
           
             $updateinfo .="<ul><li> Update info:".$update_info[0]['update_info']."</li>" ;
             $updateinfo .="<li> Update by:".$update_info[0]['updated_by']."</li>" ;
             $updateinfo .="<li> Update at:".$update_info[0]['updated_at']."</li></ul>" ;
             }
            
        $this->close_info($ticket_id);
        return $updateinfo;
        }
    }
    public function close_info($ticket_id) {
        if ($ticket_id != '') {
            $res = Yii::app()->db->createCommand()
                ->select('ct.close_reason, ct.closed_at,(u.user_fname ||  " " || u.user_lname) as closename')
                ->from('su_customer_ticket ct') 
                ->leftjoin('su_user u', 'ct.closed_by=u.user_id')               
                ->limit(1)            
                ->where('ct.customer_ticket_id = ' . $ticket_id);

        $result = $res->queryAll();
       
               $close_info="";
             if(!empty($result)){
           
             $close_info .="<ul><li> Closed reason:".$result[0]['close_reason']."</li>" ;
             $close_info .="<li> Closed by:".$result[0]['closename']."</li>" ;
             $close_info .="<li> Closed at:".$result[0]['closed_at']."</li></ul>" ;
             }
            
       
        return $close_info;
        }
    }
    public function check_user_name($user_fname ,$user_lname) {
        if ($user_fname != '' &&  $user_lname!="") {
            $user_fname= strtolower($user_fname) ;
            $user_lname= strtolower($user_lname) ;
            $connection = Yii::app()->db;
            $data = $connection->createCommand("select user_id from su_user where LOWER(user_fname) ='".$user_fname."' and LOWER(user_lname)='".$user_lname. "'" )->queryRow();
            return $data['user_id'];
        }
    }
     public function check_user_email($email) {
        if ($email != '') {
            $connection = Yii::app()->db;
            $data = $connection->createCommand("select user_id from su_user where user_email ='".$email."'" )->queryRow();
            return $data['user_id'];
        }
    }
   public function get_lastforwer($id) {
      
      $res = Yii::app()->db->createCommand()
                ->select('ts as fwd_at,(u.user_fname ||  " " || u.user_lname) as fwdbyname')
                ->from('su_fwd_tickets ft') 
                ->leftjoin('su_user u', 'ft.fwd_by=u.user_id')
                ->order('ts DESC')
                ->limit(1)            
                ->where('ft.ticket_id = ' . $id);

        $result = $res->queryAll();
        return $result;
       
    } public function get_reply($t_id) {
      
      $res = Yii::app()->db->createCommand()
                ->select('sr.*,(u.user_fname ||  " " || u.user_lname) as sendername')
                ->from('su_reply sr') 
                ->leftjoin('su_user u', 'sr.sender_id=u.user_id')
                ->order('sr.reply_id ASC')                      
                ->where('sr.ticket_id = ' . $t_id);

         $result = $res->queryAll();
         $Content="";
        foreach ($result as $key => $value) {
          
                 $Content.="<li><b>".$value['sendername']."</b> : ".$value['description']; 
           if(Yii::app()->session['user_data']['user_id']==$value['sender_id']){
                $Content.="<a class='remove_reply' title='Remove' style='display:none' data='".$value['reply_id']."' href='javascript:void(0)'> <i class='fa fa-minus pull-right'></i></a>";
           }
                $$Content .="</li>"; 
         }
        if(!empty($Content)){
         $Content = "<ul>".$Content."</ul>";  
        }
        return $Content ;
       
    } 
  
    public function sendTicketEmail($uid) {
        
    }

    public function delete_records($table, $for, $ids) {
        if ($table == "su_department") {
            Yii::app()->db->createCommand('DELETE FROM su_user WHERE  user_departmentID=' . $ids)->execute();
            Yii::app()->db->createCommand('DELETE FROM su_dept_head_schedule WHERE  department_id=' . $ids)->execute();
        }
        return Yii::app()->db->createCommand('DELETE FROM ' . $table . '  WHERE  ' . $for . '  IN  (' . $ids . ')')->execute();
    }

    public function getCountryCodeById($id) {
        $connection = Yii::app()->db;
        $data = $connection->createCommand("select country_code from su_country where country_id=" . $id)->queryRow();
        return $data['country_code'];
    }

    public function addLog($operation, $operation_on, $id, $msg) {

        if (!file_exists('logs/' . date("Y"))) {
            if (!mkdir('./logs/' . date("Y"), 0777, true)) {
                return false;
            }
        }

        if (!file_exists('logs/' . date("Y") . '/' . date("m"))) {
            if (!mkdir('./logs/' . date("Y") . '/' . date("m"), 0777, true)) {
                return false;
            }
        }

        $my_file = 'logs/' . date("Y") . '/' . date("m") . '/' . date("d-m-Y") . '.txt';
        $handle = fopen($my_file, 'a') or die('Cannot open file:  ' . $my_file);
        $data = '##Performed Operation : ' . $operation . '; ##Performed On :' . $operation_on . '; ##Performed to ID:' . $id . '; ##Performed By UID:' . Yii::app()->session['user_data']['user_id'] . '; ##Message :' . $msg . '; ##Performed At :' . date('d-m-Y H:i:s') . "; ##Accessed From :" . $_SERVER['REMOTE_ADDR'] . "; \n\n --------------------------------" . date('d-m-Y H:i:s') . "---------------------------------\n\n\n";
        fwrite($handle, $data);
        fclose($handle);
    }

    public function deleteEntity($id, $operation_on) {
        if ($id != "") {
            $table = "su_" . $operation_on;

            $delete_status = Yii::app()->db->createCommand('Delete FROM  `' . $table . '`  WHERE  id = "' . $id . '" ')->execute();
            $log_model = new Admin_ajax;
            $log_model->addLog("DELETE", $operation_on, $id, "Performed Delete Operation");
            if ($delete_status) {
                return true;
            } else {
                return false;
            }
        } else {

            return false;
        }
    }

    public function change_status($id, $operation_on, $status) {
        if ($id != "") {
            $table = "su_" . $operation_on;
            $feild_prefix = $operation_on;
            $update_status = Yii::app()->db->createCommand('UPDATE ' . $table . ' set ' . $feild_prefix . '_status = "' . $status . '"  WHERE ' . $feild_prefix . '_id = "' . $id . '" ')->execute();
            $log_model = new Admin_ajax;
            $log_model->addLog("UPDATE", $operation_on, $id, "Performed UPDATE Operation");
            if ($update_status) {
                return true;
            } else {
                return false;
            }
        } else {

            return false;
        }
    }

    public function insert_data($table, $data, $cond = "") {
        $fields = $fields_value = "";
        foreach ($data as $key => $value) {
            $fields .= "`" . $key . "`,";
            $value2 = str_replace("'", '"', $value);
            $fields_value .= "'" . $value2 . "',";
        }

        $fields = trim($fields, ",");
        $fields_value = trim($fields_value, ",");

        if ($fields != "" && $fields_value != "") {
            $insert_status = Yii::app()->db->createCommand('INSERT INTO ' . $table . '( ' . $fields . ' ) VALUES( ' . $fields_value . ' ) ')->execute();

            $log_model = new Admin_ajax;
            $log_model->addLog("INSERT", $table, $insert_status, "Performed INSERT Operation");
            if ($insert_status) {
                return Yii::app()->db->lastInsertID;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    public function forwardTicket() {
       $data = Yii::app()->db->createCommand("select * from `su_customer_ticket` where customer_ticket_id=" . $_POST["ticketid"])->queryRow();
        $value_rason = str_replace('"', "'", $_POST["fwd_region"]);
        //echo 'INSERT INTO `su_fwd_tickets` ( ticket_id,ticket_fwd_region,fwd_by,fwd_to,assign_to,assign_to_dept,assign_from_dept,ticket_status ) VALUES(' . $_POST["ticketid"] . ',"' . $value_rason . '" ,' . Yii::app()->session['user_data']['user_id'] . ',' . $_POST["userid"] . ',' . $data['ticket_assign_to'] . ',' . $_POST["dept_id"] . ',' . $data['department_id'] . ', ' . $data['customer_ticket_status'] . ' ) ';
        //die;
        $ticket_assign_to = $data['ticket_assign_to'];
        if($data['ticket_assign_to'] == ""){
            $ticket_assign_to = 0;
        }
        $fwd_id = Yii::app()->db->createCommand('INSERT INTO `su_fwd_tickets` ( ticket_id,ticket_fwd_region,fwd_by,fwd_to,assign_to,assign_to_dept,assign_from_dept,ticket_status ) VALUES(' . $_POST["ticketid"] . ',"' . $value_rason . '" ,' . Yii::app()->session['user_data']['user_id'] . ',' . $_POST["userid"] . ',' . $_POST["userid"] . ',' . $_POST["dept_id"] . ',' . $data['department_id'] . ', ' . $data['customer_ticket_status'] . ' ) ')->execute();
        $log_model = new Admin_ajax;
        $log_model->addLog("INSERT", 'su_fwd_tickets', $fwd_id, "Insert into su_fwd_tickets");
        $sql = "Update `su_customer_ticket` set department_id=" . $_POST["dept_id"] . " ,ticket_assign_to='" . $_POST["userid"] . "' , notifyFlag=1 , notifySms=0 where customer_ticket_id='" . $_POST["ticketid"] . "'";
        $log_model->addLog("Update", 'su_customer_ticket', $_POST["ticketid"], "Performed Update Operation");
        return Yii::app()->db->createCommand($sql)->execute();
    }

    public function forwardTicketViaMail($ticketid, $dept_id, $reason, $frwd_user) {
        $data = Yii::app()->db->createCommand("select * from `su_customer_ticket` where customer_ticket_id=" . $ticketid)->queryRow();
        $fwd_id = Yii::app()->db->createCommand('INSERT INTO `su_fwd_tickets` ( ticket_id,ticket_fwd_region,fwd_by,fwd_to,assign_to,assign_to_dept,assign_from_dept,ticket_status ) VALUES(' . $ticketid . ',"' . $reason . '" ,' . $data['ticket_assign_to'] . ',' . $frwd_user . ',' . $data['ticket_assign_to'] . ',' . $dept_id . ',' . $data['department_id'] . ', ' . $data['customer_ticket_status'] . ' ) ')->execute();
        $log_model = new Admin_ajax;
        $log_model->addLog("INSERT", 'su_fwd_tickets', $fwd_id, "Insert into su_fwd_tickets");
        $sql = "Update `su_customer_ticket` set department_id=" . $dept_id . " ,ticket_assign_to='" . $frwd_user . "' , notifyFlag=1 , notifySms=0 where customer_ticket_id='" . $ticketid . "'";
        $log_model->addLog("Update", 'su_customer_ticket', $ticketid, "Performed Update Operation");
        return Yii::app()->db->createCommand($sql)->execute();
    }

    public function customOneRowQuery($sql) {
        return Yii::app()->db->createCommand($sql)->queryRow();
    }

    public function customUpdateQuery($sql) {
        return Yii::app()->db->createCommand($sql)->execute();
    }

    public function removeTicketAttechmentFile($file) {
        $sql = "delete from  `su_attachement`  where file_name='" . $file . "'";
        $log_model = new Admin_ajax;
        $log_model->addLog("Update", 'su_customer_ticket', $file, "Performed Update Operation");
        return Yii::app()->db->createCommand($sql)->execute();
    }
    public function removeuserFile($file, $user_id) {
        $sql = "update   `su_user`  set user_avatar='' where   user_avatar='".$file."' and  user_id='" . $user_id . "'";
        $log_model = new Admin_ajax;
        $log_model->addLog("Update", 'su_user', $file, "Performed Update Operation");
        return Yii::app()->db->createCommand($sql)->execute();
    }

    public function updateTicket($ticket_num, $status, $reason) {
        $status_id = Yii::app()->db->createCommand("Select ticket_status_id from su_ticket_status where ticket_status_name='" . $status . "'")->queryRow();
        $sql = "Update `su_customer_ticket` set close_reason ='" . $reason . "'  ,customer_ticket_status='" . $status_id['ticket_status_id'] . "' where customer_ticket_id='" . $ticket_num . "'";
        $log_model = new Admin_ajax;
        $log_model->addLog("Update", 'su_customer_ticket', $sql, "Performed Update Operation");
        return Yii::app()->db->createCommand($sql)->execute();
    }

    /*
     * update_data : methode for updating the data
     * @param : $table = table name , $data = data to be updated ,$id_name= field name of id , $id = id of the recored to be update
     * @return : boolian
     *
     */

    public function update_data($table, $data, $id_name, $id) {
        $update = "set ";
        $i = 0;
        foreach ($data as $key => $value) {
            if ($i) {
                $value2 = str_replace("'", '"', $value);
                $update.=" ,`" . $key . "` = '" . $value2 . "' ";
            } else {
                $value2 = str_replace("'", '"', $value);
                $update.=" `" . $key . "` = '" . $value2 . "' ";
            }
            $i++;
        }

        if ($update != "" && $id_name != "" && $id != "") {

            $sql = 'UPDATE ' . $table . ' ' . $update . '  WHERE ' . $id_name . ' = "' . $id . '" ';

            $log_model = new Admin_ajax;
            $log_model->addLog("Update", $table, $id, "Performed UPDATE Operation");

            $update_status = Yii::app()->db->createCommand($sql)->execute();


            return true;
        } else {
            return false;
        }
    }

    public function getAcronymsByDepartmentId($id) {
        $sqlx = "select department_acronym from `su_department` where department_id=" . $id;
        $connection = Yii::app()->db;
        $data = $connection->createCommand($sqlx)->queryRow();
        $Acronyms = $data['department_acronym'];

        return $Acronyms;
    }

    public function getHodByDepartmentId($deptId) {
        $sqlx = "select head from `su_dept_head_schedule` where department_id=" . $deptId . " and   " . date("N") . " >=day_from and " . date("N") . " <=day_to  and " . date("H") . " >=time_from and " . date("H") . " <=time_to ORDER BY RAND() limit 0,1";
        $connection = Yii::app()->db;
        $data = $connection->createCommand($sqlx)->queryRow();
        if ($data) {
            $hodId = $data['head'];
        } else {

            /* if hod not available in schedule */
            $sql = "select head from `su_dept_head_schedule` where department_id=" . $deptId . " ORDER BY RAND() limit 0,1";
            $connection = Yii::app()->db;
            $data = $connection->createCommand($sql)->queryRow();

            if ($data) {
                $hodId = $data['head'];
            } else {
                $hodId = '';
            }

            /*
              $sql = "select user_id from su_user where user_accountTypeID=" . $deptId . " ORDER BY RAND() limit 0,1";
              $data = $connection->createCommand($sql)->queryRow();
              $hodId = $data['user_id']; */
        }
        return $hodId;
    }

    public function getDepartmentId($deptName) {
        $sql = "select department_id from `su_department` where department_name='" . $deptName . "'";
        $connection = Yii::app()->db;
        $data = $connection->createCommand($sql)->queryRow();
        if ($data) {
            $hodId = $data['department_id'];
        } else {
            $hodId = '';
        }
        return $hodId;
    }

    public function fetch_single_data($table, $select, $feild, $value) {
        if ($feild != "" && $value != "" && $table != "" && $select != "") {
            $connection = Yii::app()->db;
            $sql = 'SELECT ' . $select . ' FROM ' . $table . ' WHERE ' . $feild . ' ="' . $value . '"'; 

            $data = $connection->createCommand($sql)->queryRow();

            if ($data) {
                return $data;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    public function fetch_array($table, $field, $id) {
        if ($table != "" && $id != "") {
            $connection = Yii::app()->db;
            $sql = 'SELECT *  FROM ' . $table . ' WHERE ' . $field . ' = ' . $id;

            $data = $connection->createCommand($sql)->queryRow();
            if ($data) {
                return $data;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    public function get_records($table, $where) {
        if ($table != "" && $where != "") {
            $connection = Yii::app()->db;
            $sql = 'SELECT *  FROM ' . $table . ' WHERE ' . $where;



            $data = $connection->createCommand($sql)->queryAll();
            if ($data) {
                return $data;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    public function department_schedule($department_id, $user_id = "") {
        if ($department_id != "") {
            $connection = Yii::app()->db;
            if ($user_id == "") {
                $data = $connection->createCommand()->select('s.* , u.user_id, u.user_fname, u.user_lname,')->from('su_dept_head_schedule s')
                                ->leftjoin('su_user u', 's.head = u.user_id')
                                ->where('s.department_id=' . $department_id)->queryAll();
            } else {
                $data = $connection->createCommand()->select('s.* , u.user_id, u.user_fname, u.user_lname,')->from('su_dept_head_schedule s')
                                ->leftjoin('su_user u', 's.head = u.user_id')
                                ->where('s.department_id=' . $department_id . ' AND s.head!=' . $user_id)->queryAll();
            }
            if ($data) {
                return $data;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    public function reload_user($user_id) {
        $user = Yii::app()->db->createCommand('SELECT su_user.*, su_accountType.accountType_name, su_accountType.accountType_alias as user_type ,su_department.department_name FROM su_user
							      LEFT JOIN su_accountType ON su_accountType.accountType_id = su_user.user_accountTypeID
							      LEFT JOIN su_department ON su_department.department_id = su_user.user_departmentID
							      WHERE su_user.user_id = "' . $user_id . '"')->queryRow();

        if (is_array($user) && isset($user["user_id"])) {
            unset(Yii::app()->session['user_data']);
            Yii::app()->session['user_data'] = $user;
            return true;
        }
    }

    /*
     * user_schedule : METHOD FOR GETTING THE USER SCHEDULE
     * @param : USER_ID
     * @return : data if there is any data corrosponding to that user else false.
     *
     */

    public function user_schedule($user_id) {
        if ($user_id != "") {
            $connection = Yii::app()->db;
            $data = $connection->createCommand()
                    ->select('s.*')
                    ->from('su_dept_head_schedule s')
                    ->where('s.head=' . $user_id)
                    ->queryAll();
            if ($data) {
                return $data;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    /*
     * Fetch payway retailer
     */

    public function fetch_payway_retailer($term) {

        // Search retailers according to pattern
        $r = json_encode(array('pattern' => $term));

        // Search for retailers
        $ch = curl_init("https://admin.payway.ug/integration/retailer/search");

        // Due to HTTPS
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);

        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'Content-Length: ' . strlen($r),
            'X-Api-Key: Oc21K1TA5evcBQ7Evc3lZE0nF8x52t72'
        ));

        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $r);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        try {

            $p = curl_exec($ch);
            $status = curl_getinfo($ch, CURLINFO_HTTP_CODE);

            if ($status == 200) {
                $json_array = json_decode($p);
                //  echo "<pre>";print_r($json_array->retailers);die;
                foreach ($json_array->retailers as $retailerdata) {
                    $data[] = array(
                        'label' => $retailerdata->name
                    );
                }
                echo json_encode($data);
                flush();
            } else {
                $error = array("Error" => "Error accessing BioService");
                echo json_encode($error);
            }
        } catch (Exception $ex) {
            $error = array("Error" => $ex->getMessage());
            echo json_encode($error);
        }
    }

    /*
     * Send SMS
     */

    public function send_sms_via_gateway() {

        // Search retailers according to pattern
        $r = json_encode(array('via' => 'SMS',
            "to" => "+91865665656",
            "subject" => "Test subject",
            "message" => "Test message"));

        // Search for retailers
        $ch = curl_init("https://admin.payway.ug/integration/notification/send");

        // Due to HTTPS
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);

        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'Content-Length: ' . strlen($r),
            'X-Api-Key: Oc21K1TA5evcBQ7Evc3lZE0nF8x52t72'
        ));

        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $r);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        try {

            $p = curl_exec($ch);
            $status = curl_getinfo($ch, CURLINFO_HTTP_CODE);

            if ($status == 200) {
                $json_array = json_decode($p);
                echo "<pre>";
                print_r($json_array);
                die;
                foreach ($json_array->retailers as $retailerdata) {
                    $data[] = array(
                        'label' => $retailerdata->name
                    );
                }
                echo json_encode($data);
                flush();
            } else {
                $error = array("Error" => "Error accessing BioService");
                echo json_encode($error);
            }
        } catch (Exception $ex) {
            $error = array("Error" => $ex->getMessage());
            echo json_encode($error);
        }
    }

    public function user_view() {
        if ($_POST["id"]) {
            $data = Yii::app()->db->createCommand("SELECT  a.user_fname as 'First Name', a.user_lname as 'Last Name', a.user_email as Email,a.user_phoneNumber as 'Phone No',a.user_title as Title, b.accountType_name as 'Account type', c.department_name as Department, a.user_avatar as image
                                                  FROM su_user as a  LEFT JOIN su_accountType as b
                                                  ON b.accountType_id=a.user_accountTypeID
                                                  LEFT JOIN su_department as c
                                                  ON c.department_id = a.user_departmentID
                                                  where a.user_id= " . $_POST["id"])->queryRow();
            if ($data['image']) {
                $data['image'] = "<img src='" . Yii::app()->request->baseUrl . "/uploads/" . $data['image'] . "'  style='width:100px;' />";
            }
        }
        return json_encode($data);
    }

    public function get_template() {
        $res = Yii::app()->db->createCommand("SELECT a.template_title as 'Title', a.template_content as 'Content', b.template_category_name as 'Category Name'
                                             FROM su_template as a
                                             LEFT JOIN su_template_category as b
                                             ON b.template_category_id = a.template_category
                                             where template_id=" . $_POST["template_id"])->queryRow();
        return $res;
    }

    public function get_faq() {
        $res = Yii::app()->db->createCommand("SELECT a.faq_title as 'Title', a.faq_name as 'Description', b.faq_cat_name as 'Category Name',c.faq_subcat_name as 'Sub Category Name',a.faq_modifyDate as 'Creation Date'
                                             FROM su_faq as a
                                             LEFT JOIN su_faq_cat as b
                                             ON b.faq_cat_id = a.faq_cat_id
                                             LEFT JOIN su_faq_subcat as c 
                                             ON c.faq_subcat_id = a.faq_subcat_id
                                             where a.faq_id=" . $_POST["faq_id"])->queryRow();
        if ($res['Creation Date']) {
            $res['Creation Date'] = date("d.m.Y H:i:s", strtotime($res['Creation Date']));
        }

        return json_encode($res);
    }

    public function getImage($id) {
        $query='SELECT file_name FROM su_attachement  WHERE attached_id ='. $id;
        $res = Yii::app()->db->createCommand($query)->queryRow();      
        $ext = array("jpg", "jpeg", "JPEG", "gif", "png", "bmp");
        $filext = substr(strrchr($res['file_name'], '.'), 1);
        $data = array();
        if (in_array($filext, $ext)) {
            $data['image'] = "<img src='" . Yii::app()->request->baseUrl . "/uploads/" . $res['file_name'] . "'  style='width:960px;' />";
        } else {
            $data['image'] = "<div class='jumbotron'><h1>No Image available</h1></div>";
        }
        if (isset($res['file_name']) && !empty($res['file_name'])) {
            $data['download'] = "<a href='" . Yii::app()->request->baseUrl . "/uploads/" . $res['file_name'] . "' class='btn btn-default'>Download</a>";
        } else {
            $data['download'] = "";
        }
        return $data;
    }

    public function get_ticket() {
        $res = Yii::app()->db->createCommand('SELECT t.customer_name as "Customer Name" , ct.customer_type_name as "Customer Type" , t.customer_type_value as "Customer/Retailer Name" ,cc.call_category as "Call Category",t.reciept_value as "Reciept Value", t.candidate_key as "Candidate key",(x.user_fname ||  " " || x.user_lname) as "Assigned To",(u.user_fname ||  " " || u.user_lname) as "Created By",t.customer_contact as "Customer Contact",t.ticket_ts as "Creation Date",cd.department_name as "Department",sur.unknown_name_reason as "Unknown Reason", t.attachement as "image", t.customer_ticket_status as "status", t.close_reason as "Close Reason" 
                FROM su_customer_ticket t
                LEFT JOIN su_user u
		ON t.ticket_created_by=u.user_id
                LEFT JOIN su_user x 
		ON t.ticket_assign_to=x.user_id
                LEFT JOIN su_customer_type ct
		ON t.customer_type=ct.customer_type_id
                LEFT JOIN su_call_category cc
		ON t.call_category=cc.call_category_id
                LEFT JOIN su_department cd
		ON u.user_departmentID=cd.department_id
		LEFT JOIN su_unknown_name_reason as sur
		ON sur.unknown_name_reason_id = t.customer_unknown_name_reason
                WHERE t.customer_ticket_id =' . $_POST["ticket_id"])->queryRow();
         $admin_model = new Admin;
         $attachment = $admin_model->all_rows("su_attachement", "`file_name` ,`attached_id` ", "customer_ticket_id = ".$_POST['ticket_id']);
         $res['attachment']=$attachment;
        if ($res['status'] == 1) {
            $res['status'] = "Open";
        } elseif ($res['status'] == 2) {
            $res['status'] = "In Progress";
        } elseif ($res['status'] == 3) {
            $res['status'] = "Overdue";
        }
        if ($res['status'] == 4) {
            $res['status'] = "Closed";
        }
        if ($res['Creation Date']) {
            $res['Creation Date'] = date("d.m.Y H:i:s", strtotime($res['Creation Date']));
        }

        return json_encode($res);
    }

    public function get_ticket_naration() {
        $res = Yii::app()->db->createCommand('SELECT description_template_id,description,description_template_content FROM su_customer_ticket WHERE customer_ticket_id =' . $_POST["ticket_id"])->queryRow();
        $data = '';
        if ($res['description'] == 'new') {
            $data = $res['description_template_content'];
        } else {
            if (isset($res['description_template_id'])) {
                $res2 = Yii::app()->db->createCommand('SELECT template_content FROM su_template WHERE template_id =' . $res['description_template_id'])->queryRow();
                $data = $res2['template_content'];
            } else {
                $data = "";
            }
        }
        return $data;
    }

    public function fetch_ticketstatus($table, $value) {
        if ($value != "" && $table != "") {
            $connection = Yii::app()->db;
            $sql = 'SELECT ticket_status_name , color FROM ' . $table . ' WHERE ticket_status_id = ' . $value;

            //echo $sql ; die;

            $data = $connection->createCommand($sql)->queryRow();

            if ($data) {
                return $data;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    public function getEmailResoluton() {
        $time = Yii::app()->db->createCommand('SELECT email_resolution_id, email_resolution_imap,email_resolution_email,email_resolution_password FROM `su_email_resolution`')->queryRow();
        return $time;
    }

    public function setEmailResoluton($time) {
        $log_model = new Admin_ajax;
        if ($_POST['hdnid']) {
            $log_model->addLog("UPDATE", "su_email_resolution", 'email_resolution_imap', "Performed UPDATE Operation");
            $res = Yii::app()->db->createCommand('UPDATE `su_email_resolution` SET email_resolution_imap="' . $_POST['email_resolution_imap'] . '", email_resolution_email="' . $_POST['email_resolution_email'] . '",email_resolution_password="' . $_POST['email_resolution_password'] . '" WHERE email_resolution_id=' . $_POST['hdnid'])->execute();
            return $res;
        } else {
            $insertemail = 'INSERT INTO `su_email_resolution` (email_resolution_imap,email_resolution_email,email_resolution_password,email_resolution_ts) VALUES ("' . $_POST['email_resolution_imap'] . '","' . $_POST['email_resolution_email'] . '","' . $_POST['email_resolution_password'] . '","' . date("Y-m-d H:i:s") . '")';
            $id = Yii::app()->db->createCommand($insertemail)->execute();
            $log_model = new Admin_ajax;
            $log_model->addLog("INSERT", "su_email_resolution", $id, "Performed INSERT Operation");
            return $id;
        }
    }

    public function executeQuery($sql) {
        return Yii::app()->db->createCommand($sql)->queryAll();
    }

}
