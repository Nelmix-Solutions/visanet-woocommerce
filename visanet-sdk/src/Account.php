<?php

namespace VisanetSDK;

final class Account
{
  private static $_configuration = array();

  private static $_profileId;
  private static $_merchantId;
  private static $_accessKey;
  private static $_secretKey;
  private static $_transactionKey;
  private static $_currency;
  private static $_DEFAULT_CURRENCY = 'DOP';
  private static $_testingMode = false;

  function __construct()
  {
    throw new \Exception("Class can't be instantiated");
  }

  public static function configure(array $configuration)
  {
    if (isset($configuration['profile_id']))
      self::$_profileId = $configuration['profile_id'];

    if (isset($configuration['merchant_id']))
      self::$_merchantId = $configuration['merchant_id'];

    if (isset($configuration['access_key']))
      self::$_accessKey = $configuration['access_key'];

    if (isset($configuration['secret_key']))
      self::$_secretKey = $configuration['secret_key'];

    if (isset($configuration['transaction_key']))
      self::$_transactionKey = $configuration['transaction_key'];

    if (isset($configuration['currency']))
      self::$_currency = $configuration['currency'];
  }

  public static function getConfiguration()
  {
    $config = array(
      'profile_id' => self::getProfileId(),
      'merchant_id' => self::getMerchantId(),
      'access_key' => self::getAccessKey(),
      'secret_key' => self::getSecretKey(),
      'transaction_key' => self::getTransactionKey(),
      'currency' => self::getCurrency(),
    );

    return $config;
  }

  public static function readSecretKeyFromFile($filePath)
  {
    self::$_secretKey = self::readKeyFromFile($filePath);
  }

  public static function readTransactionKeyFromFile($filePath)
  {
    self::$_transactionKey = self::readKeyFromFile($filePath);
  }

  protected static function readKeyFromFile($filePath)
  {
    $key = file_get_contents($filePath);
    $key = trim($key);

    return $key;
  }

  public static function getSecretKey()
  {
    if (empty(self::$_secretKey)) {
      throw new \Exception("Secret Key not defined");
    }

    return self::$_secretKey;
  }

  public static function getProfileId()
  {
    if (empty(self::$_profileId)) {
      throw new \Exception("Profile Id not defined");
    }

    return self::$_profileId;
  }

  public static function getMerchantId()
  {
    if (empty(self::$_merchantId)) {
      throw new \Exception("Merchant Id not defined");
    }

    return self::$_merchantId;
  }

  public static function getAccessKey()
  {
    if (empty(self::$_accessKey)) {
      throw new \Exception("Access Key not defined");
    }

    return self::$_accessKey;
  }

  public static function getCurrency()
  {
    if (isset(self::$_currency) && !empty(self::$_currency)) {
      return self::$_currency;
    } else {
      return self::$_DEFAULT_CURRENCY;
    }
  }

  public static function getTransactionKey()
  {
    if (empty(self::$_transactionKey)) {
      throw new \Exception("Transaction Key not defined");
    }

    return self::$_transactionKey;
  }

  public static function testingModeOn()
  {
    self::$_testingMode = true;
  }

  public static function testingModeOff()
  {
    self::$_testingMode = false;
  }

  public static function isTestingMode()
  {
    return self::$_testingMode;
  }
}
