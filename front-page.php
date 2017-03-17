<?php
/*
 *	Template Name: Front Page Template
*/

if( !defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * Enqueue scripts for infinite page scrolling 
 *
 * @since 1.0.0
 */
function frontpage_scripts() {
	wp_enqueue_script( 'rva-trans-header', get_stylesheet_directory_uri() . '/js/trans-header.js', array( 'jquery' ), '1.0', true );
	
	rva_load_more_posts();

} add_action( 'wp_enqueue_scripts', 'frontpage_scripts' );

/** 
* Add Leaderboard ad before header
*
* @since 1.0.0
*/ 
function rva_before_header() {
	?>
		<div class="before-header">
			<?php echo do_shortcode('[rva_ad name="Leaderboard" class="ad-leaderboard"]'); ?>
		</div>
	<?php

} add_action( 'genesis_before_header', 'rva_before_header' );

/**
 * Pre-page content menu standoff.
 *
 * @since 1.0.0
 */
function rvamag_before_content() {

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
	<!--<div class="padding-top"></div>-->
	<div class="padding-top expand-m"></div>
	<div class="section-title margin-top rva-site-margins">
		<h2>LATEST</h2>
	</div>
	<?php

} add_action('genesis_before_content_sidebar_wrap', 'rvamag_before_content');

/**
 * Output front page content loop.
 *
 * @since 1.0.0
 */
function rvamag_frontpage_loop() {

	echo do_shortcode('[rva_topbox title="LATEST" count="9"/]');

} add_action( 'genesis_loop', 'rvamag_frontpage_loop' );
remove_action( 'genesis_loop', 'genesis_do_loop' );

/**
 * After page main content
 *
 * @since 1.0.0
 */
function rva_fp_aftercontent() {

	$square_ads = '
		[hr]
		[rva_gutter_box class="flex-container padding-top margin-top"]
			[rva_ad name="Big_Boy_H1" class="ad-big-boy"]
			[rva_ad name="Big_Boy_H2" class="ad-big-boy collapse-s"]
			[rva_ad name="Big_Boy_H3" class="ad-big-boy collapse-m"]
		[/rva_gutter_box]
	';

	echo do_shortcode( 
		'[rva_popular_posts]

		[rva_1x2 title="Music" slug="music"/]

		'.$square_ads.'

		[rva_1x2 title="ART" slug="art"/]

		[rva_gutter_box title=""]
			[rva_mail_form]
				<h3>The best of RVA sent to your inbox weekly</h3>
				<h2>Sign up for the RVA Mag Newsletter</h2>
			[/rva_mail_form]
		[/rva_gutter_box]

		[rva_1x2 title="POLITICS" slug="politics"/]
	
		[hr]
		[rva_gutter_box class="flex-container padding-top margin-top"]
			[rva_ad name="Leaderboard" class="ad-leaderboard"]
		[/rva_gutter_box]
		
		[rva_1x2 title="EAT DRINK" slug="eatdrink"/]

		[rva_gutter_box title=""]
			[rva_magazine_box]
		[/rva_gutter_box]
		
		'.$square_ads.'
		
		[rva_1x2 title="PHOTO" slug="photo"/]

		[rva_gutter_box title=""]
				[rva_bigwrk_box]
		[/rva_gutter_box]

		[rva_gutter_box title="WATCH"]
			[rva_3x6 title="WATCH" slug="watch" layout="rva-3x3-box margin-top" class="entry-thumb-video"]
		[/rva_gutter_box]

		'.$square_ads.'

		[rva_gutter_box title="GAY RVA"]
			<h2>Big Work</h2>
			<!-- TODO: GayRva content... 2x side by side. -->
		[/rva_gutter_box]

		'.$square_ads.'
		
		[rva_gutter_box title="READ MORE"]
			<div class="post-listing rva-3x3-box" ></div>
		[/rva_gutter_box]
	');

} add_action( 'genesis_after_content_sidebar_wrap', 'rva_fp_aftercontent');

/**
 * Sidebar Content (hiden below S breakpoint)
 *
 ** @since 1.0.0
 */
function rva_frontpage_sidebar(){

	echo do_shortcode('
			[rva_ad name="Big_Boy_H0" class="wrap ad-big-boy"]
			[rva_social_account_buttons]
			');

} add_action('genesis_sidebar', 'rva_frontpage_sidebar', 5);

genesis();