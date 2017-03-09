<?php

if( !defined( 'ABSPATH' ) ) exit; // Exit if accessed directly


/**
 * Hook header class to remove the header offset.
 */
function rva_unset_header_class($attrs) {

	//$attrs['class'] = str_replace('site-header-offset','', $attrs['class']);
	
	return $attrs;

} add_filter( 'genesis_attr_site-header', 'rva_unset_header_class' );

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

	echo "hello search world!";

} add_action('genesis_loop', 'search_content_loop');
//remove_action('genesis_loop', '');

genesis();
