<?php

if( !defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/*
 * Remove the primary and secondary menus
 *
 * @since 2.0.9
 */
// remove_action( 'genesis_after_header', 'genesis_do_nav' );
// remove_action( 'genesis_after_header', 'genesis_do_subnav' );


add_action( 'genesis_header', 'rvamag_header_logo', 12);
/*
 * Add header image and post nav mobile hamburger
 *
 * @since 
 */
function rvamag_header_logo() {
	?>
	<a class="rva-logo" href="<?php echo get_site_url(); ?>">
		<img src="<?php echo get_stylesheet_directory_uri(); ?>/images/logo.svg" alt="RVA Mag Logo" />
	</a>
	<div class="rva-site-description">
		<span><?php echo get_bloginfo( 'description' ); ?> </span>
	</div>
	<?php
}

//* Reposition the primary navigation menu
remove_action( 'genesis_after_header', 'genesis_do_nav');
add_action( 'genesis_header', 'genesis_do_nav', 13 );

add_action( 'genesis_header', 'rva_nav_button', 14);
/**
 * Adds hamburger menu to the collapsed navigation.
 */
function rva_nav_button() {
	?>
	<a href="#0" class="rva-nav-trigger">Menu<span></span></a>
	<?php
}

/*
 * Limit menu depth
 *
 * @since 2.3.31
 */
add_filter( 'wp_nav_menu_args', 'bfg_limit_menu_depth' );
function bfg_limit_menu_depth( $args ) {

	if( !in_array($args['theme_location'], array('primary', 'secondary'), true) )
		return $args;

	$args['depth'] = 2;

	return $args;

}