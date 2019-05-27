<?php

function wrp_the_content($content) {
	if (is_single() && get_option('wrp_add_to_posts') == 1) {
		if (!has_shortcode($content, 'related-posts')) {
			$content .= wrp_get_related_posts();
		}
	}
	return $content;
}

add_filter('the_content', 'wrp_the_content');