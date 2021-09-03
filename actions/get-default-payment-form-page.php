<?php

function wc_visanet_get_default_payment_form_page() {
  global $wpdb;

  $query = '
    SELECT ID
    FROM wp_posts
    WHERE post_type = "page"
    AND post_name LIKE %s
    AND post_status = "publish"
    LIMIT 1
  ';

  $like = '%pago-con-tarjeta-visa%';

  $results = $wpdb->get_results($wpdb->prepare($query, $like), OBJECT);

  if (count($results) === 0) {
    return false;
  }

  return $results[0]->ID;
}
