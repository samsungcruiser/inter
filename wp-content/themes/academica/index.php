<?php
get_header();

if ( is_home() && option::get('slideshow_show') == 'on' ) {
	get_template_part('wpzoom', 'showcase');
} else {
	echo '<div class="wrap"><div class="sep">&nbsp;</div></div>';
}

$static = false;
if ( option::get('homepage_static') == 'on' && 0 < ($pagid=option::get('homepage_static_page')) ) {
	query_posts("page_id=$pagid&showposts=1");
	if ( have_posts() ) the_post();
	$static = true;
}
?>

<div id="content">

	<div class="wrap">

		<div class="column column-narrow">&nbsp;</div><!-- end .column-narrow -->

		<div class="column column-double column-content column-last">

			<h1><?php if ( $static ) the_title(); else bloginfo('name'); ?></h1>

		</div>

		<div class="clear">&nbsp;</div>

		<div class="column column-narrow">

			<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('Sidebar: Homepage (Left)') ) echo '&nbsp;'; ?>

		</div><!-- end .column-narrow -->

		<div class="column column-content">

			<?php
			if ( $static ) {

				the_content('');
				?><p class="postmetadata"><?php edit_post_link( __('Edit this page', 'wpzoom'), '', '' ); ?></p><?php

			} else {

				?><p>Thank you for using Academica Theme by <a href="http://www.wpzoom.com">WPZOOM</a></p>
				<p>Please go to <strong>WPZOOM Theme Options > Homepage Options</strong> and select a <strong>static page</strong> or disable this block if it is unnecessarry.</p><?php

			}

			if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('Sidebar: Homepage (Middle)') ) echo '&nbsp;';
			?>

		</div><!-- end .column-content -->

		<div class="column column-narrow column-last">

			<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('Sidebar: Homepage (Right)') ) echo '&nbsp;'; ?>

		</div><!-- end .column-narrow -->

		<div class="clear">&nbsp;</div>

	</div><!-- end .wrap -->

</div><!-- end #content -->

<?php get_footer(); ?>