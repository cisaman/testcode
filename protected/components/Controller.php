<?php

/**
 * Controller is the customized base controller class.
 * All controller classes for this application should extend from this base class.
 */
class Controller extends CController {

    /**
     * @var string the default layout for the controller view. Defaults to '//layouts/column1',
     * meaning using a single column layout. See 'protected/views/layouts/column1.php'.
     */
    public $layout = '//layouts/column1';

    /**
     * @var array context menu items. This property will be assigned to {@link CMenu::items}.
     */
    public $menu = array();

    /**
     * @var array the breadcrumbs of the current page. The value of this property will
     * be assigned to {@link CBreadcrumbs::links}. Please refer to {@link CBreadcrumbs::links}
     * for more details on how to specify this property.
     */
    public $breadcrumbs = array();
    public $user_data;
    public $site_name;
    public $company_logo;
    public $Host;
    public $Username;
    public $user_password;
    public $from_smtp;
    public $site_email;
    public $site_contact_no;

    public function init() {

        $model = new Configuration();
        $setmodel = $model->findAll();
        Yii::app()->db->setactive(FALSE);      
       
        foreach ($setmodel as $set) {
            if ($set->name == 'company_logo') {
                $this->company_logo = $set->value;
            }
            if ($set->name == 'site_name') {
                $this->site_name = $set->value;
            }
            if ($set->name == 'Host') {
                $this->Host = $set->value;
            }
            if ($set->name == 'Username') {
                $this->Username = $set->value;
            }
            if ($set->name == 'user_password') {
                $this->user_password = $set->value;
            }
            if ($set->name == 'from_smtp') {
                $this->from_smtp = $set->value;
            }
            if ($set->name == 'Site_email') {
                $this->site_email = $set->value;
            }
            if ($set->name == 'site_contact_no') {
                $this->site_contact_no = $set->value;
            }
        }

        if (!in_array(Yii::app()->controller->id, array('auth', 'app'))) {
            if (!isset(Yii::app()->session['user_data'])) {
                $this->redirect(Yii::app()->request->baseUrl . '/auth');
            } else {
                if (strtotime(date('Y-m-d H:i:s')) > Yii::app()->session['session_time'] && isset(Yii::app()->session['user_data'])) {
                    //  $loginmodel = new LoginForm;
                    //  $loginmodel->UpdateLastLogoutTime(Yii::app()->session['user_data']['user_id']);
                    //  unset(Yii::app()->session['user_data']);
                    // Yii::app()->user->logout();
                }
                $user = Users::model()->findByAttributes(array('user_id' => Yii::app()->session['user_data']['user_id']));
                Yii::app()->session['user_data'] = $user;
                $this->user_data = Yii::app()->session['user_data'];
                $role_name = UserRoles::model()->getRoleName($user->user_role_type);
                Yii::app()->user->name = $role_name;
                $user_role_type = Yii::app()->session['user_data']['user_role_type'];
                if ($user_role_type > 0) {
                    $modulist = ModulePermission::getAllmoduleList($user_role_type);
                    $module_id = SystemModules::getModuleIdBykey(Yii::app()->controller->id);
                    if (!in_array($module_id, $modulist)) {
                        $this->redirect(Yii::app()->request->baseUrl . '/auth');
                    }
                }
            }
        } else {

            if (Yii::app()->controller->id == "app") {
                $string = ltrim(strstr(Yii::app()->request->pathInfo, '/'), "/");
                if (!in_array(ucfirst($string), array('AddOrder', 'AddUser', 'EmailComments', 'MailToUsers', 'EmailAssignee', 'EmailChangeTicketStatus'))) {
                    echo json_encode(array("error" => true, 'error_code' => "401", "Message" => "Invalid Action"));
                    exit();
                }
            }
            if (strtotime(date('Y-m-d H:i:s')) > Yii::app()->session['session_time'] && isset(Yii::app()->session['user_data'])) {
                // $loginmodel = new LoginForm;
                // $loginmodel->UpdateLastLogoutTime(Yii::app()->session['user_data']['user_id']);
                // unset(Yii::app()->session['user_data']);
                //  Yii::app()->user->logout();
            }
        }
    }

    function replace($array, $str) {
        $logo = '<img style="width: 200px; max-height: 60px; margin-right: 10px; position: relative; top: 15px;"  src="' . Utils::getBaseUrl() . "/img/" . $this->company_logo . '" />';
        $userData = array(
            'website_url' => Utils::getBaseUrl(),
            "site_name" => $this->site_name,
            "company_logo" => $logo,
            "site_email" => $this->site_email,
            "site_contact_no" => $this->site_contact_no
        );

        $arrayNew = array_merge($array, $userData);
        foreach ($arrayNew as $key => $value) {
            $str = str_replace("$" . $key, $value, $str);
        }
        return $str;
    }

    function SendMail($to, $to_name, $subject, $message) {
        Yii::import('application.extensions.phpmailer.JPhpMailer');
        $mail = new JPhpMailer;
        $mail->IsSMTP();

        $mail->Host = $this->Host;
        $mail->SMTPSecure = "ssl";
        $mail->SMTPAuth = true;
        $mail->Username = $this->Username;
        $mail->Password = $this->user_password;
        $mail->SetFrom($this->from_smtp, $this->site_name);
        $mail->Subject = $subject;
        $mail->AltBody = 'To view the message, please use an HTML compatible email viewer!';
        $mail->MsgHTML($message);
        $mail->AddAddress($to, $to_name);

        if ($mail->Send()) {
            return true;
        } else {
            return false;
        }
    }

}
