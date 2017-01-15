<?php

if( !defined( 'ABSPATH' ) ) exit; // Exit if accessed directly


/* Code to Display Featured Image on top of the post */
add_action( 'genesis_before_entry', 'featured_post_image', 8 );
function featured_post_image() {
  if ( !is_singular( array( 'post', 'page' ) ))  return;
    the_post_thumbnail('large'); 
}

/* Limit exerpt lenght */
function custom_excerpt_length( $length ) {
	return 20;
}
add_filter( 'excerpt_length', 'custom_excerpt_length', 999 );