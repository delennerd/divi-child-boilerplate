<?php
/**
 * Some stuff for gravity forms
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

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

// removes gravity forms entries directly after submission
function remove_form_entry( $entry ) {
    GFAPI::delete_entry( $entry['id'] );
}
add_action( 'gform_after_submission_3', 'remove_form_entry' );