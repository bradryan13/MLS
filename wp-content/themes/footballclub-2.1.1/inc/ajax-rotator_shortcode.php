<?php
add_action( 'wp_ajax_tb_rotator_shortcode', 'tb_rotator_shortcode_ajax' );

function tb_rotator_shortcode_ajax() {
	$defaults = array(
		'cat' => get_option( 'tb_rotator_cat' )
	);
	$args = array_merge( $defaults, $_GET );
	?>
		<div id="tb_rotator-form">
			<table id="tb_rotator-table" class="form-table">
				<tr>
					<?php $field = 'cat'; ?>
					<th><label for="option-<?php echo $field; ?>"><?php printf( __( 'Show posts from category', 'themeboy' ) ); ?></label></th>
					<td>
						<?php
						wp_dropdown_categories( array(
							'limit' => -1,
							'show_option_all' => __( 'All' ),
							'selected' => $args[$field],
							'name' => $field,
							'id' => 'option-' . $field
						) );
						?>
					</td>
				</tr>
			</table>
			<p class="submit">
				<input type="button" id="option-submit" class="button-primary" value="<?php printf( __( 'Insert %s', 'themeboy' ), __( 'Image Rotator', 'themeboy' ) ); ?>" name="submit" />
			</p>
		</div>
	<?php
	exit();
}
?>