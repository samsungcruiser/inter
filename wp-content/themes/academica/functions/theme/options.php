<?php return array(

/* Theme Admin Menu */
"menu" => array(
	array("id"   => "1",
				"name" => "General"),

	array("id"   => "2",
				"name" => "Homepage"),

	array("id"   => "5",
				"name" => "Styling"),

	array("id"   => "7",
				"name" => "Banners")
),

/* Theme Admin Options */
"id1" => array(
	array("type" => "preheader",
				"name" => "Theme Settings"),

		array("name" => "Logo Image",
					"desc" => "Upload a custom logo image for your site, or you can specify an image URL directly.",
					"id"   => "misc_logo_path",
					"std"  => "",
					"type" => "upload"),

    array("name"  => "Display Site Tagline under Logo?",
          "desc"  => "Tagline can be changed in <a href='options-general.php' target='_blank'>General Settings</a>",
          "id"    => "logo_desc",
          "std"   => "on",
          "type"  => "checkbox"),

		array("name" => "Favicon URL",
					"desc" => "Upload a favicon image (16&times;16px).",
					"id"   => "misc_favicon",
					"std"  => "",
					"type" => "upload"),

		array("name" => "Custom Feed URL",
					"desc" => "Example: <strong>http://feeds.feedburner.com/wpzoom</strong>",
					"id"   => "misc_feedburner",
					"std"  => "",
					"type" => "text")
),

"id2" => array(
	array("type" => "preheader",
				"name" => "Slideshow Settings"),

		array("name" => "Show Slideshow on Homepage",
					"desc" => "Select if you want to show the jQuery slideshow on the homepage.",
					"id"   => "slideshow_show",
					"std"  => "off",
					"type" => "checkbox"),

		array("name" => "Homepage Slideshow Items",
					"desc" => "How many slides should be shown in the Slideshow on the Homepage?",
					"id"   => "slideshow_num",
					"std"  => "5",
					"type" => "text"),

		array("name"  => "Autoplay slider",
		          "desc"  => "Should the slider start rotating automatically?",
		          "id"    => "featured_rotate",
		          "std"   => "off",
		          "type"  => "checkbox"), 
	
		array("name"  => "Autoplay Interval",
		          "desc"  => "Select the interval (in miliseconds) at which the slider should change posts (if autoplay is enabled). Default: 5000 (5 seconds).",
		          "id"    => "featured_interval",
		          "std"   => "5000",
		          "type"  => "text"),

	array("type" => "preheader",
				"name" => "Static Content"),

		array("name" => "Show Static Page on Homepage",
					"desc" => "Select if you want to show the content of a static page on the homepage.",
					"id" => "homepage_static",
					"std" => "on",
					"type" => "checkbox"),

		array("name" => "Page to be Displayed on Homepage",
					"desc" => "Choose the page that should appear in the main block on the homepage.",
					"id" => "homepage_static_page",
					"std" => "",
					"type" => "select-page")
),

"id4" => array(
	array("type" => "preheader",
				"name" => "Social Profiles"),

		array("name" => '<img src="' . get_template_directory_uri() . '/images/icons/icon_twitter.png" style="vertical-align:middle"/> Twitter',
					"desc" => "Set the absolute path to your Twitter account page or leave blank to hide the Twitter icon. <br />Example: <strong>http://twitter.com/wpzoom</strong>",
					"id" => "misc_soc_twitter",
					"std" => "",
					"type" => "text"),

		array("name" => '<img src="' . get_template_directory_uri() . '/images/icons/icon_flickr.png" style="vertical-align:middle"/> Flickr',
					"desc" => "Set the absolute path to your Flickr account page or leave blank to hide the Flickr icon.",
					"id" => "misc_soc_flickr",
					"std" => "",
					"type" => "text"),

		array("name" => '<img src="' . get_template_directory_uri() . '/images/icons/icon_facebook.png" style="vertical-align:middle"/> Facebook',
					"desc" => "Set the absolute path to your Facebook account page or leave blank to hide the Facebook icon.",
					"id" => "misc_soc_facebook",
					"std" => "",
					"type" => "text"),

		array("name" => '<img src="' . get_template_directory_uri() . '/images/icons/icon_linkedin.png" style="vertical-align:middle"/> LinkedIn',
					"desc" => "Set the absolute path to your LinkedIn account page or leave blank to hide the LinkedIn icon.",
					"id" => "misc_soc_linkedin",
					"std" => "",
					"type" => "text"),

		array("name" => '<img src="' . get_template_directory_uri() . '/images/icons/icon_youtube.png" style="vertical-align:middle"/> YouTube',
					"desc" => "Set the absolute path to your YouTube account page or leave blank to hide the YouTube icon.",
					"id" => "misc_soc_youtube",
					"std" => "",
					"type" => "text"),

	array("type" => "preheader",
				"name" => "Previous Theme Custom Field"),   

		array("name" => "Previous Theme Used Custom Fields for Thumbnails",
					"desc" => "If selected then theme will use images added via custom fields for thumbnails.",
					"id"   => "cf_use",
					"std"  => "off",
					"type" => "checkbox"),

		array("name" => "Custom Field Name",
					"desc" => "<strong>Used only if you checked the option above.</strong>",
					"id"   => "cf_photo",
					"std"  => "image",
					"type" => "text")
),

"id5" => array(
    array("type"  => "preheader",
          "name"  => "Colors"),

    array("name"  => "Logo Color",
           "id"   => "logo_color",
           "type" => "color",
           "selector" => "#logo h1 a",
           "attr" => "color"),
   
    array("name"  => "Link Color",
           "id"   => "a_css_color",
           "type" => "color",
           "selector" => "a",
           "attr" => "color"),
           
    array("name"  => "Link Hover Color",
           "id"   => "ahover_css_color",
           "type" => "color",
           "selector" => "a:hover",
           "attr" => "color"),

    array("name"  => "Widget Title Color",
           "id"   => "widget_color",
           "type" => "color",
           "selector" => ".widget .heading",
           "attr" => "color"),
 

    array("type"  => "preheader",
          "name"  => "Fonts"),

    array("name" => "General Text Font Style", 
          "id" => "typo_body", 
          "type" => "typography", 
          "selector" => "body" ),

    array("name" => "Logo Text Style", 
          "id" => "typo_logo", 
          "type" => "typography", 
          "selector" => "#logo h1 a" ),

    array("name"  => "Individual Post Title Style",
           "id"   => "typo_individual_title",
           "type" => "typography",
           "selector" => ".single #content h1 a"),
 
     array("name"  => "Widget Title Style",
           "id"   => "typo_widget",
           "type" => "typography",
           "selector" => ".widget .heading"),

),

"id7" => array(
	array("type" => "preheader",
				"name" => "Content Area Ad"),

		array("name" => "Enable ad space in the content area?",
					"id"   => "ad_content_select",
					"std"  => "off",
					"type" => "checkbox"),

		array("name"    => "Ad Position",
					"desc"    => "Do you want to place the banner before the article&rsquo;s content or after?",
					"id"      => "ad_content_pos",
					"options" => array('Before content', 'After content'),
					"std"     => "After content",
					"type"    => "select"),

		array("name" => "HTML Code (Adsense)",
					"desc" => "Enter complete HTML code for your banner (or Adsense code) or upload an image below.",
					"id"   => "ad_content_code",
					"std"  => "",
					"type" => "textarea"),

		array("name" => "Upload your image",
					"desc" => "Upload a banner image or enter the URL of an existing image.<br/>Recommended size: <strong>468 &times; 60px</strong>",
					"id"   => "ad_content_imgpath",
					"std"  => "",
					"type" => "upload"),

		array("name" => "Destination URL",
					"desc" => "Enter the URL where this banner ad points to.",
					"id"   => "ad_content_imgurl",
					"type" => "text"),

		array("name" => "Banner Title",
					"desc" => "Enter the title for this banner which will be used for ALT tag.",
					"id"   => "ad_content_imgalt",
					"type" => "text")
)

/* end return */);