(function ($) {

var ib_mini_search_condos;
var ib_mini_search_homes;
var ib_mini_search_filter_area;
var ib_mini_building_search;

$(function() {
  //  dom ready
  ib_mini_search_condos = $("#ib-mini-search-condos");
  ib_mini_search_homes = $("#ib-mini-search-homes");
  ib_mini_search_filter_area = $("#cbo_filter_by_area2");
  ib_mini_building_search = $("#cbo_filter_name, #cbo_building_top");


  if (ib_mini_search_condos.length) {
    ib_mini_search_condos.on("submit", function(e) {
      e.preventDefault();

      var data = $(this).serializeArray();
      var formData = _.object(_.pluck(data, 'name'), _.pluck(data, 'value'));
      var redirectToUrl = __flex_g_settings.searchUrl;

      redirectToUrl += ("1" == formData.rental) ? "?for=rent&type=condo" : "?for=sale&type=condo";

      if ("--" != formData.city) {
        redirectToUrl += "&keyword=" + encodeURIComponent(formData.city + "_city");
      }

      window.location.href = redirectToUrl;
    });
  }

  
    ib_mini_building_search.on("change",function(e){
      e.preventDefault();
      if ("--" != $(this).val()) {
        window.location.href = $(this).val();
      }
    });

  if (ib_mini_search_filter_area.length) {
    ib_mini_search_filter_area.on("change",function(e){
      e.preventDefault();
      var redirectToUrl = __flex_g_settings.searchUrl;
      if ("--" != $(this).val()) {
        redirectToUrl += "?keyword=" + encodeURIComponent($(this).val() + "_city");
      }

      window.location.href = redirectToUrl;
    });
  }
  

  if (ib_mini_search_homes.length) {
    ib_mini_search_homes.on("submit", function(e) {
      e.preventDefault();

      var data = $(this).serializeArray();
      var formData = _.object(_.pluck(data, 'name'), _.pluck(data, 'value'));
      var redirectToUrl = __flex_g_settings.searchUrl;

      redirectToUrl += ("1" == formData.rental) ? "?for=rent&type=house" : "?for=sale&type=house";

      if ("--" != formData.city) {
        redirectToUrl += "&keyword=" + encodeURIComponent(formData.city + "_city");
      }

      window.location.href = redirectToUrl;
    });
  }
});

})(jQuery);