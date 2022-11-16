<?php
/**
 * Settings for divi
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

/**
 * Adds a divi builder to given custom post types and globalize all section templates
 *
 * @return array All post-type-names
 * @uses get_post_types()
 */
function divi_overrule_post_types() {
    return get_post_types();
}

add_filter( 'et_builder_post_types', 'divi_overrule_post_types', 100 );
add_filter( 'et_pb_show_all_layouts_built_for_post_type', 'divi_overrule_post_types', 100);

// REMOVE ALL DIVI GOOGLE FONTS (Except Open Sans) FROM DIVI
function et_builder_get_google_fonts() {return array();}
function et_get_google_fonts() {return array();}

// REMOVE DIVI SUPPORT SCRIPTS E.G. VISITING YOUTUBE ON FRONTEND
// (in backend the script should load)
function theme_divi_dequeue_support_center_scripts() {
    wp_dequeue_script( 'et-support-center' );

}
add_action( 'wp_enqueue_scripts', 'theme_divi_dequeue_support_center_scripts', 20 );

/**
 * Translates Divi strings
 * @param $translated
 * @return mixed
 */
function theme_translate_divi($translated) {
    $translated = str_ireplace('read more', 'weiterlesen', $translated);
    $translated = str_ireplace('Search &hellip;', 'Suchen &hellip;', $translated);
    $translated = str_ireplace('Search for:', 'Suche nach:', $translated);
    $translated = str_ireplace('« Older Entries', '« ältere Beiträge', $translated);
    $translated = str_ireplace('Next Entries »', 'neuere Beiträge »', $translated);
    $translated = str_ireplace('Please, fill in the following fields:', 'Bitte füllen Sie die folgenden Felder aus:', $translated);

    return $translated;
}
add_filter('gettext', 'theme_translate_divi');
add_filter('ngettext', 'theme_translate_divi');


// Begin custom image size for Blog Module
function blog_size_w($width) 
{
    return '600';
}

function blog_size_h($height)
{
    return '400';
}

add_filter( 'et_pb_blog_image_width', 'blog_size_w' );
add_filter( 'et_pb_blog_image_height', 'blog_size_h' );
add_image_size( 'custom-blog-size', 640, 400 );
// End custom image size for Blog Module


//* changes image size for divi portfolio
function portfolio_size_h($height) {
    return '9999';
}

function portfolio_size_w($width) {
    return '9999';
}

add_filter( 'et_pb_portfolio_image_height', 'portfolio_size_h' );
add_filter( 'et_pb_portfolio_image_width', 'portfolio_size_w' );