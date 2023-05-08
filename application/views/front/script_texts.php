<script>
	var base_url = "<?php echo base_url(); ?>"; 
	var current_url = "<?php echo CURRENT_URL; ?>"; 
	var eligible = "You are not eligible for login";
	var product_added = "<?php echo translate('product_added_to_cart'); ?>";
	var added_to_cart = "<?php echo translate('added_to_cart'); ?>";
	var quantity_exceeds = "<?php echo translate('product_quantity_exceed_availability!'); ?>";
	var product_already = "<?php echo translate('product_already_added_to_cart!'); ?>";
	var wishlist_add = "<?php echo translate('product_added_to_wishlist'); ?>";
	var wishlist_add1 = "<?php echo translate('wished'); ?>";
	var wishlist_adding = "<?php echo translate('wishing..'); ?>";
	var wishlist_remove = "<?php echo translate('product_removed_from_wishlist'); ?>";
	var compare_add = "<?php echo translate('product_added_to_compared'); ?>";
	var compare_add1 = "<?php echo translate('compared'); ?>";
	var compare_adding = "<?php echo translate('working..'); ?>";
	var compare_remove = "<?php echo translate('product_removed_from_compare'); ?>";
	var compare_cat_full = "<?php echo translate('compare_category_full'); ?>";
	var compare_already = "<?php echo translate('product_already_added_to_compare'); ?>";
	var rated_success = "<?php echo translate('product_rated_successfully'); ?>";
	var rated_fail = "<?php echo translate('product_rating_failed'); ?>";
	var rated_already = "<?php echo translate('you_already_rated_this_product'); ?>";
	var working = "<?php echo translate('working..'); ?>";
	var subscribe_already = "<?php echo translate('you_already_subscribed'); ?>";
	var subscribe_success = "<?php echo translate('you_subscribed_successfully'); ?>";
	var subscribe_sess = "<?php echo translate('you_already_subscribed_thrice_from_this_browser'); ?>";
	var logging = "<?php echo translate('logging_in..'); ?>";
	var login_success = "<?php echo translate('you_logged_in_successfully'); ?>";
	var login_fail = "<?php echo translate('login_failed!_try_again!'); ?>";
	var logup_success = "<?php echo translate('you_have_registered_successfully'); ?>";
	var logup_fail = "<?php echo translate('registration_failed!_try_again!'); ?>";
	var login_first = "<?php echo translate('login_first'); ?>";
	var logging = "<?php echo translate('logging_in..'); ?>";
	var submitting = "<?php echo translate('submitting..'); ?>";
	var email_sent = "<?php echo translate('email_sent_successfully'); ?>";
	var email_noex = "<?php echo translate('email_does_not_exist!'); ?>";
	var email_fail = "<?php echo translate('email_sending_failed!'); ?>";
	var logging = "<?php echo translate('logging_in'); ?>";		
	var cart_adding = "<?php echo translate('adding_to_cart..'); ?>";	
	var cart_product_removed = "<?php echo translate('product_removed_from_cart'); ?>";	
	var required = "<?php echo translate('the_field_is_required'); ?>";
	var mbn = "<?php echo translate('must_be_a_number'); ?>";
	var mbe = "<?php echo translate('must_be_a_valid_email_address'); ?>";
	var valid_email = "<?php echo translate('enter_a_valid_email_address'); ?>";
	var applying = "<?php echo translate('applying..'); ?>";
	var coupon_not_valid = "<?php echo translate('coupon_not_valid'); ?>";
	var promocode_not_valid = "<?php echo 'Promocode not valid'; ?>";
	var coupon_discount_successful = "<?php echo translate('coupon_discount_successful'); ?>";
	var promocode_discount_successful = "<?php echo 'Promocode discount successful'; ?>";
	var currency = "<?php echo currency(); ?>";
	var exchange = Number(<?php echo exchange(); ?>);
	var login_state = '';
	var verify_check = 'Please check your email account to verify your email for registration process.';
	var $j = jQuery.noConflict();
	var $ = jQuery.noConflict();

	function product_listing_defaults(){

		reload_header_cart();
		 $j('.ajax-to-cart').click(function(e){
			e.preventDefault();
	        var product = $(this).data('pid');
	        var elm_type = $(this).data('type');
	        var button = $(this);
			var alread = button.html();
			var type = 'pp';
	        if(button.closest('.row').find('.cart_quantity').length){
	            quantity = button.closest('.margin-bottom-40').find('.cart_quantity').val();
	        }
			
	        if($('#pnopoi').length){
	        	type = 'pp';
	            var form = button.closest('form');
				var formdata = false;
				if (window.FormData){
					formdata = new FormData(form[0]);
				}
	            var option = formdata ? formdata : form.serialize();
	        } else {
	        	type = 'other';
	        	var form = $('#cart_form_singl');
				var formdata = false;
				if (window.FormData){
					formdata = new FormData(form[0]);
				}
	        	var option = formdata ? formdata : form.serialize();
	        }
			
	        $.ajax({
	            url 		: base_url+'home/cart/add/'+product+'/'+type,
				type 		: 'POST', // form submit method get/post
				dataType 	: 'html', // request type html/json/xml
				data 		: option, // serialize form data 
				cache       : false,
				contentType : false,
				processData : false,
	            beforeSend: function() {
					if(elm_type !== 'icon'){
			 			$j(this).addClass('btn--wait');
					}
	            },
	            success: function(data) {
					$j('.ajax-to-cart').removeClass('btn--wait');
	                if(data == 'added'){
						$('.add_to_cart').each(function(index, element) {
							if( $('body .add_to_cart').length ){
								$('body .add_to_cart').each(function() {
									if($(this).data('pid') == product){
										var h = $(this);
										if(h.data('type') == 'text'){
											h.html('<i class="fa fa-shopping-cart"></i>'+added_to_cart).fadeIn();				
										} else if(h.data('type') == 'icon'){
											h.html('<i style="color:#AB00FF" class="fa fa-shopping-cart"></i>').fadeIn();					
										}
									}
								});
							}
	                    });
						reload_header_cart();
						//growl
	                    //ajax_load(base_url+'home/cart/added_list/','added_list');
						notify(product_added,'success','bottom','right');
						//sound('successful_cart');
	                } else if (data == 'shortage'){
	                    //button.html(alread);
						notify(quantity_exceeds,'warning','bottom','right');
						//sound('cart_shortage');
	                } else if (data == 'already'){
	                    //button.html(alread);
						notify(product_already,'warning','bottom','right');
						//sound('already_cart');
	                }
	            },
	            error: function(e) {
	                console.log(e)
	            }
	        });
			
		});
		

		
		 $j('.ajax-to-wishlist').click(function(e){
			e.preventDefault();
			//$j('#modalAddToWishlist').modal("toggle");		
			//$j('#modalAddToWishlist .loading').show();
			//$j('#modalAddToWishlist .success').hide();	
	        var state = check_login_stat('state');
			var product = $(this).data('pid');
			var button = $(this);
			
	        state.success(function (data) {
	            if(data == 'hypass'){
					$.ajax({
						url: base_url+'home/wishlist/add/'+product,
						beforeSend: function() {
						},
						success: function(data) {
							if(data == ''){
								//$j('#modalAddToWishlist .loading').hide();
								//$j('#modalAddToWishlist .success').show();
								notify(wishlist_add,'info','bottom','right');
							} else {
								notify(wishlist_already,'warning','bottom','right');
							}
						},
						error: function(e) {
							console.log(e)
						}
					});
	            } else {
					//$j('#modalAddToWishlist .loading').hide();
					//$j('#modalAddToWishlist').modal("toggle");
					signin();
					
				}
	        });	
			
		});	
		
	}


	function reload_header_cart(){
	    $.getJSON(base_url+"home/cart/whole_list", function(result){
			var total = 0;
			var whole_list = '';
			var count = Object.keys(result).length;
	        $.each(result, function(i, field){
				total += Number(field['subtotal'])*exchange;		

      			whole_list +=   "<div class=\"media\" data-rowid=\""+field['rowid']+"\">"
						        +"    <a class=\"pull-left\" href=\""+base_url+'home/product_view/'+field['id']+"\"><img class=\"media-object item-image\" src=\""+field['image']+"\" alt=\"\"></a>"
						        +"    <p class=\"pull-right item-price\">"+currency+(Number(field['price'])*exchange*Number(field['qty'])).toFixed(2)+" <span class=\"remove_one\"><i class=\"fa fa-close\"></i></span></p>"
						        +"    <div class=\"media-body\">"
						        +"        <h4 class=\"media-heading item-title\"><a href=\"#\">"+field['qty']+" X "+field['name']+"</a></h4>"
						        +"    </div>"
						        +"</div>";
				/*
				whole_list_o += "<li class='shopping-cart__item'>"
							+"	  <div class=\"shopping-cart__item__image pull-left\"><a href=\""+field['link']+"\">"
							+"			<img src=\""+field['image']+"\" height=\"60px\" width=\"100px\ alt=\"\"/></a></div>"
							+"	  <div class=\"shopping-cart__item__info\">"
							+"		<div class=\"shopping-cart__item__info__title\">"
							+"		  <h2 class=\"text-uppercase\"><a href=\"\">"+field['name']+"</a></h2>"
							+"		</div>"
							+"		<div class=\"shopping-cart__item__info__price\">"+currency+field['price']+"</div>"
							+"		<div class=\"shopping-cart__item__info__qty\">Qty:"+field['qty']+"</div>"
							+"		<div class=\"shopping-cart__item__info__delete\"><a href=\"#\"></a></div>"
							+"	  </div>"
							+"	</li>"
				*/
				
	        });
			$('.cart_num').html(count);
			$('.header__cart__indicator').html(currency+total.toFixed(2));
			$('.shopping-cart__top').html('Your Cart('+count+')');
			$('.top_carted_list').html(whole_list);
			$('.shopping-cart__total').html(currency+total.toFixed(2));	
	    });
	}


	$(document).ready(function () {
		$.ajax({url: '<?php echo base_url(); ?>home/surfer_info'});
	});

		
</script>
<script>
$( "#btn_no" ).click(function() {
  //alert( "Handler for .click() called." );
  notify(eligible,'warning','bottom','right');
		   window.location.href = "<?php echo base_url(); ?>";
});

</script>

<div id="popup-6" class="activeModal" style="z-index: 999990;">
    <div class="window window1">
        <div class="window_set row" >
        
        </div>
    </div>
</div>
<div id="popup-7" class="activeModal">
    <div class="window window1">
        <div class="window_set row" >
        
        </div>
    </div>
</div>
<div class="foiop" style="display:none;">
<span class="openactiveModal-7 manualLabel" id="qoiqoi" data-ajax=""></span>
<span class="openactiveModal-6 manualLabel" id="qoiqois" data-ajax=""></span>
</div>
<!-- ========== END COPYING HERE ========== -->

        <style>
		.box{
			overflow: hidden;
			position:relative;
		}
		.box .box-img img{
			width:100%;
			height: auto;
		}
		.box .box-img:before{
			content: "";
			position: absolute;
			top: 5%;
			left: 4%;
			width: 92%;
			height: 90%;
			opacity: 0;
			z-index:1;
			transform: scale(0,1);
			border-top: 1px solid #fff;
			border-bottom: 1px solid #fff;
			transition:all 0.90s ease 0s;
		}
		.box .box-img:after{
			content: "";
			position: absolute;
			width: 92%;
			height: 90%;
			top: 5%;
			left: 4%;
			opacity: 0;
			transform: scale(1,0);
			border-left: 1px solid #fff;
			border-right: 1px solid #fff;
			transition:all 0.90s ease 0s;
		}
		.box:hover .box-img:before,
		.box:hover .box-img:after{
			opacity:1;
			transform: scale(1);
		}
		.box .box-img .over-layer{
			position: absolute;
			display:block;
			width:100%;
			height:100%;
			opacity:0;
			transition:all 0.90s ease 0s;
		}
		.box:hover .over-layer{
			opacity:1;
		}
		.box .over-layer ul{
			list-style: none;
			position: relative;
			top: 30%;
			padding: 0;
			text-align: center;
			z-index: 1;
			transition:all 0.6s ease 0s;
		}
		.box:hover .over-layer ul{
			top: 30%;
		}
		.box .over-layer ul li{
			padding:5px;
		}
		
		@media only screen and (max-width: 990px) {
			.box{
				margin-bottom:20px;
			}
		}
		.wp-block.product .price {
			padding:4px 0;
			font-size: 16px !important;
			font-weight: 300 !important;
			color: #272526 !important;
		}
		/*h1, h2, h3, h4, h5, h6 {
    		font-weight: 400 !important;
		}*/
		.alert{
			z-index:999999999 !important;
		}
		.bootstrap-select:not([class*=col-]):not([class*=form-control]):not(.input-group-btn) {
			width: 100%;
		}
		</style>
        
<script type="text/javascript">
	
 
	//google.maps.event.addDomListener(window, 'load', initialize);
	/**/
	
	function tooltip_set(){
		$('[data-toggle="tooltip"]').tooltip(); 
	} 
	
	function isValidEmailAddress(emailAddress) {
		var pattern = new RegExp(/^(("[\w-+\s]+")|([\w-+]+(?:\.[\w-+]+)*)|("[\w-+\s]+")([\w-+]+(?:\.[\w-+]+)*))(@((?:[\w-+]+\.)*\w[\w-+]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$)|(@\[?((25[0-5]\.|2[0-4][\d]\.|1[\d]{2}\.|[\d]{1,2}\.))((25[0-5]|2[0-4][\d]|1[\d]{2}|[\d]{1,2})\.){2}(25[0-5]|2[0-4][\d]|1[\d]{2}|[\d]{1,2})\]?$)/i);
		return pattern.test(emailAddress);
	}
	
	$(document).ready(function(){ 
	
		product_listing_defaults();
		tooltip_set();
		//opc_color();
		//setTimeout(function(){ slide_color(); }, 1000);
			
		
		window.addEventListener("keydown", checkKeyPressed, false);
		 
		function checkKeyPressed(e) {
			if (e.keyCode == "13") {
				$(":focus").each(function() {
					event.preventDefault();
					$(this).closest('form').find('.enterer').click();
					$(this).closest('form').find('.shrc_btn').click();
				});
			}
		}
		
		
		/*
		if($('#location').length > 0){
			//Autocomplete variables
			var input = document.getElementById('location');
			var searchform = document.getElementById('form1');
			var place;
			var autocomplete = new google.maps.places.Autocomplete(input);
			
			
			//Google Map variables
			var map;
			var marker;
			
			//Add listener to detect autocomplete selection
			google.maps.event.addListener(autocomplete, 'place_changed', function () {
				place = autocomplete.getPlace();
				//console.log(place);
			});
			 
			//Reset the inpout box on click
			input.addEventListener('click', function(){
				input.value = "";
			});
		}
	 	*/
	 
		
	});

	function slide_color(){
		var rgb = $('.base').css('background-color');
		$('.active-bg-base').css('background-color',rgb);	
	}
	
	function opc_color(){
		var rgb = $('.base').css('background-color');
		var new_arr = rgb.split(')');
		var rgba = new_arr[0]+',.6)';
		$('.base_opc').css('background-color',rgba);	
	}

	function quick_view(urlh){
		$('#qoiqoi').data('ajax',urlh);
		$('#qoiqoi').click();
	}
	function do_compare(id,e){
		var product = id;
		e = e || window.event;
		e = e.target || e.srcElement;
		var button = $(e);
		var alread 		= button.html();
		if(button.is("i")){
			var alread_classes = button.attr('class');	
		}		
		$.ajax({
			url: base_url+'home/compare/add/'+product,
			beforeSend: function() {
				if(button.is("i")){
					button.attr('class','fa fa-spinner fa-spin fa-fw');	
				} else {
					button.find('i').attr('class','fa fa-spinner fa-spin fa-fw');	
				}
			},
			success: function(data) {
				if(data == 'cat_full'){
					notify(compare_cat_full,'warning','bottom','right');
				} else if (data == 'already'){
					notify(compare_already,'warning','bottom','right');
				} else {
					$.ajax({
						url: base_url+'home/compare/num/', 
						success: function(result){
							$("#compare_tooltip").attr('data-original-title',result);
							$("#compare_num").html(result);
							$("#compare_tooltip").tooltip(); 
						}
					});
					notify(compare_add,'info','bottom','right');
				}
				if(button.is("i")){
					button.attr('class',alread_classes);	
				} else {
					button.html(alread);	
				}
			},
			error: function(e) {
				console.log(e)
			}
		});
	}
	$(document).on("click",'.to_cart_add',function()
	{	
		var state = check_login_stat('state');
		var product = $(this).attr('productid');
		var variationid = $(this).attr('variationid');		
		var coupon_price = $(this).attr('coupon_price');		
		var qty;
		if(variationid == 1) {
			qty = $('.quantity-multiply'+product+variationid).val();
		} else if(variationid == 2){
			qty = $('.quantity-multiply'+product+variationid).val() * 6;
		} else{
			qty = $('.quantity-multiply'+product+variationid).val() * 12;
		}
		var variationqty = $(this).attr('variationqty'+variationid);
		state.success(function (data) {
		if(data == 'hypass')
		{
			var type = "other";
			$.ajax({
				url 		: base_url+'home/cart/add/'+product+'/'+type,
				type 		: 'POST', // form submit method get/post
				dataType 	: 'html', // request type html/json/xml
				data 		: "qty="+qty+"&&variationid="+variationid+"&&variationqty="+variationqty+"&&coupon_price="+coupon_price, // serialize form data 
				success: function(data) {
					$j('.ajax-to-cart').removeClass('btn--wait');
					if(data == 'added'){
						reload_header_cart();
						notify(product_added,'success','bottom','right');
						//sound('successful_cart');
					} else if (data == 'shortage'){
						notify(quantity_exceeds,'warning','bottom','right');
						//sound('cart_shortage');
					} else if (data == 'already'){
						notify(product_already,'warning','bottom','right');
						//sound('already_cart');
					}	
				},
				error: function(e) {
					console.log(e)
				}
			});
		}
		else
		{
			notify(login_first,'warning','bottom','right');
		}
		});	
	});
	$(document).on("click",'.to_wishlist',function()
	{
		var path = $(this).attr('pathaction');	
		var productid = $(this).attr('productid');
		var producttype = $(this).attr('producttype');
		
		$.ajax({
			url: '<?php echo base_url(); ?>home/check_login/state',
				success: function(data) 
				{	
					if(data == 'hypass'){
					$.ajax({
						url: base_url+'home/wishlist/'+path+'/'+productid,
						success: function(data) 
						{
							if(path == 'add')
							{
								if((base_url == current_url)||(producttype == 'related')||(producttype == 'latest')||(producttype == 'recently'))
								{
									$('.product'+productid).attr('title',"<?php echo translate('_added_to_wishlist');  ?>");
									$('.product'+productid).attr('pathaction','remove');
									$('.product'+productid).html("<ion-icon name='heart-sharp'></ion-icon>");
								}
								else
								{
									$('.to_wishlist').html("<ion-icon name='heart-sharp'></ion-icon><?php echo translate('_added_to_wishlist');  ?>");
									$('.to_wishlist').attr('pathaction','remove');
								}
								
								notify(wishlist_add,'info','bottom','right');
							}
							else
							{
								
								if((base_url == current_url)||(producttype == 'related')||(producttype == 'latest')||(producttype == 'recently'))
								{
									$('.product'+productid).attr('title',"<?php echo translate('_add_to_wishlist');  ?>");
									$('.product'+productid).attr('pathaction','add');
									$('.product'+productid).html("<ion-icon name='heart-outline'></ion-icon>");
								}
								else
								{
									$('.to_wishlist').attr('pathaction','add');
									$('.to_wishlist').html("<ion-icon name='heart-outline'></ion-icon><?php echo translate('_add_to_wishlist');  ?>");
								}
								
								notify(wishlist_remove,'warning','bottom','right');
							}
							
						},
						error: function(e) {
							console.log(e)
						}
					});
						}
						else{
							signin();
						}  
				}
			});
	});
	
	/*function to_cart(id,e){	
		var product = id;		
		e = e || window.event;
		e = e.target || e.srcElement;
		var elm_type = $(e).data('type');
		var button = $(e);
		var alread = button.html();
		if(button.is("i")){
			var alread_classes = button.attr('class');	
		}
		var type = 'pp';
		if(button.closest('.row').find('.cart_quantity').length){
			quantity = button.closest('.margin-bottom-40').find('.cart_quantity').val();
		}
		
		if($('#pnopoi').length){
			type = 'pp';
			var form = button.closest('form');
			var formdata = false;
			if (window.FormData){
				formdata = new FormData(form[0]);
			}
			var option = formdata ? formdata : form.serialize();
		} else {
			type = 'other';
			var form = $('#cart_form_singl');
			var formdata = false;
			if (window.FormData){
				formdata = new FormData(form[0]);
			}
			var option = formdata ? formdata : form.serialize();
		}
		
		$.ajax({
			url 		: base_url+'home/cart/add/'+product+'/'+type,
			type 		: 'POST', // form submit method get/post
			dataType 	: 'html', // request type html/json/xml
			data 		: option, // serialize form data 
			cache       : false,
			contentType : false,
			processData : false,
			beforeSend: function() {
				if(button.is("i")){
					button.attr('class','fa fa-spinner fa-spin fa-fw');	
				} else {
					button.find('i').attr('class','fa fa-spinner fa-spin fa-fw');	
				}			
			},
			success: function(data) {
				$j('.ajax-to-cart').removeClass('btn--wait');
				if(data == 'added'){
					reload_header_cart();
					notify(product_added,'success','bottom','right');
					//sound('successful_cart');
				} else if (data == 'shortage'){
					notify(quantity_exceeds,'warning','bottom','right');
					//sound('cart_shortage');
				} else if (data == 'already'){
					notify(product_already,'warning','bottom','right');
					//sound('already_cart');
				}
				if(button.is("i")){
					button.attr('class',alread_classes);	
				} else {
					button.html(alread);	
				}	
			},
			error: function(e) {
				console.log(e)
			}
		});
	}*/
	

	function signin(carry){
		$('#qoiqois').data('ajax','<?php echo base_url(); ?>home/login_set/login/modal/'+carry);
		$('#qoiqois').click();
	}
	function wallet(hurl){
		$('#qoiqois').data('ajax',hurl);
		$('#qoiqois').click();
	}
	
	function view_package_details(hurl){
		$('#qoiqois').data('ajax',hurl);
		$('#qoiqois').click();
	}
	
	
	function set_select(){
		$('.selectpicker').selectpicker();
	}
	$(document).ready(function() {
		//set_select();
		$('.drops').dropdown();
	});
	function check_login_stat(thing){
		return $.ajax({
			url: '<?php echo base_url(); ?>home/check_login/'+thing
		});
	}	

	function check_login_stat_for_like(thing){
		return $.ajax({
			url: '<?php echo base_url(); ?>home/check_login/'+thing,
				success: function(data) {
					login_state = data;
			   }
		});
	}


	
	function reg(){
		$('.regis_btn').click();
	}
	
	function reload_page(){
		var loc = location.href;
		location.replace(loc);
	}
	
	
	function notify(message,type,from,align){		
		jQuery.notify({
			// options
			message: message 
		},{
			// settings
			type: type,
			placement: {
				from: from,
				align: align
			}
		});
		
	}
	
	function form_submit(form_id){
		var form = $('#'+form_id);
		var button = form.find('.submit_button');
		var prv = button.html();
		var ing = button.data('ing');
		var success = button.data('success');
		var unsuccessful = button.data('unsuccessful');
		var redirect_click = button.data('redirectclick');
		form.find('.summernotes').each(function() {
			var now = $(this);
			now.closest('div').find('.val').val(now.code());
		});
		
		//var form = $(this);
		var formdata = false;
		if (window.FormData){
			formdata = new FormData(form[0]);
		}
		
	
		$.ajax({
			url: form.attr('action'), // form action url
			type: 'POST', // form submit method get/post
			dataType: 'html', // request type html/json/xml
			data: formdata ? formdata : form.serialize(), // serialize form data 
			cache       : false,
			contentType : false,
			processData : false,
			beforeSend: function() {
				button.html(ing); // change submit button text
			},
			success: function(data) {
				var alls = data.split('#-#-#');
				var part1 = alls[0];
				var part2 = alls[1];
				if(part1 == 'success'){
					notify(success,'success','bottom','right');
					if(part2 == ''){
						$(redirect_click).click();
					} else {
						location.replace(part2);
					}
					form.find('input').val('');
					form.find('textarea').val('');
					form.find('textarea').html('');
				} else {
					var text = '<div>'+unsuccessful+'</div>'+part2;
					notify(text,'warning','bottom','right');
				}
				button.html(prv);
				
			},
			error: function(e) {
				console.log(e)
			}
		});
				
	}
	
	function header_search_set(val){
		if(val == 'product'){
			$('.cat_select').show();
		} else if(val == 'vendor'){
			$('.cat_select').hide();
		}
	}
	
	function tes(val,e){
		e = e || window.event;
		e = e.target || e.srcElement;
		$(e).css('background','red');	
	}
	
	// Plugin invoke
	
	/*function set_modal(){
		$("#popup-6").activeModals({
			// Functionality
			popupType: "delayed",
			delayTime: 1000,
			exitTopDistance: 40,
			scrollTopDistance: 400,
			setCookie: false,
			cookieDays: 0,
			cookieTriggerClass: "setCookie-1",
			cookieName: "activeModal-1",
	
			// Overlay options
			overlayBg: true,
			overlayBgColor: "rgba(255, 255, 255, 0.721569)",
			overlayTransition: "ease",
			overlayTransitionSpeed: "0.4",
	
			// Background effects
			bgEffect: "scaled",
			blurBgRadius: "2px",
			scaleBgValue: "1",
	
			// Window options
			windowWidth: "530px",
			windowHeight: "580px",
			windowLocation: "center",
			windowTransition: "fadeIn",
			windowTransitionSpeed: "0.4",
			windowTransitionEffect: "fadeIn",
			windowShadowOffsetX: "0",
			windowShadowOffsetY: "0",
			windowShadowBlurRadius: "20px",
			windowShadowSpreadRadius: "0",
			windowShadowColor: "none",
			windowBackground: "none",
			windowRadius: "0px",
			windowMargin: "10px",
			windowPadding: "10px",
	
			// Close and reopen button
			closeButton: "icon",
			reopenClass: "openactiveModal-6",
		});
		$("#popup-7").activeModals({
			// Functionality
			popupType: "delayed",
			delayTime: 1000,
			exitTopDistance: 40,
			scrollTopDistance: 400,
			setCookie: false,
			cookieDays: 0,
			cookieTriggerClass: "setCookie-1",
			cookieName: "activeModal-1",
	
			// Overlay options
			overlayBg: true,
			overlayBgColor: "rgba(255, 255, 255, 0.72)",
			overlayTransition: "ease",
			overlayTransitionSpeed: "0.4",
	
			// Background effects
			bgEffect: "scaled",
			blurBgRadius: "2px",
			scaleBgValue: "1",
	
			// Window options
			windowWidth: "1000px",
			windowHeight: "600px",
			windowLocation: "center",
			windowTransition: "ease",
			windowTransitionSpeed: "0.4",
			windowTransitionEffect: "fadeIn",
			windowShadowOffsetX: "0",
			windowShadowOffsetY: "0",
			windowShadowBlurRadius: "20px",
			windowShadowSpreadRadius: "0",
			windowShadowColor: "rgba(0,0,0,.8)",
			windowBackground: "rgba(255,255,255,1)",
			windowRadius: "0px",
			windowMargin: "10px",
			windowPadding: "30px",
	
			// Close and reopen button
			closeButton: "icon",
			reopenClass: "openactiveModal-7",
		});	
	}*/


	$(document).ready(function () {
		/*set_modal();*/	
		
		$('.window_set').on('click','.author_contact_submitter',function(event){
			event.preventDefault();
			var now = $(this);
			var btntxt = now.html();
			var form = now.closest('form');  
			var success = now.data('success');
			var unsuccessful = now.data('unsuccessful');
			var formdata = false;
			if (window.FormData){
				formdata = new FormData(form[0]);
			}
	
			$.ajax({
				url: form.attr('action'), // form action url
				type: 'POST', // form submit method get/post
				dataType: 'html', // request type html/json/xml
				data: formdata ? formdata : form.serialize(), // serialize form data 
				cache       : false,
				contentType : false,
				processData : false,
				beforeSend: function() {
					now.html('<span>submitting...</span>');
				},
				success: function(data) {
					if(data == 'success'){
						notify(success,'success','bottom','right');
						$(".closeModal").click();
					} else {
						var text = '<div>'+unsuccessful+'</div>'+data;
						notify(text,'warning','bottom','right');
					}
					now.html(btntxt);
				},
				error: function(e) {
					console.log(e)
				}
			});
		});
		
		$('body').on('click','.signup_btn',function(event){
			event.preventDefault();
			var now = $(this);
			var btntxt = now.html();
			var form = now.closest('form');  
			var ing = now.data('ing');
			var success = now.data('success');
			var unsuccessful = now.data('unsuccessful');
			var rld = now.data('reload');
			var callback = now.data('callback');
			var formdata = false;
			if (window.FormData){
				formdata = new FormData(form[0]);
			}
	
			$.ajax({
				url: form.attr('action'), // form action url
				type: 'POST', // form submit method get/post
				dataType: 'html', // request type html/json/xml
				data: formdata ? formdata : form.serialize(), // serialize form data 
				cache       : false,
				contentType : false,
				processData : false,
				beforeSend: function() {
					// now.attr('disabled','disabled');
					$(".btn_dis").attr('disabled','disabled');
					now.html(ing);
				},
				success: function(data) {
					if(data == 'done' || data.search('done') !== -1){
						notify(success,'success','bottom','right');
						if(rld == 'ok'){
							setTimeout(function(){location.reload();}, 2000);
						}
						if(callback == 'order_tracing'){
							// now.removeAttr('disabled');
							data = data.replace('done','');
        					$('#trace_details').html(data);
						}
						$(".closeModal").click();
					} else {
						$(".btn_dis").removeAttr('disabled');
						var text = '<div>'+unsuccessful+'</div>'+data;
						notify(text,'warning','bottom','right');
					}
					now.html(btntxt);
				},
				error: function(e) {
					console.log(e)
				}
			});
		});
		
		$('body').on('click', '.wish_it', function(){
			var state = check_login_stat('state');
			var product = $(this).data('pid');
			var button = $(this);
			
			state.success(function (data) {
				if(data == 'hypass'){
					$.ajax({
						url: base_url+'home/wishlist/add/'+product,
						beforeSend: function() {
							button.html('<span><?php echo translate('working...'); ?></span>');
						},
						success: function(data) {
							button.html('<span><?php echo translate('favored'); ?></span>');
							button.removeClass("wish_it");
							button.addClass("wished_it");
							button.closest('ul').data('originalTitle',wishlist_add1);
							notify(wishlist_add,'info','bottom','right');
							sound('successful_wish');
						},
						error: function(e) {
							console.log(e)
						}
					});
				} else {
					signin();
				}
			});
		});
		
		$('body').on('click', '.btn_wish', function(){
			var state = check_login_stat('state');
			var product = $(this).data('pid');
			var button = $(this);
			state.success(function (data) {
				if(data == 'hypass'){
					$.ajax({
						url: base_url+'home/wishlist/add/'+product,
						beforeSend: function() {
							button.html(wishlist_adding); // change submit button text
						},
						success: function(data) {
							button.removeClass("btn_wish");
							button.addClass("btn_wished");
							button.html('<span>'+wishlist_add1+'</span>');
							notify(wishlist_add,'info','bottom','right');
							sound('successful_wish');
						},
						error: function(e) {
							console.log(e)
						}
					});
				} else {
					signin();
				}
			});
		});
	
		
		
		$('body').on('click','.logup_btn', function(){
			var here = $(this); // alert div for show alert message
			var form = here.closest('form');
			var can = '';
			var ing = here.data('ing');
			var msg = here.data('msg');
			var prv = here.html();
			
			//var form = $(this);
			var formdata = false;
			if (window.FormData){
				formdata = new FormData(form[0]);
			}
			
			$.ajax({
				url: form.attr('action'), // form action url
				type: 'POST', // form submit method get/post
				dataType: 'html', // request type html/json/xml
				data: formdata ? formdata : form.serialize(), // serialize form data 
				cache       : false,
				contentType : false,
				processData : false,
				beforeSend: function() {
					here.html(ing); // change submit button text
					$('.ajax-loader').css("visibility", "visible");
				},
				success: function(data) {
					$('.ajax-loader').css("visibility", "hidden");					
					here.fadeIn();
					here.html(prv);
					if(data == 'done'){
						 
						
								var url = window.location.href;
								if(url.search("vendor_logup") !== -1){
									//$('.vendor_login_btn')[0].click();
									notify(logup_success,'success','bottom','right');
									location.replace("<?php echo base_url(); ?>home/vendor_login_msg");
								} else{
									notify(verify_check,'success','bottom','right');
									location.replace("<?php echo base_url(); ?>home/login_set/login");
								}

						setTimeout(
							function() {	
							var url = window.location.href;	
							}, 3000
						);
						//sound('successful_logup');  		
					}else if(data == 'done_and_sent'){
				
								var url = window.location.href;
								if(url.search("vendor_logup") !== -1){
									//$('.vendor_login_btn')[0].click();
									notify(logup_success+'<br>'+email_sent,'success','bottom','right');
									location.replace("<?php echo base_url(); ?>home/vendor_login_msg");
								} else{
									notify(verify_check,'success','bottom','right');
									location.replace("<?php echo base_url(); ?>home/login_set/login");

								}
							setTimeout(
							function() {	
							var url = window.location.href;	
							}, 3000
						);
					}else if(data == 'done_but_not_sent'){
						notify(email_fail,'warning','bottom','right');
						notify(logup_success,'success','bottom','right');
						setTimeout(
							function() {
								var url = window.location.href;
								if(url.search("vendor_logup") !== -1){
									//$('.vendor_login_btn')[0].click();
									location.replace("<?php echo base_url(); ?>home/vendor_login_msg");
								} else{
									location.replace("<?php echo base_url(); ?>home/login_set/login");
								}
							}, 2000
						);
					} else {
						//here.closest('.modal-content').find('#close_logup_modal').click();
						notify('Signup failed'+'<br>'+data,'warning','bottom','right');
						//sound('unsuccessful_logup');
					}
				},
				error: function(e) {
					console.log(e)
				}
			});
		});
		
		$("body").on('click','.login_btn',function(){
			var here = $(this); // alert div for show alert message
			var text = here.html(); // alert div for show alert message
			var form = here.closest('form');
			var logging = here.data('ing');
			//var form = $(this);
			var formdata = false;
			if (window.FormData){
				formdata = new FormData(form[0]);
			}
			$.ajax({
				url: form.attr('action'), // form action url
				type: 'POST', // form submit method get/post
				dataType: 'html', // request type html/json/xml
				data: formdata ? formdata : form.serialize(), // serialize form data 
				cache       : false,
				contentType : false,
				processData : false,
				beforeSend: function() {
					here.addClass('disabled');
					here.html(logging); // change submit button text
				},
				success: function(data) {
					here.fadeIn();
					here.html(text);
					here.removeClass('disabled');
					if(data == 'done'){
						$('.closeModal').click();
						notify('<?php echo translate('successful_login'); ?>','success','bottom','right');
						setTimeout(function(){ location.href= base_url }, 2000);
						//sound('successful_login');
					} else if(data == 'failed'){
						notify('<?php echo translate('login_failed'); ?>','warning','bottom','right');
						//sound('unsuccessful_login');
					} else {
						notify(data,'warning','bottom','right');
					}
				},
				error: function(e) {
					console.log(e)
				}
			});
		});
		
		
		
		
		$("body").on('click','.wallet_add_btn',function(){
			var here = $(this); // alert div for show alert message
			var text = here.html(); // alert div for show alert message
			var form = here.closest('form');
			var logging = '<?php echo translate('working'); ?>...';
			//var form = $(this);
			var formdata = false;
			if (window.FormData){
				formdata = new FormData(form[0]);
			}
			if(form.find($("[name='method']")).length < 1){
				var meth = '';
			} else {
				var meth = form.find($("[name='method']")).val();
			}
			var amount = Number(form.find($("[name='amount']")).val());
			//console.log('--'+amount+'--'+meth+'--');
			if(meth == '' || amount == ''){
				notify('<?php echo translate('fill_all_fields_correctly'); ?>','warning','bottom','right');
			} else {
				$.ajax({
					url: form.attr('action'), // form action url
					type: 'POST', // form submit method get/post
					dataType: 'html', // request type html/json/xml
					data: formdata ? formdata : form.serialize(), // serialize form data 
					cache       : false,
					contentType : false,
					processData : false,
					beforeSend: function() {
						here.addClass('disabled');
						here.html(logging); // change submit button text
					},
					success: function(data) {
						here.fadeIn();
						here.html(text);
						here.removeClass('disabled');
						if(data == 'done'){
							$('.closeModal').click();
							notify('<?php echo translate('deposit_request_sent'); ?>','success','bottom','right');
							//setTimeout(function(){wish_listed('0');}, 2000);
							wallet_listed('0');
						} else if(data == 'failed'){
							notify('<?php echo translate('deposit_request_sending_failed'); ?>','warning','bottom','right');
						} else {
							notify(data,'warning','bottom','right');
						}
					},
					error: function(e) {
						console.log(e)
					}
				});
			}
		});
		
		
		
		$("body").on('click','.info_add_btn',function(){
			var here = $(this); // alert div for show alert message
			var text = here.html(); // alert div for show alert message
			var form = here.closest('form');
			var logging = '<?php echo translate('working'); ?>...';
			//var form = $(this);
			var formdata = false;
			if (window.FormData){
				formdata = new FormData(form[0]);
			}
			var payment_info = form.find($("[name='payment_info']")).val();

			if(payment_info == ''){
				notify('<?php echo translate('fill_all_fields_correctly'); ?>','warning','bottom','right');
			} else {
				$.ajax({
					url: form.attr('action'), // form action url
					type: 'POST', // form submit method get/post
					dataType: 'html', // request type html/json/xml
					data: formdata ? formdata : form.serialize(), // serialize form data 
					cache       : false,
					contentType : false,
					processData : false,
					beforeSend: function() {
						here.addClass('disabled');
						here.html(logging); // change submit button text
					},
					success: function(data) {
						here.fadeIn();
						here.html(text);
						here.removeClass('disabled');
						if(data == 'done'){
							$('.closeModal').click();
							notify('<?php echo translate('payment_info_sent'); ?>','success','bottom','right');
							//setTimeout(function(){wish_listed('0');}, 2000);
							wallet_listed('0');
						} else if(data == 'failed'){
							notify('<?php echo translate('payment_info_sending_failed'); ?>','warning','bottom','right');
						} else {
							notify(data,'warning','bottom','right');
						}
					},
					error: function(e) {
						console.log(e)
					}
				});
			}
		});
		
		
		
		$("body").on('click','.forget_btn',function(){
			var here = $(this); // alert div for show alert message
			var text = here.html(); // alert div for show alert message
			var form = here.closest('form');
			var submitting = here.data('ing');
			//var form = $(this);
			var formdata = false;
			if (window.FormData){
				formdata = new FormData(form[0]);
			}
			$.ajax({
				url: form.attr('action'), // form action url
				type: 'POST', // form submit method get/post
				dataType: 'html', // request type html/json/xml
				data: formdata ? formdata : form.serialize(), // serialize form data 
				cache       : false,
				contentType : false,
				processData : false,
				beforeSend: function() {
					here.addClass('disabled');
					here.html(submitting); // change submit button text
				},
				success: function(data) {
					here.fadeIn();
					here.html(text);
					here.removeClass('disabled');
					if(data == 'email_sent'){
						notify(email_sent,'info','bottom','right');
						$(".closeModal").click();
					} else if(data == 'email_nay'){
						$(".closeModal").click();
						notify(email_noex,'info','bottom','right');
					} else if(data == 'email_not_sent'){
						$(".closeModal").click();
						notify(email_fail,'info','bottom','right');
					} else {
						notify(data,'warning','bottom','right');
					}
				},
				error: function(e) {
					console.log(e)
				}
			});
		});
		
		
		
	});
</script>

<style>
	.loading_parent{
		height:500px;
		width:100%;	
		position:absolute;
	}
	#loading-center-relative {
		position: relative;
		left: 50%;
		top: 50%;
		height: 150px;
		width: 150px;
		margin-top: -75px;
		margin-left: -75px;
	}
	.object_on{
		width: 20px;
		height: 20px;
		float: left;
		margin-right: 20px;
		margin-top: 65px;
		-moz-border-radius: 50% 50% 50% 50%;
		-webkit-border-radius: 50% 50% 50% 50%;
		border-radius: 50% 50% 50% 50%;
		zoom: .5;
	}
	
	#object_one_on {	
		-webkit-animation: object_one 1.5s infinite;
		animation: object_one 1.5s infinite;
	}
	#object_two_on {
		-webkit-animation: object_two 1.5s infinite;
		animation: object_two 1.5s infinite;
		-webkit-animation-delay: 0.25s; 
		animation-delay: 0.25s;
	}
	#object_three_on {
		-webkit-animation: object_three 1.5s infinite;
		animation: object_three 1.5s infinite;
		-webkit-animation-delay: 0.5s;
		animation-delay: 0.5s;
	}
	
	@-webkit-keyframes object_one_on {
	75% { -webkit-transform: scale(0); }
	}
	
	@keyframes object_one_on {
	  75% { 
		transform: scale(0);
		-webkit-transform: scale(0);
	  }
	}
	@-webkit-keyframes object_two_on {
	  75% { -webkit-transform: scale(0); }
	}
	
	@keyframes object_two_on {
	  75% { 
		transform: scale(0);
		-webkit-transform:  scale(0);
	  }
	}
	@-webkit-keyframes object_three_on {
	  75% { -webkit-transform: scale(0); }
	}
	@keyframes object_three_on {
	  75% { 
		transform: scale(0);
		-webkit-transform: scale(0);
	  }
	}
</style>


<style>

#loading-center1{
	width: 100%;
	height: 100%;
	position: relative;
}
#loading-center-absolute1 {
	position: absolute;
	left: 50%;
	top: 50%;
	height: 150px;
	width: 150px;
	margin-top: -75px;
	margin-left: -75px;
}
.object1{
	width: 20px;
	height: 20px;
	float: left;
	margin-right: 20px;
	margin-top: 65px;
	-moz-border-radius: 50% 50% 50% 50%;
	-webkit-border-radius: 50% 50% 50% 50%;
	border-radius: 50% 50% 50% 50%;
}

#object_one1 {	
	-webkit-animation: object_one1 1.5s infinite;
	animation: object_one1 1.5s infinite;
	}
#object_two1 {
	-webkit-animation: object_two1 1.5s infinite;
	animation: object_two1 1.5s infinite;
	-webkit-animation-delay: 0.25s; 
    animation-delay: 0.25s;
	}
#object_three1 {
    -webkit-animation: object_three1 1.5s infinite;
	animation: object_three1 1.5s infinite;
	-webkit-animation-delay: 0.5s;
    animation-delay: 0.5s;
	
	}


@-webkit-keyframes object_one1 {
75% { -webkit-transform: scale(0); }
}

@keyframes object_one1 {

  75% { 
    transform: scale(0);
    -webkit-transform: scale(0);
  }

}

@-webkit-keyframes object_two1 {
 

  75% { -webkit-transform: scale(0); }


}

@keyframes object_two1 {
  75% { 
    transform: scale(0);
    -webkit-transform:  scale(0);
  }

}

@-webkit-keyframes object_three1 {

  75% { -webkit-transform: scale(0); }

}

@keyframes object_three1 {

  75% { 
    transform: scale(0);
    -webkit-transform: scale(0);
  }
  
}

</style>
<div id="loading1" style="display:none;">
    <div id="loading-center1">
        <div id="loading-center-absolute1">
            <div class="object1 base" id="object_one1"></div>
            <div class="object1 base" id="object_two1"></div>
            <div class="object1 base" id="object_three1"></div>
        </div>
	</div>
</div>



<input type="hidden" id="page_num" value="0" />
<script>
	function others_count(){
		
	}
	var loading = $('#loading1').html();
	var base = $('.base').css('background');
	loading = '<span class="loading_parent col-md-12">'+loading+'</span>';
    function filter(page){
		if(page == 'no'){
			page = $('#page_num').val();	
		} else {
			$('#page_num').val(page);
		}
        var form = $('#filter_form');
        var alert = $('#result');
        var formdata = false;
        if (window.FormData){
            formdata = new FormData(form[0]);
        }
        $.ajax({
            url: form.attr('action')+page+'/', // form action url
			type: 'POST', // form submit method get/post
			dataType: 'html', // request type html/json/xml
			data: formdata ? formdata : form.serialize(), // serialize form data 
			cache       : false,
			contentType : false,
			processData : false,
            beforeSend: function() {
				alert.fadeOut();
                alert.html(loading).fadeIn(); // change submit button text
				$('.loading_parent').find("#loading-center").show();
				$('.loading_parent').find(".object1").addClass('base');
            },
            success: function(data) {
				setTimeout(function(){
                	alert.html(data); // fade in response data
				}, 20);
				setTimeout(function(){
                	alert.fadeIn(); // fade in response data
					$('.pagination_links').html($('#pagenation_set_links').html());
				}, 30);
				$('.loading_parent').find("#loading-center1").hide();
            },
            error: function(e) {
                console.log(e)
            }
        });
        
    }
	
	$(document).ready(function() {
			
		$('body').on('click','.remove_one', function(){
			var here = $(this);
			var rowid = here.closest('.media').data('rowid');
			var thetr = here.closest('.media');
			var list1 = $('#total');
			$.ajax({
				url: base_url+'home/cart/remove_one/'+rowid,
				beforeSend: function() {
					list1.html('...');
				},
				success: function(data) {
					list1.html(data).fadeIn();
					notify(cart_product_removed,'success','bottom','right');
					//sound('cart_product_removed');
					reload_header_cart();
					others_count();
					thetr.hide('fast');
					if($('#coup_frm').length > 0){
						$('.carter_table').find("tr[data-rowid='" + rowid + "']").remove();
						if(data == 0){
							location.replace('<?php echo base_url();?>');	
						}
					}
				},
				error: function(e) {
					console.log(e)
				}
			});
		});
		
    });
    
</script>

<script>
		function load_textarea(){
			$('.textarea').wysihtml5({
				"font-styles": true,
				"color": true,
				"emphasis": true,
				"lists": true,
				"html": true,
				"link": false,
				"image": false,
				events: {},
				parserRules: {
					classes: {
						// (path_to_project/lib/css/wysiwyg-color.css)
						"wysiwyg-color-silver" : 1,
						"wysiwyg-color-gray" : 1,
						"wysiwyg-color-white" : 1,
						"wysiwyg-color-maroon" : 1,
						"wysiwyg-color-red" : 1,
						"wysiwyg-color-purple" : 1,
						"wysiwyg-color-fuchsia" : 1,
						"wysiwyg-color-green" : 1,
						"wysiwyg-color-lime" : 1,
						"wysiwyg-color-olive" : 1,
						"wysiwyg-color-yellow" : 1,
						"wysiwyg-color-navy" : 1,
						"wysiwyg-color-blue" : 1,
						"wysiwyg-color-teal" : 1,
						"wysiwyg-color-aqua" : 1,
						"wysiwyg-color-orange" : 1
					},
					tags: {
						"b":  {},
						"i":  {},
						"br": {},
						"ol": {},
						"ul": {},
						"li": {},
						"h1": {},
						"h2": {},
						"h3": {},
						"h4": {},
						"h5": {},
						"h6": {},
						"blockquote": {},
						"u": 1,
						"img": {
							"check_attributes": {
								"width": "numbers",
								"alt": "alt",
								"src": "url",
								"height": "numbers"
							}
						},
						"a":  {
							check_attributes: {
								'href': "url", // important to avoid XSS
								'target': 'alt',
								'rel': 'alt',
								
							}
						},
						"span": 1,
						"div": 1,
						// to allow save and edit files with code tag hacks
						"code": 1,
						"pre": 1
					}
				},
				stylesheets: ["<?php echo base_url(); ?>template/front/wysihtml5/wysiwyg-color.css"], // (path_to_project/lib/css/wysiwyg-color.css)
				locale: "en"
			});
		}

	    function check_login_stat(thing){
	        return $.ajax({
	            url: '<?php echo base_url(); ?>home/check_login/'+thing
	        });
	    }
		
		function load_iamges(){
			$('body').find('.image_delay').each(function(){
				var src = $(this).data('src');
				if($(this).is('img')){
					$(this).attr('src',src);			
				} else {
					$(this).css('background-image',"url('"+src+"')");			
				}
			});	
		}
	var delivery = { del : '' };	
	validation(delivery);
    function validation(delivery)
    {
		
        var item_value = "<?php echo count($this->cart->contents()) ?>"; /* number of cart item */
        var first_name = $('input[name='+delivery.del+'first_name]').val();
        var last_name = $('input[name='+delivery.del+'last_name]').val();
        var phone = $('input[name='+delivery.del+'phone]').val();
        var email = $('input[name='+delivery.del+'email]').val();
        var address1 = $('input[name='+delivery.del+'address1]').val();
        var address2 = $('input[name='+delivery.del+'address2]').val();
        var city = $('input[name='+delivery.del+'city]').val();
        var state = $('input[name='+delivery.del+'state]').val();
        var state_or_province_code = $('input[name='+delivery.del+'state_or_province_code]').val();
        var country = $('#'+delivery.del+'country').children("option:selected").val();

        var postal_code = $('input[name='+delivery.del+'postal_code]').val();

		

        var data = {
                'item_value' : item_value,
                'first_name' : first_name,
                'last_name' : last_name,
                'phone' : phone,
                'email' : email,
                'address1' : address1,
                'address2' : address2,
                'city' : city,
                'state' : state,
                'state_or_province_code' : state_or_province_code,
                'country' : country,
                'postal_code' : postal_code
            };

        return data;    
    }
    $(document).on('click','.ishipping_api', function()
    {

		if($(".same_delivery").is(":checked"))
			delivery = { del : 'delivery_' };
		else 
			delivery = { del : '' };
		
        var data = validation(delivery);  
       /* if((data.first_name =="")||(data.last_name=="")||(data.phone=="")||(data.email==""))
        {
            notify("All Fields are required",'warning','bottom','right');
        }
        else
		{*/
			
			var showtext = "&nbsp;<span class='show-txt text-over'>+</span><span class='hide-txt text-over' style='display:none;'>-</span>";
            $.ajax({
                url: base_url + 'home/ishippingCal',
                dataType: 'json',
                method : 'Post',
                data : data,
                beforeSend: function() 
                {
                    $('.ajax-loader').css("visibility", "visible");
                    $('.ishipping_result').hide();
                },
                success: function(resp) 
                {
                    $('.ajax-loader').css("visibility", "hidden");
					$('.required').hide();
					var result = resp.response
                    if(result.postage_result)
                    {
                    	if(result.postage_result.status=='success')
                    	{

							console.log(result.postage_result,'-------- taxxxx')
							$('#ishipping_duty').parent().show();
							$("#gst-domestic").parent().hide();
							$("#international-disclaimer").show();
							
	                        $('.ishipping_result').show();
	                        $('.comman_checkout').removeClass('disabled');
	                        $('#ishipping_custom').html("$"+result.postage_result.data.delivery.charges);
	                        $('#ishipping_duty').html("$"+result.postage_result.data.total_duty+showtext);
	                        $('#ishipping_total').html("$"+result.postage_result.data.total_cost);
							$('#estimated_delivery_time').html(result.postage_result.data.estimated_delivery_time);
							
							$('#alcohol-tax').html("$"+result.postage_result.data.tax.alcohol_tax_est);
							$('#import-vat').html("$"+result.postage_result.data.tax.import_vat_est);
							$('#import-duty').html("$"+result.postage_result.data.tax.import_duty_est);
	                        update_calc_cart();
	                    }else if(result.postage_result.status=='Success'){
							$('.ishipping_result').show();
							$("#international-disclaimer").hide();
	                        $('.comman_checkout').removeClass('disabled');
	                        $('#ishipping_custom').html("$"+result.postage_result.data.delivery.charges);
	                        // $('#ishipping_duty').html("$0");
							$("#gst-domestic").parent().show();
							$('#ishipping_duty').parent().hide();
	                        $('#ishipping_total').parent().css("display","none");
	                        $('#estimated_delivery_time').html(result.postage_result.data.estimated_delivery_time);
	                        update_calc_cart();
						}
	                    else
	                    {
	                    	notify(result.postage_result.msg,'warning','bottom','right');
	                    }    

                    }
                    if(result.status=='Failed')
                    {
                        notify(result.message,'warning','bottom','right');
                    }
                }
            });
       /* } */   
    });
</script>
