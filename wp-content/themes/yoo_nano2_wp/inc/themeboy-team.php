<?php

add_action('admin_menu', 'tb_register_themeboy_team_page');

function tb_register_themeboy_team_page() {
	add_submenu_page( 'themeboy', __( 'Players & Staff', 'themeboy' ), __( 'Players & Staff', 'themeboy' ), 'manage_options', 'themeboy-team', 'tb_themeboy_team_page' );
}

function tb_themeboy_team_page() {
	if (!current_user_can('manage_options')) { wp_die( __('You do not have sufficient permissions to access this page.') ); }
	$hidden_field_name = 'tb_submit_hidden';
?>
<div class="wrap">
	<div id="icon-options-general" class="icon32"><br></div>
	<h2><?php _e('Players & Staff Settings', 'themeboy'); ?></h2>
	<?php
		if( isset( $_POST[ $hidden_field_name ] ) && $_POST[ $hidden_field_name ] == 'Y' ) {
			global $tb_option_fields;
			foreach( $tb_option_fields['team'] as $option_field => $value ) {
				$new_value = isset( $_POST[$option_field] ) ? $_POST[$option_field] : null;
				update_option( $option_field, stripslashes( $new_value ) );
			}
	?>
	<div id="message" class="updated"><p><strong><?php _e( 'Settings saved.' ); ?></strong></p></div>
	<?php
		}
	?>
	<form name="themeboy_form" method="post" action="">
		<table class="form-table">
			<tbody>
				<tr valign="top">
					<th scope="row"><label for="tb_players_view"><?php _e( 'Display players as', 'themeboy'  ); ?></label></th>
					<td>
						<?php $option_slug = 'tb_players_view'; ?>
						<?php echo form_dropdown( $option_slug, array( 'list' => __( 'List' ), 'gallery' => __( 'Gallery' ) ), get_option( $option_slug) ); ?>
					</td>
				</tr>
				<tr valign="top">
					<th scope="row"><?php _e( 'Player Gallery', 'themeboy' ); ?></th>
					<td>						
						<?php $option_slug = 'tb_player_gallery_show_name'; ?>
						<input name="<?php echo $option_slug; ?>" type="checkbox" id="<?php echo $option_slug; ?>" value="1"<?php if( get_option( $option_slug ) ) echo ' checked' ?> />
						<label for="<?php echo $option_slug; ?>"><?php _e( 'Name', 'themeboy' ); ?></label><br />
						
						<?php $option_slug = 'tb_player_gallery_show_number'; ?>
						<input name="<?php echo $option_slug; ?>" type="checkbox" id="<?php echo $option_slug; ?>" value="1"<?php if( get_option( $option_slug ) ) echo ' checked' ?> />
						<label for="<?php echo $option_slug; ?>"><?php _e( 'Squad Number', 'themeboy' ); ?></label>
					</td>
				</tr>
				<tr valign="top">
					<th scope="row"><?php _e( 'Player Profile', 'themeboy' ); ?></th>
					<td>						
						<?php $option_slug = 'tb_player_profile_show_number'; ?>
						<input name="<?php echo $option_slug; ?>" type="checkbox" id="<?php echo $option_slug; ?>" value="1"<?php if( get_option( $option_slug ) ) echo ' checked' ?> />
						<label for="<?php echo $option_slug; ?>"><?php _e( 'Squad Number', 'themeboy' ); ?></label><br />
						
						<?php $option_slug = 'tb_player_profile_show_name'; ?>
						<input name="<?php echo $option_slug; ?>" type="checkbox" id="<?php echo $option_slug; ?>" value="1"<?php if( get_option( $option_slug ) ) echo ' checked' ?> />
						<label for="<?php echo $option_slug; ?>"><?php _e( 'Name', 'themeboy' ); ?></label><br />
						
						<?php $option_slug = 'tb_player_profile_show_dob'; ?>
						<input name="<?php echo $option_slug; ?>" type="checkbox" id="<?php echo $option_slug; ?>" value="1"<?php if( get_option( $option_slug ) ) echo ' checked' ?> />
						<label for="<?php echo $option_slug; ?>"><?php _e( 'Birthday', 'themeboy' ); ?></label><br />
						
						<?php $option_slug = 'tb_player_profile_show_age'; ?>
						<input name="<?php echo $option_slug; ?>" type="checkbox" id="<?php echo $option_slug; ?>" value="1"<?php if( get_option( $option_slug ) ) echo ' checked' ?> />
						<label for="<?php echo $option_slug; ?>"><?php _e( 'Age', 'themeboy' ); ?></label><br />
						
						<?php $option_slug = 'tb_player_profile_show_season'; ?>
						<input name="<?php echo $option_slug; ?>" type="checkbox" id="<?php echo $option_slug; ?>" value="1"<?php if( get_option( $option_slug ) ) echo ' checked' ?> />
						<label for="<?php echo $option_slug; ?>"><?php _e( 'Season', 'themeboy' ); ?></label><br />
						
						<?php $option_slug = 'tb_player_profile_show_team'; ?>
						<input name="<?php echo $option_slug; ?>" type="checkbox" id="<?php echo $option_slug; ?>" value="1"<?php if( get_option( $option_slug ) ) echo ' checked' ?> />
						<label for="<?php echo $option_slug; ?>"><?php _e( 'Team', 'themeboy' ); ?></label><br />
						
						<?php $option_slug = 'tb_player_profile_show_position'; ?>
						<input name="<?php echo $option_slug; ?>" type="checkbox" id="<?php echo $option_slug; ?>" value="1"<?php if( get_option( $option_slug ) ) echo ' checked' ?> />
						<label for="<?php echo $option_slug; ?>"><?php _e( 'Position', 'themeboy' ); ?></label><br />
						
						<?php $option_slug = 'tb_player_profile_show_appearances'; ?>
						<input name="<?php echo $option_slug; ?>" type="checkbox" id="<?php echo $option_slug; ?>" value="1"<?php if( get_option( $option_slug ) ) echo ' checked' ?> />
						<label for="<?php echo $option_slug; ?>"><?php _e( 'Appearances', 'themeboy' ); ?></label><br />
						
						<?php $option_slug = 'tb_player_profile_show_goals'; ?>
						<input name="<?php echo $option_slug; ?>" type="checkbox" id="<?php echo $option_slug; ?>" value="1"<?php if( get_option( $option_slug ) ) echo ' checked' ?> />
						<label for="<?php echo $option_slug; ?>"><?php _e( 'Goals', 'themeboy' ); ?></label><br />
						
						<?php $option_slug = 'tb_player_profile_show_assists'; ?>
						<input name="<?php echo $option_slug; ?>" type="checkbox" id="<?php echo $option_slug; ?>" value="1"<?php if( get_option( $option_slug ) ) echo ' checked' ?> />
						<label for="<?php echo $option_slug; ?>"><?php _e( 'Assists', 'themeboy' ); ?></label><br />
						
						<?php $option_slug = 'tb_player_profile_show_joined'; ?>
						<input name="<?php echo $option_slug; ?>" type="checkbox" id="<?php echo $option_slug; ?>" value="1"<?php if( get_option( $option_slug ) ) echo ' checked' ?> />
						<label for="<?php echo $option_slug; ?>"><?php _e( 'Joined', 'themeboy' ); ?></label><br />
						
						<?php $option_slug = 'tb_player_profile_show_hometown'; ?>
						<input name="<?php echo $option_slug; ?>" type="checkbox" id="<?php echo $option_slug; ?>" value="1"<?php if( get_option( $option_slug ) ) echo ' checked' ?> />
						<label for="<?php echo $option_slug; ?>"><?php _e( 'Hometown', 'themeboy' ); ?></label>
					</td>
				</tr>
				<tr valign="top">
					<th scope="row"><?php _e( 'Staff Profile', 'themeboy' ); ?></th>
					<td>						
						<?php $option_slug = 'tb_staff_profile_show_dob'; ?>
						<input name="<?php echo $option_slug; ?>" type="checkbox" id="<?php echo $option_slug; ?>" value="1"<?php if( get_option( $option_slug ) ) echo ' checked' ?> />
						<label for="<?php echo $option_slug; ?>"><?php _e( 'Birthday', 'themeboy' ); ?></label><br />
						
						<?php $option_slug = 'tb_staff_profile_show_age'; ?>
						<input name="<?php echo $option_slug; ?>" type="checkbox" id="<?php echo $option_slug; ?>" value="1"<?php if( get_option( $option_slug ) ) echo ' checked' ?> />
						<label for="<?php echo $option_slug; ?>"><?php _e( 'Age', 'themeboy' ); ?></label><br />
						
						<?php $option_slug = 'tb_staff_profile_show_natl'; ?>
						<input name="<?php echo $option_slug; ?>" type="checkbox" id="<?php echo $option_slug; ?>" value="1"<?php if( get_option( $option_slug ) ) echo ' checked' ?> />
						<label for="<?php echo $option_slug; ?>"><?php _e( 'Nationality', 'themeboy' ); ?></label><br />
						
						<?php $option_slug = 'tb_staff_profile_show_seasons'; ?>
						<input name="<?php echo $option_slug; ?>" type="checkbox" id="<?php echo $option_slug; ?>" value="1"<?php if( get_option( $option_slug ) ) echo ' checked' ?> />
						<label for="<?php echo $option_slug; ?>"><?php _e( 'Season', 'themeboy' ); ?></label><br />
						
						<?php $option_slug = 'tb_staff_profile_show_teams'; ?>
						<input name="<?php echo $option_slug; ?>" type="checkbox" id="<?php echo $option_slug; ?>" value="1"<?php if( get_option( $option_slug ) ) echo ' checked' ?> />
						<label for="<?php echo $option_slug; ?>"><?php _e( 'Team', 'themeboy' ); ?></label>
					</td>
				</tr>
			</tbody>
		</table>
		<input type="hidden" name="<?php echo $hidden_field_name; ?>" value="Y">
		<?php submit_button( null, 'primary', 'save-themeboy-options' ); ?>
	</form>
</div>
<?php } ?>