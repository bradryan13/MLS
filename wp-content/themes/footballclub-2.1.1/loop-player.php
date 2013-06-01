<h1 class="entry-title"><?php _e('Player Profile', 'themeboy'); ?></h1>
<div id="content" role="main">
	<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>
    <div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
      <div class="profile-box">
			<h2 class="entry-title"><?php the_title(); ?></h2>
			<?php 
			$args = array(
				'post_type' => 'tb_player',
				'numberposts' => -1,
				'orderby' => 'meta_value_num',
				'meta_key' => 'tb_number',
				'order' => 'ASC'
			);
			$player_posts = get_posts($args);
			$players = array();
			foreach($player_posts as $player_post):
								$custom = get_post_custom($player_post->ID);
				$players[get_permalink($player_post->ID)] = ($custom['tb_number'][0] == null ? '' : $custom['tb_number'][0].'. ').get_the_title($player_post->ID);
			endforeach;
							$custom = get_post_custom();
			if($custom['tb_number'][0] == null) {
				$number = '-';
				$name = get_the_title($post->ID);
			} else {
				$number = $custom['tb_number'][0];
				$name = $number.'. '.get_the_title($post->ID);
			}
			?>
			<?php echo form_dropdown('switch-player-profile', $players, get_permalink(), array('onchange' => 'window.location = this.value;')); ?>
			<?php echo do_shortcode('[tb_player id="' . get_the_ID() . '"]'); ?>
			<div id="nav-below" class="navigation">
				<?php if (get_option('tb_team_view_all_link')): ?>
					<div class="nav-previous">
						<a href="<?php echo get_page_link(get_option('tb_team_page')) ?>" rel="prev"><span class="meta-nav">&#x25C2;</span> <?php echo get_option('tb_team_view_all_text'); ?></a>
					</div>
				<?php endif; ?>
			</div>
        </div>
        
    </div><!-- #post-## -->

<?php endwhile; // end of the loop. ?>
</div><!-- #content -->