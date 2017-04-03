<?php
/*
 *	Template Name: Events Template
 */

if( !defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
include 'category.php';
/*
	Template Name: Category Template
*/

global $query_override;
$query_override = [
	'category_name' => '',
	'orderby'       => 'post_date',
	'order'         => 'DESC',
	'posts_per_page'=> 6 ,
	// 'tax_query'=>[[
	// 	'taxonomy' => 'post_format',
	// 	'field' => 'slug',
	// 	'operator' => 'IN',
	// 	'include_children' => true,
	// 	'terms' => ['post-format-video'] 
	// ]]
];


/**
 *
 */
function rva_events_load_more_args() {

	global $query_override;
	rva_load_more_posts(1, "entry-thumb-event", $query_override );

} add_action( 'wp_enqueue_scripts', 'rva_events_load_more_args' );
remove_action( 'wp_enqueue_scripts', 'rva_load_more_args' );

/**
 * Calendar loop
 */
function do_calendar() {
    echo start_section([], '<div class="post-listing rva-1x-box margin-top" ></div>' );
}
add_action( 'genesis_loop', 'do_calendar');
remove_action( 'genesis_loop', 'rvamag_categorypage_loop' );

function rva_events_sidebar(){
	echo spingo_events_widget();
} add_action('genesis_sidebar','rva_events_sidebar'); 
remove_action('genesis_sidebar', 'rva_sidebar', 5);


remove_action ('genesis_after_content_sidebar_wrap', 'rva_fp_aftercontent');


genesis();