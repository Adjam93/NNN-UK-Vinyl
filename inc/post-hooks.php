<?php

//Save band name and title in separate ACF fields via splitting at hyphen
function validate_product_title_with_hyphen( $post_id, $post ) {

    if ( $post->post_type === 'product')  {

        // Get the product title
        $title = $post->post_title;
        $delimiter = ' - ';
        $parts = explode( $delimiter, $title, 2 );
        $first_part = $parts[0];
        $second_part = isset( $parts[1] ) ? $parts[1] : '';

        update_field( 'band_name', $first_part, $post_id );
        update_field( 'record_title', $second_part, $post_id );

    }

}
add_action( 'save_post', 'validate_product_title_with_hyphen', 10, 2 );

//Set min and max price values as options
function update_min_max_price( $post_id, $post, $update, $post_before ) {

    global $wpdb;

    if ( 'product' !== $post->post_type ) {
        return;
    }

    if ( ! in_array( $post->post_status, [ 'publish' ] ) ) {
        //To only process when status is private or publish
        return;
    }

    //The rest of your code goes here
    $results = $wpdb->get_row("
        SELECT 
            MIN(CAST(pm.meta_value AS DECIMAL(10,2))) AS min_price,
            MAX(CAST(pm.meta_value AS DECIMAL(10,2))) AS max_price
        FROM {$wpdb->posts} AS p
        INNER JOIN {$wpdb->postmeta} AS pm 
            ON p.ID = pm.post_id
        INNER JOIN {$wpdb->postmeta} AS stock 
            ON p.ID = stock.post_id
        WHERE p.post_type = 'product'
            AND p.post_status = 'publish'
            AND pm.meta_key = '_price'
            AND pm.meta_value != ''
            AND CAST(pm.meta_value AS DECIMAL(10,2)) > 0
            AND stock.meta_key = '_stock_status'
            AND stock.meta_value = 'instock'
    ");

    if( $results ) {

        if( $results->min_price !== null ) {
            update_option('lowest_product_price', (float) $results->min_price);
        }
        if( $results->max_price !== null ) {
            update_option('highest_product_price', (float) $results->max_price);
        }

    }

}

add_action( 'wp_after_insert_post', 'update_min_max_price', 90, 4 );


// When product is trashed, recalculate min/max prices
function update_lowest_highest_price_on_trash( $post_id ) {

    global $wpdb;

    $post_type = get_post_type($post_id);

    // Only recalc if it's a WooCommerce product
    if ($post_type !== 'product') {
        return;
    }

    // Query min/max for published & in-stock products
    $results = $wpdb->get_row("
        SELECT 
            MIN(CAST(pm.meta_value AS DECIMAL(10,2))) AS min_price,
            MAX(CAST(pm.meta_value AS DECIMAL(10,2))) AS max_price
        FROM {$wpdb->posts} AS p
        INNER JOIN {$wpdb->postmeta} AS pm 
            ON p.ID = pm.post_id
        INNER JOIN {$wpdb->postmeta} AS stock 
            ON p.ID = stock.post_id
        WHERE p.post_type = 'product'
            AND p.post_status = 'publish'
            AND pm.meta_key = '_price'
            AND pm.meta_value != ''
            AND CAST(pm.meta_value AS DECIMAL(10,2)) > 0
            AND stock.meta_key = '_stock_status'
            AND stock.meta_value = 'instock'
    ");

    if( $results ) {

        if( $results->min_price !== null ) {
            update_option( 'lowest_product_price', ( float ) $results->min_price );
        } else {
            update_option( 'lowest_product_price', null ); // fallback if no products
        }

        if( $results->max_price !== null ) {
            update_option( 'highest_product_price', ( float ) $results->max_price );
        } else {
            update_option( 'highest_product_price', null );
        }
        
    }

}

add_action( 'trashed_post', 'update_lowest_highest_price_on_trash' );