<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

//dynamic css
function cp_get_dynamic_css($attributes){
$selectors = '
.cool-post-timeline-block-'.$attributes["cp_timeline_block_id"].' .cool-vertical-timeline-body .story-details h3 
  {
    font-size:'.$attributes["headFontSize"].$attributes["headFontSizeType"].';
    font-family:'.$attributes["headFontFamily"].';
    font-weight:'.$attributes["headFontWeight"].';
    line-height:'.$attributes["headLineHeight"].$attributes["headLineHeightType"].';
    color: '.$attributes["headingColor"].';
   }
.cool-post-timeline-block-'.$attributes["cp_timeline_block_id"].' .cool-horizontal-timeline-body .story-details h3 
  {
    font-size:'.$attributes["headFontSize"].$attributes["headFontSizeType"].';
    font-family:'.$attributes["headFontFamily"].';
    font-weight:'.$attributes["headFontWeight"].';
    line-height:'.$attributes["headLineHeight"].$attributes["headLineHeightType"].';
    color: '.$attributes["headingColor"].';
   }
   .cool-post-timeline-block-'.$attributes["cp_timeline_block_id"].' .cool-vertical-timeline-body .story-details p
  {
    font-size:'.$attributes["subHeadFontSize"].$attributes["subHeadFontSizeType"].';
    font-family:'.$attributes["subHeadFontFamily"].';
    font-weight:'.$attributes["subHeadFontWeight"].';
    line-height:'.$attributes["subHeadLineHeight"].$attributes["subHeadLineHeightType"].';
    color: '.$attributes["subHeadingColor"].';
   }
   .cool-post-timeline-block-'.$attributes["cp_timeline_block_id"].' .cool-horizontal-timeline-body .story-details p
  {
    font-size:'.$attributes["subHeadFontSize"].$attributes["subHeadFontSizeType"].';
    font-family:'.$attributes["subHeadFontFamily"].';
    font-weight:'.$attributes["subHeadFontWeight"].';
    line-height:'.$attributes["subHeadLineHeight"].$attributes["subHeadLineHeightType"].';
    color: '.$attributes["subHeadingColor"].';
   }
   .cool-post-timeline-block-'.$attributes["cp_timeline_block_id"].'  .cool-vertical-timeline-body .story-time p
  {
    font-size:'.$attributes["dateFontsize"].$attributes["dateFontsizeType"].';
    font-family:'.$attributes["dateFontFamily"].';
    font-weight:'.$attributes["dateFontWeight"].';
    line-height:'.$attributes["dateLineHeight"].$attributes["dateLineHeightType"].';
    color: '.$attributes["dateColor"].';
   }
   .cool-post-timeline-block-'.$attributes["cp_timeline_block_id"].'  .cool-horizontal-timeline-body .story-time p
  {
    font-size:'.$attributes["dateFontsize"].$attributes["dateFontsizeType"].';
    font-family:'.$attributes["dateFontFamily"].';
    font-weight:'.$attributes["dateFontWeight"].';
    line-height:'.$attributes["dateLineHeight"].$attributes["dateLineHeightType"].';
    color: '.$attributes["dateColor"].';
   }
   .cool-post-timeline-block-'.$attributes["cp_timeline_block_id"].'  .cool-vertical-timeline-body a.cp-timeline_link
  {
    font-size:'.$attributes["readMoreFontsize"].$attributes["readMoreFontsizeType"].';
    font-family:'.$attributes["readMoreFontFamily"].';
    font-weight:'.$attributes["readMoreFontWeight"].';
    line-height:'.$attributes["readMoreLineHeight"].$attributes["readMoreLineHeightType"].';
    color: '.$attributes["readMoreColor"].';
   }
   .cool-post-timeline-block-'.$attributes["cp_timeline_block_id"].'  .cool-horizontal-timeline-body a.cp-timeline_link
  {
    font-size:'.$attributes["readMoreFontsize"].$attributes["readMoreFontsizeType"].';
    font-family:'.$attributes["readMoreFontFamily"].';
    font-weight:'.$attributes["readMoreFontWeight"].';
    line-height:'.$attributes["readMoreLineHeight"].$attributes["readMoreLineHeightType"].';
    color: '.$attributes["readMoreColor"].';
   }
   .cool-post-timeline-block-'.$attributes["cp_timeline_block_id"].' .cool-vertical-timeline-body .timeline-content .story-details
  {
    background: '.$attributes["backgroundColor"].';
   }
   .cool-post-timeline-block-'.$attributes["cp_timeline_block_id"].' .cool-vertical-timeline-body::before {
    background:linear-gradient(to bottom, rgba(230, 230, 230, 0) 0%,'.$attributes["LineColor"].' 10%,'.$attributes["LineColor"].' 90%, rgba(230, 230, 230, 0) 100%);
    }
.cool-post-timeline-block-'.$attributes["cp_timeline_block_id"].' .cool-vertical-timeline-body .timeline-content .timeline-block-icon{
    background:'.$attributes['iconBg'].' !important;
}
.cool-post-timeline-block-'.$attributes["cp_timeline_block_id"].' .icon-true .timeline-block-icon span.timeline-block-render-icon svg  {
    fill:'.$attributes['iconColor'].';
}
.cool-post-timeline-block-'.$attributes["cp_timeline_block_id"].' .cool-vertical-timeline-body .timeline-content::before {
    background:'.$attributes["storyBorderColor"].' !important;
}
.cool-post-timeline-block-'.$attributes["cp_timeline_block_id"].' .cool-vertical-timeline-body.left .story-details::after{
    background:'.$attributes["storyBorderColor"].' !important;
}
.cool-post-timeline-block-'.$attributes["cp_timeline_block_id"].'  .cool-vertical-timeline-body.right .story-time::after{
    background:'.$attributes["storyBorderColor"].' !important;
}

.cool-post-timeline-block-'.$attributes["cp_timeline_block_id"].' .cool-vertical-timeline-body.both-sided .timeline-content .position-right .story-details::before{
    border-right-color:'.$attributes["storyBorderColor"].' !important;
}
.cool-post-timeline-block-'.$attributes["cp_timeline_block_id"].'  .cool-vertical-timeline-body.both-sided .timeline-content .position-left  .story-details::before{
    border-left-color:'.$attributes["storyBorderColor"].' !important;
}
.cool-post-timeline-block-'.$attributes["cp_timeline_block_id"].'  .cool-vertical-timeline-body.one-sided.left .timeline-content  .story-details::before {
    border-right-color:'.$attributes["storyBorderColor"].' !important;
}
.cool-post-timeline-block-'.$attributes["cp_timeline_block_id"].' .cool-vertical-timeline-body.one-sided.right .timeline-content  .story-details::before {
border-left-color:'.$attributes["storyBorderColor"].' !important;
}
.cool-post-timeline-block-'.$attributes["cp_timeline_block_id"].' .cool-vertical-timeline-body .timeline-content  .story-details {
    border-color:'.$attributes["storyBorderColor"].' !important;
}

.cool-post-timeline-block-'.$attributes["cp_timeline_block_id"].' .cool-vertical-timeline-body .timeline-content .story-details{
    background:'.$attributes["backgroundColor"].';
}
.cool-post-timeline-block-'.$attributes["cp_timeline_block_id"].' .cool-horizontal-timeline-body .timeline-content .story-details{
    background:'.$attributes["backgroundColor"].';
}
.cool-post-timeline-block-'.$attributes["cp_timeline_block_id"].' .cool-horizontal-timeline-body .timeline-content::before{
    background:'.$attributes["LineColor"].';
}
.cool-post-timeline-block-'.$attributes["cp_timeline_block_id"].' .cool-horizontal-timeline-body .timeline-content::after{
    background:'.$attributes["LineColor"].';
}
.cool-post-timeline-block-'.$attributes["cp_timeline_block_id"].' .cool-horizontal-timeline-body .swiper-button-next{
    color:'.$attributes["LineColor"].';
}
.cool-post-timeline-block-'.$attributes["cp_timeline_block_id"].' .cool-horizontal-timeline-body .swiper-button-prev{
    color:'.$attributes["LineColor"].';
}
.cool-post-timeline-block-'.$attributes["cp_timeline_block_id"].' .cool-horizontal-timeline-body .swiper-pagination-bullet-active{
    background:'.$attributes["LineColor"].';
}
.cool-post-timeline-block-'.$attributes["cp_timeline_block_id"].' .cool-horizontal-timeline-body .timeline-content .timeline-block-icon{
    background:'.$attributes["iconBg"].' !important;
}
.cool-post-timeline-block-'.$attributes["cp_timeline_block_id"].' .cool-horizontal-timeline-body .timeline-content .ctl-row .ctl-6.timeline-block-detail::before{
    border-bottom-color:'.$attributes["storyBorderColor"].' !important;
}
.cool-post-timeline-block-'.$attributes["cp_timeline_block_id"].' .cool-horizontal-timeline-body .ctl-6.timeline-block-detail{
    border-top-color:'.$attributes["storyBorderColor"].' !important;
}
   ';

   echo $selectors;
}