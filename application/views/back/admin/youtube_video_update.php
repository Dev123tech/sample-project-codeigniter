<div id="content-container">
    <div id="page-title">
        <h1 class="page-header text-overflow"><?php echo 'Youtube Video Update' ;?></h1>
    </div>
    <div class="container">
        <div class="row">
            <?php
                echo form_open(base_url() . 'admin/youtube_video_update/update_video/', array(
                    'class' => 'form-horizontal',
                    'method' => 'post',
                    'id' => 'add_video',
                    'enctype' => 'multipart/form-data'
                ));
            ?>
            <br>
            <?php
                $video_type = $this->db->get_where('general_settings',array('type'=>'video_link'))->row_array();
            ?>   
            <div class="form-group btm_border">
                <label class="col-sm-2 control-label" for="demo-hor-1"><?php echo translate('video_update');?></label>
                <div class="col-sm-6">
                    <input type="text" name="video_link" id="video_update" value="<?php echo $video_type['value']; ?>" placeholder="<?php echo translate('video_update');?>" class="form-control required" >
                </div>
            </div>
            <div class="panel-footer">
                <div class="row">
                    <div class="panel-footer text-center">
                        <span class="btn btn-success btn-labeled fa fa-check submitter"  data-ing='<?php echo translate('saving'); ?>' data-msg='<?php echo translate('settings_updated!'); ?>'>
                            <?php echo translate('save');?>
                        </span>
                    </div>
                </div>
            </div>
            </form>
        </div>
    </div>
</div>

