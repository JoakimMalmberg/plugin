<?php
/**
* Plugin Name: My Github Repos
* Description: Display user repos in widget
* Version:     0.1
* Author:      Joakim Malmberg
**/

//Exit if Accessed Directly
if(!defined('ABSPATH')){
	exit;
}

// Load Scripts
require_once(plugin_dir_path(__FILE__) . '/inc/my-github-repos-scripts.php');

// Load Class
require_once(plugin_dir_path(__FILE__) . '/inc/my-github-repos-class.php');


//Register Widget
function mgr_register_widget(){
	register_widget('WP_MY_Github_Repos');
}
add_action('widgets_init', 'mgr_register_widget');