// @todo last opened property
var lastOpenedProperty;
// @todo load property modal function
var loadPropertyInModal;

var newPhoneNumberFormat;

/** @todo init global left click on property */

if ("undefined" === typeof formatShortPriceX) {
function formatShortPriceX(value) {
		var price = Number(value),
				short_price;
		
		if (price < 1000) {
				return price;
		}
		
		if (price < 10000) {
				short_price = Math.ceil(price / 100) / 10;
				
				return short_price + 'K';
		} else {
				if (price < 1000000) {
						short_price = Math.ceil(price / 1000);
						
						if (short_price < 100) {
								return String(short_price).substr(0, 2) + 'K';
						}
						
						if (short_price >= 1000) {
								return '1M';
						}
						
						return short_price + 'K';
				} else {
						if (price < 10000000) {
								short_price = Math.ceil(price / 10000) / 100;
						} else {
								short_price = Math.ceil(price / 100000) / 10;
						}
				}
		}
		
		if (String(short_price, '.') !== -1) {
				short_price = String(short_price).substr(0, 4);
		}
		
		return short_price + 'M';
}
}

var IB_HAS_LEFT_CLICKS = (__flex_g_settings.hasOwnProperty("signup_left_clicks") && (null != __flex_g_settings.signup_left_clicks));

if (true === IB_HAS_LEFT_CLICKS) {
	if (typeof Cookies.get("_ib_left_click_force_registration") === "undefined") {
		// Cookies.set("_ib_left_click_force_registration", parseInt(__flex_g_settings.signup_left_clicks, 10));
		Cookies.set("_ib_left_click_force_registration", 0);
	}
}

if (typeof Cookies.get("_ib_user_listing_views") === "undefined") {
	Cookies.set("_ib_user_listing_views", JSON.stringify([]));
}

if (typeof originalPositionY === "undefined") {
	var originalPositionY;
}

/** Handle for hide tooltip lead */

jQuery(function() {
	if (jQuery("#ib-disable-forcereg").length) {
		jQuery(document).one("click", "#ib-disable-forcereg", function(event) {
			event.preventDefault();

			Cookies.set("_ib_disabled_forcereg", "1", {
				expires: 30
			});

			jQuery("#ib-disable-forcereg").hide();
		});

		if ("undefined" !== typeof Cookies.get("_ib_disabled_forcereg")) {
			jQuery("#ib-disable-forcereg").hide();
		}
	}

	if (jQuery("#ib-lead-history-menu-btn").length) {
		if ("no" === __flex_g_settings.anonymous) {
			// if available history menu for lead
			if (jQuery("#ib-lead-history-menu-btn").length) {
				jQuery.ajax({
					url :__flex_g_settings.fetchLeadActivitiesEndpoint,
					method: "POST",
					data: {
						access_token: __flex_g_settings.accessToken,
						flex_credentials: Cookies.get("ib_lead_token")
					},
					dataType: "json",
					success: function(response) {
						if ("yes" === response.lead_info.show_help_tooltip) {
							jQuery("#ib-lead-history-tooltip-help").show();
						}

						jQuery("#ib-lead-history-menu-btn").show();

						// fill generated values
						var fill_first_letter_name_values = [];

						if (response.lead_info.first_name.length) {
							fill_first_letter_name_values.push(response.lead_info.first_name.charAt(0));
						}

						if (response.lead_info.last_name.length) {
							fill_first_letter_name_values.push(response.lead_info.last_name.charAt(0));
						}

						jQuery(".ib-lead-first-letter-name").html(fill_first_letter_name_values.join(""));


						if (response.lead_info.hasOwnProperty('photo_url') && response.lead_info.photo_url.length) {
							jQuery(".ib-lead-first-letter-name").css({
								'background-color': 'transparent',
								'background-image': 'url(' + response.lead_info.photo_url + ')',
								'background-repeat': 'no-repeat',
								'background-size': 'contain',
								'background-position': 'center center',
								'text-indent': '-9999px'
							});
						}

						jQuery(".ib-lead-fullname").html(response.lead_info.first_name + " " + response.lead_info.last_name);
						jQuery(".ib-lead-firstname").html("Hello " + response.lead_info.first_name + "!");

						jQuery(".ib-agent-fullname").html(response.agent_info.first_name + " " + response.agent_info.last_name);
						//jQuery(".ib-agent-phonenumber").html(response.agent_info.phone_number);
						jQuery(".ib-agent-phonenumber").attr("href", "tel:" + response.agent_info.phone_number.replace(/[^\d]/g, ""));
						jQuery(".ib-agent-emailaddress").attr("href", "mailto:" + response.agent_info.email_address);
						jQuery(".ib-agent-photo-thumbnail-wrapper").empty();
						jQuery(".ib-agent-photo-thumbnail-wrapper").append('<img src="' + response.agent_info.photo_url + '">');

						// fill activity lead
						jQuery("#_ib_lead_activity_rows").empty();
						jQuery("#_ib_lead_activity_pagination").empty();

						if (response.lead_info.listing_views.length) {
							var lead_listing_views = response.lead_info.listing_views;
							var lead_listing_views_html = [];

							for (var i = 0, l = lead_listing_views.length; i < l; i++) {
								lead_listing_views_html.push('<div class="ms-history-menu-item">');
								lead_listing_views_html.push('<div class="ms-history-menu-wrap-img">');
								lead_listing_views_html.push('<img src="'+lead_listing_views[i].thumbnail+'">');
								lead_listing_views_html.push('</div>');
								lead_listing_views_html.push('<div class="ms-history-menu-property-detail">');
								lead_listing_views_html.push('<h3 class="ms-history-menu-title">'+lead_listing_views[i].address_short+'</h3>');
								lead_listing_views_html.push('<h4 class="ms-history-menu-address">'+lead_listing_views[i].address_large+'</h4>');
								lead_listing_views_html.push('<h5 class="ms-history-menu-price">'+lead_listing_views[i].price+'</h5>');
								lead_listing_views_html.push('<div class="ms-history-menu-details">');
									lead_listing_views_html.push('<span>'+lead_listing_views[i].bed+' Beds</span>');
									lead_listing_views_html.push('<span>'+lead_listing_views[i].bath+' Baths</span>');
									lead_listing_views_html.push('<span>'+lead_listing_views[i].sqft+' SqFt</span>');
								lead_listing_views_html.push('</div>');
								lead_listing_views_html.push('</div>');
								//console.log(lead_listing_views[i].mls_num);
								lead_listing_views_html.push('<div class="ms-history-menu-property-actions">');
								lead_listing_views_html.push('<button data-mls="'+lead_listing_views[i].mls_num+'" class="ib-la-hp ms-history-menu-delete"><span>Delete</span></button>');
								lead_listing_views_html.push('</div>');
								//lead_listing_views_html.push('<div class="ms-property-actions">');
								//lead_listing_views_html.push('<button class="ms-save"><span>save</span></button>');
								//lead_listing_views_html.push('<button class="ms-delete"><span>Delete</span></button>');
								//lead_listing_views_html.push('</div>');
								lead_listing_views_html.push('<a href="'+__flex_g_settings.propertyDetailPermalink+'/'+lead_listing_views[i].slug+'" target="_blank" class="ms-history-menu-link">'+lead_listing_views[i].address_short + ' ' +  lead_listing_views[i].address_large +'</a>');
								lead_listing_views_html.push('</div>');
							}

							jQuery("#_ib_lead_activity_rows").html(lead_listing_views_html.join(""));
						}

						// build pagination
						if (response.lead_info.hasOwnProperty('listing_views_pagination')) {
							if (response.lead_info.listing_views_pagination.total_pages > 1) {
								var lead_listing_views_paging = [];

								if (response.lead_info.listing_views_pagination.has_prev_page) {
									lead_listing_views_paging.push('<a role="button" class="ib-pagprev ib-paggo" data-page="'+(response.lead_info.listing_views_pagination.current_page - 1 )+'"></a>');
								}

								lead_listing_views_paging.push('<div class="ib-paglinks">');

								var lead_listing_views_page_range = response.lead_info.listing_views_pagination.page_range_links;

								for (var i = 0, l =  lead_listing_views_page_range.length; i < l; i++) {
									if (lead_listing_views_page_range[i] == response.lead_info.listing_views_pagination.current_page) {
										lead_listing_views_paging.push('<a role="button" class="ib-plitem ib-plitem-active" data-page="'+lead_listing_views_page_range[i]+'">'+lead_listing_views_page_range[i]+'</a>');
									} else {
										lead_listing_views_paging.push('<a role="button" class="ib-plitem" data-page="'+lead_listing_views_page_range[i]+'">'+lead_listing_views_page_range[i]+'</a>');
									}
								}

								lead_listing_views_paging.push('</div>');

								if (response.lead_info.listing_views_pagination.has_next_page) {
									lead_listing_views_paging.push('<a role="button" class="ib-pagnext ib-paggo" data-page="'+(response.lead_info.listing_views_pagination.current_page + 1 )+'"></a>');
								}

								jQuery("#_ib_lead_activity_pagination").html('<div class="ms-history-menu-wrapper-pagination">'+lead_listing_views_paging.join("")+'</div>');
							}
					}
					}
				});
			}
		}

		jQuery(document).on("click", ".ib-lead-hide-bubble-exp", function (event) {
			event.stopPropagation();
			event.preventDefault();

			jQuery.ajax({
				url :__flex_g_settings.hideTooltipLeadEndpoint,
				method: "POST",
				data: {
					access_token: __flex_g_settings.accessToken,
					flex_credentials: Cookies.get("ib_lead_token")
				},
				dataType: "json",
				success: function(response) {
					console.log(response)
				}
			});
		});
	}
});

/** The end */

if ("undefined" !== typeof IB_PAGE_PROPERTY_DETAIL) {
	if ("yes" === __flex_g_settings.anonymous) {
		if ("undefined" !== typeof IB_PAGE_PROPERTY_DETAIL_MLS_NUMBER) {
			console.log(IB_PAGE_PROPERTY_DETAIL_MLS_NUMBER);
			var _ib_user_listing_views = JSON.parse(Cookies.get("_ib_user_listing_views"));

			if (-1 === jQuery.inArray(IB_PAGE_PROPERTY_DETAIL_MLS_NUMBER, _ib_user_listing_views)) {
					_ib_user_listing_views.push(IB_PAGE_PROPERTY_DETAIL_MLS_NUMBER);
					Cookies.set("_ib_user_listing_views", JSON.stringify(_ib_user_listing_views));
			}
		}
	}

	if (IB_HAS_LEFT_CLICKS) {
		if (false === (window.parent != window)) {
			// not in a iframe
			if ("yes" === __flex_g_settings.anonymous) {
				// var IB_CURRENT_LEFT_CLICKS = parseInt(Cookies.get("_ib_left_click_force_registration"), 10);
				// Cookies.set("_ib_left_click_force_registration", IB_CURRENT_LEFT_CLICKS + 1);

				// var IB_CURRENT_LEFT_CLICKS = (parseInt(Cookies.get("_ib_left_click_force_registration"), 10) - 1);
				// Cookies.set("_ib_left_click_force_registration", IB_CURRENT_LEFT_CLICKS);
			}
		}
	}
}

function idx_auto_save_building(lead_data){
					//force registration for building
					if ( 
								(__flex_g_settings.hasOwnProperty("force_registration")) && (1 == __flex_g_settings.force_registration) ||
								(typeof(idxboost_force_registration) != "undefined" && idxboost_force_registration != false )
							) {
						if(typeof(idxboostCollecBuil) !== 'undefined' && idxboostCollecBuil.hasOwnProperty("success") && idxboostCollecBuil.success != false){
							var search_count=0;
							var name_alert='';
							var query_filter='';

							if (document.location.hash=='#!for-rent'){
								search_count=idxboostCollecBuil.payload.properties.rent.count;
								name_alert=$('.idx_name_building').val()+' for rent';
								query_filter=idxboostCollecBuil.payload.filter_query+' and is_rental=1 ';
							}else{
								search_count=idxboostCollecBuil.payload.properties.sale.count;
								name_alert=$('.idx_name_building').val()+' for sale';
								query_filter=idxboostCollecBuil.payload.filter_query+' and is_rental=0 ';
							}

							var search_url = location.href;
							if (/iPhone|iPad|iPod|Android/i.test(navigator.userAgent)) {
								var search_url = initial_href;
							}

							$.ajax({
									type: "POST",
									url: __flex_g_settings.ajaxUrl,
									data: {
										action: "track_force_registration_building",
										board_id: __flex_g_settings.boardId,
										query_generate: query_filter,
										search_count:search_count,
										search_name:name_alert,
										lead_name:lead_data.first_name,
										lead_lastname:lead_data.last_name,
										lead_email:lead_data.email,                 
										search_url:search_url
									},
								success: function(response) {
										//console.log(response);
									}
							});                                
						}
					}
					//force registration for building
}
	
//Pusher.logToConsole = true;
// var socket;
// var channel;

var fullSlider;

		var style_map=[];

		if(style_map_idxboost != undefined && style_map_idxboost != '') {
			style_map=JSON.parse(style_map_idxboost);
		}   
		
// socket = new Pusher(__flex_g_settings.pusher.app_key, {
// 	cluster: __flex_g_settings.pusher.app_cluster,
// 	encrypted: true,
// 	authEndpoint: __flex_g_settings.socketAuthUrl + "?ib_lead_token=" + Cookies.get("ib_lead_token")
// });
//
// if ("undefined" !== typeof Cookies.get("ib_lead_token")) {
// 	socket.subscribe(__flex_g_settings.pusher.presence_channel);
// }

// socket.subscribe(__flex_g_settings.pusher.presence_channel);

// llamar cuando se suscribe login, register
// channel = socket.subscribe(__flex_g_settings.pusher.presence_channel);

/*------------------------------------------------------------------------------------------*/
/* Funcion que lanza el modal para casos especiales
/*------------------------------------------------------------------------------------------*/
function active_modal($modal) {
	if ($modal.hasClass('active_modal')) {
		jQuery('.overlay_modal').removeClass('active_modal');
		// jQuery("html, body").animate({
		//   scrollTop: 0
		// }, 1500);
	} else {
		$modal.addClass('active_modal');
		$modal.find('form').find('input').eq(0).focus();
		jQuery('html').addClass('modal_mobile');
	}
	close_modal($modal);
}

function close_modal($obj) {
	var $this = $obj.find('.close');
	$this.click(function () {
		var $modal = $this.closest('.active_modal');
		$modal.removeClass('active_modal');
		jQuery('html').removeClass('modal_mobile');
	});
}

/*------------------------------------------------------------------------------------------*/
/* Calculadora: Formateando resultados con comas (",")
/*------------------------------------------------------------------------------------------*/
function numberWithCommas(x) {
	return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
}

/*------------------------------------------------------------------------------------------*/
/* Calculadora: Calulando el precio a mostrar
/*------------------------------------------------------------------------------------------*/
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

(function ($) {
	/*------------------------------------------------------------------------------------------*/
	/* Inicializando: Calculadora
	/*------------------------------------------------------------------------------------------*/
	$.fn.calculatemortgage = function () {
		$('#submit-mortgage').addClass('loading');

		var price = $(".ib-price-calculator").attr("data-price");
        var percent = $("#down_payment_txt").val();
        var year = $("#term_txt").val();
         var interest = $("#interest_rate_txt").val();

	    price = price.replace(/[^\d]/g, "");
	    percent = parseFloat(percent);
	    year = year.replace(/[^\d]/g, "");
	    interest = parseFloat(interest);

	    var month_factor = 0;
	    var month_term = year * 12;
	    var down_payment = price * (percent / 100);
	    
	    interest = interest / 100;
	    
	    var month_interest = interest / 12;
	    
	    var financing_price = price - down_payment;
	    var base_rate = 1 + month_interest;
	    var denominator = base_rate;
	    
	    for (var i = 0; i < (year * 12); i++) {
	      month_factor += (1 / denominator);
	      denominator *= base_rate;
	    }
	    
	    var month_payment = financing_price / month_factor;
	    var pmi_per_month = 0;
	    
	    if (percent < 20) {
	      pmi_per_month = 55 * (financing_price / 100000);
	    }
	    
	    var total_monthly = month_payment + pmi_per_month;
	    
	    $(".ib-price-calculator").text("$" + (total_monthly).toFixed(2) +"/mo");
	    $('.js-est-payment').text('$' + (total_monthly).toFixed(2) );


/*
		$.ajax({
			url: __flex_g_settings.ajaxUrl,
			type: "POST",
			data: {
				'action': 'dgt_mortgage_calculator',
				purchase_price: $('.purchase_price_txt').val().replace(/,/g, '').replace(/\./g, '').replace('$', ''),
				down_payment: $('.down_payment_txt').val(),
				year_term: $('.term_txt').val(),
				interest_rate: $('.interest_rate_txt').val()
			},
			dataType: "json",
			success: function (response) {
				$('#submit-mortgage').removeClass('loading');
				$('.mortgage_mount_txt').text('$' + response.mortgage);
				$('.down_paymentamount_txt').text('$' + response.down_payment);
				$('.mortgage_amount_txt').text('$' + response.total_monthly);
				$('.js-est-payment').text('$' + response.total_monthly);
			},
			error: function (xhr, ajaxOptions, thrownError) {
				alert(thrownError);
			}
		})
		*/
	};

	$(function () {
		/*------------------------------------------------------------------------------------------*/
		/* Calculadora eventos y funciones
		/*------------------------------------------------------------------------------------------*/
		$('#form-calculator').submit(function (e) {
			e.preventDefault();
			$(this).calculatemortgage();
		});

		$(document).on('click', '#calculator-mortgage', function (e) {
			e.preventDefault();
			var curr_price = $("#calculator-mortgage").data("price");
			$(".purchase_price_txt").val(curr_price);
			$('.mortgage_mount_txt').text('$0');
			$('.down_paymentamount_txt').text('$0');
			$('.mortgage_amount_txt').text('$0');
			$('#form-calculator').trigger('submit');
		});

		$('.purchase_price_txt').focusout(function (event) {
			$(this).val($(this).val().replace(/,/g, '').replace(/\./g, ''));
			$(this).val(numberWithCommas($('.purchase_price_txt').val()));
		});

		$(document).on("submit", "#flex-idx-property-form", function (event) {
			// $("#flex-idx-property-form").on("submit", function(event) {
			event.stopPropagation();
			event.preventDefault();

			var _self = $(this);

			//VALIDACION DEL CAMPO TELEFONO
			var idCodeInput = _self.attr("data-id");
			if (iti[idCodeInput].isValidNumber()) {

				_self.find("input[type='tel']").removeClass("ms-input-error");
				_self.find(".ms-validation-text").empty();

				if (__flex_g_settings.hasOwnProperty("has_enterprise_recaptcha")) { // enterprise recaptcha
					if ("1" == __flex_g_settings.has_enterprise_recaptcha) {
							// pending...
					} else { // regular recaptcha
							grecaptcha.ready(function() {
									grecaptcha
									.execute(__flex_g_settings.google_recaptcha_public_key, { action: 'property_inquiry' })
									.then(function(token) {
											_self.prepend('<input type="hidden" name="recaptcha_response" value="'+token+'">');

											$.ajax({
												url: __flex_g_settings.ajaxUrl,
												method: "POST",
												data: _self.serialize(),
												dataType: "json",
												success: function (data) {
													$('#modal_properties_send .body_md .ico_ok').text(word_translate.email_sent);
													active_modal($('#modal_properties_send'));
													setTimeout(function () {
														$('#modal_properties_send').find('.close').click();
													}, 2000);
												}
											});
									});
							});
					}
				} else { // regular recaptcha
						grecaptcha.ready(function() {
								grecaptcha
								.execute(__flex_g_settings.google_recaptcha_public_key, { action: 'property_inquiry' })
								.then(function(token) {
										_self.prepend('<input type="hidden" name="recaptcha_response" value="'+token+'">');

										$.ajax({
											url: __flex_g_settings.ajaxUrl,
											method: "POST",
											data: _self.serialize(),
											dataType: "json",
											success: function (data) {
												$('#modal_properties_send .body_md .ico_ok').text(word_translate.email_sent);
												active_modal($('#modal_properties_send'));
												setTimeout(function () {
													$('#modal_properties_send').find('.close').click();
												}, 2000);
											}
										});
								});
						});
				}

			}else{

				_self.find("input[type='tel']").addClass("ms-input-error");
				_self.find(".ms-validation-text").html("<span>"+word_translate.enter_a_valid_phone_number+"</span>");
				
			}

			// $.ajax({
			//   url: __flex_g_settings.ajaxUrl,
			//   method: "POST",
			//   data: _self.serialize(),
			//   dataType: "json",
			//   success: function (data) {
			//     //data.message
			//     $('#modal_properties_send .body_md .ico_ok').text(word_translate.email_sent);
			//     active_modal($('#modal_properties_send'));
			//     setTimeout(function () {
			//       $('#modal_properties_send').find('.close').click();
			//     }, 2000);
			//   }
			// });
		});


		$(document).on("submit", "#flex-idx-property-form-rental", function (event) {
			// $("#flex-idx-property-form").on("submit", function(event) {
			event.stopPropagation();
			event.preventDefault();
		
			var _self = $(this);
			
			var message = jQuery(this).find("input[name='message']:eq(0)").val();
			var comments = jQuery(this).find("textarea[name='comments']").val();
			var sleep = jQuery(this).find("input[name='sleep']:eq(0)").val();
			var rental_stay = jQuery(this).find("input[name='rental_stay']:eq(0)").val();

			var address_short = jQuery(this).find("input[name='address_short']:eq(0)").val();
			var address_large = jQuery(this).find("input[name='address_large']:eq(0)").val();
			var bed = jQuery(this).find("input[name='bed']:eq(0)").val();
			var bath = jQuery(this).find("input[name='bath']:eq(0)").val();
			var mls_num = jQuery(this).find("input[name='mls_num']:eq(0)").val();
			var price = jQuery(this).find("input[name='price']:eq(0)").val();
			var first_name = jQuery(this).find("input[name='first_name']:eq(0)").val();
			var last_name = jQuery(this).find("input[name='last_name']:eq(0)").val();
			var email = jQuery(this).find("input[name='email']:eq(0)").val();
			var phone = jQuery(this).find("input[name='phone']:eq(0)").val();
			var permalink = jQuery(this).find("input[name='permalink']:eq(0)").val();
			var lead_credentials = jQuery(this).find("input[name='lead_credentials']:eq(0)").val();
			var office_code_send_email = jQuery(this).find("input[name='office_code_send_email']:eq(0)").val();
			
			
			var commentsd = comments;

			if(sleep){
					commentsd += "Sleeps: "+sleep+". ";
			}
			
			if(rental_stay){
					commentsd += "Rentals Stay: "+rental_stay+". ";
			}
			
		let dataParam = {
				"address_large": address_large,
				"address_short": address_short,
				"bath": bath,
				"bed": bed,
				"comments": commentsd,
				"email_address": email,
				"first_name": first_name,
				"last_name": last_name,
				"mls_num": mls_num,
				"permalink": permalink,
				"phone_number": phone,
				"price": price,
				"price_rate": price,
				"office_code_send_email" : office_code_send_email
		}

		var formData = new FormData();
		formData.append("access_token", __flex_g_settings.accessToken );
		formData.append("ib_tags", "Vacation Rentals");
		formData.append("is_vacation_rentals", 1 );
		formData.append("lead_credentials", lead_credentials );
		formData.append("data", JSON.stringify(dataParam) );
		

			jQuery(this).find( "[name='message']" ).val(commentsd);
			
			//VALIDACION DEL CAMPO TELEFONO
			var idCodeInput = _self.attr("data-id");
			if (iti[idCodeInput].isValidNumber()) {

				_self.find("input[type='tel']").removeClass("ms-input-error");
				_self.find(".ms-validation-text").empty();

				if (__flex_g_settings.hasOwnProperty("has_enterprise_recaptcha")) { // enterprise recaptcha
					if ("1" == __flex_g_settings.has_enterprise_recaptcha) {
							// pending...
					} else { // regular recaptcha
							grecaptcha.ready(function() {
									grecaptcha
									.execute(__flex_g_settings.google_recaptcha_public_key, { action: 'property_inquiry' })
									.then(function(token) {
											_self.prepend('<input type="hidden" name="recaptcha_response" value="'+token+'">');
											formData.append("recaptcha_response", token );
						
											$.ajax({
												url: __flex_g_settings.request_form_rentals,
												method: "POST",
												//data: _self.serialize(),
												async: false,
							processData: false,
							contentType: false,	                      
												data: formData,
												dataType: "json",
												success: function (data) {
													/*  $('#modal_properties_send .body_md .ico_ok').text(word_translate.email_sent);
													active_modal($('#modal_properties_send'));
													setTimeout(function () {
														$('#modal_properties_send').find('.close').click();
													}, 2000); */
							
							if(data.success){
								swal({
									title: 'Email Sent!',
									text: 'Your email was sent succesfully',
									type: 'success',
									timer: 2000,
									showConfirmButton: false,
									})
							}else{
								const td = data.error
										let formt = td.replaceAll('_', ' ').toLowerCase()
												formt = formt.charAt(0).toUpperCase() + formt.slice(1)
								swal({
									title: formt,
									text: data.message,
									type: 'error',
									timer: 2000,
									showConfirmButton: false,
									})
							}
							
												}
											});
									});
							});
					}
				} else { // regular recaptcha
						grecaptcha.ready(function() {
								grecaptcha
								.execute(__flex_g_settings.google_recaptcha_public_key, { action: 'property_inquiry' })
								.then(function(token) {
										_self.prepend('<input type="hidden" name="recaptcha_response" value="'+token+'">');
										formData.append("recaptcha_response", token );
						
										$.ajax({
											url: __flex_g_settings.request_form_rentals,
											method: "POST",
											//data: _self.serialize(),
												async: false,
							processData: false,
							contentType: false,	                      	                    
											data: formData,
											dataType: "json",
											success: function (data) {
												/*  $('#modal_properties_send .body_md .ico_ok').text(word_translate.email_sent);
												active_modal($('#modal_properties_send'));
												setTimeout(function () {
													$('#modal_properties_send').find('.close').click();
												}, 2000); */
							if(data.success){
							swal({
								title: 'Email Sent!',
								text: 'Your email was sent succesfully',
								type: 'success',
								timer: 2000,
								showConfirmButton: false,
								})
						}else{
							const td = data.error
									let formt = td.replaceAll('_', ' ').toLowerCase()
											formt = formt.charAt(0).toUpperCase() + formt.slice(1)
							swal({
								title: formt,
								text: data.message,
								type: 'error',
								timer: 2000,
								showConfirmButton: false,
								})
						}

											}
										});
								});
						});
				}

			}else{

				_self.find("input[type='tel']").addClass("ms-input-error");
				_self.find(".ms-validation-text").html("<span>"+word_translate.enter_a_valid_phone_number+"</span>");
				
			}


			// $.ajax({
			//   url: __flex_g_settings.ajaxUrl,
			//   method: "POST",
			//   data: _self.serialize(),
			//   dataType: "json",
			//   success: function (data) {
			//     //data.message
			//     $('#modal_properties_send .body_md .ico_ok').text(word_translate.email_sent);
			//     active_modal($('#modal_properties_send'));
			//     setTimeout(function () {
			//       $('#modal_properties_send').find('.close').click();
			//     }, 2000);
			//   }
			// });
		});
	    
		/*------------------------------------------------------------------------------------------*/
		/* Mostrar y cerrar modales
		/*------------------------------------------------------------------------------------------*/
		var $bodyHtml = $('html');
		$(document).on('click', '.overlay_modal_closer', function () {
			var idModal = $(this).attr('data-id');
			if ("1" == __flex_g_settings.force_registration) {
				$('#' + idModal).find('.close-modal').click();
				if ( __flex_g_settings.hasOwnProperty("force_registration_forced") && ("yes" == __flex_g_settings.force_registration_forced) ) {
					$(".ib-pbtnclose").click();
				}
				return;
			}

			if ($('button[data-id="modal_login"]:eq(0)').is(":hidden")) {
				$('#' + idModal).find('.close-modal').click();
				return;
			}

			var idModal = $(this).attr('data-id');
			var parentModal = $(this).attr('data-frame');
			$('#' + idModal).removeClass('active_modal');
			$bodyHtml.removeClass(parentModal);
			$('.content_md').removeClass('ms-hidden-extras');
		});

		// @todo check modal
		
		//CLOSE MODAL PARTE 1
    $(document).on('click', '.close-modal', function (event) {
      event.stopPropagation();

      var idModal = $(this).attr('data-id');
      var parentModal = $(this).attr('data-frame');
      $('#' + idModal).removeClass('active_modal');
      $bodyHtml.removeClass(parentModal);

      $('body').removeClass('only-mobile');
      $('.content_md').removeClass('ms-hidden-extras');

      if ("1" == __flex_g_settings.force_registration) {
        if ( __flex_g_settings.hasOwnProperty("force_registration_forced") && ("yes" == __flex_g_settings.force_registration_forced) ) {
          $(".ib-pbtnclose").click();
        }
        return;
      }

    });

    //CLOSE MODAL PARTE 2
    $('.modal_cm .close').click(function () {
      $('#modal_login, #overlay_modal, #modal_add_favorities, #modal_properties_send').removeClass('active_modal');

      if (typeof originalPositionY !== "undefined") {
        if (!$(".ib-modal-master.ib-mmpd").hasClass("ib-md-active")) {
          console.log('restoring to: ' + originalPositionY);
          window.scrollTo(0,originalPositionY);
        }
      }
    });


		$(document).on('click', '.show-modal', function () {
			var $idModal = $(this).attr('data-modal'); //Identificador del Modal a mostrar
			var $positionModal = $(this).attr('data-position'); //Posición en la que se encuentra el Modal
			var $modal = $('#' + $idModal);
			var $modalImg = $('#' + $idModal).find('.lazy-img').attr('data-src'); //Consultamos si existe una imagen para mostrar en el Modal
			if (typeof ($modalImg) != 'undefined') {
				$('#' + $idModal).find('.lazy-img').attr('src', $modalImg).removeAttr('data-src');
			}

			if ($modal.hasClass('active_modal')) {
				$('.overlay_modal').removeClass('active_modal');
			} else {
				$modal.addClass('active_modal');
				if ($positionModal == 0) {
					$bodyHtml.addClass('modal_fmobile');
				} else {
					$bodyHtml.addClass('modal_mobile');
				}
			}

			var mapImg = $("#min-map").attr("data-map-img");
			if (typeof (mapImg) != 'undefined') {
				$("#min-map").css("background-image", "url('" + mapImg + "')").removeAttr("data-map-img");
			}
		});

		/*==================================================*/
		/*=============== EMAIL TO A FRIEND ================*/
		/*==================================================*/
		$(document).on("click", ".showfriendEmail", function () {

			var imgProp = ""; var a = "";
			$("#mediaModal").html("");

			//RECUPERANDO VALORES DE CONSULTA
			var itemLg = $(this).attr("data-lg");
			var itemLt = $(this).attr("data-lt");
			var modalOrigin =  $(this).attr("data-origin");
			var mediaElement = $(this).attr("data-media");

			//RECUPERAMOS LOS TEXTOS
			var textBeds = $("#ib-email-to-friend").attr("data-text-beds");
			var textBath = $("#ib-email-to-friend").attr("data-text-bath");
			var textYear = $("#ib-email-to-friend").attr("data-text-year");
			var textCity = $("#ib-email-to-friend").attr("data-text-city");
			var textAddress = $("#ib-email-to-friend").attr("data-text-address");
			var textBedsFull = $("#ib-email-to-friend").attr("data-text-beds-full");
			
			//FORMATO DEL BLOQUE MEDIA (IMAGEN O MAPA)
			switch (mediaElement) {
				case 'ib-pva-photos':
					imgProp = $(this).parents("#full-main");
					
					if(imgProp.length){
						a = "full-main";
						$("#mediaModal").html(imgProp.find("#full-slider .gs-wrapper-content:first-child").html());
					}else{
						a = "modal-wrapper";
						imgProp = $(this).parents("#flex_idx_modal_wrapper");
						if(imgProp.length){
							$("#mediaModal").html(imgProp.find(".ib-modal-master .ib-property-detail .ib-pvslider .gs-item-slider:first-child").html());
						}else{
							a = "full-gallery";
							imgProp = $("#fullScreenModal");
							if(imgProp.length){
								$("#mediaModal").html(imgProp.find("#fullGalleryView .gs-wrapper-content:first-child").html());
							}
						}
					}
					break;
		
				case 'ib-pva-map':
					loadMapModal(itemLt,itemLg);
					break;
			}
		
			//FORMATO DE LA INFORMACION A MOSTRAR
			switch (modalOrigin) {
				case '1':
					//RECUPERAMOS LAS VARIABLES
					var itemPrice = $(this).attr("data-price");
					var itemBeds = $(this).attr("data-beds");
					var itemBaths = $(this).attr("data-baths");
					var itemSqft = $(this).attr("data-sqft");
					var itemAddress = $(this).attr("data-address");
		
					//GENERAMOS LA INFORMACION DE LA PROPIEDAD
					$("#msInfoPropertyModal").html(
						'<span class="ms-price-label"><span>'+itemPrice+'</span></span>'+
						'<span class="ms-bed-label"><span>'+itemBeds+'</span>&nbsp;'+textBeds+'</span>'+
						'<span class="ms-bath-label"><span>'+itemBaths+'</span>&nbsp;'+textBath+'</span>'+
						'<span class="ms-sqft-label"><span>'+itemSqft+'</span> Sqft</span>'+
						'<span class="ms-address-label"><span>'+itemAddress+'</span></span>'
					);

					$("#friend-comments").val($("#friend-comments").attr("data-comment")+" "+window.location.hostname+": "+itemAddress);
				break;
		
				case '2':
		
					//RECUPERAMOS LAS VARIABLES
					var itemName = $(this).attr("data-property");
					var itemBeds = $(this).attr("data-beds");
					var itemYear = $(this).attr("data-year");
					var itemCity = $(this).attr("data-city");
					var itemAddress = $(this).attr("data-address");
		
					//GENERAMOS LA INFORMACION DE LA PROPIEDAD
					$("#msInfoPropertyModal").html(
						'<span class="ms-price-label"><span>'+itemName+'</span></span>'+
						'<span class="ms-bed-label">'+textBedsFull+':&nbsp;<span>'+itemBeds+'</span></span>'+
						'<span class="ms-bed-label">'+textYear+':&nbsp;<span>'+itemYear+'</span></span>'+
						'<span class="ms-bed-label">'+textAddress+':&nbsp;<span>'+itemAddress+'</span></span>'+
						'<span class="ms-bed-label">'+textCity+':&nbsp;<span>'+itemCity+'</span></span>'
					);

					$("#friend-comments").val($("#friend-comments").attr("data-comment")+" "+window.location.hostname+": "+itemAddress);
				break;
			}
		});
		

		// handle socket auth
		/*
						if (__flex_g_settings.anonymous === 'yes') {
								if (localStorage.getItem('idxboost_credential')){
										var objectCredential=JSON.parse(localStorage.getItem('idxboost_credential'));
										if(objectCredential["user_name"].length>0 && objectCredential["user_pass"].length>0){
												Cookies.set('ib_lead_token', objectCredential['ib_lead_token'], { expires: 30 });
												window.location.reload(true);
										}
								}
						}
		*/
	 
		// if (__flex_g_settings.anonymous === 'no') {
			// socket = new Pusher(__flex_g_settings.pusher.app_key, {
			//   cluster: __flex_g_settings.pusher.app_cluster,
			//   encrypted: true,
			//   authEndpoint: __flex_g_settings.socketAuthUrl
			// });

			// channel = socket.subscribe(__flex_g_settings.pusher.presence_channel);

			// socket.connection.bind('connected', function() {
			//     console.dir(arguments);
			// });
			//
			// channel.bind('pusher:subscription_succeeded', function(members) {
			//     console.group('[pusher:subscription_succeeded]');
			//     console.dir(members);
			//     console.groupEnd('[pusher:subscription_succeeded]');
			// });
			//
			// channel.bind('pusher:member_added', function(member) {
			//     console.group('[pusher:member_added]');
			//     console.dir(member);
			//     console.groupEnd('[pusher:member_added]');
			// });
			//
			// channel.bind('pusher:member_removed', function(member) {
			//     console.group('[pusher:member_removed]');
			//     console.dir(member);
			//     console.groupEnd('[pusher:member_removed]');
			// });
			//
			// channel.bind('pusher:subscription_error', function(status) {
			//     console.group('[pusher:subscription_error]');
			//     console.dir(status);
			//     console.groupEnd('[pusher:subscription_error]');
			// });
		// }

		idxboostTypeIcon();

		// handle sign in
		$('#formLogin').on("submit", function (event) {
			event.preventDefault();

			var objectCredential = [];
			var _self = $(this);
			var formData = _self.serialize();
			var usernameCache = '',
				passwordCache = '';
			var seriaLogin = _self.serializeArray();
			var textmessage='';

			$.ajax({
				url: __flex_g_settings.ajaxUrl,
				method: "POST",
				data: formData,
				dataType: "json",
				success: function (response) {
					if (response.success === true) {
						// console.dir(seriaLogin);
						if (__flex_g_settings.has_cms == "1") {
							jQuery("body").addClass("logged");
							jQuery(".js-login").addClass("ip-d-none");
						}
						
						if (typeof dataLayer !== "undefined") {
							dataLayer.push({'event': 'email_signin'});
						}

						var lead_token = response.lead_token;

						Cookies.set("_ib_left_click_force_registration", 0);
						//Cookies.set('ib_lead_token', lead_token, { expires: 30 });
						Cookies.set('ib_lead_token', lead_token);

						// if available history menu for lead
						if (jQuery("#ib-lead-history-menu-btn").length) {
							jQuery.ajax({
								url :__flex_g_settings.fetchLeadActivitiesEndpoint,
								method: "POST",
								data: {
									access_token: __flex_g_settings.accessToken,
									flex_credentials: Cookies.get("ib_lead_token")
								},
								dataType: "json",
								success: function(response) {
									if ("yes" === response.lead_info.show_help_tooltip) {
										jQuery("#ib-lead-history-tooltip-help").show();
									}

									jQuery("#ib-lead-history-menu-btn").show();

									// fill generated values
									var fill_first_letter_name_values = [];

									if (response.lead_info.first_name.length) {
										fill_first_letter_name_values.push(response.lead_info.first_name.charAt(0));
									}

									if (response.lead_info.last_name.length) {
										fill_first_letter_name_values.push(response.lead_info.last_name.charAt(0));
									}

									jQuery(".ib-lead-first-letter-name").html(fill_first_letter_name_values.join(""));

									if (response.lead_info.hasOwnProperty('photo_url') && response.lead_info.photo_url.length) {
										jQuery(".ib-lead-first-letter-name").css({
											'background-color': 'transparent',
											'background-image': 'url(' + response.lead_info.photo_url + ')',
											'background-repeat': 'no-repeat',
											'background-size': 'contain',
											'background-position': 'center center',
											'text-indent': '-9999px'
										});
									}

									jQuery(".ib-lead-fullname").html(response.lead_info.first_name + " " + response.lead_info.last_name);
									jQuery(".ib-lead-firstname").html("Hello " + response.lead_info.first_name + "!");

									jQuery(".ib-agent-fullname").html(response.agent_info.first_name + " " + response.agent_info.last_name);
									//jQuery(".ib-agent-phonenumber").html(response.agent_info.phone_number);
									jQuery(".ib-agent-phonenumber").attr("href", "tel:" + response.agent_info.phone_number.replace(/[^\d]/g, ""));
									jQuery(".ib-agent-emailaddress").attr("href", "mailto:" + response.agent_info.email_address);
									jQuery(".ib-agent-photo-thumbnail-wrapper").empty();
									jQuery(".ib-agent-photo-thumbnail-wrapper").append('<img src="' + response.agent_info.photo_url + '">');

									// fill activity lead
									jQuery("#_ib_lead_activity_rows").empty();
									jQuery("#_ib_lead_activity_pagination").empty();

									if (response.lead_info.listing_views.length) {
										var lead_listing_views = response.lead_info.listing_views;
										var lead_listing_views_html = [];

										for (var i = 0, l = lead_listing_views.length; i < l; i++) {
											lead_listing_views_html.push('<div class="ms-history-menu-item">');
											lead_listing_views_html.push('<div class="ms-history-menu-wrap-img">');
											lead_listing_views_html.push('<img src="'+lead_listing_views[i].thumbnail+'">');
											lead_listing_views_html.push('</div>');
											lead_listing_views_html.push('<div class="ms-history-menu-property-detail">');
											lead_listing_views_html.push('<h3 class="ms-history-menu-title">'+lead_listing_views[i].address_short+'</h3>');
											lead_listing_views_html.push('<h4 class="ms-history-menu-address">'+lead_listing_views[i].address_large+'</h4>');
											lead_listing_views_html.push('<h5 class="ms-history-menu-price">'+lead_listing_views[i].price+'</h5>');
											lead_listing_views_html.push('<div class="ms-history-menu-details">');
												lead_listing_views_html.push('<span>'+lead_listing_views[i].bed+' Beds</span>');
												lead_listing_views_html.push('<span>'+lead_listing_views[i].bath+' Baths</span>');
												lead_listing_views_html.push('<span>'+lead_listing_views[i].sqft+' SqFt</span>');
											lead_listing_views_html.push('</div>');
											lead_listing_views_html.push('</div>');
											//console.log(lead_listing_views[i].mls_num);
											lead_listing_views_html.push('<div class="ms-history-menu-property-actions">');
											lead_listing_views_html.push('<button data-mls="'+lead_listing_views[i].mls_num+'" class="ib-la-hp ms-history-menu-delete"><span>Delete</span></button>');
											lead_listing_views_html.push('</div>');
											//lead_listing_views_html.push('<div class="ms-property-actions">');
											//lead_listing_views_html.push('<button class="ms-save"><span>save</span></button>');
											//lead_listing_views_html.push('<button class="ms-delete"><span>Delete</span></button>');
											//lead_listing_views_html.push('</div>');
											lead_listing_views_html.push('<a href="'+__flex_g_settings.propertyDetailPermalink+'/'+lead_listing_views[i].slug+'" target="_blank" class="ms-history-menu-link">'+lead_listing_views[i].address_short + ' ' +  lead_listing_views[i].address_large +'</a>');
											lead_listing_views_html.push('</div>');
										}

										jQuery("#_ib_lead_activity_rows").html(lead_listing_views_html.join(""));
									}

									// build pagination
									if (response.lead_info.hasOwnProperty('listing_views_pagination')) {
										if (response.lead_info.listing_views_pagination.total_pages > 1) {
											var lead_listing_views_paging = [];

											if (response.lead_info.listing_views_pagination.has_prev_page) {
												lead_listing_views_paging.push('<a role="button" class="ib-pagprev ib-paggo" data-page="'+(response.lead_info.listing_views_pagination.current_page - 1 )+'"></a>');
											}

											lead_listing_views_paging.push('<div class="ib-paglinks">');

											var lead_listing_views_page_range = response.lead_info.listing_views_pagination.page_range_links;

											for (var i = 0, l =  lead_listing_views_page_range.length; i < l; i++) {
												if (lead_listing_views_page_range[i] == response.lead_info.listing_views_pagination.current_page) {
													lead_listing_views_paging.push('<a role="button" class="ib-plitem ib-plitem-active" data-page="'+lead_listing_views_page_range[i]+'">'+lead_listing_views_page_range[i]+'</a>');
												} else {
													lead_listing_views_paging.push('<a role="button" class="ib-plitem" data-page="'+lead_listing_views_page_range[i]+'">'+lead_listing_views_page_range[i]+'</a>');
												}
											}

											lead_listing_views_paging.push('</div>');

											if (response.lead_info.listing_views_pagination.has_next_page) {
												lead_listing_views_paging.push('<a role="button" class="ib-pagnext ib-paggo" data-page="'+(response.lead_info.listing_views_pagination.current_page + 1 )+'"></a>');
											}

											jQuery("#_ib_lead_activity_pagination").html('<div class="ms-history-menu-wrapper-pagination">'+lead_listing_views_paging.join("")+'</div>');
										}
									}
								}
							});
						}

						if (true === IB_HAS_LEFT_CLICKS) {
							//Cookies.set("_ib_left_click_force_registration", parseInt(__flex_g_settings.signup_left_clicks, 10));
							Cookies.set("_ib_left_click_force_registration", 0);
						}

						// if ("undefined" !== typeof socket) {
						// 	socket.disconnect();
						//
						// 	socket = new Pusher(__flex_g_settings.pusher.app_key, {
						// 		cluster: __flex_g_settings.pusher.app_cluster,
						// 		encrypted: true,
						// 		authEndpoint: __flex_g_settings.socketAuthUrl + "?ib_lead_token=" + Cookies.get("ib_lead_token")
						// 	});
						//
						// 	socket.subscribe(__flex_g_settings.pusher.presence_channel);
						// }

						// callback [login]

						//socket.subscribe(__flex_g_settings.pusher.presence_channel);

						// save last logged in username
						Cookies.set("_ib_last_logged_in_username", response.last_logged_in_username);

						// store first name
						Cookies.set("_ib_user_firstname", response.first_name);

						// store last name
						Cookies.set("_ib_user_lastname", response.last_name);

						// store phone
						Cookies.set("_ib_user_phone", response.phone);

						// store email
						Cookies.set("_ib_user_email", response.email);

						// store code phone
						Cookies.set("_ib_user_code_phone", response.country_code_phone);

						var newPhoneFormat = Cookies.get("_ib_user_code_phone");
						var newPhoneNumber = Cookies.get("_ib_user_phone");
						
						if(typeof newPhoneFormat === "undefined" || newPhoneFormat === "null" || newPhoneFormat === "" || newPhoneFormat === "0"){
							newPhoneNumberFormat = newPhoneNumber;
						}else{
							newPhoneNumberFormat = "+"+newPhoneFormat+newPhoneNumber;
						}

						Cookies.set("_ib_user_new_phone_number", newPhoneNumberFormat);
						
						$("#_ib_fn_inq").val(response.first_name);
						$("#_ib_ln_inq").val(response.last_name);
						$("#_ib_em_inq").val(response.email);
						$("#_ib_ph_inq").val(Cookies.get("_ib_user_new_phone_number"));

						$("._ib_fn_inq").val(response.first_name);
						$("._ib_ln_inq").val(response.last_name);
						$("._ib_em_inq").val(response.email);
						$("._ib_ph_inq").val(Cookies.get("_ib_user_new_phone_number"));
						$("._ib_pc_inq").val(response.country_code_phone);

						$(".phoneCodeValidation").val(response.country_code_phone);

						//Building default label
						var ob_form_building_footer;
						ob_form_building_footer=$('.flex_idx_building_form');
						if (ob_form_building_footer.length>0){
							ob_form_building_footer.find('[name="first_name"]').val(response.first_name);
							ob_form_building_footer.find('[name="last_name"]').val(response.last_name);
							ob_form_building_footer.find('[name="email"]').val(response.email);
							ob_form_building_footer.find('[name="email_address"]').val(response.email);
							ob_form_building_footer.find('[name="phone"]').val(Cookies.get("_ib_user_new_phone_number"));
							ob_form_building_footer.find('[name="phoneCodeValidation"]').val(response.country_code_phone);
						}
						
						//modal regular filter default label
						var ob_form_modal;
						ob_form_modal=$('.ib-propery-inquiry-f');
						if (ob_form_modal.length>0){
							ob_form_modal.find('[name="first_name"]').val(response.first_name);
							ob_form_modal.find('[name="last_name"]').val(response.last_name);
							ob_form_modal.find('[name="email_address"]').val(response.email);
							ob_form_modal.find('[name="phone_number"]').val(Cookies.get("_ib_user_new_phone_number"));
							ob_form_modal.find('[name="phoneCodeValidation"]').val(response.country_code_phone);
						}

						var ob_form_regular_contact_form;
						ob_form_regular_contact_form=$('#flex_idx_contact_form');
						if (ob_form_regular_contact_form.length>0){
							ob_form_regular_contact_form.find('[name="name"]').val(response.first_name);
							ob_form_regular_contact_form.find('[name="lastname"]').val(response.last_name);
							ob_form_regular_contact_form.find('[name="email"]').val(response.email);
							ob_form_regular_contact_form.find('[name="phone_number"]').val(Cookies.get("_ib_user_new_phone_number"));
							ob_form_regular_contact_form.find('[name="phoneCodeValidation"]').val(response.country_code_phone);
						}

						//Off market listing default label
						var ob_form_off_market_listing;
						ob_form_off_market_listing=$('#flex-idx-property-form');
						if (ob_form_off_market_listing.length>0){
							ob_form_off_market_listing.find('[name="first_name"]').val(response.first_name);
							ob_form_off_market_listing.find('[name="last_name"]').val(response.last_name);
							ob_form_off_market_listing.find('[name="email"]').val(response.email);
							ob_form_off_market_listing.find('[name="phone"]').val(Cookies.get("_ib_user_new_phone_number"));
							ob_form_off_market_listing.find('[name="phoneCodeValidation"]').val(response.country_code_phone);
						}

						//Property form react Vacation Rentals
						var ob_property_form_vacation_rentals;
						ob_property_form_vacation_rentals=$('#propertyForm');
						if (ob_property_form_vacation_rentals.length>0){
							ob_property_form_vacation_rentals.find('[name="firstName"]').val(response.first_name);
							ob_property_form_vacation_rentals.find('[name="lastName"]').val(response.last_name);
							ob_property_form_vacation_rentals.find('[name="email"]').val(response.email);
							ob_property_form_vacation_rentals.find('[name="phone"]').val(Cookies.get("_ib_user_new_phone_number"));
							ob_property_form_vacation_rentals.find('[name="phoneCodeValidation"]').val(response.country_code_phone);
						}

						// Sets user information on CMS Forms
						if (
							typeof idxpages === 'object' && 
							idxpages.forms && 
							typeof idxpages.forms.init === 'function'
						) {
							idxpages.forms.init();
						}

						// dont close modal property
						//$(".close").click();

						__flex_g_settings.anonymous = "no";

						//force registration for building
						idx_auto_save_building(response);            
						//force registration for building
						
						if ((typeof lastOpenedProperty !== "undefined") && lastOpenedProperty.length) {
							// track listing view
							$.ajax({
								type: "POST",
								url: __flex_g_settings.ajaxUrl,
								data: {
									action: "track_property_view",
									board_id: __flex_g_settings.boardId,
									mls_number: (typeof lastOpenedProperty === "undefined") ? "" : lastOpenedProperty,
									mls_opened_list: ((Cookies.get("_ib_user_listing_views") === "undefined") ? [] : JSON.parse(Cookies.get("_ib_user_listing_views")) )
								},
								success: function(response) {
									console.log("track done for property #" + lastOpenedProperty);
									Cookies.set("_ib_user_listing_views", JSON.stringify([]));
								}
							});
						}

						$("#user-options").html(response.output);
						$(".lg-wrap-login:eq(0)").html(response.output);
						$(".lg-wrap-login:eq(0)").addClass("active");

						// $("#modal_login").removeClass("active_modal");
						$(".overlay_modal").removeClass("active_modal");
						$('html').removeClass('modal_mobile');

						objectCredential = {
							'user_name': usernameCache,
							'user_pass': passwordCache,
							'logon_type': 'email',
							'ib_lead_token': lead_token
						};

						localStorage.setItem('idxboost_credential', JSON.stringify(objectCredential));

						if (response.message=='Invalid credentials, try again.') 
							textmessage=word_translate.invalid_credentials_try_again;
						else if (response.message=='Logged in succesfully.')
							textmessage=word_translate.logged_in_succesfully;

						swal({
							title: word_translate.good_job,
							text: textmessage,
							type: "success",
							timer: 1000,
							showConfirmButton: false
						});

						if(typeof fc_ib_response_register === 'function') {
								fc_ib_response_register(response,'login');
						}

						setTimeout(function () {
							if (typeof originalPositionY !== "undefined") {
								if (!$(".ib-modal-master.ib-mmpd").hasClass("ib-md-active")) {
									console.log('restoring to: ' + originalPositionY);
									window.scrollTo(0,originalPositionY);
								}
						 	}

							/*CONSULTAR*/
							jQuery(".iboost-form-validation-loaded").each(function () {
								iti[jQuery(this).attr("data-id")].setNumber(Cookies.get("_ib_user_new_phone_number"));
							});

						}, 300);

					} else {
						
						if (response.message=='Invalid credentials, try again.') 
							textmessage=word_translate.invalid_credentials_try_again;
						else if (response.message=='Logged in succesfully.')
							textmessage=word_translate.logged_in_succesfully;
							sweetAlert(word_translate.oops, textmessage, "error");
					}
				}
			});
			
			$('.content_md').removeClass('ms-hidden-extras');
		});

		/*PASSWORD*/
		var resetPassPath;
		$(document).ready(function () {
			 resetPassPath = window.location.search.split('?passtoken=');
			if (resetPassPath.length == 2) {
				$('li.login').click();
				$(".header-tab a").removeClass('active');
				$('#formReset #reset_email').attr('placeholder', word_translate.enter_you_new_password);
				$('#formReset #reset_email').attr('type', 'password');
				$('#formReset .action').val('flex_idx_get_resetpass');
				$('#formReset .tokepa').val(resetPassPath[1]);
				$("ul.header-tab li:nth-child(3) a").addClass('active');
				$('#modal_login h2').text(word_translate.welcome_back);
				$(".text-slogan").text(word_translate.sign_in_below);
				$(".item_tab").removeClass('active');
				$("#tabReset").addClass('active');
				$("#modal_login").addClass("tabResetHidden");

				$("#reset_email").attr("required", "required");
				$("#reset_email").prev().hide();
				$("#ms-new-password-text").show();
				$("#ms-recovery-password-text").hide();
			}

			if (__flex_g_settings.anonymous == "no") {
				if (__flex_g_settings.has_cms == "1") {
					$("body").addClass("logged");
					$(".js-login").addClass("ip-d-none");
				}
			}
		});

		// handle sign in
		$('#formReset').on("submit", function (event) {
			event.preventDefault();

			var _self = $(this);
			var formData = _self.serialize();

			$.ajax({
				url: __flex_g_settings.ajaxUrl,
				method: "POST",
				data: formData,
				dataType: "json",
				success: function (response) {
					if (response.success === true) {           
						var lead_token = response.lead_token;

						Cookies.set("_ib_left_click_force_registration", 0);
						//Cookies.set('ib_lead_token', lead_token, { expires: 30 });
						Cookies.set('ib_lead_token', lead_token);

						$(".close").click();
						var text_mailbox='';
						if (response.message=='Check your mailbox'){
								text_mailbox=word_translate.check_your_mailbox;
						}else if (response.message=='Password Changed'){
							text_mailbox=word_translate.password_change;
						}

						swal({
							title: word_translate.good_job,
							text: text_mailbox,
							type: "success",
							timer: 8000,
							showConfirmButton: false
						});
					} else {
						var textmessage='';
						if (response.message=='Invalid credentials, try again.') 
							textmessage=word_translate.invalid_credentials_try_again;
						else if (response.message=='Logged in succesfully.')
							textmessage=word_translate.logged_in_succesfully;

						sweetAlert(word_translate.oops, textmessage, "error");
					}
				}
			});

			$('.content_md').removeClass('ms-hidden-extras');
		});
		/*PASSWORD*/

		// handle sign up
		$("#formRegister").on("submit", function (event) {
			event.preventDefault();

			var _self = $(this);
			var fub_chk = _self.parents("#modal_login").find(jQuery(".follow_up_boss_valid_register"));

			if(fub_chk.length){

				if(!fub_chk.prop('checked')){
					alert("You must accept the terms and conditions, and the privacy policy to continue");
					fub_chk.addClass("error");
					return;

				}else{

					var formData = _self.serialize();
					var objectCredential = [];
					var usernameCache = '',
							passwordCache = '';
					var seriaLogin = _self.serializeArray();

					// hide registration form
					$("#modal_login").removeClass("active_modal");

					swal({
						title: word_translate.your_account_is_being_created,
						text: word_translate.this_might_take_a_while_do_not_reload_thepage,
						type: "info",
						showConfirmButton: false,
						closeOnClickOutside: false,
						closeOnEsc: false
					});

					$.ajax({
						url: __flex_g_settings.ajaxUrl,
						method: "POST",
						data: formData,
						dataType: "json",
						success: function (response) {
							// if registration is sucessfully.
							if (true === response.success) {
								if (typeof dataLayer !== "undefined") {
									dataLayer.push({'event': 'email_register'});
								}

								if (__flex_g_settings.has_cms == "1") {
									jQuery("body").addClass("logged");
									jQuery(".js-login").addClass("ip-d-none");
								}

								if (true === IB_HAS_LEFT_CLICKS) {
									//Cookies.set("_ib_left_click_force_registration", parseInt(__flex_g_settings.signup_left_clicks, 10));
									Cookies.set("_ib_left_click_force_registration", 0);
								}

								Cookies.set("_ib_left_click_force_registration", 0);
								// stores into cookies current lead token
								//Cookies.set('ib_lead_token', lead_token, { expires: 30 });
								Cookies.set('ib_lead_token', response.lead_token);

								// if available history menu for lead
								if (jQuery("#ib-lead-history-menu-btn").length) {
									jQuery.ajax({
										url :__flex_g_settings.fetchLeadActivitiesEndpoint,
										method: "POST",
										data: {
											access_token: __flex_g_settings.accessToken,
											flex_credentials: Cookies.get("ib_lead_token")
										},
										dataType: "json",
										success: function(response) {
											if ("yes" === response.lead_info.show_help_tooltip) {
												jQuery("#ib-lead-history-tooltip-help").show();
											}

											jQuery("#ib-lead-history-menu-btn").show();

											// fill generated values
											var fill_first_letter_name_values = [];

											if (response.lead_info.first_name.length) {
												fill_first_letter_name_values.push(response.lead_info.first_name.charAt(0));
											}

											if (response.lead_info.last_name.length) {
												fill_first_letter_name_values.push(response.lead_info.last_name.charAt(0));
											}

											jQuery(".ib-lead-first-letter-name").html(fill_first_letter_name_values.join(""));

											if (response.lead_info.hasOwnProperty('photo_url') && response.lead_info.photo_url.length) {
												jQuery(".ib-lead-first-letter-name").css({
													'background-color': 'transparent',
													'background-image': 'url(' + response.lead_info.photo_url + ')',
													'background-repeat': 'no-repeat',
													'background-size': 'contain',
													'background-position': 'center center',
													'text-indent': '-9999px'
												});
											}

											jQuery(".ib-lead-fullname").html(response.lead_info.first_name + " " + response.lead_info.last_name);
											jQuery(".ib-lead-firstname").html("Hello " + response.lead_info.first_name + "!");

											jQuery(".ib-agent-fullname").html(response.agent_info.first_name + " " + response.agent_info.last_name);
											jQuery(".ib-agent-phonenumber").html(response.agent_info.phone_number);
											jQuery(".ib-agent-phonenumber").attr("href", "tel:" + response.agent_info.phone_number.replace(/[^\d]/g, ""));
											jQuery(".ib-agent-emailaddress").attr("href", "mailto:" + response.agent_info.email_address);
											jQuery(".ib-agent-photo-thumbnail-wrapper").empty();
											jQuery(".ib-agent-photo-thumbnail-wrapper").append('<img src="' + response.agent_info.photo_url + '">');

											// fill activity lead
											jQuery("#_ib_lead_activity_rows").empty();
											jQuery("#_ib_lead_activity_pagination").empty();

											if (response.lead_info.listing_views.length) {
												var lead_listing_views = response.lead_info.listing_views;
												var lead_listing_views_html = [];

												for (var i = 0, l = lead_listing_views.length; i < l; i++) {
													lead_listing_views_html.push('<div class="ms-history-menu-item">');
													lead_listing_views_html.push('<div class="ms-history-menu-wrap-img">');
													lead_listing_views_html.push('<img src="'+lead_listing_views[i].thumbnail+'">');
													lead_listing_views_html.push('</div>');
													lead_listing_views_html.push('<div class="ms-history-menu-property-detail">');
													lead_listing_views_html.push('<h3 class="ms-history-menu-title">'+lead_listing_views[i].address_short+'</h3>');
													lead_listing_views_html.push('<h4 class="ms-history-menu-address">'+lead_listing_views[i].address_large+'</h4>');
													lead_listing_views_html.push('<h5 class="ms-history-menu-price">'+lead_listing_views[i].price+'</h5>');
													lead_listing_views_html.push('<div class="ms-history-menu-details">');
														lead_listing_views_html.push('<span>'+lead_listing_views[i].bed+' Beds</span>');
														lead_listing_views_html.push('<span>'+lead_listing_views[i].bath+' Baths</span>');
														lead_listing_views_html.push('<span>'+lead_listing_views[i].sqft+' SqFt</span>');
													lead_listing_views_html.push('</div>');
													lead_listing_views_html.push('</div>');
													//console.log(lead_listing_views[i].mls_num);
													lead_listing_views_html.push('<div class="ms-history-menu-property-actions">');
													lead_listing_views_html.push('<button data-mls="'+lead_listing_views[i].mls_num+'" class="ib-la-hp ms-history-menu-delete"><span>Delete</span></button>');
													lead_listing_views_html.push('</div>');
													//lead_listing_views_html.push('<div class="ms-property-actions">');
													//lead_listing_views_html.push('<button class="ms-save"><span>save</span></button>');
													//lead_listing_views_html.push('<button class="ms-delete"><span>Delete</span></button>');
													//lead_listing_views_html.push('</div>');
													lead_listing_views_html.push('<a href="'+__flex_g_settings.propertyDetailPermalink+'/'+lead_listing_views[i].slug+'" target="_blank" class="ms-history-menu-link">'+lead_listing_views[i].address_short + ' ' +  lead_listing_views[i].address_large +'</a>');
													lead_listing_views_html.push('</div>');
												}

												jQuery("#_ib_lead_activity_rows").html(lead_listing_views_html.join(""));
											}

											// build pagination
											if (response.lead_info.hasOwnProperty('listing_views_pagination')) {
												if (response.lead_info.listing_views_pagination.total_pages > 1) {
													var lead_listing_views_paging = [];

													if (response.lead_info.listing_views_pagination.has_prev_page) {
														lead_listing_views_paging.push('<a role="button" class="ib-pagprev ib-paggo" data-page="'+(response.lead_info.listing_views_pagination.current_page - 1 )+'"></a>');
													}

													lead_listing_views_paging.push('<div class="ib-paglinks">');

													var lead_listing_views_page_range = response.lead_info.listing_views_pagination.page_range_links;

													for (var i = 0, l =  lead_listing_views_page_range.length; i < l; i++) {
														if (lead_listing_views_page_range[i] == response.lead_info.listing_views_pagination.current_page) {
															lead_listing_views_paging.push('<a role="button" class="ib-plitem ib-plitem-active" data-page="'+lead_listing_views_page_range[i]+'">'+lead_listing_views_page_range[i]+'</a>');
														} else {
															lead_listing_views_paging.push('<a role="button" class="ib-plitem" data-page="'+lead_listing_views_page_range[i]+'">'+lead_listing_views_page_range[i]+'</a>');
														}
													}

													lead_listing_views_paging.push('</div>');

													if (response.lead_info.listing_views_pagination.has_next_page) {
														lead_listing_views_paging.push('<a role="button" class="ib-pagnext ib-paggo" data-page="'+(response.lead_info.listing_views_pagination.current_page + 1 )+'"></a>');
													}

													jQuery("#_ib_lead_activity_pagination").html(lead_listing_views_paging.join(""));
												}
											}
										}
									});
								}

								//socket.subscribe(__flex_g_settings.pusher.presence_channel);
								// if ("undefined" !== typeof socket) {
								// 	socket.disconnect();
								//
								// 	socket = new Pusher(__flex_g_settings.pusher.app_key, {
								// 		cluster: __flex_g_settings.pusher.app_cluster,
								// 		encrypted: true,
								// 		authEndpoint: __flex_g_settings.socketAuthUrl + "?ib_lead_token=" + Cookies.get("ib_lead_token")
								// 	});
								//
								// 	socket.subscribe(__flex_g_settings.pusher.presence_channel);
								// }

								// save last logged in username
								Cookies.set("_ib_last_logged_in_username", response.last_logged_in_username);

								// store first name
								Cookies.set("_ib_user_firstname", response.first_name);

								// store last name
								Cookies.set("_ib_user_lastname", response.last_name);

								// store email
								Cookies.set("_ib_user_email", response.email);
								
								jQuery("#_ib_fn_inq").val(response.first_name);
								jQuery("#_ib_ln_inq").val(response.last_name);
								jQuery("#_ib_em_inq").val(response.email);
								jQuery("#_ib_ph_inq").val(Cookies.get("_ib_user_new_phone_number"));

								jQuery("._ib_fn_inq").val(response.first_name);
								jQuery("._ib_ln_inq").val(response.last_name);
								jQuery("._ib_em_inq").val(response.email);
								jQuery("._ib_ph_inq").val(Cookies.get("_ib_user_new_phone_number"));
								jQuery("._ib_pc_inq").val(Cookies.get("_ib_user_code_phone"));

								jQuery(".phoneCodeValidation").val(Cookies.get("_ib_user_code_phone"));

								//Building default label
								var ob_form_building_footer;
								ob_form_building_footer=jQuery('.flex_idx_building_form');
								if (ob_form_building_footer.length>0){
									ob_form_building_footer.find('input[name="first_name"]').val(response.first_name);
									ob_form_building_footer.find('input[name="last_name"]').val(response.last_name);
									ob_form_building_footer.find('input[name="email"]').val(response.email);
									ob_form_building_footer.find('input[name="email_address"]').val(response.email);
									ob_form_building_footer.find('input[name="phone"]').val(Cookies.get("_ib_user_new_phone_number"));
									ob_form_building_footer.find('input[name="phoneCodeValidation"]').val(Cookies.get("_ib_user_code_phone"));
								}
								
								//modal regular filter default label
								var ob_form_modal;
								ob_form_modal=jQuery('.ib-propery-inquiry-f');
								if (ob_form_modal.length>0){
									ob_form_modal.find('input[name="first_name"]').val(response.first_name);
									ob_form_modal.find('input[name="last_name"]').val(response.last_name);
									ob_form_modal.find('input[name="email_address"]').val(response.email);
									ob_form_modal.find('input[name="phone_number"]').val(Cookies.get("_ib_user_new_phone_number"));
									ob_form_modal.find('input[name="phoneCodeValidation"]').val(Cookies.get("_ib_user_code_phone"));
								}

								var ob_form_regular_contact_form;
								ob_form_regular_contact_form = jQuery('#flex_idx_contact_form');
								if (ob_form_regular_contact_form.length>0){
									ob_form_regular_contact_form.find('[name="name"]').val(response.first_name);
									ob_form_regular_contact_form.find('[name="lastname"]').val(response.last_name);
									ob_form_regular_contact_form.find('[name="email"]').val(response.email);
									ob_form_regular_contact_form.find('[name="phone_number"]').val(Cookies.get("_ib_user_new_phone_number"));
									ob_form_regular_contact_form.find('[name="phoneCodeValidation"]').val(response.country_code_phone);
								}

								//Off market listing default label
								var ob_form_off_market_listing;
								ob_form_off_market_listing=jQuery('#flex-idx-property-form');
								if (ob_form_off_market_listing.length>0){
									ob_form_off_market_listing.find('input[name="first_name"]').val(response.first_name);
									ob_form_off_market_listing.find('input[name="last_name"]').val(response.last_name);
									ob_form_off_market_listing.find('input[name="email"]').val(response.email);
									ob_form_off_market_listing.find('input[name="phone"]').val(Cookies.get("_ib_user_new_phone_number"));
									ob_form_off_market_listing.find('input[name="phoneCodeValidation"]').val(Cookies.get("_ib_user_code_phone"));
								}

								var ob_contact_form;
								ob_contact_form = jQuery('#ip-form');
								if (ob_contact_form.length>0){
									ob_contact_form.find('input[name="name"]').val(response.first_name);
									ob_contact_form.find('input[name="lastname"]').val(response.last_name);
									ob_contact_form.find('input[name="email"]').val(response.email);
									ob_contact_form.find('input[name="phone"]').val(Cookies.get("_ib_user_new_phone_number"));
									ob_contact_form.find('input[name="phoneCodeValidation"]').val(Cookies.get("_ib_user_code_phone"));
								}

								//Property form react Vacation Rentals
								var ob_property_form_vacation_rentals;
								ob_property_form_vacation_rentals = jQuery('#propertyForm');
								if (ob_property_form_vacation_rentals.length>0){
									ob_property_form_vacation_rentals.find('[name="firstName"]').val(response.first_name);
									ob_property_form_vacation_rentals.find('[name="lastName"]').val(response.last_name);
									ob_property_form_vacation_rentals.find('[name="email"]').val(response.email);
									ob_property_form_vacation_rentals.find('[name="phone"]').val(Cookies.get("_ib_user_new_phone_number"));
									ob_property_form_vacation_rentals.find('[name="phoneCodeValidation"]').val(response.country_code_phone);
								}

								// store phone
								//console.log("REGISTER_ib_user_phone"+Cookies.get("_ib_user_phone"));
								//console.log("REGISTER_ib_user_code_phone"+Cookies.get("_ib_user_code_phone"));
								//console.log("REGISTER_ib_user_new_phone_number"+Cookies.get("_ib_user_new_phone_number"));

								// Sets user information on CMS Forms
								if (
									typeof idxpages === 'object' && 
									idxpages.forms && 
									typeof idxpages.forms.init === 'function'
								) {
									idxpages.forms.init();
								}

								// updates lead list menu HTML
								$("#user-options").html(response.output);
								$(".lg-wrap-login:eq(0)").html(response.output);
								$(".lg-wrap-login:eq(0)").addClass("active");

								$('html').removeClass('modal_mobile');

								// reset registration form
								_self.trigger('reset');

								// overwrite lead status globally
								__flex_g_settings.anonymous = "no";

								console.log(Cookies.get("_ib_user_listing_views"));
								console.log(lastOpenedProperty);

								//if ("undefined" !== lastOpenedProperty) {
								// if (typeof lastOpenedProperty !== "undefined") {
								// 	// if (typeof loadPropertyInModal !== "undefined") {
								// 		window.loadPropertyInModal(lastOpenedProperty);
								// 	// }
								// }

								if ((typeof lastOpenedProperty !== "undefined") && lastOpenedProperty.length) {
									// track listing view
									$.ajax({
										type: "POST",
										url: __flex_g_settings.ajaxUrl,
										data: {
											action: "track_property_view",
											board_id: __flex_g_settings.boardId,
											mls_number: (typeof lastOpenedProperty === "undefined") ? "" : lastOpenedProperty,
											mls_opened_list: ((Cookies.get("_ib_user_listing_views") === "undefined") ? [] : JSON.parse(Cookies.get("_ib_user_listing_views")) )
										},
										success: function(response) {
											console.log("track done for property #" + lastOpenedProperty);
											Cookies.set("_ib_user_listing_views", JSON.stringify([]));
										}
									});
								}

								// notify user with success message

								var ib_log_message = response.message;
								if (response.message=='Logged in succesfully.'){
									ib_log_message=word_translate.logged_in_succesfully;
								}else if(response.message=='Your account has been created successfully.'){
									ib_log_message=word_translate.your_account_has_been_created_successfully;
								}

								swal({
									title: word_translate.congratulations,
									text: ib_log_message,
									type: "success",
									showConfirmButton: false,
									closeOnClickOutside: true,
									closeOnEsc: true,
									timer: 3000
								});

								if(typeof fc_ib_response_register === 'function') {
										fc_ib_response_register(response,'register');
								}

								setTimeout(function () {
									if (typeof originalPositionY !== "undefined") {
										if (!$(".ib-modal-master.ib-mmpd").hasClass("ib-md-active")) {
											console.log('restoring to: ' + originalPositionY);
											window.scrollTo(0,originalPositionY);
										}
									}
								}, 3000);
								
								if ( ("undefined" !== typeof IB_IS_SEARCH_FILTER_PAGE) && (true === IB_IS_SEARCH_FILTER_PAGE) ||
										("undefined" !== typeof IB_IS_REGULAR_FILTER_PAGE) && (true === IB_IS_REGULAR_FILTER_PAGE) 
								) {
									// save filter for lead is it doesnt exists
									saveFilterSearchForLead();
								}

								if (typeof gtagfucntion == 'function') {
									gtagfucntion();
								} //to generate the google tag conversion of signed in user
							} else {
								// notify user with error message
								var textmessage='';

								if (response.message=='Invalid credentials, try again.') {
									textmessage=word_translate.invalid_credentials_try_again;
								} else if (response.message=='Logged in succesfully.') {
									textmessage=word_translate.logged_in_succesfully;
								} else {
									textmessage = response.message;
								}

								swal({
									title: word_translate.oops,
									text: textmessage,
									type: "error",
									showConfirmButton: false,
									closeOnClickOutside: true,
									closeOnEsc: true,
									timer: 3000
								});

								setTimeout(function () {
									// show first screen of registration form
									$("#formRegister").find(".pr-step").removeClass("active");
									$("#formRegister").find(".pr-step:eq(0)").addClass("active");

									// show registration form
									$("#modal_login").addClass("active_modal");
								}, 3000);
							}
						}
					});

					$('.content_md').removeClass('ms-hidden-extras');

				}

			}else{

				var formData = _self.serialize();
				var objectCredential = [];
				var usernameCache = '',
						passwordCache = '';
				var seriaLogin = _self.serializeArray();

				// hide registration form
				$("#modal_login").removeClass("active_modal");

				swal({
					title: word_translate.your_account_is_being_created,
					text: word_translate.this_might_take_a_while_do_not_reload_thepage,
					type: "info",
					showConfirmButton: false,
					closeOnClickOutside: false,
					closeOnEsc: false
				});

				$.ajax({
					url: __flex_g_settings.ajaxUrl,
					method: "POST",
					data: formData,
					dataType: "json",
					success: function (response) {
						// if registration is sucessfully.
						if (true === response.success) {
							if (typeof dataLayer !== "undefined") {
								dataLayer.push({'event': 'email_register'});
							}

							if (__flex_g_settings.has_cms == "1") {
								jQuery("body").addClass("logged");
								jQuery(".js-login").addClass("ip-d-none");
							}

							if (true === IB_HAS_LEFT_CLICKS) {
								//Cookies.set("_ib_left_click_force_registration", parseInt(__flex_g_settings.signup_left_clicks, 10));
								Cookies.set("_ib_left_click_force_registration", 0);
							}

							Cookies.set("_ib_left_click_force_registration", 0);

							// stores into cookies current lead token
							//Cookies.set('ib_lead_token', lead_token, { expires: 30 });
							Cookies.set('ib_lead_token', lead_token);

							// if available history menu for lead
							if (jQuery("#ib-lead-history-menu-btn").length) {
								jQuery.ajax({
									url :__flex_g_settings.fetchLeadActivitiesEndpoint,
									method: "POST",
									data: {
										access_token: __flex_g_settings.accessToken,
										flex_credentials: Cookies.get("ib_lead_token")
									},
									dataType: "json",
									success: function(response) {
										if ("yes" === response.lead_info.show_help_tooltip) {
											jQuery("#ib-lead-history-tooltip-help").show();
										}

										jQuery("#ib-lead-history-menu-btn").show();

										// fill generated values
										var fill_first_letter_name_values = [];

										if (response.lead_info.first_name.length) {
											fill_first_letter_name_values.push(response.lead_info.first_name.charAt(0));
										}

										if (response.lead_info.last_name.length) {
											fill_first_letter_name_values.push(response.lead_info.last_name.charAt(0));
										}

										jQuery(".ib-lead-first-letter-name").html(fill_first_letter_name_values.join(""));

										if (response.lead_info.hasOwnProperty('photo_url') && response.lead_info.photo_url.length) {
											jQuery(".ib-lead-first-letter-name").css({
												'background-color': 'transparent',
												'background-image': 'url(' + response.lead_info.photo_url + ')',
												'background-repeat': 'no-repeat',
												'background-size': 'contain',
												'background-position': 'center center',
												'text-indent': '-9999px'
											});
										}

										jQuery(".ib-lead-fullname").html(response.lead_info.first_name + " " + response.lead_info.last_name);
										jQuery(".ib-lead-firstname").html("Hello " + response.lead_info.first_name + "!");

										jQuery(".ib-agent-fullname").html(response.agent_info.first_name + " " + response.agent_info.last_name);
										//jQuery(".ib-agent-phonenumber").html(response.agent_info.phone_number);
										jQuery(".ib-agent-phonenumber").attr("href", "tel:" + response.agent_info.phone_number.replace(/[^\d]/g, ""));
										jQuery(".ib-agent-emailaddress").attr("href", "mailto:" + response.agent_info.email_address);
										jQuery(".ib-agent-photo-thumbnail-wrapper").empty();
										jQuery(".ib-agent-photo-thumbnail-wrapper").append('<img src="' + response.agent_info.photo_url + '">');

										// fill activity lead
										jQuery("#_ib_lead_activity_rows").empty();
										jQuery("#_ib_lead_activity_pagination").empty();

										if (response.lead_info.listing_views.length) {
											var lead_listing_views = response.lead_info.listing_views;
											var lead_listing_views_html = [];

											for (var i = 0, l = lead_listing_views.length; i < l; i++) {
												lead_listing_views_html.push('<div class="ms-history-menu-item">');
												lead_listing_views_html.push('<div class="ms-history-menu-wrap-img">');
												lead_listing_views_html.push('<img src="'+lead_listing_views[i].thumbnail+'">');
												lead_listing_views_html.push('</div>');
												lead_listing_views_html.push('<div class="ms-history-menu-property-detail">');
												lead_listing_views_html.push('<h3 class="ms-history-menu-title">'+lead_listing_views[i].address_short+'</h3>');
												lead_listing_views_html.push('<h4 class="ms-history-menu-address">'+lead_listing_views[i].address_large+'</h4>');
												lead_listing_views_html.push('<h5 class="ms-history-menu-price">'+lead_listing_views[i].price+'</h5>');
												lead_listing_views_html.push('<div class="ms-history-menu-details">');
													lead_listing_views_html.push('<span>'+lead_listing_views[i].bed+' Beds</span>');
													lead_listing_views_html.push('<span>'+lead_listing_views[i].bath+' Baths</span>');
													lead_listing_views_html.push('<span>'+lead_listing_views[i].sqft+' SqFt</span>');
												lead_listing_views_html.push('</div>');
												lead_listing_views_html.push('</div>');
												//console.log(lead_listing_views[i].mls_num);
												lead_listing_views_html.push('<div class="ms-history-menu-property-actions">');
												lead_listing_views_html.push('<button data-mls="'+lead_listing_views[i].mls_num+'" class="ib-la-hp ms-history-menu-delete"><span>Delete</span></button>');
												lead_listing_views_html.push('</div>');
												//lead_listing_views_html.push('<div class="ms-property-actions">');
												//lead_listing_views_html.push('<button class="ms-save"><span>save</span></button>');
												//lead_listing_views_html.push('<button class="ms-delete"><span>Delete</span></button>');
												//lead_listing_views_html.push('</div>');
												lead_listing_views_html.push('<a href="'+__flex_g_settings.propertyDetailPermalink+'/'+lead_listing_views[i].slug+'" target="_blank" class="ms-history-menu-link">'+lead_listing_views[i].address_short + ' ' +  lead_listing_views[i].address_large +'</a>');
												lead_listing_views_html.push('</div>');
											}

											jQuery("#_ib_lead_activity_rows").html(lead_listing_views_html.join(""));
										}

										// build pagination
										if (response.lead_info.hasOwnProperty('listing_views_pagination')) {
											if (response.lead_info.listing_views_pagination.total_pages > 1) {
												var lead_listing_views_paging = [];

												if (response.lead_info.listing_views_pagination.has_prev_page) {
													lead_listing_views_paging.push('<a role="button" class="ib-pagprev ib-paggo" data-page="'+(response.lead_info.listing_views_pagination.current_page - 1 )+'"></a>');
												}

												lead_listing_views_paging.push('<div class="ib-paglinks">');

												var lead_listing_views_page_range = response.lead_info.listing_views_pagination.page_range_links;

												for (var i = 0, l =  lead_listing_views_page_range.length; i < l; i++) {
													if (lead_listing_views_page_range[i] == response.lead_info.listing_views_pagination.current_page) {
														lead_listing_views_paging.push('<a role="button" class="ib-plitem ib-plitem-active" data-page="'+lead_listing_views_page_range[i]+'">'+lead_listing_views_page_range[i]+'</a>');
													} else {
														lead_listing_views_paging.push('<a role="button" class="ib-plitem" data-page="'+lead_listing_views_page_range[i]+'">'+lead_listing_views_page_range[i]+'</a>');
													}
												}

												lead_listing_views_paging.push('</div>');

												if (response.lead_info.listing_views_pagination.has_next_page) {
													lead_listing_views_paging.push('<a role="button" class="ib-pagnext ib-paggo" data-page="'+(response.lead_info.listing_views_pagination.current_page + 1 )+'"></a>');
												}

												jQuery("#_ib_lead_activity_pagination").html('<div class="ms-history-menu-wrapper-pagination">'+lead_listing_views_paging.join("")+'</div>');
											}
										}
									}
								});
							}

							//socket.subscribe(__flex_g_settings.pusher.presence_channel);
							// if ("undefined" !== typeof socket) {
							// 	socket.disconnect();
							//
							// 	socket = new Pusher(__flex_g_settings.pusher.app_key, {
							// 		cluster: __flex_g_settings.pusher.app_cluster,
							// 		encrypted: true,
							// 		authEndpoint: __flex_g_settings.socketAuthUrl + "?ib_lead_token=" + Cookies.get("ib_lead_token")
							// 	});
							//
							// 	socket.subscribe(__flex_g_settings.pusher.presence_channel);
							// }

							// save last logged in username
							Cookies.set("_ib_last_logged_in_username", response.last_logged_in_username);

							// store first name
							Cookies.set("_ib_user_firstname", response.first_name);

							// store last name
							Cookies.set("_ib_user_lastname", response.last_name);

							// store email
							Cookies.set("_ib_user_email", response.email);
							
							jQuery("#_ib_fn_inq").val(response.first_name);
							jQuery("#_ib_ln_inq").val(response.last_name);
							jQuery("#_ib_em_inq").val(response.email);
							jQuery("#_ib_ph_inq").val(Cookies.get("_ib_user_new_phone_number"));

							jQuery("._ib_fn_inq").val(response.first_name);
							jQuery("._ib_ln_inq").val(response.last_name);
							jQuery("._ib_em_inq").val(response.email);
							jQuery("._ib_ph_inq").val(Cookies.get("_ib_user_new_phone_number"));
							jQuery("._ib_pc_inq").val(Cookies.get("_ib_user_code_phone"));

							jQuery(".phoneCodeValidation").val(Cookies.get("_ib_user_code_phone"));

							//Building default label
							var ob_form_building_footer;
							ob_form_building_footer=jQuery('.flex_idx_building_form');
							if (ob_form_building_footer.length>0){
								ob_form_building_footer.find('input[name="first_name"]').val(response.first_name);
								ob_form_building_footer.find('input[name="last_name"]').val(response.last_name);
								ob_form_building_footer.find('input[name="email"]').val(response.email);
								ob_form_building_footer.find('input[name="email_address"]').val(response.email);
								ob_form_building_footer.find('input[name="phone"]').val(Cookies.get("_ib_user_new_phone_number"));
								ob_form_building_footer.find('input[name="phoneCodeValidation"]').val(Cookies.get("_ib_user_code_phone"));
							}
							
							//modal regular filter default label
							var ob_form_modal;
							ob_form_modal=jQuery('.ib-propery-inquiry-f');
							if (ob_form_modal.length>0){
								ob_form_modal.find('input[name="first_name"]').val(response.first_name);
								ob_form_modal.find('input[name="last_name"]').val(response.last_name);
								ob_form_modal.find('input[name="email_address"]').val(response.email);
								ob_form_modal.find('input[name="phone_number"]').val(Cookies.get("_ib_user_new_phone_number"));
								ob_form_modal.find('input[name="phoneCodeValidation"]').val(Cookies.get("_ib_user_code_phone"));
							}

							var ob_form_regular_contact_form;
							ob_form_regular_contact_form = jQuery('#flex_idx_contact_form');
							if (ob_form_regular_contact_form.length>0){
								ob_form_regular_contact_form.find('[name="name"]').val(response.first_name);
								ob_form_regular_contact_form.find('[name="lastname"]').val(response.last_name);
								ob_form_regular_contact_form.find('[name="email"]').val(response.email);
								ob_form_regular_contact_form.find('[name="phone_number"]').val(Cookies.get("_ib_user_new_phone_number"));
								ob_form_regular_contact_form.find('[name="phoneCodeValidation"]').val(response.country_code_phone);
							}

							//Off market listing default label
							var ob_form_off_market_listing;
							ob_form_off_market_listing=jQuery('#flex-idx-property-form');
							if (ob_form_off_market_listing.length>0){
								ob_form_off_market_listing.find('input[name="first_name"]').val(response.first_name);
								ob_form_off_market_listing.find('input[name="last_name"]').val(response.last_name);
								ob_form_off_market_listing.find('input[name="email"]').val(response.email);
								ob_form_off_market_listing.find('input[name="phone"]').val(Cookies.get("_ib_user_new_phone_number"));
								ob_form_off_market_listing.find('input[name="phoneCodeValidation"]').val(Cookies.get("_ib_user_code_phone"));
							}

							var ob_contact_form;
							ob_contact_form = jQuery('#ip-form');
							if (ob_contact_form.length>0){
								ob_contact_form.find('input[name="name"]').val(response.first_name);
								ob_contact_form.find('input[name="lastname"]').val(response.last_name);
								ob_contact_form.find('input[name="email"]').val(response.email);
								ob_contact_form.find('input[name="phone"]').val(Cookies.get("_ib_user_new_phone_number"));
								ob_contact_form.find('input[name="phoneCodeValidation"]').val(Cookies.get("_ib_user_code_phone"));
							}

							//Property form react Vacation Rentals
							var ob_property_form_vacation_rentals;
							ob_property_form_vacation_rentals = jQuery('#propertyForm');
							if (ob_property_form_vacation_rentals.length>0){
								ob_property_form_vacation_rentals.find('[name="firstName"]').val(response.first_name);
								ob_property_form_vacation_rentals.find('[name="lastName"]').val(response.last_name);
								ob_property_form_vacation_rentals.find('[name="email"]').val(response.email);
								ob_property_form_vacation_rentals.find('[name="phone"]').val(Cookies.get("_ib_user_new_phone_number"));
								ob_property_form_vacation_rentals.find('[name="phoneCodeValidation"]').val(response.country_code_phone);
							}

							// store phone
							//console.log("REGISTER_ib_user_phone"+Cookies.get("_ib_user_phone"));
							//console.log("REGISTER_ib_user_code_phone"+Cookies.get("_ib_user_code_phone"));
							//console.log("REGISTER_ib_user_new_phone_number"+Cookies.get("_ib_user_new_phone_number"));

							// Sets user information on CMS Forms
							if (
								typeof idxpages === 'object' && 
								idxpages.forms && 
								typeof idxpages.forms.init === 'function'
							) {
								idxpages.forms.init();
							}

							// updates lead list menu HTML
							$("#user-options").html(response.output);
							$(".lg-wrap-login:eq(0)").html(response.output);
							$(".lg-wrap-login:eq(0)").addClass("active");

							$('html').removeClass('modal_mobile');

							// reset registration form
							_self.trigger('reset');

							// overwrite lead status globally
							__flex_g_settings.anonymous = "no";

							console.log(Cookies.get("_ib_user_listing_views"));
							console.log(lastOpenedProperty);

							//if ("undefined" !== lastOpenedProperty) {
							// if (typeof lastOpenedProperty !== "undefined") {
							// 	// if (typeof loadPropertyInModal !== "undefined") {
							// 		window.loadPropertyInModal(lastOpenedProperty);
							// 	// }
							// }

							if ((typeof lastOpenedProperty !== "undefined") && lastOpenedProperty.length) {
								// track listing view
								$.ajax({
									type: "POST",
									url: __flex_g_settings.ajaxUrl,
									data: {
										action: "track_property_view",
										board_id: __flex_g_settings.boardId,
										mls_number: (typeof lastOpenedProperty === "undefined") ? "" : lastOpenedProperty,
										mls_opened_list: ((Cookies.get("_ib_user_listing_views") === "undefined") ? [] : JSON.parse(Cookies.get("_ib_user_listing_views")) )
									},
									success: function(response) {
										console.log("track done for property #" + lastOpenedProperty);
										Cookies.set("_ib_user_listing_views", JSON.stringify([]));
									}
								});
							}

							// notify user with success message

							var ib_log_message = response.message;
							if (response.message=='Logged in succesfully.'){
								ib_log_message=word_translate.logged_in_succesfully;
							}else if(response.message=='Your account has been created successfully.'){
								ib_log_message=word_translate.your_account_has_been_created_successfully;
							}

							swal({
								title: word_translate.congratulations,
								text: ib_log_message,
								type: "success",
								showConfirmButton: false,
								closeOnClickOutside: true,
								closeOnEsc: true,
								timer: 3000
							});

							if(typeof fc_ib_response_register === 'function') {
									fc_ib_response_register(response,'register');
							}

							setTimeout(function () {
								if (typeof originalPositionY !== "undefined") {
									if (!$(".ib-modal-master.ib-mmpd").hasClass("ib-md-active")) {
										console.log('restoring to: ' + originalPositionY);
										window.scrollTo(0,originalPositionY);
									}
								}
							}, 3000);
							
							if ( ("undefined" !== typeof IB_IS_SEARCH_FILTER_PAGE) && (true === IB_IS_SEARCH_FILTER_PAGE) ||
									("undefined" !== typeof IB_IS_REGULAR_FILTER_PAGE) && (true === IB_IS_REGULAR_FILTER_PAGE) 
							) {
								// save filter for lead is it doesnt exists
								saveFilterSearchForLead();
							}

							if (typeof gtagfucntion == 'function') {
								gtagfucntion();
							} //to generate the google tag conversion of signed in user
						} else {
							// notify user with error message
							var textmessage='';

							if (response.message=='Invalid credentials, try again.') {
								textmessage=word_translate.invalid_credentials_try_again;
							} else if (response.message=='Logged in succesfully.') {
								textmessage=word_translate.logged_in_succesfully;
							} else {
								textmessage = response.message;
							}

							swal({
								title: word_translate.oops,
								text: textmessage,
								type: "error",
								showConfirmButton: false,
								closeOnClickOutside: true,
								closeOnEsc: true,
								timer: 3000
							});

							setTimeout(function () {
								// show first screen of registration form
								$("#formRegister").find(".pr-step").removeClass("active");
								$("#formRegister").find(".pr-step:eq(0)").addClass("active");

								// show registration form
								$("#modal_login").addClass("active_modal");
							}, 3000);
						}
					}
				});

				$('.content_md').removeClass('ms-hidden-extras');

			}

		});

		//TABS DEL MODAL DE LOGIN
		$(".header-tab a").click(function () {
			var loginHeight = 0;
			$(".header-tab a").removeClass('active');
			$(this).addClass('active');
			var tabId = $(this).attr('data-tab');
			var $loginText = "";
			var $resetText = "";
			var $registerText = "";
			switch (tabId) {
				case 'tabLogin':

					jQuery(".ms-fub-register").addClass("hidden");
					jQuery(".ms-footer-sm").removeClass("hidden");

					/*$("#modal_login h2").text(word_translate.welcome_back);*/
					$("#modal_login #msRst").empty().html($("#mstextFst").html());

					var $dataText = $(this).attr("data-text");
					var $dataTextForce = $(this).attr("data-text-force");

					if ($(this).parents("#modal_login").hasClass("registration_forced")) {
						$loginText = $dataTextForce;
					} else {
						$loginText = $dataText;
					}

					$("#modal_login h2").html($loginText);
					$(".text-slogan").text(word_translate.sign_in_below);
					$(".modal_cm.social_items .footer_md").show();
					$("#modal_login").removeClass("tabResetHidden");
					break;

				case 'tabRegister':

					jQuery(".ms-fub-register").removeClass("hidden");
					jQuery(".ms-footer-sm").addClass("hidden");

					$("#modal_login #msRst").empty().html($("#mstextRst").html());

					/*$("#modal_login h2").text(word_translate.register);*/
					var $dataText = $(this).attr("data-text");
					var $dataTextForce = $(this).attr("data-text-force");

					//if ($(this).parents("#modal_login").hasClass("registration_forced")) {
					if ("1" == __flex_g_settings.force_registration) {
						$registerText = $dataTextForce;
					} else {
						$registerText = $dataText;
					}

					$("#modal_login h2").html($registerText);
					$(".text-slogan").text(word_translate.join_to_save_listings_and_receive_updates);
					$(".modal_cm.social_items .footer_md").show();
					$("#modal_login").removeClass("tabResetHidden");
					break;

				case 'tabReset':
					/*$("#modal_login h2").text(word_translate.reset_password);*/

					var $dataText = $(this).attr("data-text");
					var $dataTextForce = $(this).attr("data-text-force");

					if ($(this).parents("#modal_login").hasClass("registration_forced")) {
						$resetText = $dataTextForce;
					} else {
						$resetText = $dataText;
					}

					$("#modal_login h2").html($resetText);
					$(".text-slogan").text(word_translate.sign_in_below);
					$(".modal_cm.social_items .footer_md").show();
					$("#modal_login").addClass("tabResetHidden");
					break;
			}

			$(".item_tab").removeClass('active');
			$("#" + tabId).addClass('active');
			loginHeight = $("#content-info-modal").height();
			$(".img_modal").css({
				'height': loginHeight + 'px'
			});
		});

		$(".flex-login-link").on("click", function (event) {
			event.preventDefault();
			active_modal($("#modal_login"));
		});

		$('.searchArea-container').click(function () {
			if (!$('ul#list-news-cates').is(":visible")) {
				$('ul#list-news-cates').slideDown();
			} else {
				$('ul#list-news-cates').hide();
			}
		});


		/*$('ul#user-options li').click(function() {var modal_acti = '#' + $(this).attr('data-modal');$(modal_acti).addClass('active_modal');});*/
		$('ul#user-options li').click(function (event) {
			var tmpPositionY = Math.max(window.pageYOffset, document.documentElement.scrollTop, document.body.scrollTop);

			if (tmpPositionY > 0) {
				originalPositionY = tmpPositionY;
			}

			// if (originalPositionY > 0 ) {
			//   originalPositionY = Math.max(window.pageYOffset, document.documentElement.scrollTop, document.body.scrollTop);
			// }
			
			// console.log('opening...');
			// console.log(originalPositionY);

			var tabactive = '';
			var modal_acti = '#' + $(this).attr('data-modal');
			$(modal_acti).addClass('active_modal');
			tabactive = $(this).attr('data-tab');
			$('.active_modal .header-tab li a').removeClass('active');
			$(".header-tab li a[data-tab='" + tabactive + "']").addClass('active');
			$(".active_modal .header-tab li .active").click();
			$('html').addClass('modal_mobile');
		});

		$('#user-options .external-lg-item').click(function () {
			var tabactive = '';
			var modal_acti = '#' + $(this).attr('data-modal');
			$(modal_acti).addClass('active_modal');
			tabactive = $(this).attr('data-tab');
			$('.active_modal .header-tab li a').removeClass('active');
			$(".header-tab li a[data-tab='" + tabactive + "']").addClass('active');
			$(".active_modal .header-tab li .active").click();
		});

		$(document).on("click", "#user-options", function(event) {
			event.stopPropagation();
		});

		$(document).on("click", '.show_modal_login_active', function () {
			$('html').removeClass('modal_mobile');

			if (!$(".menu_login_active").hasClass("active_login")) {
				$(".menu_login_active").removeClass("disable_login").addClass("active_login");
			} else {
				$(".menu_login_active").removeClass("active_login").addClass("disable_login");
			}
		});

		$(document).on("click", function() {
			$(".menu_login_active").removeClass("active_login").addClass("disable_login");
		});

		$(document).on('click', '.languages-list .item-languages', function () {
			var $selectLanguage = $(this).attr('data-iso');
			switch ($selectLanguage) {
				case 'us':
					$($(".goog-te-menu-frame")).contents().find("span.text").each(function () {
						if ($(this).html() == "Inglés" || $(this).html() == "English" || $(this).html() == "english" || $(this).html() == "inglés") {
							$(this).click();
						}
					});
					$("#available-languages").find(".languages-text").text("EN");
					$("#available-languages").find("#languages-map").removeClass().addClass("flag-english");
					$(".languages-list .item-languages").removeClass("active");
					$(this).addClass("active");
					break;
				case 'ru':
					$($(".goog-te-menu-frame")).contents().find("span.text").each(function () {
						if ($(this).html() == "ruso" || $(this).html() == "Russian" || $(this).html() == "Russian" || $(this).html() == "русский") {
							$(this).click();
						}
					});
					$("#available-languages").find(".languages-text").text("RU");
					$("#available-languages").find("#languages-map").removeClass().addClass("flag-russian");
					$(".languages-list .item-languages").removeClass("active");
					$(this).addClass("active");
					break;
				case 'es':
					$($(".goog-te-menu-frame")).contents().find("span.text").each(function () {
						if ($(this).html() == "español" || $(this).html() == "Español" || $(this).html() == "Spanish") {
							$(this).click();
						}
					});
					$("#available-languages").find(".languages-text").text("ES");
					$("#available-languages").find("#languages-map").removeClass().addClass("flag-spanish");
					$(".languages-list .item-languages").removeClass("active");
					$(this).addClass("active");
					break;
				case 'pt':
					$($(".goog-te-menu-frame")).contents().find("span.text").each(function () {
						if ($(this).html() == "Portugués" || $(this).html() == "Portuguese" || $(this).html() == "português" || $(this).html() == "portugués") {
							$(this).click();
						}
					});
					$("#available-languages").find(".languages-text").text("BR");
					$("#available-languages").find("#languages-map").removeClass().addClass("flag-portuguese");
					$(".languages-list .item-languages").removeClass("active");
					$(this).addClass("active");
					break;
				case 'fr':
					$($(".goog-te-menu-frame")).contents().find("span.text").each(function () {
						if ($(this).html() == "francés" || $(this).html() == "French" || $(this).html() == "Francés") {
							$(this).click();
						}
					});
					$("#available-languages").find(".languages-text").text("FR");
					$("#available-languages").find("#languages-map").removeClass().addClass("flag-french");
					$(".languages-list .item-languages").removeClass("active");
					$(this).addClass("active");
					break;
				case 'it':
					$($(".goog-te-menu-frame")).contents().find("span.text").each(function () {
						if ($(this).html() == "italiano" || $(this).html() == "Italian" || $(this).html() == "Italiano") {
							$(this).click();
						}
					});
					$("#available-languages").find(".languages-text").text("IT");
					$("#available-languages").find("#languages-map").removeClass().addClass("flag-italy");
					$(".languages-list .item-languages").removeClass("active");
					$(this).addClass("active");
					break;
				case 'de':
					$($(".goog-te-menu-frame")).contents().find("span.text").each(function () {
						if ($(this).html() == "Alemán" || $(this).html() == "alemán" || $(this).html() == "Aleman" || $(this).html() == "aleman" || $(this).html() == "Germany" || $(this).html() == "germany" || $(this).html() == "German") {
							$(this).click();
						}
					});
					$("#available-languages").find(".languages-text").text("DE");
					$("#available-languages").find("#languages-map").removeClass().addClass("flag-german");
					$(".languages-list .item-languages").removeClass("active");
					$(this).addClass("active");
					break;
				case 'zh-TW':
					$($(".goog-te-menu-frame")).contents().find("span.text").each(function () {
						if ($(this).html() == "chino (tradicional)" || $(this).html() == "chino (Tradicional)" || $(this).html() == "Chinese (Traditional)" || $(this).html() == "hinese (traditional)" || $(this).html() == "中國（繁體）") {
							$(this).click();
						}
					});
					$("#available-languages").find(".languages-text").text("ZH");
					$("#available-languages").find("#languages-map").removeClass().addClass("flag-chinese");
					$(".languages-list .item-languages").removeClass("active");
					$(this).addClass("active");
					break;
			}
		});

		var googTrans = getCookie('googtrans'); // Devuelve esto: /en/en
		var dataLanguage = googTrans;
		if (googTrans !== '') {
			var cookieLanguage = dataLanguage.split('/')[2];
			$(".languages-list .item-languages").removeClass("active");
			switch (cookieLanguage) {
				case 'us':
					$("#available-languages").find(".languages-text").text("EN");
					$("#available-languages").find("#languages-map").removeClass().addClass("flag-english");
					$(".languages-list .item-languages[data-iso='" + cookieLanguage + "']").addClass("active");
					break;
				case 'ru':
					$("#available-languages").find(".languages-text").text("RU");
					$("#available-languages").find("#languages-map").removeClass().addClass("flag-russian");
					$(".languages-list .item-languages[data-iso='" + cookieLanguage + "']").addClass("active");
					break;
				case 'es':
					$("#available-languages").find(".languages-text").text("ES");
					$("#available-languages").find("#languages-map").removeClass().addClass("flag-spanish");
					$(".languages-list .item-languages[data-iso='" + cookieLanguage + "']").addClass("active");
					break;
				case 'pt':
					$("#available-languages").find(".languages-text").text("BR");
					$("#available-languages").find("#languages-map").removeClass().addClass("flag-portuguese");
					$(".languages-list .item-languages[data-iso='" + cookieLanguage + "']").addClass("active");
					break;
				case 'fr':
					$("#available-languages").find(".languages-text").text("FR");
					$("#available-languages").find("#languages-map").removeClass().addClass("flag-french");
					$(".languages-list .item-languages[data-iso='" + cookieLanguage + "']").addClass("active");
					break;
				case 'it':
					$("#available-languages").find(".languages-text").text("IT");
					$("#available-languages").find("#languages-map").removeClass().addClass("flag-italy");
					$(".languages-list .item-languages[data-iso='" + cookieLanguage + "']").addClass("active");
					break;
				case 'de':
					$("#available-languages").find(".languages-text").text("DE");
					$("#available-languages").find("#languages-map").removeClass().addClass("flag-german");
					$(".languages-list .item-languages[data-iso='" + cookieLanguage + "']").addClass("active");
					break;
				case 'zh-TW':
					$("#available-languages").find(".languages-text").text("ZH");
					$("#available-languages").find("#languages-map").removeClass().addClass("flag-chinese");
					$(".languages-list .item-languages[data-iso='" + cookieLanguage + "']").addClass("active");
					break;
			}
		}

		function getCookie(cname) {
			var name = cname + "=";
			var decodedCookie = decodeURIComponent(document.cookie);
			var ca = decodedCookie.split(';');
			for (var i = 0; i < ca.length; i++) {
				var c = ca[i];
				while (c.charAt(0) == ' ') {
					c = c.substring(1);
				}
				if (c.indexOf(name) == 0) {
					return c.substring(name.length, c.length);
				}
			}
			return "";
		}

		$('body').mouseup(function (e) {
			if (!$(".available-languages-content").is(e.target) && $(".available-languages-content").has(e.target).length === 0) {
				if ($(".available-languages-content").hasClass("list-show")) {
					$(".available-languages-content").removeClass("list-show");
				}
			}
		});

		// click social logins
		$(".flex-social-login-gplus").on("click", function (event) {
			event.preventDefault();
			// console.log('login with gplus');
		});

		$(".flex-social-login-fb").on("click", function (event) {
			event.preventDefault();
			// console.log('login with facebook');
		});

		$(document).on("click", ".flex-logout-link", function(event) {
			event.preventDefault();
			//socket.unsubscribe(__flex_g_settings.pusher.presence_channel);
			console.log('logout triggered');
			//alert('[error] event propagation click on document parent');
			
			Cookies.remove('ib_lead_token');
			Cookies.remove("_ib_user_firstname");
			Cookies.remove("_ib_user_lastname");
			Cookies.remove("_ib_user_phone");
			Cookies.remove("_ib_user_email");
			Cookies.remove("_ib_user_code_phone");
			Cookies.remove("_ib_user_new_phone_number");

			Cookies.remove("social_register");

			if (true === IB_HAS_LEFT_CLICKS) {
				//Cookies.set("_ib_left_click_force_registration", parseInt(__flex_g_settings.signup_left_clicks, 10));
				Cookies.set("_ib_left_click_force_registration", 0);
			}

			localStorage.removeItem('idxboost_credential');
			window.location.reload(false);
		});

		/*
		$(".flex-logout-link").on("click", function (event) {
			event.preventDefault();
			socket.unsubscribe(__flex_g_settings.pusher.presence_channel);
			Cookies.remove('ib_lead_token');
			localStorage.removeItem('idxboost_credential');
			window.location.reload(false);
		});
		*/

		$(".flex-property-request-showing").on("click", function () {
			var _self = $(this);

			$('#form-scheduled').trigger('reset');

			var address_short = _self.data('address-short');
			var address_large = _self.data('address-large');
			var slug = _self.data('slug');
			var permalink = _self.data('permalink');
			var price = _self.data('price');
			var mls = _self.data('mls');

			var ss_f_heading = address_short + ' ' + address_large;

			// setup vars
			$("#ss_f_heading").html(ss_f_heading);
			$("#ss_f_mls").val(mls);
			$("#ss_f_permalink").val(permalink);
			$("#ss_f_address_short").val(address_short);
			$("#ss_f_address_large").val(address_large);
			$("#ss_f_slug").val(slug);
			$("#ss_f_price").val(price);

			$("#ss_preferred_time").val("");
			$("#ss_preferred_date").val("");

			// show modal
			active_modal($('#modal_schedule'));
		});

		/*
		$('#form-scheduled').on("submit", function (event) {
			event.preventDefault();

			var _self = $(this);
			var formData = _self.serialize();

			$.ajax({
				url: __flex_g_settings.ajaxUrl,
				method: "POST",
				data: formData,
				dataType: "json",
				success: function (data) {
					// reset form && close modal
					_self.trigger("reset");
					$("#ss_preferred_time").val("");
					$("#ss_preferred_date").val("");

					$('.close-modal').click();

					// show success message
					active_modal($("#modal_properties_send"));

					setTimeout(function () {
						$('.close-modal').click();
					}, 1000);
				}
			});
		});
		*/

		$(document).on('click', '#available-languages', function () {
			$(this).parent().toggleClass("list-show");
		});

		/*scrollFixedx('#full-main .title-conteiner');
		function scrollFixedx(conditional) {
				var $conditional = conditional;
				var $element = $($conditional + ".fixed-box");
				var $offset = $element.offset();
				if ($offset != null) {
					var $positionYelement = $offset.top + 100;
					$ventana.scroll(function() {
							var $scrollSize = $ventana.scrollTop();
							if ($scrollSize > $positionYelement) {
									$cuerpo.addClass('fixed-active');
							} else {
									$cuerpo.removeClass('fixed-active');
							}
					})
				}
		};*/
	});

})(jQuery);

/*------------------------------------------------------------------------------------------*/
/* Dando formato a los iconos de favoritos
/*------------------------------------------------------------------------------------------*/
function idxboostTypeIcon() {
	if (__flex_g_settings["params"]["view_icon_type"] == '1') {
		jQuery('.clidxboost-btn-check').addClass('clidxboost-icon-star');
		jQuery('.chk_save').addClass('clidxboost-icon-star');
	} else if (__flex_g_settings["params"]["view_icon_type"] == '2') {
		jQuery('.clidxboost-btn-check').addClass('clidxboost-icon-square');
		jQuery('.chk_save').addClass('clidxboost-icon-square');
	} else if (__flex_g_settings["params"]["view_icon_type"] == '0') {
		jQuery('.clidxboost-btn-check').addClass('clidxboost-icon-heart');
		jQuery('.chk_save').addClass('clidxboost-icon-heart');
	} else {
		jQuery('.clidxboost-btn-check').addClass('clidxboost-icon-heart');
		jQuery('.chk_save').addClass('clidxboost-icon-heart');
	}
}

/*------------------------------------------------------------------------------------------*/
/* Funcion que fixea los elementos
/*------------------------------------------------------------------------------------------*/
function scrollFixedElement(elemento) {
	/*var boxTop = elemento.offset().top;
	var boxHeight = elemento.outerHeight();
	var originalPos = boxHeight;
	jQuery(document).on("scroll", function (e) {
		if (jQuery("body").hasClass("fixed-active")) {
			if (jQuery(document).scrollTop() <= originalPos)
				jQuery("body").removeClass("fixed-active");
			return;
		}
		if ((originalPos = jQuery(document).scrollTop()) >= (boxTop + boxHeight)) {
			jQuery("body").addClass("fixed-active");
		}
	});*/
	var $element = elemento;
	var $offset = $element.offset();
	var $positionYelement = $offset.top;
	var $scrollSize = jQuery(window).scrollTop();

	if ($scrollSize >  $positionYelement) {
		jQuery("body").addClass('fixed-active');
	} else {
		jQuery("body").removeClass('fixed-active');
	}

	jQuery(window).scroll(function(){
		var $newScrollSize = jQuery(window).scrollTop();
		if ($newScrollSize >  $positionYelement) {
			jQuery("body").addClass('fixed-active');
		} else {
			jQuery("body").removeClass('fixed-active');
		}
	});
}

/*----------------------------------------------------------------------------------*/
/* Funciones extras
/*----------------------------------------------------------------------------------*/
(function ($) {

	/*------------------------------------------------------------------------------------------*/
	/* Tab detalles de la propiedad
	/*------------------------------------------------------------------------------------------*/
	$(document).on('click', '.list-details h2', function () {
		if (!$(this).hasClass('no-tab')) {
			var $theLi = $(this).parent();
			var $theUl = $(this).next();
			if ($theLi.hasClass('active')) { // si está abierto
				$theLi.removeClass('active');
				$theUl.removeClass('show');
			} else { // si está cerrado
				$theLi.addClass('active');
				$theUl.addClass('show');
			}
		}
	});

	/*----------------------------------------------------------------------------------*/
	/* Show Password
	/*----------------------------------------------------------------------------------*/
	$('.showpassord').on('click', function (e) {
		e.preventDefault();
		var current = $(this).attr('action');

		if (current == 'hide') {
			$(this).prev().attr('type', 'text');
			$(this).addClass('blocked').attr('action', 'show');
		}

		if (current == 'show') {
			$(this).prev().attr('type', 'password');
			$(this).removeClass('blocked').attr('action', 'hide');
		}
	});

	/*------------------------------------------------------------------------------------------*/
	/* Asignando valor del select seleccionado en el item "Filtrar por" en la seccion de filtros
	/*------------------------------------------------------------------------------------------*/
	var $filterBy = $("#filter-by").find('select');
	var $textoFilterBy = $(".filter-text");
	$filterBy.change(function () {
		$textoFilterBy.text($(this).find('option:selected').text());
	}).trigger("change");

	/*------------------------------------------------------------------------------------------*/
	/* Preload
	/*------------------------------------------------------------------------------------------*/
	$(window).on("load", function (e) {
		var $preloaderItem = $('.wrap-preloader');
		if ($preloaderItem.length) {
			$preloaderItem.addClass('fadeOut').one('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend', function () {
				$preloaderItem.removeClass('fadeOut').remove();
			});
		}
	});

	/*------------------------------------------------------------------------------------------*/
	/* Show menú lateral
	/*------------------------------------------------------------------------------------------*/
	$("#show-mobile-menu").click(function () {
		$('body').toggleClass("opened-menu");
	});

	/*------------------------------------------------------------------------------------------*/
	/* Show menú lateral Buildings
	/*------------------------------------------------------------------------------------------*/
	$(document).on('click', '#clidxboost-btn-ng', function () {
		$('body').toggleClass("opened-menu-ng");
		$('.r-overlay').addClass('clidxboost-mg-close');
	});

	$(document).on('click', '#clidxboost-close-menu-ng', function (e) {
		$('body').removeClass("opened-menu-ng");
		$('.r-overlay').removeClass('clidxboost-mg-close');
	});

	$(document).on('click', '.clidxboost-mg-close', function (e) {
		$('body').removeClass("opened-menu-ng");
		$('.r-overlay').removeClass('clidxboost-mg-close');
	});

	/*------------------------------------------------------------------------------------------*/
	/* Sub menu lateral Buildings
	/*------------------------------------------------------------------------------------------*/
	$(document).on('click', '.clidxboost-child', function (e) {
		if ($(this).hasClass("active")) {
			$(this).removeClass("active");
		} else {
			$(".clidxboost-child").removeClass("active");
			$(this).addClass("active");
		}
	});

	/*------------------------------------------------------------------------------------------*/
	/* Boton apply filters
	/*------------------------------------------------------------------------------------------*/
	$("#apply-filters-min").click(function () {
		$("#apply-filters").trigger("click");
	});

	/*------------------------------------------------------------------------------------------*/
	/* Boton de print
	/*------------------------------------------------------------------------------------------*/
	$(document).on('click', '#print-btn', function (e) {
		e.preventDefault();
		var imgPrint = $('#full-slider .gs-wrapper-content:first-child').html();
		$("#imagen-print").html(imgPrint);
		$('#printMessageBox').fadeIn();
		$('#full-main').printArea({
			onClose: function () {
				$('#printMessageBox').fadeOut('fast');
			}
		});
	});

	/*------------------------------------------------------------------------------------------*/
	/* Acciones de mostrar: Mapa/Slider/Video
	/*------------------------------------------------------------------------------------------*/
	$(document).on('click', '.option-switch', function () {
		
		if ($(this).hasClass("active")) {
			return;
		}

		$(".option-switch").removeClass("active");

		$(this).addClass("active");
		$("#full-slider").removeClass("viewGallery viewVideo viewMap");
		var view = $(this).data('view');

		switch (view) {

			case 'gallery':
				/*$("#map-view").removeClass('active');
				$("#full-slider").removeClass('active');
				$("#video-view").removeClass('active');*/
				$("#full-slider").addClass("viewGallery");
				break;

			case 'video':
				/*$("#map-view").removeClass('active');
				$("#full-slider").addClass('active');
				$("#video-view").addClass('active');*/
				$("#full-slider").addClass("viewVideo");
				break;

			case 'map':
				$("#full-slider").addClass("viewMap");
				showMap();
				break;
		}
	});

	/*------------------------------------------------------------------------------------------*/
	/* Mini mapa que muestra el full map
	/*------------------------------------------------------------------------------------------*/
	$(document).on('click', '#min-map', function () {
		showMap();
	});

	/*------------------------------------------------------------------------------------------*/
	/* Activando la lista de compartir
	/*------------------------------------------------------------------------------------------*/
	$(document).on('click', '#show-shared', function () {
		$(".shared-content").toggleClass("active");
	});

	/*------------------------------------------------------------------------------------------*/
	/* Funcion que ejecuta el full map
	/*------------------------------------------------------------------------------------------*/
	function showMap() {
		/*$("#map-view").addClass('active');
		$(".option-switch").removeClass("active");
		if (!$("#show-map").hasClass("active")) {
			$("#show-map").addClass("active");
			$("#full-slider").addClass('active');
			$("#video-view").removeClass('active');
		}*/

		//mini map
		var flex_map_mini_view = $("#map-result");

		var myLatLng  = {
			lat: parseFloat(flex_map_mini_view.data('lat')),
			lng: parseFloat(flex_map_mini_view.data('lng'))
		};

		var map = new google.maps.Map(document.getElementById('map-result'), {
			zoom: 18,
			center: myLatLng,
			styles: style_map,
			gestureHandling: 'cooperative',
			panControl: false,
			scrollwheel: false,
			disableDoubleClickZoom: true,
			disableDefaultUI: true,
			streetViewControl: true,
		});

		var marker = new google.maps.Marker({
			position: myLatLng,
			map: map
		});

		google.maps.event.addListenerOnce(map, 'tilesloaded', setupMapControls);

		function handleSatelliteButton(event){
			event.stopPropagation();
			event.preventDefault();
			map.setMapTypeId(google.maps.MapTypeId.HYBRID)
		
			if($(this).hasClass("is-active")){
				$(this).removeClass("is-active");
				map.setMapTypeId(google.maps.MapTypeId.ROADMAP)
			}else{
				$(this).addClass("is-active");
				map.setMapTypeId(google.maps.MapTypeId.HYBRID)
			}
		}
		
		function handleZoomInButton(event) {
			event.stopPropagation();
			event.preventDefault();
			map.setZoom(map.getZoom() + 1);
		}
		
		function handleZoomOutButton(event) {
			event.stopPropagation();
			event.preventDefault();
			map.setZoom(map.getZoom() - 1);
		}
		
		function handlefullscreenButton() {
		
			var elementToSendFullscreen = map.getDiv().firstChild;
		
			if (isFullscreen(elementToSendFullscreen)) {
				exitFullscreen();
			} else {
				requestFullscreen(elementToSendFullscreen);
			}
		
			document.onwebkitfullscreenchange = document.onmsfullscreenchange = document.onmozfullscreenchange = document.onfullscreenchange = function () {
				if (isFullscreen(elementToSendFullscreen)) {
					fullscreenControl.classList.add("is-fullscreen");
				} else {
					fullscreenControl.classList.remove("is-fullscreen");
				}
			};
		}
		
		function isFullscreen(element) {
			return (
				(document.fullscreenElement ||
					document.webkitFullscreenElement ||
					document.mozFullScreenElement ||
					document.msFullscreenElement) == element
			);
		}
		
		function requestFullscreen(element) {
			if (element.requestFullscreen) {
				element.requestFullscreen();
			} else if (element.webkitRequestFullScreen) {
				element.webkitRequestFullScreen();
			} else if (element.mozRequestFullScreen) {
				element.mozRequestFullScreen();
			} else if (element.msRequestFullScreen) {
				element.msRequestFullScreen();
			}
		}
		
		function exitFullscreen() {
			if (document.exitFullscreen) {
				document.exitFullscreen();
			} else if (document.webkitExitFullscreen) {
				document.webkitExitFullscreen();
			} else if (document.mozCancelFullScreen) {
				document.mozCancelFullScreen();
			} else if (document.msExitFullscreen) {
				document.msExitFullscreen();
			}
		}
		
		function setupMapControls() {
			// setup buttons wrapper
			mapButtonsWrapper = document.createElement("div");
			mapButtonsWrapper.classList.add('flex-map-controls-ct');
		
			// setup Full Screen button
			fullscreenControl = document.createElement("div");
			fullscreenControl.classList.add('flex-map-fullscreen');
			mapButtonsWrapper.appendChild(fullscreenControl);
		
			// setup zoom in button
			mapZoomInButton = document.createElement("div");
			mapZoomInButton.classList.add('flex-map-zoomIn');
			mapButtonsWrapper.appendChild(mapZoomInButton);
		
			// setup zoom out button
			mapZoomOutButton = document.createElement("div");
			mapZoomOutButton.classList.add('flex-map-zoomOut');
			mapButtonsWrapper.appendChild(mapZoomOutButton);
		
			// setup Satellite button
			satelliteMapButton = document.createElement("div");
			satelliteMapButton.classList.add('flex-satellite-button');
			mapButtonsWrapper.appendChild(satelliteMapButton);
		
			// add Buttons
			google.maps.event.addDomListener(mapZoomInButton, "click", handleZoomInButton);
			google.maps.event.addDomListener(mapZoomOutButton, "click", handleZoomOutButton);
			google.maps.event.addDomListener(fullscreenControl, "click", handlefullscreenButton);
			google.maps.event.addDomListener(satelliteMapButton, "click", handleSatelliteButton);
			map.controls[google.maps.ControlPosition.TOP_RIGHT].push(mapButtonsWrapper);
		}
	}

	function msShowMap() {
		//mini map
		var flex_map_mini_view = $("#ms-map-result");
		var myLatLng2 = {
			lat: parseFloat(flex_map_mini_view.data('lat')),
			lng: parseFloat(flex_map_mini_view.data('lng'))
		};
		var miniMap = new google.maps.Map(document.getElementById('ms-map-result'), {
			zoom: 18,
			center: myLatLng2,
			styles: style_map,
			/*mapTypeControlOptions: {
				style: google.maps.MapTypeControlStyle.HORIZONTAL_BAR,
				position: google.maps.ControlPosition.TOP_RIGHT
			}*/
		});
		var marker = new google.maps.Marker({
			position: myLatLng2,
			map: miniMap
		});
	}

	/*------------------------------------------------------------------------------------------*/
	/* Login y register para los templates de LG
	/*------------------------------------------------------------------------------------------*/
	// @todo check openloginmodal
	$(document).on('click', '#lg-login, .lg-login', function (event) {
		event.stopPropagation();
		event.preventDefault();
		
		$("#user-options .login").trigger("click");
		var titleText = $(".header-tab a[data-tab='tabLogin']").attr('data-text')
		$("#modal_login .modal_cm .content_md .heder_md .ms-title-modal").html(titleText);

		$("#socialMediaRegister").removeClass("disabled");
	});

	$(document).on('click', '#lg-register, .lg-register', function (event) {
		event.stopPropagation();
		event.preventDefault();

		$("#user-options .register").trigger("click");
		var titleText = $(".header-tab a[data-tab='tabRegister']").attr('data-text')
		$("#modal_login .modal_cm .content_md .heder_md .ms-title-modal").html(titleText);

		if ($('#follow_up_boss_valid_register').is(':checked')) {
			$("#socialMediaRegister").removeClass("disabled");
		}else{
			$("#socialMediaRegister").addClass("disabled");
		}
	});

	/*------------------------------------------------------------------------------------------*/
	/* Botone de acciones en el resultado de busqueda - mobile
	/*------------------------------------------------------------------------------------------*/
	$(document).on('click', '.content-rsp-btn .show-btn-actions', function () {
		$(this).parent().toggleClass("active");
	});

	$(document).on('click', '.hamburger-content #show-filters', function () {
		$('body').toggleClass("active-show-filters");
	});

	/*------------------------------------------------------------------------------------------*/
	/* Fixeando elementos
	/*------------------------------------------------------------------------------------------*/
	$(window).on('load', function () {
		$(".fixed-box").each(function () {
			var elemento = $(this);
			scrollFixedElement(elemento);
		});
	});

	/*------------------------------------------------------------------------------------------*/
	/* Activar menu de usuario en menu lateral
	/*------------------------------------------------------------------------------------------*/
	$(document).on('click', '.lg-wrap-login', function () {
		$(this).toggleClass("show-login-list");
	});

	/*------------------------------------------------------------------------------------------*/
	/* Activar Select Luxury condos
	/*------------------------------------------------------------------------------------------*/
	$(document).on('click', '#btn-active-filters', function() {
		$("#filters").toggleClass("active-select");
	});


	/*------------------------------------------------------------------------------------------*/
	/* MODAL FLOAT
	/*------------------------------------------------------------------------------------------*/
	$(document).on('click', '.ib-active-float-form', function() {
		$("body").addClass("ib-request-float-modal");
	});

	$(document).on('click', '.ib-float-form', function() {
		$("body").removeClass("ib-request-float-modal");
	});

	$(".ms-btn-tab").on("click", function() {
		$(".ms-btn-tab").removeClass('active');
		$(this).addClass('active');
		var tabId = $(this).attr('data-id');
		$(".ms-tab-content .ms-item-tb").removeClass("active in");
		$("#"+tabId).addClass('fade active in');

		if(tabId == "tabLocation"){
			if (!$(this).hasClass('loading-map')) {
				msShowMap();
				$(this).addClass('loading-map');
			}
		}
	});

})(jQuery);

/*----------------------------------------------------------------------------------*/
/* Funciones para el detalle de propiedades (modal e internas)
/*----------------------------------------------------------------------------------*/
(function ($) {

	/*----------------------------------------------------------------------------------*/
	/* Funciones extras
	/*----------------------------------------------------------------------------------*/
	$(function() {
		$("#result-search").on("click", ".show-modal-properties", function (event) {
			event.preventDefault();

			var _propertie = $(this).parents('.propertie');

			if (("result-search" === _propertie.parent().attr("id")) && !$(event.target).hasClass("clidxboost-icon-arrow-select") && !$(event.target).hasClass("flex-favorite-btn")) {
				if (_propertie.hasClass("ib-p-non-click")) {
					return;
				}

				var mlsNum = _propertie.data("mls");

				if (__flex_g_settings.force_registration =='1'){
					if (__flex_g_settings.anonymous === 'yes') {
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

						localStorage.setItem("ib_anon_mls", mlsNum);
						return;
					}
				}


				//$('html').addClass('modal_mobile');
				$('#modal_property_detail').addClass('active_modal');
				$("#modal_property_detail .detail-modal").html('<span class="ib-modal-property-loading">Loading property details...</span>');

				$.ajax({
					type: "POST",
					url: __flex_g_settings.ajaxUrl,
					data: {
						mlsNumber: mlsNum,
						action: "load_modal_property"
					},
					success: function (response) {
						$(document.body).addClass("modal-property-active");
						$("#modal_property_detail .detail-modal").html(response);
					},

					complete: function(){
						$('#full-main #clidxboost-data-loadMore-niche').trigger("click");
						loadFullSlider(".clidxboost-full-slider");
					}
				});
			}
		});

		/*$("#result-search").on("click", "a", function (event) {
			if ($(this).hasClass("ib-refresh-tab")) {
				return true;
			}
			event.preventDefault();
		});*/

		$(document).on('click', '.overlay_modal_closer_pt, .close-modal-pt', function () {
			if ($('button[data-id="modal_login"]:eq(0)').is(":hidden")) {
				return;
			}

			var idModal = $(this).attr('data-id');
			$('#' + idModal).removeClass('active_modal');
			$("body").removeClass("modal-property-active").css({'overflow-y': 'auto'});
			$("html").removeClass("modal_mobile");
		});
	});

})(jQuery);

// CERRAR Y ABRIR MODALES CON LA FLECHA DE NAVEGACIÓN
(function($){

	let $aucCityDropdown = $("#auc_city_dropdown");
	
	const modals = {
		'search-modal': (action)=>{
		 
			switch(action) {
				case 'close':
					$('body').removeClass('active-search-modal');
					$aucCityDropdown.hide();
					break;
				case 'open':
					$('body').addClass('active-search-modal');
					setTimeout(()=>{
						$aucCityDropdown.show();
					}, 800);
					break;
			}
		}
	}

	let backTypes = {

		modal: (pObj)=>{

			let actions = {

				close: (id)=>{
					modals[id]('close');
				},
				open: (id)=>{
					modals[id]('open');
				}
			}

			let theAction = actions[pObj.action];
			if (theAction !== undefined) theAction(pObj.id);
		}
	}

	$(window).on('popstate', function(e){
		var elState = e.originalEvent.state;
		if(elState !== null && elState !== undefined) {
			let bTypes = backTypes[elState.type];
			if(bTypes !== undefined) bTypes(elState);
		}
	});

	/*------------------------------------------------------------------------------------------*/
	/* Show modal search home
	/*------------------------------------------------------------------------------------------*/
	$("#clidxboost-modal-search").click(function () {
		let theObj = {
			type:'modal',
			id: 'search-modal'
		};

		if (!$('body').hasClass('active-search-modal')) {
			//console.log('no tiene la clase');
			theObj.action = 'close';
			history.pushState(theObj, null, null);
			theObj.action = 'open';
			history.pushState(theObj, null, null);
			modals[theObj.id]('open');
		} else {
			history.back();
		}

		setTimeout(function() {
			$("#flex_idx_single_autocomplete_input").focus();
		}, 200);
	});

	// Para subir o bajar el boton del chat DRIFF cuando se llega al final del scroll
	/* @todo drift*/
	const $ibWgrid = $('.ib-wgrid');
	if ($ibWgrid.length) {
		let ibWgridScroll = 0;
		$ibWgrid.on('scroll', function(){
			let currentScroll = $(this).scrollTop();
			let $finalScroll = $('.ib-gheader').height() + $('.ib-cproperties').height() - $(this).height();
			
			if ($('#drift-widget').length) {
				let $theBottom = Number($('#drift-widget').css('bottom').replace('px', ''));
				if (currentScroll > ibWgridScroll) {
					if (currentScroll >= $finalScroll) {
						if ($theBottom !== 74) $('#drift-widget').css('bottom', '74px');
					} 
				} else {
					if (currentScroll <= ($finalScroll - 60)) {
						if ($theBottom !== 24) $('#drift-widget').css('bottom', '24px');
					} 
				}
				ibWgridScroll = currentScroll;
			}
		});
	};
	

	// trigger al Remove Boundaries
	$('body').on('click', '.ib-gnprb', ()=>{
		$('.ib-removeb-tg').click();
	});

	// trigger al all filters
	$('body').on('click', '.ib-gnpoall', ()=>{
		$('.ib-oiwrapper').click()
	});

	// trigger al clear
	$('body').on('click', '.ib-gnpclear', ()=>{
		$('.ib-dbclear').click();
	});

	// Click Next Form Buyers / Sellers / Rentals
	$(document).on("change", ".ib-firadio", function() {
		$(".ib-fbtn-continue").trigger("click");
	});

	$(document).on("change", "#lead_submission_sell_form .ib-firadio", function() {
		$(".ib-fbtn-next").trigger("click");
	});

	/*-----------------------------------------------------------------------------------------------------*/
	/* Boton menu perfil
	/*-----------------------------------------------------------------------------------------------------*/
	$(document).on('click', '.ms-history-menu-btn-back', function () {
		$(".ms-history-menu-profile-menu").removeClass('active');
	});

	$(document).on('click', '.ms-history-menu-btn-profile', function () {
		$(".ms-history-menu-profile-menu").addClass('active');
	});

	/*-----------------------------------------------------------------------------------------------------*/
	/* Boton Bubble
	/*-----------------------------------------------------------------------------------------------------*/
	$(document).on('click', '.ms-history-menu-btn-bubble', function () {
		$(".msn-bubble").animate({opacity:0},300, function(){
			$(this).remove();
		});
	});

	/*-----------------------------------------------------------------------------------------------------*/
	/* Close agent detail
	/*-----------------------------------------------------------------------------------------------------*/
	$(document).on('click', '.ms-header-agent .ms-btn-hidden', function () {
		$(".ms-history-profile-menu").addClass("ms-show-agent");
	});
	$(document).on('click', '.ms-header-agent .ms-btn-show', function () {
		$(".ms-history-profile-menu").removeClass("ms-show-agent");
	});


	/*-----------------------------------------------------------------------------------------------------*/
	/* ACCESIBILIDAD FOCUS ACTIVO
	/*-----------------------------------------------------------------------------------------------------*/
	$("body").addClass("using-mouse");

	document.body.addEventListener('mousedown', function() {
		document.body.classList.add('using-mouse');
	});
	
	document.body.addEventListener('keydown', function() {
		document.body.classList.remove('using-mouse');
	});

	/*-----------------------------------------------------------------------------------------------------*/
	/* MUESTRA EL NUEVO MODAL DE LA CALCULADORA
	/*-----------------------------------------------------------------------------------------------------*/
  $(document).on('click', '.ib-price-calculator', function(e) {
    e.preventDefault();
    $(".ib-pscitem.ib-pscalculator").trigger("click")
  });


}(jQuery));

(function ($) {
	$(function() {
		if (typeof Cookies.get("_ib_last_logged_in_username") !== "undefined") {
			$("#txt_user").val(Cookies.get("_ib_last_logged_in_username"));
		}
	});
})(jQuery);

// Calcula la altura dinámicamente del wrapper del search
(function($){

const $flexIdxSearchFilter = $('#flex_idx_search_filter');
if ($flexIdxSearchFilter.length) {
	if($(window).width() >= 1024) {
		let heightMenos = $('.ib-filter-container').height() + $('#header').outerHeight();
		if($('.gwr-breadcrumb').length) heightMenos += $('.gwr-breadcrumb').height();
		$flexIdxSearchFilter.css('height', 'calc(100vh - ' + (heightMenos + 2) + 'px)');
	}
}

// abre la lista de sugerencias del auto complete en mobile
$(document.body).on('click', '#clidxboost-modal-search', ()=>{
	$('#ui-id-1').show();
});

}(jQuery));

(function($) {
	$(function() {
		// change input type field for phone number
		if (/webOS|iPhone|iPad/i.test(navigator.userAgent)) {
			$(".ib-input-only-numeric").attr("type", "number");
		}

		// Restore modal to initial step if closed by user manually.
		$("#modal_login").on("click", "button", function(event) {
			if (event.originalEvent !== undefined) {
				if ($(this).hasClass("close-modal")) {
					$("#formRegister").find(".pr-step").removeClass("active");
					$("#formRegister").find(".pr-step:eq(0)").addClass("active");
				}
			}
		});

		$(document).on("click", ".overlay_modal_closer", function() {
			$("#formRegister").find(".pr-step").removeClass("active");
			$("#formRegister").find(".pr-step:eq(0)").addClass("active");
		});
	});
})(jQuery);

(function ($) {

	$(function() {
		if ( ("undefined" !== typeof __flex_g_settings) && ("no" == __flex_g_settings.anonymous) ) {
			var trackingServiceUrl = __flex_g_settings.events.trackingServiceUrl;
			var accessToken = __flex_g_settings.accessToken;
			var leadToken = Cookies.get('ib_lead_token');
	
			$.ajax({
				url: trackingServiceUrl,
				method: "POST",
				data: {
					access_token: accessToken,
					lead_token: leadToken,
					referer: location.href
				},
				dataType: "json",
				success: function(response) {
					//console.log(response)
				}
			});
		}

		// if user has logged out
		// TODO: this block of code conflicts
		/*
		if('yes' === __flex_g_settings.anonymous) {
			// remove cookies
			Cookies.remove('ib_lead_token');
			Cookies.remove("_ib_user_firstname");
			Cookies.remove("_ib_user_lastname");
			Cookies.remove("_ib_user_phone");
			Cookies.remove("_ib_user_email");
			Cookies.remove("_ib_user_code_phone");
			Cookies.remove("_ib_user_new_phone_number");

			Cookies.remove("social_register");
		}
		*/
	});

	/*MENU DE AÑOS CALCULADORA*/
	$(document).on("click", "#calculatorYears", function(event) {
		event.preventDefault();
		$("#calculatorYearsList").slideToggle("fast");
	});

	$(document).on("click", "#calculatorYearsList .-js-item-cl", function(event) {
		event.preventDefault();
		var itemValue = $(this).attr("data-value");
		var itemText = $(this).text();
		let ir = __flex_g_settings.interes_rate[30];    
		if (__flex_g_settings.interes_rate.hasOwnProperty(itemValue) ) {
			ir = __flex_g_settings.interes_rate[itemValue];    
			$(".ib-property-mc-ir, #interest_rate_txt").val(ir);
		}

		$(".ib-property-mc-ty").val(itemValue);
		$("#calculatorYears").text(itemText);
		$("#calculatorYearsList").css('display','none');
	});

	/*VALIDANDO CALCULADORA
	$(".ib-mcidpayment").on("keypress keyup blur", function(event) {
		$(this).val($(this).val().replace(/[^0-9\.]/g,''));
		if ((event.which != 46 || $(this).val().indexOf('.') != -1) && (event.which < 48 || event.which > 57)) {
			event.preventDefault();
		}
	});

	$(".ib-property-mc-ir,.ib-property-mc-dp").on("blur", function() {
		//Obtenemos el valor maximo y el valor actual
		var maxValue = parseInt($(this).attr("max"));
		var inputValue = parseInt($(this).val());
		var defaultValue = parseInt($(this).attr("data-default"));
		if(inputValue > maxValue){
			$(this).val(maxValue);
		}
	});*/

	/*MOSTRAR Y OCULTAR MENU DE COMPARTIR*/
	$(document).on("click", ".ms-wrapper-btn-new-share .ms-share-btn", function() {
		$(this).parents(".ms-wrapper-btn-new-share").toggleClass("active");
	});

	$(document).click(function (e) {
		e.stopPropagation();
		var container = $(".ms-wrapper-btn-new-share");
		if (container.has(e.target).length === 0) {
			$(".ms-wrapper-btn-new-share").removeClass("active");
		}

		var calculatorList = $(".ms-wrapper-dropdown-menu");
		if (calculatorList.has(e.target).length === 0) {
			$("#calculatorYearsList").css('display','none');
		}
	});

	// COPY ADDRESS LINK TO CLIPBOARD
	var $temp = $('<input>')
	$(document).on("click", ".-clipboard", function(e) {
		e.preventDefault()
		var $url = $(location).attr("href")
		$("body").append($temp)
		$temp.val($url).select()
		document.execCommand("copy")
		$temp.remove()
		$(".-copied").text("URL copied!").show().delay(2000).fadeOut()
	});

	var inputElementValue = $('.ib-mcidpayment');
	if(inputElementValue.length){
		inputElementValue.inputmask({
			alias: 'numeric', 
			allowMinus: false,  
			digits: 3, 
			max: 100,
		});
	}

	/*INPUT NO VACIO*/
	$(".ib-property-mc-ir, .ib-property-mc-dp, .interest_rate_txt, .down_payment_txt").on("blur", function() {
		var inputValue = $(this).val();
		var minValue = 0;
		if(inputValue == "" || inputValue == undefined || inputValue < 0){
			$(this).val(minValue);
		}
	});

})(jQuery);

function loadMapModal(itemLt,itemLg){

	//console.log("itemLt="+itemLt+"/itemLg="+itemLg);

	var myLatLng  = {
		lat: parseFloat(itemLt),
		lng: parseFloat(itemLg)
	};

	var map = new google.maps.Map(document.getElementById('mediaModal'), {
		zoom: 18,
		center: myLatLng,
		styles: style_map,
		gestureHandling: 'cooperative',
		panControl: false,
		scrollwheel: false,
		disableDoubleClickZoom: true,
		disableDefaultUI: true,
		streetViewControl: true,
	});

	var marker = new google.maps.Marker({
		position: myLatLng,
		map: map
	});
}

// check on every load page
jQuery(function() {
	if ("no" === __flex_g_settings.anonymous) {
		// check if phone number is required
		jQuery.ajax({
			url :__flex_g_settings.events.leadCheckSettings,
			type: "POST",
			data: {
				access_token: __flex_g_settings.accessToken,
				lead_token: Cookies.get("ib_lead_token")
			},
			dataType: "json",
			success: function(response) {
				if (response.hasOwnProperty('metadata')) {
					if (
						response.metadata.hasOwnProperty('phone_number_required') &&
						response.metadata.phone_number_required
					) {
						// show modal phone number + quizz
						jQuery("#__quizz_type").val(response.lead_source);
						jQuery("#__quizz_type_phone_ct").show();
						jQuery("#__quizz_cancel_on_fb").removeClass("ib-active");
						jQuery("#__quizz_type_phone_ct").addClass("ib-active");
						jQuery("#ib-push-registration-quizz-ct").addClass("ib-md-pa ib-md-active");
					}
				}
			}
		});
	}
});

/***************************************************************************************/

//GENERANDOR DE VIDEO
function coverVideoGenerator(videoUrl,videoTitle,videoParent){
	var videoUrl = videoUrl.toString();
	if (videoUrl.indexOf('youtube') !== -1) {
		var et = videoUrl.lastIndexOf('&')
		if(et !== -1){
			videoUrl = videoUrl.substring(0, et)
		}
		var embed = videoUrl.indexOf('embed');
		if (embed !== -1) {
			videoUrl = 'https://www.youtube.com/watch?v=' + videoUrl.substring(embed + 6, embed + 17);
		}

		var videoCode = videoUrl.substring(videoUrl.length - 11, videoUrl.length);
		jQuery("body").append('<script>var tag=document.createElement("script");tag.src="https://www.youtube.com/iframe_api";var player,firstScriptTag=document.getElementsByTagName("script")[0];function onYouTubeIframeAPIReady(){player=new YT.Player("player",{width:"100%",videoId:"'+videoCode+'",playerVars:{autoplay:1,playsinline:1,loop:1,rel:0,showinfo:0,mute:1},events:{onReady:onPlayerReady,onStateChange:onPlayerStateChange}})}function onPlayerReady(e){e.target.mute(),e.target.playVideo()}function onPlayerStateChange(e){e.data==YT.PlayerState.ENDED&&(player.seekTo(0),player.playVideo())}function stopVideo(){player.stopVideo()}firstScriptTag.parentNode.insertBefore(tag,firstScriptTag);</script>');

	} else if (videoUrl.indexOf('vimeo') !== -1) {
		var srcVideo = 'https://player.vimeo.com/video/' + videoUrl.substring((videoUrl.indexOf('.com') + 5), videoUrl.length).replace('/', '');
		jQuery(videoParent).find("#player").html('<iframe allow="autoplay; encrypted-media" title="'+videoTitle+'" src="' + srcVideo + '?autoplay=1&amp;muted=1&loop=1" frameborder="0" allowfullscreen></iframe>');
	} else {
		jQuery(videoParent).find("#player").html('<video src="'+videoUrl+'" title="'+videoTitle+'" preload="none" loop muted autoplay playsinline>');
	}
}

//GENERADOR DE MAPA EN FULL SCREEN
function generateMapFullScreen(latitud, longuitud){

	if(!jQuery("#contentMap").length){

		jQuery("#fullMapView").html('<div class="ms-wrapper-map"><div id="contentMap"></div></div>');

		var myLatLng  = {
			lat: parseFloat(latitud),
			lng: parseFloat(longuitud)
		};

		var map = new google.maps.Map(document.getElementById('contentMap'), {
			zoom: 18,
			center: myLatLng,
			styles: style_map,
			gestureHandling: 'cooperative',
			panControl: false,
			scrollwheel: false,
			disableDoubleClickZoom: true,
			disableDefaultUI: true,
			streetViewControl: true,
		});

		var marker = new google.maps.Marker({
			position: myLatLng,
			map: map
		});

		google.maps.event.addListenerOnce(map, 'tilesloaded', setupMapControls);

		function handleSatelliteButton(event){
			event.stopPropagation();
			event.preventDefault();
			map.setMapTypeId(google.maps.MapTypeId.HYBRID)
		
			if($(this).hasClass("is-active")){
				$(this).removeClass("is-active");
				map.setMapTypeId(google.maps.MapTypeId.ROADMAP)
			}else{
				$(this).addClass("is-active");
				map.setMapTypeId(google.maps.MapTypeId.HYBRID)
			}
		}
		
		function handleZoomInButton(event) {
			event.stopPropagation();
			event.preventDefault();
			map.setZoom(map.getZoom() + 1);
		}
		
		function handleZoomOutButton(event) {
			event.stopPropagation();
			event.preventDefault();
			map.setZoom(map.getZoom() - 1);
		}
		
		function handlefullscreenButton() {
		
			var elementToSendFullscreen = map.getDiv().firstChild;
		
			if (isFullscreen(elementToSendFullscreen)) {
				exitFullscreen();
			} else {
				requestFullscreen(elementToSendFullscreen);
			}
		
			document.onwebkitfullscreenchange = document.onmsfullscreenchange = document.onmozfullscreenchange = document.onfullscreenchange = function () {
				if (isFullscreen(elementToSendFullscreen)) {
					fullscreenControl.classList.add("is-fullscreen");
				} else {
					fullscreenControl.classList.remove("is-fullscreen");
				}
			};
		}
		
		function isFullscreen(element) {
			return (
				(document.fullscreenElement ||
					document.webkitFullscreenElement ||
					document.mozFullScreenElement ||
					document.msFullscreenElement) == element
			);
		}
		
		function requestFullscreen(element) {
			if (element.requestFullscreen) {
				element.requestFullscreen();
			} else if (element.webkitRequestFullScreen) {
				element.webkitRequestFullScreen();
			} else if (element.mozRequestFullScreen) {
				element.mozRequestFullScreen();
			} else if (element.msRequestFullScreen) {
				element.msRequestFullScreen();
			}
		}
		
		function exitFullscreen() {
			if (document.exitFullscreen) {
				document.exitFullscreen();
			} else if (document.webkitExitFullscreen) {
				document.webkitExitFullscreen();
			} else if (document.mozCancelFullScreen) {
				document.mozCancelFullScreen();
			} else if (document.msExitFullscreen) {
				document.msExitFullscreen();
			}
		}
		
		function setupMapControls() {
			// setup buttons wrapper
			mapButtonsWrapper = document.createElement("div");
			mapButtonsWrapper.classList.add('flex-map-controls-ct');
		
			// setup Full Screen button
			fullscreenControl = document.createElement("div");
			fullscreenControl.classList.add('flex-map-fullscreen');
			mapButtonsWrapper.appendChild(fullscreenControl);
		
			// setup zoom in button
			mapZoomInButton = document.createElement("div");
			mapZoomInButton.classList.add('flex-map-zoomIn');
			mapButtonsWrapper.appendChild(mapZoomInButton);
		
			// setup zoom out button
			mapZoomOutButton = document.createElement("div");
			mapZoomOutButton.classList.add('flex-map-zoomOut');
			mapButtonsWrapper.appendChild(mapZoomOutButton);
		
			// setup Satellite button
			satelliteMapButton = document.createElement("div");
			satelliteMapButton.classList.add('flex-satellite-button');
			mapButtonsWrapper.appendChild(satelliteMapButton);
		
			// add Buttons
			google.maps.event.addDomListener(mapZoomInButton, "click", handleZoomInButton);
			google.maps.event.addDomListener(mapZoomOutButton, "click", handleZoomOutButton);
			google.maps.event.addDomListener(fullscreenControl, "click", handlefullscreenButton);
			google.maps.event.addDomListener(satelliteMapButton, "click", handleSatelliteButton);
			map.controls[google.maps.ControlPosition.TOP_RIGHT].push(mapButtonsWrapper);
		}
	}
}

//GENERADOR DE VIDEO EN FULL SCREEN
function generateVideoFullScreen(videoUrl,videoTitle){
	var videoUrl = videoUrl, videoTitle = videoTitle, windowWidth = jQuery(window).width();
	if (videoUrl !== undefined) {
		var videoUrl = videoUrl.toString();
		if (videoUrl.indexOf('youtube') !== -1) {
			var et = videoUrl.lastIndexOf('&')
			if (et !== -1) {
					videoUrl = videoUrl.substring(0, et)
			}
			var embed = videoUrl.indexOf('embed');
			if (embed !== -1) {
				videoUrl = 'https://www.youtube.com/watch?v=' + videoUrl.substring(embed + 6, embed + 17);
			}

			var srcVideo = 'https://www.youtube.com/embed/' + videoUrl.substring(videoUrl.length - 11, videoUrl.length) + '?playlist=' + videoUrl.substring(videoUrl.length - 11, videoUrl.length) + '&autoplay=1&controls=1&loop=1';

			if(windowWidth < 639){
				jQuery("body").addClass("mobileVideo");
				player.seekTo(0).unMute();
			}else{
				jQuery("#fullVideoView").empty().html('<div class="ms-wrapper-video"><div class="ms-video-player"><iframe id="videoPropertyCover" allow="autoplay; encrypted-media" src="'+srcVideo+'" title="'+videoTitle+'" frameborder="0" allowfullscreen></iframe></div></div>');
			}

		} else if (videoUrl.indexOf('vimeo') !== -1) {
			var srcVideo = 'https://player.vimeo.com/video/' + videoUrl.substring((videoUrl.indexOf('.com') + 5), videoUrl.length).replace('/', '');
			jQuery("#fullVideoView").empty().html('<div class="ms-wrapper-video"><div class="ms-video-player"><iframe id="videoPropertyCover" allow="autoplay; encrypted-media" src="'+srcVideo+'?autoplay=1&loop=1" title="'+videoTitle+'" frameborder="0" allowfullscreen></iframe></div></div>');
		} else {
			jQuery("#fullVideoView").empty().html('<div class="ms-wrapper-video"><div class="ms-video-player"><video id="videoPropertyCover" src="'+videoUrl+'" title="'+videoTitle+'" controls autoplay loop playsinline controlsList="nodownload"></div></div>');
		}
	}
}

//SLIDER PARA LA VISTA FULL SCREEN
function generateSliderFullScreen(itemInit,galleyActive){
	//GENERAMOS Y RECUPERAMOS VARIABLES
	var count = 0;
	var slider = jQuery("#fullGalleryView");
	var sliderItems = "";

	if(jQuery(galleyActive).hasClass("gs-builded")){
		if(!slider.hasClass("slider-loaded")){
			//AGREGAMOS LA CLASE DE VALIDACION
			slider.addClass("slider-loaded");
	
			//RECUPERANDO LOS ELEMENTOS DE LA LISTA DEL SLIDER YA GENERADO
			jQuery(galleyActive).find(".gs-item-slider img").each(function () {
				count = count + 1;
				var img = jQuery(this).attr("data-lazy");
	
				if(img !== "" && img !== undefined){
					sliderItems = sliderItems + "<img src='"+img+"' data-number='"+count+"'>";
				}else{
					sliderItems = sliderItems + "<img src='"+jQuery(this).attr("src")+"' data-number='"+count+"'>";
				}
			});
	
			//AGREGAMOS LOS ELEMENTOS A LA ESTRUCTURA DEL SLIDER
			slider.html(sliderItems);
	
			//GENERAMOS EL SLIDER
			var sliderFullScreen = slider.greatSlider({
				type: 'swipe',
				nav: true,
				bullets: false,
				navSpeed: 150,
				startPosition: itemInit,
				onInited: function(){
					slider.find(".gs-item-slider img").each(function() {
						jQuery(this).parent().append('<span class="ms-label-number">'+jQuery(this).attr("data-number")+' of '+slider.find(".gs-item-slider").length+'</span>');
					});
				}
			});
	
		}else{
			//MOVEMOS EL SLIDER A LA POSICION DESEADA
			gs.slider['fullGalleryView'].goTo(itemInit);
		}
	}
}

//ACTIVANDO FULL SCREEN
function activeFullScreen(obj){

	//console.log("generando...");

	var activeView = "";
	var fullScreenModal = jQuery("#fullScreenModal");
	jQuery("body").removeClass("showPhoto showMap showVideo");
	jQuery("#fullScreenModal .ms-item").removeClass("active");
	jQuery("#fullVideoView .ms-wrapper-video").remove();

	var propertyName = "";
	var actionPhoto = "";
	var actionVideo = "";
	var actionMap = "";

	propertyName =  obj.element.parents(".ms-wrapper-actions-fs").find(".ms-property-title").html();
	actionPhoto = obj.element.parents(".ms-wrapper-actions-fs").find(".ms-gallery-fs");
	actionVideo = obj.element.parents(".ms-wrapper-actions-fs").find(".ms-video-fs");
	actionMap = obj.element.parents(".ms-wrapper-actions-fs").find(".ms-map-fs");

	if(!fullScreenModal.length){

		if(actionPhoto.length){
      var btnPhoto = '<button class="ms-item -photo-btn js-open-full-screen" data-type="photo" data-initial="1" data-gallery=".clidxboost-full-slider"><i class="ms-icon idx-icon-camera"></i> '+actionPhoto.text()+'</button>';
      
      if(jQuery("#buildingSlider").length){
        var btnPhoto = '';
      }
      
      if(jQuery(".ib-pvslider").length){
        var btnPhoto = '<button class="ms-item -photo-btn js-open-full-screen" data-type="photo" data-initial="1" data-gallery=".clidxboost-full-slider"><i class="ms-icon idx-icon-camera"></i> '+actionPhoto.text()+'</button>';
      }

     }else{
			var btnPhoto = '';
		}

		if(actionVideo.length){
			var btnType = actionVideo.attr("data-type");
			if(btnType == "video"){
				var btnVideo = '<button class="ms-item -video-btn js-open-full-screen" data-type="video" data-video="'+actionVideo.attr("data-video")+'" data-title="'+actionVideo.attr("data-title")+'"><i class="ms-icon idx-icon-play"></i> '+actionVideo.text()+'</button>';
			}else if(btnType == "link"){
				var btnVideo = '<a href="'+actionVideo.attr("href")+'" class="ms-item -video-btn" target="_blank" rel="nofollow"><i class="ms-icon idx-icon-virtual-tour-cr"></i> '+actionVideo.text()+'</a>';
			}
		}else{
			var btnVideo = '';
		}

		if(actionMap.length){
			var btnMap = '<button class="ms-item -map-btn js-open-full-screen" data-type="map" data-lat="'+actionMap.attr("data-lat")+'" data-lng="'+actionMap.attr("data-lng")+'"><i class="ms-icon idx-icon-map"></i> '+actionMap.text()+'</button>';
		}else{
			var btnMap = '';
		}

		jQuery("body").append(
			'<div id="fullScreenModal" class="ms-modal">'+
				'<div class="ms-modal-header">'+
					'<div class="ms-wrapper-header">'+
						'<h5 class="ms-title">'+propertyName+'</h5>'+
						'<div class="ms-actions">'+
							btnPhoto+btnMap+btnVideo+
							obj.element.parents(".ms-wrapper-actions-fs").find(".ms-property-search").html()+
							obj.element.parents(".ms-wrapper-actions-fs").find(".ms-property-call-action").html()+
							'<button class="ms-close js-close-full-screen" aria-label="Close modal"></button>'+
						'</div>'+
					'</div>'+
				'</div>'+
				'<div class="ms-modal-body">'+
					'<div id="fullGalleryView" class="ms-wrapper-view"></div>'+
					'<div id="fullMapView" class="ms-wrapper-view"></div>'+
					'<div id="fullVideoView" class="ms-wrapper-view"></div>'+
				'</div>'+
			'</div>'
		);
	}

	switch (obj.typeView) {
		case 'photos':
			activeView = "showPhoto";
			jQuery("#fullScreenModal .-photo-btn").addClass("active");
			generateSliderFullScreen(obj.itemInit, obj.galleyActive);
			break;
	
		case 'map':
			activeView = "showMap";
			jQuery("#fullScreenModal .-map-btn").addClass("active");
			generateMapFullScreen(obj.latitud,obj.longuitud);
			break;

		case 'video':
			activeView = "showVideo";
			jQuery("#fullScreenModal .-video-btn").addClass("active");
			generateVideoFullScreen(obj.videoUrl,obj.videoTitle);
			break;
	}

	jQuery("body").addClass("open-full-screen "+activeView);
}

//REMUEVE LA VISTA FULL SCREEN
function removeFullScreen(){
	//jQuery("#fullVideoView .ms-wrapper-video").remove();
	jQuery("body").removeClass("showVideo showMap showPhoto open-full-screen");
	//jQuery("#fullGalleryView").removeClass("slider-loaded");
	setTimeout(function () {
    if(jQuery("#fullGalleryView").hasClass("gs-builded")){
		  gs.slider['fullGalleryView'].destroy();
    }

		jQuery("#fullScreenModal").remove();
		//jQuery("#fullMapView .ms-wrapper-map").remove();
	}, 900);

	//console.log("Borrando...");
}

//BOTON DE VIDEO EN LA LISTA DE OPCIONES PHOTO/MAPA/VIDEO FLOTANTE
jQuery(document).on('click', '.js-show-video-cover-bl', function () {
	//GENERAMOS EL VIDEO SEGUN EL TIPO
	var videoUrl = jQuery(this).attr("data-video");
	var videoTitle = jQuery(this).attr("data-title");
	var videoParent = jQuery(this).attr("data-parent");
	
	if(!jQuery(videoParent).hasClass("loaded")){
		jQuery(videoParent).html('<div id="player"></div>');
		coverVideoGenerator(videoUrl,videoTitle,videoParent);
		jQuery(videoParent).addClass("loaded");
	}
});

//BOTON QYE REMUEVE EL MODAL DE FULL SCREEN EN LA VISTA VIDEO
jQuery(document).on('click', '.js-close-full-screen', function(event){
	event.preventDefault();
	removeFullScreen();
});

//BOTON DE FULL SCREEN
jQuery(document).on('click', '.js-open-full-screen', function (event) {
	event.preventDefault();

	if(!jQuery(this).hasClass("active")){

		//LIMPIAMOS TODO ANTES DE GENERAR ALGO
		var type = jQuery(this).attr("data-type");

		switch (type) {
			case 'photo':
				let photo = {
					typeView: 'photos',
					galleyActive: jQuery(this).attr("data-gallery"),
					itemInit: parseInt(jQuery(this).attr("data-initial")),
					element: jQuery(this)
				};
				activeFullScreen(photo);
				break;

			case 'map':
				let map = {
					typeView: 'map',
					latitud: jQuery(this).attr("data-lat"),
					longuitud: jQuery(this).attr("data-lng"),
					element: jQuery(this)
				};
				activeFullScreen(map);
				break;

			case 'video':
				let video = {
					typeView: 'video',
					videoUrl: jQuery(this).attr("data-video"),
					videoTitle: jQuery(this).attr("data-title"),
					element: jQuery(this)
				};
				activeFullScreen(video);
				break;
		}

	}
});

//ACTIVAMOS LA VISTA FULL SCREEN AL DAR CLICK EN ALGUNO DE LOS ELEMENTOS DEL SLIDER PRINCIPAL
jQuery(document).on('click', '#full-slider .clidxboost-full-slider .gs-item-slider', function () {
	let photo = {
		typeView: 'photos',
		galleyActive: '.clidxboost-full-slider',
		itemInit: parseInt(jQuery(this).index() + 1),
		element: jQuery(this)
	};
	activeFullScreen(photo);
});

jQuery(document).on('click', '.js-close-temp-video-view', function () {
	jQuery("body").removeClass("mobileVideo");
	player.mute();
});

//ACTIVAMOS LA VISTA FULL SCREEN AL DAR CLICK EN ALGUNO DE LOS ELEMENTOS DEL SLIDER PRINCIPAL
jQuery(document).on('click', '.ib-modal-master .ib-pvslider .gs-item-slider', function () {
	let photo = {
		typeView: 'photos',
		galleyActive: '.ib-modal-master .ib-pvslider',
		itemInit: parseInt(jQuery(this).index() + 1),
		element: jQuery(this)
	};
	activeFullScreen(photo);
});

jQuery(document).ready(function() {
	var windowSize = jQuery(window).width();
	var heightHeader = jQuery("header").outerHeight();
	var heightHeaderAdd = heightHeader + 49;
	if(windowSize > 1023){	
		jQuery(".single-flex-landing-pages #flex-filters-theme .gwr-breadcrumb").css({'position':'fixed','z-index':'5','top':heightHeader});
		jQuery(".single-flex-landing-pages #flex-filters-theme .ib-filter-container.fixed-box").css({'position':'fixed','top':heightHeaderAdd});
		if (window.__flex_g_settings.version != "1") {
			jQuery(".single-flex-landing-pages #flex-filters-theme").css({'margin-top':'49px'});
		}		
	}
});

jQuery(document).on('click', '.js-active-why-register', function () {
	jQuery("body").addClass("showMessageWhyRegister");
});

jQuery(document).on('click', '.js-close-why-register', function () {
	jQuery("body").removeClass("showMessageWhyRegister");
});

//VALIDACION DE FORMULARIOS
var iti = new Array();
var countElements = 0;
var phoneText, placeholderText = "";
var isLogin = "";

function defaultFormValidation(){
	//PARA EL FORMATO DE VALIDACION
	phoneText = word_translate.enter_a_valid_phone_number;
	placeholderText = word_translate.enter_a_phone_number;

	var formValidation = jQuery(".iboost-form-validation");
	var phoneCodeItem = formValidation.find(".phoneCodeValidation");

	if(!phoneCodeItem.length){
		jQuery("<input type='hidden' class='phoneCodeValidation' name='phoneCodeValidation' value=''>").appendTo(formValidation);
		var phoneCodeValidation = phoneCodeItem.val("1");
	}else{
		var phoneCodeValidation = phoneCodeItem.val();
	}

	//CONSULTAMOS SI YA ESTAMOS LOGUEADOS
	if ("no" === __flex_g_settings.anonymous) {
		if(phoneCodeValidation == "" && phoneCodeValidation == "0"){
			isLogin = "auto";
		}else{
			isLogin = "";
		}
	}else{
		isLogin = "auto";
	}

	if(!formValidation.hasClass("loaded")){

		//Caracteres permitidos
		var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
		var utilsScript = __flex_g_settings.templateDirectoryPlugin+"js/vendor/intltelinput/js/utils.js";
		var inputs = document.querySelectorAll(".iboost-form-validation input[type='tel']");

		jQuery(document).on("input", ".iboost-form-validation input[type='email']", function () {
			var email = jQuery(this).val();
			var emailText = word_translate.enter_a_valid_email_address;
			if(!jQuery(this).hasClass("validate-gen")){
				jQuery(this).after('<span class="ms-validation-text"></span>');
				jQuery(this).addClass("validate-gen");
			}

			if (!emailRegex.test(email)) {
				jQuery(this).addClass("ms-input-error");
				jQuery(this).parent().find(".ms-validation-text").html("<span>"+emailText+"</span>");
			} else {
				jQuery(this).removeClass("ms-input-error");
				jQuery(this).parent().find(".ms-validation-text").empty();
			}
		});

		jQuery(document).on("keypress", "form input[type='phone'], form input[type='tel']", function (event) {
			var keyCode = event.which;
			if (keyCode < 48 || keyCode > 57)
			  event.preventDefault();
		  });
  
		  jQuery(document).on("paste", "form input[type='phone'], form input[type='tel']", function (event) {
			event.preventDefault();
		  });

		jQuery(document).on("keyup change", "form input[type='phone'], form input[type='tel']", function (event) {
			if(!jQuery(this).hasClass("validate-gen")){
				jQuery(this).parents('.ms-wrapper-phone-it').after('<span class="ms-validation-text"></span>');
				jQuery(this).addClass("validate-gen");
			}

			var idInput = jQuery(this).parents(".ms-wrapper-phone-it").attr("id");
			if (iti[idInput].isValidNumber()) {
				jQuery(this).removeClass("ms-input-error");
				jQuery(this).parents().find(".ms-validation-text").empty();
			}else{
				jQuery(this).addClass("ms-input-error");
				jQuery(this).parents().find(".ms-validation-text").html("<span>"+phoneText+"</span>");
			}
		});

		if (inputs) {
			var parent, formWrapper = "";
			inputs.forEach(input => {

				parent = input.closest(".ms-wrapper-phone-it");
				formWrapper = input.closest("form");

				if (typeof parent === 'undefined' || parent === null) {
					var tempElement = input;
					var idCode = (Math.random() + 1).toString(36).substring(7);
					jQuery("<div class='ms-wrapper-phone-it' id='"+idCode+"'></div>").insertBefore(jQuery(input));
					jQuery(input).remove();
					jQuery("#"+idCode).html(tempElement);
					jQuery("#"+idCode).find("input[type='tel']").removeAttr("placeholder");
					jQuery(input).parents("form").attr("data-id",idCode);
				}

				iti[idCode] = window.intlTelInput(input, {
					//autoPlaceholder: false,
					//formatOnDisplay: true,
					initialCountry: isLogin,
					customPlaceholder: function(selectedCountryPlaceholder, selectedCountryData) {
						return placeholderText+"*";
					},

					geoIpLookup: function(callback) {
						fetch(__flex_g_settings.api_get_ip_lead,{method:'POST'})
						.then(function(res) { return res.json(); })
						.then(function(data) { 					    	

							var getCountryData = iti[idCode].countries.filter(function(item){
								return (item.iso2 == data.country.toLowerCase() );
							});

							var dialCode = "+1";
							if (getCountryData.length > 0 ) {
								dialCode = "+"+getCountryData[0].dialCode;
							}

							if ( jQuery("#"+idCode).find(".country_code").length  == 0) {
								jQuery("<input type='hidden' class='country_code' name='country_code' value='"+dialCode+"' >").insertBefore(jQuery(input));
							}else{
								jQuery("#"+idCode).find(".country_code").val(dialCode)
							}

							callback(data.country); 
						
						}).catch(function() { 
							callback("us"); 
						});
					},

					nationalMode: true,
					separateDialCode: true,
					utilsScript: utilsScript
				});

				var selectedCountryData = iti[idCode].getSelectedCountryData();
				var dialCode = "+1";
				dialCode = "+"+selectedCountryData.dialCode;
				if ( jQuery("#"+idCode).find(".country_code").length  == 0) {
					jQuery("<input type='hidden' class='country_code' name='country_code' value='"+dialCode+"' >").insertBefore(jQuery(input));
				}else{
					jQuery("#"+idCode).find(".country_code").val(dialCode)
				}
				
				jQuery(input).on("countrychange", function() {
					var selectedCountryData = iti[idCode].getSelectedCountryData();
					var dialCode = "+1";
					dialCode = "+"+selectedCountryData.dialCode;
					if ( jQuery("#"+idCode).find(".country_code").length  == 0) {
						jQuery("<input type='hidden' class='country_code' name='country_code' value='"+dialCode+"' >").insertBefore(jQuery(input));
					}else{
						jQuery("#"+idCode).find(".country_code").val(dialCode)
					}
				});

				iti[idCode].promise.then(function() {
					jQuery(inputs).trigger("countrychange");
				});
			});
		}

		formValidation.addClass("loaded iboost-form-validation-loaded");
		formValidation.removeClass("iboost-form-validation");
	}
}

jQuery(document).on("click", ".iboost-form-validation-loaded .iti__country-list .iti__country", function() {
	iti[jQuery(this).parents(".iboost-form-validation-loaded").attr("data-id")].setNumber("");
	var valueInput = jQuery(this).parents(".iboost-form-validation-loaded").find("input[type='tel']").val();
	jQuery(this).parents(".iboost-form-validation-loaded").find("input[type='tel']").val(valueInput);
	jQuery(this).parents(".iboost-form-validation-loaded").find("input[type='tel']").removeClass("validate-gen ms-input-error");
	jQuery(this).parents(".iboost-form-validation-loaded").find(".ms-validation-text").remove();
});

jQuery(window).load(function(){
	var phoneAndCodeNumber = Cookies.get("_ib_user_new_phone_number");
	//console.log("phoneAndCodeNumber="+phoneAndCodeNumber);
	if(phoneAndCodeNumber !== undefined && phoneAndCodeNumber !== "" && phoneAndCodeNumber !== "0" && phoneAndCodeNumber !== null){
		jQuery("form input[type='tel']").val(phoneAndCodeNumber);
	}
	defaultFormValidation();
});

jQuery(".follow_up_boss_valid_register").change(function(){
  if(jQuery(this).is(":checked")) {
    jQuery(this).removeClass("error");
    jQuery("#socialMediaRegister").removeClass("disabled");
  } else {
    jQuery(this).addClass("error");
    jQuery("#socialMediaRegister").addClass("disabled");
  }
});

jQuery(document).on("click", ".js-tab-amt", function(event) {
	event.preventDefault();
	var dataTab = jQuery(this).attr("data-tab");
	jQuery(".js-tab-amt").removeClass("active");
	jQuery(".js-body-amt").removeClass("active");
	jQuery(dataTab).addClass("active");
	jQuery(this).addClass("active");
});

jQuery(document).on('click', 'body.openHistoryMenu .ms-overlay.js-toggle-menu', function(event){
	event.preventDefault();
	jQuery(".ms-history-menu-btn-back").trigger("click");
});
