<?php


function wc_visanet_order_cancelled($order_id) {
  wc_visanet_cancel_order($order_id);
}

add_action(
  'woocommerce_order_status_cancelled',
  'wc_visanet_order_cancelled',
  10,
  1
);
