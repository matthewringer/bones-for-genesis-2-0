<?php

/**
 *
 */
function rva_mail_form($atts, $content) {
    ob_start();
    ?>
    <form id="mailing_list" class="rva-newsletter-form" action="http://rva.createsend.com/t/r/s/wdhtd/" method="post" target="createsend">
        <?php echo do_shortcode($content); ?>
        <fieldset >
            <input type="text" name="cm-wdhtd-wdhtd" id="wdhtd-wdhtd" size="25">
            <input type="button" class="btn btn-black" href="javascript:;" value="SUBSCRIBE" onclick="
            (function(){
                $('.rva-modal-close').click( ()=>{ $('#createsend-modal').toggle(false); } );
                $('#createsend-modal').toggle(true);
                $('#mailing_list').submit();
                }())">
        </fieldset>
    </form>
    <div id="createsend-modal" class="rva-modal">
        <div class="rva-modal-content">
            <span class="rva-modal-close">&times;</span>
            <iframe name="createsend" class="hide"></iframe>
        </div>
    </div>
    <?php
    return ob_get_clean();

} add_shortcode('rva_mail_form','rva_mail_form');

/**
 *
 */
function rva_magazine_form($atts, $content) {
    ob_start();
    ?>
    <form class="rva-newsletter-form" action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_blank">
        <?php echo do_shortcode($content); ?>
        <fieldset>
            <input type="hidden" name="cmd" value="_s-xclick">
            <input type="hidden" name="hosted_button_id" value="QGUWHR8MA4KWU">
            <input type="submit" class="btn btn-alert" name="submit" value="BUY NOW" alt="Subscribe to RVA Magazine">
        </fieldset>
    </form>
    <?php
    return ob_get_clean();

} add_shortcode('rva_magazine_form','rva_magazine_form');


/**
 * depricated form 
 */
function rva_subscribtion_form() {
    $email_image = esc_attr( genesis_get_option('rva_subscribe_email_image', RVA_SETTINGS_FIELD ) );
    $magazine_image = esc_attr( genesis_get_option('rva_subscribe_magazine_image', RVA_SETTINGS_FIELD ) );
    ob_start();
    ?>
    <div class="rva-gutter-box rva-subscribe-block" >
        <div class="section-title">
            <h2>SUBSCRIBE</h2>
        </div>
        <div class="rva-subscribe-box">
            <div class="ar-scale-box">
            <?php printf(
                '<img class="ar-content" src="%s">',
                isset( $magazine_image ) ? wp_get_attachment_url( $magazine_image ) : ''
            ); ?>
            </div>
            [rva_magazine_form]
                <h2>Subscribe to the print edition of RVA Magazine</h2>
            [/rva_magazine_form]
        </div>
        <div class="rva-subscribe-box">
                [rva_mail_form]
                    <h2>RVA Weekly Email Newsletter to your inbox.</h2>
                [/rva_mail_form]
            <div class="ar-scale-box">
            <?php printf( '<img class="ar-content" src="%s">', isset( $email_image ) ? wp_get_attachment_url( $email_image ) : ''); ?>
            </div>
        </div>
    </div>
    <?php
return do_shortcode( ob_get_clean() );

} add_shortcode("rva_subscribtion_form","rva_subscribtion_form");
