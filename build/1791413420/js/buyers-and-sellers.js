(function($){

    $('.ib-fbtn-fnext').click(()=> {
        const $stepActive = $('.ib-fsitem-active');
        const $stepIndex = $stepActive.index();
        $stepActive.removeClass('ib-fsitem-active').next().addClass('ib-fsitem-active');
        const $fbtns = $('.ib-fbtns');
        if ($stepIndex == 0) {
            $fbtns.removeClass('ib-fbtns-continue').addClass('ib-fbtns-backnext');
        } else if ($stepIndex == ($('.ib-fsitem').length - 2)) {
            $fbtns.removeClass('ib-fbtns-backnext').addClass('ib-fbtns-submit');
        }
    });
    
    $('.ib-fbtn-back').click(()=>{
        const $stepActive = $('.ib-fsitem-active');
        const $stepIndex = $stepActive.index();
        if ($stepIndex !== 0) {
            $stepActive.removeClass('ib-fsitem-active').prev().addClass('ib-fsitem-active');
        } 
    
        if ($stepIndex == 1) {
            const $ibFbtns = $('.ib-fbtns');
            console.log('aca');
            $ibFbtns.removeClass('ib-fbtns-backnext');
            if (!$('.ib-fsifind').length) $ibFbtns.addClass('ib-fbtns-continue');
        }
    });
    
}(jQuery));

(function ($) {

    var lead_submission_running = false;

    var lead_submission_buy_form;
    var lead_submission_rent_form;
    var lead_submission_sell_form;

    var lead_address_acgoogle;

    var GENERIC_ERROR_MESSAGE = "Oops, an error occurred, please try again";

    // Libera el formulario y muestra feedback al usuario ante cualquier
    // fallo (token de reCAPTCHA o respuesta del servidor), para que
    // "lead_submission_running" nunca deje el formulario bloqueado.
    function showSubmissionError(message) {
        lead_submission_running = false;
        sweetAlert("Error", message || GENERIC_ERROR_MESSAGE, "error");
    }

    async function handleLeadSubmissionForm(event, recaptchaAction) {
        event.preventDefault();

        if (true === lead_submission_running) {
            return;
        }

        lead_submission_running = true;
        var _self = $(this);

        // Elimina tokens previos (evita duplicar el input en un segundo envío)
        _self.find("input[name='recaptcha_response']").remove();

        try {
            var token = await getReCaptchaToken(recaptchaAction);
            _self.prepend($("<input>", { type: "hidden", name: "recaptcha_response", value: token }));

            $.ajax({
                type: "POST",
                url: __flex_g_settings.ajaxUrl,
                data: _self.serialize(),
                success: function(response) {
                    if (response.hasOwnProperty("success")) {

                        if (response.success) {
                            sweetAlert(word_translate.email_sent, word_translate.your_email_was_sent_succesfully, "success");
                            _self.find(":input").prop("disabled", true);

                            $(document).one("click", "button", function(event) {
                                if ($(event.target).hasClass("confirm")) {
                                    setTimeout(function () {
                                        document.location.reload();
                                    }, 300);
                                }
                            });
                        } else {
                            showSubmissionError(response.message);
                        }

                    } else {
                        showSubmissionError();
                    }
                },
                error: function() {
                    // Sin recarga automática: se conserva el formulario
                    // completado para que el usuario pueda reintentar sin
                    // perder los datos ingresados.
                    showSubmissionError();
                }
            });
        } catch (error) {
            console.error(error);
            showSubmissionError();
        }
    }

    function handleSubmissionBuyForm(event) {
        return handleLeadSubmissionForm.call(this, event, 'i_want_to_buy');
    }

    function handleSubmissionRentForm(event) {
        return handleLeadSubmissionForm.call(this, event, 'i_want_to_rent');
    }

    function handleSubmissionSellForm(event) {
        return handleLeadSubmissionForm.call(this, event, 'i_want_to_sell');
    }

    $(function() {
        lead_submission_buy_form = $("#lead_submission_buy_form");
        lead_submission_rent_form = $("#lead_submission_rent_form");
        lead_submission_sell_form = $("#lead_submission_sell_form");

        if (lead_submission_buy_form.length && $("#lead_submission_buy_submit").length) {
            lead_submission_buy_form.on("submit", handleSubmissionBuyForm);
        }

        if (lead_submission_rent_form.length && $("#lead_submission_rent_submit").length) {
            lead_submission_rent_form.on("submit", handleSubmissionRentForm);
        }

        if (lead_submission_sell_form.length && $("#lead_submission_sell_submit").length) {
            lead_submission_sell_form.on("submit", handleSubmissionSellForm);
        }
    });

    // for seller autocomplete [google]
    jQuery(function () {
        console.log('dom ready');
        lead_address_acgoogle = document.getElementById("lead_address_acgoogle");

        if (null !== lead_address_acgoogle) {
            var lead_address_acgoogle_autocomplete = new google.maps.places.Autocomplete(lead_address_acgoogle);
            
            lead_address_acgoogle_autocomplete.setComponentRestrictions({
                "country": ["us"]
            });

            // lead_address_acgoogle.setAttribute("autocomplete", "disabled");

            setTimeout(function() {
                lead_address_acgoogle.setAttribute("autocomplete", "disabled");
            }, 300);
        }
    });

})(jQuery);