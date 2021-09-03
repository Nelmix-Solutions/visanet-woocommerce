<?php

function wc_visanet_display_version_error() {
    ?>
    <div class="notice notice-error is-dismissible">
        <p><?php _e( 'Tu versión de PHP no es compatible con este plugin.', 'wc-visanet' ); ?></p>
    </div>
    <?php
}
add_action( 'admin_notices', 'wc_visanet_display_version_error' );
