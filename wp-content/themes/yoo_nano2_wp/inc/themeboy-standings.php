<?php

add_action('admin_menu', 'tb_register_themeboy_standings_page');

function tb_register_themeboy_standings_page() {
	add_submenu_page( 'themeboy', __( 'Standings', 'themeboy' ), __( 'Standings', 'themeboy' ), 'manage_options', 'themeboy-standings', 'tb_themeboy_standings_page' );
}

function tb_themeboy_standings_page() {
	if (!current_user_can('manage_options')) { wp_die( __('You do not have sufficient permissions to access this page.') ); }
	$hidden_field_name = 'tb_submit_hidden';
?>
<div class="wrap">
	<div id="icon-options-general" class="icon32"><br></div>
	<h2><?php _e('Standings Settings', 'themeboy'); ?></h2>
	<?php
		if( isset( $_POST[ $hidden_field_name ] ) && $_POST[ $hidden_field_name ] == 'Y' ) {
			global $tb_option_fields;
			foreach( $tb_option_fields['standings'] as $option_field => $value ) {
				$new_value = isset( $_POST[$option_field] ) ? $_POST[$option_field] : null;
				update_option( $option_field, stripslashes( $new_value ) );
			}
	?>
	<div id="message" class="updated"><p><strong><?php _e( 'Settings saved.' ); ?></strong></p></div>
	<?php
		}
	?>
	<form name="themeboy_form" method="post" action="">
		<h3><?php _e( 'Scoring System', 'themeboy' ); ?></h3>
		<table class="form-table">
			<tbody>
				<tr valign="top">
					<?php $option_slug = 'tb_standings_win_points'; ?>
					<th scope="row"><label for="<?php echo $option_slug; ?>"><?php _e( 'Win points', 'themeboy' ); ?></label></th>
					<td>
						<input type="number" name="<?php echo $option_slug; ?>" id="<?php echo $option_slug; ?>" value="<?php echo get_option( $option_slug ) ?>" class="small-text" />
					</td>
				</tr>
				<tr valign="top">
					<?php $option_slug = 'tb_standings_draw_points'; ?>
					<th scope="row"><label for="<?php echo $option_slug; ?>"><?php _e( 'Draw points', 'themeboy' ); ?></label></th>
					<td>
						<input type="number" name="<?php echo $option_slug; ?>" id="<?php echo $option_slug; ?>" value="<?php echo get_option( $option_slug ) ?>" class="small-text" />
					</td>
				</tr>
				<tr valign="top">
					<?php $option_slug = 'tb_standings_loss_points'; ?>
					<th scope="row"><label for="<?php echo $option_slug; ?>"><?php _e( 'Loss points', 'themeboy' ); ?></label></th>
					<td>
						<input type="number" name="<?php echo $option_slug; ?>" id="<?php echo $option_slug; ?>" value="<?php echo get_option( $option_slug ) ?>" class="small-text" />
					</td>
				</tr>
			</tbody>
		</table>
		<h3><?php _e( 'Labels', 'themeboy' ); ?></h3>
		<table class="form-table">
			<tbody>
				<tr valign="top">
					<?php $option_slug = 'tb_standings_pos_label'; ?>
					<th scope="row"><label for="<?php echo $option_slug; ?>"><?php _e( 'Pos', 'themeboy' ); ?></label></th>
					<td>
						<input type="text" name="<?php echo $option_slug; ?>" id="<?php echo $option_slug; ?>" value="<?php echo get_option( $option_slug ) ?>" class="small-text" />
					</td>
				</tr>
				<tr valign="top">
					<?php $option_slug = 'tb_standings_p_label'; ?>
					<th scope="row"><label for="<?php echo $option_slug; ?>"><?php _e( 'P', 'themeboy' ); ?></label></th>
					<td>
						<input type="text" name="<?php echo $option_slug; ?>" id="<?php echo $option_slug; ?>" value="<?php echo get_option( $option_slug ) ?>" class="small-text" />
					</td>
				</tr>
				<tr valign="top">
					<?php $option_slug = 'tb_standings_w_label'; ?>
					<th scope="row"><label for="<?php echo $option_slug; ?>"><?php _e( 'W', 'themeboy' ); ?></label></th>
					<td>
						<input type="text" name="<?php echo $option_slug; ?>" id="<?php echo $option_slug; ?>" value="<?php echo get_option( $option_slug ) ?>" class="small-text" />
					</td>
				</tr>
				<tr valign="top">
					<?php $option_slug = 'tb_standings_d_label'; ?>
					<th scope="row"><label for="<?php echo $option_slug; ?>"><?php _e( 'D', 'themeboy' ); ?></label></th>
					<td>
						<input type="text" name="<?php echo $option_slug; ?>" id="<?php echo $option_slug; ?>" value="<?php echo get_option( $option_slug ) ?>" class="small-text" />
					</td>
				</tr>
				<tr valign="top">
					<?php $option_slug = 'tb_standings_l_label'; ?>
					<th scope="row"><label for="<?php echo $option_slug; ?>"><?php _e( 'L', 'themeboy' ); ?></label></th>
					<td>
						<input type="text" name="<?php echo $option_slug; ?>" id="<?php echo $option_slug; ?>" value="<?php echo get_option( $option_slug ) ?>" class="small-text" />
					</td>
				</tr>
				<tr valign="top">
					<?php $option_slug = 'tb_standings_f_label'; ?>
					<th scope="row"><label for="<?php echo $option_slug; ?>"><?php _e( 'F', 'themeboy' ); ?></label></th>
					<td>
						<input type="text" name="<?php echo $option_slug; ?>" id="<?php echo $option_slug; ?>" value="<?php echo get_option( $option_slug ) ?>" class="small-text" />
					</td>
				</tr>
				<tr valign="top">
					<?php $option_slug = 'tb_standings_a_label'; ?>
					<th scope="row"><label for="<?php echo $option_slug; ?>"><?php _e( 'A', 'themeboy' ); ?></label></th>
					<td>
						<input type="text" name="<?php echo $option_slug; ?>" id="<?php echo $option_slug; ?>" value="<?php echo get_option( $option_slug ) ?>" class="small-text" />
					</td>
				</tr>
				<tr valign="top">
					<?php $option_slug = 'tb_standings_gd_label'; ?>
					<th scope="row"><label for="<?php echo $option_slug; ?>"><?php _e( 'GD', 'themeboy' ); ?></label></th>
					<td>
						<input type="text" name="<?php echo $option_slug; ?>" id="<?php echo $option_slug; ?>" value="<?php echo get_option( $option_slug ) ?>" class="small-text" />
					</td>
				</tr>
				<tr valign="top">
					<?php $option_slug = 'tb_standings_pts_label'; ?>
					<th scope="row"><label for="<?php echo $option_slug; ?>"><?php _e( 'PTS', 'themeboy' ); ?></label></th>
					<td>
						<input type="text" name="<?php echo $option_slug; ?>" id="<?php echo $option_slug; ?>" value="<?php echo get_option( $option_slug ) ?>" class="small-text" />
					</td>
				</tr>
			</tbody>
		</table>
		<input type="hidden" name="<?php echo $hidden_field_name; ?>" value="Y">
		<?php submit_button( null, 'primary', 'save-themeboy-options' ); ?>
	</form>
</div>
<?php } ?>