<?php

function wc_visanet_get_settings_url() {
  $url = 'admin.php?page=wc-settings';
  $url .= '&tab=checkout';
  $url .= '&section=visanet_gateway';
  $url = admin_url($url);

  return $url;
}
