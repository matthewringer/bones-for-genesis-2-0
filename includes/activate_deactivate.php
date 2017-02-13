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
    $options1=array(
    );
	//add_option('rva_socialmedia_options',  serialize($options1));

}


function default_menus() {

    $taxes = get_taxonomies();
	
	foreach ( $taxes as $tax ) {
		if ( is_taxonomy_hierarchical( $tax ) ) {

        }
    }
}

