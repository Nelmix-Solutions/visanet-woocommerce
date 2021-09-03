<?php
/*
Plugin Name: Visanet Woocommerce
Version: 2.4
Author: VisaNet Dominicana
Description: Agrega el método de pago de Visanet a Woocommerce
*/

require_once __DIR__ . '/hooks/setup.php';
define('WC_VISANET_DIR', plugin_basename(__DIR__));
define('WC_VISANET_PLUGIN', plugin_basename(__FILE__));

function wc_visanet_init()
{
  if ( version_compare( PHP_VERSION, '5.3', '<' ) ) {
    require_once __DIR__ . '/hooks/display-version-error.php';
    return;
  }

  if (!class_exists('\SoapClient')) {
    require_once __DIR__ . '/hooks/display-no-soap-error.php';
    return;
  }

  require_once __DIR__ . '/sdk-includes.php';
  require_once __DIR__ . '/actions/cancel-order.php';
  require_once __DIR__ . '/actions/complete-order.php';
  require_once __DIR__ . '/actions/create-default-payment-form-page.php';
  require_once __DIR__ . '/actions/form.php';
  require_once __DIR__ . '/actions/get-default-payment-form-page.php';
  require_once __DIR__ . '/actions/get-months.php';
  require_once __DIR__ . '/actions/get-options.php';
  require_once __DIR__ . '/actions/get-settings-url.php';
  require_once __DIR__ . '/actions/get-user-id.php';
  require_once __DIR__ . '/actions/return.php';
  require_once __DIR__ . '/hooks/account-configuration.php';
  require_once __DIR__ . '/hooks/account-not-configured-warning.php';
  require_once __DIR__ . '/hooks/add-form-shortcode.php';
  require_once __DIR__ . '/hooks/add-payment-method.php';
  require_once __DIR__ . '/hooks/add-query-vars.php';
  require_once __DIR__ . '/hooks/add-rewrite-rules.php';
  require_once __DIR__ . '/hooks/add-settings-button.php';
  require_once __DIR__ . '/hooks/hide-payment-form-from-menu.php';
  require_once __DIR__ . '/hooks/order-cancelled.php';
  require_once __DIR__ . '/hooks/order-completed.php';
  require_once __DIR__ . '/hooks/order-notes-css.php';
  require_once __DIR__ . '/hooks/parse-request.php';
  require_once __DIR__ . '/hooks/register-assets.php';
  require_once __DIR__ . '/payment-gateway.php';
}

add_action('plugins_loaded', 'wc_visanet_init');
register_activation_hook(__FILE__, 'wc_visanet_will_setup_hook');
