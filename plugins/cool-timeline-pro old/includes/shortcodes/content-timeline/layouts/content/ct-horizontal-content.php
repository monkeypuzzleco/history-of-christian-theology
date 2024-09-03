<?php 
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
$dates_year_li ='';
$year_navigtion='';
$categories = get_the_terms( get_the_id(), 'category' );
foreach($categories as $category){
  $pcat_slug = $category->slug;
}

if ($post_year != $display_year) {
  $display_year = $post_year;
  $ctle_year_lbl = sprintf('<span class="ctl-timeline-date">%s</span>', $post_year);
  if( $pagination=="ajax_load_more" && $last_year==$post_year)
  {
      $dates_year_li.='';
      $year_navigtion.='';
  }else{
     if($hr_year_label == 'show'){
      $dates_year_li .= '<div data-cls="sc-nv-'.esc_attr($design).' '.esc_attr($wrp_cls).'" 
      class="timeline-year  scrollable-section '.esc_attr($design).'-year" data-section-title="' . esc_attr($post_year) . '" 
      id="clt-' . esc_attr($post_year) . '"><div class="icon-placeholder">' . $ctle_year_lbl . '</div>
         <div class="timeline-bar"></div>
          </div>';
      $year_navigtion.='<li data-type="horizontal" class="cth-year-filters " data-term-slug="'.esc_attr($post_year).'"><a>'.esc_attr($post_year).'</a></li>';
     }
  }
}
$year_label.=$year_navigtion;
if(in_array($active_design,array('design-3','design-4','design-6'))){
  
	$dates_li .= ' <li class="ht-dates-'.esc_attr($design).'" data-year="'.$post_year.'" " data-date="' . esc_attr($p_id ). '">'.$dates_year_li.$clt_icon.'<span class="ctl-story-time ' . esc_attr($selected ). '"  data-date="' .esc_attr($p_id). '" ><div class="ctl-tooltips"><span>'. $posted_date.'</span></div></li>';
	}else{
	 $dates_li .= ' <li class="ht-dates-'.esc_attr($design).'" data-year="'.$post_year.'" " data-date="' . esc_attr($p_id ). '">'.$dates_year_li.$clt_icon.'<span class="ctl-story-time ' . esc_attr($selected ). '"  data-date="' .esc_attr($p_id). '" >'. $posted_date.'</li>';
	}
      $ctl_h_html .='<li data-date="'.esc_attr($timeline_post_id).'" class="ht-'.esc_attr($design).'" data-term-slug="'.esc_attr($pcat_slug).'">';
       $ctl_h_html .= '<!-- .timeline-post-start-->';
        $ctl_h_html .= '<div id="post-'.esc_attr($post->ID).'" class="'.implode(" ",$p_cls).'"><div class="timeline-meta"></div>';
     
       $ctl_h_html .= '<div id="' . esc_attr($row). '" class="timeline-content  clearfix ' . esc_attr($even_odd) . '  ' . esc_attr($container_cls) . ' ' . $design . '-content">';
       
      if(in_array($active_design,array('default','design-2','design-3'))) {
       	$ctl_h_html .= '<h2 class="content-title"><a target="'.$target.'" href="' .esc_url(get_the_permalink()). '">' . esc_html(get_the_title()) . '</a></h2>';
        }
     	  $ctl_h_html .= '<div class="ctl_info event-description ">';
          $ctl_h_html .= $ctl_format_html;
        
         $ctl_h_html .= '<div class="content-details">';
       	if(in_array($active_design,array('design-4','design-5','design-6'))) {
            $ctl_h_html .= '<h2 class="content-title-simple"><a target="'.$target.'" href="' .esc_url(get_the_permalink()). '">' . esc_html(get_the_title()) . '</a></h2>';
          }

            $ctl_h_html .=$post_content;
            $ctl_h_html .= '<div class="post_meta_details">';
         if($post_meta=="yes"){
            if(!empty($post_taxonomy)&& $post_taxonomy=='category') {
                $ctl_h_html .= ctl_entry_taxonomies();
                $ctl_h_html .= ctl_post_tags();
                }
          }
        $ctl_h_html .= '</div></div>';
        $ctl_h_html .= '</div></div><!-- timeline content -->
        </div></li><!-- .timeline-post-end -->';