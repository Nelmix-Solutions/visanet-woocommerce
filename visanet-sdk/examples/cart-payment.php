<?php

require_once './account-configuration.php';


$request = new \VisanetSDK\PaymentRequest();

$request->signFields(
    array(
      'bill_to_forename' => 'Jon',
      'bill_to_surname' => 'Snow',
      'bill_to_email' => 'j.snow@example.com',
      'bill_to_phone' => '809-999-9999',
      'bill_to_address_line1' => 'Kings Landing Road',
      'bill_to_address_city' => 'Santo Domingo',
      'bill_to_address_state' => 'Santo Domingo',
      'bill_to_address_country' => 'DO',
      'bill_to_address_postal_code' => '00000',
    )
);

$colors = array('#f3b88d', '#cfb8c3', '#e7de94');

$quantity0 = $_REQUEST['item-0-quantity'];
$quantity1 = $_REQUEST['item-1-quantity'];
$quantity2 = $_REQUEST['item-2-quantity'];

$sampleCartItems = array(
    array(
      'name' => 'Small T-Shirt',
      'quantity' => $quantity0 ? $quantity0 : 3,
      'price' => 22.6,
      'tax' => 1.8,
    ),
    array(
      'name' => 'Cargo Pants',
      'quantity' => $quantity1 ? $quantity1 : 2,
      'price' => 119.9,
      'tax' => 12.0,
    ),
    array(
      'name' => 'Sport Sox',
      'quantity' => $quantity2 ? $quantity2 : 4,
      'price' => 2,
      'tax' => 0.3,
    ),
);

?>
<!DOCTYPE html>

<html>
  <head>
    <title>Simple Payment Example</title>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" />
    <style>
      .cart-item .image {
        width: 100%;
        height: 200px;
      }

      .clear {
        clear: both;
      }
    </style>
  </head>

  <body>
    <div class="container">
      <h1>Cart Payment Example</h1>

      <form action="" method="get">
        <div id="cart-items" class="row">
          <?php
            foreach ($sampleCartItems as $i => $item):
              $color = $colors[$i];

              $request->addItem($item);
          ?>
            <article class="cart-item col-md-4">
              <div class="image" style="background-color:<?php echo $color; ?>"></div>
              <div class="fields row">
                <h4 class="col-md-5"><?php echo $item['name']; ?></h4>
                <h3 class="col-md-4">$<?php echo $item['price']; ?></h3>
                <div class="col-md-3">
                  <input class="form-control" type="number" name="item-<?php echo $i; ?>-quantity" value="<?php echo $item['quantity']; ?>" />
                </div>
            </article>
          <?php endforeach; ?>
        </div>

        <br />
        <div class="col-md-4 col-md-offset-4 text-center">
          <button class="btn btn-default btn-lg">
            Update Cart Quantities
          </button>
        </div>
      </form>

      <br class="clear" />
      <hr class="clear" />

      <form action="<?php echo $request->getActionUrl(); ?>" method="post" class="row">

        <div class="col-md-12">
          <?php $request->printRequestFields(); ?>
          <?php $request->printFingerprintTracker(); ?>
        </div>

        <div class="col-md-8">
          <h1>Total:</h1>
          <span>$<?php echo number_format($request->getAmount(), 2); ?></span>
        </div>

        <fieldset class="col-md-4">
          <legend>Card Details</legend>

          <div class="form-group">
            <label for="card_number">Card Number</label>
            <input name="card_number" id="card_number" value="4111111111111111" class="form-control" />
          </div>

          <div class="form-group">
            <label for="card_expiry_date">Expiration Date</label>
            <input name="card_expiry_date" id="card_expiry_date" class="form-control" placeholder="MM-YYYY" value="12-2022" />
          </div>

          <div class="form-group">
            <label for="card_cvn">CVN</label>
            <input name="card_cvn" id="card_cvn" class="form-control" value="123" />
          </div>
        </fieldset>

        <div class="form-group col-md-4 col-md-offset-8">
          <button type="submit" class="btn btn-success">Send Payment</button>
        </div>
      </form>
    </div>
  </body>
  </html>
