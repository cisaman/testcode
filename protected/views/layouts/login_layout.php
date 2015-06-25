<!DOCTYPE html>
<html lang="en">

    <head>

        <?php
        $cs = Yii::app()->clientScript;
        $cs->scriptMap = array(
            'jquery.js' => Yii::app()->request->baseUrl . '/assets/js/jquery.js',
        );
        $cs->registerCoreScript('jquery');
        ?>

        <link href="<?php echo Yii::app()->request->baseUrl; ?>/css/custom.css" rel="stylesheet">   

        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="">
        <meta name="author" content="">

        <title><?php echo Yii::app()->name . ' - Login'; ?></title>

        <!-- GLOBAL STYLES -->
        <link href="<?php echo Yii::app()->request->baseUrl; ?>/css/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet">
        <link href='http://fonts.googleapis.com/css?family=Ubuntu:300,400,500,700,300italic,400italic,500italic,700italic' rel="stylesheet" type="text/css">
        <link href='http://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800' rel="stylesheet" type="text/css">
        <link href="<?php echo Yii::app()->request->baseUrl; ?>/assets/icons/font-awesome/css/font-awesome.min.css" rel="stylesheet">

        <!-- PAGE LEVEL PLUGIN STYLES -->

        <!-- THEME STYLES -->
        <link href="<?php echo Yii::app()->request->baseUrl; ?>/css/style.css" rel="stylesheet">
        <link href="<?php echo Yii::app()->request->baseUrl; ?>/css/plugins.css" rel="stylesheet">

        <!-- THEME DEMO STYLES -->
        <link href="<?php echo Yii::app()->request->baseUrl; ?>/css/demo.css" rel="stylesheet">

        <!--[if lt IE 9]>
        <script src="<?php echo Yii::app()->request->baseUrl; ?>/assets/js/html5shiv.js"></script>
        <script src="<?php echo Yii::app()->request->baseUrl; ?>/assets/js/respond.min.js"></script>
        <![endif]-->

    </head>

    <body class="login">
    	<div class="login_bar"></div>
        <div class="container">
            <div class="row">
                <div class="col-md-5 col-md-offset-4">
                    <div class="login-banner text-center">                       
                        <h1><img id="front_logo" style="width:200px;" class="" src="<?php echo Yii::app()->request->baseUrl . "/img/" . $this->company_logo; ?>" /><span class="text-blue"><?php //echo  $this->site_name;     ?></span></h1>
                    </div>
                    <?php echo $content; ?>
                </div>
            </div>
        </div>

        <script src="<?php echo Yii::app()->request->baseUrl; ?>/assets/js/plugins/bootstrap/bootstrap.min.js"></script>
        <script src="<?php echo Yii::app()->request->baseUrl; ?>/assets/js/plugins/slimscroll/jquery.slimscroll.min.js"></script>
        <!-- HISRC Retina Images -->
        <script src="<?php echo Yii::app()->request->baseUrl; ?>/assets/js/plugins/hisrc/hisrc.js"></script>

        <!-- PAGE LEVEL PLUGIN SCRIPTS -->

        <!-- THEME SCRIPTS -->
        <script src="<?php echo Yii::app()->request->baseUrl; ?>/assets/js/flex.js"></script>
        <script src="<?php echo Yii::app()->request->baseUrl; ?>/assets/js/custom.js"></script>
   </body>

</html>
