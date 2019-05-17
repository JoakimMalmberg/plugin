<?php
/**
* Plugin Name: Facebook Footer Link
* Description: Adds a Facebook profile link to end of post
* Version:     0.1
* Author:      Joakim Malmberg
**/

//Exit if Accessed Directly
if(!defined('ABSPATH')){
	exit;
}

//Global Options Variable

$ffl_options = get_option('ffl_settings');

// Load Script
require_once(plugin_dir_path(__FILE__) . '/inc/facebook-footer-link-script.php');

// Load Content
require_once(plugin_dir_path(__FILE__) . '/inc/facebook-footer-link-content.php');

if(is_admin()){
	// Load Settings
	require_once(plugin_dir_path(__FILE__) . '/inc/facebook-footer-link-settings.php');
}