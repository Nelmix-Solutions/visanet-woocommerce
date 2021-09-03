<?php

function wc_visanet_add_query_vars( $query_vars ) {
    $query_vars[] = 'wc_visanet_form';
    $query_vars[] = 'wc_visanet_return';
    $query_vars[] = 'wc_visanet_error';

    return $query_vars;
}

add_filter( 'query_vars', 'wc_visanet_add_query_vars' );
