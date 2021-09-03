<?php

require_once '../vendor/autoload.php';

use \VisanetSDK\Account;

Account::configure(
    array(
      'profile_id' => '[YOUR_PROFILE_ID]',
      'merchant_id' => '[YOUR_MERCHANT_ID]',
      'access_key' => '[YOUR_ACCESS_KEY]',
      'secret_key' => '[YOUR_SECRET_KEY]',
      'transaction_key' => '[YOUR_TRANSACTION_KEY]',
      'currency' => 'DOP',
    )
);

Account::readSecretKeyFromFile(__DIR__ . '/../private/sdk.key');
Account::readTransactionKeyFromFile(__DIR__ . '/../private/transaction.key');

Account::testingModeOn();
