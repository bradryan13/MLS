<?php
add_action( 'wp_ajax_tb_standings_shortcode', 'tb_standings_shortcode_ajax' );

function tb_standings_shortcode_ajax() {
	$defaults = array(
		'limit' => 7,
		'comp' => null,
		'season' => null,
		'club' => get_option( 'tb_default_club' ),
		'orderby' => 'pts',
		'order' => 'DESC',
		'linktext' => __( 'View all standings', 'themeboy' ),
		'linkpage' => null,
		'stats' => 'p,w,d,l,f,a,gd,pts',
		'title' => __( 'Standings', 'themeboy' )
	);
	$args = array_merge( $defaults, $_GET );
	?>
		<div id="tb_standings-form">
			<table id="tb_standings-table" class="form-table">
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
							'show_option_none' => __( 'None' ),
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
					<td>
						<?php
							global $tb_standings_stats_labels;
						?>
						<select id="option-<?php echo $field; ?>" name="<?php echo $field; ?>">
							<?php foreach ( $tb_standings_stats_labels as $key => $val ) { ?>
								<option id="<?php echo $key; ?>" value="<?php echo $key; ?>"<?php if ( $args[$field] == $key ) echo ' selected'; ?>><?php echo $val; ?></option>
							<?php } ?>
							<option id="rand" value="rand"<?php if ( $args[$field] == 'rand' ) echo ' selected'; ?>><?php _e( 'Random', 'themeboy' ); ?></option>
						</select>
					</td>
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
				<tr>
					<?php $field = 'stats'; ?>
					<th><label><?php _e( 'Statistics', 'themeboy' ); ?></label></th>
					<td>
						<table style="text-align: center;">
							<tr>
								<?php
								global $tb_standings_stats_labels;
								foreach ( $tb_standings_stats_labels as $key => $value ) {
								?>
									<td>
										<label class="selectit" for="option-<?php echo $field; ?>-<?php echo $key; ?>">
											<input type="checkbox" id="option-<?php echo $field; ?>-<?php echo $key; ?>" name="<?php echo $field; ?>[]" value="<?php echo $key; ?>" checked />
											<?php echo $value; ?>
										</label>
									</td>
								<?php } ?>
							</tr
						></table>
					</td>
				</tr>
			</table>
			<p class="submit">
				<input type="button" id="option-submit" class="button-primary" value="<?php printf( __( 'Insert %s', 'themeboy' ), __( 'Standings', 'themeboy' ) ); ?>" name="submit" />
			</p>
		</div>
	<?php
	exit();
}
?>