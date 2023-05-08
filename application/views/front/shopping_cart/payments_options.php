    <?php 
        $system_title = $this->db->get_where('general_settings',array('type' => 'system_title'))->row()->value;
        $total = $this->cart->total(); 
        if ($this->crud_model->get_type_name_by_id('business_settings', '3', 'value') == 'product_wise') { 
            $shipping = $this->crud_model->cart_total_it('shipping'); 
        } elseif ($this->crud_model->get_type_name_by_id('business_settings', '3', 'value') == 'fixed') { 
            $shipping = $this->crud_model->get_type_name_by_id('business_settings', '2', 'value'); 
        } 
        $tax = $this->crud_model->cart_total_it('tax'); 
        $grand = $total + $shipping + $tax; 
        //echo $grand; 
    ?>
    <?php
        $p_set = $this->db->get_where('business_settings',array('type'=>'paypal_set'))->row()->value; 
        $c_set = $this->db->get_where('business_settings',array('type'=>'cash_set'))->row()->value; 
        $s_set = $this->db->get_where('business_settings',array('type'=>'stripe_set'))->row()->value;
        $c2_set = $this->db->get_where('business_settings',array('type'=>'c2_set'))->row()->value; 
        $vp_set = $this->db->get_where('business_settings',array('type'=>'vp_set'))->row()->value;
        $pum_set = $this->db->get_where('business_settings',array('type'=>'pum_set'))->row()->value;
        $ssl_set = $this->db->get_where('business_settings',array('type'=>'ssl_set'))->row()->value;
        
        
    ?> 

    <?php
     if($s_set == 'ok'){
    ?>
        <script src="https://checkout.stripe.com/checkout.js"></script>
        <a href="#" class="stripe_checkout" id="customButtong">Proceed to Checkout</a>
        <script>
            $(document).ready(function(e) {
                //<script src="https://js.stripe.com/v2/"><script>
                //https://checkout.stripe.com/checkout.js
                var handler = StripeCheckout.configure({
                    key: '<?php echo $this->db->get_where('business_settings' , array('type' => 'stripe_publishable'))->row()->value; ?>',
                    image: '<?php echo base_url(); ?>template/front/img/stripe.png',
                    token: function(token) {
                        // Use the token to create the charge with a server-side script.
                        // You can access the token ID with `token.id`
                        $('#cart_form').append("<input type='hidden' name='stripeToken' value='" + token.id + "' />");
                        if($( "#visa" ).length){
                            $( "#visa" ).prop( "checked", false );
                        }
                        if($( "#mastercard" ).length){
                            $( "#mastercard" ).prop( "checked", false );
                        }
                        $( "#mastercardd" ).prop( "checked", true );
                        notify('<?php echo translate('your_card_details_verified!'); ?>','success','bottom','right');
                        setTimeout(function(){
                            $('#cart_form').submit();
                        }, 500);
                    }
                });
        
                $('#customButtong').on('click', function(e) {
                    // Open Checkout with further options
                    var total = $('#grand').html(); 
                    total = total.replace("<?php echo currency(); ?>", '');
                    //total = parseFloat(total.replace(",", ''));
                    total = total/parseFloat(<?php echo exchange(); ?>);
                    total = total*100;
                    handler.open({
                        name: '<?php echo $system_title; ?>',
                        description: '<?php echo translate('pay_with_stripe'); ?>',
                        amount: total
                    });
                    e.preventDefault();
                });
        
                // Close Checkout on page navigation
                $(window).on('popstate', function() {
                    handler.close();
                });
            });
        </script>
    <?php
        } 
    ?>
