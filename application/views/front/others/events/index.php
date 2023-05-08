<?php
    $cashback_product = $this->db->get_where('coupon')->result_array();
    $already_add_product_arr = array();
    
    $current_date_cash = date('Y-m-d');
    
    foreach($cashback_product as $key => $value_cash) 
    {
        $already_add_product_ar = json_decode($value_cash['spec']);
    
        if(strtotime($value_cash['till']) > strtotime($current_date_cash))
        {
            $till_ar[] = strtotime($value_cash['till']);
    
            foreach(json_decode($already_add_product_ar->set) as $key => $productids) 
            {
                $already_add_product_arr[] = array('productid'=>$productids,'discount_type'=>$already_add_product_ar->discount_type,'discount_value'=>$already_add_product_ar->discount_value);
            }
        }
    }
    function searchArrayKeyVal($sKey, $id, $array) 
    {
       foreach ($array as $key => $val) 
       {
           if ($val[$sKey] == $id) {
               return $key;
           }
       }
       return false;
    }
    ?>
<div class="offcanvas-overlay"></div>
<!-- Breadcrumb Area Start -->
<div class="breadcrumb-area">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="breadcrumb-content">
                    <ul class="nav">
                        <li><a href="<?php echo base_url(); ?>">Home</a></li>
                        <li>Events</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Breadcrumb Area End-->
<?php
    $user_id = $this->session->userdata('user_id');
    $events_id = $events_details->events_id;
    $current_date = date('Y-m-d');
        
    $current_datetime =  date("Y-m-d H:i:s", time());
    
    $selected_slot = $events_details->time_slot;

    $time_slot =  $this->db->get_where('event_time_slot')->row()->$selected_slot;
    $start_time = json_decode($time_slot)->start_time;
    $end_time = json_decode($time_slot)->end_time;

    $events_start_datetime = date("$events_details->date $start_time");
     
    $events_end_datetime = date("$events_details->date $end_time");
    
    $remaining_time = strtotime($current_datetime) - strtotime($events_start_datetime);
        $time_arr['events_remaining_time'] = $remaining_time;
    
    $events_remaining_time = strtotime($current_datetime) - strtotime($events_start_datetime);
    if( $current_datetime < $events_end_datetime)
    {
    ?> 
<section class="sliderpopblock">
    <div class="container">
        <div class="row">
            <?php
                if((strtotime($current_datetime) >= strtotime($events_start_datetime))&&(strtotime($current_datetime) <= strtotime($events_end_datetime)))
                {
                    ?>
            <div class="col-md-10 offset-md-1" style="height: 500px;">
                <div id="ytplayer"></div>
            </div>
            <?php
                }
                else
                {
                    if($events_details->banner_image)
                    {
                        ?>
            <div class="col-md-10 offset-md-1">
                <img src="<?php echo base_url(); ?>uploads/events_image/<?php echo $events_details->banner_image; ?>" class="event_img">
            </div>
            <?php
                }
                else
                {
                    ?>
            <div class="col-md-10 offset-md-1">
                <img src="<?php echo base_url(); ?>template/omgee/images/iconfindericon/sliderpop.png" class="img-responsive">
            </div>
            <?php
                }    
                }
                ?>
            <div class="col-md-12">
                <div class="col-md-12 eventblock">
                    <div class="section-title">
                        <h2 class="section-heading">Presenter  Information</h2>
                    </div>
                    <div class="row">
                        <div class="col-md-2">
                            <img src="<?php echo base_url(); ?>uploads/events_image/<?php echo $events_details->image; ?>" class="eventprofile">
                        </div>
                        <div class="col-md-6 presenterinfo">
                            <h5><?php echo ucwords($events_details->presenter_name); ?></h5>
                            <div class="icon_par">
                                <div class="icon_info">
                                    <ion-icon name="information-circle-sharp"></ion-icon>
                                </div>
                                <p> <?php echo ucfirst($events_details->presenter_bio); ?> </p>
                            </div>
                            <div class="icon_par">
                                <div class="icon_info">
                                    <ion-icon name="alarm-sharp"></ion-icon>
                                </div>
                                <p>
                                    <?php 
                                        if($start_time >= '12:00:00')
                                        {  
                                            echo $start_time." pm, "; 
                                        }
                                        else 
                                        {  
                                            echo $start_time." am, "; 
                                        }
                                        if($end_time >= '12:00:00')
                                        {  
                                            echo $end_time." pm, "; 
                                        }
                                        else
                                        {  
                                            echo $end_time." am, "; 
                                        }    
                                            echo  $events_details->date;        
                                        ?>
                                </p>
                            </div>
                            <div class="icon_par">
                                <div class="icon_info">
                                    <ion-icon name="people-sharp"></ion-icon>
                                </div>
                                <?php $query = $this->db->get_where('events_registration',array('events_id'=>$events_details->events_id)); ?>
                                <p>Joined: &nbsp;<b><?php echo $query->num_rows(); ?></b></p>
                            </div>
                            <?php   $user_id;
                                $event_user_id = $this->db->get_where('events_registration',array('user_id'=>$user_id,'events_id'=>$events_details->events_id))->row()->user_id;
                                //echo $this->db->last_query();
                                if($user_id != $event_user_id){
                                ?>  
                            <button type="button" class="btn btngra"  data-toggle="modal" data-target="#staticBackdrop">Join Event</button>
                            <?php 
                                }
                                else if($user_id == NULL){
                                    ?>  
                            <button type="button" class="btn btngra" data-toggle="modal" data-target="#staticBackdrop">Join Event</button>
                            <?php 
                                }
                                
                                ?>
                            <div class="modal fade sliderpop" id="staticBackdrop" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h4>Event Registration</h4>
                                        </div>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                        </button>
                                        <div class="modal-body">
                                            <section class="events_pop">
                                                <div class="container">
                                                    <?php
                                                        echo form_open(base_url() . 'home/others/do_register/', array('method' => 'post'));
                                                        ?>
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <input type="hidden" name="user_id" class="form-control" value="<?php echo $user_id; ?>" >
                                                            <input type="hidden" name="events_id" class="form-control" value="<?php echo $events_id; ?>" >
                                                            <label><?php echo translate('name'); ?></label>
                                                            <input type="text" name="name" class="form-control required" placeholder="<?php echo translate('enter_your_name'); ?>" required> 
                                                            <label><?php echo translate('email_address'); ?></label>
                                                            <input type="text" name="email" class="form-control required" placeholder="<?php echo translate('enter_email_address'); ?>" required> 
                                                            <label><?php echo translate('phone_number'); ?></label>
                                                            <input type="number" name="phone" class="form-control required" placeholder="<?php echo translate('enter_phone_number'); ?>" required> 
                                                            <span class="custom-checkbox">
                                                            <input  name="favorite" type="checkbox" value="ok" > Favorite
                                                            <span><i class="material-icons rtl-no-flip checkbox-checked"></i></span>        
                                                            </span>
                                                            <div class="col-sm-12 text-left">
                                                                <button class="btn btngra" type="submit"><?php echo translate('register');?></button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <?php echo form_close() ; ?>   
                                                </div>
                                            </section>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <style type="text/css">
                            .coupansec{
                            border: 1px dashed #e5c55d;
                            text-align: center;
                            padding: 13px 0;
                            }
                            .coupansec h5{
                            margin-bottom: 7px;
                            color: #fff;
                            }
                            .coupansec p{
                            font-size: 24px;
                            width: 72%;
                            color: #cba637;
                            font-weight: bold;
                            margin: 0 auto 6px;
                            }
                            .coupansec label{
                            color: #ffffff;
                            font-weight: bold;
                            border: 1px dashed;
                            width: 130px;
                            height: 37px;
                            padding-top: 8px;
                            letter-spacing: 2px;
                            font-size: 17px;
                            }
                            .shape12 {
                            position: absolute;
                            left: -26px;
                            bottom: -42px;
                            }
                            .shape12 img{
                            height: 52px;
                            transform: rotate(313deg);
                            }
                        </style>
                        <?php
                            $promocode_detail = $this->db->get_where('promocode',array('promocode_id'=>$events_details->promocode_id))->row();
                            $till = strtotime($promocode_detail->till);
                            $from = strtotime($promocode_detail->form);
                            if(($from < time())&&($till > time()))
                            {
                        ?>
                        <div class="col-md-3 coupansec">
                            <h5>CONGRATULATIONS</h5>
                            <p>YOU'VE GOT PROMO CODE</p>
                            <div class="shape12">
                                <img src="<?php echo base_url(); ?>template/omgee/images/iconfindericon/coupanbg.png" alt="image"></div>
                                <div class="coupanblock">
                                    <label class="mytext"><?php echo $promocode_detail->code; ?></label>
                                </div>
                            <button type="button" class="btn btngra TextToCopy">Copy</button>
                        </div>
                        <?php
                    }
                    if($events_details->choose_product !=null)
                                    {
                    ?>
                        <div class="col-md-12">
                            <label class="pro_title">List of Showcast Products</label>
                        </div>
                        <div class="col-sm-12">
                            <div class="row marginzero">
                                <?php
                                    

                                    $product_arr = explode(",", $events_details->choose_product);
                                   
                                        foreach ($product_arr as $value) 
                                        {
                                            $product_id = $this->db->get_where('product',array('product_id'=>$value,'remove'=>'0'))->row()->product_id;
                                        ?>   
                                    <div class="feature-slider-item swiper-slide swiper-slide-active" style="width: 263.8px;">
                                        <?php 
                                            $tags = $this->db->get_where('product',array('product_id'=>$product_id))->result_array();
                                            foreach($tags as $pricetag)
                                            {
                                             ?>        
                                        <ul class="right-view new1">
                                            <?php  
                                                if($pricetag['discount'] > 0)
                                                {
                                                ?>
                                            <div class="vendoroffer">
                                                <span><?php echo $pricetag['bundle_discount1']; ?>%</span>
                                                <p>OFF</p>
                                            </div>
                                            <li><img src="<?php echo base_url(); ?>template/omgee/images/iconfindericon/pricetag.png"></li>
                                            <?php 
                                                } 
                                                ?> 
                                        </ul>
                                        <?php
                                            $productKey = searchArrayKeyVal("productid", $product_id, $already_add_product_arr);
                                            if($productKey!==false) 
                                            {
                                                ?>
                                        <div class="triangle-bottomleft">
                                            <span><?php echo $already_add_product_arr[$productKey]['discount_value']; ?> <?php echo ($already_add_product_arr[$productKey]['discount_type']=='percent') ? '%':currency(); ?> OFF</span>
                                        </div>
                                        <?php
                                            }
                                            ?>
                                        <ul class="product-flag">
                                            <li class="new">
                                                <?php
                                                    if($productKey!==false) 
                                                    {
                                                    ?>
                                                <img src="<?php echo base_url(); ?>template/omgee/images/iconfindericon/cashback.png">
                                                <?php
                                                    }
                                                    
                                                    if($pricetag['num_of_imgs'] !=NULL)
                                                    {
                                                        $num_of_img = explode(",", $pricetag['num_of_imgs']); 
                                                        $first_image = base_url('uploads/product_image/'.$num_of_img[0]);
                                                    }
                                                    else
                                                    {
                                                        $first_image = base_url('uploads/product_image/default.jpg');
                                                    }
                                                    ?>
                                            </li>
                                        </ul>
                                        <?php 
                                            }
                                            $num = $this->db->get_where('product',array('product_id'=>$product_id))->row();
                                            if($num->num_of_imgs !=NULL)
                                            {
                                                $num_of_img = explode(",",$num->num_of_imgs); 
                                                $first_image = base_url('uploads/product_image/'.$num_of_img[0]);
                                            }
                                            else
                                            {
                                                $first_image = base_url('uploads/product_image/default.jpg');
                                            }
                                            ?>
                                        <article class="list-product">
                                            <div class="img-block productblock">
                                                <a href="<?php echo $this->crud_model->product_link($product_id); ?>">
                                                <img class="first-img" src="<?php echo $first_image;?>" alt=""> 
                                                </a>
                                                <div class="quick-view">
                                                    <a class="quick_view" href="#" data-link-action="quickview" title="Quick view" data-toggle="modal" data-target="#exampleModal">
                                                    <i class="icon-magnifier icons"></i>
                                                    </a>
                                                </div>
                                                <ul class="bottomleft">
                                                    <li>
                                                        <?php  $product_name = $this->db->get_where('product',array('product_id'=>$value))->row()->title; ?>
                                                        <?php  $product_id = $this->db->get_where('product',array('product_id'=>$value))->row()->product_id; ?>
                                                        <h5><?php echo $product_name; ?> </h5>
                                                    </li>
                                                </ul>
                                                <ul class="bottomproduct">
                                                    <li>
                                                        <?php
                                                            if($this->session->userdata('user_login')!='yes'){ 
                                                            ?>
                                                        <a  data-toggle="tooltip" title="<?php echo translate('_add_to_wishlist'); ?>" href="<?php echo base_url(); ?>home/login_set/login" ><i class="icon-heart"></i></a>
                                                    </li>
                                                    <?php } 
                                                        else 
                                                            {   
                                                            $wish = $this->crud_model->is_wished($product_id); 
                                                            if($wish == 'yes')
                                                                { 
                                                                    ?>
                                                    <a data-toggle="tooltip" producttype="recent" title="<?php echo translate('_added_to_wishlist'); ?>"  pathaction="remove" href="javascript:void(0);" class="to_wishlist  product<?php echo $product_id; ?>" productid="<?php echo $product_id; ?>" >
                                                        <ion-icon name="heart-sharp">s</ion-icon>
                                                    </a>
                                                    <?php
                                                        } else {  ?>
                                                    <a data-toggle="tooltip" producttype="recently" title="<?php echo translate('_add_to_wishlist'); ?>"  pathaction="add" href="javascript:void(0);" class="to_wishlist  product<?php echo $product_id; ?>" productid="<?php echo $product_id; ?>" >
                                                        <ion-icon name="heart-outline"></ion-icon>
                                                    </a>
                                                    <?php } }  ?>
                                                    </li>
                                                </ul>
                                                <div class="rating-productone">
                                                    <?php
                                                        $rowrating['products_id'] = $product_id;
                                                                $recently_rating = $this->crud_model->getProductRating($rowrating['products_id']);
                                                                $rr = $recently_rating;
                                                                $ii = 1;
                                                                while($ii<6 && $rr >0)
                                                                {
                                                                    if($ii<=$recently_rating){
                                                                    ?>
                                                    <i class="ion-android-star"></i>
                                                    <?php
                                                        }
                                                            $rr++;
                                                        $ii++;
                                                        }
                                                        ?>
                                                </div>
                                            </div>
                                            <div class="product-decs">
                                                <?php   
                                                    $data = $this->db->get_where('product',array('product_id'=>$product_id))->result_array();
                                                    foreach($data as $row2) {
                                                        if($row2['bundle_qty1'])
                                                              {
                                                                  $lat_sale_price1 = $row2['bundle_sale1'] - ($row2['bundle_sale1']*($row2['bundle_discount1'])/100);
                                                                  $lat_sale_price2 = $row2['bundle_sale2'] - ($row2['bundle_sale2']*($row2['bundle_discount2'])/100);
                                                                  $lat_sale_price3 = $row2['bundle_sale3'] - ($row2['bundle_sale3']*($row2['bundle_discount3'])/100);
                                                    
                                                                  ?>
                                                <table class="table table-striped" width="100%">
                                                    <thead>
                                                        <th class="text-center <?php if(($row2['bundle_discount1']=="")&&($row2['bundle_discount2']=="")&&($row2['bundle_discount3']=="")) { echo 'th_firstdata'; } ?> "><?php echo translate($row2['product_type']); ?><span>(<?php echo $row2['bundle_qty1']; ?>)</span></th>
                                                        <?php if($row2['bundle_qty2'] > 0) { ?>
                                                        <th class="text-center <?php if(($row2['bundle_discount1']=="")&&($row2['bundle_discount2']=="")&&($row2['bundle_discount3']=="")) { echo 'th_firstdata'; } ?>"><?php echo translate($row2['product_type']); ?><span>(<?php echo $row2['bundle_qty2']; ?>)</span></th>
                                                        <?php } ?>    
                                                        <?php if($row2['bundle_qty3'] > 0) { ?>
                                                        <th class="text-center <?php if(($row2['bundle_discount1']=="")&&($row2['bundle_discount2']=="")&&($row2['bundle_discount3']=="")) { echo 'th_firstdata'; } ?>"><?php echo translate($row2['product_type']); ?><span>(<?php echo $row2['bundle_qty3']; ?>)</span></th>
                                                        <?php } ?>    
                                                    </thead>
                                                    <tr>
                                                        <td><del><?php if($row2['bundle_discount1'] > 0) { ?><?php echo currency($row2['bundle_sale1']); ?><?php } ?></del></td>
                                                        <td><del><?php if($row2['bundle_discount2'] > 0) { ?><?php echo currency($row2['bundle_sale2']); ?><?php } ?></del></td>
                                                        <td><del><?php if($row2['bundle_discount3'] > 0) { ?><?php echo currency($row2['bundle_sale3']); ?><?php } ?></del></td>
                                                    </tr>
                                                    <tr class="newpricetag">
                                                        <?php if($lat_sale_price1 > 0) { ?>
                                                        <td><?php echo currency($lat_sale_price1); ?></td>
                                                        <?php } ?>
                                                        <?php if($lat_sale_price2 > 0) { ?>
                                                        <td><?php echo currency($lat_sale_price2); ?></td>
                                                        <?php } ?>
                                                        <?php if($lat_sale_price3 > 0) { ?>
                                                        <td><?php echo currency($lat_sale_price3); ?></td>
                                                        <?php } ?>
                                                    </tr>
                                                </table>
                                                <?php } } ?>
                                            </div>
                                        </article>
                                    </div>
                                    <?php
                                    }
                                    ?>
                            </div>
                        </div>
                        <?php
                    }
                    ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
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
        videoId: "<?php echo $events_details->video_link; ?>"
      });
    }
    function remaintime_funct()
    {
        var data = { 'events_id' : '<?php echo $events_id; ?>' };
    
        var result = $.ajax({type: 'POST', url: base_url+"home/event_remaining_time",data: data,dataType: 'Json',context: document.body,global: false,async:false,success: function(data) { return data; } }).responseText;
    
        var result_obj = JSON.parse(result);
    
        if(result_obj.events_remaining_time == "0")
        {
            location.reload(true);
        }
        if(result_obj.end_of_event_time == "0")
        {
            location.reload(true);
        }
    }
    setInterval('remaintime_funct()', 1000);
    $('.TextToCopy').click(function()
    {
        var $temp = $("<input>");
        $("body").append($temp);
        $temp.val($('.mytext').text()).select();
        document.execCommand("copy");
         $temp.remove();
        $('.TextToCopy').html('Copied'); 
    })
</script>
<?php
    }else
    {
        redirect(base_url());
    }
    
    ?>