<?php
namespace VisanetSDK;

use \VisanetSDK\Account;
use \VisanetSDK\lib\SignedFields;
use \VisanetSDK\lib\helpers\Html;
use \VisanetSDK\lib\FingerprintTracker;
use \VisanetSDK\lib\fieldsMutators\FieldsMutationPipeline;
use \VisanetSDK\lib\Injection;

class PaymentRequest
{
  protected $fields = array();
  protected $fieldsToBeSigned = array();
  protected $sessionId;
  protected $items = array();
  protected $shippingData = null;
  protected $discounts = array();

  protected static $actionUrl = 'https://secureacceptance.cybersource.com/silent/pay';
  protected static $testActionUrl = 'https://testsecureacceptance.cybersource.com/silent/pay';

  public function __construct()
  {
    $this->sessionId = $this->getUuid();
  }

  public function signFields(array $values)
  {
    $this->fields = array_merge($this->fields, $values);
  }

  public function addItem(array $itemData)
  {
    $item = new lib\Item($itemData);
    $this->items[] = $item;
  }

  public function addShipping(array $shippingData) {
    $shippingData['code'] = 'shipping_only';
    $shippingData['sku'] = isset($shippingData['sku']) ?
      $shippingData['sku']:
      'delivery';
    $shippingData['name'] = isset($shippingData['name']) ?
      $shippingData['name']:
      'Delivery';

    $this->shippingData = $shippingData;
  }

  public function addDiscount(array $discountData) {
    $discountData['code'] = 'coupon';
    $discountData['sku'] = isset($discountData['sku']) ?
    $discountData['sku']:
    'coupon';

    $this->addItem($discountData);
  }

  public function getAmount()
  {
    if (empty($this->items)) {
      return (float) round($this->fields['amount'], 2);
    }

    $amount = 0;
    foreach ($this->items as $item) {
      $itemTotal = $item->getPriceTotal();

      if ($item->is('coupon')) {
        $amount -= $itemTotal;
      } else {
        $amount += $itemTotal;
      }
    }

    return (float) round($amount, 2);
  }

  public function printRequestFields()
  {
    $items = $this->items;

    $this->addShippingItemIfAvailable();
    $this->fieldsToBeSigned = $this->getFieldsToBeSigned();
    FieldsMutationPipeline::mutate($this->fieldsToBeSigned);
    echo $this->getSignedFieldHiddenInputs();

    $this->items = $items;
  }

  protected function addShippingItemIfAvailable() {
    if ($this->shippingData === null) return;

    $this->addItem($this->shippingData);
  }

  protected function getFieldsToBeSigned()
  {
    $itemFields = $this->getItemFields();
    $fields = array_merge($itemFields, $this->fields);
    $fields['device_fingerprint_id'] = $this->sessionId;
    return $fields;
  }

  protected function getItemFields()
  {
    $itemFields = array();

    if (empty($this->items)) {
      return $itemFields;
    }

    $itemFields['line_item_count'] = str_pad(count($this->items), 2, '0', STR_PAD_LEFT);

    $itemNumber = 0;
    foreach ($this->items as $item) {
      $itemFields = array_merge($itemFields, $item->getFieldsUsingNumber($itemNumber));
      $itemNumber++;
    }

    $itemFields['amount'] = $this->getAmount();

    return $itemFields;
  }

  protected function getUuid()
  {
    $random = Injection::getByName('Random');
    return $random::getUuid();
  }

  protected function getSignedFieldHiddenInputs()
  {
    $html = '';

    foreach ($this->fieldsToBeSigned as $name => $value) {
      $html .= Html::hiddenInput($name, $value);
    }

    return $html;
  }

  public function printFingerprintTracker()
  {
    $tracker = new FingerprintTracker($this->sessionId);
    $url1 = $tracker->getPixelUrlForMethod(1);
    $url2 = $tracker->getPixelUrlForMethod(2);
    $url3 = $tracker->getFlashUrl();
    $url4 = $tracker->getScriptUrl();

    echo Html::paragraphBackground($url1);
    echo Html::img($url2);
    echo Html::swf($url3);
    echo Html::script($url4);
  }

  public function getActionUrl() {
    if (Account::isTestingMode()) {
      return self::$testActionUrl;
    } else {
      return self::$actionUrl;
    }
  }
}
