<div class="shop-list-wrap mb-30px scroll-zoom">
    <div class="row list-product m-0px">
        <div class="col-md-12 padding-0px">
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-4 col-lg-3">
                    <div class="left-img">
                        <div class="img-block productfirst">
                            <a href="<?php echo $this->crud_model->product_link($product_id); ?>" class="thumbnail">
                            <?php
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
                            <img class="first-img" src="<?php echo $first_image;?>" alt="">
                            </a>
                            <div class="quick-view">
                                <a class="quick_view" href="#" data-link-action="quickview" title="Quick view" data-toggle="modal" data-target="#exampleModal">
                                <i class="ion-ios-search-strong"></i>
                                </a>
                            </div>
                        </div>
                        <ul class="product-flag tagpro ">
                            <?php
                                $latest=$this->crud_model->product_list_set('latest','');
                                    foreach($latest as $row)
                                    {
                                        if($product_id == $row['product_id'])
                                        {
                                        ?>    
                            <li class="new">New</li>
                            <?php    
                                }
                                }
                                ?>
                            <?php
                                $popular_products = $this->db->get_where('product',array('featured'=>'ok','status'=>'ok'))->result_array();
                                foreach ($popular_products as $pdtvalue) 
                                {
                                    if($product_id == $pdtvalue['product_id'])
                                    {
                                    ?>    
                            <li class="new">Popular</li>
                            <?php    
                                }
                                }
                                ?>
                            <?php
                                $topdeal_products = $this->db->get_where('product',array('deal'=>'ok','status'=>'ok'))->result_array();
                                foreach ($topdeal_products as $value) 
                                {
                                    if($product_id == $value['product_id'])
                                    {
                                    ?>    
                            <li class="new">Top Deals</li>
                            <?php    
                                }
                                }
                                ?>
                        </ul>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-8 col-lg-9">
                    <div class="product-desc-wrap">
                        <div class="product-decs">
                            <a class="inner-link" href="<?php echo $this->crud_model->product_link($product_id); ?>">
                            <span>
                            <?php 
                                $cat_title = wordwrap(ucwords($title), 19, '<br />', true); 
                                echo mb_strimwidth($cat_title, 0, 40, "...");
                                ?>
                            </span>
                            </a><?php $sub_category = $this->crud_model->get_type_name_by_id('sub_category',$sub_category,'sub_category_name');?>
                            <h2><a href="#" class="product-link"><?php echo $this->crud_model->get_type_name_by_id('category',$category,'category_name');?>
                                <?php
                                    if($sub_category)
                                    {
                                        echo " ,".$sub_category;
                                    }
                                    ?>
                                </a>
                            </h2>
                            <div class="rating-product">
                                <?php
                                    $recently_rating = $this->crud_model->getProductRating($product_id);
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
                            <div class="product-intro-info">
                                <p><?php echo $description; ?></p>
                            </div>
                        </div>
                        <div class="box-inner">
                            <div class="producttable">
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
                                    
                                        $wholesale = $wholesale;
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
                                </table>
                                <?php   }  ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>