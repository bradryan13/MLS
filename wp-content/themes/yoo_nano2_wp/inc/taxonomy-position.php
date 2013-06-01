<?php
add_action('init', 'tb_position_init', 0);
function tb_position_init() {
	register_taxonomy(
		'tb_position',
		'tb_player',
		array(
			'hierarchical' => true,
			'labels' => array(
				'name' => __( 'Positions', 'themeboy' ),
				'singular_name' => __( 'Position', 'themeboy' ),
				'search_items' =>  __( 'Search' ),
				'all_items' => __( 'All' ),
				'parent_item' => __( 'Parent' ),
				'parent_item_colon' => __( 'Parent:' ),
				'edit_item' => __( 'Edit Position', 'themeboy' ),
				'update_item' => __( 'Update Position', 'themeboy' ),
				'add_new_item' => __( 'Add New Position', 'themeboy' ),
				'new_item_name' => __( 'New Position Name', 'themeboy' )
			),
			'sort' => true,
			'rewrite' => array( 'slug' => 'position' )
		)
	);
}
?>