function cloudbedsajax(a,b,c,d,e,f){if("yes"==f)var g=cb_hm_front_ajaxobj.name+"_api_search";else var g=cb_hm_front_ajaxobj.name+"_search";var h={action:g,id:b,datefrom:c,dateto:d,dateformat:e};jQuery.post(cb_hm_front_ajaxobj.url,h,function(b){jQuery("#"+a).html(b).removeClass("cloudbeds_loading")})}function country_selector_changes(){"BR"==jQuery(".country_selector").val()?(jQuery("div.data").show(),jQuery("div.cpp").show(),jQuery("div.sexo").show(),jQuery("div.telefone").show(),jQuery("div.telefone input").addClass("required"),jQuery("div.celular").show(),jQuery("div.celular input").addClass("required"),jQuery("div.hear_about").show(),jQuery("div.rua").show(),jQuery("div.rua input").addClass("required"),jQuery("div.numero").show(),jQuery("div.numero input").addClass("required"),jQuery("div.complemento").show(),jQuery("div.bairro").show(),jQuery("div.bairro input").addClass("required"),jQuery("div.cidade").show(),jQuery("div.cidade input").addClass("required"),jQuery("div.estado").show(),jQuery("div.cep").show(),jQuery("hr.hide_line").show(),jQuery("div.rg").show(),jQuery("div.data_emissao").show(),jQuery("div.orgao").show(),jQuery("div.estade_emissao").show(),jQuery("div.radio_block").show(),jQuery("div.zip_foreign").hide()):(jQuery("div.data").hide(),jQuery("div.data.de").show(),jQuery("div.cpp").hide(),jQuery("div.telefone input").removeClass("required error"),jQuery("div.celular input").removeClass("required error"),jQuery("div.rua input").removeClass("required error"),jQuery("div.numero input").removeClass("required error"),jQuery("div.bairro input").removeClass("required error"),jQuery("div.cidade input").removeClass("required error"),jQuery("div.estado").hide(),jQuery("div.cep").hide(),jQuery("hr.hide_line").hide(),jQuery("div.rg").hide(),jQuery("div.data_emissao").hide(),jQuery("div.orgao").hide(),jQuery("div.estade_emissao").hide(),jQuery('input[name="payment_method"][value="cards"]').click(),jQuery("div.radio_block").hide(),jQuery("div.zip_foreign").show(),jQuery("a.userAgreementLink").click(function(a){a.preventDefault(),jQuery(".black_popup_overlay").show(),jQuery(".terms_popup").show()}),jQuery("img.close_popup").click(function(a){a.preventDefault(),jQuery(".black_popup_overlay").hide(),jQuery(".terms_popup").hide()}))}jQuery(function(a){OMBooking={init:function(b,c,d,e,f,g,h,j,k,l,m,n,o,p,q,r,s,t,u,v,w,z,A,B,C,D,E,F,G,H,I,J,K,L,M,N,O,P,Q,R,S,T,U,V){function X(b){var b=jQuery(b);if(jQuery("#roomsavailability").html('<div class="room_container"><div class="cloudbeds_loading"></div></div>'),"yes"==V)var c=cb_hm_front_ajaxobj.name+"_api_checkroomavailability";else var c=cb_hm_front_ajaxobj.name+"_checkroomavailability";var d={action:c};return jQuery.ajax({url:cb_hm_front_ajaxobj.url,data:b.serialize()+"&"+a.param(d),method:"post",beforeSend:function(){},success:function(a){jQuery("#roomsavailability").html(a),Z()},error:function(){jQuery("#roomsavailability").html("Error ! Checking Rooms Availability Try Again.")}}),!1}function Y(b){var c=a(b).get(0);a.removeData(c,"validator"),a(b).validate({errorPlacement:function(b,c){var d=a(c);b.is(":empty")?(d.qtip("destroy"),d.removeAttr("error-message")):(d.attr("error-message",b.html()),b.appendTo(c.parent()))},success:a.noop,rules:{cpf:{cpf:!0},zip:{cep:!0},search_start_date:{ofdate:!0},card_number:{cc:!0},cvv:{cvv:!0},exp_month:{ccdate:!0},exp_year:{ccdate:!0}}})}function Z(){jQuery(".cloudbeds_container .info_about_rooms").hide(),W.initGallery(!1)}function $(a,b,c){var d="",f=a;isNaN(a)&&(f=0);for(var g=f;b>=g;g++)d+='<option value="',d+=g==f&&isNaN(a)?'"':g+'"',c&&g==c&&(d+=' selected="selected"'),d+=">",d+=g==f?a:g,d+="</option>";return d}function _(a,b){if(b){var c="left center",d="right center",e=0;a.hasClass("ebanking")&&(c="right center",d="left center",e=7),a.filter(":not(.valid)").qtip({overwrite:!1,content:b,position:{my:c,at:d,viewport:!1,adjust:{y:e}},show:{event:"click",solo:!0},hide:!1,style:{classes:"qtip-blue"}}).qtip("option","content.text",b)}}function aa(a,b){a.stop().slideUp("slow",function(){void 0!=b&&b()}),void 0!=b&&b()}function ba(a,b){a.stop().slideDown("slow",function(){void 0!=b&&b()}),void 0!=b&&b()}function ca(b){var c=b.closest("tr").data("id")+"",d=c.split("-"),e=a('tr.room_type_row[data-id="'+d[0]+'"], tr.room_type_row[data-id^="'+d[0]+'-"]',"table.rooms"),f=parseInt(e.index(b.closest("tr"))),g=[],h=0,i=0;e.each(function(b){a(this).is('[data-package="0"]')&&(i=+a('[name="qty_rooms['+d[0]+']"]',this).data("max_rooms"));var c=+(a('[name^="qty_rooms['+d[0]+'"]',this).val()||0);g.push(c),h+=c,f!=b&&a('[name^="qty_rooms['+d[0]+'"]>option',this).remove()}),i-=h,e.each(function(b){var c=a('[name^="qty_rooms['+d[0]+'"]',this),e=parseInt(c.attr("data-max_rooms"));e=i>0?g[b]+i:g[b],f!=b&&a('[name^="qty_rooms['+d[0]+'"]',a(this)).html($(0,5>e?e:5)),c.val(g[b])})}function da(){for(var b=["#c6e1ff","#white"],c=0;7>c;c++)a(".segura").animate({backgroundColor:b[c%2]},300)}function ea(a,b){var c=ka(a),d=c.standardDate;c=c.convertedDate;var e=ka(b),f=e.standardDate;e=e.convertedDate;var g=ma(f,"/"),h=new Date(g[0],g[1],g[2]).getTime(),i=ma(d,"/"),j=new Date(i[0],i[1],i[2]).getTime();return parseInt((h-j)/864e5)}function fa(b){var c=0,d=0,e=0,f=0,g=0,h=a("#reservationDetailsForm"),k=(a('input[name="search_start_date"]').val(),a('input[name="search_end_date"]').val(),a(".selected_room_container"));a('input[name$="selected_"]',h).remove(),a(".short_info2",k).remove(),a("select[name^='qty_rooms[']").each(function(b,i){var j=a(i).val();if(g+=parseInt(j),j>0){for(var l=a(i).closest(".room_type_row"),m=l.data("id"),n=a('select[name^="adults["]',l).val(),o=a('select[name^="kids["]',l).val(),p=ja(l.data("val")),q=l.data("adults"),r=l.data("kids"),s=ja(l.data("add-adults")),t=ja(l.data("add-kids")),u=l.data("name"),x=p,y=0;j>y;y++){n>q&&(x+=s*(n-q)),o>r&&(x+=t*(o-r));var B=1e-4,C=0,D=0;if("percent"==v)C=parseFloat(w*A*x+B).toFixed(2),D=parseFloat(w*x+B).toFixed(2);else{var E=a(".nights_count").text();D=z*E>x?x:z*E}e+=parseFloat(C)+parseFloat(D),f+=A*x,d+=parseFloat(x)}c+=j;var F='<p class="short_info2">'+u+" (x"+j+') <br /> <span class="bold">Adultos:</span>'+n+',  <span class="bold">Crian\xc3\xa7as:</span>'+o+"</p>";k.append(F),h.append('<input type="hidden" name="selected_room_qty['+m+']" value="'+j+'" />'),h.append('<input type="hidden" name="selected_adults['+m+']" value="'+n+'" />'),h.append('<input type="hidden" name="selected_kids['+m+']" value="'+o+'" />'),jQuery.each(l.find(".roomrateid"),function(){var a=jQuery(this);h.append('<input type="hidden" name="'+a.attr("name")+'" value="'+a.attr("value")+'" />')})}}),d>0?(a(".segura .compra_rooms span.roomsCount").text(g),a(".segura .compra_price").text(ia(d)),a(".segura .compra_notice").removeClass("omhide"),a(".segura .compra_rooms").removeClass("omhide"),a(".segura .compra").removeClass("omhide").addClass("omhide")):ga()}function ga(){a(".segura .compra_price").text(""),a(".segura .compra_notice").removeClass("omhide").addClass("omhide"),a(".segura .compra_rooms").removeClass("omhide").addClass("omhide"),a(".segura .compra").removeClass("omhide")}function ia(a){var b=String(a);if(-1!=b.indexOf(d.currency_symbol))return a;b=String(parseFloat(b).toFixed(2)),b=b.replace(".",d.mon_decimal_point);var c=!1;if(0==b.indexOf("-")&&(c=!0,b=b.replace("-","")),b.length>6){b=b.split(d.mon_decimal_point);for(var e=b[0].length-3*parseInt(b[0].length/3),f=0==e?"":b[0].substr(0,e)+d.mon_thousands_sep,g=e;g<b[0].length;g+=3)f+=b[0].substr(g,3)+d.mon_thousands_sep;b=f.substr(0,f.length-1)+d.mon_decimal_point+b[1]}return"before"==d.currency_position?(c?"- ":"")+d.currency_symbol+" "+b:(c?"- ":"")+b+d.currency_symbol}function ja(a){var b=String(a);return-1==b.indexOf(d.currency_symbol)?b:(b=b.replace(d.currency_symbol+" ",""),b=b.replace(d.mon_thousands_sep,""),b=b.replace(d.mon_decimal_point,"."),parseFloat(parseFloat(b).toFixed(2)))}function ka(b){var c=d.date_format_DP,e=!0,f=b.split("/");try{f[2]<100&&f[2]>=13&&(f[2]="20"+f[2],b=f.join("/")),a.datepicker.parseDate(c,b)}catch(g){if(2==f.length){f[2]=(new Date).getFullYear(),b=f.join("/");try{a.datepicker.parseDate(c,b)}catch(g){e=!1}}else e=!1}if(e){var h=new Date((new Date).getFullYear(),(new Date).getMonth(),(new Date).getDate()),i=new Date(f[2],f[0]-1,f[1]);"dd/mm/yy"==d.date_format_DP&&(i=new Date(f[2],f[1]-1,f[0])),h>i&&(e=!1)}var j={},k=null;return j.result=e,j.convertedDate=b,"dd/mm/yy"==c?(j.standardDate=f[2]+"/"+f[1]+"/"+f[0],k=new Date(f[2],f[1]-1,f[0]),j.sameDate=k&&k.getMonth()+1==f[1]&&k.getDate()==Number(f[0])):(j.standardDate=f[2]+"/"+f[0]+"/"+f[1],k=new Date(f[2],f[0]-1,f[1]),j.sameDate=k&&k.getMonth()+1==f[0]&&k.getDate()==Number(f[1])),j}function la(){var b=a('select[name="exp_year"]'),c=a('select[name="exp_month"]'),d=b.val(),e=c.val(),f=new Date(d,e-1,1,0,0,0),g=new Date;return f>g?(b.parent().removeClass("error").addClass("valid"),c.parent().removeClass("error").addClass("valid")):(b.parent().removeClass("valid").addClass("error"),c.parent().removeClass("valid").addClass("error")),f>g}function ma(a,b){b=b||"-";var c=a.split(b);return[c[0],parseInt(c[1])-1,c[2]]}function na(a){var b=a.split("/"),c=b[0],e=b[1],f=b[2],g=new Date(f+"/"+c+"/"+e);return"dd/mm/yy"==d.date_format_DP&&(g=new Date(f+"/"+e+"/"+c)),g}function oa(a,b){var c=a.getDate(),d=a.getMonth()+1,e=a.getFullYear();return 10>c&&(c="0"+c),10>d&&(d="0"+d),b.replace("yy",e).replace("mm",d).replace("dd",c)}function pa(){var b=new Date(k),c=new Date(l),e=a("input[name='search_start_date']").first().val();if(e)var f=na(e);a("input[name='search_start_date']").each(function(b,c){var d=na(a(c).val());f>d&&(f=d)});var g=a('input[name="payment_method"]:checked').val(),h=a('input[name="payment_method"][value="boleto"]'),i=a('input[name="payment_method"][value="ebanking"]'),j=a('input[name="payment_method"][value="cards"]'),m=a(".boleto_wrapper > .boleto"),n=q+"<br /><strong>Data limite:</strong> "+oa(b,d.date_format_DP),o=a(".r2 > .ebanking"),p=r+"<br /><strong>Data limite:</strong> "+oa(c,d.date_format_DP),s=a(".r2 > .visa");return m.qtip("destroy"),o.qtip("destroy"),b>=f?(h.attr("disabled","disabled"),"boleto"==g&&j.click(),_(m,n),m.hide()):(h.removeAttr("disabled"),m.qtip("destroy"),m.show()),c>=f?(i.attr("disabled","disabled"),"ebanking"==g&&j.click(),_(o,p),o.hide(),s.show()):(i.removeAttr("disabled"),o.qtip("destroy"),o.show(),s.show()),!0}function pa(){var b=new Date(k),c=new Date(l),e=a("input[name='search_start_date']").first().val();if(e)var f=na(e);a("input[name='search_start_date']").each(function(b,c){var d=na(a(c).val());f>d&&(f=d)});var g=a('input[name="payment_method"]:checked').val(),h=a('input[name="payment_method"][value="boleto"]'),i=a('input[name="payment_method"][value="ebanking"]'),j=a('input[name="payment_method"][value="cards"]'),m=a(".boleto_wrapper > .boleto"),n=q+"<br /><strong>Data limite:</strong> "+oa(b,d.date_format_DP),o=a(".r2 > .ebanking"),p=r+"<br /><strong>Data limite:</strong> "+oa(c,d.date_format_DP),s=a(".r2 > .visa");return m.qtip("destroy"),o.qtip("destroy"),b>=f?(h.attr("disabled","disabled"),"boleto"==g&&j.click(),_(m,n),m.hide()):(h.removeAttr("disabled"),m.qtip("destroy"),m.show()),c>=f?(i.attr("disabled","disabled"),"ebanking"==g&&j.click(),_(o,p),o.hide(),s.show()):(i.removeAttr("disabled"),o.qtip("destroy"),o.show(),s.show()),!0}a("body").addClass("cb_hm_frontend cb_hm_api");var W=this;""!=D&&X(U),d.date_format_DP=d.date_format.replace("y","yy").replace("Y","yy").replace("m","mm").replace("d","dd"),a(".ofdate").datepicker({defaultDate:"+0",dateFormat:d.date_format_DP,minDate:"+0",onSelect:function(b,c){var e=a.datepicker.parseDate(c.settings.dateFormat,b);e.setDate(e.getDate()+1),a(this).is('input[name="search_start_date"]')&&a('input[name="search_end_date"]').val(a.datepicker.formatDate(d.date_format_DP,e))},onClose:function(b){if(a(this).is('input[name="search_start_date"]')){var c=a('input[name="search_start_date"]').datepicker("getDate"),d=new Date(c.getFullYear(),c.getMonth(),c.getDate()+1);a('input[name="search_end_date"]').datepicker("option","minDate",d),a('input[name="search_end_date"]').datepicker("refresh").datepicker("show")}}}),a(document).on("click",".cloudbedssearch",function(b){b.preventDefault();var c=jQuery(this).closest("form");a('input[name="search_start_date"]').val(),a('input[name="search_end_date"]').val();X(c)}),jQuery(document).on("change",'select[name^="adults["]',function(){var a=jQuery(this),b=a.closest("tr"),c=jQuery('select[name^="kids["]',b),d=b.data("max"),e=c.val(),f=a.val(),g=$(0,d-f,e);c.html(g),da(),Z(),fa(a)}),a(document).on("mouseover mouseout",".room_name_container",function(b){"mouseover"==b.type?a(".stay",this).removeClass("omhide"):a(".stay",this).addClass("omhide")}),a(document).on("mouseover mouseout",".avg_rate_container",function(b){"mouseover"==b.type?a(".stay.detailed_rates",this).removeClass("omhide"):a(".stay.detailed_rates",this).addClass("omhide")}),a(document).on("click",".name_room",function(b){b.preventDefault();var c=a(this),d=c.hasClass("for_minus"),e=c.closest(".room_type_row");if(a(".name_room").removeClass("for_minus").addClass("for_plus"),e.siblings(".info_about_rooms").find(".room_details_container").hide(),e.siblings(".info_about_rooms").hide(),!d){var f=a(".tab_info2 > div",e.next(".info_about_rooms")),g=0;f.each(function(b,c){var d=a(c).clone();d.css({opacity:0,position:"absolute",top:0,"max-width":769}).appendTo("body");var e=d.height();e>g&&(g=e),d.remove()}),c.removeClass("for_plus").addClass("for_minus"),e.next(".info_about_rooms").show(),e.next(".info_about_rooms").find(".room_details_container").show()}}),a(document).on("click","ul.room_type_tabs li",function(){var b=a(this).closest(".info_about_rooms"),c=a("ul.room_type_tabs li",b),d=a(this).index(),e=c.length-1;d>0&&e>d&&(d--,c.removeClass("active"),a(this).addClass("active"),a(".tab_info2 > div",b).removeClass("active"),a(".tab_info2 > div:eq("+d+")",b).addClass("active"))}),a(document).on("change",'select[name^="qty_rooms["]',function(){var b=a(this),c=0;a('select[name^="qty_rooms"]').each(function(b,d){c+=a(d).val()}),a(".best_price").toggle(c>0),ca(a(this)),da(),fa(b)}),a(document).on("click",".book_now",function(){var b=0,c=0,d=0,e=0,f=0,g=0,h=a("#reservationDetailsForm"),i=a('input[name="search_start_date"]').val(),j=a('input[name="search_end_date"]').val(),k=a(".selected_room_container");if(a('input[name$="selected_"]',h).remove(),a(".short_info2",k).remove(),a("select[name^='qty_rooms[']").each(function(i,j){var l=a(j).val();if(l>0){for(var m=a(j).closest(".room_type_row"),n=m.data("id"),o=a('select[name^="adults["]',m).val(),p=a('select[name^="kids["]',m).val(),q=ja(m.data("val")),r=m.data("adults"),s=m.data("kids"),t=ja(m.data("add-adults")),u=ja(m.data("add-kids")),x=m.data("name"),y=q,A=1e-4,B=0;l>B;B++){o>r&&(y+=t*(o-r)),p>s&&(y+=u*(p-s));var C=0,D=0;if("percent"==v)"Y"==G&&"percent"==H&&(C+=parseFloat(parseFloat(w*I*y+A).toFixed(2))),"Y"==K&&"percent"==L&&(C+=parseFloat(parseFloat(w*M*y+A).toFixed(2))),D=parseFloat(w*y+A).toFixed(2);else{var E=a(".nights_count").text();D=z*E>y?y:z*E}d+=parseFloat(C)+parseFloat(D),c+=parseFloat(y)}if("percent"==v){var F=0;"Y"==G&&"fixed"==H&&(F+=J),"Y"==K&&"fixed"==L&&(F+=N),d+=parseFloat(parseFloat(w*F+A).toFixed(2))}"Y"==G&&(f="percent"==H?c*I:J),"Y"==K&&(g="percent"==L?c*M:N),e=parseFloat(f.toFixed(2))+parseFloat(g.toFixed(2)),b+=l;var O=a(".clonable_for_selected_room_container").clone().removeClass("omhide clonable_for_selected_room_container");a(".selected_room_container_name",O).html(x),a(".selected_room_container_selected_count",O).html(l),a(".selected_room_container_adults",O).html(o),a(".selected_room_container_kids",O).html(p),k.append(O),h.append('<input type="hidden" name="selected_room_qty['+n+']" value="'+l+'" />'),h.append('<input type="hidden" name="selected_adults['+n+']" value="'+o+'" />'),h.append('<input type="hidden" name="selected_kids['+n+']" value="'+p+'" />'),h.append('<input type="hidden" name="selected_room_name['+n+']" value="'+x+'" />'),h.append('<input type="hidden" name="selected_room_total['+n+']" value="'+y+'" />')}}),0==b)return void alert(p);var l=ea(i,j);a(".checkin_date").text(i),a(".checkout_date").text(j),a(".nights_int").text(l),a(".total_value").text(ia(c)),"Y"==G&&a(".sub_tax").text(ia(f)),"Y"==K?a(".sub_fees").text(ia(g)):a(".sub_fees_row").remove(),Y(a("#reservationDetailsForm")),pa(),a(".total_taxes").text(ia(e)),a(".total_deposit").text("0"),a(".total_checkin").text(ia(c+e)),a(".grand_total").text(ia(c+e)),h.append('<input type="hidden" name="selected_checkin" value="'+i+'" />'),h.append('<input type="hidden" name="selected_checkout" value="'+j+'" />'),h.append('<input type="hidden" name="total_advance" value="'+d+'" />'),h.append('<input type="hidden" name="grand_total" value="'+(c+e)+'" />'),country_selector_changes(),aa(a(".chooser"),function(){aa(a(".search_panel"),function(){ba(a(".suas"),function(){a(this).attr("height","auto"),a("#cb_hm_progress").find(".cb_hm_c:eq(0)").removeClass("active").addClass("done"),a("#cb_hm_progress").find(".cb_hm_c:eq(1)").addClass("active"),a(".change_reserve").slideDown(300),a("#reservationDetailsForm").validate({ajaxSubmit:function(a){}})})})})}),a(document).on("change",".country_selector",function(a){country_selector_changes()}),a(document).on("click",".finalizecentral",function(b){b.preventDefault();var c=a(this),d=c.closest("form");if(d.valid()){var e={action:cb_hm_front_ajaxobj.name+"_reservation"};a.ajax({url:cb_hm_front_ajaxobj.url,type:"POST",beforeSend:function(){c.attr("disabled","disabled"),a("#roomsavailability").append('<span class="ajaxloader" />'),a("html, body").stop().animate({scrollTop:a("#roomsavailability").position().top},500,"swing")},data:d.serialize()+"&"+a.param(e),success:function(b){a("#roomsavailability").find(".ajaxloader").remove(),c.removeAttr("disabled"),-1!=b.indexOf("--ERROR--")?(a("#cb_hm_progress").find(".cb_hm_c").removeClass("active").addClass("active"),a("#reservationresponse").html(b)):a("#roomsavailability").html(b)},error:function(b){a("#roomsavailability").find(".ajaxloader").remove(),c.removeAttr("disabled")}})}else a("#reservationDetailsForm").find(".error:eq(0)").focus()}),a('select[name="hear_about"]').change(function(){"Other"!=a(this).val()?a(".hear_other_how").addClass("omhide"):a(".hear_other_how").removeClass("omhide")}),jQuery.validator.addMethod("cvv",function(a){if(!s)return!0;var b=0;switch(s){case"amex":b=4;break;default:b=3}var c=new RegExp("[0-9]{"+b+"}");return a.length==b&&c.test(a)},"CVV invalid, please check the data reported"),jQuery.validator.addMethod("cc",function(a){a=a.replace(/-/g,""),a=a.replace(/ /g,""),a=a.replace(/\./g,"");var c,d,e,f,g,h,i,j,k,b=[].indexOf||function(a){for(var b=0,c=this.length;c>b;b++)if(b in this&&this[b]===a)return b;return-1};return e=[{name:"amex",pattern:/^3[47]/,valid_length:[15]},{name:"diners_club_carte_blanche",pattern:/^30[0-5]/,valid_length:[14]},{name:"diners_club_international",pattern:/^36/,valid_length:[14]},{name:"jcb",pattern:/^35(2[89]|[3-8][0-9])/,valid_length:[16]},{name:"laser",pattern:/^(6304|670[69]|6771)/,valid_length:[16,17,18,19]},{name:"visa_electron",pattern:/^(4026|417500|4508|4844|491(3|7))/,valid_length:[16]},{name:"visa",pattern:/^4/,valid_length:[16]},{name:"mastercard",pattern:/^5[1-5]/,valid_length:[16]},{name:"maestro",pattern:/^(5018|5020|5038|6304|6759|676[1-3])/,valid_length:[12,13,14,15,16,17,18,19]},{name:"discover",pattern:/^(6011|622(12[6-9]|1[3-9][0-9]|[2-8][0-9]{2}|9[0-1][0-9]|92[0-5]|64[4-9])|65)/,valid_length:[16]}],f=function(a){var b,f,g;for(g=function(){var a,b,d;for(d=[],a=0,b=e.length;b>a;a++)c=e[a],d.push(c);return d}(),b=0,f=g.length;f>b;b++)if(d=g[b],a.match(d.pattern))return d;return null},h=function(a){var b,c,d,e,f,g;for(d=0,g=a.split("").reverse(),c=e=0,f=g.length;f>e;c=++e)b=g[c],b=+b,c%2?(b*=2,d+=10>b?b:b-9):d+=b;return d%10===0},g=function(a,c){var d;return d=a.length,b.call(c.valid_length,d)>=0},k=function(a){var b,c;return d=f(a),c=!1,b=!1,null!=d&&(c=h(a),b=g(a,d)),d&&c&&b?(s=d.name,!0):!1},j=function(){var b=a.replace(/[ .-]/g,"");return k(b)},i=function(a){},j()},"Card not valid, please check the data reported"),jQuery.validator.addMethod("ccdate",function(){return la()},"Invalid date, please check the data reported"),a.validator.addMethod("cpf",function(a,b){if(0==a.length)return!0;for(a=jQuery.trim(a),a=a.replace(".",""),a=a.replace(".",""),cpf=a.replace("-","");cpf.length<11;)cpf="0"+cpf;var c=/^0+$|^1+$|^2+$|^3+$|^4+$|^5+$|^6+$|^7+$|^8+$|^9+$/,d=[],e=new Number,f=11;for(i=0;i<11;i++)d[i]=cpf.charAt(i),i<9&&(e+=d[i]*--f);for((x=e%11)<2?d[9]=0:d[9]=11-x,e=0,f=11,y=0;y<10;y++)e+=d[y]*f--;(x=e%11)<2?d[10]=0:d[10]=11-x;var g=!0;return(cpf.charAt(9)!=d[9]||cpf.charAt(10)!=d[10]||cpf.match(c))&&(g=!1),this.optional(b)||g},"Invalid date, please check the data reported"),a.validator.addMethod("cep",function(a,b){if(0==a.length)return!0;if(a=jQuery.trim(a),a=a.replace(" ",""),a=a.replace(".",""),a=a.replace("-",""),8!=a.length)return!1;for(var c=""+parseInt(a,10);c.length<8;)c="0"+c;return c==a?!0:!1},"Invalid date, please check the data reported"),this.initGallery(!1),a(document).on("focus","form input.error, form select.error",function(){var b=a(this);b.attr("error-message")})},showPopup:function(b){a(".popup").hide(),a(".popup."+b).show(),a(".modal-overlay").show("fade")},hidePopup:function(){a(".modal-overlay").hide("fade",function(){a(".popup").hide()})},initGallery:function(b){jQuery(".tabGallery").each(function(){jQuery(this).magnificPopup({delegate:"a",type:"image",gallery:{enabled:!0}})}),a(document).on("click",".room_photo div",function(a){a.preventDefault(),jQuery(this).closest("tr").next(".info_about_rooms").find(".tabGallery a:eq(0)").trigger("click")})}}}),WebFontConfig={google:{families:["Roboto:400,100,100italic,300,400italic,700,700italic:latin"]}},function(){var a=document.createElement("script");a.src=("https:"==document.location.protocol?"https":"http")+"://ajax.googleapis.com/ajax/libs/webfont/1/webfont.js",a.type="text/javascript",a.async="true";var b=document.getElementsByTagName("script")[0];b.parentNode.insertBefore(a,b)}();