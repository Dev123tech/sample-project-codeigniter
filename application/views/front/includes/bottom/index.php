		<script>
            var base_url = "<?php echo base_url(); ?>";
        </script>
        <script src="<?php echo base_url(); ?>template/front/js/ajax_method.js"></script>
        <script src="<?php echo base_url(); ?>template/front/js/bootstrap-notify.min.js"></script>
        <script src="<?php echo base_url(); ?>template/front/plugins/jquery-ui/jquery-ui.min.js"></script>
        <?php 
        if(CURRENT_URL != base_url('home/login_set/login'))
        {
            ?>
            <script src="<?php echo base_url(); ?>template/front/plugins/bootstrap/js/bootstrap.min.js"></script>
        <?php 
        }
        else
        {
            ?>
            <script type="text/javascript">
            $(document).ready(function(){
                $("#loginmodal").modal({backdrop: 'static', keyboard: false,show:true});
            });
            </script>
            <?php
        }
        ?>
        <script src="<?php echo base_url(); ?>template/front/plugins/bootstrap-select/js/bootstrap-select.min.js"></script>
        <!-- JS Global -->
        <script src="<?php echo base_url(); ?>template/front/plugins/superfish/js/superfish.min.js"></script>
        <script src="<?php echo base_url(); ?>template/front/plugins/jquery.sticky.min.js"></script>
        <script src="<?php echo base_url(); ?>template/front/plugins/jquery.easing.min.js"></script>
        <script src="<?php echo base_url(); ?>template/front/plugins/jquery.smoothscroll.min.js"></script>
        <!-- <script src="<?php echo base_url(); ?>template/front/plugins/smooth-scrollbar.min.js"></script> -->
        <script src="<?php echo base_url(); ?>template/front/plugins/jquery.cookie.js"></script>
        
        <script src="<?php echo base_url(); ?>template/front/plugins/modernizr.custom.js"></script>
        <script src="<?php echo base_url(); ?>template/front/modal/js/jquery.active-modals.js"></script>
        <script src="<?php echo base_url(); ?>template/front/js/theme.js"></script>
        
        <?php include $asset_page.'.php'; ?>
        <?php include 'custom_js.php'; ?>

        <form id="cart_form_singl">
                <input type="hidden" name="color" value="">
                <input type="hidden" name="qty" value="1">
        </form>
        <script src="https://unpkg.com/ionicons@5.1.2/dist/ionicons.js"></script>
        <script src="<?php echo base_url(); ?>template/omgee/js/plugins/plugins.min.js"></script>
        <!-- Main Activation JS -->
        <script src="<?php echo base_url(); ?>template/omgee/js/main.js"></script>

       
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.1/js/select2.min.js"></script>