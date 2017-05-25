<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              http://www.omasters.com
 * @since             0.0.1
 * @package           WP Mybookings
 *
 * @wordpress-plugin
 * Plugin Name:       WP Mybookings
 * Plugin URI:        https://www.cloudbeds.com/wp-plugins/mybookings-light/update.php
 * Description:       Hotel Reservation system including Cloudbeds API. <a href="#">Check new version</a>
 * Version:           0.9.616
 * Author:            Shahinul Islam
 * Author URI:        http://www.cloudbeds.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       cloudbeds-hotel-management
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

error_reporting(E_ERROR);

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-cloudbeds-hotel-management-activator.php
 */
function activate_cloudbeds_hotel_management() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-cloudbeds-hotel-management-activator.php';
	Cloudbeds_Hotel_Management_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-cloudbeds-hotel-management-deactivator.php
 */
function deactivate_cloudbeds_hotel_management() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-cloudbeds-hotel-management-deactivator.php';
	Cloudbeds_Hotel_Management_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_cloudbeds_hotel_management' );
register_deactivation_hook( __FILE__, 'deactivate_cloudbeds_hotel_management' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-cloudbeds-hotel-management.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    0.0.1
 */
function run_cloudbeds_hotel_management() {

	$plugin = new Cloudbeds_Hotel_Management();
	$plugin->run();

}
run_cloudbeds_hotel_management();
