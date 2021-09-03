<?php
namespace VisanetSDK\lib;

class Random
{
  static function getUuid()
  {
    return uniqid();
  }

  static function getGmtDate()
  {
    return gmdate("Y-m-d\TH:i:s\Z");
  }
}
