<?php

if( !defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/*
	Template Name: Front Page Template
*/

// Add our custom loop
add_action( 'genesis_loop', 'rvamag_frontpage_loop' );

//* Remove the post content (requires HTML5 theme support)
remove_action( 'genesis_entry_content', 'genesis_do_post_content' );
remove_action( 'genesis_entry_header', 'genesis_do_post_title' );
 // Remove Footer
remove_action('genesis_footer', 'genesis_do_footer');
remove_action('genesis_footer', 'genesis_footer_markup_open', 5);
remove_action('genesis_footer', 'genesis_footer_markup_close', 15);

//* Force full-width-content layout setting
add_filter( 'genesis_pre_get_option_site_layout', '__genesis_return_full_width_content' );

//* Remove Genesis Layout Settings
//remove_theme_support( 'genesis-inpost-layouts' );

//* Force full-width-content layout setting
add_filter( 'genesis_pre_get_option_site_layout', '__genesis_return_full_width_content' );

function rvamag_frontpage_loop() {

	hero_story();
	
	$args = array(
		'orderby'       => 'post_date',
		'order'         => 'DESC',
		'posts_per_page'=> '6',
		'category__not_in' => '11',
	);

	cb_3x6("LATEST", $args, widesky_sidebar);


	$args = array(
		'orderby'       => 'post_date',
		'order'         => 'DESC',
		'posts_per_page'=> '6',
		'category_name' => 'read',
	);
	cb_3x6("READ", $args);

	$args = array(
		'orderby'       => 'post_date',
		'order'         => 'DESC',
		'posts_per_page'=> '6',
		'category_name' => 'music',
	);
	cb_3x6("MUSIC", $args);

	$args = array(
		'orderby'       => 'post_date',
		'order'         => 'DESC',
		'posts_per_page'=> '6',
		'category_name' => 'art',
	);
	cb_3x6("MUSIC", $args);

	$args = array(
		'orderby'       => 'post_date',
		'order'         => 'DESC',
		'posts_per_page'=> '6',
		'category_name' => 'photo',
	);
	cb_3x6("PHOTO", $args);

	$args = array(
		'orderby'       => 'post_date',
		'order'         => 'DESC',
		'posts_per_page'=> '6',
		'category_name' => 'eatdrink',
	);
	cb_3x6("EAT DRINK", $args);

	$args = array(
		'orderby'       => 'post_date',
		'order'         => 'DESC',
		'posts_per_page'=> '6',
		'category_name' => 'watch',
	);
	cb_3x6("WATCH", $args);


start_section('READ MORE');
	echo '<div class="post-listing cd-3x3-box" ></div>';
close_section();

}

function start_section($title) {
	echo '<div class="cd-gutter-box">';
	echo	'<div class="section-title">';
	echo		'<h2>'.$title.'</h2>';
	echo	'</div>';
}

function close_section() {
	echo '</div> <!-- End Section -->';
}

function hero_story() {
	$args = array(
		'orderby'       => 'post_date',
		'order'         => 'DESC',
		'posts_per_page'=> '1', // overrides posts per page in theme settings
		'category_name' => 'feature',
	);

	$loop = new WP_Query( $args );
	if( $loop->have_posts() ) {

		// this is shown before the loop
		$loop->the_post();
		//echo get_the_post_thumbnail();
		echo '<div class="cd-hero-box fx-paralax" style = "background-image: url(' . get_the_post_thumbnail_url() . ');" >';
		echo	'<div class="title-block" >';
		echo		'<h2 class="article-title"><a href="' . get_the_permalink() .'">'. get_the_title() . '</a></h2>';
		echo		'<br/>';
		echo		'<p class="author"><span>' . get_the_author() . '</span></p>';
		echo	'</div>';
		echo '</div>';
	}

	wp_reset_postdata();
}

function cb_3x6($title, $args, $sidebar = false) {
	$loop = new WP_Query( $args );
	if( $loop->have_posts() ) {
		// loop through posts

		start_section($title);
		
		$sidebar_class = "";
		
		if ($sidebar) {
			$sidebar_class = "cd-sidebar";
		}
		
		echo '<div class="cd-3x3-box ' . $sidebar_class . '">';

		while( $loop->have_posts() ): $loop->the_post();
			echo '<article class="entry-thumbnail">';
			echo 	'<div class="article-image" style="background-image:url('.get_the_post_thumbnail_url().');" > </div>';
			echo 	'<div class="text-block">';
			echo 		'<h3><a href="' . get_the_permalink() .'">'. get_the_title() . '</a></h3>';
			echo 		'<p>' . get_the_excerpt() . '</p>';
			echo 	'</div>';
			echo '</article>';
		endwhile;
		echo '</div>';
		if ($sidebar) {
			$sidebar();
		}
		close_section();
	}

	wp_reset_postdata();
}

function widesky_sidebar() {
	echo '<aside class="widesky-sidebar">';
	echo 	'<div class="widesky-ad ">';
	echo 		'<p class="ad-text">WideSky Ad <br> (<span></span>)</p>';
	echo 	'</div>';
	echo 	'<div class="social-buttons" >';
	echo 		'<h2>Follow RVA Mag</h2>';
	echo 		'<ul class="social-buttons">';
	echo 			'<li class="btn-facebook"><i class="fa fa-facebook" ></i><span>Facebook</span></li>';
	echo 			'<li class="btn-twitter"><i class="fa fa-twitter"></i><span>Twitter</span></li>';
	echo 			'<li class="btn-tumblr"><i class="fa fa-tumblr"></i><span>Tumblr</span></li>';
	echo 			'<li class="btn-youtube"><i class="fa fa-youtube"></i><span>YouTube</span></li>';
	echo 			'<li class="btn-instagram"><i class="fa fa-instagram"></i><span>Instagram</span></li>';
	echo 		'</ul>';
	echo 	'</div>';
	echo '</aside>';
}


genesis();
