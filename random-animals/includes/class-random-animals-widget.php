<?php

/**
 * Adds Random_Animals_Widget widget.
 */

class Random_Animals_Widget extends WP_Widget {
	/**
	 * Register widget with WordPress.
	 */
	public function __construct() {
		parent::__construct(
			'random-animals', // Base ID
			'Random Animals', // Name
			[
				'description' => __('A Widget for displaying a random animals', 'random-animals'),
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
		extract($args);
		$title = apply_filters('widget_title', $instance['title']);
		$animal = apply_filters('widget_animal', $instance['animal']);

		// start widget
		echo $before_widget;

		// title
		if (!empty($title)) {
			echo $before_title . $title . $after_title;
		}

		?>
			<div class="content" data-animal="<?php echo $animal; ?>">
				<span class="loading">Loading...</span>
			</div>

		<?php

		echo $after_widget;
	}

	/**
	 * Back-end widget form.
	 *
	 * @see WP_Widget::form()
	 *
	 * @param array $instance Previously saved values from database.
	 */
	public function form($instance) {
		if (isset($instance['title'])) {
			$title = $instance['title'];
		} else {
			$title = __('Random Animals', 'random-animals');
		}

		$animal = isset($instance['animal']) ? $instance['animal'] : 'dog';


		?>
		<!-- title -->
		<p>
			<label for="<?php echo $this->get_field_name('title'); ?>">
				<?php _e('Title:'); ?>
			</label>

			<input 
				class="widefat" 
				id="<?php echo $this->get_field_id('title'); ?>" 
				name="<?php echo $this->get_field_name('title'); ?>" 
				type="text" 
				value="<?php echo esc_attr($title); ?>" 
			/>
		</p>
		<!-- /title -->
		<!-- animal -->
		<p>
		
			<label for="<?php echo $this->get_field_name('animal'); ?>">
				<?php _e('Animal Image: (dog, cat, panda, red_panda, birb, fox or koala)'); ?>
			</label>

			<input 
				class="widefat" 
				id="<?php echo $this->get_field_id('animal'); ?>" 
				name="<?php echo $this->get_field_name('animal'); ?>" 
				type="text" 
				value="<?php echo esc_attr($animal); ?>" 
			/>
		<!-- /animal -->


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

		$instance['title'] = (!empty($new_instance['title']))
			? strip_tags($new_instance['title'])
			: '';
			
		$instance['animal'] = (!empty($new_instance['animal']))
			? strip_tags($new_instance['animal'])
			: '';

		return $instance;
	}
} // class Random_Animals_Widget