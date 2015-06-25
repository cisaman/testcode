<div class="view">   

    <div class="row">
        <div class="col-md-12">
            <h3 class="text-green"><?php echo CHtml::encode($model->coupon_code); ?></h3>
            <hr/>   
        </div>
    </div>

    <div class="table-responsive">
        <table class="table table-bordered table-responsive table-striped">            
            <tbody>
                <tr>
                    <th><?php echo CHtml::encode($model->getAttributeLabel('coupon_code')); ?></th>
                    <td><?php echo CHtml::encode($model->coupon_code); ?></td>                    
                </tr>
                <tr>
                    <th><?php echo CHtml::encode($model->getAttributeLabel('desc')); ?></th>
                    <td><?php echo CHtml::encode($model->desc); ?></td>                    
                </tr>
                <tr>
                    <th><?php echo CHtml::encode($model->getAttributeLabel('coupon_type')); ?></th>
                    <td><?php echo ($model->coupon_type == 1) ? 'Percentage' : 'Amount'; ?></td>
                </tr>
                <tr>
                    <th><?php echo CHtml::encode($model->getAttributeLabel('discount')); ?></th>
                    <td><?php echo ($model->coupon_type == 2) ? 'Rs. ' : ''; ?><?php echo CHtml::encode($model->discount); ?> <?php echo ($model->coupon_type == 1) ? '%' : ''; ?></td>
                </tr>
                <tr>
                    <th><?php echo CHtml::encode($model->getAttributeLabel('no_of_used')); ?></th>
                    <td><?php echo CHtml::encode($model->no_of_used); ?></td>                    
                </tr>
                <tr>
                    <th><?php echo CHtml::encode($model->getAttributeLabel('validate_to')); ?></th>

                    <td><?php echo CHtml::encode(date('d M Y ', strtotime($model->validate_to))); ?></td>        
                </tr>
                <tr>
                    <th><?php echo CHtml::encode($model->getAttributeLabel('validate_from')); ?></th>

                    <td><?php echo CHtml::encode(date('d M Y ', strtotime($model->validate_from))); ?></td>        
                </tr>
                <tr>
                    <th><?php echo CHtml::encode($model->getAttributeLabel('min_amt')); ?></th>
                    <td><?php echo CHtml::encode($model->min_amt); ?></td>
                </tr>                                
                <tr>
                    <th><?php echo CHtml::encode($model->getAttributeLabel('created_date')); ?></th>
                    <td><?php echo CHtml::encode(date('d M Y @ g:i A', strtotime($model->created_date))); ?></td>        
                </tr>                
                <tr>
                    <th><?php echo CHtml::encode($model->getAttributeLabel('updated_date')); ?></th>
                    <td><?php echo CHtml::encode(date('d M Y @ g:i A', strtotime($model->updated_date))); ?></td>  
                </tr>
                <tr>
                    <th><?php echo CHtml::encode($model->getAttributeLabel('status')); ?></th>
                    <td><?php echo ($model->status == 0) ? 'Inactive' : 'Active'; ?></td>
                </tr>
            </tbody>
        </table>
    </div>

</div>



<style type="text/css">    

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