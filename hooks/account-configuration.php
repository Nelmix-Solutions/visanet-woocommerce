<?php

use \VisanetSDK\Account;

function wc_visanet_account_configuration() {
  $options = wc_visanet_get_options();

  Account::configure(
      array(
        'profile_id' => $options['profile_id'],
        'merchant_id' => $options['merchant_id'],
        'access_key' => $options['access_key'],
        'secret_key' => $options['secret_key'],
        'transaction_key' => $options['transaction_key'],
        'currency' => $options['currency'],
      )
  );

  if ($options['testing_mode'] === 'yes') {
    Account::testingModeOn();
  }
}

add_action( 'init', 'wc_visanet_account_configuration' );
