<?php

/**
 * Adds MyLatestPost widget.
 */

class LatestPostWidget extends WP_Widget {

	/**
	 * Register widget with WordPress.
	 */
	public function __construct() {
		parent::__construct(
			'latest_post_widget', // Base ID
			'Latest Post Widget', // Name
			[
				'description' => __('Latest Post Widget', 'latestpostwidget'),
			] // Args
		);
	}

	/**
	 * Front-end display of widget.
	 *
	 * @see WP_Widget::widget()
	 *
	 * @param array $args     Widget arguments.
	 * @param array $instance Saved values from database.
	 */
	public function widget($args, $instance) {
		extract(shortcode_atts([
			'posts' => -1,
		], $atts));

		$posts = new WP_Query([
			'posts_per_page' => $instance['posts'],
		]);

		if ($posts->have_posts()) :
			$output = '<ul>';
				while ($posts->have_posts()) : $posts->the_post();
					$output .= '<li><a href="' . get_permalink().'">';
						$output .= get_the_title(); 
					$output .= '</a></li>';
					if($instance['meta_data']) :
						$output .= " By:" . get_the_author();
						$output .= " Posted:" . human_time_diff(get_the_time('U')) . ' ago';
						$output .= get_the_category_list() . '<br>';
					endif;
				endwhile;
				wp_reset_postdata();
			$output.= '</ul>';
		endif;
		
		echo $output;
	}

	/**
	 * Back-end widget form.
	 *
	 * @see WP_Widget::form()
	 *
	 * @param array $instance Previously saved values from database.
	 */
	public function form($instance) {
		if (isset($instance['posts'])) {
			$posts = $instance['posts'];
		}
		else {
			$posts = __('posts', 'latestpostwidget');
		}

		?>

		<p>
			<label for="<?php echo $this->get_field_name('posts'); ?>">
				<?php _e('Posts:'); ?>
			</label>
			<input 
				class="widefat" id="<?php echo $this->get_field_id('posts'); ?>" 
				name="<?php echo $this->get_field_name('posts'); ?>" 
				type="number"
				min="1"
				value="<?php echo $posts; ?>"
			/>
		</p>
		
	<?php 

	}

	/**
	 * Sanitize widget form values as they are saved.
	 *
	 * @see WP_Widget::update()
	 *
	 * @param array $new_instance Values just sent to be saved.
	 * @param array $old_instance Previously saved values from database.
	 *
	 * @return array Updated safe values to be saved.
	 */
	public function update($new_instance, $old_instance) {
		$instance = [];

		$instance['posts'] = (!empty($new_instance['posts'])) && 
		(($new_instance['posts']) > 0)
		? strip_tags($new_instance['posts']) 
		: '';

		return $instance;
	}

} // class MyFirstWidget