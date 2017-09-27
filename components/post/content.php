<?php
/**
 * Template part for displaying posts.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Basket_Gardolo_3.0
 */

?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <?php
    $post_type = get_post_type();
    $show_hero = has_post_thumbnail();
    $show_hero = $show_hero && $post_type != 'sp_player';
    $show_hero = $show_hero && $post_type != 'sp_team';
    $show_hero = $show_hero && is_singular();
    if ($show_hero) : ?>
        <div class="hero">
            <div class="hentry-inner">
                <div class="entry-wrapper">
                    <header class="entry-header">
                        <div class="entry-meta">
                            <?php basket_gardolo_3_0_categories(); ?>
                        </div><!-- .entry-meta -->
                        <?php the_title('<h1 class="entry-title">', '</h1>'); ?>
                    </header><!-- .entry-header -->
                </div><!-- .entry-wrapper -->
            </div><!-- .hentry-inner -->
        </div><!-- .hero -->
    <?php endif; ?>

    <header class="entry-header">
        <?php
        if (!$show_hero) {
            if (is_single()) {
                the_title('<h1 class="entry-title">', '</h1>');
            } else {
                the_title('<h2 class="entry-title"><a href="' . esc_url(get_permalink()) . '" rel="bookmark">', '</a></h2>');
            }
        }
        ?>
    </header>
    <div class="entry-content">
        <?php
        the_content(sprintf(
        /* translators: %s: Name of current post. */
            wp_kses(__('Continue reading %s <span class="meta-nav">&rarr;</span>', 'basket-gardolo-3-0'), array('span' => array('class' => array()))),
            the_title('<span class="screen-reader-text">"', '"</span>', false)
        ));

        wp_link_pages(array(
            'before' => '<div class="page-links">' . esc_html__('Pages:', 'basket-gardolo-3-0'),
            'after' => '</div>',
        ));
        ?>
    </div>
    <?php get_template_part('components/post/content', 'footer'); ?>
</article><!-- #post-## -->