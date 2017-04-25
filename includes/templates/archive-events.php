<?php
/*
 *	Template Name: Events Template
 */

if( !defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
include 'category.php';
/*
	Template Name: Category Template
*/

global $query_override;
$query_override = [
	//'post_status' => 'draft',
	'category_name' => '',
	'post_type' => 'post',
	'order'         => 'ASC',
	'posts_per_page'=> 7 ,
	'meta_query' => [ [
		'key' => 'rva_post_event_datetime',
		'value' => '',
		'compare' => '!=',
		] ],
	'orderby' => 'meta_value'
	
];

/**
 *
 */
function rva_events_load_more_args() {

	global $query_override;
	rva_load_more_posts(
		1, 
		"entry-thumb-event",
		$query_override,
		'events'
	 );
	 //TODO: figure out CDN stuff
	 wp_enqueue_style('slick-css', 'http://cdn.jsdelivr.net/jquery.slick/1.6.0/slick.css');
	 wp_enqueue_script('slick-js','http://cdn.jsdelivr.net/jquery.slick/1.6.0/slick.min.js');

} add_action( 'wp_enqueue_scripts', 'rva_events_load_more_args' );
remove_action( 'wp_enqueue_scripts', 'rva_load_more_args' );

function append_rvamag_event_slider_before_content() {
	$query = new WP_Query([
		'category_name' => '',
		'post_type' => 'post',
		'order'         => 'ASC',
		'posts_per_page'=> 9 ,
		'meta_query' => [ 
			[
				'key' => 'rva_post_event_datetime',
				'value' => '',
				'compare' => '!=',
			],[
				'key' => 'rva_post_event_mustsee',
				'value' => '1',
				'compare' => '=',
			],
		],
		'orderby' => 'meta_value'
	]);

	ob_start();
	?>
			<div class="section-title margin-top rva-site-margins">
				<h2>MUST SEE SHOWS</h2>
			</div>
		[rva_gutter_box class="flex-container padding-top margin-top"]
			<div id="rva-event-carousel" >
				<?php while( $query->have_posts() ) : $query->the_post(); global $post; ?>
					<div class="slide-wrapper">
						<article class="rva-event-thumbnail" style="background-image: url(<?php echo get_the_post_thumbnail_url($post->ID); ?>);">
							<h2 class="event-date"> 
								<?php 
								$meta_eventdate = get_post_meta($post->ID, 'rva_post_event_datetime', true);
								$raw_date = date_create($meta_eventdate);
								echo date_format($raw_date, 'l, m/d'); ?> 
							</h2>

							<div class="details-block">
								<h2 class="article-title"><a href="<?php echo get_the_permalink(); ?>"> <?php echo get_post_meta($post->ID, 'rva_post_event_title', true); ?> </a></h2>
								<?php echo rva_social_sharing_buttons(); ?>
							</div>
						</article>
					</div>
				<?php endwhile; ?>
			</div>
		[/rva_gutter_box]
		<script type="text/javascript">
			$('#rva-event-carousel').slick(
				{	'slidesToShow': 3,
					'prevArrow': '<div class="rva-prev-link"><i class="fa fa-chevron-left" ></i></div>',
					'nextArrow': '<div class="rva-next-link"><i class="fa fa-chevron-right" ></i></div>',
					'responsive': [{
						'breakpoint': 1024,
						'settings': {
							'slidesToShow': 2,
						}
					}, {
						'breakpoint': 729,
						'settings': {
							'slidesToShow': 1,
						}
					}]
				}
			);
		</script>
		<div class="section-title margin-top rva-site-margins"></div>
	<?php
	echo do_shortcode(ob_get_clean());
}
add_action('genesis_before_content_sidebar_wrap', 'append_rvamag_event_slider_before_content');

/**
 * Calendar loop
 */
function do_calendar() {

	$query = new WP_Query([
		'category_name' => '',
		'post_type' => 'post',
		'order'         => 'ASC',
		'posts_per_page'=> 7 ,
		'meta_query' => [ 
			[
				'key' => 'rva_post_event_datetime',
				'value' => '',
				'compare' => '!=',
			],[
				'key' => 'rva_post_event_editorspick',
				'value' => '1',
				'compare' => '=',
			],
		],
		'orderby' => 'meta_value'
	]);

	ob_start();
	?>
	[rva_content_section]
	<div class="rva-1x-box margin-top" >
		<div class="event-list-date testing">
			<i class="fa fa-caret-right open-trigger" aria-hidden="true"></i>
			<h3 class="open-trigger">Editor's Picks</h3>
			<div class="rva-accordian" >
				<div class="rva-event-group editors-picks">
					<?php
						while( $query->have_posts() ) {
							$query->the_post();
							echo rva_filter_event_thumbnail(null);
						}
					?>
				</div>
			</div>
		</div>
	</div>

	<div class="post-listing rva-1x-box" ></div>
	[/rva_content_section]
	<?php

	echo do_shortcode(ob_get_clean());
}
add_action( 'genesis_loop', 'do_calendar');
remove_action( 'genesis_loop', 'rvamag_categorypage_loop' );

function rva_events_sidebar(){
	//echo '<div class="post-listing rva-1x-box margin-top" ></div>';
	echo '<div class="margin-top padding-top"></div>';
	echo do_shortcode('[rva_ad name="Big_Boy_H0" class="margin-top wrap ad-big-boy"]');
} add_action('genesis_sidebar','rva_events_sidebar'); 
remove_action('genesis_sidebar', 'rva_sidebar', 5);


remove_action ('genesis_after_content_sidebar_wrap', 'rva_fp_aftercontent');


genesis();