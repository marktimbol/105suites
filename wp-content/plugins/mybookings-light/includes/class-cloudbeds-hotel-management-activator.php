<?php

/**
 * Fired during plugin activation
 *
 * @link       http://www.omasters.com
 * @since      0.0.1
 *
 * @package    Cloudbeds_Hotel_Management
 * @subpackage Cloudbeds_Hotel_Management/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      0.0.1
 * @package    Cloudbeds_Hotel_Management
 * @subpackage Cloudbeds_Hotel_Management/includes
 * @author     Shahinul Islam <shahinbdboy@gmail.com>
 */
class Cloudbeds_Hotel_Management_Activator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    0.0.1
	 */
	public static function activate() {

		/* Create Necessary Databases
		* `cloudbeds_hotel_management_reservaions`
		* `cloudbeds_hotel_management_room_rates`
		*/
		global $wpdb;

	    require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );

	    $table_name = $wpdb->prefix . 'cloudbeds_hotel_management_reservaions';
	    // var_dump($wpdb->prefix);

		// $sql = "DROP TABLE IF EXISTS `$table_name`";
		// dbDelta( $sql );
		// $sql = "DROP TABLE IF_EXISTS $table_name;";
		// $e = $wpdb->query($sql);

		$sql = "CREATE TABLE IF NOT EXISTS `$table_name` (
		  `id` bigint(20) NOT NULL AUTO_INCREMENT,
		  `booking_ref` varchar(255) DEFAULT NULL,
		  `user_id` bigint(20) NOT NULL,
		  `roomtype_id` bigint(20) NOT NULL,
		  `rate_id` bigint(20) NOT NULL,
		  `packages` text NOT NULL,
		  `roomquantity` bigint(20) NOT NULL,
		  `price` float NOT NULL,
		  `qtprice` float NOT NULL,
		  `kids` INT(4) NOT NULL,
		  `adults` INT(4) NOT NULL,
		  `status` enum('0','1','2','3') NOT NULL,
		  `product_type` varchar(50) DEFAULT NULL,
		  `card_type` varchar(255) DEFAULT NULL,
		  `card_number` varchar(255) DEFAULT NULL,
		  `card_name` varchar(255) DEFAULT NULL,
		  `card_issue` varchar(255) DEFAULT NULL,
		  `card_security` varchar(255) DEFAULT NULL,
		  `card_starts_month` varchar(255) DEFAULT NULL,
		  `card_starts_year` varchar(255) DEFAULT NULL,
		  `card_ends_month` varchar(255) DEFAULT NULL,
		  `card_ends_year` varchar(255) DEFAULT NULL,
		  `arriving` datetime NOT NULL,
		  `departing` datetime NOT NULL,
		  `stay` bigint(20) NOT NULL,
		  `order_time` datetime NOT NULL,
		  `any_request` text NOT NULL,
		  `guests` text NOT NULL,
		  `archive` tinyint(1) NOT NULL,
		  PRIMARY KEY (`id`)
		) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1" ;
		dbDelta( $sql );

		// DATABASE UPGRADE FOR ALREADY EXISTS DATABASE TABLE;
		// $chksql = "SELECT `adults` FROM `$table_name` WHERE 1";
		// $result = $wpdb->get_results($chksql);
		// if(empty($result)):
		// 	$sql = "ALTER TABLE  `$table_name` ADD  `adults` INT( 4 ) NOT NULL AFTER  `qtprice` , ADD  `kids` INT( 4 ) NOT NULL AFTER  `adults`";
		// 	$succss = $wpdb->query($sql);
		// endif;
		//

	 //    $sql = "CREATE TABLE IF NOT EXISTS `$table_name` (
		//   `id` bigint(20) NOT NULL AUTO_INCREMENT,
		//   `booking_ref` varchar(255) DEFAULT NULL,
		//   `user_id` bigint(20) NOT NULL,
		//   `roomtype_id` bigint(20) NOT NULL,
		//   `rate_id` bigint(20) NOT NULL,
		//   `roomquantity` bigint(20) NOT NULL,
		//   `price` float NOT NULL,
		//   `qtprice` float NOT NULL,
		//   `status` enum('0','1','2','3') NOT NULL,
		//   `product_type` varchar(50) DEFAULT NULL,
		//   `arriving` datetime NOT NULL,
		//   `departing` datetime NOT NULL,
		//   `stay` bigint(20) NOT NULL,
		//   `order_time` datetime NOT NULL,
		//   `any_request` text NOT NULL,
		//   `guests` text NOT NULL,
		//   `amenities` text NOT NULL,
		//   `archive` tinyint(1) NOT NULL,
		//   PRIMARY KEY (`id`)
		// ) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1";
		// dbDelta( $sql );


		$table_name = $wpdb->prefix . 'cloudbeds_hotel_management_room_rates';
	    $sql = "CREATE TABLE IF NOT EXISTS `$table_name` (
		  `id` bigint(20) NOT NULL AUTO_INCREMENT,
		  `roomtype_id` bigint(20) NOT NULL,
		  `bookdate` date NOT NULL,
		  `price` float NOT NULL,
		  `available` enum('0','1','2') NOT NULL,
		  `allocation` smallint(3) NOT NULL,
		  `minimum_stay` smallint(4) NOT NULL,
		  `booking` smallint(4) NOT NULL,
		  `restriction` tinyint(1) NOT NULL,
		  `update_time` datetime NOT NULL,
		  PRIMARY KEY (`id`)
		) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1";
		dbDelta( $sql );


		$admin = get_role('administrator' );
		$admin->add_cap( 'manage_options');
		
		if ( ! function_exists('curl_init') ) {
		    throw new Exception('Your server does not seem to have CURL installed. Please have your webmaster or support team install it to use this plugin.');
		}
		if(!in_array('curl', get_loaded_extensions())) {
			throw new Exception('Your server does not seem to have CURL installed. Please have your webmaster or support team install it to use this plugin.');
		}

		//Core code updated which supports php version 5.3 and above
		$required = '5.3.0';
		$server = phpversion();
		if(version_compare($required, $server, '>')){
			throw new Exception('Your server does not have php 5.3.0 or heigher. Please have your webmaster or support team to upgrade your server.');
		}

	}

}
