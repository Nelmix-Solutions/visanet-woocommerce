<?php
namespace VisanetTest\mocks;

class Random extends \VisanetSDK\lib\Random
{
  static function getUuid()
  {
    return '123e4567-e89b-12d3-a456-426655440000';
  }

  static function getGmtDate()
  {
    return '2017-01-01T23:59:59+0000';
  }
}
