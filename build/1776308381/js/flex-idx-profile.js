(function ($) {

	var flex_idx_profile_form;

	$(function() {
		// code...
		flex_idx_profile_form = $("#flex_idx_profile_form");

		if (flex_idx_profile_form.length) {
			flex_idx_profile_form.on("submit", function(event) {
				event.preventDefault();
	      $.ajax({
	        url: flex_idx_profile.ajaxUrl,
	        method: "POST",
	        data: flex_idx_profile_form.serialize(),
	        dataType: "json",
	        success: function(data) {
	          if (data.success) {
							swal({
								title: "Profile Updated!",
								text: data.message,
								type: "success",
								timer: 3000,
								showConfirmButton: false
							});
							// swal(word_translate.good_job, data.message, "success", timer: 3000);
	          	// setTimeout(function () {
	          	// 	window.location.reload(false);
	          	// }, 2000);
	          }
	        }
	      });
			});
		}
	});

})(jQuery);
