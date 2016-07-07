<?php
/**
 * Fixtures Widget
 *
 * @author 		Clubpress
 * @package 	WPClubManager/Templates
 * @version     1.3.0
 */

global $post;

$postid = get_the_ID();
$format = get_match_title_format();
$home_club = get_post_meta( $postid, 'wpcm_home_club', true );
$away_club = get_post_meta( $postid, 'wpcm_away_club', true );
$comps = get_the_terms( $postid, 'wpcm_comp' );
$comp_status = get_post_meta( $postid, 'wpcm_comp_status', true );
$seasons = get_the_terms( $postid, 'wpcm_season' );
$teams = get_the_terms( $postid, 'wpcm_team' );
	
echo '<li class="fixture">';

	echo '<div class="basket-fixture-meta">';

		if ( $show_team && is_array( $teams ) ):
			foreach ( $teams as $team ):
				echo '<span>' . $team->name . '</span>';
			endforeach;
		endif;
		echo '<span class="basket-wpcm-date">';
			if ( $show_date ) {
				echo the_time('j M');
			}	
		echo '</span>';
	echo '</div>';

	echo '<a href="' . get_post_permalink( $postid, false, true ) . '">';

		echo '<div class="clubs">';
			echo '<h4 class="home-clubs">';
				echo wpcm_get_team_name( $home_club, $postid );
			echo '</h4>';
			echo '<h4 class="away-clubs">';
				echo wpcm_get_team_name( $away_club, $postid );
			echo '</h4>';
		echo '</div>';
	echo '</a>';
echo '</li>';