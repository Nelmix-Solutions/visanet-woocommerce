<?php
namespace VisanetSDK\lib\fieldsMutators;

class FieldsMutationPipeline extends FieldsMutator
{
  static function mutate(array &$params)
  {
    DefaultParams::mutate($params);
    GeneratedFields::mutate($params);
    AccountFields::mutate($params);
    FieldsEncoder::mutate($params);
    FieldsTruncator::mutate($params);
    FieldsTranslator::mutate($params);
    FieldsToBeSigned::mutate($params);
    FieldsFlatter::mutate($params);
    FieldsSigner::mutate($params);
  }
}
