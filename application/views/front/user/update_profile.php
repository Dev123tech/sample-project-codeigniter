<?php
    foreach($user_info as $row)
    {
?>
    <div class="information-title">
        <?php echo translate('profile_information');?>
    </div>
    
    <div class="details-wrap profileedit">
        <div class="row">
            <div class="col-md-12">
                <div class="tabs-wrapper content-tabs">
                    <ul class="nav nav-tabs">
                        <li class="active">
                            <a href="#tab1" data-toggle="tab">
                                <?php echo translate('personal_info');?>
                            </a>
                        </li>
                        <li>
                            <a href="#tab2" data-toggle="tab">
                                <?php echo translate('change_password');?>
                            </a>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane fade in active" id="tab1">
                             <div class="details-wrap">
                                <div class="block-title alt"> 
                                    <i class="fa fa-angle-down"></i> 
                                    <?php echo translate('change_your_profile_information');?>
                                </div>
                                <div class="details-box">
                                    <?php
                                        echo form_open(base_url() . 'home/registration/update_info/', array(
                                            'class' => 'form-login',
                                            'method' => 'post',
                                            'enctype' => 'multipart/form-data'
                                        ));
                                    ?>    
                                        <div class="row">

                                            <div class="col-lg-3 col-md-12 col-sm-12 col-xs-12">
                                                <div class="form-group">
                                                    <label>Title Name</label>
                                                    <select class="form-control" name="titlename" >
                                                            <option value="<?php echo $row['titlename']; ?>" > <?php echo $row['titlename']; ?> </option>
                                                            <option value="Mr" selected><?php echo translate('mr');?></option>
                                                            <option value="Mrs"><?php echo translate('mrs');?></option>
                                                    </select>
                                                    
                                                </div>
                                            </div>
                                            <div class="col-lg-9 col-md-12 col-sm-12 col-xs-12">
                                                <div class="form-group">
                                                    <label>Full Name</label>
                                                    <input type="text" name="username" value="<?php echo $row['username']; ?>" placeholder="Enter Your <?php echo translate('full_name');?>" class="form-control" required>
                                                </div>
                                            </div>
                                         
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Email Address</label>
                                                    <input type="email" name="email" value="<?php echo $row['email']; ?>" class="form-control" placeholder="Enter <?php echo translate('email');?>" >
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Country Code</label>
                                                    <select class="form-control" name="country" required >
                                                        <option><?php echo $row['countrycode']; ?></option>
                                                        <?php
                                                            if($row['countrycode'] != "61")
                                                            {
                                                        ?>        
                                                               <option value="61">(+61) Australia</option>
                                                        <?php
                                                            }
                                                            else if($row['countrycode'] != "81"){
                                                        ?>     
                                                                <option value="81">(+81) Japan</option>
                                                        <?php
                                                            }
                                                            else if($row['countrycode'] != "852"){
                                                        ?>            
                                                               <option value="852">(+852) Hong Kong </option>
                                                        <?php
                                                            }
                                                            else if($row['countrycode'] != "65"){
                                                        ?>   
                                                                 <option value="65">(+65) Singapore</option>       
                                                        <?php
                                                            }
                                                        ?>
                                                        
                                                        <option value="Hongkong">Hong Kong</option >
                                                        <option value="Singapore">Singapore</option >
                                                        <option value="Japan">Japan</option >
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Phone Number</label>
                                                    <input type="text" name="phone" value="<?php echo $row['phone']; ?>" placeholder="123-123-1234" class="form-control"  placeholder="<?php echo translate('phone');?>" onkeypress="isInputNumber(event)">
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Country</label>
                                                    <select class="form-control" name="country" required >
                                                        <option value="<?php echo $row['country']; ?>"><?php echo $row['country']; ?> </option>
                                                        <option value="Australia">Australia</option >
                                                        <option value="Hongkong">Hong Kong</option >
                                                        <option value="Singapore">Singapore</option >
                                                        <option value="Japan">Japan</option >
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Date of Birth</label>
                                                    <input type="date" name="dob" value="<?php echo $row['dob']; ?>" class="form-control" required>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Profile Image</label>
                                                    <input type="file" name="profile_image" value="" class="form-control" >
                                                    <input type="hidden" name="last_profile_image" value="<?php echo $row['profile_image']; ?>">
                                                </div>
                                            </div>
                                           
                                            <div class="col-md-12">
                                                <span class="btn btn-theme pull-right signup_btn" data-unsuccessful='<?php echo translate('info_update_unsuccessful!'); ?>' data-success='<?php echo translate('info_updated_successfully!'); ?>' data-ing='<?php echo translate('updating..') ?>' >
                                                    <?php echo translate('update');?>
                                                </span>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>   
                        </div>
                        <div class="tab-pane fade" id="tab2">
                            <div class="details-wrap">
                                <div class="block-title alt"> <i class="fa fa-angle-down"></i> <?php echo translate('change_your_password');?></div>
                                <div class="details-box">
                                    <?php
                                        echo form_open(base_url() . 'home/registration/update_password/', array(
                                            'class' => 'form-delivery',
                                            'method' => 'post',
                                            'enctype' => 'multipart/form-data'
                                        ));
                                    ?> 
                                        <div class="row">
                                            <div class="col-md-12 col-sm-12">
                                                <div class="form-group"><input required name="password" type="password" placeholder="<?php echo translate('old_password');?>" class="form-control"></div>
                                            </div>
                                            <div class="col-md-6 col-sm-6">
                                                <div class="form-group"><input required name="password1" type="password" placeholder="<?php echo translate('new_password');?>" class="form-control"></div>
                                            </div>
                                            <div class="col-md-6 col-sm-6">
                                                <div class="form-group"><input required name="password2" type="password" placeholder="<?php echo translate('confirm_new_password');?>" class="form-control"></div>
                                            </div>
                                            <div class="col-md-12 col-sm-12">
                                                <span class="btn btn-theme pull-right signup_btn" data-unsuccessful='<?php echo translate('password_change_unsuccessful!'); ?>' data-success='<?php echo translate('password_changed_successfully!'); ?>' data-ing='<?php echo translate('updating..') ?>' >
                                                    <?php echo translate('update');?> 
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>  
<?php
    }
?>
   <script>
            
        function isInputNumber(evt){
            var ch = String.fromCharCode(evt.which);
            if(!(/[0-9]/.test(ch))){
                evt.preventDefault();
            }
        }
            
    </script>   
                                   