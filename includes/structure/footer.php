<?php

if( !defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

add_filter( 'genesis_footer_output', 'bfg_footer_creds_text' );
/**
 * Custom footer 'creds' text.
 *
 * @since 2.0.0
 */
function bfg_footer_creds_text($content) {
	ob_start();
	?>
	<hr>
		[rva_ad name="Partner" class="wrap"] 
		<hr>
		[rva_ad name="Partner" class="wrap"] 
<hr>
		[rva_ad name="Partner" class="wrap"]
		<hr> 
		[rva_ad name="Partner" class="wrap"]
		<hr>
		
	<?php
	$contents = ob_get_clean();
	global $ad_positions;

	 return $contents . $ad_positions .'<p>' . ' ads served' . __( 'Copyright', CHILD_THEME_TEXT_DOMAIN ) . ' [footer_copyright] [footer_childtheme_link] </p>';

}

// add_action( 'wp_footer', 'bfg_disable_pointer_events_on_scroll', 99 );
/**
 * Disable pointer events when scrolling. Be careful using this with CSS :hover-enabled menus.
 *
 * See: https://gist.github.com/ossreleasefeed/7768761
 *
 * @since 2.0.20
 */
function bfg_disable_pointer_events_on_scroll() {

	ob_start();
	?><script>
		if( window.addEventListener ) {
			var root = document.documentElement;
			var timer;

			window.addEventListener('scroll', function() {
				clearTimeout(timer);

				if (!root.style.pointerEvents) {
					root.style.pointerEvents = 'none';
				}

				timer = setTimeout(function() {
					root.style.pointerEvents = '';
				}, 250);
			}, false);
		}
	</script>
	<?php
	$output = ob_get_clean();
	echo preg_replace( '/\s+/', ' ', $output ) . "\n";

}
