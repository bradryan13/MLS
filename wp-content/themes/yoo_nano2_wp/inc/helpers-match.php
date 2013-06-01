<?php
// player subs dropdown
function tb_player_subs_dropdown( $players = array(), $club = null, $side = 'home', $id = null, $disabled = false ) {
	$subs = get_posts( array (
		'post_type' => 'tb_player',
		'meta_query' => array(
			array(
				'key' => 'tb_club',
				'value' => $club,
			)
		),
		'meta_key' => 'tb_number',
		'orderby' => 'meta_value_num',
		'order' => 'ASC',
		'showposts' => -1
	) );
	$players = array_merge( array( 'home' => array( 'lineup' => array(), 'subs' => array() ), 'away' => array( 'lineup' => array(), 'subs' => array() ) ), $players );
?>
	<select name="tb_players[<?php echo $side; ?>][subs][<?php echo $id; ?>][sub]" data-player="<?php the_ID(); ?>" class="postform" <?php disabled( true, $disabled ); ?>>
		<option value="-1"><?php _e( 'None' ); ?></option>
		<?php foreach( $subs as $sub ) { ?>
			<option value="<?php echo $sub->ID; ?>"<?php echo ( $sub->ID == get_tb_stats_value( $players[$side]['subs'], $id, 'sub' ) ? ' selected' : '' ); ?>>
				<?php echo get_post_meta( $sub->ID, 'tb_number', true ); ?>. <?php echo $sub->post_title; ?>
			</option>
		<?php } ?>
	</select>
<?php
}

// player statistics table function
function tb_match_player_stats_table( $selected_players = array(), $club = null, $side = 'home', $type = 'lineup' ) {
	global $tb_player_stats_labels;
	$args = array(
		'post_type' => 'tb_player',
		'meta_query' => array(
			array(
				'key' => 'tb_club',
				'value' => $club,
			)
		),
		'meta_key' => 'tb_number',
		'orderby' => 'meta_value_num',
		'order' => 'ASC',
		'showposts' => -1
	);
	$players = get_posts( $args );
	if ( empty( $players ) ) {
		printf( __( 'No %s found', 'themeboy' ), __( 'players', 'themeboy' ) );
		return;
	}
	if ( ! is_array( $selected_players ) )
		$selected_players = array();
	$selected_players = array_merge( array( 'home' => array( 'lineup' => array(), 'subs' => array() ), 'away' => array( 'lineup' => array(), 'subs' => array() ) ), $selected_players );
?>
	<table>
		<thead>
			<tr>
				<th><?php _e( 'Player', 'themeboy' ); ?></th>
				<th><?php _e( 'Goals', 'themeboy' ); ?></th>
				<th><?php _e( 'Assists', 'themeboy' ); ?></th>
				<th><?php _e( 'Yellow Cards', 'themeboy' ); ?></th>
				<th><?php _e( 'Red Cards', 'themeboy' ); ?></th>
				<?php if ( $type == 'subs' ) { ?>
					<th><?php _e( 'Substitution', 'themeboy' ); ?></th>
				<?php } ?>
			</tr>
		</thead>
		<tbody>
			<?php foreach( $players as $player ) { ?>
				<?php
					$played = (
						is_array( $selected_players ) &&
						array_key_exists( $side, $selected_players ) &&
						is_array( $selected_players[$side] ) &&
						array_key_exists( $type, $selected_players[$side] ) &&
						is_array( $selected_players[$side][$type] ) &&
						array_key_exists( $player->ID, $selected_players[$side][$type] )
					);
				?>
				<tr data-player="<?php echo $player->ID; ?>">
					<td class="names">
						<label class="selectit">
							<input type="checkbox" data-player="<?php echo $player->ID; ?>" name="tb_players[<?php echo $side; ?>][<?php echo $type; ?>][<?php echo $player->ID; ?>][checked]" value="1" <?php checked( true, $played ); ?> />
							<?php echo get_post_meta( $player->ID, 'tb_number', true ); ?>. <?php echo $player->post_title; ?>
						</label>
					</td>
					<?php foreach( $tb_player_stats_labels as $key => $val ): ?>
						<td class="<?php echo $key; ?>">
							<input type="number" data-player="<?php echo $player->ID; ?>" name="tb_players[<?php echo $side; ?>][<?php echo $type; ?>][<?php echo $player->ID; ?>][<?php echo $key; ?>]" value="<?php tb_stats_value( $selected_players[$side][$type], $player->ID, $key ); ?>" min="0"<?php if ( !$played ) echo ' readonly'; ?>/>
						</td>
					<?php endforeach; ?>
					<?php if ( $type == 'subs' ) { ?>
						<td>
							<?php tb_player_subs_dropdown( $selected_players, $club, $side, $player->ID, !$played ); ?>
						</td>
					<?php } ?>
				</tr>
			<?php } ?>
		</tbody>
	</table>
<?php
}

function tb_match_player_row( $key, $value, $count = 0 ) {
	$number = get_post_meta( $key, 'tb_number', true );
	$output = '<tr class="' . ( $count % 2 ? 'even' : 'odd' ) . '">' .
		'<td class="name"><a href="' . get_permalink( $key ) . '">' . ( !empty( $number ) ? $number . '. ' : '' ) . get_the_title( $key ) . '</a></td>' .
		'<td class="notes">';
		for ( $i = 0; $i < $value['goals']; $i++ ) {
			$output .= '<span class="goal" title="' . __( 'Goal', 'themeboy' ) . '">' . __( 'Goal', 'themeboy' ) . '</span>';
		}
		for ( $i = 0; $i < $value['assists']; $i++ ) {
			$output .= '<span class="assist" title="' . __( 'Assist', 'themeboy' ) . '">' . __( 'Assist', 'themeboy' ) . '</span>';
		}
		for ( $i = 0; $i < $value['yellowcards']; $i++ ) {
			$output .= '<span class="yellowcard" title="' . __( 'Yellow Card', 'themeboy' ) . '">' . __( 'Yellow Card', 'themeboy' ) . '</span>';
		}
		for ( $i = 0; $i < $value['redcards']; $i++ ) {
			$output .= '<span class="redcard" title="' . __( 'Red Card', 'themeboy' ) . '">' . __( 'Red Card', 'themeboy' ) . '</span>';
		}
		if ( array_key_exists( 'sub', $value ) && $value['sub'] > 0 ) {
			$output .= '<span class="sub" title="' . __( 'Sub', 'themeboy' ) . '">' . __( 'Sub', 'themeboy' ) . '</span>' . get_post_meta( $value['sub'], 'tb_number', true );
		}
		$output .=
		'</td>' .
	'</tr>';
	return $output;
}
?>