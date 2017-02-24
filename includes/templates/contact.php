<?php

if( !defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

remove_action( 'wp_enqueue_scripts', 'rva_load_more_js' );
add_action('genesis_before_content', 'rvamag_before_content');
/**
 * Pre-page content menu standoff.
 *
 */
function rvamag_before_content() {
	?>
		<div id="top" class="rva-fp-before-content"></div>
	<?php
}


genesis();