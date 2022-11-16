<?php
/**
 * Here you can include code within hooks
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

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