# Visanet PHP SDK

## Configuración

```PHP
<?php
Account::configure(array(
  'profile_id' => '[PROVISTO_POR_VISANET]',
  'merchant_id' => '[PROVISTO_POR_VISANET]',
  'access_key' => '[PROVISTO_POR_VISANET]',
  'secret_key' => '[PROVISTO_POR_VISANET]',
  'transaction_key' => '[PROVISTO_POR_VISANET]',
  'currency' => 'DOP',
));
?>
```

## Modo de prueba

```PHP
<?php
Account::testingModeOn();
?>
```

## Preparando los campos a enviar

La librería cuenta con una clase **PaymentRequest** que se encarga de preparar los datos a enviar para el procesamiento de pago. La clase se puede inicializar de la siguiente manera:

```PHP
<?php
$request = new \VisanetSDK\PaymentRequest();
?>
```

### Firmando los campos

Si desea firmar algún campo puede utilizar el método **signFields** cuantas veces necesite. El método acepta un arreglo con los campos definidos en la documentación provista por Visanet. Ej.:

```PHP
<?php
$request->signFields(array(
  'amount' => 256,
  'bill_to_forename' => 'Jon',
  'bill_to_surname' => 'Snow',
  'bill_to_email' => 'j.snow@example.com',
  'bill_to_phone' => '809-999-9999',
  'bill_to_address_line1' => 'Kings Landing Road',
  'bill_to_address_city' => 'Santo Domingo',
  'bill_to_address_state' => 'Santo Domingo',
  'bill_to_address_country' => 'DO',
  'bill_to_address_postal_code' => '00000',
));
?>
```

* Nota: los nombres de los campos deben de corresponder a los nombres definidos en la documentación provista por Visanet.

### Tabla de conversión de MDD

Para mayor facilidad, el SDK renombra de una manera amigable los campos *merchant_defined_data*. A continuaciación la tabla de conversión:

* merchant_defined_data1: vertical
* merchant_defined_data2: merchant_id
* merchant_defined_data3: conection_type
* merchant_defined_data4: client_identification_number
* merchant_defined_data5: email
* merchant_defined_data6: sku
* merchant_defined_data7: user_type
* merchant_defined_data8: account_registration_date
* merchant_defined_data9: number_of_previous_transactions
* merchant_defined_data10: last_transaction_date
* merchant_defined_data11: retail_store_number
* merchant_defined_data12: address_type

### Proceso de autorización

Por defecto la librería auto liquida el monto requerido, pero si desea, puede ejecutar una autorización. Las autorizaciones reservan el monto que luego será cargado a la tarjeta (ej.: al entregar el producto). El nombre del campo a enviar es **transaction_type** y el valor es igual a **authorization**. Ej.:

```PHP
<?php
$request->signFields(array(
  'transaction_type' => 'authorization'
));
?>
```

A la hora de procesar el pago (detallado más adelante) debe de almacenar el campo **transaction_id** el cual debe de ser enviado para liquidar o cancelar la transacción.

### Agregando productos al carrito

Si desea agregar los detalles del carrito a la transacción puede utilizar el método **addItem**. En caso de agregar un producto de esta manera el cálculo del campo **amount** se hará automático. Ej.:

```PHP
<?php
$request->additem(array(
  'sku' => '123123123',
  'name' => 'Nombre del producto',
  'quantity' => 3,
  'price' => 100,
  'tax' => 18
));
?>
```

### Agregar descuento

Para agregar un descuento o código de promoción solo debe de usar el método **addDiscount**:

```PHP
<?php
$request->addDiscount(array(
  'name' => 'PROMO_CODE_123',
  'price' => 30,
  'tax' => 5
));
```

* Nota: el descuento debe de ser final, no porcentual.

### Agregar envío (shipping)

Para agregar un detalle de envío puede usar el método **addShipping**:

```PHP
<?php
$request->addShipping(array(
  'price' => 80,
  'tax' => 10
));
?>
```

### Formulario de captura de tarjeta

Cuando esté conforme con la configuración de pasos debe pasar a preparar el formulario de envío de datos de la tarjeta.

**Paso 1:** Colocar la etiqueta *form* con el atributo *action* apuntando a la URL de procesamiento de pago:

```PHP
<form action="<?php echo $request->getActionUrl(); ?>" method="post" class="row">
```
* Nota: recuerde cerrar la etiqueta *form*.

**Paso 2:** Imprima los campos firmados y huella digital dentro de la etiqueta *form*:

```PHP
<?php $request->printRequestFields(); ?>
<?php $request->printFingerprintTracker(); ?>
```

**Paso 3:** Agregue los campos restantes (nombre, dirección, etc), y los campos de la tarjeta:

```PHP
<div class="form-group">
  <label for="card_number">Card Number</label>
  <input name="card_number" id="card_number" class="form-control" />
</div>

<div class="form-group">
  <label for="card_expiry_date">Expiration Date</label>
  <input name="card_expiry_date" id="card_expiry_date" class="form-control" placeholder="MM-YYYY" />
</div>

<div class="form-group">
  <label for="card_cvn">CVN</label>
  <input name="card_cvn" id="card_cvn" class="form-control" />
</div>

```

## Procesando la respuesta de aprovación o declinación

Para procesar la transacción debe de utilizar la clase **PaymentResponse** en la URL de retorno configurada en su manejador de decisiones (Visanet puede ayudar a configurar esta URL).

La clase **paymentResponse** contiene un método estático llamado **process** que determina si la transacción fue exitosa o tuvo problemas. Este método debe de ejecutarse en un bloque *try/catch* donde el catch solo se ejecuta en caso de que la transacción tuvo problemas. Ej.:

```PHP
<?php
try {
  $response = \VisanetSDK\PaymentResponse::process();
  //éxito
} catch(\Exception $error) {
  //error
}
?>
```

En caso de éxito, **process** retornará un arreglo con los detalles de la transacción. El campo más importante es **transaction_id** el cual puede ser utilizado como referencia para liquidar o cancelar una transacción previamente autorizada.

En caso de error, la excepción tendrá información que puede ayudar a determinar el error ocurrido. Debe de referirse a la tabla de errores provista en la documentación de Visanet para determinar el error ocurrido y la mejor forma de comunicarlo a sus usuarios.

## Liquidación y cancelación de una autorización

En caso de que haya autorizado un monto y haya guardado el **transaction_id** puede utilizar la clase **PaymentAuthorizationRequest** y **RevertPaymentRequest**.

### Liquidando una autorización

```PHP
<?php
try {
  $request = new \VisanetSDK\PaymentAuthorizationRequest();

  $response = $request->authorize(
    $transactionId, //id de la transacción
    $total, //total autorizado en la transacción original
    $orderId, //id de la orden autorizada
    session_id() //id único de sesión
  );

  //$response tiene los datos de la transacción de liquidación
} catch(\VisanetSDK\SoapTransactionError $error) {
  //$error tiene los datos del error ocurrido
}
?>
```

### Cancelación de la autorización


```PHP
<?php
try {
  $request = new \VisanetSDK\RevertPaymentRequest();

  $response = $request->revert(
    $transactionId, //id de la transacción
    $total, //total autorizado en la transacción original
    $orderId, //id de la orden autorizada
    session_id() //id único de sesión
  );

  //$response tiene los datos de la transacción de cancelación
} catch(\VisanetSDK\SoapTransactionError $error) {
  //$error tiene los datos del error ocurrido
}
?>
```

## Ejemplos

* [Formulario con campos sin firmar](examples/simple-payment.php)
* [Formulario con campos firmados](examples/signed-payment.php)
* [Carrito de compras](examples/cart-payment.php)
* [Recibo y confirmación](examples/receipt.php)
