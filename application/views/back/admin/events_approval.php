<style type="text/css">
  .contentwidth{
          width: 584px !important;
    }
</style>
<div>
    <?php
        echo form_open(base_url() . 'admin/events/approval_set/'.$events_id, array(
            'class' => 'form-horizontal',
            'method' => 'post',
            'id' => 'events_approval',
            'enctype' => 'multipart/form-data'
        ));
    ?>
        <div class="panel-body">
        
            <div class="form-group">
                <label class="col-sm-2 control-label" for="demo-hor-1"> </label>
                <div class="col-sm-2">
                    <h4><?php echo translate('postpond'); ?></h4>
                </div>
                <div class="col-sm-4 text-center">
                    <label class="switch">
                        <input id="pub_<?php echo $events_data->events_id; ?>"  data-size="switchery-lg" class='sw1 form-control' name="approval" type="checkbox" value="ok" data-id='<?php echo $events_data->events_id; ?>' <?php if($status == 'approved'){ ?>checked<?php } ?>>
                        <span class="slider round"></span>
                    </label>
                </div>
                <div class="col-sm-2">
                    <h4><?php echo translate('approved'); ?></h4>
                </div>
            </div>
            
            <!-- Youtube Id and Passsword -->
            <div class="form-group btm_border">
                <label class="col-sm-4 control-label" for="demo-hor-11"><?php echo translate('youtube_id*');?></label>
                <div class="col-sm-6">
                    <input type="text" name="youtube_id" value="<?php echo $events_data->youtube_id; ?>" placeholder="<?php echo translate('youtube_id');?>" class="form-control required" >
                </div>
            </div>
            <div class="form-group btm_border">
                <label class="col-sm-4 control-label" for="demo-hor-11"><?php echo translate('youtube_password*');?></label>
                <div class="col-sm-6">
                    <input type="password" name="youtube_password" value="<?php echo $events_data->youtube_password; ?>" placeholder="<?php echo translate('youtube_password');?>" class="form-control required" >
                </div>
            </div>

            <!-- End Youtube id and password -->

            <div class="form-group btm_border">
                <label class="col-sm-4 control-label" for="demo-hor-11"><?php echo translate('video_link*');?></label>
                <div class="col-sm-6">
                    <input type="text" name="video_link" value="<?php echo $events_data->video_link; ?>" placeholder="<?php echo translate('video_id_only');?>" class="form-control required" >
                </div>
            </div>

                            
            <div class="form-group btm_border">
                <label class="col-sm-4 control-label" for="demo-hor-12"><?php echo translate('Banner images');?></label>
                <div class="col-sm-6">
                    <span class="pull-left btn btn-default btn-file"> <?php echo translate('choose_file');?>
                        <input type="file" multiple name="images[]" onchange="preview(this);" id="demo-hor-inputpass" class="form-control <?php if($events_data->banner_image<0){ echo "required";}?>">
                        <input type="hidden"  name="last_images" value="<?php echo $events_data->banner_image; ?>" >
                    </span>
                    <br><br>
                    <span id="previewImg" ></span>
                </div>
            </div>
            <div class="form-group btm_border">
                <label class="col-sm-4 control-label" for="demo-hor-13"></label>
                <div class="col-sm-6">
                    <?php 
                        $images = explode(",",$events_data->banner_image);
                        // print_r($images);
                        if($images){
                            foreach ($images as $row1){
                    ?>  <div class="delete-div-wrap">
                            <span class="closenew_approve">&times;</span>
                            <div class="inner-div">
                                <img class="img-responsive" width="100" src="<?php echo base_url(); ?>uploads/events_image/<?php echo $row1; ?> "alt="User_Image" >
                            </div>
                       </div>     
                        
                    <?php 
                            }
                        } 
                    ?>
                </div>
            </div>
            
        </div>
    </form>
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
        

     $('.delete-div-wrap .closenew_approve').on('click', function() { 
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
<style>
.switch {
  position: relative;
  display: inline-block;
  width: 60px;
  height: 34px;
}

.switch input { 
  opacity: 0;
  width: 0;
  height: 0;
}

.slider {
  position: absolute;
  cursor: pointer;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background-color: #cc2424;
  -webkit-transition: .4s;
  transition: .4s;
}

.slider:before {
  position: absolute;
  content: "";
  height: 26px;
  width: 26px;
  left: 4px;
  bottom: 4px;
  background-color: white;
  -webkit-transition: .4s;
  transition: .4s;
}

input:checked + .slider {
  background-color: #00a65a;
}

input:focus + .slider {
  box-shadow: 0 0 1px #00a65a;
}

input:checked + .slider:before {
  -webkit-transform: translateX(26px);
  -ms-transform: translateX(26px);
  transform: translateX(26px);
}

/* Rounded sliders */
.slider.round {
  border-radius: 34px;
}

.slider.round:before {
  border-radius: 50%;
}
</style>
<script type="text/javascript">

    $(document).ready(function() {
        set_switchery();
    });


    $(document).ready(function() {
        $("form").submit(function(e){
            //return false;
        });
    });
</script>
<div id="reserve"></div>
