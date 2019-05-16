<?php
/**
* Plugin Name: WCMS 18 Realted Posts
* Plugin URI:  http://google.com
* Description: My second plugin.
* Version:     0.1
* Author:      Joakim Malmberg
* Author       URI:
* License:     WTFPL
* License URI:
* Text Domain: wcms18-realatedposts
* Domain Path: /languages
* Network:
**/
function rp_shortcode($atts){
	extract(shortcode_atts([
		'posts' => -1,
		'title' => 'Realted Posts'
	], $atts));

	$current_post_id = get_the_ID();
	// $current_post_categories = get_the_category();
	// $categories_ids = [];

	// foreach($current_post_categories as $current_post_category){
	// 	array_push($categories_ids, $current_post_category->$term_id);
	// }
	
	$categories_ids = wp_get_post_terms($current_post_id, 'category', ['fields' => 'ids']);

	$posts = new WP_Query([
		'showposts' => $posts,
		'post__not_in' => [$current_post_id],
		'category__in' => $categories_ids,
	]);

	$output .= $title;

	$output .= '<ul>';
	if ($posts->have_posts()) :
		while ($posts->have_posts()) : $posts->the_post();
			$output .= '<li><a href="' . get_permalink().'">';
				$output .= get_the_title(); 
			$output .= '</a></li>';
			// $output .= " By:" . get_the_author();
			// $output .= " Posted:" . human_time_diff(get_the_time('U')) . ' ago';
			// $output .= get_the_category_list() . '<br>';
		endwhile;
	endif;
	
	$output.= '</ul>';

	wp_reset_postdata();
	return $output;
}

function rp_init() {
	add_shortcode('relatedposts', 'rp_shortcode');
}
add_action('init', 'rp_init');


