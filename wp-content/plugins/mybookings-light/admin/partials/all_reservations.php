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
 * @template   All Reservations Template
 */
?>
<div class="cb_hm wrap">

    <h2>Reservations</h2> 

    <div ng-app="searchallBooking" id="ngappdiv" class="displaynone">

    <div ng-controller="resultsCtlall">

              <div class="row">

              <div class="col-md-12">

              <div class="col-md-12">

                  <div class="search_panel">

                      <div class="center">

                          <div class="for_inputs">

                             <form onsubmit="return false;" method="POST" id="searchbookings"> 



                                    <div class="styled_label">

                                        Arrival From                       

                                    </div>

                                    <div class="styled_input">

                                        <input type="text" value="<?php echo date('d/m/Y', strtotime('-30days')) ;?>" name="booking_date_from" class="datas ofdate required" placeholder="<?php echo date('d/m/Y', strtotime('-30days')) ;?>" id="booking_date_from">

                                    </div>

                                    <div class="styled_label">

                                        Arrival To                    

                                    </div>

                                    <div class="styled_input">

                                        <input type="text" value="<?php echo date('d/m/Y', strtotime('+1day')) ;?>" name="booking_date_to" class="datas_end ofdate required" placeholder="<?php echo date('d/m/Y',strtotime('+1day') ) ;?>" id="booking_date_to">

                                    </div>



                                    <div class="styled_button text_align_right">

                                        <input type="submit" class="bookingsearch" value=" Filter Reservations " ng-click="search_bookings()">

                                        <!--input type="submit" class="downloadcsv" value="Download CSV"-->

                                    </div>

                                </form>





                          </div>

                      </div> 

                    </div>

              </div> 

            </div>

            </div>

             <div class="clearfix row">  

                   <div class="col-md-12">  

                        <div class="block block_1" ng-show="totalfound > 0"> 

                            <div class="block_head" >
                                <h2>  Reservation results </h2>
                            </div>

                            <div class="block_content tab_content" style="display: block;" >  

                                    <table border="0" width="100%" cellpadding="4" cellspacing="0">

                                        <thead ng-show="results.length" style="display:none">

                                            <tr> 
                                                  <th style="width: 200px;"> Reservation Ref ID  </th>

                                                  <th>Search by name</th>

                                                  <th style="width: 80px;" class="text-center">Arriving (DD/MM/YY)</th>

                                                  <th style="width: 80px;" class="text-center">Departing (DD/MM/YY)</th>

                                                  <th style="width: 50px;" class="text-center">Nights</th>

                                                  <th>Price</th>

                                                  <th style="width: 50px;" class="text-center">Qty</th>

                                                  <th>Total</th> 

                                                  <th>Order  (YY-MM-DD HH:min:sec)</th> 

                                                  <th style="width: 80px;" class="text-center">Status</th> 

                                            </tr>

                                        </thead>

                                        <tbody ng-show="results.length">    

                                                <tr>
                                                  <td> <input type="input" class="filterinput" ng-model="search.booking_ref" value="" placeholder="" /></td>

                                                  <td> <input type="input" class="filterinput" ng-model="search.customer" value="" placeholder="" /></td>

                                                  <td> <input type="input" class="filterinput" ng-model="search.arriving" value="" placeholder="" /></td>

                                                  <td> <input type="input" class="filterinput" ng-model="search.departing" value="" placeholder="" /></td>

                                                  <td> <input type="input" class="filterinput" ng-model="search.nights" value="" placeholder="" /></td>

                                                  <td>  </td>

                                                  <td> <input type="input" class="filterinput" ng-model="search.roomquantity" value="" placeholder="" /></td>

                                                  <td> </td>

                                                  <td> <input type="input" class="filterinput" ng-model="search.order_time" value="" placeholder="" /></td>

                                                 <?php /* <td> <input type="input" class="filterinput" ng-model="search.status" value="" placeholder="" /> </td>  */?>
                                                 <td> <select class="filterinput" ng-model="search.status" >
                                                    <option value=""> Any </option>
                                                    <option value="Initialize"> Initialize</option>
                                                    <option value="New Booking"> New Booking </option>
                                                    <option value="Confirmed"> Confirmed </option>
                                                    <option value="Cancelled"> Cancelled </option>
                                                    
                                                  </select> </td> 


                                                </tr> 
                      
                                                <tr ng-repeat="row in results | filter:search" class="result-row booking-row-{{row.table_tr_alt}}">  
                                                        <td>
                                                          <a class="{{showrowdata(row.same_ref_id)}} thickbox button button-primary btn btn-primary" href="<?php echo admin_url( 'admin-ajax.php' ) ;?>?action=<?php echo $this->cloudbeds_hotel_management;?>_view_bookings_info&ref={{row.booking_ref}}&amp;width=1030&amp;height=700" title="Reservation Info"> {{row.booking_ref}}</a>                                                           
                                                        </td> 

                                                        <td> {{row.customer}} </td> 

                                                        <td> {{row.arriving}} </td> 

                                                        <td> {{row.departing}} </td> 

                                                        <td> {{row.nights}}  </td> 

                                                        <td class="text-right"> <?php echo $cursym ;?>{{row.price}}  </td> 

                                                        <td> {{row.roomquantity}}  </td> 

                                                        <td class="text-right"> <?php echo $cursym ;?>{{row.qtprice}}  </td>  

                                                        <td> {{row.order_time}} </td>  

                                                        <td class="bookstatus book-ref-{{row.booking_ref}}"> <i class="fa {{row.class}}"></i> {{row.status}} </td>  

                                                </tr> 

                                        </tbody>

                                    </table>

                            </div>

                        </div>  

                    </div>

              </div>



  

        <div id="bookingloading" class="cb_hm_ajax_message" ng-show="searching > 0" style="display:none">
           <div class="cb_hm_ajax_message_container"><span class="cb_hm_loading"></span> Please Wait....</div>
        </div>







   <p class="info" ng-show="results.length">

       <small>* Status : init = Customer don't accest/Confirm Reservation.</small>

     

       <small> , New Reservation = Customer  Confirm Reservation.</small>

     

       <small> , : approved = Admin Approve Reservation.</small>

     

       <small> , : rejected = Admin Reject Reservation..</small>

    </p>





    </div> </div> 



 

      </div>