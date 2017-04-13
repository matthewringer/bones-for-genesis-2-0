<?php

if( !defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 *	Template Name: Single Page Template
 */

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
*
*	Top spacing to offset content to compensate for leaderboard ad and header height
*	Previous and next post buttons.
*
*/
function rva_before_content() {

	?> 
	<div class="rva-before-entry-content"></div>

	<?php echo do_shortcode('
	[rva_gutter_box class="flex-container padding-top margin-top"]
		<div class="collapse-m" style=" margin-bottom: 6em; height:250px; width:970px; background-color:yellow;"></div>
		<div class="expand-m" style="margin-bottom: 6em; height:250px; width:300px; background-color:yellow;"></div>
	[/rva_gutter_box]
	'); ?>

	<?php 
		if(get_previous_post(TRUE)) { 
			previous_post_link( '<div class="rva-prev-link">%link</div>', '<i class="fa fa-chevron-left" ></i>', TRUE ); 
		}
		
		if(get_next_post(TRUE)) {	
			next_post_link( '<div class="rva-next-link">%link</div>', '<i class="fa fa-chevron-right" ></i>', TRUE ); 
		}

} add_action('genesis_before_content_sidebar_wrap', 'rva_before_content');

/**
* Display Featured Image at top of the post 
*
*/
function featured_post_image() {

	if ( !is_singular( array( 'post', 'page', 'magazine' ) ))  return;
	$feature_image_class = ( has_post_format('video') ) ? 'margin-bottom' : 'rva-feature-image margin-bottom' ;
	?> 
		<div id="top" class="<?php echo $feature_image_class; ?>" >
			<?php the_post_thumbnail('large'); ?>
			<?php echo do_shortcode('[rva_photo_credit]'); ?>
		</div> 
	<?php

} add_action( 'genesis_before_content_sidebar_wrap', 'featured_post_image', 13 );


/**
 * Hook the social sharing links into the entry header
 */
function entry_header(){

	echo rva_entry_share_links();

} add_action('genesis_entry_header', 'entry_header', 12); //TODO: Included from SocialMedia.php 

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
* Print the tag line in the entry header
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

/**
 * Hook the page link buttons after the content
 */
function rva_entry_like_buttons() {

	echo do_shortcode('[rva_like_buttons]');

} add_action( 'genesis_entry_footer', 'rva_entry_like_buttons' );

function rva_entry_after_loop() {
	echo do_shortcode(' 
		[hr]
		[rva_gutter_box class="flex-container padding-top margin-top"]
			[rva_ad name="Big_Boy_H1" class="ad-big-boy"]
			[rva_ad name="Big_Boy_H2" class="ad-big-boy collapse-s"]
			[rva_ad name="Big_Boy_H3" class="ad-big-boy collapse-m"]
		[/rva_gutter_box]
		[hr]');

	echo do_shortcode('
	[rva_gutter_box class="flex-container padding-top margin-top"]
	[fb_comments]
	[/rva_gutter_box]
	');

} add_action( 'genesis_after_content_sidebar_wrap', 'rva_entry_after_loop' ); //TODO: Defined elsewhere


