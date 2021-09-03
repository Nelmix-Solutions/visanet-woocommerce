<?php
namespace VisanetSDK\lib\fieldsMutators;

abstract class FieldsMutator
{
  abstract static function mutate(array &$params);
}
