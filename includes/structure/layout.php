<?php

if( !defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/*
 * Force a layout setting for the site
 *
 * See: http://www.briangardner.com/code/force-layout-setting/
 *
 * @since 2.3.38
 */
add_filter( 'genesis_pre_get_option_site_layout', '__genesis_return_content_sidebar' );

/**
 * Gets the id object and returns an int
 * @return int 
 */
function get_cat_id_by_slug($category_slug) {
	$idObj = get_category_by_slug($category_slug); 
	return $idObj->term_id;
}

/**
 *  Hero Story Box
 */
function hero_story($atts) {
	$class = ( is_array($atts) && array_key_exists ( 'class' , $atts ) ) ? $atts['class'] : 'rva-hero-box fx-paralax';
	?>
    	<div class="<?php echo $class; ?>" style = "background-image: url(' <?php echo get_the_post_thumbnail_url(); ?> '); " >
    		<div class="title-block" >
    			<h2 class="article-title"><a href="<?php echo get_the_permalink(); ?>"> <?php echo get_the_title(); ?> </a></h2>
    			<br/>
    			<p class="author"><?php echo do_shortcode('[post_author_posts_link]'); ?> </p>
    		</div>
    	</div>
	<?php
} add_shortcode('rva_hero_box', 'hero_story');

function demi_hero_story($atts) {
	do_shortcode('[rva_hero_box ]');
} add_shortcode('rva_demihero_box', 'demi_hero_story');

/**
 * Horizon
 */
 function horizon_shortcode() {
	 return '<div class="section-title rva-gutter-box collapse-s"></div>';
 } add_shortcode('hr','horizon_shortcode');

/**
 * flex box container
 *
 */
function flex_container ($atts, $content) {
	ob_start();
	?>
	<div class="flex-container <?php echo atts['classes'] ?>" >
		<?php echo do_shortcode($content); ?>
	</div>
	<?php
	return ob_get_clean();
} add_shortcode('rva_flex_box', 'flex_container');

/**
 *  Open an Fullwidth Gutterbox div
 *  $atts [title=>string, classes=>string]
 * 	$content 
 */
function start_section( $atts, $content) {
	ob_start();
	//$class = $atts['class'];
	$class = (array_key_exists('class',$atts))? $atts['class'] : '';
	?>
	<div class="rva-gutter-box <?php echo $class; ?>">
		<?php if($atts['title'] != '') : ?>
		<div class="section-title">
			<h2><?php echo $atts['title']; ?></h2>
		</div>
		<?php endif; ?>
		<?php echo do_shortcode($content); ?> 
	</div> <!-- End Gutter Box Section --> 
	<?php
	//TODO: return not echo....
	return ob_get_clean();
} add_shortcode('rva_layout_section', 'start_section');

function rva_gutter_box_shortcode($atts, $content) {
	return start_section($atts, $content);
} add_shortcode( 'rva_gutter_box', 'rva_gutter_box_shortcode' );

/**
 * Get the post thumbnail markup
 *
 *
 */
function rva_post_thumbnail($class='entry-thumbnail ') { //entry-thumb-vox 
	?>
	<article class="<?php echo $class ?>" >
		<div class="rva-article-image" style="background-image:url(<?php echo get_the_post_thumbnail_url()?>);" >
			<a href=" <?php echo get_the_permalink(); ?>"> <i class="fa fa-play-circle-o" aria-hidden="true"></i> </a>
			<div class="title-block" >
    			<h2 class="article-title"><a href="<?php echo get_the_permalink(); ?>"> <?php echo get_the_title(); ?> </a></h2>
    			<br/>
    			<p class="author"> <?php echo do_shortcode('[post_author_posts_link]'); ?> </p>
				<p class="excerpt"> <?php echo get_the_excerpt() ?> </p>
			</div>
		</div>
	</article>
	<?php
}

/**
 * 
 */
function top_box($atts, $content) {

	$title = $atts['title'];

	$count = ($atts['count'] == '')? '9': $atts['count'];

	$args = array(
		'orderby'       => 'post_date',
		'order'         => 'DESC',
		'posts_per_page'=> $count,
		//TODO: should be not in featured.... fix hardcoded reference!
		'category__not_in' => get_cat_id_by_slug('feature')
	);
	$sidebar = $content;
	
	ob_start();
	$loop = new WP_Query( $args );
	if( $loop->have_posts() ) {
		// loop through posts
		echo '<div class="rva-top-box ">';
		while( $loop->have_posts() ): $loop->the_post();
			rva_post_thumbnail();
			//rva_post_thumbnail('entry-thumb-vox');
		endwhile;
		echo '</div>';
		if ($sidebar != '') {
			echo do_shortcode($sidebar);
		}
	}
	wp_reset_postdata();
	$content = ob_get_clean();
	return $content;
} add_shortcode('rva_topbox', 'top_box');

/**
 * 3 by 6 post thumbnail box
*/
function rva_3x6($atts) {
	
	$title = $atts['title']; 
	$slug = $atts['slug'];
	$class = $atts['class'];
	$count = ( array_key_exists ( 'count' , $atts ) )? $atts['count'] : '9';
	$args = [
		'orderby'       => 'post_date',
		'order'         => 'DESC',
		'posts_per_page'=> $count ,
		'category_name' => $slug 
	];

	ob_start();
	$loop = new WP_Query( $args );
	if( $loop->have_posts() ) {
		// loop through posts
		echo '<div class="rva-3x3-box">';
		while( $loop->have_posts() ): $loop->the_post();
			if($class != null) {
				rva_post_thumbnail($class);
			} else {
				rva_post_thumbnail();
			}
		endwhile;
		echo '</div>';
	}
	wp_reset_postdata();
	$content = ob_get_clean();
	return $content;
} add_shortcode('rva_3x6', 'rva_3x6');

/**
 * 1 over 2 post thumbnail box
 * 
 * TODO: hardcoded styles!
*/
function rva_1_over_2_box($attr, $content) {

	$title = $attr['title']; 
	$slug = $attr['slug'];
	$ad_html = do_shortcode($content);

    $args = array(
		'orderby'       => 'post_date',
		'order'         => 'DESC',
		'posts_per_page'=> '3',
		'category_name' => $slug,
	);

    $loop = new WP_Query( $args );

	ob_start();
	//flex container 
	?> 
	<div class="flex-container"> 
		<div style="flex-grow: 2;"> 
			<?php if( $loop->have_posts() ) :
			//Display hero
			$loop->the_post(); 
			echo do_shortcode('[rva_demihero_box]'); 
			//$loop->post; 
			?>
			<div class="rva-2x1-box margin-top">
				<?php while( $loop->have_posts() ) { 
					$loop->the_post(); 
					//rva_post_thumbnail('entry-thumb-vox '); 
					rva_post_thumbnail(); 

				} ?>
			</div>
			<?php endif;
			wp_reset_postdata(); ?>
		</div>
		<?php echo $ad_html; ?>
	</div> 
	<?php
    $content = ob_get_clean();

	return start_section(array('title'=>$title), $content);
} add_shortcode('rva_1x2','rva_1_over_2_box');
