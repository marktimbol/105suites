<?php

$templatedata = $rooms; // need to store this variable to use for propertyID , engine { gds / central }

//cloudbeds_dump($rooms['roomsdata']['rooms']);

$rooms = $rdata = $rooms['roomsdata'];
//print_r($data->rooms[0]->rooms[0]->rate->rate_basic);
  // var_dump($rooms['rooms'][0]['rooms'][2]['rate']['detailed_rates']);

if ($rooms['success'] && $rooms['room_count'] > 0) {
 
    $hotels = $rdata['rooms']; 

    foreach ($hotels as $hotel) { 
        // $currency = $hotel['currency']['symbol'];
        // $currency_position = $hotel['currency']['position'];
        foreach ($hotel['rooms'] as $room) :

            $roomhtml .= '<tr class="room_type_row" data-id="' . $room['rate']['rate_id'] . '" data-val="' . $this->format_currency($room['rate']['rate_basic']) . '" data-add-adults="' . $this->format_currency($room['rate']['add_adult_rate']) .
                '" data-add-kids="' . $this->format_currency($room['rate']['add_kid_rate']) . '" data-adults="' . $room['guests']['adults_included'] . '" data-kids="' . $room['guests']['kids_included'] . '" data-max="' . $room['guests']['max'] . '" data-name="' . $room['name'] . '" data-package="0">';

            $roomhtml .= '  <td class="pphoto">  

                        <div class="cb_hm_container">

                            <div class="room_photo">

                                <div style="background-image:url(' . $room['photos'][0] . ')">

                                    <img class="bigger" alt="" src="' . plugins_url('/mybookings-light/public/images/bigger.png') . '">

                                </div>

                            </div>

                        </div>

                    </td>';

            $roomhtml .= '<td class="room_type">

                        <div class="room_name_container">

                            <div class="stay stay_b omhide">

                                <div class="stay_bg"></div>

                                <table>

                                    <tbody>

                                        <tr class="padding-top-9">

                                            <td class="min_stay">'.__('Minimum Stay', $this->cloudbeds_hotel_management).'</td>

                                            <td class="nights">' . $room['rate']['days'] . ' '.__('Night(s)', $this->cloudbeds_hotel_management).'</td>

                                        </tr>

                                        <tr>

                                            <td class="min_stay">'.__('Included Occupancy', $this->cloudbeds_hotel_management).'</td>

                                            <td class="nights">' . $room['guests']['adults_included'] . ' '.__('People', $this->cloudbeds_hotel_management).'</td>

                                        </tr>

                                        <tr class="padding-bottom-14">

                                            <td class="min_stay">'.__('Maximum Occupancy', $this->cloudbeds_hotel_management).'</td>

                                            <td class="nights">' . $room['guests']['max'] . ' People</td>

                                        </tr>

                                    </tbody>

                                </table>

                            </div>

                            <a href="javascript:void(0)" class="name_room"><i class="fa fa-plus-circle"></i> ' . $room['name'] . '</a>

                        </div>

                        <div style="clear:both;"></div> 

                    </td>';

            $roomhtml .= '<td class="aver_price">

                        <div class="avg_rate_container">

                            <div class="stay stay_b detailed_rates omhide">

                                <div class="stay_bg"></div>

                                <table>

                                    <tbody>';

                // var_dump($room['rate']['detailed_rates']);
            foreach ($days as $day) {
                // $date = date('Y-m-d', strtotime($day));
                // 
                $roomhtml .= '          <tr class="padding-top-9 padding-bottom-14 ">

                                            <td class="min_stay">' . $day . '</td>';

                    if($this->is_api_enabled()){
                $roomhtml .= '              <td class="nights">' . $this->format_currency($room['rate']['rate_min']) . '</td>';
                    }else {
                        $date = date('Y-m-d', strtotime($day));
                $roomhtml .= '              <td class="nights">' . $nightrate . '<input class="roomrateid" type="hidden" name="roomrateid['. $room['id'] .']['.$date.']" value="'. $room['rate']['detailed_rates'][$date]['id'] .'" /></td>';
                    }
                $roomhtml .= ' 
                                        </tr>';

            }

            $roomhtml .= '          </tbody>

                                </table>

                            </div>

                            <span class="avg_rate">' . $this->format_currency($room['rate']['rate_min']) . '</span>

                        </div>

                    </td>';

            $roomhtml .= '<td class="for_22">' . $this->format_currency($room['rate']['rate_basic']) . '

                        <p class="only_left  omhide">only left</p>

                    </td>

                    <td class="max">';

            for ($i = 0; $i < $room['guests']['max']; $i++) {

                $roomhtml .= '<i class="fa fa-user"></i>';

            }

            $roomhtml .= '</td>';

            $roomhtml .= '<td class="no_rooms">

                        <div class="styled_select">

                            <select name="adults[' . $room['hotel'] . ']" class="required">';

            for ($i = 0; $i < (int)$room['guests']['max']; $i++) {

                $roomhtml .= '<option value="' . ($i + 1) . '">' . ($i + 1) . '</option>';

            }

            $roomhtml .= '</select>

                        </div>

                    </td>';

            $roomhtml .= '<td class="no_rooms">

                        <div class="styled_select">

                            <select name="kids[' . $room['hotel'] . ']" class="required">';

            for ($i = 0; $i < $room['guests']['max']; $i++) {

                $roomhtml .= '<option value="' . $i . '">' . $i . '</option>';

            }

            $roomhtml .= '</select>

                        </div>

                    </td>';

            $roomhtml .= '<td class="no_rooms">

                            <div class="styled_select">

                                <select data-max_rooms="16" name="qty_rooms[' . $room['hotel'] . ']" class="required">';

            for ($i = 0; $i <= $room['available']; $i++) {

                $roomhtml .= '<option value="' . $i . '">' . $i . '</option>';

            }

            $roomhtml .= '</select>

                            </div>

                        </td>

                    </tr>';

            $roomhtml .= '<tr class="info_about_rooms">

                        <td colspan="8">

                            <div class="room_details_container">

                                <p class="tarifa_basic">'.sprintf(__('Basic rate: %s (including %s adults and %s children)', $this->cloudbeds_hotel_management), $this->format_currency($room['rate']['basic']), $room['guests']['adults_included'], $room['guests']['kids_included']).'</p>

                                <p class="tarifa">'.sprintf(__('Additional adult: %s | Child: %s', $this->cloudbeds_hotel_management), $this->format_currency($room['rate']['add_adult_rate']), $this->format_currency($room['rate']['add_kid_rate'])) .'</p>

                                <div class="white_share"></div>

                                <div>

                                    <ul class="room_type_tabs">

                                        <li>&nbsp;</li>

                                        <li class="active">'.__('Description', $this->cloudbeds_hotel_management).'</li>

                                        <li class="amenities_tab">'.__('Amenities', $this->cloudbeds_hotel_management).'</li>

                                        <li>'.__('Photos', $this->cloudbeds_hotel_management).'</li>

                                        <li>&nbsp;</li>

                                    </ul>

                                    <div class="tab_info2">

                                        <div class="active">' . $room['description'] . '</div>

                                        <div class="amenities_tab">

                                            <ul>';

            foreach ($room['features'] as $feature) {

                $roomhtml .= '<li>' . $feature . '</li>';

            }

            $roomhtml .= '                          </ul>

                                            <div style="clear:both;"></div>

                                        </div>

                                        <div><div class="tabGallery">';

            foreach ($room['photos'] as $photo) {

                $roomhtml .= '<a href="' . $photo . '" class="small"><span style="background-image: url(' . $photo . ');" class="room_image"></span></a>';

            }

            $roomhtml .= '                    </div></div>

                                    </div>

                                </div>

                            </div>

                        </td>

                    </tr>';

        endforeach;

    }

}

?>
<div id="cb_hm_progress" class="cb_hm_progress">
    <div class="row">
        <a class="cb_hm_sp_6 cb_hm_c active">
            <?php _e('Choose and Accommodation', $this->cloudbeds_hotel_management); ?>
        </a>
        <a class="cb_hm_c cb_hm_sp_6">
            <?php _e('Checkout', $this->cloudbeds_hotel_management); ?>            
        </a>
    </div>
</div>
<div class="chooser omhide" style="display: block;">
    <div class="room_container omhide" style="display: block;">
        <div class="choose_info">
            <table class="rooms">
                <thead>
                <tr>
                    <th class="room_type" colspan="2"><?php _e('Room type', $this->cloudbeds_hotel_management);?></th>
                    <th class="aver_price"><?php _e('Price From', $this->cloudbeds_hotel_management);?></th>
                    <th class="for_22"><span class="nights_count"><?php echo count($days); ?></span> <?php _e('Night(s)', $this->cloudbeds_hotel_management);?></th>
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

        <div class="segura">
            <div class="table_filler"></div>
            <p class="compra">
                <font>
                    <font><?php _e('100% Secure Shopping', $this->cloudbeds_hotel_management);?></font>
                </font>
            </p>

            <p class="compra_rooms omhide">
                <span class="roomsCount"></span><?php _e('Rooms for', $this->cloudbeds_hotel_management);?></p>
            <p class="compra_price"></p>

            <input type="button" value="<?php _e('BOOK NOW', $this->cloudbeds_hotel_management);?>" class="book_now">

            <p class="confirm"><?php _e('Confirmation is immediate', $this->cloudbeds_hotel_management);?></p>
            <p class="not_included"><?php _e('Not Included [%] Tax', $this->cloudbeds_hotel_management);?></p>

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

<div class="suas omhide">

    <div class="white_bg">

        <div class="short_reservas_mini omhide">
            <h4><?php _e('Your Reservation', $this->cloudbeds_hotel_management);?></h4>

            <hr class="blue_line">

            <p class="short_info selected_room_container"><?php _e('Room Selections', $this->cloudbeds_hotel_management);?>:</p>
            <p class="short_info checkin_container"><?php _e('Arrival Date', $this->cloudbeds_hotel_management);?>:</p>
            <p class="short_info2">
                <span class="checkin_date"></span>
            </p>
            <div class="row">
                <div class="short_info nights_container omgrid_7"><?php _e('Departure Date', $this->cloudbeds_hotel_management);?>:</div>
                <div class="short_info2">
                    <span class="checkout_date omgrid_5 text-right"></span>
                </div>
            </div>
            <p class="short_info nights_container"><?php _e('Room Nights', $this->cloudbeds_hotel_management);?>:</p>
            <p class="short_info2">
                <span class="nights_int"></span>
            </p>

            <p class="totale"><?php _e('Room Total', $this->cloudbeds_hotel_management);?>:
                <span class="total_value"></span>
            </p>

            <div class="taxas">
                <div class="l1">
                    <p><?php _e('Advance amount', $this->cloudbeds_hotel_management);?>:</p>
                    <p><?php _e('Amount paid at check-in', $this->cloudbeds_hotel_management);?>:</p>
                </div>

                <div class="r1">
                    <p class="total_deposit"></p>
                    <p class="total_checkin"></p>
                </div>

                <div style="clear:both;"></div>

                <hr class="grey_line valor">

                <div class="total">
                    <div class="l1">
                        <p><?php _e('Grand Total', $this->cloudbeds_hotel_management);?>:</p>
                    </div>

                    <div class="r1">
                        <p class="grand_total"></p>
                    </div>

                    <div style="clear:both;"></div>
                </div>

                <hr class="grey_line tt">

            </div>

        </div>

        <div class="cf">

            <div class="form_fields">

                <form id="reservationDetailsForm" action="">


                    <input type="hidden" name="id" value="<?php echo $templatedata['id']; ?>">

                    <input type="hidden" name="lang" value="en">

                    <input type="hidden" name="date_format_DP" value="<?php echo $params['date_format_DP']; ?>">

                    <h4><?php _e('Contact and Billing Information', $this->cloudbeds_hotel_management);?></h4>

                    <div class="white_block">

                        <div class="omrow">

                            <div class="country omgrid_8">

                                <p><?php _e('Country', $this->cloudbeds_hotel_management);?></p>

                                <div class="styled_select to_country">

                                    <select name="country" class="country_selector">

                                        <option value="" selected="selected"><?php _e('Choose Country', $this->cloudbeds_hotel_management);?></option>
                                        <?php $countries = $this->get_countries();
                                        foreach ($countries as $key => $name) {
                                            echo '<option value="'.$key.'">'.$name.'</option>';
                                        } ?>
                                    </select>

                                </div>

                            </div>

                        </div>

                        <p class="porfavor"><?php _e('Continue checking out as a guest by filling in the required fields below', $this->cloudbeds_hotel_management);?>:</p>

                        <div class="omrow">
                            <div class="omgrid_4">
                                <p><?php _e('First Name', $this->cloudbeds_hotel_management);?></p>
                                <input type="text" name="first_name" class="required">
                            </div>

                            <div class="omgrid_4">
                                <p><?php _e('Last Name', $this->cloudbeds_hotel_management);?></p>
                                <input type="text" name="last_name" class="required">
                            </div>

                            <div class="omgrid_4">
                                <p><?php _e('Email Address', $this->cloudbeds_hotel_management);?>:</p>
                                <input type="text" name="email" class="required email">
                            </div>
                        </div>

                        <div class="omrow">
                            <div class="telefone omgrid_4">
                                <p><?php _e('Phone', $this->cloudbeds_hotel_management);?>:</p>
                                <input type="text" name="phone" class="required">
                            </div>
                        </div>


                        <hr class="form_line">

                        <div class="omrow">

                            <div class="rua omgrid_4">
                                <p><?php _e('Address', $this->cloudbeds_hotel_management);?>:</p>
                                <input type="text" name="street" class="required">
                            </div>

                            <div class="cidade omgrid_4">
                                <p><?php _e('City', $this->cloudbeds_hotel_management);?>:</p>
                                <input type="text" name="city" class="required">
                            </div>

                            <div class="zip_foreign omgrid_4">
                                <p><?php _e('Postal Code', $this->cloudbeds_hotel_management);?>:</p>
                                <input type="text" name="zip_f" class="required" placeholder="99999"/>
                            </div>

                        </div>

                        <hr class="form_line">

                        <div class="omrow">

                            <div class="hear_about omgrid_8">
                                <p><?php _e('How did you hear about us', $this->cloudbeds_hotel_management);?>?</p>
                                <div class="styled_select to_hear">
                                    <select name="hear_about" class="">
                                        <option value=""><?php _e('Select an option', $this->cloudbeds_hotel_management);?>...</option>
                                        <option value="OTA"><?php _e('Online Travel Agent', $this->cloudbeds_hotel_management);?></option>
                                        <option value="Travel Agent"><?php _e('Travel Agent', $this->cloudbeds_hotel_management);?></option>
                                        <option value="Search Engine"><?php _e('Friends', $this->cloudbeds_hotel_management);?></option>
                                        <option value="Trip Advisor"><?php _e('Hotel Website', $this->cloudbeds_hotel_management);?></option>
                                        <option value="Advertisement Online"><?php _e('Online Recomendation', $this->cloudbeds_hotel_management);?></option>
                                        <option value="Other"><?php _e('Other', $this->cloudbeds_hotel_management);?></option>
                                    </select>
                                </div>

                            </div>

                            <div class="omgrid_4">
                                <div class="hear_other_how omhide">
                                    <p><?php _e('How', $this->cloudbeds_hotel_management);?>?:</p>
                                    <input type="text" name="hear_other">
                                </div>
                            </div>

                        </div>

                        <hr class="form_line">
                        <?php if($this->is_api_enabled()): ?>
                            <div class="cards">
                                <div class="omrow">
                                    <div class="styled_select cards_select omgrid_4">
                                        <select name="choose_card" class="required">
                                            <option value="visa">Visa</option>
                                            <option value="master">Mastercard</option>
                                            <option value="amex">American Express</option>
                                            <option value="aura">Aura</option>
                                            <option value="diners">Diners</option>
                                            <option value="hiper">Hipercard</option>
                                            <option value="elo">Elo</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="omrow">
                                    <div class="no_cartao omgrid_4">
                                        <p><?php _e('Name of Cardholder', $this->cloudbeds_hotel_management);?>:</p>
                                        <input type="text" name="cardholder_name" class="required">
                                    </div>

                                    <div class="do_cartao omgrid_4">
                                        <p><?php _e('Credit Card No.', $this->cloudbeds_hotel_management);?></p>
                                        <input type="text" name="card_number" class="required" minlength="13" maxlength="19">
                                    </div>
                                </div>

                                <div class="omrow">
                                    <div class="data de omgrid_4">
                                        <p><?php _e('Expiration Date', $this->cloudbeds_hotel_management);?>:</p>
                                        <div class="omrow">
                                            <div class="styled_select exp_month omgrid_5">
                                                <select name="exp_month" class="required">
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

                                            <div class="styled_select exp_year omgrid_7">
                                                <select name="exp_year" class="required">
                                                    <?php foreach ($years as $year) {
                                                        echo '<option value="' . $year . '">' . $year . '</option>';
                                                    } ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="cvv omgrid_3">
                                        <p><?php _e('Security Code / CVV', $this->cloudbeds_hotel_management);?>:</p>
                                        <input type="text" name="cvv" class="dd required" maxlength="4">
                                    </div>
                                </div>

                            </div>

                            <hr class="form_line">
                        <?php endif; ?>

                        <p><?php _e('Is this your first time at this hotel', $this->cloudbeds_hotel_management);?>?</p>

                        <div class="primiera omrow">
                            <label class="omgrid_4">
                                <input type="radio" name="first_time" value="Y" class="required"> <?php _e('Yes', $this->cloudbeds_hotel_management);?>
                            </label>

                            <label class="omgrid_4">
                                <input type="radio" name="first_time" value="N" class="required"> <?php _e('No', $this->cloudbeds_hotel_management);?>
                            </label>
                        </div>


                        <div class="omrow">
                            <div class="omgrid_12">
                                <p class="especials"><?php _e('Special Requests', $this->cloudbeds_hotel_management);?>:</p>
                                <textarea class="esp" name="special_requests"></textarea>
                                <label class="terms_conditions">
                                    <input type="checkbox" class="required" name="agree"><?php _e('I agree with', $this->cloudbeds_hotel_management);?>
                                    <a href="#" class="userAgreementLink">
                                        <?php _e('the terms and conditions of', $this->cloudbeds_hotel_management);?> <span id="ajaxautoloadhotelname"></span>
                                    </a>
                                </label>

                                <div class="trans"></div>
                            </div>
                        </div>

                        <div class="choise_modal omrow">
                            <div class="secure_notice omgrid_6">
                                <img style="" src="<?php echo plugins_url('/mybookings-light/public/images/padlock.png'); ?>"
                                     pagespeed_url_hash="3091412696">
                                <div style="display:inline-block;line-height:14px;padding:0 0 0 10px;">
                                    <?php _e('Secure Online Payment', $this->cloudbeds_hotel_management);?>
                                    <br>
                                    <span class="fake_link"><?php _e('Learn More', $this->cloudbeds_hotel_management);?></span>
                                </div>
                            </div>

                            <div class="omgrid_6">
                                <input type="button" class="finalizecentral" value="<?php _e('Complete Your Reservation', $this->cloudbeds_hotel_management);?>">
                            </div>
                        </div>

                    </div>

                </form>

            </div>

            <div class="short_reservas">
                <h4>Your Reservation</h4>
                <hr class="blue_line">
                <div class="short_info selected_room_container"><strong><?php _e('Room Selections', $this->cloudbeds_hotel_management);?>:</strong></div>
                <div class="short_info2 clonable_for_selected_room_container omhide">
                    <span class="selected_room_container_name"></span>(x
                    <span class="selected_room_container_selected_count"></span>)
                    <br>
                    <span class="bold"><strong><?php _e('Adults', $this->cloudbeds_hotel_management);?>:</strong></span>
                    <span class="selected_room_container_adults"></span>,
                    <span class="bold"><strong><?php _e('Kids', $this->cloudbeds_hotel_management);?>:</strong></span>
                    <span class="selected_room_container_kids"></span>
                </div>
                <div class="omrow">
                    <div class="short_info checkin_container omgrid_7"><strong><?php _e('Arrival Date', $this->cloudbeds_hotel_management);?>:</strong></div>
                    <div class="short_info2 omgrid_5 text-right">
                        <span class="checkin_date"></span>
                    </div>
                </div>
                <div class="omrow">
                    <div class="short_info nights_container omgrid_7"><strong><?php _e('Departure Date', $this->cloudbeds_hotel_management);?>:</strong></div>
                    <div class="short_info2 omgrid_5 text-right">
                        <span class="checkout_date"></span>
                    </div>
                </div>
                <div class="omrow">
                    <div class="short_info nights_container omgrid_7"><strong><?php _e('Room Nights', $this->cloudbeds_hotel_management);?>:</strong></div>
                    <div class="short_info2 omgrid_5 text-right">
                        <span class="nights_int"></span>
                    </div>
                </div>
                <hr class="grey_line">

                <div class="taxas">
                    <div class="omrow">
                        <div class="l1 omgrid_8">
                            <p><?php _e('Room Total', $this->cloudbeds_hotel_management);?>:</p>
                        </div>

                        <div class="r1 omgrid_4">
                            <p class="total_value"></p>
                        </div>
                    </div>

                    <div class="omrow">
                        <div class="sub_tax_row l1 omgrid_8">
                            <p><?php _e('Tax', $this->cloudbeds_hotel_management);?>:</p>
                        </div>

                        <div class="r1 omgrid_4">
                            <p class="sub_tax"><?php _e('Included', $this->cloudbeds_hotel_management);?></p>
                        </div>
                    </div>

                    <div class="omrow">
                        <div class="sub_fees_row l1 omgrid_8">
                            <p><?php _e('Hotel Fees', $this->cloudbeds_hotel_management);?>:</p>
                        </div>

                        <div class="r1 omgrid_4">
                            <p class="sub_fees"></p>
                        </div>
                    </div>

                    <hr class="grey_line valor">

                    <div class="omrow">
                        <div class="l1 omgrid_8">
                            <p>
                                <span class="grand_total_label bold">*<?php _e('Grand Total', $this->cloudbeds_hotel_management);?>:</span>
                            </p>
                        </div>

                        <div class="r1 omgrid_4">
                            <p class="grand_total bold"></p>
                        </div>
                    </div>

                    <hr class="grey_line valor">

                    <div class="omrow">
                        <div class="l1 omgrid_8">
                            <p><?php _e('Advance amount', $this->cloudbeds_hotel_management);?>:</p>
                        </div>

                        <div class="r1 omgrid_4">
                            <p class="total_deposit"></p>
                        </div>
                    </div>

                    <hr class="grey_line valor">
                </div>

            </div>

        </div>

        <div style="clear:both;"></div>

    </div>

</div>


<div id="reservation_confirmation"></div>