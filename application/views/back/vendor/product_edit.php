<?php
    foreach($product_data as $row){
        // echo "<pre>";
        // print_r($row);
        // // exit;
?>
<div class="row">
    <div class="col-md-12">
        <?php
            echo form_open(base_url() . 'vendor/product/update/' . $row['product_id'], array(
                'class' => 'form-horizontal',
                'method' => 'post',
                'id' => 'product_edit',
                'enctype' => 'multipart/form-data'
            ));
        ?>
            <!--Panel heading-->
            <div class="panel-heading">
                <div class="panel-control" style="float: left;">
                    <ul class="nav nav-tabs">
                        <li class="active">
                            <a data-toggle="tab" href="#product_details"><?php echo translate('product_details'); ?></a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="panel-body">
                <div class="tab-base">
                    <!--Tabs Content-->                    
                    <div class="tab-content">
                        <div id="product_details" class="tab-pane fade active in">
                            <div class="form-group btm_border">
                                <label class="col-sm-4 control-label" for="demo-hor-12"><?php echo translate('images');?></label>
                                <div class="col-sm-6">
                                    <span class="pull-left btn btn-default btn-file"> <?php echo translate('choose_file');?>
                                        <input type="file"  multiple name="images[]" onchange="preview(this);" id="demo-hor-inputpass" class="form-control <?php if($row['num_of_imgs']=="NULL"){echo "required"; } ?> ">
                                    </span>

                                    <br><br>
                                    <span id="previewImg" ></span>
                                </div>
                            </div>

                            <div class="form-group btm_border">
                                <label class="col-sm-4 control-label" for="demo-hor-13"></label>
                                <div class="col-sm-6">
                                    <?php 
                                        $images = explode(",",$row['num_of_imgs']);
                                        if($row['num_of_imgs'])
                                        {
                                            foreach ($images as $value)
                                            {
                                                ?>
                                                    <div class="delete-div-wrap">
                                                         <a href="javascript:void(0);" data-product-id="<?php echo $row['product_id']; ?>" data-id="<?php echo $value; ?>" class="delete-product-img close">&times;</a>    
                                                        <div class="inner-div">
                                                            <img class="img-responsive" width="100" src="<?php echo  base_url('/uploads/product_image/'.$value); ?>" alt="Product Image" >
                                                        </div>
                                                    </div>
                                                <?php 
                                            }
                                        }
                                        else
                                        {
                                            ?>
                                            <div class="delete-div-wrap">
                                                <div class="inner-div">
                                                    <img class="img-responsive" width="100" src="<?php echo  base_url('/uploads/product_image/default.jpg'); ?>" alt="Product Image" >
                                                </div>
                                            </div>
                                            <?php
                                        } 
                                    ?>
                                    <input type="hidden" name="last_products_images" value="<?php echo $row['num_of_imgs']; ?>">
                                </div>
                            </div>
                            <div class="form-group btm_border">
                                <label class="col-sm-4 control-label" for="demo-hor-2"><?php echo translate('category');?></label>
                                <div class="col-sm-6">
                                    <?php echo $this->crud_model->select_html('category','category','category_name','edit','demo-chosen-select required',$row['category'],'digital',NULL,'get_cat'); ?>
                                </div>
                            </div>
                            <div class="form-group btm_border" >
                                <label class="col-sm-4 control-label" for="demo-hor-3"><?php echo translate('sub-category');?></label>
                                <div class="col-sm-6" id="sub_cat">
                                    <?php echo $this->crud_model->select_html('sub_category','sub_category','sub_category_name','edit','demo-chosen-select ',$row['sub_category'],'category',$row['category'],'get_brnd'); ?>
                                </div>
                            </div>

                            <div class="form-group btm_border" >
                                <label class="col-sm-4 control-label" for="demo-hor-4"><?php echo translate('brand');?></label>
                                <div class="col-sm-6" >
                                    <select class="demo-chosen-select form-control required"  name="brand">
                                        <option value="">Select...</option>
                                        <?php
                                        $brands = $this->db->get_where('vendorbrands',array('user_id'=> $this->session->userdata('vendor_id')))->result_array();
                                        foreach ($brands as $key => $value) 
                                        {
                                            ?>
                                            <option <?php if($row['brand']==$value['id']) { echo "selected"; } ?>  value="<?php echo $value['id']; ?>"><?php echo $value['name']; ?></option>
                                            <?php
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group btm_border">
                                <label class="col-sm-4 control-label" for="demo-hor-84"><?php echo translate('variety');?></label>
                                <div class="col-sm-6">
                                    <input type="text" name="variety" id="demo-hor-84" value="<?php echo $row['variety']; ?>" placeholder="<?php echo translate('variety');?>" class="form-control required">
                                </div>
                            </div>
                            <div class="form-group btm_border">
                                <label class="col-sm-3 control-label" for="demo-hor-1"><?php echo "Product Name"; ?></label>
                                <div class="col-sm-3">
                                    <input type="text" name="title" id="demo-hor-1" placeholder="<?php echo "Product Name"; ?>" value="<?php echo $row['title']; ?>" class="form-control required"><span style="color: grey">English</span>
                                </div>
                                <div class="col-sm-3">
                                    <input type="text" name="title_ch" id="demo-hor-1" placeholder="<?php echo "Product Name"; ?>" value="<?php echo $row['title_ch']; ?>" class="form-control"><span style="color: grey">Chinese</span>
                                </div>
                                <div class="col-sm-3">
                                    <input type="text" name="title_jp" id="demo-hor-1" placeholder="<?php echo "Product Name"; ?>" value="<?php echo $row['title_jp']; ?>" class="form-control"><span style="color: grey">Japanese</span>
                                </div>
                            </div>
                            <div class="form-group btm_border">
                                <label class="col-sm-4 control-label" for="demo-hor-83"><?php echo translate('product_year');?></label>
                                <div class="col-sm-4">
                                    <input type="number" name="product_year" id="demo-hor-83" min="0" value="<?php echo $row['product_year']; ?>" placeholder="<?php echo translate('_e.g._2016,_2017,_etc.'); ?>" class="form-control">
                                </div>
                            </div>

                            <div class="form-group btm_border">
                                <label class="col-sm-4 control-label" for="demo-hor-83"><?php echo translate('regions');?></label>
                                <div class="col-sm-4">
                                    <input type="text" name="regions" id="demo-hor-83" min="0" value="<?php echo $row['regions']; ?>" placeholder="<?php echo translate('_e.g._Barrosa valley,_Hunter valley,_etc.'); ?>" class="form-control">
                                </div>
                            </div>
                            <div   class="form-group btm_border">
                                <label class="col-sm-4 control-label" for="demo-hor-5"><?php echo "Volume (ml)";?></label>
                                <div class="col-sm-4">
                                    <input type="text" name="unit" id="demo-hor-5" value="<?php echo $row['unit']; ?>" placeholder="<?php echo translate('Volume (ml)'); ?>" class="form-control">
                                </div>
                            </div>
                            <div class="form-group btm_border">
                                <label class="col-sm-4 control-label" for="demo-hor-82"><?php echo translate('product_abv').' (%)';?></label>
                                <div class="col-sm-4">
                                    <input type="number" name="product_abv" id="demo-hor-82" min="0" max="100" value="<?php echo $row['product_abv']; ?>" placeholder="<?php echo translate('_e.g._23%.'); ?>" class="form-control">
                                </div>
                            </div> 
                            <div   class="form-group btm_border">
                                <label class="col-sm-4 control-label" for="demo-hor-11"><?php echo translate('tags');?></label>
                                <div class="col-sm-4">
                                    <input type="text" name="tag" data-role="tagsinput" placeholder="<?php echo "Awards, Certification, etc";?>" value="<?php echo $row['tag']; ?>" class="form-control">
                                </div>
                            </div>
                            <div class="form-group btm_border">
                                <label class="col-sm-4 control-label" for="demo-hor-81"><?php echo translate('limited_release');?></label>
                                <div class="col-sm-5">
                                    <select class="form-control" name="limited_release">
                                         <option value="<?php echo $row['limited_release']; ?>"><?php echo $row['limited_release']; ?></option>
                                        <?php if($row['limited_release'] != 'Yes')  { ?> <option value="Yes"><?php echo translate('yes');?></option> <?php } ?>
                                        <?php if($row['limited_release'] != 'No')  { ?> <option value="No"><?php echo translate('no');?></option> <?php } ?>
                                    </select>
                                </div>
                            </div>
                            
                            <div class="form-group btm_border">
                                <label class="col-sm-4 control-label" for="demo-hor-84"><?php echo translate('is_low_stock');?></label>
                                <div class="col-sm-6">
                                    <input type="checkbox" name="is_low_stock" id="demo-hor-84" <?php if($row['is_low_stock']=='yes') { echo 'checked'; } ?> value="yes" placeholder="<?php echo translate('is_low_stock');?>" >Low Stock
                                </div>
                            </div>
                            <div class="form-group btm_border">
                                <label class="col-sm-4 control-label" for="demo-hor-13">Product Description English</label>
                                <div class="col-sm-6">

                                    <textarea rows="5" maxlength="900" placeholder="Max 900 characters"  class="form-control required"  name="description_en"><?php echo $row['description']; ?></textarea>
                                </div>
                            </div>
                            <div class="form-group btm_border">
                                <label class="col-sm-4 control-label" for="demo-hor-13">Product Description Chinese</label>
                                <div class="col-sm-6">
                                    <textarea rows="5" placeholder="Max 900 characters" maxlength="900" class="form-control"  name="description_ch"><?php echo $row['description_ch']; ?></textarea>
                                </div>
                            </div>
                            <div class="form-group btm_border">
                                <label class="col-sm-4 control-label" for="demo-hor-13">Product Description Japanese</label>
                                <div class="col-sm-6">
                                    <textarea rows="5" placeholder="Max 900 characters" maxlength="900"  class="form-control"  name="description_jp"><?php echo $row['description_jp']; ?></textarea>
                                </div>
                            </div>
                            <div class="form-group btm_border" >
                                <label class="col-sm-4 control-label" for="demo-hor-5"><?php echo translate('wholesale (INCL GST + WET)');?></label>
                                <div class="col-sm-6" >
                                    <input type="number" min="1" name="wholesale" class="form-control required" value="<?php echo $row['wholesale']; ?>" >
                                </div>                                
                            </div>
                            <div class="form-group btm_border" >
                                <label class="col-sm-4 control-label" for="demo-hor-5"><?php echo translate('wholesale_EXCL_WET_GST');?></label>
                                <div class="col-sm-6" >
                                    <input type="number" min="1" name="wholesale_EXCL_WET_GST" class="form-control required" value="<?php echo $row['wholesale_EXCL_WET_GST']; ?>" >
                                </div>                                
                            </div>
                            
                            <div class="form-group btm_border" >
                                <label class="col-sm-1 control-label" for="demo-hor-5"><?php echo translate('bundle_sale_price');?> (AUD)</label>
                                <div class="col-sm-2">
                                    <span style="position: absolute;top: 7px;left: 28px;color: grey;font-weight: bold;"> $ </span>
                                    <input type="number" min="1" name="sale_price_AU" class="form-control required" value="<?php echo $row['sale_price_AU']; ?>"  placeholder="If applicable" style=" padding-left: 26px;padding-top: 3px;">
                                </div> 
                                <label class="col-sm-1 control-label" for="demo-hor-5"><?php echo translate('bundle_sale_price');?> (HKD)</label>
                                <div class="col-sm-2">
                                    <span style="position: absolute;top: 7px;left: 28px;color: grey;font-weight: bold;"> $ </span>
                                    <input type="number" min="1" name="sale_price_HK" class="form-control" value="<?php echo $row['sale_price_HK']; ?>"  placeholder="If applicable" style=" padding-left: 26px;padding-top: 3px;">
                                </div>
                                <label class="col-sm-1 control-label" for="demo-hor-5"><?php echo translate('bundle_sale_price');?> (JP Yen)</label>
                                <div class="col-sm-2">
                                    <span style="position: absolute;top: 7px;left: 28px;color: grey;font-weight: bold;"> $ </span>
                                    <input type="number" min="1" name="sale_price_JP" class="form-control" value="<?php echo $row['sale_price_JP']; ?>"  placeholder="If applicable" style=" padding-left: 26px;padding-top: 3px;"> 
                                </div>
                                <label class="col-sm-1 control-label" for="demo-hor-5"><?php echo translate('bundle_sale_price');?> (SGD)</label>
                                <div class="col-sm-2">
                                    <span style="position: absolute;top: 7px;left: 28px;color: grey;font-weight: bold;"> $ </span>
                                    <input type="number" min="1" name="sale_price_SG" class="form-control" value="<?php echo $row['sale_price_SG']; ?>"  placeholder="If applicable" style=" padding-left: 26px;padding-top: 3px;">
                                </div>                              
                            </div>
                            <div class="form-group btm_border"  style="display: none;">
                                <label class="col-sm-4 control-label" for="demo-hor-5"><?php echo translate('bundle_discount');?> (%)</label>
                                <div class="col-sm-6">
                                    <input type="number" min="1" name="discount" class="form-control" value="<?php echo $row['discount']; ?>">
                                </div>
                            </div>
                            <!-- Test section -->
                            <div class="form-group btm_border">
                                 <b class="pull-left"><?php echo "Taste Meter";?></b>
                               <div class="col-sm-6">  
                                    <input type="hidden" name="test_section" placeholder="<?php echo translate('test_section');?>" <?php if($row['test_section'] == 'yes') { echo "checked"; } ?>  value="yes">
                               </div>
                            </div>

                            <div class="form-group btm_border test_hide_show_field">
                                <div class="col-sm-3">
                                    <input type="text" name="test_title_en" id="demo-hor-55" placeholder="<?php echo translate('Taste Meter Rate English');?>" min="1" max="100" value="<?php echo $row['test_title_en']; ?>" class="form-control">
                                </div>
                                <div class="col-sm-3">
                                    <input type="text" name="test_title_ch" id="demo-hor-55" value="<?php echo $row['test_title_ch']; ?>" placeholder="<?php echo translate('Taste Meter Rate Chinese');?>" min="1" max="100" class="form-control">
                                </div>
                                <div class="col-sm-3">
                                    <input type="text" name="test_title_jp" id="demo-hor-55"  value="<?php echo $row['test_title_jp']; ?>" placeholder="<?php echo translate('Taste Meter Rate Japanese');?>" min="1" max="100" class="form-control">
                                </div>
                            </div> 
                            <div class="form-group btm_border test_hide_show_field">

                    <div class="col-sm-3">
                        
                        <select name="test1_name" id="demo-hor-65"  class="form-control">
                            <option value=""><?php echo translate('taste');?></option>
                            <option <?php if($row['test1_name'] == 'Wine') { echo  "selected"; } ?> value="Wine">Wine</option>
                            <option <?php if($row['test1_name'] == 'Dry') { echo  "selected"; } ?> value="Dry">Dry</option>
                            <option <?php if($row['test1_name'] == 'Sweet') { echo  "selected"; } ?> value="Sweet">Sweet</option>
                            <option <?php if($row['test1_name'] == 'Fruity') { echo  "selected"; } ?> value="Fruity">Fruity</option>
                            <option <?php if($row['test1_name'] == 'Citrus') { echo  "selected"; } ?> value="Citrus">Citrus</option>
                            <option <?php if($row['test1_name'] == 'Floral') { echo  "selected"; } ?> value="Floral">Floral</option>
                            <option <?php if($row['test1_name'] == 'Oak') { echo  "selected"; } ?> value="Oak">Oak</option>
                            <option <?php if($row['test1_name'] == 'Creamy') { echo  "selected"; } ?> value="Creamy">Creamy</option>
                            <option <?php if($row['test1_name'] == 'Rich') { echo  "selected"; } ?> value="Rich">Rich</option>
                            <option <?php if($row['test1_name'] == 'Body') { echo  "selected"; } ?> value="Body">Body</option>

                            <option <?php if($row['test1_name'] == 'Sparkling') { echo  "selected"; } ?> value="Sparkling">Sparkling</option>
                            <option <?php if($row['test1_name'] == 'Dry White') { echo  "selected"; } ?> value="Dry White">Dry White</option>
                            <option <?php if($row['test1_name'] == 'Sweet White') { echo  "selected"; } ?> value="Sweet White">Sweet White</option>
                            <option <?php if($row['test1_name'] == 'Rich White') { echo  "selected"; } ?> value="Rich White">Rich White</option>
                            <option <?php if($row['test1_name'] == 'Rose') { echo  "selected"; } ?> value="Rose">Rose</option>
                            <option <?php if($row['test1_name'] == 'Light Red') { echo  "selected"; } ?> value="Light Red">Light Red</option>
                            <option <?php if($row['test1_name'] == 'Medium Red') { echo  "selected"; } ?> value="Medium Red">Medium Red</option>
                            <option <?php if($row['test1_name'] == 'Bold Red') { echo  "selected"; } ?> value="Bold Red">Bold Red</option>
                        </select>
                    </div>
                    <div class="col-sm-3">
                        <select class="form-control" name="test1_number">
                            <option value=""><?php echo translate('meter_level');?></option>
                            <option <?php if($row['test1_number'] == 0) { echo "selected"; } ?> value="0">0</option>
                            <option  <?php if($row['test1_number'] == 1) { echo "selected"; } ?> value="1">1</option>
                            <option  <?php if($row['test1_number'] == 2) { echo "selected"; } ?> value="2">2</option>
                            <option  <?php if($row['test1_number'] == 3) { echo "selected"; } ?> value="3">3</option>
                            <option  <?php if($row['test1_number'] == 4) { echo "selected"; } ?> value="4">4</option>
                            <option  <?php if($row['test1_number'] == 5) { echo "selected"; } ?> value="5">5</option>
                            <option  <?php if($row['test1_number'] == 6) { echo "selected"; } ?> value="6">6</option>
                            <option  <?php if($row['test1_number'] == 7) { echo "selected"; } ?> value="7">7</option>
                            <option  <?php if($row['test1_number'] == 8) { echo "selected"; } ?> value="8">8</option>
                            <option  <?php if($row['test1_number'] == 9) { echo "selected"; } ?> value="9">9</option>
                        </select>
                    </div>
                    <div class="col-sm-3">
                        <select name="test11_name" id="demo-hor-67"   class="form-control">
                            <option value=""><?php echo translate('taste');?>..</option>
                            <option <?php if($row['test11_name'] == 'Wine') { echo  "selected"; } ?> value="Wine">Wine</option>
                            <option <?php if($row['test11_name'] == 'Dry') { echo  "selected"; } ?> value="Dry">Dry</option>
                            <option <?php if($row['test11_name'] == 'Sweet') { echo  "selected"; } ?> value="Sweet">Sweet</option>
                            <option <?php if($row['test11_name'] == 'Fruity') { echo  "selected"; } ?> value="Fruity">Fruity</option>
                            <option <?php if($row['test11_name'] == 'Citrus') { echo  "selected"; } ?> value="Citrus">Citrus</option>
                            <option <?php if($row['test11_name'] == 'Floral') { echo  "selected"; } ?> value="Floral">Floral</option>
                            <option <?php if($row['test11_name'] == 'Oak') { echo  "selected"; } ?> value="Oak">Oak</option>
                            <option <?php if($row['test11_name'] == 'Creamy') { echo  "selected"; } ?> value="Creamy">Creamy</option>
                            <option <?php if($row['test11_name'] == 'Rich') { echo  "selected"; } ?> value="Rich">Rich</option>
                            <option <?php if($row['test11_name'] == 'Body') { echo  "selected"; } ?> value="Body">Body</option>

                            <option <?php if($row['test11_name'] == 'Sparkling') { echo  "selected"; } ?> value="Sparkling">Sparkling</option>
                            <option <?php if($row['test11_name'] == 'Dry White') { echo  "selected"; } ?> value="Dry White">Dry White</option>
                            <option <?php if($row['test11_name'] == 'Sweet White') { echo  "selected"; } ?> value="Sweet White">Sweet White</option>
                            <option <?php if($row['test11_name'] == 'Rich White') { echo  "selected"; } ?> value="Rich White">Rich White</option>
                            <option <?php if($row['test11_name'] == 'Rose') { echo  "selected"; } ?> value="Rose">Rose</option>
                            <option <?php if($row['test11_name'] == 'Light Red') { echo  "selected"; } ?> value="Light Red">Light Red</option>
                            <option <?php if($row['test11_name'] == 'Medium Red') { echo  "selected"; } ?> value="Medium Red">Medium Red</option>
                            <option <?php if($row['test11_name'] == 'Bold Red') { echo  "selected"; } ?> value="Bold Red">Bold Red</option>
                        </select>
                    </div>
                    <div class="col-sm-3">
                        <select class="form-control" name="test11_number">
                            <option value=""><?php echo translate('meter_level');?></option>
                            <option <?php if($row['test11_number'] == 0) { echo "selected"; } ?> value="0">0</option>
                            <option  <?php if($row['test11_number'] == 1) { echo "selected"; } ?> value="1">1</option>
                            <option  <?php if($row['test11_number'] == 2) { echo "selected"; } ?> value="2">2</option>
                            <option  <?php if($row['test11_number'] == 3) { echo "selected"; } ?> value="3">3</option>
                            <option  <?php if($row['test11_number'] == 4) { echo "selected"; } ?> value="4">4</option>
                            <option  <?php if($row['test11_number'] == 5) { echo "selected"; } ?> value="5">5</option>
                            <option  <?php if($row['test11_number'] == 6) { echo "selected"; } ?> value="6">6</option>
                            <option  <?php if($row['test11_number'] == 7) { echo "selected"; } ?> value="7">7</option>
                            <option  <?php if($row['test11_number'] == 8) { echo "selected"; } ?> value="8">8</option>
                            <option  <?php if($row['test11_number'] == 9) { echo "selected"; } ?> value="9">9</option>
                        </select>
                    </div>
                </div>
                <div class="form-group btm_border test_hide_show_field">
                    <div class="col-sm-3">
                        <select name="test2_name" id="demo-hor-69"   class="form-control">
                            <option value=""><?php echo translate('taste');?>..</option>
                            <option <?php if($row['test2_name'] == 'Wine') { echo  "selected"; } ?> value="Wine">Wine</option>
                            <option <?php if($row['test2_name'] == 'Dry') { echo  "selected"; } ?> value="Dry">Dry</option>
                            <option <?php if($row['test2_name'] == 'Sweet') { echo  "selected"; } ?> value="Sweet">Sweet</option>
                            <option <?php if($row['test2_name'] == 'Fruity') { echo  "selected"; } ?> value="Fruity">Fruity</option>
                            <option <?php if($row['test2_name'] == 'Citrus') { echo  "selected"; } ?> value="Citrus">Citrus</option>
                            <option <?php if($row['test2_name'] == 'Floral') { echo  "selected"; } ?> value="Floral">Floral</option>
                            <option <?php if($row['test2_name'] == 'Oak') { echo  "selected"; } ?> value="Oak">Oak</option>
                            <option <?php if($row['test2_name'] == 'Creamy') { echo  "selected"; } ?> value="Creamy">Creamy</option>
                            <option <?php if($row['test2_name'] == 'Rich') { echo  "selected"; } ?> value="Rich">Rich</option>
                            <option <?php if($row['test2_name'] == 'Body') { echo  "selected"; } ?> value="Body">Body</option>

                            <option <?php if($row['test2_name'] == 'Sparkling') { echo  "selected"; } ?> value="Sparkling">Sparkling</option>
                            <option <?php if($row['test2_name'] == 'Dry White') { echo  "selected"; } ?> value="Dry White">Dry White</option>
                            <option <?php if($row['test2_name'] == 'Sweet White') { echo  "selected"; } ?> value="Sweet White">Sweet White</option>
                            <option <?php if($row['test2_name'] == 'Rich White') { echo  "selected"; } ?> value="Rich White">Rich White</option>
                            <option <?php if($row['test2_name'] == 'Rose') { echo  "selected"; } ?> value="Rose">Rose</option>
                            <option <?php if($row['test2_name'] == 'Light Red') { echo  "selected"; } ?> value="Light Red">Light Red</option>
                            <option <?php if($row['test2_name'] == 'Medium Red') { echo  "selected"; } ?> value="Medium Red">Medium Red</option>
                            <option <?php if($row['test2_name'] == 'Bold Red') { echo  "selected"; } ?> value="Bold Red">Bold Red</option>
                        </select>
                    </div>
                    <div class="col-sm-3">
                        <select class="form-control" name="test2_number">
                            <option value=""><?php echo translate('meter_level');?></option>
                             <option <?php if($row['test2_number'] == 0) { echo "selected"; } ?> value="0">0</option>
                            <option  <?php if($row['test2_number'] == 1) { echo "selected"; } ?> value="1">1</option>
                            <option  <?php if($row['test2_number'] == 2) { echo "selected"; } ?> value="2">2</option>
                            <option  <?php if($row['test2_number'] == 3) { echo "selected"; } ?> value="3">3</option>
                            <option  <?php if($row['test2_number'] == 4) { echo "selected"; } ?> value="4">4</option>
                            <option  <?php if($row['test2_number'] == 5) { echo "selected"; } ?> value="5">5</option>
                            <option  <?php if($row['test2_number'] == 6) { echo "selected"; } ?> value="6">6</option>
                            <option  <?php if($row['test2_number'] == 7) { echo "selected"; } ?> value="7">7</option>
                            <option  <?php if($row['test2_number'] == 8) { echo "selected"; } ?> value="8">8</option>
                            <option  <?php if($row['test2_number'] == 9) { echo "selected"; } ?> value="9">9</option>
                        </select>
                    </div>
                    <div class="col-sm-3">
                        <select name="test22_name" id="demo-hor-71"   class="form-control">
                            <option value=""><?php echo translate('taste');?>..</option>
                            <option <?php if($row['test22_name'] == 'Wine') { echo  "selected"; } ?> value="Wine">Wine</option>
                            <option <?php if($row['test22_name'] == 'Dry') { echo  "selected"; } ?> value="Dry">Dry</option>
                            <option <?php if($row['test22_name'] == 'Sweet') { echo  "selected"; } ?> value="Sweet">Sweet</option>
                            <option <?php if($row['test22_name'] == 'Fruity') { echo  "selected"; } ?> value="Fruity">Fruity</option>
                            <option <?php if($row['test22_name'] == 'Citrus') { echo  "selected"; } ?> value="Citrus">Citrus</option>
                            <option <?php if($row['test22_name'] == 'Floral') { echo  "selected"; } ?> value="Floral">Floral</option>
                            <option <?php if($row['test22_name'] == 'Oak') { echo  "selected"; } ?> value="Oak">Oak</option>
                            <option <?php if($row['test22_name'] == 'Creamy') { echo  "selected"; } ?> value="Creamy">Creamy</option>
                            <option <?php if($row['test22_name'] == 'Rich') { echo  "selected"; } ?> value="Rich">Rich</option>
                            <option <?php if($row['test22_name'] == 'Body') { echo  "selected"; } ?> value="Body">Body</option>

                            <option <?php if($row['test22_name'] == 'Sparkling') { echo  "selected"; } ?> value="Sparkling">Sparkling</option>
                            <option <?php if($row['test22_name'] == 'Dry White') { echo  "selected"; } ?> value="Dry White">Dry White</option>
                            <option <?php if($row['test22_name'] == 'Sweet White') { echo  "selected"; } ?> value="Sweet White">Sweet White</option>
                            <option <?php if($row['test22_name'] == 'Rich White') { echo  "selected"; } ?> value="Rich White">Rich White</option>
                            <option <?php if($row['test22_name'] == 'Rose') { echo  "selected"; } ?> value="Rose">Rose</option>
                            <option <?php if($row['test22_name'] == 'Light Red') { echo  "selected"; } ?> value="Light Red">Light Red</option>
                            <option <?php if($row['test22_name'] == 'Medium Red') { echo  "selected"; } ?> value="Medium Red">Medium Red</option>
                            <option <?php if($row['test22_name'] == 'Bold Red') { echo  "selected"; } ?> value="Bold Red">Bold Red</option>
                        </select>
                    </div>
                    <div class="col-sm-3">
                        <select class="form-control" name="test22_number">
                            <option value=""><?php echo translate('meter_level');?></option>
                            <option <?php if($row['test22_number'] == 0) { echo "selected"; } ?> value="0">0</option>
                            <option  <?php if($row['test22_number'] == 1) { echo "selected"; } ?> value="1">1</option>
                            <option  <?php if($row['test22_number'] == 2) { echo "selected"; } ?> value="2">2</option>
                            <option  <?php if($row['test22_number'] == 3) { echo "selected"; } ?> value="3">3</option>
                            <option  <?php if($row['test22_number'] == 4) { echo "selected"; } ?> value="4">4</option>
                            <option  <?php if($row['test22_number'] == 5) { echo "selected"; } ?> value="5">5</option>
                            <option  <?php if($row['test22_number'] == 6) { echo "selected"; } ?> value="6">6</option>
                            <option  <?php if($row['test22_number'] == 7) { echo "selected"; } ?> value="7">7</option>
                            <option  <?php if($row['test22_number'] == 8) { echo "selected"; } ?> value="8">8</option>
                            <option  <?php if($row['test22_number'] == 9) { echo "selected"; } ?> value="9">9</option>
                        </select>
                    </div>
                </div>
                <div class="form-group btm_border test_hide_show_field">
                    <div class="col-sm-3">
                        <select name="test3_name" id="demo-hor-73"   class="form-control">
                            <option value=""><?php echo translate('taste');?>..</option>
                            <option <?php if($row['test3_name'] == 'Wine') { echo  "selected"; } ?> value="Wine">Wine</option>
                            <option <?php if($row['test3_name'] == 'Dry') { echo  "selected"; } ?> value="Dry">Dry</option>
                            <option <?php if($row['test3_name'] == 'Sweet') { echo  "selected"; } ?> value="Sweet">Sweet</option>
                            <option <?php if($row['test3_name'] == 'Fruity') { echo  "selected"; } ?> value="Fruity">Fruity</option>
                            <option <?php if($row['test3_name'] == 'Citrus') { echo  "selected"; } ?> value="Citrus">Citrus</option>
                            <option <?php if($row['test3_name'] == 'Floral') { echo  "selected"; } ?> value="Floral">Floral</option>
                            <option <?php if($row['test3_name'] == 'Oak') { echo  "selected"; } ?> value="Oak">Oak</option>
                            <option <?php if($row['test3_name'] == 'Creamy') { echo  "selected"; } ?> value="Creamy">Creamy</option>
                            <option <?php if($row['test3_name'] == 'Rich') { echo  "selected"; } ?> value="Rich">Rich</option>
                            <option <?php if($row['test3_name'] == 'Body') { echo  "selected"; } ?> value="Body">Body</option>

                            <option <?php if($row['test3_name'] == 'Sparkling') { echo  "selected"; } ?> value="Sparkling">Sparkling</option>
                            <option <?php if($row['test3_name'] == 'Dry White') { echo  "selected"; } ?> value="Dry White">Dry White</option>
                            <option <?php if($row['test3_name'] == 'Sweet White') { echo  "selected"; } ?> value="Sweet White">Sweet White</option>
                            <option <?php if($row['test3_name'] == 'Rich White') { echo  "selected"; } ?> value="Rich White">Rich White</option>
                            <option <?php if($row['test3_name'] == 'Rose') { echo  "selected"; } ?> value="Rose">Rose</option>
                            <option <?php if($row['test3_name'] == 'Light Red') { echo  "selected"; } ?> value="Light Red">Light Red</option>
                            <option <?php if($row['test3_name'] == 'Medium Red') { echo  "selected"; } ?> value="Medium Red">Medium Red</option>
                            <option <?php if($row['test3_name'] == 'Bold Red') { echo  "selected"; } ?> value="Bold Red">Bold Red</option>
                        </select>
                    </div>
                    <div class="col-sm-3">
                        <select class="form-control" name="test3_number">
                            <option value=""><?php echo translate('meter_level');?></option>
                            <option <?php if($row['test3_number'] == 0) { echo "selected"; } ?> value="0">0</option>
                            <option  <?php if($row['test3_number'] == 1) { echo "selected"; } ?> value="1">1</option>
                            <option  <?php if($row['test3_number'] == 2) { echo "selected"; } ?> value="2">2</option>
                            <option  <?php if($row['test3_number'] == 3) { echo "selected"; } ?> value="3">3</option>
                            <option  <?php if($row['test3_number'] == 4) { echo "selected"; } ?> value="4">4</option>
                            <option  <?php if($row['test3_number'] == 5) { echo "selected"; } ?> value="5">5</option>
                            <option  <?php if($row['test3_number'] == 6) { echo "selected"; } ?> value="6">6</option>
                            <option  <?php if($row['test3_number'] == 7) { echo "selected"; } ?> value="7">7</option>
                            <option  <?php if($row['test3_number'] == 8) { echo "selected"; } ?> value="8">8</option>
                            <option  <?php if($row['test3_number'] == 9) { echo "selected"; } ?> value="9">9</option>
                        </select>
                    </div>
                    <div class="col-sm-3">
                        <select name="test33_name" id="demo-hor-75"   class="form-control">
                            <option value=""><?php echo translate('taste');?>..</option>
                            <option <?php if($row['test33_name'] == 'Wine') { echo  "selected"; } ?> value="Wine">Wine</option>
                            <option <?php if($row['test33_name'] == 'Dry') { echo  "selected"; } ?> value="Dry">Dry</option>
                            <option <?php if($row['test33_name'] == 'Sweet') { echo  "selected"; } ?> value="Sweet">Sweet</option>
                            <option <?php if($row['test33_name'] == 'Fruity') { echo  "selected"; } ?> value="Fruity">Fruity</option>
                            <option <?php if($row['test33_name'] == 'Citrus') { echo  "selected"; } ?> value="Citrus">Citrus</option>
                            <option <?php if($row['test33_name'] == 'Floral') { echo  "selected"; } ?> value="Floral">Floral</option>
                            <option <?php if($row['test33_name'] == 'Oak') { echo  "selected"; } ?> value="Oak">Oak</option>
                            <option <?php if($row['test33_name'] == 'Creamy') { echo  "selected"; } ?> value="Creamy">Creamy</option>
                            <option <?php if($row['test33_name'] == 'Rich') { echo  "selected"; } ?> value="Rich">Rich</option>
                            <option <?php if($row['test33_name'] == 'Body') { echo  "selected"; } ?> value="Body">Body</option>

                            <option <?php if($row['test33_name'] == 'Sparkling') { echo  "selected"; } ?> value="Sparkling">Sparkling</option>
                            <option <?php if($row['test33_name'] == 'Dry White') { echo  "selected"; } ?> value="Dry White">Dry White</option>
                            <option <?php if($row['test33_name'] == 'Sweet White') { echo  "selected"; } ?> value="Sweet White">Sweet White</option>
                            <option <?php if($row['test33_name'] == 'Rich White') { echo  "selected"; } ?> value="Rich White">Rich White</option>
                            <option <?php if($row['test33_name'] == 'Rose') { echo  "selected"; } ?> value="Rose">Rose</option>
                            <option <?php if($row['test33_name'] == 'Light Red') { echo  "selected"; } ?> value="Light Red">Light Red</option>
                            <option <?php if($row['test33_name'] == 'Medium Red') { echo  "selected"; } ?> value="Medium Red">Medium Red</option>
                            <option <?php if($row['test33_name'] == 'Bold Red') { echo  "selected"; } ?> value="Bold Red">Bold Red</option>
                        </select>
                    </div>
                    <div class="col-sm-3">
                        <select class="form-control" name="test33_number">
                            <option value=""><?php echo translate('meter_level');?></option>
                            <option <?php if($row['test33_number'] == 0) { echo "selected"; } ?> value="0">0</option>
                            <option  <?php if($row['test33_number'] == 1) { echo "selected"; } ?> value="1">1</option>
                            <option  <?php if($row['test33_number'] == 2) { echo "selected"; } ?> value="2">2</option>
                            <option  <?php if($row['test33_number'] == 3) { echo "selected"; } ?> value="3">3</option>
                            <option  <?php if($row['test33_number'] == 4) { echo "selected"; } ?> value="4">4</option>
                            <option  <?php if($row['test33_number'] == 5) { echo "selected"; } ?> value="5">5</option>
                            <option  <?php if($row['test33_number'] == 6) { echo "selected"; } ?> value="6">6</option>
                            <option  <?php if($row['test33_number'] == 7) { echo "selected"; } ?> value="7">7</option>
                            <option  <?php if($row['test33_number'] == 8) { echo "selected"; } ?> value="8">8</option>
                            <option  <?php if($row['test33_number'] == 9) { echo "selected"; } ?> value="9">9</option>
                        </select>
                    </div>
                </div>
                <div class="form-group btm_border test_hide_show_field">
                    <div class="col-sm-3">
                        <select name="test4_name" id="demo-hor-73"   class="form-control">
                            <option value=""><?php echo translate('taste');?>..</option>
                            <option <?php if($row['test4_name'] == 'Wine') { echo  "selected"; } ?> value="Wine">Wine</option>
                            <option <?php if($row['test4_name'] == 'Dry') { echo  "selected"; } ?> value="Dry">Dry</option>
                            <option <?php if($row['test4_name'] == 'Sweet') { echo  "selected"; } ?> value="Sweet">Sweet</option>
                            <option <?php if($row['test4_name'] == 'Fruity') { echo  "selected"; } ?> value="Fruity">Fruity</option>
                            <option <?php if($row['test4_name'] == 'Citrus') { echo  "selected"; } ?> value="Citrus">Citrus</option>
                            <option <?php if($row['test4_name'] == 'Floral') { echo  "selected"; } ?> value="Floral">Floral</option>
                            <option <?php if($row['test4_name'] == 'Oak') { echo  "selected"; } ?> value="Oak">Oak</option>
                            <option <?php if($row['test4_name'] == 'Creamy') { echo  "selected"; } ?> value="Creamy">Creamy</option>
                            <option <?php if($row['test4_name'] == 'Rich') { echo  "selected"; } ?> value="Rich">Rich</option>
                            <option <?php if($row['test4_name'] == 'Body') { echo  "selected"; } ?> value="Body">Body</option>

                            <option <?php if($row['test4_name'] == 'Sparkling') { echo  "selected"; } ?> value="Sparkling">Sparkling</option>
                            <option <?php if($row['test4_name'] == 'Dry White') { echo  "selected"; } ?> value="Dry White">Dry White</option>
                            <option <?php if($row['test4_name'] == 'Sweet White') { echo  "selected"; } ?> value="Sweet White">Sweet White</option>
                            <option <?php if($row['test4_name'] == 'Rich White') { echo  "selected"; } ?> value="Rich White">Rich White</option>
                            <option <?php if($row['test4_name'] == 'Rose') { echo  "selected"; } ?> value="Rose">Rose</option>
                            <option <?php if($row['test4_name'] == 'Light Red') { echo  "selected"; } ?> value="Light Red">Light Red</option>
                            <option <?php if($row['test4_name'] == 'Medium Red') { echo  "selected"; } ?> value="Medium Red">Medium Red</option>
                            <option <?php if($row['test4_name'] == 'Bold Red') { echo  "selected"; } ?> value="Bold Red">Bold Red</option>
                        </select>
                    </div>
                    <div class="col-sm-3">
                        <select class="form-control" name="test4_number">
                            <option value=""><?php echo translate('meter_level');?></option>
                            <option <?php if($row['test44_number'] == 0) { echo "selected"; } ?> value="0">0</option>
                            <option  <?php if($row['test44_number'] == 1) { echo "selected"; } ?> value="1">1</option>
                            <option  <?php if($row['test44_number'] == 2) { echo "selected"; } ?> value="2">2</option>
                            <option  <?php if($row['test44_number'] == 3) { echo "selected"; } ?> value="3">3</option>
                            <option  <?php if($row['test44_number'] == 4) { echo "selected"; } ?> value="4">4</option>
                            <option  <?php if($row['test44_number'] == 5) { echo "selected"; } ?> value="5">5</option>
                            <option  <?php if($row['test44_number'] == 6) { echo "selected"; } ?> value="6">6</option>
                            <option  <?php if($row['test44_number'] == 7) { echo "selected"; } ?> value="7">7</option>
                            <option  <?php if($row['test44_number'] == 8) { echo "selected"; } ?> value="8">8</option>
                            <option  <?php if($row['test44_number'] == 9) { echo "selected"; } ?> value="9">9</option>
                        </select>
                    </div>
                    <div class="col-sm-3">
                        <select name="test44_name" id="demo-hor-73"   class="form-control">
                            <option value=""><?php echo translate('taste');?>..</option>
                            <option <?php if($row['test44_name'] == 'Wine') { echo  "selected"; } ?> value="Wine">Wine</option>
                            <option <?php if($row['test44_name'] == 'Dry') { echo  "selected"; } ?> value="Dry">Dry</option>
                            <option <?php if($row['test44_name'] == 'Sweet') { echo  "selected"; } ?> value="Sweet">Sweet</option>
                            <option <?php if($row['test44_name'] == 'Fruity') { echo  "selected"; } ?> value="Fruity">Fruity</option>
                            <option <?php if($row['test44_name'] == 'Citrus') { echo  "selected"; } ?> value="Citrus">Citrus</option>
                            <option <?php if($row['test44_name'] == 'Floral') { echo  "selected"; } ?> value="Floral">Floral</option>
                            <option <?php if($row['test44_name'] == 'Oak') { echo  "selected"; } ?> value="Oak">Oak</option>
                            <option <?php if($row['test44_name'] == 'Creamy') { echo  "selected"; } ?> value="Creamy">Creamy</option>
                            <option <?php if($row['test44_name'] == 'Rich') { echo  "selected"; } ?> value="Rich">Rich</option>
                            <option <?php if($row['test44_name'] == 'Body') { echo  "selected"; } ?> value="Body">Body</option>

                            <option <?php if($row['test44_name'] == 'Sparkling') { echo  "selected"; } ?> value="Sparkling">Sparkling</option>
                            <option <?php if($row['test44_name'] == 'Dry White') { echo  "selected"; } ?> value="Dry White">Dry White</option>
                            <option <?php if($row['test44_name'] == 'Sweet White') { echo  "selected"; } ?> value="Sweet White">Sweet White</option>
                            <option <?php if($row['test44_name'] == 'Rich White') { echo  "selected"; } ?> value="Rich White">Rich White</option>
                            <option <?php if($row['test44_name'] == 'Rose') { echo  "selected"; } ?> value="Rose">Rose</option>
                            <option <?php if($row['test44_name'] == 'Light Red') { echo  "selected"; } ?> value="Light Red">Light Red</option>
                            <option <?php if($row['test44_name'] == 'Medium Red') { echo  "selected"; } ?> value="Medium Red">Medium Red</option>
                            <option <?php if($row['test44_name'] == 'Bold Red') { echo  "selected"; } ?> value="Bold Red">Bold Red</option>
                        </select>
                    </div>
                    <div class="col-sm-3">
                        <select class="form-control" name="test44_number">
                            <option value=""><?php echo translate('meter_level');?></option>
                            <option <?php if($row['test44_number'] == 0) { echo "selected"; } ?> value="0">0</option>
                            <option  <?php if($row['test44_number'] == 1) { echo "selected"; } ?> value="1">1</option>
                            <option  <?php if($row['test44_number'] == 2) { echo "selected"; } ?> value="2">2</option>
                            <option  <?php if($row['test44_number'] == 3) { echo "selected"; } ?> value="3">3</option>
                            <option  <?php if($row['test44_number'] == 4) { echo "selected"; } ?> value="4">4</option>
                            <option  <?php if($row['test44_number'] == 5) { echo "selected"; } ?> value="5">5</option>
                            <option  <?php if($row['test44_number'] == 6) { echo "selected"; } ?> value="6">6</option>
                            <option  <?php if($row['test44_number'] == 7) { echo "selected"; } ?> value="7">7</option>
                            <option  <?php if($row['test44_number'] == 8) { echo "selected"; } ?> value="8">8</option>
                            <option  <?php if($row['test44_number'] == 9) { echo "selected"; } ?> value="9">9</option>
                        </select>
                    </div>
                </div>
                <div class="form-group btm_border test_hide_show_field">
                    <div class="col-sm-3">
                        <select name="test5_name" id="demo-hor-73"   class="form-control">
                            <option <?php if($row['test5_name'] == 'Wine') { echo  "selected"; } ?> value="Wine">Wine</option>
                            <option <?php if($row['test5_name'] == 'Dry') { echo  "selected"; } ?> value="Dry">Dry</option>
                            <option <?php if($row['test5_name'] == 'Sweet') { echo  "selected"; } ?> value="Sweet">Sweet</option>
                            <option <?php if($row['test5_name'] == 'Fruity') { echo  "selected"; } ?> value="Fruity">Fruity</option>
                            <option <?php if($row['test5_name'] == 'Citrus') { echo  "selected"; } ?> value="Citrus">Citrus</option>
                            <option <?php if($row['test5_name'] == 'Floral') { echo  "selected"; } ?> value="Floral">Floral</option>
                            <option <?php if($row['test5_name'] == 'Oak') { echo  "selected"; } ?> value="Oak">Oak</option>
                            <option <?php if($row['test5_name'] == 'Creamy') { echo  "selected"; } ?> value="Creamy">Creamy</option>
                            <option <?php if($row['test5_name'] == 'Rich') { echo  "selected"; } ?> value="Rich">Rich</option>
                            <option <?php if($row['test5_name'] == 'Body') { echo  "selected"; } ?> value="Body">Body</option>

                            <option <?php if($row['test5_name'] == 'Sparkling') { echo  "selected"; } ?> value="Sparkling">Sparkling</option>
                            <option <?php if($row['test5_name'] == 'Dry White') { echo  "selected"; } ?> value="Dry White">Dry White</option>
                            <option <?php if($row['test5_name'] == 'Sweet White') { echo  "selected"; } ?> value="Sweet White">Sweet White</option>
                            <option <?php if($row['test5_name'] == 'Rich White') { echo  "selected"; } ?> value="Rich White">Rich White</option>
                            <option <?php if($row['test5_name'] == 'Rose') { echo  "selected"; } ?> value="Rose">Rose</option>
                            <option <?php if($row['test5_name'] == 'Light Red') { echo  "selected"; } ?> value="Light Red">Light Red</option>
                            <option <?php if($row['test5_name'] == 'Medium Red') { echo  "selected"; } ?> value="Medium Red">Medium Red</option>
                            <option <?php if($row['test5_name'] == 'Bold Red') { echo  "selected"; } ?> value="Bold Red">Bold Red</option>
                        </select>
                    </div>
                    <div class="col-sm-3">
                        <select class="form-control" name="test5_number">
                            <option value=""><?php echo translate('meter_level');?></option>
                            <option <?php if($row['test5_number'] == 0) { echo "selected"; } ?> value="0">0</option>
                            <option  <?php if($row['test5_number'] == 1) { echo "selected"; } ?> value="1">1</option>
                            <option  <?php if($row['test5_number'] == 2) { echo "selected"; } ?> value="2">2</option>
                            <option  <?php if($row['test5_number'] == 3) { echo "selected"; } ?> value="3">3</option>
                            <option  <?php if($row['test5_number'] == 4) { echo "selected"; } ?> value="4">4</option>
                            <option  <?php if($row['test5_number'] == 5) { echo "selected"; } ?> value="5">5</option>
                            <option  <?php if($row['test5_number'] == 6) { echo "selected"; } ?> value="6">6</option>
                            <option  <?php if($row['test5_number'] == 7) { echo "selected"; } ?> value="7">7</option>
                            <option  <?php if($row['test5_number'] == 8) { echo "selected"; } ?> value="8">8</option>
                            <option  <?php if($row['test5_number'] == 9) { echo "selected"; } ?> value="9">9</option>
                        </select>
                    </div>
                    <div class="col-sm-3">
                        <select name="test55_name" id="demo-hor-73"   class="form-control">
                            <option value=""><?php echo translate('taste');?>..</option>
                            <option <?php if($row['test55_name'] == 'Wine') { echo  "selected"; } ?> value="Wine">Wine</option>
                            <option <?php if($row['test55_name'] == 'Dry') { echo  "selected"; } ?> value="Dry">Dry</option>
                            <option <?php if($row['test55_name'] == 'Sweet') { echo  "selected"; } ?> value="Sweet">Sweet</option>
                            <option <?php if($row['test55_name'] == 'Fruity') { echo  "selected"; } ?> value="Fruity">Fruity</option>
                            <option <?php if($row['test55_name'] == 'Citrus') { echo  "selected"; } ?> value="Citrus">Citrus</option>
                            <option <?php if($row['test55_name'] == 'Floral') { echo  "selected"; } ?> value="Floral">Floral</option>
                            <option <?php if($row['test55_name'] == 'Oak') { echo  "selected"; } ?> value="Oak">Oak</option>
                            <option <?php if($row['test55_name'] == 'Creamy') { echo  "selected"; } ?> value="Creamy">Creamy</option>
                            <option <?php if($row['test55_name'] == 'Rich') { echo  "selected"; } ?> value="Rich">Rich</option>
                            <option <?php if($row['test55_name'] == 'Body') { echo  "selected"; } ?> value="Body">Body</option>

                            <option <?php if($row['test55_name'] == 'Sparkling') { echo  "selected"; } ?> value="Sparkling">Sparkling</option>
                            <option <?php if($row['test55_name'] == 'Dry White') { echo  "selected"; } ?> value="Dry White">Dry White</option>
                            <option <?php if($row['test55_name'] == 'Sweet White') { echo  "selected"; } ?> value="Sweet White">Sweet White</option>
                            <option <?php if($row['test55_name'] == 'Rich White') { echo  "selected"; } ?> value="Rich White">Rich White</option>
                            <option <?php if($row['test55_name'] == 'Rose') { echo  "selected"; } ?> value="Rose">Rose</option>
                            <option <?php if($row['test55_name'] == 'Light Red') { echo  "selected"; } ?> value="Light Red">Light Red</option>
                            <option <?php if($row['test55_name'] == 'Medium Red') { echo  "selected"; } ?> value="Medium Red">Medium Red</option>
                            <option <?php if($row['test55_name'] == 'Bold Red') { echo  "selected"; } ?> value="Bold Red">Bold Red</option>
                        </select>
                    </div>
                    <div class="col-sm-3">
                        <select class="form-control" name="test55_number">
                            <option value=""><?php echo translate('meter_level');?></option>
                            <option <?php if($row['test55_number'] == 0) { echo "selected"; } ?> value="0">0</option>
                            <option  <?php if($row['test55_number'] == 1) { echo "selected"; } ?> value="1">1</option>
                            <option  <?php if($row['test55_number'] == 2) { echo "selected"; } ?> value="2">2</option>
                            <option  <?php if($row['test55_number'] == 3) { echo "selected"; } ?> value="3">3</option>
                            <option  <?php if($row['test55_number'] == 4) { echo "selected"; } ?> value="4">4</option>
                            <option  <?php if($row['test55_number'] == 5) { echo "selected"; } ?> value="5">5</option>
                            <option  <?php if($row['test55_number'] == 6) { echo "selected"; } ?> value="6">6</option>
                            <option  <?php if($row['test55_number'] == 7) { echo "selected"; } ?> value="7">7</option>
                            <option  <?php if($row['test55_number'] == 8) { echo "selected"; } ?> value="8">8</option>
                            <option  <?php if($row['test55_number'] == 9) { echo "selected"; } ?> value="9">9</option>
                        </select>
                    </div>
                </div>
                <div class="form-group btm_border test_hide_show_field">
                                <div class="col-sm-3">
                                    <input type="text" name="test_title_en" id="demo-hor-55" placeholder="<?php echo translate('Taste Meter Rate English');?>" min="1" max="100" value="<?php echo $row['test_title_en']; ?>" class="form-control">
                                </div>
                                <div class="col-sm-3">
                                    <input type="text" name="test_title_ch" id="demo-hor-55" value="<?php echo $row['test_title_ch']; ?>" placeholder="<?php echo translate('Taste Meter Rate Chinese');?>" min="1" max="100" class="form-control">
                                </div>
                                <div class="col-sm-3">
                                    <input type="text" name="test_title_jp" id="demo-hor-55"  value="<?php echo $row['test_title_jp']; ?>" placeholder="<?php echo translate('Taste Meter Rate Japanese');?>" min="1" max="100" class="form-control">
                                </div>
                            </div>
                <div  class="form-group btm_border test_hide_show_field">
                    <div class="col-sm-3" style="display: none;">
                        <input type="text" name="test_sumary_title_en" id="demo-hor-56" placeholder="<?php echo translate('test_sumary_title ');?>" value="<?php echo $row['test_sumary_title_en']; ?>" min="1" max="100" class="form-control">
                    </div>
                    <div class="col-sm-3" style="display: none;">
                        <input type="text" name="test_sumary_title_ch" id="demo-hor-56" placeholder="<?php echo translate('test_sumary_title Chinese');?>" value="<?php echo $row['test_sumary_title_ch']; ?>" min="1" max="100" class="form-control">
                    </div>
                    <div class="col-sm-3" style="display: none;">
                        <input type="text" name="test_sumary_title_jp" id="demo-hor-56" placeholder="<?php echo translate('test_sumary_title Japanese');?>" value="<?php echo $row['test_sumary_title_jp']; ?>" min="1" max="100" class="form-control">
                    </div>
                </div>
                <div class="form-group btm_border test_hide_show_field">
                    <div class="col-sm-3">
                        <textarea type="text" name="test_sumary_en" id="demo-hor-57-en" placeholder="<?php echo translate('test_sumary')." (English)";?>" value="<?php echo $row['test_sumary_en']; ?>" min="1" maxlength="250" class="form-control"><?php echo $row['test_sumary_en']; ?></textarea>
                    </div>
                    <div class="col-sm-3">
                        <textarea type="text" name="test_sumary_ch" id="demo-hor-57-ch" placeholder="<?php echo translate('test_sumary').' (Simplified Chinese)';?>" value="<?php echo $row['test_sumary_ch']; ?>" min="1" maxlength="250" class="form-control"><?php echo $row['test_sumary_ch']; ?></textarea>
                    </div>
                    <div class="col-sm-3">
                        <textarea type="text" name="test_sumary_jp" id="demo-hor-57-jp" placeholder="<?php echo translate('test_sumary').' (Japanese)';?>" value="<?php echo $row['test_sumary_jp']; ?>" min="1" maxlength="250" class="form-control"><?php echo $row['test_sumary_jp']; ?></textarea>
                    </div>
                </div>            
                <!-- Food Section  -->
                <div class="form-group btm_border">
                    <b class="pull-left"><?php echo "Food Pairing (Up to 4 Dishes)";?></b>
                    <div class="col-sm-6">
                        <input type="hidden" name="food_section" placeholder="<?php echo translate('food_section');?>" value="yes"  <?php if($row['food_section'] == 'yes') { echo "checked"; } ?>>
                    </div>
                </div>
                <div style="display: none;" class="form-group btm_border hide_show_field">
                    <label class="col-sm-4 control-label" ><?php echo translate('food_title');?></label>
                    <div class="col-sm-6">
                        <input type="text" name="food_title" value="Food That Goes Well With This" placeholder="<?php echo translate('food_title');?>" value="<?php echo $row['food_title']; ?>" class="form-control">
                    </div>
                </div>
                <div class="form-group btm_border hide_show_field">
                    <div class="col-sm-6">
                        <textarea name="food_description" maxlength="250" rows="3" placeholder="<?php echo translate('food_description');?>" class="form-control"><?php echo $row['food_description']; ?></textarea>
                    </div>
                </div>
                <div class="form-group btm_border hide_show_field">
                    <div class="col-sm-3" style="display: none;">
                        <select name="food_preparation_1" class="form-control">
                            <option value="">Select <?php echo translate('food_preparation_1');?>...</option>
                            <option <?php if($row['food_preparation_1'] == 'Spicy') { echo "selected"; } ?> value="Spicy">Spicy</option>
                            <option  <?php if($row['food_preparation_1'] == 'Grilled') { echo "selected"; } ?> value="Grilled">Grilled</option>
                            <option  <?php if($row['food_preparation_1'] == 'Fried') { echo "selected"; } ?> value="Fried">Fried</option>
                            <option  <?php if($row['food_preparation_1'] == 'Stir Fry') { echo "selected"; } ?> value="Stir Fry">Stir Fry</option>
                            <option  <?php if($row['food_preparation_1'] == 'Deep Fried') { echo "selected"; } ?> value="Deep Fried">Deep Fried</option>
                            <option  <?php if($row['food_preparation_1'] == 'Smoked') { echo "selected"; } ?> value="Smoked">Smoked</option>
                            <option  <?php if($row['food_preparation_1'] == 'Baked') { echo "selected"; } ?> value="Baked">Baked</option>
                            <option  <?php if($row['food_preparation_1'] == 'Stew') { echo "selected"; } ?> value="Stew">Stew</option>
                            <option  <?php if($row['food_preparation_1'] == 'Steamed') { echo "selected"; } ?> value="Steamed">Steamed</option>
                            <option  <?php if($row['food_preparation_1'] == 'Stuffed') { echo "selected"; } ?> value="Stuffed">Stuffed</option>
                            <option  <?php if($row['food_preparation_1'] == 'Boiled') { echo "selected"; } ?> value="Boiled">Boiled</option>
                            <option  <?php if($row['food_preparation_1'] == 'Poach') { echo "selected"; } ?> value="Poach">Poach</option>
                            <option  <?php if($row['food_preparation_1'] == 'Soup') { echo "selected"; } ?> value="Soup">Soup</option>
                            <option  <?php if($row['food_preparation_1'] == 'Green') { echo "selected"; } ?> value="Green">Green</option>
                            <option  <?php if($row['food_preparation_1'] == 'Pickled') { echo "selected"; } ?> value="Pickled">Pickled</option>
                            <option  <?php if($row['food_preparation_1'] == 'Raw') { echo "selected"; } ?> value="Raw">Raw</option>
                            <option  <?php if($row['food_preparation_1'] == 'Aperitif') { echo "selected"; } ?> value="Aperitif">Aperitif</option>
                            <option  <?php if($row['food_preparation_1'] == 'Digestif') { echo "selected"; } ?> value="Digestif">Digestif</option>
                            <option  <?php if($row['food_preparation_1'] == 'Roasted') { echo "selected"; } ?> value="Roasted">Roasted</option>
                            <option  <?php if($row['food_preparation_1'] == 'BBQ') { echo "selected"; } ?> value="BBQ">BBQ</option>
                            <option  <?php if($row['food_preparation_1'] == 'Braised') { echo "selected"; } ?> value="Braised">Braised</option>
                        </select>
                    </div>
                    <div class="col-sm-3" style="display: none;">
                        <select name="food_origin_1" class="form-control">
                            <option value="">Select <?php echo translate('food_origin_1');?>...</option>
                            <option <?php if($row['food_origin_1'] == 'Chinese') { echo "selected"; } ?> value="Chinese">Chinese</option>
                            <option <?php if($row['food_origin_1'] == 'Indonesian') { echo "selected"; } ?> value="Indonesian">Indonesian</option>
                            <option <?php if($row['food_origin_1'] == 'Malaysian') { echo "selected"; } ?> value="Malaysian">Malaysian</option>
                            <option <?php if($row['food_origin_1'] == 'Singaporean') { echo "selected"; } ?> value="Singaporean">Singaporean</option>
                            <option <?php if($row['food_origin_1'] == 'Japanese') { echo "selected"; } ?> value="Japanese">Japanese</option>
                            <option <?php if($row['food_origin_1'] == 'Korean') { echo "selected"; } ?> value="Korean">Korean</option>
                            <option <?php if($row['food_origin_1'] == 'Baked') { echo "selected"; } ?> value="Baked">Baked</option>
                            <option <?php if($row['food_origin_1'] == 'Vietnamese') { echo "selected"; } ?> value="Vietnamese">Vietnamese</option>
                            <option <?php if($row['food_origin_1'] == 'Indian') { echo "selected"; } ?> value="Indian">Indian</option>
                            <option <?php if($row['food_origin_1'] == 'Thai') { echo "selected"; } ?> value="Thai">Thai</option>
                            <option <?php if($row['food_origin_1'] == 'Mexican') { echo "selected"; } ?> value="Mexican">Mexican</option>
                            <option <?php if($row['food_origin_1'] == 'French') { echo "selected"; } ?> value="French">French</option>
                            <option <?php if($row['food_origin_1'] == 'Spanish') { echo "selected"; } ?> value="Spanish">Spanish</option>
                            <option <?php if($row['food_origin_1'] == 'Italian') { echo "selected"; } ?> value="Italian">Italian</option>
                            <option <?php if($row['food_origin_1'] == 'Australian') { echo "selected"; } ?> value="Australian">Australian</option>
                        </select>
                    </div>
                    <div class="col-sm-3">
                        <select name="food_name1" class="form-control food_name" data-id="1">
                            <option value="">Select <?php echo translate('food_pairing_1');?>...</option>
                               <option <?php if($row['food_name1'] == 'Appetizer') { echo "selected"; } ?> value="Appetizer">Appetizers</option>
                              <option <?php if($row['food_name1'] == 'Snacks') { echo "selected"; } ?> value="Snacks">Snacks(peanuts,crackers)</option>
                              <option <?php if($row['food_name1'] == 'Beef') { echo "selected"; } ?>  value="Beef">Beef</option>
                              <option <?php if($row['food_name1'] == 'Lamb') { echo "selected"; } ?> value="Lamb">Lamb</option>
                              <option <?php if($row['food_name1'] == 'Veal') { echo "selected"; } ?> value="Veal">Veal</option>
                              <option <?php if($row['food_name1'] == 'Pork') { echo "selected"; } ?> value="Pork">Pork</option>
                              <option <?php if($row['food_name1'] == 'Game') { echo "selected"; } ?>  value="Game">Game(deer,venison)</option>
                              <option <?php if($row['food_name1'] == 'Poultry') { echo "selected"; } ?> value="Poultry">Poultry</option>
                              <option <?php if($row['food_name1'] == 'Mushrooms') { echo "selected"; } ?> value="Mushrooms">Mushrooms</option>
                              <option <?php if($row['food_name1'] == 'Cured meat') { echo "selected"; } ?> value="Cured meat">Cured meat</option>
                              <option <?php if($row['food_name1'] == 'Mature and hard cheese') { echo "selected"; } ?> value="Mature and hard cheese">Mature and hard cheese</option>
                              <option <?php if($row['food_name1'] == 'Mild and soft cheese') { echo "selected"; } ?> value="Mild and soft cheese">Mild and soft cheese</option>
                              <option <?php if($row['food_name1'] == 'Pasta') { echo "selected"; } ?> value="Pasta">Pasta</option>
                              <option <?php if($row['food_name1'] == 'Noodle') { echo "selected"; } ?> value="Noodle">Noodle</option>
                              <option <?php if($row['food_name1'] == 'Noodle') { echo "selected"; } ?> value="Lean fish">Lean fish</option>
                              <option <?php if($row['food_name1'] == 'Noodle') { echo "selected"; } ?> value="Rich fish(salmon,tuna)">Rich fish(salmon,tuna)</option>
                              <option <?php if($row['food_name1'] == 'Shellfish') { echo "selected"; } ?> value="Shellfish">Shellfish</option>
                              <option <?php if($row['food_name1'] == 'Seafood') { echo "selected"; } ?> value="Seafood">Seafood</option>
                              <option <?php if($row['food_name1'] == 'Crab') { echo "selected"; } ?> value="Crab">Crab</option>
                              <option <?php if($row['food_name1'] == 'Vegetable') { echo "selected"; } ?> value="Vegetable">Vegetable</option>
                              <option <?php if($row['food_name1'] == 'Olives') { echo "selected"; } ?> value="Olives">Olives</option>
                              <option <?php if($row['food_name1'] == 'Dessert') { echo "selected"; } ?> value="Dessert">Dessert</option>
                              <option <?php if($row['food_name1'] == 'Savoury') { echo "selected"; } ?> value="Savoury">Savoury</option>
                        </select>
                    </div>
                    <div class="row food_image1_name">
                    </div>
                    <div class="row food_image1_preview">
                    </div>
                </div>
                <div class="form-group btm_border hide_show_field">
                    <div class="col-sm-3" style="display: none;">
                        <select name="food_preparation_2" class="form-control">
                            <option value="">Select <?php echo translate('food_preparation_2');?>...</option>
                             <option <?php if($row['food_preparation_2'] == 'Spicy') { echo "selected"; } ?> value="Spicy">Spicy</option>
                            <option  <?php if($row['food_preparation_2'] == 'Grilled') { echo "selected"; } ?> value="Grilled">Grilled</option>
                            <option  <?php if($row['food_preparation_2'] == 'Fried') { echo "selected"; } ?> value="Fried">Fried</option>
                            <option  <?php if($row['food_preparation_2'] == 'Stir Fry') { echo "selected"; } ?> value="Stir Fry">Stir Fry</option>
                            <option  <?php if($row['food_preparation_2'] == 'Deep Fried') { echo "selected"; } ?> value="Deep Fried">Deep Fried</option>
                            <option  <?php if($row['food_preparation_2'] == 'Smoked') { echo "selected"; } ?> value="Smoked">Smoked</option>
                            <option  <?php if($row['food_preparation_2'] == 'Baked') { echo "selected"; } ?> value="Baked">Baked</option>
                            <option  <?php if($row['food_preparation_2'] == 'Stew') { echo "selected"; } ?> value="Stew">Stew</option>
                            <option  <?php if($row['food_preparation_2'] == 'Steamed') { echo "selected"; } ?> value="Steamed">Steamed</option>
                            <option  <?php if($row['food_preparation_2'] == 'Stuffed') { echo "selected"; } ?> value="Stuffed">Stuffed</option>
                            <option  <?php if($row['food_preparation_2'] == 'Boiled') { echo "selected"; } ?> value="Boiled">Boiled</option>
                            <option  <?php if($row['food_preparation_2'] == 'Poach') { echo "selected"; } ?> value="Poach">Poach</option>
                            <option  <?php if($row['food_preparation_2'] == 'Soup') { echo "selected"; } ?> value="Soup">Soup</option>
                            <option  <?php if($row['food_preparation_2'] == 'Green') { echo "selected"; } ?> value="Green">Green</option>
                            <option  <?php if($row['food_preparation_2'] == 'Pickled') { echo "selected"; } ?> value="Pickled">Pickled</option>
                            <option  <?php if($row['food_preparation_2'] == 'Raw') { echo "selected"; } ?> value="Raw">Raw</option>
                            <option  <?php if($row['food_preparation_2'] == 'Aperitif') { echo "selected"; } ?> value="Aperitif">Aperitif</option>
                            <option  <?php if($row['food_preparation_2'] == 'Digestif') { echo "selected"; } ?> value="Digestif">Digestif</option>
                            <option  <?php if($row['food_preparation_2'] == 'Roasted') { echo "selected"; } ?> value="Roasted">Roasted</option>
                            <option  <?php if($row['food_preparation_2'] == 'BBQ') { echo "selected"; } ?> value="BBQ">BBQ</option>
                            <option  <?php if($row['food_preparation_2'] == 'Braised') { echo "selected"; } ?> value="Braised">Braised</option>
                        </select>
                    </div>
                    <div class="col-sm-3" style="display: none;">
                        <select name="food_origin_2" class="form-control">
                            <option value="">Select <?php echo translate('food_origin_2');?>...</option>
                            <option <?php if($row['food_origin_2'] == 'Chinese') { echo "selected"; } ?> value="Chinese">Chinese</option>
                            <option <?php if($row['food_origin_2'] == 'Indonesian') { echo "selected"; } ?> value="Indonesian">Indonesian</option>
                            <option <?php if($row['food_origin_2'] == 'Malaysian') { echo "selected"; } ?> value="Malaysian">Malaysian</option>
                            <option <?php if($row['food_origin_2'] == 'Singaporean') { echo "selected"; } ?> value="Singaporean">Singaporean</option>
                            <option <?php if($row['food_origin_2'] == 'Japanese') { echo "selected"; } ?> value="Japanese">Japanese</option>
                            <option <?php if($row['food_origin_2'] == 'Korean') { echo "selected"; } ?> value="Korean">Korean</option>
                            <option <?php if($row['food_origin_2'] == 'Baked') { echo "selected"; } ?> value="Baked">Baked</option>
                            <option <?php if($row['food_origin_2'] == 'Vietnamese') { echo "selected"; } ?> value="Vietnamese">Vietnamese</option>
                            <option <?php if($row['food_origin_2'] == 'Indian') { echo "selected"; } ?> value="Indian">Indian</option>
                            <option <?php if($row['food_origin_2'] == 'Thai') { echo "selected"; } ?> value="Thai">Thai</option>
                            <option <?php if($row['food_origin_2'] == 'Mexican') { echo "selected"; } ?> value="Mexican">Mexican</option>
                            <option <?php if($row['food_origin_2'] == 'French') { echo "selected"; } ?> value="French">French</option>
                            <option <?php if($row['food_origin_2'] == 'Spanish') { echo "selected"; } ?> value="Spanish">Spanish</option>
                            <option <?php if($row['food_origin_2'] == 'Italian') { echo "selected"; } ?> value="Italian">Italian</option>
                            <option <?php if($row['food_origin_2'] == 'Australian') { echo "selected"; } ?> value="Australian">Australian</option>
                        </select>
                    </div>
                    <div class="col-sm-3">
                        <select name="food_name2" class="form-control food_name" data-id="2">
                            <option value="">Select <?php echo translate('food_name2');?>...</option>
                            <option <?php if($row['food_name2'] == 'Appetizer') { echo "selected"; } ?> value="Appetizer">Appetizers</option>
                              <option <?php if($row['food_name2'] == 'Snacks') { echo "selected"; } ?> value="Snacks">Snacks(peanuts,crackers)</option>
                              <option <?php if($row['food_name2'] == 'Beef') { echo "selected"; } ?>  value="Beef">Beef</option>
                              <option <?php if($row['food_name2'] == 'Lamb') { echo "selected"; } ?> value="Lamb">Lamb</option>
                              <option <?php if($row['food_name2'] == 'Veal') { echo "selected"; } ?> value="Veal">Veal</option>
                              <option <?php if($row['food_name2'] == 'Pork') { echo "selected"; } ?> value="Pork">Pork</option>
                              <option <?php if($row['food_name2'] == 'Game') { echo "selected"; } ?>  value="Game">Game(deer,venison)</option>
                              <option <?php if($row['food_name2'] == 'Poultry') { echo "selected"; } ?> value="Poultry">Poultry</option>
                              <option <?php if($row['food_name2'] == 'Mushrooms') { echo "selected"; } ?> value="Mushrooms">Mushrooms</option>
                              <option <?php if($row['food_name2'] == 'Cured meat') { echo "selected"; } ?> value="Cured meat">Cured meat</option>
                              <option <?php if($row['food_name2'] == 'Mature and hard cheese') { echo "selected"; } ?> value="Mature and hard cheese">Mature and hard cheese</option>
                              <option <?php if($row['food_name2'] == 'Mild and soft cheese') { echo "selected"; } ?> value="Mild and soft cheese">Mild and soft cheese</option>
                              <option <?php if($row['food_name2'] == 'Pasta') { echo "selected"; } ?> value="Pasta">Pasta</option>
                              <option <?php if($row['food_name2'] == 'Noodle') { echo "selected"; } ?> value="Noodle">Noodle</option>
                              <option <?php if($row['food_name2'] == 'Noodle') { echo "selected"; } ?> value="Lean fish">Lean fish</option>
                              <option <?php if($row['food_name2'] == 'Noodle') { echo "selected"; } ?> value="Rich fish(salmon,tuna)">Rich fish(salmon,tuna)</option>
                              <option <?php if($row['food_name2'] == 'Shellfish') { echo "selected"; } ?> value="Shellfish">Shellfish</option>
                              <option <?php if($row['food_name2'] == 'Seafood') { echo "selected"; } ?> value="Seafood">Seafood</option>
                              <option <?php if($row['food_name2'] == 'Crab') { echo "selected"; } ?> value="Crab">Crab</option>
                              <option <?php if($row['food_name2'] == 'Vegetable') { echo "selected"; } ?> value="Vegetable">Vegetable</option>
                              <option <?php if($row['food_name2'] == 'Olives') { echo "selected"; } ?> value="Olives">Olives</option>
                              <option <?php if($row['food_name2'] == 'Dessert') { echo "selected"; } ?> value="Dessert">Dessert</option>
                              <option <?php if($row['food_name2'] == 'Savoury') { echo "selected"; } ?> value="Savoury">Savoury</option>
                        </select>
                    </div>
                    <div class="row food_image2_name">
                    </div>
                    <div class="row food_image2_preview">
                    </div>
                </div>
                <div class="form-group btm_border hide_show_field">
                    <div class="col-sm-3" style="display: none;">
                        <select name="food_preparation_3" class="form-control">
                            <option value="">Select <?php echo translate('food_preparation_3');?>...</option>
                             <option <?php if($row['food_preparation_3'] == 'Spicy') { echo "selected"; } ?> value="Spicy">Spicy</option>
                            <option  <?php if($row['food_preparation_3'] == 'Grilled') { echo "selected"; } ?> value="Grilled">Grilled</option>
                            <option  <?php if($row['food_preparation_3'] == 'Fried') { echo "selected"; } ?> value="Fried">Fried</option>
                            <option  <?php if($row['food_preparation_3'] == 'Stir Fry') { echo "selected"; } ?> value="Stir Fry">Stir Fry</option>
                            <option  <?php if($row['food_preparation_3'] == 'Deep Fried') { echo "selected"; } ?> value="Deep Fried">Deep Fried</option>
                            <option  <?php if($row['food_preparation_3'] == 'Smoked') { echo "selected"; } ?> value="Smoked">Smoked</option>
                            <option  <?php if($row['food_preparation_3'] == 'Baked') { echo "selected"; } ?> value="Baked">Baked</option>
                            <option  <?php if($row['food_preparation_3'] == 'Stew') { echo "selected"; } ?> value="Stew">Stew</option>
                            <option  <?php if($row['food_preparation_3'] == 'Steamed') { echo "selected"; } ?> value="Steamed">Steamed</option>
                            <option  <?php if($row['food_preparation_3'] == 'Stuffed') { echo "selected"; } ?> value="Stuffed">Stuffed</option>
                            <option  <?php if($row['food_preparation_3'] == 'Boiled') { echo "selected"; } ?> value="Boiled">Boiled</option>
                            <option  <?php if($row['food_preparation_3'] == 'Poach') { echo "selected"; } ?> value="Poach">Poach</option>
                            <option  <?php if($row['food_preparation_3'] == 'Soup') { echo "selected"; } ?> value="Soup">Soup</option>
                            <option  <?php if($row['food_preparation_3'] == 'Green') { echo "selected"; } ?> value="Green">Green</option>
                            <option  <?php if($row['food_preparation_3'] == 'Pickled') { echo "selected"; } ?> value="Pickled">Pickled</option>
                            <option  <?php if($row['food_preparation_3'] == 'Raw') { echo "selected"; } ?> value="Raw">Raw</option>
                            <option  <?php if($row['food_preparation_3'] == 'Aperitif') { echo "selected"; } ?> value="Aperitif">Aperitif</option>
                            <option  <?php if($row['food_preparation_3'] == 'Digestif') { echo "selected"; } ?> value="Digestif">Digestif</option>
                            <option  <?php if($row['food_preparation_3'] == 'Roasted') { echo "selected"; } ?> value="Roasted">Roasted</option>
                            <option  <?php if($row['food_preparation_3'] == 'BBQ') { echo "selected"; } ?> value="BBQ">BBQ</option>
                            <option  <?php if($row['food_preparation_3'] == 'Braised') { echo "selected"; } ?> value="Braised">Braised</option>
                        </select>
                    </div>
                    <div class="col-sm-3" style="display: none;">
                        <select name="food_origin_3" class="form-control">
                            <option value="">Select <?php echo translate('food_origin_3');?>...</option>
                            <option <?php if($row['food_origin_3'] == 'Chinese') { echo "selected"; } ?> value="Chinese">Chinese</option>
                            <option <?php if($row['food_origin_3'] == 'Indonesian') { echo "selected"; } ?> value="Indonesian">Indonesian</option>
                            <option <?php if($row['food_origin_3'] == 'Malaysian') { echo "selected"; } ?> value="Malaysian">Malaysian</option>
                            <option <?php if($row['food_origin_3'] == 'Singaporean') { echo "selected"; } ?> value="Singaporean">Singaporean</option>
                            <option <?php if($row['food_origin_3'] == 'Japanese') { echo "selected"; } ?> value="Japanese">Japanese</option>
                            <option <?php if($row['food_origin_3'] == 'Korean') { echo "selected"; } ?> value="Korean">Korean</option>
                            <option <?php if($row['food_origin_3'] == 'Baked') { echo "selected"; } ?> value="Baked">Baked</option>
                            <option <?php if($row['food_origin_3'] == 'Vietnamese') { echo "selected"; } ?> value="Vietnamese">Vietnamese</option>
                            <option <?php if($row['food_origin_3'] == 'Indian') { echo "selected"; } ?> value="Indian">Indian</option>
                            <option <?php if($row['food_origin_3'] == 'Thai') { echo "selected"; } ?> value="Thai">Thai</option>
                            <option <?php if($row['food_origin_3'] == 'Mexican') { echo "selected"; } ?> value="Mexican">Mexican</option>
                            <option <?php if($row['food_origin_3'] == 'French') { echo "selected"; } ?> value="French">French</option>
                            <option <?php if($row['food_origin_3'] == 'Spanish') { echo "selected"; } ?> value="Spanish">Spanish</option>
                            <option <?php if($row['food_origin_3'] == 'Italian') { echo "selected"; } ?> value="Italian">Italian</option>
                            <option <?php if($row['food_origin_3'] == 'Australian') { echo "selected"; } ?> value="Australian">Australian</option>
                        </select>
                    </div>
                    <div class="col-sm-3">
                        <select name="food_name3" class="form-control food_name" data-id="3">
                            <option value="">Select <?php echo translate('food_name3');?>...</option>
                            <option <?php if($row['food_name3'] == 'Appetizer') { echo "selected"; } ?> value="Appetizer">Appetizers</option>
                              <option <?php if($row['food_name3'] == 'Snacks') { echo "selected"; } ?> value="Snacks">Snacks(peanuts,crackers)</option>
                              <option <?php if($row['food_name3'] == 'Beef') { echo "selected"; } ?>  value="Beef">Beef</option>
                              <option <?php if($row['food_name3'] == 'Lamb') { echo "selected"; } ?> value="Lamb">Lamb</option>
                              <option <?php if($row['food_name3'] == 'Veal') { echo "selected"; } ?> value="Veal">Veal</option>
                              <option <?php if($row['food_name3'] == 'Pork') { echo "selected"; } ?> value="Pork">Pork</option>
                              <option <?php if($row['food_name3'] == 'Game') { echo "selected"; } ?>  value="Game">Game(deer,venison)</option>
                              <option <?php if($row['food_name3'] == 'Poultry') { echo "selected"; } ?> value="Poultry">Poultry</option>
                              <option <?php if($row['food_name3'] == 'Mushrooms') { echo "selected"; } ?> value="Mushrooms">Mushrooms</option>
                              <option <?php if($row['food_name3'] == 'Cured meat') { echo "selected"; } ?> value="Cured meat">Cured meat</option>
                              <option <?php if($row['food_name3'] == 'Mature and hard cheese') { echo "selected"; } ?> value="Mature and hard cheese">Mature and hard cheese</option>
                              <option <?php if($row['food_name3'] == 'Mild and soft cheese') { echo "selected"; } ?> value="Mild and soft cheese">Mild and soft cheese</option>
                              <option <?php if($row['food_name3'] == 'Pasta') { echo "selected"; } ?> value="Pasta">Pasta</option>
                              <option <?php if($row['food_name3'] == 'Noodle') { echo "selected"; } ?> value="Noodle">Noodle</option>
                              <option <?php if($row['food_name3'] == 'Noodle') { echo "selected"; } ?> value="Lean fish">Lean fish</option>
                              <option <?php if($row['food_name3'] == 'Noodle') { echo "selected"; } ?> value="Rich fish(salmon,tuna)">Rich fish(salmon,tuna)</option>
                              <option <?php if($row['food_name3'] == 'Shellfish') { echo "selected"; } ?> value="Shellfish">Shellfish</option>
                              <option <?php if($row['food_name3'] == 'Seafood') { echo "selected"; } ?> value="Seafood">Seafood</option>
                              <option <?php if($row['food_name3'] == 'Crab') { echo "selected"; } ?> value="Crab">Crab</option>
                              <option <?php if($row['food_name3'] == 'Vegetable') { echo "selected"; } ?> value="Vegetable">Vegetable</option>
                              <option <?php if($row['food_name3'] == 'Olives') { echo "selected"; } ?> value="Olives">Olives</option>
                              <option <?php if($row['food_name3'] == 'Dessert') { echo "selected"; } ?> value="Dessert">Dessert</option>
                              <option <?php if($row['food_name3'] == 'Savoury') { echo "selected"; } ?> value="Savoury">Savoury</option>
                        </select>
                    </div>
                    <div class="row food_image3_name">
                    </div>
                    <div class="row food_image3_preview">
                    </div>
                </div>
                <div class="form-group btm_border hide_show_field">
                    <div class="col-sm-3" style="display: none;">
                        <select name="food_preparation_4" class="form-control">
                            <option value="">Select <?php echo translate('food_preparation_4');?>...</option>
                            <option <?php if($row['food_preparation_4'] == 'Spicy') { echo "selected"; } ?> value="Spicy">Spicy</option>
                            <option  <?php if($row['food_preparation_4'] == 'Grilled') { echo "selected"; } ?> value="Grilled">Grilled</option>
                            <option  <?php if($row['food_preparation_4'] == 'Fried') { echo "selected"; } ?> value="Fried">Fried</option>
                            <option  <?php if($row['food_preparation_4'] == 'Stir Fry') { echo "selected"; } ?> value="Stir Fry">Stir Fry</option>
                            <option  <?php if($row['food_preparation_4'] == 'Deep Fried') { echo "selected"; } ?> value="Deep Fried">Deep Fried</option>
                            <option  <?php if($row['food_preparation_4'] == 'Smoked') { echo "selected"; } ?> value="Smoked">Smoked</option>
                            <option  <?php if($row['food_preparation_4'] == 'Baked') { echo "selected"; } ?> value="Baked">Baked</option>
                            <option  <?php if($row['food_preparation_4'] == 'Stew') { echo "selected"; } ?> value="Stew">Stew</option>
                            <option  <?php if($row['food_preparation_4'] == 'Steamed') { echo "selected"; } ?> value="Steamed">Steamed</option>
                            <option  <?php if($row['food_preparation_4'] == 'Stuffed') { echo "selected"; } ?> value="Stuffed">Stuffed</option>
                            <option  <?php if($row['food_preparation_4'] == 'Boiled') { echo "selected"; } ?> value="Boiled">Boiled</option>
                            <option  <?php if($row['food_preparation_4'] == 'Poach') { echo "selected"; } ?> value="Poach">Poach</option>
                            <option  <?php if($row['food_preparation_4'] == 'Soup') { echo "selected"; } ?> value="Soup">Soup</option>
                            <option  <?php if($row['food_preparation_4'] == 'Green') { echo "selected"; } ?> value="Green">Green</option>
                            <option  <?php if($row['food_preparation_4'] == 'Pickled') { echo "selected"; } ?> value="Pickled">Pickled</option>
                            <option  <?php if($row['food_preparation_4'] == 'Raw') { echo "selected"; } ?> value="Raw">Raw</option>
                            <option  <?php if($row['food_preparation_4'] == 'Aperitif') { echo "selected"; } ?> value="Aperitif">Aperitif</option>
                            <option  <?php if($row['food_preparation_4'] == 'Digestif') { echo "selected"; } ?> value="Digestif">Digestif</option>
                            <option  <?php if($row['food_preparation_4'] == 'Roasted') { echo "selected"; } ?> value="Roasted">Roasted</option>
                            <option  <?php if($row['food_preparation_4'] == 'BBQ') { echo "selected"; } ?> value="BBQ">BBQ</option>
                            <option  <?php if($row['food_preparation_4'] == 'Braised') { echo "selected"; } ?> value="Braised">Braised</option>
                        </select>
                    </div>
                    <div class="col-sm-3" style="display: none;">
                        <select name="food_origin_4" class="form-control">
                            <option value="">Select <?php echo translate('food_origin_4');?>...</option>
                             <option <?php if($row['food_origin_4'] == 'Chinese') { echo "selected"; } ?> value="Chinese">Chinese</option>
                            <option <?php if($row['food_origin_4'] == 'Indonesian') { echo "selected"; } ?> value="Indonesian">Indonesian</option>
                            <option <?php if($row['food_origin_4'] == 'Malaysian') { echo "selected"; } ?> value="Malaysian">Malaysian</option>
                            <option <?php if($row['food_origin_4'] == 'Singaporean') { echo "selected"; } ?> value="Singaporean">Singaporean</option>
                            <option <?php if($row['food_origin_4'] == 'Japanese') { echo "selected"; } ?> value="Japanese">Japanese</option>
                            <option <?php if($row['food_origin_4'] == 'Korean') { echo "selected"; } ?> value="Korean">Korean</option>
                            <option <?php if($row['food_origin_4'] == 'Baked') { echo "selected"; } ?> value="Baked">Baked</option>
                            <option <?php if($row['food_origin_4'] == 'Vietnamese') { echo "selected"; } ?> value="Vietnamese">Vietnamese</option>
                            <option <?php if($row['food_origin_4'] == 'Indian') { echo "selected"; } ?> value="Indian">Indian</option>
                            <option <?php if($row['food_origin_4'] == 'Thai') { echo "selected"; } ?> value="Thai">Thai</option>
                            <option <?php if($row['food_origin_4'] == 'Mexican') { echo "selected"; } ?> value="Mexican">Mexican</option>
                            <option <?php if($row['food_origin_4'] == 'French') { echo "selected"; } ?> value="French">French</option>
                            <option <?php if($row['food_origin_4'] == 'Spanish') { echo "selected"; } ?> value="Spanish">Spanish</option>
                            <option <?php if($row['food_origin_4'] == 'Italian') { echo "selected"; } ?> value="Italian">Italian</option>
                            <option <?php if($row['food_origin_4'] == 'Australian') { echo "selected"; } ?> value="Australian">Australian</option>
                        </select>
                    </div>
                    <div class="col-sm-3">
                        <select name="food_name4" class="form-control food_name" data-id="4">
                            <option value="">Select <?php echo translate('food_name4');?>...</option>
                            <option <?php if($row['food_name4'] == 'Appetizer') { echo "selected"; } ?> value="Appetizer">Appetizers</option>
                              <option <?php if($row['food_name4'] == 'Snacks') { echo "selected"; } ?> value="Snacks">Snacks(peanuts,crackers)</option>
                              <option <?php if($row['food_name4'] == 'Beef') { echo "selected"; } ?>  value="Beef">Beef</option>
                              <option <?php if($row['food_name4'] == 'Lamb') { echo "selected"; } ?> value="Lamb">Lamb</option>
                              <option <?php if($row['food_name4'] == 'Veal') { echo "selected"; } ?> value="Veal">Veal</option>
                              <option <?php if($row['food_name4'] == 'Pork') { echo "selected"; } ?> value="Pork">Pork</option>
                              <option <?php if($row['food_name4'] == 'Game') { echo "selected"; } ?>  value="Game">Game(deer,venison)</option>
                              <option <?php if($row['food_name4'] == 'Poultry') { echo "selected"; } ?> value="Poultry">Poultry</option>
                              <option <?php if($row['food_name4'] == 'Mushrooms') { echo "selected"; } ?> value="Mushrooms">Mushrooms</option>
                              <option <?php if($row['food_name4'] == 'Cured meat') { echo "selected"; } ?> value="Cured meat">Cured meat</option>
                              <option <?php if($row['food_name4'] == 'Mature and hard cheese') { echo "selected"; } ?> value="Mature and hard cheese">Mature and hard cheese</option>
                              <option <?php if($row['food_name4'] == 'Mild and soft cheese') { echo "selected"; } ?> value="Mild and soft cheese">Mild and soft cheese</option>
                              <option <?php if($row['food_name4'] == 'Pasta') { echo "selected"; } ?> value="Pasta">Pasta</option>
                              <option <?php if($row['food_name4'] == 'Noodle') { echo "selected"; } ?> value="Noodle">Noodle</option>
                              <option <?php if($row['food_name4'] == 'Noodle') { echo "selected"; } ?> value="Lean fish">Lean fish</option>
                              <option <?php if($row['food_name4'] == 'Noodle') { echo "selected"; } ?> value="Rich fish(salmon,tuna)">Rich fish(salmon,tuna)</option>
                              <option <?php if($row['food_name4'] == 'Shellfish') { echo "selected"; } ?> value="Shellfish">Shellfish</option>
                              <option <?php if($row['food_name4'] == 'Seafood') { echo "selected"; } ?> value="Seafood">Seafood</option>
                              <option <?php if($row['food_name4'] == 'Crab') { echo "selected"; } ?> value="Crab">Crab</option>
                              <option <?php if($row['food_name4'] == 'Vegetable') { echo "selected"; } ?> value="Vegetable">Vegetable</option>
                              <option <?php if($row['food_name4'] == 'Olives') { echo "selected"; } ?> value="Olives">Olives</option>
                              <option <?php if($row['food_name4'] == 'Dessert') { echo "selected"; } ?> value="Dessert">Dessert</option>
                              <option <?php if($row['food_name4'] == 'Savoury') { echo "selected"; } ?> value="Savoury">Savoury</option>
                        </select>
                    </div>
                    <div class="row food_image4_name">
                    </div>
                    <div class="row food_image4_preview">
                    </div>
                </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="panel-footer">
                <div class="row">
                    <div class="col-md-1">
                        <span class="btn btn-purple btn-labeled fa fa-refresh pro_list_btn" 
                            onclick="ajax_set_full('edit','<?php echo translate('edit_product'); ?>','<?php echo translate('successfully_edited!'); ?>','product_edit','<?php echo $row['product_id']; ?>') "><?php echo translate('reset');?>
                        </span>
                     </div>
                     <div class="col-md-11">
                        <span class="btn btn-success btn-md btn-labeled fa fa-wrench pull-right enterer" onclick="form_submit('product_edit','<?php echo translate('successfully_edited!'); ?>');proceed('to_add');" ><?php echo translate('edit');?></span> 
                     </div>
                </div>
            </div>
        </form>
    </div>
</div>
<?php
    }
?>
<!--Bootstrap Tags Input [ OPTIONAL ]-->
<script src="<?php echo base_url(); ?>template/back/plugins/bootstrap-tagsinput/bootstrap-tagsinput.min.js"></script>
<input type="hidden" id="option_count" value="<?php if($r == 1){ echo $row1['no']; } else { echo '0'; } ?>">
<?php 
if($row['food_section'] != 'yes')
{
    ?>
<style type="text/css">
    .xhide_show_field
    {
        display: none;
    }
</style>
<?php
}
?>
<!-- Test Section -->
<?php 
if($row['test_section'] != 'yes')
{
    ?>
     <style type="text/css">
        .xtest_hide_show_field
        {
            display: none;
        }  
    </style>
<?php
}
?>

<script type="text/javascript">
    $("input[name = 'food_section']").click(function() {
        if($("input[name = 'food_section']").is(':checked'))
        {
            $('.hide_show_field').show();
        }
        else
        {
            $('.hide_show_field').hide();
        }
    });

    $("input[name = 'test_section']").click(function() {
        if($("input[name = 'test_section']").is(':checked'))
        {
            $('.test_hide_show_field').show();
        }
        else
        {
            $('.test_hide_show_field').hide();
        }
    });
    window.preview = function (input) {
        if (input.files && input.files[0]) {
            $("#previewImg").html('');
            $(input.files).each(function () {
                var reader = new FileReader();
                reader.readAsDataURL(this);
                reader.onload = function (e) {
                    $("#previewImg").append("<div style='float:left;border:4px solid #303641;padding:5px;margin:5px;'><img height='80' src='" + e.target.result + "'></div>");
                }
            });
        }
    }
    $('.delete-product-img').on('click', function() 
    { 
        var pid = $(this).data('id'); 
        var productid = $(this).data('product-id'); 
        var here = $(this); 
        msg = 'Really want to delete this Image?'; 
        bootbox.confirm(msg, function(result) {
            if (result) { 
                 $.ajax({ 
                    url: base_url+''+user_type+'/'+module+'/dlt_img/'+pid+'/'+productid, 
                    cache: false, 
                    success: function(data) { 
                        $('input[name="last_products_images"]').attr('value',data);
                        $.activeitNoty({ 
                            type: 'success', 
                            icon : 'fa fa-check', 
                            message : 'Deleted Successfully', 
                            container : 'floating', 
                            timer : 3000 
                        }); 
                        here.closest('.delete-div-wrap').remove(); 
                    } 
                }); 
            }else{ 
                $.activeitNoty({ 
                    type: 'danger', 
                    icon : 'fa fa-minus', 
                    message : 'Cancelled', 
                    container : 'floating', 
                    timer : 3000 
                }); 
            }; 
          }); 
        }); 
        

    function other_forms(){}
    
    function set_summer(){
        $('.summernotes').each(function() {
            var now = $(this);
            var h = now.data('height');
            var n = now.data('name');
            if(now.closest('div').find('.val').length == 0){
                now.closest('div').append('<input type="hidden" class="val" name="'+n+'">');
            }
            now.summernote({
                height: h,
                onChange: function() {
                    now.closest('div').find('.val').val(now.code());
                }
            });
            now.closest('div').find('.val').val(now.code());
        });
    }

    function option_count(type){
        var count = $('#option_count').val();
        if(type == 'add'){
            count++;
        }
        if(type == 'reduce'){
            count--;
        }
        $('#option_count').val(count);
    }

    function set_select(){
        $('.demo-chosen-select').chosen();
        $('.demo-cs-multiselect').chosen({width:'100%'});
    }
    
    $(document).ready(function() {
        set_select();
        set_summer();
        createColorpickers();
    });

    function other(){
        $('.demo-chosen-select').chosen();
        $('.demo-cs-multiselect').chosen({width:'100%'});
        $('#sub').show('slow');
    }
    function get_cat(id){
        $('#brn').hide('slow');
        $('#sub').hide('slow');
        ajax_load(base_url+'vendor/product/sub_by_cat/'+id,'sub_cat','other');
    }
    function get_brnd(id){
        $('#brn').hide('slow');
        ajax_load(base_url+'vendor/product/brand_by_sub/'+id,'brand','other');
        $('#brn').show('slow');
    }

    function get_sub_res(id){}

    $(".unit").on('keyup',function(){
        $(".unit_set").html($(".unit").val());
    });
    
    function createColorpickers() {
    
        $('.demo2').colorpicker({
            format: 'rgba'
        });
        
    }
    
    
    $("#more_btn").click(function(){
        $("#more_additional_fields").append(''
            +'<div class="form-group">'
            +'    <div class="col-sm-4">'
            +'        <input type="text" name="ad_field_names[]" class="form-control"  placeholder="<?php echo translate('field_name'); ?>">'
            +'    </div>'
            +'    <div class="col-sm-5">'
            +'        <textarea rows="9"  class="summernotes" data-height="100" data-name="ad_field_values[]"></textarea>'
            +'    </div>'
            +'    <div class="col-sm-2">'
            +'        <span class="remove_it_v rms btn btn-danger btn-icon btn-circle icon-lg fa fa-times" onclick="delete_row(this)"></span>'
            +'    </div>'
            +'</div>'
        );
        set_summer();
    });
    
    
    $("#more_option_btn").click(function(){
        option_count('add');
        var co = $('#option_count').val();
        $("#more_additional_options").append(''
            +'<div class="form-group" data-no="'+co+'">'
            +'    <div class="col-sm-4">'
            +'        <input type="text" name="op_title[]" class="form-control required"  placeholder="<?php echo translate('customer_input_title'); ?>">'
            +'    </div>'
            +'    <div class="col-sm-5">'
            +'        <select class="demo-chosen-select op_type required" name="op_type[]" >'
            +'            <option value="">(none)</option>'
            +'            <option value="text">Text Input</option>'
            +'            <option value="single_select">Dropdown Single Select</option>'
            +'            <option value="multi_select">Dropdown Multi Select</option>'
            +'            <option value="radio">Radio</option>'
            +'        </select>'
            +'        <div class="col-sm-12 options">'
            +'          <input type="hidden" name="op_set'+co+'[]" value="none" >'
            +'        </div>'
            +'    </div>'
            +'    <input type="hidden" name="op_no[]" value="'+co+'" >'
            +'    <div class="col-sm-2">'
            +'        <span class="remove_it_o rmo btn btn-danger btn-icon btn-circle icon-lg fa fa-times" onclick="delete_row(this)"></span>'
            +'    </div>'
            +'</div>'
        );
        set_select();
    });
    
    $("#more_additional_options").on('change','.op_type',function(){
        var co = $(this).closest('.form-group').data('no');
        if($(this).val() !== 'text' && $(this).val() !== ''){
            $(this).closest('div').find(".options").html(''
                +'    <div class="col-sm-12">'
                +'        <div class="col-sm-12 options margin-bottom-10"></div><br>'
                +'        <div class="btn btn-mint btn-labeled fa fa-plus pull-right add_op">'
                +'        <?php echo translate('add_options_for_choice');?></div>'
                +'    </div>'
            );
        } else if ($(this).val() == 'text' || $(this).val() == ''){
            $(this).closest('div').find(".options").html(''
                +'    <input type="hidden" name="op_set'+co+'[]" value="none" >'
            );
        }
    });
    
    $("#more_additional_options").on('click','.add_op',function(){
        var co = $(this).closest('.form-group').data('no');
        $(this).closest('.col-sm-12').find(".options").append(''
            +'    <div>'
            +'        <div class="col-sm-10">'
            +'          <input type="text" name="op_set'+co+'[]" class="form-control required"  placeholder="<?php echo translate('option_name'); ?>">'
            +'        </div>'
            +'        <div class="col-sm-2">'
            +'          <span class="remove_it_n rmon btn btn-danger btn-icon btn-circle icon-sm fa fa-times" onclick="delete_row(this)"></span>'
            +'        </div>'
            +'    </div>'
        );
    });
    
    $('body').on('click', '.rmo', function(){
        $(this).parent().parent().remove();
    });

    function next_tab(){
        $('.nav-tabs li.active').next().find('a').click();                    
    }
    function previous_tab(){
        $('.nav-tabs li.active').prev().find('a').click();                     
    }
    
    $('body').on('click', '.rmon', function(){
        var co = $(this).closest('.form-group').data('no');
        $(this).parent().parent().remove();
        if($(this).parent().parent().parent().html() == ''){
            $(this).parent().parent().parent().html(''
                +'   <input type="hidden" name="op_set'+co+'[]" value="none" >'
            );
        }
    });

    
    $('body').on('click', '.rms', function(){
        $(this).parent().parent().remove();
    });


    $("#more_color_btn").click(function(){
        $("#more_colors").append(''
            +'      <div class="col-md-12" style="margin-bottom:8px;">'
            +'          <div class="col-md-8">'
            +'              <div class="input-group demo2">'
            +'                 <input type="text" value="#ccc" name="color[]" class="form-control" />'
            +'                 <span class="input-group-addon"><i></i></span>'
            +'              </div>'
            +'          </div>'
            +'          <span class="col-md-4">'
            +'              <span class="remove_it_v rmc btn btn-danger btn-icon btn-circle icon-lg fa fa-times" ></span>'
            +'          </span>'
            +'      </div>'
        );
        createColorpickers();
    });                

    $('body').on('click', '.rmc', function(){
        $(this).parent().parent().remove();
    });

    
    function delete_row(e)
    {
        e.parentNode.parentNode.parentNode.removeChild(e.parentNode.parentNode);
    }    
    
    
    $(document).ready(function() {
        $("form").submit(function(e){
            event.preventDefault();
        });
    });
    $('.food_name').change(function()
    {
        var id = $(this).attr('data-id');
        var food_name = $(this).val();
        var food_image;
        food_name_funct(id,food_name,food_image); 
    });
    food_name_funct(id=1,food_name="<?php echo $row['food_name1'] ?>",food_image="<?php echo $row['food_image1'] ?>");
    food_name_funct(id=2,food_name="<?php echo $row['food_name2'] ?>",food_image="<?php echo $row['food_image2'] ?>");
    food_name_funct(id=3,food_name="<?php echo $row['food_name3'] ?>",food_image="<?php echo $row['food_image3'] ?>");
    food_name_funct(id=4,food_name="<?php echo $row['food_name4'] ?>",food_image="<?php echo $row['food_image4'] ?>");
    
    
    function food_name_funct(id,food_name,food_image)
    {
        var Appetizer = ['antipesto.jpeg','Bread_dip.jpeg','Bruschetta.jpeg','curry_puff.jpeg','japanese_squid_ball_Takoyaki.jpeg','meatball.jpeg','mini_quiche_pastry.jpeg','nuts.jpeg','olives.jpeg','Pate.jpeg','rice-cracker.jpg','savoury_pastry.jpeg','smoked_salmon_cream_cheese.jpeg','soup.jpeg','spring_roll.jpeg','yum_cha_dim_sim.jpeg'];        
    
        var Snacks=['antipesto.jpeg','Bread_dip.jpeg','Bruschetta.jpeg','curry_puff.jpeg','japanese_squid_ball_Takoyaki.jpeg','meatball.jpeg','mini_quiche_pastry.jpeg','nuts.jpeg','olives.jpeg','Pate.jpeg','rice-cracker.jpg','savoury_pastry.jpeg','smoked_salmon_cream_cheese.jpeg','Soup.jpeg','spring_roll.jpeg','yum_cha_dim_sim.jpeg'];
        var Beef = ['BBQ_Grill.jpg','beef-rendang1.jpg','Curry_meat.jpg','Deep_fry_or_stir_fry.jpeg','Grill_BBQ_Lamb.jpeg','Grill_BBQ_Roast.jpeg','hotpot_Lamb_Beef.jpeg','hot-pot-meat.jpg','lamb-shank.jpeg','Meat-salad.jpg','pie-pastry.jpg','skewer-Grill_meat.jpeg','Smoked-meat.jpg','Stew.jpg','Stirfry_Spicy.jpeg','Waygu-Beef.jpeg'];
        var Lamb=['BBQ_Grill.jpg','beef-rendang1.jpg','Curry_meat.jpg','Deep_fry_or_stir_fry.jpeg','Grill_BBQ_Lamb.jpeg','Grill_BBQ_Roast.jpeg','hotpot_Lamb_Beef.jpeg','hot-pot_meat.jpg','lamb_shank.jpeg','Meat_salad.jpg','pie_pastry.jpeg','skewer_Grill_meat.jpeg','Smoked_meat.jpg','Stew.jpg','Stirfry_Spicy.jpeg','Waygu_Beef.jpeg'];
        var Veal=['Babi_Kecap-pork_dish.jpeg','Chinese_BBQ_roast_pork.jpeg','crumbed_veal.jpeg','Deep_fried_Pork.jpeg','Pork_Belly.jpeg','pork_dumpling.jpeg','Pork_Katsu_curry.jpg','Pork_ribs.jpeg','Pork_Skwer.jpeg','Pork_stew.jpeg','pull_pork_salad.jpeg','roast_pork.jpeg','spicy_pork.jpeg','Steamed_poach_Boiled.jpg','stir_fry_pork_mince.jpeg','Veal.jpeg'];
        var Pork=['Babi_Kecap-pork_dish.jpeg','ChineseBBQ_roast_pork.jpeg','crumbed_veal.jpeg','Deep_fried_Pork.jpeg','Pork_Belly.jpeg','pork_dumpling.jpeg','Pork_Katsu_curry.jpg','Pork_ribs.jpeg','Pork_Skwer.jpeg','Pork_stew.jpeg','pull_pork_salad.jpeg','roast_pork.jpeg','spicy_pork.jpeg','Steamed_poach_Boiled.jpg','stir_fry_pork_mince.jpeg','Veal.jpeg'];
        var Game=['BBQ_Grill.jpg','beef-rendang1.jpg','Curry_meat.jpg','Deep_fry_or_stir_fry.jpeg','Grill_BBQ_Lamb.jpeg','Grill_BBQ_Roast.jpeg','hotpot_Lamb_Beef.jpeg','hot-pot_meat.jpg','lamb_shank.jpeg','Meat_salad.jpg','pie_pastry.jpeg','skewer_Grill_meat.jpeg','Smoked_meat.jpg','Stew.jpg','Stirfry_Spicy.jpeg','Waygu_Beef.jpeg'];
        var Poultry=['Chicken_Ceasar_Salad.jpeg','Chicken_Curry.jpeg','chicken_Parmigiana.jpeg','chicken_skewer.jpeg','Chinese_Soy_Chicken.jpg','duck_confit.jpeg','Fried_Chicken_korean.jpeg','Grill_Chicken.jpeg','Hainan_Chicken.jpeg','Hotpot_Chicken_steam_boil.jpeg','indonesian_chicken.jpeg','Lemongrass_chicken.jpeg','Peking_duck.jpeg','Quail.jpeg','spicy_stir_fry_Chicken.jpeg','Tandori_Chicken.jpeg'];
        var Mushrooms=['braised_shitake_mushroom.jpeg','clay_pot_vegetable_braised.jpeg','fried_mushroom.jpeg','garlic_mushroom.jpeg','mix_salad.jpeg','roast_vegetable.jpeg','soup_pumpkin.jpeg','spicy_vegetable_kim_chi.jpeg','steam_vegetable.jpeg','stir_fry.jpeg','stuffed_mushroom.jpeg','vegetable_curry.jpeg','vegetable_pie_quiche.jpeg','vegetable_stew.jpeg','vegetable_tempura.jpeg','vegeterian_pizza.jpeg'];
        var Pasta=['bibimbap.jpeg','Char_Kway_teow.jpeg','Chinese_sticky_rice.jpeg','Fried_rice.jpeg','Hainan_chicken_rice.jpegindian_rice.jpeg','Lasagne_pasta_bake.jpeg','Paella_rice.jpeg','Pasta.jpeg','pasta_salad.jpg','Ramen.jpeg','Risotto.jpeg','Seafood_laksa.jpeg','Spicy_meat_soup_noodle.jpeg','tortellini.jpeg','vietnamese_noodle_Pho.jpeg'];
        var Noodle=['bibimbap.jpeg','Char_Kway_teow.jpeg','Chinese_sticky_rice.jpeg','Fried_rice.jpeg','Hainan_chicken_rice.jpeg','indian_rice.jpeg','Lasagne_pasta_bake.jpeg','Paella_rice.jpeg','Pasta.jpeg','pasta_salad.jpg','Ramen.jpeg','Risotto.jpeg','Seafood_laksa.jpeg','Spicy_meat_soup_noodle.jpeg','tortellini.jpeg','vietnamese_noodle_Pho.jpeg'];
        var Fish=['abalone.jpeg','battered_fish.jpeg','Chilli_Crab.jpeg','fish_curry.jpeg','Grill_fish.jpeg','lobstor_stir_fry.jpeg','oyster_natural_shellfish.jpeg','Pan_seared_salmon.jpeg','prawns.jpeg','Seafood_soup.jpeg','seared_scallop.jpeg','shellfish_oven_baked.jpeg','spicy_stirfry_squid.jpeg','steam_fish.jpeg','Sushi_raw_fish.jpeg','unagi_eel.jpeg'];
        var Shellfish=['abalone.jpeg','battered_fish.jpeg','Chilli_Crab.jpeg','fish_curry.jpeg','Grill_fish.jpeg','lobstor_stir_fry.jpeg','oyster_natural_shellfish.jpeg','Pan_seared_salmon.jpeg','prawns.jpeg','Seafood_soup.jpeg','seared_scallop.jpeg','shellfish_oven_baked.jpeg','spicy_stirfry_squid.jpeg','steam_fish.jpeg','Sushi_raw_fish.jpeg','unagi_eel.jpeg'];
        var Seafood=['abalone.jpeg','battered_fish.jpeg','Chilli_Crab.jpeg','fish_curry.jpeg','Grill_fish.jpeg','lobstor_stir_fry.jpeg','oyster_natural_shellfish.jpeg','Pan_seared_salmon.jpeg','prawns.jpeg','Seafood_soup.jpeg','seared_scallop.jpeg','shellfish_oven_baked.jpeg','spicy_stirfry_squid.jpeg','steam_fish.jpeg','Sushi_raw_fish.jpeg','unagi_eel.jpeg'];

        var Vegetables=['braised_shitake_mushroom.jpeg','clay_pot_vegetable_braised.jpeg','fried_mushroom.jpeg','garlic_mushroom.jpeg','mix_salad.jpeg','roast_vegetable.jpeg','soup_pumpkin.jpeg','spicy_vegetable_kim_chi.jpeg','steam_vegetable.jpeg','stir_fry.jpeg','stuffed_mushroom.jpeg','vegetable_curry.jpeg','vegetable_pie_quiche.jpeg','vegetable_stew.jpeg','vegetable_tempura.jpeg','vegeterian_pizza.jpeg'];

        var Savoury=['antipesto.jpeg','Bread_dip.jpeg','Bruschetta.jpeg','curry_puff.jpeg','japanese_squid_ball_Takoyaki.jpeg','meatball.jpeg','mini_quiche_pastry.jpeg','nuts.jpeg','olives.jpeg','Pate.jpeg','rice-cracker.jpg','savoury_pastry.jpeg','smoked_salmon_cream_cheese.jpeg','Soup.jpeg','spring_roll.jpeg','yum_cha_dim_sim.jpeg'];

        var Dessert=['cheese_cake.jpeg','cheese_platter.jpeg','chinese_sweet_soup.jpeg','creme_brulee.jpeg','custard_bun.jpeg','fried_red_bean_pancake.jpeg','fruit.jpeg','icecream_gelato_sorbet.jpeg','macaron.jpeg','Matcha_dessert.jpeg','mochi.jpeg','mousse.jpeg','Souffle.jpeg','Sticky_rice_dessert.jpeg','tiramisu.jpeg','waffles.jpeg'];

        var Rice=['bibimbap.jpeg','Char_Kway_teow.jpeg','Chinese_sticky_rice.jpeg','Fried_rice.jpeg','Hainan_chicken_rice.jpeg','indian_rice.jpeg','Lasagne_pasta_bake.jpeg','Paella_rice.jpeg','Pasta.jpeg','pasta_salad.jpg','Ramen.jpeg','Risotto.jpeg','Seafood_laksa.jpeg','Spicy_meat_soup_noodle.jpeg','tortellini.jpeg','vietnamese_noodle_Pho.jpeg'];
        var Cheese=['cheese_cake.jpeg','cheese_platter.jpeg','chinese_sweet_soup.jpeg','creme_brulee.jpeg','custard_bun.jpeg','fried_red_bean_pancake.jpeg','fruit.jpeg','icecream_gelato_sorbet.jpeg','macaron.jpeg','Matcha_dessert.jpeg','mochi.jpeg','mousse.jpeg','Souffle.jpeg','Sticky_rice_dessert.jpeg','tiramisu.jpeg','waffles.jpeg'];

        var food_name,images_name="";
        var loop = 1;
        var checkedImg = "";
        console.log(food_name,food_image,'------',typeof eval(food_name))
        for (image of eval(food_name)) {
            checkedImg = "";
            if(image == food_image)
                checkedImg = "checked";
            if(loop <= 10)
                images_name += '<div class="col-md-2"><input type ="radio" name="food_image'+id+'" value="'+image+'" '+checkedImg+'><img style="height: 86px;width: 135px;" src="' + base_url + 'uploads/food_paring/' + food_name + '/' + image + '"></div>';

            loop++; 
        }
        // if(food_name == 'Appetizer')
        // {
        //     images_name +="<select class='form-control image_name' name='food_image"+id+"' paring='"+food_name+"' image-food-id="+id+"  ><option value=''>Select...</option>";

        //     for (Appetizers of Appetizer) 
        //     {
        //         if(food_image == Appetizers)
        //         {
        //             images_name += "<option selected value="+Appetizers+">"+Appetizers+"</option>";
        //         }
        //         else
        //         {
        //             images_name += "<option value="+Appetizers+">"+Appetizers+"</option>";
        //         }
        //     }
        //     images_name +='</select>';
        // }
        // var Snackss;
        // if(food_name == 'Snacks')
        // {
        //     images_name +="<select class='form-control image_name' name='food_image"+id+"' paring='"+food_name+"' image-food-id="+id+"  ><option value=''>Select...</option>";

        //     for (Snackss of Snacks) 
        //     {
        //         if(food_image == Snackss)
        //         {
        //             images_name += "<option selected value="+Snackss+">"+Snackss+"</option>";
        //         }
        //         else
        //         {
        //             images_name += "<option value="+Snackss+">"+Snackss+"</option>";
        //         }
        //     }
        //     images_name +='</select>';
        // }
        // var Beefs;
        // if(food_name == 'Beef')
        // {
        //     images_name +="<select class='form-control image_name' name='food_image"+id+"' paring='"+food_name+"' image-food-id="+id+"  ><option value=''>Select...</option>";

        //     for (Beefs of Beef) 
        //     {
        //         if(food_image == Beefs)
        //         {
        //             images_name += "<option selected value="+Beefs+">"+Beefs+"</option>";
        //         }
        //         else
        //         {
        //             images_name += "<option value="+Beefs+">"+Beefs+"</option>";
        //         }
        //     }
        //     images_name +='</select>';
        // }
        // var Lambs;
        // if(food_name == 'Lamb')
        // {
        //     images_name +="<select class='form-control image_name' name='food_image"+id+"' paring='"+food_name+"' image-food-id="+id+"  ><option value=''>Select...</option>";

        //     for (Lambs of Lamb) 
        //     {
        //         if(food_image == Lambs)
        //         {
        //             images_name += "<option selected value="+Lambs+">"+Lambs+"</option>";
        //         }
        //         else
        //         {
        //             images_name += "<option value="+Lambs+">"+Lambs+"</option>";
        //         }
        //     }
        //     images_name +='</select>';
        // }
        //  var Veals;
        // if(food_name == 'Veal')
        // {
        //     images_name +="<select class='form-control image_name' name='food_image"+id+"' paring='"+food_name+"' image-food-id="+id+"  ><option value=''>Select...</option>";

        //     for (Veals of Veal) 
        //     {
        //         if(food_image == Veals)
        //         {
        //             images_name += "<option selected value="+Veals+">"+Veals+"</option>";
        //         }
        //         else
        //         {
        //             images_name += "<option value="+Veals+">"+Veals+"</option>";
        //         }
        //     }
        //     images_name +='</select>';
        // }
        //  var Porks;
        // if(food_name == 'Pork')
        // {
        //     images_name +="<select class='form-control image_name' name='food_image"+id+"' paring='"+food_name+"' image-food-id="+id+"  ><option value=''>Select...</option>";

        //     for (Porks of Pork) 
        //     {
        //         if(food_image == Porks)
        //         {
        //             images_name += "<option selected value="+Porks+">"+Porks+"</option>";
        //         }
        //         else
        //         {
        //             images_name += "<option value="+Porks+">"+Porks+"</option>";
        //         }
        //     }
        //     images_name +='</select>';
        // }
        //   var Games;
        // if(food_name == 'Game')
        // {
        //     images_name +="<select class='form-control image_name' name='food_image"+id+"' paring='"+food_name+"' image-food-id="+id+"  ><option value=''>Select...</option>";

        //     for (Games of Game) 
        //     {
        //         if(food_image == Games)
        //         {
        //             images_name += "<option selected value="+Games+">"+Games+"</option>";
        //         }
        //         else
        //         {
        //             images_name += "<option value="+Games+">"+Games+"</option>";
        //         }
        //     }
        //     images_name +='</select>';
        // }
        //   var Poultrys;
        // if(food_name == 'Poultry')
        // {
        //     images_name +="<select class='form-control image_name' name='food_image"+id+"' paring='"+food_name+"' image-food-id="+id+"  ><option value=''>Select...</option>";

        //     for (Poultrys of Poultry) 
        //     {
        //         if(food_image == Poultrys)
        //         {
        //             images_name += "<option selected value="+Poultrys+">"+Poultrys+"</option>";
        //         }
        //         else
        //         {
        //             images_name += "<option value="+Poultrys+">"+Poultrys+"</option>";
        //         }
        //     }
        //     images_name +='</select>';
        // }
        //   var Mushroomss;
        // if(food_name == 'Mushrooms')
        // {
        //     images_name +="<select class='form-control image_name' name='food_image"+id+"' paring='"+food_name+"' image-food-id="+id+"  ><option value=''>Select...</option>";

        //     for (Mushroomss of Mushrooms) 
        //     {
        //         if(food_image == Mushroomss)
        //         {
        //             images_name += "<option selected value="+Mushroomss+">"+Mushroomss+"</option>";
        //         }
        //         else
        //         {
        //             images_name += "<option value="+Mushroomss+">"+Mushroomss+"</option>";
        //         }
        //     }
        //     images_name +='</select>';
        // }
        //   var Pastas;
        // if(food_name == 'Pasta')
        // {
        //     images_name +="<select class='form-control image_name' name='food_image"+id+"' paring='"+food_name+"' image-food-id="+id+"  ><option value=''>Select...</option>";

        //     for (Pastas of Pasta) 
        //     {
        //         if(food_image == Pastas)
        //         {
        //             images_name += "<option selected value="+Pastas+">"+Pastas+"</option>";
        //         }
        //         else
        //         {
        //             images_name += "<option value="+Pastas+">"+Pastas+"</option>";
        //         }
        //     }
        //     images_name +='</select>';
        // }
        //   var Noodles;
        // if(food_name == 'Noodle')
        // {
        //     images_name +="<select class='form-control image_name' name='food_image"+id+"' paring='"+food_name+"' image-food-id="+id+"  ><option value=''>Select...</option>";

        //     for (Noodles of Noodle) 
        //     {
        //         if(food_image == Noodles)
        //         {
        //             images_name += "<option selected value="+Noodles+">"+Noodles+"</option>";
        //         }
        //         else
        //         {
        //             images_name += "<option value="+Noodles+">"+Noodles+"</option>";
        //         }
        //     }
        //     images_name +='</select>';
        // }
        //   var fishs;
        // if(food_name == 'fish')
        // {
        //     images_name +="<select class='form-control image_name' name='food_image"+id+"' paring='"+food_name+"' image-food-id="+id+"  ><option value=''>Select...</option>";

        //     for (fishs of fish) 
        //     {
        //         if(food_image == fishs)
        //         {
        //             images_name += "<option selected value="+fishs+">"+fishs+"</option>";
        //         }
        //         else
        //         {
        //             images_name += "<option value="+fishs+">"+fishs+"</option>";
        //         }
        //     }
        //     images_name +='</select>';
        // }
        //    var Shellfishs;
        // if(food_name == 'Shellfish')
        // {
        //     images_name +="<select class='form-control image_name' name='food_image"+id+"' paring='"+food_name+"' image-food-id="+id+"  ><option value=''>Select...</option>";

        //     for (Shellfishs of Shellfish) 
        //     {
        //         if(food_image == Shellfishs)
        //         {
        //             images_name += "<option selected value="+Shellfishs+">"+Shellfishs+"</option>";
        //         }
        //         else
        //         {
        //             images_name += "<option value="+Shellfishs+">"+Shellfishs+"</option>";
        //         }
        //     }
        //     images_name +='</select>';
        // }
        //      var Seafoods;
        // if(food_name == 'Seafood')
        // {
        //     images_name +="<select class='form-control image_name' name='food_image"+id+"' paring='"+food_name+"' image-food-id="+id+"  ><option value=''>Select...</option>";

        //     for (Seafoods of Seafood) 
        //     {
        //         if(food_image == Seafoods)
        //         {
        //             images_name += "<option selected value="+Seafoods+">"+Seafoods+"</option>";
        //         }
        //         else
        //         {
        //             images_name += "<option value="+Seafoods+">"+Seafoods+"</option>";
        //         }
        //     }
        //     images_name +='</select>';
        // }
        //       var Crabs;
        // if(food_name == 'Crab')
        // {
        //     images_name +="<select class='form-control image_name' name='food_image"+id+"' paring='"+food_name+"' image-food-id="+id+"  ><option value=''>Select...</option>";

        //     for (Crabs of Crab) 
        //     {
        //         if(food_image == Crabs)
        //         {
        //             images_name += "<option selected value="+Crabs+">"+Crabs+"</option>";
        //         }
        //         else
        //         {
        //             images_name += "<option value="+Crabs+">"+Crabs+"</option>";
        //         }
        //     }
        //     images_name +='</select>';
        // }
        //        var Vegetables;
        // if(food_name == 'Vegetable')
        // {
        //     images_name +="<select class='form-control image_name' name='food_image"+id+"' paring='"+food_name+"' image-food-id="+id+"  ><option value=''>Select...</option>";

        //     for (Vegetables of Vegetable) 
        //     {
        //         if(food_image == Vegetables)
        //         {
        //             images_name += "<option selected value="+Vegetables+">"+Vegetables+"</option>";
        //         }
        //         else
        //         {
        //             images_name += "<option value="+Vegetables+">"+Vegetables+"</option>";
        //         }
        //     }
        //     images_name +='</select>';
        // }
         
        //         var Olivess;
        // if(food_name == 'Olives')
        // {
        //     images_name +="<select class='form-control image_name' name='food_image"+id+"' paring='"+food_name+"' image-food-id="+id+"  ><option value=''>Select...</option>";

        //     for (Olivess of Olives) 
        //     {
        //         if(food_image == Olivess)
        //         {
        //             images_name += "<option selected value="+Olivess+">"+Olivess+"</option>";
        //         }
        //         else
        //         {
        //             images_name += "<option value="+Olivess+">"+Olivess+"</option>";
        //         }
        //     }
        //     images_name +='</select>';
        // }
        //          var Desserts;
        // if(food_name == 'Dessert')
        // {
        //     images_name +="<select class='form-control image_name' name='food_image"+id+"' paring='"+food_name+"' image-food-id="+id+"  ><option value=''>Select...</option>";

        //     for (Desserts of Dessert) 
        //     {
        //         if(food_image == Desserts)
        //         {
        //             images_name += "<option selected value="+Desserts+">"+Desserts+"</option>";
        //         }
        //         else
        //         {
        //             images_name += "<option value="+Desserts+">"+Desserts+"</option>";
        //         }
        //     }
        //     images_name +='</select>';
        // }
        //           var Savourys;
        // if(food_name == 'Savoury')
        // {
        //     images_name +="<select class='form-control image_name' name='food_image"+id+"' paring='"+food_name+"' image-food-id="+id+"  ><option value=''>Select...</option>";

        //     for (Savourys of Savoury) 
        //     {
        //         if(food_image == Savourys)
        //         {
        //             images_name += "<option selected value="+Savourys+">"+Savourys+"</option>";
        //         }
        //         else
        //         {
        //             images_name += "<option value="+Savourys+">"+Savourys+"</option>";
        //         }
        //     }
        //     images_name +='</select>';
        // }
               
        $('.food_image'+id+'_name').html(images_name);
    }
    $(document).on('change','.image_name',function()
    {
        var food_id = $(this).attr('image-food-id');
        var selected_paring = $(this).attr('paring');
        var image_name = $(this).val();
        show_image_funct(food_id,selected_paring,image_name);      
    });
    show_image_funct(food_id=1,selected_paring="<?php echo $row['food_name1'] ?>",image_name="<?php echo $row['food_image1'] ?>");
    show_image_funct(food_id=2,selected_paring="<?php echo $row['food_name2'] ?>",image_name="<?php echo $row['food_image2'] ?>");
    show_image_funct(food_id=3,selected_paring="<?php echo $row['food_name3'] ?>",image_name="<?php echo $row['food_image3'] ?>");
    show_image_funct(food_id=4,selected_paring="<?php echo $row['food_name4'] ?>",image_name="<?php echo $row['food_image4'] ?>");
    function show_image_funct(food_id,selected_paring,image_name)
    {
        if(image_name)
        {
            var images = '<span style="float:left;border:4px solid #303641;padding:5px;margin:5px;"><img style="height: 86px;width: 135px;" src="'+base_url+'uploads/food_paring/'+selected_paring+'/'+image_name+'"></span>';
            $('.food_image'+food_id+'_preview').html(images);
        }    
    }
</script>
<style>
    .btm_border{
        border-bottom: 1px solid #ebebeb;
        padding-bottom: 15px;   
    }
</style>

