<?php

/**
 * Set new locaiton for the single page template...
 */
add_filter('single_template', function($template) {

    // Add files to override the singlge template.
    $category_templates = [
        //slug  to  path
        'read' => 'includes/templates/single-read.php',
        'photo' => 'includes/templates/single-photo.php',
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
        //'magazine' => 'includes/templates/archive-magazine.php',
        'events' => 'includes/templates/archive-events.php',
        'watch' => 'includes/templates/category-watch.php',
    ];
    // Get the current queried post id
    $term = get_queried_object();
    $new_template = $category_templates[$term->slug]; //TODO: check first
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

/**
 *
 */
function catch_page_template( $page_template ) {
    $archive_templates = [
        'contributors' => 'page_templates/contributors.php',
        ];
    $term = get_queried_object();
    $new_template = $templates[$term->slug]; //TODO: check first
    if ( $new_template ) {
        $new_template = locate_template( $new_template );
        if($new_template) {
            return $new_template;
        }
    }
 


} add_filter('page_template', 'catch_page_template', 999);



function get_custom_post_type_template( $archive_template ) {
     //global $post;
     
     $archive_templates = [
        'magazine' => 'includes/templates/archive-magazine.php',
        'events' => 'includes/templates/archive-events.php',
        'contributors' => 'includes/templates/archive-contributors.php'
    ];

    $term = get_queried_object();
    $new_template = $archive_templates[$term->slug]; //TODO: check first
    if ( $new_template ) {
        $new_template = locate_template( $new_template );
        if($new_template) {
            return $new_template;
        }
    }

    //  if ( is_post_type_archive ( 'events' ) ) {
    //       $archive_template = locate_template('includes/templates/category-events.php');
          
    //       //$archive_template = dirname( __FILE__ ) . '/category-events.php';
    //  }

     return $archive_template;
} add_filter( 'archive_template', 'get_custom_post_type_template' ) ;


