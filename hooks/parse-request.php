<?php

function wc_visanet_parse_request(&$wp) {
  if (isset($wp->query_vars['wc_visanet_return'])) {
    wc_visanet_return($wp);
  }

  return;
}

add_action( 'parse_request', 'wc_visanet_parse_request' );
