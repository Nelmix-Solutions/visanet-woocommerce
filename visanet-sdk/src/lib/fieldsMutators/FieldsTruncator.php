<?php
namespace VisanetSDK\lib\fieldsMutators;

class FieldsTruncator extends FieldsMutator
{
  protected static $fieldLimits = array(
    'bill_to_company_name' => 40,
    'bill_to_email' => 255,
    'bill_to_phone' => 15,
    'bill_to_forename' => 60,
    'bill_to_surname' => 60,
    'bill_to_address_city' => 50,
    'bill_to_address_country' => 2,
    'bill_to_address_line1' => 60,
    'bill_to_address_line2' => 60,
    'bill_to_address_state' => 60,
    'bill_to_address_postal_code' => 10,
    'ship_to_company_name' => 40,
    'ship_to_email' => 255,
    'ship_to_phone' => 15,
    'ship_to_forename' => 60,
    'ship_to_surname' => 60,
    'ship_to_address_city' => 50,
    'ship_to_address_country' => 2,
    'ship_to_address_line1' => 60,
    'ship_to_address_line2' => 60,
    'ship_to_address_state' => 60,
    'ship_to_address_postal_code' => 10,
  );

  static function mutate(array &$params)
  {
    foreach(self::$fieldLimits as $fieldName => $limit) {
      if (isset($params[$fieldName])) {
        $params[$fieldName] = substr($params[$fieldName], 0, $limit);
      }
    }
  }
}
