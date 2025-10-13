<!DOCTYPE html>

<html <?php language_attributes(); ?>>

<head>

    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&family=Roboto&display=swap" rel="stylesheet">

    <?php wp_head(); ?>

    <?php 
        $url_search = isset($_GET['search_query']) ? $_GET['search_query'] : '';
        $basket_total = WC()->cart->get_cart_contents_count(); 
    ?>
                 
</head>

<body <?php body_class(); ?> >
 
<div class="overlay"></div>

<header>

    <div class="header-overlay"></div>
    
    <div class="container">

        <div class="header-container">

            <div class="header-items-wrapper">

                <button class="nav-menu-burger" title="Open Site Menu" aria-label="Open Site Menu" aria-expanded="false" aria-controls="mobile-menu-categories">
                    <span class="top-line">
                        <span class="top-line-left menu-line"></span>
                        <span class="top-line-right menu-line"></span>
                    </span>
                    <span class="middle-line menu-line"></span>
                    <span class="bottom-line">
                        <span class="bottom-line-left menu-line"></span>
                        <span class="bottom-line-right menu-line"></span>
                    </span>
                </button>

                <div class="logo">
                    <a href="<?php echo home_url( ) ?>">
                        <img src="<?php echo get_template_directory_uri() . '/images/nnn-logo.png' ?>" />
                    </a>
                </div>

                <div class="nav-wrapper">
                    <nav class="main-nav">
                        <?php
                            wp_nav_menu( array(
                                'menu'              => 'primary',
                                'theme_location'    => 'primary',
                                'depth'             => 3,
                            ));
                        ?>
                    </nav>
                </div>

                <div class="menu-buttons">

                    <button class="nav-button basket-btn">
                        <?= file_get_contents( get_template_directory_uri() . '/images/svg/cart.svg' ) ?>
                        <span class="nav-basket-counter"></span>
                    </button>

                    <div class="account-search">
                        <a class="nav-button account" href="<?= get_permalink( get_option('woocommerce_myaccount_page_id') ) ?>" title="Login/Register">
                            <?= file_get_contents( get_template_directory_uri() . '/images/svg/person.svg' ) ?>
                        </a>
                        <button class="nav-button open-search-btn">
                            <?= file_get_contents( get_template_directory_uri() . '/images/svg/search.svg' ) ?>
                        </button>
                    </div>
                
                </div>
            
                <div class="mobile-menu">
                    <?php
                        wp_nav_menu( array(
                            'menu' => 'primary',
                            'theme_location' => 'primary',
                            'depth' => 3,
                        ));
                    ?>
                </div>

            </div>
        
            <div class="record-search">

                <div class="search-wrapper">

                    <label class="record-search-label <?= $url_search ? 'd-none' : '' ?>" for="records-search-input">Search records<span class="d-none d-440-inline">, tapes, CDs and more...</span></label>
                    <input type="text" autocomplete="off" id="records-search-input" name="search_query" value="<?= $url_search ? $url_search : '' ?>">
                    <div class="search-button-wrapper">
                        <button class="search-button" aria-label="Submit search">
                            <span class="search-glass">
                                <?= file_get_contents( get_template_directory_uri() . '/images/svg/search.svg' ) ?>
                            </span>
                        </button>
                    </div>
                    <button class="close-search"><?= file_get_contents( get_template_directory_uri() . '/images/svg/close-cross.svg' ) ?></button>
                    
                    <div class="header-search-results">

                    <div class="search-placeholder">Please enter 3 or more characters to start a search</div>


                        <div class="header-results-container">

                            <div class="page-results">
                                <h2 class="fs-medium">Pages</h2>
                                <hr>
                                <div class="skeleton-wrapper">
                                    <div class="skeleton-loader">
                                        <div class="d-grid gap-050">
                                            <span class="skeleton" style="--height: 20px"></span>
                                            <span class="skeleton" style="--height: 20px"></span>
                                        </div>
                                    </div>
                                </div>

                                <div class="page-results-container"></div>
                            </div>

                            <div class="product-results">
                                <h2 class="fs-medium">Products</h2>
                                <hr>

                                <div class="skeleton-wrapper">
                                    <div class="skeleton-loader d-grid product-tile-list gap-1">
                                        <div class="skeleton-col padding-1 rounded-border-10">
                                            <span class="skeleton rounded-border-5" style="--height: 100%"></span>
                                            <div class="d-grid gap-050">
                                                <span class="skeleton" style="--height: 30px; --width: 100px"></span>
                                                <span class="skeleton" style="--height: 30px; --width: 100%"></span>
                                                <span class="skeleton" style="--height: 30px; --width: 75px"></span>
                                            </div>
                                        </div>
                                        <div class="skeleton-col padding-1 rounded-border-10 d-none-important d-768-block-important">
                                            <span class="skeleton rounded-border-5" style="--height: 100%"></span>
                                            <div class="d-grid gap-050">
                                                <span class="skeleton" style="--height: 30px; --width: 100px"></span>
                                                <span class="skeleton" style="--height: 30px; --width: 100%"></span>
                                                <span class="skeleton" style="--height: 30px; --width: 75px"></span>
                                            </div>
                                        </div>
                                        <div class="skeleton-col padding-1 rounded-border-10 d-none-important d-992-block-important">
                                            <span class="skeleton rounded-border-5" style="--height: 100%"></span>
                                            <div class="d-grid gap-050">
                                                <span class="skeleton" style="--height: 30px; --width: 100px"></span>
                                                <span class="skeleton" style="--height: 30px; --width: 100%"></span>
                                                <span class="skeleton" style="--height: 30px; --width: 75px"></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="product-results-container"></div>
                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

</header>

<div class="basket-menu">

    <div class="basket-menu-wrapper">

        <div class="basket-header">
            <h2>Your Basket</h2>
            <button class="close-basket-menu">
                <?= file_get_contents( get_template_directory_uri() . '/images/svg/close-cross.svg' ) ?>
            </button>
        </div>

        <div class="basket-items">
            <div class="filter-loading-overlay rounded-border" style="--spinner-colour: #046db5;">
                <span class="spinner-loader"></span>
            </div>
            <div class="basket-items-container"></div>
        </div>

        <?php if( $basket_total >= 1 ) : ?>
            <div class="basket-footer">
                <div class="basket-total">
                    <div class="basket-subtotal">
                        <h2>Subtotal</h2>
                        <span class="get-basket-total fs-medium"></span>
                    </div>
                    <span>Postage calculated at checkout.</span>
                </div>

                <div class="basket-ctas">
                    <a href="<?= site_url() . '/basket/' ?>" class="basket-cta">Basket</a>
                    <a href="<?= site_url() . '/checkout/' ?>" class="basket-checkout-cta">Checkout</a>
                </div>
            </div>
        <?php endif; ?>

    </div>
</div>