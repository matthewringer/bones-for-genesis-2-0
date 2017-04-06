<?php
/*
 *	Template Name: Events Template
 */

if( !defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
include 'category.php';
/*
	Template Name: Category Template
*/

add_filter( 'genesis_pre_get_option_site_layout', '__genesis_return_full_width_content' );

/**
 *
 */
function rva_events_load_more_args() {

	global $query_override;
	rva_load_more_posts(1, "entry-thumb-event", $query_override );

} add_action( 'wp_enqueue_scripts', 'rva_events_load_more_args' );
remove_action( 'wp_enqueue_scripts', 'rva_load_more_args' );

function rvamag_magazine_archive_loop() {
	echo rva_3x6([ 
		'args' => json_encode( [
			'post_type'	=> ['magazine'], //, 'issues'],
			'orderby'	=> 'post_date',
			'order'		=> 'DESC',
			'posts_per_page'	=> 6 ,
		])
	]);

	?><script type="text/javascript">
		let covers = [...document.querySelectorAll('.issuuembed')];
		covers.push( [...document.querySelectorAll('.excerpt iframe')] );
		covers.map(x=>{
			x.style.height = '300px';
			x.style.width = '300px';
		});
	</script> <?php
}
remove_action( 'genesis_loop', 'rvamag_categorypage_loop' );
add_action( 'genesis_loop', 'rvamag_magazine_archive_loop');


function filter_thumbnail( $content ) {
	global $post;

	ob_start();
	?>
	<article class="rva-event-thumbnail" >
		<div class="rva-article-image" style="background-image:url(<?php echo get_the_post_thumbnail_url()?>);" >
			<div class="title-block" >
				<p class="excerpt"> 
					<?php echo get_the_content(); ?>
				</p>
				<h2 class="article-title"><a href="<?php echo get_the_permalink(); ?>"> <?php echo get_thumbnail_title(); ?> </a></h2>
			</div>
		</div>
	</article>
	<?php
	$content = ob_get_clean();
	return $content;
} 	add_filter('rva_thumbnail_content', 'filter_thumbnail' );

remove_action ('genesis_after_content_sidebar_wrap', 'rva_fp_aftercontent');


genesis();