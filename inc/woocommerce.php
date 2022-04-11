<?php

/**
 * Add WooCommerce support
 */
function nnn_woocommerce_support() {

	add_theme_support( 'woocommerce' );
    add_theme_support( 'wc-product-gallery-lightbox' );
	add_theme_support( 'wc-product-gallery-slider' );

}

add_action( 'after_setup_theme', 'nnn_woocommerce_support' );

/**
 * Theme wrappers
*/
function nnn_wrapper_start() {

    ?>
    <div class="container">
    <main class="page-wrapper" role="main">
    
    <div class="sidebar-wrapper">

    <?php if( is_active_sidebar( 'shop_sidebar' ) && is_shop() || is_active_sidebar( 'shop_sidebar' ) && is_product_category() ) : ?>

        <aside class="shop-sidebar">

            <div class="close">
                <button class="filter-close-btn">Apply Filters</button><button class="filter-close-btn close-x">Close X</button>
            </div>

            <?php dynamic_sidebar( 'shop_sidebar' ); ?>

            <button class="filter-close-btn">Apply Filters</button>

        </aside>
     
    <?php endif; ?>

    <!-- //NEW SIDEBAR MOBILE-ACTIVE-FILTERS
    //SHOW ACTIVE FILTERS ABOVE CONTENT VIA ACTIVE FILTERS WIDGET

    //NEW SIDEBAR MOBILE-FILTERS
    //SHOW FILTERS BUTTON - WHEN CLICKED OPEN UP SAME FILTERS AS DESKTOP BUT IN MODAL WINDOW OVERLAYING PAGE -->

    </div>

    <?php if( is_shop() || is_product_category() ) : ?>

        <button id="mobile-filter-btn"><span>&#43;</span>Product Filters</button>
        <div class="mobile-active-filters"></div>

    <?php endif; ?>

  
        

    <div class="shop-wrapper">

    <?php

}

function nnn_wrapper_end() {

    echo '</div>';
    echo '</main>';
    echo '</div>';

}

remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10 );
remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10 );
add_action( 'woocommerce_before_main_content', 'nnn_wrapper_start', 10 );
add_action( 'woocommerce_after_main_content', 'nnn_wrapper_end', 10 );



/**
 * Change the product description title
 */
function change_product_description_heading() {

    return __( '', 'woocommerce' );

}
add_filter( 'woocommerce_product_description_heading', 'change_product_description_heading' );

/**
* Remove woocommerce sidebar
*/
remove_action( 'woocommerce_sidebar', 'woocommerce_get_sidebar', 10 );

/**
* Change shop page title
*/
function nnn_shop_page_title( $page_title ) {

    if( 'Shop' == $page_title ) {

        return "Browse All Records";
    }

}
add_filter( 'woocommerce_page_title', 'nnn_shop_page_title' );

/**
* Attribute not visible by default
*/
add_filter( 'woocommerce_attribute_default_visibility', '__return_false' );


// Remove the result count from WooCommerce
remove_action( 'woocommerce_before_shop_loop', 'woocommerce_result_count', 20 );



/**
* Add Cart totals to menu and refresh on addition to cart
*/
function nnn_header_add_to_cart_fragment( $fragments ) {

    ob_start();
    ?>

    <a class="cart-contents" href="<?php echo esc_url( wc_get_cart_url() ); ?>" title="<?php esc_attr_e( 'View your shopping cart', 'nnn' ); ?>">
            <?php
                $nnn_cart_count = WC()->cart->cart_contents_count;
                echo sprintf( esc_html( _n( '%d item', '%d items', $nnn_cart_count, 'nnn' ) ), esc_html( $nnn_cart_count ) );
            ?>
        - <?php echo wp_kses_post( WC()->cart->get_cart_total() ); ?></a>
    <?php

    $fragments['a.cart-contents'] = ob_get_clean();

    return $fragments;
}

add_filter( 'woocommerce_add_to_cart_fragments', 'nnn_header_add_to_cart_fragment' );



/**
 * Add cart link to the menu
 */

function nnn_nav_cart( $items, $args ) {

    if ( $args->theme_location == 'primary' ) {

            if ( is_user_logged_in() ) { 

              $items .= '<li><a href="' . get_permalink( get_option("woocommerce_myaccount_page_id") ) . '" title="My Account">My Account</a></li>';

            } 
            else { 

                $items .= '<li><a href="'. get_permalink( get_option('woocommerce_myaccount_page_id') ) .'" title="Login/Register">Login/Register</a></li>';
            }
            
            $items .= '<li class="nav-cart"><i class="fa fa-shopping-cart"></i><a class="cart-contents" href="' . wc_get_cart_url() . '" title="' . __( 'View your shopping cart', 'nnn' ) . '">' . sprintf( _n( '%d item', '%d items', WC()->cart->cart_contents_count, 'nnn' ), WC()->cart->cart_contents_count ) . ' - ' . WC()->cart->get_cart_total() . '</a></li>';
           
    }
    
    return $items;
}

add_filter( 'wp_nav_menu_items', 'nnn_nav_cart', 10, 2 );


// Only show products in the front-end search results

function nnn_search_filter_pages( $query ) {

    // Frontend search only
    if ( ! is_admin() && $query->is_search() ) {

        $query->set( 'post_type', 'product' );
        $query->set( 'wc_query', 'product_query');
    }

    return $query;

}

add_filter( 'pre_get_posts', 'nnn_search_filter_pages' );


/**
 * Remove below templates - replaced with custom markup in "content-single-product.php"
 */
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_title', 5 );
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_price', 10 );
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_excerpt', 20 );
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 30 );
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40 );

/** 
* Remove "in stock" text form single products 
*/
function remove_in_stock_text_form_single_products( $html, $text, $product ) {

    $availability = $product->get_availability();

    if ( isset( $availability['class'] ) && 'in-stock' === $availability['class'] ) {

        return '';

    }

    return $html;

}

add_filter( 'woocommerce_stock_html', 'remove_in_stock_text_form_single_products', 10, 3 );
