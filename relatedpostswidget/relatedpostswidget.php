<?php
/**
* Plugin Name: Related Post Widget
* Plugin URI:  http://google.com
* Description: Related Post Widget.
* Version:     0.1
* Author:      Joakim Malmberg
* Author       URI:
* License:     WTFPL
* License URI:
* Text Domain: relatedpostwidget
* Domain Path: /languages
* Network:
**/

require("class.relatedpostwidget.php");

function rlp_widgets_init() {
	register_widget('relatedpostwidget');
}

add_action('widgets_init', 'rlp_widgets_init');