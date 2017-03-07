<?php
// TODO: Move to Plugin
add_shortcode ('geturl', 'get_current_page_url');
function get_current_page_url() {
	$pageURL = 'http';
	if( isset($_SERVER["HTTPS"]) ) {
		if ($_SERVER["HTTPS"] == "on") {$pageURL .= "s";}
	}
	$pageURL .= "://";
	if ($_SERVER["SERVER_PORT"] != "80") {
		$pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
	} else {
		$pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
	}
	return $pageURL;
}

/*
 * Facebook Open Graph Meta
 *
 * @since 1.0.0
 */
function facebook_og_meta() {
    ?>
        <!-- Facebook Open Graph Tags -->
        <meta property="og:url"           content="<?php echo get_current_page_url(); ?>" />
        <meta property="og:type"          content="website" />
        <meta property="og:title"         content="<?php echo get_the_title(); ?>" />
        <meta property="og:description"   content="<?php echo get_the_excerpt(); ?>" />
        <meta property="og:image"         content="<?php echo get_the_post_thumbnail_url(); ?>" />
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
            data-href="<?php echo get_current_page_url(); ?>" 
            data-layout="button_count"
            data-size="small" 
            data-mobile-iframe="false"
            target="_blank">
        </div>
    <?php
}

/*
 * Sharing links for Posts
 *
 * @since 1.0.0
 */
function rva_entry_share_links($post) {
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
                            href: '<?php echo get_current_page_url(); ?>',
                        }, function(response){});
                    }
                </script>
            </li>
            <li class="btn-twitter"><a target="_blank" href="'.genesis_get_option('share_twitter_url').get_permalink($post).'"><i class="fa fa-twitter" ></i></a></li>
            <li class="btn-linkedin"><a target="_blank" href="'.genesis_get_option('share_linkedin_url').get_permalink($post).'"><i class="fa fa-linkedin" ></i></a></li>
            <li class="btn-email"><a target="_blank" href="'.genesis_get_option('share_email_url').get_permalink($post).'"><i class="fa fa-envelope" ></i></a></li>
            <li class="btn-print"><a target="_blank" href="'.genesis_get_option('share_print_url').get_permalink($post).'"><i class="fa fa-print" ></i></a></li>
            <li class="btn-message"><a target="_blank" href="'.genesis_get_option('share_message_url').get_permalink($post).'"><i class="fa fa-comment" ></i></a></li>
        </ul>
        
	<?php
}

/**
 * This function displays social sharing buttons based on the options selected by the user.
 *
 * @since 1.0.0
 */
function rva_social_sharing_buttons() {

	$perm  = get_permalink();
	$title = get_the_title();
    ?> <div class="rva-entry-like-btns" > <?php
	if ( genesis_get_option( 'rva_facebook_like_btn', RVA_SETTINGS_FIELD ) ) {
		?> 
        <div class="ctsettings-fb-like ctsettings-social-share"> <div id="fb-root"></div><script src="http://connect.facebook.net/en_US/all.js#xfbml=1"></script><fb:like href="'.$perm.'" send="false" layout="button_count" width="120" show_faces="false" action="like" font="lucida grande"></fb:like> </div>
        <?php
	}
	if ( genesis_get_option( 'rva_twitter_tweet_btn', RVA_SETTINGS_FIELD ) ) {
		?>
        <div class="ctsettings-tweet ctsettings-social-share"> <a href="http://twitter.com/share" class="twitter-share-button" data-count="horizontal" data-url="'.$perm.'" data-text="'.$title.'">Tweet</a><script type="text/javascript" src="http://platform.twitter.com/widgets.js"></script> </div>
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
}

/**
 *
 */
function rva_social_sidebar_shortcode($attrs, $content) {
	ob_start();
    ?> 
	<aside class="big-boy-h0-sidebar"> 
	<?php
		echo do_shortcode($content);
	?> 
	</aside> 
	<?php
    return do_shortcode(ob_get_clean());
}
add_shortcode( 'rva_social_sidebar', 'rva_social_sidebar_shortcode' );

/**
 *
 */
function rva_social_account_buttons() {
	$options =  get_option( RVA_SETTINGS_FIELD );
    ob_start();
	?>
	<div class="padding-bottom margin-bottom social-buttons " >
		<div>
			<h2>Follow RVA Mag</h2>
            <ul class="social-buttons">
                <li class="btn-facebook"><a target="_blank" href="<?php echo esc_attr( $options['rva_socialmedia_facebook_url'] ); ?> "><i class="fa fa-facebook" ></i><span>Facebook</span></a></li>
                <li class="btn-twitter"><a target="_blank" href="<?php echo esc_attr( $options['rva_socialmedia_twitter_url'] ); ?>"><i class="fa fa-twitter"></i><span>Twitter</span></a></li>
                <li class="btn-tumblr"><a target="_blank" href="<?php echo esc_attr( $options['rva_socialmedia_tumblr_url'] ); ?>"><i class="fa fa-tumblr"></i><span>Tumblr</span></a></li>
                <li class="btn-youtube"><a target="_blank" href="<?php echo esc_attr( $options['rva_socialmedia_youtube_url'] ); ?>"><i class="fa fa-youtube"></i><span>YouTube</span></a></li>
                <li class="btn-instagram"><a target="_blank" href="<?php echo esc_attr( $options['rva_socialmedia_instagram_url'] ); ?>"><i class="fa fa-instagram"></i><span>Instagram</span></a></li>
            </ul>
		</div>
	</div>
	<?php
    return ob_get_clean();
} add_shortcode('rva_social_account_buttons', 'rva_social_account_buttons');

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