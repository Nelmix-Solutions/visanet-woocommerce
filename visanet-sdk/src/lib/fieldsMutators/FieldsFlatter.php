<?php
namespace VisanetSDK\lib\fieldsMutators;

class FieldsFlatter extends FieldsMutator
{
  protected static $fieldsToFlatten = array(
    'signed_field_names',
    'unsigned_field_names',
  );

  static function mutate(array &$params)
  {
    foreach (self::$fieldsToFlatten as $fieldName) {
      $params[$fieldName] = self::flatten($params[$fieldName]);
    }
  }

  static function flatten(array $array)
  {
    return implode(',', $array);
  }
}
