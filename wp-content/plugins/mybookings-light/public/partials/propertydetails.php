<?php


// dump this $hotel variable to see what you have available on your template files - 
// var_export($hotel, true);

?>

<?php

// var_dump($hotel);
/* //
             foreach ($hotel as $key => $value) {
                echo '<p><strong>'.$key.'</strong> : ';
                if(is_array($value)){
                   foreach ($value as $k => $v) {
                     echo '<p><strong>'.$k.'</strong> : ' . $v;
                   }
                }else{
                   var_dump( $value );
                } 
             
                echo '</p>';
             }
// */
?>
<div class="search_panel">
    <div class="center">
        <div class="for_inputs">
            <form id="searchRoomForm" method="POST" onSubmit="return false;">
                <input type="hidden" name="id" value="<?php echo $hotel['id']; ?>">
                <table class="roomsparams omhide">
                    <tr>
                        <td> Rooms :
                            <select name="rooms">
                                <?php
                                $defaultOption = 1;
                                for ($i = 1; $i < 11; $i++) {
                                    $selected = ($i == $defaultOption) ? 'selected' : '';
                                    echo '<option value="' . $i . '" ' . $selected . '> ' . $i . ' </option>';
                                }
                                ?>
                            </select>
                        </td>
                        <td> Adults :
                            <select name="adults">
                                <?php
                                $defaultOption = 1;
                                for ($i = 0; $i < 11; $i++) {
                                    $selected = ($i == $defaultOption) ? 'selected' : '';
                                    echo '<option value="' . $i . '" ' . $selected . '> ' . $i . ' </option>';
                                }
                                ?>
                            </select>
                        </td>
                        <td>Kids :
                            <select name="kids">
                                <?php
                                $defaultOption = 0;
                                for ($i = 0; $i < 11; $i++) {
                                    $selected = ($i == $defaultOption) ? 'selected' : '';
                                    echo '<option value="' . $i . '" ' . $selected . '> ' . $i . ' </option>';
                                }
                                ?>
                            </select>
                        </td>

                    </tr>
                </table>

                <input type="hidden" name="lang" value="en">
                <input type="hidden" name="date_format_DP" value="<?php echo $dateformat; ?>">


                <div class="styled_label">
                    Check-in
                </div>
                <div class="styled_input">
                    <input type="text" placeholder="<?php echo $datefrom; ?>" class="datas ofdate required"
                           name="search_start_date" value="<?php echo $datefrom; ?>"/>
                </div>
                <div class="styled_label">
                    Check-out
                </div>
                <div class="styled_input">
                    <input type="text" placeholder="<?php echo $dateto; ?>" class="datas_end ofdate required"
                           name="search_end_date" value="<?php echo $dateto; ?>"/>
                </div>
    

                <div class="styled_button text_align_right">
                    <input type="submit" value="<?php _e('SEARCH', $this->cloudbeds_hotel_management); ?>" class="cloudbedssearch"/>
                </div>
            </form>
        </div>
    </div>
</div>

<div id="reservationresponse" class=""></div>
<div id="roomsavailability" class=""></div>

<div class="cloudbeds_property_details">
    <div class="property white_bg">
        <div class="propertyTitle cf">
            <h4>
                <span ><?php echo $hotel['name']; ?></span> - <?php _e('Property Information', $this->cloudbeds_hotel_management);?>
            </h4>
        </div>
        <div class="cf plr20">
            <?php echo isset($hotel['description']) ? $hotel['description'] : ''; ?>
        </div>
        <div class="cf">
            <div class="imagmap">
                <a href="javascript:void(0)"><img src="<?php echo $hotel['image']; ?>" alt="" class="img-responsive"/>
                    <span class="popupphotots"><img class="bigger" alt="" src="http://localhost/wordpress4/wp-content/plugins/cloudbeds/assets/images/bigger.png"></span>
                </a>
            </div>
            <div class="map_info">
                <div class="cf"><strong><?php _e('Phone', $this->cloudbeds_hotel_management);?>:</strong> <?php echo $hotel['phone']; ?></div>
                <div class="cf"><strong><?php _e('Email', $this->cloudbeds_hotel_management);?>:</strong> <?php echo $hotel['email']; ?></div>
                <div class="cf"><strong><?php _e('Facebook', $this->cloudbeds_hotel_management);?>:</strong> <?php echo $hotel['facebook']; ?></div>
                <div class="cf">
                    <strong><?php _e('Address', $this->cloudbeds_hotel_management);?>:</strong> <?php echo $hotel['address']['number'] . ' ' . $hotel['address']['street']; ?>
                </div>

                <div class="cf"><strong><?php _e('City', $this->cloudbeds_hotel_management);?>:</strong> <?php echo $hotel['address']['city']; ?></div>
                <div class="cf"><strong><?php _e('State', $this->cloudbeds_hotel_management);?>:</strong> <?php echo $hotel['address']['state']; ?></div>
                <div class="cf"><strong><?php _e('Zip', $this->cloudbeds_hotel_management);?>:</strong> <?php echo $hotel['address']['zip']; ?></div>
                <div class="cf"><strong><?php _e('Country', $this->cloudbeds_hotel_management);?>:</strong> <?php echo $hotel['address']['country']; ?></div>
            </div>
        </div>
        <?php
            // Hotel Additional Photos
            if($hotel['additional_photos']) {
                echo '<div id="hotelImages" class="cb_hidden">';
                foreach ($hotel['additional_photos'] as $image) {
                    echo '<a class="small" href="'.$image.'"></a>';
                }
                echo '</div>';
            }
            // Hotel Map 
            if(isset($hotel['map_link']) && $hotel['map_link'] !=''){
                echo '<div class="cb_map cf">';
                $map = parse_url($hotel['map_link']);
                $resultArray = array();
                $query = $map['query'];
                $data = explode('&', $map['query']);
                foreach ($data as $row) {
                    $result = explode('=', $row);
                    $resultArray[$result[0]] = $result[1];
                }
                $zoom = isset($resultArray['z']) ? $resultArray['z'] : 13;
                $location = explode(',', $resultArray['ll']);
                $lat = $location[0];
                $lng = $location[1];
                // parse_str($map['query'], $params); 
                // $cord = explode(',', $params['ll']);
                $zoom = isset($params['z']) ? $params['z'] : $zoom;
                $lat = isset($hotel['address']['lat']) ? $hotel['address']['lat'] : $lat;
                $lng = isset($hotel['address']['lng']) ? $hotel['address']['lng'] : $lng;
                $infotxt = $hotel['name'].' , '.$hotel['address']['city'];
                if($lat && $lng){
                ?>
                        <div id="gmap_canvas" style="height:300px;width:100%;"></div>

                <?php
                }
                echo '</div>';
            }
        ?>
        <?php if (isset($hotel['amenities']) && $hotel['amenities']): ?>
        <div class="clear"></div>
        <hr class="grey_ll">
        <h6><?php _e('Hotel Amenities', $this->cloudbeds_hotel_management);?></h6>
        <ul class="amenities">
            <?php
            foreach ($hotel['amenities'] as $value) {
                echo '<li>' . $value . '</li>';
            } ?>
        </ul>
        <?php endif; ?>
        <div style="clear:both;"></div>
        <hr class="grey_ll">
        <h6 class="chn"><?php _e('Check-In / Check-Out Policies', $this->cloudbeds_hotel_management);?></h6>

        <p class="checkin"><?php _e('This property has the following check-in and check-out times and policies', $this->cloudbeds_hotel_management);?>.<br><br>
        </p>

        <p class="checkin">
            <span><?php _e('Check-In', $this->cloudbeds_hotel_management);?>: </span> <?php $this->time24to12($hotel['policy']['checkin']); ?></p>

        <p class="checkin">
            <span><?php _e('Check-Out', $this->cloudbeds_hotel_management);?>: </span> <?php $this->time24to12($hotel['policy']['checkout']); ?> </p>

        <p class="checkin">
            <span><?php _e('Late Check-Out Hour', $this->cloudbeds_hotel_management);?>: </span> <?php $this->time24to12($hotel['policy']['late_checkout_hour']); ?></p>

        <p class="checkin">
            <span><?php _e('Late Check-Out Fee', $this->cloudbeds_hotel_management);?>:</span> <?php echo $this->format_currency($hotel['policy']['late_checkout_val']); ?> <br/>

        <p class="checkin">
            <?php echo sprintf(__('Check out after <span>%s</span> will incur late check-outfee above', $this->cloudbeds_hotel_management), $hotel['policy']['late_checkout_hour']);?>

        </p>
        <h6 class="politica"><?php _e('Hotel and Cancellation Policies', $this->cloudbeds_hotel_management);?>:</h6>

        <?php if($hotel['policy']['terms_full_charge_cancellation_days'] && $hotel['policy']['terms_full_charge_allowed'] == 'Y'): ?>
            <p class="pp">
                <?php echo sprintf(__('Full Charge - %s - If cancelled within %s days of arrival', $this->cloudbeds_hotel_management), $hotel['policy']['terms_full_charge_text'], $hotel['policy']['terms_full_charge_cancellation_days']);?>
            </p>
        <?php endif; ?>

        <?php if($hotel['policy']['terms_partial_charge_cancellation_days'] && $hotel['policy']['terms_partial_charge_allowed'] == 'Y'): ?>
            <p class="pp">
                <?php echo sprintf(__('Partial Charge - %s - If cancelled within %s days of arrival', $this->cloudbeds_hotel_management), $hotel['policy']['terms_partial_charge_text'], $hotel['policy']['terms_partial_charge_cancellation_days']);?>
            </p>
        <?php endif; ?>

        <?php if($hotel['policy']['terms_no_charge_cancellation_days'] && $hotel['policy']['terms_no_charge_allowed'] == 'Y'): ?>
            <p class="pp">
                <?php echo sprintf(__('No Charge - If cancelled within %s days of arrival', $this->cloudbeds_hotel_management), $hotel['policy']['terms_no_charge_cancellation_days']);?>
            </p>
        <?php endif; ?>

        <?php if (!empty($hotel['policy']['terms_and_conditions'])) { ?>
            <div class="cf pp">
                <strong><?php _e('Terms and Conditions', $this->cloudbeds_hotel_management);?> :</strong> 
                <div class="cf">
                    <?php echo wpautop($hotel['policy']['terms_and_conditions']); ?>
                </div>
            </div>

        <?php } ?>
        <?php if (!empty($hotel['policy']['tax_percent'])) { ?>
            <p class="pp">
                <strong><?php _e('Tax Percent', $this->cloudbeds_hotel_management);?> :</strong> <?php echo $hotel['policy']['tax_percent']; ?> %
            </p>
        <?php } ?>
        <?php if (!empty($hotel['policy']['deposit_type'])) { ?>

            <p class="pp">
                <strong><?php _e('Deposit Type', $this->cloudbeds_hotel_management);?> :</strong> <?php echo $hotel['policy']['deposit_type']; ?>
            </p>
        <?php } ?>
        <?php if (!empty($hotel['policy']['deposit_percent'])) { ?>

            <p class="pp">
                <strong><?php _e('Deposit Percent', $this->cloudbeds_hotel_management);?> :</strong> <?php echo $hotel['policy']['deposit_percent']; ?>
            </p>
        <?php } ?>
        <?php if (!empty($hotel['policy']['deposit_fixed'])) { ?>

            <p class="pp">
                <strong><?php _e('Deposit Fixed', $this->cloudbeds_hotel_management);?> :</strong> <?php echo $hotel['policy']['deposit_fixed']; ?>
            </p>
        <?php } ?>

        <div class="clear"></div>
        <br/>
    </div>
</div>
<!-- adding map -->
<div id="map_canvas"></div>
<script type="text/javascript">
<?php if($this->is_api_enabled()) { ?>
    jQuery(document).ready(function ($) {
        <?php

            $currency_symbol = $currency['symbol'];
            $currency_position = $currency['position'];
            date_default_timezone_set('UTC');
            setlocale(LC_MONETARY, 'en_US');
        ?>
        var minDate = new Date(<?php echo date('Y'); ?>, <?php echo date('n'); ?>, <?php echo date('j'); ?>, 0, 0, 0, 0);
        var adults = 1;
        var kids = 0;
        var start_date = "<?php echo date($dateformat);?>";
        var end_date = "<?php echo date($dateformat, strtotime('tomorrow'));?>";
        var fb_app = "443263065747242";
        var boletoDate = '2014/04/01';
        var eBankingDate = '2014/03/20';
        var disabled_msg = '<?php _e("This hotel is not currently accepting reservations. Please check back shortly.", $this->cloudbeds_hotel_management); ?>';
        var no_rooms_msg = '<?php _e("We&#96;re sorry but there are no available rooms for your selected dates -- please modify your dates above to search again. We also encourage you to contact the hotel for more information at", $this->cloudbeds_hotel_management); echo $hotel["phone"]; ?>';
        var not_enough_rooms_msg = '<?php _e("We&#96;re sorry but we could not accomodate your request. Please change your selected dates or choose a fewer number of rooms. We also encourage you to contact the hotel for more information at", $this->cloudbeds_hotel_management); echo $hotel["phone"]; ?>';
        var no_rooms_selected_msg = '<?php _e("No Rooms added to cart.", $this->cloudbeds_hotel_management); ?>';
        var boletoDateError = '<?php _e("Only bookings over 14 days in advance can be paid with payment slip.", $this->cloudbeds_hotel_management); ?>';
        var eBankingDateError = '<?php _e("Only bookings over 2 days in advance can be paid with eBanking.", $this->cloudbeds_hotel_management); ?>';
        var ct = null;
        var roomCount = 0;
        var cartCount = 0;
        var deposit_type = <?php echo isset($hotel['policy']['deposit_type']) ? $hotel['policy']['deposit_type'] : 0; ?>;
        var deposit_fixed = <?php echo isset($hotel['policy']['deposit_fixed']) ? $hotel['policy']['deposit_fixed'] : 0; ?>;
        var deposit_pct = <?php echo isset($hotel['policy']['deposit_percent']) ? $hotel['policy']['deposit_percent'] : 0; ?>;
        var taxes = 0;
        var taxes_included = 'Y'
        var included_taxes_type = 'percent';
        var terms_tax_percent = <?php echo isset($hotel['policy']['tax_percent']) ? $hotel['policy']['tax_percent'] : 0; ?>;
        var terms_tax_fixed = 0;
        var fees_included = 'Y';
        var fees_included_type = 'percent';
        var fees_percent = 0;
        var fees_fixed = 0;
        var latitude = "<?php echo $hotel['address']['lat'];?>";
        var longitude = "<?php echo $hotel['address']['lng'];?>";
        var hotel_name = "<?php echo $hotel['name'];?>";
        var fb = false;
        var country = 'BR';
        var is_api = 'yes';

        var newRoom = '<tr class="room_type_row" data-id="{%room_type_id%}" data-val="{%room_type_total_rate%}" ' + 'data-add-adults="{%room_type_adult_rate%}" data-add-kids="{%room_type_child_rate%}" ' + 'data-adults="{%adults_inBasePrice%}" data-kids="{%children_inBasePrice%}" ' + 'data-max="{%max_guests_count%}" data-name="{%room_type_name%}" data-package="{%package_id%}">' + '<td class="pphoto">' + '<div class="cb_hm_container">' + '<div class="room_photo">' + '<div style="background-image:url(\'{%featured_photo%}\')">' + '<img class="bigger" alt="" src="/assets/booking/images/bigger.png">' + '</div>' + '</div>' + '</div>' + '</td>' + '<td class="room_type">' + '<div class="room_name_container">{%popup_info%}' + '<p class="name_room for_plus">{%room_type_name%}</p>' + '</div><div style="clear:both;"></div>' + '</td>' + '<td class="aver_price"><div class="avg_rate_container">{%detailed_rates_popup%}' + '<span class="avg_rate">{%room_type_min_rate%}</span></div></td>' + '<td class="for_22">{%room_type_total_rate%}<p class="only_left {%hide_class%}">only {%room_type_only_left%} left</p></td>' + '<td class="max">{%max_guests%}</td>' + '<td class="no_rooms">' + '<div class="styled_select">' + '<select name="adults[{%room_type_id%}]" class="required">{%adults_count%}</select>' + '</div>' + '</td>' + '<td class="no_rooms">' + '<div class="styled_select">' + '<select name="kids[{%room_type_id%}]" class="required">{%kids_count%}</select>' + '</div>' + '</td>' + '<td class="no_rooms">' + '<div class="styled_select">' + '<select data-max_rooms="{%max-count-rooms%}" name="qty_rooms[{%room_type_id%}]" class="required">{%room_count%}</select>' + '</div>' + '</td>' + '</tr>';
        var newPopup = '<div class="stay hide">' + '<table>' + '<tbody>' + '<tr class="padding-top-9">' + '<td class="min_stay">Minimum Stay</td>' + '<td class="nights">{%nights%} Nights</td>' + '</tr>' + '<tr>' + '<td class="min_stay">Included Occupancy</td>' + '<td class="nights">{%included_occupancy%} People</td>' + '</tr>' + '<tr class="padding-bottom-14">' + '<td class="min_stay">Maximum Occupancy</td>' + '<td class="nights">{%maximum_occupancy%} People</td>' + '</tr>' + '</tbody>' + '</table>' + '<div  class="stay_bg"></div>' + '</div>';
        var newDetailedRatesPopup = '<div class="stay detailed_rates hide" style="margin-top:-{%rates_top%}px">' + '<table>' + '<tbody>' + '{%rates_content%}' + '</tbody>' + '</table>' + '<div  class="stay_bg"></div>' + '</div>';
        var newDetails = '<tr class="info_about_rooms hide">' + '<td colspan="8">' + '<div class="hide room_details_container">' + '<p class="tarifa_basic">Basic rate: {%room_type_total_rate%} (including {%adults_inBasePrice%} adults and {%children_inBasePrice%} children)</p>' + '<p class="tarifa">Additional adult: {%room_type_adult_rate%} | Child: {%room_type_child_rate%}</p>' + '<div class="white_share"></div>' + '<div>' + '<ul class="room_type_tabs">' + '<li>&nbsp;</li>' + '<li class="active">Description</li>' + '<li class="amenities_tab">Amenities</li>' + '<li>Photos</li>' + '<li>&nbsp;</li>' + '</ul>' + '<div class="tab_info2">' + '<div class="active">{%room_type_desc%}</div>' + '<div class="amenities_tab">' + '<ul>{%room_type_features%}</ul>' + '<div style="clear:both;"></div>' + '</div>' + '<div>{%other_photos%}</div>' + '</div>' + '</div>' + '</div>' + '</td>' + '</tr>';
        var newDetailsPackage = '<tr class="info_about_rooms hide">' + '<td colspan="8">' + '<div class="hide room_details_container">' + '<p class="tarifa_basic">Basic rate: {%room_type_total_rate%} (including {%adults_inBasePrice%} adults and {%children_inBasePrice%} children)</p>' + '<p class="tarifa">Additional adult: {%room_type_adult_rate%} | Child: {%room_type_child_rate%}</p>' + '<div class="white_share"></div>' + '<div>' + '<ul class="room_type_tabs package_tab">' + '<li>&nbsp;</li>' + '<li class="active">Package Details</li>' + '<li class="amenities_tab">Amenities</li>' + '<li>Photos</li>' + '<li>Description</li>' + '<li>&nbsp;</li>' + '</ul>' + '<div class="tab_info2">' + '<div class="active">' + '<img src="{%package_src%}" alt="" style="height: 91px;" class="package_img">' + '<div class="package_descr">' + '<p>{%package_desc%}</p>' + '<a href="#" class="package_terms">Terms & Conditions</a>' + '<div style="display: none;"><p>{%package_terms%}</p></div> ' + '</div>' + '<div style="clear: both;"></div>' + '</div>' + '<div class="amenities_tab">' + '<ul>{%room_type_features%}</ul>' + '<div style="clear:both;"></div>' + '</div>' + '<div>{%other_photos%}</div>' + '<div>{%room_type_desc%}</div>' + '</div>' + '</div>' + '</div>' + '</td>' + '</tr>';
        var newBookingRoom = '<p class="short_info2">{%name%} (x {%selected%}) <br />' + ' <span class="bold">Adults:</span>{%adults%}, ' + ' <span class="bold">Kids:</span>{%kids%}</p>';
        var searchform = jQuery('#searchRoomForm');
        <?php

        $jsdateformat = 'mm/dd/yy';
        switch ($dateformat) {
            case 'd/m/Y':
                $jsdateformat = 'dd/mm/yy';
                break;

            default:
                # code...
                break;
        }
        ?>

        OMBooking.init({
            "rooms": "\/booking\/rooms",
            "prepare": "\/booking\/prepare",
            "done": "\/booking\/done"
        }, minDate, {
            "name": "english",
            "native": "English",
            "date_format": "<?php echo $jsdateformat;?>",
            "currency_symbol": "<?php echo $currency_symbol; ?>",
            "currency_position": "<?php echo $currency_position; ?>",
            "mon_decimal_point": ".",
            "mon_thousands_sep": ",",
            "date_format_full": "l, F j, Y",
            "time_format": "h:i A",
            "month_first": true,
            "phone": "(999) 999-9999",
            "locale": "en_US",
            "date_format_wy": "m\/d",
            "default_language": "en",
            "default_timezone": "UTC",
            "default_timezone_offset": 0
        }, adults, kids, start_date, end_date, fb_app, boletoDate, eBankingDate, disabled_msg, no_rooms_msg, not_enough_rooms_msg, no_rooms_selected_msg, boletoDateError, eBankingDateError, ct, roomCount, cartCount, deposit_type, deposit_pct, deposit_fixed, taxes, latitude, longitude, hotel_name, fb, country, taxes_included, included_taxes_type, terms_tax_percent, terms_tax_fixed, fees_included, fees_included_type, fees_percent, fees_fixed, newRoom, newPopup, newDetailedRatesPopup, newDetails, newDetailsPackage, newBookingRoom, searchform);

        // requestGetAvailability();
        jQuery("#hotelImages").magnificPopup({

            delegate: 'a', // the selector for gallery item

            type: 'image',

            gallery: {

              enabled:true

            }

        });
        jQuery(document).on('click', '.imagmap a', function(e){
            e.preventDefault();
            jQuery('#hotelImages a:eq(0)').trigger('click');
        });
    });
<?php }else { ?>

    jQuery(document).ready(function ($) {
        <?php
            $currency_symbol = $this->cb_hm_options('_payment_currency', '$');
            $currency_position = $this->cb_hm_options('_currency_position', 'before');
            date_default_timezone_set('UTC');
            setlocale(LC_MONETARY, 'en_US');
        ?>
        var minDate = new Date(<?php echo date('Y'); ?>, <?php echo date('n'); ?>, <?php echo date('j'); ?>, 0, 0, 0, 0);
        var adults = 1;
        var kids = 0;
        var start_date = "<?php echo date($dateformat);?>";
        var end_date = "<?php echo date($dateformat, strtotime('tomorrow'));?>";
        var fb_app = "443263065747242";
        var boletoDate = '2014/04/01';
        var eBankingDate = '2014/03/20';
        var disabled_msg = '<?php _e("This hotel is not currently accepting reservations. Please check back shortly.", $this->cloudbeds_hotel_management); ?>';
        var no_rooms_msg = '<?php _e("We&#96;re sorry but there are no available rooms for your selected dates -- please modify your dates above to search again. We also encourage you to contact the hotel for more information at", $this->cloudbeds_hotel_management); echo $hotel["phone"]; ?>';
        var not_enough_rooms_msg = '<?php _e("We&#96;re sorry but we could not accomodate your request. Please change your selected dates or choose a fewer number of rooms. We also encourage you to contact the hotel for more information at", $this->cloudbeds_hotel_management); echo $hotel["phone"]; ?>';
        var no_rooms_selected_msg = '<?php _e("No Rooms added to cart.", $this->cloudbeds_hotel_management); ?>';
        var boletoDateError = '<?php _e("Only bookings over 14 days in advance can be paid with payment slip.", $this->cloudbeds_hotel_management); ?>';
        var eBankingDateError = '<?php _e("Only bookings over 2 days in advance can be paid with eBanking.", $this->cloudbeds_hotel_management); ?>';
        var ct = null;
        var roomCount = 0;
        var cartCount = 0;
        var deposit_type = "";
        var deposit_fixed = "";
        var deposit_pct = 0;
        var taxes = <?php echo (float)$this->cb_hm_options( '_vat', '15', false ); ?>;
        <?php 
            $taxes_included = $this->cb_hm_options( '_vatincluded', 'yes', false );
        ?>
        <?php if($taxes_included == 'yes'){ ?>
            var taxes_included = 'Y';
        <?php }else{ ?>
            var taxes_included = 'N';
        <?php } ?>
        var included_taxes_type = 'percent';
        var terms_tax_percent = <?php echo (float)$this->cb_hm_options( '_vat', '15', false ); ?> / 100;
        var terms_tax_fixed = 0;
        var fees_included = 'N';
        var fees_included_type = 'percent';
        var fees_percent = 0;
        var fees_fixed = 0;
        var latitude = "<?php echo $lat;?>";
        var longitude = "<?php echo $lng;?>";
        var hotel_name = "<?php echo $hotel['name'];?>";
        var fb = false;
        var country = "<?php echo $hotel['address']['country'];?>";
        var is_api = 'no';

        var newRoom = '<tr class="room_type_row" data-id="{%room_type_id%}" data-val="{%room_type_total_rate%}" ' + 'data-add-adults="{%room_type_adult_rate%}" data-add-kids="{%room_type_child_rate%}" ' + 'data-adults="{%adults_inBasePrice%}" data-kids="{%children_inBasePrice%}" ' + 'data-max="{%max_guests_count%}" data-name="{%room_type_name%}" data-package="{%package_id%}">' + '<td class="pphoto">' + '<div class="cb_hm_container">' + '<div class="room_photo">' + '<div style="background-image:url(\'{%featured_photo%}\')">' + '<img class="bigger" alt="" src="/assets/booking/images/bigger.png">' + '</div>' + '</div>' + '</div>' + '</td>' + '<td class="room_type">' + '<div class="room_name_container">{%popup_info%}' + '<p class="name_room for_plus">{%room_type_name%}</p>' + '</div><div style="clear:both;"></div>' + '</td>' + '<td class="aver_price"><div class="avg_rate_container">{%detailed_rates_popup%}' + '<span class="avg_rate">{%room_type_min_rate%}</span></div></td>' + '<td class="for_22">{%room_type_total_rate%}<p class="only_left {%hide_class%}">only {%room_type_only_left%} left</p></td>' + '<td class="max">{%max_guests%}</td>' + '<td class="no_rooms">' + '<div class="styled_select">' + '<select name="adults[{%room_type_id%}]" class="required">{%adults_count%}</select>' + '</div>' + '</td>' + '<td class="no_rooms">' + '<div class="styled_select">' + '<select name="kids[{%room_type_id%}]" class="required">{%kids_count%}</select>' + '</div>' + '</td>' + '<td class="no_rooms">' + '<div class="styled_select">' + '<select data-max_rooms="{%max-count-rooms%}" name="qty_rooms[{%room_type_id%}]" class="required">{%room_count%}</select>' + '</div>' + '</td>' + '</tr>';
        var newPopup = '<div class="stay hide">' + '<table>' + '<tbody>' + '<tr class="padding-top-9">' + '<td class="min_stay">Minimum Stay</td>' + '<td class="nights">{%nights%} Nights</td>' + '</tr>' + '<tr>' + '<td class="min_stay">Included Occupancy</td>' + '<td class="nights">{%included_occupancy%} People</td>' + '</tr>' + '<tr class="padding-bottom-14">' + '<td class="min_stay">Maximum Occupancy</td>' + '<td class="nights">{%maximum_occupancy%} People</td>' + '</tr>' + '</tbody>' + '</table>' + '<div  class="stay_bg"></div>' + '</div>';
        var newDetailedRatesPopup = '<div class="stay detailed_rates hide" style="margin-top:-{%rates_top%}px">' + '<table>' + '<tbody>' + '{%rates_content%}' + '</tbody>' + '</table>' + '<div  class="stay_bg"></div>' + '</div>';
        var newDetails = '<tr class="info_about_rooms hide">' + '<td colspan="8">' + '<div class="hide room_details_container">' + '<p class="tarifa_basic">Basic rate: {%room_type_total_rate%} (including {%adults_inBasePrice%} adults and {%children_inBasePrice%} children)</p>' + '<p class="tarifa">Additional adult: {%room_type_adult_rate%} | Child: {%room_type_child_rate%}</p>' + '<div class="white_share"></div>' + '<div>' + '<ul class="room_type_tabs">' + '<li>&nbsp;</li>' + '<li class="active">Description</li>' + '<li class="amenities_tab">Amenities</li>' + '<li>Photos</li>' + '<li>&nbsp;</li>' + '</ul>' + '<div class="tab_info2">' + '<div class="active">{%room_type_desc%}</div>' + '<div class="amenities_tab">' + '<ul>{%room_type_features%}</ul>' + '<div style="clear:both;"></div>' + '</div>' + '<div>{%other_photos%}</div>' + '</div>' + '</div>' + '</div>' + '</td>' + '</tr>';
        var newDetailsPackage = '<tr class="info_about_rooms hide">' + '<td colspan="8">' + '<div class="hide room_details_container">' + '<p class="tarifa_basic">Basic rate: {%room_type_total_rate%} (including {%adults_inBasePrice%} adults and {%children_inBasePrice%} children)</p>' + '<p class="tarifa">Additional adult: {%room_type_adult_rate%} | Child: {%room_type_child_rate%}</p>' + '<div class="white_share"></div>' + '<div>' + '<ul class="room_type_tabs package_tab">' + '<li>&nbsp;</li>' + '<li class="active">Package Details</li>' + '<li class="amenities_tab">Amenities</li>' + '<li>Photos</li>' + '<li>Description</li>' + '<li>&nbsp;</li>' + '</ul>' + '<div class="tab_info2">' + '<div class="active">' + '<img src="{%package_src%}" alt="" style="height: 91px;" class="package_img">' + '<div class="package_descr">' + '<p>{%package_desc%}</p>' + '<a href="#" class="package_terms">Terms & Conditions</a>' + '<div style="display: none;"><p>{%package_terms%}</p></div> ' + '</div>' + '<div style="clear: both;"></div>' + '</div>' + '<div class="amenities_tab">' + '<ul>{%room_type_features%}</ul>' + '<div style="clear:both;"></div>' + '</div>' + '<div>{%other_photos%}</div>' + '<div>{%room_type_desc%}</div>' + '</div>' + '</div>' + '</div>' + '</td>' + '</tr>';
        var newBookingRoom = '<p class="short_info2">{%name%} (x {%selected%}) <br />' + ' <span class="bold">Adults:</span>{%adults%}, ' + ' <span class="bold">Kids:</span>{%kids%}</p>';
        var searchform = jQuery('#searchRoomForm');
        <?php

        $jsdateformat = 'm/d/Y';
        switch ($dateformat) {
            case 'd/m/Y':
                $jsdateformat = 'd/m/Y';
                break;

            default:
                # code...
                break;
        }
        ?>

        OMBooking.init({
            "rooms": "\/booking\/rooms",
            "prepare": "\/booking\/prepare",
            "done": "\/booking\/done"
        }, minDate, {
            "name": "english",
            "native": "English",
            "date_format": "<?php echo $jsdateformat;?>",
            "currency_symbol": "<?php echo $currency_symbol; ?>",
            "currency_position": "<?php echo $currency_position; ?>",
            "mon_decimal_point": ".",
            "mon_thousands_sep": ",",
            "date_format_full": "l, F j, Y",
            "time_format": "h:i A",
            "month_first": true,
            "phone": "(999) 999-9999",
            "locale": "en_US",
            "date_format_wy": "m\/d",
            "default_language": "en",
            "default_timezone": "UTC",
            "default_timezone_offset": 0
        }, adults, kids, start_date, end_date, fb_app, boletoDate, eBankingDate, disabled_msg, no_rooms_msg, not_enough_rooms_msg, no_rooms_selected_msg, boletoDateError, eBankingDateError, ct, roomCount, cartCount, deposit_type, deposit_pct, deposit_fixed, taxes, latitude, longitude, hotel_name, fb, country, taxes_included, included_taxes_type, terms_tax_percent, terms_tax_fixed, fees_included, fees_included_type, fees_percent, fees_fixed, newRoom, newPopup, newDetailedRatesPopup, newDetails, newDetailsPackage, newBookingRoom, searchform, is_api);

        // requestGetAvailability();
        jQuery("#hotelImages").magnificPopup({

            delegate: 'a', // the selector for gallery item

            type: 'image',

            gallery: {

              enabled:true

            }

        });
        jQuery(document).on('click', '.imagmap a', function(e){
            e.preventDefault();
            jQuery('#hotelImages a:eq(0)').trigger('click');
        });
    });

<?php } ?>
</script> 
<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false&callback=initialize" ></script>
<script type="text/javascript">
    var map;
    var global_markers = [];
    // var infowindow = new google.maps.InfoWindow({});
    function initialize(){
        // var infowindow = new google.maps.InfoWindow({});
        if(jQuery("#gmap_canvas").length){
            initialize_shows(<?php echo $lat; ?>, <?php echo $lng; ?>, [[<?php echo $lat; ?>, <?php echo $lng; ?>, "<?php echo $infotxt; ?>"]], 'gmap_canvas', <?php echo $zoom; ?>, 'false');
        }
    }
    function initialize_map_show(lat, lng) {
        var latlng = new google.maps.LatLng(lat, lng);
        var myOptions = {
            zoom: 1,
            center: latlng,
            scrollwheel:false,
            mapTypeId: google.maps.MapTypeId.ROADMAP
        }
        map = new google.maps.Map(document.getElementById("gmap_canvas"), myOptions);
    }

    function initialize_shows(latt, long, markers, placeholder, zoomlabel, mapbounds) {
        if(!placeholder || placeholder == '') {var placeholder = 'gmap_canvas'}
        if(!zoomlabel || zoomlabel == '') {var zoomlabel = 10}
        if(!mapbounds || mapbounds == '') {var mapbounds = 'true'}
        else { var placeholder = placeholder;}
        geocoder = new google.maps.Geocoder();
        var latlng = new google.maps.LatLng(latt, long);
        var myOptions = {
            zoom: zoomlabel,
            center: latlng,
            mapTypeControl: true,
            navigationControl: true,
            scaleControl: false,
            scrollwheel:false,
            mapTypeId: google.maps.MapTypeId.ROADMAP
        }
        var bounds = new google.maps.LatLngBounds();
        map = new google.maps.Map(document.getElementById(placeholder), myOptions);
        addMarker(markers, bounds, mapbounds);
    }

    function addMarker(markers, bounds, mapbounds) {
        var infowindow = new google.maps.InfoWindow({});
        for (var i = 0; i < markers.length; i++) {
            // obtain the attribues of each marker
            var lat = parseFloat(markers[i][0]);
            var lng = parseFloat(markers[i][1]);
            var trailhead_name = markers[i][2];
            var myLatlng = new google.maps.LatLng(lat, lng);
            var contentString = jQuery("<div />").html(trailhead_name).text();
            bounds.extend(myLatlng);
            // var image = '<?php echo get_template_directory_uri(); ?>/assets/images/favicon-tvc.png';
            var titletxt = jQuery(contentString).text();
            var marker = new google.maps.Marker({
                position: myLatlng,
                map: map,
                // icon: image,
                title: ''
            });

            // marker['infowindow'] = "<?php echo $hotel['name']; ?><br/><?php echo $hotel['address']['city']; ?>";

            // global_markers[i] = marker;

            // infowindow = new google.maps.InfoWindow({
            //     content: "<?php echo $hotel['name']; ?><br/><?php echo $hotel['address']['city']; ?>"
            // });
            // google.maps.event.addListener(marker, "click", function() {
            //     infowindow.open(map, marker);
            // });
            // infowindow.open(map, marker);

            marker['infowindow'] = contentString;

            global_markers[i] = marker;

            google.maps.event.addListener(global_markers[i], 'click', function() {
                // console.log(infowindow);
                infowindow.setContent(this['infowindow']);
                infowindow.open(map, this);
            });
        }
        if(mapbounds == 'true'){
            map.fitBounds(bounds);  
        }
    }
</script>