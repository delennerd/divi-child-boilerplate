<?php
/**
 * Optimization stuff
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

//remove automatic <p> tags from excerpt
remove_filter('the_excerpt', 'wpautop');

/*
* Remove that junk from wp_head
*/
remove_action('wp_head', 'rsd_link'); // Removes the Really Simple Discovery link
remove_action('wp_head', 'wlwmanifest_link'); // Removes the Windows Live Writer link
remove_action('wp_head', 'wp_generator'); // Removes the WordPress version
remove_action('wp_head', 'feed_links', 2); // Removes the RSS feeds remember to add post feed maunally (if required) to header.php
remove_action('wp_head', 'feed_links_extra', 3); // Removes all other RSS links
remove_action('wp_head', 'index_rel_link'); // Removes the index page link
remove_action('wp_head', 'start_post_rel_link', 10, 0); // Removes the random post link
remove_action('wp_head', 'parent_post_rel_link', 10, 0); // Removes the parent post link
remove_action('wp_head', 'adjacent_posts_rel_link', 10, 0); // Removes the next and previous post links
remove_action('wp_head', 'print_emoji_detection_script', 7 );
remove_action('wp_print_styles', 'print_emoji_styles' );
remove_action('wp_head', 'wp_shortlink_wp_head'); //removes shortlink.
remove_action('wp_head', 'adjacent_posts_rel_link_wp_head'); // Removes prev and next links

/* DISABLE EMOJIS */   
remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
remove_action( 'wp_print_styles', 'print_emoji_styles' );
remove_action( 'admin_print_styles', 'print_emoji_styles' ); 
remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
remove_filter( 'comment_text_rss', 'wp_staticize_emoji' ); 
remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );


if ( ! function_exists( 'theme_remove_wp_block_library_css' ) ) :
    /**
     * Remove Gutenberg Block Library CSS from loading on the frontend
     */
    function theme_remove_wp_block_library_css() {
        wp_dequeue_style( 'wp-block-library' );
        wp_dequeue_style( 'wp-block-library-theme' );
        wp_dequeue_style( 'wc-blocks-style' ); // Remove WooCommerce block CSS
    }

endif;

add_action( 'wp_enqueue_scripts', 'theme_remove_wp_block_library_css', 100 );
add_action( 'wp_print_styles', 'theme_remove_wp_block_library_css', 100 );

/**
 * remove dashicons in frontend to non-admin
 */
function idm_dequeue_dashicon() {
    if (current_user_can( 'update_core' )) {
        return;
    }
    wp_deregister_style('dashicons');
}
add_action( 'wp_enqueue_scripts', 'idm_dequeue_dashicon' );

/**
 * Remove Woothemes generator
 */
function theme_remove_woo_generator() {
    remove_action( 'wp_head',  'woo_version', 10 );
}
add_action('get_header','theme_remove_woo_generator');

/*
 * Customize list of allowed HTML tags in comments
 */
function theme_customize_allowedhtmlTagsInComments()
{
    global $allowedtags;

    // remove unwanted tags
    foreach ($allowedtags as $tagKey => $tagAttributs) {
        unset($allowedtags[$tagKey]);
    }
}
add_action('init', 'theme_customize_allowedhtmlTagsInComments');

// Allow uploads for other media formats
function allow_svgimg_types($mimes) {
    $mimes['svg'] = 'image/svg+xml';
    return $mimes;
}
add_filter('upload_mimes', 'allow_svgimg_types');

// Remove WP Version From Styles  
add_filter( 'style_loader_src', 'sdt_remove_ver_css_js', 9999 );
// Remove WP Version From Scripts
add_filter( 'script_loader_src', 'sdt_remove_ver_css_js', 9999 );

// Function to remove version numbers
function sdt_remove_ver_css_js( $src ) {
    if ( strpos( $src, 'ver=' ) )
        $src = remove_query_arg( 'ver', $src );
    return $src;
}

/* Removes DNS prefetches */
remove_action('wp_head', 'wp_resource_hints', 2);

/**
 * disables application passwords feature.
 * complete wordpress core security risk. can be uses to social engineer application acces via rest with ADMIN rights
 * see:
 * https://www.youtube.com/watch?v=MgDbnvuJmPc&feature=youtu.be&t=677
 * https://www.wordfence.com/blog/2020/12/wordpress-5-6-introduces-a-new-risk-to-your-site-what-to-do/
 *
 * @return false
 */
function theme_disable_application_passwords(){
    return false;
}
add_filter("wp_is_application_passwords_available", "theme_disable_application_passwords");

// disables lazy loading by WordPress
// add_filter( 'wp_lazy_loading_enabled', '__return_false' );


/**
 * hides login errors
 */
add_filter( 'login_errors', '__return_null' );

// Disables the block editor from managing widgets. renamed from wp_use_widgets_block_editor
add_filter( 'use_widgets_block_editor', '__return_false' );


// adds page slug body class
function theme_add_slug_body_class( $classes ) {
    global $post;
    if ( isset( $post ) ) {
        $classes[] = $post->post_type . '-slug-' . $post->post_name;
    }
    return $classes;
}

add_filter( 'body_class', 'theme_add_slug_body_class' );