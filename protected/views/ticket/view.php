<?php
$this->pageTitle = Yii::app()->name . ' | View Ticket';
$result = Ticket::model()->findByAttributes(array("ticket_id" => $ticket_id, "read" => 0));
if (!empty($result)) {
    $result->read = 1;
    $result->read_by = Yii::app()->session['user_data']['user_id'];
    $result->update();
}
?>

<!-- begin PAGE TITLE AREA -->
<div class="row">
    <div class="col-lg-12">
        <div class="page-title">            
            <h1><i class="fa fa-search"></i> View Ticket | <small><a class="text-blue" href="<?php echo Yii::app()->createAbsoluteUrl('ticket/index'); ?>">Back to Listing</a></small></h1>
        </div>
    </div>    
</div>
<!-- end PAGE TITLE AREA -->

<div class="row">
    <div class="col-lg-12">

        <div class="portlet portlet-default">
            <div class="portlet-body">
                <ul id="bookingTab" class="nav nav-tabs">               
                    <li class="active"  id='getTicketStatus'><a href="#ticket-view" data-toggle="tab"><i class="fa fa-search"></i> Overview</a></li>
                    <?php if (in_array(Yii::app()->session['user_data']['user_role_type'], array(0, 1, 2, 3))) { ?>                       
                        <li class=""><a href="#ticket-assignee" data-toggle="tab"><i class="fa fa-user"></i> Assignee</a></li>
                    <?php } ?>
                    <li class="" id='getComments'><a href="#ticket-comments" data-toggle="tab" ><i class="fa fa-comments"></i> Discussions</a></li>
                     <?php if (!in_array(Yii::app()->session['user_data']['user_role_type'], array(6))) { ?>  
                    <li class="" id='changeTicketStatus'><a href="#ticket-status" data-toggle="tab" ><i class="fa fa-exchange"></i> Ticket Status</a></li>
                       <?php } ?>
                    <?php if (in_array(Yii::app()->session['user_data']['user_role_type'], array(6))) { ?>  
                    <li class="" id='refund'><a href="#ticket-refund" data-toggle="tab" ><i class="fa fa-exchange"></i>Refund</a></li>
                    <?php }?>
                </ul>
                <div id="bookingTabContent" class="tab-content">
                    <div class="tab-pane fade active in" id="ticket-view">                            
                        <div class="row">
                            <div class="col-md-12">
                                <?php $this->renderPartial('_view', array('model' => $model, 'ticket_id' => $ticket_id)); ?>
                            </div>
                        </div>
                    </div>
                    <?php if (in_array(Yii::app()->session['user_data']['user_role_type'], array(0, 1, 2, 3))) { ?>
                        <div class="tab-pane " id="ticket-assignee">                            
                            <div class="row">
                                <div class="col-md-12">
                                    <?php $this->renderPartial('_assignee', array('model' => $model, 'ticket_id' => $ticket_id)); ?>
                                </div>
                            </div>
                        </div>                    
                    <?php } ?>

                    <div class="tab-pane " id="ticket-comments">                            
                        <div class="row">
                            <div class="col-md-12">
                                <?php $this->renderPartial('_comments', array('model' => $model, 'ticket_id' => $ticket_id)); ?>
                            </div>
                        </div>
                    </div>

                    <div class="tab-pane " id="ticket-status">                            
                        <div class="row">
                            <div class="col-md-12">

                                <?php $this->renderPartial('_ticketstatus', array('model' => $model, 'ticket_id' => $ticket_id)); ?>
                            </div>
                        </div>
                    </div>
                     <?php if (in_array(Yii::app()->session['user_data']['user_role_type'], array(6))) { ?>
                        <div class="tab-pane " id="ticket-refund">                            
                            <div class="row">
                                <div class="col-md-12">
                                    <?php $this->renderPartial('_refund', array('model' => $model, 'ticket_id' => $ticket_id)); ?>
                                </div>
                            </div>
                        </div>                    
                    <?php } ?>
                </div>
            </div>
        </div>        
    </div>    
</div>