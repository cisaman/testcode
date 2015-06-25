<?php
$ts = 0;
$statusName = 'All Tickets';
if (isset($_GET['ts'])) {
    if (isset($_GET['Ticket']['ticket_status'])) {
        $_GET['ts'] = $_GET['Ticket']['ticket_status'];
    }
    $ts = $_GET['ts'];
    $statusName = TicketStatus::model()->getStatusName($ts);
}

$this->pageTitle = Yii::app()->name . ' | Manage Ticket';
?>
<div id="hole">
    <!-- begin PAGE TITLE AREA -->
    <div class="row">
        <div class="col-lg-12">
            <div class="page-title">            
                <h1> 
                    <?php
                    echo "Manage Ticket";
                    if (isset($_GET['user_id'])) {
                        echo "<small class='text-blue'> Listing For " . Users::model()->getUserName(base64_decode($_GET['user_id'])) . "</small>";
                    }
                    if (isset($_GET['client'])) {
                        echo "<small class='text-blue'> Listing For " . Users::model()->getUserName(base64_decode($_GET['client'])) . "</small>";
                    }
                    ?>

                </h1>

            </div>
        </div>    
    </div>
    <!-- end PAGE TITLE AREA -->

    <div class="row">
        <div class="col-lg-12">

            <div class="portlet portlet-default">
                <div class="portlet-body">

                    <div id="statusMsg"></div>

                    <?php if (Yii::app()->user->hasFlash('message')): ?>
                        <div class="alert alert-<?php echo Yii::app()->user->getFlash('type'); ?> alert-dismissable" id="successmsg">
                            <?php echo Yii::app()->user->getFlash('message'); ?>
                        </div>
                    <?php endif; ?>

                    <ul id="userTab" class="nav nav-tabs">
                        <li class="active"><a href="#ticket-list" data-toggle="tab"><i class="fa fa-list"></i> List of Ticket</a></li>
                        <?php if (in_array(Yii::app()->session['user_data']['user_role_type'], array(0, 1, 2, 3))) { ?>
                            <li class=""><a href="#ticket-report" data-toggle="tab"><i class="fa fa-search"></i> Order Report</a></li>                         
                        <?php } ?>
                    </ul>
                    <div id="userTabContent" class="tab-content">
                        <div class="tab-pane fade active in" id="ticket-list">
                            <div class="row">
                                <div class="col-md-12">                                
                                    <div class="table-responsive">
                                        <?php
                                        $this->widget('zii.widgets.grid.CGridView', array(
                                            'id' => 'users-grid',
                                            'htmlOptions' => array('class' => 'dataTables_wrapper', 'role' => 'grid'),
                                            'dataProvider' => $model->search(),
                                            'filter' => $model,
                                            'columns' => array(
                                                array(
                                                    'header' => 'S. No.',
                                                    'name' => 'S. No.',
                                                    'value' => '$this->grid->dataProvider->pagination->currentPage * $this->grid->dataProvider->pagination->pageSize + ($row+1)',
                                                    'htmlOptions' => array('style' => 'text-align:center'),
                                                    'headerHtmlOptions' => array('style' => 'text-align: center;width:60px'),
                                                ),
                                                array(
                                                    'name' => 'order_id',
                                                    'value' => '$data->order_id',
                                                    'htmlOptions' => array('style' => 'text-align:justify;-ms-word-break: break-all;word-break: break-all;'),
                                                    'filter' => CHtml::activeTextField($model, 'order_id', array('placeholder' => $model->getAttributeLabel('order_id'), 'style' => '', 'autocomplete' => 'off', 'class' => 'form-control')),
                                                    'headerHtmlOptions' => array('style' => 'text-align: center;width:100px'),
                                                ),
                                                array(
                                                    'header' => 'Client',
                                                    'type' => 'raw',
                                                    'headerHtmlOptions' => array('style' => 'text-align:left;'),
                                                    'value' => 'Orders::model()->getClientName($data->order_id)',
                                                    'htmlOptions' => array('style' => 'text-align:left;'),
                                                    'filter' => CHtml::activeTextField($model, 'clientname', array('value'=>@$_GET['Ticket']['clientname'] , 'placeholder' => $model->getAttributeLabel('clientname'), 'style' => '', 'autocomplete' => 'off', 'class' => 'form-control'))
                                                ),
                                                array(
                                                    'name' => 'ticket_title',
                                                    'value' => '$data->ticket_title',
                                                    'headerHtmlOptions' => array('style' => 'text-align: center;width:200px'),
                                                    'htmlOptions' => array('style' => 'text-align:left;'),
                                                    'filter' => CHtml::activeTextField($model, 'ticket_title', array('placeholder' => $model->getAttributeLabel('ticket_title'), 'style' => '', 'autocomplete' => 'off', 'class' => 'form-control'))
                                                ),
//                                                array(
//                                                    'name' => 'description',
//                                                    'value' => '$data->description',
//                                                    'htmlOptions' => array('style' => 'text-align:justify;-ms-word-break: break-all;word-break: break-all;'),
//                                                    'filter' => CHtml::activeTextField($model, 'description', array('placeholder' => $model->getAttributeLabel('description'), 'style' => '', 'autocomplete' => 'off', 'class' => 'form-control'))
//                                                ),
                                                array(
                                                    'name' => 'ticket_status',
                                                    'type' => 'raw',
                                                    'value' => 'TicketStatus::getTicketStatus($data->ticket_status)',
                                                    'htmlOptions' => array('style' => 'text-align:center;'),
                                                    'headerHtmlOptions' => array('style' => 'text-align: center;width:120px'),
                                                    'filter' => CHtml::activeDropDownList($model, 'ticket_status', TicketStatus::getTicketStatus(), array('style' => '', 'class' => 'form-control', 'empty' => 'Select'))
                                                ),
                                                array(
                                                    'header' => 'Read/Unread',
                                                    'name' => 'read',
                                                    'type' => 'raw',
                                                    'value' => '($data->read)?"Read":"Unread"',
                                                    'htmlOptions' => array('style' => 'text-align:center;'),
                                                    'headerHtmlOptions' => array('style' => 'text-align: center;width:100px'),
                                                    'filter' => CHtml::activeDropDownList($model, 'read', array(1 => 'Read', 0 => "Unread"), array('style' => '', 'class' => 'form-control', 'empty' => 'Select'))
                                                ),
                                                array(
                                                    'header' => 'Action',
                                                    'class' => 'CButtonColumn',
                                                    'deleteConfirmation' => 'Do you want to delete this Ticket Record?',
                                                    'afterDelete' => 'function(link,success,data){ if(success) { $("#statusMsg").css("display", "block"); $("#statusMsg").html(data); $("#statusMsg").animate({opacity: 1.0}, 3000).fadeOut("fast");}}',
                                                    'headerHtmlOptions' => array('style' => 'text-align: center;width:60px'),
                                                    'htmlOptions' => array('style' => 'text-align:center;'),
                                                    'template' => '{view}',
                                                    'buttons' => array
                                                        (
                                                        'view' => array
                                                            (
                                                            'label' => '<i class="fa fa-search"></i>',
                                                            'options' => array('title' => 'View Ticket'),
                                                            'imageUrl' => FALSE,
                                                            'url' => 'Yii::app()->createUrl("ticket/view", array("id" => base64_encode($data->ticket_id)))',
                                                        ),
                                                        'delete' => array
                                                            (
                                                            'label' => '<i class="fa fa-times"></i>',
                                                            'options' => array('title' => 'Delete', 'class' => 'remove'),
                                                            'imageUrl' => FALSE
                                                        ),
                                                        'assign' => array
                                                            (
                                                            'label' => '<i class="fa fa-mail-forward"></i>',
                                                            'options' => array('title' => 'Assign Ticket'),
                                                            'imageUrl' => FALSE
                                                        ),
                                                        'close' => array
                                                            (
                                                            'label' => '<i class="fa fa-minus"></i>',
                                                            'options' => array('title' => 'Close Ticket'),
                                                            'imageUrl' => FALSE
                                                        ),
                                                    ),
                                                ),
                                            ),
                                            'itemsCssClass' => 'table table-striped table-bordered table-hover dataTable',
                                            'pagerCssClass' => 'dataTables_paginate paging_bootstrap',
                                            'summaryCssClass' => 'dataTables_info',
                                            'template' => '{items}<div class = "row"><div class = "col-xs-6">{summary}</div><div class = "col-xs-6">{pager}</div></div>',
                                            'pager' => array(
                                                'htmlOptions' => array('class' => 'pagination', 'id' => ''),
                                                'header' => '',
                                                'cssFile' => false,
                                                'selectedPageCssClass' => 'active',
                                                'previousPageCssClass' => 'prev',
                                                'nextPageCssClass' => 'next',
                                                'hiddenPageCssClass' => 'disabled',
                                                'maxButtonCount' => 5,
                                            ),
                                            'emptyText' => '<span class="text-danger text-center">No Record Found!</span>',
                                        ));
                                        ?>
                                    </div>
                                </div>
                            </div>
                        </div>   

                        <?php if (in_array(Yii::app()->session['user_data']['user_role_type'], array(0, 1, 2, 3))) { ?>
                            <div class="tab-pane " id="ticket-report">                            
                                <div class="row">
                                    <div class="col-md-12">

                                        <?php $this->renderPartial('_report', array('model' => $model, 'ticket_id' => $ticket_id)); ?>

                                    </div>
                                </div>
                            </div>                    
                        <?php } ?>

                    </div>
                </div>            
            </div>        
        </div>    
    </div>
    <style type="text/css">
        .forall {       
            margin: 0px; 
            padding: 1px 5px;
            border: 1px solid;
            border-radius: 3px; 
            text-transform: none;
            font-size:12px;
            color:#fff;
        }
        table td {
            vertical-align: middle !important;
        }

    </style>
    <script type="text/javascript">
        $(function () {
            $("#Ticket_ticket_status option[value='<?php echo $ts; ?>']").attr("selected", "selected").change();

        });

    </script>
</div>
