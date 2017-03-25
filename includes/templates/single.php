<?php

if( !defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 *	Template Name: Single Page Template
 */

/**
* Functions are not defined on this page.
*/

function after_entry() {
	echo do_shortcode('[rva_like_buttons]');
	echo do_shortcode('[fb_comments]');
}
add_action( 'genesis_after_entry_content', 'after_entry' ); //TODO: Defined elsewhere

function entry_header(){
	echo rva_entry_share_links();
}
add_action('genesis_entry_header', 'entry_header', 12); //TODO: Included from SocialMedia.php 


/**
 * Track post views
 */
function rva_track_post_views ($post_id) {
    if ( !is_single() ) return;
    if ( empty ( $post_id) ) {
        global $post;
        $post_id = $post->ID;    
    }
    rva_set_post_views($post_id);

} add_action( 'wp_head', 'rva_track_post_views');

/**
* Add Facebook Open Graph Meta Data Header
*/
add_action('wp_head', 'facebook_og_meta'); //TODO: reference to function not defined on this page.
add_action('genesis_before', 'facebook_js_sdk'); //TODO: reference to function not defined on this page.


function single_scripts() {

	//wp_enqueue_script( 'rva-trans-header', get_stylesheet_directory_uri() . '/js/trans-header.js', array( 'jquery' ), '1.0', true );
} add_action( 'wp_enqueue_scripts', 'single_scripts' );


/** 
* Set page Layout Single Sidebar
* 
*/
function content_sidebar_layout_single_posts( $opt ) {
	if ( is_single() ) {
		$opt = 'content-sidebar'; 
		return $opt;
	} 
} add_filter( 'genesis_pre_get_option_site_layout', 'content_sidebar_layout_single_posts' );


/** 
* print pre-header content
*
* @since 1.0.0
*/ 
function rva_before_header($ad_unit = 'Leaderboard') {
	?>
		<div class="before-header">
			<?php echo do_shortcode('[rva_ad name="Leaderboard"]'); ?>
		</div>
	<?php
} add_action( 'genesis_before_header', 'rva_before_header' );


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
} add_action('genesis_before_content_sidebar_wrap', 'rva_before_content');

/**
* Display Featured Image at top of the post 
*
*/
function featured_post_image() {
	if ( !is_singular( array( 'post', 'page' ) ))  return;
	?> 
		<div id="top" class="rva-feature-image" > 
			<?php the_post_thumbnail('large'); ?>
			<?php echo do_shortcode('[rva_photo_credit]'); ?>
		</div> 
	<?php

} add_action( 'genesis_before_content_sidebar_wrap', 'featured_post_image', 13 );

/**
 * Custom layout functions
 * used in single....
 */
function get_the_tagline(){
	global $post;
    $field = 'rva_post_tagline';
    return get_post_meta( $post->ID, $field, true );

}

/**
*
*/
function rva_post_excerpt() {

	?> 
		<h2 class="entry-tagline"><?php echo get_the_tagline(); ?> </h2> 
	<?php

} add_action('genesis_entry_header', 'rva_post_excerpt', 11);

/**
*	Add hr to entry header
*
*/
function rva_entry_header_hr() {

	?> 
		<hr class="rva-content-horizon">
	<?php

} add_action('genesis_entry_header', 'rva_entry_header_hr', 14);

/**
* Prints the right primary sidebar ads
* Applys filter : rva_single_ad_big_boy_h0
*
* @since 1.0.0
*/
function rva_single_ad_big_boy_h0(){

	$shortcode = '[rva_ad name="Big_Boy_H0" class="wrap ad-big-boy padding-bottom"]';
	$shortcode = apply_filters('rva_single_ad_big_boy_h0', $shortcode );
	
	?>
	<div class="">
	<?php echo do_shortcode($shortcode); ?>
	</div>
	<?php

} add_action('genesis_sidebar', 'rva_single_ad_big_boy_h0', 5);


