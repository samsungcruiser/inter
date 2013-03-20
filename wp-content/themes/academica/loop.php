<div class="posts">

	<?php
	if ( have_posts() ) :

		while ( have_posts() ) :

			the_post();

			?><div <?php post_class('post'); ?>>

				<?php
				get_the_image( array( 'size' => 'loop-main', 'width' => 120, 'height' => 80, 'before' => '<div class="thumb">', 'after' => '</div>' ) );
				?>

				<div class="post-info">
					<h2><a href="<?php the_permalink(); ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><?php the_title(); ?></a></h2>
					<p class="postmetadata"><?php the_date(); ?> <?php the_time(); ?> / <a href="<?php the_permalink(); ?>#commentspost" title="Jump to the comments"><?php comments_number( __('no comments', 'wpzoom'), __('1 comment', 'wpzoom'), __('% comments', 'wpzoom') ); ?></a><?php edit_post_link( __('EDIT', 'wpzoom'), ' / ', '' ); ?></p>
					<div class="info"><?php the_excerpt(); ?></div>
				</div><!-- .post-info -->
	
				<div class="clear">&nbsp;</div>

			</div><!-- end .post --><?php

		endwhile;

	else:

		?><h2><?php _e('Sorry, there are no posts in this category.', 'wpzoom'); ?></h2><?php

	endif;

	get_template_part('pagination');
	?>

</div><!-- end .posts -->