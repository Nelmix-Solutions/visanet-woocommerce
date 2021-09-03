<?php

function wc_visanet_display_no_soap_error() {
    ?>
    <div class="notice notice-error is-dismissible">
        <p><?php _e( 'La librería <strong>SOAP</strong> no está configurada debidamente.', 'wc-visanet' ); ?></p>
    </div>
    <?php
}
add_action( 'admin_notices', 'wc_visanet_display_no_soap_error' );
