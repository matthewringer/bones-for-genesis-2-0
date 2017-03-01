<?php

if( !defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/*
	Template Name: Single Page Template
*/

// Modifications to Genesis 
//remove_action('genesis_footer', 'genesis_do_footer');
//remove_action('genesis_footer', 'genesis_footer_markup_open', 5);
//remove_action('genesis_footer', 'genesis_footer_markup_close', 15);

/**
* Add Facebook Open Graph Meta Data Header
*/
add_action('wp_head', 'facebook_og_meta');

function single_scripts() {

	wp_enqueue_script( 'rva-trans-header', get_stylesheet_directory_uri() . '/js/trans-header.js', array( 'jquery' ), '1.0', true );
}
add_action( 'wp_enqueue_scripts', 'single_scripts' );

/**
* Remove javascript infinite scroll 
*/
//TODO: code smell
remove_action( 'wp_enqueue_scripts', 'rva_load_more_js' );

add_filter( 'genesis_pre_get_option_site_layout', 'content_sidebar_layout_single_posts' );
/** 
* Set page Layout Single Sidebar
* 
*/
function content_sidebar_layout_single_posts( $opt ) {
	if ( is_single() ) {
		$opt = 'content-sidebar'; 
		return $opt;
	} 
}

add_action( 'genesis_before_header', 'rva_before_header' );
/** 
* print pre-header content
*
* @since 1.0.0
*/ 
function rva_before_header($ad_unit = 'Leaderboard') {
	?>
		<div class="before-header">
			<?php echo do_shortcode('[rva_ad name="m_home_header"]'); ?>
		</div>
	<?php
}


add_action('genesis_before_content', 'rva_before_content');
/**
*
*	Top spacing to offset content to compensate for leaderboard ad and header height
*	Previous and next post buttons.
*
*/
function rva_before_content() {
	?> 
	<div class="rva-before-entry-content"></div>
	<?php 
		if(get_previous_post(TRUE))
			previous_post_link( '<div class="rva-prev-link">%link</div>', '<i class="fa fa-chevron-left" ></i>', TRUE );
		if(get_next_post(TRUE))
			next_post_link( '<div class="rva-next-link">%link</div>', '<i class="fa fa-chevron-right" ></i>', TRUE );
	?>
	<div class="rva-gutter-box article" >
	<?php
}

add_action( 'genesis_before_content', 'featured_post_image', 13 );
/**
* Display Featured Image at top of the post 
*
*/
function featured_post_image() {
	if ( !is_singular( array( 'post', 'page' ) ))  return;

	?> 
		<div id="top" class="rva-feature-image" > 
			<?php the_post_thumbnail('large'); ?> 
		</div> 
		<?php $photog_name = get_post_meta( get_post_thumbnail_id(), 'rva_photographer_name', true ); ?> 
		<p class="rva-photo-credit"> 
			<?php $photog_name ?> 
		</p> 
	<?php
}

add_filter( 'genesis_attr_content', 'single_main_add_css_attr' );
/**
* Hook genesis content and add ".single-main" to class
*
*/
function single_main_add_css_attr( $attributes ) {

	// add original plus extra CSS classes
	$attributes['class'] .= ' single-main';
	
	// return the attributes
	return $attributes;

}

add_filter( 'genesis_attr_sidebar-primary', 'single_sidebar_add_css_attr' );
/**
* Hook genesis sidebar-primary and add ".single-main" to class
*/
function single_sidebar_add_css_attr( $attributes ) {

	// add original plus extra CSS classes
	$attributes['class'] .= ' single-sidebar';
	
	// return the attributes
	return $attributes;

}

add_action('genesis_before', 'facebook_js_sdk');

add_action('genesis_after_content', 'rva_after_content');
/**
* 
*/
function rva_after_content() {
	?>
		</div> <!-- / rva-gutterbox -->'
	<?php
}

add_action('genesis_entry_header', 'rva_post_excerpt', 11);
/**
*
*/
function rva_post_excerpt(){
	?> 
		<h2 class="entry-tagline"><?php get_the_tagline() ?> </h2> 
	<?php
}


add_action('genesis_entry_header', 'rva_entry_share_links', 12);
/**
* Included from SocialMedia.php
*/


add_action('genesis_entry_header', 'rva_entry_header_hr', 14);
/**
*
*/
function rva_entry_header_hr() {
	?> 
		<hr class="rva-content-horizon">
	<?php
}

add_action('genesis_sidebar', 'rva_single_ad_big_boy_h0', 5);
/**
* Prints the right primary sidebar ads
* Applys filter : rva_single_ad_big_boy_h0
*/
function rva_single_ad_big_boy_h0(){

	$shortcode = '[rva_ad name="Big_Boy_H0" class="wrap ad-big-boy pad-bottom"]';
	$shortcode = apply_filters('rva_single_ad_big_boy_h0', $shortcode );
	
	?>
	<div class="">
	<?php echo do_shortcode($shortcode); ?>
	</div>
	<?php
}

/**
* 
*/
add_action( 'genesis_after_entry_content', 'rva_social_sharing_buttons' );

