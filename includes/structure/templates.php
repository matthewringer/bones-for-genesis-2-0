<?php

/**
 * Set new locaiton for the single page template...
 */
add_filter('single_template', function($template) {

	// Add files to override the singlge template.
	$category_templates = [
		'photo' => 'includes/templates/single-photo.php',
		'magazine' => 'includes/templates/single-magazine.php',
	];

	// Get the current queried post id
	$current_post = get_queried_object_id();
	$terms = wp_get_post_terms( $current_post, 'category' );
	if ( count($terms) > 0 ) {
		$term = array_pop($terms);
		$slug = $term->slug;
	} else {
		$slug = 'magazine'; //TODO: Hack to serve the magazine template... needs to be not hardcoded.
	}

	//$term = get_queried_object();
	$new_template = (array_key_exists( $slug, $category_templates ))? $category_templates[$slug] : false;
	if ( $new_template ) {
		$new_template = locate_template( $new_template );
		if($new_template) {
			return $new_template;
		}
	}

	$new_template = locate_template( 'includes/templates/single-default.php');
	$template = ($new_template) ? $new_template : $template;

	return $template;
});

/**
 * Set new locaiton for the single page template...
 */
add_filter('category_template', function($template) {

	// Add files to override the singlge template.
	$category_templates = [
		//slug  to  path
		'events' => 'includes/templates/archive-events.php',
		'watch' => 'includes/templates/category-watch.php',
	];
	// Get the current queried post id
	$term = get_queried_object();
	$new_template = (array_key_exists( $term->slug, $category_templates ))? $category_templates[$term->slug] : false;
	if ( $new_template ) {
		$new_template = locate_template( $new_template );
		if($new_template) {
			return $new_template;
		}
	}

	$new_template = locate_template( 'includes/templates/category-default.php');
	$template = ($new_template) ? $new_template : $template;

	return $template;
});

/*
 * Set the archive template for specific queries
 */
add_filter( 'archive_template', function( $archive_template ) {
	 //global $post;
	 $archive_templates = [
		'magazine' => 'includes/templates/archive-magazine.php',
	];
	$term = get_queried_object();
	$new_template = (array_key_exists( $term->name, $archive_templates ))? $archive_templates[$term->name] : false;
	if ( $new_template ) {
		$new_template = locate_template( $new_template );
		if($new_template) {
			return $new_template;
		}
	}

	 return $archive_template;
}) ;
