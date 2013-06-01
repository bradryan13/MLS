<?php
add_shortcode( 'tb_results', 'tb_results_shortcode' );
function tb_results_shortcode( $atts, $content = null, $code = "" ) {
	extract( shortcode_atts( array(
		'limit' => 5,
		'comp' => null,
		'season' => null,
		'club' => null,
		'venue' => null,
		'orderby' => 'post_date',
		'order' => 'DESC',
		'linktext' => __( 'View all results', 'themeboy' ),
		'linkpage' => null,
		'title' => __( 'Results', 'themeboy' ),
		'type' => 'default'
	), $atts ) );
	// convert atts to something more useful
	$orderby = strtolower( $orderby );	
	$order = strtoupper( $order );
	if ( $limit == 0 )
		$limit = -1;
	if ( $linkpage <= 0 )
		$linkpage = null;
	if ( $club <= 0  )
		$club = null;
	if ( $comp <= 0 )
		$comp = null;
	if ( $season <= 0  )
		$season = null;
	if ( $venue <= 0  )
		$venue = null;
	// get all corresponding matches
	$args = array(
		'tax_query' => array(),
		'numberposts' => $limit,
		'order' => $order,
		'orderby' => $orderby,
		'meta_query' => array(
			array(
				'key' => 'tb_played',
				'value' => true
			)
		),
		'post_type' => 'tb_match',
		'posts_per_page' => $limit
	);
	$args['paged'] = get_query_var( 'paged' );
	if ( isset( $club ) ) {
		$args['meta_query'] = array(
			'relation' => 'OR',
			array(
				'key' => 'tb_home_club',
				'value' => $club,
			),
			array(
				'key' => 'tb_away_club',
				'value' => $club,
			)
		);
	}
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
	if ( isset( $venue ) ) {
		$args['tax_query'][] = array(
			'taxonomy' => 'tb_venue',
			'terms' => $venue,
			'field' => 'term_id'
		);
	}
	$matches = get_posts( $args );
	$size = sizeof( $matches );
	$output = '';
	$count = 0;
	// sidebar type
	if ( $type == 'sidebar' ) {
		$output .=
		'<section><h3>' . $title . '</h3>' .
		'<ul class="tb_fixtures tb_matches tb_fixtures-sidebar tb_matches-sidebar">';
		if ( $size > 0 ) {
			foreach( $matches as $match ) {
				$count ++;
				$home_club = get_post_meta( $match->ID, 'tb_home_club', true );
				$away_club = get_post_meta( $match->ID, 'tb_away_club', true );
				$hide_default_club = get_option( 'tb_matches_hide_default_club' );
				$default_club = get_option( 'tb_default_club' );
				$home_goals = get_post_meta( $match->ID, 'tb_home_goals', true );
				$away_goals = get_post_meta( $match->ID, 'tb_away_goals', true );
				$timestamp = strtotime( $match->post_date );
				$gmt_offset = get_option( 'gmt_offset' );
				$date_format = get_option( 'date_format' );
				$time_format = get_option( 'time_format' );
				$output .=
				'<li class="'.( $count % 2 == 0 ? 'even' : 'odd').' '.( $count == $size ? ' last' : '').'">
					<div class="kickoff">
						<div class="home-logo">' . get_the_post_thumbnail( $home_club, 'crest-medium', array( 'title' => get_the_title( $home_club ) ) ) . '</div>
						<div class="away-logo">' . get_the_post_thumbnail( $away_club, 'crest-medium', array( 'title' => get_the_title( $away_club ) ) ) . '</div>
						<a href="' . get_permalink( $match->ID ) . '">' . date_i18n( $date_format, $timestamp ) . '</a><br />
						<time>' . $home_goals . ' ' . get_option( 'tb_match_goals_delimiter' ) . ' '  . $away_goals . '</time>
					</div>
					<h4 class="teams ellipsis">
						<a href="' . get_permalink( $match->ID ) . '">';
						$output .= get_the_title( $match );
						$output .=
						'</a>
					</h4>
				</li>';
			}
		} else {
			$output .= '<li class="inner">'.__('No matches played yet.', 'themeboy').'</li>';
		}
		$output .= '</ul>';
		if ( isset( $linkpage ) )
			$output .= '<a href="' . get_page_link( $linkpage ) . '" class="tb_view_all">' . $linktext . '</a>';
		$output .- '</section>';
	} else {
		$output = 
		'<section><h3>' . $title . '</h3>' .
		'<table class="tb_fixtures tb_matches tb_results-normal tb_matches-normal">
			<thead>';
		if ( $size > 0 ) {
			$output .=
			'<tr>
				<th class="date first">'.__('Date').'</th>
				<th class="home">'.__('Home', 'themeboy').'</th>
				<th class="away">'.__('Away', 'themeboy').'</th>
				<th class="goals last">'.__('Results', 'themeboy').'</th>
			</tr>';
		} else {
			$output .=
			'<tr>
				<th class="inner">'.__('No matches played yet.', 'themeboy').'</div></th>
			</tr>';
		}
		$output .=
		'</thead>
		<tbody>';
		if ( $size > 0 ) {
			foreach( $matches as $match ) {
				$count++;
				$home_club = get_post_meta( $match->ID, 'tb_home_club', true );
				$away_club = get_post_meta( $match->ID, 'tb_away_club', true );
				$home_goals = get_post_meta( $match->ID, 'tb_home_goals', true );
				$away_goals = get_post_meta( $match->ID, 'tb_away_goals', true );
				$played = get_post_meta( $match->ID, 'tb_played', true );
				$timestamp = strtotime( $match->post_date );
				$gmt_offset = get_option( 'gmt_offset' );
				$date_format = get_option( 'date_format' );
				$time_format = get_option( 'time_format' );
				$output .=
				'<tr class="' . ( $count % 2 == 0 ? 'even' : 'odd') . ' ' . ( $count == $size ? ' last' : '') . '">
					<th class="date"><a href="' . get_permalink( $match->ID ) . '">' . date_i18n( $date_format, $timestamp ) . '</a></td>
					<td class="home">' . get_the_post_thumbnail( $home_club, 'crest-small', array( 'class' => 'crest-home crest', 'title' => get_the_title( $home_club ) ) ) . get_the_title ( $home_club ) . '</td>
					<td class="away">' . get_the_post_thumbnail( $away_club, 'crest-small', array( 'class' => 'crest-away crest', 'title' => get_the_title( $away_club ) ) ) . get_the_title ( $away_club ) . '</td>
					<td class="goals">' . ( $played ? $home_goals . ' ' . get_option( 'tb_match_goals_delimiter' ) . ' ' . $away_goals : '' ) . '</td>
				</tr>';
			}
		}
		$output .= '</tbody></table>';
		if ( isset( $linkpage ) )
			$output .= '<a href="'.get_page_link( $linkpage ) . '" class="tb_view_all">' . $linktext . '</a>';
		$output .= '</section>';
	}
	return $output;
}
?>