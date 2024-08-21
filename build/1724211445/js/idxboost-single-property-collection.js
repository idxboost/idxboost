(function ($) {

	const WINDOW = $(window);
	const DOCUMENT = $(document);
	const BODY = $('body');

	const IB_SP = $('.js-ib-sp');
	const IB_SP_TOTAL = $('.js-ib-sp-total');
	const IB_SP_SORT_FILTER = $('#ib-gsort-b');
	const IB_SP_LIST = $('.js-ib-sp-list:eq(0)');
	const IB_SP_PAGINATION = $('.js-ib-sp-pagination');
	const IB_SP_COLUMN = $('.js-ib-sp');

	const IB_MODAL_REGISTER_FORM_TAGS = document.getElementById('formRegister_ib_tags');
	const IB_MODAL_REGISTER_CLOSE_BTN = document.querySelector('#modal_login .close-modal');

	var xhr_setting = false;
	var countClickAnonymous = 0;
	var IB_HAS_LEFT_CLICKS = (__flex_g_settings.hasOwnProperty("signup_left_clicks") && (null != __flex_g_settings.signup_left_clicks));
	var IB_CURRENT_LEFT_CLICKS;

	// Fallback images
	const IB_SP_IMAGE_INIT = `${window.location.origin}/wp-content/plugins/idxboost/images/single-property/temp.png`;
	const IB_SP_IMAGE_ERROR = 'https://www.idxboost.com/i/default_thumbnail.jpg';

	let column_view = 'four';
	let display_results = 'price-desc';

	$.ajax({
		url: ib_property_collection.ajaxSetting,
		method: "POST",
		data: JSON.stringify({ "registration_key": ib_property_collection.rg, limit: ib_property_collection.limit }),
		dataType: "json",
		success: function (data, textStatus, xhr) {

			if (xhr.status == 200) {
				ib_property_collection.order = data.display_results;
				ib_property_collection.column = data.grid_column;

				if (!isNaN(ib_property_collection.column)) {
					if ('1' == ib_property_collection.column) {
						column_view = 'one';
					}
					if ('2' == ib_property_collection.column) {
						column_view = 'two';
					}
					if ('3' == ib_property_collection.column) {
						column_view = 'three';
					}
					if ('4' == ib_property_collection.column) {
						column_view = 'four';
					}
					if ('5' == ib_property_collection.column) {
						column_view = 'five';
					}
				}
				IB_SP_COLUMN.addClass("columns-" + column_view);

				if (['list_date-desc', 'price-asc', 'price-desc', 'sqft-asc', 'sqft-desc'].includes(ib_property_collection.order)) {
					display_results = ib_property_collection.order;
				}
				IB_SP_SORT_FILTER.val(display_results);
				xhr_setting = true;

				listSingleProperties();

			}
		}

	});

	/**
	 * Sort properties
	 */
	IB_SP_SORT_FILTER.change(function () {
		if (xhr_setting != false) {
			listSingleProperties();
		}
	}).trigger("change");

	function listSingleProperties(currentPage = 1) {
		let sortProperty = IB_SP_SORT_FILTER.val();
		IB_SP_TOTAL.html(word_translate.loading_properties);

		let data = {
			"registration_key": ib_property_collection.rg,
			"page": currentPage,
			"sort": sortProperty
		};

		if (
			ib_property_collection.limit &&
			parseInt(ib_property_collection.limit) != 0
		) {
			data.limit = parseInt(ib_property_collection.limit);
		}

		$.ajax({
			url: ib_property_collection.ajaxlist,
			method: "POST",
			data: JSON.stringify(data),
			dataType: "json",
			success: function (response) {
				let listHTML = [];
				let paginationHTML = [];

				if (response.status) {
					let properties = response.properties;
					let totalProperties = response.total;
					let pagination = response.pagination;

					// Number of properties to show
					IB_SP_TOTAL.html(`
						${word_translate.showing} ${pagination.start} 
						${word_translate.to} ${pagination.end}
						${word_translate.of} 
						${_.formatPrice(pagination.count)} ${word_translate.properties}.
					`);

					properties.forEach(function (item) {
						let totalPhotosProperty = item.propertyPhotoGalleryCount;
						let hideGreatSliderNav = totalPhotosProperty < 2 ? 'ib-piwoimgs' : '';

						if (ib_property_collection.mode == 'slider') {
							listHTML.push('<ul class="result-search slider-generator slider-generator-sp">');
							listHTML.push('<li class="propertie"  data-id="' + item.propertyId + '" data-counter="0">');

							let websiteName = item.websiteName ? item.websiteName : '';
							let propertyPrice = item.propertyPrice != '' ? item.propertyPrice : '';
							let propertyBeds = item.propertyBeds != '0' ? item.propertyBeds + '  <span>' + word_translate.beds + ' </span>' : '';
							let propertyBaths = item.propertyBaths != '0' ? item.propertyBaths + '  <span>' + word_translate.baths + ' </span>' : '';
							let propertyLivingSize = item.propertyLivingSize != '0' ? '<span>' + _.formatPrice(item.propertyLivingSize) + '</span>' + word_translate.sqft + '<span></span>' : '';

							listHTML.push('<h2 title="' + websiteName + '">' + websiteName + '</h2>');
							listHTML.push('<ul class="features">');
							listHTML.push('<li class="address">' + websiteName + '</li>');
							if (item.propertyPrice != '') { listHTML.push('<li class="price">' + propertyPrice + '</li>'); }
							listHTML.push('<li class="pr down"></li>');
							if (item.propertyBeds != '0') { listHTML.push('<li class="beds">' + propertyBeds + '</li>'); }
							if (item.propertyBaths != '0') { listHTML.push('<li class="baths">' + propertyBaths + '</li>'); }
							if (item.propertyLivingSize != '0') { listHTML.push('<li class="living-size"> ' + propertyLivingSize + ' </li>'); }
							listHTML.push('<li class="price-sf"> <span></span> </li>');
							listHTML.push('<li class="build-year"> <span></span> </li>');
							listHTML.push('<li class="development"> <span></span> </li>');
							//listHTML.push('<li class="ms-logo-board"><img src="https://idxboost-spw-assets.idxboost.us/logos/fmls.png"></li>');
							listHTML.push('</ul>');
							listHTML.push('<div class="wrap-slider">');
							listHTML.push('<ul>');

							item.propertyPhotoGallery.forEach(function (gallery, index_gallery) {
								if (index_gallery == 0) {
									listHTML.push('<li class="flex-slider-current"><img class="flex-lazy-image" data-original="' + gallery + '" alt="' + item.websiteName + '"></li>');
								} else {
									listHTML.push('<li class="flex-slider-item-hidden"><img class="flex-lazy-image" data-original="' + gallery + '" alt="' + item.websiteName + '"></li>');
								}
							});

							listHTML.push('</ul>');

							if (item.propertyPhotoGallery.length > 1) {
								listHTML.push('<button class="prev flex-slider-prev" aria-label="Next" tab-index="-1"><span class="clidxboost-icon-arrow-select"></span></button>');
								listHTML.push('<button class="next flex-slider-next" aria-label="Prev" tab-index="-1"><span class="clidxboost-icon-arrow-select"></span></button>');
							}


							listHTML.push('</div>');
							//listHTML.push('<a class="ib-view-detailt" href="'+slug_post+'" rel="nofollow">'+word_translate.details+' of '+info_item.address_short+'</a>');
							listHTML.push('</li>');
							listHTML.push('</ul>');

						} else {
							listHTML.push(`
								<li class="ib-pitem propertie" data-id="${item.propertyId}">
									<ul class="ib-piinfo">
										${(() => {
									if (item.propertyPrice != '') {
										return `<li class="ib-piitem ib-piprice">${item.propertyPrice}</li>`
									} else {
										return ''
									}
								})()
								}

										${(() => {
									if (item.propertyBeds != '0') {
										return `<li class="ib-piitem ib-pibeds">${item.propertyBeds}<span>&nbsp${word_translate.beds}</span></li>`
									} else {
										return ''
									}
								})()
								}

										${(() => {
									if (item.propertyBaths != '0') {
										return `<li class="ib-piitem ib-pibaths">${item.propertyBaths}<span>&nbsp${word_translate.baths}</span></li>`
									} else {
										return ''
									}
								})()
								}

										${(() => {
									if (item.propertyLivingSize != '0') {
										return `<li class="ib-piitem ib-pisqft">${_.formatPrice(item.propertyLivingSize)} ${word_translate.sqft}</li>`
									} else {
										return ''
									}
								})()
								}

										${(() => {
									if (item.websiteName != '') {
										return `<li class="ib-piitem ib-paddress">${item.websiteName}</li>`
									} else {
										return ''
									}
								})()
								}
										
									</ul>

									<div class="ib-pislider gs-container-slider ${hideGreatSliderNav}">
										${(() => {
									if (totalPhotosProperty) {
										let images = [];

										for (let i = 0, l = item.propertyPhotoGallery.length; i < l; i++) {
											if (i < 1) {
												images.push(`
																<img class="ib-pifimg sp-lazy" 
																	onerror="this.src='${IB_SP_IMAGE_ERROR}';"
																	data-img="${item.propertyPhotoGallery[i]}" src="${IB_SP_IMAGE_INIT}"
																	title="${item.websiteName}" alt="${item.websiteName}">
															`)
											} else {
												images.push(`
																<img class="gs-lazy" 
																	onerror="this.src='${IB_SP_IMAGE_ERROR}';"
																	data-lazy="${item.propertyPhotoGallery[i]}" src="${IB_SP_IMAGE_INIT}"
																	title="${item.websiteName}" alt="${item.websiteName}">
															`)
											}
										}

										return images.join("");
									} else {
										return `
														<img class="ib-pifimg sp-lazy" 
															data-img="${IB_SP_IMAGE_ERROR}" src="${IB_SP_IMAGE_INIT}"
															title="${item.websiteName}" alt="${item.websiteName}">
													`
									}
								})()
								}
										<div class="gs-container-navs">
											<div class="gs-wrapper-arrows">
												<button class="gs-prev-arrow" tabindex="-1" aria-label="Previous image"></button>
												<button class="gs-next-arrow" tabindex="-1" aria-label="Next image"></button>
											</div>
										</div>
									</div>

									<a class="ib-pipermalink" href="#" aria-label="${item.websiteName}">
										<span>${item.websiteName}</span>
									</a>
								</li>
							`);
						}

					});

					if (pagination.pages > 1) {

						paginationHTML.push(`
							<span class="ib-pagn">
								${word_translate.page} ${currentPage} ${word_translate.of} ${pagination.pages}
							</span>
						`);

						if (currentPage > 1) {
							paginationHTML.push(`
								<a class="ib-pagfirst ib-paggo" data-page="1" href="#">
									<span>${word_translate.first_page}</span>
								</a>
              `);
						}

						if (pagination.prev) {
							paginationHTML.push(`
								<a class="ib-pagprev ib-paggo" data-page="${(currentPage - 1)}" href="#">
									<span>${word_translate.previous_page}</span>
								</a>
							`);
						}

						if (pagination.range.length) {
							paginationHTML.push(`<div class="ib-paglinks">`);

							for (let i = 0, l = pagination.range.length; i < l; i++) {
								if (currentPage == pagination.range[i]) {
									paginationHTML.push(`
										<a class="ib-plitem ib-plitem-active" 
											data-page="${pagination.range[i]}" href="#">
											${pagination.range[i]}
										</a>
                  `);
								} else {
									paginationHTML.push(`
										<a class="ib-plitem" 
											data-page="${pagination.range[i]}" href="#">
											${pagination.range[i]}
										</a>
									`);
								}
							}

							paginationHTML.push(`</div>`);
						}

						if (pagination.next) {
							paginationHTML.push(`
								<a class="ib-pagnext ib-paggo" data-page="${(currentPage + 1)}" href="#">
									<span>${word_translate.next_page}</span>
								</a>
							`);
						}

						if (currentPage < pagination.pages) {
							paginationHTML.push(`
								<a class="ib-paglast ib-paggo" data-page="${pagination.pages}" href="#">
									<span>${word_translate.last_page}</span>
								</a>
              `);
						}

					}
				}

				IB_SP_LIST.html(listHTML.join(''));
				IB_SP_PAGINATION.html(paginationHTML.join(''));
				if (ib_property_collection.mode == 'slider') {
					genMultiSliderSingleProperty(IB_SP_LIST); //slider
					IB_SP_LIST.addClass('clidxboost-properties-slider');
					myLazyLoad.update(); // Never comment this line, this is a global function
				}

				lazyLoad();
				jQuery("html, body").animate({ scrollTop: 0 }, 900);
			}
		});
	}

	IB_SP_PAGINATION.on('click', 'a', function (e) {
		e.preventDefault();

		if (!$(this).hasClass('ib-plitem-active')) {
			let goToNewPage = $(this).data("page");
			listSingleProperties(goToNewPage);
		}
	})

	// Attach lazy
	WINDOW.on('scroll', function () {
		lazyLoad();
	});

	/**
	 * Lazy load for property's first image
	 */
	function lazyLoad() {
		const IB_SP_LAZY_CLASS = 'sp-lazy';
		let images = $(`.${IB_SP_LAZY_CLASS}`);

		if (images.length) {
			images.each(function () {
				let image = $(this);
				if (isElementVisibleInDocument(image, WINDOW)) {
					image.attr('src', image.attr('data-img')).on('load', function () {
						image.removeAttr('data-img').removeClass(IB_SP_LAZY_CLASS);
					});
				}
			});
		}
	}

	/**
	 * Verifies if element is visible in document
	 * @param {object} element element to verify
	 * @param {object} document visible space
	 * @return {boolean}
	 */
	function isElementVisibleInDocument(element, document) {
		let documentViewTop = 0;
		let documentViewBottom = 0;
		let elementTop = 0;
		let elementBottom = 0;

		documentViewTop = document.scrollTop();
		documentViewBottom = documentViewTop + document.height();
		elementTop = $(element).offset().top;
		elementBottom = elementTop + $(element).height();

		return ((elementBottom > documentViewTop) && (elementTop < documentViewBottom));
	}

	/**
	 * Generate slider for the property
	 */
	IB_SP_LIST.on('click', '.gs-next-arrow', function () {
		const $sliderProperty = $(this).parents('.ib-pislider');

		// Slider isn't builded
		if (!$sliderProperty.hasClass('gs-builded')) {
			$sliderProperty.find('.ib-pifimg').removeClass('ib-pifimg');
			$sliderProperty.find('.gs-container-navs').remove();

			$sliderProperty.greatSlider({
				type: 'fade',
				nav: true,
				bullets: false,
				autoHeight: false,
				lazyLoad: true,
				startPosition: 2,
				layout: { arrowDefaultStyles: false },
				onLoadedItem: function (item, index, response) {
					if (response != 'success') {
						setTimeout(function () {
							item.attr("src", IB_SP_IMAGE_ERROR);
						}, 2000);
					}
				}
			});
		}
	});

	// const IB_SPC_MODAL_WRAPPER = $('.js-ib-spc-modal');

	const IB_SP_MODALS = $('.js-ib-sp-modals'); // Container for all SP modals
	const IB_SP_HANDLEBARS_TPL = $('.js-ib-sp-handlebars-template');
	const IB_SP_MODAL_WEBSITE = $('.js-ib-sp-modal-website');
	const IB_SP_MODAL_CONTACT = $('.js-ib-sp-modal-contact');
	const IB_SP_MODAL_PRIVACY = $('.js-ib-sp-modal-privacy');
	const IB_SP_MODAL_A11Y = $('.js-ib-sp-modal-accessibility');

	// Scope for SP theme settings
	const IB_SP_PAGE = '.js-ib-sps-page';

	/**
	 * Open property modal website and load detail
	 */
	IB_SP_LIST.on('click', '.ib-pitem', function (event) {
		if ($(event.target).hasClass('ib-pipermalink')) {
			event.preventDefault();

			BODY.addClass('ib-sp-modal-opened');
			const SP_ID = $(event.target).parent().data('id');
			loadSPDetail(SP_ID);
		}
	});

	/**
	 * Close property modal website
	 */
	IB_SP_MODALS.on('click', '.ib-pbtnclose', function () {
		BODY.removeClass('ib-sp-modal-opened');
		IB_SP_MODAL_WEBSITE.removeClass('ib-md-active');
		IB_SP_MODALS.empty();
	});

	Handlebars.registerHelper('replaceDashBySpace', function (string) {
		return string.replace('-', ' ');
	});

	Handlebars.registerHelper('ifequals', function (a, b, options) {
		return (a == b) ? options.fn(this) : options.inverse(this);
	});

	Handlebars.registerHelper('propertyHasFloorplans', function (floorplans) {
		return (floorplans.length > 1) ? true : false;
	});

	Handlebars.registerHelper('ifVisibility', function (section) {
		return (section == 'true' || section == true) ? true : false;
	});

	Handlebars.registerHelper('ifCond', function (a, b, options) {
		return (a && b) ? options.fn(this) : options.inverse(this);
	});

	Handlebars.registerHelper('ifCondOR', function (a, b, options) {
		return a || b;
	});

	/**
	 * 
	 */
	function loadSPDetail(SP_ID) {
		$.ajax({
			url: ib_property_collection.ajaxgetProperty,
			data: JSON.stringify({ "registration_key": ib_property_collection.rg, "id": SP_ID }),
			method: "POST",
			dataType: "json",
			success: function (response) {

				if (IB_SP_MODALS.length && IB_SP_HANDLEBARS_TPL.length) {
					let template = Handlebars.compile(IB_SP_HANDLEBARS_TPL.html());
					IB_SP_MODALS.html(template(response));

					const property = {
						name: response.websiteName,
						slug: response.publicDomainUrl || response.websiteSlugnameDomain,
					};

					loadSPThemeSettings(response.stylesInput.themeSettings);
					generateSPSliders();
					loadSPForms(property);
					loadMap();
					loadMainVideo();

					if ("undefined" === typeof Cookies.get("_ib_disabled_forcereg")) {
						if (true === IB_HAS_LEFT_CLICKS) {
							IB_CURRENT_LEFT_CLICKS = (parseInt(Cookies.get("_ib_left_click_force_registration"), 10) - 1);
							Cookies.set("_ib_left_click_force_registration", IB_CURRENT_LEFT_CLICKS);

							if (
								parseInt(
									Cookies.get("_ib_left_click_force_registration"),
									10
								) <= 0 &&
								"yes" === __flex_g_settings.anonymous
							) {
								
								// Set tags
								const tags = `Property Site, ${response.websiteName}`;
								handleTagsOnRegistrationForm('add',  tags);
								
								// No left click then open popup registration
								$("#modal_login")
									.addClass("active_modal")
									.find("[data-tab]")
									.removeClass("active");

								$("#modal_login")
									.addClass("active_modal")
									.find("[data-tab]:eq(1)")
									.addClass("active");

								$("#modal_login").find(".item_tab").removeClass("active");

								$("#tabRegister").addClass("active");

								$("#modal_login #msRst").empty().html($("#mstextRst").html());
								$("button.close-modal").addClass("ib-close-mproperty");
								$(".overlay_modal").css(
									"background-color",
									"rgba(0,0,0,0.8);"
								);

								$("#modal_login h2").html(
									$("#modal_login")
										.find("[data-tab]:eq(1)")
										.data("text-force")
								);

								/*Asigamos el texto personalizado*/
								var titleText = $(".header-tab a[data-tab='tabRegister']").attr('data-text')
								$("#modal_login .modal_cm .content_md .heder_md .ms-title-modal").html(titleText);

								// reset to default clicks
								//IB_CURRENT_LEFT_CLICKS = IB_DEFAULT_LEFT_CLICKS;
							}
						} else {
							if ("yes" === __flex_g_settings.anonymous) {
								if (
									__flex_g_settings.hasOwnProperty("force_registration") &&
									1 == __flex_g_settings.force_registration
								) {
									$("#modal_login")
										.addClass("active_modal")
										.find("[data-tab]")
										.removeClass("active");

									$("#modal_login")
										.addClass("active_modal")
										.find("[data-tab]:eq(1)")
										.addClass("active");

									$("#modal_login").find(".item_tab").removeClass("active");

									$("#tabRegister").addClass("active");

									$("#modal_login #msRst")
										.empty()
										.html($("#mstextRst").html());
									$("button.close-modal").addClass("ib-close-mproperty");
									$(".overlay_modal").css(
										"background-color",
										"rgba(0,0,0,0.8);"
									);

									$("#modal_login h2").html(
										$("#modal_login")
											.find("[data-tab]:eq(1)")
											.data("text-force")
									);

									/*Asigamos el texto personalizado*/
									var titleText = $(".header-tab a[data-tab='tabRegister']").attr('data-text')
									$("#modal_login .modal_cm .content_md .heder_md .ms-title-modal").html(titleText);
									// }
								}
							}
						}
					}

				}

			}
		});
	}

	/**
	 * 
	 */
	function loadSPThemeSettings({ fontFamily, buttons }) {
		setSPFontFamily(fontFamily);
		setSPButtonColors(buttons);
	}

	function setSPFontFamily(fontFamily) {

		if (fontFamily == "compass-sans-and-serif") {
			document.querySelector(IB_SP_PAGE).classList.add('CompassSansSerif');
			fontFamily = '"Compass Sans", Helvetica, Arial, sans-serif';
			document.querySelectorAll(IB_SP_PAGE).forEach(item => {
				item.style.setProperty('--sps-font-family', fontFamily);
			});
		} else if (fontFamily == "'Compass Sans', Helvetica, Arial, sans-serif") {
			fontFamily = '"Compass Sans", Helvetica, Arial, sans-serif';
			document.querySelectorAll(IB_SP_PAGE).forEach(item => {
				item.style.setProperty('--sps-font-family', fontFamily);
			});
		} else if (fontFamily == "'Compass Serif', Times, 'Times New Roman', serif") {
			fontFamily = '"Compass Serif", Times, "Times New Roman", serif';
			document.querySelectorAll(IB_SP_PAGE).forEach(item => {
				item.style.setProperty('--sps-font-family', fontFamily);
			});
		} else if (fontFamily == "dinengschrift-and-open-sans") {
			document.querySelector(IB_SP_PAGE).classList.add('dinengschrift-and-open-sans');
			fontFamily = 'Open Sans, sans-serif';
			document.querySelectorAll(IB_SP_PAGE).forEach(item => {
				item.style.setProperty('--sps-font-family', fontFamily);
			});
		} else {
			let webFontLoaded = false;

			if (!webFontLoaded) {
				let js = document.createElement("script");
				js.src = 'https://ajax.googleapis.com/ajax/libs/webfont/1.6.26/webfont.js';
				js.async = 1;
				let firstScript = document.getElementsByTagName("script")[0];
				firstScript.parentNode.insertBefore(js, firstScript);
				webFontLoaded = true;
			}

			setTimeout(() => {
				WebFont.load({
					google: {
						families: [`${fontFamily}:400,500,600,700`]
					},

					/* 
						Called when each requested web font has finished loading.
						The fontFamily parameter is the name of the font family, 
						and fontDescription represents the style and weight of the font. 
					*/
					fontactive: function (fontFamily, fontDescription) {
						document.querySelectorAll(IB_SP_PAGE).forEach(item => {
							item.style.setProperty('--sps-font-family', fontFamily);
						});
					},
				});
			}, 1000);
		}

	}

	function setSPButtonColors(buttonColors) {
		document.querySelectorAll(IB_SP_PAGE).forEach(item => {
			item.style.setProperty('--sps-button-text-color', buttonColors.color);
			item.style.setProperty('--sps-button-text-color-hover', buttonColors.hoverColor);
			item.style.setProperty('--sps-button-background-color', buttonColors.backgroundColor);
			item.style.setProperty('--sps-button-background-color-hover', buttonColors.backgroundHoverColor);
			item.style.setProperty('--sps-button-border-color', buttonColors.borderColor);
		});
	}

	/**
	 * Generate sliders inside SP Modal Website
	 */
	function generateSPSliders() {

		// Slider for Home section
		const $sliderHome = $('.ib-sps-page .js-slider-home');

		if ($sliderHome.length) {
			$.each($sliderHome, function () {

				let $slider = $(this);

				$slider.greatSlider({
					type: 'fade',
					nav: false,
					lazyLoad: true,
					bullets: false,
					autoHeight: false,
					autoplay: true,
					autoplaySpeed: 7000,
				});

			});
		}

		const $sliderVideoTour = $(".sps-video-slider");
		if ($sliderVideoTour.length) {
			let $videoTourGS = $sliderVideoTour.greatSlider({
				type: 'swipe',
				nav: false,
				lazyLoad: true,
				bullets: false,
				autoHeight: false,
				autoplay: true,
				autoplaySpeed: 7000,

				onInited: function () {
					// Assign action to Next button
					$sliderVideoTour.parents('#sps-virtual').find('.sps-btn-next').click(function () {
						$videoTourGS.goTo('next');
					});

					// Assign action to Prev button
					$sliderVideoTour.parents('#sps-virtual').find('.sps-btn-next').click(function () {
						$videoTourGS.goTo('prev');
					});
				}
			});
		}

		let sliderVideoItems = 0;
		const $sliderVideo = $("#sps-slider-video");

		if ($sliderVideo.length) {
			const videos = $sliderVideo.find(".sps-item-video");
			videos.each(function () {
				sliderVideoItems += 1;
				let newID = `video_item_${sliderVideoItems}`;
				let videoURL = $(this).attr("data-video");

				$(this).attr("id", newID);
				getVideoThumbnail(videoURL, $(this));
			});

			let enableNav = sliderVideoItems > 1 ? true : false;

			const $sliderVideoGS = $sliderVideo.greatSlider({
				type: 'swipe',
				nav: enableNav,
				navSpeed: 500,
				lazyLoad: true,
				bullets: false,
				items: 1,
				drag: false,

				onInited: function () {
					$sliderVideo.find("iframe").each(function () {
						$(this).remove();
					});

					$sliderVideo.find("video").each(function () {
						$(this)[0].pause();
						$(this)[0].controls = false;
					});

					$sliderVideo.find(".sps-play-video").each(function () {
						$(this).removeClass('hide');
					});
				},

				onStepStart: function () {
					$sliderVideo.find("video").each(function () {
						$(this)[0].pause();
						$(this)[0].controls = false;
						$(this)[0].currentTime = 0;
					});

					$sliderVideo.find("iframe").each(function () {
						$(this).remove();
					});

					$sliderVideo.find(".sps-play-video").each(function () {
						$(this).removeClass('hide');
					});
				},

				onStepEnd: function () {
					$sliderVideo.find("video").each(function () {
						$(this)[0].controls = false;
					});

					$sliderVideo.find("iframe").each(function () {
						$(this).remove();
					});

					$sliderVideo.find(".sps-play-video").each(function () {
						$(this).removeClass('hide');
					});
				},
			});
		}

		const $sliderFloorPlan = $("#sps-slider-prop");
		if ($sliderFloorPlan.length) {
			const $floorPlanGS = $sliderFloorPlan.greatSlider({
				type: 'swipe',
				nav: false,
				navSpeed: 500,
				lazyLoad: true,
				bullets: true,
				items: 1,
				layout: {
					bulletDefaultStyles: false,
					wrapperBulletsClass: 'idx-gs-wrapper-bullets',
				},

				onInited: function () {
					let itemCount = 0;
					let imageCount = 0;
					let textButton = '';
					let imageURL = '';
					let thumbURL = '';
					let imageStyle = '';

					$sliderFloorPlan.find('img').each(function () {
						imageCount += 1;
						textButton = `View Slide ${imageCount}`;
						imageURL = $(this).attr('data-img');

						if (imageURL !== "" && imageURL !== undefined) {
							thumbURL = imageURL;
						} else {
							thumbURL = $(this).attr('src');
						}

						imageStyle = `background: url('${thumbURL}')`;
						// Assign image to bullets as background
						$sliderFloorPlan.find(`.gs-bullet:eq(${itemCount})`).html(`<span style="${imageStyle}"></span>`);
						$sliderFloorPlan.find(`.gs-bullet:eq(${itemCount})`).attr('aria-label', textButton);
						itemCount += 1;
					});

					// Assign action to Next button
					$sliderFloorPlan.parents("#sps-slider-wp").find('.sps-btn-next').click(function () {
						$floorPlanGS.goTo('next');
					});

					// Assign action to Prev button
					$sliderFloorPlan.parents("#sps-slider-wp").find('.sps-btn-prev').click(function () {
						$floorPlanGS.goTo('prev');
					});

					setTimeout(function () { setSliderTopPosition(); }, 300);
				},

				onResized: function () {
					setTimeout(function () { setSliderTopPosition(); }, 300);
				}
			});
		}
	}

	function setSliderTopPosition() {
		let finalTop = 0;
		let topPosition = $("#sps-slider-wp .gs-container-items").outerHeight() / 2;

		finalTop = topPosition;
		$("#sps-slider-wp .sps-wrap-action-btn").css({ "top": finalTop });

		$(window).on('resize', function () {
			let finalTop = 0;
			let topPosition = $("#sps-slider-wp .gs-container-items").outerHeight() / 2;

			finalTop = topPosition;
			$("#sps-slider-wp .sps-wrap-action-btn").css({ "top": finalTop });
		});
	}

	function getVideoThumbnail(element, parent) {
		let videoStr = element.toString();
		let { id, service } = getVideoId(videoStr);

		if (service == 'youtube') {
			parent.append(`<img src="https://img.youtube.com/vi/${id}/0.jpg">`);
		} else if (service == 'vimeo') {
			$.ajax({
				url: 'https://vimeo.com/api/oembed.json?url=https://vimeo.com/' + id,
				async: false,
				data: { format: "json", width: 960 },
				success: function (response) {
					if (response.thumbnail_url) {
						parent.append(`<img src="${response.thumbnail_url}">`);
					}
				}
			});
		} else if (videoStr.indexOf('images') !== -1) {
			parent.append(`<img src="${videoStr}">`);
		} else {
			parent.append(`<video autoplay="false" src="${videoStr}" loop>`);
		}
	}

	function loadMainVideo() {
		const IB_SP_VIDEO_WELCOME = $('.sps-main-video');

		if (IB_SP_VIDEO_WELCOME.length) {
			IB_SP_VIDEO_WELCOME.html('<div id="player"></div>');
			let videoUrl = IB_SP_VIDEO_WELCOME.attr('data-img');
			let videoTitle = IB_SP_VIDEO_WELCOME.attr('data-title');

			if (videoUrl !== undefined) {
				let videoStr = videoUrl.toString();
				let { id, service } = getVideoId(videoStr);

				if (service == 'youtube') {
					BODY.append(`<script>var tag=document.createElement("script");tag.src="https://www.youtube.com/iframe_api";var player,firstScriptTag=document.getElementsByTagName("script")[0];function onYouTubeIframeAPIReady(){player=new YT.Player("player",{width:"100%",videoId:"${id}",host:"${window.location.protocol}//www.youtube.com",playerVars:{autoplay:1,playsinline:1,loop:1,rel:0,showinfo:0,origin:'${window.location.origin}'},events:{onReady:onPlayerReady,onStateChange:onPlayerStateChange}})}function onPlayerReady(e){e.target.mute(),e.target.playVideo()}function onPlayerStateChange(e){e.data==YT.PlayerState.ENDED&&(player.seekTo(0),player.playVideo())}function stopVideo(){player.stopVideo()}firstScriptTag.parentNode.insertBefore(tag,firstScriptTag);</script>`);
				} else if (service == 'vimeo') {
					IB_SP_VIDEO_WELCOME.html(`<iframe allow="autoplay; encrypted-media" src="https://player.vimeo.com/video/${id}?autoplay=1&amp;muted=1&loop=1" frameborder="0" allowfullscreen title="${videoTitle}"></iframe>`);
				} else {
					IB_SP_VIDEO_WELCOME.html(`<video class="video-layer" id="idx-video" src="${videoUrl}" title="${videoTitle}" tab-index="-1" preload="none" autoplay loop muted playsinline>`);
				}
			}

			IB_SP_VIDEO_WELCOME.removeAttr('data-img');
		}
	}

	function loadMap() {
		const IB_SP_MAP = $('#googleMap');

		if (IB_SP_MAP.length) {
			let map = IB_SP_MAP.attr('data-img');
			let lat = IB_SP_MAP.attr('data-lat');
			let lng = IB_SP_MAP.attr('data-lng');
			let zoom = parseInt(IB_SP_MAP.attr('data-zoom'));

			let myLatLng = {
				lat: parseFloat(lat),
				lng: parseFloat(lng)
			};

			let newMap = new google.maps.Map(document.getElementById(map), {
				zoom: zoom,
				center: myLatLng,
				mapTypeControl: true,
				fullscreenControl: true
			});

			let marker = new google.maps.Marker({
				position: myLatLng,
				map: newMap
			});
		}
	}

	IB_SP_MODALS.on('click', '.sps-play-video', function () {
		var parent = $(this).parents(".sps-item-video");
		var videoUrl = parent.attr("data-video");
		var videoTitle = parent.attr("data-title");

		let videoStr = videoUrl.toString();
		let { id, service } = getVideoId(videoStr);

		if (service == 'youtube') {
			parent.append(`
        <iframe id="ytIframe" allow="autoplay; encrypted-media" 
          src="https://www.youtube.com/embed/${id}?&autoplay=1&loop=1&rel=0&showinfo=0&enablejsapi=1&origin=${window.location.origin}&color=white&iv_load_policy=3" 
          frameborder="0" allowfullscreen title="${videoTitle}">
        </iframe>
      `).ready(function () {
				var s = document.createElement("script");
				s.type = "text/javascript";
				s.src = "https://www.youtube.com/iframe_api";
				// Use any selector
				$("head").append(s);

				var player;
				var ytpIframe = document.getElementById('ytIframe');
				window.onYouTubeIframeAPIReady = function () {
					player = new YT.Player(ytpIframe, {
						events: {
							'onStateChange': onPlayerStateChange
						}
					});
				};
				window.onPlayerStateChange = function (event) {
					if (event.data == YT.PlayerState.ENDED || event.data == YT.PlayerState.PAUSED) {
						//player.stopVideo();
						$("#slider-video .gs-item-active .ms-item-video").contents().find(".ytp-pause-overlay").remove();
					}
				};
			});
		} else if (service == 'vimeo') {
			parent.append(`
				<iframe allow="autoplay; encrypted-media" 
					src="https://player.vimeo.com/video/${id}?autoplay=1&amp;loop=1" 
					frameborder="0" allowfullscreen title="${videoTitle}">
				</iframe>
			`);
		} else {
			parent.find("video")[0].play();
			parent.find("video")[0].controls = true;
		}

		$(this).addClass('hide');
	});

	/**
	 * Open property modal contact
	 */
	IB_SP_MODALS.on('click', '.sfm', function () {
		// IB_SP_MODAL_CONTACT.addClass('ib-md-active');
		$('.js-ib-sp-modal-contact').addClass('ib-md-active');
	});

	/**
	 * Open property website in another tab
	 */
	IB_SP_MODALS.on('click', '.ib-pbtnopen', function () {
		let link = $(this).data("permalink");
		window.open(link);
	});

	const getPropertyInformation = (property) => {
		return `Source: Property Site, ${property.name} (${property.slug})`;
	}

	const addPropertyInformationToMessage = (form, property) => {
		const message = $(form).find('textarea[name="message"]');
	
		if (message.val()) {
			message.val(`${message.val()} | ${getPropertyInformation(property)}`);
		} else {
			message.val(getPropertyInformation(property));
		}
	}

	/**
	 * 
	 */
	function loadSPForms(property) {
		const IB_SP_FORM_CONTACT = $(".js-ib-sp-contact-form");

		if (IB_SP_FORM_CONTACT.length) {
			IB_SP_FORM_CONTACT.on("submit", function (event) {
				event.preventDefault();
				contactForm = $(this);
				addPropertyInformationToMessage(contactForm, property);

				$.ajax({
					url: ib_property_collection.ajaxUrl,
					type: "POST",
					data: contactForm.serialize(),
					success: function (response) {
						if (response.success) {
							// handle submission via ajax
							contactForm
								.find('button[type="submit"]')
								.html('Thank you!');
							contactForm
								.find('button[type="submit"]')
								.after('<span class="form-message">We will contact you shortly</span>');
							contactForm
								.find(":input").prop("disabled", true);
						}
					}
				});
			});
		}
	}

	$(document).on('click', '.accordion-title', function () {
		var $item = jQuery(this);

		if ($item.hasClass('active')) {
			$item.removeClass('active');
			$item.next().removeClass('active');
		} else {
			$item.addClass('active');
			$item.next().addClass('active');
		}
	});

	$(document).on('click', '.sp-show-modal', function (e) {
		e.preventDefault();
		var idModal = $(this).attr("data-modal");
		$(idModal).addClass('ib-md-active');
	});

	/****GENERANDO SLIDER TIPO MODAL****/
	$(document).on('click', '.sps-modal-galery', function (e) {
		e.preventDefault();
		let parentId = $(this).parents(".sps-sps-slider").attr("id");
		let elementSelected = $(this).parents('.sps-sl-item').index();
		sliderModal(`#${parentId}`, elementSelected);
		$("body").addClass("sps-active-mds");
	});

	/**** REMOVIENDO SLIDER TIPO MODAL****/
	$(document).on('click', '.sps-modal-sp-slider .sps-close', function (e) {
		e.preventDefault();
		removeSliderModal();
		$("body").removeClass("sps-active-mds");
		$(".sps-modal-sp-slider").removeClass("in");
	});

	/**** GENERANDO MODAL Y SLIDER FLOORPLAN ****/
	function sliderModal(element, slideinit) {
		var mySliderList, temporalImage = "", slidesQuantity = 0;
		// var elementsQuantity = $(this).parents(".sps-sp-slider").find('.sps-sl-item').length;
		var genSlider = $("#sps-modal-sp-slider").find("#sps-gen-slider");
		if (!genSlider.hasClass("gs-builded")) {
			$(element).find('img').each(function () {
				slidesQuantity++;
				var imgeSliderBg = $(this).attr('data-bg');
				var imgAltText = $(this).attr('alt');
				if (imgeSliderBg !== "" && imgeSliderBg !== undefined) {
					temporalImage = imgeSliderBg;
				} else {
					var imgeSlider = $(this).attr('data-img');
					if (imgeSlider !== "" && imgeSlider !== undefined) {
						temporalImage = imgeSlider;
					} else {
						temporalImage = $(this).attr('src');
					}
				}

				var imgList = '<img src="' + temporalImage + '">';
				if (imgAltText !== undefined) {
					imgList = '<div class="sps-gallery-img-wrapper">' + imgList + '<span class="alt-text">' + imgAltText + '</span></div>';
				}
				mySliderList = mySliderList + imgList;
			});
			genSlider.empty().html(mySliderList);
			var starItem = slideinit + 1;
			var enableNav = slidesQuantity > 1 ? true : false; // If greather than one, enable nav on slider
			genSlider.greatSlider({
				type: 'swipe',
				nav: enableNav,
				lazyLoad: true,
				bullets: false,
				startPosition: starItem
			});
		}

		setTimeout(function () {
			$(".sps-modal-sp-slider").addClass("in");
		}, 300);
	}

	/**** REMOVER MODAL Y SLIDER FLOORPLAN ****/
	function removeSliderModal() {
		$("#sps-modal-sp-slider").find(".sps-wrap-slider").remove();
		$("#sps-modal-sp-slider").append('<div class="sps-wrap-slider" id="sps-gen-slider"></div>');
	}

	//slider
	function genMultiSliderSingleProperty(element) {
		var $multiSlider = $(element);
		if ($multiSlider.length) {

			//RECUPERANDO LOS PARAMETROS
			var initialItems, autoPlaySpeed, autoPlay = "";
			var dataItems = $multiSlider.parents(".featured-section").attr("data-item");
			var autoPlayStatus = ($multiSlider.parents(".featured-section").attr("auto-play")) * 1;
			var autoPlayspeed = $multiSlider.parents(".featured-section").attr("speed-slider");
			var styleFormat = ($multiSlider.parents(".featured-section").attr("data-gallery")) * 1; //PARAMETRO PARA EL FORMATO GRILLA O SLIDER

			//VALIDAMOS LA EXISTENCIA DE LOS PARAMETROS
			if (autoPlayStatus !== "" && autoPlayStatus !== undefined && autoPlayStatus > 0) {
				autoPlay = true;
			} else {
				autoPlay = false;
			}

			if (autoPlayspeed !== "" && autoPlayspeed !== undefined) {
				autoPlaySpeed = autoPlayspeed * 1;
			} else {
				autoPlaySpeed = 5000;
			}

			if (dataItems !== "" && dataItems !== undefined) {
				initialItems = dataItems * 1;
			} else {
				initialItems = 4;
			}

			//CONSULTAMOS LA EXISTENCIA Y EL TIPO DE FORMATO "GRILLA/SLIDER"
			if (styleFormat !== "" && styleFormat !== undefined && styleFormat > 0) {
				styleFormat = 1; //RECUPERAMOS EL PARAMETRO
			} else {
				styleFormat = 0;
			}

			//CONSULTAMOS EL FORMATO
			if (styleFormat == 1) {
				//generamos las clases para el formato de columnas
				if (initialItems < 2) {
					initialItems = 2;
				} else if (initialItems > 4) {
					initialItems = 4;
				} else {
					initialItems = initialItems;
				}

				$multiSlider.parents(".featured-section").addClass("ms-colums-" + initialItems);
			} else {
				//generamos el slider
				$multiSlider.greatSlider({
					type: 'swipe',
					nav: true,
					navSpeed: 500,
					lazyLoad: true,
					bullets: false,
					items: 1,
					autoplay: autoPlay,
					autoplaySpeed: autoPlaySpeed,
					layout: {
						bulletDefaultStyles: false,
						wrapperBulletsClass: 'clidxboost-gs-wrapper-bullets',
						arrowPrevContent: 'Prev',
						arrowNextContent: 'Next',
						arrowDefaultStyles: false
					},
					breakPoints: {
						640: {
							items: 2,
							slideBy: 2,
							nav: false,
							bullets: true
						},
						991: {
							items: 3,
							slideBy: 3
						},
						1360: {
							items: initialItems,
							slideBy: initialItems,
						}
					},
					onStepStart: function () {
						$(element).find(".flex-slider-current img").each(function () {
							if (!$(this).hasClass(".loaded")) {
								var dataImage = $(this).attr('data-original');
								$(this).attr("data-was-processed", "true").attr("src", dataImage).addClass("initial loaded");
							}
						});
					},
					onInited: function () {
						var $a = 0;
						var $bulletBtn = $multiSlider.find(".gs-bullet");
						if ($bulletBtn.length) {
							$bulletBtn.each(function () {
								$a += 1;
								$(this).text('View Slide ' + $a);
							});
						}
					},
					onResized: function () {
						var $a = 0;
						var $bulletBtn = $multiSlider.find(".gs-bullet");
						if ($bulletBtn.length) {
							$bulletBtn.each(function () {
								$a += 1;
								$(this).text('View Slide ' + $a);
							});
						}
					}
				});
			}
		}
	}

	IB_SP_LIST.on('click', '.propertie', function (event) {
		BODY.addClass('ib-sp-modal-opened');
		const SP_ID = $(this).data('id');
		loadSPDetail(SP_ID);
	});

	$(".js-ib-sp-list").on("click", ".gs-next-arrow, .gs-prev-arrow", function () {		
		// Open Registration popup after 3 property pictures are showed [force registration]
		if ("yes" === __flex_g_settings.anonymous) {
			if ((__flex_g_settings.hasOwnProperty("force_registration")) && (1 == __flex_g_settings.force_registration)) {
				countClickAnonymous++;

				if (countClickAnonymous >= 3) {
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

					jQuery(".ms-fub-register").removeClass("hidden");
					jQuery(".ms-footer-sm").addClass("hidden");

					if (jQuery('#follow_up_boss_valid_register').is(':checked')) {
						jQuery("#socialMediaRegister").removeClass("disabled");
					}else{
						jQuery("#socialMediaRegister").addClass("disabled");
					}
					countClickAnonymous = 0;
				}
			}
		}

		var $wSlider = $(this).parents('.ib-pislider');

		if (!$wSlider.hasClass('gs-builded')) {
			$wSlider.find('.ib-pifimg').removeClass('ib-pifimg');
			$wSlider.find('.gs-container-navs').remove();
			$wSlider.greatSlider({
				type: 'fade',
				nav: true,
				bullets: false,
				autoHeight: false,
				lazyLoad: true,
				startPosition: 2,
				layout: {
					arrowDefaultStyles: false
				},
				onLoadedItem: function (item, index, response) {
					if ("success" != response) {
						setTimeout(function () {
							item.attr("src", "https://www.idxboost.com/i/default_thumbnail.jpg");
						}, 2000);
					}
				}
			});
		}
	});

	$(".js-ib-sp-list").on("click", ".gs-next-arrow", function () {
		if ("yes" === __flex_g_settings.anonymous) {
			if ((__flex_g_settings.hasOwnProperty("force_registration")) && (1 == __flex_g_settings.force_registration)) {
				countClickAnonymous++;

				if (countClickAnonymous >= 3) {
					$("#modal_login").addClass("active_modal").find('[data-tab]').removeClass('active');
					$("#modal_login").addClass("active_modal").find('[data-tab]:eq(1)').addClass('active');
					$("#modal_login").find(".item_tab").removeClass("active");
					$("#tabRegister").addClass("active");
					$("#modal_login #msRst").empty().html($("#mstextRst").html());
					$("button.close-modal").addClass("ib-close-mproperty");
					$(".overlay_modal").css("background-color", "rgba(0,0,0,0.8);");
					$("#modal_login h2").html($("#modal_login").find('[data-tab]:eq(1)').data("text-force"));

					jQuery(".ms-fub-register").removeClass("hidden");
					jQuery(".ms-footer-sm").addClass("hidden");

					if (jQuery('#follow_up_boss_valid_register').is(':checked')) {
						jQuery("#socialMediaRegister").removeClass("disabled");
					}else{
						jQuery("#socialMediaRegister").addClass("disabled");
					}
					countClickAnonymous = 0;
				}
			}
		}

		var $wSlider = $(this).parents('.ib-pislider');

		if (!$wSlider.hasClass('gs-builded')) {
			$wSlider.find('.ib-pifimg').removeClass('ib-pifimg');
			$wSlider.find('.gs-container-navs').remove();
			$wSlider.greatSlider({
				type: 'fade',
				nav: true,
				bullets: false,
				autoHeight: false,
				lazyLoad: true,
				startPosition: 2,
				layout: {
					arrowDefaultStyles: false
				},
				onLoadedItem: function (item, index, response) {
					if ("success" != response) {
						setTimeout(function () {
							item.attr("src", "https://www.idxboost.com/i/default_thumbnail.jpg");
						}, 2000);
					}
				}
			});
		}
	});

	/**
	 * Add or remove tags on registration form.
	 *
	 * @param {String} action The action to do, add or remove tag.
	 *
	 * @returns {undefined}
	 */
	function handleTagsOnRegistrationForm(action, tags) {
		if (!IB_MODAL_REGISTER_FORM_TAGS) return false;

		if (action === 'add') {
			IB_MODAL_REGISTER_FORM_TAGS.value = tags;
		} else {
			IB_MODAL_REGISTER_FORM_TAGS.value = '';
		}

	}
	
	if (IB_MODAL_REGISTER_CLOSE_BTN) {
		IB_MODAL_REGISTER_CLOSE_BTN.addEventListener('click', () => {
			if (!document.body.classList.contains('ib-sp-modal-opened')) return false;
			handleTagsOnRegistrationForm('remove')
		});
	}

})(jQuery);
