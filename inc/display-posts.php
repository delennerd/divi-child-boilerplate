<?php
/**
 * Settings for the display-posts plugin
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

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