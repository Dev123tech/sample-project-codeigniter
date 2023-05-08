<?php            
	$refer =  $this->db->get_where('general_settings',array('type' => 'earn'))->row()->value;
?>          
<div id="content-container">
    <div id="page-title">
    	<center>
        	<h1 class="page-header text-overflow">
				<?php echo translate('manage_referral_earn')?>
            </h1>
        </center>
    </div>
    <?php
		echo form_open(base_url() . 'admin/business_settings/refer/', array(
			'class'     => 'form-horizontal',
			'method'    => 'post',
			'enctype'   => 'multipart/form-data'
		));
	?>
        <div class="row">
            <div class="col-md-12">
                <div class="form-group btm_border">
                    <label class="col-sm-4 control-label" for="demo-hor-17">Referral Earn (<?php echo currency(); ?>) </label>
                    <div class="col-sm-6">
                        <input type="number" name="earn" class="form-control" value="<?php echo $refer; ?>" placeholder="<?php echo translate('Enter_referral_money'); ?>">
                    </div>
                </div>
            </div>
        </div>
        <div class="panel-footer text-right">
            <span class="btn btn-info submitter enterer" 
                data-ing='<?php echo translate('saving'); ?>' data-msg='<?php echo translate('settings_updated!'); ?>' >
                    <?php echo translate('save');?>
            </span>
        </div>
    </form>
</div>

<script src="<?php echo base_url(); ?>template/back/js/custom/business.js"></script>

