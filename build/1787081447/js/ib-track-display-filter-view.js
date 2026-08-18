(function($) {
    $(function() {
        if ("no" === __flex_g_settings.anonymous) {
            $.ajax({
                type: "POST",
                url: __track_display_filter_view.updateEventUri,
                data: {
                    "type": "lead_display_filter_view",
                    "name": filter_metadata.title,
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