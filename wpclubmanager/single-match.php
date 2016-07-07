<?php
/**
 * The Template for displaying all single matches.
 *
 * Override this template by copying it to yourtheme/wpclubmanager/single-match.php
 *
 * @author 		ClubPress
 * @package 	WPClubManager/Templates
 * @version     1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

get_header(); ?>
	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">
		<?php while ( have_posts() ) : the_post(); ?>

			<?php wpclubmanager_get_template_part( 'content', 'single-match' ); 
			
			the_post_navigation();

			// If comments are open or we have at least one comment, load up the comment template.
			if ( comments_open() || get_comments_number() ) :
				comments_template();
			endif;
			?>
		<?php endwhile; // end of the loop. ?>
		</main>
	</div>
<?php get_sidebar(); ?>
<?php get_footer(); ?>