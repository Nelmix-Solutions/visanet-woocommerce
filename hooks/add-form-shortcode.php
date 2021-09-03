<?php

function wc_visanet_payment_form_shortcode() {
  return wc_visanet_form();
}

add_shortcode( 'wc_visanet_payment_form' , 'wc_visanet_payment_form_shortcode' );
