<?php

if( !defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

remove_action( 'genesis_loop_else', 'genesis_do_noposts' );
remove_action( 'genesis_loop', 'genesis_do_loop' );

add_filter( 'genesis_attr_site-header', 'rva_unset_header_class' );
/**
 * Hook header class
 */
function rva_unset_header_class($attrs) {

	$attrs['class'] = str_replace('site-header-offset','', $attrs['class']);
	
	return $attrs;
}

add_filter( 'genesis_attr_site-inner', 'rva_set_header_class' );
add_filter( 'genesis_attr_site-footer', 'rva_set_header_class' );
/**
 * Hook header class
 */
function rva_set_header_class($attrs) {

	//$attrs['class'] .= ' site-header-offset';
	
	return $attrs;
}


add_action( 'genesis_loop', 'bfg_404' );
/**
 * Better default 404 text.
 *
 * See: https://yoast.com/404-error-pages-wordpress/
 *
 * @since 2.3.2
 */
function bfg_404() {

	global $wp_query;
	?>
	<article class="entry">
		<h1 class="entry-title"> <?php printf( '%s ', apply_filters( 'genesis_404_entry_title', __( 'What the?!', CHILD_THEME_TEXT_DOMAIN ) ) ); ?> </h1>
		<div class="entry-content">
			<ol>
				<li>
					<?php echo __( '<strong>Search</strong> for it:', CHILD_THEME_TEXT_DOMAIN ); ?>
					<?php echo get_search_form(); ?>
				</li>
				<li>
					<?php echo __( '<strong>If you typed in a URL...</strong> make sure the spelling, cApitALiZaTiOn, and punctuation are correct. Then, try reloading the page.', CHILD_THEME_TEXT_DOMAIN ); ?>
				</li>
				<li>
					<?php
					printf(
						__( '<strong>Start over again</strong> at the <a href="%s">homepage</a> (and please contact us to say what went wrong, so we can fix it).', CHILD_THEME_TEXT_DOMAIN ),
						get_bloginfo('url')
					)
					?>
				</li>
			</ol>
			<?php

		echo '</div>';

	echo '</article>';

}

genesis();
