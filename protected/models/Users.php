<?php

/**
 * This is the model class for table "users".
 *
 * The followings are the available columns in table 'users':
 * @property integer $user_id
 * @property string $user_name
 * @property string $user_image
 * @property string $user_email
 * @property string $user_password
 * @property integer $user_status
 * @property integer $user_role_type
 * @property integer $user_department_id
 * @property integer $user_created_by_id
 * @property string $user_last_login_time
 * @property string $user_last_logout_time
 * @property string $user_ip_address
 * @property string $created_date
 * @property string $updated_date
 * @property string $forgot_password_code
 * @property string $forgot_pass_code_expiry
 * @property string $phone
 * @property string $skype
 */
class Users extends CActiveRecord {

    public $all = array();

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'users';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('user_name, user_email, user_password user_role_type ,user_department_id ,user_created_by_id ', 'required'),
            array('user_email', 'match', "pattern" => "/^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,6})$/"),
            array('user_email', 'unique'),
            array('user_status, user_role_type, user_department_id, ', 'numerical', 'integerOnly' => true),
            array('user_name, user_image, user_password', 'length', 'max' => 255),
            array('user_email', 'length', 'max' => 55),
            array('skype', 'length', 'max' => 55),
            array('phone', 'length', 'max' => 12),
            array('user_ip_address', 'length', 'max' => 100),
            array('user_last_login_time, user_last_logout_time, created_date, updated_date', 'safe'),
            array('created_date,updated_date', 'default',
                'value' => date("Y-m-d H:i:s"),
                'on' => 'insert'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('user_id, user_name,skype,phone,forgot_password_code,forgot_pass_code_expiry, user_image, user_email, user_password, user_status, user_role_type, user_department_id, user_created_by_id, user_last_login_time, user_last_logout_time, user_ip_address, created_date, updated_date', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'user_id' => 'ID',
            'user_name' => 'Name',
            'user_image' => 'Profile Photo',
            'user_email' => 'Email ID',
            'user_password' => 'Password',
            'user_status' => 'Status',
            'user_role_type' => 'Role Type',
            'user_department_id' => 'Department',
            'user_created_by_id' => 'Created By',
            'user_last_login_time' => 'Last Login Time',
            'user_last_logout_time' => 'Last Logout Time',
            'user_ip_address' => 'IP Address',
            'created_date' => 'Created Date',
            'updated_date' => 'Updated Date',
            'phone' => "Phone No.",
            'skype' => "Skype ID"
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     *
     * Typical usecase:
     * - Initialize the model fields with values from filter form.
     * - Execute this method to get CActiveDataProvider instance which will filter
     * models according to data in model fields.
     * - Pass data provider to CGridView, CListView or any similar widget.
     *
     * @return CActiveDataProvider the data provider that can return the models
     * based on the search/filter conditions.
     */
    public function search($id = 1) {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria = new CDbCriteria;
        $criteria->compare('user_id', $this->user_id);
        $criteria->compare('user_name', trim($this->user_name), true);
        $criteria->compare('user_image', $this->user_image, true);
        $criteria->compare('user_email', trim($this->user_email), true);
        $criteria->compare('user_password', $this->user_password, true);
        $criteria->compare('user_status', $this->user_status, true);
        $criteria->compare('user_role_type', $this->user_role_type);
        $criteria->compare('user_department_id', $this->user_department_id);
        $criteria->compare('user_created_by_id', $this->user_created_by_id);
        $criteria->compare('user_last_login_time', $this->user_last_login_time, true);
        $criteria->compare('user_last_logout_time', $this->user_last_logout_time, true);
        $criteria->compare('user_ip_address', $this->user_ip_address, true);
        $criteria->compare('created_date', $this->created_date, true);
        $criteria->compare('updated_date', $this->updated_date, true);
        $criteria->compare('phone', $this->phone, true);
        $criteria->compare('skype', $this->skype, true);


        if ($id == 1) {
            if ($this->getAllUserbyCreated(Yii::app()->session['user_data']['user_id'])) {
                $criteria->AddInCondition('user_created_by_id ', $this->all);
            }
            $criteria->AddCondition('user_role_type != 5');
        } else {
            if (in_array(Yii::app()->session['user_data']['user_role_type'], array(0, 1, 2))) {
                $criteria->AddCondition('user_role_type ==5');
            } else {
                $criteria->AddCondition('user_id==0 ');
            }
        }


        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'sort' => array(
                'defaultOrder' => 'user_id asc'
            ),
            'pagination' => array(
                'pageSize' => 20,
            ),
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Users the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function checkUserRole($roleType) {
        if ($roleType != 1) {
            $data = Users::model()->count('user_role_type=' . $roleType);
        } else {
            $data = 1;
        }

        return $data;
    }

    public function checkDepartment($id) {
        $data = Users::model()->count('user_department_id=' . $id);
        return $data;
    }

    public static function getUserName($ID) {
        if ($ID) {
            $result = Users::model()->findByPk($ID)->user_name;
        } else {
            $result = "Self";
        }

        return $result;
    }

    public function getUserRoleType($ID) {

        if ($ID) {

            $result = Users::model()->findByPk($ID)->user_role_type;
        } else {
            $result = 0;
        }

        return $result;
    }

    public static function getUserInfo($ID) {
        if ($ID) {
            $result = Users::model()->findByPk($ID);
        } else {
            $result = "Self";
        }

        return $result;
    }

    public function checkPassword($password, $user_id) {
        if ($password != "" && $user_id != "") {
            $data = Users::model()->count('user_id=' . $user_id . ' and  user_password= "' . md5($password) . '"');
            if ($data) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    public function getAllUserbyCreated($id) {
        $userList[] = $id;
        $this->all[] = $id;
        $c = new CDbCriteria();
        $c->select = "user_id";
        $c->condition = 'user_created_by_id =:user_id AND user_role_type !=5';
        $this->getRecursiveUserList($c, $userList);
        return $this->all;
    }

    public function getRecursiveUserList($c, $userList) {

        foreach ($userList as $id) {
            $c->params = array('user_id' => $id);
            $result = Users::model()->findAll($c);
            if (!empty($result)) {
                foreach ($result as $t) {
                    $userFilterList[] = $t->user_id;
                    $this->all[] = $t->user_id;
                }
            }
        }
        if (!empty($userFilterList)) {
            $this->getRecursiveUserList($c, $userFilterList);
        }
    }

    public function getClienList() {
        $result = Users::model()->findAll("user_role_type =5");
        $list = array();
        foreach ($result as $row) {
            $list[$row['user_id']] = $row['user_name'];
        }

        return $list;
    }

    function getFilterUser($username, $deparment, $restrictedUsers, $emailid, $order_column = "user_name", $order = "asc") {

        $c = new CDbCriteria();
        $parm[':user_name'] = "%$username%";
        if ($deparment) {
            $parm['department_id'] = $deparment;
            $str = ' user_name LIKE :user_name AND user_department_id = :department_id  AND user_status=1';
        } else {
            $str = ' user_name LIKE :user_name AND user_department_id NOT IN (0,1) AND user_status=1';
        }
        if ($emailid) {
            $parm['user_email'] = "%$emailid%";
            $str .= ' AND user_email LIKE :user_email';
        }

        $restrictedUsers = implode(',', $restrictedUsers);

        if (!empty($restrictedUsers)) {
            $str .= ' AND user_id NOT IN (' . $restrictedUsers . ')';
        }


        $c->condition = $str;
        $c->params = $parm;
        $c->select = "user_id, user_name,user_department_id,user_role_type,user_email ";
        $c->order = $order_column . ' ' . $order;
        $c->limit = 20;
        //$c->offset = $offset;

        $result = Users::model()->findAll($c);
        return $result;
    }

    public function getUserAssigneeList($id) {
        $assigneeList = TicketAssign::model()->findAllByAttributes(array("ticket_id" => $id, "status" => 1), array(
            'condition' => 'fwd_to!=:id AND user_role_type!=5',
            'params' => array('id' => Yii::app()->session['user_data']['user_id']),
        ));

        if (!empty($assigneeList)) {
            $str = '<table class="table table-bordered table-striped" >
                    <tr><th  style="width:20px;">#</th><th>Name</th><th>Email ID</th><th>Role</th><th style="max-width:120px;">Department</th> <th>Assigned by</th><th  style="width:60px;">Action</th></tr>';
            $count = 1;
            foreach ($assigneeList as $list) {
                $userinfo = Users::model()->findByAttributes(array('user_id' => $list['fwd_to']));
                $str .= '<tr>
                        <td> ' . $count++ . ' </td>
                        <td>' . $userinfo['user_name'] . '</td>
                        <td>' . $userinfo['user_email'] . '</td>     
                        <td>' . UserRoles::model()->getRoleName($userinfo["user_role_type"]) . '</td>
                        <td>' . Department::model()->getDepartmentName($userinfo['user_department_id']) . '</td>
                        <td>' . Users::model()->getUserName($list['fwd_by']) . '</td>';
                if (Yii::app()->session['user_data']['user_id'] == $list['fwd_by'] || in_array(Yii::app()->session['user_data']['user_role_type'], array(0, 1, 2))) {
                    $str .='<td><a class = "removeUser" data = "' . $userinfo['user_id'] . '" title = "Remove assign User" href = "javascript:"><i class = "fa fa-times" ></i></a></td></tr>';
                } else {
                    $str .='<td></td></tr>';
                }
            }
            $str .='</table>';
        } else {
            $str .='<div class = "norecord col-sm-12">No users assigned.</div>';
        }
        return $str;
    }

    public function getClientAssigneeList($id) {
        $assigneeList = TicketAssign::model()->findAllByAttributes(array("ticket_id" => $id, "status" => 1, 'user_role_type' => 5), array(
            'condition' => 'fwd_to!=:id',
            'params' => array('id' => Yii::app()->session['user_data']['user_id']),
        ));
        if (!empty($assigneeList)) {
            $str = '<table class = "table table-bordered table-striped" >
                <tr><th style = "width:20px;" > #</th><th>Name</th><th>Email ID</th><th>Role</th><th style="max-width:120px;">Department</th><th>Assigned by</th><th style="width:60px;">Action</th></tr>';
            $count = 1;
            foreach ($assigneeList as $list) {
                $userinfo = Users::model()->findByAttributes(array('user_id' => $list['fwd_to']));
                $str .= '<tr >
                        <td> ' . $count++ . ' </td>
                        <td>' . $userinfo['user_name'] . '</td>   
                        <td>' . $userinfo['user_email'] . '</td>   
                        <td>' . UserRoles::model()->getRoleName($userinfo["user_role_type"]) . '</td>
                        <td>' . Department::model()->getDepartmentName($userinfo['user_department_id']) . '</td>
                       <td>' . Users::model()->getUserName($list['fwd_by']) . '</td>';
                if (Yii::app()->session['user_data']['user_id'] == $list['fwd_by']) {
                    $str .='<td><a class="removeUser" data="' . $userinfo['user_id'] . '"  title="Remove assign User" href="javascript:"><i class="fa fa-times" ></i></a></td></tr>';
                } else {
                    $str .='<td></td></tr>';
                }
            }
            $str .='</table>';
        } else {
            $str .='<div class = "norecord col-sm-12">No users assigned.</div>';
        }
        return $str;
    }

    public static function getAllClients($clientname) {
        $rows = Users::model()->findAllByAttributes(array('user_role_type' => 5), 'user_name LIKE "%' . $clientname . '%"');
        $result = array();

        if (!empty($rows)) {
            foreach ($rows as $row) {
                $result[] = $row->user_id;
            }
        }

        return $result;
    }

}
