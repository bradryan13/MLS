<?php
add_action( 'wp_ajax_tb_match_shortcode', 'tb_match_shortcode_ajax' );

function tb_match_shortcode_ajax() {
	$defaults = array(
		'id' => null
	);
	$args = array_merge( $defaults, $_GET );
	?>
		<div id="tb_match-form">
			<table id="tb_match-table" class="form-table">
				<tr>
					<?php $field = 'id'; ?>
					<th><label for="option-<?php echo $field; ?>"><?php printf( __( 'Select %s', 'themeboy' ), __( 'Match', 'themeboy' ) ); ?></label></th>
					<td>
						<?php
						tb_dropdown_posts( array(
							'post_type' => 'tb_match',
							'limit' => -1,
							'show_option_none' => __( 'None' ),
							'selected' => $args[$field],
							'orderby' => 'post_date',
							'order' => 'DESC',
							'name' => $field,
							'id' => 'option-' . $field
						) );
						?>
					</td>
				</tr>
			</table>
			<p class="submit">
				<input type="button" id="option-submit" class="button-primary" value="<?php printf( __( 'Insert %s', 'themeboy' ), __( 'Match', 'themeboy' ) ); ?>" name="submit" />
			</p>
		</div>
	<?php
	exit();
}
?>