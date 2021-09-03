<?php

use \VisanetSDK\RevertPaymentRequest;
use \VisanetSDK\lib\exceptions\SoapTransactionError;

function wc_visanet_cancel_order($order_id) {
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
    $request = new RevertPaymentRequest();

    $data = $order->get_data();
    $response = $request->revert(
      $transactionId,
      $data['total'],
      $order_id,
      session_id()
    );

    update_post_meta($order_id, '_visanet_payment_status', 'cancelled');

    $noteId = $order->add_order_note(__('Pago con Visa cancelado. ID#'.$response->requestID, 'wc-visa'));
    add_comment_meta($noteId, '_wc_visanet_note_type', 'warning', true);

  } catch(SoapTransactionError $e) {
    $noteId = $order->add_order_note(__('Error en cancelación con Visa. ID#'.$e->requestId, 'wc-visanet'));
    add_comment_meta($noteId, '_wc_visanet_note_type', 'error', true);
  }
}
