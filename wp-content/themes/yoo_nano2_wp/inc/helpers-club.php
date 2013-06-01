<?php
// get empty stats row
if (!function_exists('get_tb_club_stats_empty_row')) {
	function get_tb_club_stats_empty_row() {
		global $tb_standings_stats_labels;
		$output = array();
		foreach( $tb_standings_stats_labels as $key => $val ) {
			$output[$key] = 0;
		}
		return $output;
	}
}
// get total stats
if (!function_exists('get_tb_club_total_stats')) {
	function get_tb_club_total_stats( $post_id = null, $comp = null, $season = null ) {
		$output = get_tb_club_stats_empty_row();
		$autostats = get_tb_club_auto_stats( $post_id, $comp, $season);
		$manualstats = get_tb_club_manual_stats( $post_id, $comp, $season);
		foreach( $output as $key => $val ) {
			$output[$key] = $autostats[$key] + $manualstats[$key];
		}
		return $output;
	}
}
// get manual stats
if (!function_exists('get_tb_club_manual_stats')) {
	function get_tb_club_manual_stats( $post_id = null, $comp = null, $season = null ) {
		$output = get_tb_club_stats_empty_row();
		if ( empty ( $comp ) ) $comp = 0;
		if ( empty ( $season ) ) $season = 0;
		$stats = unserialize( get_post_meta( $post_id, 'tb_stats', true ) );
		if ( is_array( $stats ) && array_key_exists( $comp, $stats ) ) {
			if ( is_array( $stats[$comp] ) && array_key_exists ( $season, $stats[$comp] ) ) {
				$output = $stats[$comp][$season];
			}
		}
		return $output;
	}
}
// get auto stats
if (!function_exists('get_tb_club_auto_stats')) {
	function get_tb_club_auto_stats( $post_id = null, $comp = null, $season = null ) {
		if ( !$post_id ) global $post_id;
		$output = get_tb_club_stats_empty_row();
		// get all home matches
		$args = array(
			'post_type' => 'tb_match',
			'meta_key' => 'tb_home_club',
			'meta_value' => $post_id,
			'tax_query' => array(),
			'showposts' => -1
		);
		if ( isset( $comp ) ) {
			$args['tax_query'][] = array(
				'taxonomy' => 'tb_comp',
				'terms' => $comp,
				'field' => 'term_id'
			);
		}
		if ( isset( $season ) ) {
			$args['tax_query'][] = array(
				'taxonomy' => 'tb_season',
				'terms' => $season,
				'field' => 'term_id'
			);
		}
		$matches = get_posts( $args );
		foreach( $matches as $match ) {
			$played = get_post_meta( $match->ID, 'tb_played', true );
			if ( $played ) {
				$f = get_post_meta( $match->ID, 'tb_home_goals', true );
				$a = get_post_meta( $match->ID, 'tb_away_goals', true );
				$won = (int)( $f > $a );
				$draw = (int)( $f == $a );
				$lost = (int)( $f < $a );
				$output['p'] ++;
				$output['w'] += $won;
				$output['d'] += $draw;
				$output['l'] += $lost;
				$output['f'] += $f;
				$output['a'] += $a;
				$output['gd'] += $f - $a;
				$output['pts'] += $won * get_option( 'tb_standings_win_points' ) + $draw * get_option( 'tb_standings_draw_points' ) + $lost * get_option( 'tb_standings_loss_points' );
			}
		}
		$args['meta_key'] = 'tb_away_club';
		$matches = get_posts( $args );
		foreach( $matches as $match ) {
			$played = get_post_meta( $match->ID, 'tb_played', true );
			if ( $played ) {
				$f = get_post_meta( $match->ID, 'tb_away_goals', true );
				$a = get_post_meta( $match->ID, 'tb_home_goals', true );
				$won = (int)( $f > $a );
				$draw = (int)( $f == $a );
				$lost = (int)( $f < $a );
				$output['p'] ++;
				$output['w'] += $won;
				$output['d'] += $draw;
				$output['l'] += $lost;
				$output['f'] += $f;
				$output['a'] += $a;
				$output['gd'] += $f - $a;
				$output['pts'] += $won * get_option( 'tb_standings_win_points' ) + $draw * get_option( 'tb_standings_draw_points' ) + $lost * get_option( 'tb_standings_loss_points' );
			}
		}
		return $output;
	}
}
// get stats
if (!function_exists('get_tb_club_stats')) {
	function get_tb_club_stats( $post = null ) {
		if ( !$post ) global $post;
		$output = array();
		$comps = get_the_terms( $post->ID, 'tb_comp' );
		$seasons = get_the_terms( $post->ID, 'tb_season' );
		// isolated competition stats
		if ( is_array( $comps ) ) {
			foreach ( $comps as $comp ) {
				// combined season stats per competition
				$stats = get_tb_club_auto_stats( $post->ID, $comp->term_id, null );
				$output[$comp->term_id][0] = array(
					'auto' => $stats,
					'total' => $stats
				);
				// isolated season stats per competition
				if ( is_array( $seasons ) ) {
					foreach ( $seasons as $season ) {
						$stats = get_tb_club_auto_stats( $post->ID, $comp->term_id, $season->term_id );
						$output[$comp->term_id][$season->term_id] = array(
							'auto' => $stats,
							'total' => $stats
						);
					}
				}
			}
		}
		// combined season stats for combined competitions
		$stats = get_tb_club_auto_stats( $post->ID );
		$output[0][0] = array(
			'auto' => $stats,
			'total' => $stats
		);
		// isolated season stats for combined competitions
		if ( is_array( $seasons ) ) {
			foreach ( $seasons as $season ) {
				$stats = get_tb_club_auto_stats( $post->ID, null, $season->term_id );
				$output[0][$season->term_id] = array(
					'auto' => $stats,
					'total' => $stats
				);
			}
		}
		// manual stats
		$stats = (array)unserialize( get_post_meta( $post->ID, 'tb_stats', true ) );
		if ( is_array( $stats ) ):
			foreach( $stats as $comp_key => $comp_val ):
				if ( is_array( $comp_val ) && array_key_exists( $comp_key, $output ) ):
					foreach( $comp_val as $season_key => $season_val ):
						if ( array_key_exists ( $season_key, $output[$comp_key] ) ) {
							$output[$comp_key][$season_key]['manual'] = $season_val;
							foreach( $output[$comp_key][$season_key]['total'] as $index_key => &$index_val ) {
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
// standings sort
if ( !function_exists( 'tb_club_standings_sort' ) ) {
	function tb_club_standings_sort( $a, $b ) {
		if ( $a->tb_stats['pts'] > $b->tb_stats['pts'] ) {
			return -1;
		} elseif  ( $a->tb_stats['pts'] < $b->tb_stats['pts'] ) {
			return 1;
		} else {
			if ( $a->tb_stats['gd'] > $b->tb_stats['gd'] ) {
				return -1;
			} elseif  ($a->tb_stats['gd'] < $b->tb_stats['gd']) {
				return 1;
			} else {
				return ( $a->tb_stats['f'] > $b->tb_stats['f'] ? -1 : 1);
			}
		}
	}
}
// standings sort by
if (!function_exists('tb_club_standings_sort_by')) {
	function tb_club_standings_sort_by( $subkey, $a ) {
		foreach( $a as $k => $v ) {
			$b[$k] = (float) $v->tb_stats[$subkey];
		}
		if ( $b != null ) {
			arsort( $b );
			foreach( $b as $key=>$val ) {
				$c[] = $a[$key];
			}
			return $c;
		}
		return array();
	}
}
?>