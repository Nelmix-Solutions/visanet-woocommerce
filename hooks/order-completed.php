<?php


function wc_visanet_order_completed($order_id) {
  wc_visanet_complete_order($order_id);
}

add_action(
  'woocommerce_order_status_completed',
  'wc_visanet_order_completed',
  10,
  1
);
