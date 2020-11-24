(function ($) {

$(function() {    

jQuery('.form_submit_button_search_desuscribe').click(function(event) {
        $('.notification_day_update_flo').val('0');
        jQuery("#form-update-alert-for-token").submit();
    });

    $('.close.close-modal').click(function(event) {
        close_modal($('#modal_update_search'));
        close_modal($('#modal_update_favorities'));
    });

    jQuery('.modal_cm .close').click(function(){
        close_modal($('#modal_update_search'));
        close_modal($('#modal_update_favorities'));
    });

        $("#form-update-alert-for-token").on("submit", function(event) {
            event.preventDefault();
            var arragle_notification_type = [];
            jQuery(".idxboost_footer_thank").show().ready(function(){ jQuery('.idx_body_alert_unsubscribe').hide(); });
            $('input[name="notification_type_update_token[]"]:checked').each(function() {
                arragle_notification_type.push(this.value);
            });
            var name = $('#input_update_name_search_token').val();
            var token_alert = $('.token_alert_flo').val();
            var notiday=$('.notification_day_update_flo').val();
            
            //if (name != null && name.length > 0 && $('.type_alert').val()=='update' ) {
                jQuery.ajax({
                    url: flex_idx_alerts_params.ajaxUrl,
                    method: "POST",
                    data: {
                        action: "flex_update_search",
                        type: "update",
                        name:name,
                        notification_day: notiday,
                        notification_type: arragle_notification_type,
                        token_alert: token_alert,
                        search_count:1
            },
            dataType: "json",
            success: function(data) {
                console.log(data);
                //_self.parent().parent().slideUp("slow", function() {$(this).remove();});
            },complete: function(){
                jQuery('html').addClass('active_modal modal_mobile');
                jQuery('#modal_update_favorities').addClass('active_modal');
            }
        });
           /*
            } else {
                sweetAlert("Oops...", "You must provide a name for this search.", "error");
            }
            */
        });


    function active_modal($modal) {
        if ($modal.hasClass('active_modal')) {
            $('.overlay_modal').removeClass('active_modal');
            // $("html, body").animate({
            //     scrollTop: 0
            // }, 1500);
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