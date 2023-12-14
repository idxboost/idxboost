/**
 * Created by Max on 1/6/2017.
 */

(function ($) {

var flex_idx_verify_credentials;
var flex_idx_import_settings;
var flex_idx_xhr_status = false;

var flex_idx_omit_import_settings;

$(function() {
    flex_idx_verify_credentials = $("#flex_idx_verify_credentials");
    flex_idx_import_settings = $("#flex_idx_import_settings");
    flex_idx_client_form  = $("#flex_idx_client_form");

    flex_idx_omit_import_data = $("#flex_idx_omit_import_data");

    if (flex_idx_omit_import_data.length) {
      flex_idx_omit_import_data.on("click", function(event) {
        event.preventDefault();

        $.ajax({
            url: flex_idx_admin_js.ajaxUrl,
            method: "POST",
            data: {
              action: "flex_skip_importdata"
            },
            dataType: "json",
            success: function(data) {
              location.reload();
            }
        });
      });
    }

    if (flex_idx_verify_credentials.length) {
        flex_idx_verify_credentials.on("click", function(event) {
            event.preventDefault();

            if (flex_idx_xhr_status === false) {
                flex_idx_xhr_status = true;

                $.ajax({
                    url: flex_idx_admin_js.ajaxUrl,
                    method: "POST",
                    data: flex_idx_client_form.serialize(),
                    dataType: "json",
                    success: function(data) {
                        if (data.success === false) {
                            $("#flex-idx-status").html('<p class="flex-idx-admin-message flex-idx-admin-message-error">' + data.message + '</p>');
                        } else {
                            $("#flex-idx-status").html('<p class="flex-idx-admin-message flex-idx-admin-message-success">Successfully logged in with credentials, please visit <a href="'+flex_idx_admin_js.documentationurl+'">documentation page</a> to configure.</p>');
                        }

                        flex_idx_xhr_status = false;
                        Cookies.remove("_ib_left_click_force_registration");
                    }
                });
            }
        });
    }

    $("#flex_idx_import_data").on("click", function() {
        var _self = $(this);

        if (_self.hasClass("flex-importing-data")) {
            return;
        }

        _self
            .html("Importing data...")
            .prop('disabled', true)
            .addClass('flex-importing-data');

        $.ajax({
            url: flex_idx_admin_js.ajaxUrl,
            method: "POST",
            data: {
                action: "flex_importdata"
            },
            dataType: "json",
            success: function(data) {
                _self.html("Imported Sucessfully");
                    // .prop("disabled", false)
                    // .removeClass("flex-importing-data");
            }
        });
    });
});

})(jQuery);
