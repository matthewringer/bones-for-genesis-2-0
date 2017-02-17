<?php

function rva_subscribtion_form() {

    $email_image = esc_attr( genesis_get_option('rva_subscribe_email_image', RVA_SETTINGS_FIELD ) );

    $magazine_image = esc_attr( genesis_get_option('rva_subscribe_magazine_image', RVA_SETTINGS_FIELD ) );
?>
    <div class="cd-gutter-box cd-subscribe-block" >
        <div class="section-title">
            <h2>SUBSCRIBE</h2>
        </div>
        <div class="cd-subscribe-box">
            <div class="ar-scale-box">
            <?php printf(
                '<img class="ar-content" src="%s">',
                isset( $magazine_image ) ? wp_get_attachment_url( $magazine_image ) : ''
            ); ?>
            </div>
            <form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_blank">
                <h2>Subscribe to the print edition of RVA Magazine</h2>
                <fieldset>
					<input type="hidden" name="cmd" value="_s-xclick">
					<input type="hidden" name="hosted_button_id" value="QGUWHR8MA4KWU">
                    <button class="btn btn-alert" name="submit" alt="Subscribe to RVA Magazine" >BUY NOW</button>
                </fieldset>
            </form>
        </div>
        <div class="cd-subscribe-box">
            <form>
                <h2>RVA Weekly Email Newsletter to your inbox.</h2>
                <fieldset>
                    <input type="text">
                    <button class="btn btn-alert">SUBSCRIBE</button>
                </fieldset>
            </form>
            <div class="ar-scale-box">
            <?php printf(
                '<img class="ar-content" src="%s">',
                isset( $email_image ) ? wp_get_attachment_url( $email_image ) : ''
            ); ?>
            </div>
        </div>
    </div>
<?php
}