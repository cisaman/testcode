<?php

class Utils {

    public static function getListOfControllers($flag = TRUE) {

        $appControllerPath = Yii::getPathOfAlias('application.controllers');

//checking existence of controllers directory
        if (is_dir($appControllerPath)) {
            $fileLists = CFileHelper::findFiles($appControllerPath);
        }

        $controllerName = array();
        foreach ($fileLists as $controllerPath) {
//getting controller name like e.g. 'siteController.php' 
            $name = substr($controllerPath, strrpos($controllerPath, DIRECTORY_SEPARATOR) + 1, -4);

            $name = str_replace('Controller', '', $name);

            if (in_array($name, array("Auth", "App"))) {
                if ($flag != TRUE) {
                    $controllerName[$name] = $name;
                }
            } else {
                $controllerName[$name] = $name;
            }
        }
        return $controllerName;
    }

    public static function getRandomPassword($length = 8) {

        $characters = '123456789abcdefghjkmnpqrstuvwxyzABCDEFGHJKLMNPQRSTUVWXYZ';

        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, strlen($characters) - 1)];
        }

        return $randomString;
    }

    public static function getBaseUrl() {
        if ($_SERVER['SERVER_NAME'] == "localhost") {
            $base_url = 'http://' . $_SERVER['SERVER_NAME'];
        } else {
            $base_url = 'http://' . $_SERVER['SERVER_NAME'] . Yii::app()->baseUrl;
        }


        return $base_url;
    }

    public static function getBaseNew() {
        if ($_SERVER['SERVER_NAME'] == "localhost") {
            $base_url = 'http://' . $_SERVER['SERVER_NAME'];
        } else {
            $base_url = 'http://' . $_SERVER['SERVER_NAME'];
        }


        return $base_url;
    }

    private function Encryption_Key() {
        $string = 'd0a7e7997b6d5fcd55f4b5c32611b87cd923e88837b63bf2941ef819dc8ca282';
        return $string;
    }

    private function mc_encrypt($encrypt, $key) {
        $encrypt = serialize($encrypt);

        $iv = mcrypt_create_iv(mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_CBC), MCRYPT_DEV_URANDOM);
        $key = pack('H*', $key);
        $mac = hash_hmac('sha256', $encrypt, substr(bin2hex($key), -32));
        $passcrypt = mcrypt_encrypt(MCRYPT_RIJNDAEL_256, $key, $encrypt . $mac, MCRYPT_MODE_CBC, $iv);
        $encoded = base64_encode($passcrypt) . '|' . base64_encode($iv);
        return $encoded;
    }

    private function mc_decrypt($decrypt, $key) {
        $decrypt = explode('|', $decrypt . '|');
        $decoded = base64_decode($decrypt[0]);
        $iv = base64_decode($decrypt[1]);
        if (strlen($iv) !== mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_CBC)) {
            return false;
        }
        $key = pack('H*', $key);
        $decrypted = trim(mcrypt_decrypt(MCRYPT_RIJNDAEL_256, $key, $decoded, MCRYPT_MODE_CBC, $iv));
        $mac = substr($decrypted, -64);
        $decrypted = substr($decrypted, 0, -64);
        $calcmac = hash_hmac('sha256', $decrypted, substr(bin2hex($key), -32));
        if ($calcmac !== $mac) {
            return false;
        }
        $decrypted = unserialize($decrypted);
        return $decrypted;
    }

    function passwordEncrypt($password) {

        return Utils::mc_encrypt($password, Utils::Encryption_Key());
    }

    function passwordDecrypt($password) {
        return Utils::mc_decrypt($password, Utils::Encryption_Key());
    }

    function encode($value) {

        if (!$value) {
            return false;
        }
        $crypttext = base64_encode($value);
        $crypttext = str_replace(array('+', '/', '='), array('-', '_', ''), $crypttext);
        return trim($crypttext);
    }

    function decode($string) {

        if (!$string) {
            return false;
        }
        $string = str_replace(array('-', '_'), array('+', '/'), $string);

        $crypttext = base64_decode($string);

        return trim($crypttext);
    }

    function getAttachmentpath() {
        $path = Yii::app()->basePath . "/../uploads/";
        return $path;
    }
    function getDownloadpath() {
        $path = Yii::app()->basePath . "/../../images/upload/";
        return $path;
    }

    function getBasepath() {
        $path = Yii::app()->basePath . "/../";
        return $path;
    }

    public static function createLabel($for) {
        $data = '<label class="col-sm-3 control-label col-sm-offset-1" for="' . $for . '">' . $for . ' <span class="text-red">*</span> </label>';
        return $data;
    }

    public static function createInputBox($id, $name, $value, $label) {

        $data = '<input id="' . $id . '" name="Configuration[' . $name . ']" placeholder="Enter ' . $label . '" value="' . $value . '" class="form-control " />';
        return $data;
    }

    public static function createTextArea($id, $name, $value, $label, $rows = 4) {
        $data = '<textarea id="' . $id . '" name="Configuration[' . $name . ']" placeholder="Enter ' . $label . '" rows="' . $rows . '" class="form-control">' . $value . '</textarea>';
        return $data;
    }

    public static function createImage($id, $name, $value, $label) {

        $data = '<div class="innerdiv" style="max-width: 200px;  margin: 5px 0px 15px;display:none">';
        $data .= '<img id="imagPrev"style="max-height:60px"  /><br>';
        $data .='<span id="close"  class="btn btn-default"title="Click here to remove this image">Remove</i></span>';
        $data .='</div>';
        $data .='<img class="image_pic" style="max-width: 200px; max-height: 60px; margin: 5px 0px 15px;" id="' . $id . '"   src="' . Yii::app()->request->baseUrl . '/img/' . $value . '?' . time() . '">';
        $data .= '<input type="file" id="upload_file" value="' . $value . '"  name = "Configuration[' . $name . ']" >';
        $data .="<label> Image standard size 200X60 upto 2MB & Upload only jpg, jpeg, png and gif file types. </label><div id='statusMsg'></div>";
        return $data;
    }

}
