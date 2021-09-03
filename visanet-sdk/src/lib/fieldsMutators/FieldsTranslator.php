<?php
namespace VisanetSDK\lib\fieldsMutators;

class FieldsTranslator extends FieldsMutator
{
  protected static $mddTranslation = array(
    'vertical' => 1,
    'merchant_id' => 2,
    'conection_type' => 3,
    'client_identification_number' => 4,
    'email' => 5,
    'sku' => 6,
    'user_type' => 7,
    'account_registration_date' => 8,
    'number_of_previous_transactions' => 9,
    'last_transaction_date' => 10,
    'retail_store_number' => 11,
    'address_type' => 12,
  );
  protected static $mddName = 'merchant_defined_data';

  static function mutate(array &$params)
  {
    foreach (self::$mddTranslation as $fieldName => $mddNumber) {
      if (!isset($params[$fieldName])) {
        continue;
      }

      $newFieldName = self::$mddName . $mddNumber;

      $params[$newFieldName] = $params[$fieldName];

      unset($params[$fieldName]);
    }
  }
}
