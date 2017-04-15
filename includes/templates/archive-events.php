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

function append_rvamag_before_content() {
	ob_start();
	// must see events carosel
	?>
		[rva_gutter_box class="flex-container padding-top margin-top"]
		<div class="rva-event-carousel" >
			<div class="rva-prev-link"><i class="fa fa-chevron-left" ></i></div>
			<div class="rva-carousel-mask">
				<div class="rva-carousel-contents">
					<div class="rva-event-thumbnail">
						<img src="<?php echo get_stylesheet_directory_uri(); ?>/images/logo.svg" alt="RVA Mag Logo" />
					</div>
					<div class="rva-event-thumbnail">
						<img src="<?php echo get_stylesheet_directory_uri(); ?>/images/logo.svg" alt="RVA Mag Logo" />
					</div>
					<div class="rva-event-thumbnail">
						<img src="<?php echo get_stylesheet_directory_uri(); ?>/images/logo.svg" alt="RVA Mag Logo" />
					</div>
					<div class="rva-event-thumbnail">
						<img src="<?php echo get_stylesheet_directory_uri(); ?>/images/logo.svg" alt="RVA Mag Logo" />
					</div>
					<div class="rva-event-thumbnail">
						<img src="<?php echo get_stylesheet_directory_uri(); ?>/images/logo.svg" alt="RVA Mag Logo" />
					</div>
					<div class="rva-event-thumbnail">
						<img src="<?php echo get_stylesheet_directory_uri(); ?>/images/logo.svg" alt="RVA Mag Logo" />
					</div>
					<div class="rva-event-thumbnail">
						<img src="<?php echo get_stylesheet_directory_uri(); ?>/images/logo.svg" alt="RVA Mag Logo" />
					</div>
					<div class="rva-event-thumbnail">
						<img src="<?php echo get_stylesheet_directory_uri(); ?>/images/logo.svg" alt="RVA Mag Logo" />
					</div>
					<div class="rva-event-thumbnail">
						<img src="<?php echo get_stylesheet_directory_uri(); ?>/images/logo.svg" alt="RVA Mag Logo" />
					</div>
				</div>
			</div>
			<div class="rva-next-link"><i class="fa fa-chevron-right" ></i></div>
		</div>
		[/rva_gutter_box]
		<script type="text/javascript">

			const delta = 20;
			//const delta = $('.rva-event-thumbnail').width()/$('.rva-carousel-mask').width() * 100;

			$('.rva-event-carousel .rva-next-link').on('click', function(){
				console.log('click next');
				$('.rva-carousel-contents').addClass('animate');
				$('.rva-carousel-contents').animate( { go: -delta, }, slide, 'linear');
			});

			$('.rva-event-carousel .rva-prev-link').on('click', function(){
				console.log('click prev');
				$('.rva-carousel-contents').animate( { go: delta, }, slide, 'linear');
			});

			let slide = {
					step: function(now, fx) {

						console.log(`now: ${now} start: ${fx.start} end: ${fx.end}`);
						console.log(this.go);
						let offset = now - delta*4;


						// Offset start negative(left) if now is zero and scrolling right
						if( 0 == now && delta == fx.end ) {
							fx.start = delta;
							//fx.start = 0;
						} 
						
						//Start at zero if now and end will be the same location and scrollign right.
						if( delta == now && delta == fx.end ) {
							fx.start = 0;
						} 

						// If now and start are both at delta or zero offset to negative delta
						if( (delta == now && delta == fx.start) || (0 == now && 0 == fx.start ) ) {
							fx.start = -delta;
							fx.end = -delta;
						 }

						$(this).css('-webkit-transform',`translate3d(${offset}%, 0px, 0px)`);
						$(this).css('-moz-transform',`translate3d(${offset}%, 0px, 0px)`);
						$(this).css('transform',`translate3d(${offset}%, 0px, 0px)`);
					},
					duration: 300,
					complete: function(){
						let now = -20; // -delta;
						$(this).css('-webkit-transform',`translate3d(${now}%, 0px, 0px)`);
						$(this).css('-moz-transform',`translate3d(${now}%, 0px, 0px)`);
						$(this).css('transform',`translate3d(${now}%, 0px, 0px)`);
						$('.rva-carousel-contents').removeClass('animate');
					}
				};

		</script>
	<?php
	
	echo do_shortcode(ob_get_clean());

} add_action('genesis_before_content_sidebar_wrap', 'append_rvamag_before_content');
//remove_action('genesis_before_content_sidebar_wrap', 'rvamag_before_content');


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

	echo start_section([], '<div class="post-listing rva-1x-box margin-top" ></div>' );

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