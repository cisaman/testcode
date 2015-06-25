<!DOCTYPE html>
<html lang="en">
        <head>
        <?php
        $cs = Yii::app()->clientScript;
        $cs->scriptMap = array(
            'jquery.min.js' => false,
            'jquery.ajaxqueue.js' => false,
            'jquery.metadata.js' => false,
        );
        $cs->scriptMap = array(
            'jquery.min.js' => Yii::app()->request->baseUrl . '/bootstrap/js/jquery.js',
        );
        $cs->registerCoreScript('jquery');
        ?>
        <!--<link href="<?php echo Yii::app()->request->baseUrl; ?>/css/custom.css" rel="stylesheet">-->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="">
        <meta name="author" content="">
        <title><?php echo CHtml::encode($this->pageTitle); ?></title>

        <!-- PACE LOAD BAR PLUGIN - This creates the subtle load bar effect at the top of the page. -->
        <link href="<?php echo Yii::app()->request->baseUrl; ?>/css/plugins/pace/pace.css" rel="stylesheet">
        <script src="<?php echo Yii::app()->request->baseUrl; ?>/assets/js/plugins/pace/pace.js"></script>

        <!-- GLOBAL STYLES - Include these on every page. -->
        <link href="<?php echo Yii::app()->request->baseUrl; ?>/css/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet">
        <link href='http://fonts.googleapis.com/css?family=Ubuntu:300,400,500,700,300italic,400italic,500italic,700italic' rel="stylesheet" type="text/css">
        <link href="<?php echo Yii::app()->request->baseUrl; ?>/assets/icons/font-awesome/css/font-awesome.min.css" rel="stylesheet">

        <!-- PAGE LEVEL PLUGIN STYLES -->
        <link href="<?php echo Yii::app()->request->baseUrl; ?>/css/plugins/messenger/messenger.css" rel="stylesheet">
        <link href="<?php echo Yii::app()->request->baseUrl; ?>/css/plugins/messenger/messenger-theme-flat.css" rel="stylesheet">
        <link href="<?php echo Yii::app()->request->baseUrl; ?>/css/plugins/daterangepicker/daterangepicker-bs3.css" rel="stylesheet">
        <link href="<?php echo Yii::app()->request->baseUrl; ?>/css/plugins/morris/morris.css" rel="stylesheet">
        <link href="<?php echo Yii::app()->request->baseUrl; ?>/css/plugins/jvectormap/jquery-jvectormap-1.2.2.css" rel="stylesheet">
        <link href="<?php echo Yii::app()->request->baseUrl; ?>/css/plugins/datatables/datatables.css" rel="stylesheet">
        <link href="<?php echo Yii::app()->request->baseUrl; ?>/css/plugins/touch-spin/jquery.bootstrap-touchspin.css" rel="stylesheet">

        <!-- THEME STYLES - Include these on every page. -->
        <link href="<?php echo Yii::app()->request->baseUrl; ?>/css/style.css" rel="stylesheet">
        <link href="<?php echo Yii::app()->request->baseUrl; ?>/css/plugins.css" rel="stylesheet">

        <!-- THEME DEMO STYLES - Use these styles for reference if needed. Otherwise they can be deleted. -->
        <link href="<?php echo Yii::app()->request->baseUrl; ?>/css/demo.css" rel="stylesheet">

        <!--[if lt IE 9]>
          <script src="<?php echo Yii::app()->request->baseUrl; ?>/assets/js/html5shiv.js"></script>
          <script src="<?php echo Yii::app()->request->baseUrl; ?>/assets/js/respond.min.js"></script>
        <![endif]-->

        <!-- GLOBAL SCRIPTS -->
        <!--        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>-->
        <script src="<?php echo Yii::app()->request->baseUrl; ?>/assets/js/plugins/bootstrap/bootstrap.min.js"></script>
        <script src="<?php echo Yii::app()->request->baseUrl; ?>/assets/js/plugins/slimscroll/jquery.slimscroll.min.js"></script>
        <script src="<?php echo Yii::app()->request->baseUrl; ?>/assets/js/plugins/popupoverlay/jquery.popupoverlay.js"></script>
        <script src="<?php echo Yii::app()->request->baseUrl; ?>/assets/js/plugins/popupoverlay/defaults.js"></script>
        <script src="<?php echo Yii::app()->request->baseUrl; ?>/assets/js/plugins/popupoverlay/logout.js"></script>
        <script src="<?php echo Yii::app()->request->baseUrl; ?>/assets/js/bootbox.js"></script>
        <!-- HISRC Retina Images -->
        <script src="<?php echo Yii::app()->request->baseUrl; ?>/assets/js/plugins/hisrc/hisrc.js"></script>
        <!--        <script src="<?php echo Yii::app()->request->baseUrl; ?>/assets/js/jquery.form.js"></script> -->

        <script src="<?php echo Yii::app()->request->baseUrl; ?>/assets/js/plugins/validate/jquery.validate.js"></script>
        <script src="<?php echo Yii::app()->request->baseUrl; ?>/assets/js/plugins/touch-spin/jquery.bootstrap-touchspin.js"></script>
        <script src="<?php echo Yii::app()->request->baseUrl; ?>/assets/js/flex.js"></script>
        <script src="<?php echo Yii::app()->request->baseUrl; ?>/bootstrap/js/bootstrap-datepicker.js"></script>
        <script src="<?php echo Yii::app()->request->baseUrl; ?>/bootstrap/js/jquery.form.js"></script>
        <script>
            site_path = '<?php echo Yii::app()->request->baseUrl; ?>';
            controller_id = '<?php echo Yii::app()->controller->id ?>';
            action_id = '<?php echo Yii::app()->controller->action->id ?>';

        </script>
        </head>

        <body>
<div id="wrapper">
<nav class="navbar-top" role="navigation">
          <div class="navbar-header">
    <button type="button" class="navbar-toggle pull-right" data-toggle="collapse" data-target=".sidebar-collapse"> <i class="fa fa-bars"></i> Menu </button>
    <div class="navbar-brand"> <a href="<?php echo Yii::app()->request->baseUrl; ?>" style="width: 190px;"> <p style="color: rgb(255, 255, 255); font-weight: bold;">
    <span>
      <?php
                                echo $this->site_name;
                                ?>
                                </span>
      <img id="front_logo" style="max-width: 200px;max-height: 60px;margin-left: -5px;margin-right: 10px;"   src="<?php echo Yii::app()->request->baseUrl . "/img/" . $this->company_logo.'?'.time(); ?>" /> </p> 
      <!--                            <img src="<?php echo Yii::app()->request->baseUrl; ?>/img/payway.png"  class="hisrc img-responsive" alt="" style="position: absolute;top: 7px;">--> 
      </a> </div>
  </div>
          <div class="nav-top">
    <ul class="nav navbar-left">
              <li class="tooltip-sidebar-toggle"> <a href="javascript:void(0);" id="sidebar-toggle" data-toggle="tooltip" data-placement="right" title="Sidebar Toggle"> <i class="fa fa-bars"></i> </a> </li>
            </ul>
    <ul class="nav navbar-right">
              <li class="user_name_logged"> Welcome, <strong><?php echo $this->user_data["user_name"]; ?></strong> </li>
              <li> <a href="<?php echo Yii::app()->request->baseUrl; ?>/usersetting"> <i class="fa fa-gear"></i></a> </li>
              <li class="signout"> <a class="logout_open" href="logout"> <i class="fa fa-power-off"></i> </a> </li>
              <!--<li class="dropdown">
                            <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown">
                                <i class="fa fa-user"></i>  <i class="fa fa-caret-down"></i>
                            </a>
                            <ul class="dropdown-menu dropdown-user">
                                <li>
                                    <a href="<?php echo Yii::app()->request->baseUrl; ?>/usersetting">
                                        <i class="fa fa-gear"></i> Settings
                                    </a>
                                </li>
                                <li class="divider"></li>
                                <li>
                                    <a class="logout_open" href="logout">
                                        <i class="fa fa-sign-out"></i> Sign Out
                                        <strong><?php echo $this->user_data["user_name"]; ?></strong>
                                    </a>
                                </li>
                            </ul>                                
                        </li>-->
            </ul>
  </div>
        </nav>
<script type="text/javascript">
                $('document').ready(function () {
                    //  console.log(controller_id + " and action " + action_id);
                    $("#" + controller_id).addClass("active");
                    if (action_id == 'clients' && controller_id == 'users') {
                        $("#" + controller_id).removeClass("active");
                        $("#clients").addClass("active");
                    }
                    if (action_id == 'dashboard' && controller_id == 'auth') {
                        $("#auth").addClass("active");
                    }
                    var toggle = '1';
                    $("#sidebar-toggle").click(function () {
                        if (toggle == '1') {
                            $(".navbar-side").addClass("collapsed");
                            $("#page-wrapper").addClass("collapsed");
							$(".navbar-top").addClass("collapsed");
                            toggle = '0';

                        } else {
                            $(".navbar-side").removeClass("collapsed");
                            $("#page-wrapper").removeClass("collapsed");
							$(".navbar-top").removeClass("collapsed");
                            toggle = '1';
                        }

                    })

                })
            </script>
<style type="text/css">
                #page-wrapper {
                    min-height: 900px !important;
                }
                .navbar-side.collapsed {
                    display: none;
                }
                #page-wrapper.collapsed {
                    margin: 50px 0 0;
                }
            </style>
