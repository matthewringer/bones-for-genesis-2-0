<?php 
/** 
 * Template Name: Contributors Template 
 */

if( !defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * Pre-page content menu standoff.
 *
 */
function rva_before_content() {
	?>
		<div class="rva-menu-offset"> </div>
		<div class="rva-gutter-box">
			<span class="page-title"> <?php echo the_title(); ?> </span>
		</div>
	<?php
} add_action('genesis_before_content_sidebar_wrap', 'rva_before_content');

/** 
* Set page Layout Single Sidebar
* 
*/
function content_sidebar_layout_single_posts( $opt ) {
	if ( is_single() ) {
		$opt = 'content-sidebar';
		return $opt;
	} 
} add_filter( 'genesis_pre_get_option_site_layout', 'content_sidebar_layout_single_posts' );

remove_action( 'genesis_loop', 'genesis_do_loop' );

require_once(ABSPATH . 'wp-admin/includes/taxonomy.php');
/**
 * 
 */
function rva_contributors_loop() {
	?>
	<div style="background-color:red;" >
	<h2>List of authors:</h2>
	<ul>
		
		<?php wp_list_authors(); 

		?>
	</ul>
	</div>
	<?php
} add_action( 'genesis_loop', 'rva_contributors_loop' );

/**
* Prints the right primary sidebar ads
* Applys filter : rva_single_ad_big_boy_h0
*/
function rva_contributor_sidebar(){
	?>
	<div style="background-color:blue;" >
		<?php echo the_content(); ?>
	</div>
	<?php
} add_action('genesis_sidebar', 'rva_contributor_sidebar', 5);





genesis();