<?php
/*
	Plugin Name: Eventify - Simple Events.
	Plugin URI: http://designerfoo.com/wordpress-plugin-eventify-simple-events-management
Description: A plugin to store and show upcoming events in wordpress widgets/sidebar and/or create an event post. Note: If you uninstall/delete/upgrade the plugin the events scheduled will be lost! More info about <A href="http://designerfoo.com/wordpress-plugin-eventify-simple-events-management#contentstartshere">Desingerfoo & Eventify</a>. <a href="http://www.eventifypro.com" target="_blank">Subscribe</a>, to get an invite for the private beta. Thanks! <a href="http://www.facebook.com/eventifypro" target="_blank">Facebook Fan Page - (http://www.facebook.com/eventifypro)</a>
Version: 1.8.a
	Author: Manoj Sachwani [Designerfoo]
	Author URI: http://designerfoo.com
*/

/*  Copyright 2009-2010  Manoj Sachwani  (email : i@designerfoo.com)

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
	Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
	*/
// error_reporting(E_ALL); /*Notice marte salla*/

$subpage="";
	

if(!class_exists("EventifyLoader"))
{
	require_once(WP_PLUGIN_DIR.'/eventify/php/eventify.class.php');
	require_once(WP_PLUGIN_DIR.'/eventify/php/eventify.widget.php');
	require_once(WP_PLUGIN_DIR.'/eventify/php/eventify.addevent.widget.php');

	class EventifyLoader 
	{

		var $ar_eventify = "";
		var $ar_widget ="";
		var $ar_addeventwidget ="";

		function EventifyLoader()
		{
			if (class_exists("eventify")) 
			{ 
				$this->ar_eventify = new eventify(); 

			}  
			if(class_exists("eventifywidget"))
			{
				$this->ar_widget = new eventifywidget();
			
			}
			if(class_exists("eventifyaddeventwidget"))
			{
				$this->ar_addeventwidget = new eventifyaddeventwidget();
			}
			
		
		}


		function eventify_install()
		{
			global $wpdb;


			$table_name = $wpdb->prefix."em_main";
			
			if($wpdb->get_var("SHOW TABLES LIKE '$table_name'")!= $table_name){
			
				$sql  = "CREATE TABLE IF NOT EXISTS ".$table_name."(
					em_id int NOT NULL AUTO_INCREMENT  PRIMARY  KEY,
					em_date varchar(255) NOT NULL,
					em_time varchar(50) NOT NULL,
					em_desc text,
					em_title text NOT NULL,
					em_venue text,
					em_timezone varchar(255),
                                        em_savetype varchar(255) DEFAULT '0',
					em_timestamp BIGINT,
                                        em_repeats varchar(255) NOT NULL DEFAULT '0',
                                        em_repeats_type varchar(255) NOT NULL DEFAULT '0',
                                        em_repeats_untill text NOT NULL
			       	);";

				$wpdb->query($sql);
				
				
				//$wpdb->print_error();

				//require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
				//dbDelta($sql);

			}//ending the if to check the table exists
			
			if(!get_option("em_timezone"))
			{
			  add_option("em_timezone","none","","no");

			}
			if(!get_option("em_category_slug")) add_option("em_category_slug","eventify-events","","no");
		        if(!get_category_by_slug('eventify-events')) $eventify_category = wp_insert_category(array('cat_name'=>'Eventify Events','category_description'=>'','category_nicename'=>'eventify-events','category_parent'=>''));
		}//end of eventify_install 


		
		

		function eventify_uninstall()
		{
			global $wpdb;
			$table_name  = $wpdb->prefix."em_main";
			//echo $wpdb->get_var("SHOW TABLES LIKE '$table_name'");
			if($wpdb->get_var("SHOW TABLES LIKE '$table_name'") == $table_name)
			{	
			//	echo "something";
			$sql = "drop table ".$table_name;
			$wpdb->query($sql);
			$wpdb->print_error();
			}

			if(get_option("em_timezone"))
			{
				delete_option("em_timezone");

			}
			if(get_option("em_category_slug")) delete_option("em_category_slug");

		} 

		function load_widgets()
		{
				register_widget('eventifywidget');
				register_widget('eventifyaddeventwidget');
		}

		function load_plugin()
		{
				
			if(isset($this->ar_eventify))
			{
			
				register_activation_hook(__FILE__, array($this,'eventify_install'));

				add_action('admin_menu', array($this->ar_eventify, 'admin_menu'));

				if(isset($_GET['page']) && $_GET['page'] =="eventify/php/eventify.class.php") //very crude way of checking the page! admin_head doesn't work and couldn't find enough documentation to make it work.. still at it .. need to clean up redundancy code ...
				{
					add_action('admin_init', array($this->ar_eventify, 'remove_add_jquery'));
				}
				else
				{
					add_action('wp_print_scripts', array($this->ar_eventify,'add_js_css_theme')); //adding js/css for calendar, jquery, other js, for form, etc
				}

				add_action('wp_print_scripts', array($this->ar_eventify, 'add_custom_css'));
				
				add_action('widgets_init',array($this,'load_widgets'));
				
				
				add_shortcode('eventifytag', array($this->ar_eventify,'eventifytag_func'));
				add_shortcode('eventifyform',array($this->ar_eventify,'eventifyform_func'));
				add_shortcode('eventifycalbig', array($this->ar_eventify,'eventifycal_func'));
				add_action('wp_footer',array($this->ar_eventify,'add_mask_widget'));

				if ( function_exists('register_deactivation_hook') ){
					
					register_deactivation_hook(__FILE__, array($this,'eventify_uninstall'));}


				}//above if ends here
			}

		}//class eventify loader ends here

		
		
		
	}//if to check if the eventifyloader class exists
	global $eventifyloaded;
	$eventifyloaded = new EventifyLoader();
	$eventifyloaded->load_plugin();
