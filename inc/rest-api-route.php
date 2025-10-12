<?php

//Add custom rest API route in order to search products and create custom shop page with only the data needed to display each one on the front-end
function recordRegisterRoutes() {

  register_rest_route( 'product/v1', 'products', array(
    'methods' => WP_REST_SERVER::READABLE,
    'callback' => 'recordResults'
  ) );

}

function handle_price_range_query_var( $query, $query_vars ) {

    if ( isset( $query_vars['min-price'] ) || isset( $query_vars['max-price'] ) ) {

      $min = isset( $query_vars['min-price'] ) ? floatval( $query_vars['min-price'] ) : 0;
      $max = isset( $query_vars['max-price'] ) ? floatval( $query_vars['max-price'] ) : PHP_INT_MAX;

      $query['meta_query'][] = array(
        'key'     => '_price',
        'value'   => array( $min, $max ),
        'compare' => 'BETWEEN',
        'type'    =>  'DECIMAL(10,2)'
      );

    }

    return $query;

}

add_filter( 'woocommerce_product_data_store_cpt_get_products_query', 'handle_price_range_query_var', 10, 2 );

function recordResults( $data ) {

  global $wpdb;
  
  $sort_by = $data->get_param( 'sort_by' );
  $min_price = $data->get_param( 'min-price' );
  $max_price = $data->get_param( 'max-price' );
  $genres = $data->get_param( 'genre' );
  $attributes = $data->get_param( 'attributes' );
  $search = $data->get_param( 'search_query' );
  $per_page = $data->get_param( 'per_page' );
  
  //Ensure price is numeric
  if( $min_price !== null && ! is_numeric( $min_price ) ) {

    //return new WP_Error( 'invalid_min_price', 'Min price must be a number.', array( 'status' => 400, 'code' => 'min_price_not_a_number' ) );
    return new WP_Error(
      'invalid_min_price',
      'Min price must be a number',
      array(
          'status' => 400,
          'error_type' => 'validation',
          'field' => 'min-price',
          'code' => 'min_price_must_be_a_number',
          'message' => 'Price must be a valid number'
      ) );

  }

  if( $max_price !== null && ! is_numeric( $max_price ) ) {

     return new WP_Error(
      'invalid_min_price',
      'Max price must be a number',
      array(
          'status' => 400,
          'error_type' => 'validation',
          'field' => 'max-price',
          'code' => 'max_price_must_be_a_number',
          'message' => 'Price must be a valid number'
      ) );

  }

  //Cast to floats
  $min_price = $min_price !== null ? floatval( $min_price ) : 0;
  $max_price = $max_price !== null ? floatval( $max_price ) : PHP_INT_MAX;

  if( $max_price < $min_price ) {

    return new WP_Error(
      'invalid_price_range',
      'Max price must be greater',
      array(
          'status' => 400,
          'error_type' => 'validation',
          'field' => 'price-range',
          'code' => 'max_price_must_be_greater',
          'message' => 'Max. price must be greater than Min. price'
      ) );

  }


  $args = array(

    'limit'  => $per_page ? $per_page : 12,
    'status' => 'publish',
    'stock_status' => 'instock',
    'paginate' => true,
    'page' => ( $data->get_param( 'page' ) ? $data->get_param( 'page' ) : 1 ),
    's' => sanitize_text_field( $search ),
    'min-price' => $min_price,
    'max-price' => $max_price,

  );
  
  if ( !empty( $sort_by ) ) {

    switch ( $sort_by ) {

      case 'price-low-to-high':

        $args['orderby'] = 'meta_value_num';
        $args['order'] = 'ASC';
        $args['meta_key'] = '_price';

        break;

      case 'price-high-to-low':

        $args['orderby'] = 'meta_value_num';
        $args['order'] = 'DESC';
        $args['meta_key'] = '_price';

        break;

      case 'latest':

        $args['orderby'] = 'date';
        $args['order'] = 'DESC';

        break;

      case 'band-asc':

        $args['meta_key'] = 'band_name';
        $args['orderby'] = 'meta_value';
        $args['order'] = 'ASC';

        break;

      case 'band-desc':

        $args['meta_key'] = 'band_name';
        $args['orderby'] = 'meta_value';
        $args['order'] = 'DESC';

        break;

      case 'title-asc':

        $args['meta_key'] = 'record_title';
        $args['orderby'] = 'meta_value';
        $args['order'] = 'ASC';

        break;

      case 'title-desc':

        $args['meta_key'] = 'record_title';
        $args['orderby'] = 'meta_value';
        $args['order'] = 'DESC';

        break;

    }

  }

  if ( !empty( $genres ) ) {

    $genre_array = explode(',', $genres);
    $args['category'] = $genre_array;

  }

  if ( !empty( $attributes ) ) {

    foreach ( $attributes as $key => $attribute ) {

      $get_attributes = explode( ',', $attribute );

      $tax_query[] = array(
          'taxonomy' => 'pa_' . $key,
          'field'    => 'slug',
          'terms'    => $get_attributes,
          'operator' => 'IN',
      );

    }

    if ( !empty( $tax_query ) ) {

        $tax_query['relation'] = 'AND';
        $args['tax_query'] = $tax_query;

    }
    
  }
  
  $products = wc_get_products( $args );

  $results = array(

    'recordsInfo' => array(),
    'totalRecords' => '',
    'totalPages' => '',
    'lowest_price' => get_option( 'lowest_product_price' ),
    'highest_price' => get_option( 'highest_product_price' )

  );


  if ( ! empty( $products ) ) {

    //Calculate a starting index for each paginated set of results, in order to set a position order for each post 
    $paged = ( $data->get_param('page') ? $data->get_param('page') : 1 );
    $posts_per_page = 3;
    $start_position = ( $paged - 1 ) * $posts_per_page;
    $position = 0;

    foreach ( $products->products as $product ) {

        $discogs_data = get_post_meta( $product->get_id(), 'discogs_data_discogs_data', true );
        $record_meta = '';
        if( $discogs_data ) {

          $record_meta = json_decode( $discogs_data, true );

        }

        $position++;

        array_push( $results['recordsInfo'], array(

          'product_id' => $product->get_id(),
          'title' => $product->name,
          'band_name' => get_post_meta( $product->get_id(), 'band_name', true ),
          'record_name' => get_post_meta( $product->get_id(), 'record_title', true ),
          'permalink' => site_url() . "/" . $product->slug,
          'image' => wp_get_attachment_image_src( $product->image_id, 'full' )[0],
          'product_description' => wp_strip_all_tags( wp_trim_words( $product->description, 30 ) ),
          'price' => $product->price,
          'label' => $record_meta['labels'][0]['name'] ?? '',
          'catno' => $record_meta['labels'][0]['catno'] ?? '',
          'country' =>$record_meta['country'] ?? '',
          'release_date' => $record_meta['release_date'] ?? '',
          'position' => $start_position + $position, 

        ) );

    }

    $results['totalRecords'] = $products->total;
    $results['totalPages'] = $products->max_num_pages;

  }


  return $results;

}

add_action( 'rest_api_init', 'recordRegisterRoutes' );