<?php
    $this->session->unset_userdata('total_cashback_discount');
?>

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
                  <li><a href="index.html">Home</a></li>
                  <li>Thank You</li>
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
               <img class="bouncenew" src="<?php echo base_url(); ?>template/omgee/images/iconfindericon/thankyoucheck.png">
               <h4>Congrats! Your Order Has been Completed..</h4>
               <p>Your Order has been successsfully placed, You soon will get a message regarding order status. Thank you for choosing OMGee</p>
               <a href="<?php echo base_url(); ?>"><button type="button" class="btn btnyes">Continue Shopping</button></a>
               <a href="<?php echo base_url('home/profile/'); ?>"><button type="button" class="btn btnno">My Order</button></a>
            </div>
         </div>
      </div>
   </div>
</section>
<!-- end -->
