jQuery("document").ready(function($) {

    function storySlideShow(container){
        container.find(".ctl_slideshow .slides").not('.slick-initialized').each(function(){
        var autoplaySpeed=parseInt($(this).data('animationspeed'));
        var slideshow=$(this).data('slideshow');

        $(this).not('.slick-initialized').slick({
            dots: false,
            infinite: false,
            arrows:true,
            mobileFirst:true,
            pauseOnHover:true,
            slidesToShow:1,
            autoplay:slideshow,
            autoplaySpeed:autoplaySpeed,
             adaptiveHeight:true
          });      
        }); 
    }

    $(".cool-timeline-horizontal.ht-design-6,.cool-timeline-horizontal.ht-design-5").each(function(e) {
            var thisS =$(this);

            let nexticon=thisS.hasClass('ht-design-6') ? '<i class="fa fa-chevron-right" aria-hidden="true"></i>' : '<i class="far fa-arrow-alt-circle-right"></i>';
            let previcon=thisS.hasClass('ht-design-6') ? '<i class="fa fa-chevron-left" aria-hidden="true"></i>' : '<i class="far fa-arrow-alt-circle-left"></i>';
            var sliderContent= "#" + thisS.attr("date-slider"),
                sliderNav = "#" + thisS.attr("data-nav"),
                rtl = thisS.attr("data-rtl"),
                items= parseInt(thisS.attr("data-items")),
                autoplay = thisS.attr("data-autoplay"),
                autoplaySettings=autoplay=="true"?true:false,
                rtlSettings=rtl=="true"?true:false,
                speed = parseInt(thisS.attr("data-autoplay-speed")),
                lineFilling=thisS.attr("data-line-filling");
                thisS.siblings(".clt_preloader").hide();
                thisS.css("opacity",1);
                let showStories=parseInt(thisS.attr("data-items"));
                let totalStories=$(sliderNav).find("li").length,
                startOn = parseInt(thisS.attr("data-start-on")) >= totalStories ? totalStories-1 : parseInt(thisS.attr("data-start-on"));
            var settingsObj={
                slidesToShow: 1,
                slidesToScroll: 1,
                autoplaySpeed:speed,
                rtl:rtlSettings,
                asNavFor:sliderNav,
                dots:false,
                arrows:true,
                //  autoplay: a,
                infinite:false,
                initialSlide:startOn,
                adaptiveHeight:true,
                responsive: [{
                    breakpoint: 768,
                    settings: {
                        centerPadding: "10px",
                        slidesToShow: 1
                    }
                }, {
                    breakpoint: 480,
                    settings: {
                        centerPadding: "10px",
                        slidesToShow: 1
                    }
                }]
            }

          if(totalStories!==undefined && totalStories<=3){
                settingsObj.arrows=true;
            }else{
               settingsObj.arrows=false; 
            };

       $(sliderContent).not('.slick-initialized').slick(settingsObj);
        
        $(sliderNav).not('.slick-initialized').slick({
            slidesToShow: showStories,
            slidesToScroll: 1,
            autoplaySpeed:speed,
            asNavFor:sliderContent,
            dots:false,
            infinite:false,
            centerMode:true,
            rtl:rtlSettings,
            autoplay:autoplaySettings,
            nextArrow: `<button type="button" class="ctl-slick-next ctl-flat-left">${nexticon}</button>`,
            prevArrow: `<button type="button" class="ctl-slick-prev ctl-flat-right">${previcon}</button>`,
            focusOnSelect:true,
            adaptiveHeight:true,
            initialSlide:startOn,
            responsive: [{
                breakpoint: 768,
                settings: {
                    arrows:true,
                    centerPadding: "10px",
                    slidesToShow: 1
                }
            }, {
                breakpoint: 480,
                settings: {
                    arrows:true,
                    centerPadding: "10px",
                    slidesToShow: 1
                }
            }]
        });
        
        // enable story slideshow
        storySlideShow(thisS);

    })
});