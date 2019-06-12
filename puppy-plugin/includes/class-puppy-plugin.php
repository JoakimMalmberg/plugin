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
 * @package    Puppy_Plugin
 * @subpackage Puppy_Plugin/includes
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
 * @package    Puppy_Plugin
 * @subpackage Puppy_Plugin/includes
 * @author     Joakim Malmberg <jmalmberg.web@gmail.com>
 */
class Puppy_Plugin {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      Puppy_Plugin_Loader    $loader    Maintains and registers all hooks for the plugin.
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
		if ( defined( 'PUPPY_PLUGIN_VERSION' ) ) {
			$this->version = PUPPY_PLUGIN_VERSION;
		} else {
			$this->version = '1.0.0';
		}
		$this->plugin_name = 'puppy-plugin';

		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();
		$this->define_public_hooks();

		// register widget
		$this->register_widget();

		$this->add_action_init();
		$this->filter_the_excerpt();
	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - Puppy_Plugin_Loader. Orchestrates the hooks of the plugin.
	 * - Puppy_Plugin_i18n. Defines internationalization functionality.
	 * - Puppy_Plugin_Admin. Defines all hooks for the admin area.
	 * - Puppy_Plugin_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_dependencies() {
		/**
		 * Custom fields
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/acf/acf.php';

		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-puppy-plugin-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-puppy-plugin-i18n.php';

		/**
		 * The class responsible for the widget.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-puppy-plugin-widget.php';
		

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-puppy-plugin-admin.php';

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-puppy-plugin-public.php';

		$this->loader = new Puppy_Plugin_Loader();

	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the Puppy_Plugin_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale() {

		$plugin_i18n = new Puppy_Plugin_i18n();

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

		$plugin_admin = new Puppy_Plugin_Admin( $this->get_plugin_name(), $this->get_version() );

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

		$plugin_public = new Puppy_Plugin_Public( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );

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
	 * @return    Puppy_Plugin_Loader    Orchestrates the hooks of the plugin.
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

	/**
	 * Register the widget.
	 *
	 * @since    1.0.0
	 */
	public function register_widget() {
		add_action('widgets_init', function(){
			register_widget('Puppy_Plugin_Widget');
		});
	}

	/**
	 * Add function init hook
	 *
	 * @since    1.0.0
	 */
	public function add_action_init() {
		//CPT
		add_action('init', [$this, 'register_cpts']);
		//CT
		add_action( 'init', [$this, 'register_cts'] );
		//ACF
		add_action( 'init', [$this, 'register_acf'] );
	}

	/**
	 * Register Custom Post Types
	 *
	 * @since    1.0.0
	 */
	public function register_cpts() {

		/**
		 * Post Type: PP Dogs.
		 */

		$labels = array(
			"name" => __( "PP Dogs", "hestia" ),
			"singular_name" => __( "PP Dog", "hestia" ),
		);

		$args = array(
			"label" => __( "PP Dogs", "hestia" ),
			"labels" => $labels,
			"description" => "",
			"public" => true,
			"publicly_queryable" => true,
			"show_ui" => true,
			"delete_with_user" => false,
			"show_in_rest" => true,
			"rest_base" => "",
			"rest_controller_class" => "WP_REST_Posts_Controller",
			"has_archive" => true,
			"show_in_menu" => true,
			"show_in_nav_menus" => true,
			"exclude_from_search" => false,
			"capability_type" => "post",
			"map_meta_cap" => true,
			"hierarchical" => true,
			"rewrite" => array( "slug" => "pp_dog", "with_front" => true ),
			"query_var" => true,
			"supports" => array( "title", "editor", "thumbnail", "excerpt" ),
		);
		register_post_type( "pp_dog", $args );
	}

	/**
	 * Register cts
	 *
	 * @since    1.0.0
	 */
	public function register_cts() {
		/**
		 * Taxonomy: PP Dogsizes.
		 */

		$labels = array(
			"name" => __( "PP Dogsizes", "hestia" ),
			"singular_name" => __( "PP Dogsize", "hestia" ),
		);

		$args = array(
			"label" => __( "PP Dogsizes", "hestia" ),
			"labels" => $labels,
			"public" => true,
			"publicly_queryable" => true,
			"hierarchical" => false,
			"show_ui" => true,
			"show_in_menu" => true,
			"show_in_nav_menus" => true,
			"query_var" => true,
			"rewrite" => array( 'slug' => 'pp_dogsize', 'with_front' => true, ),
			"show_admin_column" => false,
			"show_in_rest" => true,
			"rest_base" => "pp_dogsize",
			"rest_controller_class" => "WP_REST_Terms_Controller",
			"show_in_quick_edit" => false,
			);
		register_taxonomy( "pp_dogsize", array( "pp_dog" ), $args );
	}

	/**
	 * Register Advanced Custom Fields
	 *
	 * @since    1.0.0
	 */
	public function register_acf() {
		if( function_exists('acf_add_local_field_group') ):

		acf_add_local_field_group(array(
			'key' => 'group_5d00e27d0eff9',
			'title' => 'Dog Details',
			'fields' => array(
				array(
					'key' => 'field_5d00e28b00eca',
					'label' => 'Birthday',
					'name' => 'birthday',
					'type' => 'date_picker',
					'instructions' => '',
					'required' => 0,
					'conditional_logic' => 0,
					'wrapper' => array(
						'width' => '',
						'class' => '',
						'id' => '',
					),
					'display_format' => 'Y-m-d',
					'return_format' => 'Y-m-d',
					'first_day' => 1,
				),
				array(
					'key' => 'field_5d00e2cb00ecb',
					'label' => 'Height',
					'name' => 'height',
					'type' => 'number',
					'instructions' => '',
					'required' => 0,
					'conditional_logic' => 0,
					'wrapper' => array(
						'width' => '',
						'class' => '',
						'id' => '',
					),
					'default_value' => '',
					'placeholder' => '',
					'prepend' => '',
					'append' => '',
					'min' => '',
					'max' => '',
					'step' => '',
				),
				array(
					'key' => 'field_5d00e2ff00ecc',
					'label' => 'Sex',
					'name' => 'sex',
					'type' => 'text',
					'instructions' => '',
					'required' => 0,
					'conditional_logic' => 0,
					'wrapper' => array(
						'width' => '',
						'class' => '',
						'id' => '',
					),
					'default_value' => '',
					'placeholder' => '',
					'prepend' => '',
					'append' => '',
					'maxlength' => '',
				),
				array(
					'key' => 'field_5d00e31200ecd',
					'label' => 'Weight',
					'name' => 'weight',
					'type' => 'number',
					'instructions' => '',
					'required' => 0,
					'conditional_logic' => 0,
					'wrapper' => array(
						'width' => '',
						'class' => '',
						'id' => '',
					),
					'default_value' => '',
					'placeholder' => '',
					'prepend' => '',
					'append' => '',
					'min' => '',
					'max' => '',
					'step' => '',
				),
			),
			'location' => array(
				array(
					array(
						'param' => 'post_type',
						'operator' => '==',
						'value' => 'pp_dog',
					),
				),
			),
			'menu_order' => 0,
			'position' => 'normal',
			'style' => 'default',
			'label_placement' => 'top',
			'instruction_placement' => 'label',
			'hide_on_screen' => '',
			'active' => true,
			'description' => '',
		));
		endif;
	}


	/**
	 * function for filtering filter_the_content
	 *
	 * @since    1.0.0
	 */
	public function filter_the_excerpt() {
		add_filter('get_the_excerpt', function($excerpt){
			$size = get_the_term_list(get_the_ID(), 'pp_dogsize', '<br><strong>Size:</strong> ');
			$excerpt .= $size;

			return $excerpt;
		});
	}
}
