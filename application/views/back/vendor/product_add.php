<div class="row">
    <div class="col-md-12">
        <?php
        echo form_open(base_url() . 'vendor/product/do_add/', array(
            'class' => 'form-horizontal',
            'method' => 'post',
            'id' => 'product_add',
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
                    <!-- <div  id="product_details" class="tab-pane fade active in"> -->
                    <div class="form-group btm_border">
                        <h4 class="text-thin text-center"><?php echo translate('product_details'); ?></h4>
                    </div>
                    <div class="form-group btm_border">
                        <label class="col-sm-4 control-label" for="demo-hor-12">Product <?php echo translate('images'); ?></label>
                        <div class="col-sm-6">
                            <span class="pull-left btn btn-default btn-file"> <?php echo translate('choose_file'); ?>
                                <input type="file" multiple name="images[]" onchange="preview(this);" id="demo-hor-12" class="form-control image_limit required"> 
                            </span>
                            &nbsp;<label class="col-sm-6 control-label" style="color: gray;" >*PNG format(Transparent background) only.</label>
                            <br><br>
                            <span id="previewImg"></span>
                        </div>
                    </div>
                    <div class="form-group btm_border">
                        <label class="col-sm-4 control-label" for="demo-hor-2"><?php echo translate('category'); ?></label>
                        <div class="col-sm-6">
                            <?php echo $this->crud_model->select_html_order('category', 'category', 'category_name', 'add', 'demo-chosen-select required', '', 'digital', NULL, 'get_cat', 'single', '', 'ASC'); ?>
                        </div>
                    </div>
                    <div class="form-group btm_border">
                        <label class="col-sm-4 control-label" for="demo-hor-3"><?php echo translate('sub-category'); ?></label>
                        <div class="col-sm-6" id="sub_cat">
                            <?php echo $this->crud_model->select_html_sub_order('sub_category', 'sub_category', 'sub_category_name', 'add', 'demo-chosen-select ', '', 'digital', NULL, 'get_cat', 'single', '', 'ASC'); ?>
                        </div>
                    </div>
                    <div class="form-group btm_border">
                        <label class="col-sm-4 control-label" for="demo-hor-4"><?php echo translate('brand'); ?></label>
                        <div class="col-sm-6">
                            <select class="demo-chosen-select form-control required" name="brand">
                                <option value="">Select...</option>
                                <?php
                                $brands = $this->db->get_where('vendorbrands', array('user_id' => $this->session->userdata('vendor_id')))->result_array();
                                foreach ($brands as $key => $value) {
                                ?>
                                    <option value="<?php echo $value['id']; ?>"><?php echo $value['name']; ?></option>
                                <?php
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group btm_border">
                        <label class="col-sm-4 control-label" for="demo-hor-84"><?php echo translate('variety'); ?></label>
                        <div class="col-sm-6">
                            <input type="text" name="variety" id="demo-hor-84" placeholder="<?php echo translate('variety'); ?>" class="form-control required">
                        </div>
                    </div>
                    <div class="form-group btm_border">
                        <label class="col-sm-3 control-label" for="demo-hor-1"><?php echo "Product Name"; ?></label>
                        <div class="col-sm-3">
                            <input type="text" name="title" id="demo-hor-1" placeholder="<?php echo "Product Name"; ?>" class="form-control required"><span style="color: grey"> English</span>
                        </div>
                        <div class="col-sm-3">
                            <input type="text" name="title_ch" id="demo-hor-1" placeholder="<?php echo "Product Name"; ?>" class="form-control"><span style="color: grey"> Chinese</span>
                        </div>
                        <div class="col-sm-3">
                            <input type="text" name="title_jp" id="demo-hor-1" placeholder="<?php echo "Product Name"; ?>" class="form-control"><span style="color: grey"> Japanese</span>
                        </div>
                    </div>
                    <div class="form-group btm_border">
                        <label class="col-sm-4 control-label" for="demo-hor-83"><?php echo translate('product_year'); ?></label>
                        <div class="col-sm-6">
                            <input type="number" name="product_year" id="demo-hor-83" min="0" placeholder="<?php echo translate('_e.g._2016,_2017,_etc.'); ?>" class="form-control">
                        </div>
                    </div>
                    <div class="form-group btm_border">
                        <label class="col-sm-4 control-label" for="demo-hor-83"><?php echo translate('regions'); ?></label>
                        <div class="col-sm-6">
                            <input type="text" name="regions" id="demo-hor-83" min="0" placeholder="<?php echo translate('_e.g._Barrosa valley,_Hunter valley,_etc.'); ?>" class="form-control">
                        </div>
                    </div>
                    <div class="form-group btm_border">
                        <label class="col-sm-4 control-label" for="demo-hor-5">Volume (ml) </label>
                        <div class="col-sm-6">
                            <input type="text" name="unit" id="demo-hor-5" placeholder="<?php echo translate('Volume (ml)'); ?>" class="form-control ">
                        </div>
                    </div>
                    <div class="form-group btm_border">
                        <label class="col-sm-4 control-label" for="demo-hor-82"><?php echo translate('product_abv') . ' (%)'; ?></label>
                        <div class="col-sm-6">
                            <input type="number" name="product_abv" oninput="if(this.value.length==2) return false;" id="demo-hor-82" min="1" max="30" placeholder="<?php echo translate('_e.g._23%'); ?>" class="form-control">
                        </div>
                        <span id="product_abv_error"></span>
                    </div>
                    <div class="form-group btm_border">
                        <label class="col-sm-4 control-label" for="demo-hor-11"><?php echo translate('tags'); ?></label>
                        <div class="col-sm-6">
                            <input type="text" name="tag" data-role="tagsinput" placeholder="<?php echo "Awards, Certification, etc"; ?>" class="form-control">
                        </div>
                    </div>
                    <div class="form-group btm_border">
                        <label class="col-sm-4 control-label" for="demo-hor-81"><?php echo translate('limited_release'); ?></label>
                        <div class="col-sm-6">
                            <select class="form-control" name="limited_release">
                                <option value="">Select..</option>
                                <option value="Yes"><?php echo translate('yes'); ?></option>
                                <option value="No"><?php echo translate('no'); ?></option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="form-group btm_border">
                    <label class="col-sm-4 control-label" for="demo-hor-84"><?php echo translate('is_low_stock'); ?></label>
                    <div class="col-sm-6">
                        <input type="checkbox" name="is_low_stock" id="demo-hor-84" <?php if ($row['is_low_stock'] == 'yes') {
                                                                                        echo 'checked';
                                                                                    } ?> value="yes" placeholder="<?php echo translate('is_low_stock'); ?>"> Low Stock
                    </div>
                </div>
                <div class="form-group btm_border">
                    <label class="col-sm-4 control-label" for="demo-hor-13">Product Description English</label>
                    <div class="col-sm-6">
                        <textarea rows="5" maxlength="900" class="form-control required" name="description_en" placeholder="Max 900 characters"></textarea>
                    </div>
                </div>
                <div class="form-group btm_border">
                    <label class="col-sm-4 control-label" for="demo-hor-13">Product Description Chinese</label>
                    <div class="col-sm-6">
                        <textarea rows="5" placeholder="Max 900 characters" maxlength="900" class="form-control" name="description_ch"></textarea>
                    </div>
                </div>
                <div class="form-group btm_border">
                    <label class="col-sm-4 control-label" for="demo-hor-13">Product Description Japanese</label>
                    <div class="col-sm-6">
                        <textarea rows="5" placeholder="Max 900 characters" maxlength="900" class="form-control" name="description_jp"></textarea>
                    </div>
                </div>
                <div class="form-group btm_border">
                    <label class="col-sm-4 control-label" for="demo-hor-5"><?php echo translate('wholesale (INCL GST + WET)'); ?></label>
                    <div class="col-sm-6">
                        <span style="position: absolute;top: 7px;left: 28px;color: grey;font-weight: bold;"> $ </span>
                        <input type="number" min="1" name="wholesale" class="form-control required" style=" padding-left: 26px;padding-top: 3px;">
                    </div>
                </div>
                <div class="form-group btm_border">
                    <label class="col-sm-4 control-label" for="demo-hor-5">Wholesale (EXCL WET & GST)</label>
                    <div class="col-sm-6">
                        <span style="position: absolute;top: 7px;left: 28px;color: grey;font-weight: bold;"> $ </span>
                        <input type="number" min="1" name="wholesale_EXCL_WET_GST" class="form-control required" style=" padding-left: 26px;padding-top: 3px;">
                    </div>
                </div>
                <div class="form-group btm_border">
                    <label class="col-sm-1 control-label" for="demo-hor-5"> <?php echo translate('bundle_sale_price'); ?> (AUD)</label>
                    <div class="col-sm-2 ">
                        <span style="position: absolute;top: 7px;left: 28px;color: grey;font-weight: bold;"> $ </span>
                        <input type="number" min="1" name="sale_price_AU" class="form-control required" placeholder="If applicable" style=" padding-left: 26px;padding-top: 3px;">
                    </div>
                    <label class="col-sm-1 control-label" for="demo-hor-5"> <?php echo translate('bundle_sale_price'); ?> (HKD)</label>
                    <div class="col-sm-2 ">
                        <span style="position: absolute;top: 7px;left: 28px;color: grey;font-weight: bold;"> $ </span>
                        <input type="number" min="1" name="sale_price_HK" class="form-control" placeholder="If applicable" style=" padding-left: 26px;padding-top: 3px;">
                    </div>
                    <label class="col-sm-1 control-label" for="demo-hor-5"> <?php echo translate('bundle_sale_price'); ?> (JP Yen)</label>
                    <div class="col-sm-2 ">
                        <span style="position: absolute;top: 7px;left: 28px;color: grey;font-weight: bold;"> $ </span>
                        <input type="number" min="1" name="sale_price_JP" class="form-control" placeholder="If applicable" style=" padding-left: 26px;padding-top: 3px;">
                    </div>
                    <label class="col-sm-1 control-label" for="demo-hor-5"> <?php echo translate('bundle_sale_price'); ?> (SGD)</label>
                    <div class="col-sm-2 ">
                        <span style="position: absolute;top: 7px;left: 28px;color: grey;font-weight: bold;"> $ </span>
                        <input type="number" min="1" name="sale_price_SG" class="form-control" placeholder="If applicable" style=" padding-left: 26px;padding-top: 3px;">
                    </div>
                </div>
                <div class="form-group btm_border" style="display: none;">
                    <label class="col-sm-4 control-label" for="demo-hor-5"><?php echo translate('bundle_discount'); ?> (%)</label>
                    <div class="col-sm-6">
                        <input type="number" min="1" value="0" name="discount" class="form-control">
                    </div>
                </div>
                <div class="form-group btm_border">
                    <label class="col-sm-4 control-label">
                        <b class="pull-left"><?php echo "Taste Meter"; ?></b>
                    </label>
                    <div class="col-sm-6">
                        <input name="test_section" type="hidden" value="yes">
                    </div>
                </div>
                <!-- test Percentage -->
                <div class="form-group btm_border test_hide_show_field">
                    <div class="col-sm-3">
                        <input type="text" name="test_title_en" id="demo-hor-55" placeholder="<?php echo translate('Taste Meter Rate English'); ?>" min="1" max="100" class="form-control">
                    </div>
                    <div class="col-sm-3">
                        <input type="text" name="test_title_ch" id="demo-hor-65" placeholder="<?php echo translate('Taste Meter Rate Chinese'); ?>" min="1" max="100" class="form-control">
                    </div>
                    <div class="col-sm-3">
                        <input type="text" name="test_title_jp" id="demo-hor-75" placeholder="<?php echo translate('Taste Meter Rate Japanese'); ?>" min="1" max="100" class="form-control">
                    </div>
                </div>
                <div class="form-group btm_border test_hide_show_field">
                    <div class="col-sm-3">
                        <select name="test1_name" id="demo-hor-65" class="form-control">
                            <option value=""><?php echo translate('taste'); ?></option>
                            <option value="Wine">Wine</option>
                            <option value="Dry">Dry</option>
                            <option value="Sweet">Sweet</option>
                            <option value="Fruity">Fruity</option>
                            <option value="Citrus">Citrus</option>
                            <option value="Floral">Floral</option>
                            <option value="Oak">Oak</option>
                            <option value="Creamy">Creamy</option>
                            <option value="Rich">Rich</option>
                            <option value="Body">Body</option>
                            <option value="Sparkling">Sparkling</option>
                            <option value="Dry white">Dry White</option>
                            <option value="Sweet white">Sweet White</option>
                            <option value="Rich White">Rich White</option>
                            <option value="Light Red">Light Red</option>
                            <option value="Medium Red">Medium Red</option>
                            <option value="Bold Red">Bold Red</option>
                        </select>
                    </div>
                    <div class="col-sm-3">
                        <select class="form-control" name="test1_number">
                            <option value=""><?php echo translate('meter_level'); ?></option>
                            <option value="0">0</option>
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="5">5</option>
                            <option value="6">6</option>
                            <option value="7">7</option>
                            <option value="8">8</option>
                            <option value="9">9</option>
                        </select>
                    </div>
                    <div class="col-sm-3">
                        <select name="test11_name" id="demo-hor-67" class="form-control">
                            <option value=""><?php echo translate('taste'); ?></option>
                            <option value="Wine">Wine</option>
                            <option value="Dry">Dry</option>
                            <option value="Sweet">Sweet</option>
                            <option value="Fruity">Fruity</option>
                            <option value="Citrus">Citrus</option>
                            <option value="Floral">Floral</option>
                            <option value="Oak">Oak</option>
                            <option value="Creamy">Creamy</option>
                            <option value="Rich">Rich</option>
                            <option value="Body">Body</option>
                            <option value="Sparkling">Sparkling</option>
                            <option value="Dry white">Dry White</option>
                            <option value="Sweet white">Sweet White</option>
                            <option value="Rich White">Rich White</option>
                            <option value="Light Red">Light Red</option>
                            <option value="Medium Red">Medium Red</option>
                            <option value="Bold Red">Bold Red</option>
                        </select>
                    </div>
                    <div class="col-sm-3">
                        <select class="form-control" name="test11_number">
                            <option value=""><?php echo translate('meter_level'); ?></option>
                            <option value="0">0</option>
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="5">5</option>
                            <option value="6">6</option>
                            <option value="7">7</option>
                            <option value="8">8</option>
                            <option value="9">9</option>
                        </select>
                    </div>
                </div>
                <div class="form-group btm_border test_hide_show_field">
                    <div class="col-sm-3">
                        <select name="test2_name" id="demo-hor-69" class="form-control">
                            <option value=""><?php echo translate('taste'); ?></option>
                            <option value="Wine">Wine</option>
                            <option value="Dry">Dry</option>
                            <option value="Sweet">Sweet</option>
                            <option value="Fruity">Fruity</option>
                            <option value="Citrus">Citrus</option>
                            <option value="Floral">Floral</option>
                            <option value="Oak">Oak</option>
                            <option value="Creamy">Creamy</option>
                            <option value="Rich">Rich</option>
                            <option value="Body">Body</option>
                            <option value="Sparkling">Sparkling</option>
                            <option value="Dry white">Dry White</option>
                            <option value="Sweet white">Sweet White</option>
                            <option value="Rich White">Rich White</option>
                            <option value="Light Red">Light Red</option>
                            <option value="Medium Red">Medium Red</option>
                            <option value="Bold Red">Bold Red</option>
                        </select>
                    </div>
                    <div class="col-sm-3">
                        <select class="form-control" name="test2_number">
                            <option value=""><?php echo translate('meter_level'); ?></option>
                            <option value="0">0</option>
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="5">5</option>
                            <option value="6">6</option>
                            <option value="7">7</option>
                            <option value="8">8</option>
                            <option value="9">9</option>
                        </select>
                    </div>
                    <div class="col-sm-3">
                        <select name="test22_name" id="demo-hor-71" class="form-control">
                            <option value=""><?php echo translate('taste'); ?></option>
                            <option value="Wine">Wine</option>
                            <option value="Dry">Dry</option>
                            <option value="Sweet">Sweet</option>
                            <option value="Fruity">Fruity</option>
                            <option value="Citrus">Citrus</option>
                            <option value="Floral">Floral</option>
                            <option value="Oak">Oak</option>
                            <option value="Creamy">Creamy</option>
                            <option value="Rich">Rich</option>
                            <option value="Body">Body</option>
                            <option value="Sparkling">Sparkling</option>
                            <option value="Dry white">Dry White</option>
                            <option value="Sweet white">Sweet White</option>
                            <option value="Rich White">Rich White</option>
                            <option value="Light Red">Light Red</option>
                            <option value="Medium Red">Medium Red</option>
                            <option value="Bold Red">Bold Red</option>
                        </select>
                    </div>
                    <div class="col-sm-3">
                        <select class="form-control" name="test22_number">
                            <option value=""><?php echo translate('meter_level'); ?></option>
                            <option value="0">0</option>
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="5">5</option>
                            <option value="6">6</option>
                            <option value="7">7</option>
                            <option value="8">8</option>
                            <option value="9">9</option>
                        </select>
                    </div>
                </div>
                <div class="form-group btm_border test_hide_show_field">
                    <div class="col-sm-3">
                        <select name="test3_name" id="demo-hor-73" class="form-control">
                            <option value=""><?php echo translate('taste'); ?></option>
                            <option value="Wine">Wine</option>
                            <option value="Dry">Dry</option>
                            <option value="Sweet">Sweet</option>
                            <option value="Fruity">Fruity</option>
                            <option value="Citrus">Citrus</option>
                            <option value="Floral">Floral</option>
                            <option value="Oak">Oak</option>
                            <option value="Creamy">Creamy</option>
                            <option value="Rich">Rich</option>
                            <option value="Body">Body</option>
                            <option value="Sparkling">Sparkling</option>
                            <option value="Dry white">Dry White</option>
                            <option value="Sweet white">Sweet White</option>
                            <option value="Rich White">Rich White</option>
                            <option value="Light Red">Light Red</option>
                            <option value="Medium Red">Medium Red</option>
                            <option value="Bold Red">Bold Red</option>
                        </select>
                    </div>
                    <div class="col-sm-3">
                        <select class="form-control" name="test3_number">
                            <option value=""><?php echo translate('meter_level'); ?></option>
                            <option value="0">0</option>
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="5">5</option>
                            <option value="6">6</option>
                            <option value="7">7</option>
                            <option value="8">8</option>
                            <option value="9">9</option>
                        </select>
                    </div>
                    <div class="col-sm-3">
                        <select name="test33_name" id="demo-hor-75" class="form-control">
                            <option value=""><?php echo translate('taste'); ?></option>
                            <option value="Wine">Wine</option>
                            <option value="Dry">Dry</option>
                            <option value="Sweet">Sweet</option>
                            <option value="Fruity">Fruity</option>
                            <option value="Citrus">Citrus</option>
                            <option value="Floral">Floral</option>
                            <option value="Oak">Oak</option>
                            <option value="Creamy">Creamy</option>
                            <option value="Rich">Rich</option>
                            <option value="Body">Body</option>
                            <option value="Sparkling">Sparkling</option>
                            <option value="Dry white">Dry White</option>
                            <option value="Sweet white">Sweet White</option>
                            <option value="Rich White">Rich White</option>
                            <option value="Light Red">Light Red</option>
                            <option value="Medium Red">Medium Red</option>
                            <option value="Bold Red">Bold Red</option>
                        </select>
                    </div>
                    <div class="col-sm-3">
                        <select class="form-control" name="test33_number">
                            <option value=""><?php echo translate('meter_level'); ?></option>
                            <option value="0">0</option>
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="5">5</option>
                            <option value="6">6</option>
                            <option value="7">7</option>
                            <option value="8">8</option>
                            <option value="9">9</option>
                        </select>
                    </div>
                </div>
                <div class="form-group btm_border test_hide_show_field">
                    <!--<div class="col-sm-3">
                        <select name="test4_name" id="demo-hor-73"   class="form-control">
                            <option value=""><?php echo translate('taste'); ?></option>
                            <option value="Wine">Wine</option>
                            <option value="Dry">Dry</option>
                            <option value="Sweet">Sweet</option>
                            <option value="Fruity">Fruity</option>
                            <option value="Citrus">Citrus</option>
                            <option value="Floral">Floral</option>
                            <option value="Oak">Oak</option>
                            <option value="Creamy">Creamy</option>
                            <option value="Rich">Rich</option>
                            <option value="Body">Body</option>
                            <option value="Sparkling">Sparkling</option>
                            <option value="Dry white">Dry White</option>
                            <option value="Sweet white">Sweet White</option>
                            <option value="Rich White">Rich White</option>
                            <option value="Light Red">Light Red</option>
                            <option value="Medium Red">Medium Red</option>
                            <option value="Bold Red">Bold Red</option>
                        </select>
                    </div>
                     <div class="col-sm-3">
                        <select class="form-control" name="test4_number">
                            <option value=""><?php echo translate('meter_level'); ?></option>
                            <option value="0">0</option>
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="5">5</option>
                            <option value="6">6</option>
                            <option value="7">7</option>
                            <option value="8">8</option>
                            <option value="9">9</option>
                        </select>
                    </div>
                    <div class="col-sm-3">
                        <select name="test44_name" id="demo-hor-73"   class="form-control">
                            <option value=""><?php echo translate('taste'); ?></option>
                            <option value="Wine">Wine</option>
                            <option value="Dry">Dry</option>
                            <option value="Sweet">Sweet</option>
                            <option value="Fruity">Fruity</option>
                            <option value="Citrus">Citrus</option>
                            <option value="Floral">Floral</option>
                            <option value="Oak">Oak</option>
                            <option value="Creamy">Creamy</option>
                            <option value="Rich">Rich</option>
                            <option value="Body">Body</option>
                            <option value="Sparkling">Sparkling</option>
                            <option value="Dry white">Dry White</option>
                            <option value="Sweet white">Sweet White</option>
                            <option value="Rich White">Rich White</option>
                            <option value="Light Red">Light Red</option>
                            <option value="Medium Red">Medium Red</option>
                            <option value="Bold Red">Bold Red</option>
                        </select>
                    </div>
                    <div class="col-sm-3">
                        <select class="form-control" name="test44_number">
                            <option value=""><?php echo translate('meter_level'); ?></option>
                            <option value="0">0</option>
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="5">5</option>
                            <option value="6">6</option>
                            <option value="7">7</option>
                            <option value="8">8</option>
                            <option value="9">9</option>
                        </select>
                    </div>
                </div>
                <div class="form-group btm_border test_hide_show_field">
                    <div class="col-sm-3">
                        <select name="test5_name" id="demo-hor-73"   class="form-control">
                            <option value=""><?php echo translate('taste'); ?></option>
                            <option value="Wine">Wine</option>
                            <option value="Dry">Dry</option>
                            <option value="Sweet">Sweet</option>
                            <option value="Fruity">Fruity</option>
                            <option value="Citrus">Citrus</option>
                            <option value="Floral">Floral</option>
                            <option value="Oak">Oak</option>
                            <option value="Creamy">Creamy</option>
                            <option value="Rich">Rich</option>
                            <option value="Body">Body</option>
                            <option value="Sparkling">Sparkling</option>
                            <option value="Dry white">Dry White</option>
                            <option value="Sweet white">Sweet White</option>
                            <option value="Rich White">Rich White</option>
                            <option value="Light Red">Light Red</option>
                            <option value="Medium Red">Medium Red</option>
                            <option value="Bold Red">Bold Red</option>
                        </select>
                    </div>
                    <div class="col-sm-3">
                        <select class="form-control" name="test5_number">
                            <option value=""><?php echo translate('meter_level'); ?></option>
                            <option value="0">0</option>
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="5">5</option>
                            <option value="6">6</option>
                            <option value="7">7</option>
                            <option value="8">8</option>
                            <option value="9">9</option>
                        </select>
                    </div>
                    <div class="col-sm-3">
                        <select name="test55_name" id="demo-hor-73"   class="form-control">
                            <option value=""><?php echo translate('taste'); ?></option>
                            <option value="Wine">Wine</option>
                            <option value="Dry">Dry</option>
                            <option value="Sweet">Sweet</option>
                            <option value="Fruity">Fruity</option>
                            <option value="Citrus">Citrus</option>
                            <option value="Floral">Floral</option>
                            <option value="Oak">Oak</option>
                            <option value="Creamy">Creamy</option>
                            <option value="Rich">Rich</option>
                            <option value="Body">Body</option>
                            <option value="Sparkling">Sparkling</option>
                            <option value="Dry white">Dry White</option>
                            <option value="Sweet white">Sweet White</option>
                            <option value="Rich White">Rich White</option>
                            <option value="Light Red">Light Red</option>
                            <option value="Medium Red">Medium Red</option>
                            <option value="Bold Red">Bold Red</option>
                        </select>
                    </div>
                    <div class="col-sm-3">
                        <select class="form-control" name="test55_number">
                            <option value=""><?php echo translate('meter_level'); ?></option>
                            <option value="0">0</option>
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="5">5</option>
                            <option value="6">6</option>
                            <option value="7">7</option>
                            <option value="8">8</option>
                            <option value="9">9</option>
                        </select>
                    </div> -->
                </div>
                <div class="form-group  test_hide_show_field">
                    <div class="col-sm-3" style="display: none;">
                        <input type="text" name="test_sumary_title_en" id="demo-hor-56" placeholder="<?php echo translate('test_sumary_title English'); ?>" min="1" max="100" class="form-control">
                    </div>
                    <div class="col-sm-3" style="display: none;">
                        <input type="text" name="test_sumary_title_ch" id="demo-hor-56" placeholder="<?php echo translate('test_sumary_title Chinese'); ?>" min="1" max="100" class="form-control">
                    </div>
                    <div class="col-sm-3" style="display: none;">
                        <input type="text" name="test_sumary_title_jp" id="demo-hor-56" placeholder="<?php echo translate('test_sumary_title Japanese'); ?>" min="1" max="100" class="form-control">
                    </div>
                </div>
                <div class="form-group btm_border test_hide_show_field">
                    <div class="col-sm-3">
                        <textarea type="text" name="test_sumary_en" id="demo-hor-57" placeholder="<?php echo translate('test_sumary') . ' (English)'; ?>" min="1" maxlength="250" class="form-control"></textarea>
                    </div>
                    <div class="col-sm-3">
                        <textarea type="text" name="test_sumary_ch" id="demo-hor-57" placeholder="<?php echo translate('test_sumary') . ' (Chinese)'; ?>" min="1" maxlength="250" class="form-control"></textarea>
                    </div>
                    <div class="col-sm-3">
                        <textarea type="text" name="test_sumary_jp" id="demo-hor-57" placeholder="<?php echo translate('test_sumary') . ' (Japanese)'; ?>" min="1" maxlength="250" class="form-control"></textarea>
                    </div>
                </div>
                <!-- Test section over -->
                <!-- Food Section  -->
                <!-- Food Section  -->
                <div class="form-group btm_border">
                    <b class="pull-left"><?php echo "Food Pairing (Up to 4 Dishes)"; ?></b>
                    <div class="col-sm-6">
                        <input type="hidden" name="food_section" placeholder="<?php echo translate('food_section'); ?>" value="yes">
                    </div>
                </div>
                <div class="form-group btm_border hide_show_field">
                    <div class="col-sm-6">
                        <textarea name="food_description" maxlength="250" rows="3" placeholder="<?php echo translate('food_description'); ?>" class="form-control"></textarea>
                    </div>
                </div>
                <div class="form-group btm_border">
                    <div class="col-sm-3" style="display: none;">
                        <select name="food_preparation_1" class="form-control">
                            <option value=""><?php echo "Preparation 1" //translate('food_preparation_1');
                                                ?>...</option>
                            <option value="Spicy">Spicy</option>
                            <option value="Grilled">Grilled</option>
                            <option value="Fried">Fried</option>
                            <option value="Stir Fry">Stir Fry</option>
                            <option value="Deep Fried">Deep Fried</option>
                            <option value="Smoked">Smoked</option>
                            <option value="Baked">Baked</option>
                            <option value="Stew">Stew</option>
                            <option value="Steamed">Steamed</option>
                            <option value="Stuffed">Stuffed</option>
                            <option value="Boiled">Boiled</option>
                            <option value="Poach">Poach</option>
                            <option value="Soup">Soup</option>
                            <option value="Green">Green</option>
                            <option value="Pickled">Pickled</option>
                            <option value="Raw">Raw</option>
                            <option value="Aperitif">Aperitif</option>
                            <option value="Digestif">Digestif</option>
                            <option value="Roasted">Roasted</option>
                            <option value="BBQ">BBQ</option>
                            <option value="Braised">Braised</option>
                        </select>
                    </div>
                    <div class="col-sm-3" style="display: none;">
                        <select name="food_origin_1" class="form-control">
                            <option value=""><?php echo "Origin 1"; //translate('food_origin_1');
                                                ?>...</option>
                            <option value="Chinese">Chinese</option>
                            <option value="Indonesian">Indonesian</option>
                            <option value="Malaysian">Malaysian</option>
                            <option value="Singaporean">Singaporean</option>
                            <option value="Japanese">Japanese</option>
                            <option value="Korean">Korean</option>
                            <option value="Baked">Baked</option>
                            <option value="Vietnamese">Vietnamese</option>
                            <option value="Indian">Indian</option>
                            <option value="Thai">Thai</option>
                            <option value="Mexican">Mexican</option>
                            <option value="French">French</option>
                            <option value="Spanish">Spanish</option>
                            <option value="Italian">Italian</option>
                            <option value="Australian">Australian</option>
                        </select>
                    </div>
                    <div class="col-sm-3">
                        <select name="food_name1" class="form-control food_name" data-id="1">
                            <option value=""><?php echo "Pairing 1"; //translate('food_pairing_1');
                                                ?>...</option>
                            <option value="Lamb">Lamb</option>
                            <option value="Veal">Veal</option>
                            <option value="Pork">Pork</option>
                            <option value="Game">Game(deer,venison)</option>
                            <option value="Poultry">Poultry</option>
                            <option value="Mushrooms">Mushrooms</option>
                            <option value="Cured meat">Cured meat</option>
                            <option value="Mature and hard cheese">Mature and hard cheese</option>
                            <option value="Mild and soft cheese">Mild and soft cheese</option>
                            <option value="Pasta">Pasta</option>
                            <option value="Noodle">Noodle</option>
                            <option value="Lean fish">Lean fish</option>
                            <option value="Rich fish(salmon,tuna)">Rich fish(salmon,tuna)</option>
                            <option value="Shellfish">Shellfish</option>
                            <option value="Seafood">Seafood</option>
                            <option value="Crab">Crab</option>
                            <option value="Vegetable">Vegetable</option>
                            <option value="Olives">Olives</option>
                            <option value="Dessert">Dessert</option>
                            <option value="Savoury">Savoury</option>
                        </select>
                    </div>
                    <div class="row food_image1_name">
                    </div>
                    <div class="row food_image1_preview">
                    </div>
                </div>
                <div class="form-group btm_border">
                    <div class="col-sm-3" style="display: none;">
                        <select name="food_preparation_2" class="form-control">
                            <option value=""><?php echo "Preparation 2"; //translate('food_preparation_2');
                                                ?>...</option>
                            <option value="Spicy">Spicy</option>
                            <option value="Grilled">Grilled</option>
                            <option value="Fried">Fried</option>
                            <option value="Stir Fry">Stir Fry</option>
                            <option value="Deep Fried">Deep Fried</option>
                            <option value="Smoked">Smoked</option>
                            <option value="Baked">Baked</option>
                            <option value="Stew">Stew</option>
                            <option value="Steamed">Steamed</option>
                            <option value="Stuffed">Stuffed</option>
                            <option value="Boiled">Boiled</option>
                            <option value="Poach">Poach</option>
                            <option value="Soup">Soup</option>
                            <option value="Green">Green</option>
                            <option value="Pickled">Pickled</option>
                            <option value="Raw">Raw</option>
                            <option value="Aperitif">Aperitif</option>
                            <option value="Digestif">Digestif</option>
                            <option value="Roasted">Roasted</option>
                            <option value="BBQ">BBQ</option>
                            <option value="Braised">Braised</option>
                        </select>
                    </div>
                    <div class="col-sm-3" style="display: none;">
                        <select name="food_origin_2" class="form-control">
                            <option value=""><?php echo "Origin 2"; //translate('food_origin_2');
                                                ?>...</option>
                            <option value="Chinese">Chinese</option>
                            <option value="Indonesian">Indonesian</option>
                            <option value="Malaysian">Malaysian</option>
                            <option value="Singaporean">Singaporean</option>
                            <option value="Japanese">Japanese</option>
                            <option value="Korean">Korean</option>
                            <option value="Baked">Baked</option>
                            <option value="Vietnamese">Vietnamese</option>
                            <option value="Indian">Indian</option>
                            <option value="Thai">Thai</option>
                            <option value="Mexican">Mexican</option>
                            <option value="French">French</option>
                            <option value="Spanish">Spanish</option>
                            <option value="Italian">Italian</option>
                            <option value="Australian">Australian</option>
                        </select>
                    </div>
                    <div class="col-sm-3">
                        <select name="food_name2" class="form-control food_name" data-id="2">
                            <option value=""><?php echo "Pairing 2"; //translate('food_pairing_2');
                                                ?>...</option>
                            <option value="Appetizer">Appetizers</option>
                            <option value="Snacks">Snacks(peanuts,crackers)</option>
                            <option value="Beef">Beef</option>
                            <option value="Lamb">Lamb</option>
                            <option value="Veal">Veal</option>
                            <option value="Pork">Pork</option>
                            <option value="Game">Game(deer,venison)</option>
                            <option value="Poultry">Poultry</option>
                            <option value="Mushrooms">Mushrooms</option>
                            <option value="Cured meat">Cured meat</option>
                            <option value="Mature and hard cheese">Mature and hard cheese</option>
                            <option value="Mild and soft cheese">Mild and soft cheese</option>
                            <option value="Pasta">Pasta</option>
                            <option value="Noodle">Noodle</option>
                            <option value="Lean fish">Lean fish</option>
                            <option value="Rich fish(salmon,tuna)">Rich fish(salmon,tuna)</option>
                            <option value="Shellfish">Shellfish</option>
                            <option value="Seafood">Seafood</option>
                            <option value="Crab">Crab</option>
                            <option value="Vegetable">Vegetable</option>
                            <option value="Olives">Olives</option>
                            <option value="Dessert">Dessert</option>
                            <option value="Savoury">Savoury</option>
                        </select>
                    </div>
                    <div class="row food_image2_name">
                    </div>
                    <div class="row food_image2_preview">
                    </div>
                </div>
                <div class="form-group btm_border">
                    <div class="col-sm-3" style="display: none;">
                        <select name="food_preparation_3" class="form-control">
                            <option value=""><?php echo "Preparation 1"; //translate('food_preparation_1');
                                                ?>...</option>
                            <option value="Spicy">Spicy</option>
                            <option value="Grilled">Grilled</option>
                            <option value="Fried">Fried</option>
                            <option value="Stir Fry">Stir Fry</option>
                            <option value="Deep Fried">Deep Fried</option>
                            <option value="Smoked">Smoked</option>
                            <option value="Baked">Baked</option>
                            <option value="Stew">Stew</option>
                            <option value="Steamed">Steamed</option>
                            <option value="Stuffed">Stuffed</option>
                            <option value="Boiled">Boiled</option>
                            <option value="Poach">Poach</option>
                            <option value="Soup">Soup</option>
                            <option value="Green">Green</option>
                            <option value="Pickled">Pickled</option>
                            <option value="Raw">Raw</option>
                            <option value="Aperitif">Aperitif</option>
                            <option value="Digestif">Digestif</option>
                            <option value="Roasted">Roasted</option>
                            <option value="BBQ">BBQ</option>
                            <option value="Braised">Braised</option>
                        </select>
                    </div>
                    <div class="col-sm-3" style="display: none;">
                        <select name="food_origin_3" class="form-control">
                            <option value=""><?php echo "Origin 1"; //translate('food_origin_1');
                                                ?>...</option>
                            <option value="Chinese">Chinese</option>
                            <option value="Indonesian">Indonesian</option>
                            <option value="Malaysian">Malaysian</option>
                            <option value="Singaporean">Singaporean</option>
                            <option value="Japanese">Japanese</option>
                            <option value="Korean">Korean</option>
                            <option value="Baked">Baked</option>
                            <option value="Vietnamese">Vietnamese</option>
                            <option value="Indian">Indian</option>
                            <option value="Thai">Thai</option>
                            <option value="Mexican">Mexican</option>
                            <option value="French">French</option>
                            <option value="Spanish">Spanish</option>
                            <option value="Italian">Italian</option>
                            <option value="Australian">Australian</option>
                        </select>
                    </div>
                    <div class="col-sm-3">
                        <select name="food_name3" class="form-control food_name" data-id="3">
                            <option value=""><?php echo "Pairing 3"; //translate('food_pairing_3');
                                                ?>...</option>
                            <option value="Appetizer">Appetizers</option>
                            <option value="Snacks">Snacks(peanuts,crackers)</option>
                            <option value="Beef">Beef</option>
                            <option value="Lamb">Lamb</option>
                            <option value="Veal">Veal</option>
                            <option value="Pork">Pork</option>
                            <option value="Game">Game(deer,venison)</option>
                            <option value="Poultry">Poultry</option>
                            <option value="Mushrooms">Mushrooms</option>
                            <option value="Cured meat">Cured meat</option>
                            <option value="Mature and hard cheese">Mature and hard cheese</option>
                            <option value="Mild and soft cheese">Mild and soft cheese</option>
                            <option value="Pasta">Pasta</option>
                            <option value="Noodle">Noodle</option>
                            <option value="Lean fish">Lean fish</option>
                            <option value="Rich fish(salmon,tuna)">Rich fish(salmon,tuna)</option>
                            <option value="Shellfish">Shellfish</option>
                            <option value="Seafood">Seafood</option>
                            <option value="Crab">Crab</option>
                            <option value="Vegetable">Vegetable</option>
                            <option value="Olives">Olives</option>
                            <option value="Dessert">Dessert</option>
                            <option value="Savoury">Savoury</option>
                        </select>
                    </div>
                    <div class="row food_image3_name">
                    </div>
                    <div class="row food_image3_preview">
                    </div>
                </div>
                <div class="form-group btm_border">
                    <div class="col-sm-3" style="display: none;">
                        <select name="food_preparation_4" class="form-control">
                            <option value=""><?php echo "Preparation 4"; //translate('food_preparation_4');
                                                ?>...</option>
                            <option value="Spicy">Spicy</option>
                            <option value="Grilled">Grilled</option>
                            <option value="Fried">Fried</option>
                            <option value="Stir Fry">Stir Fry</option>
                            <option value="Deep Fried">Deep Fried</option>
                            <option value="Smoked">Smoked</option>
                            <option value="Baked">Baked</option>
                            <option value="Stew">Stew</option>
                            <option value="Steamed">Steamed</option>
                            <option value="Stuffed">Stuffed</option>
                            <option value="Boiled">Boiled</option>
                            <option value="Poach">Poach</option>
                            <option value="Soup">Soup</option>
                            <option value="Green">Green</option>
                            <option value="Pickled">Pickled</option>
                            <option value="Raw">Raw</option>
                            <option value="Aperitif">Aperitif</option>
                            <option value="Digestif">Digestif</option>
                            <option value="Roasted">Roasted</option>
                            <option value="BBQ">BBQ</option>
                            <option value="Braised">Braised</option>
                        </select>
                    </div>
                    <div class="col-sm-3" style="display: none;">
                        <select name="food_origin_4" class="form-control">
                            <option value=""><?php echo "Preparation 4"; //translate('food_origin_4');
                                                ?>...</option>
                            <option value="Chinese">Chinese</option>
                            <option value="Indonesian">Indonesian</option>
                            <option value="Malaysian">Malaysian</option>
                            <option value="Singaporean">Singaporean</option>
                            <option value="Japanese">Japanese</option>
                            <option value="Korean">Korean</option>
                            <option value="Baked">Baked</option>
                            <option value="Vietnamese">Vietnamese</option>
                            <option value="Indian">Indian</option>
                            <option value="Thai">Thai</option>
                            <option value="Mexican">Mexican</option>
                            <option value="French">French</option>
                            <option value="Spanish">Spanish</option>
                            <option value="Italian">Italian</option>
                            <option value="Australian">Australian</option>
                        </select>
                    </div>
                    <div class="col-sm-3">
                        <select name="food_name4" class="form-control food_name" data-id="4">
                            <option value=""><?php echo "Pairing 4"; //translate('food_pairing_4');
                                                ?>...</option>
                            <option value="Appetizer">Appetizers</option>
                            <option value="Snacks">Snacks(peanuts,crackers)</option>
                            <option value="Beef">Beef</option>
                            <option value="Lamb">Lamb</option>
                            <option value="Veal">Veal</option>
                            <option value="Pork">Pork</option>
                            <option value="Game">Game(deer,venison)</option>
                            <option value="Poultry">Poultry</option>
                            <option value="Mushrooms">Mushrooms</option>
                            <option value="Cured meat">Cured meat</option>
                            <option value="Mature and hard cheese">Mature and hard cheese</option>
                            <option value="Mild and soft cheese">Mild and soft cheese</option>
                            <option value="Pasta">Pasta</option>
                            <option value="Noodle">Noodle</option>
                            <option value="Lean fish">Lean fish</option>
                            <option value="Rich fish(salmon,tuna)">Rich fish(salmon,tuna)</option>
                            <option value="Shellfish">Shellfish</option>
                            <option value="Seafood">Seafood</option>
                            <option value="Crab">Crab</option>
                            <option value="Vegetable">Vegetable</option>
                            <option value="Olives">Olives</option>
                            <option value="Dessert">Dessert</option>
                            <option value="Savoury">Savoury</option>
                        </select>
                    </div>
                    <div class="row food_image4_name">
                    </div>
                    <div class="row food_image4_preview">
                    </div>
                </div>
            </div>
        </div>
        <div class="panel-footer">
            <div class="row">
                <div class="col-md-1">
                    <span class="btn btn-purple btn-labeled fa fa-refresh pro_list_btn" onclick="ajax_set_full('add','<?php echo translate('add_product'); ?>','<?php echo translate('successfully_added!'); ?>','product_add',''); "><?php echo translate('reset'); ?>
                    </span>
                </div>
                <div class="col-md-11">
                    <span class="btn btn-success btn-md btn-labeled fa fa-upload pull-right enterer" onclick="form_submit('product_add','<?php echo translate('product_has_been_uploaded!'); ?>');proceed('to_add');"><?php echo translate('upload'); ?></span>
                </div>
            </div>
        </div>
        </form>
    </div>
</div>
<script src="<?php $this->benchmark->mark_time();
                echo base_url(); ?>template/back/plugins/bootstrap-tagsinput/bootstrap-tagsinput.min.js"></script>
<input type="hidden" id="option_count" value="-1">
<style type="text/css">
    /*.hide_show_field
    {
    display: none;
    }
    .test_hide_show_field
    {
    display: none;
    }*/
</style>
<script>
    $("input[name = 'food_section']").click(function() {
        if ($("input[name = 'food_section']").is(':checked')) {
            $('.hide_show_field').show();
        } else {
            $('.hide_show_field').hide();
        }
    });
    $("input[name = 'test_section']").click(function() {
        if ($("input[name = 'test_section']").is(':checked')) {
            $('.test_hide_show_field').show();
        } else {
            $('.test_hide_show_field').hide();
        }
    });

    window.preview = function(input) {
        if (input.files && input.files[0]) {
            $("#previewImg").html('');
            $(input.files).each(function() {
                var reader = new FileReader();
                reader.readAsDataURL(this);
                reader.onload = function(e) {
                    $("#previewImg").append("<div style='float:left;border:4px solid #303641;padding:5px;margin:5px;'><img height='80' src='" + e.target.result + "'></div>");
                }
            });
        }
    }

    function other_forms() {}

    function set_summer() {
        $('.summernotes').each(function() {
            var now = $(this);
            var h = now.data('height');
            var n = now.data('name');
            if (now.closest('div').find('.val').length == 0) {
                now.closest('div').append('<input type="hidden" class="val" name="' + n + '">');
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

    function option_count(type) {
        var count = $('#option_count').val();
        if (type == 'add') {
            count++;
        }
        if (type == 'reduce') {
            count--;
        }
        $('#option_count').val(count);
    }

    function set_select() {
        $('.demo-chosen-select').chosen();
        $('.demo-cs-multiselect').chosen({
            width: '100%'
        });
    }

    $(document).ready(function() {
        set_select();
        set_summer();
        createColorpickers();
    });

    function other() {
        set_select();
        $('#sub').show('slow');
    }

    function get_cat(id, now) {
        $('#sub').hide('slow');
        ajax_load(base_url + 'vendor/product/sub_by_cat/' + id, 'sub_cat', 'other');
    }

    function get_brnd(id) {
        $('#brn').hide('slow');
        ajax_load(base_url + 'vendor/product/brand_by_sub/' + id, 'brand', 'other');
        $('#brn').show('slow');
    }

    function get_sub_res(id) {}

    $(".unit").on('keyup', function() {
        $(".unit_set").html($(".unit").val());
    });

    function createColorpickers() {

        $('.demo2').colorpicker({
            format: 'rgba'
        });

    }

    $("#more_btn").click(function() {
        $("#more_additional_fields").append('' +
            '<div class="form-group">' +
            '    <div class="col-sm-4">' +
            '        <input type="text" name="ad_field_names[]" class="form-control required"  placeholder="<?php echo translate('field_name'); ?>">' +
            '    </div>' +
            '    <div class="col-sm-5">' +
            '        <textarea rows="9"  class="summernotes" data-height="100" data-name="ad_field_values[]"></textarea>' +
            '    </div>' +
            '    <div class="col-sm-2">' +
            '        <span class="remove_it_v rms btn btn-danger btn-icon btn-circle icon-lg fa fa-times" onclick="delete_row(this)"></span>' +
            '    </div>' +
            '</div>'
        );
        set_summer();
    });

    function next_tab() {
        $('.nav-tabs li.active').next().find('a').click();
    }

    function previous_tab() {
        $('.nav-tabs li.active').prev().find('a').click();
    }

    $("#more_option_btn").click(function() {
        option_count('add');
        var co = $('#option_count').val();
        $("#more_additional_options").append('' +
            '<div class="form-group" data-no="' + co + '">' +
            '    <div class="col-sm-4">' +
            '        <input type="text" name="op_title[]" class="form-control required"  placeholder="<?php echo translate('customer_input_title'); ?>">' +
            '    </div>' +
            '    <div class="col-sm-5">' +
            '        <select class="demo-chosen-select op_type required" name="op_type[]" >' +
            '            <option value="">(none)</option>' +
            '            <option value="text">Text Input</option>' +
            '            <option value="single_select">Dropdown Single Select</option>' +
            '            <option value="multi_select">Dropdown Multi Select</option>' +
            '            <option value="radio">Radio</option>' +
            '        </select>' +
            '        <div class="col-sm-12 options">' +
            '          <input type="hidden" name="op_set' + co + '[]" value="none" >' +
            '        </div>' +
            '    </div>' +
            '    <input type="hidden" name="op_no[]" value="' + co + '" >' +
            '    <div class="col-sm-2">' +
            '        <span class="remove_it_o rmo btn btn-danger btn-icon btn-circle icon-lg fa fa-times" onclick="delete_row(this)"></span>' +
            '    </div>' +
            '</div>'
        );
        set_select();
    });

    $("#more_additional_options").on('change', '.op_type', function() {
        var co = $(this).closest('.form-group').data('no');
        if ($(this).val() !== 'text' && $(this).val() !== '') {
            $(this).closest('div').find(".options").html('' +
                '    <div class="col-sm-12">' +
                '        <div class="col-sm-12 options margin-bottom-10"></div><br>' +
                '        <div class="btn btn-mint btn-labeled fa fa-plus pull-right add_op">' +
                '        <?php echo translate('add_options_for_choice'); ?></div>' +
                '    </div>'
            );
        } else if ($(this).val() == 'text' || $(this).val() == '') {
            $(this).closest('div').find(".options").html('' +
                '    <input type="hidden" name="op_set' + co + '[]" value="none" >'
            );
        }
    });

    $("#more_additional_options").on('click', '.add_op', function() {
        var co = $(this).closest('.form-group').data('no');
        $(this).closest('.col-sm-12').find(".options").append('' +
            '    <div>' +
            '        <div class="col-sm-10">' +
            '          <input type="text" name="op_set' + co + '[]" class="form-control required"  placeholder="<?php echo translate('option_name'); ?>">' +
            '        </div>' +
            '        <div class="col-sm-2">' +
            '          <span class="remove_it_n rmon btn btn-danger btn-icon btn-circle icon-sm fa fa-times" onclick="delete_row(this)"></span>' +
            '        </div>' +
            '    </div>'
        );
    });

    $('body').on('click', '.rmo', function() {
        $(this).parent().parent().remove();
    });

    $('body').on('click', '.rmon', function() {
        var co = $(this).closest('.form-group').data('no');
        $(this).parent().parent().remove();
        if ($(this).parent().parent().parent().html() == '') {
            $(this).parent().parent().parent().html('' +
                '   <input type="hidden" name="op_set' + co + '[]" value="none" >'
            );
        }
    });

    $('body').on('click', '.rms', function() {
        $(this).parent().parent().remove();
    });

    $("#more_color_btn").click(function() {
        $("#more_colors").append('' +
            '      <div class="col-md-12" style="margin-bottom:8px;">' +
            '          <div class="col-md-10">' +
            '              <div class="input-group demo2">' +
            '                 <input type="text" value="#ccc" name="color[]" class="form-control" />' +
            '                 <span class="input-group-addon"><i></i></span>' +
            '              </div>' +
            '          </div>' +
            '          <span class="col-md-2">' +
            '              <span class="remove_it_v rmc btn btn-danger btn-icon icon-lg fa fa-trash" ></span>' +
            '          </span>' +
            '      </div>'
        );
        createColorpickers();
    });

    $('body').on('click', '.rmc', function() {
        $(this).parent().parent().remove();
    });


    $(document).ready(function() {
        $("form").submit(function(e) {
            event.preventDefault();
        });
    });


    $('.food_name').change(function() {
        var id = $(this).attr('data-id');
        var paring = eval ("var "+ $(this).val() + ";");
        var categoryType = $(this).val();
        
        var Appetizer = ['antipesto.jpeg', 'Bread_dip.jpeg', 'Bruschetta.jpeg', 'curry_puff.jpeg', 'japanese_squid_ball_Takoyaki.jpeg', 'meatball.jpeg', 'mini_quiche_pastry.jpeg', 'nuts.jpeg', 'olives.jpeg', 'Pate.jpeg', 'rice-cracker.jpg', 'savoury_pastry.jpeg', 'smoked_salmon_cream_cheese.jpeg', 'soup.jpeg', 'spring_roll.jpeg', 'yum_cha_dim_sim.jpeg'];


        var Snacks = ['antipesto.jpeg', 'Bread_dip.jpeg', 'Bruschetta.jpeg', 'curry_puff.jpeg', 'japanese_squid_ball_Takoyaki.jpeg', 'meatball.jpeg', 'mini_quiche_pastry.jpeg', 'nuts.jpeg', 'olives.jpeg', 'Pate.jpeg', 'rice-cracker.jpg', 'savoury_pastry.jpeg', 'smoked_salmon_cream_cheese.jpeg', 'Soup.jpeg', 'spring_roll.jpeg', 'yum_cha_dim_sim.jpeg'];
        var Beef = ['BBQ_Grill.jpg', 'beef-rendang1.jpg', 'Curry_meat.jpg', 'Deep_fry_or_stir_fry.jpeg', 'Grill_BBQ_Lamb.jpeg', 'Grill_BBQ_Roast.jpeg', 'hotpot_Lamb_Beef.jpeg', 'hot-pot-meat.jpg', 'lamb-shank.jpeg', 'Meat-salad.jpg', 'pie-pastry.jpg', 'skewer-Grill_meat.jpeg', 'Smoked-meat.jpg', 'Stew.jpg', 'Stirfry_Spicy.jpeg', 'Waygu-Beef.jpeg'];
        var Lamb = ['BBQ_Grill.jpg', 'beef-rendang1.jpg', 'Curry_meat.jpg', 'Deep_fry_or_stir_fry.jpeg', 'Grill_BBQ_Lamb.jpeg', 'Grill_BBQ_Roast.jpeg', 'hotpot_Lamb_Beef.jpeg', 'hot-pot_meat.jpg', 'lamb_shank.jpeg', 'Meat_salad.jpg', 'pie_pastry.jpeg', 'skewer_Grill_meat.jpeg', 'Smoked_meat.jpg', 'Stew.jpg', 'Stirfry_Spicy.jpeg', 'Waygu_Beef.jpeg'];
        var Veal = ['Babi_Kecap-pork_dish.jpeg', 'Chinese_BBQ_roast_pork.jpeg', 'crumbed_veal.jpeg', 'Deep_fried_Pork.jpeg', 'Pork_Belly.jpeg', 'pork_dumpling.jpeg', 'Pork_Katsu_curry.jpg', 'Pork_ribs.jpeg', 'Pork_Skwer.jpeg', 'Pork_stew.jpeg', 'pull_pork_salad.jpeg', 'roast_pork.jpeg', 'spicy_pork.jpeg', 'Steamed_poach_Boiled.jpg', 'stir_fry_pork_mince.jpeg', 'Veal.jpeg'];
        var Pork = ['Babi_Kecap-pork_dish.jpeg', 'ChineseBBQ_roast_pork.jpeg', 'crumbed_veal.jpeg', 'Deep_fried_Pork.jpeg', 'Pork_Belly.jpeg', 'pork_dumpling.jpeg', 'Pork_Katsu_curry.jpg', 'Pork_ribs.jpeg', 'Pork_Skwer.jpeg', 'Pork_stew.jpeg', 'pull_pork_salad.jpeg', 'roast_pork.jpeg', 'spicy_pork.jpeg', 'Steamed_poach_Boiled.jpg', 'stir_fry_pork_mince.jpeg', 'Veal.jpeg'];
        var Game = ['BBQ_Grill.jpg', 'beef-rendang1.jpg', 'Curry_meat.jpg', 'Deep_fry_or_stir_fry.jpeg', 'Grill_BBQ_Lamb.jpeg', 'Grill_BBQ_Roast.jpeg', 'hotpot_Lamb_Beef.jpeg', 'hot-pot_meat.jpg', 'lamb_shank.jpeg', 'Meat_salad.jpg', 'pie_pastry.jpeg', 'skewer_Grill_meat.jpeg', 'Smoked_meat.jpg', 'Stew.jpg', 'Stirfry_Spicy.jpeg', 'Waygu_Beef.jpeg'];
        var Poultry = ['Chicken_Ceasar_Salad.jpeg', 'Chicken_Curry.jpeg', 'chicken_Parmigiana.jpeg', 'chicken_skewer.jpeg', 'Chinese_Soy_Chicken.jpg', 'duck_confit.jpeg', 'Fried_Chicken_korean.jpeg', 'Grill_Chicken.jpeg', 'Hainan_Chicken.jpeg', 'Hotpot_Chicken_steam_boil.jpeg', 'indonesian_chicken.jpeg', 'Lemongrass_chicken.jpeg', 'Peking_duck.jpeg', 'Quail.jpeg', 'spicy_stir_fry_Chicken.jpeg', 'Tandori_Chicken.jpeg'];
        var Mushroom = ['braised_shitake_mushroom.jpeg', 'clay_pot_vegetable_braised.jpeg', 'fried_mushroom.jpeg', 'garlic_mushroom.jpeg', 'mix_salad.jpeg', 'roast_vegetable.jpeg', 'soup_pumpkin.jpeg', 'spicy_vegetable_kim_chi.jpeg', 'steam_vegetable.jpeg', 'stir_fry.jpeg', 'stuffed_mushroom.jpeg', 'vegetable_curry.jpeg', 'vegetable_pie_quiche.jpeg', 'vegetable_stew.jpeg', 'vegetable_tempura.jpeg', 'vegeterian_pizza.jpeg'];
        var Pasta = ['bibimbap.jpeg', 'Char_Kway_teow.jpeg', 'Chinese_sticky_rice.jpeg', 'Fried_rice.jpeg', 'Hainan_chicken_rice.jpegindian_rice.jpeg', 'Lasagne_pasta_bake.jpeg', 'Paella_rice.jpeg', 'Pasta.jpeg', 'pasta_salad.jpg', 'Ramen.jpeg', 'Risotto.jpeg', 'Seafood_laksa.jpeg', 'Spicy_meat_soup_noodle.jpeg', 'tortellini.jpeg', 'vietnamese_noodle_Pho.jpeg'];
        var Noodle = ['bibimbap.jpeg', 'Char_Kway_teow.jpeg', 'Chinese_sticky_rice.jpeg', 'Fried_rice.jpeg', 'Hainan_chicken_rice.jpeg', 'indian_rice.jpeg', 'Lasagne_pasta_bake.jpeg', 'Paella_rice.jpeg', 'Pasta.jpeg', 'pasta_salad.jpg', 'Ramen.jpeg', 'Risotto.jpeg', 'Seafood_laksa.jpeg', 'Spicy_meat_soup_noodle.jpeg', 'tortellini.jpeg', 'vietnamese_noodle_Pho.jpeg'];
        var Fish = ['abalone.jpeg', 'battered_fish.jpeg', 'Chilli_Crab.jpeg', 'fish_curry.jpeg', 'Grill_fish.jpeg', 'lobstor_stir_fry.jpeg', 'oyster_natural_shellfish.jpeg', 'Pan_seared_salmon.jpeg', 'prawns.jpeg', 'Seafood_soup.jpeg', 'seared_scallop.jpeg', 'shellfish_oven_baked.jpeg', 'spicy_stirfry_squid.jpeg', 'steam_fish.jpeg', 'Sushi_raw_fish.jpeg', 'unagi_eel.jpeg'];
        var Shellfish = ['abalone.jpeg', 'battered_fish.jpeg', 'Chilli_Crab.jpeg', 'fish_curry.jpeg', 'Grill_fish.jpeg', 'lobstor_stir_fry.jpeg', 'oyster_natural_shellfish.jpeg', 'Pan_seared_salmon.jpeg', 'prawns.jpeg', 'Seafood_soup.jpeg', 'seared_scallop.jpeg', 'shellfish_oven_baked.jpeg', 'spicy_stirfry_squid.jpeg', 'steam_fish.jpeg', 'Sushi_raw_fish.jpeg', 'unagi_eel.jpeg'];

        var Snacks = ['antipesto.jpeg', 'Bread_dip.jpeg', 'Bruschetta.jpeg', 'curry_puff.jpeg',
            //'japanese_squid_ball_Takoyaki.jpeg',
            'meatball.jpeg', 'mini_quiche_pastry.jpeg', 'nuts.jpeg', 'olives.jpeg', 'Pate.jpeg', 'rice-cracker.jpg', 'savoury_pastry.jpeg', 'smoked_salmon_cream_cheese.jpeg', 'Soup.jpeg', 'spring_roll.jpeg', 'yum_cha_dim_sim.jpeg'
        ];
        var Beef = ['BBQ_Grill.jpg', 'beef-rendang1.jpg', 'Curry_meat.jpg', 'Deep_fry_or_stir fry.jpeg', 'Grill_BBQ_Lamb.jpeg', 'Grill_BBQ_Roast.jpeg', 'hotpot_Lamb_Beef.jpeg', 'hot-pot-meat.jpg', 'lamb-shank.jpeg', 'Meat-salad.jpg', 'pie-pastry.jpg', 'skewer-Grill meat.jpeg', 'Smoked-meat.jpg', 'Stew.jpg', 'Stirfry_Spicy.jpeg', 'Waygu-Beef.jpeg'];
        var Lamb = ['BBQ_Grill.jpg', 'beef-rendang1.jpg', 'Curry_meat.jpg', 'Deep_fry_or_stir_fry.jpeg', 'Grill_BBQ Lamb.jpeg', 'Grill_BBQ_Roast.jpeg', 'hotpot_Lamb_Beef.jpeg', 'hot-pot_meat.jpg', 'lamb_shank.jpeg', 'Meat_salad.jpg', 'pie_pastry.jpeg', 'skewer_Grill_meat.jpeg', 'Smoked_meat.jpg', 'Stew.jpg', 'Stirfry_Spicy.jpeg', 'Waygu_Beef.jpeg'];
        var Veal = ['Babi_Kecap-pork_dish.jpeg', 'Chinese_BBQ_roast_pork.jpeg', 'crumbed_veal.jpeg', 'Deep_fried_Pork.jpeg', 'Pork_Belly.jpeg', 'pork_dumpling.jpeg', 'Pork Katsu_curry.jpg', 'Pork ribs.jpeg', 'Pork_Skwer.jpeg', 'Pork_stew.jpeg', 'pull_pork_salad.jpeg', 'roast_pork.jpeg', 'spicy_pork.jpeg', 'Steamed_poach_Boiled.jpg', 'stir_fry_pork_mince.jpeg', 'Veal.jpeg'];
        var Pork = ['Babi_Kecap-pork_dish.jpeg', 'ChineseBBQ_roast_pork.jpeg', 'crumbed_veal.jpeg', 'Deep_fried_Pork.jpeg', 'Pork_Belly.jpeg', 'pork_dumpling.jpeg', 'Pork_Katsu_curry.jpg', 'Pork ribs.jpeg', 'Pork Skwer.jpeg', 'Pork_stew.jpeg', 'pull_pork_salad.jpeg', 'roast pork.jpeg', 'spicy_pork.jpeg', 'Steamed_poach_Boiled.jpg', 'stir_fry_pork mince.jpeg', 'Veal.jpeg'];
        var Game = ['BBQ_Grill.jpg', 'beef-rendang1.jpg', 'Curry_meat.jpg', 'Deep fry_or_stir_fry.jpeg', 'Grill_BBQ_Lamb.jpeg', 'Grill_BBQ_Roast.jpeg', 'hotpot_Lamb_Beef.jpeg', 'hot-pot meat.jpg', 'lamb_shank.jpeg', 'Meat salad.jpg', 'pie pastry.jpeg', 'skewer_Grill_meat.jpeg', 'Smoked_meat.jpg', 'Stew.jpg', 'Stirfry_Spicy.jpeg', 'Waygu_Beef.jpeg'];
        var Poultry = ['Chicken_Ceasar_Salad.jpeg', 'Chicken_Curry.jpeg', 'chicken_Parmigiana.jpeg', 'chicken_skewer.jpeg', 'Chinese_Soy_Chicken.jpg', 'duck_confit.jpeg', 'Fried_Chicken_korean.jpeg', 'Grill_Chicken.jpeg', 'Hainan_Chicken.jpeg', 'Hotpot_Chicken_steam_boil.jpeg', 'indonesian_chicken.jpeg', 'Lemongrass_chicken.jpeg', 'Peking_duck.jpeg', 'Quail.jpeg',
            //'spicy_stir fry_Chicken.jpeg',
            // 'Tandori_Chicken.jpeg'
        ];
        var Mushroom = ['braised_shitake_mushroom.jpeg', 'clay_pot vegetable_braised.jpeg', 'fried_mushroom.jpeg', 'garlic mushroom.jpeg', 'mix_salad.jpeg', 'roast_vegetable.jpeg', 'soup_pumpkin.jpeg', 'spicy vegetable_kim_chi.jpeg', 'steam_vegetable.jpeg', 'stir_fry.jpeg', 'stuffed_mushroom.jpeg', 'vegetable_curry.jpeg', 'vegetable_pie_quiche.jpeg', 'vegetable stew.jpeg', 'vegetable_tempura.jpeg', 'vegeterian_pizza.jpeg'];
        var Pasta = ['bibimbap.jpeg', 'Char_Kway_teow.jpeg', 'Chinese_sticky rice.jpeg', 'Fried_rice.jpeg', 'Hainan_chicken_rice.jpegindian rice.jpeg', 'Lasagne_pasta bake.jpeg', 'Paella rice.jpeg', 'Pasta.jpeg', 'pasta salad.jpg', 'Ramen.jpeg', 'Risotto.jpeg', 'Seafood_laksa.jpeg', 'Spicy_meat_soup_noodle.jpeg', 'tortellini.jpeg', 'vietnamese noodle Pho.jpeg'];
        var Noodle = ['bibimbap.jpeg', 'Char_Kway_teow.jpeg', 'Chinese_sticky rice.jpeg', 'Fried_rice.jpeg', 'Hainan_chicken_rice.jpeg', 'indian_rice.jpeg', 'Lasagne_pasta bake.jpeg', 'Paella_rice.jpeg', 'Pasta.jpeg', 'pasta_salad.jpg', 'Ramen.jpeg', 'Risotto.jpeg', 'Seafood laksa.jpeg', 'Spicy_meat_soup_noodle.jpeg', 'tortellini.jpeg', 'vietnamese_noodle_Pho.jpeg'];
        var Fish = ['abalone.jpeg', 'battered_fish.jpeg', 'Chilli_Crab.jpeg', 'fish_curry.jpeg', 'Grill_fish.jpeg', 'lobstor_stir_fry.jpeg', 'oyster_natural_shellfish.jpeg', 'Pan_seared_salmon.jpeg', 'prawns.jpeg', 'Seafood_soup.jpeg', 'seared_scallop.jpeg', 'shellfish_oven_baked.jpeg', 'spicy_stirfry_squid.jpeg', 'steam fish.jpeg', 'Sushi_raw fish.jpeg', 'unagi_eel.jpeg'];
        var Shellfish = ['abalone.jpeg', 'battered_fish.jpeg', 'Chilli_Crab.jpeg', 'fish curry.jpeg', 'Grill_fish.jpeg', 'lobstor_stir_fry.jpeg', 'oyster_natural_shellfish.jpeg', 'Pan_seared_salmon.jpeg', 'prawns.jpeg', 'Seafood_soup.jpeg', 'seared_scallop.jpeg', 'shellfish_oven_baked.jpeg', 'spicy_stirfry_squid.jpeg', 'steam fish.jpeg', 'Sushi_raw_fish.jpeg', 'unagi_eel.jpeg'];

        var Seafood = ['abalone.jpeg', 'battered_fish.jpeg', 'Chilli_Crab.jpeg', 'fish_curry.jpeg', 'Grill_fish.jpeg', 'lobstor_stir_fry.jpeg', 'oyster_natural_shellfish.jpeg', 'Pan_seared_salmon.jpeg', 'prawns.jpeg', 'Seafood_soup.jpeg', 'seared_scallop.jpeg', 'shellfish_oven_baked.jpeg', 'spicy_stirfry_squid.jpeg', 'steam_fish.jpeg', 'Sushi_raw_fish.jpeg', 'unagi_eel.jpeg'];

        var Vegetables = ['braised_shitake_mushroom.jpeg', 'clay_pot_vegetable_braised.jpeg', 'fried_mushroom.jpeg', 'garlic_mushroom.jpeg', 'mix_salad.jpeg', 'roast_vegetable.jpeg', 'soup_pumpkin.jpeg', 'spicy_vegetable_kim_chi.jpeg', 'steam_vegetable.jpeg', 'stir_fry.jpeg', 'stuffed_mushroom.jpeg', 'vegetable_curry.jpeg', 'vegetable_pie_quiche.jpeg', 'vegetable_stew.jpeg', 'vegetable_tempura.jpeg', 'vegeterian_pizza.jpeg'];

        var Savoury = ['antipesto.jpeg', 'Bread_dip.jpeg', 'Bruschetta.jpeg', 'curry_puff.jpeg', 'japanese_squid_ball_Takoyaki.jpeg', 'meatball.jpeg', 'mini_quiche_pastry.jpeg', 'nuts.jpeg', 'olives.jpeg', 'Pate.jpeg', 'rice-cracker.jpg', 'savoury_pastry.jpeg', 'smoked_salmon_cream_cheese.jpeg', 'Soup.jpeg', 'spring_roll.jpeg', 'yum_cha_dim_sim.jpeg'];

        var Dessert = ['cheese_cake.jpeg', 'cheese_platter.jpeg', 'chinese_sweet_soup.jpeg', 'creme_brulee.jpeg', 'custard_bun.jpeg', 'fried_red_bean_pancake.jpeg', 'fruit.jpeg', 'icecream_gelato_sorbet.jpeg', 'macaron.jpeg', 'Matcha_dessert.jpeg', 'mochi.jpeg', 'mousse.jpeg', 'Souffle.jpeg', 'Sticky_rice_dessert.jpeg', 'tiramisu.jpeg', 'waffles.jpeg'];

        var Rice = ['bibimbap.jpeg', 'Char_Kway_teow.jpeg', 'Chinese_sticky_rice.jpeg', 'Fried_rice.jpeg', 'Hainan_chicken_rice.jpeg', 'indian_rice.jpeg', 'Lasagne_pasta_bake.jpeg', 'Paella_rice.jpeg', 'Pasta.jpeg', 'pasta_salad.jpg', 'Ramen.jpeg', 'Risotto.jpeg', 'Seafood_laksa.jpeg', 'Spicy_meat_soup_noodle.jpeg', 'tortellini.jpeg', 'vietnamese_noodle_Pho.jpeg'];
        var Cheese = ['cheese_cake.jpeg', 'cheese_platter.jpeg', 'chinese_sweet_soup.jpeg', 'creme_brulee.jpeg', 'custard_bun.jpeg', 'fried_red_bean_pancake.jpeg', 'fruit.jpeg', 'icecream_gelato_sorbet.jpeg', 'macaron.jpeg', 'Matcha_dessert.jpeg', 'mochi.jpeg', 'mousse.jpeg', 'Souffle.jpeg', 'Sticky_rice_dessert.jpeg', 'tiramisu.jpeg', 'waffles.jpeg'];

        var images_name = "";
        // if (paring == 'Appetizer') {
            // images_name += "<select class='form-control image_name' name='food_image" + id + "' paring='" + paring + "' image-food-id=" + id + "  ><option value=''>Select...</option>";
            var loop =1;
            for (image of eval($(this).val())) {
                if(loop <= 10)
                    images_name += '<div class="col-md-2"><input type ="radio" name="food_image'+id+'" value="'+image+'"><img style="height: 86px;width: 135px;" src="' + base_url + 'uploads/food_paring/' + categoryType + '/' + image + '"></div>';

               loop++; 
            }

            // images_name += '</select>';
        // }
        // if (paring == 'Snacks') {
        //     images_name += "<select class='form-control image_name' name='food_image" + id + "' paring='" + paring + "' image-food-id=" + id + "  ><option value=''>Select...</option>";

        //     for (paring of Snacks) {
        //         images_name += "<option value=" + paring + ">" + paring + "</option>"
        //     }

        //     images_name += '</select>';
        // }
        // if (paring == 'Beef') {
        //     images_name += "<select class='form-control image_name' name='food_image" + id + "' paring='" + paring + "' image-food-id=" + id + "  ><option value=''>Select...</option>";

        //     for (paring of Beef) {
        //         images_name += "<option value=" + paring + ">" + paring + "</option>"
        //     }

        //     images_name += '</select>';
        // }
        // if (paring == 'Lamb') {
        //     images_name += "<select class='form-control image_name' name='food_image" + id + "' paring='" + paring + "' image-food-id=" + id + "  ><option value=''>Select...</option>";

        //     for (paring of Lamb) {
        //         images_name += "<option value=" + paring + ">" + paring + "</option>"
        //     }

        //     images_name += '</select>';
        // }
        // if (paring == 'Veal') {
        //     images_name += "<select class='form-control image_name' name='food_image" + id + "' paring='" + paring + "' image-food-id=" + id + "  ><option value=''>Select...</option>";

        //     for (paring of Veal) {
        //         images_name += "<option value=" + paring + ">" + paring + "</option>"
        //     }

        //     images_name += '</select>';
        // }
        // if (paring == 'Pork') {
        //     images_name += "<select class='form-control image_name' name='food_image" + id + "' paring='" + paring + "' image-food-id=" + id + "  ><option value=''>Select...</option>";

        //     for (paring of Pork) {
        //         images_name += "<option value=" + paring + ">" + paring + "</option>"
        //     }

        //     images_name += '</select>';
        // }
        // if (paring == 'Game') {
        //     images_name += "<select class='form-control image_name' name='food_image" + id + "' paring='" + paring + "' image-food-id=" + id + "  ><option value=''>Select...</option>";

        //     for (paring of Game) {
        //         images_name += "<option value=" + paring + ">" + paring + "</option>"
        //     }

        //     images_name += '</select>';
        // }
        // if (paring == 'Poultry') {
        //     images_name += "<select class='form-control image_name' name='food_image" + id + "' paring='" + paring + "' image-food-id=" + id + "  ><option value=''>Select...</option>";

        //     for (paring of Poultry) {
        //         images_name += "<option value=" + paring + ">" + paring + "</option>"
        //     }

        //     images_name += '</select>';
        // }
        // if (paring == 'Mushrooms') {
        //     images_name += "<select class='form-control image_name' name='food_image" + id + "' paring='" + paring + "' image-food-id=" + id + "  ><option value=''>Select...</option>";

        //     for (paring of Mushrooms) {
        //         images_name += "<option value=" + paring + ">" + paring + "</option>"
        //     }

        //     images_name += '</select>';
        // }
        // if (paring == 'Pasta') {
        //     images_name += "<select class='form-control image_name' name='food_image" + id + "' paring='" + paring + "' image-food-id=" + id + "  ><option value=''>Select...</option>";

        //     for (paring of Pasta) {
        //         images_name += "<option value=" + paring + ">" + paring + "</option>"
        //     }

        //     images_name += '</select>';
        // }
        // if (paring == 'Noodle') {
        //     images_name += "<select class='form-control image_name' name='food_image" + id + "' paring='" + paring + "' image-food-id=" + id + "  ><option value=''>Select...</option>";

        //     for (paring of Noodle) {
        //         images_name += "<option value=" + paring + ">" + paring + "</option>"
        //     }

        //     images_name += '</select>';
        // }
        // if (paring == 'fish') {
        //     images_name += "<select class='form-control image_name' name='food_image" + id + "' paring='" + paring + "' image-food-id=" + id + "  ><option value=''>Select...</option>";

        //     for (paring of fish) {
        //         images_name += "<option value=" + paring + ">" + paring + "</option>"
        //     }

        //     images_name += '</select>';
        // }
        // if (paring == 'Shellfish') {
        //     images_name += "<select class='form-control image_name' name='food_image" + id + "' paring='" + paring + "' image-food-id=" + id + "  ><option value=''>Select...</option>";

        //     for (paring of Shellfish) {
        //         images_name += "<option value=" + paring + ">" + paring + "</option>"
        //     }

        //     images_name += '</select>';
        // }
        // if (paring == 'Seafood') {
        //     images_name += "<select class='form-control image_name' name='food_image" + id + "' paring='" + paring + "' image-food-id=" + id + "  ><option value=''>Select...</option>";

        //     for (paring of Seafood) {
        //         images_name += "<option value=" + paring + ">" + paring + "</option>"
        //     }

        //     images_name += '</select>';
        // }
        // if (paring == 'Crab') {
        //     images_name += "<select class='form-control image_name' name='food_image" + id + "' paring='" + paring + "' image-food-id=" + id + "  ><option value=''>Select...</option>";

        //     for (paring of Crab) {
        //         images_name += "<option value=" + paring + ">" + paring + "</option>"
        //     }

        //     images_name += '</select>';
        // }
        // if (paring == 'Vegetable') {
        //     images_name += "<select class='form-control image_name' name='food_image" + id + "' paring='" + paring + "' image-food-id=" + id + "  ><option value=''>Select...</option>";

        //     for (paring of Vegetable) {
        //         images_name += "<option value=" + paring + ">" + paring + "</option>"
        //     }

        //     images_name += '</select>';
        // }
        // if (paring == 'Olives') {
        //     images_name += "<select class='form-control image_name' name='food_image" + id + "' paring='" + paring + "' image-food-id=" + id + "  ><option value=''>Select...</option>";

        //     for (paring of Olives) {
        //         images_name += "<option value=" + paring + ">" + paring + "</option>"
        //     }

        //     images_name += '</select>';
        // }
        // if (paring == 'Dessert') {
        //     images_name += "<select class='form-control image_name' name='food_image" + id + "' paring='" + paring + "' image-food-id=" + id + "  ><option value=''>Select...</option>";

        //     for (paring of Dessert) {
        //         images_name += "<option value=" + paring + ">" + paring + "</option>"
        //     }

        //     images_name += '</select>';
        // }
        // if (paring == 'Savoury') {
        //     images_name += "<select class='form-control image_name' name='food_image" + id + "' paring='" + paring + "' image-food-id=" + id + "  ><option value=''>Select...</option>";

        //     for (paring of Savoury) {
        //         images_name += "<option value=" + paring + ">" + paring + "</option>"
        //     }

        //     images_name += '</select>';
        // }

        $('.food_image' + id + '_name').html(images_name);
    });
    $(document).on('change', '.image_name', function() {
        var food_id = $(this).attr('image-food-id');
        var selected_paring = $(this).attr('paring');
        var image_name = $(this).val();
        var images = '<span style="float:left;border:4px solid #303641;padding:5px;margin:5px;"><img style="height: 86px;width: 135px;" src="' + base_url + 'uploads/food_paring/' + selected_paring + '/' + image_name + '"></span>';
        $('.food_image' + food_id + '_preview').html(images);
    });
    $('.image_limit').bind('change', function() {
        var a = (this.files[0].size);
        if (a > 2000000) {
            alert('Please select image size less than 2 MB');
            $('.image_limit').val(" ");
        };
    });
    /*
        var uploadField = document.getElementById("file");

    uploadField.onchange = function() {
        if(this.files[0].size > 307200){
           alert("File is too big!");
           this.value = "";
        };
    };*/
</script>
<style>
    .btm_border {
        border-bottom: 1px solid #ebebeb;
        padding-bottom: 15px;
    }
</style>
