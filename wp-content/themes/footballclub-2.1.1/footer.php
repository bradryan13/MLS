<?php if (get_option('tb_footer_show_sponsors')) { ?>
	<div id="sponsors"><?php echo do_shortcode('[tb_sponsors]'); ?></div>
<?php } ?>
	</div><!-- #main -->
	<!-- <div id="footer-widgets" role="contentinfo" class="clearfix">
		<div id="colophon">
			<?php	get_sidebar( 'footer' ); ?>
		</div><!-- #colophon -->
	</div><!-- #footer-widgets --> 
	
</div><!-- #wrapper -->
<footer class="clearfix">
<div class="copyright">
	<div class="left">&copy; <?php echo get_the_date('Y') ?> <?php bloginfo('name'); ?></div></div>
	<div class="right"></div>
</footer>
	
<?php
	wp_footer();
?>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/<?php echo get_locale(); ?>/all.js#xfbml=1";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>
<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
<script type="text/javascript">
(function($) {
	// fancybox all image links
	$('a').each(function() {
		var self = this;
		var file =  $(self).attr('href');
		if (file) {
			var extension = file.substr( (file.lastIndexOf('.') +1) );
			switch(extension) {
				case 'jpg':
				case 'png':
				case 'gif':
					$(self).fancybox({
						'overlayColor' : '#fff'
					});
			}
		}
	});
})(jQuery);
</script>
</body>
</html>