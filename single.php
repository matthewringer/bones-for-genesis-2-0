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

add_action('genesis_before_content', 'rvamag_before_content');
function rvamag_before_content() {
	echo '<div class="rva-before-content"></div>';
	echo '<div class="cd-gutter-box article  " >';
}

add_action('genesis_after_content', 'rvamag_after_content');
function rvamag_after_content() {
	echo '</div> <!-- / cd-gutterbox -->';
}


genesis();
