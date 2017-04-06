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
			'post_type' => 'events',
			'orderby'       => 'post_date',
			'order'         => 'ASC',
			'posts_per_page'=> $count ,
			'meta_query' => [ [
				'key' => 'wpcf-eventdate',
				'operator' => 'EXISTS'
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

} add_action( 'wp_enqueue_scripts', 'rva_events_load_more_args' );
remove_action( 'wp_enqueue_scripts', 'rva_load_more_args' );


function filter_thumbnail( $content ) {
	global $post;

	$meta_eventdate = get_post_meta($post->ID, 'wpcf-eventdate', true);
	$meta_eventlocation = get_post_meta($post->ID, 'wpcf-eventlocation', true);
	$meta_eventtime = get_post_meta($post->ID, 'wpcf-eventtime', true);

	$date = date_create();
	date_timestamp_set($date, $meta_eventdate);
	$date = date_format($date, 'U = Y-m-d H:i:s');  

	ob_start();
	?>
	<article class="rva-event-thumbnail" >
		<!--<a href=""><span class="rva-sponsored-by"> The National <i class="fa fa-external-link" aria-hidden="true"></i> </span></a>-->
		<?php echo get_the_post_thumbnail();?>
		<div class="rva-article-image" style="background-image:url(<?php echo get_the_post_thumbnail_url()?>);" >
			<div class="title-block" >
    			<h2 class="article-title"><a href="<?php echo get_the_permalink(); ?>"> <?php echo get_thumbnail_title(); ?> </a></h2>
				<span class="rva-event-date"> <?php 
					echo $date;
				?> </span>
				<span class="rva-event-location"> <?php echo $meta_eventlocation; ?> </span>
				<span class="rva-event-time"> <?php echo $meta_eventtime; ?> </span>
				<p class="excerpt"> 
					<?php echo rva_get_excerpt(140, 'content'); ?>
				</p>
			</div>
		</div>
	</article>
	<?php
	$content = ob_get_clean();
	return $content;
} 	add_filter('rva_thumbnail_content', 'filter_thumbnail' );

/**
 * Calendar loop
 */
function do_calendar() {

	// $args = json_encode( [
	// 		'post_type' => 'events',
	// 		'orderby'       => 'post_date',
	// 		'order'         => 'DESC',
	// 		'posts_per_page'=> $count ,
	// 		//'category_name' => $slug
	// 	]);

	// global $wp_query;
	// echo rva_3x6([
	// 	'layout' => 'rva-1x-box',
	// 	'args' => $args
	// 	]);
    echo start_section([], '<div class="post-listing rva-1x-box margin-top" ></div>' );
}
add_action( 'genesis_loop', 'do_calendar');
remove_action( 'genesis_loop', 'rvamag_categorypage_loop' );

function rva_events_sidebar(){
	echo spingo_events_widget();
	echo '<div class="margin-top padding-top"></div>';
	echo do_shortcode('[rva_ad name="Big_Boy_H0" class="margin-top wrap ad-big-boy"]');
} add_action('genesis_sidebar','rva_events_sidebar'); 
remove_action('genesis_sidebar', 'rva_sidebar', 5);


remove_action ('genesis_after_content_sidebar_wrap', 'rva_fp_aftercontent');


genesis();