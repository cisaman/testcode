<?php

/**
 * LoginForm class.
 * LoginForm is the data structure for keeping
 * user login form data. It is used by the 'login' action of 'SiteController'.
 */
class LoginForm extends CFormModel {

    public $username;
    public $password;
    public $rememberMe;
    private $_identity;

    /**
     * Declares the validation rules.
     * The rules state that username and password are required,
     * and password needs to be authenticated.
     */
    public function rules() {
        return array(
            // username and password are required
            array('username, password', 'required', 'message' => 'Please enter {attribute}.'),
            array('username', 'email', 'message' => 'Invalid {attribute}.'),
            // rememberMe needs to be a boolean
            array('rememberMe', 'boolean'),
            // password needs to be authenticated
            array('password', 'required'),
        );
    }

    /**
     * Declares attribute labels.
     */
    public function attributeLabels() {
        return array(
            'rememberMe' => 'Remember me',
            'username' => 'Email ID'
        );
    }

    /**
     * Logs in the user using the given username and password in the model.
     * @return boolean whether login is successful
     */
    public function login() {
        if ($this->_identity === null) {
            $this->_identity = new UserIdentity($this->username, $this->password);
            $this->_identity->authenticate();
        }
        if ($this->_identity->errorCode === UserIdentity::ERROR_NONE) {
            if (Yii::app()->session['attamps'] >= 3 && Yii::app()->session['exp'] > time()) {
                $this->addError('password', "You have already made 3 incorrect attempts. Now you can't sign in for next 15 min.");
                return false;
            } else {
                if (Yii::app()->session['attamps'] >= 3) {
                    Yii::app()->session['attamps'] = 0;
                }
            }
            $user = Users::model()->findByAttributes(array('user_email' => $this->username, 'user_password' => md5($this->password)));

            if (!empty($user)) {
                if ($user->user_status == 1) {
                    if ($this->rememberMe) {
                        $user_id = new CHttpCookie('user_id', $user->user_id);
                        $user_id->expire = time() + 3600 * 24 * 30;
                        Yii::app()->request->cookies['user_id'] = $user_id;

                        $user_role = new CHttpCookie('user_role', $user->user_role_type);
                        $user_role->expire = time() + 3600 * 24 * 30;
                        Yii::app()->request->cookies['user_role'] = $user_role;
                    }
                    //$this->setRights($user['user_accountTypeID']);
                    $this->setConfiguration();
                    //print_r($rights);die;
                    Yii::app()->session['attamps'] = 0;
                    Yii::app()->session['user_data'] = $user;
                    Yii::app()->session['session_time'] = strtotime(Date('Y-m-d H:i:s')) + 1200;
                    $role_name = UserRoles::model()->getRoleName($user->user_role_type);
                    Yii::app()->user->name = $role_name;

                    return true;
                } else {

                    $this->addError('password', 'Your Account Got Disabled By Admin.');
                    return false;
                }
            } else {
                Yii::app()->session['attamps'] = Yii::app()->session['attamps'] + 1;
                Yii::app()->session['exp'] = time() + (60 * 15);
                if (Yii::app()->session['attamps'] > 2) {
                    $this->addError('password', "You have already made 3 incorrect attempts. Now you can't sign in for next 15 min.");
                    return false;
                }
                $this->addError('password', 'Invalid Credentials');
                return false;
            }
        } else
            return false;
    }

    public function setRights($id) {
//      //  $user_rights = Yii::app()->db->createCommand('SELECT * FROM `su_permission` WHERE accountType_id =' . $id)->queryAll();
//
//        $rights = array();
//        foreach ($user_rights as $right) {
//            $rights[$right['module_id']] = $right['permission_flag'];
//        }

        Yii::app()->session['user_rights'] = $rights;
    }

    public function setConfiguration() {

        $config = Yii::app()->db->createCommand('SELECT * FROM `su_configuration`')->queryAll();
        $configs = array();

        foreach ($config as $val) {
            $configs[$val['config_name']] = $val['config_value'];
        }
        Yii::app()->session['config'] = $configs;
    }

    /*
     * updateLastLogin : this method will update the value of alst login time of the user ;
     * @param : user id
     * @return : true
     */

    public function UpdateLastLoginTime($user_id) {
        $user_ip = CHttpRequest::getUserHostAddress();
        return $update_last_login = Yii::app()->db->createCommand('UPDATE users SET user_last_login_time = "' . date("Y-m-d H:i:s") . '", user_ip_address = "' . $user_ip . '" WHERE user_id = "' . $user_id . '"')->query();
    }

    public function UpdateLastLogoutTime($user_id) {
        return $update_last_login = Yii::app()->db->createCommand('UPDATE users SET user_last_logout_time = "' . date("Y-m-d H:i:s") . '" WHERE user_id = "' . $user_id . '"')->query();
    }

    /*
     * UpdateLastLoginOnResetPassword : this method will set the value of alst login time to NULL ;
     * @param : user id
     * @return : true
     */

    public function UpdateLastLoginOnResetPassword($user_id) {
        $user_ip = CHttpRequest::getUserHostAddress();
        $log_model = new Admin_ajax;
        // $log_model->addLog("Update", 'su_user', $user_id, 'Performed Update Operation');

        $update_last_login = Yii::app()->db->createCommand('UPDATE users SET user_last_login_time = "' . NULL . '", user_ip_address = "' . $user_ip . '" WHERE user_id = "' . $user_id . '"  ')->query();
        return true;
    }

}
