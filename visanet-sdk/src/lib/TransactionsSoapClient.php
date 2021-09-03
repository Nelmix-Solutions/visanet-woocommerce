<?php

namespace VisanetSDK\lib;

use \VisanetSDK\Account;
use \VisanetSDK\lib\exceptions\SoapTransactionError;

//ics2wsa.ic3.com
define( 'WSDL_TEST_URL', 'https://ics2wstest.ic3.com/commerce/1.x/transactionProcessor/CyberSourceTransaction_1.132.wsdl' );
define( 'WSDL_LIVE_URL', 'https://ics2wsa.ic3.com/commerce/1.x/transactionProcessor/CyberSourceTransaction_1.132.wsdl' );

class TransactionsSoapClient extends \SoapClient
{
  public function __construct(array $options = array())
  {
    $url = WSDL_LIVE_URL;

    if (Account::isTestingMode()) {
      $url = WSDL_TEST_URL;
    }

    parent::__construct($url, $options);
  }

  public function __doRequest($request, $location, $action, $version, $oneWay = null)
  {
    $request = self::__prepareRequest($request);

    return parent::__doRequest(
      $request,
      $location,
      $action,
      $version,
      $oneWay
    );
  }

  public function runTransaction($payload) {
    $response = parent::runTransaction($payload);

    if ($response->decision === 'REJECT') {
      throw new SoapTransactionError(
        "REJECTED {$response->reasonCode}",
        $response->reasonCode,
        $response->requestID
      );
    }

    return $response;
  }

  protected function __prepareRequest($request)
  {
    try {
      $header = self::__getRequestHeader();

      $requestDom = new \DomDocument('1.0');
      $headerDom = new \DomDocument('1.0');

      $requestDom->loadXml($request);
      $headerDom->loadXml($header);

      $node = $requestDom->importNode($headerDom->firstChild, true);
      $requestDom->firstChild->insertBefore(
        $node,
        $requestDom->firstChild->firstChild
      );

      return $requestDom->saveXml();
    } catch (\DOMException $e) {
      die( 'Error adding UsernameToken: ' . $e->code);
    }
  }

  protected function __getRequestHeader()
  {
    $merchantId = Account::getMerchantId();
    $transactionKey = Account::getTransactionKey();

    return "<SOAP-ENV:Header xmlns:SOAP-ENV=\"http://schemas.xmlsoap.org/soap/envelope/\" xmlns:wsse=\"http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-secext-1.0.xsd\"><wsse:Security SOAP-ENV:mustUnderstand=\"1\"><wsse:UsernameToken><wsse:Username>$merchantId</wsse:Username><wsse:Password Type=\"http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-username-token-profile-1.0#PasswordText\">$transactionKey</wsse:Password></wsse:UsernameToken></wsse:Security></SOAP-ENV:Header>";
  }
}
