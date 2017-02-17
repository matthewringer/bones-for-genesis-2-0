<?php

if( !defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
include 'category.php';
/*
	Template Name: Category Template
*/

/**
* Remove javascript infinite scroll 
*/
//TODO: code smell
remove_action( 'wp_enqueue_scripts', 'rva_load_more_js' );

//* Remove the post content (requires HTML5 theme support)
remove_action( 'genesis_loop', 'rvamag_categorypage_loop' );

add_action( 'genesis_loop', 'do_calendar');
/**
 * Calendar loop
 */
 function do_calendar() {
     ?>
     <div id="spingo-container" style="position:static; top:200px;"></div>
     <script src="http://rvamag.spingo.com/embed.js"></script>
     <?php
 }

genesis();