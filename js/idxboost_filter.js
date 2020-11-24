(function($) {

$(function() {

        $("#form-save").on("submit", function(event) {
            var arragle_notification_type = [];
            $('input[name="notification_type[]"]:checked').each(function() {
                arragle_notification_type.push(this.value);
            });
            event.preventDefault();
            var name = $('#input_sname_search').val().trim();
            var search_url = window.location.href;
            var search_count = $("#search_count").val();
            var search_query = idxboostcondition;
            var current_type_alert = $(".iboost-alert-change-interval:eq(0)").val();
            if (name != null && name.length > 0) {
                if ((current_type_alert == 1) || (current_type_alert == 7)) {
                    var qty_checked = $(".flex-save-type-options:checked");
                    if (qty_checked.length <= 0) {
                        sweetAlert("Oops...", word_translate.youmust_selectat_least_one_checkbox_from_below, "error");
                        return;
                    }
                }
                $.ajax({
                    url: flex_idx_filter_params.ajaxUrl,
                    method: "POST",
                    data: {
                        action: "idxboost_filter_save_search",
                        search_url: search_url,
                        search_count: search_count,
                        name: name,
                        notification_day: $('.notification_day_class').val(),
                        notification_type: arragle_notification_type,
                        search_query: search_query,
                        type: "add"
                    },
                    dataType: "json",
                    success: function(data) {
                        console.log(data);
                        if (data.success === true) {
                            swal({ title: word_translate.search_saved , text: word_translate.your_search_has_been_saved_successfuly, type: "success", timer: 2000, showConfirmButton: false });
                            jQuery('.ib-md-active .ib-mmclose').click();
                            $('.ib-name_search').val('');
                            // console.log(arragle_notification_type);
                            $('input[name="notification_type[]"]').each(function() {
                                this.checked = false;
                            });
                            $('.notification_day_class').val('--');
                        } else {
                            // show error
                            sweetAlert("Oops...", data.message, "error");
                        }
                    }
                });
            } else {
                sweetAlert("Oops...", word_translate.you_must_provide_a_name_for_this_search, "error");
            }
        });
});

})(jQuery);