<?php
/* Template Name: Century
Description:  Look up the page number in  options_whcl,  and do a redirect to the correct /page/#century-anchor
Version: 1.2.0
Author: Barbara J. Feldman
Author URI: https://www.wordher.com
License: Copyright 2019 Feldman Publishing GPL2
 */

if(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') {
    $url = 'https://' . $_SERVER['HTTP_HOST'];
}
else {
    $url =  'http://' . $_SERVER['HTTP_HOST'];
}
// $url is full URL to timeline (without paging)
$t =  $_GET['t'];
$c =  intval($_GET['c']);
if( isset ($t) && (strpos($t, 'timeline') === 0) && isset ($c)){ // validate input
	$url .= '/' . $t;
	if ( $c>=1 && $c<=21 ){
  	$options = get_option( 'whcl_options' ); // retrieve page number from options for specific timeline
		if ( $options ){
	 		$t_options = substr($t, 9); // remove 'timeline-' because options are saved with just taxonomy slug
	  	$get_page =  1 + floor($options[$t_options][$c]); // fractional values are page 1, etc
			if ($c < 10) {
							$c = '0'.$c; //create 2 digit century string for anchor id
			}
			if ($get_page > 1) {
				$url .= '/page/' . strval( $get_page) .'/#' . $c .'start';
			}
			else {
				$url .= '/#' . $c .'start';
			}
		}
	}
}
header("Location: $url" , true, 301);
exit();