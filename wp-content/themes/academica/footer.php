		<div id="footer">

			<div class="wrap">

				<div id="footerColumn"><?php if ( function_exists('dynamic_sidebar') ) dynamic_sidebar('Footer: Right'); ?></div>

				<?php wp_nav_menu( array( 'container' => '', 'container_class' => '', 'menu_class' => '', 'depth' => '1', 'menu_id' => 'menufooter', 'sort_column' => 'menu_order', 'theme_location' => 'secondary' ) ); ?>

				<p class="copy">Copyright &copy; <?php echo date('Y', time()); ?> <?php bloginfo('name'); ?>. All rights reserved. <?php _e('WordPress Theme', 'wpzoom'); ?> <?php _e('by', 'wpzoom'); ?> <a href="http://www.wpzoom.com" target="_blank" title="WordPress Themes">WPZOOM</a></p>

				<div class="clear">&nbsp;</div>

			</div><!-- end .wrap -->

		</div><!-- end #footer -->

	</div><!-- end #wrap -->

	<?php wp_footer(); ?>

</body>
</html>