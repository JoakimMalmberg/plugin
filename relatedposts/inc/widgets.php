<?php

require("class.RelatedPostsWidget.php");

function wrp_shortcode($user_atts = [], $content = null, $tag = '') {
	return wrp_get_related_posts($user_atts, $content, $tag);
}

function wrp_widgets_init() {
	register_widget('RelatedPostsWidget');
}

add_action('widgets_init', 'wrp_widgets_init');