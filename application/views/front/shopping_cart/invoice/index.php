
<section class="page-section invoice">
    <div class="breadcrumb-area">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="breadcrumb-content">
                        <ul class="nav">
                            <li><a href="<?php echo base_url(); ?>">Home</a></li>
                            <li>Invoice Details</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
    <?php
        $sale_details = $this->db->get_where('sale',array('sale_id'=>$sale_id))->result_array();
          
        foreach($sale_details as $row){
        ?>
    <div class="row">
        <div class="offset-xl-2 col-xl-8 col-lg-12 col-md-12 col-sm-12 col-12 padding invoice_rec">
            <div class="card">
                <div class="card-header p-4">
                    <a class="pt-2 d-inline-block" href="<?php echo base_url(); ?>" data-abc="true"><img class="img-responsive" src="<?php echo base_url(); ?>uploads/logo_image/logo_<?php echo $home_top_logo; ?>.png" alt="logo.png"></a>
                    <div class="float-right">
                        <?php if($invoice == "guest") {?>
                        <h3 class="mb-0"><?php echo translate('guest_id'); ?> : <span><?php echo $row['guest_id']; ?></span></h3>
                        <h3 class="mb-0"><?php echo translate('invoice'); ?> : #<span><?php echo $row['sale_code']; ?></span></h3>
                        <?php }
                            else{ 
                             ?>
                        <h3 class="mb-0"><?php echo translate('user_id'); ?>  : <span><?php echo $row['buyer']; ?></span></h3>
                        <h3 class="mb-0"><?php echo translate('invoice'); ?> : #<span><?php echo $row['sale_code']; ?></span></h3>
                        <?php
                            }
                            ?>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row mb-4 invoi_brdr">
                        <div class="col-sm-5">
                            <h5 class="mb-3"><?php echo translate('billed_to'); ?> :</h5>
                            <p><?php $info = json_decode($row['shipping_address'],true); ?></p>
                            <h3 class="text-dark mb-1">
                                <p> <?php echo ucwords($info['first_name']." ".$info['last_name']); ?> </p>
                            </h3>
                            <p> <?php if($info['address1']) { echo $info['address1']; } ?> <?php  if($info['address1'] != NULL) { echo ", ";  }
                                if($info['address2']) { echo $info['address2']; } if( ($info['address1'] != NULL) || ($info['address2'] != NULL) )  { echo ", ";  }
                                if($info['city']) { echo $info['city']; }  if( ($info['address1'] != NULL) || ($info['address2'] != NULL) || ($info['city'] != NULL) )  { echo ", ";  }
                                if($info['state']) { echo $info['state']; }  if( ($info['address1'] != NULL) || ($info['address2'] != NULL) || ($info['city'] != NULL) || ($info['state'] != NULL) )  { echo ", ";  }
                                if($info['country']) { echo $info['country']; } ?> </p>
                            <p><b> <?php echo translate('e-mail');?> : </b><?php echo $info['email']; ?> </p>
                            <p><b> <?php echo translate('phone'); ?> : </b> <?php echo $info['phone']; ?> </p>
                        </div>
                        <div class="col-sm-5 offset-sm-2">
                            <h5 class="mb-3"> <?php echo translate('shipped_to'); ?> :</h5>
                            <p><?php $info = json_decode($row['shipping_address'],true); ?></p>
                            <h3 class="text-dark mb-1">
                                <p> <?php echo ucwords($info['deleivery_first_name']." ".$info['deleivery_last_name']); ?> </p>
                            </h3>
                            <p> <?php echo ($info['deleivery_address1']) ? ($info['deleivery_address1']) : $info['address1'];  ?> <?php echo ($info['deleivery_address2']) ? (", ".$info['deleivery_address2']) : ", ".$info['address1'];  if($info['deleivery_city']) { echo ", ".$info['deleivery_city']; } else { echo ", ".$info['city']; } 
                                if($info['deleivery_state']) { echo ", ".$info['deleivery_state']; } else { echo ", ".$info['state']; } 
                                if($info['deleivery_country']) { echo ", ".$info['deleivery_country']; } else { echo ", ".$info['country']; }?>  </p>
                            <p><b> <?php echo translate('e-mail');?> : </b><?php echo ($info['deleivery_email']) ? ($info['deleivery_email1']) : $info['email'];  ?></p>
                            <p><b> <?php echo translate('phone'); ?> : </b> <?php echo ($info['deleivery_phone']) ? ($info['deleivery_phone1']) : $info['phone'];  ?> </p>
                        </div>
                    </div>
                    <div class="row mb-4 invoi_brdr">
                        <div class="col-sm-6">
                            <h5 class="mb-3"> <?php echo translate('payment_details'); ?> :</h5>
                            <h3 class="pay_sta mb-1"><?php echo translate('payment_status'); ?> :<span> <?php echo translate($this->crud_model->sale_payment_status($row['sale_id'])); ?></span></h3>
                            <h3 class="pay_sta mb-1"><?php echo translate('payment_method'); ?> :<span><?php if($info['payment_type'] == 'c2'){
                                echo 'TwoCheckout';
                                }else{
                                echo ucfirst(str_replace('_', ' ', $info['payment_type'])); 
                                }?></span></h3>
                        </div>
                        <div class="col-sm-3 offset-sm-3">
                            <h5 class="mb-3"> <?php echo translate('order_date'); ?> :</h5>
                            <h3 class="pay_sta mb-1"><span>  <?php echo date('d M, Y',$row['sale_datetime'] );?></span></h3>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <table class="table table-dark table-stripped table-hover">
                                <thead>
                                    <th colspan="12"><?php echo translate('payment_invoice');?></th>
                                </thead>
                                <thead>
                                    <th><?php echo translate('no');?></th>
                                    <th><?php echo translate('item');?></th>
                                    <th><?php echo translate('options');?></th>
                                    <th><?php echo translate('quantity');?></th>
                                    <th><?php echo translate('price');?></th>
                                    <th><?php echo translate('total');?></th>
                                </thead>
                                <tbody>
                                    <?php
                                        $product_details = json_decode($row['product_details'], true);
                                        $i =0;
                                        $total = 0;
                                        foreach ($product_details as $row1) 
                                        {
                                            $i++;
                                        ?>
                                            <tr class="text-center">
                                                <td><?php echo $i; ?></td>
                                                <td><?php echo $row1['name']; ?></td>
                                                <td><?php
                                                        $optiondata = json_decode($row1['option'],true);
                                                        if($optiondata['variationid'] =='1')
                                                        {
                                                            echo "Each";
                                                        }
                                                        if($optiondata['variationid'] =='2')
                                                        {
                                                            echo "Six";
                                                        }
                                                        if($optiondata['variationid'] =='3')
                                                        {
                                                            echo "Twelve";
                                                        }
                                                 ?> </td>
                                                <td><?php echo $optiondata['variationqty']; ?></td>
                                                <td><?php echo currency($row1['price']); ?></td>
                                                <td><?php echo currency($row1['subtotal']); 
                                                    $total += $row1['subtotal']; 
                                                    ?></td>
                                            </tr>
                                    <?php
                                        }
                                        ?>
                                    <tr>
                                        <td colspan="4"></td>
                                        <td class="right">
                                            <strong class="text-dark">  <?php echo translate('sub_total_amount');?> :</strong>
                                        </td>
                                        <td class="center"><?php echo currency($total);?></td>
                                    </tr>
                                    <tr>
                                        <td colspan="4"></td>
                                        <td class="right">
                                            <strong class="text-dark"><?php echo translate('shipping');?> :</strong>
                                        </td>
                                        <td class="center"><?php echo currency($row['shipping']);?></td>
                                    </tr>
                                    <tr>
                                        <td colspan="4"></td>
                                        <td class="right">
                                            <strong class="text-dark"><?php echo translate('grand_total');?> :</strong> 
                                        </td>
                                        <td class="center">
                                            <strong class=""><?php echo currency($row['grand_total']);?></strong>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php } ?>
    </div>
</section>
<script>
    function print_invoice(){
        window.print();
    }
</script>
<style type="text/css">    
    @media print {
    .top-bar{
    display: none !important;
    }
    header{
    display: none !important;
    }
    footer{
    display: none !important;
    }
    .to-top{
    display: none !important;
    }
    .btn_print{
    display: none !important;
    }
    .invoice{
    padding: 0px;
    }
    .table{
    margin:0px;
    }
    address{
    margin-bottom: 0px;
    border:1px solid #fff !important;
    }
    }
</style>