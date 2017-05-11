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
 * Pre-page content menu standoff.
 *
 * @since 1.0.0
 */
function rvamag_before_content() {

	$loop = new WP_Query([	
		'orderby'       => 'post_date',
		'order'         => 'DESC',
		'posts_per_page'=> '1',
		'meta_query' => [[
			'key' => RVA_POST_FIELDS_FEATURED_POST,
			'value' => '1',
			'compare' => '='
			]]
	]);

	if( !$loop->have_posts() ) {
		$loop = new WP_Query([
			'orderby'       => 'post_date',
			'order'         => 'DESC',
			'posts_per_page'=> '1' 
		]);
	}

	global $rva_displayed_posts;
	if(isset($rva_displayed_posts)) {
		$args['post__not_in'] = $rva_displayed_posts;
	}

	if( $loop->have_posts() ) {
		$loop->the_post();
		global $post;
		$rva_displayed_posts[] = $post->ID;
		echo do_shortcode('[rva_hero_box]');
		wp_reset_postdata();
	}

	ob_start();
	?>
	<div class="padding-top"></div>
		[rva_gutter_box class="flex-container padding-top padding-bottom margin-top"]
			[rva_ad name="Super_Billboard" class="ad-billboard"]
		[/rva_gutter_box]
	<div class="section-title margin-top rva-site-margins">
		<h2>LATEST</h2>
	</div>
	
	<?php
	echo do_shortcode(ob_get_clean());

}
add_action('genesis_before_content_sidebar_wrap', 'rvamag_before_content');

/**
 * Output front page content loop.
 *
 * @since 1.0.0
 */
function rvamag_frontpage_loop() {

	echo do_shortcode('
		[rva_topbox title="LATEST" count="6"/]
		
		[rva_gutter_box class="flex-container padding-top margin-top expand-s"]
			[rva_ad name="Big_Boy_H0" class="ad-big-boy"]
		[/rva_gutter_box]
	');

} 
add_action( 'genesis_loop', 'rvamag_frontpage_loop' );
remove_action( 'genesis_loop', 'genesis_do_loop' );

/**
 * After page main content
 *
 * @since 1.0.0
 */
function rva_fp_aftercontent() {
	$square_ads = '
		[hr]
		[rva_gutter_box class="flex-container padding-top margin-top margin-bottom"]
			[rva_ad name="Big_Boy_H1" class="ad-big-boy"]
			[rva_ad name="Big_Boy_H2" class="ad-big-boy collapse-s"]
			[rva_ad name="Big_Boy_H3" class="ad-big-boy collapse-m"]
		[/rva_gutter_box]
	';

	//[rva_popular_posts date_after="5 year ago"]

	echo do_shortcode( 
		'[rva_1x2 title="Music" slug="music"/]

		'.$square_ads.'

		[rva_1x2 title="ART" slug="art"/]

		[rva_1x2 title="POLITICS" slug="politics"/]

		[rva_1x2 title="EAT DRINK" slug="eatdrink"/]

		[rva_1x2 title="PHOTO" slug="photo"/]

		[rva_2x title="WATCH" slug="watch" layout="rva-3x3-box" class="entry-thumb-video"]

		'.$square_ads.'

		[rva_gutter_box title="READ MORE" class="padding-top"]
			<div class="post-listing rva-3x3-box margin-top" ></div>
		[/rva_gutter_box]
	');

} add_action( 'genesis_after_content_sidebar_wrap', 'rva_fp_aftercontent');

		// [rva_gutter_box title=""]
		// 	[rva_mail_form]
		// 		<h3>The best of RVA <br class="expand-s" >sent to your inbox weekly</h3>
		// 		<h2>Sign up for the RVA <br class="expand-s" >Newsletter</h2>
		// 	[/rva_mail_form]
		// [/rva_gutter_box]

		// [rva_gutter_box title=""]
		// 	[rva_bigwrk_box]
		// [/rva_gutter_box]

		// [rva_gutter_box title=""]
		// 	[rva_magazine_box]
		// [/rva_gutter_box]

		// [rva_gutter_box title="GAY RVA"]
		// 	<h2>Gay RVA Content</h2>
		// 	<!-- TODO: GayRva content... 2x side by side. -->
		// [/rva_gutter_box]

		// '.$square_ads.'


/**
 * Sidebar Content (hiden below S breakpoint)
 *
 ** @since 1.0.0
 */
function rva_frontpage_sidebar(){

	echo do_shortcode('[rva_ad name="Big_Boy_H0" class="wrap ad-big-boy"]');
			//[rva_social_account_buttons]
} add_action('genesis_sidebar', 'rva_frontpage_sidebar', 5);

genesis();