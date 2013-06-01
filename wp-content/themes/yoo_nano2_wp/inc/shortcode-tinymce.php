<?php
add_action( 'init', 'tb_addbuttons' );
function tb_addbuttons() {
	if ( ! current_user_can( 'edit_posts' ) && ! current_user_can( 'edit_pages' ) )
		return;

	if ( get_user_option('rich_editing') == 'true' ) {
		add_filter( 'mce_external_plugins', 'add_tb_mce_plugin' );
		add_filter( 'mce_buttons_3', 'register_tb_buttons' );
	}
}
function register_tb_buttons($buttons) {
	array_push( $buttons, 'tb_match', 'tb_fixtures', 'tb_results', 'tb_standings', '|', 'tb_player', 'tb_players', 'tb_staff', '|', 'tb_rotator', 'tb_contact', 'tb_map' );
	return $buttons;
}
function add_tb_mce_plugin($plugin_array) {
	$plugin_array['tb_match'] = get_template_directory_uri() . '/js/themeboy-editor/match.js';
	$plugin_array['tb_fixtures'] = get_template_directory_uri() . '/js/themeboy-editor/fixtures.js';
	$plugin_array['tb_results'] = get_template_directory_uri() . '/js/themeboy-editor/results.js';
	$plugin_array['tb_standings'] = get_template_directory_uri() . '/js/themeboy-editor/standings.js';
	$plugin_array['tb_player'] = get_template_directory_uri() . '/js/themeboy-editor/player.js';
	$plugin_array['tb_players'] = get_template_directory_uri() . '/js/themeboy-editor/players.js';
	$plugin_array['tb_staff'] = get_template_directory_uri() . '/js/themeboy-editor/staff.js';
	$plugin_array['tb_rotator'] = get_template_directory_uri() . '/js/themeboy-editor/rotator.js';
	$plugin_array['tb_contact'] = get_template_directory_uri() . '/js/themeboy-editor/contact.js';
	$plugin_array['tb_map'] = get_template_directory_uri() . '/js/themeboy-editor/map.js';
	return $plugin_array;
}
?>