<?php

/**
 * Localize scripts for ajax infinite scroll callback 
 */
function rva_load_more_posts($start_page = 3, $thumb_style = 'entry-thumbnail', $sub_queries = null) {

	wp_enqueue_script( 'rva-load-more', get_stylesheet_directory_uri() . '/js/load-more.js', array( 'jquery' ), '1.0', true );

	global $wp_query;
	$query = $wp_query->query;

	if(is_array($sub_queries)) {
		foreach ( $sub_queries as $key => $value ) {
			$query[$key] =  $value;
		}
	}

	$args = [
		'url'   => admin_url( 'admin-ajax.php' ),
		'query' => json_encode($query),
		'thumb_style' => $thumb_style,
		'startpage' => $start_page,
	];

	wp_localize_script( 'rva-load-more', 'rvaloadmore', $args );

}

/**
 *
 */
function rva_ajax_load_more() {

	//$args = isset( $_POST['query'] ) ? array_map( 'esc_attr', $_POST['query'] ) : array();
	$thumb_style = isset( $_POST['thumb_style'] ) ? $_POST['thumb_style'] : array();

	$args = isset( $_POST['query'] ) ? json_decode( stripslashes(  $_POST['query'] ), true ) : array();
	$args['post_type'] = isset( $args['post_type'] ) ? esc_attr( $args['post_type'] ) : 'post';
	
	$args['post_status'] = 'publish';
	
	if(isset( $_POST['page'] ) ) {
		$args['paged'] = esc_attr( $_POST['page'] );
	}

	if(isset( $_POST['posts_per_page'] )) {
		$args['posts_per_page'] = esc_attr( $_POST['posts_per_page'] );
	}

	$loop = new WP_Query( $args );

	$count = $loop->post_count;
	$total = $loop->found_posts;
	$max_pages = $loop->max_num_pages;

	ob_start();
	// echo "hello ajax ";
	// echo $count ." ". $total . " "; 
	// echo print_r($args);

	if( $loop->have_posts() ) {

		while( $loop->have_posts() ) {
			$loop->the_post();
			echo do_shortcode('[rva_post_thumbnail class="'.$thumb_style.'"]');
		}

	}
	wp_reset_postdata();
	
	$thumbs = ob_get_clean();
	$response = array();
	$response['thumbs'] = $thumbs;
	$response['count'] = $count;
	$response['total'] = $total;
	$response['max_pages'] = $max_pages;
	wp_send_json_success( $response );
	wp_die();
} add_action( 'wp_ajax_rva_ajax_load_more', 'rva_ajax_load_more' );
  add_action( 'wp_ajax_nopriv_rva_ajax_load_more', 'rva_ajax_load_more' );