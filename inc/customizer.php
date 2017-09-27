<?php
/**
 * Basket Gardolo 3.0 Theme Customizer.
 *
 * @package Basket_Gardolo_3.0
 */

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function basket_gardolo_3_0_customize_register( $wp_customize ) {
	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
	$wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';
}
add_action( 'customize_register', 'basket_gardolo_3_0_customize_register' );

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function basket_gardolo_3_0_customize_preview_js() {
	wp_enqueue_script( 'basket_gardolo_3_0_customizer', get_template_directory_uri() . '/assets/js/customizer.js', array( 'customize-preview' ), '20151215', true );
}
add_action( 'customize_preview_init', 'basket_gardolo_3_0_customize_preview_js' );
