<?php

if( !defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

include 'single.php';

add_filter( 'genesis_pre_get_option_site_layout', '__genesis_return_full_width_content' );


/**
* Hook genesis content and add ".single-main" to class
*
*/
function photo_content_class( $attributes ) {

	// add replace content class
	$attributes['class'] = 'center-content';
	// return the attributes
	return $attributes;

} 
add_filter( 'genesis_attr_entry-content', 'photo_content_class' );

genesis();