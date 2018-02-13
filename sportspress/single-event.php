<?php
/**
 * The template for displaying all pages.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Basket_Gardolo_3.0
 */
global $competition;
global $team_id;
$competition = wp_get_object_terms($post->ID, 'sp_league');
$team_id = get_post_meta($post->ID, 'sp_team');
if (strstr(strtolower(get_post($team_id[0])->title), 'gardolo') {
    $team_id = $team_id[0];
} else {
    $team_id = $team_id[1];   
}
get_header(); ?>
    <div class="widget-column">
        <?php dynamic_sidebar('sidebar-2'); ?>
    </div>
    <div id="primary" class="content-area">
        <main id="main" class="site-main" role="main">

            <?php
            while (have_posts()) : the_post();
                get_template_part('components/single_event/content');
                ?>
                <div class="post-nav">
                    <div class="alignleft prev-next-post-nav">
                        <?php
                            previous_post_link( '%link', '&#8592; %title' , true, ' ', 'sp_league');
                        ?>
                    </div>
                    <div class="alignright prev-next-post-nav">
                        <?php next_post_link( '%link', '%title &#8594;', true, ' ', 'sp_league' ); ?>
                    </div>
                </div>
            <?php
                // If comments are open or we have at least one comment, load up the comment template.
                if (comments_open() || get_comments_number()) :
                    comments_template();
                endif;

            endwhile; // End of the loop.
            ?>

        </main>
    </div>
    <div class="widget-column">
        <?php dynamic_sidebar('sidebar-1'); ?>
    </div>
<?php
get_footer();
