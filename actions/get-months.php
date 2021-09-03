<?php

function wc_visanet_get_months() {
  $months = array();
  $date = strtotime('2010-01-01');

  for($i = 1; $i <= 12; $i++) {
    $months[] = date_i18n('F', $date);
    $date = strtotime('+1 month', $date);
  }

  return $months;
}
