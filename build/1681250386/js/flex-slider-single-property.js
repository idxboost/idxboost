!function(n){const p=n(window);n(document);const a=n("body");n(".js-ib-sp");const o=n(".js-ib-sp-total"),e=n("#ib-gsort-b"),l=n(".js-collection-single-property");n(".js-ib-sp-pagination");const c=window.location.origin+"/wp-content/plugins/idxboost/images/single-property/temp.png",g="https://www.idxboost.com/i/default_thumbnail.jpg";function listSingleProperties(r=1){var a=e.val();o.html(word_translate.loading_properties),n.ajax({url:ib_property_collection.ajaxlist,method:"POST",data:JSON.stringify({registration_key:ib_property_collection.rg,page:r,sort:a}),dataType:"json",success:function(a){let t=[];var s=[];if(a.status){var e=a.properties,i=(a.total,a.pagination);if(o.html(`
						${word_translate.showing} ${i.start} 
						${word_translate.to} ${i.end}
						${word_translate.of} 
						${_.formatPrice(i.count)} ${word_translate.properties}.
					`),e.forEach(function(s){let a=s.propertyPhotoGalleryCount;var e=a<2?"ib-piwoimgs":"";t.push(`
							<li class="ib-pitem" data-id="${s.propertyId}">
								<ul class="ib-piinfo">
									${"0"!=s.propertyPrice?`<li class="ib-piitem ib-piprice">$${_.formatPrice(s.propertyPrice)}</li>`:""}

									${"0"!=s.propertyBeds?`<li class="ib-piitem ib-pibeds">${s.propertyBeds}<span>&nbsp${word_translate.beds}</span></li>`:""}

									${"0"!=s.propertyBaths?`<li class="ib-piitem ib-pibaths">${s.propertyBaths}<span>&nbsp${word_translate.baths}</span></li>`:""}

									${"0"!=s.propertyLivingSize?`<li class="ib-piitem ib-pisqft">${s.propertyLivingSize}</li>`:""}

									${""!=s.websiteName?`<li class="ib-piitem ib-paddress">${s.websiteName}</li>`:""}
								</ul>

								<div class="ib-pislider gs-container-slider ${e}">
									${(()=>{if(a){var t=[];for(let a=0,e=s.propertyPhotoGallery.length;a<e;a++)a<1?t.push(`
															<img class="ib-pifimg sp-lazy" 
																onerror="this.src='${g}';"
																data-img="${s.propertyPhotoGallery[a]}" src="${c}"
																title="${s.websiteName}" alt="${s.websiteName}">
														`):t.push(`
															<img class="gs-lazy" 
																onerror="this.src='${g}';"
																data-lazy="${s.propertyPhotoGallery[a]}" src="${c}"
																title="${s.websiteName}" alt="${s.websiteName}">
														`);return t.join("")}return`
													<img class="ib-pifimg sp-lazy" 
														data-img="${g}" src="${c}"
														title="${s.websiteName}" alt="${s.websiteName}">
												`})()}
									<div class="gs-container-navs">
										<div class="gs-wrapper-arrows">
											<button class="gs-prev-arrow" tabindex="-1" aria-label="Previous image"></button>
											<button class="gs-next-arrow" tabindex="-1" aria-label="Next image"></button>
										</div>
									</div>
								</div>

								<a class="ib-pipermalink" href="#" aria-label="${s.websiteName}">
									<span>${s.websiteName}</span>
								</a>
							</li>
						`)}),1<i.pages){if(s.push(`
							<span class="ib-pagn">
								${word_translate.page} ${r} ${word_translate.of} ${i.pages}
							</span>
						`),1<r&&s.push(`
								<a class="ib-pagfirst ib-paggo" data-page="1" href="#">
									<span>${word_translate.first_page}</span>
								</a>
              `),i.prev&&s.push(`
								<a class="ib-pagprev ib-paggo" data-page="${r-1}" href="#">
									<span>${word_translate.previous_page}</span>
								</a>
							`),i.range.length){s.push('<div class="ib-paglinks">');for(let a=0,e=i.range.length;a<e;a++)r==i.range[a]?s.push(`
										<a class="ib-plitem ib-plitem-active" 
											data-page="${i.range[a]}" href="#">
											${i.range[a]}
										</a>
                  `):s.push(`
										<a class="ib-plitem" 
											data-page="${i.range[a]}" href="#">
											${i.range[a]}
										</a>
									`);s.push("</div>")}i.next&&s.push(`
								<a class="ib-pagnext ib-paggo" data-page="${r+1}" href="#">
									<span>${word_translate.next_page}</span>
								</a>
							`),r<i.pages&&s.push(`
								<a class="ib-paglast ib-paggo" data-page="${i.pages}" href="#">
									<span>${word_translate.last_page}</span>
								</a>
              `)}}l.html(t.join("")),function lazyLoad(){const e="sp-lazy";var a=n("."+e);a.length&&a.each(function(){let a=n(this);!function isElementVisibleInDocument(a,e){var t,s;return t=e.scrollTop(),e=t+e.height(),s=n(a).offset().top,s+n(a).height()>t&&s<e}(a,p)||a.attr("src",a.attr("data-img")).on("load",function(){a.removeAttr("data-img").removeClass(e)})})}()}})}listSingleProperties(),e.change(function(){listSingleProperties()}).trigger("change"),l.on("click",".gs-next-arrow",function(){var a=n(this).parents(".ib-pislider");a.hasClass("gs-builded")||(a.find(".ib-pifimg").removeClass("ib-pifimg"),a.find(".gs-container-navs").remove(),a.greatSlider({type:"fade",nav:!0,bullets:!1,autoHeight:!1,lazyLoad:!0,startPosition:2,layout:{arrowDefaultStyles:!1},onLoadedItem:function(a,e,t){"success"!=t&&setTimeout(function(){a.attr("src",g)},2e3)}}))});const t=n(".js-ib-sp-modals");n(".js-ib-sp-handlebars-template");const s=n(".js-ib-sp-modal-website");n(".js-ib-sp-modal-contact"),n(".js-ib-sp-modal-privacy"),n(".js-ib-sp-modal-accessibility");t.on("click",".ib-pbtnclose",function(){a.removeClass("ib-sp-modal-opened"),s.removeClass("ib-md-active"),t.empty()}),Handlebars.registerHelper("replaceDashBySpace",function(a){return a.replace("-"," ")}),Handlebars.registerHelper("ifequals",function(a,e,t){return a==e?t.fn(this):t.inverse(this)}),Handlebars.registerHelper("propertyHasFloorplans",function(a){return 1<a.length})}(jQuery);