<?php

function wc_visanet_order_notes_css($classes, $note) {
  $noteType = get_comment_meta($note->comment_ID, '_wc_visanet_note_type', true);

  if ($noteType) {
    $classes[] = "wc-visanet-note-type-{$noteType}";
  }

  return $classes;
}

add_filter('woocommerce_order_note_class', 'wc_visanet_order_notes_css', 10, 2);
