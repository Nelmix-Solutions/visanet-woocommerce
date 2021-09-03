<?php
namespace VisanetSDK\lib\fieldsMutators;

class AccountFields extends FieldsMutator
{
  static function mutate(array &$params)
  {
    $params['profile_id'] = \VisanetSDK\Account::getProfileId();
    $params['merchant_id'] = \VisanetSDK\Account::getMerchantId();
    $params['access_key'] = \VisanetSDK\Account::getAccessKey();
    $params['currency'] = \VisanetSDK\Account::getCurrency();
  }
}
