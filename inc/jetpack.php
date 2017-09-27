<?php
/**
 * Jetpack Compatibility File.
 *
 * @link https://jetpack.me/
 *
 * @package Basket_Gardolo_3.0
 */

/**
 * Jetpack setup function.
 *
 * See: https://jetpack.me/support/infinite-scroll/
 * See: https://jetpack.me/support/responsive-videos/
 */
function basket_gardolo_3_0_jetpack_setup() {
	// Add theme support for Infinite Scroll.
	add_theme_support( 'infinite-scroll', array(
		'container' => 'main',
		'render'	=> 'basket_gardolo_3_0_infinite_scroll_render',
		'footer'	=> 'page',
	) );

	// Add theme support for Responsive Videos.
	add_theme_support( 'jetpack-responsive-videos' );

	// Add theme support for Social Menus
	add_theme_support( 'jetpack-social-menu' );

	// Add theme support for site logos
	add_image_size( 'basket-gardolo-3-0-logo', 200, 200 );
	add_theme_support( 'site-logo', array( 'size' => 'basket-gardolo-3-0-logo' ) );

	add_theme_support( 'featured-content', array(
		'filter'	 => 'basket_gardolo_3_0_get_featured_posts',
		'max_posts'  => 20,
		'post_types' => array( 'post', 'match'),
	) );
}
add_action( 'after_setup_theme', 'basket_gardolo_3_0_jetpack_setup' );

/**
 * Custom render function for Infinite Scroll.
 */
function basket_gardolo_3_0_infinite_scroll_render() {
	while ( have_posts() ) {
		the_post();
		if ( is_search() ) :
			get_template_part( 'components/post/content', 'search' );
		else :
			get_template_part( 'components/post/content', get_post_format() );
		endif;
	}
}

/**
 * Return early if Site Logo is not available.
 */
function basket_gardolo_3_0_the_site_logo() {
	if ( ! function_exists( 'jetpack_the_site_logo' ) ) {
		return;
	} else {
		jetpack_the_site_logo();
	}
}

function basket_gardolo_3_0_social_menu() {
	if ( ! function_exists( 'jetpack_social_menu' ) ) {
		return;
	} else {
		jetpack_social_menu();
	}
}

/**
 * Featured Posts
 */
function basket_gardolo_3_0_has_multiple_featured_posts() {
	$featured_posts = apply_filters( 'basket_gardolo_3_0_get_featured_posts', array() );
	if ( is_array( $featured_posts ) && 1 < count( $featured_posts ) ) {
		return true;
	}
	return false;
}
function basket_gardolo_3_0_get_featured_posts() {
	$p = apply_filters( 'basket_gardolo_3_0_get_featured_posts', false );
	return $p;
}