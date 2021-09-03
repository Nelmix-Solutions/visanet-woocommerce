<?php

function wc_visanet_add_settings_button($links) {
  $url = wc_visanet_get_settings_url();

  $linksToMerge = array(
    'settings' => '<a href="'.$url.'">'.__('Configuración', 'wc-visanet').'</a>'
  );

  return array_merge($linksToMerge, $links);
}

add_filter(
  'plugin_action_links_' . WC_VISANET_PLUGIN,
  'wc_visanet_add_settings_button'
);
