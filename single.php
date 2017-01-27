<?php

if( !defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/*
	Template Name: Single Page Template
*/

// Add our custom loop
//remove_action( 'genesis_loop', 'genesis_do_loop' );
//add_action( 'genesis_loop', 'rvamag_singlepage_loop' );

//* Remove the post content (requires HTML5 theme support)
//remove_action( 'genesis_entry_header', 'genesis_do_post_title' );

// remove javascript infinite scroll
remove_action( 'wp_enqueue_scripts', 'rva_load_more_js' );

 // Remove Footer
remove_action('genesis_footer', 'genesis_do_footer');
remove_action('genesis_footer', 'genesis_footer_markup_open', 5);
remove_action('genesis_footer', 'genesis_footer_markup_close', 15);

add_action('genesis_before_content', 'rva_before_content');
function rva_before_content() {
	echo '<div class="rva-before-content"></div>';
	echo '<div class="cd-gutter-box article" >';
}

add_action('genesis_after_content', 'rva_after_content');
function rva_after_content() {
	echo '</div> <!-- / cd-gutterbox -->';
}

add_action('genesis_before_entry_content', 'rva_entry_share_links', 9);


add_action('genesis_before_entry_content', 'rva_entry_header_hr', 12);
function rva_entry_header_hr() {
	echo '<hr style="width: 50%; margin-left: 25%; height: 1px; border: none; color: black; background-color: black;">';
}


add_action('genesis_before_entry_content', 'rva_ad_widesky', 15);
function rva_ad_widesky() {
	echo '<div style="">';
	echo '<aside class="widesky-sidebar">';
	echo 	'<div class="widesky-ad ">';
	echo 		'<p class="ad-text">WideSky Ad <br> (<span></span>)</p>';
	echo 	'</div>';
	echo '</aside>';
	echo '</div>';
}

add_action('genesis_entry_header', 'rva_post_excerpt');
function rva_post_excerpt(){
	echo get_the_tagline();
}

genesis();
