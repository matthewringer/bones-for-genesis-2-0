<?php

//TODO: Move to plugin

if( !defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

//add_action( 'genesis_before_header', 'rva_before_header' );
/** 
* Prints Ad Unit : Leaderboard
*
* @since 1.0.0
*/
function rva_ad_leaderboard_shortcode($atts) {
	ob_start();
	if(array_key_exists ( 'name', $atts)) {
		echo do_shortcode('[dfp_ads name="'.$atts['name'].'"]');
	}
	return ob_get_clean();
}
add_shortcode( 'rva_ad_leaderboard', 'rva_ad_leaderboard_shortcode' );

/**
 * Display Shortcode Halfpage "Big Boy H0"
 *
 * @since  0.0.1
 *
 * @param $atts array
 *
 * @return mixed Returns HTML data for the position
 */
function rva_ad_big_boy_shortcode($atts) {
	ob_start();
	?>
	<div class="wrap ad-big-boy">
		<?php
		if(array_key_exists ( 'name', $atts)) { 
			echo do_shortcode('[dfp_ads name="'.$atts['name'].'"]'); 
		} ?>
	</div>
	<?php
	return ob_get_clean();
}
add_shortcode( 'rva_ad_big_boy', 'rva_ad_big_boy_shortcode' );


/**
 * Display Shortcode Halfpage "Big Boy H0"
 *
 * @since  0.0.1
 *
 * @param $atts array
 *
 * @return mixed Returns HTML data for the position
 */
function rva_ad_shortcode($atts) {
	ob_start();
	?>
	<div class="<?php echo $atts['class']; ?> ">
		<?php
		if(array_key_exists ( 'name', $atts)) { 
			echo do_shortcode('[dfp_ads name="'.$atts['name'].'"]'); 
		} ?>
	</div>
	<?php
	return ob_get_clean();
}
add_shortcode( 'rva_ad', 'rva_ad_shortcode' );



//[dfp_ads name="Skyscraper"]

/** 
* Square Ad 
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
* Square Ad 
*
*/
function rva_square_2_ad($placement) {
	?>
	<center class="wrap ad-square "> 
		<?php echo do_shortcode('[dfp_ads id=590]'); ?>
	</center>
	<?php
}

function rva_bigboy_block() {
	echo '<hr>';
	echo '<div class="ad-bigboy-block">';
		rva_square_1_ad('');
		rva_square_2_ad('');
		// rva_square_ad('');
		// rva_square_ad('');
	echo '</div>';
}
