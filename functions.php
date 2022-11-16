<?php
// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

define( 'CUSTOM_THEME_URL', get_stylesheet_directory_uri() );
define( 'CUSTOM_THEME_FILE', __FILE__ );
define( 'CUSTOM_THEME_PATH', __DIR__ );
define( 'CUSTOM_THEME_INCLUDE_PATH', __DIR__ . '/inc/' );

/*
|--------------------------------------------------------------------------
| Autoloader
|--------------------------------------------------------------------------
*/
$theme_includes = [
    '/setup.php',
    '/enqueue.php',
    '/language.php',
    '/gravity-forms.php',
    '/divi.php',
    // '/pagination.php',
    // '/display-posts.php',
    '/optimize/disable-email-notifications.php',
    '/optimize/optimization.php',
    '/misc.php',
    '/includes.php',
    '/../modules/post-filter-shortcode/post-filter-shortcode.php',
];

foreach( $theme_includes as $file_path ) {
    include_once dirname(__FILE__) . '/inc' . $file_path;
}