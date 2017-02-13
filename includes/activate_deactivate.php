<?php

if( !defined( 'ABSPATH' ) ) exit; // Exit if accessed directly


add_action('switch_theme', 'rva_deactivation');
function rva_deactivation(){
    $socialMediaOptions=array(
    );
	//delete_option('rva_socialmedia_options',  serialize($socialMediaOptions));

}

add_action('after_switch_theme', 'rva_activation');
function rva_activation(){
    //$options1=array();
	//add_option('rva_socialmedia_options',  serialize($options1));

}

add_action('after_switch_theme', 'rva_create_primary_memu');
/**
 * Configure Theme menus
 */
function rva_create_primary_memu() {

	$top_menu_items = [
		'read' => 'READ',
		'music' => 'MUSIC',
		'art' => 'ART',
		'photo' => 'PHOTO',
		'eatdrink' => 'EAT DRINK',
		'watch' => 'WATCH',
		'events' => 'EVENTS',
		'magazine' => 'MAGAZINE'
	];

    //TODO: set the categories when the theme is applied.
    //wp_create_category(${'name'}, ${'parent'});
    //wp_insert_category( array $catarr, bool $wp_error = false )
	
    //give your menu a name
    $menu_name = 'RVA Primary Menu';
	$menu = wp_get_nav_menu_object( $menu_name );
	if(!$menu) {
		$menu_id = wp_create_nav_menu($menu_name);
		$menu = get_term_by( 'id', $menu_id , 'nav_menu' );
		write_log('Menu Created name: '. $menu->title);

		// Insert top level menu items.
		foreach ( $top_menu_items as $key => $value ) {
			wp_update_nav_menu_item($menu->term_id, 0, array(
			'menu-item-title' =>  __($value),
			//'menu-item-classes' => 'home',
			'menu-item-url' => home_url( '/'.$key ), 
			'menu-item-status' => 'publish'));
		}
	
		//then you set the wanted theme  location
		$locations = get_theme_mod('nav_menu_locations');
		write_log($locations);
		$locations['primary'] = $menu->term_id;
		set_theme_mod( 'nav_menu_locations', $locations );
	}
}