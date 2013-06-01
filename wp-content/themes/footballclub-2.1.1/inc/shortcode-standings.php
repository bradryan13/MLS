<?php
add_shortcode( 'tb_standings', 'tb_standings_shortcode' );
function tb_standings_shortcode( $atts, $content = null, $code = "" ) {
	global $tb_standings_stats_labels;
	extract( shortcode_atts( array(
		'limit' => 7,
		'comp' => null,
		'season' => null,
		'club' => get_option( 'tb_default_club' ),
		'orderby' => 'pts',
		'order' => 'DESC',
		'linktext' => __( 'View all standings', 'themeboy' ),
		'linkpage' => null,
		'stats' => 'p,w,d,l,f,a,gd,pts',
		'title' => __( 'Standings', 'themeboy' ),
		'type' => 'normal'
	), $atts ) );
	// convert atts to something more useful
	$stats = explode( ',', $stats );
	foreach( $stats as $key => $value ) {
		$stats[$key] = strtolower( trim( $value ) );
		if ( !array_key_exists( $stats[$key], $tb_standings_stats_labels ) )
			unset( $stats[$key] );
	}
	if ( $limit == 0 )
		$limit = -1;
	if ( $club <= 0 )
		$club = null;
	if ( $comp <= 0 )
		$comp = null;
	if ( $season <= 0 )
		$season = null;
	$comp_slug = tb_get_term_slug( $comp, 'tb_comp' );
	$season_slug = tb_get_term_slug( $comp, 'tb_season' );
	$center = $club;
	$orderby = strtolower( $orderby );	
	$order = strtoupper( $order );
	if ( $linkpage <= 0 )
		$linkpage = null;
	// get all clubs from comp and season
	$args = array(
		'post_type' => 'tb_club',
		'tax_query' => array(),
		'numberposts' => -1,
		'posts_per_page' => -1
	);
	if ( $comp ) {
		$args['tax_query'][] = array(
			'taxonomy' => 'tb_comp',
			'terms' => $comp,
			'field' => 'term_id'
		);
	}
	if ( $season ) {
		$args['tax_query'][] = array(
			'taxonomy' => 'tb_season',
			'terms' => $season,
			'field' => 'term_id'
		);
	}
	$clubs = get_posts( $args );
	$size = sizeof( $clubs );
	if ( $size == 0 )
		return false;
	if ( $limit == -1 )
		$limit = $size;
	// attach stats to each club
	foreach ( $clubs as $club ) {
		$club_stats = get_tb_club_total_stats( $club->ID, $comp, $season );		
		$club->tb_stats = $club_stats;
	}
	// sort clubs
	if ( $orderby == 'pts' ) {
		usort( $clubs, 'tb_club_standings_sort');
	} else {
		$clubs = tb_club_standings_sort_by( $orderby, $clubs );
	}
	if ( $order == 'ASC' ) {
		$clubs = array_reverse( $clubs );
	}
	// add places to clubs
	foreach ( $clubs as $key => $value ) {	
		$value->place = $key + 1;
	}
	// define center if null
	if ( !isset( $center ) )
		$center = $clubs[0]->ID;
	// if limit is smaller than table size, find range to display
	if ( $limit < $size ) {
		// find mmiddle
		$middle = 0;
		foreach( $clubs as $key => $value ) {
			if ( $value->ID == $center ) $middle = $key;
		}
		// find range to display
		$before = floor( ( $limit - 1 ) / 2 );
		$first = $middle - $before;
		$actual = $size - $first;
		if ( $actual < $limit ) {
			$first -= ( $limit - $actual );
		}
		if ( $first < 0 ) {
			$first = 0;
		}
	} else {
		$first = 0;
		$limit = $size;
	}
	// slice array
	$clubs = array_slice( $clubs, $first, $limit );
	// initialize output
	$output = '';
	// table head
	$output .=
	'<section><h3>' . $title . '</h3>' .
		'<table class="tb_standings tb_standings-' . $type . '">
			<thead>
				<tr>
					<th class="pos">' . get_option( 'tb_standings_pos_label' ) . '</th>';
		foreach( $stats as $stat ) {
			$output .= '<th class="' . $stat . '">' . $tb_standings_stats_labels[$stat] . '</th>';
		}
		$output .=
				'</tr>
			</thead>
		<tbody>';
		// insert rows
		$rownum = 0;
		foreach ( $clubs as $club ) {
			$rownum ++;
			$club_stats = $club->tb_stats;
			$output .=
			'<tr class="' . ( $center == $club->ID ? 'highlighted ' : '' ) . ( $rownum % 2 == 0 ? 'even' : 'odd' ) . ( $rownum == $limit ? ' last' : '' ) . '">';
			$output .= '<td class="club"><span class="pos">' . $club->place . '</span> ' . get_the_post_thumbnail( $club->ID, 'crest-small', array( 'title' => $club->post_title, 'class' => 'crest' ) ) . ' <span class="name">' . $club->post_title . '</span></td>';
			foreach( $stats as $stat ) {
				$output .= '<td class="' . $stat . '">' . $club_stats[$stat] . '</td>';
			}
		}
		$output.=
		'</tbody>
		</table>';
	if ( isset( $linkpage ) )
		$output .= '<a href="' . get_page_link( $linkpage ) . '" class="tb_view_all">' . $linktext . '</a>';
	$output .= '</section>';
	return $output;
}
?>