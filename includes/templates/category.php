<?php

if( !defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/*
	Template Name: Category Template
*/

/**
 * Load javascript assets for category page
 */
function rva_load_more_args() {
	//from plugin...
	rva_load_more_posts();
}
add_action( 'wp_enqueue_scripts', 'rva_load_more_args' );

add_filter('wp_title', function($title) {
	global $wp_query;
	return $title . ' | ' . strtoupper( $wp_query->query["category_name"] );
});

/**
 * Add spacer before page content to offset the fixed header and leaderboard ad unit.
 *
 * Applies filter: rva_category_archive_title
 */
function rvamag_before_content() {
	?>
	<div class="rva-category-before-content"></div>
	<?php echo do_shortcode('
		<div class="flex-container padding-top" >
			[rva_ad code="super_leaderboard" class="ad-billboard"]
		</div>
		<div class="padding-top expand-m" ></div>
	'); ?>
	<?php
	global $wp_query;

	$title = apply_filters( 'rva_category_archive_title', $wp_query->query["category_name"] );
	echo start_section(['title' => $title ], '');
	
}
add_action('genesis_before_content_sidebar_wrap', 'rvamag_before_content');

/** 
* Add our custom loop
*/
function rvamag_categorypage_loop() {
	global $wp_query;
	echo rva_3x6([
		'slug' => $wp_query->query["category_name"],
		'count' => 4,
		'layout' => 'rva-2x-box'
		]);
}
remove_action( 'genesis_loop', 'genesis_do_loop' );
add_action( 'genesis_loop', 'rvamag_categorypage_loop' );


function rva_sidebar(){
	echo do_shortcode('[rva_ad code="Big_Boy_H0" class="wrap ad-big-boy"]');
} add_action('genesis_sidebar', 'rva_sidebar', 5);

function rva_fp_aftercontent() {

    echo start_section([], '<div class="post-listing rva-3x3-box margin-top" ></div>' );

} add_action( 'genesis_after_content_sidebar_wrap', 'rva_fp_aftercontent');


//* Remove the post content (requires HTML5 theme support)
remove_action( 'genesis_entry_content', 'genesis_do_post_content' );
remove_action( 'genesis_entry_header', 'genesis_do_post_title' );
