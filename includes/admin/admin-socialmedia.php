<?php

if( !defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * Social Settings
 *
 * This file registers the Social settings to the Theme Settings, to be used in the nav bar.
 *
 * @package      RVA Magazine
 * @author       
 * @license      
 */

/**
 * Register Defaults
 * @author 
 * @link 
 *
 * @param array $defaults
 * @return array modified defaults
 *
 */
function rva_social_defaults( $defaults ) {
	$defaults['twitter_url'] = 'http://twitter.com/RVAMAG';
	$defaults['facebook_url'] = 'https://www.facebook.com/RVAMAG/';
    $defaults['instagram_url'] = 'http://instagram.com/rvamag';
    $defaults['tumblr_url'] = 'http://rvamag.tumblr.com/';
    $defaults['pintrest_url'] = 'http://pinterest.com/rvamag';
    $defaults['youtube_url'] = 'https://www.youtube.com/user/hellorva';

	return $defaults;
}
add_filter( 'genesis_theme_settings_defaults', 'rva_social_defaults' );

/**
 * Sanitization
 * @author Bill Erickson
 * @link http://www.billerickson.net/genesis-theme-options/
 *
 */
function rva_register_social_sanitization_filters() {
	genesis_add_option_filter( 'no_html', GENESIS_SETTINGS_FIELD,
		array(
			'twitter_url',
			'facebook_url',
            'instagram_url',
            'tumblr_url',
            'pintrest_url',
		) );
}
add_action( 'genesis_settings_sanitizer_init', 'rva_register_social_sanitization_filters' );

/**
 * Register Metabox
 * @author Bill Erickson
 * @link http://www.billerickson.net/genesis-theme-options/
 *
 * @param string $_genesis_theme_settings_pagehook
 */
function rva_register_social_settings_box( $_genesis_theme_settings_pagehook ) {
	add_meta_box('rva-social-settings', 'Social Links', 'rva_social_settings_box', $_genesis_theme_settings_pagehook, 'main', 'high');
}
add_action('genesis_theme_settings_metaboxes', 'rva_register_social_settings_box');
/**
 * Create Metabox
 *
 */
function rva_social_settings_box() {
	?>

	<p>Twitter URL:<br />
	<input type="text" name="<?php echo GENESIS_SETTINGS_FIELD; ?>[twitter_url]" value="<?php echo esc_attr( genesis_get_option('twitter_url') ); ?>" size="50" /> </p>

	<p>Facebook URL:<br />
	<input type="text" name="<?php echo GENESIS_SETTINGS_FIELD; ?>[facebook_url]" value="<?php echo esc_attr( genesis_get_option('facebook_url') ); ?>" size="50" /> </p>

    <p>Instagam URL:<br />
	<input type="text" name="<?php echo GENESIS_SETTINGS_FIELD; ?>[instagram_url]" value="<?php echo esc_attr( genesis_get_option('instagram_url') ); ?>" size="50" /> </p>

    <p>Tumblr URL:<br />
	<input type="text" name="<?php echo GENESIS_SETTINGS_FIELD; ?>[tumblr_url]" value="<?php echo esc_attr( genesis_get_option('tumblr_url') ); ?>" size="50" /> </p>

    <p>Pintrest URL:<br />
	<input type="text" name="<?php echo GENESIS_SETTINGS_FIELD; ?>[pintrest_url]" value="<?php echo esc_attr( genesis_get_option('pintrest_url') ); ?>" size="50" /> </p>

	<?php
}