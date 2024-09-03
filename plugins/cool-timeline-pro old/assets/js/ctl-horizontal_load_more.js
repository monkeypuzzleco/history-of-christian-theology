jQuery(document).ready(function(){

    window.ctl_ajax_loading=false;

    // slider Popup Custom Html
    const customLightboxHTML = `<div id="glightbox-body" class="glightbox-container">
            <div class="gloader visible"></div>
            <div class="goverlay"></div>
            <div class="gcontainer ctl_glightbox_container">
            <div id="glightbox-slider" class="gslider"></div>
            <button class="gnext gbtn" tabindex="0" aria-label="Next" data-customattribute="example">{nextSVG}</button>
            <button class="gprev gbtn" tabindex="1" aria-label="Previous">{prevSVG}</button>
            <button class="gclose gbtn" tabindex="2" aria-label="Close">{closeSVG}</button>
        </div>
        </div>`;

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

    function storySlideShow(container){
        container.find(".ctl_slideshow .slides").not('.slick-initialized').each(function(){
            var autoplaySpeed=parseInt(jQuery(this).data('animationspeed'));
            var slideshow=jQuery(this).data('slideshow');
            if (jQuery(this).parents('.cool-timeline').hasClass('compact')) {
              var autoHeight = false;
            } else {
                var autoHeight = true;
            }
        jQuery(this).slick({
            dots: false,
            infinite: false,
            arrows:true,
            mobileFirst:true,
            pauseOnHover:true,
            slidesToShow:1,
            autoplay:slideshow,
            autoplaySpeed:autoplaySpeed,
            adaptiveHeight:autoHeight
          });      
        }); 
    }

      function loadMore(e){
        let thisS =e,
        sliderNav = "#" + thisS.attr("data-nav"),
        slider = "#" + thisS.attr("date-slider"),
        items= parseInt(thisS.attr("data-items")),
        setting_filters= thisS.attr("filters"),
        request=parseInt(thisS.attr('data_current_page')),
        wrp_id = thisS.attr('data-wrapper');
        year_navigation=jQuery(thisS.find('.year-nav-wrp .ctl_h_yearNav')),
        year_navigation_id=year_navigation[0] != undefined ? year_navigation[0].id : undefined;

        var UID = wrp_id.charAt(wrp_id.length-2)+wrp_id.charAt(wrp_id.length-1);
        UID = UID.replace('-', '');
        if(wrp_id.startsWith("content")){
            var shortcode_type = 'content-timeline';
            var ajax_action =  'ct_ajax_load_more';
            var ctlloadmore = window['ct_load_more' + '_' + UID] ;  
        }
        else{
            var shortcode_type = 'story-timeline';          
            var ajax_action =  'ctl_ajax_load_more';         
            var ctlloadmore = window['ctlloadmore' + '_' + UID] ;  
        }

        var last_year = thisS.find('.timeline-year:last').data('section-title');
                var allAtts= ctlloadmore.attribute;
                
                jQuery(this).unbind();
                    var max_pages= jQuery(this).attr("data-max-num-pages");
                    var termSlug = jQuery('.cth-cat-filters.active-category').data("term-slug");
                    
                    var request_page =  thisS.attr('data_current_page');
                    var data = {
                        action: ajax_action,
                        page: request_page,
                        last_year:last_year,
                        main_wrp_id:wrp_id,
                        termslug:termSlug,
                        attribute:allAtts,
                        layout:'horizontal',
                        nonce:ctlloadmore.nonce
                        };
                    jQuery.post(ctlloadmore.url, data, function(res) {
                    if(typeof(res) == 'string'){
                        res = JSON.parse(res);
                    }	
                        if( res.success) {
                            if(year_navigation != undefined)
                            if(year_navigation.hasClass('slick-slider')){
                                jQuery(year_navigation).slick('slickAdd',res.data.hr_year_label);
                            }else{
                                jQuery(year_navigation).append(res.data.hr_year_label);
                                year_swiper(year_navigation_id);              
                            }
                            jQuery(sliderNav).slick('slickAdd',res.data.date_html);
                            jQuery(slider).slick('slickAdd',res.data.html);
                            let nextpage=request+1;
                            thisS.attr('data_current_page',nextpage);

                            // PopUp slider reinitalize
                            GLightbox({
                                selector: '.ctl_glightbox_gallery',
                                lightboxHTML: customLightboxHTML,
                                svg: {
                                          'close':'<i class="ctl_glightbox_close_btn"></i>',
                                    },
                            });
                        if(shortcode_type=='story-timeline'){
                          storySlideShow(thisS);
                        }    
                        window.ctl_ajax_loading=false;
                        } else {
                            
                        }
                    }).fail(function(xhr, textStatus, e) {
                    console.log(xhr.responseText);
                    });
    }
    
    jQuery('.cool-timeline-horizontal').each(function(){
        var thisS =jQuery(this),
        setting_pagination= thisS.attr("pagination"),
        sliderNav = "#" + thisS.attr("data-nav");
        show_items = parseInt(thisS.attr("data-items"));
        if(setting_pagination == 'ajax_load_more'){
            thisS.attr('data_current_page',2);
            jQuery(sliderNav).on('afterChange', function(event, slick, currentSlide, nextSlide){
                if(window.ctl_ajax_loading == false){
                    let showitems=slick.originalSettings.slidesToShow,
                    totalStories=slick.slideCount-1,
                    laststory=slick.currentSlide + show_items,
                    request=parseInt(thisS.attr('data_current_page')),
                    totalPages= parseInt(thisS.attr("data-max-num-pages"));
                    if(request <= totalPages && laststory >= totalStories){
                        window.ctl_ajax_loading=true;
                    loadMore(thisS);
                    let next_button=thisS.find('.ctl-flat-left');
                    let button_new_cls="<i class='fa fa-spinner fa-spin'></i>";
                    next_button.html(button_new_cls);
                    }
                }
            });
        };
        // if(setting_filters == 'yes'){
        //     let wrp_id=thisS.attr('id').replace('ctl-horizontal-slider-','');
        //     jQuery('[data-id~='+wrp_id+'].cat-filter-wrp .cth-cat-filters').on('click',function(){
        //         let category=jQuery(this).attr('data-term-slug');
        //         let wrapper=jQuery(this);
        //         if(!wrapper.hasClass('active')){
        //             wrapper.closest('.cat-filter-wrp').find('.cth-cat-filters').removeClass('active');
        //             wrapper.addClass('active');

        //             var last_year = thisS.find('.timeline-year:last').data('section-title');
        //             var allAtts= ctlloadmore.attribute;
                    
        //             allAtts.category=category;

        //             if( ! loading ) {
        //                 loading=true;
        //                 var max_pages= jQuery(this).attr("data-max-num-pages");
        //                 var termSlug = jQuery('.cth-cat-filters.active-category').data("term-slug");
                        
        //                 var request_page =  thisS.attr('data_current_page');
        //                 var data = {
        //                     action: ajax_action,
        //                     page: request_page,
        //                     last_year:last_year,
        //                     termslug:termSlug,
        //                     attribute:allAtts,
        //                     layout:'horizontal',
        //                     nonce:ctlloadmore.nonce
        //                     };

        //                 jQuery.post(ctlloadmore.url, data, function(res) {
        //                 if(typeof(res) == 'string'){
        //                     res = JSON.parse(res);
        //                 }	
        //                     if( res.success) {
        //                         // console.log(res.data)
        //                         console.log('.slick-initialized#ctl-h-slider-'+wrp_id);

        //                         jQuery(sliderNav).slick( 'slickRemove', null, null, true );
        //                         jQuery(slider).slick( 'slickRemove', null, null, true );
                                
        //                         jQuery(sliderNav).slick('slickAdd',res.data.date_html);
        //                         jQuery(slider).slick('slickAdd',res.data.html);

        //                         slickReinitialize(thisS);
        //                     //     jQuery(yearwrapper).append(res.data.hr_year_label);
        //                     //     jQuery(sliderNav).slick('slickAdd',res.data.date_html);
        //                     //     jQuery(slider).slick('slickAdd',res.data.html);
        //                     //     let nextpage=request+1;
        //                     //     thisS.attr('data_current_page',nextpage);
        //                     // if(shortcode_type=='story-timeline'){
        //                     //   storySlideShow(thisS);
        //                     // }       
        //                     loading=false;            
        //                     // ctlStoryAnimation_loadMore();
        //                     } else {
                                
        //                     }
        //                 }).fail(function(xhr, textStatus, e) {
        //                 console.log(xhr.responseText);
        //                 });
        //             }

        //         };
        //     });
        // };
    });

    // function slickReinitialize(container){
    //     var thisS =container;
    //     var sliderContent= "#" + thisS.attr("date-slider"),
    //         sliderNav = "#" + thisS.attr("data-nav"),
    //         rtl = thisS.attr("data-rtl"),
    //         items= parseInt(thisS.attr("data-items")),
    //         autoplay = thisS.attr("data-autoplay"),
    //         autoplaySettings=autoplay=="true"?true:false,
    //         rtlSettings=rtl=="true"?true:false,
    //         startOn= parseInt(thisS.attr("data-start-on")),
    //         speed = parseInt(thisS.attr("data-autoplay-speed"));
    //         showSlides= items;
    //     var  totalStories=jQuery(sliderNav).find("li").length;

    //     thisS.siblings(".clt_preloader").hide();
    //     thisS.css("opacity", 1);
    //     settingObj={
    //         slidesToShow: showSlides,
    //         slidesToScroll: 1,
    //         autoplaySpeed: speed,
    //         rtl:rtlSettings,
    //         asNavFor:sliderNav,
    //         dots:false,
    //         autoplay:autoplaySettings,
    //         infinite:false,
    //         initialSlide:startOn,
    //         adaptiveHeight: true,
    //         responsive: [{
    //             breakpoint: 768,
    //             settings: {
    //                 centerPadding: "10px",
    //                 slidesToShow: 1
    //             }
    //         }, {
    //             breakpoint: 480,
    //             settings: {
    //                 centerPadding: "10px",
    //                 slidesToShow: 1
    //             }
    //         }]
    //     };
    //  if(totalStories!==undefined && totalStories<=3){
    //         settingObj.arrows=true;
    //         settingObj.nextArrow='<button type="button" style="background:none;" class="ctl-slick-next "><i class="far fa-arrow-alt-circle-right"></i></button>';
    //         settingObj.prevArrow='<button type="button" style="background:none;" class="ctl-slick-prev"><i class="far fa-arrow-alt-circle-left"></i></button>';
    //     }else{
    //         settingObj.arrows=false; 
    //     }
    //     var $slideShow = jQuery(sliderContent).not('.slick-initialized').slick(settingObj);

    //     jQuery(sliderNav).not('.slick-initialized').slick({
    //         slidesToShow:showSlides,
    //         slidesToScroll: 1,
    //         asNavFor:sliderContent,
    //         dots:false,
    //         infinite:false,
    //         rtl:rtlSettings,
    //         nextArrow: '<button type="button" class="ctl-slick-next "><i class="far fa-arrow-alt-circle-right"></i></button>',
    //         prevArrow: '<button type="button" class="ctl-slick-prev"><i class="far fa-arrow-alt-circle-left"></i></button>',
    //         focusOnSelect:true,
    //         adaptiveHeight:true,
    //         initialSlide:startOn,
    //         responsive: [{
    //             breakpoint: 768,
    //             settings: {
    //                 arrows:true,
    //                 centerPadding: "10px",
    //                 slidesToShow: 1
    //             }
    //         }, {
    //             breakpoint: 480,
    //             settings: {
    //                 arrows:true,
    //                 centerPadding: "10px",
    //                 slidesToShow: 1
    //             }
    //         }]
    //     })
    // };
    })
    