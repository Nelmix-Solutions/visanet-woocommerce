<?php

function wc_visanet_add_rewrite_rules() {
  $options = wc_visanet_get_options();

  if (
    isset($options['return_url'])
    && !empty($options['return_url'])
  ) {
    add_rewrite_rule(
      $options['return_url'].'$',
      'index.php?wc_visanet_return=1',
      'top'
    );
  }
}

add_action( 'init', 'wc_visanet_add_rewrite_rules' );
