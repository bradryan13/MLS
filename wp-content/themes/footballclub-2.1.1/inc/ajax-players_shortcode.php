<?php
add_action( 'wp_ajax_tb_players_shortcode', 'tb_players_shortcode_ajax' );

function tb_players_shortcode_ajax() {
	$defaults = array(
		'limit' => 0,
		'season' => null,
		'club' => get_option( 'tb_default_club' ),
		'team' => null,
		'position' => null,
		'orderby' => 'number',
		'order' => 'ASC',
		'linktext' => __( 'View all players', 'themeboy' ),
		'linkpage' => null,
		'stats' => 'flag,number,name,position,age',
		'title' => __( 'Players', 'themeboy' ),
		'type' => get_option( 'tb_players_view' )
	);
	$args = array_merge( $defaults, $_GET );
	
	global $tb_player_stats_labels;
	$player_stats_labels = array_merge( array( 'appearances' => __( 'Appearances', 'themeboy' ) ), $tb_player_stats_labels );
	$stats_labels = array_merge(
		array(
			'flag' => __( 'Flag', 'themeboy' ),
			'number' => __( 'Number', 'themeboy' ),
			'name' => __( 'Name', 'themeboy' ),
			'position' => __( 'Position', 'themeboy' ),
			'age' => __( 'Age', 'themeboy' ),
			'team' => __( 'Team', 'themeboy' ),
			'season' => __( 'Season', 'themeboy' ),
			'dob' => __( 'Date of Birth', 'themeboy' ),
			'hometown' => __( 'Hometown', 'themeboy' ),
			'joined' => __( 'Joined', 'themeboy' )
		),
		$player_stats_labels
	);
	$stats = explode( ',', $args['stats'] );
	?>
		<div id="tb_players-form">
			<table id="tb_players-table" class="form-table">
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
					<?php $field = 'team'; ?>
					<th><label for="option-<?php echo $field; ?>"><?php _e( 'Team', 'themeboy' ); ?></label></th>
					<td>
						<?php
						wp_dropdown_categories( array(
							'show_option_none' => __( 'All' ),
							'hide_empty' => 0,
							'orderby' => 'title',
							'taxonomy' => 'tb_team',
							'selected' => $args[$field],
							'name' => $field,
							'id' => 'option-' . $field
						) );
						?>
					</td>
				</tr>
				<tr>
					<?php $field = 'position'; ?>
					<th><label for="option-<?php echo $field; ?>"><?php _e( 'Position', 'themeboy' ); ?></label></th>
					<td>
						<?php
						wp_dropdown_categories( array(
							'show_option_none' => __( 'All' ),
							'hide_empty' => 0,
							'orderby' => 'title',
							'taxonomy' => 'tb_position',
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
						<select id="option-<?php echo $field; ?>" name="<?php echo $field; ?>">
							<option id="number" value="number"<?php if ( $args[$field] == 'number' ) echo ' selected'; ?>><?php _e( 'Number', 'themeboy' ); ?></option>
							<?php foreach ( $player_stats_labels as $key => $val ) { ?>
								<option id="<?php echo $key; ?>" value="<?php echo $key; ?>"<?php if ( $args[$field] == $key ) echo ' selected'; ?>><?php echo $val; ?></option>
							<?php } ?>
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
					<?php $field = 'type'; ?>
					<th><label for="option-<?php echo $field; ?>"><?php _e( 'Type', 'themeboy' ); ?></label></th>
					<td>
						<?php global $tb_players_view_types; ?>
						<select id="option-<?php echo $field; ?>" name="<?php echo $field; ?>">
							<?php foreach ( $tb_players_view_types as $key => $val ) { ?>
								<option id="<?php echo $key; ?>" value="<?php echo $key; ?>"<?php if ( $args[$field] == $key ) echo ' selected'; ?>><?php echo $val; ?></option>
							<?php } ?>
						</select>
					</td>
				</tr>
				<tr>
					<?php $field = 'stats'; ?>
					<th><label><?php _e( 'Statistics', 'themeboy' ); ?></label></th>
					<td>
						<table>
							<tr>
								<?php
								foreach ( $stats_labels as $key => $value ) {
									$count++;
									if ( $count > 3 ) {
										$count = 1;
										echo '</tr><tr>';
									}
								?>
									<td>
										<label class="selectit" for="option-<?php echo $field; ?>-<?php echo $key; ?>">
											<input type="checkbox" id="option-<?php echo $field; ?>-<?php echo $key; ?>" name="<?php echo $field; ?>[]" value="<?php echo $key; ?>" <?php checked( in_array( $key, $stats ) ); ?> />
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
				<input type="button" id="option-submit" class="button-primary" value="<?php printf( __( 'Insert %s', 'themeboy' ), __( 'Players', 'themeboy' ) ); ?>" name="submit" />
			</p>
		</div>
	<?php
	exit();
}
?>