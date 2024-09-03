<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// default variables for later use
$ctl_options_arr = get_option('cool_timeline_settings');

$ctl_html='';
$ctl_format_html='';
$display_s_date='';
$same_day_post='';
$dates_li='';
$s_styles='';
$ctl_slideshow ='';
$dates_year_li='';
$year_label='';
$ctl_content_length ? $ctl_content_length : 100;
$itcls='';
$i=0;
$navigtion=ctl_set_default_value( $attribute['year-navigation'], 'hide');
$navigtion_position=ctl_set_default_value( $attribute['navigation-position'], 'left');
$hr_year_label=ctl_set_default_value($attribute['year-label'],'hide');
$icons = ctl_set_default_value( $attribute['icons'], 'YES');
$filters           = ctl_set_default_value( $attribute['filters'], 'no');
$cate_slug = '';
$lineFilling       = 'data-line-filling="'.esc_attr($attribute['line-filling']).'"';
// $lineFilling       = $active_design =='design-5' ? ' data-line-filling="'.$attribute['line-filling'].'"' : null;
$ctl_options_arr = get_option('cool_timeline_settings');
$target = isset($ctl_options_arr['story_content_settings']['story_link_target'])?$ctl_options_arr['story_content_settings']['story_link_target']:'_self';
  
if($attribute['designs'])
{
    $design_cls='ht-'.$attribute['designs'];
    $design=$attribute['designs'];
    }else{
   $design_cls='ht-default';
    $design='default';
}
 $r_more=isset($ctl_options_arr['story_content_settings']['display_readmore'])?$ctl_options_arr['story_content_settings']['display_readmore']:"yes";
 
// dynamic class based upon design
if(in_array($active_design,array("default","design-2","design-3","design-4","design-5","design-6"))){
    $items = $attribute['items'] ? $attribute['items'] : "3";
    $itcls='hori-items-'.$items;
	
}else if($active_design=="design-7" && $navigtion == 'show'){
    $items = $attribute['items'] ? $attribute['items'] : "3";
}else if($active_design=="design-7"){
    $items = $attribute['items'] ? $attribute['items'] : "6";
}
// main query
$ctl_loop = new WP_Query(apply_filters( 'ctl_stories_query',$args));
if ($ctl_loop->have_posts()) {

    while ($ctl_loop->have_posts()) : $ctl_loop->the_post();
         global $post;
        $post_id=get_the_ID();

        $posted_date='';
        $ctl_format_html='';
        $slink_s='';
        $slink_e='';

        // grabing values        
       
        $posted_date=ctl_get_story_date($post_id,$date_formats);       
    
        //Story Type
        $ctl_story_type = get_post_meta($post_id, 'story_type', true);
        $ctl_story_date = isset($ctl_story_type['ctl_story_date'])?$ctl_story_type['ctl_story_date']:'';       

        //Story Media
        $ctl_story_media = get_post_meta($post_id, 'story_media', true);
        $story_format = isset($ctl_story_media['story_format'])?$ctl_story_media['story_format']:'';
        $img_cont_size = isset($ctl_story_media['img_cont_size'])?$ctl_story_media['img_cont_size']:'';
        $container_cls=isset($img_cont_size) ? $img_cont_size : "full";

        // Extra Settings
        $ctl_extra_settings = get_post_meta($post_id, 'extra_settings', true);
        $custom_link = isset($ctl_extra_settings['story_custom_link']['url'])?$ctl_extra_settings['story_custom_link']['url']:'';        
        $ctl_story_color = isset($ctl_extra_settings['ctl_story_color'])?$ctl_extra_settings['ctl_story_color']:'';
        
        $story_id="story-id-".$post_id;
        $i++;

        // genrating dynamic styles
        $s_styles.=CTL_H_Styles::ctl_h_story_styles($post_id ,$layout,$design,$timeline_skin);
       
        //read more link html
          if($r_more=="yes"){
            if(isset($custom_link)&& !empty($custom_link)){
                $target = isset($ctl_options_arr['story_content_settings']['story_link_target'])?$ctl_options_arr['story_content_settings']['story_link_target']:'_blank';   
                $target =  isset($ctl_extra_settings['story_custom_link']['target'])?$ctl_extra_settings['story_custom_link']['target']:$target; 
   
                $slink_s='<a target="'.$target.'" title="'.esc_attr(get_the_title()).'" href="'.esc_url($custom_link).'">';
                $slink_e='</a>';
            }else{
            $slink_s='<a target="'.$target.'" title="'.esc_attr(get_the_title()).'" href="'.esc_url(get_the_permalink()).'">';
             $slink_e='</a>';
                }
          } 
       
          // on load first active story
        $selected='';
        if($i==1){
            $selected='selected';
        }

        // grabing html and generating html for later use
        $clt_icon=''; 
        $icon='';
        if ($icons == "YES") {
            $icon=ctl_post_icon($post_id,$default_icon);
            $clt_icon .='<span class="icon-placeholder">'.$icon.'</span> ';
         }
       
   // if stories based upon custom order 
   $post_date = explode( '/', get_the_date( $ctl_story_date ) ); 
   $year_navigtion='';
   $dates_year_li='';
  if ( isset( $post_date[ $year_position ] )) {
	$post_year = (int) $post_date[ $year_position ];
	if ( $post_year != $display_year ) {
		$display_year  = $post_year;
		$ctle_year_lbl = sprintf( '<span  class="ctl-timeline-date">%s</span>', $post_year );
		if ( $pagination == 'ajax_load_more' && $last_year == $post_year ) {
			$dates_year_li .= '';
            $year_navigtion.='';
		} else {
			if ( $hr_year_label == 'show' && $based!="custom" ) {
				$dates_year_li .= '<div data-cls="sc-nv-' . esc_attr( $design ) . ' ' . esc_attr( $wrp_cls ) . '" class="timeline-year scrollable-section ' . esc_attr( $design ) . '-year" data-section-title="' . esc_attr( $post_year ) . '" id="year-' . esc_attr( $post_year ) . '">' . apply_filters( 'ctl_story_year', $ctle_year_lbl ) . '</div>';
                $year_navigtion.='<li data-type="horizontal" class="cth-year-filters " data-term-slug="'.esc_attr($post_year).'"><a>'.esc_attr($post_year).'</a></li>';
			}
		}
	}
}
$year_label.=$year_navigtion;
 if($based=="custom"){       
        $ctl_story_type = get_post_meta($post_id, 'story_type', true);
        $ctl_story_lbl = isset($ctl_story_type['ctl_story_lbl'])?$ctl_story_type['ctl_story_lbl']:'';
        $ctl_story_lbl2 = isset($ctl_story_type['ctl_story_lbl_2'])?$ctl_story_type['ctl_story_lbl_2']:'';
        
        $lb1= '<span class="custom_story_lbl">'.__($ctl_story_lbl,'cool-timeline').'</span>';
        $lb2= '<span class="custom_story_lbl_2">'.__($ctl_story_lbl2,'cool-timeline'). '</span>';
       
        if($active_design=='design-7'){
             $dates_li .='<li id="' . esc_attr($story_id ). '" class="ht-dates-'.esc_attr($design).'">'.$dates_year_li.$clt_icon;
              if(  $r_more=="yes"){
                $dates_li.='<a ref="minimal_glightbox" href="#ctl-'.esc_attr($story_id).'">';
                 }
            $dates_li.='<span class="ctl-main-story-date ' . esc_attr($selected ). '">'. $lb1.$lb2.'</span>
            <div class="ctl-main-story-title">'.get_the_title().'</div>';
             if(  $r_more=="yes"){
                $dates_li.='</a>';
                }
            $dates_li.='</li>';

        }else{
        $dates_li .='<li id="' . esc_attr($story_id ). '" class="ht-dates-'.esc_attr($design).'" data-year="'.$post_year.'" data-date="' . esc_attr($story_id ). '">'.$dates_year_li.$clt_icon.'<span class="ctl-story-time ' . esc_attr($selected ). '"  data-date="' .esc_attr($story_id). '" >'. $lb1.$lb2.'</span></li>';
        }
}else{
    // if date based stories
    // horizontal tm dates navigation html
    $term_obj_list = get_the_terms(get_the_id(), 'ctl-stories' );
    foreach($term_obj_list as $key=>$value){
        $cate_slug = $value->slug;
    }

     if($active_design=='design-3'||$active_design=='design-4'||$active_design=='design-6') {
            $dates_li .= ' <li class="ht-dates-'.esc_attr($design).'" id="' . esc_attr($story_id ). '" data-year="'.$post_year.'" data-date="' . esc_attr($story_id ). '">'.$dates_year_li.$clt_icon.'<span class="ctl-story-time ' . esc_attr($selected ). '"  data-date="' .esc_attr($story_id). '" ><div class="ctl-tooltips"><span>'. apply_filters('ctl_story_dates',$posted_date).'</span></div></span></li>';

        }else if($active_design=='design-7'){
                $dates_li .= ' <li  id="' . esc_attr($story_id ). '" class="ht-dates-'.esc_attr($design).'" data-year="'.$post_year.'" data-term-slug="'.esc_attr($cate_slug).'">'.$dates_year_li.$clt_icon;
             if(  $r_more=="yes"){
                    $dates_li.='<a class="minimal_glightbox" href="#ctl-'.esc_attr($story_id).'">';
               }
                $dates_li.='<div class="ctl-main-story-date"><span class="minimal-date">'.$posted_date.'</span></div>';
                $dates_li.='<div class="ctl-main-story-title">';
                $dates_li.=esc_html(get_the_title());
                $dates_li.='</div>';
                if(  $r_more=="yes"){
                    $dates_li.='</a>';
                }
                $dates_li .= '</li>';
        } else{
             $dates_li .= ' <li  id="' . esc_attr($story_id ). '" class="ht-dates-'.esc_attr($design).'" data-year="'.$post_year.'" data-date="' . esc_attr($story_id ). '" data-term-slug="'.esc_attr($cate_slug).'">'.$dates_year_li.$clt_icon.'<span class="ctl-story-time ' . esc_attr($selected ). '"  data-date="' .esc_attr($story_id). '" >'. apply_filters('ctl_story_dates',$posted_date).'</span></li>';
            }
         }

    // horizontal timeline story content HTML
    if($active_design=='design-7'){
    $ctl_html.='<div id="ctl-'.esc_attr($story_id).'" class="ctl_hide"><div class="ctl-popup-content">';
    }else{
     $ctl_html .= '<li id="' . esc_attr($story_id ). '-content"  class="ht-'.esc_attr($design).'" data-term-slug="'.esc_attr($cate_slug).'">';
     if($active_design == "design-6"){
        $ctl_html .= '<div class="ctl-arrow-timeline"></div>';
     }
    }

     $ctl_html .= '<div class="timeline-post '.esc_attr($post_skin_cls).' ht-content-'.esc_attr($design).'">';
       
     // above title for default and design 2
     if($active_design=="default" || $active_design=="design-2") { 
            $ctl_html .= '<h2 class="content-title">'.$slink_s . esc_html(get_the_title()) .$slink_e.'</h2>';
      }else if($active_design=="design-7"){

          
         if($based=="custom"){
            $ctl_html .='<div class="popup-sublabels">'. $lb1 .' - '.$lb2.'</div>';
         }else{
            $ctl_html .='<div class="popup-posted-date">'. apply_filters('ctl_story_dates',$posted_date).'</div>';
            }
            $ctl_html .= '<h2 class="popup-content-title">' . esc_html(get_the_title()) .'</h2>';
        }
     $ctl_html .= '<div class="ctl_info event-description '.esc_attr($container_cls) .'">';

     // dynamic content based upon story type
        if ($story_format == "video") {
             $ctl_html .=clt_story_video($post_id);
         } elseif ($story_format == "slideshow") {  
           
              $ctl_html .=clt_story_slideshow($post_id,$layout,$ctl_options_arr,$active_design);

         }else{
                if($active_design=="design-7"){
                 $ctl_html .=ctl_minimal_featured_img($post_id,$img_cont_size);
                }else{
                $ctl_html .=clt_story_featured_img($post_id,$ctl_options_arr);
                }
             }
             // below title for design 3 and 4
             if($active_design=='design-3'|| $active_design=='design-4') {
                $ctl_html .= '<div class="ctl-description-d-4"><h2 class="content-title-simple">'.$slink_s. esc_html(get_the_title()) .$slink_e.'</h2>';
            }
               if( $active_design=='design-4') {
                if ($story_content=="full") {
                    $ctl_html .= apply_filters('the_content', $post->post_content);
                   } else {
                   $ctl_html .= "<p>" .apply_filters('ctl_story_excerpt',get_the_excerpt()) . "</p></div>";
                    }
            }
    


        if($active_design!='design-4') {
            $ctl_html .= '<div class="content-details">';
           
             if($active_design=='design-5'|| $active_design=='design-6') {
            $ctl_html .= '<h2 class="content-title-simple">'.$slink_s. esc_html(get_the_title()) .$slink_e.'</h2>';
                 }

            if($active_design=="design-7"){
                $ctl_html .= "<div class='ctl_popup_desc'>" .apply_filters('the_content', $post->post_content). "</div>";
            }else{
                if ($story_content=="full") {
                  $ctl_html .= apply_filters('the_content', $post->post_content);
                 } else {
                 $ctl_html .= "<p>" .apply_filters('ctl_story_excerpt',get_the_excerpt()) . "</p>";
                  }
            }
           $ctl_html.='</div>';
        }
      
          $ctl_html .= '</div></div>';

         if($active_design=='design-7'){
            $ctl_html .= '</div></div>';
         }else{
        $ctl_html .='</li>';
         }
        $post_content = '';
        // dynamic content end
    endwhile;
    wp_reset_postdata();
    // lopp end

// main wrapper classes
$timeline_id=uniqid();
// $category= $attribute['category'] ?$attribute['category']:'all-cats';
$ctl_category = $attribute['category'];
$timeline_wrp_id="ctl-horizontal-slider-".$timeline_id;
$sl_dir=is_rtl() ? "rtl":"";
$rtl=is_rtl()?"true":"false";

     $main_wrp_cls=array();
    $main_wrp_cls[]="cool-timeline-horizontal";
    $main_wrp_cls[]=esc_attr($wrp_cls);
    if(isset($ctl_category)){
    $main_wrp_cls[]=esc_attr($ctl_category);
    }
    $main_wrp_cls[]=esc_attr($design_cls);
    $main_wrp_cls=apply_filters('ctl_wrapper_clasess',$main_wrp_cls);  

$clt_hori_view ='<!-- ========= Cool Timeline PRO '.CTLPV.' ========= -->';
// HT Settings

$clt_hori_view .='<div class="clt_preloader" style="width: 100%; min-height: 300px; display: flex; justify-content: center; align-items: center;">
<img alt="Preloader" src="'.CTP_PLUGIN_URL.'assets/images/clt-compact-preloader.gif" style="width: 100px; height: 100px;"></div>';
$clt_hori_view .= '<div  style="opacity:0"
class="'.implode(" ",$main_wrp_cls).'"  
id="'.esc_attr($timeline_wrp_id).'" 
data-rtl="'.$rtl.'"
date-slider="ctl-h-slider-'.esc_attr($timeline_id).'" 
data-nav="nav-slider-'.esc_attr($timeline_id).'" 
data-items="'.esc_attr($items).'"
data-start-on="'.esc_attr($attribute['start-on']).'" 
data-autoplay="'.esc_attr($attribute['autoplay']).'"
data-autoplay-speed="'.esc_attr($attribute['autoplay-speed']).'"
data-max-num-pages="'.$ctl_loop->max_num_pages.'"
data-wrapper="'.$main_wrp_id.'"
pagination="'.$pagination.'"
filters="'.$filters.'"'
.$lineFilling.'
>

<div   class="timeline-wrapper '.esc_attr($wrapper_cls).' '.esc_attr($itcls).'" >';

// if($filters=="yes"){
//     $clt_hori_view.=ctl_categories_filters($timeline_id, $taxo="ctl-stories",$select_cat=$ctl_category ,$type="story-tm",$layout,$filter_categories);
// }
if($navigtion=="show" && $year_label != '' && $based!="custom"){
    $clt_hori_view.='<div class="year-nav-wrp ctl-navigation-'.esc_attr($navigtion_position).'" data-id="'.$timeline_id.'"><ul class="ctl_h_yearNav" id="year-slder-'.esc_attr($timeline_id).'">'.$year_label.'</ul></div>';
}

// wrapper for  design 4
if($active_design=="design-4") {
    $clt_hori_view .= '<div  class="wrp-desgin-4" dir="'.esc_attr($sl_dir).'">';
}else{
    $clt_hori_view .= '<div class="clt_carousel_slider"  dir="'.esc_attr($sl_dir).'">';
}
     
// dates navigation for all designs
if($active_design=='design-7'){
    $clt_hori_view .= '<ul class="ctl_minimal_cont" id="nav-slider-'.esc_attr($timeline_id). '" >';
    $clt_hori_view .= $dates_li;
    $clt_hori_view .= '</ul>';
}else if($active_design!='design-4') {
    $clt_hori_view .= '<ul class="ctl_h_nav" id="nav-slider-'.esc_attr($timeline_id). '">';
    $clt_hori_view .= $dates_li;
    $clt_hori_view .= '</ul></div>';
}  


// stories content for all designs
if($active_design=='design-7') {
        $clt_hori_view .=$ctl_html;
         $clt_hori_view .='</div>';
}else{
$clt_hori_view .= '<div  class="clt_caru_slider"  dir="'.esc_attr($sl_dir).'">';
$clt_hori_view .= '<ul class="ctl_h_slides"  id="ctl-h-slider-'.esc_attr($timeline_id).'" data-filter="'.esc_attr($filters).'">';
$clt_hori_view .=$ctl_html;
$clt_hori_view .= '</ul></div>';
}
// Dates navigation for desgin 4
if($active_design=='design-4') {
    $clt_hori_view .= '<ul class="ctl_h_nav" id="nav-slider-' .esc_attr($timeline_id). '">';
    $clt_hori_view .= $dates_li;
    $clt_hori_view .= '</ul></div>';
}
// dynamic styles
$stories_styles='<style type="text/css">'.$s_styles.'</style>';
$clt_hori_view .='</div></div>'.$stories_styles;
$clt_hori_view .='<!-- end  ================================================== -->';

} else {
    $clt_hori_view .= '<div class="no-content"><h4>';
    //$ctl_html_no_cont.=$ctl_no_posts;
    $clt_hori_view .= __('Sorry,You have not added any story yet', 'cool-timeline');
    $clt_hori_view .= '</h4></div>';
}
