var ajax_request_filter;
var myLazyLoad;
var IB_COMMERCIAL = $("#ib-template-property-sale-rent-sold"); 
var $viewFilter = $('.filter-views');
var $wrapResult = $('.wrap-result');
var IB_PAGINATION= $("#ib-template-display-pagination"); 

var flex_ui_loaded = false;
var baths_slider;
var beds_slider;
var sqft_slider;
var lotsize_slider;
var price_sale_slider;
var price_rent_slider;
var year_built_slider;
var flex_filter_sort;
var flex_pagination;
var flex_search_rental_switch;
var flex_waterfront_switch;
var flex_parking_switch;
var flex_autocomplete;
var flex_autocomplete_inner;
var $cuerpo = jQuery("body");
var $ventana = jQuery(window);
var arraytest_pryueba = '';
var currentfiltemid = '';
var xDown = null;
var yDown = null;

	// console.dir(property_items);
	/******** MAP BEHAVIOR ********/
	var map;
	var markers = [];
	var infoWindow;
	var mapButtonsWrapper;
	var mapZoomInButton;
	var mapZoomOutButton;
	var mapDrawButton;
	var userIsDrawing = false;
	var userHasMapFigure = false;
	var renderedMarkers = false;
	var mapIsVisible = false;
	var polyStrokeColor = '#015288';
	var polyFillColor = '#0099FF';
	var hashed_properties = [];
	var filtered_properties = [];
	var unique_properties = [];
	var infobox_content = [];
	var geocode;
	var poly;
	var move;
	var properties = [];


	function initialize() {
		console.log("map init");
	var style_map=[];

	if(style_map_idxboost != undefined && style_map_idxboost != '') {
		style_map=JSON.parse(style_map_idxboost);
	}

		myLazyLoad = new LazyLoad({
			elements_selector: ".flex-lazy-image",
			callback_load: function() {},
			callback_error: function(element){
			  $(element).attr('src','https://idxboost.com/i/default_thumbnail.jpg').removeClass('error').addClass('loaded');
			  $(element).attr('data-origin','https://idxboost.com/i/default_thumbnail.jpg');
			}
		});
		map = new google.maps.Map(
			document.getElementById('code-map'), {
			center: new google.maps.LatLng(25.761680, -80.19179),
			mapTypeId: google.maps.MapTypeId.ROADMAP,
			zoom: 18,
			disableDoubleClickZoom: true,
			scrollwheel: false,
			panControl: false,
			zoomControl: false,
			disableDefaultUI: true,
			clickableIcons: false,
			styles: style_map,
			gestureHandling: ("1" == __flex_g_settings.is_mobile) ? 'greedy' : 'cooperative',
			streetViewControl: true,
		});

		google.maps.event.addListenerOnce(map, 'tilesloaded', setupMapControls);

	}

		function handleZoomInButton(event) {
		event.stopPropagation();
		event.preventDefault();
		// if (userIsDrawing) {
		//     google.maps.event.clearListeners(map.getDiv(), "mousedown");
		//     google.maps.event.removeListener(move);
		//     stopDrawingMap();
		//     // remove polygon draw
		//     $('#idx_page').val(1);
		//     $('#idx_polygon').val('');
		//     filter_refresh_search();
		// }
		map.setZoom(map.getZoom() + 1);
	}

	function handleZoomOutButton(event) {
		event.stopPropagation();
		event.preventDefault();
		// if (userIsDrawing) {
		//     google.maps.event.clearListeners(map.getDiv(), "mousedown");
		//     google.maps.event.removeListener(move);
		//     stopDrawingMap();
		//     // remove polygon draw
		//     $('#idx_page').val(1);
		//     $('#idx_polygon').val('');
		//     filter_refresh_search();
		// }
		map.setZoom(map.getZoom() - 1);
	}

	function handleDrawButton(event) {
		event.stopPropagation();
		event.preventDefault();
		if (this.classList.contains('flex-map-is-drawing')) {
			google.maps.event.clearListeners(map.getDiv(), "mousedown");
			google.maps.event.removeListener(move);
			stopDrawingMap();
			// remove polygon draw
			// $('#idx_page').val(1);
			// $('#idx_polygon').val('');
			// filter_refresh_search();
		} else {
			startDrawingMap();
			google.maps.event.addDomListener(map.getDiv(), "mousedown", handleMouseDown);
		}
	}

	function stopDrawingMap() {
		map.setOptions({
			draggable: true,
			zoomControl: true
		});
		mapDrawButton.classList.remove("flex-map-is-drawing");
		userIsDrawing = false;
	}

	function startDrawingMap() {
		if (infoWindow.isOpen()) {
			infoWindow.close();
		}
		map.setOptions({
			draggable: false,
			zoomControl: false
		});
		if (userHasMapFigure === true) {
			poly.setMap(null);
		}
		mapDrawButton.classList.add("flex-map-is-drawing");
		userIsDrawing = true;
	}

	function handleMapDrawing() {
		if (userIsDrawing === false) {
			return;
		}
		poly = new google.maps.Polyline({
			map: map,
			clickable: false,
			strokeColor: polyStrokeColor,
			strokeOpacity: 1,
			strokeWeight: 1
		});
		move = google.maps.event.addListener(map, "mousemove", handleMouseMove);
		google.maps.event.addListener(map, "mouseup", handleMouseUp);
	}

	function handleMouseMove(event) {
		poly.getPath().push(event.latLng);
	}

	function handleMouseUp(event) {
		google.maps.event.removeListener(move);
		if (userIsDrawing === false) {
			return;
		}
		poly.setMap(null);
		var path = poly.getPath();
		var theArrayOfLatLng = path.getArray();
		var arrayForPolygonSearch = [];
		var polyOptions = {
			map: map,
			fillColor: polyFillColor,
			fillOpacity: 0.25,
			strokeColor: polyStrokeColor,
			strokeWeight: 1,
			clickable: false,
			zIndex: 1,
			path: theArrayOfLatLng,
			editable: false
		};
		for (var i = 0, l = theArrayOfLatLng.length; i < l; i++) {
			arrayForPolygonSearch.push(theArrayOfLatLng[i].lat() + " " + theArrayOfLatLng[i].lng());
		}
		if (path.getArray().length) {
			arrayForPolygonSearch.push(path.getAt(0).lat() + ' ' + path.getAt(0).lng());
		}
		poly = new google.maps.Polygon(polyOptions);
		poly.setMap(map);
		google.maps.event.clearListeners(map.getDiv(), "mousedown");
		if (arrayForPolygonSearch.length) {
			var geometry = 'POLYGON((' + arrayForPolygonSearch.join(",") + '))';
			userHasMapFigure = true;
			// set polygon draw
			// $('#idx_page').val(1);
			// $('#idx_polygon').val(geometry);
			// filter_refresh_search();
		} else {
			userHasMapFigure = false;
		}
		stopDrawingMap();
	}

	function handleMouseDown(event) {
		event.stopPropagation();
		event.preventDefault();
		handleMapDrawing();
	}

	function handleSatelliteButton(event){
		event.stopPropagation();
		event.preventDefault();
		map.setMapTypeId(google.maps.MapTypeId.HYBRID)
	
		if($(this).hasClass("is-active")){
			$(this).removeClass("is-active");
			map.setMapTypeId(google.maps.MapTypeId.ROADMAP)
		}else{
			$(this).addClass("is-active");
			map.setMapTypeId(google.maps.MapTypeId.HYBRID)
		}
	}
	
	function handleZoomInButton(event) {
		event.stopPropagation();
		event.preventDefault();
		map.setZoom(map.getZoom() + 1);
	}
	
	function handleZoomOutButton(event) {
		event.stopPropagation();
		event.preventDefault();
		map.setZoom(map.getZoom() - 1);
	}
	
	function handlefullscreenButton() {
	
		var elementToSendFullscreen = map.getDiv().firstChild;
	
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

	function removeMarkers() {
		if (hashed_properties.length) {
			hashed_properties.length = 0;
		}
		if (filtered_properties.length) {
			filtered_properties.length = 0;
		}
		if (unique_properties.length) {
			unique_properties.length = 0;
		}
		if (markers.length) {
			for (var i = 0, l = markers.length; i < l; i++) {
				markers[i].setMap(null);
			}
			markers.length = 0;
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
		map.controls[google.maps.ControlPosition.TOP_RIGHT].push(mapButtonsWrapper);
	}

	var $wrapListResult = $('#wrap-list-result'); //seteo esto

	function setupMarkers(properties) {
		arrayother = properties;
		var bounds = new google.maps.LatLngBounds(),
			marker,
			property,
			row,
			i;
		infoWindow = new InfoBubble({
			map: map,
			disableAutoPan: true,
			shadowStyle: 0,
			padding: 0,
			borderRadius: 0,
			borderWidth: 0,
			disableAnimation: true,
			maxWidth: 380
		});

		infoWindow.addListener("domready", function() {
			$(".ib-load-property-iw").on("click", function(event) {
				event.preventDefault();
				event.stopPropagation();

				var _self = $(this);
				var mlsNum = _self.data("mls");
				loadPropertyInModal(mlsNum);
			});
		});


		if (properties != null){

			for (var i = 0, l = properties.length; i < l; i++) {
				row = properties[i];
				geocode = row.lat + ':' + row.lng;
				if (_.indexOf(hashed_properties, geocode) === -1) {
					hashed_properties.push(geocode);
					filtered_properties.push(row);
				}
			}

			for (var i = 0, l = filtered_properties.length; i < l; i++) {
				row = filtered_properties[i];
				geocode = [row.lat, row.lng];
				// reset array
				var related_properties = [];
				for (var k = 0, m = properties.length; k < m; k++) {
					inner = properties[k];
					if ((inner.lat == geocode[0]) && (inner.lng == geocode[1])) {
						related_properties.push(inner);
					}
				}
				unique_properties.push({
					item: row,
					group: related_properties
				});
			}

			for (i = 0; i < unique_properties.length; i++) {
				property = unique_properties[i];
				marker = new RichMarker({
					position: new google.maps.LatLng(parseFloat(property.item.lat), parseFloat(property.item.lng)),
					map: map,
					flat: true,
					draggable: false,
					content: (property.group.length > 1) ? '<div class="dgt-richmarker-group"><strong>' + property.group.length + '</strong><span>Units</span></div>' : '<div class="dgt-richmarker-single"><strong>$' + _.formatShortPrice(property.item.price) + '</strong></div>',
					anchor: RichMarkerPosition.TOP
				});
				marker.geocode = property.item.lat + ':' + property.item.lng;
				bounds.extend(marker.position);
				markers.push(marker);
				google.maps.event.addListener(marker, "click", handleMarkerClick(marker, property, map));
				google.maps.event.addListener(marker, "mouseover", handleMarkerMouseOver(marker));
				google.maps.event.addListener(marker, "mouseout", handleMarkerMouseOut(marker));
			}

		}
		
		if (typeof map !== "undefined") {
			map.fitBounds(bounds);
		}
	}


	function handleMarkerMouseOver(marker) {
		return function() {
			marker.setZIndex(google.maps.Marker.MAX_ZINDEX + 1);
		};
	}

	function handleMarkerMouseOut(marker) {
		return function() {
			marker.setZIndex(google.maps.Marker.MAX_ZINDEX - 1);
		};
	}

	var $buttonsMap = $('#map-actions');
	if ($buttonsMap.length) {
		$buttonsMap.on('click', 'button', function() {
			$wrapListResult.toggleClass('closed');
			$(this).addClass('hide').siblings().removeClass('hide');
			setTimeout(function() {
				google.maps.event.trigger(map, 'resize');
				setTimeout(function() {
					google.maps.event.trigger(map, 'resize');
				}, 200);
			}, 100);
		});
	}

	var $openCloseMap = $('.map-actions button');
	if (typeof($openCloseMap) != 'undefined') {
		$openCloseMap.on('click', function() {
			$openCloseMap.removeClass('no-show');
			$(this).addClass('no-show');
			$('#wrap-list-result').toggleClass('hidden-results');
		});
	}

	function handleMarkerClick(marker, property, map) {
		return function() {
			if (property.group.length > 1) {
				// multiple
				infobox_content.push('<div class="mapview-container">');
				infobox_content.push('<div class="mapviwe-header">');
				infobox_content.push('<h2>' + property.item.heading + '</h2>');
				infobox_content.push('<span class="build">' + property.group.length + '</span>');
				infobox_content.push('<button class="closeInfo"><span>'+word_translate.close+'</span></button>');
				infobox_content.push('</div>');
				infobox_content.push('<div class="mapviwe-body">');
				for (var i = 0, l = property.group.length; i < l; i++) {
					var property_group = property.group[i];
					infobox_content.push('<div class="mapviwe-item">');
					infobox_content.push('<h2 title="' + property_group.address_short.replace(/# /, "#") + '"><span>' + property_group.address_short.replace(/# /, "#") + '</span></h2>');
					infobox_content.push('<ul>');
					infobox_content.push('<li class="address"><span>' + property_group.address_large.replace(/ , /, ", ") + '</span></li>');
					infobox_content.push('<li class="price">$' + _.formatPrice(property_group.price) + '</li>');
					var textpropertybed = word_translate.beds;
					var textpropertybath = word_translate.baths;
					if (property_group.bed > 1) {
						textpropertybed = word_translate.beds;
					} else {
						textpropertybed = word_translate.bed;
					}
					if (property_group.bath > 1) {
						textpropertybath = word_translate.baths;
					} else {
						textpropertybath = word_translate.bath;
					}
					infobox_content.push('<li class="beds"><b>' + property_group.bed + '</b> <span> ' + textpropertybed + '</span></li>');
					infobox_content.push('<li class="baths"><b>' + property_group.bath + '</b> <span> ' + textpropertybath + '</span></li>');
					infobox_content.push('<li class="living-size"> <span>' + _.formatPrice(property_group.sqft) + '</span> Sq.Ft.<span>(' + property_group.living_size_m2 + ' m²)</span></li>');
					infobox_content.push('<li class="price-sf"><span>$' + property_group.price_sqft + ' </span>/ Sq.Ft.<span>($' + property_group.price_sqft_m2 + ' m²)</span></li>');
					infobox_content.push('</ul>');
					infobox_content.push('<div class="mapviwe-img">');					
                if (
                        __flex_g_settings.hasOwnProperty("board_info") &&
                        __flex_g_settings.board_info.hasOwnProperty("board_logo_url") &&
                        !(["", null, undefined, "undefined", "null"].includes(__flex_g_settings.board_info.board_logo_url))
                    ) {
                    	infobox_content.push('<img title="' + property_group.address_short.replace(/# /, "#") + ', ' + property_group.address_large.replace(/ , /, ", ") + '" alt="' + property_group.address_short.replace(/# /, "#") + ', ' + property_group.address_large.replace(/ , /, ", ") + '" src="' + property_group.gallery[0] + '"><img src="'+__flex_g_settings.board_info.board_logo_url+'" style="position: absolute;bottom: 10px;z-index: 2;width: 80px;right: 10px;height:auto">');
                    }else{
                        infobox_content.push('<img title="' + property_group.address_short.replace(/# /, "#") + ', ' + property_group.address_large.replace(/ , /, ", ") + '" alt="' + property_group.address_short.replace(/# /, "#") + ', ' + property_group.address_large.replace(/ , /, ", ") + '" src="' + property_group.gallery[0] + '">');
                    }

					infobox_content.push('</div>');
					infobox_content.push('<a class="ib-load-property-iw" data-mls="' + property_group.mls_num + '" href="' + flex_idx_filter_params.propertyDetailPermalink + '/' + property_group.slug + '" title="' + property_group.address_short.replace(/# /, "#") + ', ' + property_group.address_large.replace(/ , /, ", ") + '">' + property_group.address_short.replace(/# /, "#") + ', ' + property_group.address_large.replace(/ , /, ", ") + '</a>');
					infobox_content.push('</div>');
				}
				infobox_content.push('</div>');
				infobox_content.push('</div>');
			} else {
				var text_is_rental='';
				if (property.item.is_rental=='1')
					text_is_rental='/'+word_translate.month; 

				// single
				infobox_content.push('<div class="mapview-container">');
				infobox_content.push('<div class="mapviwe-header">');
				infobox_content.push('<h2>' + property.item.heading + '</h2>');
				infobox_content.push('<button class="closeInfo"><span>'+word_translate.close+'</span></button>');
				infobox_content.push('</div>');
				infobox_content.push('<div class="mapviwe-body">');
				infobox_content.push('<div class="mapviwe-item">');
				infobox_content.push('<h2 title="' + property.item.address_short.replace(/# /, "#") + '"><span>' + property.item.address_short.replace(/# /, "#") + '</span></h2>');
				infobox_content.push('<ul>');
				infobox_content.push('<li class="address"><span>' + property.item.address_large.replace(/ , /, ", ") + '</span></li>');
				infobox_content.push('<li class="price">$' + _.formatPrice(property.item.price)+text_is_rental + '</li>');
				var textpropertyitembed = word_translate.beds;
				var textpropertyitembath = word_translate.baths;
				if (property.item.bed > 1) {
					textpropertyitembed = word_translate.beds;
				} else {
					textpropertyitembed = word_translate.bed;
				}
				if (property.item.bath > 1) {
					textpropertyitembath = word_translate.baths;
				} else {
					textpropertyitembath = word_translate.bath;
				}
				infobox_content.push('<li class="beds"><b>' + property.item.bed + '</b> <span> ' + textpropertyitembed + '</span></li>');
				infobox_content.push('<li class="baths"><b>' + property.item.bath + '</b> <span> ' + textpropertyitembath + '</span></li>');
				infobox_content.push('<li class="living-size"> <span>' + _.formatPrice(property.item.sqft) + '</span> Sq.Ft.<span>(' + property.item.living_size_m2 + ' m²)</span></li>');
				infobox_content.push('<li class="price-sf"><span>$' + property.item.price_sqft + ' </span>/ Sq.Ft.<span>($' + property.item.price_sqft_m2 + ' m²)</span></li>');
				infobox_content.push('</ul>');
				infobox_content.push('<div class="mapviwe-img">');				

                if (
                        __flex_g_settings.hasOwnProperty("board_info") &&
                        __flex_g_settings.board_info.hasOwnProperty("board_logo_url") &&
                        !(["", null, undefined, "undefined", "null"].includes(__flex_g_settings.board_info.board_logo_url))
                    ) {
                    	infobox_content.push('<img title="' + property.item.address_short.replace(/# /, "#") + ', ' + property.item.address_large.replace(/ , /, ", ") + '" alt="' + property.item.address_short.replace(/# /, "#") + ', ' + property.item.address_large.replace(/ , /, ", ") + '" src="' + property.item.gallery[0] + '"><img src="'+__flex_g_settings.board_info.board_logo_url+'" style="position: absolute;bottom: 10px;z-index: 2;width: 80px;right: 10px;height:auto">');
                    }else{
                        infobox_content.push('<img title="' + property.item.address_short.replace(/# /, "#") + ', ' + property.item.address_large.replace(/ , /, ", ") + '" alt="' + property.item.address_short.replace(/# /, "#") + ', ' + property.item.address_large.replace(/ , /, ", ") + '" src="' + property.item.gallery[0] + '">');
                    }


				infobox_content.push('</div>');
				infobox_content.push('<a class="ib-load-property-iw" data-mls="' + property.item.mls_num + '" href="' + flex_idx_filter_params.propertyDetailPermalink + '/' + property.item.slug + '" title="' + property.item.address_short.replace(/# /, "#") + ', ' + property.item.address_large.replace(/ , /, ", ") + '">' + property.item.address_short.replace(/# /, "#") + ', ' + property.item.address_large.replace(/ , /, ", ") + '</a>');
				infobox_content.push('</div>');
				infobox_content.push('</div>');
				infobox_content.push('</div>');
			}
			if (infobox_content.length) {
				infoWindow.setContent(infobox_content.join(""));
				infoWindow.open(map, marker);
				infobox_content.length = 0;
			}
		};
	}

$(document).ready(function(){
		if (typeof myLazyLoad === 'undefined') {
			myLazyLoad = new LazyLoad({
				elements_selector: ".flex-lazy-image",
				callback_load: function() {},
				callback_error: function(element){
				  $(element).attr('src','https://idxboost.com/i/default_thumbnail.jpg').removeClass('error').addClass('loaded');
				  $(element).attr('data-origin','https://idxboost.com/i/default_thumbnail.jpg');
				}
			});
		}
	filter_refresh_search();
	//var statusMapLoad = google.maps.event.addDomListener(window, 'load', initialize);
	//console.log(statusMapLoad);
	initialize();
});

Handlebars.registerHelper('paginationBlock', function(paging) {
	console.log(paging);
	var paginationHTML=[];
	if (paging.has_prev_page && paging.total_pages_count > 1) {
		paginationHTML.push('<a role="button" data-page="1" title="First Page" id="firstp" class="ad visible">');
		paginationHTML.push('<span class="clidxboost-icon-arrow-select"></span>');
		paginationHTML.push('<span class="clidxboost-icon-arrow-select"></span>');
		paginationHTML.push('<span>First page</span>');
		paginationHTML.push('</a>');
	}

	if (paging.has_prev_page) {
		paginationHTML.push('<a role="button" data-page="' + (paging.current_page_number - 1) + '" title="Prev Page" id="prevn" class="arrow clidxboost-icon-arrow-select prevn visible">');
		paginationHTML.push('<span>Previous page</span>');
		paginationHTML.push('</a>');
	}
	paginationHTML.push('<ul id="principal-nav">');

	for (var i = 0, l = paging.range.length; i < l; i++) {
		var loopPage = paging.range[i];
		if (paging.current_page_number === loopPage) {
			paginationHTML.push('<li class="active"><a role="button" data-page="' + loopPage + '">' + loopPage + '</a></li>');
		} else {
			paginationHTML.push('<li><a role="button" data-page="' + loopPage + '">' + loopPage + '</a></li>');
		}
	}
	paginationHTML.push('</ul>');
	if (paging.has_next_page) {
		paginationHTML.push('<a role="button" data-page="' + (paging.current_page_number + 1) + '" title="Prev Page" id="nextn" class="arrow clidxboost-icon-arrow-select nextn visible">');
		paginationHTML.push('<span>Next page</span>');
		paginationHTML.push('</a>');
	}

	if (paging.has_next_page && paging.total_pages_count > 1) {
		paginationHTML.push('<a role="button" data-page="' + paging.total_pages_count + '" title="First Page" id="lastp" class="ad visible">');
		paginationHTML.push('<span class="clidxboost-icon-arrow-select"></span>');
		paginationHTML.push('<span class="clidxboost-icon-arrow-select"></span>');
		paginationHTML.push('<span>Last page</span>');
		paginationHTML.push('</a>');
	}
	return paginationHTML.join("");
});


Handlebars.registerHelper('DFformatBathsHalf', function(baths_half) {
	if (baths_half > 0) {
		return ".5";
	} else {
		return "";
	}
});

Handlebars.registerHelper('DFhandleStatusProperty', function(property) {
	if ("yes" === property.recently_listed) {
		if (property.min_ago > 0 && property.min_ago_txt !="" ) {
			return '<div class="flex-property-new-listing">'+property.min_ago_txt+'</div>';
		}else{
			return '<div class="flex-property-new-listing">'+word_translate.new_listing+'</div>';
		}		
	} else if (1 != property.status) {
		return '<div class="flex-property-new-listing">'+property.status_name+'</div>';
	}
});

Handlebars.registerHelper('DFhandleTypeView', function(property) {
	return '<h2 title="'+property.full_address+'" class="ms-property-address"><div class="ms-title-address -address-top">'+property.full_address_top+'</div><div class="ms-br-line">,</div><div class="ms-title-address -address-bottom">'+property.full_address_bottom+'</div></h2>';
});

Handlebars.registerHelper('DFhandleOhContent', function(property) {
	if (property.hasOwnProperty("oh_info") && property.oh_info != null && property.oh_info != "" ) {
		var oh_info=JSON.parse(property.oh_info);
		if (typeof(oh_info) === "object" && oh_info.hasOwnProperty("date") && oh_info.hasOwnProperty("timer") ) {
			return '<div class="ms-open"><span class="ms-wrap-open"><span class="ms-open-title">Open House</span><span class="ms-open-date">'+oh_info.date+'</span><span class="ms-open-time">'+oh_info.timer+'</span></span></div>';
		}                          
	}
});


Handlebars.registerHelper('DFhandleFormatAddress', function(property) {
	if (property.address_large != null ) {
		var al = property.address_large.split(", ");
		return " <span>"+ property.address_short.replace(/# /, "#") +", " + al[0] + ", " + al[1] + "</span>";
	}
});


Handlebars.registerHelper('DFformatPrice', function(price) {
	return "$" + _.formatPrice(price);
});

Handlebars.registerHelper('DFrentalType', function(rentalType,status = "1" ) {
	var text_is_rental='';
	if (rentalType=='1' && status != '2')
		text_is_rental='/'+word_translate.month;
	return text_is_rental;
});

Handlebars.registerHelper('DFidxReduced', function(reduced) {
	if (reduced == '') {
		return '<li class="pr">' + reduced + '</li>';
	}else if (reduced < 0) {
		return  '<li class="pr down">' + reduced + '%</li>';
	}else {
		return  '<li class="pr up">' + reduced + '%</li>';
	}
});

Handlebars.registerHelper('DFhandleDevelopment', function(property) {
            if (property.development !== '' && property.development !== null) {
              return '<li class="development"><span>' + property.development + '</span></li>';
            } else if (property.complex !== ''  && property.complex !== null) {
              return '<li class="development"><span>' + property.complex + '</span></li>';
            } else {
              return '<li class="development"><span>' + property.subdivision + '</span></li>';
            }
});

Handlebars.registerHelper("DFidxGalleryImages", function(property) {
	var htmlTemp=[];
	var totgallery='';
	if (property.gallery.length <= 1) {
		totgallery='no-zoom';
	}
	htmlTemp.push('<div class="wrap-slider '+totgallery+'">');
		htmlTemp.push('<ul>');
		for (var k = 0, m = property.gallery.length; k < m; k++) {
			if (k <= 0) {
				htmlTemp.push('<li class="flex-slider-current"><img class="flex-lazy-image" data-original="' + property.gallery[k] + '"></li>');
			} else {
				htmlTemp.push('<li class="flex-slider-item-hidden"><img class="flex-lazy-image" data-original="' + property.gallery[k] + '"></li>');
			}
	    }

	    htmlTemp.push('</ul>');
	    if (property.gallery.length > 1) {
	    	htmlTemp.push('<button class="prev flex-slider-prev"><span class="clidxboost-icon-arrow-select"></span></button>');
	    	htmlTemp.push('<button class="next flex-slider-next"><span class="clidxboost-icon-arrow-select"></span></button>');
	    }

	    if (property.hasOwnProperty("status") && property.status!="2" ) {
	    	if (property.is_favorite) {
	    		htmlTemp.push('<button class="clidxboost-btn-check flex-favorite-btn"><span class="clidxboost-icon-check active"></span></button>');
	        } else {
	        	htmlTemp.push('<button class="clidxboost-btn-check flex-favorite-btn"><span class="clidxboost-icon-check"></span></button>');
	        }
	    }
	htmlTemp.push('</div>');

return htmlTemp.join("");
});

Handlebars.registerHelper('DFformatSqft', function(sqft) {
	return _.formatPrice(sqft);
});

Handlebars.registerHelper("DFidxPermalinkModal", function(slug) {
	return __flex_idx_search_filter.propertyDetailPermalink + "/" + slug;
});

Handlebars.registerHelper('DFformatLotSize', function(lot_size) {
	return _.formatPrice(lot_size);
});

Handlebars.registerHelper("DFidxPermalink", function(slug) {
	return flex_idx_filter_params.propertyDetailPermalink + "/" + slug;
});

	function filter_refresh_search(topElementContent) {

		var filter_refresh_search = parseInt(topElementContent, 10);

		if(filter_refresh_search > 0){
			filter_refresh_search = filter_refresh_search
		}else{
			filter_refresh_search = 0;
		}

		var currentfiltemid = $(".flex-idx-filter-form:eq(0)").attr("filtemid");
		var idxboostnavresult ='.idxboost-content-filter-'+currentfiltemid+' #nav-results';
		var idxboostresult ='.idxboost-content-filter-'+currentfiltemid+' #result-search';
		var idx_oh=$( "input[name='idx[oh]']" ).val();

			if(typeof ajax_request_filter !== 'undefined')
			ajax_request_filter.abort();

			ajax_request_filter=$.ajax({
				url: flex_idx_filter_params.ajaxUrl,
				type: "POST",
				data: filter_metadata,
				dataType: "json",
				success: function(response) {
				   if ("yes" === __flex_g_settings.anonymous) {
					 var buildObjectFilter = {
					   search_url: location.href,
					   search_count: response.counter,
					   name: response.title,
					   search_query: response.condition
					 };

					 localStorage.setItem("IB_SAVE_FILTER_PAYLOAD", JSON.stringify(buildObjectFilter));
				   }

					var items = response.items;
					var listingHTML = [];
					var paginationHTML = [];
					var paging = response.pagination;
					var contentPage= {};

					setupMarkers(response.map_items);

					if (paging.total_pages_count > 1) {
						contentPage={ pagination: response.pagination };
					}

					var contentData = {
				      properties:response.items,
				      is_sold: true
				  	};
				  	//TEMPLATE PROPERTY
					var sourcePro = Handlebars.compile(IB_COMMERCIAL.html());
					var compilate = sourcePro(contentData);
					$(".result-search-commercial").html(compilate);
				  	//TEMPLATE PAGINATION
					var sourcePagina = Handlebars.compile(IB_PAGINATION.html());
					var compilatePag = sourcePagina(contentPage);
					$("#nav-results").html(compilatePag);

					//scroll top paginador $(window).scrollTop($('.clidxboost-sc-filters').offset().top);
					$("html, body").animate({ scrollTop: filter_refresh_search }, 0);
					
					
				  	$('#info-subfilters').html(word_translate.showing+' ' +paging.offset.start+' '+word_translate.to+' ' +paging.offset.end+' '+word_translate.of+' '+ _.formatPrice(response.counter)+' '+word_translate.properties+'.');
					myLazyLoad.update();
					idxboostTypeIcon();
				}
			});
	}


		$(document).on("click", ".flex-slider-next", function(event) {
			event.stopPropagation();
			var node = $(this).prev().prev().find('li.flex-slider-current');
			var index = node.index();
			var total = $(this).prev().prev().find('li').length;
			if (index >= (total - 1)) {
				index = 0;
			} else {
				index = index + 1;
			}
			// index = (index >= (total - 1)) ? 0 : (index + 1);
			$(this).prev().prev().find('li').removeClass('flex-slider-current');
			$(this).prev().prev().find('li').addClass('flex-slider-item-hidden');
			$(this).prev().prev().find('li').eq(index).removeClass('flex-slider-item-hidden').addClass('flex-slider-current');
			myLazyLoad.update();

			// Open Registration popup after 3 clicks property pictures are showed [force registration]
			if ("yes" === __flex_g_settings.anonymous) {
				if ( (__flex_g_settings.hasOwnProperty("force_registration")) && (1 == __flex_g_settings.force_registration) ) {
					countClickAnonymous++;
			
					if (countClickAnonymous >= 3) {
						$("#modal_login").addClass("active_modal")
						.find('[data-tab]').removeClass('active');
					
						$("#modal_login").addClass("active_modal")
							.find('[data-tab]:eq(1)')
							.addClass('active');
						
						$("#modal_login")
							.find(".item_tab")
							.removeClass("active");
						
						$("#tabRegister")
						.addClass("active");

						$("#modal_login #msRst").empty().html($("#mstextRst").html());
						$("button.close-modal").addClass("ib-close-mproperty");
						//$(".overlay_modal").css("background-color", "rgba(0,0,0,0.8);");

						/*TEXTO LOGIN*/
						var titleText = $(".header-tab a[data-tab='tabRegister']").attr('data-text')
						$("#modal_login .modal_cm .content_md .heder_md .ms-title-modal").html(titleText);

						jQuery(".ms-fub-register").removeClass("hidden");
						jQuery(".ms-footer-sm").addClass("hidden");

						if (jQuery('#follow_up_boss_valid_register').is(':checked')) {
							jQuery("#socialMediaRegister").removeClass("disabled");
						}else{
							jQuery("#socialMediaRegister").addClass("disabled");
						}
						countClickAnonymous = 0;
					}
				}
			}
		});

		$(document).on("click", ".flex-slider-prev", function(event) {
			event.stopPropagation();
			var node = $(this).prev().find('li.flex-slider-current');
			var index = node.index();
			var total = $(this).prev().find('li').length;
			index = (index === 0) ? (total - 1) : (index - 1);
			$(this).prev().find('li').removeClass('flex-slider-current');
			$(this).prev().find('li').addClass('flex-slider-item-hidden');
			$(this).prev().find('li').eq(index).removeClass('flex-slider-item-hidden').addClass('flex-slider-current');
			myLazyLoad.update();


			// Open Registration popup after 3 property pictures are showed [force registration]
			if ("yes" === __flex_g_settings.anonymous) {
				if ( (__flex_g_settings.hasOwnProperty("force_registration")) && (1 == __flex_g_settings.force_registration) ) {
					countClickAnonymous++;
			
					if (countClickAnonymous >= 3) {
						$("#modal_login").addClass("active_modal")
						.find('[data-tab]').removeClass('active');
					
						$("#modal_login").addClass("active_modal")
							.find('[data-tab]:eq(1)')
							.addClass('active');
						
						$("#modal_login")
							.find(".item_tab")
							.removeClass("active");
						
						$("#tabRegister")
						.addClass("active");

						$("#modal_login #msRst").empty().html($("#mstextRst").html());
						$("button.close-modal").addClass("ib-close-mproperty");
						//$(".overlay_modal").css("background-color", "rgba(0,0,0,0.8);");

						/*TEXTO LOGIN*/
						var titleText = $(".header-tab a[data-tab='tabRegister']").attr('data-text')
						$("#modal_login .modal_cm .content_md .heder_md .ms-title-modal").html(titleText);

						jQuery(".ms-fub-register").removeClass("hidden");
						jQuery(".ms-footer-sm").addClass("hidden");

						if (jQuery('#follow_up_boss_valid_register').is(':checked')) {
							jQuery("#socialMediaRegister").removeClass("disabled");
						}else{
							jQuery("#socialMediaRegister").addClass("disabled");
						}
						countClickAnonymous = 0;
					}
				}
			}

		});



		$viewFilter.on('change', 'select', function() {
			console.log($viewFilter);
			switch ($(this).find('option:selected').val()) {
				case 'grid':
					$viewFilter.removeClass('list map').addClass('grid');
					$wrapResult.removeClass('view-list view-map').addClass('view-grid');
					$cuerpo.removeClass('view-list view-map');
					$("#idx_view").val("grid");
					break
				case 'list':
					$viewFilter.removeClass('grid map').addClass('list');
					$wrapResult.removeClass('view-grid view-map').addClass('view-list');
					$cuerpo.addClass('view-list').removeClass('view-map');
					$("#idx_view").val("list");
					break
				case 'map':
					$viewFilter.removeClass('list grid').addClass('map');
					$wrapResult.removeClass('view-list view-grid').addClass('view-map');
					$cuerpo.removeClass('view-list').addClass('view-map');
					$("#idx_view").val("map");
					/*console.log('trigger map resize');
					google.maps.event.trigger(map, "resize");*/
					setTimeout(function() {
						var map_center = map.getCenter();
						var map_zoom = map.getZoom();
						google.maps.event.trigger(map, 'resize');
						if (renderedMarkers === false) {
							var bounds = new google.maps.LatLngBounds();
							for (var i = 0, l = markers.length; i < l; i++) {
								bounds.extend(markers[i].position);
							}
							map.fitBounds(bounds);
						} else {
							map.setCenter(map_center);
							map.setZoom(map_zoom);
						}
					}, 100);
					break
			}
			new LazyLoad({
			  callback_error: function(element){
				$(element).attr('src','https://idxboost.com/i/default_thumbnail.jpg').removeClass('error').addClass('loaded');
				$(element).attr('data-origin','https://idxboost.com/i/default_thumbnail.jpg');
			  }
			});
		});
		// Cambio de estado por select combertido a lista
		$viewFilter.on('click', 'li', function() {
			currentfiltemid=$(this).parent('ul').parent('li').attr('filtemid');
			$(this).addClass('active').siblings().removeClass('active');
			switch ($(this).attr('class').split(' ')[0]) {
				case 'grid':
					$('.idxboost-content-filter-'+currentfiltemid+' ').find($wrapResult).removeClass('view-list view-map').addClass('view-grid');
					$cuerpo.removeClass('view-list view-map');
					
					/*Desactivando scrollResultados(false)*/
					break
				case 'list':
					$('.idxboost-content-filter-'+currentfiltemid+' ').find($wrapResult).removeClass('view-grid view-map').addClass('view-list');
					$cuerpo.addClass('view-list').removeClass('view-map');
					/*Desactivando scrollResultados(false)*/
					break
				case 'map':
					$('.idxboost-content-filter-'+currentfiltemid+' ').find($wrapResult).removeClass('view-list view-grid').addClass('view-map');
					$cuerpo.removeClass('view-list').addClass('view-map');
					/*Desactivando scrollResultados(true);*/
					// showFullMap();
					break
			}
			new LazyLoad({
			  callback_error: function(element){
				$(element).attr('src','https://idxboost.com/i/default_thumbnail.jpg').removeClass('error').addClass('loaded');
				$(element).attr('data-origin','https://idxboost.com/i/default_thumbnail.jpg');
			  }
			});
		});

		$("#filter-views").on("click", "li", function() {
			if ($(this).hasClass("map")) {
				mapIsVisible = true;
				setTimeout(function() {
					var map_center = map.getCenter();
					var map_zoom = map.getZoom();
					google.maps.event.trigger(map, 'resize');
					if (renderedMarkers === false) {
						var bounds = new google.maps.LatLngBounds();
						for (var i = 0, l = markers.length; i < l; i++) {
							bounds.extend(markers[i].position);
						}
						map.fitBounds(bounds);
					} else {
						map.setCenter(map_center);
						map.setZoom(map_zoom);
					}
				}, 100);
			} else {
				mapIsVisible = false;
			}
			new LazyLoad({
			  callback_error: function(element){
				$(element).attr('src','https://idxboost.com/i/default_thumbnail.jpg').removeClass('error').addClass('loaded');
				$(element).attr('data-origin','https://idxboost.com/i/default_thumbnail.jpg');
			  }
			});
		});

		flex_pagination = $('.nav-results');
		if (flex_pagination.length) {
			flex_pagination.on('click', 'a', function(event) {
				event.preventDefault();
				var currentPage = $(this).data('page');
				filter_metadata.page = currentPage;

				var scrollTopElement = $(".clidxboost-sc-filters");
				if(scrollTopElement.length){
					scrollTopElement = (($(".clidxboost-sc-filters").offset().top) * 1) - 100;
				}else{
					scrollTopElement = 0;
				}

				filter_refresh_search(scrollTopElement);
			});
		}

		FILTER_PAGE_URL = $('#flex_idx_sort').data('permalink');
		FILTER_PAGE_CURRENT = $('#flex_idx_sort').data('currpage');
		view_options = $(".filter-views li");
		sort_options = $(".flex_idx_sort");
		if (view_options.length) {
			view_options.on("click", function() {
				currentfiltemid=$(this).attr('filtemid');

				if ($(this).hasClass("active")) {
					return;
				}
				var current_view = $(this).html().toLowerCase();
				var current_sort = sort_options.val();
			});
		}
		if (sort_options.length) {
			sort_options.on("change", function() {
				currentfiltemid=$(this).attr('filtemid');

				var current_view = $('#filter-views li.active:eq(0)').html();
				var current_sort = $(this).val();
				filter_metadata.order_by = current_sort;
				filter_refresh_search();
			});
		}
		flex_ui_loaded = true;

		function mutaSelectViews(estado) {
			if (estado) {
				if (!$viewFilter.find('ul').length) {
					//console.log('muto a lista, el Ancho es: ' + $ventana.width());
					var $optionActive = $viewFilter.find('option:selected').val();
					$viewFilter.find('option').each(function() {
						$(this).replaceWith('<li class="' + $(this).val() + '">' + $(this).text() + '</li>');
					});
					var $theSelect = $viewFilter.find('select');
					$theSelect.replaceWith('<ul>' + $theSelect.html() + '</ul>');
					$viewFilter.find('.' + $optionActive).addClass('active');
					$viewFilter.removeClass($optionActive);
				}
			} else {
				if (!$viewFilter.find('select').length) {
					//console.log('muto a select nativo, el Ancho es: ' + $ventana.width());
					var $indexLiActive = $viewFilter.find('.active').index();
					var $classLiActive = $viewFilter.find('.active').attr('class').split(' ')[0];
					$viewFilter.find('li').each(function() {
						$(this).replaceWith('<option value="' + $(this).attr('class').split(' ')[0] + '">' + $(this).text() + '</option>');
					});
					var $theUl = $viewFilter.find('ul');
					$theUl.replaceWith('<select>' + $theUl.html() + '</select>');
					$viewFilter.find('option').eq($indexLiActive).prop('selected', true).siblings().prop('selected', false);
					$viewFilter.addClass($classLiActive);
				}
			}
		}

		if ($ventana.width() >= 768) {
			mutaSelectViews(true); //,por defecto que mute
		}
		// Al redimencionar muto los selects o Ul si corresponde
		$ventana.on('resize', function() {
			var $widthVentana = $ventana.width();
			if ($widthVentana >= 768) {
				mutaSelectViews(true)
			} else if ($widthVentana < 768) {
				mutaSelectViews(false);
			}
		});

		$("#wrap-list-result").on('scroll',function(){
			myLazyLoad.update();
		});

		if (filter_metadata.action == "ib_boost_dinamic_data_agent_office"){
			$("#result-search, .result-search-commercial").on("click", ".view-detail", function(event) {
				event.stopPropagation();
				event.preventDefault();
				var mlsNumber = $(this).parent('li').data('mls')
				loadPropertyInModal(mlsNumber);
			});
		}



		$('#result-search, .result-search-commercial').on("click", ".flex-favorite-btn", function(event) {
			event.stopPropagation();
			event.preventDefault();
			// active
			var buton_corazon = $(this);
			if (__flex_g_settings.anonymous === "yes") {
				//active_modal($('#modal_login'));
				 $("#modal_login").addClass("active_modal").find('[data-tab]').removeClass('active');
				 $("#modal_login").addClass("active_modal").find('[data-tab]:eq(1)').addClass('active');
				 $("#modal_login").find(".item_tab").removeClass("active");
				 $("#tabRegister").addClass("active");
				 $("button.close-modal").addClass("ib-close-mproperty");
				 $(".overlay_modal").css("background-color", "rgba(0,0,0,0.8);");
				 $("#modal_login h2").html(
				 $("#modal_login").find("[data-tab]:eq(1)").data("text-force"));
				 /*Asigamos el texto personalizado*/
				 var titleText = $(".header-tab a[data-tab='tabRegister']").attr('data-text')
				 $("#modal_login .modal_cm .content_md .heder_md .ms-title-modal").html(titleText);

			} else {
				// ajax favorite
				var class_id = $(this).parents('.propertie').data('class-id');
				var mls_num = $(this).parents('.propertie').data("mls");
				var property_subject = $(this).parents('.propertie').data("address");

				if (!$(this).find('.clidxboost-icon-check').hasClass('active')) {
					//console.log('mark as favorite');
					$(this).find('.clidxboost-icon-check').addClass('active');
					$.ajax({
						url: flex_idx_filter_params.ajaxUrl,
						method: "POST",
						data: {
							action: "flex_favorite",
							class_id: class_id,
							mls_num: mls_num,
							subject:property_subject,
							search_url: window.location.href,
							type_action: 'add'
						},
						dataType: "json",
						success: function(data) {
							/*console.log(data.message);
							active_modal($('#modal_add_favorities'));
							setTimeout(function() {
								$('#modal_add_favorities').find('.close').click();
							}, 2000); */
							$(buton_corazon).attr("data-alert-token", data.token_alert);
						}
					});
				} else {
					//console.log('remove from favorites');
					$(this).find('.clidxboost-icon-check').removeClass('active');
					var token_alert = $(this).attr("data-alert-token");
					$.ajax({
						url: flex_idx_filter_params.ajaxUrl,
						method: "POST",
						data: {
							action: "flex_favorite",
							class_id: class_id,
							mls_num: mls_num,
							type_action: 'remove',
							token_alert: token_alert
						},
						dataType: "json",
						success: function(data) {
							//console.log(data.message);
							$(buton_corazon).attr("data-alert-token", '');
						}
					});
				}
			}
		});
