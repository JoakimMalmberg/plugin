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

require("class.StarWarsWidget.php");
require("swapi.php");

function wsw_widgets_init() {
	register_widget('StarWarsWidget');
}

add_action('widgets_init', 'wsw_widgets_init');