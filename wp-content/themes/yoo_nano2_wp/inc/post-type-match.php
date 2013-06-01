<?php
add_action( 'init', 'tb_match_init' );
add_filter( 'the_posts', 'show_scheduled_tb_matches' );
add_action( 'admin_init', 'tb_match_meta_boxes' );
add_filter( 'gettext', 'tb_match_text_replace', 10, 4 );
add_filter( 'the_title', 'tb_match_title', 10, 2 );
add_filter( 'wp_title', 'tb_match_wp_title', 10, 3 );
add_action( 'save_post', 'save_tb_match' );
add_filter( 'manage_edit-tb_match_columns', 'tb_match_edit_columns' );
add_action( 'manage_posts_custom_column', 'tb_match_custom_columns' );
add_action( 'restrict_manage_posts', 'tb_match_request_filter_dropdowns' );
// initialize
function tb_match_init() {
	$labels = array( 
		'name' => __( 'Matches', 'themeboy' ),
		'singular_name' => __( 'Match', 'themeboy' ),
		'add_new' => __( 'Add New', 'themeboy' ),
		'all_items' => sprintf( __( 'All %s', 'themeboy' ), __( 'Matches', 'themeboy' ) ),
		'add_new_item' => sprintf( __( 'Add New %s', 'themeboy' ), __( 'Match', 'themeboy' ) ),
		'edit_item' => sprintf( __( 'Edit %s', 'themeboy' ), __( 'Match', 'themeboy' ) ),
		'new_item' => sprintf( __( 'New %s', 'themeboy' ), __( 'Match', 'themeboy' ) ),
		'view_item' => sprintf( __( 'View %s', 'themeboy' ), __( 'Match', 'themeboy' ) ),
		'search_items' => sprintf( __( 'Search %s', 'themeboy' ), __( 'Matches', 'themeboy' ) ),
		'not_found' => sprintf( __( 'No %s found', 'themeboy' ), __( 'matches', 'themeboy' ) ),
		'not_found_in_trash' => sprintf( __( 'No %s found in trash', 'themeboy' ), __( 'matches', 'themeboy' ) ),
		'parent_item_colon' => sprintf( __( 'Parent %s:', 'themeboy' ), __( 'Match', 'themeboy' ) ),
		'menu_name' => __( 'Matches', 'themeboy' )
	);
	$args = array( 
		'labels' => $labels,
		'hierarchical' => false,
		'supports' => array( 'editor' ),
		'public' => true,
		'show_ui' => true,
		'show_in_menu' => true,
		'show_in_nav_menus' => true,
		'publicly_queryable' => true,
		'exclude_from_search' => false,
		'has_archive' => false,
		'query_var' => true,
		'can_export' => true,
		'rewrite' => array( 'slug' => 'match' ),
		'capability_type' => 'post'
	);
	register_post_type( 'tb_match', $args );
};
// show future
function show_scheduled_tb_matches($posts) {
	global $wp_query, $wpdb;
	if(is_single() && $wp_query->post_count == 0 && isset($wp_query->query_vars['tb_match'])) {
		$posts = $wpdb->get_results($wp_query->request);
	}
	return $posts;
}
// text replace
function tb_match_text_replace($input, $text, $domain) {
	global $post;
	if ( is_admin() && get_post_type( $post ) == 'tb_match'  && in_array( $text, array( 'Scheduled for: <b>%1$s</b>', 'Published on: <b>%1$s</b>', 'Publish <b>immediately</b>' ) ) )
		return __( 'Kick-off: <b>%1$s</b>', 'themeboy' );
	return $input;
}
// generate title
function tb_match_title( $title, $id = null ) {
	if ( get_post_type( $id ) == 'tb_match' ) {
		$default_club = get_option('tb_default_club');
		$home_title_format = get_option('tb_match_home_title_format');
		$away_title_format = get_option('tb_match_away_title_format');
		$home_id = (int)get_post_meta( $id, 'tb_home_club', true );
		$away_id = (int)get_post_meta( $id, 'tb_away_club', true );
		$home_club = get_post( $home_id );
		$away_club = get_post( $away_id );
		$search = array( '%home%', '%away%' );
		$replace = array( $home_club->post_title, $away_club->post_title );
		
		if ( $away_id == $default_club ) {
			//away
			$title = str_replace( $search, $replace, $away_title_format );
		} else {
			// home
			$title = str_replace( $search, $replace, $home_title_format );
		}
	}
	return $title;
}
// generate title
function tb_match_wp_title( $title, $sep, $seplocation ) {
	if ( get_post_type( ) == 'tb_match' ) {
		$title = '';
		if ( $seplocation == 'left' ) {
			$title .= ' ' . $sep . ' ';
		}
		global $post;
		$id = $post->ID;
		$home_id = (int)get_post_meta( $id, 'tb_home_club', true );
		$away_id = (int)get_post_meta( $id, 'tb_away_club', true );
		$home_club = get_post( $home_id );
		$away_club = get_post( $away_id );
		$title .= tb_match_title( $title, $id ) . ' ' . $sep . ' ' . get_the_date();
		if ( $seplocation == 'right' ) {
			$title .= ' ' . $sep . ' ';
		}
		return $title;
	}
	return $title;
}
// initialize admin
function tb_match_meta_boxes() {
	remove_meta_box( 'tb_compdiv', 'tb_match', 'side');
	remove_meta_box( 'tb_venuediv', 'tb_match', 'side');
	remove_meta_box( 'tb_seasondiv', 'tb_match', 'side');
	add_meta_box( 'tb_match-details-meta', __('Match Details', 'themeboy'), 'tb_match_details_meta', 'tb_match', 'side', 'default');
	add_meta_box( 'tb_match-fixture-meta', __('Fixture', 'themeboy'), 'tb_match_fixture_meta', 'tb_match', 'normal', 'high');
	add_meta_box( 'tb_match-players-meta', __('Players', 'themeboy'), 'tb_match_players_meta', 'tb_match', 'normal', 'high');
}
// details meta box
function tb_match_details_meta( $post ) {
	$post_id = $post->ID;
	$comps = get_the_terms( $post_id, 'tb_comp' );
	if ( is_array( $comps ) ) {
		$comp = $comps[0]->term_id;
		$comp_slug = $comps[0]->slug;
	} else {
		$comp = 0;
		$comp_slug = null;
	}
	$seasons = get_the_terms( $post->ID, 'tb_season' );
	if ( is_array( $seasons ) ) {
		$season = $seasons[0]->term_id;
	} else {
		$season = -1;
	}
	$venues = get_the_terms( $post->ID, 'tb_venue' );
	if ( is_array( $venues ) ) {
		$venue = $venues[0]->term_id;
	} else {
		$venue = -1;
	}
	$played = get_post_meta( $post_id, 'tb_played', true );
	$goals = array_merge(
		array(
			'auto' => array( 'home' => 0, 'away' => 0	),
			'manual' => array( 'home' => 0, 'away' => 0	),
			'total' => array( 'home' => 0, 'away' => 0	)
		),
		(array)unserialize( get_post_meta( $post_id, 'tb_goals', true ) )
	);
?>
	<p>
		<label><?php _e( 'Competition', 'themeboy' ); ?>:</label>
		<?php
		wp_dropdown_categories(array(
			'show_option_none' => __( 'None' ),
			'orderby' => 'title',
			'hide_empty' => false,
			'taxonomy' => 'tb_comp',
			'selected' => $comp,
			'name' => 'tb_comp'
		));
		?>
	</p>
	<p>
		<label><?php _e( 'Season', 'themeboy' ); ?>:</label>
		<?php
		wp_dropdown_categories(array(
			'show_option_none' => __( 'None' ),
			'orderby' => 'title',
			'hide_empty' => false,
			'taxonomy' => 'tb_season',
			'selected' => $season,
			'name' => 'tb_season'
		));
		?>
	</p>
	<p>
		<label><?php _e( 'Venue', 'themeboy' ); ?>:</label>
		<?php
		wp_dropdown_categories( array(
			'show_option_none' => __( 'None' ),
			'orderby' => 'title',
			'hide_empty' => false,
			'taxonomy' => 'tb_venue',
			'selected' => $venue,
			'name' => 'tb_venue'
		) );
		?>
	</p>
	<p>
		<label class="selectit">
			<input type="checkbox" name="tb_played" id="tb_played" value="1" <?php checked( true, $played ); ?> />
			<?php _e( 'Results', 'themeboy' ); ?>
		</label>
	</p>
	<table id="results-table">
		<thead>
			<tr>
				<td>&nbsp;</td>
				<th><?php _ex( 'Home', 'team', 'themeboy' ); ?></th>
				<th><?php _ex( 'Away', 'team', 'themeboy' ); ?></th>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td align="right"><?php _e( 'Auto', 'themeboy' ); ?></td>
				<td><input type="text" name="tb_goals[auto][home]" id="tb_goals_auto_home" value="<?php echo (int)$goals['auto']['home']; ?>" size="3" readonly /></td>
				<td><input type="text" name="tb_goals[auto][away]" id="tb_goals_auto_away" value="<?php echo (int)$goals['auto']['away']; ?>" size="3" readonly /></td>
			</tr>
			<tr>
				<td align="right"><?php _e( 'Manual', 'themeboy' ); ?></td>
				<td><input type="text" name="tb_goals[manual][home]" id="tb_goals_manual_home" value="<?php echo (int)$goals['manual']['home']; ?>" size="3" /></td>
				<td><input type="text" name="tb_goals[manual][away]" id="tb_goals_manual_away" value="<?php echo (int)$goals['manual']['away']; ?>" size="3" /></td>
			</tr>
			<tr>
				<th align="right"><?php _e( 'Total', 'themeboy' ); ?></th>
				<td><input type="text" name="tb_goals[total][home]" id="tb_goals_total_home" value="<?php echo (int)$goals['total']['home']; ?>" size="3" readonly /></td>
				<td><input type="text" name="tb_goals[total][away]" id="tb_goals_total_away" value="<?php echo (int)$goals['total']['away']; ?>" size="3" readonly /></td>
			</tr>
		</tbody>
	</table>
	<script type="text/javascript">
		(function($) {
			$('#poststuff #post-body-content').hide();
			$('#tb_match-details-meta').on('change', '#tb_played', function() {			
				played = $(this).prop('checked');
				if (played) {
					$('#poststuff #post-body-content').show();
					$('#tb_match-details-meta #results-table').show();
				} else {
					$('#tb_match-details-meta #results-table').hide();
					$('#poststuff #post-body-content').hide();
				}
			});
			$('#tb_match-details-meta #tb_played').change();
		})(jQuery);
	</script>
	<input type="hidden" name="tb_match_details_meta_nonce" id="tb_match_details_meta_nonce" value="<?php echo wp_create_nonce( plugin_basename(__FILE__) ); ?>" />
<?php
}
// fixture meta box
function tb_match_fixture_meta( $post ) {
	$post_id = $post->ID;
	$home_club = get_post_meta( $post_id, 'tb_home_club', true );
	$away_club = get_post_meta( $post_id, 'tb_away_club', true );
	if ( ! $home_club && get_option( 'tb_default_club' ) > 0 )
		$home_club = get_option( 'tb_default_club' );
	if ( ! $away_club && get_option( 'tb_default_club' ) > 0 )
		$away_club = get_option( 'tb_default_club' );
	$club_buttons_ajax_nonce = wp_create_nonce( 'tb_club_buttons_ajax_nonce' );
?>
	<table id="fixtures-table">
		<thead>
			<tr>
				<th><?php _e( 'Home', 'themeboy' ); ?></th>
				<td>&nbsp;</td>
				<th><?php _e( 'Away', 'themeboy' ); ?></th>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td>
					<a class="thickbox tb-club-big-button" id="tb_home_club_button" data-club="<?php echo $home_club; ?>" href="<?php echo admin_url('admin-ajax.php?action=tb_club_buttons&width=664&side=home&eid=tb_home_club&nonce=' . $club_buttons_ajax_nonce ); ?>" title="<?php printf( __( 'Select %s', 'themeboy' ), __( 'Club', 'themeboy' ) ); ?>">
						<?php if ( $home_club ) { ?>
							<?php echo get_the_post_thumbnail( $home_club, 'crest-large', array( 'title' => sprintf( __( 'Select %s', 'themeboy' ), __( 'Club', 'themeboy' ) ) ) ); ?>
							<span class="ellipsis"><?php echo get_the_title( $home_club ); ?></span>
						<?php } else { ?>
							<span class="ellipsis"><?php printf( __( 'Select %s', 'themeboy' ), __( 'Club', 'themeboy' ) ); ?></span>
						<?php } ?>
					</a>
					<input type="hidden" name="tb_home_club" id="tb_home_club" value="<?php echo $home_club ?>" />
				</td>
				<td>
					&nbsp;
					<?php if ( false ) { ?>
						<a class="tb-swap-teams-button"></a>
					<?php } ?>
				</td>
				<td class="away-club">
					<a class="thickbox tb-club-big-button" id="tb_away_club_button" data-club="<?php echo $away_club; ?>" href="<?php echo admin_url('admin-ajax.php?action=tb_club_buttons&width=664&side=away&eid=tb_away_club&nonce=' . $club_buttons_ajax_nonce ); ?>" title="<?php printf( __( 'Select %s', 'themeboy' ), __( 'Club', 'themeboy' ) ); ?>">
						<?php if ( $away_club ) { ?>
							<?php echo get_the_post_thumbnail( $away_club, 'crest-large', array( 'title' => sprintf( __( 'Select %s', 'themeboy' ), __( 'Club', 'themeboy' ) ) ) ); ?>
							<span class="ellipsis"><?php echo get_the_title( $away_club ); ?></span>
						<?php } else { ?>
							<span class="ellipsis"><?php printf( __( 'Select %s', 'themeboy' ), __( 'Club', 'themeboy' ) ); ?></span>
						<?php } ?>
					</a>
					<input type="hidden" name="tb_away_club" id="tb_away_club" value="<?php echo $away_club ?>" />
				</td>
			</tr>
		</tbody>
	</table>
	<input type="hidden" name="post_title" value="" />
	<input type="hidden" name="tb_match_fixture_meta_nonce" id="tb_match_fixture_meta_nonce" value="<?php echo wp_create_nonce( plugin_basename(__FILE__) ); ?>" />
<?php
}
// players meta box
function tb_match_players_meta( $post ) {
	$post_id = $post->ID;
	$players = unserialize( get_post_meta( $post_id, 'tb_players', true ) );
	$home_club = get_post_meta( $post_id, 'tb_home_club', true );
	$away_club = get_post_meta( $post_id, 'tb_away_club', true );
	if ( ! $home_club && get_option( 'tb_default_club' ) > 0 )
		$home_club = get_option( 'tb_default_club' );
	if ( ! $away_club && get_option( 'tb_default_club' ) > 0 )
		$away_club = get_option( 'tb_default_club' );
?>
	<div class="playersdiv" id="tb_home_players">
		<h4><?php _ex( 'Home', 'team', 'themeboy' ); ?></h4>
		<ul class="tb_stats-tabs category-tabs">
			<li class="tabs"><a href="#tb_home_lineup" tabindex="3"><?php _e( 'Starting Lineup', 'themeboy' ); ?></a></li>
			<li class="hide-if-no-js"><a href="#tb_home_subs" tabindex="3"><?php _e( 'Substitutes', 'themeboy' ); ?></a></li>
		</ul>
		<div id="tb_home_lineup" class="tabs-panel">
			<?php tb_match_player_stats_table( $players, $home_club, 'home', 'lineup' ); ?>
		</div>
		<div id="tb_home_subs" class="tabs-panel" style="display: none;">
			<?php tb_match_player_stats_table( $players, $home_club, 'home', 'subs' ); ?>
		</div>
	</div>
	<div class="categorydiv" id="tb_away_players">
		<h4><?php _ex( 'Away', 'team', 'themeboy' ); ?></h4>
		<ul class="tb_stats-tabs category-tabs">
			<li class="tabs"><a href="#tb_away_lineup" tabindex="3"><?php _e( 'Starting Lineup', 'themeboy' ); ?></a></li>
			<li class="hide-if-no-js"><a href="#tb_away_subs" tabindex="3"><?php _e( 'Substitutes', 'themeboy' ); ?></a></li>
		</ul>
		<div id="tb_away_lineup" class="tabs-panel">
			<?php tb_match_player_stats_table( $players, $away_club, 'away', 'lineup' ); ?>
		</div>
		<div id="tb_away_subs" class="tabs-panel" style="display: none;">
			<?php tb_match_player_stats_table( $players, $away_club, 'away', 'subs' ); ?>
		</div>
	</div>
	<div class="clear"></div>
	<script type="text/javascript">
		(function($) {
			// swap teams
			$('#tb_match-fixture-meta .tb-swap-teams-button').click(function() {
				// swap club buttons
				var home_button = $('#tb_home_club_button');
				var away_button = $('#tb_away_club_button');
				var temp = $(home_button).html();
				$(home_button).html($(away_button).html());
				$(away_button).html(temp);
				// swap club inputs
				var home_input = $('#tb_home_club');
				var away_input = $('#tb_away_club');
				var temp = $(home_input).val();
				$(home_input).val($(away_input).val());
				$(away_input).val(temp);
			});
			// stats tabs
			$('.tb_stats-tabs a').click(function(){
				var t = $(this).attr('href');
				$(this).parent().addClass('tabs').siblings('li').removeClass('tabs');
				$(this).parent().parent().parent().find('.tabs-panel').hide();
				$(t).show();
				return false;
			});
			$('#tb_match-players-meta table input[type="checkbox"]').live('change', function() {
				player_id = $(this).attr('data-player');
				$(this).closest('tr').find('input[type="number"]').prop('readonly', !$(this).prop('checked'));
				$(this).closest('tr').find('select').prop('disabled', !$(this).prop('checked'));
			});
			// update auto goals
			tb_update_auto_goals = function() {
				home_goals = 0;
				away_goals = 0;
				$('#tb_match-players-meta #tb_home_players table .goals input:not([readonly])').each(function() {
					home_goals += parseInt($(this).val());
				});
				$('#tb_match-players-meta #tb_away_players table .goals input:not([readonly])').each(function() {
					away_goals += parseInt($(this).val());
				});
				manual_home_goals = $('#tb_match-details-meta #results-table input#tb_goals_manual_home').val();
				manual_away_goals = $('#tb_match-details-meta #results-table input#tb_goals_manual_away').val();
				$('#tb_match-details-meta #results-table input#tb_goals_auto_home').val(home_goals);
				$('#tb_match-details-meta #results-table input#tb_goals_auto_away').val(away_goals);
				$('#tb_match-details-meta #results-table input#tb_goals_total_home').val(parseInt(home_goals) + parseInt(manual_home_goals));
				$('#tb_match-details-meta #results-table input#tb_goals_total_away').val(parseInt(away_goals) + parseInt(manual_away_goals));
			}
			$('#tb_match-players-meta table input[type="checkbox"]').live('click', function() {
				tb_update_auto_goals();
			});
			$('#tb_match-details-meta #results-table input, #tb_match-players-meta table .goals input, #tb_match-players-meta table input[type="checkbox"]').live('change', function() {
				tb_update_auto_goals();
			});
			// refresh players list
			tb_refresh_players_lists = function(side) {
				tb_refresh_players_list(side, 'lineup');
				tb_refresh_players_list(side, 'subs');				
			}
			tb_refresh_players_list = function(side, type) {
				nonce = '<?php echo wp_create_nonce('tb_players_nonce'); ?>';
				club = $('#tb_' + side + '_club').val();
				$.ajax({
					type : 'post',
					dataType : 'html',
					url : ajaxurl,
					data : {
						action: 'tb_players_table',
						nonce: nonce,
						club: club,
						side: side,
						type: type
					},
					success: function(response) {
						$('#tb_match-players-meta #tb_' + side + '_' + type).html(response);
					}
				});
			}
			$('#tb_home_club').live('change', function() {
				tb_refresh_players_lists('home');
			})
			$('#tb_away_club').live('change', function() {
				tb_refresh_players_lists('away');
			})
		})(jQuery);
	</script>
	<input type="hidden" name="tb_match_players_meta_nonce" id="tb_match_players_meta_nonce" value="<?php echo wp_create_nonce( plugin_basename(__FILE__) ); ?>" />
<?php
}
// save post
function save_tb_match( ) {
	global $post, $post_id, $typenow;
	if ( $typenow  == 'tb_match' && isset( $_POST ) ) {
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return $post_id;
		if ( !isset( $_POST['tb_match_details_meta_nonce'] ) || !wp_verify_nonce( $_POST['tb_match_details_meta_nonce'], plugin_basename(__FILE__) )) return $post_id;
		if ( !isset( $_POST['tb_match_fixture_meta_nonce'] ) || !wp_verify_nonce( $_POST['tb_match_fixture_meta_nonce'], plugin_basename(__FILE__) )) return $post_id;
		if ( !isset( $_POST['tb_match_players_meta_nonce'] ) || !wp_verify_nonce( $_POST['tb_match_players_meta_nonce'], plugin_basename(__FILE__) )) return $post_id;
		// details meta
		$comp = $_POST['tb_comp'];
		$season = $_POST['tb_season'];
		$venue = $_POST['tb_venue'];
		$played = $_POST['tb_played'];
		$goals = $_POST['tb_goals'];
		wp_set_post_terms( $post->ID, $comp, 'tb_comp' );
		wp_set_post_terms( $post->ID, $season, 'tb_season' );
		wp_set_post_terms( $post->ID, $venue, 'tb_venue' );
		update_post_meta( $post->ID, 'tb_played', $played );
		update_post_meta( $post->ID, 'tb_goals', serialize( $goals ) );
		update_post_meta( $post->ID, 'tb_home_goals', $goals['total']['home'] );
		update_post_meta( $post->ID, 'tb_away_goals', $goals['total']['away'] );
		// fixture meta
		$home_club = $_POST['tb_home_club'];
		$away_club = $_POST['tb_away_club'];
		update_post_meta( $post->ID, 'tb_home_club', $home_club );
		update_post_meta( $post->ID, 'tb_away_club', $away_club );
		// players meta
		$players = (array)$_POST['tb_players'];
		if ( is_array( $players ) && array_key_exists( 'home', $players ) && is_array( $players['home'] ) ) {
			if ( array_key_exists( 'lineup', $players['home'] ) && is_array( $players['home']['lineup'] ) )
				$players['home']['lineup'] = array_filter( $players['home']['lineup'], 'tb_array_filter_checked' );
			if ( array_key_exists( 'subs', $players['home'] ) &&  is_array( $players['home']['subs'] ) )
				$players['home']['subs'] = array_filter( $players['home']['subs'], 'tb_array_filter_checked' );
		}
		if ( is_array( $players ) && array_key_exists( 'away', $players ) && is_array( $players['away'] ) ) {
			if ( array_key_exists( 'lineup', $players['away'] ) &&  is_array( $players['away']['lineup'] ) )
				$players['away']['lineup'] = array_filter( $players['away']['lineup'], 'tb_array_filter_checked' );
			if ( array_key_exists( 'subs', $players['away'] ) &&  is_array( $players['away']['subs'] ) )
				$players['away']['subs'] = array_filter( $players['away']['subs'], 'tb_array_filter_checked' );
		}
		update_post_meta( $post->ID, 'tb_players', serialize( $players ) );
		// add comps and sesaons to clubs
		wp_set_post_terms( $home_club, $comp, 'tb_comp', true );
		wp_set_post_terms( $home_club, $season, 'tb_season', true );
		wp_set_post_terms( $away_club, $comp, 'tb_comp', true );
		wp_set_post_terms( $away_club, $season, 'tb_season', true );
	}
}
// edit columns
function tb_match_edit_columns($columns) {
	$columns = array(
		'cb' => '<input type="checkbox" />',
		'title' => __( 'Fixture', 'themeboy' ),
		'comp' => __( 'Competition', 'themeboy' ),
		'season' => __( 'Season', 'themeboy' ),
		'venue' => __( 'Venue', 'themeboy' ),
		'date' => __( 'Date' ),
		'kickoff' => __( 'Kick-off', 'themeboy' ),
		'results' => __( 'Results', 'themeboy' )
	);
	return $columns;
}
// custom columns
function tb_match_custom_columns($column) {
	global $post, $typenow;
	$post_id = $post->ID;
	if ( $typenow == 'tb_match' ) {
		switch ($column) {
		case 'comp' :
			the_terms( $post_id, 'tb_comp' );
			break;
		case 'season' :
			the_terms( $post_id, 'tb_season' );
			break;
		case 'venue' :
			the_terms( $post_id, 'tb_venue' );
			break;
		case 'date' :
			echo get_the_date ( get_option ( 'date_format' ) );
			break;
		case 'kickoff' :
			echo get_the_time ( get_option ( 'time_format' ) );
			break;
		case 'results' :
			$played = get_post_meta( $post_id, 'tb_played', true );
			if ( $played ) {
				echo get_post_meta( $post_id, 'tb_home_goals', true ) . ' ' . get_option( 'tb_match_goals_delimiter' ) . ' ' . get_post_meta( $post_id, 'tb_away_goals', true );
			}
			break;
		}
	}
}
// taxonomy filter dropdowns
function tb_match_request_filter_dropdowns() {
	global $typenow, $wp_query;
	if ( $typenow == 'tb_match' ) {
		// comp dropdown
		$selected = isset( $_REQUEST['tb_comp'] ) ? $_REQUEST['tb_comp'] : null;
		$args = array(
			'show_option_all' =>  sprintf( __( 'Show all %s', 'themeboy' ), __( 'competitions', 'themeboy' ) ),
			'taxonomy' => 'tb_comp',
			'name' => 'tb_comp',
			'selected' => $selected
		);
		tb_dropdown_taxonomies($args);
		echo PHP_EOL;
		// season dropdown
		$selected = isset( $_REQUEST['tb_season'] ) ? $_REQUEST['tb_season'] : null;
		$args = array(
			'show_option_all' =>  sprintf( __( 'Show all %s', 'themeboy' ), __( 'seasons', 'themeboy' ) ),
			'taxonomy' => 'tb_season',
			'name' => 'tb_season',
			'selected' => $selected
		);
		tb_dropdown_taxonomies($args);
		echo PHP_EOL;
		// venue dropdown
		$selected = isset( $_REQUEST['tb_venue'] ) ? $_REQUEST['tb_venue'] : null;
		$args = array(
			'show_option_all' =>  sprintf( __( 'Show all %s', 'themeboy' ), __( 'venues', 'themeboy' ) ),
			'taxonomy' => 'tb_venue',
			'name' => 'tb_venue',
			'selected' => $selected
		);
		tb_dropdown_taxonomies($args);
	}
}
?>