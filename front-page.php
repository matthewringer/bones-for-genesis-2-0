<?php

if( !defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/*
	Template Name: Front Page Template
*/

function rva_load_more_args() {
	global $wp_query;
	$args = array(
		'url'   => admin_url( 'admin-ajax.php' ),
		'query' => $wp_query->query,
	);

	wp_enqueue_script( 'rva-load-more', get_stylesheet_directory_uri() . '/js/load-more.js', array( 'jquery' ), '1.0', true );
	wp_localize_script( 'rva-load-more', 'rvaloadmore', $args ); 
}
add_action( 'wp_enqueue_scripts', 'rva_load_more_args' );

//rva_infinite_scroll();

add_action('genesis_before_content', 'rvamag_before_content');
function rvamag_before_content() {
	echo '<div class="rva-fp-before-content"></div>';
}

// Add our custom loop
remove_action( 'genesis_loop', 'genesis_do_loop' );
add_action( 'genesis_loop', 'rvamag_frontpage_loop' );

//* Remove the post content (requires HTML5 theme support)
remove_action( 'genesis_entry_content', 'genesis_do_post_content' );
remove_action( 'genesis_entry_header', 'genesis_do_post_title' );
 // Remove Footer
remove_action('genesis_footer', 'genesis_do_footer');
remove_action('genesis_footer', 'genesis_footer_markup_open', 5);
remove_action('genesis_footer', 'genesis_footer_markup_close', 15);

//* Force full-width-content layout setting
//add_filter( 'genesis_pre_get_option_site_layout', '__genesis_return_full_width_content' );

function rvamag_frontpage_loop() {

	hero_story();
	
	$args = array(
		'orderby'       => 'post_date',
		'order'         => 'DESC',
		'posts_per_page'=> '6',
		'category__not_in' => '11',
	);

	cb_3x6("LATEST", $args, widesky_sidebar);


	$args = array(
		'orderby'       => 'post_date',
		'order'         => 'DESC',
		'posts_per_page'=> '6',
		'category_name' => 'read',
	);
	cb_3x6("READ", $args);

	$args = array(
		'orderby'       => 'post_date',
		'order'         => 'DESC',
		'posts_per_page'=> '6',
		'category_name' => 'music',
	);
	cb_3x6("MUSIC", $args);

	$args = array(
		'orderby'       => 'post_date',
		'order'         => 'DESC',
		'posts_per_page'=> '6',
		'category_name' => 'art',
	);
	cb_3x6("MUSIC", $args);

	$args = array(
		'orderby'       => 'post_date',
		'order'         => 'DESC',
		'posts_per_page'=> '6',
		'category_name' => 'photo',
	);
	cb_3x6("PHOTO", $args);

	$args = array(
		'orderby'       => 'post_date',
		'order'         => 'DESC',
		'posts_per_page'=> '6',
		'category_name' => 'eatdrink',
	);
	cb_3x6("EAT DRINK", $args);

	$args = array(
		'orderby'       => 'post_date',
		'order'         => 'DESC',
		'posts_per_page'=> '6',
		'category_name' => 'watch',
	);
	cb_3x6("WATCH", $args);

	start_section('READ MORE');
		echo '<div class="post-listing cd-3x3-box" ></div>';
	close_section();

}

genesis();
