<?php

if( !defined( 'ABSPATH' ) && !defined( 'WP_UNINSTALL_PLUGIN' ) )
    exit();

// Delete all options
delete_option( 'jetpack_post_views' );
delete_option( 'jetpack-post-views_version' );
delete_option( 'jetpack_post_views_wp_api_key' );
delete_option( 'jetpack_post_views_stats_has_run' );

// Undefine plugin version

// Delete post meta from each post
$args = array( 'numberposts' => -1, 'post_type' => 'post', 'post_status' => 'publish');
$allposts = get_posts( $args );
foreach( $allposts as $post) {
	delete_post_meta( $post->ID, 'jetpack-post-views' );
}