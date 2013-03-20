<?php
get_header();

$curauth = get_query_var('author_name') ? get_userdatabylogin(get_query_var('author_name')) : get_userdata(get_query_var('author'));
?>

<div id="content">

	<div class="wrap">

		<div class="sep sepinside">&nbsp;</div>

		<div class="column column-narrow">&nbsp;</div><!-- end .column-narrow -->

		<div class="column column-double column-content column-last">

			<?php $post = $posts[0]; // Hack. Set $post so that the_date() works. ?>
			<h1><?php _e('Author Archive', 'wpzoom'); ?>: <a href="<?php echo $curauth->user_url; ?>"><?php echo $curauth->display_name; ?></a></h1>

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