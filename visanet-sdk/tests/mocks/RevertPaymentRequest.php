<?php

namespace VisanetTest\mocks;

class RevertPaymentRequest {
  public static $calls = array();

  public function revert($transactionId, $authorizationAmount) {
    self::$calls[] = array(
      'transactionId' => $transactionId,
      'authAmount' => $authorizationAmount,
    );
  }
}
