<?php

if( !defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/*
 * Force a layout setting for the site
 *
 * See: http://www.briangardner.com/code/force-layout-setting/
 *
 * @since 2.3.38
 */
add_filter( 'genesis_pre_get_option_site_layout', '__genesis_return_full_width_content' );

/**
 *  Hero Story Box
 * 
 * 
 */
function hero_story($atts) {
	$class = ( is_array($atts) && array_key_exists ( 'class' , $atts ) ) ? $atts['class'] : 'cd-hero-box fx-paralax';
	?>
    	<div class="<?php echo $class; ?>" style = "background-image: url(' <?php echo get_the_post_thumbnail_url(); ?> '); " >
    		<div class="title-block" >
    			<h2 class="article-title"><a href="<?php echo get_the_permalink(); ?>"> <?php echo get_the_title(); ?> </a></h2>
    			<br/>
    			<p class="author"><?php echo do_shortcode('[post_author_posts_link]'); ?> </p>
    		</div>
    	</div>
	<?php
}
add_shortcode('rva_hero_box', 'hero_story');

function demi_hero_story($atts) {
	do_shortcode('[rva_hero_box class="rva-demi-hero"]');
}
add_shortcode('rva_demihero_box', 'demi_hero_story');

/**
 *  Open an Fullwidth Gutterbox div
 * 
 * 
 */
function start_section($title, $classes = '') {
?>
	<div class="cd-gutter-box <?php echo $classes; ?>">
		<div class="section-title">
			<h2><?php echo $title; ?></h2>
		</div>
<?php
}

/**
 *  Close a div
 * 
 * 
 */
function close_section() {
	?> </div> <!-- End Gutter Box Section --> <?php
}

function rva_gutter_box_shortcode($atts, $content) {
	start_section($atts['title'], $atts['classes']);
	echo do_shortcode($content);
	close_section();
}
add_shortcode( 'rva_gutter_box', 'rva_gutter_box_shortcode' );

/**
 * Get the post thumbnail markup
 *
 *
 */
function rva_post_thumbnail() {
	?>
	<article class="entry-thumbnail ">
		<a href="<?php echo get_the_permalink(); ?>">
			<div class="rva-article-image " style="background-image:url(<?php echo get_the_post_thumbnail_url()?>);" ></div>
			<div class="text-block ">
				<h2><?php echo get_the_title() ?></h2>
				<p> <?php echo get_the_excerpt() ?> </p>
			</div>
		</a>
	</article>
	<?php
}

/**
 * 3 by 6 post thumbnail box
 * 
 * 
*/
function cb_3x6($title, $args, $sidebar = '') {
	$loop = new WP_Query( $args );
	if( $loop->have_posts() ) {
		// loop through posts

		start_section($title, "flex");
		
		$sidebar_class = "";
		
		if ($sidebar) {
			$sidebar_class = "cd-sidebar";
		}
		
		echo '<div class="cd-3x3-box ' . $sidebar_class . '">';

		while( $loop->have_posts() ): $loop->the_post();
			rva_post_thumbnail();
		endwhile;
		echo '</div>';
		if ($sidebar != '') {
			echo do_shortcode($sidebar);
		}
		
		//rva_bigboy_block();

		close_section();
	}

	wp_reset_postdata();
}


/**
 * 1 over 2 post thumbnail box
 * 
 * 
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
    start_section($title);
	//flex container 
	?> 
	<div class="flex-container"> 
		
		<div style="flex: 1;"> 
			<?php if( $loop->have_posts() ) :
			//Display hero
			$loop->the_post(); 
			echo do_shortcode('[rva_demihero_box]');
			$loop->post; ?>
			<div class="cd-2x1-box rva-top-spacing ">
				<?php while( $loop->have_posts() ) { $loop->the_post(); rva_post_thumbnail(); } ?>
			</div>
			<?php endif;
			wp_reset_postdata(); ?>
		</div>
		<?php if($ad_html != ''): ?>
		<div style="flex: 0 1 120px; margin-left:1em;"> <?php echo $ad_html; ?> </div>
		<?php endif; ?>
	</div> 
	<?php
	echo do_shortcode('[rva_ad name="Leaderboard" class="wrap ad-leaderboard"]');
    close_section();
}
add_shortcode('rva_1x2','rva_1_over_2_box');
