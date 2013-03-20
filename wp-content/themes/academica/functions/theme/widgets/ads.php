<?php 
class WPZOOM_Sidebar_Ads extends WP_Widget {
	function WPZOOM_Sidebar_Ads() {
		$widget_ops = array('classname' => 'wpzoom_ads_widget', 'description' => 'For adding Ad Units.' );
		$this->WP_Widget('wpzoom_ads', 'WPZOOM: Ads Widget', $widget_ops);
	}
 
	function widget($args, $instance) {
		extract($args, EXTR_SKIP);
 
		echo $before_widget;
		$title = empty($instance['title']) ? '&nbsp;' : apply_filters('widget_title', $instance['title']);
		$code = empty($instance['code']) ? '&nbsp;' : apply_filters('widget_code', $instance['code']);
 
		if ( !empty( $title ) ) { echo $before_title . $title . $after_title; };
		print($code);
		echo $after_widget;
	}
 
	function update($new_instance, $old_instance) {
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['code'] = $new_instance['code'];
		return $instance;
	}
 
	function form($instance) {
		$instance = wp_parse_args( (array) $instance, array( 'title' => '', 'code' => '') );
		$title = strip_tags($instance['title']);
		$code = $instance['code'];
?>
			<p><label for="<?php echo $this->get_field_id('title'); ?>">Title (optional):</label><input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo attribute_escape($title); ?>" /></p>
			<p><label for="<?php echo $this->get_field_id('code'); ?>">HTML/JS Code: </label><textarea class="widefat" id="<?php echo $this->get_field_id('code'); ?>" name="<?php echo $this->get_field_name('code'); ?>"><?php echo $code; ?></textarea></p>
<?php
	}
}
register_widget('WPZOOM_Sidebar_Ads');
?>