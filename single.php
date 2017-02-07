<?php

if( !defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/*
	Template Name: Single Page Template
*/

add_action('wp_head', 'facebook_og_meta');

// remove javascript infinite scroll TODO: code smell
remove_action( 'wp_enqueue_scripts', 'rva_load_more_js' );

 // Remove Footer
remove_action('genesis_footer', 'genesis_do_footer');
remove_action('genesis_footer', 'genesis_footer_markup_open', 5);
remove_action('genesis_footer', 'genesis_footer_markup_close', 15);

add_action('genesis_before', 'facebook_js_sdk');

add_action('genesis_before_content', 'rva_before_content');
function rva_before_content() {
	echo '<div class="rva-before-content"></div>';
	
	// $ids = array();
	// $cats = get_the_category(get_the_ID());
	// foreach( $cats as $term) {
	// 	array_push($ids, $cat_id );
	// }
	
	if(get_previous_post(TRUE))
		previous_post_link( '<div class="rva-prev-link">%link</div>', '<i class="fa fa-chevron-left" ></i>', TRUE );
	
	if(get_next_post(TRUE))
		next_post_link( '<div class="rva-next-link">%link</div>', '<i class="fa fa-chevron-right" ></i>', TRUE );
		
	echo '<div class="cd-gutter-box article" >';
}

add_action('genesis_after_content', 'rva_after_content');
function rva_after_content() {
	echo '</div> <!-- / cd-gutterbox -->';
}

add_action('genesis_before_entry_content', 'rva_entry_share_links', 9);


add_action('genesis_before_entry_content', 'rva_entry_header_hr', 12);
function rva_entry_header_hr() {
	echo '<hr class="rva-content-horizon">';
}


add_action('genesis_before_entry', 'rva_ad_widesky_desktop', 15);
function rva_ad_widesky_desktop(){
	rva_ad_widesky("collapse-hidden");
}


add_action('genesis_before_entry_content', 'rva_ad_widesky_mobile', 15);
function rva_ad_widesky_mobile(){
	rva_ad_widesky("collapse-shown");
}


add_action( 'genesis_after_entry_content', 'rva_social_sharing_buttons' );

function rva_ad_widesky($class) {
	echo '<div class="">';
	echo '<aside class="widesky-sidebar '.$class.'">';
	echo 	'<div class="widesky-ad ">';
	echo 		'<p class="ad-text">WideSky Ad <br> (<span></span>)</p>';
	echo 	'</div>';
	echo '</aside>';
	echo '</div>';
}

add_action('genesis_entry_header', 'rva_post_excerpt');
function rva_post_excerpt(){
	echo '<h2 class="entry-tagline">'.get_the_tagline().'</h2>';
}

genesis();
