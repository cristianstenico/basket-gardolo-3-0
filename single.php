<?php
/**
 * The template for displaying all single posts.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package Basket_Gardolo_3.0
 */
$post_type = get_post_type();
global $competition;
global $team_id;
if ($post_type == 'sp_player' || $post_type == 'sp_calendar') {
	 'meta_query' => array(
                                array(
                                    'key' => 'sp_team',
                                    'value' => get_post_meta($team_id, 'sp_team', true)
                                ),
                            )
    $team_id = get_post_meta($post->ID, 'sp_team', true);
    $competition = wp_get_object_terms($post->ID, 'sp_league');
}

get_header(); ?>
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
		while ( have_posts() ) : the_post();
			$post_type = get_post_type();
			the_title('<h1 class="entry-title">', '</h1>');
			if ($post_type == 'sp_calendar') {
				$calendar = new SP_Calendar($post);
				sp_get_template( 'event-blocks.php',
					array(
						'id' => $calendar->ID
					)
				);
			} else if ($post_type == 'sp_player' || $post_type == 'sp_staff') {
				the_content();
			} else {
				get_template_part(sprintf('components/%s/content', $post_type), get_post_format());
            		}
			// Previous/next post navigation.
			the_post_navigation( array(
				'next_text' => '<span class="post-title">%title</span>' . '<span class="meta-nav" aria-hidden="true">' . __( '&#8594;', 'basket_gardolo_3_0' ) . '</span> ',
				'prev_text' => '<span class="meta-nav" aria-hidden="true">' . __( '&#8592;', 'basket_gardolo_3_0' ) . '</span> ' . '<span class="post-title">%title</span>',
			) );

			// If comments are open or we have at least one comment, load up the comment template.
			if ( comments_open() || get_comments_number() ) :
				comments_template();
			endif;

		endwhile; // End of the loop.
		?>
		</main>
	</div>
    <div class="widget-column">
<?php
dynamic_sidebar('sidebar-1'); ?>
        </div>
<?php
get_footer();
