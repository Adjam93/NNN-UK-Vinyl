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


function add_last_nav_item( $items ) {

  return $items .= '<li class="login-link"><a href="my-account"><span>'.file_get_contents( get_template_directory_uri() . '/images/svg/person.svg' ).'</span> <span>Login/Register</span></a></li>';

}

add_filter( 'wp_nav_menu_items','add_last_nav_item' );


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
