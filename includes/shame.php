<?php

if( !defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

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
		echo '<div class="rva-hero-box fx-paralax" style = "background-image: url(' . get_the_post_thumbnail_url() . ');" >';
		echo	'<div class="title-block" >';
		echo		'<h2 class="article-title"><a href="' . get_the_permalink() .'">'. get_the_title() . '</a></h2>';
		echo		'<br/>';
		echo		'<p class="author"><span>' . get_the_author() . '</span></p>';
		echo	'</div>';
		echo '</div>';
}

/**
 * Custom layout functions
 *
 */

function get_the_tagline(){
	$post_id = get_the_ID();
    $field = 'rva_post_tagline';
    return get_post_meta( $post_id, $field, true );
}

function get_cat_id_by_slug($category_slug) {
	$idObj = get_category_by_slug($category_slug); 
	return $idObj->term_id;
}
