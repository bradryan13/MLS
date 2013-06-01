<?php

add_action('admin_menu', 'tb_register_themeboy_contact_page');

function tb_register_themeboy_contact_page() {
	add_submenu_page( 'themeboy', __( 'Contact Form', 'themeboy' ), __( 'Contact Form', 'themeboy' ), 'manage_options', 'themeboy-contact', 'tb_themeboy_contact_page' );
}

function tb_themeboy_contact_page() {
	if (!current_user_can('manage_options')) { wp_die( __('You do not have sufficient permissions to access this page.') ); }
	$hidden_field_name = 'tb_submit_hidden';
?>
<div class="wrap">
	<div id="icon-options-general" class="icon32"><br></div>
	<h2><?php _e('Contact Form Settings', 'themeboy'); ?></h2>
	<?php
		if( isset( $_POST[ $hidden_field_name ] ) && $_POST[ $hidden_field_name ] == 'Y' ) {
			global $tb_option_fields;
			foreach( $tb_option_fields['contact'] as $option_field => $value ) {
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
					<th scope="row"><label for="tb_contact_title"><?php _e( 'Title', 'themeboy' ); ?></label></th>
					<td>
						<input type="text" name="tb_contact_title" id="tb_contact_title" value="<?php echo get_option('tb_contact_title') ?>" class="regular-text" />
					</td>
				</tr>
				<tr valign="top">
					<th scope="row"><label for="tb_contact_email"><?php _e( 'Email Address', 'themeboy' ); ?></label></th>
					<td>
						<input type="text" name="tb_contact_email" id="tb_contact_email" value="<?php echo get_option('tb_contact_email') ?>" class="regular-text" />
					</td>
				</tr>
				<tr valign="top">
					<th scope="row"><label for="tb_contact_thanks_text"><?php _e( 'Success Message', 'themeboy' ); ?></label></th>
					<td>
						<input type="text" name="tb_contact_thanks_text" id="tb_contact_thanks_text" value="<?php echo get_option('tb_contact_thanks_text') ?>" class="regular-text" />
					</td>
				</tr>
				<tr valign="top">
					<th scope="row"><label for="tb_contact_error_text"><?php _e( 'Error Message', 'themeboy' ); ?></label></th>
					<td>
						<input type="text" name="tb_contact_error_text" id="tb_contact_error_text" value="<?php echo get_option('tb_contact_error_text') ?>" class="regular-text" /><br />
					</td>
				</tr>
				<tr valign="top">
					<th scope="row"><label for="tb_contact_thanks_subject"><?php _e( 'Email Subject', 'themeboy' ); ?></label></th>
					<td>
						<input type="text" name="tb_contact_thanks_subject" id="tb_contact_thanks_subject" value="<?php echo get_option('tb_contact_thanks_subject') ?>" class="regular-text" />
					</td>
				</tr>
				<tr valign="top">
					<th scope="row"><label for="tb_contact_thanks_email"><?php _e( 'Thank You Email', 'themeboy' ); ?></label></th>
					<td>
						<textarea name="tb_contact_thanks_email" rows="10" cols="50" id="tb_contact_thanks_email" class="large-text code"><?php echo get_option('tb_contact_thanks_email') ?></textarea>
					</td>
				</tr>
			</tbody>
		</table>
		<input type="hidden" name="<?php echo $hidden_field_name; ?>" value="Y">
		<?php submit_button( null, 'primary', 'save-themeboy-options' ); ?>
	</form>
</div>
<?php } ?>