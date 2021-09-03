<?php
namespace VisanetSDK\lib\fieldsMutators;

class FieldsSigner extends FieldsMutator
{
  static function mutate(array &$params)
  {
    if (!isset($params['signed_field_names']) && !is_array($params['signed_field_names'])) {
      throw new \Error('signed field names is empty');
    }

    $fieldsString = self::getFieldsString($params);

    $params['signature'] = self::signValue($fieldsString);
  }

  protected static function getFieldsString($params)
  {
    $fields = array();

    $fieldNames = explode(',', $params['signed_field_names']);
    foreach ($fieldNames as $fieldName) {
      $fieldValue = $params[$fieldName];
      $fields[] = "$fieldName=$fieldValue";
    }

    return implode(',', $fields);
  }

  protected static function signValue($value)
  {
    $secretKey = \VisanetSDK\Account::getSecretKey();
    return base64_encode(hash_hmac('sha256', $value, $secretKey, true));
  }
}
