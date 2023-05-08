<?php
    if($this->session->userdata('vendor_login')=='yes')
      {
            redirect(base_url('vendor'));
      }
      ?>
<style type="text/css">
    .ajax-loader 
    {
    visibility: hidden;
    background-color: rgba(255,255,255,0.7);
    position: absolute;
    z-index: +100 !important;
    width: 100%;
    height:100%;
    }
    .ajax-loader img {
    position: relative;
    top:50%;
    left:50%;
    }
</style>
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
<div class="offcanvas-overlay"></div>
<div class="ajax-loader">
    <!-- <img src="<?php echo base_url('uploads'); ?>/loader.gif" class="img-responsive" />  -->
</div>
<div class="breadcrumb-area">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="breadcrumb-content">
                    <ul class="nav">
                        <li><a href="<?php echo base_url(); ?>">Home</a></li>
                        <li>Account</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<section class="vender_center_register">
    <div class="container">
        <div class="row">
            <div class="col-sm-6 offset-sm-3">
                <!-- <div class="vendormainblock">
                    <img src="assets/images/iconfindericon/vendorbgg.jpg" class="img-responsive">
                    </div> -->
                <div class="blocksec ">
                    <h4>VENDOR REGISTRATION</h4>
                    <p style="text-align: left; margin-left:30%;">
                        Already A Vendor ? <a href="<?php echo base_url('vendor'); ?>">Login </a>  <br/>
                        New Vendor <!--<a href="<?php echo base_url('home/vendor_logup/registration'); ?>"> -->Sign-Up below:</a> 
                    </p>
                </div>
                <div class="form-modal">
                    <div id="signup-form">
                        <?php
                            echo form_open(base_url() . 'home/vendor_logup/add_info/', array('class' => 'form-login','id' => 'sign_form'));
                            ?>
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="vendortop">
                                    <h4 class="vendorlog">Vendor Registration</h4>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <!--<label>Full Name</label> -->
                            </div>
                            <div class="col-sm-8">
                                <div class="row">
                                    <div class="col-sm-4 selectpro">
                                        <div class="select-wrapper">
                                            <select name="titlename" id="title">
                                                <option value="">Title</option>
                                                <option value="Mr">Mr</option>
                                                <option value="Miss">Miss</option>
                                                <option value="Mrs">Mrs</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-8"> 
                                        <input name="name" type="text" id="firstname" placeholder="First Name" required>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-4"> 
                                <input name="last_name" type="text" id="lastname" placeholder=" Last Name">
                                <span class="last_name"></span>
                            </div>
                            <div class="col-sm-6">
                                <!-- <label><?php echo translate('company');?></label> -->
                                <input name="company" type="text" placeholder="<?php echo translate('company');?>"/>
                            </div>
                            <div class="col-sm-6">
                                <!-- <label><?php echo translate('company');?></label> -->
                                <input name="abn" type="text" placeholder="ABN/ACN"/>
                            </div>
                            <div class="col-sm-6">
                                <!-- <label>Email Address</label> -->
                                <input name="website" type="email"  placeholder="Website">
                            </div>
                            <div class="col-sm-6"></div>
                            <div class="col-sm-6">
                                <!--<label>Address Line 1</label>   -->
                                <textarea name="address1" id="address1" placeholder="<?php echo translate('address_line_1');?>" rows="3"></textarea>
                            </div>
                            <div class="col-sm-6">
                                <!-- <label>Address Line 2</label>   -->
                                <textarea name="address2" placeholder="<?php echo translate('address_line_2');?>" rows="3"></textarea>
                            </div>
                            <div class="col-sm-6">
                                <!--  <label>City</label> -->
                                <input type="text" name="city" id="city" placeholder="<?php echo translate('suburb');?>">
                            </div>
                            <div class="col-sm-6">
                                <!--  <label>State</label>  -->
                                <input type="text" name="state" id="states" placeholder="<?php echo translate('state');?>">
                            </div>
                            <div class="col-sm-6">
                                <!-- <label>Post Code</label>  -->
                                <input type="text" name="zip" id="zip" placeholder="<?php echo translate('Post Code');?>">
                            </div>
                            <div class="col-sm-6 selectpro">
                                <input type="hidden" name="country"value="Null">
                                <!-- <label>Country Name</label> -->
                                <!--  <div class="select-wrapper">
                                    <select name="country">
                                        <option>Select Country</option>
                                        <option value="Australia">Australia</option>
                                        <option value="Japan">Japan</option>
                                        <option value="Hong Kong">Hong Kong </option>
                                        <option value="Singapore">Singapore</option>   
                                </select> --->
                                <!--</div>  -->
                            </div>
                            <div class="col-sm-6">
                                <!-- <label>Phone Number</label> -->
                                <div class="row">
                                    <div class="col-sm-4 selectpro">
                                        <div class="select-wrapper">
                                            <select name="countryCode">
                                                <option value="02">(+02)</option>
                                                <option value="03">(+03)</option>
                                                <option value="04">(+04)</option>
                                                <option value="07">(+07)</option>
                                                <option value="08">(+08)</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-8">
                                        <input type="text" id="phone" name="phone" placeholder="<?php echo translate('phone');?>"onkeypress="isInputNumber(event)">
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="row">
                                    <div class="col-sm-4 selectpro" style="display: none;">
                                        <div class="select-wrapper">
                                            <select name="phone_code">
                                                <option value="">Code</option>
                                                <option value="61">(+61) Australia</option>
                                                <option value="81">(+81) Japan</option>
                                                <option value="852">(+852) Hong Kong </option>
                                                <option value="65">(+65) Singapore</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-12">
                                        <input name="mobile" type="text" placeholder="<?php echo translate('Mobile Number');?>"onkeypress="isInputNumber(event)"/>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <!-- <label>Email Address</label> -->
                                <input name="email" type="email" id="mail" placeholder="<?php echo translate('email');?>">
                            </div>
                            <div class="col-sm-6"></div>
                            <div class="col-sm-6">
                                <!-- <label>Password</label>  -->
                                <div class="passfield">
                                    <input type="password" name="password1" id="pass1" minlength="6" id="password1" placeholder="<?php echo translate('password');?>" />
                                    <i class="fa fa-eye password1" onclick="rpassword_hideshow()"></i>
                                </div>
                               
                            </div>
                            <div class="col-sm-6">
                                <!--  <label>Confirm Password</label>  -->
                                <div class="passfield">
                                    <input type="password" name="password2" id="pass2" minlength="6" id="password2" placeholder="<?php echo translate('confirm_password');?>" />
                                    <i class="fa fa-eye password2" onclick="rcpassword_hideshow()"></i>
                                </div>
                              
                            </div>
                            <div class="col-sm-6">
                                <div class="field_wrapper">
                                    <input type="text"name="brand[]"id="vendor_brand"placeholder="Brand  Name"/>
                                    <a href="javascript:void(0);" class="add_button" title="Add field">
                                    <img src="https://img.icons8.com/android/24/000000/plus.png"width="12"height="12"style="position:absolute;right:19px;top:17px;"/></a>
                                </div>
                            </div>
                            <div class="col-sm-6 selectpro custom_vendor_sel">
                                <?php  $row=$this->db->get("category");
                                    ?>
                                <!--  Brand category -->       
                                <div class="select-wrapper" id="select-wrapper">
                                    <select  name="brandcategory0[]" multiple="multiple"size="1">
                                        <option value="23">Wine</option>
                                        <?php foreach($row->result() as $cat)
                                        {
                                            if($cat->category_id=="23")
                                            {    
                                                continue;
                                            }
                                            else
                                            {
                                            
                                            ?>
                                        <option value="<?php  echo $cat->category_id; ?>"> <?php echo$cat->category_name; ?></option>
                                        <?php   } }  ?>
                                    </select>
                                </div>
                                <style type="text/css">
                                    .custom_vendor_sel .select2-container--default .select2-selection--single {
                                    width: 100%;
                                    font-size: 1em;
                                    padding: 13px 10px;
                                    margin-top: 0.2em;
                                    margin-bottom: 0.4em;
                                    border-radius: 10px;
                                    border: 1px solid #e2e2e2;
                                    background: #fff;
                                    outline: none;
                                    height: 44px;
                                    }
                                    .custom_vendor_sel .select2-container--default .select2-selection--single .select2-selection__arrow {
                                    height: 26px;
                                    position: absolute;
                                    top: 10px;
                                    right: 1px;
                                    width: 35px;
                                    }
                                </style>
                            </div>
                            <div class="col-sm-12">
                                <div class="regis_check vendorcheck">
                                    <span class="custom-checkbox">
                                        <input name="terms_check" type="checkbox" value="ok">
                                        <p><?php //echo translate('i_agree_with');?> I Accept<a href="<?php echo base_url();?>home/legal/Vendor_Agreements"style="font-size:14px;">  Terms and Conditions </a> for Vendor Agreement</p>
                                    </span>
                                </div>
                            </div>
                            <div class="col-sm-5 offset-sm-7">
                                <button id="submit"  onsubmit="fName_Changed(this)"  type="button" class="btn signup logup_btn"onclick="if(!this.form.checkbox.checked){alert('Vendor must Read & Tick Vendor Agreement('Before even can Create Account').');return false} ">Create Account</button>
                            </div>
                        </div>
                        <hr>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<script>
    function isInputNumber(evt){
        var ch = String.fromCharCode(evt.which);
        if(!(/[0-9]/.test(ch))){
            evt.preventDefault();
        }   
    }
</script>
<script type="text/javascript">
    $(document).ready(function(){
        var maxField = 5; //Input fields increment limitation
        var addButton = $('.add_button'); //Add button selector
        var wrapper = $('.field_wrapper'); //Input field wrapper
        var fieldHTML = '<div><input type="text" name="brand[]" placeholder="Brand Name"value=""/><a href="javascript:void(0);" class="remove_button">  <img src="https://img.icons8.com/android/24/000000/minus.png" width="12"height="12"style="position:relative;right:-240px;top:-36px;"/></a></div>'; //New input field html 
        var x = 1; //Initial field counter is 1
        //Once add button is clicked
        $(addButton).click(function(){
            //Check maximum number of input fields
            if(x < maxField)
            { 
                 //Increment field counter
                $(wrapper).append(fieldHTML); //Add field html
    
                $('#select-wrapper').append("<div class='mcx'><Select name='brandcategory"+x+"[]'' size='1'multiple><?php foreach($row->result() as $cat){?><option value='<?php  echo $cat->category_id; ?>'> <?php echo$cat->category_name; ?></option><?php   }   ?>?></Select></div>");
                x++;
            }
        });
        
        //Once remove button is clicked
        $(wrapper).on('click', '.remove_button', function(e){
            e.preventDefault();
            $(this).parent('div').remove(); //Remove field html
            
            $('.mcx').remove();
    
            x--; //Decrement field counter
        });
    });
    
    $(document).ready(function() {
        $('.mcat').select2();
    });

    $('#submit').click(function(event) {

      var firstname = $('#firstname').val();
      var lastname = $('#lastname').val();
      var title = $('#title').val();
      var mail = $('#mail').val();
      var pass1 = $('#pass1').val();
      var pass2 = $('#pass2').val();

      var mail = $('#mail').val();
      var phone = $('#phone').val();
      var address1 = $('#address1').val();
      var city = $('#city').val();
      var state = $('#states').val();

    if (firstname.trim() == '')
    {
        $('#firstname').css({
          'border': '1px solid red'
        });
    }
    else{
        $('#firstname').css({
          'border': '1px solid #e2e2e2'
        });
    } 

    if(phone.trim() == '')   
    {    
        $('#phone').css({
          'border': '1px solid red'
        });
    }
    else  
    {    
        $('#phone').css({
          'border': '1px solid #e2e2e2'
        });
    } 

    if(lastname.trim() == '')  
    {  
        $('#lastname').css({
          'border': '1px solid red'
        });
    }
    else  
    {    
        $('#lastname').css({
          'border': '1px solid #e2e2e2'
        });
    } 

    if(title.trim() == '')
    {    
        $('#title').css({
          'border': '1px solid red'
        });
    }
    else  
    {    
        $('#title').css({
          'border': '1px solid #e2e2e2'
        });
    }

    if(mail.trim() == '')
    {
        $('#mail').css({
          'border': '1px solid red'
        });
    }
    else  
    {    
        $('#mail').css({
          'border': '1px solid #e2e2e2'
        });
    }

    if(pass1.trim() == '')
    {   
        $('#pass1').css({
          'border': '1px solid red'
        });
    }
    else  
    {    
        $('#pass1').css({
          'border': '1px solid #e2e2e2'
        });
    }

    if(pass2.trim() == '')
    {
        $('#pass2').css({
          'border': '1px solid red'
        });
    }
    else  
    {    
        $('#pass2').css({
          'border': '1px solid #e2e2e2'
        });
    }

    if(zip.trim() == '')
    {
        $('#zip').css({
          'border': '1px solid red'
        });
    }
    else  
    {    
        $('#zip').css({
          'border': '1px solid #e2e2e2'
        });
    }

    if(city.trim() == '')
    {    
        $('#city').css({
          'border': '1px solid red'
        });
    }
    if(state.trim() == '')
    {
        $('#states').css({
          'border': '1px solid red'
        });
    }
    else  
    {    
        $('#states').css({
          'border': '1px solid #e2e2e2'
        });
    }

    if(address1.trim() == '')
    {
        $('#address1').css({
          'border': '1px solid red'
        });
    }
    else  
    {    
        $('#address1').css({
          'border': '1px solid #e2e2e2'
        });
    }

});


</script>