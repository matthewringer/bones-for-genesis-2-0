<?php



add_action( 'genesis_before_header', 'rva_before_header' );
/** 
* Leaderboard ad
*
* @since 1.0.0
*/
function rva_before_header($ad_unit) {
	

	?>
	<div class="before-header">
		<?php echo do_shortcode('[dfp_ads name="m_home_header"]'); ?>
	</div>
	<?php
}

/** 
* Leaderboard ad
*
* @since 1.0.0
*/
function rva_leaderboard_ad($placement) {
	?>
	<div class="wrap ad-leaderboard ">
		<!-- TODO: insert ad here  -->
		<?php if (true): ?>
			<!-- /53299010/Leaderboard -->
			<div id='div-gpt-ad-1486844719982-5' style='height:90px; width:728px;'>
			<script>
			googletag.cmd.push(function() { googletag.display('div-gpt-ad-1486844719982-5'); });
			</script>
			</div>
		<?php else: ?>
			<p class="ad-text">Leaderboard Ad <br> (<span></span>)</p>
		<?php endif; ?>
	</div>
	<div class="wrap m-ad-leaderboard">
		<p class="ad-text">Leaderboard Mobile Ad <br> (<span></span>)</p>
	</div>
	<?php
}

/** 
* Leaderboard Ad 
*
*/
function rva_square_1_ad($placement) {
	?>
	<center class="wrap ad-square "> 
		<?php echo do_shortcode('[dfp_ads id=590]'); ?>
	</center>
	<?php
}

/** 
* Leaderboard Ad 
*
*/
function rva_square_2_ad($placement) {
	?>
	<center class="wrap ad-square "> 
		<?php echo do_shortcode('[dfp_ads id=590]'); ?>
	</center>
	<?php
}


// /**
//  * Shortcode for ad by name
//  */
// function dfp_by_name_shortcode( $atts ) {
// 	$position = dfp_get_ad_position_by_name( $atts['name'] );

// 	return $position->get_position();
// }
// add_shortcode( 'dfp_by_name', 'dfp_by_name_shortcode' );

// //hook filter from dfp-ads
// add_filter('pre_dfp_ads_to_js', array ($positions, ) {
// 	echo 'hello world again';
// 	echo print_r($position, false);
// 	return $position;
// });

/** 
* Leaderboard Ad 
*
*/
function rva_skyscraper_ad($placement) {

	?>
	<div class="wrap ad-skyscraper "> 
		<?php echo do_shortcode('[dfp_ads name="Big_Boy_H0"]'); ?>
	</div>
	<?php
}

/**
 * Register our sidebars and widgetized areas.
 *
 */
function rva_ad_widgets_init() {

	genesis_register_sidebar( array(
        'id'            => 'widesky_ad',
		'name'          => 'Widesky Ad position',
        'description'   => '',
		'before_widget' => '<div class="widesky-ad ">',
		'after_widget'  => '</div>',
		// 'before_title'  => '<h2 class="rounded">',
		// 'after_title'   => '</h2>',
	) );
}
add_action( 'widgets_init', 'rva_ad_widgets_init' );

function rva_bigboy_block() {
	echo '<hr>';
	echo '<div class="ad-bigboy-block">';
		rva_square_1_ad('');
		rva_square_2_ad('');
		// rva_square_ad('');
		// rva_square_ad('');
	echo '</div>';
}

function rva_bigboy_ad(){
	?>
	<div class="ad-big-boy">
		<div class="ad-container">
			<p class="ad-text">Medium Ad BigBoy <br> (1:.896 Aspect Ratio) <br> (<span></span>)</p>
		</div>
	</div>
	<?php
}
