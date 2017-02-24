<?php

if( !defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

add_filter( 'genesis_footer_output', 'bfg_footer_creds_text' );
/**
 * Custom footer 'creds' text.
 *
 * @since 2.0.0
 * TODO: fix hardcoding of menu names.
 */
function bfg_footer_creds_text($content) {
	ob_start();
	?>
	<div class="rva-footer-partners">
		[rva_ad name="Partner" class="wrap"]
		[rva_ad name="Partner" class="wrap"]
		[rva_ad name="Partner" class="wrap"]
		[rva_ad name="Partner" class="wrap"]
		[rva_ad name="Partner" class="wrap"]
	</div >

	<div class="rva-footer-links">
	<!-- links -->
		<a class="rva-footer-logo" href=" <?php echo get_site_url() ?>"><img src="<?php echo get_stylesheet_directory_uri() .'/images/logo.svg';?>" alt="RVA Mag Logo" /></a>
		<div> 
			<ul>
			<?php  foreach( wp_get_nav_menu_items('RVA Primary Menu') as $key => $value ): ?>
				<li><?php echo $value->title; ?></li>
			<?php endforeach; ?>
			</ul>
		</div>
		<div> 
			<ul>
			<?php  foreach( wp_get_nav_menu_items('RVA Secondary Menu') as $key => $value ): ?>
				<li><?php echo $value->title; ?></li>
			<?php endforeach; ?>
			</ul>
		</div>
		<div> 
			[rva_social_accounts]
		</div>
		<div>
			[rva_mail_form]
		</div>
	</div>

	<div >
		<p> <?php echo __( 'Copyright', CHILD_THEME_TEXT_DOMAIN ) . ' [footer_copyright] [footer_childtheme_link]'; ?> </p>
	</div>
	
	<?php
	$contents = ob_get_clean();
	return $contents; 

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
