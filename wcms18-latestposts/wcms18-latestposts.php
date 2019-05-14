<?php
/**
* Plugin Name: WCMS 18 Latest Posts
* Plugin URI:  http://google.com
* Description: My second plugin.
* Version:     0.1
* Author:      Joakim Malmberg
* Author       URI:
* License:     WTFPL
* License URI:
* Text Domain: wcms18-latestposts
* Domain Path: /languages
* Network:
**/
function wlp_shortcode($atts){
	extract(shortcode_atts([
		'posts' => -1,
		'title' => 'Latest News'
	], $atts));

	$posts = new WP_Query([
		'showposts' => $posts,
		'orderby' => 'date',
		'order' => 'DESC'
	]);

	$output .= $title;

	$output .= '<ul>';

	if ($posts->have_posts()) :
		while ($posts->have_posts()) : $posts->the_post();
			$output .= '<li><a href="' . get_permalink().'">';
				$output .= get_the_title(); 
			$output .= '</a></li>';
			$output .= " By:" . get_the_author();
			$output .= " Posted:" . human_time_diff(get_the_time('U')) . ' ago';
			$output .= get_the_category_list() . '<br>';
		endwhile;
	endif;
	
	$output.= '</ul>';

	wp_reset_postdata();
	return $output;
}

function wlp_init() {
	add_shortcode('latestposts', 'wlp_shortcode');
}
add_action('init', 'wlp_init');


