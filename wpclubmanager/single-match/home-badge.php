<?php
/**
 * Single match - Home Badge
 *
 * @author 		ClubPress
 * @package 	WPClubManager/Templates
 * @version     1.3.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $post;

$home_club = get_post_meta( $post->ID, 'wpcm_home_club', true );
if( has_post_thumbnail( $home_club ) ):
	$badge = get_the_post_thumbnail( $home_club, 'crest-medium', array( 'class' => 'home-logo' ) );
 ?>

<div class="wpcm-match-home-club-badge">

	<?php echo $badge; ?>

</div>
<?php
endif;
?>