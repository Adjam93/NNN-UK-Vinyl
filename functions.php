<?php 

$includes = array(

    '/enqueue.php',  // Enqueue scripts and styles.
    '/theme-setup.php', //Theme support and setup
    '/rest-api-route.php', //Custom REST API endpoint for searching through products
    '/woocommerce.php', //WooCommerce custom functions
);
  
foreach ( $includes as $include ) {

    require_once get_template_directory() . '/inc' . $include;

}