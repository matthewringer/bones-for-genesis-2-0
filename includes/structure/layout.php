<?php

if( !defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/*
 * Force a layout setting for the site
 *
 * See: http://www.briangardner.com/code/force-layout-setting/
 *
 * @since 2.3.38
 */
add_filter( 'genesis_pre_get_option_site_layout', '__genesis_return_full_width_content' );
// Other possible layouts: __genesis_return_content_sidebar, __genesis_return_sidebar_content, __genesis_return_content_sidebar_sidebar, __genesis_return_sidebar_sidebar_content, __genesis_return_sidebar_content_sidebar, __genesis_return_full_width_content


/*
 *  Hero Story Box
 * 
 * 
 */

function hero_story($post) {
    //echo get_the_post_thumbnail();
    echo '<div class="cd-hero-box fx-paralax" style = "background-image: url(' . get_the_post_thumbnail_url($post) . ');" >';
    echo	'<div class="title-block" >';
    echo		'<h2 class="article-title"><a href="' . get_the_permalink($post) .'">'. get_the_title($post) . '</a></h2>';
    echo		'<br/>';
    echo		'<p class="author">' . do_shortcode('[post_author_posts_link]') . '</p>';
    echo	'</div>';
    echo '</div>';
}


/*
 *  Open an Fullwidth Gutterbox div
 * 
 * 
 */

function start_section($title) {
	echo '<div class="cd-gutter-box">';
	if($title) {
		echo	'<div class="section-title">';
	} else {
		echo	'<div>';
	}
	echo		'<h2>'.$title.'</h2>';
	echo	'</div>';
}

/*
 *  Close a div
 * 
 * 
 */

function close_section() {
	echo '</div> <!-- End Gutter Box Section -->';
}

/*
 * Get the post thumbnail markup
 *
 *
 */
function rva_post_thumbnail() {
  		echo '<article class="entry-thumbnail">';
        echo '<a href="' . get_the_permalink() .'">';
        echo 	'<div class="rva-article-image" style="background-image:url('.get_the_post_thumbnail_url().');" > </div>';
        echo 	'<div class="text-block">';
        echo 		'<h3>'. get_the_title() . '</h3>';
        echo 		'<p>' . get_the_excerpt() . '</p>';
        echo 	'</div>';
        echo  '</a>';
        echo '</article>';
}

/*
 * 3 by 6 post thumbnail box
 * 
 * 
*/

function cb_3x6($title, $args, $sidebar = false) {
	$loop = new WP_Query( $args );
	if( $loop->have_posts() ) {
		// loop through posts

		start_section($title);
		
		$sidebar_class = "";
		
		if ($sidebar) {
			$sidebar_class = "cd-sidebar";
		}
		
		echo '<div class="cd-3x3-box ' . $sidebar_class . '">';

		while( $loop->have_posts() ): $loop->the_post();
			rva_post_thumbnail();
		endwhile;
		echo '</div>';
		if ($sidebar) {
			//call_user_func($sidebar);
			$sidebar();
		}
		
		rva_bigboy_block();

		close_section();
	}

	wp_reset_postdata();
}


/*
 * 1 over 2 post thumbnail box
 * 
 * 
*/

function rva_1_over_2_box($title, $slug){
    
    $args = array(
		'orderby'       => 'post_date',
		'order'         => 'DESC',
		'posts_per_page'=> '3',
		'category_name' => $slug,
	);

    $loop = new WP_Query( $args );
    
    start_section($title);

	if( $loop->have_posts() ) {
		hero_story( $loop->the_post());
        //needs padding here
        $loop->post; // skip one
        echo '<div class="cd-2x1-box rva-top-spacing ">';
        while( $loop->have_posts() ): $loop->the_post();
            rva_post_thumbnail();
        endwhile;
        echo '</div>';
    }
    wp_reset_postdata();

    close_section();
}