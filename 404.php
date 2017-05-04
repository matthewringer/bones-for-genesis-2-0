<?php

if( !defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

remove_action( 'genesis_loop_else', 'genesis_do_noposts' );
remove_action( 'genesis_loop', 'genesis_do_loop' );

/**
 * Hook header class to remove the header offset.
 */
function rva_unset_header_class($attrs) {

	$attrs['class'] = str_replace('site-header-offset','', $attrs['class']);
	
	return $attrs;
} add_filter( 'genesis_attr_site-header', 'rva_unset_header_class' );

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
	<article class="page rva-gutter-box">
		<h1 class="entry-title"> <?php printf( '%s ', apply_filters( 'genesis_404_entry_title', __( 'What the?!', CHILD_THEME_TEXT_DOMAIN ) ) ); ?> </h1>
		<div class="entry-content">
			<ul>
				<li>
					<?php echo __( '<strong>Search</strong> for it:', CHILD_THEME_TEXT_DOMAIN ); ?>
					<?php echo get_search_form(); ?>
				</li>
				<li>
					<?php
					printf(
						__( '<strong>Start over again</strong> at the <a href="%s">homepage</a> (and please contact us to say what went wrong, so we can fix it).', CHILD_THEME_TEXT_DOMAIN ),
						get_bloginfo('url')
					)
					?>
				</li>
			</ul>
			<?php
		echo '</div>';
	echo '</article>';
} add_action( 'genesis_loop', 'bfg_404' );

genesis();
