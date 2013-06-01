<?php
add_action('init', 'tb_venue_init', 0);
add_action('tb_venue_edit_form_fields','tb_venue_extra_fields', 10, 2);
add_action('edited_tb_venue', 'save_tb_venue_extra_fields', 10, 2);
add_filter('manage_edit-tb_venue_columns', 'tb_venue_edit_columns');
add_action('manage_tb_venue_custom_column', 'tb_venue_custom_columns', 5,3);

function tb_venue_init() {
	register_taxonomy(
		'tb_venue',
		'tb_match',
		array(
			'hierarchical' => true,
			'labels' => array(
				'name' => __( 'Venues', 'themeboy' ),
				'singular_name' => __( 'Venue', 'themeboy' ),
				'search_items' =>  sprintf( __( 'Search %s', 'themeboy' ), __( 'Venues', 'themeboy' ) ),
				'all_items' => sprintf( __( 'All %s', 'themeboy' ), __( 'Venues', 'themeboy' ) ),
				'parent_item' => sprintf( __( 'Parent %s', 'themeboy' ), __( 'Venue', 'themeboy' ) ),
				'parent_item_colon' => sprintf( __( 'Parent %s:', 'themeboy' ), __( 'Venue', 'themeboy' ) ),
				'edit_item' => sprintf( __( 'Edit %s', 'themeboy' ), __( 'Venue', 'themeboy' ) ),
				'update_item' => sprintf( __( 'Update %s', 'themeboy' ), __( 'Venue', 'themeboy' ) ),
				'add_new_item' => sprintf( __( 'Add New %s', 'themeboy' ), __( 'Venue', 'themeboy' ) ),
				'new_item_name' => __( 'Venue', 'themeboy' )
			),
			'sort' => true,
			'rewrite' => array( 'slug' => 'venue' )
		)
	);
}

function tb_venue_edit_columns($columns) {
	$columns = array(
		"cb" => "<input type=\"checkbox\" />",
		"name" => __('Name', 'themeboy'),
		"address" => __('Address', 'themeboy'),
		"posts" => __('Matches', 'themeboy')
	);
	return $columns;
}

function tb_venue_custom_columns($value, $column, $t_id) {
	global $post;
	$term_meta = get_option( "taxonomy_term_$t_id" );
	switch ($column) {
	case 'tb_address':
		echo $term_meta['tb_address'];
		break;
	}
}

function tb_venue_extra_fields( $tag ) {
	$t_id = $tag->term_id;
	$term_meta = get_option( "taxonomy_term_$t_id" );
?>
	<tr class="form-field">
		<th scope="row" valign="top">
			<label for="term_meta[tb_address]"><?php _e('Venue Address', 'themeboy'); ?></label>
		</th>
		<td>
			<input name="term_meta[tb_address]" id="term_meta[tb_address]" type="text" value="<?php echo $term_meta['tb_address'] ? $term_meta['tb_address'] : '' ?>" size="40"><br />
		</td>
	</tr>
<?php
}

function save_tb_venue_extra_fields( $term_id ) {
	if ( isset( $_POST['term_meta'] ) ) {
		$t_id = $term_id;
		$term_meta = get_option( "taxonomy_term_$t_id" );
		$cat_keys = array_keys( $_POST['term_meta'] );
			foreach ( $cat_keys as $key ){
			if ( isset( $_POST['term_meta'][$key] ) ){
				$term_meta[$key] = $_POST['term_meta'][$key];
			}
		}
		update_option( "taxonomy_term_$t_id", $term_meta );
	}
}
?>