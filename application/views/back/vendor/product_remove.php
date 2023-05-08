
    <?php
		echo form_open(base_url() . 'vendor/product/remove/', array(
			'class' => 'form-horizontal',
			'method' => 'post',
			'id' => 'add_remove',
			'enctype' => 'multipart/form-data'
		));
	?>
            <input type="hidden" name="product_id" value="<?php echo $product; ?>" >
            <input type="hidden" name="remove" value="1" >
            <h3><?php echo translate('do_you_really_want_to_remove_this_product!'); ?></h3>
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

