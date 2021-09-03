<?php
namespace VisanetSDK\lib\fieldsMutators;
use \VisanetSDK\lib\Injection;

class GeneratedFields extends FieldsMutator
{
  static function mutate(array &$params)
  {
    $random = Injection::getByName('Random');

    if (!isset($params['reference_number'])) {
      $params['reference_number'] = $random::getUuid();
    }

    $params['transaction_uuid'] = $random::getUuid();
    $params['signed_date_time'] = $random::getGmtDate();
  }
}
