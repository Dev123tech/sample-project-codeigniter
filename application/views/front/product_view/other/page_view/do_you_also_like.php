<?php
    $do_yo_also_likes = $this->db->get_where('product',array('added_by'=>$row['added_by']))->result_array();
    $total_similar_product = count($do_yo_also_likes);
    $latest = $this->crud_model->lastOneWeekproduct();
    $latest_product_ids = array();

    foreach ($latest as $key => $value) 
    {
        $latest_product_ids[] = $value['product_id'];
    }
?>
    <div class="feature-area mt-30px">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="section-title">
                        <h2 class="section-heading">
                            <?php 
                                $count = 0;
                                foreach($do_yo_also_likes as $similar)
                                {    
                                    if($count == 0) {
                                        echo "You May Also Like";    
                                    } 
                                    $count++;   
                                }    
                            ?>
                        </h2>
                    </div>
                </div>
            </div>
            <div class="feature-slider slider-nav-style-1 swiper-container-initialized swiper-container-horizontal">
                <div class="feature-slider-wrapper swiper-wrapper" style="transform: translate3d(0px, 0px, 0px);">
                    <!--single Item  -->
                    <?php
                        foreach($do_yo_also_likes as $similar)
                        {
                    ?>
                    <div class="feature-slider-item swiper-slide swiper-slide-active" style="width: 263.8px;">
                        <ul class="right-view new1">
                                <?php 
                                    if($similar['discount'] > 0)
                                    {
                                        ?>
                                <div class="vendoroffer">
                                    <span><?php echo $similar['discount']; ?>%</span>
                                    <p>OFF</p>
                                </div>
                                <li><img src="<?php echo base_url(); ?>template/omgee/images/iconfindericon/pricetag.png"></li>
                            <?php } ?>
                            </ul>
                        <?php
                            $productKey = searchArrayKeyVal("productid", $similar['product_id'], $already_add_product_arr);
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
                                        if(in_array($similar['product_id'],$latest_product_ids))
                                        {
                                            ?>
                                                <img src="<?php echo base_url(); ?>template/omgee/images/iconfindericon/new_cash.png">
                                        <?php
                                        }
                                        else
                                        {
                                            ?>
                                                <img src="<?php echo base_url(); ?>template/omgee/images/iconfindericon/cashback.png">
                                        <?php
                                        }
                                
                                }
                                if($similar['num_of_imgs'] !=NULL)
                                {
                                    $num_of_img = explode(",", $similar['num_of_imgs']); 
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
                                <a href="<?php echo $this->crud_model->product_link($similar['product_id']); ?>" class="thumbnail">
                                    <img class="first-img" src="<?php echo $first_image;?>" alt="">
                                </a>
                                <div class="quick-view">
                                    <a class="quick_view" href="#" data-link-action="quickview" title="Quick view" data-toggle="modal" data-target="#exampleModal">
                                        <i class="icon-magnifier icons"></i>
                                    </a>
                                </div>
                                <ul class="bottomleft">
                                    <?php 
                                    $row11 = $this->db->get_where('product',array('product_id'=> $similar['product_id']))->row();
                                    $brands = $this->db->get_where('vendorbrands',array('id'=> $row11->brand))->row();
                                    ?>
                                    <p class = "text-white pl-3  "><?php echo $brands->name ?></p>
                                    <li>
                                        <a data-toggle="tooltip" title="<?php echo ucwords($similar['title']); ?>" href="<?php echo $this->crud_model->product_link($similar['product_id']); ?>"><h5 > 
                                            <?php 
                                            $cat_title = wordwrap(ucwords($similar['title']), 19, '<br />', true); 
                                            echo mb_strimwidth($cat_title, 0, 40, "...");
                                            ?> </h5>
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
                                        $wish = $this->crud_model->is_wished($similar['product_id']); 
                                        if($wish == 'yes')
                                        { 
                                            ?>
                                            <a data-toggle="tooltip" producttype="related" title="<?php echo translate('_added_to_wishlist'); ?>"  pathaction="remove" href="javascript:void(0);" class="to_wishlist  product<?php echo $similar['product_id']; ?>" productid="<?php echo $similar['product_id']; ?>" ><ion-icon name="heart-sharp"></ion-icon></a>
                                            <?php
                                            } else {  ?>
                                                <a data-toggle="tooltip" producttype="related" title="<?php echo translate('_add_to_wishlist'); ?>"  pathaction="add" href="javascript:void(0);" class="to_wishlist  product<?php echo $similar['product_id']; ?>" productid="<?php echo $similar['product_id']; ?>" > <ion-icon name="heart-outline"></ion-icon></a>
                                    <?php } }  ?>
                                   </li>
                                </ul>
                                <div class="rating-productone">
                                    <?php
                                            $recently_rating = $this->crud_model->getProductRating($similar['product_id']);
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
                                    if($this->session->userdata('currency') == '2')
                                    {
                                        $rrp = $similar['sale_price_AU'];
                                        $wholesale = $similar['wholesale'];
                                    }
                                    else
                                    {
                                        $wholesale = $similar['wholesale_EXCL_WET_GST'];
                                    }
                                    if($this->session->userdata('currency') == '10')
                                    {
                                        if($similar['sale_price_HK'] > 0)
                                        {
                                            $rrp = $similar['sale_price_HK'];
                                        }
                                        else
                                        {
                                            $rrp = $similar['sale_price_AU'];
                                        }
                                    }
                                    if($this->session->userdata('currency') == '13')
                                    {
                                        if($similar['sale_price_JP'] > 0)
                                        {
                                            $rrp = $similar['sale_price_JP'];
                                        }
                                        else
                                        {
                                            $rrp = $similar['sale_price_AU'];
                                        }
                                    }
                                    if($this->session->userdata('currency') == '22')
                                    {
                                        if($similar['sale_price_SG'] > 0)
                                        {
                                            $rrp = $similar['sale_price_SG'];
                                        }
                                        else
                                        {
                                            $rrp = $similar['sale_price_AU'];
                                        }
                                    }

                                    $wholesale = $similar['wholesale'];
                                    $discount = ($similar['discount']) ? ($similar['discount']/100) : 0;
                                    
                                    if($similar['limited_release']=="Yes")
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
                                        <th class="text-center <?php if($similar['discount'] == 0) { echo 'th_firstdata'; } ?>">Each</span></th>   
                                        <th class="text-center <?php if($similar['discount'] == 0) { echo 'th_firstdata'; } ?>">Six</span></th>   
                                        <th class="text-center <?php if($similar['discount'] == 0) { echo 'th_firstdata'; } ?>">Twelve</span></th>   
                                    </thead>
                                    <tr>
                                         <?php
                                            if($similar['discount'] > 0)
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
                                                    if($similar['sale_price_HK'] > 0)
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
                                                    if($similar['sale_price_JP'] > 0)
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
                                                    if($similar['sale_price_SG'] > 0)
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
                                                    if($similar['sale_price_HK'] > 0)
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
                                                    if($similar['sale_price_JP'] > 0)
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
                                                    if($similar['sale_price_SG'] > 0)
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
                            </div>                           
                        </article>
                    </div>
                    <?php } ?> 
                </div>
                <?php if($total_similar_product > 5) {  ?>
                    <div class="swiper-buttons">
                        <div class="swiper-button-next" tabindex="0" role="button" aria-label="Next slide" aria-disabled="false"></div>
                        <div class="swiper-button-prev swiper-button-disabled" tabindex="-1" role="button" aria-label="Previous slide" aria-disabled="true"></div>
                    </div>
                <?php  }  ?>
                <span class="swiper-notification" aria-live="assertive" aria-atomic="true"></span>
            </div>
        </div>
    </div>