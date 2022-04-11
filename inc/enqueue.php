<?php

function nnn_scripts(){

  //Main css file with filemtime (to reload cache)
  wp_enqueue_style( 'style', get_stylesheet_directory_uri() . '/style.css', array(), filemtime( get_stylesheet_directory() . '/style.css' ) );
  wp_enqueue_script( 'bundled', get_template_directory_uri() . '/dist/bundled.js', array(), '1.0', true );
     
  $search_vars = array(

    'root_url' => site_url(),

  );

  wp_add_inline_script( 'bundled', 'var search_vars = ' . wp_json_encode( $search_vars ), 'before' );

  /*Example of localize script - to pass php values as an array of objects to be used in the associated javascript file
  
    E.g. - ajax-load-more is the handle of the associate js file
    - art_ajax_load is the callable object e.g. art_ajax_load.admin_url gets the admin url + admin-ajax.php, for use in example of making an ajax request in the assoicated js file


    wp_localize_script example:

    wp_enqueue_script( 'ajax-load-more', get_template_directory_uri() . '/assets/js/artwork-load-more.js', array( 'jquery' ), '1.0', true );
    wp_localize_script( 'ajax-load-more', 'art_ajax_load', array(
      'admin_url' => admin_url( 'admin-ajax.php' ),
      'security' => wp_create_nonce( 'art-loadmore' )
    ) );


    wp_add_inline_script example:
    
    $slider_vars = array(

      'homeURL' => home_url(),
      'blockAttributes' => $attributes,
      'numberOfSlides' => $numberOfSlides

    );

    wp_enqueue_script( 'attentionFrontend', plugin_dir_url( __FILE__ ) . 'build/block-slider-frontend.js', [ 'jquery' ] );
    wp_add_inline_script( 'attentionFrontend', 'var slider_vars = ' . wp_json_encode( $slider_vars ), 'before' );

  */

}

add_action( 'wp_enqueue_scripts', 'nnn_scripts' );