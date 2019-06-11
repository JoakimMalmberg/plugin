<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       m42.se
 * @since      1.0.0
 *
 * @package    Wcms18_Mappy_Weather
 * @subpackage Wcms18_Mappy_Weather/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Wcms18_Mappy_Weather
 * @subpackage Wcms18_Mappy_Weather/public
 * @author     Joakim Malmberg <jmalmberg.web@gmail.com>
 */
class Wcms18_Mappy_Weather_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

		$this->define_shortcodes();
		$this->define_ajax_actions();

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		
		
		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/wcms18-mappy-weather-public.css', [], $this->version, 'all' );
	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/wcms18-mappy-weather-public.js', array( 'jquery' ), $this->version, true );

		wp_localize_script($this->plugin_name, 'wcms18_mappy_weather_obj', [
			'ajax_url' => admin_url('admin-ajax.php'),
		]);

		wp_enqueue_script( 
			'google-maps',
			'https://maps.googleapis.com/maps/api/js?key='. WCMS18_MAPPY_WEATHER_GOOGLE_MAPS_API_KEY .'&callback=initMap',
			[], false, true 
		);
	}

	/*
	* Create Shortcode "mappy"
	*/
	public function do_shortcode_mappy($user_atts) {
		
		// fallback if no $user_atts is set
		$default_atts = [
			'address' => false,
		];

		$atts = shortcode_atts($default_atts, $user_atts, 'mappy');

		//verify that address is set
		if($atts['address'] == false){
			return '<div id="wcms18-mappy-weather">
						<div class="error">Add Address to show map for.</div>
					</div>';
		}

		//do stuff

		//return stuffsies
		return '<div id="wcms18-mappy-weather" data-address="'.$atts['address'].'">
					<div id="map"></div><div id="weather"></div>
				</div>';

	}

	/**
	 * Register our plugin's shortcodes.
	 * 
	 * @since 1.0.0.
	 */
	public function define_shortcodes(){
		add_shortcode('mappy', [$this, 'do_shortcode_mappy']);
	}
	
	/**
	 * Register our ajax actions.
	 * 
	 * @since 1.0.0.
	 */
	public function define_ajax_actions(){
		add_action('wp_ajax_wcms18_mappy_weather__get', [$this, 'do_ajax_get_weather']);
		add_action('wp_ajax_nopriv_wcms18_mappy_weather__get', [$this, 'do_ajax_get_weather']);
	}

	/**
	 * Respond to ajax action.
	 * 
	 * @since 1.0.0.
	 */
	public function do_ajax_get_weather(){
		$lat = $_POST['lat'];
		$lng = $_POST['lng'];
		$res = wapi_get_weather_for_position($lat, $lng);

		if($res['success']){
			wp_send_json_success($res['data']);
		}else{
			wp_send_json_error($res['error']);
		}
	}
}
