<?php
/* Plugin Name: Glossary Tooltip on Timeline
Plugin URI: https://www.wordher.com
Description: Adds &lt;span&gt; tag to timeline story titles, so Glossary Plugin can provide tooltip and glossary link. Requires both Cool Timeline Pro and Glossary by Codeat Premium. Be sure to set "Display Read More" to "No" in Cool Timeline Settings.
Version: 1.2.2
Author: Barbara J. Feldman
Author URI: https://www.wordher.com
License: Copyright 2019 Feldman Publishing GPL2
*/

/*when initialized, check for required plugins */
add_action( 'plugins_loaded', 'wordher_gtt_init' );

function wordher_gtt_init() {
	if( class_exists('CoolTimelinePro') && function_exists( 'gt_fs' )){
		add_filter('get_the_title','wordher_add_span_titles',99999999);
	}
}

function wordher_add_span_titles($title){
	if ((get_post_type() == "cool_timeline") && !is_single() && !is_admin()){
		$title = '<span class="glossary-tooltip-timeline">' . $title . '</span>';
	}
	return $title;
}