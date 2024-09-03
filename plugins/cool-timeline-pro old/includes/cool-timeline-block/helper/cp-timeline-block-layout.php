<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

 function get_timeline_post_html($attributes,$query){
     $autoplay = isset($attributes['autoplay']) && $attributes['autoplay'] ? true :false;
     $autoplayTimer = isset($attributes['autoplayTimer']) ? $attributes['autoplayTimer'] :3000;
    $classname ="cool-post-timeline-block-".$attributes['cp_timeline_block_id']." cool-post-timeline-block";
    ?>
    <div class= "<?php echo esc_attr( $classname ); ?> " >
    <div class="<?php echo "cool-".$attributes['timelineLayout']."-timeline-body  ".$attributes['timelineDesign']." ".$attributes['Orientation']; ?>" >
        <div class="cool-timeline-block-list">
            <?php
            if($attributes['timelineLayout'] == "horizontal"){
                ?>
                <div  class="swiper-outer" data-autoplay=<?php echo esc_attr($autoplay) ?> data-autoplayTimer =<?php echo esc_attr($autoplayTimer) ?>  data-slide=<?php echo esc_attr($attributes['slidePerView']) ?> id=<?php echo esc_attr($attributes['cp_timeline_block_id']) ?>>
				<div class ="swiper block-editor-block-list__layout">
				<div class="swiper-wrapper ">

            <?php cp_timeline_posts($attributes,$query); ?>
            </div>
            </div>
            <div class="swiper-button-prev"></div>
			<div class="swiper-button-next"></div>
            </div>
            <?php
            }else{
                cp_timeline_posts($attributes,$query);
            }
            ?>
        </div>
    </div>
    </div>
    <style type='text/css'><?php cp_get_dynamic_css($attributes) ?></style>
    <?php

}

function cp_timeline_posts($attributes,$query){
    $index = 0;
    while ( $query->have_posts() ) {
        $query->the_post();
        global $post;
        $storySetting = isset($attributes['storyStart']) ? $attributes['storyStart'] : 'right';
        if($storySetting == 'right'){
            $block_postion ="right";
                if($index % 2 != 0){
                    $block_postion ="left";
                }
        }
        else{
            $block_postion ="left";
            if($index % 2 != 0){
                $block_postion ="right";
            }
        }
        if($attributes['timelineLayout'] == "horizontal"){
            ?>
            <div class="swiper-slide">
            <?php cp_timeline_render_single( $attributes, $index, $post,$block_postion ); ?>
            </div>
            <?php
        }
        else{
            cp_timeline_render_single( $attributes, $index, $post,$block_postion );
        }
        $index++;
    }
    wp_reset_postdata();
}

function cp_timeline_render_single($attributes, $index, $post,$block_postion ){
$post_array =  (array)$post;
$icon_class=$attributes['iconToggle'] == 'true' ? 'timeline-content icon-true' : 'timeline-content icon-false';
?>
<div class="<?php echo esc_attr($icon_class)?>">
    <div class ="timeline-block-vertical-timeline ctl-row  position-<?php echo $block_postion;?>">
            <div class="ctl-6 timeline-block-time">
                <div class="story-time">
                    <?php
                    cp_timeline_date($attributes)
                    ?>
                </div>
            </div> 
            <div class="timeline-block-icon"><?php cp_timeline_icon($attributes);?></div> 
            <div class="ctl-6 timeline-block-detail">						
            <div class="story-details">
            <div class="story-image"><?php ( $attributes['displayPostImage'] )?cp_timeline_image( $attributes ):null; ?></div>
        <div class="story-content">                           
            <?php cp_timeline_title($attributes) ?>                     
            <?php cp_timeline_excerpt($attributes) ?>                     
            </div>
            <?php cp_timeline_link($attributes) ?>                     
            </div>
            </div>
        </div>
</div>

<?php

}









