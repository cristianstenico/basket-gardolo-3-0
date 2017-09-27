<?php
/**
 * Custom functions that act independently of the theme templates.
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package Basket_Gardolo_3.0
 */

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function basket_gardolo_3_0_body_classes( $classes ) {
	global $featuredImage;
	// Adds a class of group-blog to blogs with more than 1 published author.
	if ( is_multi_author() ) {
		$classes[] = 'group-blog';
	}
    if (get_post_type() == 'sp_player') {
        return $classes;
    }
	if ( ( is_singular() && has_post_thumbnail() ) ||
         ( is_singular() && $featuredImage) ) {
		$classes[] = 'has-hero';
	}

	// Adds a class of hfeed to non-singular pages.
	if ( ! is_singular() ) {
		$classes[] = 'hfeed';
	}

	return $classes;
}
add_filter( 'body_class', 'basket_gardolo_3_0_body_classes' );

/**
 * Adds custom classes to the array of post classes.
 *
 * @param array $classes Classes for the post element.
 * @return array
 */
function basket_gardolo_3_0_post_classes( $classes ) {
	global $wp_query;
	
	// Adds a class of hero to the 1st post on the 1st page if it has a featured image.
	if ( is_front_page() && ! is_paged() && 0 === $wp_query->current_post && has_post_thumbnail() ) {
		$classes[] = 'hero';
	}
	return $classes;
}
add_filter( 'post_class', 'basket_gardolo_3_0_post_classes' );

/**
 * Add featured image as background image to hero.
 *
 * @see wp_add_inline_style()
 */
function basket_gardolo_3_0_hero_background() {
	global $wp_query;
	global $post;
	global $featuredImage;
	if ( ! is_singular() ) {
		return;
	}
	$featuredImage = null;
	if($post->post_type == 'wpcm_match'){
		$terms = get_terms( array(
			'taxonomy' => array('wpcm_season','wpcm_team')
		));
		if(count($terms)==2) {
			$thumbnail = get_posts(array(
				'post_type' => 'wpcm_team_photo',
				'tax_query' => array(
					array(
						'taxonomy'	=> 'wpcm_season',
						'field'		=> 'term_id',
						'terms'		=> $terms[0]->term_id
					),
					array(
						'taxonomy' => 'wpcm_team',
						'field'		=> 'term_id',
						'terms'		=> $terms[1]->term_id
					)
				)
			));
			if(count($thumbnail) > 0){
				$featuredImage = wp_get_attachment_image_src(get_post_thumbnail_id($thumbnail[0]->ID), 'basket-gardolo-3-0-hero');
			}
		}
	}
	else
		$featuredImage= wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'basket-gardolo-3-0-hero' );
	$css = '.hero { background-image: url(' . esc_url( $featuredImage[0] ) . '); }';
	wp_add_inline_style( 'basket-gardolo-3-0-style', $css );
}
add_action( 'wp_enqueue_scripts', 'basket_gardolo_3_0_hero_background' );

function basket_gardolo_3_0_select_multiple_job($output){
	if(strpos($output, 'option-jobs')){
		$output = str_replace("id='option-jobs'", "multiple id='option-jobs'", $output);
	}
	return $output;
}
add_filter('wp_dropdown_cats', 'basket_gardolo_3_0_select_multiple_job');
