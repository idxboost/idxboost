!function(n){n(function(){function a(e){var a=e.find(".close");a.click(function(){a.closest(".active_modal").removeClass("active_modal"),n("html").removeClass("modal_mobile")})}jQuery("#modal_subscribe .close").click(function(){jQuery("html").removeClass("active_modal modal_mobile"),jQuery("#modal_subscribe").removeClass("active_modal")}),jQuery(".form_submit_button_search_desuscribe").click(function(e){var a=[],t=(n('input[name="notification_type_update_token[]"]:checked').each(function(){a.push(this.value)}),n("#input_update_name_search_token").val()),o=n(".token_alert_flo").val(),i=n(".notification_day_update_flo").val();jQuery.ajax({url:flex_idx_alerts_params.ajaxUrl,method:"POST",data:{action:"flex_update_search",type:"update",name:t,notification_day:i,notification_type:a,token_alert:o,search_count:1},dataType:"json",success:function(e){console.log(e),jQuery(".idxboost_footer_thank").show().ready(function(){jQuery(".idx_body_alert_unsubscribe").hide()})},complete:function(){jQuery("html").addClass("active_modal modal_mobile"),jQuery("#modal_subscribe").addClass("active_modal")}})}),n(".close.close-modal").click(function(e){a(n("#modal_update_search")),a(n("#modal_update_favorities"))}),jQuery("#input_update_name_search_token").change(function(){jQuery(".idxboost_edit_info_alert span").text(jQuery(this).val())}),jQuery(".modal_cm .close").click(function(){a(n("#modal_update_search")),a(n("#modal_update_favorities"))}),n("#form-update-alert-for-token").on("submit",function(e){e.preventDefault();var a=[],e=(n('input[name="notification_type_update_token[]"]:checked').each(function(){a.push(this.value)}),n("#input_update_name_search_token").val()),t=n(".token_alert_flo").val(),o=n(".notification_day_update_flo").val();jQuery.ajax({url:flex_idx_alerts_params.ajaxUrl,method:"POST",data:{action:"flex_update_search",type:"update",name:e,notification_day:o,notification_type:a,token_alert:t,search_count:1},dataType:"json",success:function(e){console.log(e)},complete:function(){jQuery(".idxboost_edit_info_alert").show().ready(function(){jQuery(".idxboost_subscribe").hide()})}})})})}(jQuery);