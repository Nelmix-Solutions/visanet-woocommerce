

<img style="float:right;box-shadow:none;" width="150px" height="100px" src="<?php echo plugins_url(); ?>/visanet-woocommerce/images/visanet-logo.png" alt="Visanet" />
<div class="clear"></div>

<input type="hidden" name="card_type" id="card_type" value="001" />

<p id="card_number_field" class="form-row">
  <input type="hidden" name="card_number" id="card_number" />

  <label for="card_number">
   <i class="fa  fa-credit-card"></i> <?php _e('Detalle del pago', 'wc-visanet'); ?>
  </label>
  </br>
<input type="text" class="input-text" id="card_number_mask" placeholder="Numero de tarjeta" value="" minlength="16" maxlength="24" required />
</p>

<p id="card_expiry_date_field" class="form-row">
  <input type="hidden" name="card_expiry_date" id="card_expiry_date" />

  <label for="card_expiry_month">
    <i class="fa fa-calendar"></i> <?php _e('Fecha Vencimiento', 'wc-visanet'); ?>
  </label>

  <select id="card_expiry_month" class="select-input">
    <?php foreach(wc_visanet_get_months() as $i => $month): ?>
      <option value="<?php echo $i + 1; ?>">
        <?php echo $month; ?>
      </option>
    <?php endforeach; ?>
  </select>

  <input type="number" class="input-text" id="card_expiry_year" min="<?php echo date('Y'); ?>" max="<?php echo date('Y') + 20; ?>" placeholder="YYYY" required />
</p>


<p id="card_cvn_field" class="form-row">
<label for="card_cvn">
  <i class="fa  fa-lock"></i>  <?php _e('Código verificación', 'wc-visanet'); ?>
  </label>

  <input type="text" class="input-text" name="card_cvn" id="card_cvn" placeholder="CVV / CVN" required maxlength="3" />
      </p>
<div class="dropdown">
<i class="fa fa-question-circle"></i> 
  <div class="dropdown-content">
 <img style="float:top;box-shadow:none;" width="300px" height="200px" src="<?php echo plugins_url(); ?>/visanet-woocommerce/images/cvv1.png" alt="Visanet" />
  </div>
</div>
<div class="clear"></div>
		
<div>
<button class="vnet-button" type="submit" style="color: white">
<?php _e('Confirmar y Pagar', 'wc-visanet'); ?>
</button>
</div>
</br>
		<div class="form-row" align="justify">
		<img style="float:left;box-shadow:none;" width="100px" height="50px" src="<?php echo plugins_url(); ?>/visanet-woocommerce/images/lock.png" alt="Visanet" /><p>Este website utiliza la seguridad de <a href="https://www.cybersource.com/es-LAC/products/payment_security/" target="_blank"><strong>CyberSource Inc.</strong></a>para procesar el pago forma segura y proteger sus datos. Tecnología distribuida  por VisaNet. Si detecta una anomalía puede reportarlo en el 809-947-5500</p>
		</div>
		

