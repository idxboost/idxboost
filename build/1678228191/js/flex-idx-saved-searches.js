var activeli="";!function(r){r(function(){function l(t){t.hasClass("active_modal")?(r(".overlay_modal").removeClass("active_modal"),r("html, body").animate({scrollTop:0},1500)):(t.addClass("active_modal"),t.find("form").find("input").eq(0).focus(),r("html").addClass("modal_mobile")),i(t)}function i(t){var a=t.find(".close");a.click(function(){a.closest(".active_modal").removeClass("active_modal"),r("html").removeClass("modal_mobile")})}r(".flex-saved-search-remove").on("click",function(t){t.preventDefault();var a=r(this).attr("data-alert-token"),o=r(this);swal({title:word_translate.are_you_sure,text:word_translate.are_you_sure_you_want_to_remove_this_saved_search,type:"warning",showCancelButton:!0,confirmButtonColor:"#DD6B55",confirmButtonText:word_translate.yes_delete_it,closeOnConfirm:!1},function(){r.ajax({url:__flex_g_settings.ajaxUrl,method:"POST",data:{action:"flex_save_search",type:"remove",id:o.data("id"),search_url:o.data("search-url"),search_count:o.data("search-count"),token_alert:a},dataType:"json",success:function(t){swal({title:word_translate.deleted,text:word_translate.the_saved_search_has_been_removed_from_your_alerts,type:"success",timer:2e3,showConfirmButton:!1});var a=o.data("alert-token"),e=parseInt(r("#ib-saved-searches-cnt").html(),10);r('.flex-body[data-alert-token="'+a+'"]').hide().remove(),r("#ib-saved-searches-cnt").html(e-1)}})})}),r(".flex-table .flex-table-row .flex-table-row-item .info-sub-item .info-b .notify span").click(function(t){var a;activeli=this,r("#input_update_name_search").val(r(".flex_alert_cont_"+r(this).attr("posid")).attr("namesearch")),r(".token_alert").val(r(".flex_alert_cont_"+r(this).attr("posid")).attr("data-alert-token")),r(".notification_day_class_update").val(r(".flex_alert_cont_"+r(this).attr("posid")).attr("alertinterval")),r.each(r(".flex_alert_cont_"+r(activeli).attr("posid")).attr("alertnotifications").split(","),function(t,a){r("input[value='"+a+"']").prop("checked",!0)}),"yes"===__flex_g_settings.anonymous?(r("#modal_login").addClass("active_modal").find("[data-tab]").removeClass("active"),r("#modal_login").addClass("active_modal").find("[data-tab]:eq(1)").addClass("active"),r("#modal_login").find(".item_tab").removeClass("active"),r("#tabRegister").addClass("active"),r("button.close-modal").addClass("ib-close-mproperty"),r(".overlay_modal").css("background-color","rgba(0,0,0,0.8);"),r("#modal_login h2").html(r("#modal_login").find("[data-tab]:eq(1)").data("text-force")),a=r(".header-tab a[data-tab='tabRegister']").attr("data-text"),r("#modal_login .modal_cm .content_md .heder_md .ms-title-modal").html(a)):1==r(this).attr("taction")?l(r("#modal_update_search")):(r(".notification_day_class_update").val("0"),r("#form-update-alert").submit())}),r(".close.close-modal").click(function(t){i(r("#modal_update_search"))}),r("#form-update-alert").on("submit",function(t){t.preventDefault();var a=[],t=(r('input[name="notification_type_update[]"]:checked').each(function(){a.push(this.value)}),r("#input_update_name_search").val()),e=r(".token_alert").val(),o=r(".notification_day_class_update").val();null!=t&&0<t.length?r.ajax({url:__flex_g_settings.ajaxUrl,method:"POST",data:{action:"flex_save_search",type:"update",name:t,notification_day:o,notification_type:a,token_alert:e,search_count:1},dataType:"json",success:function(t){console.log(t),r(".flex_tit_"+r(activeli).attr("posid")).text(r("#input_update_name_search").val()),r(".flex_alert_cont_"+r(activeli).attr("posid")).attr("namesearch"),r(".flex_alert_cont_"+r(activeli).attr("posid")).attr("namesearch",r("#input_update_name_search").val()),r(".flex_alert_cont_"+r(activeli).attr("posid")).attr("alertinterval",r(".notification_day_class_update").val()),r(".flex_alert_cont_"+r(activeli).attr("posid")).attr("alertnotifications",a.toString()),r("#form-update-alert").trigger("reset"),r(0==o?"input#flex_saved_search_off_"+r(activeli).attr("posid"):"input#flex_saved_search_on_"+r(activeli).attr("posid")).click(),r("#modal_update_search").removeClass("active_modal")},before:function(){i(r("#modal_update_search"))},complete:function(){l(r("#modal_update_favorities"))}}):sweetAlert(word_translate.oops,word_translate.you_must_provide_a_name_for_this_search,"error")})})}(jQuery);