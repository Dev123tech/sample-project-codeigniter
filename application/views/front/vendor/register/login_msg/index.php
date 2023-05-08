

<style type="text/css">
    .thankyou{
          
    margin:2% 0;
    
    }
    .thankyou .maintitle h4{
        font-size: 50px;
    color: #071144;
    font-weight: 700;
    padding-bottom: 5px;
    margin-bottom: 7px;
    }
    .thankyou .maintitle p {
        font-size: 26px;
        color: #b8870d;
    padding-bottom: 6px;
    }
   
      .thankyoublock {
    box-shadow: 0px 5px 79px 0px rgb(34 51 136);
    background: #fff;
    padding: 19px 57px;
    text-align: center;
    border-radius: 14px;
    }
    .thankyouimg img{
            height: 75px;

    }
    .thankyoubtn{
            text-align: center;
    color: #0f0c29;
    border-radius: 0 5px 5px 0;
    border: 0;
    transition: all .3s linear;
    background-image: linear-gradient(to right, #c8a233 0%, #f6da76 51%, #c8a233 100%) !important;
    width: 200px;
    font-weight: bold;
    height: 50px;
    margin-top: 64px;
    }
    .thankyoubtn:hover{
        background-image: linear-gradient(to right, #c8a233 20%, #f6da76 35%, #c8a233 88%) !important;
    }
    .shape2{
    position: absolute;
    left: 20%;
    top: 5%;
    z-index: 99;
    opacity: 0.6;

    }
    .shape5 {
        position: absolute;
    right : 20%;
    top: 5%;
    z-index: 99;
    opacity: 0.6;
    }
    .shape2 img, .shape5 img{
        height: 70px;
    }
</style>
    <div class="offcanvas-overlay"></div>
    <!-- Breadcrumb Area Start -->
        <div class="breadcrumb-area">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="breadcrumb-content">
                            <ul class="nav">
                                <li><a href="index.html">Home</a></li>
                                <li>Account</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <!-- Breadcrumb Area End-->
<section class="thankyou">
    <div class="container">
        <div class="row">
            <div class="col-sm-6 offset-sm-3">
                <div class="thankyoublock">
                    <div class="shape2" id="loading"><img src="<?php echo base_url(); ?>/template/omgee/images/iconfindericon/beer.png" alt="image"></div>
                    <div class="shape5" id="loading"><img src="<?php echo base_url(); ?>/template/omgee/images/iconfindericon/wine.png" alt="image"></div>
                <div class="thankyouimg">
                    <img src="<?php echo base_url(); ?>/template/omgee/images/iconfindericon/thankyou.png">
                </div>
                <div class="maintitle">
                    <h4><?php echo translate('Thank you for registering with OMGee.')?></h4>
                    <p> <?php echo translate('Your request is now being reviewed by administration team. 
Please allow 3 to 5 business days for approval

.');?> <br>
                            <?php echo translate('Upon approval, you will receive a confirmation email and access to your portal.');?>
                            <br>
                            <?php echo translate('Please email the administration team if you have any further question. ');?>.
                            <?php echo translate('Looking forward to welcoming you on-board and Thank you for your support');?></p>
                </div>
                <div class="row">
                    <div class="col-sm-7">
                        <img src="<?php echo base_url(); ?>/template/omgee/images/iconfindericon/thankyoufooter.png" class="img-responsive">
                    </div>
                    <div class="col-sm-5">
                       <!-- <a href="<?php echo base_url();?>vendor"><button type="button" class="btn thankyoubtn"><?php echo translate('login_from_here');?></button></a> -->
                    </div>
                </div>
            </div>
            </div>
        </div>
    </div>
</section>