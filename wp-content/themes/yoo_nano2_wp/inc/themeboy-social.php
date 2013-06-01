<?php

add_action('admin_menu', 'tb_register_themeboy_social_page');

function tb_register_themeboy_social_page() {
	add_submenu_page( 'themeboy', __( 'Social Network', 'themeboy' ), __( 'Social Network', 'themeboy' ), 'manage_options', 'themeboy-social', 'tb_themeboy_social_page' );
}

function tb_themeboy_social_page() {
	if (!current_user_can('manage_options')) { wp_die( __('You do not have sufficient permissions to access this page.') ); }
	$hidden_field_name = 'tb_submit_hidden';
?>
<div class="wrap">
	<div id="icon-options-general" class="icon32"><br></div>
	<h2><?php _e('Social Network Settings', 'themeboy'); ?></h2>
	<?php
		if( isset( $_POST[ $hidden_field_name ] ) && $_POST[ $hidden_field_name ] == 'Y' ) {
			global $tb_option_fields;
			foreach( $tb_option_fields['social'] as $option_field => $value ) {
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
					<?php $option_slug = 'tb_social_facebook'; ?>
					<th scope="row"><label for="<?php echo $option_slug; ?>"><?php _e( 'Facebook', 'themeboy' ); ?></label></th>
					<td>
						<input type="text" name="<?php echo $option_slug; ?>" id="<?php echo $option_slug; ?>" value="<?php echo get_option( $option_slug ) ?>" class="regular-text" placeholder="URL" /><br />
						<?php $option_slug = 'tb_social_show_facebook_like_button'; ?>
						<input name="<?php echo $option_slug; ?>" type="checkbox" id="<?php echo $option_slug; ?>" value="1"<?php if( get_option( $option_slug ) ) echo ' checked' ?> />
						<label for="<?php echo $option_slug; ?>"><?php _e( 'Show "Like" button on pages and posts', 'themeboy' ); ?></label>
					</td>
				</tr>
				<tr valign="top">
					<?php $option_slug = 'tb_social_twitter'; ?>
					<th scope="row"><label for="<?php echo $option_slug; ?>"><?php _e( 'Twitter', 'themeboy' ); ?></label></th>
					<td>
						<input type="text" name="<?php echo $option_slug; ?>" id="<?php echo $option_slug; ?>" value="<?php echo get_option( $option_slug ) ?>" class="regular-text" placeholder="URL" /><br />
						<?php $option_slug = 'tb_social_show_twitter_tweet_button'; ?>
						<label for="<?php echo $option_slug; ?>" class="selectit">
							<input name="<?php echo $option_slug; ?>" type="checkbox" id="<?php echo $option_slug; ?>" value="1"<?php if( get_option( $option_slug ) ) echo ' checked' ?> />
							<?php _e( 'Show "Tweet" button on pages and posts', 'themeboy' ); ?>
						</label><br />
						<?php $option_slug = 'tb_social_twitter_via'; ?>
						<label for="<?php echo $option_slug; ?>" class="selectit">
							<?php _e( 'Username', 'themeboy' ); ?>:
							<input type="text" name="<?php echo $option_slug; ?>" id="<?php echo $option_slug; ?>" value="<?php echo get_option( $option_slug ) ?>" class="text" placeholder="<?php _e( 'Username', 'themeboy' ); ?>" />
						</label><br />
						<?php $option_slug = 'tb_social_twitter_hashtags'; ?>
						<label for="<?php echo $option_slug; ?>" class="selectit">
							<?php _e( 'Hashtags', 'themeboy' ); ?>:
							<input type="text" name="<?php echo $option_slug; ?>" id="<?php echo $option_slug; ?>" value="<?php echo get_option( $option_slug ) ?>" class="text" placeholder="<?php _e( 'Hashtags', 'themeboy' ); ?>" />
						</label>
					</td>
				</tr>
				<tr valign="top">
					<?php $option_slug = 'tb_social_pinterest'; ?>
					<th scope="row"><label for="<?php echo $option_slug; ?>"><?php _e( 'Pinterest', 'themeboy' ); ?></label></th>
					<td>
						<input type="text" name="<?php echo $option_slug; ?>" id="<?php echo $option_slug; ?>" value="<?php echo get_option( $option_slug ) ?>" class="regular-text" placeholder="URL" />
					</td>
				</tr>
				<tr valign="top">
					<?php $option_slug = 'tb_social_linkedin'; ?>
					<th scope="row"><label for="<?php echo $option_slug; ?>"><?php _e( 'LinkedIn', 'themeboy' ); ?></label></th>
					<td>
						<input type="text" name="<?php echo $option_slug; ?>" id="<?php echo $option_slug; ?>" value="<?php echo get_option( $option_slug ) ?>" class="regular-text" placeholder="URL" />
					</td>
				</tr>
				<tr valign="top">
					<?php $option_slug = 'tb_social_gplus'; ?>
					<th scope="row"><label for="<?php echo $option_slug; ?>"><?php _e( 'Google+', 'themeboy' ); ?></label></th>
					<td>
						<input type="text" name="<?php echo $option_slug; ?>" id="<?php echo $option_slug; ?>" value="<?php echo get_option( $option_slug ) ?>" class="regular-text" placeholder="URL" />
					</td>
				</tr>
				<tr valign="top">
					<?php $option_slug = 'tb_social_youtube'; ?>
					<th scope="row"><label for="<?php echo $option_slug; ?>"><?php _e( 'YouTube', 'themeboy' ); ?></label></th>
					<td>
						<input type="text" name="<?php echo $option_slug; ?>" id="<?php echo $option_slug; ?>" value="<?php echo get_option( $option_slug ) ?>" class="regular-text" placeholder="URL" />
					</td>
				</tr>
				<tr valign="top">
					<?php $option_slug = 'tb_social_vimeo'; ?>
					<th scope="row"><label for="<?php echo $option_slug; ?>"><?php _e( 'Vimeo', 'themeboy' ); ?></label></th>
					<td>
						<input type="text" name="<?php echo $option_slug; ?>" id="<?php echo $option_slug; ?>" value="<?php echo get_option( $option_slug ) ?>" class="regular-text" placeholder="URL" />
					</td>
				</tr>
			</tbody>
		</table>
		<input type="hidden" name="<?php echo $hidden_field_name; ?>" value="Y">
		<?php submit_button( null, 'primary', 'save-themeboy-options' ); ?>
	</form>
</div>
<?php } ?>