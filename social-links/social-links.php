<?php
/**
* Plugin Name: Social Links
* Description: Adds social icons
* Version:     0.1
* Author:      Joakim Malmberg
**/

//Exit if Accessed Directly
if(!defined('ABSPATH')){
	exit;
}

// Load Scripts
require_once(plugin_dir_path(__FILE__) . '/inc/social-links-scripts.php');

// Load Class
require_once(plugin_dir_path(__FILE__) . '/inc/social-links-class.php');


//Register Widget

function register_social_links(){
	register_widget('Social_Links_Widget');
}

add_action('widgets_init', 'register_social_links');