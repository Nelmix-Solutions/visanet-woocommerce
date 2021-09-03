<?php

require 'account-configuration.php';

$request = new \VisanetSDK\PaymentRequest();

$request->signFields(
    array(
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
    )
);


?>
<!DOCTYPE html>

<html>
  <head>
    <title>Signed Payment Example</title>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" />
  </head>

  <body>
    <div class="container">
      <h1>Signed Payment Example</h1>

      <form action="<?php echo $request->getActionUrl(); ?>" method="post" class="row">
        <div class="col-md-12">
          <?php $request->printRequestFields(); ?>
          <?php $request->printFingerprintTracker(); ?>
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

        <div class="form-group col-md-12">
          <button type="submit" class="btn btn-primary">Send Payment</button>
        </div>
      </form>
    </div>
  </body>
  </html>
