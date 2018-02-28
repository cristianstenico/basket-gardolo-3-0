<?php
/**
 * Template part for displaying posts.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Basket_Gardolo_3.0
 */

?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>
<header class="entry-header">
    <?php
    if (!is_single()) {
        the_title('<h2 class="entry-title"><a href="' . esc_url(get_permalink()) . '" rel="bookmark">', '</a></h2>');
    }
    if ('post' === get_post_type()) : ?>
        <?php get_template_part('components/post/content', 'meta'); ?>
        <?php
    endif; ?>
</header>
<div class="entry-content">
    <?php
    the_content();
    ?>
</div>
<?php get_template_part('components/post/content', 'footer'); ?>
</article><!-- #post-## -->
