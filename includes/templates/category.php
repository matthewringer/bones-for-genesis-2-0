<?php

if( !defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/*
	Template Name: Category Template
*/

function rva_load_more_args() {
	
	global $wp_query;
	$args = array(
		'url'   => admin_url( 'admin-ajax.php' ),
		'query' => $wp_query->query,
	);	
    wp_localize_script( 'rva-load-more', 'rvaloadmore', $args );
}
add_action( 'wp_enqueue_scripts', 'rva_load_more_args' );


/** 

*/
// Add our custom loop
remove_action( 'genesis_loop', 'genesis_do_loop' );
add_action( 'genesis_loop', 'rvamag_categorypage_loop' );


add_action( 'genesis_before_header', 'rva_before_header' );
/** 
* print pre-header content
*
* @since 1.0.0
*/ 
function rva_before_header() {
	?>
		<div class="before-header">
			<?php echo do_shortcode('[rva_ad name="Leaderboard"]'); ?>
		</div>
	<?php
}

add_action('genesis_before_content', 'rvamag_before_content');
/**
 * 
 *
 */
function rvamag_before_content() {
	echo '<div id="top" class="rva-category-before-content"></div>';
}

//* Remove the post content (requires HTML5 theme support)
remove_action( 'genesis_entry_content', 'genesis_do_post_content' );
remove_action( 'genesis_entry_header', 'genesis_do_post_title' );
 // Remove Footer
remove_action('genesis_footer', 'genesis_do_footer');
remove_action('genesis_footer', 'genesis_footer_markup_open', 5);
remove_action('genesis_footer', 'genesis_footer_markup_close', 15);

function rvamag_categorypage_loop() {
	
	global $wp_query;

	$args = array(
		'orderby'       => 'post_date',
		'order'         => 'DESC',
		'posts_per_page'=> '6',
		'category_name' => $wp_query->query["category_name"],
	);

    cb_3x6("", $args);

	$idObj = get_category_by_slug($wp_query->query["category_name"]); 
  	$title = $idObj->cat_name;

    start_section("");
        echo '<div class="post-listing cd-3x3-box" ></div>';
    close_section();

}
