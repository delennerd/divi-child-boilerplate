<?php

//remove automatic <p> tags from excerpt
remove_filter('the_excerpt', 'wpautop');

/*
* Register scripts and styles
*/
function theme_enqueue() {
    global $wp_styles;

    wp_enqueue_script( 'theme-script', get_stylesheet_directory_uri() . '/assets/js/scripts.js', array("jquery"), filemtime(get_stylesheet_directory()), true );

    wp_enqueue_style( 'divi-parent', get_template_directory_uri() . '/style.css' );

    wp_enqueue_style( 'theme-css', get_stylesheet_directory_uri() . '/assets/css/app.css', array(), filemtime(get_stylesheet_directory()) );

}

add_action( 'wp_enqueue_scripts', 'theme_enqueue' );


/*
* Add Translations
*/
function theme_load_lang() {
    load_child_theme_textdomain( 'Divi', get_stylesheet_directory() . '/lang/Divi' );
}

add_action( 'after_setup_theme', 'theme_load_lang' );


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
remove_action('wp_head', 'feed_links', 2 ); //removes feed links.
remove_action('wp_head', 'feed_links_extra', 3 );  //removes comments feed.
remove_action('wp_head', 'adjacent_posts_rel_link_wp_head'); // Removes prev and next links

// remove dashicons in frontend to non-admin
function thr_dequeue_dashicon() {
    if (current_user_can( 'update_core' )) {
        return;
    }
    wp_deregister_style('dashicons');
}
add_action( 'wp_enqueue_scripts', 'thr_dequeue_dashicon' );

/* Remove Woothemes generator */
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

/**
 * allows design menu for authors
 */
$role_object = get_role( 'editor' );
$role_object->add_cap( 'edit_theme_options' );

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

/* Removes DNS prefetches */
remove_action('wp_head', 'wp_resource_hints', 2);

// REMOVE GOOGLE FONTS FROM DIVI
function theme_divi_dequeue_google_fonts() {
    wp_dequeue_style( 'divi-fonts' );
    wp_dequeue_style( 'et-builder-googlefonts-cached' );
}
add_action( 'wp_enqueue_scripts', 'theme_divi_dequeue_google_fonts', 20 );

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
 * changes gravity forms standard validation error message
 *
 * @param $message
 * @param $form
 * @return string
 */
function theme_filter_gform_validation_message( $message, $form ) {
    return "<div class='validation_error'>Es gab ein Problem mit den Eingaben. Fehler wurden unten hervorgehoben.</div>";
}
add_filter( 'gform_validation_message', 'theme_filter_gform_validation_message', 10, 2 );

/**
 * Returns the uploads base url
 * @return string the WordPress uploads url
 */
function theme_get_uploads_url(){
    $uploads = wp_upload_dir();
    $upload_path = $uploads['baseurl'];

    return $upload_path;
}

// adds page slug body class
function theme_add_slug_body_class( $classes ) {
    global $post;
    if ( isset( $post ) ) {
        $classes[] = $post->post_type . '-slug-' . $post->post_name;
    }
    return $classes;
}

add_filter( 'body_class', 'theme_add_slug_body_class' );

function theme_add_head_html(){
    ?>
    <?php
}
add_action('wp_head', 'theme_add_head_html');


function theme_add_wp_body_open_html()
{
    ?>
    <?php
}
add_action('wp_body_open', 'theme_add_wp_body_open_html');


function theme_add_footer_html(){
    ?>
    <?php
}
add_action('wp_footer', 'theme_add_footer_html');

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

/**
 * hides login errors
 */
add_filter( 'login_errors', '__return_null' );

// Disables the block editor from managing widgets. renamed from wp_use_widgets_block_editor
add_filter( 'use_widgets_block_editor', '__return_false' );


// removes gravity forms entries directly after submission
function remove_form_entry( $entry ) {
    GFAPI::delete_entry( $entry['id'] );
}
add_action( 'gform_after_submission_3', 'remove_form_entry' );


/**
 * Register menus
 */
register_nav_menus(
    array(
        'navbar_button_menu' => __( 'Navbar Button Menu', 'divi' ),
    ) 
);


function idm_dps_template_part( $output, $original_atts ) {
	// Return early if our "layout" attribute is not specified
	if( empty( $original_atts['layout'] ) ) {
		return $output;
    }

	ob_start();

	get_template_part( 'loop-content/dps', $original_atts['layout'] );

	$new_output = ob_get_clean();
	
    if ( !empty( $new_output ) ) {
		$output = $new_output;
    }

	return $output;
}
add_action( 'display_posts_shortcode_output', 'idm_dps_template_part', 10, 2 );


/**
 * Display Posts -  Pagination Links
 *
 */
function theme_dps_pagination_links( $output, $atts, $listing ) {
	if( empty( $atts['pagination'] ) || !empty( $atts['offset'] ) )
		return $output;

	global $wp;
	$base = home_url( $wp->request );

	$format = 'dps_paged';
	if( intval( $atts['pagination'] ) > 1 )
		$format .= '_' . intval( $atts['pagination'] );
	$format = '?' . $format . '=%#%';

	$current = !empty( $listing->query['paged'] ) ? $listing->query['paged'] : 1;

	$args = array(
		'base'		=> trailingslashit( $base ) . $format,
		'format'    => $format,
		'current'   => $current,
		'total'     => $listing->max_num_pages,
		'prev_text' => 'Previous',
		'next_text' => 'Next',
        'type'      => 'array',
	);

	$nav_output = '';
	$navigation = paginate_links( apply_filters( 'display_posts_shortcode_paginate_links', $args, $atts ) );
    
	if( $navigation ) {
    	$nav_output .= '<nav class="display-posts-pagination" role="navigation" aria-labelledby="posts-nav-label">';
        	$nav_output .= '<h2 id="posts-nav-label" class="screen-reader-text">Navigation</h2>';
            $nav_output .= ' <ul class="pagination">';

            foreach( $navigation as $link ) {

                $nav_output .= sprintf(
                    '<li class="page-item %1$s">%2$s</li>',
                    strpos( $link, 'current' ) ? 'active' : '',
                    str_replace( 'page-numbers', 'page-link', $link )
                );

        	    // $nav_output .= '<div class="pagination">' . $navigation . '</div>';
            }

            $nav_output .= '</ul>';

		$nav_output .= '</nav>';
	}

	if( !empty( $atts['pagination_inside'] ) && filter_var( $atts['pagination_inside'], FILTER_VALIDATE_BOOLEAN ) )
		$output = $nav_output . $output;
	else
		$output .= $nav_output;

	return $output;
}
add_filter( 'display_posts_shortcode_wrapper_close', 'theme_dps_pagination_links', 10, 3 );

/**
 * Display Posts - Pagination Args
 */
function be_dps_pagination_args( $args, $atts ) {
	if( empty( $atts['pagination'] ) )
		return $args;

	$format = 'dps_paged';
	if( intval( $atts['pagination'] ) > 1 )
		$format .= '_' . intval( $atts['pagination'] );

	if( ! empty( $_GET[ $format ] ) )
		$args['paged'] = intval( $_GET[ $format ] );

	return $args;
}
add_filter( 'display_posts_shortcode_args', 'be_dps_pagination_args', 10, 2 );


require dirname(__FILE__) . '/modules/post-filter-shortcode/post-filter-shortcode.php';