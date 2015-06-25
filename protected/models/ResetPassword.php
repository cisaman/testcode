<?php

/**
 * ForgetPassword class.
 * ForgetPassword is the class for recover the password
 */
class ResetPassword extends CFormModel {

    public $password;
    public $re_password;
    public $user_password;

    /**
     * Declares the validation rules.
     * The rules state that username and password are required,
     * and password needs to be authenticated.
     */
    public function rules() {
        return array(
            array('password, re_password', 'required'),
            array('password, re_password', 'length', 'min' => 6, 'max' => 40),
            array('password', 'compare', 'compareAttribute' => 're_password'),
        );
    }

    /**
     * Declares attribute labels.
     */
    public function attributeLabels() {
       
    }

    /**
     * Set the newly generated password.
     * @return boolean whether successfuly set password
     */
    public function reset_password($user_id) {
        $recoverPasswordModel = new ForgetPassword;
        $this->user_password = md5($this->password);

        // echo $this->user_password ." ". $user_id; die;  
        $insert = $recoverPasswordModel->set_password($this->user_password, $user_id);

        if ($insert) {
//            $user = Yii::app()->db->createCommand('SELECT su_user.*, su_accountType.accountType_name, su_accountType.accountType_alias as user_type ,su_department.department_name FROM su_user
//							      LEFT JOIN su_accountType ON su_accountType.accountType_id = su_user.user_accountTypeID
//							      LEFT JOIN su_department ON su_department.department_id = su_user.user_departmentID
//							      WHERE su_user.user_id = "' . $user_id . '"')->queryRow();
            $user = Users::model()->findByAttributes(array('user_id' => $user_id));

            unset(Yii::app()->session['user_data']);
            Yii::app()->session['user_data'] = $user;
            return true;
        } else {
            return false;
        }
    }

    public function reset_password_byemail($email) {
        $recoverPasswordModel = new ForgetPassword;
        $this->user_password = md5($this->password);

        // echo $this->user_password ." ". $user_id; die;  
        $insert = $recoverPasswordModel->set_password($this->user_password, $email);

        if ($insert) {
//            $user = Yii::app()->db->createCommand('SELECT su_user.*, su_accountType.accountType_name, su_accountType.accountType_alias as user_type ,su_department.department_name FROM su_user
//							      LEFT JOIN su_accountType ON su_accountType.accountType_id = su_user.user_accountTypeID
//							      LEFT JOIN su_department ON su_department.department_id = su_user.user_departmentID
//							      WHERE su_user.user_id = "' . $user_id . '"')->queryRow();
            $user = Users::model()->findByAttributes(array('user_id' => $user_id));

            unset(Yii::app()->session['user_data']);
            Yii::app()->session['user_data'] = $user;
            return true;
        } else {
            return false;
        }
    }

}
