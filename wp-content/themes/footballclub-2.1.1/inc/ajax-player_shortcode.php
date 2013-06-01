<?php
add_action( 'wp_ajax_tb_player_shortcode', 'tb_player_shortcode_ajax' );

function tb_player_shortcode_ajax() {
	$defaults = array(
		'id' => null
	);
	$args = array_merge( $defaults, $_GET );
	?>
		<div id="tb_player-form">
			<table id="tb_player-table" class="form-table">
				<tr>
					<?php $field = 'id'; ?>
					<th><label for="option-<?php echo $field; ?>"><?php printf( __( 'Select %s', 'themeboy' ), __( 'Player', 'themeboy' ) ); ?></label></th>
					<td>
						<?php
						tb_dropdown_posts( array(
							'post_type' => 'tb_player',
							'limit' => -1,
							'show_option_none' => __( 'None' ),
							'selected' => $args[$field],
							'name' => $field,
							'id' => 'option-' . $field
						) );
						?>
					</td>
				</tr>
			</table>
			<p class="submit">
				<input type="button" id="option-submit" class="button-primary" value="<?php printf( __( 'Insert %s', 'themeboy' ), __( 'Player Profile', 'themeboy' ) ); ?>" name="submit" />
			</p>
		</div>
	<?php
	exit();
}
?>