<?php

function wc_visanet_form() {
  global $wp;
  $order_id = $wp->query_vars['wc_visanet_form'];

  if($order_id === NULL) {
    echo 'Número de orden no encontrado.';
    return;
  }

  try {
    $order = new WC_Order($order_id);
  } catch(\Exception $e) {
    echo 'Order #' . $order_id . ' no encontrada.';
    return;
  }


  $data = $order->get_data();
  $billing = (object) $data['billing'];
  $shipping = $data['shipping'];

  if (redirectToOrderDetailsIfNotPendingPayment($order)) {
    return;
  }

  $user_id = wc_visanet_get_user_id();

  $options = wc_visanet_get_options();

  $transactionType = 'sale';

  if ($options['auto_authorize'] === 'no') {
    $transactionType = 'authorization';
  }

  $request = new \VisanetSDK\PaymentRequest();
  $request->signFields(
      array(
        'transaction_type' => $transactionType,

        'reference_number' => $order_id,
        'client_identification_number' => $user_id,

        'bill_to_forename' => $billing->first_name,
        'bill_to_surname' => $billing->last_name,
        'bill_to_email' => $billing->email,
        'bill_to_phone' => $billing->phone,
        'bill_to_address_line1' => $billing->address_1,
        'bill_to_address_line2' => $billing->address_2,
        'bill_to_address_city' => $billing->city,
        'bill_to_address_state' => $billing->state,
        'bill_to_address_country' => 'DO', //$billing->country,
        'bill_to_address_postal_code' => $billing->postcode,
      )
  );

  if (!empty($billing->company)) {
    $request->signFields(array(
      'bill_to_company_name' => $billing->company
    ));
  }

  $items = $order->get_items();
  foreach($items as $item) {
    $price = $item['subtotal'] / $item['quantity'];
    $tax = $item['subtotal_tax'] / $item['quantity'];

    $itemData = array(
      'name' => $item['name'],
      'quantity' => $item['quantity'],
      'price' => $price,
      'tax' => $tax,
    );

    $sku = get_item_sku($item);
    if (!empty($sku)) {
      $itemData['sku'] = $sku;
    }

    $request->addItem($itemData);
  }

  if (
    !empty($shipping)
    && isset($shipping['address_1'])
    && !empty($shipping['address_1'])
  ) {
    $shipping = (object) $shipping;

    $request->signFields(
        array(
          'ship_to_forename' => $shipping->first_name,
          'ship_to_surname' => $shipping->last_name,
          'ship_to_address_line1' => $shipping->address_1,
          'ship_to_address_line2' => $shipping->address_2,
          'ship_to_address_city' => $shipping->city,
          'ship_to_address_state' => $shipping->state,
          'ship_to_address_country' => $shipping->country,
          'ship_to_address_postal_code' => $shipping->postcode,
        )
    );

    if (!empty($shipping->company)) {
      $request->signFields(array(
        'ship_to_company_name' => $shipping->company
      ));
    }

    $request->addShipping(array(
      'price' => $data['shipping_total'],
      'tax' => $data['shipping_tax']
    ));
  }

  if (!empty($data['coupon_lines'])) {
    foreach($data['coupon_lines'] as $coupon) {
      $cdata = $coupon->get_data();

      $request->addDiscount(array(
        'name' => $cdata['code'],
        'price' => (float) $cdata['discount'],
        'tax' => (float) $cdata['discount_tax']
      ));
    }
  }

  require_once __DIR__ . '/../parts/form.php';
  return;
}

function redirectToOrderDetailsIfNotPendingPayment($order) {
  $status = $order->get_status();

  if ($status !== 'pending') {
    $visanet_gateway = new WC_Visanet_Payment_Gateway();

    $url = $visanet_gateway->get_return_url($order);
?>
<script>
setTimeout(function () {
  window.location = '<?php echo $url; ?>';
}, 0);
</script>
<?php
    return true;
  }

  return false;
}

function get_item_sku($item) {
  if ($item['variation_id']) {
    return get_post_meta( $item['variation_id'], '_sku', true );
  } else {
    $product = new WC_Product($item['product_id']);
    return $product->get_sku();
  }
}
