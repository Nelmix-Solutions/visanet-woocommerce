<?php
namespace VisanetSDK\lib\exceptions;

class PaymentResponseError extends \Exception
{
  public function __construct($message, $code, $requestId) {
    parent::__construct($message, $code);
    $this->requestId = $requestId;
  }
}
