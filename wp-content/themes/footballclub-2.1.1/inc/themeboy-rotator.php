<?php

add_action('admin_menu', 'tb_register_themeboy_rotator_page');

function tb_register_themeboy_rotator_page() {
	add_submenu_page( 'themeboy', __( 'Image Rotator', 'themeboy' ), __( 'Image Rotator', 'themeboy' ), 'manage_options', 'themeboy-rotator', 'tb_themeboy_rotator_page' );
}

function tb_themeboy_rotator_page() {
	if (!current_user_can('manage_options')) { wp_die( __('You do not have sufficient permissions to access this page.') ); }
	$hidden_field_name = 'tb_submit_hidden';
?>
<div class="wrap">
	<div id="icon-options-general" class="icon32"><br></div>
	<h2><?php _e('Image Rotator Settings', 'themeboy'); ?></h2>
	<?php
		if( isset( $_POST[ $hidden_field_name ] ) && $_POST[ $hidden_field_name ] == 'Y' ) {
			global $tb_option_fields;
			foreach( $tb_option_fields['rotator'] as $option_field => $value ) {
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
					<th scope="row"><?php _e( 'Show posts from category', 'themeboy' ); ?></th>
					<td>
						<?php $option_slug = 'tb_rotator_cat'; ?>
						<?php
						wp_dropdown_categories( array(
							'limit' => -1,
							'show_option_all' => __( 'All' ),
							'selected' => get_option( $option_slug ),
							'name' => $option_slug,
							'id' => $option_slug
						) );
						?>
					</td>
				</tr>
				<tr valign="top">
					<th scope="row"><?php _e( 'Show in image rotator', 'themeboy' ); ?></th>
					<td>						
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
						<input type="number" name="<?php echo $option_slug; ?>" id="<?php echo $option_slug; ?>" value="<?php echo get_option('tb_rotator_delay_in_seconds') ?>" class="small-text" />
						<label for="<?php echo $option_slug; ?>"><?php _e( 'Seconds', 'themeboy' ); ?></label>
					</td>
				</tr>
			</tbody>
		</table>
		<input type="hidden" name="<?php echo $hidden_field_name; ?>" value="Y">
		<?php submit_button( null, 'primary', 'save-themeboy-options' ); ?>
	</form>
</div>
<?php } ?>