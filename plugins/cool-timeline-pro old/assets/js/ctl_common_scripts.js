jQuery('document').ready(function($){
	// gligbox popup slick html
	const popupSlick = (e) =>{
		let sliderimg=[];
		Object.keys(e).forEach(key => {jQuery(e[key]).attr('src') != undefined ? sliderimg.push(`<div><img src="${jQuery(e[key]).attr('src')}"/></div>`) : null});

		return '<div class="ctl_glightbox_slideshow"><div class="ctl_popup_slick"><div class="slides">'+sliderimg.join('')+'</div></div></div>';
	};

	// glightbox custom html
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

	// glightbox minimal html
	const lightboxMimalHTML = `<div id="glightbox-body" class="glightbox-container">
		<div class="gloader visible"></div>
		<div class="goverlay"></div>
		<div class="gcontainer ctl_glightbox_container minimal-layout">
		<div id="glightbox-slider" class="gslider"></div>
		<button class="gnext gbtn" tabindex="0" aria-label="Next" data-customattribute="example">{nextSVG}</button>
		<button class="gprev gbtn" tabindex="1" aria-label="Previous">{prevSVG}</button>
		<button class="gclose gbtn" tabindex="2" aria-label="Close">{closeSVG}</button>
	</div>
	</div>`;

	const Lightboxsvg={
		'close':'<i class="ctl_glightbox_close_btn"></i>',
		'next':'<i class="ctl_glightbox_hidden"></i>',
		'prev':'<i class="ctl_glightbox_hidden"></i>',
	};

	// vertical CenterLineFilling
const ctlLineFilling=(element)=>{
	let parentWrp=element.data;
	let timeline_year=parentWrp.find('.timeline-year');
	let timeline_icons=parentWrp.find('.timeline-icon');
	let lineFilling=parentWrp.data('line-filling');
	let Stories=parentWrp.find('.timeline-post');
	if(parentWrp.hasClass('main-design-6') && (parentWrp.hasClass('one-sided-wrapper') || parentWrp.hasClass('both-sided-wrapper'))){
		timeline_icons=Stories;
	}
	if(lineFilling && Stories.length > 0){
		let outerDiv=parentWrp.find('.cool-timeline');
		if(parentWrp.hasClass('compact-wrapper')){
			outerDiv=parentWrp.find('.clt-compact-cont')
			outerHeight=outerDiv.outerHeight()-36;

			// Center Line Filling Callback
			if(outerDiv.height() == 0 && element.async_callback){
				ctl_Ver_LineFill_callback(parentWrp);
			}

		}else{
			outerHeight=outerDiv.outerHeight();
		}
		rect=outerDiv[0].getBoundingClientRect(),
		height=jQuery(window).height() / 2,
		centerLine=parentWrp.find('.ctl_center_line_filling');
		if (rect.top < 0) {
			ctlTop = Math.abs(rect.top);
		} else {
			ctlTop = -Math.abs(rect.top);
		}
		let lineInerHeight=ctlTop + height,
		centerLIneHeight=centerLine.height();
		if(lineInerHeight <= outerHeight){
			centerLine.height(lineInerHeight);
		}
		for(year of timeline_year){
			let yearPosition=jQuery(year)[0].offsetTop;
			let height=jQuery(year).height() / 1.5;
			if(lineInerHeight >= yearPosition + height){
				jQuery(year).addClass('innerViewPort');
			}else{
				jQuery(year).removeClass('innerViewPort');
			}
		};	
		for(icons of timeline_icons){
			let iconsPosition=jQuery(icons)[0].offsetTop;
			if(parentWrp.hasClass('compact-wrapper')){
				IconTopPosition=jQuery(icons)[0];
				if(IconTopPosition.offsetTop > 0){
					iconsPosition=IconTopPosition.parentElement.offsetTop;
				}else{
					iconsPosition=IconTopPosition.parentElement.offsetTop - 20;
				}
			}
			if(lineInerHeight >= iconsPosition){
				jQuery(icons.closest('.timeline-post')).addClass('innerViewPort');
			}else{
				jQuery(icons.closest('.timeline-post')).removeClass('innerViewPort');
			}
		};	
		if(lineInerHeight >= outerHeight && centerLIneHeight < outerHeight){
			centerLine.height(outerHeight);
		}
		if(lineInerHeight > 0){
			jQuery(parentWrp.find('.cool_timeline_start')).addClass('innerViewPort')
			jQuery(parentWrp.find('.center-line')).addClass('BeforeViewPort')
		}else{
			jQuery(parentWrp.find('.cool_timeline_start')).removeClass('innerViewPort')
			jQuery(parentWrp.find('.center-line')).removeClass('BeforeViewPort')
		}
		if(lineInerHeight >= outerHeight){
			jQuery(parentWrp.find('.cool_timeline_end')).addClass('innerViewPort')
		    jQuery(parentWrp.find('.center-line')).addClass('AfterViewPort')
		}else{
			jQuery(parentWrp.find('.cool_timeline_end')).removeClass('innerViewPort')
		    jQuery(parentWrp.find('.center-line')).removeClass('AfterViewPort')
		}
	}
};
	
	var timelineWrapper=$(".cool_timeline");
	timelineWrapper.each(function(){
		storySlideShow($(this));
		// ctlStoryPopup($(this));
		ctlYearNavigation($(this));
		let data={data: $(this)}
		ctlLineFilling(data);
		jQuery(window).on('scroll',$(this),ctlLineFilling);
	});

	ctlStoryAnimation();
	var ele_width=timelineWrapper.find('.timeline-content').find(".ctl_info").width();
	ele_width=ele_width-20;
	var value =ele_width
    value *= 1;
    var valueHeight = Math.round((value/4)*3);
	timelineWrapper.find('.full-width > iframe').height(valueHeight);


	function Utils() {
	}

//detect element position in page
	Utils.prototype = {
		constructor: Utils,
		isElementInView: function (element, fullyInView) {
			var pageTop = $(window).scrollTop();
			var pageBottom = pageTop + $(window).height();
			var elementTop = parseInt($(element).offset().top)+200;
			var elementBottom = elementTop + parseInt($(element).height())-500;

			if (fullyInView === true) {
				return ((pageTop < elementTop) && (pageBottom > elementBottom));
			} else {
				return ((elementTop <= pageBottom) && (elementBottom >= pageTop));
			}
		}
	};

var Utils = new Utils();

function storySlideShow(container){
	container.find(".ctl_flexslider .slides").not('.slick-initialized').each(function(){
	var autoplaySpeed=parseInt($(this).data('animationspeed'));
	var slideshow=$(this).data('slideshow');
	var animation=$(this).data('animation');

	if ($(this).parents('.cool-timeline').hasClass('compact')) {
		var autoHeight = false;
	}else {
		var autoHeight = true;
	}

	$(this).slick({
		dots: false,
		infinite: false,
		arrows:true,
		mobileFirst:true,
		pauseOnHover:true,
		slidesToShow:1,
		autoplay:slideshow,
		autoplaySpeed:autoplaySpeed,
		 adaptiveHeight: autoHeight,
	  });      
	}); 
}

// year navigation
function ctlYearNavigation(timelineWrapper){
		// creates year scrolling navigation
		var pagination= timelineWrapper.attr('data-pagination');
		var pagination_position= timelineWrapper.attr('data-pagination-position');
		var bull_cls='';
		var position='';
		if(pagination_position=="left"){
			 bull_cls='section-bullets-left';
			position='left';
		}else if(pagination_position=="right"){
			 bull_cls='section-bullets-right';
			position='right';
		}else if(pagination_position=="bottom"){
			 bull_cls='section-bullets-bottom';
			position='bottom';
		}
		timelineWrapper.each(function(index){
			var id=$(this).attr("id");
		if(id!==undefined){
			if(pagination=="yes"){
			  $('body').sectionScroll({
			  // CSS class for bullet navigation
			  bulletsClass:bull_cls,
			  // CSS class for sectioned content
			  sectionsClass:'scrollable-section',
			  // scroll duration in ms
			  scrollDuration: 1500,
			  // displays titles on hover
			  titles: true,
			  // top offset in pixels
			  topOffset:2,
			  // easing opiton
			  easing: '',
			  id:id,
			  position:position,
			});
			}
		}
		});
		
		if(pagination=="yes"){
		$('.ctl-bullets-container').hide();
		timelineWrapper.each(function(){
		if (typeof  $(this).attr("id") !== typeof undefined &&  $(this).attr("id") !== false) {
			 var id="#"+ $(this).attr("id");
			 var nav_id="#"+ $(this).attr("id")+'-navi';
			 $(nav_id).find('li').removeClass('active');
			 var offset = $(id).offset();
			  var t_height =$(id).height();
		
		 $(window).scroll(function () {
		  var isElementInView = Utils.isElementInView($(id), false);
			if (isElementInView) {
			  $(nav_id).show();
			} else {
				 $(nav_id).hide(); 
			}
			});
		}
		 });
	   }
}

// on scroll stories animations
function ctlStoryAnimation(){
	// enabled animation on page scroll
	$(".cooltimeline_cont").each(function(index ){
		var timeline_id=$(this).attr('id');
		var animations=$("#"+timeline_id).attr("data-animations");
	if(animations!="none") {
		// You can also pass an optional settings object
		// below listed default settings
		AOS.init({
			// Global settings:
			disable:'mobile', // accepts following values: 'phone', 'tablet', 'mobile', boolean, expression or function
			startEvent: 'DOMContentLoaded', // name of the event dispatched on the document, that AOS should initialize on
			offset: 75, // offset (in px) from the original trigger point
			delay: 0, // values from 0 to 3000, with step 50ms
			duration: 750, // values from 0 to 3000, with step 50ms
			easing: 'ease-in-out-sine', // default easing for AOS animations
			mirror: true,
		});
			
			}
	});
}

jQuery(window).on('load', function($) {
	var timeline_id=jQuery('.cooltimeline_cont').attr('id');
	var animations=jQuery("#"+timeline_id).attr("data-animations");	
	if(animations!="none" && animations!=undefined) {
		setTimeout(function(){ 
		AOS.refresh(); }, 500);
	}
});

// gligbox pop slick initialize
function storySlideShowLightbox(){
    jQuery('.ctl_glightbox_slideshow .slides').slick({
        dots: false,
        infinite: false,
        arrows:true,
        mobileFirst:true,
        pauseOnHover:true,
        slidesToShow:1,
        centerMode: true,
        autoplay:false,
        centerPadding: '0px',
        adaptiveHeight: true,
      });      
  }

  // glightbox single image slider
  jQuery(document).on('click','.ctl_glightbox',function(e){
      e.preventDefault();
      const lightbox = GLightbox({
        lightboxHTML: customLightboxHTML,
        svg:Lightboxsvg,
      })

      let targetHref = this.getAttribute('href'),
      title = this.getAttribute('data-glightbox')
      lightbox.setElements([{'href': targetHref,'title':title}])
      lightbox.open() 
  });

  // glightbox minimal layout slider
  jQuery(document).on('click','.minimal_glightbox',function(e){
    e.preventDefault();

    const lightbox = GLightbox({
      lightboxHTML: lightboxMimalHTML,
      svg:Lightboxsvg,
      touchNavigation:false
    })
    
    if(jQuery('.ctl_glightbox_slideshow .slides').hasClass('slick-initialized')){
      jQuery('.ctl_glightbox_slideshow .slides').slick('unslick');
    }

    let id=jQuery(this).attr('href'),
    image=jQuery(id).find('.ctl-popup-content .full-width>img, .ctl-popup-content .pull-left>img')[0],
    date=jQuery(id).find('.ctl-popup-content .popup-posted-date').html(),
    title=jQuery(id).find('.popup-content-title').html(),
    slideShow=jQuery(id).find('.ctl-popup-content .full-width.ctl_slideshow .ctl_popup_slick>ul>li>img'),
    desc=jQuery(id).find('.ctl-popup-content .ctl_popup_desc').html(),
    img=undefined;
    if(image != undefined){
      img=image.src;
    }
    lightbox.setElements(
      slideShow.length > 0 ?[
        {
          'content': `${popupSlick(slideShow)}<h2 class='ctl_glightbox_title'>${title}</h2><div class='ctl_glightbox_content'><div class='ctl_glightbox_date'>${date}</div><div class="ctl_glightbox_desc">${desc}</div></div>`,
          'height':'auto',
          'width':'500px'
        },
      ] :
      img!=undefined?[
        {
          'href': img,
          'type': 'image',
          'description': `<div class='ctl_glightbox_content'><h2 class='ctl_glightbox_title'>${title}</h2><div class='ctl_glightbox_date'>${date}</div><div class="ctl_glightbox_desc">${desc}</div></div>`,
          'height':'200px'
        },
      ]:
      [
        {
          'content': `<h2 class='ctl_glightbox_title'>${title}</h2><div class='ctl_glightbox_content'><div class='ctl_glightbox_date'>${date}</div><div class="ctl_glightbox_desc">${desc}</div></div>`,
          'max-width':'50vw',
          'height':'auto'
        },
      ]
    )
    lightbox.open();
    storySlideShowLightbox();
  });

  // glightbox slider gallery
  let sliderLightbox=GLightbox({
    selector: '.ctl_glightbox_gallery',
    lightboxHTML: customLightboxHTML,
    svg: {
              'close':'<i class="ctl_glightbox_close_btn"></i>',
        },
  });

// Center Line Filling Async Callback If Line Height 0px
const ctl_Ver_LineFill_callback=async (e)=>{
	await new Promise(timer => setTimeout(timer, 100));
	ctl_vertical_ling_filling({data: e,async_callback: true})
}

// horizontal CenterLineFilling
const centerHrLineFilling = (e) => {
	let activeslide=e.pos;
	
	jQuery(e.id).find('li.slick-slide').removeClass('pi');
	if(activeslide != undefined){
		for(let i=0; i < activeslide; i++){
			let prevAll=jQuery(e.id).find('li')[i];
				jQuery(prevAll).addClass('pi');
		}
	}
};

jQuery(".cool-timeline-horizontal").each((e,a)=>{
	let sliderContent = "#" + jQuery(a).attr("date-slider"), 
	sliderNav = "#" + jQuery(a).attr("data-nav"),
	sliderStory = "#" + jQuery(a).attr("date-slider"),
	lineFilling = jQuery(a).attr("data-line-filling"),
	startOn = parseInt(jQuery(a).attr("data-start-on")),
	items = parseInt(jQuery(a).attr("data-items")),
	totalslide = $(sliderContent + ' li[data-term-slug]').length;
	let lastshow_items = (totalslide - startOn);
	let PreviousSlide=startOn;
	let navClick=false;
	if(!jQuery(a).hasClass('ht-design-7')){
		
		if(lineFilling == 'true'){
			startOn >= (totalslide - 1) ? jQuery(sliderNav).addClass('line-full') : jQuery(sliderNav).removeClass('line-full');
			
			jQuery(document).on('click',sliderNav+' li.slick-slide,'+sliderNav+' .ctl-slick-prev,'+sliderNav+' .ctl-slick-next',function(){
				navClick=true;
				let NavWrapper=jQuery(this).closest('.ctl_h_nav.slick-initialized');
				let index=NavWrapper[0].slick.currentSlide;
				let currentSlider=NavWrapper[0].id;
				(totalslide - 1) == index ? NavWrapper.addClass('line-full') : NavWrapper.removeClass('line-full');
				centerHrLineFilling({'id': '#'+currentSlider,'pos': parseInt(index)});
			});

			jQuery(sliderStory).on('beforeChange',function(event, slick, currentSlide, nextSlide){
				if(!navClick){
					let NavWrapper=jQuery(this).closest('.cool-timeline-horizontal').find('.ctl_h_nav.slick-initialized');
					let index=NavWrapper[0].slick.currentSlide;
					let currentSlider=NavWrapper[0].id;
					(totalslide - 1) == index ? NavWrapper.addClass('line-full') : NavWrapper.removeClass('line-full');
					centerHrLineFilling({'id': '#'+currentSlider,'pos': parseInt(index)});
				}
				navClick=false;
			});

			if(jQuery(a).hasClass('ht-design-5') || jQuery(a).hasClass('ht-design-6')){
				startOn =  startOn >= totalslide ? totalslide-1 : startOn;
			}else{
				if (lastshow_items < items) {
					startOn = totalslide - items;
				}
			}
			// update center linefilling class after pageload
			centerHrLineFilling({'id': sliderNav,'pos': startOn});
		}

	}
});

// Center Line Filling Global Function
window.ctl_vertical_ling_filling=ctlLineFilling;
});