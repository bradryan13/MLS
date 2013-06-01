<?php
add_action('init', 'tb_team_init', 0);
function tb_team_init() {
	register_taxonomy(
		'tb_team',
		array( 'tb_player', 'tb_staff' ),
		array(
			'hierarchical' =>true,
			'labels' => array(
				'name' => __( 'Teams', 'themeboy' ),
				'singular_name' => __( 'Team', 'themeboy' ),
				'search_items' =>  sprintf( __( 'Search %s', 'themeboy' ), __( 'Teams', 'themeboy' ) ),
				'all_items' => sprintf( __( 'All %s', 'themeboy' ), __( 'Teams', 'themeboy' ) ),
				'parent_item' => sprintf( __( 'Parent %s', 'themeboy' ), __( 'Team', 'themeboy' ) ),
				'parent_item_colon' => sprintf( __( 'Parent %s:', 'themeboy' ), __( 'Team', 'themeboy' ) ),
				'edit_item' => sprintf( __( 'Edit %s', 'themeboy' ), __( 'Team', 'themeboy' ) ),
				'update_item' => sprintf( __( 'Update %s', 'themeboy' ), __( 'Team', 'themeboy' ) ),
				'add_new_item' => sprintf( __( 'Add New %s', 'themeboy' ), __( 'Team', 'themeboy' ) ),
				'new_item_name' => __( 'Team', 'themeboy' )
			),
			'sort' => true,
			'rewrite' => array( 'slug' => 'team' )
		)
	);
}
?>