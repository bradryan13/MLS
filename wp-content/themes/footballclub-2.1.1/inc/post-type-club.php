<?php
add_action( 'init', 'tb_club_init' );
add_action( 'admin_init', 'tb_club_meta_boxes' );
add_action( 'save_post', 'save_tb_club' );
add_filter( 'manage_edit-tb_club_columns', 'tb_club_edit_columns' );
add_action( 'manage_posts_custom_column', 'tb_club_custom_columns' );
add_action( 'restrict_manage_posts', 'tb_club_request_filter_dropdowns' );
// initialize
function tb_club_init() {
	$labels = array( 
		'name' => __( 'Clubs', 'themeboy' ),
		'singular_name' => __( 'Club', 'themeboy' ),
		'add_new' => __( 'Add New', 'themeboy' ),
		'all_items' => sprintf( __( 'All %s', 'themeboy' ), __( 'Clubs', 'themeboy' ) ),
		'add_new_item' => sprintf( __( 'Add New %s', 'themeboy' ), __( 'Club', 'themeboy' ) ),
		'edit_item' => sprintf( __( 'Edit %s', 'themeboy' ), __( 'Club', 'themeboy' ) ),
		'new_item' => sprintf( __( 'New %s', 'themeboy' ), __( 'Club', 'themeboy' ) ),
		'view_item' => sprintf( __( 'View %s', 'themeboy' ), __( 'Club', 'themeboy' ) ),
		'search_items' => sprintf( __( 'Search %s', 'themeboy' ), __( 'Clubs', 'themeboy' ) ),
		'not_found' => sprintf( __( 'No %s found', 'themeboy' ), __( 'clubs', 'themeboy' ) ),
		'not_found_in_trash' => sprintf( __( 'No %s found in trash', 'themeboy' ), __( 'clubs', 'themeboy' ) ),
		'parent_item_colon' => sprintf( __( 'Parent %s:', 'themeboy' ), __( 'Club', 'themeboy' ) ),
		'menu_name' => __( 'Clubs', 'themeboy' )
	);
	$args = array( 
		'labels' => $labels,
		'hierarchical' => false,
		'supports' => array( 'title', 'thumbnail' ),
		'public' => true,
		'show_ui' => true,
		'show_in_menu' => true,
		'show_in_nav_menus' => true,
		'publicly_queryable' => true,
		'exclude_from_search' => true,
		'has_archive' => false,
		'query_var' => true,
		'can_export' => true,
		'rewrite' => array( 'slug' => 'club' ),
		'capability_type' => 'post'
	);
	register_post_type( 'tb_club', $args );
};
// initialize admin
function tb_club_meta_boxes() {
	add_meta_box( 'tb_club-stats-meta', __( 'Statistics', 'themeboy' ), 'tb_club_stats_meta', 'tb_club', 'normal', 'low' );
}
// club statistics table function
function tb_club_stats_table( $stats = array(), $comp = 0, $season = 0 ) {
	global $tb_standings_stats_labels;
	if ( array_key_exists( $comp, $stats ) ): if ( array_key_exists( $season, $stats[$comp] ) ):
		$stats = $stats[$comp][$season];
	endif; endif;
?>
	<table>
		<thead>
			<tr>
				<td>&nbsp;</td>
				<?php foreach( $tb_standings_stats_labels as $key => $val ): ?>
					<th><?php echo $val; ?></th>
				<?php endforeach; ?>
			</tr>
		</thead>
		<tfoot>
			<tr>
				<th align="right">Total</th>
				<?php foreach( $tb_standings_stats_labels as $key => $val ): ?>
					<td><input type="text" data-index="<?php echo $key; ?>" value="<?php tb_stats_value( $stats, 'total', $key ); ?>" size="1" tabindex="-1" readonly /></td>
				<?php endforeach; ?>
			</tr>
		</tfoot>
		<tbody>
			<tr>
				<td align="right"><?php _e( 'Auto' ); ?></td>
				<?php foreach( $tb_standings_stats_labels as $key => $val ): ?>
					<td><input type="text" data-index="<?php echo $key; ?>" value="<?php tb_stats_value( $stats, 'auto', $key ); ?>" size="1" tabindex="-1" readonly /></td>
				<?php endforeach; ?>
			</tr>
			<tr>
				<td align="right"><?php _e( 'Manual' ); ?></td>
				<?php foreach( $tb_standings_stats_labels as $key => $val ): ?>
					<td><input type="text" data-index="<?php echo $key; ?>" name="tb_stats[<?php echo $comp; ?>][<?php echo $season; ?>][<?php echo $key; ?>]" value="<?php tb_stats_value( $stats, 'manual', $key ); ?>" size="1" /></td>
				<?php endforeach; ?>
			</tr>
		</tbody>
	</table>
<?php
}
// club statistics meta box
function tb_club_stats_meta() {
	global $post;
	$comps = get_the_terms( $post->ID, 'tb_comp' );
	$seasons = get_the_terms( $post->ID, 'tb_season' );
	$stats = get_tb_club_stats( $post );
	if( is_array( $comps ) ) { foreach( $comps as $comp ) {
		$name = $comp->name;
		if ( $comp->parent ) {
			$parent_comp = get_term( $comp->parent, 'tb_comp');
			$name .= ' (' . $parent_comp->name . ')';
		}
?>
	<div class="statsdiv">
		<h4><?php echo $name; ?></h4>
		<ul class="tb_stats-tabs category-tabs">
			<li class="tabs"><a href="#tb_comp-<?php echo $comp->term_id; ?>_season-0" tabindex="3"><?php printf( __( 'All %s', 'themeboy' ), __( 'Seasons', 'themeboy' ) ); ?></a></li>
			<?php if(is_array($seasons)): foreach($seasons as $season): ?>
				<li class="hide-if-no-js"><a href="#tb_comp-<?php echo $comp->term_id; ?>_season-<?php echo $season->term_id; ?>" tabindex="3"><?php echo $season->name; ?></a></li>
			<?php endforeach; endif; ?>
		</ul>
		<?php if(is_array($seasons)): foreach($seasons as $season): ?>
			<div id="tb_comp-<?php echo $comp->term_id; ?>_season-<?php echo $season->term_id; ?>" class="tabs-panel" style="display: none;">
				<?php tb_club_stats_table($stats, $comp->term_id, $season->term_id); ?>
			</div>
		<?php endforeach; endif; ?>
		<div id="tb_comp-<?php echo $comp->term_id; ?>_season-0" class="tabs-panel">
		<?php tb_club_stats_table($stats, $comp->term_id, 0); ?>
		</div>
	</div>
	<div class="clear"></div>
<?php } } ?>
<div class="statsdiv">
	<?php if( is_array( $comps ) ) { ?>
		<h4><?php printf( __( 'All %s', 'themeboy' ), __( 'Competitions', 'themeboy' ) ); ?></h4>
	<?php } ?>
	<ul class="tb_stats-tabs category-tabs">
		<li class="tabs"><a href="#tb_comp-0_season-0" tabindex="3"><?php printf( __( 'All %s', 'themeboy' ), __( 'Seasons', 'themeboy' ) ); ?></a></li>
		<?php if( is_array( $seasons ) ): foreach( $seasons as $season ): ?>
			<li class="hide-if-no-js22"><a href="#tb_comp-0_season-<?php echo $season->term_id; ?>" tabindex="3"><?php echo $season->name; ?></a></li>
		<?php endforeach; endif; ?>
	</ul>
	<?php if( is_array( $seasons ) ): foreach( $seasons as $season ): ?>
		<div id="tb_comp-0_season-<?php echo $season->term_id; ?>" class="tabs-panel" style="display: none;">
			<?php tb_club_stats_table( $stats, 0, $season->term_id ); ?>
		</div>
	<?php endforeach; endif; ?>
	<div id="tb_comp-0_season-0" class="tabs-panel">
		<?php tb_club_stats_table( $stats, 0, 0 ); ?>
	</div>
</div>
<div class="clear"></div>
<script type="text/javascript">
(function($) {
	$('#tb_club-stats-meta input').change(function() {
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
		$(this).parent().parent().parent().find('.tabs-panel').hide();
		$(t).show();
		return false;
	});
})(jQuery);
</script>
<input type="hidden" name="tb_clubstats_meta_nonce" id="tb_clubstats_meta_nonce" value="<?php echo wp_create_nonce( plugin_basename(__FILE__) ); ?>" />
<?php
}
// save post
function save_tb_club() {
	global $post;
	if ( get_post_type() == 'tb_club' ) {
		if ( !wp_verify_nonce( $_POST['tb_clubstats_meta_nonce'], plugin_basename(__FILE__) ) ) return $post_id;
		if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ) return $post_id;
		$stats = $_POST['tb_stats'];
		array_walk_recursive( $stats, 'tb_array_values_to_int' );
		update_post_meta( $post->ID, 'tb_stats', serialize( $stats ) );
	}
}
// edit columns
function tb_club_edit_columns($columns) {
	$columns = array(
		'cb' => "<input type=\"checkbox\" />",
		'crest' => '',
		'title' => __( 'Club', 'themeboy' ),
		'p' => get_option( 'tb_standings_p_label' ),
		'w' => get_option( 'tb_standings_w_label' ),
		'd' => get_option( 'tb_standings_d_label' ),
		'l' => get_option( 'tb_standings_l_label' ),
		'f' => get_option( 'tb_standings_f_label' ),
		'a' => get_option( 'tb_standings_a_label' ),
		'gd' => get_option( 'tb_standings_gd_label' ),
		'pts' => get_option( 'tb_standings_pts_label' ),
	);
	return $columns;
}
// custom columns
function tb_club_custom_columns($column) {
	global $post, $typenow;
	$post_id = $post->ID;
	if ( $typenow == 'tb_club' ) {
		if ( $column == 'crest' ) {
			echo get_the_post_thumbnail( $post_id, 'crest-small' );
		} elseif( array_key_exists( $column, get_tb_club_stats_empty_row() ) ) {
			// get comp id
			if	( isset( $_REQUEST['tb_comp'] ) && $_REQUEST['tb_comp'] != '0' ) {
				$slug = $_REQUEST['tb_comp'];
				$term = get_term_by( 'slug', $slug, 'tb_comp' );
				$comp_id = $term->term_id;
			} else {
				$comp_id = null;
			}
			// get season id
			if	( isset( $_REQUEST['tb_season'] ) && $_REQUEST['tb_season'] != '0' ) {
				$slug = $_REQUEST['tb_season'];
				$term = get_term_by( 'slug', $slug, 'tb_season' );
				$season_id = $term->term_id;
			} else {
				$season_id = null;
			}
			$season = isset( $_REQUEST['tb_season'] ) ? $_REQUEST['tb_season'] : null;
			$stats = get_tb_club_total_stats( $post_id, $comp_id, $season_id );
			echo $stats[$column];
		}
	}
}
// taxonomy filter dropdowns
function tb_club_request_filter_dropdowns() {
	global $typenow, $wp_query;
	if ( $typenow == 'tb_club' ) {
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
	}
}
?>