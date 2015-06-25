<?php
$user_role_type = Yii::app()->session['user_data']['user_role_type'];
$modulist = ModulePermission::getAllmoduleList($user_role_type);
$ticketList = TicketAssign::model()->getTicketbyUser(Yii::app()->session['user_data']['user_id']);
//print_r($ticketList);
if (Yii::app()->session['user_data']['user_role_type'] == 5) {

    $orderlist = Ticket::Orderlistbyclients(Yii::app()->session['user_data']['user_id']);
    
    $ticketList = new CDbCriteria();
    $ticketList->select = 'ticket_id';
    $ticketList->addInCondition("order_id", $orderlist);
    $ticketList = Ticket::model()->findAll($ticketList);
}
$ticket_ids = array();
foreach ($ticketList as $ticket) {
    $ticket_ids[] = $ticket['ticket_id'];
}
$tickList = implode(',', $ticket_ids);
?> 
<div class="page-content">

    <!-- begin PAGE TITLE AREA -->
    <!-- Use this section for each page's title and breadcrumb layout. In this example a date range picker is included within the breadcrumb. -->
    <div class="row">
        <div class="col-lg-12">
            <div class="page-title">
                <h1>Dashboard
                    <small>Content Overview</small>
                </h1>
                <!-- <ol class="breadcrumb">
                     <li class="active"><i class="fa fa-dashboard"></i> Dashboard</li>
                     li class="pull-right">
                         <div id="reportrange" class="btn btn-green btn-square date-picker">
                             <i class="fa fa-calendar"></i>
                             <span class="date-range"></span> <i class="fa fa-caret-down"></i>
                         </div>
                     </li
                 </ol>-->
            </div>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->
    <!-- end PAGE TITLE AREA -->

    <!-- begin DASHBOARD CIRCLE TILES -->

    <div class="row tickets_boxes">
        <?php
        if (in_array(SystemModules::getModuleIdBykey('ticket'), $modulist)) {
            if (in_array(Yii::app()->session['user_data']['user_role_type'], array(0, 1, 2, 5))) {

                if (!in_array(Yii::app()->session['user_data']['user_role_type'], array(0, 1, 2))) {

                    $ticketNew = Ticket::model()->count('ticket_status==1 AND ticket_id IN (' . $tickList . ')');
                    $ticketUnread = Ticket::model()->count('ticket_status==1 AND read==0 AND ticket_id IN (' . $tickList . ')');
                } else {
                    $ticketNew = Ticket::model()->count('ticket_status==1');
                    $ticketUnread = Ticket::model()->count('ticket_status==1 AND read==0 ');
                }
                if (Yii::app()->session['user_data']['user_role_type'] == 5) {
                    $ticketNew = Ticket::model()->count('ticket_status==1 AND ticket_id IN (' . $tickList . ')');
                    $ticketUnread = Ticket::model()->count('read==0 AND ticket_id IN (' . $tickList . ')');
                }
                ?>
                <a href="<?php echo Yii::app()->request->baseUrl; ?>/ticket?ts=1">
                    <div  class="col-sm-3 link_to_Click">                    
                        <div class="circle-tile">
                            <div class="circle-tile-heading">
                                <i class="fa fa-ticket fa-fw fa-3x"></i>
                            </div>
                            <div class="circle-tile-content">

                                <!--<div title="Unread Ticket(s)" class="unread_ticket">
                                           <span style="font-weight: 300; font-size: 16px; color: #666;">Unread Tickets</span></p>
                                    </div>-->



                                <div class="circle-tile-number">
                                    <?php echo $ticketNew; ?><span style="font-weight: 500; font-size: 16px; color: #EA6153;">/ <?php if ($ticketUnread) { ?> <?php echo $ticketUnread; ?>  <?php } else { ?> 0 <?php } ?> unread</span>
                                </div>

                                <div class="circle-tile-description">
                                    New Tickets
                                </div>

                                                                                <!--<span class="circle-tile-footer">More Info <i class="fa fa-chevron-circle-right"></i></span>-->
                            </div>
                        </div>

                    </div>
                <?php } ?>
            </a>
            <a href="<?php echo Yii::app()->request->baseUrl; ?>/ticket?ts=2">
                <div class="col-sm-3 link_to_Click">

                    <div class="circle-tile">

                        <div class="circle-tile-heading">
                            <i class="fa fa-ticket fa-fw fa-3x"></i>
                        </div>

                        <div class="circle-tile-content">
                            <div class="circle-tile-number">
                                <?php
                                if (!in_array(Yii::app()->session['user_data']['user_role_type'], array(0, 1, 2))) {
                                    //echo 'ticket_status == 2 AND ticket_id IN (" ' . $tickList . ' ")';
                                    echo Ticket::model()->count('ticket_status == 2 AND ticket_id IN (' . $tickList . ')');
                                } else {
                                    echo Ticket::model()->count('ticket_status== 2 ');
                                }
                                ?>
                            </div>
                            <div class="circle-tile-description">
                                Open Tickets
                            </div>

                                        <!--<span class="circle-tile-footer">More Info <i class="fa fa-chevron-circle-right"></i></span>-->
                        </div>
                    </div>

                </div>
            </a>
            <a href="<?php echo Yii::app()->request->baseUrl; ?>/ticket?ts=3">
                <div class="col-sm-3 link_to_Click">

                    <div class="circle-tile">

                        <div class="circle-tile-heading">
                            <i class="fa fa-ticket fa-fw fa-3x"></i>
                        </div>

                        <div class="circle-tile-content">
                            <div class="circle-tile-number">
                                <?php
                                if (!in_array(Yii::app()->session['user_data']['user_role_type'], array(0, 1, 2))) {
                                    echo Ticket::model()->count('ticket_status==3 AND ticket_id IN (' . $tickList . ')');
                                } else {
                                    echo Ticket::model()->count('ticket_status==3');
                                }
                                ?>
                            </div>
                            <div class="circle-tile-description">
                                In-process Tickets
                            </div>

                                        <!--<span class="circle-tile-footer">More Info <i class="fa fa-chevron-circle-right"></i></span>-->
                        </div>
                    </div>

                </div>
            </a>
            <a href="<?php echo Yii::app()->request->baseUrl; ?>/ticket?ts=4">
                <div class="col-sm-3 link_to_Click">
                    <div class="circle-tile">

                        <div class="circle-tile-heading">
                            <i class="fa fa-ticket fa-fw fa-3x"></i>
                        </div>

                        <div class="circle-tile-content">
                            <div class="circle-tile-number">
                                <?php
                                if (!in_array(Yii::app()->session['user_data']['user_role_type'], array(0, 1, 2))) {

                                    echo Ticket::model()->count('ticket_status==4 AND ticket_id IN (' . $tickList . ')');
                                } else {
                                    echo Ticket::model()->count('ticket_status==4');
                                }
                                ?>
                            </div>
                            <div class="circle-tile-description">
                                Waiting for feedback
                            </div>

                                        <!--<span class="circle-tile-footer">More Info <i class="fa fa-chevron-circle-right"></i></span>-->
                        </div>
                    </div>
                </div>
            </a>
            <a href="<?php echo Yii::app()->request->baseUrl; ?>/ticket?ts=5">
                <div class="col-sm-3 link_to_Click">
                    <div class="circle-tile">

                        <div class="circle-tile-heading">
                            <i class="fa fa-ticket fa-fw fa-3x"></i>
                        </div>

                        <div class="circle-tile-content">
                            <div class="circle-tile-number">
                                <?php
                                if (!in_array(Yii::app()->session['user_data']['user_role_type'], array(0, 1, 2))) {

                                    echo Ticket::model()->count('ticket_status==5 AND ticket_id IN (' . $tickList . ')');
                                } else {
                                    echo Ticket::model()->count('ticket_status==5');
                                }
                                ?>
                            </div>
                            <div class="circle-tile-description">
                                Closed Tickets
                            </div>

                                        <!--<span class="circle-tile-footer">More Info <i class="fa fa-chevron-circle-right"></i></span>-->
                        </div>
                    </div>
                </div>
            </a>
        <?php } ?>
        <?php if (in_array(SystemModules::getModuleIdBykey('users'), $modulist)) { ?>
            <a href="<?php echo Yii::app()->request->baseUrl; ?>/users">
                <div class="col-sm-3 link_to_Click">

                    <div class="circle-tile">

                        <div class="circle-tile-heading">
                            <i class="fa fa-users fa-fw fa-3x"></i>
                        </div>

                        <div class="circle-tile-content">
                            <div class="circle-tile-number">
                                <?php
                                $count = count(Users::model()->getAllUserbyCreated(Yii::app()->session['user_data']['user_id']));
                                if ($count > 0) {
                                    echo $count - 1;
                                } else {
                                    echo $count;
                                }
                                ?>
                                <span id="sparklineA"></span>
                            </div>
                            <div class="circle-tile-description">
                                Users
                            </div>

                                        <!--<span class="circle-tile-footer">More Info <i class="fa fa-chevron-circle-right"></i></span>-->
                        </div>
                    </div>
                </div>
            </a>
        <?php } ?>
        <?php if (in_array(SystemModules::getModuleIdBykey('users'), $modulist)) { ?>
            <a href="<?php echo Yii::app()->request->baseUrl; ?>/users/clients">
                <div class="col-sm-3 link_to_Click">
                    <div class="circle-tile">

                        <div class="circle-tile-heading">
                            <i class="fa fa-users fa-fw fa-3x"></i>
                        </div>

                        <div class="circle-tile-content">
                            <div class="circle-tile-number">
                                <?php echo Users::model()->count('user_role_type=5'); ?>
                                <span id="sparklineA"></span>
                            </div>
                            <div class="circle-tile-description">
                                Clients
                            </div>

                                        <!--<span class="circle-tile-footer">More Info <i class="fa fa-chevron-circle-right"></i></span>-->
                        </div>
                    </div>
                </div>
            </a>
        <?php } ?>

    </div>
    <!-- end DASHBOARD CIRCLE TILES -->


</div>

<!-- PAGE LEVEL PLUGIN SCRIPTS -->

<!-- HubSpot Messenger -->
<script src="<?php echo Yii::app()->request->baseUrl; ?>/assets/js/plugins/messenger/messenger.min.js"></script>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/assets/js/plugins/messenger/messenger-theme-flat.js"></script>
<!-- Date Range Picker -->
<script src="<?php echo Yii::app()->request->baseUrl; ?>/assets/js/plugins/daterangepicker/moment.js"></script>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/assets/js/plugins/daterangepicker/daterangepicker.js"></script>

<script src="<?php echo Yii::app()->request->baseUrl; ?>/assets/js/plugins/flot/jquery.flot.js"></script>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/assets/js/plugins/flot/jquery.flot.resize.js"></script>
<!-- Sparkline Charts -->
<script src="<?php echo Yii::app()->request->baseUrl; ?>/assets/js/plugins/sparkline/jquery.sparkline.min.js"></script>
<!-- Moment.js -->
<script src="<?php echo Yii::app()->request->baseUrl; ?>/assets/js/plugins/moment/moment.min.js"></script>
<!-- jQuery Vector Map -->
<script src="<?php echo Yii::app()->request->baseUrl; ?>/assets/js/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js"></script>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/assets/js/plugins/jvectormap/maps/jquery-jvectormap-world-mill-en.js"></script>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/assets/js/demo/map-demo-data.js"></script>

<script src="<?php echo Yii::app()->request->baseUrl; ?>/assets/js/plugins/datatables/jquery.dataTables.js"></script>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/assets/js/plugins/datatables/datatables-bs3.js"></script>

<!-- THEME SCRIPTS -->
<script src="<?php echo Yii::app()->request->baseUrl; ?>/assets/js/flex.js"></script>

<!--faq search start-->


