<?php

if( !defined( 'ABSPATH' ) ) exit; // Exit if accessed directly


//add_filter( 'genesis_pre_get_option_site_layout', '__genesis_return_content_sidebar' );
// Other possible layouts: __genesis_return_content_sidebar, __genesis_return_sidebar_content, __genesis_return_content_sidebar_sidebar, __genesis_return_sidebar_sidebar_content, __genesis_return_sidebar_content_sidebar, __genesis_return_full_width_content



add_filter( 'genesis_pre_get_option_site_layout', 'content_sidebar_layout_single_posts' );
/** 
* @author Brad Dalton 
* @link http://wpsites.net/web-design/change-layout-genesis/ 
*/
function content_sidebar_layout_single_posts( $opt ) {
	if ( is_single() ) {
		$opt = 'content-sidebar'; 
		return $opt;
    } 
}

/*
	Template Name: Single Page Template
*/

add_action('wp_head', 'facebook_og_meta');

// remove javascript infinite scroll TODO: code smell
remove_action( 'wp_enqueue_scripts', 'rva_load_more_js' );

/**
 *
 * Code to Display Featured Image on top of the post 
 *
 */
add_action( 'genesis_before_content', 'featured_post_image', 13 );
function featured_post_image() {
  if ( !is_singular( array( 'post', 'page' ) ))  return;
    
		echo '<div class="rva-feature-image" >';
			the_post_thumbnail('large');
		echo '</div>';

		$photog_name = get_post_meta( get_post_thumbnail_id(), 'rva_photographer_name', true );
		echo '<p class="rva-photo-credit">'. $photog_name .'</p>'; 
}

add_filter( 'genesis_attr_content', 'single_main_add_css_attr' );
function single_main_add_css_attr( $attributes ) {
 
 // add original plus extra CSS classes
 $attributes['class'] .= ' single-main';
 
 // return the attributes
 return $attributes;
 
}

add_filter( 'genesis_attr_sidebar-primary', 'single_sidebar_add_css_attr' );
function single_sidebar_add_css_attr( $attributes ) {
 
 // add original plus extra CSS classes
 $attributes['class'] .= ' single-sidebar';
 
 // return the attributes
 return $attributes;
 
}

 // Remove Footer
remove_action('genesis_footer', 'genesis_do_footer');
remove_action('genesis_footer', 'genesis_footer_markup_open', 5);
remove_action('genesis_footer', 'genesis_footer_markup_close', 15);

add_action('genesis_before', 'facebook_js_sdk');

add_action('genesis_before_content', 'rva_before_content');
/**
 *
 *	Top spacing to offset content to compensate for leaderboard ad and header height
 *	Previous and next post buttons.
 *
 */
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

add_action('genesis_entry_header', 'rva_post_excerpt', 11);
function rva_post_excerpt(){
	echo '<h2 class="entry-tagline">'.get_the_tagline().'</h2>';
}

add_action('genesis_entry_header', 'rva_entry_share_links', 12);

add_action('genesis_entry_header', 'rva_entry_header_hr', 14);
function rva_entry_header_hr() {
	echo '<hr class="rva-content-horizon">';
}



add_action('genesis_sidebar', 'rva_ad_widesky_desktop', 5);
function rva_ad_widesky_desktop(){
	//echo '<aside class="widesky-sidebar '.$class.'">';
		rva_skyscraper_ad(''); //"collapse-hidden");
	//echo '</aside>';
}

// TODO: 
add_action( 'genesis_after_entry_content', 'rva_social_sharing_buttons' );

genesis();
