jQuery('document').ready(function($){

var nextBtn='<div class="clt_h_nav_btn ctl-slick-next"><i class="fa fa-angle-right"></i></div>';
var preBtn='<div class="clt_h_nav_btn ctl-slick-prev"><i class="fa fa-angle-left"></i></div>';
$('.cool-timeline-horizontal').each(function(){
    var slidetoshow=$(this).data('items');
    var autoplay=$(this).data('autoplay');
    var startOn=$(this).data('start-on');
    var speed = parseInt($(this).data('autoplay-speed'));

    $(this).siblings(".clt_preloader").hide();
    $(this).css("opacity",1);

    let totalslide=$(this).find('ul.ctl_minimal_cont li.ht-dates-design-7').length;
    let lastshow_items=(totalslide - startOn);

    if(lastshow_items < slidetoshow){
     startOn=totalslide-slidetoshow;
    }

   $(this).find('ul.ctl_minimal_cont').not('.slick-initialized').slick({
               dots: false,
               infinite: false,
               slidesToShow:slidetoshow,
               autoplay: autoplay,
               autoplaySpeed:speed,
               adaptiveHeight:true,
               initialSlide:startOn,
               slidesToScroll:1,
               nextArrow:nextBtn,
               prevArrow:preBtn,
               responsive: [
                 {
                   breakpoint: 600,
                   settings: {
                     slidesToShow: 2,
                     slidesToScroll: 1
                   }
                 },
                 {
                   breakpoint: 480,
                   settings: {
                     slidesToShow: 1,
                     slidesToScroll: 1
                   }
                 }
               ]
               });

           });

        function initialize(){
        $(".ctl_popup_slick .slides").not('.slick-initialized').each(function(){
          var autoplaySpeed=parseInt($(this).data('animationspeed'));
          var slideshow=$(this).data('slideshow');
          var animation=$(this).data('animation');
       
          $(this).slick({
              dots: false,
              infinite: false,
              slidesToShow:1,
              autoplay:slideshow,
              autoplaySpeed:autoplaySpeed,
               adaptiveHeight: true
            });      
          }); 
        }
        function unInitialize(){
          $(".ctl_popup_slick .slides").each(function(){
            $(this).slick('unslick');      
          }); 
      
          }
});
