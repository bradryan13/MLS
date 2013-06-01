<?php
add_action( 'init', 'tb_comp_init', 0 );
// taxonomy init
function tb_comp_init() {
	register_taxonomy(
		'tb_comp',
		array( 'tb_club', 'tb_match' ),
		array(
			'hierarchical' => true,
			'labels' => array(
				'name' => __( 'Competitions', 'themeboy' ),
				'singular_name' => __( 'Competition', 'themeboy' ),
				'search_items' =>  sprintf( __( 'Search %s', 'themeboy' ), __( 'Competitions', 'themeboy' ) ),
				'all_items' => sprintf( __( 'All %s', 'themeboy' ), __( 'Competitions', 'themeboy' ) ),
				'parent_item' => sprintf( __( 'Parent %s', 'themeboy' ), __( 'Competition', 'themeboy' ) ),
				'parent_item_colon' => sprintf( __( 'Parent %s:', 'themeboy' ), __( 'Competition', 'themeboy' ) ),
				'edit_item' => sprintf( __( 'Edit %s', 'themeboy' ), __( 'Competition', 'themeboy' ) ),
				'update_item' => sprintf( __( 'Update %s', 'themeboy' ), __( 'Competition', 'themeboy' ) ),
				'add_new_item' => sprintf( __( 'Add New %s', 'themeboy' ), __( 'Competition', 'themeboy' ) ),
				'new_item_name' => __( 'Competition', 'themeboy' )
			),
			'sort' => true,
			'rewrite' => array( 'slug' => 'comp' )
		)
	);
}
?>