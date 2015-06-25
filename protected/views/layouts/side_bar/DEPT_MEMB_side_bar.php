<!-- begin SIDE NAVIGATION -->
<nav class="navbar-side" role="navigation">
    <div class="navbar-collapse sidebar-collapse collapse">
        <ul id="side" class="nav navbar-nav side-nav">
            <!-- begin SIDE NAV USER PANEL -->
            <li class="side-user hidden-xs">
                <?php if ($this->user_data["user_avatar"] == NULL || $this->user_data["user_avatar"] == "") { ?>
                    <img class="img-circle" src="<?php echo Yii::app()->request->baseUrl; ?>/img/profile-pic.jpg" alt="">
                <?php } else { ?>
                    <img style="width: 160px; height: 150px;" class="img-circle" src="<?php echo Yii::app()->request->baseUrl; ?>/uploads/<?php echo $this->user_data["user_avatar"]; ?>" alt="">
                <?php } ?>
                <p class="welcome">
                    <i class="fa fa-key"></i> Logged in as
                </p>
                <p class="name tooltip-sidebar-logout">
                    <?php echo $this->user_data["accountType_name"]; ?>
                    <a style="color: inherit" class="logout_open" href="<?php echo Yii::app()->request->baseUrl . '/department/logout'; ?>" data-toggle="tooltip" data-placement="top" title="Logout"><i class="fa fa-sign-out"></i></a>
                </p>
                <div class="clearfix"></div>
            </li>
            <!-- end SIDE NAV USER PANEL -->

            <!-- begin DASHBOARD LINK -->
            <li>
                <a class="active" href="<?php echo Yii::app()->request->baseUrl; ?>/department">
                    <i class="fa fa-dashboard"></i> Dashboard
                </a>
            </li>
            <!-- end DASHBOARD LINK -->
            <?php
            if (Yii::app()->session['user_rights'][4]) {
                ?>
                <!-- begin DASHBOARD LINK -->
                <li>
                    <a class="active" href="<?php echo Yii::app()->request->baseUrl; ?>/department/tickets">
                        <i class="fa fa-dashboard"></i> Tickets
                    </a>
                </li>
                <!-- end DASHBOARD LINK -->
                <?php
            }
            ?>
            <?php
            if (Yii::app()->session['user_rights'][6]) {
                ?>
                <!-- Faq -->
                <li class="panel">
                    <a href="javascript:;" data-parent="#side" data-toggle="collapse" class="accordion-toggle" data-target="#forms2">
                        <i class="fa fa-table"></i> Faq <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="collapse nav" id="forms2">
                        <li>
                            <a href="<?php echo Yii::app()->request->baseUrl; ?>/admin/faq_category">
                                <i class="fa fa-angle-double-right"></i> Faq Category
                            </a>
                        </li>
                        <!--li>
                            <a href="<?php echo Yii::app()->request->baseUrl; ?>/admin/faq_subcategory">
                                <i class="fa fa-angle-double-right"></i> Faq Sub Category
                            </a>
                        </li-->
                        <li>
                            <a href="<?php echo Yii::app()->request->baseUrl; ?>/admin/faq">
                                <i class="fa fa-angle-double-right"></i>  Faq
                            </a>
                        </li>
                    </ul>
                </li>
                <!--End Faq -->
                <?php
            }
            ?>
            <?php
            if (Yii::app()->session['user_rights'][5]) {
                ?>
                <!-- Template -->
                <li class="panel">
                    <a href="javascript:;" data-parent="#side" data-toggle="collapse" class="accordion-toggle" data-target="#forms1">
                        <i class="fa fa-table"></i> Template <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="collapse nav" id="forms1">
                        <li>
                            <a href="<?php echo Yii::app()->request->baseUrl; ?>/admin/template_category">
                                <i class="fa fa-angle-double-right"></i> Template Category
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo Yii::app()->request->baseUrl; ?>/admin/template">
                                <i class="fa fa-angle-double-right"></i>  Template
                            </a>
                        </li>
                    </ul>
                </li>
                <!--End Template -->
                <?php
            }
            ?>
            <?php
            if (Yii::app()->session['user_rights'][3]) {
                ?>
                <!-- begin Departments LINK -->
                <li>
                    <a class="active" href="<?php echo Yii::app()->request->baseUrl; ?>/admin/department">
                        <i class="fa fa-briefcase"></i> Departments
                    </a>
                </li>
                <!-- end Departments LINK -->
                <?php
            }
            ?>
            <?php
            if (Yii::app()->session['user_rights'][2]) {
                ?>
                <!-- begin Users LINK -->
                <li>
                    <a class="active" href="<?php echo Yii::app()->request->baseUrl; ?>/admin/users">
                        <i class="fa fa-users"></i> Users
                    </a>
                </li>
                <!-- end Users LINK -->
                <?php
            }
            ?>
            <!-- begin Users LINK -->
            <li>
               <!--  <a class="active" href="<?php echo Yii::app()->request->baseUrl; ?>/department/add_ticket">
                    <i class="fa fa-table"></i> Open a Ticket
                </a> -->
                <a class="active" href="">
                    <i class="fa fa-table"></i> Open a Ticket
                </a> 
            </li>
            <!-- end Users LINK -->

        </ul>
        <!-- /.side-nav -->
    </div>
    <!-- /.navbar-collapse -->
</nav>
<!-- /.navbar-side -->
<!-- end SIDE NAVIGATION -->
