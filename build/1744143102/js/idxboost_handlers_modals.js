// HANDLERS MODALS
if (typeof originalPositionY === "undefined") {
  var originalPositionY;
}
var initial_href = document.URL;
var ib_path_filters = __flex_idx_filter_regular.searchFilterPermalink;
var IB_HAS_LEFT_CLICKS = (__flex_g_settings.hasOwnProperty("signup_left_clicks") && (null != __flex_g_settings.signup_left_clicks));
var IB_CURRENT_LEFT_CLICKS;

var $ = jQuery;
var IB_ACCESS_TOKEN = __flex_idx_filter_regular.accessToken;
var IB_MODAL_WRAPPER = $("#flex_idx_modal_wrapper");
var IB_MODAL_TPL = $("#ib-modal-template");
var IB_LISTINGS_CT = $(".ib-listings-ct:eq(0)");
var IB_HEADING_CT = $(".ib-heading-ct:eq(0)");
var IB_MODAL_SLIDER;
var IB_TRACKING_IFRAME;
var style_map = [];

if (style_map_idxboost != undefined && style_map_idxboost != '') {
  style_map = JSON.parse(style_map_idxboost);
}

window.addEventListener("notify-changes-favorites", event => 

  $("#result-search li").each(function(params) {

          if($(this).attr("data-mls") == event.detail.mlsNumber ){
            if( event.detail.isFavorite && !$(this).find(".flex-favorite-btn").find(".clidxboost-icon-check").hasClass("active")) {
              $(this).find(".flex-favorite-btn").find(".clidxboost-icon-check").addClass("active")
            }

            if( !event.detail.isFavorite && $(this).find(".flex-favorite-btn").find(".clidxboost-icon-check").hasClass("active")) {
              $(this).find(".flex-favorite-btn").find(".clidxboost-icon-check").removeClass("active")
            }

          }
  })
  
);



_.mixin({
  formatPrice: function (value, n, x, d, c, s, p) {
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
  getMLSImage: function (mls_num, image) {
    var base_url = 'https://retsimages.s3.amazonaws.com';
    var path = mls_num.substr(-2);

    return [base_url, path, image].join("/");

  },
  getMLSListImage: function (mls_num, image, index) {
    var base_url = 'https://retsimages.s3.amazonaws.com';
    var path = mls_num.substr(-2);

    return [base_url, path, mls_num].join("/") + "_" + index + ".jpg";
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

Handlebars.registerHelper('formatPrice', function (price) {
  return "$" + _.formatPrice(price);
});

Handlebars.registerHelper('formatSqft', function(sqft) {
        if ( ![null,"",undefined,"undefined",0,"0"].includes( sqft ) ){
            return _.formatPrice(sqft);
        }else{
            return "N/A";
        }
        
    });

Handlebars.registerHelper('propertyPermalink', function (slug) {
  if (typeof IB_AGENT_PERMALINK !== "undefined") {
    //return IB_AGENT_PERMALINK + "/property/" + slug;
  }

  return __flex_idx_filter_regular.propertyDetailPermalink + "/" + slug;
});

Handlebars.registerHelper('agentPhoto', function (property) {
  if (typeof IB_AGENT_AVATAR_IMAGE !== "undefined") {
    if (IB_AGENT_AVATAR_IMAGE.length) {
      return IB_AGENT_AVATAR_IMAGE;
    } else {
      return 'https://idxboost-spw-assets.idxboost.us/photos/avatar.jpg';
    }
  }

  return __flex_idx_filter_regular.agentPhoto;
});

Handlebars.registerHelper('agentFullName', function (property) {
  if (typeof IB_AGENT_FULL_NAME !== "undefined") {
    return IB_AGENT_FULL_NAME;
  }

  return __flex_idx_filter_regular.agentFullName;
});

Handlebars.registerHelper('agentPhoneNumber', function (property) {
  if (typeof IB_AGENT_PHONE_NUMBER !== "undefined") {
    return IB_AGENT_PHONE_NUMBER.replace(/[^\d+]/g, "");
  }

  return __flex_idx_filter_regular.agentPhone.replace(/[^\d+]/g, "");
});

Handlebars.registerHelper('agentPhone', function (property) {
  if (typeof IB_AGENT_PHONE_NUMBER !== "undefined") {
    return IB_AGENT_PHONE_NUMBER;
  }

  return __flex_idx_filter_regular.agentPhone;
});

Handlebars.registerHelper('idxReduced', function (reduced) {
  if (reduced < 0) {
    return '<div class="ib-pipanumber ib-pipadown">' + reduced + '%</div>';
  } else if (reduced > 0) {
    return '<div class="ib-pipanumber">' + reduced + '%</div>';
  } else {
    return '';
  }
});

Handlebars.registerHelper('isNotSingleorCondos', function (property) {
  if ((property.tw == "1" || property.mf == "1" || property.is_vacant == "1")) {
    if (property.more_info_info.style != "") {
      return '<li><span class="ib-plist-st">' + word_translate.style + '</span><span class="ib-plist-pt">' + property.more_info_info.style + '</span></li>';
    }
  }
  return '';
});

Handlebars.registerHelper('isSingleorCondos', function (property) {
  if (!(property.tw == "1" || property.mf == "1" || property.is_vacant == "1")) {

    if (property.more_info_info.style != "") {
      return '<li><span class="ib-plist-st">' + word_translate.style + '</span><span class="ib-plist-pt">' + property.more_info_info.style + '</span></li>';
    }
  }
  return '';
});

Handlebars.registerHelper('leadFirstName', function (property) {
  return __flex_idx_filter_regular.leadFirstName;
});

Handlebars.registerHelper('leadLastName', function (property) {
  return __flex_idx_filter_regular.leadLastName;
});

Handlebars.registerHelper('leadEmailAddress', function (property) {
  return __flex_idx_filter_regular.leadEmailAddress;
});

/*Handlebars.registerHelper('leadCountryCodePhoneNumber', function (property) {
  return __flex_idx_filter_regular.leadCountryCodePhoneNumber;
});*/

Handlebars.registerHelper('leadPhoneNumber', function (property) {
  return __flex_idx_filter_regular.leadPhoneNumber;
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


Handlebars.registerHelper("markClassActiveTab", function (property) {
  if (parseInt(property.img_cnt, 10) > 0) {
    return "ib-pva-photos";
  } else {
    return "ib-pva-map";
  }
});

Handlebars.registerHelper("idxFavoriteText", function (property) {
  return ("" === property.token_alert) ? word_translate.save : word_translate.remove;
});

Handlebars.registerHelper('formatPriceSqft', function (property) {
  if ((property.sqft > 0) && (property.price > 0)) {
    return _.formatPrice(property.price / property.sqft);
  } else {
    return "";
  }
});

Handlebars.registerHelper('idxImage', function (property) {
  if (property.img_cnt > 0) {
    return _.getMLSImage(property.mls_num, property.image);
  } else {
    return "https://www.idxboost.com/i/default_thumbnail.jpg";
  }
});

Handlebars.registerHelper('idxRelatedImage', function (property) {
  if ("" != property.image) {
    return _.getMLSImage(property.mls_num, property.image);
  } else {
    return "https://www.idxboost.com/i/default_thumbnail.jpg";
  }
});

Handlebars.registerHelper('idxImageEmpty', function (property) {
  if (property.img_cnt < 2) {
    return "ib-piwoimgs";
  } else {
    return "";
  }
});

Handlebars.registerHelper('markPhotosActive', function (property) {
  if (parseInt(property.img_cnt, 10) > 0) {
    return "ib-pvi-active";
  } else {
    return "";
  }
});

Handlebars.registerHelper('markMapActive', function (property) {
  if (0 == parseInt(property.img_cnt, 10)) {
    return "ib-pvi-active";
  } else {
    return "";
  }
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
    
Handlebars.registerHelper("idxFavoriteClass", function (property) {
  var options = ["ib-pfheart", "ib-pfstar", "ib-pfcube"];
  var currentClass = options[__flex_idx_filter_regular.search.view_icon_type];
  var returnOptions = [];

  returnOptions.push(currentClass);

  if (property.hasOwnProperty("token_alert") && (property.token_alert.length)) {
    returnOptions.push("ib-pf-active");
  }

  return returnOptions.join(" ");
});

Handlebars.registerHelper("isRentalType", function (property) {
  if (property.hasOwnProperty("is_rental") && "1" == property.is_rental) {
    return '/' + word_translate.month;
  } else {
    return "";
  }
});

Handlebars.registerHelper('idxSliderLoop', function (property) {
  sliderItems = [];
  var count = property.gallery.length;
  if (property.gallery.length > 0) {
    property.gallery.forEach(function (item_image) {
      sliderItems.push('<img class="ib-pvsitem" src="' + item_image + '">');
    });

    if (count == 1) {
      sliderItems.push('<img class="ib-pvsitem" src="https://www.idxboost.com/i/default_thumbnail.jpg">');
      sliderItems.push('<img class="ib-pvsitem" src="https://www.idxboost.com/i/default_thumbnail.jpg">');
    } else if (count == 2) {
      sliderItems.push('<img class="ib-pvsitem" src="https://www.idxboost.com/i/default_thumbnail.jpg">');
    }

  }
  return sliderItems.join("");
});


$(document).ready(function () {
  var idxboostsearch = window.location.search.split('&');
  var urlParams = new URLSearchParams(window.location.search);
  idxboostsearch.forEach(function (elementboost) {
    var keyelement = elementboost.split('=');
    if (keyelement[0].indexOf('savesearch') != -1) {
      if (flex_idx_filter_params.anonymous != 'yes') {
        active_modal($('#modal_login'));
      }
    }
  });
  idxboost_filter_countacti = true;
  if (urlParams.has("show")) {
    var mlsNumber = urlParams.get("show");

    originalPositionY = Math.max(window.pageYOffset, document.documentElement.scrollTop, document.body.scrollTop);
    console.log('opening...');

    loadPropertyInModal(mlsNumber);
  }
});

$(document).on("click", ".ib-mmclose", function () {
  var $theModal = $(event.target).parents('.ib-modal-master');
  $theModal.addClass('ib-md-hiding');
  setTimeout(function () {
    $theModal.removeClass('ib-md-active ib-md-hiding');
  }, 250);
});

$(".ib-dbsave").on("click", function () {
  if ("yes" === __flex_g_settings.anonymous) {
    if ($(".register").length) {
      $(".register").click();

      /*TEXTO REGISTER*/
      var titleText = $(".header-tab a[data-tab='tabRegister']").attr('data-text')
      $("#modal_login .modal_cm .content_md .heder_md .ms-title-modal").html(titleText);
    }

    return;
  }

  $("#ib-fsearch-save-modal").addClass("ib-md-active");
});


$(".ib-listings-ct:eq(0)").on("click", ".gs-next-arrow", function () {
  var $wSlider = $(this).parents('.ib-pislider');

  if (!$wSlider.hasClass('gs-builded')) {
    var $newImages = '',
      $mlsCode = $wSlider.attr('data-mls'),
      $imgCnt = $wSlider.attr('data-img-cnt');

    if ($mlsCode == undefined) return console.log('MLS code no found!');
    if ($imgCnt == undefined) return console.log('Counter not found!');

    $.each(getGallery($mlsCode, $imgCnt, 2), function (i, m) {
      $newImages += '<img data-lazy="' + m + '" class="gs-lazy">';
    });

    $wSlider.html($newImages);

    $wSlider.greatSlider({
      type: 'fade',
      nav: true,
      bullets: false,
      autoHeight: false,
      lazyLoad: true,
      layout: {
        arrowDefaultStyles: false
      },
    });
  }
});


$('body').on('click', '.ib-pshared', function () {
  $(this).toggleClass('ib-ps-active');
});

// HANDLERS MODALS

function markPropertyAsFavorite(mlsNumber, element, from) {
  var markPropertyAsFavoriteEndpoint = __flex_idx_filter_regular.trackListingsDetail.replace(/{{mlsNumber}}/g, mlsNumber);

  console.dir([mlsNumber, element, from]);

  $.ajax({
    type: "POST",
    url: markPropertyAsFavoriteEndpoint,
    data: {
      access_token: IB_ACCESS_TOKEN,
      flex_credentials: Cookies.get("ib_lead_token"),
      url_origin: location.origin,
      url_referer: document.referrer,
      user_agent: navigator.userAgent,
      registration_key: (typeof IB_AGENT_REGISTRATION_KEY !== "undefined") ? IB_AGENT_REGISTRATION_KEY : null
    },
    success: function (response) {
      if ("add" === response.type) {
        $(this).data("token-alert", response.token_alert);
      } else {
        $(this).data("token-alert", "");
      }

      if ("modal" === from) {
        if ("add" === response.type) {

          /*SETTING ALL MLS IN PAGE FROM BUILDNG*/
          $('.ib-filter-slider-building .js-flex-favorite-btn').each(function () {
            console.log($(this).parent().attr("data-mls") + "--" + mlsNumber);
            if ($(this).parent().attr("data-mls") == mlsNumber) {
              console.log("ingreso add 1");
              $(this).addClass("active");
            }
          });

          $('.ib_content_views_building .flex-favorite-btn').each(function () {
            if ($(this).parent().data("mls") != undefined) {
              var mls_num_extra = $(this).parent().data("mls");
            } else {
              var mls_num_extra = $(this).parent().parent().data("mls");
            }
            if (mls_num_extra == mlsNumber) {
              console.log("ingreso add 2");
              $(this).find("span").addClass("active flex-active-fav");
            }
          });
          /*SETTING ALL MLS IN PAGE*/


          IB_LISTINGS_CT.find(".ib-pfavorite").each(function () {
            var mlsData = $(this).data("mls");

            if (mlsData === mlsNumber) {
              $(this).addClass("ib-pf-active");
              $(this).data("token-alert", response.token_alert);
            }
          });

          $('#wrap-list-result ul#result-search').find('li.propertie').each(function () {
            if ($(this).data('mls') == mlsNumber) {
              $(this).find('.clidxboost-icon-check').addClass('active');
              $(this).find('.flex-favorite-btn').data('alert-token', response.token_alert);
              $(this).attr("data-token-alert", response.token_alert);
            }
          });

        } else {

          /*SETTING ALL MLS IN PAGE*/
          $('.ib_content_views_building .flex-favorite-btn').each(function () {
            if ($(this).parent().data("mls") != undefined) {
              var mls_num_extra = $(this).parent().data("mls");
            } else {
              var mls_num_extra = $(this).parent().parent().data("mls");
            }
            if (mls_num_extra == mlsNumber) {
              $(this).find("span").removeClass("active flex-active-fav");
            }
          });

          $('.ib-filter-slider-building .js-flex-favorite-btn').each(function () {
            if ($(this).parent().attr("data-mls") == mlsNumber) {
              $(this).removeClass("active flex-active-fav");
            }
          });
          /*SETTING ALL MLS IN PAGE*/


          IB_LISTINGS_CT.find(".ib-pfavorite").each(function () {
            var mlsData = $(this).data("mls");

            if (mlsData === mlsNumber) {
              $(this).removeClass("ib-pf-active");
            }
          });

          $('#wrap-list-result ul#result-search').find('li.propertie').each(function () {
            if ($(this).data('mls') == mlsNumber) {
              $(this).find('.clidxboost-icon-check').removeClass('active');
              $(this).find('.flex-favorite-btn').data('alert-token', '');
              $(this).attr("data-token-alert", '');
            }
          });

        }
      }

      if (jQuery("#_ib_lead_activity_tab").length) {
        jQuery("#_ib_lead_activity_tab button:eq(1)").click();
      }
    }
  });

  console.log('Track #' + mlsNumber + " as favorite.");
}

function calculate_mortgage(price, percent, year, interest) {
  console.log("mortgage calculator");

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

if ("undefined" === typeof loadPropertyInModal) {
  loadPropertyInModal = function(mlsNumber) {
    if( __flex_g_settings.hasOwnProperty("version") && __flex_g_settings.version == "1" ){
      window.idxtoken= __flex_idx_filter_regular.access_token_search;
      window.dispatchEvent(new CustomEvent("open-property-modal", { detail: { "mlsNumber": mlsNumber,board_id: __flex_g_settings.boardId, } }));
      return false;
    }
    
    if (/webOS|iPhone|iPad/i.test(navigator.userAgent)) {
      $('body').addClass('only-mobile');
    }

    lastOpenedProperty = mlsNumber;
    if (typeof infoWindow !== 'undefined') {
      if (infoWindow.isOpen()) {
        infoWindow.close();
      }
    }

    var viewListingDetailEndpoint = __flex_idx_filter_regular.lookupListingsDetail.replace(/{{mlsNumber}}/g, mlsNumber);

    $.ajax({
      type: "POST",
      url: viewListingDetailEndpoint,
      headers: {
          'Authorization':'Bearer '+__flex_idx_filter_regular.access_token_search
      },    
      data: __flex_g_settings.version == "1" ? 
        JSON.stringify({
          board_id: __flex_g_settings.boardId,
          mls_num :mlsNumber,       
          access_token: IB_ACCESS_TOKEN,
          flex_credentials: Cookies.get("ib_lead_token"),
          registration_key: (typeof IB_AGENT_REGISTRATION_KEY !== "undefined") ? IB_AGENT_REGISTRATION_KEY : null,
          onimage: "noresize"
        })
      :
       {
        board_id: __flex_g_settings.boardId,
        mls_num :mlsNumber,       
        access_token: IB_ACCESS_TOKEN,
        flex_credentials: Cookies.get("ib_lead_token"),
        registration_key: (typeof IB_AGENT_REGISTRATION_KEY !== "undefined") ? IB_AGENT_REGISTRATION_KEY : null,
        onimage: "noresize"
      },
      success: function (response) {
        if (__flex_g_settings.version == "1") {

        
        response.price = "$"+(new Intl.NumberFormat('en-US').format(response.price));
        response.sqft = (new Intl.NumberFormat('en-US').format(response.sqft));
        response.total_sqft = (new Intl.NumberFormat('en-US').format(response.total_sqft));
        response.property_type = response.more_info.type_property;
        response.status_name = response.more_info.status_name;
        response.img_cnt = response.imagens.length;
        response.days_market = response.adom;
        response.list_date = new Date(new Date(response.list_date * 1000)).toLocaleDateString("en-GB")
        response.furnished = response.furnished ? "Yes" : "No";
        response.pool = response.pool ? "Yes" : "No";
        response.water_front = response.water_front ? "Yes" : "No";
        response.amenities = response.amenities.split(",");
        response.price_sqft = "$"+Math.round(response.price_sqft);
        response.gallery = response.imagens;
        response.more_info_info = response.more_info;
        response.feature_exterior = response.feature_exterior.split(",");
        response.feature_interior = response.feature_interior.split(",");
      }
        window.responseex = response;
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
            if (response.hasOwnProperty("mls_num") && response.hasOwnProperty("price")) {
              var int_price = parseInt(response.price.replace(/[^\d+]/g, ""));
              dataLayer.push({ "event": "view_item", "value": int_price, "items": [{ "id": response.mls_num, "google_business_vertical": "real_estate" }] });
            }
          }
        }

        setTimeout(function () {
          if ($(".ib-property-mortage-submit").length > 0) {
            var pp = response.price;
            $(".ib-property-mortgage-f:eq(0)").trigger("reset");
            $("#calculatorYears").text(30+" "+word_translate.years);
            $(".ib-property-mc-ir, #interest_rate_txt").val(__flex_g_settings.interes_rate[30]);            
            var dp = $(".ib-property-mc-dp:eq(0)").val();
            var ty = $(".ib-property-mc-ty:eq(0)").val();
            var ir = $(".ib-property-mc-ir:eq(0)").val();
            var calc_mg = calculate_mortgage(pp, dp, ty, ir);
            $(".ib-price-calculator").text("$" + calc_mg.monthly + "/mo");
            $(".js-est-payment").hide();
            if (response.is_rental == "0") {
              $(".js-est-payment").show();
            }
            // update form
          }
        }, 1000);

        IB_TRACKING_IFRAME = document.createElement("iframe");
        IB_TRACKING_IFRAME.setAttribute("id", "__ib-tracking-iframe");
        if (typeof IB_AGENT_PERMALINK !== "undefined") {
          IB_TRACKING_IFRAME.setAttribute("src", IB_AGENT_PERMALINK + "/property/" + response.slug);
        } else {
          IB_TRACKING_IFRAME.setAttribute("src", __flex_g_settings.propertyDetailPermalink + "/" + response.slug);
        }
        // IB_TRACKING_IFRAME.setAttribute("src", __flex_g_settings.propertyDetailPermalink + "/" + response.slug);
        IB_TRACKING_IFRAME.style.width = "1px";
        IB_TRACKING_IFRAME.style.height = "1px";
        //document.body.appendChild(IB_TRACKING_IFRAME);

        IB_TRACKING_IFRAME.onload = function () {
          setTimeout(function () {
            $(IB_TRACKING_IFRAME).remove();
          }, 3000);
        };

        if (response.hasOwnProperty("development") && response.development == "" && response.hasOwnProperty("complex")) {
          response.development = response.complex;
        }

        if (IB_MODAL_WRAPPER.length && IB_MODAL_TPL.length) {
          var template = Handlebars.compile(IB_MODAL_TPL.html());

          response.oh_bool = false;
          if (response.oh == "1") {
            response.oh_bool = true;
          }

          if (response.hasOwnProperty("oh") && response.oh == "1" && response.hasOwnProperty("oh_info")) {
            var oh_info = JSON.parse(response.oh_info);
            if ((oh_info != null || oh_info != undefined) &&
              typeof (oh_info) === "object" &&
              oh_info.hasOwnProperty("date") &&
              oh_info.hasOwnProperty("timer")) {
              response.oh_info_parce_date = oh_info.date;
              response.oh_info_parce_timer = oh_info.timer;
            }
          }

          IB_MODAL_WRAPPER.html(template(response));

          var rfn = (typeof Cookies.get("_ib_user_firstname") !== "undefined") ? Cookies.get("_ib_user_firstname") : "";
          var rln = (typeof Cookies.get("_ib_user_lastname") !== "undefined") ? Cookies.get("_ib_user_lastname") : "";
          var remail = (typeof Cookies.get("_ib_user_email") !== "undefined") ? Cookies.get("_ib_user_email") : "";
          var rphone = (typeof Cookies.get("_ib_user_phone") !== "undefined" && Cookies.get("_ib_user_phone") != "null") ? Cookies.get("_ib_user_phone") : "";
          var rcphone = (typeof Cookies.get("_ib_user_code_phone") !== "undefined" && Cookies.get("_ib_user_code_phone") != "null") ? Cookies.get("_ib_user_code_phone") : "";

          $("#_ib_fn_inq").val(rfn);
          $("#_ib_ln_inq").val(rln);
          $("#_ib_em_inq").val(remail);

          if (parseInt(response.img_cnt, 10) > 0) {
            IB_MODAL_SLIDER = IB_MODAL_WRAPPER.find(".ib-pvslider:eq(0)");

            IB_MODAL_SLIDER = IB_MODAL_SLIDER.greatSlider({
              type: 'swipe',
              nav: true,
              bullets: false,
              lazyLoad: true,
              navSpeed: 150,
              layout: {
                arrowDefaultStyles: false
              },
              /*fullscreen: true,
              layout: {
                fsButtonDefaultStyles: false,
                fsButtonClass: 'ib-btnfs'
              },*/
              breakPoints: {
                640: {
                  items: 2
                },
                1024: {
                  items: 3
                }
              }/*,
              onInited: function () {
                var windowSize = $(window).width();
                if (windowSize > 767) {
                  IB_MODAL_WRAPPER.find('.gs-item-slider').on('click', function () {
                    IB_MODAL_SLIDER.fullscreen('in', $(this).index() + 1);
                  });
                }

                // Creando la numeración en FS
                const $ibmpNumbers = IB_MODAL_WRAPPER.find('.ib-pvsinumber');
                if (!$ibmpNumbers.length) {
                  IB_MODAL_WRAPPER.find('.gs-container-items').append('<span class="ib-pvsinumber">' + (IB_MODAL_WRAPPER.find('.gs-item-active').index() + 1) + ' of ' + IB_MODAL_WRAPPER.find('.ib-pvsitem').length + '</span>');
                } else {
                  IB_MODAL_WRAPPER.find('.ib-pvsinumber').text((IB_MODAL_WRAPPER.find('.gs-item-active').index() + 1) + ' of ' + IB_MODAL_WRAPPER.find('.ib-pvsitem').length)
                }

              },
              onFullscreenIn: () => {
                // creando el título en FS
                const $ibmpTitle = IB_MODAL_WRAPPER.find('.ib-pvsititle');
                if (!$ibmpTitle.length) {
                  IB_MODAL_WRAPPER.find('.gs-container-items').append('<span class="ib-pvsititle">' + $('.ib-ptitle').text() + ' ' + $('.ib-pstitle').text() + '</span>');
                }
              },
              onStepEnd: ($itemActivo, indexIA) => {
                IB_MODAL_WRAPPER.find('.ib-pvsinumber').text(indexIA + ' of ' + IB_MODAL_WRAPPER.find('.ib-pvsitem').length)
              }*/
            });
            jQuery(".ib-full-screen").removeClass("hidden");
          }else{

            jQuery(".ib-full-screen").addClass("hidden");
          }

          if (0 === parseInt(response.img_cnt, 10)) {
            // @todo
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

            google.maps.event.addListenerOnce(map, 'tilesloaded', setupMapControls);

            function handleSatelliteButton(event) {
              event.stopPropagation();
              event.preventDefault();
              map.setMapTypeId(google.maps.MapTypeId.HYBRID)

              if ($(this).hasClass("is-active")) {
                $(this).removeClass("is-active");
                map.setMapTypeId(google.maps.MapTypeId.ROADMAP)
              } else {
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

            function handleSatelliteButton(event) {
              event.stopPropagation();
              event.preventDefault();
              map2.setMapTypeId(google.maps.MapTypeId.HYBRID)

              if ($(this).hasClass("is-active")) {
                $(this).removeClass("is-active");
                map2.setMapTypeId(google.maps.MapTypeId.ROADMAP)
              } else {
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
            if (typeof IB_AGENT_PERMALINK !== "undefined") {
              history.pushState(null, null, IB_AGENT_PERMALINK + "/property/" + response.slug);
            } else {
              history.pushState(null, null, __flex_g_settings.propertyDetailPermalink + "/" + response.slug);
            }
            // history.pushState(null, null, __flex_g_settings.propertyDetailPermalink + "/" + response.slug);
          } else { // for desktop
            var urlParams = new URLSearchParams(window.location.search);
            urlParams.set("show", response.mls_num);
            history.pushState(null, null, '?' + urlParams.toString());
          }

          if ("undefined" === typeof Cookies.get("_ib_disabled_forcereg")) {
            if (true === IB_HAS_LEFT_CLICKS) {
              //IB_CURRENT_LEFT_CLICKS = (parseInt(Cookies.get("_ib_left_click_force_registration"), 10) - 1);
              IB_CURRENT_LEFT_CLICKS = parseInt(Cookies.get("_ib_left_click_force_registration"), 10);
              Cookies.set("_ib_left_click_force_registration", IB_CURRENT_LEFT_CLICKS + 1);

              if (
                  (typeof idxboost_force_registration != false &&
                      idxboost_force_registration != undefined &&
                      idxboost_force_registration == true)
                  &&
                  parseInt(
                      Cookies.get("_ib_left_click_force_registration"),
                      10
                  ) >= parseInt(__flex_g_settings.signup_left_clicks, 10) &&
                  "yes" === __flex_g_settings.anonymous
              ) {

              // if (
              //   (typeof idxboost_force_registration != false &&
              //     idxboost_force_registration != undefined &&
              //     idxboost_force_registration == true)
              //   &&
              //   parseInt(
              //     Cookies.get("_ib_left_click_force_registration"),
              //     10
              //   ) <= 0 &&
              //   "yes" === __flex_g_settings.anonymous
              // ) {
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

                $("#modal_login #msRst").empty().html($("#mstextRst").html());
                $("button.close-modal").addClass("ib-close-mproperty");
                $(".overlay_modal").css("background-color", "rgba(0,0,0,0.8);");

                $("#modal_login h2").html(
                  $("#modal_login").find("[data-tab]:eq(1)").data("text-force")
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
                  (__flex_g_settings.hasOwnProperty("force_registration") &&
                    1 == __flex_g_settings.force_registration) ||
                  (typeof idxboost_force_registration != false &&
                    typeof idxboost_force_registration != 'undefined' &&
                    idxboost_force_registration != undefined &&
                    idxboost_force_registration == true)
                ) {
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

                  $("#modal_login #msRst").empty().html($("#mstextRst").html());
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
          if (__flex_g_settings.hasOwnProperty("google_recaptcha_public_key") && ("" != __flex_g_settings.google_recaptcha_public_key)) {
            $('.ib-propery-inquiry-f:eq(0)').find('input[name="recaptcha_response"]').remove();
            grecaptcha.execute(__flex_g_settings.google_recaptcha_public_key).then(function (token) {
              $('.ib-propery-inquiry-f:eq(0)').append('<input type="hidden" name="recaptcha_response" value="' + token + '">');
              console.dir(token);
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

    console.log('Open Property #' + mlsNumber + " in modal.");
  }

  // window.loadPropertyInModal = loadPropertyInModal;
}

if (IB_MODAL_WRAPPER.length) {
  // open property in modal from related
  IB_MODAL_WRAPPER.on("click", ".ib-rel-property", function (event) {
    event.preventDefault();

    var mlsNumber = $(this).data("mls");
    loadPropertyInModal(mlsNumber);
  });

  // handle favorite
  IB_MODAL_WRAPPER.on("click", ".ib-pfavorite", function (event) {
    if ("yes" === __flex_g_settings.anonymous) {
      if ($(".register").length) {
        $(".register").click();

        /*TEXTO LOGIN*/
        var titleText = $(".header-tab a[data-tab='tabRegister']").attr('data-text')
        $("#modal_login .modal_cm .content_md .heder_md .ms-title-modal").html(titleText);
      }

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
  IB_MODAL_WRAPPER.on("click", ".ib-pbtnopen", function () {
    var linkToOpen = $(this).data("permalink");
    if (typeof (is_references_active) != "undefined" && is_references_active == "yes") {
      Cookies.set("reference_force_registration", "yes");
    }
    window.open(linkToOpen);
  });

  // close opened modal
  IB_MODAL_WRAPPER.on("click", ".ib-pbtnclose", function () {
    IB_MODAL_WRAPPER.find(".ib-modal-master").removeClass("ib-md-active");
    IB_MODAL_WRAPPER.empty();

    $('body').removeClass('only-mobile');

    // Web Share API
    // if ('share' in navigator) { // for mobile
    if (/iPhone|iPad|iPod|Android/i.test(navigator.userAgent)) {
      document.title = initial_title;
      history.pushState(null, null, initial_href);
    } else { // for  desktop
      var urlParams = new URLSearchParams(window.location.search);
      urlParams.delete("show");

      if ("" === urlParams.toString()) {
        if (window.filter_view == "agent") {
          history.pushState(null, null, initial_href);
        }else{
          history.pushState(null, null, ib_path_filters);
        }
        
      } else {
        history.pushState(null, null, '?' + urlParams.toString());
      }
    }

    // quitando fallback para safari IOS
    $('html').removeClass('ib-mpropertie-open');

    if (typeof originalPositionY !== "undefined") {
      console.log('restoring to: ' + originalPositionY);
      window.scrollTo(0, originalPositionY);
    }
  });

  // share on facebook
  $(document).on("click", ".ib-plsifb", function (event) {
    event.preventDefault();

    var shareURL = "https://www.facebook.com/sharer/sharer.php?"; //url base

    //params
    var params = {
      u: $(this).attr("href")
    };

    for (var prop in params) {
      shareURL += '&' + prop + '=' + encodeURIComponent(params[prop]);
    }

    var wo = window.open(shareURL, '', 'left=0,top=0,width=550,height=450,personalbar=0,toolbar=0,scrollbars=0,resizable=0');

    if (wo.focus) {
      wo.focus();
    }
  });

  // share on twitter
  $(document).on("click", ".ib-plsitw", function (event) {
    event.preventDefault();

    var shareURL = "http://twitter.com/share?"; //url base

    var buildTextShare = [];
    var propertyRental = (1 == $(this).data("rental")) ? "Rent " : "Sale ";

    buildTextShare.push($(this).data("type"));

    buildTextShare.push(" for " + propertyRental);
    buildTextShare.push($(this).data("price"));
    buildTextShare.push(" #" + $(this).data("mls"));
    buildTextShare.push(" in ");
    buildTextShare.push($(this).data("address") + " ");

    //params
    var params = {
      url: $(this).attr("href"),
      text: buildTextShare.join("")
    }

    for (var prop in params) {
      shareURL += '&' + prop + '=' + encodeURIComponent(params[prop]);
    }

    var wo = window.open(shareURL, '', 'left=0,top=0,width=550,height=450,personalbar=0,toolbar=0,scrollbars=0,resizable=0');

    if (wo.focus) {
      wo.focus();
    }
  });

  // open mortgage calculator
  IB_MODAL_WRAPPER.on("click", ".ib-pscalculator", function () {
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

    console.dir(calc_mg);


    console.log('open mortgage calculator');
    $("#ib-mortage-calculator").addClass("ib-md-active");
  });

  $(".ib-property-mortage-submit").on("click", function () {
    var pp = $(".ib-property-mc-pp:eq(0)").val();
    var dp = $(".ib-property-mc-dp:eq(0)").val();
    var ty = $(".ib-property-mc-ty:eq(0)").val();
    var ir = $(".ib-property-mc-ir:eq(0)").val();

    var calc_mg = calculate_mortgage(pp, dp, ty, ir);

    $(".ib-calc-mc-mortgage").html("$" + calc_mg.mortgage);
    $(".ib-calc-mc-down-payment").html("$" + calc_mg.down_payment);
    $(".ib-calc-mc-monthly").html("$" + calc_mg.monthly);
    $(".ib-calc-mc-totalmonthly").html("$" + calc_mg.total_monthly);
    $(".ib-price-calculator").text("$" + calc_mg.monthly + "/mo");
  });

  // open email to a friend modal
  $(document).on("click", ".ib-psemailfriend", function () {
    var mlsNumber = $(this).data("mls");
    $(".ib-property-share-friend-f:eq(0)").trigger("reset");
    $(".ib-property-share-mls-num:eq(0)").val(mlsNumber);
    $("#ib-email-to-friend").addClass("ib-md-active");
  });

  $(".ib-property-share-friend-f").on("submit", function (event) {
    event.preventDefault();

    var _self = $(this);

    if (__flex_g_settings.hasOwnProperty("has_enterprise_recaptcha")) { // enterprise recaptcha
      if ("1" == __flex_g_settings.has_enterprise_recaptcha) {
        // pending...
      } else { // regular recaptcha
        grecaptcha.ready(function () {
          grecaptcha
            .execute(__flex_g_settings.google_recaptcha_public_key, { action: 'share_property_with_friend' })
            .then(function (token) {
              _self.prepend('<input type="hidden" name="recaptcha_response" value="' + token + '">');

              var formData = _self.serialize();
              var mlsNumber = _self.find("input[name='mls_number']:eq(0)").val();
              var shareWithFriendEndpoint = __flex_idx_filter_regular.shareWithFriendEndpoint.replace(/{{mlsNumber}}/g, mlsNumber);

              var building_id = $("#idxboost_collection_xr").find('[name="building_id"]').val();

              if (building_id != undefined) {
                shareWithFriendEndpoint = __flex_idx_filter_regular.shareWithFriendBuildingEndpoint.replace(/{{codBuilding}}/g, building_id);
                formData = formData + "&url=" + encodeURIComponent(window.location.href);
              }


              $.ajax({
                type: "POST",
                url: shareWithFriendEndpoint,
                data: {
                  access_token: IB_ACCESS_TOKEN,
                  flex_credentials: Cookies.get("ib_lead_token"),
                  form_data: formData
                },
                success: function (response) {
                  // ...
                }
              });

              $("#ib-email-to-friend").removeClass("ib-md-active");
              $("#ib-email-thankyou").addClass("ib-md-active");
            });
        });
      }
    } else { // regular recaptcha
      grecaptcha.ready(function () {
        grecaptcha
          .execute(__flex_g_settings.google_recaptcha_public_key, { action: 'share_property_with_friend' })
          .then(function (token) {
            _self.prepend('<input type="hidden" name="recaptcha_response" value="' + token + '">');

            var formData = _self.serialize();
            var mlsNumber = _self.find("input[name='mls_number']:eq(0)").val();
            var shareWithFriendEndpoint = __flex_idx_filter_regular.shareWithFriendEndpoint.replace(/{{mlsNumber}}/g, mlsNumber);

            $.ajax({
              type: "POST",
              url: shareWithFriendEndpoint,
              data: {
                access_token: IB_ACCESS_TOKEN,
                flex_credentials: Cookies.get("ib_lead_token"),
                form_data: formData
              },
              success: function (response) {
                // ...
              }
            });

            $("#ib-email-to-friend").removeClass("ib-md-active");
            $("#ib-email-thankyou").addClass("ib-md-active");
          });
      });
    }
  });

  // print screen
  IB_MODAL_WRAPPER.on("click", ".ib-psprint", function () {
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
  IB_MODAL_WRAPPER.on("submit", ".ib-propery-inquiry-f", function (event) {
    event.preventDefault();

    var formData = $(this).serialize();

    console.log(formData);
    console.log('handle share property');

    // @todo save property inquiry
    var mlsNumber = $(this).find("input[name='mls_number']:eq(0)").val();
    var requestInformationEndpoint = __flex_idx_filter_regular.requestInformationEndpoint.replace(/{{mlsNumber}}/g, mlsNumber);
    console.log(requestInformationEndpoint);

    $.ajax({
      type: "POST",
      url: requestInformationEndpoint,
      data: {
        access_token: IB_ACCESS_TOKEN,
        flex_credentials: Cookies.get("ib_lead_token"),
        form_data: formData
      },
      success: function (response) {
        // ...
      }
    });

    $(".ib-propery-inquiry-f:eq(0)").trigger("reset");
    $("#ib-email-thankyou").addClass("ib-md-active");
  });

  // handle slider switch fullscreen
  IB_MODAL_WRAPPER.on("click", ".ib-btnfs", function () {
    if (typeof IB_MODAL_SLIDER !== "undefined") {
      IB_MODAL_SLIDER.fullscreen('in');
    }
  });

  // handle accordion
  IB_MODAL_WRAPPER.on("click", ".ib-paitem", function () {
    $(this).toggleClass("ib-pai-active");
  });

  // handle switch photos, map view, video
  IB_MODAL_WRAPPER.on("click", ".ib-pvitem", function (event) {
    var tabToOpen = $(this).data("id");

    if ($(this).hasClass("ib-pvi-active") || ("video" == tabToOpen)) {
      return;
    }

    $(this).parent().find(">li").removeClass("ib-pvi-active");
    $(this).addClass("ib-pvi-active");

    $(this).parent().parent().parent().removeClass('ib-pva-photos ib-pva-map').addClass('ib-pva-' + tabToOpen);

    switch (tabToOpen) {
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

          function handleSatelliteButton(event) {
            event.stopPropagation();
            event.preventDefault();
            map.setMapTypeId(google.maps.MapTypeId.HYBRID)

            if ($(this).hasClass("is-active")) {
              $(this).removeClass("is-active");
              map.setMapTypeId(google.maps.MapTypeId.ROADMAP)
            } else {
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
