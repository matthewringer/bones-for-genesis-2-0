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

genesis();