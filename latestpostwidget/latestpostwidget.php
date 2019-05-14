<?php
/**
* Plugin Name: Latest Post Widget
* Plugin URI:  http://google.com
* Description: Latest Post Widget.
* Version:     0.1
* Author:      Joakim Malmberg
* Author       URI:
* License:     WTFPL
* License URI:
* Text Domain: latestpostwidget
* Domain Path: /languages
* Network:
**/

require("class.latestpostwidget.php");

function lp_widgets_init() {
	register_widget('latestpostwidget');
}

add_action('widgets_init', 'lp_widgets_init');