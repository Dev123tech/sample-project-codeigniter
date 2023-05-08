<?php
	$physical_system   	 =  $this->crud_model->get_type_name_by_id('general_settings','68','value');
	$digital_system   	 =  $this->crud_model->get_type_name_by_id('general_settings','69','value');
	$status= '';
	$value= '';
	if($physical_system !== 'ok' && $digital_system == 'ok'){
		$status= 'digital';
		$value= 'ok';
	}
	if($physical_system == 'ok' && $digital_system !== 'ok'){
		$status= 'digital';
		$value= NULL;
	}
	if($physical_system !== 'ok' && $digital_system !== 'ok'){
		$status= 'digital';
		$value= '0';
	}
?>
<div>
	<?php
        echo form_open(base_url() . 'admin/coupon/do_add/', array(
            'class' => 'form-horizontal',
            'method' => 'post',
            'id' => 'coupon_add',
            'enctype' => 'multipart/form-data'
        ));
    ?>
        <div class="panel-body">

            <div class="form-group">
                <label class="col-sm-4 control-label" for="demo-hor-1"><?php echo translate('coupon_title');?></label>
                <div class="col-sm-6">
                    <input type="text" name="title" id="demo-hor-1" 
                        placeholder="<?php echo translate('title'); ?>" class="form-control required">
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-4 control-label" for="demo-hor-1"><?php echo translate('from');?></label>
                <div class="col-sm-6">
                    <input type="date" name="from" id="demo-hor-1" class="form-control">
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-4 control-label" for="demo-hor-1"><?php echo translate('valid_till');?></label>
                <div class="col-sm-6">
                    <input type="date" name="till" id="demo-hor-1" class="form-control">
                </div>
            </div>
            
            <div class="form-group">
                <label class="col-sm-4 control-label"><?php echo translate('coupon_discount_on');?></label>
                <div class="col-sm-6">
                    <?php
                        $cashback_product = $this->db->get_where('coupon')->result_array();
                        $already_add_product_arr = array();
                        $current_date = date('Y-m-d');

                        foreach($cashback_product as $key => $value) 
                        {
                            $already_add_product_ar = json_decode($value['spec']);

                            if(strtotime($value['till']) > strtotime($current_date))
                            {
                                $till_ar[] = strtotime($value['till']);

                                foreach(json_decode($already_add_product_ar->set) as $key => $productids) 
                                {
                                    $already_add_product_arr[] = array('productid'=>$productids,'discount_type'=>$already_add_product_ar->discount_type,'discount_value'=>$already_add_product_ar->discount_value);
                                }
                            }
                        }
                        function searchArrayKeyVal($sKey, $id, $array) {
                           foreach ($array as $key => $val) {
                               if ($val[$sKey] == $id) {
                                   return $key;
                               }
                           }
                           return false;
                        }
                    ?>
                    <select data-placeholder="<?php echo translate('choose_product');?>" name='product[]' class="demo-cs-multiselect" multiple tabindex="2">
                        <?php
                            $productKey = searchArrayKeyVal("productid", $row['product_id'], $already_add_product_arr);
                            $products = $this->db->get_where('product')->result_array();
                            foreach ($products as $row) 
                            {
                                $productKey = searchArrayKeyVal("productid", $row['product_id'], $already_add_product_arr);
                                if($productKey==false) 
                                {
                            ?>
                                <option value="<?php echo $row['product_id']; ?>"><?php echo $row['title']; ?></option>
                            <?php
                                }
                            }
                        ?>
                    </select>
                </div>        
            </div>
            
            <div class="form-group category" style="display:none;">
                <label class="col-sm-4 control-label"><?php echo translate('category');?></label>
                <div class="col-sm-6">
                    <?php
                        echo $this->crud_model->select_html('category','category','category_name','add','demo-cs-multiselect','',$status,$value); 
                    ?>
                </div>
            </div>
            
            <div class="form-group sub_category" style="display:none;">
                <label class="col-sm-4 control-label"><?php echo translate('sub_category');?></label>
                <div class="col-sm-6">
                    <?php 
                        echo $this->crud_model->select_html('sub_category','sub_category','sub_category_name','add','demo-cs-multiselect','',$status,$value); 
                    ?>
                </div>
            </div>
            
            <div class="form-group product" style="display:none;">
                <label class="col-sm-4 control-label"><?php echo translate('product');?></label>
                <div class="col-sm-6">
                    <?php 
						$status2= '';
						$value2= '';
						if($physical_system !== 'ok' && $digital_system == 'ok'){
							$status2= 'download';
							$value2= 'ok';
						}
						if($physical_system == 'ok' && $digital_system !== 'ok'){
							$status2= 'download';
							$value2= NULL;
						}
						if($physical_system !== 'ok' && $digital_system !== 'ok'){
							$status2= 'download';
							$value2= '0';
						}
                        echo $this->crud_model->select_html('product','product','title','add','demo-cs-multiselect','',$status2,$value2); 
                    ?>
                </div>
            </div>

            <!-- <div class="form-group">
                <label class="col-sm-4 control-label" for="demo-hor-1"><?php echo translate('coupon_code');?></label>
                <div class="col-sm-6">
                    <input type="text" name="code" id="demo-hor-1" 
                        placeholder="<?php echo translate('code'); ?>" class="form-control required">
                </div>
            </div> -->
            
            <div class="form-group">
                <label class="col-sm-4 control-label"><?php echo translate('discount_type');?></label>
                <div class="col-sm-6">
                    <?php
                        $array = array('percent','amount');
                        echo $this->crud_model->select_html($array,'discount_type','','add','demo-chosen-select required'); 
                    ?>
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-4 control-label" for="demo-hor-1"><?php echo translate('discount_value');?></label>
                <div class="col-sm-6">
                    <input type="number" name="discount_value" id="demo-hor-1" 
                        placeholder="<?php echo translate('discount_value'); ?>" class="form-control required">
                </div>
            </div>
        </div>
	</form>
</div>
<script src="<?php echo base_url(); ?>template/back/js/custom/brand_form.js"></script>
<script type="text/javascript">
    $('.chos').on('change',function(){
        var a = $(this).val();
        $('.product').hide('slow');
        $('.category').hide('slow');
        $('.sub_category').hide('slow');
        $('.'+a).show('slow');
    });
</script>
