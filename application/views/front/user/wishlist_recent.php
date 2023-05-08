<?php
    // $max_stock = $row1['current_stock'] - ($row1['bundle_qty1'] + $row1['bundle_qty2'] + $row1['bundle_qty3']);
    $max_stock = 72;
    ?>
<section class="wishlishtblock">
    <div class="container">
    <div class="row">
    <div class="col-sm-12 mob_padding">
    <table class="table table-dark table-striped table-hover table-responsive">
        <thead>
            <tr>
                <th><?php echo translate('product_image');?></th>
                <th><?php echo translate('product_name');?></th>
                <th><?php echo translate('price');?></th>
                <th><?php echo translate('product_status');?></th>
                <th colspan="1"></th>
                <th><?php echo translate('remove');?></th>
            </tr>
        </thead>
        <tbody id="result4">
        </tbody>
    </table>
</section>
<?php 
    $coupon_price = 0;
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
    foreach ($query_wishlist as $row1) 
    {
        if($row1['num_of_imgs'] !=NULL)
        {
            $num_of_img = explode(",", $row1['num_of_imgs']); 
            $first_image = base_url('uploads/product_image/'.$num_of_img[0]);
        }
        else
        {
            $first_image = base_url('uploads/product_image/default.jpg');
        }

        $productKey = searchArrayKeyVal("productid", $row1['product_id'], $already_add_product_arr);

        if($productKey!==false) 
        {
             $coupon_price = $already_add_product_arr[$productKey]['discount_value'];
        }
        ?>
<div class="modal fade" id="wishlistmodal<?php echo $row1['product_id']; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title h6 text-sm-center" id="myModalLabel">
                    <ion-icon name="checkmark-circle"></ion-icon>
                    Select Product Type
                </h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body wishleftimg">
                <div class="row">
                    <div class="col-md-5 divide-right">
                        <div class="row">
                            <div class="col-md-6">
                                 <a  href="<?php echo $this->crud_model->product_link($row1['product_id']); ?>">
                                <img class="product-image" src="<?php echo $first_image; ?>" alt="" title="" itemprop="image"></a>
                            </div>
                            <div class="col-md-6">
                                <h6 class="h6 product-name"><?php echo ucwords($row1['title']); ?></h6>
                                <br>
                                <div class="pro-details-list">
                                <p><?php echo strip_tags($row1['description']); ?></p>
                                <ul>
                                <li>- <?php echo $row1['product_abv']; ?>% (ABV)</li>
                                <li>- <?php echo $row1['product_year']; ?> (Year)</li>
                                <li>- <?php echo $row1['regions']; ?> (Regions)</li>
                                <li>- <?php echo $row1['variety']; ?> (Variety)</li>
                                <?php if($row1['limited_release'] == 'Yes') { ?>
                                <li>- Limited Release</li>
                                <?php } ?>
                                </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-7 wishtable">
                        <div class="cart-content">
                             
                                <script type="text/javascript">
    var max_stock = <?php echo $max_stock; ?>;
    $('.cart-plus-minus-box<?php echo $row1['product_id']; ?>').attr('remainingmax<?php echo $row1['product_id']; ?>',parseInt(max_stock));
    $('.total_max<?php echo $row1['product_id']; ?>').attr('max<?php echo $row1['product_id']; ?>',parseInt(max_stock));
    $('.minusbutton<?php echo $row1['product_id']; ?>').click(function()
    {
        var productid = $(this).attr('data-productid<?php echo $row1['product_id']; ?>'); 
        var value = $('.quantity-multiply<?php echo $row1['product_id']; ?>'+productid).attr('value');
        var max_val =parseInt($('.quantity-field<?php echo $row1['product_id']; ?>'+productid).attr('max<?php echo $row1['product_id']; ?>'));
        var quantityvalue = $('.quantity-multiply<?php echo $row1['product_id']; ?>'+productid).attr('realqty<?php echo $row1['product_id']; ?>');
        var quantityval = $('.quantity-multiply<?php echo $row1['product_id']; ?>'+productid).val();
        var remainingmax_val = $('.cart-plus-minus-box<?php echo $row1['product_id']; ?>').attr('remainingmax<?php echo $row1['product_id']; ?>');
        var remainmax_val = $('.quantity-multiply<?php echo $row1['product_id']; ?>'+productid).attr('remainingmax<?php echo $row1['product_id']; ?>');
        if(value >= 1)
        {    
            var decreasevalue = parseInt(value - quantityvalue);

            if(decreasevalue >= quantityvalue)
            {    
                var remainingqty = parseInt(quantityvalue);
                var remaining = parseInt(remainingmax_val) + parseInt(remainingqty); 
                if(remaining >= 1)
                {
                    $('.cart-plus-minus-box<?php echo $row1['product_id']; ?>').attr('remainingmax<?php echo $row1['product_id']; ?>',remaining);
                    $('.quantity-multiply<?php echo $row1['product_id']; ?>'+productid).val(decreasevalue);
                }
                $('.quantity-multiply<?php echo $row1['product_id']; ?>'+productid).attr('value',decreasevalue);
            }        
        }
        $('.quantity-field<?php echo $row1['product_id']; ?>'+productid).val(value);
    });
    $('.plusbutton<?php echo $row1['product_id']; ?>').click(function()
    {
        var productid = $(this).attr('data-productid<?php echo $row1['product_id']; ?>'); 
        var value =  $('.quantity-multiply<?php echo $row1['product_id']; ?>'+productid).attr('value');
        var max_val = parseInt($('.quantity-field<?php echo $row1['product_id']; ?>'+productid).attr('max<?php echo $row1['product_id']; ?>'));
        var remainingmax_val = $('.cart-plus-minus-box<?php echo $row1['product_id']; ?>').attr('remainingmax<?php echo $row1['product_id']; ?>');
        var quantityvalue = $('.quantity-multiply<?php echo $row1['product_id']; ?>'+productid).attr('realqty<?php echo $row1['product_id']; ?>');
        var quantityval = $('.quantity-multiply<?php echo $row1['product_id']; ?>'+productid).val();
        
        if(quantityval <= max_val)
        {
            var increasevalue = parseInt(value)+parseInt(quantityvalue);
            if(max_val >= increasevalue)
            {
                var current_qty = $('.quantity-multiply<?php echo $row1['product_id']; ?>'+productid).val();
                var remainingqty = parseInt(quantityvalue);
                
                var remaining = parseInt(remainingmax_val-remainingqty); 
                
                if(remaining >= 0)
                {
                    $('.cart-plus-minus-box<?php echo $row1['product_id']; ?>').attr('remainingmax<?php echo $row1['product_id']; ?>',remaining);
                    $('.quantity-multiply<?php echo $row1['product_id']; ?>'+productid).val(increasevalue);
                    $('.quantity-multiply<?php echo $row1['product_id']; ?>'+productid).attr('value',increasevalue);   
                }
            }
        }
        $('.quantity-field<?php echo $row1['product_id']; ?>'+productid).val(value);
    });
    </script>
                                  <?php
                                  $rrp = $row1['bundle_sale1'];
	
                                  $wholesale = $row1['wholesale'];
                                  $discount = ($row1['bundle_discount1']) ? ($row1['bundle_discount1']/100) : 0;
                                  
                              
                                  if($row1['limited_release']=="Yes")
                                  {
                                      $orp_commission_amount = ($this->db->get_where('business_settings', array('type' => 'limit_admin_orp_commission_amount'))->row()->value)/100;
                                  
                                      $commission_amount = ($this->db->get_where('business_settings', array('type' => 'limit_admin_commission_amount'))->row()->value)/100;	
                                  }
                                  else
                                  {
                                      $orp_commission_amount = ($this->db->get_where('business_settings', array('type' => 'nolimit_admin_orp_commission_amount'))->row()->value)/100;
                                  
                                      $commission_amount = ($this->db->get_where('business_settings', array('type' => 'nolimit_admin_commission_amount'))->row()->value)/100;
                                  }
                                function price_formula($rrp,$wholesale,$commission_amount,$orp_commission_amount,$discount)
                                {
                                $gap_revenue = $rrp - $wholesale;
                                $gap_revenue_commission = $gap_revenue * $commission_amount;	
                                $orp = $rrp - (($gap_revenue - $gap_revenue_commission)*$orp_commission_amount);
                                $total_discount = $orp * $discount;
                                $total_orp = $orp - $total_discount;
                                return $total_orp;
                                }
                               $checkcount = count(json_decode($row1['products']));
                            if(($row1['current_stock'] > 0)&&($max_stock > 0))
                            {
                            		$lat_sale_price1 = price_formula($rrp,$wholesale,$commission_amount,$orp_commission_amount,$discount)*1;
                            		$lat_sale_price2 = price_formula($rrp,$wholesale,$commission_amount,$orp_commission_amount,$discount)*6;
                            		$lat_sale_price3 = price_formula($rrp,$wholesale,$commission_amount,$orp_commission_amount,$discount)*12;
                                ?>
                                <table class="table table-bordered table-striped <?php if($checkcount =='1') { echo  'tablesinglewidth'; }  ?>"> 
                                    <thead>
                                        <th class="text-center ">Each<span></span></th>    
                                        <th class="text-center ">Six<span></span></th>     
                                        <th class="text-center ">Twelve<span></span></th>    
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td><?php echo currency($lat_sale_price1); ?></td>
                                            <td><?php echo currency($lat_sale_price2); ?></td>
                                            <td><?php echo currency($lat_sale_price3); ?></td>
                                        </tr>
                                        <tr>
                                            <td class="plusview">
                                                <div class="cart-plus-minus">
                                                	<a href="javascript:void(0);" class="dec qtybutton minusbutton" data-productid="1">-</a>
                                                    <input  class="cart-plus-minus-box cart-plus-minus-box1 quantity-multiply<?php echo $row1['product_id']; ?>1 cart_quantity" disabled realqty="1" type="text" name="qtybutton" value="1" min="1" remainingmax="" />
                                                    <input class="total_max quantity-field1" type="hidden"  value="1" min="1" max="" />
                                                    <a href="javascript:void(0);" class="inc qtybutton plusbutton" data-productid="1">+</a>
                                                </div>
                                                <div class="cartbtn btn-hover">
                                                    <a href="javascript:void(0);" coupon_price ="<?php echo $coupon_price; ?>" variationqty1="<?php echo $row1['bundle_qty1']; ?>" variationid="1" class="to_cart_add" productid="<?php echo $row1['product_id']; ?>" > Add To Cart</a>
                                                </div>
                                            </td>  
                                            <td class="plusview">  
                                                <div class="cart-plus-minus">
                                                    <a href="javascript:void(0);" class="dec qtybutton minusbutton" data-productid="2">-</a>
                                                    <input  class="cart-plus-minus-box cart-plus-minus-box2 quantity-multiply<?php echo $row1['product_id']; ?>2 cart_quantity" disabled realqty="6" type="text" name="qtybutton" value="6" min="1" remainingmax="" />
                                                    <input class="total_max quantity-field2" type="hidden"  value="1" min="1" max="" />
                                                    <a href="javascript:void(0);" class="inc qtybutton plusbutton" data-productid="2">+</a>
                                                </div>
                                                <div class="cartbtn btn-hover">
                                                    <a href="javascript:void(0);" coupon_price ="<?php echo $coupon_price; ?>" variationqty2="<?php echo $row1['bundle_qty2']; ?>" variationid="2" class="to_cart_add" productid="<?php echo $row1['product_id']; ?>" > Add To Cart</a>
                                                </div>
                                            </td>
                                            <td class="plusview">    
                                                <div class="cart-plus-minus">
                                                    <a href="javascript:void(0);" class="dec qtybutton minusbutton" data-productid="3">-</a>
                                                    <input  class="cart-plus-minus-box cart-plus-minus-box3 quantity-multiply<?php echo $row1['product_id']; ?>3 cart_quantity" disabled realqty="12" type="text" name="qtybutton" value="12" min="1" remainingmax="" />
                                                    <input class="total_max quantity-field3" type="hidden"  value="1" min="1" max="" />
                                                    <a href="javascript:void(0);" class="inc qtybutton plusbutton" data-productid="3">+</a>
                                                </div>
                                                <div class="cartbtn btn-hover">
                                                    <a href="javascript:void(0);" coupon_price ="<?php echo $coupon_price; ?>" variationqty3="<?php echo $row1['bundle_qty3']; ?>" variationid="3" class="to_cart_add" productid="<?php echo $row1['product_id']; ?>" > Add To Cart</a>
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>    
                            <?php   
                            }
                        ?>
                            <div class="cart-content-btn">
                                <a href="<?php echo base_url().'home'; ?>" class="btn con-shopbtn" >Continue shopping</a>
                                <a href="<?php echo base_url().'home/cart_checkout/cart'; ?>" class="btn check_btn">Proceed to Cart</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
}
?>
<!-- end -->
<!-- second modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body ">
                <h4>Sorry, This item was Sold Out</h4>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<input type="hidden" id="page_num4" value="0" />
<div class="pagination_box">
</div>
<script>                                          
    function wish_listed(page){
        if(page == 'no'){
            page = $('#page_num4').val();   
        } else {
            $('#page_num4').val(page);
        }
        var alerta = $('#result4');
        alerta.load('<?php echo base_url();?>home/wish_listed/'+page,
            function(){
                //set_switchery();
            }
        );   
    }
    $(document).ready(function() {
        wish_listed('0');
    });
    
</script>

<script type="text/javascript">
    var max_stock = <?php echo $max_stock; ?>;
    $('.cart-plus-minus-box').attr('remainingmax',parseInt(max_stock));
    $('.total_max').attr('max',parseInt(max_stock));
    $('.minusbutton').click(function()
    {
    	var productid = $(this).attr('data-productid');	
		var value = $('.quantity-multiply<?php echo $row1['product_id']; ?>'+productid).attr('value');
        var max_val =parseInt($('.quantity-field'+productid).attr('max'));
        var quantityvalue = $('.quantity-multiply<?php echo $row1['product_id']; ?>'+productid).attr('realqty');
        var quantityval = $('.quantity-multiply<?php echo $row1['product_id']; ?>'+productid).val();
        var remainingmax_val = $('.cart-plus-minus-box'+productid).attr('remainingmax');
        var remainmax_val = $('.quantity-multiply<?php echo $row1['product_id']; ?>'+productid).attr('remainingmax');
		if(value >= 1)
        {	 
            var decreasevalue = parseInt(value - quantityvalue);

            if(decreasevalue >= quantityvalue)
            {    
                var remainingqty = parseInt(quantityvalue);
                var remaining = parseInt(remainingmax_val) + parseInt(remainingqty); 
                if(remaining >= 1)
                {
                    $('.cart-plus-minus-box'+productid).attr('remainingmax',remaining);
                    $('.quantity-multiply<?php echo $row1['product_id']; ?>'+productid).val(decreasevalue);
                }
                $('.quantity-multiply<?php echo $row1['product_id']; ?>'+productid).attr('value',decreasevalue);
            }        
		}
		$('.quantity-field'+productid).val(value);
	});
    $('.plusbutton').click(function()
    {
	    var productid = $(this).attr('data-productid');	
		var value =  $('.quantity-multiply<?php echo $row1['product_id']; ?>'+productid).attr('value');
		var max_val = parseInt($('.quantity-field'+productid).attr('max'));
        var remainingmax_val = $('.cart-plus-minus-box'+productid).attr('remainingmax');
        var quantityvalue = $('.quantity-multiply<?php echo $row1['product_id']; ?>'+productid).attr('realqty');
        var quantityval = $('.quantity-multiply<?php echo $row1['product_id']; ?>'+productid).val();
        
		if(quantityval <= max_val)
        {
            var increasevalue = parseInt(value)+parseInt(quantityvalue);
            if(max_val >= increasevalue)
            {
                var current_qty = $('.quantity-multiply<?php echo $row1['product_id']; ?>'+productid).val();
                var remainingqty = parseInt(quantityvalue);
                
                var remaining = parseInt(remainingmax_val-remainingqty); 
                
                if(remaining >= 0)
                {
                    $('.cart-plus-minus-box'+productid).attr('remainingmax',remaining);
                    $('.quantity-multiply<?php echo $row1['product_id']; ?>'+productid).val(increasevalue);
                    $('.quantity-multiply<?php echo $row1['product_id']; ?>'+productid).attr('value',increasevalue);   
                }
            }
		}
		$('.quantity-field'+productid).val(value);
	});
    </script>

<!-- end -->    



                                    