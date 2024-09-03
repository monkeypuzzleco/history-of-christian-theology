<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}


//Display Date Function
function cp_timeline_date($attributes){
    global $post;
    $post_id = $post->ID;
    if( isset( $attributes['displayPostDate'] ) && $attributes['displayPostDate'] ){
        if(isset($attributes['dateFormat']) ){
            $date = $attributes['dateFormat'] == 'custom' ? get_the_date($attributes['customDateFormat'],$post_id) :  get_the_date($attributes['dateFormat'],$post_id);
        }
        if($attributes['showDateType'] == 'custom_meta'){
            $meta = get_post_meta($post_id,$attributes['customMeta']);
                $date = $meta ? $meta[0] : "";
        }
        ?>
        <p><?php echo esc_html($date); ?></p>
        <?php
    }
}

//Display Title Function
function cp_timeline_title($attributes){
    if( isset( $attributes['displayPostTitle'] ) && $attributes['displayPostTitle'] ){
        $title= get_the_title() ? get_the_title() : "(Untitled)";
        if(isset($attributes['titleLink']) && $attributes['titleLink']){
            $link=  get_the_permalink();
            $target = ( isset( $attributes['linkTarget'] ) && ( true === $attributes['linkTarget'] ) ) ? '_blank' : '_self';
            ?>
        <a  href=<?php echo esc_url($link)?> target=<?php echo esc_attr($target) ?>><h3><?php echo esc_html($title) ?></h3></a>
        <?php
        }
        else{
        ?>
        <h3><?php echo esc_html($title) ?></h3>
        <?php
        }
    }
}
//Display Excerpt Function
function cp_timeline_excerpt($attributes){

    if( isset( $attributes['displayPostExcerpt'] ) && $attributes['displayPostExcerpt'] ){
        $excerpt = wp_trim_words( get_the_excerpt(), $attributes['exerptLength'] );
        if ( ! $excerpt ) {
            $excerpt = null;
        }
        ?>
        <p><?php echo wp_kses_post( $excerpt ); ?></p>
        <?php
    }

    
}


//Display Icon Function
function cp_timeline_icon($attributes){
    
    if($attributes['icon'] !== "" && $attributes['iconToggle'] == "true"){
              ?>
        <span class="timeline-block-render-icon" ><?php CP_Timeline_Helper::render_svg_html( $attributes['icon'] ); ?></span>
        <?php
    } 
}
//Display Link Function
function cp_timeline_link($attributes){
    $target = ( isset( $attributes['linkTarget'] ) && ( true === $attributes['linkTarget'] ) ) ? '_blank' : '_self';
    if( isset( $attributes['displayPostLink'] ) && $attributes['displayPostLink'] ){
        $link=  get_the_permalink();
        ?>
        <div class='cp-timeline_link_parent'	>
            <a class='cp-timeline_link' href=<?php echo esc_url($link)?> target=<?php echo esc_attr($target) ?>>
            <?php echo esc_html($attributes['readMoreText']) ?>
        </a>
        </div>
        <?php
    }
}

//Display Image Function
function cp_timeline_image($attributes){
    	if ( ! get_the_post_thumbnail_url() ) {
				return;
			}
            if($attributes['imageSize'] != 'custom'){
                echo wp_get_attachment_image( get_post_thumbnail_id(), $attributes['imageSize'] ); 
                   }else{
                       echo wp_get_attachment_image( get_post_thumbnail_id(),[$attributes['imageWidth'],$attributes['imageHeight']] );  
                   }
}