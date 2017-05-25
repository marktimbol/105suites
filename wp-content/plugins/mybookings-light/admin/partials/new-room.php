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
 * @template   New Room
 */
?>
<div class="cb_hm row">
	<h2>New Room</h2>
	<div class="container_panel">
		<form id="new_room_type" action="<?php echo admin_url('/admin-ajax.php' ); ?>" onsubmit="return false;">
			<input type="hidden" name="action" value="<?php echo $action; ?>" />
			<input type="hidden" name="wp_nonce" value="<?php echo $nonce; ?>" />
			<div class="row">
				<div class="mixin-col span_6">
					<div class="form-group">
						<label for="room_name">Title</label>
						<input type="text" class="form-control required" id="room_name" name="title" />
					</div>
					<div class="form-group">
						<div class="row">
							<div class="mixin-col span_4">
								<label for="no_rooms">Number of rooms</label>
								<div class="input-group spinner input-spinner" data-trigger="spinner">
									<input type="text" id="no_rooms" name="no_rooms" class="form-control" value="0" data-max="30" data-min="0" data-step="1">
									<div class="input-group-addon">
										<a href="javascript:;" class="spin-up" data-spin="up"><i class="fa fa-angle-up"></i></a>
										<a href="javascript:;" class="spin-down" data-spin="down"><i class="fa fa-angle-down"></i></a>
									</div>
								</div>
							</div>
							<div class="mixin-col span_4">
								<label for="guest">Number of Guests</label>
								<div class="input-group spinner input-spinner" data-trigger="spinner">
									<input type="text" id="guest" name="guest" class="form-control" value="0" data-max="30" data-min="0" data-step="1">
									<div class="input-group-addon">
										<a href="javascript:;" class="spin-up" data-spin="up"><i class="fa fa-angle-up"></i></a>
										<a href="javascript:;" class="spin-down" data-spin="down"><i class="fa fa-angle-down"></i></a>
									</div>
								</div>
							</div>
							<div class="mixin-col span_4">
								<label for="kids">Number of Kids</label>
								<div class="input-group spinner input-spinner" data-trigger="spinner">
									<input type="text" id="kids" name="kids" class="form-control" value="0" data-max="30" data-min="0" data-step="1">
									<div class="input-group-addon">
										<a href="javascript:;" class="spin-up" data-spin="up"><i class="fa fa-angle-up"></i></a>
										<a href="javascript:;" class="spin-down" data-spin="down"><i class="fa fa-angle-down"></i></a>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="form-group">
						<div class="row">
							<div class="mixin-col span_4">
								<label for="max_guest">Allowed Max Guests</label>
								<div class="input-group spinner input-spinner" data-trigger="spinner">
									<input type="text" id="max_guest" name="max_guest" class="form-control" value="0" data-max="30" data-min="0" data-step="1">
									<div class="input-group-addon">
										<a href="javascript:;" class="spin-up" data-spin="up"><i class="fa fa-angle-up"></i></a>
										<a href="javascript:;" class="spin-down" data-spin="down"><i class="fa fa-angle-down"></i></a>
									</div>
								</div>
							</div>
							<div class="mixin-col span_4">
								<label for="max_kids">Allowed Max Kids</label>
								<div class="input-group spinner input-spinner" data-trigger="spinner">
									<input type="text" id="max_kids" name="max_kids" class="form-control" value="0" data-max="30" data-min="0" data-step="1">
									<div class="input-group-addon">
										<a href="javascript:;" class="spin-up" data-spin="up"><i class="fa fa-angle-up"></i></a>
										<a href="javascript:;" class="spin-down" data-spin="down"><i class="fa fa-angle-down"></i></a>
									</div>
								</div>
							</div>
							<div class="mixin-col span_4">
								<label for="room_size">Room Size (Ft<sup>2</sup>)</label>
								<div class="input-group spinner input-spinner" data-trigger="spinner">
									<input type="text" id="room_size" name="room_size" class="form-control" value="0" data-max="3000" data-min="0" data-step="1">
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
					<h3>Pictures</h3>
					<small>We want you to look your best, upload up to 10 photos.</small>
					<div class="row">
						<div class="mixin-col span_5 room_images">
							<input type="hidden" class="uploadfield" name="room_images[]" value="" />
							<div class="room_img first">
								<a href="javscript:void(0)" class="<?php echo $name; ?>_cb_hm_upload_image_button cb_hm_uploader"></a>
							</div>
						</div>
						<div class="mixin-col span_7">
							<div class="row">
								<div class="mixin-col span_4 room_images">
									<input type="hidden" class="uploadfield" name="room_images[]" value="" />
									<div class="room_img">
										<a href="javscript:void(0)" class="<?php echo $name; ?>_cb_hm_upload_image_button cb_hm_uploader"></a>
									</div>
								</div>
								<div class="mixin-col span_4 room_images">
									<input type="hidden" class="uploadfield" name="room_images[]" value="" />
									<div class="room_img">
										<a href="javscript:void(0)" class="<?php echo $name; ?>_cb_hm_upload_image_button cb_hm_uploader"></a>
									</div>
								</div>
								<div class="mixin-col span_4 room_images">
									<input type="hidden" class="uploadfield" name="room_images[]" value="" />
									<div class="room_img">
										<a href="javscript:void(0)" class="<?php echo $name; ?>_cb_hm_upload_image_button cb_hm_uploader"></a>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="mixin-col span_4 room_images">
									<input type="hidden" class="uploadfield" name="room_images[]" value="" />
									<div class="room_img">
										<a href="javscript:void(0)" class="<?php echo $name; ?>_cb_hm_upload_image_button cb_hm_uploader"></a>
									</div>
								</div>
								<div class="mixin-col span_4 room_images">
									<input type="hidden" class="uploadfield" name="room_images[]" value="" />
									<div class="room_img">
										<a href="javscript:void(0)" class="<?php echo $name; ?>_cb_hm_upload_image_button cb_hm_uploader"></a>
									</div>
								</div>
								<div class="mixin-col span_4 room_images">
									<input type="hidden" class="uploadfield" name="room_images[]" value="" />
									<div class="room_img">
										<a href="javscript:void(0)" class="<?php echo $name; ?>_cb_hm_upload_image_button cb_hm_uploader"></a>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="mixin-col span_4 room_images">
									<input type="hidden" class="uploadfield" name="room_images[]" value="" />
									<div class="room_img">
										<a href="javscript:void(0)" class="<?php echo $name; ?>_cb_hm_upload_image_button cb_hm_uploader"></a>
									</div>
								</div>
								<div class="mixin-col span_4 room_images">
									<input type="hidden" class="uploadfield" name="room_images[]" value="" />
									<div class="room_img">
										<a href="javscript:void(0)" class="<?php echo $name; ?>_cb_hm_upload_image_button cb_hm_uploader"></a>
									</div>
								</div>
								<div class="mixin-col span_4 room_images">
									<input type="hidden" class="uploadfield" name="room_images[]" value="" />
									<div class="room_img">
										<a href="javscript:void(0)" class="<?php echo $name; ?>_cb_hm_upload_image_button cb_hm_uploader"></a>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<hr/>
			<div class="row">
				<div class="mixin-col span_6">
					<h3>What Beds Are In This Room?</h3>
					<div class="row">
						<div class="mixin-col span_3">
							<label for="single">Single</label>
							<div class="input-group spinner input-spinner" data-trigger="spinner">
								<input type="text" id="single" name="single" class="form-control" value="0" data-max="30" data-min="0" data-step="1">
								<div class="input-group-addon">
									<a href="javascript:;" class="spin-up" data-spin="up"><i class="fa fa-angle-up"></i></a>
									<a href="javascript:;" class="spin-down" data-spin="down"><i class="fa fa-angle-down"></i></a>
								</div>
							</div>
						</div>
						<div class="mixin-col span_3">
							<label for="double">Double</label>
							<div class="input-group spinner input-spinner" data-trigger="spinner">
								<input type="text" id="double" name="double" class="form-control" value="0" data-max="30" data-min="0" data-step="1">
								<div class="input-group-addon">
									<a href="javascript:;" class="spin-up" data-spin="up"><i class="fa fa-angle-up"></i></a>
									<a href="javascript:;" class="spin-down" data-spin="down"><i class="fa fa-angle-down"></i></a>
								</div>
							</div>
						</div>
						<div class="mixin-col span_3">
							<label for="queen_size">Queen size</label>
							<div class="input-group spinner input-spinner" data-trigger="spinner">
								<input type="text" id="queen_size" name="queen_size" class="form-control" value="0" data-max="30" data-min="0" data-step="1">
								<div class="input-group-addon">
									<a href="javascript:;" class="spin-up" data-spin="up"><i class="fa fa-angle-up"></i></a>
									<a href="javascript:;" class="spin-down" data-spin="down"><i class="fa fa-angle-down"></i></a>
								</div>
							</div>
						</div>
						<div class="mixin-col span_3">
							<label for="king_size">King size</label>
							<div class="input-group spinner input-spinner" data-trigger="spinner">
								<input type="text" id="king_size" name="king_size" class="form-control" value="0" data-max="30" data-min="0" data-step="1">
								<div class="input-group-addon">
									<a href="javascript:;" class="spin-up" data-spin="up"><i class="fa fa-angle-up"></i></a>
									<a href="javascript:;" class="spin-down" data-spin="down"><i class="fa fa-angle-down"></i></a>
								</div>
							</div>
						</div>
					</div>
					<hr/>
					<h3>Room Description</h3>
					<div class="form-group">
						<label for="sort-desc">Short Description</label>
						<div class="clearfix">
							<textarea name="sort-desc" id="sort-desc" rows="5" class="form-control"></textarea>
						</div>
					</div>
					<div class="form-group">
						<label for="long_desc">Long Description</label>
						<div class="clearfix">
							<?php 
								$content 	= '';
								$editor_id 	= 'long_description';
								wp_editor( $content, $editor_id, array('textarea_name' => $editor_id, 'textarea_rows' => 8) );
							?>
						</div>
					</div>
				</div>
				<div class="mixin-col span_6">
					<h3>Room Amenities</h3>
					<div class="form-group room_aminities">
						<ul class="clearfix">
							<li>
								<input type="checkbox" id="amenity-ac" name="amenity['ac']" value="Air Conditioning" />
								<label for="amenity-ac">Air Conditioning</label>
							</li>
							<li>
								<input type="checkbox" id="amenity-internet" name="amenity['internet']" value="Internet (Wi-Fi)" />
								<label for="amenity-internet">Internet (Wi-Fi)</label>
							</li>
							<li>
								<input type="checkbox" id="amenity-telephone" name="amenity['telephone']" value="Telephone" />
								<label for="amenity-telephone">Telephone</label>
							</li>
							<li>
								<input type="checkbox" id="amenity-tv" name="amenity['tv']" value="TV" />
								<label for="amenity-tv">TV</label>
							</li>
							<li>
								<input type="checkbox" id="amenity-safe" name="amenity['safe']" value="Safe" />
								<label for="amenity-safe">Safe</label>
							</li>
							<li>
								<input type="checkbox" id="amenity-minibar" name="amenity['minibar']" value="Minibar" />
								<label for="amenity-minibar">Minibar</label>
							</li>
							<li>
								<input type="checkbox" id="amenity-Kitchen" name="amenity['kitchen']" value="Kitchen" />
								<label for="amenity-Kitchen">Kitchen</label>
							</li>
							<li>
								<input type="checkbox" id="amenity-work-space" name="amenity['work-space']" value="Work Space" />
								<label for="amenity-work-space">Work Space</label>
							</li>
							<li>
								<input type="checkbox" id="amenity-bath" name="amenity['bath']" value="Bath" />
								<label for="amenity-bath">Bath</label>
							</li>
							<li>
								<input type="checkbox" id="amenity-shower" name="amenity['shower']" value="Shower" />
								<label for="amenity-shower">Shower</label>
							</li>
							<li>
								<input type="checkbox" id="amenity-towels" name="amenity['towels']" value="Towels" />
								<label for="amenity-towels">Towels</label>
							</li>
							<li>
								<input type="checkbox" id="amenity-Smoking" name="amenity['smoking']" value="Smoking Allowed" />
								<label for="amenity-Smoking">Smoking Allowed</label>
							</li>
          				</ul>
					</div>
					<hr/>
					<h3>Price (without tax)</h3>
					<div class="form-group">
						<input type="text" class="form-control" name="price" />
					</div>
				</div>
			</div>
			<hr/>
			<div class="clearfix">
				<div class="pull-right">
					<button class="btn btn-primary cb_hm_ajax_submit">Create Room</button>
				</div>
			</div>
		</form>
	</div>
</div>
