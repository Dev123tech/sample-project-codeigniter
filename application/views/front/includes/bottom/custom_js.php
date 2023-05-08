
<script>
  navigator.geolocation.getCurrentPosition(success, error);

        function success(position) {
            console.log(position.coords.latitude)
            console.log(position.coords.longitude)

            var GEOCODING = 'https://maps.googleapis.com/maps/api/geocode/json?latlng=' + position.coords.latitude + '%2C' + position.coords.longitude + '&language=en';

            $.getJSON(GEOCODING).done(function(location) {
                console.log(location)
            })

        }

        function error(err) {
            console.log(err)
        }
</script>

<script type="text/javascript">
function password_hideshow() 
{
    var x = document.getElementById("password");
    if (x.type === "password") {
        $('.fa-eye').addClass('fa-eye-slash');
        x.type = "text";
    } else {
        $('.fa-eye').removeClass('fa-eye-slash');
        x.type = "password";
    }
}
function rpassword_hideshow() 
{
    var x = document.getElementById("password1");
    if (x.type === "password") {
        $('.password1').addClass('fa-eye-slash');
        x.type = "text";
    } else {
        $('.password1').removeClass('fa-eye-slash');
        x.type = "password";
    }
}
function rcpassword_hideshow() 
{
    var x = document.getElementById("password2");
    if (x.type === "password") {
        $('.password2').addClass('fa-eye-slash');
        x.type = "text";
    } else {
        $('.password2').removeClass('fa-eye-slash');
        x.type = "password";
    }
}
$('.set_langs').on('click',function(){
    var lang_url = $(this).data('href');                                    
    $.ajax({url: lang_url, success: function(result){
        location.reload();
    }});
});
function getLocation() 
{
  if (navigator.geolocation) {
    navigator.geolocation.getCurrentPosition(showPosition);
  } else { 
    x.innerHTML = "Geolocation is not supported by this browser.";
  }
}

function showPosition(position) 
{
    console.log(position.coords.latitude);
}
getLocation();
$('.set_currency').on('click',function()
{
    var lang_url = $(this).data('href');                                    
    var currencyid = $(this).attr('currencyid');                                   
    $.ajax({
        url: lang_url, 
        success: function(result)
        {
            var originalURL = "<?php echo CURRENT_URL; ?>"+'?lang='+currencyid
            var alteredURL = removeParam("lang", originalURL);
            window.location.href=alteredURL+'?lang='+currencyid;
        }
    });
});
function removeParam(key, sourceURL) {
    var rtn = sourceURL.split("?")[0],
        param,
        params_arr = [],
        queryString = (sourceURL.indexOf("?") !== -1) ? sourceURL.split("?")[1] : "";
    if (queryString !== "") {
        params_arr = queryString.split("&");
        for (var i = params_arr.length - 1; i >= 0; i -= 1) {
            param = params_arr[i].split("=")[0];
            if (param === key) {
                params_arr.splice(i, 1);
            }
        }
        rtn = rtn + "?" + params_arr.join("&");
    }
    return rtn;
}
$('.top-bar-right').load('<?php echo base_url(); ?>home/top_bar_right');


$(".enterclick").keyup(function(event) 
{
    if (event.keyCode === 13) 
    {
        $(".entersubmit").click();
    }
});
$(".enterclicklogin").keyup(function(event) 
{
    if (event.keyCode === 13) 
    {
        $(".entersubmitlogin").click();
    }
});

</script>