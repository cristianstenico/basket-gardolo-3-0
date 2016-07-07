<?php
/**
 * Results Widget
 *
 * @author 		Clubpress
 * @package 	WPClubManager/Templates
 * @version     1.3.2
 */

global $post;

$postid = get_the_ID();
$format = get_match_title_format();
$home_club = get_post_meta( $postid, 'wpcm_home_club', true );
$away_club = get_post_meta( $postid, 'wpcm_away_club', true );
$home_goals = get_post_meta( $postid, 'wpcm_home_goals', true );
$away_goals = get_post_meta( $postid, 'wpcm_away_goals', true );
$played = get_post_meta( $postid, 'wpcm_played', true );
$comps = get_the_terms( $postid, 'wpcm_comp' );
$comp_status = get_post_meta( $postid, 'wpcm_comp_status', true );
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

	echo '<a href="' . get_permalink( $postid ) . '">';
		echo '<div class="clubs">';
			echo '<h4 class="home-clubs">';
				echo '<div class="club-name">'. wpcm_get_team_name( $home_club, $postid ).'</div>';
				echo '<div class="score">' . ( $played ? $home_goals : '' ) . '</div>';
			echo '</h4>';
			echo '<h4 class="away-clubs">';
				echo '<div class="club-name">'.wpcm_get_team_name( $away_club, $postid ).'</div>';
				echo '<div class="score">' . ( $played ? $away_goals : '' ) . '</div>';
			echo '</h4>';
		echo '</div>';
	echo '</a>';
echo '</li>';