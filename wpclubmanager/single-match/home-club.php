<?php
/**
 * Single Match - Home Club
 *
 * @author 		ClubPress
 * @package 	WPClubManager/Templates
 * @version     1.3.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
global $wpclubmanager, $post;
$home_club = get_post_meta( $post->ID, 'wpcm_home_club', true );
$side1 = wpcm_get_team_name( $home_club, $post->ID );
?>

<div class="match-home-club">
	<?php echo $side1; ?>
</div>