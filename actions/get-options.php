<?php

$wc_visanet_options;

function wc_visanet_get_options() {
  if (isset($wc_visanet_options) && is_array($wc_visanet_options)) {
    return $wc_visanet_options;
  }

  $visanet_gateway = new WC_Visanet_Payment_Gateway();

  $wc_visanet_options = array(
    'enabled' => $visanet_gateway->get_option('active'),
    'testing_mode' => $visanet_gateway->get_option('testing_mode'),
    'profile_id' => $visanet_gateway->get_option('profile_id'),
    'merchant_id' => $visanet_gateway->get_option('merchant_id'),
    'access_key' => $visanet_gateway->get_option('access_key'),
    'secret_key' => $visanet_gateway->get_option('secret_key'),
    'transaction_key' => $visanet_gateway->get_option('transaction_key'),
    'currency' => $visanet_gateway->get_option('currency'),
    'auto_authorize' => $visanet_gateway->get_option('auto_authorize'),
    'payment_form_page' => $visanet_gateway->get_option('payment_form_page'),
    'return_url' => $visanet_gateway->get_option('return_url'),
  );

  return $wc_visanet_options;
}
