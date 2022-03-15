var ajax_request_filter;
var myLazyLoad;
var IB_COMMERCIAL = $("#ib-template-property"); 
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

var scrollTopElement = $(".clidxboost-sc-filters");
if(scrollTopElement.length){
	scrollTopElement = (($(".clidxboost-sc-filters").offset().top) * 1) - 100;
}else{
	scrollTopElement = 0;
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
});

Handlebars.registerHelper('paginationBlock', function(paging) {
	console.log(paging);
	var paginationHTML=[];
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
		if (paging.current_page_number === loopPage) {
			paginationHTML.push('<li class="active"><a href="#" data-page="' + loopPage + '">' + loopPage + '</a></li>');
		} else {
			paginationHTML.push('<li><a href="#" data-page="' + loopPage + '">' + loopPage + '</a></li>');
		}
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
	return '<h2 title="' + property.full_address + '" class="ms-property-address"><div class="ms-title-address -address-top">'+property.full_address_top+'</div><div class="ms-br-line">,</div><div class="ms-title-address -address-bottom">'+property.full_address_bottom+'</div></h2>';
});

Handlebars.registerHelper('DFhandleOhContent', function(property) {
	if (property.hasOwnProperty("oh_info") && property.oh_info != null ) {
		var oh_info=JSON.parse(property.oh_info);
		if (typeof(oh_info) === "object" && oh_info.hasOwnProperty("date") && oh_info.hasOwnProperty("timer") ) {
			return '<div class="ms-open"><span class="ms-wrap-open"><span class="ms-open-title">Open House</span><span class="ms-open-date">'+oh_info.date+'</span><span class="ms-open-time">'+oh_info.timer+'</span></span></div>';
		}                          
	}
});


Handlebars.registerHelper('DFhandleFormatAddress', function(property) {
	var al = property.address_large.split(", ");
	return " <span>"+ property.address_short.replace(/# /, "#") +", " + al[0] + ", " + al[1] + "</span>";
});


Handlebars.registerHelper('DFformatPrice', function(price) {
	return "$" + _.formatPrice(price);
});

Handlebars.registerHelper('DFrentalType', function(rentalType) {
	var text_is_rental='';
	if (rentalType=='1')
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

	    if (property.hasOwnProperty("status")) {
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

	function filter_refresh_search() {
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

					if (paging.total_pages_count > 1) {
						contentPage={ pagination: response.pagination };
					}

					var contentData = {
				      properties:response.items
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
					$("html, body").animate({ scrollTop: scrollTopElement }, 0);

				  $('#info-subfilters').html(word_translate.showing+' ' +paging.offset.start+' '+word_translate.to+' ' +paging.offset.end+' '+word_translate.of+' '+ _.formatPrice(response.counter)+' '+word_translate.properties+'.');
					myLazyLoad.update();
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

		$("#result-search, .result-search-commercial").on("click", ".view-detail", function(event) {
			event.stopPropagation();
			event.preventDefault();
			var mlsNumber = $(this).parent('li').data('mls')
			loadPropertyInModal(mlsNumber);
		});

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