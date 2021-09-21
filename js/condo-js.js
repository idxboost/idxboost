(function($) {
    var chart_container_obj;

    // handle inquiry building form
    var flex_idx_contact_form;

    $(function() {
var lead_data=[];

        flex_idx_contact_form = $(".flex_idx_building_form");
        if (flex_idx_contact_form.length) {
            flex_idx_contact_form.on("submit", function(event) {
                event.preventDefault();
                var _self = $(this);
                var contactSubmitData = _self.serialize();
                var contactbuildingArray =_self.serializeArray();
                $.ajax({
                    url: __flex_g_settings.ajaxUrl,
                    type: "POST",
                    data: contactSubmitData,
                    dataType: "json",
                    success: function(response) {
                        if (response.success) {
                            var obj_email=contactbuildingArray.map(function(e) { return e.name; }).indexOf("email");
                            var obj_first_name=contactbuildingArray.map(function(e) { return e.name; }).indexOf("first_name");
                            var obj_last_name=contactbuildingArray.map(function(e) { return e.name; }).indexOf("last_name");

                            if (obj_email !=-1)
                                lead_data['email']=contactbuildingArray[obj_email].value;

                            if (obj_first_name !=-1)
                                lead_data['first_name']=contactbuildingArray[obj_first_name].value;

                            if (obj_last_name !=-1)
                                lead_data['last_name']=contactbuildingArray[obj_last_name].value;

                            idx_auto_save_building(lead_data);
                            _self.trigger('reset');
                            $('#modal_properties_send').addClass('active_modal');
                            setTimeout(function() {
                                $('#modal_properties_send').find('.close').click();
                            }, 2000);
                        }
                    }
                });
            });
        }

    });

})(jQuery);
