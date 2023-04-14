
(function ($) {
var idx_button_tools;

    idx_button_tools = $("#idx_button_tools");

        $("#flex_idx_client_tools_form").on("submit", function(event) {
            event.preventDefault();

            if (flex_idx_xhr_status === false) {
                flex_idx_xhr_status = true;

                $.ajax({
                    url: idx_admin_tools.ajaxUrl,
                    method: "POST",
                    data: $(this).serialize(),
                    dataType: "json",
                    success: function(data) {
                        if (data.success === false) {
                            $("#flex-idx-status").html('<p class="flex-idx-admin-message flex-idx-admin-message-success">Successfully logged in with credentials.</p>');
                        }
                        flex_idx_xhr_status = false;
                    }
                });
            }
        });

})(jQuery);
