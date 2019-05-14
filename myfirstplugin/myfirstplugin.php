<?php
/**
* Plugin Name: My First Plugin
* Plugin URI:  http://google.com
* Description: My first plugin.
* Version:     0.1
* Author:      Joakim Malmberg
* Author       URI:
* License:     WTFPL
* License URI:
* Text Domain: myfirstplugin
* Domain Path: /languages
* Network:
**/

function mfp_myfirstshortcode() {
	return "TEST!";
}


function mfp_init() {
	add_shortcode('myfirstshortcode', 'mfp_myfirstshortcode');
	
	add_shortcode('mysecondshortcode', function() {
		return "TEST2!";
	});
}
add_action('init', 'mfp_init');
