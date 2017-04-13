<?php

if( !defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/*
 * Remove the primary and secondary menus
 *
 * @since 2.0.9
 */

//* Reposition the primary navigation menu
remove_action( 'genesis_after_header', 'genesis_do_nav');
remove_action( 'genesis_after_header', 'genesis_do_subnav' );

/*
 * Add header image and post nav mobile hamburger
 *
 * @since 
 */
function rvamag_header_nav() {
	?>

		<a class="rva-logo" href="<?php echo get_site_url(); ?>">
			<img src="<?php echo get_stylesheet_directory_uri(); ?>/images/logo.svg" alt="RVA Mag Logo" />
		</a>
		<a href="#0" class="rva-nav-trigger">Menu<span></span></a>
		<?php echo rva_navigation(); ?>
	<?php
}
add_action( 'genesis_header', 'rvamag_header_nav', 12);

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

function rva_navigation() {

	echo '<div class="rva-nav-wrapper" >';
	ob_start();
		echo rva_searchform();
		echo genesis_do_nav();
		?>
		<a class="rva-menu-logo" href="<?php echo get_site_url(); ?>">
			<img src="<?php echo get_stylesheet_directory_uri(); ?>/images/logo.svg" alt="RVA Mag Logo" />
		</a>
		<?php
		echo genesis_do_subnav();

		$options =  get_option( RVA_SETTINGS_FIELD );
		echo rva_social_accounts([ 	
			'facebook' => $options['rva_socialmedia_facebook_url'],
			'twitter' => $options['rva_socialmedia_twitter_url'],
			'tumblr' => $options['rva_socialmedia_tumblr_url'],
			'youtube' => $options['rva_socialmedia_youtube_url'],
			'instagram' => $options['rva_socialmedia_instagram_url'],
			'snapchat' => $options['rva_socialmedia_snapchat_url']
		]);
	echo '</div>';

	return ob_get_clean();
}