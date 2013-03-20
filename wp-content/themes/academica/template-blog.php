<?php 
/*
Template Name: Blog Archives
*/
get_header(); ?>

<div id="content">

	<div class="wrap">

		<div class="sep sepinside">&nbsp;</div>

		<div class="column column-narrow">&nbsp;</div><!-- end .column-narrow -->

		<div class="column column-double column-content column-last">

			<h1><?php the_title(); ?></h1>

		</div><!-- end .column-double -->

		<div class="clear">&nbsp;</div>

		<div class="column column-narrow">

			<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('Sidebar: Archive Pages') ) echo '&nbsp;'; ?>

		</div><!-- end .column-narrow -->

		<div class="column column-double column-last">

			<?php 		
			// WP 3.0 PAGED BUG FIX
			$paged = get_query_var('paged') ? get_query_var('paged') : ( get_query_var('page') ? get_query_var('page') : 1 );
			query_posts("paged=$paged");

			get_template_part('loop'); ?>

		</div><!-- end .column-content -->

		<div class="clear">&nbsp;</div>

	</div><!-- end .wrap -->

</div><!-- end #content -->

<?php get_footer(); ?>