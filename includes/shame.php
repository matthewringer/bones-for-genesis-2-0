<?php

if( !defined( 'ABSPATH' ) ) exit; // Exit if accessed directly


/* Code to Display Featured Image on top of the post */
add_action( 'genesis_before_entry', 'featured_post_image', 8 );
function featured_post_image() {
  if ( !is_singular( array( 'post', 'page' ) ))  return;
    
		echo '<div class="rva-feature-image" >';
			the_post_thumbnail('large');
		echo '</div>';

		$photog_name = get_post_meta( get_post_thumbnail_id(), 'rva_photographer_name', true );
		echo '<p class="rva-photo-credit">'. $photog_name .'</p>'; 
}

/* Limit exerpt lenght */
function custom_excerpt_length( $length ) {
	return 20;
}
add_filter( 'excerpt_length', 'custom_excerpt_length', 999 );

/**
 * AJAX Load More
 * @link http://www.billerickson.net/infinite-scroll-in-wordpress
 */

function rva_post_summary() {
		echo '<div class="cd-hero-box fx-paralax" style = "background-image: url(' . get_the_post_thumbnail_url() . ');" >';
		echo	'<div class="title-block" >';
		echo		'<h2 class="article-title"><a href="' . get_the_permalink() .'">'. get_the_title() . '</a></h2>';
		echo		'<br/>';
		echo		'<p class="author"><span>' . get_the_author() . '</span></p>';
		echo	'</div>';
		echo '</div>';
}

function rva_post_thumbnails() {
  		echo '<article class="entry-thumbnail">';
			echo 	'<div class="rva-article-image" style="background-image:url('.get_the_post_thumbnail_url().');" > </div>';
			echo 	'<div class="text-block">';
			echo 		'<h3><a href="' . get_the_permalink() .'">'. get_the_title() . '</a></h3>';
			echo 		'<p>' . get_the_excerpt() . '</p>';
			echo 	'</div>';
			echo '</article>';
}

function rva_ajax_load_more() {
	$args = isset( $_POST['query'] ) ? array_map( 'esc_attr', $_POST['query'] ) : array();
	$args['post_type'] = isset( $args['post_type'] ) ? esc_attr( $args['post_type'] ) : 'post';
	$args['paged'] = esc_attr( $_POST['page'] );
	$args['post_status'] = 'publish';
	ob_start();
	$loop = new WP_Query( $args );
	if( $loop->have_posts() ): while( $loop->have_posts() ): $loop->the_post();
		rva_post_thumbnails();
	endwhile; endif; wp_reset_postdata();
	$data = ob_get_clean();
	wp_send_json_success( $data );
	wp_die();
}
add_action( 'wp_ajax_rva_ajax_load_more', 'rva_ajax_load_more' );
add_action( 'wp_ajax_nopriv_rva_ajax_load_more', 'rva_ajax_load_more' );

/**
 * Javascript for Load More
 *
 */
function rva_load_more_js() {

	wp_enqueue_script( 'rva-load-more', get_stylesheet_directory_uri() . '/js/load-more.js', array( 'jquery' ), '1.0', true );
}
add_action( 'wp_enqueue_scripts', 'rva_load_more_js' );

// function rva_load_more_args() {
	
// 	global $wp_query;
// 	$args = array(
// 		'url'   => admin_url( 'admin-ajax.php' ),
// 		'query' => $wp_query->query,
// 	);

//     wp_enqueue_script( 'rva-load-more', get_stylesheet_directory_uri() . '/js/load-more.js', array( 'jquery' ), '1.0', true );
	
//     wp_localize_script( 'rva-load-more', 'rvaloadmore', $args );
// }
//add_action( 'wp_enqueue_scripts', 'rva_load_more_args' );


function rva_infinite_scroll() {
	add_action( 'wp_ajax_rva_ajax_load_more', 'rva_ajax_load_more' );
	add_action( 'wp_ajax_nopriv_rva_ajax_load_more', 'rva_ajax_load_more' );
	add_action( 'wp_enqueue_scripts', 'rva_load_more_js' );
	//add_action( 'wp_enqueue_scripts', 'rva_load_more_args' );
}

/**
 * Custom layout functions
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

function close_section() {
	echo '</div> <!-- End Section -->';
}

function hero_story() {
	$args = array(
		'orderby'       => 'post_date',
		'order'         => 'DESC',
		'posts_per_page'=> '1', // overrides posts per page in theme settings
		'category_name' => 'feature',
	);

	$loop = new WP_Query( $args );
	if( $loop->have_posts() ) {

		// this is shown before the loop
		$loop->the_post();
		//echo get_the_post_thumbnail();
		echo '<div class="cd-hero-box fx-paralax" style = "background-image: url(' . get_the_post_thumbnail_url() . ');" >';
		echo	'<div class="title-block" >';
		echo		'<h2 class="article-title"><a href="' . get_the_permalink() .'">'. get_the_title() . '</a></h2>';
		echo		'<br/>';
		echo		'<p class="author">' . do_shortcode('[post_author_posts_link]') . '</p>';
		echo	'</div>';
		echo '</div>';
	}

	wp_reset_postdata();
}

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
			echo '<article class="entry-thumbnail">';
			echo 	'<div class="rva-article-image" style="background-image:url('.get_the_post_thumbnail_url().');" > </div>';
			echo 	'<div class="text-block">';
			echo 		'<h3><a href="' . get_the_permalink() .'">'. get_the_title() . '</a></h3>';
			echo 		'<p>' . get_the_excerpt() . '</p>';
			echo 	'</div>';
			echo '</article>';
		endwhile;
		echo '</div>';
		if ($sidebar) {
			$sidebar();
		}
		close_section();
	}

	wp_reset_postdata();
}

function widesky_sidebar() {
	echo '<aside class="widesky-sidebar">';
	echo 	'<div class="widesky-ad ">';
	echo 		'<p class="ad-text">WideSky Ad <br> (<span></span>)</p>';
	echo 	'</div>';
	echo 	'<div class="social-buttons" >';
	echo 		'<h2>Follow RVA Mag</h2>';
	echo 		'<ul class="social-buttons">';
	echo 			'<li class="btn-facebook"><a target="_blank" href="'.genesis_get_option('facebook_url').'"><i class="fa fa-facebook" ></i><span>Facebook</span></a></li>';
	echo 			'<li class="btn-twitter"><a target="_blank" href="'.genesis_get_option('twitter_url').'"><i class="fa fa-twitter"></i><span>Twitter</span></a></li>';
	echo 			'<li class="btn-tumblr"><a target="_blank" href="'.genesis_get_option('tumblr_url').'"><i class="fa fa-tumblr"></i><span>Tumblr</span></a></li>';
	echo 			'<li class="btn-youtube"><a target="_blank" href="'.genesis_get_option('youtube_url').'"><i class="fa fa-youtube"></i><span>YouTube</span></a></li>';
	echo 			'<li class="btn-instagram"><a target="_blank" href="'.genesis_get_option('instagram_url').'"><i class="fa fa-instagram"></i><span>Instagram</span></a></li>';
	echo 		'</ul>';
	echo 	'</div>';
	echo '</aside>';
}

function rva_entry_share_links($post) {
	echo	'<ul class="social-buttons social-links">';
	echo		'<li class="btn-facebook"><a target="_blank" href="'.genesis_get_option('share_facebook_url').get_permalink($post).'"><i class="fa fa-facebook" ></i></a></li>';
	echo		'<li class="btn-twitter"><a target="_blank" href="'.genesis_get_option('share_twitter_url').get_permalink($post).'"><i class="fa fa-twitter" ></i></a></li>';
	echo		'<li class="btn-linkedin"><a target="_blank" href="'.genesis_get_option('share_linkedin_url').get_permalink($post).'"><i class="fa fa-linkedin" ></i></a></li>';
	echo		'<li class="btn-email"><a target="_blank" href="'.genesis_get_option('share_email_url').get_permalink($post).'"><i class="fa fa-envelope" ></i></a></li>';
	echo		'<li class="btn-print"><a target="_blank" href="'.genesis_get_option('share_print_url').get_permalink($post).'"><i class="fa fa-print" ></i></a></li>';
	echo		'<li class="btn-message"><a target="_blank" href="'.genesis_get_option('share_message_url').get_permalink($post).'"><i class="fa fa-comment" ></i></a></li>';
	echo	'</ul>';
}

function get_the_tagline(){
	$post_id = get_the_ID();
    $field = 'rva_post_tagline';
    return get_post_meta( $post_id, $field, true );
}