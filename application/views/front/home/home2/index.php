<?php
$cashback_product = $this->db->get_where('coupon')->result_array();
$already_add_product_arr = array();

$current_date = date('Y-m-d');

foreach($cashback_product as $key => $value) 
{
    $already_add_product_ar = json_decode($value['spec']);

    if(strtotime($value['till']) > strtotime($current_date))
    {
        $till_ar[] = strtotime($value['till']);

        foreach(json_decode($already_add_product_ar->set) as $key => $productids) 
        {
            $already_add_product_arr[] = array('productid'=>$productids,'discount_type'=>$already_add_product_ar->discount_type,'discount_value'=>$already_add_product_ar->discount_value);
        }
    }
}
function searchArrayKeyVal($sKey, $id, $array) {
   foreach ($array as $key => $val) {
       if ($val[$sKey] == $id) {
           return $key;
       }
   }
   return false;
}
?>

<pre id="response"></pre>
 <section class="bg-games bg-section" id="game">
            <div class="container">
            <div class="row">
                <div class="col-sm-12 col-12">
                    <!-- Nav pills -->
                    <ul class="nav nav-pills categorieslist scrollmenu" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="pill" href="#popular">
                                <img src="<?php echo base_url(); ?>template/omgee/images/iconfindericon/popular.png" class="img-responsive">
                                <label>Popular</label>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" data-toggle="pill" href="#topdeal">
                                <img src="<?php echo base_url(); ?>template/omgee/images/iconfindericon/topdeals.png" class="img-responsive">
                                <label><?php echo translate('todays_deal'); ?></label>
                            </a>
                        </li>
                        <?php
                            $categories = $this->db->order_by('category_id', 'desc')->get_where('category',array('digital'=> NULL))->result_array();
                            foreach ($categories as $row1) 
                            {
                                if($this->crud_model->if_publishable_category($row1['category_id'])){
                                ?>
                                <li class="nav-item">
                                    <a style = "<?php if($row1['category_name'] != 'Wine') echo 'pointer-events: none; cursor: default;'; ?>" onclick="return false;" class="nav-link" data-toggle="pill" href="#<?php echo str_replace(' ','-',$row1['category_name']); ?> ">
                                    <img src="<?php echo base_url(); ?>uploads/category_image/<?php echo $row1['banner']; ?>" class="img-responsive">
                                    <label><?php echo ucwords($row1['category_name']); ?></label>
                                    </a>
                                </li>
                        <?php
                            }
                        }
                        ?>
                    </ul>
                </div>
                <!-- Tab panes -->
                <div class="col-sm-12">
                    <div class="tab-content">
                        <div id="popular" class="tab-pane fade">
                                <div class="row">
                                    <div class="col-sm-12 catblock">
                                        <div class="row">
                                            <?php
                                            $brands = $this->db->limit(12)->get_where('brand')->result_array();
                                            foreach ($brands as $brandsvalue) 
                                            {
                                                if($brandsvalue['logo'] !=NULL)
                                                {
                                                    $num_of_img = explode(",", $brandsvalue['logo']); 
                                                    $first_image = base_url('uploads/brand_image/'.$num_of_img[0]);
                                                }
                                                else
                                                {
                                                    $first_image = base_url('uploads/product_image/default.jpg');
                                                }
                                                ?>
                                            <div class="col-sm-2 col-4 pro_view">
                                                <a href="<?php echo base_url('home/category/0/0-'.$brandsvalue['brand_id']); ?>">
                                                    <img  src="<?php echo $first_image;?>" class="img-responsive">
                                                    <span><?php echo ucwords($brandsvalue['name']); ?></span>
                                                </a>
                                            </div>
                                            <?php
                                                
                                            }
                                            ?>
                                        </div>
                                        <div class="row" style="display: none;">
                                            <div class="col-sm-12 text-center catfooter">
                                                <a href="<?php echo base_url('home/category/latest'); ?>">Discover All Popular </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div id="topdeal" class="tab-pane fade active">
                                <div class="row">
                                    <div class="col-sm-12 catblock">
                                        <div class="row">
                                            <?php
                                            $topdeal_products = $this->db->limit(12)->get_where('product',array('deal'=>'ok','status'=>'ok','remove'=>'0'))->result_array();
                                            foreach ($topdeal_products as $pdtvalue) 
                                            {
                                                
                                               ?>
                                                <div class="col-sm-2 col-4 pro_view">
                                                    <a href="<?php echo $this->crud_model->product_link($pdtvalue['product_id']); ?>">
                                                        <?php
                                                        if($pdtvalue['num_of_imgs'] !=NULL)
                                                        {
                                                            $num_of_img = explode(",", $pdtvalue['num_of_imgs']); 
                                                            $first_image = base_url('uploads/product_image/'.$num_of_img[0]);
                                                        }
                                                        else
                                                        {
                                                            $first_image = base_url('uploads/product_image/default.jpg');
                                                        }
                                                        ?>
                                                        <img alt="<?php echo $pdtvalue['title']; ?>" src="<?php echo $first_image;?>" class="img-responsive">
                                                        <span><?php echo ucwords($pdtvalue['title']); ?></span>
                                                    </a>
                                                </div>
                                            <?php
                                                
                                            }
                                            ?>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-12 text-center catfooter">
                                                <a href="<?php echo base_url('home/category/todays_deal'); ?>">Discover All <?php echo translate('todays_deal'); ?></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php
                        $cat_count = 0;
                        foreach ($categories as $catvalue) 
                        {
                            ?>
                            <div id="<?php echo str_replace(' ','-',$catvalue['category_name']); ?>" class="tab-pane fade show ">
                                <div class="row">
                                    <div class="col-sm-12 catblock">
                                        <div class="row">
                                            <?php
                                            $sub_category = $this->db->get_where('sub_category',array('category'=>$catvalue['category_id']))->result_array();
                                            if(count($sub_category) > 0)
                                            {
                                                foreach ($sub_category as $sub_category_value) 
                                                {
                                                    if($sub_category_value['banner'] !=NULL)
                                                    {
                                                        $num_of_img = explode(",",$sub_category_value['banner']); 
                                                        $first_image = base_url('uploads/sub_category_image/'.$sub_category_value['banner']);
                                                    }
                                                    else
                                                    {
                                                        $first_image = base_url('uploads/sub_category_image/default.jpg');
                                                    }
                                                   ?>
                                                <div class="col-sm-2 col-4 pro_view">
                                                    <a href="<?php echo base_url(); ?>home/category/<?php echo $catvalue['category_id']; ?>/<?php echo $sub_category_value['sub_category_id']; ?>">
                                                        <img src="<?php echo $first_image; ?>" class="img-responsive">
                                                        <span><?php echo $sub_category_value['sub_category_name']; ?></span>
                                                    </a>
                                                </div>
                                                <?php 
                                                }
                                            }
                                            else
                                            {
                                                echo  '<div class="pro_view text-center">
                                                            <h4><span class="text-center">No sub-categories are available.</span></h4>
                                                        </div>';
                                            }    
                                            ?>
                                        </div>
                                        <div class="row" style="display: none;">
                                            <div class="col-sm-12 text-center catfooter">
                                                <a href="<?php echo base_url('home/category/'.$catvalue['category_id']); ?>">Discover All <?php echo ucwords($catvalue['category_name']); ?></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php
                            $cat_count++;
                        }
                        ?>
                    </div>
                </div>
            </div>
        </section>
        <!-- end -->
        <!-- modal popup -->
        <div class="container">
            <div class="row">
            <?php 
                $banner_image =  $this->db->get_where('banner',array('banner_id' => '1','status'=>'ok'))->row()->banner_image;
                $bannerimages = explode(",",$banner_image);
                // print_r($images);
                if($bannerimages){
                    foreach ($bannerimages as $banner_row){
            ?>  
                <div class="inner-div">
                    <!-- <button type="button" class="btn" data-toggle="modal" data-target="#exampleModal"> -->
                    <a href = "https://omgee.com.au/home/login_set/login">
                        <img class="popimg" src="<?php echo base_url(); ?>uploads/banner_image/<?php echo $banner_row; ?>"  >
                    </a>
                    <!-- </button> -->
                </div>
            <?php 
                    }
                } 
            ?>
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
    </div>
</div>
        <div class="offcanvas-overlay"></div>
        <div class="feature-area mt-30px">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="section-title">
                            <h2 class="section-heading"><?php echo translate('latest_products');?></h2>
                        </div>
                    </div>
                </div>
                <div class="feature-slider slider-nav-style-1 swiper-container-initialized swiper-container-horizontal">
                    <div class="feature-slider-wrapper swiper-wrapper" style="transform: translate3d(0px, 0px, 0px);">
                        <?php
                            $latest=$this->crud_model->lastOneWeekproduct();
                            $total_latest = count($latest);
                            foreach($latest as $row)
                            { 
                        ?>
                        <!-- Single Item -->
                        <div class="feature-slider-item swiper-slide swiper-slide-active" style="width: 263.8px;">
                            <ul class="right-view new1">
                                <?php 
                                    if($row['discount'] > 0)
                                    {
                                        ?>
                                <div class="vendoroffer">
                                    <span><?php echo $row['discount']; ?>%</span>
                                    <p>OFF</p>
                                </div>
                                <?php
                                }
                                if(($row['discount'] > 0))
                                {
                            ?>
                                <li><img src="<?php echo base_url(); ?>template/omgee/images/iconfindericon/pricetag.png"></li>
                            <?php } ?>
                            </ul>
                            <?php
                                $productKey = searchArrayKeyVal("productid", $row['product_id'], $already_add_product_arr);
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
                                        <img src="<?php echo base_url(); ?>template/omgee/images/iconfindericon/new_cash.png">
                                <?php
                                    }

                                    if($row['num_of_imgs'] !=NULL)
                                    {
                                        $num_of_img = explode(",", $row['num_of_imgs']); 
                                        $first_image = base_url('uploads/product_image/'.$num_of_img[0]);
                                    }
                                    else
                                    {
                                        $first_image = base_url('uploads/product_image/default.jpg');
                                    }
                                    ?>
                                </li>
                            </ul>
                            <article class="list-product">
                                <div class="img-block productblock">
                                    <a href="<?php echo $this->crud_model->product_link($row['product_id']); ?>" class="thumbnail">
                                    <img class="first-img" src="<?php echo $first_image; ?>" alt="">
                                    </a>
                                    <div class="quick-view">
                                        <a class="quick_view" href="#" data-link-action="quickview" title="Quick view" data-toggle="modal" data-target="#exampleModal">
                                        <i class="icon-magnifier icons"></i>
                                        </a>
                                    </div>
                                    <ul class="bottomleft">
                                    <?php 
                                    $row11 = $this->db->get_where('product',array('product_id'=> $row['product_id']))->row();
                                    $brands = $this->db->get_where('vendorbrands',array('id'=> $row11->brand))->row();
                                    ?>
                                    <p class = "text-white pl-3  "><?php echo $brands->name ?></p>
                                        <li>
                                            <a data-toggle="tooltip" title="<?php echo ucwords($row['title']); ?>" href="<?php echo $this->crud_model->product_link($row['product_id']); ?>"><h5 >
                                                <?php 
                                                $cat_title = wordwrap(ucwords($row['title']), 19, '<br />', true); 
                                                echo mb_strimwidth($cat_title, 0, 40, "...");
                                                ?>    
                                            </h5>
                                            </a>
                                        </li>
                                    </ul>
                                    <ul class="bottomproduct">
                                        <li>
                                        <?php
                                    if($this->session->userdata('user_login')!='yes'){ 
                                    ?>
                                        <a  data-toggle="tooltip" title="<?php echo translate('_add_to_wishlist'); ?>" href="<?php echo base_url(); ?>home/login_set/login" ><i class="icon-heart"></i></a></li>
                                    <?php } else 
                                    { 
                                        $wish = $this->crud_model->is_wished($row['product_id']); 
                                        if($wish == 'yes')
                                        { 
                                            ?>
                                            <a data-toggle="tooltip" producttype="latest" title="<?php echo translate('_added_to_wishlist'); ?>"  pathaction="remove" href="javascript:void(0);" class="to_wishlist  product<?php echo $row['product_id']; ?>" productid="<?php echo $row['product_id']; ?>" ><ion-icon name="heart-sharp"></ion-icon></a>
                                            <?php
                                            } else {  ?>
                                                <a data-toggle="tooltip" producttype="latest" title="<?php echo translate('_add_to_wishlist'); ?>"  pathaction="add" href="javascript:void(0);" class="to_wishlist  product<?php echo $row['product_id']; ?>" productid="<?php echo $row['product_id']; ?>" > <ion-icon name="heart-outline"></ion-icon></a>
                                    <?php } }  ?>
                                    <li>
                                    </ul>
                                    <div class="rating-productone">
                                        <?php
                                            $rating = $this->crud_model->getProductRating($row['product_id']);
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
                                        ?>
                                    </div>
                                </div>
                                <div class="product-decs">
                                    <?php
                                    if($row['sale_price_AU']>0)
                                    {
                                        if($this->session->userdata('currency') == '2')
                                        {
                                            $rrp = $row['sale_price_AU'];
                                            $wholesale = $row['wholesale'];
                                        }
                                        else
                                        {
                                            $wholesale = $row['wholesale_EXCL_WET_GST'];
                                        }
                                        if($this->session->userdata('currency') == '10')
                                        {
                                            if($row['sale_price_HK'] > 0)
                                            {
                                                $rrp = $row['sale_price_HK'];
                                            }
                                            else
                                            {
                                                $rrp = $row['sale_price_AU'];
                                            }
                                        }
                                        if($this->session->userdata('currency') == '13')
                                        {
                                            if($row['sale_price_JP'] > 0)
                                            {
                                                $rrp = $row['sale_price_JP'];
                                            }
                                            else
                                            {
                                                $rrp = $row['sale_price_AU'];
                                            }
                                        }
                                        if($this->session->userdata('currency') == '22')
                                        {
                                            if($row['sale_price_SG'] > 0)
                                            {
                                                $rrp = $row['sale_price_SG'];
                                            }
                                            else
                                            {
                                                $rrp = $row['sale_price_AU'];
                                            }
                                        }
    
                                        $wholesale = $row['wholesale'];
                                        $discount = ($row['discount']) ? ($row['discount']/100) : 0;
                                        
                                        if($row['limited_release']=="Yes")
                                        {
                                            $orp_commission_amount = ($this->db->get_where('business_settings', array('type' => 'limit_admin_orp_commission_amount'))->row()->value)/100;
                                        
                                            $commission_amount = ($this->db->get_where('business_settings', array('type' => 'limit_admin_commission_amount'))->row()->value)/100;   
                                        }
                                        else
                                        {
                                            $orp_commission_amount = ($this->db->get_where('business_settings', array('type' => 'nolimit_admin_orp_commission_amount'))->row()->value)/100;
                                        
                                            $commission_amount = ($this->db->get_where('business_settings', array('type' => 'nolimit_admin_commission_amount'))->row()->value)/100;
                                        }

                                        $gap_revenue = $rrp - $wholesale;
                                        $gap_revenue_commission = $gap_revenue * $commission_amount;    
                                        $orp = $rrp - (($gap_revenue - $gap_revenue_commission)*$orp_commission_amount);
                                        $total_discount = $orp * $discount;
                                        $total_orp = $orp - $total_discount;
                                    

                                        $lat_sale_price1 = $total_orp*1;
                                        $lat_sale_price2 = $total_orp*6;
                                        $lat_sale_price3 = $total_orp*12;

                                    ?>
                                    <table class="table table-striped" width="100%">
                                        <thead>
                                            <th class="text-center <?php if($row['discount'] == 0) { echo 'th_firstdata'; } ?>">Each</span></th>   
                                            <th class="text-center <?php if($row['discount'] == 0) { echo 'th_firstdata'; } ?>">Six</span></th>   
                                            <th class="text-center <?php if($row['discount'] == 0) { echo 'th_firstdata'; } ?>">Twelve</span></th>   
                                        </thead>
                                        <tr>
                                            <?php
                                            if($row['discount'] > 0)
                                            {
                                                if($this->session->userdata('currency') == '2')
                                                {
                                                    ?>
                                                    <td><del><?php echo currency($orp *1); ?></del></td>
                                                    <td><del><?php echo currency($orp *6); ?></del></td>
                                                    <td><del><?php echo currency($orp *12); ?></del></td>
                                                    <?php
                                                }
                                                if($this->session->userdata('currency') == '10')
                                                {
                                                    if($row['sale_price_HK'] > 0)
                                                    {
                                                        ?>
                                                        <td><del><?php echo currency().$orp *1; ?></del></td>
                                                        <td><del><?php echo currency().$orp *6; ?></del></td>
                                                        <td><del><?php echo currency().$orp *12; ?></del></td>
                                                        <?php
                                                    }
                                                    else
                                                    {
                                                        ?>
                                                        <td><del><?php echo currency($orp *1); ?></del></td>
                                                        <td><del><?php echo currency($orp *6); ?></del></td>
                                                        <td><del><?php echo currency($orp *12); ?></del></td>
                                                        <?php
                                                    }
                                                }
                                                if($this->session->userdata('currency') == '13')
                                                {
                                                    if($row['sale_price_JP'] > 0)
                                                    {
                                                        ?>
                                                        <td><del><?php echo currency().$orp *1; ?></del></td>
                                                        <td><del><?php echo currency().$orp *6; ?></del></td>
                                                        <td><del><?php echo currency().$orp *12; ?></del></td>
                                                        <?php
                                                    }
                                                    else
                                                    {
                                                        ?>
                                                        <td><del><?php echo currency($orp *1); ?></del></td>
                                                        <td><del><?php echo currency($orp *6); ?></del></td>
                                                        <td><del><?php echo currency($orp *12); ?></del></td>
                                                        <?php
                                                    }
                                                }
                                                if($this->session->userdata('currency') == '22')
                                                {
                                                    if($row['sale_price_SG'] > 0)
                                                    {
                                                        ?>
                                                        <td><del><?php echo currency().$orp *1; ?></del></td>
                                                        <td><del><?php echo currency().$orp *6; ?></del></td>
                                                        <td><del><?php echo currency().$orp *12; ?></del></td>
                                                        <?php
                                                    }
                                                    else
                                                    {
                                                        ?>
                                                        <td><del><?php echo currency($orp *1); ?></del></td>
                                                        <td><del><?php echo currency($orp *6); ?></del></td>
                                                        <td><del><?php echo currency($orp *12); ?></del></td>
                                                        <?php
                                                    }
                                                }
                                            ?>
                                            <?php
                                        }
                                        else
                                        {
                                            ?>
                                            <td><del></del></td>
                                            <td><del></del></td>
                                            <td><del></del></td>
                                            <?php
                                        }
                                        ?>
                                        </tr>
                                        <tr class="newpricetag">
                                            <?php
                                                if($this->session->userdata('currency') == '2')
                                                {
                                                    ?>
                                                    <td><?php echo currency($lat_sale_price1); ?></td>
                                                    <td><?php echo currency($lat_sale_price2); ?></td>
                                                    <td><?php echo currency($lat_sale_price3); ?></td>
                                                    <?php
                                                }
                                                if($this->session->userdata('currency') == '10')
                                                {
                                                    if($row['sale_price_HK'] > 0)
                                                    {
                                                        ?>
                                                        <td><?php echo currency().$lat_sale_price1; ?></td>
                                                        <td><?php echo currency().$lat_sale_price2; ?></td>
                                                        <td><?php echo currency().$lat_sale_price3; ?></td>
                                                        <?php
                                                    }
                                                    else
                                                    {
                                                        ?>
                                                        <td><?php echo currency($lat_sale_price1); ?></td>
                                                        <td><?php echo currency($lat_sale_price2); ?></td>
                                                        <td><?php echo currency($lat_sale_price3); ?></td>
                                                        <?php
                                                    }
                                                }
                                                if($this->session->userdata('currency') == '13')
                                                {
                                                    if($row['sale_price_JP'] > 0)
                                                    {
                                                        ?>
                                                        <td><?php echo currency().$lat_sale_price1; ?></td>
                                                        <td><?php echo currency().$lat_sale_price2; ?></td>
                                                        <td><?php echo currency().$lat_sale_price3; ?></td>
                                                        <?php
                                                    }
                                                    else
                                                    {
                                                        ?>
                                                        <td><?php echo currency($lat_sale_price1); ?></td>
                                                        <td><?php echo currency($lat_sale_price2); ?></td>
                                                        <td><?php echo currency($lat_sale_price3); ?></td>
                                                        <?php
                                                    }
                                                }
                                                if($this->session->userdata('currency') == '22')
                                                {
                                                    if($row['sale_price_SG'] > 0)
                                                    {
                                                        ?>
                                                        <td><?php echo currency().$lat_sale_price1; ?></td>
                                                        <td><?php echo currency().$lat_sale_price2; ?></td>
                                                        <td><?php echo currency().$lat_sale_price3; ?></td>
                                                        <?php
                                                    }
                                                    else
                                                    {
                                                        ?>
                                                        <td><?php echo currency($lat_sale_price1); ?></td>
                                                        <td><?php echo currency($lat_sale_price2); ?></td>
                                                        <td><?php echo currency($lat_sale_price3); ?></td>
                                                        <?php
                                                    }
                                                }
                                            ?>
                                        </tr>
                                    </table>
                                    <?php
                                }
                                ?>
                                </div>
                            </article>
                        </div>
                        <?php } ?>
                    </div>
                    <?php
                    if($total_latest > 5)
                    {
                        ?>
                    <!-- Add Arrows -->
                    <div class="swiper-buttons">
                        <div class="swiper-button-next" tabindex="0" role="button" aria-label="Next slide" aria-disabled="false"></div>
                        <div class="swiper-button-prev" tabindex="-1" role="button" aria-label="Previous slide" aria-disabled="true"></div>
                    </div>
                    <?php
                }
                ?>
                    <span class="swiper-notification" aria-live="assertive" aria-atomic="true"></span>
                </div>
            </div>
        </div>
        <!-- end -->
        <!-- new product -->
        <!-- product  -->
        <div class="feature-area mt-30px">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="section-title">
                            <h2 class="section-heading"><?php echo translate('recently_viewed');?></h2>
                        </div>
                    </div>
                </div>
                <div class="feature-slider slider-nav-style-1 swiper-container-initialized swiper-container-horizontal">
                    <div class="feature-slider-wrapper swiper-wrapper" style="transform: translate3d(0px, 0px, 0px);">
                        <?php
                            $recently_viewed=$this->crud_model->product_list_set('recently_viewed','');
                            $total_recently_viewed = count($recently_viewed);
                            foreach($recently_viewed as $row)
                            {

                        ?>
                        <!-- Single Item -->
                        <div class="feature-slider-item swiper-slide swiper-slide-active" style="width: 263.8px;">
                            <ul class="right-view new1">
                                <?php 
                                    if($row['discount'] > 0)
                                    {
                                        ?>
                                <div class="vendoroffer">
                                    <span><?php echo $row['discount']; ?>%</span>
                                    <p>OFF</p>
                                </div>
                                <li><img src="<?php echo base_url(); ?>template/omgee/images/iconfindericon/pricetag.png"></li>
                            <?php } ?>
                            </ul>
                            <?php
                                $productKey = searchArrayKeyVal("productid", $row['product_id'], $already_add_product_arr);
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
                                    if($row['num_of_imgs'] !=NULL)
                                    {
                                        $num_of_img = explode(",", $row['num_of_imgs']); 
                                        $first_image = base_url('uploads/product_image/'.$num_of_img[0]);
                                    }
                                    else
                                    {
                                        $first_image = base_url('uploads/product_image/default.jpg');
                                    }
                                    ?>
                                </li>
                            </ul>
                            <article class="list-product">
                                <div class="img-block productblock">
                                    <a href="<?php echo $this->crud_model->product_link($row['product_id']); ?>" class="thumbnail">
                                    <img class="first-img" src="<?php echo $first_image;?>" alt="">
                                    </a>
                                    <div class="quick-view">
                                        <a class="quick_view" href="#" data-link-action="quickview" title="Quick view" data-toggle="modal" data-target="#exampleModal">
                                        <i class="icon-magnifier icons"></i>
                                        </a>
                                    </div>
                                    <ul class="bottomleft">
                                    <?php 
                                    $row11 = $this->db->get_where('product',array('product_id'=> $row['product_id']))->row();
                                    $brands = $this->db->get_where('vendorbrands',array('id'=> $row11->brand))->row();
                                    ?>
                                    <p class = "text-white pl-3  "><?php echo $brands->name ?></p>
                                        <li>
                                            <a data-toggle="tooltip" title="<?php echo ucwords($row['title']); ?>" href="<?php echo $this->crud_model->product_link($row['product_id']); ?>"><h5 > 
                                                <?php 
                                                $cat_title = wordwrap(ucwords($row['title']), 19, '<br />', true); 
                                                echo mb_strimwidth($cat_title, 0, 40, "...");
                                                ?> </h5>
                                            </a>
                                        </li>
                                    </ul>
                                    <ul class="bottomproduct">
                                        <li><?php
                                    if($this->session->userdata('user_login')!='yes'){ 
                                    ?>
                                        <a  data-toggle="tooltip" title="<?php echo translate('_add_to_wishlist'); ?>" href="<?php echo base_url(); ?>home/login_set/login" ><i class="icon-heart"></i></a></li>
                                    <?php } else 
                                    { 
                                        $wish = $this->crud_model->is_wished($row['product_id']); 
                                        if($wish == 'yes')
                                        { 
                                            ?>
                                            <a data-toggle="tooltip" producttype="recently" title="<?php echo translate('_added_to_wishlist'); ?>"  pathaction="remove" href="javascript:void(0);" class="to_wishlist  product<?php echo $row['product_id']; ?>" productid="<?php echo $row['product_id']; ?>" ><ion-icon name="heart-sharp"></ion-icon></a>
                                            <?php
                                            } else {  ?>
                                                <a data-toggle="tooltip" producttype="recently" title="<?php echo translate('_add_to_wishlist'); ?>"  pathaction="add" href="javascript:void(0);" class="to_wishlist  product<?php echo $row['product_id']; ?>" productid="<?php echo $row['product_id']; ?>" > <ion-icon name="heart-outline"></ion-icon></a>
                                    <?php } }  ?></li>   
                                    </ul>
                                    <div class="rating-productone">
                                        <?php
                                            $recently_rating = $this->crud_model->getProductRating($row['product_id']);
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
                                    if($row['sale_price_AU']>0)
                                    {
                                        if($this->session->userdata('currency') == '2')
                                        {
                                            $rrp = $row['sale_price_AU'];
                                            $wholesale = $row['wholesale'];
                                        }
                                        else
                                        {
                                            $wholesale = $row['wholesale_EXCL_WET_GST'];
                                        }
                                        if($this->session->userdata('currency') == '10')
                                        {
                                            if($row['sale_price_HK'] > 0)
                                            {
                                                $rrp = $row['sale_price_HK'];
                                            }
                                            else
                                            {
                                                $rrp = $row['sale_price_AU'];
                                            }
                                        }
                                        if($this->session->userdata('currency') == '13')
                                        {
                                            if($row['sale_price_JP'] > 0)
                                            {
                                                $rrp = $row['sale_price_JP'];
                                            }
                                            else
                                            {
                                                $rrp = $row['sale_price_AU'];
                                            }
                                        }
                                        if($this->session->userdata('currency') == '22')
                                        {
                                            if($row['sale_price_SG'] > 0)
                                            {
                                                $rrp = $row['sale_price_SG'];
                                            }
                                            else
                                            {
                                                $rrp = $row['sale_price_AU'];
                                            }
                                        }

                                        $discount = ($row['discount']) ? ($row['discount']/100) : 0;
                                        
                                        if($row['limited_release']=="Yes")
                                        {
                                            $orp_commission_amount = ($this->db->get_where('business_settings', array('type' => 'limit_admin_orp_commission_amount'))->row()->value)/100;
                                        
                                            $commission_amount = ($this->db->get_where('business_settings', array('type' => 'limit_admin_commission_amount'))->row()->value)/100;   
                                        }
                                        else
                                        {
                                            $orp_commission_amount = ($this->db->get_where('business_settings', array('type' => 'nolimit_admin_orp_commission_amount'))->row()->value)/100;
                                        
                                            $commission_amount = ($this->db->get_where('business_settings', array('type' => 'nolimit_admin_commission_amount'))->row()->value)/100;
                                        }

                                        $gap_revenue = $rrp - $wholesale;
                                        $gap_revenue_commission = $gap_revenue * $commission_amount;    
                                        $orp = $rrp - (($gap_revenue - $gap_revenue_commission)*$orp_commission_amount);
                                        $total_discount = $orp * $discount;
                                        $total_orp = $orp - $total_discount;
                                    

                                        $lat_sale_price1 = $total_orp*1;
                                        $lat_sale_price2 = $total_orp*6;
                                        $lat_sale_price3 = $total_orp*12;

                                    ?>
                                    <table class="table table-striped" width="100%">
                                        <thead>
                                            <th class="text-center <?php if($row['discount'] == 0) { echo 'th_firstdata'; } ?>">Each</span></th>   
                                            <th class="text-center <?php if($row['discount'] == 0) { echo 'th_firstdata'; } ?>">Six</span></th>   
                                            <th class="text-center <?php if($row['discount'] == 0) { echo 'th_firstdata'; } ?>">Twelve</span></th>   
                                        </thead>
                                        <tr>
                                       <?php
                                            if($row['discount'] > 0)
                                            {
                                                if($this->session->userdata('currency') == '2')
                                                {
                                                    ?>
                                                    <td><del><?php echo currency($orp *1); ?></del></td>
                                                    <td><del><?php echo currency($orp *6); ?></del></td>
                                                    <td><del><?php echo currency($orp *12); ?></del></td>
                                                    <?php
                                                }
                                                if($this->session->userdata('currency') == '10')
                                                {
                                                    if($row['sale_price_HK'] > 0)
                                                    {
                                                        ?>
                                                        <td><del><?php echo currency().$orp *1; ?></del></td>
                                                        <td><del><?php echo currency().$orp *6; ?></del></td>
                                                        <td><del><?php echo currency().$orp *12; ?></del></td>
                                                        <?php
                                                    }
                                                    else
                                                    {
                                                        ?>
                                                        <td><del><?php echo currency($orp *1); ?></del></td>
                                                        <td><del><?php echo currency($orp *6); ?></del></td>
                                                        <td><del><?php echo currency($orp *12); ?></del></td>
                                                        <?php
                                                    }
                                                }
                                                if($this->session->userdata('currency') == '13')
                                                {
                                                    if($row['sale_price_JP'] > 0)
                                                    {
                                                        ?>
                                                        <td><del><?php echo currency().$orp *1; ?></del></td>
                                                        <td><del><?php echo currency().$orp *6; ?></del></td>
                                                        <td><del><?php echo currency().$orp *12; ?></del></td>
                                                        <?php
                                                    }
                                                    else
                                                    {
                                                        ?>
                                                        <td><del><?php echo currency($orp *1); ?></del></td>
                                                        <td><del><?php echo currency($orp *6); ?></del></td>
                                                        <td><del><?php echo currency($orp *12); ?></del></td>
                                                        <?php
                                                    }
                                                }
                                                if($this->session->userdata('currency') == '22')
                                                {
                                                    if($row['sale_price_SG'] > 0)
                                                    {
                                                        ?>
                                                        <td><del><?php echo currency().$orp *1; ?></del></td>
                                                        <td><del><?php echo currency().$orp *6; ?></del></td>
                                                        <td><del><?php echo currency().$orp *12; ?></del></td>
                                                        <?php
                                                    }
                                                    else
                                                    {
                                                        ?>
                                                        <td><del><?php echo currency($orp *1); ?></del></td>
                                                        <td><del><?php echo currency($orp *6); ?></del></td>
                                                        <td><del><?php echo currency($orp *12); ?></del></td>
                                                        <?php
                                                    }
                                                }
                                            ?>
                                            <?php
                                        }
                                        else
                                        {
                                            ?>
                                            <td><del></del></td>
                                            <td><del></del></td>
                                            <td><del></del></td>
                                            <?php
                                        }
                                        ?>
                                        </tr>
                                        <tr class="newpricetag">
                                            <?php
                                                if($this->session->userdata('currency') == '2')
                                                {
                                                    ?>
                                                    <td><?php echo currency($lat_sale_price1); ?></td>
                                                    <td><?php echo currency($lat_sale_price2); ?></td>
                                                    <td><?php echo currency($lat_sale_price3); ?></td>
                                                    <?php
                                                }
                                                if($this->session->userdata('currency') == '10')
                                                {
                                                    if($row['sale_price_HK'] > 0)
                                                    {
                                                        ?>
                                                        <td><?php echo currency().$lat_sale_price1; ?></td>
                                                        <td><?php echo currency().$lat_sale_price2; ?></td>
                                                        <td><?php echo currency().$lat_sale_price3; ?></td>
                                                        <?php
                                                    }
                                                    else
                                                    {
                                                        ?>
                                                        <td><?php echo currency($lat_sale_price1); ?></td>
                                                        <td><?php echo currency($lat_sale_price2); ?></td>
                                                        <td><?php echo currency($lat_sale_price3); ?></td>
                                                        <?php
                                                    }
                                                }
                                                if($this->session->userdata('currency') == '13')
                                                {
                                                    if($row['sale_price_JP'] > 0)
                                                    {
                                                        ?>
                                                        <td><?php echo currency().$lat_sale_price1; ?></td>
                                                        <td><?php echo currency().$lat_sale_price2; ?></td>
                                                        <td><?php echo currency().$lat_sale_price3; ?></td>
                                                        <?php
                                                    }
                                                    else
                                                    {
                                                        ?>
                                                        <td><?php echo currency($lat_sale_price1); ?></td>
                                                        <td><?php echo currency($lat_sale_price2); ?></td>
                                                        <td><?php echo currency($lat_sale_price3); ?></td>
                                                        <?php
                                                    }
                                                }
                                                if($this->session->userdata('currency') == '22')
                                                {
                                                    if($row['sale_price_SG'] > 0)
                                                    {
                                                        ?>
                                                        <td><?php echo currency().$lat_sale_price1; ?></td>
                                                        <td><?php echo currency().$lat_sale_price2; ?></td>
                                                        <td><?php echo currency().$lat_sale_price3; ?></td>
                                                        <?php
                                                    }
                                                    else
                                                    {
                                                        ?>
                                                        <td><?php echo currency($lat_sale_price1); ?></td>
                                                        <td><?php echo currency($lat_sale_price2); ?></td>
                                                        <td><?php echo currency($lat_sale_price3); ?></td>
                                                        <?php
                                                    }
                                                }
                                            ?>
                                        </tr>
                                    </table>
                                    <?php }  ?>
                                </div>
                            </article>
                        </div>
                        <?php
                        }
                        ?>
                    </div>
                    <?php
                    if($total_recently_viewed > 5)
                    {
                        ?>
                    <!-- Add Arrows -->
                    <div class="swiper-buttons">
                        <div class="swiper-button-next" tabindex="0" role="button" aria-label="Next slide" aria-disabled="false"></div>
                        <div class="swiper-button-prev" tabindex="-1" role="button" aria-label="Previous slide" aria-disabled="true"></div>
                    </div>
                    <?php
                }
                ?>
                    <span class="swiper-notification" aria-live="assertive" aria-atomic="true"></span>
                </div>
            </div>
        </div>
        <!-- end -->
        <!-- support section -->
        <section class="supportblock">
            <div class="container">
                <div class="row marginzero">
                    <div class="col-lg-3 col-md-6 col-sm-6 col-xs-3 paddingzero">
                        <div class="supportmain">
                            <img src="<?php echo base_url(); ?>template/omgee/images/iconfindericon/shop.png">
                            <?php 
                                $footer_logo_text1 =  $this->db->get_where('general_settings',array('type' => 'footer_logo_text1'))->row()->value;
                                $footer_logo_text2 =  $this->db->get_where('general_settings',array('type' => 'footer_logo_text2'))->row()->value;
                                $footer_logo_text3 =  $this->db->get_where('general_settings',array('type' => 'footer_logo_text3'))->row()->value;
                                $footer_logo_text4 =  $this->db->get_where('general_settings',array('type' => 'footer_logo_text4'))->row()->value;
                            ?>
                            <p> <?php 
                                    $cat_footer_logo_text1 = wordwrap(ucwords($footer_logo_text1), 40, '<br />', true); 
                                    echo mb_strimwidth($cat_footer_logo_text1, 0, 85, "..."); 
                                ?> 
                            </p>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-6 col-xs-3 paddingzero">
                        <div class="supportmain">
                            <img src="<?php echo base_url(); ?>template/omgee/images/iconfindericon/support.png">
                            <p> <?php 
                                    $cat_footer_logo_text2 = wordwrap(ucwords($footer_logo_text2), 40, '<br />', true); 
                                    echo mb_strimwidth($cat_footer_logo_text2, 0, 85, "..."); 
                                ?> 
                            </p>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-6 col-xs-3 paddingzero">
                        <div class="supportmain">
                            <img src="<?php echo base_url(); ?>template/omgee/images/iconfindericon/delievery.png">
                            <p> <?php 
                                    $cat_footer_logo_text3 = wordwrap(ucwords($footer_logo_text3), 40, '<br />', true); 
                                    echo mb_strimwidth($cat_footer_logo_text3, 0, 85, "..."); 
                                ?> 
                            </p>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-6 col-xs-3 paddingzero">
                        <div class="supportmain">
                            <img src="<?php echo base_url(); ?>template/omgee/images/iconfindericon/document.png">
                            <p> <?php 
                                    $cat_footer_logo_text4 = wordwrap(ucwords($footer_logo_text4), 40, '<br />', true); 
                                    echo mb_strimwidth($cat_footer_logo_text4, 0, 85, "..."); 
                                ?> 
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <script>
            $(document).ready(function (){
                var price_tags = $('.newpricetag');
                for(let i=0;i<price_tags.length;i++)
                {
                    var prices = $(price_tags[i]).find('td');
                    for (let j = 1; j < prices.length; j++) {
                        let current_price = $(prices[j]).html();
                        let currency = current_price.slice(0,1)
                        current_price = current_price.slice(1)
                        if(j==1) current_price = current_price * 95 / 100
                        if(j==2) current_price = current_price * 90 / 100
                        $(prices[j]).html(currency + current_price.toFixed(2))
                    }
                }
            })
            
        </script>