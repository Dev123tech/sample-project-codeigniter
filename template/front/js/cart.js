$('body').on('click', '.colrs', function() {
    var here = $(this);
    var rowid = here.closest('tr').data('rowid');
    var val = here.closest('li').find('input').val();
    if (val == 'undefined') {
        val = '';
    }
    val = val.split(",").join("-");
    val = val.replace(')', '--');
    val = val.replace('(', '---');

    $.ajax({
        url: base_url + 'home/cart/upd_color/' + rowid + '/' + val,
        beforeSend: function() {},
        success: function() {
            //other option
            reload_header_cart();
        },
        error: function(e) {
            console.log(e)
        }
    });
});

function others_count() {
    update_calc_cart();
}


function check_ok(element) {
    var here = $(element);
    here.closest('td').find('.minus').click();
    here.closest('td').find('.plus').click();
}

$('body').on('click', '.quantity-button', function() {
    var here = $(this);
    var variationqty = here.attr('variationqty');
    var quantity = here.closest('td').find('.quantity_field').val();
    var limit = here.closest('td').find('.quantity_field').data('limit');
    if (here.val() == 'minus') {
        quantity = quantity - parseInt(variationqty);
    } else if (here.val() == 'plus') {
        //if(limit == 'no'){
        quantity = Number(quantity) + parseInt(variationqty);
        //console.log(quantity);
        // }
    }
    if (quantity >= variationqty) {
        here.closest('td').find('.quantity_field').val(quantity);

        var rowid = here.closest('td').find('.quantity_field').data('rowid');
        var lim_t = here.closest('tr').find('.limit');
        var list1 = here.closest('tr').find('.sub_total');
        var list2 = here.closest('tr').find('.discount');
        var list3 = here.closest('tr').find('.promocode_price');
        var list4 = here.closest('tr').find('.rrp');
        var list5 = here.closest('tr').find('.orp');

        $.ajax({
            url: base_url + 'home/cart/quantity_update/' + rowid + '/' + quantity,
            beforeSend: function() {
                list1.html('...');
                list2.html('...');
                list3.html('...');
                list4.html('...');
                list5.html('...');
            },
            success: function(data) {
                var res = data.split("---");
                var show_subtotal = JSON.parse(res[0]);
                list1.html(show_subtotal.subtotal);
                list2.html(show_subtotal.discount);
                list3.html(show_subtotal.promocode_price);
                list4.html(show_subtotal.rrp);
                list5.html(show_subtotal.orp);
                reload_header_cart();
                others_count();
                if (res[1] !== 'not_limit') {
                    lim_t.html('!!').fadeIn();
                    here.closest('td').find('.plus').hide();
                    here.closest('td').find('.quantity_field').data('limit', 'yes');
                    here.closest('td').find('.quantity_field').val(res[1]);
                } else {
                    lim_t.html('').fadeOut();
                    here.closest('td').find('.plus').show();
                    here.closest('td').find('.quantity_field').data('limit', 'no');
                }
            },
            error: function(e) {
                console.log(e)
            }
        });
    }
});

function cart_submission() {
    //var payment_type = $('#ab').val();
    var payment_type = '';
    var state = check_login_stat('state');
    state.success(function(data) {
        var form = $('#cart_form');
        form.submit();
    });
}

$(document).ready(function() {
    update_calc_cart();
    $('.colrs').each(function() {
        var here = $(this);
        var rad = here.closest('li').find('input');
        if (rad.is(':checked')) {
            setTimeout(function() {
                here.click();
            }, 800);
        }
    });
});

function update_prices() {

    var url = base_url + 'home/cart/calcs/prices';
    $.ajax({
        url: url,
        dataType: 'json',
        beforeSend: function() {

        },
        success: function(data) {
            $.each(data, function(key, item) {
                var elem = $("table").find("[data-rowid='" + item.id + "']");
                elem.find('.sub_total').html(item.subtotal);
                elem.find('.pric').html(item.price);
            });
        },
        error: function(e) {
            console.log(e)
        }
    });
}

function update_calc_cart() {
    
    var url = base_url + 'home/cart/calcs/full';
    var product_total = $('#product_total');
    var ship = $('#shipping'); 
    var tax = $('#tax');
    var grand = $('#grand');
    var total_discount = $('#total_discount');
    var total_cashback_discount = $('#total_cashback_discount');
    var product_sub_total = $('#product_sub_total');
    var product_coupon_price = $('#coupon_price');
    var promocode_total_discount_price = $('#promocode_total_discount_price');
    var country = $(".same_delivery").is(":checked") ? $("#delivery_country").val() :$("#country").val();
    var insurance_add = $("#insurance-chk").is(":checked");

    if(country != "")
        url = url + "?insurance="+country;
    if(country != "" && insurance_add)
        url = url + "&add_insurance=yes";
    if(country == "" && insurance_add)
        url = url + "?add_insurance=yes";
    $.ajax({
        url: url,
        beforeSend: function() {
            $('.ajax-loader').css("visibility", "visible");
            product_total.html('...');
            ship.html('...');
            tax.html('...');
            grand.html('...');
            total_discount.html('...');
            total_cashback_discount.html('...');
            product_sub_total.html('...');
            product_coupon_price.html('...');
            promocode_total_discount_price.html('...');
        },
        success: function(data) {
            $('.ajax-loader').css("visibility", "hidden");
            var res = data.split('-');
            product_total.html(res[0]).fadeIn();
            ship.html(res[1]).fadeIn();
            tax.html(res[2]).fadeIn();
            grand.html(res[3]).fadeIn();
            total_discount.html(res[5]).fadeIn();
            total_cashback_discount.html(res[6]).fadeIn();
            product_sub_total.html(res[7]).fadeIn();
            product_coupon_price.html(res[8]).fadeIn();
            promocode_total_discount_price.html(res[9]).fadeIn();
            $("#insurance").html(res[10]).fadeIn();
            $("#insurance-chk").val(res[10])
            console.log(res,'-------- res');
            //other_action();
        },
        error: function(e) {
            console.log(e)
        }
    });
}
$('body').on('click', '.promocode_btn', function() {
    var txt = $(this).html();
    var code = $('.promo_code').val();
    $('#coup_frm').val(code);
    var form = $('#coupon_set');
    var formdata = false;
    if (window.FormData) {
        formdata = new FormData(form[0]);
    }
    var datas = formdata ? formdata : form.serialize();
    $.ajax({
        url: base_url + 'home/promocode_check/',
        type: 'POST', // form submit method get/post
        dataType: 'html', // request type html/json/xml
        data: datas, // serialize form data 
        cache: false,
        contentType: false,
        processData: false,
        beforeSend: function() {
            $('.ajax-loader').css("visibility", "visible");
            $(this).html(applying);
        },
        success: function(result) {
            $('.ajax-loader').css("visibility", "hidden");
            if (result == 'nope') {
                notify(promocode_not_valid, 'warning', 'bottom', 'right');
            } else {

                notify(promocode_discount_successful, 'success', 'bottom', 'right');
                setTimeout(function() { window.location.reload(); }, 2000);
            }
        }
    });
});


function set_cart_map() {
    //$('#maps').animate({ height: '400px' }, 'easeInOutCubic', function(){});
    initialize();
    var address = [];
    //$('#pos').show('fast');
    //$('#lnlat').show('fast');
    $('.address').each(function(index, value) {
        if (this.value !== '') {
            address.push(this.value);
        }
    });
    address = address.toString();
    deleteMarkers();
    geocoder.geocode({ 'address': address }, function(results, status) {
        if (status == google.maps.GeocoderStatus.OK) {
            if ($('#langlat').val().indexOf(',') == -1 || $('#first').val() == 'no') {
                deleteMarkers();
                var location = results[0].geometry.location;
                var marker = addMarker(location);
                map.setCenter(location);
                $('#langlat').val(location);
            } else if ($('#langlat').val().indexOf(',') >= 0) {
                deleteMarkers();
                var loca = $('#langlat').val();
                loca = loca.split(',');
                var lat = loca[0].replace('(', '');
                var lon = loca[1].replace(')', '');
                var marker = addMarker(new google.maps.LatLng(lat, lon));
                map.setCenter(new google.maps.LatLng(lat, lon));
            }
            if ($('#first').val() == 'yes') {
                $('#first').val('no');
            }
            // Add dragging event listeners.
            google.maps.event.addListener(marker, 'drag', function() {
                $('#langlat').val(marker.getPosition());
            });
        }
    });
}

var geocoder;
var map;
var markers = [];

function initialize() {
    geocoder = new google.maps.Geocoder();
    var latlng = new google.maps.LatLng(-34.397, 150.644);
    var mapOptions = {
        zoom: 14,
        center: latlng
    }
    map = new google.maps.Map(document.getElementById('map-canvas'), mapOptions);
    google.maps.event.addListener(map, 'click', function(event) {
        deleteMarkers();
        var marker = addMarker(event.latLng);
        $('#langlat').val(event.latLng);
        // Add dragging event listeners.
        google.maps.event.addListener(marker, 'drag', function() {
            $('#langlat').val(marker.getPosition());
        });

    });
}


/*
    var address = [];
    $('#maps').show('fast');
    $('#pos').show('fast');
    $('#lnlat').show('fast');
    $(".address").each(
    address.push(this.value);
    );
*/

$('body').on('blur', '.address', function() {
    if (!$(this).is('select')) {
        set_cart_map();
    }
});

$('body').on('change', '.address', function() {
    if ($(this).is('select')) {
        set_cart_map();
    }
});

// Add a marker to the map and push to the array.
function addMarker(location) {
    var image = {
        url: base_url + 'uploads/others/marker.png',
        size: new google.maps.Size(40, 60),
        origin: new google.maps.Point(0, 0),
        anchor: new google.maps.Point(20, 62)
    };

    var shape = {
        coords: [1, 5, 15, 62, 62, 62, 15, 5, 1],
        type: 'poly'
    };

    var marker = new google.maps.Marker({
        position: location,
        map: map,
        draggable: true,
        icon: image,
        shape: shape,
        animation: google.maps.Animation.DROP
    });
    markers.push(marker);
    return marker;
}

// Deletes all markers in the array by removing references to them.
function deleteMarkers() {
    clearMarkers();
    markers = [];
}

// Sets the map on all markers in the array.
function setAllMap(map) {
    for (var i = 0; i < markers.length; i++) {
        markers[i].setMap(map);
    }
}

// Removes the markers from the map, but keeps them in the array.
function clearMarkers() {
    setAllMap(null);
}
//google.maps.event.addDomListener(window, 'load', initialize);