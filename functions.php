<?php
/**
 * Basket Gardolo 3.0 functions and definitions.
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Basket_Gardolo_3.0
 */

if (!function_exists('basket_gardolo_3_0_setup')) :

    function register_widgets()
    {
        require get_template_directory() . '/gardolo-widgets.php';
        register_widget('Gardolo_Widget_Countdown');
        register_widget('Gardolo_Widget_Sponsor');
    }

    add_action('widgets_init', 'register_widgets');

    //function prova($a) {
    //    var_dump($a);
    //    return $a;
    //}
    //add_filter('sportspress_meta_boxes', 'prova');
    /**
     * Sets up theme defaults and registers support for various WordPress features.
     *
     * Note that this function is hooked into the after_setup_theme hook, which
     * runs before the init hook. The init hook is too late for some features, such
     * as indicating support for post thumbnails.
     */
    function basket_gardolo_3_0_setup()
    {
        /*
         * Make theme available for translation.
         * Translations can be filed in the /languages/ directory.
         * If you're building a theme based on components, use a find and replace
         * to change 'basket-gardolo-3-0' to the name of your theme in all the template files.
         */
        load_theme_textdomain('basket-gardolo-3-0', get_template_directory() . '/languages');

        // Add default posts and comments RSS feed links to head.
        add_theme_support('automatic-feed-links');

        /*
         * Let WordPress manage the document title.
         * By adding theme support, we declare that this theme does not use a
         * hard-coded <title> tag in the document head, and expect WordPress to
         * provide it for us.
         */
        add_theme_support('title-tag');

        /*
         * Enable support for Post Thumbnails on posts and pages.
         *
         * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
         */
        add_theme_support('post-thumbnails');

        add_image_size('basket-gardolo-3-0-featured-image', 640, 9999);
        add_image_size('basket-gardolo-3-0-thumbnail', 960, 9999);

        // This theme uses wp_nav_menu() in one location.
        register_nav_menus(array(
            'top' => esc_html__('Top', 'basket-gardolo-3-0'),
        ));

        /*
         * Switch default core markup for search form, comment form, and comments
         * to output valid HTML5.
         */
        add_theme_support('html5', array(
            'search-form',
            'comment-form',
            'comment-list',
            'gallery',
            'caption',
        ));

        /*
         * Enable support for Post Formats.
         * See https://developer.wordpress.org/themes/functionality/post-formats/
         */
        add_theme_support('post-formats', array(
            'aside',
            'image',
            'video',
            'quote',
            'link',
        ));

        // Set up the WordPress core custom background feature.
        add_theme_support('custom-background', apply_filters('basket_gardolo_3_0_custom_background_args', array(
            'default-color' => 'ffffff',
            'default-image' => '',
        )));

        //Add support to Featured content (provided by Jetpack)
        add_theme_support('featured-content', array(
            'filter' => 'basket_gardolo_3_0_get_featured_posts',
            'max_posts' => 20,
        ));

        add_theme_support('sportspress');

    }
endif;
add_action('after_setup_theme', 'basket_gardolo_3_0_setup');

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function basket_gardolo_3_0_content_width()
{
    $GLOBALS['content_width'] = apply_filters('basket_gardolo_3_0_content_width', 640);
}

add_action('after_setup_theme', 'basket_gardolo_3_0_content_width', 0);

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function basket_gardolo_3_0_widgets_init()
{
    register_sidebar(array(
        'name' => esc_html__('Sidebar One', 'basket-gardolo-3-0'),
        'id' => 'sidebar-1',
        'description' => '',
        'before_widget' => '<aside id="%1$s" class="widget %2$s">',
        'after_widget' => '</aside>',
        'before_title' => '<h2 class="widget-title">',
        'after_title' => '</h2>',
    ));

    register_sidebar(array(
        'name' => esc_html__('Sidebar Two', 'basket-gardolo-3-0'),
        'id' => 'sidebar-2',
        'description' => '',
        'before_widget' => '<aside id="%1$s" class="widget %2$s">',
        'after_widget' => '</aside>',
        'before_title' => '<h2 class="widget-title">',
        'after_title' => '</h2>',
    ));

    register_sidebar(array(
        'name' => 'Gardolo Sidebar',
        'id' => 'gardolo-sidebar',
        'description' => '',
        'before_widget' => '<aside id="%1$s" class="widget %2$s">',
        'after_widget' => '</aside>',
        'before_title' => '<h2 class="widget-title">',
        'after_title' => '</h2>',
    ));
}

add_action('widgets_init', 'basket_gardolo_3_0_widgets_init');

function add_giornalino_download ($text) {
    if (get_post_type() == 'giornalino') {
        $file = get_field('file');
        return '<div class="download"><a href="' . $file['url'] . '"><img src="' . get_template_directory_uri() .'/assets/images/giornalino.jpg"></a></div>';
    }
    return $text;
}

add_filter('the_content', 'add_giornalino_download');

if (!function_exists('get_team_page_from_player')) :
    function get_team_page_from_player($id)
    {
        $result = [];
        $pages = get_pages(array(
            'post_status' => 'publish'
        ));
        foreach ($pages as $page) {
            if (has_shortcode($page->post_content, 'player_list')) {
                $pattern = get_shortcode_regex();
                preg_match('/' . $pattern . '/s', $page->post_content, $matches);
                if ($matches) :
                    if (is_array($matches) && $matches[2] == 'player_list') {
                        $team_id = shortcode_parse_atts($matches[0])['id'];
                        $leagues = sp_get_the_term_ids($team_id, 'sp_league');
                        $seasons = sp_get_the_term_ids($team_id, 'sp_season');
                        $args = array(
                            'post_type' => 'sp_player',
                            'numberposts' => -1,
                            'posts_per_page' => -1,
                            'meta_key' => 'sp_number',
                            'orderby' => 'meta_value_num',
                            'order' => 'ASC',
                            // Look only for players who played in this specific league / season / team 
                            'meta_query' => array(
                                array(
                                    'key' => 'sp_assignments',
                                    'value' => intval($leagues[0]).'_'.intval($seasons[0]).'_'.intval(get_post_meta($team_id, 'sp_team', true))
                                ),
                            )
                        );
                        $players = get_posts($args);
                        foreach ($players as $player) {
                            if ($player->ID == $id) {
                                $result[] = $page;
                                break;
                            }
                        }
                    }
                endif;
            }
        }
        return $result;
    }
endif;

if (!function_exists('player_data')) :
    function player_data($id, $season_id)
    {
        $points = 0;
        $presence = 0;
        $args = array(
            'post_type' => 'sp_event',
            'numberposts' => -1,
            'posts_per_page' => -1,
            'order' => 'DESC',
            'meta_query' => array(
                array(
                    'key' => 'sp_player',
                    'value' => $id
                )
            ),
            'tax_query' => array(
                'relation' => 'AND',
                array(
                    'taxonomy' => 'sp_season',
                    'field' => 'term_id',
                    'terms' => $season_id
                )
            ),
        );
        $matches = get_posts($args);
        foreach ($matches as $match) {
            $team_performance = (array)get_post_meta($match->ID, 'sp_players', true);
            foreach ($team_performance as $team_id => $players) {
                if (is_array($players) && array_key_exists($id, $players)) {
                    $presence++;
                    $points += $players[$id]['pts'];
                }
            }
        }
        return array(
            'pts' => $points,
            'presence' => $presence
        );
    }
endif;

if (!function_exists('get_points_from_player')) :
    function get_points_from_player($id)
    {
        $player = new SP_Player($id);
        $term_arr = array(
            'taxonomy' => 'sp_season'
        );
        $result = [];
        $seasons = get_terms($term_arr);
        foreach ($seasons as $season) {
            $player_data = player_data($id, $season->term_id);
            if ($player_data['presence'] > 0)
                $result[$season->name] = player_data($id, $season->term_id);
        }
        return $result;
    }
endif;

function add_sponsor($text = '', $echo = false) {
    if (is_archive())
        return $text;
    if (is_home() || is_front_page())
        return $text;
    $post_arr = array(
        'post_type' => 'sponsor',
        'orderby' => 'rand',
        'post_per_page' => 1
    );
    $sponsor = get_posts($post_arr)[0];
    $content = '<div class="content-sponsor"><div class="sponsor-separator">sponsor</div>';
    $content .= '<div class="content-sponsor-inner">';
    $id = $sponsor->ID;
    $link = get_field('link', $id);
    $facebook = get_field('facebook', $id);
    $luogo = get_field('luogo', $id);
    $image = get_field('immagine', $id)['url'];
    if ($link)
        $content .= sprintf('<a href="%s" target="_blank">', $link);
    $content .= sprintf('<img src="%s">', $image);
    if ($link)
        $content .= '</a>';
    $content .= '<div class="sponsor-buttons">';
    if ($facebook)
        $content .= sprintf('<div class="facebook"><a href="%s" target="_blank">Pagina Facebook <img src="%s/assets/images/facebook-icon.png"></a></div>', $facebook, get_template_directory_uri());
    if ($luogo)
        $content .= sprintf('<div class="maps"><a href="https://www.google.it/maps?z=14&q=loc:%s,%s" target="_blank">Maps<img src="%s/assets/images/maps-icon.png"></a></div>', $luogo['lat'], $luogo['lng'], get_template_directory_uri());
    $content .= '</div></div></div>';
    return $text . $content;
}
add_filter( 'the_content', 'add_sponsor', 18 );

/**
 * Register Oswald font.
 *
 * @return string
 */
function basket_gardolo_3_0_oswald_fonts_url()
{
    $fonts_url = '';
    $font_families[] = 'Oswald:300,400,700';
    $font_families[] = 'Bitter:300,400,700';
    $query_args = array(
        'family' => urlencode(implode('|', $font_families)),
        'subset' => urlencode('latin,latin-ext'), // add extra subset
    );
    $fonts_url = add_query_arg($query_args, 'https://fonts.googleapis.com/css');

    return $fonts_url;
}

/**
 * Register Oswald font.
 *
 * @return string
 */
function basket_gardolo_3_0_lato_fonts_url()
{
    $fonts_url = '';
    $font_family = 'Lato:300,400,700';
    $query_args = array(
        'family' => urlencode($font_family),
        'subset' => urlencode('latin,latin-ext'), // add extra subset
    );
    $fonts_url = add_query_arg($query_args, 'https://fonts.googleapis.com/css');

    return $fonts_url;
}

/**
 * Enqueue scripts and styles.
 */
function basket_gardolo_3_0_scripts()
{
    wp_enqueue_style('basket-gardolo-3-0-style', get_stylesheet_uri());

    wp_enqueue_style('basket-gardolo-3-0-oswald', basket_gardolo_3_0_oswald_fonts_url());

    wp_enqueue_style('basket-gardolo-3-0-lato', basket_gardolo_3_0_lato_fonts_url());

    wp_enqueue_script('basket-gardolo-3-0-navigation', get_template_directory_uri() . '/assets/js/navigation.js', array(), '20151215', true);

    wp_enqueue_script('basket-gardolo-3-0-skip-link-focus-fix', get_template_directory_uri() . '/assets/js/skip-link-focus-fix.js', array(), '20151215', true);

    wp_enqueue_script('basket-gardolo-3-0-script', get_template_directory_uri() . '/assets/js/functions.js', array('jquery'), '20150715', true);

    if (is_singular() && comments_open() && get_option('thread_comments')) {
        wp_enqueue_script('comment-reply');
    }
}

function set_event_metadata($templates)
{
    global $post;
    if ($post) {
        $event = new SP_Event($post->ID);
        if ($event->status() === 'results') {
            $templates = array_intersect_key($templates, array_flip(array('logos', 'excerpt', 'content', 'video', 'results', 'performance', 'tabs')));
            return $templates;
        }
    }
    return $templates;
}

add_filter('sportspress_event_templates', 'set_event_metadata');

function set_player_metadata($templates)
{
    global $post;
    if ($post) {
        $player = new SP_Player($post->ID);
        $res = [];
        foreach ($templates as $name => $template) {
            if ($name == 'statistics') {
                $res[$name] = array(
                    'action' => 'basket_gardolo_statistics',
                    'option' => 'show_basket_gardolo_statistics',
                    'default' => 'yes'
                );
            } else {
                $res[$name] = $template;
            }
        }
        return $res;
    }
    return $templates;
}

add_filter('sportspress_player_templates', 'set_player_metadata');

function wpcodex_add_excerpt_support_for_pages()
{
    add_post_type_support('wpcm_match', 'comments');
}

add_action('wp_enqueue_scripts', 'basket_gardolo_3_0_scripts');

add_action('init', 'wpcodex_add_excerpt_support_for_pages');

function disable_wordpress_emojis() {
    remove_action('wp_head', 'print_emoji_detection_script', 7);
    remove_action('admin_print_scripts', 'print_emoji_detection_script');
    remove_action('wp_print_styles', 'print_emoji_styles');
    remove_action('admin_print_styles', 'print_emoji_styles');
    remove_filter('the_content_feed', 'wp_staticize_emoji');
    remove_filter('comment_text_rss', 'wp_staticize_emoji');
    remove_filter('wp_mail', 'wp_staticize_emoji_for_email');
    add_filter('tiny_mce_plugins', 'disable_emojis_tinymce');
    add_filter('wp_resource_hints', 'disable_emojis_remove_dns_prefetch', 10, 2);
}
add_action( 'init', 'disable_wordpress_emojis' );

/**
* Filter function used to remove the tinymce emoji plugin.
*
* @param array $plugins
* @return array Difference betwen the two arrays
*/
function disable_emojis_tinymce( $plugins ) {
    if ( is_array( $plugins ) ) {
        return array_diff( $plugins, array( 'wpemoji' ) );
    } else {
        return array();
    }
}

/**
* Remove emoji CDN hostname from DNS prefetching hints.
*
* @param array $urls URLs to print for resource hints.
* @param string $relation_type The relation type the URLs are printed for.
* @return array Difference betwen the two arrays.
*/
function disable_emojis_remove_dns_prefetch( $urls, $relation_type ) {
    if ( 'dns-prefetch' == $relation_type ) {
        /** This filter is documented in wp-includes/formatting.php */
        $emoji_svg_url = apply_filters( 'emoji_svg_url', 'https://s.w.org/images/core/emoji/2/svg/' );
        $urls = array_diff( $urls, array( $emoji_svg_url ) );
    }
    return $urls;
}

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Custom functions that act independently of the theme templates.
 */
require get_template_directory() . '/inc/extras.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
require get_template_directory() . '/inc/jetpack.php';


/**
 * Load team template for players
 */
require get_template_directory() . '/components/single_player/content-team-page.php';

class SP_Meta_Box_Player_Details_Gardolo
{

    /**
     * Output the metabox
     */
    public static function output($post)
    {
        wp_nonce_field('sportspress_save_data', 'sportspress_meta_nonce');
        $continents = SP()->countries->continents;

        $number = get_post_meta($post->ID, 'sp_number', true);
        $nationalities = get_post_meta($post->ID, 'sp_nationality', false);
        foreach ($nationalities as $index => $nationality):
            if (2 == strlen($nationality)):
                $legacy = SP()->countries->legacy;
                $nationality = strtolower($nationality);
                $nationality = sp_array_value($legacy, $nationality, null);
                $nationalities[$index] = $nationality;
            endif;
        endforeach;

        if (taxonomy_exists('sp_league')):
            $leagues = get_the_terms($post->ID, 'sp_league');
            $league_ids = array();
            if ($leagues):
                foreach ($leagues as $league):
                    $league_ids[] = $league->term_id;
                endforeach;
            endif;
        endif;

        if (taxonomy_exists('sp_season')):
            $seasons = get_the_terms($post->ID, 'sp_season');
            $season_ids = array();
            if ($seasons):
                foreach ($seasons as $season):
                    $season_ids[] = $season->term_id;
                endforeach;
            endif;
        endif;

        if (taxonomy_exists('sp_position')):
            $positions = get_the_terms($post->ID, 'sp_position');
            $position_ids = array();
            if ($positions):
                foreach ($positions as $position):
                    $position_ids[] = $position->term_id;
                endforeach;
            endif;
        endif;

        $teams = get_posts(array('post_type' => 'sp_team', 'posts_per_page' => -1));
        $past_teams = array_filter(get_post_meta($post->ID, 'sp_past_team', false));
        $current_teams = array_filter( get_post_meta( $post->ID, 'sp_current_team', false ) );
        $current_team = array_values(array_filter($teams, function ($team) {
            return strpos($team->post_title, 'Bc Gardolo') !== false;
        }));
        ?>
        <p><strong><?php _e('Squad Number', 'sportspress'); ?></strong></p>
        <p><input type="text" size="4" id="sp_number" name="sp_number" value="<?php echo $number; ?>"></p>

        <p><strong><?php _e('Nationality', 'sportspress'); ?></strong></p>
        <p><select id="sp_nationality" name="sp_nationality[]"
                   data-placeholder="<?php printf(__('Select %s', 'sportspress'), __('Nationality', 'sportspress')); ?>"
                   class="widefat chosen-select<?php if (is_rtl()): ?> chosen-rtl<?php endif; ?>" multiple="multiple">
                <option value=""></option>
                <?php foreach ($continents as $continent => $countries): ?>
                    <optgroup label="<?php echo $continent; ?>">
                        <?php foreach ($countries as $code => $country): ?>
                            <option
                                value="<?php echo $code; ?>" <?php selected(in_array($code, $nationalities)); ?>><?php echo $country; ?></option>
                        <?php endforeach; ?>
                    </optgroup>
                <?php endforeach; ?>
            </select></p>

        <?php if (taxonomy_exists('sp_position')) { ?>
        <p><strong><?php _e('Positions', 'sportspress'); ?></strong></p>
        <p><?php
            $args = array(
                'taxonomy' => 'sp_position',
                'name' => 'tax_input[sp_position][]',
                'selected' => $position_ids,
                'values' => 'term_id',
                'placeholder' => sprintf(__('Select %s', 'sportspress'), __('Positions', 'sportspress')),
                'class' => 'widefat',
                'property' => 'multiple',
                'chosen' => true,
            );
            sp_dropdown_taxonomies($args);
            ?></p>
    <?php } ?>

        <?php if (apply_filters('sportspress_player_teams', true)) { ?>
        <p><strong><?php _e('Current Teams', 'sportspress'); ?></strong></p>
        <p><?php
            $args = array(
                'post_type' => 'sp_team',
                'name' => 'sp_current_team[]',
                'selected' => $current_teams,
                'p' => $current_team->ID,
                'values' => 'ID',
                'placeholder' => sprintf(__('Select %s', 'sportspress'), __('Teams', 'sportspress')),
                'class' => 'sp-current-teams widefat',
                'property' => 'multiple',
                'chosen' => true,
            );
            sp_dropdown_pages($args);
            ?></p>

        <p><strong><?php _e('Past Teams', 'sportspress'); ?></strong></p>
        <p><?php
            $args = array(
                'post_type' => 'sp_team',
                'name' => 'sp_past_team[]',
                'selected' => $past_teams,
                'values' => 'ID',
                'placeholder' => sprintf(__('Select %s', 'sportspress'), __('Teams', 'sportspress')),
                'class' => 'sp-past-teams widefat',
                'property' => 'multiple',
                'chosen' => true,
            );
            sp_dropdown_pages($args);
            ?></p>
    <?php } ?>

        <?php if (taxonomy_exists('sp_league')) { ?>
        <p><strong><?php _e('Competitions', 'sportspress'); ?></strong></p>
        <p><?php
            $args = array(
                'taxonomy' => 'sp_league',
                'name' => 'tax_input[sp_league][]',
                'selected' => $league_ids,
                'values' => 'term_id',
                'placeholder' => sprintf(__('Select %s', 'sportspress'), __('Competitions', 'sportspress')),
                'class' => 'widefat',
                'property' => 'multiple',
                'chosen' => true,
            );
            sp_dropdown_taxonomies($args);
            ?></p>
    <?php } ?>

        <?php if (taxonomy_exists('sp_season')) { ?>
        <p><strong><?php _e('Seasons', 'sportspress'); ?></strong></p>
        <p><?php
            $args = array(
                'taxonomy' => 'sp_season',
                'name' => 'tax_input[sp_season][]',
                'selected' => $season_ids,
                'values' => 'term_id',
                'placeholder' => sprintf(__('Select %s', 'sportspress'), __('Seasons', 'sportspress')),
                'class' => 'widefat',
                'property' => 'multiple',
                'chosen' => true,
            );
            sp_dropdown_taxonomies($args);
            ?></p>
    <?php } ?>
        <?php
    }

    /**
     * Save meta box data
     */
    public static function save($post_id, $post)
    {
        update_post_meta($post_id, 'sp_number', esc_attr(sp_array_value($_POST, 'sp_number', '')));
        sp_update_post_meta_recursive($post_id, 'sp_nationality', sp_array_value($_POST, 'sp_nationality', array()));
        sp_update_post_meta_recursive($post_id, 'sp_current_team', sp_array_value($_POST, 'sp_current_team', array()));
        sp_update_post_meta_recursive($post_id, 'sp_past_team', sp_array_value($_POST, 'sp_past_team', array()));
        sp_update_post_meta_recursive($post_id, 'sp_team', array_merge(array(sp_array_value($_POST, 'sp_current_team', array())), sp_array_value($_POST, 'sp_past_team', array())));
    }
}

function add_gardolo_meta_boxes($meta_boxes)
{
    $meta_boxes['sp_player']['details'] = array(
        'title' => __('Details', 'sportspress'),
        'save' => 'SP_Meta_Box_Player_Details_Gardolo::save',
        'output' => 'SP_Meta_Box_Player_Details_Gardolo::output',
        'context' => 'side',
        'priority' => 'default',
    );
    return $meta_boxes;
}

add_filter('sportspress_meta_boxes', 'add_gardolo_meta_boxes');
remove_filter('previous_post_link', 'sportspress_hide_adjacent_post_links');
remove_filter('next_post_link', 'sportspress_hide_adjacent_post_links');
function gardolo_hide_adjacent_post_links( $output = null, $format = null, $link = null, $post = null ) {
    if ( is_object( $post ) && property_exists( $post, 'post_type' ) && in_array( $post->post_type, array('sp_calendar', 'sp_team', 'sp_table', 'sp_player', 'sp_list', 'sp_staff' ) ) )
        return false;
    return $output;
}
add_filter( 'previous_post_link', 'gardolo_hide_adjacent_post_links', 10, 4 );
add_filter( 'next_post_link', 'gardolo_hide_adjacent_post_links', 10, 4 );
