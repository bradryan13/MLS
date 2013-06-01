<?php
add_shortcode( 'tb_players', 'tb_players_shortcode' );
function tb_players_shortcode( $atts, $content = null, $code = "" ) {
	global $tb_player_stats_labels;
	$player_stats_labels = array_merge( array( 'appearances' => __( 'Appearances', 'themeboy' ) ), $tb_player_stats_labels );
	$stats_labels = array_merge(
		array(
			'flag' => '&nbsp;',
			'number' => '&nbsp;',
			'name' => __( 'Name', 'themeboy' ),
			'position' => __( 'Position', 'themeboy' ),
			'age' => __( 'Age', 'themeboy' ),
			'team' => __( 'Team', 'themeboy' ),
			'season' => __( 'Season', 'themeboy' ),
			'dob' => __( 'Date of Birth', 'themeboy' ),
			'hometown' => __( 'Hometown', 'themeboy' ),
			'joined' => __( 'Joined', 'themeboy' )
		),
		$player_stats_labels
	);
	extract( shortcode_atts( array(
		'limit' => -1,
		'season' => null,
		'club' => null,
		'team' => null,
		'position' => null,
		'orderby' => 'number',
		'order' => 'ASC',
		'show_flag' => get_option( 'tb_player_list_show_flag' ),
		'show_position' => get_option( 'tb_player_list_show_position' ),
		'show_age' => get_option( 'tb_player_list_show_age' ),
		'show_dob' => get_option( 'tb_player_list_show_dob' ),
		'show_name' => get_option( 'tb_player_gallery_show_name' ),
		'show_number' => get_option( 'tb_player_gallery_show_number' ),
		'linktext' => __( 'View all players', 'themeboy' ),
		'linkpage' => null,
		'stats' => 'flag,number,name,position,age',
		'title' => __( 'Players', 'themeboy' ),
		'type' => get_option( 'tb_players_view' )
	), $atts ) );
	if ( $limit == 0 )
		$limit = -1;
	if ( $team <= 0 )
		$team = null;
	$stats = explode( ',', $stats );
	foreach( $stats as $key => $value ) {
		$stats[$key] = strtolower( trim( $value ) );
		if ( !array_key_exists( $stats[$key], $stats_labels ) )
			unset( $stats[$key] );
	}
	$numposts = $limit;
	if ( array_intersect_key( array_flip( $stats ), $player_stats_labels ) )
		$numposts = -1;
	$orderby = strtolower( $orderby );	
	$order = strtoupper( $order );
	$output = '';
	$args = array(
		'post_type' => 'tb_player',
		'tax_query' => array(),
		'numposts' => $numposts,
		'posts_per_page' => $numposts,
		'orderby' => 'meta_value_num',
		'meta_key' => 'tb_number',
		'order' => $order
	);
	if ( $club ) {
		$args['meta_query'] = array(
			array(
				'key' => 'tb_club',
				'value' => $club,
			)
		);
	}
	if ( $season ) {
		$args['tax_query'][] = array(
			'taxonomy' => 'tb_season',
			'terms' => $season,
			'field' => 'term_id'
		);
	}
	if ( $team ) {
		$args['tax_query'][] = array(
			'taxonomy' => 'tb_team',
			'terms' => $team,
			'field' => 'term_id'
		);
	}
	if ( $position ) {
		$args['tax_query'][] = array(
			'taxonomy' => 'tb_position',
			'terms' => $position,
			'field' => 'term_id'
		);
	}
	$players = get_posts( $args );
	$count = 0;	
	// list view
	$output .=
	'<section><h3>' . $title . '</h3>' .
	'<div class="tb_players">
		<ul class="tb_section_views">
			<li><a href="#list" class="list' . ( $type == 'list' ? ' selected' : '' ) . '"><span>' . __( 'List', 'themeboy' ) . '</span></a></li>
			<li><a href="#gallery" class="gallery' . ( $type == 'gallery' ? ' selected' : '' ) . '"><span>' . __( 'Gallery', 'themeboy' ) . '</span></a></li>
		</ul>
		<table class="list-view'.($type != 'list' ? ' hidden' : '').'">
			<thead>
				<tr>';
				foreach( $stats as $stat ) {
					$output .= '<th class="'. $stat . ( $stats[0] == $stat ? ' first' : '' ) .'">' . $stats_labels[$stat] .'</th>';
				}
				$output .= '</tr>
			</thead>
			<tbody>';
	$player_details = array();
	foreach( $players as $player ) {
		$player_details[$player->ID] = array();
		$count++;
		if ( array_intersect_key( array_flip( $stats ), $player_stats_labels ) )
			$player_stats = get_tb_player_stats( $player->ID );
		$number = get_post_meta( $player->ID, 'tb_number', true );
		$name = $player->post_title;
		$positions = get_the_terms( $player->ID, 'tb_position' );
		if ( is_array( $positions ) ) {
			$position = reset($positions);
			$position = $position->name;
		} else {
			$position = __( 'None' );
		}
		$dob = get_post_meta( $player->ID, 'tb_dob', true );
		$natl = get_post_meta( $player->ID, 'tb_natl', true );
		$hometown = get_post_meta( $player->ID, 'tb_hometown', true );
		global $tb_countries_of_the_world;
		foreach( $stats as $stat ) {		
			if ( array_key_exists( $stat, $player_stats_labels ) ) 
				$player_details[$player->ID][$stat] .= $player_stats[0][0]['total'][$stat];
			else {
				switch ( $stat ) {
				case 'flag':
					$player_details[$player->ID][$stat] .= '<img class="flag" src="' . get_bloginfo( 'template_directory' ) . '/images/flags/' . $natl . '.png" />';
					break;
				case 'number':
					$player_details[$player->ID][$stat] .= $number;
					break;
				case 'name':
					$player_details[$player->ID][$stat] .= '<a href="' . get_permalink( $player->ID ) . '">' . $name . '</a>';
					break;
				case 'position':
					$positions = get_the_terms( $player->ID, 'tb_position' );
					if ( is_array( $positions ) ) {
						$player_positions = array();
						foreach ( $positions as $position ) {
							$player_positions[] = $position->name;
						}
						$player_details[$player->ID][$stat] .= implode( ', ', $player_positions );
					}
					break;
				case 'team':
					$teams = get_the_terms( $player->ID, 'tb_team' );
					if ( is_array( $teams ) ) {
						$player_teams = array();
						foreach ( $teams as $team ) {
							$player_teams[] = $team->name;
						}
						$player_details[$player->ID][$stat] .= implode( ', ', $player_teams );
					}
					break;
				case 'season':
					$seasons = get_the_terms( $player->ID, 'tb_season' );
					if ( is_array( $seasons ) ) {
						$player_seasons = array();
						foreach ( $seasons as $season ) {
							$player_seasons[] = $season->name;
						}
						$player_details[$player->ID][$stat] .= implode( ', ', $player_seasons );
					}
					break;
				case 'age':
					$player_details[$player->ID][$stat] .= get_age( get_post_meta( $player->ID, 'tb_dob', true ) );
					break;
				case 'dob':
					$player_details[$player->ID][$stat] .= date_i18n( get_option( 'date_format' ), strtotime( get_post_meta( $player->ID, 'tb_dob', true ) ) );
					break;
				case 'hometown':
					$player_details[$player->ID][$stat] .= '<img class="flag" src="'.get_bloginfo('template_directory').'/images/flags/' . $natl . '.png" /> ' . $hometown;
					break;
				case 'joined':
					$player_details[$player->ID][$stat] = date_i18n( get_option( 'date_format' ), strtotime( $player->post_date ) );
					break;
				}
			}
		}
	}
	if ( array_key_exists( $orderby, $player_stats_labels ) ) {
		$player_details = subval_sort( $player_details, $orderby );
		if ( $order == 'DESC' )
			$player_details = array_reverse( $player_details );
	}
	$count = 0;
	foreach( $player_details as $player_detail ) {
		$count++;
		if ( $limit > 0 && $count > $limit )
			break;
		$output .=
		'<tr class="'.( $count % 2 == 0 ? 'even' : 'odd').'">';
		foreach( $stats as $stat ) {
			$output .= '<td class="'. $stat . ( $stats[0] == $stat ? ' first' : '' ) .'">';
			$output .= $player_detail[$stat];
			$output .= '</td>';
		}
		$output .= '</tr>';
	}
	$output .= '</tbody></table>';
	
	// gallery view
	global $tb_default_images;
	$count = 0;
	$output .= '<ul class="gallery-view' . ( $type != 'gallery' ? ' hidden' : '' ) . '"><div class="clearfix">';
	foreach( $players as $player ) {
		$count++;
		$number = get_post_meta( $player->ID, 'tb_number', true );
		$name = $player->post_title;
		if ( get_the_post_thumbnail( $player->ID, 'gallery-image' ) != null ):
			$img = get_the_post_thumbnail( $player->ID, 'gallery-image', array( 'title' => get_the_title( $player->ID ) ));
		else:
			$img = '<img src="' . $tb_default_images['player_thumb'] . '" />';
		endif;
		$output .= '<li'.($count % 5 == 1 ? ' class="first"' : '').($count % 5 == 0 ? ' class="last"' : '').'>
			<a href="' . get_permalink( $player->ID ) . '">' . $img . '</a>';
			if ( $show_number && $number ) {
				$output .=
				'<div class="number">
					<a href="' . get_permalink( $player->ID ) . '" title="' . esc_attr( get_post_field( 'post_title', $player->ID ) ) . '">'.$number.'</a>
				</div>';
			}
			if ( $show_name ) {
				$output .=
				'<div class="name">
					<a href="' . get_permalink( $player->ID ) . '" title="' . esc_attr( get_post_field( 'post_title', $player->ID ) ) . '">'.get_the_title($player->ID).'</a>
				</div>';
			}
		$output .=
		'</li>';
		if ($count % 5 == 0):
			$output .= '</div><div class="clearfix">';
		endif;
	}
	$output .= '</div></ul>';
	if ( isset( $linkpage ) ) $output .= '<a href="' . get_page_link( $linkpage ) . '" class="tb_view_all">' . $linktext . '</a>';
	$output .= '</div></section>';
	$output .=
	'<script type="text/javascript">
		(function($) {
			switchToGalleryView = function() {
				$(\'.tb_players .tb_section_views .list\').removeClass(\'selected\');
				$(\'.tb_players .tb_section_views .gallery\').addClass(\'selected\');
				$(\'.tb_players .list-view\').hide(0, function() {
					$(\'.tb_players .gallery-view\').show();
				});
			};
			fadeToGalleryView = function() {
				$(\'.tb_players .tb_section_views .list\').removeClass(\'selected\');
				$(\'.tb_players .tb_section_views .gallery\').addClass(\'selected\');
				$(\'.tb_players .list-view\').fadeOut(400, function() {
					$(\'.tb_players .gallery-view\').fadeIn();
				});
			};
			fadeToListView = function() {
				$(\'.tb_players .tb_section_views .gallery\').removeClass(\'selected\');
				$(\'.tb_players .tb_section_views .list\').addClass(\'selected\');
				$(\'.tb_players .gallery-view\').fadeOut(400, function() {
					$(\'.tb_players .list-view\').fadeIn();
				});
			};
			hash = window.location.hash;
			if (hash == \'#gallery\') switchToGalleryView();
			$(\'.tb_players .tb_section_views .list\').click(function() {
				fadeToListView();
			});
			$(\'.tb_players .tb_section_views .gallery\').click(function() {
				fadeToGalleryView();
			});
		})(jQuery);
	</script>';
	return $output;	
}
?>