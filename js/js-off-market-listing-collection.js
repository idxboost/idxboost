var view_options;
var sort_options;
var FILTER_PAGE_URL;
var FILTER_PAGE_CURRENT;
var IB_IS_REGULAR_FILTER_PAGE = true;
var textprueba = '',
    inifil_default = 4;
var idxboost_filter_countacti = false,
    idxboostcondition = '';
(function($) {
    var ajax_request_filter;
    var idxboost_filter_forms;

    $(function() {
        idxboost_filter_forms = $(".flex-idx-filter-form");
        FILTER_PAGE_URL = $('#flex_idx_sort').data('permalink');
        FILTER_PAGE_CURRENT = $('#flex_idx_sort').data('currpage');

        if (idxboost_filter_forms.length) {
            idxboost_filter_forms.each(function() {
                var form = $(this);
                var inputs = form.find("input");

                if (inputs.length) {
                    inputs.on("change", function() {
                        var filter_form = $(this).parent();
                        var filter_form_data = filter_form.serialize();
                    });
                }
            });
        }
    });
})(jQuery);

var ib_event_mobile=true;
var myLazyLoad;
var arraytest;
var arrayother;
var search_params = flex_idx_filter_params.params;
var baths_slider_values = _.pluck(search_params.baths_range, 'value');
var beds_slider_values = _.pluck(search_params.beds_range, 'value');
var sqft_slider_values = _.pluck(search_params.living_size_range, 'value');
var lotsize_slider_values = _.pluck(search_params.lot_size_range, 'value');
var price_rent_slider_values = _.pluck(search_params.price_rent_range, 'value');
var price_sale_slider_values = _.pluck(search_params.price_sale_range, 'value');
var year_built_slider_values = _.pluck(search_params.year_built_range, 'value');
var property_type_values = _.pluck(search_params.property_types, 'value');
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

(function($) {
    $(function() {
      // handle save search on filter pages
      $("#filter-save-search").on("click", function() {
        var current_count = $(this).data("count");

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


        } else if (__flex_g_settings.anonymous === "no" && (current_count > 500)) {
            sweetAlert(word_translate.oops, word_translate.you_cannot_save_search_with_more_than_500_properties, "error");
            return;
        } else {
          active_modal($('#modal_save_search'));
          setTimeout(function() {
              $('#modal_properties_send').find('.close').click();
          }, 2000);
        }
      });

        // fix touch slider
        $('body').on('touchstart', '.slider-generator .propertie', function(evt) {
            evt.stopPropagation();
            xDown = evt.originalEvent.touches[0].clientX;
            yDown = evt.originalEvent.touches[0].clientY;
        });
        $('body').on('touchmove', '.slider-generator .propertie', function(evt) {
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
        $('#result-search').scroll(function() {
            new LazyLoad({
              callback_error: function(element){
                $(element).attr('src','https://idxboost.com/i/default_thumbnail.jpg').removeClass('error').addClass('loaded');
                $(element).attr('data-origin','https://idxboost.com/i/default_thumbnail.jpg');
              }
            });
        });

        // Expande y contrae los mini filtros de 'all filters' en versión mobile de la web
        var $miniFilters = $('#mini-filters');
        if ($miniFilters.length) {
            // Expando y contrigo el filtro
            $miniFilters.find('h4').on('click', function() {
                var $theLi = $(this).parents('li');
                $theLi.toggleClass('expanded').siblings().removeClass('expanded');
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
                        if ($wrapFilters.width() <= 959) {
                            //$cuerpo.toggleClass('fixed');
                            $('html').toggleClass('fixed');
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
                            //creaScrollTemporal($allFilters, $citiesList);
                        }
                        // [/D]
                        break
                    default:

                        if ($('html').hasClass('fixed')) {
                            $('html').removeClass('fixed');
                        }
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
            $theFilters.find('.mini-search, .save').on('click', function() {
                if ($allFilters.hasClass('visible')) {
                    $theFilters.find('.active button').trigger('click');
                }
            });
        }
    });
    var $textThComplet = 'Page % - LISTINGS % to %'; // Éste es el texto que aparecerá en el separador cuando se cargue más items en la vista mapa, de la página 'Search Results'. Ejm: Page 2 - LISTINGS 25 to 48
    //
    var $cuerpo = $('body');
    var $ventana = $(window);
    var $htmlcuerpo = $('html, body');
    //alert('Ancho: ' + $ventana.width() + 'px - Alto: ' + $ventana.height() + 'px');
    $ventana.on('load', function() {
        $cuerpo.removeClass('loading');
    });
    // Seleccionador de clases en los filtros.
    var $viewFilter = $('.filter-views');
    if ($viewFilter.length) {
        var $wrapResult = $('.wrap-result');
        // Cambio de vista por SELECT NATIVO
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
                    break
                case 'list':
                    $('.idxboost-content-filter-'+currentfiltemid+' ').find($wrapResult).removeClass('view-grid view-map').addClass('view-list');
                    $cuerpo.addClass('view-list').removeClass('view-map');
                    break
                case 'map':
                    $('.idxboost-content-filter-'+currentfiltemid+' ').find($wrapResult).removeClass('view-list view-grid').addClass('view-map');
                    $cuerpo.removeClass('view-list').addClass('view-map');
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
        if ($ventana.width() >= 768) {
            mutaSelectViews(true); //,por defecto que mute
        }

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
    }
    // Results Search
    var $resultSearch = $('#result-search');
    if ($resultSearch.length) {

        function creaMiniSliders() {
            var $properties = $resultSearch.find('.propertie');
            var nproperties = $properties.length;
            for (var p = 0; p < nproperties; p++) {
                var $miniSlider = $properties.eq(p).find('.wrap-slider');
                if ($miniSlider.length) {
                    var $ulSlider = $miniSlider.find('> ul');
                    var $lisSlider = $ulSlider.find('> li');
                    var nLisEx = $lisSlider.length;
                    if (nLisEx > 1) {
                        $ulSlider.css('width', (nLisEx * 100) + '%');
                        $lisSlider.css('width', (100 / nLisEx) + '%');
                    }
                };
            }
        }
        // Escondo el 'All Filters' con el boton 'Apply filters', simulando click en 'All Filters'
        var $applyFilters = $('#apply-filters');
        if ($applyFilters.length) {
            $applyFilters.on('click', function() {
                $theFilters.find('.all button').trigger('click');
            });
        }
        // Click fuera de 'All filters', desaparece.
    }
    // Crea scroll para resultados , si es neighboorhood;
    var $neighborhood = $('#neighborhood');
    if ($neighborhood.length) {
        if ($ventana.width() >= 1280) {
            $('#neighborhood').perfectScrollbar({
                suppressScrollX: true,
                minScrollbarLength: '42'
            });
        }
    }
    // Escoge en el menu de 'neighborhood-menu' de Neighboorhood Results
    var $neighborhoodMenu = $('#neighborhood-menu');
    if ($neighborhoodMenu.length) {
        // Desaparece el menu cuando se hizo click en un LI
        $neighborhoodMenu.on('click', 'li', function() {
            $neighborhoodMenu.toggleClass('active');
            $(this).addClass('active').siblings().removeClass('active');
        })
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
    // Slider del menu de neighboorhood.
    // analizar, si se necesita convertir en funcion para luego anidar su ejecución permanente al evento .resize
    if ($neighborhoodMenu.width() >= 700) { // no pongo 768, xq en MAC: (1280), el espacio para el '$neighborhoodMenu' es solo de 720
        // Dando ancho relativo al contenedor de los enlaces;
        setTimeout(function() {
            var $enlacesNbh = $neighborhoodMenu.find('li');
            var nEnlacesNbh = $enlacesNbh.length
            if (nEnlacesNbh) { // Compruebo que existan enlaces
                var anchoUlNbh = 0;
                $enlacesNbh.each(function() {
                    anchoUlNbh = anchoUlNbh + $(this).outerWidth();
                });
                // Calculo el margen total de los items y luego doy ancho real al Ul
                var $anchoFinalUl = anchoUlNbh + (Number($enlacesNbh.eq(0).css('margin-right').replace('px', '')) * (nEnlacesNbh - 1))
                var $ulNbhMenu = $neighborhoodMenu.find('ul')
                    // Si los enlaces no son muchos, escondo las flechas
                var $menuNbhWidth = Number($neighborhoodMenu.find('.gwr').width());
                if ($anchoFinalUl < $neighborhoodMenu.width()) {
                    $neighborhoodMenu.find('button').addClass('hide');
                    var $porcentaje = Math.floor(($anchoFinalUl * 100) / $menuNbhWidth);
                    if ($porcentaje >= 65) { // si el porcentaje del ancho de los items sumados es mayor al 65%, damos flex
                        $ulNbhMenu.addClass('flex');
                    }
                } else {
                    $ulNbhMenu.css('width', $anchoFinalUl + 'px');
                    var $nextItemNbh = $neighborhoodMenu.find('.next-item');
                    var $prevItemNbh = $neighborhoodMenu.find('.prev-item');
                    // Asignando el desplazamiento para la flecha 'NEXT'
                    $nextItemNbh.on('click', function() { // Boton siguiente
                        var $lastItemMenuNbh = $enlacesNbh.eq(nEnlacesNbh - 1);
                        // Moviendo el menu
                        $ulNbhMenu.css('margin-left', '-' + (($menuNbhWidth - $lastItemMenuNbh.position().left) + $lastItemMenuNbh.width()) + 'px');
                        // Desactivando el boton
                        $(this).addClass('hide');
                        $prevItemNbh.removeClass('hide')
                    });
                    $prevItemNbh.on('click', function() {
                        $ulNbhMenu.css('margin-left', '0');
                        $(this).addClass('hide');
                        $nextItemNbh.removeClass('hide');
                    })
                }
            }
        }, 0);
    }

    widthTitleModal();
    $ventana.resize(function() {
        widthTitleModal();
    });
    var $openCloseMap = $('.map-actions button');
    if (typeof($openCloseMap) != 'undefined') {
        $openCloseMap.on('click', function() {
            $openCloseMap.removeClass('no-show');
            $(this).addClass('no-show');
            $('#wrap-list-result').toggleClass('hidden-results');
        });
    }
    var $showModal = $('.show-modal');
    if (typeof($showModal) != 'undefined') {
        $showModal.on('click', function() {
            var $idModal = $(this).attr('data-modal'); //Identificador del Modal a mostrar
            var $positionModal = $(this).attr('data-position'); //Posición en la que se encuentra el Modal
            var $modalImg = $('#' + $idModal).find('.lazy-img').attr('data-src'); //Consultamos si existe una imagen para mostrar en el Modal
            if (typeof($modalImg) != 'undefined') {
                $('#' + $idModal).find('.lazy-img').attr('src', $modalImg).removeAttr('data-src');
            }
            active_modal($idModal, $positionModal);
        });
    }
    //var $overlayModal = $('.overlay_modal');
    var $bodyModal = $('.modal_cm');
    var $bodyHtml = $('html');

    function active_modal(modal, positionmodal) {
        var $modal = $('#' + modal);
        var $positionModal = positionmodal;
        if ($modal.hasClass('active_modal')) {
            $('.overlay_modal').removeClass('active_modal');
        } else {
            $modal.addClass('active_modal');
            if ($positionModal == 0) {
                $bodyHtml.addClass('modal_fmobile');
                var $positionClose = 0;
            } else {
                $bodyHtml.addClass('modal_mobile');
                var $positionClose = 1;
            }
        }
        close_modal(modal, $positionClose);
    }

    function close_modal(modal, positionClose) {
        var $this, $parentModal;
        var $positionClose = positionClose; //Posición para cerrar el modal
        //Condición relacionada al botón close del modal
        if ($positionClose == 0) {
            $this = $('#' + modal).find('.close-btn'); //Boton close del modal
            $parentModal = 'modal_fmobile';
        } else {
            $this = $('#' + modal).find('.close'); //Boton close del modal
            $parentModal = 'modal_mobile';
        }
        $this.click(function() {
            var $modal = $this.closest('.active_modal');
            $modal.removeClass('active_modal');
            $bodyHtml.removeClass($parentModal);
        });

        $('#' + modal).find(".overlay_modal_closer").click(function() {
            $('#' + modal).removeClass('active_modal');
            $bodyHtml.removeClass('modal_mobile');
        });
    }

    function showFullMap() {
        console.log('activo');
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

    function widthTitleModal() {
        var $titleModal = $('#md-title');
        if (typeof($titleModal) != 'undefined') {
            var widthSize = $("#md-body").width();
            $titleModal.css({
                'width': widthSize + 'px'
            });
        }
    }
    //Final de Funciones agregadas el 20/04/2017
    // Funciones generales
    function apareceImagen(li) {
        var $laImagen = li.find('img');
        var $srcOriginal = $laImagen.attr('data-src');
        if ($srcOriginal !== undefined) {
            $laImagen.attr('src', $srcOriginal).removeAttr('data-src');
            li.addClass('loading');
            $laImagen.on('load', function() {
                li.removeClass('loading');
            });
        }
    }

    function itemActivo(losLi) { // refactorizar esto (nueva idea para la función).
        var nLis = losLi.length;
        for (var s = 0; s < nLis; s++) {
            if (losLi.eq(s).hasClass('active')) {
                return s;
            }
        }
    }

    function getGallery(mls, counter) {
        // ejemplo: http://retsimages.s3.amazonaws.com/34/A10172834_2.jpg
        var cdn = '//retsimages.s3.amazonaws.com';
        var folder = mls.substring((mls.length) - 2); // 34
        var list = [];
        var img = '';
        if (counter <= 0) {
            list.push(dgtCredential.imgComingSoon);
        } else {
            for (var i = 1; i <= counter; i++) {
                img = cdn + '/' + folder + '/' + mls + '_' + i + '.jpg';
                list.push(img);
            }
        }
        return list;
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

    function dgt_rangeSlide(elementRange, minr, maxr, stepTo, pricefrom, priceto, typev1, typev2, boolComa, maxStep, newStep) {
        $(elementRange).slider({
            range: true,
            min: minr,
            max: maxr,
            values: [minr, maxr],
            step: stepTo,
            slide: function(event, ui) {
                if (ui.values[0] > maxStep) {
                    newSepTo(elementRange, newStep);
                    //console.log('soy mas que: ' + maxStep);
                } else {
                    //if (step != stepTo) {
                    newSepTo(elementRange, stepTo);
                    //console.log('soy menos que: ' + maxStep);
                    //}
                }
                if (boolComa == true) {
                    $(pricefrom).val(typev1 + separadorComa(ui.values[0]) + " " + typev2);
                    $(priceto).val(typev1 + separadorComa(ui.values[1]) + " " + typev2);
                } else {
                    $(pricefrom).val(typev1 + ui.values[0] + " " + typev2);
                    $(priceto).val(typev1 + ui.values[1] + " " + typev2);
                }
            },
        });
    };

    function newSepTo(elementRange, newStep) {
        $(elementRange).slider({
            step: newStep
        });
    };

    function separadorComa(valor) {
        var nums = new Array();
        var simb = ","; //Éste es el separador
        valor = valor.toString();
        valor = valor.replace(/\D/g, ""); //Ésta expresión regular solo permitira ingresar números
        nums = valor.split(""); //Se vacia el valor en un arreglo
        var long = nums.length - 1; // Se saca la longitud del arreglo
        var patron = 3; //Indica cada cuanto se ponen las comas
        var prox = 2; // Indica en que lugar se debe insertar la siguiente coma
        var res = "";
        while (long > prox) {
            nums.splice((long - prox), 0, simb); //Se agrega la coma
            prox += patron; //Se incrementa la posición próxima para colocar la coma
        }
        for (var i = 0; i <= nums.length - 1; i++) {
            res += nums[i]; //Se crea la nueva cadena para devolver el valor formateado
        }
        return res;
    };
    (function($) {
        var extensionMethods = {
            pips: function(settings) {
                options = {
                    first: "number",
                    last: "number",
                    rest: "pip"
                };
                $.extend(options, settings);
                this.element.addClass('ui-slider-pips').find('.ui-slider-pip').remove();
                var pips = this.options.max - this.options.min;
                for (i = 0; i <= pips; i++) {
                    var s = $('<span class="ui-slider-pip"><span class="ui-slider-line"></span><span class="ui-slider-number">' + i + '</span></span>');
                    if (0 == i) {
                        s.addClass('ui-slider-pip-first');
                        if ("number" == options.first) {
                            s.addClass('ui-slider-pip-number');
                        }
                        if (false == options.first) {
                            s.addClass('ui-slider-pip-hide');
                        }
                    } else if (pips == i) {
                        s.addClass('ui-slider-pip-last');
                        if ("number" == options.last) {
                            s.addClass('ui-slider-pip-number');
                        }
                        if (false == options.last) {
                            s.addClass('ui-slider-pip-hide');
                        }
                    } else {
                        if ("number" == options.rest) {
                            s.addClass('ui-slider-pip-number');
                        }
                        if (false == options.rest) {
                            s.addClass('ui-slider-pip-hide');
                        }
                    }
                    if (this.options.orientation == "horizontal") s.css({
                        left: '' + (100 / pips) * i + '%'
                    });
                    else s.css({
                        top: '' + (100 / pips) * i + '%'
                    });
                    this.element.append(s);
                }
            }
        };
        $.extend(true, $['ui']['slider'].prototype, extensionMethods);
    })(jQuery);

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

    function close_modal($obj) {
        var $this = $obj.find('.close');
        $this.click(function() {
            var $modal = $this.closest('.active_modal');
            $modal.removeClass('active_modal');
            $('html').removeClass('modal_mobile');
        });
    }
    $(function() {
        $("#wrap-list-result").on('scroll',function(){
            myLazyLoad.update();
        });

        $("#result-search, .result-search").on("click", ".view-detail", function() {
            var mlsNumber = $(this).parent('li').data('mls')
            loadPropertyInModal(mlsNumber);
        });

        $('.property_type_checkbox').change(function(event){
            var typeProperty=[],text_type=[];
            $(".property_type_checkbox:checked").each(function(){
                typeProperty.push($(this).val());
            });

            if (typeProperty.indexOf("2") != -1 )
                text_type.push(word_translate.homes);
            

            if (typeProperty.indexOf("1") != -1 )
                text_type.push(word_translate.condominiums);

            if (typeProperty.indexOf("tw") != -1 )
                text_type.push(word_translate.townhouses);

            if (typeProperty.indexOf("mf") != -1 )
                text_type.push(word_translate.multi_family);            

            if(text_type.length==4) {
                $('#text-type').text(word_translate.any_type);
            }else if (typeProperty.length>0){
                $('#text-type').text(text_type.join(', '));
            }else{
                $('#text-type').text(word_translate.any_type);
            }            

        });

        $('#result-search, .result-search').on("click", ".flex-favorite-btn", function(event) {
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
    });
    if (document.getElementById('code-map') === null) {
        return;
    }
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
            zoom: 16,
            disableDoubleClickZoom: true,
            scrollwheel: false,
            panControl: false,
            streetViewControl: false,
            disableDefaultUI: true,
            clickableIcons: false,
            gestureHandling: ("1" == __flex_g_settings.is_mobile) ? 'greedy' : 'cooperative'
        });
        google.maps.event.addListenerOnce(map, 'tilesloaded', setupMapControls);
        flex_ui_loaded = true;
		ib_event_mobile = true; 
		idxboost_filter_countacti = true;
        filter_refresh_search();
        //setupMarkers(filter_metadata.map_items);
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

    function handleDrawButton(event) {
        event.stopPropagation();
        event.preventDefault();
        if (this.classList.contains('flex-map-is-drawing')) {
            google.maps.event.clearListeners(map.getDiv(), "mousedown");
            google.maps.event.removeListener(move);
            stopDrawingMap();
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
        // mapDrawButton = document.createElement("div");
        // mapDrawButton.classList.add('flex-map-draw');
        // mapButtonsWrapper.appendChild(mapDrawButton);
        // setup listeners on buttons
        google.maps.event.addDomListener(mapZoomInButton, "click", handleZoomInButton);
        google.maps.event.addDomListener(mapZoomOutButton, "click", handleZoomOutButton);
        // google.maps.event.addDomListener(mapDrawButton, "click", handleDrawButton);
        // push controls to google map canvas
        map.controls[google.maps.ControlPosition.TOP_RIGHT].push(mapButtonsWrapper);
    }

    function setInitialStateSlider() {
        $("#wrap-result").find(".wrap-slider > ul li:first").each(function() {
            $(this).addClass("flex-slider-current");
        });
    }

        view_options = $(".filter-views li");
        sort_options = $(".flex_idx_sort");

            sort_options.on("change", function() {
                currentfiltemid=$(this).attr('filtemid');
                var current_view = $('#filter-views li.active:eq(0)').html();
                var current_sort = $(this).val();
                // update hidden form
                $('.market_order').val(current_sort);
                $('.market_page').val(1);
                // do ajax
                filter_refresh_search();
                // window.location.href = FILTER_PAGE_URL + "order-" + current_sort + "/view-" + current_view.toLowerCase() + "/page-1";
            });

    function filter_refresh_search() {
        if (flex_ui_loaded === false) {
            return;
        }
        if (idxboost_filter_countacti==false) {
            return false;
        }

        if (ib_event_mobile==false){
            return false;
        }

        var currentfiltemid = $(".flex-idx-filter-form:eq(0)").attr("filtemid");
        var flex_filter_form = $('.flex-idx-filter-form-listing');
        var idxboost_filter_class = flex_filter_form.attr('class');
        idxboost_filter_class = '.flex-idx-filter-form-'+ currentfiltemid;
        var idxboostnavresult ='.idxboost-content-filter-'+currentfiltemid+' #nav-results';
        var idxboostresult ='.idx-off-market-result-search';


        if (flex_filter_form.length) {
            var flex_form_data = flex_filter_form.serialize();
            if(typeof ajax_request_filter !== 'undefined')
            ajax_request_filter.abort();

            ajax_request_filter=$.ajax({
                url: flex_idx_filter_params.ajaxUrl,
                type: "POST",
                data: flex_form_data,
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

                    for (var i = 0, l = items.length; i < l; i++) {
                        var item = response.items[i];
                        var text_is_rental='';
                        if (item.is_rental=='1')
                            text_is_rental='/'+word_translate.month;

                        listingHTML.push('<li data-geocode="' + item.lat + ':' + item.lng + '" data-class-id="' + item.class_id + '" data-mls="' + item.mls_num + '" data-address="'+item.address+'" class="propertie">');
                        if (item.hasOwnProperty("status")) {
                            if (item.status == "5") {
                                listingHTML.push('<div class="flex-property-new-listing">'+word_translate.rented+'</div>');
                            } else if (item.status == "2") {
                                listingHTML.push('<div class="flex-property-new-listing">'+word_translate.sold+'</div>');
                            }
                        } else {
                            if (item.recently_listed === "yes") {
                                listingHTML.push('<div class="flex-property-new-listing">'+word_translate.new_listing+'</div>');
                            }
                        }
                        listingHTML.push('<h2 title="' + item.address + '">' + item.address + '</h2>');
                        listingHTML.push('<ul class="features">');
                        listingHTML.push('<li class="address">' + item.address + '</li>');
                        listingHTML.push('<li class="price">$' + _.formatPrice(item.listing_price) + text_is_rental + '</li>');
                        /*
                        if (item.reduced == '') {
                            listingHTML.push('<li class="pr">' + item.reduced + '</li>');
                        } else if (item.reduced < 0) {
                            listingHTML.push('<li class="pr down">' + item.reduced + '%</li>');
                        } else {
                            listingHTML.push('<li class="pr up">' + item.reduced + '%</li>');
                        }
                        */
                        var textbed = word_translate.bed;
                        if (item.bedrooms > 1) {
                            textbed = word_translate.beds;
                        } else {
                            textbed = word_translate.bed;
                        }
                        listingHTML.push('<li class="beds">' + item.bedrooms + ' <span>' + textbed + ' </span></li>');
                        var textbath = word_translate.bath;
                        if (item.full_bathrooms > 1) {
                            textbath = word_translate.baths;
                        } else {
                            textbath = word_translate.bath;
                        }
                        if (item.half_bath > 0) {
                            listingHTML.push('<li class="baths">' + item.full_bathrooms + '.5 <span>' + textbath + ' </span></li>');
                        } else {
                            listingHTML.push('<li class="baths">' + item.full_bathrooms + ' <span>' + textbath + ' </span></li>');
                        }
                        listingHTML.push('<li class="living-size"> ' + _.formatPrice(item.sqft) + ' '+word_translate.sqft+'</li>');
                        listingHTML.push('<li class="price-sf"><span>$' + item.price_sqft + ' </span>/ '+word_translate.sqft+'</li>');
                        if (item.development !== '') {
                            listingHTML.push('<li class="development"><span>' + item.development + '</span></li>');
                        } else if (item.complex !== '') {
                            listingHTML.push('<li class="development"><span>' + item.complex + '</span></li>');
                        } else {
                            listingHTML.push('<li class="development"><span>' + item.subdivision + '</span></li>');
                        }
                        listingHTML.push('</ul>');
                        var totgallery='';

                        if (item.gallery != null && item.gallery != '' && item.gallery.length <= 1) {
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
                            listingHTML.push('<div class="prev flex-slider-prev" aria-label="Prev" style="cursor:pointer"><span class="clidxboost-icon-arrow-select"></span></div>');
                            listingHTML.push('<div class="next flex-slider-next" aria-label="Next" style="cursor:pointer"><span class="clidxboost-icon-arrow-select"></span></div>');
                        }

                        if (!item.hasOwnProperty("status")) {
                            if (item.is_favorite) {
                                listingHTML.push('<button class="clidxboost-btn-check flex-favorite-btn" aria-label="Remove Favorite"><span class="clidxboost-icon-check active"></span></button>');
                            } else {
                                listingHTML.push('<button class="clidxboost-btn-check flex-favorite-btn" aria-label="Save Favorite"><span class="clidxboost-icon-check"></span></button>');
                            }
                        }

                        listingHTML.push('</div>');
                        listingHTML.push('<a href="'+(flex_idx_filter_params.siteUrl+'/off-market-listing/'+item.property_slug)+'" class="view-detail">'+item.full_address+'</a>');
                        listingHTML.push('<a class="view-map-detail" data-geocode="'+item.lat + ':' + item.lng+'">View Map</a>');
                        listingHTML.push('</li>');
                    }

                    $(idxboostresult).html(listingHTML.join("")).ready(function() {  idxboostTypeIcon();  });
                    $(idxboostnavresult).html(paginationHTML.join(""));
                    $('.flex-loading-ct').fadeIn();

                    var idx_param_url=[];

                    
                    if (response.hasOwnProperty("only_count") && (true === response.only_count)) {
                        var flex_filter_heading = $("#flex-idx-filter-heading_" + currentfiltemid);
                        var flex_filter_heading_tpl = flex_filter_heading.data("heading");
                        flex_filter_heading_tpl = flex_filter_heading_tpl.replace(/\{\{count\}\}/, _.formatPrice(response.counter));
                        flex_filter_heading_tpl = flex_filter_heading_tpl.replace(/\{\{rental\}\}/, (response.info.rental_type == 1 ? " For Rent " : " For Sale "));
                        flex_filter_heading.find("h4").html(flex_filter_heading_tpl);
                        }

                    $("#search_count").val(response.counter);
                    idxboostcondition = response.condition;

                    if (typeof infoWindow !== 'undefined') {
                        if (infoWindow.isOpen()) {
                            infoWindow.close();
                        }
                    }

                    $('#wrap-list-result').show();
                    $('#paginator-cnt').show();
                    jQuery('#form-save .list-check .flex-save-type-options').removeAttr("disabled");
                    // reset scroll
                    if ($('.wrap-result').hasClass('view-map')){
                        $('#wrap-list-result').scrollTop(0);
                    }                    

                    //removeMarkers();
                    $(window).scrollTop($('.clidxboost-sc-filters').offset().top);
                    //setupMarkers(response.items);
                    // check lazy images
                    myLazyLoad.update();
                    setInitialStateSlider();
                    inifil_default=5;
                }
            });
        }
    }

    function idxboost_Hackedbox_cpanel() {
        var ib_object = jQuery('#result-search li.propertie, .result-search li.propertie');
        if(idxboost_hackbox_filter.status)
            if (idxboost_hackbox_filter.result.content != '')                                
                if(ib_object.length<3)
                    ib_object.eq(ib_object.length-1).after('<li class="propertie button_properties"><div class="ppc-content ppc-video-box">'+idxboost_hackbox_filter.result.content+'</div></li>');
                else
                    ib_object.eq(2).after('<li class="propertie button_properties"><div class="ppc-content ppc-video-box">'+idxboost_hackbox_filter.result.content+'</div></li>');            
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
        
        if (typeof map !== "undefined") {
            map.fitBounds(bounds);
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
                    infobox_content.push('<h2 title="' + property_group.address+ '</span></h2>');
                    infobox_content.push('<ul>');
                    infobox_content.push('<li class="address"><span>' + property_group.address + '</span></li>');
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
                    infobox_content.push('</ul>');
                    infobox_content.push('<div class="mapviwe-img">');
                    infobox_content.push('</div>');
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
                if (property.item.bedrooms > 1) {
                    textpropertyitembed = word_translate.beds;
                } else {
                    textpropertyitembed = word_translate.bed;
                }
                if (property.item.full_bathrooms > 1) {
                    textpropertyitembath = word_translate.baths;
                } else {
                    textpropertyitembath = word_translate.bath;
                }
                infobox_content.push('<li class="beds"><b>' + property.item.bedrooms + '</b> <span> ' + textpropertyitembed + '</span></li>');
                infobox_content.push('<li class="baths"><b>' + property.item.full_bathrooms + '</b> <span> ' + textpropertyitembath + '</span></li>');
                infobox_content.push('<li class="living-size"> <span>' + _.formatPrice(property.item.sqft) + '</span> Sq.Ft<span>(' + property.item.living_size_m2 + ' m2)</span></li>');
                infobox_content.push('<li class="price-sf"><span>$' + property.item.price_sqft + ' </span>/ Sq.Ft.<span>($' + property.item.price_sqft_m2 + ' m2)</span></li>');
                infobox_content.push('</ul>');
                infobox_content.push('<div class="mapviwe-img">');
                infobox_content.push('<img title="' + property.item.address_short.replace(/# /, "#") + ', ' + property.item.address_large.replace(/ , /, ", ") + '" alt="' + property.item.address_short.replace(/# /, "#") + ', ' + property.item.address_large.replace(/ , /, ", ") + '" src="' + property.item.gallery[0] + '">');
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
                //console.log($(this).parent('nav ul li'));
                currentfiltemid = $(this).parent('li').parent('ul').parent('nav').attr('filtemid');
                if($(this).attr('id')=='nextn' || $(this).attr('id')=='lastp' || $(this).attr('id')=='firstp' || $(this).attr('id')=='prevn' ) {
                    currentfiltemid=$(this).parent('nav').attr('filtemid');
                }

                $('.nav-results-'+currentfiltemid+' ul#principal-nav li').removeClass('active');
                $('.nav-results-'+currentfiltemid+' ul#principal-nav #page_' + currentPage).addClass('active');
                // history.pushState(null, '', $(this).attr('norefre'));
                $('.flex-idx-filter-form-'+currentfiltemid+' #idx_page').val(currentPage);
                // do ajax
                filter_refresh_search();
                // filter_change_page();
            });
        }

        function update_view_page(evento) {
            $('#nav-results ul#principal-nav li').removeClass('active');
            $('#nav-results ul#principal-nav #page_' + $(evento).attr('page')).addClass('active');
            history.pushState(null, '', $(evento).attr('norefre'));
            $('#idx_page').val($(this).attr('page'));
            // filter_change_page();
        }

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

        var $wrapListResult = $('#wrap-list-result');

        $wrapListResult.on('ps-y-reach-end', _.debounce(function() {
            // next page
            // var has_next_page = $("#flex-idx-search-form").data("next_page");
            var has_next_page = filter_metadata.pagination.has_next_page;
            // var current_page = $("#flex-idx-search-form").data("current_page");
            var current_page = filter_metadata.pagination.current_page_number;
            if ($('#filter-views').find('.map:eq(0)').hasClass('active') && has_next_page == true) {
            }
        }, 800));
    });
    if (typeof search_metadata === 'undefined') {
        return;
    }
    var baths_slider_values = _.pluck(search_metadata.baths_range, 'value');
    var beds_slider_values = _.pluck(search_metadata.beds_range, 'value');
    var sqft_slider_values = _.pluck(search_metadata.living_size_range, 'value');
    var lotsize_slider_values = _.pluck(search_metadata.lot_size_range, 'value');
    var year_built_slider_values = _.pluck(search_metadata.year_built_range, 'value');
    var price_slider_values = _.pluck(search_metadata.price_sale_range, 'value');
    var price_rent_slider_values = _.pluck(search_metadata.price_rent_range, 'value');
    var baths_slider;
    var beds_slider;
    var sqft_slider;
    var lotsize_slider;
    var price_slider;
    var price_rent_slider;
    var year_built_slider;

    //INICIO_FORMULARIO
    $(function() {
        // DOM ready
        // Setup sliders
    $(document).on("click", "#modal_login .close-modal", function(event) {
        event.preventDefault();
        $(".ib-pbtnclose").click();
    });                

    $('.overlay_modal_closer').click(function(){
            event.preventDefault();
            $(".ib-pbtnclose").click();
    });

    });

var IB_SEARCH_FILTER;
IB_SEARCH_FILTER= $('#flex-idx-filter-form');

    $(function() {
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
        flex_ui_loaded = true;
    });
})(jQuery);
(function($) {
    $(function() {
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
    });
})(jQuery);
