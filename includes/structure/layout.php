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
function hero_story($post) {
	?>
    	<div class="cd-hero-box fx-paralax" style = "background-image: url(' <?php echo get_the_post_thumbnail_url($post); ?> '); " >
    		<div class="title-block" >';
    			<h2 class="article-title"><a href="<?php echo get_the_permalink($post); ?>"> <?php echo get_the_title($post); ?> </a></h2>
    			<br/>
    			<p class="author"><?php echo do_shortcode('[post_author_posts_link]'); ?> </p>
    		</div>
    	</div>
	<?php
}


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
function rva_1_over_2_box($title, $slug, $ad_html = '') {
    
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
		<?php if($ad_html != ''): ?>
		<div style="flex: 0 1 120px; margin-right:1em;"> <?php echo $ad_html; ?> </div>
		<?php endif; ?>
		<div style="flex: 1;"> 
			<?php if( $loop->have_posts() ) :
			//Display hero
			hero_story( $loop->the_post() ); $loop->post; ?>
			<div class="cd-2x1-box rva-top-spacing ">
				<?php while( $loop->have_posts() ) { $loop->the_post(); rva_post_thumbnail(); } ?>
			</div>
			<?php endif;
			wp_reset_postdata(); ?>
		</div> 
	</div> 
	<?php
    close_section();
}

/**
 *
 */
function rva_big_boy_h0_sidebar_shortcode($attrs, $content) {
	?> 
	<aside class="big-boy-h0-sidebar"> 
	<?php
		
		echo do_shortcode('[rva_ad name="Big_Boy_H0" class="wrap ad-big-boy"]');
		rva_social_follow_buttons();
		echo do_shortcode($content);
	?> 
	</aside> 
	<?php
}
add_shortcode( 'rva_big_boy_h0_sidebar', 'rva_big_boy_h0_sidebar_shortcode' );

/**
 *
 */
function rva_social_follow_buttons() {
	$options =  get_option( RVA_SETTINGS_FIELD ); 
	?>
	<div class="social-buttons pad-bottom" >
		<h2>Follow RVA Mag</h2>
		<ul class="social-buttons">

			<li class="btn-facebook"><a target="_blank" href="<?php echo esc_attr( $options['rva_socialmedia_facebook_url'] ); ?> "><i class="fa fa-facebook" ></i><span>Facebook</span></a></li>
			<li class="btn-twitter"><a target="_blank" href="<?php echo esc_attr( $options['rva_socialmedia_twitter_url'] ); ?>"><i class="fa fa-twitter"></i><span>Twitter</span></a></li>
			<li class="btn-tumblr"><a target="_blank" href="<?php echo esc_attr( $options['rva_socialmedia_tumblr_url'] ); ?>"><i class="fa fa-tumblr"></i><span>Tumblr</span></a></li>
			<li class="btn-youtube"><a target="_blank" href="<?php echo esc_attr( $options['rva_socialmedia_youtube_url'] ); ?>"><i class="fa fa-youtube"></i><span>YouTube</span></a></li>
			<li class="btn-instagram"><a target="_blank" href="<?php echo esc_attr( $options['rva_socialmedia_instagram_url'] ); ?>"><i class="fa fa-instagram"></i><span>Instagram</span></a></li>
		</ul>
	</div>
	<?php 
}
