(function ($) {

var ib_mini_search_condos;
var ib_mini_search_homes;

$(function() {
  //  dom ready
  ib_mini_search_condos = $("#ib-mini-search-condos");
  ib_mini_search_homes = $("#ib-mini-search-homes");

  if (ib_mini_search_condos.length) {
    ib_mini_search_condos.on("submit", function(e) {
      e.preventDefault();

      var data = $(this).serializeArray();
      var formData = _.object(_.pluck(data, 'name'), _.pluck(data, 'value'));
      var redirectToUrl = __flex_g_settings.searchUrl;

      redirectToUrl += ("1" == formData.rental) ? "/condos-for~rent" : "/condos-for~sale";

      if ("--" != formData.city) {
        redirectToUrl += "/keywords-" + encodeURIComponent(formData.city + "|city");
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

      redirectToUrl += ("1" == formData.rental) ? "/SingleFamilyHomes-for~rent" : "/SingleFamilyHomes-for~sale";

      if ("--" != formData.city) {
        redirectToUrl += "/keywords-" + encodeURIComponent(formData.city + "|city");
      }

      window.location.href = redirectToUrl;
    });
  }
});

})(jQuery);
