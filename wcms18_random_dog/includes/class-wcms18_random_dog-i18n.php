<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       m42.se
 * @since      1.0.0
 *
 * @package    Wcms18_random_dog
 * @subpackage Wcms18_random_dog/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Wcms18_random_dog
 * @subpackage Wcms18_random_dog/includes
 * @author     Joakim Malmberg <jmalmberg.web@gmail.com>
 */
class Wcms18_random_dog_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'wcms18_random_dog',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}
