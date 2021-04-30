var myLazyLoad;
var map;

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
    var $cuerpo = $("body");
    var $ventana = $(window);
    var $viewFilter;
    var $wrapListResult = $('#wrap-list-result');

    function flex_encode_keyword_string(input) {
        return input.replace(/\s/g, "~").replace(/\#/g, ":").replace(/\//g, "_").replace(/\&/g, ";");
    }

    function flex_decode_keyword_string(input) {
        return input.replace(/\~/g, " ").replace(/\:/g, "#").replace(/\_/g, "/").replace(/\;/g, "&");
    }

    function scrollFixed(conditional) {
        var $conditional = conditional;
        var $element = $($conditional + ".fixed-box");
        var $offset = $element.offset();
        var $positionYelement = $offset.top;
        $ventana.on("scroll", function() {
            var $scrollSize = $ventana.scrollTop();
            if ($scrollSize >= $positionYelement) {
                $cuerpo.addClass('fixed-active');
            } else {
                $cuerpo.removeClass('fixed-active');
            }
        });
    }

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
        if (xhr_running === false) {
            return;
        }
        var form_data = $("#flex-idx-search-form").serialize();
        if (mapIsVisible === false) {
            $("#flex-spinner-load").fadeIn();
            $("#wrap-result").hide();
        }
        $('#filter-views ul li.active').click();
        // xhr_running = true;
        $.ajax({
            url: flex_idx_search_params.ajaxUrl,
            method: "POST",
            data: form_data,
            dataType: "json",
            success: function(response) {
                $("html, body").animate({
                    scrollTop: 0
                }, 700);
                var items = response.items;
                var listingHTML = [];
                var paginationHTML = [];
                var paging = response.paging;
                var search_labels = response.search_labels;
                var labelPricemax='',labelPrice='',labelBed='',labelBath='',labelPriceTemp='', labelBedTemp='', labelBathTemp='', labelPricemaxTemp=''; 

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

                // xhr_running = false;
                $('#properties-found').html('<span>' + _.formatShortPrice(response.total) + '</span> '+word_translate.properties);
                $('#fs_inner_c').html(_.formatShortPrice(response.total));
                $('#info-subfilters').html('Showing ' + paging.offset.start +' '+word_translate.to+' ' + paging.offset.end +' '+word_translate.of+' ' + _.formatPrice(response.total) +' '+word_translate.properties+'.');
                // $('#title-subfilters').html(response.heading.property_type + " in Miami, FL  from " + response.heading.price.min + " to " + response.heading.price.max);
                $('#title-subfilters').html(response.keyword +' '+word_translate.from+' '+ response.heading.price.min +' '+word_translate.to+' '+ response.heading.price.max);
                for (var i = 0, l = items.length; i < l; i++) {
                    var item = response.items[i];
                    var al = item.address_large.split(", ");
                    var st = al[1].replace(/[\d\s]/g, "");
                    // var final_address = item.address_short + ", " + al[0] + ", " + st;
                    var final_address = item.address_short.replace(/# /, "#") + ", " + al[0] + ", " + st;
                    var final_address_parceada = item.address_short.replace(/# /, "#") + "<span> " + al[0] + ", " + st+"</span>";
                    var final_address_parceada_new = " <span>"+ item.address_short.replace(/# /, "#") +", " + al[0] + ", " + al[1] + "</span>";

                    listingHTML.push('<li data-geocode="' + item.lat + ':' + item.lng + '" data-class-id="' + item.class_id + '" data-mls="' + item.mls_num + '" data-address="' + item.address_short + '" class="propertie">');
                    if (item.status == 1 && item.recently_listed === "yes") {
                        listingHTML.push('<div class="flex-property-new-listing">'+word_translate.new_listing+'!</div>');
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
                    var textitembed='Beds';
                    var textitembath='Baths';
                    if (item.bed>1) {textitembed='Beds';}else{textitembed='Bed';}
                    if (item.bath>1) {textitembath='Baths';}else{textitembath='Bath';}

                    listingHTML.push('<li class="beds">' + item.bed + ' <span>'+textitembed+' </span></li>');
                    if (item.baths_half > 0) {
                        listingHTML.push('<li class="baths">' + item.bath + '.5 <span>'+textitembath+' </span></li>');
                    } else {
                        listingHTML.push('<li class="baths">' + item.bath + ' <span>'+textitembath+' </span></li>');
                    }
                    listingHTML.push('<li class="living-size"> <span>' + _.formatPrice(item.sqft) + '</span>Sq.Ft. <span>(' + item.living_size_m2 + ' m2)</span></li>');
                    listingHTML.push('<li class="price-sf"><span>$' + item.price_sqft + ' </span>/ Sq.Ft.<span>($' + item.price_sqft_m2 + ' m2)</span></li>');
                    if (item.development !== '') {
                        listingHTML.push('<li class="development"><span>' + item.development + '</span></li>');
                    } else if (item.complex !== '') {
                        listingHTML.push('<li class="development"><span>' + item.complex + '</span></li>');
                    } else {
                        listingHTML.push('<li class="development"><span>' + item.subdivision + '</span></li>');
                    }
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
                            listingHTML.push('<a href="' + flex_idx_search_params.propertyDetailPermalink + '/' + item.slug + '" class="view-detail">'+final_address_parceada_new+'</a>');
                        } else {
                            listingHTML.push('<a href="' + flex_idx_search_params.propertyDetailPermalink + '/' + item.slug + '" class="view-detail">'+final_address_parceada_new+'</a>');
                        }
                    } else {
                        if (item.is_favorite) {
                            listingHTML.push('<a href="' + flex_idx_search_params.propertyDetailPermalink + '/pending-' + item.slug + '" class="view-detail">'+final_address_parceada_new+'</a>');
                        } else {
                            listingHTML.push('<a href="' + flex_idx_search_params.propertyDetailPermalink + '/pending-' + item.slug + '" class="view-detail">'+final_address_parceada_new+'</a>');
                        }
                    }

                    listingHTML.push('</li>');
                }
                $('#result-search').html(listingHTML.join(""));
                if (paging.pages > 1) {
                    paginationHTML.push('<span id="indicator">Pag ' + paging.current + ' of ' + _.formatPrice(paging.pages) + '</span>');
                    if (paging.prev_page && paging.pages > 1) {
                        paginationHTML.push('<a href="#" data-page="1" id="firstp" class="ad visible">');
                        paginationHTML.push('<span class="clidxboost-icon-arrow-select"></span>');
                        paginationHTML.push('<span class="clidxboost-icon-arrow-select"></span>');
                        paginationHTML.push('<span>First page</span>');
                        paginationHTML.push('</a>');
                    }
                    if (paging.prev_page) {
                        paginationHTML.push('<a href="#" data-page="' + (paging.current - 1) + '" id="prevn" class="arrow clidxboost-icon-arrow-select prevn visible">');
                        paginationHTML.push('<span>Previous page</span>');
                        paginationHTML.push('</a>');
                    }
                    paginationHTML.push('<ul id="principal-nav">');
                    for (var i = 0, l = paging.range.length; i < l; i++) {
                        var loopPage = paging.range[i];
                        // if (i <= 3) {
                        if (paging.current === loopPage) {
                            paginationHTML.push('<li class="active"><a href="#" data-page="' + loopPage + '">' + loopPage + '</a></li>');
                        } else {
                            paginationHTML.push('<li><a href="#" data-page="' + loopPage + '">' + loopPage + '</a></li>');
                        }
                        // }
                    }
                    paginationHTML.push('</ul>');
                    if (paging.next_page) {
                        paginationHTML.push('<a href="#" data-page="' + (paging.current + 1) + '" id="nextn" class="arrow clidxboost-icon-arrow-select nextn visible">');
                        paginationHTML.push('<span>Next page</span>');
                        paginationHTML.push('</a>');
                    }
                    if (paging.next_page && paging.pages > 1) {
                        paginationHTML.push('<a href="#" data-page="' + paging.pages + '" id="lastp" class="ad visible">');
                        paginationHTML.push('<span class="clidxboost-icon-arrow-select"></span>');
                        paginationHTML.push('<span class="clidxboost-icon-arrow-select"></span>');
                        paginationHTML.push('<span>Last page</span>');
                        paginationHTML.push('</a>');
                    }
                }
                if (mapIsVisible === false) {
                    $("#flex-spinner-load").hide();
                    $("#wrap-result").show();
                }
                $('#nav-results').html(paginationHTML.join(""));
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
                setupMarkers(map_items);
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
                            map.fitBounds(bounds);
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
    $(function() {
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
            $viewFilter.on('change', 'select', function() {
                switch ($(this).find('option:selected').val()) {
                    case 'grid':
                        $viewFilter.removeClass('list map').addClass('grid');
                        $wrapResult.removeClass('view-list view-map').addClass('view-grid');
                        $cuerpo.removeClass('view-list view-map');
                        $(".open-map").removeClass("hide");
                        $(".close-map").addClass("hide");
                        //$("#wrap-list-result").css('display', 'block');
                        $("#idx_view").val("grid");
                        if (typeof myLazyLoad !== "undefined") { myLazyLoad.update(); }
                        break
                    case 'list':
                        $viewFilter.removeClass('grid map').addClass('list');
                        $wrapResult.removeClass('view-grid view-map').addClass('view-list');
                        $cuerpo.addClass('view-list').removeClass('view-map');
                        $(".open-map").removeClass("hide");
                        $(".close-map").addClass("hide");
                        //$("#wrap-list-result").css('display', 'block');
                        $("#idx_view").val("list");
                        break
                    case 'map':
                        $viewFilter.removeClass('list grid').addClass('map');
                        $wrapResult.removeClass('view-list view-grid').addClass('view-map');
                        $cuerpo.removeClass('view-list').addClass('view-map');
                        $("#idx_view").val("map");
                        console.log('trigger map resize');
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
            $viewFilter.on('click', 'li', function() {
                $(this).addClass('active').siblings().removeClass('active');
                switch ($(this).attr('class').split(' ')[0]) {
                    case 'grid':
                        $wrapResult.removeClass('view-list view-map').addClass('view-grid');
                        $cuerpo.removeClass('view-list view-map');
                        scrollResultados(false);
                        $(".open-map").removeClass("hide");
                        $(".close-map").addClass("hide");
                        //$("#wrap-list-result").css('display', 'block');
                        if (typeof myLazyLoad !== "undefined") { myLazyLoad.update(); }
                        $("#idx_view").val("grid");
                        break
                    case 'list':
                        $wrapResult.removeClass('view-grid view-map').addClass('view-list');
                        $cuerpo.addClass('view-list').removeClass('view-map');
                        scrollResultados(false);
                        $(".open-map").removeClass("hide");
                        $(".close-map").addClass("hide");
                        //$("#wrap-list-result").css('display', 'block');
                        $("#idx_view").val("list");
                        break
                    case 'map':
                        $wrapResult.removeClass('view-list view-grid').addClass('view-map');
                        $cuerpo.removeClass('view-list').addClass('view-map');
                        scrollResultados(true);
                        // showFullMap();
                        $("#idx_view").val("map");
                        google.maps.event.trigger(map, "resize");
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
        /*var $citiesList = $('#cities-list');
        if ($citiesList.length) {
            $ventana.on('resize', function() {
                if ($citiesList.hasClass('ps-container')) {
                    $citiesList.perfectScrollbar('update');
                }
            });
        };*/

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
                        //console.log('no se hizo click en "All filters"');
                        return;
                    } else {
                        $liClicked.toggleClass('active').siblings().removeClass('active'); // se hizo click en 'All Filter', activo su flecha
                    }
                } else {
                    //console.log('si hay vinculación');
                    $liClicked.toggleClass('active').siblings().removeClass('active'); // activo su flecha, xq si hay vinculación y continuo.. apareciendo el mini filter.
                    //return;
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
                        //if ($wrapFilters.width() <= 768) {
                        if ($wrapFilters.width() <= 959) {
                            //$cuerpo.toggleClass('fixed');
                            $('html').toggleClass('fixed');
                            // Scrolleo si es necesario.
                            /*
                             var $SetScrollTop = $wrapFilters.position().top - Number($wrapFilters.css('margin-top').replace('px', ''));
                             if ($ventana.scrollTop() !== $SetScrollTop) {
                             $htmlcuerpo.animate({scrollTop:$SetScrollTop}, 800);
                             }

                             $htmlcuerpo.animate({scrollTop:0}, 800);
                             */
                            // Creo el scroll interno invisible del 'all filter'.
                            if (!$allFilters.hasClass('ps-container')) {
                                setTimeout(function() {
                                    $allFilters.perfectScrollbar({
                                        suppressScrollX: true,
                                        minScrollbarLength: '42'
                                    });
                                }, ((Number($allFilters.css('transition-duration').replace('s', '')) * 1000) * 2));
                            }
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
                                console.log('Widt all filter: ' + $allFilters.width() + ' | position left clicked: ' + $liClicked.position().left + ' | Li clicked widht: ' + $liClicked.width());
                                $allFilters.css({
                                    'top': $wrapFilters.outerHeight() + 'px',
                                    //'left': ($allFilters.width() - ($liClicked.position().left + $liClicked.width())) + 'px'
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
                        /*if ($cuerpo.hasClass('fixed')) {
                         $cuerpo.removeClass('fixed');
                         }*/
                        if ($('html').hasClass('fixed')) {
                            $('html').removeClass('fixed');
                        }
                        // Destruyo el 'perfect scroll bar' creado cuando era modal 'all filter'
                        if ($allFilters.hasClass('ps-container')) {
                            $allFilters.perfectScrollbar('destroy');
                        }
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
            /*
            $theFilters.find('.mini-search, .save').on('click', function() {
                if ($allFilters.hasClass('visible')) {
                    $theFilters.find('.active button').trigger('click');
                }
            });
            */
        }
        if ($("#wrap-filters").length) {
            scrollFixed('#wrap-filters');
        }
        /*
        $("#autocomplete-ajax").on("click", function() {
            $('#filters > li').removeClass('active');
            $('#all-filters').removeClass('visible');
            $('#cities-list').appendTo("#autocomplete-dropdown-ct")
        });
        */
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
                minLength: 3,
                select: function(event, ui) {
                    var val_exp = ui.item.id.split(/\|/);
                    var keywordValue = val_exp[0];
                    var keywordType = val_exp[1];
                    // var keywordFinalValue = flex_encode_keyword_string(keywordValue) + "." + keywordType;
                    var keywordFinalValue = encodeURIComponent(keywordValue + "|" + keywordType);
                    // $('#idx_keyword').val(ui.item.id);
                    $('#idx_keyword').val(keywordFinalValue);
                    // console.log('changing val 1');
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
            flex_autocomplete_inner.on({
                focus: function() {
                    if ($(this).val() == "") {
                        // $('#cities-list').appendTo("#autocomplete-dropdown-ct");
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
                        // do ajax
                        flex_refresh_search();
                    }
                },
                click: function(event) {
                    event.stopPropagation();
                    if ($(this).val() == "") {
                        // $('#cities-list').appendTo("#autocomplete-dropdown-ct");
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
                select: function(event, ui) {
                    var val_exp = ui.item.id.split(/\|/);
                    var keywordValue = val_exp[0];
                    var keywordType = val_exp[1];
                    // var keywordFinalValue = flex_encode_keyword_string(keywordValue) + "." + keywordType;
                    var keywordFinalValue = encodeURIComponent(keywordValue + "|" + keywordType);
                    // $('#idx_keyword').val(ui.item.id);
                    $('#idx_keyword').val(keywordFinalValue);
                    // console.log('changing val 2');
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
        $("#flex_search_keyword_form").on("submit", function(event) {
            event.preventDefault();
            var currentValue = flex_autocomplete.val().trim();
            if (!currentValue.length) {
                return;
            }
            if (/^[\d+]{5}$/.test(currentValue)) { // zip code
                $('#idx_keyword').val(currentValue + "|zip");
                flex_autocomplete.val(currentValue + " (Zip)");
                flex_autocomplete_inner.val(currentValue + " (Zip)");
                // do ajax
                flex_refresh_search();
            } else if (($.inArray(currentValue, flex_idx_autocomplete_cities)) > -1) {
                $('#idx_keyword').val(currentValue + "|city");
                flex_autocomplete.val(currentValue + " (City)");
                flex_autocomplete_inner.val(currentValue + " (City)");
                // do ajax
                flex_refresh_search();;
            }
        });
        $("#autocomplete-ajax").on("keyup", function(event) {
            if (event.which === 13) {
                var currentValue = $(this).val().trim();
                if (!currentValue.length) {
                    return;
                }
                if (/^[\d+]{5}$/.test(currentValue)) { // zip code
                    $('#idx_keyword').val(currentValue + "|zip");
                    flex_autocomplete.val(currentValue + " (Zip)");
                    flex_autocomplete_inner.val(currentValue + " (Zip)");
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
                        flex_autocomplete.val(currentValue + " (Zip)");
                        flex_autocomplete_inner.val(currentValue + " (Zip)");
                        currentValue = flex_idx_autocomplete_cities[inArrayCities];
                        $('#idx_keyword').val(currentValue + "|city");
                        flex_autocomplete.val(currentValue + " (City)");
                        flex_autocomplete_inner.val(currentValue + " (City)");
                        // do ajax
                        flex_refresh_search();
                    }
                }
            }
        });
        $("#autocomplete-ajax-min").on("keyup", function(event) {
            if (event.which === 13) {
                var currentValue = $(this).val().trim();
                if (!currentValue.length) {
                    return;
                }
                if (/^[\d+]{5}$/.test(currentValue)) { // zip code
                    $('#idx_keyword').val(currentValue + "|zip");
                    flex_autocomplete.val(currentValue + " (Zip)");
                    flex_autocomplete_inner.val(currentValue + " (Zip)");
                    // do ajax
                    flex_refresh_search();
                } else {
                    var check_flex_idx_single_autocomplete_cities = [];
                    currentValue = currentValue.toLowerCase();
                    for (var i = 0, l = flex_idx_autocomplete_cities.length; i < l; i++) {
                        check_flex_idx_single_autocomplete_cities[i] = flex_idx_autocomplete_cities[i].toLowerCase();
                    }
                    var inArrayCities = $.inArray(currentValue, check_flex_idx_single_autocomplete_cities);
                    console.log(inArrayCities);
                    if (inArrayCities > -1) {
                        currentValue = flex_idx_autocomplete_cities[inArrayCities];
                        $('#idx_keyword').val(currentValue + "|city");
                        flex_autocomplete.val(currentValue + " (City)");
                        flex_autocomplete_inner.val(currentValue + " (City)");
                        // do ajax
                        flex_refresh_search();
                    }
                }
            }
        });
        $("#submit-ms").on("click", function() {
            var currentValue = flex_autocomplete.val().trim();
            if (!currentValue.length) {
                return;
            }
            if (/^[\d+]{5}$/.test(currentValue)) { // zip code
                $('#idx_keyword').val(currentValue + "|zip");
                flex_autocomplete.val(currentValue + " (Zip)");
                flex_autocomplete_inner.val(currentValue + " (Zip)");
                // do ajax
                flex_refresh_search();
            } else if (($.inArray(currentValue, flex_idx_autocomplete_cities)) > -1) {
                $('#idx_keyword').val(currentValue + "|city");
                flex_autocomplete.val(currentValue + " (City)");
                flex_autocomplete_inner.val(currentValue + " (City)");
                // do ajax
                flex_refresh_search();;
            }
        });
        $("#submit-ms-min").on("click", function() {
            var currentValue = flex_autocomplete_inner.val().trim();
            if (!currentValue.length) {
                return;
            }
            if (/^[\d+]{5}$/.test(currentValue)) { // zip code
                $('#idx_keyword').val(currentValue + "|zip");
                flex_autocomplete.val(currentValue + " (Zip)");
                flex_autocomplete_inner.val(currentValue + " (Zip)");
                // do ajax
                flex_refresh_search();
            } else if (($.inArray(currentValue, flex_idx_autocomplete_cities)) > -1) {
                $('#idx_keyword').val(currentValue + "|city");
                flex_autocomplete.val(currentValue + " (City)");
                flex_autocomplete_inner.val(currentValue + " (City)");
                // do ajax
                flex_refresh_search();;
            }
        });
        // handle cities list
        $(document.body).on("click", function() {
            $('#cities-list').appendTo('#cities-list-wrap');
        });
        $("#cities-list").on("click", function(event) {
            event.stopPropagation();
        });
        $('#cities-list').on("click", "li", function() {
            var label = $(this).html();
            var value = $(this).data('slug');
            flex_autocomplete.val(label + " (City)");
            flex_autocomplete_inner.val(label + " (City)");
            $('#idx_keyword').val(value);
            $('#cities-list').appendTo('#cities-list-wrap');
            // console.log('changing val 3');
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
                //var name = prompt('Please enter a title to identify your custom search.', '');
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
                            //active_modal($('#modal_search_saved'));
                            /*setTimeout(function() {
                                $('#modal_properties_send').find('.close').click();
                            }, 2000);
                            */
                            $('#modal_save_search').removeClass('active_modal');
                            $('#input_sname_search').val('');
                            // console.log(arragle_notification_type);
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
                            // console.log(data);

                            swal({ title: word_translate.search_saved, text: word_translate.your_search_has_been_saved_successfuly, type: "success", timer: 2000, showConfirmButton: false });
                            //active_modal($('#modal_search_saved'));
                            /*
                            setTimeout(function() {
                                $('#modal_properties_send').find('.close').click();
                            }, 2000);
                            */
                            $('#input_sname_search').val('');
                            // console.log(arragle_notification_type);
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
            // event.preventDefault();

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

                // setTimeout(function() {
                //     $('#modal_properties_send').find('.close').click();
                // }, 2000);
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
                            // action: "flex_favorite_building",
                            action: "flex_favorite",
                            class_id: class_id,
                            mls_num: mls_num,
                            subject:property_subject,
                            type_action: 'add'
                        },
                        dataType: "json",
                        success: function(data) {
                            /*active_modal($('#modal_add_favorities'));
                            setTimeout(function() {
                                $('#modal_add_favorities').find('.close').click();
                            }, 2000);*/
                            var totsearch=0;
                            totsearch=1+parseInt(jQuery('.clidxboost-icon-favorite span span').text());
                            $('.clidxboost-icon-favorite span span').text(totsearch);
                            $(buton_corazon).attr("data-alert-token", data.token_alert);
                        }
                    });
                } else {
                    $(this).removeClass('active');
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
                            // console.log(data.message);
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
        //TABS DEL MODAL DE LOGIN
        /*$(".header-tab a").click(function() {
            var loginHeight = 0;
            $(".header-tab a").removeClass('active');
            $(this).addClass('active');
            var tabId = $(this).attr('data-tab');
            switch (tabId) {
                case 'tabLogin':
                    $('#modal_login h2').text('Welcome Back');
                    $(".text-slogan").text('Sign in below');
                    break;
                case 'tabRegister':
                    $('#modal_login h2').text('Register');
                    $(".text-slogan").text('Join to save listings and receive updates');
                    break;
                case 'tabReset':
                    $('#modal_login h2').text('Reset Password');
                    $(".text-slogan").text('Sign in below');
                    break;
            }
            $(".item_tab").removeClass('active');
            $("#" + tabId).addClass('active');
            loginHeight = $("#content-info-modal").height();
            $(".img_modal").css({
                'height': loginHeight + 'px'
            });
        });*/
        // setup waterfront
        flex_waterfront_switch = $('#flex_waterfront_switch');
        if (flex_waterfront_switch.length) {
            flex_waterfront_switch.on("change", function() {
                var _self = $(this);
                $('#idx_water_desc').val(_self.val());
                // console.log('changing val 4');
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
                // console.log('changing val 5');
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
                // console.log('changing val 6');
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
        // $('#idx_property_type').val(property_type_values.join("|"));
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
            // console.log('changing val 7');
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
            // console.log('changing val 8');
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
                // console.log('changing val 9');
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
                    // console.log('From %s to %s', baths_slider_values[startValue], baths_slider_values[endValue]);
                },
                create: function(event, ui) {
                    var min_val = $('#idx_min_baths').val() === '--' ? baths_slider_values[0] : parseFloat($('#idx_min_baths').val(), 10);
                    var max_val = $('#idx_max_baths').val() === '--' ? baths_slider_values[baths_slider_values.length - 1] : parseFloat($('#idx_max_baths').val(), 10);
                    var _self = $(this);
                    var startValue = $('#idx_min_baths').val() === '--' ? 0 : baths_slider_values.indexOf(min_val);
                    var endValue = $('#idx_max_baths').val() === '--' ? (baths_slider_values.length - 1) : baths_slider_values.indexOf(max_val);
                    _self.slider('values', [startValue, endValue]);
                    /*var _self = $(this);
                    var startValue = 0;
                    var endValue = baths_slider_values.length - 1;
                    _self.slider('values', [startValue, endValue]);
                    var initialStartValue = (baths_slider_values[startValue] == baths_slider_values[0]) ? '--' : baths_slider_values[startValue];
                    var initialEndValue = (baths_slider_values[endValue] == baths_slider_values[baths_slider_values.length - 1]) ? '--' : baths_slider_values[endValue];
                    $('#idx_min_baths').val(initialStartValue);
                    $('#idx_max_baths').val(initialEndValue);*/
                },
                change: function(event, ui) {
                    var startValue = ui.values[0];
                    var endValue = ui.values[1];
                    var initialStartValue = (baths_slider_values[startValue] == baths_slider_values[0]) ? '--' : baths_slider_values[startValue];
                    var initialEndValue = (baths_slider_values[endValue] == baths_slider_values[baths_slider_values.length - 1]) ? '--' : baths_slider_values[endValue];
                    $('#idx_min_baths').val(initialStartValue);
                    $('#idx_max_baths').val(initialEndValue);
                    // console.log('changing val 10');
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
                    // console.log('From %s to %s', beds_slider_values[startValue], beds_slider_values[endValue]);
                },
                create: function(event, ui) {
                    var min_val = $('#idx_min_beds').val() === '--' ? beds_slider_values[0] : parseInt($('#idx_min_beds').val(), 10);
                    var max_val = $('#idx_max_beds').val() === '--' ? beds_slider_values[beds_slider_values.length - 1] : parseInt($('#idx_max_beds').val(), 10);
                    var _self = $(this);
                    var startValue = $('#idx_min_beds').val() === '--' ? 0 : beds_slider_values.indexOf(min_val);
                    var endValue = $('#idx_max_beds').val() === '--' ? (beds_slider_values.length - 1) : beds_slider_values.indexOf(max_val);
                    _self.slider('values', [startValue, endValue]);
                    /* var _self = $(this);
                     var startValue = 0;
                     var endValue = beds_slider_values.length - 1;
                     _self.slider('values', [startValue, endValue]);
                     var initialStartValue = (beds_slider_values[startValue] == beds_slider_values[0]) ? '--' : beds_slider_values[startValue];
                     var initialEndValue = (beds_slider_values[endValue] == beds_slider_values[beds_slider_values.length - 1]) ? '--' : beds_slider_values[endValue];
                     $('#idx_min_beds').val(initialStartValue);
                     $('#idx_max_beds').val(initialEndValue);*/
                },
                change: function(event, ui) {
                    var startValue = ui.values[0];
                    var endValue = ui.values[1];
                    var initialStartValue = (beds_slider_values[startValue] == beds_slider_values[0]) ? '--' : beds_slider_values[startValue];
                    var initialEndValue = (beds_slider_values[endValue] == beds_slider_values[beds_slider_values.length - 1]) ? '--' : beds_slider_values[endValue];
                    $('#idx_min_beds').val(initialStartValue);
                    $('#idx_max_beds').val(initialEndValue);
                    // console.log('changing val 11');
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

                    $('#living_from').val(_.formatPrice(sqft_slider_values[startValue]) + " Sq.Ft.");

                    if (endValue == 37) {
                         $('#living_to').val('Any Size');
                    } else {
                         $('#living_to').val(_.formatPrice(sqft_slider_values[endValue]) + " Sq.Ft.");
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
                    // console.log('updating sqft');
                    // console.log(flex_input_living_from_old_value, flex_input_living_to_old_value);

                    $('#living_from').val(_.formatPrice(min_val) + " Sq.Ft.");

                    if (80000 == max_val) {
                        $('#living_to').val("Any Size");
                    } else {
                        $('#living_to').val(_.formatPrice(max_val) + " Sq.Ft.");
                    }

                    // $('#living_from').val(_.formatPrice(min_val) + " Sq.Ft.");
                    // $('#living_to').val(_.formatPrice(max_val) + " SF");
                    /*var _self = $(this);
                    var startValue = 0;
                    var endValue = sqft_slider_values.length - 1;
                    _self.slider('values', [startValue, endValue]);
                    $('#idx_living_area_min').val(sqft_slider_values[startValue]);
                    $('#idx_living_area_max').val(sqft_slider_values[endValue]);
                    $('#living_from').val(_.formatPrice(sqft_slider_values[startValue]) + " SF");
                    $('#living_to').val(_.formatPrice(sqft_slider_values[endValue]) + " SF");*/
                },
                change: function(event, ui) {
                    var startValue = ui.values[0];
                    var endValue = ui.values[1];
                    $('#idx_living_area_min').val(sqft_slider_values[startValue]);
                    $('#idx_living_area_max').val(sqft_slider_values[endValue]);
                    // console.log('changing val 12');
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

                    $('#land_from').val(_.formatPrice(lotsize_slider_values[startValue]) + " Sq.Ft.");

                    if (endValue == 37) {
                         $('#land_to').val('Any Size');
                    } else {
                         $('#land_to').val(_.formatPrice(lotsize_slider_values[endValue]) + " Sq.Ft.");
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

                    $('#land_from').val(_.formatPrice(min_val) + " Sq.Ft.");

                    if (80000 == max_val) {
                        $('#land_to').val("Any Size");
                    } else {
                        $('#land_to').val(_.formatPrice(max_val) + " Sq.Ft.");
                    }

                    /*var _self = $(this);
                    var startValue = 0;
                    var endValue = lotsize_slider_values.length - 1;
                    _self.slider('values', [startValue, endValue]);
                    $('#idx_lot_size_min').val(lotsize_slider_values[startValue]);
                    $('#idx_lot_size_max').val(lotsize_slider_values[endValue]);
                    $('#land_from').val(_.formatPrice(lotsize_slider_values[startValue]) + " SF");
                    $('#land_to').val(_.formatPrice(lotsize_slider_values[endValue]) + " SF");*/
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
                    // console.log('changing val 13');
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
                         $('#price_to').val('Any Price');
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
                        $('#price_to').val('Any Price');
                    } else {
                        $('#price_to').val('$' + _.formatPrice(max_val));
                    }

                    /*var _self = $(this);
                    var startValue = 0;
                    var endValue = price_sale_slider_values.length - 1;
                    _self.slider('values', [startValue, endValue]);
                    $('#idx_min_price_sale').val(price_sale_slider_values[startValue]);
                    $('#idx_max_price_sale').val(price_sale_slider_values[endValue]);
                    $('#price_from').val('$' + _.formatPrice(price_sale_slider_values[startValue]));
                    $('#price_to').val('$' + _.formatPrice(price_sale_slider_values[endValue]));*/
                },
                change: function(event, ui) {
                    var startValue = ui.values[0];
                    var endValue = ui.values[1];
                    $('#idx_min_price_sale').val(price_sale_slider_values[startValue]);
                    $('#idx_max_price_sale').val(price_sale_slider_values[endValue]);
                    // console.log('changing val 14');
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
                         $('#price_rent_to').val('Any Price');
                    } else {
                         $('#price_rent_to').val('$' + _.formatPrice(price_rent_slider_values[endValue]));
                    }

                    flex_input_min_price_rent_old_value = price_rent_slider_values[startValue];
                    flex_irent_max_price_sale_old_value = price_rent_slider_values[endValue];
                },
                create: function(event, ui) {
                    var min_val = $('#idx_min_price_rent').val() === '--' ? price_rent_slider_values[0] : parseInt($('#idx_min_price_rent').val(), 10);
                    var max_val = $('#idx_max_price_rent').val() === '--' ? price_rent_slider_values[price_rent_slider_values.length - 1] : parseInt($('#idx_max_price_rent').val(), 10);
                    // console.dir([min_val, max_val]);
                    var _self = $(this);
                    var startValue = $('#idx_min_price_rent').val() === '--' ? 0 : price_rent_slider_values.indexOf(min_val);
                    var endValue = $('#idx_max_price_rent').val() === '--' ? (price_rent_slider_values.length - 1) : price_rent_slider_values.indexOf(max_val);
                    // console.dir([startValue, endValue]);
                    // console.dir(price_rent_slider_values);
                    _self.slider('values', [startValue, endValue]);
                    $('#price_rent_from').val('$' + _.formatPrice(min_val));

                    if (100000 == max_val) {
                        $('#price_rent_to').val('Any Price');
                    } else {
                        $('#price_rent_to').val('$' + _.formatPrice(max_val));
                    }

                    /*var _self = $(this);
                    var startValue = 0;
                    var endValue = price_rent_slider_values.length - 1;
                    _self.slider('values', [startValue, endValue]);
                    $('#idx_min_price_rent').val(price_rent_slider_values[startValue]);
                    $('#idx_max_price_rent').val(price_rent_slider_values[endValue]);
                    $('#price_rent_from').val('$' + _.formatPrice(price_rent_slider_values[startValue]));
                    $('#price_rent_to').val('$' + _.formatPrice(price_rent_slider_values[endValue]));*/
                },
                change: function(event, ui) {
                    var startValue = ui.values[0];
                    var endValue = ui.values[1];
                    $('#idx_min_price_rent').val(price_rent_slider_values[startValue]);
                    $('#idx_max_price_rent').val(price_rent_slider_values[endValue]);
                    // console.log('changing val 15');
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
        // handle sign up
       /* $("#formRegister").on("submit", function(event) {
            event.preventDefault();
            var _self = $(this);
            var formData = _self.serialize();
            $.ajax({
                url: flex_idx_search_params.ajaxUrl,
                method: "POST",
                data: formData,
                dataType: "json",
                success: function(response) {
                    if (response.success === true) {
                        _self.trigger('reset');
                        $(".close").click();
                        swal({
                            title: "Good job!",
                            text: response.message,
                            type: "success",
                            timer: 2000,
                            showConfirmButton: false
                        });
                        setTimeout(function() {
                            window.location.reload(false);
                        }, 2000);
                    } else {
                        sweetAlert("Oops...", response.message, "error");
                    }
                }
            });
        });*/
        // handle sign in
        /*$('#formLogin').on("submit", function(event) {
            event.preventDefault();
            var _self = $(this);
            var formData = _self.serialize();
            $.ajax({
                url: flex_idx_search_params.ajaxUrl,
                method: "POST",
                data: formData,
                dataType: "json",
                success: function(response) {
                    if (response.success === true) {
                        $(".close").click();
                        swal({
                            title: "Good job!",
                            text: response.message,
                            type: "success",
                            timer: 2000,
                            showConfirmButton: false
                        });
                        setTimeout(function() {
                            window.location.reload(false);
                        }, 2000);
                    } else {
                        sweetAlert("Oops...", response.message, "error");
                    }
                }
            });
        });*/
        xhr_running = true;
        if ($("#flex-idx-search-form").length) {
            flex_refresh_search();
        }
        // fill values
        // var sqft_slider_values = _.pluck(search_params.living_size_range, 'value');
        // var lotsize_slider_values = _.pluck(search_params.lot_size_range, 'value');
        // var price_rent_slider_values = _.pluck(search_params.price_rent_range, 'value');
        // var price_sale_slider_values = _.pluck(search_params.price_sale_range, 'value');
        // var year_built_slider_values = _.pluck(search_params.year_built_range, 'value');
        // handle input fields
        var flex_input_min_price_sale = $('#price_from');
        var flex_input_max_price_sale = $('#price_to');
        var flex_input_min_price_sale_old_value;
        var flex_input_max_price_sale_old_value;
        if (flex_input_min_price_sale.length) {
            flex_input_min_price_sale.data('min-price', price_sale_slider_values[0]);
            flex_input_min_price_sale.data('max-price', price_sale_slider_values[price_sale_slider_values.length - 1]);
            flex_input_min_price_sale_old_value = parseInt(flex_input_min_price_sale.val().trim().replace(/\D/g, ''), 10);
            // flex_input_min_price_sale.on('focus', function() {
            //     this.value = '';
            // });
            flex_input_min_price_sale.on('blur', function() {
                var currentValue = jQuery(this).val().trim();
                currentValue = currentValue.replace(/\D/g, '');
                if (typeof currentValue === 'string' && currentValue.length === 0) {
                    // console.log(flex_input_min_price_sale_old_value);
                    currentValue = flex_input_min_price_sale_old_value;
                } else {
                    currentValue = parseInt(currentValue, 10);
                }
                // console.group('blur');
                // console.log(currentValue);
                // console.groupEnd('blur');
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
                    alert(word_translate.current_value_must_be_less_than_or_equal_to.+' ' + parseInt(flex_input_max_price_sale.val().trim().replace(/\D/g, ''), 10));
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
                    // console.log(x_val, y_val);
                    // do ajax
                    // console.log('changing val 17');
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
            // flex_input_max_price_sale.on('focus', function() {
            //     this.value = '';
            // });
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
                    alert(word_translate.current_value_must_be_less_than_or_equal_to.+' ' + parseInt(flex_input_min_price_sale.val().trim().replace(/\D/g, ''), 10));
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
                    // console.log('changing val 18');
                    $('#idx_page').val(1);
                    // do ajax
                    flex_refresh_search();
                }
                $(this).val('$' + _.formatPrice(currentValue));
            });
        }
        // ...
        var flex_input_min_price_rent = $('#price_rent_from');
        var flex_input_max_price_rent = $('#price_rent_to');
        var flex_input_min_price_rent_old_value;
        var flex_irent_max_price_sale_old_value;
        if (flex_input_min_price_rent.length) {
            flex_input_min_price_rent.data('min-price', price_rent_slider_values[0]);
            flex_input_min_price_rent.data('max-price', price_rent_slider_values[price_rent_slider_values.length - 1]);
            flex_input_min_price_rent_old_value = parseInt(flex_input_min_price_rent.val().trim().replace(/\D/g, ''), 10);
            // flex_input_min_price_rent.on('focus', function() {
            //     this.value = '';
            // });
            flex_input_min_price_rent.on('blur', function() {
                var currentValue = jQuery(this).val().trim();
                currentValue = currentValue.replace(/\D/g, '');
                if (typeof currentValue === 'string' && currentValue.length === 0) {
                    currentValue = flex_input_min_price_rent_old_value;
                } else {
                    currentValue = parseInt(currentValue, 10);
                }
                // console.group('blur');
                // console.log(currentValue);
                // console.groupEnd('blur');
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
                    alert(word_translate.current_value_must_be_less_than_or_equal_to.+' ' + parseInt(flex_input_max_price_rent.val().trim().replace(/\D/g, ''), 10));
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
                    // console.log(x_val, y_val);
                    // do ajax
                    // console.log('changing val 19');
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
            // flex_input_max_price_rent.on('focus', function() {
            //     this.value = '';
            // });
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
                    alert(word_translate.current_value_must_be_less_than_or_equal_to.+' ' + parseInt(flex_input_min_price_rent.val().trim().replace(/\D/g, ''), 10));
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
                    // console.log('changing val 20');
                    $('#idx_page').val(1);
                    flex_refresh_search();
                }
                $(this).val('$' + _.formatPrice(currentValue));
            });
        }
        // ...
        var flex_input_land_from = $('#land_from');
        var flex_input_land_to = $('#land_to');
        var flex_input_land_from_old_value;
        var flex_input_land_to_old_value;
        if (flex_input_land_from.length) {
            flex_input_land_from.data('min-sqft', sqft_slider_values[0]);
            flex_input_land_from.data('max-sqft', sqft_slider_values[sqft_slider_values.length - 1]);
            flex_input_land_from_old_value = parseInt(flex_input_land_from.val().trim().replace(/\D/g, ''), 10);
            // flex_input_land_from.on('focus', function() {
            //     this.value = '';
            // });
            flex_input_land_from.on('blur', function() {
                var currentValue = jQuery(this).val().trim();
                currentValue = currentValue.replace(/\D/g, '');
                if (typeof currentValue === 'string' && currentValue.length === 0) {
                    // console.log(flex_input_land_from_old_value);
                    currentValue = flex_input_land_from_old_value;
                } else {
                    currentValue = parseInt(currentValue, 10);
                }
                // console.group('blur');
                // console.log(currentValue);
                // console.groupEnd('blur');
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
                    alert(word_translate.current_value_must_be_less_than_or_equal_to.+' ' + parseInt(flex_input_land_to.val().trim().replace(/\D/g, ''), 10));
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
                    // console.log(x_val, y_val);
                    // do ajax
                    // console.log('changing val 21');
                    $('#idx_page').val(1);
                    flex_refresh_search();
                }
                $(this).val(_.formatPrice(currentValue) + ' Sq.Ft.');
            });
        }
        if (flex_input_land_to.length) {
            flex_input_land_to.data('min-sqft', sqft_slider_values[0]);
            flex_input_land_to.data('max-sqft', sqft_slider_values[sqft_slider_values.length - 1]);
            flex_input_land_to_old_value = parseInt(flex_input_land_to.val().trim().replace(/\D/g, ''), 10);
            // flex_input_land_to.on('focus', function() {
            //     this.value = '';
            // });
            flex_input_land_to.on('blur', function() {
                var currentValue = jQuery(this).val().trim();
                currentValue = currentValue.replace(/\D/g, '');
                if (typeof currentValue === 'string' && currentValue.length === 0) {
                    currentValue = flex_input_land_to_old_value;
                } else {
                    currentValue = parseInt(currentValue, 10);
                }
                $(this).val(_.formatPrice(currentValue) + ' Sq.Ft.');
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
                    alert(word_translate.current_value_must_be_less_than_or_equal_to.+' ' + parseInt(flex_input_land_from.val().trim().replace(/\D/g, ''), 10));
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
                    // console.log('changing val 22');
                    $('#idx_page').val(1);
                    flex_refresh_search();
                }
                $(this).val(_.formatPrice(currentValue) + ' Sq.Ft.');
            });
        }
        // ...
        var flex_input_living_from = $('#living_from');
        var flex_input_living_to = $('#living_to');
        var flex_input_living_from_old_value;
        var flex_input_living_to_old_value;
        if (flex_input_living_from.length) {
            flex_input_living_from.data('min-sqft', sqft_slider_values[0]);
            flex_input_living_from.data('max-sqft', sqft_slider_values[sqft_slider_values.length - 1]);
            flex_input_living_from_old_value = parseInt(flex_input_living_from.val().trim().replace(/\D/g, ''), 10);
            // flex_input_living_from.on('focus', function() {
            //     this.value = '';
            // });
            flex_input_living_from.on('blur', function() {
                var currentValue = jQuery(this).val().trim();
                currentValue = currentValue.replace(/\D/g, '');
                if (typeof currentValue === 'string' && currentValue.length === 0) {
                    // console.log(flex_input_living_from_old_value);
                    currentValue = flex_input_living_from_old_value;
                } else {
                    currentValue = parseInt(currentValue, 10);
                }
                // console.group('blur');
                // console.log(currentValue);
                // console.groupEnd('blur');
                $(this).val(_.formatPrice(currentValue) + ' Sq.Ft.');
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
                    alert(word_translate.current_value_must_be_less_than_or_equal_to.+' ' + parseInt(flex_input_living_to.val().trim().replace(/\D/g, ''), 10));
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
                    // console.log(x_val, y_val);
                    // do ajax
                    // console.log('changing val 23');
                    $('#idx_page').val(1);
                    flex_refresh_search();
                }
                $(this).val(_.formatPrice(currentValue) + ' Sq.Ft.');
            });
        }
        if (flex_input_living_to.length) {
            flex_input_living_to.data('min-sqft', sqft_slider_values[0]);
            flex_input_living_to.data('max-sqft', sqft_slider_values[sqft_slider_values.length - 1]);
            flex_input_living_to_old_value = parseInt(flex_input_living_to.val().trim().replace(/\D/g, ''), 10);
            // flex_input_living_to.on('focus', function() {
            //     this.value = '';
            // });
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
                    alert(word_translate.current_value_must_be_less_than_or_equal_to.+' ' + parseInt(flex_input_living_from.val().trim().replace(/\D/g, ''), 10));
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
                    // console.log('changing val 24');
                    $('#idx_page').val(1);
                    flex_refresh_search();
                }
                $(this).val(_.formatPrice(currentValue) + ' Sq.Ft.');
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
            // flex_input_year_min.on('focus', function() {
            //     this.value = '';
            // });
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
                    alert(word_translate.current_value_must_be_less_than_or_equal_to.+' ' + parseInt(flex_input_year_max.val(), 10));
                    currentValue = $(this).data('min-year');
                } else {
                    $('#year_from').val(currentValue);
                    $('#idx_min_year').val(currentValue);
                    var x_val = year_built_slider_values.indexOf(currentValue);
                    var y_val = year_built_slider_values.indexOf(parseInt(flex_input_year_max.val(), 10));
                    flex_input_year_min_old_value = currentValue;
                    // console.log('changing val 25');
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
            // flex_input_year_max.on('focus', function() {
            //     this.value = '';
            // });
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
                    alert(word_translate.current_value_must_be_less_than_or_equal_to.+' ' + parseInt(flex_input_year_min.val(), 10));
                    currentValue = $(this).data('max-year');
                } else {
                    $('#year_to').val(currentValue);
                    $('#idx_max_year').val(currentValue);
                    var x_val = year_built_slider_values.indexOf(parseInt(flex_input_year_min.val(), 10));
                    var y_val = year_built_slider_values.indexOf(currentValue);
                    flex_input_year_max_old_value = currentValue;
                    // console.log('changing val 26');
                    $('#idx_page').val(1);
                    $('#range-year').slider('values', [x_val, y_val]);
                }
                $(this).val(currentValue);
            });
        }
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
    var initMapLoaded = false;

    $(function() {
        /*$("#map-actions").on("click", "button", function() {
            if ($(this).hasClass("open-map")) {
                // close
                $(".close-map").removeClass("hide");
                $(".open-map").addClass("hide");
                $("#wrap-list-result").hide();
            } else {
                // open
                $(".open-map").removeClass("hide");
                $(".close-map").addClass("hide");
                $("#wrap-list-result").show();
            }
            google.maps.event.trigger(map, "resize");
        });*/

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

    function initialize() {
        myLazyLoad = new LazyLoad({
            elements_selector: ".flex-lazy-image"
        });
        map = new google.maps.Map(document.getElementById('code-map'), {
            center: new google.maps.LatLng(25.761680, -80.19179),
            mapTypeId: google.maps.MapTypeId.ROADMAP,
            zoom: 16,
            disableDoubleClickZoom: true,
            scrollwheel: false,
            panControl: false,
            streetViewControl: false,
            disableDefaultUI: true,
            clickableIcons: false,
            gestureHandling: 'greedy'
        });
        google.maps.event.addListenerOnce(map, 'tilesloaded', setupMapControls);
        var bounds = new google.maps.LatLngBounds();
        firstB = new google.maps.LatLng(25.761680, -80.19179);
        bounds.extend(firstB);
        map.fitBounds(bounds);
        // google.maps.event.addListenerOnce(map, 'tilesloaded', setupMarkers);
    }

    function handleZoomInButton(event) {
        event.stopPropagation();
        event.preventDefault();
        if (userIsDrawing) {
            google.maps.event.clearListeners(map.getDiv(), "mousedown");
            google.maps.event.removeListener(move);
            stopDrawingMap();
            // remove polygon draw
            // console.log('changing val 27');
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
        if (userIsDrawing) {
            google.maps.event.clearListeners(map.getDiv(), "mousedown");
            google.maps.event.removeListener(move);
            stopDrawingMap();
            // remove polygon draw
            // console.log('changing val 28');
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
        // console.log('changing val 29');
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
        if (this.classList.contains('flex-map-is-drawing')) {
            google.maps.event.clearListeners(map.getDiv(), "mousedown");
            google.maps.event.removeListener(move);
            stopDrawingMap();
            // remove polygon draw
            // console.log('changing val 30');
            $('#idx_page').val(1);
            $('#idx_polygon').val('');
            flex_refresh_search();
            $(".flex-map-draw-erase").hide();
        } else {
            $(".flex-map-draw-erase").show();
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
            // console.log('changing val 31');
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

    function setupMarkers(properties) {
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
        // console.dir(unique_properties);
        for (i = 0; i < unique_properties.length; i++) {
            property = unique_properties[i];
            marker = new RichMarker({
                position: new google.maps.LatLng(property.item.lat, property.item.lng),
                map: map,
                flat: true,
                content: (property.group.length > 1) ? '<div class="dgt-richmarker-group"><strong>' + property.group.length + '</strong><span>'+word_translate.units+'</span></div>' : '<div class="dgt-richmarker-single"><strong>$' + _.formatShortPrice(property.item.price) + '</strong></div>',
                anchor: RichMarkerPosition.TOP
            });
            marker.geocode = property.item.lat + ':' + property.item.lng;
            google.maps.event.addListener(marker, "click", handleMarkerClick(marker, property, map));
            google.maps.event.addListener(marker, "mouseover", handleMarkerMouseOver(marker));
            google.maps.event.addListener(marker, "mouseout", handleMarkerMouseOut(marker));
            bounds.extend(marker.position);
            markers.push(marker);
        }
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
    }

    function handleMarkerClick(marker, property, map) {
        return function() {
            // console.dir(property);
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
                    infobox_content.push('<h2 title="' + property_group.address_short + '"><span>' + property_group.address_short + '</span></h2>');
                    infobox_content.push('<ul>');
                    infobox_content.push('<li class="address"><span>' + property_group.address_large + '</span></li>');
                    infobox_content.push('<li class="price">$' + _.formatPrice(property_group.price) + '</li>');
                    var textpropertygroupbed='Beds';
                    var textpropertygroupbath='Baths';
                    if (property_group.bed>1) { textpropertygroupbed='Beds'; }else{textpropertygroupbed='Bed'; }
                    if (property_group.bath>1) {textpropertygroupbath='Baths';}else{textpropertygroupbath='Bath';}

                    infobox_content.push('<li class="beds"><b>' + property_group.bed + '</b> <span> '+textpropertygroupbed+'</span></li>');
                    infobox_content.push('<li class="baths"><b>' + property_group.bath + '</b> <span> '+textpropertygroupbath+'</span></li>');
                    infobox_content.push('<li class="living-size"> <span>' + _.formatPrice(property_group.sqft) + '</span> Sq.Ft.<span>(' + property_group.living_size_m2 + ' m2)</span></li>');
                    infobox_content.push('<li class="price-sf"><span>$' + property_group.price_sqft + ' </span>/ Sq.Ft.<span>($' + property_group.price_sqft_m2 + ' m2)</span></li>');
                    infobox_content.push('</ul>');
                    infobox_content.push('<div class="mapviwe-img">');
                    infobox_content.push('<img title="' + property_group.address_short + ', ' + property_group.address_large + '" alt="' + property_group.address_short + ', ' + property_group.address_large + '" src="' + property_group.gallery[0] + '">');
                    infobox_content.push('</div>');
                    if (property_group.status == 1) {
                        infobox_content.push('<a href="' + flex_idx_search_params.propertyDetailPermalink + '/' + property_group.slug + '" title="' + property_group.address_short + ', ' + property_group.address_large + '">' + property_group.address_short + ', ' + property_group.address_large + '</a>');
                    } else {
                        infobox_content.push('<a href="' + flex_idx_search_params.propertyDetailPermalink + '/pending-' + property_group.slug + '" title="' + property_group.address_short + ', ' + property_group.address_large + '">' + property_group.address_short + ', ' + property_group.address_large + '</a>');
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
                infobox_content.push('<h2 title="' + property.item.address_short + '"><span>' + property.item.address_short + '</span></h2>');
                infobox_content.push('<ul>');
                infobox_content.push('<li class="address"><span>' + property.item.address_large + '</span></li>');
                infobox_content.push('<li class="price">$' + _.formatPrice(property.item.price) + '</li>');
                var textpropertyitembed='Beds'; var textpropertyitembath='Baths';
                if (property.item.bed>1) { textpropertyitembed='Beds'; }else{ textpropertyitembed='Bed'; }
                if (property.item.bath>1) { textpropertyitembath='Baths'; }else{ textpropertyitembath='Bath'; }
                infobox_content.push('<li class="beds"><b>' + property.item.bed + '</b> <span> '+textpropertyitembed+'</span></li>');
                infobox_content.push('<li class="baths"><b>' + property.item.bath + '</b> <span> '+textpropertyitembath+'</span></li>');
                infobox_content.push('<li class="living-size"> <span>' + _.formatPrice(property.item.sqft) + '</span> Sq.Ft.<span>(' + property.item.living_size_m2 + ' m2)</span></li>');
                infobox_content.push('<li class="price-sf"><span>$' + property.item.price_sqft + ' </span>/ Sq.Ft.<span>($' + property.item.price_sqft_m2 + ' m2)</span></li>');
                infobox_content.push('</ul>');
                infobox_content.push('<div class="mapviwe-img">');
                infobox_content.push('<img title="' + property.item.address_short + ', ' + property.item.address_large + '" alt="' + property.item.address_short + ', ' + property.item.address_large + '" src="' + property.item.gallery[0] + '">');
                infobox_content.push('</div>');
                if (property.item.status == 1) {
                    infobox_content.push('<a href="' + flex_idx_search_params.propertyDetailPermalink + '/' + property.item.slug + '" title="' + property.item.address_short + ', ' + property.item.address_large + '">' + property.item.address_short + ', ' + property.item.address_large + '</a>');
                } else {
                    infobox_content.push('<a href="' + flex_idx_search_params.propertyDetailPermalink + '/pending-' + property.item.slug + '" title="' + property.item.address_short + ', ' + property.item.address_large + '">' + property.item.address_short + ', ' + property.item.address_large + '</a>');
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
                        map.fitBounds(bounds);
                    } else {
                        map.setCenter(map_center);
                        map.setZoom(map_zoom);
                    }
                }, 100);
            } else {
                mapIsVisible = false;
            }
        });
        $("#result-search").on("click", ".propertie", function(event) {
            // event.stopPropagation();
            // event.preventDefault();
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
                map.setZoom(18);
                google.maps.event.trigger(marker, "mouseover");
                google.maps.event.trigger(marker, "click");
            }
        });
        /*$wrapListResult.perfectScrollbar({
            suppressScrollX: true
        });*/
        /*$wrapListResult.on('ps-y-reach-end', _.debounce(function() {
            // next page
            var has_next_page = $("#flex-idx-search-form").data("next_page");
            var current_page = $("#flex-idx-search-form").data("current_page");
            if ($('#filter-views').find('.map:eq(0)').hasClass('active') && has_next_page == true) {
                $("#idx_page").val(current_page + 1);
                flex_refresh_search();
            }
        }, 800));*/
        // handle typing into input fields
        /*$("#result-search").on("scroll", function() {
          if (mapIsVisible === true) {
              console.log('scrolling');

              var containerHeight = $(this).innerHeight();
              var containerScrollTop = $(this).scrollTop();
              var containerScrollHeight = $(this).prop('scrollHeight');

              if ((containerScrollTop + containerHeight) >= containerScrollHeight) {
                  // next page
                  var has_next_page = $("#flex-idx-search-form").data("next_page");
                  var current_page = $("#flex-idx-search-form").data("current_page");

                  if (has_next_page == true) {
                      $("#idx_page").val(current_page + 1);
                      flex_refresh_search();
                  }

                  // <div class="dgt-load-more-page-metadata"><p>Page 2 - LISTINGS 25 to 48</p></div>
                  console.log(has_next_page);
                  console.log('end reached');
              }
          }
        });*/
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


        /*** TOUCH SLIDER **
        var xDown = null;
        var yDown = null;
        $('body').live('touchstart', '#result-search .propertie', function(evt){
            xDown = evt.touches[0].clientX;
            yDown = evt.touches[0].clientY;

            console.log('paso1');
        });

        $('body').live('touchmove', '#result-search .propertie', function(evt) {

            console.log('paso2');

          if ( ! xDown || ! yDown ) {
            return;
          }
          var xUp = evt.touches[0].clientX;
          var yUp = evt.touches[0].clientY;
          var xDiff = xDown - xUp;
          var yDiff = yDown - yUp;
          if ( Math.abs( xDiff ) > Math.abs( yDiff ) ) { // si se mueve derecha o izquierda
            evt.preventDefault();
            if ( xDiff > 0 ) { // izquierda
              $(this).find('.flex-slider-next').click();
            } else { // derecha
              $(this).find('.flex-slider-prev').click();
            }
          }
          xDown = null;
          yDown = null;
        });*/


        /*** FUNCÍON PARA AGREGAR COMPORTAMIENTO DE SISTEMA SEGUN LA RESULUCIÓN DE SU CONTENEDOR GENERAL ****/
        /*function hackResize(wrapContentPage){
          //Nota: lo primero que hay que hacer es obtener el ancho del dispositivo, de esa forma
          //podemos hacer una comparación con el ancho del contenedor del plugin y colocar el hack
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
