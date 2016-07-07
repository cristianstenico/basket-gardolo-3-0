<?php
/**
 * The sidebar containing the main widget area.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Basket_Gardolo_3.0
 */

if ( ! is_active_sidebar( 'sidebar-1' ) && ! is_active_sidebar( 'sidebar-2' ) ) {
	return;
}
?>

<div id="secondary" class="widget-area" role="complementary">
	<?php if ( is_active_sidebar( 'sidebar-1' ) ) : ?>
		<div class="widget-column">
			<?php dynamic_sidebar( 'sidebar-1' ); ?>
		</div><!-- .widget-column -->
	<?php endif; ?>

	<?php if ( is_active_sidebar( 'sidebar-2' ) ) : ?>
		<div class="widget-column">
			<?php dynamic_sidebar( 'sidebar-2' ); ?>
		</div><!-- .widget-column -->
	<?php endif; ?>
</div>
