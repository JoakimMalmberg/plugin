<?php
/**
* Plugin Name: Oneliners Widget
* Description: Widget that shows Oneliners.
* Version:     0.1
* Author:      Joakim Malmberg
* Author       URI:
* License:     WTFPL
* License URI:
* Text Domain: oneliners
* Domain Path: /languages
* Network:
**/

require("inc/class.OnelinerWidget.php");
require("inc/oneliners.php");

function ol_widgets_init() {
	register_widget('OnelinerWidget');
}
add_action('widgets_init', 'ol_widgets_init');

//Adds css , js and ajax
function ol_enqueue_style(){
	wp_enqueue_style( 'oneliners', plugin_dir_url( __FILE__ ) . 'assets/css/style.css' );

	wp_enqueue_script( 'oneliners_js', plugin_dir_url( __FILE__ ) . 'assets/js/main.js', ['jquery'], false, true );

	wp_localize_script( 'oneliners_js', 'ol_settings', [
		'ajax_url' => admin_url('admin-ajax.php'),
	]);
}
add_action('wp_enqueue_scripts', 'ol_enqueue_style');


function ol_ajax_get_oneliner(){
	global $oneliners;

	echo $oneliners[array_rand($oneliners)];

	wp_die();
}

add_action('wp_ajax_get_oneliner', 'ol_ajax_get_oneliner');
add_action('wp_ajax_nopriv_get_oneliner', 'ol_ajax_get_oneliner');
