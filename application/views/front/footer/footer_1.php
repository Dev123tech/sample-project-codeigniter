<?php
    $footer_text =  $this->db->get_where('general_settings',array('type' => 'footer_text'))->row()->value;
    $contact_email =  $this->db->get_where('general_settings',array('type' => 'contact_email'))->row()->value;
?>
<!-- Footer Area Start -->
<div class="footer-area">
    <div class="footer-container">
        <div class="footer-top">
            <div class="container">
                <div class="row">
                    <div class="col-md-6 col-lg-3 mb-md-30px mb-lm-30px">
                        <div class="single-wedge">
                            <h4>Stay in touch</h4>
                            <!-- <p class="text-infor"> <?php echo $contact_email; ?></p>    -->
                            <p class="text-infor">omgee@omgee.com.au</p>
                            <p class="text-infor">1800 776 789<br>7 Pelangi Pty Ltd<br>Package Liquor Licence LIQP770017127</p>
                            <button class="btn btnnew" data-toggle="modal" data-target="#footermodal"><i class="fa fa-comment" aria-hidden="true"></i>Support</button>
                            <div class="modal fade support_footer sliderpop"  id="footermodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-modal="true" style="display: block;">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                           
                            <div class="modal-body">
                                <section class="footer_sup">
                                    <div class="container">
                                        <div class="row">

                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                            </button>
                                           <div class="col-sm-6">
                                            <img class="img-responsive" src="<?php echo base_url(); ?>template/omgee/images/iconfindericon/support_vector.png">
                                           </div>
                                              <div class="col-sm-6 supportform">
                                                <?php
                                                echo form_open(base_url() . 'home/contact/send', array(
                                                    'class' => 'contact-form',
                                                    'method' => 'post',
                                                    'enctype' => 'multipart/form-data',
                                                    'id' => 'contact-form'
                                                ));
                                                ?>
                                                    <h5>Having any questions? Let's talk</h5>
                                                    <p>If you still have any questions about our geatures or pricing, feel free to contact us</p>
                                                   
                                                    <input type="text" placeholder="<?php echo translate('name');?>" name="name" id="name" class="form-control placeholder name test required"/>
                                                    
                                                    
                                                    <input type="text" class="form-control placeholder mob test required" name="mob" id="mob" minlength="8" maxlength="15" placeholder="<?php echo translate('mobile_number');?>" onkeypress="isInputNumber(event)"/>

                                                    <input type="email" placeholder="<?php echo translate('email_address');?>" name="email" id="email" class="form-control placeholder email test required"/>
                                              
                                                    <textarea name="message" id="input-message" placeholder="<?php echo translate('type_your_message_here');?>" maxlength="250" rows="4" cols="50" class="form-control placeholder message test required"></textarea>
                                                  
                                                    <button type="button" class="btn btngra submitter12"  data-ing='<?php echo translate('sending..'); ?>'> Send </button>
                                                </form>
                                           </div>
                                        </div>
                                    </div>
                                </section>
                            </div>
                            </div></div></div>
                            <h4 class="footer-herading">Secured By</h4>
                            <img class="cloudheight" src="<?php echo $this->crud_model->logo('home_bottom_logo'); ?>">
                            
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-2 mb-md-30px mb-lm-30px">
                        <div class="single-wedge">
                            <h4>OMGee</h4>
                            <div class="footer-links">
                                <ul>
                                    <li><a href="<?php echo base_url(); ?>home/about_us">About Us</a></li>
                                    <li><a href="<?php echo base_url(); ?>home/legal/privacy_policy"><?php echo ucfirst(translate('privacy_policy'));?></a></li>
                                    <li><a href="<?php echo base_url(); ?>home/legal/terms_conditions"><?php echo ucfirst(translate('terms_&_conditions'));?></a></li>
                                    <!-- <li><a href="<?php echo base_url(); ?>home/affiliate">Affiliate</a></li> -->
                                     <!-- <li><a href="#">Security Policy</a></li>
                                      <li><a href="#">Delivery Policy</a></li>
                                       <li><a href="#">Return Policy</a></li> -->
                                </ul>
                            </div>
                             <div class="social-new">
                                <?php
                                    if ($facebook != '') {
                                    ?>
                                <a href="<?php echo $facebook;?>"><img class="facebtn" src="<?php echo base_url(); ?>template/omgee/images/iconfindericon/facebook.png"></a>
                                <?php
                                    } if ($instagram != '') {
                                    ?>
                                <a href="<?php echo $instagram;?>"><img class="instabtn" src="<?php echo base_url(); ?>template/omgee/images/iconfindericon/instagram.png"></a>
                                <?php
                                    }
                                    if ($youtube != '') {
                                    ?>
                                <a href="<?php echo $youtube;?>"><img class="gplusbtn" src="<?php echo base_url(); ?>template/omgee/images/iconfindericon/youtube.png"></a>
                                <?php
                                    }
                                    if ($googleplus != '') {
                                    ?>
                                <a href="<?php echo $googleplus;?>"><img class="twibtn" src="<?php echo base_url(); ?>template/omgee/images/iconfindericon/google-plus.png"></a>
                                <?php
                                    } 
                                    ?>
                            </div>

                        </div>
                    </div>
                   
                    <div class="col-md-6 col-lg-4">
                        <div class="single-wedge">
                            <img src="<?php echo base_url(); ?>template/omgee/images/iconfindericon/webadvertisement.png" class="img-responsive footerimgheight">
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-3">
                        <div class="single-wedge">
                            <img src="<?php echo base_url(); ?>template/omgee/images/iconfindericon/footerdownload.png" class="img-responsive footertag">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="footer-bottom">
            <div class="container">
                <div class="row">
                    <div class="col-md-6">
                        <p class="copy-text"><?php echo strip_tags($footer_text)  ;?>
                        </p>
                    </div>
                    <div class="col-md-6 text-right footerbottombar">
                        <img src="<?php echo base_url(); ?>template/omgee/images/iconfindericon/australia.png">
                        <img src="<?php echo base_url(); ?>template/omgee/images/iconfindericon/hong-kong.png">
                        <img src="<?php echo base_url(); ?>template/omgee/images/iconfindericon/singapore.png">
                        <img src="<?php echo base_url(); ?>template/omgee/images/iconfindericon/japan.png">
                        <img src="<?php echo base_url(); ?>template/omgee/images/iconfindericon/indonesia.png">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Footer Area End -->
<!-- button -->    
<?php 
if(CURRENT_URL == base_url())
{
    ?>
<div class="fixedscreen">
    <div class="container">
        <div class="row">
            <div class="col-sm-2 col-3 firstblock">
                <img src="<?php echo base_url(); ?>template/omgee/images/iconfindericon/fixedimg.png" class="img-responsive">
            </div>
            <div class="col-sm-6 col-9 text-center">
                <p>Never miss out on Cashback and Deals</p>
            </div>
            <div class="col-sm-4 col-12 lastblock">
                <img src="<?php echo base_url(); ?>template/omgee/images/iconfindericon/googleplay.png">
                <img src="<?php echo base_url(); ?>template/omgee/images/iconfindericon/appstore.png">
            </div>
        </div>
    </div>
</div>
<?php
}
?>
<!-- end of code -->

<script>
    function isInputNumber(evt){
        var ch = String.fromCharCode(evt.which);
        if(!(/[0-9]/.test(ch))){
            evt.preventDefault();
        }
    }

    $("body").on('change','.email',function(){
        var value=$(this).val();
        var here=$(this);
        var txt='<?php echo translate('enter_valid_email_address')?>';
        if(isValidEmailAddress(value) !== true){
            here.css({borderColor: 'red'});
            here.closest('div').find('.require_alert').remove();
            here.closest('.form-group').append(''
                +'  <span id="" class="require_alert" >'
                +'      '+txt
                +'  </span>'
            );
        } else{
        }
    });
     $('#contact-form').on('click','.submitter12', function(){
        var herea = $(this); // alert div for show alert message
        var form = herea.closest('form');
        var ing = herea.data('ing');
        var msg = herea.data('msg');
        var prv = herea.html();
        var sent = '<?php echo translate('message_sent_successfully')?>';
        var can = '';
        var captcha_incorrect = '<?php echo translate('please_fill_the_captcha'); ?>'
        var incorrect = '<?php echo translate('incorrect_information').'. '.translate('check_again').'!';?>'
        var l = '';
        var formdata = false;
        if (window.FormData){
            formdata = new FormData(form[0]);
        }
         var message=$('.message').val();
        if(message){
            can3 ='yes';
        }else{
            can3 ='no';
             var incorrect = "<?php echo 'Please Insert Valid message !' ;?>"
        }
        
        var email=$('.email').val();
        if(isValidEmailAddress(email)==true){
            can ='yes';
        }else{
            can ='no';
             var incorrect = "<?php echo 'Please Insert Valid Email Address !' ;?>"
        }
        
        var mob=$('.mob').val();
        if(mob){
            can2 ='yes';
        }else{
            can2 ='no';
             var incorrect = "<?php echo 'Please Insert mob !' ;?>"
        }
        var name=$('.name').val();
        if(name){
            can1 ='yes';
        }else{
            can1 ='no';
             var incorrect = "<?php echo 'Please Insert Name !' ;?>"
        }
       
        
        $('#contact-form .test').each(function() {
            var it=$(this);
            if(it.val()==''){
                it.css({borderColor: 'red'});
                it.closest('div').find('.require_alert').remove();
                it.closest('.form-group').append(''
                    +'  <span id="" class="require_alert" >'
                    +'      <?php echo translate('this_field_is_required!')?>'
                    +'  </span>'
                );
                can ='no';
            }
        });
        
        if(can !== 'no'){
            $.ajax({
                url: form.attr('action'), // form action url
                type: 'POST', // form submit method get/post
                dataType: 'html', // request type html/json/xml
                data: formdata ? formdata : form.serialize(), // serialize form data 
                cache       : false,
                contentType : false,
                processData : false,
                beforeSend: function() {
                    herea.html(ing); // change submit button text
                },
                success: function(data) {
                    herea.fadeIn();
                    herea.html(prv);
                    if(data == 'sent'){
                        //sound('message_sent');
                        notify(sent,'success','bottom','right');
                        setTimeout(
                            function() {
                                location.replace("<?php echo base_url(); ?>home");
                            }, 2000
                        );
                    } else if (data == 'captcha_incorrect'){
                        //sound('captcha_incorrect');
                        $('#recaptcha_reload_btn').click();
                        notify(captcha_incorrect,'warning','bottom','right');
                        
                    }else {
                        notify(data,'warning','bottom','right');
                    }
                },
                error: function(e) {
                    console.log(e)
                }
            });
        }else{
            notify(incorrect,'warning','bottom','right');
        }
    });
    
    $("#contact-form").on('change','.test',function(){
        var here = $(this);
        here.css({borderColor: '#dcdcdc'});
        
        if (here.attr('type') == 'email'){
            if(isValidEmailAddress(here.val())){
                here.closest('div').find('.require_alert').remove();
            }
        } else {
            here.closest('div').find('.require_alert').remove();
        }
        if(here.is('select')){
            here.closest('div').find('.chosen-single').css({borderColor: '#dcdcdc'});
        }
    });
    
    function isValidEmailAddress(emailAddress) {
        var pattern = new RegExp(/^(("[\w-+\s]+")|([\w-+]+(?:\.[\w-+]+)*)|("[\w-+\s]+")([\w-+]+(?:\.[\w-+]+)*))(@((?:[\w-+]+\.)*\w[\w-+]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$)|(@\[?((25[0-5]\.|2[0-4][\d]\.|1[\d]{2}\.|[\d]{1,2}\.))((25[0-5]|2[0-4][\d]|1[\d]{2}|[\d]{1,2})\.){2}(25[0-5]|2[0-4][\d]|1[\d]{2}|[\d]{1,2})\]?$)/i);
        return pattern.test(emailAddress);
    };
</script>