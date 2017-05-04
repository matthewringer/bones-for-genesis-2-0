<?php
/*
 *	Template Name: Contributors Template
 */

if( !defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
include 'category.php';
/*
	Template Name: Page Contributors
*/

add_filter( 'genesis_pre_get_option_site_layout', '__genesis_return_full_width_content' );

function override_rvamag_before_content() {
	echo '<div class="rva-before-entry-content"></div>';
} add_action('genesis_before_content_sidebar_wrap', 'override_rvamag_before_content');
remove_action('genesis_before_content_sidebar_wrap', 'rvamag_before_content');


/**
 *
 */


function rvamag_custom_archive_loop() {

    $args = ['who' => 'authors'];

    // The Query
    $user_query = new WP_User_Query( $args );

    ob_start();
    // User Loop
    if ( ! empty( $user_query->results ) ) {
        foreach ( $user_query->results as $user ) {
            echo rva_author_box( ['author_id' => $user->ID] );
        }
    } else {
        echo 'No users found.';
    }
    $content = ob_get_clean();

	echo start_section([], $content );

} add_action( 'genesis_loop', 'rvamag_custom_archive_loop'); remove_action( 'genesis_loop', 'rvamag_categorypage_loop' );


remove_action ('genesis_after_content_sidebar_wrap', 'rva_fp_aftercontent');

genesis();