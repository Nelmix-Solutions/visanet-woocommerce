<?php

require 'account-configuration.php';

$request = new \VisanetSDK\PaymentRequest();

$request->signFields(
    array(
      'amount' => 256,
    )
);


?>
<!DOCTYPE html>

<html>
  <head>
    <title>Simple Payment Example</title>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" />
  </head>

  <body>
    <div class="container">
      <h1>Simple Payment Example</h1>

      <form action="<?php echo $request->getActionUrl(); ?>" method="post" class="row">
        <div class="col-md-12">
          <?php $request->printRequestFields(); ?>
          <?php $request->printFingerprintTracker(); ?>
        </div>

        <fieldset class="col-md-4">
          <legend>Personal information</legend>

          <div class="form-group">
            <label for="bill_to_forename">Firstname</label>
            <input name="bill_to_forename" id="bill_to_forename" class="form-control" />
          </div>

          <div class="form-group">
            <label for="bill_to_surname">Lastname</label>
            <input name="bill_to_surname" id="bill_to_surname" class="form-control" />
          </div>

          <div class="form-group">
            <label for="bill_to_email">Email</label>
            <input name="bill_to_email" id="bill_to_email" class="form-control" />
          </div>

          <div class="form-group">
            <label for="bill_to_phone">Phone</label>
            <input name="bill_to_phone" id="bill_to_phone" class="form-control" />
          </div>
        </fieldset>

        <fieldset class="col-md-4">
          <legend>Billing address information</legend>

          <div class="form-group">
            <label for="bill_to_address_country">Country</label>
            <select class="form-control" name="bill_to_address_country" id="bill_to_address_country">
              <option value="DO">Dominican Republic</option>
              <option value="US">United States</option>
            </select>
          </div>

          <div class="form-group">
            <label for="bill_to_address_state">State</label>
            <input name="bill_to_address_state" id="bill_to_address_state" class="form-control" />
          </div>

          <div class="form-group">
            <label for="bill_to_address_city">City</label>
            <input name="bill_to_address_city" id="bill_to_address_city" class="form-control" />
          </div>

          <div class="form-group">
            <label for="bill_to_address_line1">Address line 1</label>
            <input name="bill_to_address_line1" id="bill_to_address_line1" class="form-control" />
          </div>

          <div class="form-group">
            <label for="bill_to_postal_code">Postal Code</label>
            <input name="bill_to_postal_code" id="bill_to_postal_code" class="form-control" />
          </div>

        </fieldset>

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
