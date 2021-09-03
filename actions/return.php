<?php

function wc_visanet_return($wp) {
  $order_id = $_REQUEST['req_reference_number'];
  $order = new WC_Order($order_id);
  $visanet_gateway = new WC_Visanet_Payment_Gateway();

  try {
    global $woocommerce;

    $response = \VisanetSDK\PaymentResponse::process();

    wc_visanet_update_status_proccesing($order, $response['transaction_id']);

    $order->reduce_order_stock();
    $woocommerce->cart->empty_cart();

    $transactionType = 'sale';
    $paymentStatus = 'completed';

    if ($visanet_gateway->get_option('auto_authorize') === 'no') {
      $transactionType = 'authorization';
      $paymentStatus = 'authorized';
    }

    update_post_meta(
      $order_id,
      '_visanet_transaction_id',
      $response['transaction_id']
    );

    update_post_meta(
      $order_id,
      '_visanet_transaction_type',
      $transactionType
    );

    update_post_meta(
      $order_id,
      '_visanet_payment_status',
      $paymentStatus
    );

    $url = $visanet_gateway->get_return_url($order);
    wp_redirect($url);
  } catch(Exception $error) {
    //add note
    $noteId = $order->add_order_note(__('Error en pago con Visa. ID#'.$error->requestId, 'wc-visanet'));
    add_comment_meta($noteId, '_wc_visanet_note_type', 'error', true);

    //redirect
    $url = $visanet_gateway->get_option('payment_form_page');
    $url = get_permalink($url);
    $url = add_query_arg(array(
      'wc_visanet_form' => $order_id,
      'wc_visanet_error' => 1,
    ), $url);

    wp_redirect($url);
  }

  exit();
}

function wc_visanet_update_status_proccesing($order, $transactionId) {
  $options = wc_visanet_get_options();

  if ($options['auto_authorize'] === 'yes') {
    $message = __( 'Pago con Visa completado. ID#'.$transactionId, 'wc-visanet' );
  } else {
    $message = __( 'Pago con Visa autorizado. ID#'.$transactionId, 'wc-visanet' );
  }

  $order->add_order_note( $message );
  $order->update_status( 'processing' );
}
