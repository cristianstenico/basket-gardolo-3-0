<?php
/**
 * Single Match - Away Club
 *
 * @author 		ClubPress
 * @package 	WPClubManager/Templates
 * @version     1.3.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
global $wpclubmanager, $post;
$away_club = get_post_meta( $post->ID, 'wpcm_away_club', true );
$side2 = wpcm_get_team_name( $away_club, $post->ID );
 ?>

<div class="match-away-club">

	<?php echo $side2; ?>

</div>