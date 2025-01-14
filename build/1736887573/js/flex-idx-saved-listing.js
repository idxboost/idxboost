(function($) {
    var flex_xhr_running = false;
    $(function() {
        $("#ss_preferred_time").timepicker();
        $("#ss_preferred_date").datepicker();

        $(".dgt-remove-favorite").on("click", function(event) {
            var class_id = $(this).data('class-id');
            var mls_num = $(this).data("mls");
            var token_alert = $(this).attr("data-alert-token");
            var _self = $(this);
            swal({
                title: word_translate.are_you_sure,
                text:  word_translate.are_you_sure_you_want_to_remove_this_property,
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: word_translate.yes_delete_it,
                closeOnConfirm: false
            }, function() {
                // swal(word_translate.deleted, word_translate.the_property_has_been_removed_from_your_favorites, "success");
                $.ajax({
                    url: flex_idx_saved_listing.ajaxUrl,
                    method: "POST",
                    data: {
                        action: "flex_favorite",
                        class_id: class_id,
                        mls_num: mls_num,
                        token_alert: token_alert,
                        type_action: 'remove'
                    },
                    dataType: "json",
                    success: function(data) {
                        swal({
                            title: word_translate.deleted,
                            text: word_translate.the_property_has_been_removed_from_your_favorites,
                            type: "success",
                            timer: 2000,
                            showConfirmButton: false
                        });
                        
                        var mlsNumber = _self.data("mls");
                        var savedPropertiesCnt = parseInt($("#ib-saved-properties-cnt").html(), 10);

                        $('.flex-body[data-mls="'+mlsNumber+'"]').hide().remove();
                        $("#ib-saved-properties-cnt").html(savedPropertiesCnt - 1);

                        // _self.parent().parent().hide().remove();
                        //location.reload();
                    }
                });
            });
        });
        $(".flex-idx-favorites-add-comment").on("click", function(event) {
            event.stopPropagation();
            var sibling = $(this).prev();
            var _comment = sibling.val();
            var _type_action = $(this).data('type-action');
            var _mls = $(this).data('mls');
            $.ajax({
                url: flex_idx_saved_listing.ajaxUrl,
                method: "POST",
                data: {
                    action: "flex_favorite_comments",
                    comment: _comment,
                    mls: _mls,
                    type_action: _type_action
                },
                dataType: "json",
                success: function(data) {
                    if (data.success === true) {
                        var _ct = $('#flex-idx-comment_placeholder-' + _mls);
                        _ct.empty();
                        var _html = [];
                        _html.push('<blockquote>' + data.comment + '</blockquote');
                        _html.push('<div class="flex-idx-favorite-actions">');
                        _html.push('<p>');
                        _html.push('<a data-mls="' + _mls + '" href="#" data-action="edit">Edit</a> | <a data-mls="' + _mls + '" href="#" data-action="remove">Remove</a>');
                        _html.push('</p>');
                        _html.push('</div>');
                        _ct.html(_html.join(""));
                    }
                    alert(data.message);
                }
            });
        });
        $(".comment-bt").on("click", function() {
            var _rel = $(this).data('rel');
            var _target = $('#flex-idx_comments-' + _rel);
            _target.toggle();
            _target.find('textarea:eq(0)').focus();
        });
        $('.flex-idx-favorite-actions').on('click', 'a', function(event) {
            event.preventDefault();
            var _mls = $(this).data('mls');
            var _action = $(this).data('action');
            switch (_action) {
                case 'edit':
                    var _ct = $('#flex-idx_comments-' + _mls);
                    _ct.show();
                    _ct.find('textarea:eq(0)').focus();
                    _ct.find('button:eq(0)').data('for', 'update');
                    break;
                case 'remove':
                    $(this).parent().parent().parent().empty();
                    var _ct = $('#flex-idx_comments-' + _mls);
                    _ct.find('button:eq(0)').data('for', 'add');
                    _ct.find('textarea:eq(0)').val('').focus();
                    $.ajax({
                        url: flex_idx_saved_listing.ajaxUrl,
                        method: "POST",
                        data: {
                            action: "flex_favorite_comments_remove",
                            mls: _mls
                        },
                        dataType: "json",
                        success: function(data) {
                            alert(data.message);
                        }
                    });
                    break;
            }
        });
        $(".flex-idx-favorites-rating").on("click", "i", function(event) {
            event.stopPropagation();
            var _count = $(this).data('count');
            var _mls = $(this).data('mls');
            $.ajax({
                url: flex_idx_saved_listing.ajaxUrl,
                method: "POST",
                data: {
                    action: "flex_favorite_rate",
                    count: _count,
                    mls: _mls
                },
                dataType: "json",
                success: function(data) {
                    alert(data.message);
                }
            });
        });
    });
})(jQuery);
