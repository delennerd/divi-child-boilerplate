<?php
/**
 * 
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

if ( ! function_exists( 'theme_disable_new_user_notifications' ) ) :
    /**
     * Disable the new user notification sent to the site admin
     */
    function theme_disable_new_user_notifications()
    {
    	// Remove original use created emails
    	remove_action( 'register_new_user', 'wp_send_new_user_notifications' );
    	remove_action( 'edit_user_created_user', 'wp_send_new_user_notifications', 10, 2 );
    	
    	//A dd new function to take over email creation
    	add_action( 'register_new_user', 'theme_send_new_user_notifications' );
    	add_action( 'edit_user_created_user', 'theme_send_new_user_notifications', 10, 2 );
    }

endif;

add_action( 'init', 'theme_disable_new_user_notifications' );


if ( ! function_exists( 'theme_send_new_user_notifications' ) ) :
    /**
     * 
     */
    function theme_send_new_user_notifications( $user_id, $notify = 'user' )
    {
    	if ( empty($notify) || $notify == 'admin' ) {
    	  return;
    	} elseif( $notify == 'both' ) {
        	// Only send the new user their email, not the admin
    		$notify = 'user';
    	}
    	wp_send_new_user_notifications( $user_id, $notify );
    }

endif;


// Disable emails for core updates
add_filter( 'auto_core_update_send_email', '__return_false' );

//Disable plugin auto-update email notification
add_filter('auto_plugin_update_send_email', '__return_false');

//Disable theme auto-update email notification
add_filter('auto_theme_update_send_email', '__return_false');