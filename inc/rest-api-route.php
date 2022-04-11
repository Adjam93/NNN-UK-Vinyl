<?php

//Add featured image as a custom rest field (img_url) to custom post type (in this case - movie) when returning results from the API
/*function register_rest_images() {

  register_rest_field( array( 'movie' ),
      'img_url',
      array(
          'get_callback'    => 'get_rest_featured_image',
          'update_callback' => null,
          'schema'          => null,
      )
  );

}

function get_rest_featured_image( $object, $field_name, $request ) {

  if( $object['featured_media'] ){

      $img = wp_get_attachment_image_src( $object['featured_media'], 'app-thumb' );
      return $img[0];

  }

  return false;
  
}

add_action( 'rest_api_init', 'register_rest_images' );
*/





//Add custom rest API route in order to search custom post type (movies) with only the data needed to display each one on the front-end
function recordRegisterRoutes() {

  register_rest_route( 'product/v1', 'search', array(
    'methods' => WP_REST_SERVER::READABLE,
    'callback' => 'recordSearchResults'
  ) );

  register_rest_route( 'product/v1', 'category', array(
    'methods' => WP_REST_SERVER::READABLE,
    'callback' => 'recordCategoryResults'
  ) );

}
/*
function support_search_term_query_var( $query, $query_vars ) {

  if( empty( $query_vars['search_term'] ) ) {

      return $query;

  }

  $query['s'] = $query_vars['search_term'];

  return $query;

}
add_filter( 'woocommerce_product_data_store_cpt_get_products_query', 'support_search_term_query_var', 10, 2 );
*/


function recordSearchResults( $data ) {

  $args = array(

      'limit'  => 3,
      'status' => 'publish',
      's' => sanitize_text_field( $data['term'] ),
      
  );
  
  $products = wc_get_products( $args );

  $results = array(

    'recordInfo' => array(),

  );

  if ( ! empty( $products ) ) {

    foreach ( $products as $product ) {

        array_push( $results['recordInfo'], array(

          'title' => $product->name,
          'permalink' => site_url() . "/" . $product->slug,
          'image' => wp_get_attachment_image_src( $product->image_id, 'full' )[0],
          'category' => get_term( $product->category_ids[0] )->name,
          "category_desc" => category_description( $product->category_ids[0] ), 
          //'category_link' => site_url() . "/" . "product-category" . "/" . get_term( $product->category_ids[0] )->slug,
          'category_id' => $product->category_ids[0],
          'description' => wp_strip_all_tags( wp_trim_words( $product->description, 30 ) ),
          'price' => $product->price

        ) );

    }

  }


  /*

  $mainQuery = new WP_Query( 
      array(
        'post_type' => array( 'product' ),
        's' => sanitize_text_field( $data['term'] ),
        'posts_per_page' => -1,
      )
  );

  $results = array(

    'recordInfo' => array(),

  );

  while( $mainQuery->have_posts() ) { 

    $mainQuery->the_post();

    if ( get_post_type() == 'product' ) {

      array_push( $results['recordInfo'], array(

        'title' => get_the_title(),
        'permalink' => get_the_permalink(),
        'postType' => get_post_type(),
        'image' => get_the_post_thumbnail_url( 0, 'full' ),
        'category' => get_the_category(),
        'description' => wp_strip_all_tags( wp_trim_words( get_the_excerpt(), 30 ) ),
        'price' => get_post_meta( get_the_ID(), '_price', true )

      ) );

    }

  }*/

  return $results;

}




/**
 * FROM RESULTS OF BELOW REQUEST:
 * http://nnn-uk-vinyl.local/wp-json/product/v1/category?cat_slug=alternative
 * IN JAVASCRIPT GET FIRST ELEMENT IN RESULT ARRAY AND EXTRACT category_desc TO DISPLAY THE DESCRIPTION ONCE
 * THEN USE MAP TO DISPLAY THE 3 LATEST RETRIEVED RECORDS FOR THAT CATEGORY
 * LASTLY ADD A VIEW ALL BUTTON WITH A LINK USING THE SLUG THAT WAS USED IN THE SEARCH


*/

function recordCategoryResults( $data ) {

  $args = array(

      'limit'  => 6,
      'status' => 'publish',
      'category' => array ( sanitize_text_field( $data['cat_slug'] ) ),

  );
  
  $products = wc_get_products( $args );

  $results = array(

    'recordInfo' => array(),

  );

  if ( ! empty( $products ) ) {

    foreach ( $products as $product ) {

        $category_info = get_term_by( 'slug', sanitize_text_field( $data['cat_slug'] ), 'product_cat' );

        array_push( $results['recordInfo'], array(

          'title' => $product->name,
          'permalink' => site_url() . "/" . $product->slug,
          'image' => wp_get_attachment_image_src( $product->image_id, 'full' )[0],
          'product_description' => wp_strip_all_tags( wp_trim_words( $product->description, 30 ) ),
          'category_id' => $category_info->term_id,
          'category' => $category_info->name,
          'category_desc' => $category_info->description,
          'category_link' => site_url() . "/" . "product-category" . "/" . $category_info->slug,
         // 'category_info' => get_term_by( 'slug', sanitize_text_field( $data['cat_slug'] ), 'product_cat' )


        ) );

    }

  }


  return $results;

}

add_action( 'rest_api_init', 'recordRegisterRoutes' );