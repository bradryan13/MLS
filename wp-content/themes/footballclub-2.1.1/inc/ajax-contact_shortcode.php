<?php
add_action( 'wp_ajax_tb_contact_shortcode', 'tb_contact_shortcode_ajax' );

function tb_contact_shortcode_ajax() {
	$defaults = array(
		'mailto' => get_option('tb_contact_email'),
		'title' => get_option('tb_contact_title')
	);
	$args = array_merge( $defaults, $_GET );
	?>
		<div id="tb_contact-form">
			<table id="tb_contact-table" class="form-table">
				<tr>
					<?php $field = 'title'; ?>
					<th><label for="option-<?php echo $field; ?>"><?php _e( 'Title', 'themeboy' ); ?></label></th>
					<td><input type="text" id="option-<?php echo $field; ?>" name="<?php echo $field; ?>" value="<?php echo $args[$field]; ?>" class="widefat" /></td>
				</tr>
				<tr>
					<?php $field = 'mailto'; ?>
					<th><label for="option-<?php echo $field; ?>"><?php _e( 'Email Address', 'themeboy' ); ?></label></th>
					<td><input type="text" id="option-<?php echo $field; ?>" name="<?php echo $field; ?>" value="<?php echo $args[$field]; ?>" class="widefat" /></td>
				</tr>
			</table>
			<p class="submit">
				<input type="button" id="option-submit" class="button-primary" value="<?php printf( __( 'Insert %s', 'themeboy' ), __( 'Contact Form', 'themeboy' ) ); ?>" name="submit" />
			</p>
		</div>
	<?php
	exit();
}
?>