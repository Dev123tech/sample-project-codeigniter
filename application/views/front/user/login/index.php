<div class="offcanvas-overlay"></div>
<!-- Breadcrumb Area Start -->
<div class="breadcrumb-area">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="breadcrumb-content">
                    <ul class="nav">
                        <li><a href="<?php echo base_url(); ?>">Home</a></li>
                        <li><?php echo translate('login');?> or Signup</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Breadcrumb Area End-->
<div id="loginmodal" class="modal fade log_pop">
    <div class="modal-dialog">
        <button type="button" class="close d-none" data-dismiss="modal" aria-hidden="true">&times;</button>
        <div class="modal-content loginpopup-bg-image">
            <div class="modal-body">
                <div class="loginpop">
                    <div class="row">
                        <div class="col-sm-12 text-center">
                            <?php
                                $home_top_logo = $this->db->get_where('ui_settings',array('type' => 'home_top_logo'))->row()->value;
                                ?>
                            <img src="<?php echo base_url(); ?>uploads/logo_image/logo_<?php echo $home_top_logo; ?>.png">
                            <h4>YOU NEED TO BE OVER THE LEGAL DRINKING AGE IN YOUR COUNTRY</h4>
                            <h5>Please confirm you are over <?php
                                if($this->session->userdata('currency') == '2')
                                 {
                                     echo  $eligible_age = "18";
                                 }
                                 else{
                                    echo  $eligible_age = "21";
                                 }
                                 /*if($this->session->userdata('currency') == '10')
                                 {
                                     echo $eligible_age = "21";
                                 }
                                 if($this->session->userdata('currency') == '13')
                                 {
                                     echo $eligible_age = "20";
                                 }
                                 if($this->session->userdata('currency') == '22')
                                 {
                                     echo $eligible_age = "18";
                                 }*/
                                ?> years of age?</h5>
                            <button type="button" class="btn btnyes" data-dismiss="modal" aria-hidden="true">Yes</button>
                            <button type="button" id="btn_no" class="btn btnno">No</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<section>
    <div class="login-register-area mtb-20px">
        <div class="container">
            <div class="row">
                <div class="col-lg-7 col-md-12 ml-auto mr-auto">
                    <div class="login-register-wrapper">
                        <div class="login-register-tab-list nav"id="lrg">
                            <a class="active" data-toggle="tab" href="#lg1">
                                <h4><?php echo translate('login');?></h4>
                            </a>
                            <a data-toggle="tab" href="#lg2">
                                <h4>register</h4>
                            </a>
                        </div>
                        <div class="tab-content"id="login">
                            <div id="lg1" class="tab-pane <?php if($_GET['code'] =="") { echo 'active'; } ?>">
                                <div class="cart-tax loginform">
                                    <div class="title-wrap">
                                        <h4 class="cart-bottom-title section-bg-gray"><?php echo translate('login');?></h4>
                                    </div>
                                    <div class="tax-wrapper">
                                        <div class="tax-select-wrapper">
                                            <?php
                                                echo form_open(base_url() . 'home/login/do_login/', array('method' => 'post'));
                                                ?>
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <div class="tax-select">
                                                        <input type="text" name="email" id="username" placeholder="<?php echo translate('enter_email');?>" class="form-control enterclicklogin">
                                                    </div>
                                                </div>
                                                <div class="col-sm-12">
                                                    <div class="tax-select mb-25px">
                                                        <div class="formclass">
                                                            <input type="password" id="password"  name="password" class="form-control enterclicklogin" placeholder="<?php echo translate('enter_password');?>">
                                                            <i class="fa fa-eye" onclick="password_hideshow()"></i>
                                                        </div>
                                                    </div>
                                                    <div class="login-toggle-btn">
                                                        <label>
                                                        <input type="checkbox" id="remember_me"> Remember me
                                                        </label>
                                                        <a href="#" onClick="set_html('forget','login','lrg')"><?php echo translate('forget_your_password_?');?></a>
                                                    </div>
                                                </div>
                                                <div class="col-sm-12 text-right">
                                                    <button class="cart-btn-2 login_btn entersubmitlogin" type="button"><?php echo translate('login');?></button>
                                                </div>
                                                <div class="col-sm-12 text-center" style="display: none;"> <small>-or login via social media-</small> </div>
                                                <div class="col-sm-12 text-center" style="display: none;">
                                                    <button type="button" class="btn instaloginbtn">
                                                        <ion-icon name="logo-instagram"></ion-icon>
                                                        Instagram     
                                                    </button>
                                                    <button type="button" class="btn faceloginbtn">
                                                        <ion-icon name="logo-facebook"></ion-icon>
                                                        Facebook       
                                                    </button>
                                                    <button type="button" class="btn linkbtn">
                                                        <ion-icon name="logo-linkedin"></ion-icon>
                                                        linkedin 
                                                    </button>
                                                </div> 
                                                </div>
                                            <?php echo form_close() ; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div id="lg2" class="tab-pane <?php if($_GET['code'] !="") { echo 'active'; } ?>">
                                <div class="cart-tax loginform">
                                    <div class="title-wrap">
                                        <h4 class="cart-bottom-title section-bg-gray">Signup</h4>
                                    </div>
                                    <div class="tax-wrapper">
                                        <div class="tax-select-wrapper">
                                            <?php echo form_open(base_url() . 'home/registration/add_info/', array('method' => 'post'));?>
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <div class="tax-select">
                                                        <select class="form-control titlename" name="titlename" required>
                                                            <option value="">Title</option>
                                                            <option value="Mr"><?php echo translate('mr');?></option>
                                                            <option value="Mrs"><?php echo translate('mrs');?></option>
                                                        </select>
                                                        <input type="text" name="username" placeholder="Enter Your <?php echo translate('full_name');?>" class="form-control namefield"required>
                                                    </div>
                                                </div>
                                                <div class="col-sm-4">
                                                    <div class="tax-select mb-25px">
                                                        <input type="email" name="email" class="form-control emails required" placeholder="Enter <?php echo translate('email');?>" >
                                                        <div id='email_note'></div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-3">
                                                    <div class="tax-select mb-25px">
                                                        <select name="countrycode" class="form-control" required>
                                                            <option value=""><?php echo translate('code');?></option>
                                                            <option value="61">(+61) Australia</option>
                                                            <option value="852">(+852) Hong Kong </option>
                                                            <option value="81">(+81) Japan</option>
                                                            <option value="65">(+65) Singapore</option>
                                                        </select>
                                                        <div id='code'></div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-5">
                                                    <div class="tax-select">
                                                        <input type="text" name="phone"  placeholder="123-123-1234" class="form-control" placeholder="<?php echo translate('phone');?>" onkeypress="isInputNumber(event)">
                                                    </div>
                                                </div>
                                                <!-- Password -->
                                                <div class="col-sm-6">
                                                    <div class="tax-select mb-25px">
                                                        <div class="formclass">
                                                            <input type="password" id="password1"  name="password1" class="form-control pass1 required" placeholder="Enter <?php echo translate('password');?>">
                                                            <i class="fa fa-eye password1" onclick="rpassword_hideshow()"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- Cofirm Password -->
                                                <div class="col-sm-6">
                                                    <div class="tax-select">
                                                        <div class="formclass">
                                                            <input type="password" id="password2" name="password2" placeholder="Enter <?php echo translate('confirm_password');?>" class="form-control required">
                                                            <i class="fa fa-eye password2" onclick="rcpassword_hideshow()"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                                .
                                                <!-- Cofirm Password -->
                                                <div class="col-sm-12">
                                                    <div class="tax-select countab">
                                                        <div class="formclass">
                                                            <select  name="country" class="form-control" required>
                                                                <option value="">---Select Country---</option>
                                                                <option value="Australia">Australia</option>
                                                                <option value="Hongkong">Hong Kong</option>
                                                                <option value="Japan" >Japan</option>
                                                                <option value="Singapore" >Singapore</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-12">
                                                    <div class="tax-select datlabel">
                                                    </div>
                                                    <div class="formclass">
                                                        <input type="text" name="dob" class="form-control"   id="datepicker" placeholder="Date Of Birth"  >
                                                        <span class="dob_error"></span>
                                                    </div>
                                                </div>
                                                <div class="col-sm-12">
                                                    <div class="tax-select">
                                                        <label>Referral Code</label>
                                                        <div class="formclass">
                                                            <input type="text" placeholder="<?php echo translate('enter_referral_code'); ?>"  name="unique_refer_key" class="form-control required" value="<?php echo $_GET['code'] ?>" >
                                                        </div>
                                                    </div>
                                                    <div class="regis_check">
                                                        <label class="custom-checkbox">
                                                            <input  name="comfirm" type="checkbox" value="1" >
                                                            <span><i class="material-icons rtl-no-flip checkbox-checked"></i></span>
                                                            <p>I Agreed to <a href="<?php echo base_url(); ?>home/legal/terms_conditions"><u><?php echo ucfirst(translate('terms_&_conditions'));?></u></a></p>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="col-sm-12 text-right">
                                                    <button class="cart-btn-2 logup_btn" type="button"><?php echo translate('register');?></button>
                                                </div>
                                            </div>
                                            <?php echo form_close(); ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>


   
     <div class="row123" id="forget" style="display:none">

         <div class="login-register-tab-list nav"id="lrg">
                            <a class="active" data-toggle="tab" href="#lg1">
                                <h4><?php echo translate('Reset Password');?></h4>
                            </a>
                            
         </div>
        <div class="tab-content">

             <div class="cart-tax loginform">

                 <div class="title-wrap">
                                        <h4 class="cart-bottom-title section-bg-gray"><?php echo translate('Reset Password');?></h4>
                 </div>


          <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <?php
                echo form_open(base_url() . 'home/login/forget/', array(
                    'class' => 'form-login',
                    'method' => 'post',
                    'id' => 'forget_form'
                ));
            ?>
                <div class="row box_shape2">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="form-group">
                            <input class="form-control" type="email" name="email" placeholder="<?php echo translate('email_address');?>">
                        </div>
                    </div>
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-right">
                        <span class="forgot-password pull-left" style="cursor: pointer;margin-left: 1px;" onClick="set_html2('login','forget','lrg')">
                            <?php echo translate('back_to_login');?>
                        </span>
                        <span class="btn btn-primary btn-sm forget_btn">
                            <?php echo translate('submit');?>
                        </span>
                    </div>
                </div>
            </form>
        </div>
    </div></div></div>







                    </div>
                </div>
            </div>





        </div>



   



    </div>






    
</section>






  
  







<script type="text/javascript">


function set_html(hide,show,lrg){   
    $('#'+hide).show('fast');
    $('#'+show).hide('fast');
    $('#'+lrg).hide('fast');
}



function set_html2(hide,show,lrg){   
    $('#'+hide).show('fast');
    $('#'+show).hide('fast');
    $('#'+lrg).show('fast');
}




    function isInputNumber(evt){
        var ch = String.fromCharCode(evt.which);
        if(!(/[0-9]/.test(ch))){
            evt.preventDefault();
        }
    }
    
    jQuery(document).ready(function() 
    { 
        if (localStorage.chkbx && localStorage.chkbx != '') {
            $('#remember_me').attr('checked', 'checked');
            $('#username').val(localStorage.usrname);
            $('#password').val(localStorage.pass);
        } else {
            $('#remember_me').removeAttr('checked');
            $('#username').val('');
            $('#password').val('');
        }
    
        $('#remember_me').click(function() {
    
            if ($('#remember_me').is(':checked')) {
                // save username and password
                localStorage.usrname = $('#username').val();
                localStorage.pass = $('#password').val();
                localStorage.chkbx = $('#remember_me').val();
            } else {
                localStorage.usrname = '';
                localStorage.pass = '';
                localStorage.chkbx = '';
            }
        });
    
    
        $("#datepicker").datepicker({changeMonth: true,
            changeYear: true,
            showButtonPanel: true,
            yearRange: "-100:+0"});
        $("#datepicker").on("change",function()
        {
            var dateString = $(this).val();
    
            var parts = dateString.split("/");
            var dtCurrent = new Date();
            var get_year = dtCurrent.getFullYear() - parts[2];    
    
            console.log(get_year);
            if (<?php echo $eligible_age; ?> > get_year) 
            {
                $('.dob_error').html("You must be at least <?php echo $eligible_age; ?> years old").css('color','red');
            }
            else
            {
                $('.dob_error').html(" ");
    
            }
        });
    });
</script>