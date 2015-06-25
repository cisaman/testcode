<!---Admin sidebar --->
<?php
//if ($this->user_data["user_type"] == "ADMIN") {
?>
<!-- begin SIDE NAVIGATION -->
<nav class="navbar-side" role="navigation">
    <div class="navbar-collapse sidebar-collapse collapse">
        <ul id="side" class="nav navbar-nav side-nav">
            <!-- begin SIDE NAV USER PANEL -->
   <!--           <li class="side-user hidden-xs" >

              <img style="width: 160px; height: 150px;" class="img-circle" src="<?php echo Yii::app()->request->baseUrl; ?>/img/avatar.png" alt="">-->

                <!--<img id="front_logo" style="max-width: 200px;max-height: 60px;margin-left: -5px;margin-right: 10px;"   src="<?php echo Yii::app()->request->baseUrl . "/img/" . $this->company_logo.'?'.time(); ?>" />


                <p class="welcome">
                    <i class="fa fa-key"></i> Signed in as <b><?php echo Yii::app()->user->name; ?></b>
                </p>
                <p class="name tooltip-sidebar-logout">
                    <?php echo $this->user_data["user_name"]; ?>
                    <a style="color: inherit" class="logout_open" href="<?php echo Yii::app()->request->baseUrl . '/auth/logout'; ?>" data-toggle="tooltip" data-placement="top" title="Sign Out">
                        <i class="fa fa-sign-out"></i>
                    </a>
                </p>
                <div class="clearfix"></div>
            </li>-->
            <!-- end SIDE NAV USER PANEL -->

            <!-- Tickets -->

            <!-- begin Users Management  LINK -->
            <li id="auth">
                <a  href="<?php echo Yii::app()->request->baseUrl; ?>/dashboard">
                    <i class="fa fa-dashboard"></i> Dashboard
                </a>
            </li>
            <?php
            $user_role_type = Yii::app()->session['user_data']['user_role_type'];
            $modulist = ModulePermission::getAllmoduleList($user_role_type);
            ?>                   
            <?php if (in_array(SystemModules::getModuleIdBykey('ticket'), $modulist)) { ?>
                <li id="ticket">
                    <a  href="<?php echo Yii::app()->request->baseUrl; ?>/ticket">
                        <i class="fa fa-ticket"></i> Ticket Management 
                    </a>
                </li>        
            <?php } ?>
            <?php if (in_array(SystemModules::getModuleIdBykey('users'), $modulist)) { ?>
                <li id="users">
                    <a  href="<?php echo Yii::app()->request->baseUrl; ?>/users">
                        <i class="fa fa-users"></i> User Management 
                    </a>
                </li>        
            <?php } ?>
            <?php if (in_array(SystemModules::getModuleIdBykey('users'), $modulist)) { ?>
                <li id="clients">
                    <a  href="<?php echo Yii::app()->request->baseUrl; ?>/users/clients">
                        <i class="fa fa-users"></i> Client Management 
                    </a>
                </li>        
            <?php } ?>    
            <?php if (in_array(SystemModules::getModuleIdBykey('users12'), $modulist)) { ?>
                <li id="clients">
                    <a  href="<?php echo Yii::app()->request->baseUrl; ?>/users/clients">
                        <i class="fa fa-users"></i> Client Management 
                    </a>
                </li>        
            <?php } ?>


            <!-- Users Management -->

            <?php if (in_array(SystemModules::getModuleIdBykey('modulePermission'), $modulist)) { ?>
                <li id="modulePermission">
                    <a  href="<?php echo Yii::app()->request->baseUrl; ?>/modulePermission">
                        <i class="fa fa-unlock-alt"></i> Permission Management 
                    </a>
                </li>
            <?php } ?>
            <?php if (in_array(SystemModules::getModuleIdBykey('template'), $modulist)) { ?>
                <li id="template">
                    <a  href="<?php echo Yii::app()->request->baseUrl; ?>/template">
                        <i class="fa fa-css3"></i> Template Management 
                    </a>
                </li>
            <?php } ?>
            <?php if (in_array(SystemModules::getModuleIdBykey('coupons'), $modulist)) { ?>
                <li id="coupons">
                    <a  href="<?php echo Yii::app()->request->baseUrl; ?>/coupons">
                        <i class="fa fa-money"></i> Coupon Management 
                    </a>
                </li>
            <?php } ?>
            <?php
            $activeClass = "collapsed";
            $activeClass1 = "collapse";
            $action = Yii::app()->controller->id;
            if ($action == "ticketStatus" || $action == "department" || $action == "systemModules" || $action == "userRoles" || $action == "configuration") {
                $activeClass = "";
                $activeClass1 = "in";
            }
            ?>
            <?php if (in_array(SystemModules::getModuleIdBykey('configuration'), $modulist)) { ?>
                <li class="panel">
                    <a data-target="#configpanel" class="accordion-toggle <?php echo $activeClass; ?> " data-toggle="collapse" data-parent="#configpanel" href="javascript:;">
                        <i class="fa fa-gear"></i> Configuration <i class="fa fa-caret-down"></i>
                    </a>
                    <ul id="configpanel" class="nav <?php echo $activeClass1; ?>">
                        <?php if (in_array(SystemModules::getModuleIdBykey('ticketStatus'), $modulist)) { ?>
                            <li id="ticketStatus">
                                <a  href="<?php echo Yii::app()->request->baseUrl; ?>/ticketStatus">
                                    <i class="fa fa-check-square-o"></i> Ticket Status Management 
                                </a>
                            </li>
                        <?php } ?>
                        <?php if (in_array(SystemModules::getModuleIdBykey('department'), $modulist)) { ?>
                            <li id="department">
                                <a  href="<?php echo Yii::app()->request->baseUrl; ?>/department">
                                    <i class="fa fa-briefcase"></i> Department Management 
                                </a>
                            </li>
                        <?php } ?>
                        <?php if (in_array(SystemModules::getModuleIdBykey('systemModules'), $modulist)) { ?>
                            <!-- begin Module Management -->
                            <li id="systemModules">
                                <a  href="<?php echo Yii::app()->request->baseUrl; ?>/systemModules">
                                    <i class="fa fa-suitcase"></i> Module Management 
                                </a>
                            </li>
                        <?php } ?>
                        <?php if (in_array(SystemModules::getModuleIdBykey('userRoles'), $modulist)) { ?>
                            <li id="userRoles">
                                <a  href="<?php echo Yii::app()->request->baseUrl; ?>/userRoles">
                                    <i class="fa fa-anchor"></i> User Role Management 
                                </a>
                            </li>
                        <?php } ?>
                        <?php if (in_array(SystemModules::getModuleIdBykey('configuration'), $modulist)) { ?>
                            <li id="configuration">
                                <a  href="<?php echo Yii::app()->request->baseUrl; ?>/configuration">
                                    <i class="fa fa-gears"></i> System Settings
                                </a>
                            </li>
                        <?php } ?>
                    </ul>
                </li>                
            <?php } ?>            
            <!-- end Module Management LINK -->

        </ul>
        <!-- /.side-nav -->
    </div>
    <!-- /.navbar-collapse -->
</nav>
<!-- /.navbar-side -->
<!-- end SIDE NAVIGATION -->
<?php
//}
?>
<!---End Admin sidebar --->

<style>
    .navbar-side ul.side-nav {
        background-color: #fcfcfc;
        color: red !important;
    }
    .side-user .name ,.welcome {
        color: #34595e !important;
    </style>
