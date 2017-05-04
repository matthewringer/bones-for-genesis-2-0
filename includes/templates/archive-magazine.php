<?php
/*
 *	Template Name: Magazine Archive Template
 */

if( !defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
include 'category.php';
/*
	Template Name: Category Template
*/

add_filter( 'genesis_pre_get_option_site_layout', '__genesis_return_full_width_content' );

/**
 *
 */
function rva_events_load_more_args() {
	rva_load_more_posts(
		1,
		"entry-thumb-cover",
		 [	'post_type' => 'magazine', 
		 	'post_status' => 'publish', 
			'orderby'	=> 'post_date',
			'order'		=> 'DESC',
			'posts_per_page'	=> 6 ,
			'paged' => 1 ],
		 'magazine'
		);
} add_action( 'wp_enqueue_scripts', 'rva_events_load_more_args' );
remove_action( 'wp_enqueue_scripts', 'rva_load_more_args' );

function rvamag_magazine_archive_loop() {
	//echo rva_mail_form();
	echo start_section(['title' => 'Magazine'], '<div class="post-listing rva-3x3-box margin-top" ></div>' );
}
remove_action( 'genesis_loop', 'rvamag_categorypage_loop' );
add_action( 'genesis_loop', 'rvamag_magazine_archive_loop');

remove_action ('genesis_after_content_sidebar_wrap', 'rva_fp_aftercontent');

genesis();