var initial_title;
var initial_href;

if (typeof originalPositionY === "undefined") {
    var originalPositionY;
}

var IB_HAS_LEFT_CLICKS = (__flex_g_settings.hasOwnProperty("signup_left_clicks") && (null != __flex_g_settings.signup_left_clicks));
var IB_CURRENT_LEFT_CLICKS;

// if (true === IB_HAS_LEFT_CLICKS) {
//     var IB_DEFAULT_LEFT_CLICKS = parseInt(__flex_g_settings.signup_left_clicks, 10);
//     var IB_CURRENT_LEFT_CLICKS = parseInt(__flex_g_settings.signup_left_clicks, 10);
// }

// overwrite amenities for commercial
__flex_idx_search_filter.search.amenities = [
    { "name": "Foreclosure", code: "foreclosure" }, 
    { "name": "Occupied", code: "is_occupied" }, 
    { "name": "Short Sale", code: "short_sale" }, 
    { "name": "Vacant", code: "is_vacant" }
];

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

/* [start] commercial vars (desktop) */
var ib_comm_price_sale_outer_min;
var ib_comm_price_sale_outer_max;

var ib_comm_price_sale_inner_min;
var ib_comm_price_sale_inner_max;

var ib_comm_price_rent_outer_min;
var ib_comm_price_rent_outer_max;

var ib_comm_price_rent_inner_min;
var ib_comm_price_rent_inner_max;

var ib_comm_sqft_inner_min;
var ib_comm_sqft_inner_max;

var ib_comm_bsize_inner_min;
var ib_comm_bsize_inner_max;

var ib_comm_lotsize_inner_min;
var ib_comm_lotsize_inner_max;

var ib_comm_beds_inner_min;
var ib_comm_beds_inner_max;

var ib_comm_year_inner_min;
var ib_comm_year_inner_max;

var ib_comm_rate_inner_min;
var ib_comm_rate_inner_max;
/* [end] */
    
/** @todo vars for mobile inputs */
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

var ib_min_bsize;
var ib_max_bsize;

var ib_min_land;
var ib_max_land;

var ib_min_year;
var ib_max_year;

var ib_waterfront_switch;

var ib_m_features;

var ib_min_caprate;
var ib_max_caprate;
/** end */

var IB_IS_FIRST_LOAD = true;

var style_map=[];

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
    if (__flex_idx_search_filter.list_offmarket.status != undefined  ){
        
        tot_oml_item=parseInt(__flex_idx_search_filter.list_offmarket.tot_item);

        html_market.push('<li class="ib-pitem"><div class="ib-pislider gs-container-slider gs-loaded" id="collection-markert">');
        __flex_idx_search_filter.list_offmarket.data.forEach(function(item){
            html_market.push('<div class="ib-item"><img class="ib-pifimg" src="'+item.image+'" alt="'+item.address+'"><h3 class="ib-title">'+item.address+'</h3><div class="ib-wrap-btn"><a target="_blank" href="" class="ib-mr-link idx_view_collection_market"><span>View Collection</span></a> <a target="_blank" href="https://management.urbanresource.com/page-property/'+item.property_id+'" class="ib-mr-link idx_view_detail_market"><span>'+word_translate.details+'</span></a></div></div>');
        });
        html_market.push('<div class="gs-navs-off-market"><div class="gs-om-arrows"><button class="gs-om-prev-arrow btn_prev_item" method="prev"></button><button class="gs-om-next-arrow btn_next_item" method="next"></button></div></div><span class="ib-label">Managed by Urban Resource</span></div></li>');
    }    

    if (1 == IB_SEARCH_FILTER.attr("data-count")) {
        if (html_market.length>0){
            return html_market.join('');
        }else{
            return '<li class="ib-pitem ib-pitem-marketing">' + __flex_idx_search_filter.hackbox.content + '</li>';
        }
        
    } else {
        if ((0 === index) && ("" != __flex_idx_search_filter.hackbox.content) ) {
            if (html_market.length>0){
                return html_market.join('');
            }else{
                return '<li class="ib-pitem ib-pitem-marketing">' + __flex_idx_search_filter.hackbox.content + '</li>';
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
    if ("yes" === property.recently_listed) {
        return '<li class="ib-piitem ib-pstatus">'+word_translate.new_listing+'!</li>';
    } else if (1 != property.status) {
        return '<li class="ib-piitem ib-pstatus">'+word_translate.pending+'</li>';
    }
});

Handlebars.registerHelper('formatPrice', function(price) {
    return "$" + _.formatPrice(price);
});

Handlebars.registerHelper('rentalType', function(rentalType) {
    return ("1" == rentalType) ? word_translate.similar_properties_for_rent :  word_translate.Similar_properties_for_sale;
});

Handlebars.registerHelper('formatSqft', function(sqft) {
    return _.formatPrice(sqft);
});

Handlebars.registerHelper("idxPermalinkModal", function(slug) {
    return __flex_idx_search_filter.propertyDetailPermalink + "/" + slug;
});

Handlebars.registerHelper('formatLotSize', function(lot_size) {
    return _.formatPrice(lot_size);
});

Handlebars.registerHelper("idxPermalink", function(property) {
    return __flex_idx_search_filter.propertyDetailPermalink + "/" + property.slug;
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
    return ("" === property.token_alert) ? word_translate.save_favorite : word_translate.remove_favorite;
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

Handlebars.registerHelper('markPhotosActive', function(property) {
    if ( parseInt(property.img_cnt, 10) > 0 ) {
        return "ib-pvi-active";
    } else {
        return "";
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

Handlebars.registerHelper('idxSliderLoop', function(property) {
    var images = [];

    for (var i = 0, l = property.gallery.length; i < l; i++) {
      images.push(
        '<img onerror="this.src=\'https://www.idxboost.com/i/default_thumbnail.jpg\';" class="ib-pvsitem" src="' +
          property.gallery[i] +
          '" alt="'+property.full_address+'">'
      );
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

        if (/^\d+$/.test(inputValue) && (5 === inputValue.length)) {
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

function handleLookupAutocomplete(request, response) {
    var term = request.term;

    if (term in ib_autocomplete_cache) {
        response(ib_autocomplete_cache[term]);
        return;
    }

    $.ajax({
        url: "https://autocomplete.idxboost.com",
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
    }

    ib_autocomplete.autocomplete("option", "source", handleLookupAutocomplete);
}

function handleKeyUpAutocompleteEvent(event) {
    var inputValue = this.value;

    if ( ("" !== inputValue) && (13 === event.keyCode) ) {
        ib_autocomplete.autocomplete("close");
        // @todo blur autocomplete
        
        setTimeout(function () {
            document.activeElement.blur();
        }, 100);

        if (/^\d+$/.test(inputValue) && (5 === inputValue.length)) {
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

    if ("" === inputValue) {
        ib_autocomplete.autocomplete("option", "source", ib_autocomplete_cities);
        ib_autocomplete.autocomplete( "search", "" );
    } else {
        ib_autocomplete.autocomplete("option", "source", handleLookupAutocomplete);
        ib_autocomplete.autocomplete( "search", ib_autocomplete.val() );
    }
}

function handleClearAutocompleteEvent() {
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
    percent = percent.replace(/[^\d]/g, "");
    year = year.replace(/[^\d]/g, "");
    interest = interest.replace(/[^\d]/g, "");

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

/**
 * Handle Google Map Custom Controls
 */
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

        // push controls to google map canvas
        IB_MAP.controls[google.maps.ControlPosition.TOP_RIGHT].push(mapButtonsWrapper);
}

function handleZoomInButton() {
    // if (IB_MAP.getZoom() >= 18) {
    //     return;
    // }

    if (typeof infoWindow !== 'undefined') {
        if (infoWindow.isOpen()) {
            infoWindow.close();
        }
    }

    // console.log("zoomIn");

    IB_MAP.setZoom(IB_MAP.getZoom() + 1);
}

function handleZoomOutButton() {
    if (typeof infoWindow !== 'undefined') {
        if (infoWindow.isOpen()) {
            infoWindow.close();
        }
    }

    // console.log("zoomOut");

    IB_MAP.setZoom(IB_MAP.getZoom() - 1);
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

// function setupListenersForMapBounds() {
//     console.log("listeners for bounds added");

//     IB_MAP.addListener("dragend", function() {
//         var idleListener = IB_MAP.addListener("idle", function() {
//             google.maps.event.removeListener(idleListener);
//             handleDragSearchEvent();
//         });
//     });
//     // IB_MAP.addListener("zoom_changed", function() {
//     //     var idleListener2 = IB_MAP.addListener("idle", function() {
//     //         google.maps.event.removeListener(idleListener2);
//     //         handleDragSearchEvent();
//     //     });
//     // });
// }

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

        infobox_content.push(
          '<button class="ib-ibclose" aria-label="Close"><span>Close</span></button>'
        );
        infobox_content.push("</div>");
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

                infobox_content.push('<li class="ib-ibditem ib-ibbeds"><span class="ib-ibdbold">'+property_group.property_class_name+'</span></li>');
                infobox_content.push('<li class="ib-ibditem ib-ibbaths"><span class="ib-ibdbold">'+_.formatPrice(property_group.lot_size)+'</span> Lot Size</li>');

                // infobox_content.push('<li class="ib-ibditem ib-ibbeds"><span class="ib-ibdbold">'+property_group.bed+'</span>'+word_translate.beds+'</li>');

                // if (property_group.baths_half > 0) {
                //     infobox_content.push('<li class="ib-ibditem ib-ibbaths"><span class="ib-ibdbold">'+property_group.bath+(property_group.baths_half > 0 ? ".5" : "")+'</span>'+word_translate.baths+'</li>');
                // } else {
                //     infobox_content.push('<li class="ib-ibditem ib-ibbaths"><span class="ib-ibdbold">'+property_group.bath+'</span>'+word_translate.baths+'</li>');
                // }
                
                // infobox_content.push('<li class="ib-ibditem ib-ibsqft"><span class="ib-ibdbold">'+_.formatPrice(property_group.sqft)+'</span>'+word_translate.sqft+'</li>');

                // if (property_group.sqft > 0) {
                //     infobox_content.push('<li class="ib-ibditem ib-ibsqft"><span class="ib-ibdbold">$'+_.formatPrice(property_group.price / property_group.sqft)+'</span>/ '+word_translate.sqft+'</li>');
                // }

                infobox_content.push('</ul>');
                infobox_content.push('</div>');

                infobox_content.push('<div class="ib-ibpb"><img onerror="this.src=\'https://www.idxboost.com/i/default_thumbnail.jpg\';" class="ib-ibimg" src="'+property_group.thumbnail+'" alt="'+property.full_address+'"></div>');

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


            infobox_content.push('<button class="ib-ibclose" aria-label="Close"><span>Close</span></button>');
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

            infobox_content.push('<li class="ib-ibditem ib-ibbeds"><span class="ib-ibdbold">'+property.item.property_class_name+'</span></li>');
            infobox_content.push('<li class="ib-ibditem ib-ibbaths"><span class="ib-ibdbold">'+_.formatPrice(property.item.lot_size)+'</span> Lot Size</li>');

            // infobox_content.push('<li class="ib-ibditem ib-ibbeds"><span class="ib-ibdbold">'+property.item.bed+'</span>'+word_translate.beds+'</li>');

            // if (property.item.baths_half > 0) {
            //     infobox_content.push('<li class="ib-ibditem ib-ibbaths"><span class="ib-ibdbold">'+property.item.bath+(property.item.baths_half > 0 ? ".5" : "")+'</span>'+word_translate.baths+'</li>');
            // } else {
            //     infobox_content.push('<li class="ib-ibditem ib-ibbaths"><span class="ib-ibdbold">'+property.item.bath+'</span>'+word_translate.baths+'</li>');
            // }

            // infobox_content.push('<li class="ib-ibditem ib-ibsqft"><span class="ib-ibdbold">'+_.formatPrice(property.item.sqft)+'</span>'+word_translate.sqft+'</li>');

            // if (property.item.sqft > 0 ) {
            //     infobox_content.push('<li class="ib-ibditem ib-ibsqft"><span class="ib-ibdbold">$'+_.formatPrice(property.item.price / property.item.sqft)+'</span>/ '+word_translate.sqft+'</li>');
            // }

            infobox_content.push('</ul>');
            infobox_content.push('</div>');

            infobox_content.push('<div class="ib-ibpb"><img onerror="this.src=\'https://www.idxboost.com/i/default_thumbnail.jpg\';" class="ib-ibimg" src="'+property.item.thumbnail+'"></div>');

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
function loadPropertyInModal(mlsNumber) {
    if (/webOS|iPhone|iPad/i.test(navigator.userAgent)) {
      $('body').addClass('only-mobile');
    }

    lastOpenedProperty = mlsNumber;

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
            flex_credentials: Cookies.get("ib_lead_token")
        },
        success: function(response) {
            if (jQuery("#_ib_lead_activity_tab").length) {
                jQuery("#_ib_lead_activity_tab button:eq(0)").click();
            }

            // track property [statcounter]
            if (typeof IB_TRACKING_IFRAME !== "undefined") {
                $(IB_TRACKING_IFRAME).remove();
            }

            // dataLayer Tracking Single
            if ("undefined" !== typeof dataLayer) {
                if (__flex_g_settings.hasOwnProperty("has_dynamic_ads") && ("1" == __flex_g_settings.has_dynamic_ads)) {
                    if ( response.hasOwnProperty("mls_num") && response.hasOwnProperty("price") ) {
                        var int_price = parseInt(response.price.replace(/[^\d+]/g, ""));
                        dataLayer.push({"event": "view_item","value": int_price,"items": [{"id": response.mls_num,"google_business_vertical": "real_estate"}]});
                    }
                }
            }


            IB_TRACKING_IFRAME = document.createElement("iframe");
            IB_TRACKING_IFRAME.setAttribute("id", "__ib-tracking-iframe");
            IB_TRACKING_IFRAME.setAttribute("src", __flex_idx_search_filter.propertyDetailPermalink + "/" + response.slug);
            IB_TRACKING_IFRAME.style.width = "1px";
            IB_TRACKING_IFRAME.style.height = "1px";
            document.body.appendChild(IB_TRACKING_IFRAME);

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
                $("#_ib_ph_inq").val(rphone);

                if ( parseInt(response.img_cnt, 10) > 0) {
                    IB_MODAL_SLIDER = IB_MODAL_WRAPPER.find(".ib-pvslider:eq(0)");

                    if (response.gallery.length) {

                    IB_MODAL_SLIDER = IB_MODAL_SLIDER.greatSlider({
                        type: 'swipe',
                          nav: true,
                          bullets: false,
                          lazyLoad: true,
                          layout: {
                              arrowDefaultStyles: false
                          },
                          fullscreen: true,
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
                            IB_MODAL_WRAPPER.find('.gs-item-slider').on('click', function(){
                                IB_MODAL_SLIDER.fullscreen('in', $(this).index() + 1);
                            });
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
                            const $ibmpTitle = IB_MODAL_WRAPPER.find('.ib-pvsititle');
                            if (!$ibmpTitle.length) {
                                IB_MODAL_WRAPPER.find('.gs-container-items').append('<span class="ib-pvsititle">' + $('.ib-ptitle').text() + ' ' + $('.ib-pstitle').text() + '</span>');
                            }
                            // Creando la numeración en FS
                            const $ibmpNumbers = IB_MODAL_WRAPPER.find('.ib-pvsinumber');
                            if (!$ibmpNumbers.length) {
                                IB_MODAL_WRAPPER.find('.gs-container-items').append('<span class="ib-pvsinumber">' + (IB_MODAL_WRAPPER.find('.gs-item-active').index() + 1) + ' of ' + IB_MODAL_WRAPPER.find('.ib-pvsitem').length + '</span>');
                            } else {
                                IB_MODAL_WRAPPER.find('.ib-pvsinumber').text((IB_MODAL_WRAPPER.find('.gs-item-active').index() + 1) + ' of ' + IB_MODAL_WRAPPER.find('.ib-pvsitem').length)
                            }
                          },
                          onStepEnd: ($itemActivo, indexIA)=> {
                            if (IB_MODAL_WRAPPER.find(".ib-pvslider:eq(0)").hasClass('gs-infs')) {
                                IB_MODAL_WRAPPER.find('.ib-pvsinumber').text(indexIA + ' of ' + IB_MODAL_WRAPPER.find('.ib-pvsitem').length)
                            }
                          }

                      });

                    }
                }

                if (0 === parseInt(response.img_cnt, 10)) {
                    var myLatLng = { lat: parseFloat(response.lat), lng: parseFloat(response.lng) };

                    var map = new google.maps.Map(IB_MODAL_WRAPPER.find(".ib-pmap")[0], {
                        disableDoubleClickZoom: true,
                        scrollwheel: false,
                        streetViewControl: false,
                        panControl: false,
                        zoom: 15,
                        center: myLatLng,
                        styles: style_map,
                        gestureHandling: 'greedy',
                        zoomControl: true,
                        zoomControlOptions: {
                            position: google.maps.ControlPosition.RIGHT_TOP
                        },
                        mapTypeControlOptions: {
                          position: google.maps.ControlPosition.LEFT_BOTTOM
                        }
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
                        disableDoubleClickZoom: true,
                        scrollwheel: false,
                        streetViewControl: false,
                        panControl: false,
                        zoom: 15,
                        center: myLatLng2,
                        styles: style_map,
                        gestureHandling: 'cooperative',
                        zoomControl: true,
                        zoomControlOptions: {
                            position: google.maps.ControlPosition.RIGHT_TOP
                        }
                    });
                
                    var marker2 = new google.maps.Marker({
                        position: myLatLng2,
                        map: map2
                    });
                }

                // Web Share API
                if ('share' in navigator) { // for mobile
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
                        IB_CURRENT_LEFT_CLICKS = (parseInt(Cookies.get("_ib_left_click_force_registration"), 10) - 1);
                        Cookies.set("_ib_left_click_force_registration", IB_CURRENT_LEFT_CLICKS);

                        if ((parseInt(Cookies.get("_ib_left_click_force_registration"), 10) <= 0) && ("yes" === __flex_g_settings.anonymous)) {
                            // no left click then open popup registration
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
															// reset to default clicks
															//IB_CURRENT_LEFT_CLICKS = IB_DEFAULT_LEFT_CLICKS;
                        }
                    } else {
                        if ("yes" === __flex_g_settings.anonymous) {
                            if ( (__flex_g_settings.hasOwnProperty("force_registration")) && (1 == __flex_g_settings.force_registration) ) {
                                console.log("is forced registration");
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
						
																$("#modal_login #msRst")
																	.empty()
																	.html($("#mstextRst").html());
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

                // request new token each render of inquiry form for property modal
                if ( __flex_g_settings.hasOwnProperty("google_recaptcha_public_key") && ("" != __flex_g_settings.google_recaptcha_public_key) ) {
                    $('.ib-propery-inquiry-f:eq(0)').find('input[name="recaptcha_response"]').remove();
                    grecaptcha.execute(__flex_g_settings.google_recaptcha_public_key).then(function(token) {
                        $('.ib-propery-inquiry-f:eq(0)').append('<input type="hidden" name="recaptcha_response" value="' + token + '">');
                        console.dir(token);
                    });
                }
            }
        }
    });

    // console.log('Open Property #' + mlsNumber + " in modal.");
}
window.loadPropertyInModal = loadPropertyInModal;
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

    ib_min_bsize = $("#ib-min-bsize");
    ib_max_bsize = $("#ib-max-bsize");

    ib_min_land = $("#ib-min-land");
    ib_max_land = $("#ib-max-land");

    ib_min_year = $("#ib-min-year");
    ib_max_year = $("#ib-max-year");

    ib_waterfront_switch = $("#ib-flex-waterfront-switch");

    ib_m_features = $("#ib-flex-m-features");

    ib_min_caprate = $("#ib-min-caprate");
    ib_max_caprate = $("#ib-max-caprate");

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
        ib_search_filter_dropdown = __flex_idx_search_filter.commercial_types;

        for(var i = 0, l = ib_search_filter_dropdown.length; i < l; i++) {
            var option = ib_search_filter_dropdown[i];
            var text_translate = '';

            if ('Single Family Homes' == option.label ){
                text_translate = word_translate.single_family_homes;
            }else if ('Condominiums' == option.label){
                text_translate = word_translate.condominiums;
            }else if ('Townhouses' == option.label){
                text_translate = word_translate.townhouses;
            }
            else if ('Adult Congregate' == option.label){
                text_translate = word_translate.adult_congregate;
            }else if ('Agricultural' == option.label){
                text_translate = word_translate.agricultural;
            }else if ('Apartments' == option.label){
                text_translate = word_translate.apartments;
            }else if ('Automotive' == option.label){
                text_translate = word_translate.automotive;
            }else if ('Building' == option.label){
                text_translate = word_translate.building;
            }else if ('Business' == option.label){
                text_translate = word_translate.business;
            }else if ('Church' == option.label){
                text_translate = word_translate.church;
            }else if ('Commercial' == option.label){
                text_translate = word_translate.commercial;
            }else if ('Commercial / Business / Agricultural / Industrial Land' == option.label){
                text_translate = word_translate.commercial_business_agricultural_industrial_land;
            }else if ('Condominium' == option.label){
                text_translate = word_translate.condominium;
            }else if ('Dock' == option.label){
                text_translate = word_translate.dock;
            }else if ('Dock Height' == option.label){
                text_translate = word_translate.dock_height;
            }else if ('Duplex / Quad Plex / Triplex' == option.label){
                text_translate = word_translate.duplex_quad_plex_triplex;
            }else if ('Franchise' == option.label){
                text_translate = word_translate.franchise;
            }else if ('Free Standing' == option.label){
                text_translate = word_translate.free_standing;
            }else if ('Hotel' == option.label){
                text_translate = word_translate.hotel;
            }else if ('Income' == option.label){
                text_translate = word_translate.income;
            }else if ('Industrial' == option.label){
                text_translate = word_translate.industrial;
            }else if ('Manufacturing' == option.label){
                text_translate = word_translate.manufacturing;
            }else if ('Medical' == option.label){
                text_translate = word_translate.medical;
            }else if ('Multifamily' == option.label){
                text_translate = word_translate.multifamily;
            }else if ('Office' == option.label){
                text_translate = word_translate.office;
            }else if ('Professional' == option.label){
                text_translate = word_translate.professional;
            }else if ('Residential Income' == option.label){
                text_translate = word_translate.residential_income;
            }else if ('Residential Land/Boat Docks' == option.label){
                text_translate = word_translate.residential_Land_boat_docks;
            }else if ('Restaurant' == option.label){
                text_translate = word_translate.restaurant;
            }else if ('Retail' == option.label){
                text_translate = word_translate.retail;                
            }else if ('School' == option.label){
                text_translate = word_translate.school;
            }else if ('Service' == option.label){
                text_translate = word_translate.service;
            }else if ('Shopping Center' == option.label){
                text_translate = word_translate.shopping_center;
            }else if ('Showroom' == option.label){
                text_translate = word_translate.showroom;
            }else if ('Special' == option.label){
                text_translate = word_translate.special;
            }else if ('Store' == option.label){
                text_translate = word_translate.store;
            }else if ('Warehouse' == option.label){
                text_translate = word_translate.warehouse;               
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

        // ib_search_filter_frag.push('<option value="--">'+word_translate.any+'</option>');

        for(var i = 0, l = ib_search_filter_dropdown.length; i < l; i++) {
            var option = ib_search_filter_dropdown[i];
            ib_search_filter_frag.push('<option value="'+option.value+'">'+option.label+'</option>');
        }

        ib_search_filter_frag.push('<option value="2020">2020</option>');

        if (ib_search_filter_frag.length) {
            ib_min_year.html(ib_search_filter_frag.join(""));
            ib_search_filter_frag.length = 0;
        }
    }

    // FOR YEAR [MOBILE]
    if (ib_max_year.length) {
        ib_search_filter_dropdown = ib_search_filter_params.year_built_range;
        ib_search_filter_dropdown.splice(-1, 1);

        // ib_search_filter_frag.push('<option value="--">'+word_translate.any+'</option>');
        ib_search_filter_frag.push('<option value="2020">2020</option>');

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
            else                
                text_caracteristics=option.name;


            ib_search_filter_frag.push('<li class="ib-item-wrap-fm ib-btn-chk-fm"><input class="ib-m-features-checkboxes" type="checkbox" value="'+option.code+'" id="s_amenity_'+option.code+'"><label for="s_amenity_'+option.code+'">'+text_caracteristics+'</label></li>');
        }

        if (ib_search_filter_frag.length) {
            ib_m_features.html(ib_search_filter_frag.join(""));
            ib_search_filter_frag.length = 0;
        }
    }
}


function formatMobileValues(value) {
    if ( (null != value) && ("" != value) ) {
        if (value.length) {
            value = value.replace(/[^0-9+]/gi, '');
            return _.formatPrice(value);
        }
    } else {
        return "";
    }
}

function formatMobileSoftValues(value) {
    if ( (null != value) && ("" != value) ) {
        if (value.length) {
            value = value.replace(/[^0-9\.+]/gi, '');
            return value;
        }
    } else {
        return "";
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
        ib_min_price.val(formatMobileValues(params.min_sale_price));
    }

    // max price for sale
    if (null != params.max_sale_price) {
        ib_max_price.val(formatMobileValues(params.max_sale_price));
    }

    // min price for rent
    if (null != params.min_rent_price) {
        ib_min_rent_price.val(formatMobileValues(params.min_rent_price));
    }

    // max price for rent
    if (null != params.max_rent_price) {
        ib_max_rent_price.val(formatMobileValues(params.max_rent_price));
    }

    // min beds
    if (null != params.min_beds) {
        ib_min_beds.val(formatMobileValues(params.min_beds));
    }

    // max beds
    if (null != params.max_beds) {
        ib_max_beds.val(formatMobileValues(params.max_beds));
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
        ib_min_living.val(formatMobileValues(params.min_living_size));
    }

    // max living
    if (null != params.max_living_size) {
        ib_max_living.val(formatMobileValues(params.max_living_size));
    }

    // min bsize
    if (null != params.min_building_size) {
        ib_min_bsize.val(formatMobileValues(params.min_building_size));
    }

    // max bsize
    if (null != params.max_building_size) {
        ib_max_bsize.val(formatMobileValues(params.max_building_size));
    }

    // min land
    if (null != params.min_lot_size) {
        ib_min_land.val(formatMobileValues(params.min_lot_size));
    }

    // max land
    if (null != params.max_lot_size) {
        ib_max_land.val(formatMobileValues(params.max_lot_size));
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

    // min caprate
    if (null != params.min_cap_rate) {
        ib_min_caprate.val(formatMobileSoftValues(params.min_cap_rate));
    }

    // max caprate
    if (null != params.max_cap_rate) {
        ib_max_caprate.val(formatMobileSoftValues(params.max_cap_rate));
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

    ib_min_price.on({
        change: function() {
            var currentValue = this.value;
    
            if (currentValue.length) {
                currentValue = currentValue.replace(/[^0-9+]/gi, '');
            }

            IB_SEARCH_FILTER_FORM.find('[name="min_sale_price"]').val(currentValue);
            IB_SEARCH_FILTER_FORM.find('[name="page"]').val(1);

            // submit form
            IB_SEARCH_FILTER_FORM.trigger("submit");
        },
        keyup: function() {
            var currentValue = this.value;
    
            if (currentValue.length) {
                this.value = currentValue.replace(/[^0-9+]/gi, '');
                this.value = (this.value != "" && this.value > 0) ? _.formatPrice(this.value) : "";
            }
        }
    });


    ib_max_price.on({
        change: function() {
            var currentValue = this.value;
    
            if (currentValue.length) {
                currentValue = currentValue.replace(/[^0-9+]/gi, '');
            }

            IB_SEARCH_FILTER_FORM.find('[name="max_sale_price"]').val(currentValue);
            IB_SEARCH_FILTER_FORM.find('[name="page"]').val(1);

            // submit form
            IB_SEARCH_FILTER_FORM.trigger("submit");
        },
        keyup: function() {
            var currentValue = this.value;
    
            if (currentValue.length) {
                this.value = currentValue.replace(/[^0-9+]/gi, '');
                this.value = (this.value != "" && this.value > 0) ? _.formatPrice(this.value) : "";
            }
        }
    });

    ib_min_rent_price.on({
        change: function() {
            var currentValue = this.value;
    
            if (currentValue.length) {
                currentValue = currentValue.replace(/[^0-9+]/gi, '');
            }

            IB_SEARCH_FILTER_FORM.find('[name="min_rent_price"]').val(currentValue);
            IB_SEARCH_FILTER_FORM.find('[name="page"]').val(1);

            // submit form
            IB_SEARCH_FILTER_FORM.trigger("submit");
        },
        keyup: function() {
            var currentValue = this.value;
    
            if (currentValue.length) {
                this.value = currentValue.replace(/[^0-9+]/gi, '');
                this.value = (this.value != "" && this.value > 0) ? _.formatPrice(this.value) : "";
            }
        }
    });


    ib_max_rent_price.on({
        change: function() {
            var currentValue = this.value;
    
            if (currentValue.length) {
                currentValue = currentValue.replace(/[^0-9+]/gi, '');
            }

            IB_SEARCH_FILTER_FORM.find('[name="max_rent_price"]').val(currentValue);
            IB_SEARCH_FILTER_FORM.find('[name="page"]').val(1);

            // submit form
            IB_SEARCH_FILTER_FORM.trigger("submit");
        },
        keyup: function() {
            var currentValue = this.value;
    
            if (currentValue.length) {
                this.value = currentValue.replace(/[^0-9+]/gi, '');
                this.value = (this.value != "" && this.value > 0) ? _.formatPrice(this.value) : "";
            }
        }
    });

    ib_min_living.on({
        change: function() {
            var currentValue = this.value;
    
            if (currentValue.length) {
                currentValue = currentValue.replace(/[^0-9+]/gi, '');
            }

            IB_SEARCH_FILTER_FORM.find('[name="min_living_size"]').val(currentValue);
            IB_SEARCH_FILTER_FORM.find('[name="page"]').val(1);

            // submit form
            IB_SEARCH_FILTER_FORM.trigger("submit");
        },
        keyup: function() {
            var currentValue = this.value;
    
            if (currentValue.length) {
                this.value = currentValue.replace(/[^0-9+]/gi, '');
                this.value = (this.value != "" && this.value > 0) ? _.formatPrice(this.value) : "";
            }
        }
    });


    ib_max_living.on({
        change: function() {
            var currentValue = this.value;
    
            if (currentValue.length) {
                currentValue = currentValue.replace(/[^0-9+]/gi, '');
            }

            IB_SEARCH_FILTER_FORM.find('[name="max_living_size"]').val(currentValue);
            IB_SEARCH_FILTER_FORM.find('[name="page"]').val(1);

            // submit form
            IB_SEARCH_FILTER_FORM.trigger("submit");
        },
        keyup: function() {
            var currentValue = this.value;
    
            if (currentValue.length) {
                this.value = currentValue.replace(/[^0-9+]/gi, '');
                this.value = (this.value != "" && this.value > 0) ? _.formatPrice(this.value) : "";
            }
        }
    });

    ib_min_bsize.on({
        change: function() {
            var currentValue = this.value;
    
            if (currentValue.length) {
                currentValue = currentValue.replace(/[^0-9+]/gi, '');
            }

            IB_SEARCH_FILTER_FORM.find('[name="min_building_size"]').val(currentValue);
            IB_SEARCH_FILTER_FORM.find('[name="page"]').val(1);

            // submit form
            IB_SEARCH_FILTER_FORM.trigger("submit");
        },
        keyup: function() {
            var currentValue = this.value;
    
            if (currentValue.length) {
                this.value = currentValue.replace(/[^0-9+]/gi, '');
                this.value = (this.value != "" && this.value > 0) ? _.formatPrice(this.value) : "";
            }
        }
    });


    ib_max_bsize.on({
        change: function() {
            var currentValue = this.value;
    
            if (currentValue.length) {
                currentValue = currentValue.replace(/[^0-9+]/gi, '');
            }

            IB_SEARCH_FILTER_FORM.find('[name="max_building_size"]').val(currentValue);
            IB_SEARCH_FILTER_FORM.find('[name="page"]').val(1);

            // submit form
            IB_SEARCH_FILTER_FORM.trigger("submit");
        },
        keyup: function() {
            var currentValue = this.value;
    
            if (currentValue.length) {
                this.value = currentValue.replace(/[^0-9+]/gi, '');
                this.value = (this.value != "" && this.value > 0) ? _.formatPrice(this.value) : "";
            }
        }
    });

    ib_min_land.on({
        change: function() {
            var currentValue = this.value;
    
            if (currentValue.length) {
                currentValue = currentValue.replace(/[^0-9+]/gi, '');
            }

            IB_SEARCH_FILTER_FORM.find('[name="min_lot_size"]').val(currentValue);
            IB_SEARCH_FILTER_FORM.find('[name="page"]').val(1);

            // submit form
            IB_SEARCH_FILTER_FORM.trigger("submit");
        },
        keyup: function() {
            var currentValue = this.value;
    
            if (currentValue.length) {
                this.value = currentValue.replace(/[^0-9+]/gi, '');
                this.value = (this.value != "" && this.value > 0) ? _.formatPrice(this.value) : "";
            }
        }
    });


    ib_max_land.on({
        change: function() {
            var currentValue = this.value;
    
            if (currentValue.length) {
                currentValue = currentValue.replace(/[^0-9+]/gi, '');
            }

            IB_SEARCH_FILTER_FORM.find('[name="max_lot_size"]').val(currentValue);
            IB_SEARCH_FILTER_FORM.find('[name="page"]').val(1);

            // submit form
            IB_SEARCH_FILTER_FORM.trigger("submit");
        },
        keyup: function() {
            var currentValue = this.value;
    
            if (currentValue.length) {
                this.value = currentValue.replace(/[^0-9+]/gi, '');
                this.value = (this.value != "" && this.value > 0) ? _.formatPrice(this.value) : "";
            }
        }
    });

    ib_min_beds.on({
        change: function() {
            var currentValue = this.value;
    
            if (currentValue.length) {
                currentValue = currentValue.replace(/[^0-9+]/gi, '');
            }

            IB_SEARCH_FILTER_FORM.find('[name="min_beds"]').val(currentValue);
            IB_SEARCH_FILTER_FORM.find('[name="page"]').val(1);

            // submit form
            IB_SEARCH_FILTER_FORM.trigger("submit");
        },
        keyup: function() {
            var currentValue = this.value;
    
            if (currentValue.length) {
                this.value = currentValue.replace(/[^0-9+]/gi, '');
                this.value = (this.value != "" && this.value > 0) ? _.formatPrice(this.value) : "";
            }
        }
    });


    ib_max_beds.on({
        change: function() {
            var currentValue = this.value;
    
            if (currentValue.length) {
                currentValue = currentValue.replace(/[^0-9+]/gi, '');
            }

            IB_SEARCH_FILTER_FORM.find('[name="max_beds"]').val(currentValue);
            IB_SEARCH_FILTER_FORM.find('[name="page"]').val(1);

            // submit form
            IB_SEARCH_FILTER_FORM.trigger("submit");
        },
        keyup: function() {
            var currentValue = this.value;
    
            if (currentValue.length) {
                this.value = currentValue.replace(/[^0-9+]/gi, '');
                this.value = (this.value != "" && this.value > 0) ? _.formatPrice(this.value) : "";
            }
        }
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

    ib_min_caprate.on({
        change: function() {
            var currentValue = this.value;
    
            if (currentValue.length) {
                currentValue = currentValue.replace(/[^0-9\.+]/gi, '');
            }

            IB_SEARCH_FILTER_FORM.find('[name="min_cap_rate"]').val(currentValue);
            IB_SEARCH_FILTER_FORM.find('[name="page"]').val(1);

            // submit form
            IB_SEARCH_FILTER_FORM.trigger("submit");
        },
        keyup: function() {
            var currentValue = this.value;
    
            if (currentValue.length) {
                this.value = currentValue.replace(/[^0-9\.+]/gi, '');
                this.value = this.value;
            }
        }
    });
    
    ib_max_caprate.on({
        change: function() {
            var currentValue = this.value;
    
            if (currentValue.length) {
                currentValue = currentValue.replace(/[^0-9\.+]/gi, '');
            }

            IB_SEARCH_FILTER_FORM.find('[name="max_cap_rate"]').val(currentValue);
            IB_SEARCH_FILTER_FORM.find('[name="page"]').val(1);

            // submit form
            IB_SEARCH_FILTER_FORM.trigger("submit");
        },
        keyup: function() {
            var currentValue = this.value;
    
            if (currentValue.length) {
                this.value = currentValue.replace(/[^0-9\.+]/gi, '');
                this.value = this.value;
            }
        }
    });

    /*
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
    */
}

function buildSearchFilterForm() {
    // start commercial (desktop)

    ib_comm_price_sale_outer_min = $(".ib-comm-price-sale-outer-min");
    ib_comm_price_sale_outer_max = $(".ib-comm-price-sale-outer-max");
    
    ib_comm_price_sale_inner_min = $(".ib-comm-price-sale-inner-min");
    ib_comm_price_sale_inner_max = $(".ib-comm-price-sale-inner-max");
    
    ib_comm_price_sale_outer_min.on({
        change: function() {
            var currentValue = this.value;
    
            if (currentValue.length) {
                currentValue = currentValue.replace(/[^0-9+]/gi, '');
            }
    
            ib_comm_price_sale_inner_min.val(this.value);

            IB_SEARCH_FILTER_FORM.find('[name="min_sale_price"]').val(currentValue);
            IB_SEARCH_FILTER_FORM.find('[name="page"]').val(1);

            // submit form
            IB_SEARCH_FILTER_FORM.trigger("submit");
        },
        keyup: function() {
            var currentValue = this.value;
    
            if (currentValue.length) {
                this.value = currentValue.replace(/[^0-9+]/gi, '');
                this.value = (this.value != "" && this.value > 0) ? _.formatPrice(this.value) : "";
            }
        }
    });
    
    ib_comm_price_sale_inner_min.on({
        change: function() {
            var currentValue = this.value;
    
            if (currentValue.length) {
                currentValue = currentValue.replace(/[^0-9+]/gi, '');
            }
    
            ib_comm_price_sale_outer_min.val(this.value);

            IB_SEARCH_FILTER_FORM.find('[name="min_sale_price"]').val(currentValue);
            IB_SEARCH_FILTER_FORM.find('[name="page"]').val(1);

            // submit form
            IB_SEARCH_FILTER_FORM.trigger("submit");
        },
        keyup: function() {
            var currentValue = this.value;
    
            if (currentValue.length) {
                this.value = currentValue.replace(/[^0-9+]/gi, '');
                this.value = (this.value != "" && this.value > 0) ? _.formatPrice(this.value) : "";
            }
        }
    });
    
    ib_comm_price_sale_outer_max.on({
        change: function() {
            var currentValue = this.value;
    
            if (currentValue.length) {
                currentValue = currentValue.replace(/[^0-9+]/gi, '');
            }
    
            ib_comm_price_sale_inner_max.val(this.value);

            IB_SEARCH_FILTER_FORM.find('[name="max_sale_price"]').val(currentValue);
            IB_SEARCH_FILTER_FORM.find('[name="page"]').val(1);

            // submit form
            IB_SEARCH_FILTER_FORM.trigger("submit");
        },
        keyup: function() {
            var currentValue = this.value;
    
            if (currentValue.length) {
                this.value = currentValue.replace(/[^0-9+]/gi, '');
                this.value = (this.value != "" && this.value > 0) ? _.formatPrice(this.value) : "";
            }
        }
    });
    
    ib_comm_price_sale_inner_max.on({
        change: function() {
            var currentValue = this.value;
    
            if (currentValue.length) {
                currentValue = currentValue.replace(/[^0-9+]/gi, '');
            }
    
            ib_comm_price_sale_outer_max.val(this.value);

            IB_SEARCH_FILTER_FORM.find('[name="max_sale_price"]').val(currentValue);
            IB_SEARCH_FILTER_FORM.find('[name="page"]').val(1);

            // submit form
            IB_SEARCH_FILTER_FORM.trigger("submit");
        },
        keyup: function() {
            var currentValue = this.value;
    
            if (currentValue.length) {
                this.value = currentValue.replace(/[^0-9+]/gi, '');
                this.value = (this.value != "" && this.value > 0) ? _.formatPrice(this.value) : "";
            }
        }
    });
    
    ib_comm_price_rent_outer_min = $(".ib-comm-price-rent-outer-min");
    ib_comm_price_rent_outer_max = $(".ib-comm-price-rent-outer-max");
    
    ib_comm_price_rent_inner_min = $(".ib-comm-price-rent-inner-min");
    ib_comm_price_rent_inner_max = $(".ib-comm-price-rent-inner-max");
    
    ib_comm_price_rent_outer_min.on({
        change: function() {
            var currentValue = this.value;
    
            if (currentValue.length) {
                currentValue = currentValue.replace(/[^0-9+]/gi, '');
            }
    
            ib_comm_price_rent_inner_min.val(this.value);

            IB_SEARCH_FILTER_FORM.find('[name="min_rent_price"]').val(currentValue);
            IB_SEARCH_FILTER_FORM.find('[name="page"]').val(1);

            // submit form
            IB_SEARCH_FILTER_FORM.trigger("submit");
        },
        keyup: function() {
            var currentValue = this.value;
    
            if (currentValue.length) {
                this.value = currentValue.replace(/[^0-9+]/gi, '');
                this.value = (this.value != "" && this.value > 0) ? _.formatPrice(this.value) : "";
            }
        }
    });
    
    ib_comm_price_rent_inner_min.on({
        change: function() {
            var currentValue = this.value;
    
            if (currentValue.length) {
                currentValue = currentValue.replace(/[^0-9+]/gi, '');
            }
    
            ib_comm_price_rent_outer_min.val(this.value);

            IB_SEARCH_FILTER_FORM.find('[name="min_rent_price"]').val(currentValue);
            IB_SEARCH_FILTER_FORM.find('[name="page"]').val(1);

            // submit form
            IB_SEARCH_FILTER_FORM.trigger("submit");
        },
        keyup: function() {
            var currentValue = this.value;
    
            if (currentValue.length) {
                this.value = currentValue.replace(/[^0-9+]/gi, '');
                this.value = (this.value != "" && this.value > 0) ? _.formatPrice(this.value) : "";
            }
        }
    });
    
    ib_comm_price_rent_outer_max.on({
        change: function() {
            var currentValue = this.value;
    
            if (currentValue.length) {
                currentValue = currentValue.replace(/[^0-9+]/gi, '');
            }
    
            ib_comm_price_rent_inner_max.val(this.value);

            IB_SEARCH_FILTER_FORM.find('[name="max_rent_price"]').val(currentValue);
            IB_SEARCH_FILTER_FORM.find('[name="page"]').val(1);

            // submit form
            IB_SEARCH_FILTER_FORM.trigger("submit");
        },
        keyup: function() {
            var currentValue = this.value;
    
            if (currentValue.length) {
                this.value = currentValue.replace(/[^0-9+]/gi, '');
                this.value = (this.value != "" && this.value > 0) ? _.formatPrice(this.value) : "";
            }
        }
    });
    
    ib_comm_price_rent_inner_max.on({
        change: function() {
            var currentValue = this.value;
    
            if (currentValue.length) {
                currentValue = currentValue.replace(/[^0-9+]/gi, '');
            }
    
            ib_comm_price_rent_outer_max.val(this.value);

            IB_SEARCH_FILTER_FORM.find('[name="max_rent_price"]').val(currentValue);
            IB_SEARCH_FILTER_FORM.find('[name="page"]').val(1);

            // submit form
            IB_SEARCH_FILTER_FORM.trigger("submit");
        },
        keyup: function() {
            var currentValue = this.value;
    
            if (currentValue.length) {
                this.value = currentValue.replace(/[^0-9+]/gi, '');
                this.value = (this.value != "" && this.value > 0) ? _.formatPrice(this.value) : "";
            }
        }
    });
    
    ib_comm_sqft_inner_min = $(".ib-comm-sqft-inner-min");
    ib_comm_sqft_inner_max = $(".ib-comm-sqft-inner-max");
    
    ib_comm_sqft_inner_min.on({
        change: function() {
            var currentValue = this.value;
    
            if (currentValue.length) {
                currentValue = currentValue.replace(/[^0-9+]/gi, '');
            }

            IB_SEARCH_FILTER_FORM.find('[name="min_living_size"]').val(currentValue);
            IB_SEARCH_FILTER_FORM.find('[name="page"]').val(1);

            // submit form
            IB_SEARCH_FILTER_FORM.trigger("submit");
        },
        keyup: function() {
            var currentValue = this.value;
    
            if (currentValue.length) {
                this.value = currentValue.replace(/[^0-9+]/gi, '');
                this.value = (this.value != "" && this.value > 0) ? _.formatPrice(this.value) : "";
            }
        }
    });
    
    ib_comm_sqft_inner_max.on({
        change: function() {
            var currentValue = this.value;
    
            if (currentValue.length) {
                currentValue = currentValue.replace(/[^0-9+]/gi, '');
            }

            IB_SEARCH_FILTER_FORM.find('[name="max_living_size"]').val(currentValue);
            IB_SEARCH_FILTER_FORM.find('[name="page"]').val(1);

            // submit form
            IB_SEARCH_FILTER_FORM.trigger("submit");
        },
        keyup: function() {
            var currentValue = this.value;
    
            if (currentValue.length) {
                this.value = currentValue.replace(/[^0-9+]/gi, '');
                this.value = (this.value != "" && this.value > 0) ? _.formatPrice(this.value) : "";
            }
        }
    });
    
    
    ib_comm_bsize_inner_min = $(".ib-comm-bsize-inner-min");
    ib_comm_bsize_inner_max = $(".ib-comm-bsize-inner-max");
    
    ib_comm_bsize_inner_min.on({
        change: function() {
            var currentValue = this.value;
    
            if (currentValue.length) {
                currentValue = currentValue.replace(/[^0-9+]/gi, '');
            }

            IB_SEARCH_FILTER_FORM.find('[name="min_building_size"]').val(currentValue);
            IB_SEARCH_FILTER_FORM.find('[name="page"]').val(1);

            // submit form
            IB_SEARCH_FILTER_FORM.trigger("submit");
        },
        keyup: function() {
            var currentValue = this.value;
    
            if (currentValue.length) {
                this.value = currentValue.replace(/[^0-9+]/gi, '');
                this.value = (this.value != "" && this.value > 0) ? _.formatPrice(this.value) : "";
            }
        }
    });
    
    ib_comm_bsize_inner_max.on({
        change: function() {
            var currentValue = this.value;
    
            if (currentValue.length) {
                currentValue = currentValue.replace(/[^0-9+]/gi, '');
            }

            IB_SEARCH_FILTER_FORM.find('[name="max_building_size"]').val(currentValue);
            IB_SEARCH_FILTER_FORM.find('[name="page"]').val(1);

            // submit form
            IB_SEARCH_FILTER_FORM.trigger("submit");
        },
        keyup: function() {
            var currentValue = this.value;
    
            if (currentValue.length) {
                this.value = currentValue.replace(/[^0-9+]/gi, '');
                this.value = (this.value != "" && this.value > 0) ? _.formatPrice(this.value) : "";
            }
        }
    });
    
    ib_comm_lotsize_inner_min = $(".ib-comm-lotsize-inner-min");
    ib_comm_lotsize_inner_max = $(".ib-comm-lotsize-inner-max");
    
    ib_comm_lotsize_inner_min.on({
        change: function() {
            var currentValue = this.value;
    
            if (currentValue.length) {
                currentValue = currentValue.replace(/[^0-9+]/gi, '');
            }

            IB_SEARCH_FILTER_FORM.find('[name="min_lot_size"]').val(currentValue);
            IB_SEARCH_FILTER_FORM.find('[name="page"]').val(1);

            // submit form
            IB_SEARCH_FILTER_FORM.trigger("submit");
        },
        keyup: function() {
            var currentValue = this.value;
    
            if (currentValue.length) {
                this.value = currentValue.replace(/[^0-9+]/gi, '');
                this.value = (this.value != "" && this.value > 0) ? _.formatPrice(this.value) : "";
            }
        }
    });
    
    ib_comm_lotsize_inner_max.on({
        change: function() {
            var currentValue = this.value;
    
            if (currentValue.length) {
                currentValue = currentValue.replace(/[^0-9+]/gi, '');
            }

            IB_SEARCH_FILTER_FORM.find('[name="max_lot_size"]').val(currentValue);
            IB_SEARCH_FILTER_FORM.find('[name="page"]').val(1);

            // submit form
            IB_SEARCH_FILTER_FORM.trigger("submit");
        },
        keyup: function() {
            var currentValue = this.value;
    
            if (currentValue.length) {
                this.value = currentValue.replace(/[^0-9+]/gi, '');
                this.value = (this.value != "" && this.value > 0) ? _.formatPrice(this.value) : "";
            }
        }
    });
    
    ib_comm_beds_inner_min = $(".ib-comm-beds-inner-min");
    ib_comm_beds_inner_max = $(".ib-comm-beds-inner-max");
    
    ib_comm_beds_inner_min.on({
        change: function() {
            var currentValue = this.value;
    
            if (currentValue.length) {
                currentValue = currentValue.replace(/[^0-9+]/gi, '');
            }

            IB_SEARCH_FILTER_FORM.find('[name="min_beds"]').val(currentValue);
            IB_SEARCH_FILTER_FORM.find('[name="page"]').val(1);

            // submit form
            IB_SEARCH_FILTER_FORM.trigger("submit");
        },
        keyup: function() {
            var currentValue = this.value;
    
            if (currentValue.length) {
                this.value = currentValue.replace(/[^0-9+]/gi, '');
                this.value = (this.value != "" && this.value > 0) ? _.formatPrice(this.value) : "";
            }
        }
    });
    
    ib_comm_beds_inner_max.on({
        change: function() {
            var currentValue = this.value;
    
            if (currentValue.length) {
                currentValue = currentValue.replace(/[^0-9+]/gi, '');
            }

            IB_SEARCH_FILTER_FORM.find('[name="max_beds"]').val(currentValue);
            IB_SEARCH_FILTER_FORM.find('[name="page"]').val(1);

            // submit form
            IB_SEARCH_FILTER_FORM.trigger("submit");
        },
        keyup: function() {
            var currentValue = this.value;
    
            if (currentValue.length) {
                this.value = currentValue.replace(/[^0-9+]/gi, '');
                this.value = (this.value != "" && this.value > 0) ? _.formatPrice(this.value) : "";
            }
        }
    });
    
    ib_comm_year_inner_min = $(".ib-comm-year-inner-min");
    ib_comm_year_inner_max = $(".ib-comm-year-inner-max");
    
    ib_comm_year_inner_min.on({
        change: function() {
            var currentValue = this.value;

            IB_SEARCH_FILTER_FORM.find('[name="min_year"]').val(currentValue);
            IB_SEARCH_FILTER_FORM.find('[name="page"]').val(1);

            // submit form
            IB_SEARCH_FILTER_FORM.trigger("submit");
        },
    });
    
    ib_comm_year_inner_max.on({
        change: function() {
            var currentValue = this.value;

            IB_SEARCH_FILTER_FORM.find('[name="max_year"]').val(currentValue);
            IB_SEARCH_FILTER_FORM.find('[name="page"]').val(1);

            // submit form
            IB_SEARCH_FILTER_FORM.trigger("submit");
        }
    });
    
    ib_comm_rate_inner_min = $(".ib-comm-rate-inner-min");
    ib_comm_rate_inner_max = $(".ib-comm-rate-inner-max");
    
    ib_comm_rate_inner_min.on({
        change: function() {
            var currentValue = this.value;
    
            if (currentValue.length) {
                currentValue = currentValue.replace(/[^0-9\.+]/gi, '');
            }

            IB_SEARCH_FILTER_FORM.find('[name="min_cap_rate"]').val(currentValue);
            IB_SEARCH_FILTER_FORM.find('[name="page"]').val(1);

            // submit form
            IB_SEARCH_FILTER_FORM.trigger("submit");
        },
        keyup: function() {
            var currentValue = this.value;
    
            if (currentValue.length) {
                this.value = currentValue.replace(/[^0-9\.+]/gi, '');
                this.value = this.value;
            }
        }
    });
    
    ib_comm_rate_inner_max.on({
        change: function() {
            var currentValue = this.value;
    
            if (currentValue.length) {
                currentValue = currentValue.replace(/[^0-9\.+]/gi, '');
            }

            IB_SEARCH_FILTER_FORM.find('[name="max_cap_rate"]').val(currentValue);
            IB_SEARCH_FILTER_FORM.find('[name="page"]').val(1);

            // submit form
            IB_SEARCH_FILTER_FORM.trigger("submit");
        },
        keyup: function() {
            var currentValue = this.value;
    
            if (currentValue.length) {
                this.value = currentValue.replace(/[^0-9\.+]/gi, '');
                this.value = this.value;
            }
        }
    });

    // end

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
                console.log('opening...');

                loadPropertyInModal(mlsNumber);
            });
        }, 0);
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
                    console.log('opening...');

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

                    $("#modal_login #msRst").empty().html($("#mstextRst").html());
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
                console.log('opening...');

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

                if ($(window).width() < 1023) {
                    //$('html, body').animate({scrollTop: $('.ib-wgrid').offset().top - 20}, 1000)
                    $('html, body').animate({scrollTop:0}, 1000);
                }
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

            IB_LB_AMENITIES_OPTIONS.find('input[value="'+clickedOption+'"]').attr('checked', checkedOption);

            var chk_amt = IB_LB_AMENITIES_OPTIONS.find(':checked');
            var chk_list = [];

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

    if (IB_LB_TYPES_OPTIONS.length) {
        IB_LB_TYPES_OPTIONS.each(function (index, node) {
            for (var i = 0, l = __flex_idx_search_filter.commercial_types.length; i < l; i++) {
                var li = document.createElement("li");
                li.classList.add("ib-citem");
                var input = document.createElement("input");
                input.setAttribute("type", "checkbox");
                input.setAttribute("id", "ib-ppt-"+node.getAttribute('data-type')+"_" + i);
                input.setAttribute("value", __flex_idx_search_filter.commercial_types[i].value);
                input.classList.add("ib-icheck");
                var label = document.createElement("label");
                label.classList.add("ib-clabel");
                label.setAttribute("for", "ib-ppt-"+node.getAttribute('data-type')+"_" + i);
                var text_label_trans='';
                    if(__flex_idx_search_filter.commercial_types[i].label=='Homes'){
                        text_label_trans=word_translate.homes;
                    }else if(__flex_idx_search_filter.commercial_types[i].label=='Condominiums'){
                        text_label_trans=word_translate.condominiums;
                    }else if(__flex_idx_search_filter.commercial_types[i].label=='Townhouses'){
                        text_label_trans=word_translate.townhouses;
                    }else if (__flex_idx_search_filter.commercial_types[i].label=='Single Family Homes'){
                        text_label_trans=word_translate.single_family_homes;
                    }else if ('Adult Congregate' == __flex_idx_search_filter.commercial_types[i].label){
                        text_label_trans = word_translate.adult_congregate;                    
                    }else if ('Agricultural' == __flex_idx_search_filter.commercial_types[i].label){
                        text_label_trans = word_translate.agricultural;
                    }else if ('Apartments' == __flex_idx_search_filter.commercial_types[i].label){
                        text_label_trans = word_translate.apartments;
                    }else if ('Automotive' == __flex_idx_search_filter.commercial_types[i].label){
                        text_label_trans = word_translate.automotive;
                    }else if ('Building' == __flex_idx_search_filter.commercial_types[i].label){
                        text_label_trans = word_translate.building;
                    }else if ('Business' == __flex_idx_search_filter.commercial_types[i].label){
                        text_label_trans = word_translate.business;
                    }else if ('Church' == __flex_idx_search_filter.commercial_types[i].label){
                        text_label_trans = word_translate.church;
                    }else if ('Commercial' == __flex_idx_search_filter.commercial_types[i].label){
                        text_label_trans = word_translate.commercial;
                    }else if ('Commercial / Business / Agricultural / Industrial Land' == __flex_idx_search_filter.commercial_types[i].label){
                        text_label_trans = word_translate.commercial_business_agricultural_industrial_land;
                    }else if ('Condominium' == __flex_idx_search_filter.commercial_types[i].label){
                        text_label_trans = word_translate.condominium;
                    }else if ('Dock' == __flex_idx_search_filter.commercial_types[i].label){
                        text_label_trans = word_translate.dock;
                    }else if ('Dock Height' == __flex_idx_search_filter.commercial_types[i].label){
                        text_label_trans = word_translate.dock_height;
                    }else if ('Duplex / Quad Plex / Triplex' == __flex_idx_search_filter.commercial_types[i].label){
                        text_label_trans = word_translate.duplex_quad_plex_triplex;
                    }else if ('Franchise' == __flex_idx_search_filter.commercial_types[i].label){
                        text_label_trans = word_translate.franchise;
                    }else if ('Free Standing' == __flex_idx_search_filter.commercial_types[i].label){
                        text_label_trans = word_translate.free_standing;
                    }else if ('Hotel' == __flex_idx_search_filter.commercial_types[i].label){
                        text_label_trans = word_translate.hotel;
                    }else if ('Income' == __flex_idx_search_filter.commercial_types[i].label){
                        text_label_trans = word_translate.income;
                    }else if ('Industrial' == __flex_idx_search_filter.commercial_types[i].label){
                        text_label_trans = word_translate.industrial;
                    }else if ('Manufacturing' == __flex_idx_search_filter.commercial_types[i].label){
                        text_label_trans = word_translate.manufacturing;
                    }else if ('Medical' == __flex_idx_search_filter.commercial_types[i].label){
                        text_label_trans = word_translate.medical;
                    }else if ('Multifamily' == __flex_idx_search_filter.commercial_types[i].label){
                        text_label_trans = word_translate.multifamily;
                    }else if ('Office' == __flex_idx_search_filter.commercial_types[i].label){
                        text_label_trans = word_translate.office;
                    }else if ('Professional' == __flex_idx_search_filter.commercial_types[i].label){
                        text_label_trans = word_translate.professional;
                    }else if ('Residential Income' == __flex_idx_search_filter.commercial_types[i].label){
                        text_label_trans = word_translate.residential_income;
                    }else if ('Residential Land/Boat Docks' == __flex_idx_search_filter.commercial_types[i].label){
                        text_label_trans = word_translate.residential_Land_boat_docks;
                    }else if ('Restaurant' == __flex_idx_search_filter.commercial_types[i].label){
                        text_label_trans = word_translate.restaurant;
                    }else if ('Retail' == __flex_idx_search_filter.commercial_types[i].label){
                        text_label_trans = word_translate.retail;                
                    }else if ('School' == __flex_idx_search_filter.commercial_types[i].label){
                        text_label_trans = word_translate.school;
                    }else if ('Service' == __flex_idx_search_filter.commercial_types[i].label){
                        text_label_trans = word_translate.service;
                    }else if ('Shopping Center' == __flex_idx_search_filter.commercial_types[i].label){
                        text_label_trans = word_translate.shopping_center;
                    }else if ('Showroom' == __flex_idx_search_filter.commercial_types[i].label){
                        text_label_trans = word_translate.showroom;
                    }else if ('Special' == __flex_idx_search_filter.commercial_types[i].label){
                        text_label_trans = word_translate.special;
                    }else if ('Store' == __flex_idx_search_filter.commercial_types[i].label){
                        text_label_trans = word_translate.store;
                    }else if ('Warehouse' == __flex_idx_search_filter.commercial_types[i].label){
                        text_label_trans = word_translate.warehouse;               
                    }else{
                        text_label_trans=__flex_idx_search_filter.commercial_types[i].label;
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

            IB_LB_TYPES_OPTIONS.find('input[value="'+clickedOption+'"]').attr('checked', checkedOption);

            var chk_amt = IB_LB_TYPES_OPTIONS.find(':checked');
            var chk_list = [];

            chk_amt.each(function (index, node) {
                if ( -1 === $.inArray(node.value, chk_list) ) {
                    chk_list.push(node.value);
                }
            });

            var lbl_ptypes = [];
            var commercial_types = __flex_idx_search_filter.commercial_types;

            var ibTextTrans = [];

            [].forEach.call(chk_list, function(index) {
                for (var i = 0, l = commercial_types.length; i < l; i++) {
                    if (commercial_types[i].value == index) {
                        lbl_ptypes.push(commercial_types[i].label);
                    }
                }
            });

            console.dir(lbl_ptypes);

            if (lbl_ptypes.length==commercial_types.length) {
                IB_LBL_TYPES_NTF.html(word_translate.any_type);
            }else{

                if (lbl_ptypes.length) {

                    lbl_ptypes.forEach(function(itemSelect){

                        if ('Adult Congregate' == itemSelect){
                            ibTextTrans.push(word_translate.adult_congregate);                    
                        }else if ('Agricultural' == itemSelect){
                            ibTextTrans.push(word_translate.agricultural);
                        }else if ('Apartments' == itemSelect){
                            ibTextTrans.push(word_translate.apartments);
                        }else if ('Automotive' == itemSelect){
                            ibTextTrans.push(word_translate.automotive);
                        }else if ('Building' == itemSelect){
                            ibTextTrans.push(word_translate.building);
                        }else if ('Business' == itemSelect){
                            ibTextTrans.push(word_translate.business);
                        }else if ('Church' == itemSelect){
                            ibTextTrans.push(word_translate.church);
                        }else if ('Commercial' == itemSelect){
                            ibTextTrans.push(word_translate.commercial);
                        }else if ('Commercial / Business / Agricultural / Industrial Land' == itemSelect){
                            ibTextTrans.push(word_translate.commercial_business_agricultural_industrial_land);
                        }else if ('Condominium' == itemSelect){
                            ibTextTrans.push(word_translate.condominium);
                        }else if ('Dock' == itemSelect){
                            ibTextTrans.push(word_translate.dock);
                        }else if ('Dock Height' == itemSelect){
                            ibTextTrans.push(word_translate.dock_height);
                        }else if ('Duplex / Quad Plex / Triplex' == itemSelect){
                            ibTextTrans.push(word_translate.duplex_quad_plex_triplex);
                        }else if ('Franchise' == itemSelect){
                            ibTextTrans.push(word_translate.franchise);
                        }else if ('Free Standing' == itemSelect){
                            ibTextTrans.push(word_translate.free_standing);
                        }else if ('Hotel' == itemSelect){
                            ibTextTrans.push(word_translate.hotel);
                        }else if ('Income' == itemSelect){
                            ibTextTrans.push(word_translate.income);
                        }else if ('Industrial' == itemSelect){
                            ibTextTrans.push(word_translate.industrial);
                        }else if ('Manufacturing' == itemSelect){
                            ibTextTrans.push(word_translate.manufacturing);
                        }else if ('Medical' == itemSelect){
                            ibTextTrans.push(word_translate.medical);
                        }else if ('Multifamily' == itemSelect){
                            ibTextTrans.push(word_translate.multifamily);
                        }else if ('Office' == itemSelect){
                            ibTextTrans.push(word_translate.office);
                        }else if ('Professional' == itemSelect){
                            ibTextTrans.push(word_translate.professional);
                        }else if ('Residential Income' == itemSelect){
                            ibTextTrans.push(word_translate.residential_income);
                        }else if ('Residential Land/Boat Docks' == itemSelect){
                            ibTextTrans.push(word_translate.residential_Land_boat_docks);
                        }else if ('Restaurant' == itemSelect){
                            ibTextTrans.push(word_translate.restaurant);
                        }else if ('Retail' == itemSelect){
                            ibTextTrans.push(word_translate.retail);
                        }else if ('School' == itemSelect){
                            ibTextTrans.push(word_translate.school);
                        }else if ('Service' == itemSelect){
                            ibTextTrans.push(word_translate.service);
                        }else if ('Shopping Center' == itemSelect){
                            ibTextTrans.push(word_translate.shopping_center);
                        }else if ('Showroom' == itemSelect){
                            ibTextTrans.push(word_translate.showroom);
                        }else if ('Special' == itemSelect){
                            ibTextTrans.push(word_translate.special);
                        }else if ('Store' == itemSelect){
                            ibTextTrans.push(word_translate.store);
                        }else if ('Warehouse' == itemSelect){
                            ibTextTrans.push(word_translate.warehouse);
                        }else{
                            ibTextTrans.push(itemSelect)
                        }
                    });



                    IB_LBL_TYPES_NTF.html(ibTextTrans.join(", "));
                    lbl_ptypes.length = 0;
                } else {
                    IB_LBL_TYPES_NTF.html(word_translate.any_type);
                }

            }


            // if (-1 !== $.inArray("2", chk_list)) {
            //     lbl_ptypes.push("Homes");
            // }

            // if (-1 !== $.inArray("1", chk_list)) {
            //     lbl_ptypes.push("Condominiums");
            // }

            // if (-1 !== $.inArray("tw", chk_list)) {
            //     lbl_ptypes.push("Townhouses");
            // }

            // if (-1 !== $.inArray("mf", chk_list)) {
            //     lbl_ptypes.push("Multi-Family");
            // }

            // if (lbl_ptypes.length && lbl_ptypes.length < 4) {
            //     IB_LBL_TYPES_NTF.html(lbl_ptypes.join(", "));
            //     lbl_ptypes.length = 0;
            // } else {
            //     // IB_LBL_TYPES_NTF.html("Homes, Condominiums, Townhouses");
            //     IB_LBL_TYPES_NTF.html(word_translate.any_type);
            // }

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

                if ( (1900 == min_val) || (2020 == min_val)) {
                    min_val = '1900';
                }
                
                if ( (1900 == max_val) || (2020 == max_val)) {
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
                search_params: search_filter_params
            },
            success: function(response) {
                // console.log("The search filter has been saved successfully.");
            }
        });
    }
}

// register function globally
window.saveFilterSearchForLead = saveFilterSearchForLead;

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
        url: __flex_idx_search_filter.lookupSearchCommercialFilter,
        data: {
            access_token: IB_ACCESS_TOKEN,
            flex_credentials: Cookies.get("ib_lead_token"),
            search_filter_id: IB_SEARCH_FILTER.data("filter-id"),
            get_off_market_position: get_off_market_position,
            post_params: IB_SEARCH_FILTER_FORM.serialize(),
            query_params: ("" != location.search) ? location.search.substr(1) : location.search,
            event_triggered: (typeof event !== 'undefined') ? 'yes' : 'no',
            device_width: window.innerWidth
        },
        success: function(response) {

            //update list off market listing
            __flex_idx_search_filter.list_offmarket = response.list_off_market_listing;

            // update hackbox variable
            __flex_idx_search_filter.hackbox.content = response.hackbox;


            // update force registration variable
            if (false === __flex_g_settings.force_registration) {
                __flex_g_settings.force_registration = response.force_registration;
            }

            ib_xhr_running = false;

            // dataLayer Tracking Collection
            if (typeof dataLayer !== "undefined") {
                if (__flex_g_settings.hasOwnProperty("has_dynamic_ads") && ("1" == __flex_g_settings.has_dynamic_ads)) {
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
                // min_baths: params.min_baths,
                // max_baths: params.max_baths,
                min_living_size: params.min_living_size,
                max_living_size: params.max_living_size
            }));

            if ("0" == params.sale_type) {
                if ( (null == params.min_sale_price) && (null == params.max_sale_price) ) {
                    IB_LBL_PRICE_NTF.html(word_translate.any_price);
                } else {
                    if ( (null != params.min_sale_price) && (null != params.max_sale_price) ) {
                        IB_LBL_PRICE_NTF.html("$" + _.formatShortPrice(params.min_sale_price) + " - $" + _.formatShortPrice(params.max_sale_price));
                        console.log('[1]');
                    } else if ( (null != params.min_sale_price) && (null == params.max_sale_price) ) {
                        IB_LBL_PRICE_NTF.html("$" + _.formatShortPrice(params.min_sale_price) + " - " + word_translate.any_price);
                        console.log('[2]');
                    } else if ( (null == params.min_sale_price) && (null != params.max_sale_price) ) {
                        IB_LBL_PRICE_NTF.html("$" + _.formatShortPrice("0") + " - $" + _.formatShortPrice(params.max_sale_price));
                        console.log('[3]');
                    }
                }
            } else {
                if ( (null == params.min_rent_price) && (null == params.max_rent_price) ) {
                    IB_LBL_PRICE_NTF.html(word_translate.any_price);
                } else {
                    if ( (null != params.min_rent_price) && (null != params.max_rent_price) ) {
                        IB_LBL_PRICE_NTF.html("$" + _.formatShortPrice(params.min_rent_price) + " - $" + _.formatShortPrice(params.max_rent_price));
                        console.log('[1]');
                    } else if ( (null != params.min_rent_price) && (null == params.max_rent_price) ) {
                        IB_LBL_PRICE_NTF.html("$" + _.formatShortPrice(params.min_rent_price) + " - " + word_translate.any_price);
                        console.log('[2]');
                    } else if ( (null == params.min_rent_price) && (null != params.max_rent_price) ) {
                        IB_LBL_PRICE_NTF.html("$" + _.formatShortPrice("0") + " - $" + _.formatShortPrice(params.max_rent_price));
                        console.log('[3]');
                    }
                }
            }

            // if ("0" == params.sale_type) {
            //     if ( (null == params.min_sale_price) && (null == params.max_sale_price) ) {
            //         IB_LBL_PRICE_NTF.html(word_translate.any_price);
            //     } else if ((null != params.min_sale_price) && (null == params.max_sale_price)) {
            //         if (0 == params.min_sale_price) {
            //             IB_LBL_PRICE_NTF.html(word_translate.any_price);
            //         } else {
            //             IB_LBL_PRICE_NTF.html("$" + _.formatShortPrice(params.min_sale_price) + " - "+word_translate.any_price);
            //         }
            //     } else {
            //         IB_LBL_PRICE_NTF.html("$" + _.formatShortPrice(params.min_sale_price) + " - $" + _.formatShortPrice(params.max_sale_price));
            //     }
            // } else {
            //     if ( (null == params.min_rent_price) && (null == params.max_rent_price) ) {
            //         IB_LBL_PRICE_NTF.html(word_translate.any_price);
            //     } else if ((null != params.min_rent_price) && (null == params.max_rent_price)) {
            //         if (0 == params.min_rent_price) {
            //             IB_LBL_PRICE_NTF.html(word_translate.any_price);
            //         } else {
            //             IB_LBL_PRICE_NTF.html("$" + _.formatShortPrice(params.min_rent_price) + " - "+word_translate.any_price);
            //         }
            //     } else {
            //         IB_LBL_PRICE_NTF.html("$" + _.formatShortPrice(params.min_rent_price) + " - $" + _.formatShortPrice(params.max_rent_price));
            //     }
            // }

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

            // if ( (null == params.min_beds) && (null == params.max_beds) ) {
            //     IB_LBL_BED_NTF.html(word_translate.any_beds);
            // } else if ((null != params.min_beds) && (null == params.max_beds)) {
            //     if (0 == params.min_beds) {
            //         IB_LBL_BED_NTF.html(word_translate.any_beds);
            //     } else {
            //         IB_LBL_BED_NTF.html(_.formatShortPrice(params.min_beds) + " - "+word_translate.any_beds);
            //     }
                
            // } else {
            //     IB_LBL_BED_NTF.html(_.formatShortPrice(params.min_beds) + " - " + _.formatShortPrice(params.max_beds) + " "+word_translate.beds);
            // }

            // if ( (null == params.min_baths) && (null == params.max_baths) ) {
            //     IB_LBL_BATH_NTF.html(word_translate.any_baths);
            // } else if ((null != params.min_baths) && (null == params.max_baths)) {
            //     if (0 == params.min_baths) {
            //         IB_LBL_BATH_NTF.html(word_translate.any_baths);
            //     } else {
            //         IB_LBL_BATH_NTF.html(_.formatShortPrice(params.min_baths) + " - "+word_translate.any_baths);
            //     }
            // } else {
            //     IB_LBL_BATH_NTF.html(_.formatShortPrice(params.min_baths) + " - " + _.formatShortPrice(params.max_baths) + " "+word_translate.baths);
            // }

            var labelPropertyTypes = [];
            var commercial_types = __flex_idx_search_filter.commercial_types;

            if(params.property_type != null) {
                [].forEach.call(params.property_type, function(index) {
                    for (var i = 0, l = commercial_types.length; i < l; i++) {
                        if (commercial_types[i].value == index) {
                            labelPropertyTypes.push(commercial_types[i].label);
                        }
                    }
                });
            }

            if (labelPropertyTypes.length) {
                IB_LBL_TYPES_NTF.html(labelPropertyTypes.join(", "));
                
                labelPropertyTypes.length = 0;
            } else {
                IB_LBL_TYPES_NTF.html(word_translate.any_type);
            }

            // var labelPropertyTypes = [];
        
            // if (-1 != $.inArray("2", params.property_type)) {
            //     labelPropertyTypes.push("Homes");
            // }

            // if (-1 != $.inArray("1", params.property_type)) {
            //     labelPropertyTypes.push("Condominiums");
            // }

            // if (-1 != $.inArray("tw", params.property_type)) {
            //     labelPropertyTypes.push("Townhouses");
            // }

            // if (-1 != $.inArray("mf", params.property_type)) {
            //     labelPropertyTypes.push("Multi-Family");
            // }

            // if (labelPropertyTypes.length) {
            //     labelPropertyTypes.forEach(function(item_translate,pos_trans){
            //         if(item_translate=='Homes'){
            //             labelPropertyTypes[pos_trans]=word_translate.homes;
            //         }else if(item_translate=='Condominiums'){
            //             labelPropertyTypes[pos_trans]=word_translate.condominiums;
            //         }else if(item_translate=='Townhouses'){
            //             labelPropertyTypes[pos_trans]=word_translate.townhouses;
            //         }else if (item_translate=='"Single Family Homes"'){
            //             text_label_trans=word_translate.single_family_homes;
            //         } else {
            //             text_label_trans = "Multi-Family";
            //         }
            //     });

            //     if (labelPropertyTypes.length === __flex_idx_search_filter.commercial_types.length) {
            //         IB_LBL_TYPES_NTF.html(word_translate.any_type);
            //     } else {
            //         IB_LBL_TYPES_NTF.html(labelPropertyTypes.join(", "));
            //     }
            //     labelPropertyTypes.length = 0;
            // }


            IB_RG_MATCHING.html(word_translate.view+" " + _.formatShortPrice(pagination.count) + " "+word_translate.listings);
            $(".ib-fmapply").html(word_translate.view+" " + _.formatShortPrice(pagination.count) + " "+word_translate.listings);
            $("#ib-apply-filters-btn").html(word_translate.view+' <span>'+_.formatShortPrice(pagination.count)+'</span> '+word_translate.properties);

            IB_SEARCH_FILTER_FORM.find('[name="sale_type"]').val(params.sale_type);
            IB_SEARCH_FILTER_FORM.find('[name="filter_search_keyword_label"]').val(params.filter_search_keyword_label);
            IB_SEARCH_FILTER_FORM.find('[name="filter_search_keyword_type"]').val(params.filter_search_keyword_type);
            //IB_SEARCH_FILTER_FORM.find('[name="waterfront_options"]').val(params.waterfront_options);
            IB_SEARCH_FILTER_FORM.find('[name="min_sale_price"]').val(params.min_sale_price);
            IB_SEARCH_FILTER_FORM.find('[name="max_sale_price"]').val(params.max_sale_price);
            IB_SEARCH_FILTER_FORM.find('[name="min_rent_price"]').val(params.min_rent_price);
            IB_SEARCH_FILTER_FORM.find('[name="max_rent_price"]').val(params.max_rent_price);
            IB_SEARCH_FILTER_FORM.find('[name="min_beds"]').val(params.min_beds);
            IB_SEARCH_FILTER_FORM.find('[name="max_beds"]').val(params.max_beds);
            //IB_SEARCH_FILTER_FORM.find('[name="min_baths"]').val(params.min_baths);
            //IB_SEARCH_FILTER_FORM.find('[name="max_baths"]').val(params.max_baths);
            IB_SEARCH_FILTER_FORM.find('[name="min_living_size"]').val(params.min_living_size);
            IB_SEARCH_FILTER_FORM.find('[name="max_living_size"]').val(params.max_living_size);
            IB_SEARCH_FILTER_FORM.find('[name="min_lot_size"]').val(params.min_lot_size);
            IB_SEARCH_FILTER_FORM.find('[name="max_lot_size"]').val(params.max_lot_size);
            IB_SEARCH_FILTER_FORM.find('[name="lot_size_measure_type"]').val(params.lot_size_measure_type);
            IB_SEARCH_FILTER_FORM.find('[name="min_year"]').val(params.min_year);
            IB_SEARCH_FILTER_FORM.find('[name="max_year"]').val(params.max_year);
            IB_SEARCH_FILTER_FORM.find('[name="sort_type"]').val(params.sort_type);
            IB_SEARCH_FILTER_FORM.find('[name="page"]').val(params.currentpage);

            if (params.hasOwnProperty("property_type")) {
                // if (Array.isArray(params.property_type)) {
                    if (params.property_type != null) {
                        IB_SEARCH_FILTER_FORM.find('[name="property_type"]').val(params.property_type.join(","));
                    }
                // }
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
                        htmlBuildPagination.push('<a class="ib-pagfirst ib-paggo" data-page="1" href="#"><span>'+word_translate.first_page+'</span></a>');
                    }

                    if (pagination.prev) {
                        htmlBuildPagination.push('<a class="ib-pagprev ib-paggo" data-page="'+(params.currentpage - 1)+'" href="#"><span>'+word_translate.previous_page+'</span></a>');
                    }

                    if (pagination.range.length) {
                        htmlBuildPagination.push('<div class="ib-paglinks">');

                        for (var i = 0, l = pagination.range.length; i < l; i++) {
                            if (params.currentpage == pagination.range[i]) {
                                htmlBuildPagination.push('<a class="ib-plitem ib-plitem-active" data-page="'+pagination.range[i]+'" href="#">'+pagination.range[i]+'</a>');
                            } else {
                                htmlBuildPagination.push('<a class="ib-plitem" data-page="'+pagination.range[i]+'" href="#">'+pagination.range[i]+'</a>');
                            }
                        }

                        htmlBuildPagination.push('</div>');
                    }

                    if (pagination.next) {
                        htmlBuildPagination.push('<a class="ib-pagnext ib-paggo" data-page="'+(params.currentpage + 1)+'" href="#"><span>'+word_translate.next_page+'</span></a>');
                    }

                    if (params.currentpage < pagination.pages) {
                        htmlBuildPagination.push('<a class="ib-paglast ib-paggo" data-page="'+pagination.pages+'" href="#"><span>'+word_translate.last_page+'</span></a>');
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
                IB_LB_TYPES_OPTIONS.find("input").each(function (index, node) {
                    var currentValue = (-1 === $.inArray(node.value, params.property_type) ? parseInt(node.value, 10) : node.value);

                    if (-1 != $.inArray(currentValue, params.property_type)) {
                        node.checked = true;
                    }
                });
            }


            // if (IB_LB_TYPES_OPTIONS.length) {
            //     IB_LB_TYPES_OPTIONS.find("input").each(function (index, node) {
            //         // var currentValue = ("tw" != node.value) ? parseInt(node.value, 10) : node.value;
            //         var currentValue = node.value;

            //         if (-1 != $.inArray(currentValue, params.property_type)) {
            //             node.checked = true;
            //         }
            //     });
            // }

            // if (IB_LB_WATERFRONT_OPTIONS.length) {
            //     IB_LB_WATERFRONT_OPTIONS.val((null == params.waterfront_options) ? "--" : params.waterfront_options);
            // }

            // if (IB_LB_PARKING_OPTIONS.length) {
            //     IB_LB_PARKING_OPTIONS.val((null == params.parking_options) ? "--" : params.parking_options);
            // }

            if (IB_LB_MEASURE_TYPE.length) {
                IB_LB_MEASURE_TYPE.each(function () {
                    if (params.lot_size_measure_type == $(this).val()) {
                        //$(this).click();
                    }
                });
            }

            if (IB_LB_AMENITIES_OPTIONS.length) {
                IB_LB_AMENITIES_OPTIONS.find('input').each(function() {
                    if (-1 !== $.inArray(this.value, params.amenities)) {
                        this.checked = true;
                    }
                });
            }

            if (ib_comm_rate_inner_min.length) {
                IB_SEARCH_FILTER_FORM.find('[name="min_cap_rate"]').val(params.min_cap_rate);
            }

            if (ib_comm_rate_inner_max.length) {
                IB_SEARCH_FILTER_FORM.find('[name="max_cap_rate"]').val(params.max_cap_rate);
            }

            // range notifiers
            if (IB_RG_PRICE_SALE_LBL_LT.length) {
                if (params.min_sale_price != null && params.min_sale_price != "") {
                    var min_sale_price = _.formatPrice(params.min_sale_price);
                    IB_RG_PRICE_SALE_LBL_LT.val(min_sale_price);
                }
                // var min_sale_price = "$" + _.formatPrice(params.min_sale_price)
                // IB_RG_PRICE_SALE_LBL_LT.val(min_sale_price);
            }

            if (IB_RG_PRICE_SALE_LBL_RT.length) {
                if (params.max_sale_price != null && params.max_sale_price != "") {
                    var max_sale_price = _.formatPrice(params.max_sale_price);
                    IB_RG_PRICE_SALE_LBL_RT.val(max_sale_price);
                }
                // var max_sale_price = (null == params.max_sale_price) ? word_translate.any_price : ("$" + _.formatPrice(params.max_sale_price));
                // IB_RG_PRICE_SALE_LBL_RT.val(max_sale_price);
            }

            if (IB_RG_PRICE_RENT_LBL_LT.length) {
                if (params.min_rent_price != null && params.min_rent_price != "") {
                    var min_rent_price = _.formatPrice(params.min_rent_price);
                    IB_RG_PRICE_RENT_LBL_LT.val(min_rent_price);
                }
                // var min_rent_price = "$" + _.formatPrice(params.min_rent_price);
                // IB_RG_PRICE_RENT_LBL_LT.val(min_rent_price);
            }

            if (IB_RG_PRICE_RENT_LBL_RT.length) {
                if (params.max_rent_price != null && params.max_rent_price != "") {
                    var max_rent_price = _.formatPrice(params.max_rent_price);
                    IB_RG_PRICE_RENT_LBL_RT.val(max_rent_price);
                }
                // var max_rent_price = (null == params.max_rent_price) ? word_translate.any_price : ("$" + _.formatPrice(params.max_rent_price));
                // IB_RG_PRICE_RENT_LBL_RT.val(max_rent_price);
            }

            if (IB_RG_YEAR_LBL_LT.length) {
                var min_year = (null == params.min_year) ? "1900" : params.min_year;
                IB_RG_YEAR_LBL_LT.val(min_year);
            }

            if (IB_RG_YEAR_LBL_RT.length) {
                var max_year = (null == params.max_year) ? "2020" : params.max_year;
                IB_RG_YEAR_LBL_RT.val(max_year);
            }

            if (ib_comm_bsize_inner_min.length) {
                if (params.min_building_size != null && params.min_building_size != "") {
                    var min_bsize = params.min_building_size.replace(/[^0-9+]/gi, '');

                    ib_comm_bsize_inner_min.val(_.formatPrice(min_bsize));
                }
            }
            if (ib_comm_bsize_inner_max.length) {
                if (params.max_building_size != null && params.max_building_size != "") {
                    var max_bsize = params.max_building_size.replace(/[^0-9+]/gi, '');

                    ib_comm_bsize_inner_max.val(_.formatPrice(max_bsize));
                }
            }

            if (ib_comm_beds_inner_min.length) {
                if (params.min_beds != null && params.min_beds != "") {
                    ib_comm_beds_inner_min.val(params.min_beds);
                }
            }
            if (ib_comm_beds_inner_max.length) {
                if (params.max_beds != null && params.max_beds != "") {
                    ib_comm_beds_inner_max.val(params.max_beds);
                }
            }

            if (ib_comm_rate_inner_min.length) {
                if (params.min_cap_rate != null && params.min_cap_rate != "") {
                    ib_comm_rate_inner_min.val(params.min_cap_rate);
                }
            }
            if (ib_comm_rate_inner_max.length) {
                if (params.max_cap_rate != null && params.max_cap_rate != "") {
                    ib_comm_rate_inner_max.val(params.max_cap_rate);
                }
            }

            if (IB_RG_LIVING_LBL_LT.length) {
                if (params.min_living_size != null && params.min_living_size != "") {
                    var min_living_size = _.formatPrice(params.min_living_size);
                    IB_RG_LIVING_LBL_LT.val(min_living_size);
                }
                // var min_living_size = _.formatPrice(params.min_living_size) + ' '+word_translate.sqft;
                // IB_RG_LIVING_LBL_LT.val(min_living_size);
            }

            if (IB_RG_LIVING_LBL_RT.length) {
                if (params.max_living_size != null && params.max_living_size != "") {
                    var max_living_size = _.formatPrice(params.max_living_size);
                    IB_RG_LIVING_LBL_RT.val(max_living_size);
                }
                // var max_living_size = (null == params.max_living_size) ? word_translate.any_size : (_.formatPrice(params.max_living_size) + " "+word_translate.sqft);
                // IB_RG_LIVING_LBL_RT.val(max_living_size);
            }

            if (IB_RG_LAND_LBL_LT.length) {
                if (params.min_lot_size != null && params.min_lot_size != "") {
                    var min_lot_size = _.formatPrice(params.min_lot_size);
                    IB_RG_LAND_LBL_LT.val(min_lot_size);
                }
            }

            if (IB_RG_LAND_LBL_RT.length) {
                if (params.max_lot_size != null && params.max_lot_size != "") {
                    var max_lot_size = _.formatPrice(params.max_lot_size);
                    IB_RG_LAND_LBL_RT.val(max_lot_size);
                }

                // var max_lot_size = (null == params.max_lot_size) ? word_translate.any_size : (_.formatPrice(params.max_lot_size) + " "+word_translate.sqft);
                // IB_RG_LAND_LBL_RT.val(max_lot_size);
            }

            // // range notifiers
            // if (IB_RG_PRICE_SALE_LBL_LT.length) {
            //     var min_sale_price = "$" + _.formatPrice(params.min_sale_price)
            //     IB_RG_PRICE_SALE_LBL_LT.val(min_sale_price);
            // }

            // if (IB_RG_PRICE_SALE_LBL_RT.length) {
            //     var max_sale_price = (null == params.max_sale_price) ? word_translate.any_price : ("$" + _.formatPrice(params.max_sale_price));
            //     IB_RG_PRICE_SALE_LBL_RT.val(max_sale_price);
            // }

            // if (IB_RG_PRICE_RENT_LBL_LT.length) {
            //     var min_rent_price = "$" + _.formatPrice(params.min_rent_price);
            //     IB_RG_PRICE_RENT_LBL_LT.val(min_rent_price);
            // }

            // if (IB_RG_PRICE_RENT_LBL_RT.length) {
            //     var max_rent_price = (null == params.max_rent_price) ? word_translate.any_price : ("$" + _.formatPrice(params.max_rent_price));
            //     IB_RG_PRICE_RENT_LBL_RT.val(max_rent_price);
            // }

            // if (IB_RG_YEAR_LBL_LT.length) {
            //     var min_year = (null == params.min_year) ? "1900" : params.min_year;
            //     IB_RG_YEAR_LBL_LT.val(min_year);
            // }

            // if (IB_RG_YEAR_LBL_RT.length) {
            //     var max_year = (null == params.max_year) ? "2020" : params.max_year;
            //     IB_RG_YEAR_LBL_RT.val(max_year);
            // }

            // if (IB_RG_LIVING_LBL_LT.length) {
            //     var min_living_size = _.formatPrice(params.min_living_size) + ' '+word_translate.sqft;
            //     IB_RG_LIVING_LBL_LT.val(min_living_size);
            // }

            // if (IB_RG_LIVING_LBL_RT.length) {
            //     var max_living_size = (null == params.max_living_size) ? word_translate.any_size : (_.formatPrice(params.max_living_size) + " "+word_translate.sqft);
            //     IB_RG_LIVING_LBL_RT.val(max_living_size);
            // }

            // if (IB_RG_LAND_LBL_LT.length) {
            //     var min_lot_size = _.formatPrice(params.min_lot_size) + ' '+word_translate.sqft;
            //     IB_RG_LAND_LBL_LT.val(min_lot_size);
            // }

            // if (IB_RG_LAND_LBL_RT.length) {
            //     var max_lot_size = (null == params.max_lot_size) ? word_translate.any_size : (_.formatPrice(params.max_lot_size) + " "+word_translate.sqft);
            //     IB_RG_LAND_LBL_RT.val(max_lot_size);
            // }

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

            // if (typeof event !== "undefined") {
            //     if ("" != slug) {
            //         history.pushState(null, null, '?' + decodeURIComponent(slug));
            //     } else {
            //         history.pushState(null, null, __flex_idx_search_filter.searchFilterPermalink);
            //     }
            // }

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
                    streetViewControl: false,
                    panControl: false,
                    styles: style_map,
                    gestureHandling: 'greedy',
                    disableDefaultUI: true
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

                google.maps.event.addListenerOnce(IB_MAP, 'tilesloaded', setupMapControls);
            }

            if (params.hasOwnProperty('kml_boundaries'))  {
                if (typeof IB_POLYGON !== "undefined") {
                    IB_POLYGON.setMap(null);
                }

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
                    if (location.search.length > 0) {
                        // console.log('[fit]');
                        IB_MAP.fitBounds(IB_BOUNDS);
                    }
                }
                
                // IB_GMAP_FIT_TO_BOUNDS = false;
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

// @todo domReady
$(function () {
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

                //IB_SEARCH_FILTER_FORM.find('[name="rect"]').val(mapBounds.toUrlValue());
                //IB_SEARCH_FILTER_FORM.find('[name="zm"]').val(mapZoom);

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

        $('.ib-gnopro').removeClass('ib-gnopro-show')
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
    IB_LB_TYPES_OPTIONS = $(".ib-types-options");
    IB_LB_MEASURE_TYPE = $(".lotsize-measure-type");
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
                    $("#modal_login #msRst").empty().html($("#mstextRst").html());
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

                        $("#modal_login #msRst").empty().html($("#mstextRst").html());
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
                $(this).children().html(word_translate.save_favorite);
            } else { // add
                $(this).children().html(word_translate.remove_favorite);
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
            if ('share' in navigator) { // for mobile
                document.title = initial_title;
                history.pushState(null, null, initial_href);
            } else { // for  desktop
                var urlParams = new URLSearchParams(window.location.search);
                urlParams.delete("show");
    
                if ("" === urlParams.toString()) {
                    history.pushState(null, null, __flex_idx_search_filter_v2.searchFilterPermalink);
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
                console.log('restoring to: ' + originalPositionY);
                window.scrollTo(0,originalPositionY);
            }
        });


        IB_SAVE_SEARCH_MODALS.on("submit",function(event){
            event.preventDefault();
            var search_url = encodeURIComponent(location.href);
            var search_count = IB_SEARCH_FILTER.attr("data-count");
            var search_condition = IB_SEARCH_FILTER.attr("data-condition");
            var search_filter_params = IB_SEARCH_FILTER.attr("data-params");
            var search_filter_ID = IB_SEARCH_FILTER.data("filter-id");
            var formData = $(this).serialize();
            formData=formData+'&search_url='+search_url+'&search_count='+search_count+'&search_condition='+search_condition+'&search_filter_params='+search_filter_params+'&search_filter_ID='+search_filter_ID;

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

        IB_MODAL_WRAPPER.on("click", ".ib-plsifb", function(event) {
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
        IB_MODAL_WRAPPER.on("click", ".ib-plsitw", function(event) {
            event.preventDefault();

            var shareURL = "http://twitter.com/share?"; //url base

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
                            disableDoubleClickZoom: true,
                            scrollwheel: false,
                            streetViewControl: false,
                            panControl: false,
                            zoom: 15,
                            center: myLatLng,
                            styles: style_map,
                            gestureHandling: 'cooperative',
                            zoomControl: true,
                            zoomControlOptions: {
                                position: google.maps.ControlPosition.RIGHT_TOP
                            },
                            mapTypeControlOptions: {
                              position: google.maps.ControlPosition.LEFT_BOTTOM
                            }
                        });
                
                        var marker = new google.maps.Marker({
                          position: myLatLng,
                          map: map
                        });
                    }

                    break;
            }
        });
    }

    // if (IB_KW_TG_SEARCH.length) {
        // IB_KW_TG_SEARCH.on("click", function() {
            /*
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
            */
        //});
    //}

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

        // refresh page
        $("#ib-apply-clear").on("click", function() {
            window.scrollTo(0,0);
            location.href = __flex_idx_search_filter_v2.searchFilterPermalink;
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
    $(".ib-listings-ct:eq(0)").on("click", ".gs-next-arrow", function() {
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
                    $(".overlay_modal").css("background-color", "rgba(0,0,0,0.8);");
        
                    $("#modal_login h2").html($("#modal_login").find('[data-tab]:eq(1)').data("text-force"));
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
