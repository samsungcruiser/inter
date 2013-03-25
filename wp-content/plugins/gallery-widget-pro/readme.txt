=== Gallery Widget Pro ===
Contributors: aaroncampbell
Donate link: https://www.paypal.com/cgi-bin/webscr?cmd=_xclick&business=paypal%40xavisys%2ecom&item_name=Gallery%20Widget%20Pro&no_shipping=0&no_note=1&tax=0&currency_code=USD&lc=US&bn=PP%2dDonationsBF&charset=UTF%2d8
Tags: gallery, widget, images, fade
Requires at least: 2.5.1
Tested up to: 2.5.1
Stable tag: 1.0.1

A widget that displays rotating images from a post's gallery in the sidebar of your site. Requires PHP5.

== Description ==

A widget that displays rotating images from a post's gallery in the sidebar of
your site.  You just specify the post or page, and it will cycle through all the
images from the gallery of that post or page.  you can have as many of them as
you want on your site simultaneously.  Requires PHP5.

In WordPress 2.6, another plugin of mine has been included into the CORE to
allow these to be reorder your images to make them display in whatever order you
prefer.  Until then, go get <a href="http://wordpress.org/extend/plugins/reorder-gallery/">Reorder Gallery</a>!

== Installation ==

1. Verify that you have PHP5, which is required for this plugin.
1. Upload the whole `gallery-widget-pro` directory to the `/wp-content/plugins/` directory
1. Activate the plugin through the 'Plugins' menu in WordPress

== Frequently Asked Questions ==

= How exactly do I use this? =

To use it, first create a post or page (I recommend post, less overhead) and upload the photos that you want in the slideshow.  When you look at the photos details; title will be the mouseover text on the image, caption will be the caption under the image, Gallery URL (not just URL) will be the location they go if they click that image.  You do NOT have to publish the post, just save it (so it doesn't have to actually show on your blog).  Then, in the admin section, go to Design->widgets.  On the right you can choose which sidebar you want to add the widget to, and click "show" to switch to it.    Then just click the "add" link on the "gallery" widget on the left, and it will add it to the list on the right.  Click "edit" on that new widget to see the options.  Choose the post that you just made from the dropdown box, and give it a title if you DON'T want to use the title of the post.  The just click the "Save Changes" button.

= Can I have use than one instance of this widget? =

Yes, Gallery Widget Pro employs the multi-widget pattern, which allows you to not only have more than one instance of this widget on your site, but even allows more than one instance of this widget in a single sidebar.

= How do I set where the user goes when they click the image? =

In the details of each image, set the Gallery URL (not the regular one, WordPress doesn't save the URL in that box).

= I see some order options, but I want them in the order I specify. =

If you choose the option for "Menu Order (order you placed them in)" it will display them in the order they are in the gallery tab in the media box of the post.  By default, this is the order you upload them in.  In WordPress 2.6, another plugin of mine has been included into the CORE to allow these to be reordered.  Until then, go get <a href="http://wordpress.org/extend/plugins/reorder-gallery/">Reorder Gallery</a>.