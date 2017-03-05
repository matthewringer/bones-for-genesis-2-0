<?php 
/** 
 * Template Name: Contributors Template 
 */

if( !defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

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
add_action( 'genesis_before_header', 'rva_before_header' );

/**
 * Pre-page content menu standoff.
 *
 */
function rva_before_content() {
	?>
		<div class="rva-category-before-content"></div>
	<?php
} add_action('genesis_before_content', 'rva_before_content');

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
add_filter( 'genesis_pre_get_option_site_layout', 'content_sidebar_layout_single_posts' );

//remove_action( 'genesis_loop', 'genesis_do_loop' );

/**
* Prints the right primary sidebar ads
* Applys filter : rva_single_ad_big_boy_h0
*/
function rva_contributor_sidebar(){
	echo "this is the sidebar"; //.the_content();
} add_action('genesis_sidebar', 'rva_contributor_sidebar', 5);




genesis();