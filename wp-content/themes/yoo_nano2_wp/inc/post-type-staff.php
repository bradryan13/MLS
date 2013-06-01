<?php
add_action( 'init', 'tb_staff_init' );
add_action( 'admin_init', 'tb_staff_meta_boxes' );
add_filter( 'gettext', 'tb_staff_text_replace', 10, 4 );
add_action( 'save_post', 'save_tb_staff' );
add_filter( 'manage_edit-tb_staff_columns', 'tb_staff_edit_columns' );
add_action( 'manage_tb_staff_posts_custom_column', 'tb_staff_custom_columns' );
add_filter( 'manage_edit-tb_staff_sortable_columns', 'tb_staff_sortable_columns' );
add_filter( 'request', 'tb_staff_column_orderby' );
add_action( 'restrict_manage_posts', 'tb_staff_request_filter_dropdowns' );

// initialize
function tb_staff_init() {
	$labels = array( 
		'name' => __( 'Staff', 'themeboy' ),
		'singular_name' => __( 'Staff', 'themeboy' ),
		'add_new' => __( 'Add New', 'themeboy' ),
		'all_items' => sprintf( __( 'All %s', 'themeboy' ), __( 'Staff', 'themeboy' ) ),
		'add_new_item' => sprintf( __( 'Add New %s', 'themeboy' ), __( 'Staff', 'themeboy' ) ),
		'edit_item' => sprintf( __( 'Edit %s', 'themeboy' ), __( 'Staff', 'themeboy' ) ),
		'new_item' => sprintf( __( 'New %s', 'themeboy' ), __( 'Staff', 'themeboy' ) ),
		'view_item' => sprintf( __( 'View %s', 'themeboy' ), __( 'Staff', 'themeboy' ) ),
		'search_items' => sprintf( __( 'Search %s', 'themeboy' ), __( 'Staff', 'themeboy' ) ),
		'not_found' => sprintf( __( 'No %s found', 'themeboy' ), __( 'staff', 'themeboy' ) ),
		'not_found_in_trash' => sprintf( __( 'No %s found in trash', 'themeboy' ), __( 'staff', 'themeboy' ) ),
		'parent_item_colon' => sprintf( __( 'Parent %s:', 'themeboy' ), __( 'Staff', 'themeboy' ) ),
		'menu_name' => __( 'Staff', 'themeboy' )
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
		'exclude_from_search' => true,
		'has_archive' => false,
		'query_var' => true,
		'can_export' => true,
		'rewrite' => array( 'slug' => 'staff' ),
		'capability_type' => 'post'
	);
	register_post_type( 'tb_staff', $args );
};
// initialize admin
function tb_staff_meta_boxes() {
	add_meta_box( 'tb_staff-basic-meta', __( 'Basic Information', 'themeboy' ), 'tb_staff_basic_meta', 'tb_staff', 'normal', 'core' );
}
// text replace
function tb_staff_text_replace($input, $text, $domain) {
	global $post;
	if (is_admin()) {
		$translations = &get_translations_for_domain($domain);
		if (get_post_type() == 'tb_staff') {
			if ( $text == 'Enter title here')	return __( 'Name' );
		}
	}
	return $input;
}
// staff basic information meta box
function tb_staff_basic_meta() {
	global $post, $wp_locale, $soccer_positions;
	$selected_club = get_post_meta( $post->ID, 'tb_club', true );
	$dob = get_post_meta( $post->ID, 'tb_dob', true );
	if ( empty( $dob ) ) $dob = '1986-01-01';
	$dob_month = substr( $dob, 5, 2 );
	$dob_day = substr( $dob, 8, 2 );
	$dob_year = substr( $dob, 0, 4 );
	$natl = get_post_meta( $post->ID, 'tb_natl', true );
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
<?php wp_reset_postdata(); ?>
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
	<label><?php _e( 'Nationality', 'themeboy' ); ?>:</label>
<?php
	global $tb_countries_of_the_world;
	asort($tb_countries_of_the_world);
	$natl = (isset($natl) ? $natl : get_option('tb_region_code'));
	echo form_dropdown('tb_natl', $tb_countries_of_the_world, $natl);
?>
</p>
<?php
	echo '<input type="hidden" name="tb_staff_basic_meta_nonce" id="tb_staff_basic_meta_nonce" value="'.wp_create_nonce( plugin_basename(__FILE__) ).'" />';
}
// save post
function save_tb_staff() {
	global $post;
	if (get_post_type() == 'tb_staff') {
		if ( !wp_verify_nonce( $_POST['tb_staff_basic_meta_nonce'], plugin_basename(__FILE__) )) return $post_id;
		if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ) return $post_id;
		$dob_year = substr( zeroise( (int) $_POST['tb_dob_year'], 4 ), 0, 4 );
		$dob_month = substr( zeroise( (int) $_POST['tb_dob_month'], 2 ), 0, 2 );
		$dob_day = substr( zeroise( (int) $_POST['tb_dob_day'], 2 ), 0, 2 );
		update_post_meta( $post->ID, 'tb_club', $_POST['tb_club'] );		
		update_post_meta( $post->ID, 'tb_dob', $dob_year . '-' . $dob_month. '-' . $dob_day );
		update_post_meta( $post->ID, 'tb_natl', $_POST['tb_natl'] );
	}
}
// edit columns
function tb_staff_edit_columns($columns) {
	$columns = array(
		'cb' => '<input type="checkbox" />',
		'title' => __( 'Name' ),
		'natl' => __( 'Nationality', 'themeboy' ),
		'dob' => __( 'Date of Birth', 'themeboy' ),
		'club' => __( 'Club', 'themeboy' ),
		'team' => __( 'Team', 'themeboy' )
	);
	return $columns;	
}
// custom columns
function tb_staff_custom_columns($column) {
	global $post, $typenow;
	$post_id = $post->ID;
	if ( $typenow == 'tb_staff' ) {
		switch ($column) {
		case 'natl':
			global $tb_countries_of_the_world;
			$natl = get_post_meta( $post_id, 'tb_natl', true );
			echo $tb_countries_of_the_world[$natl];
			break;
		case 'dob':
			$dob = get_post_meta($post_id, 'tb_dob', true );
			echo get_the_date( get_option( 'date_format' ), strtotime( $dob ) );
			break;
		case 'club':
			$club = get_post_meta( $post_id, 'tb_club', true );
			echo get_the_title( $club );
			break;
		case 'team':
			the_terms($post_id, 'tb_team');
			break;
		}
	}
}
// sortable columns
function tb_staff_sortable_columns($columns) {
	$custom = array(
		'club' => 'club',
		'dob' => 'dob',
		'natl' => 'natl'
	);
	return wp_parse_args($custom, $columns);
}
// column sorting rules
function tb_staff_column_orderby( $vars ) {
	global $pagenow;
	if ( $pagenow == 'edit.php' && $vars['post_type'] == 'tb_staff' && isset( $vars['orderby'] )):
		if ( in_array( $vars['orderby'], array( 'club', 'dob', 'natl' ) ) ):
			$vars = array_merge( $vars, array(
				'meta_key' => 'tb_' . $vars['orderby'],
				'orderby' => 'meta_value'
			) );
		endif;
	endif;
	return $vars;
}
// taxonomy filter dropdowns
function tb_staff_request_filter_dropdowns() {
	global $typenow, $wp_query;
	if ( $typenow == 'tb_staff' ) {
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