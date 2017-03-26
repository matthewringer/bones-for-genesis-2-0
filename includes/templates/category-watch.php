<?php

if( !defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

include 'category.php';

function rva_watch_load_more_args() {
	//from plugin...
	rva_load_more_posts("entry-thumb-video");

} add_action( 'wp_enqueue_scripts', 'rva_watch_load_more_args' );
remove_action( 'wp_enqueue_scripts', 'rva_load_more_args' );

add_filter( 'genesis_pre_get_option_site_layout', '__genesis_return_full_width_content' );

/** 
* Add our custom loop
*/
function rvamag_watch_loop() {
	global $wp_query;
    echo do_shortcode('[rva_3x6 title="WATCH" slug="watch" count="6" layout="post-listing rva-3x3-box" class="entry-thumb-video"]');
}
add_action( 'genesis_loop', 'rvamag_watch_loop' );
remove_action( 'genesis_loop', 'rvamag_categorypage_loop' );

function rva_watch_aftercontent() {

    echo do_shortcode('
        [rva_gutter_box ]
			[rva_3x6 title="" count="6" slug="watch" layout="post-listing rva-3x3-box" class="entry-thumb-video"]
		[/rva_gutter_box]
    ');

} 
//add_action( 'genesis_after_content_sidebar_wrap', 'rva_watch_aftercontent');
remove_action ('genesis_after_content_sidebar_wrap', 'rva_fp_aftercontent');


genesis();