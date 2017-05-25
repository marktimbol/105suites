Handlebars.registerHelper("ifvalue",function(a,b){return b.hash.value===a?b.fn(this):b.inverse(this)}),Handlebars.registerHelper("formathtml",function(a){return new Handlebars.SafeString(a)});var cb_hm_ajax_commonmessage='<div class="cb_hm_ajax_message_container"> {{#if status}} <span class="cb_hm_{{status}}"></span> {{/if}} {{formathtml message}}</div>',roomrates='<table id="rate-table" class="rate-table table table-condensed"> <thead> <tr class="monthhead"> <th colspan="2"></th> {{#each months}} <th colspan="{{colspan}}">{{title}}</th> {{/each}} </tr> <tr class=""> <th colspan="2"> <a href="javascript:void(0)" class="calendar-prev btn btn-warning"><i class="fa fa-chevron-left"></i></a> <a href="javascript:void(0)" class="calendar-next btn btn-warning"><i class="fa fa-chevron-right"></i></a> </th> {{#each days}} <th>{{title}}, {{value}}</th> {{/each}} </tr> </thead> <tbody> {{#each roomrate}} <tr> <td class="roomname">{{title}}</td> <td class="roomrate"> <label>Rooms</label> <label>Rate(rooms)</label> </td> {{#each rates}} <td> <input type="text" class="form-control" name="rooms[{{../roomid}}][{{day}}]" placeholder="0" value="{{available}}" /> <input type="text" class="form-control" name="rates[{{roomid}}][{{day}}]" placeholder="0" value="{{price}}" /> </td> {{/each}} </tr> {{/each}} </tbody> </table>';