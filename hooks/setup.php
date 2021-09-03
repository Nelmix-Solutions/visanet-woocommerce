<?php

function wc_visanet_will_setup_hook() {
  add_option( 'wc_visanet_will_setup', true );
}

function wc_visanet_setup_hook() {
  $willSetup = get_option('wc_visanet_will_setup');

  if (!is_admin() || $willSetup === false) return;
  delete_option('wc_visanet_will_setup');

  $options = wc_visanet_get_options();

  // checks if page still exists, if not, it creates it:
  if (!empty($options['payment_form_page'])) {
    $page = get_post($options['payment_form_page']);
    if ($page !== NULL) return;
  }

  wc_visanet_create_default_payment_form_page();
}

add_action('init', 'wc_visanet_setup_hook');
