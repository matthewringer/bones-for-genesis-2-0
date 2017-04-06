<?php

/**
 * Localize scripts for ajax infinite scroll callback 
 */
function rva_load_more_posts($start_page = 3, $thumb_style = 'entry-thumbnail', $sub_queries = null, $layout = null) {

	wp_enqueue_script( 'rva-load-more', get_stylesheet_directory_uri() . '/js/load-more.js', array( 'jquery' ), '1.0', true );

	global $wp_query;
	$query = $wp_query->query;

	if(is_array($sub_queries)) {
		foreach ( $sub_queries as $key => $value ) {
			$query[$key] =  $value;
		}
	}

	$args = [
		'url'	=> admin_url( 'admin-ajax.php' ),
		'query' => json_encode($query),
		'thumb_style' => $thumb_style,
		'startpage' => $start_page,
		'layout' => $layout
	];

	wp_localize_script( 'rva-load-more', 'rvaloadmore', $args );

}

/**
 *
 */
function rva_ajax_load_more() {

	//$args = isset( $_POST['query'] ) ? array_map( 'esc_attr', $_POST['query'] ) : array();
	//extract( [ 'thumb_style' => 'entry-thumbnail', 'layout' => '', 'page' => null, 'posts_per_page' => null] , $_POST );
	
	$thumb_style = isset( $_POST['thumb_style'] ) ? $_POST['thumb_style'] : '';
	$layout = isset( $_POST['layout'] ) ? $_POST['layout'] : null;

	$args = isset( $_POST['query'] ) ? json_decode( stripslashes(  $_POST['query'] ), true ) : array();
	$args['post_type'] = isset( $args['post_type'] ) ? esc_attr( $args['post_type'] ) : 'post';
	$args['post_status'] = 'publish';
	
	if( isset( $_POST['page'] ) ) {
		$args['paged'] = esc_attr( $_POST['page'] );
	}

	if( isset( $_POST['posts_per_page'] ) ) {
		$args['posts_per_page'] = esc_attr( $_POST['posts_per_page'] );
	}

	if( isset( $layout ) ) {

		$layouts = [
			'events' => 'rva_filter_event_thumbnail'
		];

		add_filter('rva_thumbnail_content', $layouts[$layout] );
	}

	$loop = new WP_Query( $args );

	$count = $loop->post_count;
	$total = $loop->found_posts;
	$max_pages = $loop->max_num_pages;

	ob_start();

	$current_date = null;

	if( $loop->have_posts() ) {

		while( $loop->have_posts() ) {
			
			$loop->the_post();

			if($layout == 'events') {
				//print the day, month day box
				global $post;
				$event_date = rva_get_date_header($post);
				if($event_date != $current_date) {
					echo '<div class="event-list-date"><h3>'.$event_date.'</h3></div>';
					$current_date = $event_date;
				}

			}

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


function rva_get_date_header($post) {

	$meta_eventdate = get_post_meta($post->ID, 'wpcf-eventdate', true);
	$date = date_create();
	date_timestamp_set($date, $meta_eventdate);
	return date_format($date, 'l, F d');

}

function rva_filter_event_thumbnail( $content ) {
	global $post;

	$meta_eventdate = get_post_meta($post->ID, 'wpcf-eventdate', true);
	$meta_eventlocation = get_post_meta($post->ID, 'wpcf-eventlocation', true);
	$meta_eventtime = get_post_meta($post->ID, 'wpcf-eventtime', true);

	$date = date_create();
	date_timestamp_set($date, $meta_eventdate);

	$time = date_format($date, 'h:iA');
	$day = date_format($date, 'l');
	$date = date_format($date, 'l, F d');

	ob_start();
	?>
	<article class="entry-thumb-event" >
		<?php echo get_the_post_thumbnail($post_id, [100,100]);?>
		<div class="title-block" >
			<h3 class="rva-event-date"> <?php echo $time; ?> </h3>
			<h2 class="article-title"><a href="<?php echo get_the_permalink(); ?>"> <?php echo get_thumbnail_title(); ?> </a></h2>
			<h3 class="rva-event-location"> <?php echo $meta_eventlocation; ?> </h3>
			<p class="excerpt"> 
				<?php echo rva_get_excerpt(140, 'content'); ?>
			</p>
		</div>
	</article>
	<?php
	$content = ob_get_clean();
	return $content;
}