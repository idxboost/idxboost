!function(u){var t;u(function(){var e=[];for(i=0;i<u(".idx_id_form").length;i++)e.push("#"+u(".idx_id_form").eq(i).val());(t=u(e.join(", "))).length&&t.on("submit",function(e){e.preventDefault();var t=u(this);u(".idx_contact_email").val(u(".idx_contact_email_temp").val()),__flex_g_settings.hasOwnProperty("has_enterprise_recaptcha")?"1"!=__flex_g_settings.has_enterprise_recaptcha&&grecaptcha.ready(function(){grecaptcha.execute(__flex_g_settings.google_recaptcha_public_key,{action:"contact_inquiry"}).then(function(e){t.prepend('<input type="hidden" name="recaptcha_response" value="'+e+'">'),u.ajax({url:__flex_g_settings.ajaxUrl,type:"POST",data:t.serialize(),dataType:"json",success:function(e){e.success&&(t.trigger("reset"),sweetAlert(word_translate.email_sent,word_translate.your_email_was_sent_succesfully,"success"))}})})}):grecaptcha.ready(function(){grecaptcha.execute(__flex_g_settings.google_recaptcha_public_key,{action:"contact_inquiry"}).then(function(e){t.prepend('<input type="hidden" name="recaptcha_response" value="'+e+'">'),u.ajax({url:__flex_g_settings.ajaxUrl,type:"POST",data:t.serialize(),dataType:"json",success:function(e){e.success&&(t.trigger("reset"),sweetAlert(word_translate.email_sent,word_translate.your_email_was_sent_succesfully,"success"))}})})})})}),u("#map").length&&google.maps.event.addDomListener(window,"load",function(){var e,n,t=[],a=(null!=style_map_idxboost&&""!=style_map_idxboost&&(t=JSON.parse(style_map_idxboost)),u("#map"));function o(e){e.stopPropagation(),e.preventDefault(),n.setMapTypeId(google.maps.MapTypeId.HYBRID),u(this).hasClass("is-active")?(u(this).removeClass("is-active"),n.setMapTypeId(google.maps.MapTypeId.ROADMAP)):(u(this).addClass("is-active"),n.setMapTypeId(google.maps.MapTypeId.HYBRID))}function l(e){e.stopPropagation(),e.preventDefault(),n.setZoom(n.getZoom()+1)}function s(e){e.stopPropagation(),e.preventDefault(),n.setZoom(n.getZoom()-1)}function c(){var e,t=n.getDiv().firstChild;r(t)?document.exitFullscreen?document.exitFullscreen():document.webkitExitFullscreen?document.webkitExitFullscreen():document.mozCancelFullScreen?document.mozCancelFullScreen():document.msExitFullscreen&&document.msExitFullscreen():(e=t).requestFullscreen?e.requestFullscreen():e.webkitRequestFullScreen?e.webkitRequestFullScreen():e.mozRequestFullScreen?e.mozRequestFullScreen():e.msRequestFullScreen&&e.msRequestFullScreen(),document.onwebkitfullscreenchange=document.onmsfullscreenchange=document.onmozfullscreenchange=document.onfullscreenchange=function(){r(t)?fullscreenControl.classList.add("is-fullscreen"):fullscreenControl.classList.remove("is-fullscreen")}}function r(e){return(document.fullscreenElement||document.webkitFullscreenElement||document.mozFullScreenElement||document.msFullscreenElement)==e}a.length&&(e=16,""!=a.data("zoom")&&null!=a.data("zoom")&&(e=a.data("zoom")),console.log(e),a={lat:parseFloat(a.data("lat")),lng:parseFloat(a.data("lng"))},n=new google.maps.Map(document.getElementById("map"),{zoom:e,styles:t,center:a}),new google.maps.Marker({position:a,map:n,icon:flex_idx_contact.idxboost_uri+"images/marker.png"}),u("#map").removeAttr("data-lat").removeAttr("data-lng"),google.maps.event.addListenerOnce(n,"tilesloaded",function(){(mapButtonsWrapper=document.createElement("div")).classList.add("flex-map-controls-ct"),(fullscreenControl=document.createElement("div")).classList.add("flex-map-fullscreen"),mapButtonsWrapper.appendChild(fullscreenControl),(mapZoomInButton=document.createElement("div")).classList.add("flex-map-zoomIn"),mapButtonsWrapper.appendChild(mapZoomInButton),(mapZoomOutButton=document.createElement("div")).classList.add("flex-map-zoomOut"),mapButtonsWrapper.appendChild(mapZoomOutButton),(satelliteMapButton=document.createElement("div")).classList.add("flex-satellite-button"),mapButtonsWrapper.appendChild(satelliteMapButton),google.maps.event.addDomListener(mapZoomInButton,"click",l),google.maps.event.addDomListener(mapZoomOutButton,"click",s),google.maps.event.addDomListener(fullscreenControl,"click",c),google.maps.event.addDomListener(satelliteMapButton,"click",o),n.controls[google.maps.ControlPosition.TOP_RIGHT].push(mapButtonsWrapper)}))})}(jQuery);