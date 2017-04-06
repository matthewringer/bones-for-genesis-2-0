<?php
/*
 *	Template Name: Default Page Template
 */

if( !defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/** 
* Add Leaderboard ad before header
*
* @since 1.0.0
*/ 
function rva_before_header() {
	?>
		<div class="before-header">
			<?php echo do_shortcode('[rva_ad name="Leaderboard" class="ad-leaderboard"]'); ?>
		</div>
	<?php

} add_action( 'genesis_before_header', 'rva_before_header' );

function page_template_class( $attributes ) {

	// add replace content class
	$attributes['class'] .= ' page-default';
	// return the attributes
	return $attributes;

} add_filter( 'genesis_attr_site-inner', 'page_template_class' );





genesis();