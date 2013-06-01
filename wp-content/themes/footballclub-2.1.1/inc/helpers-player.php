<?php
// get empty stats row
if (!function_exists('get_tb_player_stats_empty_row')) {
	function get_tb_player_stats_empty_row() {
		global $tb_player_stats_labels;
		$output = array( 'appearances' => 0 );
		foreach( $tb_player_stats_labels as $key => $val ) {
			$output[$key] = 0;
		}
		return $output;
	}
}
// get total stats
if (!function_exists('get_tb_player_total_stats')) {
	function get_tb_player_total_stats( $post_id = null, $team = null, $season = null ) {
		$output = get_tb_player_stats_empty_row();
		$autostats = get_tb_player_auto_stats( $post_id, $team, $season);
		$manualstats = get_tb_player_manual_stats( $post_id, $team, $season);
		foreach( $output as $key => $val ) {
			$output[$key] = $autostats[$key] + $manualstats[$key];
		}
		return $output;
	}
}
// get manual stats
if (!function_exists('get_tb_player_manual_stats')) {
	function get_tb_player_manual_stats( $post_id = null, $team = null, $season = null ) {
		$output = get_tb_player_stats_empty_row();
		if ( empty ( $team ) ) $team = 0;
		if ( empty ( $season ) ) $season = 0;
		$stats = unserialize( get_post_meta( $post_id, 'tb_stats', true ) );
		if ( is_array( $stats ) && array_key_exists( $team, $stats ) ) {
			if ( is_array( $stats[$team] ) && array_key_exists ( $season, $stats[$team] ) ) {
				$output = $stats[$team][$season];
			}
		}
		return $output;
	}
}
// get auto stats
if (!function_exists('get_tb_player_auto_stats')) {
	function get_tb_player_auto_stats( $post_id = null, $team_id = null, $season_id = null ) {
		if ( !$post_id ) global $post_id;
		$club_id = get_post_meta( $post_id, 'tb_club', true );
		$output = get_tb_player_stats_empty_row();
		// get all home matches
		$args = array(
			'post_type' => 'tb_match',
			'tax_query' => array(),
			'showposts' => -1,
			'meta_query' => array(
				array(
					'key' => 'tb_home_club',
					'value' => $club_id
				)
			)
		);
		if ( isset( $season_id ) ) {
			$args['tax_query'][] = array(
				'taxonomy' => 'tb_season',
				'terms' => $season_id
			);
		}
		$matches = get_posts( $args );
		foreach( $matches as $match ) {
			$all_players = unserialize( get_post_meta( $match->ID, 'tb_players', true ) );
			if ( is_array( $all_players ) && array_key_exists( 'home', $all_players ) && is_array( $all_players['home'] ) ) {
				foreach( $all_players['home'] as $players ) {
					if ( is_array( $players ) && array_key_exists( $post_id, $players ) ) {
						$stats = $players[$post_id];
						$output['appearances'] ++;
						$output['goals'] += $stats['goals'];
						$output['assists'] += $stats['assists'];
						$output['yellowcards'] += $stats['yellowcards'];
						$output['redcards'] += $stats['redcards'];
					}
				}
			}
		}
		// get all away matches
		$args['meta_query'] = array(
			array(
				'key' => 'tb_away_club',
				'value' => $club_id
			)
		);
		$matches = get_posts( $args );
		foreach( $matches as $match ) {
			$all_players = unserialize( get_post_meta( $match->ID, 'tb_players', true ) );
			if ( is_array( $all_players ) && array_key_exists( 'away', $all_players ) && is_array( $all_players['away'] ) ) {
				foreach( $all_players['away'] as $players ) {
					if ( is_array( $players ) && array_key_exists( $post_id, $players ) ) {
						$stats = $players[$post_id];
						$output['appearances'] ++;
						$output['goals'] += $stats['goals'];
						$output['assists'] += $stats['assists'];
						$output['yellowcards'] += $stats['yellowcards'];
						$output['redcards'] += $stats['redcards'];
					}
				}
			}
		}
		return $output;
	}
}
// get stats
if (!function_exists('get_tb_player_stats')) {
	function get_tb_player_stats( $post_id = null ) {
		if ( !$post_id ) global $post_id;
		$output = array();
		$teams = get_the_terms( $post_id, 'tb_team' );
		$seasons = get_the_terms( $post_id, 'tb_season' );
		// combined season stats for combined team
		$stats = get_tb_player_auto_stats( $post_id );
		$output[0][0] = array(
			'auto' => $stats,
			'total' => $stats
		);
		// isolated season stats for combined team
		if ( is_array( $seasons ) ) {
			foreach ( $seasons as $season ) {
				$stats = get_tb_player_auto_stats( $post_id, null, $season->term_id );
				$output[0][$season->term_id] = array(
					'auto' => $stats,
					'total' => $stats
				);
			}
		}
		// manual stats
		$stats = (array)unserialize( get_post_meta( $post_id, 'tb_stats', true ) );
		if ( is_array( $stats ) ):
			foreach( $stats as $team_key => $team_val ):
				if ( is_array( $team_val ) && array_key_exists( $team_key, $output ) ):
					foreach( $team_val as $season_key => $season_val ):
						if ( array_key_exists ( $season_key, $output[$team_key] ) ) {
							$output[$team_key][$season_key]['manual'] = $season_val;
							foreach( $output[$team_key][$season_key]['total'] as $index_key => &$index_val ) {
								if ( array_key_exists( $index_key, $season_val ) )
								 $index_val += $season_val[$index_key];
							}
						}
					endforeach;
				endif;
			endforeach;
		endif;
		return $output;
	}
}
// club statistics table function
function tb_player_stats_table( $stats = array(), $team = 0, $season = 0 ) {
	global $tb_player_stats_labels;
	$stats_labels = array( 'appearances' => __( 'Appearances', 'themeboy' ) );
	$stats_labels = array_merge( $stats_labels, $tb_player_stats_labels );
	if ( array_key_exists( $team, $stats ) ): if ( array_key_exists( $season, $stats[$team] ) ):
		$stats = $stats[$team][$season];
	endif; endif;
?>
	<table>
		<thead>
			<tr>
				<td>&nbsp;</td>
				<?php foreach( $stats_labels as $key => $val ): ?>
					<th><?php echo $val; ?></th>
				<?php endforeach; ?>
			</tr>
		</thead>
		<tfoot>
			<tr>
				<th align="right">Total</th>
				<?php foreach( $stats_labels as $key => $val ): ?>
					<td><input type="text" data-index="<?php echo $key; ?>" value="<?php tb_stats_value( $stats, 'total', $key ); ?>" size="1" tabindex="-1" readonly /></td>
				<?php endforeach; ?>
			</tr>
		</tfoot>
		<tbody>
			<tr>
				<td align="right"><?php _e( 'Auto' ); ?></td>
				<?php foreach( $stats_labels as $key => $val ): ?>
					<td><input type="text" data-index="<?php echo $key; ?>" value="<?php tb_stats_value( $stats, 'auto', $key ); ?>" size="1" tabindex="-1" readonly /></td>
				<?php endforeach; ?>
			</tr>
			<tr>
				<td align="right"><?php _e( 'Manual', 'themeboy' ); ?></td>
				<?php foreach( $stats_labels as $key => $val ): ?>
					<td><input type="text" data-index="<?php echo $key; ?>" name="tb_stats[<?php echo $team; ?>][<?php echo $season; ?>][<?php echo $key; ?>]" value="<?php tb_stats_value( $stats, 'manual', $key ); ?>" size="1" /></td>
				<?php endforeach; ?>
			</tr>
		</tbody>
	</table>
<?php
}
?>