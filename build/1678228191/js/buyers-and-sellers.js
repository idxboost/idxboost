!function(n){n(".ib-fbtn-fnext").click(()=>{var e=n(".ib-fsitem-active"),t=e.index(),e=(e.removeClass("ib-fsitem-active").next().addClass("ib-fsitem-active"),n(".ib-fbtns"));0==t?e.removeClass("ib-fbtns-continue").addClass("ib-fbtns-backnext"):t==n(".ib-fsitem").length-2&&e.removeClass("ib-fbtns-backnext").addClass("ib-fbtns-submit")}),n(".ib-fbtn-back").click(()=>{var e=n(".ib-fsitem-active"),t=e.index();0!==t&&e.removeClass("ib-fsitem-active").prev().addClass("ib-fsitem-active"),1==t&&(e=n(".ib-fbtns"),console.log("aca"),e.removeClass("ib-fbtns-backnext"),n(".ib-fsifind").length||e.addClass("ib-fbtns-continue"))})}(jQuery),function(t){var n,e,a,s,i,c,o,r=!1;function l(e){e.preventDefault(),!0!==r&&(r=!0,__flex_g_settings.hasOwnProperty("has_enterprise_recaptcha")?"1"!=__flex_g_settings.has_enterprise_recaptcha&&grecaptcha.ready(function(){grecaptcha.execute(__flex_g_settings.google_recaptcha_public_key,{action:"i_want_to_buy"}).then(function(e){n.prepend('<input type="hidden" name="recaptcha_response" value="'+e+'">');e=n.serialize();t.ajax({type:"POST",url:__flex_g_settings.ajaxUrl,data:e,success:function(e){sweetAlert(word_translate.email_sent,word_translate.your_email_was_sent_succesfully,"success"),n.find(":input").prop("disabled",!0),t(document).one("click","button",function(e){t(e.target).hasClass("confirm")&&setTimeout(function(){document.location.reload()},300)})},error:function(){setTimeout(function(){document.location.reload()},300)}})})}):grecaptcha.ready(function(){grecaptcha.execute(__flex_g_settings.google_recaptcha_public_key,{action:"i_want_to_buy"}).then(function(e){n.prepend('<input type="hidden" name="recaptcha_response" value="'+e+'">');e=n.serialize();t.ajax({type:"POST",url:__flex_g_settings.ajaxUrl,data:e,success:function(e){sweetAlert(word_translate.email_sent,word_translate.your_email_was_sent_succesfully,"success"),n.find(":input").prop("disabled",!0),t(document).one("click","button",function(e){t(e.target).hasClass("confirm")&&setTimeout(function(){document.location.reload()},300)})},error:function(){setTimeout(function(){document.location.reload()},300)}})})}))}function _(e){e.preventDefault(),!0!==r&&(r=!0,__flex_g_settings.hasOwnProperty("has_enterprise_recaptcha")?"1"!=__flex_g_settings.has_enterprise_recaptcha&&grecaptcha.ready(function(){grecaptcha.execute(__flex_g_settings.google_recaptcha_public_key,{action:"i_want_to_rent"}).then(function(e){a.prepend('<input type="hidden" name="recaptcha_response" value="'+e+'">');e=a.serialize();t.ajax({type:"POST",url:__flex_g_settings.ajaxUrl,data:e,success:function(e){sweetAlert(word_translate.email_sent,word_translate.your_email_was_sent_succesfully,"success"),a.find(":input").prop("disabled",!0),t(document).one("click","button",function(e){t(e.target).hasClass("confirm")&&setTimeout(function(){document.location.reload()},300)})},error:function(){setTimeout(function(){document.location.reload()},300)}})})}):grecaptcha.ready(function(){grecaptcha.execute(__flex_g_settings.google_recaptcha_public_key,{action:"i_want_to_rent"}).then(function(e){a.prepend('<input type="hidden" name="recaptcha_response" value="'+e+'">');e=a.serialize();t.ajax({type:"POST",url:__flex_g_settings.ajaxUrl,data:e,success:function(e){sweetAlert(word_translate.email_sent,word_translate.your_email_was_sent_succesfully,"success"),a.find(":input").prop("disabled",!0),t(document).one("click","button",function(e){t(e.target).hasClass("confirm")&&setTimeout(function(){document.location.reload()},300)})},error:function(){setTimeout(function(){document.location.reload()},300)}})})}))}function u(e){e.preventDefault(),!0!==r&&(r=!0,__flex_g_settings.hasOwnProperty("has_enterprise_recaptcha")?"1"!=__flex_g_settings.has_enterprise_recaptcha&&grecaptcha.ready(function(){grecaptcha.execute(__flex_g_settings.google_recaptcha_public_key,{action:"i_want_to_sell"}).then(function(e){i.prepend('<input type="hidden" name="recaptcha_response" value="'+e+'">');e=i.serialize();t.ajax({type:"POST",url:__flex_g_settings.ajaxUrl,data:e,success:function(e){sweetAlert(word_translate.email_sent,word_translate.your_email_was_sent_succesfully,"success"),i.find(":input").prop("disabled",!0),t(document).one("click","button",function(e){t(e.target).hasClass("confirm")&&setTimeout(function(){document.location.reload()},300)})},error:function(){setTimeout(function(){document.location.reload()},300)}})})}):grecaptcha.ready(function(){grecaptcha.execute(__flex_g_settings.google_recaptcha_public_key,{action:"i_want_to_sell"}).then(function(e){i.prepend('<input type="hidden" name="recaptcha_response" value="'+e+'">');e=i.serialize();t.ajax({type:"POST",url:__flex_g_settings.ajaxUrl,data:e,success:function(e){sweetAlert(word_translate.email_sent,word_translate.your_email_was_sent_succesfully,"success"),i.find(":input").prop("disabled",!0),t(document).one("click","button",function(e){t(e.target).hasClass("confirm")&&setTimeout(function(){document.location.reload()},300)})},error:function(){setTimeout(function(){document.location.reload()},300)}})})}))}t(function(){n=t("#lead_submission_buy_form"),e=t("#lead_submission_buy_submit"),a=t("#lead_submission_rent_form"),s=t("#lead_submission_rent_submit"),i=t("#lead_submission_sell_form"),c=t("#lead_submission_sell_submit"),n.length&&e.length&&n.on("submit",l),a.length&&s.length&&a.on("submit",_),i.length&&c.length&&i.on("submit",u)}),jQuery(function(){console.log("dom ready"),null!==(o=document.getElementById("lead_address_acgoogle"))&&(new google.maps.places.Autocomplete(o).setComponentRestrictions({country:["us"]}),setTimeout(function(){o.setAttribute("autocomplete","disabled")},300))})}(jQuery);