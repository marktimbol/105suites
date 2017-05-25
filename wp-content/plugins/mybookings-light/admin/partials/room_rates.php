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
 * @template   Room Rates
 */
?>
<div id="cb-hm-roomrate-panel" class="cb_hm wrap">
	<div class="container_panel">
		<h2>Set Long-Term Data</h2>
		<form action="">
			<input type="hidden" name="action" value="<?php echo $this->cloudbeds_hotel_management;?>_save_bulk_changes" />
			<input type="hidden" name="setfor" value="availability" />
			<div class="cf">
				<div class="row">
					<div class="mixin-col span_4">
		                <div class="form-group">
		                    <label class="control-label">Room</label>
		                    <div class="controls">
		                    	<select name="roomid" class="form-control">
		                            <?php foreach ($rooms as $key => $room) {
		                            	echo '<option value="'.$room['id'].'">'.$room['title'].'</option>';
		                            } ?>
		                        </select>
		                    </div>
		                </div>
		            </div>
		            <div class="mixin-col span_4">
		                <div class="form-group">
		                    <label class="control-label">Start Date</label>
		                    <div class="controls">
		                    	<input type="text" id="datefrom" name="from" class="form-control" />
		                    </div>
		                </div>
		            </div>
		            <div class="mixin-col span_4">
		                <div class="form-group">
		                    <label class="control-label">End Date</label>
		                    <div class="controls">
		                        <input type="text" id="dateto" name="to" class="form-control" />
		                    </div>
		                </div>
		            </div>
		        </div>
		        <div class="row">
		        	<div class="mixin-col span_6">
		                <div class="form-group weekday-checkbox">
		                    <label class="control-label">Weekdays</label>
		                    <div class="controls">
		                        <label class="checkbox">
		                            <input type="checkbox" name="weekday[]" value="Mon" checked="">Monday
		                        </label>
		                        <label class="checkbox">
		                            <input type="checkbox" name="weekday[]" value="Tue" checked="">Tuesday</label>
		                        <label class="checkbox">
		                            <input type="checkbox" name="weekday[]" value="Wed" checked="">Wednesday</label>
		                        <label class="checkbox">
		                            <input type="checkbox" name="weekday[]" value="Thu" checked="">Thursday</label>
		                        <label class="checkbox">
		                            <input type="checkbox" name="weekday[]" value="Fri" checked="">Friday</label>
		                        <label class="checkbox">
		                            <input type="checkbox" name="weekday[]" value="Sat" checked="">Saturday</label>
		                        <label class="checkbox">
		                            <input type="checkbox" name="weekday[]" value="Sun" checked="">Sunday</label>
		                    </div>
		                </div>
		           	</div>
		           	<div class="mixin-col span_6">
						<div class="row">
							<div class="mixin-col span_3">
								<div class="form-group">
			                    	<label class="control-label">Availability</label>
			                    	<div class="controls">
										<input type="number" name="availability" placeholder="0" class="form-control" />
			                    	</div>
			                   	</div>
			                   	<div class="form-group">
			                    	<button class="btn btn-primary saveLongTerm" data-set="availability">Set Availability</button>
			                   	</div>
			                </div>
			                <div class="mixin-col span_3">
								<div class="form-group">
			                    	<label class="control-label">Rate</label>
			                    	<div class="controls">
										<input type="number" name="rate" placeholder="0" class="form-control" />
			                    	</div>
			                   	</div>
			                   	<div class="form-group">
			                    	<button class="btn btn-primary saveLongTerm" data-set="rate">Set Rate</button>
			                   	</div>
			                </div>
			                <div class="mixin-col span_3">
								<div class="form-group">
			                    	<label class="control-label">Minimum Stay</label>
			                    	<div class="controls">
										<input type="number" name="min_stay" placeholder="0" class="form-control" />
			                    	</div>
			                   	</div>
			                   	<div class="form-group">
			                    	<button class="btn btn-primary saveLongTerm" data-set="min_stay">Set Min Stay</button>
			                   	</div>
		                	</div>
		                	<div class="mixin-col span_3">
								<div class="form-group">
			                    	<label class="control-label">Closed</label>
			                    	<div class="controls">
										<input type="checkbox" name="close" placeholder="0" value="1" />
			                    	</div>
			                   	</div>		
			                   	<div class="form-group">
			                    	<button class="btn btn-primary saveLongTerm" data-set="close">Set Close</button>
			                   	</div>			
							</div>
						</div>
		           	</div>
		        </div>
	        </div>
		</form>
		<hr/>
		<form id="rate_table-form" action="">
			<div class="ratepanel">
				<div class="row">
					<div class="mixin-col span_4">
						<span class="dbutton">
							<input type="hidden" class="pickdate" />
						</span>
					</div>
					<button class="btn btn-danger saverateChanges pull-right" type="button">Save Changes</button>
				</div>
			</div>
			<br/>
			<div class="rate-calender">
				<input type="hidden" name="action" value="<?php echo $this->cloudbeds_hotel_management;?>_save_rate_changes" />
				<input type="hidden" name="from" value="" />
				<input type="hidden" name="to" value="" />
				<table id="rate-table" class="rate-table table table-condensed"> 

				</table>
			</div>
		</form>
	</div>
</div>