(function ($) {

$(function() {
    // code...
    $(".flex-saved-search-remove").on("click", function(event) {
        event.preventDefault();

        var _self = $(this);

        jQuery.ajax({
            url: flex_idx_saved_searches.ajaxUrl,
            method: "POST",
            data: {
                action: "flex_save_search",
                type: "remove",
                id: _self.data('id'),
                search_url: _self.data('search-url'),
                search_count: _self.data('search-count')
            },
            dataType: "json",
            success: function(data) {
                if (data.success) {
                    _self.parent().parent().remove();
                    swal({
                        title: "Saved Search Removed!",
                        text: data.message,
                        type: "success",
                        timer: 2000,
                        showConfirmButton: false
                    });
                }
            }
        });
    });
});

})(jQuery);