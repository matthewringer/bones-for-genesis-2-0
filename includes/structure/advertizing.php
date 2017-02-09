<?php

/* 
* Register before header widget area
*/
// genesis_register_sidebar( array(
// 	'id'          => 'before-header',
// 	'name'        => __( 'Before Header Leaderboard Ad', 'rvamag' ),
// 	'description' => __( 'Leaderboard Ad position before Header', 'rvamag' ),
// ) );

add_action( 'genesis_before_header', 'rva_before_header' );
/** 
* Leaderboard ad
*
* @since 1.0.0
*/
function rva_before_header($placement) {
	?>
	<div class="before-header">
		<?php echo rva_leaderboard_ad('todo:') ?>
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
		<?php if (!$placement): ?>
			<p class="ad-text">Leaderboard Ad <br> (<span></span>)</p>
		<?php endif; ?>
	</div>
	<?php
}

/** 
* Leaderboard Ad 
*
*/
function rva_square_ad($placement) {
	?>
	<div class="wrap ad-square "> 
		<!-- TODO: insert ad here  -->
		<?php if(!$placement): ?>
			<p class="ad-text">Square Ad  <br> (<span></span>)</p>
		<?php endif; ?>
	</div>
	<?php
}

/** 
* Leaderboard Ad 
*
*/
function rva_skyscraper_ad($placement) {
	?>
	<div class="wrap ad-skyscraper "> 
		<!-- TODO: insert ad here  -->
		<?php if(!$placement): ?>
			<p class="ad-text">Skyscraper Ad  <br> (<span></span>)</p>
		<?php endif; ?>
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
		rva_bigboy_ad();
		rva_bigboy_ad();
		rva_bigboy_ad();
		rva_bigboy_ad();
	echo '</div>';
}

function rva_bigboy_ad(){
	echo '<div class="ad-big-boy"><div class="ad-container"><p class="ad-text">Medium Ad BigBoy <br> (1:.896 Aspect Ratio) <br> (<span></span>)</p></div></div>';
}

/*	Big Boy All 300x250
*	Big Boy H0 	300x250
*	Big Boy H1 	300x250
*	Big Boy H2 	300x250
*	Big Boy H3 	300x250
*	Leaderboard 728x90
*	Partner 	140x140
*	Skyscraper 	120x600
*	Spud 		125x125
*/
