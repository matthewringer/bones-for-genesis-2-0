<?php

function rva_subscribtion_form() {

    $options = get_option('rva_admin_options');
?>
    <div class="cd-gutter-box cd-subscribe-block" >
        <div class="section-title">
            <h2>SUBSCRIBE</h2>
        </div>
        <div class="cd-subscribe-box">
            <div class="ar-scale-box">
            <?php printf(
                '<img class="ar-content" src="%s">',
                isset( $options['subscribe_magazine_image'] ) ? wp_get_attachment_url( esc_attr( $options['subscribe_magazine_image']) ) : ''
            ); ?>
            </div>
            <form>
                <h2>Subscribe to the print edition of RVA Magazine</h2>
                <fieldset>
                    <button class="btn btn-alert">BUY NOW</button>
                </fieldset>
            </form>
        </div>
        <div class="cd-subscribe-box">
            <form>
                <h2>RVA Weekly Email Newsletter to your inbox.</h2>
                <fieldset>
                    <input type="text">
                    <button class="btn btn-alert">SUBMIT</button>
                </fieldset>
            </form>
            <div class="ar-scale-box">
            <?php printf(
                '<img class="ar-content" src="%s">',
                isset( $options['subscribe_email_image'] ) ? wp_get_attachment_url( esc_attr( $options['subscribe_email_image']) ) : ''
            ); ?>
            </div>
        </div>
    </div>
<?php
}