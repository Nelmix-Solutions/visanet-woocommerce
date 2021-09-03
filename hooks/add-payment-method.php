<?php

function wc_visanet_add_payment_method( $methods ) {
  $methods[] = 'WC_Visanet_Payment_Gateway';
  return $methods;
}

add_filter( 'woocommerce_payment_gateways', 'wc_visanet_add_payment_method' );
