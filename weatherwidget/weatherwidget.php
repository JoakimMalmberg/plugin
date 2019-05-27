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

require("class.WeatherWidget.php");
require("wapi.php");


function ww_widgets_init() {
	register_widget('WeatherWidget');
}

add_action('widgets_init', 'ww_widgets_init');