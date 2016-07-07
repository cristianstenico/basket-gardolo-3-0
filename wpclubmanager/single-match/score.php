<?php
/**
 * Single Match - Score
 *
 * @author 		ClubPress
 * @package 	WPClubManager/Templates
 * @version     1.3.2
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $wpclubmanager, $post;

$format = get_match_title_format();
$sep = get_option( 'wpcm_match_goals_delimiter' );
$home_goals = get_post_meta( $post->ID, 'wpcm_home_goals', true );
$away_goals = get_post_meta( $post->ID, 'wpcm_away_goals', true );
$played = get_post_meta( $post->ID, 'wpcm_played', true );
if( !$played ) :
	$sep = get_option( 'wpcm_match_clubs_separator' );
endif;
$side1 = $home_goals;
$side2 = $away_goals;
?>

<div class="match-score">

	<?php
	if ( $played ) {
		echo $side1;
	}
	?>

	<span class="wpcm-match-score-delimiter"><?php echo $sep ?></span>

	<?php
	if ( $played ) {
		echo $side2;
	}
	?></div>