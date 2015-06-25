<?php
echo "hi";die;
// change the following paths if necessary
error_reporting(E_ALL & ~E_NOTICE  & ~E_WARNING & ~E_STRICT);

$yii=dirname(__FILE__).'/framework/yii.php';
$config=dirname(__FILE__).'/protected/config/main.php';


// remove the following lines when in production mode
//defined('YII_DEBUG') or define('YII_DEBUG',false);
// specify how many levels of call stack should be shown in each log message
//defined('YII_TRACE_LEVEL') or define('YII_TRACE_LEVEL',0);

require_once($yii);

   $cnt_temp = $_SERVER["REQUEST_URI"]; 
   $cnt_temp = str_replace('/index.php', '', $cnt_temp);
   $cnt_temp =   explode("/",$cnt_temp);
   

// 
// if($_SESSION['seturl']!=1  && $cnt_temp[1]=="admin" && $_SERVER["REQUEST_URI"] !="/index.php" && $_SERVER["REQUEST_URI"] !="/admin/logout" && $_SERVER["REQUEST_URI"] !="/admin/index" && $_SERVER["REQUEST_URI"] !="/auth" && $_SERVER["REQUEST_URI"] !="/" &&  $_SERVER["REQUEST_URI"] !="" ) { 
//       
//        //  $_SESSION["mainurl"]=$_SERVER["REQUEST_URI"];  
//          $_SESSION["seturl"]  =1;
//   }

Yii::createWebApplication($config)->run();