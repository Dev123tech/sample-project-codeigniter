<div class="col-xl-3 col-md-4 col-sm-6 alllistsec">
    <div class="feature-slider-item swiper-slide">
        <ul class="right-view new1">
            <?php 
                if($discount > 0)
                {
                    ?>
            <div class="vendoroffer">
                <span><?php echo $discount; ?>%</span>
                <p>OFF</p>
            </div>
            <li><img src="<?php echo base_url(); ?>template/omgee/images/iconfindericon/pricetag.png"></li>
            <?php } ?>
        </ul>
        <?php
            $coupon_price = 0;
            $cashback_product = $this->db->get_where('coupon')->result_array();
            $already_add_product_arr = array();
            $productKey = 0;
            $discount_value = 0;
            $discount_type = 0;
            $current_date = date('Y-m-d');
            
            foreach($cashback_product as $key => $value) 
            {
                $already_add_product_ar = json_decode($value['spec']);
            
                if(strtotime($value['till']) > strtotime($current_date))
                {
                    $till_ar[] = strtotime($value['till']);
            
                    foreach(json_decode($already_add_product_ar->set) as $key => $productids) 
                    {
                        if($productids == $product_id) 
                        {
                           $productKey =  $productids;
                           $discount_value = $already_add_product_ar->discount_value;
                           $discount_type = $already_add_product_ar->discount_type;
                        }
                    }
                }
            }
            if($productKey > 0 ) 
            {
                ?>
        <div class="triangle-bottomleft">
            <span><?php echo $discount_value; ?> <?php echo ($discount_type=='percent') ? '%':currency(); ?> OFF</span>
        </div>
        <?php
            }
            ?>
        <ul class="product-flag">
            <?php
                $latest = $this->crud_model->lastOneWeekproduct();
                $latest_product_ids = array();
                
                foreach ($latest as $key => $value) 
                {
                    $latest_product_ids[] = $value['product_id'];
                }
                if($productKey > 0) 
                {
                    if(in_array($productKey,$latest_product_ids))
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
                if($num_of_imgs !=NULL)
                {
                $num_of_img = explode(",", $num_of_imgs); 
                $first_image = base_url('uploads/product_image/'.$num_of_img[0]);
                }
                else
                {
                $first_image = base_url('uploads/product_image/default.jpg');
                }    
                ?>
        </ul>
        <article class="list-product">
            <div class="img-block productblock">
                <a href="<?php echo $this->crud_model->product_link($product_id); ?>" class="thumbnail">
                <img class="first-img" src="<?php echo $first_image; ?>" alt="">
                </a>
                <div class="quick-view">
                    <a class="quick_view" href="#" data-link-action="quickview" title="Quick view" data-toggle="modal" data-target="#exampleModal">
                    <i class="icon-magnifier icons"></i>
                    </a>
                </div>
                <ul class="bottomleft">
                    <li>
                        <a data-toggle="tooltip" title="<?php echo ucwords($title); ?>" href="<?php echo $this->crud_model->product_link($product_id); ?>">
                            <h5 >
                                <?php 
                                    $cat_title = wordwrap(ucwords($title), 19, '<br />', true); 
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
                        <a  data-toggle="tooltip" title="<?php echo translate('_add_to_wishlist'); ?>" href="<?php echo base_url(); ?>home/login_set/login" >
                        <i class="icon-heart"></i>
                        </a>
                        <?php } else 
                            { 
                                $wish = $this->crud_model->is_wished($product_id); 
                                if($wish == 'yes')
                                { 
                                    ?>
                        <a data-toggle="tooltip" producttype="related" title="<?php echo translate('_added_to_wishlist'); ?>"  pathaction="remove" href="javascript:void(0);" class="to_wishlist  product<?php echo $product_id; ?>" productid="<?php echo $product_id; ?>" >
                            <ion-icon name="heart-sharp"></ion-icon>
                        </a>
                        <?php
                            } else {  ?>
                        <a data-toggle="tooltip" producttype="related" title="<?php echo translate('_add_to_wishlist'); ?>"  pathaction="add" href="javascript:void(0);" class="to_wishlist  product<?php echo $product_id; ?>" productid="<?php echo $product_id; ?>" >
                            <ion-icon name="heart-outline"></ion-icon>
                        </a>
                        <?php } }  ?>
                    </li>
                </ul>
                <div class="rating-productone">
                    <?php
                        $rating = $this->crud_model->getProductRating($product_id);
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
                    if($sale_price_AU>0)
                    {
                    if($this->session->userdata('currency') == '2')
                    {
                        $rrp = $sale_price_AU;
                        $wholesale = $wholesale;
                    }
                    else
                    {
                        $wholesale = $wholesale_EXCL_WET_GST;
                    }
                    if($this->session->userdata('currency') == '10')
                    {
                        if($sale_price_HK > 0)
                        {
                            $rrp = $sale_price_HK;
                        }
                        else
                        {
                            $rrp = $sale_price_AU;
                        }
                    }
                    if($this->session->userdata('currency') == '13')
                    {
                        if($sale_price_JP > 0)
                        {
                            $rrp = $sale_price_JP;
                        }
                        else
                        {
                            $rrp = $sale_price_AU;
                        }
                    }
                    if($this->session->userdata('currency') == '22')
                    {
                        if($sale_price_SG > 0)
                        {
                            $rrp = $sale_price_SG;
                        }
                        else
                        {
                            $rrp = $sale_price_AU;
                        }
                    }
                    
                    
                    $discount = ($discount) ? ($discount/100) : 0;
                    
                    if($limited_release=="Yes")
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
                        <th class="text-center <?php if($discount == 0) { echo 'th_firstdata'; } ?>">Each</span></th>
                        <th class="text-center <?php if($discount == 0) { echo 'th_firstdata'; } ?>">Six</span></th>
                        <th class="text-center <?php if($discount == 0) { echo 'th_firstdata'; } ?>">Twelve</span></th>
                    </thead>
                    <tr>
                   <?php
                        if($discount > 0)
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
                                if($sale_price_HK > 0)
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
                                if($sale_price_JP > 0)
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
                                if($sale_price_SG > 0)
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
                                if($sale_price_HK > 0)
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
                                if($sale_price_JP > 0)
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
                                if($sale_price_SG > 0)
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
                <?php   }  ?>
            </div>
        </article>
    </div>
</div>