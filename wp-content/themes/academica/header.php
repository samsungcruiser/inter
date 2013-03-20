<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" <?php language_attributes(); ?>>
<head profile="http://gmpg.org/xfn/11">

	<title><?php ui::title(); ?></title>
	<meta http-equiv="content-type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />

	<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />

	<link rel="stylesheet" type="text/css" href="<?php bloginfo('stylesheet_url'); ?>" media="screen" />

	<?php wp_head(); ?>

	<script type="text/javascript">
		jQuery(function($){
			$("#menuhead ul").css({display:"none"}); // Opera Fix
			$("#menuhead li").hover(function(){
				$(this).find('ul:first').css({visibility:"visible",display:"none"}).show(268);
			}, function(){
				$(this).find('ul:first').css({visibility:"hidden"});
			});
		});
	</script>

</head>

<body <?php body_class(); ?>>

	<div id="wrap">

		<div id="mainNav">
			<div class="wrap">
				<?php wp_nav_menu( array( 'container' => '', 'container_class' => '', 'menu_class' => '', 'menu_id' => 'menuhead', 'sort_column' => 'menu_order', 'theme_location' => 'primary' ) ); ?>
			</div><!-- end .wrap -->
		</div><!-- end #mainNav -->

		<div id="crumbs">
			<div class="wrap">
				<p><?php wpzoom_breadcrumbs(); ?></p>
			</div><!-- end .wrap -->
		</div>

		<div id="header">

			<div class="wrap">

				<div id="logo">
					<?php if (!option::get('misc_logo_path')) { echo "<h1>"; } ?>

					<a href="<?php echo home_url(); ?>" title="<?php bloginfo('description'); ?>">
						<?php if (!option::get('misc_logo_path')) { bloginfo('name'); } else { ?>
							<img src="<?php echo ui::logo(); ?>" alt="<?php bloginfo('name'); ?>" />
						<?php } ?>
					</a>

					<?php if (!option::get('misc_logo_path')) { echo "</h1>"; } ?>

					<?php if (option::get('logo_desc') == 'on') {  ?><p id="tagline"><?php bloginfo('description'); ?></p><?php } ?>
				</div>

				<div id="search"><?php get_template_part('searchform'); ?></div>

				<?php get_template_part('wpzoom', 'social'); // calling social block ?>

				<div class="clear">&nbsp;</div>

			</div><!-- end .wrap -->

		</div><!-- end #header -->