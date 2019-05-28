<?php
/**
* Plugin Name: Weather API Widget
* Description: Widget that shows weater from API.
* Version:     0.1
* Author:      Joakim Malmberg
* Author       URI:
* License:     WTFPL
* License URI:
* Text Domain: weatherwidget
* Domain Path: /languages
* Network:
**/

require("inc/class.WeatherWidget.php");
require("inc/wapi.php");

function waw_widgets_init() {
	register_widget('WeatherWidget');
}
add_action('widgets_init', 'waw_widgets_init');

//Adds css , js and ajax
function w18ww_enqueue_style(){
	wp_enqueue_style( 'weather', plugin_dir_url( __FILE__ ) . 'assets/css/style.css' );

	wp_enqueue_script( 'weather', plugin_dir_url( __FILE__ ) . 'assets/js/main.js', ['jquery'], false, true );

	wp_localize_script( 'weather', 'my_ajax_obj', [
		'ajax_url' => admin_url('admin-ajax.php'),
	]);
}
add_action('wp_enqueue_scripts', 'w18ww_enqueue_style');


//Respond to AJAX request fot 'get_current_weather'
function w18ww_ajax_get_current_weather(){
	$current_weather = wapi_get_weather('Lund', 'SE');
	
	wp_send_json($current_weather);
}
add_action('wp_ajax_get_current_weather', 'w18ww_ajax_get_current_weather');
add_action('wp_ajax_nopriv_get_current_weather', 'w18ww_ajax_get_current_weather');

