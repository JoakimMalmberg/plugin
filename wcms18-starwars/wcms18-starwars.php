<?php
/**
* Plugin Name: Star Wars Widget
* Plugin URI:  http://google.com
* Description: Star Wars Widget.
* Version:     0.1
* Author:      Joakim Malmberg
* Author       URI:
* License:     WTFPL
* License URI:
* Text Domain: starwarswidget
* Domain Path: /languages
* Network:
**/

require("inc/class.StarWarsWidget.php");
require("inc/swapi.php");

function wsw_widgets_init() {
	register_widget('StarWarsWidget');
}

add_action('widgets_init', 'wsw_widgets_init');

//Adds css , js and ajax
function w18sw_enqueue_style(){
	wp_enqueue_style( 'starwars', plugin_dir_url( __FILE__ ) . 'assets/css/style.css' );

	wp_enqueue_script( 'starwars_js', plugin_dir_url( __FILE__ ) . 'assets/js/main.js', ['jquery'], false, true );

	wp_localize_script( 'starwars_js', 'get_sw_trivia', [
		'ajax_url' => admin_url('admin-ajax.php'),
	]);
}
add_action('wp_enqueue_scripts', 'w18sw_enqueue_style');


//Respond to AJAX request fot 'get_starwars'
function w18sw_ajax_get_starwars(){

	$films = swapi_get_films();
	
	wp_send_json($films);
}
add_action('wp_ajax_get_starwars', 'w18sw_ajax_get_starwars');
add_action('wp_ajax_nopriv_get_starwars', 'w18sw_ajax_get_starwars');