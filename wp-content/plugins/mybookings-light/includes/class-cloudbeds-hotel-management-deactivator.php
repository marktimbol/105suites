<?php

/**
 * Fired during plugin deactivation
 *
 * @link       http://www.omasters.com
 * @since      0.0.1
 *
 * @package    Cloudbeds_Hotel_Management
 * @subpackage Cloudbeds_Hotel_Management/includes
 */

/**
 * Fired during plugin deactivation.
 *
 * This class defines all code necessary to run during the plugin's deactivation.
 *
 * @since      0.0.1
 * @package    Cloudbeds_Hotel_Management
 * @subpackage Cloudbeds_Hotel_Management/includes
 * @author     Shahinul Islam <shahinbdboy@gmail.com>
 */
class Cloudbeds_Hotel_Management_Deactivator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    0.0.1
	 */
	public static function deactivate() {
		 global $wpdb;
         $table = $wpdb->prefix."cloudbeds_hotel_management_reservaions";

         //Delete any options thats stored also?
		// //delete_option('wp_yourplugin_version');

		 $wpdb->query("DROP TABLE IF EXISTS $table");
	}

}
