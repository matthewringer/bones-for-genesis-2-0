<?php

/**
 * Localize scripts for ajax infinite scroll callback 
 */
function rva_load_more_posts($start_page = 3, $thumb_style = 'entry-thumbnail', $sub_queries = null, $layout = null) {

	$stylesheet_dir        = get_stylesheet_directory_uri();
	$use_production_assets = genesis_get_option('bfg_production_on');
	$use_production_assets = !empty($use_production_assets);

	$src = $use_production_assets ? '/build/js/load-more.min.js' : '/build/js/load-more.js';
	
	wp_enqueue_script( 'rva-load-more', $stylesheet_dir . $src, array('jquery'), null, true );
	
	global $wp_query;
	$query = $wp_query->query;

	if(is_array($sub_queries)) {
		foreach ( $sub_queries as $key => $value ) {
			$query[$key] =  $value;
		}
	}

	$args = [
		'url'	=> admin_url( 'admin-ajax.php' ),
		'action' => 'rva_ajax_load_more',
		'button_selector' => '.load-more',
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

	if( isset( $layout ) && $layout != '' ) {

		$layouts = [
			'events' => 'rva_filter_event_thumbnail',
			'magazine' => 'rva_filter_magazine_thumbnail'
		];

		add_filter( 'rva_thumbnail_content', $layouts[$layout] );

	}

	$loop = new WP_Query( $args );
	$count = $loop->post_count;
	$total = $loop->found_posts;
	$max_pages = $loop->max_num_pages;

	ob_start();

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

/**
 *
 */
function value_or_default($value, $default) {
	return ( $value === '' || !isset($value) || is_null($value) ) ? $default : $value;
}

/**
 *
 */
function rva_filter_event_thumbnail( $content ) {
	global $post;

	$title = get_post_meta($post->ID, 'rva_post_event_title', true); 				// value_or_default( , get_thumbnail_title() );
	$description = get_post_meta($post->ID, 'rva_post_event_description', true); 	//value_or_default( , rva_get_excerpt(140, 'content') );
	$meta_eventdate = get_post_meta($post->ID, 'rva_post_event_datetime', true); 	// wpcf-eventdate wpcf-eventtime
	$meta_eventlocation = get_post_meta($post->ID, 'rva_post_event_venue', true); 	//'wpcf-eventlocation', 
	$meta_eventprice = get_post_meta($post->ID, 'rva_post_event_price', true); 		// value_or_default( , 'FREE' );
	$meta_eventtickets = get_post_meta($post->ID, 'rva_post_event_tickets', true); 	// value_or_default( , 'TICKETS' );
	
	$raw_date = date_create($meta_eventdate);
	$time = date_format($raw_date, 'h:i A');
	$date = date_format($raw_date, 'l, M d');

	ob_start();
	?><article class="entry-thumb-event" data-date="<?php echo date_format($raw_date, 'Ymd'); ?>" data-display-date="<?php echo $date; ?>" data-id="<?php echo $post->ID; ?>" >
		<div class="title-block" >
			<h2 class="article-title"><a href="<?php echo get_the_permalink(); ?>"> <?php echo $title; ?> </a></h2>
		</div>
		<div class="details-block">
			<h2 class="rva-event-date"> <?php echo $date; ?> </h2>
			<h3 class="rva-event-time"> <?php echo $time; ?> </h3>
			<h3 class="rva-event-location"> <?php echo $meta_eventlocation; ?> </h3>
			<h3 class="rva-event-price"> <?php echo $meta_eventprice; ?> </h3>
			<p class="excerpt"> 
				<?php echo $description; ?>
			</p>
			<?php
			if( '' !== $meta_eventtickets ) {
				echo '<a class="rva-event-tickets-link" href="'.$meta_eventtickets.'" target="_blank" alt="event tickets">TICKETS</a>';
			}
			?>
		</div>
	</article><?php $content = ob_get_clean();
	return $content;
}

/**
 *
 */
function rva_filter_magazine_thumbnail( $content ) {
	global $post;

	ob_start();
	?>
	<article class="entry-thumb-cover" >
		<div class="rva-article-image" style="background-image:url(<?php echo get_the_post_thumbnail_url()?>);" >
			
		</div>
		<div class="title-block" >
				<h2 class="article-title"> <a href="<?php echo get_the_permalink(); ?>"> <?php echo get_post_meta($post->ID, 'wpcf-issuenumber', true); ?> </a></h2>
				<h3 class="article-title"><a href="<?php echo get_the_permalink(); ?>"> <?php echo get_thumbnail_title(); ?> </a></h3>
		</div>
	</article>
	<?php
	$content = ob_get_clean();
	return $content;
} 	