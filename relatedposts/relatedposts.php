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
function rp_get_related_posts($user_atts = [], $content = null, $tag = ''){
	extract(shortcode_atts([
		'posts' => -1,
		'title' => 'Realted Posts',
		'category' => -1,
	], $atts));

	$current_post_id = get_the_ID();
	
	$categories_ids = wp_get_post_terms($current_post_id, 'category', ['fields' => 'ids']);

	$posts = new WP_Query([
		'showposts' => $posts,
		'post__not_in' => [$current_post_id],
		'category__in' => $categories_ids,
	]);

	if ($posts->have_posts()) :
		$output .= $title;
		$output .= '<ul>';
			while ($posts->have_posts()) : $posts->the_post();
				$output .= '<li><a href="' . get_permalink().'">';
					$output .= get_the_title(); 
				$output .= '</a></li>';
			endwhile;
			wp_reset_postdata();
		$output.= '</ul>';
	else :
		$output .= "No Related Posts";
	endif;
	
	return $output;
}


function rp_shortcode($user_atts = [], $content = null, $tag = ''){
	return rp_get_related_posts($user_atts, $content, $tag);
}

function rp_init() {

	add_shortcode('relatedposts', 'rp_shortcode');

}
add_action('init', 'rp_init');


function rp_the_content($content){
	if(is_single() && !has_shortcode($content, 'relatedposts')){
		$related_posts = rp_get_related_posts();
		$content = $content . $related_posts;
	}
	return $content;
}

add_filter('the_content', 'rp_the_content');