<?php

use PHPUnit\Framework\TestCase;
use VisanetSDK\Account;

final class AccountTestCase extends TestCase
{
  /**
   * @expectedException Exception
   */
  public function testCantInstantiate()
  {
    $account = new Account();
  }

  private function _getConfig()
  {
    return array(
      'profile_id' => 'accountabc123',
      'merchant_id' => 'merchantabc123',
      'access_key' => 'visanet123',
      'secret_key' => 'ABC123ABC123ABC123',
      'transaction_key' => 'XYZ123XYZ123XYZ123',
      'currency' => 'DOP',
    );
  }

  public function testSetAndGetConfiguration()
  {
    $config = $this->_getConfig();

    Account::configure($config);

    $result = Account::getConfiguration();

    $this->assertEquals($config, $result);
  }

  public function testReadSecretKeyFile()
  {
    $config = $this->_getConfig();
    $expected = $this->_getConfig();

    unset($config['secret_key']);

    $expected['secret_key'] = 'TESTSECRETKEY123ABC';

    Account::configure($config);

    Account::readSecretKeyFromFile(__DIR__ . '/../private/test.key');

    $result = Account::getConfiguration();

    $this->assertArraySubset($expected, $result);
  }

  public function testGetSecretKey()
  {
    $config = $this->_getConfig();

    Account::configure($config);

    $result = Account::getSecretKey();

    $this->assertEquals($config['secret_key'], $result);
  }

  /**
   * @expectedException Exception
   * @runInSeparateProcess
   */
  public function testThrowErrorWhenGettingUndefinedSecretKey()
  {
    $config = $this->_getConfig();

    unset($config['secret_key']);

    Account::configure($config);

    Account::getSecretKey();
  }

  public function testGetProfileId()
  {
    $config = $this->_getConfig();

    Account::configure($config);

    $result = Account::getProfileId();

    $this->assertEquals($config['profile_id'], $result);
  }

  /**
   * @expectedException Exception
   * @runInSeparateProcess
   */
  public function testThrowErrorWhenGettingUndefinedProfileId()
  {
    $config = $this->_getConfig();

    unset($config['profile_id']);

    Account::configure($config);

    Account::getProfileId();
  }

  public function testGetMerchantId()
  {
    $config = $this->_getConfig();

    Account::configure($config);

    $result = Account::getMerchantId();

    $this->assertEquals($config['merchant_id'], $result);
  }

  /**
   * @expectedException Exception
   * @runInSeparateProcess
   */
  public function testThrowErrorWhenGettingUndefinedMerchantId()
  {
    $config = $this->_getConfig();

    unset($config['merchant_id']);

    Account::configure($config);

    Account::getMerchantId();
  }

  public function testGetAccessKey()
  {
    $config = $this->_getConfig();

    Account::configure($config);

    $result = Account::getAccessKey();

    $this->assertEquals($config['access_key'], $result);
  }

  /**
   * @expectedException Exception
   * @runInSeparateProcess
   */
  public function testThrowErrorWhenGettingUndefinedAccessKey()
  {
    $config = $this->_getConfig();

    unset($config['access_key']);

    Account::configure($config);

    Account::getAccessKey();
  }

  public function testGetCurrency()
  {
    $config = $this->_getConfig();

    Account::configure($config);

    $result = Account::getCurrency();

    $this->assertEquals($config['currency'], $result);
  }

  public function testGetDefaultCurrency()
  {
    $config = $this->_getConfig();

    unset($config['currency']);

    Account::configure($config);

    $result = Account::getCurrency();

    $this->assertEquals('DOP', $result);
  }

  public function testGetTransactionKey()
  {
    $config = $this->_getConfig();

    Account::configure($config);

    $result = Account::getTransactionKey();

    $this->assertEquals($config['transaction_key'], $result);
  }

  /**
   * @expectedException Exception
   * @runInSeparateProcess
   */
  public function testGetTransactionKeyException()
  {
    $config = $this->_getConfig();

    unset($config['transaction_key']);

    Account::configure($config);
    Account::getTransactionKey();
  }

  public function testTestingModeOn()
  {
    $config = $this->_getConfig();

    Account::configure($config);

    Account::testingModeOn();

    $this->assertTrue(true);
  }

  public function testTestingModeOff()
  {
    $config = $this->_getConfig();

    Account::configure($config);

    Account::testingModeOff();

    $this->assertTrue(true);
  }

  public function testIsTestingMode()
  {
    $config = $this->_getConfig();

    Account::configure($config);

    $this->assertEquals(false, Account::isTestingMode());

    Account::testingModeOn();

    $this->assertEquals(true, Account::isTestingMode());

    Account::testingModeOff();

    $this->assertEquals(false, Account::isTestingMode());
  }
}
