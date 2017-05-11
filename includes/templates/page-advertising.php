<?php
/*
 *	Template Name: Advertising Template
 */

if( !defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
include 'category.php';
/*
	Template Name: Page Contributors
*/

add_filter( 'genesis_pre_get_option_site_layout', '__genesis_return_full_width_content' );

function override_rvamag_before_content() {
	$sky_boat_img_url = get_stylesheet_directory_uri().'/images/advertising/sky_boat.png';
	?>
	<div class="rva-before-entry-content"></div>
	<div class="rva-advertizing-box rva-advertizing-hero-box" style = "background-image: url(' <?php echo $sky_boat_img_url; ?> '); " >
		<div class="title-block" >
			<h2 class="article-title">MEET <br>THE NEW <br> <a href="<?php echo get_site_url(); ?>">RVAMAG.COM</a></h2>
			<br><br>
			<p>Introducing the next</p>
			<p>generation of local media</p>
			<p>with targeted and simplified</p>
			<p>advertising options.</p>
		</div>
	</div>
	<?php
} add_action('genesis_before_content_sidebar_wrap', 'override_rvamag_before_content'); //TODO: this can be done better with filters....
remove_action('genesis_before_content_sidebar_wrap', 'rvamag_before_content');


/**
 *
 */


function rvamag_custom_archive_loop() {
	$dude_img_url = get_stylesheet_directory_uri().'/images/advertising/dude.png';
	$field_img_url = get_stylesheet_directory_uri().'/images/advertising/field.png';
	?>
	<section class="rva-advertizing-box" >
		<div class="title-block" >
			<h2 class="article-title">
			WANT local MUSIC? <br>
			How About food? <br>
			Maybe art? <br>
			how about all of it? <br>
			</h2>
			<br><br>
			<p>Your advertising can be </p>
			<p>aligned with what your</p>
			<p>business is all about and more.</p>
		</div>
	</section>
	<section class="rva-advertizing-box" style = "background-image: url(' <?php echo $field_img_url; ?> '); " >
		<div class="title-block" >
			<h2 class="article-title">
			Advertising<br>
			not your thing?<br>
			be a sponsor<br>
			of the local<br>
			scene instead.<br>
			</h2>
			<br><br>
			<p>Be a sponsor of our content and</p>
			<p>help us bring the city’s stories to life.  </p>
		</div>
	</section>
	<section class="rva-advertizing-box" >
		<div class="title-block" >
			<h2 class="article-title">
			For as low<br>
			as $300 monthly<br>
			we can get<br>
			your business<br>
			out there.<br>
			</h2>
			<br><br>
			<p>We build our marketing packages</p>
			<p>around your budget. Small business to </p>
			<p>big time agency --- together we will </p>
			<p>get the most for your spend.</p>
		</div>
	</section>
	<section class="rva-center-img rva-advertizing-box" style = "background-image: url(' <?php echo $dude_img_url; ?> '); " >
		<div class="title-block" >
			<h2 class="article-title">
			marketing<br>
			made<br>
			simple.<br>
			</h2>
			<br><br>
			<p>The new <a href="<?php echo get_site_url(); ?>">RVAMAG.com</a> has</p>
			<p>3 easy to figure out advertising</p>
			<p>sizes and 1 sponsorship per section.</p>
		</div>
	</section>
	<section class="rva-advertizing-box" >
		<div class="title-block" >
			<h2 class="article-title">
			Get in touch.<br>
			WE ARE HERE<br>
			TO HELP.<br>
			</h2>
			<br><br>
			<p>Our crew is ready.</p>
			<p><a href="mailto:advertising@rvamag.com">advertising@rvamag.com</a></p>
		</div>
	</section>
	<?

} add_action( 'genesis_loop', 'rvamag_custom_archive_loop'); remove_action( 'genesis_loop', 'rvamag_categorypage_loop' );


remove_action ('genesis_after_content_sidebar_wrap', 'rva_fp_aftercontent');

genesis();