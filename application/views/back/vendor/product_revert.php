
    <?php
		echo form_open(base_url() . 'vendor/remove_product/revert/', array(
			'class' => 'form-horizontal',
			'method' => 'post',
			'id' => 'add_revert',
			'enctype' => 'multipart/form-data'
		));
	?>
            <input type="hidden" name="product_id" value="<?php echo $product; ?>" >
            <input type="hidden" name="remove" value="0" >
            <h3><?php echo translate('do_you_really_want_to_revert_this_product!'); ?></h3>
    </form>


<script type="text/javascript">

    $(document).ready(function() {
        $('.demo-chosen-select').chosen();
        $('.demo-cs-multiselect').chosen({width:'100%'});
    });


	$(document).ready(function() {
		$("form").submit(function(e){
			event.preventDefault();
		});
	});
</script>

