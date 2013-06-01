<?php

get_header(); ?>

	<div id="container">
		<h1 class="entry-title"><?php _e( 'Not Found', 'themeboy' ); ?></h1>
		<div id="content" role="main">
			<article>
				<div id="post-0" class="post error404 not-found">
					<div class="entry-content">
						<p><?php _e( 'Apologies, but the page you requested could not be found. Perhaps searching will help.', 'themeboy' ); ?></p>
						<?php get_search_form(); ?>
					</div><!-- .entry-content -->
				</div><!-- #post-0 -->
			</article>
		</div><!-- #content -->
	</div><!-- #container -->
	<script type="text/javascript">
		// focus on search field after it has loaded
		document.getElementById('s') && document.getElementById('s').focus();
	</script>

<?php get_footer(); ?>