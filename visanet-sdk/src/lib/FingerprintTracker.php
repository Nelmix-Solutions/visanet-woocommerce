<?php

namespace VisanetSDK\lib;

use \VisanetSDK\Account;

class FingerprintTracker
{
  protected $sessionId;
  protected static $productionUrl = 'https://h.online-metrix.net/fp/clear.png';
  protected static $orgId = '1snn5n9w';

  public function __construct($sessionId)
  {
    $this->sessionId = $sessionId;
  }

  public function getPixelUrlForMethod($method = 1)
  {
    $url = self::$productionUrl;

    $profileId = Account::getProfileId();
    $url .= "?org_id=".self::$orgId;
    $url .= "&amp;session_id=".$this->getSessionId();
    $url .= "&amp;m=$method";

    return $url;
  }

  public function getFlashUrl()
  {
    $url = 'https://h.online-metrix.net/fp/fp.swf';
    $url .= '?org_id=' . self::$orgId;
    $url .= "&amp;session_id=".$this->getSessionId();
    return $url;
  }

  public function getScriptUrl()
  {
    $url = 'https://h.online-metrix.net/fp/check.js';
    $url .= '?org_id=' . self::$orgId;
    $url .= "&amp;session_id=".$this->getSessionId();
    return $url;
  }

  protected function getSessionId()
  {
    $merchantId = Account::getMerchantId();
    return $merchantId . $this->sessionId;
  }
}
