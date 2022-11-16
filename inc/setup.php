<?php
/**
 * Setup for the theme
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

/**
 * Register menus
 */
register_nav_menus(
    array(
        'navbar_button_menu' => __( 'Navbar Button Menu', 'divi' ),
    ) 
);

