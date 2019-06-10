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
 * @package    Wcms18_Year_Book
 * @subpackage Wcms18_Year_Book/includes
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
 * @package    Wcms18_Year_Book
 * @subpackage Wcms18_Year_Book/includes
 * @author     Joakim Malmberg <jmalmberg.web@gmail.com>
 */
class Wcms18_Year_Book {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      Wcms18_Year_Book_Loader    $loader    Maintains and registers all hooks for the plugin.
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
		if ( defined( 'WCMS18_YEAR_BOOK_VERSION' ) ) {
			$this->version = WCMS18_YEAR_BOOK_VERSION;
		} else {
			$this->version = '1.0.0';
		}
		$this->plugin_name = 'wcms18-year-book';

		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();
		$this->define_public_hooks();
		
		$this->register_filter_the_content();
		$this->add_action_init();
		$this->register_widget();

	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - Wcms18_Year_Book_Loader. Orchestrates the hooks of the plugin.
	 * - Wcms18_Year_Book_i18n. Defines internationalization functionality.
	 * - Wcms18_Year_Book_Admin. Defines all hooks for the admin area.
	 * - Wcms18_Year_Book_Public. Defines all hooks for the public side of the site.
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
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-wcms18-year-book-loader.php';
		
		/**
		 * Custom fields
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/acf/acf.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-wcms18-year-book-i18n.php';
		
		/**
		 * Widget
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-wcms18-year-book-widget.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-wcms18-year-book-admin.php';

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-wcms18-year-book-public.php';

		$this->loader = new Wcms18_Year_Book_Loader();

	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the Wcms18_Year_Book_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale() {

		$plugin_i18n = new Wcms18_Year_Book_i18n();

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

		$plugin_admin = new Wcms18_Year_Book_Admin( $this->get_plugin_name(), $this->get_version() );

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

		$plugin_public = new Wcms18_Year_Book_Public( $this->get_plugin_name(), $this->get_version() );

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
			register_widget('Wcms18_Year_Book_Widget');
		});
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
	 * Register a function for filter register_filter_the_content
	 *
	 * @since    1.0.0
	 */
	public function register_filter_the_content() {
		add_filter('the_content', [$this, 'filter_the_content']);
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
		 * Post Type: Students.
		 */

		$labels = array(
			"name" => __( "Students", "hestia" ),
			"singular_name" => __( "Student", "hestia" ),
		);

		$args = array(
			"label" => __( "Students", "hestia" ),
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
			"show_in_nav_menus" => false,
			"exclude_from_search" => false,
			"capability_type" => "post",
			"map_meta_cap" => true,
			"hierarchical" => false,
			"rewrite" => array( "slug" => "students", "with_front" => true ),
			"query_var" => true,
			"menu_icon" => "dashicons-welcome-learn-more",
			"supports" => array( "title", "editor", "thumbnail", "excerpt" ),
		);
		register_post_type( "w18yb_student", $args );
	}

	/**
	 * Register cts
	 *
	 * @since    1.0.0
	 */
	public function register_cts() {
		/**
	 	* Taxonomy: Course.
		*/

		$labels = array(
			"name" => __( "Course", "hestia" ),
			"singular_name" => __( "Course", "hestia" ),
		);

		$args = array(
			"label" => __( "Course", "hestia" ),
			"labels" => $labels,
			"public" => true,
			"publicly_queryable" => true,
			"hierarchical" => true,
			"show_ui" => true,
			"show_in_menu" => true,
			"show_in_nav_menus" => true,
			"query_var" => true,
			"rewrite" => array( 'slug' => 'courses', 'with_front' => true,  'hierarchical' => true, ),
			"show_admin_column" => false,
			"show_in_rest" => true,
			"rest_base" => "w18yb_course",
			"rest_controller_class" => "WP_REST_Terms_Controller",
			"show_in_quick_edit" => false,
			);
		register_taxonomy( "w18yb_course", array( "w18yb_student" ), $args );
	}

	/**
	 * Register Advanced Custom Fields
	 *
	 * @since    1.0.0
	 */
	public function register_acf() {
		if( function_exists('acf_add_local_field_group') ):

		acf_add_local_field_group(array(
			'key' => 'group_5cfe3fe3b7968',
			'title' => 'Student Details',
			'fields' => array(
				array(
					'key' => 'field_5cfe3ff22505d',
					'label' => 'Attendance',
					'name' => 'attendance',
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
					'append' => '%',
					'min' => 0,
					'max' => '',
					'step' => '',
				),
				array(
					'key' => 'field_5cfe401e2505e',
					'label' => 'Detention Hours',
					'name' => 'detention_hours',
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
					'append' => 'h',
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
						'value' => 'w18yb_student',
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
	public function filter_the_content($content) {

		if(get_post_type() === 'w18yb_student'){

			$courses = get_the_term_list(get_the_ID(), 'w18yb_course', 'Courses: ', ', ');
			$content .= '<div class="w18yb-courses">' . $courses . '</div>';

			if(function_exists('get_field')){

				$attendance = get_field('attendance');
				$detention_hours = get_field('detention_hours');

				$content .= '<div class="student-details">';
				$content .= '<h2>Student Details</h2>';
				
				if($attendance !== false){
					$content .= '<span>Attendance: ' . $attendance . '%</span><br>';
				}
				if($detention_hours !== false){
					$content .= '<span>Detention: ' . $detention_hours . ' hours</span>';
				}
				$content .= '</div>';
			}
		}
		return $content;
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
	 * @return    Wcms18_Year_Book_Loader    Orchestrates the hooks of the plugin.
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
