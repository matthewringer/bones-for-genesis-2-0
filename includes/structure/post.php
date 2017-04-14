<?php

if( !defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

add_filter( 'gallery_style', 'bfg_gallery_style' );
/**
 * Remove the injected styles for the [gallery] shortcode.
 *
 * @since 1.x
 */
function bfg_gallery_style( $css ) {

	return preg_replace( "!<style type='text/css'>(.*?)</style>!s", '', $css );

}

/*
 * Allow pages to have excerpts.
 *
 * @since 2.2.5
 */
// add_post_type_support( 'page', 'excerpt' );

//add_filter( 'the_content_more_link', 'bfg_more_tag_excerpt_link' );
/**
 * Customize the excerpt text, when using the <!--more--> tag.
 *
 * See: http://my.studiopress.com/snippets/post-excerpts/
 *
 * @since 2.0.16
 */
function bfg_more_tag_excerpt_link() {

	return ' <a class="more-link" href="' . get_permalink() . '">' . __( 'READ MORE &rarr;', CHILD_THEME_TEXT_DOMAIN ) . '</a>';

}

add_filter( 'excerpt_more', 'bfg_truncated_excerpt_link' );
//add_filter( 'get_the_content_more_link', 'bfg_truncated_excerpt_link' );
/**
 * Customize the excerpt text, when using automatic truncation.
 *
 * See: http://my.studiopress.com/snippets/post-excerpts/
 *
 * @since 2.0.16
 */
function bfg_truncated_excerpt_link() {
	return '... <a class="rva-read-more" href="'.post_permalink().'" alt="'.the_title().'">READ MORE</a>';

}

//remove_action( 'genesis_entry_header', 'genesis_post_info', 12 );
add_filter( 'genesis_post_info', 'bfg_post_info' );
/**
 * Customize the post info text.
 *
 * See:http://www.briangardner.com/code/customize-post-info/
 *
 * @since 2.0.0
 */
function bfg_post_info() {

	return ' [post_author_posts_link] ' . __( '|', CHILD_THEME_TEXT_DOMAIN ) . ' [post_date] ';
	// Friendly note: use [post_author] to return the author's name, without an archive link
	// [post_comments] [post_edit]

}

//genesis_entry_header
remove_action( 'genesis_entry_footer', 'genesis_post_meta' );
add_action( 'genesis_entry_header', 'genesis_post_meta', 13);
add_filter( 'genesis_post_meta', 'bfg_post_meta' );
/**
 * Customize the post meta text.
 *
 * return '[post_categories before="' . __( 'Filed Under: ', CHILD_THEME_TEXT_DOMAIN ) . '"] [post_tags before="' . __( 'Tagged: ', CHILD_THEME_TEXT_DOMAIN ) . '"]';
 *
 * @since 2.0.0
 */
function bfg_post_meta() {

	return 'Topics: [post_tags before="' . __( ' ', CHILD_THEME_TEXT_DOMAIN ) . '"]';

}

add_filter( 'genesis_prev_link_text', 'bfg_prev_link_text' );
/**
 * Customize the post navigation prev text
 * (Only applies to the 'Previous/Next' Post Navigation Technique, set in Genesis > Theme Options).
 *
 * @since 2.0.0
 */
function bfg_prev_link_text( $text ) {

	return html_entity_decode('&#10216;') . ' ';

}

add_filter( 'genesis_next_link_text', 'bfg_next_link_text' );
/**
 * Customize the post navigation next text
 * (Only applies to the 'Previous/Next' Post Navigation Technique, set in Genesis > Theme Options).
 *
 * @since 2.0.0
 */
function bfg_next_link_text( $text ) {

	return ' ' . html_entity_decode('&#10217;');

}

/*
 * Remove the post title
 *
 * @since 2.0.9
 */
// remove_action( 'genesis_entry_header', 'genesis_do_post_title' );

/*
 * Remove the post edit links (maybe you just want to use the admin bar)
 *
 * @since 2.0.9
 */
add_filter( 'edit_post_link', '__return_false' );

/*
 * Show the  author box for posts and user archives. 
 *
 * @since 2.0.18
 */
add_filter( 'get_the_author_genesis_author_box_single', '__return_true' );
add_filter( 'get_the_author_genesis_author_box_archive', '__return_true' );

//remove_action( 'genesis_after_entry', 'genesis_do_author_box_single', 8 );
//remove_action( 'genesis_after_post', 'genesis_do_author_box_single' );

/**
* Author box output filter.
*
* Allows you to filter the full output of the author box.
*
* @since unknown
*
* @param string $output  Assembled output.
* @param string $context Context.
* @param string $pattern (s)printf pattern.
* @param string $context Gravatar.
* @param string $context Title.
* @param string $context Description.
*/
function rva_author_box_filter($output='', $context='', $pattern='', $gravatar='', $title='', $description='' ) {

	$author_id = get_the_author_meta('ID');
	$output =  rva_author_box( ['author_id'=> $author_id ] );

	//[ 'output'=> $output, 'context' => $context, 'pattern' => $pattern, 'gravatar' => $gravatar, 'title' => $title, 'description' => $description ]

	return $output;

} add_filter('genesis_author_box', 'rva_author_box_filter');


/**
 * Shortcode for the author box. 
 */
function rva_author_box($atts, $content=NULL, $tag='rva_author_box') {

	extract( shortcode_atts( [ 
		'author_id' => '',
		 ], $atts ) );

	global  $authordata;
	$authordata    =  get_userdata( $author_id );

	$avitar = get_avatar($author_id);
	$title = get_the_author_link();
	$gravatar_size = apply_filters( 'genesis_author_box_gravatar_size', 96, $context );
	$gravatar      = get_avatar( $author_id, $gravatar_size );
	$description   = wpautop( get_the_author_meta( 'description') );
	$email = get_the_author_meta( 'email' );
	
	$social_media_ul = rva_social_accounts([
		'facebook' => get_the_author_meta( 'facebook' ),
		'twitter' => get_the_author_meta( 'twitter' ),
		'linkedin' => get_the_author_meta( 'linkedin' ),
		'snapchat' => get_the_author_meta( 'snapchat' ),
		'instagram' => get_the_author_meta( 'instagram' )
	]);
	
	$popular_posts = new WP_Query(rva_popular_posts_query( 5, '1 year ago', [ $author_id ] ));
	
	ob_start();
	?>
	<section class="author-box" itemprop="author" itemscope="" itemtype="http://schema.org/Person">
		<div class="avatar-block" >
			<?php echo $gravatar; //class="avatar avatar-96 photo" height="96" width="96" ?>
		</div>
		<div class="author-bio-block" >
			<h4 class="author-box-title">
					<span itemprop="name" class=""> <?php echo $title; ?></span>
			</h4>
			<?php echo $social_media_ul; ?>
			<div class="author-box-content" itemprop="description">
				<?php echo $description; ?>
			</div>
			<div class="author-box-content" itemprop="description">
				<h4>Top posts by <?php echo $title; ?></h4>
				<table class="author-top-posts"><?php $i = 0; while ( $popular_posts->have_posts() ) : $popular_posts->the_post(); $i++; ?>
					<tr>
						<td><?php echo $i; ?></td><td> <a href="<?php echo get_the_permalink();?>" > <?php echo the_title(); ?> </a> </td>
					</tr>
					<?php endwhile; ?>
				</table>
			</div>
		</div>
	</section>

	<?php $content = ob_get_clean(); ?>
	<?php
	return $content;

} add_shortcode( 'rva_author_box','rva_author_box' );


/*
 * Adjust the default WP password protected form to support keeping the input and submit on the same line
 *
 * @since 2.2.18
 */
add_filter( 'the_password_form', 'bfg_password_form' );
function bfg_password_form( $post = 0 ) {

	$post       = get_post( $post );
	$label      = 'pwbox-' . ( empty($post->ID) ? mt_rand() : $post->ID );
	$output     = '<form action="' . esc_url( site_url( 'wp-login.php?action=postpass', 'login_post' ) ) . '" class="post-password-form" method="post">';
		$autofocus = is_singular() ? 'autofocus' : '';
		$output .= '<input name="post_password" id="' . $label . '" type="password" size="20" placeholder="' . __( 'Password', CHILD_THEME_TEXT_DOMAIN ) . '" ' . $autofocus . '>';
		$output .= '<input type="submit" name="' . __( 'Submit', CHILD_THEME_TEXT_DOMAIN ) . '" value="' . esc_attr__( 'Submit' ) . '">';
	$output .= '</form>';

	return $output;

}

