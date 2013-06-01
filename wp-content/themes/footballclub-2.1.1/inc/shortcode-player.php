<?php
add_shortcode( 'tb_player', 'tb_player_shortcode' );
function tb_player_shortcode( $atts, $content = null, $code = "" ) {
	extract( shortcode_atts( array(
		'id' => null,
		'show_number' => get_option( 'tb_player_profile_show_number' ),
		'show_name' => get_option( 'tb_player_profile_show_name' ),
		'show_dob' => get_option( 'tb_player_profile_show_dob' ),
		'show_age' => get_option( 'tb_player_profile_show_age' ),
		'show_season' => get_option( 'tb_player_profile_show_season' ),
		'show_team' => get_option( 'tb_player_profile_show_team' ),
		'show_position' => get_option( 'tb_player_profile_show_position' ),
		'show_appearances' => get_option( 'tb_player_profile_show_appearances' ),
		'show_goals' => get_option( 'tb_player_profile_show_goals' ),
		'show_assists' => get_option( 'tb_player_profile_show_assists' ),
		'show_joined' => get_option( 'tb_player_profile_show_joined' ),
		'show_hometown' => get_option( 'tb_player_profile_show_hometown' )
	), $atts ) );
	if ( $id == null )
		return false;
	global $tb_soccer_positions;
	global $tb_countries_of_the_world;
	global $tb_default_images;
	$player = get_post( $id );
	
	$output = '';
	$output .= '<div class="profile-image">';
	if ( get_the_post_thumbnail( $id, 'profile-image' ) != null )
		$output .= get_the_post_thumbnail( $id, 'profile-image', array( 'title' => get_the_title( $id ) ) );
	else
		$output .= '<img src="' . $tb_default_images['player'] . '" />';
	$output .= '</div>';
	
	$profile_details = array();
	
	// number
	if ( $show_number)
		$profile_details[ __( 'Number', 'themeboy' ) ] = get_post_meta( $id, 'tb_number', true );
	
	// name
	if ( $show_name )
		$profile_details[ __( 'Name', 'themeboy' ) ] = get_the_title( $id );
	
	// birthday
	if ( $show_dob )
		$profile_details[ __( 'Birthday', 'themeboy' ) ] = date_i18n( get_option( 'date_format' ), strtotime( get_post_meta( $id, 'tb_dob', true ) ) );
	
	// age
	if ( $show_age )
		$profile_details[__('Age', 'themeboy')] = get_age( get_post_meta( $id, 'tb_dob', true ) );
	
	// season
	if ( $show_season ) {
		$seasons = get_the_terms( $id, 'tb_season' );
		if ( is_array( $seasons ) ) {
			$player_seasons = array();
			foreach ( $seasons as $season ) {
				$player_seasons[] = $season->name;
			}
			$profile_details[ __('Season', 'themeboy') ] = implode( ', ', $player_seasons );
		}
	}
	
	// team
	if ( $show_team ) {
		$teams = get_the_terms( $id, 'tb_team' );
		if ( is_array( $teams ) ) {
			$player_teams = array();
			foreach ( $teams as $team ) {
				$player_teams[] = $team->name;
			}
			$profile_details[ __('Team', 'themeboy') ] = implode( ', ', $player_teams );
		}
	}
	
	// position
	if ( $show_position ) {
		$positions = get_the_terms( $id, 'tb_position' );
		if ( is_array( $positions ) ) {
			$player_positions = array();
			foreach ( $positions as $position ) {
				$player_positions[] = $position->name;
			}
			$profile_details[ __('Position', 'themeboy') ] = implode( ', ', $player_positions );
		}
	}
	
	// stats
	$stats = get_tb_player_stats( $id );
	
	if ( $show_appearances )
		$profile_details[ __( 'Appearances', 'themeboy' ) ] = $stats[0][0]['total']['appearances'];
		
	if ( $show_goals )
		$profile_details[ __( 'Goals', 'themeboy' ) ] = $stats[0][0]['total']['goals'];
		
	if ( $show_assists )
		$profile_details[ __( 'Assists', 'themeboy' ) ] = $stats[0][0]['total']['assists'];
	
	// joined
	if ( $show_joined )
		$profile_details[ __( 'Joined', 'themeboy' ) ] = date_i18n( get_option( 'date_format' ), strtotime( $player->post_date ) );
	
	// nationality
	if ( $show_hometown ) {
		$natl = get_post_meta( $id, 'tb_natl', true );
		$hometown = get_post_meta( $id, 'tb_hometown', true );
		$profile_details[ __( 'Hometown', 'themeboy' ) ] = '<img class="flag" src="'.get_bloginfo('template_directory').'/images/flags/' . $natl . '.png" /> ' . $hometown;
	}
	
	$count = 0;
	$size = sizeof( $profile_details );
	if ( $size > 0 ) {
		$output .=
		'<section class="profile-details">' .
			'<table>' .
				'<tbody>';
			
		foreach ( $profile_details as $key => $value ) {
			$count++;
			$output .=
			'<tr class="'.( $count % 2 == 0 ? 'even' : 'odd').( $count >= $size ? ' last' : '').'">' .
				'<th>'.$key.'</th>' .
				'<td>'.$value.'</td>' .
			'</tr>';
		}
		$output .=
				'</tbody>' .
			'</table>' .
		'</section>';
	}
	if ( $player->post_content ) {
		$output .= '<div class="clear"></div>';
		$output .=
		'<section class="profile-bio">' .
			'<h3>' . __( 'Profile', 'themeboy' ) . '</h3>' .
			'<div class="inner">' . apply_filters( 'the_content', $player->post_content ) . '</div>' .
		'</section>';
	}
	return $output;
}
?>