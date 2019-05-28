<?php
/**
* Plugin Name: News
* Description: News Letter
* Version:     0.1
* Author:      Joakim Malmberg
**/

//Exit if Accessed Directly
if(!defined('ABSPATH')){
	exit;
}

// Load Scripts
require_once(plugin_dir_path(__FILE__) . '/inc/news-scripts.php');

// Load Class
require_once(plugin_dir_path(__FILE__) . '/inc/news-class.php');


//Register Widget
function register_news(){
	register_widget('News_Widget');
}
add_action('widgets_init', 'register_news');