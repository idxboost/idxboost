(function ($) {
  var idxboost_quick_search_input;
  var idxboost_quick_search_form;
  var baths_slider;
  var beds_slider;
  var price_sale_slider;
  var price_rent_slider;
  var baths_slider_values;
  var beds_slider_values;
  var price_rent_slider_values;
  var price_sale_slider_values;
  var xhr_running = false;

  function flex_q_refresh_search()
  {
    if (false === xhr_running) {
      return;
    }

    $.ajax({
      url: __flex_g_settings.ajaxUrl,
      method: "POST",
      data: idxboost_quick_search_form.serialize(),
      dataType: "json",
      success: function(response) {
        if (response.total > 0) {
            window.location.href = __flex_g_settings.searchUrl + "/" + response.uri
        }

        // console.dir(response);
      }
    });
  }

  $(function() {
    idxboost_quick_search_input = $("#idxboost_quick_search_input");
    idxboost_quick_search_form = $(".idxboost-quick-search-form:eq(0)");

    baths_slider_values = _.pluck(__flex_g_settings.params.baths_range, 'value');
    beds_slider_values = _.pluck(__flex_g_settings.params.beds_range, 'value');
    price_rent_slider_values = _.pluck(__flex_g_settings.params.price_rent_range, 'value');
    price_sale_slider_values = _.pluck(__flex_g_settings.params.price_sale_range, 'value');

    baths_slider = $(".idxboost-qs-baths-slider:eq(0)");
    beds_slider = $(".idxboost-qs-beds-slider:eq(0)");
    price_sale_slider = $(".idxboost-qs-price-sale-slider:eq(0)");
    price_rent_slider = $(".idxboost-qs-price-rent-slider:eq(0)");

    $(".idxboost-qsearch-rental:eq(0)").on("change", function() {
      var currentValue = this.value;
      $("#idx_q_rental").val(currentValue);
      $(".idxboost-slider-price-range").hide();

      if (1 == currentValue) {
          $(".idxboost-slider-price-rent-range").show();
      } else {
        $(".idxboost-slider-price-sale-range").show();
      }
    });

    $(".idxboost-qsearch-ptype:eq(0)").on("change", function() {
      var currentValue = this.value;
      $("#idx_q_property_type").val(currentValue);
    });

    if (baths_slider.length) {
      baths_slider.slider({
          range: true,
          min: 0,
          max: baths_slider_values.length - 1,
          step: 1,
          slide: function(event, ui) {
              var min_val = ui.values[0];
              var max_val = ui.values[1];
              var xValue;
              var yValue;

              var startValue = $('#idx_q_min_baths').val() === '--' ? 0 : baths_slider_values.indexOf(min_val);
              var endValue = $('#idx_q_max_baths').val() === '--' ? (baths_slider_values.length - 1) : baths_slider_values.indexOf(max_val);

              xValue = __flex_g_settings.params.baths_range[startValue].label;
              yValue = __flex_g_settings.params.baths_range[endValue].label + " Baths";

              console.log('slide beds: ' + xValue + " - " + yValue);
              $(".idxboost-slider-baths-label").html(xValue + " - " + yValue);
          },
          create: function(event, ui) {
              var min_val = $('#idx_q_min_baths').val() === '--' ? baths_slider_values[0] : parseFloat($('#idx_q_min_baths').val(), 10);
              var max_val = $('#idx_q_max_baths').val() === '--' ? baths_slider_values[baths_slider_values.length - 1] : parseFloat($('#idx_q_max_baths').val(), 10);
              var _self = $(this);
              var xValue;
              var yValue;
              var startValue = $('#idx_q_min_baths').val() === '--' ? 0 : baths_slider_values.indexOf(min_val);
              var endValue = $('#idx_q_max_baths').val() === '--' ? (baths_slider_values.length - 1) : baths_slider_values.indexOf(max_val);
              _self.slider('values', [startValue, endValue]);

              xValue = __flex_g_settings.params.baths_range[startValue].label;
              yValue = __flex_g_settings.params.baths_range[endValue].label + " Baths";

              console.log('create baths: ' + xValue + " - " + yValue);
              $(".idxboost-slider-baths-label").html(xValue + " - " + yValue);
          },
          change: function(event, ui) {
              var startValue = ui.values[0];
              var endValue = ui.values[1];
              var initialStartValue = (baths_slider_values[startValue] == baths_slider_values[0]) ? '--' : baths_slider_values[startValue];
              var initialEndValue = (baths_slider_values[endValue] == baths_slider_values[baths_slider_values.length - 1]) ? '--' : baths_slider_values[endValue];
              $('#idx_q_min_baths').val(initialStartValue);
              $('#idx_q_max_baths').val(initialEndValue);
              if (xhr_running === true) {
                  $('#idx_q_page').val(1);
              }

              console.log('slide baths: ' + initialStartValue + ' - ' + initialEndValue);
              // do ajax
              // flex_q_refresh_search();
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
              var min_val = ui.values[0];
              var max_val = ui.values[1];

              var startValue = $('#idx_q_min_beds').val() === '--' ? 0 : beds_slider_values.indexOf(min_val);
              var endValue = $('#idx_q_max_beds').val() === '--' ? (beds_slider_values.length - 1) : beds_slider_values.indexOf(max_val);

              xValue = __flex_g_settings.params.beds_range[startValue].label;
              yValue = __flex_g_settings.params.beds_range[endValue].label + " Beds";

              console.log('slide beds: ' + xValue + " - " + yValue);
              $(".idxboost-slider-beds-label").html(xValue + " - " + yValue);
          },
          create: function(event, ui) {
              var min_val = $('#idx_q_min_beds').val() === '--' ? beds_slider_values[0] : parseInt($('#idx_q_min_beds').val(), 10);
              var max_val = $('#idx_q_max_beds').val() === '--' ? beds_slider_values[beds_slider_values.length - 1] : parseInt($('#idx_q_max_beds').val(), 10);
              var _self = $(this);
              var xValue;
              var yValue;
              var startValue = $('#idx_q_min_beds').val() === '--' ? 0 : beds_slider_values.indexOf(min_val);
              var endValue = $('#idx_q_max_beds').val() === '--' ? (beds_slider_values.length - 1) : beds_slider_values.indexOf(max_val);
              _self.slider('values', [startValue, endValue]);

              xValue = __flex_g_settings.params.beds_range[startValue].label;
              yValue = __flex_g_settings.params.beds_range[endValue].label + " Beds ";

              console.log('create beds: ' + xValue + " - " + yValue);
              $(".idxboost-slider-beds-label").html(xValue + " - " + yValue);
          },
          change: function(event, ui) {
              var startValue = ui.values[0];
              var endValue = ui.values[1];
              var initialStartValue = (beds_slider_values[startValue] == beds_slider_values[0]) ? '--' : beds_slider_values[startValue];
              var initialEndValue = (beds_slider_values[endValue] == beds_slider_values[beds_slider_values.length - 1]) ? '--' : beds_slider_values[endValue];
              $('#idx_q_min_beds').val(initialStartValue);
              $('#idx_q_max_beds').val(initialEndValue);
              if (xhr_running === true) {
                  $('#idx_q_page').val(1);
              }
              // do ajax
              // flex_q_refresh_search();
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
              var xPrice;
              var yPrice;

              xPrice = '$' + _.formatPrice(price_sale_slider_values[startValue]);

              if (endValue == 48) {
                   yPrice = 'Any Price'
              } else {
                  yPrice = '$' + _.formatPrice(price_sale_slider_values[endValue]);
              }

              $('#price_from').val(xPrice);
              $('#price_to').val(yPrice);

              console.log('slide sale: ' + xPrice + ' - ' + yPrice);
              $(".idxboost-slider-price-sale-label").html(xPrice + ' - ' + yPrice);
          },
          create: function(event, ui) {
              var min_val = $('#idx_q_min_price_sale').val() === '--' ? price_sale_slider_values[0] : parseInt($('#idx_q_min_price_sale').val(), 10);
              var max_val = $('#idx_q_max_price_sale').val() === '--' ? price_sale_slider_values[price_sale_slider_values.length - 1] : parseInt($('#idx_q_max_price_sale').val(), 10);
              var _self = $(this);
              var xPrice;
              var yPrice;
              var startValue = $('#idx_q_min_price_sale').val() === '--' ? 0 : price_sale_slider_values.indexOf(min_val);
              var endValue = $('#idx_q_max_price_sale').val() === '--' ? (price_sale_slider_values.length - 1) : price_sale_slider_values.indexOf(max_val);
              _self.slider('values', [startValue, endValue]);

              xPrice = '$' + _.formatPrice(min_val);

              if (100000000 == max_val) {
                  yPrice = 'Any Price';
              } else {
                  yPrice = "$" + _.formatPrice(max_val);
              }

              $('#price_from').val(xPrice);
              $('#price_to').val(yPrice);

              console.log('create sale: ' + xPrice + ' - ' + yPrice);
              $(".idxboost-slider-price-sale-label").html(xPrice + ' - ' + yPrice);
          },
          change: function(event, ui) {
              var startValue = ui.values[0];
              var endValue = ui.values[1];
              $('#idx_q_min_price_sale').val(price_sale_slider_values[startValue]);
              $('#idx_q_max_price_sale').val(price_sale_slider_values[endValue]);
              if (xhr_running === true) {
                  $('#idx_q_page').val(1);
              }
              // do ajax
              //flex_q_refresh_search();
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
              var xPrice;
              var yPrice;

              xPrice = "$" + _.formatPrice(price_rent_slider_values[startValue]);

              if (endValue == 30) {
                yPrice = "Any Price";
              } else {
                yPrice = "$" + _.formatPrice(price_rent_slider_values[endValue]);
              }

              $('#price_rent_from').val(xPrice);
              $('#price_rent_to').val(yPrice);

              console.log('slide rent: ' + xPrice + ' - ' + yPrice);
              $(".idxboost-slider-price-rent-label").html(xPrice + ' - ' + yPrice);
          },
          create: function(event, ui) {
              var _self = $(this);
              var xPrice;
              var yPrice;
              var min_val = $('#idx_q_min_price_rent').val() === '--' ? price_rent_slider_values[0] : parseInt($('#idx_q_min_price_rent').val(), 10);
              var max_val = $('#idx_q_max_price_rent').val() === '--' ? price_rent_slider_values[price_rent_slider_values.length - 1] : parseInt($('#idx_q_max_price_rent').val(), 10);
              var startValue = $('#idx_q_min_price_rent').val() === '--' ? 0 : price_rent_slider_values.indexOf(min_val);
              var endValue = $('#idx_q_max_price_rent').val() === '--' ? (price_rent_slider_values.length - 1) : price_rent_slider_values.indexOf(max_val);
              _self.slider('values', [startValue, endValue]);

              xPrice = '$' + _.formatPrice(min_val);

              if (100000 == max_val) {
                  yPrice = "Any Price";
              } else {
                  yPrice = "$" + _.formatPrice(max_val);
              }

              $('#price_rent_from').val(xPrice);
              $('#price_rent_to').val(yPrice);

              console.log('create rent: ' + xPrice + ' - ' + yPrice);
              $(".idxboost-slider-price-rent-label").html(xPrice + ' - ' + yPrice);
          },
          change: function(event, ui) {
              var startValue = ui.values[0];
              var endValue = ui.values[1];
              $('#idx_q_min_price_rent').val(price_rent_slider_values[startValue]);
              $('#idx_q_max_price_rent').val(price_rent_slider_values[endValue]);
              if (xhr_running === true) {
                  $('#idx_q_page').val(1);
              }

              // do ajax
              // flex_q_refresh_search();
          }
      });
    }

    if (idxboost_quick_search_form.length) {
      idxboost_quick_search_form.on("submit", function(event) {
        event.preventDefault();

        // do ajax
        flex_q_refresh_search();
      });
    }

    if (idxboost_quick_search_input.length) {
      idxboost_quick_search_input.autocomplete({
          source: function(request, response) {
              $.getJSON("https://autocomplete.flexidx.com", request, function(data, status, xhr) {
                  response(data);
              });
          },
          minLength: 3,
          select: function(event, ui) {
              var val_exp = ui.item.id.split(/\|/);
              var keywordValue = val_exp[0];
              var keywordType = val_exp[1];
              // var keywordFinalValue = encodeURIComponent(keywordValue + "|" + keywordType);
              var keywordFinalValue = keywordValue + "|" + keywordType;
              $('#idx_q_keyword').val(keywordFinalValue);
              $('#idx_q_page').val(1);

              // do ajax
              // flex_q_refresh_search();
          },
          close: function(event, ui) {
              var _self = $(this);
          },
          create: function( event, ui ) {
              $(this).attr('autocomplete', 'disabled');
          }
      });

      idxboost_quick_search_input.on("change", function() {
        if ("" === this.value) {
          $('#idx_q_keyword').val("");
        }
      });
    }

    xhr_running = true;
  });
})(jQuery);
