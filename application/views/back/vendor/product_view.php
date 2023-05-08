<!--CONTENT CONTAINER-->
<?php 
		foreach($product_data as $row)
        { 
?>

<h4 class="modal-title text-center padd-all"><?php echo translate('details_of');?> <?php echo $row['title'];?></h4>
	<hr style="margin: 10px 0 !important;">
    <div class="row">
    <div class="col-md-12">
        <div class="text-center pad-all">
            <div class="col-md-3">
                <div class="col-md-12">
                    <?php
                        if($row['num_of_imgs'] !=NULL)
                        {
                            $num_of_img = explode(",", $row['num_of_imgs']); 
                            $first_image = base_url('uploads/product_image/'.$num_of_img[0]);
                        }
                        else
                        {
                            $first_image = base_url('uploads/product_image/default.jpg');
                        }    
                        ?>
                    <img class="img-responsive thumbnail" alt="Profile Picture" src="<?php echo $first_image; ?>">
                </div>
                <!--<div class="col-md-12" style="text-align:justify;">-->
                <!--    <p><?php //echo $row['description'];?></p>-->
                <!--</div>-->
            </div>
            <div class="col-md-9">   
                <table class="table table-striped" style="border-radius:3px;">
                    <tr>
                        <th class="custom_td"><?php echo translate('name');?></th>
                        <td class="custom_td"><?php echo $row['title']?></td>
                    </tr>
                    <tr>
                        <th class="custom_td"><?php echo translate('category');?></th>
                        <td class="custom_td">
                            <?php echo $this->crud_model->get_type_name_by_id('category',$row['category'],'category_name');?>
                        </td>
                    </tr>
                    <tr>
                        <th class="custom_td"><?php echo translate('sub-category');?></th>
                        <td class="custom_td">
                            <?php echo $this->crud_model->get_type_name_by_id('sub_category',$row['sub_category'],'sub_category_name');?>
                        </td>
                    </tr>
                    
                    <tr>
                        <th class="custom_td"><?php echo translate('brand');?></th>
                        <td class="custom_td">
                            <?php 
                            
                            $brands = $this->db->get_where('vendorbrands',array('user_id'=> $this->session->userdata('vendor_id'),'id'=> $row['brand']))->row();
                            if(!empty($brands))
                                echo $brands->name;
                            //echo $this->crud_model->get_type_name_by_id('brand',$row['brand']); 
                            ?>
                        </td>
                    </tr>

                    <tr>
                        <th class="custom_td"><?php echo translate('unit');?></th>
                        <td class="custom_td"><?php echo $row['unit']; ?></td>
                    </tr>
                    <tr>
                        <th class="custom_td"><?php echo translate('bundle_sale_price');?></th>
                        <td class="custom_td"><?php echo $row['sale_price_AU']; ?></td>
                    </tr>
                    <tr>
                        <th class="custom_td"><?php echo translate('Wholesale (INCL GST + WET)');?></th>
                        <td class="custom_td"><?php echo $row['wholesale']; ?></td>
                    </tr>
                     <tr>
                      <th class="custom_td"><?php echo translate('Wholesale (EXCL WET & GST)');?></th>
                        <td class="custom_td"><?php echo $row['wholesale_EXCL_WET_GST']; ?></td>
                    </tr>
                   <!--  <?php if($row['shipping_cost'] != ''){ ?>
                    <tr>
                        <th class="custom_td"><?php echo translate('shipping_cost');?></th>
                        <td class="custom_td"><?php echo $row['shipping_cost']; ?> / <?php echo $row['unit']; ?></td>
                    </tr>
                    <?php } if($row['shipping_cost'] != ''){ ?>
                    <tr>
                        <th class="custom_td"><?php echo translate('tax');?></th>
                        <td class="custom_td">
                            <?php echo $row['tax']; ?>
                            <?php if($row['tax_type'] == 'percent'){ echo '%'; } elseif($row['tax_type'] == 'amount'){ echo '$'; } ?>
                            / <?php echo $row['unit']; ?>
                        </td>
                    </tr> -->
                    <?php } if($row['discount'] != ''){ ?>
                    <!--<tr>-->
                    <!--    <th class="custom_td"><?php// echo translate('discount');?></th>-->
                    <!--    <td class="custom_td">-->
                    <!--        <?php //echo $row['discount']; ?>-->
                    <!--        <?php //if($row['discount_type'] == 'percent'){ echo '%'; } elseif($row['discount_type'] == 'amount'){ echo '$'; } ?>-->
                    <!--        / <?php //echo $row['unit']; ?>-->
                    <!--    </td>-->
                    <!--</tr>-->
                    <?php } ?>
                    <tr>
                        <th class="custom_td"><?php echo translate('Limited Release');?></th>
                        <td class="custom_td"><?php echo ucwords($row['featured']); ?></td>
                    </tr>
                    <tr>
                        <th class="custom_td"><?php echo translate('Highlights');?></th>
                        <td class="custom_td">
                            <?php foreach(explode(',',$row['tag']) as $tag){ ?>
                                <?php echo $tag; ?>
                            <?php } ?>
                        </td>
                    </tr>
                    <tr>
                        <th class="custom_td"><?php echo translate('status');?></th>
                        <td class="custom_td">
                            <?php  
                                if($row['status'] == 'ok')
                                {
                                    echo "Published";
                                }
                                else{
                                    echo "Not Published";
                                }
                            ?>
                        </td>
                    </tr>
                    
                    <?php
                        $all_af = $this->crud_model->get_additional_fields($row['product_id']);
                        $all_c = json_decode($row['color']);
                    ?>
                    <!-- <tr>
                        <th class="custom_td"><?php echo translate('colors');?></th>
                        <td class="custom_td">
                            <?php 
                                if($all_c){
                                    foreach($all_c as $p){
                            ?>
                                <div style="background-color:<?php echo $p; ?>; width:30px; height:30px; margin:5px; border: 1px solid grey; float:left;"></div>
                            <?php
                                    }
                                }
                            ?>
                        </td>
                    </tr> -->
                    
                    <?php
                        if(!empty($all_af)){
                            foreach($all_af as $row1){
                    ?>
                    <tr>
                        <th class="custom_td"><?php echo $row1['name']; ?></th>
                        <td class="custom_td"><?php echo $row1['value']; ?></td>
                    </tr>
                    <?php
                            }
                        }
                    ?>
                </table>
            </div>
            <hr>
        </div>
    </div>
</div>				

<?php 
	}
?>
            
<style>
.custom_td{
border-left: 1px solid #ddd;
border-right: 1px solid #ddd;
border-bottom: 1px solid #ddd;
}
</style>

<script>
	$(document).ready(function(e) {
		proceed('to_list');
	});
</script>