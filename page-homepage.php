<?php
get_header(); ?>
    <div class="widget-column">
        <?php
            dynamic_sidebar('gardolo-sidebar');
        ?>
    </div>
    <div id="primary" class="content-area">
        <main id="main" class="site-main" role="main">

            <?php
            global $post;
            $args = array(
                'post_type' => array('post', 'sp_event', 'minibasket'),
                'meta_query' => array(
                    array(
                        'key' => '_thumbnail_id',
                        'value' => '0',
                        'compare' => '>='
                    )
                ),
                'posts_per_page' => 1
            );
            $post = get_posts($args)[0];
            $post_id = $post->ID;
            $featuredImage = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'basket-gardolo-3-0-hero' );
            ?>
        <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                <div class="hero" style="<?php echo 'background-image: url(' . esc_url( $featuredImage[0] ) . ')';?>">
                    <div class="hentry-inner">
                        <div class="entry-wrapper">
                            <header class="entry-header">
                                <a href="<?php the_permalink(); ?>"><?php the_title( '<h1 class="entry-title">', '</h1>' ); ?></a>
                            </header><!-- .entry-header -->
                        </div><!-- .entry-wrapper -->
                    </div><!-- .hentry-inner -->
            </div><!-- .hero -->
        </article>
<?php
            query_posts(array(
                'post_type' => array('post', 'sp_event', 'minibasket'),
                'posts_per_page' => 10
            ));
            while (have_posts()) : the_post();
                if ($post->post_type == 'sp_event') {
                    $competition = wp_get_object_terms($post->ID,'sp_league')[0];
                    echo '<div class="date">';

                    echo '</div>';?>
                    <a href="<?php the_permalink(); ?>">
                        <?php the_title( '<h2><div class="date">' . get_the_date('j F Y') . '</div><span class="competizione">' . $competition->name . '</span> ', '</h2>' ); ?>
                    </a>
                    <?php
                }
                else
                    get_template_part('components/post/content');
                ?>
                <hr>
                <?php
            endwhile; // End of the loop.
            ?>

        </main>
    </div>
    <div class="widget-column">
        <?php dynamic_sidebar('sidebar-1'); ?>
    </div>
<?php
get_footer();