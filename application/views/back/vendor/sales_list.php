<div class="panel-body" id="demo_s">
    <table id="demo-table" class="table table-striped"  data-pagination="true" data-show-refresh="true"  data-show-toggle="true" data-show-columns="true" data-search="true" >

        <thead>
            <tr>
                <th style="width:4ex"><?php echo translate('#');?></th>
                <th><?php echo translate('order');?><br>Id</th>
                <th><?php echo translate('Customer');?><br>Id</th>
                <th><?php echo translate('Country');?></th>
                <th><?php echo translate('wholesale');?></th>
                <th><?php echo translate('Shipping');?></th> 
                <th><?php echo translate('QTY');?></th> 

                <th><?php echo translate('Order');?><br>Placed</th> 
                <th><?php echo translate('Tracking');?><br>ID </th>
                <th><?php echo translate('Dispatch');?><br>Date</th> 
                <th><?php echo translate('Arrived');?><br>Date</th> 
                <th><?php echo translate('payment');?></th> 
                <th><?php echo translate('Release');?><br>Date</th> 

                <th class="text-right"><?php echo translate('options');?></th> 
            </tr>
        </thead>
            
        <tbody>
        <?php
        if($all_sales)
        {
            $i = 0;
            foreach($all_sales as $row){
                $i++;
        ?>
        <tr class="<?php if($row['viewed'] !== 'ok'){ echo 'pending'; } ?>" >
            <td><?php echo $i; ?></td>
            <td><?php echo $row['sale_id'];?></td>
            <td><?php echo $row['buyer']; ?></td>
            <td>
                <?php
                    if($row['country'] == 'AU')
                    {
                        echo "Australia";
                    }
                    else if($row['country'] == 'HK')
                    {
                        echo "HongKong";
                    }
                    else if($row['country'] == 'JP')
                    {
                        echo "Japan";
                    }
                    else if($row['country'] == 'SG')
                    {
                        echo "Singapore";
                    }
                ?>
            </td>
            <td>
                <?php 
                    if($row['wholesale']){
                        echo $whole_d = round($row['wholesale']/$row['qty'],2);
                    }
                    else{
                        echo "0";
                    }     

                ?>
            </td>

            <td><?php echo currency($row['shipping_cost']); ?></td>
            <td><?php echo $row['qty']; ?></td>
            <td><?php echo date('d M y H:i A',$row['sale_datetime']); ?></td>
            <td><?php echo $row['sale_code']; ?></td>
            <td></td>
            <td></td>
            <td><?php echo currency(($row['wholesale']*$row['qty'])+$row['shipping_cost']); ?></td>
            <td></td>
            <td class="text-right">

                <!-- <a class="btn btn-info btn-xs btn-labeled fa fa-file-text" data-toggle="tooltip" 
                    onclick="ajax_set_full('view','<?php echo translate('title'); ?>','<?php echo translate('successfully_edited!'); ?>','sales_view','<?php echo $row['sale_id']; ?>')" 
                        data-original-title="Edit" data-container="body"><?php echo translate('view'); ?>
                </a> -->
                
                <a class="btn btn-success btn-xs btn-labeled fa fa-wrench" data-toggle="tooltip" 
                    onclick="ajax_modal('delivery_payment','<?php echo translate('update'); ?>','<?php echo translate('successfully_edited!'); ?>','delivery_payment','<?php echo $row['sale_id']; ?>')" 
                        data-original-title="Edit" data-container="body">
                            <?php echo translate('update'); ?>
                </a>
                
                <!-- <a onclick="delete_confirm('<?php echo $row['sale_id']; ?>','<?php echo translate('really_want_to_delete_this?'); ?>')" 
                    class="btn btn-danger btn-xs btn-labeled fa fa-trash" data-toggle="tooltip" 
                        data-original-title="Delete" data-container="body"><?php echo translate('delete'); ?>
                </a> -->
            </td> 
        </tr>
        <?php
                
            }
        }    
        ?>
        </tbody>
    </table>
</div>  
   <!--  <div id='export-div' style="padding:40px;">
        <h1 id ='export-title' style="display:none;"><?php echo translate('sales'); ?></h1>
        <table id="export-table" class="table" data-name='sales' data-orientation='l' data-width='1500' style="display:none;">
                <colgroup>
                    <col width="50">
                    <col width="150">
                    <col width="150">
                    <col width="150">
                    <col width="250">
                </colgroup>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Sale Code</th>
                        <th>Buyer</th>
                        <th>Date</th>
                        <th>Total</th>
                    </tr>
                </thead>

                <tbody >
                <?php
                    $i = 0;
                    foreach($all_sales as $row){
                        if($this->crud_model->is_sale_of_vendor($row['sale_id'],$this->session->userdata('vendor_id'))){
                        $i++;
                ?>
                <tr>
                    <td><?php echo $i; ?></td>
                    <td>#<?php echo $row['sale_code']; ?></td>
                    <td><?php echo $this->crud_model->get_type_name_by_id('user',$row['buyer'],'username'); ?></td>
                    <td><?php echo date('d-m-Y',$row['sale_datetime']); ?></td>
                    <td><?php echo currency('','def').$this->cart->format_number($this->crud_model->vendor_share_in_sale($row['sale_id'],$this->session->userdata('vendor_id'))['total']); ?></td>               
                </tr>
                <?php
                        }
                    }
                ?>
                </tbody>
        </table>
    </div> -->
    
<style type="text/css">
    .pending{
        background: #D2F3FF  !important;
    }
    .pending:hover{
        background: #9BD8F7 !important;
    }
</style>



           