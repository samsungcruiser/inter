=== Jetpack Post Views ===
Contributors: straker503, topher1kenobe
Tags: jetpack, post views
Requires at least: 3.5
Tested up to: 3.5.1
Stable tag: 1.0.4
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

A plugin that displays your most popular posts using Jetpack stats.

== Description ==

A plugin that displays your most popular posts using Jetpack stats.

Jetpack Post Views is a plugin that lets you integrate Jetpack stats into your site. Jetpack is a great plugin that lets you track information about your blog, but it doesn’t give you access to this information so you can display it to your visitors. The most common information users wish to have access to are the number of views for a post.

Jetpack Post Views gives you access to this information. This plugin adds a widget that lets you display your top posts by views according to Jetpack stats. As an added bonus, this plugin adds this information to the post meta of each post, allowing you to display those stats anywhere on your site.

== Installation ==

1. Upload `jetpack-post-views.php` to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Upon activation, stats will be downloaded automatically and entered into the post meta for each post. **This process takes time!** Depending on how many posts you have, this can take up to 5 minutes, so be patient!

**NOTE:** If the plugin does not work, go to the settings page and try entering in your WordPress API Key.

To find your API key, log into https://apikey.wordpress.com/. Enter this key into the “WordPress API key” field in the Jetpack Post Views Settings page and click “Save Changes.”

To display the total views for a post anywhere on your site, just add the following code to your files (such as single.php):

`<?php echo get_post_meta( $post->ID, 'jetpack-post-views', true ); ?>`

Stats are updated hourly only if the plugin is active.

== Frequently asked questions ==

= How can I display the top posts in my template? =

Use the function 'JPV_display_top_posts()'

*Usage*
`<?php if ( function_exists('JPV_display_top_posts') ) { JPV_display_top_posts( $args ); } ?>`

*Default Usage*
`<?php $args = array( 
       	 'days'         => '-1',
         'limit'        => '5',
         'exclude'      => '',
         'displayViews' => false ); ?>`
*Parameters*

**days** - (*string*) The number of days of the desired time frame. '-1' means unlimited.

**limit** - (*string*) The number of posts to display. '-1' means unlimited. If days is -1, then limit is capped at 500.

**exclude** - (*string*) A comma-separated list of Post IDs to be excluded from displaying.

**displayViews** - (*boolean*) Displays the post views.

**NOTE** This function only works if the function `stats_get_csv()` exists. If this function is not working probably, it is probably due to the `stats_get_csv()` function not returning the needed results.

== Screenshots ==

1. Jetpack Post Views Widget options.
2. Jetpack Post Views Sidebar that displays top posts for the site.
3. Jetpack Post Views Sidebar with number of views displayed.
4. Jetpack Post Views settings page.

== Changelog ==

= 1.0.4 (2013-03-14) =
* Added the `JPV_display_top_posts()` function to display top posts in a template
* Added widget options to exclude posts by ID and to display a different time frame

= 1.0.3 (2013-02-10) =
* Plugin can now access Jetpack stats without needing a WordPress API Key first. (Special thanks to topher1kenobe for helping me with this)
* Added a settings page to help those unable to access stats normally enter in the needed information to access the stats via the Jetpack API

= 1.0.1 (2013-01-21) =
* Reduced number of API calls made
* Considerably sped up process of adding/updating post meta data to each post
* Added security to widget
* Added uninstall.php file

= 1.0.0 (2013-01-19) =
* Public beta released