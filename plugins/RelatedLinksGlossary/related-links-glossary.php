<?php
/* Plugin Name: Related Links on Glossary Items
Plugin URI: https://www.wordher.com
Description: When either a glossary or post is saved, posts are scanned for glossary titles. Related Links are displayed on each glossary entry,grouped by post category.
Version: 1.7.5
Author: Barbara J. Feldman
Author URI: https://www.wordher.com
License: Copyright 2019 Feldman Publishing GPL2
*/
/*<style>
.rlg-also-appears {width: 100%; border-top: solid 1px #dddddd; margin-bottom: 20px; margin-top:20px; font-family: arial; font-style: italic;}
.rlg_categories {letter-spacing: 3px; font-size: 13px; margin-top:1em;}
.rlg_link {margin-left: 15px;}
.rlg_see_year {font-family: arial; font-size: 12px; font-style: italic; }
.rlg_link_text{}
</style>*/


register_activation_hook( __FILE__, 'wordher_rlg_activate' );
function wordher_rlg_activate(){
}
register_deactivation_hook( __FILE__, 'wordher_rlg_deactivate' );
function wordher_rlg_deactivate(){
}
add_action( 'wp_trash_post', 'rlg_post_trashed' ); //remove links to trashed posts, and from trashed glossary items
add_action( 'transition_post_status','rlg_post_transition', 10 ,3);//remove links to un-published posts, and from un-published glossary items
function rlg_post_transition ($newstatus, $oldstatus, $post){
	if ($oldstatus === 'publish' && $newstatus <> 'publish'){
		rlg_post_trashed ($post->ID);
	}
}
function rlg_post_trashed( $postid ){
// when post or glossary is trashed, need to remove related link meta in both posts/glossary

  switch ( get_post_type( $postid )) {
  	case 'glossary':
		$rlg_previous_links = get_post_meta($postid, 'rlg_related_links_glossary',true);
		$rlg_previous_links_array =  json_decode($rlg_previous_links, true); // retrieve as an array
		$rlg_previous_links_ids = array_keys($rlg_previous_links_array );
		foreach ($rlg_previous_links_ids as $post_post_id){
			rlg_remove_obsolete_rl( $postid,  $post_post_id, 'post' ); // post is the haystack, glossary is the needle
		}
  	break;
  	case 'post':
  		$rlg_previous_links = get_post_meta($postid, 'rlg_related_links_post',true); // true to ensure it retreives a string and not an array)
			$rlg_previous_links_array =  json_decode($rlg_previous_links, true); // retrieve as an array ...
			foreach ($rlg_previous_links_array as $gloss_id => $gloss_title){
				rlg_remove_obsolete_rl( $postid,  $gloss_id, 'glossary' ); // glossary is the haystack, post is the needle
			}
	break;
	}
}



add_filter('plugin_action_links_'.plugin_basename(__FILE__), 'whrlg_page_settings_link');
function whrlg_page_settings_link( $links ) {
	$links[] = '<a href="' .
		admin_url( 'options-general.php?page=whrlg' ) .
		'">' . __('Settings') . '</a>';
	return $links;
}
add_action('admin_menu', 'whrlg_add_page');


function whrlg_add_page() {

	add_options_page( 'Related Links on Glossary', 'Related Links on Glossary', 'manage_options', 'whrlg', 'whrlg_option_page' );
}

// Draw the option page this one merges two forms into one
function whrlg_option_page() {
	if ( ! current_user_can( 'manage_options' ) ) {
        return;
    }
	?>
	<div class="wrap">
		<h1>Related Links on Glossary</h1>
<p style="font-size:16px;margin-right:20%;">This plugin scans Posts and creates Related Links that are displayed on Glossary items. Related Links are updated for the entire site when you click the Scan button below.  Individual Related Links are updated whenever a Post or Glossary item is published, or updated. </p>
<p style="font-size:16px;margin-right:20%;"> Related Posts and Related Glossary items are listed in a meta box that displays when editing either glossary items or posts, but they can not be edited within the meta box.</p>
<p style="font-size:16px;margin-right:20%;">Posts (and their titles) in selected parent categories are scanned for case insensitive, whole word matches of each Glossary title (with an optional "s" ending). For example, the Glossary title "Zoo" will match with the words "zoo","zoos", and "zoo's" but not "zoology". Other plural endings, such as "ies" or "es" are not supported.</p>
<p style="font-size:16px;margin-right:20%;">NOTE: Please return to this Settings page to re-scan whenever a new parent category is renamed or added, or you want to change the order of the category subheads are displayed on the Glossary items.</p>
        <h2><?php echo 'Select parent categories to be included in Related Links by numbering them in sort order (from 1 to a max of 5)'; ?></h2>
        <div><form action="<?php echo admin_url( 'admin-post.php' ); ?>" method="post">
<?php
	settings_fields('whrlg_options');
    do_settings_sections('whrlg');
?>
	<input type="hidden" name="action"  value="whrlg_scan_posts_now">
 	<input name="Submit" type="submit" value="Click Here to Scan all Posts and Create Related Links for all Glossary Items">
	</form>
	</div>
<?php
}
function whrlg_setting_input() { // Display and fill the form field
	$rlg_cats = get_option( 'whrlg_options' ); //or FALSE or Array([1] => 'ESSAYS', [2] => 'COMMENTARY', [3]=>'VIDEOS')  ETC
	$rlg_categories = get_terms(array('taxonomy' => 'category', 'parent' => 0)); // only top-level categories
	$rlg_categories = wp_list_pluck( $rlg_categories, 'name' ); // parent cats of site
	$rlg_row = 0;
	foreach ( $rlg_categories as $category ){
		$sort_order = null;
  	if ( $rlg_cats ){  //previously saved options
  		$sort_order = array_search( $category , $rlg_cats ); //returns key or false
  		if (!$sort_order){
  			$sort_order = null;
  		}
  	}
  	?><input type="hidden" name="rlg_selected_cats[<?php echo $rlg_row;?>][name]"  value = "<?php echo $category; ?>" /></input> <input name="rlg_selected_cats[<?php echo $rlg_row; ?>][sort]" type="number" size="1" min="1" max="5" value=<?php echo $sort_order; ?>  />   <?php echo $category; ?> </input><br />
  	<?php
  	++$rlg_row;
	}
}

//Register and define the settings

add_action('admin_init', 'whrlg_admin_init');

function whrlg_admin_init(){
	register_setting(
		'whrlg_options',
		'whrlg_options',
		'whrlg_validate_options'
	);
add_settings_section(
		'whrlg_main',
		'',
		'whrlg_section_text',
		'whrlg'
	);
	add_settings_field(
		'rlg_selected_cats',
		'Select categories whose posts will display on Glossary items as Related Links by entering the sort order (1-5) in which the category subheads will be listed.',
		'whrlg_setting_input',
		'whrlg',
		'whrlg_main'
	);

}
/*
function whrlg_validate_options($input){
		return $input;
}
*/

 // Draw the section header
function whrlg_section_text() {
}

function whrlg_scan_posts(){ // called from Button on Settings Admin page
 	if (isset( $_POST['rlg_selected_cats'])){ // create an array of ALL parent cats and sort numbers
 		$new_options = $_POST['rlg_selected_cats'];
 		$save_options = [];
 		foreach ($new_options as  $inner_array) {
 			foreach ($inner_array as $key=>$value){

 			  if ( $key === 'name' ) {
 			  	$name = $value;
 			  }
 			  elseif ($key === 'sort' && is_numeric($value)){
 			  	$save_options[$value] = $name;
 			  }
 			}
 		}
 	}
 	ksort( $save_options );
	update_option('whrlg_options',	$save_options); //just parents (no child categories)
	rlg_scanning_posts( null, null, false ); // scan all posts
}

add_action( 'admin_post_whrlg_scan_posts_now', 'whrlg_scan_posts' );

function rlg_post_create_related_links( $postid, $post, $bool, $rlg_glossary_title_array  ){
	//scan when a post is saved ($bool == true) .. also when plugin is initialized ($bool == false)
	// is post in a selected category?
	$rlg_post_category = rlg_get_parent_category_name($postid); // returns NULL or name of selected parent category
	// if the post USED to be in a parent category, but is no longer, we need to remove some related links
	// bool== true? get previous links ... if there are changes, we need to make modifications to REMOVED glossary items
	// bool== true? also maybe a change from selected to non-selected category
	if ($bool) { //  only do this if we are saving single post. If previous glossary links are removed, we need to remove related link from glossary
		$rlg_previous_links = get_post_meta($postid, 'rlg_related_links_post',true); // true to ensure it retreives a string and not an array)
		$rlg_previous_links_array =  json_decode($rlg_previous_links, true); // retrieve as an array ... when done we need to compare (glossaryid => glossary title)
		if (is_null( $rlg_post_category ) && !empty($rlg_previous_links)){ // need to remove RL from post and from each glossary item
			delete_post_meta($postid, 'rlg_related_links_post');
			foreach ($rlg_previous_links_array as $gloss_id => $gloss_title){
				rlg_remove_obsolete_rl( $postid, $gloss_id, 'glossary'); // glossary is haystack, post is needle
			}
		}
	}
	if ( !is_null( $rlg_post_category )){ 		//is this post in one of the selected parent categories?
		$post_url = get_permalink($postid);
		$post_obj = get_post($postid);
		$post_title = $post_obj->post_title;
		$rlg_related_links_post = [];
		foreach ($rlg_glossary_title_array as  $key_glossary_id => $rlg_glossary_title) { // for each glossary title

			if (rlg_scan_content_for_match ($post_obj, $rlg_glossary_title)){
				$rlg_related_links_glossary_str = get_post_meta($key_glossary_id, "rlg_related_links_glossary", true); // true to ensure it retreives a string and not an array
				if (!empty(	$rlg_related_links_glossary_str )){
					$rlg_related_links_glossary = json_decode($rlg_related_links_glossary_str, true); // 2nd parameter == true so it returns an array();
				}
				else {
					$rlg_related_links_glossary=[];
				}
				if (get_post_status($postid) === 'publish'){ // only update glossary when post is published
					$rlg_related_links_glossary[$postid] = array('related-title' => $post_title,'related-url' => $post_url, 'related-category' => $rlg_post_category);// append to array using URL as KEY
				 	update_post_meta($key_glossary_id, 'rlg_related_links_glossary', json_encode($rlg_related_links_glossary)); // update with string (an array encoded to json) on glossary item
				}
				$rlg_related_links_post[$key_glossary_id] = $rlg_glossary_title; // array push (add to end of arrray) using glossary postid as key
			}
		}
		update_post_meta($postid, 'rlg_related_links_post', json_encode($rlg_related_links_post)); // update post meta on POST site with titles of glossary items.

		// compare $rlg_related_links_post with $rlg_previous_links
  	if (!empty($rlg_previous_links_array)){
			$rlg_glossary_titles_outdated = array_diff( $rlg_previous_links_array, $rlg_related_links_post); // if there are previous glossary items that are now gone!
			if (!empty($rlg_glossary_titles_outdated)){
				// need to remove from glossary item.
				foreach ( $rlg_glossary_titles_outdated as $rlg_title ){
					$rlg_gloss_post = get_page_by_title(  html_entity_decode($rlg_title), OBJECT, 'glossary');
					rlg_remove_obsolete_rl( $postid, $rlg_gloss_post->ID, 'glossary'); // glossary is haystack, post is needle
				}
			}
		}
	}
}

add_action('save_post_post','rlg_scanning_posts', 13, 3); //upon post save, scan post title and content for glossary titles
add_action('save_post_glossary','rlg_glossary_create_related_links', 13, 3); //upon glossary save, scan all posts for this one glossary title

function rlg_glossary_create_related_links($postid,$post,$bool){
	// when a glossary item is saved
	$rlg_glossary_title =  $post->post_title; //this will be the needle in the search
	$rlg_related_links_glossary = array(); // initialize the post meta data array rlg_related_links_glossary
//create array of posts to be searched
	$rlg_post_query  = new WP_Query(
    array ( 'post_type'      => 'post',
        		'posts_per_page' => -1
    )
	);

	$rlg_post_query_array = $rlg_post_query->posts;
	wp_reset_postdata();
	foreach ($rlg_post_query_array as $rlg_single_post) {
		$rlg_post_category = rlg_get_parent_category_name($rlg_single_post->ID); // returns selected parent cat or null
		if (( get_post_status( $rlg_single_post->ID ) === 'publish') && (!is_null($rlg_post_category))){ // only include published posts  && those with the right catgories
			if ( rlg_scan_content_for_match( $rlg_single_post, $rlg_glossary_title)) {
				$post_title =$rlg_single_post->post_title;
				$post_url = get_permalink($rlg_single_post->ID);
				$rlg_related_links_glossary[$rlg_single_post->ID] = array('related-title' => $post_title, 'related-url' => $post_url, 'related-category' => $rlg_post_category);
			}
		}
	}
	update_post_meta($postid, 'rlg_related_links_glossary', json_encode($rlg_related_links_glossary)); // update custom field with array encoded to json
}

add_filter('post_updated_messages', 'rlg_updated_messages');

function rlg_updated_messages( $messages){
	$messages['post'] [1] = "Post updated and scanned for glossary titles." ;
	$messages['post'] [4] = "Post updated and scanned for glossary titles";
	$messages['post'] [6] = "Post published and scanned for glossary titles." ;
	$messages['post'] [7] = "Post saved and scanned for glossary titles";
	$messages['glossary'] [1] = "Glossary Term updated and posts scanned for its title." ;
	$messages['glossary'] [4] = "Glossary Term updated and posts scanned for its title.";
	$messages['glossary'] [6] ="Glossary Term published and posts scanned for its title.";
	$messages['glossary'] [7] = "Glossary Term saved and posts scanned for its title.";
	return ($messages);
}

function rlg_add_custom_box() {
        add_meta_box(
            'rlg_box_id',           // Unique ID
            'Related Glossary Items',  // Box title
            'rlg_custom_box_html',  // Content callback, must be of type callable
            'post'                  // Post type
        );

                add_meta_box(
            'rlg_box_id_glossary',           // Unique ID
            'Related Posts',  // Box title
            'rlg_glossary_box_html',  // Content callback, must be of type callable
            'glossary'                  // Post type
        );
}

add_action( 'add_meta_boxes', 'rlg_add_custom_box' );

function rlg_custom_box_html( $post ){
	$rlg_type = get_post_type($post);
	if ($rlg_type == 'post') {
		$rlg_list_glossary_items = get_post_meta($post->ID, 'rlg_related_links_post',true); // true to ensure it retreives a string and not an array)
		if (!empty($rlg_list_glossary_items)) {
			$rlg_list_array =  json_decode($rlg_list_glossary_items, true); // retrieve as an array
			if( count( $rlg_list_array) > 0) {
	    	echo '<ul>';
  	  	echo '<li>' . implode( '</li><li>', $rlg_list_array) . '</li>';
    		echo '</ul>';
			}
		}
	}
}
function rlg_glossary_box_html($post){
	// read the title from the meta data rlg_related_links_glossary
	$rlg_related_links_glossary_str = get_post_meta($post->ID, 'rlg_related_links_glossary', true); // true to ensure it retreives a string and not an array
  if (!empty($rlg_related_links_glossary_str)){
  	$rlg_related_links_glossary_array = json_decode($rlg_related_links_glossary_str, true); // 2nd parameter == true so it returns an array();
   	$rlg_related_links_glossary = wp_list_pluck ($rlg_related_links_glossary_array, 'related-title', $post->ID);
   	if( count( $rlg_related_links_glossary) > 0) {
    	echo '<ul>';
 	 		echo '<li>' . implode( '</li><li>',     $rlg_related_links_glossary) . '</li>';
   		echo '</ul>';
		}
	}
}

function rlg_display_related( $rlg_content ) {
	global $post;
  if  ( is_main_query() && is_single() && $post->post_type === 'glossary'){
   	$rlg_related_links_glossary_str = get_post_meta($post->ID, 'rlg_related_links_glossary', true); // true to ensure it retreives a string and not an array
   	$rlg_related_links_glossary_array = json_decode($rlg_related_links_glossary_str, true); // 2nd parameter == true so it returns an array();
   	$rlg_timeline_story_obj = get_page_by_title( $post->post_title, OBJECT, 'cool_timeline' );
   	if ( $rlg_related_links_glossary_array || $rlg_timeline_story_obj ) { // if there is a related_links custom field OR a timeline story with same title
   		$rlg_output = '[glossary-ignore]<div class="rlg-also-appears">Also appears in:</div>';
			//get postid of timeline event with EXACT match on glossary title
			if ( isset( $rlg_timeline_story_obj )) { //if there is timeline story with same title
      	$rlg_timeline_custom_fields = get_post_custom( $rlg_timeline_story_obj->ID ); // get custom glossary fields into array
	  		if (isset ($rlg_timeline_custom_fields['ctl_story_order'][0])){
	  			$story_order = $rlg_timeline_custom_fields['ctl_story_order'][0];
  	//convert date of event to a century
	  			if  ((+$story_order) <= 0 ){
  						$rlg_century = 0;

  				}
  				else {
  					$rlg_century = (int) floor(+$story_order / 100) + 1; // 1600s are 17th century so we need to add 1
				// now century is type integer
  				}
  				if ( isset( $rlg_timeline_custom_fields['ctl_story_lbl'][0] )) {
  					$rlg_see_year =  '<span class="rlg_see_year"> (see ' . $rlg_timeline_custom_fields["ctl_story_lbl"][0] . ')</span>';
  				}
  				else {
  				$rlg_see_year = '';
  				}
					// get_post_terms of glossary item to determine which timeline:  PEOPLE, RELIGIOUS, OR WORLD
					$rlg_timeline_terms = wp_get_post_terms($post->ID, 'glossary-cat');
					$rlg_output .= '<div class="rlg_categories">TIMELINES:</div><div><span class="rlg_link"><a href="/century?t=';
					switch ( $rlg_timeline_terms[0]->name ) {
						case 'EVENTS':
				 			$rlg_output .= 'timeline-all-religious-events&c=' . $rlg_century . '"><span class="rlg_link_text">EVENTS</span></a></span>'  . $rlg_see_year .'</div>';
					 		break;
						case 'PEOPLE':
							$rlg_output .=  'timeline-all-people&c=' . $rlg_century . '"><span class="rlg_link_text">PEOPLE</span></a></span>' . $rlg_see_year .'</div>';
							break;
						case 'EVENTS - world':
							$rlg_output .=  'timeline-all-world-events&c='. $rlg_century . '"><span class="rlg_link_text">WORLD</span></a></span>' . $rlg_see_year .'</div>';
							break;
					}
				}
			}
 			//now do category subheads
    	$ordered_categories = get_option( 'whrlg_options' ); // FALSE or Array([1] => 'ESSAYS', [2] => 'COMMENTARY', [3]=>'VIDEOS')  ETC
    	if ($ordered_categories &&  is_array($rlg_related_links_glossary_array)){
    		//if ($ordered_categories) 9.10.2020
    		foreach ($ordered_categories as $current_cat){
    			$current_array = array_filter($rlg_related_links_glossary_array, function ( $item ) use ($current_cat) {
							return $current_cat == $item['related-category'];
					 		}	);
	   			if (!empty($current_array)){
		 				$rlg_output .= '<div class="rlg_categories">'. $current_cat . ':</div>';
						foreach ($current_array as $link ){
     					$rlg_output .= '<div class="rlg_link"><a href="'. $link["related-url"] .'">' . '<span class="rlg_link_text">' .$link["related-title"] .'</span></a></div>';
     				}
     			}
				}
	  		// $rlg_content .=  $rlg_output . '[/glossary-ignore]'; move out of this loop
			}
		}
	}
	if (!empty($rlg_output)){
		$rlg_content .=  $rlg_output . '[/glossary-ignore]';
	}
	return $rlg_content;
}

add_filter( 'the_content', 'rlg_display_related', 2 );

function rlg_scanning_posts( $postid = null, $post = null, $bool ){
//$postid is for when scanning only one post (i.e. when post is saved)
//create an array of glossary titles
	$glossary_query  = new WP_Query(
   array ( 'post_type'      => 'glossary',
        		'posts_per_page' => -1
	 ));
	$rlg_glossary_array = $glossary_query->posts;
	wp_reset_postdata();
	$rlg_glossary_title_array = wp_list_pluck( $rlg_glossary_array, 'post_title','ID' ); //postid as index_key, title as value

	if (!is_null($postid)){   // scan one post if postid is not null
		$post = get_post($postid);
		rlg_post_create_related_links( $postid, $post, true, $rlg_glossary_title_array ); //true for single post being SAVED
	}
	elseif (is_null($postid)) { // scan ALL posts
		//delete all existing post_meta for 'post' and 'glossary'
		rlg_delete_all_postmeta('post');
		rlg_delete_all_postmeta('glossary');
  	//create query of all postids and do a foreach
		$rlg_post_query = new WP_Query( array (
			'post_type' => 'post',
			'posts_per_page' => -1
			));
		$rlg_post_query_array = $rlg_post_query->posts;
		wp_reset_postdata();
		foreach ( $rlg_post_query_array as $rlg_single_post){
			rlg_post_create_related_links( $rlg_single_post->ID, $rlg_single_post, false, $rlg_glossary_title_array ); //false for not single post being saved
		}

		echo "</br></br><b>Scanning is complete, and Related Links have been created for the following categories, sorted in the following order: </br /></br>" ;
		foreach ( get_option( 'whrlg_options' ) as $key => $value ) {
			echo $key . ') ' . $value .'<br/>';
		}
		die ("</br>Click here to return to <a href='". admin_url() ."'>Dashboard</a>.</b></br></br>");
	}
}

function rlg_get_parent_category_name( $postid ){
	// return a parent category name (in the selected category list) or else return NULL (do not scan posts not in selected categories)
	$rlg_post_category = null;
	$rlg_post_category_array_of_objects = wp_get_post_terms( $postid, 'category'); // get all the categories of this post
	$rlg_option_cats =  get_option( 'whrlg_options' ); //or FALSE or Array([1] => 'ESSAYS', [2] => 'COMMENTARY', [3]=>'VIDEOS')  ETC
  foreach ( $rlg_post_category_array_of_objects as $rlg_cat_object) {
     // if parent<>0 ?
  	if (in_array( $rlg_cat_object->name, $rlg_option_cats )) { // is it in the list of parents?
   		$rlg_post_category =  $rlg_cat_object->name;  // it's a parent Yay!
  		break;
  	}
  	else {
  		$rlg_parent_name = get_cat_name( $rlg_cat_object->parent ); // check the name of the parent (just 1 level)

  		if (in_array( $rlg_parent_name, $rlg_option_cats)){
  			$rlg_post_category = $rlg_parent_name; // its parent is a seleted cat. Yay!
  			break;
  		}
  	}
	}
	return $rlg_post_category;   // null or a selected parent category
}

function rlg_scan_content_for_match($post, $rlg_glossary_title) {
	$rlg_post_content =  $post->post_title . ' '. $post->post_content;
	//some content should be ignored if it's within [glossary-ignore]
	$rlg_post_content = preg_replace('/\[glossary\-ignore\][\s\S]+?\[\/glossary\-ignore\]/', '', $rlg_post_content);
	$rlg_post_content = preg_replace('/\<\!--[\s\S]+?\--\>/', '', $rlg_post_content);
	$rlg_glossary_title = trim( $rlg_glossary_title);
	if (preg_match("^\b$rlg_glossary_title(s\b|\b)^i", $rlg_post_content)){
	 return(true);
	}
	else {
		return(false);
	}
}

function rlg_remove_obsolete_rl( $needle_id, $haystack_id, $haystack_post_type='post' ){
//remove the needle from the haystack
	$meta_name = 'rlg_related_links_' . $haystack_post_type;
	$meta_str = get_post_meta( $haystack_id, $meta_name, true);
	if (!empty($meta_str)){
		$meta_array =  json_decode( $meta_str, true); //convert to array
		unset( $meta_array[$needle_id]); // remove outdated glossary item from post
		update_post_meta( $haystack_id, $meta_name, json_encode($meta_array));
	}
}
function rlg_delete_all_postmeta( $ptype ){
	$args = array("posts_per_page" => -1, "post_type" => $ptype);
	$allposts = get_posts( $args );
	foreach ($allposts as $postinfo) {
		delete_post_meta ($postinfo->ID, 'rlg_related_links_'.$ptype);
	}
}