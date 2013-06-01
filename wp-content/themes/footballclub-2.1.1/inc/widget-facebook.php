<?php
add_action('widgets_init', 'tb_facebook_widget_init' );
function tb_facebook_widget_init() {
	class TB_Facebook_Widget extends WP_Widget {
		public function __construct() {
			parent::__construct(
				'tb_facebook',
				__( 'Facebook', 'themeboy' ),
				array( 'description' => __( 'ThemeBoy widget', 'themeboy' ) )
			);
		}
		function widget( $args, $instance ) {
			extract( $args );
			$title = apply_filters('widget_title', $instance['title']);
			$page_url = $instance['page_url'];
			$show_faces = isset($instance['show_faces']) ? $instance['show_faces'] : false;
			$stream = isset($instance['stream']) ? $instance['stream'] : false;
			$colorscheme = isset($instance['colorscheme']) ? $instance['colorscheme'] : 'light';
			$border_color = 'dark' == $colorscheme ? '#000' : '#fff';
			echo '<li id="facebook" class="widget-container">
				<h3 class="widget-title">'.$title.'</h3>
				<div id="fb-root"></div><script src="http://connect.facebook.net/en_US/all.js#xfbml=1"></script><fb:like-box href="'.$page_url.'" width="318" colorscheme="'.$colorscheme.'" show_faces="'.($show_faces?'true':'false').'" border_color="'.$border_color.'" stream="'.($stream?'true':'false').'" header="false"></fb:like-box>
				</li>';
		}
		function update( $new_instance, $old_instance ) {
			$instance = $old_instance;
			$instance['title'] = strip_tags( $new_instance['title'] );
			$instance['page_url'] = strip_tags( $new_instance['page_url'] );
			$instance['show_faces'] = (bool)$new_instance['show_faces'];
			$instance['stream'] = (bool)$new_instance['stream'];
			$instance['colorscheme'] = $new_instance['colorscheme'];
			return $instance;
		}
		function form( $instance ) {
			$defaults = array( 'title' => __('Find us on Facebook', 'themeboy'), 'page_url' => get_option( 'tb_social_facebook' ), 'show_faces' => false, 'stream' => false, 'colorscheme' => 'light' );
			$instance = wp_parse_args( (array) $instance, $defaults ); ?> 
			<p>
				<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('Title:', 'themeboy') ?></label>
				<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" type="text" />
			</p>
			<p>
				<label for="<?php echo $this->get_field_id( 'page_url' ); ?>"><?php _e('Facebook Page URL:', 'themeboy') ?></label>
				<input class="widefat" id="<?php echo $this->get_field_id( 'page_url' ); ?>" name="<?php echo $this->get_field_name( 'page_url' ); ?>" value="<?php echo $instance['page_url']; ?>" type="text" />
			</p>
			<p>
				<input class="checkbox" type="checkbox" <?php checked( $instance['show_faces'], true ); ?> id="<?php echo $this->get_field_id( 'show_faces' ); ?>" name="<?php echo $this->get_field_name( 'show_faces' ); ?>" />
				<label for="<?php echo $this->get_field_id( 'show_faces' ); ?>"><?php _e('Show faces', 'themeboy') ?></label><br />
				<input class="checkbox" type="checkbox" <?php checked( $instance['stream'], true ); ?> id="<?php echo $this->get_field_id( 'stream' ); ?>" name="<?php echo $this->get_field_name( 'stream' ); ?>" />
				<label for="<?php echo $this->get_field_id( 'stream' ); ?>"><?php _e('Show stream', 'themeboy') ?></label>
			</p>
			<p>
				<label for="<?php echo $this->get_field_id( 'colorscheme' ); ?>"><?php _e('Color scheme:', 'themeboy') ?></label>
				<select id="<?php echo $this->get_field_id( 'colorscheme' ); ?>" name="<?php echo $this->get_field_name( 'colorscheme' ); ?>">
					<option value="light" <?php if ( 'light' == $instance['colorscheme'] ) echo 'selected="selected"'; ?>><?php _e('Light', 'themeboy') ?></option>
					<option value="light" <?php if ( 'dark' == $instance['colorscheme'] ) echo 'selected="selected"'; ?>><?php _e('Dark', 'themeboy') ?></option>
				</select>
			</p>
			<?php
		}
	}
	register_widget( 'tb_facebook_widget' );
};
?>