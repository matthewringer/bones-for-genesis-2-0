<?php

/**
 * Replace local url base with rvamag.com
 */
function rva_replace($url) {
    return str_replace(site_url(), 'http://rvamag.com', $url);
}

/**
 * Facebook Open Graph Meta
 *
 * @since 1.0.0
 */
function facebook_og_meta() {
    ?>
        <!-- Facebook Open Graph Tags -->
        <meta property="og:url"           content="<?php echo rva_replace(get_current_page_url()); ?>" />
        <meta property="og:type"          content="website" />
        <meta property="og:title"         content="<?php echo get_the_title(); ?>" />
        <meta property="og:description"   content="<?php echo get_the_excerpt(); ?>" />
        <meta property="og:image"         content="<?php echo rva_replace(get_the_post_thumbnail_url()); ?>" />
    <?php
}

/*
 * Facebook JS SDK
 *
 * @since 1.0.0
 */
function facebook_js_sdk() {
    $app_id = genesis_get_option('rva_facebook_appid' ,RVA_SETTINGS_FIELD);
    ?>
        <!-- Load Facebook SDK for JavaScript -->
        <div id="fb-root"></div>
        <script>(function(d, s, id) {
            var js, fjs = d.getElementsByTagName(s)[0];
            if (d.getElementById(id)) return;
            js = d.createElement(s); js.id = id;
            js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.8<?php echo (isset( $app_id )) ? '&appId='.$app_id : ''; ?>" ;  //TODO: hardcoded app id...
            fjs.parentNode.insertBefore(js, fjs);
        }(document, 'script', 'facebook-jssdk'));</script>
    <?php
}

/*
 * Facebook Share Button
 *
 * @since 1.0.0
 */
function facebook_share_btn() {
    ?>
        <!-- Your share button code -->
        <div class="fb-share-button" 
            data-href="<?php echo rva_replace(get_current_page_url()); ?>" 
            data-layout="button_count"
            data-size="small" 
            data-mobile-iframe="false"
            target="_blank"
            href="https://www.facebook.com/sharer/sharer.php?u=https%3A%2F%2Fdevelopers.facebook.com%2Fdocs%2Fplugins%2F&amp;src=sdkpreparse">
        </div>
    <?php
}

function facebook_comments( $atts ) {

    global $wpdb; //wp_fg_redirect;
    global $post;
    $is_array = is_array($atts);
    $num_posts = ($is_array && array_key_exists('num_posts', $atts)) ? $atts['num_posts'] : '5';
    $post_id = ($is_array && array_key_exists('post_id', $atts)) ? $atts['post_id'] : $post->ID;

    $permalink = 'http://rvamag.com' + $wpdb->get_var( "SELECT old_url FROM wp_fg_redirect  WHERE id = $post_id", 0, 0 );
    if( $permalink == "" ) $permalink = get_permalink($post->ID); 

    return vsprintf('<div id="comments" class="fb-comments" data-href="%s" data-colorscheme="dark" data-numposts="%s"></div>',[$url, $num_posts]);

} add_shortcode('fb_comments', 'facebook_comments');

/*
 * Sharing links for Posts
 *
 * @since 1.0.0
 */
function rva_entry_share_links() {
    global $post;
	$options = get_option( RVA_SETTINGS_FIELD );
    ?>
        <ul class="social-buttons social-links">
            <li id="fb-share-btn"class="btn-facebook"><i class="fa fa-facebook" ></i>
                <script>
                    document.getElementById('fb-share-btn').onclick = function() {
                        FB.ui({
                            method: 'share',
                            display: 'iframe',
                            mobile_iframe: 'true',
                            href: '<?php echo rva_replace(get_current_page_url()); ?>',
                        }, function(response){});
                    }
                </script>
            </li>
            <li class="btn-twitter"><a target="_blank" href="<?php  echo genesis_get_option('share_twitter_url'). rva_replace(get_permalink($post)); ?>"><i class="fa fa-twitter" ></i></a></li>
            <li class="btn-linkedin"><a target="_blank" href="<?php  echo genesis_get_option('share_linkedin_url'). rva_replace(get_permalink($post)); ?>"><i class="fa fa-linkedin" ></i></a></li>
            <li class="btn-email"><a target="_blank" href="<?php echo genesis_get_option('share_email_url'). rva_replace(get_permalink($post)); ?>"><i class="fa fa-envelope" ></i></a></li>
            <li class="btn-print"><a target="_blank" href="<?php echo genesis_get_option('share_print_url'). rva_replace(get_permalink($post)); ?>"><i class="fa fa-print" ></i></a></li>
            <li class="btn-message"><a href="#comments" alt="Comments"><i class="fa fa-comment" ></i></a></li>
        </ul>
        
	<?php
}

/**
 * Print the Facebook like button, Twitter tweet and Google +1
 * Output is conditional based on user input.
 *
 * @since 1.0.0
 */
function rva_social_sharing_buttons() {
	$perm  = rva_replace(get_permalink());
	$title = get_the_title();
    ?> <div class="rva-entry-like-btns" > <?php
	if ( genesis_get_option( 'rva_facebook_like_btn', RVA_SETTINGS_FIELD ) ) {
		?> 
        <div class="ctsettings-fb-like ctsettings-social-share"> 
            <div id="fb-root"></div>
            <script src="http://connect.facebook.net/en_US/all.js#xfbml=1"></script>
            <fb:like href="<?php echo $perm; ?>" send="false" layout="button_count" width="120" show_faces="false" action="like" font="lucida grande"></fb:like> 
        </div>
        <?php
	}
	if ( genesis_get_option( 'rva_twitter_tweet_btn', RVA_SETTINGS_FIELD ) ) {
        //TODO: opens a new window, need to make it modal...
		?>
        <div class="ctsettings-tweet ctsettings-social-share"> <a href="http://twitter.com/share" class="twitter-share-button" data-count="horizontal" data-url="<?php echo  $perm ?>" data-text="<?php echo $title ?>">Tweet</a><script type="text/javascript" src="http://platform.twitter.com/widgets.js"></script> </div>
        <?php
	}
	if ( genesis_get_option( 'rva_google_plus_btn', RVA_SETTINGS_FIELD ) ) {
		?> 
        <div class="ctsettings-google ctsettings-social-share"> <g:plusone size="medium" href="'.$perm.'"></g:plusone><script type="text/javascript">
			(function() {
   			var po = document.createElement("script"); po.type = "text/javascript"; po.async = true;
    		po.src = "https://apis.google.com/js/plusone.js";
    		var s = document.getElementsByTagName("script")[0]; s.parentNode.insertBefore(po, s);
  			})();
		</script></div>
        <?php
	}
    ?> </div> <?php 
} add_shortcode('rva_like_buttons', 'rva_social_sharing_buttons');

/**
 * Print the Sidebar social media account links (used on front page)
 */
function rva_social_account_buttons() {
	$options =  get_option( RVA_SETTINGS_FIELD );
    ob_start();
	?>
    <ul class="margin-top margin-bottom" >
        <li><a target="_blank" href="<?php echo esc_attr( $options['rva_socialmedia_facebook_url'] ); ?> "> 
            <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/social-media-buttons_FB.jpg" alt="RVA Facebook link" />
        </a></li>
        <li><a target="_blank" href="<?php echo esc_attr( $options['rva_socialmedia_twitter_url'] ); ?>">
            <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/social-media-buttons_twitter.jpg" alt="RVA Twitter link" />
        </a></li>
        <li><a target="_blank" href="<?php echo esc_attr( $options['rva_socialmedia_youtube_url'] ); ?>">
            <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/social-media-buttons_youtube.jpg" alt="RVA YouTube link" />
        </a></li>
        <li><a target="_blank" href="<?php echo esc_attr( $options['rva_socialmedia_instagram_url'] ); ?>">
            <img  src="<?php echo get_stylesheet_directory_uri(); ?>/images/social-media-buttons_instagram.jpg" alt="RVA Instagram link" />
        </a></li>

        <!-- <li class="btn-tumblr"><a target="_blank" href="<?php echo esc_attr( $options['rva_socialmedia_tumblr_url'] ); ?>"><i class="fa fa-tumblr"></i><span>Tumblr</span></a></li> -->
    </ul>

	<?php
    return ob_get_clean();
} add_shortcode('rva_social_account_buttons', 'rva_social_account_buttons');

/**
 * Print social account share buttons links, used in the single page entry header
 * TODO: facebook, linkedin, twitter and youtube buttons
 */
function rva_social_accounts() {
    $options =  get_option( RVA_SETTINGS_FIELD );
    ob_start();
    ?>
    <ul>
        <li class="btn-facebook"><a target="_blank" href="<?php echo esc_attr( $options['rva_socialmedia_facebook_url'] ); ?> "><i class="fa fa-facebook" ></i><span>Facebook</span></a></li>
        <li class="btn-twitter"><a target="_blank" href="<?php echo esc_attr( $options['rva_socialmedia_twitter_url'] ); ?>"><i class="fa fa-twitter"></i><span>Twitter</span></a></li>
        <li class="btn-tumblr"><a target="_blank" href="<?php echo esc_attr( $options['rva_socialmedia_tumblr_url'] ); ?>"><i class="fa fa-tumblr"></i><span>Tumblr</span></a></li>
        <li class="btn-youtube"><a target="_blank" href="<?php echo esc_attr( $options['rva_socialmedia_youtube_url'] ); ?>"><i class="fa fa-youtube"></i><span>YouTube</span></a></li>
        <li class="btn-instagram"><a target="_blank" href="<?php echo esc_attr( $options['rva_socialmedia_instagram_url'] ); ?>"><i class="fa fa-instagram"></i><span>Instagram</span></a></li>
    </ul>
    <?php
    return ob_get_clean();
}
add_shortcode('rva_social_accounts','rva_social_accounts');