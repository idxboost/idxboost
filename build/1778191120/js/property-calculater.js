(function($) {

    /*$.fn.calculatemortgage = function() {
        $('#submit-mortgage').addClass('loading');
        $.ajax({
            url: flex_idx_property_params.ajaxUrl,
            type: "POST",
            data: {
                'action': 'dgt_mortgage_calculator',
                purchase_price: $('.purchase_price_txt').val().replace(/,/g, '').replace(/\./g, '').replace('$', ''),
                down_payment: $('.down_payment_txt').val(),
                year_term: $('.term_txt').val(),
                interest_rate: $('.interest_rate_txt').val()
            },
            dataType: "json",
            success: function(response) {
                $('#submit-mortgage').removeClass('loading');
                $('.mortgage_mount_txt').text('$' + response.mortgage);
                $('.down_paymentamount_txt').text('$' + response.down_payment);
                //$('.mortgage_amount_txt').text(response.monthly);
                $('.mortgage_amount_txt').text('$' + response.total_monthly);
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(thrownError);
            }
        })
    };*/

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
    }

    function close_modal($obj) {
      var $this = $obj.find('.close');
      $this.click(function() {
        var $modal = $this.closest('.active_modal');
        $modal.removeClass('active_modal');
        $('html').removeClass('modal_mobile');
      });
    }

    function numberWithCommas(x) {
      return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    }

    function validate_price(evt) {
        var theEvent = evt || window.event;
        var key = theEvent.keyCode || theEvent.which;
        key = String.fromCharCode(key);
        var regex = /[0-9]|\./;
        if (!regex.test(key)) {
            theEvent.returnValue = false;
            if (theEvent.preventDefault) theEvent.preventDefault();
        }
    }
    
    $(function() {
        $('#form-calculator').submit(function(e) {
            e.preventDefault();
            $(this).calculatemortgage();
        });

        $(document).on('click', '#calculator-mortgage', function(e) {
            e.preventDefault();
            var curr_price = $("#calculator-mortgage").data("price");
            $(".purchase_price_txt").val(curr_price);
            $('.mortgage_mount_txt').text('$0');
            $('.down_paymentamount_txt').text('$0');
            $('.mortgage_amount_txt').text('$0');
            //var listing_price = $('.property-price').attr('data-price');
            //$('.purchase_price_txt').val(numberWithCommas(listing_price));
            $('#form-calculator').trigger('submit');
        });

        $('.purchase_price_txt').focusout(function(event) {
            $(this).val($(this).val().replace(/,/g, '').replace(/\./g, ''));
            $(this).val(numberWithCommas($('.purchase_price_txt').val()));
        });

        /*
        $('#tr-es').live('click', function() {
            $($(".goog-te-menu-frame")).contents().find("span.text").each(function() {
                if ($(this).html() == "español" || $(this).html() == "Español" || $(this).html() == "Spanish") {
                    $(this).click();
                    console.log(this);
                }
            });
            $('ul#available-languages li').removeClass('active');
            $(this).addClass('active');
        });
        $('#tr-en').live('click', function() {
            $($(".goog-te-menu-frame")).contents().find("span.text").each(function() {
                if ($(this).html() == "Inglés" || $(this).html() == "English" || $(this).html() == "english" || $(this).html() == "inglés") {
                    $(this).click();
                    console.log(this);
                }
            });
            $('ul#available-languages li').removeClass('active');
            $(this).addClass('active');
        });
        $('#tr-fr').live('click', function() {
            $($(".goog-te-menu-frame")).contents().find("span.text").each(function() {
                if ($(this).html() == "francés" || $(this).html() == "French" || $(this).html() == "Francés") {
                    $(this).click();
                    console.log(this);
                }
            });
            $('ul#available-languages li').removeClass('active');
            $(this).addClass('active');
        });
        $('#tr-it').live('click', function() {
            $($(".goog-te-menu-frame")).contents().find("span.text").each(function() {
                if ($(this).html() == "italiano" || $(this).html() == "Italian" || $(this).html() == "Italiano") {
                    $(this).click();
                    console.log(this);
                }
            });
            $('ul#available-languages li').removeClass('active');
            $(this).addClass('active');
        });
        $('#tr-pt').live('click', function() {
            $($(".goog-te-menu-frame")).contents().find("span.text").each(function() {
                if ($(this).html() == "Portugués" || $(this).html() == "Portuguese" || $(this).html() == "português" || $(this).html() == "portugués") {
                    $(this).click();
                    console.log(this);
                }
            });
            $('ul#available-languages li').removeClass('active');
            $(this).addClass('active');
        });
        $('#zh-TW').live('click', function() {
            $($(".goog-te-menu-frame")).contents().find("span.text").each(function() {
                if ($(this).html() == "chino (tradicional)" || $(this).html() == "chino (Tradicional)" || $(this).html() == "Chinese (Traditional)" || $(this).html() == "hinese (traditional)" || $(this).html() == "中國（繁體）") {
                    $(this).click();
                    console.log(this);
                }
            });
            $('ul#available-languages li').removeClass('active');
            $(this).addClass('active');
        });
        $('#tr-ru').live('click', function() {
            $($(".goog-te-menu-frame")).contents().find("span.text").each(function() {
                if ($(this).html() == "ruso" || $(this).html() == "Russian" || $(this).html() == "Russian" || $(this).html() == "русский") {
                    $(this).click();
                    console.log(this);
                }
            });
            $('ul#available-languages li').removeClass('active');
            $(this).addClass('active');
        });
        $('#tr-de').live('click', function() {
            $($(".goog-te-menu-frame")).contents().find("span.text").each(function() {
                if ($(this).html() == "Alemán" || $(this).html() == "alemán" || $(this).html() == "Aleman" || $(this).html() == "aleman" || $(this).html() == "Germany" || $(this).html() == "germany" || $(this).html() == "German") {
                    $(this).click();
                    console.log(this);
                }
            });
            $('ul#available-languages li').removeClass('active');
            $(this).addClass('active');
        });*/
    });


})(jQuery);
