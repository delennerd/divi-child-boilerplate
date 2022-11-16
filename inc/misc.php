<?php
/**
 * Optimization stuff
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

/**
 * soft hyphen shortcode, because &shy; gets stripped
 */
function theme_shy_shortcode($atts){
    return '&shy;';
}
add_shortcode('shy', 'theme_shy_shortcode');

function theme_zerospace_shortcode($atts){
    return '&ZeroWidthSpace;';
}
add_shortcode('zerospace', 'theme_zerospace_shortcode');

/**
 * allows design menu for authors
 */
$role_object = get_role( 'editor' );
$role_object->add_cap( 'edit_theme_options' );

/**
 * Returns the uploads base url
 * @return string the WordPress uploads url
 */
function theme_get_uploads_url(){
    $uploads = wp_upload_dir();
    $upload_path = $uploads['baseurl'];

    return $upload_path;
}