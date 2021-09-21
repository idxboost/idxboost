(function($) {
    // handle inquiry contact form
    var flex_idx_contact_form;
    
    $(function () {
        // dom ready
        var idForm=[];
        for(i=0;i<$('.idx_id_form').length;i++){
            idForm.push('#'+$('.idx_id_form').eq(i).val());
        }
        
        flex_idx_contact_form = $(idForm.join(', '));

        if (flex_idx_contact_form.length) {
            flex_idx_contact_form.on("submit", function(event) {
                event.preventDefault();

                var _self = $(this);
                $('.idx_contact_email').val( $('.idx_contact_email_temp').val());

                var contactSubmitData = _self.serialize();

                $.ajax({
                    url: __flex_g_settings.ajaxUrl,
                    type: "POST",
                    data: contactSubmitData,
                    dataType: "json",
                    success: function(response) {
                        console.log(response);
                        if (response.success) {
                            _self.trigger('reset');
                            sweetAlert(word_translate.email_sent, word_translate.your_email_was_sent_succesfully, "success");
                        }
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

            var idx_zoom=16;
            if(flex_map_mini_view.data('zoom') != '' && flex_map_mini_view.data('zoom') != undefined){
                idx_zoom=flex_map_mini_view.data('zoom');
            }
            console.log(idx_zoom);

            var myLatLng2 = {
                lat: parseFloat(flex_map_mini_view.data('lat')),
                lng: parseFloat(flex_map_mini_view.data('lng'))
            };
            var miniMap = new google.maps.Map(document.getElementById('map'), {
                zoom: idx_zoom,
                styles: style_map,
                center: myLatLng2
            });
            var marker = new google.maps.Marker({
                position: myLatLng2,
                map: miniMap,
                icon: flex_idx_contact.idxboost_uri+'images/marker.png'
            });
            $("#map").removeAttr("data-lat").removeAttr("data-lng");
        }
    });
})(jQuery);