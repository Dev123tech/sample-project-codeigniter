
  <!DOCTYPE html>
<html class="no-js" lang="en">
   <head>
      <?php 
         $vendor_system   =  $this->crud_model->get_settings_value('general_settings','vendor_system');
         $physical_system =  $this->crud_model->get_settings_value('general_settings','physical_product_activation');
         $digital_system  =  $this->crud_model->get_settings_value('general_settings','digital_product_activation');
         $description     =  $this->crud_model->get_settings_value('general_settings','meta_description');
         $keywords        =  $this->crud_model->get_settings_value('general_settings','meta_keywords');
         $author          =  $this->crud_model->get_settings_value('general_settings','meta_author');
         $system_name     =  $this->crud_model->get_settings_value('general_settings','system_name');
         $system_title    =  $this->crud_model->get_settings_value('general_settings','system_title');
         $map_api_key     =  $this->crud_model->get_settings_value('general_settings','google_api_key');
         $revisit_after   =  $this->crud_model->get_settings_value('general_settings','revisit_after');
         
         $page_title      =  ucfirst(str_replace('_',' ',$page_title));
         $this->crud_model->check_vendor_mambership();
         if($this->router->fetch_method() == 'product_view'){
             $keywords    .= ','.$product_tags;
         }
         if($this->router->fetch_method() == 'vendor_profile'){
             $keywords    .= ','.$vendor_tags;
         }
         
         $facebook =  $this->db->get_where('social_links',array('type' => 'facebook'))->row()->value;
         $twitter =  $this->db->get_where('social_links',array('type' => 'twitter'))->row()->value;
         $instagram =  $this->db->get_where('social_links',array('type' => 'instagram'))->row()->value;
         $googleplus =  $this->db->get_where('social_links',array('type' => 'google-plus'))->row()->value;
         $youtube =  $this->db->get_where('social_links',array('type' => 'youtube'))->row()->value;
         ?>
      <title><?php echo $page_title; ?> || <?php echo $system_title; ?></title>
      <?php
         include 'includes/top/index.php';
         ?>
   </head>
   <body style="background-image: url(<?php echo base_url(); ?>template/omgee/images/iconfindericon/bgbody.png);background-size:cover;background-repeat: no-repeat; background-attachment: fixed;" class="<?php if(CURRENT_URL == base_url()) echo 'home_index'; ?>" >
       <!-- Header Section Start From Here -->
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
            .ajax-loader img 
            {
                position: relative;
                top:50%;
                left:50%;
            }
       </style>
        <div class="ajax-loader">
            <img src="<?php echo base_url('uploads'); ?>/loader.gif" class="img-responsive" />
        </div>
      <header class="header-wrapper">
         <?php
            $header = '1';
            include 'header/header_'.$header.'.php';
            if($page_name == 'home/home2')
            {   
            ?>
         <div class="header-menu slidermargin  d-xl-block">
            <div class="container">
               <div class="row">
                  <div class="col-lg-9 col-12">
                     <!-- Slider Start -->
                     <?php
                        $this->db->where('status','approved');
                        $this->db->order_by('events_id','desc');
                        $events_data = $this->db->get('events')->result_array();
                         $h = count($events_data);
                        if($h>0)
                        {    
                            $current_datetime =  date("Y-m-d H:i:s", time());
                            $count_check=0;
                            foreach($events_data as $check_count)
                            {
                                $date = $check_count['date'];

                                $selected_slot = $check_count['time_slot'];

                                $time_slot =  $this->db->get('event_time_slot')->row()->$selected_slot;
                                $end_time = json_decode($time_slot)->end_time;

                                $events_end_datetime = date("$date $end_time");
                                if( $current_datetime < $events_end_datetime)
                                {
                                    $count_check++;
                                }
                            }
                        }        
                        $count_check = 0;
                        if($count_check > 0)
                        {   
                        ?>
                            <div class="slider-area slider-height-2 sliderfirstnew">
                                <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
                                    <ol class="carousel-indicators">
                                        <?php
                                            $events = 0;
                                            foreach ($events_data as $row11) 
                                            {   
                                                $date = $row11['date'];
                                                
                                                $selected_slot = $row11['time_slot'];

                                                $time_slot =  $this->db->get('event_time_slot')->row()->$selected_slot;
                                                $end_time = json_decode($time_slot)->end_time;

                                                $events_end_datetime = date("$date $end_time");
                                                if( ($row11['banner_image'] != NULL) && ( $current_datetime < $events_end_datetime) )
                                                {
                                        ?>
                                                    <li data-target="#carouselExampleIndicators" data-slide-to="<?php echo $events; ?>" class="<?php if($events == 0) { echo 'active' ; } ?>"></li>
                                        <?php
                                            $events++;
                                                }
                                            }
                                        ?>
                                    </ol>
                                    <div class="carousel-inner">
                                        <?php
                                            $n=1;
                                            foreach ($events_data as $row1) 
                                            {  
                                                $date = $row1['date'];
                                                
                                                $selected_slot = $row1['time_slot'];

                                                $time_slot =  $this->db->get('event_time_slot')->row()->$selected_slot;
                                                $end_time = json_decode($time_slot)->end_time;
                                                
                                                $events_end_datetime = date("$date $end_time");
                                                if( ($row1['banner_image'] != NULL) && ( $current_datetime < $events_end_datetime) )
                                                {
                                                    ?>
                                                    <div class="carousel-item <?php if($n == 1) { echo 'active'; } ?>">
                                                        <a href="<?php echo base_url('home/events/'.$row1['events_id']); ?>">
                                                            <img class="d-block w-100"  src="<?php echo base_url(); ?>uploads/events_image/<?php echo $row1['banner_image']; ?>" alt="<?php echo $n; ?> events">
                                                         </a>    
                                                    </div>
                                        <?php
                                                $n++;
                                                }
                                            }
                                        ?>
                                   </div>
                                    <?php
                                        if($n > 2)
                                        {
                                    ?>
                                            <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                                <span class="sr-only">Previous</span>
                                            </a>
                                            <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                                <span class="sr-only">Next</span>
                                            </a>
                                    <?php 
                                        }
                                    ?>    
                                </div>
                            </div>
                        <?php
                        }
                        else 
                        {
                        ?>
                            <div class="slider-area slider-height-2 sliderfirstnew">
                                <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
                                    <ol class="carousel-indicators">
                                        <?php
                                         $this->db->where('status','ok');
                                         $this->db->order_by('serial','desc');
                                         $this->db->order_by('slider_id','desc');
                                         $sliders = $this->db->get('slider')->result_array();
                                         $h = count($sliders);
                                         $slider = 0;
                                         foreach ($sliders as $row1) 
                                         {
                                         ?>
                                        <li data-target="#carouselExampleIndicators" data-slide-to="<?php echo $slider; ?>" class="<?php if($slider == 0) { echo 'active' ; } ?>"></li>
                                      <?php
                                         $slider++;
                                         }
                                         ?>
                                    </ol>
                                   <div class="carousel-inner">
                                      <?php
                                         $n=1;
                                         foreach ($sliders as $row1) 
                                         {
                                             $elements = json_decode($row1['elements'],true);
                                             $txts   = $elements['texts'];
                                         ?>
                                         <?php if($row1['title'] == 'Giveawaypromo') { ?>
                                            <div class="carousel-item <?php if($n == 1) { echo 'active'; } ?>">
                                                <a href = 'http://bitly/omgeegiveaway'>
                                                    <img class="d-block w-100" src="<?php echo base_url(); ?>uploads/slider_image/background_<?php echo $row1['slider_id']; ?>.jpg" alt="<?php echo $n; ?> slide">
                                                </a>
                                            </div>
                                         <?php } else { ?>
                                            <div class="carousel-item <?php if($n == 1) { echo 'active'; } ?>">
                                            <img class="d-block w-100" src="<?php echo base_url(); ?>uploads/slider_image/background_<?php echo $row1['slider_id']; ?>.jpg" alt="<?php echo $n; ?> slide">
                                            </div>
                                         <?php } ?>
                                      <?php
                                         $n++;
                                         }
                                         ?>
                                   </div>
                                    <?php
                                        if($n > 2)
                                        {
                                    ?>        
                                            <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                            <span class="sr-only">Previous</span>
                                            </a>
                                            <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                            <span class="sr-only">Next</span>
                                            </a>
                                    <?php
                                        }    
                                    ?>    
                                </div>
                            </div>
                     <?php          
                        }
                        ?>      
                     <!-- Slider End -->
                  </div>
                  <div class="col-lg-3 col-12">
                     <div class="banner-area banner-area-2 sliderfirstnew slider_right_first">
                        <div class = 'row'>
                            <div class = 'col-lg-12 col-6'>
                                <div id="sidecarouselExampleIndicators" class="carousel slide" data-ride="carousel">

                                    <!-- Indicators -->
                                    <ol class="carousel-indicators">
                                        <?php
                                            $this->db->order_by('slides_id','desc');
                                            $slides = $this->db->get('slides')->result_array();
                                            $h = count($slides);
                                            $slide = 0;
                                            foreach($slides as $rows) 
                                            {
                                            ?>
                                        <li data-target="#sidecarouselExampleIndicators" data-slide-to="<?php echo $slide; ?>" class="<?php if($slide == 0) { echo 'active' ; } ?>"></li>
                                        <?php
                                            $slide++;
                                            }
                                            ?>
                                    </ol>
                                    <div class="carousel-inner">
                                        <?php
                                            $n=1;
                                            foreach ($slides as $rows) 
                                            {
                                                $elements = json_decode($rows['elements'],true);
                                                $txts   = $elements['texts'];
                                            ?>
                                        <div class="carousel-item <?php if($n == 1) { echo 'active'; } ?>">
                                            <img class="d-block w-100" src="<?php echo base_url(); ?>uploads/slides_image/slides_<?php echo $rows['slides_id']; ?>.jpg" alt="<?php echo $n; ?> slide">
                                        </div>
                                        <?php
                                            $n++;
                                            }
                                            ?>
                                    </div>
                                    <!-- Left and right controls -->
                                        <?php
                                            if($n > 2)
                                            {
                                        ?> 
                                            <a class="carousel-control-prev" href="#sidecarouselExampleIndicators" role="button" data-slide="prev">
                                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                            <span class="sr-only">Previous</span>
                                            </a>
                                            <a class="carousel-control-next" href="#sidecarouselExampleIndicators" role="button" data-slide="next">
                                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                            <span class="sr-only">Next</span>
                                            </a>
                                        <?php
                                            }
                                        ?>            
                                </div>
                            </div>
                            <div class = 'col-lg-12 col-6'>
                                <?php
                                $video_type = $this->db->get_where('general_settings',array('type'=>'video_link'))->row_array();
                                ?>
                                <div class="banner-wrapper videoslider">
                                    <div class="video">
                                        <div id="ytplayer"></div>
                                        <script>
                                            // Load the IFrame Player API code asynchronously.
                                            var tag = document.createElement('script');
                                            tag.src = "https://www.youtube.com/player_api";
                                            var firstScriptTag = document.getElementsByTagName('script')[0];
                                            firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);
                                            
                                            // Replace the 'ytplayer' element with an <iframe> and
                                            // YouTube player after the API code downloads.
                                            var player;
                                            function onYouTubePlayerAPIReady() {
                                            player = new YT.Player('ytplayer', {
                                                height: '390',
                                                width: '640',
                                                videoId: "<?php echo $video_type['value']; ?>"
                                            });
                                            }
                                        </script>
                                    </div>
                                </div>
                            </div>
                        </div>
                     </div>
                  </div>
               </div>
               <!-- row -->
            </div>
            <!-- Static Area End -->
         </div>
         <?php } ?>
         <!-- header menu -->
      </header>
      <!-- categories section -->
      <?php /*echo $page_name;*/ include $page_name.'/index.php'; ?>  
      <!-- end -->
      <?php
         $footer = '1';
         include 'footer/footer_'.$footer.'.php';
         ?> 
      <script src="<?php echo base_url(); ?>template/omgee/js/vendor/vendor.min.js"></script>
      <?php
         include 'script_texts.php';
         ?>
      <?php
         include 'includes/bottom/index.php';
         ?>
   </body>
   </html>