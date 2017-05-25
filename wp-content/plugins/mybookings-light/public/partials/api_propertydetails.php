<div class="search_panel api_search_panel">
    <div class="omgrid_3 omgrid_x12">
        <?php if($hotel['propertyAdditionalPhotos']) {
            echo '<ul id="hotel_gallery" class="cS-hidden">';
            if($hotel['propertyImage']){
                echo '<li><a class="small magnific" href="'.$hotel['propertyImage'][0]['image'].'" style="background-image:url('.$hotel['propertyImage'][0]['thumb'].');"></a></li>';
            }
            foreach ($hotel['propertyAdditionalPhotos'] as $image) {
                echo '<li><a href="'.$image['image'].'" style="background-image:url('.$image['thumb'].');"></a></li>';
            }
            echo '</ul>';
        }elseif($hotel['propertyImage']){
            echo '<div id="hotelPropertyImage"><a class="small magnific" href="'.$hotel['propertyImage'][0]['image'].'"><img src="'.$hotel['propertyImage'][0]['thumb'].'" alt="" /></a></div>';
        } ?>
    </div>
    <div class="omgrid_9 omgrid_x12">
        <form id="searchRoomForm" method="POST" onSubmit="return false;">
            <input type="hidden" name="id" value="<?php echo $hotel['propertyID']; ?>">
            <input type="hidden" name="currency_symbol" value="<?php echo $currency['currencySymbol']; ?>">
            <input type="hidden" name="currency_position" value="<?php echo $currency['currencyPosition']; ?>">
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
            <div class="row">
                <div class="omgrid_4 omgrid_x6">
                    <label for="search_start_date" class="search_label">
                        <?php _e('Check-in', $this->cloudbeds_hotel_management); ?>
                    </label>
                    <div class="cf">
                        <input type="text" id="search_start_date" placeholder="<?php echo $datefrom; ?>" class="datas ofdate required"
                           name="search_start_date" value="<?php echo $datefrom; ?>"/>
                    </div>
                </div>
                <div class="omgrid_4 omgrid_x6">
                    <label for="search_end_date" class="search_label">
                        <?php _e('Check-out', $this->cloudbeds_hotel_management); ?>
                    </label>
                    <div class="cf">
                        <input type="text" placeholder="<?php echo $dateto; ?>" class="datas_end ofdate required"
                           name="search_end_date" value="<?php echo $dateto; ?>"/>
                    </div>
                </div>
                <div class="omgrid_4 omgrid_x12">
                    <input type="submit" value="<?php _e('SEARCH', $this->cloudbeds_hotel_management); ?>" class="cloudbedssearch"/>
                </div>
            </div>
        </form>
    </div>
</div>

<div id="reservationresponse" class=""></div>
<div id="roomsavailability" class=""></div>

<div class="cloudbeds_property_details">
    <div class="property white_bg">
        <div class="propertyTitle cf">
            <h4>
                <span id="hotel_property_name"><?php echo $hotel['propertyName']; ?></span> - <?php _e('Property Information', $this->cloudbeds_hotel_management);?>
            </h4>
        </div>
        <div class="cf plr20">
            <?php echo isset($hotel['description']) ? $hotel['description'] : ''; ?>
        </div>
        <?php if (isset($hotel['propertyAmenities']) && $hotel['propertyAmenities']): ?>
        <div class="clear"></div>
        <hr class="grey_ll">
        <h6><?php _e('Hotel Amenities', $this->cloudbeds_hotel_management);?></h6>
        <ul class="amenities">
            <?php
            foreach ($hotel['propertyAmenities'] as $value) {
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
            <span><?php _e('Check-In', $this->cloudbeds_hotel_management);?>: </span> <?php $this->time24to12($hotel['propertyPolicy']['propertyCheckInTime']); ?></p>

        <p class="checkin">
            <span><?php _e('Check-Out', $this->cloudbeds_hotel_management);?>: </span> <?php $this->time24to12($hotel['propertyPolicy']['propertyCheckOutTime']); ?> </p>

        <p class="checkin">
            <span><?php _e('Late Check Allowed', $this->cloudbeds_hotel_management);?>: </span> <?php if($hotel['propertyPolicy']['propertyLateCheckOutAllowed']) echo 'Allowed'; else _e('Late Checkout not Allowed', $this->cloudbeds_hotel_management); ?></p>

        <p class="checkin">
            <span><?php _e('Late Check-Out Fee', $this->cloudbeds_hotel_management);?>:</span>
            <?php if($hotel['propertyPolicy']['propertyLateCheckOutType'] == 'percent') {
                    echo $hotel['propertyPolicy']['propertyLateCheckOutValue'].' %';
                }else {
                    echo $this->format_api_currency($hotel['propertyPolicy']['propertyLateCheckOutValue']); 
                } ?> 
                <br/>
        </p>

        <?php if (!empty($hotel['propertyPolicy']['propertyTermsAndConditions'])) { ?>
            <div class="cf pp">
                <strong><?php _e('Terms and Conditions', $this->cloudbeds_hotel_management);?> :</strong> 
                <div class="cf" id="propertyTermsAndConditions">
                    <?php echo wpautop($hotel['propertyPolicy']['propertyTermsAndConditions']); ?>
                </div>
            </div>

        <?php } ?>

        <div class="clear"></div>
        <br/>
    </div>
</div>
<script type="text/javascript">
jQuery(document).ready(function ($) {
    if(jQuery('.cloudbeds_container').width() < 768){
        jQuery('.cloudbeds_container').addClass('smallerScreen');
    }
    if(jQuery("#hotel_gallery").length){
        jQuery("#hotel_gallery").lightSlider({
            item:4,
            autoWidth:true,
            slideMove:1,
            loop:false,
            pager:false,
            easing: 'cubic-bezier(0.25, 0, 0.25, 1)',
            onSliderLoad: function() {
                jQuery('#hotel_gallery').removeClass('cS-hidden');
            },
            responsive : [
                {
                    breakpoint:980,
                    settings: {
                        item:2
                      }
                },
                {
                    breakpoint:480,
                    settings: {
                        item:1
                      }
                }
            ]
        });  
    }
    <?php
        $currency_symbol = $currency['currencySymbol'];
        $currency_position = $currency['currencyPosition'];
        date_default_timezone_set('UTC');
        setlocale(LC_MONETARY, 'en_US');
    ?>
    var minDate = new Date(<?php echo date('Y'); ?>, <?php echo date('n'); ?>, <?php echo date('j'); ?>, 0, 0, 0, 0);
    var adults = 1;
    var kids = 0;
    var start_date = "<?php echo date($dateformat);?>";
    var end_date = "<?php echo date($dateformat, strtotime('tomorrow'));?>";
    var disabled_msg = '<?php _e("This hotel is not currently accepting reservations. Please check back shortly.", $this->cloudbeds_hotel_management); ?>';
    var no_rooms_msg = '<?php _e("We&#96;re sorry but there are no available rooms for your selected dates -- please modify your dates above to search again. We also encourage you to contact the hotel for more information at", $this->cloudbeds_hotel_management); echo $hotel["propertyPhone"]; ?>';
    var not_enough_rooms_msg = '<?php _e("We&#96;re sorry but we could not accomodate your request. Please change your selected dates or choose a fewer number of rooms. We also encourage you to contact the hotel for more information at", $this->cloudbeds_hotel_management); echo $hotel["propertyPhone"]; ?>';
    var no_rooms_selected_msg = '<?php _e("No Rooms added to cart.", $this->cloudbeds_hotel_management); ?>';
    var ct = null;
    var roomCount = 0;
    var cartCount = 0;
    var deposit_type = 0;
    var deposit_fixed = 0;
    var deposit_pct = 0;
    var taxes = 0;
    var taxes_included = 'Y';
    var included_taxes_type = 'percent';
    var terms_tax_percent = "<?php echo isset($hotel['propertyPolicy']['propertyTaxPercent']) ? $hotel['propertyPolicy']['propertyTaxPercent'] : 0; ?>";
    var terms_tax_fixed = 0;
    var fees_included = 'Y';
    var fees_included_type = 'percent';
    var fees_percent = 0;
    var fees_fixed = 0;
    var latitude = "<?php echo $hotel['propertyAddress']['propertyLatitude'];?>";
    var longitude = "<?php echo $hotel['propertyAddress']['propertyLongitude'];?>";
    var hotel_name = "<?php echo $hotel['propertyName'];?>";
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

    // var_dump($dateformat);
    // $jsdateformat = 'mm/dd/yy';
    switch ($dateformat) {
        case 'd/m/Y':
            $jsdateformat = 'dd/mm/yy';
            break;
        case 'Y/m/d':
            $jsdateformat = 'yy/mm/dd';
            break;
        case 'Y-m-d':
            $jsdateformat = 'yy-mm-dd';
            break;
        case 'd-m-Y':
            $jsdateformat = 'dd-mm-yy';
            break;
        case 'm-d-Y':
            $jsdateformat = 'mm-dd-yy';
            break;
        default: /* m/d/Y */
            $jsdateformat = 'mm/dd/yy';
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
    }, adults, kids, start_date, end_date, disabled_msg, no_rooms_msg, not_enough_rooms_msg, no_rooms_selected_msg, ct, roomCount, cartCount, deposit_type, deposit_pct, deposit_fixed, taxes, latitude, longitude, hotel_name, fb, country, taxes_included, included_taxes_type, terms_tax_percent, terms_tax_fixed, fees_included, fees_included_type, fees_percent, fees_fixed, newRoom, newPopup, newDetailedRatesPopup, newDetails, newDetailsPackage, newBookingRoom, searchform);

    // requestGetAvailability();
    jQuery("#hotelImages, #hotel_gallery, #hotelPropertyImage").magnificPopup({

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
</script>