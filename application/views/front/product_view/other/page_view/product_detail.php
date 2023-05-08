<?php


$max_stock = 72;
$coupon_price = 0;
$cashback_product = $this->db->get_where('coupon')->result_array();
$already_add_product_arr = array();

$current_date = date('Y-m-d');

foreach ($cashback_product as $key => $value) {
    $already_add_product_ar = json_decode($value['spec']);

    if (strtotime($value['till']) > strtotime($current_date)) {
        $till_ar[] = strtotime($value['till']);

        foreach (json_decode($already_add_product_ar->set) as $key => $productids) {
            $already_add_product_arr[] = array('productid' => $productids, 'discount_type' => $already_add_product_ar->discount_type, 'discount_value' => $already_add_product_ar->discount_value);
        }
    }
}
function searchArrayKeyVal($sKey, $id, $array)
{
    foreach ($array as $key => $val) {
        if ($val[$sKey] == $id) {
            return $key;
        }
    }
    return false;
}
$productKey = searchArrayKeyVal("productid", $row['product_id'], $already_add_product_arr);
if ($productKey !== false) {
    $coupon_price = $already_add_product_arr[$productKey]['discount_value'];
}

function array_msort($array, $cols)
{
    $colarr = array();
    foreach ($cols as $col => $order) {
        $colarr[$col] = array();
        foreach ($array as $k => $row) {
            $colarr[$col]['_' . $k] = strtolower($row[$col]);
        }
    }
    $eval = 'array_multisort(';
    foreach ($cols as $col => $order) {
        $eval .= '$colarr[\'' . $col . '\'],' . $order . ',';
    }
    $eval = substr($eval, 0, -1) . ');';
    eval($eval);
    $ret = array();
    foreach ($colarr as $col => $arr) {
        foreach ($arr as $k => $v) {
            $k = substr($k, 1);
            if (!isset($ret[$k])) $ret[$k] = $array[$k];
            $ret[$k][$col] = $array[$k][$col];
        }
    }
    return $ret;
}

if ($this->session->userdata('currency') == '2') {
    $rrp = $row['sale_price_AU'];
    $wholesale = $row['wholesale'];
} else {
    $wholesale = $row['wholesale_EXCL_WET_GST'];
}
if ($this->session->userdata('currency') == '10') {
    if ($row['sale_price_HK'] > 0) {
        $rrp = $row['sale_price_HK'];
    } else {
        $rrp = $row['sale_price_AU'];
    }
}
if ($this->session->userdata('currency') == '13') {
    if ($row['sale_price_JP'] > 0) {
        $rrp = $row['sale_price_JP'];
    } else {
        $rrp = $row['sale_price_AU'];
    }
}
if ($this->session->userdata('currency') == '22') {
    if ($row['sale_price_SG'] > 0) {
        $rrp = $row['sale_price_SG'];
    } else {
        $rrp = $row['sale_price_AU'];
    }
}

$discount = ($row['discount']) ? ($row['discount'] / 100) : 0;


if ($row['limited_release'] == "Yes") {
    $orp_commission_amount = ($this->db->get_where('business_settings', array('type' => 'limit_admin_orp_commission_amount'))->row()->value) / 100;

    $commission_amount = ($this->db->get_where('business_settings', array('type' => 'limit_admin_commission_amount'))->row()->value) / 100;
} else {
    $orp_commission_amount = ($this->db->get_where('business_settings', array('type' => 'nolimit_admin_orp_commission_amount'))->row()->value) / 100;

    $commission_amount = ($this->db->get_where('business_settings', array('type' => 'nolimit_admin_commission_amount'))->row()->value) / 100;
}

function price_formula($rrp, $wholesale, $commission_amount, $orp_commission_amount, $discount)
{
    $gap_revenue = $rrp - $wholesale;
    $gap_revenue_commission = $gap_revenue * $commission_amount;
    $orp = $rrp - (($gap_revenue - $gap_revenue_commission) * $orp_commission_amount);
    $total_discount = $orp * $discount;
    $total_orp = $orp - $total_discount;
    return $total_orp;
}
$tmp = json_decode($row['added_by']);
$vendor_data = $this->db->get_where('vendor', array(
    'vendor_id' => $tmp->id
))->result_array();

foreach ($vendor_data as $tmp) {
    $company_image = $tmp['company_image'];
}

$brands = $this->db->get_where('vendorbrands',array('id'=> $row['brand']))->row();



?>
<style>
    .pro_main_detail .jzoom img {
        border: 3px solid #fff;
    }

    .pro_main_detail .jzoom {
        position: relative;
        top: 0px;
        left: 100px;
        width: 350px;
        height: 350px;
    }

    .pro_main_detail h1 {
        margin-top: 150px;
        margin-left: 100px;
        color: #fff;
    }

    .pro_main_detail .zoomnew {
        position: relative;
        display: block;
        margin: 2% 0;
    }

    .pro_main_detail .pro_new_slider .swiper-slide {
        width: 115px !important;
        margin: 8px 10px !important;
    }

    .zoomLens {
        height: 30px !important;
        width: 30px !important;
    }

    .pro_main_detail .zoompro {
        height: 400px !important;
        width: 400px !important;
        position: relative;
        margin: 0 auto !important;
        left: 79px !important;
    }

    .pro_main_detail .swiper-container {
        z-index: 1 !important;
    }

    .pro_main_detail .tas_lik {
        margin-left: 20px !important;
        margin-top: 30px !important;
        margin-bottom: 17px !important;
    }

    @media(max-width: 540px) {
        .pro_main_detail .zoompro {
            position: inherit !important;
            width: 100% !important;
            left: 0 !important;
            height: 100% !important;
        }

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
                        <li><a href="<?php echo base_url(); ?>">Home</a></li>
                        <li>Product Detail</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Breadcrumb Area End-->
<!-- Shop details Area start -->
<section class="product-details-area pro_main_detail mtb-10px">
    <div class="container">
        <div class="row">
            <div class="col-xl-6 col-lg-6 col-md-12">
                <div class="product-details-img product-details-tab">
                    <div class="zoompro-2">
                        <div class="zoompro-border zoompro-span">
                            <?php
                            if ($row['num_of_imgs'] != NULL) {
                                $num_of_img = explode(",", $row['num_of_imgs']);
                                $first_image = base_url('uploads/product_image/' . $num_of_img[0]);
                            } else {
                                $first_image = base_url('uploads/product_image/default.jpg');
                            }
                            ?>
                            <img class="zoompro" src="<?php echo $first_image; ?>" data-zoom-image="<?php echo $first_image; ?>" alt="">
                        </div>
                    </div>
                    <div id="gallery" class="product-dec-slider-2 swiper-container pro_new_slider swiper-container-initialized swiper-container-horizontal">
                        <div class="swiper-wrapper" style="transform: translate3d(0px, 0px, 0px);">
                            <?php 
                            if ($row['num_of_imgs'] != NULL) {
                                $thumb_counter = 1;
                                $mains = explode(",", $row['num_of_imgs']);
                                foreach ($mains as $row1) {
                                    if ($thumb_counter == '1') {
                            ?>
                                     <?php 
                                        $images1 = explode(",",$company_image);
                                        if($images1)
                                        {
                                            foreach ($images1 as $row11)
                                            {
                                        ?>
                                        <div class = "d-flex">
                                            <div class="swiper-slide  swiper-slide-active" style="width: 145.75px; margin-right: 10px;">
                                                <a class="active" data-image="<?php echo base_url('uploads/product_image/' . $row1); ?>" data-zoom-image="<?php echo base_url('uploads/product_image/' . $row1); ?>">
                                                    <img class="img-responsive" src="<?php echo base_url('uploads/events_image/' . $row11); ?>" alt="">
                                                    
                                                </a>
                                                
                                            </div>
                                            <div class = "d-flex align-items-center"><h4 class="text-white "><?php echo $brands->name ?><h4></div>
                                        </div>
                                        <?php 
                                            } 
                                        } 
                                        ?>
                                    <?php
                                    } elseif ($thumb_counter == '2') {
                                    ?>
                                        <div class="swiper-slide swiper-slide-next" style="width: 145.75px; margin-right: 10px;">
                                            <a data-image="<?php echo base_url('uploads/product_image/' . $row1); ?>" data-zoom-image="<?php echo base_url('uploads/product_image/' . $row1); ?>">
                                                <img class="img-responsive" src="<?php echo base_url('uploads/product_image/' . $row1); ?>" alt="">
                                            </a>
                                        </div>
                                    <?php
                                    } else {
                                    ?>
                                        <div class="swiper-slide" style="width: 145.75px; margin-right: 10px;">
                                            <a data-image="<?php echo base_url('uploads/product_image/' . $row1); ?>" data-zoom-image="<?php echo base_url('uploads/product_image/' . $row1); ?>">
                                                <img class="img-responsive" src="<?php echo base_url('uploads/product_image/' . $row1); ?>" alt="">
                                            </a>
                                        </div>
                                    <?php } ?>
                            <?php $thumb_counter++;
                                }
                            } ?>
                        </div>
                        <span class="swiper-notification" aria-live="assertive" aria-atomic="true"></span>
                    </div>
                </div>
                <?php
                $numbers = array($row['test1_number'], $row['test11_number'], $row['test2_number'], $row['test22_number'], $row['test3_number'], $row['test33_number'], $row['test4_number'], $row['test44_number'], $row['test5_number'], $row['test55_number']);

                $arr1 = array(
                    array('id' => $row['test1_number'], 'name' => $row['test1_name']),
                    array('id' => $row['test11_number'], 'name' => $row['test11_name']),
                    array('id' => $row['test2_number'], 'name' => $row['test2_name']),
                    array('id' => $row['test22_number'], 'name' => $row['test22_name']),
                    array('id' => $row['test3_number'], 'name' => $row['test3_name']),
                    array('id' => $row['test33_number'], 'name' => $row['test33_name']),
                    array('id' => $row['test4_number'], 'name' => $row['test4_name']),
                    array('id' => $row['test44_number'], 'name' => $row['test44_name']),
                    array('id' => $row['test5_number'], 'name' => $row['test5_name']),
                    array('id' => $row['test55_number'], 'name' => $row['test55_name'])
                );

                $arr2 = array_msort($arr1, array('id' => SORT_DESC));

                $newarr2 = array();
                foreach ($arr2 as $key => $value) {
                    $newarr2[] = $value;
                }


                ?>
                <?php
                if ($row['test_section'] == 'yes') {
                ?>
                    <!-- new section -->
                    <div class="section-title taste_meter_div" >
                        <h2 class="section-heading tas_lik"><?php /*echo $row['test_title'] ? ucwords($row['test_title']) : 'Taste Meter'*/ ?>Taste Meter</h2>
                    </div>
                    <?php
                    $show_section = "No";
                    foreach ($newarr2 as $key => $value) {
                        if ($key < 3) {
                            if($value['id'] != "0")
                                $show_section = "Yes";

                            
                    ?>
                            <div class="row tasteview d-none d-md-flex taste_meter_div">
                                <div class="col-sm-2 tasteviewpar">
                                    <p> <?php echo ucwords($value['name']); ?> </p>
                                </div>

                                <div class="col-sm-8 text-center">
                                    <ul>
                                        <li>
                                            <div class="circle_white  <?php if ($value['id'] == '0') { ?>circle_orangedark<?php } ?>  ">
                                                <p>0</p>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="circle_white  <?php if ($value['id'] == '1') { ?>circle_orangedark<?php } ?>">
                                                <p>1</p>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="circle_white  <?php if ($value['id'] == '2') { ?>circle_orangedark<?php } ?>">
                                                <p>2</p>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="circle_white  <?php if ($value['id'] == '3') { ?>circle_orangedark<?php } ?>">
                                                <p>3</p>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="circle_white  gr_first <?php if ($value['id'] == '4') { ?>circle_light_grdark<?php } ?>">
                                                <p>4</p>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="circle_white  <?php if ($value['id'] == '5') { ?>circle_light_grdark<?php } ?>">
                                                <p>5</p>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="circle_white  <?php if ($value['id'] == '6') { ?>circle_light_grdark<?php } ?>">
                                                <p>6</p>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="circle_white  gr_first <?php if ($value['id'] == '7') { ?>circle_light_bluedark<?php } ?>">
                                                <p>7</p>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="circle_white  <?php if ($value['id'] == '8') { ?>circle_light_bluedark<?php } ?>">
                                                <p>8</p>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="circle_white  <?php if ($value['id'] == '9') { ?>circle_light_bluedark<?php } ?>">
                                                <p>9</p>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>


                            <div class="row tasteview d-md-none">
                                <div class="col-2 tasteviewpar">
                                    <p> <?php echo ucwords($value['name']); ?></p>
                                </div>

                                <div class="col-8 text-center">
                                    <ul>
                                        <li>
                                            <div class="circle_white  <?php if ($value['id'] == '0' || $value['id'] == '1' || $value['id'] == '2' || $value['id'] == '3') { ?>circle_orangedark<?php } else if ($value['id'] == '4' || $value['id'] == '5' || $value['id'] == '6') { ?>circle_light_grdark<?php } else if ($value['id'] == '7' || $value['id'] == '8' || $value['id'] == '9') { ?>circle_light_bluedark <?php } ?> ">
                                                <p><?php echo $value['id']; ?></p>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>

                <?php
                        }
                    }
                }
                ?>
            </div>
            <div class="col-xl-6 col-lg-6 col-md-12">
                <div class="product-details-content">
                    <div class="product_right_fix">



                        <div class="product_h2sec">
                            <h2><?php echo ucwords($row['title']); ?></h2>
                            <?php
                            if ($row['is_low_stock'] == 'yes') {
                            ?>
                                <div class="pdngtop soldout">
                                    <div class="mt-3">
                                        <span>Low Stock</span>
                                    </div>
                                </div>
                            <?php
                            }
                            ?>
                        </div>
                        <p class="d-none reference">Reference:<span> demo_17</span></p>
                        <div class="pro-details-rating-wrap d-none">
                            <div class="rating-product">
                                <?php
                                $rating = $this->crud_model->getProductRating($row['product_id']);
                                if ($rating != NULL) {
                                    $r = $rating;
                                    $i = 1;
                                    while ($i < 6 && $r > 0) {
                                        if ($i <= $rating) {
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
                                <li class="old-price not-cut">$12</li>
                            </ul>
                        </div>
                        <div class="pro-details-list">
                            <p><?php echo strip_tags($row['description']); ?></p>
                            <ul>
                                <?php if ($row['product_abv'] != "") { ?>
                                    <li>- <?php echo $row['product_abv'] != "" ? $row['product_abv'] . "%" : ""; ?> </li>
                                <?php } ?>
                                <?php //if ($row['product_year'] != '') { 
                                ?>
                                <li>- <?php echo $row['product_year'] == '' || $row['product_year'] == '0000' ? 'Non-Vintage' : $row['product_year']; ?> </li>
                                <?php //} 
                                ?>
                                <?php if ($row['regions'] != '') { ?>
                                    <li>- <?php echo $row['regions']; ?> </li>
                                <?php } ?>
                                <?php if ($row['unit'] != '') { ?>
                                    <li>- <?php echo $row['unit']; ?> </li>
                                <?php } ?>
                                <?php if ($row['variety'] != '') { ?>
                                    <li>- <?php echo $row['variety']; ?> </li>
                                <?php } ?>
                                <?php if ($row['limited_release'] == 'Yes') { ?>
                                    <li>- Limited Release</li>
                                <?php } ?>
                            </ul>
                        </div>
                        <div class="pro-details-quality mt-0px">
                            <?php
                            $lat_sale_price1 = price_formula($rrp, $wholesale, $commission_amount, $orp_commission_amount, $discount) * 1;
                            $lat_sale_price2 = price_formula($rrp, $wholesale, $commission_amount, $orp_commission_amount, $discount) * 6 * 95 / 100;
                            $lat_sale_price3 = price_formula($rrp, $wholesale, $commission_amount, $orp_commission_amount, $discount) * 12 * 90 / 100;
                            ?>
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <th class="text-center ">Each<span></span></th>
                                    <th class="text-center ">Six<span></span></th>
                                    <th class="text-center ">Twelve<span></span></th>
                                </thead>
                                <tbody>
                                    <tr>
                                        <?php
                                        if ($this->session->userdata('currency') == '2') {
                                        ?>
                                            <td><?php echo currency($lat_sale_price1); ?></td>
                                            <td><?php echo currency($lat_sale_price2); ?></td>
                                            <td><?php echo currency($lat_sale_price3); ?></td>
                                            <?php
                                        }
                                        if ($this->session->userdata('currency') == '10') {
                                            if ($row['sale_price_HK'] > 0) {
                                            ?>
                                                <td><?php echo currency() . $lat_sale_price1; ?></td>
                                                <td><?php echo currency() . $lat_sale_price2; ?></td>
                                                <td><?php echo currency() . $lat_sale_price3; ?></td>
                                            <?php
                                            } else {
                                            ?>
                                                <td><?php echo currency($lat_sale_price1); ?></td>
                                                <td><?php echo currency($lat_sale_price2); ?></td>
                                                <td><?php echo currency($lat_sale_price3); ?></td>
                                            <?php
                                            }
                                        }
                                        if ($this->session->userdata('currency') == '13') {
                                            if ($row['sale_price_JP'] > 0) {
                                            ?>
                                                <td><?php echo currency() . $lat_sale_price1; ?></td>
                                                <td><?php echo currency() . $lat_sale_price2; ?></td>
                                                <td><?php echo currency() . $lat_sale_price3; ?></td>
                                            <?php
                                            } else {
                                            ?>
                                                <td><?php echo currency($lat_sale_price1); ?></td>
                                                <td><?php echo currency($lat_sale_price2); ?></td>
                                                <td><?php echo currency($lat_sale_price3); ?></td>
                                            <?php
                                            }
                                        }
                                        if ($this->session->userdata('currency') == '22') {
                                            if ($row['sale_price_SG'] > 0) {
                                            ?>
                                                <td><?php echo currency() . $lat_sale_price1; ?></td>
                                                <td><?php echo currency() . $lat_sale_price2; ?></td>
                                                <td><?php echo currency() . $lat_sale_price3; ?></td>
                                            <?php
                                            } else {
                                            ?>
                                                <td><?php echo currency($lat_sale_price1); ?></td>
                                                <td><?php echo currency($lat_sale_price2); ?></td>
                                                <td><?php echo currency($lat_sale_price3); ?></td>
                                        <?php
                                            }
                                        }
                                        ?>
                                    </tr>
                                    <tr>
                                        <td class="plusview">
                                            <div class="cart-plus-minus">
                                                <a href="javascript:void(0);" class="dec qtybutton minusbutton" data-productid="1">-</a>
                                                <input class="cart-plus-minus-box cart-plus-minus-box1 quantity-multiply<?php echo $row['product_id']; ?>1 cart_quantity" disabled realqty="1" type="text" name="qtybutton" value="1" min="1" remainingmax="" />
                                                <input class="total_max quantity-field1" type="hidden" value="1" min="1" max="" />
                                                <a href="javascript:void(0);" class="inc qtybutton plusbutton" data-productid="1">+</a>
                                            </div>
                                            <div class="cartbtn btn-hover">
                                                <a href="javascript:void(0);" coupon_price="<?php echo $coupon_price; ?>" variationqty1="1" variationid="1" class="to_cart_add" productid="<?php echo $row['product_id']; ?>"> Add To Cart</a>
                                            </div>
                                        </td>
                                        <td class="plusview">
                                            <div class="cart-plus-minus">
                                                <a href="javascript:void(0);" class="dec qtybutton minusbutton" data-productid="2">-</a>
                                                <input class="cart-plus-minus-box cart-plus-minus-box2 quantity-multiply<?php echo $row['product_id']; ?>2 cart_quantity" disabled realqty="1" type="text" name="qtybutton" value="1" min="1" remainingmax="" />
                                                <input class="total_max quantity-field2" type="hidden" value="1" min="1" max="" />
                                                <a href="javascript:void(0);" class="inc qtybutton plusbutton" data-productid="2">+</a>
                                            </div>
                                            <div class="cartbtn btn-hover">
                                                <a href="javascript:void(0);" coupon_price="<?php echo $coupon_price; ?>" variationqty2="6" variationid="2" class="to_cart_add" productid="<?php echo $row['product_id']; ?>"> Add To Cart</a>
                                            </div>
                                        </td>
                                        <td class="plusview">
                                            <div class="cart-plus-minus">
                                                <a href="javascript:void(0);" class="dec qtybutton minusbutton" data-productid="3">-</a>
                                                <input class="cart-plus-minus-box cart-plus-minus-box3 quantity-multiply<?php echo $row['product_id']; ?>3 cart_quantity" disabled realqty="1" type="text" name="qtybutton" value="1" min="1" remainingmax="" />
                                                <input class="total_max quantity-field3" type="hidden" value="1" min="1" max="" />
                                                <a href="javascript:void(0);" class="inc qtybutton plusbutton" data-productid="3">+</a>
                                            </div>
                                            <div class="cartbtn btn-hover">
                                                <a href="javascript:void(0);" coupon_price="<?php echo $coupon_price; ?>" variationqty3="12" variationid="3" class="to_cart_add" productid="<?php echo $row['product_id']; ?>"> Add To Cart</a>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="pro-details-wish-com">
                            <?php
                            if ($this->session->userdata('user_login') != 'yes') {
                            ?>
                                <a href="<?php echo base_url(); ?>home/login_set/login"><i class="icon-heart"></i><?php echo translate('_add_to_wishlist'); ?></a></li>
                                <?php } else {
                                $wish = $this->crud_model->is_wished($row['product_id']);
                                if ($wish == 'yes') {
                                ?>
                                    <a pathaction="remove" producttype="single" href="javascript:void(0);" class="to_wishlist" productid="<?php echo $row['product_id']; ?>">
                                        <ion-icon name="heart-sharp"></ion-icon><?php echo translate('_added_to_wishlist');  ?>
                                    </a>
                                <?php
                                } else {  ?>
                                    <a pathaction="add" producttype="single" href="javascript:void(0);" class="to_wishlist" productid="<?php echo $row['product_id']; ?>">
                                        <ion-icon name="heart-outline"></ion-icon><?php echo translate('_add_to_wishlist');   ?>
                                    </a>
                            <?php }
                            }  ?>
                            <div class="pro-details-compare d-none">
                                <a href="#"><i class="icon-shuffle"></i>Add to compare</a>
                            </div>
                        </div>
                        <div class="pro-details-social-info">
                            <span>Share</span>
                            <div class="social-new">
                                <a href="http://www.facebook.com/sharer.php?u=<?php echo CURRENT_URL; ?>" target="_blank">
                                    <img class="facebtn" src="<?php echo base_url(); ?>template/omgee/images/iconfindericon/facebook.png">
                                </a>
                                <a href="http://instagram.com/###?ref=<?php echo CURRENT_URL; ?>">
                                    <img class="instabtn" src="<?php echo base_url(); ?>template/omgee/images/iconfindericon/instagram.png">
                                </a>
                                <a href="https://twitter.com/intent/tweet?url=<?php echo CURRENT_URL; ?>&text=<?php echo ucwords($page_title);?>">
                                    <img class="twibtn" src="<?php echo base_url(); ?>template/omgee/images/iconfindericon/twitter.png">
                                </a>
                                <a style="display: none;" href="https://plus.google.com/share?url=<?php echo CURRENT_URL; ?>">
                                    <img class="gplusbtn" src="<?php echo base_url(); ?>template/omgee/images/iconfindericon/google-plus.png">
                                </a>
                            </div>
                        </div>
                        <?php if ($row['tag'] != "") { ?>
                            <div class="Highlights_details  ">
                                <div class="section-title">
                                    <h2 class="section-heading">Highlights</h2>
                                </div>

                                <?php

                                $product_arr = explode(",", $row['tag']);

                                $product_name[] = $this->db->get_where('product', array('product_id' => $row['product_id']))->row()->tag;
                                foreach ($product_arr as $key) {
                                    if ($key != "") {
                                ?>
                                        <ul class="one_half">

                                            <li><?php echo " " . ucfirst($key); ?></li>
                                        </ul>
                                <?php
                                    }
                                }

                                ?>

                            </div>

                        <?php } 
                        if($row['test_sumary_en'] != ""){
                        ?>

                        <div class="product_h2sec <?php echo ($row['tag'] != "") ? 'productright' : ''?>" style="margin-top : 70px;">
                            <div class="section-title">
                                <h2 class="section-heading">Taste Summary</h2>
                            </div>

                            <p><?php echo $row['test_sumary_en']; ?></p>

                        </div>
                    </div>
                    <?php
                        }
                    if (($row['test_sumary_title'] != Null) && ($row['test_sumary'] != Null)) {
                    ?>
                        <div class="productright">

                            <h5> <?php echo ucwords($row['test_sumary_title']); ?> </h5>

                            <p> <?php echo ucfirst($row['test_sumary']); ?> </p>


                        </div>
                    <?php
                    }
                    ?>
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

        <?php $row['product_id'];
                    $product_food = $this->db->get_where('sticky', array('product_id' => $row['product_id']))->result_array();
                    foreach ($product_food as $food_count) {
                        $food_paring = json_decode($food_count['food_paring']);
                        if ($food_paring->food_name1 != NULL) {
                            $count_name1 = $food_paring->food_name1;

                            $count1++;
                        }
                        if ($food_paring->food_name2 != NULL) {
                            $count_name2 = $food_paring->food_name2;

                            $count2++;
                        }
                        if ($food_paring->food_name3 != NULL) {
                            $count_name3 = $food_paring->food_name3;

                            $count3++;
                        }
                        if ($food_paring->food_name4 != NULL) {
                            $count_name4 = $food_paring->food_name4;

                            $count4++;
                        }
                    }
                    $arr1 = array(
                        array('id' => $count1, 'name' => $count_name1),
                        array('id' => $count2, 'name' => $count_name2),
                        array('id' => $count3, 'name' => $count_name3),
                        array('id' => $count4, 'name' => $count_name4),
                    );
                    $arr2 = array_msort($arr1, array('id' => SORT_DESC));
                    $newarr2 = array();
                    foreach ($arr2 as $key => $value) {
                        $newarr2[] = $value;
                    }
                    $flag = 0;
                    foreach ($newarr2 as $key => $value) {
                            if(isset($value['id']) && $value['id'] > 0){
                                $flag = 1;
                            }
                    }
        ?>


            <div class="col-sm-12">
                <div class="section-title">
                    <?php if($flag == 1) { ?>
                    <h2 class="section-heading">Community Reviews</h2>
                    <?php } ?>
                </div>
            </div>
            <div class="col-sm-12">
                <div class="row">
                    
                    <?php
                    foreach ($newarr2 as $key => $value) {
                        if ($key >= 0 && $key <= 0) {
                            if(isset($value['id']) && $value['id'] > 0){
                    ?>
                    <div class="col-lg-4 col-md-12 col-sm-12 col-xs-12">
                        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Modal title1</h5>
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
                            <h3 class="title">
                                <?php
                                foreach ($newarr2 as $key => $value) {
                                    if ($key >= 0 && $key <= 0) {
                                        echo ucwords($value['name']);
                                ?>
                            </h3>
                            <p class="description">
                                <?php echo ucwords($value['id']); ?> mentions of oaky notes.
                        <?php
                                    }
                                }
                        ?>
                            </p>
                        </div>
                    </div>
                            <?php }
                        } 
                    }?>

<?php
                    foreach ($newarr2 as $key => $value) {
                        if ($key >= 1 && $key <= 1) {
                            if(isset($value['id']) && $value['id'] > 0){
                    ?>
                    <div class="col-lg-4 col-md-12 col-sm-12 col-xs-12">
                        <div class="modal fade" id="exampleModal2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Modal title2</h5>
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
                            <h3 class="title"><?php
                                                foreach ($newarr2 as $key => $value) {
                                                    if ($key >= 1 && $key <= 1) {
                                                        echo ucwords($value['name']);
                                                ?>
                            </h3>
                            <p class="description">
                                <?php echo ucwords($value['id']); ?> mentions of oaky notes.
                        <?php
                                                    }
                                                }
                        ?>
                            </p>
                        </div>
                    </div>
                    <?php }
                        } 
                    }?>
<?php
                    foreach ($newarr2 as $key => $value) {
                        if ($key >= 2 && $key <= 2) {
                            if(isset($value['id']) && $value['id'] > 0){
                    ?>
                    <div class="col-lg-4 col-md-12 col-sm-12 col-xs-12">
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
                            <h3 class="title"><?php
                                                foreach ($newarr2 as $key => $value) {
                                                    if ($key >= 2 && $key <= 2) {
                                                        echo ucwords($value['name']);
                                                ?>
                            </h3>
                            <p class="description">
                                <?php echo ucwords($value['id']); ?> mentions of oaky notes.
                        <?php
                                                    }
                                                }
                        ?>
                            </p>
                        </div>
                    </div>
                    <?php }
                        } 
                    }?>
                </div>
            </div>
        </div>
    </div>
</section>
<hr>
<!-- end -->
<!-- Feature Area start -->
<?php
if ($row['food_section'] == 'yes') {
?>
    <section class="tasteblock">
        <div class="container">
            <div class="row">
                <div class="col-sm-3 col-12">
                    <div class="section-title">
                        <h2 class="section-heading"><?php echo ($row['food_title']); ?> <?php echo $category_name; ?></h2>
                    </div>
                    <p><?php echo ($row['food_description']); ?> </p>
                </div>
                <div class="col-sm-2 col-6 tastesec">
                    <img src="<?php echo $first_image; ?>" class="img-responsive" alt="" />
                </div>
                <div class="col-sm-6 col-6">
                    <div class="row">
                        <div class="col-sm-3 col-12 mixblock">
                            <?php
                            if ($row['food_image1']) { ?>
                                <img src="<?php echo base_url('uploads/food_paring/' . ucwords($row['food_name1']) . '/' . $row['food_image1']); ?>" class="img-responsive">
                                <p><?php echo ucwords($row['food_name1']); ?></p>
                            <?php } ?>
                        </div>
                        <div class="col-sm-3 col-12 mixblock">
                            <?php
                            if ($row['food_image2']) { ?>
                                <img src="<?php echo base_url('uploads/food_paring/' . ucwords($row['food_name2']) . '/' . $row['food_image2']); ?>" class="img-responsive">
                                <p><?php echo ucwords($row['food_name2']); ?></p>
                            <?php } ?>
                        </div>
                        <div class="col-sm-3 col-12 mixblock">
                            <?php
                            if ($row['food_image3']) { ?>
                                <img src="<?php echo base_url('uploads/food_paring/' . ucwords($row['food_name3']) . '/' . $row['food_image3']); ?>" class="img-responsive">
                                <p><?php echo ucwords($row['food_name3']); ?></p>
                            <?php } ?>
                        </div>
                        <div class="col-sm-3 col-12 mixblock">
                            <?php
                            if ($row['food_image4']) { ?>
                                <img src="<?php echo base_url('uploads/food_paring/' . ucwords($row['food_name4']) . '/' . $row['food_image4']); ?>" class="img-responsive">
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
<?php include 'related_products.php'; ?>
<?php include 'do_you_also_like.php'; ?>

<script type="text/javascript">
    var max_stock = <?php echo $max_stock; ?>;
    $('.cart-plus-minus-box').attr('remainingmax', parseInt(max_stock));
    $('.total_max').attr('max', parseInt(max_stock));

    var show_taste_section =  "<?php echo $show_section;?>";
    
    $('.minusbutton').click(function() {
        var productid = $(this).attr('data-productid');
        var value = $('.quantity-multiply<?php echo $row['product_id']; ?>' + productid).attr('value');
        var max_val = parseInt($('.quantity-field' + productid).attr('max'));
        var quantityvalue = $('.quantity-multiply<?php echo $row['product_id']; ?>' + productid).attr('realqty');
        var quantityval = $('.quantity-multiply<?php echo $row['product_id']; ?>' + productid).val();
        var remainingmax_val = $('.cart-plus-minus-box' + productid).attr('remainingmax');
        var remainmax_val = $('.quantity-multiply<?php echo $row['product_id']; ?>' + productid).attr('remainingmax');
        if (value >= 1) {
            var decreasevalue = parseInt(value - quantityvalue);

            if (decreasevalue >= quantityvalue) {
                var remainingqty = parseInt(quantityvalue);
                var remaining = parseInt(remainingmax_val) + parseInt(remainingqty);
                if (remaining >= 1) {
                    $('.cart-plus-minus-box' + productid).attr('remainingmax', remaining);
                    $('.quantity-multiply<?php echo $row['product_id']; ?>' + productid).val(decreasevalue);
                }
                $('.quantity-multiply<?php echo $row['product_id']; ?>' + productid).attr('value', decreasevalue);
            }
        }
        $('.quantity-field' + productid).val(value);
    });
    $('.plusbutton').click(function() {
        var productid = $(this).attr('data-productid');
        var value = $('.quantity-multiply<?php echo $row['product_id']; ?>' + productid).attr('value');
        var max_val = parseInt($('.quantity-field' + productid).attr('max'));
        var remainingmax_val = $('.cart-plus-minus-box' + productid).attr('remainingmax');
        var quantityvalue = $('.quantity-multiply<?php echo $row['product_id']; ?>' + productid).attr('realqty');
        var quantityval = $('.quantity-multiply<?php echo $row['product_id']; ?>' + productid).val();

        if (quantityval <= max_val) {
            var increasevalue = parseInt(value) + parseInt(quantityvalue);
            if (max_val >= increasevalue) {
                var current_qty = $('.quantity-multiply<?php echo $row['product_id']; ?>' + productid).val();
                var remainingqty = parseInt(quantityvalue);

                var remaining = parseInt(remainingmax_val - remainingqty);

                if (remaining >= 0) {
                    $('.cart-plus-minus-box' + productid).attr('remainingmax', remaining);
                    $('.quantity-multiply<?php echo $row['product_id']; ?>' + productid).val(increasevalue);
                    $('.quantity-multiply<?php echo $row['product_id']; ?>' + productid).attr('value', increasevalue);
                }
            }
        }
        $('.quantity-field' + productid).val(value);
    });

    $(document).ready(function() {
        if(show_taste_section == "No")
            $('.taste_meter_div').attr("style","display : none !important");

        var price_tags = $('.newpricetag');
        for (let i = 0; i < price_tags.length; i++) {
            var prices = $(price_tags[i]).find('td');
            for (let j = 1; j < prices.length; j++) {
                let current_price = $(prices[j]).html();
                let currency = current_price.slice(0, 1)
                current_price = current_price.slice(1)
                if (j == 1) current_price = current_price * 95 / 100
                if (j == 2) current_price = current_price * 90 / 100
                $(prices[j]).html(currency + current_price.toFixed(2))
            }
        }
    })
</script>