window.addEventListener('DOMContentLoaded', function() {
  var swiper = new Swiper('.home-banner--swiper', {
      slidesPerView: 4,
      loop: true,
      spaceBetween: 30,
      pagination: {
        el: '.swiper-pagination',
        clickable: true,
      },
      breakpoints:{
        1024:{
          slidesPerView: 3,
        },
        800:{
          slidesPerView: 2,
        },
        560:{
          slidesPerView: 1,
        },
      },
    });
  var swiper = new Swiper('.best-sellers--swiper', {
      slidesPerView: 4,
      loop: true,
      spaceBetween: 30,
      pagination: {
        el: '.swiper-pagination',
        clickable: true,
      },
      navigation: {
        nextEl: '.swiper-button-next',
        prevEl: '.swiper-button-prev',
      },
      breakpoints:{
        1024:{
          slidesPerView: 3,
        },
        800:{
          slidesPerView: 2,
        },
        560:{
          slidesPerView: 1,
        },
      },
    });

});

var resizeTimer = null;
jQuery(window).resize(function (){
  clearTimeout(resizeTimer);
   resizeTimer= setTimeout(function(){
    
   }, 10);
});//END OF WINDOW RESIZE
console.log("ready!!");




