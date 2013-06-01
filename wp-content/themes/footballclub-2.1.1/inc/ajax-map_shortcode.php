<?php
add_action( 'wp_ajax_tb_map_shortcode', 'tb_map_shortcode_ajax' );

function tb_map_shortcode_ajax() {
	$defaults = array(
		'width' => 584,
		'height' => 320,
		'address' => null
	);
	$args = $defaults;
	?>
		<div id="tb_map-form">
			<table id="tb_map-table" class="form-table">
				<tr>
					<?php $field = 'address'; ?>
					<th><label for="option-<?php echo $field; ?>"><?php _e( 'Address', 'themeboy' ); ?></label></th>
					<td><input type="text" id="option-<?php echo $field; ?>" name="<?php echo $field; ?>" value="<?php echo $args[$field]; ?>" class="widefat" /></td>
				</tr>
				<tr>
					<?php $field = 'width'; ?>
					<th><label for="option-<?php echo $field; ?>"><?php _e( 'Width', 'themeboy' ); ?></label></th>
					<td><input type="text" id="option-<?php echo $field; ?>" name="<?php echo $field; ?>" value="<?php echo $args[$field]; ?>" size="3" /></td>
				</tr>
				<tr>
					<?php $field = 'height'; ?>
					<th><label for="option-<?php echo $field; ?>"><?php _e( 'Height', 'themeboy' ); ?></label></th>
					<td><input type="text" id="option-<?php echo $field; ?>" name="<?php echo $field; ?>" value="<?php echo $args[$field]; ?>" size="3" /></td>
				</tr>
			</table>
			<p class="submit">
				<input type="button" id="option-submit" class="button-primary" value="<?php printf( __( 'Insert %s', 'themeboy' ), __( 'Map', 'themeboy' ) ); ?>" name="submit" />
			</p>
		</div>
	<?php
	exit();
}
?>