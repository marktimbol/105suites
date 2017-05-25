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
 * @template   Rooms
 */
?>

<div class="cb_hm wrap">
	<div class="row">
		<div class="mixin-col span_11">
			<h2>Room Types
				<a href="<?php echo admin_url('/admin.php?page=mybookings-rooms&subpage=new-room' ); ?>" class="add-new-h2 ">Add New Room Type</a>
			</h2>
		</div>
	</div>
	<ul class="clearfix roomList">
		<li>
			<div class="row">
				<div class="mixin-col span_2">
					Cover Image
				</div>
				<div class="mixin-col span_3">
					Name
				</div>
				<div class="mixin-col span_2">
					No. of Rooms
				</div>
				<div class="mixin-col span_2">
					Price
				</div>
				<div class="mixin-col span_3">
					
				</div>
			</div>
		</li>
		<?php
			if($rooms->have_posts()):
				while ($rooms->have_posts()): $rooms->the_post();
					$post = $rooms->post; 
					$post_images = get_post_meta($post->ID, $this->cloudbeds_hotel_management.'_room_images', true );
					if(!empty($post_images)){
						$imageurl = $post_images[0];
					}else {
						$imageurl = '';
					}
					?>
					<li>
						<div class="row">
							<div class="mixin-col span_2">
								<div class="img-thumbnail" style="background-image:url(<?php echo $imageurl; ?>);"></div>
							</div>
							<div class="mixin-col span_3">
								<?php the_title(); ?>
							</div>
							<div class="mixin-col span_2 text-center">
								<strong><?php echo get_post_meta($post->ID, $this->cloudbeds_hotel_management.'_no_rooms', true ); ?></strong>
							</div>
							<div class="mixin-col span_2">
								<?php echo $cursym.''.get_post_meta($post->ID, $this->cloudbeds_hotel_management.'_price', true ); ?>
							</div>
							<div class="mixin-col span_3">
								<a href="<?php echo admin_url('/admin.php?page=mybookings-rooms&subpage=edit-room&room_id='.$post->ID ); ?>" class="btn btn-warning">Edit</a>
							</div>
						</div>
					</li>
				<?php endwhile; 
			endif;
		?>
	</ul>
</div>
