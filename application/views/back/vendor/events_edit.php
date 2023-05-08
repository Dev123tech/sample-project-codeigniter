<?php
    foreach($events_data as $row){
    ?>
<div class="row">
<div class="col-md-12">
    <?php
        echo form_open(base_url() . 'vendor/events/update/' . $row['events_id'], array(
            'class' => 'form-horizontal',
            'method' => 'post',
            'id' => 'events_edit',
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
            <!--Tabs Content-->                    
            <div class="tab-content">
                <div id="product_details" class="tab-pane fade active in">
                    <div class="form-group btm_border">
                        <label class="col-sm-4 control-label" for="demo-hor-1"><?php echo translate('presenter_name');?></label>
                        <div class="col-sm-6">
                            <input type="text" name="presenter_name" id="demo-hor-1" value="<?php echo $row['presenter_name']; ?>" placeholder="<?php echo translate('presenter_name');?>" class="form-control required" <?php if($row['status']=="approved"){ echo "readonly"; } ?>>
                        </div>
                    </div>
                    <div class="form-group btm_border">
                        <label class="col-sm-4 control-label" for="demo-hor-12"><?php echo translate('Presenter_images');?></label>
                        <div class="col-sm-6">
                            <span class="pull-left btn btn-default btn-file"> <?php echo translate('choose_file');?>
                            <?php if($row['status'] !="approved"){ ?>
                            <input type="file" multiple name="images[]" onchange="preview(this);" id="demo-hor-inputpass" class="form-control">
                            <?php } ?>    
                            <input type="hidden"  name="last_images" value="<?php echo $row['image']; ?>">
                            </span>
                            <br><br>
                            <span id="previewImg" ></span>
                        </div>
                    </div>
                    <div class="form-group btm_border">
                        <label class="col-sm-4 control-label" for="demo-hor-13"></label>
                        <div class="col-sm-6">
                            <?php 
                                $images = explode(",",$row['image']);
                                if($images){
                                    foreach ($images as $row1){
                                ?>
                            <?php if($row['status'] !="approved"){ ?>
                            <div class="delete-div-wrap">
                                <span class="close" >&times;</span>
                                <?php } ?>    
                                <div class="inner-div">
                                    <img class="img-responsive" width="100" src="<?php echo base_url(); ?>uploads/events_image/<?php echo $row1; ?> "alt="User_Image" <?php if($row['status']=="approved"){ echo "readonly"; } ?>>
                                </div>
                            </div>
                            <?php 
                                }
                                } 
                                ?>
                        </div>
                    </div>
                    <div class="form-group btm_border">
                        <label class="col-sm-4 control-label" for="demo-hor-8"><?php echo translate('presenter_title');?></label>
                        <div class="col-sm-6">
                            <input type="text" name="presenter_title" id="demo-hor-8" value="<?php echo $row['presenter_title']; ?>" placeholder="<?php echo translate('presenter_title');?>" class="form-control required" <?php if($row['status']=="approved"){ echo "readonly"; } ?>>
                        </div>
                    </div>
                    <div class="form-group btm_border">
                        <label class="col-sm-4 control-label" for="demo-hor-1"><?php echo translate('presenter_bio');?></label>
                        <div class="col-sm-6">
                            <textarea type="text" name="presenter_bio" id="demo-hor-3" maxlength="250" placeholder="<?php echo translate('presenter_bio');?>" class="form-control required" <?php if($row['status']=="approved"){ echo "readonly"; } ?>> <?php echo $row['presenter_bio']; ?>  </textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-4 control-label"><?php echo translate('product');?></label>
                        <div class="col-sm-6">
                            <select data-placeholder="<?php echo translate('choose_product');?>" name='choose_product[]' class="form-control chosen-select" multiple tabindex="2" <?php if($row['status']=="approved"){ echo "disabled"; } ?>>
                                <?php
                                    $product_arr = explode(",", $row['choose_product']);
                                        $products = $this->db->get_where('product',array('added_by'=>json_encode(array('type'=>'vendor','id'=>$this->session->userdata('vendor_id')))))->result_array();
                                        foreach ($products as $rows) {
                                            if($this->crud_model->is_publishable($rows['product_id'])){
                                    ?>
                                <option value="<?php echo $rows['product_id']; ?>"
                                    <?php $product_arr = explode(",", $row['choose_product']);
                                        foreach ($product_arr as $value) 
                                        {   
                                          echo  $product[] = $this->db->get_where('product',array('product_id'=>$value))->row()->product_id;
                                        }  
                                        ?> 
                                    <?php if (in_array($rows['product_id'], $product)) {
                                        echo 'selected="selected"';
                                        } ?>
                                    > <?php echo $rows['title']; ?>
                                </option>
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
                        <select  <?php if($row['status']=="approved"){ echo "readonly"; } ?> name='promocode_id' class="form-control promocode_details">
                                <option value="">Select...</option>
                            <?php
                                $promocodes = $this->db->get_where('promocode',array('status'=>'ok'))->result_array();
                                foreach ($promocodes as $rows) 
                                {
                                    $promo_data = json_decode($rows['spec']);
                                    if($promo_data->discount_type=='percent')
                                    {
                                        $discount_value = $promo_data->discount_value.'%';
                                    }
                                    else
                                    {
                                        $discount_value = currency($promo_data->discount_value);
                                    }
                                    ?>
                                    <option <?php if($rows['promocode_id']==$row['promocode_id']) { echo "selected"; } ?>  value="<?php echo $rows['promocode_id']; ?>"><?php echo $rows['code']."-".$discount_value; ?></option>
                                    <?php
                                }
                                ?>
                        </select>
                        <span class="show_promocode"></span>
                    </div>
                </div>

                <div class="form-group" <?php if($row['status'] =="approved"){ echo "style='pointer-events:none;'";  } ?>>
                    <label class="col-sm-4 control-label"><?php echo translate('promocode_product');?></label>
                    <div class="col-sm-6">
                        <ul id="promocode_products" class="list-group" style="display: none;"></ul>
                    </div>
                </div>
                    <!-- Add Banner Image -->
                    <div class="form-group btm_border">
                        <label class="col-sm-4 control-label" for="demo-hor-12"><?php echo translate('Banner images');?></label>
                        <div class="col-sm-6">
                            <span class="pull-left btn btn-default btn-file"> <?php echo translate('choose_file');?>
                            <?php if($row['status'] !="approved"){ ?>
                            <input type="file" multiple name="banner_images[]" onchange="previewbannerImg(this);" id="demo-hor-inputpass" class="form-control" <?php if($row['status']=="approved"){ echo "readonly"; } ?>>
                            <?php } ?>    
                            <input type="hidden"  name="banner_last_images" value="<?php echo $row['banner_image']; ?>">
                            </span>
                            <br><br>
                            <span id="previewbannerImg" ></span>
                        </div>
                    </div>
                    <div class="form-group btm_border">
                        <label class="col-sm-4 control-label" for="demo-hor-13"></label>
                        <div class="col-sm-6">
                            <?php 
                                $banner_image = $row['banner_image']; 
                                $bannerimages = explode(",",$banner_image);
                                if($bannerimages){
                                    foreach ($bannerimages as $banner_row){
                                ?>  
                            <div class="delete-div-wrap">
                                <?php if($row['status'] !="approved"){ ?>    
                                <span class="close">&times;</span>
                                <?php } ?>    
                                <div class="inner-div">
                                    <img class="img-responsive" width="100" src="<?php echo base_url(); ?>uploads/events_image/<?php echo $banner_row; ?> "alt="User_Image" <?php if($row['status']=="approved"){ echo "readonly"; } ?>>
                                </div>
                            </div>
                            <?php 
                                }
                                } 
                                ?>
                        </div>
                    </div>
                    <!-- End banner Image -->
                    <!-- Start Date and time start/end    -->
                    <div class="form-group btm_border">
                        <label class="col-sm-4 control-label" for="date"><?php echo translate('date');?></label>
                        <div class="col-sm-2">
                            <input type="date" name='date' id="datepicker" value="<?php echo $row['date']; ?>" class="form-control required"
                                <?php if($row['status']=="approved"){ echo "readonly"; } ?> >
                            <span class="dob_error"></span>
                        </div>
                    </div>
                    <div class="form-group btm_border">
                        <label class="col-sm-4 control-label" for="date"><?php echo translate('date');?></label>
                        <div class="col-sm-4">
                            <select name="time_slot" class="form-control ">
                                <option value="">Select...</option>
                                <?php
                                    $result = $this->db->get_where('event_time_slot')->row();
                                    $time_slot1 = json_decode($result->slot_1);
                                    $time_slot2 = json_decode($result->slot_2);
                                    $time_slot3 = json_decode($result->slot_3);
                                ?>    
                                <option <?php if($row['time_slot']=='slot_1') { echo "selected"; } ?> value="slot_1"><?php echo 'From '.$time_slot1->start_time.' To '.$time_slot1->end_time; ?></option>
                                <option <?php if($row['time_slot']=='slot_2') { echo "selected"; } ?> value="slot_2"><?php echo 'From '.$time_slot2->start_time.' To '.$time_slot2->end_time; ?></option>
                                <option <?php if($row['time_slot']=='slot_3') { echo "selected"; } ?> value="slot_3"><?php echo 'From '.$time_slot3->start_time.' To '.$time_slot3->end_time; ?></option>
                            </select>
                        </div>    
                    </div>
                </div>
            </div>
        </div>
        <div class="panel-footer">
            <div class="row">
                <div class="col-md-11">
                    <span class="btn btn-success btn-md btn-labeled fa fa-wrench pull-right enterer" id="submit-button" onclick="form_submit('events_edit','<?php echo translate('successfully_edited!'); ?>');proceed('to_add');" ><?php echo translate('edit');?></span> 
                </div>
            </div>
        </div>
        </form>
    </div>
</div>

<script type="text/javascript">
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
    
    window.previewbannerImg = function (input) {
        if (input.files && input.files[0]) {
            $("#previewbannerImg").html('');
            $(input.files).each(function () {
                var reader = new FileReader();
                reader.readAsDataURL(this);
                reader.onload = function (e) {
                    $("#previewbannerImg").append("<div style='float:left;border:4px solid #303641;padding:5px;margin:5px;'><img height='80' src='" + e.target.result + "'></div>");
                }
            });
        }
    }
    
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
    function delete_row(e)
    {
        e.parentNode.parentNode.parentNode.removeChild(e.parentNode.parentNode);
    }    
    $(document).ready(function() 
    {
        $("form").submit(function(e)
        {
            event.preventDefault();
        });
    });
</script>
<script type="text/javascript">
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
    var $chosen = $('.chosen-select').chosen({max_selected_options: 10 });
    
    $chosen.change(function () 
    {
        var $this = $(this);
        var chosen = $this.data('chosen');
        var search = chosen.search_container.find('input[type="text"]');
        var deptid = $this.val();
        selected_promocode(deptid);
        search.prop('disabled', $this.val() !== null);
        
        if (chosen.active_field) 
        {
            search.focus();
        }
    });
    var deptid =<?php echo json_encode(explode(",",$row['choose_product']))  ?>;
    selected_promocode(deptid);
    function selected_promocode(deptid)
    {
        var selected_pro = <?php echo json_encode(explode(",",$row['promocode_products'])) ?>;
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
                    
                    if(selected_pro.includes(id))
                    {
                        $("#promocode_products").append("<li  class='list-group-item'><label><input type='checkbox' checked name='promocode_products[]' value='"+id+"'> "+ name+"</label></li>");
                    }
                    else
                    {
                        $("#promocode_products").append("<li class='list-group-item'><label><input type='checkbox' name='promocode_products[]' value='"+id+"'> "+ name+"</label></li>");
                    }
                }
            }
        });
    }
    $('.promocode_details').change(function()
    {
        var promocode_id = $(this).val();
        promocode_detail(promocode_id);
    });
    var promocode_id = "<?php echo $row['promocode_id'] ?>";
    promocode_detail(promocode_id);
    function promocode_detail(promocode_id)
    {
        $.ajax({
            url: base_url+'vendor/events/promocode_details',
            type: 'post',
            data: {promocodeid:promocode_id},
            dataType: 'json',
            success:function(response)
            {
                if(response)
                {
                    $("#promocode_products").show();
                    var discount = JSON.parse(response.spec);
                    var str = response.title;
                    str = str.toLowerCase().replace(/\b[a-z]/g, function(letter) {
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
    }
</script>
<?php
    }
    ?>