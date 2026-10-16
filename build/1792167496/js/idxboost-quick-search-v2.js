(function ($) {

// Fill Any Value for Sliders
__ib_quick_search.priceSaleValues.push({ label: word_translate.any_price, value: "--" });
__ib_quick_search.priceRentValues.push({ label: word_translate.any_price, value: "--" });

var ib_quick_search_form;
var ib_quick_search_rental_switch;
var ib_quick_search_types_switch;
var ib_quick_search_price_lbl;

ib_quick_search_price_lbl = $("#ib-quick-search-price-range-lbl");

var ib_quick_search_rent_slider;
var ib_quick_search_rent_values = _.pluck(__ib_quick_search.priceRentValues, "value");

var ib_quick_search_sale_slider;
var ib_quick_search_sale_values = _.pluck(__ib_quick_search.priceSaleValues, "value");

$(function() {

// Handle for Sale Slider
ib_quick_search_rent_slider = $("#ib-quick-search-price-range-rent");

if (ib_quick_search_rent_slider.length) {
    ib_quick_search_rent_slider.slider({
        range: true,
        min: 0,
        max: ib_quick_search_rent_values.length - 1,
        step: 1,
        values: [0, ib_quick_search_rent_values.length - 1],
        slide: function(event, ui) {
            // console.log(ui.values);

            var min = ib_quick_search_rent_values[ui.values[0]];
            var max = ib_quick_search_rent_values[ui.values[1]];

            // console.log({ min, max });

            var values = [];

            values.push( (isNaN(min) ? word_translate.any_price : "$" + _.formatShortPrice(min)) );
            values.push( (isNaN(max) ? word_translate.any_price_max : "$" + _.formatShortPrice(max)) );

            if (
                ( "0" == min && "--" == max ) ||
                ( "0" == min && "0" == max ) ||
                ( "--" == min && "--" == max )
            ) {
                ib_quick_search_price_lbl.html(word_translate.any_price);
                $("#ib-quick-search-rent-values").val("");
            } else {
                ib_quick_search_price_lbl.html(values.join(" - "));
                
                if ( (!isNaN(min) && isNaN(max)) ) {
                    $("#ib-quick-search-rent-values").val(min + "-");
                } else {
                    $("#ib-quick-search-rent-values").val(min + "-" + max);
                }
            }
        }
    });
}

// Handle for Rent Slider
ib_quick_search_sale_slider = $("#ib-quick-search-price-range-sale");

if (ib_quick_search_sale_slider.length) {
    ib_quick_search_sale_slider.slider({
        range: true,
        min: 0,
        max: ib_quick_search_sale_values.length - 1,
        step: 1,
        values: [0, ib_quick_search_sale_values.length - 1],
        slide: function(event, ui) {
            // console.log(ui.values);

            var min = ib_quick_search_sale_values[ui.values[0]];
            var max = ib_quick_search_sale_values[ui.values[1]];

            // console.log({ min, max });

            var values = [];

            values.push( (isNaN(min) ? word_translate.any_price : "$" + _.formatShortPrice(min)) );
            values.push( (isNaN(max) ? word_translate.any_price_max : "$" + _.formatShortPrice(max)) );

            if (
                ( "0" == min && "--" == max ) ||
                ( "0" == min && "0" == max ) ||
                ( "--" == min && "--" == max )
            ) {
                ib_quick_search_price_lbl.html(word_translate.any_price);
                $("#ib-quick-search-sale-values").val("");
            } else {
                ib_quick_search_price_lbl.html(values.join(" - "));
                
                if ( (!isNaN(min) && isNaN(max)) ) {
                    $("#ib-quick-search-sale-values").val(min + "-");
                } else {
                    $("#ib-quick-search-sale-values").val(min + "-" + max);
                }
            }
        }
    });
}

// Handle Switch for Rental Type
ib_quick_search_rental_switch = $("#ib-quick-search-rental-type");

if (ib_quick_search_rental_switch.length) {
    ib_quick_search_rental_switch.on("change", function() {
        var values;

        if (1 == this.value) { 
            // for rent
            $("#ib-quick-search-price-range-sale").hide();
            $("#ib-quick-search-price-range-rent").show();

            values = $("#ib-quick-search-rent-values").val().split("-");
        } else {
            // for sale
            $("#ib-quick-search-price-range-rent").hide();
            $("#ib-quick-search-price-range-sale").show();

            values = $("#ib-quick-search-sale-values").val().split("-");
        }

        if (1 === values.length) {
            ib_quick_search_price_lbl.html(word_translate.any_price);
        } else {
            if ("" === values[1]) {
                ib_quick_search_price_lbl.html("$" + _.formatShortPrice(values[0]) + " - "+word_translate.any_price);
            } else {
                ib_quick_search_price_lbl.html("$" + _.formatShortPrice(values[0]) + " - " + "$" + _.formatShortPrice(values[1]));
            }
        }
        idx_quiz_search();
    });
}

// Handle Switch for Property Types
ib_quick_search_types_switch = $(".ib-quick-search-types");

if (ib_quick_search_types_switch.length) {
    ib_quick_search_types_switch.on("change", function() {
        var catch_types = [];

        ib_quick_search_types_switch.each(function () {
            if (this.checked) {
                catch_types.push(this.value);
            }
        });

        $("#ib-quick-search-type-values").val(catch_types.join(","));
    });
}

// Handle Form Submission
ib_quick_search_form = $("#__ib_quick_search_form");

if (ib_quick_search_form.length) {
    ib_quick_search_form.on("submit", function(event) {
        var property_types;
        var catch_types = [];
        var query_values = [];

        // console.log(ib_quick_search_rental_switch.val())
        event.preventDefault();

        if (1 == ib_quick_search_rental_switch.val()) {
            // for rent
            query_values.push("for=rent");
        }

        // console.log($("#ib-quick-search-type-values").val().length);

        if ($("#ib-quick-search-type-values").val().length) {
            property_types = $("#ib-quick-search-type-values").val().split(",");
        }

        if ($.inArray("2", property_types) !== -1) {
            catch_types.push("house");
        }

        if ($.inArray("1", property_types) !== -1) {
            catch_types.push("condo");
        }

        if ($.inArray("tw", property_types) !== -1) {
            catch_types.push("multifamily");
        }

        if ($.inArray("mf", property_types) !== -1) {
            catch_types.push("multifamily");
        }

        if (catch_types.length && catch_types.length !== ib_quick_search_types_switch.length) {
            query_values.push("type=" + catch_types.join(","));
            catch_types.length = 0;
        }

        if ("--" !== $("#ib-quick-search-city").val()) {
            query_values.push("keyword=" + encodeURIComponent($("#ib-quick-search-city").val() + "_city") );
        }

        if (1 == ib_quick_search_rental_switch.val()) {
            // for rent
            if ($("#ib-quick-search-rent-values").val().length) {
                query_values.push("price=" + $("#ib-quick-search-rent-values").val());
            }
        } else {
            // for sale
            if ($("#ib-quick-search-sale-values").val().length) {
                query_values.push("price=" + $("#ib-quick-search-sale-values").val());
            }
        }

        if (query_values.length) {
            window.location.href = __ib_quick_search.searchUrl + "?" + query_values.join("&");
        } else {
            window.location.href = __ib_quick_search.searchUrl;
        }

        // search/?for=rent&type=house,condo,townhouse&keyword=Aventura_city&price=4000-50000
        // search/?type=house,condo,multifamily&keyword=Aventura_city&price=750000-30000000
    });
}

function idx_quiz_search(){
      $('#ib-quick-search-price-range-rent span').each(function(indexq){
        if(indexq==0)
        $(this).attr('data-text',$('.idx_txt_min_slider').val());
        if(indexq==1)
        $(this).attr('data-text',$('.idx_txt_max_slider').val());
      });      

      $('#ib-quick-search-price-range-sale span').each(function(indexq){
        if(indexq==0)
        $(this).attr('data-text',$('.idx_txt_min_slider').val());
        if(indexq==1)
        $(this).attr('data-text',$('.idx_txt_max_slider').val());
      });     
}

// console.dir(__ib_quick_search);
  $(document).on('ready',function(){
    idx_quiz_search();
  });

  $(document).on("click",function(e) {
    var container = $(".ib-quick-search-nav-item");
    if (!container.is(e.target) && container.has(e.target).length === 0) { 
      $('.ib-quick-search-nav-item.ib-active').removeClass('ib-active');
      $('.ib-quick-search-nav').removeClass('ib-open');      
    }

  });

  $(".ib-arrow").on("click", function(event) {
    if ($(this).parents('.ib-quick-search-nav-item').hasClass('ib-active')) {
     $('.ib-quick-search-nav-item.ib-active').removeClass('ib-active');
     $('.ib-quick-search-nav').removeClass('ib-open');
    }else{
      $('.ib-quick-search-nav-item.ib-active').removeClass('ib-active');
      $(this).parents('.ib-quick-search-nav-item').addClass('ib-active');
      $('.ib-quick-search-nav').addClass('ib-open');
    }
  });
});

})(jQuery);