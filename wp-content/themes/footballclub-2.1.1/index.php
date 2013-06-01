<?php get_header(); ?>
<?php
	echo do_shortcode('[tb_rotator type=featured]');
?>

<div id="feature-area">
<ul>
	<?php get_sidebar('home-left'); ?>
</ul>
</div>

<div id="container">
	<div id="content" role="main">
		<ul class="home-widgets content-right">
			<?php get_sidebar('home-right'); ?>
		</ul>
		<div class="clear"></div>
		<ul class="home-widgets">
			<?php get_sidebar('home-bottom'); ?>
		</ul>
	</div><!-- #content -->
</div><!-- #container -->

<?php get_sidebar('home'); ?>
<?php get_footer(); ?>