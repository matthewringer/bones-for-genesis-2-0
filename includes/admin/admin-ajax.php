<?php

function rva_ajax_load_more() {
	$args = isset( $_POST['query'] ) ? array_map( 'esc_attr', $_POST['query'] ) : array();
	$args['post_type'] = isset( $args['post_type'] ) ? esc_attr( $args['post_type'] ) : 'post';
	$args['paged'] = esc_attr( $_POST['page'] );
	$args['post_status'] = 'publish';
	ob_start();
	$loop = new WP_Query( $args );
	$count = $loop->found_posts;
	$max_pages = $loop->max_num_pages;
	if( $loop->have_posts() ): while( $loop->have_posts() ): $loop->the_post();
		rva_post_thumbnail();
	endwhile; endif; wp_reset_postdata();
	
	echo '<hr>';
	echo do_shortcode('[rva_ad name="Leaderboard" class="wrap ad-leaderboard"]');
	echo '<hr>';
	$response = array();
	$response['thumbs'] = ob_get_clean();
	$response['count'] = $count;
	$response['max_pages'] = $max_pages;
	wp_send_json_success( $response );
	wp_die();
}

add_action( 'wp_ajax_rva_ajax_load_more', 'rva_ajax_load_more' );
add_action( 'wp_ajax_nopriv_rva_ajax_load_more', 'rva_ajax_load_more' );