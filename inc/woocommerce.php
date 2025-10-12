<?php

/**
 * Add WooCommerce support
 */
function nnn_woocommerce_support() {

	add_theme_support( 'woocommerce' );

}

add_action( 'after_setup_theme', 'nnn_woocommerce_support' );


function change_shipping_text_to_delivery( $sprintf, $i, $package ) {

    $sprintf = sprintf( _nx( 'Delivery', 'Delivery %d', ( $i + 1 ), 'delivery packages', 'woocommerce' ), ( $i + 1 ) );
    return $sprintf;

}

add_filter( 'woocommerce_shipping_package_name', 'change_shipping_text_to_delivery', 20, 3 );
