<?php

class WC_Visanet_Payment_Gateway extends WC_Payment_Gateway
{
  public $id = 'visanet_gateway';
  public $title = 'VisaNet - Pago con tarjeta Débito/Crédito';
  public $method_title = 'Visanet';
  public $method_description = 'Acepte tarjetas Débito/Crédito en su negocio';
  public $has_fields = false;
  protected $setupPaymentForm = 'wc_visanet_form_setup';

  public function __construct()
  {
    $this->init_form_fields();
    $this->init_settings();

    add_action(
      'woocommerce_update_options_payment_gateways_' . $this->id,
      array( $this, 'process_admin_options' )
    );
  }

  public function init_form_fields()
  {
    $paymentFormPage = $this->get_payment_form_page();
    $pages = $this->get_pages();

    if ($paymentFormPage === false) {
      $paymentFormPage = $this->setupPaymentForm;
    }

    $this->form_fields = array(
      'enabled' => array(
          'title'   => __( 'Activar', 'wc-visanet' ),
          'type'    => 'checkbox',
          'label'   => __( 'Activar pago con tarjeta.', 'wc-visanet' ),
          'default' => 'yes'
      ),

      'testing_mode' => array(
          'title'   => __( 'Modo', 'wc-visanet' ),
          'type'    => 'select',
          'options'   => array(
            'no' => 'Producción',
            'yes' => 'Prueba '
          ),
          'default' => 'yes'
      ),

      'profile_id' => array(
        'title' => __( 'Profile ID', 'wc-visanet' ),
        'type' => 'text',
        'default' => '',
      ),
      'merchant_id' => array(
        'title' => __( 'Merchant ID', 'wc-visanet' ),
        'type' => 'text',
        'default' => '',
      ),
      'access_key' => array(
        'title' => __( 'Access Key (llave de acceso)', 'wc-visanet' ),
        'type' => 'password',
        'default' => '',
		
      ),
	  
	 	  
      'secret_key' => array(
        'title' => __( 'Secret Key (llave secreta)', 'wc-visanet' ),
        'type' => 'password',
        'default' => '',
		'autocomplete' => 'off',		
	),
	
      'transaction_key' => array(
        'title' => __( 'Transaction Key (llave para transacciones)', 'wc-visanet' ),
        'type' => 'password',
        'default' => '',
		'autocomplete' => 'off',
      ),
      'currency' => array(
        'title' => __( 'Moneda', 'wc-visanet' ),
        'type' => 'select',
        'options' => array(
          'DOP' => 'DOP',
          'USD' => 'USD',
        ),
        'default' => 'DOP',
      ),
      'payment_form_page' => array(
        'title' => 'Página del formulario de pago',
        'type' => 'select',
        'options' => $pages,
        'default' => $paymentFormPage
      ),
      'auto_authorize' => array(
          'title'   => __( 'Liquidación Automática', 'woocommerce' ),
          'type'    => 'checkbox',
          'label'   => __( 'Sí', 'wc-visanet' ),
          'default' => 'yes'
      ),
    );
  }

  public function process_admin_options() {
    $fieldName = 'woocommerce_visanet_gateway_payment_form_page';

    if (
      isset($_REQUEST[$fieldName])
      && $_REQUEST[$fieldName] === $this->setupPaymentForm
    ) {
      $_REQUEST[$fieldName] = wc_visanet_create_default_payment_form_page();
      $_POST[$fieldName] = $_REQUEST[$fieldName];
    }

    return parent::process_admin_options($args);
  }

  protected function get_payment_form_page() {
    $paymentFormPage = $this->get_option('payment_form_page');

    if (!empty($paymentFormPage)) return $paymentFormPage;

    return wc_visanet_get_default_payment_form_page();
  }

  protected function get_pages() {
    $pages = get_pages(array(
      'sort_order' => 'asc',
      'sort_column' => 'post_title',
      'hierarchical' => 1,
      'post_type' => 'page',
      'post_status' => 'publish'
    ));

    $options = array();
    $options[$this->setupPaymentForm] = '(Crear Formulario de Pago)';

    foreach($pages as $page) {
      $options[ $page->ID ] = $page->post_title;
    }

    return $options;
  }

  function admin_options() {
   ?>
   <h2><?php _e('Tarjeta de Crédito Visa','wc-visanet'); ?></h2>
   <table class="form-table">
     <?php $this->generate_settings_html(); ?>
     <tr valign="top">
       <th scope="row" class="titledesc">
         URL de retorno
       </th>
       <td class="forminp">
         <?php bloginfo('url'); ?>/?wc_visanet_return=1
       </td>
   </table>
   <?php
   }

  public function payment_fields()
  {
    require_once __DIR__ . '/parts/payment-form.php';
  }

  public function process_payment($order_id)
  {
    $pageId = $this->get_option('payment_form_page');
    $page = get_post($pageId);

    if (!$pageId || $page === NULL) {
      wc_add_notice( __('Error en pago con visanet: formulario de pago no definido', 'wc-visanet'), 'error' );
      return;
    }

    $pageUrl = get_permalink($pageId);
    $pageUrl = add_query_arg('wc_visanet_form', $order_id, $pageUrl);

    return array(
      'result' => 'success',
      'redirect' => $pageUrl
    );
  }
  
  
  
  
  
  
}
?>
