var myLazyLoad;

(function($) {
    $(function() {
        if (typeof LazyLoad !== 'undefined') {
            myLazyLoad = new LazyLoad({
                elements_selector: ".flex-lazy-image",
                callback_load: function() {}
            });
            $(document).on("click", "li.grid", function() {
                myLazyLoad.update();
            });

            $(".tabs-btn > li").on("click", function() {
                myLazyLoad.update();
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
        }

    });

    //alert('Ancho: ' + $(window).width() + ' | Alto: ' + $(window).height())
    // Variables Editables:
    var $textThComplet = 'Page % - LISTINGS % to %'; // Éste es el texto que aparecerá en el separador cuando se cargue más items en la vista mapa, de la página 'Search Results'. Ejm: Page 2 - LISTINGS 25 to 48
    //
    var $cuerpo = $('body');
    var $ventana = $(window);
    var $widthVentana = $ventana.width();
    var $htmlcuerpo = $('html, body');
    //alert('Ancho: ' + $ventana.width() + 'px - Alto: ' + $ventana.height() + 'px');
    $ventana.on('load', function() {
        $cuerpo.removeClass('loading');
    });
    // Seleccionador de clases en los filtros.
    var $viewFilter = $('#filter-views');
    if ($viewFilter.length) {
        var $wrapResult = $('#wrap-result');
        // Cambio de vista por SELECT NATIVO
        $viewFilter.on('change', 'select', function() {
            switch ($(this).find('option:selected').val()) {
                case 'grid':
                    $viewFilter.removeClass('list map').addClass('grid');
                    $wrapResult.removeClass('view-list view-map').addClass('view-grid');
                    $cuerpo.removeClass('view-list view-map');
                    break
                case 'list':
                    $viewFilter.removeClass('grid map').addClass('list');
                    $wrapResult.removeClass('view-grid view-map').addClass('view-list');
                    $cuerpo.addClass('view-list').removeClass('view-map');
                    break
                case 'map':
                    $viewFilter.removeClass('list grid').addClass('map');
                    $wrapResult.removeClass('view-list view-grid').addClass('view-map');
                    $cuerpo.removeClass('view-list').addClass('view-map');
                    break
            }
        });
        // Cambio de estado por select combertido a lista
        $viewFilter.on('click', 'li', function() {
            $(this).addClass('active').siblings().removeClass('active');
            switch ($(this).attr('class').split(' ')[0]) {
                case 'grid':
                    $wrapResult.removeClass('view-list view-map').addClass('view-grid');
                    $cuerpo.removeClass('view-list view-map');
                    scrollResultados(false)
                    break
                case 'list':
                    $wrapResult.removeClass('view-grid view-map').addClass('view-list');
                    $cuerpo.addClass('view-list').removeClass('view-map');
                    scrollResultados(false)
                    break
                case 'map':
                    $wrapResult.removeClass('view-list view-grid').addClass('view-map');
                    $cuerpo.removeClass('view-list').addClass('view-map');
                    scrollResultados(true);
                    break
            }
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
                                console.log('ahora cargaré más ITEMS');
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
    var $resultSearch = $('.slider-generator');
    // if ($resultSearch.length) {
    // Agregando a favoritos cada propiedad.
    /*$resultSearch.on('click', '.clidxboost-btn-check', function() {
        // Anclas para trabajar
        var $favoriteLink = $('#link-favorites > a');
        var $nFavorite = $favoriteLink.find('span:eq(1)');
        // Cambiando a active el check
        var $elCheck = $(this).find('span');
        if (!$elCheck.hasClass('active')) {
            $elCheck.addClass('active');
            // Agregando 1 más a 'favoritos'
            if ($favoriteLink.length) { // Habrá páginas en donde no exista el boton de 'favoritos, por eso compruebo su existencia'
                if (Number($nFavorite.text()) == 0) {
                    $nFavorite.text('1');
                    $favoriteLink.addClass('active');
                } else {
                    $nFavorite.text(Number($nFavorite.text()) + 1);
                }
            }
        } else {
            $elCheck.removeClass('active');
            if ($favoriteLink.length) { // Habrá páginas en donde no exista el boton de 
                var $nFavorite = $('#link-favorites a span:eq(1)');
                var restaFavorite = Number($nFavorite.text()) - 1;
                $nFavorite.text(restaFavorite);
                // Quito el active al favorite
                if (restaFavorite == 0) {
                    $favoriteLink.removeClass('active');
                }
            }
        }
    });*/

    // Creando los mini sliders
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
                // activando el el primer frame
                /* Se quita esto, por creación dinámica de ITEMS, (ajax).
                else {
                  // No hay items para q sea slide
                  $miniSlider.find('.next').css('display', 'none');
                  $miniSlider.find('.prev').css('display', 'none');
                }
                */
            };
        }
    }
    // creando el slider por defecto
    //creaMiniSliders();
    // $resultSearch.find('.propertie').each(function() {
    //     apareceImagen($(this).find('.wrap-slider li:eq(0)'));
    // });
    // Agregando función click a .next y .prev al slider interno, preparado para contenido creado dinámicamente
    /*        $('#result-search').on('click', '.next', function(event) {
                event.stopPropagation();
                event.preventDefault();
                var $wrapSlider = $(this).parent();
                var $ulSliderb = $wrapSlider.find('> ul');
                if (!$ulSliderb.hasClass('swiping')) {
                    // variables a usar
                    var $lisSliderb = $ulSliderb.find('> li');
                    var nLisB = $lisSliderb.length;
                    //
                    var $marginLeftUl = $ulSliderb.css('margin-left');
                    if ($marginLeftUl == '0px') {
                        $ulSliderb.addClass('swiping');
                        if ($ulSliderb.hasClass('created')) {
                            $ulSliderb.css('margin-left', '-100%');
                            var $liactive = $lisSliderb.eq(1);
                            apareceImagen($liactive);
                            $liactive.addClass('active');
                            $ulSliderb.removeClass('swiping');
                        } else {
                            $ulSliderb.css('margin-left', '-100%');
                            $wrapSlider.addClass('loading');
                            var $newImages = '';
                            $.each(getGallery($wrapSlider.parent().attr('data-mls'), $wrapSlider.parent().attr('data-counter')), function(i, m) {
                                $newImages = $newImages + '<li><img src="#" data-src="' + m + '" title="#" alt="#"></li>';
                            });
                            // Construyo el slider
                            $ulSliderb.append($newImages);
                            var $lisSlider = $ulSliderb.find('> li');
                            var nLisEx = $lisSlider.length;
                            setTimeout(function() {
                                // creo el slider
                                $ulSliderb.css('width', (nLisEx * 100) + '%');
                                $lisSlider.css('width', (100 / nLisEx) + '%');
                                var $segundoFrame = $lisSlider.eq(1);
                                $segundoFrame.addClass('active');
                                apareceImagen($segundoFrame);
                            }, 500)
                            setTimeout(function() {
                                $wrapSlider.removeClass('loading');
                            }, 1000)
                            $ulSliderb.addClass('created').removeClass('swiping');
                        }
                    } else {
                        var nLiactive = itemActivo($lisSliderb);
                        if ((nLiactive + 1) !== nLisB) {
                            $ulSliderb.addClass('swiping');
                            $ulSliderb.css('margin-left', '-' + ((nLiactive + 1) * 100) + '%');
                            var $liactive = $lisSliderb.eq(nLiactive + 1);
                            apareceImagen($liactive);
                            $liactive.addClass('active').siblings().removeClass('active');
                            $ulSliderb.removeClass('swiping');
                            // Volteo la flecha para indicar que llegué al ultimo.
                            if (nLiactive == (nLisB - 2)) {
                                $(this).addClass('back');
                            }
                        } else {
                            $(this).removeClass('back');
                            $ulSliderb.addClass('swiping');
                            $ulSliderb.css('margin-left', '0');
                            $lisSliderb.eq(nLisB - 1).removeClass('active');
                            $ulSliderb.removeClass('swiping');
                        }
                    }
                }
            });
            $('#result-search').on('click', '.prev', function(event) {
                event.stopPropagation();
                event.preventDefault();
                // vuelve a un estado normal la flecha de 'next' si se tiene volteada.
                var $nextButton = $(this).next('button');
                if ($nextButton.hasClass('back')) {
                    $nextButton.removeClass('back');
                }
                var $ulSliderb = $(this).parent().find('> ul');
                if (!$ulSliderb.hasClass('swiping')) {
                    // variables a usar
                    var $lisSliderb = $ulSliderb.find('> li');
                    var nLisB = $lisSliderb.length;
                    var $marginLeftUl = $ulSliderb.css('margin-left');
                    if ($marginLeftUl != '0px') {
                        var nLiactive = itemActivo($lisSliderb);
                        $ulSliderb.addClass('swiping');
                        $ulSliderb.css('margin-left', '-' + ((nLiactive - 1) * 100) + '%');
                        var $liactive = $lisSliderb.eq(nLiactive - 1);
                        $liactive.addClass('active').siblings().removeClass('active');
                        $ulSliderb.removeClass('swiping');
                        if (nLiactive == 1) {
                            $lisSliderb.eq(0).removeClass('active');
                        }
                    }
                }
            });*/
    // Para mover los mini sliders con touch,
    var xDown = null;
    var yDown = null;
    $resultSearch.on('touchstart', '.propertie', function(evt) {
        xDown = evt.touches[0].clientX;
        yDown = evt.touches[0].clientY;
    });
    $resultSearch.on('touchmove', '.propertie', function(evt) {
        if (!xDown || !yDown) {
            return;
        }
        var xUp = evt.touches[0].clientX;
        var yUp = evt.touches[0].clientY;
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
    // }
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
                    if ($wrapFilters.width() <= 768) {
                        $cuerpo.toggleClass('fixed');
                        // Scrolleo si es necesario.
                        var $SetScrollTop = $wrapFilters.position().top - Number($wrapFilters.css('margin-top').replace('px', ''));
                        if ($ventana.scrollTop() !== $SetScrollTop) {
                            $htmlcuerpo.animate({
                                scrollTop: $SetScrollTop
                            }, 800);
                        }
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
                    } else if ($wrapFilters.width() > 640 && $wrapFilters.width() <= 768) { // mayor a 640 pero menor a 768 pixeles de ancho.
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
                    if ($cuerpo.hasClass('fixed')) {
                        $cuerpo.removeClass('fixed');
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
        $theFilters.find('.mini-search, .save').on('click', function() {
            if ($allFilters.hasClass('visible')) {
                $theFilters.find('.active button').trigger('click');
            }
        });
    }
    // Crea scroll para resultados , si es neighboorhood;
    /*var $neighborhood = $('#neighborhood');
    if ($neighborhood.length) {
        if ($ventana.width() >= 1280) {
            $('#neighborhood').perfectScrollbar({
                suppressScrollX: true,
                minScrollbarLength: '42'
            });
        }
    }*/


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
        });
    }
    // Slider del menu de neighboorhood.
    // analizar, si se necesita convertir en funcion para luego anidar su ejecución permanente al evento .resize
    //if ($neighborhoodMenu.width() >= 700) { // no pongo 768, xq en MAC: (1280), el espacio para el '$neighborhoodMenu' es solo de 720
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
                    //$ulNbhMenu.css('margin-left', '-' + (($menuNbhWidth - $lastItemMenuNbh.position().left) + $lastItemMenuNbh.width()) + 'px');
                    $ulNbhMenu.css('margin-left', (($menuNbhWidth - $lastItemMenuNbh.position().left) + $lastItemMenuNbh.width()) + 'px');
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
    }, 300);
    //}
    // Range de 'All Filters'
    /*  dgt_rangeSlide('#range-price', 0, 50000000, 50000, '#price_from', '#price_to', '$', '', true, 1000000, 250000);
      dgt_rangeSlide('#range-living', 0, 10000, 50, '#living_from', '#living_to', '', 'SF', true);
      dgt_rangeSlide('#range-year', 1900, 2021, 1, '#year_from', '#year_to', '', '', false);
      dgt_rangeSlide('#range-land', 0, 10000, 50, '#land_from', '#land_to', '', 'SF', true);

      dgt_rangeSliderSnap('#range-baths', 0, 10);
      dgt_rangeSliderSnap('#range-beds', 0, 7);*/
    //Inicio de Funciones agregadas el 20/04/2017
    //scrollFixed('#wrap-filters');
    
    widthTitleModal();
    $ventana.resize(function() {
        widthTitleModal();
    });
    /*$(".header-tab a").click(function() {
        var loginHeight = 0;
        $(".header-tab a").removeClass('active');
        $(this).addClass('active');
        var tabId = $(this).attr('data-tab');
        switch (tabId) {
            case 'tabLogin':
                $('#modal_login h2').text(word_translate.welcome_back);
                $(".text-slogan").text(word_translate.sign_in_below);
                break;
            case 'tabRegister':
                $('#modal_login h2').text(word_translate.register);
                $(".text-slogan").text(word_translate.join_to_save_listings_and_receive_updates);
                break;
            case 'tabReset':
                $('#modal_login h2').text(word_translate.welcome_back);
                $(".text-slogan").text(word_translate.sign_in_below);
                break;
        }
        $(".item_tab").removeClass('active');
        $("#" + tabId).addClass('active');
        loginHeight = $("#content-info-modal").height();
        $(".img_modal").css({
            'height': loginHeight + 'px'
        });
    });*/
    var $openCloseMap = $('.map-actions button');
    if (typeof($openCloseMap) != 'undefined') {
        $openCloseMap.on('click', function() {
            $openCloseMap.removeClass('no-show');
            $(this).addClass('no-show');
            $('#wrap-list-result').toggleClass('hidden-results');
        });
    }
    var $bodyHtml = $('html');
    $(document).on('click', '.close-div', function() {
        $('.modal-welcome-login').fadeOut();
    });
    /*$(document).on('click', '.chk_save', function() {
      if (!$(this).find('span').hasClass('active')) {
        $(this).find('span').addClass('active');
      }else{
        $(this).find('span').removeClass('active');
      }
    });*/
    $(document).on('click', '.tab-list li a', function() {
        var idTab = $(this).attr('data-tab');
        $('.tab-list li a').removeClass('active');
        $(this).addClass('active');
        $('.body-tabs .item-tab').hide();
        $('.body-tabs ' + idTab).fadeIn();
    });
    $(document).on('click', '.register', function() {
        $(".header-tab li a").removeClass('active');
        $(".item_tab").removeClass('active');
        $(".header-tab li a[data-tab='tabRegister']").addClass('active');
        $("#tabRegister").addClass('active');
    });
    $(document).on('click', '.login', function() {
        $(".header-tab li a").removeClass('active');
        $(".item_tab").removeClass('active');
        $(".header-tab li a[data-tab='tabLogin']").addClass('active');
        $("#tabLogin").addClass('active');
    });

    /*
    $(document).on('click', '.close-message', function() {
        $(this).parent('.message-alert').fadeOut('fast');
    });

    
    $(document).on('click', '#clidxboost-btn-flight', function() {
        $('#full-slider .wrap-slider li:first-child').trigger("click");
    });

    
    $(document).on('click', '#print-btn', function(e) {
        e.preventDefault();
        var imgPrint = $('#full-slider .wrap-slider li:first-child').html();
        $("#imagen-print").html(imgPrint);
        $("#printMessageBox").fadeIn();
        setTimeout(function() {
            $("#printMessageBox").fadeOut("fast", function() {
                window.print();
            });
        }, 1000);
    });

    
    $(document).on('click', '.option-switch', function() {
        if ($(this).hasClass("active")) {
            return;
        }
        $(".option-switch").removeClass("active");
        $(this).addClass("active");
        var view = $(this).data('view');
        switch (view) {
            case 'gallery':
                $("#map-view").removeClass('active');
                $("#full-slider").removeClass('active');
                break;
            case 'map':
                showMap();
                break;
        }
    });
    $(document).on('click', '#min-map', function() {
        showMap();
    });
    $(document).on('click', '#show-shared', function() {
        $(".shared-content").toggleClass("active");
    });
    function showMap() {
        $("#map-view").addClass('active');
        $(".option-switch").removeClass("active");
        if (!$("#show-map").hasClass("active")) {
            $("#show-map").addClass("active");
            $("#full-slider").addClass('active');
        }
        //mini map
        var flex_map_mini_view = $("#map-result");
        var myLatLng2 = {
            lat: parseFloat(flex_map_mini_view.data('lat')),
            lng: parseFloat(flex_map_mini_view.data('lng'))
        };
        var miniMap = new google.maps.Map(document.getElementById('map-result'), {
            zoom: 16,
            center: myLatLng2,
            mapTypeControlOptions: {
                style: google.maps.MapTypeControlStyle.HORIZONTAL_BAR,
                position: google.maps.ControlPosition.TOP_RIGHT
            }
        });
        var marker = new google.maps.Marker({
            position: myLatLng2,
            map: miniMap
        });
    }*/

    /** FINAL ACTIVAR Y CERRAR LOS MODALES **/
    //if(typeof($elementx) != 'undefined'){
    /*function scrollFixed(conditional) {
        var $conditional = conditional;
        var $element = $($conditional + ".fixed-box");
        var $offset = $element.offset();
        if ($offset != null) {
            var $positionYelement = $offset.top + 100;
            $ventana.scroll(function() {
                var $scrollSize = $ventana.scrollTop();
                if ($scrollSize > $positionYelement) {
                    $cuerpo.addClass('fixed-active');
                } else {
                    $cuerpo.removeClass('fixed-active');
                }
            })
        }
    };*/

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
    /*function apareceImagen(li) {
        var currImage = li.find('> img').eq(0);
        var currImageSrc = $(currImage).attr('data-src');

        console.log(li.find('> img'));
        console.log(currImage);
        console.log(currImageSrc);

        if (currImageSrc.length) {
            li.addClass('loading');
            var newImg = new Image();
            newImg.addEventListener('load', function() {
                li.removeClass('loading');
            }, false);
            newImg.src = currImageSrc;
            currImage.replaceWith(newImg);
        }
    }*/
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
            //Terminar de realizar la validaciÃ³n del Callback --------------------------
            /*
            change: function(){
               console.log('terminar de arrastrar');
               setTimeout( function() {
                  var rangefrom = $( pricefrom).val();
                  var rangeto = $( priceto).val();
                  if( $( pricefrom).val() == rangefrom || $(priceto).val() == rangeto ) {
                     console.log('Daniel: ya cambie');
                  }
               }, 2000);
            }
            */
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

    function dgt_rangeSliderSnap(elementRange, minr, maxr) {
        $(elementRange).slider({
            min: minr,
            max: maxr,
            animate: true,
            range: true,
            values: [minr, maxr]
        });
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

    /************* INICIO FULL SLIDER ******************************************/
    /*var fullSlider = (function(){
      return {
        framesPorSwipe: function(){
          var $widthVentana = $(window).width();
          switch(true) {
            case ($widthVentana < 768):
              return 1;
              break;
            case ($widthVentana >= 768 && $widthVentana < 1024):
              return 2;
              break;
            case ($widthVentana >= 1024):
              return 3;
              break;
          }
        },
        anchoRelativoSlider: function($wrapper, $frames) {
          if (!$wrapper.hasClass('generanding')) {
            $wrapper.addClass('generanding');
            var nframes = $frames.length;
            var $fps = fullSlider.framesPorSwipe(); // sabiendo cuantos items irán
            $wrapper.css('width', ((nframes / $fps) * 100) + '%'); // dando ancho al wrapper
            $frames.css('width', (100 / nframes) + '%'); // dando ancho a los Items
            // reacomodando por redimención
            var $liActive = $wrapper.find('.active');
            if($liActive.length) {
              var $activeIndex = $liActive.index();
              switch($fps) {
                case 1:
                  $wrapper.css('margin-left', '-' + ($activeIndex * 100) + '%');
                  $wrapper.parent().data('frame', ($activeIndex * 100) + 1);
                  break;
                case 2:
                  $wrapper.css('margin-left', '-' + (($activeIndex - 1) * 50) + '%');
                  $wrapper.parent().data('frame', (($activeIndex - 1) * 50));
                  // carga la imagen q se agrego al viewport
                  if ($activeIndex == 0) fullSlider.loadNextImage($frames.eq(1));
                  break;
                case 3:
                  $wrapper.css('margin-left', '-' + (($activeIndex - 2) * 33.33) + '%');
                  $wrapper.parent().data('frame', (($activeIndex - 2) * 33.33) + 1);
                  // carga las imagenes q se agregaron al viewport
                  if ($activeIndex == 0) fullSlider.cargarImgLi($frames, 1, 3);
                  if ($activeIndex == 1) fullSlider.loadNextImage($frames.eq(2));
                  break;
              }
            } else {
              $wrapper.parent().data('frame', 1);
            }
            // quitando el pause de transición
            setTimeout(function(){
              $wrapper.removeClass('generanding');
            }, 1500);
          }
        },
        loadNextImage: function($theLi){
          var $imagenACargar = $theLi.find('img');
          var $dataBlazy = $imagenACargar.attr('data-blazy');
          if ($dataBlazy !== undefined) {
            $imagenACargar.attr('src', $dataBlazy).removeAttr('data-blazy');
            $theLi.addClass('loading');
            $imagenACargar.one('load', function(){
              $theLi.removeClass('loading');
            });
          }
          // marcando la imagen guía para redirecciòn
          $theLi.addClass('active').siblings().removeClass('active');
        },
        cargarImgLi: function($frames, indexLi, totalLis){
          if (indexLi !== totalLis) {
            var $liImagen = $frames.eq(indexLi);
            $liImagen.addClass('active').siblings().removeClass('active');// marcando la imagen guía para redirecciòn
            var $imagenACargar = $liImagen.find('img');
            var $dataBlazy = $imagenACargar.attr('data-blazy');
            if ($dataBlazy !== undefined) {
              $imagenACargar.attr('src', $dataBlazy).removeAttr('data-blazy');
              $liImagen.addClass('loading');
              $imagenACargar.one('load', function(){
                $liImagen.removeClass('loading');
                fullSlider.cargarImgLi($frames, indexLi + 1, totalLis)
              });
            } else {
              fullSlider.cargarImgLi($frames, indexLi + 1, totalLis)
            }
          }
        },
        showMap: function($fsContainer){
          $fsContainer.find(".map-view").addClass('active');
          $fsContainer.find(".option-switch").removeClass("active");
          var $showMap = $fsContainer.find(".show-map");
          if (!$showMap.hasClass("active")) {
            $showMap.addClass("active");
            $fsContainer.addClass('active');
          }

          //mini map
          var $mapFS = $fsContainer.find(".map-result");
          if(!$mapFS.hasClass('built')) {
            var myLatLng2 = {
              lat: parseFloat($mapFS.data('lat')),
              lng: parseFloat($mapFS.data('lng'))
            };
            var $idResultMap = $mapFS.attr('id');
            var miniMap = new google.maps.Map(document.getElementById($idResultMap), {
              zoom: 16,
              center: myLatLng2,
              mapTypeId: google.maps.MapTypeId.ROADMAP,
              mapTypeControl: false,
              mapTypeControlOptions: {
                position: google.maps.ControlPosition.BOTTOM_LEFT
              },
            });
            var marker = new google.maps.Marker({
              position: myLatLng2,
              map: miniMap
            });
            $mapFS.addClass('built').removeAttr('data-lat data-lng');
          }
        },
        withoutLis: function($fsContainer){
          var $wrapperSlider = $fsContainer.find('.wrap-slider');
          var $lisSlider = $wrapperSlider.find('li');
          if(!$lisSlider.length){ // si no hay LIS, nos vamos a la vista mapa.
            return true;
          } else { // Si tenemos LI (imágenes)
            // Verificando si la primera imagen es 'comming soon' para pasar a la 'vista mapa'
            var $firstLiImg = $lisSlider.eq(0).find('img');
            var $theDataBlazy = $firstLiImg.attr('data-blazy'); 
            var $theSrcImg = $firstLiImg.attr('src');
            if($theSrcImg == undefined) { // existe el SRC, veamos si es una
              if($theDataBlazy != undefined) {
                if ($theDataBlazy == dgtCredential.imgComingSoon) {
                  return true;
                } else {
                  return false;
                }
              } else {
                console.log('Existe una imagen sin SRC y sin data blazy, no se puede definir si es coming soon');
                return false;
              } 
            }
          }
        },
        init: function($fsContainer){
          if($fsContainer.length && !$fsContainer.hasClass('built')){
            if(!fullSlider.withoutLis($fsContainer)) { // si hay imagenes que no son 'coming soon' en el slider.
              var $wrapperSlider = $fsContainer.find('.wrap-slider');
              var $frames = $wrapperSlider.find('li');
              if ($frames.length > 1) {
                fullSlider.anchoRelativoSlider($wrapperSlider.find('ul'), $frames);
                // Cargando por demanda las imagenes correspondientes:
                fullSlider.cargarImgLi($frames, 0, fullSlider.framesPorSwipe());
                // Marcando el contenedor indicando q yà se construyò el slider
                setTimeout(function(){
                  $fsContainer.addClass('built'); 
                }, 1500);
                // Redimencionado el wrapper de los frames
                $(window).on('resize', function(){
                  var $theUlwrap = $wrapperSlider.find('ul');
                    fullSlider.anchoRelativoSlider($theUlwrap, $frames);
                });
                //
              } else {
                $wrapperSlider.find('.next, .prev').remove();
                fullSlider.cargarImgLi($frames, 0, fullSlider.framesPorSwipe());
              }
              $fsContainer.removeClass('wo-images');
            } else {
              $fsContainer.addClass('wo-images');
              setTimeout(function(){
                $fsContainer.find('.option-switch[data-view="map"]').trigger('click');
              }, 1000);
            }
          }
        }
      }
    })();

    fullSlider.init($('#full-slider'));*/

    // Anida globalmente la activacion del modal de 'full screen'
    /*$(document).on('click', '.full-screen', function() {
      var $wrapperSlider = $(this).parents('#full-slider').find('.wrap-slider');
      var $dataFrame = Number($wrapperSlider.data('frame'));
      var $frames = $wrapperSlider.find('ul > li');
      var liToClick;
      switch(fullSlider.framesPorSwipe()) {
        case 1:
          liToClick = ($dataFrame - 1) / 100;
          break;
        case 2:
          ($dataFrame == 1) ? liToClick = 1 : liToClick = ($dataFrame / 50) + 1;
          break;
        case 3:
          ($dataFrame == 1) ? liToClick = 2 : liToClick = Math.floor(($dataFrame / 33.33) + 2)
          break;
      }

      $frames.eq(liToClick).trigger("click");
    });*/

    /*var $modalImageProperty = $('#modal_img_propertie');
    if ($modalImageProperty.length) {
      // Bindeando globalmente a los Li de cualquier Full slider
      $('body').on('click', '#full-slider .wrap-slider li, #list-floorplan li', function(){
        var $itemIndex = $(this).index(); //Elemento de la lista al que se hizo clic
        var $itemAll = $(this).parent().find('li')
        var $itemLength = $itemAll.length;
        var $ptBuilding = $('#pt-building');
        // Creando el array de imagenes que creará el slider modal.
          var $theImgs = [];
          // Cuando es un lista de 'Floor Plans'
          var $dataImg = $(this).attr('data-img');
          if ($dataImg !== undefined) {
            $modalImageProperty.addClass("cr-floorplan");
            var $theImgs = [];
            $itemAll.each(function(){
              $theImgs.push($(this).attr('data-img'));
              //$(this).removeAttr('data-img'); q se quede para ser identificable luego.
            });
          // Cuando es una lista del 'Full Slide'
          } else { 
            $modalImageProperty.removeClass("cr-floorplan pt-building");
            // creando el array de imagenes, las yá cargadas y las por cargar (las que tienen carga por demanda).
            $itemAll.each(function(){
              var $img = $(this).find('img');
              var $imgDB = $img.attr('data-blazy');
              ($imgDB == undefined) ? $theImgs.push($img.attr('src')) : $theImgs.push($imgDB);
            });
            // identificando un slider de 'building detail'
            if($ptBuilding.length) $modalImageProperty.addClass('pt-building');
          }
        //
        $modalImageProperty.data('imagenes', $theImgs.join());
        $modalImageProperty.data('indeximg', $itemIndex + 1);
        // Insertando los datos de la propiedad en el modal
        var $modalTitle = $modalImageProperty.find('.title');
        $modalTitle.attr('data-titlebk', $modalTitle.html().trim()); // haciendo BK del texto del título para luego restaurarlo.
        var $titleModalPD = $modalTitle.find('span').text();
        var $fullMain = $(this).parents('#full-main');
        var titleObj = {};
        var $dataInf = $fullMain.find('.property-information').attr('data-inf');
        if($dataInf !== undefined) {
          $dataInf = $dataInf.split('|');
          $.each($dataInf, function(i, v){
            var key = v.split(':')[0];
            var val = v.split(':')[1]
            if(key == 'price') {
              val = val.replace(/\B(?=(\d{3})+(?!\d))/g, ",")
            }
            $titleModalPD = $titleModalPD.replace('%' + key + '%', val);
          });
          $modalImageProperty.find('.title span').text($titleModalPD);
        } else {
          if(!$ptBuilding.length) console.error('* Missing data-inf attribute, with data needed to show modal_img');
        }
        
        // Insertando numeración e imagen clickeada
        var $wrapperImg = $modalImageProperty.find('.wrapper-img');
        // Poniendo la numeración
        var $numeration = $wrapperImg.find('.numeration');
        $numeration.find('span').eq(0).text($itemIndex + 1);
        $numeration.find('span').eq(1).text($itemLength);
        // Insertando url de imagen
        $wrapperImg.find('.img').attr('src', $theImgs[$itemIndex]);
        // Quitando o poniendo el opacity dependiendo del index del LI al que se hizo click
        var $buttonPrevMDP = $modalImageProperty.find('.prev');
        ($itemIndex) ? $buttonPrevMDP.removeClass('opacity') : $buttonPrevMDP.addClass('opacity');
        // Mostrando modal
        $modalImageProperty.addClass('active_modal');
      });

      // Navegación 'Next y Prev'
      $('body').on('click', '#modal_img_propertie .nav', function(){
        // armando el objeto
        var $imgList = $modalImageProperty.data('imagenes');
        if($imgList == undefined) {
          alert('Missing the "data:imagenes" attribute HTML5, in the element "#modal_img_propertie"');
          return false;
        } 
        var $imgArray = $imgList.split(','); // objeto de imagenes
        var $imgWrapper = $modalImageProperty.find('.wrapper-img');

        var $imgCurrent = $imgWrapper.find('.img'); // contenedor de la imagen actual
        var $imgCurrentIndex = Number($modalImageProperty.data('indeximg'));
        var $numeration = $imgWrapper.find('.numeration');
        var $buttonPrev = $(this).parent().find('.prev');

        // Detectando si es siguiente o anterior
        if ($(this).hasClass('next')) { // Click en NEXT
          if($imgCurrentIndex !== $imgArray.length) {
            $modalImageProperty.data('indeximg', $imgCurrentIndex + 1); // Aumentando el data ancla
            $numeration.find('span').eq(0).text($imgCurrentIndex + 1); // aumentando la numeraciòn en el bloque negro (Ejm: 3 - 55)
            $imgCurrent.attr('src', $imgArray[($imgCurrentIndex)])
            $imgWrapper.addClass('loading')
            $imgCurrent.on('load', function(){
              $imgWrapper.removeClass('loading');
            }).on('error', function(){
              $imgWrapper.removeClass('loading');
              $imgCurrent.attr('src', dgtCredential.imgComingSoon);
            });
            // Desopacitando el boton prev
            if ($buttonPrev.hasClass('opacity')) $buttonPrev.removeClass('opacity');
          } else {
            $imgCurrent.attr('src', $imgArray[0]);
            $numeration.find('span').eq(0).text('1');
            $buttonPrev.addClass('opacity');
            $modalImageProperty.data('indeximg', 1);
          }
        } else { // Click en PREV
          if ($imgCurrentIndex !== 1) {
            $numeration.find('span').eq(0).text($imgCurrentIndex - 1);
            $imgCurrent.attr('src', $imgArray[$imgCurrentIndex - 2]);
            $modalImageProperty.data('indeximg', $imgCurrentIndex - 1);
          }

          if ($imgCurrentIndex == 2) $buttonPrev.addClass('opacity');
        }
      });
      
      // Bindeando al touch en mobile del modal img propertie, anidado al FS
      var xDownb = null, yDownb = null;
      $('body').on('touchstart', '#modal_img_propertie', function(evt){
        xDownb = evt.touches[0].clientX;
        yDownb = evt.touches[0].clientY;
      });
      $('body').on('touchmove', '#modal_img_propertie', function(evt) {
        if ( ! xDownb || ! yDownb ) {
          return;
        }
        var xUp = evt.touches[0].clientX;
        var yUp = evt.touches[0].clientY;
        var xDiff = xDownb - xUp;
        var yDiff = yDownb - yUp;
        if ( Math.abs( xDiff ) > Math.abs( yDiff ) ) { // si se mueve derecha o izquierda
          if ( xDiff > 0 ) { // izquierda
            $(this).find('.next').trigger('click');
          } else { // derecha
            $(this).find('.prev').trigger('click');
          }
        }
        xDownb = null;
        yDownb = null;
      });

      //Cierra modal de imagen de detalle de propiedad
      $('body').on('click', '#modal_img_propertie .close-slider-modal', function(){
        var $modalTitle = $modalImageProperty.find('.title');
        var $titlebk = $modalTitle.attr('data-titlebk');
        if($titlebk !== undefined) {
          $modalTitle.html($titlebk);
          $modalTitle.removeAttr('data-titlebk');
        }
        $modalImageProperty.removeClass('active_modal');
      });

      // Binbeando teclas de navegación y de cierre
      $('body').on('keyup', function(e) {
        // Flechas,
        if($modalImageProperty.hasClass('active_modal')) {
          if (e.keyCode === 39) { // NEXT
            $modalImageProperty.find('.nav.next').trigger('click');
          }
          if (e.keyCode === 37) { // PREV
            $modalImageProperty.find('.nav.prev').trigger('click');
          }
        }
      });
      // Bindeando el cierre con 'Esc'
      $('body').on('keyup', function(e) {
        if($modalImageProperty.hasClass('active_modal')) {
          // Tecla Escape
          if (e.keyCode === 27){
            $modalImageProperty.find('.close-slider-modal').trigger('click');   // cierro la galería
          }
        }
      });
    }*/

    // Dando funcionalidad global a los botones de next y prev
    /*$('body').on('click', '#full-slider .wrap-slider button', function(){ // BOTON NEXT
      var $wrapperSlider = $(this).parent();
      var $dataFrame = Number($wrapperSlider.data('frame'));
      var $wrapperFrames = $wrapperSlider.find('ul');
      var $frames = $wrapperSlider.find('li');
      var nframes = $frames.length;
      var $lisATomar = fullSlider.framesPorSwipe();
      if ($(this).hasClass('next')) { // CLICK EN NEXT
        switch($lisATomar) {
          case 1:
            if (($dataFrame - 1) !== ((nframes - 1) * 100)) {
              $wrapperFrames.css('margin-left', '-' + (($dataFrame - 1) + 100) + '%');
              $wrapperSlider.data('frame', ($dataFrame + 100));
              // Carga por demanda
              ($dataFrame == 1) ? fullSlider.loadNextImage($frames.eq($dataFrame)) : fullSlider.loadNextImage($frames.eq((($dataFrame - 1) / 100) + 1));
            } else {
              $wrapperFrames.css('margin-left', '0');
              $wrapperSlider.data('frame', 1);
              fullSlider.loadNextImage($frames.eq(0)); // para darme el active class
            }
            break;
          case 2:
            if ($dataFrame !== ((nframes * 50) - 100)) {
              if ($dataFrame == 1) {
                $wrapperFrames.css('margin-left', '-50%');
                $wrapperSlider.data('frame', 50);
                fullSlider.loadNextImage($frames.eq(2));
              } else {
                $wrapperFrames.css('margin-left', '-' + ($dataFrame + 50) + '%');
                $wrapperSlider.data('frame', $dataFrame + 50);
                fullSlider.loadNextImage($frames.eq(($dataFrame / 50) + 2));
              }
            } else {
              $wrapperFrames.css('margin-left', '0');
              $wrapperSlider.data('frame', 1);
              fullSlider.loadNextImage($frames.eq(1)); // para darme el active class
            }
            break;
          case 3:
            if ($dataFrame <= ((nframes * 33.33) - 100)) {
              $wrapperFrames.css('margin-left', '-' + (($dataFrame - 1) + 33.33) + '%');
              $wrapperSlider.data('frame', $dataFrame + 33.33);
              // Carga por demanda
              ($dataFrame == 1) ? fullSlider.loadNextImage($frames.eq(3)) : fullSlider.loadNextImage($frames.eq(Math.floor(($dataFrame / 33.33) + 3)));
            } else {
              $wrapperFrames.css('margin-left', '0');
              $wrapperSlider.data('frame', 1);
              fullSlider.loadNextImage($frames.eq(2)); // para darme el active class
            }
            break;
        }
      } else if ($(this).hasClass('prev')) { // elseif xq pueda q exista otro button XD;
        if ($dataFrame !== 1 && $dataFrame !== 0) {
          switch($lisATomar) {
            case 1:
              $wrapperFrames.css('margin-left', '-' + (($dataFrame - 1) - 100) +'%');
              $wrapperSlider.data('frame', '' + ($dataFrame - 100) + '');
              break;
            case 2:
              $wrapperFrames.css('margin-left', '-' + ($dataFrame - 50) + '%');
              $wrapperSlider.data('frame', $dataFrame - 50);
              break;
            case 3:
              $wrapperFrames.css('margin-left', '-' + (($dataFrame - 1) - 33.33) + '%');
              $wrapperSlider.data('frame', $dataFrame - 33.33);
              break;
          }
          fullSlider.loadNextImage($frames.eq($wrapperSlider.find('.active').index() - 1)); // para darme el active class
        }
      }
    });*/

    // Touch para FULL SLIDER
    /*var xDown = null, yDown = null;
    $('body').on('touchstart', '#full-slider .wrap-slider', function(evt){
      xDown = evt.touches[0].clientX;
      yDown = evt.touches[0].clientY;
    });
    $('body').on('touchmove', '#full-slider .wrap-slider', function(evt) {
      if ( ! xDown || ! yDown ) {
        return;
      }
      var xUp = evt.touches[0].clientX;
      var yUp = evt.touches[0].clientY;
      var xDiff = xDown - xUp;
      var yDiff = yDown - yUp;
      if ( Math.abs( xDiff ) > Math.abs( yDiff ) ) { // si se mueve derecha o izquierda
        if ( xDiff > 0 ) { // izquierda
          $(this).find('.next').trigger('click');
        } else { // derecha
          $(this).find('.prev').trigger('click');
        }
      }
      xDown = null;
      yDown = null;
    });*/

    /************* FINAL FULL SLIDER ******************************************/
    
    /*var items = $('.scroll-tab-list').width();
    if (typeof(items) != 'undefined') {
        var itemSelected = document.getElementsByClassName('scroll-item');
        countriesPointerScroll($(itemSelected));
        $(".scroll-tab-list").scrollLeft(200).delay(200).animate({
            scrollLeft: "-=200"
        }, 2000, "easeOutQuad");
        if (!/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent)) {
            var scrolling = false;
            $(".paddle-right").bind("mouseover", function(event) {
                scrolling = true;
                scrollContent("right");
            }).bind("mouseout", function(event) {
                scrolling = false;
            });
            $(".paddle-left").bind("mouseover", function(event) {
                scrolling = true;
                scrollContent("left");
            }).bind("mouseout", function(event) {
                scrolling = false;
            });

            function scrollContent(direction) {
                var amount = (direction === "left" ? "-=3px" : "+=3px");
                $(".scroll-tab-list").animate({
                    scrollLeft: amount
                }, 1, function() {
                    if (scrolling) {
                        scrollContent(direction);
                    }
                });
            }
        }
        $('.scroll-tab-list .scroll-item').click(function() {
            $('.scroll-tab-list').find('.active').removeClass('active');
            $(this).addClass("active");
        });
    }

    function countriesPointerScroll(ele) {
        var parentScroll = $(".scroll-tab-list").scrollLeft();
        var offset = 0;
        var totalelement = offset + $(ele).outerWidth() / 2;
    }

    function activeScroll() {
        var widthItem, sumaItem = 0;
        $(".scroll-tab-list .scroll-item").each(function() {
            widthItem = $(this).innerWidth();
            sumaItem = sumaItem + widthItem;
        });
        var widthWrapperScroll = $(".wrapper-scroll-tab").width();
        if (sumaItem > widthWrapperScroll) {
            $(".wrapper-scroll-tab").addClass('active');
        } else {
            $(".wrapper-scroll-tab").removeClass('active');
        }
    }
    activeScroll();
    $(window).resize(function() {
        activeScroll()
    });*/

    /*$(document).on('click', '.list-details h2', function() {
      if (!$(this).hasClass('no-tab')) {
        var $theLi = $(this).parent();
        var $theUl = $(this).next();
        if ($theLi.hasClass('active')) { // si está abierto
            $theLi.removeClass('active');
            $theUl.removeClass('show')
        } else { // si está cerrado
            $theLi.addClass('active');
            $theUl.addClass('show');
        }
      }
    });*/

    // Boton 'close modal' de 'propertie_img_modal'
    /*$('#modal_img_propertie .close-modal button').click(function(){
        $('#modal_img_propertie .overlay_modal_closer').trigger('click');
    });*/

}(jQuery));
