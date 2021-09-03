<?php

function wc_visanet_create_default_payment_form_page() {
  $paymentFormPage = wc_visanet_get_default_payment_form_page();

  if ($paymentFormPage) {
    return $paymentFormPage;
  }

  return wp_insert_post(array(
    'post_type' => 'page',
    'post_title' => 'Pagar la Orden',
    'post_name' => 'pagar-la-orden',
    'post_content' => '[wc_visanet_payment_form]',
    'post_status' => 'publish',
  ));
}
