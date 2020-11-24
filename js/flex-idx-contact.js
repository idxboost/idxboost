(function ($) {

var contact_form;

$(function () {
    // dom ready
    contact_form = $("#flex-idx-contact-form");

    if (contact_form.length) {
        contact_form.on("submit", function(event) {
            event.preventDefault();
            var _self = $(this);

            // code...
            $.ajax({
                url: flex_idx_contact_form.ajaxUrl,
                method: "POST",
                data: _self.serialize(),
                dataType: "json",
                success: function(data) {
                    alert(data.message);

                    // clean form
                    _self.trigger('reset');
                }
            });
        });
    }
});


    // map
    google.maps.event.addDomListener(window, "load", function() {
        
    var style_map=[];

    if(style_map_idxboost != undefined && style_map_idxboost != '') {
        style_map=JSON.parse(style_map_idxboost);
    }


        var flex_map_mini_view = $("#map");
        if (flex_map_mini_view.length) {
            var myLatLng2 = {
                lat: parseFloat(flex_map_mini_view.data('lat')),
                lng: parseFloat(flex_map_mini_view.data('lng'))
            };
            var miniMap = new google.maps.Map(document.getElementById('map'), {
                zoom: 16,
                center: myLatLng2,
                styles: style_map
            });
            var marker = new google.maps.Marker({
                position: myLatLng2,
                map: miniMap,
                icon: '/wp-content/themes/minimalib/images/free-theme/marker.png'
            });
            $("#map").removeAttr("data-lat").removeAttr("data-lng");
        }
    });

})(jQuery);
