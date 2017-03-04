<?php

if( !defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/*
	Template Name: Front Page Template
*/

// Remove the post content (requires HTML5 theme support)
//remove_action( 'genesis_entry_content', 'genesis_do_post_content' );
//remove_action( 'genesis_entry_header', 'genesis_do_post_title' );

/**
 * Javascript for Load More
 *
 */

/**
 * enqueue scripts for infinite page scrolling 
 *
 */
function frontpage_scripts() {
	wp_enqueue_script( 'rva-trans-header', get_stylesheet_directory_uri() . '/js/trans-header.js', array( 'jquery' ), '1.0', true );
	wp_enqueue_script( 'rva-load-more', get_stylesheet_directory_uri() . '/js/load-more.js', array( 'jquery' ), '1.0', true );
	
	global $wp_query;
	$args = array(
		'url'   => admin_url( 'admin-ajax.php' ),
		'query' => $wp_query->query,
	);
	wp_localize_script( 'rva-load-more', 'rvaloadmore', $args );
}
add_action( 'wp_enqueue_scripts', 'frontpage_scripts' );

/** 
* Add Leaderboard Add before header
*
* @since 1.0.0
*/ 
function rva_before_header() {
	?>
		<div class="before-header">
			<?php echo do_shortcode('[rva_ad name="Leaderboard" class="ad-leaderboard"]'); ?>
		</div>
	<?php
}
add_action( 'genesis_before_header', 'rva_before_header' );

/**
 * Pre-page content menu standoff.
 * genesis_before_content_sidebar_wrap
 * genesis_before_content
 */
function rvamag_before_content() {
	?>
		<div id="top" class="rva-fp-before-content"></div>
	<?php
	$args = array(
		'orderby'       => 'post_date',
		'order'         => 'DESC',
		'posts_per_page'=> '1', //TODO: overrides posts per page in theme settings
		'category_name' => 'feature',
	);

	$loop = new WP_Query( $args );
	if( $loop->have_posts() ) {
		$loop->the_post();
		echo do_shortcode('[rva_hero_box]');
		wp_reset_postdata();
    }
	?>
	<div class="section-title">
		<h2>LATEST</h2>
	</div>
	<?php
}
add_action('genesis_before_content_sidebar_wrap', 'rvamag_before_content');

/**
 * Output front page content loop.
 *
 */
function rvamag_frontpage_loop() {
	//content
	echo do_shortcode('[rva_topbox title="LATEST" count="12"/]');

	//echo do_shortcode('[rva_3x6 title="LATEST" slug="read"]');
}
remove_action( 'genesis_loop', 'genesis_do_loop' );
add_action( 'genesis_loop', 'rvamag_frontpage_loop' );

function rva_fp_aftercontent() {
	//after content
	echo do_shortcode('
		[rva_gutter_box class="flex-container padding-top margin-top margin-bottom"]
			[rva_ad name="Big_Boy_H1" class="ad-big-boy"]
			[rva_ad name="Big_Boy_H2" class="ad-big-boy collapse-s"]
			[rva_ad name="Big_Boy_H3" class="ad-big-boy collapse-m"]
		[/rva_gutter_box]

		[rva_1x2 title="POLITICS" slug="politics"]
			[notphone]
				[rva_ad name="Skyscraper" class="margin-left ad-skyscraper "]
			[/notphone]
		[/rva_1x2]

		[rva_gutter_box class="flex-container padding-top margin-top margin-bottom"]
			[rva_ad name="Big_Boy_H1" class="ad-big-boy"]
			[rva_ad name="Big_Boy_H2" class="ad-big-boy collapse-s"]
			[rva_ad name="Big_Boy_H3" class="ad-big-boy collapse-m"]
		[/rva_gutter_box]

		[rva_1x2 title="Music" slug="music"]
			[notphone]
				[rva_ad name="Skyscraper" class="margin-left ad-skyscraper "]
			[/notphone]
		[/rva_1x2]
		
		[rva_gutter_box class="flex-container padding-top margin-top margin-bottom"]
			[rva_ad name="Big_Boy_H1" class="ad-big-boy"]
			[rva_ad name="Big_Boy_H2" class="ad-big-boy collapse-s"]
			[rva_ad name="Big_Boy_H3" class="ad-big-boy collapse-m"]
		[/rva_gutter_box]

		[rva_1x2 title="ART" slug="art"]
			[notphone]
				[rva_ad name="Skyscraper" class="margin-left ad-skyscraper "]
			[/notphone]
		[/rva_1x2]
		
		[rva_gutter_box class="flex-container padding-top margin-top margin-bottom"]
			[rva_ad name="Big_Boy_H1" class="ad-big-boy"]
			[rva_ad name="Big_Boy_H2" class="ad-big-boy collapse-s"]
			[rva_ad name="Big_Boy_H3" class="ad-big-boy collapse-m"]
		[/rva_gutter_box]

		[rva_1x2 title="PHOTO" slug="photo" /]
		
		[rva_gutter_box class="flex-container padding-top margin-top margin-bottom"]
			[rva_ad name="Big_Boy_H1" class="ad-big-boy"]
			[rva_ad name="Big_Boy_H2" class="ad-big-boy collapse-s"]
			[rva_ad name="Big_Boy_H3" class="ad-big-boy collapse-m"]
		[/rva_gutter_box]

		[rva_1x2 title="EAT DRINK" slug="eatdrink" /]

		[rva_gutter_box class="flex-container padding-top margin-top margin-bottom"]
			[rva_ad name="Big_Boy_H1" class="ad-big-boy"]
			[rva_ad name="Big_Boy_H2" class="ad-big-boy collapse-s"]
			[rva_ad name="Big_Boy_H3" class="ad-big-boy collapse-m"]
		[/rva_gutter_box]
		
		[rva_gutter_box title="WATCH"]
			[rva_3x6 title="WATCH" slug="watch"]
		[/rva_gutter_box]

		<!-- TODO: GayRva content... -->
		
		[rva_subscribtion_form]

		[rva_gutter_box class="flex-container padding-top margin-top margin-bottom"]
			[rva_ad name="Big_Boy_H1" class="ad-big-boy"]
			[rva_ad name="Big_Boy_H2" class="ad-big-boy collapse-s"]
			[rva_ad name="Big_Boy_H3" class="ad-big-boy collapse-m"]
		[/rva_gutter_box]

		[rva_gutter_box title="READ MORE"]
			<div class="post-listing rva-3x3-box" ></div>
		[/rva_gutter_box]
	');
} add_action( 'genesis_after_content_sidebar_wrap', 'rva_fp_aftercontent');

function rva_frontpage_sidebar(){
	echo do_shortcode('
			[rva_ad name="Big_Boy_H0" class="wrap ad-big-boy"]
			[rva_social_account_buttons]
			');
} add_action('genesis_sidebar', 'rva_frontpage_sidebar', 5);

genesis();