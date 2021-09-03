<?php
namespace VisanetSDK\lib;

class Injection
{
  protected static $defaults = array(
    'Random' => '\VisanetSDK\lib\Random',
    'RevertPaymentRequest' => '\VisanetSDK\RevertPaymentRequest',
  );

  protected static $libs = array();

  static function getAll()
  {
    return array_merge(self::$defaults, self::$libs);
  }

  static function getByName($name)
  {
    $libs = self::getAll();

    if (!isset($libs[$name])) {
      throw new \Error('Library *'.$name.'* not found.');
    }

    return $libs[$name];
  }

  static function setByName($name, $classPath)
  {
    self::$libs[$name] = $classPath;
  }
}
