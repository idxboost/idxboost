var map;
var bounds;
(function($) {
    var ajax_request_filter;
    view_grid_type='grid';
    
    var markers = [];
    var infoWindow;
    var myLazyLoad;
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
    var $cuerpo = jQuery("body");
    var $ventana = jQuery(window);

    $(document).ready(function(){
        idx_search_filter();
    });   

    function initialize() {
        
        var style_map=[];
    
        if(style_map_idxboost != undefined && style_map_idxboost != '') {
            style_map=JSON.parse(style_map_idxboost);
        }
    
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

            map = new google.maps.Map(
                document.getElementById('code-map'), {
                center: new google.maps.LatLng(25.761680, -80.19179),
                mapTypeId: google.maps.MapTypeId.ROADMAP,
                zoom: 16,
                disableDoubleClickZoom: true,
                scrollwheel: false,
                panControl: false,
                streetViewControl: false,
                disableDefaultUI: true,
                clickableIcons: false,
                styles: style_map,
                gestureHandling: ("1" == __flex_g_settings.is_mobile) ? 'greedy' : 'cooperative'
            });
            google.maps.event.addListenerOnce(map, 'tilesloaded', setupMapControls);
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

        function setupMapControls() {
            mapButtonsWrapper = document.createElement("div");
            mapButtonsWrapper.classList.add('flex-map-controls-ct');
            mapZoomInButton = document.createElement("div");
            mapZoomInButton.classList.add('flex-map-zoomIn');
            mapButtonsWrapper.appendChild(mapZoomInButton);
            mapZoomOutButton = document.createElement("div");
            mapZoomOutButton.classList.add('flex-map-zoomOut');
            mapButtonsWrapper.appendChild(mapZoomOutButton);
            google.maps.event.addDomListener(mapZoomInButton, "click", handleZoomInButton);
            google.maps.event.addDomListener(mapZoomOutButton, "click", handleZoomOutButton);
            map.controls[google.maps.ControlPosition.TOP_RIGHT].push(mapButtonsWrapper);
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
                    infobox_content.push('<a class="ib-load-property-iw" data-mls="' + property_group.mls_num + '" href="' + flex_idx_sold_statistics.propertyDetailPermalink + '/' + property_group.slug + '" title="' + property_group.address_short.replace(/# /, "#") + ', ' + property_group.address_large.replace(/ , /, ", ") + '">' + property_group.address_short.replace(/# /, "#") + ', ' + property_group.address_large.replace(/ , /, ", ") + '</a>');
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
                infobox_content.push('<a class="ib-load-property-iw" data-mls="' + property.item.mls_num + '" href="' + flex_idx_sold_statistics.propertyDetailPermalink + '/' + property.item.slug + '" title="' + property.item.address_short.replace(/# /, "#") + ', ' + property.item.address_large.replace(/ , /, ", ") + '">' + property.item.address_short.replace(/# /, "#") + ', ' + property.item.address_large.replace(/ , /, ", ") + '</a>');
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
    
    google.maps.event.addDomListener(window, 'load', initialize);

    function showFullMap() {
        var flex_map_mini_view = $("#code-map");
        var myLatLng2 = {
            lat: parseFloat(flex_map_mini_view.data('lat')),
            lng: parseFloat(flex_map_mini_view.data('lng'))
        };
        var miniMap = new google.maps.Map(document.getElementById('code-map'), {
            zoom: 16,
            center: myLatLng2
        });
        var marker = new google.maps.Marker({
            position: myLatLng2,
            map: miniMap
        });
        google.maps.event.trigger(miniMap, "resize");
        $("#code-map").removeAttr("data-lat");
        $("#code-map").removeAttr("data-lng");
    }

    function setupMarkers(properties) {
        //if ( item.lat != '' && item.lng !='' && item.lat != null && item.lng != null ){
            arrayother = properties;
            bounds = new google.maps.LatLngBounds(),
                marker=[],
                property=[],
                row=null,
                i=0;

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
    
                    if (__flex_g_settings.anonymous === 'yes') {
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

                        localStorage.setItem("ib_anon_mls", mlsNum);
                        return;
                    }
    
                    $('html').addClass('modal_mobile');
                    $('#modal_property_detail').addClass('active_modal');
                    $("#modal_property_detail .detail-modal").html('<span class="ib-modal-property-loading">Loading property details...</span>');
    
                    $.ajax({
                        type: "POST",
                        url: __flex_g_settings.ajaxUrl,
                        data: { mlsNumber: mlsNum, action: "load_modal_property" },
    
                        success: function (response) {
                          $(document.body).addClass("modal-property-active");
                          $("#modal_property_detail .detail-modal").html(response);
                        },
    
                        complete: function(){
                          $('#full-main #clidxboost-data-loadMore-niche').trigger("click");
                          loadFullSlider(".clidxboost-full-slider");
                        }
                    });
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


        
        $('.f-pricerange').change(function(){
            var price_range=$(this).val();
            if(price_range =='1'){
                flex_idx_sold_statistics.price_min=0;
                flex_idx_sold_statistics.price_max=1000000;
            }else if(price_range=='2'){
                flex_idx_sold_statistics.price_min=1000001;
                flex_idx_sold_statistics.price_max=2000000;
            }else if(price_range =='3'){
                flex_idx_sold_statistics.price_min=2000001;
                flex_idx_sold_statistics.price_max=3000000;
            }
            else if(price_range=='4'){
                flex_idx_sold_statistics.price_min=3000001;
                flex_idx_sold_statistics.price_max=5000000;
            }else if(price_range =='5'){
                flex_idx_sold_statistics.price_min=5000001;
                flex_idx_sold_statistics.price_max=7500000;
            }else if(price_range=='6'){
                flex_idx_sold_statistics.price_min=7500001;
                flex_idx_sold_statistics.price_max=100000000;
            }else if(price_range =='7'){
                flex_idx_sold_statistics.price_min=0;
                flex_idx_sold_statistics.price_max=100000000;
            }
            flex_idx_sold_statistics.page=1;
            idx_search_filter();
        });

        $('.f-neighborhood').change(function(){
            flex_idx_sold_statistics.city_id= $(this).val();
            flex_idx_sold_statistics.page=1;
            idx_search_filter();
        });

        $('.f-ptype').change(function(){
            flex_idx_sold_statistics.class_id= $(this).val();
            flex_idx_sold_statistics.page=1;
            idx_search_filter();
        });        

        $('.js-pstyle').click(function(){
            var textStyle='regular';
            if (jQuery("#regular").is(":checked") )
                textStyle='regular';

            if (jQuery("#new").is(":checked") )
                textStyle='new';

            if (jQuery("#no_waterfront").is(":checked") )
                textStyle='no_waterfront';

            if (jQuery("#waterfront").is(":checked") )
                textStyle='waterfront';

            flex_idx_sold_statistics.property_style= textStyle;
            flex_idx_sold_statistics.page=1;
            idx_search_filter();
        });     
        
        $('.flex_idx_sort').change(function(){
            flex_idx_sold_statistics.sort= $(this).val();
            flex_idx_sold_statistics.page=1;
            idx_search_filter();
        });     
        
        

    function idx_search_filter() {
        var currentfiltemid = flex_idx_sold_statistics.class_form;
        var flex_filter_form = $('.flex-idx-filter-form-'+ currentfiltemid);
        var idxboost_filter_class = flex_filter_form.attr('class');
        idxboost_filter_class = '.flex-idx-filter-form-'+ flex_idx_sold_statistics.class_form;
        var idxboostnavresult ='.idxboost-content-filter-'+currentfiltemid+' #nav-results';
        var idxboostresult ='.idxboost-content-filter-'+currentfiltemid+' #result-search';
        var idx_oh=$( "input[name='idx[oh]']" ).val();
        
        if(typeof ajax_request_filter !== 'undefined')
            ajax_request_filter.abort();

            ajax_request_filter=

            $.ajax({
                url: flex_idx_sold_statistics.ajaxUrl,
                method: "POST",
                data: {
                    action: "flex_statistics_filter_sold",
                    class_id: flex_idx_sold_statistics.class_id,
                    city_id:   flex_idx_sold_statistics.city_id,
                    price_min:  flex_idx_sold_statistics.price_min,
                    price_max:  flex_idx_sold_statistics.price_max,
                    property_type :  flex_idx_sold_statistics.property_type,
                    property_style :  flex_idx_sold_statistics.property_style,
                    page:   flex_idx_sold_statistics.page,
                    order:   flex_idx_sold_statistics.sort,
                    close_date_start:   flex_idx_sold_statistics.close_date_start,
                    close_date_end:   flex_idx_sold_statistics.close_date_end
                },dataType: "json",
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
                    /*
                    $("html, body").animate({
                        scrollTop: $("#wrap-subfilters").offset().top
                    }, 700);
                    */
                    var items = response.items;
                    var listingHTML = [];
                    var paginationHTML = [];
                    var paging = response.pagination;

                    // xhr_running = false;
                    // $('#properties-found').html('<span>' + _.formatShortPrice(response.counter) + '</span> Properties');
  /*
                    $("#filter-save-search").data("count", response.counter);
                    $('#properties-found-2').html(_.formatShortPrice(response.counter));
                    $('#fs_inner_c').html(_.formatShortPrice(response.counter));
                    $('#info-subfilters').html(word_translate.showing+' ' +paging.offset.start+' '+word_translate.to+' ' +paging.offset.end+' '+word_translate.of+' '+ _.formatPrice(response.counter)+' '+word_translate.properties+'.');
                    $('#title-subfilters').html('<span>' + response.heading + '</span>');
*/
                    // dataLayer Tracking Collection
                    if (typeof dataLayer !== "undefined") {
                        if (__flex_g_settings.hasOwnProperty("has_dynamic_remarketing") && ("1" == __flex_g_settings.has_dynamic_remarketing)) {
                            if ("undefined" !== typeof dataLayer) {
                                if (response.hasOwnProperty("items") && response.items.length) {
                                    var mls_list = _.pluck(response.items, "mls_num");
                                    var build_mls_list = [];
                                    for (var i = 0, l = mls_list.length; i < l; i++) {
                                        build_mls_list.push({ id: mls_list[i], google_business_vertical: 'real_estate' });
                                    }

                                    if (build_mls_list.length) {
                                        dataLayer.push({ "event": "view_item_list", "items": build_mls_list });

                                        build_mls_list.length = 0;
                                    }
                                }
                            }
                        }
                    }

                    
                    for (var i = 0, l = items.length; i < l; i++) {
                        var item = response.items[i];

                        if(item.address_short !='' && item.address_short != null ){
                            item.address_short = item.address_short.replace(/# /, "#");
                        }

                        if(item.address_large !=''  && item.address_large != null ){                        
                            item.address_large = item.address_large.replace(/ , /, ", ");
                        }

                        var text_is_rental='';
                        if (item.is_rental=='1')
                            text_is_rental='/'+word_translate.month;


                        var al = item.address_large.split(", ");
                        var st = al[1].replace(/[\d\s]/g, "");
                        var final_address = item.address_short + " " + al[0] + ", " + st;
                        var final_address_parceada = item.address_short + " <span>" + al[0] + ", " + al[1] + "</span>";
                        var final_address_parceada_new='';
                        if(item.address_short != null && item.address_short != ''){
                            final_address_parceada_new = " <span>"+ item.address_short.replace(/# /, "#") +", " + al[0] + ", " + al[1] + "</span>";
                        }
                        

                        listingHTML.push('<li data-geocode="' + item.lat + ':' + item.lng + '" data-class-id="' + item.class_id + '" data-mls="' + item.mls_num + '" data-address="'+item.address_short+'" class="propertie">');
                        
                        //if (idx_oh=="0" ) {

                            if (item.hasOwnProperty("status")) {
                                if (item.status == "5") {
                                    listingHTML.push('<div class="flex-property-new-listing">'+word_translate.rented+'</div>');
                                } else if (item.status == "2") {
                                    listingHTML.push('<div class="flex-property-new-listing">'+word_translate.sold+'</div>');
                                }else if(item.status != "1"){
                                    listingHTML.push('<div class="flex-property-new-listing">'+item.status_name+'</div>');
                                }                           
                            } else {
                                if (item.recently_listed === "yes") {
                                    listingHTML.push('<div class="flex-property-new-listing">'+word_translate.new_listing+'</div>');
                                }
                            }
                        //}

                        if (view_grid_type=='1'){
                            listingHTML.push('<h2 title="'+item.full_address+'" class="ms-property-address"><div class="ms-title-address -address-top">'+item.full_address_top+'</div><div class="ms-br-line">,</div><div class="ms-title-address -address-bottom">'+item.full_address_bottom+'</div></h2>');
                        }else{
                            listingHTML.push('<h2 title="'+item.full_address+'" class="ms-property-address"><div class="ms-title-address -address-top">'+item.full_address+'</div></h2>');
                        }

                        listingHTML.push('<ul class="features">');
                        listingHTML.push('<li class="address">' + final_address_parceada_new + '</li>');
                        listingHTML.push('<li class="price">$' + _.formatPrice(item.price) + text_is_rental + '</li>');
                        if (item.reduced == '') {
                            listingHTML.push('<li class="pr">' + item.reduced + '</li>');
                        } else if (item.reduced < 0) {
                            listingHTML.push('<li class="pr down">' + item.reduced + '%</li>');
                        } else {
                            listingHTML.push('<li class="pr up">' + item.reduced + '%</li>');
                        }
                        var textbed = word_translate.bed;
                        if (item.bed > 1) {
                            textbed = word_translate.beds;
                        } else {
                            textbed = word_translate.bed;
                        }
                        listingHTML.push('<li class="beds">' + item.bed + ' <span>' + textbed + ' </span></li>');
                        var textbath = word_translate.bath;
                        if (item.bath > 1) {
                            textbath = word_translate.baths;
                        } else {
                            textbath = word_translate.bath;
                        }
                        if (item.baths_half > 0) {
                            listingHTML.push('<li class="baths">' + item.bath + '.5 <span>' + textbath + ' </span></li>');
                        } else {
                            listingHTML.push('<li class="baths">' + item.bath + ' <span>' + textbath + ' </span></li>');
                        }
                        listingHTML.push('<li class="living-size"> <span>' + _.formatPrice(item.sqft) + '</span>'+word_translate.sqft+' <span>(' + item.living_size_m2 + ' m²)</span></li>');
                        listingHTML.push('<li class="price-sf"><span>$' + item.price_sqft + ' </span>/ '+word_translate.sqft+'<span>($' + item.price_sqft_m2 + ' m²)</span></li>');
                        if (item.development !== '') {
                            listingHTML.push('<li class="development"><span>' + item.development + '</span></li>');
                        } else if (item.complex !== '') {
                            listingHTML.push('<li class="development"><span>' + item.complex + '</span></li>');
                        } else {
                            listingHTML.push('<li class="development"><span>' + item.subdivision + '</span></li>');
                        }
                        //listingHTML.push('<li class="ms-logo-board"><img src="https://idxboost-spw-assets.idxboost.us/logos/fmls.png"></li>');
                        listingHTML.push('</ul>');
                        var totgallery='';
                        if (item.gallery.length <= 1) {
                            totgallery='no-zoom';
                        }
                        listingHTML.push('<div class="wrap-slider '+totgallery+'">');
                        listingHTML.push('<ul>');
                        for (var k = 0, m = item.gallery.length; k < m; k++) {
                            // listingHTML.push('<li><img src="' + item.gallery[k] + '" data-src="' + item.gallery[k] + '"></li>');
                            if (k <= 0) {
                                listingHTML.push('<li class="flex-slider-current"><img class="flex-lazy-image" data-original="' + item.gallery[k] + '"></li>');
                            } else {
                                listingHTML.push('<li class="flex-slider-item-hidden"><img class="flex-lazy-image" data-original="' + item.gallery[k] + '"></li>');
                            }
                        }
                        listingHTML.push('</ul>');
                        if (item.gallery.length > 1) {
                            listingHTML.push('<button class="prev flex-slider-prev"><span class="clidxboost-icon-arrow-select"></span></button>');
                            listingHTML.push('<button class="next flex-slider-next"><span class="clidxboost-icon-arrow-select"></span></button>');
                        }

                        listingHTML.push('</div>');
                        
                        listingHTML.push('<a href="'+flex_idx_sold_statistics.propertyDetailPermalink+'/'+item.slug+'" class="view-detail">'+final_address_parceada_new+'</a>');

                        listingHTML.push('<a class="view-map-detail" data-geocode="'+item.lat + ':' + item.lng+'">View Map</a>');
                        
                        if (idx_oh=="1" && item.hasOwnProperty("oh_info") ) {
                          var oh_info=JSON.parse(item.oh_info);
                          if (typeof(oh_info) === "object" && oh_info.hasOwnProperty("date") && oh_info.hasOwnProperty("timer") ) {
                            listingHTML.push('<div class="ms-open"><span class="ms-wrap-open"><span class="ms-open-title">Open House</span><span class="ms-open-date">'+oh_info.date+'</span><span class="ms-open-time">'+oh_info.timer+'</span></span></div>');
                          }                          
                        }                        

                        listingHTML.push('</li>');
                    }
                    $(idxboostresult).html(listingHTML.join("")).ready(function() {  idxboostTypeIcon();  if(typeof ppchack === 'function') { ppchack(); }  if(typeof idxboost_Hackedbox_cpanel === 'function') { idxboost_Hackedbox_cpanel(); } });


                    if (paging.total_pages_count > 1) {
                        paginationHTML.push('<span id="indicator">'+word_translate.page+' ' + paging.current_page_number+' '+ word_translate.of+' ' + _.formatPrice(paging.total_pages_count) + '</span>');
                        if (paging.has_prev_page && paging.total_pages_count > 1) {
                            paginationHTML.push('<a href="#" data-page="1" title="First Page" id="firstp" class="ad visible">');
                            paginationHTML.push('<span class="clidxboost-icon-arrow-select"></span>');
                            paginationHTML.push('<span class="clidxboost-icon-arrow-select"></span>');
                            paginationHTML.push('<span>First page</span>');
                            paginationHTML.push('</a>');
                        }
                        if (paging.has_prev_page) {
                            paginationHTML.push('<a href="#" data-page="' + (paging.current_page_number - 1) + '" title="Prev Page" id="prevn" class="arrow clidxboost-icon-arrow-select prevn visible">');
                            paginationHTML.push('<span>Previous page</span>');
                            paginationHTML.push('</a>');
                        }
                        paginationHTML.push('<ul id="principal-nav">');
                        for (var i = 0, l = paging.range.length; i < l; i++) {
                            var loopPage = paging.range[i];
                            // if (i <= 3) {
                            if (paging.current_page_number === loopPage) {
                                paginationHTML.push('<li class="active"><a href="#" data-page="' + loopPage + '">' + loopPage + '</a></li>');
                            } else {
                                paginationHTML.push('<li><a href="#" data-page="' + loopPage + '">' + loopPage + '</a></li>');
                            }
                            // }
                        }
                        paginationHTML.push('</ul>');
                        if (paging.has_next_page) {
                            paginationHTML.push('<a href="#" data-page="' + (paging.current_page_number + 1) + '" title="Prev Page" id="nextn" class="arrow clidxboost-icon-arrow-select nextn visible">');
                            paginationHTML.push('<span>Next page</span>');
                            paginationHTML.push('</a>');
                        }
                        if (paging.has_next_page && paging.total_pages_count > 1) {
                            paginationHTML.push('<a href="#" data-page="' + paging.total_pages_count + '" title="First Page" id="lastp" class="ad visible">');
                            paginationHTML.push('<span class="clidxboost-icon-arrow-select"></span>');
                            paginationHTML.push('<span class="clidxboost-icon-arrow-select"></span>');
                            paginationHTML.push('<span>Last page</span>');
                            paginationHTML.push('</a>');
                        }
                    }

                    $(idxboostnavresult).html(paginationHTML.join(""));
                    $('.flex-loading-ct').fadeIn();
                    var idxboost_price_filter = '',
                        idxboost_view_filter = '',
                        idxboost_pagenum_filter = '',
                        idxboost_water_filter = '',
                        idxboost_parking_filter = '',
                        idxboost_lotsize_filter = '',
                        idxboost_bed_filter = '',
                        idxboost_bath_filter = '',
                        idxboost_orderby_filter = '',
                        idxboost_year_filter = '',
                        idxboost_sqft_filter = '';


                    // $("#flex-idx-search-form").data('save_slug', flex_idx_new_url);

                    $("#search_count").val(response.counter);
                    idxboostcondition = response.condition;
                    $(idxboost_filter_class + " #flex-idx-search-form").data('save_count', response.counter);
                    $(idxboost_filter_class + " #flex-idx-search-form").data('next_page', response.pagination.has_next_page);
                    $(idxboost_filter_class + " #flex-idx-search-form").data('current_page', response.pagination.current_page_number);
                    // close all infowindow
                    if (typeof infoWindow !== 'undefined') {
                        if (infoWindow.isOpen()) {
                            infoWindow.close();
                        }
                    }

                    /*BUILD THE URL CODE */
                    idx_param_url=[];
                    var min_par=0;              
                    var max_par=0;
                    if(flex_idx_sold_statistics.price_min != ""){
                        min_par=parseInt(flex_idx_sold_statistics.price_min);
                    }                    
                    
                    if(flex_idx_sold_statistics.price_max != ""){
                        max_par=parseInt(flex_idx_sold_statistics.price_max);
                    }

                    if(min_par > max_par){
                        min_par=0;
                        max_par=1000000;
                    }
                    idx_param_url.push("price="+min_par+"~"+max_par);
                
                    if(flex_idx_sold_statistics.city_id != ""){
                        idx_param_url.push("city="+flex_idx_sold_statistics.city_id);
                    }
                    
                    if(flex_idx_sold_statistics.class_id != ""){
                        idx_param_url.push("property_type="+flex_idx_sold_statistics.class_id);
                    }                    
                    
                    if(flex_idx_sold_statistics.property_style != ""){
                        idx_param_url.push("property_style="+flex_idx_sold_statistics.property_style);
                    }                                      
                    
                    if(flex_idx_sold_statistics.page != ""){
                        idx_param_url.push("page="+flex_idx_sold_statistics.page);
                    }                    

                    if(flex_idx_sold_statistics.sort != ""){
                        idx_param_url.push("sort=price-desc");
                    }


                    var min_close=0;
                    var max_close=0;
                    if(flex_idx_sold_statistics.close_date_start != ""){
                        min_close=parseInt(flex_idx_sold_statistics.close_date_start);
                    }

                    if(flex_idx_sold_statistics.close_date_end != ""){
                        max_close=parseInt(flex_idx_sold_statistics.close_date_end);
                    }
                    /*dynamic date*/
                    if(min_close > max_close){
                        var currentdate = new Date();
                        if ((currentdate.getMonth()+1) < 10){
                            var getMonth = '0' + (currentdate.getMonth()+1);
                        }
                        var datetime = currentdate.getFullYear() + getMonth + currentdate.getDate() ;

                        var startdate = new Date();
                        var startdate = add_months(startdate, -6);

                        if ((startdate.getMonth()+1) < 10){
                            var getMonthold = '0' + (startdate.getMonth()+1);
                        }else{
                            var getMonthold = (startdate.getMonth()+1);

                        }
                        var old_date = startdate.getFullYear() +''+ getMonthold +''+ startdate.getDate() ;

                        min_close=old_date;
                        max_close=datetime;
                    }
                    idx_param_url.push("close_date="+min_close+"~"+max_close);

                    /*BUILD THE URL CODE */
                    
                    var flex_idx_new_url = flex_idx_sold_statistics.wpsite + "?" + idx_param_url.join('&');
                    history.pushState(null, '', flex_idx_new_url);

                    $('#wrap-list-result').show();
                    $('#paginator-cnt').show();
                    jQuery('#form-save .list-check .flex-save-type-options').removeAttr("disabled");
                    // reset scroll
                    if ($('.wrap-result').hasClass('view-map')){
                        $('#wrap-list-result').scrollTop(0);
                    }                    
                    // window.scrollTo(0, 0);
                    // first clean old markers
                    removeMarkers();
                   // $(window).scrollTop($('.clidxboost-sc-filters').offset().top);
                    setupMarkers(response.map_items);
                    // check lazy images
                    if (typeof myLazyLoad != 'undefined') {
                        myLazyLoad.update();
                    }
                    setInitialStateSlider();
                }
            });
    }

    function add_months(dt, n)
    {
        return new Date(dt.setMonth(dt.getMonth() + n));
    }
    function setInitialStateSlider() {
        $("#wrap-result").find(".wrap-slider > ul li:first").each(function() {
            $(this).addClass("flex-slider-current");
        });
    }    

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
    });
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
    });    

    flex_pagination = $('.nav-results');
    if (flex_pagination.length) {
        flex_pagination.on('click', 'a', function(event) {
            event.preventDefault();
            var currentPage = $(this).data('page');
            currentfiltemid = $(this).parent('li').parent('ul').parent('nav').attr('filtemid');
            if($(this).attr('id')=='nextn' || $(this).attr('id')=='lastp' || $(this).attr('id')=='firstp' || $(this).attr('id')=='prevn' ) {
                currentfiltemid=$(this).parent('nav').attr('filtemid');
            }

            $('.nav-results-'+currentfiltemid+' ul#principal-nav li').removeClass('active');
            $('.nav-results-'+currentfiltemid+' ul#principal-nav #page_' + currentPage).addClass('active');
            // history.pushState(null, '', $(this).attr('norefre'));
            flex_idx_sold_statistics.page=currentPage;
            idx_search_filter();
        });
    }

    
    view_options = $(".filter-views li");
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
    
   var $viewFilter = $('.filter-views');
   if ($viewFilter.length) {
       var $wrapResult = $('.wrap-result');
       // Cambio de vista por SELECT NATIVO
       $viewFilter.on('change', 'select', function() {
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
                   
                   google.maps.event.trigger(map, "resize");
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
                   }, 1000);
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
                   google.maps.event.trigger(map, "resize");
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
                   }, 1000);
                   
                   break
           }
           new LazyLoad({
             callback_error: function(element){
               $(element).attr('src','https://idxboost.com/i/default_thumbnail.jpg').removeClass('error').addClass('loaded');
               $(element).attr('data-origin','https://idxboost.com/i/default_thumbnail.jpg');
             }
           });
       });
       var $wrapListResult = $('#wrap-list-result'); //seteo esto
       function scrollResultados(estado) {
           if (estado) { // creo slider
               if ($ventana.width() >= 1024) {
                   if (!$wrapListResult.hasClass('ps-container')) {
                       $wrapListResult.perfectScrollbar({
                           suppressScrollX: true
                       });
                       $wrapListResult.on('ps-y-reach-end', function() {
                           if (!$wrapListResult.hasClass('loading-more')) {
                               $wrapListResult.addClass('loading-more');
                               /////// PAUSADO
                               //-------- luego de cargar los nuevos items POR AJAX-------
                               /*
                               var moreItems = false; // pongo esto para ver si hay más items a agregar, puede ser que el resultado solo alcanse para 1 página.
                               // 'Page % - LISTINGS % to %'
                               if (!moreItems) { //
                                 var $textThComplet;
                                 var $currentPage = $resultSearch.attr('data-cpage');
                                 if ($currentPage !== undefined) {
                                   $resultSearch.attr('data-cpage', Number($currentPage) + 1)
                                   //$textThComplet =
                                 } else {
                                   // estoy en la primera página, asi que le pongo que estaré en la 2
                                   $resultSearch.attr('data-cpage', '2');
                                 }
                                 $resultSearch.append('<li class="th-page">' + $textThComplete + '</li>' + $resultSearch.html()).promise().done(function(){
                                   $wrapListResult.perfectScrollbar('update');
                                   $wrapListResult.removeClass('loading-more');
                                 });
                               }
                               ////// AUN FALTA TRABAJAR EN ESTO
                               */
                           }
                       });
                   }
               }
           } else { // lo destruyo
               if ($wrapListResult.hasClass('ps-container')) {
                   $wrapListResult.perfectScrollbar('destroy');
                   /*
                   $wrapListResult.removeClass('ps-container ps-theme-default ps-active-y');
                   $wrapListResult.removeAttr('data-ps-id');
                   $wrapListResult.find('.ps-scrollbar-x-rail, .ps-scrollbar-y-rail').remove();
                   $wrapListResult.off('ontouchstart, touchend, touchmove, touchend');
                   */
               }
           }
       }
       // touchend de select 'Vista grid, list y map' a lista con botones.
       // Por defecto compruebo para mutar.
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

       function mutaSelectViews(estado) {
           if (estado) {
               if (!$viewFilter.find('ul').length) {
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
   }
    
        // Por defecto compruebo para mutar.
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

        function mutaSelectViews(estado) {
            if (estado) {
                if (!$viewFilter.find('ul').length) {
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

    // Abre y cierra el mapa en los resultados de busqueda: (Botones, Open y close)
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


    $(document).click(function (e){
        $(".js-fc-dropdown").removeClass('show');
    });
    $('.js-fc-dropdown').on('click', function (e) {
        e.stopPropagation();
        $(this).toggleClass('show');
    });

    
    })(jQuery);