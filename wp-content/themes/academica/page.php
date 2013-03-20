<?php
global $wpz_template;
if ( !isset($wpz_template) || empty($wpz_template) ) $wpz_template = '';

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

				if ( $wpz_template == '' || $wpz_template == 'side-left' ) { ?><div class="column column-narrow">&nbsp;</div><!-- end .column-narrow --><?php }

				?><div class="column <?php echo $wpz_template == 'full-width' || $wpz_template == 'side-right' ? 'column-full' : 'column-double'; ?> column-content column-last">

					<h1><?php the_title(); ?></h1>

				</div><!-- end .column-double -->

				<div class="clear">&nbsp;</div>

				<?php
				if ( $wpz_template == '' || $wpz_template == 'side-left' ) {

					?><div class="column column-narrow">

						<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('Sidebar: Pages (Left)') ) echo '&nbsp;'; ?>

					</div><!-- end .column-narrow --><?php

				}
				?>

				<div class="column<?php if ( $wpz_template == 'side-left' || $wpz_template == 'side-right' ) echo ' column-double'; elseif ( $wpz_template == 'full-width' ) echo ' column-full'; ?> column-content<?php if ( $wpz_template == 'side-left' || $wpz_template == 'full-width' ) echo ' column-last'; ?> single">

					<?php
					the_content('');
					
					wp_link_pages( array( 'before' => '<p class="pages"><strong>' . __('Pages', 'wpzoom') . ':</strong> ', 'after' => '</p>', 'next_or_number' => 'number' ) );
					?>

					<p class="postmetadata"><?php edit_post_link( __('EDIT', 'wpzoom'), ' / ', ''); ?></p>

					<?php comments_template(); ?>

				</div><!-- end .column-content -->

				<?php
				if ( $wpz_template == '' || $wpz_template == 'side-right' ) {

					?><div class="column column-narrow column-last">

						<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('Sidebar: Pages (Right)') ) echo '&nbsp;'; ?>

					</div><!-- end .column-narrow --><?php

				}

			endwhile;

		endif;
		?>

		<div class="clear">&nbsp;</div>

	</div><!-- end .wrap -->

</div><!-- end #content -->

<?php get_footer(); ?>