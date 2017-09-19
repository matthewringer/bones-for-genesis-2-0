<?php

if( !defined( 'ABSPATH' ) ) exit; // Exit if accessed directly


/**
 * Hook header class to remove the header offset.
 */
function rva_set_search_content_class($attrs) {

	$attrs['class'] = $attrs['class'].' search-content';
	
	return $attrs;

} add_filter( 'genesis_attr_content', 'rva_set_search_content_class' );

/**
 * Before content sidebar wrapper.
 */
 function rva_before_content_wrap(){

	?>
	<div class="rva-category-before-content"></div>
	<?php

} add_action('genesis_before_content_sidebar_wrap', 'rva_before_content_wrap');

/**
 * Copied from the Genesis search.php file. Putting it here allows overriding.
 *
 * @since 1.9.0
 */
function bfg_do_search_title() {

	$title = sprintf( '<div class="archive-description"><h1 class="archive-title">%s %s</h1></div>', apply_filters( 'genesis_search_title_text', __( 'Search Results for:', CHILD_THEME_TEXT_DOMAIN ) ), get_search_query() );

	echo apply_filters( 'genesis_search_title_output', $title ) . "\n";

} //add_action( 'genesis_before_loop', 'bfg_do_search_title' );

/**
 * Main content Loop 
 *
 */
function search_content_loop() {

	ob_start();
	echo rva_searchform();
	global $wp_query;
?>
<div class="wapper">
	<div class="contentarea clearfix">
		<div class="content">
			<h1 class="search-title"> <?php echo $wp_query->found_posts; ?> <?php _e( 'Search Results Found For', 'locale' ); ?>: "<?php the_search_query(); ?>" </h1>
				<?php if ( have_posts() ) { 
						while ( have_posts() ) { $post = the_post(); ?>
					<article class="search-entry">
						<div class="title-block" >
							<h2 class="article-title" > <a href="<?php echo get_permalink(); ?>"> <?php the_title();  ?> </a> <?php echo ' | ' . genesis_post_date_shortcode([]); ?> </h2>
							<p class="excerpt"> 
							<?php
								echo rva_get_excerpt(500, 'content');
								?>
							</p>:
						</div>
					</article>
					<?php
					}
				echo get_the_posts_pagination([
					'mid_size'           => 1,
					'prev_text'          => _x( '<', 'previous page of results' ),
					'next_text'          => _x( '>', 'next page of results' ),
					'screen_reader_text' => __( 'Search results navigation' ),
				]);
				} ?>
		</div>
	</div>
</div>

	<?php
	echo ob_get_clean();

} 
add_action('genesis_loop', 'search_content_loop', 9);


add_filter( 'the_content', function($content) {
	//$content = wp_strip_all_tags(get_the_excerpt());
	return $content;
});

remove_action( 'genesis_loop', 'genesis_do_loop' );
//add_action('genesis_loop','genesis_grid_loop');

genesis();
