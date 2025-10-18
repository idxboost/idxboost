var activeli = '';

(function($) {
    $(function() {
        $(".flex-saved-search-remove").on("click", function(event) {
            event.preventDefault();
            var token_alert = $(this).attr("data-alert-token");
            var _self = $(this);
            swal({
                title: word_translate.are_you_sure,
                text: word_translate.are_you_sure_you_want_to_remove_this_saved_search,
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: word_translate.yes_delete_it,
                closeOnConfirm: false
            }, function() {
                $.ajax({
                    url: __flex_g_settings.ajaxUrl,
                    method: "POST",
                    data: {
                        action: "flex_save_search",
                        type: "remove",
                        id: _self.data('id'),
                        search_url: _self.data('search-url'),
                        search_count: _self.data('search-count'),
                        token_alert: token_alert
                    },
                    dataType: "json",
                    success: function(data) {

                        swal({
                            title: word_translate.deleted,
                            text: word_translate.the_saved_search_has_been_removed_from_your_alerts,
                            type: "success",
                            timer: 2000,
                            showConfirmButton: false
                        });

                        var alertToken = _self.data("alert-token");
                        var savedSearchesCnt = parseInt($("#ib-saved-searches-cnt").html(), 10);

                        $('.flex-body[data-alert-token="'+alertToken+'"]').hide().remove();
                        $("#ib-saved-searches-cnt").html(savedSearchesCnt - 1);

                        //_self.parent().parent().hide().remove();
                        //location.reload();
                    }
                });
            });
        });

        $('.flex-table .flex-table-row .flex-table-row-item .info-sub-item .info-b .notify span').click(function(event) {
            activeli = this;
            $('#input_update_name_search').val( $('.flex_alert_cont_'+$(this).attr('posid')).attr('namesearch') );
            $('.token_alert').val($('.flex_alert_cont_'+$(this).attr('posid')).attr('data-alert-token'));
            $('.notification_day_class_update').val($('.flex_alert_cont_'+$(this).attr('posid')).attr('alertinterval'));
            $.each($('.flex_alert_cont_'+$(activeli).attr('posid')).attr('alertnotifications').split(","), function(i, val){
                $("input[value='" + val + "']").prop('checked', true);
            });

            if (__flex_g_settings.anonymous === "yes") {
                //active_modal($('#modal_login'));

                $("#modal_login").addClass("active_modal").find('[data-tab]').removeClass('active');
                $("#modal_login").addClass("active_modal").find('[data-tab]:eq(1)').addClass('active');
                $("#modal_login").find(".item_tab").removeClass("active");
                $("#tabRegister").addClass("active");
                $("button.close-modal").addClass("ib-close-mproperty");
                $(".overlay_modal").css("background-color", "rgba(0,0,0,0.8);");
                $("#modal_login h2").html(
                $("#modal_login").find("[data-tab]:eq(1)").data("text-force"));
                /*Asigamos el texto personalizado*/
                var titleText = $(".header-tab a[data-tab='tabRegister']").attr('data-text')
                $("#modal_login .modal_cm .content_md .heder_md .ms-title-modal").html(titleText);
            } else {
                if ($(this).attr('taction') == 1) {
                    active_modal($('#modal_update_search'));
                } else {
                    $('.notification_day_class_update').val('0');
                    $("#form-update-alert").submit();
                }
            }
        });
        $('.close.close-modal').click(function(event) {
            close_modal($('#modal_update_search'));
        });
        $("#form-update-alert").on("submit", function(event) {
            event.preventDefault();
            var arragle_notification_type = [];
            $('input[name="notification_type_update[]"]:checked').each(function() {
                arragle_notification_type.push(this.value);
            });
            var name = $('#input_update_name_search').val();
            var token_alert = $('.token_alert').val();
            var notiday = $('.notification_day_class_update').val();
            if (name != null && name.length > 0) {
                $.ajax({
                    url: __flex_g_settings.ajaxUrl,
                    method: "POST",
                    data: {
                        action: "flex_save_search",
                        type: "update",
                        name: name,
                        notification_day: notiday,
                        notification_type: arragle_notification_type,
                        token_alert: token_alert,
                        search_count: 1
                    },
                    dataType: "json",
                    success: function(data) {
                        console.log(data);
                        $('.flex_tit_' + $(activeli).attr('posid')).text($('#input_update_name_search').val());
                        $('.flex_alert_cont_'+$(activeli).attr('posid')).attr('namesearch')
                        $('.flex_alert_cont_'+$(activeli).attr('posid')).attr('namesearch', $('#input_update_name_search').val());
                        $('.flex_alert_cont_'+$(activeli).attr('posid')).attr('alertinterval', $('.notification_day_class_update').val());
                        $('.flex_alert_cont_'+$(activeli).attr('posid')).attr('alertnotifications', arragle_notification_type.toString() );
                        //$(activeli).attr('alertnotifications', $('.notification_day_class_update').val() );
                        $('#form-update-alert').trigger("reset");
                        if (notiday == 0) {
                            $('input#flex_saved_search_off_' +$(activeli).attr('posid') ).click();
                        } else {
                            $('input#flex_saved_search_on_' + $(activeli).attr('posid') ).click();
                        }
                        //_self.parent().parent().slideUp("slow", function() {$(this).remove();});
                        $('#modal_update_search').removeClass('active_modal');
                    },
                    before: function(){
                        close_modal($('#modal_update_search'));
                    },complete: function() {
                        active_modal($('#modal_update_favorities'));
                    }
                });
            } else {
                sweetAlert(word_translate.oops, word_translate.you_must_provide_a_name_for_this_search, "error");
            }
        });

        function active_modal($modal) {
            if ($modal.hasClass('active_modal')) {
                $('.overlay_modal').removeClass('active_modal');
                $("html, body").animate({
                    scrollTop: 0
                }, 1500);
            } else {
                $modal.addClass('active_modal');
                $modal.find('form').find('input').eq(0).focus();
                $('html').addClass('modal_mobile');
            }
            close_modal($modal);
        }

        function close_modal($obj) {
            var $this = $obj.find('.close');
            $this.click(function() {
                var $modal = $this.closest('.active_modal');
                $modal.removeClass('active_modal');
                $('html').removeClass('modal_mobile');
            });
        }
    });
})(jQuery);
