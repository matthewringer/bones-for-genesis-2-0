<?php

if( !defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

// add_filter( 'genesis_search_text', 'bfg_search_text' );
/**
 * Customize the search form input box text.
 *
 * See: http://www.briangardner.com/code/customize-search-form/
 *
 * @since 2.0.0
 */
function bfg_search_text() {

	return esc_attr( __( 'Search Text Goes Here...', CHILD_THEME_TEXT_DOMAIN ) );

}

// add_filter( 'genesis_search_button_text', 'bfg_search_button_text' );
/**
 * Customize the search form input button text.
 *
 * See: http://www.briangardner.com/code/customize-search-form/
 *
 * @since 2.0.0
 */
function bfg_search_button_text( $text ) {

	return esc_attr( __( 'Click Here...', CHILD_THEME_TEXT_DOMAIN ) );

}

// add_action( 'template_redirect', 'bfg_redirect_single_search_result' );
/**
 * Redirect to the result itself, if only one search result is returned.
 *
 * See: http://www.developerdrive.com/2013/07/5-quick-and-easy-tricks-to-improve-your-wordpress-theme/
 *
 * @since 2.0.5
 */
function bfg_redirect_single_search_result() {

	if( is_search() ) {
		global $wp_query;

		if( $wp_query->post_count === 1) {
			wp_safe_redirect( get_permalink( $wp_query->posts['0']->ID ) );
		}
	}

}

// add_action( 'pre_get_posts', 'bfg_only_search_posts' );
/**
 * Limit searching to just posts, excluding pages and CPTs.
 *
 * See: http://www.mhsiung.com/2009/11/limit-wordpress-search-scope-to-blog-posts/
 *
 * @since 2.0.18
 */
function bfg_only_search_posts( $query ) {

	if( is_admin() )
		return;

	if( $query->is_search ) {
		$query->set( 'post_type', 'post' );
	}

}


function rva_searchform() {
	ob_start();
    ?> 
	<form class="search-form" role="search" method="get" id="searchform" action="<?php echo home_url( '/' ); ?>" >
		<div><label class="screen-reader-text" for="s"><?php echo __('Search for:'); ?></label>
			<input type="text" value="<?php echo get_search_query(); ?>" name="s" id="s" />
			<button type="submit" id="searchsubmit" value="<?php echo esc_attr__('Search'); ?>" >
				<i class="fa fa-search" aria-hidden="true"></i>
			</button>
		</div>
    </form>
	<?php
	$form = ob_get_clean();
    return $form;
}
//add_shortcode('wpbsearch', 'wpbsearchform');

