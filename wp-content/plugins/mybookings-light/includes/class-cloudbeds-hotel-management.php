<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       http://www.omasters.com
 * @since      0.0.1
 *
 * @package    Cloudbeds_Hotel_Management
 * @subpackage Cloudbeds_Hotel_Management/includes
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
 * @since      0.0.1
 * @package    Cloudbeds_Hotel_Management
 * @subpackage Cloudbeds_Hotel_Management/includes
 * @author     Shahinul Islam <shahinbdboy@gmail.com>
 */
class Cloudbeds_Hotel_Management {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    0.0.1
	 * @access   protected
	 * @var      Cloudbeds_Hotel_Management_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    0.0.1
	 * @access   protected
	 * @var      string    $cloudbeds_hotel_management    The string used to uniquely identify this plugin.
	 */
	protected $cloudbeds_hotel_management;

	/**
	 * The current version of the plugin.
	 *
	 * @since    0.0.1
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
	 * @since    0.0.1
	 */
	public function __construct() {

		$this->cloudbeds_hotel_management = 'cloudbeds-hotel-management';
		$this->version = '0.9.616';

		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();
		$this->define_public_hooks();

	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - Cloudbeds_Hotel_Management_Loader. Orchestrates the hooks of the plugin.
	 * - Cloudbeds_Hotel_Management_i18n. Defines internationalization functionality.
	 * - Cloudbeds_Hotel_Management_Admin. Defines all hooks for the admin area.
	 * - Cloudbeds_Hotel_Management_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    0.0.1
	 * @access   private
	 */
	private function load_dependencies() {

		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-cloudbeds-hotel-management-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-cloudbeds-hotel-management-i18n.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-cloudbeds-hotel-management-admin.php';

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-cloudbeds-hotel-management-public.php';

		$this->loader = new Cloudbeds_Hotel_Management_Loader();

	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the Cloudbeds_Hotel_Management_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    0.0.1
	 * @access   private
	 */
	private function set_locale() {

		$plugin_i18n = new Cloudbeds_Hotel_Management_i18n();
		$plugin_i18n->set_domain( $this->get_cloudbeds_hotel_management() );

		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );

	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    0.0.1
	 * @access   private
	 */
	private function define_admin_hooks() {

		$plugin_admin = new Cloudbeds_Hotel_Management_Admin( $this->get_cloudbeds_hotel_management(), $this->get_version() );

		$this->loader->add_action( 'admin_menu', $plugin_admin, 'cloudbeds_hotel_management_overview' );
		
		// Ajax Callbacks
		$this->loader->add_action('wp_ajax_'.$this->get_cloudbeds_hotel_management().'_search_bookings', $plugin_admin, 'reservation_results_callback');

		$this->loader->add_action('wp_ajax_'.$this->get_cloudbeds_hotel_management().'_view_bookings_info', $plugin_admin, 'get_booking_info');
		$this->loader->add_action('wp_ajax_'.$this->get_cloudbeds_hotel_management().'_confirm_bookings_info', $plugin_admin, 'booking_info_confirmed');
		$this->loader->add_action('wp_ajax_'.$this->get_cloudbeds_hotel_management().'_booking_cancelled', $plugin_admin, 'booking_cancelled');
		$this->loader->add_action('wp_ajax_'.$this->get_cloudbeds_hotel_management().'_request_archive', $plugin_admin, 'booking_info_archive');

		$this->loader->add_action('wp_ajax_'.$this->get_cloudbeds_hotel_management().'_new_room', $plugin_admin, 'cloudbeds_hotel_management_new_room');
		
		$this->loader->add_action('wp_ajax_'.$this->get_cloudbeds_hotel_management().'_edit_room', $plugin_admin, 'cloudbeds_hotel_management_edit_room');

		$this->loader->add_action('wp_ajax_'.$this->get_cloudbeds_hotel_management().'_general_settings', $plugin_admin, 'cloudbeds_hotel_management__general_settings_save');

		$this->loader->add_action('wp_ajax_'.$this->get_cloudbeds_hotel_management().'_get_rates', $plugin_admin, 'get_room_rates');
		$this->loader->add_action('wp_ajax_'.$this->get_cloudbeds_hotel_management().'_save_rate_changes', $plugin_admin, 'save_rate_changes');
		$this->loader->add_action('wp_ajax_'.$this->get_cloudbeds_hotel_management().'_save_bulk_changes', $plugin_admin, 'save_bulk_changes');


		$this->loader->add_action('wp_ajax_'.$this->get_cloudbeds_hotel_management().'_update-grid', $plugin_admin, 'room_rate_update_grid');
		$this->loader->add_action('wp_ajax_'.$this->get_cloudbeds_hotel_management().'_update-rate-grid', $plugin_admin, 'room_rate_update_rate_grid');
		$this->loader->add_action('wp_ajax_'.$this->get_cloudbeds_hotel_management().'_updatecommonrate', $plugin_admin, 'room_rate_coomonupdate');
		$this->loader->add_action('wp_ajax_'.$this->get_cloudbeds_hotel_management().'_updatecommonsell', $plugin_admin, 'room_rate_updatecommonsell');

		$this->loader->add_action('wp_ajax_'.$this->get_cloudbeds_hotel_management().'_roomrate-update', $plugin_admin, 'cloudbeds_hotel_management__roomrate_update');

		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );
		$this->loader->add_action( 'admin_notices', $plugin_admin, 'cloudbeds_admin_notices' );
		$this->loader->add_action( 'admin_init', $plugin_admin, 'cloudbeds_notices_nag_ignore' );
		
		// Upgrade Notifiaction
		$this->loader->add_filter( 'admin_init', $plugin_admin, 'cloudbeds_update_plugin' );
		$this->loader->add_action( 'admin_notices', $plugin_admin, 'show_admin_notification' );
	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    0.0.1
	 * @access   private
	 */
	private function define_public_hooks() {

		$plugin_public = new Cloudbeds_Hotel_Management_Public( $this->get_cloudbeds_hotel_management(), $this->get_version() );

		$this->loader->add_action( 'init', $this, 'init' );


		$this->loader->add_action('wp_ajax_'.$this->get_cloudbeds_hotel_management().'_cb_hm-front-search', $plugin_public, 'search');
		$this->loader->add_action('wp_ajax_nopriv_'.$this->get_cloudbeds_hotel_management().'_cb_hm-front-search', $plugin_public, 'search');

		$this->loader->add_action('wp_ajax_'.$this->get_cloudbeds_hotel_management().'_user_login', $plugin_public, 'user_login');
		$this->loader->add_action('wp_ajax_nopriv_'.$this->get_cloudbeds_hotel_management().'_user_login', $plugin_public, 'user_login');

		$this->loader->add_action('wp_ajax_'.$this->get_cloudbeds_hotel_management().'_book_now', $plugin_public, 'book_now');
		$this->loader->add_action('wp_ajax_nopriv_'.$this->get_cloudbeds_hotel_management().'_book_now', $plugin_public, 'book_now');

		$this->loader->add_action('wp_ajax_'.$this->get_cloudbeds_hotel_management().'_order_booking', $plugin_public, 'order_booking');
		$this->loader->add_action('wp_ajax_nopriv_'.$this->get_cloudbeds_hotel_management().'_order_booking', $plugin_public, 'order_booking');

		$this->loader->add_action('wp_ajax_'.$this->get_cloudbeds_hotel_management().'_confirm_booking', $plugin_public, 'confirm_booking');
		$this->loader->add_action('wp_ajax_nopriv_'.$this->get_cloudbeds_hotel_management().'_confirm_booking', $plugin_public, 'confirm_booking');


		// Local hooks
		$this->loader->add_action('wp_ajax_'.$this->get_cloudbeds_hotel_management().'_search', $plugin_public, 'cloudbeds_ajax');
		$this->loader->add_action('wp_ajax_nopriv_'.$this->get_cloudbeds_hotel_management().'_search', $plugin_public, 'cloudbeds_ajax');

		$this->loader->add_action('wp_ajax_'.$this->get_cloudbeds_hotel_management().'_checkroomavailability', $plugin_public, 'cloudbeds_checkroomavailability');
		$this->loader->add_action('wp_ajax_nopriv_'.$this->get_cloudbeds_hotel_management().'_checkroomavailability', $plugin_public, 'cloudbeds_checkroomavailability');
		
		$this->loader->add_action('wp_ajax_'.$this->get_cloudbeds_hotel_management().'_reservation', $plugin_public, 'cloudbeds_reservation');
		$this->loader->add_action('wp_ajax_nopriv_'.$this->get_cloudbeds_hotel_management().'_reservation', $plugin_public, 'cloudbeds_reservation');



		// API hooks 
		$this->loader->add_action('wp_ajax_'.$this->get_cloudbeds_hotel_management().'_api_search', $plugin_public, 'cloudbeds_api_ajax');
		$this->loader->add_action('wp_ajax_nopriv_'.$this->get_cloudbeds_hotel_management().'_api_search', $plugin_public, 'cloudbeds_api_ajax');

		$this->loader->add_action('wp_ajax_'.$this->get_cloudbeds_hotel_management().'_api_checkroomavailability', $plugin_public, 'api_checkroomavailability');
		$this->loader->add_action('wp_ajax_nopriv_'.$this->get_cloudbeds_hotel_management().'_api_checkroomavailability', $plugin_public, 'api_checkroomavailability');

		$this->loader->add_action('wp_ajax_'.$this->get_cloudbeds_hotel_management().'_api_reservation', $plugin_public, 'cloudbeds_api_reservation');
		$this->loader->add_action('wp_ajax_nopriv_'.$this->get_cloudbeds_hotel_management().'_api_reservation', $plugin_public, 'cloudbeds_api_reservation');

		$this->loader->add_action('wp_ajax_'.$this->get_cloudbeds_hotel_management().'_api_checkoutreservation', $plugin_public, 'cloudbeds_api_checkoutreservation');
		$this->loader->add_action('wp_ajax_nopriv_'.$this->get_cloudbeds_hotel_management().'_api_checkoutreservation', $plugin_public, 'cloudbeds_api_checkoutreservation');


		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );


		// Short Code for hotel reservation
		add_shortcode( 'cb_hm', array( $plugin_public, 'cloudbeds_shortcode' ) ); 
		// add_shortcode( 'cb_hm_thankyou', array( $plugin_public, 'show_thankyou' ) ); 

	}

	public function init(){
		/* Register Post Type for Room Type
		*
		*/
		$labels = array(
			'name'               => _x( 'Rooms', 'post type general name', $this->get_cloudbeds_hotel_management() ),
			'singular_name'      => _x( 'Room', 'post type singular name', $this->get_cloudbeds_hotel_management() ),
			'menu_name'          => _x( 'Room', 'admin menu', $this->get_cloudbeds_hotel_management() ),
			'name_admin_bar'     => _x( 'Room', 'add new on admin bar', $this->get_cloudbeds_hotel_management() ),
			'add_new'            => _x( 'Add New', 'cb_hm_room_type', $this->get_cloudbeds_hotel_management() ),
			'add_new_item'       => __( 'Add New Room', $this->get_cloudbeds_hotel_management() ),
			'new_item'           => __( 'New Room', $this->get_cloudbeds_hotel_management() ),
			'edit_item'          => __( 'Edit Room', $this->get_cloudbeds_hotel_management() ),
			'view_item'          => __( 'View Rooms', $this->get_cloudbeds_hotel_management() ),
			'all_items'          => __( 'All Rooms', $this->get_cloudbeds_hotel_management() ),
			'search_items'       => __( 'Search Rooms', $this->get_cloudbeds_hotel_management() ),
			'parent_item_colon'  => __( 'Parent Rooms:', $this->get_cloudbeds_hotel_management() ),
			'not_found'          => __( 'No Rooms found.', $this->get_cloudbeds_hotel_management() ),
			'not_found_in_trash' => __( 'No Rooms found in Trash.', $this->get_cloudbeds_hotel_management() )
		);

		$args = array(
			'labels'             => $labels,
			'public'             => true,
			'publicly_queryable' => false,
			'show_ui'            => true,
			'show_in_menu'       => false,
			'query_var'          => true,
			'rewrite'            => array( 'slug' => 'cb_hm_room_type' ),
			'capability_type'    => 'post',
			'has_archive'        => true,
			'hierarchical'       => false,
			'menu_position'      => null,
			'supports'           => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt' )
		);

		register_post_type( 'cb_hm_room_type', $args );
	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    0.0.1
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
	public function get_cloudbeds_hotel_management() {
		return $this->cloudbeds_hotel_management;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.0
	 * @return    Cloudbeds_Hotel_Management_Loader    Orchestrates the hooks of the plugin.
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
