<div id="homeGallery">

	<div class="wrap">

		<div id="showcase">

			<a class="prev browse" rel="nofollow"><?php _e('prev', 'wpzoom'); ?></a>
			<a class="next browse" rel="nofollow"><?php _e('next', 'wpzoom'); ?></a>
			
			<ul class="slides">

			<?php
			$loop = new WP_Query( array( 'post_type' => 'slideshow', 'posts_per_page' => option::get('slideshow_num') ) );
			$default_image = get_template_directory_uri() . '/images/x.gif';

			while ( $loop->have_posts() ) :

				$loop->the_post();

				?>
				<li class="slide">
				<?php

				$link = get_post_meta($post->ID, 'wpzoom_slide_url', true);

				if (strlen($link) > 1) echo '<a href="' . $link . '">';

				get_the_image( array( 'size' => 'homepage-slider', 'width' => 960, 'height' => 300, 'default_image' => $default_image, 'link_to_post' => false, 'before' => '', 'after' => '' ) );
				
				if (strlen($link) > 1) echo '</a>';
				
				?>
				</li>
				<?php

			endwhile;
			?>
			
			</ul><!-- end .slides -->

		</div><!-- end #showcase -->

		<script type="text/javascript">
		jQuery(document).ready(function() {
			
				jQuery('#showcase').css({ display : 'block' });
				jQuery("#showcase").slides({
				container: 'slides',
				play: <?php if (option::get('featured_rotate') == 'on') { echo option::get('featured_interval'); }  else { ?>0<?php } ?>,
				slideSpeed: 500,
				generatePagination: false,
		 		pause: 1000,
		 		effect: 'slide, fade',
		 		autoHeight: true,
				hoverPause: true,
				preload: true,
				preloadImage: '<?php echo get_template_directory_uri(); ?>/images/loading2.gif'
			});		 
		
		});
		</script>

	</div><!-- end .wrap -->

</div><!-- end #homeGallery -->