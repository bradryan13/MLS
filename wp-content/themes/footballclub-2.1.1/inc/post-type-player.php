<?php
add_action( 'init', 'tb_player_init' );
add_action( 'admin_init', 'tb_player_meta_boxes' );
add_filter( 'gettext', 'tb_player_text_replace', 10, 4 );
add_action( 'save_post', 'save_tb_player' );
add_filter( 'manage_edit-tb_player_columns', 'tb_player_edit_columns' );
add_action( 'manage_tb_player_posts_custom_column', 'tb_player_custom_columns' );
add_filter( 'manage_edit-tb_player_sortable_columns', 'tb_player_sortable_columns' );
add_filter( 'request', 'tb_player_column_orderby' );
add_action( 'restrict_manage_posts', 'tb_player_request_filter_dropdowns' );

// initialize
function tb_player_init() {
	$labels = array( 
		'name' => __( 'Players', 'themeboy' ),
		'singular_name' => __( 'Player', 'themeboy' ),
		'add_new' => __( 'Add New', 'themeboy' ),
		'all_items' => sprintf( __( 'All %s', 'themeboy' ), __( 'Players', 'themeboy' ) ),
		'add_new_item' => sprintf( __( 'Add New %s', 'themeboy' ), __( 'Player', 'themeboy' ) ),
		'edit_item' => sprintf( __( 'Edit %s', 'themeboy' ), __( 'Player', 'themeboy' ) ),
		'new_item' => sprintf( __( 'New %s', 'themeboy' ), __( 'Player', 'themeboy' ) ),
		'view_item' => sprintf( __( 'View %s', 'themeboy' ), __( 'Player', 'themeboy' ) ),
		'search_items' => sprintf( __( 'Search %s', 'themeboy' ), __( 'Players', 'themeboy' ) ),
		'not_found' => sprintf( __( 'No %s found', 'themeboy' ), __( 'players', 'themeboy' ) ),
		'not_found_in_trash' => sprintf( __( 'No %s found in trash', 'themeboy' ), __( 'players', 'themeboy' ) ),
		'parent_item_colon' => sprintf( __( 'Parent %s:', 'themeboy' ), __( 'Player', 'themeboy' ) ),
		'menu_name' => __( 'Players', 'themeboy' )
	);
	$args = array( 
		'labels' => $labels,
		'hierarchical' => false,
		'supports' => array( 'title', 'editor', 'thumbnail' ),
		'public' => true,
		'show_ui' => true,
		'show_in_menu' => true,
		'show_in_nav_menus' => true,
		'publicly_queryable' => true,
		'exclude_from_search' => false,
		'has_archive' => false,
		'query_var' => true,
		'can_export' => true,
		'rewrite' => array( 'slug' => 'player' ),
		'capability_type' => 'post'
	);
	register_post_type( 'tb_player', $args );
};
// initialize admin
function tb_player_meta_boxes() {
	remove_meta_box( 'tb_positiondiv', 'tb_player', 'side' );
	add_meta_box( 'tb_player-basic-meta', __( 'Basic Information', 'themeboy' ), 'tb_player_basic_meta', 'tb_player', 'normal', 'core' );
	add_meta_box( 'tb_player-stats-meta', __( 'Statistics', 'themeboy' ), 'tb_player_stats_meta', 'tb_player', 'normal', 'low' );
}
// player basic information meta box
function tb_player_basic_meta() {
	global $post, $wp_locale, $soccer_positions;
	$selected_club = get_post_meta( $post->ID, 'tb_club', true );
	$number = get_post_meta( $post->ID, 'tb_number', true );
	$position_id = null;
	$positions = get_the_terms( $post->ID, 'tb_position' );
	if ( !empty( $positions ) )
		$position_id = $positions[0]->term_id;
	$dob = get_post_meta( $post->ID, 'tb_dob', true );
	if ( empty( $dob ) ) $dob = '1986-01-01';
	$dob_month = substr( $dob, 5, 2 );
	$dob_day = substr( $dob, 8, 2 );
	$dob_year = substr( $dob, 0, 4 );
	$natl = get_post_meta( $post->ID, 'tb_natl', true );
	$hometown = get_post_meta( $post->ID, 'tb_hometown', true );
	$time_adj = current_time( 'timestamp' );
?>
<?php
	$clubs = get_posts( array(
		'post_type' => 'tb_club',
		'orderby' => 'title',
		'order' => 'asc',
		'numberposts' => -1,
		'posts_per_page' => -1
	) );
?>
<p>
	<label for="tb_club"><?php _e( 'Club', 'themeboy' ); ?>:</label>
	<select name="tb_club" id="tb_club" class="postform">
		<?php foreach( $clubs as $club ) { ?>
			<option value="<?php echo $club->ID; ?>"<?php echo ( $club->ID == $selected_club ? ' selected' : '' ); ?>>
				<?php echo $club->post_title; ?>
			</option>
		<?php } ?>
	</select>
</p>
<p>
	<label for="tb_number"><?php _e( 'Number', 'themeboy' ); ?>:</label>
	<input type="text" name="tb_number" value="<?php echo $number; ?>" size="2" />
</p>
<p>
	<label><?php _e( 'Position', 'themeboy' ); ?>:</label>
	<?php
		wp_dropdown_categories( array(
			'show_option_none' => __( 'None' ),
			'orderby' => 'title',
			'hide_empty' => false,
			'taxonomy' => 'tb_position',
			'selected' => $position_id,
			'name' => 'tb_position'
		) );
	?>
</p>
<p>
	<label><?php _e( 'Date of Birth', 'themeboy' ); ?>:</label>
	<select name="tb_dob_month" id="tb_dob_month">
		<?php for ( $i = 1; $i < 13; $i = $i +1 ): ?>
			<option value="<?php echo zeroise($i, 2); ?>"<?php echo ($i == $dob_month ? ' selected="selected"' : ''); ?>>
				<?php echo zeroise($i, 2); ?>-<?php echo $wp_locale->get_month_abbrev( $wp_locale->get_month( $i ) ); ?>
			</option>
		<?php endfor; ?>
	</select>
	<input type="text" name="tb_dob_day" id="tb_dob_day" value="<?php echo $dob_day; ?>" size="2" maxlength="2" autocomplete="off" />
	<input type="text" name="tb_dob_year" id="tb_dob_year" value="<?php echo $dob_year; ?>" size="4" maxlength="4" autocomplete="off" />
</p>
<p>
	<label><?php _e( 'Hometown', 'themeboy' ); ?>:</label>
	<input type="text" name="tb_hometown" id="tb_hometown" value="<?php echo $hometown; ?>" />
<?php
	global $tb_countries_of_the_world;
	asort($tb_countries_of_the_world);
	$natl = (isset($natl) ? $natl : get_option('tb_region_code'));
	echo form_dropdown('tb_natl', $tb_countries_of_the_world, $natl);
	echo '<input type="hidden" name="tb_player_basic_meta_nonce" id="tb_player_basic_meta_nonce" value="'.wp_create_nonce( plugin_basename(__FILE__) ).'" />';
}
// player statistics meta box
function tb_player_stats_meta() {
	global $post_id;
	$stats = get_tb_player_stats( $post_id );
	$seasons = get_the_terms( $post_id, 'tb_season' );
?>
<div class="statsydiv">
	<ul class="tb_stats-tabs category-tabs">
		<li class="tabs"><a href="#tb_team-0_season-0" tabindex="3"><?php printf( __( 'All %s', 'themeboy' ), __( 'Seasons', 'themeboy' ) ); ?></a></li>
		<?php if( is_array( $seasons ) ): foreach( $seasons as $season ): ?>
			<li class="hide-if-no-js22"><a href="#tb_team-0_season-<?php echo $season->term_id; ?>" tabindex="3"><?php echo $season->name; ?></a></li>
		<?php endforeach; endif; ?>
	</ul>
	<?php if( is_array( $seasons ) ): foreach( $seasons as $season ): ?>
		<div id="tb_team-0_season-<?php echo $season->term_id; ?>" class="wp-tab-panel" style="display: none;">
			<?php tb_player_stats_table( $stats, 0, $season->term_id ); ?>
		</div>
	<?php endforeach; endif; ?>
	<div id="tb_team-0_season-0" class="wp-tab-panel">
		<?php tb_player_stats_table( $stats, 0, 0 ); ?>
	</div>
</div>
<div class="clear"></div>
<script type="text/javascript">
(function($) {
	$('#tb_player-stats-meta input').change(function() {
		index = $(this).attr('data-index');
		value = 0;
		$(this).closest('table').find('tbody tr').each(function() {
			value += parseInt($(this).find('input[data-index="' + index + '"]').val());
		});
		$(this).closest('table').find('tfoot tr input[data-index="' + index + '"]').val(value);
		$('#leaguetable #totalstats-p').val(
			Number($('#leaguetable #autostats-p').val()) +
			Number($('#leaguetable #manualstats-p').val())
		);
		$('#leaguetable #totalstats-w').val(
			Number($('#leaguetable #autostats-w').val()) +
			Number($('#leaguetable #manualstats-w').val())
		);
		$('#leaguetable #totalstats-d').val(
			Number($('#leaguetable #autostats-d').val()) +
			Number($('#leaguetable #manualstats-d').val())
		);
		$('#leaguetable #totalstats-l').val(
			Number($('#leaguetable #autostats-l').val()) +
			Number($('#leaguetable #manualstats-l').val())
		);
		$('#leaguetable #totalstats-f').val(
			Number($('#leaguetable #autostats-f').val()) +
			Number($('#leaguetable #manualstats-f').val())
		);
		$('#leaguetable #totalstats-a').val(
			Number($('#leaguetable #autostats-a').val()) +
			Number($('#leaguetable #manualstats-a').val())
		);
		$('#leaguetable #totalstats-gd').val(
			Number($('#leaguetable #autostats-gd').val()) +
			Number($('#leaguetable #manualstats-gd').val())
		);
		$('#leaguetable #totalstats-pts').val(
			Number($('#leaguetable #autostats-pts').val()) +
			Number($('#leaguetable #manualstats-pts').val())
		);
	});
	// stats tabs
	$('.tb_stats-tabs a').click(function(){
		var t = $(this).attr('href');
		$(this).parent().addClass('tabs').siblings('li').removeClass('tabs');
		$(this).parent().parent().parent().find('.wp-tab-panel').hide();
		$(t).show();
		return false;
	});
})(jQuery);
</script>
<input type="hidden" name="tb_player_stats_meta_nonce" id="tb_player_stats_meta_nonce" value="<?php echo wp_create_nonce( plugin_basename(__FILE__) ); ?>" />
<?php
}
// text replace
function tb_player_text_replace($input, $text, $domain) {
	global $post;
	if (is_admin()) {
		$translations = &get_translations_for_domain($domain);
		if (get_post_type() == 'tb_player') {
			if ( $text == 'Enter title here')	return __( 'Name' );
			if ( $text == 'Scheduled for: <b>%1$s</b>' )	return __( 'Joined on: <b>%1$s</b>', 'themeboy' );
			if ( $text == 'Published on: <b>%1$s</b>' ) return __( 'Joined on: <b>%1$s</b>', 'themeboy' );
			if ( $text == 'Publish <b>immediately</b>' ) return __( 'Joined on: <b>%1$s</b>', 'themeboy' );
		}
	}
	return $input;
}
// save post
function save_tb_player() {
	global $post;
	if (get_post_type() == 'tb_player') {
		if ( !wp_verify_nonce( $_POST['tb_player_basic_meta_nonce'], plugin_basename(__FILE__) )) return $post_id;
		if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ) return $post_id;
		$dob_year = substr( zeroise( (int) $_POST['tb_dob_year'], 4 ), 0, 4 );
		$dob_month = substr( zeroise( (int) $_POST['tb_dob_month'], 2 ), 0, 2 );
		$dob_day = substr( zeroise( (int) $_POST['tb_dob_day'], 2 ), 0, 2 );
		update_post_meta( $post->ID, 'tb_club', $_POST['tb_club'] );		
		update_post_meta( $post->ID, 'tb_number', $_POST['tb_number'] );
		wp_set_post_terms( $post->ID, $_POST['tb_position'], 'tb_position' );
		update_post_meta( $post->ID, 'tb_dob', $dob_year . '-' . $dob_month. '-' . $dob_day );
		update_post_meta( $post->ID, 'tb_natl', $_POST['tb_natl'] );
		update_post_meta( $post->ID, 'tb_hometown', $_POST['tb_hometown'] );
		$stats = $_POST['tb_stats'];
		array_walk_recursive( $stats, 'tb_array_values_to_int' );
		update_post_meta( $post->ID, 'tb_stats', serialize( $stats ) );
	}
}
// edit columns
function tb_player_edit_columns($columns) {
	$columns = array(
		'cb' => '<input type="checkbox" />',
		'number' => '#',
		'title' => __( 'Name' ),
		'position' => __( 'Position', 'themeboy' ),
		'hometown' => __( 'Hometown', 'themeboy' ),
		'dob' => __( 'Date of Birth', 'themeboy' ),
		'club' => __( 'Club', 'themeboy' ),
		'team' => __( 'Team', 'themeboy' ),
		'season' => __( 'Season', 'themeboy' )
	);
	return $columns;	
}
// custom columns
function tb_player_custom_columns($column) {
	global $post, $typenow;
	$post_id = $post->ID;
	if ( $typenow == 'tb_player' ) {
		switch ($column) {
		case 'number':
			$number = get_post_meta($post_id, 'tb_number', true);		
			echo $number;
			break;
		case 'position':
			the_terms($post_id, 'tb_position');
			break;
		case 'dob':
			$dob = get_post_meta($post_id, 'tb_dob', true );
			echo get_the_date( get_option( 'date_format' ), strtotime( $dob ) );
			break;
		case 'hometown':
			global $tb_countries_of_the_world;
			$natl = get_post_meta( $post_id, 'tb_natl', true );
			$hometown = get_post_meta( $post_id, 'tb_hometown', true );
			echo $hometown . ' (' . $tb_countries_of_the_world[$natl] . ')';
			break;
		case 'club':
			$club = get_post_meta( $post_id, 'tb_club', true );
			echo get_the_title( $club );
			break;
		case 'team':
			the_terms($post_id, 'tb_team');
			break;
		case 'season':
			the_terms($post_id, 'tb_season');
			break;
		}
	}
}
// sortable columns
function tb_player_sortable_columns($columns) {
	$custom = array(
		'number' => 'number',
		'club' => 'club',
		'dob' => 'dob',
		'hometown' => 'hometown'
	);
	return wp_parse_args($custom, $columns);
}
// column sorting rules
function tb_player_column_orderby( $vars ) {
	global $pagenow;
	if ( $pagenow == 'edit.php' && $vars['post_type'] == 'tb_player' && isset( $vars['orderby'] )):
		if ( $vars['orderby'] == 'number' ):
			$vars = array_merge( $vars, array(
				'meta_key' => 'tb_number',
				'orderby' => 'meta_value_num'
			) );
		elseif ( in_array( $vars['orderby'], array(  'club', 'position', 'dob', 'hometown' ) ) ):
			$vars = array_merge( $vars, array(
				'meta_key' => 'tb_' . $vars['orderby'],
				'orderby' => 'meta_value'
			) );
		endif;
	endif;
	return $vars;
}
// taxonomy filter dropdowns
function tb_player_request_filter_dropdowns() {
	global $typenow, $wp_query;
	if ( $typenow == 'tb_player' ) {
		// position dropdown
		$selected = isset( $_REQUEST['tb_position'] ) ? $_REQUEST['tb_position'] : null;
		$args = array(
			'show_option_all' =>  sprintf( __( 'Show all %s', 'themeboy' ), __( 'players', 'themeboy' ) ),
			'taxonomy' => 'tb_position',
			'name' => 'tb_position',
			'selected' => $selected
		);
		tb_dropdown_taxonomies($args);
		echo PHP_EOL;
		// team dropdown
		$selected = isset( $_REQUEST['tb_team'] ) ? $_REQUEST['tb_team'] : null;
		$args = array(
			'show_option_all' =>  sprintf( __( 'Show all %s', 'themeboy' ), __( 'teams', 'themeboy' ) ),
			'taxonomy' => 'tb_team',
			'name' => 'tb_team',
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
	}
}
?>