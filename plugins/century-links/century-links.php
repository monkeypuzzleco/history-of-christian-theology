<?php
/* Plugin Name: Century Links
Plugin URI: https://www.wordher.com
Description: Counts timeline stories and creates century link redirects for each timeline (i.e. each timeline category).  To create or recreate the century redirects, visit the Settings page. Requires Cool Timeline Pro. Requires a blank page titled Century. Usage example for link to 15th century on the All Major Avents timeline: /century/timeline-all-major-events/15/
Version: 1.2.0
Author: Barbara J. Feldman
Author URI: https://www.wordher.com
License: Copyright 2019 Feldman Publishing GPL2
*/
/* upon plugin activation */
register_activation_hook( __FILE__, 'wordher_cl_activate' );
function wordher_cl_activate (){
}
/* rewrite not working at Siteground
function whcl_rewrite_rule() {
	add_rewrite_rule ('^century/timeline-([a-zA-Z-]+)/([0-9]+)/?', 'index.php?pagename=century&t=timeline-$matches[1]&c=$matches[2]','top');
	flush_rewrite_rules();

}

add_action('init', 'whcl_rewrite_rule');
*/

add_filter('plugin_action_links_'.plugin_basename(__FILE__), 'whcl_page_settings_link');
function whcl_page_settings_link( $links ) {
	$links[] = '<a href="' .
		admin_url( 'options-general.php?page=whcl' ) .
		'">' . __('Settings') . '</a>';
	return $links;
}

add_action('admin_menu', 'whcl_add_page');


function whcl_add_page() {

	add_options_page( 'Century Links', 'Century Links', 'manage_options', 'whcl', 'whcl_option_page' );
}

/* Draw the option page this one merges two forms into one, but the callback function is not being reached!! */
function whcl_option_page() {
	if ( ! current_user_can( 'manage_options' ) ) {
        return;
    }
	?>
	<div class="wrap">
		<h2>Century Links</h2>
<p>This plugin counts timeline stories and creates century redirects for each timeline (i.e. each timeline category). </p>
<p>Requires Cool Timeline Pro. Requires a blank page titled "Century". Assumes all Timeline category pages are using the SAME "stories per page" setting. </p>
<p>This plugin also  assumes that the Century items have a named anchor element formatted with CSS:  01start to 21start for example: </br> <a id="#01start" style="display: block; position: relative; top: -250px;"></a> </p>
<p>Usage example for link to 15th century on the All Major Events timeline will be:
	 </br>"/century/?t=timeline-all-major-events&c=15"</p>

	<?php get_option( 'whcl_options' );
	$ppp = $options['posts_per_page'];?>
	<form action="<?php echo admin_url( 'admin-post.php' );?>" method="post">
		<?php settings_fields('whcl_options'); ?>
			<?php do_settings_sections('whcl'); ?>
	<input type="hidden" name="action"  value="whcl_century_pages">
 	<input name="Submit" type="submit" value="Click Here to Count Timeline Stories & Create Century Link Redirects">
	</form>
	</div>
	<?php
}

// Register and define the settings
add_action('admin_init', 'whcl_admin_init');
function whcl_admin_init(){
	register_setting(
		'whcl_options',
		'whcl_options',
		'whcl_validate_options'
	);
add_settings_section(
		'whcl_main',
		'',
		'whcl_section_text',
		'whcl'
	);
add_settings_field(
		'posts_per_page',
		'How many stories per Cool Timeline Pro page?',
		'whcl_setting_input',
		'whcl',
		'whcl_main'
	);

}

// Draw the section header
function whcl_section_text() {
}

// Display and fill the form field
function whcl_setting_input() {
	// get option 'posts_per_page' value from the database
	$options = get_option( 'whcl_options' );
	$ppp = $options['posts_per_page'];
	// echo the field
	echo "<input id='posts_per_page' name='whcl_options_posts_per_page' type='number' min='10' max='500' value=$ppp />";

}

// Validate user input (we want integer only -- but input is validated by form)
function whcl_validate_options( $input ) {
	return $input;
}
add_filter( 'page_template', 'whcl_page_template' );
function whcl_page_template( $page_template )
{
		global $post;
    if ( is_page( 'century' ) ) {
         $page_template = dirname( __FILE__ ) . '/template-century.php';
    }
    return $page_template;
}
add_action( 'admin_post_whcl_century_pages', 'whcl_count_stories' );

function whcl_count_stories($something){

if ( isset( $_POST['whcl_options_posts_per_page'])){
  $ppp = $_POST['whcl_options_posts_per_page'];
  update_option ('whcl_options',	$new_options);
  echo "</br> Calcuating redirects using ". $ppp . " stories per page.</br>";
	// save $ppp and then delete all options
	delete_option('whcl_options' );
	//create_category_arrays()
	$temp = get_terms(['taxonomy' => 'ctl-stories']);
	$all_timeline_categories =  array_column($temp, 'slug');
	$new_options = array();
	foreach (	$all_timeline_categories as $current_cat){
		//fill array with zeros
		$new_options[$current_cat] = array_fill(0,22,0);
	}
	$new_options[ 'posts_per_page'] = $ppp;
	update_option ('whcl_options',	$new_options); // looks like this overwrites entire
	 $args = array (		'post_type'		=> 'cool_timeline',
			'post_status'	=> 'publish',
			'meta_key'		=> 'ctl_story_order',
			'orderby' 		=> 'meta_value_num',
			'order'				=> 'ASC',
			'posts_per_page' => '-1', //all posts
			 'no_found_rows' => true);
	$the_query = new WP_Query( $args );
		if ( $the_query->have_posts() ) : while ( $the_query->have_posts() ) :  $the_query->the_post();
		  $story_cats = get_the_terms( get_the_ID(), 'ctl-stories' ); // an array of all the categories for this post
		  $story_cats_slug = array_column($story_cats, 'slug');
	  	if (empty($story_cats_slug)) continue;
	  	$stories_custom_fields = get_post_custom(); // get custom fields into array
  		$story_order = $stories_custom_fields['ctl_story_order'][0];
  	//convert date of event to a century
  		if (($story_order == null) || ((+$story_order) <= 0 )){
  			$century = 0;
  		}
  		else {
  			$century = (int) floor(+$story_order / 100) + 1; // 100s are 17th century so we need to add 1
				// now century is type integer
  		}
		foreach ($story_cats_slug as $current_cat){
			// for each timeline category
			for ($i=$century+1; $i<22; $i++) {
				//increment all later centuries
					$ppp_increment = 1/$ppp;
					$new_options[$current_cat][$i] = (float) $new_options[$current_cat][$i] + $ppp_increment;

			}
		}
	endwhile;
	endif;
	$new_options['posts_per_page'] = $ppp;
  update_option ('whcl_options',	$new_options);
	wp_reset_query();
	die("</br></br><b>Counting is complete, and century links have been created. Click here to return to <a href='". admin_url() ."'>Dashboard</a>.</b></br>");
	}
}