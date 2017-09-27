<?php
/**
 * The main template file.
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Basket_Gardolo_3.0
 */
get_header();
$post_type = get_post_type();
?>
	<?php
		if ( is_home() ) {
			// Include the featured content template.
			
			get_template_part( 'components/features/featured-content/display', 'featured' );
		}

	?>
<div class="widget-column">
    <?php
    global $competition;
    if ($competition) {
        dynamic_sidebar('sidebar-2');
    } else {
        dynamic_sidebar('gardolo-sidebar');
    }
    ?>
</div>
	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">
		<?php
		if ( have_posts() ) :

			if ( is_home() && ! is_front_page() ) : ?>
				<header>
					<h1 class="page-title screen-reader-text"><?php single_post_title(); ?></h1>
				</header>
			<?php
			endif;
			/* Start the Loop */
			while ( have_posts() ) : the_post();

				/*
				 * Include the Post-Format-specific template for the content.
				 * If you want to override this in a child theme, then include a file
				 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
				 */
				get_template_part( 'components/post/content', get_post_format() );

			endwhile;
			the_posts_navigation(
                array(
			        'prev_text' => '&#8592;',
                    'next_text' => '&#8594;'
                )
            );
		else :
			get_template_part( 'components/post/content', 'none' );

		endif; ?>

		</main>
	</div>
<div class="widget-column">
    <?php dynamic_sidebar('sidebar-1'); ?>
</div>
<?php
get_footer();
