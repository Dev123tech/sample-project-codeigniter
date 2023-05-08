
<style type="text/css">
   .select2-selection--multiple .select2-search--inline .select2-search__field {
width: auto !important;
}
</style>
<div class="row">
    <div class="col-md-12">
        <?php
            echo form_open(base_url() . 'vendor/events/do_add/', array(
                'class' => 'form-horizontal',
                'method' => 'post',
                'id' => 'add_events',
                'enctype' => 'multipart/form-data'
            ));
            ?>
        <!--Panel heading-->
        <div class="panel-heading">
            <div class="panel-control" style="float: left;">
                <ul class="nav nav-tabs">
                    <li class="active">
                        <a data-toggle="tab" href="#product_details"><?php echo translate('event_details'); ?></a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="panel-body">
            <div class="tab-base">
                <div class="form-group">
                    <h4 class="text-thin text-center"><?php echo translate('events_details'); ?></h4>
                </div>
                <div class="form-group">
                    <label class="col-sm-4 control-label" for="demo-hor-1"><?php echo translate('presenter_name');?></label>
                    <div class="col-sm-6">
                        <input type="text" name="presenter_name" id="demo-hor-1" placeholder="<?php echo translate('presenter_name');?>" class="form-control required">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-4 control-label" for="demo-hor-12"><?php echo translate('Presenter_images');?></label>
                    <div class="col-sm-6">
                        <span class="pull-left btn btn-default btn-file"> <?php echo translate('choose_file');?>
                        <input type="file" multiple name="images[]" onchange="preview(this);" id="demo-hor-inputpass0" class="form-control required">
                        </span>
                        <br><br>
                        <span id="previewImg" ></span>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-4 control-label" for="demo-hor-8"><?php echo translate('presenter_title');?></label>
                    <div class="col-sm-6">
                        <input type="text" name="presenter_title" id="demo-hor-8" placeholder="<?php echo translate('presenter_title');?>" class="form-control required">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-4 control-label" for="demo-hor-2"><?php echo translate('presenter_bio');?></label>
                    <div class="col-sm-6">
                        <textarea rows="3"  name="presenter_bio" id="demo-hor-3" maxlength="250" placeholder="<?php echo translate('presenter_bio');?>" class="form-control required"></textarea>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-4 control-label"><?php echo translate('Choose one or multiple products to promote');?></label>
                    <div class="col-sm-6">
                        <select data-placeholder="<?php echo translate('Choose...');?>" name='choose_product[]' class="form-control chosen-select required" multiple tabindex="2" >
                            <?php
                                $products = $this->db->get_where('product',array('added_by'=>json_encode(array('type'=>'vendor','id'=>$this->session->userdata('vendor_id')))))->result_array();
                                foreach ($products as $row) 
                                {
                                    if($this->crud_model->is_publishable($row['product_id'])){
                                ?>
                            <option value="<?php echo $row['product_id']; ?>"><?php echo $row['title']; ?></option>
                            <?php
                                }
                                }
                                ?>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-4 control-label"><?php echo translate('promocode');?></label>
                    <div class="col-sm-6">
                        <select  name='promocode_id' class="form-control promocode_details">
                                <option value="">Select...</option>
                            <?php
                                $promocodes = $this->db->get_where('promocode',array('status'=>'ok'))->result_array();
                                foreach ($promocodes as $row) 
                                {
                                    $promo_data = json_decode($row['spec']);
                                    if($promo_data->discount_type=='percent')
                                    {
                                        $discount_value = $promo_data->discount_value.'%';
                                    }
                                    else
                                    {
                                        $discount_value = currency($promo_data->discount_value);
                                    }
                                    ?>
                                        <option value="<?php echo $row['promocode_id']; ?>"><?php echo $row['code']."-".$discount_value; ?></option>
                                    <?php
                                }
                                ?>
                        </select>
                        <span class="show_promocode"></span>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-4 control-label"><?php echo translate('promocode_product');?></label>
                    <div class="col-sm-6">
                        <ul id="promocode_products" class="list-group" style="display: none;"></ul>
                    </div>
                </div>
                <!-- Add Banner_image -->
                <div class="form-group">
                    <label class="col-sm-4 control-label" for="demo-hor-13"><?php echo translate('Banner images');?></label>
                    <div class="col-sm-6">
                        <span class="pull-left btn btn-default btn-file"> <?php echo translate('choose_file');?>
                        <input type="file" multiple name="banner_images[]" onchange="previewbanner(this);" id="demo-hor-inputpass" class="form-control required">
                        </span>
                        <br><br>
                        <span id="previewbannerImg" ></span>
                    </div>
                </div>
                <!-- banner_image end -->
                <!-- Start Date and time start/end-->
                <div class="form-group">
                    <label class="col-sm-4 control-label" for="date"><?php echo translate('date');?></label>
                    <div class="col-sm-2">
                        <input type="date" name='date' id="datepicker" class="form-control required">
                        <span class="dob_error"></span>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-4 control-label"><?php echo 'Slot';?></label>
                    <div class="col-sm-6">
                        <div class="input-group">
                            <select name="time_slot" class="form-control required">
                                <option value="">Select...</option>
                                <?php
                                    $result = $this->db->get_where('event_time_slot')->row();
                                    $time_slot1 = json_decode($result->slot_1);
                                    $time_slot2 = json_decode($result->slot_2);
                                    $time_slot3 = json_decode($result->slot_3);
                                ?>    
                                <option value="slot_1"><?php echo 'From '.$time_slot1->start_time.' To '.$time_slot1->end_time; ?></option>
                                <option value="slot_2"><?php echo 'From '.$time_slot2->start_time.' To '.$time_slot2->end_time; ?></option>
                                <option value="slot_3"><?php echo 'From '.$time_slot3->start_time.' To '.$time_slot3->end_time; ?></option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="panel-footer">
            <div class="row">
                <div class="col-md-10">
                    <span class="btn btn-purple btn-labeled fa fa-refresh pro_list_btn pull-right" 
                        onclick="ajax_set_full('add','<?php echo translate('add_product'); ?>','<?php echo translate('successfully_added!'); ?>','add_events',''); "><?php echo translate('reset');?>
                    </span>
                </div>
                <div class="col-md-2">
                    <span class="btn btn-success btn-md btn-labeled fa fa-upload pull-right enterer" id="submit-button"    onclick="form_submit('add_events','<?php echo translate('product_has_been_uploaded!'); ?>');proceed('to_add');" ><?php echo translate('submit');?></span>
                </div>
            </div>
        </div>
        </form>
    </div>
</div>
<script>
    window.preview = function (input) 
    {
        if (input.files && input.files[0]) 
        {
            $("#previewImg").html('');
            $(input.files).each(function () 
            {
                var reader = new FileReader();
                reader.readAsDataURL(this);
                reader.onload = function (e) {
                    $("#previewImg").append("<div style='float:left;border:4px solid #303641;padding:5px;margin:5px;'><img height='80' src='" + e.target.result + "'></div>");
                }
            });
        }
    }
    window.previewbanner = function (input) 
    {
        if (input.files && input.files[0]) 
        {
            $("#previewbannerImg").html('');
            $(input.files).each(function () 
            {
                var reader = new FileReader();
                reader.readAsDataURL(this);
                reader.onload = function (e) 
                {
                    $("#previewbannerImg").append("<div style='float:left;border:4px solid #303641;padding:5px;margin:5px;'><img height='80' src='" + e.target.result + "'></div>");
                }
            });
        }
    }
    $(document).ready(function() 
    {
        $("form").submit(function(e)
        {
            event.preventDefault();
        });
    });
    jQuery(document).ready(function() 
    {
        $("#txtEndTime").on("change",function()
        { 
            var strStartTime = document.getElementById("txtStartTime").value;
            var strEndTime = document.getElementById("txtEndTime").value;
            if (strEndTime > strStartTime) {
                $('.end_error').html(" ").css('color','green');
                $('#submit-button').removeAttr('disabled');
                
            } else{
                $('.end_error').html("The end time must be after the start time").css('color','red');
                $('#submit-button').attr('disabled', 'disabled');
                
            }
        });  
        $("#txtStartTime").on("change",function()
        { 
            var strStartTime = document.getElementById("txtStartTime").value;
            var strEndTime = document.getElementById("txtEndTime").value;
            if (strEndTime < strStartTime) {
                if(strEndTime){
                    $('.start_error').html("The start time must be before the end time").css('color','red');
                     $('#submit-button').attr('disabled', 'disabled');
                }else{
                    $('.start_error').html(" ").css('color','green');
                    $('#submit-button').removeAttr('disabled');
                }
               
            } else{
                 $('.start_error').html(" ").css('color','green');
                 $('#submit-button').removeAttr('disabled');
            }
        }); 
    
        $("#datepicker").on("change",function()
        {
            var getdates = document.getElementById("datepicker").value;
            
            var date = new Date();
            var newdate = new Date(date);
    
            newdate.setDate(newdate.getDate() + 14);
            
            var dd = newdate.getDate();
            var mm = newdate.getMonth() + 1;
            var y = newdate.getFullYear();
    
            var eventdate = y + '-' + mm + '-' + dd;
    
            // console.log('get',getdates);
            // console.log('event',eventdate);
            
            
            if (eventdate > getdates) 
            {
                $('.dob_error').html("Earliest date to book is 2 wks from today ").css('color','red');
                $('#submit-button').attr('disabled', 'disabled');
            }
            else
            {
                console.log(eventdate);
                $('.dob_error').html(" ");
                $('#submit-button').removeAttr('disabled');
            }
        }); 
    
    });    
    var $chosen = $('.chosen-select').chosen({
        max_selected_options: 10,
        width: '100%'
    });
    $('select').chosen({width: '100%'});
    
    $chosen.change(function () 
    {
        var $this = $(this);
        var chosen = $this.data('chosen');
        var deptid = $this.val();
        $.ajax({
            url: base_url+'vendor/events/choose_products',
            type: 'post',
            data: {depart:deptid},
            dataType: 'json',
            success:function(response)
            {
                var len = response.length;
                $("#promocode_products").empty();
                for( var i = 0; i<len; i++)
                {
                    var id = response[i]['id'];
                    var name = response[i]['name'];
                    
                    $("#promocode_products").append("<li class='list-group-item'><label><input type='checkbox' name='promocode_products[]' value='"+id+"'> "+ name+"</label></li>");

                }
            }
        });
        var search = chosen.search_container.find('input[type="text"]');
      
        search.prop('disabled', $this.val() !== null);
      
        if (chosen.active_field) 
        {
            search.focus();
        }
    });
    $('.promocode_details').change(function()
    {
        $.ajax({
            url: base_url+'vendor/events/promocode_details',
            type: 'post',
            data: {promocodeid:$(this).val()},
            dataType: 'json',
            success:function(response)
            {
                if(response)
                {
                    $("#promocode_products").show();
                    var discount = JSON.parse(response.spec);
                    var str = response.title;
                    str = str.toLowerCase().replace(/\b[a-z]/g, function(letter) 
                    {
                        return letter.toUpperCase();
                    });
                    if(discount.discount_type=='percent')
                    {
                        var discount_value = discount.discount_value+'%';
                    }
                    if(discount.discount_type=='amount')
                    {
                        var discount_value = "$"+discount.discount_value;
                    }
                    $('.show_promocode').html('<br>Date : '+response.till+'<br>Discount : '+discount_value);
                }
                else
                {
                    $('.show_promocode').html(" ");
                    $("#promocode_products").hide();
                }       
            }
        });
    });
</script>
<!--Bootstrap Tags Input [ OPTIONAL ]-->