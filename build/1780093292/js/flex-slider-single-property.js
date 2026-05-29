(function($) {

	const WINDOW = $(window);
	const DOCUMENT = $(document);
	const BODY = $('body');

	const IB_SP = $('.js-ib-sp');
	const IB_SP_TOTAL = $('.js-ib-sp-total');
	const IB_SP_SORT_FILTER = $('#ib-gsort-b');
	const IB_SP_LIST = $('.js-collection-single-property');
	const IB_SP_PAGINATION = $('.js-ib-sp-pagination');

	// Fallback images
	const IB_SP_IMAGE_INIT = `${window.location.origin}/wp-content/plugins/idxboost/images/single-property/temp.png`;
	const IB_SP_IMAGE_ERROR = 'https://www.idxboost.com/i/default_thumbnail.jpg';	

	listSingleProperties();

	/**
	 * Sort properties
	 */
	IB_SP_SORT_FILTER.change(function () {
		listSingleProperties();
	}).trigger("change");

	function listSingleProperties(currentPage = 1) {
		let sortProperty = IB_SP_SORT_FILTER.val();
		IB_SP_TOTAL.html(word_translate.loading_properties);

		$.ajax({
			url: ib_property_collection.ajaxlist,
			method: "POST",
			data: JSON.stringify({ 
				"registration_key": ib_property_collection.rg, 
				"page": currentPage, 
				"sort": sortProperty,
				"group_id": ib_property_collection.groupId,
			}),
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
						${word_translate.showing} ${pagination.end === 0 ? '0' : pagination.start} 
						${word_translate.to} ${pagination.end}
						${word_translate.of} 
						${_.formatPrice(pagination.count)} ${word_translate.properties}.
					`);

					properties.forEach(function(item) {
						let totalPhotosProperty = item.propertyPhotoGalleryCount;
						let hideGreatSliderNav = totalPhotosProperty < 2 ? 'ib-piwoimgs' : '';
						
						listHTML.push(`
							<li class="ib-pitem" data-id="${item.propertyId}">
								<ul class="ib-piinfo">
									${
										(() => {
											if (item.propertyPrice != '0') {
												return `<li class="ib-piitem ib-piprice">$${_.formatPrice(item.propertyPrice)}</li>`
											} else {
												return ''
											}
										})()
									}

									${
										(() => {
											if (item.propertyBeds != '0') {
												return `<li class="ib-piitem ib-pibeds">${item.propertyBeds}<span>&nbsp${word_translate.beds}</span></li>`
											} else {
												return ''
											}
										})()
									}

									${
										(() => {
											if (item.propertyBaths != '0') {
												return `<li class="ib-piitem ib-pibaths">${item.propertyBaths}<span>&nbsp${word_translate.baths}</span></li>`
											} else {
												return ''
											}
										})()
									}

									${
										(() => {
											if (item.propertyLivingSize != '0') {
												return `<li class="ib-piitem ib-pisqft">${item.propertyLivingSize}</li>`
											} else {
												return ''
											}
										})()
									}

									${
										(() => {
											if (item.websiteName != '') {
												return `<li class="ib-piitem ib-paddress">${item.websiteName}</li>`
											} else {
												return ''
											}
										})()
									}
								</ul>

								<div class="ib-pislider gs-container-slider ${hideGreatSliderNav}">
									${
										(() => {
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

								<a role="button" class="ib-pipermalink" aria-label="${item.websiteName}">
									<span>${item.websiteName}</span>
								</a>
							</li>
						`);
					});

					if (pagination.pages > 1) {

						paginationHTML.push(`
							<span class="ib-pagn">
								${word_translate.page} ${currentPage} ${word_translate.of} ${pagination.pages}
							</span>
						`);
						
						if (currentPage > 1) {
							paginationHTML.push(`
								<a role="button" class="ib-pagfirst ib-paggo" data-page="1">
									<span>${word_translate.first_page}</span>
								</a>
              `);
						}
						
						if (pagination.prev) {
              paginationHTML.push(`
								<a role="button" class="ib-pagprev ib-paggo" data-page="${(currentPage - 1)}">
									<span>${word_translate.previous_page}</span>
								</a>
							`);
						}

						if (pagination.range.length) {
              paginationHTML.push(`<div class="ib-paglinks">`);

              for (let i = 0, l = pagination.range.length; i < l; i++) {
                if (currentPage == pagination.range[i]) {
									paginationHTML.push(`
										<a role="button" class="ib-plitem ib-plitem-active" 
											data-page="${pagination.range[i]}">
											${pagination.range[i]}
										</a>
                  `);
                } else {
									paginationHTML.push(`
										<a role="button" class="ib-plitem" 
											data-page="${pagination.range[i]}">
											${pagination.range[i]}
										</a>
									`);
                }
              }

              paginationHTML.push(`</div>`);
            }

						if (pagination.next) {
              paginationHTML.push(`
								<a role="button" class="ib-pagnext ib-paggo" data-page="${(currentPage + 1)}">
									<span>${word_translate.next_page}</span>
								</a>
							`);
						}
						
						if (currentPage < pagination.pages) {
              paginationHTML.push(`
								<a role="button" class="ib-paglast ib-paggo" data-page="${pagination.pages}">
									<span>${word_translate.last_page}</span>
								</a>
              `);
            }
						
					}
				}

				IB_SP_LIST.html(listHTML.join(''));
				//IB_SP_PAGINATION.html(paginationHTML.join(''));
				lazyLoad();
			}
		}); 
	}


	/**
	 * Lazy load for property's first image
	 */
	function lazyLoad() {
		const IB_SP_LAZY_CLASS = 'sp-lazy';
		let images = $(`.${IB_SP_LAZY_CLASS}`);

		if (images.length) {
			images.each(function() {
				let image = $(this);
				if (isElementVisibleInDocument(image, WINDOW)) {
					image.attr('src', image.attr('data-img')).on('load', function() {
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
	IB_SP_LIST.on('click', '.gs-next-arrow', function() {
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

	Handlebars.registerHelper('eq', function (a, b) {
		return a === b;
	});

	/**
	 * 
	 */
	function loadSPThemeSettings({fontFamily, buttons}) {
		setSPFontFamily(fontFamily);
		setSPButtonColors(buttons);
	}

	function setSPFontFamily(fontFamily) {
		WebFont.load({
			google: {
				families: [`${fontFamily}:400,500,600,700`]
			},

			/* 
				Called when each requested web font has finished loading.
				The fontFamily parameter is the name of the font family, 
				and fontDescription represents the style and weight of the font. 
			*/
			fontactive: function(fontFamily, fontDescription) {
				document.querySelectorAll(IB_SP_PAGE).forEach(item => {
					item.style.setProperty('--sps-font-family', fontFamily);
				});
    	},
		});
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


})(jQuery);
