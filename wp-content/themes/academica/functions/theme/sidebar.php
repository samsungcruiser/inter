<?php
/*-----------------------------------------------------------------------------------*/
/* Initializing Widgetized Areas (Sidebars)											                     */
/*-----------------------------------------------------------------------------------*/

/*----------------------------------*/
/* Sidebar							            */
/*----------------------------------*/

register_sidebar( array(
	'name' => 'Sidebar: Homepage (Left)',
	'before_widget' => '<div class="widget">',
	'after_widget' => '</div>',
	'before_title' => '<p class="heading">',
	'after_title' => '</p>'
) );

register_sidebar( array(
	'name' => 'Sidebar: Homepage (Right)',
	'before_widget' => '<div class="widget">',
	'after_widget' => '</div>',
	'before_title' => '<p class="heading">',
	'after_title' => '</p>'
) );

register_sidebar( array(
	'name' => 'Sidebar: Homepage (Middle)',
	'before_widget' => '<div class="widget">',
	'after_widget' => '</div>',
	'before_title' => '<h2>',
	'after_title' => '</h2>'
) );

register_sidebar( array(
	'name' => 'Sidebar: Archive Pages',
	'before_widget' => '<div class="widget">',
	'after_widget' => '</div>',
	'before_title' => '<p class="heading">',
	'after_title' => '</p>'
) );

register_sidebar( array(
	'name' => 'Sidebar: Pages (Left)',
	'before_widget' => '<div class="widget">',
	'after_widget' => '</div>',
	'before_title' => '<p class="heading">',
	'after_title' => '</p>'
) );

register_sidebar( array(
	'name' => 'Sidebar: Pages (Right)',
	'before_widget' => '<div class="widget">',
	'after_widget' => '</div>',
	'before_title' => '<p class="heading">',
	'after_title' => '</p>'
) );

register_sidebar( array(
	'name' => 'Sidebar: Posts (Left)',
	'before_widget' => '<div class="widget">',
	'after_widget' => '</div>',
	'before_title' => '<p class="heading">',
	'after_title' => '</p>'
) );

register_sidebar( array(
	'name' => 'Sidebar: Posts (Right)',
	'before_widget' => '<div class="widget">',
	'after_widget' => '</div>',
	'before_title' => '<p class="heading">',
	'after_title' => '</p>'
) );

/*----------------------------------*/
/* Footer widgetized areas		      */
/*----------------------------------*/

register_sidebar( array(
	'name' => 'Footer: Right',
	'before_widget' => '<div class="widget">',
	'after_widget' => '</div>',
	'before_title' => '<p class="heading">',
	'after_title' => '</p>'
) );
?>