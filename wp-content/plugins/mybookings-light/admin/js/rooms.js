function renderMediaUploader(a,b){"use strict";var c,d;return void 0!==c?void c.open():(c=wp.media.frames.file_frame=wp.media({title:"Upload Image",button:{text:"Insert Image"},multiple:!1}),c.on("insert",function(){}),c.on("select",function(){d=c.state().get("selection").first().toJSON(),a.closest(".room_images").find('input[name*="room_images[]"]').val(d.url).end().find(".room_img").css({backgroundImage:"url("+d.url+")"}).html('<div class="image_editor_box"><a href="JavaScript:void(0)" class="'+b+'_cb_hm_change_image cb_hm_change_image">change</a><a href="JavaScript:void(0)" class="'+b+'_cb_hm_remove_image cb_hm_remove_image"><i class="fa fa-trash"></i></a></div>');for(var e in d);}),void c.open())}!function(a){"use strict";jQuery(document).on("click","."+cb_hm_ajaxobj_rooms.name+"_cb_hm_upload_image_button, ."+cb_hm_ajaxobj_rooms.name+"_cb_hm_change_image",function(a){a.preventDefault();var b=jQuery(this);renderMediaUploader(b,cb_hm_ajaxobj_rooms.name)}),jQuery(document).on("click","."+cb_hm_ajaxobj_rooms.name+"_cb_hm_remove_image",function(a){a.preventDefault(),jQuery(this).closest(".room_images").find("input.uploadfield").val(""),jQuery(this).closest(".room_img").css({backgroundImage:"none"}).html('<a href="javscript:void(0)" class="'+cb_hm_ajaxobj_rooms.name+'_cb_hm_upload_image_button cb_hm_uploader"></a>')})}(jQuery);