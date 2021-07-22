var myLazyLoad;
var map;
var mapNotLoaded = false;

// setup google maps drawing tools
var drawingManager;
var autoMapSearch = true;
var polygons = [];
var initPolygons = [];
var mapCenter;
var mapBounds;
var mapZoom;
var centerBounds;
var lastBounds = "";

var initLoadMLSAnonymous = false;

var xDown = null;
var yDown = null;

(function($) {
    if (typeof flex_idx_search_params === 'undefined') {
        return;
    }
    var search_params = flex_idx_search_params.params;
    var flex_idx_autocomplete_cities = _.pluck(search_params.cities, "name");
    var baths_slider_values = _.pluck(search_params.baths_range, 'value');
    var beds_slider_values = _.pluck(search_params.beds_range, 'value');
    var sqft_slider_values = _.pluck(search_params.living_size_range, 'value');
    var lotsize_slider_values = _.pluck(search_params.lot_size_range, 'value');
    var price_rent_slider_values = _.pluck(search_params.price_rent_range, 'value');
    var price_sale_slider_values = _.pluck(search_params.price_sale_range, 'value');
    var year_built_slider_values = _.pluck(search_params.year_built_range, 'value');
    var property_type_values = _.pluck(search_params.property_types, 'value');
    var xhr_running = false;
    var first_load_map = false;
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

    var $wrapListResult = $('#wrap-list-result');
    var $ventana = $(window);
    var $cuerpo = $("body");
    var $viewFilter;

    function flex_encode_keyword_string(input) {
        return input.replace(/\s/g, "~").replace(/\#/g, ":").replace(/\//g, "_").replace(/\&/g, ";");
    }

    function flex_decode_keyword_string(input) {
        return input.replace(/\~/g, " ").replace(/\:/g, "#").replace(/\_/g, "/").replace(/\;/g, "&");
    }

    /*function scrollFixed(conditional) {
        var $conditional = conditional;
        var $element = $($conditional + ".fixed-box");
        var $offset = $element.offset();
        var $positionYelement = $offset.top;
        $ventana.on("scroll", function() {
            var $scrollSize = $ventana.scrollTop();
            if ($scrollSize > $positionYelement) {
                $cuerpo.addClass('fixed-active');
            } else {
                $cuerpo.removeClass('fixed-active');
            }
        });
    }*/

    function creaScrollTemporal(creador, objetivo) {
        if (!objetivo.hasClass('ps-container')) {
            setTimeout(function() {
                objetivo.perfectScrollbar({
                    suppressScrollX: true,
                    minScrollbarLength: '42'
                });
            }, ((Number(creador.css('transition-duration').replace('s', '')) * 1000) * 2));
        }
    }

    function active_modal($modal) {
        if ($modal.hasClass('active_modal')) {
            $('.overlay_modal').removeClass('active_modal');
            // $("html, body").animate({
            //     scrollTop: 0
            // }, 1500);
        } else {
            $modal.addClass('active_modal');
            $modal.find('form').find('input').eq(0).focus();
            $('html').addClass('modal_mobile');
        }
        close_modal($modal);
    }

    function setInitialStateSlider() {
        $("#wrap-result").find(".wrap-slider > ul li:first").each(function() {
            $(this).addClass("flex-slider-current");
        });
    }

    function close_modal($obj) {
        var $this = $obj.find('.close');
        $this.click(function() {
            var $modal = $this.closest('.active_modal');
            $modal.removeClass('active_modal');
            $('html').removeClass('modal_mobile');
        });
    }

    function flex_refresh_search() {
        if (xhr_running === false) { return; }

        var dontReloadBounds = (arguments.length) ? true : false;

        if (mapIsVisible === false) {
            // $("#flex-spinner-load").fadeIn();
            // $("#wrap-result").hide();
        } else {
            var mapBounds = map.getBounds();
            var mapCenter = map.getCenter();
            var mapZoom = map.getZoom();

            $("#idx_center").val(mapCenter.lat() + " " + mapCenter.lng());
            $("#idx_zoom").val(mapZoom);
            $("#idx_bounds").val([
                mapBounds.getNorthEast().lat(),
                mapBounds.getNorthEast().lng(),
                mapBounds.getSouthWest().lat(),
                mapBounds.getSouthWest().lng()
            ].join(" "));

            console.dir({
                center: { lat: mapCenter.lat(), lng: mapCenter.lng() },
                bounds: [
                    mapBounds.getNorthEast().lat(),
                    mapBounds.getNorthEast().lng(),
                    mapBounds.getSouthWest().lat(),
                    mapBounds.getSouthWest().lng()
                ],
                zoom: mapZoom
            });
        }

        var form_data = $("#flex-idx-search-form").serialize();

        $("html, body").animate({
            scrollTop: 0
        }, 700);

        $('#filter-views ul li.active').click();

        $("#wrap-list-result").addClass("ib-loading-results");

        $.ajax({
            // url: flex_idx_search_params.ajaxUrl,
            url: flex_idx_search_params.lookupSearch,
            method: "POST",
            data: {
                idx: form_data,
                access_token: flex_idx_search_params.accessToken,
                flex_credentials: Cookies.get("ib_lead_token")
            },
            dataType: "json",
            success: function(response) {
                if (typeof iboost_track_gid !== "undefined") {
                  if (response.total > 0) {
                    gtag('event', 'Listing_view', {
                        'send_to': __flex_g_settings.g_adwords_account,
                        'listing_search_term': response.keyword + ' ' + response.heading.price.min + ' to ' + response.heading.price.max,
                        'listing_pagetype': 'searchresults',
                        'listing_totalvalue': response.total
                    });
                  }
                }

                /*$("html, body").animate({
                    scrollTop: 0
                }, 700);*/

                var listingHTML = [];
                var paginationHTML = [];
                var items = response.items;
                var paging = response.paging;
                var search_labels = response.search_labels;
                var labelPrice = '',
                    labelBed = '',
                    labelBath = '';

                if (search_labels.range_price=='Any Price') {
                    labelPrice=word_translate.any_price; 
                }else{ 
                    labelPriceTemp=search_labels.range_price.split(" - ");
                    labelPriceTemp.forEach(function(itemprice,keyprice){
                        if (itemprice=='Any Price'){
                            labelPriceTemp[keyprice]=word_translate.any_price;
                        }
                    });                    
                    labelPrice=labelPriceTemp.join(' - ');
                }

                if (search_labels.range_bed=='Any Bed') {
                    labelBed=word_translate.any_bed; 
                }else{ 
                    labelBedTemp=search_labels.range_bed.split(" - ");
                    labelBedTemp.forEach(function(itembed,keybed){
                        if (itembed=='Any Bed'){
                            labelBedTemp[keybed]=word_translate.any_bed;
                        }
                    });                    
                    labelBed=labelBedTemp.join(' - ');
                }

                if (search_labels.range_bath=='Any Bath') {
                    labelBath=word_translate.any_bath;
                }else{ 
                    labelBathTemp=search_labels.range_bed.split(" - ");
                    labelBathTemp.forEach(function(itembath,keybed){
                        if (itembath=='Any Bath'){
                            labelBathTemp[keybed]=word_translate.any_bath;
                        }
                    });                    
                    labelBath=labelBathTemp.join(' - ');
                }                

                $('#text-price').html(labelPrice);
                $('#text-beds').html(labelBed);
                $('#text-baths').html(labelBath);

                if (search_labels.property_type == 'Homes, Condominiums') {
                    $('#text-type').html(word_translate.homes_condominiums);
                } else if (search_labels.property_type == 'Condominiums') {
                    $('#text-type').html(word_translate.condominiums);
                }else if (search_labels.property_type == 'Homes, Condominiums, Townhouses') {
                    $('#text-type').html(word_translate.homes_condominiums_townhouses);
                }else if (search_labels.property_type == 'Homes') {
                    $('#text-type').html(word_translate.homes);
                }
                else{
                    $('#text-type').html(word_translate.type);
                }

                $('#properties-found').html('<span>' + _.formatShortPrice(response.total) + '</span> '+word_translate.properties);
                $('#fs_inner_c').html(_.formatShortPrice(response.total));
                $('#info-subfilters').html(word_translate.showing+' ' + paging.offset.start +' '+word_translate.to+' ' + paging.offset.end + ' '+word_translate.of+' '+ _.formatPrice(response.total) +' '+word_translate.properties+'.');

                if (response.heading.price.max=='Any Price') {
                    labelPricemax=word_translate.any_price; 
                }else{ 
                    labelPricemaxTemp=response.heading.price.max.split(" - ");
                    labelPricemaxTemp.forEach(function(itemprice,keyprice){
                        if (itemprice=='Any Price'){
                            labelPricemaxTemp[keyprice]=word_translate.any_price;
                        }
                    });                    
                    labelPricemax=labelPricemaxTemp.join(' - ');
                }
                console.log(response.keyword);
                var text_translate='';
                text_translate=response.keyword.replace('Condominiums',word_translate.condominiums).replace('Single Family Homes',word_translate.single_family_homes).replace('Townhouses',word_translate.townhouses).replace(' and ',' '+word_translate.and+' ').replace(' in ',' '+word_translate.in+' ');

                var heading_title_str = text_translate +' '+word_translate.from+" " + response.heading.price.min+' '+word_translate.to+' '+ labelPricemax;

                $('#title-subfilters').html(heading_title_str);
                document.title = heading_title_str;

                // listingHTML.push('<li class="propertie ib-p-non-click"><a style="background-image:url(https://via.placeholder.com/420x380);background-repeat:no-repeat;background-size:cover;display:block;height:100%;" href="#" target="_blank"></a></div>');

                for (var i = 0, l = items.length; i < l; i++) {
                    var item = response.items[i];
                    item.address_short = item.address_short.replace(/# /, "#");
                    item.address_large = item.address_large.replace(/ , /, ", ");
                    var al = item.address_large.split(", ");
                    if (al[1] != undefined){
                        var st = al[1].replace(/[\d\s]/g, "");                        
                        var st_print = al[0] + ", " + al[1];
                    }else{
                        var st = al[0];    
                        var st_print = al[0];
                    }

                    var final_address = item.address_short + " " + al[0] + ", " + st;
                    var final_address_parceada = item.address_short + "<span>" + st_print + "</span>";
                    //var final_address_parceada_new = "<span>"+item.address_short + " " + al[0] +  " " + al[1]+ "</span>";
                    var final_address_parceada_new = "<span>"+item.address_short + " " + st_print + "</span>";

                    listingHTML.push('<li data-geocode="' + item.lat + ':' + item.lng + '" data-class-id="' + item.class_id + '" data-mls="' + item.mls_num + '" data-address="' + item.address_short + '" class="propertie">');
                    if (item.status == 1 && item.recently_listed === "yes") {
                        listingHTML.push('<div class="flex-property-new-listing">'+word_translate.new_listing+'</div>');
                    }
                    if (item.status == 6) {
                        listingHTML.push('<div class="flex-property-new-listing">'+item.status_name+'</div>');
                    }
                    listingHTML.push('<h2 title="' + final_address + '"><span>' + final_address_parceada + '</span></h2>');
                    listingHTML.push('<ul class="features">');
                    listingHTML.push('<li class="address">' + final_address_parceada_new + '</li>');
                    listingHTML.push('<li class="price"><a href="' + flex_idx_search_params.propertyDetailPermalink + '/' + item.slug + '">$' + _.formatPrice(item.price) + '</a></li>');
                    if (item.reduced == '') {
                        listingHTML.push('<li class="pr">' + item.reduced + '</li>');
                    } else if (item.reduced < 0) {
                        listingHTML.push('<li class="pr down">' + item.reduced + '%</li>');
                    } else {
                        listingHTML.push('<li class="pr up">' + item.reduced + '%</li>');
                    }
                    var textitembed=word_translate.beds;
                    var textitembath=word_translate.baths;

                    if (item.bed>1) {textitembed=word_translate.beds;}else{textitembed=word_translate.bed;}
                    if (item.bath>1) {textitembath=word_translate.baths;}else{textitembath=word_translate.bath;}

                    listingHTML.push('<li class="beds">' + item.bed + ' <span>'+textitembed+' </span></li>');
                    if (item.baths_half > 0) {
                        listingHTML.push('<li class="baths">' + item.bath + '.5 <span>'+textitembath+' </span></li>');
                    } else {
                        listingHTML.push('<li class="baths">' + item.bath + ' <span>'+textitembath+' </span></li>');
                    }
                    listingHTML.push('<li class="living-size"> <span>' + _.formatPrice(item.sqft) + '</span>'+word_translate.sqft+' <span>(' + item.living_size_m2 + ' m2)</span></li>');
                    listingHTML.push('<li class="price-sf"><span>$' + item.price_sqft + ' </span>/ '+word_translate.sqft+'<span>($' + item.price_sqft_m2 + ' m2)</span></li>');
                    if (item.development !== '' && item.development != null ) {
                        listingHTML.push('<li class="development"><span>' + item.development + '</span></li>');
                    } else if (item.complex !== '' && item.complex != 'null' ) {
                        listingHTML.push('<li class="development"><span>' + item.complex + '</span></li>');
                    } else {
                        listingHTML.push('<li class="development"><span>' + item.subdivision + '</span></li>');
                    }

                    if ( 
                        response.payload.hasOwnProperty("board_info") &&
                        response.board_info.hasOwnProperty("board_logo_url") &&
                        response.board_info.board_logo_url != "" ) {
                        listingHTML.push('<li class="ms-logo-board"><img src="'+response.board_info.board_logo_url+'"></li>');
                    }

                    listingHTML.push('</ul>');
                    var totgallery='';

                    if (item.gallery.length <= 1) {
                        totgallery='no-zoom';
                    }
                    listingHTML.push('<div class="wrap-slider '+totgallery+'">');
                    listingHTML.push('<ul>');
                    for (var k = 0, m = item.gallery.length; k < m; k++) {
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

                    if (item.status == 1) {
                        if (item.is_favorite) {
                            listingHTML.push('<button class="clidxboost-btn-check flex-favorite-btn" data-alert-token="' + item.token_alert + '"><span class="clidxboost-icon-check active"></span></button>');
                        } else {
                            listingHTML.push('<button class="clidxboost-btn-check flex-favorite-btn"><span class="clidxboost-icon-check"></span></button>');
                        }
                    }

                    listingHTML.push('</div>');

                    if (item.status == 1) {
                        if (item.is_favorite) {
                            listingHTML.push('<a href="' + flex_idx_search_params.propertyDetailPermalink + '/' + item.slug + '" class="view-detail show-modal-properties">'+final_address_parceada+'</a>');
                        } else {
                            listingHTML.push('<a href="' + flex_idx_search_params.propertyDetailPermalink + '/' + item.slug + '" class="view-detail show-modal-properties">'+final_address_parceada+'</a>');
                        }
                    } else {
                        if (item.is_favorite) {
                            listingHTML.push('<a href="' + flex_idx_search_params.propertyDetailPermalink + '/pending-' + item.slug + '" class="view-detail show-modal-properties">'+final_address_parceada+'</a>');
                        } else {
                            listingHTML.push('<a href="' + flex_idx_search_params.propertyDetailPermalink + '/pending-' + item.slug + '" class="view-detail show-modal-properties">'+final_address_parceada+'</a>');
                        }
                    }

                    listingHTML.push('</li>');
                }

                if (response.total > 0) {
                    $('#result-search').html(listingHTML.join(""));
                } else {
                    $('#result-search').html('<h3 style="margin:5px 30px 30px 30px;">Try <strong><a class="ib-refresh-tab" href="'+__flex_g_settings.searchUrl+'">refreshing the page</a></strong> to include more results. Or, change your search criteria.</h3>');
                }

                if (paging.pages > 1) {
                    paginationHTML.push('<span id="indicator">'+word_translate.pag+' ' + paging.current +' '+word_translate.of+' ' + _.formatPrice(paging.pages) + '</span>');
                    if (paging.prev_page && paging.pages > 1) {
                        paginationHTML.push('<a href="#" data-page="1" title="'+word_translate.first_page+'" id="firstp" class="ad visible">');
                        paginationHTML.push('<span class="clidxboost-icon-arrow-select"></span>');
                        paginationHTML.push('<span class="clidxboost-icon-arrow-select"></span>');
                        paginationHTML.push('<span>'+word_translate.first_page+'</span>');
                        paginationHTML.push('</a>');
                    }
                    if (paging.prev_page) {
                        paginationHTML.push('<a href="#" data-page="' + (paging.current - 1) + '" title="Prev Page" id="prevn" class="arrow clidxboost-icon-arrow-select prevn visible">');
                        paginationHTML.push('<span>Previous page</span>');
                        paginationHTML.push('</a>');
                    }
                    paginationHTML.push('<ul id="principal-nav">');
                    for (var i = 0, l = paging.range.length; i < l; i++) {
                        var loopPage = paging.range[i];

                        if (paging.current === loopPage) {
                            paginationHTML.push('<li class="active"><a href="#" data-page="' + loopPage + '">' + loopPage + '</a></li>');
                        } else {
                            paginationHTML.push('<li><a href="#" data-page="' + loopPage + '">' + loopPage + '</a></li>');
                        }
                    }
                    paginationHTML.push('</ul>');
                    if (paging.next_page) {
                        paginationHTML.push('<a href="#" data-page="' + (paging.current + 1) + '" title="Prev Page" id="nextn" class="arrow clidxboost-icon-arrow-select nextn visible">');
                        paginationHTML.push('<span>'+word_translate.next_page+'</span>');
                        paginationHTML.push('</a>');
                    }
                    if (paging.next_page && paging.pages > 1) {
                        paginationHTML.push('<a href="#" data-page="' + paging.pages + '" title="'+word_translate.first_page+'" id="lastp" class="ad visible">');
                        paginationHTML.push('<span class="clidxboost-icon-arrow-select"></span>');
                        paginationHTML.push('<span class="clidxboost-icon-arrow-select"></span>');
                        paginationHTML.push('<span>'+word_translate.last_page+'</span>');
                        paginationHTML.push('</a>');
                    }
                }

                $("#flex-spinner-load").hide();

                if (mapIsVisible === false) {
                    $("#wrap-result").show();
                }

                $('#nav-results').html(paginationHTML.join("")).ready(function() {  idxboostTypeIcon();  if(typeof ppchack === 'function') { ppchack(); }  });
                $('.flex-loading-ct').fadeIn();
                var flex_idx_new_url = flex_idx_search_params.searchUrl + "/" + response.uri + "/order-" + response.sort + "/view-" + response.view + "/page-" + response.paging.current;
                history.pushState(null, '', flex_idx_new_url);
                $("#flex-idx-search-form").data("search_slug", response.uri);
                $("#flex-idx-search-form").data('save_slug', flex_idx_new_url);
                $("#flex-idx-search-form").data('save_query', encodeURIComponent(response.condition));
                $("#flex-idx-search-form").data('save_count', response.total);
                $("#flex-idx-search-form").data('next_page', response.paging.next_page);
                $("#flex-idx-search-form").data('current_page', response.paging.current);
                // close all infowindow
                if (typeof infoWindow !== 'undefined') {
                    if (infoWindow.isOpen()) {
                        infoWindow.close();
                    }
                }
                // reset scroll
                $('#wrap-list-result').scrollTop(0);
                // first clean old markers
                removeMarkers();
                // setup markers on map
                var map_items = response.map_items;
                google.maps.event.trigger(map, "resize");

                if (response.hasOwnProperty("kml_boundaries") && (null != response.kml_boundaries)) {
                    // remove polygons
                    if (polygons.length) {
                        for (var i = 0, l = polygons.length; i < l; i++) {
                            polygons[i].setMap(null);
                        }
                        polygons.length = 0;
                    }

                    // test
                    autoMapSearch = false;

                    var kb_exp = response.kml_boundaries.split(",");
                    var tmp_points = new google.maps.MVCArray();
                    for (var nn = 0, mm = kb_exp.length; nn < mm; nn++) {
                        var tmp_point = kb_exp[nn].split(" ");
                        tmp_points.push(new google.maps.LatLng(tmp_point[0], tmp_point[1]));
                    }

                    var tmpPolygon = new google.maps.Polygon({
                        path: tmp_points,
                        editable: false,
                        strokeWeight: 3,
                        strokeColor: "#31239a",
                        fillOpacity: 0.1,
                        strokeOpacity: 0.8,
                        strokeWeight: 1,
                        fillColor: "#31239a"
                    });

                    tmpPolygon.setMap(map);
                    polygons.push(tmpPolygon);
                }

                setupMarkers(map_items, dontReloadBounds);

                $("#wrap-list-result").removeClass("ib-loading-results");

                // check lazy images
                if (typeof myLazyLoad !== "undefined") { myLazyLoad.update(); }
                setInitialStateSlider();

                if (false === initMapLoaded) {
                  if ($("#wrap-result").hasClass("view-map")) {
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
                            // map.fitBounds(bounds);
                        } else {
                            map.setCenter(map_center);
                            map.setZoom(map_zoom);
                        }
                    }, 100);
                  }

                  initMapLoaded = true;
                }
                idxboostTypeIcon();
            }
        });
    }

    function flex_slider_setup(node, values) {}

    function flex_amenities_setup() {}

    function flex_property_types_setup() {}

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
                        }
                    });
                }
            }
        } else { // lo destruyo
            if ($wrapListResult.hasClass('ps-container')) {
                $wrapListResult.perfectScrollbar('destroy');
            }
        }
    }

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
        new LazyLoad({
          callback_error: function(element){
            $(element).attr('src','https://idxboost.com/i/default_thumbnail.jpg').removeClass('error').addClass('loaded');
            $(element).attr('data-origin','https://idxboost.com/i/default_thumbnail.jpg');
          }
        });
    }
    $(function() {
        $("#result-search").on("mouseover", ">li", function(event) {
            if ($(this).hasClass("propertie")) {
                var geocodePoint = $(this).data("geocode");

                if (typeof geocodePoint === 'undefined') {
                    return;
                }

                if (!geocodePoint.length) {
                    return;
                }

                for (var i = 0, l = markers.length; i < l; i++) {
                    if (geocodePoint == markers[i].geocode) {
                        new google.maps.event.trigger(markers[i], 'click');
                        break;
                    }
                }
            }
        });

        $("#result-search").on("mouseleave", ">li", function(event) {
            if (typeof infoWindow !== 'undefined') {
                if (infoWindow.isOpen()) {
                    infoWindow.close();
                }
            }
        });


        /*
        $("#result-search").on("mouseout", function() {
            if (typeof infoWindow !== 'undefined') {
                if (infoWindow.isOpen()) {
                    infoWindow.close();
                }
            }
        });
        */

        /*
        $("#result-search").on("mouseout", "li", function(event) {
            if ($(this).hasClass("propertie")) {
                var geocodePoint = $(this).data("geocode");
                // console.log(geocodePoint);

                if (!geocodePoint.length) {
                    return;
                }

                if (typeof infoWindow !== 'undefined') {
                    if (infoWindow.isOpen()) {
                        infoWindow.close();
                    }
                }
            }
        });
        */

        // fix touch slider
        $('body').on('touchstart', '.slider-generator .propertie', function (evt) {
            xDown = evt.originalEvent.touches[0].clientX;
            yDown = evt.originalEvent.touches[0].clientY;
        });

        $('body').on('touchmove', '.slider-generator .propertie', function (evt) {
            if (!xDown || !yDown) {
                return;
            }
            var xUp = evt.originalEvent.touches[0].clientX;
            var yUp = evt.originalEvent.touches[0].clientY;
            var xDiff = xDown - xUp;
            var yDiff = yDown - yUp;
            if (Math.abs(xDiff) > Math.abs(yDiff)) { // si se mueve derecha o izquierda
                evt.preventDefault();
                if (xDiff > 0) { // izquierda
                    $(this).find('.next').click();
                } else { // derecha
                    $(this).find('.prev').click();
                }
            }
            xDown = null;
            yDown = null;
        });

        $viewFilter = $('#filter-views');
        if ($viewFilter.length) {
            var $wrapResult = $('#wrap-result');
            // Cambio de vista por SELECT NATIVO
            $viewFilter.on('change', 'select', function(event) {
              if (typeof event.originalEvent === "undefined") {
                return;
              }

                switch ($(this).find('option:selected').val()) {
                    case 'grid':
                        $viewFilter.removeClass('list map').addClass('grid');
                        $wrapResult.removeClass('view-list view-map').addClass('view-grid');
                        $cuerpo.removeClass('view-list view-map');
                        $(".open-map").removeClass("hide");
                        $(".close-map").addClass("hide");
                        $("#idx_view").val("grid");
                        if (typeof myLazyLoad !== "undefined") { myLazyLoad.update(); }
                        break
                    case 'list':
                        $viewFilter.removeClass('grid map').addClass('list');
                        $wrapResult.removeClass('view-grid view-map').addClass('view-list');
                        $cuerpo.addClass('view-list').removeClass('view-map');
                        $(".open-map").removeClass("hide");
                        $(".close-map").addClass("hide");
                        $("#idx_view").val("list");
                        break
                    case 'map':
                        $viewFilter.removeClass('list grid').addClass('map');
                        $wrapResult.removeClass('view-list view-grid').addClass('view-map');
                        $cuerpo.removeClass('view-list fixed-active').addClass('view-map');
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

                                // map.fitBounds(bounds);
                            } else {
                                map.setCenter(map_center);
                                map.setZoom(map_zoom);
                            }
                        }, 100);
                        break
                }
                var f_search_url = $("#flex-idx-search-form").data('search_slug');
                var f_sort = $("#idx_sort").val();
                var f_page = $("#flex-idx-search-form").data('current_page');
                var f_new_url = [
                    flex_idx_search_params.searchUrl,
                    f_search_url, "order-" + f_sort, "view-" + $("#idx_view").val(), "page-" + f_page
                ].join("/");
                history.pushState(null, '', f_new_url);
            });
            // Cambio de estado por select combertido a lista
            $viewFilter.on('click', 'li', function(event) {
              if (typeof event.originalEvent === "undefined") {
                return;
              }

              console.log("clicked");

                $(this).addClass('active').siblings().removeClass('active');
                switch ($(this).attr('class').split(' ')[0]) {
                    case 'grid':
                        $wrapResult.removeClass('view-list view-map').addClass('view-grid');
                        $cuerpo.removeClass('view-list view-map');
                        //scrollResultados(false);
                        $(".open-map").removeClass("hide");
                        $(".close-map").addClass("hide");
                        if (typeof myLazyLoad !== "undefined") { myLazyLoad.update(); }
                        $("#idx_view").val("grid");
                        break
                    case 'list':
                        $wrapResult.removeClass('view-grid view-map').addClass('view-list');
                        $cuerpo.addClass('view-list').removeClass('view-map');
                        //scrollResultados(false);
                        $(".open-map").removeClass("hide");
                        $(".close-map").addClass("hide");
                        $("#idx_view").val("list");
                        break
                    case 'map':
                        $wrapResult.removeClass('view-list view-grid').addClass('view-map');
                        $cuerpo.removeClass('view-list fixed-active').addClass('view-map');
                        //scrollResultados(true);
                        // map.fitBounds(bounds);
                        $("#idx_view").val("map");
                        google.maps.event.trigger(map, "resize");
                        if (typeof centerBounds !== "undefined") {
                            map.fitBounds(centerBounds)
                        }
                        break
                }
                var f_search_url = $("#flex-idx-search-form").data('search_slug');
                var f_sort = $("#idx_sort").val();
                var f_page = $("#flex-idx-search-form").data('current_page');
                var f_new_url = [
                    flex_idx_search_params.searchUrl,
                    f_search_url, "order-" + f_sort, "view-" + $("#idx_view").val(), "page-" + f_page
                ].join("/");
                history.pushState(null, '', f_new_url);
            });
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
        // Actualizado el scroll de 'Choose cities' del 'All filter' al redimencionar la pantalla.
        var $citiesList = $('#cities-list');
        if ($citiesList.length) {
            $ventana.on('resize', function() {
                if ($citiesList.hasClass('ps-container')) {
                    $citiesList.perfectScrollbar('update');
                }
            });
        };
        // Expande y contrae los mini filtros de 'all filters' en versión mobile de la web
        var $miniFilters = $('#mini-filters');
        if ($miniFilters.length) {
            // Expando y contrigo el filtro
            $miniFilters.find('h4').on('click', function() {
                var $theLi = $(this).parents('li');
                $theLi.toggleClass('expanded').siblings().removeClass('expanded');
                // ver si creo el slider de 'cities', si es que se clickeo el LI con clase CITIES
                if ($theLi.hasClass('cities') && !$citiesList.hasClass('ps-container')) {
                    setTimeout(function() {
                        $citiesList.perfectScrollbar({
                            suppressScrollX: true,
                            minScrollbarLength: '42'
                        });
                    }, ((Number($theLi.css('transition-duration').replace('s', '')) * 1000) * 2));
                    creaScrollTemporal($theLi, $citiesList);
                }
            });
        }
        // Abre y cierra el 'All Filters'
        var $theFilters = $('#filters');
        if ($theFilters.length) {
            var $allFilters = $('#all-filters');
            var $wrapFilters = $('#wrap-filters');
            $theFilters.on('click', 'button', function() {
                var $bedsActive = $('#mini-filters .price').addClass('expanded');
                var $liClicked = $(this).parent();
                var $nameClass = $liClicked.attr('class').split(' ')[0];
                // [A] verifico si existe un LI de mini filter vinculado al LI de la cabezera de filtros que se acaba de crear.
                var $miniFilter = $miniFilters.find('li.' + $nameClass);
                if (!$miniFilter.length) {
                    //El LI clickeado no está vinculado a la visualizacion de un mini filtro, verifiquemos si se hizo click en "All Filter".
                    if ($nameClass !== 'all') {
                        return;
                    } else {
                        $liClicked.toggleClass('active').siblings().removeClass('active'); // se hizo click en 'All Filter', activo su flecha
                    }
                } else {
                    $liClicked.toggleClass('active').siblings().removeClass('active'); // activo su flecha, xq si hay vinculación y continuo.. apareciendo el mini filter.
                }
                // [/A]
                switch ($nameClass) {
                    case 'all': // Mostrar el 'All Filter'
                        // [B] Apareciendo y/o mutando
                        if (!$allFilters.hasClass('visible')) { // lo pongo asi, x siacaso yá esté visible individualmente y no se oculte, sino, muestre todos
                            $allFilters.addClass('visible');
                        } else {
                            if ($allFilters.hasClass('individual') && $allFilters.hasClass('visible')) { // Está visible, pero individualmente, le quitaré eso...
                                $allFilters.removeClass('individual');
                            } else {
                                if (!$allFilters.hasClass('individual') && $allFilters.hasClass('visible')) { // Está visible, y sin individual, lo ocultaré...
                                    $allFilters.removeClass('visible');
                                }
                            }
                        }
                        // [/B]
                        // verifico la dimención de la pantalla, para mostrar en fixed o como modal.
                        // [C] si es menor o igual a 768 siempre se mostrará en pantalla completa, con el body fixeado,
                        /* LO QUITE */
                        if ($wrapFilters.width() <= 959) {
                            //$cuerpo.toggleClass('fixed');
                            $('html').toggleClass('fixed');
                            // Scrolleo si es necesario.
                            // Creo el scroll interno invisible del 'all filter'.
                            
                            /*Desactivando
                            if (!$allFilters.hasClass('ps-container')) {
                                setTimeout(function() {
                                    $allFilters.perfectScrollbar({
                                        suppressScrollX: true,
                                        minScrollbarLength: '42'
                                    });
                                }, ((Number($allFilters.css('transition-duration').replace('s', '')) * 1000) * 2));
                            }*/
                        }
                        // [/C]
                        // [D] Posiciono el 'All filter' dependiendo el ancho de la pantalla.
                        if ($wrapFilters.width() <= 640) {
                            $allFilters.css({ // porque la cabezera de los filtros están en una sola linea.
                                'top': ($wrapFilters.outerHeight() + $wrapFilters.position().top) + 'px',
                                'left': '0px',
                                'height': 'calc(100vh - ' + ($wrapFilters.outerHeight() + $theFilters.find('li.save').outerHeight()) + 'px)'
                            });
                        } else if ($wrapFilters.width() > 640 && $wrapFilters.width() <= 959) { // mayor a 640 pero menor a 768 pixeles de ancho.
                            if (!$allFilters.hasClass('neighborhood')) { // si no estoy en 'neighborhood' tengo todo el ancho de la pantalla.
                                $allFilters.css({ // porque la cabezera de los filtros están en 2 lineas.
                                    'left': '0px',
                                    'top': $wrapFilters.outerHeight() + 'px',
                                    'height': 'calc(100vh - ' + ($wrapFilters.outerHeight() + $applyFilters.outerHeight()) + 'px)'
                                });
                            } else { // estoy en 'neighborhood', lo aparesco diferente;
                                $allFilters.removeAttr('style');
                                $allFilters.css({
                                    'top': $wrapFilters.outerHeight() + 'px',
                                    'right': '0',
                                    'left': 'auto',
                                    'transform': 'none'
                                });
                            }
                        } else { // cuando la cabezera de los filtros se muestran en 1 sola linea y el 'all filter' debe ser modal (de 960px para arriba).
                            $allFilters.removeAttr('style');
                            $allFilters.css('top', $wrapFilters.outerHeight() + 'px');
                            creaScrollTemporal($allFilters, $citiesList);
                        }
                        // [/D]
                        break
                    default:
                        // Quito el fixed , ya que no es el LI 'ALL FILTER'
                        if ($('html').hasClass('fixed')) {
                            $('html').removeClass('fixed');
                        }

                        // Destruyo el 'perfect scroll bar' creado cuando era modal 'all filter'
                        /*Desactivando
                        if ($allFilters.hasClass('ps-container')) {
                            $allFilters.perfectScrollbar('destroy');
                        }*/

                        //  busco el mini filter vinculado al LI clickeado de la cabezera de filters
                        if ($liClicked.hasClass('active')) { // activo la flecha del LI clickeado
                            $miniFilter.addClass('visible').siblings().removeClass('visible'); //  aparesco el 'Mimi filter'
                            if (!$allFilters.hasClass('individual')) { // agrego la 'individualidad' solo si se viene de 'All filter', xq sino, yá la tiene.
                                $allFilters.addClass('individual');
                                $allFilters.css('height', 'auto');
                            }
                            if (!$allFilters.hasClass('visible')) { // agrego la 'individualidad' solo si se viene de 'All filter', xq sino, yá la tiene.
                                $allFilters.addClass('visible');
                            }
                            $allFilters.css({
                                'top': $wrapFilters.outerHeight() + 'px', // aparesco el filtro individual, justo abajito del boton LI que se hizo click
                                'left': (($liClicked.position().left + ($liClicked.outerWidth() / 2)) - 150) + 'px'
                            });
                        } else {
                            $allFilters.removeClass('visible');
                            $miniFilter.removeClass('visible');
                            $liClicked.removeClass('active');
                            setTimeout(function() {
                                $allFilters.removeClass('individual');
                            }, Number($allFilters.css('transition-duration').replace('s', '')) * 1000)
                        }
                }
            });

            // Escondo el 'All Filters' con el boton 'Apply filters', simulando click en 'All Filters'
            var $applyFilters = $('#apply-filters');
            if ($applyFilters.length) {
                $applyFilters.on('click', function() {
                    $theFilters.find('.all button').trigger('click');
                });
            }

            // Click fuera de 'All filters', desaparece.
            $(document).on('mouseup', function(e) {
                if ($allFilters.hasClass('visible')) {
                    if (!$wrapFilters.is(e.target) && $wrapFilters.has(e.target).length === 0) {
                        $theFilters.find('.active button').trigger('click');
                    }
                }
            });
        }
       /* if ($("#wrap-filters").length) {
            scrollFixed('#wrap-filters');
        }*/

        $("#autocomplete-ajax").on("click", function() {
          if ($allFilters.hasClass('visible') && $('body').width() > 959){
            $('#filters > li').removeClass('active');
            $('#all-filters').removeClass('visible individual');
            $('#cities-list').appendTo("#autocomplete-dropdown-ct")
          }
        });

        // setup autocomplete
        flex_autocomplete = $('#autocomplete-ajax');
        flex_autocomplete_inner = $("#autocomplete-ajax-min");
        if (flex_autocomplete_inner.length) {
            flex_autocomplete_inner.autocomplete({
                source: function(request, response) {
                  $.ajax({
                      url: __flex_g_settings.suggestions.service_url,
                      dataType: "json",
                      data: { term: request.term, board: __flex_g_settings.suggestions.board },
                      success: function(data) {
                          response(data);
                      }
                  });
                },
                appendTo: '#flex_search_keyword_form_min',
                minLength: 3,
                select: function(event, ui) {
                    var val_exp = ui.item.id.split(/\|/);
                    var keywordValue = val_exp[0];
                    var keywordType = val_exp[1];
                    var keywordFinalValue = encodeURIComponent(keywordValue + "|" + keywordType);
                    $('#idx_keyword').val(keywordFinalValue);
                    $('#idx_page').val(1);
                    flex_autocomplete.val(ui.item.label);

                    // do ajax
                    flex_refresh_search();
                },
                close: function(event, ui) {
                    var _self = $(this);
                },
                create: function( event, ui ) {
                    $(this).attr('autocomplete', 'disabled');
                }
            });

            $("#autocomplete-ajax").on("search", function() {
                if ("" == this.value) {
                    if (polygons.length) {
                        for (var i = 0, l = polygons.length; i < l; i++) {
                            polygons[i].setMap(null);
                        }
                        polygons.length = 0;
                    }

                    autoMapSearch = true;

                    $('#idx_page').val(1);
                    $("#idx_keyword").val("");
                    flex_refresh_search();
                }
            });

            $("#autocomplete-ajax-min").on("search", function() {
                if ("" == this.value) {
                    if (polygons.length) {
                        for (var i = 0, l = polygons.length; i < l; i++) {
                            polygons[i].setMap(null);
                        }
                        polygons.length = 0;
                    }

                    autoMapSearch = true;

                    $('#idx_page').val(1);
                    $("#idx_keyword").val("");
                    flex_refresh_search();
                }
            });

            flex_autocomplete_inner.on({
                focus: function() {
                    if ($(this).val() == "") {
                        $('#cities-list').appendTo('#cities-list-wrap');
                    }
                },
                keypress: function() {
                    $('#cities-list').appendTo('#cities-list-wrap');
                },
                change: function() {
                    if ($(this).val() == "") {
                        flex_autocomplete.val('');
                        $('#idx_keyword').val("");

                        if (polygons.length) {
                            for (var i = 0, l = polygons.length; i < l; i++) {
                                polygons[i].setMap(null);
                            }
                            polygons.length = 0;
                        }

                        // do ajax
                        flex_refresh_search();
                    }
                },
                click: function(event) {
                    event.stopPropagation();
                    if ($(this).val() == "") {
                        $('#cities-list').appendTo('#cities-list-wrap');
                    }
                }
            });
        }
        if (flex_autocomplete.length) {
            flex_autocomplete.autocomplete({
                source: function(request, response) {
                  $.ajax({
                      url: __flex_g_settings.suggestions.service_url,
                      dataType: "json",
                      data: { term: request.term, board: __flex_g_settings.suggestions.board },
                      success: function(data) {
                          response(data);
                      }
                  });
                },
                minLength: 3,
                appendTo: '#flex_search_keyword_form',
                select: function(event, ui) {
                    var val_exp = ui.item.id.split(/\|/);
                    var keywordValue = val_exp[0];
                    var keywordType = val_exp[1];
                    var keywordFinalValue = encodeURIComponent(keywordValue + "|" + keywordType);
                    $('#idx_keyword').val(keywordFinalValue);
                    $('#idx_page').val(1);
                    flex_autocomplete_inner.val(ui.item.label);
                    // do ajax
                    flex_refresh_search();
                },
                close: function(event, ui) {
                    var _self = $(this);
                }
            });
            flex_autocomplete.on({
                focus: function() {
                    if ($(this).val() == "") {
                        $('#cities-list').appendTo("#autocomplete-dropdown-ct");
                    }
                },
                keypress: function(event) {
                    $('#cities-list').appendTo('#cities-list-wrap');
                },
                change: function() {
                    if ($(this).val() == "") {
                        flex_autocomplete_inner.val('');
                        $('#idx_keyword').val("");
                        // do ajax
                        flex_refresh_search();
                    }
                },
                click: function(event) {
                    event.stopPropagation();
                    if ($(this).val() == "") {
                        $('#cities-list').appendTo("#autocomplete-dropdown-ct");
                    }
                }
            });
        }
        $('#result-search').scroll(function() {
            new LazyLoad({
              callback_error: function(element){
                $(element).attr('src','https://idxboost.com/i/default_thumbnail.jpg').removeClass('error').addClass('loaded');
                $(element).attr('data-origin','https://idxboost.com/i/default_thumbnail.jpg');
              }
            });
        });

        $("#flex_search_keyword_form").on("submit", function(event) {
            event.preventDefault();

            var currentValue = flex_autocomplete.val().trim().replace(/\w\S*/g, function(str){
              return str.charAt(0).toUpperCase() + str.substr(1).toLowerCase();
            });

            if (!currentValue.length) {
                return;
            }

            currentValue = $.trim(currentValue.replace(/\(.*\)?/, ""));

            if (/^[\d+]{5}$/.test(currentValue)) { // zip code
                $('#idx_keyword').val(currentValue + "|zip");
                flex_autocomplete.val(currentValue + " (Zip)");
                flex_autocomplete_inner.val(currentValue + " (Zip)");
                // do ajax
                flex_refresh_search();
            } else if (/^[0-9a-zA-Z]{7,9}$/.test(currentValue) && /[0-9]/.test(currentValue) && (false === /\s/.test(currentValue))) {
              $('#idx_keyword').val(currentValue + "|mls");
              flex_autocomplete.val(currentValue + " (MLS)");
              flex_autocomplete_inner.val(currentValue + " (MLS)");
              // do ajax
              flex_refresh_search();
            } else if (($.inArray(currentValue, flex_idx_autocomplete_cities)) > -1) {
                $('#idx_keyword').val(currentValue + "|city");
                flex_autocomplete.val(currentValue + " (City)");
                flex_autocomplete_inner.val(currentValue + " (City)");
                // do ajax
                flex_refresh_search();;
            } else if (/^[0-9a-zA-Z]{7,9}$/.test(currentValue) && /[0-9]/.test(currentValue) && (false === /\s/.test(currentValue))) {
              $('#idx_keyword').val(currentValue + "|mls");
              flex_autocomplete.val(currentValue + " (MLS)");
              flex_autocomplete_inner.val(currentValue + " (MLS)");
              // do ajax
              flex_refresh_search();
            }
        });

        /* @todo check autocomplete enter */
        $("#autocomplete-ajax").on("keyup", function(event) {
          if (event.which === 13) {
            event.preventDefault();
          }
        });
        // $("#autocomplete-ajax").on("keyup", function(event) {
        //     if (event.which === 13) {
        //         // var currentValue = $(this).val().trim();
        //         var currentValue = $(this).val().trim().replace(/\w\S*/g, function(str){
        //           return str.charAt(0).toUpperCase() + str.substr(1).toLowerCase();
        //         });
        //         if (!currentValue.length) {
        //             return;
        //         }
        //
        //         currentValue = $.trim(currentValue.replace(/\(.*\)?/, ""));
        //
        //         if (/^[\d+]{5}$/.test(currentValue)) { // zip code
        //             $('#idx_keyword').val(currentValue + "|zip");
        //             flex_autocomplete.val(currentValue + " (Zip)");
        //             flex_autocomplete_inner.val(currentValue + " (Zip)");
        //             // do ajax
        //             flex_refresh_search();
        //         } else if (/^[0-9a-zA-Z]{7,9}$/.test(currentValue) && /[0-9]/.test(currentValue) && (false === /\s/.test(currentValue))) { // mls number
        //           $('#idx_keyword').val(currentValue + "|mls");
        //           flex_autocomplete.val(currentValue + " (MLS)");
        //           flex_autocomplete_inner.val(currentValue + " (MLS)");
        //           // do ajax
        //           flex_refresh_search();
        //         } else {
        //             var check_flex_idx_single_autocomplete_cities = [];
        //             currentValue = currentValue.toLowerCase();
        //             for (var i = 0, l = flex_idx_autocomplete_cities.length; i < l; i++) {
        //                 check_flex_idx_single_autocomplete_cities[i] = flex_idx_autocomplete_cities[i].toLowerCase();
        //             }
        //             var inArrayCities = $.inArray(currentValue, check_flex_idx_single_autocomplete_cities);
        //             if (inArrayCities > -1) {
        //                 flex_autocomplete.val(currentValue + " (Zip)");
        //                 flex_autocomplete_inner.val(currentValue + " (Zip)");
        //                 currentValue = flex_idx_autocomplete_cities[inArrayCities];
        //                 $('#idx_keyword').val(currentValue + "|city");
        //                 flex_autocomplete.val(currentValue + " (City)");
        //                 flex_autocomplete_inner.val(currentValue + " (City)");
        //                 // do ajax
        //                 flex_refresh_search();
        //             } else {
        //               $('#idx_keyword').val(currentValue + "|address");
        //               flex_autocomplete.val(currentValue + " (Address)");
        //               flex_autocomplete_inner.val(currentValue + " (Address)");
        //               // do ajax
        //               flex_refresh_search();
        //             }
        //         }
        //     }
        // });

        $("#autocomplete-ajax-min").on("keyup", function(event) {
            if (event.which === 13) {
                var currentValue = $(this).val().trim().replace(/\w\S*/g, function(str){
                  return str.charAt(0).toUpperCase() + str.substr(1).toLowerCase();
                });
                if (!currentValue.length) {
                    return;
                }

                currentValue = $.trim(currentValue.replace(/\(.*\)?/, ""));

                if (/^[\d+]{5}$/.test(currentValue)) { // zip code
                    $('#idx_keyword').val(currentValue + "|zip");
                    flex_autocomplete.val(currentValue + " (Zip)");
                    flex_autocomplete_inner.val(currentValue + " (Zip)");
                    // do ajax
                    flex_refresh_search();
                } else if (/^[0-9a-zA-Z]{7,9}$/.test(currentValue) && /[0-9]/.test(currentValue) && (false === /\s/.test(currentValue))) {
                  $('#idx_keyword').val(currentValue + "|mls");
                  flex_autocomplete.val(currentValue + " (MLS)");
                  flex_autocomplete_inner.val(currentValue + " (MLS)");
                  // do ajax
                  flex_refresh_search();
                } else {
                    var check_flex_idx_single_autocomplete_cities = [];
                    currentValue = currentValue.toLowerCase();
                    for (var i = 0, l = flex_idx_autocomplete_cities.length; i < l; i++) {
                        check_flex_idx_single_autocomplete_cities[i] = flex_idx_autocomplete_cities[i].toLowerCase();
                    }
                    var inArrayCities = $.inArray(currentValue, check_flex_idx_single_autocomplete_cities);
                    if (inArrayCities > -1) {
                        currentValue = flex_idx_autocomplete_cities[inArrayCities];
                        $('#idx_keyword').val(currentValue + "|city");
                        flex_autocomplete.val(currentValue + " (City)");
                        flex_autocomplete_inner.val(currentValue + " (City)");
                        // do ajax
                        flex_refresh_search();
                    } else {
                      $('#idx_keyword').val(currentValue + "|address");
                      flex_autocomplete.val(currentValue + " (Address)");
                      flex_autocomplete_inner.val(currentValue + " (Address)");
                      // do ajax
                      flex_refresh_search();
                    }
                }
            }
        });

        $("#submit-ms").on("click", function() {
          event.preventDefault();

          // var currentValue = flex_autocomplete.val().trim();
          var currentValue = flex_autocomplete.val().trim().replace(/\w\S*/g, function(str){
            return str.charAt(0).toUpperCase() + str.substr(1).toLowerCase();
          });

          if (!currentValue.length) {
              return;
          }

          currentValue = $.trim(currentValue.replace(/\(.*\)?/, ""));

          if (/^[\d+]{5}$/.test(currentValue)) { // zip code
              $('#idx_keyword').val(currentValue + "|zip");
              flex_autocomplete.val(currentValue + " (Zip)");
              flex_autocomplete_inner.val(currentValue + " (Zip)");
              // do ajax
              flex_refresh_search();
          } else if (/^[0-9a-zA-Z]{7,9}$/.test(currentValue) && /[0-9]/.test(currentValue) && (false === /\s/.test(currentValue))) {
            $('#idx_keyword').val(currentValue + "|mls");
            flex_autocomplete.val(currentValue + " (MLS)");
            flex_autocomplete_inner.val(currentValue + " (MLS)");
            // do ajax
            flex_refresh_search();
          } else if (($.inArray(currentValue, flex_idx_autocomplete_cities)) > -1) {
              $('#idx_keyword').val(currentValue + "|city");
              flex_autocomplete.val(currentValue + " (City)");
              flex_autocomplete_inner.val(currentValue + " (City)");
              // do ajax
              flex_refresh_search();;
          } else if (/^[0-9a-zA-Z]{7,9}$/.test(currentValue) && /[0-9]/.test(currentValue) && (false === /\s/.test(currentValue))) {
            $('#idx_keyword').val(currentValue + "|mls");
            flex_autocomplete.val(currentValue + " (MLS)");
            flex_autocomplete_inner.val(currentValue + " (MLS)");
            // do ajax
            flex_refresh_search();
          } else {
            $('#idx_keyword').val(currentValue + "|address");
            flex_autocomplete.val(currentValue + " (Address)");
            flex_autocomplete_inner.val(currentValue + " (Address)");
            // do ajax
            flex_refresh_search();
          }
        });


        // $("#submit-ms").on("click", function() {
        //     // var currentValue = flex_autocomplete.val().trim();
        //     var currentValue = flex_autocomplete.val().trim().replace(/\w\S*/g, function(str){
        //       return str.charAt(0).toUpperCase() + str.substr(1).toLowerCase();
        //     });
        //     if (!currentValue.length) {
        //         return;
        //     }
        //     if (/^[\d+]{5}$/.test(currentValue)) { // zip code
        //         $('#idx_keyword').val(currentValue + "|zip");
        //         flex_autocomplete.val(currentValue + " (Zip)");
        //         flex_autocomplete_inner.val(currentValue + " (Zip)");
        //         // do ajax
        //         flex_refresh_search();
        //     } else if (/^[0-9a-zA-Z]{7,9}$/.test(currentValue) && /[0-9]/.test(currentValue)) {
        //       $('#idx_keyword').val(currentValue + "|mls");
        //       flex_autocomplete.val(currentValue + " (MLS)");
        //       flex_autocomplete_inner.val(currentValue + " (MLS)");
        //       // do ajax
        //       flex_refresh_search();
        //     } else if (($.inArray(currentValue, flex_idx_autocomplete_cities)) > -1) {
        //         $('#idx_keyword').val(currentValue + "|city");
        //         flex_autocomplete.val(currentValue + " (City)");
        //         flex_autocomplete_inner.val(currentValue + " (City)");
        //         // do ajax
        //         flex_refresh_search();;
        //     } else {
        //       $('#idx_keyword').val(currentValue + "|address");
        //       flex_autocomplete.val(currentValue + " (Address)");
        //       flex_autocomplete_inner.val(currentValue + " (Address)");
        //       // do ajax
        //       flex_refresh_search();
        //     }
        // });


        $("#submit-ms-min").on("click", function() {
            var currentValue = flex_autocomplete_inner.val().trim().replace(/\w\S*/g, function(str){
              return str.charAt(0).toUpperCase() + str.substr(1).toLowerCase();
            });

            if (!currentValue.length) {
                return;
            }

            currentValue = $.trim(currentValue.replace(/\(.*\)?/, ""));

            if (/^[\d+]{5}$/.test(currentValue)) { // zip code
                $('#idx_keyword').val(currentValue + "|zip");
                flex_autocomplete.val(currentValue + " (Zip)");
                flex_autocomplete_inner.val(currentValue + " (Zip)");
                // do ajax
                flex_refresh_search();
            } else if (/^[0-9a-zA-Z]{7,9}$/.test(currentValue) && /[0-9]/.test(currentValue) && (false === /\s/.test(currentValue))) {
              $('#idx_keyword').val(currentValue + "|mls");
              flex_autocomplete.val(currentValue + " (MLS)");
              flex_autocomplete_inner.val(currentValue + " (MLS)");
              // do ajax
              flex_refresh_search();
            } else if (($.inArray(currentValue, flex_idx_autocomplete_cities)) > -1) {
                $('#idx_keyword').val(currentValue + "|city");
                flex_autocomplete.val(currentValue + " (City)");
                flex_autocomplete_inner.val(currentValue + " (City)");
                // do ajax
                flex_refresh_search();;
            } else {
              $('#idx_keyword').val(currentValue + "|address");
              flex_autocomplete.val(currentValue + " (Address)");
              flex_autocomplete_inner.val(currentValue + " (Address)");
              // do ajax
              flex_refresh_search();
            }
        });
        // handle cities list
        $(document.body).on("click", function(event) {
          if ("LI" !== event.target.nodeName) {
            $('#cities-list').appendTo('#cities-list-wrap');
          }
        });
        // $("#cities-list").on("click", function(event) {
        //     event.stopPropagation();
        // });
        $('#cities-list').on("click", "li", function() {
            var label = $(this).html();
            var value = $(this).data('slug');
            flex_autocomplete.val(label + " (City)");
            flex_autocomplete_inner.val(label + " (City)");
            $('#idx_keyword').val(value);
            $('#cities-list').appendTo('#cities-list-wrap');
            $('#idx_page').val(1);
            // do ajax
            flex_refresh_search();
        });
        // setup save search
        $('#flex_save_search_btn, #save-button-responsive, .create-alert-footer').on("click", function() {
            event.stopPropagation();
            event.preventDefault();
            if (flex_idx_search_params.anonymous === "yes") {
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

            } else if (flex_idx_search_params.anonymous === "no" && ($("#flex-idx-search-form").data('save_count') > 500)) {
                sweetAlert(word_translate.oops, word_translate.you_cannot_save_search_with_more_than_500_properties, "error");
                return;
            } else {
                // ajax saved search
                var search_url = $("#flex-idx-search-form").data("save_slug");
                var search_count = $("#flex-idx-search-form").data("save_count");
                active_modal($('#modal_save_search'));
                setTimeout(function() {
                    $('#modal_properties_send').find('.close').click();
                }, 2000);
                if (name != null) {}
            }
        });

        $(".iboost-alert-change-interval").on("change", function() {
            var currentValue = $(this).val();
            switch (currentValue) {
                case "1":
                case "7":
                case "30":
                    $(".flex-save-type-options").prop("disabled", false);
                    $(".flex-save-type-options").prop("disabled", false);
                    break;
                case "--":
                default:
                    $(".flex-save-type-options").prop("checked", false);
                    $(".flex-save-type-options").prop("disabled", true);
                    break;
            }
        });

        $("#form-save").on("submit", function(event) {
            var arragle_notification_type = [];
            $('input[name="notification_type[]"]:checked').each(function() {
                arragle_notification_type.push(this.value);
            });
            event.preventDefault();
            var name = $('#input_sname_search').val().trim();
            var search_url = $("#flex-idx-search-form").data("save_slug");
            var search_count = $("#flex-idx-search-form").data("save_count");
            var search_query = decodeURIComponent($("#flex-idx-search-form").data('save_query'));
            var current_type_alert = $(".iboost-alert-change-interval:eq(0)").val();
            if (name != null && name.length > 0) {
                if ((current_type_alert == 1) || (current_type_alert == 7)) {
                    var qty_checked = $(".flex-save-type-options:checked");
                    if (qty_checked.length <= 0) {
                        sweetAlert(word_translate.oops, word_translate.youmust_selectat_least_one_checkbox_from_below, "error");
                        return;
                    }
                }
                $.ajax({
                    url: flex_idx_search_params.ajaxUrl,
                    method: "POST",
                    data: {
                        action: "flex_save_search",
                        search_url: search_url,
                        search_count: search_count,
                        name: name,
                        notification_day: $('.notification_day_class').val(),
                        notification_type: arragle_notification_type,
                        search_query: search_query,
                        type: "add"
                    },
                    dataType: "json",
                    success: function(data) {
                        if (data.success === true) {
                            swal({ title: word_translate.search_saved, text: word_translate.your_search_has_been_saved_successfuly, type: "success", timer: 2000, showConfirmButton: false });
                            $('#modal_save_search').removeClass('active_modal');
                            $('#input_sname_search').val('');
                            $('input[name="notification_type[]"]').each(function() {
                                this.checked = false;
                            });
                            $('.notification_day_class').val('--');
                        } else {
                            // show error
                            sweetAlert(word_translate.oops, data.message, "error");
                        }
                    }
                });
            } else {
                sweetAlert(word_translate.oops, word_translate.you_must_provide_a_name_for_this_search, "error");
            }
        });
        $("#form-update").on("submit", function(event) {
            var arragle_notification_type = [];
            $('input[name="notification_type[]"]:checked').each(function() {
                arragle_notification_type.push(this.value);
            });
            event.preventDefault();
            var name = $('#input_sname_search').val();
            var search_url = $("#flex-idx-search-form").data("save_slug");
            var search_count = $("#flex-idx-search-form").data("save_count");
            if (name != null && name.length > 0) {
                $.ajax({
                    url: flex_idx_search_params.ajaxUrl,
                    method: "POST",
                    data: {
                        action: "flex_save_search",
                        search_url: search_url,
                        search_count: search_count,
                        name: name,
                        notification_day: $('.notification_day_class').val(),
                        notification_type: arragle_notification_type,
                        type: "update"
                    },
                    dataType: "json",
                    success: function(data) {
                        if (data.success == true) {
                            $('#modal_save_search').removeClass('active_modal');

                            swal({ title: word_translate.search_saved, text: word_translate.your_search_has_been_saved_successfuly, type: "success", timer: 2000, showConfirmButton: false });
                            $('#input_sname_search').val('');
                            $('input[name="notification_type[]"]').each(function() {
                                this.checked = false;
                            });
                            $('.notification_day_class').val('--');
                        } else {
                            // show error
                            sweetAlert(word_translate.oops, data.message, "error");
                        }
                    }
                });
            } else {
                sweetAlert(word_translate.oops, word_translate.you_must_provide_a_name_for_this_search, "error");
            }
        });
        $('.update_search_over').on("click", function() {
            event.stopPropagation();
            event.preventDefault();
            $('#input_sname_search').val($(this).attr('txtedit'));
            active_modal($('#modal_save_search'));
            setTimeout(function() {
                $('#modal_properties_send').find('.close').click();
            }, 2000);
        });
        // setup favorite
        $(document).on("click", ".flex-favorite-btn", function(event) {
            event.stopPropagation();

            var buton_corazon = $(this);
            // active
            if (flex_idx_search_params.anonymous === "yes") {
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
                    $(this).find('.clidxboost-icon-check').addClass('active');
                    $.ajax({
                        url: flex_idx_search_params.ajaxUrl,
                        method: "POST",
                        data: {
                            action: "flex_favorite",
                            class_id: class_id,
                            mls_num: mls_num,
                            subject:property_subject,
                            type_action: 'add'
                        },
                        dataType: "json",
                        success: function(data) {
                            var totsearch=0;
                            totsearch=1+parseInt(jQuery('.clidxboost-icon-favorite span span').text());
                            $('.clidxboost-icon-favorite span span').text(totsearch);
                            $(buton_corazon).attr("data-alert-token", data.token_alert);
                        }
                    });
                } else {
                    $(this).find('.clidxboost-icon-check').removeClass('active');
                    var token_alert = $(this).attr("data-alert-token");
                    $.ajax({
                        url: flex_idx_search_params.ajaxUrl,
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
                            var totsearch=0;
                            totsearch=parseInt(jQuery('.clidxboost-icon-favorite span span').text())-1;
                            if(totsearch<0) totsearch=0;
                            $('.clidxboost-icon-favorite span span').text(totsearch);
                            $(buton_corazon).attr("data-alert-token", '');
                        }
                    });
                }
            }
        });
        // setup waterfront
        flex_waterfront_switch = $('#flex_waterfront_switch');
        if (flex_waterfront_switch.length) {
            flex_waterfront_switch.on("change", function() {
                var _self = $(this);
                $('#idx_water_desc').val(_self.val());
                $('#idx_page').val(1);
                // do ajax
                flex_refresh_search();
            });
        }

        // setup parking
        flex_parking_switch = $('#flex_parking_switch');
        if (flex_parking_switch.length) {
            flex_parking_switch.on("change", function() {
                var _self = $(this);
                $('#idx_parking').val(_self.val());
                $('#idx_page').val(1);
                // do ajax
                flex_refresh_search();
            });
        }

        // setup pagination
        flex_pagination = $('#nav-results');
        if (flex_pagination.length) {
            flex_pagination.on('click', 'a', function(event) {
                event.preventDefault();
                var _self = $(this);
                var _page = _self.data('page');
                $('#idx_page').val(_page);
                // do ajax
                flex_refresh_search();
            });
        }
        // setup sort
        flex_filter_sort = $('#flex_filter_sort');

        if (flex_filter_sort.length) {
            flex_filter_sort.on("change", function() {
                var _self = $(this);
                $('#idx_sort').val(_self.val());
                $('#idx_page').val(1);
                // do ajax
                flex_refresh_search();
            });
        }

        // setup sliders
        baths_slider = $("#range-baths");
        beds_slider = $("#range-beds");
        sqft_slider = $("#range-living");
        lotsize_slider = $("#range-land");
        price_sale_slider = $("#range-price");
        price_rent_slider = $("#range-price-rent");
        year_built_slider = $('#range-year');

        // setup property types
        $('.property_type_checkbox').on('change', function() {
            var checked_items = $('.property_type_checkbox:checked');
            if (checked_items.length) {
                var checked_values = [];
                checked_items.each(function() {
                    checked_values.push($(this).val());
                });
                if (checked_values.length) {
                    $('#idx_property_type').val(checked_values.join("|"));
                }
            } else {
                $('#idx_property_type').val(property_type_values.join("|"));
            }
            $('#idx_page').val(1);
            // do ajax
            flex_refresh_search();
        });
        // setup amenities
        $('.amenities_checkbox').on('change', function() {
            var checked_items = $('.amenities_checkbox:checked');
            if (checked_items.length) {
                var checked_values = [];
                checked_items.each(function() {
                    checked_values.push($(this).val());
                });
                $('#idx_features').val(checked_values.join("|"));
            } else {
                $('#idx_features').val("");
            }
            $('#idx_page').val(1);
            // do ajax
            flex_refresh_search();
        });
        // setup switch rental type
        flex_search_rental_switch = $('.flex_search_rental_switch');
        if (flex_search_rental_switch.length) {
            flex_search_rental_switch.on('click', function() {
                var _self = $(this);
                if (_self.hasClass('active')) {
                    return;
                }
                flex_search_rental_switch.removeClass('active');
                _self.addClass('active');
                $('.price_ranges_ct').hide();
                var type = _self.attr('id');

                if (type == 'for-sale') { // for sale
                    $('.price_range_for_sale').show();
                    $('#idx_rental').val(0);
                } else if (type == 'for-rent') { // for rent
                    $('.price_range_for_rent').show();
                    $('#idx_rental').val(1);
                }

                $('#idx_page').val(1);
                // do ajax
                flex_refresh_search();
            });
        }
        if (baths_slider.length) {
            baths_slider.slider({
                range: true,
                min: 0,
                max: baths_slider_values.length - 1,
                step: 1,
                slide: function(event, ui) {
                    var startValue = ui.values[0];
                    var endValue = ui.values[1];
                },
                create: function(event, ui) {
                    var min_val = $('#idx_min_baths').val() === '--' ? baths_slider_values[0] : parseFloat($('#idx_min_baths').val(), 10);
                    var max_val = $('#idx_max_baths').val() === '--' ? baths_slider_values[baths_slider_values.length - 1] : parseFloat($('#idx_max_baths').val(), 10);
                    var _self = $(this);
                    var startValue = $('#idx_min_baths').val() === '--' ? 0 : baths_slider_values.indexOf(min_val);
                    var endValue = $('#idx_max_baths').val() === '--' ? (baths_slider_values.length - 1) : baths_slider_values.indexOf(max_val);
                    _self.slider('values', [startValue, endValue]);
                },
                change: function(event, ui) {
                    var startValue = ui.values[0];
                    var endValue = ui.values[1];
                    var initialStartValue = (baths_slider_values[startValue] == baths_slider_values[0]) ? '--' : baths_slider_values[startValue];
                    var initialEndValue = (baths_slider_values[endValue] == baths_slider_values[baths_slider_values.length - 1]) ? '--' : baths_slider_values[endValue];
                    $('#idx_min_baths').val(initialStartValue);
                    $('#idx_max_baths').val(initialEndValue);

                    if (xhr_running === true) {
                        $('#idx_page').val(1);
                    }

                    // do ajax
                    flex_refresh_search();
                }
            });
        }
        if (beds_slider.length) {
            beds_slider.slider({
                range: true,
                min: 0,
                max: beds_slider_values.length - 1,
                step: 1,
                slide: function(event, ui) {
                    var startValue = ui.values[0];
                    var endValue = ui.values[1];
                },
                create: function(event, ui) {
                    var min_val = $('#idx_min_beds').val() === '--' ? beds_slider_values[0] : parseInt($('#idx_min_beds').val(), 10);
                    var max_val = $('#idx_max_beds').val() === '--' ? beds_slider_values[beds_slider_values.length - 1] : parseInt($('#idx_max_beds').val(), 10);
                    var _self = $(this);
                    var startValue = $('#idx_min_beds').val() === '--' ? 0 : beds_slider_values.indexOf(min_val);
                    var endValue = $('#idx_max_beds').val() === '--' ? (beds_slider_values.length - 1) : beds_slider_values.indexOf(max_val);
                    _self.slider('values', [startValue, endValue]);
                },
                change: function(event, ui) {
                    var startValue = ui.values[0];
                    var endValue = ui.values[1];
                    var initialStartValue = (beds_slider_values[startValue] == beds_slider_values[0]) ? '--' : beds_slider_values[startValue];
                    var initialEndValue = (beds_slider_values[endValue] == beds_slider_values[beds_slider_values.length - 1]) ? '--' : beds_slider_values[endValue];
                    $('#idx_min_beds').val(initialStartValue);
                    $('#idx_max_beds').val(initialEndValue);

                    if (xhr_running === true) {
                        $('#idx_page').val(1);
                    }

                    // do ajax
                    flex_refresh_search();
                }
            });
        }
        if (sqft_slider.length) {
            sqft_slider.slider({
                range: true,
                min: 0,
                max: sqft_slider_values.length - 1,
                step: 1,
                slide: function(event, ui) {
                    var startValue = ui.values[0];
                    var endValue = ui.values[1];

                    $('#living_from').val(_.formatPrice(sqft_slider_values[startValue]) + " "+word_translate.sqft);

                    if (endValue == 37) {
                         $('#living_to').val(word_translate.any_size);
                    } else {
                         $('#living_to').val(_.formatPrice(sqft_slider_values[endValue]) + " "+word_translate.sqft);
                    }

                    flex_input_living_from_old_value = sqft_slider_values[startValue];
                    flex_input_living_to_old_value = sqft_slider_values[endValue];
                },
                create: function(event, ui) {
                    var min_val = $('#idx_living_area_min').val() === '--' ? sqft_slider_values[0] : parseInt($('#idx_living_area_min').val(), 10);
                    var max_val = $('#idx_living_area_max').val() === '--' ? sqft_slider_values[sqft_slider_values.length - 1] : parseInt($('#idx_living_area_max').val(), 10);
                    var _self = $(this);
                    var startValue = $('#idx_living_area_min').val() === '--' ? 0 : sqft_slider_values.indexOf(min_val);
                    var endValue = $('#idx_living_area_max').val() === '--' ? (sqft_slider_values.length - 1) : sqft_slider_values.indexOf(max_val);
                    _self.slider('values', [startValue, endValue]);

                    $('#living_from').val(_.formatPrice(min_val) + " "+word_translate.sqft);

                    if (80000 == max_val) {
                        $('#living_to').val(word_translate.any_size);
                    } else {
                        $('#living_to').val(_.formatPrice(max_val) +" "+word_translate.sqft);
                    }
                },
                change: function(event, ui) {
                    var startValue = ui.values[0];
                    var endValue = ui.values[1];
                    $('#idx_living_area_min').val(sqft_slider_values[startValue]);
                    $('#idx_living_area_max').val(sqft_slider_values[endValue]);
                    if (xhr_running === true) {
                        $('#idx_page').val(1);
                    }
                    // do ajax
                    flex_refresh_search();
                }
            });
        }
        if (lotsize_slider.length) {
            lotsize_slider.slider({
                range: true,
                min: 0,
                max: lotsize_slider_values.length - 1,
                step: 1,
                slide: function(event, ui) {
                    var startValue = ui.values[0];
                    var endValue = ui.values[1];

                    $('#land_from').val(_.formatPrice(lotsize_slider_values[startValue]) +" "+word_translate.sqft);

                    if (endValue == 37) {
                         $('#land_to').val(word_translate.any_size);
                    } else {
                         $('#land_to').val(_.formatPrice(lotsize_slider_values[endValue]) +" "+word_translate.sqft);
                    }

                    flex_input_land_from_old_value = lotsize_slider_values[startValue];
                    flex_input_land_to_old_value = lotsize_slider_values[endValue];
                },
                create: function(event, ui) {
                    var min_val = $('#idx_lot_size_min').val() === '--' ? sqft_slider_values[0] : parseInt($('#idx_lot_size_min').val(), 10);
                    var max_val = $('#idx_lot_size_max').val() === '--' ? sqft_slider_values[sqft_slider_values.length - 1] : parseInt($('#idx_lot_size_max').val(), 10);
                    var _self = $(this);
                    var startValue = $('#idx_lot_size_min').val() === '--' ? 0 : sqft_slider_values.indexOf(min_val);
                    var endValue = $('#idx_lot_size_max').val() === '--' ? (sqft_slider_values.length - 1) : sqft_slider_values.indexOf(max_val);
                    _self.slider('values', [startValue, endValue]);

                    $('#land_from').val(_.formatPrice(min_val) +" "+word_translate.sqft);

                    if (80000 == max_val) {
                        $('#land_to').val(word_translate.any_size);
                    } else {
                        $('#land_to').val(_.formatPrice(max_val) +" "+word_translate.sqft);
                    }
                },
                change: function(event, ui) {
                    var startValue = ui.values[0];
                    var endValue = ui.values[1];

                    if ((startValue == 0) || (startValue == 37)) {
                        $('#idx_lot_size_min').val('--');
                    } else {
                        $('#idx_lot_size_min').val(lotsize_slider_values[startValue]);
                    }

                    if ((endValue == 0) || (endValue == 37)) {
                        $('#idx_lot_size_max').val('--');
                    } else {
                        $('#idx_lot_size_max').val(lotsize_slider_values[endValue]);
                    }

                    $('#idx_lot_size_min').val(lotsize_slider_values[startValue]);
                    $('#idx_lot_size_max').val(lotsize_slider_values[endValue]);
                    if (xhr_running === true) {
                        $('#idx_page').val(1);
                    }
                    // do ajax
                    flex_refresh_search();
                }
            });
        }
        if (price_sale_slider.length) {
            price_sale_slider.slider({
                range: true,
                min: 0,
                max: price_sale_slider_values.length - 1,
                step: 1,
                slide: function(event, ui) {
                    var startValue = ui.values[0];
                    var endValue = ui.values[1];

                    $('#price_from').val('$' + _.formatPrice(price_sale_slider_values[startValue]));

                    if (endValue == 48) {
                         $('#price_to').val(word_translate.any_price);
                    } else {
                         $('#price_to').val('$' + _.formatPrice(price_sale_slider_values[endValue]));
                    }

                    flex_input_min_price_sale_old_value = price_sale_slider_values[startValue];
                    flex_input_max_price_sale_old_value = price_sale_slider_values[endValue];
                },
                create: function(event, ui) {
                    var min_val = $('#idx_min_price_sale').val() === '--' ? price_sale_slider_values[0] : parseInt($('#idx_min_price_sale').val(), 10);
                    var max_val = $('#idx_max_price_sale').val() === '--' ? price_sale_slider_values[price_sale_slider_values.length - 1] : parseInt($('#idx_max_price_sale').val(), 10);
                    var _self = $(this);
                    var startValue = $('#idx_min_price_sale').val() === '--' ? 0 : price_sale_slider_values.indexOf(min_val);
                    var endValue = $('#idx_max_price_sale').val() === '--' ? (price_sale_slider_values.length - 1) : price_sale_slider_values.indexOf(max_val);
                    _self.slider('values', [startValue, endValue]);

                    $('#price_from').val('$' + _.formatPrice(min_val));

                    if (100000000 == max_val) {
                        $('#price_to').val(word_translate.any_price);
                    } else {
                        $('#price_to').val('$' + _.formatPrice(max_val));
                    }
                },
                change: function(event, ui) {
                    var startValue = ui.values[0];
                    var endValue = ui.values[1];
                    $('#idx_min_price_sale').val(price_sale_slider_values[startValue]);
                    $('#idx_max_price_sale').val(price_sale_slider_values[endValue]);
                    if (xhr_running === true) {
                        $('#idx_page').val(1);
                    }
                    // do ajax
                    flex_refresh_search();
                }
            });
        }
        if (price_rent_slider.length) {
            price_rent_slider.slider({
                range: true,
                min: 0,
                max: price_rent_slider_values.length - 1,
                step: 1,
                slide: function(event, ui) {
                    var startValue = ui.values[0];
                    var endValue = ui.values[1];

                    $('#price_rent_from').val('$' + _.formatPrice(price_rent_slider_values[startValue]));

                    if (endValue == 30) {
                         $('#price_rent_to').val(word_translate.any_price);
                    } else {
                         $('#price_rent_to').val('$' + _.formatPrice(price_rent_slider_values[endValue]));
                    }

                    flex_input_min_price_rent_old_value = price_rent_slider_values[startValue];
                    flex_irent_max_price_sale_old_value = price_rent_slider_values[endValue];
                },
                create: function(event, ui) {
                    var min_val = $('#idx_min_price_rent').val() === '--' ? price_rent_slider_values[0] : parseInt($('#idx_min_price_rent').val(), 10);
                    var max_val = $('#idx_max_price_rent').val() === '--' ? price_rent_slider_values[price_rent_slider_values.length - 1] : parseInt($('#idx_max_price_rent').val(), 10);
                    var _self = $(this);
                    var startValue = $('#idx_min_price_rent').val() === '--' ? 0 : price_rent_slider_values.indexOf(min_val);
                    var endValue = $('#idx_max_price_rent').val() === '--' ? (price_rent_slider_values.length - 1) : price_rent_slider_values.indexOf(max_val);
                    _self.slider('values', [startValue, endValue]);
                    $('#price_rent_from').val('$' + _.formatPrice(min_val));

                    if (100000 == max_val) {
                        $('#price_rent_to').val(word_translate.any_price);
                    } else {
                        $('#price_rent_to').val('$' + _.formatPrice(max_val));
                    }

                },
                change: function(event, ui) {
                    var startValue = ui.values[0];
                    var endValue = ui.values[1];
                    $('#idx_min_price_rent').val(price_rent_slider_values[startValue]);
                    $('#idx_max_price_rent').val(price_rent_slider_values[endValue]);
                    if (xhr_running === true) {
                        $('#idx_page').val(1);
                    }
                    // do ajax
                    flex_refresh_search();
                }
            });
        }
        if (year_built_slider.length) {
            year_built_slider.slider({
                range: true,
                min: 0,
                max: year_built_slider_values.length - 1,
                step: 1,
                slide: function(event, ui) {
                    var startValue = ui.values[0];
                    var endValue = ui.values[1];
                    $('#year_from').val(year_built_slider_values[startValue]);
                    $('#year_to').val(year_built_slider_values[endValue]);
                    flex_input_year_min_old_value = year_built_slider_values[startValue];
                    flex_input_year_max_old_value = year_built_slider_values[endValue];
                },
                create: function(event, ui) {
                    var min_val = $('#idx_min_year').val() === '--' ? year_built_slider_values[0] : parseInt($('#idx_min_year').val(), 10);
                    var max_val = $('#idx_max_year').val() === '--' ? year_built_slider_values[year_built_slider_values.length - 1] : parseInt($('#idx_max_year').val(), 10);
                    var _self = $(this);
                    var startValue = $('#idx_min_year').val() === '--' ? 0 : year_built_slider_values.indexOf(min_val);
                    var endValue = $('#idx_max_year').val() === '--' ? (year_built_slider_values.length - 1) : year_built_slider_values.indexOf(max_val);
                    _self.slider('values', [startValue, endValue]);
                    $('#year_from').val(min_val);
                    $('#year_to').val(max_val);
                },
                change: function(event, ui) {
                    var startValue = ui.values[0];
                    var endValue = ui.values[1];

                    if ((startValue == 0) || (startValue == 120)) {
                        $('#idx_min_year').val('--');
                    } else {
                        $('#idx_min_year').val(year_built_slider_values[startValue]);
                    }

                    if ((endValue == 0) || (endValue == 120)) {
                        $('#idx_max_year').val('--');
                    } else {
                        $('#idx_max_year').val(year_built_slider_values[endValue]);
                    }

                    if (xhr_running === true) {
                        $('#idx_page').val(1);
                    }

                    // do ajax
                    flex_refresh_search();
                }
            });
        }
        // trigger initial ajax
        /*
        xhr_running = true;
        if ($("#flex-idx-search-form").length) {
            flex_refresh_search();
        }
        */
        // fill values
        // handle input fields
        var flex_input_min_price_sale = $('#price_from');
        var flex_input_max_price_sale = $('#price_to');
        var flex_input_min_price_sale_old_value;
        var flex_input_max_price_sale_old_value;
        if (flex_input_min_price_sale.length) {
            flex_input_min_price_sale.data('min-price', price_sale_slider_values[0]);
            flex_input_min_price_sale.data('max-price', price_sale_slider_values[price_sale_slider_values.length - 1]);
            flex_input_min_price_sale_old_value = parseInt(flex_input_min_price_sale.val().trim().replace(/\D/g, ''), 10);
            flex_input_min_price_sale.on('blur', function() {
                var currentValue = jQuery(this).val().trim();
                currentValue = currentValue.replace(/\D/g, '');
                if (typeof currentValue === 'string' && currentValue.length === 0) {
                    currentValue = flex_input_min_price_sale_old_value;
                } else {
                    currentValue = parseInt(currentValue, 10);
                }

                $(this).val('$' + _.formatPrice(currentValue));
            });
            flex_input_min_price_sale.on('change', function() {
                var currentValue = jQuery(this).val().trim();
                currentValue = currentValue.replace(/\D/g, '');
                if (typeof currentValue === 'string' && currentValue.length === 0) {
                    currentValue = $(this).data('min-price');
                } else {
                    currentValue = parseInt(currentValue, 10);
                }
                if (currentValue < $(this).data('min-price')) {
                    currentValue = $(this).data('min-price');
                } else if (currentValue > $(this).data('max-price')) {
                    currentValue = $(this).data('max-price');
                }
                if (currentValue > parseInt(flex_input_max_price_sale.val().trim().replace(/\D/g, ''), 10)) {
                    alert(word_translate.current_value_must_be_less_than_or_equal_to+' ' + parseInt(flex_input_max_price_sale.val().trim().replace(/\D/g, ''), 10));
                    currentValue = $(this).data('min-price');
                } else {
                    $('#price_from').val(currentValue);
                    $('#idx_min_price_sale').val(currentValue);
                    var x_val = price_sale_slider_values.indexOf(currentValue);
                    var y_val = price_sale_slider_values.indexOf(parseInt(flex_input_max_price_sale.val().trim().replace(/\D/g, ''), 10));
                    flex_input_min_price_sale_old_value = currentValue;
                    if (x_val !== -1 && y_val !== -1) {
                        $('#range-price').slider('values', [x_val, y_val]);
                    }

                    // do ajax
                    $('#idx_page').val(1);
                    flex_refresh_search();
                }
                $(this).val('$' + _.formatPrice(currentValue));
            });
        }
        if (flex_input_max_price_sale.length) {
            flex_input_max_price_sale.data('min-price', price_sale_slider_values[0]);
            flex_input_max_price_sale.data('max-price', price_sale_slider_values[price_sale_slider_values.length - 1]);
            flex_input_max_price_sale_old_value = parseInt(flex_input_max_price_sale.val().trim().replace(/\D/g, ''), 10);
            flex_input_max_price_sale.on('blur', function() {
                var currentValue = jQuery(this).val().trim();
                currentValue = currentValue.replace(/\D/g, '');
                if (typeof currentValue === 'string' && currentValue.length === 0) {
                    currentValue = flex_input_max_price_sale_old_value;
                } else {
                    currentValue = parseInt(currentValue, 10);
                }
                $(this).val('$' + _.formatPrice(currentValue));
            });
            flex_input_max_price_sale.on('change', function() {
                var currentValue = jQuery(this).val().trim();
                currentValue = currentValue.replace(/\D/g, '');
                if (typeof currentValue === 'string' && currentValue.length === 0) {
                    currentValue = $(this).data('max-price');
                } else {
                    currentValue = parseInt(currentValue, 10);
                }
                if (currentValue < $(this).data('min-price')) {
                    currentValue = $(this).data('min-price');
                } else if (currentValue > $(this).data('max-price')) {
                    currentValue = $(this).data('max-price');
                }
                if (currentValue < parseInt(flex_input_min_price_sale.val().trim().replace(/\D/g, ''), 10)) {
                    alert(word_translate.current_value_must_be_less_than_or_equal_to+' ' + parseInt(flex_input_min_price_sale.val().trim().replace(/\D/g, ''), 10));
                    currentValue = $(this).data('min-price');
                } else {
                    $('#price_to').val(currentValue);
                    $('#idx_max_price_sale').val(currentValue);
                    var x_val = price_sale_slider_values.indexOf(parseInt(flex_input_min_price_sale.val().trim().replace(/\D/g, ''), 10));
                    var y_val = price_sale_slider_values.indexOf(currentValue);
                    flex_input_max_price_sale_old_value = currentValue;
                    if (x_val !== -1 && y_val !== -1) {
                        $('#range-price').slider('values', [x_val, y_val]);
                    }

                    $('#idx_page').val(1);
                    // do ajax
                    flex_refresh_search();
                }
                $(this).val('$' + _.formatPrice(currentValue));
            });
        }

        var flex_input_min_price_rent = $('#price_rent_from');
        var flex_input_max_price_rent = $('#price_rent_to');
        var flex_input_min_price_rent_old_value;
        var flex_irent_max_price_sale_old_value;
        if (flex_input_min_price_rent.length) {
            flex_input_min_price_rent.data('min-price', price_rent_slider_values[0]);
            flex_input_min_price_rent.data('max-price', price_rent_slider_values[price_rent_slider_values.length - 1]);
            flex_input_min_price_rent_old_value = parseInt(flex_input_min_price_rent.val().trim().replace(/\D/g, ''), 10);

            flex_input_min_price_rent.on('blur', function() {
                var currentValue = jQuery(this).val().trim();
                currentValue = currentValue.replace(/\D/g, '');
                if (typeof currentValue === 'string' && currentValue.length === 0) {
                    currentValue = flex_input_min_price_rent_old_value;
                } else {
                    currentValue = parseInt(currentValue, 10);
                }

                $(this).val('$' + _.formatPrice(currentValue));
            });
            flex_input_min_price_rent.on('change', function() {
                var currentValue = jQuery(this).val().trim();
                currentValue = currentValue.replace(/\D/g, '');
                if (typeof currentValue === 'string' && currentValue.length === 0) {
                    currentValue = $(this).data('min-price');
                } else {
                    currentValue = parseInt(currentValue, 10);
                }
                if (currentValue < $(this).data('min-price')) {
                    currentValue = $(this).data('min-price');
                } else if (currentValue > $(this).data('max-price')) {
                    currentValue = $(this).data('max-price');
                }
                if (currentValue > parseInt(flex_input_max_price_rent.val().trim().replace(/\D/g, ''), 10)) {
                    alert(word_translate.current_value_must_be_less_than_or_equal_to+' ' + parseInt(flex_input_max_price_rent.val().trim().replace(/\D/g, ''), 10));
                    currentValue = $(this).data('min-price');
                } else {
                    $('#price_rent_from').val(currentValue);
                    $('#idx_min_price_rent').val(currentValue);
                    var x_val = price_rent_slider_values.indexOf(currentValue);
                    var y_val = price_rent_slider_values.indexOf(parseInt(flex_input_max_price_rent.val().trim().replace(/\D/g, ''), 10));
                    flex_input_min_price_rent_old_value = currentValue;
                    if (x_val !== -1 && y_val !== -1) {
                        $('#range-price-rent').slider('values', [x_val, y_val]);
                    }

                    // do ajax
                    $('#idx_page').val(1);
                    flex_refresh_search();
                }
                $(this).val('$' + _.formatPrice(currentValue));
            });
        }
        if (flex_input_max_price_rent.length) {
            flex_input_max_price_rent.data('min-price', price_rent_slider_values[0]);
            flex_input_max_price_rent.data('max-price', price_rent_slider_values[price_rent_slider_values.length - 1]);
            flex_input_max_price_rent_old_value = parseInt(flex_input_max_price_rent.val().trim().replace(/\D/g, ''), 10);
            flex_input_max_price_rent.on('blur', function() {
                var currentValue = jQuery(this).val().trim();
                currentValue = currentValue.replace(/\D/g, '');
                if (typeof currentValue === 'string' && currentValue.length === 0) {
                    currentValue = flex_input_max_price_rent_old_value;
                } else {
                    currentValue = parseInt(currentValue, 10);
                }
                $(this).val(_.formatPrice(currentValue) + ' Sq.Ft.');
            });
            flex_input_max_price_rent.on('change', function() {
                var currentValue = jQuery(this).val().trim();
                currentValue = currentValue.replace(/\D/g, '');
                if (typeof currentValue === 'string' && currentValue.length === 0) {
                    currentValue = $(this).data('max-price');
                } else {
                    currentValue = parseInt(currentValue, 10);
                }
                if (currentValue < $(this).data('min-price')) {
                    currentValue = $(this).data('min-price');
                } else if (currentValue > $(this).data('max-price')) {
                    currentValue = $(this).data('max-price');
                }
                if (currentValue < parseInt(flex_input_min_price_rent.val().trim().replace(/\D/g, ''), 10)) {
                    alert(word_translate.current_value_must_be_less_than_or_equal_to+' ' + parseInt(flex_input_min_price_rent.val().trim().replace(/\D/g, ''), 10));
                    currentValue = $(this).data('min-price');
                } else {
                    $('#price_rent_to').val(currentValue);
                    $('#idx_max_price_rent').val(currentValue);
                    var x_val = price_rent_slider_values.indexOf(parseInt(flex_input_min_price_rent.val().trim().replace(/\D/g, ''), 10));
                    var y_val = price_rent_slider_values.indexOf(currentValue);
                    flex_input_max_price_rent_old_value = currentValue;
                    if (x_val !== -1 && y_val !== -1) {
                        $('#range-price-rent').slider('values', [x_val, y_val]);
                    }

                    // do ajax
                    $('#idx_page').val(1);
                    flex_refresh_search();
                }
                $(this).val('$' + _.formatPrice(currentValue));
            });
        }

        var flex_input_land_from = $('#land_from');
        var flex_input_land_to = $('#land_to');
        var flex_input_land_from_old_value;
        var flex_input_land_to_old_value;
        if (flex_input_land_from.length) {
            flex_input_land_from.data('min-sqft', sqft_slider_values[0]);
            flex_input_land_from.data('max-sqft', sqft_slider_values[sqft_slider_values.length - 1]);
            flex_input_land_from_old_value = parseInt(flex_input_land_from.val().trim().replace(/\D/g, ''), 10);
            flex_input_land_from.on('blur', function() {
                var currentValue = jQuery(this).val().trim();
                currentValue = currentValue.replace(/\D/g, '');
                if (typeof currentValue === 'string' && currentValue.length === 0) {
                    currentValue = flex_input_land_from_old_value;
                } else {
                    currentValue = parseInt(currentValue, 10);
                }

                $(this).val(_.formatPrice(currentValue) + ' Sq.Ft.');
            });
            flex_input_land_from.on('change', function() {
                var currentValue = jQuery(this).val().trim();
                currentValue = currentValue.replace(/\D/g, '');
                if (typeof currentValue === 'string' && currentValue.length === 0) {
                    currentValue = $(this).data('min-sqft');
                } else {
                    currentValue = parseInt(currentValue, 10);
                }
                if (currentValue < $(this).data('min-sqft')) {
                    currentValue = $(this).data('min-sqft');
                } else if (currentValue > $(this).data('max-sqft')) {
                    currentValue = $(this).data('max-sqft');
                }
                if (currentValue > parseInt(flex_input_land_to.val().trim().replace(/\D/g, ''), 10)) {
                    alert(word_translate.current_value_must_be_less_than_or_equal_to+' ' + parseInt(flex_input_land_to.val().trim().replace(/\D/g, ''), 10));
                    currentValue = $(this).data('min-sqft');
                } else {
                    $('#land_from').val(currentValue);
                    $('#idx_lot_size_min').val(currentValue);
                    var x_val = sqft_slider_values.indexOf(currentValue);
                    var y_val = sqft_slider_values.indexOf(parseInt(flex_input_land_to.val().trim().replace(/\D/g, ''), 10));
                    flex_input_land_from_old_value = currentValue;
                    if (x_val !== -1 && y_val !== -1) {
                        $('#range-land').slider('values', [x_val, y_val]);
                    }

                    // do ajax
                    $('#idx_page').val(1);
                    flex_refresh_search();
                }
                $(this).val(_.formatPrice(currentValue) +' '+word_translate.sqft);
            });
        }
        if (flex_input_land_to.length) {
            flex_input_land_to.data('min-sqft', sqft_slider_values[0]);
            flex_input_land_to.data('max-sqft', sqft_slider_values[sqft_slider_values.length - 1]);
            flex_input_land_to_old_value = parseInt(flex_input_land_to.val().trim().replace(/\D/g, ''), 10);
            flex_input_land_to.on('blur', function() {
                var currentValue = jQuery(this).val().trim();
                currentValue = currentValue.replace(/\D/g, '');
                if (typeof currentValue === 'string' && currentValue.length === 0) {
                    currentValue = flex_input_land_to_old_value;
                } else {
                    currentValue = parseInt(currentValue, 10);
                }
                $(this).val(_.formatPrice(currentValue) +' '+word_translate.sqft);
            });
            flex_input_land_to.on('change', function() {
                var currentValue = jQuery(this).val().trim();
                currentValue = currentValue.replace(/\D/g, '');
                if (typeof currentValue === 'string' && currentValue.length === 0) {
                    currentValue = $(this).data('max-sqft');
                } else {
                    currentValue = parseInt(currentValue, 10);
                }
                if (currentValue < $(this).data('min-sqft')) {
                    currentValue = $(this).data('min-sqft');
                } else if (currentValue > $(this).data('max-sqft')) {
                    currentValue = $(this).data('max-sqft');
                }
                if (currentValue < parseInt(flex_input_land_from.val().trim().replace(/\D/g, ''), 10)) {
                    alert(word_translate.current_value_must_be_less_than_or_equal_to+' ' + parseInt(flex_input_land_from.val().trim().replace(/\D/g, ''), 10));
                    currentValue = $(this).data('min-sqft');
                } else {
                    $('#land_to').val(currentValue);
                    $('#idx_lot_size_max').val(currentValue);
                    var x_val = sqft_slider_values.indexOf(parseInt(flex_input_land_from.val().trim().replace(/\D/g, ''), 10));
                    var y_val = sqft_slider_values.indexOf(currentValue);
                    flex_input_land_to_old_value = currentValue;
                    if (x_val !== -1 && y_val !== -1) {
                        $('#range-land').slider('values', [x_val, y_val]);
                    }
                    // do ajax
                    $('#idx_page').val(1);
                    flex_refresh_search();
                }
                $(this).val(_.formatPrice(currentValue) +' '+word_translate.sqft);
            });
        }

        var flex_input_living_from = $('#living_from');
        var flex_input_living_to = $('#living_to');
        var flex_input_living_from_old_value;
        var flex_input_living_to_old_value;
        if (flex_input_living_from.length) {
            flex_input_living_from.data('min-sqft', sqft_slider_values[0]);
            flex_input_living_from.data('max-sqft', sqft_slider_values[sqft_slider_values.length - 1]);
            flex_input_living_from_old_value = parseInt(flex_input_living_from.val().trim().replace(/\D/g, ''), 10);

            flex_input_living_from.on('blur', function() {
                var currentValue = jQuery(this).val().trim();
                currentValue = currentValue.replace(/\D/g, '');
                if (typeof currentValue === 'string' && currentValue.length === 0) {
                    currentValue = flex_input_living_from_old_value;
                } else {
                    currentValue = parseInt(currentValue, 10);
                }

                $(this).val(_.formatPrice(currentValue) +' '+word_translate.sqft);
            });
            flex_input_living_from.on('change', function() {
                var currentValue = jQuery(this).val().trim();
                currentValue = currentValue.replace(/\D/g, '');
                if (typeof currentValue === 'string' && currentValue.length === 0) {
                    currentValue = $(this).data('min-sqft');
                } else {
                    currentValue = parseInt(currentValue, 10);
                }
                if (currentValue < $(this).data('min-sqft')) {
                    currentValue = $(this).data('min-sqft');
                } else if (currentValue > $(this).data('max-sqft')) {
                    currentValue = $(this).data('max-sqft');
                }
                if (currentValue > parseInt(flex_input_living_to.val().trim().replace(/\D/g, ''), 10)) {
                    alert(word_translate.current_value_must_be_less_than_or_equal_to+' ' + parseInt(flex_input_living_to.val().trim().replace(/\D/g, ''), 10));
                    currentValue = $(this).data('min-sqft');
                } else {
                    $('#living_from').val(currentValue);
                    $('#idx_living_area_min').val(currentValue);
                    var x_val = sqft_slider_values.indexOf(currentValue);
                    var y_val = sqft_slider_values.indexOf(parseInt(flex_input_living_to.val().trim().replace(/\D/g, ''), 10));
                    flex_input_living_from_old_value = currentValue;
                    if (x_val !== -1 && y_val !== -1) {
                        $('#range-living').slider('values', [x_val, y_val]);
                    }
                    // do ajax
                    $('#idx_page').val(1);
                    flex_refresh_search();
                }
                $(this).val(_.formatPrice(currentValue) +' '+word_translate.sqft);
            });
        }
        if (flex_input_living_to.length) {
            flex_input_living_to.data('min-sqft', sqft_slider_values[0]);
            flex_input_living_to.data('max-sqft', sqft_slider_values[sqft_slider_values.length - 1]);
            flex_input_living_to_old_value = parseInt(flex_input_living_to.val().trim().replace(/\D/g, ''), 10);
            flex_input_living_to.on('blur', function() {
                var currentValue = jQuery(this).val().trim();
                currentValue = currentValue.replace(/\D/g, '');
                if (typeof currentValue === 'string' && currentValue.length === 0) {
                    currentValue = flex_input_living_to_old_value;
                } else {
                    currentValue = parseInt(currentValue, 10);
                }
                $(this).val(_.formatPrice(currentValue) + ' Sq.Ft.');
            });
            flex_input_living_to.on('change', function() {
                var currentValue = jQuery(this).val().trim();
                currentValue = currentValue.replace(/\D/g, '');
                if (typeof currentValue === 'string' && currentValue.length === 0) {
                    currentValue = $(this).data('max-sqft');
                } else {
                    currentValue = parseInt(currentValue, 10);
                }
                if (currentValue < $(this).data('min-sqft')) {
                    currentValue = $(this).data('min-sqft');
                } else if (currentValue > $(this).data('max-sqft')) {
                    currentValue = $(this).data('max-sqft');
                }
                if (currentValue < parseInt(flex_input_living_from.val().trim().replace(/\D/g, ''), 10)) {
                    alert(word_translate.current_value_must_be_less_than_or_equal_to+' ' + parseInt(flex_input_living_from.val().trim().replace(/\D/g, ''), 10));
                    currentValue = $(this).data('min-sqft');
                } else {
                    $('#living_to').val(currentValue);
                    $('#idx_living_area_max').val(currentValue);
                    var x_val = sqft_slider_values.indexOf(parseInt(flex_input_living_from.val().trim().replace(/\D/g, ''), 10));
                    var y_val = sqft_slider_values.indexOf(currentValue);
                    flex_input_living_to_old_value = currentValue;
                    if (x_val !== -1 && y_val !== -1) {
                        $('#range-living').slider('values', [x_val, y_val]);
                    }
                    // do ajax
                    $('#idx_page').val(1);
                    flex_refresh_search();
                }
                $(this).val(_.formatPrice(currentValue) +' '+word_translate.sqft);
            });
        }
        var flex_input_year_min = $('#year_from');
        var flex_input_year_max = $('#year_to');
        var flex_input_year_min_old_value;
        var flex_input_year_max_old_value;
        if (flex_input_year_min.length) {
            flex_input_year_min.data("min-year", year_built_slider_values[0]);
            flex_input_year_min.data("max-year", year_built_slider_values[year_built_slider_values.length - 1]);
            flex_input_year_min_old_value = parseInt(flex_input_year_min.val(), 10);
            flex_input_year_min.on('blur', function() {
                var currentValue = jQuery(this).val().trim();
                currentValue = currentValue.replace(/\D/g, '');
                if (typeof currentValue === 'string' && currentValue.length === 0) {
                    currentValue = flex_input_year_min_old_value;
                } else {
                    currentValue = parseInt(currentValue, 10);
                }
                $(this).val(currentValue);
            });
            flex_input_year_min.on('change', function() {
                var currentValue = jQuery(this).val().trim();
                currentValue = currentValue.replace(/\D/g, '');
                if (typeof currentValue === 'string' && currentValue.length === 0) {
                    currentValue = $(this).data('min-year');
                } else {
                    currentValue = parseInt(currentValue, 10);
                }
                if (currentValue < $(this).data('min-year')) {
                    currentValue = $(this).data('min-year');
                } else if (currentValue > $(this).data('max-year')) {
                    currentValue = $(this).data('max-year');
                }
                if (currentValue > parseInt(flex_input_year_max.val(), 10)) {
                    alert('current value must be less than or equal to ' + parseInt(flex_input_year_max.val(), 10));
                    currentValue = $(this).data('min-year');
                } else {
                    $('#year_from').val(currentValue);
                    $('#idx_min_year').val(currentValue);
                    var x_val = year_built_slider_values.indexOf(currentValue);
                    var y_val = year_built_slider_values.indexOf(parseInt(flex_input_year_max.val(), 10));
                    flex_input_year_min_old_value = currentValue;
                    $('#idx_page').val(1);
                    $('#range-year').slider('values', [x_val, y_val]);
                }
                $(this).val(currentValue);
            });
        }
        if (flex_input_year_max.length) {
            flex_input_year_max.data("min-year", year_built_slider_values[0]);
            flex_input_year_max.data("max-year", year_built_slider_values[year_built_slider_values.length - 1]);
            flex_input_year_max_old_value = parseInt(flex_input_year_max.val(), 10);
            flex_input_year_max.on('blur', function() {
                var currentValue = jQuery(this).val().trim();
                currentValue = currentValue.replace(/\D/g, '');
                if (typeof currentValue === 'string' && currentValue.length === 0) {
                    currentValue = flex_input_year_max_old_value;
                } else {
                    currentValue = parseInt(currentValue, 10);
                }
                $(this).val(currentValue);
            });
            flex_input_year_max.on('change', function() {
                var currentValue = jQuery(this).val().trim();
                currentValue = currentValue.replace(/\D/g, '');
                if (typeof currentValue === 'string' && currentValue.length === 0) {
                    currentValue = $(this).data('max-year');
                } else {
                    currentValue = parseInt(currentValue, 10);
                }
                if (currentValue < $(this).data('min-year')) {
                    currentValue = $(this).data('min-year');
                } else if (currentValue > $(this).data('max-year')) {
                    currentValue = $(this).data('max-year');
                }
                if (currentValue < parseInt(flex_input_year_min.val(), 10)) {
                    alert( word_translate.current_value_must_be_less_than_or_equal_to+' ' + parseInt(flex_input_year_min.val(), 10));
                    currentValue = $(this).data('max-year');
                } else {
                    $('#year_to').val(currentValue);
                    $('#idx_max_year').val(currentValue);
                    var x_val = year_built_slider_values.indexOf(parseInt(flex_input_year_min.val(), 10));
                    var y_val = year_built_slider_values.indexOf(currentValue);
                    flex_input_year_max_old_value = currentValue;
                    $('#idx_page').val(1);
                    $('#range-year').slider('values', [x_val, y_val]);
                }
                $(this).val(currentValue);
            });
        }
    });

    $(function() {
        $("#map-draw-cancel-tg").on("click", function() {

            $(".flex-map-controls-ct").show();
            $("#wrap-map-draw-actions").css("display", "none");
            $("#wrap-map").removeClass("mp-btn");

            drawingManager.setMap(null);
            autoMapSearch = true;

            // remove polygons
            if (polygons.length) {
                if (polygons.length > 1) {
                    polygons[0].setVisible(true);
                    polygons[1].setMap(null);
                    polygons.pop();
                } else {
                    polygons[0].setVisible(true);
                }
            }

            if (("" == $("#idx_keyword").val("")) && ("" == $("#idx_polygon").val(""))) {
                if (polygons.length) {
                    for (var i = 0, l = polygons.length; i < l; i++) {
                        polygons[i].setMap(null);
                    }
                    polygons.length = 0;
                }
            }


            // else {
            //   if (initPolygons.length) {
            //     var oldPolygon = initPolygons[0];
            //     console.dir(oldPolygon);
            //
            //     for(var i = 0, l = initPolygons.length; i < l; i++) {
            //       initPolygons[i].setMap(map);
            //       initPolygons[i].setVisible(true);
            //     }
            //     polygons = initPolygons;
            //     initPolygons.length = 0;
            //   }
            // }

            // if (initPolygons.length) {
            //   var oldPolygon = initPolygons[0];
            //   console.dir(oldPolygon);
            //
            //   for(var i = 0, l = initPolygons.length; i < l; i++) {
            //     initPolygons[i].setMap(map);
            //     initPolygons[i].setVisible(true);
            //   }
            //   polygons = initPolygons;
            //   initPolygons.length = 0;
            // }

            if (markers.length) {
                for (var i = 0, l = markers.length; i < l; i++) {
                    markers[i].setVisible(true);
                }
            }
        });

        $("#map-draw-apply-tg").on("click", function() {
            if (!polygons.length) {
                $(".flex-map-controls-ct").show();
                $("#wrap-map-draw-actions").css("display", "none");
                $("#wrap-map").removeClass("mp-btn");

                drawingManager.setMap(null);
                autoMapSearch = true;

                if (markers.length) {
                    for (var i = 0, l = markers.length; i < l; i++) {
                        markers[i].setVisible(true);
                    }
                }
                return;
            }

            mapDrawButton.classList.add("flex-map-is-drawing");
            // width: 112px; left: -121px;
            $(".flex-shown-map").html('Remove Boundaries');
            $(".flex-shown-map").css("width", "134px");
            $(".flex-shown-map").css("left", "-148px");

            drawingManager.setMap(null);
            autoMapSearch = false;

            $(".flex-map-controls-ct").show();
            $("#wrap-map-draw-actions").css("display", "none");
            $("#wrap-map").removeClass("mp-btn");

            var locations = [];

            if (polygons.length) {
                if (polygons.length > 1) {
                    polygons = [polygons[1]];
                }
                for (var i = 0, l = polygons.length; i < l; i++) {
                    polygons[i].set("editable", false);
                    var currentPath = polygons[i].getPath();
                    var currentPathArray = currentPath.getArray();
                    var geocodePath = [];

                    for (var j = 0, k = currentPathArray.length; j < k; j++) {
                        geocodePath.push({ lat: currentPathArray[j].lat(), lng: currentPathArray[j].lng() });
                    }

                    if (currentPathArray.length) {
                        geocodePath.push({ lat: currentPath.getAt(0).lat(), lng: currentPath.getAt(0).lng() });
                    }

                    locations[i] = geocodePath;
                }
            }

            if (locations.length) {
                if (markers.length) {
                    for (var i = 0, l = markers.length; i < l; i++) {
                        markers[i].setMap(null);
                    }
                }

                var tmpGeometry = [];

                for (var i = 0, l = locations[0].length; i < l; i++) {
                    tmpGeometry.push(locations[0][i].lat + ' ' + locations[0][i].lng);
                }

                var finalGeometry = 'POLYGON((' + tmpGeometry.join(",") + '))';

                $('#idx_page').val(1);
                //$("#autocomplete-ajax").val("");
                //$("#autocomplete-ajax-min").val("");
                $('#idx_polygon').val(finalGeometry);
                flex_refresh_search();
            }
        });
    });

    /******** MAP BEHAVIOR ********/
    // var map;
    var markers = [];
    var infoWindow;
    var mapButtonsWrapper;
    var mapZoomInButton;
    var mapZoomOutButton;
    var mapDrawButton;
    var mapDrawEraseButton;
    var userIsDrawing = false;
    var userHasMapFigure = false;
    var renderedMarkers = false;
    var mapIsVisible = false;
    var polyStrokeColor = '#31239a';
    var polyFillColor = '#31239a';
    var hashed_properties = [];
    var filtered_properties = [];
    var unique_properties = [];
    var infobox_content = [];
    var geocode;
    var poly;
    var move;
    var properties = [];
    var initMapLoaded = false;

    $(function() {
        /**************************************************************/
        $("#map-actions").on("click", "button", function() {
          $('#wrap-list-result').toggleClass('closed');
          $(this).addClass('hide').siblings().removeClass('hide');
            setTimeout(function () {
                google.maps.event.trigger(map, 'resize');
                setTimeout(function () {
                    google.maps.event.trigger(map, 'resize');
                }, 200);
            }, 100);
        });
        /**************************************************************/
    });

    function handleMapDrag() {
        var mapCenter = map.getCenter();
        var mapZoom = map.getZoom();
        var mapBounds = map.getBounds();
        var md5_bounds = [
            mapBounds.getNorthEast().lat(),
            mapBounds.getNorthEast().lng(),
            mapBounds.getSouthWest().lat(),
            mapBounds.getSouthWest().lng()
        ].join(" ");

        $("#idx_center").val(mapCenter.lat() + " " + mapCenter.lng());
        $("#idx_zoom").val(mapZoom);
        $("#idx_bounds").val(md5_bounds);

        if (md5_bounds != lastBounds) {
            if ( ("" == $("#idx_keyword").val()) && ("" == $("#idx_polygon").val()) ) {
                if (mapIsVisible === false) {
                    return;
                }

                flex_refresh_search();
            }
            lastBounds = md5_bounds;
        }
    }

    function initialize() {
        myLazyLoad = new LazyLoad({
            elements_selector: ".flex-lazy-image",
            callback_error: function(element){
              $(element).attr('src','https://idxboost.com/i/default_thumbnail.jpg').removeClass('error').addClass('loaded');
              $(element).attr('data-origin','https://idxboost.com/i/default_thumbnail.jpg');
            }
        });

        var defaultCenter = $("#idx_center").val();
        var defaultZoom = $("#idx_zoom").val();

        if ("" == defaultCenter) {
            defaultCenter = new google.maps.LatLng(25.789138662506385, -80.15144241556732);
        } else {
            var defaultCenterExp = defaultCenter.split(" ");
            defaultCenter = new google.maps.LatLng(parseFloat(defaultCenterExp[0]), parseFloat(defaultCenterExp[1]));
        }

        if ("" == defaultZoom) {
            defaultZoom = 14;
        } else {
            defaultZoom = parseInt(defaultZoom, 10);
        }

        map = new google.maps.Map(document.getElementById("code-map"), {
            center: defaultCenter,
            mapTypeId: google.maps.MapTypeId.ROADMAP,
            zoom: defaultZoom,
            disableDoubleClickZoom: true,
            scrollwheel: false,
            panControl: false,
            streetViewControl: false,
            disableDefaultUI: true,
            clickableIcons: false,
            zoomControl: true,
            zoomControlOptions: {
                position: google.maps.ControlPosition.RIGHT_BOTTOM
            }
        });

        $("#wrap-result").show();

        google.maps.event.addListenerOnce(map, "idle", function() {
            var mapCenter = map.getCenter();
            var mapZoom = map.getZoom();
            var mapBounds = map.getBounds();

            $("#idx_center").val(mapCenter.lat() + " " + mapCenter.lng());
            $("#idx_zoom").val(mapZoom);
            $("#idx_bounds").val([
                mapBounds.getNorthEast().lat(),
                mapBounds.getNorthEast().lng(),
                mapBounds.getSouthWest().lat(),
                mapBounds.getSouthWest().lng()
            ].join(" "));

            console.dir({
                center: [ mapCenter.lat(), mapCenter.lng() ],
                zoom: mapZoom,
                bounds: [
                    mapBounds.getNorthEast().lat(),
                    mapBounds.getNorthEast().lng(),
                    mapBounds.getSouthWest().lat(),
                    mapBounds.getSouthWest().lng()
                ]
            });

            if (false === mapNotLoaded) {
                mapNotLoaded = true;
                xhr_running = true;

                if ($("#flex-idx-search-form").length) {
                    flex_refresh_search();

                    if (false === initLoadMLSAnonymous) {
                        initLoadMLSAnonymous = true;
                        var anonMLS = localStorage.getItem('ib_anon_mls');

                        if (null !== anonMLS) {
                            console.log(anonMLS);

                            if (__flex_g_settings.anonymous === 'no') {
                                setTimeout(function() {
                                    $('html').addClass('modal_mobile');
                                    $('#modal_property_detail').addClass('active_modal');
                                    $("#modal_property_detail .detail-modal").html('<span class="ib-modal-property-loading">Loading property details...</span>');

                                    $.ajax({
                                        type: "POST",
                                        url: __flex_g_settings.ajaxUrl,
                                        data: { mlsNumber: anonMLS, action: "load_modal_property" },

                                        success: function (response) {
                                          $(document.body).addClass("modal-property-active");
                                          $("#modal_property_detail .detail-modal").html(response);
                                        },

                                        complete: function(){
                                          $('#full-main #clidxboost-data-loadMore-niche').trigger("click");
                                          loadFullSlider(".clidxboost-full-slider");
                                        }
                                    });
                                }, 1500);

                                localStorage.removeItem("ib_anon_mls");
                            }
                        }
                    }
                }
            }

            google.maps.event.addListener(map, "idle", _.debounce(handleMapDrag, 700));
        });

        /*
        google.maps.event.addListener(map, "zoom_changed", function() {
            var mapCenter = map.getCenter();
            var mapZoom = map.getZoom();
            var mapBounds = map.getBounds();


            $("#idx_center").val(mapCenter.lat() + " " + mapCenter.lng());
            $("#idx_zoom").val(mapZoom);
            $("#idx_bounds").val([
                mapBounds.getNorthEast().lat(),
                mapBounds.getNorthEast().lng(),
                mapBounds.getSouthWest().lat(),
                mapBounds.getSouthWest().lng()
            ].join(" "));

            if ((true === mapNotLoaded) && (true === autoMapSearch) && ("" == $("#idx_keyword").val()) && ("" == $("#idx_polygon").val())) {
                $('#idx_page').val(1);
                flex_refresh_search();
            }
        });
        */

        /*
        google.maps.event.addListener(map, "dragend", function() {
            var mapCenter = map.getCenter();
            var mapZoom = map.getZoom();
            var mapBounds = map.getBounds();


            $("#idx_center").val(mapCenter.lat() + " " + mapCenter.lng());
            $("#idx_zoom").val(mapZoom);
            $("#idx_bounds").val([
                mapBounds.getNorthEast().lat(),
                mapBounds.getNorthEast().lng(),
                mapBounds.getSouthWest().lat(),
                mapBounds.getSouthWest().lng()
            ].join(" "));

            if ((true === mapNotLoaded) && (true === autoMapSearch) && ("" == $("#idx_keyword").val()) && ("" == $("#idx_polygon").val())) {
                $('#idx_page').val(1);
                flex_refresh_search();
            }
        });
        */

        drawingManager = new google.maps.drawing.DrawingManager({
            drawingMode: google.maps.drawing.OverlayType.POLYGON,
            drawingControl: false,
            drawingControlOptions: {
                position: google.maps.ControlPosition.TOP_RIGHT,
                drawingModes: ["polygon"]
            },
            polygonOptions: {
                editable: false,
                strokeColor: "#31239a",
                fillOpacity: 0.1,
                strokeOpacity: 0.8,
                strokeWeight: 1,
                fillColor: "#31239a",
            }
        });

        drawingManager.setMap(null);

        google.maps.event.addListener(drawingManager, "overlaycomplete", function(event) {
            var newShape = event.overlay;
            newShape.type = event.type;

            polygons.push(newShape);

            // google.maps.event.addListener(newShape, "click", handleShapeClick(newShape, drawingManager));

            event.overlay.set("editable", false);
            drawingManager.setMap(null);
        });

        google.maps.event.addListenerOnce(map, 'tilesloaded', setupMapControls);
        /*
        var bounds = new google.maps.LatLngBounds();
        firstB = new google.maps.LatLng(25.761680, -80.19179);
        bounds.extend(firstB);
        map.fitBounds(bounds);
        */
    }

    function handleZoomInButton(event) {
        event.stopPropagation();
        event.preventDefault();

        if (typeof infoWindow !== 'undefined') {
            if (infoWindow.isOpen()) {
                infoWindow.close();
            }
        }

        if (userIsDrawing) {
            google.maps.event.clearListeners(map.getDiv(), "mousedown");
            google.maps.event.removeListener(move);
            stopDrawingMap();
            // remove polygon draw
            $('#idx_page').val(1);
            $('#idx_polygon').val('');
            flex_refresh_search();
        }
        var old_map_center = map.getCenter();
        map.setZoom(map.getZoom() + 1);
        map.setCenter(old_map_center);
    }

    function handleZoomOutButton(event) {
        event.stopPropagation();
        event.preventDefault();

        if (typeof infoWindow !== 'undefined') {
            if (infoWindow.isOpen()) {
                infoWindow.close();
            }
        }

        if (userIsDrawing) {
            google.maps.event.clearListeners(map.getDiv(), "mousedown");
            google.maps.event.removeListener(move);
            stopDrawingMap();
            // remove polygon draw
            $('#idx_page').val(1);
            $('#idx_polygon').val('');
            flex_refresh_search();
        }

        var old_map_center = map.getCenter();
        map.setZoom(map.getZoom() - 1);
        map.setCenter(old_map_center);
    }

    function handleDrawEraseButton(event) {
        event.stopPropagation();
        event.preventDefault();
        google.maps.event.clearListeners(map.getDiv(), "mousedown");
        google.maps.event.removeListener(move);
        stopDrawingMap();
        // remove polygon draw
        $('#idx_page').val(1);
        $('#idx_polygon').val('');
        flex_refresh_search();
        poly.setMap(null);
        removeMarkers();
        $(".flex-map-draw-erase").hide();
    }

    function handleDrawButton(event) {
        event.stopPropagation();
        event.preventDefault();

        if ($(event.target).hasClass("flex-map-is-drawing")) {
            mapDrawButton.classList.remove("flex-map-is-drawing");
            $(".flex-shown-map").html('Draw Your Map');
            $(".flex-shown-map").css("width", "112px");
            $(".flex-shown-map").css("left", "-121px");

            if (typeof infoWindow !== 'undefined') {
                if (infoWindow.isOpen()) {
                    infoWindow.close();
                }
            }

            autoMapSearch = true;

            // remove polygons
            if (polygons.length) {
                for (var i = 0, l = polygons.length; i < l; i++) {
                    polygons[i].setMap(null);
                }
                polygons.length = 0;
            }
            if ("" != $("idx_polygon").val()) {
                $('#idx_page').val(1);
                $('#idx_polygon').val('');
                flex_refresh_search();
                removeMarkers();
            }
            return;
        }

        if (typeof infoWindow !== 'undefined') {
            if (infoWindow.isOpen()) {
                infoWindow.close();
            }
        }

        // if there initially loaded polygons
        if (polygons.length) {
            for (var i = 0, l = polygons.length; i < l; i++) {
                polygons[i].setVisible(false);
            }
            // initPolygons = polygons;
            // if (polygons.length) {
            //   for(var i = 0, l = polygons.length; i < l; i++) {
            //     polygons[i].setMap(null);
            //   }
            //   polygons.length = 0;
            // }
        }

        $(".flex-map-controls-ct").hide();
        $("#wrap-map-draw-actions").css("display", "flex");
        $("#wrap-map").addClass("mp-btn");

        drawingManager.setMap(map);
        autoMapSearch = false;

        if (markers.length) {
            for (var i = 0, l = markers.length; i < l; i++) {
                markers[i].setVisible(false);
            }
        }

        /*
        if (this.classList.contains('flex-map-is-drawing')) {
            google.maps.event.clearListeners(map.getDiv(), "mousedown");
            google.maps.event.removeListener(move);
            stopDrawingMap();
            // remove polygon draw
            $('#idx_page').val(1);
            $('#idx_polygon').val('');
            flex_refresh_search();
            $(".flex-map-draw-erase").hide();
        } else {
            $(".flex-map-draw-erase").show();
            startDrawingMap();
            google.maps.event.addDomListener(map.getDiv(), "mousedown", handleMouseDown);
        }
        */
    }

    function stopDrawingMap() {
        map.setOptions({
            draggable: true,
            zoomControl: true
        });

        if (typeof infoWindow !== 'undefined') {
            if (infoWindow.isOpen()) {
                infoWindow.close();
            }
        }

        mapDrawButton.classList.remove("flex-map-is-drawing");
        $(".flex-shown-map").html('Draw Your Map');
        $(".flex-shown-map").css("width", "112px");
        $(".flex-shown-map").css("left", "-121px");

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
            fillOpacity: 0.1,
            strokeOpacity: 0.8,
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
            $('#idx_page').val(1);
            $('#idx_polygon').val(geometry);
            flex_refresh_search();
        } else {
            userHasMapFigure = false;
        }
        stopDrawingMap();
    }

    function handleMouseDown(event) {
        event.stopPropagation();
        event.preventDefault();

        // only left click to draw
        if (0 !== event.button) {
            google.maps.event.clearListeners(map.getDiv(), "mousedown");
            google.maps.event.removeListener(move);
            stopDrawingMap();
            $(".flex-map-draw-erase").hide();
            return;
        }

        handleMapDrawing();
    }

    function setupMapControls() {
        // setup buttons wrapper
        mapButtonsWrapper = document.createElement("div");
        mapButtonsWrapper.classList.add('flex-map-controls-ct');
        // setup zoom in button
        mapZoomInButton = document.createElement("div");
        mapZoomInButton.classList.add('flex-map-zoomIn');
        mapButtonsWrapper.appendChild(mapZoomInButton);
        // setup zoom out button
        mapZoomOutButton = document.createElement("div");
        mapZoomOutButton.classList.add('flex-map-zoomOut');
        mapButtonsWrapper.appendChild(mapZoomOutButton);
        // setup draw button
        mapDrawButton = document.createElement("div");
        mapDrawButton.innerHTML = '<span class="flex-shown-map">'+word_translate.draw_your_map+'</span>';
        mapDrawButton.classList.add('flex-map-draw');
        mapButtonsWrapper.appendChild(mapDrawButton);
        // set draw erase button
        mapDrawEraseButton = document.createElement("div");
        mapDrawEraseButton.classList.add('flex-map-draw-erase');
        mapButtonsWrapper.appendChild(mapDrawEraseButton);
        // setup listeners on buttons
        google.maps.event.addDomListener(mapZoomInButton, "click", handleZoomInButton);
        google.maps.event.addDomListener(mapZoomOutButton, "click", handleZoomOutButton);
        google.maps.event.addDomListener(mapDrawButton, "click", handleDrawButton);
        google.maps.event.addDomListener(mapDrawEraseButton, "click", handleDrawEraseButton);
        // push controls to google map canvas
        map.controls[google.maps.ControlPosition.TOP_RIGHT].push(mapButtonsWrapper);
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

    function setupMarkers(properties, dontReloadBounds) {
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
            maxWidth: 380,
            // enableEventPropagation: true,
            // pane: "floatPane"
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

        //google.maps.event.addDomListener(infoWindow, 'click', function() { alert('clicked!') });

        // reduce markers [first step]
        for (var i = 0, l = properties.length; i < l; i++) {
            row = properties[i];
            geocode = row.lat + ':' + row.lng;
            if (_.indexOf(hashed_properties, geocode) === -1) {
                hashed_properties.push(geocode);
                filtered_properties.push(row);
            }
        }
        // reduce markers [second step]
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

        centerBounds = new google.maps.LatLngBounds();

        for (i = 0; i < unique_properties.length; i++) {
            property = unique_properties[i];
            marker = new RichMarker({
                position: new google.maps.LatLng(property.item.lat, property.item.lng),
                map: map,
                flat: true,
                content: (property.group.length > 1) ? '<div class="dgt-richmarker-group"><strong>' + property.group.length + '</strong><span>Units</span></div>' : '<div class="dgt-richmarker-single"><strong>$' + _.formatShortPrice(property.item.price) + '</strong></div>',
                anchor: RichMarkerPosition.TOP
            });

            marker.geocode = property.item.lat + ':' + property.item.lng;

            bounds.extend(marker.position);
            markers.push(marker);

            centerBounds.extend(marker.position);

            // setup listeners for markers
            google.maps.event.addListener(marker, "click", handleMarkerClick(marker, property, map));
            google.maps.event.addListener(marker, "mouseover", handleMarkerMouseOver(marker));
            google.maps.event.addListener(marker, "mouseout", handleMarkerMouseOut(marker));
        }

        if ((false === autoMapSearch) || ("" != $("#idx_keyword").val()) || ("" != $("#idx_polygon").val())) {
            if (dontReloadBounds === false) {
                if (  ("" != $("#idx_keyword").val()) || ("" != $("#idx_polygon").val())  ) {
                    map.fitBounds(bounds);
                }
            }
        }
        // map.fitBounds(bounds);

        /*
        if (first_load_map === false) {
            if (typeof map !== 'undefined') {
                map.setZoom(14);
                map.setCenter(new google.maps.LatLng(25.783253667493966, -80.14746014041748));
            }
            first_load_map = true;
        } else {
            if (typeof map !== 'undefined') {
                map.fitBounds(bounds);
            }
        }
        */
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
                    infobox_content.push('<h2 title="' + property_group.address_short.replace(/ , /, ', ') + '"><span>' + property_group.address_short.replace(/ , /, ', ') + '</span></h2>');
                    infobox_content.push('<ul>');
                    infobox_content.push('<li class="address"><span>' + property_group.address_large.replace(/ , /, ', ') + '</span></li>');
                    infobox_content.push('<li class="price">$' + _.formatPrice(property_group.price) + '</li>');
                    var textpropertygroupbed= word_translate.beds;
                    var textpropertygroupbath=word_translate.baths;
                    if (property_group.bed>1) { textpropertygroupbed=word_translate.beds; }else{textpropertygroupbed=word_translate.bed; }
                    if (property_group.bath>1) {textpropertygroupbath=word_translate.baths;}else{textpropertygroupbath=word_translate.bath;}

                    infobox_content.push('<li class="beds"><b>' + property_group.bed + '</b> <span> '+textpropertygroupbed+'</span></li>');
                    infobox_content.push('<li class="baths"><b>' + property_group.bath + '</b> <span> '+textpropertygroupbath+'</span></li>');
                    infobox_content.push('<li class="living-size"> <span>' + _.formatPrice(property_group.sqft) + '</span> Sq.Ft.<span>(' + property_group.living_size_m2 + ' m2)</span></li>');
                    infobox_content.push('<li class="price-sf"><span>$' + property_group.price_sqft + ' </span>/ '+word_translate.sqft+'<span>($' + property_group.price_sqft_m2 + ' m2)</span></li>');
                    infobox_content.push('</ul>');
                    infobox_content.push('<div class="mapviwe-img">');
                    infobox_content.push('<img title="' + property_group.address_short + ', ' + property_group.address_large + '" alt="' + property_group.address_short + ', ' + property_group.address_large + '" src="' + property_group.gallery[0] + '">');
                    infobox_content.push('</div>');
                    if (property_group.status == 1) {
                        infobox_content.push('<a class="ib-load-property-iw" data-mls="' + property_group.mls_num + '" href="' + flex_idx_search_params.propertyDetailPermalink + '/' + property_group.slug + '" title="' + property_group.address_short.replace(/ # /, ' #') + ', ' + property_group.address_large.replace(/ , /, ', ') + '">' + property_group.address_short.replace(/ # /, ' #') + ', ' + property_group.address_large.replace(/ , /, ', ') + '</a>');
                    } else {
                        infobox_content.push('<a class="ib-load-property-iw" data-mls="' + property_group.mls_num + '" href="' + flex_idx_search_params.propertyDetailPermalink + '/pending-' + property_group.slug + '" title="' + property_group.address_short.replace(/ # /, ' #') + ', ' + property_group.address_large.replace(/ , /, ', ') + '">' + property_group.address_short.replace(/ # /, ' #') + ', ' + property_group.address_large.replace(/ , /, ', ') + '</a>');
                    }
                    infobox_content.push('</div>');
                }
                infobox_content.push('</div>');
                infobox_content.push('</div>');
            } else {
                // single
                infobox_content.push('<div class="mapview-container">');
                infobox_content.push('<div class="mapviwe-header">');
                infobox_content.push('<h2>' + property.item.heading + '</h2>');
                infobox_content.push('<button class="closeInfo"><span>'+word_translate.close+'</span></button>');
                infobox_content.push('</div>');
                infobox_content.push('<div class="mapviwe-body">');
                infobox_content.push('<div class="mapviwe-item">');
                infobox_content.push('<h2 title="' + property.item.address_short.replace(/ , /, ', ') + '"><span>' + property.item.address_short.replace(/ , /, ', ') + '</span></h2>');
                infobox_content.push('<ul>');
                infobox_content.push('<li class="address"><span>' + property.item.address_large.replace(/ , /, ', ') + '</span></li>');
                infobox_content.push('<li class="price">$' + _.formatPrice(property.item.price) + '</li>');
                var textpropertyitembed=word_translate.beds; var textpropertyitembath=word_translate.baths;
                if (property.item.bed>1) { textpropertyitembed= word_translate.beds; }else{ textpropertyitembed=word_translate.bed; }
                if (property.item.bath>1) { textpropertyitembath=word_translate.baths; }else{ textpropertyitembath=word_translate.bath; }
                infobox_content.push('<li class="beds"><b>' + property.item.bed + '</b> <span> '+textpropertyitembed+'</span></li>');
                infobox_content.push('<li class="baths"><b>' + property.item.bath + '</b> <span> '+textpropertyitembath+'</span></li>');
                infobox_content.push('<li class="living-size"> <span>' + _.formatPrice(property.item.sqft) + '</span> '+word_translate.sqft+'<span>(' + property.item.living_size_m2 + ' m2)</span></li>');
                infobox_content.push('<li class="price-sf"><span>$' + property.item.price_sqft + ' </span>/ '+word_translate.sqft+'<span>($' + property.item.price_sqft_m2 + ' m2)</span></li>');
                infobox_content.push('</ul>');
                infobox_content.push('<div class="mapviwe-img">');
                infobox_content.push('<img title="' + property.item.address_short + ', ' + property.item.address_large + '" alt="' + property.item.address_short + ', ' + property.item.address_large + '" src="' + property.item.gallery[0] + '">');
                infobox_content.push('</div>');
                if (property.item.status == 1) {
                    infobox_content.push('<a class="ib-load-property-iw" data-mls="' + property.item.mls_num + '" href="' + flex_idx_search_params.propertyDetailPermalink + '/' + property.item.slug + '" title="' + property.item.address_short.replace(/ # /, ' #') + ', ' + property.item.address_large.replace(/ , /, ', ') + '">' + property.item.address_short + ', ' + property.item.address_large.replace(/ # /, ' #') + '</a>');
                } else {
                    infobox_content.push('<a class="ib-load-property-iw" data-mls="' + property.item.mls_num + '" href="' + flex_idx_search_params.propertyDetailPermalink + '/pending-' + property.item.slug + '" title="' + property.item.address_short.replace(/ # /, ' #') + ', ' + property.item.address_large.replace(/ , /, ', ') + '">' + property.item.address_short + ', ' + property.item.address_large.replace(/ # /, ' #') + '</a>');
                }
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
    if (null !== document.getElementById('code-map')) {
        google.maps.event.addDomListener(window, 'load', initialize);
    }
    $(function() {
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
                        // map.fitBounds(bounds);
                    } else {
                        map.setCenter(map_center);
                        map.setZoom(map_zoom);
                    }
                }, 100);
            } else {
                mapIsVisible = false;
            }
        });

        /**  @todo benjamin **/
        /*Para mostrar la propiedad en el mapa*/
        $("#result-search").on("mouseover", ".propertie", function(event) {
            return;
            console.log('ok');
            var geocode = $(this).data("geocode"),
                i,
                marker;
            for (i = 0; i < markers.length; i++) {
                if (markers[i].geocode === geocode) {
                    marker = markers[i];
                    break;
                }
            }
            if (typeof marker !== 'undefined') {
                map.setCenter(marker.position);
                map.setZoom(16);
                google.maps.event.trigger(marker, "mouseover");
                google.maps.event.trigger(marker, "click");
            }
        });
    });
})(jQuery);
(function($) {
    $(function() {
        $(".allf-ss").on("click", function() {
            $("#flex_save_search_btn").click();
        });

        $(".iboost-alert-change-interval:eq(0)").change();
        $(document).on("click", ".flex-slider-prev", function(event) {
            event.stopPropagation();
            var node = $(this).prev().find('li.flex-slider-current');
            var index = node.index();
            var total = $(this).prev().find('li').length;
            index = (index === 0) ? (total - 1) : (index - 1);
            $(this).prev().find('li').removeClass('flex-slider-current');
            $(this).prev().find('li').addClass('flex-slider-item-hidden');
            $(this).prev().find('li').eq(index).removeClass('flex-slider-item-hidden').addClass('flex-slider-current');
            if (typeof myLazyLoad !== "undefined") { myLazyLoad.update(); }
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
            if (typeof myLazyLoad !== "undefined") { myLazyLoad.update(); }
        });
        $("#hide_flex_alerts_msg").on("click", function() {
            $(this).parent().remove();
            // set cookie
            Cookies.set('flex_hide_alert_message', '1');
        });
        if (typeof Cookies.get('flex_hide_alert_message') === 'undefined') {
            $("#box_flex_alerts_msg").show();
        }
        if (window.location.hash == "#advanced") {
            setTimeout(function() {
                $(".f-as-trigger").click();
            }, 1000);
        }

        /*** FUNCÍON PARA AGREGAR COMPORTAMIENTO DE SISTEMA SEGUN LA RESULUCIÓN DE SU CONTENEDOR GENERAL ****
        function hackResize(wrapContentPage){
          //Nota: lo primero que hay que hacer es obtener el ancho del dispositivo, de esa forma podemos hacer una comparación con el ancho del contenedor del plugin y colocar el hack
          var $widthPage = $('body').width(); //Obtenemos el ancho del dispositivo
          var $widthWrapContent = wrapContentPage.width(); //Obtenemos el ancho del contenedor

          if(! /Android|webOS|iPhone|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) ) {
            setTimeout(function(){

              if($widthWrapContent < $widthPage){
                $('body').addClass('hack');

                if($widthWrapContent > 899 && $widthWrapContent < 1300){
                  $('body').removeClass('w-768 w-640 w-480').addClass('w-1024');
                }else if($widthWrapContent > 699 && $widthWrapContent < 900){
                  $('body').removeClass('w-1024 w-640 w-480').addClass('w-768');
                }else if($widthWrapContent > 499 && $widthWrapContent < 700){
                  $('body').removeClass('w-1024 w-768 w-480').addClass('w-640');
                }else if($widthWrapContent < 500){
                  $('body').removeClass('w-1024 w-768 w-640').addClass('w-480');
                }

              }else{
                $('body').removeClass('hack w-1024 w-768 w-640 w-480');
              }
            }, 300);
          }
        }

        var $wrapContentPage = $(".wrap-page-idx");
        if ($wrapContentPage.length) {
          hackResize($wrapContentPage);
          $(window).resize(function() {
            hackResize($wrapContentPage);
          });
        }*/

        var $iconSelect = $('#filter-views');
        if ($iconSelect.length) {
          var $widthVentana = $(window).width();
          var $selectItem = $iconSelect.find('option:selected').val();
          if ($widthVentana >= 768) {
            $iconSelect.removeClass($selectItem);
          } else if ($widthVentana < 768) {
            $iconSelect.addClass($selectItem);
          }
        }

    });
})(jQuery);
