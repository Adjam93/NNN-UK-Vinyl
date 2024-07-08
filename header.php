<!DOCTYPE html>

<html <?php language_attributes(); ?>>

<head>

    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800;900&family=Roboto&display=swap" rel="stylesheet">
    <?php wp_head(); ?>
                 
</head>

<body <?php body_class(); ?> >
 

<header>

    <div class="header-wrapper">

        <div class="container">

            <div class="header-inner">

                <div class="logo">

                    <a href="<?php echo home_url( ) ?>">
                        <img src="<?php echo get_template_directory_uri() . '/images/NNN-UK-Vinyl.svg' ?>" />
                    </a>

                </div>

                <div class="menu-icon">
                    <div class="menu-btn-burger"></div>
                </div>

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
           
            <div class="mobile-menu">
                <?php
                    wp_nav_menu( array(
                        'menu'              => 'primary',
                        'theme_location'    => 'primary',
                        'depth'             => 3,
                    ));
                ?>
            </div>

        </div>

        <div class="container search">

            <div class="record-search">

                <div class="search-wrapper">
                    <input type="text" placeholder="Live search records, tapes, CDs and more..." autocomplete="off" id="records-search">

                    <div class="search-overlay">

                        <div class="search-overlay-inner">

                            <img class="spinner-img" src="<?php echo get_template_directory_uri() . '/images/711.gif' ?>" />
                            <div class="spinner-loader">Searching Records... (please enter at least 3 or more characters)</div>

                        </div>

                    </div>
                   
                    <div class="header-search-results">
                        <!-- <div class="search-overlay">Searching...</div> -->
                    </div>

                </div>

            </div>
           
          
        </div>
        

    </div>

</header>

