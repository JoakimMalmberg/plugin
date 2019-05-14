<?php
/**
* Plugin Name: My First Widget
* Plugin URI:  http://google.com
* Description: My first widget.
* Version:     0.1
* Author:      Joakim Malmberg
* Author       URI:
* License:     WTFPL
* License URI:
* Text Domain: myfirstwidget
* Domain Path: /languages
* Network:
**/

require("class.myfirstwidget.php");

function mfw_widgets_init() {
	register_widget('myfirstwidget');
}

add_action('widgets_init', 'mfw_widgets_init');