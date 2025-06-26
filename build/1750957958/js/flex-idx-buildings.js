(function($) {
    var remove_favorites;
    $(function() {
        console.log('script for buildings loaded');
        // handle remove favorites
        remove_favorites = $(".dgt-remove-favorite");
        if (remove_favorites.length) {
            remove_favorites.on("click", function(event) {
                event.preventDefault();
                var building_id = $(this).data("building-id");
                var _self = $(this);

	            swal({
	                title: word_translate.are_you_sure,
	                text: word_translate.are_you_sure_you_want_to_remove_this_building,
	                type: "warning",
	                showCancelButton: true,
	                confirmButtonColor: "#DD6B55",
	                confirmButtonText: word_translate.yes_delete_it,
	                closeOnConfirm: false
	            }, function() {
	                // swal(word_translate.deleted, word_translate.the_building_has_been_removed_from_your_favorites, "success");
                    $.ajax({
	                    url: __flex_g_settings.ajaxUrl,
	                    method: "POST",
	                    data: {
	                        action: "flex_favorite_building",
	                        building_id: building_id,
	                        type_action: 'remove'
	                    },
	                    dataType: "json",
	                    success: function(data) {
	                        _self.parent().parent().hide().remove();
							//location.reload();
							swal({
								title: word_translate.deleted,
								text: word_translate.the_building_has_been_removed_from_your_favorites,
								type: "success",
								timer: 2000,
								showConfirmButton: false
							});
	                    }
               		});
	            });
            });
        }
    });
})(jQuery);
