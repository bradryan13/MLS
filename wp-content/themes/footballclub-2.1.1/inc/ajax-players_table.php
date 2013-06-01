<?php
add_action( 'wp_ajax_tb_players_table', 'tb_players_table_ajax' );
function tb_players_table_ajax() {
	if ( !wp_verify_nonce( $_REQUEST['nonce'], 'tb_players_nonce')) {
		exit();
	}
	global $tb_player_stats_labels;
	$defaults = array(
		'club' => null,
		'side' => 'home',
		'type' => 'lineup'
	);
	$args = array_merge( $defaults, $_REQUEST );
	echo tb_match_player_stats_table( null, $args['club'], $args['side'], $args['type'] );
	exit();
}
?>