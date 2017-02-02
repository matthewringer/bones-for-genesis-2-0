<?php

if( !defined( 'ABSPATH' ) ) exit; // Exit if accessed directly


/* Code to Display Featured Image on top of the post */
add_action( 'genesis_before_entry', 'featured_post_image', 8 );
function featured_post_image() {
  if ( !is_singular( array( 'post', 'page' ) ))  return;
    
		echo '<div class="rva-feature-image" >';
			the_post_thumbnail('large');
		echo '</div>';

		$photog_name = get_post_meta( get_post_thumbnail_id(), 'rva_photographer_name', true );
		echo '<p class="rva-photo-credit">'. $photog_name .'</p>'; 
}

/* Limit exerpt lenght */
function custom_excerpt_length( $length ) {
	return 20;
}
add_filter( 'excerpt_length', 'custom_excerpt_length', 999 );

/**
 * AJAX Load More
 * @link http://www.billerickson.net/infinite-scroll-in-wordpress
 */

function rva_post_summary() {
		echo '<div class="cd-hero-box fx-paralax" style = "background-image: url(' . get_the_post_thumbnail_url() . ');" >';
		echo	'<div class="title-block" >';
		echo		'<h2 class="article-title"><a href="' . get_the_permalink() .'">'. get_the_title() . '</a></h2>';
		echo		'<br/>';
		echo		'<p class="author"><span>' . get_the_author() . '</span></p>';
		echo	'</div>';
		echo '</div>';
}

/**
 * Javascript for Load More
 *
 */
function rva_load_more_js() {

	wp_enqueue_script( 'rva-load-more', get_stylesheet_directory_uri() . '/js/load-more.js', array( 'jquery' ), '1.0', true );
}
add_action( 'wp_enqueue_scripts', 'rva_load_more_js' );

/**
 * Custom layout functions
 *
 */

function widesky_sidebar() {
	echo '<aside class="widesky-sidebar">';
		if ( is_active_sidebar( 'widesky_ad' ) ) {
			dynamic_sidebar( 'widesky_ad' );
		}
		rva_social_follow_buttons();
	echo '</aside>';
}

function rva_social_follow_buttons() {
	?>
	<div class="social-buttons" >
		<h2>Follow RVA Mag</h2>
		<ul class="social-buttons">
			<li class="btn-facebook"><a target="_blank" href="<?php genesis_get_option('facebook_url'); ?> "><i class="fa fa-facebook" ></i><span>Facebook</span></a></li>
			<li class="btn-twitter"><a target="_blank" href="<?php genesis_get_option('twitter_url'); ?>"><i class="fa fa-twitter"></i><span>Twitter</span></a></li>
			<li class="btn-tumblr"><a target="_blank" href="<?php genesis_get_option('tumblr_url') ?>"><i class="fa fa-tumblr"></i><span>Tumblr</span></a></li>
			<li class="btn-youtube"><a target="_blank" href="<?php genesis_get_option('youtube_url') ?>"><i class="fa fa-youtube"></i><span>YouTube</span></a></li>
			<li class="btn-instagram"><a target="_blank" href="<?php genesis_get_option('instagram_url') ?>"><i class="fa fa-instagram"></i><span>Instagram</span></a></li>
		</ul>
	</div>
	<?php 
}

function rva_entry_share_links($post) {
	echo	'<ul class="social-buttons social-links">';
	echo		'<li class="btn-facebook"><a target="_blank" href="'.genesis_get_option('share_facebook_url').get_permalink($post).'"><i class="fa fa-facebook" ></i></a></li>';
	echo		'<li class="btn-twitter"><a target="_blank" href="'.genesis_get_option('share_twitter_url').get_permalink($post).'"><i class="fa fa-twitter" ></i></a></li>';
	echo		'<li class="btn-linkedin"><a target="_blank" href="'.genesis_get_option('share_linkedin_url').get_permalink($post).'"><i class="fa fa-linkedin" ></i></a></li>';
	echo		'<li class="btn-email"><a target="_blank" href="'.genesis_get_option('share_email_url').get_permalink($post).'"><i class="fa fa-envelope" ></i></a></li>';
	echo		'<li class="btn-print"><a target="_blank" href="'.genesis_get_option('share_print_url').get_permalink($post).'"><i class="fa fa-print" ></i></a></li>';
	echo		'<li class="btn-message"><a target="_blank" href="'.genesis_get_option('share_message_url').get_permalink($post).'"><i class="fa fa-comment" ></i></a></li>';
	echo	'</ul>';
}

function get_the_tagline(){
	$post_id = get_the_ID();
    $field = 'rva_post_tagline';
    return get_post_meta( $post_id, $field, true );
}

function get_cat_id_by_slug($category_slug) {
	$idObj = get_category_by_slug($category_slug); 
	return $idObj->term_id;
}
