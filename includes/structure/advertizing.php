<?php

/* 
* Register before header widget area
*/
// genesis_register_sidebar( array(
// 	'id'          => 'before-header',
// 	'name'        => __( 'Before Header Leaderboard Ad', 'rvamag' ),
// 	'description' => __( 'Leaderboard Ad position before Header', 'rvamag' ),
// ) );


add_action( 'wp_head', 'google_dfp_script' );

function google_dfp_script() {
	?>
	<script async='async' src='https://www.googletagservices.com/tag/js/gpt.js'></script>
	<script>
	var googletag = googletag || {};
	googletag.cmd = googletag.cmd || [];
	</script>

	<script>
	googletag.cmd.push(function() {
		googletag.defineSlot('/53299010/Big_Boy_All', [300, 280], 'div-gpt-ad-1486844719982-0').addService(googletag.pubads());
		googletag.defineSlot('/53299010/Big_Boy_H0', [300, 600], 'div-gpt-ad-1486844719982-1').addService(googletag.pubads());
		googletag.defineSlot('/53299010/Big_Boy_H1', [300, 280], 'div-gpt-ad-1486844719982-2').addService(googletag.pubads());
		googletag.defineSlot('/53299010/Big_Boy_H2', [300, 280], 'div-gpt-ad-1486844719982-3').addService(googletag.pubads());
		googletag.defineSlot('/53299010/Big_Boy_H3', [300, 280], 'div-gpt-ad-1486844719982-4').addService(googletag.pubads());
		googletag.defineSlot('/53299010/Leaderboard', [728, 90], 'div-gpt-ad-1486844719982-5').addService(googletag.pubads());
		googletag.defineSlot('/53299010/Partner', [140, 140], 'div-gpt-ad-1486844719982-6').addService(googletag.pubads());
		googletag.defineSlot('/53299010/Skyscraper', [120, 600], 'div-gpt-ad-1486844719982-7').addService(googletag.pubads());
		googletag.defineSlot('/53299010/Spud', [125, 125], 'div-gpt-ad-1486844719982-8').addService(googletag.pubads());
		googletag.pubads().enableSingleRequest();
		googletag.enableServices();
	});
	</script>

	<?php
}


function ad_units() {
	?>
	<!-- /53299010/Big_Boy_All -->
	<div id='div-gpt-ad-1486844719982-0' style='height:280px; width:300px;'>
	<script>
	googletag.cmd.push(function() { googletag.display('div-gpt-ad-1486844719982-0'); });
	</script>
	</div>

	<!-- /53299010/Big_Boy_H0 -->
	<div id='div-gpt-ad-1486844719982-1' style='height:600px; width:300px;'>
	<script>
	googletag.cmd.push(function() { googletag.display('div-gpt-ad-1486844719982-1'); });
	</script>
	</div>

	<!-- /53299010/Big_Boy_H1 -->
	<div id='div-gpt-ad-1486844719982-2' style='height:280px; width:300px;'>
	<script>
	googletag.cmd.push(function() { googletag.display('div-gpt-ad-1486844719982-2'); });
	</script>
	</div>

	<!-- /53299010/Big_Boy_H2 -->
	<div id='div-gpt-ad-1486844719982-3' style='height:280px; width:300px;'>
	<script>
	googletag.cmd.push(function() { googletag.display('div-gpt-ad-1486844719982-3'); });
	</script>
	</div>

	<!-- /53299010/Big_Boy_H3 -->
	<div id='div-gpt-ad-1486844719982-4' style='height:280px; width:300px;'>
	<script>
	googletag.cmd.push(function() { googletag.display('div-gpt-ad-1486844719982-4'); });
	</script>
	</div>

	<!-- /53299010/Leaderboard -->
	<div id='div-gpt-ad-1486844719982-5' style='height:90px; width:728px;'>
	<script>
	googletag.cmd.push(function() { googletag.display('div-gpt-ad-1486844719982-5'); });
	</script>
	</div>

	<!-- /53299010/Partner -->
	<div id='div-gpt-ad-1486844719982-6' style='height:140px; width:140px;'>
	<script>
	googletag.cmd.push(function() { googletag.display('div-gpt-ad-1486844719982-6'); });
	</script>
	</div>

	<!-- /53299010/Skyscraper -->
	<div id='div-gpt-ad-1486844719982-7' style='height:600px; width:120px;'>
	<script>
	googletag.cmd.push(function() { googletag.display('div-gpt-ad-1486844719982-7'); });
	</script>
	</div>

	<!-- /53299010/Spud -->
	<div id='div-gpt-ad-1486844719982-8' style='height:125px; width:125px;'>
	<script>
	googletag.cmd.push(function() { googletag.display('div-gpt-ad-1486844719982-8'); });
	</script>
	</div>
	<?php
}


add_action( 'genesis_before_header', 'rva_before_header' );
/** 
* Leaderboard ad
*
* @since 1.0.0
*/
function rva_before_header($placement) {
	?>
	<div class="before-header">
		<?php echo rva_leaderboard_ad('') ?>
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
		<!-- TODO: insert ad here  -->
		<?php if('' == $placement): ?>
			<div id='div-gpt-ad-1486844719982-2' style='height:280px; width:300px;'>
			<script>
			googletag.cmd.push(function() { googletag.display('div-gpt-ad-1486844719982-2'); });
			</script>
			</div>
		<?php else: ?>
			<p class="ad-text">Square Ad  <br> (<span></span>)</p>
		<?php endif; ?>
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
		<!-- TODO: insert ad here  -->
		<?php if('' == $placement): ?>
			<div id='div-gpt-ad-1486844719982-3' style='height:280px; width:300px;'>
			<script>
			googletag.cmd.push(function() { googletag.display('div-gpt-ad-1486844719982-3'); });
			</script>
			</div>
		<?php else: ?>
			<p class="ad-text">Square Ad  <br> (<span></span>)</p>
		<?php endif; ?>
	</center>
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
		<?php if('' == $placement): ?>
		
		<div id='div-gpt-ad-1486844719982-1' style='height:600px; width:300px;'>
		<script>
		googletag.cmd.push(function() { googletag.display('div-gpt-ad-1486844719982-1'); });
		</script>
		</div>
		
		<?php else: ?>
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
