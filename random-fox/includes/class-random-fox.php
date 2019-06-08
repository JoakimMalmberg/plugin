<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       m42.se
 * @since      1.0.0
 *
 * @package    Random_Fox
 * @subpackage Random_Fox/includes
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    Random_Fox
 * @subpackage Random_Fox/includes
 * @author     Joakim Malmberg <jmalmberg.web@gmail.com>
 */
class Random_Fox {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      Random_Fox_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $plugin_name    The string used to uniquely identify this plugin.
	 */
	protected $plugin_name;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $version;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {
		if ( defined( 'RANDOM_FOX_VERSION' ) ) {
			$this->version = RANDOM_FOX_VERSION;
		} else {
			$this->version = '1.0.0';
		}
		$this->plugin_name = 'random-fox';

		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();
		$this->define_public_hooks();
		
		// register widget
		$this->register_widget();
		
		// register ajax actions
		$this->register_ajax_actions();

	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - Random_Fox_Loader. Orchestrates the hooks of the plugin.
	 * - Random_Fox_i18n. Defines internationalization functionality.
	 * - Random_Fox_Admin. Defines all hooks for the admin area.
	 * - Random_Fox_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_dependencies() {

		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-random-fox-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-random-fox-i18n.php';
		
		/**
		 * The class responsible for the widget.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-random-fox-widget.php';
		
		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-random-fox-admin.php';

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-random-fox-public.php';

		$this->loader = new Random_Fox_Loader();

	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the Random_Fox_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale() {

		$plugin_i18n = new Random_Fox_i18n();

		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );

	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_admin_hooks() {

		$plugin_admin = new Random_Fox_Admin( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );

	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_public_hooks() {

		$plugin_public = new Random_Fox_Public( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );

	}

	/**
	 * Register the widget.
	 *
	 * @since    1.0.0
	 */
	public function register_widget() {
		add_action('widgets_init', function(){
			register_widget('Random_Fox_Widget');
		});
	}
	
	/**
	 * Register ajax actions
	 *
	 * @since    1.0.0
	 */
	public function register_ajax_actions() {
		//Register action 'random_fox__get'
		add_action('wp_ajax_random_fox__get', [$this, 'ajax_random_fox__get']);
		add_action('wp_ajax_nopriv_random_fox__get', [$this, 'ajax_random_fox__get']);
	}
	
	/**
	 * Respond to ajax action 'ajax_random_fox__get'
	 *
	 * @since    1.0.0
	 */
	public function ajax_random_fox__get() {
		//Get random fox image
		$response_image = wp_remote_get('https://randomfox.ca/floof/');
		if(is_wp_error( $response_image ) || wp_remote_retrieve_response_code( $response_image ) != 200){
			wp_send_json_error([
				'error_code' => wp_remote_retrieve_response_code( $response_image ),
				'error_msg' => wp_remote_retrieve_response_message( $response_image ),
			]);
		}
		$content_image = json_decode(wp_remote_retrieve_body( $response_image ));

		//Get random fox fact
		$response_fact = wp_remote_get('https://some-random-api.ml/facts/fox');
		if(is_wp_error( $response_fact ) || wp_remote_retrieve_response_code( $response_fact ) != 200){
			wp_send_json_error([
				'error_code' => wp_remote_retrieve_response_code( $response_fact ),
				'error_msg' => wp_remote_retrieve_response_message( $response_fact ),
			]);
		}
		$content_fact = json_decode(wp_remote_retrieve_body( $response_fact ));


		wp_send_json_success([
			'image' => $content_image->image,
			'fact' => $content_fact->fact
		]);
	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function run() {
		$this->loader->run();
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     1.0.0
	 * @return    string    The name of the plugin.
	 */
	public function get_plugin_name() {
		return $this->plugin_name;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.0
	 * @return    Random_Fox_Loader    Orchestrates the hooks of the plugin.
	 */
	public function get_loader() {
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function get_version() {
		return $this->version;
	}

}
