<?php
add_action('widgets_init', 'tb_image_widget_init' );
function tb_image_widget_init() {
	class TB_Image_Widget extends WP_Widget {
		public function __construct() {
			parent::__construct(
				'tb_image',
				__( 'Image Advertisement', 'themeboy' ),
				array( 'description' => __( 'ThemeBoy widget', 'themeboy' ) )
			);
		}
		function widget( $args, $instance ) {
			extract( $args );
			$image_url = $instance['image_url'];
			$link_url = $instance['link_url'];
			if ($image_url && $link_url) {
				echo '<li id="image-ad" class="widget-container">
				<a href="'.$link_url.'" target="_blank"><img src="'.$image_url.'" /></a>
				</li>';
			}
		}
		function update( $new_instance, $old_instance ) {
			$instance = $old_instance;
			$instance['image_url'] = strip_tags( $new_instance['image_url'] );
			$instance['link_url'] = strip_tags( $new_instance['link_url'] );
			return $instance;
		}
		function form( $instance ) {
			$defaults = array( 'image_url' => '', 'link_url' => '' );
			$instance = wp_parse_args( (array) $instance, $defaults ); ?>
			<p>
				<label for="<?php echo $this->get_field_id( 'image_url' ); ?>"><?php _e('Image URL', 'themeboy') ?>:</label>
				<input class="widefat" id="<?php echo $this->get_field_id( 'image_url' ); ?>" name="<?php echo $this->get_field_name( 'image_url' ); ?>" value="<?php echo $instance['image_url']; ?>" type="text" />
			</p>
			<p>
				<label for="<?php echo $this->get_field_id( 'link_url' ); ?>"><?php _e('Link URL', 'themeboy') ?>:</label>
				<input class="widefat" id="<?php echo $this->get_field_id( 'link_url' ); ?>" name="<?php echo $this->get_field_name( 'link_url' ); ?>" value="<?php echo $instance['link_url']; ?>" type="text" />
			</p>
			<?php
		}
	}
	register_widget( 'tb_image_widget' );
};
?>