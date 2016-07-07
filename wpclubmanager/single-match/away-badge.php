<?php
/**
 * Single match - Away Badge
 *
 * @author 		ClubPress
 * @package 	WPClubManager/Templates
 * @version     1.3.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $post;
if(is_archive())
	return;

$format = get_match_title_format();
$away_club = get_post_meta( $post->ID, 'wpcm_away_club', true );
	if( has_post_thumbnail( $away_club ) ) :
		$badge = get_the_post_thumbnail( $away_club, 'crest-medium', array( 'class' => 'away-logo' ) );
 ?>

<div class="wpcm-match-away-club-badge">

	<?php echo $badge; ?>

</div>

<?php
endif;
?>