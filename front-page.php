<?php

if( !defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/*
	Template Name: Front Page Template
*/

//* Remove the post content (requires HTML5 theme support)
remove_action( 'genesis_entry_content', 'genesis_do_post_content' );
remove_action( 'genesis_entry_header', 'genesis_do_post_title' );

// Remove main loop genesis loop.
remove_action( 'genesis_loop', 'genesis_do_loop' );

 // Remove Footer
remove_action('genesis_footer', 'genesis_do_footer');
remove_action('genesis_footer', 'genesis_footer_markup_open', 5);
remove_action('genesis_footer', 'genesis_footer_markup_close', 15);

add_action( 'wp_enqueue_scripts', 'frontpage_scripts' );
/**
 * enqueue scripts for infinite page scrolling 
 *
 *
 */
function frontpage_scripts() {
	global $wp_query;
	$args = array(
		'url'   => admin_url( 'admin-ajax.php' ),
		'query' => $wp_query->query,
	);
	wp_localize_script( 'rva-load-more', 'rvaloadmore', $args );

	wp_enqueue_script( 'rva-trans-header', get_stylesheet_directory_uri() . '/js/trans-header.js', array( 'jquery' ), '1.0', true );
}

add_action( 'genesis_before_header', 'rva_before_header' );
/** 
* print pre-header content
*
* @since 1.0.0
*/ 
function rva_before_header() {
	?>
		<div class="before-header">
			<?php echo do_shortcode('[rva_ad name="Leaderboard" class="wrap ad-leaderoard"]'); ?>
		</div>
	<?php
}

add_action('genesis_before_content', 'rvamag_before_content');
/**
 * Pre-page content menu standoff.
 *
 */
function rvamag_before_content() {
	?>
		<div id="top" class="rva-fp-before-content"></div>
	<?php
}

add_action( 'genesis_loop', 'rvamag_frontpage_loop' );
/**
 *
 *
 */
function rvamag_frontpage_loop() {

	$args = array(
		'orderby'       => 'post_date',
		'order'         => 'DESC',
		'posts_per_page'=> '1', // overrides posts per page in theme settings
		'category_name' => 'feature',
	);

	$loop = new WP_Query( $args );
	if( $loop->have_posts() ) {

		$loop->the_post();
		echo do_shortcode('[rva_hero_box]');
		
		wp_reset_postdata();
    }
	
	cb_3x6("LATEST", 
		array(
			'orderby'       => 'post_date',
			'order'         => 'DESC',
			'posts_per_page'=> '8',
			'category__not_in' => '11', 
			//TODO: fix hardcoded reference
		), 
		//Don't display the sidebar on mobile
		'[notphone]
			[rva_social_sidebar]
				[rva_ad name="Big_Boy_H1" class="wrap ad-big-boy pad-bottom"]
			[/rva_social_sidebar]
		[/notphone]'
	);
	
	echo do_shortcode('
		<div class="flex" >
			[rva_ad name="Big_Boy_H2" class="wrap ad-big-boy pad-bottom"]
			[notphone]
				[rva_ad name="Big_Boy_H3" class="wrap ad-big-boy"]
			[/notphone]
		</div>');

	echo do_shortcode('
		[rva_1x2 title="READ" slug="read"]
			[rva_ad name="Skyscraper" class="wrap ad-skyscraper"]
		[/rva_1x2]
		[rva_1x2 title="Music" slug="music"]
			[rva_ad name="Skyscraper" class="wrap ad-skyscraper"]
		[/rva_1x2]
		[rva_1x2 title="ART" slug="art"]
			[rva_ad name="Spud" class="wrap ad-spud"]
		[/rva_1x2]
		[rva_1x2 title="PHOTO" slug="photo"]
			[rva_ad name="Spud" class="wrap ad-spud"]
		[/rva_1x2]
		[rva_1x2 title="EAT DRINK" slug="eatdrink"]
	');

	$args = array(
		'orderby'       => 'post_date',
		'order'         => 'DESC',
		'posts_per_page'=> '6',
		'category_name' => 'watch',
	);
	cb_3x6("WATCH", $args); // Todo: restyle watch

	// TODO: GayRva content...

	/*
	 * Output subscription box
	 */
	
	echo rva_subscribtion_form();

	echo do_shortcode(
		'[rva_gutter_box title="READ MORE"]'
			.'<div class="post-listing cd-3x3-box" ></div>'
		.'[/rva_gutter_box]'
	);

	// start_section('READ MORE');
	// 	echo '<div class="post-listing cd-3x3-box" ></div>';
	// close_section();

}

genesis();
