<?php
/**
 * Init the textdomain
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

/*
* Add Translations
*/
function theme_load_lang() {
    load_child_theme_textdomain( 'Divi', get_stylesheet_directory() . '/lang/Divi' );
}

add_action( 'after_setup_theme', 'theme_load_lang' );