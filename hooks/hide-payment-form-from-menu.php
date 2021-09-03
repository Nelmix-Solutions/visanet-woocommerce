<?php

function wc_visanet_hide_payment_form_from_menu($args) {
  $exclude = $args['exclude'];
  $options = wc_visanet_get_options();
  $paymentFormPage = $options['payment_form_page'];

  if (!$paymentFormPage) return $args;

  if (!$exclude) {
    $exclude = $paymentFormPage;
  } else if (is_array($exclude)) {
    $exclude[] = $paymentFormPage;
  } else {
    $exclude .= ','.$paymentFormPage;
  }

  $args['exclude'] = $exclude;
  return $args;
}

add_filter('wp_nav_menu_args', 'wc_visanet_hide_payment_form_from_menu');
