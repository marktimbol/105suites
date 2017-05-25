<?php

/**
 *
 * This File Is for Cloudbeds API search Form.
 *
 * @link       https://www.cloudbeds.com
 * @since      0.0.1
 *
 * @package    Cloudbeds_Hotel_Management
 * @subpackage Cloudbeds_Hotel_Management/public/partials
 */
?>
<?php 
//echo $this->is_api_enabled();
 ?>
<div class="cloudbeds_loading cloudbeds_container" id="<?php echo $unique_id; ?>">
	<script type="text/javascript">
		jQuery(document).ready(function($) {  
			<?php 
				if($this->is_api_enabled()) { ?>
					var is_api = 'yes';
				<?php }else { ?>
					var is_api = 'no';
				<?php } ?>
			cloudbedsajax( "<?php echo $unique_id; ?>", "<?php echo $property_id; ?>", "<?php echo $datefrom; ?>", "<?php echo $dateto; ?>", "<?php echo $date_format; ?>", is_api);
		});
	</script>
	<div style="display:none"><?php _e('Loading...', $this->cloudbeds_hotel_management); ?></div>
</div>