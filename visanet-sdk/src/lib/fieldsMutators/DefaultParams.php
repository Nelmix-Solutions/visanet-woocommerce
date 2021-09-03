<?php
namespace VisanetSDK\lib\fieldsMutators;

use \VisanetSDK\lib\IpAddress;

class DefaultParams extends FieldsMutator
{
  protected static $defaults = array(
    //'card_type' => '001',
    'vertical' => 'RETAIL',
    'conection_type' => 'WEB',
    //'customer_identification_type' => 'CEDULA',
    'payment_method' => 'card',
    'locale' => 'es',
    'transaction_type' => 'sale',
  );

  static function mutate(array &$params)
  {
    self::$defaults['customer_ip_address'] = IpAddress::get_ip_address();



    $params = array_merge(self::$defaults, $params);
  }
}
