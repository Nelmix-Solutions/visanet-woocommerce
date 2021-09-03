<?php
namespace VisanetSDK\lib\fieldsMutators;

class FieldsToBeSigned extends FieldsMutator
{
  protected static $requiredFields = array(
    'access_key',
    'bill_to_address_country',
    'bill_to_address_state',
    'bill_to_address_city',
    'bill_to_address_line1',
    'bill_to_forename',
    'bill_to_surname',
    'bill_to_email',
    'bill_to_phone',
    'card_cvn',
    'card_expiry_date',
    'card_number',
    'card_type',
    //'customer_ip_address',
    'currency',
    'merchant_defined_data1',
    //'merchant_defined_data2',
    //'merchant_defined_data3',
    //'merchant_defined_data4',
    'payment_method',
    'profile_id',
    'amount',
    'locale',
    'reference_number',
    //'transaction_type',
    'transaction_uuid',
    'device_fingerprint_id',
  );

  static function mutate(array &$params)
  {
    $params['signed_field_names'] = self::getSignedFieldNames($params);

    $params['unsigned_field_names'] = self::getUnsignedFieldNames($params);
  }

  protected static function getSignedFieldNames($params)
  {
    $signedFieldNames;
    $keys = array_keys($params);

    if (isset($params['unsigned_field_names']) && is_array($params['unsigned_field_names'])) {
      $signedFieldNames = array_diff($keys, $params['unsigned_field_names']);
    } else {
      $signedFieldNames = $keys;
    }

    $signedFieldNames[] = 'signed_field_names';
    $signedFieldNames[] = 'unsigned_field_names';

    return $signedFieldNames;
  }

  protected static function getUnsignedFieldNames($params)
  {
    $unsignedFields = array_diff(self::$requiredFields, $params['signed_field_names']);

    if (isset($params['unsigned_field_names']) && is_array($params['unsigned_field_names'])) {
      return array_merge($params['unsigned_field_names'], $unsignedFields);
    } else {
      return $unsignedFields;
    }
  }
}
