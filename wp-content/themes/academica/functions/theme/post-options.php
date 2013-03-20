<?php 

add_action('admin_menu', 'wpzoom_options_box');

function wpzoom_options_box() {
add_meta_box('wpzoom_post_layout', 'Post Layout', 'wpzoom_post_layout_options', 'post', 'normal', 'high');
add_meta_box('wpzoom_slideshow_template', 'Slide Options', 'wpzoom_slideshow_info', 'slideshow', 'side', 'high');
add_meta_box('wpzoom_faq_excerpt', 'Important Notices', 'wpzoom_faq_excerpt_completed', 'slideshow', 'side', 'high');
}

function wpzoom_slideshow_info() {
global $post;
?>
<fieldset>
<div>
<p>
<label for="wpzoom_slide_url" >Slide Link:</label><br />
<textarea style="height: 80px; width: 250px;" name="wpzoom_slide_url" id="wpzoom_slide_url"><?php echo get_post_meta($post->ID, 'wpzoom_slide_url', true); ?></textarea>
<br />
</p>
</div>
</fieldset>
<?php
}

function wpzoom_faq_excerpt_completed() {
  global $post;
  $custom = get_post_custom($post->ID);
  $faq_excerpt_completed = $custom["faq_excerpt_completed"][0];
  ?>
    <p>If you get a <strong>404 Error</strong> when trying to view a post from slideshow, simply access <a href='options-permalinks.php' target='_blank'>Permalinks</a> section, and this will fix the problem.<br/><br/>
    <em>Example of call-to-action button:</em> <br /><br /><code><?php print(htmlentities('<a class="button" href="your-url"><span></span>Learn More</a>')); ?></code></p>
  <?php
}

function wpzoom_post_layout_options() {
	global $post;
	$postLayouts = array('side-both' => 'Sidebars on both sides (Default)', 'side-right' => 'Sidebar on the right', 'side-left' => 'Sidebar on the left', 'full' => 'Full Width');
	?>

	<style>
	.RadioClass { display: none; }
	.RadioLabelClass { margin-right: 10px; }
	img.layout-select { border: solid 4px #c0cdd6; border-radius: 5px; }
	.RadioSelected img.layout-select { border: solid 4px #3173b2; }

 	#wpzoom_post_embed_code { font-size: 20px; }
	#wpzoom_post_embed_code { color: #444444; font-size: 11px; margin: 3px 0 10px; padding: 5px; font-family: Consolas,Monaco,Courier,monospace; }
	.wpzoom_post_embed_code { background: #F4F4F4; color: #444444; font-size: 11px; margin: 3px 0 0; padding: 5px; font-family: Consolas,Monaco,Courier,monospace; }
	.wpz_video { background: url(images/media-button-video.gif) no-repeat; padding: 0 0 0 18px; }
	.wpz_list { font-size: 11px; }
	.wpz_self_input { border: 1px solid #DFDFDF; border-radius: 4px 4px 4px 4px; width: 230px; color: #444444; }
	.wpz_border { border-bottom: 1px solid #EEEEEE; padding: 0 0 10px; }
 
 	</style>

	<script type="text/javascript">  
		jQuery(document).ready( function($) {
			$(".RadioClass").change(function(){  
			    if($(this).is(":checked")){  
			        $(".RadioSelected:not(:checked)").removeClass("RadioSelected");  
			        $(this).next("label").addClass("RadioSelected");  
			    }  
			}).triggerHandler("change");
 		});  
  	</script>
  
	<fieldset>
		<div>
 			<p>
 			<?php
			$dbval = trim(get_post_meta($post->ID, 'wpzoom_post_template', true));
			$curval = !empty($dbval) ? $dbval : 'side-both';
			foreach ($postLayouts as $key => $value)
			{
				?>
				<input id="<?php echo $key; ?>" type="radio" class="RadioClass" name="wpzoom_post_template" value="<?php echo $key; ?>"<?php if ($curval == $key) { echo' checked="checked"'; } ?> />
				<label for="<?php echo $key; ?>" class="RadioLabelClass<?php if (get_post_meta($post->ID, 'wpzoom_post_template', true) == $key) { echo' RadioSelected"'; } ?>">
				<img src="<?php echo wpzoom::$wpzoomPath; ?>/assets/images/layout-<?php echo $key; ?>.png" alt="<?php echo $value; ?>" title="<?php echo $value; ?>" class="layout-select" /></label>
			<?php
			} 
			?>
 			</p>
   		</div>
	</fieldset>
	<?php
}

add_action('save_post', 'custom_add_save');

function custom_add_save($postID){
// called after a post or page is saved
if($parent_id = wp_is_post_revision($postID))
{
  $postID = $parent_id;
}

if ($_POST['save'] || $_POST['publish']) {
  update_custom_meta($postID, $_POST['wpzoom_slide_url'], 'wpzoom_slide_url');
	update_custom_meta($postID, $_POST['faq_excerpt_completed'], 'faq_excerpt_completed');
}
if ($_POST['wpzoom_post_template']) {
	update_custom_meta($postID, $_POST['wpzoom_post_template'], 'wpzoom_post_template');
}
}

function update_custom_meta($postID, $newvalue, $field_name) {
// To create new meta
if(!get_post_meta($postID, $field_name)){
add_post_meta($postID, $field_name, $newvalue);
}else{
// or to update existing meta
update_post_meta($postID, $field_name, $newvalue);
}
}

?>