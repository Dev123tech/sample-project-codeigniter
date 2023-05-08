<link href="https://fonts.googleapis.com/css2?family=Varela+Round&display=swap" rel="stylesheet">
    <div class="offcanvas-overlay"></div>
    <!-- Breadcrumb Area Start -->
        <div class="breadcrumb-area">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="breadcrumb-content">
                            <ul class="nav">
                                <li><a href="<?php echo base_url(); ?>">Home</a></li>
                                <li><?php 
                                    if($type=='Vendor_Agreements'){
                                        echo translate('terms_&_condition');
                                    }
                                    elseif($type=='privacy_policy'){
                                        echo translate('privacy_policy');
                                    }

                                   elseif($type=='terms_conditions'){
                                            
                                     echo translate('terms_&_condition');

                                    }
                                    ?>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <!-- Breadcrumb Area End-->
<!-- /BREADCRUMBS -->

<!-- PAGE -->
<section class="innerpageblock">
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <div class="block-title v-line mb-35"style="margin-left: 20%">
                     <h2><?php 
                            if($type=='Vendor_Agreements'){
                                echo translate('Vendor Agreement');
                            }
                            elseif($type=='privacy_policy'){
                                echo translate('privacy_policy');
                            }
                            
                           elseif($type=='terms_conditions'){
                                echo translate('terms_&_condition');
                               

                            }

                        ?></h2>
                     <p>The users of this website <b>"omgee.com.au"</b> are suggested to read our <?php 
                            if($type=='Vendor_Agreements'){
                                echo translate('terms_&_condition');
                            }
                            elseif($type=='privacy_policy'){
                                echo translate('privacy_policy');
                            }
                        ?> carefully.</p>
                </div>
            </div>
            <div class="col-lg-8 col-md-12 col-sm-12 col-xs-12 innermain"style="margin-left: 20%">
                <?php echo $this->db->get_where('general_settings', array( 'type' => $type ))->row()->value; ?>
            </div>
           <!-- <div class="col-lg-4 col-md-12 col-sm-12 col-xs-12">
                <div class="faq_quick_link">
                    <h4>Quick Links</h4>
                    <ul class="one-half">
                        <li><a href="<?php echo base_url(); ?>home/legal/terms_conditions">Terms &amp; Conditions</a></li>
                        <li><a href="<?php echo base_url(); ?>home/affiliate">Affiliate</a></li>
                    </ul>
                    <ul class="one-half">
                        <li><a href="<?php echo base_url(); ?>home/how_omgee_work">How Omgee Works</a></li>
                        <li><a href="#">OMGee Careers</a></li>
                    </ul>
                </div>
            </div>  -->   
        </div>
    </div>
</section>
<!-- /PAGE -->