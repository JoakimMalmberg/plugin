<?php

/**
 * Adds Weater widget.
 */

class OnelinerWidget extends WP_Widget {
	/**
	 * Register widget with WordPress.
	 */
	public function __construct() {
		parent::__construct(
			'oneliner-widget', // Base ID
			'Oneliner', // Name
			[
				'description' => __('A Widget for displaying some weather', 'oneliner-widget'),
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

		// start widget
		echo $before_widget;

		?>
			<div class="content">
				Loading a funny oneliner...
			</div>

		<?php
		
		echo $after_widget;
	}
}