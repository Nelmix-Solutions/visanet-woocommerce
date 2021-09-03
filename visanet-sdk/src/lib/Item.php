<?php
namespace VisanetSDK\lib;

class Item
{
  protected $itemData;

  public function __construct(array $itemData)
  {
    $this->itemData = $itemData;
    $this->roundTaxAndUnitPrice();
  }

  public function is($type) {
    return $this->itemData['code'] === $type;
  }

  protected function roundTaxAndUnitPrice() {
    if (isset($this->itemData['price'])) {
      $this->itemData['price'] = round($this->itemData['price'], 2);
    }

    if (isset($this->itemData['tax'])) {
      $this->itemData['tax'] = round($this->itemData['tax'], 2);
    }
  }

  public function getFieldsUsingNumber($itemNumber)
  {
    $this->output = array();
    $this->itemNumber = $itemNumber;

    $this->setOutputField('code', 'code', 'default');
    $this->setOutputField('sku', 'sku');
    $this->setOutputField('name', 'name');
    $this->setOutputField('quantity', 'quantity', 1);
    $this->setOutputField('tax', 'tax_amount');
    $this->setOutputField('price', 'unit_price');

    return $this->output;
  }

  protected function setOutputField($internalName, $externalName, $default = null)
  {
    $fieldName = "item_{$this->itemNumber}_{$externalName}";

    if (!isset($this->itemData[ $internalName ])) {

      if ($default) {
        $this->output[ $fieldName ] = $default;
      }

      return;
    }

    $this->output[ $fieldName ] = $this->itemData[ $internalName ];
  }

  public function getPriceTotal()
  {
    $quantity = $this->itemData['quantity'] ? $this->itemData['quantity'] : 1;
    $price = $this->itemData['price'] ? $this->itemData['price'] : 0;
    $tax = $this->itemData['tax'] ? $this->itemData['tax'] : 0;

    return ($price + $tax) * $quantity;
  }
}
