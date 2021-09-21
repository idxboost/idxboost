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
var lead_submission_buy_submit;

var lead_submission_rent_form;
var lead_submission_rent_submit;

var lead_submission_sell_form;
var lead_submission_sell_submit;

var lead_address_acgoogle;

function handleSubmissionBuyForm(event) {
    event.preventDefault();

    if (true === lead_submission_running) {
        return;
    }

    lead_submission_running = true;

    var formData = lead_submission_buy_form.serialize();

    $.ajax({
        type: "POST",
        url: __flex_g_settings.ajaxUrl,
        data: formData,
        success: function(response) {
            sweetAlert(word_translate.email_sent, word_translate.your_email_was_sent_succesfully, "success");
            lead_submission_buy_form.find(":input").prop("disabled", true);

            $(document).one("click", "button", function(event) {
                if ($(event.target).hasClass("confirm")) {
                    setTimeout(function () {
                        document.location.reload();
                    }, 300);
                }
            });
        }
    });
}

function handleSubmissionRentForm(event) {
    event.preventDefault();

    if (true === lead_submission_running) {
        return;
    }

    lead_submission_running = true;

    var formData = lead_submission_rent_form.serialize();

    $.ajax({
        type: "POST",
        url: __flex_g_settings.ajaxUrl,
        data: formData,
        success: function(response) {
            sweetAlert(word_translate.email_sent, word_translate.your_email_was_sent_succesfully, "success");
            lead_submission_rent_form.find(":input").prop("disabled", true);

            $(document).one("click", "button", function(event) {
                if ($(event.target).hasClass("confirm")) {
                    setTimeout(function () {
                        document.location.reload();
                    }, 300);
                }
            });
        }
    });
}

function handleSubmissionSellForm(event) {
    event.preventDefault();

    if (true === lead_submission_running) {
        return;
    }

    lead_submission_running = true;

    var formData = lead_submission_sell_form.serialize();

    $.ajax({
        type: "POST",
        url: __flex_g_settings.ajaxUrl,
        data: formData,
        success: function(response) {
            sweetAlert(word_translate.email_sent, word_translate.your_email_was_sent_succesfully, "success");
            lead_submission_sell_form.find(":input").prop("disabled", true);

            $(document).one("click", "button", function(event) {
                if ($(event.target).hasClass("confirm")) {
                    setTimeout(function () {
                        document.location.reload();
                    }, 300);
                }
            });
        }
    });
}
    
$(function() {
    lead_submission_buy_form = $("#lead_submission_buy_form");
    lead_submission_buy_submit = $("#lead_submission_buy_submit");

    lead_submission_rent_form = $("#lead_submission_rent_form");
    lead_submission_rent_submit = $("#lead_submission_rent_submit");

    lead_submission_sell_form = $("#lead_submission_sell_form");
    lead_submission_sell_submit = $("#lead_submission_sell_submit");

    if (lead_submission_buy_form.length && lead_submission_buy_submit.length) {
        lead_submission_buy_form.on("submit", handleSubmissionBuyForm);
    }

    if (lead_submission_rent_form.length && lead_submission_rent_submit.length) {
        lead_submission_rent_form.on("submit", handleSubmissionRentForm);
    }

    if (lead_submission_sell_form.length && lead_submission_sell_submit.length) {
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

google.maps.event.addDomListener(window, 'load', function() {
    console.log('window ready');
    // lead_address_acgoogle = document.getElementById("lead_address_acgoogle");

    // if (null !== lead_address_acgoogle) {
    //     var lead_address_acgoogle_autocomplete = new google.maps.places.Autocomplete(lead_address_acgoogle);
        
    //     lead_address_acgoogle_autocomplete.setComponentRestrictions({
    //         "country": ["us"]
    //     });

    //     setTimeout(function() {
    //         lead_address_acgoogle.setAttribute("autocomplete", "disabled");
    //     }, 1000);
    // }
});

})(jQuery);