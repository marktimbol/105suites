<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       http://www.omasters.com
 * @since      0.0.1
 *
 * @package    Cloudbeds_Hotel_Management
 * @subpackage Cloudbeds_Hotel_Management/admin/partials
 * @template   Settings
 */
	if($amenity == ''){
		$amenity = array();
	}

?>
<div class="cb_hm wrap">
	<div class="clearfix"><div class="mixin-col span_11"><h2><?php _e('Settings', $this->cloudbeds_hotel_management); ?></h2></div></div>
	<div>
		<div class="hm_tab_panel">
			<ul>
				<li><a href="javascript:void(0)" class="active" rel="hotelinfotab"><?php _e('Hotel Info', $this->cloudbeds_hotel_management); ?></a></li>
				<li><a href="javascript:void(0)" class="<?php if($api_enabled =='yes') echo 'disabled'; ?>" rel="generaltab"><?php _e('General Settings', $this->cloudbeds_hotel_management); ?></a></li>
				<li><a href="javascript:void(0)" class="<?php if($api_enabled =='yes') echo 'disabled'; ?>" rel="reservationpolicytab">Reservations Policy</a></li>
				<li><a href="javascript:void(0)" class="<?php if($api_enabled =='yes') echo 'disabled'; ?>" rel="emailstab">Emails</a></li>
			</ul>
		</div>
		<div class="container_panel" style="margin-top:0;position:relative;">	
			<form action="<?php echo admin_url('/admin-ajax.php' ); ?>" id="cloudbeds_hotel_management_settings" onsubmit="return false;">
				<input type="hidden" name="action" value="<?php echo $action; ?>"/>
				<input type="hidden" name="wp_nonce" value="<?php echo $nonce; ?>" />
				<div id="cb_hm_tab_content">
					<div id="hotelinfotab" class="row cb_hm_tabs active">
						<div class="row">
							<div class="mixin-col span_11">
								<h3>Enter Your Hotel Info</h3>
							</div>
						</div>
						<hr/>
						<div class="accordion">
							<div class="accordiontab">
								<div class="accordionhead">
									<label for="using_cb_api">
										<input type="radio" name="using_cb_api" id="using_cb_api" value="yes" <?php if($api_enabled =='yes') echo 'checked="checked"'; ?> />
											<?php _e('Cloudbeds API Integration', $this->cloudbeds_hotel_management); ?>
										<a href="javascript:void(0)" class="qtip-tooltip">
											<i class="fa fa-question-circle"></i>
										</a>
										<div class="displaynone qtipinfo">
											<?php _e('If you are a Cloudbeds customer, you can integrate WP Mybookings with Cloudbeds\' premium booking engine,', $this->cloudbeds_hotel_management); ?> <a href="https://www.cloudbeds.com/mybookings?utm_source=self&amp;utm_medium=plugin&amp;utm_campaign=wp-mybookings" target="_blank">mybookings</a>. <?php _e('This paid option allows you to serve your mybookings booking engine directly from a page on your website. To manage your property info, images, rates and more, log into the', $this->cloudbeds_hotel_management); ?> <a href="https://www.cloudbeds.com/myfrontdesk?utm_source=self&amp;utm_medium=plugin&amp;utm_campaign=wp-mybookings" target="_blank">myfrontdesk</a> property management system <a href="https://hotels.cloudbeds.com/login?utm_source=self&amp;utm_medium=plugin&amp;utm_campaign=wp-mybookings" target="_blank">at Cloudbeds.com</a>. <?php _e('Any changes made there will appear on your website.', $this->cloudbeds_hotel_management); ?>
										</div>
									</label>
								</div>
								<div class="accordioncontent" <?php if($api_enabled =='yes') echo 'style="display:block;"'; ?>>
									<p>To use Cloudbeds API, you must first get a Client ID and Client Secret pair of keys.  See the “How to get a Client ID and Client Secret key pair" in the <a href="<?php echo admin_url('admin.php?page=mybookings-documentation'); ?>">Documentation</a> if you need help doing this.  Once you’ve entered the Client ID and Client Secret and click the "Save" button, you will be sent to a page on Cloudbeds.com asking if you want to allow this WordPress plugin to access your Cloudbeds account. Click the “Accept" button on that page and you will be redirected back here automatically.</p>
									<?php if($cloudbeds_app_code !='') echo '<div class="displaynone">';?>
										   
										<h3><?php _e('Client ID', $this->cloudbeds_hotel_management); ?>
											<a href="javascript:void(0)" class="qtip-tooltip">
												<i class="fa fa-question-circle"></i>
											</a>
											<div class="displaynone qtipinfo">
												Obtain, copy, and paste your Client ID and Client Secret from your myfrontdesk "API Integrations &amp; Credentials" page. More details on can be found on <a href="<?php echo admin_url( 'admin.php?page=mybookings-documentation' ); ?>" target="_blank">documentation page</a>
											</div>
										</h3>
										<div class="cf">
											<?php
											// <input type="text" class="text form-control" name="cloudbeds_api_key" value="<?php echo $cloudbeds_api_key;" />
											?>
											<input type="text" class="text form-control required" name="client_id" value="<?php echo $client_id; ?>" />
										</div>	
										<h3><?php _e('Client Secret', $this->cloudbeds_hotel_management); ?>
											<a href="javascript:void(0)" class="qtip-tooltip">
												<i class="fa fa-question-circle"></i>
											</a>
											<div class="displaynone qtipinfo">
												Obtain, copy, and paste your Client ID and Client Secret from your myfrontdesk "API Integrations &amp; Credentials" page. More details on can be found on <a href="<?php echo admin_url( 'admin.php?page=mybookings-documentation' ); ?>" target="_blank">documentation page</a>
											</div>
										</h3>
										<div class="cf">
											<?php
											// <input type="text" class="text form-control" name="cloudbeds_api_key" value="<?php echo $cloudbeds_api_key;" />
											?>
											<input type="text" class="text form-control required" name="client_secret" value="<?php echo $client_secret; ?>" />
										</div>	
										<h3><?php _e('Redirect Url', $this->cloudbeds_hotel_management); ?>
											<a href="javascript:void(0)" class="qtip-tooltip">
												<i class="fa fa-question-circle"></i>
											</a>
											<div class="displaynone qtipinfo">
												Obtain, copy, and paste your Redirect URL from your myfrontdesk "API Integrations &amp; Credentials" page. More details on can be found on <a href="<?php echo admin_url( 'admin.php?page=mybookings-documentation' ); ?>" target="_blank">documentation page</a>
											</div>
										</h3>
										<div class="cf">
											<?php
											// <input type="text" class="text form-control" name="cloudbeds_api_key" value="<?php echo $cloudbeds_api_key;" />
											?>
											<input type="text" readonly="readonly" class="text form-control required" name="redirect_url" value="<?php echo $redirect_url; ?>" />
										</div>	
									<?php if($cloudbeds_app_code !='') echo '</div>';?>
									<?php 
									// if(!ini_get('allow_url_fopen') ) {
									// 	// echo '<div class="alert alert-danger">You have to enable <strong>allow_url_fopen</strong> to use this method, Please consult your server administrator to resolve this.</div>';
									// }else { 
									// } 
									?>
								</div>
							</div>	
							<div class="accordiontab">
								<div class="accordionhead">
									<label for="using_system">
											<input type="radio" name="using_cb_api" id="using_system" value="no" <?php if($api_enabled == 'no') echo 'checked="checked"'; ?> />
											<?php _e('Standalone', $this->cloudbeds_hotel_management); ?>
										<a href="javascript:void(0)" class="qtip-tooltip">
											<i class="fa fa-question-circle"></i>
										</a>
										<div class="displaynone qtipinfo">
											<?php _e('If you are not a Cloudbeds customer, you can still use WP Mybookings. This free option gives you a stand-alone booking engine, where you manage your photos, property info and room info directly from this plugin.', $this->cloudbeds_hotel_management); ?>
										</div>
									</label>
								</div>
								<div class="accordioncontent"<?php if($api_enabled == 'no') echo 'style="display:block;"'; ?>>
									<section class="mixin-col span_6">
										<div class="form-group">
											<label for="propertyname">Property Name</label>
											<div class="row">
												<div class="mixin-col span_11">
													<input type="text" class="form-control required" id="propertyname" name="propertyname" value="<?php echo $propertyname; ?>" />
												</div>
											</div>
										</div>
										<div class="form-group">
											<label for="propertywebsite">Property Website</label>
											<div class="row">
												<div class="mixin-col span_11">
													<input type="text" class="form-control required" id="propertywebsite" name="propertywebsite" value="<?php echo $propertywebsite; ?>" />
												</div>
											</div>
										</div>
										<div class="form-group">
											<label for="email">Email</label>
											<div class="row">
												<div class="mixin-col span_11">
													<input type="email" class="form-control {required:true, email:true}" id="email" name="email" value="<?php echo $email; ?>" />
												</div>
											</div>
										</div>
										<div class="form-group">
											<label for="phone">Phone Number</label>
											<div class="row">
												<div class="mixin-col span_11">
													<input type="text" class="form-control required" id="phone" name="phone" value="<?php echo $phone; ?>" />
												</div>
											</div>
										</div>
										<div class="form-group">
											<label for="facebook">Facebook</label>
											<div class="row">
												<div class="mixin-col span_11">
													<input type="text" class="form-control" id="facebook" name="facebook" value="<?php echo $facebook; ?>" />
												</div>
											</div>
										</div>
										<div class="form-group">
											<label for="property-type">Property Type</label>
											<div class="row">
												<div class="mixin-col span_11">
													<select name="property-type" id="property-type" class="form-control required">
														<option>Select Property Type</option>
														<?php foreach($propertyType as $key=>$value){
															echo '<option value="'.$key.'"';
															echo ($key == $type) ? ' selected="selected">' : '>';
															echo $value.'</option>';
														} ?>
													</select>
												</div>
											</div>
										</div>
										<div class="form-group">
											<label for="property-description">Property Short Description</label>
											<div class="row">
												<div class="mixin-col span_11">
													<?php
														$content = $propertydescription;
														$editor_id = 'propertydescription';
														wp_editor( $content, $editor_id, array('textarea_name' => $editor_id, 'textarea_rows' => 12) );
													?>
												</div>
											</div>
										</div>
									</section>
									<section class="mixin-col span_6">
										<h3>Hotel Pictures</h3>
										<small>We want you to look your best, upload up to 10 photos.</small>
										<div class="row">
											<div class="mixin-col span_5 room_images">
												<?php if($coverImage){ ?>
													<input type="hidden" class="uploadfield" name="room_images[]" value="<?php echo $coverImage['id']; ?>" />
													<div class="room_img first" style="background-image:url(<?php echo $coverImage['image']; ?>);">
														<div class="image_editor_box">
															<a href="JavaScript:void(0)" class="<?php echo $this->cloudbeds_hotel_management; ?>_cb_hm_change_image cb_hm_change_image">change</a>
															<a href="JavaScript:void(0)" class="<?php echo $this->cloudbeds_hotel_management; ?>_cb_hm_remove_image cb_hm_remove_image"><i class="fa fa-trash"></i></a>
														</div>
													</div>
												<?php }else{ ?>
													<input type="hidden" class="uploadfield" name="room_images[]" value="" />
													<div class="room_img first">
														<a href="javscript:void(0)" class="<?php echo $this->cloudbeds_hotel_management; ?>_cb_hm_upload_image_button cb_hm_uploader"></a>
													</div>
												<?php } ?>
											</div>
											<div class="mixin-col span_7">
												<div class="row">
													<?php for ($i=1; $i < 4 ; $i++) {
														if(!empty($images[$i])){
															$image = $images[$i];
															$edittool = '<div class="image_editor_box"> <a href="JavaScript:void(0)" class="'.$this->cloudbeds_hotel_management.'_cb_hm_change_image cb_hm_change_image">change</a> <a href="JavaScript:void(0)" class="'.$this->cloudbeds_hotel_management.'_cb_hm_remove_image cb_hm_remove_image"><i class="fa fa-trash"></i></a> </div>';
														}else {
															$image = '';
															$edittool = '<a href="javscript:void(0)" class="'.$this->cloudbeds_hotel_management.'_cb_hm_upload_image_button cb_hm_uploader"></a>';
														} ?>
														<div class="mixin-col span_4 room_images">
															<input type="hidden" class="uploadfield" name="room_images[]" value="<?php echo $image; ?>" />
															<?php 
																$url = wp_get_attachment_image_src($image, array(200,200) );
															?>
															<div class="room_img" style="background-image:url(<?php echo $url[0]; ?>);">
																<?php echo $edittool; ?>
															</div>
														</div>
													<?php } ?>
												</div>
												<div class="row">
													<?php for ($i=4; $i < 7 ; $i++) {
														if(!empty($images[$i])){
															$image = $images[$i];
															$edittool = '<div class="image_editor_box"> <a href="JavaScript:void(0)" class="'.$this->cloudbeds_hotel_management.'_cb_hm_change_image cb_hm_change_image">change</a> <a href="JavaScript:void(0)" class="'.$this->cloudbeds_hotel_management.'_cb_hm_remove_image cb_hm_remove_image"><i class="fa fa-trash"></i></a> </div>';
														}else {
															$image = '';
															$edittool = '<a href="javscript:void(0)" class="'.$this->cloudbeds_hotel_management.'_cb_hm_upload_image_button cb_hm_uploader"></a>';
														} ?>
														<div class="mixin-col span_4 room_images">
															<input type="hidden" class="uploadfield" name="room_images[]" value="<?php echo $image; ?>" />
															<?php 
																$url = wp_get_attachment_image_src($image, array(200,200) );
															?>
															<div class="room_img" style="background-image:url(<?php echo $url[0]; ?>);">
																<?php echo $edittool; ?>
															</div>
														</div>
													<?php } ?>
												</div>
												<div class="row">
													<?php for ($i=7; $i < 10 ; $i++) {
														if(!empty($images[$i])){
															$image = $images[$i];
															$edittool = '<div class="image_editor_box"> <a href="JavaScript:void(0)" class="'.$this->cloudbeds_hotel_management.'_cb_hm_change_image cb_hm_change_image">change</a> <a href="JavaScript:void(0)" class="'.$this->cloudbeds_hotel_management.'_cb_hm_remove_image cb_hm_remove_image"><i class="fa fa-trash"></i></a> </div>';
														}else {
															$image = '';
															$edittool = '<a href="javscript:void(0)" class="'.$this->cloudbeds_hotel_management.'_cb_hm_upload_image_button cb_hm_uploader"></a>';
														} ?>
														<div class="mixin-col span_4 room_images">
															<input type="hidden" class="uploadfield" name="room_images[]" value="<?php echo $image; ?>" />
															<?php 
																$url = wp_get_attachment_image_src($image, array(200,200) );
															?>
															<div class="room_img" style="background-image:url(<?php echo $url[0]; ?>);">
																<?php echo $edittool; ?>
															</div>
														</div>
													<?php } ?>
												</div>
											</div>
										</div>
										<div class="form-group">
											<label for="address1">Address 1</label>
											<div class="row">
												<div class="mixin-col span_11">
													<input type="text" class="form-control required" id="address1" name="address1" value="<?php echo $address1; ?>" />
												</div>
											</div>
										</div>
										<div class="form-group">
											<label for="address2">Address 2</label>
											<div class="row">
												<div class="mixin-col span_11">
													<input type="text" class="form-control" id="address2" name="address2" value="<?php echo $address2; ?>" />
												</div>
											</div>
										</div>
										<div class="form-group">
											<label for="state">State</label>
											<div class="row">
												<div class="mixin-col span_11">
													<input type="text" class="form-control required" id="state" name="state" value="<?php echo $state; ?>" />
												</div>
											</div>
										</div>
										<div class="form-group">
											<label for="city">City</label>
											<div class="row">
												<div class="mixin-col span_11">
													<input type="text" class="form-control required" id="city" name="city" value="<?php echo $city; ?>" />
												</div>
											</div>
										</div>
										<div class="form-group">
											<div class="row">
												<div class="mixin-col span_6">
													<label for="street">Zip Code / Postal Code</label>
													<div class="row">
														<div class="mixin-col span_11">
															<input type="text" class="form-control required" id="zip" name="zip" value="<?php echo $zip; ?>" />
														</div>
													</div>
												</div>
												<div class="mixin-col span_5">
													<label for="country">Country</label>
													<select name="country" id="country" class="form-control required">
														<option value="">--Select Country--</option>
														<?php echo $countries; ?>
													</select>
												</div>
											</div>
										</div>
										<div class="form-group">
											<label for="maplink">Map Link</label>
											<div class="row">
												<div class="mixin-col span_11">
													<input type="text" class="form-control" id="maplink" name="maplink" value="<?php echo $maplink; ?>" />
												</div>
											</div>
										</div>
										<div class="form-group">
											<div class="row">
												<div class="mixin-col span_6">
													<label for="lat">Latitude</label>
													<input type="text" class="form-control" id="lat" name="lat" value="<?php echo $lat; ?>" />
												</div>
												<div class="mixin-col span_5">
													<label for="lng">Longitude </label>
													<input type="text" class="form-control" id="lng" name="lng" value="<?php echo $lng; ?>" />
												</div>
											</div>
										</div>
									</section>
								</div>
							</div>
						</div>
					</div>
					<div id="generaltab" class="cb_hm_tabs">
						<div class="row">
							<div class="mixin-col span_11">
								<h3>General Settings</h3>
							</div>
						</div>
						<hr/>
						<div class="row">
							<section class="mixin-col span_6">
								<div class="row">
									<div class="mixin-col span_6">
										<div class="form-group">
											<label for="checkin">Check In Time</label>
											<div class="row">
												<div class="mixin-col span_11">
													<input type="text" class="form-control timepicker" name="checkin" id="checkin" value="<?php echo $checkin; ?>" />
												</div>
											</div>
										</div>
									</div>
									<div class="mixin-col span_6">
										<div class="form-group">
											<label for="checkout">Check Out Time</label>
											<div class="row">
												<div class="mixin-col span_11">
													<input type="text" class="form-control timepicker" name="checkout" id="checkout" value="<?php echo $checkout; ?>" />
												</div>
											</div>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="mixin-col span_6">
										<div class="form-group">
											<label for="min_stay">Minimum Nights</label>
											<div class="row">
												<div class="mixin-col span_11">
													<div class="input-group spinner input-spinner" data-trigger="spinner">
														<input type="text" id="min_stay" name="min_stay" class="form-control" value="<?php echo $min_stay; ?>" data-max="30" data-min="1" data-step="1">
														<div class="input-group-addon">
															<a href="javascript:;" class="spin-up" data-spin="up"><i class="fa fa-angle-up"></i></a>
															<a href="javascript:;" class="spin-down" data-spin="down"><i class="fa fa-angle-down"></i></a>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
									<div class="mixin-col span_6">
										<div class="form-group">
											<label for="max_stay">Maximum Nights</label>
											<div class="row">
												<div class="mixin-col span_11">
													<div class="input-group spinner input-spinner" data-trigger="spinner">
														<input type="text" name="max_stay" id="max_stay" class="form-control" value="<?php echo $max_stay; ?>" data-max="30" data-min="1" data-step="1">
														<div class="input-group-addon">
															<a href="javascript:;" class="spin-up" data-spin="up"><i class="fa fa-angle-up"></i></a>
															<a href="javascript:;" class="spin-down" data-spin="down"><i class="fa fa-angle-down"></i></a>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="mixin-col span_6">
										<div class="form-group">
											<label for="kids_under">Kids Under</label>
											<div class="row">
												<div class="mixin-col span_11">
													<select name="kids_under" id="kids_under" class="form-control">
														<?php foreach($kids as $key=>$value){
															echo '<option value="'.$key.'"';
															echo ($key == $kids_under) ? ' selected="selected">' : '>';
															echo $value.'</option>';
														} ?>
													</select>
												</div>
											</div>
										</div>
									</div>
								</div>
							</section>
							<section class="mixin-col span_6">
								<div class="form-group">
									<label for="timezone">Time Zone</label>
									<div class="row">
										<div class="mixin-col span_11">
											<select name="timezone" id="timezone" class="form-control">
												<?php foreach($timezonelist as $key=>$value){
													echo '<option value="'.$key.'"';
													echo ($key == $timezone) ? ' selected="selected">' : '>';
													echo $value.'</option>';
												} ?>
											</select>
										</div>
									</div>
								</div>
								<div class="form-group">
									<label for="weekend">Your Weekend is</label>
									<div class="row">
										<div class="mixin-col span_11">
											<select name="weekend" id="weekend" class="form-control">
												<?php foreach($weekends as $key=>$value){
													echo '<option value="'.$key.'"';
													echo ($key == $weekend) ? ' selected="selected">' : '>';
													echo $value.'</option>';
												} ?>
											</select>
										</div>
									</div>
								</div>
								<div class="form-group">
									<label for="weekend">VAT Included</label>
									<div class="row">
										<div class="mixin-col span_11">
											<select name="vatincluded" id="include_vat" class="form-control">
												<option value="yes" <?php if($vatincluded == 'yes') echo 'selected="selected"'; ?>>Yes</option>
												<option value="no" <?php if($vatincluded == 'no') echo 'selected="selected"'; ?>>No</option>
											</select>
										</div>
									</div>
								</div>
								<div class="form-group">
									<label for="weekend">VAT( in %)</label>
									<div class="row">
										<div class="mixin-col span_11">
											<input type="text" name="vat" class="form-control" value="<?php $vat; ?>" />
										</div>
									</div>
								</div>
							</section>
						</div>
						<div class="row">
							<div class="mixin-col span_6">
								<label for="payment_currency">Currency</label>
								<div class="row">
									<div class="mixin-col span_3">
										<label for="currency_code">Code</label>
										<input type="text" id="currency_code" name="currency_code" value="<?php echo $currency_code; ?>" class="form-control" />
									</div>
									<div class="mixin-col span_2">
										<label for="payment_currency">Symbol</label>
										<select name="payment_currency" id="payment_currency" class="form-control">
											<option value="&pound;" <?php if($cursym =="£"): ?>selected="selected"<?php endif; ?>>&pound;</option>
											<option value="&dollar;" <?php if($cursym =="$"): ?>selected="selected"<?php endif; ?>>&dollar;</option>
										</select>
									</div>
									<div class="mixin-col span_3">
										<label for="currency_name">Name</label>
										<input type="text" id="currency_name" name="currency_name" value="<?php echo $currency_name; ?>" class="form-control" />
									</div>
									<div class="mixin-col span_3">
										<label for="currency_position">Position</label>
										<select name="currency_position" id="currency_position" class="form-control">
											<option value="before" <?php if($currency_position =="before"): ?>selected="selected"<?php endif; ?>>Before</option>
											<option value="after" <?php if($currency_position =="after"): ?>selected="selected"<?php endif; ?>>After</option>
										</select>
									</div>
								</div>
							</div>
							<div class="mixin-col span_6">
								<label for="amenities">Amenities</label>
								<div class="form-group room_aminities">
									<ul class="clearfix">
										<?php
											foreach ($amenities as $key => $value) {
												echo '<li><input type="checkbox" id="amenity-'.$key.'" name="amenity['.$key.']" value="'.$value.'"';
												if(array_key_exists($key, $amenity))
													echo ' checked="checked" />';
												echo '<label for="amenity-'.$key.'">'.$value.'</label></li>';
											}
										?>
			          				</ul>
								</div>
							</div>
						</div>
					</div>
					<div id="reservationpolicytab" class="cb_hm_tabs">
						<hr/>
						<div class="row">
							<div class="mixin-col span_4">
								<label for="deposit_type">Diposit Type</label>
								<div class="row">
									<div class="mixin-col span_11">
										<select name="deposit_type" id="deposit_type" class="form-control">
											<option value="percent" <?php if($deposit_type =="percent"): ?>selected="selected"<?php endif; ?>>Percent</option>
											<option value="fixed" <?php if($deposit_type =="fixed"): ?>selected="selected"<?php endif; ?>>fixed</option>
										</select>
									</div>
								</div>
							</div>
							<div class="mixin-col span_4">
								<label for="deposit_percent">Diposit Percent</label>
								<div class="row">
									<div class="mixin-col span_11">
										<input type="text" name="deposit_percent" id="deposit_percent" class="form-control" value="<?php $deposit_percent; ?>" />
									</div>
								</div>								
							</div>
							<div class="mixin-col span_4">
								<label for="deposit_fixed">Diposit Fixed</label>
								<div class="row">
									<div class="mixin-col span_11">
										<input type="text" name="deposit_fixed" id="deposit_fixed" class="form-control" value="<?php $deposit_fixed; ?>" />
									</div>
								</div>									
							</div>
						</div><br/>
						<div class="form-group">
							<div class="cf clearfix">
								<div class="mixin-col span_12">
									<label for="custom_cancelllation_policy">Custom Cancelation Policy</label>
									<?php
										$content = $custom_cancelllation_policy;
										$editor_id = 'custom_cancelllation_policy';
										wp_editor( $content, $editor_id, array('textarea_name' => $editor_id, 'textarea_rows' => 8) );
									?>
								</div>
							</div>
						</div>
						<div class="form-group">
							<div class="row">
								<div class="mixin-col span_4">
									<label for="cancellation_policy_allowed">Cancellation Policy Allowed</label>
									<select name="cancellation_policy_allowed" id="cancellation_policy_allowed" class="form-control">
										<option value="yes" <?php if($cancellation_policy_allowed =="yes"): ?>selected="selected"<?php endif; ?>>Yes</option>
										<option value="no" <?php if($cancellation_policy_allowed =="no"): ?>selected="selected"<?php endif; ?>>No</option>
									</select>
								</div>
								<div class="mixin-col span_4">
									<label for="terms_full_charge_allowed">Terms Full Charged Allowed</label>
									<select name="terms_full_charge_allowed" id="terms_full_charge_allowed" class="form-control">
										<option value="yes" <?php if($terms_full_charge_allowed =="yes"): ?>selected="selected"<?php endif; ?>>Yes</option>
										<option value="no" <?php if($terms_full_charge_allowed =="no"): ?>selected="selected"<?php endif; ?>>No</option>
									</select>
								</div>
								<div class="mixin-col span_4">
									<label for="terms_full_charge_cancellation_days">Terms full charge cancellation days</label>
									<input tpye="text" id="terms_full_charge_cancellation_days" name="termsfullchargecancellationdays"  class="form-control" value="<?php echo $termsfullchargecancellationdays; ?>">
								</div>
							</div>
						</div>
						<div class="form-group">
							<div class="row">
								<div class="mixin-col span_3">
									<label for="terms_partial_charge_allowed">Terms partial Charge Allowed</label>
									<select name="terms_partial_charge_allowed" id="terms_partial_charge_allowed" class="form-control">
										<option value="yes" <?php if($terms_partial_charge_allowed =="percent"): ?>selected="selected"<?php endif; ?>>Yes</option>
										<option value="no" <?php if($terms_partial_charge_allowed =="no"): ?>selected="selected"<?php endif; ?>>No</option>
									</select>
								</div>
								<div class="mixin-col span_3">
									<label for="terms_partial_charge_type">Terms partial Charge Allowed</label>
									<select name="terms_partial_charge_type" id="terms_partial_charge_type" class="form-control">
										<option value="percent" <?php if($terms_partial_charge_type =="percent"): ?>selected="selected"<?php endif; ?>>Percent</option>
										<option value="no" <?php if($terms_partial_charge_type =="fixed"): ?>selected="selected"<?php endif; ?>>Fixed</option>
									</select>
								</div>
								<div class="mixin-col span_3">
									<label for="terms_partial_charge_cancellation_days">Terms Partial charge cancellation days</label>
									<input tpye="text" id="terms_partial_charge_cancellation_days" name="terms_partial_charge_cancellation_days"  class="form-control" value="<?php echo $terms_partial_charge_cancellation_days; ?>">
								</div>
								<div class="mixin-col span_3">
									<label for="terms_partial_amount">Terms Partial Amount</label>
									<input tpye="text" id="terms_partial_amount" name="terms_partial_amount"  class="form-control" value="<?php echo $terms_partial_amount; ?>">
								</div>
							</div>
						</div>
						<div class="form-group">
							<div class="row">
								<div class="mixin-col span_3">
									<label for="late_checkout_allowed">Late checkout allowed</label>
									<select name="late_checkout_allowed" id="late_checkout_allowed" class="form-control">
										<option value="yes" <?php if($late_checkout_allowed =="yes"): ?>selected="selected"<?php endif; ?>>Yes</option>
										<option value="no" <?php if($late_checkout_allowed =="no"): ?>selected="selected"<?php endif; ?>>No</option>
									</select>
								</div>
								<div class="mixin-col span_3">
									<div class="form-group">
										<label for="late_checkout_hour">Late Check-Out Hour</label>
										<div class="row">
											<div class="mixin-col span_11">
												<input type="text" class="form-control timepicker" name="late_checkout_hour" id="late_checkout_hour" value="<?php echo $late_checkout_hour; ?>" />
											</div>
										</div>
									</div>
								</div>
								<div class="mixin-col span_3">
									<label for="late_checkout_type">Late checkout type</label>
									<select name="late_checkout_type" id="late_checkout_type" class="form-control">
										<option value="percent" <?php if($late_checkout_type =="percent"): ?>selected="selected"<?php endif; ?>>Percent</option>
										<option value="fixed" <?php if($late_checkout_type =="fixed"): ?>selected="selected"<?php endif; ?>>Fixed</option>
									</select>
								</div>
								<div class="mixin-col span_3">
									<div class="form-group">
										<label for="late_checkout_val">Late Check-Out Fee</label>
										<div class="row">
											<div class="mixin-col span_11">
												<input type="text" class="form-control" name="late_checkout_val" id="late_checkout_val" value="<?php echo $late_checkout_val; ?>" />
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="form-group">
							<div class="row">
								<div class="mixin-col span_11">
									<label for="reservation_policy">Terms and conditions</label>
									<?php
										$content = $reservation_policy;
										$editor_id = 'reservation_policy';
										wp_editor( $content, $editor_id, array('textarea_name' => $editor_id, 'textarea_rows' => 8) );
									?>
								</div>
							</div>
						</div>
					</div>
					<div id="emailstab" class="cb_hm_tabs">
						<h3>Email and Email Template</h3>
						<hr/>
						<div class="row">
							<section class="mixin-col span_6">
								<div class="form-group">
									<label for="sender_name">Sender Name</label>
									<div class="row">
										<div class="mixin-col span_11">
											<input type="text" class="form-control required" id="sender_name" name="sender_name" value="<?php echo $sender_name; ?>" />
										</div>
									</div>
								</div>
								<div class="form-group">
									<label for="sender_email">Sender Email</label>
									<div class="row">
										<div class="mixin-col span_11">
											<input type="email" class="form-control {required:true, email:true}" id="sender_email" name="sender_email" value="<?php echo $sender_email; ?>" />
										</div>
									</div>
								</div>
							</section>
						</div>
						<hr/>
						<div class="row">
							<div class="mixin-col span_3">
								<h3>Mail Subject:</h3>
							</div>
							<div class="mixin-col span_6">
								<input type="text" name="email_subject" class="form-control {required:true}" value="<?php echo $email_subject; ?>" />
							</div>
						</div>
						<div class="row">
							<div class="mixin-col span_3">
								<h3>Message</h3>
							</div>
							<div class="mixin-col span_8">
								<?php
									$content = $email_message;
									$editor_id = 'email_message';
									wp_editor( $content, $editor_id, array('textarea_name' => $editor_id, 'textarea_rows' => 12) );
								?>
							</div>
						</div>
						<h3>Codes</h3>
						<div class="from-group row">
							<div class="mixin-col span_3">
								{{GUESTNAME}}
							</div>
							<div class="mixin-col span_8">
								Guest Name
							</div>
						</div>
						<div class="from-group row">
							<div class="mixin-col span_3">
								{{{RESERVATION-NUMBER}}
							</div>
							<div class="mixin-col span_8">
								Booking Reservation Number
							</div>
						</div>
						<div class="from-group row">
							<div class="mixin-col span_3">
								{{RESERVATION-DETAILS}}
							</div>
							<div class="mixin-col span_8">
								Reservation Details
							</div>
						</div>
					</div>
				</div>
				<hr/>
				<div class="form-group row">
					<div class="pull-right">
						<button type="button" class="btn btn-primary pull-right cb_hm_ajax_submit">Save Changes</button>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>
<script type="text/javascript">(function(o){var b="https://api.autopilothq.com/anywhere/",t="4e62e5bc21ca4bf580e8810fece55398a2d5867fc7c44972995667cd1a647998",a=window.AutopilotAnywhere={_runQueue:[],run:function(){this._runQueue.push(arguments);}},c=encodeURIComponent,s="SCRIPT",d=document,l=d.getElementsByTagName(s)[0],p="t="+c(d.title||"")+"&u="+c(d.location.href||"")+"&r="+c(d.referrer||""),j="text/javascript",z,y;if(!window.Autopilot) window.Autopilot=a;if(o.app) p="devmode=true&"+p;z=function(src,asy){var e=d.createElement(s);e.src=src;e.type=j;e.async=asy;l.parentNode.insertBefore(e,l);};if(!o.noaa){z(b+"aa/"+t,false)};y=function(){z(b+t,true);};if(window.attachEvent){window.attachEvent("onload",y);}else{window.addEventListener("load",y,false);}})({});</script>