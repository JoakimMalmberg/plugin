<?php

class News_Widget extends WP_Widget {

	/**
	 * Sets up the widgets name etc
	 */
	public function __construct() {
		parent::__construct(
			'news_widget', // Base ID
			__( 'News Widget', 'ns_domain' ), // Name
			array( 'description' => __( 'News Letter', 'ns_domain' ), ) // Args
		);
	}

	/**
	 * Outputs the content of the widget
	 *
	 * @param array $args
	 * @param array $instance
	 */
	public function widget( $args, $instance ) {

		echo $args['before_widget'];

		echo $args['before_title'];
		if(!empty($instance['title'])){
			echo $instance['title'];
		}
		echo $args['after_title'];
		?>
			<div id="form-msg"></div>
			<form 
				id="subscriber-form" 
				method="post" 
				action="<?php echo plugins_url().'/news/inc/news-mailer.php'; ?>"
			>
				<div class="form-group">
					<label for="name">Name: </label><br>
					<input type="text" id="email" name="name" class="form-control">
				</div>
				<div class="form-group">
					<label for="email">Email: </label><br>
					<input type="text" id="email" name="email" class="form-control">
				</div>
				<br>
				<input type="hidden" name="recipient" value="<?php $instance['recipitent'] ?>">
				<input type="hidden" name="subject" value="<?php $instance['subject'] ?>">
				<input type="submit" class="btn btn-primary" name="subscriber-submit" value="Subscriber">
				<br><br>
			</form>

		<?php

		echo $args['after_widget'];
	}

	/**
	 * Outputs the options form on admin
	 *
	 * @param array $instance The widget options
	 */
	public function form( $instance ) {
		$title = !empty($instance['title']) ? $instance['title'] : __('News Subscriber', 'ns_domain');

		$recipient = $instance['recipient'];

		$subject = !empty($instance['subject']) ? $instance['subject'] : __('News Subject', 'ns_domain');
		?>
			<p>
				<label for="<?php echo $this->get_field_id('title'); ?>">
					<?php _e('Title: '); ?>
				</label><br>
				<input 
					type="text" 
					id="<?php echo $this->get_field_id('title'); ?>"
					name="<?php echo $this->get_field_name('title'); ?>"
					type="text"
					value="<?php echo esc_attr($title); ?>"
				>
			</p>
			<p>
				<label for="<?php echo $this->get_field_id('recipient'); ?>">
					<?php _e('Recipient: '); ?>
				</label><br>
				<input 
					type="text" 
					id="<?php echo $this->get_field_id('recipient'); ?>"
					name="<?php echo $this->get_field_name('recipient'); ?>"
					type="text"
					value="<?php echo esc_attr($recipient); ?>"
				>
			</p>
			<p>
				<label for="<?php echo $this->get_field_id('subject'); ?>">
					<?php _e('Subject: '); ?>
				</label><br>
				<input 
					type="text" 
					id="<?php echo $this->get_field_id('subject'); ?>"
					name="<?php echo $this->get_field_name('subject'); ?>"
					type="text"
					value="<?php echo esc_attr($subject); ?>"
				>
			</p>
		<?php
	}

	/**
	 * Processing widget options on save
	 *
	 * @param array $new_instance The new options
	 * @param array $old_instance The previous options
	 *
	 * @return array
	 */
	public function update( $new_instance, $old_instance ) {
		// processes widget options to be saved
		$instance = [
			//Links
			'title' => (!empty($new_instance['title'])) ? strip_tags($new_instance['title']) : '',
			'recipient' => (!empty($new_instance['recipient'])) ? strip_tags($new_instance['recipient']) : '',
			'subject' => (!empty($new_instance['subject'])) ? strip_tags($new_instance['subject']) : '',
		];
		return $instance;
	}


	/**
	 * Gets and Displays Form
	 *
	 * @param array $instance The widget options
	 */
	public function getForm( $instance ) {

	}
}