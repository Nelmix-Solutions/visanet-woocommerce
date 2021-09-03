<?php
namespace VisanetSDK\lib\fieldsMutators;

class FieldsEncoder extends FieldsMutator
{
  static function mutate(array &$params)
  {
    foreach ($params as $name => $value) {
      $params[$name] = html_entity_decode($value);
    }
  }
}
