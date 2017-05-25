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
 * @template   Edit Room
 */
?>
<?php
	$id = $room->ID;
	$title = $room->post_title;
	$content = $room->post_content;
	$excerpt = $room->post_excerpt;
	$no_rooms = get_post_meta($room->ID, $this->cloudbeds_hotel_management.'_no_rooms', true);
	$max_guest = get_post_meta($room->ID, $this->cloudbeds_hotel_management.'_max_guest', true);
	$max_kids = get_post_meta($room->ID, $this->cloudbeds_hotel_management.'_max_kids', true);
	// $minimumnights = get_post_meta($room->ID, $this->cloudbeds_hotel_management.'_minimumnights', true);
	$room_size = get_post_meta($room->ID, $this->cloudbeds_hotel_management.'_room_size', true);
	$room_images = get_post_meta($room->ID, $this->cloudbeds_hotel_management.'_room_images', true);
	$single = get_post_meta($room->ID, $this->cloudbeds_hotel_management.'_single', true);
	$double = get_post_meta($room->ID, $this->cloudbeds_hotel_management.'_double', true);
	$queen_size = get_post_meta($room->ID, $this->cloudbeds_hotel_management.'_queen_size', true);
	$king_size = get_post_meta($room->ID, $this->cloudbeds_hotel_management.'_king_size', true);
	$amenity = get_post_meta($room->ID, $this->cloudbeds_hotel_management.'_amenity', true);
	$price = get_post_meta($room->ID, $this->cloudbeds_hotel_management.'_price', true);

	if(!empty($room_images)){
		$coverImage = $room_images[0];
		$images = $room_images;
	}else {
		$coverImage = false;
		$images = array();
	}
	if($amenity == ''){
		$amenity = array();
	}

?>
<div class="cb_hm row">
	<h2>Edit Room</h2>
	<div class="container_panel">
		<form id="new_room_type" action="<?php echo admin_url('/admin-ajax.php' ); ?>" onsubmit="return false;">
			<input type="hidden" name="action" value="<?php echo $action; ?>" />
			<input type="hidden" name="wp_nonce" value="<?php echo $nonce; ?>" />
			<input type="hidden" name="room_id" value="<?php echo $id; ?>" />
			<div class="row">
				<div class="mixin-col span_6">
					<div class="form-group">
						<label for="room_name">Title</label>
						<input type="text" class="form-control required" id="room_name" name="title" value="<?php echo $title; ?>" />
					</div>
					<div class="form-group">
						<div class="row">
							<div class="mixin-col span_4">
								<label for="no_rooms">Number of rooms</label>
								<div class="input-group spinner input-spinner" data-trigger="spinner">
									<input type="text" id="no_rooms" name="no_rooms" class="form-control" value="<?php echo $no_rooms; ?>" data-max="30" data-min="0" data-step="1">
									<div class="input-group-addon">
										<a href="javascript:;" class="spin-up" data-spin="up"><i class="fa fa-angle-up"></i></a>
										<a href="javascript:;" class="spin-down" data-spin="down"><i class="fa fa-angle-down"></i></a>
									</div>
								</div>
							</div>
							<div class="mixin-col span_4">
								<label for="guest">Number of Guests</label>
								<div class="input-group spinner input-spinner" data-trigger="spinner">
									<input type="text" id="guest" name="guest" class="form-control" value="<?php echo $guest; ?>" data-max="30" data-min="0" data-step="1">
									<div class="input-group-addon">
										<a href="javascript:;" class="spin-up" data-spin="up"><i class="fa fa-angle-up"></i></a>
										<a href="javascript:;" class="spin-down" data-spin="down"><i class="fa fa-angle-down"></i></a>
									</div>
								</div>
							</div>
							<div class="mixin-col span_4">
								<label for="kids">Number of Kids</label>
								<div class="input-group spinner input-spinner" data-trigger="spinner">
									<input type="text" id="kids" name="kids" class="form-control" value="<?php echo $kids; ?>" data-max="30" data-min="0" data-step="1">
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
								<label for="max_guest">Max Guests</label>
								<div class="input-group spinner input-spinner" data-trigger="spinner">
									<input type="text" id="max_guest" name="max_guest" class="form-control" value="<?php echo $max_guest; ?>" data-max="30" data-min="0" data-step="1">
									<div class="input-group-addon">
										<a href="javascript:;" class="spin-up" data-spin="up"><i class="fa fa-angle-up"></i></a>
										<a href="javascript:;" class="spin-down" data-spin="down"><i class="fa fa-angle-down"></i></a>
									</div>
								</div>
							</div>
							<div class="mixin-col span_4">
								<label for="max_kids">Max Kids</label>
								<div class="input-group spinner input-spinner" data-trigger="spinner">
									<input type="text" id="max_kids" name="max_kids" class="form-control" value="<?php echo $max_kids; ?>" data-max="30" data-min="0" data-step="1">
									<div class="input-group-addon">
										<a href="javascript:;" class="spin-up" data-spin="up"><i class="fa fa-angle-up"></i></a>
										<a href="javascript:;" class="spin-down" data-spin="down"><i class="fa fa-angle-down"></i></a>
									</div>
								</div>
							</div>
							<div class="mixin-col span_4">
								<label for="room_size">Room Size (Ft<sup>2</sup>)</label>
								<div class="input-group spinner input-spinner" data-trigger="spinner">
									<input type="text" id="room_size" name="room_size" class="form-control" value="<?php echo $room_size; ?>" data-max="3000" data-min="0" data-step="1">
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
							<?php if($coverImage){ ?>
								<input type="hidden" class="uploadfield" name="room_images[]" value="<?php echo $coverImage; ?>" />
								<div class="room_img first" style="background-image:url(<?php echo $coverImage; ?>);">
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
										$edittool = '<div class="image_editor_box"> <a href="JavaScript:void(0)" class="<?php echo $this->cloudbeds_hotel_management; ?>_cb_hm_change_image cb_hm_change_image">change</a> <a href="JavaScript:void(0)" class="'.$this->cloudbeds_hotel_management.'_cb_hm_remove_image cb_hm_remove_image"><i class="fa fa-trash"></i></a> </div>';
									}else {
										$image = '';
										$edittool = '<a href="javscript:void(0)" class="'.$this->cloudbeds_hotel_management.'_cb_hm_upload_image_button cb_hm_uploader"></a>';
									} ?>
									<div class="mixin-col span_4 room_images">
										<input type="hidden" class="uploadfield" name="room_images[]" value="<?php echo $image; ?>" />
										<div class="room_img" style="background-image:url(<?php echo $image; ?>);">
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
										<div class="room_img" style="background-image:url(<?php echo $image; ?>);">
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
										<div class="room_img" style="background-image:url(<?php echo $image; ?>);">
											<?php echo $edittool; ?>
										</div>
									</div>
								<?php } ?>
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
								<input type="text" id="single" name="single" class="form-control" value="<?php echo $single; ?>" data-max="30" data-min="0" data-step="1">
								<div class="input-group-addon">
									<a href="javascript:;" class="spin-up" data-spin="up"><i class="fa fa-angle-up"></i></a>
									<a href="javascript:;" class="spin-down" data-spin="down"><i class="fa fa-angle-down"></i></a>
								</div>
							</div>
						</div>
						<div class="mixin-col span_3">
							<label for="double">Double</label>
							<div class="input-group spinner input-spinner" data-trigger="spinner">
								<input type="text" id="double" name="double" class="form-control" value="<?php echo $double; ?>" data-max="30" data-min="0" data-step="1">
								<div class="input-group-addon">
									<a href="javascript:;" class="spin-up" data-spin="up"><i class="fa fa-angle-up"></i></a>
									<a href="javascript:;" class="spin-down" data-spin="down"><i class="fa fa-angle-down"></i></a>
								</div>
							</div>
						</div>
						<div class="mixin-col span_3">
							<label for="queen_size">Queen size</label>
							<div class="input-group spinner input-spinner" data-trigger="spinner">
								<input type="text" id="queen_size" name="queen_size" class="form-control" value="<?php echo $queen_size; ?>" data-max="30" data-min="0" data-step="1">
								<div class="input-group-addon">
									<a href="javascript:;" class="spin-up" data-spin="up"><i class="fa fa-angle-up"></i></a>
									<a href="javascript:;" class="spin-down" data-spin="down"><i class="fa fa-angle-down"></i></a>
								</div>
							</div>
						</div>
						<div class="mixin-col span_3">
							<label for="king_size">King size</label>
							<div class="input-group spinner input-spinner" data-trigger="spinner">
								<input type="text" id="king_size" name="king_size" class="form-control" value="<?php echo $king_size; ?>" data-max="30" data-min="0" data-step="1">
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
							<textarea name="sort-desc" id="sort-desc" rows="5" class="form-control"><?php echo $excerpt; ?></textarea>
						</div>
					</div>
					<div class="form-group">
						<label for="long_desc">Long Description</label>
						<div class="clearfix">
							<?php 
								// $content 	= $post->post_content;
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
					<hr/>
					<h3>Price (without tax)</h3>
					<div class="form-group">
						<input type="text" class="form-control" name="price" value="<?php echo $price; ?>" />
					</div>
				</div>
			</div>
			<hr/>
			<div class="clearfix">
				<div class="pull-right">
					<button class="btn btn-primary cb_hm_ajax_submit pull-right">Save Changes</button>
					<a href="<?php echo admin_url('/admin.php?page=mybookings-rooms' ); ?>" class="btn btn-inverse cb_hm_ajax_submit pull-right">Dicard Changes</a>
				</div>
			</div>
		</form>
	</div>
</div>