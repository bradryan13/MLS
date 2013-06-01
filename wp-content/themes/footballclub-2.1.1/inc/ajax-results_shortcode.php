<?php
add_action( 'wp_ajax_tb_results_shortcode', 'tb_results_shortcode_ajax' );

function tb_results_shortcode_ajax() {
	$defaults = array(
		'limit' => 5,
		'comp' => null,
		'season' => null,
		'club' => get_option( 'tb_default_club' ),
		'venue' => null,
		'orderby' => 'post_date',
		'order' => 'DESC',
		'linktext' => __( 'View all results', 'themeboy' ),
		'linkpage' => null,
		'title' => __( 'Results', 'themeboy' )
	);
	$args = array_merge( $defaults, $_GET );
	?>
		<div id="tb_results-form">
			<table id="tb_results-table" class="form-table">
				<tr>
					<?php $field = 'title'; ?>
					<th><label for="option-<?php echo $field; ?>"><?php _e( 'Title', 'themeboy' ); ?></label></th>
					<td><input type="text" id="option-<?php echo $field; ?>" name="<?php echo $field; ?>" value="<?php echo $args[$field]; ?>" class="widefat" /></td>
				</tr>
				<tr>
					<?php $field = 'limit'; ?>
					<th><label for="option-<?php echo $field; ?>"><?php _e( 'Limit', 'themeboy' ); ?></label></th>
					<td><input type="text" id="option-<?php echo $field; ?>" name="<?php echo $field; ?>" value="<?php echo $args[$field]; ?>" size="3" /> (<?php _e( '0 = no limit', 'themeboy' ); ?>)</td>
				</tr>
				<tr>
					<?php $field = 'comp'; ?>
					<th><label for="option-<?php echo $field; ?>"><?php _e( 'Competition', 'themeboy' ); ?></label></th>
					<td>
						<?php
						wp_dropdown_categories(array(
							'show_option_none' => __( 'All' ),
							'hide_empty' => 0,
							'orderby' => 'title',
							'taxonomy' => 'tb_comp',
							'selected' => $args[$field],
							'name' => $field,
							'id' => 'option-' . $field
						));
						?>
					</td>
				</tr>
				<tr>
					<?php $field = 'season'; ?>
					<th><label for="option-<?php echo $field; ?>"><?php _e( 'Season', 'themeboy' ); ?></label></th>
					<td>
						<?php
						wp_dropdown_categories(array(
							'show_option_none' => __( 'All' ),
							'hide_empty' => 0,
							'orderby' => 'title',
							'taxonomy' => 'tb_season',
							'selected' => $args[$field],
							'name' => $field,
							'id' => 'option-' . $field
						));
						?>
					</td>
				</tr>
				<tr>
					<?php $field = 'club'; ?>
					<th><label for="option-<?php echo $field; ?>"><?php _e( 'Club', 'themeboy' ); ?></label></th>
					<td>
						<?php
						tb_dropdown_posts( array(
							'post_type' => 'tb_club',
							'limit' => -1,
							'show_option_none' => __( 'All' ),
							'selected' => $args[$field],
							'name' => $field,
							'id' => 'option-' . $field
						) );
						?>
					</td>
				</tr>
				<tr>
					<?php $field = 'venue'; ?>
					<th><label for="option-<?php echo $field; ?>"><?php _e( 'Venue', 'themeboy' ); ?></label></th>
					<td>
						<?php
						wp_dropdown_categories( array(
							'show_option_none' => __( 'All' ),
							'hide_empty' => 0,
							'orderby' => 'title',
							'taxonomy' => 'tb_venue',
							'selected' => $args[$field],
							'name' => $field,
							'id' => 'option-' . $field
						) );
						?>
					</td>
				</tr>
				<tr>
					<?php $field = 'orderby'; ?>
					<th><label for="option-<?php echo $field; ?>"><?php _e( 'Order by', 'themeboy' ); ?></label></th>
					<td><input type="text" id="option-<?php echo $field; ?>" name="<?php echo $field; ?>" value="<?php echo $args[$field]; ?>" /></td>
				</tr>
				<tr>
					<?php $field = 'order'; ?>
					<th><label for="option-<?php echo $field; ?>"><?php _e( 'Order', 'themeboy' ); ?></label></th>
					<td>
						<?php global $tb_order_options; ?>
						<select id="option-<?php echo $field; ?>" name="<?php echo $field; ?>">
							<?php foreach ( $tb_order_options as $key => $val ) { ?>
								<option id="<?php echo $key; ?>" value="<?php echo $key; ?>"<?php if ( $args[$field] == $key ) echo ' selected'; ?>><?php echo $val; ?></option>
							<?php } ?>
						</select>
					</td>
				</tr>
				<tr>
					<?php $field = 'linktext'; ?>
					<th><label for="option-<?php echo $field; ?>"><?php _e( 'Link text', 'themeboy' ); ?></label></th>
					<td><input type="text" id="option-<?php echo $field; ?>" name="<?php echo $field; ?>" value="<?php echo $args[$field]; ?>" /></td>
				</tr>
				<tr>
					<?php $field = 'linkpage'; ?>
					<th><label for="option-<?php echo $field; ?>"><?php _e( 'Link page', 'themeboy' ); ?></label></th>
					<td>
						<?php
						wp_dropdown_pages( array(
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
				<input type="button" id="option-submit" class="button-primary" value="<?php printf( __( 'Insert %s', 'themeboy' ), __( 'Results', 'themeboy' ) ); ?>" name="submit" />
			</p>
		</div>
	<?php
	exit();
}
?>