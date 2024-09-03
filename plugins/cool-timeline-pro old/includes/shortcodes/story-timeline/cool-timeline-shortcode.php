<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if (!class_exists('CoolTimelineShortcode')) {

    class CoolTimelineShortcode {


        public $assetsObj;
        /**
         * The Constructor
         */
        public function __construct() {
            // register actions
            add_action('init', array($this, 'cooltimeline_register_shortcode'));
             
             /*
              * Include this plugin's public JS & CSS files
              */
              require CTP_PLUGIN_DIR .'includes/shortcodes/common/class-ctl-assets-manager.php';
              
             $this->assetsObj=CTL_Assets_Manager::get_instance();
             $this->assetsObj->registers();

        
            add_filter( 'body_class', array($this, 'ctl_st_body_class') );
           
            // Call actions and filters in after_setup_theme hook
            add_action('after_setup_theme', array($this, 'ctl_pro_read_more'), 999);
            add_filter('excerpt_length', array($this, 'ctl_ex_len'), 999);

          //  add_filter( 'the_content', array($this,'ctl_back_to_timeline'));
        }
      
        /*
          Register Shortcode for cooltimeline 
         */
        function cooltimeline_register_shortcode() {
            add_shortcode('cool-timeline', array($this, 'cooltimeline_view'));

        }
        /*
          Timeline Views
         */
        function cooltimeline_view($atts, $content = null) {
          
            $attribute = shortcode_atts(array(
                'show-posts' => '',
                'order' => '',
                'category' => 0,
                'layout' => 'default',
                'designs'=>'',
                'items'=>'',
                'skin' =>'',
                'type'=>'',
                'icons' =>'',
                'animations'=>'',
                'animation'=>'',
                'date-format'=>'',
                'based'=>'default',
                'story-content'=>'',
                'pagination'=>'default',
                'year-navigation'=>'hide',
                'navigation-position'=>'',
                'year-label'=>'',
                'compact-ele-pos'=>'main-date',
                'filters'=>'no',
                'line-filling'=>'false',
                'autoplay'=>'false',
                'autoplay-speed'=>3000,
                'start-on'=>0,
                'filter-categories'=>'',
               ), $atts);
                // set vars for later use  
              $output = ''; $ctl_html = ''; $ctl_format_html = '';
              $ctl_animation='';$last_year='';  $alternate=0;
              $ctl_avtar_html = ''; $timeline_id = '';$cls_icons='';
               $design_cls='';
               $pagination        = $attribute['pagination'];
               $tm_active_design  = ctl_set_default_value($attribute['designs'],'default');
               $filters           = ctl_set_default_value( $attribute['filters'], 'no');
               $icons             = ctl_set_default_value( $attribute['icons'], 'YES');
               $ctl_category      = ctl_set_default_value($attribute['category'],'');
               $filter_categories = !empty($attribute['filter-categories'])?explode(",",$attribute['filter-categories']):'all';
               $cls_icons         = $icons=='YES'?'icons_yes':'icons_no';
               $old_animations    = array("bounceInUp","bounceInDown","bounceInLeft","bounceInRight","slideInDown","slideInUp",
                                    "bounceIn","slideInLeft","slideInRight","shake","wobble","swing","jello","flip","fadein",
                                    "rotatein","zoomIn");
             if(isset($attribute['type'])&& !empty($attribute['type'])){

                if($attribute['type']=="default"){
                   $layout=$attribute['layout'];
                    $type=$attribute['layout'];
                  }else{
                     $layout=$attribute['type'];
                      $type=$attribute['type'];
                  }
                }else{
                  $type = ctl_set_default_value( $attribute['type'], 'default' );
                  $layout = ctl_set_default_value( $attribute['layout'], 'default' );
                }

              // creates classes based on design type
              if($tm_active_design)
              {
                  $design_cls='main-'.$tm_active_design;
                  $design=$tm_active_design;
                }else{
                  $design_cls='main-default';
                  $design='default';
                }

                // set stories animations
                               
                if (isset($attribute['animations'])) {
                  $ctl_animation=$attribute['animations'];
              }elseif($attribute['animation']){
                $ctl_animation=$attribute['animation'];
               }else{
                $ctl_animation ='fade-in';
                   }
                if(in_array($ctl_animation,$old_animations)){
                  $ctl_animation ='fade-in';
                }

            /*
              Loading CSS and JS
            */
             //loading all required assets
             $this->assetsObj->ctl_load_global_assets();
             // loading layout specifc assets
             $this->assetsObj->clt_conditional_assets($tm_active_design,$ctl_animation,$layout,$type, $filters,$pagination,$attribute['year-navigation']);

            // generates  wp query object
            require('ctl-build-query.php');
              // loads horizontal layout content
           if( $layout=="horizontal"){
             $main_wrp_id='tm-'.$layout.'-'.$tm_active_design.'-'.rand(1,20);
             $uid = substr($main_wrp_id, -2);
             $newUID= str_replace("-","",$uid);
            if($pagination=="ajax_load_more" || $filters == 'yes'){
              wp_localize_script( 'ctl-horizontal-load-more', "ctlloadmore_$newUID",
                 array( 'url' => admin_url( 'admin-ajax.php' ),
                 'attribute'=>$attribute,
                 'nonce' => wp_create_nonce('ctl-ajax-nonce')
                ) );
            }
             $clt_hori_view='';
              require( CTP_PLUGIN_DIR .'includes/shortcodes/common/class-ctl-h-styles.php');
              require('layouts/story-horizontal-layout.php');

             return $clt_hori_view;

            }else {
                // if layout type is vertical
                $main_wrp_id='tm-'.$layout.'-'.$tm_active_design.'-'.rand(1,20);
            
              $uid = substr($main_wrp_id, -2);
              $newUID= str_replace("-","",$uid);
                // if users has enabled ajax load more then pass ajax url and other attributes
             if($pagination=="ajax_load_more" || $filters == 'yes'){
             
              wp_localize_script( 'ctl-ajax-load-more', "ctlloadmore_$newUID",
                 array( 'url' => admin_url( 'admin-ajax.php' ),
                 'attribute'=>$attribute,
                 'nonce' => wp_create_nonce('ctl-ajax-nonce')
                ) );
               }
                // Timeline main title 

                // show category name if category based timeline else show admin dynamic text
                if ($ctl_category) {
                  if(is_numeric($ctl_category)){
                         $ctl_term = get_term_by('id', $ctl_category, 'ctl-stories');
                        }else{
                    $ctl_term = get_term_by('slug', $ctl_category, 'ctl-stories');
                      }
                
                    if (isset($ctl_term->name) && $ctl_term->name == "Timeline Stories") {
                        $ctl_title_text =isset($ctl_options_arr['timeline_header']['title_text'])? $ctl_options_arr['timeline_header']['title_text'] : 'Timeline';
                    } else {
                        $ctl_title_text = isset($ctl_term->name)?$ctl_term->name:"";
                    }
                    $timeline_id = "timeline-$ctl_category";
                } else {
                    // admin dynamic text 
                    $ctl_title_text = isset($ctl_options_arr['timeline_header']['title_text'])? $ctl_options_arr['timeline_header']['title_text'] : 'Timeline';
                    $timeline_id = "timeline-".rand(1,10);
                }
                  
             $ctl_html_no_cont = ''; $layout_wrp = '';
                // add custom wrapper if layout is compact
                if($layout=="compact"){
                    $compact_id="ctl-compact-pro-".rand(1,20);
                    $ctl_html .='<div id="'.$compact_id.'" class="clt-compact-cont"><div class="center-line"></div>';
              }

              //loads content vertical layout 
             require( CTP_PLUGIN_DIR .'includes/shortcodes/common/class-ctl-v-styles.php');
             require("layouts/story-vertical-layout.php");
             
             // add clear fix if layout mode is compact 
              $ctl_html .= '<div  class="end-timeline clearfix"></div>';
                if($layout=="compact"){
                    $ctl_html .='</div>';
                }

                // creating dynamic classes for timeline main wrapper
        
        $main_wrp_cls=array();
        $main_wrp_cls[]="cool_timeline";
        $main_wrp_cls[]="cool-timeline-wrapper";
        $main_wrp_cls[]=$layout_wrp;
        $main_wrp_cls[]=$wrapper_cls;
        $main_wrp_cls[]=$design_cls;
        $main_wrp_cls=apply_filters('ctl_wrapper_clasess',$main_wrp_cls);     
    

     // timeline wrapper html    
    $output .='<!-- ========= Cool Timeline PRO '.CTLPV.' ========= -->';

    // main div with settings
    $output .= '<div style="opacity:0;" 
    data-showposts="'.$attribute['show-posts'].'"
     class="'.implode(" ",$main_wrp_cls).'" 
     id="'. $main_wrp_id.'"  
     data-pagination="' . $enable_navigation . '"  
     data-pagination-position="' . $navigation_position . '"
     data-line-filling="' .esc_attr($attribute['line-filling']). '">';

    // main top title html
     $output .=ctl_main_title($ctl_options_arr,$ctl_title_text,$ttype='default_timeline');
     
     // generate categories html if user have enable cateogry filters
     if($filters=="yes"){
        $taxo="ctl-stories";
        $select_cat=$ctl_category;
        $type="story-tm";
        $output.=ctl_categories_filters($taxo,$select_cat,$type,$layout,$filter_categories,$timeline_id);
      }

      $content_empty_cls=$ctl_loop->have_posts() ? '' : 'ctl_story_empty';
         // timeline content div
     $output .= '<div class="cool-timeline ultimate-style ' . $layout_cls . ' ' . $wrp_cls . ' ' . $content_empty_cls . '">';
     if($layout == 'default' || $layout == 'one-side'){
      $output.='<div class="cool_timeline_start"></div>';
     }
     // preloader container
     $output .='<div  class="filter-preloaders"><img src="'.CTP_PLUGIN_URL.'/assets/images/clt-compact-preloader.gif"></div>';
         // timeline container
     $output .= '<div data-animations="'.$ctl_animation.'"  id="' . $timeline_id . '" class="cooltimeline_cont  clearfix '.$cls_icons.'">';
    
    //  stories content
     $output .= $ctl_html;
     $output .= '</div>';
        

     // stories pagination
        if($pagination=="ajax_load_more"){
            //ajax load more
              $hideIt='';
               if($ctl_loop->max_num_pages<1){
                $hideIt='clt-hide-it';
               }
             $output.='<button data-loading-text="<i class=\'fa fa-spinner fa-spin\'></i>'.__(' Loading','cool-timeline').'" data-max-num-pages="'.$ctl_loop->max_num_pages.'" 
             data-timeline-type="'.$layout.'"   class="ctl_load_more '.$hideIt.'">'.__('Load More','cool-timeline').'</button>';
            
                }else{
              if ($enable_pagination == "yes") {
                  // default numbers pagination
                  if (function_exists('ctl_pro_pagination')) {
                      $output .= ctl_pro_pagination($ctl_loop->max_num_pages, "", $paged);
                  }
              }
              }
            $output .= $ctl_html_no_cont;
            if($layout == 'default' || $layout == 'one-side'){
              $output.='<div class="cool_timeline_end"></div><div class="ctl_center_line_filling"></div>';
            };
            $output .= '</div></div>  <!-- end
================================================== -->';
              // loads dynamic style
              $stories_styles='<style type="text/css">'.$story_styles.'</style>';
              
              // return final output
              return $output.$stories_styles;

            }

        }

        /*
          Read more button for timeline stories
         */

        function ctl_pro_read_more() {

            // add more link to excerpt
            function ctl_p_excerpt_more($more) {
                global $post;
                $ctl_options_arr = get_option('cool_timeline_settings');
                $target = isset($ctl_options_arr['story_content_settings']['story_link_target'])?$ctl_options_arr['story_content_settings']['story_link_target']:'_self';
                $r_more=isset($ctl_options_arr['story_content_settings']['display_readmore'])?$ctl_options_arr['story_content_settings']['display_readmore']:"yes";
                $read_more='';
                if(isset($ctl_options_arr['story_content_settings']['read_more_lbl'])&& !empty($ctl_options_arr['story_content_settings']['read_more_lbl']))
                {
                  $read_more=__($ctl_options_arr['story_content_settings']['read_more_lbl'],'cool-timeline');
                } else{
                  $read_more=__('Read More', 'cool-timeline');
                }  
                
                if (is_object( $post ) && $post->post_type == 'cool_timeline' && !is_single()) {

                  // Extra Settings
                  $ctl_extra_settings = get_post_meta($post->ID, 'extra_settings', true);
                  $custom_link = isset($ctl_extra_settings['story_custom_link']['url'])?$ctl_extra_settings['story_custom_link']['url']:'';        
                  
                    if ($r_more == 'yes') {

                    
                    if($custom_link){
                        $read_more = isset($ctl_extra_settings['story_custom_link']['text'])?$ctl_extra_settings['story_custom_link']['text']:$read_more;        
                        $target =  isset($ctl_extra_settings['story_custom_link']['target'])?$ctl_extra_settings['story_custom_link']['target']:$target; 
                        return '..<a  target="'. esc_attr($target) .'" class="read_more ctl_read_more" href="' . esc_url($custom_link) . '">' .$read_more. '</a>';
                      }else{
                        return '..<a class="read_more ctl_read_more" target="'.esc_attr($target).'" href="' . esc_attr(get_permalink($post->ID)) . '">' .$read_more. '</a>';
                      }
                    }
                } else {
                    return $more;
                }
            }

            add_filter('excerpt_more', 'ctl_p_excerpt_more', 999);
        }

        function ctl_ex_len($length) {
            global $post;           
           
            if ( is_object( $post ) && $post->post_type == 'cool_timeline' && !is_single()) {
              $ctl_options_arr = get_option('cool_timeline_settings');
              $ctl_content_length = isset($ctl_options_arr['story_content_settings']['content_length']) ? $ctl_options_arr['story_content_settings']['content_length'] : 100;
              return $ctl_content_length;
            }
            return $length;
        }

    

      public function ctl_st_body_class( $c ) {
        global $post;
        if( isset($post->post_content) && has_shortcode( $post->post_content, 'cool-content-timeline' )  )
        {
            $c[] = 'cool-ct-page';
        }else if( isset($post->post_content) && has_shortcode( $post->post_content, 'cool-timeline' ) ) {
            $c[] = 'cool-timeline-page';
        }
        return $c;
    }
    }

} // end class


