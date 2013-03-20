<?php get_header(); ?>

<div id="content">

	<div class="wrap">

		<div class="sep sepinside">&nbsp;</div>

		<div class="column column-narrow">&nbsp;</div><!-- end .column-narrow -->

		<div class="column column-double column-content column-last">

			<?php $post = $posts[0]; // Hack. Set $post so that the_date() works. ?>

			<h1><?php
				/* category archive */ if ( is_category() ) single_cat_title();
				/* tag archive */ elseif ( is_tag() ) printf( __('Archive for: <strong>%s</strong>', 'wpzoom'), single_tag_title('', false) );
				/* day/month/year archive */ elseif ( is_day() || is_month() || is_year() ) printf( __('Archive for: <strong>%s</strong>', 'wpzoom'), get_the_time( is_day() ? 'F jS, Y' : ( is_month() ? 'F, Y' : 'Y' ) ) );
				/* author archive */ elseif ( is_author() ) printf( __('Articles by: <strong>%s</strong>', 'wpzoom'), '<a class="url fn n" href="' . get_author_posts_url( get_the_author_meta( 'ID' ) ) . '" title="' . esc_attr( get_the_author() ) . '" rel="me">' . get_the_author() . '</a>' );
				/* paged archive */ elseif ( isset($_GET['paged']) && !empty($_GET['paged']) ) _e('Archives', 'wpzoom');
			?></h1>

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