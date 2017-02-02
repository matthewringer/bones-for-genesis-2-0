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
	wp_localize_script( 'rva-load-more', 'rvaloadmore', $args ); 
}
add_action( 'wp_enqueue_scripts', 'rva_load_more_args' );

function rva_trans_header_js() {

	wp_enqueue_script( 'rva-trans-header', get_stylesheet_directory_uri() . '/js/trans-header.js', array( 'jquery' ), '1.0', true );
}
add_action( 'wp_enqueue_scripts', 'rva_trans_header_js' );

add_action('genesis_before_content', 'rvamag_before_content');
function rvamag_before_content() {
	echo '<div id="top" class="rva-fp-before-content"></div>';
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


	$args = array(
		'orderby'       => 'post_date',
		'order'         => 'DESC',
		'posts_per_page'=> '1', // overrides posts per page in theme settings
		'category_name' => 'feature',
	);

	$loop = new WP_Query( $args );
	if( $loop->have_posts() ) {
		hero_story($loop->the_post());
		wp_reset_postdata();
    }
	
	$args = array(
		'orderby'       => 'post_date',
		'order'         => 'DESC',
		'posts_per_page'=> '6',
		'category__not_in' => '11', //TODO: fix hardcoded reference
	);
	cb_3x6("LATEST", $args, widesky_sidebar);

	rva_1_over_2_box("READ", 'read');

	rva_1_over_2_box("MUSIC", 'music');

	rva_1_over_2_box("ART", 'art');

	rva_1_over_2_box("PHOTO", 'photo');

	rva_1_over_2_box("EAT DRINK", 'eatdrink');

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
