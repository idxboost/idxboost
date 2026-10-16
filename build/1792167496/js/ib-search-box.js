/*!
 * jQuery serializeObject - v0.2 - 1/20/2010
 * http://benalman.com/projects/jquery-misc-plugins/
 * 
 * Copyright (c) 2010 "Cowboy" Ben Alman
 * Dual licensed under the MIT and GPL licenses.
 * http://benalman.com/about/license/
 */

// Whereas .serializeArray() serializes a form into an array, .serializeObject()
// serializes a form into an (arguably more useful) object.

(function($,undefined){
    '$:nomunge'; // Used by YUI compressor.
  
    $.fn.serializeObject = function(){
      var obj = {};
  
      $.each( this.serializeArray(), function(i,o){
        var n = o.name,
          v = o.value;
  
          obj[n] = obj[n] === undefined ? v
            : $.isArray( obj[n] ) ? obj[n].concat( v )
            : [ obj[n], v ];
      });
  
      return obj;
    };
  
  })(jQuery);

(function ($) {
var ib_search_box_form;

function redirect_to(params)
{
    var url_to_redirect = "";

    url_to_redirect += "for=" + params.for;

    url_to_redirect += "&type=" + params.type;

    if ("" !== params.city) {
        url_to_redirect += "&keyword=" + encodeURIComponent(params.city) + "_city";
    }

    window.location.href = __flex_g_settings.searchUrl + "/?" + url_to_redirect;
}

$(function() {
    ib_search_box_form = $(".ib-search-box-form");

    if (ib_search_box_form.length) {
        ib_search_box_form.on("submit", function(event) {
            event.preventDefault();
            // http://idxboost.demo/search/?for=rent&type=condo&keyword=Aventura_city

            var data = $(this).serializeObject();
            redirect_to(data);
        });
    }
});

})(jQuery);