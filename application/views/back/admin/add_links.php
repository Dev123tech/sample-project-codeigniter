<div>
    <?php
  
        echo form_open(base_url() . 'admin/events/do_add_link/'.$events_id, array(
            'class' => 'form-horizontal',
            'method' => 'post',
            'id' => 'events_approval',
            'enctype' => 'multipart/form-data'
        ));
    ?>      
        <div class="panel-body">
        
            <div class="form-group btm_border">
                <label class="col-sm-4 control-label" for="demo-hor-11"><?php echo translate('video_link');?></label>
                <div class="col-sm-6">
                    <input type="text" name="video_link" value="<?php echo $video_link; ?>" placeholder="<?php echo translate('video_id_only');?>" class="form-control" required>
                </div>
            </div>

                            
            <div class="form-group btm_border">
                <label class="col-sm-4 control-label" for="demo-hor-12"><?php echo translate('Banner images');?></label>
                <div class="col-sm-6">
                    <span class="pull-left btn btn-default btn-file"> <?php echo translate('choose_file');?>
                        <input type="file" multiple name="images[]" onchange="preview(this);" id="demo-hor-inputpass" class="form-control">
                        <input type="hidden"  name="last_images" value="<?php echo $banner_image; ?>" required>
                    </span>
                    <br><br>
                    <span id="previewImg" ></span>
                </div>
            </div>
            <div class="form-group btm_border">
                <label class="col-sm-4 control-label" for="demo-hor-13"></label>
                <div class="col-sm-6">
                    <?php 
                        $images = explode(",",$banner_image);
                        // print_r($images);
                        if($images){
                            foreach ($images as $row1){
                    ?>
                            <div class="inner-div">
                                <img class="img-responsive" width="100" src="<?php echo base_url(); ?>uploads/events_image/<?php echo $row1; ?> "alt="User_Image" >
                            </div>
                        
                    <?php 
                            }
                        } 
                    ?>
                </div>
            </div>
              <br>
            <div class="col-sm-12">
                <button class="btn btn-success btn-md btn-labeled fa fa-upload pull-right enterer">Upload</button>
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

    $(document).ready(function() {
        set_switchery();
    });


    $(document).ready(function() {
        $("form").submit(function(e){
            //return false;
        });
    });
</script>


