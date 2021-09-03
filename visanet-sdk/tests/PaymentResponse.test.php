<?php
use PHPUnit\Framework\TestCase;
use VisanetSDK\PaymentResponse;
use \VisanetSDK\lib\Injection;
use \VisanetTest\mocks\RevertPaymentRequest;

class PaymentResponseTestCase extends TestCase
{
  /**
   * @expectedException \VisanetSDK\lib\exceptions\PaymentResponseNotFound
   */
  public function testThrowErrorWhenNoResponseFound()
  {
    PaymentResponse::process();
  }

  /**
   * @expectedException \VisanetSDK\lib\exceptions\PaymentResponseError
   */
  public function testThrowErrorWhenResponseHadError()
  {
    $_REQUEST['decision'] = 'ERROR';
    $_REQUEST['message'] = 'Request parameters are invalid or missing';
    $_REQUEST['reason_code'] = '102';

    PaymentResponse::process();
  }

  public function testShouldReturnResponseObjectOnSuccess()
  {
    $_REQUEST['decision'] = 'ACCEPT';

    $result = PaymentResponse::process();

    $this->assertEquals($_REQUEST, $result);
  }

  public function testShouldRevertpaymentOnDecisionError()
  {
    $_REQUEST['decision'] = 'ERROR';
    $_REQUEST['message'] = '';
    $_REQUEST['reason_code'] = '401';
    $_REQUEST['transaction_id'] = '123123123';
    $_REQUEST['auth_amount'] = '321';

    Injection::setByName('RevertPaymentRequest', '\VisanetTest\mocks\RevertPaymentRequest');

    try {
      PaymentResponse::process();
      $this->assertEquals(false, true);
    } catch(\Exception $e) {
      $this->assertEquals(1, count(RevertPaymentRequest::$calls));
      $call = RevertPaymentRequest::$calls[0];

      $this->assertEquals(
        $_REQUEST['transaction_id'],
        $call['transactionId']
      );

      $this->assertEquals(
        $_REQUEST['auth_amount'],
        $call['authAmount']
      );
    }
  }
}
