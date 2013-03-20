<?php get_header(); ?>

<div id="content">

	<div class="wrap">

		<div class="sep sepinside">&nbsp;</div>

		<div class="column column-narrow">&nbsp;</div><!-- end .column-narrow -->

		<div class="column column-double column-content column-last">

			<?php $post = $posts[0]; // Hack. Set $post so that the_date() works. ?>
			<h1><?php _e('Search Results for', 'wpzoom'); ?>: <?php the_search_query(); ?></h1>

		</div><!-- end .column-double -->

		<div class="clear">&nbsp;</div>

		<div class="column column-narrow">

			<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('Sidebar: Archive Pages') ) echo '&nbsp;'; ?>

		</div><!-- end .column-narrow -->

		<div class="column column-double column-last">

			<?php get_template_part('loop'); ?>

		</div><!-- end .column-content -->

		<div class="clear">&nbsp;</div>

	</div><!-- end .wrap -->

</div><!-- end #content -->

<?php get_footer(); ?>