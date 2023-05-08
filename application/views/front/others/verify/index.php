<style type="text/css">
   .thank_you:hover{
          box-shadow: 15px 16px 19px #071143;
   }
   .thank_you{
      background: #fff;
    border-radius: 10px;
    text-align: center;
    padding: 28px 128px;
    margin-bottom: 5%;
   }
   .thank_you h4{
         color: #b8870d;
    margin-bottom: 10px;
    margin-top: 15px;
   }
    .thank_you p{
      color: #696969;
    margin-bottom: 20px;
    font-size: 15px;
   }
   .thank_you .btnyes{
          padding: 6px 21px;
   }
   .thank_you .btnno{
      padding: 6px 48px;
   }
   .thank_you .bouncenew{
          height: 90px;
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
                  <li><a href="<?php echo base_url(); ?>">Home</a></li>
                  <li><?php echo $page_title; ?></li>
               </ul>
            </div>
         </div>
      </div>
   </div>
</div>
<!-- Breadcrumb Area End-->
<!-- Thank You Main Section -->
<section>
   <div class="container">
      <div class="row">
         <div class="col-sm-6 offset-sm-3">
            <div class="thank_you">
               <img class="img-responsive" src="<?php echo base_url(); ?>/template/omgee/images/iconfindericon/email-verification.png">
               <h4>Email Verified Successfully</h4>
               <a href="<?php echo base_url('home/login_set/login'); ?>"><button type="button" class="btn btnyes">Login</button></a>
            </div>
         </div>
      </div>
   </div>
</section>
<!-- end -->