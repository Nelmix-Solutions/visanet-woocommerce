<section id="wc-visanet-form">
  <form action="<?php echo $request->getActionUrl(); ?>" method="post" autocomplete="off">
    <?php $request->printRequestFields(); ?>
    <?php $request->printFingerprintTracker(); ?>

    <?php if (isset($_REQUEST['wc_visanet_error'])): ?>
    <div class="wc-visanet-error">
      <p>Estamos teniendo problemas para autorizar su pago para los artículos seleccionados. Verifique o actualice su método de pago. Si su información de pago es correcta, póngase en contacto con su banco para obtener más detalles.</p>
    </div>
    <?php endif; ?>

    <div id="wc-visanet-card-fields">
      <?php include __DIR__ . '/card-fields.php'; ?>
    </div>

   
  </form>
  
  
  
</section>