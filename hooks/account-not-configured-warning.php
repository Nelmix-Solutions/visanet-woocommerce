<?php

function wc_visanet_account_not_configured_warning() {
  if (
    wc_visanet_required_options_are_empty()
    && wc_visanet_current_url_is_not_settings()
  ) {
    require __DIR__ . '/../parts/configuration-warning.php';
  }
}

function wc_visanet_required_options_are_empty() {
  $options = wc_visanet_get_options();

  return empty($options['profile_id'])
  || empty($options['merchant_id'])
  || empty($options['access_key'])
  || empty($options['secret_key'])
  || empty($options['transaction_key']);
}

function wc_visanet_current_url_is_not_settings() {
  $current_url = $_SERVER['REQUEST_URI'];

  return preg_match("/visanet_gateway$/", $current_url) === 0;
}

add_action( 'admin_notices', 'wc_visanet_account_not_configured_warning' );
