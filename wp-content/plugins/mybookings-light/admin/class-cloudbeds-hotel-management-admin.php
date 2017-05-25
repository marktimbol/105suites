<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       http://www.omasters.com
 * @since      0.0.1
 *
 * @package    Cloudbeds_Hotel_Management
 * @subpackage Cloudbeds_Hotel_Management/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Cloudbeds_Hotel_Management
 * @subpackage Cloudbeds_Hotel_Management/admin
 * @author     Shahinul Islam <shahinbdboy@gmail.com>
 */

if ( ! function_exists('curl_init') ) {
    throw new Exception('Your server does not seem to have CURL installed. Please have your webmaster or support team install it to use this plugin.');
}

class Cloudbeds_Hotel_Management_Admin {

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
	private $remote_path = 'https://www.cloudbeds.com/wp-plugins/mybookings-light/update.php';

	public $amenities = array('ac'=>'Air Conditioning', 'internet'=>'Internet (Wi-Fi)', 'telephone'=>'Telephone', 'tv'=>'TV', 'safe'=>'Safe', 'minibar'=>'Minibar', 'kitchen'=>'Kitchen', 'work-space'=>'Work Space', 'bath'=>'Bath', 'shower'=>'Shower', 'towels'=>'Towels', 'smoking'=>'Smoking Allowed');

	// API SETTINGS
	private $api_authorization_url 	= 'https://hotels.cloudbeds.com/api/v1.1/oauth';
	private $api_token_url 	= 'https://hotels.cloudbeds.com/api/v1.1/access_token';
	// private $api_token_url 	= 'http://wwwdev4.ondeficar.com/api/v1.1/access_token';
	// private $api_authorization_url 	= 'http://wwwdev4.ondeficar.com/api/v1.1/oauth';
	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    0.0.1
	 * @param      string    $cloudbeds_hotel_management       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $cloudbeds_hotel_management, $version ) {

		$this->cloudbeds_hotel_management = $cloudbeds_hotel_management;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
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
		wp_enqueue_style( $this->cloudbeds_hotel_management.'_fontawesome', plugin_dir_url( __FILE__ ) . 'fonts/fontawesome/font-awesome.min.css', array(), $this->version, 'all' );

      	wp_enqueue_style('thickbox');
      	wp_enqueue_style('jquery-style', '//ajax.googleapis.com/ajax/libs/jqueryui/1.8.2/themes/smoothness/jquery-ui.css');

		wp_enqueue_style( $this->cloudbeds_hotel_management, plugin_dir_url( __FILE__ ) . 'css/cloudbeds-hotel-management-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    0.0.1
	 */
	public function enqueue_scripts() {
		$plugin_folder = plugin_dir_url( __FILE__ );
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
		wp_enqueue_script($this->cloudbeds_hotel_management.'_form', $plugin_folder . 'js/jquery.form.min.js', array('jquery'), $this->version, true);

		wp_enqueue_script($this->cloudbeds_hotel_management.'_validate', $plugin_folder . 'js/jquery.validate.min.js', array('jquery'), $this->version, true);
		
		wp_enqueue_script($this->cloudbeds_hotel_management.'_handlebars', $plugin_folder . 'js/handlebars-v1.3.0.js', array('jquery'), '1.3.0', true);

		wp_enqueue_script($this->cloudbeds_hotel_management.'_dependencies', $plugin_folder . 'js/dependencies.js', array('jquery'), $this->version, true); 

	    // wp_enqueue_script('thickbox'); 

		wp_enqueue_script('jquery-ui-datepicker');

		wp_enqueue_script($this->cloudbeds_hotel_management.'_templates', $plugin_folder . 'js/template.js', array('jquery'), $this->version, true);

		wp_enqueue_script($this->cloudbeds_hotel_management.'_print', $plugin_folder . 'js/print.js', array('jquery'), $this->version, true);

		if ( isset($_GET['page']) && $_GET['page'] == 'mybookings-reservations'){
			wp_enqueue_script($this->cloudbeds_hotel_management.'_reservation_angular', $plugin_folder . 'js/angular.min.js', array('jquery'), '1.0.0', true);

			wp_enqueue_script($this->cloudbeds_hotel_management.'_reservation_angular_resources', $plugin_folder . 'js/angular-resource.min.js', array('jquery'), '1.0.0', true);

	      	wp_enqueue_script($this->cloudbeds_hotel_management.'_date-moment', $plugin_folder.'js/moment.min.js', array( 'jquery' ), '1.4.0', true );

	      	wp_enqueue_script($this->cloudbeds_hotel_management.'_reservation',$plugin_folder . 'js/reservation.js', array('jquery'), '1.0.0', true); 

	      	wp_localize_script($this->cloudbeds_hotel_management.'_reservation', 'reservation_object', array( 'url' => admin_url( 'admin-ajax.php' ), 'name' =>$this->cloudbeds_hotel_management) ); 
		}

		if ( isset($_GET['page']) && $_GET['page'] == 'mybookings-rooms'){
			wp_enqueue_script($this->cloudbeds_hotel_management.'_room_types',$plugin_folder . 'js/rooms.js', array('jquery'), $this->version, true); 

	      	wp_localize_script($this->cloudbeds_hotel_management.'_room_types', 'cb_hm_ajaxobj_rooms', array( 'url' => admin_url( 'admin-ajax.php') , 'name' => $this->cloudbeds_hotel_management, 'admin_url'=> admin_url('/' ) ) );  

		}

		if ( isset($_GET['page']) && $_GET['page'] == 'mybookings-rates'){
	      	// wp_enqueue_script('jquery-ui-datepicker');

	      	wp_enqueue_script($this->cloudbeds_hotel_management.'_date-moment', $plugin_folder.'js/moment.min.js', array( 'jquery' ), '1.4.0', true );

			wp_enqueue_script($this->cloudbeds_hotel_management.'_room_rates',$plugin_folder . 'js/room_rates.js', array('jquery'), $this->version, true); 

	      	wp_localize_script($this->cloudbeds_hotel_management.'_room_rates', 'cb_hm_ajaxobj_rates', array( 'url' => admin_url( 'admin-ajax.php') , 'name' => $this->cloudbeds_hotel_management, 'admin_url'=> admin_url('/' ) ) );  
		}
			wp_print_scripts('editor');
			wp_enqueue_media();
			if (function_exists('add_thickbox')) add_thickbox();
			wp_print_scripts('media-upload');
			if (function_exists('wp_tiny_mce')) wp_tiny_mce();
			wp_admin_css();
			wp_enqueue_script('utils');
			do_action("admin_print_styles-post-php");
			do_action('admin_print_styles');

		if ( isset($_GET['page']) && $_GET['page'] == 'mybookings-settings'){

			wp_enqueue_script( $this->cloudbeds_hotel_management.'_qtip', plugin_dir_url( __FILE__ ) . 'js/jquery.qtip.min.js', array( 'jquery' ), $this->version, false );
			wp_enqueue_script( $this->cloudbeds_hotel_management.'_settings', plugin_dir_url( __FILE__ ) . 'js/settings.js', array( 'jquery' ), $this->version, false );
	    	wp_localize_script($this->cloudbeds_hotel_management.'_settings', 'cb_hm_settings_obj', array('admin'=>admin_url('/' ),'url' => admin_url( 'admin-ajax.php' ), 'name' => $this->cloudbeds_hotel_management) ); 
		}

		wp_enqueue_script( $this->cloudbeds_hotel_management, plugin_dir_url( __FILE__ ) . 'js/cloudbeds-hotel-management-admin.js', array( 'jquery' ), $this->version, false );
	    wp_localize_script($this->cloudbeds_hotel_management, 'cb_hm_ajaxobj', array('admin'=>admin_url('/' ),'url' => admin_url( 'admin-ajax.php' ), 'name' => $this->cloudbeds_hotel_management, 'version'=>$this->version) ); 

	}

	public function cloudbeds_hotel_management_overview(){
		global $wpdb, $menu;
		$bookingtable = $wpdb->prefix.$this->bookingtable;

		$ompanel = 'mybookings-reservations';
		$icon = plugin_dir_url( __FILE__ ).'images/cloud_beds.png';

		$core_page =  add_menu_page( 'WP Mybookings', 'WP Mybookings', 'manage_options', 'mybookings-settings', array($this, 'cloudbeds_hotel_management_settings_panel'), $icon, 210  );

		add_submenu_page("mybookings-settings", "WP Mybookings Reservations", "Reservations", "manage_options", 'mybookings-reservations', array($this, "cloudbeds_reservations_panel") ); 
		  
		add_submenu_page("mybookings-settings", "WP Mybookings Rooms", "Rooms", "manage_options", 'mybookings-rooms', array($this, "cloudbeds_hotel_management_rooms_panel") );  

		add_submenu_page("mybookings-settings", "WP Mybookings Room Rates", "Room Rates", "manage_options", 'mybookings-rates', array($this, "cloudbeds_hotel_management_room_rates_panel") ); 

		// add_submenu_page("mybookings-reservations", "WP Mybookings Settings", "Settings", "manage_options", 'mybookings-settings', array($this, "cloudbeds_hotel_management_settings_panel") ); 

		add_submenu_page("mybookings-settings", "Documentation", "Documentation", "manage_options", 'mybookings-documentation', array($this, "cloudbeds_hotel_management_documentation_panel") ); 
		// add_submenu_page("mybookings-reservations", "Cloudbeds Payments", "Payments", "edit_post", 'mybookings-payments', array(&$this, "cloudbeds_hotel_management_payments_panel") ); 

		// Reservation Notification Bubble to show new reservations.
		$result = $wpdb->get_results("SELECT count(id) as total FROM `$bookingtable` WHERE `status`= '1'");
		if($result){
			if($result[0]->total > 0){
				foreach ( $menu as $key => $value ) {
			      if ( $menu[$key][2] == 'mybookings-settings' ) {
			        $menu[$key][0] .= ' <span class="awaiting-mod count-' . $result[0]->total . '"><span>' . $result[0]->total . '</span></span>';
			        return;
			      }
			    }
			}
		}

	}

	public function cloudbeds_reservations_panel(){

		$cursym = $this->cb_hm_options('_payment_currency', '&pound;', false);
		$subpage = isset($_GET['subpage']) ? $_GET['subpage'] : false;
		// Check Api Enabled or not 
		$api_enabled = $this->cb_hm_options('_using_cb_api','no' );

		if($api_enabled == 'no'):
			if($subpage && $subpage == 'allbookings'){
				include(plugin_dir_path( __FILE__ ).'partials/all_reservations.php');
			}else {
				include(plugin_dir_path( __FILE__ ).'partials/reservations.php');
			}
		else:			
			echo '<div class="cf"><div class="alert alert-info">';
			_e('You enabled the Cloudbeds API option in this plugin. To access this page, you must enable the "Free - Use System Management" option instead.', $this->cloudbeds_hotel_management);
			echo '</div>';
		endif;
	}

	public function get_booking_info(){
		$reference_id = isset($_GET['ref']) ? $_GET['ref'] : '';
		$html = isset($_GET['html']) ? $_GET['html'] : false;
		if($reference_id == ''){
			$json = array('success'=> false, 'status'=>'error', 'message'=> 'Invalid Request!!!');
			wp_send_json( $json );
		}
		$bookinginfo = $this->generate_booking_info($reference_id);
		// var_dump($bookinginfo);exit(0);
		if(!empty($bookinginfo)){
			if($html){
				echo $this->print_booking_info($bookinginfo);
				exit(0);
			}else {
				$json = array('success'=>true, 'status'=>'success', 'data'=> $bookinginfo);
				wp_send_json( $data );
			}
		}
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
		if(!empty($results) && isset($results[0]) && $results[0]->user_id !=0){
		      // var_dump($results);exit(0);
		      $cardtypes = array("Visa", "Mastercard", "Maestro", "American Express");
		      $cardtype  = in_array($results[0]->card_type, $cardtypes) ? $results[0]->card_type : 'N/A';
		      $user_id   = $results[0]->user_id;

		      $userdata = get_user_meta( $user_id );
		      $user = get_user_by('id', $user_id );
		      $all_meta_for_user = array_map( function( $a ){ return $a[0]; }, get_user_meta( $user_id ) );  

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
		                                      // Email template
		                                      $mailbody .='<tr><td></td><td>'. $v->roomtype_id.'</td><td>'. $v->roomquantity.'</td></tr>';

		                                  }
		                                $return['subtotal'] = $cursym .' '.$this->money_format("%i", $subtotal);
		                                $return['vat'] = $vat;
		                                $return['vattotal'] = $cursym .' '.$this->money_format("%i", (float)$subtotal * ($vat / 100) );
		                                $return['total'] = $cursym .' '. $this->money_format("%i", (float)  $subtotal + $subtotal * ($vat / 100));
		      if($showtext): 
		      		$return['thankyoutxt'] = $this->cb_hm_options('_thankyou_text', '', false);

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

		        
		}elseif(!empty($results) && isset($results[0]) && $results[0]->user_id ==0) {

			$cardtypes = array("Visa", "Mastercard", "Maestro", "American Express");
			$cardtype  = in_array($results[0]->card_type, $cardtypes) ? $results[0]->card_type : 'N/A';
			$all_meta_for_user =  unserialize($results[0]->guests);  

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
			$gtotal = 0;
			$subtotal = 0;
			$vat      = $this->cb_hm_options('_vat','15',false);
			// $packages = array();
			$return['bookinginfo'] = array();

			foreach ($results as $k => $v) {

				$subtotal += (float)$v->qtprice * 1;
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
				// Email template
				$mailbody .='<tr><td></td><td>'. $v->roomtype_id.'</td><td>'. $v->roomquantity.'</td></tr>';

			}
			$return['subtotal'] = $cursym .' '.$this->money_format("%i", $subtotal);
			$return['vat'] = $vat;
			$return['vattotal'] = $cursym .' '.$this->money_format("%i", (float)$subtotal * ($vat / 100) );
			$return['total'] = $cursym .' '. $this->money_format("%i", (float)  $subtotal + $subtotal * ($vat / 100));
			if($showtext): 
				$return['thankyoutxt'] = $this->cb_hm_options('_thankyou_text', '', false);
			endif;

			$return['name'] = ucfirst( $all_meta_for_user['res_title'] ) .' '. ucfirst( $all_meta_for_user['first_name'] ).' '.$all_meta_for_user['last_name'];

			$address = (!empty($all_meta_for_user['street'])) ? $all_meta_for_user['street'] . '<br />' : '';
			$return['address'] = stripcslashes(trim($address));
			$return['city']	= $all_meta_for_user['city'];
			$return['state']	= $all_meta_for_user['state'];
			$return['postcode']	= $all_meta_for_user['zip_f'];
			$return['country']	= $this->countries($all_meta_for_user['country']);
			$return['phoneday']	= $all_meta_for_user['phone'];
			$return['phonenight']	= 'none';
			$return['mobile']	= $all_meta_for_user['cell'];
			$return['email']	= $all_meta_for_user['email'];
			$return['guests']	= NULL;
			$return['request']	= stripcslashes(trim($results[0]->any_request));

		}
		return $return;
		exit(0);
	}

	public function print_booking_info($bookinfo) {
		$return = '';
		// var_dump($bookinfo);exit();
		if($bookinfo['showprint']):
		$return .= '<a href="javascript:void(0)" class="thankprint btnaprint btn btn-default">Print Page</a>';
		endif;
		$return .= '<div class="cb_hm"><div id="bookOrder" class="normalwhitebg">
		              <div class="row"> 
		                  <div class="mixin-col span_6"> 
		                        <h2 class="subtitle">Booking </h2>
		                        <table class="booktable"><tr><td class="strong">Reference </td><td>'.$bookinfo['ref_id'].'</td></tr></table>

		                        <h2 class="subtitle">Stay </h2> 
		                        <table class="booktable">
		                            <tr><td class="strong">Arriving</td><td>'. $bookinfo['arriving'] .'</td></tr>
		                            <tr><td class="strong">Departing</td><td>'. $bookinfo['departing'] .'</td></tr>
		                            <tr><td class="strong">Nights</td><td>'.  $bookinfo['nights']  .'</td></tr>
		                        </table>



		                        <h2 class="subtitle">Your Chosen Apartments </h2>
		                        <table class="booktable">
		                           <tr>
		                             <th class="strong">Apartment</th>
		                             <th class="strong text-right">Each</th>
		                             <th class="strong text-center">Qty</th>
		                             <th class="strong text-center">Nights</th>
		                             <th class="strong text-right">Price</th>
		                          </tr>';

		                          

		                          foreach ($bookinfo['bookinginfo'] as $k => $value) {
		                             
		                             $return .= '<tr>
		                                            <td> '. $value['appartment'] .' <br/>('.$value['ratedate'].') </td>
		                                            <td class="text-right pricetd">'. $value['each'].'</td>
		                                            <td class="text-center"> '. $value['qty'].'</td>
		                                            <td class="text-center">1</td>
		                                            <td class="text-right pricetd">'. $value['price'].'</td>
		                                        </tr>';
		                          }  
		                        $return .= '</table><h2 class="subtitle">Cost  </h2>';
		                        $return .= '
		                        <table class="booktable">
		                            <tr><td class="strong"> Sub-total </td><td class="text-right pricetd">'.$bookinfo['subtotal'] .'</td></tr>
		                            <tr><td class="strong"> VAT ('. $bookinfo['vat'] .'%)  </td><td class="text-right pricetd"> '. $bookinfo['vattotal'].' </td></tr>
		                            <tr><td class="strong"> Total Price  </td><td class="text-right pricetd">'.$bookinfo['total'].'</td></tr> 
		                        </table>';
								if(array_key_exists('thankyoutxt', $bookinfo)): 
			                        $return .= '<div class="customthanks clearfix">
						                          	'.$bookinfo['thankyoutxt'].'
								                </div>';
								endif;
		                   $return .= '</div>
		                   <div class="mixin-col span_6"> 

		                        <h2 class="subtitle">Contact Details</h2>
		                        <table class="booktable">
		                            <tr><td class="strong">Name</td><td>'.$bookinfo['name'].'</td></tr>
		                              <tr><td valign="top" class="strong">Address</td><td>';

		                   $return .= $bookinfo['address'];

		                   $return .= ''.$bookinfo['city'].', '.$bookinfo['state'].' - '.$bookinfo['postcode'].'<br />'.$bookinfo['country'].'</td></tr>
		                            <tr><td class="strong">Phone (daytime)</td><td>'.$bookinfo['phoneday'].'</td></tr>
		                            <tr><td class="strong"> Phone (evening)</td><td>'.$bookinfo['phonenight'].'</td></tr>
		                            <tr><td class="strong">Mobile</td><td>'.$bookinfo['mobile'].'</td></tr>
		                            <tr><td class="strong">Email Address</td><td><a href="mailto:'.$bookinfo['email'].'">'.$bookinfo['email'].'</a></td></tr>
		                            <tr><td class="strong">Guests</td><td>'.$bookinfo['guests'].'</td></tr>
		                            <tr><td class="strong">Special Notes</td><td>'.$bookinfo['request'].'</td></tr>
		                        </table>
		                          
		                          
		                        <p><small>Note: All prices shown are for the entire '.$bookinfo['nights'].' night stay</small>
		                  </div>
		          </div>
		     </div>
		</div>';
	  	return $return; 
	}

	public function booking_info_confirmed(){
		$ref = isset($_POST['ref_id'])   ? $_POST['ref_id']   : '';

		$roomid = isset($_POST['room_id'])   ? $_POST['room_id']   : '';

		global $wpdb;

		$booktable       = $wpdb->prefix.$this->bookingtable;

		$update_sql = "UPDATE $booktable SET `status` = '2' WHERE `booking_ref` = '$ref'";

		        //AND `roomtype_id` = '$roomid'"; // we confirmed all booking for ref_id { entire booking will be Confirmed }

		$success = $wpdb->query( $update_sql ); 

		if($success){ 

			$data = array('success'=>true, 'error'=>'', 'message'=>'Confirmed');

		}else {

			$data = array('success'=>false, 'error'=>'Update Failed');

		}

		wp_send_json( $data );
	}

	public function booking_cancelled(){
		$ref = isset($_POST['ref_id'])   ? $_POST['ref_id']   : '';
		$roomid = isset($_POST['room_id'])   ? $_POST['room_id']   : '';
		global $wpdb;
		$booktable       = $wpdb->prefix.$this->bookingtable;
		$update_sql = "UPDATE $booktable SET `status` = '3' WHERE `booking_ref` = '$ref'";
		        // AND `roomtype_id` = '$roomid'"; // we cancel all booking for ref_id { entire booking will be cancelled }
		$success = $wpdb->query( $update_sql ); 
		if($success){ 
			$data = array('success'=>true, 'error'=>'', 'message'=>'Cancelled');
		}else {
			$data = array('success'=>false, 'error'=>'Update Failed');
		}
		wp_send_json( $data );
	}

	public function booking_info_archive(){
		global $wpdb;
		$booking_ref = isset($_POST['booking_ref']) ? $_POST['booking_ref'] : '';

		if(empty($booking_ref)){
			echo 'Nothing selected';
			exit(0);
		}
		$booktable       = $wpdb->prefix.$this->bookingtable;
		$booking_ref = "'".implode("','", $booking_ref)."'";
		// var_dump($booking_ref);
		$sql = "UPDATE `".$booktable."` SET `archive`='1' WHERE `booking_ref` IN ($booking_ref)";
		// var_dump($sql);
		$success = $wpdb->query($sql);
		if($success){
			echo 'updated';
		}else {
			echo 'update failed';
		}
		exit(0);
	}

	public function cloudbeds_hotel_management_rooms_panel(){
		$tab = isset($_GET['subpage']) ? $_GET['subpage'] : 'default';
		$api_enabled = $this->cb_hm_options('_using_cb_api','no' );
		$amenities = $this->amenities;

		if($api_enabled == 'no'):
			switch ($tab) {
				case 'new-room':
					$action = $this->cloudbeds_hotel_management.'_new_room';
					$nonce = wp_create_nonce( $action );
					$name = $this->cloudbeds_hotel_management;
					include(plugin_dir_path( __FILE__ ).'partials/new-room.php');
					break;
				case 'edit-room':
					$room_id = isset($_GET['room_id']) ? $_GET['room_id'] : null;
					$room = get_post($room_id);
					$action = $this->cloudbeds_hotel_management.'_edit_room';
					$nonce = wp_create_nonce( $action );
					include(plugin_dir_path( __FILE__ ).'partials/edit-room.php');
					break;
				default:
					$cursym = $this->cb_hm_options('_payment_currency', '&pound;', false);
					$args = array('post_type'=>$this->roomtype, 'post_status'=> 'publish', 'nopaging' => true);

					$rooms = new WP_Query( $args );		
					include(plugin_dir_path( __FILE__ ).'partials/rooms.php');
					break;
			}
		else:
			echo '<div class="cf"><div class="alert alert-info">';
			_e('You enabled the Cloudbeds API option in this plugin. To access this page, you must enable the "Free - Use System Management" option instead.', $this->cloudbeds_hotel_management);
			echo '</div>';
		endif;
	}

	public function cloudbeds_hotel_management_room_rates_panel(){
		$cursym = $this->cb_hm_options('_payment_currency', '&pound;', false);
		$tab = isset($_GET['tab']) ? $_GET['tab'] : 'default';
		$api_enabled = $this->cb_hm_options('_using_cb_api','no' );

		if($api_enabled == 'no'):
			switch ($tab) {
				case 'update-room-rates':
					$this->room_rates_update_tab();
					break;
				case 'room-to-sell':
					$this->room_to_sell_tab();
					break;
				case 'open-close-rooms':
					$this->room_open_close_tab();
					break;
				default:
					$this->room_rates_overview_tab();
					break;
			}
		else:
			echo '<div class="cf"><div class="alert alert-info">';
			_e('You enabled the Cloudbeds API option in this plugin. To access this page, you must enable the "Free - Use System Management" option instead.', $this->cloudbeds_hotel_management);
			echo '</div>';
		endif;
		// $args = array('post_type'=>'cb_hm_room_type', 'post_status'=> 'publish', 'nopaging' => true);

		// $rooms = new WP_Query( $args );
		
	}

	public function get_room_rates( $datefrom = '', $dateto = '' ){
		if($datefrom == '')
			$datefrom = date( 'd-m-Y', strtotime('now') );
		if($dateto == '')
			$dateto = date('d-m-Y', strtotime(date('d-m-Y', strtotime('now'))."+10 day"));
		$from = isset($_GET['from']) ? $_GET['from'] : $datefrom;
		$until = isset($_GET['to']) ? $_GET['to'] : $dateto;
		$from = date('Y-m-d', strtotime($from));
		$until = date('Y-m-d', strtotime($until));

		// var_dump($from);
		// exit();

		global $wpdb;
		$args = array('post_type'=> $this->roomtype, 'nopaging'=>true, 'orderby' => 'post_date' , 'order' => 'ASC',   'post_status'=>'publish');
		$roomtypes = new WP_Query($args);
		$rooms = array();
		if($roomtypes->have_posts()):
			while($roomtypes->have_posts()): $roomtypes->the_post();
			$post = $roomtypes->post;
				$rooms[] = array(
					'id'=>$post->ID,
					'title'=>get_the_title($post->ID)
				);
			endwhile;
		endif;
		// Get dates to show on grid
		$dates = $this->datelist($from, $until);
		// Get Number of rooms to sell

	   	$table = $wpdb->prefix.$this->roomratedb;
	   	$sell = array();
	   	foreach ($rooms as $room) {
	   		$id = $room['id'];
		   	$sql = "SELECT * FROM $table WHERE `roomtype_id` = '$id' AND `bookdate` BETWEEN '$from'AND '$until'ORDER BY `bookdate` ASC";
		   	$getresult = $wpdb->get_results( $sql );
		   	if(empty($getresult)){
		   		foreach ($dates as $date) {
		   			$this->empty_n_insert($id, $date , 0, true);
		   		}
		   		$rsql = "SELECT * FROM $table WHERE `roomtype_id`='$id' AND `bookdate` between '$from' AND '$until'";
		   		$sell[$id] = $wpdb->get_results( $rsql );
		   		// var_dump($sell);
		   	}else{
			   	$sell[$id] = $getresult;
			}
	   	}

	   	// Prepair Month Row
	   	$years = $month = $months = Array();
        foreach($dates as $date) { 
            $y = date('Y', strtotime($date));
            $m = date('m', strtotime($date));
            $years[$y][] = $date;
            $months[$y."-".$m][] = $date;
        }

        $years = array_values($years);
        $months = array_values($months);

        foreach ($months as $key => $value) {
        	$month[] = array(
        		'colspan'	=> (sizeof($value)),
        		'title'		=> date('F Y', strtotime($value[0]))
        	);
        }

        // Prepair Days Row
        $days = array();
        foreach ($dates as $date) {
        	$value = date('d', strtotime($date));
        	$day = date('D', strtotime($date));
        	$days[] = array(
        		'title'	=> date('D', strtotime($date)),
        		'value'	=> date('d', strtotime($date))
        	);
        }

        // Prepair Rooms
        $roomrate = array();
        foreach($rooms as $room) {
        	$id = $room['id'];
            $roomdata = $sell[$id];
            $rates = array();
        	for ($i=0; $i < count($dates) ; $i++) {
        		$rates[] = array(
        			'day'		=> date('Y-m-d', strtotime($roomdata[$i]->bookdate)),
        			'date'		=> strtotime($roomdata[$i]->bookdate),
        			'price'		=> $roomdata[$i]->price,
        			'available'	=> $roomdata[$i]->allocation
        		);
            }
    		$roomrate[] = array(
    			'title'		=> get_the_title($id ),
    			'roomid'	=> $id,
    			'rates'		=> $rates
    		);

        }//end $rooms loop
        if(empty($roomrate)){
        	$json = array('success'=> false, 'status'=>error, 'message'=> "No rooms Found, Please Add Room First");
        }else {
        	$data = array(
        		'months' 	=> $month,
        		'days'		=> $days,
        		'roomrate'	=> $roomrate
        	);
       		$json = array('success'=>true, 'status'=>'success', 'data'=>$data);
       	}
       	wp_send_json( $json );
	}

	private function room_open_close_tab(){
		$cursym = $this->cb_hm_options('_payment_currency', '&pound;', false);
		$current_date = date('Y-m-d');
		$weekahead = date("Y-m-d", strtotime("+2 Week ".date("Y-m-d h:i:s") )); 
		$from = isset($_POST['from']) ? $_POST['from'] : $current_date;
		$until = isset($_POST['until']) ? $_POST['until'] : $weekahead;

		$weekdays = isset($_POST['weekdays']) ? $_POST['weekdays'] : '';
		$rooms = isset($_POST['rooms']) ? $_POST['rooms'] : '';
		$closed = isset($_POST['closed']) ? $_POST['closed'] : 0;
		$submit = isset($_POST['submit']) ? $_POST['submit'] : '';
		$now = date('Y-m-d h:i:s');

		$error = array();
		$success = '';
		if(isset($submit) && $submit == 'stay' or $submit == 'show'){
			global $wpdb;
			$table = $wpdb->prefix.$this->roomratedb;
			if(empty($weekdays)) $error[] = 'Please select weekdays';
			if(empty($rooms)) $error[] 	= 'Please select rooms';
			if(empty($error)):
				$dates = $this->datelist($from, $until);
				if(!empty($dates)){
					foreach ($rooms as $room) {
						foreach ($dates as $date) {
							$this->empty_n_insert ($room, $date, 0, true);
						}
					}
				}
				if(isset($rooms) && is_array($rooms)):
					foreach ($rooms as $room) {
						$dates = array();
						foreach ($weekdays as $day) {
							$days = $this->getdates($from, $until, $day);
							array_push($dates, implode(',',$days));
						}
						$dates = implode(',',$dates);
						foreach (explode(',',$dates) as $date) {
							$update_sql = "UPDATE `$table` SET `available` = '".$closed."',  update_time = '$now' WHERE `roomtype_id` = '$room' and `bookdate` = '$date'";
							$success = $wpdb->query( $update_sql );
							if(!$success){
								$this->empty_n_insert($room, $date , 0, true, 1, $closed, 1);
							}
						}
					}
					$success = 'Options updated';

					if($submit == 'show'):
						if ( headers_sent() ) {
					        echo '<meta http-equiv="refresh" content="0;url=' . admin_url('admin.php?page=mybookings-rates') . '">';
					        echo '<script type="text/javascript">document.location.href="' . admin_url('admin.php?page=mybookings-rates') . '"</script>';
					    } else {
					        wp_redirect(admin_url('admin.php?page=mybookings-rates'));
					        exit();
					    }
					endif;
					// getdates
				else:
					$error[] = 'No rooms Selected';
				endif;
			endif;
		}
		// Get the rooms
		$args = array('post_type'=> $this->roomtype, 'nopaging'=>true, 'orderby' => 'post_date' , 'order' => 'ASC',   'post_status'=>'publish');
		$roomtypes = new WP_Query($args);
		$rooms = array();
		if($roomtypes->have_posts()):
			while($roomtypes->have_posts()): $roomtypes->the_post();
			$post = $roomtypes->post;
				$rooms[] = array(
					'id'=>$post->ID,
					'title'=>get_the_title($post->ID)
				);
			endwhile;
		endif;
		include(plugin_dir_path( __FILE__ ).'partials/room_open_close.php');
	}

	private function room_to_sell_tab(){
		$cursym = $this->cb_hm_options('_payment_currency', '&pound;', false);
		$current_date = date('Y-m-d');
		$weekahead = date("Y-m-d", strtotime("+2 Week ".date("Y-m-d h:i:s") )); 
		$from = isset($_POST['from']) ? $_POST['from'] : $current_date;
		$until = isset($_POST['until']) ? $_POST['until'] : $weekahead;
		// Get the rooms
		$args = array('post_type'=> $this->roomtype, 'nopaging'=>true, 'orderby' => 'post_date' , 'order' => 'ASC',   'post_status'=>'publish');
		$roomtypes = new WP_Query($args);
		$rooms = array();
		if($roomtypes->have_posts()):
			while($roomtypes->have_posts()): $roomtypes->the_post();
			$post = $roomtypes->post;
				$rooms[] = array(
					'id'=>$post->ID,
					'title'=>get_the_title($post->ID)
				);
			endwhile;
		endif;
		// Get dates to show on grid
		$dates = $this->datelist($from, $until);
		// Get Number of rooms to sell

	   	global $wpdb; 
	   	$table   = $wpdb->prefix.$this->roomratedb;
	   	$sell =array();
	   	foreach ($rooms as $room) {
	   		$id = $room['id'];
		   	$sql = "SELECT * FROM $table WHERE `roomtype_id` = '$id' AND `bookdate` BETWEEN '$from'AND '$until'ORDER BY `bookdate` ASC";
		   	$getresult = $wpdb->get_results( $sql );
		   	if(empty($getresult)){
		   		foreach ($dates as $date) {
		   			$this->empty_n_insert($id, $date , 0, true);
		   		}
		   		$rsql = "SELECT * FROM $table WHERE `roomtype_id`='$id' AND `bookdate` between '$from' AND '$until'";
		   		$sell[$id] = $wpdb->get_results( $rsql );
		   	}else{
			   	$sell[$id] = $getresult;
			}
	   	}
	   	include(plugin_dir_path( __FILE__ ).'partials/room_to_sell.php');
	}

	private function room_rates_update_tab(){
		$cursym = $this->cb_hm_options('_payment_currency', '&pound;', false);
		$current_date = date('Y-m-d');
		$weekahead = date("Y-m-d", strtotime("+2 Week ".date("Y-m-d h:i:s") )); 
		$from = isset($_POST['from']) ? $_POST['from'] : $current_date;
		$until = isset($_POST['until']) ? $_POST['until'] : $weekahead;
		// Get the rooms
		$args = array('post_type'=> $this->roomtype, 'nopaging'=>true, 'orderby' => 'post_date' , 'order' => 'ASC',   'post_status'=>'publish');
		$roomtypes = new WP_Query($args);
		$rooms = array();
		if($roomtypes->have_posts()):
			while($roomtypes->have_posts()): $roomtypes->the_post();
			$post = $roomtypes->post;
				$rooms[] = array(
					'id'=>$post->ID,
					'title'=>get_the_title($post->ID)
				);
			endwhile;
		endif;
		// Get dates to show on grid
		$dates = $this->datelist($from, $until);
		// Get Number of rooms to sell

	   global $wpdb; 
	   $table       = $wpdb->prefix.$this->roomratedb;
	   $sell =array();
		foreach ($rooms as $room) {
			$id = $room['id'];
		   	$sql = "SELECT * FROM $table WHERE `roomtype_id` = '$id' AND `bookdate` BETWEEN '$from'AND '$until'ORDER BY `bookdate` ASC";
		   	$getresult = $wpdb->get_results( $sql );
		   	if(empty($getresult)){
		   		foreach ($dates as $date) {
		   			$this->empty_n_insert($id, $date , 0, true);
		   		}
		   		$rsql = "SELECT * FROM $table WHERE `roomtype_id`='$id' AND `bookdate` between '$from' AND '$until'";
		   		$sell[$id] = $wpdb->get_results( $rsql );
		   	}else{
			   	$sell[$id] = $getresult;
			}
		}
	   	include(plugin_dir_path( __FILE__ ).'partials/room_rate_update.php');
	}

	private function room_rates_overview_tab(){
		$cursym = $this->cb_hm_options('_payment_currency', '&pound;', false);
		$current_date = date('Y-m-d');
		$weekahead = date("Y-m-d", strtotime("+4 Week ".date("Y-m-d h:i:s") )); 
		$from = isset($_POST['from']) ? $_POST['from'] : $current_date;
		$until = isset($_POST['until']) ? $_POST['until'] : $weekahead;
		// Get the rooms
		$args = array('post_type'=> $this->roomtype, 'nopaging'=>true, 'orderby' => 'post_date' , 'order' => 'ASC',   'post_status'=>'publish');
		$roomtypes = new WP_Query($args);
		$rooms = array();
		if($roomtypes->have_posts()):
			while($roomtypes->have_posts()): $roomtypes->the_post();
			$post = $roomtypes->post;
				$rooms[] = array(
					'id'=>$post->ID,
					'title'=>get_the_title($post->ID)
				);
			endwhile;
		endif;
		// Get dates to show on grid
		$dates = $this->datelist($from, $until);
		// Get Number of rooms to sell

	   	global $wpdb; 
	   	$table       = $wpdb->prefix.$this->roomratedb;
	   	$sell =array();
	   	foreach ($rooms as $room) {
	   		$id = $room['id'];
		   	$sql = "SELECT * FROM $table WHERE `roomtype_id` = '$id' AND `bookdate` BETWEEN '$from'AND '$until'ORDER BY `bookdate` ASC";
		   	$getresult = $wpdb->get_results( $sql );
		   	if(empty($getresult)){
		   		foreach ($dates as $date) {
		   			$this->empty_n_insert($id, $date , 0, true);
		   		}
		   		$rsql = "SELECT * FROM $table WHERE `roomtype_id`='$id' AND `bookdate` between '$from' AND '$until'";
		   		$sell[$id] = $wpdb->get_results( $rsql );
		   		// var_dump($sell);
		   	}else{
			   	$sell[$id] = $getresult;
			}
	   	}
		include(plugin_dir_path( __FILE__ ).'partials/room_rates.php');
	}

	public function save_rate_changes(){
		global $wpdb;
		$from = isset($_POST['from']) ? $_POST['from'] : false;
		$until = isset($_POST['to']) ? $_POST['to'] : false;
		$rooms = isset($_POST['rooms']) ? $_POST['rooms'] : false;
		$rates = isset($_POST['rates']) ? $_POST['rates'] : false;

		$table = $wpdb->prefix.$this->roomratedb;
		$now = date('Y-m-d h:i:s');

		if(!$from || !$until  ) {
			$json = array('success'=>false, 'status'=>'warning', 'message'=>'Nothing changes');
			wp_send_json( $json );
		}
		if($rooms):
			foreach ($rooms as $roomid => $dates) {
				
				$defaultprice = get_post_meta($roomid, $this->cloudbeds_hotel_management.'_price', true );
				$defaultavailable = get_post_meta($roomid, $this->cloudbeds_hotel_management.'_no_rooms', true );
				$defaultmin_stay = $this->cb_hm_options('_min_stay', '' );

				foreach ($dates as $date => $allocation) {
					$update_sql = $update_sql = "UPDATE `".$table."` SET `allocation`='$allocation' WHERE `roomtype_id` = '$roomid' and `bookdate`= '$date'";
					$success = $wpdb->query( $update_sql );
					$status[] = $success;
					if(!$success){
						$this->empty_n_insert($roomid, $date , $defaultprice , false, $defaultavailable, $allocation, $defaultmin_stay);
					}
				}

			}
		endif;

		if($rates):
			foreach ($rates as $roomid => $dates) {

				$defaultprice = get_post_meta($roomid, $this->cloudbeds_hotel_management.'_price', true );
				$defaultavailable = get_post_meta($roomid, $this->cloudbeds_hotel_management.'_no_rooms', true );
				$defaultmin_stay = $this->cb_hm_options('_min_stay', '' );

				foreach ($dates as $date => $price) {
					$update_sql = $update_sql = "UPDATE `".$table."` SET `price`='$price' WHERE `roomtype_id` = '$roomid' and `bookdate`= '$date'";
					$success = $wpdb->query( $update_sql );
					$status[] = $success;
					if(!$success){
						$this->empty_n_insert($roomid, $date , $price , false, '1', $defaultavailable, $defaultmin_stay);
					}
				}
			}
		endif;
		if($rates || $rooms){
			$json = array('success'=> true, 'status'=>'success', 'message'=>'data updated');
			wp_send_json( $json );
		}else {
			$json = array('success'=>false, 'status'=>'warning', 'message'=>'Nothing changes');
			wp_send_json( $json );
		}
	}

	public function save_bulk_changes(){
		global $wpdb;
		$from = isset($_POST['from']) ? $_POST['from'] : false;
		$until = isset($_POST['to']) ? $_POST['to'] : false;
		$roomid = isset($_POST['roomid']) ? $_POST['roomid'] : false;
		$weekdays = isset($_POST['weekday']) ? $_POST['weekday'] : false;
		// $type = isset($_POST['type']) ? $_POST['type'] : false;
		$availability = isset($_POST['availability']) ? $_POST['availability'] : false;
		$rate = isset($_POST['rate']) ? $_POST['rate'] : false;
		$min_stay = isset($_POST['min_stay']) ? $_POST['min_stay'] : false;
		$close = isset($_POST['close']) ? $_POST['close'] : false;
		$setfor = isset($_POST['setfor']) ? $_POST['setfor'] : false;
		// var_dump($_POST);exit(0);
		if(!$from || !$until || !$roomid) {
			$json = array('success'=>false, 'status'=>'warning', 'message'=>'Nothing changes');
			wp_send_json( $json );
		}

		$defaultprice = get_post_meta($roomid, $this->cloudbeds_hotel_management.'_price', true );
		$defaultavailable = get_post_meta($roomid, $this->cloudbeds_hotel_management.'_no_rooms', true );
		$defaultmin_stay = $this->cb_hm_options('_min_stay', '' );

		// Get Dates from weekdays
		$dates = array();
		foreach ($weekdays as $day) {
			$days = $this->getdates($from, $until, $day);
			array_push($dates, implode(',',$days));
		}
		$dates = implode(',', $dates);
		$table = $wpdb->prefix.$this->roomratedb;
		$now = date('Y-m-d h:i:s');
		// set defaults 
		$price = $defaultprice;
		$available = $defaultavailable;
		$allocation = $defaultavailable;
		$minimum_stay = $defaultmin_stay;
		$status = array();
		// var_export($dates);exit(0);
		foreach (explode(',', $dates) as $date) {
			$set = array();
			if($availability && $availability !='' && $setfor == 'availability'){
				$allocation = $allocation;
				$set[] = "`allocation` = '".$availability."'";
			}
			if($rate && $rate !='' && $setfor == 'rate'){
				$price = $rate;
				$set[] = "`price` = '".$rate."'";
			}
			if($min_stay && $min_stay !='' && $setfor == 'min_stay'){
				$minimum_stay = $min_stay;
				$set[] = "`minimum_stay` = '".$min_stay."'";
			}
			if($close && $close =='1' && $setfor == 'close'){
				$available = '0';
				$set[] = "`available` = '0'";
			}
			$where = "WHERE `roomtype_id` = '$roomid' and `bookdate`= '$date'";
			$update_sql = $update_sql = "UPDATE `".$table."` SET ".implode(', ', $set)." ".$where;

			// switch ($type) {
			// 	case 'availability':
			// 		$update_sql = "UPDATE `".$table."` SET `allocation` = '".$units."',  update_time = '$now' WHERE `roomtype_id` = '$roomid' and `bookdate`= '$date'";
			// 		$allocation = $units;
			// 		break;
			// 	case 'rate':
			// 		$update_sql = "UPDATE `".$table."` SET `price` = '".$units."',  update_time = '$now' WHERE `roomtype_id` = '$roomid' and `bookdate`= '$date'";
			// 		$price = $units;
			// 		break;
			// 	case 'minstay':
			// 		$update_sql = "UPDATE `".$table."` SET `minimum_stay` = '".$units."',  update_time = '$now' WHERE `roomtype_id` = '$roomid' and `bookdate`= '$date'";
			// 		$allocation = $units;
			// 		break;
			// 	default:
			// 		if($close && $close == 1){
			// 			$update_sql = "UPDATE `".$table."` SET `allocation` = '0',  update_time = '$now' WHERE `roomtype_id` = '$roomid' and `bookdate`= '$date'";
			// 			$allocation = 0;
			// 		}
			// 		break;
			// }
			if($update_sql != ''):
				$success = $wpdb->query( $update_sql );
				$status[] = $success;
				if(!$success){
					$this->empty_n_insert($roomid, $date , $price , false, $available, $allocation, $minimum_stay);
				}
			endif;
		}		

		// Now return rates within seleted dates, have to show 10 result from selected date
		$datefrom = new DateTime($from);
		$dateto = new DateTime($until);
		$interval = $datefrom->diff($dateto);
		if($interval->days > 9){
			$dateto = $datefrom;
			$dateto->add(new DateInterval('P9D'));
		}
		$data = array(
			'from'	=> $from,
			'to'	=> $dateto->format('d-m-Y')
		);
		$json = array('success'=>true, 'status'=> 'success', 'data'=>$data);
		wp_send_json( $json );
	}

	public function room_rate_update_grid(){
		global $wpdb;
		$inventory_data = $_POST['inventory_data'];
		$now = date('Y-m-d h:i:s');
		$error = array();
		foreach ($inventory_data['hotel_room_date'] as $room => $value) {
			foreach ($value as $date => $available) {
				// var_export($available['rooms_to_sell']);
				$table = $wpdb->prefix.$this->roomratedb;
				$update_sql = "UPDATE `".$table."` SET `allocation` = '".$available['rooms_to_sell']."',  update_time = '$now' WHERE `roomtype_id` = '$room' and bookdate = '$date'";
				$success = $wpdb->query( $update_sql );
				if(!$success){
					$this->empty_n_insert($room, $date , 0, true, 1, $available['rooms_to_sell'], 1);
				}
			}
		}
		if(!empty($error)){
			$json = array('success'=>false, 'error'=> $error);
		}else {
			$updated_fields = array(
				'hotel_room_date'=>$inventory_data['hotel_room_date']
			);
			$json = array('success'=>true, 'status'=>'success','message'=>'rooms updated successfully', 'updated_fields'=>$updated_fields);
		}
		wp_send_json( $json );
		exit();
	}

	public function room_rate_update_rate_grid(){
		global $wpdb;
		$inventory_data = $_POST['inventory_data'];
		$now = date('Y-m-d h:i:s');
		$error = array();
		foreach ($inventory_data['hotel_room_date'] as $room => $value) {
			foreach ($value as $date => $available) {
				// var_export($available['rooms_to_sell']);
				$table = $wpdb->prefix.$this->roomratedb;
				$update_sql = "UPDATE `".$table."` SET `price` = '".$available['rooms_to_sell']."',  update_time = '$now' WHERE `roomtype_id` = '$room' and bookdate = '$date'";
				$success = $wpdb->query( $update_sql );
				if(!$success){
					empty_n_insert($room, $date , $available['rooms_to_sell'], true, 1, 2, 1);
				}
			}
		}
		if(!empty($error)){
			$json = array('success'=>false, 'error'=> $error);
		}else {
			$updated_fields = array(
				'hotel_room_date'=>$inventory_data['hotel_room_date']
			);
			$json = array('success'=>true,'message'=>'Rate updated successfully', 'updated_fields'=>$updated_fields);
		}
		wp_send_json( $json );
		exit();
	}

	public function room_rate_coomonupdate(){
		$error 			= array();
		$weekdays 		= isset($_POST['weekdays']) ? $_POST['weekdays'] : '';
		$rooms 			= isset($_POST['rooms']) ? $_POST['rooms'] : '';
		$fromdate 		= isset($_POST['from']) ? $_POST['from'] : '';
		$todate 		= isset($_POST['until']) ? $_POST['until'] : '';
		$price 			= isset($_POST['room_rate']) ? $_POST['room_rate'] : '';
		// $inventory_data = prepair_inventory($_POST);

		if(empty($weekdays))$error[] 		= 'Please select weekdays';
		if(empty($rooms))$error[] 			= 'Please select Room';
		if($price =='')$error[] 			= 'Please Enter rate of the rooms';

		if(!empty($error)){
			$json = array ('success'=> false, 'error'=>$error);
			wp_send_json( $json );
			exit();
		}else {
			$dates = $this->datelist($fromdate, $todate);
			if(isset($rooms) && is_array($rooms)):
				global $wpdb;
				$table = $wpdb->prefix.$this->roomratedb;
				$now = date('Y-m-d h:i:s');
				$inventory = array();
				foreach ($rooms as $room) {
					$dates = array();
					foreach ($weekdays as $day) {
						$days = $this->getdates($fromdate, $todate, $day);
						array_push($dates, implode(',',$days));
					}
					$dates = implode(',',$dates);
					foreach (explode(',',$dates) as $date) {
						$update_sql = "UPDATE `".$table."` SET `price` = '".$price."',  update_time = '$now' WHERE `roomtype_id` = '$room' and `bookdate`= '$date'";
						$success = $wpdb->query( $update_sql );
						if(!$success){
							$this->empty_n_insert($room, $date , $price , false);
						}
					}
				}
				// getdates
			endif;
			if(!empty($error)){
				$json = array ('success'=> false, 'error'=>$error);
				wp_send_json( $json );
				exit();
			}else {
				// $updated_fields = array(
				// 	'hotel_room_date'=>$inventory
				// );
				$json = array ('success'=> true, 'message'=>'updated successfully');
				wp_send_json( $json );
				exit();
			}
		}
	}

	public function room_rate_updatecommonsell(){
		$error 			= array();
		$weekdays 		= isset($_POST['weekdays']) ? $_POST['weekdays'] : '';
		$rooms 			= isset($_POST['rooms']) ? $_POST['rooms'] : '';
		$fromdate 		= isset($_POST['from']) ? $_POST['from'] : '';
		$todate 		= isset($_POST['until']) ? $_POST['until'] : '';
		$room_to_sell 	= isset($_POST['rooms_to_sell']) ? $_POST['rooms_to_sell'] : '';
		// $inventory_data = prepair_inventory($_POST);

		if(empty($weekdays))$error[] 		= 'Please select weekdays';
		if(empty($rooms))$error[] 			= 'Please select Room';
		if($room_to_sell =='')$error[] 	= 'Please Enter number of rooms to sell';

		if(!empty($error)){
			$json = array ('success'=> false, 'error'=>$error);
			wp_send_json( $json );
			exit();
		}else {
			global $wpdb;
			$table = $wpdb->prefix.$this->roomratedb;
			$dates = $this->datelist($fromdate, $todate);
			if(isset($rooms) && is_array($rooms)):
				$now = date('Y-m-d h:i:s');
				$inventory = array();
				foreach ($rooms as $room) {
					$dates = array();
					foreach ($weekdays as $day) {
						$days = $this->getdates($fromdate, $todate, $day);
						array_push($dates, implode(',',$days));
					}
					$dates = implode(',',$dates);
					foreach (explode(',',$dates) as $date) {
						$update_sql = "UPDATE `".$table."` SET `allocation` = '".$room_to_sell."',  update_time = '$now' WHERE `roomtype_id` = '$room' and bookdate = '$date'";
						$success = $wpdb->query( $update_sql );
						if(!$success){
							$this->empty_n_insert($room, $date , 0 , true);
						}
					}
				}
				// getdates
			endif;
			if(!empty($error)){
				$json = array ('success'=> false, 'status'=>'error', 'error'=>$error);
				wp_send_json( $json );
				exit();
			}else {
				// $updated_fields = array(
				// 	'hotel_room_date'=>$inventory
				// );
				$json = array ('success'=> true, 'status'=>'success', 'message'=>'updated successfully');
				wp_send_json( $json );
				exit();
			}
		}
	}

	public function cloudbeds_hotel_management_settings_panel(){
		$amenities = $this->amenities;
		$timezonelist = $this->generate_timezone_list();
		$action = $this->cloudbeds_hotel_management.'_general_settings';
		$nonce = wp_create_nonce( $action );
		$propertyType = array('Aparthotel', 'Apartment', 'Bed and breakfast', 'Boat', 'Campsite', 'Chalet', 'Country house', 'Farm stay', 'Guest house', 'Holiday home', 'Holiday park', 'Hostel', 'Hotel', 'Inns', 'Lodge', 'Motel', 'Resort', 'Riad', 'Ryokan', 'Luxury tent', 'Villa', 'Other');

		$kids = array('1 Year Old', '2 Year Old', '3 Year Old', '4 Year Old', '5 Year Old', '6 Year Old', '7 Year Old', '8 Year Old', '9 Year Old', '10 Years Old' );

		$weekends = array('Saturday, Sunday', 'Sunday', 'Saturday', 'Friday', 'Sunday, Monday', 'Friday, Saturday, Sunday');
		
		$propertyname = $this->cb_hm_options('_propertyname', '' );
		$propertywebsite = $this->cb_hm_options('_propertywebsite', '' );
		$propertydescription = $this->cb_hm_options('_propertydescription', '' );
		$email = $this->cb_hm_options('_email', '' );
		$facebook = $this->cb_hm_options('_facebook', '' );
		$phone = $this->cb_hm_options('_phone', '' );
		$type = $this->cb_hm_options('_type', '' );
		$city = $this->cb_hm_options('_city', '' );
		$address1 = $this->cb_hm_options('_address1', '' );
		$address2 = $this->cb_hm_options('_address2', '' );
		$state = $this->cb_hm_options('_state', '' );
		$zip = $this->cb_hm_options('_zip', '' );
		$checkin = $this->cb_hm_options('_checkin', '' );
		$checkout = $this->cb_hm_options('_checkout', '' );
		$min_stay = $this->cb_hm_options('_min_stay', '' );
		$max_stay = $this->cb_hm_options('_max_stay', '' );
		$kids_under = $this->cb_hm_options('_kids_under', '' );
		$timezone = $this->cb_hm_options('_timezone', '' );
		$weekend = $this->cb_hm_options('_weekend', '' );
		$vatincluded      = $this->cb_hm_options('_vatincluded','15',false);
		$vat      = $this->cb_hm_options('_vat','15',false);
		$hotel_images = $this->cb_hm_options('_images', array() );
		$sender_name = $this->cb_hm_options('_sender_name', '' );
		$sender_email = $this->cb_hm_options('_sender_email', '' );
		// $guest_name = $this->cb_hm_options('_guest_name','' );
		// $guest_email = $this->cb_hm_options('_guest_email','' );
		$email_subject = $this->cb_hm_options('_email_subject','' );
		$email_message = $this->cb_hm_options('_email_message','' );


		//Settings while api enabled

		$api_enabled = $this->cb_hm_options('_using_cb_api','no' );
		// $cloudbeds_api_key = $this->cb_hm_options('_cloudbeds_api_key','' );
		// $cloudbeds_api_key = $this->cb_hm_options('_cloudbeds_api_key','' );
		$cloudbeds_app_email = '';
		$cloudbeds_app_password = '';
		$client_id = '';
		$client_secret = '';
		$redirect_url = admin_url('admin.php?page=mybookings-settings');
		$cloudbeds_app_info = $this->cb_hm_options('_cloudbeds_app_info','' );
		if(is_array($cloudbeds_app_info)){ 
			$client_id = isset($cloudbeds_app_info['client_id']) ? $cloudbeds_app_info['client_id'] : '';
			$client_secret = isset($cloudbeds_app_info['client_secret']) ? $cloudbeds_app_info['client_secret'] : '';
		}
		// Save code if have any
		$code = isset($_REQUEST['code']) ? $_REQUEST['code'] : '';
		if($code !=''){
            
             $client = new OAuth2\Client($client_id, $client_secret); 
		     $token_uri = $this->api_token_url;
		 

		    
		    $apiparams = array(
		        'code' => $code,
		        'client_id' => $client_id,
		        'client_secret' => $client_secret,
		        'redirect_uri' => $redirect_url,
		        'grant_type' => 'authorization_code'
		    );
		    $apiresponses = $client->getAccessToken($token_uri, 'authorization_code', $apiparams);

            
            $apiresponse = $apiresponses['result']; 
		    if($apiresponse['error'] !=''){
		    	
		    	$display_message =  $apiresponse['message'];
		    	 
		     }else {

			    $access_info = array(
			    	'access_token'	=> $apiresponse['access_token'],
			    	'token_timeout'	=> $apiresponse['expires_in'],
			    	'refresh_token'	=> $apiresponse['refresh_token'],
			    	'token_created'	=> current_time('timestamp' ),
			    );


			    if(get_option($this->cloudbeds_hotel_management.'_cloudbeds_api_access_info', FALSE)) { 
		            update_option($this->cloudbeds_hotel_management.'_cloudbeds_api_access_info', $access_info);
		        } else { 
		            add_option( $this->cloudbeds_hotel_management.'_cloudbeds_api_access_info', $access_info );
		        }
		         

		        $display_message =  'Application Authorization Code Saved!!!';
			}

 

	        $this->show_admin_notification($display_message);
		}

		$amenity = $this->cb_hm_options('_amenity','' );
		$maplink = $this->cb_hm_options('_maplink','' );
		$lat = $this->cb_hm_options('_lat','' );
		$lng = $this->cb_hm_options('_lng','' );

		// Currency
		$currency_code = $this->cb_hm_options('_currency_code','' );
		$cursym = $this->cb_hm_options('_payment_currency', '&pound;');
		$currency_name = $this->cb_hm_options('_currency_name', '');
		$currency_position = $this->cb_hm_options('_currency_position', 'before');
		$deposit_type = $this->cb_hm_options('_deposit_type', 'percent');
		$deposit_percent = $this->cb_hm_options('_deposit_percent', '');
		$deposit_fixed = $this->cb_hm_options('_deposit_fixed', '');


		$custom_cancelllation_policy = $this->cb_hm_options('_custom_cancelllation_policy', '');
		$cancellation_policy_allowed = $this->cb_hm_options('_cancellation_policy_allowed', 'no');
		$terms_full_charge_allowed = $this->cb_hm_options('_terms_full_charge_allowed', 'no');
		$terms_full_charge_cancellation_days = $this->cb_hm_options('_terms_full_charge_cancellation_days', '1');
		$terms_partial_charge_allowed = $this->cb_hm_options('_terms_partial_charge_allowed', 'no');
		$terms_partial_charge_type = $this->cb_hm_options('_terms_partial_charge_type', 'percent');
		$terms_partial_charge_cancellation_days = $this->cb_hm_options('_terms_partial_charge_cancellation_days', '2');
		$terms_partial_amount = $this->cb_hm_options('_terms_partial_amount', '20');


		$late_checkout_allowed = $this->cb_hm_options('_late_checkout_allowed','no' );
		$late_checkout_hour = $this->cb_hm_options('_late_checkout_hour','' );
		$late_checkout_type = $this->cb_hm_options('_late_checkout_type','percent' );
		$late_checkout_val = $this->cb_hm_options('_late_checkout_val','' );

		// $late_checkout_val = $this->cb_hm_options('_late_checkout_val','' );


		$selectedcountry = $this->cb_hm_options('_country','' );
		$countries = '';
		$listcountries = $this->countries();

		// var_export($listcountries);

		foreach ($listcountries as $key => $value) {
			$countries .='<option value="'.$key.'"';
			if($selectedcountry == $key)
				$countries .= ' selected="selected"';
			$countries .= '>'.$value.'</option>';
		}

		// $latecheckout = $this->cb_hm_options('_latecheckout','' );
		// $latecheckoutfee = $this->cb_hm_options('_latecheckoutfee','' );


		$images = array();
		if(!empty($hotel_images)){
			$image = wp_get_attachment_image_src($hotel_images[0], array(200,200) );
			$coverImage = array(
				'id'	=> $hotel_images[0],
				'image'	=> $image[0]
			);
			$images = $hotel_images;
		}else {
			$coverImage = false;
			$images = array();
		}


		$reservation_policy = $this->cb_hm_options('_reservation_policy', '' );
		$thankyou_text = $this->cb_hm_options('_thankyou_text', '' );
		include(plugin_dir_path( __FILE__ ).'partials/settings.php');
	}

	public function cloudbeds_hotel_management__general_settings_save(){
		$nonce = isset($_POST['wp_nonce']) ? $_POST['wp_nonce'] : null;
		$action = $this->cloudbeds_hotel_management.'_general_settings';
		if(!$nonce || !wp_verify_nonce( $nonce, $action ) ){
			$json = array('success'=>false, 'status'=>'error', 'message'=>'Invalid Request');
			wp_send_json($json );
		}
		$cb_hm_option['using_cb_api'] 	= isset($_POST['using_cb_api']) ? $_POST['using_cb_api'] : 'no';
		// $cb_hm_option['cloudbeds_api_key'] 	= isset($_POST['cloudbeds_api_key']) ? $_POST['cloudbeds_api_key'] : '';
		//upgrading to using server version 1.1
		 
		$client_id = isset($_POST['client_id']) ? $_POST['client_id'] : '';
		$client_secret = isset($_POST['client_secret']) ? $_POST['client_secret'] : '';

		$cb_hm_option['cloudbeds_app_info'] = array( 
			'client_id' => $client_id,
			'client_secret' => $client_secret
		);

		//check if old info and new info same or not
		$doappauthorization = false;
		$cloudbeds_app_info = $this->cb_hm_options('_cloudbeds_app_info','' );
		if($cb_hm_option['using_cb_api'] == 'yes'){
			// if(is_array($cloudbeds_app_info)){
			// 	$old_client_id = isset($cloudbeds_app_info['client_id']) ? $cloudbeds_app_info['client_id'] : '';
			// 	$old_client_secret = isset($cloudbeds_app_info['client_secret']) ? $cloudbeds_app_info['client_secret'] : '';
			// 	if($client_id !='' && $client_id != $old_client_id){
			// 		$doappauthorization = true;
			// 	}elseif( $client_secret !='' && $client_secret != $old_client_secret ){
			// 		$doappauthorization = true;
			// 	}else{
			// 		$doappauthorization = false;
			// 	}
			// }else{
			// 	$doappauthorization = true;
			// }
			$doappauthorization = true;
		}

		$cb_hm_option['propertyname'] 	= isset($_POST['propertyname']) ? $_POST['propertyname'] : '';
		$cb_hm_option['propertywebsite'] 	= isset($_POST['propertywebsite']) ? $_POST['propertywebsite'] : '';
		$cb_hm_option['propertydescription'] 	= isset($_POST['propertydescription']) ? $_POST['propertydescription'] : '';
		$cb_hm_option['email'] 			= isset($_POST['email']) ? $_POST['email'] : '';
		$cb_hm_option['facebook'] 			= isset($_POST['facebook']) ? $_POST['facebook'] : '';
		$cb_hm_option['phone'] 			= isset($_POST['phone']) ? $_POST['phone'] : '';
		$cb_hm_option['type']			= isset($_POST['property-type']) ? $_POST['property-type'] : '';
		$cb_hm_option['images']			= isset($_POST['room_images']) ? $_POST['room_images'] : array();
		$cb_hm_option['city'] 			= isset($_POST['city']) ? $_POST['city'] : '';
		$cb_hm_option['state'] 			= isset($_POST['state']) ? $_POST['state'] : '';
		$cb_hm_option['address1']			= isset($_POST['address1']) ? $_POST['address1'] : '';
		$cb_hm_option['address2']			= isset($_POST['address2']) ? $_POST['address2'] : '';
		$cb_hm_option['zip'] 			= isset($_POST['zip']) ? $_POST['zip'] : '';
		$cb_hm_option['checkin'] 		= isset($_POST['checkin']) ? $_POST['checkin'] : '';
		$cb_hm_option['checkout'] 		= isset($_POST['checkout']) ? $_POST['checkout'] : '';
		$cb_hm_option['min_stay'] 		= isset($_POST['min_stay']) ? $_POST['min_stay'] : '';
		$cb_hm_option['max_stay'] 		= isset($_POST['max_stay']) ? $_POST['max_stay'] : '';
		$cb_hm_option['kids_under'] 	= isset($_POST['kids_under']) ? $_POST['kids_under'] : '';
		$cb_hm_option['payment_currency'] 	= isset($_POST['payment_currency']) ? $_POST['payment_currency'] : '';
		$cb_hm_option['vatincluded'] 	= isset($_POST['vatincluded']) ? $_POST['vatincluded'] : '';
		$cb_hm_option['vat'] 	= isset($_POST['vat']) ? $_POST['vat'] : '';
		$cb_hm_option['timezone'] 		= isset($_POST['timezone']) ? $_POST['timezone'] : '';
		$cb_hm_option['weekend'] 		= isset($_POST['weekend']) ? $_POST['weekend'] : '';
		$cb_hm_option['reservation_policy'] = isset($_POST['reservation_policy']) ? $_POST['reservation_policy'] : '';
		$cb_hm_option['thankyou_text'] = isset($_POST['thankyou_text']) ? $_POST['thankyou_text'] : '';
		$cb_hm_option['sender_name'] = isset($_POST['sender_name']) ? $_POST['sender_name'] : '';
		$cb_hm_option['sender_email'] = isset($_POST['sender_email']) ? $_POST['sender_email'] : '';
		// $cb_hm_option['guest_name'] = isset($_POST['guest_name']) ? $_POST['guest_name'] : '';
		// $cb_hm_option['guest_email'] = isset($_POST['guest_email']) ? $_POST['guest_email'] : '';
		$cb_hm_option['email_subject'] = isset($_POST['email_subject']) ? $_POST['email_subject'] : '';
		$cb_hm_option['email_message'] = isset($_POST['email_message']) ? $_POST['email_message'] : '';


		$cb_hm_option['country'] = isset($_POST['country']) ? $_POST['country'] : '';


		$cb_hm_option['amenity'] = isset($_POST['amenity']) ? $_POST['amenity'] : array();
		$cb_hm_option['maplink'] = isset($_POST['maplink']) ? $_POST['maplink'] : '';
		$cb_hm_option['lat'] = isset($_POST['lat']) ? $_POST['lat'] : '';
		$cb_hm_option['lng'] = isset($_POST['lng']) ? $_POST['lng'] : '';
		$cb_hm_option['currency_code'] = isset($_POST['currency_code']) ? $_POST['currency_code'] : '';
		$cb_hm_option['payment_currency'] = isset($_POST['payment_currency']) ? $_POST['payment_currency'] : '';
		$cb_hm_option['currency_name'] = isset($_POST['currency_name']) ? $_POST['currency_name'] : '';
		$cb_hm_option['currency_position'] = isset($_POST['currency_position']) ? $_POST['currency_position'] : '';
		$cb_hm_option['deposit_type'] = isset($_POST['deposit_type']) ? $_POST['deposit_type'] : '';
		$cb_hm_option['deposit_percent'] = isset($_POST['deposit_percent']) ? $_POST['deposit_percent'] : '';
		$cb_hm_option['deposit_fixed'] = isset($_POST['deposit_fixed']) ? $_POST['deposit_fixed'] : '';
		$cb_hm_option['custom_cancelllation_policy'] = isset($_POST['custom_cancelllation_policy']) ? $_POST['custom_cancelllation_policy'] : '';
		$cb_hm_option['cancellation_policy_allowed'] = isset($_POST['cancellation_policy_allowed']) ? $_POST['cancellation_policy_allowed'] : 'no';
		$cb_hm_option['terms_full_charge_allowed'] = isset($_POST['terms_full_charge_allowed']) ? $_POST['terms_full_charge_allowed'] : 'no';
		$cb_hm_option['terms_full_charge_cancellation_days'] = isset($_POST['terms_full_charge_cancellation_days']) ? $_POST['terms_full_charge_cancellation_days'] : 'no';
		$cb_hm_option['terms_partial_charge_allowed'] = isset($_POST['terms_partial_charge_allowed']) ? $_POST['terms_partial_charge_allowed'] : 'no';
		$cb_hm_option['terms_partial_charge_type'] = isset($_POST['terms_partial_charge_type']) ? $_POST['terms_partial_charge_type'] : 'no';
		$cb_hm_option['terms_partial_charge_cancellation_days'] = isset($_POST['terms_partial_charge_cancellation_days']) ? $_POST['terms_partial_charge_cancellation_days'] : 'no';
		$cb_hm_option['terms_partial_amount'] = isset($_POST['terms_partial_amount']) ? $_POST['terms_partial_amount'] : 'no';

		$cb_hm_option['late_checkout_allowed'] = isset($_POST['late_checkout_allowed']) ? $_POST['late_checkout_allowed'] : 'no';
		$cb_hm_option['late_checkout_hour'] = isset($_POST['late_checkout_hour']) ? $_POST['late_checkout_hour'] : 'no';
		$cb_hm_option['late_checkout_type'] = isset($_POST['late_checkout_type']) ? $_POST['late_checkout_type'] : 'no';
		$cb_hm_option['late_checkout_val'] = isset($_POST['late_checkout_val']) ? $_POST['late_checkout_val'] : 'no';

		foreach ($cb_hm_option as $key => $value) {
	        if(get_option($this->cloudbeds_hotel_management.'_'.$key, FALSE)) { // If the custom field already has a value
	            update_option($this->cloudbeds_hotel_management.'_'.$key, $value);
	        } else { // If the custom field doesn't have a value
	            add_option( $this->cloudbeds_hotel_management.'_'.$key, $value );
	        }
	        if(!$value) delete_option($this->cloudbeds_hotel_management.'_'.$key); // Delete if blank
	    }
	    if($doappauthorization){
	    	$redirect   = $this->api_authorization_url.'?client_id='.$client_id.'&redirect_uri='.urlencode(admin_url( 'admin.php?page=mybookings-settings' )).'&response_type=code';
	    	$json = array('success'=>true, 'status'=>'redirect', 'message'=>__('Please Wait, Now Redirecting to Cloudbeds Server For Authorization this plugin.If not Redirect within 5second please click ', $this->cloudbeds_hotel_management).'<a href="'.$redirect.'">here</a>', 'redirect_url'=>$redirect );
	    }else {
	    	$json = array('success'=>true, 'status'=>'success', 'message'=>'Settings Updated!!!');
	    }
	    wp_send_json($json );
	}

	public function cloudbeds_hotel_management_payments_panel(){
		$cursym = $this->cb_hm_options('_payment_currency', '&pound;', false);
		include(plugin_dir_path( __FILE__ ).'partials/payments.php');
	}

	public function cloudbeds_hotel_management_documentation_panel(){
		$cursym = $this->cb_hm_options('_payment_currency', '&pound;', false);
		$plugin_admin = plugin_dir_url( __FILE__ );
		include(plugin_dir_path( __FILE__ ).'partials/documentation.php');
	}

	private function money_format($format, $number)
    {
    	// var_dump($_SERVER);
    	// return ;
    	// if($_SERVER['HTTP_HOST'] == 'localhost'){
    	// 	return $number;
    	// }
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

	public function cb_hm_options($option_name = '_logo', $default_val = '', $echo = false){

		$return = $default_val;	
		get_option( $option, $default );  
		$variable = get_option($this->cloudbeds_hotel_management . $option_name);
		if(!is_array($variable)) 
			$variable = stripcslashes(trim($variable)); 	
		if(!empty($variable))$return = $variable; 		
		if($echo) 
			echo $return;		
		else 
		    return $return; 	
	}

	public function reservation_results_callback() {
	    $data = array();

	    $date_from = isset($_GET['date_from']) ? $_GET['date_from'] : date('d/m/Y', strtotime('-30days'));

	    $date_to = isset($_GET['date_to']) ? $_GET['date_to'] : date('d/m/Y');

	    $initialize = isset($_GET['initialize']) ? $_GET['initialize'] : false;

	    $getall = isset($_GET['getall']) ? $_GET['getall'] : false;

	    $date_from_d = substr($date_from, 0, 2);

	    $date_from_m = substr($date_from, 3, 2);

	    $date_from_y = substr($date_from, 6, 4);

	    $date_to_d = substr($date_to, 0, 2);

	    $date_to_m = substr($date_to, 3, 2);

	    $date_to_y = substr($date_to, 6, 4);

	    $dfrom = $date_from_y.
	    '-'.$date_from_m.
	    '-'.$date_from_d.
	    ' 00:00:00';

	    $dto = $date_to_y.
	    '-'.$date_to_m.
	    '-'.$date_to_d.
	    ' 23:59:59';

	    global $wpdb;

	    $booktable = $wpdb->prefix.$this->bookingtable;

	    if ($getall) {
	        $sql = "SELECT * FROM `$booktable` WHERE `arriving` between '$dfrom' and '$dto' OR `departing` between '$dfrom' and '$dto' ORDER BY `order_time` DESC";
	    } else {
	        $sql = "SELECT * FROM `$booktable` WHERE `archive` !=1 and (`arriving` between '$dfrom' and '$dto' OR `departing` between '$dfrom' and '$dto') ORDER BY `order_time` DESC";
	    }

	    $results = $wpdb->get_results($sql);

	    // var_export($sql);

	    $status_class = array('fa-square-o', 'fa-square', 'fa-check-square-o', 'fa-times-circle');

	    // $status_array  = array('Initialize', 'Pending', 'Approved', 'Rejected');

	    $status_array = array('Initialize', 'New Booking', 'Confirmed', 'Cancelled');

	    foreach($results as $key => $row) {

	        $data[$key] = array();

	        $data[$key]['class'] = $status_class[$row->status];

	        $data[$key]['status'] = $status_array[$row->status];

	        $data[$key]['booking_ref'] = $row->booking_ref;

	        $data[$key]['roomtype_id'] = $row->roomtype_id;

	        if($row->user_id == 0){
	        	$userinfo = unserialize($row->guests);
	        	if(!empty($userinfo))
		        	$data[$key]['customer'] = ucfirst($userinfo['name']).
			        ' '.$userinfo['last_name'].
			        ' ['.$userinfo['email'].
			        ']';
	        }else {
		        $userdata = get_userdata($row->user_id);

		        $all_meta_for_user = array_map(function($a) {
		            return $a[0];
		        }, get_user_meta($row->user_id));

		        $data[$key]['customer'] = ucfirst($all_meta_for_user['res_title']).
		        ' '.ucfirst($all_meta_for_user['first_name']).
		        ' '.$all_meta_for_user['last_name'].
		        ' ['.$userdata->user_email.
		        ']';
		    }
	        // $data[$key]['id']        = $row->id;

	        $data[$key]['arriving'] = date('d/m/Y', strtotime($row->arriving));

	        $data[$key]['departing'] = date('d/m/Y', strtotime($row->departing));

	        $data[$key]['nights'] = $row->stay;

	        $data[$key]['roomquantity'] = $row->roomquantity;

	        $data[$key]['price'] = $row->price;

	        $data[$key]['qtprice'] = $row->qtprice;

	        $data[$key]['order_time'] = $row->order_time;

	    }

	    echo json_encode($data);

	    exit(0);

	}

	public function cloudbeds_hotel_management_new_room(){
		$current_user = wp_get_current_user();
		$nonce = isset($_POST['wp_nonce']) ? $_POST['wp_nonce'] : null;
		$action = $this->cloudbeds_hotel_management.'_new_room';
		if(!$nonce || !wp_verify_nonce( $nonce, $action ) ){
			$json = array('success'=>false, 'status'=>'error', 'message'=>'Invalid Request');
			wp_send_json($json );
		}
		$title = isset($_POST['title']) ? $_POST['title'] : '';
		$content = isset($_POST['long_description']) ? $_POST['long_description'] : '';
		$excerpt = isset($_POST['sort-desc']) ? $_POST['sort-desc'] : '';
		$defaults = array(
			'post_title'    => $title,
			'post_content'  => $content,
			'post_excerpt'  => $excerpt,
			'post_status'   => 'publish',
			'post_type'     => $this->roomtype,
			'post_author'   => $current_user->ID,
			'ping_status'   => get_option('default_ping_status'), 
			'post_parent'   => 0,
			'menu_order' 	=> 0
		);
		$post_meta = array();
		$post_id = wp_insert_post( $defaults );
		if($post_id){
			$post_meta['no_rooms'] = isset($_POST['no_rooms']) ? $_POST['no_rooms'] : '';
			$post_meta['guest'] = isset($_POST['guest']) ? $_POST['guest'] : 0;
			$post_meta['kids'] = isset($_POST['kids']) ? $_POST['kids'] : 0;
			$post_meta['max_guest'] = isset($_POST['max_guest']) ? $_POST['max_guest'] : 0;
			$post_meta['max_kids'] = isset($_POST['max_kids']) ? $_POST['max_kids'] : 0;
			$post_meta['minimumnights'] = isset($_POST['minimumnights']) ? $_POST['minimumnights'] : 1;
			$post_meta['room_size'] = isset($_POST['room_size']) ? $_POST['room_size'] : '';
			$post_meta['room_images'] = isset($_POST['room_images']) ? $_POST['room_images'] : array();
			$post_meta['single'] = isset($_POST['single']) ? $_POST['single'] : '';
			$post_meta['double'] = isset($_POST['double']) ? $_POST['double'] : '';
			$post_meta['queen_size'] = isset($_POST['queen_size']) ? $_POST['queen_size'] : '';
			$post_meta['king_size'] = isset($_POST['king_size']) ? $_POST['king_size'] : '';
			$post_meta['amenity'] = isset($_POST['amenity']) ? $_POST['amenity'] : array();
			$post_meta['price'] = isset($_POST['price']) ? $_POST['price'] : '';
			foreach ($post_meta as $key => $value) {
		        if(get_post_meta($post_id, $this->cloudbeds_hotel_management.'_'.$key, FALSE)) { // If the custom field already has a value
		            update_post_meta($post_id, $this->cloudbeds_hotel_management.'_'.$key, $value);
		        } else { // If the custom field doesn't have a value
		            add_post_meta( $post_id, $this->cloudbeds_hotel_management.'_'.$key, $value, true );
		        }
		        if(!$value) delete_post_meta($post_id, $key); // Delete if blank
		    }
		    $json = array('success'=>true, 'status'=>'success', 'message'=>'Room Created', 'room_id'=> $post_id);
		    wp_send_json($json );
		}else {
			$json = array('success'=>true, 'status'=>'error', 'message'=>'Room Create Failed!!!', 'id'=>$post_id);
		    wp_send_json($json );
		}
		exit(0);
	}

	public function cloudbeds_hotel_management_edit_room(){
		$current_user = wp_get_current_user();
		$nonce = isset($_POST['wp_nonce']) ? $_POST['wp_nonce'] : null;
		$action = $this->cloudbeds_hotel_management.'_edit_room';
		if(!$nonce || !wp_verify_nonce( $nonce, $action ) ){
			$json = array('success'=>false, 'status'=>'error', 'message'=>'Invalid Request');
			wp_send_json($json );
		}
		$post_id = isset($_POST['room_id']) ? $_POST['room_id'] : '';
		$title = isset($_POST['title']) ? $_POST['title'] : '';
		$content = isset($_POST['long_description']) ? $_POST['long_description'] : '';
		$excerpt = isset($_POST['sort-desc']) ? $_POST['sort-desc'] : '';
		$args = array(
			'ID'			=> $post_id,
			'post_title'    => $title,
			'post_content'  => $content,
			'post_excerpt'  => $excerpt
		);
		$post_meta = array();
		$success = wp_update_post( $args );
		if($success){
			$post_meta['no_rooms'] = isset($_POST['no_rooms']) ? $_POST['no_rooms'] : '';
			$post_meta['guest'] = isset($_POST['guest']) ? $_POST['guest'] : 0;
			$post_meta['kids'] = isset($_POST['kids']) ? $_POST['kids'] : 0;
			$post_meta['max_guest'] = isset($_POST['max_guest']) ? $_POST['max_guest'] : 0;
			$post_meta['max_kids'] = isset($_POST['max_kids']) ? $_POST['max_kids'] : 0;
			$post_meta['minimumnights'] = isset($_POST['minimumnights']) ? $_POST['minimumnights'] : 1;
			$post_meta['room_size'] = isset($_POST['room_size']) ? $_POST['room_size'] : '';
			$post_meta['room_images'] = isset($_POST['room_images']) ? $_POST['room_images'] : array();
			$post_meta['single'] = isset($_POST['single']) ? $_POST['single'] : '';
			$post_meta['double'] = isset($_POST['double']) ? $_POST['double'] : '';
			$post_meta['queen_size'] = isset($_POST['queen_size']) ? $_POST['queen_size'] : '';
			$post_meta['king_size'] = isset($_POST['king_size']) ? $_POST['king_size'] : '';
			$post_meta['amenity'] = isset($_POST['amenity']) ? $_POST['amenity'] : array();
			$post_meta['price'] = isset($_POST['price']) ? $_POST['price'] : '';
			foreach ($post_meta as $key => $value) {
		        if(get_post_meta($post_id, $this->cloudbeds_hotel_management.'_'.$key, FALSE)) { // If the custom field already has a value
		            update_post_meta($post_id, $this->cloudbeds_hotel_management.'_'.$key, $value);
		        } else { // If the custom field doesn't have a value
		            add_post_meta( $post_id, $this->cloudbeds_hotel_management.'_'.$key, $value, true );
		        }
		        if(!$value) delete_post_meta($post_id, $key); // Delete if blank
		    }
		    $json = array('success'=>true, 'status'=>'success', 'message'=>'Room Updated Successfully!!!');
		    wp_send_json($json );
		}else {
			$json = array('success'=>true, 'status'=>'error', 'message'=>'Room Create Failed!!!', 'id'=>$post_id);
		    wp_send_json($json );
		}
		exit(0);
	}

	public function generate_timezone_list() {
	    static $regions = array(
	        DateTimeZone::AFRICA,
	        DateTimeZone::AMERICA,
	        DateTimeZone::ANTARCTICA,
	        DateTimeZone::ASIA,
	        DateTimeZone::ATLANTIC,
	        DateTimeZone::AUSTRALIA,
	        DateTimeZone::EUROPE,
	        DateTimeZone::INDIAN,
	        DateTimeZone::PACIFIC,
	    );

	    $timezones = array();
	    foreach( $regions as $region )
	    {
	        $timezones = array_merge( $timezones, DateTimeZone::listIdentifiers( $region ) );
	    }

	    $timezone_offsets = array();
	    foreach( $timezones as $timezone )
	    {
	        $tz = new DateTimeZone($timezone);
	        $timezone_offsets[$timezone] = $tz->getOffset(new DateTime);
	    }

	    // sort timezone by timezone name
	    ksort($timezone_offsets);

	    $timezone_list = array();
	    foreach( $timezone_offsets as $timezone => $offset )
	    {
	        $offset_prefix = $offset < 0 ? '-' : '+';
	        $offset_formatted = gmdate( 'H:i', abs($offset) );

	        $pretty_offset = "UTC${offset_prefix}${offset_formatted}";
	        
	        $t = new DateTimeZone($timezone);
	        $c = new DateTime(null, $t);
	        $current_time = $c->format('g:i A');

	        $timezone_list[$timezone] = "(${pretty_offset}) $timezone - $current_time";
	    }

	    return $timezone_list;
	}

	private function getdates($first='', $last='', $day = 'Sun', $step = '+1 day', $format = 'Y-m-d' ) { 
	    $dates = array();
	    $current = strtotime($first);
	    $last = strtotime($last);
	    while( $current <= $last ) { 
	        if (date("D", $current) == $day)
	            $dates[] = date($format, $current);
	        $current = strtotime($step, $current);
	    }
	    return $dates;
	}

	private function datelist($from, $to){
		$dates = array();
		$datefrom = mktime(1,0,0, substr($from,5,2), substr($from, 8, 2), substr($from, 0, 4));
		$dateto = mktime(1,0,0, substr($to,5,2), substr($to, 8, 2), substr($to, 0, 4));

		if($dateto >= $datefrom){
			array_push($dates, date('Y-m-d', $datefrom));
			while($datefrom < $dateto){
				$datefrom +=86400;
				array_push($dates, date('Y-m-d', $datefrom));
			}
		}
		return $dates;
	}

	private function empty_n_insert($post_id, $bookdate , $price , $setdefault = false, $available = null, $allocation = null, $minimum_stay = 1){
		global $wpdb;
		$now = date('Y-m-d h:i:s');
		$sql = "SELECT `id` FROM `".$wpdb->prefix.$this->roomratedb."` WHERE `bookdate`='$bookdate' AND `roomtype_id`='$post_id'";
		$row = $wpdb->query($sql);
		if(empty($row)){
			if($setdefault) $price = get_post_meta($post_id, $this->cloudbeds_hotel_management.'_price', true );
	   		if(!isset($available)) $available = 1;
	   		if(!isset($allocation)) {
	   			$allocation = get_post_meta($post_id, $this->cloudbeds_hotel_management.'_no_rooms', true);
	   			if($allocation == '') $allocation = 3;
	   		} 
	       	$success = $wpdb->query("
				insert into ".$wpdb->prefix.$this->roomratedb." 
				 (
					`id` ,
					`roomtype_id` ,
					`bookdate` ,
					`price` ,
					`available` ,
					`allocation` ,
					`minimum_stay`
					)
					VALUES (
							NULL , '$post_id', '$bookdate' , '$price' , '$available', '$allocation', '$minimum_stay' 
					)"
	       	);
		}
	}

	public function cloudbeds_hotel_management__roomrate_update(){
		$data = isset($_POST['data']) ? $_POST['data'] : '';
		$room = isset($data['room']) ? $data['room'] : '';
		$date = isset($data['date']) ? $data['date'] : '';
		$status = isset($data['status']) ? $data['status'] : '';
		if($status == 'bookable'){
			$status = 1;
		}else {
			$status = 0;
		}
		if($room !=''):
			global $wpdb;
			$now = date('Y-m-d h:i:s');
			$sql = "UPDATE `".$wpdb->prefix.$this->roomratedb."` SET `available` = '".$status."',  update_time = '$now' WHERE `roomtype_id` = '$room' and `bookdate` = '$date'";
			$success = $wpdb->query($sql);
			$gsql = "SELECT * FROM `".$wpdb->prefix.$this->roomratedb."` WHERE `roomtype_id`='$room' AND `bookdate`='$date' LIMIT 0,1";
			$result = $wpdb->get_results($gsql);
			if($result[0]->available == '1' ) $status = 'closed';
			else $status = 'bookable';
			$statusinfo = array(
				'tooltip'	=> $result[0]->price,
				'status'	=> $status,
				'value'		=> null,
				'date'		=> $result[0]->bookdate,
				'room'		=> $result[0]->roomtype_id,
				'clickable'	=> '1',
				'field'		=> 'hidden',
			);
			$json = array (
				'success'			=> true,
				'error'				=> '',
				'status'			=> $status,
				'datastatusinfo'	=> $statusinfo
			);
		else:
			$json = array (
				'success'	=> false,
				'error'		=> 'Update failed'
			);
		endif;
		wp_send_json( $json );
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

	   // add_action('admin_notices', 'example_admin_notice');

	function cloudbeds_admin_notices() {
	    global $current_user ;
	        $user_id = $current_user->ID;
	    if ( !get_user_meta($user_id, 'cloudbeds_notices_nag_ignore') || get_user_meta($user_id, 'cloudbeds_notices_nag_ignore', true) <1 ) {
	        if( file_exists(TEMPLATEPATH.'/mybookings-light/api/propertydetails.php')){
	        	echo '<div class="cf"><div class="update-nag" style="display:block;"><p>';
	        	printf(__('Please update your api/propertydetails.php, on this version added hotel images and map on hotel description. <a href="%1$s" style="float:right;">Hide Notice</a>', $this->cloudbeds_hotel_management), admin_url( '?cloudbeds_notices_nag_ignore=1' )); 
	        	
	        	echo "</p></div></div>";
	        }
	    }
	    // get_plugin_data( $plugin_file, $markup, $translate );

	    $plugin_info = get_plugin_data(ABSPATH.'/wp-content/plugins/mybookings-light/mybookings-light.php');
	    // Now get remote server verion
	    $request = wp_remote_post($this->remote_path, array('body' => array('action' => 'version')));
        if (!is_wp_error($request) || wp_remote_retrieve_response_code($request) === 200) {
            $remote_version = $request['body'];
            if(version_compare($plugin_info['Version'], $remote_version, '<')){
            	echo '<div class="cf"><div class="update-nag" style="display:block;"><p>';
	        	printf(__('There is a new version of WP Mybookings available. Please Visit Plugin page to udpate.', $this->cloudbeds_hotel_management), admin_url( '?cloudbeds_notices_nag_ignore=1' )); 
	        	// echo ' <a href="'.admin_url('/plugins.php' ).'">here</a>';
	        	echo "</p></div></div>";
            }
        }
	}

	function cloudbeds_notices_nag_ignore() {
	    global $current_user;
	        $user_id = $current_user->ID;
	        if ( isset($_GET['cloudbeds_notices_nag_ignore']) && '1' == $_GET['cloudbeds_notices_nag_ignore'] ) {
	             update_usermeta($user_id, 'cloudbeds_notices_nag_ignore', '1', true);
	    }
	}


	private function countries($id = false){
		$countries = array(
			'AF' => 'Afghanistan','AX' => 'Aland Islands','AL' => 'Albania','DZ' => 'Algeria','AS' => 'American Samoa','AD' => 'Andorra','AO' => 'Angola','AI' => 'Anguilla','AQ' => 'Antarctica','AG' => 'Antigua And Barbuda','AR' => 'Argentina','AM' => 'Armenia','AW' => 'Aruba','AU' => 'Australia','AT' => 'Austria','AZ' => 'Azerbaijan','BS' => 'Bahamas','BH' => 'Bahrain','BD' => 'Bangladesh','BB' => 'Barbados','BY' => 'Belarus','BE' => 'Belgium','BZ' => 'Belize','BJ' => 'Benin','BM' => 'Bermuda','BT' => 'Bhutan','BO' => 'Bolivia','BA' => 'Bosnia And Herzegovina','BW' => 'Botswana','BV' => 'Bouvet Island','BR' => 'Brazil','IO' => 'British Indian Ocean Territory','BN' => 'Brunei Darussalam','BG' => 'Bulgaria','BF' => 'Burkina Faso','BI' => 'Burundi','KH' => 'Cambodia',                        'CM' => 'Cameroon','CA' => 'Canada','CV' => 'Cape Verde','KY' => 'Cayman Islands','CF' => 'Central African Republic','TD' => 'Chad','CL' => 'Chile','CN' => 'China','CX' => 'Christmas Island','CC' => 'Cocos (Keeling) Islands','CO' => 'Colombia','KM' => 'Comoros','CG' => 'Congo','CD' => 'Congo, Democratic Republic','CK' => 'Cook Islands','CR' => 'Costa Rica','CI' => 'Cote D\'Ivoire','HR' => 'Croatia','CU' => 'Cuba','CY' => 'Cyprus','CZ' => 'Czech Republic','DK' => 'Denmark','DJ' => 'Djibouti','DM' => 'Dominica','DO' => 'Dominican Republic','EC' => 'Ecuador','EG' => 'Egypt','SV' => 'El Salvador','GQ' => 'Equatorial Guinea','ER' => 'Eritrea','EE' => 'Estonia','ET' => 'Ethiopia','FK' => 'Falkland Islands (Malvinas)', 'FO' => 'Faroe Islands','FJ' => 'Fiji','FI' => 'Finland','FR' => 'France','GF' => 'French Guiana','PF' => 'French Polynesia','TF' => 'French Southern Territories','GA' => 'Gabon','GM' => 'Gambia','GE' => 'Georgia','DE' => 'Germany','GH' => 'Ghana','GI' => 'Gibraltar','GR' => 'Greece','GL' => 'Greenland','GD' => 'Grenada','GP' => 'Guadeloupe','GU' => 'Guam','GT' => 'Guatemala','GG' => 'Guernsey','GN' => 'Guinea','GW' => 'Guinea-Bissau','GY' => 'Guyana','HT' => 'Haiti','HM' => 'Heard Island & Mcdonald Islands','VA' => 'Holy See (Vatican City State)',                        'HN' => 'Honduras', 'HK' => 'Hong Kong','HU' => 'Hungary','IS' => 'Iceland','IN' => 'India','ID' => 'Indonesia','IR' => 'Iran, Islamic Republic Of','IQ' => 'Iraq','IE' => 'Ireland','IM' => 'Isle Of Man','IL' => 'Israel','IT' => 'Italy','JM' => 'Jamaica','JP' => 'Japan','JE' => 'Jersey','JO' => 'Jordan','KZ' => 'Kazakhstan','KE' => 'Kenya','KI' => 'Kiribati','KR' => 'Korea','KW' => 'Kuwait','KG' => 'Kyrgyzstan','LA' => 'Lao People\'s Democratic Republic','LV' => 'Latvia','LB' => 'Lebanon','LS' => 'Lesotho','LR' => 'Liberia','LY' => 'Libyan Arab Jamahiriya','LI' => 'Liechtenstein','LT' => 'Lithuania','LU' => 'Luxembourg','MO' => 'Macao','MK' => 'Macedonia','MG' => 'Madagascar','MW' => 'Malawi','MY' => 'Malaysia','MV' => 'Maldives','ML' => 'Mali','MT' => 'Malta','MH' => 'Marshall Islands',                        'MQ' => 'Martinique','MR' => 'Mauritania','MU' => 'Mauritius','YT' => 'Mayotte','MX' => 'Mexico','FM' => 'Micronesia, Federated States Of','MD' => 'Moldova','MC' => 'Monaco','MN' => 'Mongolia','ME' => 'Montenegro','MS' => 'Montserrat','MA' => 'Morocco','MZ' => 'Mozambique','MM' => 'Myanmar','NA' => 'Namibia','NR' => 'Nauru','NP' => 'Nepal','NL' => 'Netherlands','AN' => 'Netherlands Antilles','NC' => 'New Caledonia','NZ' => 'New Zealand','NI' => 'Nicaragua','NE' => 'Niger','NG' => 'Nigeria','NU' => 'Niue','NF' => 'Norfolk Island','MP' => 'Northern Mariana Islands','NO' => 'Norway','OM' => 'Oman','PK' => 'Pakistan','PW' => 'Palau','PS' => 'Palestinian Territory, Occupied','PA' => 'Panama','PG' => 'Papua New Guinea','PY' => 'Paraguay','PE' => 'Peru','PH' => 'Philippines','PN' => 'Pitcairn','PL' => 'Poland','PT' => 'Portugal','PR' => 'Puerto Rico','QA' => 'Qatar','RE' => 'Reunion','RO' => 'Romania','RU' => 'Russian Federation','RW' => 'Rwanda','BL' => 'Saint Barthelemy','SH' => 'Saint Helena','KN' => 'Saint Kitts And Nevis','LC' => 'Saint Lucia','MF' => 'Saint Martin','PM' => 'Saint Pierre And Miquelon','VC' => 'Saint Vincent And Grenadines','WS' => 'Samoa',                        'SM' => 'San Marino','ST' => 'Sao Tome And Principe','SA' => 'Saudi Arabia','SN' => 'Senegal','RS' => 'Serbia','SC' => 'Seychelles','SL' => 'Sierra Leone','SG' => 'Singapore','SK' => 'Slovakia','SI' => 'Slovenia','SB' => 'Solomon Islands','SO' => 'Somalia','ZA' => 'South Africa','GS' => 'South Georgia And Sandwich Isl.','ES' => 'Spain','LK' => 'Sri Lanka','SD' => 'Sudan','SR' => 'Suriname','SJ' => 'Svalbard And Jan Mayen','SZ' => 'Swaziland','SE' => 'Sweden','CH' => 'Switzerland','SY' => 'Syrian Arab Republic','TW' => 'Taiwan','TJ' => 'Tajikistan','TZ' => 'Tanzania','TH' => 'Thailand','TL' => 'Timor-Leste','TG' => 'Togo','TK' => 'Tokelau','TO' => 'Tonga','TT' => 'Trinidad And Tobago','TN' => 'Tunisia','TR' => 'Turkey','TM' => 'Turkmenistan','TC' => 'Turks And Caicos Islands','TV' => 'Tuvalu', 'UG' => 'Uganda', 'UA' => 'Ukraine','AE' => 'United Arab Emirates','GB' => 'United Kingdom','US' => 'United States','UM' => 'United States Outlying Islands','UY' => 'Uruguay','UZ' => 'Uzbekistan','VU' => 'Vanuatu','VE' => 'Venezuela','VN' => 'Viet Nam','VG' => 'Virgin Islands, British','VI' => 'Virgin Islands, U.S.','WF' => 'Wallis And Futuna','EH' => 'Western Sahara','YE' => 'Yemen','ZM' => 'Zambia','ZW' => 'Zimbabwe'  );
		if($id){
			return $countries[$id];
		}else {
			return $countries;
		}
	}

	function cloudbeds_update_plugin(){
		require_once (plugin_dir_path( __FILE__ ).'plugin_autoupdate.php');
	    $mybookings_plugin_path = $this->remote_path;
	    $mybookings_plugin_slug = 'mybookings-light/mybookings-light.php';
	    new mybookings_autoupdate($this->version, $mybookings_plugin_path, $mybookings_plugin_slug);

	}

	function show_admin_notification($msg){
		if($msg !='')
    		echo '<div class="updated"><p>'.__( $msg, $this->cloudbeds_hotel_management ).'</p></div>';
	}
}



