(function($) {
$(function() {
    if ("no" === __flex_g_settings.anonymous) {
        $.ajax({
            type: "POST",
            url: __track_building_view.updateEventUri,
            data: {
                "type": "lead_building_view",
                "name": $("#page_title").data("building-name"),
                "address": $("#page_title").data("building-address"),
                "city": $("#page_title").data("building-city"),
                "access_token": __flex_g_settings.accessToken,
                "lead_token": Cookies.get("ib_lead_token"),
                "source_url": location.href
            },
            success: function(response) {
                console.dir(response);
            }
        });
    }
});
})(jQuery);