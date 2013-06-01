<?php
add_action('widgets_init', 'tb_fixtures_widget_init' );
function tb_fixtures_widget_init() {
	class TB_Fixtures_Widget extends WP_Widget {
		public function __construct() {
			parent::__construct(
				'tb_fixtures',
				__( 'Fixtures', 'themeboy' ),
				array( 'description' => __( 'ThemeBoy widget', 'themeboy' ) )
			);
		}
		function widget( $args, $instance ) {
			$options_string = '';
			foreach( $instance as $key => $value ) {
				$options_string .= ' ' . $key . '="' . $value . '"';
			}
			echo '<li class="widget-container widget_tb_fixtures">' .
			do_shortcode('[tb_fixtures' . $options_string . ' title="' . apply_filters('widget_title', $instance['title']) . '" type="sidebar"]') .
			'</li>';
		}
		function update( $new_instance, $old_instance ) {
			$instance = $old_instance;
			foreach( $new_instance as $key => $value ) {
				$instance[$key] = strip_tags( $value );
			}
			return $instance;
		}
		function form( $instance ) {
			$defaults = array(
				'limit' => 5,
				'comp' => null,
				'season' => null,
				'club' => get_option( 'tb_default_club' ),
				'venue' => null,
				'orderby' => 'post_date',
				'order' => 'ASC',
				'linktext' => __( 'View all fixtures', 'themeboy' ),
				'linkpage' => null,
				'title' => __( 'Fixtures', 'themeboy' )
			);
			$instance = wp_parse_args( (array) $instance, $defaults ); ?>
			<p>
				<?php $field = 'title'; ?>
				<label for="<?php echo $this->get_field_id( $field ); ?>"><?php _e('Title', 'themeboy') ?>:</label>
				<input class="widefat" id="<?php echo $this->get_field_id( $field ); ?>" name="<?php echo $this->get_field_name( $field ); ?>" value="<?php echo $instance[$field]; ?>" type="text" />
			</p>
			<p>
				<?php $field = 'limit'; ?>
				<label for="<?php echo $this->get_field_id( $field ); ?>"><?php _e('Limit', 'themeboy') ?>:</label>
				<input id="<?php echo $this->get_field_id( $field ); ?>" name="<?php echo $this->get_field_name( $field ); ?>" value="<?php echo $instance[$field]; ?>" type="text" size="3" />
			</p>
			<p>
				<?php $field = 'comp'; ?>
				<label for="<?php echo $this->get_field_id( $field ); ?>"><?php _e('Competition', 'themeboy') ?>:</label>
				<?php
				wp_dropdown_categories(array(
					'show_option_none' => __( 'All' ),
					'hide_empty' => 0,
					'orderby' => 'title',
					'taxonomy' => 'tb_comp',
					'selected' => $instance[$field],
					'name' => $this->get_field_name( $field ),
					'id' => $this->get_field_id( $field )
				));
				?>
			</p>
			<p>
				<?php $field = 'season'; ?>
				<label for="<?php echo $this->get_field_id( $field ); ?>"><?php _e('Season', 'themeboy') ?>:</label>
				<?php
				wp_dropdown_categories(array(
					'show_option_none' => __( 'All' ),
					'hide_empty' => 0,
					'orderby' => 'title',
					'taxonomy' => 'tb_season',
					'selected' => $instance[$field],
					'name' => $this->get_field_name( $field ),
					'id' => $this->get_field_id( $field )
				));
				?>
			</p>
			<p>
				<?php $field = 'club'; ?>
				<label for="<?php echo $this->get_field_id( $field ); ?>"><?php _e('Club', 'themeboy') ?>:</label>
				<?php
				tb_dropdown_posts( array(
					'post_type' => 'tb_club',
					'limit' => -1,
					'show_option_none' => __( 'All' ),
					'selected' => $instance[$field],
					'name' => $this->get_field_name( $field ),
					'id' => $this->get_field_id( $field )
				) );
				?>
			</p>
			<p>
				<?php $field = 'venue'; ?>
				<label for="<?php echo $this->get_field_id( $field ); ?>"><?php _e('Venue', 'themeboy') ?>:</label>
				<?php
				wp_dropdown_categories(array(
					'show_option_none' => __( 'All' ),
					'hide_empty' => 0,
					'orderby' => 'title',
					'taxonomy' => 'tb_venue',
					'selected' => $instance[$field],
					'name' => $this->get_field_name( $field ),
					'id' => $this->get_field_id( $field )
				));
				?>
			</p>
			<p>
				<?php $field = 'orderby'; ?>
				<label for="<?php echo $this->get_field_id( $field ); ?>"><?php _e('Order by', 'themeboy') ?>:</label>
				<input id="<?php echo $this->get_field_id( $field ); ?>" name="<?php echo $this->get_field_name( $field ); ?>" value="<?php echo $instance[$field]; ?>" type="text" />
			</p>
			<p>
				<?php $field = 'order'; ?>
				<label for="<?php echo $this->get_field_id( $field ); ?>"><?php _e('Order', 'themeboy') ?>:</label>
				<input id="<?php echo $this->get_field_id( $field ); ?>" name="<?php echo $this->get_field_name( $field ); ?>" value="<?php echo $instance[$field]; ?>" type="text" size="3" />
			</p>
			<p>
				<?php $field = 'linktext'; ?>
				<label for="<?php echo $this->get_field_id( $field ); ?>"><?php _e('Link text', 'themeboy') ?>:</label>
				<input class="widefat" id="<?php echo $this->get_field_id( $field ); ?>" name="<?php echo $this->get_field_name( $field ); ?>" value="<?php echo $instance[$field]; ?>" type="text" />
			</p>
			<p>
				<?php $field = 'linkpage'; ?>
				<label for="<?php echo $this->get_field_id( $field ); ?>"><?php _e('Link page', 'themeboy') ?>:</label>
				<?php
				wp_dropdown_pages( array(
					'show_option_none' => __( 'None' ),
					'selected' => $instance[$field],
					'name' => $this->get_field_name( $field ),
					'id' => $this->get_field_id( $field )
				) );
				?>
			</p>
			<?php
		}
	}
	register_widget( 'tb_fixtures_widget' );
}
?>