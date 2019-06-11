
<?php
/**
 * Adds Wcms18_Year_Book_Widget widget.
 */
class Wcms18_Year_Book_Widget extends WP_Widget {
	/**
	 * Register widget with WordPress.
	 */
	public function __construct() {
		parent::__construct(
			'wcms18-year-book-widget', // Base ID
			'WCMS18 Year Book', // Name
			[
				'description' => __('A Widget for displaying related posts year book', 'wcms18-year-book'),
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
		if (!(is_single() && get_post_type() === 'w18yb_student')) {
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

		// content
		if(get_post_type() === 'w18yb_student'){

			$courses = get_the_term_list(get_the_ID(), 'w18yb_course', '<h2>Courses</h2>', '<br>');
			$content .= '<div class="w18yb-courses">' . $courses . '</div>';

			if(function_exists('get_field')){

				$attendance = get_field('attendance');
				$detention_hours = get_field('detention_hours');

				$content .= '<div class="student-details">';
				$content .= '<h2>Student Details</h2>';
				
				if($attendance !== false){
					$content .= '<span><strong>Attendance:</strong> ' . $attendance . ' %</span><br>';
				}
				if($detention_hours !== false){
					$content .= '<span><strong>Detention:</strong> ' . $detention_hours . ' hours</span>';
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
			$title = get_option('default_title', __('Year Book', 'wcms18-year-book'));
		}
		?>

		<!-- title -->
		<p>
			<label
				for="<?php echo $this->get_field_name('title'); ?>"
			>
				<?php _e('Title:', 'wcms18-year-book-widget'); ?>
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
} // class Wcms18_Year_Book_Widget