<?php
/* 	Custom Posts Types for Slideshow 
======================================= */
add_action('init', 'slideshow_register');

function slideshow_register() {
	$labels = array(
		'name' => _x('Slideshow', 'post type general name'),
		'singular_name' => _x('Slideshow Item', 'post type singular name'),
		'add_new' => _x('Add a New Slide', 'slideshow item'),
		'add_new_item' => __('Add New Slideshow Item'),
		'edit_item' => __('Edit Slideshow Item'),
		'new_item' => __('New Slideshow Item'),
		'view_item' => __('View Slideshow Item'),
		'search_items' => __('Search Slideshow'),
		'not_found' =>  __('Nothing found'),
		'not_found_in_trash' => __('Nothing found in Trash'),
		'parent_item_colon' => ''
	);
 
	$args = array(
		'labels' => $labels,
		'public' => true,
		'publicly_queryable' => true,
		'show_ui' => true,
		'query_var' => true,
 		'rewrite' => true,
		'capability_type' => 'post',
		'hierarchical' => false,
		'menu_position' => 20,
		'supports' => array('title','editor','thumbnail', 'excerpt', 'custom-fields')
	  ); 
 
	register_post_type( 'slideshow' , $args );
}
?>