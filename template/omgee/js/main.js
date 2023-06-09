$(function() {

    "use strict";

    /*---------------------------
       Commons Variables
    ------------------------------ */
    var $window = $(window),
        $body = $("body");

    /*---------------------------
       Menu Fixed On Scroll Active
    ------------------------------ */
    $(window).scroll(function() {
        var window_top = $(window).scrollTop() + 1;
        if (window_top > 250) {
            $(".sticky-nav").addClass("menu_fixed animated fadeInDown");
        } else {
            $(".sticky-nav").removeClass("menu_fixed animated fadeInDown");
        }
    });

    /*---------------------------
       Menu menu-content
    ------------------------------ */

    $(".header-menu-vertical .menu-title").on("click", function(event) {
        $(".header-menu-vertical .menu-content").slideToggle(500);
    });

    $(".menu-content").each(function() {
        var $ul = $(this),
            $lis = $ul.find(".menu-item:gt(7)"),
            isExpanded = $ul.hasClass("expanded");
        $lis[isExpanded ? "show" : "hide"]();

        if ($lis.length > 0) {
            $ul.append(
                $(
                    '<li class="expand">' +
                    (isExpanded ? '<a href="javascript:;"><span><i class="ion-android-remove"></i>Close Categories</span></a>' : '<a href="javascript:;"><span><i class="ion-android-add"></i>More Categories</span></a>') +
                    "</li>"
                ).click(function(event) {
                    var isExpanded = $ul.hasClass("expanded");
                    event.preventDefault();
                    $(this).html(isExpanded ? '<a href="javascript:;"><span><i class="ion-android-add"></i>More Categories</span></a>' : '<a href="javascript:;"><span><i class="ion-android-remove"></i>Close Categories</span></a>');
                    $ul.toggleClass("expanded");
                    $lis.toggle(300);
                })
            );
        }
    });

    /*---------------------------------
        Off Canvas Function
    -----------------------------------*/
    (function() {
        var $offCanvasToggle = $(".offcanvas-toggle"),
            $offCanvas = $(".offcanvas"),
            $offCanvasOverlay = $(".offcanvas-overlay"),
            $mobileMenuToggle = $(".mobile-menu-toggle");
        $offCanvasToggle.on("click", function(e) {
            e.preventDefault();
            var $this = $(this),
                $target = $this.attr("href");
            $body.addClass("offcanvas-open");
            $($target).addClass("offcanvas-open");
            $offCanvasOverlay.fadeIn();
            if ($this.parent().hasClass("mobile-menu-toggle")) {
                $this.addClass("close");
            }
        });
        $(".offcanvas-close, .offcanvas-overlay").on("click", function(e) {
            e.preventDefault();
            $body.removeClass("offcanvas-open");
            $offCanvas.removeClass("offcanvas-open");
            $offCanvasOverlay.fadeOut();
            $mobileMenuToggle.find("a").removeClass("close");
        });
    })();

    /*----------------------------------
        Off Canvas Menu
    -----------------------------------*/
    function mobileOffCanvasMenu() {
        var $offCanvasNav = $(".offcanvas-menu, .overlay-menu"),
            $offCanvasNavSubMenu = $offCanvasNav.find(".sub-menu");

        /*Add Toggle Button With Off Canvas Sub Menu*/
        $offCanvasNavSubMenu.parent().prepend('<span class="menu-expand"></span>');

        /*Category Sub Menu Toggle*/
        $offCanvasNav.on("click", "li a, .menu-expand", function(e) {
            var $this = $(this);
            if ($this.attr("href") === "#" || $this.hasClass("menu-expand")) {
                e.preventDefault();
                if ($this.siblings("ul:visible").length) {
                    $this.parent("li").removeClass("active");
                    $this.siblings("ul").slideUp();
                    $this.parent("li").find("li").removeClass("active");
                    $this.parent("li").find("ul:visible").slideUp();
                } else {
                    $this.parent("li").addClass("active");
                    $this.closest("li").siblings("li").removeClass("active").find("li").removeClass("active");
                    $this.closest("li").siblings("li").find("ul:visible").slideUp();
                    $this.siblings("ul").slideDown();
                }
            }
        });
    }
    mobileOffCanvasMenu();

    /*------------------------------
            Hero Slider
    -----------------------------------*/

    var swiper = new Swiper(".hero-slider", {
        spaceBetween: 30,
        speed: 750,
        effect: "fade",
        loop: true,
        autoplay: {
            delay: 7000,
            disableOnInteraction: false,
        },
        pagination: {
            el: ".swiper-pagination",
            clickable: true,
        },
    });

    /*------------------------------
            Category Slider
    -----------------------------------*/
    var swiper = new Swiper(".category-slider", {
        slidesPerView: 5,
        spaceBetween: 30,
        speed: 750,
        navigation: {
            nextEl: ".swiper-button-next",
            prevEl: ".swiper-button-prev",
        },
        breakpoints: {
            0: {
                slidesPerView: 1,
            },
            478: {
                slidesPerView: 2,
            },
            576: {
                slidesPerView: 2,
            },
            768: {
                slidesPerView: 3,
            },
            1024: {
                slidesPerView: 4,
            },
            1200: {
                slidesPerView: 5,
            },
        },
    });

    /*------------------------------
            Feature Slider
    -----------------------------------*/

    var swiper = new Swiper(".feature-slider", {
        slidesPerView: 5,
        spaceBetween: 0,
        navigation: {
            nextEl: ".swiper-button-next",
            prevEl: ".swiper-button-prev",
        },
        breakpoints: {
            0: {
                slidesPerView: 1,
            },
            478: {
                slidesPerView: 2,
            },
            576: {
                slidesPerView: 2,
            },
            768: {
                slidesPerView: 3,
            },
            1024: {
                slidesPerView: 4,
            },
            1200: {
                slidesPerView: 5,
            },
        },
    });

    /*------------------------------
            Feature Slider Two
    -----------------------------------*/

    var swiper = new Swiper(".feature-slider-two", {
        slidesPerView: 6,
        spaceBetween: 0,
        navigation: {
            nextEl: ".swiper-button-next",
            prevEl: ".swiper-button-prev",
        },
        breakpoints: {
            0: {
                slidesPerView: 1,
            },
            478: {
                slidesPerView: 2,
            },
            576: {
                slidesPerView: 2,
            },
            768: {
                slidesPerView: 3,
            },
            1024: {
                slidesPerView: 4,
            },
            1200: {
                slidesPerView: 5,
            },
            1300: {
                slidesPerView: 6,
            },
        },
    });

    /*------------------------------
            Hot Deal Slider
    -----------------------------------*/
    var swiper = new Swiper(".deal-slider", {
        slidesPerView: 2,
        spaceBetween: 30,
        speed: 750,
        navigation: {
            nextEl: ".swiper-button-next",
            prevEl: ".swiper-button-prev",
        },
        breakpoints: {
            0: {
                slidesPerView: 1,
            },
            1024: {
                slidesPerView: 1,
            },
            1200: {
                slidesPerView: 2,
            },
        },
    });

    /*------------------------------
            Feature-2 Slider
    -----------------------------------*/

    var swiper = new Swiper(".feature-slider-2", {
        slidesPerView: 4,
        spaceBetween: 0,
        navigation: {
            nextEl: ".swiper-button-next",
            prevEl: ".swiper-button-prev",
        },
        breakpoints: {
            0: {
                slidesPerView: 1,
            },
            478: {
                slidesPerView: 2,
            },
            576: {
                slidesPerView: 2,
            },
            768: {
                slidesPerView: 2,
            },
            1024: {
                slidesPerView: 2,
            },
            1200: {
                slidesPerView: 4,
            },
        },
    });

    /*------------------------------
            Brand Slider
    -----------------------------------*/

    var swiper = new Swiper(".brand-slider", {
        slidesPerView: 5,
        spaceBetween: 30,
        speed: 750,
        navigation: {
            nextEl: ".swiper-button-next",
            prevEl: ".swiper-button-prev",
        },
        breakpoints: {
            0: {
                slidesPerView: 1,
            },
            478: {
                slidesPerView: 1,
            },
            576: {
                slidesPerView: 2,
            },
            768: {
                slidesPerView: 3,
            },
            1024: {
                slidesPerView: 4,
            },
            1200: {
                slidesPerView: 5,
            },
        },
    });

    /*------------------------------
            Recent Slider
    -----------------------------------*/

    var swiper = new Swiper(".recent-slider", {
        slidesPerView: 4,
        spaceBetween: 30,
        speed: 750,
        navigation: {
            nextEl: ".swiper-button-next",
            prevEl: ".swiper-button-prev",
        },
        breakpoints: {
            0: {
                slidesPerView: 1,
            },
            478: {
                slidesPerView: 1,
            },
            576: {
                slidesPerView: 1,
            },
            768: {
                slidesPerView: 2,
            },
            1024: {
                slidesPerView: 3,
            },
            1200: {
                slidesPerView: 4,
            },
        },
    });

    /*------------------------------
            Recent Slider Two
    -----------------------------------*/
    var swiper = new Swiper(".recent-slider-two", {
        slidesPerView: 3,
        spaceBetween: 0,
        navigation: {
            nextEl: ".swiper-button-next",
            prevEl: ".swiper-button-prev",
        },
        breakpoints: {
            0: {
                slidesPerView: 1,
            },
            478: {
                slidesPerView: 1,
            },
            576: {
                slidesPerView: 1,
            },
            768: {
                slidesPerView: 1,
            },
            992: {
                slidesPerView: 2,
            },
            1024: {
                slidesPerView: 2,
            },
            1200: {
                slidesPerView: 3,
            },
        },
    });

    /*------------------------------
            Single Product Slider
    -----------------------------------*/
    var swiper = new Swiper(".single-product-slider", {
        slidesPerView: 4,
        spaceBetween: 20,
        navigation: {
            nextEl: ".swiper-button-next",
            prevEl: ".swiper-button-prev",
        },
        breakpoints: {
            0: {
                slidesPerView: 1,
            },
            478: {
                slidesPerView: 1,
            },
            576: {
                slidesPerView: 2,
            },
            768: {
                slidesPerView: 3,
            },
            992: {
                slidesPerView: 3,
            },
            1024: {
                slidesPerView: 4,
            },
            1200: {
                slidesPerView: 4,
            },
        },
    });

    /*----------------------------  
        All Category toggle  
     ------------------------------*/

    $(".category-toggle").click(function() {
        $(".category-menu").slideToggle("slow");
    });
    $(".menu-item-has-children-1").click(function() {
        $(".category-mega-menu-1").slideToggle("slow");
    });
    $(".menu-item-has-children-2").click(function() {
        $(".category-mega-menu-2").slideToggle("slow");
    });
    $(".menu-item-has-children-3").click(function() {
        $(".category-mega-menu-3").slideToggle("slow");
    });
    $(".menu-item-has-children-4").click(function() {
        $(".category-mega-menu-4").slideToggle("slow");
    });
    $(".menu-item-has-children-5").click(function() {
        $(".category-mega-menu-5").slideToggle("slow");
    });
    $(".menu-item-has-children-6").click(function() {
        $(".category-mega-menu-6").slideToggle("slow");
    });

    /*-----------------------------  
              Category more toggle  
        -------------------------------*/

    $(".category-menu li.hidden").hide();
    $("#more-btn").on("click", function(e) {
        e.preventDefault();
        $(".category-menu li.hidden").toggle(500);
        var htmlAfter = '<i class="ion-ios-minus-empty" aria-hidden="true"></i> Less Categories';
        var htmlBefore = '<i class="ion-ios-plus-empty" aria-hidden="true"></i> More Categories';

        if ($(this).html() == htmlBefore) {
            $(this).html(htmlAfter);
        } else {
            $(this).html(htmlBefore);
        }
    });

    /*---------------------
        Countdown
    --------------------- */
    $("[data-countdown]").each(function() {
        var $this = $(this),
            finalDate = $(this).data("countdown");
        $this.countdown(finalDate, function(event) {
            $this.html(event.strftime('<span class="cdown day">%-D <p>Days</p></span> <span class="cdown hour">%-H <p>Hours</p></span> <span class="cdown minutes">%M <p>Mins</p></span> <span class="cdown second">%S <p>Sec</p></span>'));
        });
    });

    /*---------------------
        Scroll Up
    --------------------- */
    $.scrollUp({
        scrollText: '<i class="ion-android-arrow-up"></i>',
        easingType: "linear",
        scrollSpeed: 900,
        animation: "fade",
    });



    /*--------------------------
            Product Zoom
    ---------------------------- */

    if ($(window).width() > 768) {
        $(".zoompro").elevateZoom({
            gallery: "gallery",
            galleryActiveClass: "active",
            scrollZoom: false,
            cursor: "crosshair",
            easing: true,
            responsive: true,
            zoomWindowOffetx: 70,
            zoomWindowWidth: 500,
            zoomWindowHeight: 400,
            zoomLens: true,
            lensSize: 500,
    
        });
     }

    

    /*------------------------------
            Single Product Slider
    -----------------------------------*/
    var swiper = new Swiper(".product-dec-slider-2", {
        slidesPerView: 4,
        spaceBetween: 10,
        breakpoints: {
            0: {
                slidesPerView: 4,
            },
            478: {
                slidesPerView: 4,
            },
            576: {
                slidesPerView: 4,
            },
            768: {
                slidesPerView: 4,
            },
            992: {
                slidesPerView: 4,
            },
            1024: {
                slidesPerView: 4,
            },
            1200: {
                slidesPerView: 4,
            },
        },
    });

    /*------------------------------
            Single Product Slider
    -----------------------------------*/
    var swiper = new Swiper(".product-dec-slider-3", {
        slidesPerView: 4,
        spaceBetween: 10,
        direction: 'vertical',
        breakpoints: {
            0: {
                slidesPerView: 4,
            },
            478: {
                slidesPerView: 4,
            },
            576: {
                slidesPerView: 4,
            },
            768: {
                slidesPerView: 4,
            },
            992: {
                slidesPerView: 4,
            },
            1024: {
                slidesPerView: 4,
            },
            1200: {
                slidesPerView: 4,
            },
        },
    });



    /*-----------------------------
        Blog Gallery Slider 
    -------------------------------- */
    var swiper = new Swiper(".blog-gallery", {
        slidesPerView: 1,
        spaceBetween: 0,
        navigation: {
            nextEl: ".swiper-button-next",
            prevEl: ".swiper-button-prev",
        },
    });

    /*-------------------------------
        Create an account toggle
    ---------------------------------*/
    $(".checkout-toggle2").on("click", function() {
        $(".open-toggle2").slideToggle(1000);
    });

    $(".checkout-toggle").on("click", function() {
        $(".open-toggle").slideToggle(1000);
    });

    /*---------------------------
        Quick view Slider 
    ------------------------------ */
    var galleryThumbs = new Swiper('.gallery-thumbs', {
        spaceBetween: 10,
        slidesPerView: 4,
        freeMode: true,
        watchSlidesVisibility: true,
        watchSlidesProgress: true,
    });
    var galleryTop = new Swiper('.gallery-top', {
        spaceBetween: 0,
        navigation: {
            nextEl: '.swiper-button-next',
            prevEl: '.swiper-button-prev',
        },
        thumbs: {
            swiper: galleryThumbs
        }
    });

    //
    var prevScroll = 0,
        curDir = 'down',
        prevDir = 'up';

    $(window).scroll(function() {
        if ($(this).scrollTop() >= prevScroll) {
            curDir = 'down';
            if (curDir != prevDir) {
                $('.fixedscreen').stop();
                $('.fixedscreen').addClass('translate_100');
                prevDir = curDir;
            }
        } else {
            curDir = 'up';
            if (curDir != prevDir) {
                $('.fixedscreen').stop();
                $('.fixedscreen').removeClass('translate_100');
                prevDir = curDir;
            }
        }
        prevScroll = $(this).scrollTop();
    });

    $.fn.isInViewport = function() {
        var elementTop = $(this).offset().top;
        var elementBottom = elementTop + $(this).outerHeight();

        var viewportTop = $(window).scrollTop();
        var viewportBottom = viewportTop + $(window).height();

        return elementBottom > viewportTop && elementTop < viewportBottom;
    };

    $(window).on('resize scroll', function() {

        if ($('.footer-bottom').isInViewport()) {
            $('.fixedscreen').addClass('notfixed');


        } else {
            $('.fixedscreen').removeClass('notfixed');

        }
    });

});