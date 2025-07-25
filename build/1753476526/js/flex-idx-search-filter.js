var is_search_filter_viewed = false;

var initial_title;
var initial_href;
var dataAlert;

var disableSearchEvent = false;

function ib_local_ovewrite_ptypes(ptypes) {
	var r = [];

	for (var i = 0, l = ptypes.length; i < l; i++) {
		if (2 == ptypes[i]) {
			r.push({ label: "Single Family Home", value: 2 });
		}
		if (1 == ptypes[i]) {
			r.push({ label: "Condominiums", value: 1 });
		}
		if ("tw" == ptypes[i]) {
			r.push({ label: "Townhouses", value: "tw" });
		}
		if ("mf" == ptypes[i]) {
			r.push({ label: "Multi-Family", value: "mf" });
		}
		if ("valand" == ptypes[i]) {
			r.push({ label: "Vacant Land", value: "valand" });
		}
	}

	return r;
}

if (typeof IS_SEARCH_FILTER_CARROUSEL !== "undefined") {
	var myLazyLoad;
}

if (typeof originalPositionY === "undefined") {
	var originalPositionY;
}

var IB_HAS_LEFT_CLICKS = (__flex_g_settings.hasOwnProperty("signup_left_clicks") && (null != __flex_g_settings.signup_left_clicks));
var IB_CURRENT_LEFT_CLICKS;

var current_year = (new Date()).getFullYear();

//delete feature hopa
if ([1,2,3].includes(parseFloat(__flex_idx_search_filter.boardId) ) ===false ) {
	
	var item_dele=__flex_idx_search_filter.search.amenities.map(function(item){
		return item.code
	}).indexOf('hopa');
	__flex_idx_search_filter.search.amenities.splice(item_dele,1);
}
//delete feature hopa

// if (true === IB_HAS_LEFT_CLICKS) {
//     var IB_DEFAULT_LEFT_CLICKS = parseInt(__flex_g_settings.signup_left_clicks, 10);
//     var IB_CURRENT_LEFT_CLICKS = parseInt(__flex_g_settings.signup_left_clicks, 10);
// }

// fix for gmap dragEnd, zoomEnd
var get_off_market_position=0;
var tot_oml_item=0;

var countClickAnonymous = 0;

var idleListener;

var IB_USER_IS_DRAWING = false;
var IB_TRACKING_IFRAME;

var ib_xhr_handler;
var ib_xhr_running = false;
var IB_IS_SEARCH_FILTER_PAGE = true;
var IB_GMAP_INIT = false;
var IB_GMAP_FINISHED_POLYGON = false;
var IB_GMAP_BOUNDS_LOADED = false;

// for schools information
var size_li_actives = 0;
var size_li_actives_X = 0;
var size_li = 0;

var IB_GMAP_FIT_TO_BOUNDS = true;

var IB_MAP;
var IB_HIDDEN_BOUNDS;
var IB_LOOKUP_DRAG = false;
var IB_RECTANGLE;
var IB_LAST_OPENED_MARKER;

var ib_min_price;
var ib_max_price;

var ib_min_rent_price;
var ib_max_rent_price;

var ib_min_beds;
var ib_max_beds;

var ib_min_baths;
var ib_max_baths;

var ib_m_types;

var ib_m_parking;

var ib_min_living;
var ib_max_living;

var ib_min_land;
var ib_max_land;

var ib_min_year;
var ib_max_year;

var ib_waterfront_switch;

var ib_m_features;

var ib_m_features_exta;

var IB_IS_FIRST_LOAD = true;

var style_map=[];

var ib_moreFilter = {};
var moreFilterHidden = {};

if(style_map_idxboost != undefined && style_map_idxboost != '') {
	style_map=JSON.parse(style_map_idxboost);
}

(function ($) {

_.mixin({
	formatPrice: function(value, n, x, d, c, s, p) {
		var re = '\\d(?=(\\d{' + (x || 3) + '})+' + (n > 0 ? '\\D' : '$') + ')',
			num = Number(value).toFixed(Math.max(0, ~~n));
	
		return (s && p ? s : '') + (c ? num.replace('.', c) : num).replace(new RegExp(re, 'g'), '$&' + (d || ',')) + (s && !p ? s : '');
	},
	formatShortPrice: function (value) {
		var price = Number(value),
			short_price;
		
		if (price < 1000) {
			return price;
		}
		
		if (price < 10000) {
			short_price = Math.ceil(price / 100) / 10;
			
			return short_price + 'K';
		} else {
			if (price < 1000000) {
				short_price = Math.ceil(price / 1000);
				
				if (short_price < 100) {
					return String(short_price).substr(0, 2) + 'K';
				}
				
				if (short_price >= 1000) {
					return '1M';
				}
				
				return short_price + 'K';
			} else {
				if (price < 10000000) {
					short_price = Math.ceil(price / 10000) / 100;
				} else {
					short_price = Math.ceil(price / 100000) / 10;
				}
			}
		}
		
		if (String(short_price, '.') !== -1) {
			short_price = String(short_price).substr(0, 4);
		}
		
		return short_price + 'M';
	},
	getMLSImage: function(mls_num, image) {
		var base_url = 'https://retsimages.s3.amazonaws.com';
		var path = mls_num.substr(-2);
		
		return [base_url, path, image].join("/");
		
	},
	getMLSListImage: function(mls_num, image, index) {
		var base_url = 'https://retsimages.s3.amazonaws.com';
		var path = mls_num.substr(-2);
		
		return [base_url, path, mls_num].join("/") + "_" + index + ".jpg";
	}
});

Handlebars.registerHelper('capturePositionHackbox', function(index) {
	var html_market=[];

	if (typeof __flex_idx_search_filter.list_offmarket.status !== "undefined"  ){
		
		tot_oml_item=parseInt(__flex_idx_search_filter.list_offmarket.tot_item);

		html_market.push('<li class="ib-pitem"><div class="ib-pislider gs-container-slider gs-loaded" id="collection-markert">');
		__flex_idx_search_filter.list_offmarket.data.forEach(function(item){
			html_market.push('<div class="ib-item"><img class="ib-pifimg" src="'+item.image+'" alt="'+item.address+'"><h3 class="ib-title">'+item.address+'</h3><div class="ib-wrap-btn"><a target="_blank" href="" class="ib-mr-link idx_view_collection_market"><span>View Collection</span></a> <a target="_blank" href="https://management.urbanresource.com/page-property/'+item.property_id+'" class="ib-mr-link idx_view_detail_market"><span>'+word_translate.details+'</span></a></div></div>');
		});
		html_market.push('<div class="gs-navs-off-market"><div class="gs-om-arrows"><button class="gs-om-prev-arrow btn_prev_item" method="prev"></button><button class="gs-om-next-arrow btn_next_item" method="next"></button></div></div><span class="ib-label">Managed by Urban Resource</span></div></li>');
	}    

	if (1 == IB_SEARCH_FILTER.attr("data-count")) {
		if (html_market.length > 0){
			return html_market.join('');
		}else{
			if (__flex_idx_search_filter.hackbox.content.length) {
				return '<li class="ib-pitem ib-pitem-marketing">' + __flex_idx_search_filter.hackbox.content + '</li>';
			} else {
				return "";
			}
		}
		
	} else {
		if ((0 === index) && ("" != __flex_idx_search_filter.hackbox.content) ) {
			if (html_market.length > 0){
				return html_market.join('');
			}else{
				if (__flex_idx_search_filter.hackbox.content.length) {
					return '<li class="ib-pitem ib-pitem-marketing">' + __flex_idx_search_filter.hackbox.content + '</li>';
				} else {
					return "";
				}
			}            
		} else {
			return "";
		}
	}
});

Handlebars.registerHelper('formatBathsHalf', function(baths_half) {
	if (baths_half > 0) {
		return ".5";
	} else {
		return "";
	}
});

Handlebars.registerHelper('handleStatusProperty', function(property) {
	if ("yes" === property.recently_listed || property.min_ago_txt !="" ) {
		if (property.min_ago > 0 && property.min_ago_txt !="" ) {
			return '<li class="ib-piitem ib-pstatus">'+property.min_ago_txt+'</li>';
		}else{
			return '<li class="ib-piitem ib-pstatus">'+word_translate.new_listing+'</li>';
		}
	} else if (1 != property.status) {
		return '<li class="ib-piitem ib-pstatus">'+property.status_name+'</li>';
	}
});

Handlebars.registerHelper('formatPrice', function(price) {
	return "$" + _.formatPrice(price);
});

Handlebars.registerHelper('rentalType', function(rentalType) {
	return ("1" == rentalType) ? word_translate.similar_properties_for_rent :  word_translate.Similar_properties_for_sale;
});

Handlebars.registerHelper('formatSqft', function(sqft) {
        if ( ![null,"",undefined,"undefined",0,"0"].includes( sqft ) ){
            return _.formatPrice(sqft);
        }else{
            return "N/A";
        }
        
    });

Handlebars.registerHelper("idxPermalinkModal", function(slug) {
	return __flex_idx_search_filter.propertyDetailPermalink + "/" + slug;
});

Handlebars.registerHelper("idxPermalink", function(property) {
	return __flex_idx_search_filter.propertyDetailPermalink + "/" + property.slug;
});

    Handlebars.registerHelper('formatAcres', function(inputval,metodo = null) {
        if ( ![null,"",undefined,"undefined",0,"0"].includes( inputval ) ){
            inputval= parseFloat( inputval.replaceAll(',',''));
            if (inputval >= 20000) {
                if (metodo == "total") {
                    return _.formatPrice(inputval)+" Sq.Ft / "+parseFloat((inputval/43560).toFixed(2))+ " Acre";
                }else{
                    return parseFloat((inputval/43560).toFixed(2))+ " Acre";
                }
            }else{
                   return _.formatPrice(inputval);
            }
        }else{
            return "N/A";
        }
    });

    Handlebars.registerHelper('hasAcre', function(inputval) {
        if ( ![null,"",undefined,"undefined",0,"0"].includes( inputval ) ){
            inputval= parseFloat( inputval.replaceAll(',',''));
            if (inputval >= 20000) {
                return true;
            }else{
                   return false;
            }
        }else{
            return false;
        }

    });
    
Handlebars.registerHelper("idxFavoriteClass", function(property) {
	var options = ["ib-pfheart","ib-pfstar","ib-pfcube"];
	var currentClass = options[__flex_idx_search_filter.search.view_icon_type];
	var returnOptions = [];

	returnOptions.push(currentClass);

	if ( property.hasOwnProperty("token_alert") && (property.token_alert.length) ) {
		returnOptions.push("ib-pf-active");
	}

	return returnOptions.join(" ");
});

Handlebars.registerHelper("idxFavoriteText", function(property) {
	return ("" === property.token_alert) ? word_translate.save : word_translate.remove;
});

Handlebars.registerHelper("idxGalleryImages", function(property) {
	if (property.gallery.length > 0) {
		var images = [];

	  for (var i = 0, l = property.gallery.length; i < l; i++) {
		if (i < 1) {
		  images.push(
			'<img onerror="this.src=\'https://www.idxboost.com/i/default_thumbnail.jpg\';" src="' +
			  property.gallery[i] +
			  '" class="ib-pifimg" alt="'+property.full_address+'">'
		  );
		} else {
		  images.push(
			'<img onerror="this.src=\'https://www.idxboost.com/i/default_thumbnail.jpg\';" data-lazy="' +
			  property.gallery[i] +
			  '" class="gs-lazy" alt="'+property.full_address+'">'
		  );
		}
	  }

		return images.join("");
	} else {
	  return '<img src="https://www.idxboost.com/i/default_thumbnail.jpg" class="ib-pifimg" alt="'+property.full_address+'">';
	}
});

Handlebars.registerHelper('formatPriceSqft', function(property) {
	if ( ( property.sqft > 0 ) && ( property.price > 0 )  ) {
		return _.formatPrice(property.price / property.sqft);
	} else {
		return "";
	}
});

Handlebars.registerHelper('idxImage', function(property) {
	if (property.img_cnt > 0) {
		return _.getMLSImage(property.mls_num, property.image);
	} else {
		return "https://www.idxboost.com/i/default_thumbnail.jpg";
	}
});

Handlebars.registerHelper('idxRelatedImage', function(property) {
	if ("" != property.thumbnail) {
		return property.thumbnail;
	} else {
		return "https://www.idxboost.com/i/default_thumbnail.jpg";
	}
});

Handlebars.registerHelper('idxImageEmpty', function(property) {
	if (property.img_cnt < 2) {
		return "ib-piwoimgs";
	} else {
		return "";
	}
});

Handlebars.registerHelper("propertyHasNoImages", function(property) {
	if (property.img_cnt == 0) {
		return "ib-pvlist-wophotos";
	} else {
		return "";
	}
});

Handlebars.registerHelper('isNotSingleorCondos', function(property) {
	if ( (property.tw == "1" || property.mf == "1" || property.is_vacant == "1") ) {
		if (property.more_info_info.style !="")  {
			return '<li><span class="ib-plist-st">'+word_translate.style+'</span><span class="ib-plist-pt">'+property.more_info_info.style+'</span></li>';
		}
	}
	return '';
});

Handlebars.registerHelper('isSingleorCondos', function(property) {
	if (  !(property.tw == "1" || property.mf == "1" || property.is_vacant == "1") ) {
		if (property.more_info_info.style !="")  {
			return '<li><span class="ib-plist-st">'+word_translate.style+'</span><span class="ib-plist-pt">'+property.more_info_info.style+'</span></li>';
		}
	}
	return '';
});


Handlebars.registerHelper('markPhotosActive', function(property) {
	if ( parseInt(property.img_cnt, 10) > 0 ) {
		return "ib-pvi-active";
	} else {
		return "";
	}
});

    Handlebars.registerHelper("BoardImgDisclaimer", function(property) {       
        let response = false;
            if ( property.board_id != "35" || ( property.board_id == "35" && property.rg_id == "34") ) {
                response = true;
            }
        return response;
    });

    Handlebars.registerHelper("DisclaiAgent", function(rg_id) {       
        if ( rg_id === "34" ) {
            return true;
        } else {
            return false;
        }
    });


Handlebars.registerHelper("markClassActiveTab", function(property) {
	if ( parseInt(property.img_cnt, 10) > 0 ) {
		return "ib-pva-photos";
	} else {
		return "ib-pva-map";
	}
});

Handlebars.registerHelper('markMapActive', function(property) {
	if ( 0 == parseInt(property.img_cnt, 10) ) {
		return "ib-pvi-active";
	} else {
		return "";
	}
});

Handlebars.registerHelper("isRentalTypeListing", function(rentalType) {
	if (1 == rentalType) {
		return '/'+word_translate.month;
	} else {
		return "";
	}
});

Handlebars.registerHelper("isRentalType", function(property) {
	if (property.hasOwnProperty("is_rental") && "1" == property.is_rental) {
		return '/'+word_translate.month;
	}
});

Handlebars.registerHelper('idxBoardDisclaimer', function(property) {
	window.property = property;
	let disclaimerHtml = "";
	if (
		property.hasOwnProperty("board_info") && 
		property.board_info.hasOwnProperty("board_disclaimer") && 
		!( ["" , null,undefined,"undefined","null"].includes(property.board_info.board_disclaimer)  )
	 ) {
		let disclaimer = property.board_info.board_disclaimer.replace("{officeName}", property.office_name);
		disclaimer = disclaimer.replace("{office_phone}", '<a href="tel:'+property.phone_office+'">'+property.phone_office+'</a>');
		disclaimerHtml = '<p>' + disclaimer + '</p>';
	}
	return disclaimerHtml;
});	

Handlebars.registerHelper('idxBoardDisclaimerExist', function(property) {
	let res = false;	
	if (
		property.hasOwnProperty("board_info") && 
		property.board_info.hasOwnProperty("board_disclaimer") && 
		!( ["" , null,undefined,"undefined","null"].includes(property.board_info.board_disclaimer)  )
	 ) {
		res = true;
	}
	return res;
});	

Handlebars.registerHelper('idxSliderLoop', function(property) {
	var images = [];

	for (var i = 0, l = property.gallery.length; i < l; i++) {
		images.push('<img onerror="this.src=\'https://www.idxboost.com/i/default_thumbnail.jpg\';" class="ib-pvsitem" src="' + property.gallery[i] + '">');
	}

	return images.join("");

	// if ( parseInt(property.img_cnt, 10) > 0 ) {
	//     var sliderItems = [];
	//     var count = parseInt(property.img_cnt, 10);

	//     for (var index = 1; index < count; index++) {
	//         sliderItems.push('<img class="ib-pvsitem" src="'+ _.getMLSListImage(property.mls_num, property.image, index) +'">');
	//     }

	//     if (count == 1) {
	//         sliderItems.push('<img class="ib-pvsitem" src="'+ _.getMLSListImage(property.mls_num, property.image, 1) +'">');
	//         sliderItems.push('<img class="ib-pvsitem" src="https://www.idxboost.com/i/default_thumbnail.jpg">');
	//         sliderItems.push('<img class="ib-pvsitem" src="https://www.idxboost.com/i/default_thumbnail.jpg">');
	//     } else if (count == 2) {
	//         sliderItems.push('<img class="ib-pvsitem" src="'+ _.getMLSListImage(property.mls_num, property.image, 1) +'">');
	//         sliderItems.push('<img class="ib-pvsitem" src="'+ _.getMLSListImage(property.mls_num, property.image, 2) +'">');
	//         sliderItems.push('<img class="ib-pvsitem" src="https://www.idxboost.com/i/default_thumbnail.jpg">');
	//     }

	//     return sliderItems.join("");
	// } else {
	//     return [];
	// }
});

Handlebars.registerHelper('propertyPermalink', function(slug) {
	return __flex_idx_search_filter.propertyDetailPermalink + "/" + slug;
});

Handlebars.registerHelper('agentPhoto', function(property) {
	return __flex_idx_search_filter.agentPhoto;
});

Handlebars.registerHelper('agentFullName', function(property) {
	return __flex_idx_search_filter.agentFullName;
});

Handlebars.registerHelper('agentPhoneNumber', function(property) {
	return __flex_idx_search_filter.agentPhone.replace(/[^\d+]/g, "");
});

Handlebars.registerHelper('agentPhone', function(property) {
	return __flex_idx_search_filter.agentPhone;
});

Handlebars.registerHelper('idxReduced', function(reduced) {
	if (reduced < 0) {
		return '<div class="ib-pipanumber ib-pipadown">'+reduced+'%</div>';
	} else if (reduced > 0) {
		return '<div class="ib-pipanumber">'+reduced+'%</div>';
	} else {
		return '';
	}
});

Handlebars.registerHelper('leadFirstName', function(property) {
	return __flex_idx_search_filter.leadFirstName;
});

Handlebars.registerHelper('leadLastName', function(property) {
	return __flex_idx_search_filter.leadLastName;
});

Handlebars.registerHelper('leadEmailAddress', function(property) {
	return __flex_idx_search_filter.leadEmailAddress;
});

/*Handlebars.registerHelper('leadCountryCodePhoneNumber', function (property) {
	return __flex_idx_search_filter.leadCountryCodePhoneNumber;
});*/

Handlebars.registerHelper('leadPhoneNumber', function(property) {
	return __flex_idx_search_filter.leadPhoneNumber;
});

__flex_idx_search_filter.search.price_sale_range.push({ label: word_translate.any_price, value: "--" });
__flex_idx_search_filter.search.price_rent_range.push({ label: word_translate.any_price, value: "--" });

__flex_idx_search_filter.search.living_size_range.push({ label: word_translate.any_size, value: "--" });
__flex_idx_search_filter.search.lot_size_range.push({ label: word_translate.any_size, value: "--" });

/** Setup Callbacks for Autocomplete */
function ib_fetch_default_cities() {
	var ib_autocomplete_cities = _.pluck(__flex_g_settings.params.cities, "name");
	var featured_cities = [];

	if (ib_autocomplete_cities.length) {
		for (var i = 0, l = ib_autocomplete_cities.length; i < l; i++) {
			featured_cities.push({
				label: ib_autocomplete_cities[i],
				type: "city"
			});
		}
	}

	return featured_cities;
}

function handleSubmitAutocompleteForm(event) {
	event.preventDefault();

	var inputValue = ib_autocomplete.val();

	if ("" !== inputValue) {
		ib_autocomplete.autocomplete("close");

		if (19 == __flex_g_settings.boardId) {
			var matchCity;
	
			for (var i = 0, l = ib_autocomplete_cities.length; i < l; i++) {
				var term = ib_autocomplete_cities[i];
				var match = new RegExp("^" + term.label + "$", "i");

				if (false !== match.test(inputValue)) {
					matchCity = term;
					break;
				}
			}

			if ("undefined" !== typeof matchCity) {
				setAutocompleteTerm(matchCity.label, "city");
				// @todo remove rect
				IB_SEARCH_FILTER_FORM.find('[name="polygon_search"]').val("");
				IB_SEARCH_FILTER_FORM.find('[name="rect"]').val("");
				IB_SEARCH_FILTER_FORM.find('[name="zm"]').val("");
			} else {
				setAutocompleteTerm(inputValue, null);
				// @todo remove rect
				IB_SEARCH_FILTER_FORM.find('[name="polygon_search"]').val("");
				IB_SEARCH_FILTER_FORM.find('[name="rect"]').val("");
				IB_SEARCH_FILTER_FORM.find('[name="zm"]').val("");
			}
		} else {
			if (/^\d+$/.test(inputValue) && (5 === inputValue.length) ) {
				setAutocompleteTerm(inputValue, "zip");
				// @todo remove rect
				IB_SEARCH_FILTER_FORM.find('[name="polygon_search"]').val("");
				IB_SEARCH_FILTER_FORM.find('[name="rect"]').val("");
				IB_SEARCH_FILTER_FORM.find('[name="zm"]').val("");
			} else {
				var matchCity;
	
				for (var i = 0, l = ib_autocomplete_cities.length; i < l; i++) {
					var term = ib_autocomplete_cities[i];
					var match = new RegExp("^" + term.label + "$", "i");
	
					if (false !== match.test(inputValue)) {
						matchCity = term;
						break;
					}
				}
	
				if ("undefined" !== typeof matchCity) {
					setAutocompleteTerm(matchCity.label, "city");
					// @todo remove rect
					IB_SEARCH_FILTER_FORM.find('[name="polygon_search"]').val("");
					IB_SEARCH_FILTER_FORM.find('[name="rect"]').val("");
					IB_SEARCH_FILTER_FORM.find('[name="zm"]').val("");
				} else {
					setAutocompleteTerm(inputValue, null);
					// @todo remove rect
					IB_SEARCH_FILTER_FORM.find('[name="polygon_search"]').val("");
					IB_SEARCH_FILTER_FORM.find('[name="rect"]').val("");
					IB_SEARCH_FILTER_FORM.find('[name="zm"]').val("");
				}
			}
		}
	}
}

function handleLookupAutocomplete(request, response) {
	var term = request.term;

	if (term in ib_autocomplete_cache) {
		response(ib_autocomplete_cache[term]);
		return;
	}

	$.ajax({
		url: __flex_g_settings.suggestions.service_url,
		dataType: "json",
		data: {
			term: request.term,
			board: __flex_g_settings.boardId
		},
		success:function(data) {
			ib_autocomplete_cache[term] = data;
			response(data);
		},
	});
}

function setAutocompleteTerm(term, type) {
	IB_SEARCH_FILTER_FORM.find('[name="filter_search_keyword_label"]').val(term);
	
	if (null === type) {
		IB_SEARCH_FILTER_FORM.find('[name="filter_search_keyword_type"]').val("");
	} else {
		IB_SEARCH_FILTER_FORM.find('[name="filter_search_keyword_type"]').val(type);
	}

	IB_SEARCH_FILTER_FORM.find('[name="polygon_search"]').val("");
	IB_SEARCH_FILTER_FORM.find('[name="rect"]').val("");
	IB_SEARCH_FILTER_FORM.find('[name="zm"]').val("");

	//update_bounds_zoom_gmap();

	IB_SEARCH_FILTER_FORM.find('[name="page"]').val(1);
	IB_SEARCH_FILTER_FORM.trigger("submit");
}

function handleSelectAutocomplete(event, ui) {
	setAutocompleteTerm(ui.item.value, ui.item.type);
	// @todo remove rect
	IB_SEARCH_FILTER_FORM.find('[name="polygon_search"]').val("");
	IB_SEARCH_FILTER_FORM.find('[name="rect"]').val("");
	IB_SEARCH_FILTER_FORM.find('[name="zm"]').val("");

	IB_GMAP_FIT_TO_BOUNDS = true;

	// @todo blur autocomplete    
	setTimeout(function () {
		document.activeElement.blur();
	}, 100);

}

function handleFocusAutocompleteEvent() {
	if ("" === this.value) {
		ib_autocomplete.autocomplete("option", "source", ib_autocomplete_cities);
		ib_autocomplete.autocomplete( "search", "" );
	}
}

function handleKeyPressAutocompleteEvent(event) {
	if ("" !== this.value && 13 === event.keyCode) {
		IB_SEARCH_FILTER_FORM.find('[name="polygon_search"]').val("");
		IB_SEARCH_FILTER_FORM.find('[name="rect"]').val("");
		IB_SEARCH_FILTER_FORM.find('[name="zm"]').val("");

		ib_autocomplete.autocomplete("close");
		// @todo blur autocomplete
		
		setTimeout(function () {
			document.activeElement.blur();
		}, 100);

		disableSearchEvent = true;
	}

	ib_autocomplete.autocomplete("option", "source", handleLookupAutocomplete);
}

function handleKeyUpAutocompleteEvent(event) {
	disableSearchEvent = false;

	if (event.keyCode == 40 || event.keyCode == 38 || event.keyCode == 39 || event.keyCode == 37) {
		return;
	}

	var inputValue = this.value;

	if ( ("" !== inputValue) && (13 === event.keyCode) ) {
		ib_autocomplete.autocomplete("close");
		// @todo blur autocomplete
		
		setTimeout(function () {
			document.activeElement.blur();
		}, 100);

		if (19 == __flex_g_settings.boardId) {
			var matchCity;
	
			for (var i = 0, l = ib_autocomplete_cities.length; i < l; i++) {
				var term = ib_autocomplete_cities[i];
				var match = new RegExp("^" + term.label + "$", "i");

				if (false !== match.test(inputValue)) {
					matchCity = term;
					break;
				}
			}

			if ("undefined" !== typeof matchCity) {
				setAutocompleteTerm(matchCity.label, "city");
				// @todo remove rect
				IB_SEARCH_FILTER_FORM.find('[name="polygon_search"]').val("");
				IB_SEARCH_FILTER_FORM.find('[name="rect"]').val("");
				IB_SEARCH_FILTER_FORM.find('[name="zm"]').val("");
			} else {
				setAutocompleteTerm(inputValue, null);
				// @todo remove rect
				IB_SEARCH_FILTER_FORM.find('[name="polygon_search"]').val("");
				IB_SEARCH_FILTER_FORM.find('[name="rect"]').val("");
				IB_SEARCH_FILTER_FORM.find('[name="zm"]').val("");
			}
		} else {
			if (/^\d+$/.test(inputValue) && (5 === inputValue.length) ) {
				setAutocompleteTerm(inputValue, "zip");
				// @todo remove rect
				IB_SEARCH_FILTER_FORM.find('[name="polygon_search"]').val("");
				IB_SEARCH_FILTER_FORM.find('[name="rect"]').val("");
				IB_SEARCH_FILTER_FORM.find('[name="zm"]').val("");
			} else {
				var matchCity;
	
				for (var i = 0, l = ib_autocomplete_cities.length; i < l; i++) {
					var term = ib_autocomplete_cities[i];
					var match = new RegExp("^" + term.label + "$", "i");
	
					if (false !== match.test(inputValue)) {
						matchCity = term;
						break;
					}
				}
	
				if ("undefined" !== typeof matchCity) {
					setAutocompleteTerm(matchCity.label, "city");
					// @todo remove rect
					IB_SEARCH_FILTER_FORM.find('[name="polygon_search"]').val("");
					IB_SEARCH_FILTER_FORM.find('[name="rect"]').val("");
					IB_SEARCH_FILTER_FORM.find('[name="zm"]').val("");
				} else {
					setAutocompleteTerm(inputValue, null);
					// @todo remove rect
					IB_SEARCH_FILTER_FORM.find('[name="polygon_search"]').val("");
					IB_SEARCH_FILTER_FORM.find('[name="rect"]').val("");
					IB_SEARCH_FILTER_FORM.find('[name="zm"]').val("");
				}
			}
		}
	}

	if ("" === inputValue) {
		ib_autocomplete.autocomplete("option", "source", ib_autocomplete_cities);
		ib_autocomplete.autocomplete( "search", "" );
	} else {
		ib_autocomplete.autocomplete("option", "source", handleLookupAutocomplete);
		ib_autocomplete.autocomplete( "search", ib_autocomplete.val() );
	}
}

function handleClearAutocompleteEvent() {
	if (disableSearchEvent) {
		return;
	}

	ib_autocomplete.autocomplete("option", "source", ib_autocomplete_cities);
	ib_autocomplete.autocomplete( "search", "" );
}

function handlePasteAutocompleteEvent() {
	ib_autocomplete.autocomplete("option", "source", handleLookupAutocomplete);
}

var IB_ACCESS_TOKEN;
var IB_SEARCH_FILTER;
var IB_SEARCH_FILTER_FORM;
var IB_CLEAR_BTN;

var IB_DOCFRAG = document.createDocumentFragment();
// var IB_LB_CITIES;
var IB_LB_WATERFRONT_OPTIONS;
var IB_LB_PARKING_OPTIONS;
var IB_LB_AMENITIES_OPTIONS;
var IB_LB_AMENITIES_EXTRAS_OPTIONS;
var IB_LB_TYPES_OPTIONS;
var IB_RENTAL_TYPE;

var IB_RG_PRICE_SALE;
var IB_RG_PRICE_RENT;
var IB_RG_BEDROOMS;
var IB_RG_BATHROOMS;
var IB_RG_LIVINGSIZE;
var IB_RG_LANDSIZE;
var IB_RG_YEARBUILT;

var IB_RG_PRICE_SALE_VALUES = _.pluck(__flex_idx_search_filter.search.price_sale_range, "value");
var IB_RG_PRICE_RENT_VALUES = _.pluck(__flex_idx_search_filter.search.price_rent_range, "value");
var IB_RG_BEDROOMS_VALUES = _.pluck(__flex_idx_search_filter.search.beds_range, "value");
var IB_RG_BATHROOMS_VALUES = [0,1,2,3,4,5,6];
var IB_RG_LIVINGSIZE_VALUES = _.pluck(__flex_idx_search_filter.search.living_size_range, "value");
var IB_RG_LANDSIZE_VALUES = _.pluck(__flex_idx_search_filter.search.lot_size_range, "value");
var IB_RG_YEARBUILT_VALUES = _.pluck(__flex_idx_search_filter.search.year_built_range, "value");

var IB_RG_PRICE_SALE_LBL_LT;
var IB_RG_PRICE_SALE_LBL_RT;
var IB_RG_PRICE_RENT_LBL_LT;
var IB_RG_PRICE_RENT_LBL_RT;

var IB_RG_YEAR_LBL_LT;
var IB_RG_YEAR_LBL_RT;

var IB_RG_LIVING_LBL_LT;
var IB_RG_LIVING_LBL_RT;

var IB_RG_LAND_LBL_LT;
var IB_RG_LAND_LBL_RT;

var IB_RG_MATCHING;

/** Setup global variables for Autocomplete */
var ib_autocomplete;
var ib_autocomplete_btn;
var ib_autocomplete_cities = ib_fetch_default_cities();
var ib_autocomplete_cache = {};

// var IB_SEARCH_FILTER_AUTOCOMPLETE;
// var IB_KW_TG_SEARCH;

var IB_SORT_CTRL;
var IB_PAGINATION_CTRL;
var IB_LISTINGS_CT;
var IB_HEADING_CT;

var IB_MODAL_WRAPPER;
var IB_MODAL_TPL;
var IB_MODAL_SLIDER;

var IB_LBL_PRICE_NTF;
var IB_LBL_BED_NTF;
var IB_LBL_BATH_NTF;
var IB_LBL_TYPES_NTF;

// var IB_MAP;
var IB_MARKER;
var IB_MARKERS = [];
var IB_MARKERS_LISTINGS = [];
var IB_MAP_TOOLTIP;

var IB_DRAWING_MANAGER;
var IB_DRAWING_POLYGON;

/** Google Maps Custom Controls */
var mapButtonsWrapper;
var mapZoomInButton;
var mapZoomOutButton;
var mapDrawButton;
var mapDrawEraseButton;

var IB_POLYGON;
var IB_HAS_POLYGON = false;

var infobox_content = [];
var infoWindow;

function calculate_mortgage(price, percent, year, interest) {
	price = price.replace(/[^\d]/g, "");
	percent = parseFloat(percent);
	year = year.replace(/[^\d]/g, "");
	interest = parseFloat(interest);

	var month_factor = 0;
	var month_term = year * 12;
	var down_payment = price * (percent / 100);
  
	interest = interest / 100;
  
	var month_interest = interest / 12;
	
	var financing_price = price - down_payment;
	var base_rate = 1 + month_interest;
	var denominator = base_rate;
	
	for (var i = 0; i < (year * 12); i++) {
	  month_factor += (1 / denominator);
	  denominator *= base_rate;
	}
  
	var month_payment = financing_price / month_factor;
	var pmi_per_month = 0;
	
	if (percent < 20) {
	  pmi_per_month = 55 * (financing_price / 100000);
	}
  
	var total_monthly = month_payment + pmi_per_month;
	
	return {
	  'mortgage': _.formatPrice(financing_price),
	  'down_payment': _.formatPrice(down_payment),
	  'monthly': _.formatPrice(month_payment, 2),
	  'total_monthly': _.formatPrice(total_monthly, 2)
	};
}

function getQueryParameter(q) {
	return (window.location.search.match(new RegExp('[?&]' + q + '=([^&]+)')) || [, null])[1];
}

function handleOverlayComplete(event) {
	if (IB_DRAWING_MANAGER.getDrawingMode()) {
		IB_DRAWING_MANAGER.setDrawingMode(null);
	}

	if ("polygon" === event.type) {
		var shape = event.overlay;
		var path = shape.getPath();

		IB_DRAWING_POLYGON = shape;
		IB_GMAP_FINISHED_POLYGON = true;

		// encode path
		var encodedPath = google.maps.geometry.encoding.encodePath(path);
		// console.log(encodedPath);

		// encode base64
		encodedPath = btoa(encodedPath);

		// make URL friendly
		encodedPath = encodedPath.replace(/\+/g, '-').replace(/\//g, '_').replace(/\=+$/, '');
		// console.log(encodedPath);

		IB_SEARCH_FILTER_FORM.find('[name="crid"]').val(encodedPath);

		// reverse to origin encoding
		if (encodedPath.length % 4 != 0) {
			encodedPath += ('===').slice(0, 4 - (encodedPath.length % 4));
		}

		encodedPath = encodedPath.replace(/-/g, '+').replace(/_/g, '/');

		// decode path
		// console.log(google.maps.geometry.encoding.decodePath(atob(encodedPath)));
	}
}

function handleSatelliteButton(event){
  event.stopPropagation();
  event.preventDefault();
  IB_MAP.setMapTypeId(google.maps.MapTypeId.HYBRID)

  if($(this).hasClass("is-active")){
    $(this).removeClass("is-active");
    IB_MAP.setMapTypeId(google.maps.MapTypeId.ROADMAP)
  }else{
    $(this).addClass("is-active");
    IB_MAP.setMapTypeId(google.maps.MapTypeId.HYBRID)
  }
}

function handleZoomInButton(event) {
  event.stopPropagation();
  event.preventDefault();
  IB_MAP.setZoom(IB_MAP.getZoom() + 1);
}

function handleZoomOutButton(event) {
  event.stopPropagation();
  event.preventDefault();
  IB_MAP.setZoom(IB_MAP.getZoom() - 1);
}

function handlefullscreenButton() {

  var elementToSendFullscreen = IB_MAP.getDiv().firstChild;

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

function handleDrawButton() {
	IB_LOOKUP_DRAG = false;

	// check if infowindow open, then close
	if (infoWindow.isOpen()) {
		infoWindow.close();
	}

	// check if map has polygon
	if (true === IB_HAS_POLYGON) {
		// hide polygon
		if ("undefined" !== typeof IB_POLYGON) {
			IB_POLYGON.setVisible(false);
		}
	}

	if (typeof IB_DRAWING_POLYGON !== "undefined") {
		IB_DRAWING_POLYGON.setMap(null);
	}

	// check if markers
	if (IB_MARKERS) {
		// hide them all
		for (var i = 0, l = IB_MARKERS.length; i < l; i++) {
			IB_MARKERS[i].setVisible(false);
		}
	}

	// hide map actions
	$(mapButtonsWrapper).hide();

	// show navbar top
	$("#wrap-map-draw-actions").css("display", "flex");

	// turn on drawing manager
	IB_DRAWING_MANAGER = new google.maps.drawing.DrawingManager({
		drawingMode: google.maps.drawing.OverlayType.POLYGON,
		drawingControl: false,
		drawingControlOptions: {
			position: google.maps.ControlPosition.TOP_RIGHT,
			drawingModes: ["polygon"]
		},
		polygonOptions: {
			editable: false,
			strokeWeight: 1,
			strokeOpacity: 0.8,
			strokeColor: "#31239a",
			fillOpacity: 0.1,
			fillColor: "#31239a",
		}
	});

	google.maps.event.addListenerOnce(IB_DRAWING_MANAGER, "overlaycomplete", handleOverlayComplete);

	IB_DRAWING_MANAGER.setMap(IB_MAP);

	IB_USER_IS_DRAWING = true;
}

function handleDragSearchEvent() {
	if (true === IB_USER_IS_DRAWING) {
		return;
	}

	if (false === IB_GMAP_INIT) {
		return;
	}

	var mapZoom = IB_MAP.getZoom();
	var mapBounds = IB_MAP.getBounds();
	var mapCenter = mapBounds.getCenter();

	IB_SEARCH_FILTER_FORM.find('[name="rect"]').val(mapBounds.toUrlValue());
	IB_SEARCH_FILTER_FORM.find('[name="zm"]').val(mapZoom);

	// console.log("Bounds: " + mapBounds.toUrlValue());
	// console.log("Center: " + mapCenter.toUrlValue());
	// console.log("Zoom: " + mapZoom);

	IB_SEARCH_FILTER_FORM.find('[name="page"]').val(1);
	IB_SEARCH_FILTER_FORM.trigger("submit");
}

//MAPA 50/50
function setupMapControlsFull() {
  // setup buttons wrapper
  mapButtonsWrapper = document.createElement("div");
  mapButtonsWrapper.classList.add('flex-map-controls-ct');

	// setup Full Screen button
	fullscreenControl = document.createElement("div");
	fullscreenControl.classList.add('flex-map-fullscreen');
	//mapButtonsWrapper.appendChild(fullscreenControl);

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
	mapDrawButton.classList.add('flex-map-draw');
	mapButtonsWrapper.appendChild(mapDrawButton);

	// set draw erase button
	mapDrawEraseButton = document.createElement("div");
	mapDrawEraseButton.classList.add('flex-map-draw-erase');
	//mapButtonsWrapper.appendChild(mapDrawEraseButton);

  // setup Satellite button
  satelliteMapButton = document.createElement("div");
  satelliteMapButton.classList.add('flex-satellite-button');
  mapButtonsWrapper.appendChild(satelliteMapButton);

  // add Buttons
  google.maps.event.addDomListener(mapZoomInButton, "click", handleZoomInButton);
  google.maps.event.addDomListener(mapZoomOutButton, "click", handleZoomOutButton);
  //google.maps.event.addDomListener(fullscreenControl, "click", handlefullscreenButton);
	google.maps.event.addDomListener(mapDrawButton, "click", handleDrawButton);
  google.maps.event.addDomListener(satelliteMapButton, "click", handleSatelliteButton);

  IB_MAP.controls[google.maps.ControlPosition.TOP_RIGHT].push(mapButtonsWrapper);
}

function update_bounds_zoom_gmap() {
	var mapZoom = IB_MAP.getZoom();
	var mapBounds = IB_MAP.getBounds();
	
	IB_SEARCH_FILTER_FORM.find('[name="rect"]').val("");
	IB_SEARCH_FILTER_FORM.find('[name="zm"]').val("");

	IB_GMAP_FIT_TO_BOUNDS = false;

	// var urlParams = new URLSearchParams(window.location.search);
	
	// urlParams.delete("rect");
	// urlParams.delete("zm");
	
	// @todo fitbounds
	// IB_GMAP_FIT_TO_BOUNDS = true;
}

function handleMarkerClick(marker, property, map) {
	return function() {
		IB_LAST_OPENED_MARKER = marker;

		if (property.group.length > 1) {
			// multiple
			infobox_content.push('<div class="ib-infobox ib-ibmulti">');
			infobox_content.push('<div class="ib-ibwtitle">');
			infobox_content.push('<div class="ib-ibcount">'+property.group.length+' <span>units </span></div>');

			if ( (null != property.item.complex) && ("" !== property.item.complex) ) {
				infobox_content.push('<h3 class="ib-ibtitle"><span class="ib-ibtxt">'+property.item.complex+'</span></h3>');
			} else {
				if (property.item.development == null) { property.item.development = ""; }
				infobox_content.push('<h3 class="ib-ibtitle"><span class="ib-ibtxt">'+property.item.development+'</span></h3>');
			}

			infobox_content.push('<div class="ib-ibclose"><span>Close</span></div>');
			infobox_content.push('</div>');
			infobox_content.push('<ul class="ib-ibproperties">');

			for (var i = 0, l = property.group.length; i < l; i++) {
				var property_group = property.group[i];

				infobox_content.push('<li class="ib-ibpitem" data-mls="'+property_group.mls_num+'">');
				infobox_content.push('<div class="ib-ibpa">');
				infobox_content.push('<h4 class="ib-ibptitle">'+property_group.address_short+'</h4>');
				infobox_content.push('<ul class="ib-ibdetails">');
				infobox_content.push('<li class="ib-ibditem ib-ibaddress">'+property_group.address_large+'</li>');


				if (1 == property_group.is_rental) {
					infobox_content.push('<li class="ib-ibditem ib-ibprice">$'+_.formatPrice(property_group.price)+'/'+word_translate.month+'</li>');
				} else {
					infobox_content.push('<li class="ib-ibditem ib-ibprice">$'+_.formatPrice(property_group.price)+'</li>');
				}


				infobox_content.push('<li class="ib-ibditem ib-ibbeds"><span class="ib-ibdbold">'+property_group.bed+'</span>'+word_translate.beds+'</li>');

				if (property_group.baths_half > 0) {
					infobox_content.push('<li class="ib-ibditem ib-ibbaths"><span class="ib-ibdbold">'+property_group.bath+(property_group.baths_half > 0 ? ".5" : "")+'</span>'+word_translate.baths+'</li>');
				} else {
					infobox_content.push('<li class="ib-ibditem ib-ibbaths"><span class="ib-ibdbold">'+property_group.bath+'</span>'+word_translate.baths+'</li>');
				}
				
				if ( ![null,"",undefined,"undefined",0,"0"].includes( property_group.sqft ) ){
					infobox_content.push('<li class="ib-ibditem ib-ibsqft"><span class="ib-ibdbold">'+_.formatPrice(property_group.sqft)+'</span>'+word_translate.sqft+'</li>');
				}else{
					infobox_content.push('<li class="ib-ibditem ib-ibsqft"><span class="ib-ibdbold">'+"N/A"+'</span>'+word_translate.sqft+'</li>');
				}
				

				if (property_group.sqft > 0) {
					infobox_content.push('<li class="ib-ibditem ib-ibsqft"><span class="ib-ibdbold">$'+_.formatPrice(property_group.price / property_group.sqft)+'</span>/ '+word_translate.sqft+'</li>');
				}

				infobox_content.push('</ul>');
				infobox_content.push('</div>');


                    if (
                        __flex_g_settings.hasOwnProperty("board_info") &&
                        __flex_g_settings.board_info.hasOwnProperty("board_logo_url") &&
                        !(["", null, undefined, "undefined", "null"].includes(__flex_g_settings.board_info.board_logo_url))
                    ) {
                    	if( property.board_id != "35" || ( property.board_id == "35" && property.rg_id == "34")  ) {
							  infobox_content.push(
								'<div class="ib-ibpb"><img onerror="this.src=\'https://www.idxboost.com/i/default_thumbnail.jpg\';" class="ib-ibimg" src="' +
								  property_group.thumbnail +
								  '" alt="'+ property_group.address_short +'"><img src="'+__flex_g_settings.board_info.board_logo_url+'" style="position: absolute;bottom: 10px;z-index: 2;width: 80px;right: 10px;height:auto"></div>'
							  );
                    	}
                    }else{
					  infobox_content.push(
						'<div class="ib-ibpb"><img onerror="this.src=\'https://www.idxboost.com/i/default_thumbnail.jpg\';" class="ib-ibimg" src="' +
						  property_group.thumbnail +
						  '" alt="'+ property_group.address_short +'"></div>'
					  );
                    }


				// if ((null != property_group.image) && (property_group.image.length > 0) ) {
				//     // infobox_content.push('<div class="ib-ibpb"><img class="ib-ibimg" src="'+_.getMLSImage(property_group.mls_num, property_group.image)+'"></div>');
				//     infobox_content.push('<div class="ib-ibpb"><img class="ib-ibimg" src="'+property_group.thumbnail+'"></div>');
				// } else {
				//     infobox_content.push('<div class="ib-ibpb"><img class="ib-ibimg" src="https://www.idxboost.com/i/default_thumbnail.jpg"></div>');
				// }

				// infobox_content.push('</li>');
				infobox_content.push('<a href="'+__flex_idx_search_filter.propertyDetailPermalink + "/" + property_group.slug +'"></a></li>');
			}

			infobox_content.push('</ul>');
			infobox_content.push('</div>');
		} else {
			// single
			infobox_content.push('<div class="ib-infobox">');
			infobox_content.push('<div class="ib-ibwtitle">');

			if ( (null != property.item.complex) && ("" !== property.item.complex) ) {
				infobox_content.push('<h3 class="ib-ibtitle"><span class="ib-ibtxt">'+property.item.complex+'</span></h3>');
			} else {
				if (property.item.development == null) { property.item.development = ""; }
				infobox_content.push('<h3 class="ib-ibtitle"><span class="ib-ibtxt">'+property.item.development+'</span></h3>');
			}


			infobox_content.push('<div class="ib-ibclose"><span>Close</span></div>');
			infobox_content.push('</div>');
			infobox_content.push('<ul class="ib-ibproperties">');
			infobox_content.push('<li class="ib-ibpitem" data-mls="'+property.item.mls_num+'">');
			infobox_content.push('<div class="ib-ibpa">');
			infobox_content.push('<h4 class="ib-ibptitle">'+property.item.address_short+'</h4>');
			infobox_content.push('<ul class="ib-ibdetails">');
			infobox_content.push('<li class="ib-ibditem ib-ibaddress">'+property.item.address_large+'</li>');


			if (1 == property.item.is_rental) {
				infobox_content.push('<li class="ib-ibditem ib-ibprice">$'+_.formatPrice(property.item.price)+'/'+word_translate.month+'</li>');
			} else {
				infobox_content.push('<li class="ib-ibditem ib-ibprice">$'+_.formatPrice(property.item.price)+'</li>');
			}

			infobox_content.push('<li class="ib-ibditem ib-ibbeds"><span class="ib-ibdbold">'+property.item.bed+'</span>'+word_translate.beds+'</li>');
			if (property.item.baths_half > 0) {
				infobox_content.push('<li class="ib-ibditem ib-ibbaths"><span class="ib-ibdbold">'+property.item.bath+(property.item.baths_half > 0 ? ".5" : "")+'</span>'+word_translate.baths+'</li>');
			} else {
				infobox_content.push('<li class="ib-ibditem ib-ibbaths"><span class="ib-ibdbold">'+property.item.bath+'</span>'+word_translate.baths+'</li>');
			}

                if ( [null,"",undefined,"undefined",0,"0"].includes( property.item.sqft ) ){
                    infobox_content.push('<li class="ib-ibditem ib-ibsqft"><span class="ib-ibdbold">'+'N/A'+'</span>'+word_translate.sqft+'</li>');
                }else{
                    infobox_content.push('<li class="ib-ibditem ib-ibsqft"><span class="ib-ibdbold">'+_.formatPrice(property.item.sqft)+'</span>'+word_translate.sqft+'</li>');
                }

			

			if (property.item.sqft > 0 ) {
				infobox_content.push('<li class="ib-ibditem ib-ibsqft"><span class="ib-ibdbold">$'+_.formatPrice(property.item.price / property.item.sqft)+'</span>/ '+word_translate.sqft+'</li>');
			}

			infobox_content.push('</ul>');
			infobox_content.push('</div>');


                    if (
                        __flex_g_settings.hasOwnProperty("board_info") &&
                        __flex_g_settings.board_info.hasOwnProperty("board_logo_url") &&
                        !(["", null, undefined, "undefined", "null"].includes(__flex_g_settings.board_info.board_logo_url))
                    ) {
                    	if( property.board_id != "35" || ( property.board_id == "35" && property.rg_id == "34")  ) {
							infobox_content.push('<div class="ib-ibpb"><img onerror="this.src=\'https://www.idxboost.com/i/default_thumbnail.jpg\';" class="ib-ibimg" src="'+property.item.thumbnail+'"><img src="'+__flex_g_settings.board_info.board_logo_url+'" style="position: absolute;bottom: 10px;z-index: 2;width: 80px;right: 10px;height:auto"></div>');
						}
                    }else{
					  infobox_content.push('<div class="ib-ibpb"><img onerror="this.src=\'https://www.idxboost.com/i/default_thumbnail.jpg\';" class="ib-ibimg" src="'+property.item.thumbnail+'"></div>');
                    }


			// if ((null != property.item.image) && (property.item.image.length > 0) ) {
			//     // infobox_content.push('<div class="ib-ibpb"><img class="ib-ibimg" src="'+_.getMLSImage(property.item.mls_num, property.item.image)+'"></div>');
			//     infobox_content.push('<div class="ib-ibpb"><img class="ib-ibimg" src="'+property.item.thumbnail+'"></div>');
			// } else {
			//     infobox_content.push('<div class="ib-ibpb"><img class="ib-ibimg" src="https://www.idxboost.com/i/default_thumbnail.jpg"></div>');
			// }

			// infobox_content.push('</li>');
			infobox_content.push('<a href="'+__flex_idx_search_filter.propertyDetailPermalink + "/" + property.item.slug +'"></a></li>');
			infobox_content.push('</ul>');
			infobox_content.push('</div>');
		}
		if (infobox_content.length) {
			if (window.innerWidth < 990) {
				$(".ib-temp-modal-infobox").remove();
				// handle mobile
				let tBottom = 0;
				const $botonera = $('.content-rsp-btn');
				if ($botonera.length && $botonera.is(':visible')) {
					tBottom += $botonera.height() + Number($botonera.css('bottom').replace('px', '')) + 5;
				} else {
					 const $ctas = $('.cta-container');
					if ($ctas.length && $ctas.is(':visible')) tBottom += $ctas.height() + Number($ctas.css('bottom').replace('px', '')) + 5;
				}
				var div = document.createElement("div");
				div.style.cssText = "bottom: " + tBottom + "px;";
				div.setAttribute("class", "ib-temp-modal-infobox");
				div.innerHTML = infobox_content.join("");
				infobox_content.length = 0;
				document.body.appendChild(div);
			} else {
				// handle desktop
				infoWindow.setContent(infobox_content.join(""));
				infoWindow.open(map, marker);
	
				infobox_content.length = 0;
			}
		}
	};
}

function handleMarkerMouseOver(marker) {
	return function() {
		jQuery(marker.a).addClass("ib-search-marker-active");

		IB_LAST_OPENED_MARKER = marker;

		// var markerContent = marker.getContent();

		// if (marker.iblength > 1) {
		//     markerContent = markerContent.replace("dgt-richmarker-group", "dgt-richmarker-group ib-search-marker-active");
		// } else {
		//     markerContent = markerContent.replace("dgt-richmarker-single", "dgt-richmarker-single ib-search-marker-active");
		// }

		// marker.setContent(markerContent);

		marker.setZIndex(google.maps.Marker.MAX_ZINDEX + 1);
	};
}

function handleMarkerMouseOut(marker) {
	return function() {
		jQuery(marker.a).removeClass("ib-search-marker-active");

		// var markerContent = marker.getContent();
		// markerContent = markerContent.replace(" ib-search-marker-active", "");
		// marker.setContent(markerContent);

		marker.setZIndex(google.maps.Marker.MAX_ZINDEX - 1);
	};
}

function getPriceSaleValues(min, max) {
	var r_min = ((null == min) || ("--" == min)) ? 0 : IB_RG_PRICE_SALE_VALUES.indexOf(parseInt(min, 10));
	var r_max = ((null == max) || ("--" == max)) ? (IB_RG_PRICE_SALE_VALUES.length - 1) : IB_RG_PRICE_SALE_VALUES.indexOf(parseInt(max, 10));

	return [ r_min, r_max ];
}

function getPriceRentValues(min, max) {
	var r_min = ((null == min) || ("--" == min)) ? 0 : IB_RG_PRICE_RENT_VALUES.indexOf(parseInt(min, 10));
	var r_max = ((null == max) || ("--" == max)) ? (IB_RG_PRICE_RENT_VALUES.length - 1) : IB_RG_PRICE_RENT_VALUES.indexOf(parseInt(max, 10));

	return [ r_min, r_max ];
}

function getYearValues(min, max) {
	var r_min = (null == min) ? 0 : IB_RG_YEARBUILT_VALUES.indexOf(parseInt(min, 10));
	var r_max = (null == max) ? (IB_RG_YEARBUILT_VALUES.length - 1) : IB_RG_YEARBUILT_VALUES.indexOf(parseInt(max, 10));

	return [ r_min, r_max ];
}

function getBedroomValues(min, max) {
	var r_min = (null == min) ? 0 : IB_RG_BEDROOMS_VALUES.indexOf(parseInt(min, 10));
	var r_max = (null == max) ? (IB_RG_BEDROOMS_VALUES.length - 1) : IB_RG_BEDROOMS_VALUES.indexOf(parseInt(max, 10));

	return [ r_min, r_max ];
}

function getBathroomValues(min, max) {
	var r_min = (null == min) ? 0 : IB_RG_BATHROOMS_VALUES.indexOf(parseInt(min, 10));
	var r_max = (null == max) ? (IB_RG_BATHROOMS_VALUES.length - 1) : IB_RG_BATHROOMS_VALUES.indexOf(parseInt(max, 10));

	return [ r_min, r_max ];
}

function getLivingSizeValues(min, max) {
	var r_min = ((null == min) || ("--" == min)) ? 0 : IB_RG_LIVINGSIZE_VALUES.indexOf(parseInt(min, 10));
	var r_max = ((null == max) || ("--" == max)) ? (IB_RG_LIVINGSIZE_VALUES.length - 1) : IB_RG_LIVINGSIZE_VALUES.indexOf(parseInt(max, 10));

	return [ r_min, r_max ];
}

function getLandSizeValues(min, max) {
	var r_min = ((null == min) || ("--" == min)) ? 0 : IB_RG_LANDSIZE_VALUES.indexOf(parseInt(min, 10));
	var r_max = ((null == max) || ("--" == max)) ? (IB_RG_LANDSIZE_VALUES.length - 1) : IB_RG_LANDSIZE_VALUES.indexOf(parseInt(max, 10));

	return [ r_min, r_max ];
}

function ib_generate_latlng_from_kml(kml) {
	var coords = [];
	var kml_arr = kml.split(',');
	var kml_point;

	for(var i = 0, l = kml_arr.length; i < l; i++) {
		kml_point = kml_arr[i].split(' ');
		coords.push(new google.maps.LatLng(kml_point[0], kml_point[1]));
	}

	return coords;
}

if ("undefined" === typeof loadPropertyInModal) {
	loadPropertyInModal = function(mlsNumber) {
		if (/webOS|iPhone|iPad/i.test(navigator.userAgent)) {
		$('body').addClass('only-mobile');
		}

		window.lastOpenedProperty = mlsNumber;

		if (typeof infoWindow !== 'undefined') {
			if (infoWindow.isOpen()) {
				infoWindow.close();
			}
		}

		var viewListingDetailEndpoint = __flex_idx_search_filter.lookupListingsDetail.replace(/{{mlsNumber}}/g, mlsNumber);

		$.ajax({
			type: "POST",
			url: viewListingDetailEndpoint,
			data: {
				access_token: IB_ACCESS_TOKEN,
				flex_credentials: Cookies.get("ib_lead_token"),
				onimage: "noresize"
			},
			success: function(response) {
				if (response.hasOwnProperty('price')) {
					var price_raw = parseInt(response.price.replace(/[^\d+]/g, ''), 10);
					if ($(".ib_property_signup_price").length) {
						$(".ib_property_signup_price").val(price_raw);
					}
				}

				if (jQuery("#_ib_lead_activity_tab").length) {
					jQuery("#_ib_lead_activity_tab button:eq(0)").click();
				}

				// track property [statcounter]
				if (typeof IB_TRACKING_IFRAME !== "undefined") {
					$(IB_TRACKING_IFRAME).remove();
				}

				// dataLayer Tracking Single
				if ("undefined" !== typeof dataLayer) {
					if (__flex_g_settings.hasOwnProperty("has_dynamic_remarketing") && ("1" == __flex_g_settings.has_dynamic_remarketing)) {
						if ( response.hasOwnProperty("mls_num") && response.hasOwnProperty("price") ) {
							var int_price = parseInt(response.price.replace(/[^\d+]/g, ""));
							dataLayer.push({"event": "view_item","value": int_price,"items": [{"id": response.mls_num,"google_business_vertical": "real_estate"}]});
						}
					}
				}

				setTimeout(function () {
					if( $(".ib-property-mortage-submit").length >0 ){
						var pp = response.price;
						$(".ib-property-mortgage-f:eq(0)").trigger("reset");
		                $("#calculatorYears").text(30+" "+word_translate.years);
		                $(".ib-property-mc-ir, #interest_rate_txt").val(__flex_g_settings.interes_rate[30]);						
						var dp = $(".ib-property-mc-dp:eq(0)").val();
						var ty = $(".ib-property-mc-ty:eq(0)").val();
						var ir = $(".ib-property-mc-ir:eq(0)").val();
						var calc_mg = calculate_mortgage(pp, dp, ty, ir);
						$(".ib-price-calculator").text("$" + calc_mg.monthly+"/mo");
				// update form
						$(".js-est-payment").hide();
						if (response.is_rental=="0") {
							$(".js-est-payment").show();
						}
					}
				}, 1000);

				
				IB_TRACKING_IFRAME = document.createElement("iframe");
				IB_TRACKING_IFRAME.setAttribute("id", "__ib-tracking-iframe");
				IB_TRACKING_IFRAME.setAttribute("src", __flex_idx_search_filter.propertyDetailPermalink + "/" + response.slug);
				IB_TRACKING_IFRAME.style.width = "1px";
				IB_TRACKING_IFRAME.style.height = "1px";
				//document.body.appendChild(IB_TRACKING_IFRAME);

				IB_TRACKING_IFRAME.onload = function() {
					setTimeout(function () {
						$(IB_TRACKING_IFRAME).remove();
					}, 3000);
				};

				if (IB_MODAL_WRAPPER.length && IB_MODAL_TPL.length) {
					var template = Handlebars.compile(IB_MODAL_TPL.html());

					IB_MODAL_WRAPPER.html(template(response));

					var rfn = (typeof Cookies.get("_ib_user_firstname") !== "undefined") ? Cookies.get("_ib_user_firstname") : "";
					var rln = (typeof Cookies.get("_ib_user_lastname") !== "undefined") ? Cookies.get("_ib_user_lastname") : "";
					var remail = (typeof Cookies.get("_ib_user_email") !== "undefined") ? Cookies.get("_ib_user_email") : "";
					var rphone = (typeof Cookies.get("_ib_user_phone") !== "undefined" && Cookies.get("_ib_user_phone")!="null" ) ? Cookies.get("_ib_user_phone") : "";

					$("#_ib_fn_inq").val(rfn);
					$("#_ib_ln_inq").val(rln);
					$("#_ib_em_inq").val(remail);
					

					if ( parseInt(response.img_cnt, 10) > 0) {
						IB_MODAL_SLIDER = IB_MODAL_WRAPPER.find(".ib-pvslider:eq(0)");

						if (response.gallery.length) {

						IB_MODAL_SLIDER = IB_MODAL_SLIDER.greatSlider({
								type: 'swipe',
							  nav: true,
							  bullets: false,
							  lazyLoad: true,
								navSpeed: 150,
							  layout: {
								  arrowDefaultStyles: false
							  },
							  //fullscreen: true,
								fullscreen: false,
							  layout: {
								  fsButtonDefaultStyles: false,
								  fsButtonClass: 'ib-btnfs'
							  },
							  breakPoints: {
								  640: {
									  items: 2
								  },
								  1024: {
									  items: 3
								  }
							  },
							  
								onInited: function() {

									/*var windowSize = $(window).width();
									if(windowSize > 767){
										IB_MODAL_WRAPPER.find('.gs-item-slider').on('click', function(){
											IB_MODAL_SLIDER.fullscreen('in', $(this).index() + 1);
										});
									}

									// Creando la numeración en FS
									const $ibmpNumbers = IB_MODAL_WRAPPER.find('.ib-pvsinumber');
									if (!$ibmpNumbers.length) {
										IB_MODAL_WRAPPER.find('.gs-container-items').append('<span class="ib-pvsinumber">' + (IB_MODAL_WRAPPER.find('.gs-item-active').index() + 1) + ' of ' + IB_MODAL_WRAPPER.find('.ib-pvsitem').length + '</span>');
									} else {
										IB_MODAL_WRAPPER.find('.ib-pvsinumber').text((IB_MODAL_WRAPPER.find('.gs-item-active').index() + 1) + ' of ' + IB_MODAL_WRAPPER.find('.ib-pvsitem').length)
									}*/

							  },

							  onLoadedItem: function(item, index, response) {
									if ("success" != response) {
										setTimeout(function () {
											item.attr("src", "https://www.idxboost.com/i/default_thumbnail.jpg");
										}, 2000);
									}
							  },

							  onFullscreenIn: ()=> {
									// creando el título en FS
									/*const $ibmpTitle = IB_MODAL_WRAPPER.find('.ib-pvsititle');
									if (!$ibmpTitle.length) {
										IB_MODAL_WRAPPER.find('.gs-container-items').append('<span class="ib-pvsititle">' + $('.ib-ptitle').text() + ' ' + $('.ib-pstitle').text() + '</span>');
									}*/
							  },

								onStepEnd: ($itemActivo, indexIA)=> {
									//if (IB_MODAL_WRAPPER.find(".ib-pvslider:eq(0)").hasClass('gs-infs')) {
										////IB_MODAL_WRAPPER.find('.ib-pvsinumber').text(indexIA + ' of ' + IB_MODAL_WRAPPER.find('.ib-pvsitem').length)
									//}
							  }
						  });
							jQuery(".ib-full-screen").removeClass("hidden");
					}
				}else{

					jQuery(".ib-full-screen").addClass("hidden");
				}

					if (0 === parseInt(response.img_cnt, 10)) {
						var myLatLng = { lat: parseFloat(response.lat), lng: parseFloat(response.lng) };

						var map = new google.maps.Map(IB_MODAL_WRAPPER.find(".ib-pmap")[0], {
							zoom: 18,
							center: myLatLng,
							styles: style_map,
							gestureHandling: 'cooperative',
							panControl: false,
							scrollwheel: false,
							disableDoubleClickZoom: true,
							disableDefaultUI: true,
							streetViewControl: true,
						});
				
						var marker = new google.maps.Marker({
						position: myLatLng,
						map: map
						});
					}

					// default map view [outside]
					if ($("#ib-modal-property-map").length) {
						var myLatLng2 = { lat: parseFloat(response.lat), lng: parseFloat(response.lng) };

						var map2 = new google.maps.Map(document.getElementById("ib-modal-property-map"), {
							zoom: 18,
							center: myLatLng2,
							styles: style_map,
							gestureHandling: 'cooperative',
							panControl: false,
							scrollwheel: false,
							disableDoubleClickZoom: true,
							disableDefaultUI: true,
							streetViewControl: true,
						});
				
						var marker2 = new google.maps.Marker({
								position: myLatLng2,
								map: map2
						});

						google.maps.event.addListenerOnce(map2, 'tilesloaded', setupMapControls2);

						function handleSatelliteButton(event){
							event.stopPropagation();
							event.preventDefault();
							map2.setMapTypeId(google.maps.MapTypeId.HYBRID)
						
							if($(this).hasClass("is-active")){
								$(this).removeClass("is-active");
								map2.setMapTypeId(google.maps.MapTypeId.ROADMAP)
							}else{
								$(this).addClass("is-active");
								map2.setMapTypeId(google.maps.MapTypeId.HYBRID)
							}
						}
						
						function handleZoomInButton(event) {
							event.stopPropagation();
							event.preventDefault();
							map2.setZoom(map2.getZoom() + 1);
						}
						
						function handleZoomOutButton(event) {
							event.stopPropagation();
							event.preventDefault();
							map2.setZoom(map2.getZoom() - 1);
						}
						
						function handlefullscreenButton() {
						
							var elementToSendFullscreen = map2.getDiv().firstChild;
						
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
						
						function setupMapControls2() {
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
							map2.controls[google.maps.ControlPosition.TOP_RIGHT].push(mapButtonsWrapper);
						}
					}

					// Web Share API
					// if ('share' in navigator) { // for mobile
					if (/iPhone|iPad|iPod|Android/i.test(navigator.userAgent)) {
						document.title = 'Checkout this property #' + response.mls_num + ' ' + response.address_short + ' ' + response.address_large;
						history.pushState(null, null, __flex_g_settings.propertyDetailPermalink + "/" + response.slug);
					} else { // for desktop
						var urlParams = new URLSearchParams(window.location.search);
						urlParams.set("show", response.mls_num);
						history.pushState(null, null, '?' + urlParams.toString());
					}

					// var urlParams = new URLSearchParams(window.location.search);
					// urlParams.set("show", response.mls_num);
					// history.pushState(null, null, '?' + urlParams.toString());

					if ("yes" === __flex_g_settings.anonymous) {
						var _ib_user_listing_views = JSON.parse(Cookies.get("_ib_user_listing_views"));

						if (-1 === $.inArray(response.mls_num, _ib_user_listing_views)) {
							_ib_user_listing_views.push(response.mls_num);
							Cookies.set("_ib_user_listing_views", JSON.stringify(_ib_user_listing_views));
						}
					}
					
					if ("undefined" === typeof Cookies.get("_ib_disabled_forcereg")) {
						if (true === IB_HAS_LEFT_CLICKS) {
							// IB_CURRENT_LEFT_CLICKS = (parseInt(Cookies.get("_ib_left_click_force_registration"), 10) - 1);
							// Cookies.set("_ib_left_click_force_registration", IB_CURRENT_LEFT_CLICKS);

							IB_CURRENT_LEFT_CLICKS = parseInt(Cookies.get("_ib_left_click_force_registration"), 10);
							Cookies.set("_ib_left_click_force_registration", IB_CURRENT_LEFT_CLICKS + 1);

							if ((parseInt(Cookies.get("_ib_left_click_force_registration"), 10) >= parseInt(__flex_g_settings.signup_left_clicks, 10)) && ("yes" === __flex_g_settings.anonymous)) {

							//if ((parseInt(Cookies.get("_ib_left_click_force_registration"), 10) <= 0) && ("yes" === __flex_g_settings.anonymous)) {
								// no left click then open popup registration
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

								$("button.close-modal").addClass("ib-close-mproperty");
								$(".overlay_modal").css("background-color", "rgba(0,0,0,0.8);");

					$("#modal_login h2").html(
						$("#modal_login")
						.find("[data-tab]:eq(1)")
						.data("text-force")
					);

					/*Asigamos el texto personalizado*/
					var titleText = $(".header-tab a[data-tab='tabRegister']").attr('data-text')
					$("#modal_login .modal_cm .content_md .heder_md .ms-title-modal").html(titleText);

					// reset to default clicks
					//IB_CURRENT_LEFT_CLICKS = IB_DEFAULT_LEFT_CLICKS;
					}
				} else {
					if ("yes" === __flex_g_settings.anonymous) {
					if (
						__flex_g_settings.hasOwnProperty("force_registration") &&
						1 == __flex_g_settings.force_registration
					) {
						// console.log("is forced registration");
						// if ($(".register").length) {
						// $(".register").click();
						$("#modal_login")
						.addClass("active_modal")
						.find("[data-tab]")
						.removeClass("active");

						$("#modal_login")
						.addClass("active_modal")
						.find("[data-tab]:eq(1)")
						.addClass("active");

						$("#modal_login").find(".item_tab").removeClass("active");

						$("#tabRegister").addClass("active");

						$("button.close-modal").addClass("ib-close-mproperty");
						$(".overlay_modal").css(
						"background-color",
						"rgba(0,0,0,0.8);"
						);

						$("#modal_login h2").html(
						$("#modal_login")
							.find("[data-tab]:eq(1)")
							.data("text-force")
						);

						/*Asigamos el texto personalizado*/
						var titleText = $(".header-tab a[data-tab='tabRegister']").attr('data-text')
						$("#modal_login .modal_cm .content_md .heder_md .ms-title-modal").html(titleText);
						// }
					}
					}
				}
				}
				// if ("yes" === __flex_g_settings.anonymous) {
				//     if ( (__flex_g_settings.hasOwnProperty("force_registration")) && (1 == __flex_g_settings.force_registration) ) {
				//         console.log("is forced registration");
				//         // if ($(".register").length) {
				//             // $(".register").click();
				//             $("#modal_login").addClass("active_modal")
				//             .find('[data-tab]').removeClass('active');

				//             $("#modal_login").addClass("active_modal")
				//                 .find('[data-tab]:eq(1)')
				//                 .addClass('active');

				//             $("#modal_login")
				//                 .find(".item_tab")
				//                 .removeClass("active");

				//             $("#tabRegister")
				//             .addClass("active");

					//             $("button.close-modal").addClass("ib-close-mproperty");
					//             $(".overlay_modal").css("background-color", "rgba(0,0,0,0.8);");

					//             $("#modal_login h2").html($("#modal_login").find('[data-tab]:eq(1)').data("text-force"));
					//         // }
					//     }
					// }

					// request new token each render of inquiry form for property modal
					if ( __flex_g_settings.hasOwnProperty("google_recaptcha_public_key") && ("" != __flex_g_settings.google_recaptcha_public_key) ) {
						$('.ib-propery-inquiry-f:eq(0)').find('input[name="recaptcha_response"]').remove();
						grecaptcha.execute(__flex_g_settings.google_recaptcha_public_key).then(function(token) {
							$('.ib-propery-inquiry-f:eq(0)').append('<input type="hidden" name="recaptcha_response" value="' + token + '">');
							// console.dir(token);
						});
					}
				}

				var ob_form_modal;
				ob_form_modal=jQuery('.ib-propery-inquiry-f');
				if (ob_form_modal.length>0){
				  ob_form_modal.find('[name="first_name"]').val(rfn);
				  ob_form_modal.find('[name="last_name"]').val(rln);
				  ob_form_modal.find('[name="email_address"]').val(remail);
				  ob_form_modal.find('[name="phone_number"]').val(Cookies.get("_ib_user_new_phone_number"));
				  ob_form_modal.find('[name="phoneCodeValidation"]').val("");
				}
				defaultFormValidation();
			}
		});

		// console.log('Open Property #' + mlsNumber + " in modal.");
	}
	// window.loadPropertyInModal = loadPropertyInModal;
}

function markPropertyAsFavorite(mlsNumber, element, from) {
	var markPropertyAsFavoriteEndpoint = __flex_idx_search_filter.trackListingsDetail.replace(/{{mlsNumber}}/g, mlsNumber);

	// console.dir([mlsNumber, element, from]);

	$.ajax({
		type: "POST",
		url: markPropertyAsFavoriteEndpoint,
		data: {
			access_token: IB_ACCESS_TOKEN,
			flex_credentials: Cookies.get("ib_lead_token"),
			url_origin: location.origin,
			url_referer: document.referrer,
			user_agent: navigator.userAgent
		},
		success: function(response) {
			if ("add" === response.type) {
				$(this).data("token-alert", response.token_alert);
			} else {
				$(this).data("token-alert", "");
			}

			if ("modal" === from) {
				if ("add" === response.type) {
					IB_LISTINGS_CT.find(".ib-pfavorite").each(function () {
						var mlsData = $(this).data("mls");

						if (mlsData === mlsNumber) {
							$(this).addClass("ib-pf-active");
							$(this).data("token-alert", response.token_alert);
						}
					});
				} else {
					IB_LISTINGS_CT.find(".ib-pfavorite").each(function () {
						var mlsData = $(this).data("mls");

						if (mlsData === mlsNumber) {
							$(this).removeClass("ib-pf-active");
						}
					});
				}
			}

			if (jQuery("#_ib_lead_activity_tab").length) {
				jQuery("#_ib_lead_activity_tab button:eq(1)").click();
			}
		}
	});

	// console.log('Track #' + mlsNumber + " as favorite.");
}

function buildMobileForm() {
	var ib_search_filter_params = __flex_idx_search_filter.search;
	var ib_search_filter_frag = [];
	var ib_search_filter_dropdown;

	ib_min_price = $("#ib-min-price");
	ib_max_price = $("#ib-max-price");

	ib_min_rent_price = $("#ib-min-rent-price");
	ib_max_rent_price = $("#ib-max-rent-price");

	ib_min_beds = $("#ib-min-beds");
	ib_max_beds = $("#ib-max-beds");

	ib_min_baths = $("#ib-min-baths");
	ib_max_baths = $("#ib-max-baths");

	ib_m_types = $("#ib-flex-m-types");

	ib_m_parking = $("#ib-flex-m-parking");

	ib_min_living = $("#ib-min-living");
	ib_max_living = $("#ib-max-living");

	ib_min_land = $("#ib-min-land");
	ib_max_land = $("#ib-max-land");

	ib_min_year = $("#ib-min-year");
	ib_max_year = $("#ib-max-year");

	ib_waterfront_switch = $("#ib-flex-waterfront-switch");

	ib_m_features = $("#ib-flex-m-features");

	ib_m_features_exta = $("#ib-flex-m-features-extra");

	// FOR SALE [MOBILE]
	if (ib_min_price.length) {
		ib_search_filter_dropdown = ib_search_filter_params.price_sale_range;
		ib_search_filter_dropdown.splice(-1, 1);

		for(var i = 0, l = ib_search_filter_dropdown.length; i < l; i++) {
			var option = ib_search_filter_dropdown[i];
			if (("--" == option.value) || (0 == option.value)) {
				option.label = word_translate.any_price;
				option.value = "";
			}
			ib_search_filter_frag.push('<option value="'+option.value+'">'+option.label+'</option>');
		}

		if (ib_search_filter_frag.length) {
			ib_min_price.html(ib_search_filter_frag.join(""));
			ib_search_filter_frag.length = 0;
		}
	}

	// FOR SALE [MOBILE]
	if (ib_max_price.length) {
		ib_search_filter_dropdown = ib_search_filter_params.price_sale_range;
		ib_search_filter_dropdown.splice(-1, 1);

		// ib_search_filter_frag.push('<option value="--">'+word_translate.any+'</option>');

		for(var i = 0, l = ib_search_filter_dropdown.length; i < l; i++) {
			var option = ib_search_filter_dropdown[i];
			if (("--" == option.value) || (0 == option.value)) {
				option.label = word_translate.any_price;
				option.value = "";
			}
			ib_search_filter_frag.push('<option value="'+option.value+'">'+option.label+'</option>');
		}

		if (ib_search_filter_frag.length) {
			ib_max_price.html(ib_search_filter_frag.join(""));
			ib_search_filter_frag.length = 0;
		}
	}

	// FOR RENT [MOBILE]
	if (ib_min_rent_price.length) {
		ib_search_filter_dropdown = ib_search_filter_params.price_rent_range;
		ib_search_filter_dropdown.splice(-1, 1);

		for(var i = 0, l = ib_search_filter_dropdown.length; i < l; i++) {
			var option = ib_search_filter_dropdown[i];
			if (("--" == option.value) || (0 == option.value)) {
				option.label = word_translate.any_price;
				option.value = "";
			}
			ib_search_filter_frag.push('<option value="'+option.value+'">'+option.label+'</option>');
		}

		if (ib_search_filter_frag.length) {
			ib_min_rent_price.html(ib_search_filter_frag.join(""));
			ib_search_filter_frag.length = 0;
		}
	}

	// FOR RENT [MOBILE]
	if (ib_max_rent_price.length) {
		ib_search_filter_dropdown = ib_search_filter_params.price_rent_range;
		ib_search_filter_dropdown.splice(-1, 1);

		// ib_search_filter_frag.push('<option value="--">'+word_translate.any+'</option>');

		for(var i = 0, l = ib_search_filter_dropdown.length; i < l; i++) {
			var option = ib_search_filter_dropdown[i];
			if (("--" == option.value) || (0 == option.value)) {
				option.label = word_translate.any_price;
				option.value = "";
			}
			ib_search_filter_frag.push('<option value="'+option.value+'">'+option.label+'</option>');
		}

		if (ib_search_filter_frag.length) {
			ib_max_rent_price.html(ib_search_filter_frag.join(""));
			ib_search_filter_frag.length = 0;
		}
	}

	// FOR BEDS [MOBILE]
	if (ib_min_beds.length) {
		ib_search_filter_dropdown = ib_search_filter_params.beds_range;

		ib_search_filter_frag.push('<option value="--">'+word_translate.any+'</option>');

		for(var i = 0, l = ib_search_filter_dropdown.length; i < l; i++) {
			var option = ib_search_filter_dropdown[i];
			ib_search_filter_frag.push('<option value="'+option.value+'">'+option.label+'</option>');
		}

		if (ib_search_filter_frag.length) {
			ib_min_beds.html(ib_search_filter_frag.join(""));
			ib_search_filter_frag.length = 0;
		}
	}

	// FOR BEDS [MOBILE]
	if (ib_max_beds.length) {
		ib_search_filter_dropdown = ib_search_filter_params.beds_range;

		ib_search_filter_frag.push('<option value="--">'+word_translate.any+'</option>');


		for(var i = 0, l = ib_search_filter_dropdown.length; i < l; i++) {
			var option = ib_search_filter_dropdown[i];
			ib_search_filter_frag.push('<option value="'+option.value+'">'+option.label+'</option>');
		}

		if (ib_search_filter_frag.length) {
			ib_max_beds.html(ib_search_filter_frag.join(""));
			ib_search_filter_frag.length = 0;
		}
	}

	// FOR BATHS [MOBILE]
	if (ib_min_baths.length) {
		ib_search_filter_dropdown = _.filter(ib_search_filter_params.baths_range, function (row) { return !(row.value % 1 != 0);  });

		ib_search_filter_frag.push('<option value="--">'+word_translate.any+'</option>');

		for(var i = 0, l = ib_search_filter_dropdown.length; i < l; i++) {
			var option = ib_search_filter_dropdown[i];
			ib_search_filter_frag.push('<option value="'+option.value+'">'+option.label+'</option>');
		}

		if (ib_search_filter_frag.length) {
			ib_min_baths.html(ib_search_filter_frag.join(""));
			ib_search_filter_frag.length = 0;
		}
	}

	// FOR BATHS [MOBILE]
	if (ib_max_baths.length) {
		ib_search_filter_dropdown = _.filter(ib_search_filter_params.baths_range, function (row) {  return !(row.value % 1 != 0);  });

		ib_search_filter_frag.push('<option value="--">'+word_translate.any+'</option>');

		for(var i = 0, l = ib_search_filter_dropdown.length; i < l; i++) {
			var option = ib_search_filter_dropdown[i];
			ib_search_filter_frag.push('<option value="'+option.value+'">'+option.label+'</option>');
		}

		if (ib_search_filter_frag.length) {
			ib_max_baths.html(ib_search_filter_frag.join(""));
			ib_search_filter_frag.length = 0;
		}
	}

	// FOR TYPES [MOBILE]
	if (ib_m_types.length) {
		ib_search_filter_dropdown = ib_search_filter_params.property_types;
		// console.log('build property types for mobile');

		for(var i = 0, l = ib_search_filter_dropdown.length; i < l; i++) {
			var option = ib_search_filter_dropdown[i];
			var text_translate = '';

			if ('Single Family Homes' == option.label ){
				text_translate = word_translate.single_family_homes;
			}else if ('Condominiums' == option.label){
				text_translate = word_translate.condominiums;
			}else if ('Townhouses' == option.label){
				text_translate = word_translate.townhouses;
			}else{
				text_translate = option.label;
			}

			ib_search_filter_frag.push('<li class="ib-item-wrap-fm ib-btn-chk-fm"><input class="ib-m-types-checkboxes" type="checkbox" value="'+option.value+'" id="s_types_'+option.value+'"><label for="s_types_'+option.value+'">'+text_translate+'</label></li>');
		}

		if (ib_search_filter_frag.length) {
			ib_m_types.html(ib_search_filter_frag.join(""));
			ib_search_filter_frag.length = 0;
		}
	}

	// FOR PARKING MOBILE
	if (ib_m_parking.length) {
		ib_search_filter_dropdown = ib_search_filter_params.parking_options;
		ib_search_filter_frag.push('<li class="ib-item-wrap-fm ib-btn-chk-fm"><input class="ib-m-parking-checkboxes" name="ib_m_s_parking" type="radio" value="--" id="s_parking_any"><label for="s_parking_any">'+word_translate.any+'</label></li>');
		
		for(var i = 0, l = ib_search_filter_dropdown.length; i < l; i++) {
			var option = ib_search_filter_dropdown[i];

			ib_search_filter_frag.push('<li class="ib-item-wrap-fm ib-btn-chk-fm"><input name="ib_m_s_parking" type="radio" value="'+option.value+'" id="s_parking_'+option.value+'"><label for="s_parking_'+option.value+'">'+option.label+'</label></li>');
		}

		if (ib_search_filter_frag.length) {
			ib_m_parking.html(ib_search_filter_frag.join(""));
			ib_search_filter_frag.length = 0;
		}
	}

	// FOR LIVING [MOBILE]
	if (ib_min_living.length) {
		ib_search_filter_dropdown = ib_search_filter_params.living_size_range;
		ib_search_filter_dropdown.splice(-1, 1);

		ib_search_filter_frag.push('<option value="--">'+word_translate.any+'</option>');

		for(var i = 0, l = ib_search_filter_dropdown.length; i < l; i++) {
			var option = ib_search_filter_dropdown[i];
			if ("--" == option.value) {
				ib_search_filter_frag.push('<option value="'+option.value+'">'+option.label+'</option>');
			} else {
				ib_search_filter_frag.push('<option value="'+option.value+'">'+_.formatPrice(option.label)+' Sq.Ft.</option>');
			}
		}

		if (ib_search_filter_frag.length) {
			ib_min_living.html(ib_search_filter_frag.join(""));
			ib_search_filter_frag.length = 0;
		}
	}

	// FOR LIVING [MOBILE]
	if (ib_max_living.length) {
		ib_search_filter_dropdown = ib_search_filter_params.living_size_range;
		ib_search_filter_dropdown.splice(-1, 1);

		ib_search_filter_frag.push('<option value="--">'+word_translate.any+'</option>');

		for(var i = 0, l = ib_search_filter_dropdown.length; i < l; i++) {
			var option = ib_search_filter_dropdown[i];
			if ("--" == option.value) {
				ib_search_filter_frag.push('<option value="'+option.value+'">'+option.label+'</option>');
			} else {
				ib_search_filter_frag.push('<option value="'+option.value+'">'+_.formatPrice(option.label)+' Sq.Ft.</option>');
			}
		}

		if (ib_search_filter_frag.length) {
			ib_max_living.html(ib_search_filter_frag.join(""));
			ib_search_filter_frag.length = 0;
		}
	}

	// FOR LAND [MOBILE]
	if (ib_min_land.length) {
		ib_search_filter_dropdown = ib_search_filter_params.lot_size_range;
		ib_search_filter_dropdown.splice(-1, 1);

		ib_search_filter_frag.push('<option value="--">'+word_translate.any+'</option>');

		for(var i = 0, l = ib_search_filter_dropdown.length; i < l; i++) {
			var option = ib_search_filter_dropdown[i];
			if ("--" == option.value) {
				ib_search_filter_frag.push('<option value="'+option.value+'">'+option.label+'</option>');
			} else {
				ib_search_filter_frag.push('<option value="'+option.value+'">'+_.formatPrice(option.label)+' Sq.Ft.</option>');
			}
		}

		if (ib_search_filter_frag.length) {
			ib_min_land.html(ib_search_filter_frag.join(""));
			ib_search_filter_frag.length = 0;
		}
	}

	// FOR LAND [MOBILE]
	if (ib_max_land.length) {
		ib_search_filter_dropdown = ib_search_filter_params.lot_size_range;
		ib_search_filter_dropdown.splice(-1, 1);

		ib_search_filter_frag.push('<option value="--">'+word_translate.any+'</option>');

		for(var i = 0, l = ib_search_filter_dropdown.length; i < l; i++) {
			var option = ib_search_filter_dropdown[i];
			if ("--" == option.value) {
				ib_search_filter_frag.push('<option value="'+option.value+'">'+option.label+'</option>');
			} else {
				ib_search_filter_frag.push('<option value="'+option.value+'">'+_.formatPrice(option.label)+' Sq.Ft.</option>');
			}
		}

		if (ib_search_filter_frag.length) {
			ib_max_land.html(ib_search_filter_frag.join(""));
			ib_search_filter_frag.length = 0;
		}
	}

	// FOR YEAR [MOBILE]
	if (ib_min_year.length) {
		ib_search_filter_dropdown = ib_search_filter_params.year_built_range;
		ib_search_filter_dropdown.splice(-1, 1);

		ib_search_filter_frag.push('<option value="--">'+word_translate.any+'</option>');

		for(var i = 0, l = ib_search_filter_dropdown.length; i < l; i++) {
			var option = ib_search_filter_dropdown[i];
			ib_search_filter_frag.push('<option value="'+option.value+'">'+option.label+'</option>');
		}

		ib_search_filter_frag.push('<option value="'+current_year+'">'+current_year+'</option>');

		if (ib_search_filter_frag.length) {
			ib_min_year.html(ib_search_filter_frag.join(""));
			ib_search_filter_frag.length = 0;
		}
	}

	// FOR YEAR [MOBILE]
	if (ib_max_year.length) {
		ib_search_filter_dropdown = ib_search_filter_params.year_built_range;
		ib_search_filter_dropdown.splice(-1, 1);

		ib_search_filter_frag.push('<option value="--">'+word_translate.any+'</option>');
		ib_search_filter_frag.push('<option value="'+current_year+'">'+current_year+'</option>');

		for(var i = 0, l = ib_search_filter_dropdown.length; i < l; i++) {
			var option = ib_search_filter_dropdown[i];
			ib_search_filter_frag.push('<option value="'+option.value+'">'+option.label+'</option>');
		}

		ib_search_filter_frag.push('<option value="1900">1900</option>');

		if (ib_search_filter_frag.length) {
			ib_max_year.html(ib_search_filter_frag.join(""));
			ib_search_filter_frag.length = 0;
		}
	}

	// FOR WATERFRONT [MOBILE]
	if (ib_waterfront_switch.length) {
		ib_search_filter_dropdown = _.sortBy(ib_search_filter_params.waterfront_options, "name");
		ib_search_filter_frag.push('<option value="--">'+word_translate.any+'</option>');

		for(var i = 0, l = ib_search_filter_dropdown.length; i < l; i++) {
			var option = ib_search_filter_dropdown[i];
			ib_search_filter_frag.push('<option value="'+option.code+'">'+option.name+'</option>');
		}

		if (ib_search_filter_frag.length) {
			ib_waterfront_switch.html(ib_search_filter_frag.join(""));
			ib_search_filter_frag.length = 0;
		}
	}

	// FOR FEATURES [MOBILE]
	if (ib_m_features.length) {
		ib_search_filter_dropdown = _.sortBy(ib_search_filter_params.amenities, "name");

		for(var i = 0, l = ib_search_filter_dropdown.length; i < l; i++) {
			var option = ib_search_filter_dropdown[i];

			if (("equestrian" ==option.code) && (__flex_idx_search_filter.boardId != "3")) {
				continue;
			}

			if (("loft" ==option.code) && (__flex_idx_search_filter.boardId != "5")) {
				continue;
			}
			var text_caracteristics ='';

			if(option.name=='Swimming Pool')
				text_caracteristics=word_translate.swimming_pool;
			else if (option.name=='Golf Course')
				text_caracteristics=word_translate.golf_course;
			else if (option.name=='Tennis Courts')
				text_caracteristics=word_translate.tennis_courts;
			else if (option.name=='Gated Community')
				text_caracteristics=word_translate.gated_community;
			else if (option.name=='Lofts')
				text_caracteristics=word_translate.lofts;
			else if (option.name=='Penthouse')
				text_caracteristics=word_translate.penthouse;
			else if (option.name=="Waterfront")
				text_caracteristics=word_translate.water_front;
			else if (option.name=="Pets")
				text_caracteristics=word_translate.pets;
			else if (option.name=="Furnished")
				text_caracteristics=word_translate.furnished;
			else if (option.name=="Equestrian")
				text_caracteristics=word_translate.equestrian;
			else if (option.name=="Short Sale")
				text_caracteristics=word_translate.short_sales;
			else if (option.name=="Foreclosure")
				text_caracteristics=word_translate.foreclosures;
			else if (option.name=="Boat Dock")
				text_caracteristics=word_translate.boat_dock;
			else if (option.name=="Housing Older Persons")
				text_caracteristics=word_translate.housing_older_persons;
			else if (option.name=="Occupied")
				text_caracteristics=word_translate.occupied;
			else if (option.name=="Vacant")
				text_caracteristics=word_translate.vacant;

			else if (option.name=="Park Greenbelt")
				text_caracteristics=word_translate.park_greenbelt;
			else if (option.name=="Mountains")
				text_caracteristics=word_translate.mountains;
			else if (option.name=="Strip View")
				text_caracteristics=word_translate.strip_view;
			else if (option.name=="River")
				text_caracteristics=word_translate.river;
			else if (option.name=="Lagoon")
				text_caracteristics=word_translate.lagoon;
			else if (option.name=="City")
				text_caracteristics=word_translate.city;
			else if (option.name=="Ocean")
				text_caracteristics=word_translate.ocean;
			else if (option.name=="Garden")
				text_caracteristics=word_translate.garden;
			else if (option.name=="Tennis Court")
				text_caracteristics=word_translate.tennis_court;
			else if (option.name=="Water")
				text_caracteristics=word_translate.water;
			else if (option.name=="Pool")
				text_caracteristics=word_translate.pool;
			else if (option.name=="Golf Course")
				text_caracteristics=word_translate.golf_course;          
			
			else if (option.name=="Park Greenbelt")
				text_caracteristics=word_translate.park_greenbelt;
			else if (option.name=="Strip View")
				text_caracteristics=word_translate.strip_view;
			else if (option.name=="City")
				text_caracteristics=word_translate.city;
			else if (option.name=="Golf")
				text_caracteristics=word_translate.golf;
			else if (option.name=="Court yard")
				text_caracteristics=word_translate.court_yard;          
			else if (option.name=="Pool")
				text_caracteristics=word_translate.pool;
			else if (option.name=="Mountain")
				text_caracteristics=word_translate.mountain;          
			else if (option.name=="Lake")
				text_caracteristics=word_translate.lake;          

			else if (option.name=="Bay")
				text_caracteristics=word_translate.bay;
			else if (option.name=="Gulf")
				text_caracteristics=word_translate.gulf;
			else if (option.name=="Creek")
				text_caracteristics=word_translate.creek;
			else if (option.name=="Pond")
				text_caracteristics=word_translate.pond;
			else if (option.name=="Marsh")
				text_caracteristics=word_translate.marsh;
			else if (option.name=="Mangrove")
				text_caracteristics=word_translate.mangrove;          
			else if (option.name=="Navigable")
				text_caracteristics=word_translate.navigable;
			else if (option.name=="River Frontage")
				text_caracteristics=word_translate.river_frontage;
			else if (option.name=="Basin")
				text_caracteristics=word_translate.basin;
			else if (option.name=="Seawall")
				text_caracteristics=word_translate.seawall;
			else if (option.name=="Lake")
				text_caracteristics=word_translate.lake;
			else if (option.name=="Water Access")
				text_caracteristics=word_translate.water_access;
			else
				text_caracteristics=option.name;



			ib_search_filter_frag.push('<li class="ib-item-wrap-fm ib-btn-chk-fm"><input class="ib-m-features-checkboxes" type="checkbox" value="'+option.code+'" id="s_amenity_'+option.code+'"><label for="s_amenity_'+option.code+'">'+text_caracteristics+'</label></li>');
		}

		if (ib_search_filter_frag.length) {
			ib_m_features.html(ib_search_filter_frag.join(""));
			ib_search_filter_frag.length = 0;
		}
	}


        // FOR FEATURES [MOBILE]
        if (ib_m_features_exta.length) {
            ib_search_filter_dropdown = _.sortBy(ib_search_filter_params.otherpopularfeatures, "name");

            for (var i = 0, l = ib_search_filter_dropdown.length; i < l; i++) {
                var option = ib_search_filter_dropdown[i];

                if (("equestrian" == option.code) && (__flex_idx_search_filter.boardId != "3")) {
                    continue;
                }

                if (("loft" == option.code) && (__flex_idx_search_filter.boardId != "5")) {
                    continue;
                }

                var text_caracteristics = '';

                if (option.name == 'Swimming Pool')
                    text_caracteristics = word_translate.swimming_pool;
                else if (option.name == 'Golf Course')
                    text_caracteristics = word_translate.golf_course;
                else if (option.name == 'Tennis Courts')
                    text_caracteristics = word_translate.tennis_courts;
                else if (option.name == 'Gated Community')
                    text_caracteristics = word_translate.gated_community;
                else if (option.name == 'Lofts')
                    text_caracteristics = word_translate.lofts;
                else if (option.name == 'Penthouse')
                    text_caracteristics = word_translate.penthouse;
                else if (option.name == "Waterfront")
                    text_caracteristics = word_translate.water_front;
                else if (option.name == "Pets")
                    text_caracteristics = word_translate.pets;
                else if (option.name == "Furnished")
                    text_caracteristics = word_translate.furnished;
                else if (option.name == "Equestrian")
                    text_caracteristics = word_translate.equestrian;
                else if (option.name == "Short Sale")
                    text_caracteristics = word_translate.short_sales;
                else if (option.name == "Foreclosure")
                    text_caracteristics = word_translate.foreclosures;
                else if (option.name == "Boat Dock")
                    text_caracteristics = word_translate.boat_dock;
                else if (option.name == "Housing Older Persons")
                    text_caracteristics = word_translate.housing_older_persons;
                else if (option.name == "Occupied")
                    text_caracteristics = word_translate.occupied;
                else if (option.name == "Vacant")
                    text_caracteristics = word_translate.vacant;
                else
                    text_caracteristics = option.name;

                ib_search_filter_frag.push('<li class="ib-item-wrap-fm ib-btn-chk-fm"><input class="ib-m-features-checkboxes" type="checkbox" value="' + option.code + '" id="s_amenity_' + option.code + '"><label for="s_amenity_' + option.code + '">' + text_caracteristics + '</label></li>');
            }

            if (ib_search_filter_frag.length) {
                ib_m_features_exta.html(ib_search_filter_frag.join(""));
                ib_search_filter_frag.length = 0;
            }
        }	
}

function fillValuesMobileForm(response) {
	var params = response.params;

	$(".ib-item-collapse-saletype").hide();

	if ("1" == params.sale_type) { // for rent
		$("#ib_m_rental_type_r").click();

		$(".ib-item-collapse-sale").hide();
		$(".ib-item-collapse-rent").show();
	} else { // for sale
		$("#ib_m_rental_type_s").click();

		$(".ib-item-collapse-rent").hide();
		$(".ib-item-collapse-sale").show();
	}

	// min price for sale
	if (null != params.min_sale_price) {
		ib_min_price.val(params.min_sale_price);
	}

	// max price for sale
	if (null != params.max_sale_price) {
		ib_max_price.val(params.max_sale_price);
	}

	// min price for rent
	if (null != params.min_rent_price) {
		ib_min_rent_price.val(params.min_rent_price);
	}

	// max price for rent
	if (null != params.max_rent_price) {
		ib_max_rent_price.val(params.max_rent_price);
	}

	// min beds
	if (null != params.min_beds) {
		ib_min_beds.val(params.min_beds);
	}

	// max beds
	if (null != params.max_baths) {
		ib_max_beds.val(params.max_baths);
	}

	// min baths
	if (null != params.min_baths) {
		ib_min_baths.val(params.min_baths);
	}

	// max baths
	if (null != params.max_baths) {
		ib_max_baths.val(params.max_baths);
	}

	// types
	params.property_type = _.map(params.property_type, function(value) {
		return value + "";
	});

	ib_m_types.find(":input").each(function(index, item) {
		if (-1 !== $.inArray(item.value, params.property_type)) {
			$(item).click();
		}
	});

	// parking
	if (null != params.parking_options) {
		ib_m_parking.find(":input").each(function(index, item) {
			if (item.value == params.parking_options) {
				$(item).click();
			}
		});
	} else {
		$(ib_m_parking.find(":input")[0]).click();
	}

	// min living
	if (null != params.min_living_size) {
		ib_min_living.val(params.min_living_size);
	}

	// max living
	if (null != params.max_living_size) {
		ib_max_living.val(params.max_living_size);
	}

	// min land
	if (null != params.min_lot_size) {
		ib_min_land.val(params.min_lot_size);
	}

	// max land
	if (null != params.max_lot_size) {
		ib_max_land.val(params.max_lot_size);
	}

	// min year
	if (null != params.min_year) {
		ib_min_year.val(params.min_year);
	}

	// max year
	if (null != params.max_year) {
		ib_max_year.val(params.max_year);
	}

	// waterfront
	if (null != params.waterfront_options) {
		ib_waterfront_switch.val(params.waterfront_options);
	}

	// features
	if (params.hasOwnProperty("amenities")) {
		ib_m_features.find(":input").each(function(index, item) {
			if (-1 !== $.inArray(item.value, params.amenities)) {
				$(item).click();
			}
		});
	}

	if (params.hasOwnProperty("othersamenities")) {
		ib_m_features_exta.find(":input").each(function(index, item) {
			if (-1 !== $.inArray(item.value, params.othersamenities)) {
				$(item).click();
			}
		});
	}

}

function attachListenersMobileForm() {
	$("#ib_m_rental_type_s").on("click", function() {
		$(".ib-item-collapse-saletype").hide();
		$(".ib-item-collapse-sale").show();

		IB_SEARCH_FILTER_FORM.find('[name="sale_type"]').val("0");
		IB_SEARCH_FILTER_FORM.find('[name="page"]').val(1);
		IB_SEARCH_FILTER_FORM.trigger("submit");
	});

	$("#ib_m_rental_type_r").on("click", function() {
		$(".ib-item-collapse-saletype").hide();
		$(".ib-item-collapse-rent").show();

		IB_SEARCH_FILTER_FORM.find('[name="sale_type"]').val("1");
		IB_SEARCH_FILTER_FORM.find('[name="page"]').val(1);
		IB_SEARCH_FILTER_FORM.trigger("submit");
	});

	ib_min_price.on("change", function() {
		var value = $(this).val();

		if ("--" == value) { value = ""; }

		IB_SEARCH_FILTER_FORM.find('[name="min_sale_price"]').val(value);
		IB_SEARCH_FILTER_FORM.find('[name="page"]').val(1);
		IB_SEARCH_FILTER_FORM.trigger("submit");
	});

	ib_max_price.on("change", function() {
		var value = $(this).val();

		if ("--" == value) { value = ""; }

		IB_SEARCH_FILTER_FORM.find('[name="max_sale_price"]').val(value);
		IB_SEARCH_FILTER_FORM.find('[name="page"]').val(1);
		IB_SEARCH_FILTER_FORM.trigger("submit");
	});

	ib_min_rent_price.on("change", function() {
		var value = $(this).val();

		if ("--" == value) { value = ""; }

		IB_SEARCH_FILTER_FORM.find('[name="min_rent_price"]').val(value);
		IB_SEARCH_FILTER_FORM.find('[name="page"]').val(1);
		IB_SEARCH_FILTER_FORM.trigger("submit");
	});

	ib_max_rent_price.on("change", function() {
		var value = $(this).val();

		if ("--" == value) { value = ""; }

		IB_SEARCH_FILTER_FORM.find('[name="max_rent_price"]').val(value);
		IB_SEARCH_FILTER_FORM.find('[name="page"]').val(1);
		IB_SEARCH_FILTER_FORM.trigger("submit");
	});

	ib_min_beds.on("change", function() {
		var value = $(this).val();

		if ("--" == value) { value = ""; }

		IB_SEARCH_FILTER_FORM.find('[name="min_beds"]').val(value);
		IB_SEARCH_FILTER_FORM.find('[name="page"]').val(1);
		IB_SEARCH_FILTER_FORM.trigger("submit");
	});

	ib_max_beds.on("change", function() {
		var value = $(this).val();

		if ("--" == value) { value = ""; }

		IB_SEARCH_FILTER_FORM.find('[name="max_beds"]').val(value);
		IB_SEARCH_FILTER_FORM.find('[name="page"]').val(1);
		IB_SEARCH_FILTER_FORM.trigger("submit");
	});

	ib_min_baths.on("change", function() {
		var value = $(this).val();

		if ("--" == value) { value = ""; }

		IB_SEARCH_FILTER_FORM.find('[name="min_baths"]').val(value);
		IB_SEARCH_FILTER_FORM.find('[name="page"]').val(1);
		IB_SEARCH_FILTER_FORM.trigger("submit");
	});

	ib_max_baths.on("change", function() {
		var value = $(this).val();

		if ("--" == value) { value = ""; }

		IB_SEARCH_FILTER_FORM.find('[name="max_baths"]').val(value);
		IB_SEARCH_FILTER_FORM.find('[name="page"]').val(1);
		IB_SEARCH_FILTER_FORM.trigger("submit");
	});

	ib_m_types.on("change", "input", function() {
		var checked_values = ib_m_types.find(":checked");
		var fill_values = [];

		checked_values.each(function () {
			fill_values.push($(this).val());
		});

		IB_SEARCH_FILTER_FORM.find('[name="property_type"]').val(fill_values.join(","));
		IB_SEARCH_FILTER_FORM.find('[name="page"]').val(1);
		IB_SEARCH_FILTER_FORM.trigger("submit");
		fill_values.length = 0;
	});

	ib_m_parking.on("click", "input", function() {
		var value = $(this).val();

		if ("--" == value) { value = ""; }

		IB_SEARCH_FILTER_FORM.find('[name="parking_options"]').val(value);
		IB_SEARCH_FILTER_FORM.find('[name="page"]').val(1);
		IB_SEARCH_FILTER_FORM.trigger("submit");
	});

	ib_min_living.on("change", function() {
		var value = $(this).val();

		if ("--" == value) { value = ""; }

		IB_SEARCH_FILTER_FORM.find('[name="min_living_size"]').val(value);
		IB_SEARCH_FILTER_FORM.find('[name="page"]').val(1);
		IB_SEARCH_FILTER_FORM.trigger("submit");
	});

	ib_max_living.on("change", function() {
		var value = $(this).val();

		if ("--" == value) { value = ""; }

		IB_SEARCH_FILTER_FORM.find('[name="max_living_size"]').val(value);
		IB_SEARCH_FILTER_FORM.find('[name="page"]').val(1);
		IB_SEARCH_FILTER_FORM.trigger("submit");
	});

	ib_min_land.on("change", function() {
		var value = $(this).val();

		if ("--" == value) { value = ""; }

		IB_SEARCH_FILTER_FORM.find('[name="min_lot_size"]').val(value);
		IB_SEARCH_FILTER_FORM.find('[name="page"]').val(1);
		IB_SEARCH_FILTER_FORM.trigger("submit");
	});

	ib_max_land.on("change", function() {
		var value = $(this).val();

		if ("--" == value) { value = ""; }

		IB_SEARCH_FILTER_FORM.find('[name="max_lot_size"]').val(value);
		IB_SEARCH_FILTER_FORM.find('[name="page"]').val(1);
		IB_SEARCH_FILTER_FORM.trigger("submit");
	});

	ib_min_year.on("change", function() {
		var value = $(this).val();

		if ("--" == value) { value = ""; }

		IB_SEARCH_FILTER_FORM.find('[name="min_year"]').val(value);
		IB_SEARCH_FILTER_FORM.find('[name="page"]').val(1);
		IB_SEARCH_FILTER_FORM.trigger("submit");
	});

	ib_max_year.on("change", function() {
		var value = $(this).val();

		if ("--" == value) { value = ""; }

		IB_SEARCH_FILTER_FORM.find('[name="max_year"]').val(value);
		IB_SEARCH_FILTER_FORM.find('[name="page"]').val(1);
		IB_SEARCH_FILTER_FORM.trigger("submit");
	});

	ib_waterfront_switch.on("change", function() {
		var value = $(this).val();

		if ("--" == value) { value = ""; }

		IB_SEARCH_FILTER_FORM.find('[name="waterfront_options"]').val(value);
		IB_SEARCH_FILTER_FORM.find('[name="page"]').val(1);
		IB_SEARCH_FILTER_FORM.trigger("submit");
	});

	ib_m_features.on("change", "input", function() {
		var checked_values = ib_m_features.find(":checked");
		var fill_values = [];

		checked_values.each(function () {
			fill_values.push($(this).val());
		});

		IB_SEARCH_FILTER_FORM.find('[name="amenities"]').val(fill_values.join(","));
		IB_SEARCH_FILTER_FORM.find('[name="page"]').val(1);
		IB_SEARCH_FILTER_FORM.trigger("submit");
		fill_values.length = 0;
	});

    ib_m_features_exta.on("change", "input", function () {
            var checked_values = ib_m_features_exta.find(":checked");
            var fill_values = [];

            checked_values.each(function () {
                fill_values.push($(this).val());
            });

            IB_SEARCH_FILTER_FORM.find('[name="othersamenities"]').val(fill_values.join(","));
            IB_SEARCH_FILTER_FORM.find('[name="page"]').val(1);
            IB_SEARCH_FILTER_FORM.trigger("submit");
            fill_values.length = 0;
    });

}

function buildSearchFilterForm() {
	$('body').addClass('view-grid');

	infoWindow = new InfoBubble({
		map: IB_MAP,
		disableAutoPan: true,
		shadowStyle: 0,
		padding: 0,
		borderRadius: 0,
		borderWidth: 0,
		arrowSize: 0,
		disableAnimation: true,
		maxWidth: 410,
		maxHeight: 0,
		pane: "floatPane"
	});

	infoWindow.addListener("domready", function() {
		setTimeout(function () {
			// console.dir($(".ib-infobox").parent());
			$(".ib-infobox").parent().parent().css("background-color", "transparent");
			$(".ib-ibpitem").on("click", function () {
				var mlsNumber = $(this).data("mls");

				originalPositionY = Math.max(window.pageYOffset, document.documentElement.scrollTop, document.body.scrollTop);
				// console.log('opening...');

				loadPropertyInModal(mlsNumber);
			});
		}, 30);
	});

	if (IB_LISTINGS_CT.length) {

		if (/webOS|iPhone|iPad/i.test(navigator.userAgent) === false) {
			IB_LISTINGS_CT.on("mouseover", ".ib-pitem", function(event) {
			//IB_LISTINGS_CT.on("hover", ".ib-pitem", function(event) {    
				if (window.innerWidth <= 990) {
					return;
				}

				var geocode = $(this).data("geocode"),
					i,
					marker;

				for (i = 0; i < IB_MARKERS.length; i++) {
					if (IB_MARKERS[i].geocode === geocode) {
						marker = IB_MARKERS[i];
						break;
					}
				}

				if (typeof marker !== 'undefined') {
					google.maps.event.trigger(marker, "click");
					google.maps.event.trigger(marker, "mouseover");
				}

				var itemScroll = $(this).attr('data-mls');
				setTimeout(function(){
				  $('.ib-infobox .ib-ibpitem[data-mls="'+itemScroll+'"]').addClass('ms-order-m');
				}, 100);
			});

			IB_LISTINGS_CT.on("mouseleave", ".ib-pitem", function(event) {
				if (window.innerWidth <= 990) {
					return;
				}

				if (typeof infoWindow !== 'undefined') {
					if (infoWindow.isOpen()) {
						infoWindow.close();
					}
				}

				if (typeof IB_LAST_OPENED_MARKER !== "undefined") {
					google.maps.event.trigger(IB_LAST_OPENED_MARKER, "mouseout");
				}

				$('.ib-infobox .ib-ibpitem').addClass('ms-order-m');
			});
		}

		IB_LISTINGS_CT.on("click", ".btn_next_item, .btn_prev_item", function(event) {
			if ($(this).attr('method')=='prev'){
				if (0==get_off_market_position){ $('.gs-container-navs-off-market').hide(); return false; }                
				get_off_market_position=parseInt(get_off_market_position)-1;
			}else{
				if (tot_oml_item==get_off_market_position){ $('.gs-container-navs-off-market').hide(); return false; }
				get_off_market_position=parseInt(get_off_market_position)+1;
			}
			
			$.ajax({
				type: "POST",
				url: __flex_idx_search_filter.requestDataOffmarket,
				data: {
					access_token: IB_ACCESS_TOKEN,
					flex_credentials: Cookies.get("ib_lead_token"),
					search_filter_id: IB_SEARCH_FILTER.data("filter-id"),
					get_off_market_position: get_off_market_position
				},
				beforeSend: function(){
					$('#collection-markert').removeClass('gs-loaded').addClass('gs-item-loading');
					$('#collection-markert .ib-item').fadeOut('fast');
				},
				success: function(response) {
					__flex_idx_search_filter.list_offmarket = response;
					if (__flex_idx_search_filter.list_offmarket.status != false && __flex_idx_search_filter.list_offmarket.data != undefined ){
						
						__flex_idx_search_filter.list_offmarket.data.forEach(function(item){
							$('#collection-markert').find('.ib-pifimg').attr('src',item.image);
							$('#collection-markert').find('.ib-pifimg').attr('alt',item.address);
							jQuery('#collection-markert').find('.ib-title').text(item.address);
							$('#collection-markert').find('.idx_view_detail_market').attr('href','https://management.urbanresource.com/page-property/'+item.property_id+'/');
							
							$('#collection-markert .ib-item').fadeIn('fast');
							$('#collection-markert').removeClass('gs-item-loading');
						});                        
					}
				}/*,
				complete: function(){
					$('#collection-markert').removeClass('gs-item-loading').addClass('gs-loaded');
				}*/
			});            

		});
 
		IB_LISTINGS_CT.on("click", ".ib-pitem", function(event) {
			if ($(event.target).hasClass("ib-pfavorite")) {
				if ("yes" === __flex_g_settings.anonymous) {
					originalPositionY = Math.max(window.pageYOffset, document.documentElement.scrollTop, document.body.scrollTop);
					// console.log('opening...');

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

					// if ($(".register").length) {
					//     $(".register").click();
					//     $("button.close-modal").addClass("ib-close-mproperty");
					//     $(".overlay_modal").css("background-color", "rgba(0,0,0,0.8);");
					// }

					$("#user-options .register").trigger("click");

					/*TEXTO LOGIN*/
					var titleText = $(".header-tab a[data-tab='tabRegister']").attr('data-text')
					$("#modal_login .modal_cm .content_md .heder_md .ms-title-modal").html(titleText);
					
					return;
				}

				var mlsNumber = $(event.target).data("mls");
				var tokenAlert = $(this).data("token-alert");

				$(event.target).toggleClass("ib-pf-active");

				// save favorite from listings
				markPropertyAsFavorite(mlsNumber, event.target, "listing");
			} else if ( $(event.target).hasClass("ib-pipermalink") ) {
				event.preventDefault();

				originalPositionY = Math.max(window.pageYOffset, document.documentElement.scrollTop, document.body.scrollTop);
				// console.log('opening...');

				var mlsNumber = $(event.target).parent().data("mls");
				loadPropertyInModal(mlsNumber);
			}

			// console.dir(event);
		});
	}


	if (IB_PAGINATION_CTRL.length) {
		IB_PAGINATION_CTRL.on("click", "a", function(event) {
			event.preventDefault();

			if (!$(this).hasClass("ib-plitem-active")) {
				var goToNewPage = $(this).data("page");

				IB_SEARCH_FILTER_FORM.find('[name="page"]').val(goToNewPage);

				// submit form
				IB_SEARCH_FILTER_FORM.trigger("submit");

				//if ($(window).width() < 1023) {
					//$('html, body').animate({scrollTop: $('.ib-wgrid').offset().top - 20}, 1000)
					$('html, body').animate({scrollTop:0}, 1000);
				//}
			}
		});
	}

	if (IB_SORT_CTRL.length) {
		IB_SORT_CTRL.on("change", function() {
			IB_SEARCH_FILTER_FORM.find('[name="sort_type"]').val(this.value);
			IB_SEARCH_FILTER_FORM.find('[name="page"]').val(1);

			// submit form
			IB_SEARCH_FILTER_FORM.trigger("submit");
		});
	}

	/*
	if (IB_LB_CITIES.length) {
		IB_LB_CITIES.each(function () {
			for (var i = 0, l = __flex_idx_search_filter.search.cities.length; i < l; i++) {
				var li = document.createElement('li');
				li.classList.add('ib-lcitem');
				li.innerHTML = __flex_idx_search_filter.search.cities[i].name;
				IB_DOCFRAG.appendChild(li);
			}
			
			IB_LB_CITIES.html(IB_DOCFRAG);
		});
		
		IB_LB_CITIES.on("click", "li", function() {
			IB_SEARCH_FILTER_AUTOCOMPLETE.val(this.innerHTML + ' (City)');
			IB_SEARCH_FILTER_FORM.find('[name="filter_search_keyword_label"]').val(this.innerHTML + ' (City)');
			IB_SEARCH_FILTER_FORM.find('[name="filter_search_keyword_type"]').val('city');
			IB_SEARCH_FILTER_FORM.find('[name="page"]').val(1);

			update_bounds_zoom_gmap();

			// submit form
			IB_SEARCH_FILTER_FORM.trigger("submit");
		});
	}
	*/

	if (IB_LB_WATERFRONT_OPTIONS.length) {
		for (var i = 0, l = __flex_idx_search_filter.search.waterfront_options.length; i < l; i++) {
			var option = document.createElement('option');
			var text_label_trans='';
			if(__flex_idx_search_filter.search.waterfront_options[i].name=='Bay Front')
				text_label_trans=word_translate.bay_front;
			else if (__flex_idx_search_filter.search.waterfront_options[i].name=='Canal')
				text_label_trans=word_translate.canal;
			else if (__flex_idx_search_filter.search.waterfront_options[i].name=='Fixed Bridge')
				text_label_trans=word_translate.fixed_bridge;
			else if (__flex_idx_search_filter.search.waterfront_options[i].name=='Intracoastal')
				text_label_trans=word_translate.intracoastal;
			else if (__flex_idx_search_filter.search.waterfront_options[i].name=='Lake Front')
				text_label_trans=word_translate.lake_front;
			else if (__flex_idx_search_filter.search.waterfront_options[i].name=='Ocean Access')
				text_label_trans=word_translate.ocean_access;
			else if (__flex_idx_search_filter.search.waterfront_options[i].name=="Ocean Front")
				text_label_trans=word_translate.ocean_front;
			else if (__flex_idx_search_filter.search.waterfront_options[i].name=="Point Lot")
				text_label_trans=word_translate.point_lot;
			else if (__flex_idx_search_filter.search.waterfront_options[i].name=="River Front")
				text_label_trans=word_translate.river_front;
			else if (__flex_idx_search_filter.search.waterfront_options[i].name=="Park Greenbelt")
				text_label_trans=word_translate.park_greenbelt;
			else if (__flex_idx_search_filter.search.waterfront_options[i].name=="Mountains")
				text_label_trans=word_translate.mountains;
			else if (__flex_idx_search_filter.search.waterfront_options[i].name=="Strip View")
				text_label_trans=word_translate.strip_view;
			else if (__flex_idx_search_filter.search.waterfront_options[i].name=="River")
				text_label_trans=word_translate.river;
			else if (__flex_idx_search_filter.search.waterfront_options[i].name=="Lagoon")
				text_label_trans=word_translate.lagoon;
			else if (__flex_idx_search_filter.search.waterfront_options[i].name=="City")
				text_label_trans=word_translate.city;
			else if (__flex_idx_search_filter.search.waterfront_options[i].name=="Ocean")
				text_label_trans=word_translate.ocean;
			else if (__flex_idx_search_filter.search.waterfront_options[i].name=="Garden")
				text_label_trans=word_translate.garden;
			else if (__flex_idx_search_filter.search.waterfront_options[i].name=="Tennis Court")
				text_label_trans=word_translate.tennis_court;
			else if (__flex_idx_search_filter.search.waterfront_options[i].name=="Water")
				text_label_trans=word_translate.water;
			else if (__flex_idx_search_filter.search.waterfront_options[i].name=="Pool")
				text_label_trans=word_translate.pool;
			else if (__flex_idx_search_filter.search.waterfront_options[i].name=="Golf Course")
				text_label_trans=word_translate.golf_course;          

			else if (__flex_idx_search_filter.search.waterfront_options[i].name=="Lake")
				text_label_trans=word_translate.lake;
			else if (__flex_idx_search_filter.search.waterfront_options[i].name=="Bay")
				text_label_trans=word_translate.bay;
			else if (__flex_idx_search_filter.search.waterfront_options[i].name=="Gulf")
				text_label_trans=word_translate.gulf;
			else if (__flex_idx_search_filter.search.waterfront_options[i].name=="Creek")
				text_label_trans=word_translate.creek;
			else if (__flex_idx_search_filter.search.waterfront_options[i].name=="Pond")
				text_label_trans=word_translate.pond;
			else if (__flex_idx_search_filter.search.waterfront_options[i].name=="Marsh")
				text_label_trans=word_translate.marsh;
			else if (__flex_idx_search_filter.search.waterfront_options[i].name=="Mangrove")
				text_label_trans=word_translate.mangrove;          
			else if (__flex_idx_search_filter.search.waterfront_options[i].name=="Navigable")
				text_label_trans=word_translate.navigable;
			else if (__flex_idx_search_filter.search.waterfront_options[i].name=="River Frontage")
				text_label_trans=word_translate.river_frontage;
			else if (__flex_idx_search_filter.search.waterfront_options[i].name=="Basin")
				text_label_trans=word_translate.basin;
			else if (__flex_idx_search_filter.search.waterfront_options[i].name=="Seawall")
				text_label_trans=word_translate.seawall;
			else if (__flex_idx_search_filter.search.waterfront_options[i].name=="Water Access")
				text_label_trans=word_translate.water_access;
			else
				text_label_trans=__flex_idx_search_filter.search.waterfront_options[i].name;

			option.innerHTML = text_label_trans;
			option.setAttribute('value', __flex_idx_search_filter.search.waterfront_options[i].code);
			IB_DOCFRAG.appendChild(option);
		}

		IB_LB_WATERFRONT_OPTIONS.append(IB_DOCFRAG);

		IB_LB_WATERFRONT_OPTIONS.on("change", _.debounce(function() {
			var currentValue = ("--" == this.value) ? "" : this.value;
			IB_LB_WATERFRONT_OPTIONS.val(currentValue);

			IB_SEARCH_FILTER_FORM.find('[name="waterfront_options"]').val(currentValue);
			IB_SEARCH_FILTER_FORM.find('[name="page"]').val(1);

			// submit form
			IB_SEARCH_FILTER_FORM.trigger("submit");
		}, 700));
	}

	if (IB_LB_PARKING_OPTIONS.length) {
		for (var i = 0, l = __flex_idx_search_filter.search.parking_options.length; i < l; i++) {
			var option = document.createElement('option');
			option.innerHTML = __flex_idx_search_filter.search.parking_options[i].label;
			option.setAttribute('value', __flex_idx_search_filter.search.parking_options[i].value);
			IB_DOCFRAG.appendChild(option);
		}

		IB_LB_PARKING_OPTIONS.append(IB_DOCFRAG);

		IB_LB_PARKING_OPTIONS.on("change", _.debounce(function() {
			var currentValue = ("--" == this.value) ? "" : this.value;
			IB_LB_PARKING_OPTIONS.val(currentValue);

			IB_SEARCH_FILTER_FORM.find('[name="parking_options"]').val(currentValue);
			IB_SEARCH_FILTER_FORM.find('[name="page"]').val(1);

			// submit form
			IB_SEARCH_FILTER_FORM.trigger("submit");
		}, 700));
	}

	if (IB_LB_AMENITIES_OPTIONS.length) {
		IB_LB_AMENITIES_OPTIONS.each(function (index, node) {
			for (var i = 0, l = __flex_idx_search_filter.search.amenities.length; i < l; i++) {
				if (-1 !== $.inArray(__flex_idx_search_filter.search.amenities[i].code, ["loft","equestrian"])) {
					continue;
				}

				var li = document.createElement("li");
				li.classList.add("ib-citem");
				var input = document.createElement("input");
				input.setAttribute("type", "checkbox");
				input.setAttribute("id", "ib-amt-"+node.getAttribute('data-type')+"_" + i);
				input.setAttribute("value", __flex_idx_search_filter.search.amenities[i].code);
				input.classList.add("ib-icheck");
				var label = document.createElement("label");
				label.classList.add("ib-clabel");
				label.setAttribute("for", "ib-amt-"+node.getAttribute('data-type')+"_" + i);

			var text_label_trans='';
			//console.log(__flex_idx_search_filter.search.amenities[i].name);
			if(__flex_idx_search_filter.search.amenities[i].name=='Swimming Pool')
				text_label_trans=word_translate.swimming_pool;
			else if (__flex_idx_search_filter.search.amenities[i].name=='Golf Course')
				text_label_trans=word_translate.golf_course;
			else if (__flex_idx_search_filter.search.amenities[i].name=='Tennis Courts')
				text_label_trans=word_translate.tennis_courts;
			else if (__flex_idx_search_filter.search.amenities[i].name=='Gated Community')
				text_label_trans=word_translate.gated_community;
			else if (__flex_idx_search_filter.search.amenities[i].name=='Lofts')
				text_label_trans=word_translate.lofts;
			else if (__flex_idx_search_filter.search.amenities[i].name=='Penthouse')
				text_label_trans=word_translate.penthouse;
			else if (__flex_idx_search_filter.search.amenities[i].name=="Waterfront")
				text_label_trans=word_translate.water_front;
			else if (__flex_idx_search_filter.search.amenities[i].name=="Pets")
				text_label_trans=word_translate.pets;
			else if (__flex_idx_search_filter.search.amenities[i].name=="Furnished")
				text_label_trans=word_translate.furnished;
			else if (__flex_idx_search_filter.search.amenities[i].name=="Equestrian")
				text_label_trans=word_translate.equestrian;
			else if (__flex_idx_search_filter.search.amenities[i].name=="Short Sale")
				text_label_trans=word_translate.short_sales;
			else if (__flex_idx_search_filter.search.amenities[i].name=="Foreclosure")
				text_label_trans=word_translate.foreclosures;
			else if (__flex_idx_search_filter.search.amenities[i].name=="Boat Dock")
				text_label_trans=word_translate.boat_dock;
			else if (__flex_idx_search_filter.search.amenities[i].name=="Housing Older Persons")
				text_label_trans=word_translate.housing_older_persons;
			else if (__flex_idx_search_filter.search.amenities[i].name=="Occupied")
				text_label_trans=word_translate.occupied;
			else if (__flex_idx_search_filter.search.amenities[i].name=="Vacant")
				text_label_trans=word_translate.vacant;
			
			

			else
				text_label_trans=__flex_idx_search_filter.search.amenities[i].name;
			
				label.innerHTML = text_label_trans;
				li.appendChild(input);
				li.appendChild(label);

				IB_DOCFRAG.appendChild(li);
			}

			IB_LB_AMENITIES_OPTIONS.eq(index).append(IB_DOCFRAG);
		});

		IB_LB_AMENITIES_OPTIONS.on("change", "input", function() {
			var clickedOption = this.value;
			var checkedOption = this.checked;

			// IB_LB_AMENITIES_OPTIONS.find('input[value="'+clickedOption+'"]').attr('checked', checkedOption);
			
			//var chk_amt = IB_LB_AMENITIES_OPTIONS.find(':checked');
			var chk_amt = jQuery(this).parent().parent().find(':checked');
			var chk_list = [];

			IB_LB_AMENITIES_OPTIONS.find('input[value="'+clickedOption+'"]').prop('checked', checkedOption);

			chk_amt.each(function (index, node) {
				if ( -1 === $.inArray(node.value, chk_list) ) {
					chk_list.push(node.value);
				}
			});

			IB_SEARCH_FILTER_FORM.find('[name="amenities"]').val(chk_list.join(","));
			IB_SEARCH_FILTER_FORM.find('[name="page"]').val(1);

			// submit form
			IB_SEARCH_FILTER_FORM.trigger("submit");
		});
	}


	if (IB_LB_AMENITIES_EXTRAS_OPTIONS.length) {
		IB_LB_AMENITIES_EXTRAS_OPTIONS.each(function (index, node) {
			for (var i = 0, l = __flex_idx_search_filter.search.otherpopularfeatures.length; i < l; i++) {
				if (-1 !== $.inArray(__flex_idx_search_filter.search.otherpopularfeatures[i].code, ["loft","equestrian"])) {
					continue;
				}

				var li = document.createElement("li");
				li.classList.add("ib-citem");
				var input = document.createElement("input");
				input.setAttribute("type", "checkbox");
				input.setAttribute("id", "ib-amt-"+node.getAttribute('data-type')+"_" + i);
				input.setAttribute("value", __flex_idx_search_filter.search.otherpopularfeatures[i].code);
				input.classList.add("ib-icheck");
				var label = document.createElement("label");
				label.classList.add("ib-clabel");
				label.setAttribute("for", "ib-amt-"+node.getAttribute('data-type')+"_" + i);

			var text_label_trans='';
			//console.log(__flex_idx_search_filter.search.otherpopularfeatures[i].name);
			if(__flex_idx_search_filter.search.otherpopularfeatures[i].name=='Swimming Pool')
				text_label_trans=word_translate.swimming_pool;
			else if (__flex_idx_search_filter.search.otherpopularfeatures[i].name=='Golf Course')
				text_label_trans=word_translate.golf_course;
			else
				text_label_trans=__flex_idx_search_filter.search.otherpopularfeatures[i].name;
			
				label.innerHTML = text_label_trans;
				li.appendChild(input);
				li.appendChild(label);

				IB_DOCFRAG.appendChild(li);
			}

			IB_LB_AMENITIES_EXTRAS_OPTIONS.eq(index).append(IB_DOCFRAG);
		});

		IB_LB_AMENITIES_EXTRAS_OPTIONS.on("change", "input", function() {
			var clickedOption = this.value;
			var checkedOption = this.checked;

			// IB_LB_AMENITIES_EXTRAS_OPTIONS.find('input[value="'+clickedOption+'"]').attr('checked', checkedOption);
			
			//var chk_amt = IB_LB_AMENITIES_EXTRAS_OPTIONS.find(':checked');
			var chk_amt = jQuery(this).parent().parent().find(':checked');
			var chk_list = [];

			IB_LB_AMENITIES_EXTRAS_OPTIONS.find('input[value="'+clickedOption+'"]').prop('checked', checkedOption);

			chk_amt.each(function (index, node) {
				if ( -1 === $.inArray(node.value, chk_list) ) {
					chk_list.push(node.value);
				}
			});

			IB_SEARCH_FILTER_FORM.find('[name="othersamenities"]').val(chk_list.join(","));
			IB_SEARCH_FILTER_FORM.find('[name="page"]').val(1);

			// submit form
			IB_SEARCH_FILTER_FORM.trigger("submit");
		});
	}

	if (IB_LB_TYPES_OPTIONS.length) {
		// console.log(IB_LB_TYPES_OPTIONS);
		// console.log(__flex_idx_search_filter.search.property_types);
		// console.log('build options for desktop property types')

		IB_LB_TYPES_OPTIONS.each(function (index, node) {
			for (var i = 0, l = __flex_g_settings.overwrite_settings.property_types.length; i < l; i++) {
				var li = document.createElement("li");
				li.classList.add("ib-citem");
				var input = document.createElement("input");
				input.setAttribute("type", "checkbox");
				input.setAttribute("id", "ib-ppt-"+node.getAttribute('data-type')+"_" + i);
				input.setAttribute("value", __flex_g_settings.overwrite_settings.property_types[i].value);
				input.classList.add("ib-icheck");
				var label = document.createElement("label");
				label.classList.add("ib-clabel");
				label.setAttribute("for", "ib-ppt-"+node.getAttribute('data-type')+"_" + i);
				var text_label_trans='';
					if(__flex_g_settings.overwrite_settings.property_types[i].label=='Homes'){
						text_label_trans=word_translate.homes;
					}else if(__flex_g_settings.overwrite_settings.property_types[i].label=='Condominiums'){
						text_label_trans=word_translate.condominiums;
					}else if(__flex_g_settings.overwrite_settings.property_types[i].label=='Townhouses'){
						text_label_trans=word_translate.townhouses;
					}else if (__flex_g_settings.overwrite_settings.property_types[i].label=='Single Family Homes'){
						text_label_trans=word_translate.single_family_homes;
					}else{
						text_label_trans=__flex_g_settings.overwrite_settings.property_types[i].label;
					}

				label.innerHTML = text_label_trans;
				li.appendChild(input);
				li.appendChild(label);

				IB_DOCFRAG.appendChild(li);
			}

			IB_LB_TYPES_OPTIONS.eq(index).append(IB_DOCFRAG);
		});

		IB_LB_TYPES_OPTIONS.on("change", "input", function() {
			var clickedOption = this.value;
			var checkedOption = this.checked;

			//IB_LB_TYPES_OPTIONS.find('input[value="'+clickedOption+'"]').attr('checked', checkedOption);

			// var chk_amt = IB_LB_TYPES_OPTIONS.find(':checked');
			var chk_amt = jQuery(this).parent().parent().find(':checked');
			var chk_list = [];

			IB_LB_TYPES_OPTIONS.find('input[value="'+clickedOption+'"]').prop('checked', checkedOption);

			chk_amt.each(function (index, node) {
				if ( -1 === $.inArray(node.value, chk_list) ) {
					chk_list.push(node.value);
				}
			});

			var lbl_ptypes = [];

			if ( (-1 !== $.inArray("2", chk_list)) || (-1 !== $.inArray(2, chk_list)) ) {
				lbl_ptypes.push("Homes");
			}

			if ( (-1 !== $.inArray("1", chk_list)) || (-1 !== $.inArray(1, chk_list)) ) {
				lbl_ptypes.push("Condominiums");
			}

			if (-1 !== $.inArray("tw", chk_list)) {
				lbl_ptypes.push("Townhouses");
			}

			if (-1 !== $.inArray("mf", chk_list)) {
				lbl_ptypes.push("Multi-Family");
			}

			if (-1 !== $.inArray("valand", chk_list)) {
				lbl_ptypes.push("Vacant Land");
			}

			// if (lbl_ptypes.length && lbl_ptypes.length < __flex_g_settings.params.property_types.length) {
			if (lbl_ptypes.length && lbl_ptypes.length < __flex_g_settings.overwrite_settings.property_types.length) {
				IB_LBL_TYPES_NTF.html(lbl_ptypes.join(", "));
				// console.log(lbl_ptypes);
				lbl_ptypes.length = 0;
			} else {
				// IB_LBL_TYPES_NTF.html("Homes, Condominiums, Townhouses");
				IB_LBL_TYPES_NTF.html(word_translate.any_type);
				// console.log('all');
			}

			IB_SEARCH_FILTER_FORM.find('[name="property_type"]').val(chk_list.join(","));
			IB_SEARCH_FILTER_FORM.find('[name="page"]').val(1);

			// submit form
			IB_SEARCH_FILTER_FORM.trigger("submit");
		});
	}

	// setup initial sliders
	if (IB_RG_PRICE_SALE.length) {
		IB_RG_PRICE_SALE.slider({
			range: true,
			min: 0,
			max: IB_RG_PRICE_SALE_VALUES.length - 1,
			step: 1,
			values: [0, IB_RG_PRICE_SALE_VALUES.length - 1],
			slide: _.debounce(function(event, ui) {
				IB_RG_PRICE_SALE.slider("option", "values", ui.values);

				var min_val = IB_RG_PRICE_SALE_VALUES[ui.values[0]];
				var max_val = IB_RG_PRICE_SALE_VALUES[ui.values[1]];

				if ( (0 == min_val) || ("--" == min_val)) {
					min_val = '0';
				}
				
				if ( (0 == max_val) || ("--" == max_val)) {
					max_val = '';
				}

				IB_SEARCH_FILTER_FORM.find('[name="min_sale_price"]').val(min_val);
				IB_SEARCH_FILTER_FORM.find('[name="max_sale_price"]').val(max_val);
				IB_SEARCH_FILTER_FORM.find('[name="page"]').val(1);

				// submit form
				IB_SEARCH_FILTER_FORM.trigger("submit");
			}, 700)
		});

		IB_RG_PRICE_SALE.on("slide", function(event, ui) {
			// console.log("change [slide]");
			var values = ui.values;
			
			var min = IB_RG_PRICE_SALE_VALUES[values[0]];
			var max = IB_RG_PRICE_SALE_VALUES[values[1]];

			var min_lbl = IB_RG_PRICE_SALE_VALUES[values[0]];
			var max_lbl = IB_RG_PRICE_SALE_VALUES[values[1]];

			if ( (0 == min) || ("--" == min)) {
				min = '$0';
			} else {
				min = "$" + _.formatPrice(min);
			}
			
			if ( (0 == max) || ("--" == max)) {
				max = word_translate.any_price;
			} else {
				max = "$" + _.formatPrice(max);
			}

			// console.dir([min_lbl, max_lbl]);

			if (
				( ("--" == min_lbl) && ("--" == max_lbl) ) ||
				( (0 == min_lbl) && (0 == max_lbl) ) ||
				( (0 == min_lbl) && ("--" == max_lbl) )
			) {
				IB_LBL_PRICE_NTF.html(word_translate.any_price);
			} else {
				if ( ("--" == max_lbl) && ( (!isNaN(min_lbl)) && (min_lbl > 0) ) ) {
					IB_LBL_PRICE_NTF.html("$" + _.formatShortPrice(min_lbl) + " - "+word_translate.any_price);
				} else {
					IB_LBL_PRICE_NTF.html("$" + _.formatShortPrice(min_lbl) + " - $" + _.formatShortPrice(max_lbl));
				}
			}
		
			IB_RG_PRICE_SALE_LBL_LT.val(min);
			IB_RG_PRICE_SALE_LBL_RT.val(max);
		
			// console.log("%s - %s", min, max);
		});
	}

	if (IB_RG_PRICE_RENT.length) {
		IB_RG_PRICE_RENT.slider({
			range: true,
			min: 0,
			max: IB_RG_PRICE_RENT_VALUES.length - 1,
			step: 1,
			values: [0, IB_RG_PRICE_RENT_VALUES.length - 1],
			slide: _.debounce(function(event, ui) {
				IB_RG_PRICE_RENT.slider("option", "values", ui.values);

				var min_val = IB_RG_PRICE_RENT_VALUES[ui.values[0]];
				var max_val = IB_RG_PRICE_RENT_VALUES[ui.values[1]];

				if ( (0 == min_val) || ("--" == min_val)) {
					min_val = '0';
				}
				
				if ( (0 == max_val) || ("--" == max_val)) {
					max_val = '';
				}

				IB_SEARCH_FILTER_FORM.find('[name="min_rent_price"]').val(min_val);
				IB_SEARCH_FILTER_FORM.find('[name="max_rent_price"]').val(max_val);
				IB_SEARCH_FILTER_FORM.find('[name="page"]').val(1);

				// submit form
				IB_SEARCH_FILTER_FORM.trigger("submit");
			}, 700)
		});

		IB_RG_PRICE_RENT.on("slide", function(event, ui) {
			// console.log("change [slide]");
			var values = ui.values;
			
			var min = IB_RG_PRICE_RENT_VALUES[values[0]];
			var max = IB_RG_PRICE_RENT_VALUES[values[1]];

			var min_lbl = IB_RG_PRICE_RENT_VALUES[values[0]];
			var max_lbl = IB_RG_PRICE_RENT_VALUES[values[1]];

			if ( (0 == min) || ("--" == min)) {
				min = '$0';
			} else {
				min = "$" + _.formatPrice(min);
			}
			
			if ( (0 == max) || ("--" == max)) {
				max = word_translate.any_price;
			} else {
				max = "$" + _.formatPrice(max);
			}

			// console.dir([min_lbl, max_lbl]);

			if (
				( ("--" == min_lbl) && ("--" == max_lbl) ) ||
				( (0 == min_lbl) && (0 == max_lbl) ) ||
				( (0 == min_lbl) && ("--" == max_lbl) )
			) {
				IB_LBL_PRICE_NTF.html(word_translate.any_price);
			} else {
				if ( ("--" == max_lbl) && ( (!isNaN(min_lbl)) && (min_lbl > 0) ) ) {
					IB_LBL_PRICE_NTF.html("$" + _.formatShortPrice(min_lbl) + " - "+word_translate.any_price);
				} else {
					IB_LBL_PRICE_NTF.html("$" + _.formatShortPrice(min_lbl) + " - $" + _.formatShortPrice(max_lbl));
				}
			}

			IB_RG_PRICE_RENT_LBL_LT.val(min);
			IB_RG_PRICE_RENT_LBL_RT.val(max);
		
			// console.log("%s - %s", min, max);
		});
	}

	if (IB_RG_BEDROOMS.length) {
		IB_RG_BEDROOMS.slider({
			range: true,
			min: 0,
			max: IB_RG_BEDROOMS_VALUES.length - 1,
			step: 1,
			values: [0, IB_RG_BEDROOMS_VALUES.length - 1],
			slide: _.debounce(function(event, ui) {
				IB_RG_BEDROOMS.slider("option", "values", ui.values);

				var min_val = IB_RG_BEDROOMS_VALUES[ui.values[0]];
				var max_val = IB_RG_BEDROOMS_VALUES[ui.values[1]];

				if ( (0 == min_val) || (6 == min_val)) {
					min_val = '0';
				}
				
				if ( (0 == max_val) || (6 == max_val)) {
					max_val = '';
				}

				IB_SEARCH_FILTER_FORM.find('[name="min_beds"]').val(min_val);
				IB_SEARCH_FILTER_FORM.find('[name="max_beds"]').val(max_val);
				IB_SEARCH_FILTER_FORM.find('[name="page"]').val(1);

				// submit form
				IB_SEARCH_FILTER_FORM.trigger("submit");
			}, 700)
		});

		IB_RG_BEDROOMS.on("slide", function(event, ui) {
			// console.log("change [slide]");
			var values = ui.values;

			var min_lbl = IB_RG_BEDROOMS_VALUES[values[0]];
			var max_lbl = IB_RG_BEDROOMS_VALUES[values[1]];

			// console.dir([min_lbl, max_lbl]);

			if (
				( (0 == min_lbl) && (6 == max_lbl) ) ||
				( (6 == min_lbl) && (6 == max_lbl) ) ||
				( (0 == min_lbl) && (0 == max_lbl) )
			) {
				IB_LBL_BED_NTF.html(word_translate.any_beds);
			} else {
				if (max_lbl > 5) {
					IB_LBL_BED_NTF.html(min_lbl + " - "+word_translate.any_beds);
				} else {
					IB_LBL_BED_NTF.html(min_lbl + " - " + max_lbl + " "+word_translate.beds);
				}
			}
		});
	}

	if (IB_RG_BATHROOMS.length) {
		IB_RG_BATHROOMS.slider({
			range: true,
			min: 0,
			max: IB_RG_BATHROOMS_VALUES.length - 1,
			step: 1,
			values: [0, IB_RG_BATHROOMS_VALUES.length - 1],
			slide: _.debounce(function(event, ui) {
				IB_RG_BATHROOMS.slider("option", "values", ui.values);

				var min_val = IB_RG_BATHROOMS_VALUES[ui.values[0]];
				var max_val = IB_RG_BATHROOMS_VALUES[ui.values[1]];

				if ( (0 == min_val) || (6 == min_val)) {
					min_val = '0';
				}
				
				if ( (0 == max_val) || (6 == max_val)) {
					max_val = '';
				}

				IB_SEARCH_FILTER_FORM.find('[name="min_baths"]').val(min_val);
				IB_SEARCH_FILTER_FORM.find('[name="max_baths"]').val(max_val);
				IB_SEARCH_FILTER_FORM.find('[name="page"]').val(1);

				// submit form
				IB_SEARCH_FILTER_FORM.trigger("submit");
			}, 700)
		});

		IB_RG_BATHROOMS.on("slide", function(event, ui) {
			// console.log("change [slide]");
			var values = ui.values;

			var min_lbl = IB_RG_BATHROOMS_VALUES[values[0]];
			var max_lbl = IB_RG_BATHROOMS_VALUES[values[1]];

			// console.dir([min_lbl, max_lbl]);

			if (
				( (0 == min_lbl) && (6 == max_lbl) ) ||
				( (6 == min_lbl) && (6 == max_lbl) ) ||
				( (0 == min_lbl) && (0 == max_lbl) )
			) {
				IB_LBL_BATH_NTF.html(word_translate.any_baths);
			} else {
				if (max_lbl > 5) {
					IB_LBL_BATH_NTF.html(min_lbl + " - "+word_translate.any_baths);
				} else {
					IB_LBL_BATH_NTF.html(min_lbl + " - " + max_lbl + " "+word_translate.baths);
				}
			}
		});
	}

	if (IB_RG_LIVINGSIZE.length) {
		IB_RG_LIVINGSIZE.slider({
			range: true,
			min: 0,
			max: IB_RG_LIVINGSIZE_VALUES.length - 1,
			step: 1,
			values: [0, IB_RG_LIVINGSIZE_VALUES.length - 1],
			slide: _.debounce(function(event, ui) {
				IB_RG_LIVINGSIZE.slider("option", "values", ui.values);

				var min_val = IB_RG_LIVINGSIZE_VALUES[ui.values[0]];
				var max_val = IB_RG_LIVINGSIZE_VALUES[ui.values[1]];

				if ( (0 == min_val) || ("--" == min_val)) {
					min_val = '0';
				}
				
				if ( (0 == max_val) || ("--" == max_val)) {
					max_val = '';
				}

				// console.dir("debounced [slide]");
				// console.dir(ui);

				IB_SEARCH_FILTER_FORM.find('[name="min_living_size"]').val(min_val);
				IB_SEARCH_FILTER_FORM.find('[name="max_living_size"]').val(max_val);
				IB_SEARCH_FILTER_FORM.find('[name="page"]').val(1);

				// submit form
				IB_SEARCH_FILTER_FORM.trigger("submit");
			}, 700)
		});

		// live update label for living size [slider]
		IB_RG_LIVINGSIZE.on("slide", function(event, ui) {
			// console.log("change [slide]");
			var values = ui.values;
			
			var min = IB_RG_LIVINGSIZE_VALUES[values[0]];
			var max = IB_RG_LIVINGSIZE_VALUES[values[1]];
            var min_lot_size = IB_RG_LIVINGSIZE_VALUES[values[0]];
            var max_lot_size = IB_RG_LIVINGSIZE_VALUES[values[1]];

			if ( (0 == min) || ("--" == min)) {
				min = '0 '+word_translate.sqft;
			} else {
				min = _.formatPrice(min) + " "+word_translate.sqft;
			}
			
			if ( (0 == max) || ("--" == max)) {
				max = word_translate.any_size;
			} else {
				max = _.formatPrice(max) + " "+word_translate.sqft;
			}

			if (min_lot_size >= 20000) {
				min = (min_lot_size/43560).toFixed(2)+ " Acre";
			}

			if (max_lot_size >= 20000) {
				max = (max_lot_size/43560).toFixed(2)+ " Acre";
			}

			IB_RG_LIVING_LBL_LT.val(min);
			IB_RG_LIVING_LBL_RT.val(max);

			// console.log("%s - %s", min, max);
		});
	}

	if (IB_RG_LANDSIZE.length) {
		IB_RG_LANDSIZE.slider({
			range: true,
			min: 0,
			max: IB_RG_LANDSIZE_VALUES.length - 1,
			step: 1,
			values: [0, IB_RG_LANDSIZE_VALUES.length - 1],
			slide: _.debounce(function(event, ui) {
				IB_RG_LANDSIZE.slider("option", "values", ui.values);

				var min_val = IB_RG_LANDSIZE_VALUES[ui.values[0]];
				var max_val = IB_RG_LANDSIZE_VALUES[ui.values[1]];

				if ( (0 == min_val) || ("--" == min_val)) {
					min_val = '0';
				}
				
				if ( (0 == max_val) || ("--" == max_val)) {
					max_val = '';
				}

				IB_SEARCH_FILTER_FORM.find('[name="min_lot_size"]').val(min_val);
				IB_SEARCH_FILTER_FORM.find('[name="max_lot_size"]').val(max_val);
				IB_SEARCH_FILTER_FORM.find('[name="page"]').val(1);

				// submit form
				IB_SEARCH_FILTER_FORM.trigger("submit");
			}, 700)
		});

		// live update label for land size [slider]
		IB_RG_LANDSIZE.on("slide", function(event, ui) {
			// console.log("change [slide]");
			var values = ui.values;
			
			var min = IB_RG_LANDSIZE_VALUES[values[0]];
			var max = IB_RG_LANDSIZE_VALUES[values[1]];
			var min_lot_size = IB_RG_LANDSIZE_VALUES[values[0]];
            var max_lot_size = IB_RG_LANDSIZE_VALUES[values[1]];

			if ( (0 == min) || ("--" == min)) {
				min = '0 '+word_translate.sqft;
			} else {
				min = _.formatPrice(min) + " "+word_translate.sqft;
			}
			
			if ( (0 == max) || ("--" == max)) {
				max = word_translate.any_size;
			} else {
				max = _.formatPrice(max) + " "+word_translate.sqft;
			}

			if (min_lot_size >= 20000) {
				min = (min_lot_size/43560).toFixed(2)+ " Acre";
			}

			if (max_lot_size >= 20000) {
				max = (max_lot_size/43560).toFixed(2)+ " Acre";
			}

			IB_RG_LAND_LBL_LT.val(min);
			IB_RG_LAND_LBL_RT.val(max);

			// console.log("%s - %s", min, max);
		});
	}

	if (IB_RG_YEARBUILT.length) {
		IB_RG_YEARBUILT.slider({
			range: true,
			min: 0,
			max: IB_RG_YEARBUILT_VALUES.length - 1,
			step: 1,
			values: [0, IB_RG_YEARBUILT_VALUES.length - 1],
			slide: _.debounce(function(event, ui) {
				IB_RG_YEARBUILT.slider("option", "values", ui.values);

				var min_val = IB_RG_YEARBUILT_VALUES[ui.values[0]];
				var max_val = IB_RG_YEARBUILT_VALUES[ui.values[1]];

				if ( (1900 == min_val) || (current_year == min_val)) {
					min_val = '1900';
				}
				
				if ( (1900 == max_val) || (current_year == max_val)) {
					max_val = '';
				}

				IB_SEARCH_FILTER_FORM.find('[name="min_year"]').val(min_val);
				IB_SEARCH_FILTER_FORM.find('[name="max_year"]').val(max_val);
				IB_SEARCH_FILTER_FORM.find('[name="page"]').val(1);

				// submit form
				IB_SEARCH_FILTER_FORM.trigger("submit");
			}, 700)
		});

		// live update label for year built [slider]
		IB_RG_YEARBUILT.on("slide", function(event, ui) {
			// console.log("change [slide]");
			var values = ui.values;
			
			var min = IB_RG_YEARBUILT_VALUES[values[0]];
			var max = IB_RG_YEARBUILT_VALUES[values[1]];

			IB_RG_YEAR_LBL_LT.val(min);
			IB_RG_YEAR_LBL_RT.val(max);

			// console.log("%s - %s", min, max);
		});
	}
}

function saveFilterSearchForLead() {
	// IB_SEARCH_FILTER
	var search_url = location.href;
	if (/iPhone|iPad|iPod|Android/i.test(navigator.userAgent)) {
		var pattern = /(ftp|http|https):\/\/(\w+:{0,1}\w*@)?(\S+)(:[0-9]+)?(\/|\/([\w#!:.?+=&%@!\-\/]))?/;
		if (pattern.test(initial_href)) {
		    var search_url = initial_href;
		}else{
		    var search_url = __flex_idx_search_filter.searchFilterPermalink+initial_href;
		}
	}
	var search_count = IB_SEARCH_FILTER.attr("data-count");
	var search_condition = IB_SEARCH_FILTER.attr("data-condition");
	var search_name = IB_SEARCH_FILTER.attr("data-name");
	var search_filter_params = IB_SEARCH_FILTER.attr("data-params");

	var search_filter_ID = IB_SEARCH_FILTER.data("filter-id");

	if ("no" === __flex_g_settings.anonymous) {
		$.ajax({
			type: "POST",
			url: __flex_idx_search_filter.saveListings.replace(/{{filterId}}/g, search_filter_ID),
			data: {
				access_token: IB_ACCESS_TOKEN,
				search_rk: __flex_idx_search_filter.rk,
				search_wp_web_id: __flex_idx_search_filter.wp_web_id,                                
				flex_credentials: Cookies.get("ib_lead_token"),
				search_filter_id: IB_SEARCH_FILTER.data("filter-id"),
				search_url: search_url,
				search_count: search_count,
				search_condition: search_condition,
				search_name: search_name,
				search_params: JSON.stringify(dataAlert.params)
			},
			success: function(response) {
				// console.log("The search filter has been saved successfully.");
			}
		});
	}
}

// register function globally
window.saveFilterSearchForLead = saveFilterSearchForLead;

if ("undefined" === typeof idxboostTypeIcon) {
	function idxboostTypeIcon() {
		if (__flex_g_settings["params"]["view_icon_type"] == '1') {
		  $('.clidxboost-btn-check').addClass('clidxboost-icon-star');
		  $('.chk_save').addClass('clidxboost-icon-star');
		} else if (__flex_g_settings["params"]["view_icon_type"] == '2') {
		  $('.clidxboost-btn-check').addClass('clidxboost-icon-square');
		  $('.chk_save').addClass('clidxboost-icon-square');
		} else if (__flex_g_settings["params"]["view_icon_type"] == '0') {
		  $('.clidxboost-btn-check').addClass('clidxboost-icon-heart');
		  $('.chk_save').addClass('clidxboost-icon-heart');
		} else {
		  $('.clidxboost-btn-check').addClass('clidxboost-icon-heart');
		  $('.chk_save').addClass('clidxboost-icon-heart');
		}
	}
}

function handleFilterSearchLookup(event) {
	if (ib_xhr_running) {
		ib_xhr_handler.abort();
	}

	ib_xhr_running = true;

	if (typeof event !== "undefined") {
		event.preventDefault();
	}

	if (typeof infoWindow !== 'undefined') {
		if (infoWindow.isOpen()) {
			infoWindow.close();
		}
	}

	$(".ib-temp-modal-infobox").remove();

	//IB_SEARCH_FILTER_AUTOCOMPLETE.autocomplete("close");

	// $(".ib-fmsearchsuggestions:eq(0)").parent().removeClass("ib-fhpa-minisearch-active");

	$("#ib-apply-filters-btn").html(word_translate.searching+'...');
	IB_RG_MATCHING.html(word_translate.searching+'...');
	$(".ib-fmapply").html(word_translate.searching+"...");
	IB_HEADING_CT.html(word_translate.loading_properties);

	$('.ib-wgrid:eq(0)').animate({ scrollTop: 0 }, 1000);
	ib_xhr_handler = $.ajax({
		type: "POST",
		url: __flex_idx_search_filter.lookupSearchFilter,
		data: {
			access_token: IB_ACCESS_TOKEN,
			flex_credentials: Cookies.get("ib_lead_token"),
			search_filter_id: IB_SEARCH_FILTER.data("filter-id"),
			get_off_market_position: get_off_market_position,
			post_params: IB_SEARCH_FILTER_FORM.serialize(),
			version_endpoint : 'new',
			query_params: ("" != location.search) ? location.search.substr(1) : location.search,
			event_triggered: (typeof event !== 'undefined') ? 'yes' : 'no',
			device_width: window.innerWidth
		},
		success: function(response) {
			// console.log('overwrite property type params');
			// __flex_g_settings.params.property_types = ib_local_ovewrite_ptypes(response.params.property_type);
			// __flex_idx_search_filter.search.property_types = ib_local_ovewrite_ptypes(response.params.property_type);

			if ("no" === __flex_g_settings.anonymous) {
				if (false === is_search_filter_viewed) {
					is_search_filter_viewed = true;
					$.ajax({
						type: "POST",
						url: __flex_idx_search_filter.updateEventUri,
						data: {
							"type": "lead_search_filter_view",
							"name": response.params.name,
							"access_token": __flex_g_settings.accessToken,
							"lead_token": Cookies.get("ib_lead_token"),
							"source_url": location.href
						},
						success: function(response) {
							//console.dir(response);
						}
					});
				}
			}

			dataAlert=response;
			dataAlert.params.active_property_type

			//remove property type no active
			jQuery(".ib-types-options li, #ib-flex-m-types li").each(function(params) {
				
				if(jQuery(this).find("input").val() == "2" ){
					
					if( !response.params.active_property_type.includes("homes") ){
						jQuery(this).remove();
					}
				}

				if(jQuery(this).find("input").val() == "1" ){
					
					if( !response.params.active_property_type.includes("condos") ){
						jQuery(this).remove();
					}
				}
				
				if(jQuery(this).find("input").val() == "mf" ){
					
					if( !response.params.active_property_type.includes("multifamily") ){
						jQuery(this).remove();
					}
				}
				
				if(jQuery(this).find("input").val() == "valand" ){
					
					if( !response.params.active_property_type.includes("vacantland") ){
						jQuery(this).remove();
					}
				}
				
				if(jQuery(this).find("input").val() == "tw" ){
					
					if( !response.params.active_property_type.includes("townhouse") ){
						jQuery(this).remove();
					}
				}
				
				if(jQuery(this).find("input").val() == "co_op" ){
					
					if( !response.params.active_property_type.includes("co_op") ){
						jQuery(this).remove();
					}
				}    
			})
			//remove property type no active

			if (typeof IS_SEARCH_FILTER_CARROUSEL !== "undefined") {
				// console.dir(response);

				var html_response = [];

				for (var i = 0, l = response.items.length; i < l; i++) {

					if (
						typeof $(".js-slider-filter-search").attr("data-limit") !== 'undefined' && 
						$(".js-slider-filter-search").attr("data-limit") !== false && 
						$(".js-slider-filter-search").attr("data-limit").length
					) {
						var nlimit = parseInt($(".js-slider-filter-search").attr("data-limit"), 10);
						if (nlimit > 0) {
							if (i >= nlimit) {
								break;
							}
						}
					}
					
					var info_item = response.items[i];

					html_response.push('<ul class="result-search slider-generator">');
						html_response.push('<li class="propertie" data-address="'+info_item.full_address+'"  data-id="'+info_item.mls_num+'" data-mls="'+info_item.mls_num+'" data-counter="0">');

							if ( 
								info_item.hasOwnProperty('recently_listed') && 
								("yes" === info_item.recently_listed || info_item.min_ago_txt != "") 
							) {
								if (info_item.min_ago > 0 && info_item.min_ago_txt != "" ) {
									html_response.push('<div class="flex-property-new-listing">' + info_item.min_ago_txt + '</div>');
								} else {
									html_response.push('<div class="flex-property-new-listing">' + word_translate.new_listing + '</div>');
								}
							} else if (1 != info_item.status) {
								html_response.push('<div class="flex-property-new-listing">' + info_item.status_name +'</div>');
							}

							html_response.push('<h2 title="' + info_item.full_address + '" class="ms-property-address"><div class="ms-title-address -address-top">'+info_item.full_address+'</div></h2>');
							html_response.push('<ul class="features">');
								html_response.push('<li class="address">'+info_item.address_large+'</li>');
								html_response.push('<li class="price">$'+_.formatPrice(info_item.price)+'</li>');
								html_response.push('<li class="pr down">2.05%</li>');
								html_response.push('<li class="beds">'+info_item.bed+'  <span>'+word_translate.beds+' </span></li>');
								html_response.push('<li class="baths">'+info_item.bath+' <span>'+word_translate.baths+' </span></li>');
								// html_response.push('<li class="living-size"> <span>'+info_item.sqft+'</span>'+word_translate.sqft+' <span>('+ info_item.living_size_m2 +' m²)</span></li>');
								html_response.push('<li class="living-size"> <span>'+_.formatPrice(info_item.sqft)+'</span>'+word_translate.sqft+'</li>');
								// html_response.push('<li class="price-sf"><span>$'+info_item.price_sqft+' </span>/ '+word_translate.sqft+'<span>($'+ info_item.price_sqft_m2 +' m²)</span></li>');
								html_response.push('<li class="price-sf"><span>$'+info_item.price_sqft+' </span>/ '+word_translate.sqft+'</li>');

								if ( 
									response.hasOwnProperty("board_info") &&
									response.board_info.hasOwnProperty("board_logo_url") &&
									response.board_info.board_logo_url != "" && response.board_info.board_logo_url != null 
								) {
									html_response.push('<li class="ms-logo-board"><img src="'+response.board_info.board_logo_url+'"></li>');
								}

								//html_response.push('<li class="build-year"><span>Built </span>2015</li>');
								//html_response.push('<li class="development"><span></span></li>');
							html_response.push('</ul>');
							html_response.push('<div class="wrap-slider">');
								html_response.push('<ul>');
								if (0 == info_item.gallery.length) {
									html_response.push('<li class="flex-slider-current"><img class="flex-lazy-image" data-original="https://www.idxboost.com/i/default_thumbnail.jpg"></li>');
								} else {
									info_item.gallery.forEach(function(gallery,index_gallery){
										if (index_gallery==0){
											html_response.push('<li class="flex-slider-current"><img class="flex-lazy-image" data-original="'+gallery+'"></li>');
											}else{
											html_response.push('<li class="flex-slider-item-hidden"><img class="flex-lazy-image" data-original="'+gallery+'"></li>');
											}		
										});
								}
								html_response.push('</ul>');
		
								if (info_item.gallery.length>1){
									html_response.push('<button class="prev flex-slider-prev"><span class="clidxboost-icon-arrow-select"></span></button>');
									html_response.push('<button class="next flex-slider-next"><span class="clidxboost-icon-arrow-select"></span></button>');
								}
		
								if (info_item.status!='2') {
									if (info_item.is_favorite==1){
										html_response.push('<button class="clidxboost-btn-check"><span class="flex-favorite-btn clidxboost-icon-check clidxboost-icon-check-list active" data-alert-token="'+info_item.token_alert+'"></span></button>');
									}else{
										html_response.push('<button class="clidxboost-btn-check"><span class="flex-favorite-btn clidxboost-icon-check clidxboost-icon-check-list"></span></button>');
									}
								}
		
							html_response.push('</div>');
							html_response.push('<a class="ib-view-detailt" href="'+__flex_idx_search_filter.propertyDetailPermalink+ '/' + info_item.slug + '" rel="nofollow">'+word_translate.details+'</a>');
						html_response.push('</li>');
					html_response.push('</ul>');
				}

				if (html_response.length) {
					$('#search-filter-slider-' + response.params.token_id).html(html_response.join(""));

					idxboostTypeIcon();

					//RECUPERANDO LOS PARAMETROS QUE NECESITAMOS
					var dataItems = $('#search-filter-slider-' + response.params.token_id).parents(".featured-section").attr("data-item");
					var styleFormat = ($('#search-filter-slider-' + response.params.token_id).parents(".featured-section").attr("data-gallery")) * 1; //PARAMETRO PARA EL FORMATO GRILLA O SLIDER

					//CONSULTAMOS LA CANTIDAD DE ITEMS A MOSTRAR
					if(dataItems !== "" && dataItems !== undefined){
						initialItems = dataItems * 1;
					}else{
						initialItems = 4;
					}
					
					//CONSULTAMOS LA EXISTENCIA Y EL TIPO DE FORMATO "GRILLA/SLIDER"
					if(styleFormat !== "" && styleFormat !== undefined && styleFormat > 0){
						styleFormat = 1; //RECUPERAMOS EL PARAMETRO
					}else{
						styleFormat = 0;
					}
			
					//CONSULTAMOS EL FORMATO
					if(styleFormat == 1){
						//generamos las clases para el formato de columnas
						if(initialItems < 2){
							initialItems = 2;
						}else if(initialItems > 4){
							initialItems = 4;
						}else{
							initialItems = initialItems;
						}
						$('#search-filter-slider-' + response.params.token_id).parents(".featured-section").addClass("ms-colums-"+initialItems);
					}else{
						//GENERAMOS EL SLIDER
						$('#search-filter-slider-' + response.params.token_id).greatSlider({
							type: 'swipe',
							nav: true,
							navSpeed: 500,
							lazyLoad: true,
							bullets: false,
							items: 1,
							layout: {
								bulletDefaultStyles: false,
								wrapperBulletsClass: 'clidxboost-gs-wrapper-bullets',
								arrowPrevContent: 'Prev',
								arrowNextContent: 'Next',
								arrowDefaultStyles: false
							},
							breakPoints: {
								640: {
									items: 2,
									slideBy: 2,
									nav: false,
									bullets: true
								},
								991: {
									items: 3,
									slideBy: 3
								},
								1360: {
									items: initialItems,
									slideBy: initialItems,
								}
							},
							onStepStart: function(){
								$(this).find(".flex-slider-current img").each(function() {
									if(!$(this).hasClass(".loaded")){
										var dataImage = $(this).attr('data-original');
										$(this).attr("data-was-processed","true").attr("src",dataImage).addClass("initial loaded");
									}
								});
							},
							onStepEnd: function() {
								myLazyLoad = new LazyLoad({
									elements_selector: ".flex-lazy-image",
									callback_load: function() {},
									callback_error: function(element){
										$(element).attr('src','https://idxboost.com/i/default_thumbnail.jpg').removeClass('error').addClass('loaded');
										$(element).attr('data-origin','https://idxboost.com/i/default_thumbnail.jpg');
									}
								});
							},
							onInited: function(){
								var $a = 0;
								var $bulletBtn = $('#search-filter-slider-' + response.params.token_id).find(".gs-bullet");
								if($bulletBtn.length){
									$bulletBtn.each(function() {
										$a += 1;
										$(this).text('View Slide '+$a);
									});
								}
							},
							onResized: function(){
								var $a = 0;
								var $bulletBtn = $('#search-filter-slider-' + response.params.token_id).find(".gs-bullet");
								if($bulletBtn.length){
									$bulletBtn.each(function() {
										$a += 1;
										$(this).text('View Slide '+$a);
									});
								}
							}
						});
					}

					$('#search-filter-slider-' + response.params.token_id).addClass('clidxboost-properties-slider');
	
					myLazyLoad = new LazyLoad({
						elements_selector: ".flex-lazy-image",
						callback_load: function() {},
						callback_error: function(element){
						  $(element).attr('src','https://idxboost.com/i/default_thumbnail.jpg').removeClass('error').addClass('loaded');
						  $(element).attr('data-origin','https://idxboost.com/i/default_thumbnail.jpg');
						}
					});

					html_response.length = 0;
				}
			}

			//update list off market listing
			__flex_idx_search_filter.list_offmarket = response.list_off_market_listing;

			// update hackbox variable
			__flex_idx_search_filter.hackbox.content = response.hackbox;

			// update force registration variable
			// if (false === __flex_g_settings.force_registration) {
			//     __flex_g_settings.force_registration = response.force_registration;
			// }

			// handle force registration individually
			if (true === response.force_registration) {
				__flex_g_settings.force_registration = 1;
			}

			if (0 == __flex_g_settings.force_registration) {
				IB_HAS_LEFT_CLICKS = false;
			}


			ib_xhr_running = false;

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

			// dataLayer Tracking Collection [event = view_search_results]
			if (typeof dataLayer !== "undefined") {
				if (__flex_g_settings.hasOwnProperty("has_dynamic_remarketing") && ("1" == __flex_g_settings.has_dynamic_remarketing)) {
					if ("undefined" !== typeof dataLayer) {
						if (response.hasOwnProperty("items") && response.items.length) {
							if (response.hasOwnProperty("events") && response.events.hasOwnProperty("view_search_results")) {
								dataLayer.push({
									"event": "view_search_results",
									"city": response.events.view_search_results.city,
									"region": response.events.view_search_results.region,
									"country": response.events.view_search_results.country,
									"preferred_baths_range": response.events.view_search_results.preferred_baths_range,
									"preferred_beds_range": response.events.view_search_results.preferred_beds_range,
									"preferred_price_range": response.events.view_search_results.preferred_price_range,
									"property_type": response.events.view_search_results.property_type
								});
							}
						}
					}
				}
			}

			IB_USER_IS_DRAWING = false;

			// validate if mobile device
			if( /Android|webOS|iPhone|iPad|iPod|Opera Mini/i.test(navigator.userAgent) ) {
				window.scrollTo(0, 0);
			}

			var params = response.params;
			var pagination = response.pagination;
			var items = response.items;
			var map_items = response.map_items;
			var slug = response.slug;
			var condition = response.condition;
			
			IB_SEARCH_FILTER.attr("data-count", pagination.count);
			IB_SEARCH_FILTER.attr("data-condition", condition);
			IB_SEARCH_FILTER.attr("data-name", params.name);
			IB_SEARCH_FILTER.attr("data-params", JSON.stringify({
				sale_type: params.sale_type,
				min_rent_price: params.min_rent_price,
				max_rent_price: params.max_rent_price,
				min_sale_price: params.min_sale_price,
				max_sale_price: params.max_sale_price,
				min_beds: params.min_beds,
				max_beds: params.max_beds,
				min_baths: params.min_baths,
				max_baths: params.max_baths,
				min_living_size: params.min_living_size,
				max_living_size: params.max_living_size
			}));

			if ("0" == params.sale_type) {
				if ( (null == params.min_sale_price) && (null == params.max_sale_price) ) {
					IB_LBL_PRICE_NTF.html(word_translate.any_price);
				} else if ((null != params.min_sale_price) && (null == params.max_sale_price)) {
					if (0 == params.min_sale_price) {
						IB_LBL_PRICE_NTF.html(word_translate.any_price);
					} else {
						IB_LBL_PRICE_NTF.html("$" + _.formatShortPrice(params.min_sale_price) + " - "+word_translate.any_price);
					}
				} else {
					IB_LBL_PRICE_NTF.html("$" + _.formatShortPrice(params.min_sale_price) + " - $" + _.formatShortPrice(params.max_sale_price));
				}
			} else {
				if ( (null == params.min_rent_price) && (null == params.max_rent_price) ) {
					IB_LBL_PRICE_NTF.html(word_translate.any_price);
				} else if ((null != params.min_rent_price) && (null == params.max_rent_price)) {
					if (0 == params.min_rent_price) {
						IB_LBL_PRICE_NTF.html(word_translate.any_price);
					} else {
						IB_LBL_PRICE_NTF.html("$" + _.formatShortPrice(params.min_rent_price) + " - "+word_translate.any_price);
					}
				} else {
					IB_LBL_PRICE_NTF.html("$" + _.formatShortPrice(params.min_rent_price) + " - $" + _.formatShortPrice(params.max_rent_price));
				}
			}

			if ( (null == params.min_beds) && (null == params.max_beds) ) {
				IB_LBL_BED_NTF.html(word_translate.any_beds);
			} else if ((null != params.min_beds) && (null == params.max_beds)) {
				if (0 == params.min_beds) {
					IB_LBL_BED_NTF.html(word_translate.any_beds);
				} else {
					IB_LBL_BED_NTF.html(_.formatShortPrice(params.min_beds) + " - "+word_translate.any_beds);
				}
				
			} else {
				IB_LBL_BED_NTF.html(_.formatShortPrice(params.min_beds) + " - " + _.formatShortPrice(params.max_beds) + " "+word_translate.beds);
			}

			if ( (null == params.min_baths) && (null == params.max_baths) ) {
				IB_LBL_BATH_NTF.html(word_translate.any_baths);
			} else if ((null != params.min_baths) && (null == params.max_baths)) {
				if (0 == params.min_baths) {
					IB_LBL_BATH_NTF.html(word_translate.any_baths);
				} else {
					IB_LBL_BATH_NTF.html(_.formatShortPrice(params.min_baths) + " - "+word_translate.any_baths);
				}
			} else {
				IB_LBL_BATH_NTF.html(_.formatShortPrice(params.min_baths) + " - " + _.formatShortPrice(params.max_baths) + " "+word_translate.baths);
			}

			var labelPropertyTypes = [];
		
			if ( (-1 != $.inArray("2", params.property_type)) || (-1 != $.inArray(2, params.property_type)) ) {
				labelPropertyTypes.push("Homes");
			}

			if ( (-1 != $.inArray("1", params.property_type)) || (-1 != $.inArray(1, params.property_type)) ) {
				labelPropertyTypes.push("Condominiums");
			}

			if (-1 != $.inArray("tw", params.property_type)) {
				labelPropertyTypes.push("Townhouses");
			}

			if (-1 != $.inArray("mf", params.property_type)) {
				labelPropertyTypes.push("Multi-Family");
			}

			if (-1 != $.inArray("valand", params.property_type)) {
				labelPropertyTypes.push("Vacant Land");
			}

			if (labelPropertyTypes.length) {
				labelPropertyTypes.forEach(function(item_translate,pos_trans){
					if(item_translate=='Homes'){
						labelPropertyTypes[pos_trans]=word_translate.homes;
					}else if(item_translate=='Condominiums'){
						labelPropertyTypes[pos_trans]=word_translate.condominiums;
					}else if(item_translate=='Townhouses'){
						labelPropertyTypes[pos_trans]=word_translate.townhouses;
					}else if (item_translate=='"Single Family Homes"'){
						text_label_trans=word_translate.single_family_homes;
					} else if (item_translate == 'Multi-Family') {
						text_label_trans = "Multi-Family";
					} else if (item_translate == "Vacant land") {
						text_label_trans = 'Vacant Land';
					}
				});

				// if (labelPropertyTypes.length === __flex_idx_search_filter.search.property_types.length) {
				if (labelPropertyTypes.length === __flex_g_settings.overwrite_settings.property_types.length) {
					IB_LBL_TYPES_NTF.html(word_translate.any_type);
				} else {
					IB_LBL_TYPES_NTF.html(labelPropertyTypes.join(", "));
				}
				labelPropertyTypes.length = 0;
			}


			IB_RG_MATCHING.html(word_translate.view+" " + _.formatShortPrice(pagination.count) + " "+word_translate.listings);
			$(".ib-fmapply").html(word_translate.view+" " + _.formatShortPrice(pagination.count) + " "+word_translate.listings);
			$("#ib-apply-filters-btn").html(word_translate.view+' <span>'+_.formatShortPrice(pagination.count)+'</span> '+word_translate.properties);

			IB_SEARCH_FILTER_FORM.find('[name="sale_type"]').val(params.sale_type);
			IB_SEARCH_FILTER_FORM.find('[name="filter_search_keyword_label"]').val(params.filter_search_keyword_label);
			IB_SEARCH_FILTER_FORM.find('[name="filter_search_keyword_type"]').val(params.filter_search_keyword_type);
			IB_SEARCH_FILTER_FORM.find('[name="waterfront_options"]').val(params.waterfront_options);
			IB_SEARCH_FILTER_FORM.find('[name="min_sale_price"]').val(params.min_sale_price);
			IB_SEARCH_FILTER_FORM.find('[name="max_sale_price"]').val(params.max_sale_price);
			IB_SEARCH_FILTER_FORM.find('[name="min_rent_price"]').val(params.min_rent_price);
			IB_SEARCH_FILTER_FORM.find('[name="max_rent_price"]').val(params.max_rent_price);
			IB_SEARCH_FILTER_FORM.find('[name="min_beds"]').val(params.min_beds);
			IB_SEARCH_FILTER_FORM.find('[name="max_beds"]').val(params.max_beds);
			IB_SEARCH_FILTER_FORM.find('[name="min_baths"]').val(params.min_baths);
			IB_SEARCH_FILTER_FORM.find('[name="max_baths"]').val(params.max_baths);
			IB_SEARCH_FILTER_FORM.find('[name="min_living_size"]').val(params.min_living_size);
			IB_SEARCH_FILTER_FORM.find('[name="max_living_size"]').val(params.max_living_size);
			IB_SEARCH_FILTER_FORM.find('[name="min_lot_size"]').val(params.min_lot_size);
			IB_SEARCH_FILTER_FORM.find('[name="max_lot_size"]').val(params.max_lot_size);
			IB_SEARCH_FILTER_FORM.find('[name="min_year"]').val(params.min_year);
			IB_SEARCH_FILTER_FORM.find('[name="max_year"]').val(params.max_year);
			IB_SEARCH_FILTER_FORM.find('[name="sort_type"]').val(params.sort_type);
			IB_SEARCH_FILTER_FORM.find('[name="page"]').val(params.currentpage);

			if (params.hasOwnProperty('overwrite_show_hide_pending')) {
				IB_SEARCH_FILTER_FORM.find('[name="overwrite_show_hide_pending"]').val(params.overwrite_show_hide_pending);

				if ('yes' === params.overwrite_show_hide_pending) {
					$("#pendingContigentMin").prop("checked", true);
					$("#pendingContigent").prop("checked", true);
					$("#pendingContigentMobile").prop("checked", true);
				} else {
					$("#pendingContigentMin").prop("checked", false);
					$("#pendingContigent").prop("checked", false);
					$("#pendingContigentMobile").prop("checked", false);
				}
			}

			if (params.hasOwnProperty("property_type")) {
				if (Array.isArray(params.property_type)) {
					IB_SEARCH_FILTER_FORM.find('[name="property_type"]').val(params.property_type.join(","));
				}
			}

			if (true === IB_GMAP_INIT) {
				if (params.hasOwnProperty("zm")) {
					//IB_SEARCH_FILTER_FORM.find('[name="zm"]').val(params.zm);
				}
	
				if (params.hasOwnProperty("rect")) {
					//IB_SEARCH_FILTER_FORM.find('[name="rect"]').val(params.rect);
				}
			}

			if (params.hasOwnProperty("polygon_search")) {
				IB_SEARCH_FILTER_FORM.find('[name="polygon_search"]').val(params.polygon_search);
			}

			IB_SEARCH_FILTER_FORM.find('[name="parking_options"]').val(params.parking_options);
			
			if (params.hasOwnProperty("amenities")) {
				IB_SEARCH_FILTER_FORM.find('[name="amenities"]').val(params.amenities.join(","));
			}

			if (params.hasOwnProperty("filter_search_keyword_label") && params.hasOwnProperty("polygon_search")) {
				if ( (null == params.filter_search_keyword_label) && (null == params.polygon_search) && (!params.hasOwnProperty("kml_boundaries")) ) {
					IB_LOOKUP_DRAG = true;
				}

				if (params.hasOwnProperty("kml_boundaries") && params.kml_boundaries.length) {
					IB_LOOKUP_DRAG = false;
				}
			} else {
				IB_LOOKUP_DRAG = false;
			}

			if (("" == params.polygon_search || null == params.polygon_search) && 
				 ("" == params.filter_search_keyword_label || null == params.filter_search_keyword_label)) {
				IB_LOOKUP_DRAG = true;
			}

			// initial call
			if ("0" == params.sale_type) {
				$(".ib-price-range-wrap").hide();
				$(".ib-price-range-wrap-sale").show();
				IB_RENTAL_TYPE.find("div:eq(0)").addClass("ib-fifor-active");
			} else {
				$(".ib-price-range-wrap").hide();
				$(".ib-price-range-wrap-rent").show();
				IB_RENTAL_TYPE.find("div:eq(1)").addClass("ib-fifor-active");
			}

			if (IB_PAGINATION_CTRL.length) {
				if (pagination.pages > 1) {
					var htmlBuildPagination = [];

					htmlBuildPagination.push('<span class="ib-pagn">'+word_translate.page+' '+ params.currentpage +' '+word_translate.of+' '+pagination.pages+'</span>');

					if (params.currentpage > 1) {
						htmlBuildPagination.push('<a role="button" class="ib-pagfirst ib-paggo" data-page="1"><span>'+word_translate.first_page+'</span></a>');
					}

					if (pagination.prev) {
						htmlBuildPagination.push('<a role="button" class="ib-pagprev ib-paggo" data-page="'+(params.currentpage - 1)+'"><span>'+word_translate.previous_page+'</span></a>');
					}

					if (pagination.range.length) {
						htmlBuildPagination.push('<div class="ib-paglinks">');

						for (var i = 0, l = pagination.range.length; i < l; i++) {
							if (params.currentpage == pagination.range[i]) {
								htmlBuildPagination.push('<a role="button" class="ib-plitem ib-plitem-active" data-page="'+pagination.range[i]+'">'+pagination.range[i]+'</a>');
							} else {
								htmlBuildPagination.push('<a role="button" class="ib-plitem" data-page="'+pagination.range[i]+'">'+pagination.range[i]+'</a>');
							}
						}

						htmlBuildPagination.push('</div>');
					}

					if (pagination.next) {
						htmlBuildPagination.push('<a role="button" class="ib-pagnext ib-paggo" data-page="'+(params.currentpage + 1)+'"><span>'+word_translate.next_page+'</span></a>');
					}

					if (params.currentpage < pagination.pages) {
						htmlBuildPagination.push('<a role="button" class="ib-paglast ib-paggo" data-page="'+pagination.pages+'"><span>'+word_translate.last_page+'</span></a>');
					}
					
					if (htmlBuildPagination.length) {
						IB_PAGINATION_CTRL.html(htmlBuildPagination.join(""));
						htmlBuildPagination.length = 0;
					}
				} else {
					IB_PAGINATION_CTRL.html("");
				}
			}

			if (IB_SORT_CTRL.length) {
				IB_SORT_CTRL.val(params.sort_type);
			}

			if (IB_HEADING_CT.length) {
				IB_HEADING_CT.html(word_translate.showing+" "+pagination.start+" "+word_translate.to+" "+pagination.end+" "+word_translate.of+" "+_.formatPrice(pagination.count)+" "+word_translate.properties+".");    
			}

			if ("" != params.filter_search_keyword_label) {
				ib_autocomplete.val(params.filter_search_keyword_label);
			}

			if (IB_LB_TYPES_OPTIONS.length) {
				// console.log('init');
				// console.dir(IB_LB_TYPES_OPTIONS);
				// console.dir(params.property_type);

				IB_LB_TYPES_OPTIONS.find("input").each(function (index, node) {
					//console.log(typeof node.value, ": " + node.value, isNaN(node.value));

					//var currentValue = ! isNaN(node.value) ? parseInt(node.value, 10) : node.value;
					//console.log(currentValue);
					//console.log(params.property_type);
					// var currentValue = (false === isNaN(node.value)) ? (node.value + "") : node.value;
					var currentValue = node.value;

					if (/[0-9+]/.test(currentValue) !== false) {
						currentValue = parseInt(currentValue, 10);
					}

					if (-1 != $.inArray(currentValue, params.property_type)) {
						node.checked = true;
					}
				});
			}

			if (IB_LB_WATERFRONT_OPTIONS.length) {
				IB_LB_WATERFRONT_OPTIONS.val((null == params.waterfront_options) ? "--" : params.waterfront_options);
			}

			if (IB_LB_PARKING_OPTIONS.length) {
				IB_LB_PARKING_OPTIONS.val((null == params.parking_options) ? "--" : params.parking_options);
			}

			if (IB_LB_AMENITIES_OPTIONS.length) {
				IB_LB_AMENITIES_OPTIONS.find('input').each(function() {
					if (-1 !== $.inArray(this.value, params.amenities)) {
						this.checked = true;
					}
				});
			}

			if (IB_LB_AMENITIES_EXTRAS_OPTIONS.length) {
				IB_LB_AMENITIES_EXTRAS_OPTIONS.find('input').each(function() {
					if (-1 !== $.inArray(this.value, params.othersamenities)) {
						this.checked = true;
					}
				});
			}			

			// range notifiers
			if (IB_RG_PRICE_SALE_LBL_LT.length) {
				var min_sale_price = "$" + _.formatPrice(params.min_sale_price)
				IB_RG_PRICE_SALE_LBL_LT.val(min_sale_price);
			}

			if (IB_RG_PRICE_SALE_LBL_RT.length) {
				var max_sale_price = (null == params.max_sale_price) ? word_translate.any_price : ("$" + _.formatPrice(params.max_sale_price));
				IB_RG_PRICE_SALE_LBL_RT.val(max_sale_price);
			}

			if (IB_RG_PRICE_RENT_LBL_LT.length) {
				var min_rent_price = "$" + _.formatPrice(params.min_rent_price);
				IB_RG_PRICE_RENT_LBL_LT.val(min_rent_price);
			}

			if (IB_RG_PRICE_RENT_LBL_RT.length) {
				var max_rent_price = (null == params.max_rent_price) ? word_translate.any_price : ("$" + _.formatPrice(params.max_rent_price));
				IB_RG_PRICE_RENT_LBL_RT.val(max_rent_price);
			}

			if (IB_RG_YEAR_LBL_LT.length) {
				var min_year = (null == params.min_year) ? "1900" : params.min_year;
				IB_RG_YEAR_LBL_LT.val(min_year);
			}

			if (IB_RG_YEAR_LBL_RT.length) {
				var max_year = (null == params.max_year) ? current_year : params.max_year;
				IB_RG_YEAR_LBL_RT.val(max_year);
			}

			if (IB_RG_LIVING_LBL_LT.length) {
				var min_living_size = _.formatPrice(params.min_living_size) + ' '+word_translate.sqft;
				if (parseFloat(params.min_living_size) >= 20000) {
					min_living_size = (parseFloat(params.min_living_size)/43560).toFixed(2)+ " Acre";
                }                    
				IB_RG_LIVING_LBL_LT.val(min_living_size);
			}

			if (IB_RG_LIVING_LBL_RT.length) {
				var max_living_size = (null == params.max_living_size) ? word_translate.any_size : (_.formatPrice(params.max_living_size) + " "+word_translate.sqft);
				if ( parseFloat(params.max_living_size) >= 20000) {
					max_living_size = (parseFloat(params.max_living_size)/43560).toFixed(2)+ " Acre";
                }                    				
				IB_RG_LIVING_LBL_RT.val(max_living_size);
			}

			if (IB_RG_LAND_LBL_LT.length) {
				var min_lot_size = _.formatPrice(params.min_lot_size) + ' '+word_translate.sqft;
				if (parseFloat(params.min_lot_size) >= 20000) {
					min_lot_size = (parseFloat(params.min_lot_size)/43560).toFixed(2)+ " Acre";
                }
				IB_RG_LAND_LBL_LT.val(min_lot_size);
			}

			if (IB_RG_LAND_LBL_RT.length) {
				var max_lot_size = (null == params.max_lot_size) ? word_translate.any_size : (_.formatPrice(params.max_lot_size) + " "+word_translate.sqft);
                if ( parseFloat(params.max_lot_size) >= 20000) {
                	max_lot_size = (parseFloat(params.max_lot_size)/43560).toFixed(2)+ " Acre";
                }
				IB_RG_LAND_LBL_RT.val(max_lot_size);
			}

			// price for sale
			IB_RG_PRICE_SALE.slider("option", "values", getPriceSaleValues(params.min_sale_price, params.max_sale_price));

			// price for rent
			IB_RG_PRICE_RENT.slider("option", "values", getPriceRentValues(params.min_rent_price, params.max_rent_price));

			// year built
			IB_RG_YEARBUILT.slider("option", "values", getYearValues(params.min_year, params.max_year));

			// bedrooms
			IB_RG_BEDROOMS.slider("option", "values", getBedroomValues(params.min_beds, params.max_beds));

			// bathrooms
			IB_RG_BATHROOMS.slider("option", "values", getBathroomValues(params.min_baths, params.max_baths));

			// living size
			IB_RG_LIVINGSIZE.slider("option", "values", getLivingSizeValues(params.min_living_size, params.max_living_size));

			// land size
			IB_RG_LANDSIZE.slider("option", "values", getLandSizeValues(params.min_lot_size, params.max_lot_size));

			var source = $("#ib-aside-template").html();
			var template = Handlebars.compile(source);

			IB_LISTINGS_CT.html(template(items));

			if (typeof event !== "undefined") {
				if ("" != slug) {
					history.pushState(null, null, '?' + decodeURIComponent(slug));
					initial_title = document.title;
					initial_href = '?' + decodeURIComponent(slug);
				} else {
					history.pushState(null, null, __flex_idx_search_filter.searchFilterPermalink);
					initial_title = document.title;
					initial_href = __flex_idx_search_filter.searchFilterPermalink;
				}
			} else {
				initial_title = document.title;
				initial_href = location.href;
			}

			if ("undefined" === typeof IB_MAP) {
				var gmap_coords = params.rect.split(",");
				var gmap_bounds = new google.maps.LatLngBounds(
					new google.maps.LatLng(parseFloat(gmap_coords[0]), parseFloat(gmap_coords[1])), // SW
					new google.maps.LatLng(parseFloat(gmap_coords[2]), parseFloat(gmap_coords[3])) // NE
				);

				IB_MAP = new google.maps.Map(document.getElementById("flex_idx_search_filter_map"), {
					center: { lat: gmap_bounds.getCenter().lat(), lng: gmap_bounds.getCenter().lng() },
					zoom: parseInt(params.zm, 10),
					clickableIcons: false,
					disableDoubleClickZoom: true,
					scrollwheel: false,
					panControl: false,
					styles: style_map,
					gestureHandling: 'greedy',
					disableDefaultUI: true,
					streetViewControl: true,
					/*mapTypeControl: true,
					mapTypeControlOptions: {
						position: google.maps.ControlPosition.RIGHT_TOP,
					}*/
				});

				IB_MAP.addListener("dragend", function() {
					var idleListener = IB_MAP.addListener("idle", function() {
						google.maps.event.removeListener(idleListener);
						// handleBoundsChangeEvent(IB_MAP);
						handleDragSearchEvent();
					});
				});

				// IB_MAP.addListener("zoom_changed", function() {
				//     var idleListener = IB_MAP.addListener("idle", function() {
				//         google.maps.event.removeListener(idleListener);
				//         // handleBoundsChangeEvent(IB_MAP);
				//         handleDragSearchEvent();
				//     });
				// });

				// fill values for mobile form [filter]
				fillValuesMobileForm(response);

				// attach listeners for mobile form [filter]
				attachListenersMobileForm();

				google.maps.event.addListenerOnce(IB_MAP, 'tilesloaded', setupMapControlsFull);
			}

			if (params.hasOwnProperty('kml_boundaries'))  {
				if (typeof IB_POLYGON !== "undefined") {
					IB_POLYGON.setMap(null);
				}

				if (params.hasOwnProperty("map_overlay_hidden")) {
					IB_POLYGON = new google.maps.Polygon({
						paths: ib_generate_latlng_from_kml(params.kml_boundaries),
						draggable: false,
						editable: false,
						strokeColor: '#31239a',
						strokeOpacity: ("1" == params.map_overlay_hidden) ? 0 : 0.8,
						strokeWeight: 1,
						fillColor: '#31239a',
						fillOpacity: ("1" == params.map_overlay_hidden) ? 0 : 0.1
					});
				} else { // older clients
					IB_POLYGON = new google.maps.Polygon({
						paths: ib_generate_latlng_from_kml(params.kml_boundaries),
						draggable: false,
						editable: false,
						strokeColor: '#31239a',
						strokeOpacity: 0.8,
						strokeWeight: 1,
						fillColor: '#31239a',
						fillOpacity: 0.1
					});
				}



				if (typeof IB_DRAWING_POLYGON !== "undefined") {
					IB_DRAWING_POLYGON.setMap(null);
				}

				IB_POLYGON.setMap(IB_MAP);

				IB_HAS_POLYGON = true;
				IB_MAP_TOOLTIP.removeClass("ib-removeb-hide");
			} else {
				IB_MAP_TOOLTIP.addClass("ib-removeb-hide");

				if (typeof IB_POLYGON !== "undefined") {
					IB_POLYGON.setMap(null);
				}
			}

			if (IB_MARKERS.length) {
				for (var i = 0, l = IB_MARKERS.length; i < l; i++) {
					IB_MARKERS[i].setMap(null);
				}

				IB_MARKERS.length = 0;
			}

			var IB_BOUNDS = new google.maps.LatLngBounds();
			IB_HIDDEN_BOUNDS = new google.maps.LatLngBounds();

			var row,
				inner,
				geocode,
				property,
				hashed_properties = [],
				filtered_properties = [],
				unique_properties = [];

			// reduce markers [first step]
			for (var i = 0, l = map_items.length; i < l; i++) {
				// if (i >= 39) { break; }
				row = map_items[i];
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
				for (var k = 0, m = map_items.length; k < m; k++) {
					inner = map_items[k];
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

				IB_MARKER = new RichMarker({
					position: new google.maps.LatLng(parseFloat(property.item.lat), parseFloat(property.item.lng)),
					map: IB_MAP,
					flat: true,
					content: (property.group.length > 1) ? '<div class="dgt-richmarker-group"><strong>' + property.group.length + '</strong><span>'+word_translate.units+'</span></div>' : '<div class="dgt-richmarker-single"><strong>$' + _.formatShortPrice(property.item.price) + '</strong></div>',
					anchor: RichMarkerPosition.TOP
				});
	
				IB_MARKER.geocode = property.item.lat + ':' + property.item.lng;
				IB_MARKER.mls_num = property.item.mls_num;
				IB_MARKER.iblength = property.group.length;
	
				IB_MARKERS.push(IB_MARKER);

				if (params.hasOwnProperty('kml_boundaries'))  {
					IB_POLYGON.getPath().forEach(function (position) {
						IB_BOUNDS.extend(position);
						IB_HIDDEN_BOUNDS.extend(position);
					});
				} else {
					IB_BOUNDS.extend(IB_MARKER.position);
					IB_HIDDEN_BOUNDS.extend(IB_MARKER.position);
				}

				google.maps.event.addListener(IB_MARKER, "click", handleMarkerClick(IB_MARKER, property, IB_MAP));

				google.maps.event.addListener(IB_MARKER, "mouseover", handleMarkerMouseOver(IB_MARKER));
				google.maps.event.addListener(IB_MARKER, "mouseout", handleMarkerMouseOut(IB_MARKER));
			}

			if (IB_MARKERS.length) {
				IB_MARKERS_LISTINGS.length = 0;
				IB_MARKERS_LISTINGS = _.pluck(IB_MARKERS, "mls_num");
			}

			if (items.length === 0) {
				$(".ib-heading-ct").html(word_translate.showing+" 0 "+word_translate.properties+'.');
				$('.ib-gnopro').addClass('ib-gnopro-show');
			} else {
				$('.ib-gnopro').removeClass('ib-gnopro-show');
			}

			// load initially a property if exists in hash
			if (typeof event === "undefined") {
				var urlParams = new URLSearchParams(window.location.search);

				if (urlParams.has("show")) {
					var mlsNumber = urlParams.get("show");
					loadPropertyInModal(mlsNumber);
				}
			}

			var urlParams = new URLSearchParams(window.location.search);
			
			if (false === IB_GMAP_INIT) {
				IB_GMAP_INIT = true;

				if (urlParams.has("rect") && urlParams.has("zm")) {
					var gmap_coords = urlParams.get("rect").split(",");
					var gmap_zoom = parseInt(urlParams.get("zm"), 10);
					var gmap_bounds = new google.maps.LatLngBounds(
						new google.maps.LatLng(parseFloat(gmap_coords[0]), parseFloat(gmap_coords[1])), // SW
						new google.maps.LatLng(parseFloat(gmap_coords[2]), parseFloat(gmap_coords[3])) // NE
					);
				
					IB_MAP.setCenter({ lat: gmap_bounds.getCenter().lat(), lng: gmap_bounds.getCenter().lng() });
					IB_MAP.setZoom(gmap_zoom);
				}
			}

			// @todo
			google.maps.event.clearListeners(IB_MAP, "idle");

			if (true === IB_GMAP_FIT_TO_BOUNDS) {
				if (!urlParams.has("rect") && !urlParams.has("zm")) {
					if (location.search.length > 0 && map_items.length) {
						// console.log('[fit]');
						IB_MAP.fitBounds(IB_BOUNDS);
					}
				}
				
				// IB_GMAP_FIT_TO_BOUNDS = false;
			}

			// TODO: refactor this function. This avoid display hackbox form behind the items
			if (window.idxpages && window.idxpages.hackbox) {
				if (typeof window.idxpages.hackbox.addPortal === 'function') {
					window.idxpages.hackbox.addPortal();
				}

				if (typeof window.idxpages.hackbox.handleModal === 'function') {
					window.idxpages.hackbox.handleModal();
				}
			}

			// @todo
			/*
			if (false === IB_GMAP_BOUNDS_LOADED) {
				IB_GMAP_BOUNDS_LOADED = true;
				setTimeout(function() {
					setupListenersForMapBounds();
				}, 300);
			}
			*/

			/*
			setTimeout(function () {
				// google.maps.event.addListener(IB_MAP, "idle", handleDragSearchEvent);
				console.log('count');

				IB_MAP.addListener("dragend", function() {
					var idleListener = IB_MAP.addListener("idle", function() {
						google.maps.event.removeListener(idleListener);
						handleDragSearchEvent();
					});
				});
				IB_MAP.addListener("zoom_changed", function() {
					var idleListener2 = IB_MAP.addListener("idle", function() {
						google.maps.event.removeListener(idleListener2);
						handleDragSearchEvent();
					});
				});
			}, 2000);
			*/
		}
	});
}

// @todo domReady check for mobile remove boundaries
$(function () {
	$(".ib-block-status-search-only").hide();

	$(document).on("click", ".ib-removeb-tg", function() {
		IB_GMAP_FINISHED_POLYGON = false;

		if (window.innerWidth < 990) {
			// $('.ib-mobile-sview').val('map');
			// $('.ib-mobile-sview').change();
			$(".idx-bta-map").click();

			setTimeout(function () {
				IB_LOOKUP_DRAG = true;

				IB_SEARCH_FILTER_FORM.find('[name="filter_search_keyword_label"]').val("");
				IB_SEARCH_FILTER_FORM.find('[name="filter_search_keyword_type"]').val("");
				IB_SEARCH_FILTER_FORM.find('[name="polygon_search"]').val("");
				IB_SEARCH_FILTER_FORM.find('[name="page"]').val(1);

				if ("undefined" !== typeof IB_POLYGON) {
					IB_POLYGON.setMap(null);
				}

				if ("undefined" !== typeof IB_DRAWING_POLYGON) {
					// console.log("remove polygon draw");
					IB_DRAWING_POLYGON.setMap(null);
				}

				IB_HAS_POLYGON = false;

				var mapCenter = IB_MAP.getCenter();
				var mapZoom = IB_MAP.getZoom();
				var mapBounds = IB_MAP.getBounds();

				IB_MAP_TOOLTIP.addClass("ib-removeb-hide");
				// console.log("hide remove boundaries button");

				IB_SEARCH_FILTER_FORM.find('[name="rect"]').val(mapBounds.toUrlValue());
				IB_SEARCH_FILTER_FORM.find('[name="zm"]').val(mapZoom);

				IB_SEARCH_FILTER_FORM.trigger("submit");
			}, 100);
		} else {
			IB_LOOKUP_DRAG = true;

			IB_SEARCH_FILTER_FORM.find('[name="filter_search_keyword_label"]').val("");
			IB_SEARCH_FILTER_FORM.find('[name="filter_search_keyword_type"]').val("");
			IB_SEARCH_FILTER_FORM.find('[name="polygon_search"]').val("");
			IB_SEARCH_FILTER_FORM.find('[name="page"]').val(1);

			if ("undefined" !== typeof IB_POLYGON) {
				IB_POLYGON.setMap(null);
			}

			if ("undefined" !== typeof IB_DRAWING_POLYGON) {
				// console.log("remove polygon draw");
				IB_DRAWING_POLYGON.setMap(null);
			}

			IB_HAS_POLYGON = false;

			var mapCenter = IB_MAP.getCenter();
			var mapZoom = IB_MAP.getZoom();
			var mapBounds = IB_MAP.getBounds();
	
			IB_MAP_TOOLTIP.addClass("ib-removeb-hide");
			// console.log("hide remove boundaries button");
		
			IB_SEARCH_FILTER_FORM.find('[name="rect"]').val(mapBounds.toUrlValue());
			IB_SEARCH_FILTER_FORM.find('[name="zm"]').val(mapZoom);

			IB_SEARCH_FILTER_FORM.trigger("submit");
		}

		$('.ib-gnopro').removeClass('ib-gnopro-show');
	});

	$(document).on("click", ".ib-rembounds", function() {
		if ($(".ib-removeb-tg:eq(0)").is(":visible")) {
			$(".ib-removeb-tg").click();
		}
	});

	/** Initialize variables for Autocomplete */
	ib_autocomplete = $(".ib-fmsearch:eq(0)");
	ib_autocomplete_btn = $(".ib-kw-tg-search:eq(0)");

	/** Setup listeners for Autocomplete */
	if (ib_autocomplete_btn.length) {
		ib_autocomplete_btn.on("click", handleSubmitAutocompleteForm);
	}

	if (ib_autocomplete.length) {
		ib_autocomplete.autocomplete({
			open: function(event, ui) {
				$('.ui-autocomplete').off('menufocus hover mouseover mouseenter');
			},
			create: function( event, ui ) {
				$(this).attr('autocomplete', 'disabled');
			},
			minLength: 0,
			source: handleLookupAutocomplete,
			select: handleSelectAutocomplete,
			appendTo: "#ib-autocomplete-add"
		});

		ib_autocomplete.autocomplete("instance")._renderItem = function( ul, item ) {
			if ("complex" === item.type) {
				return $('<li>')
				.append('<div>' + item.label + '<span class="autocomplete-item-type">Complex / Subdivision</span></div>')
				.appendTo(ul);
			} else {
				return $('<li>')
				.append('<div>' + item.label + '<span class="autocomplete-item-type">' + item.type + '</span></div>')
				.appendTo(ul)
			;
			}
		};

		ib_autocomplete.on("focus", handleFocusAutocompleteEvent);
		ib_autocomplete.on("keypress", handleKeyPressAutocompleteEvent);
		ib_autocomplete.on("keyup", handleKeyUpAutocompleteEvent);
		ib_autocomplete.on("search", handleClearAutocompleteEvent);
		ib_autocomplete.on("paste", handlePasteAutocompleteEvent);
	}

	IB_ACCESS_TOKEN = __flex_idx_search_filter.accessToken;
	IB_SEARCH_FILTER = $('#flex_idx_search_filter');
	IB_SEARCH_FILTER_FORM = $("#flex_idx_search_filter_form");
	IB_MAP_TOOLTIP = $(".ib-removeb-tg");
	IB_SAVE_SEARCH_MODALS = $(".flex-save-search-modals");

	//IB_SEARCH_FILTER_AUTOCOMPLETE = $(".ib-fmsearch:eq(0)");
	//IB_KW_TG_SEARCH = $(".ib-kw-tg-search:eq(0)");

	IB_CLEAR_BTN = $(".ib-dbclear");
	// IB_LB_CITIES = $(".ib-lcities");
	IB_LB_WATERFRONT_OPTIONS= $(".ib-waterfront-options");
	IB_LB_PARKING_OPTIONS = $(".ib-parking-options");
	IB_LB_AMENITIES_OPTIONS = $(".ib-amenities-options");
	IB_LB_AMENITIES_EXTRAS_OPTIONS = $(".ib-amenities-options-extra");
	IB_LB_TYPES_OPTIONS = $(".ib-types-options");
	IB_RENTAL_TYPE = $(".ib-fforsr:eq(0)");
	IB_RG_PRICE_SALE = $(".ib-rprice-sale");
	IB_RG_PRICE_RENT = $(".ib-rprice-rent");
	IB_RG_BEDROOMS = $(".ib-rbedrooms");
	IB_RG_BATHROOMS = $(".ib-rbathrooms");
	IB_RG_LIVINGSIZE = $(".ib-rliving");
	IB_RG_LANDSIZE = $(".ib-rland");
	IB_RG_YEARBUILT = $(".ib-ryear");

	IB_RG_PRICE_SALE_LBL_LT = $(".ib-rprice-sale-lbl-lt");
	IB_RG_PRICE_SALE_LBL_RT = $(".ib-rprice-sale-lbl-rt");
	IB_RG_PRICE_RENT_LBL_LT = $(".ib-rprice-rent-lbl-lt");
	IB_RG_PRICE_RENT_LBL_RT = $(".ib-rprice-rent-lbl-rt");
	
	IB_RG_YEAR_LBL_LT = $(".ib-ryear-lbl-lt");
	IB_RG_YEAR_LBL_RT = $(".ib-ryear-lbl-rt");
	
	IB_RG_LIVING_LBL_LT = $(".ib-rliving-lbl-lt");
	IB_RG_LIVING_LBL_RT = $(".ib-rliving-lbl-rt");
	
	IB_RG_LAND_LBL_LT = $(".ib-rland-lbl-lt");
	IB_RG_LAND_LBL_RT = $(".ib-rland-lbl-rt");

	IB_RG_MATCHING = $(".ib-fdmatching:eq(0)");

	IB_SORT_CTRL = $(".ib-sort-ctrl:eq(0)");
	IB_PAGINATION_CTRL = $(".ib-pagination-ctrl:eq(0)");
	IB_LISTINGS_CT = $(".ib-listings-ct:eq(0)");
	IB_HEADING_CT = $(".ib-heading-ct");

	IB_LBL_PRICE_NTF = $(".ib-lbl-price-ntf:eq(0)");
	IB_LBL_BED_NTF = $(".ib-lbl-bed-ntf:eq(0)");
	IB_LBL_BATH_NTF = $(".ib-lbl-bath-ntf:eq(0)");
	IB_LBL_TYPES_NTF = $(".ib-lbl-types-ntf:eq(0)");

	IB_MODAL_WRAPPER = $("#flex_idx_modal_wrapper");
	IB_MODAL_TPL = $("#ib-modal-template");

	buildSearchFilterForm();

	buildMobileForm();

	$(document).on("click", ".ib-ibclose", function() {
		$(this).parent().parent().parent().remove();
	});

	// handle cancel draw
	$("#map-draw-cancel-tg").on("click", function() {
		IB_USER_IS_DRAWING = false;

		/* Restore previous state */
		IB_DRAWING_MANAGER.setMap(null);

		if (typeof IB_DRAWING_POLYGON !== "undefined") {
			IB_DRAWING_POLYGON.setMap(null);
		}

		// check if map has polygon
		if (true === IB_HAS_POLYGON) {
			// hide polygon
			if ("undefined" !== typeof IB_POLYGON) {
				IB_POLYGON.setVisible(true);
			}
			IB_LOOKUP_DRAG = false;
		} else {
			IB_LOOKUP_DRAG = true;
		}
	
		// check if markers
		if (IB_MARKERS) {
			// hide them all
			for (var i = 0, l = IB_MARKERS.length; i < l; i++) {
				IB_MARKERS[i].setVisible(true);
			}
		}
	
		// show map actions
		$(mapButtonsWrapper).show();
	
		// hide navbar top
		$("#wrap-map-draw-actions").hide();
	});

	// handle apply draw
	$("#map-draw-apply-tg").on("click", function() {
		// @todo
		IB_DRAWING_MANAGER.setMap(null);

		if (false === IB_GMAP_FINISHED_POLYGON) {
			// check if markers
			if (IB_MARKERS) {
				// hide them all
				for (var i = 0, l = IB_MARKERS.length; i < l; i++) {
					IB_MARKERS[i].setVisible(true);
				}
			}

			if (typeof IB_POLYGON !== "undefined") {
				IB_POLYGON.setVisible(true);
			}
		} else {
			if (typeof IB_DRAWING_POLYGON !== "undefined") {
				if (true === IB_HAS_POLYGON) {
					IB_POLYGON.setMap(null);
				}
	
				var points = IB_DRAWING_POLYGON.getPath();
				var coords = [];
				var currentPathArray = [];
	
				var mapCenter = IB_MAP.getCenter();
				var mapZoom = IB_MAP.getZoom();
	
				points.forEach(function (point) {
					coords.push(point.lat() + " " + point.lng());
					currentPathArray.push({ lat: point.lat(), lng: point.lng() });
				});
	
				var lastPoint = points.getAt(0);
	
				coords.push(lastPoint.lat() + " " + lastPoint.lng());
	
				currentPathArray.push({ lat: lastPoint.lat(), lng: lastPoint.lng() });
	
				var points = new google.maps.MVCArray();
	
				for(var i = 0, l = currentPathArray.length; i < l; i++) {
					points.push(new google.maps.LatLng(currentPathArray[i].lat, currentPathArray[i].lng));
				}
	
				var encodedPath = google.maps.geometry.encoding.encodePath(points);
	
				// encode base64
				encodedPath = btoa(encodedPath);
	
				// make URL friendly
				encodedPath = encodedPath.replace(/\+/g, '-').replace(/\//g, '_').replace(/\=+$/, '');
	
				//console.dir(coords);
	
				var mapCenter = IB_MAP.getCenter();
				var mapZoom = IB_MAP.getZoom();
				var mapBounds = IB_MAP.getBounds();
			
				IB_SEARCH_FILTER_FORM.find('[name="rect"]').val(mapBounds.toUrlValue());
				IB_SEARCH_FILTER_FORM.find('[name="zm"]').val(mapZoom);

				// IB_SEARCH_FILTER_FORM.find('[name="gmap_coords_zoom"]').val("");
				IB_SEARCH_FILTER_FORM.find('[name="filter_search_keyword_label"]').val("");
				IB_SEARCH_FILTER_FORM.find('[name="filter_search_keyword_label"]').val("");
				IB_SEARCH_FILTER_FORM.find('[name="polygon_search"]').val(encodedPath);
				IB_SEARCH_FILTER_FORM.find('[name="page"]').val("1");
	
				IB_LOOKUP_DRAG = false;
				IB_SEARCH_FILTER_FORM.trigger("submit");
			}
		}

		// show map actions
		$(mapButtonsWrapper).show();
	
		// hide navbar top
		$("#wrap-map-draw-actions").hide();
	});

	// cambio de vista desde botonera
	$('.idx-bta-grid').click(function(){
		if (infoWindow.isOpen()) {
			infoWindow.close();
		}
		$(".ib-temp-modal-infobox").remove();
	});

	$(document).on("click", ".ib-ibpitem", function () {
		var mlsNumber = $(this).data("mls");
		loadPropertyInModal(mlsNumber);
	});

	$(document).on("click", ".ib-mmclose", function(event) {
		var $theModal = $(event.target).parents('.ib-modal-master');
		$theModal.addClass('ib-md-hiding');
		setTimeout(function() {
			$theModal.removeClass('ib-md-active ib-md-hiding');
		}, 250);
		$("body").removeClass('ib-request-float-modal');
	});

	$(document).on("click", ".ib-close-mproperty", function(event) {
		event.preventDefault();
		if ( __flex_g_settings.hasOwnProperty("force_registration_forced") && ("yes" == __flex_g_settings.force_registration_forced) ) {
			$(".ib-pbtnclose").click();
		  }
		//$(".ib-pbtnclose").click();
	});

	$(document).on("click", ".ib-paitem-load-schools", function(event) {
		// console.log("load schools information");

		var _self = $(this);
		var lat = _self.data("lat");
		var lng = _self.data("lng");
		var distance = _self.data("distance");

		var address_short = _self.data("address-short");
		var address_large = _self.data("address-large");

		if (_self.hasClass("ib-schools-loaded")) {
			return;
		}

		_self.addClass("ib-schools-loaded");
		$("#ib-paitem-load-schools-ct").empty();

		$.ajax({
			type: "POST",
			url: __flex_g_settings.ajaxUrl,
			data: {
				action: "ib_schools_info",
				lat: lat,
				lng: lng,
				distance: distance
			},
			success: function(response) {
				var html_output = response.output;

				html_output = html_output.replace("{{address_short}}", address_short);
				html_output = html_output.replace("{{address_large}}", address_large);

				$("#ib-paitem-load-schools-ct").html(html_output);

				var nicheContent = $(".clidxboost-body-niche .clidxboost-td-niche");

				if (nicheContent.length) {
					size_li = $(".clidxboost-body-niche .clidxboost-td-niche").length;
					size_li_actives = 0;
				}

				if (size_li == 0) { $("#clidxboost-container-loadMore-niche").hide(); }

				size_li_actives_X = 8;

				// attach listeners
				$('#clidxboost-data-loadMore-niche').click();
			}
		});
	});

	// FOR SCHOOLS INFORMATION LISTENERS CLICK

	$(document).on('click', '#clidxboost-data-loadMore-niche', function(event) {
		event.stopPropagation();

		size_li_actives_X = (size_li_actives_X + 8 <= size_li) ? size_li_actives_X + 8 : size_li;
		$('.clidxboost-body-niche .clidxboost-td-niche:lt(' + size_li_actives_X + ')').slideDown();
		$('.clidxboost-body-niche .clidxboost-td-niche:lt(' + size_li_actives_X + ')').addClass('clidxboost-td-niche-show');
		if (size_li_actives_X == size_li) {
		  $('#clidxboost-container-loadMore-niche').hide();
		}
		size_li_actives = $('.clidxboost-body-niche .clidxboost-td-niche-show').length;
		var result_item=(parseInt(size_li)-parseInt(size_li_actives));
		$('.clidxboost-count-niche').text( result_item+ ' '+word_translate.more_schools );
	  });

	  $(document).on('click', '.clidxboost-niche-tab-filters button', function() {
		event.stopPropagation();

		$('#clidxboost-container-loadMore-niche').show();
		$('.clidxboost-td-niche').removeClass('clidxboost-td-niche-show');
		if ($(this).attr('data-filter')=='all') {
			size_li_actives_X=8; $('#clidxboost-data-loadMore-niche').click();
		}else if($(this).attr('data-filter')=='elementary'){
		  $('.clidxboost-td-niche.elementary').addClass('clidxboost-td-niche-show');
		  $('#clidxboost-container-loadMore-niche').hide();
		}else if($(this).attr('data-filter')=='middle'){
		  $('.clidxboost-td-niche.middle').addClass('clidxboost-td-niche-show');
		  $('#clidxboost-container-loadMore-niche').hide();
		}else if($(this).attr('data-filter')=='high'){
		  $('.clidxboost-td-niche.high').addClass('clidxboost-td-niche-show');
		  $('#clidxboost-container-loadMore-niche').hide();
		}
	  });

	  $(document).on('click', '.clidxboost-niche-tab-filters button', function() {
		event.stopPropagation();

		$('.clidxboost-niche-tab-filters button').removeClass('active');
		$(this).addClass('active');
		var $dataFilter = $(this).attr('data-filter');
		$('.clidxboost-td-niche').addClass('td-hidden');
		$('.clidxboost-body-niche .'+$dataFilter).removeClass('td-hidden');
		if ($dataFilter == 'all') {
		  $('.clidxboost-td-niche').removeClass('td-hidden');
		}
	  });

	// [END]



	$(".ib-dbsave").on("click", function() {

		jQuery(".ms-fub-register").removeClass("hidden");
		jQuery(".ms-footer-sm").addClass("hidden");

		if (jQuery('#follow_up_boss_valid_register').is(':checked')) {
			jQuery("#socialMediaRegister").removeClass("disabled");
		}else{
			jQuery("#socialMediaRegister").addClass("disabled");
		}

		if ("yes" === __flex_g_settings.anonymous) {
			// if ( (__flex_g_settings.hasOwnProperty("force_registration")) && (1 == __flex_g_settings.force_registration) ) {
			// if ($(".register").length) {
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

				// $(".register").click();
				$("button.close-modal").addClass("ib-close-mproperty");
				$(".overlay_modal").css("background-color", "rgba(0,0,0,0.8);");
			// }
			// }

			/*TEXTO REGISTER*/
			var titleText = $(".header-tab a[data-tab='tabRegister']").attr('data-text')
			$("#modal_login .modal_cm .content_md .heder_md .ms-title-modal").html(titleText);
			
			return;
		}

		$("#ib-fsearch-save-modal").addClass("ib-md-active");
	});

	/*
	$(".ib-fmsearchsuggestions").on({
		focus: function() {
			$(this).parent().addClass("ib-fhpa-minisearch-active");
		},
		blur: function() {
			// setTimeout(function () {
			//     $(".ib-fmsearchsuggestions:eq(0)").parent().removeClass("ib-fhpa-minisearch-active");
			// }, 100);
		},
		keyup: function(event) {
			$(this).parent().removeClass("ib-fhpa-minisearch-active");
			
			if ("" == $(this).val()) {
				$(this).parent().addClass("ib-fhpa-minisearch-active");
			}

			if (13 === event.keyCode) {
				IB_SEARCH_FILTER_AUTOCOMPLETE.blur();
				IB_SEARCH_FILTER_AUTOCOMPLETE.autocomplete("close");

				var inputValue = $(this).val();
				var currentValue = $.trim(inputValue.replace(/\(.*\)?/, ""));
	
				if (inputValue.length) {
					var myRegexp = /\(([^)]+)\)/;
					var match = myRegexp.exec(inputValue);
					
					if (null != match) {
						var inputType = match[1].toLowerCase();
	
						IB_SEARCH_FILTER_AUTOCOMPLETE.val(inputValue);
						IB_SEARCH_FILTER_FORM.find('[name="filter_search_keyword_label"]').val(inputValue);
						IB_SEARCH_FILTER_FORM.find('[name="filter_search_keyword_type"]').val(inputType);
						IB_SEARCH_FILTER_FORM.find('[name="polygon_search"]').val("");

						update_bounds_zoom_gmap();
					} else if (/^[\d+]{5}$/.test(currentValue)) {
						IB_SEARCH_FILTER_AUTOCOMPLETE.val(inputValue + " (Zip)");
						IB_SEARCH_FILTER_FORM.find('[name="filter_search_keyword_label"]').val(inputValue + " (Zip)");
						IB_SEARCH_FILTER_FORM.find('[name="filter_search_keyword_type"]').val('zip');
						IB_SEARCH_FILTER_FORM.find('[name="polygon_search"]').val("");

						update_bounds_zoom_gmap();
						
					} else {
						currentValue = inputValue.toLowerCase();
						var matchCity = false;
	
						for (var i = 0, l = __flex_idx_search_filter.search.cities.length; i < l; i++) {
							var currentCity = __flex_idx_search_filter.search.cities[i].name.toLowerCase();
	
							if (currentValue == currentCity) {
								matchCity = true;

								IB_SEARCH_FILTER_AUTOCOMPLETE.val(inputValue + " (City)");
								IB_SEARCH_FILTER_FORM.find('[name="filter_search_keyword_label"]').val(inputValue + " (City)");
								IB_SEARCH_FILTER_FORM.find('[name="filter_search_keyword_type"]').val('city');
								IB_SEARCH_FILTER_FORM.find('[name="polygon_search"]').val("");

								update_bounds_zoom_gmap();
								break;
							}
						}

						if (false === matchCity) {
							IB_SEARCH_FILTER_AUTOCOMPLETE.val(inputValue);
							IB_SEARCH_FILTER_FORM.find('[name="filter_search_keyword_label"]').val(inputValue);
							IB_SEARCH_FILTER_FORM.find('[name="filter_search_keyword_type"]').val('neighborhood');
							IB_SEARCH_FILTER_FORM.find('[name="polygon_search"]').val("");
							IB_SEARCH_FILTER_AUTOCOMPLETE.autocomplete("close");

							update_bounds_zoom_gmap();
						}
					}
					
					IB_SEARCH_FILTER_FORM.find('[name="page"]').val(1);
	
					// submit form
					IB_SEARCH_FILTER_FORM.trigger("submit");
				}
			}
		}
	});
	*/

	// $(document).on("click", function() {
	//     $(".ib-fmsearchsuggestions:eq(0)").parent().removeClass("ib-fhpa-minisearch-active");
	// });

	$(".ib-fcitiesnon-hide").on("click", function(event) {
		event.stopPropagation();
	});

	// Cambio de vista desde botonera
	$('.idx-bta-map').click(function(){
		// $('.ib-mobile-sview').val('map');
		// $('.ib-mobile-sview').change();

		var currentValue = "map";
		var $ibMapGridContainer = $('.ib-mapgrid-container');

		$('.ib-gwvbitem[data-view="' + currentValue + '"]')
			.addClass('ib-gv-active')
			.siblings()
			.removeClass('ib-gv-active');

		$('body').addClass('view-map').removeClass('view-grid view-list');
		$ibMapGridContainer.removeClass('ib-vgrid-active').addClass('ib-vmap-active');

		// console.log(IB_LOOKUP_DRAG);

		if (false === IB_LOOKUP_DRAG) {
			IB_MAP.fitBounds(IB_HIDDEN_BOUNDS);
		}

		// IB_MAP.fitBounds(IB_HIDDEN_BOUNDS);

		// setTimeout(function () {
		//     if (false === IB_LOOKUP_DRAG) {
		//         console.log('[fitbounds]');
		//         IB_MAP.fitBounds(IB_HIDDEN_BOUNDS);
		//     }
		// }, 100);
	});

	// cambio de vista desde botonera
	$('.idx-bta-grid').click(function(){
		// $('.ib-mobile-sview').val('grid');
		// $('.ib-mobile-sview').change();

		var currentValue = "grid";
		var $ibMapGridContainer = $('.ib-mapgrid-container');

		$('.ib-gwvbitem[data-view="' + currentValue + '"]')
			.addClass('ib-gv-active')
			.siblings()
			.removeClass('ib-gv-active');

		$('body').addClass('view-grid').removeClass('view-map view-list');
		$ibMapGridContainer.addClass('ib-vgrid-active').removeClass('ib-vmap-active');
	});

	/*
	 $(".ib-mobile-sview").on("change", function() {
		var currentValue = $(this).val();

		const $ibMapGridContainer = $('.ib-mapgrid-container');
		$('.ib-gwvbitem[data-view="' + currentValue + '"]').addClass('ib-gv-active').siblings().removeClass('ib-gv-active');

		if ("map" === currentValue) {
			$('body').addClass('view-map').removeClass('view-grid view-list');
			$ibMapGridContainer.removeClass('ib-vgrid-active').addClass('ib-vmap-active');
			setTimeout(function () {
				if (false === IB_LOOKUP_DRAG) {
					IB_MAP.fitBounds(IB_HIDDEN_BOUNDS);
				}
			}, 100);
		} else if ("grid" === currentValue) {
			$('body').addClass('view-grid').removeClass('view-map view-list');
			$ibMapGridContainer.addClass('ib-vgrid-active').removeClass('ib-vmap-active');
		}
	});
	*/

	$('.ib-gwvbitem').click(function(){
		$('.ib-gviews').val($(this).attr('data-view')).change();
	});

	if (IB_MODAL_WRAPPER.length) {
		// open property in modal from related
		IB_MODAL_WRAPPER.on("click", ".ib-rel-property", function(event) {
			event.preventDefault();

			var mlsNumber = $(this).data("mls");
			loadPropertyInModal(mlsNumber);
		});

		// handle favorite
		IB_MODAL_WRAPPER.on("click", ".ib-pfavorite", function(event) {
			if ("yes" === __flex_g_settings.anonymous) {
				// if ( (__flex_g_settings.hasOwnProperty("force_registration")) && (1 == __flex_g_settings.force_registration) ) {
					// if ($(".register").length) {
						// $(".register").click();
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

						$("button.close-modal").addClass("ib-close-mproperty");
						$(".overlay_modal").css("background-color", "rgba(0,0,0,0.8);");
					// }
				// }

				/*TEXTO LOGIN*/
				var titleText = $(".header-tab a[data-tab='tabRegister']").attr('data-text')
				$("#modal_login .modal_cm .content_md .heder_md .ms-title-modal").html(titleText);
				
				return;
			}

			var mlsNumber = $(this).data("mls");
			var tokenAlert = $(this).data("token-alert");

			if ($(this).hasClass("ib-pf-active")) { // remove
				$(this).children().html(word_translate.save);
			} else { // add
				$(this).children().html(word_translate.remove);
			}

			$(this).toggleClass("ib-pf-active");

			// save favorite from modal
			markPropertyAsFavorite(mlsNumber, event.target, "modal");
		});

		// open property detail in another tab
		IB_MODAL_WRAPPER.on("click", ".ib-pbtnopen", function() {
			var linkToOpen = $(this).data("permalink");

			window.open(linkToOpen);
		});

		// close opened modal
		IB_MODAL_WRAPPER.on("click", ".ib-pbtnclose", function() {
			IB_MODAL_WRAPPER.find(".ib-modal-master").removeClass("ib-md-active");
			IB_MODAL_WRAPPER.empty();

			// Web Share API
			// if ('share' in navigator) { // for mobile
			if (/iPhone|iPad|iPod|Android/i.test(navigator.userAgent)) {
				document.title = initial_title;
				history.pushState(null, null, initial_href);
			} else { // for  desktop
				var urlParams = new URLSearchParams(window.location.search);
				urlParams.delete("show");
	
				if ("" === urlParams.toString()) {
					history.pushState(null, null, __flex_idx_search_filter.searchFilterPermalink);
				} else {
					history.pushState(null, null, '?' + urlParams.toString());
				}
			}

			// var urlParams = new URLSearchParams(window.location.search);
			// urlParams.delete("show");

			// if ("" === urlParams.toString()) {
			//     history.pushState(null, null, __flex_idx_search_filter.searchFilterPermalink);
			// } else {
			//     history.pushState(null, null, '?' + urlParams.toString());
			// }

			// quitando fallback para safari IOS
			$('html').removeClass('ib-mpropertie-open');

			if (/webOS|iPhone|iPad/i.test(navigator.userAgent)) {
			  $('body').removeClass('only-mobile');
			}

			if (typeof originalPositionY !== "undefined") {
				// console.log('restoring to: ' + originalPositionY);
				window.scrollTo(0,originalPositionY);
			}
		});


		IB_SAVE_SEARCH_MODALS.on("submit",function(event){
			event.preventDefault();
			var search_url = encodeURIComponent(location.href);
			var search_count = IB_SEARCH_FILTER.attr("data-count");
			var search_condition = encodeURIComponent(IB_SEARCH_FILTER.attr("data-condition"));
			var search_filter_params = IB_SEARCH_FILTER.attr("data-params");
			var search_filter_ID = IB_SEARCH_FILTER.data("filter-id");
			var formData = $(this).serialize();
			formData=formData+'&search_url='+search_url+'&search_count='+search_count+'&search_condition='+search_condition+'&search_filter_params='+JSON.stringify(dataAlert.params)+'&search_filter_ID='+search_filter_ID;

			var search_filter_ID = IB_SEARCH_FILTER.data("filter-id");
			if ("no" === __flex_g_settings.anonymous) {
				$.ajax({
					type: "POST",
					url: __flex_idx_search_filter.ajaxUrl,
					data: formData,
					dataType: "json",                    
					success: function(response) {
						if (response.success != false){
						 swal({
							 title: word_translate.search_saved,
							 text: word_translate.your_search_has_been_saved_successfuly,
							 type: "success",
							   timer: 2000,
							   showConfirmButton: false
						 });
						 $("#ib-fsearch-save-modal").removeClass("ib-md-active");
						 $('.ib-mssinput').val('');
						}else{
							sweetAlert("Oops...", response.message, "error");
						}

						if (jQuery("#_ib_lead_activity_tab").length) {
							jQuery("#_ib_lead_activity_tab button:eq(2)").click();
						}
					}
				});
			}
		});

		// IB_SAVE_SEARCH_MODALS.find('.ib-mgsubmit').click(function(){ IB_SAVE_SEARCH_MODALS.submit(); });

		$(document).on("click", ".ib-plsifb", function(event) {
			event.preventDefault();

			var shareURL = "https://www.facebook.com/sharer/sharer.php?"; //url base

			//params
			var params = {
				u: $(this).attr("href")
			};
  
			for(var prop in params) {
				shareURL += '&' + prop + '=' + encodeURIComponent(params[prop]);
			}

			var wo = window.open(shareURL, '', 'left=0,top=0,width=550,height=450,personalbar=0,toolbar=0,scrollbars=0,resizable=0');

			if (wo.focus) {
				wo.focus();
			}
		});

		// share on twitter
		$(document).on("click", ".ib-plsitw", function(event) {
			event.preventDefault();

            var buildTextShare = [];
            var propertyRental = (1 == $(this).data("rental")) ? "Rent " : "Sale ";

            buildTextShare.push($(this).data("type"));

            buildTextShare.push(" for " + propertyRental );
            buildTextShare.push($(this).data("price"));
            buildTextShare.push(" #" + $(this).data("mls") );
            buildTextShare.push(" in ");
            buildTextShare.push($(this).data("address") + " ");

            //params
            var params = {
              url: $(this).attr("href"), 
              text: buildTextShare.join("")
            }

            for(var prop in params) {
                shareURL += '&' + prop + '=' + encodeURIComponent(params[prop]);
            }

            var wo = window.open(shareURL, '', 'left=0,top=0,width=550,height=450,personalbar=0,toolbar=0,scrollbars=0,resizable=0');

            if (wo.focus) {
                wo.focus();
            }
        });

        // open mortgage calculator
        IB_MODAL_WRAPPER.on("click", ".ib-pscalculator", function() {
            var pp = $(this).data("price").replace(/[^\d]/g, "");

            $(".ib-property-mortgage-f:eq(0)").trigger("reset");

            $("#calculatorYears").text(30+" "+word_translate.years);
            $(".ib-property-mc-ir, #interest_rate_txt").val(__flex_g_settings.interes_rate[30]);

            var dp = $(".ib-property-mc-dp:eq(0)").val();
            var ty = $(".ib-property-mc-ty:eq(0)").val();
            var ir = $(".ib-property-mc-ir:eq(0)").val();

            // update form
            $(".ib-property-mc-pp").val("$" + _.formatPrice(pp));

            var calc_mg = calculate_mortgage(pp, dp, ty, ir);

            $(".ib-calc-mc-mortgage").html("$" + calc_mg.mortgage);
            $(".ib-calc-mc-down-payment").html("$" + calc_mg.down_payment);
            $(".ib-calc-mc-monthly").html("$" + calc_mg.monthly);
            $(".ib-calc-mc-totalmonthly").html("$" + calc_mg.total_monthly);

            $("#ib-mortage-calculator").addClass("ib-md-active");
        });

        $(".ib-property-mortage-submit").on("click", function() {
            var pp = $(".ib-property-mc-pp:eq(0)").val();
            var dp = $(".ib-property-mc-dp:eq(0)").val();
            var ty = $(".ib-property-mc-ty:eq(0)").val();
            var ir = $(".ib-property-mc-ir:eq(0)").val();

            var calc_mg = calculate_mortgage(pp, dp, ty, ir);

            $(".ib-calc-mc-mortgage").html("$" + calc_mg.mortgage);
            $(".ib-calc-mc-down-payment").html("$" + calc_mg.down_payment);
            $(".ib-calc-mc-monthly").html("$" + calc_mg.monthly);
            $(".ib-calc-mc-totalmonthly").html("$" + calc_mg.total_monthly);
            $(".ib-price-calculator").text("$" + calc_mg.monthly+"/mo");
        });

				// open email to a friend modal
				$(document).on("click", ".ib-psemailfriend", function() {
					var mlsNumber = $(this).data("mls");
					var propertyStatus = $(this).data("status");

					$(".ib-property-share-friend-f:eq(0)").trigger("reset");
					$(".ib-property-share-mls-num:eq(0)").val(mlsNumber);
					$(".ib-property-share-property-status:eq(0)").val(propertyStatus);

					$("#ib-email-to-friend").addClass("ib-md-active");
					
					var fn = (typeof Cookies.get("_ib_user_firstname") !== "undefined") ? Cookies.get("_ib_user_firstname") : "";
					var ln = (typeof Cookies.get("_ib_user_lastname") !== "undefined") ? Cookies.get("_ib_user_lastname") : "";
					var em = (typeof Cookies.get("_ib_user_email") !== "undefined") ? Cookies.get("_ib_user_email") : "";
					
					if (fn.lenght || ln.length) {
						$("#_sf_name").val(fn + " " + ln);
					}
					
					$("#_sf_email").val(em);

					/*var urlSite = window.location.hostname;
					var imgProp = $(".ib-pvphotos.ib-pvlitem .gs-item-slider:first-child .gs-wrapper-content").html();
					var itemPrice = $(".ib-pwinfo .ib-pilprice .ib-pipn").html();
					var itemBeds = $(".ib-pilbeds .ib-pilnumber").html();
					var itemBaths = $(".ib-pilbaths .ib-pilnumber").html();
					var itemSqft = $(".ib-pilsize .ib-pilnumber").html();
					var itemAddress = itemAddress = $(".ib-property-detail .ib-ptitle").html()+", "+$(".ib-property-detail .ib-pstitle").html();
					var itemComment = $("#ms-friend-comments").attr("data-comment")+" "+urlSite+": "+itemAddress;

					var itemLg = $(this).attr("data-lg");
					var itemLt = $(this).attr("data-lt");

					if(imgProp === undefined){
						var myLatLng  = {
							lat: parseFloat(itemLt),
							lng: parseFloat(itemLg)
						};
						var map = new google.maps.Map(document.getElementById('mfImg'), {
							zoom: 18,
							center: myLatLng,
							styles: style_map,
							gestureHandling: 'cooperative',
							panControl: false,
							scrollwheel: false,
							disableDoubleClickZoom: true,
							disableDefaultUI: true,
							streetViewControl: true,
						});
						var marker = new google.maps.Marker({
							position: myLatLng,
							map: map
						});

					}else if(imgProp !== ""){
						$("#mfImg").html(imgProp);
					}

					$("#mfPrice").html(itemPrice);
					$("#mfBed").html(itemBeds);
					$("#mfBath").html(itemBaths);
					$("#mfSqft").html(itemSqft);
					$("#mfAddress").html(itemAddress);
					$("#ms-friend-comments").val(itemComment);*/
				});

        $(".ib-property-share-friend-f").on("submit", function(event) {
            event.preventDefault();

            var _self = $(this);

            if (__flex_g_settings.hasOwnProperty("has_enterprise_recaptcha")) { // enterprise recaptcha
                if ("1" == __flex_g_settings.has_enterprise_recaptcha) {
                    // pending...
                } else { // regular recaptcha
                    grecaptcha.ready(function() {
                        grecaptcha
                        .execute(__flex_g_settings.google_recaptcha_public_key, { action: 'share_property_with_friend' })
                        .then(function(token) {
                            _self.prepend('<input type="hidden" name="recaptcha_response" value="'+token+'">');
            
                            var formData = _self.serialize();
                            var mlsNumber = _self.find("input[name='mls_number']:eq(0)").val();
                            var shareWithFriendEndpoint = __flex_idx_search_filter.shareWithFriendEndpoint.replace(/{{mlsNumber}}/g, mlsNumber);
                
                            $.ajax({
                                type: "POST",
                                url: shareWithFriendEndpoint,
                                data: {
                                    access_token: IB_ACCESS_TOKEN,
                                    flex_credentials: Cookies.get("ib_lead_token"),
                                    form_data: formData
                                },
                                success: function(response) {
                                    // ...
                                }
                            });
                
                            $("#ib-email-to-friend").removeClass("ib-md-active");
                            $("#ib-email-thankyou").addClass("ib-md-active");
                        });
                    });
                }
            } else { // regular recaptcha
                grecaptcha.ready(function() {
                    grecaptcha
                    .execute(__flex_g_settings.google_recaptcha_public_key, { action: 'share_property_with_friend' })
                    .then(function(token) {
                        _self.prepend('<input type="hidden" name="recaptcha_response" value="'+token+'">');
        
                        var formData = _self.serialize();
                        var mlsNumber = _self.find("input[name='mls_number']:eq(0)").val();
                        var shareWithFriendEndpoint = __flex_idx_search_filter.shareWithFriendEndpoint.replace(/{{mlsNumber}}/g, mlsNumber);
            
                        $.ajax({
                            type: "POST",
                            url: shareWithFriendEndpoint,
                            data: {
                                access_token: IB_ACCESS_TOKEN,
                                flex_credentials: Cookies.get("ib_lead_token"),
                                form_data: formData
                            },
                            success: function(response) {
                                // ...
                            }
                        });
            
                        $("#ib-email-to-friend").removeClass("ib-md-active");
                        $("#ib-email-thankyou").addClass("ib-md-active");
                    });
                });
            }

            // var formData = $(this).serialize();
            // var mlsNumber = $(this).find("input[name='mls_number']:eq(0)").val();
            // var shareWithFriendEndpoint = __flex_idx_search_filter.shareWithFriendEndpoint.replace(/{{mlsNumber}}/g, mlsNumber);

            // $.ajax({
            //     type: "POST",
            //     url: shareWithFriendEndpoint,
            //     data: {
            //         access_token: IB_ACCESS_TOKEN,
            //         flex_credentials: Cookies.get("ib_lead_token"),
            //         // url_origin: location.origin,
            //         // url_referer: document.referrer,
            //         // user_agent: navigator.userAgent,
            //         form_data: formData
            //     },
            //     success: function(response) {
            //         // ...
            //     }
            // });

            // $("#ib-email-to-friend").removeClass("ib-md-active");
            // $("#ib-email-thankyou").addClass("ib-md-active");
        });

        // print screen
        IB_MODAL_WRAPPER.on("click", ".ib-psprint", function() {
            var $printMsg = $('#printMessageBox');
            var $propertyDetail = $(".ib-property-detail:eq(0)");

            $printMsg.fadeIn();

            $propertyDetail.addClass('ib-phw-print').printArea({
                onClose: function () {
                    $printMsg.fadeOut('fast');
                    $propertyDetail.removeClass('ib-phw-print');
                }
            });
        });

        // handle share property
        IB_MODAL_WRAPPER.on("submit", ".ib-propery-inquiry-f", function(event) {
            event.preventDefault();

            var formData = $(this).serialize();

            var mlsNumber = $(this).find("input[name='mls_number']:eq(0)").val();
            var requestInformationEndpoint = __flex_idx_search_filter.requestInformationEndpoint.replace(/{{mlsNumber}}/g, mlsNumber);

            $.ajax({
                type: "POST",
                url: requestInformationEndpoint,
                data: {
                    access_token: IB_ACCESS_TOKEN,
                    flex_credentials: Cookies.get("ib_lead_token"),
                    form_data: formData
                },
                success: function(response) {
                    // ...
                }
            });

            // $(".ib-propery-inquiry-f:eq(0)").trigger("reset");
            $("#ib-email-thankyou").addClass("ib-md-active");
            $(document).on("click", "#ib-email-thankyou .ib-mmclose", function(event) {
              event.preventDefault();
              $("#ib-email-thankyou").removeClass("ib-md-active");
            });
        });

        // handle slider switch fullscreen
        IB_MODAL_WRAPPER.on("click", ".ib-btnfs", function() {
            if (typeof IB_MODAL_SLIDER !== "undefined") {
                IB_MODAL_SLIDER.fullscreen('in');
            }
        });
        
        // handle accordion
        IB_MODAL_WRAPPER.on("click", ".ib-paitem", function(event) {
            if (!$(event.target).hasClass("ib-paititle")) {
                return;
            }

            $(this).toggleClass("ib-pai-active");
        });

        // handle switch photos, map view, video
        IB_MODAL_WRAPPER.on("click", ".ib-pvitem", function(event) {
            var tabToOpen = $(this).data("id");

            if ($(this).hasClass("ib-pvi-active") || ("video" == tabToOpen)  ) {
                return;
            }

            $(this).parent().find(">li").removeClass("ib-pvi-active");
            $(this).addClass("ib-pvi-active");

            $(this).parent().parent().parent().removeClass('ib-pva-photos ib-pva-map').addClass('ib-pva-' + tabToOpen);

            switch(tabToOpen) {
                case "map":
                    var lat = $(this).data("lat");
                    var lng = $(this).data("lng");
                    var loaded = $(this).data("loaded");

                    if ("no" === loaded) {
                        var myLatLng = { lat: parseFloat(lat), lng: parseFloat(lng) };

                        var map = new google.maps.Map(IB_MODAL_WRAPPER.find(".ib-pmap")[0], {
													zoom: 18,
													center: myLatLng,
													styles: style_map,
													gestureHandling: 'cooperative',
													panControl: false,
													scrollwheel: false,
													disableDoubleClickZoom: true,
													disableDefaultUI: true,
													streetViewControl: true,
												});
								
												var marker = new google.maps.Marker({
													position: myLatLng,
													map: map
												});

						google.maps.event.addListenerOnce(map, 'tilesloaded', setupMapControls);

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
                    }

                    break;
            }
        });
    // }

		// share on twitter
		/*
		IB_MODAL_WRAPPER.on("click", ".ib-plsitw", function(event) {
			event.preventDefault();

			var shareURL = "http://twitter.com/share?"; 

			var buildTextShare = [];
			var propertyRental = (1 == $(this).data("rental")) ? "Rent " : "Sale ";

			buildTextShare.push($(this).data("type"));

			buildTextShare.push(" for " + propertyRental );
			buildTextShare.push($(this).data("price"));
			buildTextShare.push(" #" + $(this).data("mls") );
			buildTextShare.push(" in ");
			buildTextShare.push($(this).data("address") + " ");

			//params
			var params = {
			  url: $(this).attr("href"), 
			  text: buildTextShare.join("")
			}

			for(var prop in params) {
				shareURL += '&' + prop + '=' + encodeURIComponent(params[prop]);
			}

			var wo = window.open(shareURL, '', 'left=0,top=0,width=550,height=450,personalbar=0,toolbar=0,scrollbars=0,resizable=0');

			if (wo.focus) {
				wo.focus();
			}
		});

		// open mortgage calculator
		IB_MODAL_WRAPPER.on("click", ".ib-pscalculator", function() {
			var pp = $(this).data("price").replace(/[^\d]/g, "");

			$(".ib-property-mortgage-f:eq(0)").trigger("reset");

			var dp = $(".ib-property-mc-dp:eq(0)").val();
			var ty = $(".ib-property-mc-ty:eq(0)").val();
			var ir = $(".ib-property-mc-ir:eq(0)").val();

			// update form
			$(".ib-property-mc-pp").val("$" + _.formatPrice(pp));

			var calc_mg = calculate_mortgage(pp, dp, ty, ir);

			$(".ib-calc-mc-mortgage").html("$" + calc_mg.mortgage);
			$(".ib-calc-mc-down-payment").html("$" + calc_mg.down_payment);
			$(".ib-calc-mc-monthly").html("$" + calc_mg.monthly);
			$(".ib-calc-mc-totalmonthly").html("$" + calc_mg.total_monthly);

			$("#ib-mortage-calculator").addClass("ib-md-active");
		});

		$(".ib-property-mortage-submit").on("click", function() {
			var pp = $(".ib-property-mc-pp:eq(0)").val();
			var dp = $(".ib-property-mc-dp:eq(0)").val();
			var ty = $(".ib-property-mc-ty:eq(0)").val();
			var ir = $(".ib-property-mc-ir:eq(0)").val();

			var calc_mg = calculate_mortgage(pp, dp, ty, ir);

			$(".ib-calc-mc-mortgage").html("$" + calc_mg.mortgage);
			$(".ib-calc-mc-down-payment").html("$" + calc_mg.down_payment);
			$(".ib-calc-mc-monthly").html("$" + calc_mg.monthly);
			$(".ib-calc-mc-totalmonthly").html("$" + calc_mg.total_monthly);
		});

		// open email to a friend modal
		IB_MODAL_WRAPPER.on("click", ".ib-psemailfriend", function() {
			var mlsNumber = $(this).data("mls");
			var propertyStatus = $(this).data("status");

			$(".ib-property-share-friend-f:eq(0)").trigger("reset");
			$(".ib-property-share-mls-num:eq(0)").val(mlsNumber);
			$(".ib-property-share-property-status:eq(0)").val(propertyStatus);

			$("#ib-email-to-friend").addClass("ib-md-active");

			var fn = (typeof Cookies.get("_ib_user_firstname") !== "undefined") ? Cookies.get("_ib_user_firstname") : "";
			var ln = (typeof Cookies.get("_ib_user_lastname") !== "undefined") ? Cookies.get("_ib_user_lastname") : "";
			var em = (typeof Cookies.get("_ib_user_email") !== "undefined") ? Cookies.get("_ib_user_email") : "";

			$("#_sf_name").val(fn + " " + ln);
			$("#_sf_email").val(em);
		});

		$(".ib-property-share-friend-f").on("submit", function(event) {
			event.preventDefault();

			var formData = $(this).serialize();
			var mlsNumber = $(this).find("input[name='mls_number']:eq(0)").val();
			var shareWithFriendEndpoint = __flex_idx_search_filter.shareWithFriendEndpoint.replace(/{{mlsNumber}}/g, mlsNumber);

			$.ajax({
				type: "POST",
				url: shareWithFriendEndpoint,
				data: {
					access_token: IB_ACCESS_TOKEN,
					flex_credentials: Cookies.get("ib_lead_token"),
					// url_origin: location.origin,
					// url_referer: document.referrer,
					// user_agent: navigator.userAgent,
					form_data: formData
				},
				success: function(response) {
					// ...
				}
			});

			$("#ib-email-to-friend").removeClass("ib-md-active");
			$("#ib-email-thankyou").addClass("ib-md-active");
		});

		// print screen
		IB_MODAL_WRAPPER.on("click", ".ib-psprint", function() {
			var $printMsg = $('#printMessageBox');
			var $propertyDetail = $(".ib-property-detail:eq(0)");

			$printMsg.fadeIn();

			$propertyDetail.addClass('ib-phw-print').printArea({
				onClose: function () {
					$printMsg.fadeOut('fast');
					$propertyDetail.removeClass('ib-phw-print');
				}
			});
		});

		// handle share property
		IB_MODAL_WRAPPER.on("submit", ".ib-propery-inquiry-f", function(event) {
			event.preventDefault();

			var formData = $(this).serialize();

			var mlsNumber = $(this).find("input[name='mls_number']:eq(0)").val();
			var requestInformationEndpoint = __flex_idx_search_filter.requestInformationEndpoint.replace(/{{mlsNumber}}/g, mlsNumber);

			$.ajax({
				type: "POST",
				url: requestInformationEndpoint,
				data: {
					access_token: IB_ACCESS_TOKEN,
					flex_credentials: Cookies.get("ib_lead_token"),
					form_data: formData
				},
				success: function(response) {
					// ...
				}
			});

			// $(".ib-propery-inquiry-f:eq(0)").trigger("reset");
			$("#ib-email-thankyou").addClass("ib-md-active");
			$(document).on("click", "#ib-email-thankyou .ib-mmclose", function(event) {
			  event.preventDefault();
			  $("#ib-email-thankyou").removeClass("ib-md-active");
			});
		});

		// handle slider switch fullscreen
		IB_MODAL_WRAPPER.on("click", ".ib-btnfs", function() {
			if (typeof IB_MODAL_SLIDER !== "undefined") {
				IB_MODAL_SLIDER.fullscreen('in');
			}
		});
		
		// handle accordion
		IB_MODAL_WRAPPER.on("click", ".ib-paitem", function(event) {
			if (!$(event.target).hasClass("ib-paititle")) {
				return;
			}

			$(this).toggleClass("ib-pai-active");
		});

		// handle switch photos, map view, video
		IB_MODAL_WRAPPER.on("click", ".ib-pvitem", function(event) {
			var tabToOpen = $(this).data("id");

			if ($(this).hasClass("ib-pvi-active") || ("video" == tabToOpen)  ) {
				return;
			}

			$(this).parent().find(">li").removeClass("ib-pvi-active");
			$(this).addClass("ib-pvi-active");

			$(this).parent().parent().parent().removeClass('ib-pva-photos ib-pva-map').addClass('ib-pva-' + tabToOpen);

			switch(tabToOpen) {
				case "map":
					var lat = $(this).data("lat");
					var lng = $(this).data("lng");
					var loaded = $(this).data("loaded");

					if ("no" === loaded) {
						var myLatLng = { lat: parseFloat(lat), lng: parseFloat(lng) };

						var map = new google.maps.Map(IB_MODAL_WRAPPER.find(".ib-pmap")[0], {
							zoom: 18,
							center: myLatLng,
							styles: style_map,
							gestureHandling: 'cooperative',
							panControl: false,
							scrollwheel: false,
							disableDoubleClickZoom: true,
							disableDefaultUI: true,
							streetViewControl: true,
						});
		
						var marker = new google.maps.Marker({
							position: myLatLng,
							map: map
						});

						google.maps.event.addListenerOnce(map, 'tilesloaded', setupMapControls);

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
					}

					break;
			}
		});
	}

	// if (IB_KW_TG_SEARCH.length) {
		// IB_KW_TG_SEARCH.on("click", function() {
			var inputValue = $(this).prev().val();
			var currentValue = $.trim(inputValue.replace(/\(.*\)?/, ""));

			IB_SEARCH_FILTER_AUTOCOMPLETE.blur();
			IB_SEARCH_FILTER_AUTOCOMPLETE.autocomplete("close");

			if (inputValue.length) {
				var myRegexp = /\(([^)]+)\)/;
				var match = myRegexp.exec(inputValue);
				
				if (null != match) {
					var inputType = match[1].toLowerCase();

					IB_SEARCH_FILTER_AUTOCOMPLETE.val(inputValue);
					IB_SEARCH_FILTER_FORM.find('[name="filter_search_keyword_label"]').val(inputValue);
					IB_SEARCH_FILTER_FORM.find('[name="filter_search_keyword_type"]').val(inputType);
					IB_SEARCH_FILTER_FORM.find('[name="polygon_search"]').val("");
				} else if (/^[\d+]{5}$/.test(currentValue)) {
					IB_SEARCH_FILTER_AUTOCOMPLETE.val(inputValue + " (Zip)");
					IB_SEARCH_FILTER_FORM.find('[name="filter_search_keyword_label"]').val(inputValue + " (Zip)");
					IB_SEARCH_FILTER_FORM.find('[name="filter_search_keyword_type"]').val('zip');
					IB_SEARCH_FILTER_FORM.find('[name="polygon_search"]').val("");
				} else {
					currentValue = inputValue.toLowerCase();
					var matchCity = false;

					for (var i = 0, l = __flex_idx_search_filter.search.cities.length; i < l; i++) {
						var currentCity = __flex_idx_search_filter.search.cities[i].name.toLowerCase();

						if (currentValue == currentCity) {
							matchCity = true;
							
							IB_SEARCH_FILTER_AUTOCOMPLETE.val(inputValue + " (City)");
							IB_SEARCH_FILTER_FORM.find('[name="filter_search_keyword_label"]').val(inputValue + " (City)");
							IB_SEARCH_FILTER_FORM.find('[name="filter_search_keyword_type"]').val('city');
							IB_SEARCH_FILTER_FORM.find('[name="polygon_search"]').val("");
							break;
						}
					}

					if (false === matchCity) {
						IB_SEARCH_FILTER_AUTOCOMPLETE.val(inputValue);
						IB_SEARCH_FILTER_FORM.find('[name="filter_search_keyword_label"]').val(inputValue);
						IB_SEARCH_FILTER_FORM.find('[name="filter_search_keyword_type"]').val('neighborhood');
						IB_SEARCH_FILTER_FORM.find('[name="polygon_search"]').val("");
						IB_SEARCH_FILTER_AUTOCOMPLETE.autocomplete("close");
					}
				}
				
				IB_SEARCH_FILTER_FORM.find('[name="page"]').val(1);

				// submit form
				IB_SEARCH_FILTER_FORM.trigger("submit");
			}
		//});
	//}
	*/

	// if (IB_MAP_TOOLTIP.length) {
	//     $(document).on("mousemove", ib_handle_tooltip_map);
	// }

	if (IB_RENTAL_TYPE.length) {
		IB_RENTAL_TYPE.on("click", "div", function(event) {
			IB_RENTAL_TYPE.find("div").removeClass("ib-fifor-active");

			var node = event.target;
			var rentalType = node.getAttribute("data-type");

			switch (rentalType) {
				case "rent":
					$(".ib-price-range-wrap").hide();
					$(".ib-price-range-wrap-rent").show();
					IB_RENTAL_TYPE.find("div:eq(1)").addClass("ib-fifor-active");
					IB_SEARCH_FILTER_FORM.find('[name="sale_type"]').val("1");
				break;
				case "sale":
					$(".ib-price-range-wrap").hide();
					$(".ib-price-range-wrap-sale").show();
					IB_RENTAL_TYPE.find("div:eq(0)").addClass("ib-fifor-active");
					IB_SEARCH_FILTER_FORM.find('[name="sale_type"]').val("0");
				break;
			}

			node.classList.add('ib-fifor-active');

			IB_SEARCH_FILTER_FORM.find('[name="page"]').val(1);
			// submit form
			IB_SEARCH_FILTER_FORM.trigger("submit");
		});
	}


	// handle hide pending contingent
	$("#pendingContigentMin").on("change", function() {
		var _checked = $(this).prop('checked');
		$("#pendingContigent").prop("checked", _checked);
		$("#pendingContigentMobile").prop("checked", _checked);

		if (_checked) {
			IB_SEARCH_FILTER_FORM.find('[name="overwrite_show_hide_pending"]').val("yes");
		} else {
			IB_SEARCH_FILTER_FORM.find('[name="overwrite_show_hide_pending"]').val("no");
		}

		IB_SEARCH_FILTER_FORM.find('[name="page"]').val(1);
		IB_SEARCH_FILTER_FORM.trigger("submit");
	});

	$("#pendingContigent").on("change", function() {
		var _checked = $(this).prop('checked');
		$("#pendingContigentMin").prop("checked", _checked);
		$("#pendingContigentMobile").prop("checked", _checked);

		if (_checked) {
			IB_SEARCH_FILTER_FORM.find('[name="overwrite_show_hide_pending"]').val("yes");
		} else {
			IB_SEARCH_FILTER_FORM.find('[name="overwrite_show_hide_pending"]').val("no");
		}

		IB_SEARCH_FILTER_FORM.find('[name="page"]').val(1);
		IB_SEARCH_FILTER_FORM.trigger("submit");
	});

	$("#pendingContigentMobile").on("change", function() {
		var _checked = $(this).prop('checked');
		$("#pendingContigent").prop("checked", _checked);
		$("#pendingContigentMin").prop("checked", _checked);

		if (_checked) {
			IB_SEARCH_FILTER_FORM.find('[name="overwrite_show_hide_pending"]').val("yes");
		} else {
			IB_SEARCH_FILTER_FORM.find('[name="overwrite_show_hide_pending"]').val("no");
		}

		IB_SEARCH_FILTER_FORM.find('[name="page"]').val(1);
		IB_SEARCH_FILTER_FORM.trigger("submit");
	});
	

	if (IB_CLEAR_BTN.length) {
		IB_CLEAR_BTN.on("click", function() {
			location.href = __flex_idx_search_filter.searchFilterPermalink;
		});
	}
	

	/*
	if (IB_SEARCH_FILTER_AUTOCOMPLETE.length) {
		/*
		IB_SEARCH_FILTER_AUTOCOMPLETE.autocomplete({
			source: function(request, response) {
				$.ajax({
					url: __flex_idx_search_filter.lookupAutocomplete,
					dataType: "json",
					cache: false,
					data: {
						term: request.term,
						board: __flex_idx_search_filter.boardId
						// fields: __flex_idx_search_filter.fields
					},
					success: function(data) {
						response(data);
					}
				});
			},
			minLength: 3,
			select: function(event, ui) {
				event.preventDefault();

				// @todo
				//IB_GMAP_INIT = false;

				IB_SEARCH_FILTER_AUTOCOMPLETE.val(ui.item.term);
				IB_SEARCH_FILTER_FORM.find('[name="filter_search_keyword_label"]').val(ui.item.term);
				IB_SEARCH_FILTER_FORM.find('[name="filter_search_keyword_type"]').val(ui.item.field);

				IB_SEARCH_FILTER_AUTOCOMPLETE.blur();
				IB_SEARCH_FILTER_AUTOCOMPLETE.autocomplete("close");

				update_bounds_zoom_gmap();

				IB_SEARCH_FILTER_FORM.find('[name="page"]').val(1);
				IB_SEARCH_FILTER_FORM.find('[name="polygon_search"]').val("");
				// submit form
				IB_SEARCH_FILTER_FORM.trigger("submit");
			},
			change: function(event, ui) {
				if ("" === this.value) {
					IB_SEARCH_FILTER_FORM.find('[name="filter_search_keyword_label"]').val("");
					IB_SEARCH_FILTER_FORM.find('[name="filter_search_keyword_type"]').val("");
					IB_SEARCH_FILTER_AUTOCOMPLETE.val("");

					IB_SEARCH_FILTER_FORM.find('[name="page"]').val(1);
					// submit form
					IB_SEARCH_FILTER_FORM.trigger("submit");
				}
			}
		});
	}
	*/

	if (IB_SEARCH_FILTER_FORM.length) {
		IB_SEARCH_FILTER_FORM.on("submit", handleFilterSearchLookup);

		handleFilterSearchLookup();
		// init request [xhr]
	}
}
});
})(jQuery);

(function ($) {
	// formula para sacar las imágenes del MLS
	function getGallery(mls, counter, start) {
		var cdn = "https://retsimages.s3.amazonaws.com";
		var folder = mls.substring((mls.length) - 2);
		var list = [];
		var img = "";
		var newStart;

		(start == undefined) ? newStart = 1 : newStart = start;

		for(var i = newStart; i <= counter; i++) {
			img = cdn+'/'+folder+'/'+mls+'_'+i+'.jpg';
			list.push(img);
		}

		return list;
	}

	let $filterMobile = $('.ib-fmobile'),
		$ibAdvanced = $('.ib-oadbanced'),
		$btnOpeners = $('.ib-fhpb-openers'),
		$ibFilterContainer = $('.ib-filter-container'),
		$ibMatchingbtn = $('.ib-fdmatching');
	
	//Filters mobile
	if ($filterMobile.length) {
		$filterMobile.on('click', '.ib-fititle', function(){
			let $fItem = $(this).parent();
			if($fItem.hasClass('ib-fitem-active')) {
				$fItem.removeClass('ib-fitem-active');
			} else {
				$fItem.addClass('ib-fitem-active').siblings().removeClass('ib-fitem-active');
			}
		});
	}

	// Header Filters
	if($ibAdvanced.length) {
		$ibAdvanced.on('click', function(){
			if (window.innerWidth < 990) {
				// ***************
				if(Object.keys(ib_moreFilter).length <= 0) {
					$('#flex_idx_search_filter_form').find('input:hidden').each(function() {
						moreFilterHidden[($(this).attr("name"))] = $(this).val();
					});
					var flex_filter_form = $('.ib-wrap-collapse');
					$(flex_filter_form).find('input:radio, input:checkbox, select').each(function () {
						var ID = $(this).attr("id");
						var valor = $(this).val();
						if ($.inArray($(this).attr("type"), ['checkbox', 'radio']) !== -1) {
							if ($(this).is(':checked')) {
								ib_moreFilter[ID] = valor;
							}
						} else if (valor != '--' && valor != "") {
							ib_moreFilter[ID] = valor;
						}
					});
				}
				// ***************
				$(".ib-modal-filters-mobile").show();
				if (/webOS|iPhone|iPad/i.test(navigator.userAgent)) {
				  $('body').addClass('only-mobile');
				}
			}
			
			/*
			if($filterMobile.hasClass('ib-fmobile-active')) {
				$ibAdvanced.removeClass('ib-badvanced-active');
				$filterMobile.removeClass('ib-fmobile-active');
				if ($('body').width() < 990) $ibFilterContainer.removeClass('ib-filter-container-fixed');
			} else {
				$ibAdvanced.addClass('ib-badvanced-active');
				$filterMobile.addClass('ib-fmobile-active');
				if ($('body').width() < 990) $ibFilterContainer.addClass('ib-filter-container-fixed');
			}
			*/
		});

		// hide more filter [mobile]
		$(".ib-close-modal-filters-mobile").on("click", function() {
			$(".ib-modal-filters-mobile").hide();
			if (/webOS|iPhone|iPad/i.test(navigator.userAgent)) {
			  $('body').removeClass('only-mobile');
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

		// refresh page
		$("#ib-apply-clear").on("click", function() {
			if( /Android|webOS|iPhone|iPad|iPod|Opera Mini/i.test(navigator.userAgent) ) {
				$('.ib-item-collapse-sale').show();
				$('.ib-item-collapse-rent').hide();
				IB_SEARCH_FILTER_FORM = $("#flex_idx_search_filter_form");
				$.each( moreFilterHidden, function( name, value){
					if((name == 'min_rent_price' || name == 'max_rent_price' ) && parseInt(value) > 0){
						$('.ib-item-collapse-sale').hide();
						$('.ib-item-collapse-rent').show();
					}
					IB_SEARCH_FILTER_FORM.find('[name="'+name+'"]').val(value);
				});

				var flex_filter_form = $('.ib-wrap-collapse');
				$(flex_filter_form).find('input:radio, input:checkbox, select').each(function() {
					var ID = $(this).attr("id");
					if($.inArray( $(this).attr("type"), ['checkbox', 'radio']) !== -1) {
						$(this).prop('checked', ((ib_moreFilter[ID] != undefined )? true : false));
					} else {
						if(ib_moreFilter[ID] != undefined ) {
							$(this).attr('value', ib_moreFilter[ID]).attr('selected', 'selected');
						} else {
							$(this).prop('selectedIndex', 0);
						}
					}
				});
				setTimeout(function () { $("#flex_idx_search_filter_form").trigger("submit"); }, 250);
			} else {
				location.href = __flex_idx_search_filter.searchFilterPermalink;
			}

			// window.scrollTo(0,0);
			// location.href = __flex_idx_search_filter_v2.searchFilterPermalink;
		});

		// hide more filter [mobile]
		$("#ib-apply-filters-btn").on("click", function() {
			$(".ib-modal-filters-mobile").hide();
			window.scrollTo(0,0);
			if (/webOS|iPhone|iPad/i.test(navigator.userAgent)) {
			  $('body').removeClass('only-mobile');
			}
		});
	}

	// Openers
	if ($btnOpeners.length) {
		$btnOpeners.find('.ib-oiwrapper').on('click', function(){
			let $parent = $(this).parent();
			if ($parent.hasClass('ib-oitem-active')) {
				$parent.removeClass('ib-oitem-active');
			} else {
				$parent.addClass('ib-oitem-active').siblings().removeClass('ib-oitem-active');
				if(!$parent.hasClass('ib-oadbanced')) $filterMobile.removeClass('ib-fmobile-active');
			}
		});
	}

	// Builder galery
	$(".ib-listings-ct:eq(0)").on("click", ".gs-next-arrow, .gs-prev-arrow", function () {
		// Open Registration popup after 3 property pictures are showed [force registration]
		if ("yes" === __flex_g_settings.anonymous) {
			if ( (__flex_g_settings.hasOwnProperty("force_registration")) && (1 == __flex_g_settings.force_registration) ) {
				countClickAnonymous++;
		
				if (countClickAnonymous >= 3) {
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

		var $wSlider = $(this).parents('.ib-pislider');

		if (!$wSlider.hasClass('gs-builded')) {
			$wSlider.find('.ib-pifimg').removeClass('ib-pifimg');
			$wSlider.find('.gs-container-navs').remove();
			$wSlider.greatSlider({
				type: 'fade',
				nav: true,
				bullets: false,
				autoHeight: false,
				lazyLoad: true,
				startPosition: 2,
				layout: {
					arrowDefaultStyles: false
				},
				onLoadedItem: function(item, index, response) {
					if ("success" != response) {
						setTimeout(function () {
							item.attr("src", "https://www.idxboost.com/i/default_thumbnail.jpg");
						}, 2000);
					}
				}
			});
		}

		// var $wSlider = $(this).parents('.ib-pislider');

		// if (!$wSlider.hasClass('gs-builded')) {
		//     var $newImages = '',
		//         $mlsCode = $wSlider.attr('data-mls'),
		//         $imgCnt = $wSlider.attr('data-img-cnt');
			
		//     if ($mlsCode == undefined) return console.log('MLS code no found!');
		//     if ($imgCnt == undefined) return console.log('Counter not found!');

		//     $.each(getGallery($mlsCode, $imgCnt, 2), function(i, m){
		//         $newImages += '<img data-lazy="' + m + '" class="gs-lazy">';
		//     });

		//     $wSlider.html($newImages);

		//     $wSlider.greatSlider({
		//         type: 'fade',
		//         nav: true,
		//         bullets: false,
		//         autoHeight: false,
		//         lazyLoad: true,
		//         layout: {
		//             arrowDefaultStyles: false
		//         },
		//     });
		// }
	});

	// Fixed filter in scroll
	var lastScroll = 0;
	/*$(window).scroll(function(){
		let $currentScroll = $(this).scrollTop() + 86;
		if ($currentScroll > lastScroll) {
			if ($currentScroll >= $ibFilterContainer.position().top) {
				if (!$ibFilterContainer.hasClass('ib-filter-container-inscroll')) $ibFilterContainer.addClass('ib-filter-container-inscroll');
			}
		} else {
			if ($currentScroll <= $ibFilterContainer.position().top) {
				if ($ibFilterContainer.hasClass('ib-filter-container-inscroll')) $ibFilterContainer.removeClass('ib-filter-container-inscroll');
			}
		}
		lastScroll = $currentScroll;
	});*/

	// Close All filters with Matching BTN
	$ibMatchingbtn.on("click", function() {
		$ibAdvanced.find('.ib-oiwrapper').click();
	});
	$('.ib-fmapply').click(function() {
	   $('.ib-badvanced').click();
	});

	// Cambio de vista desde botonera
	$('.idx-bta-map').click(function(){
		$('.ib-mobile-sview').val('map');
		$('.ib-mobile-sview').change();
	});

	// cambio de vista desde botonera
	$('.idx-bta-grid').click(function(){
		$('.ib-mobile-sview').val('grid');
		$('.ib-mobile-sview').change();
	});

	$('.save-button-responsive').click(()=>{
		$('.ib-dbsave').click()
	});

	// botones de shared en mobile
	$('body').on('click', '.ib-pshared', function(){
		$(this).toggleClass('ib-ps-active');
	});

	// Request information
	$('body').on('click', '.ib-requestinfo',()=>{
		//$('.ib-mmpd').animate({scrollTop: $('.ib-cfsubmit').offset().top - $('.ib-pcheader').height()}, 2000, ()=>{
			$('.ib-cffitem:first-child input').focus();
		//});
	});

	if ( 
		typeof(ib_search_filter_extra) == "undefined" || 
		!ib_search_filter_extra.hasOwnProperty('mode') || 
		ib_search_filter_extra.mode !== 'slider'
	  ) {
		var wmaxWidth = $(window).width();
	  
		if (wmaxWidth > 1023) {
			$("body").addClass("ms-hidden-ovf");
		}
	}

}(jQuery));

(function($) {

$(function() {
	// dom ready
	$(window).on("popstate", function(event) {
		// console.group("[popstate]");
		// console.log(location.href);
		// console.dir(event);
		// console.groupEnd("[popstate]");

		if ($("#modal_login").is(":visible")) {
			$(".close").click();
		}

		$(".ib-pbtnclose").click();
	});
});

})(jQuery);


//ACCIONES QUE SE GENERAN EN EL MODO SLIDER: POR EJEMPLO SAVE, MOSTRAR MODAL, ETC.
if (typeof IS_SEARCH_FILTER_CARROUSEL !== "undefined") {

(function ($) {
	$(function() {
		// $(document).on("click", ".gs-bullet", function() {
		//     setTimeout(function () {
		//       myLazyLoad = new LazyLoad({
		//         elements_selector: ".flex-lazy-image",
		//         callback_load: function() {},
		//         callback_error: function(element){
		//           $(element).attr('src','https://idxboost.com/i/default_thumbnail.jpg').removeClass('error').addClass('loaded');
		//           $(element).attr('data-origin','https://idxboost.com/i/default_thumbnail.jpg');
		//         }
		//     });
		//     }, 600);
		// });

		$('.ib-properties-slider').on("click", ".flex-slider-next", function(event) {
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
	
			// Open Registration popup after 3 property pictures are showed [force registration]
			// if ("yes" === __flex_g_settings.anonymous) {
			//     if ( (__flex_g_settings.hasOwnProperty("force_registration")) && (1 == __flex_g_settings.force_registration) ) {
			//         countClickAnonymous++;
			
			//         if (countClickAnonymous >= 3) {
			//             $("#modal_login").addClass("active_modal")
			//             .find('[data-tab]').removeClass('active');
				
			//             $("#modal_login").addClass("active_modal")
			//                 .find('[data-tab]:eq(1)')
			//                 .addClass('active');
						
			//             $("#modal_login")
			//                 .find(".item_tab")
			//                 .removeClass("active");
						
			//             $("#tabRegister")
			//                 .addClass("active");
			
			//             $("button.close-modal").addClass("ib-close-mproperty");
			//             $(".overlay_modal").css("background-color", "rgba(0,0,0,0.8);");
			
			//             $("#modal_login h2").html($("#modal_login").find('[data-tab]:eq(1)').data("text-force"));
			//             countClickAnonymous = 0;
			//         }
			//     }
			// }
		});
	
		$('.ib-properties-slider').on("click", ".flex-favorite-btn", function(event) {
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
	
				if (!$(this).hasClass('active')) {
					//console.log('mark as favorite');
					$(this).addClass('active');
					$.ajax({
						url: __flex_g_settings.ajaxUrl,
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
					$(buton_corazon).removeClass('active');
					var token_alert = $(this).attr("data-alert-token");
					$.ajax({
						url: __flex_g_settings.ajaxUrl,
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
							$(buton_corazon).attr("data-alert-token", '');
						}
					});
				}
			}
		});
	});
})(jQuery);

}
