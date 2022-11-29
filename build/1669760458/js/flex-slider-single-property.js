!function(o){const n=o(window);o(document);const a=o("body");o(".js-ib-sp");const l=o(".js-ib-sp-total"),e=o("#ib-gsort-b"),c=o(".js-collection-single-property");o(".js-ib-sp-pagination");const g=window.location.origin+"/wp-content/plugins/idxboost/images/single-property/temp.png",b="https://www.idxboost.com/i/default_thumbnail.jpg";function s(p=1){var a=e.val();l.html(word_translate.loading_properties),o.ajax({url:ib_property_collection.ajaxlist,method:"POST",data:JSON.stringify({registration_key:ib_property_collection.rg,page:p,sort:a}),dataType:"json",success:function(a){let s=[];var t=[];if(a.status){var e=a.properties,i=(a.total,a.pagination);if(l.html(`
						${word_translate.showing} ${i.start} 
						${word_translate.to} ${i.end}
						${word_translate.of} 
						${_.formatPrice(i.count)} ${word_translate.properties}.
					`),e.forEach(function(t){let a=t.propertyPhotoGalleryCount;var e=a<2?"ib-piwoimgs":"";s.push(`
							<li class="ib-pitem" data-id="${t.propertyId}">
								<ul class="ib-piinfo">
									${"0"!=t.propertyPrice?`<li class="ib-piitem ib-piprice">$${_.formatPrice(t.propertyPrice)}</li>`:""}

									${"0"!=t.propertyBeds?`<li class="ib-piitem ib-pibeds">${t.propertyBeds}<span>&nbsp${word_translate.beds}</span></li>`:""}

									${"0"!=t.propertyBaths?`<li class="ib-piitem ib-pibaths">${t.propertyBaths}<span>&nbsp${word_translate.baths}</span></li>`:""}

									${"0"!=t.propertyLivingSize?`<li class="ib-piitem ib-pisqft">${t.propertyLivingSize}</li>`:""}

									${""!=t.websiteName?`<li class="ib-piitem ib-paddress">${t.websiteName}</li>`:""}
								</ul>

								<div class="ib-pislider gs-container-slider ${e}">
									${(()=>{if(a){var s=[];for(let a=0,e=t.propertyPhotoGallery.length;a<e;a++)a<1?s.push(`
															<img class="ib-pifimg sp-lazy" 
																onerror="this.src='${b}';"
																data-img="${t.propertyPhotoGallery[a]}" src="${g}"
																title="${t.websiteName}" alt="${t.websiteName}">
														`):s.push(`
															<img class="gs-lazy" 
																onerror="this.src='${b}';"
																data-lazy="${t.propertyPhotoGallery[a]}" src="${g}"
																title="${t.websiteName}" alt="${t.websiteName}">
														`);return s.join("")}return`
													<img class="ib-pifimg sp-lazy" 
														data-img="${b}" src="${g}"
														title="${t.websiteName}" alt="${t.websiteName}">
												`})()}
									<div class="gs-container-navs">
										<div class="gs-wrapper-arrows">
											<button class="gs-prev-arrow" tabindex="-1" aria-label="Previous image"></button>
											<button class="gs-next-arrow" tabindex="-1" aria-label="Next image"></button>
										</div>
									</div>
								</div>

								<a class="ib-pipermalink" href="#" aria-label="${t.websiteName}">
									<span>${t.websiteName}</span>
								</a>
							</li>
						`)}),1<i.pages){if(t.push(`
							<span class="ib-pagn">
								${word_translate.page} ${p} ${word_translate.of} ${i.pages}
							</span>
						`),1<p&&t.push(`
								<a class="ib-pagfirst ib-paggo" data-page="1" href="#">
									<span>${word_translate.first_page}</span>
								</a>
              `),i.prev&&t.push(`
								<a class="ib-pagprev ib-paggo" data-page="${p-1}" href="#">
									<span>${word_translate.previous_page}</span>
								</a>
							`),i.range.length){t.push('<div class="ib-paglinks">');for(let a=0,e=i.range.length;a<e;a++)p==i.range[a]?t.push(`
										<a class="ib-plitem ib-plitem-active" 
											data-page="${i.range[a]}" href="#">
											${i.range[a]}
										</a>
                  `):t.push(`
										<a class="ib-plitem" 
											data-page="${i.range[a]}" href="#">
											${i.range[a]}
										</a>
									`);t.push("</div>")}i.next&&t.push(`
								<a class="ib-pagnext ib-paggo" data-page="${p+1}" href="#">
									<span>${word_translate.next_page}</span>
								</a>
							`),p<i.pages&&t.push(`
								<a class="ib-paglast ib-paggo" data-page="${i.pages}" href="#">
									<span>${word_translate.last_page}</span>
								</a>
              `)}}c.html(s.join(""));{const r="sp-lazy";(a=o("."+r)).length&&a.each(function(){let a=o(this);var e,s,t,i;e=a,s=n,s=(t=s.scrollTop())+s.height(),(i=o(e).offset().top)+o(e).height()>t&&i<s&&a.attr("src",a.attr("data-img")).on("load",function(){a.removeAttr("data-img").removeClass(r)})})}}})}s(),e.change(function(){s()}).trigger("change"),c.on("click",".gs-next-arrow",function(){var a=o(this).parents(".ib-pislider");a.hasClass("gs-builded")||(a.find(".ib-pifimg").removeClass("ib-pifimg"),a.find(".gs-container-navs").remove(),a.greatSlider({type:"fade",nav:!0,bullets:!1,autoHeight:!1,lazyLoad:!0,startPosition:2,layout:{arrowDefaultStyles:!1},onLoadedItem:function(a,e,s){"success"!=s&&setTimeout(function(){a.attr("src",b)},2e3)}}))});const t=o(".js-ib-sp-modals");o(".js-ib-sp-handlebars-template");const i=o(".js-ib-sp-modal-website");o(".js-ib-sp-modal-contact"),o(".js-ib-sp-modal-privacy"),o(".js-ib-sp-modal-accessibility");t.on("click",".ib-pbtnclose",function(){a.removeClass("ib-sp-modal-opened"),i.removeClass("ib-md-active"),t.empty()}),Handlebars.registerHelper("replaceDashBySpace",function(a){return a.replace("-"," ")}),Handlebars.registerHelper("ifequals",function(a,e,s){return a==e?s.fn(this):s.inverse(this)}),Handlebars.registerHelper("propertyHasFloorplans",function(a){return 1<a.length})}(jQuery);