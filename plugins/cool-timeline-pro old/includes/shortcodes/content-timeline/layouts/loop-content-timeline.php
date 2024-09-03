<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
/*
 * settings
 */
    // global setting 
  require(CTP_PLUGIN_DIR.'includes/shortcodes/common/settings-vars.php');
  $i=0;
    $year_label='';
    $category_id ='';
    $ctl_format_html = '';
    $output = '';$display_year ='';
    $wrp_cls = '';
    $ctl_avtar_html = '';$timeline_id = '';$clt_icons='';$story_content='';
    $row=0;
    $post_skin_cls = '';
    $dates_li ='';
    $hr_year_label=ctl_set_default_value($attribute['year-label'],'hide');
    $ctl_options_arr = get_option('cool_timeline_settings');
    $target = isset($ctl_options_arr['story_content_settings']['story_link_target'])?$ctl_options_arr['story_content_settings']['story_link_target']:'_self';
    $first_story_position = isset($ctl_options_arr['first_story_position'])?$ctl_options_arr['first_story_position']:"right";
   $date_formats =ctl_date_formats($attribute['date-format'],$ctl_options_arr);
  $story_content=$attribute['story-content'];
  $post_category = $attribute['post-category'];
  $post_taxonomy = $attribute['taxonomy'];
  $stories_images_link='';
    if(isset($ctl_options_arr['story_media_settings']['stories_images'])){
     $stories_images_link = ctl_set_default_value($ctl_options_arr['story_media_settings']['stories_images'],'');
    }
  $active_design= ctl_set_default_value($attribute['designs'],'default');
  $timeline_skin = ctl_set_default_value($attribute['skin'], 'default');
  $ctl_icons     = ctl_set_default_value($attribute['icons'],'YES');
  $cls_icons     = $ctl_icons=='YES'?'icons_yes':'icons_no';
  if($pagination=="ajax_load_more"){
      $i=$alternate+1;
    }

    //  generate skin classes
if ($timeline_skin == "light") {
    $wrp_cls = 'light-timeline';
    $wrapper_cls = 'light-timeline-wrapper';
    $post_skin_cls = 'white-post';
} else if ($timeline_skin == "dark") {
    $wrp_cls = 'dark-timeline';
    $wrapper_cls = 'dark-timeline-wrapper';
    $post_skin_cls = 'black-post';
} else {
    $wrp_cls = 'white-timeline';
    $post_skin_cls = 'light-grey-post';
    $wrapper_cls = 'white-timeline-wrapper';
  }  
  
  
  /*
    Main content timelne posts query

  */

  $args['post_type'] =$attribute['post-type'];
  $args['post_status'] = array('publish');

  if ($attribute['show-posts']) {
      $args['posts_per_page'] = $attribute['show-posts'];
  } else {
      $args['posts_per_page'] = $ctl_post_per_page;
  }

 if ($enable_pagination == "yes") {
       if ( get_query_var('paged') ) { 
          $paged = get_query_var('paged'); 
          } elseif ( get_query_var('page') ) { 
          $paged = get_query_var('page'); 
          } else { 
          $paged = 1; 
          }
         $args['paged'] = $paged;
      }

  if (isset($_POST['page']) && $pagination == "ajax_load_more") {
      $args['paged']=esc_attr( $_POST['page'] );
  }

  $stories_order = '';
  if ($attribute['order']) {
      $args['order'] = $attribute['order'];
      $stories_order = $attribute['order'];
  } else {
      $args['order'] = $ctl_posts_orders;
      $stories_order = $ctl_posts_orders;
  }
if(!empty($post_taxonomy)&& !empty($post_category)) {

     if ( strpos( $post_category, "," ) !== false ) {
        $post_category = explode( ",", $post_category );
        $post_category = array_map( 'trim',$post_category );
      } else {
        $post_category = $post_category;
        }
        if(empty($attribute['category'])||$attribute['category']='all'){
          $cate = $post_category;
         }else{
          $cate =  $attribute['category'];
         }
    $args['tax_query'] = array(array(
        'taxonomy' =>$post_taxonomy,
        'field' => 'slug',
        'terms' => $cate));
        }

  if(!empty($attribute['tags'])) {
      $args['tag'] =$attribute['tags'];
  }

  $ctl_loop = new WP_Query(apply_filters( 'ctl_content_timeline_query',$args));
// loop start
if ($ctl_loop->have_posts()) {
  while ($ctl_loop->have_posts()) : $ctl_loop->the_post();
       global $post;
       $post_id=$post->ID;
        $container_cls = 'full';
        $compact_year=''; 
        $ctl_v_html='';
        $ctl_h_html='';
        $posted_date=get_the_date(__("$date_formats",'cool-timeline'));
        $post_date = explode('/',get_the_date(__("D/M/Y",'cool-timeline')));
        $post_date_def =get_the_date(__("d/m/Y,H:i",'cool-timeline'));
        $post_year = (int)$post_date[$year_position];
        $timeline_post_id='timeline-post-id-'.$post_id;
           $p_id="post-".$post_id;
        
      
          if ($story_content == 'full') {
         $post_content = apply_filters('the_content', $post->post_content);
         } else {
            $post_content = ctl_get_content_excerpt($ctl_options_arr, $post->post_excerpt);
           }
    
          $s_l_close='';
         if ($stories_images_link =="popup") {

            $img_f_url = wp_get_attachment_url(get_post_thumbnail_id($post_id));

            $story_img_link = '<a data-glightbox="' . esc_attr(get_the_title()). '"  href="' . $img_f_url . '" class="ctl_glightbox">';
            $s_l_close='</a>';

        } else if ($stories_images_link == "single") {
            $story_img_link = '<a target="'.$target.'" title="' . esc_attr(get_the_title()) . '"  href="' . get_the_permalink() . '" class="single-page-link">';
            $s_l_close='</a>';
        } else if ($stories_images_link == "disable_links") {
             $story_img_link = '';
              $s_l_close='';
        }
        else {
            $s_l_close='';
            $story_img_link = '<a target="'.$target.'" title="' . esc_attr(get_the_title()) . '"  href="' . get_the_permalink() . '" class="">';
         }

          if ( has_post_thumbnail($post_id) && !empty(get_the_post_thumbnail($post_id))) {
         $ctl_format_html .= '<div class="full-width">';
        $ctl_format_html.=$story_img_link;
        $ctl_format_html.=get_the_post_thumbnail($post_id,apply_filters('cool_timeline_story_img_size','large'), array( 'class' => 'story-img' ) );
         $ctl_format_html.='</a></div>';
         }


        $condition = $i % 2 == 0;
        if($first_story_position =='left'){
          $condition = $i % 2 != 0;
        }
        if ($condition) {
          $even_odd = "even";
        } else {
          $even_odd = "odd";
        }


        $selected='';
       if($i==1){
          $selected='selected';
        }
         $icon=ctl_post_icon($post_id,$default_icon);
        $clt_icon='';
        if ( $ctl_icons == "YES") {
          $clt_icon .='<span class="icon-placeholder">'.$icon.'</span> ';
         }

     $categories = get_the_category($post_id);
        if(isset($categories) && !empty($categories)){
        foreach($categories as $category) {
            $category_id = $category->term_id;
        }
         }
     $icon=ctl_post_icon($post_id,$default_icon);
     $compt_cls=$layout=="compact"?"timeline-mansory":'';
        // dynamic content classes
        $p_cls=array();
        $p_cls[]="timeline-post";
        $p_cls[]=esc_attr($even_odd);
        $p_cls[]=esc_attr($post_skin_cls);
        $p_cls[]=esc_attr($cls_icons);
        $p_cls[]='post-'.esc_attr($post_id);
        $p_cls[]='cat-id-'.esc_attr($category_id);
        $p_cls[]=$layout=="compact"?"timeline-mansory":'';
        $p_cls[]= esc_attr($design).'-meta';
         $p_cls=apply_filters('ctl_content_timeline_clasess',$p_cls);
       

    // Vertical layout html
     if ($layout != "horizontal"){
            /// vertical layout html end here
             require('content/ct-vertical-content.php');
               $ctl_html.= $ctl_v_html;
              }else{
                // Horizontal layout html
                
                require('content/ct-horizontal-content.php');
                $ctl_html.=$ctl_h_html;
              }
              
              
              if ($row >= 3) {
                $row = 0;
              }
              $row++;
              $i++;
              $ctl_format_html = '';
              $ctl_h_html='';
              $ctl_v_html='';
              $post_content = '';
            endwhile;
            wp_reset_postdata();
          } else {
            $ctl_html_no_cont ='';
            $ctl_html_no_cont .= '<div class="no-content"><h4>';
            //$ctl_html_no_cont.=$ctl_no_posts;
            $ctl_html_no_cont .= __('Sorry,You have not added any story yet', 'cool-timeline');
            $ctl_html_no_cont .= '</h4></div>';
          }
          $ctl_custom_pagi='';

$ctl_html_empty='';
$ctl_cust_pagi_array=array();
if($pagination != 'ajax_load_more'){
    $ctl_cust_pagi_array['total_page']=$ctl_loop->max_num_pages;
    $ctl_cust_pagi_array['current_page']=1;
    if($ctl_loop->max_num_pages > 1){
        $ctl_custom_pagi  .= '<nav class="custom-pagination" data-loading_img="'.CTP_PLUGIN_URL.'/assets/images/clt-compact-preloader.gif" data-timeline-type="'.$layout.'">';
        $ctl_custom_pagi .= '</nav>';
    }else if($ctl_loop->post_count < 1){
        $ctl_custom_pagi.=null;
        $ctl_html_empty.= '<h4>'.__('Sorry,You have not added any story yet', 'cool-timeline').'<h4>';
    };
}
