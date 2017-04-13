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

/**
 * Add spacer before page content to offset the fixed header and leaderboard ad unit.
 */
function rvamag_before_content() {
	?>
	<div class="rva-category-before-content"></div>
	<?php echo do_shortcode('
	[rva_gutter_box class="flex-container padding-top margin-top"]
		<div class="collapse-m" style="margin-bottom: 6em; height:250px; width:970px; background-color:yellow;"></div>
		<div class="expand-m" style="margin-bottom: 6em; height:250px; width:300px; background-color:yellow;"></div>
	[/rva_gutter_box]
	'); ?>
	<?php
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
	echo do_shortcode('[rva_ad name="Big_Boy_H0" class="wrap ad-big-boy"]');
} add_action('genesis_sidebar', 'rva_sidebar', 5);

function rva_fp_aftercontent() {

    echo start_section([], '<div class="post-listing rva-3x3-box margin-top" ></div>' );

} add_action( 'genesis_after_content_sidebar_wrap', 'rva_fp_aftercontent');


//* Remove the post content (requires HTML5 theme support)
remove_action( 'genesis_entry_content', 'genesis_do_post_content' );
remove_action( 'genesis_entry_header', 'genesis_do_post_title' );
