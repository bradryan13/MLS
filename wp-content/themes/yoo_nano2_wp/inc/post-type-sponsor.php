<?php
add_action( 'init', 'tb_sponsor_init' );
add_action( 'admin_init', 'tb_sponsor_meta_boxes' );
add_filter( 'gettext', 'tb_sponsor_text_replace', 10, 4 );
add_action( 'save_post', 'save_tb_sponsor' );
add_filter( 'manage_edit-tb_sponsor_columns', 'tb_sponsor_edit_columns' );
add_action( 'manage_tb_sponsor_posts_custom_column', 'tb_sponsor_custom_columns' );
add_filter( 'manage_edit-tb_sponsor_sortable_columns', 'tb_sponsor_sortable_columns' );
add_filter( 'request', 'tb_sponsor_column_orderby' );

// initialize
function tb_sponsor_init() {
	$labels = array( 
		'name' => __( 'Sponsors', 'themeboy' ),
		'singular_name' => __( 'Sponsor', 'themeboy' ),
		'add_new' => __( 'Add New', 'themeboy' ),
		'all_items' => sprintf( __( 'All %s', 'themeboy' ), __( 'Sponsors', 'themeboy' ) ),
		'add_new_item' => sprintf( __( 'Add New %s', 'themeboy' ), __( 'Sponsor', 'themeboy' ) ),
		'edit_item' => sprintf( __( 'Edit %s', 'themeboy' ), __( 'Sponsor', 'themeboy' ) ),
		'new_item' => sprintf( __( 'New %s', 'themeboy' ), __( 'Sponsor', 'themeboy' ) ),
		'view_item' => sprintf( __( 'View %s', 'themeboy' ), __( 'Sponsor', 'themeboy' ) ),
		'search_items' => sprintf( __( 'Search %s', 'themeboy' ), __( 'Sponsors', 'themeboy' ) ),
		'not_found' => sprintf( __( 'No %s found', 'themeboy' ), __( 'sponsors', 'themeboy' ) ),
		'not_found_in_trash' => sprintf( __( 'No %s found in trash', 'themeboy' ), __( 'sponsors', 'themeboy' ) ),
		'parent_item_colon' => sprintf( __( 'Parent %s:', 'themeboy' ), __( 'Sponsor', 'themeboy' ) ),
		'menu_name' => __( 'Sponsors', 'themeboy' )
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
		'rewrite' => array( 'slug' => 'sponsor' ),
		'capability_type' => 'post'
	);
	register_post_type( 'tb_sponsor', $args );
};
// initialize admin
function tb_sponsor_meta_boxes() {
	add_meta_box( 'tb_sponsor-basic-meta', __( 'Basic Information', 'themeboy' ), 'tb_sponsor_basic_meta', 'tb_sponsor', 'normal', 'core' );
}
// text replace
function tb_sponsor_text_replace($input, $text, $domain) {
	global $post;
	if (is_admin()) {
		$translations = &get_translations_for_domain($domain);
		if (get_post_type() == 'tb_sponsor') {
			if ( $text == 'Enter title here')	return __( 'Name' );
		}
	}
	return $input;
}
// sponsor basic information meta box
function tb_sponsor_basic_meta() {
	global $post;
	$link_directly = get_post_meta( $post->ID, 'tb_link_directly', true );
	$link_url = get_post_meta( $post->ID, 'tb_link_url', true );
?>
<p>
	<label><?php _e( 'Link URL', 'themeboy' ); ?>:</label>
	<input type="text" name="tb_link_url" id="tb_link_url" class="regular-text" value="<?php echo $link_url; ?>" />
</p>
<p>
	<label class="selectit">
		<input type="checkbox" data-player="<?php the_ID(); ?>" name="tb_link_directly" value="1" <?php checked( true, $link_directly ); ?> />
		<?php _e( 'Link directly' ); ?>
	</label>
</p>
<?php
	echo '<input type="hidden" name="tb_sponsor_basic_meta_nonce" id="tb_sponsor_basic_meta_nonce" value="'.wp_create_nonce( plugin_basename(__FILE__) ).'" />';
}
// save post
function save_tb_sponsor() {
	global $post;
	if (get_post_type() == 'tb_sponsor') {
		if ( !wp_verify_nonce( $_POST['tb_sponsor_basic_meta_nonce'], plugin_basename(__FILE__) )) return $post_id;
		if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ) return $post_id;
		$link_url = $_POST['tb_link_url'];
		$link_directly = isset( $_POST['tb_link_directly'] ) ? $_POST['tb_link_directly'] : 0;
		if ( isset( $link_url ) && strpos( $link_url, 'http://' ) === false )
			$link_url = 'http://' . $link_url;
		update_post_meta( $post->ID, 'tb_link_url', $link_url );
		update_post_meta( $post->ID, 'tb_link_directly', $link_directly );
	}
}
// edit columns
function tb_sponsor_edit_columns($columns) {
	$columns = array(
		'cb' => '<input type="checkbox" />',
		'title' => __( 'Name' ),
		'link_url' => __( 'URL', 'themeboy' ),
		'link_directly' => __( 'Link directly?', 'themeboy' )
	);
	return $columns;
}
// custom columns
function tb_sponsor_custom_columns($column) {
	global $post, $typenow;
	$post_id = $post->ID;
	if ( $typenow == 'tb_sponsor' ) {
		switch ($column) {
		case 'link_url':
			$link_url = get_post_meta( $post_id, 'tb_link_url', true );
			if ( isset( $link_url ) )
				echo '<a href="'.$link_url.'" target="_blank">' . $link_url . '</a>';
			break;
		case 'link_directly':
			$link_directly = get_post_meta($post_id, 'tb_link_directly', true );
			echo $link_directly ? __( 'Yes' ) : __( 'No' );
			break;
		}
	}
}
// sortable columns
function tb_sponsor_sortable_columns($columns) {
	$custom = array(
		'link_url' => 'link_url',
		'link_directly' => 'link_directly'
	);
	return wp_parse_args($custom, $columns);
}
// column sorting rules
function tb_sponsor_column_orderby( $vars ) {
	global $pagenow;
	if ( $pagenow == 'edit.php' && $vars['post_type'] == 'tb_sponsor' && isset( $vars['orderby'] )):
		if ( in_array( $vars['orderby'], array( 'link_url', 'link_directly' ) ) ):
			$vars = array_merge( $vars, array(
				'meta_key' => 'tb_' . $vars['orderby'],
				'orderby' => 'meta_value'
			) );
		endif;
	endif;
	return $vars;
}
?>