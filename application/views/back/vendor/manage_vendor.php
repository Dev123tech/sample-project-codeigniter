<script src="https://maps.google.com/maps/api/js?v=3.exp&signed_in=true&callback=MapApiLoaded&key=<?php echo $this->db->get_where('general_settings',array('type' => 'google_api_key'))->row()->value; ?>"></script>
<div id="content-container">
    <div id="page-title">
        <h1 class="page-header text-overflow"><?php echo translate('manage_profile');?></h1>
    </div>
    <div class="tab-base">
        <div class="panel">
            <div class="panel-body">
                <div class="tab-content">
                    <div class="tab-pane fade active in" id="" style="border:1px solid #ebebeb; border-radius:4px;">
                        <?php
                            $vendor_data = $this->db->get_where('vendor', array(
                                'vendor_id' => $this->session->userdata('vendor_id')
                            ))->result_array();
                            foreach ($vendor_data as $row) {
                            ?>
                        <div class="panel-heading">
                            <div class="panel-control" style="float: left;">
                                <ul class="nav nav-tabs">
                                    <li class="active">
                                        <a data-toggle="tab" href="#details"><?php echo translate('details'); ?></a>
                                    </li>
                                    <li>
                                        <a data-toggle="tab" href="#account_details"><?php echo translate('account_details'); ?></a>
                                    </li>
                                    <li>
                                        <a data-toggle="tab" href="#other_details"><?php echo translate('other_details'); ?></a>
                                    </li>
                                    <li>
                                        <a data-toggle="tab" href="#agreement"><?php echo translate('document'); ?></a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <?php
                            echo form_open(base_url() . 'vendor/manage_vendor/update_profile/', array(
                                'class' => 'form-horizontal',
                                'method' => 'post'
                            ));
                            ?>
                        <div class="panel-body">
                            <div class="tab-base">
                                <div class="tab-content">
                                    <!-- Start Manage Detail -->
                                    <div  id="details" class="tab-pane fade active in">
                                        <div class="form-group btm_border">
                                            <h4 class="text-thin text-center"><?php echo translate('details'); ?></h4>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-3 control-label" for="demo-hor-1">
                                            <?php echo translate('company_name');?>
                                            </label>
                                            <div class="col-sm-6">
                                                <input type="text" name="company" value="<?php echo ucwords($row['company']); ?>" id="demo-hor-1" class="form-control required">
                                            </div>
                                        </div>
                                        <div class="form-group btm_border">
                                            <label class="col-sm-3 control-label" for="demo-hor-12"><?php echo translate('company_Logo (Image PNG)');?></label>
                                            <div class="col-sm-6">
                                                <span class="pull-left btn btn-default btn-file"> <?php echo translate('choose_file');?>
                                                <input type="file" name="images" onchange="previewcompany(this);" id="demo-hor-inputpass0" class="form-control">
                                                 <input type="hidden"  name="last_images" value="<?php echo $row['company_image']; ?>">
                                                </span>
                                                <br><br>
                                                <span id="previewcompanyImg" ></span>
                                            </div>
                                        </div>
                                        <?php
                                            if($row['company_image'])
                                            {
                                        ?>       
                                            <div class="form-group btm_border">
                                                <label class="col-sm-3 control-label"></label>
                                                <div class="col-sm-6">
                                                    <?php 
                                                        $images = explode(",",$row['company_image']);
                                                        if($images)
                                                        {
                                                            foreach ($images as $row1)
                                                            {
                                                        ?>
                                                            <div class="delete-div-wrap">
                                                                <span class="close" >&times;</span>
                                                                <div class="inner-div">
                                                                    <img class="img-responsive" width="100" src="<?php echo base_url(); ?>uploads/events_image/<?php echo $row1; ?> "alt="User_Image">
                                                                </div>
                                                            </div>
                                                        <?php 
                                                            } 
                                                        } 
                                                        ?>
                                                </div>
                                            </div>
                                        <?php
                                            }
                                        ?>
                                        <div class="form-group btm_border">
                                            <label class="col-sm-3 control-label" >
                                            <?php echo translate('trading_name');?>
                                            </label>
                                            <div class="col-sm-6">
                                                <input type="text" name="trading_name" placeholder="<?php echo translate('trading_name'); ?>" value="<?php echo ucwords($row['trading_name']); ?>" class="form-control ">
                                            </div>
                                        </div>
                                        <div class="form-group btm_border">
                                            <label class="col-sm-3 control-label" for="demo-hor-1">
                                            <?php echo translate('website');?>
                                            </label>
                                            <div class="col-sm-6">
                                                <input type="text" name="website" value="<?php echo ucwords($row['website']); ?>" id="demo-hor-1" class="form-control required">
                                            </div>
                                        </div>
                                        <div class="form-group btm_border">
                                            <label class="col-sm-3 control-label">
                                            <?php echo "ACN / ABN";?>
                                            </label>
                                            <div class="col-sm-6">
                                                <input type="text" name="acn_and_abn" placeholder="<?php echo translate('ACN / ABN'); ?>"  value="<?php echo ucwords($row['acn_and_abn']); ?>"  class="form-control" onkeypress="isInputNumber(event)">
                                            </div>
                                        </div>
                                        <div class="form-group btm_border">
                                            <label class="col-sm-3 control-label" >
                                            <?php echo translate('Licence_number');?>
                                            </label>
                                            <div class="col-sm-6">
                                                <input type="text" name="license_number" placeholder="<?php echo translate('license_number'); ?>"  value="<?php echo ucwords($row['license_number']); ?>" id="demo-hor-57" class="form-control ">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-3 control-label" for="demo-hor-3">
                                            <?php echo translate('phone (area_code)');?>
                                            </label>
                                            <div class="col-sm-2">
                                                <div class="select-wrapper">
                                                    <select name="phone_code" class="form-control">
                                                        <option value="<?php echo $row['phone_code']; ?>"><?php echo "(+".$row['phone_code'].")"; ?></option>
                                                        <?php if($row['phone_code'] !="02"){ ?><option value="02">(+02)</option><?php } ?>
                                                        <?php if($row['phone_code'] !="03"){ ?><option value="03">(+03)</option><?php } ?>
                                                        <?php if($row['phone_code'] !="04"){ ?><option value="04">(+04)</option><?php } ?>
                                                        <?php if($row['phone_code'] !="07"){ ?><option value="07">(+07)</option><?php } ?>
                                                        <?php if($row['phone_code'] !="08"){ ?><option value="08">(+08)</option><?php } ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                                <input type="text" name="phone" value="<?php echo $row['phone']; ?>" id="demo-hor-3" class="form-control" onkeypress="isInputNumber(event)">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-3 control-label" for="demo-hor-2">
                                            <?php echo translate('email');?>
                                            </label>
                                            <div class="col-sm-6">
                                                <input type="email" name="email" value="<?php echo $row['email']; ?>" id="demo-hor-2" class="form-control required">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-3 control-label" for="demo-hor-4">
                                            <?php echo translate('registered_address');?>
                                            </label>
                                            <div class="col-sm-6">
                                                <input type="text" name="address1" value="<?php echo ucwords($row['address1']); ?>" id="demo-hor-4" class="form-control address" onblur="set_cart_map('iio');">
                                            </div>
                                        </div>
                                        <!-- <div class="form-group">
                                            <label class="col-sm-3 control-label" for="demo-hor-4">
                                            <?php echo translate('address_line_2');?>
                                            </label>
                                            <div class="col-sm-6">
                                                <input type="text" name="address2" value="<?php echo ucwords($row['address2']); ?>" id="demo-hor-4" class="form-control address" onblur="set_cart_map('iio');">
                                            </div>
                                            </div> -->
                                        <div class="form-group">
                                            <label class="col-sm-3 control-label" for="demo-hor-4">
                                            <?php echo translate('suburb');?>
                                            </label>
                                            <div class="col-sm-6">
                                                <input type="text" name="city" value="<?php echo ucwords($row['city']); ?>" id="demo-hor-4" class="form-control address" onblur="set_cart_map('iio');">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-3 control-label" for="demo-hor-4">
                                            <?php echo translate('state');?>
                                            </label>
                                            <div class="col-sm-6">
                                                <input type="text" name="state" value="<?php echo ucwords($row['state']); ?>" id="demo-hor-4" class="form-control address" onblur="set_cart_map('iio');">
                                            </div>
                                        </div>
                                        <!--  <div class="form-group" style="display: none;">
                                            <label class="col-sm-3 control-label" for="demo-hor-4">
                                            <?php echo translate('country');?>
                                            </label>
                                            <div class="col-sm-6">
                                                <input type="text" name="country" value="<?php echo ucwords($row['country']); ?>" id="demo-hor-4" class="form-control address" onblur="set_cart_map('iio');">
                                            </div>
                                            </div> -->
                                        <div class="form-group">
                                            <label class="col-sm-3 control-label" for="demo-hor-4">
                                            <?php echo translate('postcode');?>
                                            </label>
                                            <div class="col-sm-6">
                                                <input type="text" name="zip" value="<?php echo $row['zip']; ?>" id="demo-hor-4" class="form-control address" onblur="set_cart_map('iio');">
                                            </div>
                                        </div>
                                        <section class="col-md-8" id="lnlat" style="display:none;">
                                            <label class="input">
                                            <i class="icon-append fa fa-home"></i>   
                                            <input id="langlat" type="text" placeholder="langitude - latitude" name="lat_lang" value="<?php echo $row['lat_lang']; ?>" class="form-control" readonly>
                                            </label>
                                        </section>
                                        <div class="form-group">
                                            <label class="col-sm-3 control-label" for="demo-hor-4"></label>
                                            <div class="col-sm-6">
                                                <div class="" id="maps" style="height:400px;" >
                                                    <div id="map-canvas" style="height:400px;"></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group btm_border">
                                            <h4 class="text-thin "><?php echo translate('add_brands'); ?></h4>
                                        </div>
                                          <div class="form-group">
                                                <div class="col-sm-3">
                                                    <input type="text" multiple name="brands1" placeholder="<?php echo translate('brand_name'); ?>"  class="form-control" >
                                                </div>
                                                <div class="col-sm-3">
                                                    <div class="col-sm-13">
                                                        <input type="file" name="brand_image1" id="demo-hor-inputpass0" class="form-control">
                                                        </span>
                                                    </div>
                                                </div>
                                                <div class="col-sm-3">
                                                    <?php
                                                        $categories = $this->db->get('category')->result_array();
                                                    ?>
                                                    <select name="category" class="form-control category_name1" multiple="multiple">
                                                    <?php
                                                        foreach ($categories as $cat) {
                                                            ?>  
                                                            <option value="<?php echo $cat['category_id'] ?>"><?php echo $cat['category_name'] ?></option>
                                                            <?php
                                                        }
                                                    ?>
                                                    </select>
                                                </div>
                                                <div class="col-sm-3">
                                                    <div class="btn btn-mint add_brand"><?php echo translate('Add Brands');?></div> 
                                                    <!-- <div id="more_btn" class="btn btn-mint btn-labeled fa fa-plus pull-right"><?php echo translate('add_more');?></div>  -->
                                                </div>
                                            </div>
                                        <div id="more_additional_fields"></div>
                                        <?php
                                        $vendor_brands = $this->db->get_where('vendorbrands',array('user_id' => $this->session->userdata('vendor_id')))->result_array();
                                       
                                        foreach($vendor_brands as $val)
                                        {
                                            ?>
                                            <div class="remove<?php echo $val['id']; ?>">
                                                <div class="form-group">
                                                    <div class="col-sm-3">
                                                        <input type="text" multiple name="brands" placeholder="<?php echo translate('brand_name'); ?>"  class="form-control brands_name<?php echo $val['id']; ?>" value="<?php echo $val['name']; ?>">
                                                    </div>
                                                    <div class="col-sm-3">
                                                        <div class="col-sm-13">
                                                            <input type="file" name="brand_image"  id="demo-hor-inputpass0" class="form-control brand_image<?php echo $val['id']; ?>">
                                                            <input type="hidden" name="last_brand_image" class="last_brand_image<?php echo $val['id']; ?>" value="<?php echo $val['image']; ?>">
                                                            </span>
                                                            <br><br>
                                                            <?php if($val['image']) { ?>
                                                             <div style='float:left;border:4px solid #303641;padding:5px;margin:5px;'><img height='80' src='<?php echo base_url('uploads/brand_image').'/'.$val['image']; ?>'></div>
                                                            <?php } ?>
                                                            <span class="previewbrandImg" ></span>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-3">
                                                        <?php
                                                            $categories = $this->db->get('category')->result_array();
                                                        ?>
                                                        <select name="category" class="form-control category_name<?php echo $val['id']; ?>" multiple="multiple">
                                                        <?php
                                                            foreach ($categories as $cat) {
                                                                ?>  
                                                                    <option <?php if(in_array($cat['category_id'],explode(",",$val['category']))) { echo "selected"; }  ?> value="<?php echo $cat['category_id'] ?>"><?php echo $cat['category_name'] ?></option>
                                                                <?php
                                                            }
                                                        ?>
                                                        </select>
                                                    </div>
                                                     <div class="col-sm-2">
                                                         <div brand_id="<?php echo $val['id']; ?>" class="btn btn-mint update_brand"><?php echo translate('update');?></div> 
                                                        <span class="remove_it_v rms btn btn-danger btn-icon btn-circle icon-lg fa fa-times" onclick="delete_added_row(<?php echo $val['id']; ?>)"></span>
                                                    </div>
                                                </div>
                                            </div>
                                         <?php
                                         }
                                         ?>  

                                    </div>
                                    <!-- End Manage Detail -->
                                    <!-- Start Account Details -->
                                    <div id="account_details" class="tab-pane fade">
                                        <div class="form-group btm_border">
                                            <h4 class="text-thin text-center"><?php echo translate('account_details'); ?></h4>
                                        </div>
                                        <div class="form-group btm_border">
                                            <label class="col-sm-3 control-label" for="demo-hor-55">
                                            <?php echo translate('bank_name');?>
                                            </label>
                                            <div class="col-sm-6">
                                                <input type="text" name="bank_name" placeholder="<?php echo translate('bank_name'); ?>" value="<?php echo ucwords($row['bank_name']); ?>" id="demo-hor-55" class="form-control">
                                            </div>
                                        </div>
                                        <div class="form-group btm_border">
                                            <label class="col-sm-3 control-label" for="demo-hor-56">
                                            <?php echo translate('account_name');?>
                                            </label>
                                            <div class="col-sm-6">
                                                <input type="text" name="account_name" placeholder="<?php echo translate('account_name'); ?>" value="<?php echo ucwords($row['account_name']); ?>" id="demo-hor-56" class="form-control ">
                                            </div>
                                        </div>
                                        <div class="form-group btm_border">
                                            <label class="col-sm-3 control-label" for="demo-hor-57">
                                            <?php echo translate('bank_account_number');?>
                                            </label>
                                            <div class="col-sm-6">
                                                <input type="text" name="bank_account_number" placeholder="<?php echo translate('bank_account_number'); ?>" value="<?php echo $row['bank_account_number']; ?>" id="demo-hor-57" class="form-control " onkeypress="isInputNumber(event)">
                                            </div>
                                        </div>
                                        <div class="form-group btm_border">
                                            <label class="col-sm-3 control-label" for="demo-hor-58">
                                            <?php echo translate('bsb_number');?>
                                            </label>
                                            <div class="col-sm-6">
                                                <input type="text" name="bsb_number"  placeholder="<?php echo translate('bsb_number'); ?>" value="<?php echo $row['bsb_number']; ?>" id="demo-hor-58" class="form-control " onkeypress="isInputNumber(event)">
                                            </div>
                                        </div>
                                        <!-- Additional Fields -->
                                        

                                    </div>
                                    <!-- End Account Details  -->
                                    <!-- Other details -->
                                    <div id="other_details" class="tab-pane fade">
                                        <div class="form-group btm_border">
                                            <h4 class="text-thin text-center"><?php echo translate('other_details'); ?></h4>
                                        </div>
                                        <div class="form-group btm_border">
                                            <label class="col-sm-3 control-label" >
                                            <?php echo translate('first_name');?>
                                            </label>
                                            <div class="col-sm-6">
                                                <input type="text" name="first_name" placeholder="<?php echo translate('first_name'); ?>" value="<?php echo ucwords($row['first_name']); ?>"  class="form-control ">
                                            </div>
                                        </div>
                                        <div class="form-group btm_border">
                                            <label class="col-sm-3 control-label" >
                                            <?php echo translate('last_name');?>
                                            </label>
                                            <div class="col-sm-6">
                                                <input type="text" name="last_name" placeholder="<?php echo translate('last_name'); ?>" value="<?php echo ucwords($row['last_name']); ?>"  class="form-control ">
                                            </div>
                                        </div>
                                        <div class="form-group btm_border">
                                            <label class="col-sm-3 control-label">
                                            <?php echo translate('direct_number');?>
                                            </label>
                                            <div class="col-sm-2">
                                                <div class="select-wrapper">
                                                    <select name="direct_code" class="form-control">
                                                        <option value="<?php echo $row['direct_code']; ?>"><?php echo "(+".$row['direct_code'].")"; ?></option>
                                                        <?php if($row['direct_code'] !="02"){ ?><option value="02">(+02)</option><?php } ?>
                                                        <?php if($row['direct_code'] !="03"){ ?><option value="03">(+03)</option><?php } ?>
                                                        <?php if($row['direct_code'] !="04"){ ?><option value="04">(+04)</option><?php } ?>
                                                        <?php if($row['direct_code'] !="07"){ ?><option value="07">(+07)</option><?php } ?>
                                                        <?php if($row['direct_code'] !="08"){ ?><option value="08">(+08)</option><?php } ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                                <input type="text" name="direct_number" placeholder="<?php echo translate('direct_number'); ?>" value="<?php echo $row['direct_number']; ?>"  class="form-control" onkeypress="isInputNumber(event)">
                                            </div>
                                        </div>
                                        <div class="form-group btm_border">
                                            <label class="col-sm-3 control-label">
                                            <?php echo translate('mobile_number');?>
                                            </label>
                                            <div class="col-sm-6">
                                                <input type="text" name="mobile_number" placeholder="<?php echo translate('mobile_number'); ?>" value="<?php echo $row['mobile_number']; ?>"  class="form-control" onkeypress="isInputNumber(event)">
                                            </div>
                                        </div>
                                        <div class="form-group btm_border">
                                            <label class="col-sm-3 control-label">
                                            <?php echo translate('direct_email');?>
                                            </label>
                                            <div class="col-sm-6">
                                                <input type="email" name="direct_email" placeholder="<?php echo translate('direct_email'); ?>" value="<?php echo $row['direct_email']; ?>"  class="form-control" >
                                            </div>
                                        </div>

                                     
                                        <div class="form-group btm_border">
                                            <label class="col-sm-3 control-label">
                                            <?php echo translate('minimum_wholesale_value_for_free_delivery_to_banksmeadow_NSW_2019');?>
                                            </label>
                                            <div class="col-sm-6 customform">
                                                <span> $ </span>
                                                <input type="text" name="minimum_tick" placeholder="<?php echo translate('minimum (_tick_boxes )'); ?>" value="<?php echo ucwords($row['minimum_tick']); ?>" <?php echo " $" ?> class="form-control">
                                            </div>
                                            
                                        </div>
                                        <div class="form-group btm_border">
                                            <label class="col-sm-3 control-label">
                                            <?php echo translate('minimum_mix_quantity_for_free_delivery_to_banksmeadow_NSW_2019');?>
                                            </label>
                                            <div class="col-sm-6">
                                                <input type="text" name="free_delivery" placeholder="<?php echo translate('minimum_mix_quantity_for_free_delivery_to_banksmeadow_NSW_2019'); ?>" value="<?php echo $row['free_delivery']; ?>"  class="form-control" onkeypress="isInputNumber(event)">
                                            </div>
                                        </div>
                                        <div class="form-group btm_border">
                                            <label class="col-sm-3 control-label" >
                                            <?php echo translate('delivery_fee_to_banksmeadow_NSW_2019_if_either_minimum_are_not_met');?>
                                            </label>
                                            <div class="col-sm-6 customform">
                                                <span> $ </span>
                                                <input type="text" name="delivery_fee" placeholder="<?php echo translate('delivery_fee_to_banksmeadow_NSW_2019_if_either_minimum_are_not_met'); ?>" $ value="<?php echo $row['delivery_fee']; ?>"  class="form-control " onkeypress="isInputNumber(event)">
                                            </div>
                                            
                                        </div>
                                        <div class="form-group btm_border">
                                            <label class="col-sm-3 control-label">
                                            <?php echo translate('company_desciption (_english )');?>
                                            </label>
                                            <div class="col-sm-6">
                                                <input type="text" name="c_d_english" placeholder="<?php echo translate('company_desciption (_english )'); ?>" value="<?php echo ucwords($row['c_d_english']); ?>"  class="form-control">
                                            </div>
                                        </div>
                                        <div class="form-group btm_border">
                                            <label class="col-sm-3 control-label">
                                            <?php echo translate('company_desciption (_simplified_chinese-_if_any )');?>
                                            </label>
                                            <div class="col-sm-6">
                                                <input type="text" name="c_d_chinese" placeholder="<?php echo translate('company_desciption(simplified_chinese-_if_any )'); ?>" value="<?php echo ucwords($row['c_d_chinese']); ?>"  class="form-control" >
                                            </div>
                                        </div>
                                        <div class="form-group btm_border">
                                            <label class="col-sm-3 control-label">
                                            <?php echo translate('company_desciption (_japanese-_if_any )');?>
                                            </label>
                                            <div class="col-sm-6">
                                                <input type="text" name="c_d_japanese" placeholder="<?php echo translate('company_desciption (_simplified_japanese-_if_any )'); ?>" value="<?php echo ucwords($row['c_d_japanese']); ?>"  class="form-control" >
                                            </div>
                                        </div>
                                    </div>
                                    <!-- other details_end -->

                                     <div id="agreement" class="tab-pane fade">
                                            <p><?php echo date('h:m:s m-d-Y',$row['create_timestamp']); ?> You Have accepted vendor agreement <input type="checkbox" checked="checked" disabled="disabled"></p>
                                            <a href="<?php echo base_url().'/uploads/WET_-_Bought_under_Quote.pdf'; ?>"  download ><u>WET bought under quote</u></a>
                                    </div>
                                    <!-- other details_end -->
                                    
                                </div>
                            </div>
                        </div>
                        <div class="panel-footer text-right">
                            <span class="btn btn-info submitter enterer" data-ing='<?php echo translate('updating..'); ?>' data-msg='<?php echo translate('profile_updated!'); ?>'>
                            <?php echo translate('update');?>
                            </span>
                        </div>
                        </form>
                        <br>
                        
                        <div  style="display: none;">
                            <div class="panel-heading">
                                <h3 class="panel-title"><?php echo translate('change_password');?></h3>
                            </div>
                            <?php
                                echo form_open(base_url() . 'vendor/manage_vendor/update_password/', array(
                                    'class' => 'form-horizontal',
                                    'method' => 'post'
                                ));
                                ?>
                            <div class="panel-body">
                                <div class="form-group">
                                    <label class="col-sm-3 control-label" for="demo-hor-5">
                                    <?php echo translate('current_password');?>
                                    </label>
                                    <div class="col-sm-6">
                                        <input type="password" name="password" value="" id="demo-hor-5" class="form-control required">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3 control-label" for="demo-hor-6">
                                    <?php echo translate('new_password*');?>
                                    </label>
                                    <div class="col-sm-6">
                                        <input type="password" name="password1" value="" id="demo-hor-6" class="form-control pass pass1 required">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3 control-label" for="demo-hor-7">
                                    <?php echo translate('confirm_password');?>
                                    </label>
                                    <div class="col-sm-6">
                                        <input type="password" name="password2" value="" id="demo-hor-7" class="form-control pass pass2 required">
                                    </div>
                                    <div id="pass_note">
                                    </div>
                                </div>
                            </div>
                            <div class="panel-footer text-right">
                                <span class="btn btn-info pass_chng disabled enterer" disabled='disabled' data-ing='<?php echo translate('updating..'); ?>' data-msg='<?php echo translate('password_updated!'); ?>'>
                                <?php echo translate('update_password');?>
                                </span>
                            </div>
                            </form>
                        </div>
                        <?php
                            }
                            ?>
                    </div>
                </div>
            </div>
            <!--Panel body-->
        </div>
    </div>
</div>
<!--  Vendors model -->
<div id="userModal" class="modal fade">
    <div class="modal-dialog">
        <form method="post" id="user_form">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>  
                    <h4 class="modal-title">Add User</h4>
                </div>
                <div class="modal-body">  
                    <label>Enter First Name</label>  
                    <input type="text" name="first_name" id="first_name" class="form-control" />  
                    <br />  
                    <label>Select User Image</label>  
                    <input type="file" name="user_image" id="user_image" />  
                    <span id="user_uploaded_image"></span>  
                </div>
                <div class="modal-footer">  
                    <input type="hidden" name="user_id" id="user_id" />  
                    <input type="submit" name="action" id="action" class="btn btn-success" value="Add" />  
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>  
                </div>
            </div>
        </form>
    </div>
</div>
<!--  End oF model -->
<script type="text/javascript">
    $(".pass").blur(function() {
        var pass1 = $(".pass1").val();
        var pass2 = $(".pass2").val();
        if (pass1 !== pass2) {
            $("#pass_note").html('' + '  <span class="require_alert" >' + '      <?php echo translate('password_mismatched'); ?>' + '  </span>');
            $(".pass_chng").attr("disabled", "disabled");
            $(".pass_chng").addClass("disabled");
        } else if (pass1 == pass2) {
            $("#pass_note").html('');
            $(".pass_chng").removeAttr("disabled");
            $(".pass_chng").removeClass("disabled");
        }
    });
    
    $('.pass_chng').on('click', function() {
    
        //alert('vdv');
        var here = $(this); // alert div for show alert message
        var form = here.closest('form');
        var can = '';
        var ing = here.data('ing');
        var msg = here.data('msg');
        var prv = here.html();
    
        //var form = $(this);
        var formdata = false;
        if (window.FormData) {
            formdata = new FormData(form[0]);
        }
    
        var a = 0;
        var take = '';
        form.find(".required").each(function() {
            var txt = '*<?php echo translate('required'); ?>';
            a++;
            if (a == 1) {
                take = 'scroll';
            }
            var here = $(this);
            if (here.val() == '') {
                if (!here.is('select')) {
                    here.css({
                        borderColor: 'red'
                    });
    
                    if (here.closest('div').find('.require_alert').length) {
    
                    } else {
                        sound('form_submit_problem');
                        here.closest('div').append('' + '  <span id="' + take + '" class="label label-danger require_alert" >' + '      ' + txt + '  </span>');
                    }
                }
                var topp = 100;
    
                $('html, body').animate({
                    scrollTop: $("#scroll").offset().top - topp
                }, 500);
                can = 'no';
            }
    
            take = '';
        });
    
        if (can !== 'no') {
            $.ajax({
                url: form.attr('action'), // form action url
                type: 'POST', // form submit method get/post
                dataType: 'html', // request type html/json/xml
                data: formdata ? formdata : form.serialize(), // serialize form data 
                cache: false,
                contentType: false,
                processData: false,
                beforeSend: function() {
                    here.html(ing); // change submit button text
                },
                success: function(data) {
                    here.fadeIn();
                    here.html(prv);
                    if (data == 'updated') {
                        $.activeitNoty({
                            type: 'success',
                            icon: 'fa fa-check',
                            message: msg,
                            container: 'floating',
                            timer: 3000
                        });
                    } else if (data == 'pass_prb') {
                        $.activeitNoty({
                            type: 'danger',
                            icon: 'fa fa-check',
                            message: '<?php echo translate('incorrect_password!'); ?>',
                            container: 'floating',
                            timer: 3000
                        });
                    }
                },
                error: function(e) {
                    console.log(e)
                }
            });
        } else {
            sound('form_submit_problem');
            return false;
        }
    });
    
    var base_url = '<?php echo base_url(); ?>';
    var user_type = 'vendor';
    var module = 'manage_admin';
    var list_cont_func = '';
    var dlt_cont_func = '';
    
</script>
<script>
    $(document).ready(function(){
        set_cart_map();
    });
    
    function set_cart_map(tty){
        //$('#maps').animate({ height: '400px' }, 'easeInOutCubic', function(){});
        initialize();
        var address = [];
        //$('#pos').show('fast');
        //$('#lnlat').show('fast');
        $('.address').each(function(index, value){
            if(this.value !== ''){
                address.push(this.value);
            }
        });
        address = address.toString();
        deleteMarkers();
        geocoder.geocode( { 'address': address}, function(results, status) {
            if (status == google.maps.GeocoderStatus.OK) {
                if($('#langlat').val().indexOf(',')  == -1 || $('#first').val() == 'no' || tty == 'iio'){
                    deleteMarkers();
                    var location = results[0].geometry.location; 
                    var marker = addMarker(location);
                    map.setCenter(location);
                    $('#langlat').val(location);
                } else if($('#langlat').val().indexOf(',')  >= 0){
                    deleteMarkers();
                    var loca = $('#langlat').val();
                    loca = loca.split(',');
                    var lat = loca[0].replace('(','');
                    var lon = loca[1].replace(')','');
                    var marker = addMarker(new google.maps.LatLng(lat, lon));
                    map.setCenter(new google.maps.LatLng(lat, lon));
                }
                if($('#first').val() == 'yes'){
                    $('#first').val('no');
                }
                // Add dragging event listeners.
                google.maps.event.addListener(marker, 'drag', function() {
                    $('#langlat').val(marker.getPosition());
                });
            }
        }); 
    }
    
        var geocoder;
        var map;
        var markers = [];
        function initialize() {
            geocoder = new google.maps.Geocoder();
            var latlng = new google.maps.LatLng(-34.397, 150.644);
            var mapOptions = {
                zoom: 14,
                center: latlng
            }
            map = new google.maps.Map(document.getElementById('map-canvas'), mapOptions);
            google.maps.event.addListener(map, 'click', function(event) {
                deleteMarkers();
                var marker = addMarker(event.latLng);
                $('#langlat').val(event.latLng);    
                // Add dragging event listeners.
                google.maps.event.addListener(marker, 'drag', function() {
                    $('#langlat').val(marker.getPosition());
                });
                
            });     
        }
        
    
    /*
        var address = [];
        $('#maps').show('fast');
        $('#pos').show('fast');
        $('#lnlat').show('fast');
        $(".address").each(
        address.push(this.value);
        );
    */
    
        $('.address').on('blur', function(){
    $('#langlat').val('');
            set_cart_map();
        });
    
        // Add a marker to the map and push to the array.
        function addMarker(location) {
            var image = {
                url: base_url+'uploads/others/marker.png',
                size: new google.maps.Size(40, 60),
                origin: new google.maps.Point(0,0),
                anchor: new google.maps.Point(20, 62)
            };
    
            var shape = {
                coords: [1, 5, 15, 62, 62, 62, 15 , 5, 1],
                type: 'poly'
            };
    
            var marker = new google.maps.Marker({
                position: location,
                map: map,
                draggable:true,
                icon: image,
                shape: shape,
                animation: google.maps.Animation.DROP
            });
            markers.push(marker);
            return marker;
        }
    
        // Deletes all markers in the array by removing references to them.
        function deleteMarkers() {
            clearMarkers();
            markers = [];
        }
    
        // Sets the map on all markers in the array.
        function setAllMap(map) {
            for (var i = 0; i < markers.length; i++) {
                markers[i].setMap(map);
            }
        }
    
        // Removes the markers from the map, but keeps them in the array.
        function clearMarkers() {
            setAllMap(null);
        }
        //google.maps.event.addDomListener(window, 'load', initialize);
</script>
<script type="text/javascript" language="javascript" >  
    /*var dataTable = $('#user_data').DataTable({  
     "processing":true,  
     "serverSide":true,  
     "order":[],  
     "ajax":{  
          url:"<?php echo base_url() . 'brand/fetch_Brand'; ?>",  
          type:"POST"  
     },  
     "columnDefs":[  
          {  
               "targets":[0, 3, 4],  
               "orderable":false,  
          },  
     ],  
     }); */
    
    
    
    
    
    
    
    
    $("#user_form").on( 'submit',function(event){  
     event.preventDefault();  
     var firstName = $('#vendor_name').val();  
    
     var extension = $('#vendor_image').val().split('.').pop().toLowerCase();  
     if(extension != '')  
     {  
          if(jQuery.inArray(extension, ['gif','png','jpg','jpeg']) == -1)  
          {  
               alert("Invalid Image File");  
               $('#vendor_image').val('');  
               return false;  
          }  
     }       
     if(firstName != '')  
     {  
    
          
    
          var formdata= new FormData(this);
          $.ajax({  
               url:"<?php echo base_url() . 'Brand/vendor_action'?>",  
               method:'POST',  
               data:formdata,  
               contentType:false,  
               processData:false,  
               success:function(data)  
               {  
                    alert(data);  
                    $('#user_form')[0].reset();  
                    
                   dataTable.ajax.reload();  
               }  ,
               error: function()
               {
                  alert("Try again");
               }
          });  
     }  
     else  
     {  
          alert("Both Fields are Required");  
     }  
    });  
    
    
    
    $(document).on('click', '.update', function(){  
     var user_id = $(this).attr("id");  
     $.ajax({  
          url:"<?php echo base_url(); ?>crud/fetch_single_user",  
          method:"POST",  
          data:{user_id:user_id},  
          dataType:"json",  
          success:function(data)  
          {  
               $('#userModal').modal('show');  
               $('#first_name').val(data.name);  
               $('.modal-title').text("Edit User");  
               $('#user_id').val(user_id);  
               $('#user_uploaded_image').html(data.image);  
               $('#action').val("Edit"); 
               window.location.reload(); 
          }  
     })  
    });  
    
</script>  
<script src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>  
<script src="https://cdn.datatables.net/1.10.12/js/dataTables.bootstrap.min.js"></script>            
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.12/css/dataTables.bootstrap.min.css" />
<script>
    function isInputNumber(evt){
        var ch = String.fromCharCode(evt.which);
        if(!(/[0-9]/.test(ch))){
            evt.preventDefault();
        }
    }
    
    window.previewcompany = function (input) 
    {
        if (input.files && input.files[0]) 
        {
            $("#previewcompanyImg").html('');
            $(input.files).each(function () 
            {
                var reader = new FileReader();
                reader.readAsDataURL(this);
                reader.onload = function (e) {
                    $("#previewcompanyImg").append("<div style='float:left;border:4px solid #303641;padding:5px;margin:5px;'><img height='80' src='" + e.target.result + "'></div>");
                }
            });
        }
    }

    var x=1;
    $("#more_btn").click(function()
    {
        x++;
        $("#more_additional_fields").append('<div class="remove'+x+'">'
            +'<div class="form-group">'
            +'    <div class="col-sm-3  ">'
            +'         <input type="text" name="brands'+x+'" placeholder="<?php echo translate('brand_name'); ?>"  class="form-control ">'
            +'    </div>'
            +'    <div class="col-sm-3">'
            +'        <input type="file" name="brand_image'+x+'" class="form-control">'
            +'    </div>'
            +'    <div class="col-sm-3">'
            +'        <select  class="form-control category_name'+x+'"  multiple="multiple">  <?php  foreach ($categories as $cat) { ?> <option value="<?php echo $cat['category_id'] ?>"><?php echo $cat['category_name'] ?></option>  <?php } ?></select>'
            +'    </div>'

            +'    <div class="col-sm-2">'
            +'        <span class="remove_it_v rms btn btn-danger btn-icon btn-circle icon-lg fa fa-times" onclick="delete_row('+x+')"></span>'
            +'    </div>'
            +'</div>'
            +'</div>'
        );        
    });
    function delete_row(x)
    {
        $('.remove'+x).empty();
    }
    function delete_added_row(brand_id)
    {
            msg = 'Really want to delete this brand?'; 
            bootbox.confirm(msg, function(result) {
            if (result) 
            { 
                $.ajax({ 
                        url: base_url+''+user_type+'/manage_vendor/dlt_brands/'+brand_id, 
                        cache: false, 
                        success: function(data) { 
                            $('.remove'+brand_id).empty();
                            $.activeitNoty({ 
                                type: 'success', 
                                icon : 'fa fa-check', 
                                message : 'Deleted Successfully', 
                                container : 'floating', 
                                timer : 3000 
                            }); 
                            setTimeout(function(){ window.location.reload(); }, 3000); 
                        } 
                    });
            }
            else
            {
                $.activeitNoty({ 
                    type: 'danger', 
                    icon : 'fa fa-minus', 
                    message : 'Cancelled', 
                    container : 'floating', 
                    timer : 3000 
                }); 
            }
        });             
    }
    $('.update_brand').click(function()
    {
        var here = $(this);
        var brand_id = here.attr('brand_id');
        var name = $('.brands_name'+brand_id).val();
        var last_brand_image = $('.last_brand_image'+brand_id).val();
        var selected=[];
        $('.category_name'+brand_id+' :selected').each(function()
        {
            if($(this).val()  > 0)
            {
                selected.push($(this).val());
            }
        });

        var files = $('.brand_image'+brand_id)[0].files[0];
        
        var fd = new FormData();
        fd.append('brand_id',brand_id);
        fd.append('name',name);
        fd.append('category',selected);
        fd.append('brand_image',files);
        fd.append('last_brand_image',last_brand_image);

        $.ajax({ 
            url: base_url+user_type+'/manage_vendor/update_brand/', 
            data : fd,
            method : 'post',
            contentType: false,
            processData: false,
            success: function(data)
            { 
                $.activeitNoty({ 
                    type: 'success', 
                    icon : 'fa fa-check', 
                    message : 'Brand update Successfully', 
                    container : 'floating', 
                    timer : 3000 
                });
                setTimeout(function(){ window.location.reload(); }, 3000);
 
            } 
        }); 
           

    });
    $('.add_brand').click(function()
    {
        var here = $(this);
        var total_brands = x;
        var name = [];    
        var category = [];
        for(var i = 1; i <= total_brands; i++) 
        {
            name.push($('input[name="brands'+i+'"]').val());
            var selected=[];
            $('.category_name'+i+' :selected').each(function()
            {
                if($(this).val()  > 0)
                {
                    selected.push($(this).val());
                }
            });
            var selected_obj = {selected};
            category.push(selected_obj);
            selected=[];

            /*images.push($('input[name="brand_image'+i+'"]')[0].files[0]);*/
        }
        /*console.log(images);*/
        var fd = new FormData();
        fd.append('brands',name);
        fd.append('category',JSON.stringify(category));
        for (var y = 1; y <= name.length; y++) 
        {
            fd.append('brand_images'+y,$('input[name="brand_image'+y+'"]')[0].files[0]);
        }   

        $.ajax({ 
            url: base_url+user_type+'/manage_vendor/add_brand/', 
            data : fd,
            method : 'post',
            contentType: false,
            processData: false,
            success: function(data)
            { 
                $.activeitNoty({ 
                    type: 'success', 
                    icon : 'fa fa-check', 
                    message : 'Brand add Successfully', 
                    container : 'floating', 
                    timer : 3000 
                });
                setTimeout(function(){ window.location.reload(); }, 2000);
            } 
        }); 
    });
    $('.delete-div-wrap .delete-events-img').on('click', function() { 
        var pid = $(this).closest('.delete-div-wrap').find('img').data('id'); 
        var here = $(this); 
        msg = 'Really want to delete this Image?'; 
        bootbox.confirm(msg, function(result) {
            if (result) { 
                 $.ajax({ 
                    url: base_url+''+user_type+'/'+module+'/dlt_img/'+pid, 
                    cache: false, 
                    success: function(data) { 
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

    $('.delete-div-wrap .close').on('click', function() { 
        var pid = $(this).closest('.delete-div-wrap').find('img').data('id'); 
        var here = $(this); 
        msg = 'Really want to delete this Image?'; 
        bootbox.confirm(msg, function(result) {
            if (result) { 
                 $.ajax({ 
                    url: base_url+''+user_type+'/'+module+'/dlt_img/'+pid, 
                    cache: false, 
                    success: function(data) { 
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

</script>
<style type="text/css">
    .customform span{
         position: absolute;top: 7px;left: 28px;color: grey;font-weight: bold;
    }

    .customform .form-control{
        padding-left: 26px;
        padding-top: 3px;
    }
</style>