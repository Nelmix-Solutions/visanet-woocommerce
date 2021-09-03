<?php

function wc_visanet_register_assets() {
  $plugin_url =  plugins_url() . '/' . WC_VISANET_DIR;

  wp_enqueue_style('wc-visanet-css', $plugin_url.'/css/main.css',array('main.css'));
  wp_enqueue_script('wc-visanet-js', $plugin_url.'/js/visanet.js', array('jquery'));

}

add_action('init', 'wc_visanet_register_assets');
