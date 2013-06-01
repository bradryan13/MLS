<?php
add_shortcode( 'tb_match', 'tb_match_shortcode' );
function tb_match_shortcode( $atts, $content = null, $code = "" ) {
	extract( shortcode_atts( array(
		'id' => null
	), $atts ) );
	$post_id = $id;
	$match = get_post( $post_id );
	$output = '';
	$venues = get_the_terms( $post_id, 'tb_venue' );
	if ( is_array( $venues ) ) {
		$venue = reset($venues);
		$t_id = $venue->term_id;
		$venue_meta = get_option( "taxonomy_term_$t_id" );
		$address = $venue_meta['tb_address'];
	} else {
		$venue = null;
		$address = null;
	}
	$played = get_post_meta( $post_id, 'tb_played', true );
	$home_club = get_post_meta( $post_id, 'tb_home_club', true );
	$away_club = get_post_meta( $post_id, 'tb_away_club', true );
	$home_goals = get_post_meta( $post_id, 'tb_home_goals', true );
	$away_goals = get_post_meta( $post_id, 'tb_away_goals', true );
	$date = date_i18n( get_option( 'date_format' ), strtotime( $match->post_date ) );
	$time = date_i18n( get_option( 'time_format' ), strtotime( $match->post_date ) );
	
	$output .= '<article><div class="entry-content match-info">';
	$output .=
		'<div class="teams">' .
		get_the_post_thumbnail( $home_club, 'crest-medium', array( 'class' => 'home-logo' ) ) .
		'<span>' . ' ' . get_option( 'tb_match_club_delimiter' ) . ' ' . '</span>' .
		get_the_post_thumbnail( $away_club, 'crest-medium', array( 'class' => 'home-logo' ) ) .
		'</div>' .
		'<div class="date">' . $date . '</div>';
		if ( $played )
			$output .= '<div class="score">' . __( 'Score' , 'themeboy' ) . ': ' . $home_goals . ' ' . get_option( 'tb_match_goals_delimiter' ) . ' ' . $away_goals . '</div>';
		else
			$output .= '<time>' . $time . '</time>';
		$output .= '<div class="clear"></div>';
		if ( $played ) {
			if ( $match->post_content ) {
				$output .= '<section><h3>' . __( 'Match Report', 'themeboy' ) .  '</h3><div class="inner">' . apply_filters( 'the_content', $match->post_content ) . '</div></section>';
			}
			$players = unserialize( get_post_meta( $post_id, 'tb_players', true ) );
			if ( array_key_exists( 'home', $players ) && is_array( $players['home'] ) && array_key_exists( 'away', $players ) && is_array( $players['away'] ) ) {
				$output .=
				'<section class="tb_match_statistics left-section clearfix">' .
					'<h3>' . __( 'Home', 'themeboy' ) . '</h3>' .
					'<table>' .
						'<tbody>';
						$count = 0;
						if ( array_key_exists( 'lineup', $players['home'] ) && is_array( $players['home']['lineup'] ) ) {
							foreach( $players['home']['lineup'] as $key => $value) {
								$count ++;
								$output .= tb_match_player_row( $key, $value, $count );
							}
						}
						$output .=
						'</tbody>' .
					'</table>';
				if ( array_key_exists( 'subs', $players['home'] ) && is_array( $players['home']['subs'] ) ) {
					$output .=
					'<table>' .
						'<thead><tr><th colspan="3">' . _x( 'Subs', 'team', 'themeboy' ) . '</th></tr></thead>' .
						'<tbody>';
						$count = 0;
						foreach( $players['home']['subs'] as $key => $value) {
							$count ++;
							$output .= tb_match_player_row( $key, $value, $count );
						}
						$output .=
						'</tbody>' .
					'</table>';
				}
				$output .=
				'</section>' .
				'<section class="tb_match_statistics right-section clearfix">' .
					'<h3>' . __( 'Away', 'themeboy' ) . '</h3>' .
					'<table>' .
						'<tbody>';
						$count = 0;
						if ( array_key_exists( 'lineup', $players['away'] ) && is_array( $players['away']['lineup'] ) ) {
							foreach( $players['away']['lineup'] as $key => $value) {
								$count ++;
								$output .= tb_match_player_row( $key, $value, $count );
							}
						}
						$output .=
						'</tbody>' .
					'</table>';
					if ( array_key_exists( 'subs', $players['away'] ) && is_array( $players['away']['subs'] ) ) {
					$output .=
					'<table>' .
						'<thead><tr><th colspan="3">' . _x( 'Subs', 'team', 'themeboy' ) . '</th></tr></thead>' .
						'<tbody>';
						$count = 0;
						foreach( $players['away']['subs'] as $key => $value) {
							$count ++;
							$output .= tb_match_player_row( $key, $value, $count );
						}
						$output .=
						'</tbody>' .
					'</table>';
					}
				$output .=
				'</section>';
			} else {
				// Lineup and Subs sections
				if ( array_key_exists( 'home', $players ) && is_array( $players['home'] ) ) {
					if ( array_key_exists( 'lineup', $players['home'] ) && is_array( $players['home']['lineup'] ) ) {
						$output .=
						'<section class="tb_match_statistics left-section clearfix">' .
							'<h3>' . __( 'Lineup', 'themeboy' ) . '</h3>' .
							'<table>' .
								'<tbody>';
								$count = 0;
								foreach( $players['home']['lineup'] as $key => $value) {
									$count ++;
									$output .= tb_match_player_row( $key, $value, $count );
								}
								$output .=
								'</tbody>' .
							'</table>' .
						'</section>';
					}
					if ( array_key_exists( 'subs', $players['home'] ) && is_array( $players['home']['subs'] ) ) {
						$output .=
						'<section class="tb_match_statistics right-section clearfix">' .
							'<h3>' . __( 'Subs', 'themeboy' ) . '</h3>' .
							'<table>' .
								'<tbody>';
								$count = 0;
								foreach( $players['home']['subs'] as $key => $value) {
									$count ++;
									$output .= tb_match_player_row( $key, $value, $count );
								}
								$output .=
								'</tbody>' .
							'</table>' .
						'</section>';
					}
				} elseif ( array_key_exists( 'away', $players ) && is_array( $players['away']) ) {
					if ( array_key_exists( 'lineup', $players['away'] ) && is_array( $players['away']['lineup'] ) ) {
						$output .=
						'<section class="tb_match_statistics left-section clearfix">' .
							'<h3>' . __( 'Lineup', 'themeboy' ) . '</h3>' .
							'<table>' .
								'<tbody>';
								$count = 0;
								foreach( $players['away']['lineup'] as $key => $value) {
									$count ++;
									$output .= tb_match_player_row( $key, $value, $count );
								}
								$output .=
								'</tbody>' .
							'</table>' .
						'</section>';
					}
					if ( array_key_exists( 'subs', $players['away'] ) && is_array( $players['away']['subs'] ) ) {
						$output .=
						'<section class="tb_match_statistics right-section clearfix">' .
							'<h3>' . __( 'Subs', 'themeboy' ) . '</h3>' .
							'<table>';
								'<tbody>';
								$count = 0;
								foreach( $players['away']['subs'] as $key => $value) {
									$count ++;
									$output .= tb_match_player_row( $key, $value, $count );
								}
								$output .=
								'</tbody>' .
							'</table>' .
						'</section>';
					}
				}
			}
		} else {
			if ( $venue ) {
				$output .=
				'<section class="venue-info clearfix">' .
					'<h3>' . __( 'Venue Information', 'themeboy' ) . '</h3>' .
					do_shortcode( '[tb_map address="' . $address . '" width="320" height="480"]' ) .
					'<div class="details' . ( $address ? ' with-map' : '' ) . '">' .
					'<h4>' . $venue->name . '</h4>';
					if ( $address )
						$output .= '<p class="address">' . $address . '</p>';
					if ( $venue->description )
						$output .= '<p class="description">' . nl2br( $venue->description ) . '</p>';
					$output .=
						'</div>' .
					'</dl>' .
				'</section>';
			}
		}
	$output .= '</div><!-- .entry-content --></article>';
	 
	return $output;
}
?>