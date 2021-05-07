(function($) {
	// handle inquiry contact form
	var flex_idx_contact_form;
	
	$(function () {
		// dom ready
		var idForm=[];
		for(i=0;i<$('.idx_id_form').length;i++){
			idForm.push('#'+$('.idx_id_form').eq(i).val());
		}
		
		flex_idx_contact_form = $(idForm.join(', '));

		if (flex_idx_contact_form.length) {
			flex_idx_contact_form.on("submit", function(event) {
				event.preventDefault();

				var _self = $(this);
				$('.idx_contact_email').val( $('.idx_contact_email_temp').val());

				var contactSubmitData = _self.serialize();

				$.ajax({
					url: __flex_g_settings.ajaxUrl,
					type: "POST",
					data: contactSubmitData,
					dataType: "json",
					success: function(response) {
						console.log(response);
						if (response.success) {
							_self.trigger('reset');
							sweetAlert(word_translate.email_sent, word_translate.your_email_was_sent_succesfully, "success");
						}
					}
				});
			});
		}
	});

	if($("#map").length){
		// map
		google.maps.event.addDomListener(window, "load", function() {
			
			var style_map=[];

			if(style_map_idxboost != undefined && style_map_idxboost != '') {
				style_map=JSON.parse(style_map_idxboost);
			}


			var flex_map_mini_view = $("#map");
			if (flex_map_mini_view.length) {

				var idx_zoom=18;

				if(flex_map_mini_view.data('zoom') != '' && flex_map_mini_view.data('zoom') != undefined){
					idx_zoom=flex_map_mini_view.data('zoom');
				}

				var myLatLng2 = {
					lat: parseFloat(flex_map_mini_view.data('lat')),
					lng: parseFloat(flex_map_mini_view.data('lng'))
				};

				var miniMap = new google.maps.Map(document.getElementById('map'), {
					zoom: idx_zoom,
					styles: style_map,
					center: myLatLng2,

					scrollwheel: false,
					panControl: false,
					zoomControl: false,
					disableDefaultUI: true,
					streetViewControl: true,

				});

				var marker = new google.maps.Marker({
					position: myLatLng2,
					map: miniMap,
					icon: flex_idx_contact.idxboost_uri+'images/marker.png'
				});

				$("#map").removeAttr("data-lat").removeAttr("data-lng");

				google.maps.event.addListenerOnce(miniMap, 'tilesloaded', setupMapControls);

				function handleSatelliteButton(event){
					event.stopPropagation();
					event.preventDefault();
					miniMap.setMapTypeId(google.maps.MapTypeId.HYBRID)
				
					if($(this).hasClass("is-active")){
						$(this).removeClass("is-active");
						miniMap.setMapTypeId(google.maps.MapTypeId.ROADMAP)
					}else{
						$(this).addClass("is-active");
						miniMap.setMapTypeId(google.maps.MapTypeId.HYBRID)
					}
				}
				
				function handleZoomInButton(event) {
					event.stopPropagation();
					event.preventDefault();
					miniMap.setZoom(miniMap.getZoom() + 1);
				}
				
				function handleZoomOutButton(event) {
					event.stopPropagation();
					event.preventDefault();
					miniMap.setZoom(miniMap.getZoom() - 1);
				}
				
				function handlefullscreenButton() {
				
					var elementToSendFullscreen = miniMap.getDiv().firstChild;
				
					if (isFullscreen(elementToSendFullscreen)) {
						exitFullscreen();
					} else {
						requestFullscreen(elementToSendFullscreen);
					}
				
					document.onwebkitfullscreenchange = document.onmsfullscreenchange = document.onmozfullscreenchange = document.onfullscreenchange = function () {
						if (isFullscreen(elementToSendFullscreen)) {
							fullscreenControl.classList.add("is-fullscreen");
						} else {
							fullscreenControl.classList.remove("is-fullscreen");
						}
					};
				}
				
				function isFullscreen(element) {
					return (
						(document.fullscreenElement ||
							document.webkitFullscreenElement ||
							document.mozFullScreenElement ||
							document.msFullscreenElement) == element
					);
				}
				
				function requestFullscreen(element) {
					if (element.requestFullscreen) {
						element.requestFullscreen();
					} else if (element.webkitRequestFullScreen) {
						element.webkitRequestFullScreen();
					} else if (element.mozRequestFullScreen) {
						element.mozRequestFullScreen();
					} else if (element.msRequestFullScreen) {
						element.msRequestFullScreen();
					}
				}
				
				function exitFullscreen() {
					if (document.exitFullscreen) {
						document.exitFullscreen();
					} else if (document.webkitExitFullscreen) {
						document.webkitExitFullscreen();
					} else if (document.mozCancelFullScreen) {
						document.mozCancelFullScreen();
					} else if (document.msExitFullscreen) {
						document.msExitFullscreen();
					}
				}
				
				function setupMapControls() {
					// setup buttons wrapper
					mapButtonsWrapper = document.createElement("div");
					mapButtonsWrapper.classList.add('flex-map-controls-ct');
				
					// setup Full Screen button
					fullscreenControl = document.createElement("div");
					fullscreenControl.classList.add('flex-map-fullscreen');
					mapButtonsWrapper.appendChild(fullscreenControl);
				
					// setup zoom in button
					mapZoomInButton = document.createElement("div");
					mapZoomInButton.classList.add('flex-map-zoomIn');
					mapButtonsWrapper.appendChild(mapZoomInButton);
				
					// setup zoom out button
					mapZoomOutButton = document.createElement("div");
					mapZoomOutButton.classList.add('flex-map-zoomOut');
					mapButtonsWrapper.appendChild(mapZoomOutButton);
				
					// setup Satellite button
					satelliteMapButton = document.createElement("div");
					satelliteMapButton.classList.add('flex-satellite-button');
					mapButtonsWrapper.appendChild(satelliteMapButton);
				
					// add Buttons
					google.maps.event.addDomListener(mapZoomInButton, "click", handleZoomInButton);
					google.maps.event.addDomListener(mapZoomOutButton, "click", handleZoomOutButton);
					google.maps.event.addDomListener(fullscreenControl, "click", handlefullscreenButton);
					google.maps.event.addDomListener(satelliteMapButton, "click", handleSatelliteButton);
				
					miniMap.controls[google.maps.ControlPosition.TOP_RIGHT].push(mapButtonsWrapper);
				}
			}
		});
	}
})(jQuery);