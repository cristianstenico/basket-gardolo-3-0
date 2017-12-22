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
if (has_shortcode($post->post_content, 'player_list')) {
    $pattern = get_shortcode_regex();
    preg_match('/' . $pattern . '/s', $post->post_content, $matches);
    if ($matches) :
        if (is_array($matches) && $matches[2] == 'player_list') {
            $team_id = shortcode_parse_atts($matches[0])['id'];
            $competition = get_the_terms($team_id, 'sp_league');
        }
    endif;
}
get_header(); ?>
    <div class="widget-column">
        <?php
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
            while (have_posts()) : the_post();

                get_template_part('components/page/content', 'page');

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