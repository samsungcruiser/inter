<div id="social">
	<ul>
		<?php
		if ( strlen(option::get('misc_soc_twitter')) > 1 ) { ?><li><a href="<?php echo option::get('misc_soc_twitter'); ?>" rel="external,nofollow"><img src="<?php echo get_template_directory_uri(); ?>/images/icons/icon_twitter.png" alt="" /></a></li><?php }
		if ( strlen(option::get('misc_soc_flickr')) > 1 ) { ?><li><a href="<?php echo option::get('misc_soc_flickr'); ?>" rel="external,nofollow"><img src="<?php echo get_template_directory_uri(); ?>/images/icons/icon_flickr.png" alt="" /></a></li><?php }
		if ( strlen(option::get('misc_soc_facebook')) > 1 ) { ?><li><a href="<?php echo option::get('misc_soc_facebook'); ?>" rel="external,nofollow"><img src="<?php echo get_template_directory_uri(); ?>/images/icons/icon_facebook.png" alt="" /></a></li><?php }
		if ( strlen(option::get('misc_soc_linkedin')) > 1 ) { ?><li><a href="<?php echo option::get('misc_soc_linkedin'); ?>" rel="external,nofollow"><img src="<?php echo get_template_directory_uri(); ?>/images/icons/icon_linkedin.png" alt="" /></a></li><?php }
		if ( strlen(option::get('misc_soc_youtube')) > 1 ) { ?><li><a href="<?php echo option::get('misc_soc_youtube'); ?>" rel="external,nofollow"><img src="<?php echo get_template_directory_uri(); ?>/images/icons/icon_youtube.png" alt="" /></a></li><?php }
		?>
	</ul>
</div>