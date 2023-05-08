<!-- PAGE -->
<?php
    $thumbs = $this->crud_model->file_view('product',$row['product_id'],'','','thumb','src','multi','all');
    $mains = $this->crud_model->file_view('product',$row['product_id'],'','','no','src','multi','all'); 
    $max_stock = $row['current_stock'] - ($row['bundle_qty1'] + $row['bundle_qty2'] + $row['bundle_qty3']);
?>
<style>
   .jzoom img { border:3px solid #fff;}
   .jzoom {
   position: relative;
   top: 0px;
   left: 100px;
   width: 350px;
   height: 350px;
   }
   h1 { margin-top:150px; margin-left:100px; color:#fff;}
   .zoomnew{
   position: relative;display: block;margin: 2% 0;
   }
   .pro_new_slider .swiper-slide {
   width: 115px !important;
   margin: 8px 10px !important;
   }
   .zoomLens {
   height: 30px !important;
   width: 30px !important;
   }
.zoompro{
  height: 400px !important;
  width: 400px !important;
  position: relative !important;
  margin: 0 auto !important;
      left: 79px !important;
}

.swiper-container {
z-index: 1 !important;
}
.tas_lik {
    margin-left: 20px !important;
    margin-top: 30px !important;
    margin-bottom: 17px !important;
}
</style>
<script src="<?php echo base_url(); ?>template/front/js/jzoom.min.js"></script>
 <div class="offcanvas-overlay"></div>
    <!-- Breadcrumb Area Start -->
    <div class="breadcrumb-area">
	   <div class="container">
	      <div class="row">
	         <div class="col-md-12">
	            <div class="breadcrumb-content">
	               <ul class="nav">
	                  <li><a href="i<?php echo base_url(); ?>">Home</a></li>
	                  <li>Product Detail</li>
	               </ul>
	            </div>
	         </div>
	      </div>
	   </div>
	</div>
    <!-- Breadcrumb Area End-->
  	<!-- Shop details Area start -->
    <section class="product-details-area mtb-10px">
	   	<div class="container">
	      <div class="row">
	         <div class="col-xl-6 col-lg-6 col-md-12">
	            <div class="product-details-img product-details-tab">
	               <div class="zoompro-2">
	                  <div class="zoompro-border zoompro-span">
	                  	<?php
                            $result = sizeof($mains); 
                            if($result > 0)
                            {
                                ?>
                     			<img class="zoompro" src="<?php echo $mains['0']; ?>" data-zoom-image="<?php echo $mains['0']; ?>" alt="">
                     		<?php
                            	}
                            ?>
	                  </div>
	               </div>
	               <div id="gallery" class="product-dec-slider-2 swiper-container pro_new_slider swiper-container-initialized swiper-container-horizontal">
	                  <div class="swiper-wrapper" style="transform: translate3d(0px, 0px, 0px);">
	                    <?php 
                            if($mains)
                            {
                            	$thumb_counter = 1;
                                foreach ($mains as $row1)
                                {
                                	if($thumb_counter == '1')
                                	{
                                		?>
					                    <div class="swiper-slide  swiper-slide-active" style="width: 145.75px; margin-right: 10px;">
					                        <a class="active" data-image="<?php echo $row1; ?>" data-zoom-image="<?php echo $row1; ?>">
					                        <img class="img-responsive" src="<?php echo $row1; ?>" alt="">
					                        </a>
					                    </div>
	                     			<?php 
	                 				}
	                 				elseif ($thumb_counter == '2') 
	                 				{
	                 					?>
					                    <div class="swiper-slide swiper-slide-next" style="width: 145.75px; margin-right: 10px;">
					                        <a data-image="<?php echo $row1; ?>" data-zoom-image="<?php echo $row1; ?>">
					                        <img class="img-responsive" src="<?php echo $row1; ?>" alt="">
					                        </a>
					                    </div>
				                    <?php 
				                 		}
				                 	else {
				                 		?>
				                 		<div class="swiper-slide" style="width: 145.75px; margin-right: 10px;">
					                        <a data-image="<?php echo $row1; ?>" data-zoom-image="<?php echo $row1; ?>">
					                        <img class="img-responsive" src="<?php echo $row1; ?>" alt="">
					                        </a>
					                    </div>
				                 	<?php } ?>	
	                      <?php $thumb_counter++; } } ?>
	                  </div>
	               <span class="swiper-notification" aria-live="assertive" aria-atomic="true"></span></div>
	            </div>
	            <?php
	            if($row['test_section'] == 'yes')
	            {
	            	?>
		            <!-- new section -->
		            <div class="section-title">
		               <h2 class="section-heading tas_lik"><?php echo ucwords($row['test_title']); ?></h2>
		            </div>
		            <?php  if($row['test1_name']) { ?>
	              	<div class="row tasteview">
	               		<div class="col-sm-2 tasteviewpar">
	                  		<p><?php echo ucwords($row['test1_name']); ?></p>
	               		</div>
		               	<div class="col-sm-8">
		                  <ul>
		                     <li>
		                        <div class="circle_orange <?php if($row['test1_number']=='1') { ?>circle_orangedark<?php } ?>  ">
		                          <?php if($row['test1_number']=='1') { ?><div class="sonar-wave"></div> <?php } ?>
		                           <p>1</p>
		                        </div>
		                     </li>
		                     <li>
		                        <div class="circle_orange <?php if($row['test1_number']=='2') { ?>circle_orangedark<?php } ?>">
		                        	<?php if($row['test1_number']=='2') { ?><div class="sonar-wave"></div> <?php } ?>
		                           <p>2</p>
		                        </div>
		                     </li>
		                     <li>
		                        <div class="circle_orange <?php if($row['test1_number']=='3') { ?>circle_orangedark<?php } ?>">
		                        	<?php if($row['test1_number']=='3') { ?><div class="sonar-wave"></div> <?php } ?>
		                           <p>3</p>
		                        </div>
		                     </li>
		                      <li>
		                        <div class="circle_orange <?php if($row['test1_number']=='4') { ?>circle_orangedark<?php } ?>">
		                        	<?php if($row['test1_number']=='4') { ?><div class="sonar-wave"></div> <?php } ?>
		                           <p>4</p>
		                        </div>
		                     </li>
		                     <li>
		                        <div class="circle_light_gr gr_first <?php if($row['test1_number']=='5') { ?>circle_light_grdark<?php } ?>">
		                        	<?php if($row['test1_number']=='5') { ?><div class="sonar-wave"></div> <?php } ?>
		                           <p>5</p>
		                        </div>
		                     </li>
		                     <li>
		                        <div class="circle_light_gr <?php if($row['test1_number']=='6') { ?>circle_light_grdark<?php } ?>">
		                        	<?php if($row['test1_number']=='6') { ?><div class="sonar-wave"></div> <?php } ?>
		                           <p>6</p>
		                        </div>
		                     </li>
		                     <li>
		                        <div class="circle_light_gr <?php if($row['test1_number']=='7') { ?>circle_light_grdark<?php } ?>">
		                        	<?php if($row['test1_number']=='7') { ?><div class="sonar-wave"></div> <?php } ?>
		                           <p>7</p>
		                        </div>
		                     </li>
		                     <li>
		                        <div class="circle_light_blue gr_first <?php if($row['test1_number']=='8') { ?>circle_light_bluedark<?php } ?>">
		                        	<?php if($row['test1_number']=='8') { ?><div class="sonar-wave"></div> <?php } ?>
		                           <p>8</p>
		                        </div>
		                     </li>
		                     <li>
		                        <div class="circle_light_blue <?php if($row['test1_number']=='9') { ?>circle_light_bluedark<?php } ?>">
		                        	<?php if($row['test1_number']=='9') { ?><div class="sonar-wave"></div> <?php } ?>
		                           <p>9</p>
		                        </div>
		                     </li>
		                     <li>
		                        <div class="circle_light_blue <?php if($row['test1_number']=='10') { ?>circle_light_bluedark<?php } ?>">
		                        	<?php if($row['test1_number']=='10') { ?><div class="sonar-wave"></div> <?php } ?>
		                           <p>10</p>
		                        </div>
		                     </li>
		                  </ul>
		               	</div>
	            	</div>
	            <?php } if($row['test11_name']) { ?>
	              	<div class="row tasteview">
	               		<div class="col-sm-2 tasteviewpar">
	                  		<p><?php echo ucwords($row['test11_name']); ?></p>
	               		</div>
		               	<div class="col-sm-8">
		                  <ul>
		                     <li>
		                        <div class="circle_orange <?php if($row['test11_number']=='1') { ?>circle_orangedark<?php } ?>  ">
		                          <?php if($row['test11_number']=='1') { ?><div class="sonar-wave"></div> <?php } ?>
		                           <p>1</p>
		                        </div>
		                     </li>
		                     <li>
		                        <div class="circle_orange <?php if($row['test11_number']=='2') { ?>circle_orangedark<?php } ?>">
		                        	<?php if($row['test11_number']=='2') { ?><div class="sonar-wave"></div> <?php } ?>
		                           <p>2</p>
		                        </div>
		                     </li>
		                     <li>
		                        <div class="circle_orange <?php if($row['test11_number']=='3') { ?>circle_orangedark<?php } ?>">
		                        	<?php if($row['test11_number']=='3') { ?><div class="sonar-wave"></div> <?php } ?>
		                           <p>3</p>
		                        </div>
		                     </li>
		                      <li>
		                        <div class="circle_orange <?php if($row['test11_number']=='4') { ?>circle_orangedark<?php } ?>">
		                        	<?php if($row['test11_number']=='4') { ?><div class="sonar-wave"></div> <?php } ?>
		                           <p>4</p>
		                        </div>
		                     </li>
		                     <li>
		                        <div class="circle_light_gr gr_first <?php if($row['test11_number']=='5') { ?>circle_light_grdark<?php } ?>">
		                        	<?php if($row['test11_number']=='5') { ?><div class="sonar-wave"></div> <?php } ?>
		                           <p>5</p>
		                        </div>
		                     </li>
		                     <li>
		                        <div class="circle_light_gr <?php if($row['test11_number']=='6') { ?>circle_light_grdark<?php } ?>">
		                        	<?php if($row['test11_number']=='6') { ?><div class="sonar-wave"></div> <?php } ?>
		                           <p>6</p>
		                        </div>
		                     </li>
		                     <li>
		                        <div class="circle_light_gr <?php if($row['test11_number']=='7') { ?>circle_light_grdark<?php } ?>">
		                        	<?php if($row['test11_number']=='7') { ?><div class="sonar-wave"></div> <?php } ?>
		                           <p>7</p>
		                        </div>
		                     </li>
		                     <li>
		                        <div class="circle_light_blue gr_first <?php if($row['test11_number']=='8') { ?>circle_light_bluedark<?php } ?>">
		                        	<?php if($row['test11_number']=='8') { ?><div class="sonar-wave"></div> <?php } ?>
		                           <p>8</p>
		                        </div>
		                     </li>
		                     <li>
		                        <div class="circle_light_blue <?php if($row['test11_number']=='9') { ?>circle_light_bluedark<?php } ?>">
		                        	<?php if($row['test11_number']=='9') { ?><div class="sonar-wave"></div> <?php } ?>
		                           <p>9</p>
		                        </div>
		                     </li>
		                     <li>
		                        <div class="circle_light_blue <?php if($row['test11_number']=='10') { ?>circle_light_bluedark<?php } ?>">
		                        	<?php if($row['test11_number']=='10') { ?><div class="sonar-wave"></div> <?php } ?>
		                           <p>10</p>
		                        </div>
		                     </li>
		                  </ul>
		               	</div>
	            	</div>
	            <?php } if($row['test2_name']) { ?>
	              	<div class="row tasteview">
	               		<div class="col-sm-2 tasteviewpar">
	                  		<p><?php echo ucwords($row['test2_name']); ?></p>
	               		</div>
		               	<div class="col-sm-8">
		                  <ul>
		                     <li>
		                        <div class="circle_orange <?php if($row['test2_number']=='1') { ?>circle_orangedark<?php } ?>  ">
		                          <?php if($row['test2_number']=='1') { ?><div class="sonar-wave"></div> <?php } ?>
		                           <p>1</p>
		                        </div>
		                     </li>
		                     <li>
		                        <div class="circle_orange <?php if($row['test2_number']=='2') { ?>circle_orangedark<?php } ?>">
		                        	<?php if($row['test2_number']=='2') { ?><div class="sonar-wave"></div> <?php } ?>
		                           <p>2</p>
		                        </div>
		                     </li>
		                     <li>
		                        <div class="circle_orange <?php if($row['test2_number']=='3') { ?>circle_orangedark<?php } ?>">
		                        	<?php if($row['test2_number']=='3') { ?><div class="sonar-wave"></div> <?php } ?>
		                           <p>3</p>
		                        </div>
		                     </li>
		                      <li>
		                        <div class="circle_orange <?php if($row['test2_number']=='4') { ?>circle_orangedark<?php } ?>">
		                        	<?php if($row['test2_number']=='4') { ?><div class="sonar-wave"></div> <?php } ?>
		                           <p>4</p>
		                        </div>
		                     </li>
		                     <li>
		                        <div class="circle_light_gr gr_first <?php if($row['test2_number']=='5') { ?>circle_light_grdark<?php } ?>">
		                        	<?php if($row['test2_number']=='5') { ?><div class="sonar-wave"></div> <?php } ?>
		                           <p>5</p>
		                        </div>
		                     </li>
		                     <li>
		                        <div class="circle_light_gr <?php if($row['test2_number']=='6') { ?>circle_light_grdark<?php } ?>">
		                        	<?php if($row['test2_number']=='6') { ?><div class="sonar-wave"></div> <?php } ?>
		                           <p>6</p>
		                        </div>
		                     </li>
		                     <li>
		                        <div class="circle_light_gr <?php if($row['test2_number']=='7') { ?>circle_light_grdark<?php } ?>">
		                        	<?php if($row['test2_number']=='7') { ?><div class="sonar-wave"></div> <?php } ?>
		                           <p>7</p>
		                        </div>
		                     </li>
		                     <li>
		                        <div class="circle_light_blue gr_first <?php if($row['test2_number']=='8') { ?>circle_light_bluedark<?php } ?>">
		                        	<?php if($row['test2_number']=='8') { ?><div class="sonar-wave"></div> <?php } ?>
		                           <p>8</p>
		                        </div>
		                     </li>
		                     <li>
		                        <div class="circle_light_blue <?php if($row['test2_number']=='9') { ?>circle_light_bluedark<?php } ?>">
		                        	<?php if($row['test2_number']=='9') { ?><div class="sonar-wave"></div> <?php } ?>
		                           <p>9</p>
		                        </div>
		                     </li>
		                     <li>
		                        <div class="circle_light_blue <?php if($row['test2_number']=='10') { ?>circle_light_bluedark<?php } ?>">
		                        	<?php if($row['test2_number']=='10') { ?><div class="sonar-wave"></div> <?php } ?>
		                           <p>10</p>
		                        </div>
		                     </li>
		                  </ul>
		               	</div>
	            	</div>
	            <?php } if($row['test22_name']) { ?>
	              	<div class="row tasteview">
	               		<div class="col-sm-2 tasteviewpar">
	                  		<p><?php echo ucwords($row['test22_name']); ?></p>
	               		</div>
		               	<div class="col-sm-8">
		                  <ul>
		                     <li>
		                        <div class="circle_orange <?php if($row['test22_number']=='1') { ?>circle_orangedark<?php } ?>  ">
		                          <?php if($row['test22_number']=='1') { ?><div class="sonar-wave"></div> <?php } ?>
		                           <p>1</p>
		                        </div>
		                     </li>
		                     <li>
		                        <div class="circle_orange <?php if($row['test22_number']=='2') { ?>circle_orangedark<?php } ?>">
		                        	<?php if($row['test22_number']=='2') { ?><div class="sonar-wave"></div> <?php } ?>
		                           <p>2</p>
		                        </div>
		                     </li>
		                     <li>
		                        <div class="circle_orange <?php if($row['test22_number']=='3') { ?>circle_orangedark<?php } ?>">
		                        	<?php if($row['test22_number']=='3') { ?><div class="sonar-wave"></div> <?php } ?>
		                           <p>3</p>
		                        </div>
		                     </li>
		                      <li>
		                        <div class="circle_orange <?php if($row['test22_number']=='4') { ?>circle_orangedark<?php } ?>">
		                        	<?php if($row['test22_number']=='4') { ?><div class="sonar-wave"></div> <?php } ?>
		                           <p>4</p>
		                        </div>
		                     </li>
		                     <li>
		                        <div class="circle_light_gr gr_first <?php if($row['test22_number']=='5') { ?>circle_light_grdark<?php } ?>">
		                        	<?php if($row['test22_number']=='5') { ?><div class="sonar-wave"></div> <?php } ?>
		                           <p>5</p>
		                        </div>
		                     </li>
		                     <li>
		                        <div class="circle_light_gr <?php if($row['test22_number']=='6') { ?>circle_light_grdark<?php } ?>">
		                        	<?php if($row['test22_number']=='6') { ?><div class="sonar-wave"></div> <?php } ?>
		                           <p>6</p>
		                        </div>
		                     </li>
		                     <li>
		                        <div class="circle_light_gr <?php if($row['test22_number']=='7') { ?>circle_light_grdark<?php } ?>">
		                        	<?php if($row['test22_number']=='7') { ?><div class="sonar-wave"></div> <?php } ?>
		                           <p>7</p>
		                        </div>
		                     </li>
		                     <li>
		                        <div class="circle_light_blue gr_first <?php if($row['test22_number']=='8') { ?>circle_light_bluedark<?php } ?>">
		                        	<?php if($row['test22_number']=='8') { ?><div class="sonar-wave"></div> <?php } ?>
		                           <p>8</p>
		                        </div>
		                     </li>
		                     <li>
		                        <div class="circle_light_blue <?php if($row['test22_number']=='9') { ?>circle_light_bluedark<?php } ?>">
		                        	<?php if($row['test22_number']=='9') { ?><div class="sonar-wave"></div> <?php } ?>
		                           <p>9</p>
		                        </div>
		                     </li>
		                     <li>
		                        <div class="circle_light_blue <?php if($row['test22_number']=='10') { ?>circle_light_bluedark<?php } ?>">
		                        	<?php if($row['test22_number']=='10') { ?><div class="sonar-wave"></div> <?php } ?>
		                           <p>10</p>
		                        </div>
		                     </li>
		                  </ul>
		               	</div>
	            	</div>
	            <?php } if($row['test3_name']) { ?>
	              	<div class="row tasteview">
	               		<div class="col-sm-2 tasteviewpar">
	                  		<p><?php echo ucwords($row['test3_name']); ?></p>
	               		</div>
		               	<div class="col-sm-8">
		                  <ul>
		                     <li>
		                        <div class="circle_orange <?php if($row['test3_number']=='1') { ?>circle_orangedark<?php } ?>  ">
		                          <?php if($row['test3_number']=='1') { ?><div class="sonar-wave"></div> <?php } ?>
		                           <p>1</p>
		                        </div>
		                     </li>
		                     <li>
		                        <div class="circle_orange <?php if($row['test3_number']=='2') { ?>circle_orangedark<?php } ?>">
		                        	<?php if($row['test3_number']=='2') { ?><div class="sonar-wave"></div> <?php } ?>
		                           <p>2</p>
		                        </div>
		                     </li>
		                     <li>
		                        <div class="circle_orange <?php if($row['test3_number']=='3') { ?>circle_orangedark<?php } ?>">
		                        	<?php if($row['test3_number']=='3') { ?><div class="sonar-wave"></div> <?php } ?>
		                           <p>3</p>
		                        </div>
		                     </li>
		                      <li>
		                        <div class="circle_orange <?php if($row['test3_number']=='4') { ?>circle_orangedark<?php } ?>">
		                        	<?php if($row['test3_number']=='4') { ?><div class="sonar-wave"></div> <?php } ?>
		                           <p>4</p>
		                        </div>
		                     </li>
		                     <li>
		                        <div class="circle_light_gr gr_first <?php if($row['test3_number']=='5') { ?>circle_light_grdark<?php } ?>">
		                        	<?php if($row['test3_number']=='5') { ?><div class="sonar-wave"></div> <?php } ?>
		                           <p>5</p>
		                        </div>
		                     </li>
		                     <li>
		                        <div class="circle_light_gr <?php if($row['test3_number']=='6') { ?>circle_light_grdark<?php } ?>">
		                        	<?php if($row['test3_number']=='6') { ?><div class="sonar-wave"></div> <?php } ?>
		                           <p>6</p>
		                        </div>
		                     </li>
		                     <li>
		                        <div class="circle_light_gr <?php if($row['test3_number']=='7') { ?>circle_light_grdark<?php } ?>">
		                        	<?php if($row['test3_number']=='7') { ?><div class="sonar-wave"></div> <?php } ?>
		                           <p>7</p>
		                        </div>
		                     </li>
		                     <li>
		                        <div class="circle_light_blue gr_first <?php if($row['test3_number']=='8') { ?>circle_light_bluedark<?php } ?>">
		                        	<?php if($row['test3_number']=='8') { ?><div class="sonar-wave"></div> <?php } ?>
		                           <p>8</p>
		                        </div>
		                     </li>
		                     <li>
		                        <div class="circle_light_blue <?php if($row['test3_number']=='9') { ?>circle_light_bluedark<?php } ?>">
		                        	<?php if($row['test3_number']=='9') { ?><div class="sonar-wave"></div> <?php } ?>
		                           <p>9</p>
		                        </div>
		                     </li>
		                     <li>
		                        <div class="circle_light_blue <?php if($row['test3_number']=='10') { ?>circle_light_bluedark<?php } ?>">
		                        	<?php if($row['test3_number']=='10') { ?><div class="sonar-wave"></div> <?php } ?>
		                           <p>10</p>
		                        </div>
		                     </li>
		                  </ul>
		               	</div>
	            	</div>
	            <?php } if($row['test33_name']) { ?>
	              	<div class="row tasteview">
	               		<div class="col-sm-2 tasteviewpar">
	                  		<p><?php echo ucwords($row['test33_name']); ?></p>
	               		</div>
		               	<div class="col-sm-8">
		                  <ul>
		                     <li>
		                        <div class="circle_orange <?php if($row['test33_number']=='1') { ?>circle_orangedark<?php } ?>  ">
		                          <?php if($row['test33_number']=='1') { ?><div class="sonar-wave"></div> <?php } ?>
		                           <p>1</p>
		                        </div>
		                     </li>
		                     <li>
		                        <div class="circle_orange <?php if($row['test33_number']=='2') { ?>circle_orangedark<?php } ?>">
		                        	<?php if($row['test33_number']=='2') { ?><div class="sonar-wave"></div> <?php } ?>
		                           <p>2</p>
		                        </div>
		                     </li>
		                     <li>
		                        <div class="circle_orange <?php if($row['test33_number']=='3') { ?>circle_orangedark<?php } ?>">
		                        	<?php if($row['test33_number']=='3') { ?><div class="sonar-wave"></div> <?php } ?>
		                           <p>3</p>
		                        </div>
		                     </li>
		                      <li>
		                        <div class="circle_orange <?php if($row['test33_number']=='4') { ?>circle_orangedark<?php } ?>">
		                        	<?php if($row['test33_number']=='4') { ?><div class="sonar-wave"></div> <?php } ?>
		                           <p>4</p>
		                        </div>
		                     </li>
		                     <li>
		                        <div class="circle_light_gr gr_first <?php if($row['test33_number']=='5') { ?>circle_light_grdark<?php } ?>">
		                        	<?php if($row['test33_number']=='5') { ?><div class="sonar-wave"></div> <?php } ?>
		                           <p>5</p>
		                        </div>
		                     </li>
		                     <li>
		                        <div class="circle_light_gr <?php if($row['test33_number']=='6') { ?>circle_light_grdark<?php } ?>">
		                        	<?php if($row['test33_number']=='6') { ?><div class="sonar-wave"></div> <?php } ?>
		                           <p>6</p>
		                        </div>
		                     </li>
		                     <li>
		                        <div class="circle_light_gr <?php if($row['test33_number']=='7') { ?>circle_light_grdark<?php } ?>">
		                        	<?php if($row['test33_number']=='7') { ?><div class="sonar-wave"></div> <?php } ?>
		                           <p>7</p>
		                        </div>
		                     </li>
		                     <li>
		                        <div class="circle_light_blue gr_first <?php if($row['test33_number']=='8') { ?>circle_light_bluedark<?php } ?>">
		                        	<?php if($row['test33_number']=='8') { ?><div class="sonar-wave"></div> <?php } ?>
		                           <p>8</p>
		                        </div>
		                     </li>
		                     <li>
		                        <div class="circle_light_blue <?php if($row['test33_number']=='9') { ?>circle_light_bluedark<?php } ?>">
		                        	<?php if($row['test33_number']=='9') { ?><div class="sonar-wave"></div> <?php } ?>
		                           <p>9</p>
		                        </div>
		                     </li>
		                     <li>
		                        <div class="circle_light_blue <?php if($row['test33_number']=='10') { ?>circle_light_bluedark<?php } ?>">
		                        	<?php if($row['test33_number']=='10') { ?><div class="sonar-wave"></div> <?php } ?>
		                           <p>10</p>
		                        </div>
		                     </li>
		                  </ul>
		               	</div>
	            	</div>
	            <?php } if($row['test4_name']) { ?>
	              	<div class="row tasteview">
	               		<div class="col-sm-2 tasteviewpar">
	                  		<p><?php echo ucwords($row['test4_name']); ?></p>
	               		</div>
		               	<div class="col-sm-8">
		                  <ul>
		                     <li>
		                        <div class="circle_orange <?php if($row['test4_number']=='1') { ?>circle_orangedark<?php } ?>  ">
		                          <?php if($row['test4_number']=='1') { ?><div class="sonar-wave"></div> <?php } ?>
		                           <p>1</p>
		                        </div>
		                     </li>
		                     <li>
		                        <div class="circle_orange <?php if($row['test4_number']=='2') { ?>circle_orangedark<?php } ?>">
		                        	<?php if($row['test4_number']=='2') { ?><div class="sonar-wave"></div> <?php } ?>
		                           <p>2</p>
		                        </div>
		                     </li>
		                     <li>
		                        <div class="circle_orange <?php if($row['test4_number']=='3') { ?>circle_orangedark<?php } ?>">
		                        	<?php if($row['test4_number']=='3') { ?><div class="sonar-wave"></div> <?php } ?>
		                           <p>3</p>
		                        </div>
		                     </li>
		                      <li>
		                        <div class="circle_orange <?php if($row['test4_number']=='4') { ?>circle_orangedark<?php } ?>">
		                        	<?php if($row['test4_number']=='4') { ?><div class="sonar-wave"></div> <?php } ?>
		                           <p>4</p>
		                        </div>
		                     </li>
		                     <li>
		                        <div class="circle_light_gr gr_first <?php if($row['test4_number']=='5') { ?>circle_light_grdark<?php } ?>">
		                        	<?php if($row['test4_number']=='5') { ?><div class="sonar-wave"></div> <?php } ?>
		                           <p>5</p>
		                        </div>
		                     </li>
		                     <li>
		                        <div class="circle_light_gr <?php if($row['test4_number']=='6') { ?>circle_light_grdark<?php } ?>">
		                        	<?php if($row['test4_number']=='6') { ?><div class="sonar-wave"></div> <?php } ?>
		                           <p>6</p>
		                        </div>
		                     </li>
		                     <li>
		                        <div class="circle_light_gr <?php if($row['test4_number']=='7') { ?>circle_light_grdark<?php } ?>">
		                        	<?php if($row['test4_number']=='7') { ?><div class="sonar-wave"></div> <?php } ?>
		                           <p>7</p>
		                        </div>
		                     </li>
		                     <li>
		                        <div class="circle_light_blue gr_first <?php if($row['test4_number']=='8') { ?>circle_light_bluedark<?php } ?>">
		                        	<?php if($row['test4_number']=='8') { ?><div class="sonar-wave"></div> <?php } ?>
		                           <p>8</p>
		                        </div>
		                     </li>
		                     <li>
		                        <div class="circle_light_blue <?php if($row['test4_number']=='9') { ?>circle_light_bluedark<?php } ?>">
		                        	<?php if($row['test4_number']=='9') { ?><div class="sonar-wave"></div> <?php } ?>
		                           <p>9</p>
		                        </div>
		                     </li>
		                     <li>
		                        <div class="circle_light_blue <?php if($row['test4_number']=='10') { ?>circle_light_bluedark<?php } ?>">
		                        	<?php if($row['test4_number']=='10') { ?><div class="sonar-wave"></div> <?php } ?>
		                           <p>10</p>
		                        </div>
		                     </li>
		                  </ul>
		               	</div>
	            	</div>
	            <?php } if($row['test44_name']) { ?>
	              	<div class="row tasteview">
	               		<div class="col-sm-2 tasteviewpar">
	                  		<p><?php echo ucwords($row['test44_name']); ?></p>
	               		</div>
		               	<div class="col-sm-8">
		                  <ul>
		                     <li>
		                        <div class="circle_orange <?php if($row['test44_number']=='1') { ?>circle_orangedark<?php } ?>  ">
		                          <?php if($row['test44_number']=='1') { ?><div class="sonar-wave"></div> <?php } ?>
		                           <p>1</p>
		                        </div>
		                     </li>
		                     <li>
		                        <div class="circle_orange <?php if($row['test44_number']=='2') { ?>circle_orangedark<?php } ?>">
		                        	<?php if($row['test44_number']=='2') { ?><div class="sonar-wave"></div> <?php } ?>
		                           <p>2</p>
		                        </div>
		                     </li>
		                     <li>
		                        <div class="circle_orange <?php if($row['test44_number']=='3') { ?>circle_orangedark<?php } ?>">
		                        	<?php if($row['test44_number']=='3') { ?><div class="sonar-wave"></div> <?php } ?>
		                           <p>3</p>
		                        </div>
		                     </li>
		                      <li>
		                        <div class="circle_orange <?php if($row['test44_number']=='4') { ?>circle_orangedark<?php } ?>">
		                        	<?php if($row['test44_number']=='4') { ?><div class="sonar-wave"></div> <?php } ?>
		                           <p>4</p>
		                        </div>
		                     </li>
		                     <li>
		                        <div class="circle_light_gr gr_first <?php if($row['test44_number']=='5') { ?>circle_light_grdark<?php } ?>">
		                        	<?php if($row['test44_number']=='5') { ?><div class="sonar-wave"></div> <?php } ?>
		                           <p>5</p>
		                        </div>
		                     </li>
		                     <li>
		                        <div class="circle_light_gr <?php if($row['test44_number']=='6') { ?>circle_light_grdark<?php } ?>">
		                        	<?php if($row['test44_number']=='6') { ?><div class="sonar-wave"></div> <?php } ?>
		                           <p>6</p>
		                        </div>
		                     </li>
		                     <li>
		                        <div class="circle_light_gr <?php if($row['test44_number']=='7') { ?>circle_light_grdark<?php } ?>">
		                        	<?php if($row['test44_number']=='7') { ?><div class="sonar-wave"></div> <?php } ?>
		                           <p>7</p>
		                        </div>
		                     </li>
		                     <li>
		                        <div class="circle_light_blue gr_first <?php if($row['test44_number']=='8') { ?>circle_light_bluedark<?php } ?>">
		                        	<?php if($row['test44_number']=='8') { ?><div class="sonar-wave"></div> <?php } ?>
		                           <p>8</p>
		                        </div>
		                     </li>
		                     <li>
		                        <div class="circle_light_blue <?php if($row['test44_number']=='9') { ?>circle_light_bluedark<?php } ?>">
		                        	<?php if($row['test44_number']=='9') { ?><div class="sonar-wave"></div> <?php } ?>
		                           <p>9</p>
		                        </div>
		                     </li>
		                     <li>
		                        <div class="circle_light_blue <?php if($row['test44_number']=='10') { ?>circle_light_bluedark<?php } ?>">
		                        	<?php if($row['test44_number']=='10') { ?><div class="sonar-wave"></div> <?php } ?>
		                           <p>10</p>
		                        </div>
		                     </li>
		                  </ul>
		               	</div>
	            	</div>
	            <?php } if($row['test5_name']) { ?>
	              	<div class="row tasteview">
	               		<div class="col-sm-2 tasteviewpar">
	                  		<p><?php echo ucwords($row['test5_name']); ?></p>
	               		</div>
		               	<div class="col-sm-8">
		                  <ul>
		                     <li>
		                        <div class="circle_orange <?php if($row['test5_number']=='1') { ?>circle_orangedark<?php } ?>  ">
		                          <?php if($row['test5_number']=='1') { ?><div class="sonar-wave"></div> <?php } ?>
		                           <p>1</p>
		                        </div>
		                     </li>
		                     <li>
		                        <div class="circle_orange <?php if($row['test5_number']=='2') { ?>circle_orangedark<?php } ?>">
		                        	<?php if($row['test5_number']=='2') { ?><div class="sonar-wave"></div> <?php } ?>
		                           <p>2</p>
		                        </div>
		                     </li>
		                     <li>
		                        <div class="circle_orange <?php if($row['test5_number']=='3') { ?>circle_orangedark<?php } ?>">
		                        	<?php if($row['test5_number']=='3') { ?><div class="sonar-wave"></div> <?php } ?>
		                           <p>3</p>
		                        </div>
		                     </li>
		                      <li>
		                        <div class="circle_orange <?php if($row['test5_number']=='4') { ?>circle_orangedark<?php } ?>">
		                        	<?php if($row['test5_number']=='4') { ?><div class="sonar-wave"></div> <?php } ?>
		                           <p>4</p>
		                        </div>
		                     </li>
		                     <li>
		                        <div class="circle_light_gr gr_first <?php if($row['test5_number']=='5') { ?>circle_light_grdark<?php } ?>">
		                        	<?php if($row['test5_number']=='5') { ?><div class="sonar-wave"></div> <?php } ?>
		                           <p>5</p>
		                        </div>
		                     </li>
		                     <li>
		                        <div class="circle_light_gr <?php if($row['test5_number']=='6') { ?>circle_light_grdark<?php } ?>">
		                        	<?php if($row['test5_number']=='6') { ?><div class="sonar-wave"></div> <?php } ?>
		                           <p>6</p>
		                        </div>
		                     </li>
		                     <li>
		                        <div class="circle_light_gr <?php if($row['test5_number']=='7') { ?>circle_light_grdark<?php } ?>">
		                        	<?php if($row['test5_number']=='7') { ?><div class="sonar-wave"></div> <?php } ?>
		                           <p>7</p>
		                        </div>
		                     </li>
		                     <li>
		                        <div class="circle_light_blue gr_first <?php if($row['test5_number']=='8') { ?>circle_light_bluedark<?php } ?>">
		                        	<?php if($row['test5_number']=='8') { ?><div class="sonar-wave"></div> <?php } ?>
		                           <p>8</p>
		                        </div>
		                     </li>
		                     <li>
		                        <div class="circle_light_blue <?php if($row['test5_number']=='9') { ?>circle_light_bluedark<?php } ?>">
		                        	<?php if($row['test5_number']=='9') { ?><div class="sonar-wave"></div> <?php } ?>
		                           <p>9</p>
		                        </div>
		                     </li>
		                     <li>
		                        <div class="circle_light_blue <?php if($row['test5_number']=='10') { ?>circle_light_bluedark<?php } ?>">
		                        	<?php if($row['test5_number']=='10') { ?><div class="sonar-wave"></div> <?php } ?>
		                           <p>10</p>
		                        </div>
		                     </li>
		                  </ul>
		               	</div>
	            	</div>
	            <?php } if($row['test55_name']) { ?>
	              	<div class="row tasteview">
	               		<div class="col-sm-2 tasteviewpar">
	                  		<p><?php echo ucwords($row['test55_name']); ?></p>
	               		</div>
		               	<div class="col-sm-8">
		                  <ul>
		                     <li>
		                        <div class="circle_orange <?php if($row['test55_number']=='1') { ?>circle_orangedark<?php } ?>  ">
		                          <?php if($row['test55_number']=='1') { ?><div class="sonar-wave"></div> <?php } ?>
		                           <p>1</p>
		                        </div>
		                     </li>
		                     <li>
		                        <div class="circle_orange <?php if($row['test55_number']=='2') { ?>circle_orangedark<?php } ?>">
		                        	<?php if($row['test55_number']=='2') { ?><div class="sonar-wave"></div> <?php } ?>
		                           <p>2</p>
		                        </div>
		                     </li>
		                     <li>
		                        <div class="circle_orange <?php if($row['test55_number']=='3') { ?>circle_orangedark<?php } ?>">
		                        	<?php if($row['test55_number']=='3') { ?><div class="sonar-wave"></div> <?php } ?>
		                           <p>3</p>
		                        </div>
		                     </li>
		                      <li>
		                        <div class="circle_orange <?php if($row['test55_number']=='4') { ?>circle_orangedark<?php } ?>">
		                        	<?php if($row['test55_number']=='4') { ?><div class="sonar-wave"></div> <?php } ?>
		                           <p>4</p>
		                        </div>
		                     </li>
		                     <li>
		                        <div class="circle_light_gr gr_first <?php if($row['test55_number']=='5') { ?>circle_light_grdark<?php } ?>">
		                        	<?php if($row['test55_number']=='5') { ?><div class="sonar-wave"></div> <?php } ?>
		                           <p>5</p>
		                        </div>
		                     </li>
		                     <li>
		                        <div class="circle_light_gr <?php if($row['test55_number']=='6') { ?>circle_light_grdark<?php } ?>">
		                        	<?php if($row['test55_number']=='6') { ?><div class="sonar-wave"></div> <?php } ?>
		                           <p>6</p>
		                        </div>
		                     </li>
		                     <li>
		                        <div class="circle_light_gr <?php if($row['test55_number']=='7') { ?>circle_light_grdark<?php } ?>">
		                        	<?php if($row['test55_number']=='7') { ?><div class="sonar-wave"></div> <?php } ?>
		                           <p>7</p>
		                        </div>
		                     </li>
		                     <li>
		                        <div class="circle_light_blue gr_first <?php if($row['test55_number']=='8') { ?>circle_light_bluedark<?php } ?>">
		                        	<?php if($row['test55_number']=='8') { ?><div class="sonar-wave"></div> <?php } ?>
		                           <p>8</p>
		                        </div>
		                     </li>
		                     <li>
		                        <div class="circle_light_blue <?php if($row['test55_number']=='9') { ?>circle_light_bluedark<?php } ?>">
		                        	<?php if($row['test55_number']=='9') { ?><div class="sonar-wave"></div> <?php } ?>
		                           <p>9</p>
		                        </div>
		                     </li>
		                     <li>
		                        <div class="circle_light_blue <?php if($row['test55_number']=='10') { ?>circle_light_bluedark<?php } ?>">
		                        	<?php if($row['test55_number']=='10') { ?><div class="sonar-wave"></div> <?php } ?>
		                           <p>10</p>
		                        </div>
		                     </li>
		                  </ul>
		               	</div>
	            	</div>
	            <?php }  ?>	
	            <?php
	        }
	        ?>
	         </div>
	         <div class="col-xl-6 col-lg-6 col-md-12">
	            <div class="product-details-content">
	               <h2><?php echo ucwords($row['title']);?></h2>
	               <p class="d-none reference">Reference:<span> demo_17</span></p>
	               <div class="pro-details-rating-wrap">
	                  <div class="rating-product">
	                    <?php
                            $rating = $this->crud_model->getProductRating($row['product_id']);
                            if($rating !=NULL)
                            {
                                $r = $rating;
                                $i = 1;
                                while($i<6 && $r >0)
                                {
                                    if($i<=$rating){
                                    ?>
                                        <i class="ion-android-star"></i>
                                    <?php
                                }
                                $r++;
                                    $i++;
                                }
                            }    
                        ?>
	                  </div>
	                  <span class="read-review"><a class="reviews" href="#"><?php echo translate('review(s)'); ?> (<?php echo $rating; ?>)</a></span>
	               </div>
	               <div class="pricing-meta d-none">
	                  <ul>
	                     <li class="old-price not-cut"><?php echo currency($row['bundle_sale1']); ?></li>
	                  </ul>
	               </div>
	               <div class="pro-details-list">
	                  <p><?php echo strip_tags($row['description']); ?></p>
	               </div>
	               <div class="pro-details-quality mt-0px">
	                  <?php
                    $checkcount = count(json_decode($row['products']));
                            if(($row['current_stock'] > 0)&&($max_stock > 0))
                            {
                                ?>
                                <table class="table table-bordered table-striped <?php if($checkcount =='1') { echo  'tablesinglewidth'; }  ?>"> 
                                    <thead>
                                        <?php if($row['bundle_qty1'] > 0) { ?> <th class="text-center">Bottle<span>(<?php echo $row['bundle_qty1']; ?>)</span></th><?php } ?>     
                                        <?php if($row['bundle_qty2'] > 0) { ?> <th class="text-center">Bottle<span>(<?php echo $row['bundle_qty2']; ?>)</span></th><?php } ?>     
                                        <?php if($row['bundle_qty3'] > 0) { ?><th class="text-center">Bottle<span>(<?php echo $row['bundle_qty3']; ?>)</span></th><?php } ?>     
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <?php if($row['bundle_qty1'] > 0) { ?><td><?php echo currency($row['bundle_sale1']); ?></td><?php } ?>
                                            <?php if($row['bundle_qty2'] > 0) { ?><td><?php echo currency($row['bundle_sale2']); ?></td><?php } ?>
                                            <?php if($row['bundle_qty3'] > 0) { ?><td><?php echo currency($row['bundle_sale3']); ?></td><?php } ?>
                                        </tr>
                                        <tr>
                                            <td class="plusview">
                                                <div class="cart-plus-minus">
                                                	<a href="javascript:void(0);" class="dec qtybutton minusbutton" data-productid="1">-</a>
                                                    <input  class="cart-plus-minus-box quantity-multiply1 cart_quantity" disabled realqty="<?php echo $row['bundle_qty1']; ?>" type="text" name="qtybutton" value="<?php echo $row['bundle_qty1']; ?>" min="1" remainingmax="" />
                                                    <input class="total_max quantity-field1" type="hidden"  value="1" min="1" max="" />
                                                    <a href="javascript:void(0);" class="inc qtybutton plusbutton" data-productid="1">+</a>
                                                </div>
                                                <div class="cartbtn btn-hover">
                                                    <a href="javascript:void(0);" variationqty1="<?php echo $row['bundle_qty1']; ?>" variationid="1" class="to_cart_add" productid="<?php echo $row['product_id']; ?>" > Add To Cart</a>
                                                </div>
                                            </td>  
                                            <?php if($row['bundle_qty2'] > 0) { ?>
                                            <td class="plusview">  
                                                <div class="cart-plus-minus">
                                                    <a href="javascript:void(0);" class="dec qtybutton minusbutton" data-productid="2">-</a>
                                                    <input  class="cart-plus-minus-box quantity-multiply2 cart_quantity" disabled realqty="<?php echo $row['bundle_qty2']; ?>" type="text" name="qtybutton" value="<?php echo $row['bundle_qty2']; ?>" min="1" remainingmax="" />
                                                    <input class="total_max quantity-field2" type="hidden"  value="1" min="1" max="" />
                                                    <a href="javascript:void(0);" class="inc qtybutton plusbutton" data-productid="2">+</a>
                                                </div>
                                                <div class="cartbtn btn-hover">
                                                    <a href="javascript:void(0);" variationqty2="<?php echo $row['bundle_qty2']; ?>" variationid="2" class="to_cart_add" productid="<?php echo $row['product_id']; ?>" > Add To Cart</a>
                                                </div>
                                            </td>
                                        <?php } ?>
                                        <?php if($row['bundle_qty3'] > 0) { ?>
                                            <td class="plusview">    
                                                <div class="cart-plus-minus">
                                                    <a href="javascript:void(0);" class="dec qtybutton minusbutton" data-productid="3">-</a>
                                                    <input  class="cart-plus-minus-box quantity-multiply3 cart_quantity" disabled realqty="<?php echo $row['bundle_qty3']; ?>" type="text" name="qtybutton" value="<?php echo $row['bundle_qty3']; ?>" min="1" remainingmax="" />
                                                    <input class="total_max quantity-field3" type="hidden"  value="1" min="1" max="" />
                                                    <a href="javascript:void(0);" class="inc qtybutton plusbutton" data-productid="3">+</a>
                                                </div>
                                                <div class="cartbtn btn-hover">
                                                    <a href="javascript:void(0);" variationqty3="<?php echo $row['bundle_qty3']; ?>" variationid="3" class="to_cart_add" productid="<?php echo $row['product_id']; ?>" > Add To Cart</a>
                                                </div>
                                            </td>
                                        <?php } ?>    
                                        </tr>
                                    </tbody>
                                </table>    
                            <?php   
                            }
                            else{ ?> <div class="pdngtop soldout"><span>Sold Out</span></div> <?php
                            }    
                        ?>
	               </div>
	               <div class="pro-details-wish-com">
	                  <?php
	                    if($this->session->userdata('user_login')!='yes'){ 
	                    ?>
	                        <a  href="<?php echo base_url(); ?>home/login_set/login" ><i class="icon-heart"></i><?php echo translate('_add_to_wishlist'); ?></a></li>
	                    <?php } else 
	                    { 
	                        $wish = $this->crud_model->is_wished($row['product_id']); 
	                        if($wish == 'yes')
	                        { 
	                            ?>
	                            <a pathaction="remove" producttype="single" href="javascript:void(0);" class="to_wishlist" productid="<?php echo $row['product_id']; ?>" ><ion-icon name="heart-sharp"></ion-icon><?php echo translate('_added_to_wishlist');  ?></a>
	                            <?php
	                            } else {  ?>
	                                <a pathaction="add" producttype="single" href="javascript:void(0);" class="to_wishlist" productid="<?php echo $row['product_id']; ?>" > <ion-icon name="heart-outline"></ion-icon><?php echo translate('_add_to_wishlist');   ?></a>
	                    <?php } }  ?>
	                  	<div class="pro-details-compare d-none">
	                     	<a href="#"><i class="icon-shuffle"></i>Add to compare</a>
	                  	</div>
	               </div>
	               <div class="pro-details-social-info">
	                  	<span>Share</span>
	                  	<div class="social-new">
                                 <a  href="http://www.facebook.com/sharer.php?u=<?php echo CURRENT_URL; ?>" target="_blank">
                                    <img class="facebtn" src="<?php echo base_url(); ?>template/omgee/images/iconfindericon/facebook.png">
                                </a>
                                <a  href="http://instagram.com/###?ref=<?php echo CURRENT_URL; ?>">
                                    <img class="instabtn"  src="<?php echo base_url(); ?>template/omgee/images/iconfindericon/instagram.png">
                                </a>
                                <a href="https://twitter.com/intent/tweet?url=<?php echo CURRENT_URL; ?>&text=">
                                    <img class="twibtn" src="<?php echo base_url(); ?>template/omgee/images/iconfindericon/twitter.png">
                                </a>
                                <a href="https://plus.google.com/share?url=<?php echo CURRENT_URL; ?>">    
                                    <img class="gplusbtn" src="<?php echo base_url(); ?>template/omgee/images/iconfindericon/google-plus.png">
                                </a>    
                            </div>
	               </div>
	               <div class="pro-details-policy">
	                  <ul>
	                     <li><img src="<?php echo base_url(); ?>template/omgee/images/icons/policy.png" alt=""><span>Security Policy (Edit With Customer Reassurance Module)</span></li>
	                     <li><img src="<?php echo base_url(); ?>template/omgee/images/icons/policy-2.png" alt=""><span>Delivery Policy (Edit With Customer Reassurance Module)</span></li>
	                     <li><img src="<?php echo base_url(); ?>template/omgee/images/icons/policy-3.png" alt=""><span>Return Policy (Edit With Customer Reassurance Module)</span></li>
	                  </ul>
	               </div>
	            </div>
	         </div>
	      </div>
	   </div>
	</section>
    <!-- Shop details Area End -->
    <!-- main section -->    
    <section class="singleblock">
        <div class="container"> 
            <div class="row reviewblock">
                <div class="col-sm-12">
                    <div class="section-title">
                        <h2 class="section-heading">Community Reviews</h2>
                    </div>
                </div>
                <div class="col-sm-12">
                    <div class="row">
                        <div class="col-md-4 col-sm-6">
                            <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            ...
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                            <button type="button" class="btn btn-primary">Save changes</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="serviceBox" data-toggle="modal" data-target="#exampleModal">
                                <div class="service-icon">
                                    <ion-icon name="cafe-outline"></ion-icon>
                                </div>
                                <h3 class="title">Coffee, vanilla, milk c...</h3>
                                <p class="description">
                                    8 mentions of oaky notes
                                </p>
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-6">
                            <div class="modal fade" id="exampleModal2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Modal title 2</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            ...
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                            <button type="button" class="btn btn-primary">Save changes</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="serviceBox" data-toggle="modal" data-target="#exampleModal2">
                                <div class="service-icon">
                                    <ion-icon name="logo-apple"></ion-icon>
                                </div>
                                <h3 class="title">Coffee, vanilla, milk c...</h3>
                                <p class="description">
                                    8 mentions of oaky notes
                                </p>
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-6">
                            <div class="modal fade" id="exampleModal3" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Modal title3</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            ...
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                            <button type="button" class="btn btn-primary">Save changes</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="serviceBox" data-toggle="modal" data-target="#exampleModal3">
                                <div class="service-icon">
                                    <ion-icon name="radio-button-on-outline"></ion-icon>
                                </div>
                                <h3 class="title">Coffee, vanilla, milk c...</h3>
                                <p class="description">
                                    8 mentions of oaky notes
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <hr>
    <!-- end -->
    <!-- Feature Area start -->
    <?php
    if($row['food_section'] == 'yes')
    {
        ?>
    <section class="tasteblock">
        <div class="container">
            <div class="row">
                <div class="col-sm-3 col-12">
                    <div class="section-title">
                        <h2 class="section-heading"><?php echo ($row['food_title']);?></h2>
                    </div>
                    <p><?php echo ($row['food_description']);?>  </p>
                </div>
                <div class="col-sm-2 col-12 tastesec">
					<img src="<?php echo $mains['0']; ?>" data-zoom-image="<?php echo $mains['0']; ?>" class="img-responsive" alt="" />                               
                </div>
                <div class="col-sm-6 col-12">
                    <div class="row">
                        <div class="col-sm-3 col-6 mixblock">
                            <?php
                            if($row['food_image1'])
                            { ?>
                                <img src="<?php echo base_url('uploads/product_image/'.$row['food_image1']); ?>" class="img-responsive">
                                <p><?php echo ucwords($row['food_name1']); ?></p>
                            <?php } ?>
                        </div>
                        <div class="col-sm-3 col-6 mixblock">
                            <?php
                            if($row['food_image2'])
                            { ?>
                                <img src="<?php echo base_url('uploads/product_image/'.$row['food_image2']); ?>" class="img-responsive">
                                <p><?php echo ucwords($row['food_name2']); ?></p>
                            <?php } ?>
                        </div>
                        <div class="col-sm-3 col-6 mixblock">
                            <?php
                            if($row['food_image3'])
                            { ?>
                                <img src="<?php echo base_url('uploads/product_image/'.$row['food_image3']); ?>" class="img-responsive">
                                <p><?php echo ucwords($row['food_name3']); ?></p>
                            <?php } ?>
                        </div>
                        <div class="col-sm-3 col-6 mixblock">
                            <?php
                            if($row['food_image4'])
                            { ?>
                                <img src="<?php echo base_url('uploads/product_image/'.$row['food_image4']); ?>" class="img-responsive">
                                <p><?php echo ucwords($row['food_name4']); ?></p>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <?php
}
?>
    <!-- end -->
    <?php include 'related_products.php'; ?>
    <div class="feature-area mt-30px d-none">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="section-title">
                        <h2 class="section-heading">Do You Also Like</h2>
                    </div>
                </div>
            </div>
            <div class="feature-slider slider-nav-style-1 swiper-container-initialized swiper-container-horizontal">
                <div class="feature-slider-wrapper swiper-wrapper" style="transform: translate3d(0px, 0px, 0px);">
                    <!-- Single Item -->
                    <div class="feature-slider-item swiper-slide swiper-slide-active" style="width: 263.8px;">
                        <ul class="right-view new1">
                            <li><img src="<?php echo base_url(); ?>template/omgee/images/iconfindericon/pricetag.png"></li>
                        </ul>
                        <ul class="product-flag">
                            <li class="new"><img src="<?php echo base_url(); ?>template/omgee/images/iconfindericon/cashback.png"></li>
                        </ul>
                        <article class="list-product">
                            <div class="img-block productblock">
                                <a href="#" class="thumbnail">
                                    <img class="first-img" src="<?php echo base_url(); ?>template/omgee/images/iconfindericon/wine.png" alt="">
                                </a>
                                <div class="quick-view">
                                    <a class="quick_view" href="#" data-link-action="quickview" title="Quick view" data-toggle="modal" data-target="#exampleModal">
                                        <i class="icon-magnifier icons"></i>
                                    </a>
                                </div>
                                <ul class="bottomleft">
                                    <li>
                                        <h5>Product Name</h5>
                                    </li>
                                </ul>
                                <ul class="bottomproduct">
                                    <li><a href="#"><i class="icon-heart"></i></a></li>
                                </ul>
                                <div class="rating-productone">
                                    <i class="ion-android-star"></i>
                                    <i class="ion-android-star"></i>
                                    <i class="ion-android-star"></i>
                                    <i class="ion-android-star"></i>
                                    <i class="ion-android-star"></i>
                                </div>
                            </div>
                            <div class="product-decs">
                                <table class="table table-striped" width="100%">
                                    <thead>
                                        <th>Bottle<span>(1)</span></th>
                                        <th>Bottle<span>(6)</span></th>
                                        <th>Bottle<span>(12)</span></th>
                                    </thead>
                                    <tr>
                                        <td><del>$128</del></td>
                                        <td rowspan="1"></td>
                                        <td><del>$128</del></td>
                                    </tr>
                                    <tr>
                                        <td>$120</td>
                                        <td>$120</td>
                                        <td>$120</td>
                                    </tr>
                                </table>
                            </div>
                        </article>
                    </div>
                    <!--single Item  -->
                    <div class="feature-slider-item swiper-slide swiper-slide-next" style="width: 263.8px;">
                        <ul class="right-view new1">
                            <li><img src="<?php echo base_url(); ?>template/omgee/images/iconfindericon/pricetag.png"></li>
                        </ul>
                        <ul class="product-flag">
                            <li class="new"><img src="<?php echo base_url(); ?>template/omgee/images/iconfindericon/cashback.png"></li>
                        </ul>
                        <article class="list-product">
                            <div class="img-block productblock">
                                <a href="#" class="thumbnail">
                                    <img class="first-img" src="<?php echo base_url(); ?>template/omgee/images/iconfindericon/wine.png" alt="">
                                </a>
                                <div class="quick-view">
                                    <a class="quick_view" href="#" data-link-action="quickview" title="Quick view" data-toggle="modal" data-target="#exampleModal">
                                        <i class="icon-magnifier icons"></i>
                                    </a>
                                </div>
                                <ul class="bottomleft">
                                    <li>
                                        <h5>Product Name</h5>
                                    </li>
                                </ul>
                                <ul class="bottomproduct">
                                    <li><a href="#"><i class="icon-heart"></i></a></li>
                                </ul>
                                <div class="rating-productone">
                                    <i class="ion-android-star"></i>
                                    <i class="ion-android-star"></i>
                                    <i class="ion-android-star"></i>
                                    <i class="ion-android-star"></i>
                                    <i class="ion-android-star"></i>
                                </div>
                            </div>
                            <div class="product-decs">
                                <table class="table table-striped" width="100%">
                                    <thead>
                                        <th>Bottle<span>(1)</span></th>
                                        <th>Bottle<span>(6)</span></th>
                                        <th>Bottle<span>(12)</span></th>
                                    </thead>
                                    <tr>
                                        <td><del>$128</del></td>
                                        <td rowspan="1"></td>
                                        <td><del>$128</del></td>
                                    </tr>
                                    <tr>
                                        <td>$120</td>
                                        <td>$120</td>
                                        <td>$120</td>
                                    </tr>
                                </table>
                            </div>
                        </article>
                    </div>
                    <!-- end -->
                    <!--single Item  -->
                    <div class="feature-slider-item swiper-slide swiper-slide-next" style="width: 263.8px;">
                        <ul class="right-view new1">
                            <li><img src="<?php echo base_url(); ?>template/omgee/images/iconfindericon/pricetag.png"></li>
                        </ul>
                        <ul class="product-flag">
                            <li class="new"><img src="<?php echo base_url(); ?>template/omgee/images/iconfindericon/cashback.png"></li>
                        </ul>
                        <article class="list-product">
                            <div class="img-block productblock">
                                <a href="#" class="thumbnail">
                                    <img class="first-img" src="<?php echo base_url(); ?>template/omgee/images/iconfindericon/wine.png" alt="">
                                </a>
                                <div class="quick-view">
                                    <a class="quick_view" href="#" data-link-action="quickview" title="Quick view" data-toggle="modal" data-target="#exampleModal">
                                        <i class="icon-magnifier icons"></i>
                                    </a>
                                </div>
                                <ul class="bottomleft">
                                    <li>
                                        <h5>Product Name</h5>
                                    </li>
                                </ul>
                                <ul class="bottomproduct">
                                    <li><a href="#"><i class="icon-heart"></i></a></li>
                                </ul>
                                <div class="rating-productone">
                                    <i class="ion-android-star"></i>
                                    <i class="ion-android-star"></i>
                                    <i class="ion-android-star"></i>
                                    <i class="ion-android-star"></i>
                                    <i class="ion-android-star"></i>
                                </div>
                            </div>
                            <div class="product-decs">
                                <table class="table table-striped" width="100%">
                                    <thead>
                                        <th>Bottle<span>(1)</span></th>
                                        <th>Bottle<span>(6)</span></th>
                                        <th>Bottle<span>(12)</span></th>
                                    </thead>
                                    <tr>
                                        <td><del>$128</del></td>
                                        <td rowspan="1"></td>
                                        <td><del>$128</del></td>
                                    </tr>
                                    <tr>
                                        <td>$120</td>
                                        <td>$120</td>
                                        <td>$120</td>
                                    </tr>
                                </table>
                            </div>
                        </article>
                    </div>
                    <!-- end -->
                    <!--single Item  -->
                    <div class="feature-slider-item swiper-slide swiper-slide-next" style="width: 263.8px;">
                        <ul class="right-view new1">
                            <li><img src="<?php echo base_url(); ?>template/omgee/images/iconfindericon/pricetag.png"></li>
                        </ul>
                        <ul class="product-flag">
                            <li class="new"><img src="<?php echo base_url(); ?>template/omgee/images/iconfindericon/cashback.png"></li>
                        </ul>
                        <article class="list-product">
                            <div class="img-block productblock">
                                <a href="#" class="thumbnail">
                                    <img class="first-img" src="<?php echo base_url(); ?>template/omgee/images/iconfindericon/wine.png" alt="">
                                </a>
                                <div class="quick-view">
                                    <a class="quick_view" href="#" data-link-action="quickview" title="Quick view" data-toggle="modal" data-target="#exampleModal">
                                        <i class="icon-magnifier icons"></i>
                                    </a>
                                </div>
                                <ul class="bottomleft">
                                    <li>
                                        <h5>Product Name</h5>
                                    </li>
                                </ul>
                                <ul class="bottomproduct">
                                    <li><a href="#"><i class="icon-heart"></i></a></li>
                                </ul>
                                <div class="rating-productone">
                                    <i class="ion-android-star"></i>
                                    <i class="ion-android-star"></i>
                                    <i class="ion-android-star"></i>
                                    <i class="ion-android-star"></i>
                                    <i class="ion-android-star"></i>
                                </div>
                            </div>
                            <div class="product-decs">
                                <table class="table table-striped" width="100%">
                                    <thead>
                                        <th>Bottle<span>(1)</span></th>
                                        <th>Bottle<span>(6)</span></th>
                                        <th>Bottle<span>(12)</span></th>
                                    </thead>
                                    <tr>
                                        <td><del>$128</del></td>
                                        <td rowspan="1"></td>
                                        <td><del>$128</del></td>
                                    </tr>
                                    <tr>
                                        <td>$120</td>
                                        <td>$120</td>
                                        <td>$120</td>
                                    </tr>
                                </table>
                            </div>
                        </article>
                    </div>
                    <!-- end -->
                    <!--single Item  -->
                    <div class="feature-slider-item swiper-slide swiper-slide-next" style="width: 263.8px;">
                        <ul class="right-view new1">
                            <li><img src="<?php echo base_url(); ?>template/omgee/images/iconfindericon/pricetag.png"></li>
                        </ul>
                        <ul class="product-flag">
                            <li class="new"><img src="<?php echo base_url(); ?>template/omgee/images/iconfindericon/cashback.png"></li>
                        </ul>
                        <article class="list-product">
                            <div class="img-block productblock">
                                <a href="#" class="thumbnail">
                                    <img class="first-img" src="<?php echo base_url(); ?>template/omgee/images/iconfindericon/wine.png" alt="">
                                </a>
                                <div class="quick-view">
                                    <a class="quick_view" href="#" data-link-action="quickview" title="Quick view" data-toggle="modal" data-target="#exampleModal">
                                        <i class="icon-magnifier icons"></i>
                                    </a>
                                </div>
                                <ul class="bottomleft">
                                    <li>
                                        <h5>Product Name</h5>
                                    </li>
                                </ul>
                                <ul class="bottomproduct">
                                    <li><a href="#"><i class="icon-heart"></i></a></li>
                                </ul>
                                <div class="rating-productone">
                                    <i class="ion-android-star"></i>
                                    <i class="ion-android-star"></i>
                                    <i class="ion-android-star"></i>
                                    <i class="ion-android-star"></i>
                                    <i class="ion-android-star"></i>
                                </div>
                            </div>
                            <div class="product-decs">
                                <table class="table table-striped" width="100%">
                                    <thead>
                                        <th>Bottle<span>(1)</span></th>
                                        <th>Bottle<span>(6)</span></th>
                                        <th>Bottle<span>(12)</span></th>
                                    </thead>
                                    <tr>
                                        <td><del>$128</del></td>
                                        <td rowspan="1"></td>
                                        <td><del>$128</del></td>
                                    </tr>
                                    <tr>
                                        <td>$120</td>
                                        <td>$120</td>
                                        <td>$120</td>
                                    </tr>
                                </table>
                            </div>
                        </article>
                    </div>
                    <!-- end -->
                    <!--single Item  -->
                    <div class="feature-slider-item swiper-slide swiper-slide-next" style="width: 263.8px;">
                        <ul class="right-view new1">
                            <li><img src="<?php echo base_url(); ?>template/omgee/images/iconfindericon/pricetag.png"></li>
                        </ul>
                        <ul class="product-flag">
                            <li class="new"><img src="<?php echo base_url(); ?>template/omgee/images/iconfindericon/cashback.png"></li>
                        </ul>
                        <article class="list-product">
                            <div class="img-block productblock">
                                <a href="#" class="thumbnail">
                                    <img class="first-img" src="<?php echo base_url(); ?>template/omgee/images/iconfindericon/wine.png" alt="">
                                </a>
                                <div class="quick-view">
                                    <a class="quick_view" href="#" data-link-action="quickview" title="Quick view" data-toggle="modal" data-target="#exampleModal">
                                        <i class="icon-magnifier icons"></i>
                                    </a>
                                </div>
                                <ul class="bottomleft">
                                    <li>
                                        <h5>Product Name</h5>
                                    </li>
                                </ul>
                                <ul class="bottomproduct">
                                    <li><a href="#"><i class="icon-heart"></i></a></li>
                                </ul>
                                <div class="rating-productone">
                                    <i class="ion-android-star"></i>
                                    <i class="ion-android-star"></i>
                                    <i class="ion-android-star"></i>
                                    <i class="ion-android-star"></i>
                                    <i class="ion-android-star"></i>
                                </div>
                            </div>
                            <div class="product-decs">
                                <table class="table table-striped" width="100%">
                                    <thead>
                                        <th>Bottle<span>(1)</span></th>
                                        <th>Bottle<span>(6)</span></th>
                                        <th>Bottle<span>(12)</span></th>
                                    </thead>
                                    <tr>
                                        <td><del>$128</del></td>
                                        <td rowspan="1"></td>
                                        <td><del>$128</del></td>
                                    </tr>
                                    <tr>
                                        <td>$120</td>
                                        <td>$120</td>
                                        <td>$120</td>
                                    </tr>
                                </table>
                            </div>
                        </article>
                    </div>
                    <!-- end -->
                </div>
                <!-- Add Arrows -->
                <div class="swiper-buttons">
                    <div class="swiper-button-next" tabindex="0" role="button" aria-label="Next slide" aria-disabled="false"></div>
                    <div class="swiper-button-prev swiper-button-disabled" tabindex="-1" role="button" aria-label="Previous slide" aria-disabled="true"></div>
                </div>
                <span class="swiper-notification" aria-live="assertive" aria-atomic="true"></span>
            </div>
        </div>
    </div>
    <!-- end -->    
    <script type="text/javascript">
    var max_stock = <?php echo $max_stock; ?>;
    $('.cart-plus-minus-box').attr('remainingmax',parseInt(max_stock));
    $('.total_max').attr('max',parseInt(max_stock));
    $('.minusbutton').click(function()
    {
    	var productid = $(this).attr('data-productid');	
		var value = $('.quantity-multiply'+productid).attr('value');
        var max_val =parseInt($('.quantity-field'+productid).attr('max'));
        var quantityvalue = $('.quantity-multiply'+productid).attr('realqty');
        var quantityval = $('.quantity-multiply'+productid).val();
        var remainingmax_val = $('.cart-plus-minus-box').attr('remainingmax');
        var remainmax_val = $('.quantity-multiply'+productid).attr('remainingmax');
		if(value >= 1)
        {	 
            var decreasevalue = parseInt(value - quantityvalue);

            if(decreasevalue >= quantityvalue)
            {    
                var remainingqty = parseInt(quantityvalue);
                var remaining = parseInt(remainingmax_val) + parseInt(remainingqty); 
                if(remaining >= 1)
                {
                    $('.cart-plus-minus-box').attr('remainingmax',remaining);
                    $('.quantity-multiply'+productid).val(decreasevalue);
                }
                $('.quantity-multiply'+productid).attr('value',decreasevalue);
            }        
		}
		$('.quantity-field'+productid).val(value);
	});
    $('.plusbutton').click(function()
    {
	    var productid = $(this).attr('data-productid');	
		var value =  $('.quantity-multiply'+productid).attr('value');
		var max_val = parseInt($('.quantity-field'+productid).attr('max'));
        var remainingmax_val = $('.cart-plus-minus-box').attr('remainingmax');
        var quantityvalue = $('.quantity-multiply'+productid).attr('realqty');
        var quantityval = $('.quantity-multiply'+productid).val();
        
		if(quantityval <= max_val)
        {
            var increasevalue = parseInt(value)+parseInt(quantityvalue);
            if(max_val >= increasevalue)
            {
                var current_qty = $('.quantity-multiply'+productid).val();
                var remainingqty = parseInt(quantityvalue);
                
                var remaining = parseInt(remainingmax_val-remainingqty); 
                
                if(remaining >= 0)
                {
                    $('.cart-plus-minus-box').attr('remainingmax',remaining);
                    $('.quantity-multiply'+productid).val(increasevalue);
                    $('.quantity-multiply'+productid).attr('value',increasevalue);   
                }
            }
		}
		$('.quantity-field'+productid).val(value);
	});
    </script>


                                    