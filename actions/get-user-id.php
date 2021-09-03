<?php

function wc_visanet_get_user_id() {
  $cookie = WC()->session->get_session_cookie();

  if (is_array($cookie) && $cookie[0]) {
    return $cookie[0];
  } else {
    return WC()->session->generate_customer_id();
  }
}
