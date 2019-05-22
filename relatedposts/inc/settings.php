<?php

//Add our Settings Page
function wrp_add_settings_page_to_menu(){
	add_submenu_page(
		'options-general.php',
		'WCMS18 Related Posts Settings',
		'Related Posts', 'manage_options',
		'relatedposts',
		'wrp_settings_page'
	);
}

add_action('admin_menu', 'wrp_add_settings_page_to_menu');


// Render Settings page
function wrp_settings_page() {
	?>
		<div class="wrap">
			<h1><?php echo esc_html(get_admin_page_title()); ?></h1>

			<form method="post" action="options.php">
				<?php
					// Output security fields for the register settings
					settings_fields("wrp_general_options");

					// Output settings sections and their fields
					do_settings_sections("relatedposts");

					// Output save settings button
					submit_button();
				?>
			</form>
		</div>
	<?php
}

// Register all settings for our setting page
function wrp_settings_init(){
	/**
	 * Add sections section "General Options"
	 * 
	 */
	add_settings_section( 
		'wrp_general_options', 
		'General Options', 
		'wrp_general_options_section',
		'relatedposts',
	);

	/**
	 * Add settings fields to settings field "General Options" 
	 * 
	 * Default Title
	 */
	add_settings_field( 
		'wrp_default_title', 
		'Default Title', 
		'wrp_default_title_cb', 
		'relatedposts', 
		'wrp_general_options',
	);

	register_setting( 'wrp_general_options', 'wrp_default_title');

	/**
	 * Add settings fields to settings field "General Options"
	 */
	add_settings_field( 
		'wrp_add_to_posts', 
		'Add Realted Posts to all posts', 
		'wrp_add_to_posts_cb', 
		'relatedposts', 
		'wrp_general_options',
	);

	register_setting( 'wrp_general_options', 'wrp_add_to_posts');
}

add_action('admin_init', 'wrp_settings_init');

function wrp_general_options_section(){
	?>
		<p>This is section with settings</p>
	<?php
}

function wrp_default_title_cb(){
	?>
		<input 
			type="text" 
			name="wrp_default_title_cb" 
			id="wrp_default_title_cb"
			value="<?php echo get_option('wrp_default_title', 'Related Posts'); ?>"
		>
	<?php
}

function wrp_add_to_posts_cb(){
	?>
		<input 
			type="checkbox" 
			name="wrp_add_to_posts" 
			id="wrp_add_to_posts"
			value="1"
			<?php 
				checked(1, get_option('wrp_add_to_posts')); 
			?>
		>
	<?php
}