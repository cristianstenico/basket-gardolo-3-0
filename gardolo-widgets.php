<?php
/**
 * Created by PhpStorm.
 * User: cristian
 * Date: 23/01/17
 * Time: 23.21
 */
class Gardolo_Widget_Countdown extends WP_Widget {

    function __construct() {
        $widget_ops = array('classname' => 'widget_sportspress widget_gardolo_countdown widget_sp_countdown', 'description' => __( 'Gardolo countdown', 'sportspress' ) );
        parent::__construct('gardolo-countdown', 'Gardolo', $widget_ops);
    }

    function widget( $args, $instance ) {
        global $competition;
        global $team_id;
        extract($args);
        $post_arr = array(
            'post_type' => 'sp_calendar',
            'tax_query' => array(
                array(
                    'taxonomy' => 'sp_league',
                    'field' => 'term_id',
                    'terms' => $competition[0]->term_id
                )
            ),
            'meta_query' => array(
                array(
                   'key' => 'sp_team',
                   'value' => $team_id
                ),
            )
        );
        $calendar = get_posts($post_arr);
        $date_from = null;
        $date_to = null;
        if ($calendar){
            $calendar = new SP_Calendar($calendar[0]->ID);
            $calendar->status = 'future';
            $events = $calendar->data();
            if ($events && count($events) > 1) {
                $date_from = date('Y-m-d H:i:s', strtotime("-1 day", strtotime($events[1]->post_date)));
                $date_to = date('Y-m-d H:i:s', strtotime("+1 day", strtotime($events[count($events) - 1]->post_date)));
            }
        }

        echo $before_widget;

        echo $before_title . 'Prossime partite di ' . $competition[0]->name . $after_title;

        sp_get_template( 'countdown.php', array( 'team' => $team_id, 'league' => $competition[0]->term_id, 'show_venue' => true, 'show_logos' => true ) );

        sp_get_template( 'event-blocks.php', array( 'id' => $calendar->ID, 'status' => 'future', 'date' => 'range', 'date_from' => $date_from, 'date_to' => $date_to, 'number' => 3, 'order' => 'ASC', 'show_all_events_link' => false ) );

        echo $before_title . 'Ultimi risultati di ' . $competition[0]->name . $after_title;

        sp_get_template( 'event-blocks.php', array( 'id' => $calendar->ID, 'status' => 'publish', 'date' => 'default', 'number' => 3, 'order' => 'DESC', 'show_all_events_link' => true ) );


        echo $after_widget;
    }

    function update( $new_instance, $old_instance ) {
        $instance = $old_instance;
        $instance['title'] = strip_tags($new_instance['title']);
        $instance['team'] = intval($new_instance['team']);
        $instance['caption'] = strip_tags($new_instance['caption']);
        $instance['id'] = intval($new_instance['id']);
        $instance['show_venue'] = intval($new_instance['show_venue']);
        $instance['show_league'] = intval($new_instance['show_league']);

        // Filter to hook into
        $instance = apply_filters( 'sportspress_widget_update', $instance, $new_instance, $old_instance, 'countdown' );

        return $instance;
    }

    function form( $instance ) {
        $instance = wp_parse_args( (array) $instance, array( 'title' => '', 'team' => '', 'id' => '', 'caption' => '', 'show_venue' => false, 'show_league' => false ) );
        $title = strip_tags($instance['title']);
        $caption = strip_tags($instance['caption']);
        $team = intval($instance['team']);
        $id = intval($instance['id']);
        $show_venue = intval($instance['show_venue']);
        $show_league = intval($instance['show_league']);

        // Action to hook into
        do_action( 'sportspress_before_widget_template_form', $this, $instance, 'countdown' );
        ?>

        <?php
        // Action to hook into
        do_action( 'sportspress_after_widget_template_form', $this, $instance, 'countdown' );
    }
}

class Gardolo_Widget_Sponsor extends WP_Widget {

    function __construct() {
        $widget_ops = array('classname' => 'widget_sportspress widget_sponsor widget_sp_sponsor', 'description' => __( 'Gardolo sponsor', 'sportspress' ) );
        parent::__construct('gardolo-sponsor', 'Gardolo Sponsor', $widget_ops);
    }

    function widget( $args, $instance ) {
        extract($args);
        $number = empty($instance['number']) ? 3 : $instance['number'];
        $post_arr = array(
            'post_type' => 'sponsor',
            'posts_per_page' => $number,
            'orderby' => 'rand'
        );
        $sponsors = get_posts($post_arr);

        echo $before_widget;

        echo $before_title . 'Sponsor' . $after_title;

        foreach($sponsors as $sponsor) {
            $id = $sponsor->ID;
            $link = get_field('link', $id);
            $facebook = get_field('facebook', $id);
            $luogo = get_field('luogo', $id);
            echo '<div class="sponsor">';
            if ($link) {
                printf('<a href="%s" target="_blank">', $link);
            }

            printf('<img src="%s">', get_field('immagine', $id)['url']);

            if ($link) {
                echo '</a>';
            }
            echo '<div class="links">';
            if ($facebook) {
                printf('<a href="%s" target="_blank"><img src="%s/assets/images/facebook-icon.png"></a>', $facebook, get_template_directory_uri());
            }
            if ($luogo) {
                printf('<a href="https://www.google.it/maps?z=14&q=loc:%s,%s" target="_blank"><img src="%s/assets/images/maps-icon.png"></a>', $luogo['lat'], $luogo['lng'], get_template_directory_uri());
            }

            echo '</div></div>';
        }

        echo $after_widget;
    }

    function update( $new_instance, $old_instance ) {
        $instance = $old_instance;
        $instance['number'] = intval($new_instance['number']);
        return $instance;
    }

    function form( $instance ) {
        $instance = wp_parse_args( (array) $instance, array( 'number' => '') );
        $number = intval($instance['number']);
        ?>
        <p>
            <label for="<?php echo $this->get_field_id('number'); ?>">Numero sponsor</label>
            <input class="widefat" id="<?php echo $this->get_field_id('number'); ?>" name="<?php echo $this->get_field_name('number'); ?>" type="text" value="<?php echo intval($number); ?>" />
        </p>
        <?php
    }
}