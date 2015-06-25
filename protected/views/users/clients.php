<?php
$this->pageTitle = Yii::app()->name . ' | Manage Clients';

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
    $('.search-form').toggle();
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
            <ol class="breadcrumb">
                <li><h1><i class="fa fa-user"></i> Manage Clients</h1></li>
            </ol>
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
                    <li class="active"><a href="#client-list" data-toggle="tab">List of Clients</a></li>

                </ul>
                <div id="userTabContent" class="tab-content">                                       

                    <div class="tab-pane fade active in" id="client-list">
                        <div class="row">
                            <div class="col-md-12">                                
                                <div class="table-responsive">
                                    <?php
                                    $this->widget('zii.widgets.grid.CGridView', array(
                                        'id' => 'clients-grid',
                                        'htmlOptions' => array('class' => 'dataTables_wrapper', 'role' => 'grid'),
                                        'dataProvider' => $model->search(2),
                                        'filter' => $model,
                                        'columns' => array(
                                            array(
                                                'header' => 'S. No.',
                                                'name' => 'S. No.',
                                                'value' => '$this->grid->dataProvider->pagination->currentPage * $this->grid->dataProvider->pagination->pageSize + ($row+1)',
                                                'htmlOptions' => array('style' => 'text-align:center'),                                              
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
                                                'header' => 'Orders',
                                                'value' => 'Orders::model()->getCountOrderbyClient($data->user_id)',
                                                'type' => 'raw',
                                                'headerHtmlOptions' => array('style' => 'text-align: center;width:130px')
                                            ),
                                            array(
                                                'header' => 'Created By',
                                                'value' => 'Users::getUserName($data->user_created_by_id)',
                                                'htmlOptions' => array('style' => 'text-align:justify;'),
                                                'filter' => CHtml::activeTextField($model, 'user_email', array('placeholder' => $model->getAttributeLabel('user_created_by_id'), 'style' => 'font-style:italic', 'autocomplete' => 'off', 'class' => 'form-control'))
                                            ),
                                            array(
                                                'name' => 'user_status',
                                                'value' => '($data->user_status == 0) ? "Inactive" : "Active"',
                                                'htmlOptions' => array('style' => 'text-align:center;'),
                                                'headerHtmlOptions' => array('style' => 'text-align: center;width:100px'),
                                                'filter' => CHtml::activeDropDownList($model, 'user_status', array(0 => "Inactive", 1 => 'Active'), array('style' => 'font-style:italic', 'class' => 'form-control', 'empty' => 'Please Select Status'))
                                            ),
                                            array(
                                                'header' => 'Action',
                                                'class' => 'CButtonColumn',
                                                'deleteConfirmation' => 'Do you want to delete this User Record?',
                                                'afterDelete' => 'function(link,success,data){ if(success) { $("#statusMsg").css("display", "block"); $("#statusMsg").html(data); $("#statusMsg").animate({opacity: 1.0}, 3000).fadeOut("fast");}}',
                                                'headerHtmlOptions' => array('style' => 'text-align: center;width:90px'),
                                                'htmlOptions' => array('style' => 'text-align:center;'),
                                                'template' => '{update} {viewTicket}',
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
                                                        'options' => array('title' => 'View Orders'),
                                                        'imageUrl' => FALSE,
                                                        'url' => 'Yii::app()->createUrl("ticket/index", array("client" => base64_encode($data->user_id)))',
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
                                        'itemsCssClass' => 'table table-striped table-bordered table-hover table-green dataTable',
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

                </div>
            </div>            
        </div>        
    </div>    
</div>