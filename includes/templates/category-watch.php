<?php

if( !defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

include 'category.php';

add_filter( 'genesis_pre_get_option_site_layout', '__genesis_return_full_width_content' );

global $query_override;
$query_override = [
	'category_name' => '',
	'orderby'       => 'post_date',
	'order'         => 'DESC',
	'posts_per_page'=> 6 ,
	'tax_query'=>[[
		'taxonomy' => 'post_format',
		'field' => 'slug',
		'operator' => 'IN',
		'include_children' => true,
		'terms' => ['post-format-video'] 
	]]
];

/**
 *
 */
function rva_watch_load_more_args() {

	global $query_override;
	rva_load_more_posts(1, "entry-thumb-video", $query_override );

} add_action( 'wp_enqueue_scripts', 'rva_watch_load_more_args' );
remove_action( 'wp_enqueue_scripts', 'rva_load_more_args' );

/**
 *
 */
function rva_query_hook( $query ) {

	global $query_override;

	if(is_array($query_override)) {
		foreach( $query_override as $key => $value ) {
			$query->query_vars[$key] = $value;
		}
	}

} //add_action( 'pre_get_posts', 'rva_query_hook' );

remove_action( 'genesis_loop', 'rvamag_categorypage_loop' );

function rva_watch_aftercontent() {

	echo start_section([], '<div class="post-listing rva-3x3-box margin-top" ></div>' );

} 
add_action( 'genesis_after_content_sidebar_wrap', 'rva_watch_aftercontent');
remove_action ('genesis_after_content_sidebar_wrap', 'rva_fp_aftercontent');


genesis();