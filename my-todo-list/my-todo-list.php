<?php
/**
* Plugin Name: My Todo List
* Description: Simple todo list plugin
* Version:     0.1
* Author:      Joakim Malmberg
**/

//Exit if Accessed Directly
if(!defined('ABSPATH')){
	exit;
}

// Load Scripts
require_once(plugin_dir_path(__FILE__) . '/inc/my-todo-list-scripts.php');

// Load Class
require_once(plugin_dir_path(__FILE__) . '/inc/my-todo-list-shortcodes.php');

if(is_admin()){
	//Load Custom Post Type
	require_once(plugin_dir_path(__FILE__) . '/inc/my-todo-list-cpt.php');
	//Load Custom Fields
	require_once(plugin_dir_path(__FILE__) . '/inc/my-todo-list-fields.php');
}