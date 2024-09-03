jQuery(document).ready(function(){
    function year_swiper(e){
        total_year_navigation=jQuery('#'+e+' li').length;
        jQuery('#'+e).slick({
            dots: false,
            infinite: false,
            nextArrow:'<button type="button" class="ctl-slick-next ctl-flat-left"><i class="fa fa-chevron-right" aria-hidden="true"></i></button>', 
            prevArrow:'<button type="button" class="ctl-slick-prev ctl-flat-right"><i class="fa fa-chevron-left" aria-hidden="true"></i></button>',
            mobileFirst:true,
            slidesToShow:3,
            touchMove:false,
            responsive: [{
                breakpoint: 1040,
                settings: {
                    slidesToShow: 9
                }
            }, {
                breakpoint: 768,
                settings: {
                    centerPadding: "10px",
                    slidesToShow: 6
                }
            }, {
                breakpoint: 560,
                settings: {
                    centerPadding: "10px",
                    slidesToShow: 5
                }
            }, {
                breakpoint: 480,
                settings: {
                    centerPadding: "10px",
                    slidesToShow: 4
                }
            }]
        });      
    };
    function update_year(e,id){
        var thisS=jQuery(id).closest('.cool-timeline-horizontal');
        thisS.find('.cth-year-filters').each(function(key,value){
            let years=parseInt(jQuery(value).attr('data-term-slug'));
            if(years == e){
                thisS.find('.year-nav-wrp li').removeClass('active');
                jQuery(value).addClass('active');
                yearnav=thisS.find('.year-nav-wrp .ctl_h_yearNav li').length,
                main_wrap=jQuery(thisS).find('.ctl_h_yearNav'),
                total_active_li=main_wrap.find('li.slick-active').length-1;
                if(yearnav > total_active_li){
                    let current_li=jQuery(value).closest('li');
                    if(!current_li.hasClass('slick-active')){
                        let current_li_index=parseInt(current_li.attr('data-slick-index'));
                        if(current_li_index >= total_active_li){
                            current_li_index=current_li_index-total_active_li;
                        }else{
                            current_li_index=0;
                        }
                        jQuery(main_wrap).slick( 'slickGoTo',current_li_index );
                    }
                }
            }
           });
    }

    jQuery('.cool-timeline-horizontal').each(function(){
        let thisS =jQuery(this),
        items=parseInt(thisS.attr('data-items')),
        sliderNav = "#" + thisS.attr("data-nav"),
        startOn=parseInt(thisS.attr('data-start-on'))+1,
        totalsslide=jQuery(sliderNav+' li').length,
        year_navigation=jQuery(thisS.find('.year-nav-wrp .ctl_h_yearNav'))[0];
        if(isNaN(startOn)){
            startOn=0;
        }
        if(year_navigation != undefined){
          let   year_navigation_id=year_navigation.id
          year_swiper(year_navigation_id);
        }
        if(items > 4){
            thisS.find('li .timeline-year').css('left','0px');
        };
        if(startOn > totalsslide){
            startOn=totalsslide-1;
        }
        let firstyear=thisS.find(sliderNav+' li:nth-child('+startOn+')').data('year');
        update_year(firstyear,sliderNav)

        jQuery(sliderNav).on('afterChange', function(event, slick, currentSlide, nextSlide){
            let active_year=parseInt(jQuery(thisS.find('.year-nav-wrp .ctl_h_yearNav li.active a')).attr('data-term-slug'));
            let active_slide='';
            if(thisS.hasClass('ht-design-7')){
                active_slide=jQuery(sliderNav+' li[data-term-slug]')[currentSlide];
            }else{
                active_slide=jQuery(sliderNav+' li[data-date]')[currentSlide];
            }
            let current_year=parseInt(jQuery(active_slide).attr('data-year'));
            if(active_year != current_year){
               update_year(current_year,sliderNav)  
            }
        })
    });

    jQuery(document).on('click','.cth-year-filters',function(e) {
        e.preventDefault();
        let year = jQuery(this).attr('data-term-slug'),
        id = jQuery(this).closest('.year-nav-wrp'),
        lineFilling = jQuery(this).closest('.cool-timeline-horizontal').attr('data-line-filling'),
        s_id = id.attr('data-id'),
        index='',
        show_items=parseInt(jQuery('#ctl-horizontal-slider-'+s_id).attr('data-items'));
        jQuery('[data-id~='+s_id+'].year-nav-wrp li').each(function(key, value){
                 jQuery(value).removeClass('active');
        });
        jQuery(this).addClass('active');
        let totalstories=jQuery('#nav-slider-'+s_id+'.ctl_h_nav li .timeline-year, #nav-slider-'+s_id+'.ctl_minimal_cont li.ht-dates-design-7').length;
        jQuery('#nav-slider-'+s_id+'.ctl_h_nav li .timeline-year, #nav-slider-'+s_id+'.ctl_minimal_cont li.ht-dates-design-7 .timeline-year').each(function(key,value){
            let targetYear = jQuery(value).attr('data-section-title');
            if(year == targetYear){
                let targetLi=jQuery(value).closest('li.slick-slide')[0];
                index=jQuery(targetLi).attr('data-slick-index');
            }
        })

        if(jQuery('#ctl-horizontal-slider-'+s_id).hasClass('ht-design-7') && show_items > 1){
            let count=totalstories-index;
            if(count < show_items){
                index=totalstories-show_items;
            };
        }
        jQuery('.slick-initialized#nav-slider-'+s_id).slick( 'slickGoTo', parseInt( index ) );
        jQuery('.slick-initialized#ctl-h-slider-'+s_id).slick( 'slickGoTo', parseInt( index ) );

        if(lineFilling == 'true'){
            centerLIneUpdate({'id': '.slick-initialized#nav-slider-'+s_id,'pos': parseInt(index)});
        }
    });
    const centerLIneUpdate = (e) => {
        let activeslide=e.pos;
        jQuery(e.id).find('li.slick-slide').removeClass('pi');
        if(activeslide != undefined){
            for(let i=0; i < activeslide; i++){
                let prevAll=jQuery(e.id).find('li.slick-slide')[i];
                    jQuery(prevAll).addClass('pi');
            }
        }
    };
});