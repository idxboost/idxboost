(function ($) {

var flex_idx_pages_form;

$(function() {
	// dom ready...
	flex_idx_pages_form = $("#flex_idx_pages_form");

	if (flex_idx_pages_form.length) {
		flex_idx_pages_form.on("submit", function(event) {
			event.preventDefault();

            $.ajax({
                url: flex_idx_admin_pages_js.ajaxUrl,
                method: "POST",
                data: flex_idx_pages_form.serialize(),
                dataType: "json",
                success: function(data) {
                    alert(data.message);
                    window.location.reload(false);
                }
            });
		});
	}
});

})(jQuery);