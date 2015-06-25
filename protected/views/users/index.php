<?php
$this->pageTitle = Yii::app()->name . ' | Manage Users';

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
    $('.search-form').toggle();
    return false;
});
$('.search-form form').submit(function(){
    $('#users-grid').yiiGridView('update', {
        data: $(this).serialize()
    });
    return false;
});
$('.search-form form').submit(function(){
    $('#clients-grid').yiiGridView('update', {
        data: $(this).serialize()
    });
    return false;
});
");
?>

<!-- begin PAGE TITLE AREA -->
<div class="row">
    <div class="col-lg-12">
        <div class="page-title">            
            <h1>Manage Users</h1>
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
                    <li class="active"><a href="#users-list" data-toggle="tab"><i class="fa fa-list"></i> List of Users</a></li>                    
                    <li class=""><a href="#users-add" data-toggle="tab"><i class="fa fa-plus-circle"></i> Add Users</a></li>
                </ul>
                <div id="userTabContent" class="tab-content">                    
                    <div class="tab-pane fade active in" id="users-list">
                        <div class="row">
                            <div class="col-md-12">                                
                                <div class="table-responsive">
                                    <?php
                                    $this->widget('zii.widgets.grid.CGridView', array(
                                        'id' => 'users-grid',
                                        'htmlOptions' => array('class' => 'dataTables_wrapper', 'role' => 'grid'),
                                        'dataProvider' => $model->search(1),
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
                                                'name' => 'user_name',
                                                'value' => '$data->user_name',
                                                'headerHtmlOptions' => array('style' => 'text-align: center;width:220px'),
                                                'htmlOptions' => array('style' => 'text-align:justify;'),
                                                'filter' => CHtml::activeTextField($model, 'user_name', array('placeholder' => $model->getAttributeLabel('user_name'), 'style' => 'font-style:italic', 'autocomplete' => 'off', 'class' => 'form-control'))
                                            ),
                                            array(
                                                'name' => 'user_email',
                                                'value' => '$data->user_email',
                                                'htmlOptions' => array('style' => 'text-align:justify;-ms-word-break: break-all;word-break: break-all;'),
                                                'filter' => CHtml::activeTextField($model, 'user_email', array('placeholder' => $model->getAttributeLabel('user_email'), 'style' => 'font-style:italic', 'autocomplete' => 'off', 'class' => 'form-control')),
                                                'headerHtmlOptions' => array('style' => 'text-align: center;width:220px'),
                                            ),
                                             array(
                                                'name' => 'phone',
                                                'value' => '$data->phone',
                                                'htmlOptions' => array('style' => 'text-align:justify;-ms-word-break: break-all;word-break: break-all;'),
                                                'filter' => CHtml::activeTextField($model, 'phone', array('placeholder' => $model->getAttributeLabel('phone'), 'style' => 'font-style:italic', 'autocomplete' => 'off', 'class' => 'form-control')),
                                                'headerHtmlOptions' => array('style' => 'text-align: center;width:220px'),
                                            ),
                                            array(
                                                'name' => 'skype',
                                                'value' => '$data->skype',
                                                'htmlOptions' => array('style' => 'text-align:justify;-ms-word-break: break-all;word-break: break-all;'),
                                                'filter' => CHtml::activeTextField($model, 'skype', array('placeholder' => $model->getAttributeLabel('skype'), 'style' => 'font-style:italic', 'autocomplete' => 'off', 'class' => 'form-control')),
                                                'headerHtmlOptions' => array('style' => 'text-align: center;width:220px'),
                                            ),
                                            array(
                                                'header' => 'Tickets',
                                                'value' => 'count(TicketAssign::model()->getTicketbyUser($data->user_id))',
                                                'type' => 'raw',
                                                'headerHtmlOptions' => array('style' => 'text-align: center;width:60px')
                                            ),
                                            array(
                                                'name' => 'user_department_id',
                                                'value' => 'Department::getDepartmentName($data->user_department_id)',
                                                'htmlOptions' => array('style' => 'text-align:center;'),
                                                'headerHtmlOptions' => array('style' => 'text-align: center;width:120px'),
                                                'filter' => CHtml::activeDropDownList($model, 'user_department_id', Department::getDepartmentList(), array('style' => 'font-style:italic', 'class' => 'form-control', 'empty' => 'Please Select'))
                                            ),
                                            array(
                                                'name' => 'user_role_type',
                                                'value' => 'UserRoles::getRoleName($data->user_role_type)',
                                                'htmlOptions' => array('style' => 'text-align:center;'),
                                                'headerHtmlOptions' => array('style' => 'text-align: center;width:120px'),
                                                'filter' => CHtml::activeDropDownList($model, 'user_role_type', UserRoles::getUserType(), array('style' => 'font-style:italic', 'class' => 'form-control', 'empty' => 'Please Select'))
                                            ),
                                            array(
                                                'header' => 'Created By',
                                                'headerHtmlOptions' => array('style' => 'text-align: center;width:130px'),
                                                'value' => 'Users::getUserName($data->user_created_by_id)',
                                                'htmlOptions' => array('style' => 'text-align:justify;'),
                                            //'filter' => CHtml::activeTextField($model, 'user_created_by_id', array('placeholder' => $model->getAttributeLabel('user_created_by_id'), 'style' => 'font-style:italic', 'autocomplete' => 'off', 'class' => 'form-control'))
                                            ),
                                            array(
                                                'name' => 'user_status',
                                                'type' => 'raw',
                                                'value' => '($data->user_status == 0) ? "<a  class=\"btn btn-xs btn-red\" title=\"Change Status\" onclick=\"change_status($data->user_id,1)\" href=\"javascript:void(0);\"><i class=\"fa fa-minus-square\"></i></a>" : "<a  class=\"btn btn-xs btn-green\" title=\"Change Status\" onclick=\"change_status($data->user_id,0)\" href=\"javascript:void(0);\">Change Status</a>"',
                                                'htmlOptions' => array('style' => 'text-align:center;'),
                                                'headerHtmlOptions' => array('style' => 'text-align: center;width:100px'),
                                                'filter' => CHtml::activeDropDownList($model, 'user_status', array(0 => "Inactive", 1 => 'Active'), array('style' => 'font-style:italic', 'class' => 'form-control', 'empty' => 'Please Select'))
                                            ),
                                            array(
                                                'header' => 'Action',
                                                'class' => 'CButtonColumn',
                                                'deleteConfirmation' => 'Do you want to delete this User Record?',
                                                'afterDelete' => 'function(link,success,data){ if(success) { $("#statusMsg").css("display", "block"); $("#statusMsg").html(data); $("#statusMsg").animate({opacity: 1.0}, 3000).fadeOut("fast");}}',
                                                'headerHtmlOptions' => array('style' => 'text-align: center;width:60px'),
                                                'htmlOptions' => array('style' => 'text-align:center;'),
                                                'template' => '{update}{viewTicket}',
                                                'buttons' => array
                                                    (
                                                    'update' => array
                                                        (
                                                        'label' => '<i class="fa fa-edit"></i>',
                                                        'options' => array('title' => 'Update'),
                                                        'imageUrl' => FALSE,
                                                        'url' => 'Yii::app()->createUrl("users/update", array("id" => base64_encode($data->user_id)))',
                                                    ),
                                                    'viewTicket' => array
                                                        (
                                                        'label' => ' <i class="fa fa-search"></i>',
                                                        'options' => array('title' => 'View Ticket'),
                                                        'imageUrl' => FALSE,
                                                        'url' => 'Yii::app()->createUrl("ticket/index", array("user_id" => base64_encode($data->user_id)))',
                                                    ),
                                                    'delete' => array
                                                        (
                                                        'label' => '<i class="fa fa-times"></i>',
                                                        'options' => array('title' => 'Delete', 'class' => 'remove'),
                                                        'imageUrl' => FALSE,
                                                        'url' => 'Yii::app()->createUrl("users/delete", array("id" => base64_encode($data->user_id)))',
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

                    <div class="tab-pane fade" id="users-add">                            
                        <div class="row">
                            <div class="col-md-12">

                                <?php $this->renderPartial('_form', array('model' => $model)); ?>

                            </div>
                        </div>
                    </div>
                </div>
            </div>            
        </div>        
    </div>    
</div>
<script type="text/javascript">
    function change_status(user_id, status) {
        if (status == "1") {
            msg = "Are you sure you want to Activate the user status?";
            aler_msg = "User Status has been Activated Successfully.";
        } else {
            msg = "Are you sure you want to Deactivate the user status?";
            aler_msg = "User Status has been Deactivated Successfully.";
        }
        var flag = confirm(msg);
        if (flag) {
            $.ajax({
                url: "<?php echo Yii::app()->request->baseUrl ?>/users/changestatus",
                data: {user_id: user_id, status: status},
                type: "POST",
                success: function (response) {

                    $('#users-grid').yiiGridView('update', {
                        data: $(this).serialize()
                    });
                    $('#statusMsg').fadeIn();
                    $("#statusMsg").html(aler_msg).addClass("alert alert-success");
                    setTimeout(function () {
                        $('#statusMsg').fadeOut();
                    }, 3000);
                }
            });
        }
    }
</script>