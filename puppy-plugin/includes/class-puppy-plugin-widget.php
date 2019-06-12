
<?php
/**
 * Adds Puppy_Plugin_Widget widget.
 */
class Puppy_Plugin_Widget extends WP_Widget {
	/**
	 * Register widget with WordPress.
	 */
	public function __construct() {
		parent::__construct(
			'puppy-plugin-widget', // Base ID
			'Puppy Plugin', // Name
			[
				'description' => __('A Widget for displaying puppy plugin', 'puppy-plugin'),
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
		if (!(is_single() && get_post_type() === 'pp_dog')) {
			return;
		}

		extract($args);
		$title = apply_filters('widget_title', $instance['title']);
		
		// start widget
		echo $before_widget;

		// title
		if (! empty($title)) {
			echo $before_title . $title . $after_title;
		}

		$size = get_the_term_list(get_the_ID(), 'pp_dogsize', '<strong>Size:</strong> ');
		get_the_excerpt($size);

		// content
		if(get_post_type() === 'pp_dog'){

			if(function_exists('get_field')){

				$birthday = get_field('birthday');
				$height = get_field('height');
				$sex = get_field('sex');
				$weight = get_field('weight');

				$content .= '<div class="puppy-plugin">';
				
				if($birthday !== false){
					$content .= '<br><span><strong>Birthday:</strong> ' . $birthday . ' </span><br>';
				}
				if($height !== false){
					$content .= '<span><strong>Height:</strong> ' . $height . ' cm</span><br>';
				}
				if($sex !== false){
					$content .= '<span><strong>Sex:</strong> ' . $sex . ' </span><br>';
				}
				if($weight !== false){
					$content .= '<span><strong>Weight:</strong> ' . $weight . ' kg</span><br>';
				}
				if($size !== false){
					$content .= $size;
				}

				$content .= '</div>';
			}
		}
		echo $content;
		// close widget
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
			$title = get_option('default_title', __('Puppy Plugin', 'puppy-plugin'));
		}
		?>

		<!-- title -->
		<p>
			<label
				for="<?php echo $this->get_field_name('title'); ?>"
			>
				<?php _e('Title:', 'puppy-plugin-widget'); ?>
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
		return $instance;
	}
} // class Puppy Plugin