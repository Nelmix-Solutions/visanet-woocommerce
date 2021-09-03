<?php
namespace VisanetSDK;

use \VisanetSDK\lib\exceptions\PaymentResponseNotFound;
use \VisanetSDK\lib\exceptions\PaymentResponseError;
use \VisanetSDK\lib\Injection;

class PaymentResponse
{
  static function process()
  {
    self::throwExceptionIfNoResponseFound();
    self::handleDecisionError();

    return $_REQUEST;
  }
  protected static function throwExceptionIfNoResponseFound()
  {
    if (!isset($_REQUEST['decision'])) {
      throw new PaymentResponseNotFound('Response not found.');
    }
  }

  protected static function handleDecisionError()
  {
    if (
      $_REQUEST['decision'] == 'ERROR'
      || $_REQUEST['decision'] == 'DECLINE'
      || $_REQUEST['decision_rcode'] == '0'
    ) {
      self::handleRevertPayment();
      self::throwPaymentError();
    }
  }

  protected static function handleRevertPayment()
  {
    $reasonCode = (int) $_REQUEST['reason_code'];

    if (
      $reasonCode === 200 // Address Verification Service declined
      || $reasonCode === 230 // CVN verification declined
      || $reasonCode >= 400 // Fraud detection declined
    ) {
      $RevertPaymentRequest = Injection::getByName('RevertPaymentRequest');
      $request = new $RevertPaymentRequest();

      $request->revert(
        $_REQUEST['transaction_id'],
        $_REQUEST['auth_amount'],
        $_REQUEST['req_reference_number'],
        $_REQUEST['req_device_fingerprint_id']
      );
    }
  }

  protected static function throwPaymentError()
  {
    throw new PaymentResponseError(
        $_REQUEST['message'],
        $_REQUEST['reason_code'],
        $_REQUEST['transaction_id']
    );
  }
}
