<?php
/**
 * Plugin Name: Gallery Widget Pro
 * Plugin URI: http://xavisys.com/
 * Description: A widget that lets you display cycling gallery photos as a widget.  Requires PHP5.
 * Version: 1.0.1
 * Author: Aaron D. Campbell
 * Author URI: http://xavisys.com/
 */

/**
 * @todo Add more options for sorting
 * @todo comment code
 *
 * Changelog:
 * 05/31/2008: 1.0.1
 * 	- Fixed problem with hard coded table prefix
 *
 * 05/30/2008: 1.0.0
 * 	- Added to wordpress.org repository
 *
 * 05/19/2008: 0.0.1
 * 	- Original Version
 */

/*  Copyright 2006  Aaron D. Campbell  (email : wp_plugins@xavisys.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
*/
/**
 * wpGalleryWidget is the class that handles ALL of the plugin functionality.
 * It helps us avoid name collisions
 * http://codex.wordpress.org/Writing_a_Plugin#Avoiding_Function_Name_Collisions
 */

class wpGalleryWidget
{
	private $_posts = array();
	private $_pages = array();

	public function __construct() {
		$jsDir = get_option('siteurl') . '/wp-content/plugins/gallery-widget-pro/js';

        wp_register_script('gallery-widget-pro', "{$jsDir}/gallery-widget-pro.js", false, '0.0.1a');
        wp_register_script('fastinit', "{$jsDir}/fastinit.js", false, '1.3');
        wp_register_script('crossfade', "{$jsDir}/crossfade.js", array('scriptaculous-effects', 'fastinit'), '4.1');
	}

	/**
	 * Displays the Twitter widget, with all tweets in an unordered list.
	 * Things are classed but not styled to allow easy styling.
	 *
	 * @param array $args - Widget Settings
	 * @param array|int $widget_args - Widget Number
	 */
	public function display($args, $widget_args = 1) {
		extract( $args, EXTR_SKIP );
		if ( is_numeric($widget_args) )
			$widget_args = array( 'number' => $widget_args );
		$widget_args = wp_parse_args( $widget_args, array( 'number' => -1 ) );
		extract( $widget_args, EXTR_SKIP );

		$options = get_option('widget_gallery');
		if ( !isset($options[$number]) ) {
			return;
		}

		// Validate our options
		/*
		if (!isset($options[$number]['feed']) || !in_array($options[$number]['feed'], array('user', 'friends'))) {
			$options[$number]['feed'] = 'user';
		}
		$options[$number]['items'] = (int) $options[$number]['items'];
		if ( $options[$number]['items'] < 1 || 20 < $options[$number]['items'] ) {
			$options[$number]['items'] = 10;
		}
		if (!isset($options[$number]['showts'])) {
			$options[$number]['showts'] = 86400;
		}

		$options[$number]['hiderss'] = (isset($options[$number]['hiderss']) && $options[$number]['hiderss']);
		$options[$number]['avatar'] = (isset($options[$number]['avatar']) && $options[$number]['avatar']);
		*/

		// Set a default title if needed
		if (empty($options[$number]['title'])) {
			// Get our post title
			$options[$number]['title'] = get_post_field('post_title', $options[$number]['postid']);
		}
		//Make sure the size option is valid
		if (!in_array($options[$number]['size'], array('thumbnail', 'medium', 'full'))) {
			$options[$number]['size'] = 'thumbnail';
		}

		if (empty($options[$number]['orderby'])) {
			// Get our post title
			$options[$number]['orderby'] = 'menu_order ASC, ID ASC';
		} else {
			// We're trusting author input, so let's at least make sure it looks like a valid orderby statement
			$options[$number]['orderby'] = sanitize_sql_orderby($options[$number]['orderby']);
		}

		echo $before_widget;

		echo $before_title . $options[$number]['title'] . $after_title;
		$attachments = get_children("post_parent={$options[$number]['postid']}&post_type=attachment&post_mime_type=image&orderby={$options[$number]['orderby']}");

		if ( empty($attachments) )
			echo 'No Images';

		/**
		 * @todo allow the transition to be set as an option
		 */
		echo "<div class='crossfade'>";

		$first = true;
		foreach ( $attachments as $id => $attachment ) {
			$link = wp_get_attachment_link($id, $options[$number]['size'], true);
			$link_text = wp_get_attachment_image($id, $options[$number]['size'], $icon);
			$post_title = attribute_escape($attachment->post_title);
			$url = attribute_escape(get_post_meta($id, 'gallery_url', true));
			$link = "<a href='$url' title='$post_title'>$link_text</a>";

			$display = ($first)? '':' style="display:none;"';
			echo "<div class='gallery-widget-item'{$display}>";
			echo "<div class='gallery-widget-icon'>{$link}</div>";
			if ( trim($attachment->post_excerpt) ) {
				echo '<p class="gallery-widget-caption">' . htmlentities(trim($attachment->post_excerpt)) . '</p>';
			}
			echo "</div>";
			$first = false;
		}

		echo '</div>';
//		var_dump($post);

		echo $after_widget;
	}

	/**
	 * Sets up admin forms to manage widgets
	 *
	 * @param array|int $widget_args - Widget Number
	 */
	public function control($widget_args) {
		global $wp_registered_widgets;
		static $updated = false;

		if ( is_numeric($widget_args) )
			$widget_args = array( 'number' => $widget_args );
		$widget_args = wp_parse_args( $widget_args, array( 'number' => -1 ) );
		extract( $widget_args, EXTR_SKIP );

		$options = get_option('widget_gallery');
		if ( !is_array($options) )
			$options = array();

		if ( !$updated && !empty($_POST['sidebar']) ) {
			$sidebar = (string) $_POST['sidebar'];

			$sidebars_widgets = wp_get_sidebars_widgets();
			if ( isset($sidebars_widgets[$sidebar]) )
				$this_sidebar =& $sidebars_widgets[$sidebar];
			else
				$this_sidebar = array();

			foreach ( $this_sidebar as $_widget_id ) {
				if ( array($this,'display') == $wp_registered_widgets[$_widget_id]['callback'] && isset($wp_registered_widgets[$_widget_id]['params'][0]['number']) ) {
					$widget_number = $wp_registered_widgets[$_widget_id]['params'][0]['number'];
					if ( !in_array( "gallery-$widget_number", $_POST['widget-id'] ) ) // the widget has been removed.
						unset($options[$widget_number]);
				}
			}

			foreach ( (array) $_POST['widget-gallery'] as $widget_number => $widget_gallery ) {
				if ( !isset($widget_gallery['postid']) && isset($options[$widget_number]) ) // user clicked cancel
					continue;
				$widget_gallery['postid'] = intval($widget_gallery['postid']);
				$widget_gallery['title'] = strip_tags(stripslashes($widget_gallery['title']));
				$options[$widget_number] = $widget_gallery;
			}

			update_option('widget_gallery', $options);
			$updated = true;
		}

		if ( -1 != $number ) {
			$options[$number]['number'] = $number;
			$options[$number]['title'] = attribute_escape($options[$number]['title']);
			if (!isset($options[$number]['size']) || !in_array($options[$number]['size'], array('thumbnail', 'medium', 'full'))) {
				$options[$number]['size'] = 'thumbnail';
			}
			/*
			$options[$number]['username'] = attribute_escape($options[$number]['username']);
			$options[$number]['hiderss'] = (bool) $options[$number]['hiderss'];
			$options[$number]['avatar'] = (bool) $options[$number]['avatar'];
			if (!isset($options[$number]['feed']) || !in_array($options[$number]['feed'], array('user', 'friends'))) {
				$options[$number]['feed'] = 'user';
			}
			*/
		}
		$this->_showForm($options[$number]);
	}

	/**
	 * Registers widget in such a way as to allow multiple instances of it
	 *
	 * @see wp-includes/widgets.php
	 */
	public function register() {
		wp_enqueue_script(array('fastinit', 'crossfade', 'gallery-widget-pro'));
		if ( !$options = get_option('widget_gallery') )
			$options = array();
		$widget_ops = array('classname' => 'widget_gallery', 'description' => __('Slideshow of gallery images'));
		$control_ops = array('width' => 400, 'height' => 350, 'id_base' => 'gallery');
		$name = __('Gallery');

		$id = false;
		foreach ( array_keys($options) as $o ) {
			// Old widgets can have null values for some reason
			if ( !isset($options[$o]['postid']) )
				continue;
			$id = "gallery-$o"; // Never never never translate an id
			wp_register_sidebar_widget($id, $name, array($this,'display'), $widget_ops, array( 'number' => $o ));
			wp_register_widget_control($id, $name, array($this,'control'), $control_ops, array( 'number' => $o ));
		}

		// If there are none, we register the widget's existance with a generic template
		if ( !$id ) {
			wp_register_sidebar_widget( 'gallery-1', $name, array($this,'display'), $widget_ops, array( 'number' => -1 ) );
			wp_register_widget_control( 'gallery-1', $name, array($this,'control'), $control_ops, array( 'number' => -1 ) );
		}
	}

	/**
	 * Displays the actualy for that populates the widget options box in the
	 * admin section
	 *
	 * @param array $args - Current widget settings and widget number, gets combind with defaults
	 */
	private function _showForm($args) {
		if (empty($this->_posts)) {
			global $wpdb;
			$this->_posts = $wpdb->get_results("SELECT DISTINCT A.`ID`, A.`post_title`, A.`post_type` FROM `{$wpdb->prefix}posts` as A JOIN `{$wpdb->prefix}posts` as B ON A.`ID` = B.`post_parent` WHERE B.`post_type`='attachment' && A.`post_type` != 'attachment' ORDER BY `post_type` DESC, `post_title` ASC");
		}

		$defaultArgs = array(	'postid'	=> '',
								'title'		=> '',
								'size'		=> 'thumbnail',
								'orderby'	=> 'menu_order ASC, ID ASC',
								'number'	=> '%i%' );
		$args = wp_parse_args( $args, $defaultArgs );
		extract( $args );
?>
			<p>
				<label for="gallery-postid-<?php echo $number; ?>"><?php _e('Post:'); ?></label>
				<select class="widefat" id="gallery-postid-<?php echo $number; ?>" name="widget-gallery[<?php echo $number; ?>][postid]">
				<?php
				$type = '';
				foreach ($this->_posts as $p) {
					if ($type != $p->post_type) {
						if (!empty($type)) {
							echo "</optgroup>";
						}
						echo '<optgroup label="' . ucwords($p->post_type) . 's">';
						$type = $p->post_type;
					}
					echo "<option value='{$p->ID}'",selected($postid, $p->ID),">{$p->post_title}</option>";
				}
				echo "</optgroup>";
				?>
				</select>
			</p>
			<p>
				<label for="gallery-title-<?php echo $number; ?>"><?php _e('Title (optional):'); ?></label>
				<input class="widefat" id="gallery-title-<?php echo $number; ?>" name="widget-gallery[<?php echo $number; ?>][title]" type="text" value="<?php echo $title; ?>" />
			</p>
			<p>
				<label for="gallery-size-<?php echo $number; ?>"><?php _e('Size:'); ?></label>
				<select class="widefat" id="gallery-size-<?php echo $number; ?>" name="widget-gallery[<?php echo $number; ?>][size]">
					<option value="thumbnail"<?php selected($size, 'thumbnail');?>><?php _e('Thumbnail'); ?></option>
					<option value="medium"<?php selected($size, 'medium');?>><?php _e('Medium'); ?></option>
					<option value="full"<?php selected($size, 'full');?>><?php _e('Full Size'); ?></option>
				</select>
			</p>
			<p>
				<label for="gallery-orderby-<?php echo $number; ?>"><?php _e('Order By:'); ?></label>
				<select class="widefat" id="gallery-orderby-<?php echo $number; ?>" name="widget-gallery[<?php echo $number; ?>][orderby]">
					<option value="menu_order ASC, ID ASC"<?php selected($orderby, 'menu_order ASC, ID ASC');?>><?php _e('Menu Order (order you placed them in)'); ?></option>
					<option value="ID ASC"<?php selected($orderby, 'ID ASC');?>><?php _e('ID (in order they were uploaded)'); ?></option>
					<option value="post_title ASC"<?php selected($orderby, 'post_title ASC');?>><?php _e('Alphabetical by Title'); ?></option>
				</select>
			</p>
<?php
	}

	public function attachment_fields_to_edit($form_fields, $post) {
    	$form_fields['gallery_url'] = array(
			'label'      => __('Link for Gallery Widget:'),
			'value'      => get_post_meta($post->ID, 'gallery_url', true)
		);
    	return $form_fields;
    }
    public function attachment_fields_to_save($post, $attachment) {
		if (!add_post_meta($post['ID'], 'gallery_url', $attachment['gallery_url'], true)) {
			update_post_meta($post['ID'], 'gallery_url', $attachment['gallery_url']);
		}
    	return $post;
    }
}
// Instantiate our class
$wpGalleryWidget = new wpGalleryWidget();

/**
 * Add filters and actions
 */
add_action('widgets_init', array($wpGalleryWidget, 'register'));
add_filter('attachment_fields_to_edit', array($wpGalleryWidget, 'attachment_fields_to_edit'), null, 2);
add_filter('attachment_fields_to_save', array($wpGalleryWidget, 'attachment_fields_to_save'), null, 2);
