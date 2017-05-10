
<?php

if( !defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

include 'single.php';

/**
* Display Featured Image at top of the post 
*
*/
function override_featured_post_image() {

	if ( !is_singular( array( 'post', 'page', 'magazine' ) ))  return;
	?> 
		<div id="top" class="margin-bottom">
			<img style="width: 100%;" src="<?php the_post_thumbnail_url(); ?>" alt="">
			<?php echo do_shortcode('[rva_photo_credit]'); ?>
		</div> 
	<?php

} add_action( 'genesis_before_loop', 'override_featured_post_image' );
remove_action( 'genesis_before_content_sidebar_wrap', 'featured_post_image', 13 );

//add_filter('genesis_author_box', '__return_empty_string');

genesis();