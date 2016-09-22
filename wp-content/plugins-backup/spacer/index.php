<?php

/*
Plugin Name: Spacer
Description: Adds a spacer button to the WYSIWYG visual editor which allows you to add precise custom spacing between lines in your posts and pages.
Version: 1.0
Author: Justin Saad
Author URI: http://www.clevelandwebdeveloper.com
License: GPL2
*/


//begin wysiwyg visual editor custom button plugin

class motech_spacer {

	public function __construct() {
		//do when class is instantiated	
		add_shortcode('spacer', array($this, 'addShortcodeHandler'));
		add_filter( 'tiny_mce_version', array($this, 'my_refresh_mce'));
		
		//plugin row links
		add_filter( 'plugin_row_meta', array($this,'plugin_row_links'), 10, 2 );
	}

	// add the shortcode handler 
	function addShortcodeHandler($atts, $content = null) {
			extract(shortcode_atts(array( "height" => '' ), $atts));
			if ($height > 0 ) {
				$spacer_css = "padding-top: " . $height . ";";
			} elseif($height < 0) {
				$spacer_css = "margin-top: " . $height . ";";
			}
			return '<span style="display:block;clear:both;height: 0px;'.$spacer_css.'"></span>';
	}
	
	
	function add_custom_button() {
	   if ( ! current_user_can('edit_posts') && ! current_user_can('edit_pages') )
		 return;
	   if ( get_user_option('rich_editing') == 'true') {
		 add_filter('mce_external_plugins', array($this, 'add_custom_tinymce_plugin'));
		 add_filter('mce_buttons', array($this, 'register_custom_button'));
	   }
	}
	
	function register_custom_button($buttons) {
	   array_push($buttons, "|", get_class($this));
	   return $buttons;
	}
	
	function add_custom_tinymce_plugin($plugin_array) {
	   //use this in a plugin
	   $plugin_array[get_class($this)] = plugins_url( 'editor_plugin.js' , __FILE__ );
	   //use this in a theme
	   //$plugin_array[get_class($this)] = get_bloginfo('template_url').'/editor_plugin.js';
	   return $plugin_array;
	}
	
	function my_refresh_mce($ver) {
	  $ver += 5;
	  return $ver;
	}
	
	function plugin_row_links($links, $file) {
		$plugin = plugin_basename(__FILE__); 
		if ($file == $plugin) // only for this plugin
				return array_merge( $links,
			array( '<a target="_blank" href="http://www.linkedin.com/in/ClevelandWebDeveloper/">' . __('Find me on LinkedIn' ) . '</a>' ),
			array( '<a target="_blank" href="http://twitter.com/ClevelandWebDev">' . __('Follow me on Twitter') . '</a>' )
		);
		return $links;
	}
	

} //end class

$class = new motech_spacer();

add_action('init', array($class, 'add_custom_button')); 