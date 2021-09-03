<?php
namespace VisanetSDK\lib\exceptions;

class SoapTransactionError extends \Exception
{
  public function __construct($message, $code, $requestId) {
    parent::__construct($message, $code);
    $this->requestId = $requestId;
  }
}
