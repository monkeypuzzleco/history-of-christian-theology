jQuery(function($) {
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

    // on scroll stories animations
    function ctlStoryAnimation_loadMore() {
        // enabled animation on page scroll
        $(".cooltimeline_cont").each(function(index) {
            var timeline_id = $(this).attr("id");
            var animations = $("#" + timeline_id).attr("data-animations");
            if (animations != "none") {
                // You can also pass an optional settings object
                // below listed default settings
                AOS.init({
                    // Global settings:
                    disable: "mobile", // accepts following values: 'phone', 'tablet', 'mobile', boolean, expression or function
                    startEvent: "DOMContentLoaded", // name of the event dispatched on the document, that AOS should initialize on
                    offset: 75, // offset (in px) from the original trigger point
                    delay: 0, // values from 0 to 3000, with step 50ms
                    duration: 750, // values from 0 to 3000, with step 50ms
                    easing: "ease-in-out-sine", // default easing for AOS animations
                    mirror: true,
                });
            }
        });
    }

    const customPagination=(...e)=>{
        let total_pages=parseInt(e[0]['total_page']),
        current_pages=parseInt(e[0]['current_page']),
        prev_arrow='',
        next_arrow='',
        data=[],
        page_num=`<span class='page-numbers page-num' data-total-pages="${total_pages}">Page ${current_pages} of ${total_pages}</span>`;
        if (current_pages != 1) {
            prev_arrow=`<span class="page-numbers ctl_custom_pagination ctl_custom_pagi_arrow prev" data_current_page="${current_pages-1}"> « </span>`;
        }
        for( let i=1; i <= total_pages; i++ ){
            let data_value='',
            prev_dots='',
            prev_dots_sec='';
            if(total_pages < 6){
                    data_value=`<span class='page-numbers ctl_custom_pagination ${i == current_pages && 'current'}' data_current_page='${i}'>${i}</span>`;
            }else{
                if(current_pages < 3 && i < 4){
                    data_value=`<span class='page-numbers ctl_custom_pagination ${i == current_pages && 'current'}' data_current_page="${i}">${i}</span>`;
                    prev_dots= i == 3 ? '<span class="page-numbers dots">...</span>' : '';
                }else{
                    if(i==1){
                        data_value=`<span class='page-numbers ctl_custom_pagination' data_current_page="${i}">${i}</span>`;
                        prev_dots= current_pages > 3 ? '<span class="page-numbers dots">...</span>' : '';
                    }
                };
                if( current_pages > 2 && i > 1 &&  current_pages < (total_pages - 1) && i < (total_pages-1)) {
                    if(i <= (current_pages+1) && i >= current_pages-1 ){
                        data_value=`<span class='page-numbers ctl_custom_pagination ${i == current_pages && 'current'}' data_current_page="${i}">${i}</span>`;
                        if(i <= (total_pages-3) && current_pages >= total_pages - 4){
                            if(i==total_pages-2){
                                data_value=`<span class='page-numbers ctl_custom_pagination ${i == current_pages && 'current'}' data_current_page="${i}">${i}</span>`;
                            }
                        }else{
                            if(i==current_pages+2){
                                data_value=`<span class='page-numbers ctl_custom_pagination ${i == current_pages && 'current'}' data_current_page="${i}">${i}</span>`;
                            }
                        }
                        if (current_pages!=(total_pages-3)){
                                prev_dots_sec= i == (current_pages + 1)?'<span class="page-numbers dots">...</span>':"";
                        }
                        if(current_pages==(total_pages-3)){
                                prev_dots_sec= i == (total_pages-2)?'<span class="page-numbers dots">...</span>':'';
                        }
                    }
                }
                if(current_pages >= (total_pages - 2) && i >= (total_pages-2)){
                        data_value=`<span class='page-numbers ctl_custom_pagination ${i == current_pages && 'current'}' data_current_page="${i}">${i}</span>`;
                }else{
                    if(i==total_pages){
                        data_value=`<span class='page-numbers ctl_custom_pagination' data_current_page="${i}">${i}</span>`;
                    }
                }
               
            }
            data.push(data_value+prev_dots+prev_dots_sec);
        }
        if (current_pages != total_pages) {
            next_arrow=`<span class="page-numbers ctl_custom_pagination ctl_custom_pagi_arrow next" data_current_page="${current_pages+1}"> » </span>`;
        }
        let final_data=page_num+prev_arrow+data.join("")+next_arrow;
        return final_data;
    };

    // Vertical Center Line Filling Function
    const ctl_Ver_LineFill_callback=async (e)=>{
        await new Promise(timer => setTimeout(timer, 100));
        ctl_vertical_ling_filling({data: e,async_callback: true})
    }

    // story timeline load more
    //if(typeof ctlloadmore != 'undefined' && typeof ctlloadmore.attribute != 'undefined')
    //{
    // var page =2;
    var loading = false;

    if (
        $(".cool_timeline").find(".ctl_load_more").attr("data-max-num-pages") == 1
    ) {
        $(".cool_timeline").find(".ctl_load_more").hide();
    } else {
        // enable load more button in year navigation
        var timelineWrapper = $(".cool_timeline");
        naviLoadMoreBtn(timelineWrapper);
    }
    
    $(".ctl_load_more").attr("data_current_page", 2);

    $("body").on("click", ".ctl_load_more,.ctl_custom_pagination:not('.current')", function(e) {
        e.preventDefault();

        if (!loading) {
            loading = true;
        let currentElement = $(e.currentTarget);
        var timeline_wrp = $(this).parents(".cool_timeline");
        var wrp_id = timeline_wrp.attr("id");
        var UID = wrp_id.charAt(wrp_id.length - 2) + wrp_id.charAt(wrp_id.length - 1);
        UID = UID.replace("-", "");
        let ctlTopPosition=timeline_wrp[0].offsetTop;

        if (wrp_id.startsWith("content")) {
            var shortcode_type = "content-timeline";
            var ajax_action = "ct_ajax_load_more";
            var ctlloadmore = window["ct_load_more" + "_" + UID];
        } else {
            var shortcode_type = "story-timeline";
            var ajax_action = "ctl_ajax_load_more";
            var ctlloadmore = window["ctlloadmore" + "_" + UID];
        }

        var org_label = $(this).text();
        var loading_text = $(this).attr("data-loading-text");
        var button = timeline_wrp.find(".ctl_load_more");
        var type = currentElement.hasClass("ctl_custom_pagination") ? currentElement.closest('.custom-pagination').attr("data-timeline-type") : $(this).attr("data-timeline-type");
        var last_year = timeline_wrp.find(".timeline-year:last").data("section-title");

        if (currentElement.hasClass("ctl_custom_pagination")) {
            jQuery(timeline_wrp.find('.cool_timeline_end')).addClass('innerViewPort')
		    jQuery(timeline_wrp.find('.center-line')).addClass('AfterViewPort')
            let last_pagi_div = timeline_wrp.find(".custom-pagination .page-num"),
            last_pagi_num = parseInt($(last_pagi_div).attr("data-total-pages")),
            current_pagi_num = parseInt(currentElement.attr("data_current_page")),
            cust_pagination_data={"total_page":last_pagi_num,"current_page":current_pagi_num},
            loading_img = timeline_wrp.find(".custom-pagination").attr("data-loading_img");
    
            timeline_wrp.find('.custom-pagination').html(customPagination(cust_pagination_data));

            if (type == 'compact') {
                timeline_wrp.find(".cooltimeline_cont .clt-compact-cont .timeline-post").remove();
                timeline_wrp.find(".clt-compact-cont").height('60px');
                let child_comment_node = timeline_wrp.find(".clt-compact-cont")[0].childNodes;
                $(child_comment_node).each((e, a) => {
                    if (a.nodeType === Node.COMMENT_NODE) {
                        $(a).remove();
                    };
                });
                let loadInsertAfter = timeline_wrp.find(".clt-compact-cont .center-line");
                $("<div  class='filter-preloaders' style='display: block;'><img src='" + loading_img + "'></div>").insertAfter(loadInsertAfter[0]);
            } else {
                timeline_wrp.find(".cooltimeline_cont").html(
                    '<div  class="filter-preloaders" style="display: block;"><img src="' +
                    loading_img +
                    '"></div>'
                );
            }
            $(window).scrollTop(ctlTopPosition);
        }

        if (type == "compact") {
            var last_year = timeline_wrp
                .find(".compact-year:last")
                .data("section-title");
        } else {
            var last_year = timeline_wrp
                .find(".timeline-year:last")
                .data("section-title");
        }
        var allAtts = ctlloadmore.attribute;
        var alternate = timeline_wrp.find(".timeline-post:last").data("alternate");

        if (
            $(".ct-cat-filters").length &&
            $(".ct-cat-filters").hasClass("active-category")
        ) {
            var filterCat = $(".active-category").data("term-slug");
            allAtts.category = filterCat;
        }
            $(this).html(loading_text);
            var max_pages = $(this).attr("data-max-num-pages");
            var max_page_num = parseInt(max_pages) + 1;
            var termSlug = jQuery(".ct-cat-filters.active-category").data(
                "term-slug"
            );
            var request_page = $(this).attr("data_current_page");
            var data = {
                action: ajax_action,
                page: request_page,
                last_year: last_year,
                alternate: alternate,
                termslug: termSlug,
                attribute: allAtts,
                nonce: ctlloadmore.nonce,
            };
            $.post(ctlloadmore.url, data, function(res) {
                if (typeof res == "string") {
                    res = JSON.parse(res);
                }
                if (res.success) {
                    if (currentElement.hasClass("ctl_custom_pagination")) {
                        if (!currentElement.hasClass("active")) {
                            if (type == 'compact') {
                                timeline_wrp.find('.filter-preloaders').remove();
                                var $grid = timeline_wrp.find(".clt-compact-cont .center-line").after(res.data.html);
                                ctlCompactSettings($grid);
                            } else {
                                timeline_wrp.find(".cooltimeline_cont").html("");
                                timeline_wrp.find(".cooltimeline_cont").append(res.data.html);
                            }
                            $(window).scrollTop(ctlTopPosition);
                        }
                    } else {
                        if (type == "compact") {
                            var $grid = timeline_wrp
                                .find(".clt-compact-cont .timeline-post")
                                .last()
                                .after(res.data.html);
                            ctlCompactSettings($grid);
                        } else {
                            timeline_wrp.find(".cooltimeline_cont").append(res.data.html);
                        }
                    }

                    // PopUp slider reinitalize
                    GLightbox({
                        selector: ".ctl_glightbox_gallery",
                        lightboxHTML: customLightboxHTML,
                        svg: {
                            close: '<i class="ctl_glightbox_close_btn"></i>',
                        },
                    });
                    //    if(type!="compact"){
                    storyYearNavigation(timeline_wrp);
                    //  }
                    if (shortcode_type == "story-timeline") {
                        storySlideShow(timeline_wrp);
                    }
                    naviLoadMoreBtn(timeline_wrp);
                    ctlStoryAnimation_loadMore();
                    button.html(org_label);

                    // Center Line Filling Callback
                    ctl_Ver_LineFill_callback(timeline_wrp);

                    var next_page = parseInt(request_page) + 1;
                    button.attr("data_current_page", next_page);
                    loading = false;

                    if (next_page >= max_page_num) {
                        button.hide();
                        $("#" + wrp_id + "-navi")
                            .find(".ctl_load_more_clone")
                            .hide();
                    }
                } else {}
            }).fail(function(xhr, textStatus, e) {
                console.log(xhr.responseText);
            });
        }
    });
    //  }

    // content timeline load more
    /* if(typeof ct_load_more != 'undefined' && typeof ct_load_more.attribute != 'undefined') 
            {   
      
            var page =2;
            var loading = false;
            
            $('body').on('click', '.ctl_load_more', function(){
               var timeline_wrp= $(this).parents('.cool_timeline');
               var button = timeline_wrp.find('.ctl_load_more');
                 var type=$(this).attr("data-timeline-type");
                 if(type=="compact"){
                    var last_year = timeline_wrp.find('.compact-year:last').data('section-title');
                 }else{
                var last_year = timeline_wrp.find('.timeline-year:last').data('section-title');
                 }
         
               var alternate = timeline_wrp.find('.timeline-post:last').data('alternate');
               var org_label=$(this).text();
               var loading_text=$(this).attr("data-loading-text");
               var allAtts= ct_load_more.attribute;
             
               if($('.ct-cat-filters').length  && $('.ct-cat-filters').hasClass('active-category')) {
                    var filterCat=$('.active-category').data('term-slug');
                    allAtts['post-category']=filterCat;
                   
               }
      
                if( ! loading ) {
                  $(this).html(loading_text);
                  var max_pages= $(this).attr("data-max-num-pages");
                  var max_page_num=parseInt(max_pages)+1;
                 
                     loading = true;
                        var data = {
                            action: 'ct_ajax_load_more',
                            page: page,
                            last_year:last_year,
                            alternate:alternate,
                            attribute:allAtts,
                            nonce:ct_load_more.nonce
                        };
      
                     $.post(ct_load_more.url, data, function(res) {
                            if( res.success) {
                             if(type=="compact"){
                                var $grid= timeline_wrp.find('.clt-compact-cont').append( res.data );
                                ctlCompactSettings($grid);
                            }else{
                               timeline_wrp.find('.cooltimeline_cont').append( res.data );
                            }
                               storyYearNavigation(timeline_wrp);
                                 page = page + 1;
                                 loading = false;
                                button.html(org_label);
                               if(page>=max_page_num){
                                    button.hide();
                                  }
      
                            } else {
                            }
                        }).fail(function(xhr, textStatus, e) {
                           console.log(xhr.responseText);
                        });
      
                    }
                });
            }
            */
           // category based dynamic filtering for both layouts
        $(".ct-cat-filters").on("click", function($event) {
        $event.preventDefault();
        if (!loading) {
            loading = true;
        $(".ctl_load_more").attr("data_current_page", 2);
        var timeline_wrp = $(this).parents(".cool_timeline");
        let custPagiDiv = timeline_wrp.find(".custom-pagination");
        timeline_wrp.find('.ctl_center_line_filling').height('0px');
        if (custPagiDiv.length > 0) {
            custPagiDiv.remove();
        }
        var wrp_id = timeline_wrp.attr("id");
        //str.charAt(str.length-2)+str.charAt(str.length-1);
        var UID =
            wrp_id.charAt(wrp_id.length - 2) + wrp_id.charAt(wrp_id.length - 1);
        UID = UID.replace("-", "");

        if (wrp_id.startsWith("content")) {
            var shortcode_type = "content-timeline";
            var ajax_action = "ct_ajax_load_more";
            var ctlloadmore = window["ct_load_more" + "_" + UID];
        } else {
            var shortcode_type = "story-timeline";
            var ajax_action = "ctl_ajax_load_more";
            var ctlloadmore = window["ctlloadmore" + "_" + UID];
        }

        var cat_name = $(this).text();
        var parent_wrp = $(this).parents(".cool_timeline");
        var preloader = parent_wrp.find(".filter-preloaders");
        //   parent_wrp.find(".custom-pagination").hide();
        //    parent_wrp.find(".ctl_load_more").hide();
        //     $(this).parents().find('.ctl_load_more').show();

        preloader.show();
        var parent_id = parent_wrp.attr("id");
        var navigation = "#" + parent_id + "-navi";
        var termSlug = $(this).data("term-slug");

        var totalPosts = parseInt($(this).data("post-count"));
        var action = $(this).data("action");
        var tm_type = $(this).data("tm-type");
        var type = $(this).data("type");
        var org_label = $(this).text();
        var loading_text = $(this).attr("data-loading-text");

        if (type == "compact") {
            var last_year = parent_wrp
                .find(".active-category .compact-year:last")
                .data("section-title");
        } else {
            var last_year = parent_wrp
                .find(".active-category .timeline-year:last")
                .data("section-title");
        }
        var alternate = parent_wrp.find(".timeline-post:last").data("alternate");
        /*    if(tm_type=="story-tm"){
              var all_attrs= ctlloadmore.attribute;
              var ajax_url= ctlloadmore.url;
              var nonce= ctlloadmore.nonce;
           }else{
            var all_attrs= ct_load_more.attribute;
            var ajax_url= ct_load_more.url;
            var nonce= ct_load_more.nonce;
           } */

        var all_attrs = ctlloadmore.attribute;
        var ajax_url = ctlloadmore.url;
        var nonce = ctlloadmore.nonce;

        var showPosts = $(".cool-timeline-wrapper").attr("data-showposts");
        var countPages = Math.ceil(totalPosts / showPosts);

        $(".ctl_load_more").attr("data-max-num-pages", countPages);
        page = 2;

        if (totalPosts > showPosts) {
            $(this).parents(".cool_timeline").find(".ctl_load_more").show();
        } else {
            $(this).parents(".cool_timeline").find(".ctl_load_more").hide();
        }

        all_attrs.category = termSlug;
            $(".cat-filter-wrp ul li a").removeClass("active-category");
            $(this).addClass("active-category");
            if (type == "compact") {
                parent_wrp.find(".clt-compact-cont").html(" ");
            } else {
                parent_wrp.find(".cooltimeline_cont").html(" ");
            }
            var data = {
                action: action,
                last_year: last_year,
                alternate: alternate,
                termslug: termSlug,
                attribute: all_attrs,
                nonce: nonce,
            };
            $.post(ajax_url, data, function(res) {
                if (typeof res == "string") {
                    if (res != "undefined") {
                        res = JSON.parse(res);
                    }
                }
                if (res.success) {

                    // custom pagination update

                    if (res.data.pagination != '') {
                        if(type == "compact"){
                            parent_wrp.find('.cool-timeline').append(res.data.pagination);
                        }else{
                            let lastDiv = parent_wrp.find(".cool_timeline_end");
                            $(res.data.pagination).insertBefore(lastDiv[0]);
                        }
                        parent_wrp.find('.custom-pagination').html(customPagination(res.data.cust_pagination));
                    };

                    if (type == "compact") {
                        // story data Update
                        if (res.data.html !== undefined && res.data.html != "") {
                            parent_wrp
                                .find(".clt-compact-cont")
                                .append('<div class="center-line"></div>');
                            var $grid = parent_wrp
                                .find(".clt-compact-cont")
                                .append(res.data.html);
                            ctlCompactSettings($grid);
                            parent_wrp.find(".ctl_load_more").removeClass("clt-hide-it");
                        } else {
                            parent_wrp.find(".ctl_load_more").addClass("clt-hide-it");
                        }
                    } else {
                        // sotry data update
                        if (res.data.html !== undefined && res.data.html != "") {
                            parent_wrp.find(".cooltimeline_cont").append(res.data.html);
                            parent_wrp.find(".ctl_load_more").removeClass("clt-hide-it");
                        } else {
                            parent_wrp.find(".ctl_load_more").addClass("clt-hide-it");
                        }
                    }

                    if(res.data.html.length<80){
                        parent_wrp.find('.no-content').remove();
                        parent_wrp.find('.cool-timeline').addClass('ctl_story_empty');
                    }else{
                        parent_wrp.find('.cool-timeline').removeClass('ctl_story_empty');
                    }
                    // PopUp slider reinitalize
                    GLightbox({
                        selector: ".ctl_glightbox_gallery",
                        lightboxHTML: customLightboxHTML,
                        svg: {
                            close: '<i class="ctl_glightbox_close_btn"></i>',
                        },
                    });
                    loading = false;
                    preloader.hide();

                    $(parent_wrp).find(".timeline-main-title").text(cat_name);
                    $(parent_wrp).find(".no-content").hide();
                    storyYearNavigation(parent_wrp);
                    storySlideShow(parent_wrp);
                    naviLoadMoreBtn(parent_wrp);

                    // Center Line Filling Callback
                    ctl_Ver_LineFill_callback(timeline_wrp);
                    
                    var timeline_id = jQuery(".cooltimeline_cont").attr("id");
                    var animations = jQuery("#" + timeline_id).attr("data-animations");
                    if (animations != "none") {
                        AOS.refreshHard();
                    }
                } else {}
            }).fail(function(xhr, textStatus, e) {
                console.log(xhr.responseText);
            });
        }
    });

    /*
     *  Helper funcitons
     */

    // re-enable compact masonry layout grid
    function ctlCompactSettings($grid) {
        $grid = $(".clt-compact-cont");
        if ($grid != undefined) {
            $grid.masonry("reloadItems");

            // layout images after they are loaded
            $grid.imagesLoaded(function() {
                $grid.masonry("layout");
            });

            $grid.one("layoutComplete", function() {
                var leftPos = 0;
                var topPosDiff;
                $grid.find(".timeline-mansory").each(function(index) {
                    leftPos = $(this).position().left;

                    if (leftPos <= 0) {
                        $(this).removeClass("ctl-right").addClass("ctl-left");
                    } else {
                        $(this).removeClass("ctl-left").addClass("ctl-right");
                    }

                    topPosDiff = $(this).position().top - $(this).prev().position().top;
                    if (topPosDiff < 40) {
                        $(this)
                            .find(".timeline-icon")
                            .removeClass("compact-iconup")
                            .addClass("compact-icondown");
                        $(this)
                            .prev()
                            .find(".timeline-icon")
                            .removeClass("compact-icondown")
                            .addClass("compact-iconup");

                        $(this)
                            .find(".content-title")
                            .removeClass("compact-afterup")
                            .addClass("compact-afterdown");
                        $(this)
                            .prev()
                            .find(".content-title")
                            .removeClass("compact-afterdown")
                            .addClass("compact-afterup");

                        $(this)
                            .find(".timeline-content")
                            .removeClass("compact-afterup")
                            .addClass("compact-afterdown");
                        $(this)
                            .prev()
                            .find(".timeline-content")
                            .removeClass("compact-afterdown")
                            .addClass("compact-afterup");
                    }
                });
                $(".timeline-icon").addClass("showit");
                $(".content-title").addClass("showit-after");
                var timeline_id = jQuery(".cooltimeline_cont").attr("id");
                var animations = jQuery("#" + timeline_id).attr("data-animations");
                if (animations != "none") {
                    AOS.refreshHard();
                }
            });
        }
    }

    function storySlideShow(container) {
        container
            .find(".ctl_flexslider .slides")
            .not(".slick-initialized")
            .each(function() {
                var autoplaySpeed = parseInt($(this).data("animationspeed"));
                var slideshow = $(this).data("slideshow");
                if ($(this).parents(".cool-timeline").hasClass("compact")) {
                    var autoHeight = false;
                } else {
                    var autoHeight = true;
                }

                $(this).slick({
                    dots: false,
                    infinite: false,
                    arrows: true,
                    mobileFirst: true,
                    pauseOnHover: true,
                    slidesToShow: 1,
                    autoplay: slideshow,
                    autoplaySpeed: autoplaySpeed,
                    adaptiveHeight: autoHeight,
                });
            });
    }
    // year navigation load more function
    function naviLoadMoreBtn(parent_wrp) {
        if (
            parent_wrp.find(".ctl_load_more").length &&
            $("body").find(".ctl-bullets-container ul li").length
        ) {
            parent_wrp.find(".ctl_load_more").each(function() {
                var loadMoreBtn = $(this);
                var timelineId = loadMoreBtn.parents(".cool_timeline").attr("id");
                var naviContainer = $("#" + timelineId + "-navi");

                var buttonHtml =
                    '<button data-text="..Loading" class="ctl_load_more_clone">Load More</button>';
                naviContainer.find("ul").after(buttonHtml);
                naviContainer.find(".ctl_load_more_clone").on("click", function() {
                    var text = $(this).data("text");
                    $(this).text(text);
                    loadMoreBtn.trigger("click");
                });
            });

            /*  $(".ctl_load_more_clone").on("click",function(){
                var text=$(this).data("text");
                $(this).text(text);
                 $('.cool_timeline').find('.ctl_load_more').trigger("click");
               }); */
        }
    }

    // re-enable scrolling navigation
    function storyYearNavigation(timeline_wrp) {
        if (timeline_wrp != undefined) {
            var wrp_id = timeline_wrp.attr("id");
            $("#" + wrp_id + "-navi").remove();

            var pagination = timeline_wrp.attr("data-pagination");
            var pagination_position = timeline_wrp.attr("data-pagination-position");
            var bull_cls = "";
            var position = "";
            if (pagination_position == "left") {
                bull_cls = "section-bullets-left";
                position = "left";
            } else if (pagination_position == "right") {
                bull_cls = "section-bullets-right";
                position = "right";
            } else if (pagination_position == "bottom") {
                bull_cls = "section-bullets-bottom";
                position = "bottom";
            }
            $("body").sectionScroll({
                // CSS class for bullet navigation
                bulletsClass: bull_cls,
                // CSS class for sectioned content
                sectionsClass: "scrollable-section",
                // scroll duration in ms
                scrollDuration: 1500,
                // displays titles on hover
                titles: true,
                // top offset in pixels
                topOffset: 2,
                // easing opiton
                easing: "",
                id: wrp_id,
                position: position,
            });
        }
    }
});