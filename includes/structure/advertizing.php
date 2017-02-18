<?php

//TODO: Move to plugin

if( !defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

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
	$name = $atts['name'];

		error_log('this happened');
	add_filter('insert_dfp_repeat_ad_position', function ($r) {
		array_push( $r, $name );
		return $r;
	});

	return ob_get_clean();
}
add_shortcode( 'rva_ad', 'rva_ad_shortcode' );


// add_filter('insert_dfp_repeat_ad_position', function ($r) {
// 		$new_item = "something";
// 		array_push($r, $new_item);
// 		echo("dumb shit");
// 		return $r;
// 	});

// return function() use ($who) {
//                   echo "Hello $who";
//               };


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
