<?php
$template = '' == ($tpl=trim(get_post_meta($post->ID, 'wpzoom_post_template', true))) ? 'side-both' : $tpl;
get_header();
?>

<div id="content">

	<div class="wrap">

		<div class="sep sepinside">&nbsp;</div>

		<?php
		wp_reset_query();

		if ( have_posts() ) :

			while ( have_posts() ) :

				the_post();

				if ( $template == 'side-both' || $template == 'side-left' ) { ?><div class="column column-narrow">&nbsp;</div><!-- end .column-narrow --><?php }

				?><div class="column <?php echo $template == 'full' || $template == 'side-right' ? 'column-full' : 'column-double'; ?> column-content column-last">

					<h1><?php the_title(); ?></h1>

				</div><!-- end .column-double -->

				<div class="clear">&nbsp;</div>

				<?php
				if ( $template == 'side-both' || $template == 'side-left' ) {

					?><div class="column column-narrow">

						<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('Sidebar: Posts (Left)') ) echo '&nbsp;'; ?>

					</div><!-- end .column-narrow --><?php

				}
				?>

				<div class="column<?php if ( $template == 'side-left' || $template == 'side-right' ) echo ' column-double'; elseif ( $template == 'full' ) echo ' column-full'; ?> column-content<?php if ( $template == 'side-left' || $template == 'full' ) echo ' column-last'; ?> single">

					<?php
					the_content('');
					
					wp_link_pages( array( 'before' => '<p class="pages"><strong>' . __('Pages', 'wpzoom') . ':</strong> ', 'after' => '</p>', 'next_or_number' => 'number' ) );
					
					the_tags( '<p class="tags"><strong>' . __('Tags', 'wpzoom') . ':</strong> ', ', ', '</p>');
					?>

					<p class="postmetadata"><?php _e('By', 'wpzoom'); ?> <?php the_author_posts_link(); ?> <?php _e('in', 'wpzoom'); ?> <span class="category"><?php the_category(', '); ?></span> <?php _e('on', 'wpzoom'); ?> <span class="datetime"><?php the_date(); ?></span><?php edit_post_link( __('EDIT', 'wpzoom'), ' / ', '' ); ?></p>

					<?php comments_template(); ?>

				</div><!-- end .column-content -->

				<?php
				if ( $template == 'side-both' || $template == 'side-right' ) {

					?><div class="column column-narrow column-last">

						<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('Sidebar: Posts (Right)') ) echo '&nbsp;'; ?>

					</div><!-- end .column-narrow --><?php

				}

			endwhile;

		endif;
		?>

		<div class="clear">&nbsp;</div>

	</div><!-- end .wrap -->

</div><!-- end #content -->

<?php get_footer(); ?>