<?php

function wrp_init() {
	add_shortcode('related-posts', 'wrp_shortcode');
}

add_action('init', 'wrp_init');