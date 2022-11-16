<?php
/**
 * All enqueue files
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

/*
* Register scripts and styles
*/
function theme_enqueue() {
    global $wp_styles;

    wp_enqueue_script( 'theme-script', get_stylesheet_directory_uri() . '/assets/js/scripts.js', array("jquery"), filemtime(get_stylesheet_directory()), true );

    wp_enqueue_style( 'divi-parent', get_template_directory_uri() . '/style.css' );

    wp_enqueue_style( 'theme-css', get_stylesheet_directory_uri() . '/assets/css/theme.css', array(), filemtime(get_stylesheet_directory()) );

}
add_action( 'wp_enqueue_scripts', 'theme_enqueue' );


// REMOVE GOOGLE FONTS FROM DIVI
function theme_divi_dequeue_google_fonts() {
    wp_dequeue_style( 'divi-fonts' );
    wp_dequeue_style( 'et-builder-googlefonts-cached' );
}
add_action( 'wp_enqueue_scripts', 'theme_divi_dequeue_google_fonts', 20 );