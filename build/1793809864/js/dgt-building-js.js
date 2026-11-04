(function($) {

$(function() {
	// dom ready
	$("#form-request").on("submit", function(event) {
		event.preventDefault();

		// fetch values
		var first_name = $("#first_name-2").val();
		var last_name=  $("#last_name-2").val();
		var email = $("#email-2").val();
		var phone = $("#phone-2").val();
		var comments = $("#message-2").val();

		swal(word_translate.good_job, word_translate.your_message_has_been_sent, "success");
		$(this).trigger("reset");
	});

	$("#form-request-aside").on("submit", function(event) {
		event.preventDefault();

		// fetch values
		var first_name = $("#first_name").val();
		var last_name=  $("#last_name").val();
		var email = $("#email").val();
		var phone = $("#phone").val();
		var comments = $("#message").val();

		swal(word_translate.good_job, word_translate.your_message_has_been_sent, "success");
		$(this).trigger("reset");
	});
});

})(jQuery);