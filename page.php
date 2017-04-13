<?php
/*
 *	Template Name: Default Page Template
 */

if( !defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

function page_template_class( $attributes ) {

	// add replace content class
	$attributes['class'] .= ' page-default';
	// return the attributes
	return $attributes;

} add_filter( 'genesis_attr_site-inner', 'page_template_class' );

/**
*
*	Top spacing to offset content to compensate for leaderboard ad and header height
*	Previous and next post buttons.
*
*/
function rva_before_content() {

	?> 
	<div class="rva-before-entry-content"></div>

	<?php echo do_shortcode('
	[rva_gutter_box class="flex-container padding-top margin-top"]
		<div class="collapse-m" style="height:250px; width:970px; background-color:yellow;"></div>
		<div class="expand-m" style="margin-bottom: 6em; height:250px; width:300px; background-color:yellow;"></div>
	[/rva_gutter_box]
	'); ?>

	<?php 
		if(get_previous_post(TRUE)) { 
			previous_post_link( '<div class="rva-prev-link">%link</div>', '<i class="fa fa-chevron-left" ></i>', TRUE ); 
		}
		
		if(get_next_post(TRUE)) {	
			next_post_link( '<div class="rva-next-link">%link</div>', '<i class="fa fa-chevron-right" ></i>', TRUE ); 
		}

} add_action('genesis_after_header', 'rva_before_content');


genesis();