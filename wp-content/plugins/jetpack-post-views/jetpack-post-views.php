<?php

/*
 * Plugin Name: Jetpack Post Views
 * Plugin URI: http://blog.sklambert.com/jetpack-post-views/
 * Description: Adds a widget that displays your most popular posts using Jetpack stats. <strong>NOTE:</strong> If the plugin does not work, visit the <a href="options-general.php?page=jetpack_post_views">Settings</a> page to enter a WordPress API Key.
 * Author: Steven Lambert
 * Version: 1.0.4
 * Author URI: http://sklambert.com
 * License: GPL2+
 */

// Define plugin version
if ( !defined( 'JETPACK_POST_VIEWS_VERSION_NUM' ) ) {
	define( 'JETPACK_POST_VIEWS_VERSION_NUM', '1.0.4' );
}

/**
 * Jetpack Post Views
 * 
 * Queries the Jetpack API and adds a custom post_meta 'jetpack-post-views' that holds the total views of a 
 * post as listed on Jetpack. Adds a widget to display the top posts for a site. 
 * NOTE: Plugin must have a correct Wordpress API Key before the post_meta data is added.
 */
class Jetpack_Post_Views extends WP_Widget {

	// Private variables
	var $apiUrlBefore = 'http://stats.wordpress.com/csv.php';
	var $apiUrlAfter  = '&table=postviews&days=-1&limit=-1&summarize&format=json';

	/* CONSTRUCTOR */
	function __construct() {

		// Admin hooks
		add_action( 'admin_init',                          array( &$this, 'register_setting' ) );
		add_action( 'admin_menu',                          array( &$this, 'register_settings_page' ) ); 
		add_filter( 'plugin_action_links',                 array( &$this, 'settings_link' ), 10, 2 );    

		// Shecudled hooks
		add_action( 'jetpack_post_views_scheduled_update', array( &$this, 'get_post_views' ) );

		// Query the database for the blog_id
		global $wpdb;
		$stats_options = $wpdb->get_var( "SELECT option_value 
										  FROM   wp_options 
										  WHERE  option_name = 'stats_options'" );
		$stats = unserialize($stats_options);
		
		// Set blog_id
		if ( $stats ) {
			$this->blog_id = $stats['blog_id'];
		}
		else { // Jetpack stats unavailable

			// Try another possiblility to get the blog_id
			$jetpack_options = $wpdb->get_var( "SELECT option_value 
										  	  	FROM   wp_options 
										  	 	WHERE  option_name = 'jetpack_options'" );
			$jetpack = unserialize($jetpack_options);

			if ( $jetpack ) {
				$this->blog_id = $jetpack['id'];
			}
			else { // Jetpack stats really unabailable
				$this->blog_id = -1;
			}
		}

		// Grab the api key if it already exists
		$api_key = get_option( 'jetpack_post_views_wp_api_key' ) != "" ? get_option( 'jetpack_post_views_wp_api_key' ) : "";

		// Default settings
		$this->defaultsettings = (array) apply_filters( 'jetpack_post_views_defaultsettings', array(
			'version'  		   => JETPACK_POST_VIEWS_VERSION_NUM,
			'api_key'  		   => $api_key,
			'blog_id'  		   => $this->blog_id,
			'blog_uri' 		   => get_bloginfo( 'wpurl' ),
			'changed'  		   => 0,
			'connect_blog_id'  => 0,
			'connect_blog_uri' => 0
		) );

		// Create the settings array by merging the user's settings and the defaults
		$usersettings = (array) get_option('jetpack_post_views_settings');
		$this->settings = wp_parse_args( $usersettings, $this->defaultsettings );

		// Controls and options
		$widget_ops = array( 
			'classname'   => 'jetpack-post-views', 
			'description' => __('Your site\'s most popular posts using Jetpack stats', 'jetpack-post-views') 
		);
        $control_ops = array( 
        	'id_base' => 'jetpack-post-views-widget' 
        );

        // Set widget information
        $this->WP_Widget( 'jetpack-post-views-widget', __('Jetpack Post Views Widget', 'jetpack-post-views'), $widget_ops, $control_ops );
	}

	/* REGISTER SETTINGS PAGE */
	function register_settings_page() {
		add_options_page( __( 'Jetpack Post Views Settings', 'jetpack-post-views' ), __( 'Jetpack Post Views', 'jetpack-post-views' ), 'manage_options', 'jetpack_post_views', array( &$this, 'settings_page' ) );
	}


	/* REGISTER PLUGIN SETTINGS */
	function register_setting() {
		register_setting( 'jetpack_post_views_settings', 'jetpack_post_views_settings', array( &$this, 'validate_settings' ) );
	}


	/* ADD A "SETTINGS" LINK TO PLUGINS PAGE */
	function settings_link( $links, $file ) {
		static $this_plugin;
		
		if( empty($this_plugin) )
			$this_plugin = plugin_basename(__FILE__);

		if ( $file == $this_plugin )
			$links[] = '<a href="' . admin_url( 'options-general.php?page=jetpack_post_views' ) . '">' . __( 'Settings', 'jetpack-post-views' ) . '</a>';

		return $links;
	}


	/* SETTINGS PAGE */
	function settings_page() { ?>

		<style>
			.light {
				height: 14px;
				width: 14px;
				border-radius: 14px;
				-webkit-border-radius: 14px;
				-moz-border-radius: 14px;
				-ms-border-radius: 14px;
				-o-border-radius: 14px;
				position: relative;
				top: 3px;
				box-shadow: 
					0 1px 2px #fff, 
					0 -1px 1px #666,
					inset 1px -2px 6px rgba(0,0,0,0.5), 
					inset -1px 1px 6px rgba(255,255,255,0.8);
			}
				.green {
					background-color: #00b028;
				}
				.red {
					background-color: #d20406;
				}

			.inner-light {
				position: absolute;
				top: -1px;
				left: 5px;
			}
				.green .inner-light {
					background-color: rgba(123,252,149,0.7);
					border: 3px solid rgba(47,205,82,0.7);
					width: 1px;
					height: 1px;
					border-radius: 1px;
					-webkit-border-radius: 1px;
					-moz-border-radius: 1px;
					-ms-border-radius: 1px;
					-o-border-radius: 1px;
					filter: blur(1.5px);
					-webkit-filter: blur(1.5px);
					-moz-filter: blur(1.5px);
					-ms-filter: blur(1.5px);
					-o-filter: blur(1.5px);
				}
				.red .inner-light {
					background-color: rgba(225,162,157,0.7);
					border: 1px solid rgba(222,222,222,0.7);
					width: 7px;
					height: 7px;
					border-radius: 7px;
					-webkit-border-radius: 7px;
					-moz-border-radius: 7px;
					-ms-border-radius: 7px;
					-o-border-radius: 7px;
					filter: blur(2px);
					-webkit-filter: blur(2px);
					-moz-filter: blur(2px);
					-ms-filter: blur(2px);
					-o-filter: blur(2px);
				}
		</style>

		<div class="wrap">
		<?php if ( function_exists('screen_icon') ) screen_icon(); ?>

			<h2><?php _e( 'Jetpack Post Views Settings', 'jetpack-post-views' ); ?></h2>

			<p><?php _e( 'Use the settings below if the plugin is unable to connect to Jetpack using the function <code>stats_get_csv()</code>.', 'jetpack-post-views' ); ?></p>

			<form method="post" action="options.php">

			<?php settings_fields('jetpack_post_views_settings'); ?>

			<table class="form-table">
				<tr valign="top">
					<th scope="row"><label for="jetpack-post-views-api-key"><?php _e( 'WordPress API Key', 'jetpack-post-views' ); ?></label></th>
					<td><input name="jetpack_post_views_settings[api_key]" type="text" id="jetpack-post-views-api-key" value="<?php echo esc_attr( $this->settings['api_key'] ); ?>" class="regular-text" placeholder="<?php _e("https://apikey.wordpress.com/", 'jetpack-post-views'); ?>" /></td>
				</tr>
				<tr valign="top">
					<th scope="row"><label for="jetpack-post-views-blog_uri"><?php _e( 'Blog URI', 'jetpack-post-views' ); ?></label></th>
					<td><input name="jetpack_post_views_settings[blog_uri]" type="text" id="jetpack-post-views-blog-uri" value="<?php echo esc_attr( $this->settings['blog_uri'] ); ?>" class="regular-text" /></td>
				</tr>
			</table>

			<h3><?php _e( 'Connections', 'jetpack-post-views' ); ?></h3>

			<p><?php _e( 'Shows the status of connections to the Jetpack API. If at least one of the below connections shows green, the plugin should work properly.<br>Stats updated using the first connection available  in the order that they are listed.', 'jetpack-post-views' ); ?></p>

			<?php 
				if ( $this->settings['changed'] ) {
					// Test the URI connection
					$middle = '?api_key='.$this->settings['api_key'].'&blog_uri='.$this->settings['blog_uri'];
					$url = $this->apiUrlBefore.$middle.$this->apiUrlAfter;
					$json = file_get_contents( $url );
					$data = json_decode( $json, true );

					if ( $data[0]['postviews'] ) { // We got data back
						$this->settings['connect_blog_uri'] = 1;
					}
					else {
						$this->settings['connect_blog_uri'] = 0;
					}

					// Test the Blog ID connection
					$middle = '?api_key='.$this->settings['api_key'].'&blog_id='.$this->settings['blog_id'];
					$url = $this->apiUrlBefore.$middle.$this->apiUrlAfter;
					$json = file_get_contents( $url );
					$data = json_decode( $json, true );

					if ( $data[0]['postviews'] ) { // We got data back
						$this->settings['connect_blog_id'] = 1;
					}
					else {
						$this->settings['connect_blog_id'] = 0;
					}

					$this->get_post_views();
				}
			?>

			<input type="hidden" name="jetpack_post_views_settings[connect_blog_uri]" id="jetpack-post-views-connect-blog-id" value="<?php echo esc_attr( $this->settings['connect_blog_uri'] ); ?>" />
			<input type="hidden" name="jetpack_post_views_settings[connect_blog_id]" id="jetpack-post-views-connect-blog-id" value="<?php echo esc_attr( $this->settings['connect_blog_id'] ); ?>" />
			<table class="form-table">
				<fieldset>
					<tr valign="top">
						<th scope="row"><?php _e( 'Function <code>stats_get_csv()</code> exists', 'jetpack-post-views' ); ?></th>
						<td>
							<?php if ( function_exists('stats_get_csv') ) { ?>
								<div class="light green"><div class="inner-light"></div></div>
							<?php } else { ?>
								<div class="light red"><div class="inner-light"></div></div>
							<?php } ?>
						</td>
					</tr>
					<tr valign="top">
						<th scope="row"><?php _e( 'Can connect using Blog URI', 'jetpack-post-views' ); ?></th>
						<td>
							<?php if ( $this->settings['connect_blog_uri'] ) { ?>
								<div class="light green"><div class="inner-light"></div></div>
							<?php } else { ?>
								<div class="light red"><div class="inner-light"></div></div>
							<?php } ?>
						</td>
					</tr>
					<tr valign="top">
						<th scope="row"><?php _e( 'Can connect using Blog ID', 'jetpack-post-views' ); ?></th>
						<td>
							<?php if ( $this->settings['connect_blog_id'] ) { ?>
								<div class="light green"><div class="inner-light"></div></div>
							<?php } else { ?>
								<div class="light red"><div class="inner-light"></div></div>
							<?php } ?>
						</td>
					</tr>
				</fieldset>
			</table>

			<p class="submit">
			<?php
				if ( function_exists( 'submit_button' ) ) {
					submit_button( null, 'primary', 'jetpack-post-views-submit', false );
				} else {
					echo '<input type="submit" name="jetpack-post-views-submit" class="button-primary" value="' . __( 'Save Changes') . '" />' . "\n";
				}

				/*
				echo "<div class='widefat'><h3>Plugin options</h3><pre>";
				foreach ($this->settings as $key => $value) {
				    echo "[$key]: $value\n";
				}
				echo "</pre></div>";

				if (function_exists('stats_get_csv')) {
					echo "Function exists";
				}
				else {
					echo "Function does not exist";
				}
				*/
			?>
			</p>

		</form>

	</div>

	<?php
	}

	/* WIDGET OUTPUT */
	function widget( $args, $instance ) {
		global $post;
		extract ( $args );

		$title = apply_filters('widget_title', $instance['title'] );

		echo $before_widget;

		// Print the title
		if ( $title )
			echo $before_title . $title . $after_title;

		// Grab the top posts and display them using the stats_get_csv function
		if ($instance['days'] != '-1' && function_exists('stats_get_csv') ) {
			$posts = stats_get_csv('postviews', 'days='.$instance['days'].'&limit=-1' );
			$exclude_posts = explode( ',', $instance['exclude_posts'] );
			$count = 0;

			// Print top posts in order
			echo "<ul>";
			foreach( $posts as $post ) {
				// Stop printing posts if we reach the limit
				if ( $count >= intval( $instance['num_posts'] ) ) {
					break;
				}

				// Only display posts
				if ( $post['post_id'] && get_post( $post['post_id'] ) && 'post' === get_post_type( $post['post_id'] ) && !in_array( $post['post_id'], $exclude_posts) ) { ?>
					<li><a href="<?php echo get_permalink( $post['post_id'] ) ?>"><?php echo get_the_title( $post['post_id'] ) ?></a>
						<?php if ( $instance['show_views'] ) { 
							echo " - ".number_format_i18n( $post['views'] )." views";
						} ?>
					</li>
				<?php
					$count++;
				}
			}
			echo "</ul>";
		}
		// Else grab the top posts using the post meta
		else {
			$args = array( 
				'numberposts' => $instance['num_posts'], 
				'orderby' 	  => 'meta_value_num', 
				'order'       => 'DESC', 
				'exclude'     => $instance['exclude_posts'],
				'meta_key' 	  => 'jetpack-post-views'
			);
			$posts = get_posts( $args );

			// Print top posts in order
			echo "<ul>";
			foreach( $posts as $post ) { ?>
				<li><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
					<?php if ( $instance['show_views'] ) { 
						echo " - ".number_format_i18n( get_post_meta( $post->ID, 'jetpack-post-views', true ) )." views";
					} ?>
				</li>
			<?php
			}
			echo "</ul>";
		}

		echo $after_widget;
	}


	/* UPDATE WIDGET OPTIONS */
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;

		// Check nonce
		check_admin_referer('jetpack-post-views-widget-form-submition');

		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['show_views'] = strip_tags( $new_instance['show_views'] );
		$num_posts = intval( strip_tags( $new_instance['num_posts'] ) );
		$instance['days'] = strip_tags( $new_instance['days'] );
		$instance['exclude_posts'] = strip_tags( $new_instance['exclude_posts'] );
		
		// Set default number of posts to display if invalid option
		if ( $num_posts > 0 ) {
			$instance['num_posts'] = $num_posts;
		}
		else {
			$instance['num_posts'] = 5;
		}

		return $instance;
	}


	/* DISPLAY WIDGET OPTIONS */
	function form( $instance ) {

		// Default widget settings
		$defaults = array( 
			'title'         => __('Most Popular Posts', 'jetpack-post-views'), 
			'error'         => '', 
			'num_posts'     => 5,
			'days'          => '-1',
			'exclude_posts' => '',
			'show_views'    => false
		);
		$instance = wp_parse_args( (array) $instance, $defaults );

		// Set nonce
		if ( function_exists('wp_nonce_field') ) {
			wp_nonce_field('jetpack-post-views-widget-form-submition');
			echo "\n<!-- end of wp_nonce_field -->\n";
		}

		?>
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('Title:', 'jetpack-post-views'); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" type="text" />
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'num_posts' ); ?>"><?php _e('Number of posts to show:', 'jetpack-post-views'); ?></label>
			<input id="<?php echo $this->get_field_id( 'num_posts' ); ?>" name="<?php echo $this->get_field_name( 'num_posts' ); ?>" value="<?php echo $instance['num_posts']; ?>" type="text" size="3" />
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'days' ); ?>"><?php _e('<span class="error">*</span>Time interval:', 'jetpack-post-views'); ?></label>
			<select id="<?php echo $this->get_field_id( 'days' ); ?>" name="<?php echo $this->get_field_name( 'days' ); ?>">
				<option value="-1" <?php echo ($instance['days'] == '-1' ? 'selected' : '') ?> ><?php _e('Unlimited', 'jetpack-post-views'); ?></option>
				<option value="1" <?php echo ($instance['days'] == '1' ? 'selected' : '') ?> ><?php _e('Day', 'jetpack-post-views'); ?></option>
				<option value="7" <?php echo ($instance['days'] == '7' ? 'selected' : '') ?> ><?php _e('Week', 'jetpack-post-views'); ?></option>
				<option value="30" <?php echo ($instance['days'] == '30' ? 'selected' : '') ?> ><?php _e('Month', 'jetpack-post-views'); ?></option>
				<option value="366" <?php echo ($instance['days'] == '366' ? 'selected' : '') ?> ><?php _e('Year', 'jetpack-post-views'); ?></option>
			</select>
		</p>
		
		<p>
			<label for="<?php echo $this->get_field_id( 'exclude_posts' ); ?>"><?php _e('Exclude Posts:', 'jetpack-post-views'); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'exclude_posts' ); ?>" name="<?php echo $this->get_field_name( 'exclude_posts' ); ?>" value="<?php echo $instance['exclude_posts']; ?>" type="text" placeholder="<?php _e('Comma-separated list of post IDs', 'jetpack-post-views'); ?>" />
		<p>
			<input class="checkbox" type="checkbox" <?php checked( $instance['show_views'], 'on' ); ?> id="<?php echo $this->get_field_id( 'show_views' ); ?>" name="<?php echo $this->get_field_name( 'show_views' ); ?>" /> 
			<label for="<?php echo $this->get_field_id( 'show_views' ); ?>"><?php _e('Display number of views?', 'jetpack-post-views'); ?></label>
		</p>

		<p>
			<div><?php _e('<span class="error">*</span>Only works if the function <code>stats_get_csv()</code> exists', 'jetpack-post-views'); ?></div>
		</p>

	<?php
	}

	/* 
	* SCHEDULED UPDATE
	* Update all posts 'jetpack-post-views' post meta
	*/
	function get_post_views() {
		$run_stats = 0;
		$post_stats = array();
		$postdata = array();

		// Get stats using the stats_get_csv function
		if ( function_exists('stats_get_csv') ) {
			$post_stats = stats_get_csv('postviews', 'days=-1&limit=-1&summarize');
			$run_stats = 1;
		}
		// Else get the stats using the blog_uri
		else if ( $this->settings['connect_blog_uri'] ) {
			$middle = '?api_key='.$this->settings['api_key'].'&blog_uri='.$this->settings['blog_uri'];
			$url = $this->apiUrlBefore.$middle.$this->apiUrlAfter;
			$json = file_get_contents( $url );
			$data = json_decode( $json, true );
			$post_stats = $data[0]['postviews'];
			$run_stats = 1;
		}
		// Otherwise get the stats using the blog_id
		else if ( $this->settings['connect_blog_id'] ) {
			$middle = '?api_key='.$this->settings['api_key'].'&blog_uri='.$this->settings['blog_uri'];
			$url = $this->apiUrlBefore.$middle.$this->apiUrlAfter;
			$json = file_get_contents( $url );
			$data = json_decode( $json, true );
			$post_stats = $data[0]['postviews'];
			$run_stats = 1;
		}

		if ( $run_stats ) {
			global $post;

			// Create a temporary array and save all data
			foreach ( $post_stats as $postinfo ) {
				$postdata[ $postinfo['post_id'] ] = strip_tags( $postinfo['views'] );
			}

			// Grab all posts and update them
			$args = array( 'numberposts' => -1, 'post_type' => 'post', 'post_status' => 'publish');
			$allposts = get_posts( $args );
			foreach( $allposts as $post) {
				// Ensure that the $post-ID exists as a key in the array before trying to update post information.
				// This prevents the uers from pulling data from another website and trying to add it to their own
				// posts. 
				if ( array_key_exists( $post->ID, $postdata) ) {
					$newViews = intval( $postdata[ $post->ID ] );
 					$oldViews = get_post_meta( $post->ID, 'jetpack-post-views', true );

					// Only update posts with new stats. Prevents posts from being updated with '0' views when
					// the API service is down. 
					if ( $oldViews && $newViews > $oldViews ) {
						update_post_meta( $post->ID, 'jetpack-post-views', $newViews );
					}
					else {
						add_post_meta( $post->ID, 'jetpack-post-views', $newViews, true );
					}
				}
			}
		}
	}

	/* UPGRADE PLUGIN TO NEW VERSION */
	function upgrade() {
		// Delete old options
		delete_option( 'jetpack-post-views_version' );
		delete_option( 'jetpack_post_views_wp_api_key' );
		delete_option( 'jetpack_post_views_stats_has_run' );

		define( 'JETPACK_POST_VIEWS_VERSION_NUM', '1.0.4' );
	}


	/* VALIDATE SETTING PAGE SETTINGS */
	function validate_settings( $settings ) {
		if ( !empty($_POST['jetpack-post-views-defaults']) ) {
			$settings = $this->defaultsettings;
			$_REQUEST['_wp_http_referer'] = add_query_arg( 'defaults', 'true', $_REQUEST['_wp_http_referer'] );
		} else {
			// Hidden fields
			$settings['connect_blog_uri'] = strip_tags( $settings['connect_blog_uri'] );
			$settings['connect_blog_id']  = strip_tags( $settings['connect_blog_id'] );

			$settings['api_key']  = ( !empty($settings['api_key']) )  ? strip_tags( $settings['api_key'] )  : "";
			$settings['blog_uri'] = ( !empty($settings['blog_uri']) ) ? strip_tags( $settings['blog_uri'] ) : get_bloginfo( 'wpurl' );
			
			// Flag settings change
			if ( $settings['api_key'] != $this->settings['api_key'] || $settings['blog_uri'] != $this->settings['blog_uri'] ) {
				$settings['changed'] = 1;
			}
		}

		return $settings;
	}


	// PHP4 compatibility
	function Jetpack_Post_Views() {
		$this->__construct();
	}
}


// Register the wiget
function jetpack_post_views_register_widget() {  
    register_widget( 'Jetpack_Post_Views' );
}
add_action( 'widgets_init', 'jetpack_post_views_register_widget' );

/* SET SCHEDULED EVENT */
function jetpack_post_views_on_activation() {
	wp_schedule_event( time() + 3600, 'hourly', 'jetpack_post_views_scheduled_update' );
	global $Jetpack_Post_Views;
	$Jetpack_Post_Views = new Jetpack_Post_Views();
	$Jetpack_Post_Views->get_post_views();

	// Upgrade the plugin if necessary
	if ( JETPACK_POST_VIEWS_VERSION_NUM != '1.0.4' ) {
		$Jetpack_Post_Views->upgrade();
	}
}

/* UNSET SCHEDULED EVENT */
function jetpack_post_views_on_deactivation() {
	wp_clear_scheduled_hook( 'jetpack_post_views_scheduled_update' );
}
register_activation_hook( __FILE__, 'jetpack_post_views_on_activation' );
register_deactivation_hook( __FILE__, 'jetpack_post_views_on_deactivation' );

/* 
 * DISPLAY TOP POSTS
 * Use the Jetpack stats_get_csv() function to create a list of the top posts
 * args: days         - number of days of the desired time frame. '-1' means unlimited 
 * 		 limit        - number of posts to display. '-1' means unlimited. If days is -1, then limit is capped at 500
 *       exclude      - comma-separated list of post IDs to exclude form displaying
 *       displayViews - flag to display the post views
 */
function JPV_display_top_posts( $args = array( 'days' => '-1', 'limit' => '5', 'exclude' => '', 'displayViews' => false ) ) {
	// Ensure that the stats_get_csv() function exists and returns posts
	if ( function_exists('stats_get_csv') && $posts = stats_get_csv('postviews', 'days='.($args['days'] ? $args['days'] : '-1').'&limit=-1' ) ) {
		$count = 0;
		$exclude_posts = explode( ',', $args['exclude'] );

		// Print top posts in order
		echo "<ul class='JVP-top-posts'>";
		foreach( $posts as $post ) {

			// Stop printing posts if we reach the limit
			if ( $args['limit'] && $count >= intval( $args['limit'] ) ) {
				break;
			}

			// Only display posts
			if ( $post['post_id'] && get_post( $post['post_id'] ) && 'post' === get_post_type( $post['post_id'] ) && !in_array( $post['post_id'], $exclude_posts) ) { ?>
				<li><a href="<?php echo get_permalink( $post['post_id'] ) ?>"><?php echo get_the_title( $post['post_id'] ) ?></a>
					<?php if ( $args['displayViews'] ) { 
						echo " - ".number_format_i18n( $post['views'] )." views";
					} ?>
				</li>
			<?php
				$count++;
			}
		}
		echo "</ul>";
	}
}