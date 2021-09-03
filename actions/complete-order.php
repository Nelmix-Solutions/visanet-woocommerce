<?php

use \VisanetSDK\PaymentAuthorizationRequest;
use \VisanetSDK\lib\exceptions\SoapTransactionError;

function wc_visanet_complete_order($order_id) {
  $order = new WC_Order($order_id);

  $transactionId = get_post_meta(
    $order_id,
    '_visanet_transaction_id',
    true
  );

  $transactionType = get_post_meta(
    $order_id,
    '_visanet_transaction_type',
    true
  );

  $paymentStatus = get_post_meta(
    $order_id,
    '_visanet_payment_status',
    true
  );

  if (
    $transactionType !== 'authorization'
    || $paymentStatus !== 'authorized'
  ) {
    return;
  }

  try {
    $request = new PaymentAuthorizationRequest();

    $data = $order->get_data();
    $response = $request->authorize(
      $transactionId,
      $data['total'],
      $order_id,
      session_id()
    );

    update_post_meta($order_id, '_visanet_payment_status', 'completed');

    $noteId = $order->add_order_note(__('Pago con Visa completado. ID#'.$response->requestID, 'wc-visanet'));
    add_comment_meta($noteId, '_wc_visanet_note_type', 'success', true);

  } catch(SoapTransactionError $e) {
    $noteId = $order->add_order_note(__('Error en liquidación con Visa. ID#'.$e->requestId, 'wc-visanet'));
    add_comment_meta($noteId, '_wc_visanet_note_type', 'error', true);
  }
}
