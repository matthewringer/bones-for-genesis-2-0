<?php

if( !defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * Load javascript assets for category page
 */
function rva_load_more_args() {
	//from plugin...
	rva_load_more_posts( 3, $thumb_style = 'entry-thumbnail' );
}
add_action( 'wp_enqueue_scripts', 'rva_load_more_args' );


/**
 * Add spacer before page content to offset the fixed header and leaderboard ad unit.
 */
function rvamag_before_content() {
	?>
	<div class="rva-category-before-content"></div>
	<?php
} add_action('genesis_before_content_sidebar_wrap', 'rvamag_before_content');




/**
 * 
 */
function rva_author_loop() {
	echo do_shortcode('[rva_gutter_box title="READ MORE"]
			<div class="post-listing rva-3x3-box" ></div>
		[/rva_gutter_box]
	');

} add_action( 'genesis_loop', 'rva_author_loop');
remove_action( 'genesis_loop', 'genesis_do_loop' );

genesis();