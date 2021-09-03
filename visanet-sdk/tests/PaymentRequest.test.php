<?php
use PHPUnit\Framework\TestCase;

final class PaymentRequestTestCase extends TestCase
{
  private function _getPaymentRequest()
  {
    $config = array(
      'profile_id' => 'accountabc123',
      'merchant_id' => 'merchantabc123',
      'access_key' => 'visanet123',
      'vertical' => 'RETAIL',
    );

    \VisanetSDK\lib\Injection::setByName('Random', '\VisanetTest\mocks\Random');

    \VisanetSDK\Account::configure($config);
    \VisanetSDK\Account::readSecretKeyFromFile(__DIR__.'/../private/test.key');

    return new \VisanetSDK\PaymentRequest();
  }

  private function _getFunctionEcho($function)
  {
    ob_start();
    $function();
    return ob_get_clean();
  }

  public function testSignedFields()
  {
    $request = $this->_getPaymentRequest();

    $request->signFields(
        array(
          'amount' => 180.5,
          'bill_to_email' => 'info@example.com',
        )
    );

    $result = $this->_getFunctionEcho(
        function () use ($request) {
          $request->printRequestFields();
        }
    );

    $path = __DIR__.'/html/signed-inputs.html';
    $this->assertStringEqualsFile($path, $result);
  }

  public function testFingerprintTracker()
  {
    $request = $this->_getPaymentRequest();

    $result = $this->_getFunctionEcho(
        function () use ($request) {
          $request->printFingerprintTracker();
        }
    );

    $path = __DIR__.'/html/fingerprint-tracker.html';
    $this->assertStringEqualsFile($path, $result);
  }

  public function testAddingItemsToRequest()
  {
    $request = $this->_getPaymentRequest();

    $request->addItem(
        array(
          'code' => '#1234',
          'sku' => '#1234',
          'name' => 'T-Shirt',
          'quantity' => '1',
          'tax' => '0.5',
          'price' => '12.5'
        )
    );

    $request->addItem(
        array(
          'code' => '#5678',
          'sku' => '#123',
          'name' => 'Baseball Cap',
          'quantity' => '1',
          'tax' => '0.3',
          'price' => '6.7'
        )
    );

    $result = $this->_getFunctionEcho(
        function () use ($request) {
          $request->printRequestFields();
        }
    );

    $path = __DIR__.'/html/line-item-fields.html';
    $this->assertStringEqualsFile($path, $result);
  }

  public function testgetActionUrl()
  {
    $request = $this->_getPaymentRequest();

    $result = $request->getActionUrl();
    $expected = 'https://secureacceptance.cybersource.com/silent/pay';

    $this->assertEquals($expected, $result);

    \VisanetSDK\Account::testingModeOn();

    $result = $request->getActionUrl();
    $expected = 'https://testsecureacceptance.cybersource.com/silent/pay';

    $this->assertEquals($expected, $result);
  }
}
