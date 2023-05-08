<?php 
	foreach($vendor_data as $row)
	{ 
?>
    <div id="content-container" style="padding-top:0px !important;">
        <div class="text-center pad-all">
            <div class="pad-ver">
                <?php
                    if(file_exists('uploads/vendor_logo_image/logo_'.$row['vendor_id'].'.png')){
                ?>
                <img class="img-sm img-border"
                    src="<?php echo base_url(); ?>uploads/vendor_logo_image/logo_<?php echo $row['vendor_id']; ?>.png" />  
                <?php
                    } else {
                ?>
                <img class="img-sm img-border"
                    src="<?php echo base_url(); ?>uploads/vendor_logo_image/default.jpg" alt="">
                <?php
                    }
                ?>
            </div>
            <h4 class="text-lg text-overflow mar-no"><?php echo ucwords($row['name']);?></h4>
            <p class="text-sm"><?php echo translate('vendor');?></p>
            <div class="pad-ver btn-group">
                <?php if($row['facebook'] != ''){ ?>
                    <a href="<?php echo $row['facebook'];?>" target="_blank" class="btn btn-icon btn-hover-primary fa fa-facebook icon-lg"></a>
                <?php } if($row['skype'] != ''){ ?>
                    <a href="<?php echo $row['skype'];?>" target="_blank" class="btn btn-icon btn-hover-info fa fa-twitter icon-lg"></a>
                <?php } if($row['google_plus'] != ''){ ?>
                    <a href="<?php echo $row['google_plus'];?>" target="_blank" class="btn btn-icon btn-hover-danger fa fa-google-plus icon-lg"></a>
                <?php } ?>
                <a href="mailto:<?php echo $row['email']; ?>" class="btn btn-icon btn-hover-mint fa fa-envelope icon-lg"></a>
            </div>
            <hr>
        </div>
    
    
    <div class="row">
        <div class="col-sm-12">
            <div class="panel-body">
                <table class="table table-striped" style="border-radius:3px;">
                    <tr>
                        <th class="custom_td"><?php echo translate('name');?></th>
                        <td class="custom_td"><?php echo ucwords($row['name']);?></td>
                    </tr>
                    <tr>
                        <th class="custom_td"><?php echo translate('company');?></th>
                        <td class="custom_td"><?php echo ucwords($row['company']);?></td>
                    </tr>
                    <tr>
                        <th class="custom_td"><?php echo translate('email');?></th>
                        <td class="custom_td"><?php echo $row['email'];?></td>
                    </tr>
                    <tr>
                        <th class="custom_td"><?php echo translate('address');?></th>
                        <td class="custom_td">
                            <?php echo ucwords($row['address1']);?><br>
                            <?php echo ucwords($row['address2']);?>
                        </td>
                    </tr>
                    <tr>
                        <th class="custom_td"><?php echo translate('phone');?></th>
                        <td class="custom_td"><?php echo $row['phone']?></td>
                    </tr>
                    <?php if($row['skype'] != ''){ ?>
                    <tr>
                        <th class="custom_td"><?php echo translate('skype');?></th>
                        <td class="custom_td"><?php echo $row['skype']?></td>
                    </tr>
                    <?php } if($row['facebook'] != ''){ ?>
                    <tr>
                        <th class="custom_td"><?php echo translate('facebook');?></th>
                        <td class="custom_td"><?php echo $row['facebook']?></td>
                    </tr>
                    <?php } if($row['google_plus'] != ''){ ?>
                    <tr>
                        <th class="custom_td"><?php echo translate('google_plus');?></th>
                        <td class="custom_td"><?php echo $row['google_plus']?></td>
                    </tr>
                    <?php } ?>
                    <tr>
                        <th class="custom_td"><?php echo translate('creation_date');?></th>
                        <td class="custom_td"><?php echo date('d M,Y',$row['create_timestamp']);?></td>
                    </tr>
                    <?php if($row['membership'] != 0){ ?>
                    <tr>
                        <th class="custom_td"><?php echo translate('membership');?></th>
                        <td class="custom_td"><?php echo $this->crud_model->get_type_name_by_id('membership', $row['membership'], 'title')?></td>
                    </tr>
                    <?php } ?>
                    <?php if($row['google_plus'] != 0){ ?>
                    <tr>
                        <th class="custom_td"><?php echo translate('google_plus');?></th>
                        <td class="custom_td"><?php echo $row['google_plus']?></td>
                    </tr>
                    
                    <!-- bank detail -->
                    <?php } if($row['bank_name']){ ?>
                    <tr>
                        <th class="custom_td"><?php echo translate('bank_name');?></th>
                        <td class="custom_td"><?php echo ucwords($row['bank_name']);?></td>
                    </tr>
                    
                    <?php } if($row['account_name']){ ?>
                    <tr>
                        <th class="custom_td"><?php echo translate('account_name');?></th>
                        <td class="custom_td"><?php echo $row['account_name'];?></td>
                    </tr>
                   
                    <?php } if($row['bank_account_number']){ ?>
                    <tr>
                        <th class="custom_td"><?php echo translate('bank_account_number');?></th>
                        <td class="custom_td"><?php echo ucwords($row['bank_account_number']);?></td>
                    </tr>
                    
                    <?php } if($row['bsb_number']){ ?>
                    <tr>
                        <th class="custom_td"><?php echo translate('bsb_number');?></th>
                        <td class="custom_td"><?php echo $row['bsb_number'];?></td>
                    </tr>

                    <!-- Additional field -->
                    <?php } if($row['acn_and_abn']){ ?>
                    <tr>
                        <th class="custom_td"><?php echo translate('acn_and_abn');?></th>
                        <td class="custom_td"><?php echo $row['acn_and_abn'];?></td>
                    </tr>
                    <?php } if($row['trading_name']){ ?>
                    <tr>
                        <th class="custom_td"><?php echo translate('trading_name');?></th>
                        <td class="custom_td"><?php echo ucwords($row['trading_name']);?></td>
                    </tr>

                    <?php } if($row['license_number']){ ?>
                    <tr>
                        <th class="custom_td"><?php echo translate('license_number');?></th>
                        <td class="custom_td"><?php echo ucwords($row['license_number']);?></td>
                    </tr>

                    <?php } if($row['contact_person']){ ?>
                    <tr>
                        <th class="custom_td"><?php echo translate('contact_person');?></th>
                        <td class="custom_td"><?php echo ucwords($row['contact_person']);?></td>
                    </tr>

                    <?php } if($row['direct_number']){ ?>
                    <tr>
                        <th class="custom_td"><?php echo translate('direct_number');?></th>
                        <td class="custom_td"><?php echo $row['direct_number'];?></td>
                    </tr>

                    <?php } if($row['mobile_number']){ ?>
                    <tr>
                        <th class="custom_td"><?php echo translate('mobile_number');?></th>
                        <td class="custom_td"><?php echo $row['mobile_number'];?></td>
                    </tr>

                    <?php } if($row['direct_email']){ ?>
                    <tr>
                        <th class="custom_td"><?php echo translate('direct_email');?></th>
                        <td class="custom_td"><?php echo $row['direct_email'];?></td>
                    </tr>
                    <?php } ?>
                </table>
              </div>
            </div>
        </div>					
    </div>					
<?php 
	}
?>
            
<style>
.custom_td{
border-left: 1px solid #ddd;
border-right: 1px solid #ddd;
border-bottom: 1px solid #ddd;
}
</style>
<script type="text/javascript">
    $(document).ready(function(){
        $('.enterer').hide();
    });
</script>