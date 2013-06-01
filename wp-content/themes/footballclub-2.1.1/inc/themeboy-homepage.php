<?php

add_action('admin_menu', 'tb_register_themeboy_homepage_page');

function tb_register_themeboy_homepage_page() {
	add_submenu_page( 'themeboy', __( 'Homepage' ), __( 'Homepage' ), 'manage_options', 'themeboy-homepage', 'tb_themeboy_homepage_page' );
}

function tb_themeboy_homepage_page() {
	if (!current_user_can('manage_options')) { wp_die( __('You do not have sufficient permissions to access this page.') ); }
	$hidden_field_name = 'tb_submit_hidden';
?>
<div class="wrap">
	<div id="icon-options-general" class="icon32"><br></div>
	<h2><?php _e('Homepage Settings', 'themeboy'); ?></h2>
	<?php
		if( isset( $_POST[ $hidden_field_name ] ) && $_POST[ $hidden_field_name ] == 'Y' ) {
			global $tb_option_fields;
			foreach( $tb_option_fields['homepage'] as $option_field => $value ) {
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
					<th scope="row"><?php _e( 'Homepage Widgets', 'themeboy' ); ?></th>
					<td>
						<?php $option_slug = 'tb_rotator_cat'; ?>
						<input name="<?php echo $option_slug; ?>" type="checkbox" id="<?php echo $option_slug; ?>" value="1"<?php if( get_option( $option_slug ) ) echo ' checked' ?> />
						<label for="<?php echo $option_slug; ?>"><?php _e( 'Age', 'themeboy' ); ?></label><br />
						
						<?php $option_slug = 'tb_rotator_show_date'; ?>
						<input name="<?php echo $option_slug; ?>" type="checkbox" id="<?php echo $option_slug; ?>" value="1"<?php if( get_option( $option_slug ) ) echo ' checked' ?> />
						<label for="<?php echo $option_slug; ?>"><?php _e( 'Date', 'themeboy' ); ?></label><br />
						
						<?php $option_slug = 'tb_rotator_show_readmore'; ?>
						<input name="<?php echo $option_slug; ?>" type="checkbox" id="<?php echo $option_slug; ?>" value="1"<?php if( get_option( $option_slug ) ) echo ' checked' ?> />
						<label for="<?php echo $option_slug; ?>"><?php _e( 'Read More', 'themeboy' ); ?></label>
					</td>
				</tr>
				<tr valign="top">
					<?php $option_slug = 'tb_rotator_delay_in_seconds'; ?>
					<th scope="row"><label for="<?php echo $option_slug; ?>"><?php _e( 'Delay between slides', 'themeboy' ); ?></label></th>
					<td>
						<input type="number" name="<?php echo $option_slug; ?>" id="<?php echo $option_slug; ?>" value="<?php echo get_option('tb_rotator_delay_in_seconds') ?>" />
						<label for="<?php echo $option_slug; ?>"><?php _e( 'Seconds' ); ?></label>
					</td>
				</tr>
			</tbody>
		</table>
		<input type="hidden" name="<?php echo $hidden_field_name; ?>" value="Y">
		<?php submit_button( null, 'primary', 'save-themeboy-options' ); ?>
	</form>
</div>
<?php } ?>