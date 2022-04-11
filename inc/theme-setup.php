<?php

function nnn_starter_theme_setup(){

    //Theme support options
    add_theme_support( 'post-thumbnails' );
    add_theme_support( 'title-tag' );
    add_theme_support( 'custom-logo' );
    add_theme_support( 'html5',
        array( 'comment-list', 'comment-form', 'search-form', 'gallery' )
    );

     // Nav Menus
    register_nav_menus( array(
        'primary' => 'Primary Menu'
    ) );
    
}

add_action( 'after_setup_theme', 'nnn_starter_theme_setup' );


/**
 * Register Shop Page Sidebar
 */
function nnn_widgets() {

    //Shop Sidebar
    register_sidebar( 

        array(

            'name' => 'Shop Sidebar',
            'id' => 'shop_sidebar',
            'before_widget' => '<div id="%1$s" class="sidebar-content %2$s">',
            'after_widget'  => '</div>',
            'before_title' => '<h2>',
            'after_title' => '</h2>'
        )

    );
    
}

add_action( 'widgets_init', 'nnn_widgets' );


/**
 * Custom body classes
 */
function nnn_body_classes( $classes ) {
 
    if ( is_shop() ) {
     
        $classes[] = 'shop';
         
    }
     
    return $classes;
}

add_filter( 'body_class', 'nnn_body_classes' );
