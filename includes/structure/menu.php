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
	$options =  get_option( RVA_SETTINGS_FIELD ); //TODO: save all social media settings as an array for simplicity!
	$account_array	= [
			'facebook' => $options['rva_socialmedia_facebook_url'],
			'twitter' => $options['rva_socialmedia_twitter_url'],
			'tumblr' => $options['rva_socialmedia_tumblr_url'],
			'youtube' => $options['rva_socialmedia_youtube_url'],
			'instagram' => $options['rva_socialmedia_instagram_url'],
			'snapchat' => $options['rva_socialmedia_snapchat_url']
		];
	$social_accounts = rva_social_accounts($account_array);

	?>
		<div class="rva-title-bar" >
			<a href="#0" class="rva-nav-trigger">Menu<span></span></a>
			<a class="rva-logo" href="<?php echo get_site_url(); ?>">
				<img src="<?php echo get_stylesheet_directory_uri(); ?>/images/logo.svg" alt="RVA Mag Logo" />
			</a>
			<div class="rva-title-button-wrap">
				<?php echo $social_accounts; ?>
			</div>
		</div>
		<?php echo rva_navigation( $social_accounts );
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

function rva_navigation($social_accounts) {

	echo '<div class="rva-nav-wrapper" >';
	ob_start();
		echo rva_searchform();
		echo genesis_do_nav();
	?>

		<a class="rva-menu-logo" href="<?php echo get_site_url(); ?>">
			<img src="<?php echo get_stylesheet_directory_uri(); ?>/images/logo.svg" alt="RVA Mag Logo" />
		</a>

	<?php echo genesis_do_subnav(); ?>

		<script type="text/javascript" async="" src="http://btn.createsend1.com/js/sb.min.js?v=2" class="createsend-script"></script>
		

	<?php echo $social_accounts; ?>

		<div class="createsend-wrap" >
			<div class="createsend-button" data-listid="r/1C/4D9/816/5081E2E96C3931C2"></div>
		</div>
	
	</div>
	<?php
	return ob_get_clean();
}

add_filter('nav_menu_item_id', function( $menu_id, $item, $args, $depth ) {

	$menu_id = ( $item->title === 'Newsletters' ) ? 'menu-item-newsletters' : $menu_id;

	return $menu_id;

}, 10, 4);