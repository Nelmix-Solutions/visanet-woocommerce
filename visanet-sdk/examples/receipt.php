<?php

require_once '../vendor/autoload.php';

try {
  $response = \VisanetSDK\PaymentResponse::process();
  require_once 'receipt-success.php';
} catch(\Exception $error) {
  require_once 'receipt-error.php';
}
