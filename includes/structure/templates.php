<?php

/**
 * Set new locaiton for the single page template...
 */
add_filter('single_template', function($template) {

    // Add files to override the singlge template.
    $category_templates = [
        //slug  to  path
        'read' => 'includes/templates/single-read.php',
    ];

    // Get the current queried post id
    $current_post = get_queried_object_id();
    $terms = wp_get_post_terms( $current_post, 'category' );
    $term = array_pop($terms);
    $new_template = $category_templates[$term->slug];
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
        'read' => 'includes/templates/category-read.php',
        'events' => 'includes/templates/category-events.php',
    ];
    // Get the current queried post id
    $term = get_queried_object();
    $new_template = $category_templates[$term->slug];
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


