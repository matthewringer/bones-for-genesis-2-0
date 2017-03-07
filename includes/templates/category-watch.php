<?php

if( !defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

include 'category.php';


/** 
* Add our custom loop
*/
function rvamag_watch_loop() {
	global $wp_query;
	//echo rva_3x6([slug=>$wp_query->query["category_name"]]);
    echo do_shortcode('[rva_3x6 title="WATCH" slug="watch" count="18" class="entry-thumb-video"]');
}
add_action( 'genesis_loop', 'rvamag_watch_loop' );
remove_action( 'genesis_loop', 'rvamag_categorypage_loop' );


function rva_watch_sidebar(){
	echo do_shortcode('
			[rva_ad name="Big_Boy_H0" class="wrap ad-big-boy"]
			');
} 
add_action('genesis_sidebar', 'rva_watch_sidebar', 5);
remove_action('genesis_sidebar', 'rva_sidebar');

function rva_watch_aftercontent() {

	echo do_shortcode('[hr]');
	echo do_shortcode('[hr]');
    echo do_shortcode('
        [rva_gutter_box ]
			[rva_3x6 title="WATCH" slug="watch" class="entry-thumb-video"]
		[/rva_gutter_box]
    ');

} 
add_action( 'genesis_after_content_sidebar_wrap', 'rva_watch_aftercontent');
remove_action ('genesis_after_content_sidebar_wrap', 'rva_fp_aftercontent');


genesis();