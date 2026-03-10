<?php

/**
 * EC Sage Projects - Blade wrapper
 *
 * This file is used as a WordPress "template" and renders a Sage Blade view.
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$view_name = isset( $GLOBALS['ec_sage_projects_view'] ) ? (string) $GLOBALS['ec_sage_projects_view'] : '';

if ( $view_name === '' ) {
    // Nothing to render; let WordPress handle it.
    return;
}

if ( ! function_exists( '\Roots\view' ) ) {
    wp_die(
        esc_html__( 'EC Sage Projects requires a Sage (Acorn) theme to render templates.', 'ec-sage-projects' ),
        esc_html__( 'Template Error', 'ec-sage-projects' ),
        array( 'response' => 500 )
    );}

try {
    echo \Roots\view( $view_name )->render();
} catch ( \Throwable $e ) {
    if ( defined( 'WP_DEBUG' ) && WP_DEBUG ) {
        wp_die(
            esc_html__( 'EC Sage Projects template error:', 'ec-sage-projects' ) . ' ' . esc_html( $e->getMessage() ),
            esc_html__( 'Template Error', 'ec-sage-projects' ),
            array( 'response' => 500 )
        );
    }

    wp_die(
        esc_html__( 'Projects template error. Please check the logs.', 'ec-sage-projects' ),
        esc_html__( 'Template Error', 'ec-sage-projects' ),
        array( 'response' => 500 )
    );
}
