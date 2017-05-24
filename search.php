<?php

if( !defined( 'ABSPATH' ) ) exit; // Exit if accessed directly


/**
 * Hook header class to remove the header offset.
 */
function rva_set_search_content_class($attrs) {

	$attrs['class'] = $attrs['class'].' search-content';
	
	return $attrs;

} add_filter( 'genesis_attr_content', 'rva_set_search_content_class' );

/**
 * Before content sidebar wrapper.
 */
 function rva_before_content_wrap(){

	?>
	<div class="rva-category-before-content"></div>
	<?php

} add_action('genesis_before_content_sidebar_wrap', 'rva_before_content_wrap');

/**
 * Copied from the Genesis search.php file. Putting it here allows overriding.
 *
 * @since 1.9.0
 */
function bfg_do_search_title() {

	$title = sprintf( '<div class="archive-description"><h1 class="archive-title">%s %s</h1></div>', apply_filters( 'genesis_search_title_text', __( 'Search Results for:', CHILD_THEME_TEXT_DOMAIN ) ), get_search_query() );

	echo apply_filters( 'genesis_search_title_output', $title ) . "\n";

} add_action( 'genesis_before_loop', 'bfg_do_search_title' );

/**
 * Main content Loop 
 *
 */
function search_content_loop() {

	ob_start();
	echo get_search_form();
	?>

	<?php
	echo ob_get_clean();

} 
//add_action('genesis_loop', 'search_content_loop', 9);


add_filter( 'the_content', function($content) {
	//$content = rva_get_excerpt(100, $content);
	return $content;
});

remove_action( 'genesis_loop', 'genesis_do_loop' );
add_action('genesis_loop','genesis_grid_loop');

genesis();
