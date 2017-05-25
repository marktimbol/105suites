<?php

$templatedata = $rooms; // need to store this variable to use for propertyID , engine { gds / central }

//cloudbeds_dump($rooms['roomsdata']['rooms']);

// $rooms = $rdata = $rooms['roomsdata'];
//print_r($data->rooms[0]->rooms[0]->rate->rate_basic);
  // var_dump($rooms['rooms'][0]['rooms'][2]['rate']['detailed_rates']);
// $this->vdump($rooms);
foreach ($rooms as $room) :

    $roomhtml .= '<tr class="room_type_row" data-id="' . $room['roomTypeID'] . '" data-val="' . $this->format_api_currency($room['roomRate']) . '" data-add-adults="0" data-add-kids="0" data-adults="' . $room['adultsIncluded'] . '" data-kids="' . $room['childrenIncluded'] . '" data-max="' . $room['maxGuests'] . '" data-name="' . $room['roomTypeName'] . '" data-package="0">';
    
    $thumb = $room['roomTypePhotos'][0]['thumb'];

    $roomhtml .= '  <td class="pphoto cb_small_40" title="'.__('Room type', $this->cloudbeds_hotel_management).'">  

                <div class="cb_hm_container">

                    <div class="room_photo">

                        <div style="background-image:url('.$thumb . ')">

                            <img class="bigger" alt="" src="' . plugins_url('/mybookings-light/public/images/bigger.png') . '">

                        </div>

                    </div>

                </div>

            </td>';

    $roomhtml .= '<td class="room_type cb_small_60">

                <div class="room_name_container">

                    <div class="stay stay_b omhide">

                        <div class="stay_bg"></div>

                        <table>

                            <tbody>

                                <tr class="padding-top-9">

                                    <td class="min_stay">'.__('Minimum Stay', $this->cloudbeds_hotel_management).'</td>

                                    <td class="nights">' . $selected_neight . ' '.__('Night(s)', $this->cloudbeds_hotel_management).'</td>

                                </tr>

                                <tr>

                                    <td class="min_stay">'.__('Included Occupancy', $this->cloudbeds_hotel_management).'</td>

                                    <td class="nights">' . $room['adultsIncluded'] . ' '.__('People', $this->cloudbeds_hotel_management).'</td>

                                </tr>

                                <tr class="padding-bottom-14">

                                    <td class="min_stay">'.__('Maximum Occupancy', $this->cloudbeds_hotel_management).'</td>

                                    <td class="nights">' . $room['maxGuests'] . ' People</td>

                                </tr>

                            </tbody>

                        </table>

                    </div>

                    <a href="javascript:void(0)" class="name_room"><i class="fa fa-plus-circle"></i> ' . $room['roomTypeName'] . '</a>

                </div>

                <div style="clear:both;"></div> 

            </td>';

    $roomhtml .= '<td class="aver_price" title="'.__('Price From', $this->cloudbeds_hotel_management).'">

                <div class="avg_rate_container">

                    <div class="stay stay_b detailed_rates omhide">

                        <div class="stay_bg"></div>

                        <table>

                            <tbody>';

        // var_dump($room);
        // $v = var_export($room['roomRateDetailed'], true);
        // echo '<style type="text/css">pre{ text-align:left;} </style><pre>'; print_r($v); echo '</pre>';
    foreach ($room['roomRateDetailed'] as $day) {
        // $date = date('Y-m-d', strtotime($day));
        // 
        $roomhtml .= '          <tr class="padding-top-9 padding-bottom-14 ">

                                    <td class="min_stay">' . $day['date'] . '</td>';
        $roomhtml .= '              <td class="nights">' . $this->format_api_currency($day['rate']) . '</td>';
        $roomhtml .= ' 
                                </tr>';

    }

    $roomhtml .= '          </tbody>

                        </table>

                    </div>

                    <span class="avg_rate">' . $this->format_api_currency($room['roomRate']) . '</span>

                </div>

            </td>';

    $roomhtml .= '<td class="for_22 cb_small_hide">' . $this->format_api_currency($room['roomRate']) . '

                <p class="only_left  omhide">only left</p>

            </td>

            <td class="max" title="'.__('Max', $this->cloudbeds_hotel_management).'">';

    for ($i = 0; $i < $room['maxGuests']; $i++) {

        $roomhtml .= '<i class="fa fa-user"></i>';

    }

    $roomhtml .= '</td>';

    $roomhtml .= '<td class="no_rooms cb_small_33" title="'.__('Adults', $this->cloudbeds_hotel_management).'">

                <div class="styled_select">

                    <select name="adults[' . $room['hotel'] . ']" class="required">';

    for ($i = 0; $i < (int)$room['maxGuests']; $i++) {

        $roomhtml .= '<option value="' . ($i + 1) . '">' . ($i + 1) . '</option>';

    }

    $roomhtml .= '</select>

                </div>

            </td>';

    $roomhtml .= '<td class="no_rooms cb_small_33" title="'.__('Kids', $this->cloudbeds_hotel_management).'">

                <div class="styled_select">

                    <select name="kids[' . $room['hotel'] . ']" class="required">';

    for ($i = 0; $i < $room['maxGuests']; $i++) {

        $roomhtml .= '<option value="' . $i . '">' . $i . '</option>';

    }

    $roomhtml .= '</select>

                </div>

            </td>';

    $roomhtml .= '<td class="no_rooms cb_small_33"  title="'.__('No. rooms', $this->cloudbeds_hotel_management).'">

                    <div class="styled_select">

                        <select data-max_rooms="16" name="qty_rooms[' . $room['hotel'] . ']" class="required">';

    for ($i = 0; $i <= $room['roomsAvailable']; $i++) {

        $roomhtml .= '<option value="' . $i . '">' . $i . '</option>';

    }

    $roomhtml .= '</select>

                    </div>

                </td>

            </tr>';

    $roomhtml .= '<tr class="info_about_rooms">

                <td colspan="8">

                    <div class="room_details_container">

                        <p class="tarifa_basic">'.sprintf(__('Basic rate: %s (including %s adults and %s children)', $this->cloudbeds_hotel_management), $this->format_api_currency($room['roomRate']), $room['adultsIncluded'], $room['childrenIncluded']).'</p>

                        <div class="white_share"></div>

                        <div>

                            <ul class="room_type_tabs">

                                <li class="active description_tab">'.__('Description', $this->cloudbeds_hotel_management).'</li>

                                <li class="amenities_tab">'.__('Amenities', $this->cloudbeds_hotel_management).'</li>

                                <li class="photos_tab">'.__('Photos', $this->cloudbeds_hotel_management).'</li>
                            </ul>

                            <div class="tab_info2">

                                <div class="active">' . $room['roomTypeDescription'] . '</div>

                                <div class="amenities_tab">

                                    <ul>';

    foreach ($room['roomTypeFeatures'] as $feature) {

        $roomhtml .= '<li>' . $feature . '</li>';

    }

    $roomhtml .= '                          </ul>

                                    <div style="clear:both;"></div>

                                </div>

                                <div><div class="tabGallery">';

    foreach ($room['roomTypePhotos'] as $photo) { 
        // if(!strpos($photo, $this->cb_api) )
        //     $photo = $this->cb_api.$photo;

        // $thumbnail = $photo;   
        // $full_image = str_replace('_thumb', '', $photo);
        if(is_array($photo))
            $roomhtml .= '<a href="'.$photo['image'] . '" class="small"><span style="background-image: url(' .$photo['thumb'] . ');" class="room_image"></span></a>';

    }

    $roomhtml .= '                    </div></div>

                            </div>

                        </div>

                    </div>

                </td>

            </tr>';

endforeach;

?>
<div id="cb_hm_progress" class="cb_hm_progress">
    <div class="row">
        <a class="cb_hm_sp_6 cb_hm_c active">
            <?php _e('Choose accommodations', $this->cloudbeds_hotel_management); ?>
        </a>
        <a class="cb_hm_c cb_hm_sp_6">
            <?php _e('Checkout', $this->cloudbeds_hotel_management); ?>            
        </a>
    </div>
</div>
<div id="cb_hm_room_List" class="chooser">
    <div class="room_container api_rooms_container">
        <div class="choose_info rooms_list">
            <table class="rooms">
                <thead>
                <tr>
                    <th class="room_type" colspan="2"><?php _e('Room type', $this->cloudbeds_hotel_management);?></th>
                    <th class="aver_price"><?php _e('Price From', $this->cloudbeds_hotel_management);?></th>
                    <th class="for_22"><span class="nights_count"><?php echo $selected_neight; ?></span> <?php _e('Night(s)', $this->cloudbeds_hotel_management);?></th>
                    <th class="max"><?php _e('Max', $this->cloudbeds_hotel_management);?></th>
                    <th class="adults"><?php _e('Adults', $this->cloudbeds_hotel_management);?></th>
                    <th class="kids"><?php _e('Kids', $this->cloudbeds_hotel_management);?></th>
                    <th class="no_rooms"><?php _e('No. rooms', $this->cloudbeds_hotel_management);?></th>
                </tr>
                </thead>
                <tbody>
                <?php echo $roomhtml; ?>
                </tbody>
            </table>

            <div class="block_move">
                <div>
                    <span id="notice_background"><i class="fa fa-info-circle"></i> <?php _e('Move the mouse over the price for inclusions, occupancy and minimum stay', $this->cloudbeds_hotel_management);?></span>
                </div>
            </div>
        </div>

        <div class="segura choose_total">
            <div class="table_filler"></div>
            <p class="compra">
                <font>
                    <font><?php _e('100% Secure Shopping', $this->cloudbeds_hotel_management);?></font>
                </font>
            </p>

            <p class="compra_rooms omhide">
                <span class="roomsCount"></span><?php _e('Rooms for', $this->cloudbeds_hotel_management);?></p>
            <p class="compra_price"></p>

            <button type="button" class="book_now"><?php _e('BOOK NOW', $this->cloudbeds_hotel_management);?></button>

            <p class="confirm"><?php _e('Confirmation is immediate', $this->cloudbeds_hotel_management);?></p>
            <div class="couponBlock">
                <?php if($couponapplied) { ?>
                    <div class="coupon_applied"><span class="cb_hm_success"></span> Coupon Applied</div>
                <?php }else { ?>
                    <center><a href="javascript:void(0)" class="havePromocode">Have promo code ?</a></center>
                    <div class="promocode-container">
                        <input type="text" id="promo_code_input" placeholder="<?php _e('Coupon Code', $this->cloudbeds_hotel_management);?>">
                        <input type="button" value="<?php _e('Use Coupon', $this->cloudbeds_hotel_management);?>" class="cb_hm_submit_code" name="submit_promo">
                    </div>
                    
                <?php } ?>
            </div>
        </div>

        <div style="clear:both;"></div>
    </div>

    <div class="message_container omhide" style="display: none;"></div>

</div>

<div id="selected_reservation_form" class="suas omhide">
    <div class="row">
        <div class="omgrid_8 omgrid_x12 room_payment_form">
            <form id="reservationDetailsForm" action="">
                <input type="hidden" name="id" value="<?php echo $propertyID; ?>">
                <input type="hidden" name="payment_method" value="cards">

                <input type="hidden" name="lang" value="en">

                <input type="hidden" name="date_format_DP" value="<?php echo $postdata['date_format_DP']; ?>">
                <div class="payment_form payment_form_1">
                    <h3><?php _e('Contact Information', $this->cloudbeds_hotel_management);?></h3>
                    <div class="row">
                        <div class="omgrid_6 omgrid_x12">
                            <div class="input_r">
                                <label for="cbhm_country" class="normal_label"><span class="red">*</span> <?php _e('Country', $this->cloudbeds_hotel_management);?></label>
                                <select id="cbhm_country" name="country" class="customselect country_selector required">
                                    <option value="" selected="selected"><?php _e('Choose Country', $this->cloudbeds_hotel_management);?></option>
                                    <?php $countries = $this->get_countries();
                                    foreach ($countries as $key => $name) {
                                        echo '<option value="'.$key.'">'.$name.'</option>';
                                    } ?>
                                </select>
                            </div>
                        </div>
                        <div class="omgrid_6 omgrid_x12">
                            <div class="input_r">
                                <label for="cbhm_zip" class="fluid_label"><span class="red">*</span> <?php _e('Zip Code', $this->cloudbeds_hotel_management);?>:</p></label>
                                <input type="text" id="cbhm_zip" class="fluid_input required" name="zip_f" />
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="omgrid_6 omgrid_x12">
                            <div class="input_r">
                                <label for="cbhm_firstname" class="fluid_label"><span class="red">*</span> <?php _e('First Name', $this->cloudbeds_hotel_management);?></label>
                                <input type="text" id="cbhm_firstname" name="first_name" class="fluid_input required">
                            </div>
                        </div>
                        <div class="omgrid_6 omgrid_x12">
                            <div class="input_r">
                                <label for="last_name" class="fluid_label"><span class="red">*</span> <?php _e('Last Name', $this->cloudbeds_hotel_management);?></label>
                                <input type="text" id="cbhm_last_name" name="last_name" class="required fluid_input">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="omgrid_6 omgrid_x12">
                            <div class="input_r">
                                <label for="cbhm_email" class="fluid_label"><span class="red">*</span> <?php _e('Email', $this->cloudbeds_hotel_management);?></label>
                                <input type="email" id="cbhm_email" name="email" class="required email fluid_input">
                            </div>
                        </div>
                        <div class="omgrid_6 omgrid_x12">
                            <div class="input_r">
                                <label for="cbhm_phone" class="fluid_label"><?php _e('Phone', $this->cloudbeds_hotel_management);?></label>
                                <input type="text" id="cbhm_phone" class="fluid_input required" name="phone" />
                            </div>
                        </div>
                    </div>
                </div>
                <div class="payment_form payment_form_2">
                    <h3><?php _e('Payment Method', $this->cloudbeds_hotel_management);?></h3>
                    <div class="row">
                        <div class="omgrid_6 omgrid_x12">
                            <div class="input_r">
                                <label for="choose_card" class="normal_label"><span class="red">*</span> Card Type</label>
                                <select id="choose_card" name="choose_card" class="required customselect">
                                    <option value="visa">Visa</option>
                                    <option value="master">Mastercard</option>
                                    <option value="amex">American Express</option>
                                    <option value="diners">Diners</option>
                                </select>
                            </div>
                        </div>
                        <div class="omgrid_6 omgrid_x12">
                            <div class="input_r">
                                <label for="cardholder_name" class="fluid_label"><?php _e('Name on Card', $this->cloudbeds_hotel_management);?></label>
                                <input type="text" class="fluid_input required" id="cardholder_name" name="cardholder_name" />
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="omgrid_6 omgrid_x12">
                            <div class="input_r">
                                <label for="card_number" class="fluid_label"><span class="red">*</span> <?php _e('Card Number', $this->cloudbeds_hotel_management);?></label>
                                <input type="text" name="card_number" class="required cc fluid_input" minlength="13" maxlength="19">
                            </div>
                        </div>
                        <div class="omgrid_6 omgrid_x12">
                            <div class="row">
                                <div class="omgrid_3  omgrid_x4">
                                    <div class="input_r">
                                        <label for="exp_month" class="normal_label"><span class="red">*</span> <?php _e('MM', $this->cloudbeds_hotel_management);?></label>
                                        <select id="exp_month" name="exp_month" class="required customselect">
                                            <option value="1">01</option>
                                            <option value="2">02</option>
                                            <option value="3">03</option>
                                            <option value="4">04</option>
                                            <option value="5">05</option>
                                            <option value="6">06</option>
                                            <option value="7">07</option>
                                            <option value="8">08</option>
                                            <option value="9">09</option>
                                            <option value="10">10</option>
                                            <option value="11">11</option>
                                            <option value="12">12</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="omgrid_4  omgrid_x4">
                                    <div class="input_r">
                                        <label for="exp_year" class="normal_label"><span class="red">*</span> <?php _e('YYYY', $this->cloudbeds_hotel_management);?></label>
                                         <select id="exp_year" name="exp_year" class="required customselect">
                                            <?php foreach ($years as $year) {
                                                echo '<option value="' . $year . '">' . $year . '</option>';
                                            } ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="omgrid_5 omgrid_x4">
                                    <div class="input_r">
                                        <label for="card_cvv" class="fluid_label"><span class="red">*</span> <?php _e('CVV', $this->cloudbeds_hotel_management);?></label>
                                        <input id="card_cvv" type="text" name="cvv" class="fluid_input required" maxlength="4">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="payment_form payment_form_3">
                    <div class="cf">
                        <div class="input_r">
                            <label for="special_request" class="fluid_label"><?php _e('Special Requests', $this->cloudbeds_hotel_management);?></label>
                            <textarea class="fluid_input" name="special_requests"></textarea>
                        </div>
                    </div>
                </div><br/>
                <div class="cf">
                    <label for="terms">
                        <input type="checkbox" class="required" name="agree"><?php _e('I agree with', $this->cloudbeds_hotel_management);?>
                        <a href="javascript:void(0)" title="Terms and Conditions" class="userAgreementLink">
                            <?php _e('the terms and conditions of ', $this->cloudbeds_hotel_management); echo '<span class="hotel_property_name"></span>';?>
                        </a> 
                        <div style="display:none;" id="revervationtemsandcondition" class="displaynone qtipinfo">
                           
                        </div>
                    </label>
                </div><br/>
                <div class="payment_form payment_form_3">
                    <div class="row">
                        <div class="omgrid_7 omgrid_x12">
                            <div class="securepayment cf">
                                <i class="fa fa-lock"></i> Secure Online Payment. <a href="javascript:void(0)" class="learnmoreinfo">Learn More</a>
                                <div style="display:none;" id="secureinfo" title="SECURE ONLINE TRANSACTION" class="displaynone qtipinfo">
                                    <p>Cloudbeds uses PCI-Compliant security standards. All information transmitted is encrypted with a 128-bit SSL certificate. Payment information is stored within a vault, and only for a short period of time.</p>
                                </div>
                            </div>
                        </div>
                        <div class="omgrid_5 omgrid_x12">
                            <input type="button" class="finalizecentral" value="<?php _e('Complete Reservation', $this->cloudbeds_hotel_management);?>">
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <div class="omgrid_4 omgrid_x12 reservation_block">
            <h2><?php _e('Your Reservation', $this->cloudbeds_hotel_management);?></h2>
            <h5><?php _e('Room Selections', $this->cloudbeds_hotel_management);?>:</h5>
            <div class="clonable_for_selected_room_container omhide">
                <label><span class="selected_room_select_name"></span> ( x <span class="selected_room_count"></span> )</label>
                <strong>Adults: </strong><span class="selected_room_adults"></span> <strong>Kids:</strong> <span class="selected_room_kids"></span>
            </div>
            <div class="selected_room_container"></div>
            <div class="reserve">
                <strong><?php _e('Arrival Date', $this->cloudbeds_hotel_management);?>:</strong><br/>
                <span class="checkin_date"></span>
            </div>
            <div class="reserve">
                <strong><?php _e('Departure Date', $this->cloudbeds_hotel_management);?>:</strong><br/>
                <span class="checkout_date"></span>
            </div>
            <div class="reserve">
                <strong><?php _e('Room Nights', $this->cloudbeds_hotel_management);?>:</strong><br/>
                <span class="nights_int"></span>
            </div>
            <div class="reserve spacer">
                <div class="row">
                    <div class="omgrid_7 omgrid_x7">
                        <?php _e('Room Total', $this->cloudbeds_hotel_management);?>:
                    </div>
                    <div class="omgrid_5 omgrid_x5 text-right">
                        <span class="total_value"></span>
                    </div>
                </div>
                <div class="row sub_tax_row">
                    <div class="omgrid_7 omgrid_x7">
                        <?php _e('Tax', $this->cloudbeds_hotel_management);?>:
                    </div>
                    <div class="omgrid_5 omgrid_x5 text-right">
                        <span class="sub_tax"></span>
                    </div>
                </div>
                <div class="row sub_fees_row">
                    <div class="omgrid_7 omgrid_x7">
                        <?php _e('Hotel Fees', $this->cloudbeds_hotel_management);?>:
                    </div>
                    <div class="omgrid_5 omgrid_x5 text-right">
                        <span class="sub_fees"></span>
                    </div>
                </div>
            </div>
            <div class="reserve spacer">
                <div class="row">
                    <div class="omgrid_7 omgrid_x7">
                        <?php _e('Advance amount', $this->cloudbeds_hotel_management);?>:
                    </div>
                    <div class="omgrid_5 omgrid_x5 text-right">
                        <span class="total_deposit"></span>
                    </div>
                </div>
                <div class="row">
                    <div class="omgrid_7 omgrid_x7">
                        <?php _e('Amount paid at check-in', $this->cloudbeds_hotel_management);?>:
                    </div>
                    <div class="omgrid_5 omgrid_x5 text-right">
                        <span class="total_checkin"></span>
                    </div>
                </div>
            </div>
            <div class="reserve spacer">
                <div class="row">
                    <div class="omgrid_7 omgrid_x7">
                        <?php _e('Grand Total', $this->cloudbeds_hotel_management);?>:
                    </div>
                    <div class="omgrid_5 omgrid_x5 text-right">
                        <span class="grand_total"></span>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>


<div id="reservation_confirmation"></div>