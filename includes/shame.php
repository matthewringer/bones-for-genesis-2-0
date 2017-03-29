<?php

if( !defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/* Limit exerpt lenght */
function custom_excerpt_length( $length ) {
	return 20;
}
add_filter( 'excerpt_length', 'custom_excerpt_length', 999 );


function rva_get_excerpt($limit, $source = null){
    if($source == "content" ? ($excerpt = get_the_content()) : ($excerpt = get_the_excerpt()));
    $excerpt = preg_replace(" (\[.*?\])",'',$excerpt);
    $excerpt = strip_shortcodes($excerpt);
    $excerpt = strip_tags($excerpt);
    $excerpt = substr($excerpt, 0, $limit);
    $excerpt = substr($excerpt, 0, strripos($excerpt, " "));
    $excerpt = trim(preg_replace( '/\s+/', ' ', $excerpt));
    return $excerpt.'... <a class="rva-read-more" href="'.get_permalink().'">[READ MORE]</a>';
    //return $excerpt = $excerpt;

}

/**
 *
 */
function rva_load_more_posts( $thumb_style = 'entry-thumbnail' ) {

	//wp_enqueue_script( 'rva-load-more', CHILD_DIR . '/js/load-more.js', array( 'jquery' ), '1.0', true );

	wp_enqueue_script( 'rva-load-more', get_stylesheet_directory_uri() . '/js/load-more.js', array( 'jquery' ), '1.0', true );
	
	global $wp_query;
	$args = array(
		'url'   => admin_url( 'admin-ajax.php' ),
		'query' => $wp_query->query,
		'thumb_style' => $thumb_style,
	);
	wp_localize_script( 'rva-load-more', 'rvaloadmore', $args );

}

/**
 * AJAX Load More
 * @link http://www.billerickson.net/infinite-scroll-in-wordpress
 */

// function rva_post_summary() {
// 		echo '<div class="rva-hero-box fx-paralax" style = "background-image: url(' . get_the_post_thumbnail_url() . ');" >';
// 		echo	'<div class="title-block" >';
// 		echo		'<h2 class="article-title"><a href="' . get_the_permalink() .'">'. get_the_title() . '</a></h2>';
// 		echo		'<br/>';
// 		echo		'<p class="author"><span>' . get_the_author() . '</span></p>';
// 		echo	'</div>';
// 		echo '</div>';
// }



