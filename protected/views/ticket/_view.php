<div class="view">   

    <div class="row">
        <div class="col-md-12">
            <div id="ticket_portlet" class="ticket_portlet">
                <div class="row">
                    <div class="col-xs-2 ticket_icon">
                        <i class="fa fa-ticket fa-5x"></i>
                    </div>
                    <div class="col-xs-5">
                        <h2><?php echo CHtml::encode($model->ticket_title); ?></h2>
                        <div class="project_meta_details">
                            <?php
                            $orderDetails = Orders::model()->findByAttributes(array("order_id" => $model->order_id));
                            $Total_amount = $orderDetails['currency'] . " " . $orderDetails['order_total'];
                            $attrList = json_decode($orderDetails['order_Data']);
                            $coupon_id = $orderDetails['coupon_id'];
                            $couponDetails = Coupons::model()->findByAttributes(array("id" => $coupon_id));
                            $clientInfo = $attrList->userdata;
                            $days = round($attrList->numofworkingday / 8);

                            $fwdby = TicketAssign::model()->findByAttributes(array('ticket_id' => $ticket_id, 'fwd_to' => Yii::app()->session['user_data']['user_id'], 'status' => 1));
                            $fwd_name = '';
                            if (!empty($fwdby)) {
                                $fwd_name = ucfirst(Users::model()->getUserName($fwdby->fwd_by));
                            }
                            ?>                           
                            <p>Client: <strong><a href=""></a> <?php echo ucfirst(Users::model()->getUserName($orderDetails['client_id'])) ?></strong></p>                            
                            <p>Priority: <strong><?php echo ucfirst($attrList->order->priority); ?></strong></p>
                            <p>Working Day(s): <strong><?php echo $days ?> Day(s)</strong></p>
                            <?php if (!empty($fwd_name)) { ?>
                                <p>Assigned By: <strong><?php echo $fwd_name ?></strong></p>
                            <?php } ?>
                            <p>Created On: <strong><?php echo CHtml::encode(date('d M Y @ g:i A', strtotime($model->created_date))); ?></strong></p>
                            <p>Updated On: <strong><?php echo CHtml::encode(date('d M Y @ g:i A', strtotime($model->updated_date))); ?></strong></p>                            
                            <p>Status: <strong id="ticketStatusUpdate"><?php echo TicketStatus::getStatusName($model->ticket_status) ?></strong></p>
                        </div>
                    </div> 
                    <?php if ($clientInfo->userFile != "" || $clientInfo->userLink != "") {
                        ?>
                        <div class="col-xs-5 text-right">
                            <h4 title="client provided information">Additional Information</h4>
                            <?php if ($clientInfo->userFile != "") { ?>
                                <p>
                                    <a href="<?php echo Yii::app()->request->baseUrl . "/ticket/downloadZip/" . base64_encode($model->order_id); ?>"><h4>Download Attachments</h4></a>
                                </p>
                            <?php } ?>
                            <?php if ($clientInfo->userLink != "") { ?>
                                <p>
                                <h5>Reference Links :</h5>
                                <ul style="list-style: none">
                                    <?php
                                    $links = explode(",", rtrim($clientInfo->userLink, ","));
                                    foreach ($links as $link) {
                                        ?>
                                        <li><?php echo $link; ?></li>

                                    <?php } ?>
                                </ul>


                            <?php } ?>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>

    <div class="table-responsive">
        <table class="table table-bordered table-responsive table-striped">            
            <tbody>
                <tr>
                    <th><?php echo CHtml::encode($model->getAttributeLabel('description')); ?></th>
                    <td style="max-width: 200px; word-wrap: break-word;"><?php echo CHtml::encode($model->description); ?></td>                    
                </tr>                        
                <tr>
                    <th><?php echo CHtml::encode($model->getAttributeLabel('order_id')); ?></th>
                    <td><?php echo CHtml::encode($model->order_id); ?></td>                    
                </tr>
                <tr>
                    <th>Product Option </th>
                    <td>
                        <?php
                        if (!empty($attrList->order->commonAtt)) {
                            ?>
                            <ul class="tt">
                                <?php foreach ($attrList->order->commonAtt as $key => $val) { ?>

                                    <li><?php echo $val->attr->attribute . ' : <b >' . ucfirst($val->used); ?></b></li>                                          

                                <?php } ?>

                            </ul>
                        <?php } ?>
                    </td>                    
                </tr> 
                <tr>
                    <th> HTML/CSS, JavaScript options </th>
                    <td>
                        <?php
                        //print_r($attrList->order->html);die;
                        if (!empty($attrList->order->html)) {
                            ?>
                            <ul class="tt">
                                <?php foreach ($attrList->order->html as $key => $val) { ?>

                                    <li>
                                        <?php echo '<strong>' . ucfirst($key) . '</strong>'; ?>
                                        <?php if ($key == "markup") { ?>
                                            <?php if (!empty($val)) { ?>
                                                <ul>                                                  
                                                    <?php foreach ($val as $key1 => $v1) { ?>
                                                        <li>
                                                            <b><?php echo ucfirst($key1); ?></b>
                                                            <?php if (count($v1) > 0) { ?>
                                                                <ul>
                                                                    <?php foreach ($v1 as $v2) { ?>

                                                                        <li><?php echo $v2->attr . ' : <b>' . ucfirst($v2->used); ?></b></li>    
                                                                        <?php if (!empty($v2->subattr)) { ?>
                                                                            <li><?php echo $v2->subattr; ?></li>        
                                                                        <?php } ?>
                                                                    <?php } ?>
                                                                </ul>
                                                            <?php } ?>
                                                        </li>        
                                                    <?php } ?>                                                
                                                </ul>
                                            <?php } ?>
                                            <?php
                                        } else {
                                            ?>
                                            <ul>
                                                <?php foreach ($val as $v3) {
                                                    ?>

                                                    <li><?php echo $v3->attr . ' : <b>' . ucfirst($v3->used); ?></b></li>    
                                                    <?php if (!empty($v2->subattr)) { ?>
                                                        <li><?php echo $v2->subattr; ?></li>        
                                                    <?php } ?>  
                                                <?php } ?>
                                            </ul>
                                        <?php } ?>


                                    </li>
                                <?php } ?>

                            </ul>
                        <?php } ?>
                    </td>                    
                </tr> 
                <tr>
                    <th>Coupon(if applied) </th>
                    <td ><?php
                        if ($couponDetails) {
                            echo "Yes";
                        } else {
                            echo "No";
                        }
                        ?></td>                    

                </tr> 
                <?php if ($couponDetails) { ?>
                    <tr>
                        <th>Coupon Code </th>
                        <td ><?php echo $couponDetails['coupon_code'] ?> </td>                    
                    </tr> 
                    <tr>
                        <th>Coupon Type </th>
                        <td ><?php
                            if ($couponDetails['coupon_type'] == 1) {
                                echo ' Percentage';
                            } else {
                                echo 'Amount';
                            }
                            ?> </td>                    
                    </tr> 
                    <tr>
                        <th><?php
                            if ($couponDetails['coupon_type'] == 1) {
                                echo ' Percentage (%)';
                            } else {
                                echo 'Amount';
                            }
                            ?> </th>
                        <td ><?php echo $couponDetails['discount'] ?> </td>                    
                    </tr> 
                <?php } ?>
                <tr>
                    <th>Total </th>
                    <td ><?php echo $Total_amount ?> </td>                    
                </tr>
            </tbody>
        </table>        
    </div>

</div>



<style type="text/css">    

    .ticket_portlet {
        background: none repeat scroll 0 0 #fff9f3;
        border: 1px solid #ddd;
        border-radius: 5px;
        margin: 10px 0;
        padding: 10px;
    }
    .ticket_icon {
        margin-top: 25px;
        text-align: center;
        color:<?php echo TicketStatus::model()->getTicketColorName($model->ticket_status); ?>;
    }

    .tt li{
        margin-bottom: 5px;
    }

    th{
        width: 200px;
    }

    @media (min-width:320px) and (min-width:360px) {
        .view {
            padding: 0 !important;
        }
    }

    @media (min-width:361px){
        .view {
            padding: 0 30px !important;
        }
    }   
</style>
<style type="text/css">
    .forall {       
        margin: 0px; 
        padding: 1px 5px;
        border: 1px solid;
        border-radius: 3px; 
        text-transform: uppercase;
    }
    table td {
        vertical-align: middle !important;
    }
</style>
<script type="text/javascript">
    $(function () {
        $('#getTicketStatus').click(function () {

            $.ajax({
                url: "<?php echo Yii::app()->request->baseUrl ?>/ticket/getStatusName",
                data: ({ticket_id: <?php echo $ticket_id ?>}),
                type: "POST",
                dataType: 'JSON',
                success: function (response) {
                    $("#ticketStatusUpdate").html(response.name);
                    $('.ticket_icon').css('color', response.color);
                }
            });

        });
    });

</script>