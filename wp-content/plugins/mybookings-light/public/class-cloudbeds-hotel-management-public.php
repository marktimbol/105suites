<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       http://www.omasters.com
 * @since      0.0.1
 *
 * @package    Cloudbeds_Hotel_Management
 * @subpackage Cloudbeds_Hotel_Management/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Cloudbeds_Hotel_Management
 * @subpackage Cloudbeds_Hotel_Management/public
 * @author     Shahinul Islam <shahinbdboy@gmail.com>
 */

require('oauth2/Client.php');
require('oauth2/GrantType/IGrantType.php');
require('oauth2/GrantType/AuthorizationCode.php');
require('oauth2/GrantType/RefreshToken.php');

class Cloudbeds_Hotel_Management_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    0.0.1
	 * @access   private
	 * @var      string    $cloudbeds_hotel_management    The ID of this plugin.
	 */
	private $cloudbeds_hotel_management;

	/**
	 * The version of this plugin.
	 *
	 * @since    0.0.1
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	private $roomtype = 'cb_hm_room_type';
	private $roomratedb = 'cloudbeds_hotel_management_room_rates';
	private $bookingtable = 'cloudbeds_hotel_management_reservaions';
	public $cb_api = 'https://hotels.cloudbeds.com/';
	// public $cb_api = 'http://wwwdev4.ondeficar.com/';

	// API Version 1.1
	// private $cb_token_url = 'https://hotels.cloudbeds.com/api/v1.1/access_token';
	private $cb_api_hotel_details_url = 'api/v1.1/getHotelDetails';
	private $cb_api_get_available_rooms = 'api/v1.1/getAvailableRoomTypes';
	private $cb_api_get_getroomsfeesandtaxes = 'api/v1.1/getRoomsFeesAndTaxes';
	private $cb_api_post_reservation = 'api/v1.1/postReservation';
	//private $cb_token_grant_type = 'password';
	private $cb_token_grant_type = 'api/v1.1/authorization_code';
	private $cb_api_token_url = 'api/v1.1/access_token';
	private $cb_api_authorization_url = 'api/v1.1/oauth';

	public $amenities = array('ac'=>'Air Conditioning', 'internet'=>'Internet (Wi-Fi)', 'telephone'=>'Telephone', 'tv'=>'TV', 'safe'=>'Safe', 'minibar'=>'Minibar', 'kitchen'=>'Kitchen', 'work-space'=>'Work Space', 'bath'=>'Bath', 'shower'=>'Shower', 'towels'=>'Towels', 'smoking'=>'Smoking Allowed');

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    0.0.1
	 * @param      string    $cloudbeds_hotel_management       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $cloudbeds_hotel_management, $version ) {

		$this->cloudbeds_hotel_management = $cloudbeds_hotel_management;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    0.0.1
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Cloudbeds_Hotel_Management_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Cloudbeds_Hotel_Management_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

      	// wp_enqueue_style('jquery-style', '//ajax.googleapis.com/ajax/libs/jqueryui/1.8.2/themes/smoothness/jquery-ui.css');
		wp_enqueue_style($this->cloudbeds_hotel_management.'_font_awesome', '//cdnjs.cloudflare.com/ajax/libs/font-awesome/4.0.3/css/font-awesome.min.css',__FILE__);
		wp_enqueue_style($this->cloudbeds_hotel_management.'_google_font', '//fonts.googleapis.com/css?family=Roboto:400,100,100italic,300,300italic,500,400italic,500italic,700,700italic,900,900italic|Roboto+Slab:400,100,700,300',__FILE__);
		wp_enqueue_style($this->cloudbeds_hotel_management.'_selectize_css', '//cdnjs.cloudflare.com/ajax/libs/selectize.js/0.8.5/css/selectize.css',__FILE__);
		wp_enqueue_style($this->cloudbeds_hotel_management.'_qtip_css', '//cdnjs.cloudflare.com/ajax/libs/qtip2/2.2.0/basic/jquery.qtip.min.css',__FILE__);
		wp_enqueue_style($this->cloudbeds_hotel_management.'_magnific-popup_css', '//cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/0.9.9/magnific-popup.css',__FILE__);


		// if($this->is_api_enabled()){
			wp_enqueue_style($this->cloudbeds_hotel_management.'_selectize_css', 'https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.8.5/css/selectize.css', __FILE__);
		// }
		if( file_exists(get_template_directory_uri().'/mybookings-light/mybookings_light.css') ) {
			wp_enqueue_style( $this->cloudbeds_hotel_management.'_public', TEMPLATEPATH.'/mybookings-light/mybookings_light.css', array(), $this->version, 'all' );
		}else {
			wp_enqueue_style( $this->cloudbeds_hotel_management.'_public', plugin_dir_url( __FILE__ ) . 'css/cloudbeds-hotel-management-public.css', array(), rand(), 'all' );
		}


	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    0.0.1
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Cloudbeds_Hotel_Management_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Cloudbeds_Hotel_Management_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */
		wp_enqueue_script($this->cloudbeds_hotel_management.'_form', '//cdnjs.cloudflare.com/ajax/libs/jquery.form/3.51/jquery.form.min.js', array('jquery'), '3.51', true);

		wp_enqueue_script( $this->cloudbeds_hotel_management.'_jquery-validate', '//cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.9.0/jquery.validate.min.js', array( 'jquery' ), '1.9.0', true );

		wp_enqueue_script($this->cloudbeds_hotel_management.'_handlebars', '//cdnjs.cloudflare.com/ajax/libs/handlebars.js/3.0.0/handlebars.min.js', array('jquery'), '3.0.0', false);

		// wp_register_script( $this->cloudbeds_hotel_management.'_googlemapapi', '//maps.googleapis.com/maps/api/js?sensor=false');

		wp_enqueue_script( 'jquery-ui-core' );
		wp_enqueue_script( 'jquery-ui-datepicker' );

		wp_enqueue_script( $this->cloudbeds_hotel_management.'_jquery-magnific','//cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/0.9.9/jquery.magnific-popup.min.js',  array( 'jquery' ), '0.9.9', true );

		wp_enqueue_script($this->cloudbeds_hotel_management.'_print', plugin_dir_url( __FILE__ )  . 'js/print.js', array('jquery'), $this->version, true);

			wp_enqueue_script( $this->cloudbeds_hotel_management.'_jquery-selectize','//cdnjs.cloudflare.com/ajax/libs/selectize.js/0.8.5/js/standalone/selectize.min.js',  array( 'jquery' ), '0.8.5', true );
			wp_enqueue_script( $this->cloudbeds_hotel_management.'_jquery-qtip','//cdnjs.cloudflare.com/ajax/libs/qtip2/2.2.1/jquery.qtip.min.js',  array( 'jquery' ), '2.2.1', true );
		if($this->is_api_enabled()):
			wp_enqueue_script( 'jquery-light-slider', plugin_dir_url( __FILE__ ) . 'js/lightslider.min.js', array( 'jquery' ), '1.1.5', false );

			wp_enqueue_script( $this->cloudbeds_hotel_management, plugin_dir_url( __FILE__ ) . 'js/api/cloudbeds-hotel-management-api.js', array( 'jquery' ), rand(), false );
		else:
			wp_enqueue_script( $this->cloudbeds_hotel_management, plugin_dir_url( __FILE__ ) . 'js/cloudbeds-hotel-management-public.js', array( 'jquery' ), rand(), false );			
		endif;
		wp_localize_script( $this->cloudbeds_hotel_management, 'cb_hm_front_ajaxobj', array( 'url' => admin_url( 'admin-ajax.php' ), 'name'=>$this->cloudbeds_hotel_management, 'parse' => wp_create_nonce( $this->cloudbeds_hotel_management.'_public_action' ), 'version'=>$this->version ) );

	}

	public function cloudbeds_shortcode($atts){
		extract( shortcode_atts( array(
          	'property_id' => 0,
          	'widget_date'    => '',
          	'widget_date_to' => '',
          	'date_format'    => 'm/d/Y'
       	), $atts ) );

       	// var_dump($property_id);

       	$date_format = (empty($date_format)) ? isset( $_REQUEST['date_format'] ) ? $_REQUEST['date_format'] : $date_format : $date_format;
       	$datefrom = (empty($widget_date)) ? isset( $_REQUEST['widget_date'] ) ? $_REQUEST['widget_date'] : date($date_format,strtotime('tomorrow')) : $widget_date;
       	$dateto   = (empty($widget_date_to)) ? isset( $_REQUEST['widget_date_to'] ) ? $_REQUEST['widget_date_to'] : date($date_format,strtotime('+2 day')) : $widget_date_to;
        

       	$unique_id = $this->cloudbeds_hotel_management.'_'.date('YmdHisu').'_'.$property_id;

       	// API Enabled Check

       	// if($this->is_api_enabled())
       	// 	$folder = 'api';
       	// else
       	// 	$folder = 'api';
       	$folder = '';

		ob_start();

       	// Check if these templates are available in template folder;
       	if( file_exists(TEMPLATEPATH.'/mybookings-light/'.$folder.'search.php') ) {
       		include(TEMPLATEPATH.'/mybookings-light/'.$folder.'search.php');
       	}else {
       		include(plugin_dir_path( __FILE__ ).'partials/'.$folder.'search.php');
       	}
  //      	if(!$this->is_api_enabled()):
	 //       	if( file_exists(TEMPLATEPATH.'/mybookings-light/jstemplate.php') ) {
	 //       		include(TEMPLATEPATH.'/mybookings-light/jstemplate.php');
	 //       	}else {
		// 		include(plugin_dir_path( __FILE__ ).'partials/jstemplate.php');
		// 	}
		// endif;
		$content = ob_get_clean();

		return $content;

	}

	public function search(){
		$cursym = $this->cb_hm_options('_payment_currency', '&pound;', false);
		$dateformat = isset($_POST['dateformat']) ? $_POST['dateformat'] : 'm/d/Y';
		$current_date = date('Y-m-d');
		$weekahead = date("Y-m-d", strtotime("+1 day ".date("Y-m-d") )); 
		$arrival_date = isset($_POST['checkIn']) ? $_POST['checkIn'] : $current_date;
		$departingDate = isset($_POST['checkout']) ? $_POST['checkout'] : $weekahead;

		if(strtolower($dateformat) == 'd/m/y'){
			$arrival_date = str_replace('/', '-', $arrival_date);
			$departingDate = str_replace('/', '-', $departingDate);
		}
		$arrivalDate = date('Y-m-d', strtotime($arrival_date));

		$departingDate = date('Y-m-d', strtotime($departingDate));

		$date1 = new DateTime($arrivalDate);
		$date2 = new DateTime($departingDate);

		$selected_neight = $date2->diff($date1)->format("%d");
		// var_dump($selected_neight)

		// $selected_neight = 

		// Date to Stay
		$limitdate           = date('Y-m-d', strtotime('-1 day', strtotime($departingDate)));

		$selected_apartments = isset($_POST['apartments']) ? $_POST['apartments'] : array(); 

		$today         = strtotime(date('Y-m-d', strtotime('-1 day'))); 
		$selecteddate  = strtotime($arrivalDate);

		global $wpdb;

		$custom_post_type  = $this->roomtype;
		$table = $wpdb->prefix.$this->roomratedb;

		$where = "  where bookdate = '$arrivalDate' ";

		$where .= "  and minimum_stay <= $selected_neight ";

		$where .= "  and available = '1'";

		$where .= "  and allocation > 0";

		// if(!empty($selected_apartments)){

		//     $selected_apartments_glu = implode(',', $selected_apartments);

		//     $where .= "  and post_id in ( $selected_apartments_glu )";                                                  
		// }

		// Default Values
		$min_stay = $this->cb_hm_options( '_min_stay', 1, false );
		$tax = $this->cb_hm_options( '_vat', '15', false );
		$taxincluded = $this->cb_hm_options( '_vatincluded', 'yes', false );

		// var_export($today);
		// var_export(($today - $selecteddate));
		if($selecteddate > $today){
			$select_sql = "select * from `".$table."` $where order by price"; 

			$roomrates_on_db = $wpdb->get_results($select_sql);

			if(empty($roomrates_on_db)){
				$json = array('success'=>false, 'status'=> 'error', 'message'=> 'No Rooms Found!!!');
				wp_send_json( $json );
			}
			$rooms = array();
			$ck_rooms = $result_empty = $subtotal = 0;
			foreach ($roomrates_on_db as $key => $value) {
			    $ck_rooms++;
			    $roomrate =   get_post($value->roomtype_id ); 
			    $sleeps   = $this->cb_room_sleeps($roomrate->ID);

			    $check_sql = "SELECT * from ".$table." WHERE `roomtype_id` = '$roomrate->ID' AND (`bookdate` BETWEEN '$arrivalDate' AND '$limitdate') AND ((`allocation` < `booking` OR `allocation`=`booking` ) OR (`allocation`=0) OR (`available`NOT IN('1'))) ORDER BY `bookdate` ASC LIMIT $selected_neight";
			    $check_result = $wpdb->get_results($check_sql);
			    // var_dump($check_sql);
			    if(!empty($check_result)){
			      $result_empty++; 
			    }
			    if(empty($check_result)): //Check SQL
			        $select_sql = "SELECT * from ".$table." WHERE `roomtype_id` = '$roomrate->ID' AND `bookdate` BETWEEN '$arrivalDate' AND '$limitdate' ORDER BY `bookdate` ASC LIMIT $selected_neight"; 
			        $selectedroomrates = $wpdb->get_results($select_sql);
			        $avilableroomrates = 'no';
			        $roomrates = array();
			        if(!empty($selectedroomrates)):
			            $avilableroomrates = 'yes';
			            $roomrates = array();
			            $roomtotal = 0;
			            foreach ($selectedroomrates as $room) {
			                $roomrates[] = array(
			                	'id'		=> $room->id,
			                    'date'      =>  date('Y-m-d', strtotime($room->bookdate)),
			                    'dprice'    => $cursym.''.$room->price.'x1',
			                    'price'		=> $room->price
			                );
			                $roomtotal += (float)$room->price;
			            }
			        endif;
			        if((int)$value->allocation > (int)$value->booking):
			            $quantity_sql = "SELECT `allocation` FROM `".$table."` WHERE `roomtype_id` = '$roomrate->ID' AND `bookdate` BETWEEN '$arrivalDate' AND '$limitdate' ORDER BY `allocation` ASC LIMIT 1";
			            $quantity_result = $wpdb->get_results($quantity_sql);
			            $remains = (int)$value->allocation - (int)$value->booking; 
			            if($remains > $quantity_result[0]->allocation)
			                $remains = $quantity_result[0]->allocation;

			            $price = $this->cb_post_meta($roomrate->ID, '_price', 0, true);
			            $adults = $this->cb_post_meta($roomrate->ID, '_guest', 1, true);
			            $max_adults = $this->cb_post_meta($roomrate->ID, '_max_guest', 1, true);
			            $kids = $this->cb_post_meta($roomrate->ID, '_kids', 0, true);
			            $max_kids = $this->cb_post_meta($roomrate->ID, '_max_kids', 0, true);
			            $images = $this->cb_post_meta($roomrate->ID, '_room_images', array(), true);
			            if(!empty($images))
			                $coverImage = ' style=background-image:url('.$images[0].');';
			            else
			                $coverImage = '';

			            $amenities = $this->cb_post_meta($roomrate->ID, '_amenity', array(), true);
			            if(empty($amenities))
			                $aminity = false;
			            else
			                $aminity = 'yes';

			            $aminitylist = array('ac'=>'Air Conditioning', 'internet'=>'Internet (Wi-Fi)', 'telephone'=>'Telephone', 'tv'=>'TV', 'safe'=>'Safe', 'minibar'=>'Minibar', 'kitchen'=>'Kitchen', 'work-space'=>'Work Space', 'bath'=>'Bath', 'shower'=>'Shower', 'towels'=>'Towels', 'smoking'=>'Smoking Allowed');

			            $rooms[$roomrate->ID] = array(
			                'roomid'   => $roomrate->ID,
			                'title'    => get_the_title($roomrate->ID),
			                'price'    => $price,
			                'sleeps'   => (int)$sleeps,
			                'has_roomrates' => $avilableroomrates,
			                'roomrates' => array_filter($roomrates),
			                'roomtotal' => number_format($roomtotal, 2, '.', ','),
			                'quantity'  => (int)$remains,
			                'max_adults'   => (int)$max_adults,
			                'max'   => (int)$max_adults,
			                'max_kids'      => (int)$max_kids,
			                'adults'        => (int)$adults,
			                'kids'      => (int)$kids,
			                'allocation'        => (int)$remains,
			                'min_stay'			=> (int)$min_stay,
			                'image'     => $coverImage,
			                'allow_additional'  => 'no',
			                'additional_charge_adult'   => null,
			                'additional_charge_kids'    => null,
			                'have_amenity'  => $aminity,
			                'amenities'     => array_filter($amenities),
			                'images'        => array_filter($images),
			                'description'   => $roomrate->post_content,
			                'excerpt'       => $roomrate->post_excerpt
			            );
						$subtotal += $roomtotal;
			        endif;
			    endif;  
			}
			if($taxincluded == 'yes'){
				$taxvalue = (float)$subtotal*((float)$tax/100);
				$total = (float)$subtotal+(float)$taxvalue;
			}else{
				$total = (float)$subtotal;
			}

			$data = array(
				'arrival'		=> $arrivalDate,
				'departure' 	=> $departingDate,
				'cursym'		=> $cursym,
				'selectednights'=> $selected_neight,
				'txt_available_rooms'	=> __("Available Room Options", $this->cloudbeds_hotel_management),
				'txt_room_type'	=> __("Type of Accommodation", $this->cloudbeds_hotel_management),
				'txt_max'		=> __('Max', $this->cloudbeds_hotel_management),
				'txt_price'		=> __("From", $this->cloudbeds_hotel_management),
				'txt_nights'	=> __('Night(s)', $this->cloudbeds_hotel_management),
				'txt_adults'	=> __('Adults', $this->cloudbeds_hotel_management),
				'txt_kids'		=> __('Kids', $this->cloudbeds_hotel_management),
				'txt_no_rooms'	=> __('Qty. Acom.', $this->cloudbeds_hotel_management),
				'rooms' 		=> $rooms,
				'calculated_result'	=> array(
					'subtotal'	=> number_format($subtotal, 2, '.', ','),
					'taxincluded'	=> $taxincluded,
					'tax'			=> $tax.'%',
					'total'			=> number_format($total, 2, '.', ','),
				)
			);
			$json = array('success'=>true, 'status'=> 'success', 'data'=> $data );
			wp_send_json( $json );
		}else {
			$json = array('success'=>false, 'status'=> 'error', 'message'=> 'No Room Found!!!');
			wp_send_json( $json );
		}
	}

	public function user_login(){
		$username = isset($_POST['username']) ? $_POST['username'] : '';
		$password = isset($_POST['userpass']) ? $_POST['userpass'] : '';
		if(trim($username) == ''){
			$json = array('success'=>false, 'status'=> 'error', 'message'=> 'Error! Name field is empty or invalid name given.');
			wp_send_json( $json );
		}else {

			$credentials = array();
			$credentials['user_login'] = $username;
		
			$credentials['user_password'] = $password;

			$return = wp_signon($credentials);	
			if(!empty($return->errors)){
				$data = array('success'=>false, 'status'=> 'error', 'message' => 'Invalid username or password.');		
				wp_send_json( $data );
			}else{
				$user_data = ($return->data);
				$userdata = $user = new WP_User($user_data->ID);
				wp_set_current_user($userdata->ID);

				$cuser     = get_userdata( $user_data->ID );
				$userinfo  = (array)$cuser->data;
				$userinfo['first_name'] = $userdata->first_name;
				$userinfo['last_name'] = $userdata->last_name;
				$userdata = array_map( function( $a ){ return $a[0]; }, get_user_meta( $user_data->ID ) )  ;
				// New Nonce 
				$nonce = wp_create_nonce($this->cloudbeds_hotel_management.'_place_order' );
				$userdetails = array(
					'first_name'	=> isset($userinfo['first_name']) ? $userinfo['first_name'] : '',
					'last_name'		=> isset($userinfo['last_name']) ? $userinfo['last_name'] : '',
					'user_email'	=> isset($userinfo['user_email']) ? $userinfo['user_email'] : '',
					'cb_hm_title'			=> isset($userdata['cb_hm_title']) ? $userdata['cb_hm_title'] : '',
					'cb_hm_address_1'		=> isset($userdata['cb_hm_address_1']) ? $userdata['cb_hm_address_1'] : '',
					'cb_hm_address_2'		=> isset($userdata['cb_hm_address_2']) ? $userdata['cb_hm_address_2'] : '',
					'cb_hm_address_3'		=> isset($userdata['cb_hm_address_3']) ? $userdata['cb_hm_address_3'] : '',
					'cb_hm_city'			=> isset($userdata['cb_hm_city']) ? $userdata['cb_hm_city'] : '',
					'cb_hm_state'			=> isset($userdata['cb_hm_state']) ? $userdata['cb_hm_state'] : '',
					'cb_hm_country'		=> isset($userdata['cb_hm_country']) ? $userdata['cb_hm_country'] : '',
					'cb_hm_postcode'		=> isset($userdata['cb_hm_postcode']) ? $userdata['cb_hm_postcode'] : '',
					'cb_hm_phoneday'		=> isset($userdata['cb_hm_phoneday']) ? $userdata['cb_hm_phoneday'] : '',
					'cb_hm_phonenight'	=> isset($userdata['cb_hm_phonenight']) ? $userdata['cb_hm_phonenight'] : '',
					'cb_hm_mobile'		=> isset($userdata['cb_hm_mobile']) ? $userdata['cb_hm_mobile'] : '',
					'parse'				=> $nonce,
				);
				$json = array('success'=>true, 'status'=> 'success', 'data'=> $userdetails );
				wp_send_json($json );
			}
		}
	}

	public function book_now(){
		global $wpdb;
		$table = $wpdb->prefix.$this->roomratedb;
		$cursym = $this->cb_hm_options('_payment_currency', '&pound;', false);
		$nonce = wp_create_nonce($this->cloudbeds_hotel_management.'_place_order' );
		$orderid = time();

		$calculated_result = isset($_POST['calculated_result']) ? $_POST['calculated_result'] : array();
		$rooms = isset($_POST['rooms']) ? $_POST['rooms'] : array();
		if(empty($rooms)){
			$json = array('success'=> false, 'status'=>'error', 'message'=> 'No Rooms found!!!');
			wp_send_json( $json );
		}

		$arrivalDate = isset($_POST['arrival']) ? $_POST['arrival'] : '';
		$departingDate = isset($_POST['departure']) ? $_POST['departure'] : '';
		$selected_neight = isset($_POST['selectednights']) ? $_POST['selectednights'] : '';

		$selectedrooms = array();
		$error = $subtotal = 0;
		// var_export($rooms);
		foreach ($rooms as $key => $room) {
			if((int)$room['selectedrooms'] > 0){
				// check room avilability 
				$chk_sql = "SELECT * from `".$table."` WHERE `roomtype_id` = '$key' AND available = '1' AND `allocation` > 0 AND `bookdate` BETWEEN '$arrivalDate' AND '$departingDate' ORDER BY `bookdate` ASC LIMIT $selected_neight";
				$chk_result = $wpdb->get_results($chk_sql);
				if(sizeof($chk_result) < $selected_neight ){
					$error++;
				}else {
					// $subtotal += (float)$room['roomtotal'];
					$selectedrooms[$key] = $room;
				}
			}
		}
		if($error > 0){
			$json = array('success'=> false, 'status'=> 'error', 'message'=>'Booking Timeout, Please search again.');
			// var_dump($json);exit();
			wp_send_json( $json );
		}
		// $min_stay = $this->cb_hm_options( $this->cloudbeds_hotel_management.'_min_stay', 1, false );
		$vat = $this->cb_hm_options('_vat', '15', false );
		// $taxincluded = $this->cb_hm_options( $this->cloudbeds_hotel_management.'_include_tax', 'yes', false );

		// if($taxincluded == 'yes'){
			$taxvalue = (float)str_replace(',', '', $calculated_result['subtotal'])*((float)$vat/100);
			$taxvalue = number_format($taxvalue, 2, '.', ',');
		// 	$total = (float)$subtotal+(float)$taxvalue;
		// }else{
		// 	$total = (float)$subtotal;
		// }
		// Login Check and logged user values
		$userdata     =  array();
		$userinfo     = array();
		$userloggedin = 'no';
		if(is_user_logged_in()){
			$userloggedin = 'yes';
			$current_user = wp_get_current_user(); 
			$cuser     = get_userdata( $current_user->ID );
			$userinfo  = (array)$cuser->data;
			$userinfo['first_name'] = $current_user->first_name;
			$userinfo['last_name'] = $current_user->last_name;
			$userdata = array_map( function( $a ){ return $a[0]; }, get_user_meta( $current_user->ID ) )  ;
		}
		$userdetails = array(
			'first_name'	=> isset($userinfo['first_name']) ? $userinfo['first_name'] : '',
			'last_name'		=> isset($userinfo['last_name']) ? $userinfo['last_name'] : '',
			'user_email'	=> isset($userinfo['user_email']) ? $userinfo['user_email'] : '',

			'cb_hm_title'			=> isset($userdata['cb_hm_title']) ? $userdata['cb_hm_title'] : '',
			'cb_hm_address_1'		=> isset($userdata['cb_hm_address_1']) ? $userdata['cb_hm_address_1'] : '',
			'cb_hm_address_2'		=> isset($userdata['cb_hm_address_2']) ? $userdata['cb_hm_address_2'] : '',
			'cb_hm_address_3'		=> isset($userdata['cb_hm_address_3']) ? $userdata['cb_hm_address_3'] : '',
			'cb_hm_city'			=> isset($userdata['cb_hm_city']) ? $userdata['cb_hm_city'] : '',
			'cb_hm_state'			=> isset($userdata['cb_hm_state']) ? $userdata['cb_hm_state'] : '',
			'cb_hm_country'		=> isset($userdata['cb_hm_country']) ? $userdata['cb_hm_country'] : '',
			'cb_hm_postcode'		=> isset($userdata['cb_hm_postcode']) ? $userdata['cb_hm_postcode'] : '',
			'cb_hm_phoneday'		=> isset($userdata['cb_hm_phoneday']) ? $userdata['cb_hm_phoneday'] : '',
			'cb_hm_phonenight'	=> isset($userdata['cb_hm_phonenight']) ? $userdata['cb_hm_phonenight'] : '',
			'cb_hm_mobile'		=> isset($userdata['cb_hm_mobile']) ? $userdata['cb_hm_mobile'] : '',
		);

		$data = array(
			'txt_available_rooms' => __('Booking Information', $this->cloudbeds_hotel_management),
			'txt_stay'		=> __('Your Stay', $this->cloudbeds_hotel_management),
			'txt_arriving'	=> __('Arriving', $this->cloudbeds_hotel_management),
			'txt_departing'	=> __('Departing', $this->cloudbeds_hotel_management),
			'txt_nights'	=> __('Nights', $this->cloudbeds_hotel_management),
			'txt_nights'	=> __('Nights', $this->cloudbeds_hotel_management),
			'txt_choosen_appartment'	=> __('Your chosen apartments', $this->cloudbeds_hotel_management),
			'txt_apartment'	=> __('Apartment', $this->cloudbeds_hotel_management),
			'txt_rate'		=> __('Rate', $this->cloudbeds_hotel_management),
			'txt_qty'		=> __('Qty', $this->cloudbeds_hotel_management),
			'txt_nights'		=> __('Night(s)', $this->cloudbeds_hotel_management),
			'txt_price'		=> __('Price', $this->cloudbeds_hotel_management),
			'txt_costs'		=> __('Costs', $this->cloudbeds_hotel_management),
			'txt_subtotal'		=> __('Sub-total', $this->cloudbeds_hotel_management),
			'txt_vat'		=> __('VAT', $this->cloudbeds_hotel_management),
			'txt_total_price'		=> __('Total Price', $this->cloudbeds_hotel_management),
			'txt_continue_booking'		=> __('Continue your booking', $this->cloudbeds_hotel_management),
			'txt_existing_user'		=> __('Existing User Login', $this->cloudbeds_hotel_management),
			'txt_register_new_user'		=> __('Register New Acccount', $this->cloudbeds_hotel_management),
			'txt_your_name'		=> __('Your name', $this->cloudbeds_hotel_management),
			'txt_your_first_name'		=> __('First name', $this->cloudbeds_hotel_management),
			'txt_your_last_name'		=> __('Last name', $this->cloudbeds_hotel_management),
			'txt_guest_name'		=> __('Guests Info', $this->cloudbeds_hotel_management),
			'txt_your_address'		=> __('Your address', $this->cloudbeds_hotel_management),
			'txt_contact_details'		=> __('Contact details', $this->cloudbeds_hotel_management),
			'countries'			=> $this->get_countries(),
			'nonce'				=> $nonce,
			'orderid'			=> $orderid,
			'arrival'			=> $arrivalDate,
			'departure' 		=> $departingDate,
			'arriving' 			=> date('l, jS M Y', strtotime($arrivalDate)),
			'departing' 		=> date('l, jS M Y', strtotime($departingDate)),
			'cursym'			=> $cursym,
			'selectednights'	=> $selected_neight,
			'rooms'				=> $selectedrooms,
			'userloggedin'		=> $userloggedin,
			'userinfo'			=> $userdetails,
			'calculated_result'	=> array(
				'subtotal'		=> $calculated_result['subtotal'],
				'taxincluded'	=> $calculated_result['taxincluded'],
				'tax'			=> $vat.'%',
				'taxvalue'		=> $taxvalue,
				'total'			=> $calculated_result['total'],
			)
		);
		$json = array('success'=>true, 'status'=>'success', 'data'=>$data);
		wp_send_json( $json );
	}

	public function order_booking() {
		$nonce = isset($_POST['parse']) ? $_POST['parse'] : null;
		$action = $this->cloudbeds_hotel_management.'_place_order';
		if(!$nonce || !wp_verify_nonce( $nonce, $action ) ){
			$json = array('success'=>false, 'status'=>'error', 'message'=> __('Invalid Request', $this->cloudbeds_hotel_management) );
			wp_send_json($json );
		}

	    $return = array();
	    $user_email = isset($_POST['user_email']) ? $_POST['user_email'] : '';
	    $card_type            = isset($_POST['card_type'])                ? $_POST['card_type']            : ''; 
	    $card_number          = isset($_POST['card_number'])              ? $_POST['card_number']          : ''; 
	    $card_name            = isset($_POST['card_name'])                ? $_POST['card_name']            : ''; 
	    $card_issue           = isset($_POST['card_issue'])               ? $_POST['card_issue']           : ''; 
	    $card_security        = isset($_POST['card_security'])            ? $_POST['card_security']        : ''; 

	    $card_starts_month    = isset($_POST['card_starts']) ? (isset($_POST['card_starts']['month'])) ? $_POST['card_starts']['month'] : ''     : ''; 
	    $card_starts_year     = isset($_POST['card_starts']) ? (isset($_POST['card_starts']['year']))  ? $_POST['card_starts']['year']  : ''     : ''; 

	    $card_ends_month      = isset($_POST['card_ends'])   ? (isset($_POST['card_ends']['month']))   ? $_POST['card_ends']['month']   : ''     : ''; 
	    $card_ends_year       = isset($_POST['card_ends'])   ? (isset($_POST['card_ends']['year']))    ? $_POST['card_ends']['year']    : ''     : ''; 

	    $hasuseraccount = isset($_POST['hasuseraccount']) ? $_POST['hasuseraccount'] : '';
	    $username = isset($_POST['username']) ? $_POST['username'] : '';
	    $userpass = isset($_POST['userpass']) ? $_POST['userpass'] : '';
	    $newusername = isset($_POST['user_email']) ? $_POST['user_email'] : '';
	    $password = isset($_POST['password']) ? $_POST['password'] : '';
	    $password_2 = isset($_POST['password_2']) ? $_POST['password_2'] : '';
	    $any_request = isset($_POST['any_request']) ? $_POST['any_request'] : '';
	    // $any_request          = implode(',', array($any_request))
	    $all_request = array();
	    if (is_array($any_request)) {
	        foreach($any_request as $roomid => $request) {
	            $all_request[] = '<strong>'.get_the_title($roomid).
	            ':</strong> '.$request;
	        }
	    }
	    $any_request = implode('<br/>', $all_request);

	    $user_id = 0;

	    if (is_user_logged_in()) {
	        global $current_user;
	        $user_id = $current_user ->ID;
	    } else {
	        if (!empty($hasuseraccount) || $hasuseraccount == '0') {

	            if ($hasuseraccount == '1') {
	                $return['status'] = 'error';
	                $return['message'] = __('Please login before, then try again', $this->cloudbeds_hotel_management);
	            } else {

	                // check if user password is empty ? 
	                if (empty($password) || ($password != $password_2)) {
	                    $return['status'] = 'error';
	                    $return['message'] = __('Given password and confirm password doesn\'t match or password is empty.', $this->cloudbeds_hotel_management);
	                } else {
	                    if (empty($newusername) || !is_email($user_email)) {
	                        $return['status'] = 'error';
	                        $return['message'] = __('Please give a valid email', $this->cloudbeds_hotel_management);
	                    } else {

	                        $user_id = username_exists($newusername);
	                        if (!$user_id and email_exists($user_email) == false) {
	                            $random_password = md5($password); //wp_generate_password( $length=12, $include_standard_special_chars=false );
	                            $user_id = wp_create_user($newusername, $password, $user_email);
	                            $user_id = wp_update_user(array('ID' => $user_id, 'role' => 'customer'));

	                            $creds = array();
	                            $creds['user_login'] = $newusername;
	                            $creds['user_password'] = $password;
	                            $creds['remember'] = false;
	                            $user = wp_signon($creds, false);
	                        } else {

	                            $return['status'] = 'error';
	                            $return['message'] = __('Email already exist, try with another email', $this->cloudbeds_hotel_management);


	                        }
	                    }

	                }




	            }


	        }

	    }

	    // $return['user_id'] = $user_id;
	    // we now have user_id    



		// Check if this order already executed or not
		$orderid = isset($_POST['orderid']) ? $_POST['orderid'] : null;
		$lastorder = get_user_meta( $user_id, 'cb_hm_booking_order', true );
		if($orderid == $lastorder){
			$json = array('success'=>false, 'status'=>'error', 'message'=> __('Seems like you alreay plase this order, if not then please refresh this page and try again.', $this->cloudbeds_hotel_management) );
			wp_send_json( $json );
		}

	    if ($user_id) {
	        $extra_user_info = $this->get_extra_user_info();
	        foreach($extra_user_info as $key => $row) {
	            $value = isset($_POST[$row['id']]) ? $_POST[$row['id']] : '';
	            if (!empty($value)) {
	                update_user_meta($user_id, $row['id'], $value);
	            }
	        }

	        $userinfo = array('first_name', 'last_name');
	        foreach($userinfo as $key => $row) {
	            $value = isset($_POST[$row]) ? $_POST[$row] : '';
	            if (!empty($value)) {
	                $user_id = wp_update_user(array('ID' => $user_id, $row => $value));
	            }
	        }

	        $booking_ref = 'RES-'.date('Ymd-his').
	        '-'.$user_id;

	        $roomrates = isset($_POST['roomrates']) ? $_POST['roomrates'] : array();
	        $roomratesqty = isset($_POST['roomratesqty']) ? $_POST['roomratesqty'] : '';
	        $arriving = isset($_POST['arrival']) ? date('Y-m-d H:i:s', strtotime($_POST['arrival']) ) : time();
	        $departing = isset($_POST['departure']) ? date('Y-m-d H:i:s', strtotime($_POST['departure']) ) : time();
	        $stay = isset($_POST['stay']) ? $_POST['stay'] : 0;
	        // $selectedpackaged = isset($_POST['selectedpackaged']) ? $_POST['selectedpackaged'] : array();
	        $booking_ref_exits = isset($_POST['booking_ref_exits']) ? $_POST['booking_ref_exits'] : '';

	        $adults = isset($_POST['adults']) ? $_POST['adults'] : 1;
	        $kids = isset($_POST['kids']) ? $_POST['kids'] : 0;

	        if ($booking_ref_exits != '') {
	            $booking_ref = $booking_ref_exits;
	        }

	        global $wpdb, $current_user;
	        $roomtable = $wpdb->prefix.$this->roomratedb;
	        $booktable = $wpdb->prefix.$this->bookingtable;

	        // var_export($roomrates);exit(0);

	        foreach($roomrates as $key => $row) {
                $roomrates_id = (int) $row;
                $roomquantity = isset($roomratesqty[$roomrates_id]) ? $roomratesqty[$roomrates_id] : 1;
                // var_export($roomrates_id);

                $price = $exist = $roomtype_id = -1;


                // get if given roomrates exist 
                $results = $wpdb ->get_results("SELECT * FROM ".$roomtable.
                    " WHERE id = $roomrates_id");

                if (!empty($results) && isset($results[0])) {
                    $price = (float) $results[0] ->price;
                    $qtprice = (float)($results[0] ->price * (int) $roomquantity);
                    $roomtype_id = $results[0] ->roomtype_id;
                    // $packagetotal = 0;
                    // $exist = 1;
                    // $packagelist = array();
                    // if (array_key_exists($roomtype_id, $selectedpackaged)) {
                    //     $packagelist = (array) $selectedpackaged[$roomtype_id];
                    //     // foreach ($packagelist as $packageID) {
                    //     //   $packagetotal += (float)omget_post_meta( 'packages',$packageID,'_price','',true,false );
                    //     // }
                    // }
                }

                $guest = isset($_POST['guests']) ? $_POST['guests'] : '';
                $guests = array();
                if (is_array($guest)):
                    foreach($guest as $id => $values) {
                        if (!empty($values))
                            $values = array_filter($values); // Remove empty values;
                        $guests[] = '<strong>'.get_the_title($id).
                        ':</strong> '.implode(',', (array) $values);
                    }
                endif;
                $guests = implode('<br/>', (array) $guests);

                // Kids
                // Adults
                $adult = $adults[$roomtype_id];
                $kid = $kids[$roomtype_id];

                if ($exist && $roomtype_id) { // room rates exist - not invalid 
                    // $packagelist = array_filter($packagelist);
                    // $packagelist = implode(',', $packagelist);
                    $packagelist = '';
                    $product_type = $this->roomtype;
                    $ordertime = date('Y-m-d H:i:s');
                    $store = array(
                        'booking_ref' => $booking_ref,
                        'user_id' => $user_id,
                        'roomtype_id' => $roomtype_id,
                        'roomquantity' => $roomquantity,
                        'price' => $price
                    );
                    $sql = "  insert into ".$booktable.
                    "  (
                        `id`,
                        `booking_ref`,
                        `user_id`,
                        `roomtype_id`,
                        `rate_id`,
                        `packages`,
                        `roomquantity`,
                        `price`,
                        `qtprice`,
                        `adults`,
                        `kids`,
                        `status`,
                        `product_type`,
                        `card_type`,
                        `card_number`,
                        `card_name`,
                        `card_issue`,
                        `card_security`,
                        `card_starts_month`,
                        `card_starts_year`,
                        `card_ends_month`,
                        `card_ends_year`,
                        `arriving`,
                        `departing`,
                        `stay`,
                        `order_time`,
                        `any_request`,
                        `guests`
                    )
                    VALUES(
                        NULL, '$booking_ref', '$user_id', '$roomtype_id', '$roomrates_id', '$packagelist', '$roomquantity', '$price', '$qtprice', '$adult', '$kid', '0', '$product_type', '$card_type', '$card_number', '$card_name', '$card_issue', '$card_security', '$card_starts_month', '$card_starts_year', '$card_ends_month', '$card_ends_year', '$arriving', '$departing', '$stay', '$ordertime', '$any_request', '$guests'
                    )
                    ";
                    if ($booking_ref_exits != '') {
                        $sql = "UPDATE `".$booktable.
                        "` SET 
                        `product_type` = '$product_type',
                        `card_type` = '$card_type',
                        `card_number` = '$card_number',
                        `card_name` = '$card_name',
                        `card_issue` = '$card_issue',
                        `card_security` = '$card_security',
                        `card_starts_month` = '$card_starts_month',
                        `card_starts_year` = '$card_starts_year',
                        `card_ends_month` = '$card_ends_month',
                        `card_ends_year` = '$card_ends_year',
                        `order_time` = '$ordertime',
                        `any_request` = '$any_request',
                        `guests` = '$guests'
                        WHERE
                            `booking_ref` = '$booking_ref_exits'
                        AND
                            `roomtype_id` = '$roomtype_id'
                        ";
                        // var_export($sql);
                    }
                    $success = $wpdb ->query($sql);
                    // Update Roomrates table
                    // $ratesqul = "UPDATE `" .$wpdb->prefix."roomrates` SET 
                    if($success):
                    	$cb_hm_booking_order = get_user_meta( $user_id, 'cb_hm_booking_order', false );
			            if(empty($cb_hm_booking_order))
			            	add_user_meta( $user_id, 'cb_hm_booking_order', $nonce );
			           	else
			           		update_user_meta( $user_id, 'cb_hm_booking_order', $nonce );
                    endif;

                }

            } 
	        $bookinginfo = $this->generate_booking_info($booking_ref);
	        // Prepair Form Data
	        $formdata = array();
	        $extra_user_info = $this->get_extra_user_info();
	        foreach($extra_user_info as $key => $row) {
	            $formdata[$row['id']] = get_user_meta( $user_id, $row['id'], true );
	        }
	        $formdata['first_name'] = $current_user->first_name;
	        $formdata['last_name'] = $current_user->last_name;
	        $formdata['user_email'] = $current_user->user_email;
	        $formdata['guests'] = $guests;
	    }
	    if(empty($return)){
	    	$reservation_policy = __($this->cb_hm_options('_reservation_policy', '', false ), $this->cloudbeds_hotel_management);

	    	$nonce = wp_create_nonce($this->cloudbeds_hotel_management.'_place_order');
	    	$json = array("success"=>true, 'status'=>'success', 'parse'=>$nonce, 'data'=>$booking_ref, 'policy'=> $reservation_policy, 'formdata'=>$formdata, 'title'=> __('Reservation Policy', $this->cloudbeds_hotel_management));
	    }else {
	    	$json = array('success'=>false, 'status'=> $return['status'], 'message'=>$return['message']);
	    }
	    wp_send_json( $json );
	}

	public function generate_booking_info($reference_id = 0, $showtext = false, $showprint = false){
		global $wpdb;
		// $reference_id = isset($_GET['ref']) ? $_GET['ref'] : '';
		// $showtext = true;
		// $showprint = false;

		$return = array();
		$booktable       = $wpdb->prefix.$this->bookingtable;
		$roomratestable  = $wpdb->prefix.$this->roomratedb;

		$cursym = $this->cb_hm_options('_payment_currency', '&pound;', false);

		$results = $wpdb->get_results( "SELECT * FROM $booktable WHERE booking_ref = '$reference_id'" );
		// var_dump($results);exit();
		if(!empty($results) && isset($results[0])){
		      // var_dump($results);exit(0);
		      $cardtypes = array("Visa", "Mastercard", "Maestro", "American Express");
		      $cardtype  = in_array($results[0]->card_type, $cardtypes) ? $results[0]->card_type : 'N/A';
		      $user_id   = $results[0]->user_id;

		      $userdata = get_user_meta( $user_id );
		      $user = get_user_by('id', $user_id );
		      $all_meta_for_user = array_map( function( $a ){ return $a[0]; }, get_user_meta( $user_id ) )  ;  

		      $mailbody = '';
		      $return = '';
		      // if($showprint):
		        // $return .= '<a href="javascript:void(0)" class="thankprint btnaprint btn btn-default">Print Page</a>';
		      // endif;
		      $return = array(
		      	'showprint'	=> $showprint,
		      	'ref_id'	=> $reference_id,
		      	'arriving'	=> date('l, jS M Y' , strtotime($results[0]->arriving) ),
		      	'departing'	=> date('l, jS M Y' , strtotime($results[0]->departing) ),
		      	'nights'	=> $results[0]->stay,
		      );
		      // $return .= '<div id="bookOrder" class="normalwhitebg">
		      //                 <div class="row"> 
		      //                     <div class="col-md-6"> 
		      //                           <h2 class="subtitle">Booking </h2>
		      //                           <table class="booktable"><tr><td class="strong">Reference </td><td>'.$reference_id.'</td></tr></table>

		      //                           <h2 class="subtitle">Stay </h2> 
		      //                           <table class="booktable">
		      //                               <tr><td class="strong">Arriving</td><td>'. date('l, jS M Y' , strtotime($results[0]->arriving) ) .'</td></tr>
		      //                               <tr><td class="strong">Departing</td><td>'. date('l, jS M Y' , strtotime($results[0]->departing) ) .'</td></tr>
		      //                               <tr><td class="strong">Nights</td><td>'.  $results[0]->stay  .'</td></tr>
		      //                           </table>



		      //                           <h2 class="subtitle">Your Chosen Apartments </h2>
		      //                           <table class="booktable">
		      //                              <tr>
		      //                                <th class="strong">Apartment</th>
		      //                                <th class="strong text-right">Each</th>
		      //                                <th class="strong text-center">Qty</th>
		      //                                <th class="strong text-center">Nights</th>
		      //                                <th class="strong text-right">Price</th>
		      //                             </tr>';

		                                  $gtotal = 0;
		                                  $subtotal = 0;
		                                  $vat      = $this->cb_hm_options('_vat','15',false);
		                                  // $packages = array();
		                                  $return['bookinginfo'] = array();

		                                  foreach ($results as $k => $v) {
		                                     // $subtotal += (float)$v->qtprice * (int)$results[0]->stay;
		                                     $subtotal += (float)$v->qtprice * 1;
		                                      /*'.$results[0]->stay.' */
		                                      // Get Date
		                                      $ratesql = "SELECT * FROM `".$roomratestable."` WHERE `id`='".$v->rate_id."'";
		                                      $ratedate = '';
		                                      $getrates = $wpdb->get_results($ratesql);
		                                      if(!empty($getrates)){
		                                        $ratedate = date('l, jS M Y', strtotime($getrates[0]->bookdate));
		                                      }
		                                     $return['bookinginfo'][] = array(
		                                     	'appartment'	=> get_the_title( $v->roomtype_id ),
		                                     	'ratedate'	=> $ratedate,
		                                     	'each'	=> $cursym .' '.  $this->money_format("%i",  $v->price ),
		                                     	'qty'	=> $v->roomquantity,
		                                     	'nights'	=> 1,
		                                     	'price'		=> $cursym .' '.  $this->money_format("%i", ( (float)$v->qtprice ) ),
		                                     	'aminities'	=> $this->cb_post_meta($v->roomtype_id, '_aminity', array(), true)


		                                     );
		                                     // $return .= '<tr>
		                                     //                <td> '. get_the_title( $v->roomtype_id ) .' <br/>('.$ratedate.') </td>
		                                     //                <td class="text-right pricetd">'. $cursym .' '.  money_format("%i",  $v->price ).'</td>
		                                     //                <td class="text-center"> '. $v->roomquantity.'</td>
		                                     //                <td class="text-center">1</td>
		                                     //                <td class="text-right pricetd">'. $cursym .' '.  money_format("%i", ( (float)$v->qtprice ) ).'</td>
		                                     //            </tr>';
		                                     // $return .= '<tr>
		                                     //                <td> '. get_the_title( $v->roomtype_id ) .' <br/>('.$ratedate.') </td>
		                                     //                <td class="text-right pricetd">'. $cursym .' '.  $v->price.'</td>
		                                     //                <td class="text-center"> '. $v->roomquantity.'</td>
		                                     //                <td class="text-center">1</td>
		                                     //                <td class="text-right pricetd">'. $cursym .' '.  $v->qtprice.'</td>
		                                     //            </tr>';

		                                      // Email template
		                                      $mailbody .='<tr><td></td><td>'. $v->roomtype_id.'</td><td>'. $v->roomquantity.'</td></tr>';

		                                      // $packages[] = array(
		                                      //   'room_id' => $v->roomtype_id,
		                                      //   'packages'=> $v->packages,
		                                      //   'id'      => $v->id
		                                      // );
		                                      // if($packages !=''):
		                                      //   $packages = explode(',', $packages);
		                                      //   if(!empty($packages)){
		                                      //     $return .='<tr class="noborder"><td colspan="5"><div class="packagetable"><table><thead><tr><th colspan="3">Package Title</th><th>Qty</th><th style="text-align:right">Price</th></tr></thead><tbody>';
		                                      //     foreach ($packages as $packageID) {
		                                      //         $return .= '<tr>';
		                                      //         $return .= '<td colspan="3">'.get_the_title($packageID ).'</td>';
		                                      //         $return .= '<td>1</td>';
		                                      //         $return .= '<td style="text-align:right">'.$cursym.' '.omget_post_meta('packages', $packageID, '_price', '', true, false).'</td>';
		                                      //         $return .= '</tr>';
		                                      //         $packagetotal += (float)omget_post_meta('packages', $packageID, '_price', '', true, false);
		                                      //         $mailbody .= '<tr><td colspan="2">Package: <strong>'.get_the_title($packageID ).' For: '.get_the_title($v->roomtype_id).'</strong></td><td> Price:'.$cursym.' '.omget_post_meta('packages', $packageID, '_price', '', true, false).'</td></tr>';
		                                      //     } 
		                                      //     $return .='</tbody></table></div></td></tr>';
		                                      //   }
		                                      // endif;
		                                      // $subtotal += $packagetotal;
		                                  }
		                                  // $packages = array_filter($packages);
		                                  // var_export($packages);
		                                  // $packagetotal = 0;
		                                  // $filterlist = array();
		                                  // if(!empty($packages)):
		                                  //   $return .='<tr><td colspan="5"><table class="table packageTable"><thead><tr><th>Package Information</th><th>Price</th></tr></thead><tbody>';
		                                  //   foreach ($packages as $package) {
		                                  //     $packageroom = $package['room_id'];
		                                  //     $packagelist = $package['packages'];
		                                  //     $packagelist = explode(',', $packagelist);
		                                  //     $packagelist = array_filter($packagelist);
		                                  //     if(!in_array($packageroom, $filterlist)){
		                                  //       $filterlist[] = $packageroom;
		                                  //       if(!empty($packagelist)):
		                                  //         foreach ($packagelist as $packageID) {
		                                  //           $return .= '<tr>';
		                                  //           $return .= '<td><strong>'.get_the_title($packageID).' For: '.get_the_title($packageroom ).'</strong></td>';
		                                  //           $packageprice = omget_post_meta('packages', $packageID, '_price', '', true, false);
		                                  //           $return .= '<td>'.$cursym.' '.$packageprice.'</td>';
		                                  //           $return .= '</tr>';
		                                  //           $packagetotal += (float)$packageprice;
		                                  //         }
		                                  //       endif;
		                                  //     }
		                                  //   }
		                                  //   $subtotal += $packagetotal;
		                                  //   $return .='</tbody></table></td></tr>';
		                                  // endif;   
		                                // $return .= '</table><h2 class="subtitle">Cost  </h2>';
		                                $return['subtotal'] = $cursym .' '.$this->money_format("%i", $subtotal);
		                                $return['vat'] = $vat;
		                                $return['vattotal'] = $cursym .' '.$this->money_format("%i", (float)$subtotal * ($vat / 100) );
		                                $return['total'] = $cursym .' '. $this->money_format("%i", (float)  $subtotal + $subtotal * ($vat / 100));

		                                // $return .= '
		                                // <table class="booktable">
		                                //     <tr><td class="strong"> Sub-total </td><td class="text-right pricetd">'. $cursym .' '.money_format("%i", $subtotal).'</td></tr>
		                                //     <tr><td class="strong"> VAT ('. $vat.'%)  </td><td class="text-right pricetd"> '. $cursym .' '.money_format("%i", (float)   $subtotal * ($vat / 100) ).' </td></tr>
		                                //     <tr><td class="strong"> Total Price  </td><td class="text-right pricetd">'. $cursym .' '. money_format("%i", (float)  $subtotal + $subtotal * ($vat / 100)).'</td></tr> 
		                                // </table>';
		                                // $return .= '
		                                // <table class="booktable">
		                                //     <tr><td class="strong"> Sub-total </td><td class="text-right pricetd">'. $cursym .' '.$subtotal.'</td></tr>
		                                //     <tr><td class="strong"> VAT ('. $vat.'%)  </td><td class="text-right pricetd"> '. $cursym .' '.(float)($subtotal * ($vat / 100) ).' </td></tr>
		                                //     <tr><td class="strong"> Total Price  </td><td class="text-right pricetd">'. $cursym .' '. (float)( $subtotal + $subtotal * ($vat / 100)).'</td></tr> 
		                                // </table>';
		      if($showtext): 
		      		$return['thankyoutxt'] = $this->cb_hm_options('_thankyou_text', '', false);
		                                // $return .= '<div class="customthanks clearfix">
		                                //   '.cb_hm_options('_thankyou_text', '', false).'
		                                // </div>';
		      endif;
		      		$return['name'] = ucfirst( $all_meta_for_user['res_title'] ) .' '. ucfirst( $all_meta_for_user['first_name'] ).' '.$all_meta_for_user['last_name'];

		      		$address = (!empty($all_meta_for_user['cb_hm_address_1'])) ? $all_meta_for_user['cb_hm_address_1'] . '<br />' : '';
                   	$address .= (!empty($all_meta_for_user['cb_hm_address_2'])) ? $all_meta_for_user['cb_hm_address_2'] . '<br />' : '';
                   	$address .= (!empty($all_meta_for_user['cb_hm_address_3'])) ? $all_meta_for_user['cb_hm_address_3'] . '<br />' : '';

                   	$return['address'] = $address;

                   	// $user = wp_get_current_user();
                   	// var_export($user->roles);
                  	// if($user->roles[0] == 'administrator' || $user->roles[0] == 'reception'){
                   //  	$cardnumber = $results[0]->card_number;
                   //  	$user = get_user_by('id', $results[0]->user_id);
                   // 	}else {
                   //  	$cardnumber = '**** **** **** '.substr($results[0]->card_number, -4);
                   // 	}

		                           // $return .= '</div>
		                           // <div class="col-md-6"> 
		 
		                           //      <h2 class="subtitle">Contact Details</h2>
		                           //      <table class="booktable">
		                           //          <tr><td class="strong">Name</td><td>'.ucfirst( $all_meta_for_user['res_title'] ) .' '. ucfirst( $all_meta_for_user['first_name'] ).' '.$all_meta_for_user['last_name'].'</td></tr>
		                           //            <tr><td valign="top" class="strong">Address</td><td>';
		                            
		            $return['city']	= $all_meta_for_user['cb_hm_city'];
		            $return['state']	= $all_meta_for_user['cb_hm_state'];
		            $return['postcode']	= $all_meta_for_user['cb_hm_postcode'];
		            $return['country']	= $all_meta_for_user['cb_hm_country'];
		            $return['phoneday']	= $all_meta_for_user['cb_hm_phoneday'];
		            $return['phonenight']	= $all_meta_for_user['cb_hm_phonenight'];
		            $return['mobile']	= $all_meta_for_user['cb_hm_mobile'];
		            $return['email']	= $user->user_email;
		            $return['guests']	= $results[0]->guests;
		            $return['request']	= $results[0]->any_request;


		        //                    $return .= ''.$all_meta_for_user['res_city'].', '.$all_meta_for_user['res_state'].' - '.$all_meta_for_user['res_postcode'].'<br />'.$all_meta_for_user['res_country'].'</td></tr>
		        //                             <tr><td class="strong">Phone (daytime)</td><td>'.$all_meta_for_user['res_phone_day'].'</td></tr>
		        //                             <tr><td class="strong"> Phone (evening)</td><td>'.$all_meta_for_user['res_phone_evening'].'</td></tr>
		        //                             <tr><td class="strong">Mobile</td><td>'.$all_meta_for_user['res_mobile'].'</td></tr>
		        //                             <tr><td class="strong">Email Address</td><td><a href="mailto:'.$user->user_email.'">'.$user->user_email.'</a></td></tr>
		        //                             <tr><td class="strong">Guests</td><td>'.$results[0]->guests.'</td></tr>
		        //                             <tr><td class="strong">Special Notes</td><td>'.$results[0]->any_request.'</td></tr>
		        //                         </table>
		                           


		        //                         <h2 class="subtitle">Payment Details</h2>
		        //                         <table class="booktable">
		        //                             <tr><td class="strong"> Card type</td><td>'.$cardtype.'</td></tr>
		        //                             <tr><td class="strong"> Card Number </td><td>'.$cardnumber.'</td></tr>
		        //                             <tr><td class="strong"> Name on Card </td><td>'.$results[0]->card_name.'</td></tr>
		        //                             <tr><td class="strong"> Start date </td><td>'.str_pad($results[0]->card_starts_month, 2, '0', STR_PAD_LEFT)  .'/'.str_pad($results[0]->card_starts_year, 2, '0', STR_PAD_LEFT) .'</td></tr>
		        //                             <tr><td class="strong"> Expiry Date </td><td>'.str_pad($results[0]->card_ends_month, 2, '0', STR_PAD_LEFT).'/'.str_pad($results[0]->card_ends_year, 2, '0', STR_PAD_LEFT) .'</td></tr>
		        //                             <tr><td class="strong"> Security Code </td><td>'.$results[0]->card_security.'</td></tr>
		        //                             <tr><td class="strong"> Issue Number </td><td>'.$results[0]->card_issue.'</td></tr>
		        //                         </table>
		                                  
		                                  
		        //                         <p><small>Note: All prices shown are for the entire '.$results[0]->stay.' night stay</small>
		        //                   </div>
		        //           </div>
		        //      </div>

		        // '  ;

		        
		}
		return $return;
	}
	public function confirm_booking(){
	   $return = array();
	   $return['success'] = false;
	   $booking_ref = isset($_POST['booking_ref']) ? $_POST['booking_ref']  : '';
	    
	    global $wpdb;
	    $booktable       = $wpdb->prefix.$this->bookingtable;
		$roomratestable  = $wpdb->prefix.$this->roomratedb;
	    
	    $results = $wpdb->get_results( "SELECT id FROM $booktable WHERE `booking_ref` = '$booking_ref'" );
	    if(!empty($results)){

	                   $update_sql = "UPDATE $booktable SET status = '1' WHERE `booking_ref` = '$booking_ref'";

	                   $success = $wpdb->query( $update_sql ); 
	                   // update booking in roomrates table 
	                    foreach ($results as $result) {
	                      $bookdate = date('Y-m-d',strtotime($result->arriving));
	                      $roomid = $result->roomtype_id;
	                      $getremains = $wpdb->get_results( "SELECT * FROM $roomratestable WHERE `roomtype_id` = '$roomid' AND `bookdate`='$bookdate'" );
	                      if(!empty($getremains) && isset($getremains[0])){
	                        $booked = (int)$getremains[0]->booking + (int)$result->roomquantity;
	                        $available = (int)$getremains[0]->available;
	                        if((int)$booked == (int)$getremains[0]->allocation) {
	                          $available = 0; 
	                        }
	                        $now = date('Y-m-d h:i:s');
	                         $roomrates_sql = "
	                            UPDATE $roomratestable 
	                            SET `available` = '".$available."',
	                            `booking` = '$booked',  
	                            `update_time` = '$now'
	                            WHERE `roomtype_id` = '$roomid'
	                            AND `bookdate` = '$bookdate'
	                            ";

	                         $response = $wpdb->query( $roomrates_sql ); 
	                      }
	                    }

	                   if($success){ 
	                   
							$return['success']  = true;
							$mailsent = $this->generate_email_template($booking_ref);
							if(!$mailsent)
								$return['mailsent'] = 'Failed To send mail. Please Print This page for your referance.';

							$return['message'] = $this->get_thanks_message($booking_ref);
	                    }else{

	                        $return['message'] = 'Error ! Confirming your order, try again';
	                    }



	    }else{  
	         $return['message'] = 'Invalid Booking Reference ID';
	    }
	   
	    echo json_encode( $return);
	    exit(0);
	}

	private function is_api_enabled(){
		$api_enabled = $this->cb_hm_options('_using_cb_api','no', false );
		if($api_enabled == 'yes')
			return true;
		else
			return false;
	}

	public function cloudbeds_ajax(){
		$dateformat = isset($_POST['dateformat']) ? $_POST['dateformat'] : 'm/d/Y';
	    $datefrom = isset($_POST['datefrom']) ? $_POST['datefrom'] : 0;
	    $dateto = isset($_POST['dateto']) ? $_POST['dateto'] : 0;

	    $datefrom = !empty($datefrom) ? $datefrom : date($dateformat);
	    $dateto = !empty($dateto) ? $dateto : date($dateformat, strtotime('tomorrow'));

	    // Prepair Hotel Details
	    $additional_photos = array();
	    $hotel_images = array_filter($this->cb_hm_options('_images', array() ));
	    // $hotel_images = get_option($this->cloudbeds_hotel_management . '_images', true);
	    // var_dump($hotel_images);exit();
	    if(!empty($hotel_images)){
			$hotelimage = wp_get_attachment_image_src($hotel_images[0], array(220,148) );
		}else {
			$hotelimage = false;
		}
		foreach ($hotel_images as $imgid) {
			$image = wp_get_attachment_image_src($imgid, 'full' );
			$additional_photos[] = $image[0];
		}
		$amenity = $this->cb_hm_options('_amenity','' );
		$listamenities = array();
		foreach ($this->amenities as $key => $value) {
			if(array_key_exists($key, $amenity)){
				$listamenities[] = $value;
			}
		}
		$selectedcountry = $this->cb_hm_options('_country', 'BR' );
		$api_enabled = $this->cb_hm_options('_using_cb_api','no', false );

		if($this->cb_hm_options('_late_checkout_type','percent' ) == 'percent'):
			$late_checkout_val = $this->cb_hm_options('_late_checkout_val','' ).'% of room rate';
		else:
			if($this->cb_hm_options('_currency_position', 'before') == 'before')
				$late_checkout_val = $this->cb_hm_options('_payment_currency', '&pound;').number_format($this->cb_hm_options('_late_checkout_val','' ), 2, '.', ',');
			else 
				$late_checkout_val = number_format($this->cb_hm_options('_late_checkout_val','' ), 2, '.', ',').$this->cb_hm_options('_payment_currency', '&pound;');
		endif;

		// 'deposit_type' => $this->cb_hm_options('_deposit_type', 'fixed'),
		// 'deposit_percent' => $this->cb_hm_options('_deposit_percent', ''),
		// 'deposit_fixed' => $this->cb_hm_options('_deposit_fixed', ''),

	    $hotel = array(
	    	'name'				=> $this->cb_hm_options('_propertyname', '' ),
	    	'description'		=> $this->cb_hm_options('_propertydescription', '' ),
	    	'image'				=> $hotelimage[0],
	    	'phone'				=> $this->cb_hm_options('_phone', '' ),
	    	'email'				=> $this->cb_hm_options('_email', '' ),
	    	'facebook'			=> $this->cb_hm_options('_facebook', '' ),
	    	'currency'			=> array(
				'code'		=> $this->cb_hm_options('_currency_code','' ),
				'symbol'	=> $this->cb_hm_options('_payment_currency', '&pound;'),
				'name'		=> $this->cb_hm_options('_currency_name', ''),
				'position'	=> $this->cb_hm_options('_currency_position', 'before'),
			),
	    	'address'			=> array(
	    			'number'	=> $this->cb_hm_options('_address1', '' ),
	    			'street'	=> $this->cb_hm_options('_address2', '' ),
	    			'city'		=> $this->cb_hm_options('_city', '' ),
	    			'state'		=> $this->cb_hm_options('_state', '' ),
	    			'zip'		=> $this->cb_hm_options('_state', '' ),
	    			'lat'		=> $this->cb_hm_options('_lat', '' ),
	    			'lng'		=> $this->cb_hm_options('_lng', '' ),
	    			'country'	=> $this->get_countries($selectedcountry),
	    		),
	    	'additional_photos'	=> $additional_photos,
	    	'map_link'			=> $this->cb_hm_options('_maplink', '' ),
	    	'amenities'			=> $listamenities,
	    	'policy'			=> array(
	    			'deposit_type' => '',
					'deposit_percent' => '',
					'deposit_fixed' => '',
					'custom_cancellation_policy' => $this->cb_hm_options('_custom_cancelllation_policy', ''),
					'cancellation_policy_allowed' => $this->cb_hm_options('_cancellation_policy_allowed', 'no'),
					'terms_full_charge_allowed' => $this->cb_hm_options('_terms_full_charge_allowed', 'no'),
					'terms_full_charge_cancellation_days' => $this->cb_hm_options('_terms_full_charge_cancellation_days', '1'),
					'terms_partial_charge_allowed' => $this->cb_hm_options('_terms_partial_charge_allowed', 'yes'),
					'terms_partial_charge_type' => $this->cb_hm_options('_terms_partial_charge_type', 'percent'),
					'terms_partial_amount' => $this->cb_hm_options('_terms_partial_amount', '20'),
					'terms_partial_charge_cancellation_days' => $this->cb_hm_options('_terms_partial_charge_cancellation_days', '2'),
					'checkin' => $this->cb_hm_options('_checkin', '' ),
					'checkout' => $this->cb_hm_options('_checkout', '' ),
					'late_checkout_allowed' => $this->cb_hm_options('_late_checkout_allowed','no' ),
					'late_checkout_hour' => $this->cb_hm_options('_late_checkout_hour','' ),
					'late_checkout_type' => $this->cb_hm_options('_late_checkout_type','percent' ),
					'late_checkout_val' => $late_checkout_val,
					'terms_and_conditions' => $this->cb_hm_options('_reservation_policy', '' ),
	    		),
	    );
		
		// $hotel = $data['hotel'];
        $template_file = 'propertydetails.php';
        $currency = $hotel['currency'];
        $isapi = 'no';
		if( file_exists(TEMPLATEPATH.'/mybookings-light/'. $template_file) ) {
			include TEMPLATEPATH . '/mybookings-light/' . $template_file;
		} else {
			include(plugin_dir_path( __FILE__ ) .'partials/'. $template_file);
		}
		exit(0);
	}

	public function cloudbeds_checkroomavailability(){

	    $cursym = $this->cb_hm_options('_payment_currency', '$', false);
		$dateformat = isset($_POST['date_format_DP']) ? $_POST['date_format_DP'] : 'm/d/Y';
		$current_date = date('Y-m-d');
		$weekahead = date("Y-m-d", strtotime("+1 day ".date("Y-m-d") )); 

		$arrival_date = isset($_POST['search_start_date']) ? $_POST['search_start_date'] : $current_date;
		$departingDate = isset($_POST['search_end_date']) ? $_POST['search_end_date'] : $weekahead;

		$rooms 	= isset($_POST['rooms']) ? $_POST['rooms'] : '';
	    $adults = isset($_POST['adults']) ? $_POST['adults'] : '';
	    $kids 	= isset($_POST['kids']) ? $_POST['kids'] : '';
	    $lang 	= isset($_POST['lang']) ? $_POST['lang'] : $lang;

		if(strtolower($dateformat) == 'd/m/y'){
			$arrival_date = str_replace('/', '-', $arrival_date);
			$departingDate = str_replace('/', '-', $departingDate);
		}
		$arrivalDate = date('Y-m-d', strtotime($arrival_date));
		$departingDate = date('Y-m-d', strtotime($departingDate));
		// var_dump($departingDate);


		$date1 = new DateTime($arrivalDate);
		$date2 = new DateTime($departingDate);

		$selected_neight = $date2->diff($date1)->format("%d");
		// var_dump($selected_neight);

		// $selected_neight = 

		// Date to Stay
		$limitdate           = date('Y-m-d', strtotime('-1 day', strtotime($departingDate)));

		$selected_apartments = isset($_POST['apartments']) ? $_POST['apartments'] : array(); 

		$today         = strtotime(date('Y-m-d', strtotime('-1 day'))); 
		$selecteddate  = strtotime($arrivalDate);

		global $wpdb;

		$custom_post_type  = $this->roomtype;
		$table = $wpdb->prefix.$this->roomratedb;

		$where = "  where bookdate = '$arrivalDate' ";

		$where .= "  and minimum_stay <= $selected_neight ";

		$where .= "  and available = '1'";

		$where .= "  and allocation > 0";

		// if(!empty($selected_apartments)){

		//     $selected_apartments_glu = implode(',', $selected_apartments);

		//     $where .= "  and post_id in ( $selected_apartments_glu )";                                                  
		// }

		// Default Values
		$min_stay = $this->cb_hm_options( '_min_stay', 1, false );
		$tax = $this->cb_hm_options( '_vat', '15', false );
		$taxincluded = $this->cb_hm_options( '_vatincluded', 'yes', false );

		// var_export($today);
		// var_export(($today - $selecteddate));
		if($selecteddate > $today){
			$select_sql = "select * from `".$table."` $where order by price"; 

			$roomrates_on_db = $wpdb->get_results($select_sql);

			if(empty($roomrates_on_db)){
				$json = array('success'=>false, 'status'=> 'error', 'message'=> 'No Rooms Found!!!');
				wp_send_json( $json );
			}
			$rooms = array();
			$ck_rooms = $result_empty = $subtotal = $totalrooms = 0;
			foreach ($roomrates_on_db as $key => $value) {
			    $ck_rooms++;
			    $roomrate =   get_post($value->roomtype_id ); 
			    $sleeps   = $this->cb_room_sleeps($roomrate->ID);

			    $check_sql = "SELECT * from ".$table." WHERE `roomtype_id` = '$roomrate->ID' AND (`bookdate` BETWEEN '$arrivalDate' AND '$limitdate') AND ((`allocation` < `booking` OR `allocation`=`booking` ) OR (`allocation`=0) OR (`available`NOT IN('1'))) ORDER BY `bookdate` ASC LIMIT $selected_neight";
			    $check_result = $wpdb->get_results($check_sql);
			    // var_dump($check_sql);
			    if(!empty($check_result)){
			      $result_empty++; 
			    }
			    if(empty($check_result)): //Check SQL
			        $select_sql = "SELECT * from ".$table." WHERE `roomtype_id` = '$roomrate->ID' AND `bookdate` BETWEEN '$arrivalDate' AND '$limitdate' ORDER BY `bookdate` ASC LIMIT $selected_neight"; 
			        $selectedroomrates = $wpdb->get_results($select_sql);
			        $avilableroomrates = 'no';
			        $roomrates = array();
			        $ratemin = $ratemax = $ratebasic = 0;
			        if(!empty($selectedroomrates)):
			            $avilableroomrates = 'yes';
			            $roomrates = array();
			            $roomtotal = 0;
			            $minimumnights = 31;
			            $ratemin = (int)$selectedroomrates[0]->price;
			            foreach ($selectedroomrates as $room) {
			            	$date = date('Y-m-d', strtotime($room->bookdate));
			                $roomrates[$date] = array(
			                	'id'			=> $room->id,
			                    'date'      	=>  $date,
			                    'dprice'    	=> $cursym.''.$room->price.'x1',
			                    'rate'			=> $room->price
			                );

			                if($minimumnights > $room->minimum_stay)
			                	$minimumnights = $room->minimum_stay;

			                if((int)$room->price > $ratemax){
			                	$ratemax = (int)$room->price;
			                }
			                if((int)$room->price < $ratemin){
			                	$ratemin = (int)$room->price;
			                }
			                $roomtotal += (float)$room->price;
			            }
			            $ratebasic = $roomtotal;
			        endif;
			        if((int)$value->allocation > (int)$value->booking):
			            $quantity_sql = "SELECT `allocation` FROM `".$table."` WHERE `roomtype_id` = '$roomrate->ID' AND `bookdate` BETWEEN '$arrivalDate' AND '$limitdate' ORDER BY `allocation` ASC LIMIT 1";
			            $quantity_result = $wpdb->get_results($quantity_sql);
			            $remains = (int)$value->allocation - (int)$value->booking; 
			            if($remains > $quantity_result[0]->allocation)
			                $remains = $quantity_result[0]->allocation;

			            $price = $this->cb_post_meta($roomrate->ID, '_price', 0, true);
			            $adults = $this->cb_post_meta($roomrate->ID, '_guest', 1, true);
			            $max_adults = $this->cb_post_meta($roomrate->ID, '_max_guest', 1, true);
			            $kids = $this->cb_post_meta($roomrate->ID, '_kids', 0, true);
			            // $minimumnights = $this->cb_post_meta($roomrate->ID, '_minimumnights', 1, true);
			            $max_kids = $this->cb_post_meta($roomrate->ID, '_max_kids', 0, true);
			            $images = $this->cb_post_meta($roomrate->ID, '_room_images', array(), true);
			            if(!empty($images))
			                $coverImage = ' style=background-image:url('.$images[0].');';
			            else
			                $coverImage = '';

			            $amenity = $this->cb_post_meta($roomrate->ID, '_amenity', array(), true);

			            // $amenity = $this->cb_hm_options('_amenity','' );
						$listamenities = array();
			            if(!empty($amenity)):
							foreach ($this->amenities as $key => $value) {
								if(array_key_exists($key, $amenity)){
									$listamenities[] = $value;
								}
							}
						endif;

						$rooms[] = array(
						    'id' => $roomrate->ID,
						    'hotel' => '0',
						    'name' => get_the_title($roomrate->ID),
						    'short' => '',
						    'description' => $roomrate->post_content,
						    'guests' => array(
						        'adults_included' => (int) $adults,
						        'kids_included' => (int) $kids,
						        'max' => (int) $max_adults,
						    ),
						    'photos' => array_filter($images),
						    'features' => $listamenities,
						    'rate' => array(
						        'rate_basic' => $ratebasic,
						        'rate_min' => $ratemin,
						        'rate_max' => $ratemax,
						        'closed_to_arrival' => '0',
						        'room_type_id' => $roomrate->ID,
						        'package_id' => 0,
						        'rate_id' => $roomrate->ID,
						        'property_id' => '0',
						        'is_fake' => false,
						        'room_capacity' => (int) $sleeps,
						        'detailed_rates' => array_filter($roomrates),
						        'is_derived' => 0,
						        'num_available_now' => (int) $remains,
						        'remaining' => (int) $remains,
						        'charge_clean_up_room' => 0,
						        'days' => (int) $minimumnights,
						        'los_min' => '0',
						        'los_max' => '0',
						        'cut_off' => 0,
						        'last_minute_booking' => 0,
						        'closed' => 0,
						        'charge_additional_adult' => false,
						        'charge_additional_child' => false,
						        'adults_inBasePrice' => (int) $adults,
						        'children_inBasePrice' => (int) $kids,
						        'add_adult_total' => 0,
						        'add_adult_rate_first_night' => 0,
						        'add_kids_total' => 0,
						        'add_kid_rate_first_night' => 0,
						        'add_adult_rate' => 0,
						        'add_kid_rate' => 0,
						    ),
						    'available' => (int) $remains,
						);
						$subtotal += $roomtotal;
						$totalrooms++;
			        endif;
			    endif;  
			}
			if($taxincluded == 'yes'){
				$taxvalue = (float)$subtotal*((float)$tax/100);
				$total = (float)$subtotal+(float)$taxvalue;
			}else{
				$total = (float)$subtotal;
			}

			$data = array ( 
				'success' => true, 
				'room_count' => $totalrooms, 
				'rooms' => array ( 
					0 => array ( 
						'hotel_id' => '0', 
						'currency' => array ( 
							'code'		=> $this->cb_hm_options('_currency_code','USD' ),
							'symbol'	=> $this->cb_hm_options('_payment_currency', '$'),
							'name'		=> $this->cb_hm_options('_currency_name', 'US Dollar'),
							'position'	=> $this->cb_hm_options('_currency_position', 'before'),
							'is_active' => '1', 
						), 
						'gateway' 	=> 'tokenex', 
						'rooms' 	=> $rooms,
					), 
				),
				'id' => '0', 
			);
	        if ($totalrooms > 0) {
	        	global $currency;
	    		$currency = $data['rooms'][0]['currency'];

	            $rooms = array();
	            $rooms['roomsdata'] = $data;
	            $rooms['id'] = $data['id'];
	            $enddate = gmdate($dateformat, strtotime("-1 day", strtotime($departingDate)));
	            $days = $this->GetDays($arrivalDate, $enddate, 'Y-m-d');
	            $years = $this->GetYears();

	            $params = array(
	            	'date_format_DP' => $dateformat
	            );


	            $template_file = 'roomavailable.php';

	            if (file_exists(TEMPLATEPATH.'/mybookings-light/' . $template_file)) {
	                include (TEMPLATEPATH.'/mybookings-light/' . $template_file);
	            } else {
	                include(plugin_dir_path( __FILE__ ) .'partials/'. $template_file);
	            }
	        } else {
	            echo '<div class="chooser omhide" style="display: block;">
	                    <h4 style="text-align:center;">'.__('Sorry, but there is no accommodation available on selected dates. Please modify the above information to make a new search.', $this->cloudbeds_hotel_management).'</h4></div>';
	        }
		}else {
			echo 'No Rooms Found !!!';
		}

		exit(0);
	}

	public function cloudbeds_reservation(){
		global $wpdb, $current_user;
        $roomtable = $wpdb->prefix.$this->roomratedb;
        $booktable = $wpdb->prefix.$this->bookingtable;

		$data = $userinfo = array();
		$data['date_format_DP'] = $dateformat = isset($_POST['date_format_DP']) ? $_POST['date_format_DP'] : 'm/d/Y';
		$data['checkin'] = $checkin = isset($_POST['selected_checkin']) ? $_POST['selected_checkin'] : date('m/d/Y');
		$data['checkout'] = $checkout = isset($_POST['selected_checkout']) ? $_POST['selected_checkout'] : date('m/d/Y', strtotime('tomorrow'));
		$selected_room_qty = $data['selected_room_qty'] = isset($_POST['selected_room_qty']) ? $_POST['selected_room_qty'] : array();
		// room ID 726 and 727 - define the room ID -> quantiry      
		$selected_adults = $data['selected_adults'] = isset($_POST['selected_adults']) ? $_POST['selected_adults'] : array();
		$selected_kids = $data['selected_kids'] = isset($_POST['selected_kids']) ? $_POST['selected_kids'] : array();
		$data['payment_method'] = isset($_POST['payment_method']) ? $_POST['payment_method'] : '';
		$data['choose_bank'] = isset($_POST['choose_bank']) ? $_POST['choose_bank'] : '';
		$data['choose_card'] = isset($_POST['choose_card']) ? $_POST['choose_card'] : '';
		$userinfo['name'] = isset($_POST['first_name']) ? $_POST['first_name'] : '';
		$userinfo['last_name'] = isset($_POST['last_name']) ? $_POST['last_name'] : '';
		$userinfo['email'] = isset($_POST['email']) ? $_POST['email'] : '';
		$userinfo['phone'] = isset($_POST['phone']) ? $_POST['phone'] : '';
		$userinfo['cell'] = isset($_POST['cell_phone']) ? $_POST['cell_phone'] : '';
		$userinfo['zip'] = isset($_POST['zip']) ? $_POST['zip'] : '';
		$userinfo['zip_f'] = isset($_POST['zip_f']) ? $_POST['zip_f'] : '';
		$userinfo['country'] = isset($_POST['country']) ? $_POST['country'] : '';
		$userinfo['street'] = isset($_POST['street']) ? $_POST['street'] : '';
		$userinfo['number'] = isset($_POST['number']) ? $_POST['number'] : '';
		$userinfo['complement'] = isset($_POST['complement']) ? $_POST['complement'] : '';
		$userinfo['neighborhood'] = isset($_POST['neighborhood']) ? $_POST['neighborhood'] : '';
		$userinfo['city'] = isset($_POST['city']) ? $_POST['city'] : '';
		$userinfo['state'] = isset($_POST['state']) ? $_POST['state'] : '';
		$userinfo['cpf'] = isset($_POST['cpf']) ? $_POST['cpf'] : '';
		$data['rg'] = isset($_POST['rg']) ? $_POST['rg'] : '';
		$userinfo['issuer'] = isset($_POST['issuer']) ? $_POST['issuer'] : '';
		$data['special_requests'] = isset($_POST['special_requests']) ? $_POST['special_requests'] : '';
		$data['selected_room_total'] = isset($_POST['selected_room_total']) ? $_POST['selected_room_total'] : array();
		$data['selected_room_name'] = $selected_room_name = isset($_POST['selected_room_name']) ? $_POST['selected_room_name'] : array();
		$data['roomrateids'] = $roomrateids = isset($_POST['roomrateid']) ? $_POST['roomrateid'] : array();

		$data['total_advance'] = isset($_POST['total_advance']) ? $_POST['total_advance'] : '';
		$data['grand_total'] = isset($_POST['grand_total']) ? $_POST['grand_total'] : '';

		$booking_ref = 'RES-'.date('Ymd-his');
		// var_dump($data);
		$message = '';
		$user_id = 0;

		if(strtolower($dateformat) == 'd/m/y'){
			$checkin = str_replace('/', '-', $checkin);
			$checkout = str_replace('/', '-', $checkin);
		}
		$checkin = date('Y-m-d', strtotime($checkin));
		$checkout = date('Y-m-d', strtotime($checkout));
		$errors = array();
		if(!empty($roomrateids)){
			foreach ($roomrateids as $roomid => $dates):
				$packagelist = '';
				$roomquantity = $selected_room_qty[$roomid];
				$adult = $selected_adults[$roomid];
				$kid = $selected_kids[$roomid];
				$status = 1; // 0 = booking initiated, 1= New Booking, 2= booking confirmed, 3= booking Cancelled;
				$product_type = '';
				$card_type = '';
				$card_number = '';
				$card_name = '';
				$card_issue =  '';
				$card_security =  '';
				$card_starts_month = '';
				$card_starts_year =  '';
				$card_ends_month = '';
				$card_ends_year = '';
				$arriving = date('Y-m-d H:i:s', strtotime($checkin) );
				$departing = date('Y-m-d H:i:s', strtotime($checkout) );
				$stay = count($dates);
				$ordertime = date('Y-m-d H:i:s', strtotime('now'));
				$any_request = $data['special_requests'];
				$guests = serialize($userinfo);
				foreach ($dates as $date => $rate_id) {

					$price = $exist = $roomtype_id = -1;

	                // get if given roomrates exist 
	                $results = $wpdb ->get_results("SELECT * FROM ".$roomtable.
	                    " WHERE id = $rate_id");

	                if (!empty($results) && isset($results[0])) {
	                    $price = (float) $results[0] ->price;
	                    $qtprice = (float)($results[0] ->price * (int) $roomquantity);
	                    $roomtype_id = $results[0] ->roomtype_id;
	                    $bookdate = $results[0] ->bookdate;
	                }

					$sql = "insert into ".$booktable.
			            "  (
			                `id`,
			                `booking_ref`,
			                `user_id`,
			                `roomtype_id`,
	                        `rate_id`,
			                `packages`,
			                `roomquantity`,
			                `price`,
			                `qtprice`,
			                `adults`,
			                `kids`,
			                `status`,
			                `product_type`,
			                `card_type`,
			                `card_number`,
			                `card_name`,
			                `card_issue`,
			                `card_security`,
			                `card_starts_month`,
			                `card_starts_year`,
			                `card_ends_month`,
			                `card_ends_year`,
			                `arriving`,
			                `departing`,
			                `stay`,
			                `order_time`,
			                `any_request`,
			                `guests`
			            )
			            VALUES(
			                NULL, '$booking_ref', '$user_id', '$roomtype_id', '$rate_id', '$packagelist', '$roomquantity', '$price', '$qtprice', '$adult', '$kid', '$status', '$product_type', '$card_type', '$card_number', '$card_name', '$card_issue', '$card_security', '$card_starts_month', '$card_starts_year', '$card_ends_month', '$card_ends_year', '$arriving', '$departing', '$stay', '$ordertime', '$any_request', '$guests'
			            )
			            ";
			        $success = $wpdb ->query($sql);
			        if($success):

			        	// update allocation on room_rates table
			        	$getremains = $wpdb->get_results( "SELECT * FROM $roomtable WHERE `roomtype_id` = '$roomid' AND `bookdate`='$bookdate'" );
	                    if(!empty($getremains) && isset($getremains[0])){
	                        $booked = (int)$getremains[0]->booking + (int)$roomquantity;
	                        $available = (int)$getremains[0]->available;
	                        if((int)$booked == (int)$getremains[0]->allocation) {
	                          $available = 0; 
	                        }
	                        $now = date('Y-m-d h:i:s');
	                         $roomrates_sql = "
	                            UPDATE $roomtable 
	                            SET `available` = '".$available."',
	                            `booking` = '$booked',  
	                            `update_time` = '$now'
	                            WHERE `roomtype_id` = '$roomid'
	                            AND `bookdate` = '$bookdate'
	                            ";

	                         $response = $wpdb->query( $roomrates_sql );
	                         if(!$response){
	                         	$errors[] = 'Booking failed for date:'.$bookdate;
	                         }
	                    }
	                endif;
				}//end forech $dates
			endforeach; // $roomrateids

			if(empty($errors)){
				$sender_name = $this->cb_hm_options('_sender_name', '' );
				$sender_email = $this->cb_hm_options('_sender_email', '' );
				$email_subject = $this->cb_hm_options('_email_subject','' );
				$email_message = $this->cb_hm_options('_email_message','' );
				$this->generate_email_template($data, $userinfo, $booking_ref);
				echo '<div class="cb_error success">'.__('Thank you for your booking, your booking information has been sent to your email address', $this->cloudbeds_hotel_management).'</div>';
			}
		}else{
			echo '<div class="cb_error success">'.__('Reservation Failed !!!', $this->cloudbeds_hotel_management).'</div>';
		}		
		exit(0);
	}

	public function cloudbeds_api_ajax()
	{
	    // $cloudbeds_api_key = $this->cb_hm_options('_cloudbeds_api_key','', false );
	    $id = isset($_POST['id']) ? $_POST['id'] : 0;
	    $dateformat = isset($_POST['dateformat']) ? $_POST['dateformat'] : 'm/d/Y';
	    $datefrom = isset($_POST['datefrom']) ? $_POST['datefrom'] : 0;
	    $dateto = isset($_POST['dateto']) ? $_POST['dateto'] : 0;

	    $this->call_central_api($id, $datefrom, $dateto, $dateformat);
	    // if (!empty($id)) {

	    //     // $this->call_central_api($cloudbeds_api_key, $id, $datefrom, $dateto, $dateformat);
	    //     $this->call_central_api($id, $datefrom, $dateto, $dateformat);


	    // } else {
	    //     echo '<div class="cb_error danger"> API Error - property id is invalid </div>';
	    // }
	    die();
	}

	public function call_central_api($propertyid, $datefromarg = '', $datetoarg = '', $dateformat = 'm/d/Y')
	{
	    $return = '';

	    $datefrom = !empty($datefromarg) ? $datefromarg : date($dateformat);
	    $dateto = !empty($datetoarg) ? $datetoarg : date($dateformat, strtotime('tomorrow'));

	    // $url = $this->cb_api . 'hotels/details?id=' . $propertyid . '&key=' . $cloudbeds_api_key;

	    global $currency;

	    // New API 1.1 code
	    $access_token = false;
	    $cloudbeds_app_info = $this->cb_hm_options('_cloudbeds_app_info','' );
	    $access_info = $this->cb_hm_options('_cloudbeds_api_access_info','' );
 
		$client_id = isset($cloudbeds_app_info['client_id']) ? $cloudbeds_app_info['client_id'] : '';
		$client_secret = isset($cloudbeds_app_info['client_secret']) ? $cloudbeds_app_info['client_secret'] : '';

	    //Create Client
	    $client = new OAuth2\Client($client_id, $client_secret);

	    $access_token = isset($access_info['access_token']) ? $access_info['access_token'] : false;
	    $refresh_token = isset($access_info['refresh_token']) ? $access_info['refresh_token'] : false;
	    $token_timeout = isset($access_info['token_timeout']) ? $access_info['token_timeout'] : 3600;
	    $token_created = isset($access_info['token_created']) ? $access_info['token_created'] : false;

		// $code =  $this->cb_hm_options('_api_authorization_code','' );
		// if($code == ''){
		// 	var_dump('here');
		// 	echo '<div class="error">Configuration Error!!!</div>';
		// 	die();
		// }

	    if(!is_array($access_info)){
            
            echo '<div class="cb_error alert">Configuration Error!!!</div>';
			die();


	    	//$params = array('code' => $code, 'redirect_uri' => admin_url( 'admin.php?page=mybookings-settings' ), 'username'=>$cloudbeds_app_email, 'password'=>$cloudbeds_app_password);
	    	//  // var_dump($params);
	    	//$access_token = $this->get_new_access_token($client, $params, 'refresh_token');

	    }else {

		    
		    if(( (int)current_time( 'timestamp' ) - (int)$token_created ) >= $token_timeout){
		    	//if access_token timeout
		    	$params = array('code' => $code, 
		    		'redirect_uri' => admin_url( 'admin.php?page=mybookings-settings' ), 
		    		'access_token'=>$access_token, 
		    		'refresh_token'=>$refresh_token
		    		);
		    	$access_token = $this->get_new_access_token($client, $params, 'refresh_token');
		    }
		}


	    if($access_token) {
		    $client->setAccessToken($access_token); 
		    $client->setAccessTokenType(1, $access_token);
		    $cb_hotel_url = $this->cb_api.$this->cb_api_hotel_details_url;
		    if($propertyid)
		    	$response = $client->fetch($cb_hotel_url, array('propertyID' => $propertyid));
		    else
		   		$response = $client->fetch($cb_hotel_url);

		    $result = $response['result'];
		    

      //       echo '$client: '. var_export($client, true);
		    if($result['success']){
			    $hotel = $result['data'];
		    // $this->vdump($hotel);
		    	$public_dir_url = plugin_dir_url( __FILE__ );
		        $currency = $hotel['propertyCurrency'];
		        $template_file = 'api_propertydetails.php';
		        if( file_exists(TEMPLATEPATH.'/mybookings-light/'. $template_file) ) {
		            include TEMPLATEPATH . '/mybookings-light/' . $template_file;
		        } else {
		            include(plugin_dir_path( __FILE__ ) .'partials/'. $template_file);
		        }
		    }else {
		    	echo '<div class="cb_error alert">'.$result['message'].'</div>';
		    }
	    }else {
	    	echo '<div class="cb_error danger error-access-token">Invalid Request!!!.</div>';
	    	die();
	    }

	    // $json = file_get_contents($url);
	    // $data = json_decode($json, TRUE);

	    // var_dump($data);
	  
	}

	public function time24to12($time, $echo = true)
    {
        if ($echo) echo date("h:i A", strtotime($time));
        else return date("h:i A", strtotime($time));
    }

	public function print_booking_info($bookinfo) {
		$return = '';
		$cbhm = $this->cloudbeds_hotel_management;
		// var_dump($bookinfo);exit();
		if( file_exists(TEMPLATEPATH.'/mybookings-light/printbooking.php') ) {
			include(TEMPLATEPATH.'/mybookings-light/printbooking.php');
		}else {
			include(plugin_dir_path( __FILE__ ).'partials/printbooking.php');
		}
		// return $return;
	}

	function api_checkroomavailability()
	{
	    $data = array();
	    // $cloudbeds_api_key = $this->cb_hm_options('_cloudbeds_api_key','', false );
	    $data['date_format_DP'] =  $dateformat  = isset($_POST['date_format_DP']) ? $_POST['date_format_DP'] : 'm/d/Y';
	    //$lang = $options['language'] ? $options['language'] : 'en';

	    // $data['id'] = isset($_POST['id']) ? $_POST['id'] : '';
	    // $data['kids'] = isset($_POST['kids']) ? $_POST['kids'] : '';
	    // $data['check_in'] = isset($_POST['search_start_date']) ? $_POST['search_start_date'] : date($data['date_format_DP']);
	    // $data['check_out'] = isset($_POST['search_end_date']) ? $_POST['search_end_date'] : date($data['date_format_DP'], strtotime('tomorrow'));

	    //API 1.1
	    $data['propertyIDs'] = isset($_POST['id']) ? $_POST['id'] : '';
	    $data['rooms'] = isset($_POST['rooms']) ? $_POST['rooms'] : '';
	    $data['adults'] = isset($_POST['adults']) ? $_POST['adults'] : '';
	    $data['children'] = isset($_POST['kids']) ? $_POST['kids'] : '';
	    $data['lang'] = isset($_POST['lang']) ? $_POST['lang'] : $lang;
	    $data['currency_symbol'] = isset($_POST['currency_symbol']) ? $_POST['currency_symbol'] : '';
	    $data['currency_position'] = isset($_POST['currency_position']) ? $_POST['currency_position'] : $lang;
	    $data['startDate'] = $startDate = isset($_POST['search_start_date']) ? $_POST['search_start_date'] : date($data['date_format_DP']);
	    $data['endDate'] = $endDate = isset($_POST['search_end_date']) ? $_POST['search_end_date'] : date($data['date_format_DP'], strtotime('tomorrow'));


	    $sformat = DateTime::createFromFormat($data['date_format_DP'], $startDate);
		$data['startDate'] = $sformat->format('Y-m-d');
		$eformat = DateTime::createFromFormat($data['date_format_DP'], $endDate);
		$data['endDate'] = $eformat->format('Y-m-d');

	  //   if($data['date_format_DP'] == 'm/d/Y' || $data['date_format_DP'] == 'Y/m/d' || $data['date_format_DP'] == 'd/m/Y'){
	  //   	if(strtolower($dateformat) == 'd/m/y'){
	  //   		$sformat = DateTime::createFromFormat('d/m/Y', $startDate);
	  //   		$startDate = $sformat->format('Y-m-d');
	  //   		$eformat = DateTime::createFromFormat('d/m/Y', $endDate);
	  //   		$endDate = $eformat->format('Y-m-d');
			// 	// $startDate = str_replace('/', '-', $startDate);
			// 	// $endDate = str_replace('/', '-', $endDate);
			// }
	  //   	$data['startDate'] = date('Y-m-d', strtotime($startDate));
			// $data['endDate'] = date('Y-m-d', strtotime($endDate));
			// // $data['date_format_DP']  = 'Y-m-d';
	  //   }
	  //   if($data['date_format_DP'] == 'd-m-Y'){
	  //   	$sformat = DateTime::createFromFormat('d-m-Y', $startDate);
   //  		$data['startDate'] = $sformat->format('Y-m-d');
   //  		$eformat = DateTime::createFromFormat('d-m-Y', $endDate);
   //  		$data['endDate'] = $eformat->format('Y-m-d');
	  //   }

	    $data['detailedRates'] = true;

	    $data['promo_code'] = isset($_POST['promo_code']) ? $_POST['promo_code'] : '';


       	
	    $this->call_central_apinew_checkroomavailable($data);
	    // if (!empty($data['propertyIDs'])) {

	    //     // $this->call_central_api_checkroomavailable($cloudbeds_api_key, $data);
	    //     $this->call_central_apinew_checkroomavailable($data);


	    // } else {
	    //     echo '<h4> Error ! Try Again </h4><div style="display:none"> Invalid PropertyID </div>';
	    // }
	    exit();
	}

	private function call_central_apinew_checkroomavailable($postdata) {
		global $currency;



	    // New API 1.1 code
	    $access_token = false;
	    $cloudbeds_app_info = $this->cb_hm_options('_cloudbeds_app_info','' );
	    $access_info = $this->cb_hm_options('_cloudbeds_api_access_info','' );
	    $code =  $this->cb_hm_options('_api_authorization_code','' );

		 
		$client_id = isset($cloudbeds_app_info['client_id']) ? $cloudbeds_app_info['client_id'] : '';
		$client_secret = isset($cloudbeds_app_info['client_secret']) ? $cloudbeds_app_info['client_secret'] : '';

	    //Create Client
	    $client = new OAuth2\Client($client_id, $client_secret);

	    $access_token = isset($access_info['access_token']) ? $access_info['access_token'] : false;
	    $refresh_token = isset($access_info['refresh_token']) ? $access_info['refresh_token'] : false;
	    $token_timeout = isset($access_info['token_timeout']) ? $access_info['token_timeout'] : 3600;
	    $token_created = $access_info['token_created'];

		    
	    if(( (int)current_time( 'timestamp' ) - (int)$token_created ) >= $token_timeout){ 
	    	$params = array('code' => $code, 
		    		'redirect_uri' => admin_url( 'admin.php?page=mybookings-settings' ), 
		    		'access_token'=>$access_token, 
		    		'refresh_token'=>$refresh_token
		    		);
		   $access_token = $this->get_new_access_token($client, $params, 'refresh_token'); 
	    }
	    if($access_token) { 
		    $client->setAccessToken($access_token); 
		    $client->setAccessTokenType(1, $access_token);
		    $response = $client->fetch($this->cb_api.$this->cb_api_get_available_rooms, $postdata);
		    $result = $response['result'];

		     // $v = var_export($postdata, true);
       //       echo '<style type="text/css">pre{ text-align:left;} </style><pre>'; print_r($v); echo '</pre><br/><br/>';
       //       // exit();
		     // $v = var_export($result, true);
       //       echo '<style type="text/css">pre{ text-align:left;} </style><pre>'; print_r($v); echo '</pre>';
       //       exit();


		    if($result['success']){
			    if ($result['roomCount'] > 0) {
			    	$data = $result['data'][0];
			    	// $this->vdump($rooms);
		    		$currency = $data['propertyCurrency'];

			    	//selected nights
					$arrivalDate = date('Y-m-d', strtotime($postdata['startDate']));
					$departingDate = date('Y-m-d', strtotime($postdata['endDate']));
					$date1 = new DateTime($arrivalDate);
					$date2 = new DateTime($departingDate);

					$selected_neight = $date2->diff($date1)->format("%d");

					$endDate = gmdate($postdata['date_format_DP'], strtotime("-1 day", strtotime($postdata['endDate'])));

		            if($endDate == '')
		            	$endDate = $postdata['endDate'];

		            // var_dump($postdata);exit(0);


		            $days = $this->GetDays($postdata['startDate'], $postdata['endDate'], 'Y-m-d');
		            // var_dump($endDate);exit(0);
		            $years = $this->GetYears();
		            if($postdata['promo_code'])
		            	$couponapplied = true;
		           	else 
		           		$couponapplied = false;

			    	$rooms = array();
		            $rooms = $data['propertyRooms'];
		            // $this->vdump($data);
		            $propertyID = $data['propertyID'];

		            $template_file = 'api_roomsavailable.php';

		            if (file_exists(TEMPLATEPATH.'/mybookings-light/' . $template_file)) {
		                include (TEMPLATEPATH.'/mybookings-light/' . $template_file);
		            } else {
		                include(plugin_dir_path( __FILE__ ) .'partials/'. $template_file);
		            }
			    }else {
			    	echo '<div class="cb_error warning">
	                    <h5 style="text-align:center;">'.__("We're sorry but there are no available accommodations for your selected dates – please modify your dates above to search again.", $this->cloudbeds_hotel_management).'</h5></div>';
			    }
		    }else {
		    	echo $response['result']['message'];
		    }
	    }else {
	    	echo '<div class="cb_error warning">'.$result['message'].'</div>';
	    	die();
	    }	  
	}
   
	public function cloudbeds_api_checkoutreservation(){
		$dateformat = isset($_GET['formatDate']) ? $_GET['formatDate'] : 'm/d/Y';
		$prepairdata = array(
			'propertyID'=> isset($_GET['propertyID']) ? (int)$_GET['propertyID'] : 0,
	        'startDate' => isset($_GET['startDate']) ? $this->mdyTogdsDateTypeFromDate($_GET['startDate'], $dateformat) : false, 
	        'endDate' => isset($_GET['endDate']) ? $this->mdyTogdsDateTypeFromDate($_GET['endDate'], $dateformat) : false, 
	        'roomsTotal' => isset($_GET['roomsTotal']) ? (float)$_GET['roomsTotal'] : 0,
	        'roomsCount'    => isset($_GET['roomcount']) ? (int)$_GET['roomcount'] : 0
		);

		$sformat = new DateTime($prepairdata['startDate']);
		$eformat = new DateTime($prepairdata['endDate']);
		$selectednights = $sformat->diff($eformat)->format("%d");

		$access_token = false;
	    $cloudbeds_app_info = $this->cb_hm_options('_cloudbeds_app_info','' );
	    $access_info = $this->cb_hm_options('_cloudbeds_api_access_info','' );

		$cloudbeds_app_email = isset($cloudbeds_app_info['cloudbeds_app_email']) ? $cloudbeds_app_info['cloudbeds_app_email'] : '';
	    $cloudbeds_app_password = isset($cloudbeds_app_info['cloudbeds_app_password']) ? $cloudbeds_app_info['cloudbeds_app_password'] : '';
		$client_id = isset($cloudbeds_app_info['client_id']) ? $cloudbeds_app_info['client_id'] : '';
		$client_secret = isset($cloudbeds_app_info['client_secret']) ? $cloudbeds_app_info['client_secret'] : '';

	    //Create Client
	    $client = new OAuth2\Client($client_id, $client_secret);

	    $access_token = isset($access_info['access_token']) ? $access_info['access_token'] : false;
	    $refresh_token = isset($access_info['refresh_token']) ? $access_info['refresh_token'] : false;
	    $token_timeout = isset($access_info['token_timeout']) ? $access_info['token_timeout'] : 3600;
	    $token_created = $access_info['token_created'];

	 //    $code =  $this->cb_hm_options('_api_authorization_code','' );
		// if($code == ''){
		// 	echo '<div class="error">'.__('Configuration Error!!!.', $this->cloudbeds_hotel_management).'</div>';
		// 	die();
		// }

		 if(!is_array($access_info)){
            
            echo '<div class="cb_error alert">'.__('Configuration Error!!!. Please reload the page.', $this->cloudbeds_hotel_management).'</div>';
			die();
 

	    }else {
		    if(( (int)current_time( 'timestamp' ) - (int)$token_created ) >= $token_timeout){
		    	//if access_token timeout
		    	$params = array('code' => $code, 
		    		'redirect_uri' => admin_url( 'admin.php?page=mybookings-settings' ), 
		    		'access_token'=>$access_token, 
		    		'refresh_token'=>$refresh_token
		    	);
		    	$access_token = $this->get_new_access_token($client, $params, 'refresh_token');
		    }
		}

		// $this->vdump($prepairdata);
		if($access_token) {
		    $client->setAccessToken($access_token); 
		    $client->setAccessTokenType(1, $access_token);
		    // $this->vdump($this->cb_api_get_getroomsfeesandtaxes);
		    $apiurl = $this->cb_api.$this->cb_api_get_getroomsfeesandtaxes;
		    $response = $client->fetch($apiurl, $prepairdata);
		    // $this->vdump($apiurl);
		    $data = $response['result'];
		    if($data['success']){
		    	$data['days'] = $selectednights;
		    	echo json_encode($data);
		    }else {
		    	$data['send_params'] = $prepairdata;
		    	echo json_encode($data);
		    }
		}else {
			$data = array(
				'success'	=> false,
				'error'		=> 'Authentication Failed!!!. Please refresh the page.'
			);
			echo json_encode($data);
		}
		exit(0);
	}

	public function call_apinew_reservation($param){
		$return = '';  

		// $url = $this->cb_api_post_reservation;

		$postData = array();  

		$postData['propertyID']            = (int)$param['propertyID'];

		$postData['startDate']          = $this->mdyTogdsDateTypeFromDate( $param['checkin'], $param['date_format_DP'] ); //(date formatted Y-m-d)

		$postData['endDate']         = $this->mdyTogdsDateTypeFromDate( $param['checkout'], $param['date_format_DP'] ); //(date formatted Y-m-d)

		$postData['rooms'] =  $postData['adults'] =   $postData['children'] = array();


		// foreach ($param['selected_room_qty'] as $key => $value) {

		// 	$roomqty = array(
		// 		'roomTypeID'	=> (int)$key,
		// 		'quantity'		=> (int)$value
		// 	);

		// 	// $postData['rooms'][] =  $roomqty;
		// 	$postData['rooms'][] =  array(
		// 		$key => $value
		// 	);

		// }     
		$i = $j = $k = 0;
		foreach ($param['selected_room_qty'] as $key => $value) { 
			$typekey = 'rooms['.$i.'][roomTypeID]';
			$qtykey = 'rooms['.$i.'][quantity]';
			$postData[$typekey] = $key;
			$postData[$qtykey]   =  $value; 
			$i++;
		} 

		foreach ($param['selected_adults'] as $key => $value) {

			$typekey = 'adults['.$j.'][roomTypeID]';
			$qtykey = 'adults['.$j.'][quantity]';
			$postData[$typekey] = $key;
			$postData[$qtykey]   =  $value; 
			$j++;

		}     

		foreach ($param['selected_kids'] as $key => $value) {

			$typekey = 'children['.$k.'][roomTypeID]';
			$qtykey = 'children['.$k.'][quantity]';
			$postData[$typekey] = $key;
			$postData[$qtykey]   =  $value; 
			$k++;

		}   


		$postData['paymentMethod']   		= $param['payment_method']; 

		$postData['paymentBank']      		= $param['choose_bank']; 
		
		$postData['paymentCard']      		= $param['choose_card']; 

		$postData['guestFirstName']             		= $param['name']; 

		$postData['guestLastName']        		= $param['last_name']; 

		$postData['guestEmail']            		= $param['email']; 

		$postData['guestPhone']            		= isset($param['phone']) ? $param['phone'] : $param['cell']; 
		
		// $postData['guest_cell']             		= $param['cell']; 

		$postData['guestZip']              		= $param['zip_f']; 

		$postData['guestCountry']          		= $param['country']; 

		$postData['street']           		= $param['street']; 

		$postData['number']           		= $param['number']; 

		$postData['complement']       		= $param['complement']; 

		$postData['neighborhood']     		= $param['neighborhood']; 

		$postData['city']             		= $param['city']; 

		$postData['state']            		= $param['state']; 

		$postData['cpf']              		= $param['cpf']; 

		$postData['rg']               		= $param['rg']; 

		$postData['issuer']           		= $param['issuer']; 

		$postData['issue_date']       		= $param['issue_date']; 

		$postData['issuer_state']     		= $param['issuer_state']; 

		$postData['birthday']         		= $param['birthday']; 

		$postData['gender']           		= $param['gender']; 

		$postData['first_time']       		= $param['first_time']; 

		$postData['special_requests'] 		= $param['special_requests']; 

		$postData['cardHolderName']  		= $param['cardholder_name']; 

		$postData['cardNumber']      		= $param['card_number']; 

		$postData['cardExpiryDate']         = $param['exp_date']; 

		$postData['cardCVV']              	= $param['cvv'];



		$postData['roomTotal'] = $postData['selected_room_total']      = $param['selected_room_total']; 

		$postData['roomName']  = $postData['selected_room_name']        = $param['selected_room_name']; 

		$postData['selected_room_qty'] = $param['selected_room_qty'];

		$postData['grandTotal'] = $param['grand_total'];
		
		$postData['totalAdvance'] = $param['total_advance'];

		//$postData['source']           = !empty($param['source']) ? $param['source'] : 'Enbloc Hotels'; 

		$postData['source']           = !empty($options['source']) ? $options['source'] : 'mybookings-light';  
		$send_email                   = (isset($options['emailsender']) && 0 == $options['emailsender'])  ? 0 : 1; 

		$postData['send_email']       = $send_email; // 0 / 1 


		// Prepair Reservation API 1.1
		$access_token = false;
	    $cloudbeds_app_info = $this->cb_hm_options('_cloudbeds_app_info','' );
	    $access_info = $this->cb_hm_options('_cloudbeds_api_access_info','' );
 
		$client_id = isset($cloudbeds_app_info['client_id']) ? $cloudbeds_app_info['client_id'] : '';
		$client_secret = isset($cloudbeds_app_info['client_secret']) ? $cloudbeds_app_info['client_secret'] : '';

	    //Create Client
	    $client = new OAuth2\Client($client_id, $client_secret);

	    $access_token = isset($access_info['access_token']) ? $access_info['access_token'] : false;
	    $refresh_token = isset($access_info['refresh_token']) ? $access_info['refresh_token'] : false;
	    $token_timeout = isset($access_info['token_timeout']) ? $access_info['token_timeout'] : 3600;
	    $token_created = $access_info['token_created'];

	 //    $code =  $this->cb_hm_options('_api_authorization_code','' );
		// if($code == ''){
		// 	echo '<div class="error">Configuration Error!!!</div>';
		// 	die();
		// }

		 if(!is_array($access_info)){
            
            echo '<div class="cb_error alert">Configuration Error!!!</div>';
			die();
 
	    }else {

		    
		    if(( (int)current_time( 'timestamp' ) - (int)$token_created ) >= $token_timeout){
		    	//if access_token timeout
		    	$params = array('code' => $code, 
		    		'redirect_uri' => admin_url( 'admin.php?page=mybookings-settings' ), 
		    		'access_token'=>$access_token, 
		    		'refresh_token'=>$refresh_token
		    		);
		    	$access_token = $this->get_new_access_token($client, $params, 'refresh_token');
		    }
		}

		// $this->vdump($postData);
		if($access_token) {
		    $client->setAccessToken($access_token); 
		    $client->setAccessTokenType(1, $access_token);
		    $response = $client->fetch($this->cb_api.$this->cb_api_post_reservation, $postData, 'POST');
		    // $this->vdump($response);
		    $data = $response['result'];
		    if($data['success']){
		    	echo '<div class="cb_error success"><h4>'.__('Thank you for your booking, your booking information has been sent to your email address. Your Reservation Number:', $this->cloudbeds_hotel_management).' <strong>'.$data['reservationID'].'</strong>.'.'</h4></div>';
		    }else {
		    	echo '<div class="cb_error alert">'.$data['message'].'</div>';
		    }
		}else {
			echo '<div class="danger cb_error error-access-token">'.__('Invalid Request!!!.', $this->cloudbeds_hotel_management).'</div>';
	    	die();
		}
		exit(0);

	}

	function call_central_api_checkroomavailable($cloudbeds_api_key, $params)
	{
	    $return = '';

	    $urltoreq = $this->cb_api . 'rooms/available/?hotel_id=' . $params['id'];

	    $urltoreq .= '&key=' . $cloudbeds_api_key;
	    $urltoreq .= '&check_in=' . $this->mdyTogdsDateTypeFromDate($params['check_in'], $params['date_format_DP']);
	    $urltoreq .= '&check_out=' . $this->mdyTogdsDateTypeFromDate($params['check_out'], $params['date_format_DP']);
	    $urltoreq .= '&adults=' . $params['adults'];
	    $urltoreq .= '&kids=' . $params['kids'];
	    $urltoreq .= '&rooms=' . $params['rooms'];
	    $urltoreq .= '&promo_code=' . $params['promo_code'];
	    $urltoreq .= '&detailed=1';
	    $urltoreq .= '&timestamp='.time();
	    $startdate = $params['check_in'];
	    $enddate = $params['check_out'];
	    // var_dump($startdate);


	    // new
	    // curl_setopt($ch,CURLOPT_SSL_VERIFYHOST,false);

	    $ch = curl_init();  
 
	    curl_setopt($ch,CURLOPT_URL,$urltoreq);
	    curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
	    curl_setopt($ch,CURLOPT_SSL_VERIFYHOST,false);
	    curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,false);
	    // CURLSSL_VER

	 
	    $json=curl_exec($ch);

		// Getting results
		$json = curl_exec($ch); // Getting jSON result string

	    // $json = file_get_contents($url);
	    $data = json_decode($json, TRUE);
	    // var_dump($data);exit();
	    //end new

	    // $json = file_get_contents($urltoreq);
	    //cloudbeds_dump($urltoreq);
	 
	    // $data = json_decode($json, TRUE);
	     
	    /*
	    $sources = array();
	    $sourceurltoreq = 'http://wwwdev.ondeficar.com/api/hotels/sources?id='.$params['id'];
	    $sourceurltoreq .= '&key='.$options['central_apikey'];
	    $sourcejson      = file_get_contents($sourceurltoreq);
	    $sourcedata      = json_decode($sourcejson, TRUE);

	    if($sourcedata['success']){
	         $sources = $sourcedata['sources'];
	    }
	    */
	    // var_dump($data['rooms'][0]);
	    // exit(0);

	    global $currency;
	    $currency = $data['rooms'][0]['currency'];

	    if ($data['success']) {
	        if ($data['room_count'] > 0) {
	            $rooms = array();
	            $rooms['roomsdata'] = $data;
	            $rooms['id'] = $params['id'];
	            $endDate = gmdate($params['date_format_DP'], strtotime("-1 day", strtotime($enddate)));
	            if($endDate == '')
	            	$endDate = $enddate;
	            $days = $this->GetDays($startdate, $endDate, $params['date_format_DP']);
	            $years = $this->GetYears();
	            if($params['promo_code'])
	            	$couponapplied = true;
	           	else 
	           		$couponapplied = false;
	            $template_file = 'roomavailable.php';

	            if (file_exists(TEMPLATEPATH.'/mybookings-light/' . $template_file)) {
	                include (TEMPLATEPATH.'/mybookings-light/' . $template_file);
	            } else {
	                include(plugin_dir_path( __FILE__ ) .'partials/'. $template_file);
	            }
	        } else {
	            echo  '<div class="cb_error warning">
	                    <h4 style="text-align:center;">'.__('Sorry, but there is no accommodation available on selected dates. Please modify the above information to make a new search.', $this->cloudbeds_hotel_management).'</h4></div>';
	        }

	    } else {
	        echo '--ERROR--';
	        $return =  '<div class="cb_error alert">'.$data['message'].'</div>';
	    }
	    echo $return;
	}


	function cloudbeds_api_reservation(){

		$data                      = array();
		$options                   = array(
			'api_key'	=> $this->cb_hm_options('_cloudbeds_api_key','', false )
		);   

		// $data['hotel']             = isset($_POST['id'])                    ? $_POST['id']        : ''; 
		$data['propertyID']			= isset($_POST['id']) ? $_POST['id'] : ''; 

		$data['lang']				= isset($_POST['lang']) ? $_POST['lang'] : 'en';

		$data['date_format_DP']		= isset($_POST['date_format_DP']) ? $_POST['date_format_DP'] : 'm/d/Y';

		$data['checkin']			= isset($_POST['selected_checkin'])      ? $_POST['selected_checkin']  : date('m/d/Y');

		$data['checkout']			= isset($_POST['selected_checkout'])     ? $_POST['selected_checkout'] : date('m/d/Y', strtotime('tomorrow'));

		$selected_room_qty			= $data['selected_room_qty'] = isset($_POST['selected_room_qty']) ? $_POST['selected_room_qty'] : array();  
		// room ID 726 and 727 - define the room ID -> quantiry      

		$selected_adults			= $data['selected_adults'] = isset($_POST['selected_adults']) ? $_POST['selected_adults']   : array(); 

		$selected_kids				= $data['selected_kids'] = isset($_POST['selected_kids']) ? $_POST['selected_kids'] : array(); 


		$data['payment_method']   = isset($_POST['payment_method'])         ?  $_POST['payment_method']   : ''; 

		$data['choose_bank']      = isset($_POST['choose_bank'])            ?  $_POST['choose_bank']      : ''; 

		$data['choose_card']      = isset($_POST['choose_card'])            ?  $_POST['choose_card']      : ''; 

		$data['name']             = isset($_POST['first_name'])             ?  $_POST['first_name']       : ''; 

		$data['last_name']        = isset($_POST['last_name'])              ?  $_POST['last_name']        : ''; 

		$data['email']            = isset($_POST['email'])                  ?  $_POST['email']            : ''; 

		$data['phone']            = isset($_POST['phone'])                  ?  $_POST['phone']            : ''; 

		$data['cell']             = isset($_POST['cell_phone'])             ?  $_POST['cell_phone']       : ''; 

		$data['zip']              = isset($_POST['zip'])                    ?  $_POST['zip']              : ''; 

		$data['zip_f']            = isset($_POST['zip_f'])                  ?  $_POST['zip_f']            : ''; 

		$data['country']          = isset($_POST['country'])                ?  $_POST['country']          : ''; 

		$data['street']           = isset($_POST['street'])                 ?  $_POST['street']           : ''; 

		$data['number']           = isset($_POST['number'])                 ?  $_POST['number']           : ''; 

		$data['complement']       = isset($_POST['complement'])             ?  $_POST['complement']       : ''; 

		$data['neighborhood']     = isset($_POST['neighborhood'])           ?  $_POST['neighborhood']     : ''; 

		$data['city']             = isset($_POST['city'])                   ?  $_POST['city']             : ''; 

		$data['state']            = isset($_POST['state'])                  ?  $_POST['state']            : ''; 

		$data['cpf']              = isset($_POST['cpf'])                    ?  $_POST['cpf']              : ''; 

		$data['rg']               = isset($_POST['rg'])                     ?  $_POST['rg']               : ''; 

		$data['issuer']           = isset($_POST['issuer'])                 ?  $_POST['issuer']           : ''; 

		$data['selected_room_total']  = isset($_POST['selected_room_total'])    ?  $_POST['selected_room_total']          : ''; 

		$data['selected_room_name']   = isset($_POST['selected_room_name'])     ?  $_POST['selected_room_name']           : ''; 


		$data['total_advance']  = isset($_POST['total_advance'])    ?  $_POST['total_advance']          : ''; 

		$data['grand_total']   = isset($_POST['grand_total'])     ?  $_POST['grand_total']           : ''; 

		$issue_day     = isset($_POST['issue_day'])                       ? str_pad($_POST['issue_day'], 2, '0', STR_PAD_LEFT) : '02';

		$issue_month   = isset($_POST['issue_month'])                     ? str_pad($_POST['issue_month'], 2, '0', STR_PAD_LEFT) : '02';

		$issue_year    = isset($_POST['issue_year'])                      ? str_pad($_POST['issue_year'], 4, '0', STR_PAD_LEFT) : date('Y');

		$data['issue_date']         = $issue_year.'-'.$issue_month.'-'.$issue_day;  // Y-m-d


		$data['issuer_state']       = isset($_POST['issuer_state'])   ?  $_POST['issuer_state']              : ''; 
		$birthday_day     = isset($_POST['birthday_day'])             ? str_pad($_POST['birthday_day'], 2, '0', STR_PAD_LEFT) : '02';

		$birthday_month   = isset($_POST['birthday_month'])           ? str_pad($_POST['birthday_month'], 2, '0', STR_PAD_LEFT) : '02';

		$birthday_year    = isset($_POST['birthday_year'])            ? str_pad($_POST['birthday_year'], 4, '0', STR_PAD_LEFT) : date('Y');

		$data['birthday']         = $birthday_year.'-'.$birthday_month.'-'.$birthday_day;  // Y-m-d

		$data['gender']           = isset($_POST['gender'])             ?  $_POST['gender'] : 'M'; 

		$data['first_time']       = true; 

		$data['special_requests'] = isset($_POST['special_requests'])   ?  $_POST['special_requests']         : ''; 

		$data['cardholder_name']  = isset($_POST['cardholder_name'])    ?  $_POST['cardholder_name']          : ''; 

		$data['card_number']      = isset($_POST['card_number'])        ?  $_POST['card_number']              : ''; 

		$exp_month        = isset($_POST['exp_month'])                  ? str_pad($_POST['exp_month'], 2, '0', STR_PAD_LEFT) : '02';

		$exp_year         = isset($_POST['exp_year'])                   ?  $_POST['exp_year'] : date('Y');

		$data['exp_date']         = str_pad($exp_month, 2, '0', STR_PAD_LEFT).'/'.$exp_year; 


		$data['cvv']              = isset($_POST['cvv'])                ?  $_POST['cvv']                : ''; 

	    $data['hear_about']       = isset($_POST['hear_about'])         ?  $_POST['hear_about']         : ''; 

		$data['source']           = isset($_POST['source'])          ? $_POST['source']     : ''; 
	    if(!empty($data['propertyID'])){   

			// $this->call_api_reservation($options, $data);
			$this->call_apinew_reservation($data);

	    }else{

			echo '<h4> Error ! Try Again </h4><div style="display:none"> Invalid PropertyID </div>';

	    }

	    die();

	}




	public function call_api_reservation($options, $param){
		$return = '';  

		$url = 'http://hotels.cloudbeds.com/api/reservation/?key='.$options['api_key'];

		$postData = array();  

		$postData['key']              = $options['api_key'];

		$postData['hotel']            = $param['hotel'];

		$postData['checkin']          = $this->mdyTogdsDateTypeFromDate( $param['checkin'], $param['date_format_DP'] ); //(date formatted Y-m-d)

		$postData['checkout']         = $this->mdyTogdsDateTypeFromDate( $param['checkout'], $param['date_format_DP'] ); //(date formatted Y-m-d)

		$postData['rooms'] =  $postData['adults'] =   $postData['kids'] = array();


		foreach ($param['selected_room_qty'] as $key => $value) { 
			$postData['rooms']['roomTypeID'] = $key;
			$postData['rooms']['quantity']   =  $value; 

		}     

		foreach ($param['selected_adults'] as $key => $value) {

			$postData['adults']['roomTypeID'] = $key;
			$postData['adults']['quantity']   =  $value; 

			//$postData['adults']["$key"] =  (int)$value;

		}     

		foreach ($param['selected_kids'] as $key => $value) {
			$postData['kids']['roomTypeID'] = $key;
			$postData['kids']['quantity']   =  $value; 
			//$postData['kids']["$key"] =  (int)$value;

		}   


		$postData['payment_method']   = $param['payment_method']; 

		$postData['choose_bank']      = $param['choose_bank']; 

		$postData['choose_card']      = $param['choose_card']; 

		$postData['name']             = $param['name']; 

		$postData['last_name']        = $param['last_name']; 

		$postData['email']            = $param['email']; 

		$postData['phone']            = $param['phone']; 

		$postData['cell']             = $param['cell']; 

		$postData['zip']              = $param['zip']; 

		$postData['country']          = $param['country']; 

		$postData['street']           = $param['street']; 

		$postData['number']           = $param['number']; 

		$postData['complement']       = $param['complement']; 

		$postData['neighborhood']     = $param['neighborhood']; 

		$postData['city']             = $param['city']; 

		$postData['state']            = $param['state']; 

		$postData['cpf']              = $param['cpf']; 

		$postData['rg']               = $param['rg']; 

		$postData['issuer']           = $param['issuer']; 

		$postData['issue_date']       = $param['issue_date']; 

		$postData['issuer_state']     = $param['issuer_state']; 

		$postData['birthday']         = $param['birthday']; 

		$postData['gender']           = $param['gender']; 

		$postData['first_time']       = $param['first_time']; 

		$postData['special_requests'] = $param['special_requests']; 

		$postData['cardholder_name']  = $param['cardholder_name']; 

		$postData['card_number']      = $param['card_number']; 

		$postData['exp_date']         = $param['exp_date']; 

		$postData['cvv']              = $param['cvv'];



		$postData['room_total'] = $postData['selected_room_total']      = $param['selected_room_total']; 

		$postData['room_name']  = $postData['selected_room_name']        = $param['selected_room_name']; 

		$postData['selected_room_qty'] = $param['selected_room_qty'];

		$postData['grand_total'] = $param['grand_total'];
		
		$postData['total_advance'] = $param['total_advance'];

		//$postData['source']           = !empty($param['source']) ? $param['source'] : 'Enbloc Hotels'; 

		$postData['source']           = !empty($options['source']) ? $options['source'] : 'Enbloc'; 



		$send_email                   = (isset($options['emailsender']) && 0 == $options['emailsender'])  ? 0 : 1; 

		$postData['send_email']       = $send_email; // 0 / 1 


		$curldata = array();

		$curldata['key'] = $postData['key'];

		$curldata['data'] = json_encode($postData); 


		$ch = curl_init();

		curl_setopt($ch, CURLOPT_URL, $url);

		curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);

		curl_setopt($ch, CURLOPT_POST, 1);

		curl_setopt($ch, CURLOPT_POSTFIELDS, $curldata);

		$result = curl_exec($ch);

		curl_close($ch);

		$data = json_decode($result, TRUE); 

		$userinfo['name'] = $param['name']; 

		$userinfo['last_name']  = $param['last_name']; 

		$userinfo['email'] = $param['email']; 



		if($data['success']){ 

			// $this->generate_email_template($postData, $userinfo, $data['reservation_id']);
			echo  '<div class="cb_error success">'.__('Thank you for your booking, your booking information has been sent to your email address', $this->cloudbeds_hotel_management).'</div>';   

		}else{   

			$return = '<div class="cb_error alert">'.$data['message'].'</div>';

		} 

	    echo  $return ;

	}


	public function email_template_update($text, $formats = array()) {

		// available formats are : [customer-name], [reservation-details], [customer-email], [room-name]

		foreach ($formats as $value) {

			$text = str_replace('['.$value['name'].']', $value['value'], $text);

		}

		return $text;

	}


	private function generate_email_template($data, $userinfo, $reference_id){ //$reference_id = 0;
	  	
	  
	  	$sender_name = $this->cb_hm_options('_sender_name', '', false );
		$sender_email = $this->cb_hm_options('_sender_email', '', false );
		$subject = $this->cb_hm_options('_email_subject', '', false );
		$email_message .= $this->cb_hm_options('_email_message','', false );
		$sender = $sender_name.'<'.$sender_email.'>';
		$receiver = $userinfo['name'].' '.$userinfo['last_name'].'<'.$userinfo['email'].'>';
		$header[] = 'From: '.$sender;


		$header[] = 'To: '.$receiver;
		// decript message codes
		$guestname = $userinfo['name'].' '.$userinfo['last_name'];
		// Currency
		$curCode = $this->cb_hm_options('_currency_code','USD' );
		$curSymbol = $this->cb_hm_options('_payment_currency', '$');
		$curName = $this->cb_hm_options('_currency_name', 'US Dollar');
		$curPosition = $this->cb_hm_options('_currency_position', 'before');

		$orderdetails = '';
		$orderdetails .=' 
        <div class="orderdetails">
            <table class="rooms">
                <thead>
                    <tr>
                        <th>'.__('Check-In', $this->cloudbeds_hotel_management).':</th>
                        <th>'.__('Check-Out', $this->cloudbeds_hotel_management).':</th>
                        <th>'.__('Room(s)', $this->cloudbeds_hotel_management).'</th>
                        <th>'.__('Adults', $this->cloudbeds_hotel_management).':</th>
                        <th>'.__('Kids', $this->cloudbeds_hotel_management).':</th>
                        <th>'.__('Price Total', $this->cloudbeds_hotel_management).':</th>
                        <th>'.__('Appartment', $this->cloudbeds_hotel_management).':</th>
                    </tr>
                </thead>
                <tbody>';

	                foreach ($data['selected_room_qty'] as $roomid => $value) {
	                     $orderdetails .= '<tr>
                            <td>'.$data['checkin'].'</td>
                            <td>'.$data['checkout'].'</td>
                            <td>'.$value.'</td>
                            <td>'.$data['selected_adults'][$roomid].'</td>
                            <td>'.$data['selected_kids'][$roomid].'</td>';
                    	if($curPosition == 'before') { 
                        	$orderdetails .= '<td>'.$curSymbol.' '.number_format(($data['selected_room_total'][$roomid] * (int)$value), 2, '.', ',').'</td>';
                        }else {
                        	$orderdetails .= '<td>'.number_format(($data['selected_room_total'][$roomid] * (int)$value), 2, '.', ',').''.$curSymbol.'</td>';
                        }
                        $orderdetails .= '<td>'.$data['selected_room_name'][$roomid].'</td>
                        </tr>';
	                } 

    	$orderdetails .='                
                </tbody>
            </table>
        </div><div class="total text-right">
            <div class="omrow">
                <div class="omgrid_10"><h4>'.__('Total', $this->cloudbeds_hotel_management).':</h4></div>';
	            if($curPosition == 'before'){
	            	$orderdetails .='<div class="omgrid_2">'.$curSymbol.' '. number_format($data['grand_total'], 2, '.', ',') .'</div>';
	            }else {
	            	$orderdetails .='<div class="omgrid_2">'. number_format($data['grand_total'], 2, '.', ',') .''.$curSymbol.'</div>';
	            }
            $orderdetails .='
            </div>
            <div class="omrow">
                <div class="omgrid_10"><h4>'.__('Total Advance', $this->cloudbeds_hotel_management).':</h4></div>';
             	if($curPosition == 'before'){
                	$orderdetails .='<div class="omgrid_2">'.$curSymbol.' '. number_format($data['total_advance'], 2, '.', ',') .'</div>';
               	}else {
                	$orderdetails .='<div class="omgrid_2">'.  number_format($data['total_advance'], 2, '.', ',') .''.$curSymbol.'</div>';
                }
            $orderdetails .='
            </div>
            <div class="omrow">
                <div class="omgrid_10"><h4>'.__('Toal Pay While Checked in', $this->cloudbeds_hotel_management).':</h4></div>';
                if($curPosition == 'before'){
                	$orderdetails .='<div class="omgrid_2">'.$curSymbol.' '. number_format(( (float)$data['grand_total'] - (float)$param['total_advance'] ) , 2, '.', ',') .'</div>';
               	}else {
                	$orderdetails .='<div class="omgrid_2">'. number_format(( (float)$data['grand_total'] - (float)$param['total_advance'] ) , 2, '.', ',') .''.$curSymbol.'</div>';
                }
            $orderdetails .='
            </div>
        </div>';

		$email_message = str_replace('{{RESERVATION-NUMBER}}', $reference_id, $email_message);
		$email_message = str_replace('{{RESERVATION-DETAILS}}', $orderdetails, $email_message);
		$email_message = str_replace('{{GUESTNAME}}', $guestname, $email_message);
		add_filter( 'wp_mail_content_type', array($this, 'set_html_content_type') );
		wp_mail($receiver, $subject, $email_message, $header);
	}

	public function set_html_content_type(){
		return 'text/html';
	}


	private function cb_hm_options($option_name = '_logo', $default_val = '', $echo = false){
		$return = $default_val;	
		// get_option( $option_name, $default );  
		$variable = get_option($this->cloudbeds_hotel_management . $option_name);
		if(!is_array($variable)) 
			$variable = stripcslashes(trim($variable)); 	
		if(!empty($variable))$return = $variable; 		
		if($echo) 
			echo $return;		
		else 
		    return $return; 		
	}
	private function cb_post_meta($post_id = 0, $meta_key = '', $default_val = '',  $single = true, $echo = false){

		$return = $default_val;	    
		
		$key = $this->cloudbeds_hotel_management.$meta_key;
		$variable = get_post_meta( $post_id, $key, $single);

		if(!empty($variable))$return = $variable; 		
		if($echo) 
			echo $return;		
		else 
		    return $return; 	
	}

	private function cb_room_sleeps($roomid){
		$return = '';
		$single = $this->cb_post_meta($roomid, '_single', 0, true);
		$double = $this->cb_post_meta($roomid, '_double', 0, true);
		$queen_size = $this->cb_post_meta($roomid, '_queen_size', 0, true);
		$king_size = $this->cb_post_meta($roomid, '_king_size', 0, true);
		if($single > 0)
			$return .= $single.' Single Bed(s)';
		if($double > 0)
			$return .= ', '.$double.' Double Bed(s)';
		if($queen_size > 0)
			$return .= ', '.$queen_size.' Queen Size Bed(s)';
		if($king_size > 0)
			$return .= ', '.$king_size.' King Size Bed(s)';
		return $return;
	}

	private function money_format($format, $number)
    {
        return $number;
        
        $regex  = '/%((?:[\^!\-]|\+|\(|\=.)*)([0-9]+)?'.
                  '(?:#([0-9]+))?(?:\.([0-9]+))?([in%])/';
        if (setlocale(LC_MONETARY, 0) == 'C') {
            setlocale(LC_MONETARY, '');
        }
        $locale = localeconv();
        preg_match_all($regex, $format, $matches, PREG_SET_ORDER);
        foreach ($matches as $fmatch) {
            $value = floatval($number);
            $flags = array(
                'fillchar'  => preg_match('/\=(.)/', $fmatch[1], $match) ?
                               $match[1] : ' ',
                'nogroup'   => preg_match('/\^/', $fmatch[1]) > 0,
                'usesignal' => preg_match('/\+|\(/', $fmatch[1], $match) ?
                               $match[0] : '+',
                'nosimbol'  => preg_match('/\!/', $fmatch[1]) > 0,
                'isleft'    => preg_match('/\-/', $fmatch[1]) > 0
            );
            $width      = trim($fmatch[2]) ? (int)$fmatch[2] : 0;
            $left       = trim($fmatch[3]) ? (int)$fmatch[3] : 0;
            $right      = trim($fmatch[4]) ? (int)$fmatch[4] : $locale['int_frac_digits'];
            $conversion = $fmatch[5];

            $positive = true;
            if ($value < 0) {
                $positive = false;
                $value  *= -1;
            }
            $letter = $positive ? 'p' : 'n';

            $prefix = $suffix = $cprefix = $csuffix = $signal = '';

            $signal = $positive ? $locale['positive_sign'] : $locale['negative_sign'];
            switch (true) {
                case $locale["{$letter}_sign_posn"] == 1 && $flags['usesignal'] == '+':
                    $prefix = $signal;
                    break;
                case $locale["{$letter}_sign_posn"] == 2 && $flags['usesignal'] == '+':
                    $suffix = $signal;
                    break;
                case $locale["{$letter}_sign_posn"] == 3 && $flags['usesignal'] == '+':
                    $cprefix = $signal;
                    break;
                case $locale["{$letter}_sign_posn"] == 4 && $flags['usesignal'] == '+':
                    $csuffix = $signal;
                    break;
                case $flags['usesignal'] == '(':
                case $locale["{$letter}_sign_posn"] == 0:
                    $prefix = '(';
                    $suffix = ')';
                    break;
            }
            if (!$flags['nosimbol']) {
              $currency = $cprefix .
                            ($conversion == 'i' ? $locale['int_curr_symbol'] : $locale['currency_symbol']) .
                            $csuffix;
            } else {
              $currency = '';
            }
            $space  = $locale["{$letter}_sep_by_space"] ? ' ' : '';

            $value = number_format($value, $right, $locale['mon_decimal_point'],
                     $flags['nogroup'] ? '' : $locale['mon_thousands_sep']);
            $value = @explode($locale['mon_decimal_point'], $value);

            $n = strlen($prefix) + strlen($currency) + strlen($value[0]);
            if ($left > 0 && $left > $n) {
                $value[0] = str_repeat($flags['fillchar'], $left - $n) . $value[0];
            }
            
            $value = @implode($locale['mon_decimal_point'], $value);
            if ($locale["{$letter}_cs_precedes"]) {
                $value = $prefix . $currency . $space . $value . $suffix;
            } else {
                $value = $prefix . $value . $space . $currency . $suffix;
            }
            if ($width > 0) {
                $value = str_pad($value, $width, $flags['fillchar'], $flags['isleft'] ?
                         STR_PAD_RIGHT : STR_PAD_LEFT);
            }

            $format = str_replace($fmatch[0], $value, $format);
        }
        return str_replace('USD', '', $format);
    }
    function format_currency($value){
	    global $currency;

	    // var_dump($currency);

	    $symbol = $currency['symbol'];
	    $position = $currency['position'];

	    if($position == 'before')
	        return $symbol.' '.$value;
	    else
	        return $value.' '.$symbol;
	}
    function format_api_currency($value){
	    global $currency;

	    // var_dump($currency);

	    $symbol = $currency['currencySymbol'];
	    $position = $currency['currencyPosition'];

	    if($position == 'before')
	        return $symbol.' '.$value;
	    else
	        return $value.' '.$symbol;
	}

	function cloudbeds_dump($var)
    {

         $debug_force_off = true; 
         
         if (DEVMODE && !$debug_force_off) {

            echo '<style type="text/css">.devversion {
                display: block !important;
            }</style>';
            echo '<div class="devversion"><pre>';

            if (is_array($var)) {
                foreach ($var as $key => $value) {

                    echo '<p><strong>' . $key . '</strong> : ';

                    if (is_array($value)) {
                        foreach ($value as $k => $v) {

                            if (is_array($v)) {
                                foreach ($v as $k1 => $v1) {
                                    echo '<p><strong>' . $k1 . '</strong> : ' . $v1 . '</p>';
                                }
                            } else {
                                echo var_export($v, true);
                            }

                        }


                    } else {
                        echo var_export($value, true);
                    }

                }

            } else {
                echo var_export($var, true);
            }


            echo '</pre></div>';

         } else {  echo '<style type="text/css">.devversion {
                display: none !important;
            }</style>';

        }return;
    }

	public function get_countries($id = false){
		$countries = array(
			'AF' => 'Afghanistan','AX' => 'Aland Islands','AL' => 'Albania','DZ' => 'Algeria','AS' => 'American Samoa','AD' => 'Andorra','AO' => 'Angola','AI' => 'Anguilla','AQ' => 'Antarctica','AG' => 'Antigua And Barbuda','AR' => 'Argentina','AM' => 'Armenia','AW' => 'Aruba','AU' => 'Australia','AT' => 'Austria','AZ' => 'Azerbaijan','BS' => 'Bahamas','BH' => 'Bahrain','BD' => 'Bangladesh','BB' => 'Barbados','BY' => 'Belarus','BE' => 'Belgium','BZ' => 'Belize','BJ' => 'Benin','BM' => 'Bermuda','BT' => 'Bhutan','BO' => 'Bolivia','BA' => 'Bosnia And Herzegovina','BW' => 'Botswana','BV' => 'Bouvet Island','BR' => 'Brazil','IO' => 'British Indian Ocean Territory','BN' => 'Brunei Darussalam','BG' => 'Bulgaria','BF' => 'Burkina Faso','BI' => 'Burundi','KH' => 'Cambodia',                        'CM' => 'Cameroon','CA' => 'Canada','CV' => 'Cape Verde','KY' => 'Cayman Islands','CF' => 'Central African Republic','TD' => 'Chad','CL' => 'Chile','CN' => 'China','CX' => 'Christmas Island','CC' => 'Cocos (Keeling) Islands','CO' => 'Colombia','KM' => 'Comoros','CG' => 'Congo','CD' => 'Congo, Democratic Republic','CK' => 'Cook Islands','CR' => 'Costa Rica','CI' => 'Cote D\'Ivoire','HR' => 'Croatia','CU' => 'Cuba','CY' => 'Cyprus','CZ' => 'Czech Republic','DK' => 'Denmark','DJ' => 'Djibouti','DM' => 'Dominica','DO' => 'Dominican Republic','EC' => 'Ecuador','EG' => 'Egypt','SV' => 'El Salvador','GQ' => 'Equatorial Guinea','ER' => 'Eritrea','EE' => 'Estonia','ET' => 'Ethiopia','FK' => 'Falkland Islands (Malvinas)', 'FO' => 'Faroe Islands','FJ' => 'Fiji','FI' => 'Finland','FR' => 'France','GF' => 'French Guiana','PF' => 'French Polynesia','TF' => 'French Southern Territories','GA' => 'Gabon','GM' => 'Gambia','GE' => 'Georgia','DE' => 'Germany','GH' => 'Ghana','GI' => 'Gibraltar','GR' => 'Greece','GL' => 'Greenland','GD' => 'Grenada','GP' => 'Guadeloupe','GU' => 'Guam','GT' => 'Guatemala','GG' => 'Guernsey','GN' => 'Guinea','GW' => 'Guinea-Bissau','GY' => 'Guyana','HT' => 'Haiti','HM' => 'Heard Island & Mcdonald Islands','VA' => 'Holy See (Vatican City State)',                        'HN' => 'Honduras', 'HK' => 'Hong Kong','HU' => 'Hungary','IS' => 'Iceland','IN' => 'India','ID' => 'Indonesia','IR' => 'Iran, Islamic Republic Of','IQ' => 'Iraq','IE' => 'Ireland','IM' => 'Isle Of Man','IL' => 'Israel','IT' => 'Italy','JM' => 'Jamaica','JP' => 'Japan','JE' => 'Jersey','JO' => 'Jordan','KZ' => 'Kazakhstan','KE' => 'Kenya','KI' => 'Kiribati','KR' => 'Korea','KW' => 'Kuwait','KG' => 'Kyrgyzstan','LA' => 'Lao People\'s Democratic Republic','LV' => 'Latvia','LB' => 'Lebanon','LS' => 'Lesotho','LR' => 'Liberia','LY' => 'Libyan Arab Jamahiriya','LI' => 'Liechtenstein','LT' => 'Lithuania','LU' => 'Luxembourg','MO' => 'Macao','MK' => 'Macedonia','MG' => 'Madagascar','MW' => 'Malawi','MY' => 'Malaysia','MV' => 'Maldives','ML' => 'Mali','MT' => 'Malta','MH' => 'Marshall Islands',                        'MQ' => 'Martinique','MR' => 'Mauritania','MU' => 'Mauritius','YT' => 'Mayotte','MX' => 'Mexico','FM' => 'Micronesia, Federated States Of','MD' => 'Moldova','MC' => 'Monaco','MN' => 'Mongolia','ME' => 'Montenegro','MS' => 'Montserrat','MA' => 'Morocco','MZ' => 'Mozambique','MM' => 'Myanmar','NA' => 'Namibia','NR' => 'Nauru','NP' => 'Nepal','NL' => 'Netherlands','AN' => 'Netherlands Antilles','NC' => 'New Caledonia','NZ' => 'New Zealand','NI' => 'Nicaragua','NE' => 'Niger','NG' => 'Nigeria','NU' => 'Niue','NF' => 'Norfolk Island','MP' => 'Northern Mariana Islands','NO' => 'Norway','OM' => 'Oman','PK' => 'Pakistan','PW' => 'Palau','PS' => 'Palestinian Territory, Occupied','PA' => 'Panama','PG' => 'Papua New Guinea','PY' => 'Paraguay','PE' => 'Peru','PH' => 'Philippines','PN' => 'Pitcairn','PL' => 'Poland','PT' => 'Portugal','PR' => 'Puerto Rico','QA' => 'Qatar','RE' => 'Reunion','RO' => 'Romania','RU' => 'Russian Federation','RW' => 'Rwanda','BL' => 'Saint Barthelemy','SH' => 'Saint Helena','KN' => 'Saint Kitts And Nevis','LC' => 'Saint Lucia','MF' => 'Saint Martin','PM' => 'Saint Pierre And Miquelon','VC' => 'Saint Vincent And Grenadines','WS' => 'Samoa',                        'SM' => 'San Marino','ST' => 'Sao Tome And Principe','SA' => 'Saudi Arabia','SN' => 'Senegal','RS' => 'Serbia','SC' => 'Seychelles','SL' => 'Sierra Leone','SG' => 'Singapore','SK' => 'Slovakia','SI' => 'Slovenia','SB' => 'Solomon Islands','SO' => 'Somalia','ZA' => 'South Africa','GS' => 'South Georgia And Sandwich Isl.','ES' => 'Spain','LK' => 'Sri Lanka','SD' => 'Sudan','SR' => 'Suriname','SJ' => 'Svalbard And Jan Mayen','SZ' => 'Swaziland','SE' => 'Sweden','CH' => 'Switzerland','SY' => 'Syrian Arab Republic','TW' => 'Taiwan','TJ' => 'Tajikistan','TZ' => 'Tanzania','TH' => 'Thailand','TL' => 'Timor-Leste','TG' => 'Togo','TK' => 'Tokelau','TO' => 'Tonga','TT' => 'Trinidad And Tobago','TN' => 'Tunisia','TR' => 'Turkey','TM' => 'Turkmenistan','TC' => 'Turks And Caicos Islands','TV' => 'Tuvalu', 'UG' => 'Uganda', 'UA' => 'Ukraine','AE' => 'United Arab Emirates','GB' => 'United Kingdom','US' => 'United States','UM' => 'United States Outlying Islands','UY' => 'Uruguay','UZ' => 'Uzbekistan','VU' => 'Vanuatu','VE' => 'Venezuela','VN' => 'Viet Nam','VG' => 'Virgin Islands, British','VI' => 'Virgin Islands, U.S.','WF' => 'Wallis And Futuna','EH' => 'Western Sahara','YE' => 'Yemen','ZM' => 'Zambia','ZW' => 'Zimbabwe'  );
		if($id){
			return $countries[$id];
		}else {
			return $countries;
		}
	}

	public function get_extra_user_info(){
		$titleoptions = array('Mr' => 'Mr', 'Mrs' => 'Mrs', 'Ms' => 'Ms', 'Miss' => 'Miss');

		$extra_user_info = array(
           array('type'=> 'select', 'id' => 'cb_hm_title', 'title' => 'Title', 'description' =>'Title (Mr, Mrs, Ms, Miss)', 'options' => $titleoptions),
           array('id' => 'cb_hm_address_1', 'title' => 'Address Line 1', 'description' =>'Address Line one'),
           array('id' => 'cb_hm_address_2', 'title' => 'Address Line 2', 'description' =>'Address Line two'),
           array('id' => 'cb_hm_address_3', 'title' => 'Address Line 3', 'description' =>'Address Line three'),
           array('id' => 'cb_hm_city', 'title' => 'City', 'description' =>'City Name'),
           array('id' => 'cb_hm_state', 'title' => 'State', 'description' =>'State name'),
           array('type'=> 'select', 'id' => 'cb_hm_country', 'title' => 'Country', 'description' =>'Country name', 'options' => $this->get_countries()),
           array('id' => 'cb_hm_postcode', 'title' => 'Postcode', 'description' =>'Postcode'),
           array('id' => 'cb_hm_phoneday', 'title' => 'Phone (daytime)', 'description' =>'Phone Number used at day time'),
           array('id' => 'cb_hm_phonenight', 'title' => 'Phone (evening)', 'description' =>'Phone Number used at evening time'),
           array('id' => 'cb_hm_mobile', 'title' => 'Mobile', 'description' =>'Mobile phone number')  
    	);
		return $extra_user_info;
	}

	public function mdyDateToymdFormate($mdy, $dateformat = 'm/d/Y'){
        switch ($dateformat) {
            case 'd/m/Y':
                if (strstr($mdy, '/')) list($day, $month, $year) = explode("/", $mdy);
                if (strstr($mdy, '-')) list($day, $month, $year) = explode("-", $mdy);
                break;

            default:
                if (strstr($mdy, '/')) list($month, $day, $year) = explode("/", $mdy);
                if (strstr($mdy, '-')) list($month, $day, $year) = explode("-", $mdy);
                break;
        }
        return "$year-$month-$day";
    }
    public function mdyTogdsDateTypeFromDate($mdy, $dateformat = 'm/d/Y'){
        // if (strstr($mdy, '/')) list($month, $day, $year) = explode("/", $mdy);
        // if (strstr($mdy, '-')) list($month, $day, $year) = explode("-", $mdy);
        $mdy = DateTime::createFromFormat($dateformat, $mdy);
        return $mdy->format('Y-m-d');
        // $mdy = str_replace('/', '-', $mdy);
        // return date("Y-m-d", strtotime($mdy) );
    }

    public function GetDays($sStartDate, $sEndDate, $dateformat){

    	$formatchanged = false;
    	if(strtolower($dateformat) == 'd/m/y'){

    		$sformat = DateTime::createFromFormat('d/m/Y', $sStartDate);
    		$sStartDate = $sformat->format('Y-m-d');
    		$eformat = DateTime::createFromFormat('d/m/Y', $sEndDate);
    		$sEndDate = $eformat->format('Y-m-d');

    		$sStartDate = str_replace('/', '-', $sStartDate);
    		$sEndDate = str_replace('/', '-', $sEndDate);
    		$dateformat = 'Y-m-d';
    		$formatchanged = true;
    	}
    	$sStartDate = gmdate($dateformat, strtotime($sStartDate));
	    $sEndDate = gmdate($dateformat, strtotime($sEndDate));
        if($formatchanged)
        	$aDays[] = str_replace('-', '/', $sStartDate);
        else 
        	$aDays[] = $sStartDate;

        $sCurrentDate = $sStartDate;

        while ($sCurrentDate < $sEndDate) {
            $sCurrentDate = gmdate($dateformat, strtotime("+1 day", strtotime($sCurrentDate)));

	        if($formatchanged)
	        	$aDays[] = str_replace('-', '/', $sCurrentDate);
	        else
            	$aDays[] = $sCurrentDate;
        }
        return $aDays;
    }
    function GetYears($startyear = ''){
        if ($startyear) {
            $years[] = $startyear;
        } else {
            $years[] = $startyear = date('Y');
        }
        for ($i = 1; $i < 11; $i++) {
            $years[] = (int)$startyear + $i;
        }
        return $years;
    }

    // Teting thankyou
    private function get_thanks_message($reference_id, $output = true){
    	global $wpdb;

	  	// $reference_id = 'RES-20150615-070900-1';
		$booktable       = $wpdb->prefix.$this->bookingtable;
		$roomratestable  = $wpdb->prefix.$this->roomratedb;
		$cursym = $this->cb_hm_options('_payment_currency', '&pound;', false);

		$sql = "SELECT 
		`id`, 
		`user_id`,
		`booking_ref`, 
		`roomtype_id`, 
		`roomquantity`, 
		`stay`, 
		`arriving`, 
		`departing`, 
		`adults`, 
		`kids`, 
		`guests`, 
		SUM( qtprice ) AS  'subtotal'
		FROM  `$booktable`
		WHERE  `booking_ref` =  '$reference_id'
		GROUP BY  `roomtype_id`";
		// $results = $wpdb->get_results( "SELECT * FROM $booktable WHERE `booking_ref` = '$reference_id' AND `status` = '1'" );
		$results = $wpdb->get_results($sql);
		$orders = array();
		if(!empty($results) && isset($results[0])){
			$user = get_user_by('id', $results[0]->user_id );
			foreach ($results as $row) {
				if((int)$row->adults == 0)
					$adults = 1;
				else 
					$adults = $row->adults;
				$orders[] = array(
					'checkin'	=> date('l, jS M Y', strtotime($row->arriving) ),
					'checkout'	=> date('l, jS M Y', strtotime($row->departing) ),
					'adults'	=> $adults,
					'kids'		=> $row->kids,
					'nights'	=> $row->stay,
					'total'		=> $row->subtotal,
					'name'		=> get_the_title($row->roomtype_id),
				);
			}
			// var_dump($results);
			$orderhtml = $this->get_order_details($orders);
			// return $orderhtml;
		}else {
			$orderhtml = '';
		}

    	$lng_local = $this->cloudbeds_hotel_management;
    	if( file_exists(TEMPLATEPATH.'/mybookings-light/public/thankyou.php') ) {
			$return = file_get_contents( TEMPLATEPATH.'/mybookings-light/public/thankyou.php' );
       	}else {
			$return = file_get_contents(plugin_dir_path( __FILE__ ).'partials/thankyou.php');
		}
    	$reservedby = __('Reserved by', $lng_local);
    	$reservation_no = __('Reservation number', $lng_local);
    	$txtbookingdetails = __('Booking details', $lng_local);
    	$txtcheckin = __('Check in', $lng_local);
    	$txtcheckout = __('Check-out', $lng_local);
    	$txtadults = __('Adults', $lng_local);
    	$txtchildren = __('Children', $lng_local);
    	$txttotal = __('Total price', $lng_local);
    	$txtappartment = __('Apartment', $lng_local);
    	$cancellation_policy = $this->cb_hm_options('_cancellation_policy', '', false);

    	$return = str_replace('{{BOOKING_DETAILS}}', $orderhtml, $return);
    	$return = str_replace('{{TXTBOOKINGDETAILS}}', $txtbookingdetails, $return);
    	$return = str_replace('{{TXTRESERVEDBY}}', $reservedby, $return);
    	$return = str_replace('{{GUEST_NAME}}', $user->first_name.' '.$user->last_name, $return);
    	$return = str_replace('{{TXTRESERVATIONNO}}', $reservation_no, $return);
    	$return = str_replace('{{RESERVATIONNO}}', $reference_id, $return);
    	$return = str_replace('{{CANCELATION_POLICY}}', $cancellation_policy, $return);
    	if(!$output){
    		$return = array(
    			'message'  	=> $return,
    			'user'	=> isset($user) ? $user : false
    		);
    	}

    	return $return;
    }

    private function get_order_details($orders){
    	$lng_local = $this->cloudbeds_hotel_management;
    	$return = '';
    	$subtotal = 0;
    	$return .= '<table border="0" cellspacing="0" cellpadding="0" class="booking-details-table">
                    <thead>
                        <tr>
                            <th class="checkin_column">
                                '.__('Check in', $lng_local).':
                            </th>
                            <th class="checkout_column">
                            	'.__('Check-out', $lng_local).':
                            </th>
                            <th class="adults_column">
                            	'.__('Adults', $lng_local).':
                            </th>
                            <th class="kids_column">
                            	'.__('Children', $lng_local).':
                            </th>
                            <th class="total_column">
                            	'.__('Total price', $lng_local).':
                            </th>
                            <th class="room_column">
                            	'.__('Apartment', $lng_local).':
                            </th>
                        </tr>
                    </thead>
                    <tbody>';
	        foreach ($orders as $order) {
	        	$subtotal += $order['total'];
	        	$return .= '
	                        <tr>
	                            <td class="checkin_column">
	                                '. $order['checkin'].'
	                            </td>
	                            <td class="checkout_column">
	                                '. $order['checkout'].'
	                            </td>
	                            <td class="adults_column">
	                                '. $order['adults'].'
	                            </td>
	                            <td class="kids_column">
	                                '. $order['kids'].'
	                            </td>
	                            <td class="total_column">
	                                '. $order['total'].'
	                            </td>
	                            <td class="room_column">
	                                '. $order['name'].'
	                            </td>
	                        </tr>';
		    }
		$return .= '    
                    </tbody>
                </table>';
        $return .= '<div style="clear:both"></div>
                <div class="values_description">
                    <p>'.__('Sub-total', $lng_local).': '.number_format($subtotal, 2, '.', ',').'
                    </p>';
        $vat = $this->cb_hm_options('_vat', '15', false );
        if((float)$vat):
			$taxvalue = (float)str_replace(',', '', $subtotal)*((float)$vat/100);
			$taxvalue = number_format($taxvalue, 2, '.', ',');
			$return .='
                    <p>
                        '.__('VAT', $lng_local).'( '.$vat.'% ): '.$taxvalue.'
                    </p>';
        else:
        	$taxvalue = 0;
        endif;
        $total = $subtotal + $taxvalue;
        $return .='
                    <p>
                    	'.__('Total', $lng_local).': '.number_format($total, 2, '.', ',').'
                    </p>
                </div>';
    	return $return;
    }

    private function get_new_access_token($client, $params, $grant_type = 'authorization_code'){
    	 
    	$response = $client->getAccessToken($this->cb_api.$this->cb_api_token_url, $grant_type, $params);
	    $info = $response['result']; 
	    if($info['error'] !=''){
	    	echo $info['message'];
	    	die();
	    }else {
		    $access_info = array(
		    	'access_token'	=> $info['access_token'],
		    	'token_timeout'	=> $info['expires_in'],
		    	'refresh_token'	=> $info['refresh_token'],
		    	'token_created'	=> current_time('timestamp' ),
		    );
		    if(get_option($this->cloudbeds_hotel_management.'_cloudbeds_api_access_info', FALSE)) { 
	            update_option($this->cloudbeds_hotel_management.'_cloudbeds_api_access_info', $access_info);
	        } else { 
	            add_option( $this->cloudbeds_hotel_management.'_cloudbeds_api_access_info', $access_info );
	        }
	        return $info['access_token'];
		}
    }

    function vdump($var){
    	echo '<pre style="text-align:left;">';
	    var_dump($var);
	    echo '</pre>';
	}
}