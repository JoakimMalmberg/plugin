<?php

// Add Scripts
function ns_add_scripts(){
	wp_enqueue_style('ns-main-style', plugins_url().'/news/css/style.css');
	wp_enqueue_script('ns-main-script', plugins_url().'/news/js/main.js', ['jquery']);
}

add_action('wp_enqueue_scripts', 'ns_add_scripts');