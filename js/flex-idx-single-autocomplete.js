(function ($) {
    function ib_fetch_default_cities() {
        var ib_autocomplete_cities = _.pluck(__flex_g_settings.params.cities, "name");
        var featured_cities = [];

        if (ib_autocomplete_cities.length) {
            for (var i = 0, l = ib_autocomplete_cities.length; i < l; i++) {
                featured_cities.push({
                    label: ib_autocomplete_cities[i],
                    type: "city"
                });
            }
        }

        return featured_cities;
    }

    function handleSubmitAutocompleteForm(event) {
        event.preventDefault();

        var inputValue = ib_autocomplete.val();

        if ("" !== inputValue) {
            ib_autocomplete.autocomplete("close");

            if (/^\d+$/.test(inputValue) && (5 === inputValue.length)) {
                handleRedirectTo(inputValue, "zip");
            } else {
                var matchCity;

                for (var i = 0, l = ib_autocomplete_cities.length; i < l; i++) {
                    var term = ib_autocomplete_cities[i];
                    var match = new RegExp("^" + term.label + "$", "i");

                    if (false !== match.test(inputValue)) {
                        matchCity = term;
                        break;
                    }
                }

                if ("undefined" !== typeof matchCity) {
                    handleRedirectTo(matchCity.label, "city");
                } else {
                    handleRedirectTo(inputValue, null);
                }
            }
        }
    }

    function handleLookupAutocomplete(request, response) {
        var term = request.term;

        if (term in ib_autocomplete_cache) {
            response(ib_autocomplete_cache[term]);
            return;
        }

        $.ajax({
            url: __flex_g_settings.suggestions.service_url,
            dataType: "json",
            data: {
                term: request.term,
                board: __flex_g_settings.boardId
            },
            success:function(data) {
                ib_autocomplete_cache[term] = data;
                response(data);
            },
        });
    }

    function handleRedirectTo(term, type) {
        var rentalType = $("#flex_ac_rental_slug").val();
        var redirectTo = __flex_g_settings.searchUrl;

        redirectTo += "?for=" + ( (0 == rentalType) ? "sale" : "rent" );

        if (null !== type) {
            redirectTo += "&keyword=" + encodeURIComponent(term) + "_" + type.toLowerCase();
        } else {
            redirectTo += "&keyword=" + encodeURIComponent(term);
        }

        window.location.href = redirectTo;
    }

    function handleSelectAutocomplete(event, ui) {
        handleBlurAutocompleteEvent();
        handleRedirectTo(ui.item.value, ui.item.type);

        setTimeout(function () {
            document.activeElement.blur();
        }, 100);
    }

    function handleBlurAutocompleteEvent() {
        // validate if mobile device
        /*
        if( /Android|webOS|iPhone|iPad|iPod|Opera Mini/i.test(navigator.userAgent) ) {
            window.scrollTo(0, 0);
        }
        */
    }

    function handleFocusAutocompleteEvent() {
        // validate if mobile device
        /*
        if( /Android|webOS|iPhone|iPad|iPod|Opera Mini/i.test(navigator.userAgent) ) {
            $([document.documentElement, document.body]).animate({
                scrollTop: $("#flex_idx_single_autocomplete").offset().top
            }, 300);
        }
        */

        if ("" === this.value) {
            ib_autocomplete.autocomplete("option", "source", ib_autocomplete_cities);
            ib_autocomplete.autocomplete( "search", "" );
        }
    }

    function handleKeyPressAutocompleteEvent(event) {
        if ("" !== this.value && 13 === event.keyCode) {
            ib_autocomplete.autocomplete("close");
            handleBlurAutocompleteEvent();
    
            setTimeout(function () {
                document.activeElement.blur();
            }, 100);
        }
        ib_autocomplete.autocomplete("option", "source", handleLookupAutocomplete);
    }

    function handleKeyUpAutocompleteEvent(event) {
        if (event.keyCode == 40 || event.keyCode == 38 || event.keyCode == 39 || event.keyCode == 37) {
            return;
        }

        var inputValue = this.value;

        if ( ("" !== inputValue) && (13 === event.keyCode) ) {
            ib_autocomplete.autocomplete("close");
            handleBlurAutocompleteEvent();

            setTimeout(function () {
                document.activeElement.blur();
            }, 100);

            if (/^\d+$/.test(inputValue) && (5 === inputValue.length)) {
                handleRedirectTo(inputValue, "zip");
            } else {
                var matchCity;

                for (var i = 0, l = ib_autocomplete_cities.length; i < l; i++) {
                    var term = ib_autocomplete_cities[i];
                    var match = new RegExp("^" + term.label + "$", "i");

                    if (false !== match.test(inputValue)) {
                        matchCity = term;
                        break;
                    }
                }

                if ("undefined" !== typeof matchCity) {
                    handleRedirectTo(matchCity.label, "city");
                } else {
                    handleRedirectTo(inputValue, null);
                }
            }
        }

        if ("" === inputValue) {
            ib_autocomplete.autocomplete("option", "source", ib_autocomplete_cities);
            ib_autocomplete.autocomplete( "search", "" );
        } else {
            ib_autocomplete.autocomplete("option", "source", handleLookupAutocomplete);
            ib_autocomplete.autocomplete( "search", ib_autocomplete.val() );
        }
    }

    function handleClearAutocompleteEvent() {
        ib_autocomplete.autocomplete("option", "source", ib_autocomplete_cities);
        ib_autocomplete.autocomplete( "search", "" );
    }

    function handlePasteAutocompleteEvent() {
        ib_autocomplete.autocomplete("option", "source", handleLookupAutocomplete);
    }

    var ib_autocomplete;
    var ib_autocomplete_form;
    var ib_autocomplete_cities = ib_fetch_default_cities();
    var ib_autocomplete_cache = {};

    $(function() {
        ib_autocomplete = $("#flex_idx_single_autocomplete_input");
        ib_autocomplete_form = $("#flex_idx_single_autocomplete");

        if (ib_autocomplete_form.length) {
            ib_autocomplete_form.on("submit", handleSubmitAutocompleteForm);
        }

        if (ib_autocomplete.length) {
            ib_autocomplete.autocomplete({
                minLength: 0,
                open: function(event, ui) {
                    $('.ui-autocomplete').off('menufocus hover mouseover mouseenter');
                },
                create: function( event, ui ) {
                    // $(this).attr('autocomplete', 'disabled');
                },
                source: handleLookupAutocomplete,
                select: handleSelectAutocomplete,
                appendTo: "#ib-autocomplete-add"
            });

            ib_autocomplete.autocomplete("instance")._renderItem = function( ul, item ) {
                if ("complex" === item.type) {
                    return $('<li>')
                    .append('<div title="'+item.label+'">' + item.label + '<span class="autocomplete-item-type">Complex / Subdivision</span></div>')
                    .appendTo(ul);
                } else {
                    return $('<li>')
                    .append('<div title="'+item.label+'">' + item.label + '<span class="autocomplete-item-type">' + item.type + '</span></div>')
                    .appendTo(ul);
                }
            };

            ib_autocomplete.on("focus", handleFocusAutocompleteEvent);
            ib_autocomplete.on("blur", handleBlurAutocompleteEvent);
            ib_autocomplete.on("keypress", handleKeyPressAutocompleteEvent);
            ib_autocomplete.on("keyup", handleKeyUpAutocompleteEvent);
            ib_autocomplete.on("search", handleClearAutocompleteEvent);
            ib_autocomplete.on("paste", handlePasteAutocompleteEvent);
        }

        // autocomplete modal
        // $("#clidxboost-modal-search").on("click", function() {
        //     console.log("focus inline");

        //     setTimeout(function () {
        //         ib_autocomplete.focus();
        //     }, 300);
        // });
    });
})(jQuery);
