!function(g){const l=g(window);g(document);const f=g("body");g(".js-ib-sp");const c=g(".js-ib-sp-total"),s=g("#ib-gsort-b"),m=g(".js-ib-sp-list:eq(0)"),u=g(".js-ib-sp-pagination"),i=g(".js-ib-sp"),a=document.getElementById("formRegister_ib_tags");var b,e=document.querySelector("#modal_login .close-modal"),o=!1,t=0,y=__flex_g_settings.hasOwnProperty("signup_left_clicks")&&null!=__flex_g_settings.signup_left_clicks;const h=window.location.origin+"/wp-content/plugins/idxboost/images/single-property/temp.png",v="https://www.idxboost.com/i/default_thumbnail.jpg";let r="four",n="price-desc";function d(p=1){var e=s.val(),e=(c.html(word_translate.loading_properties),{registration_key:ib_property_collection.rg,page:p,sort:e});ib_property_collection.limit&&0!=parseInt(ib_property_collection.limit)&&(e.limit=parseInt(ib_property_collection.limit)),g.ajax({url:ib_property_collection.ajaxlist,method:"POST",data:JSON.stringify(e),dataType:"json",success:function(e){let n=[];var t,a,s,i,o,l=[];if(e.status){var r=e.properties,d=(e.total,e.pagination);if(c.html(`
						${word_translate.showing} ${d.start} 
						${word_translate.to} ${d.end}
						${word_translate.of} 
						${_.formatPrice(d.count)} ${word_translate.properties}.
					`),r.forEach(function(s){let e=s.propertyPhotoGalleryCount;var t,a,i,o,l,r=e<2?"ib-piwoimgs":"";"slider"==ib_property_collection.mode?(n.push('<ul class="result-search slider-generator slider-generator-sp">'),n.push('<li class="propertie"  data-id="'+s.propertyId+'" data-counter="0">'),t=s.websiteName||"",a=""!=s.propertyPrice?s.propertyPrice:"",i="0"!=s.propertyBeds?s.propertyBeds+"  <span>"+word_translate.beds+" </span>":"",o="0"!=s.propertyBaths?s.propertyBaths+"  <span>"+word_translate.baths+" </span>":"",l="0"!=s.propertyLivingSize?"<span>"+_.formatPrice(s.propertyLivingSize)+"</span>"+word_translate.sqft+"<span></span>":"",n.push('<h2 title="'+t+'">'+t+"</h2>"),n.push('<ul class="features">'),n.push('<li class="address">'+t+"</li>"),""!=s.propertyPrice&&n.push('<li class="price">'+a+"</li>"),n.push('<li class="pr down"></li>'),"0"!=s.propertyBeds&&n.push('<li class="beds">'+i+"</li>"),"0"!=s.propertyBaths&&n.push('<li class="baths">'+o+"</li>"),"0"!=s.propertyLivingSize&&n.push('<li class="living-size"> '+l+" </li>"),n.push('<li class="price-sf"> <span></span> </li>'),n.push('<li class="build-year"> <span></span> </li>'),n.push('<li class="development"> <span></span> </li>'),n.push("</ul>"),n.push('<div class="wrap-slider">'),n.push("<ul>"),s.propertyPhotoGallery.forEach(function(e,t){0==t?n.push('<li class="flex-slider-current"><img class="flex-lazy-image" data-original="'+e+'" alt="'+s.websiteName+'"></li>'):n.push('<li class="flex-slider-item-hidden"><img class="flex-lazy-image" data-original="'+e+'" alt="'+s.websiteName+'"></li>')}),n.push("</ul>"),1<s.propertyPhotoGallery.length&&(n.push('<button class="prev flex-slider-prev" aria-label="Next" tab-index="-1"><span class="clidxboost-icon-arrow-select"></span></button>'),n.push('<button class="next flex-slider-next" aria-label="Prev" tab-index="-1"><span class="clidxboost-icon-arrow-select"></span></button>')),n.push("</div>"),n.push("</li>"),n.push("</ul>")):n.push(`
								<li class="ib-pitem propertie" data-id="${s.propertyId}">
									<ul class="ib-piinfo">
										${""!=s.propertyPrice?`<li class="ib-piitem ib-piprice">${s.propertyPrice}</li>`:""}

										${"0"!=s.propertyBeds?`<li class="ib-piitem ib-pibeds">${s.propertyBeds}<span>&nbsp${word_translate.beds}</span></li>`:""}

										${"0"!=s.propertyBaths?`<li class="ib-piitem ib-pibaths">${s.propertyBaths}<span>&nbsp${word_translate.baths}</span></li>`:""}

										${"0"!=s.propertyLivingSize?`<li class="ib-piitem ib-pisqft">${_.formatPrice(s.propertyLivingSize)} ${word_translate.sqft}</li>`:""}

										${""!=s.websiteName?`<li class="ib-piitem ib-paddress">${s.websiteName}</li>`:""}
										
									</ul>

									<div class="ib-pislider gs-container-slider ${r}">
										${(()=>{if(e){var a=[];for(let e=0,t=s.propertyPhotoGallery.length;e<t;e++)e<1?a.push(`
																<img class="ib-pifimg sp-lazy" 
																	onerror="this.src='${v}';"
																	data-img="${s.propertyPhotoGallery[e]}" src="${h}"
																	title="${s.websiteName}" alt="${s.websiteName}">
															`):a.push(`
																<img class="gs-lazy" 
																	onerror="this.src='${v}';"
																	data-lazy="${s.propertyPhotoGallery[e]}" src="${h}"
																	title="${s.websiteName}" alt="${s.websiteName}">
															`);return a.join("")}return`
														<img class="ib-pifimg sp-lazy" 
															data-img="${v}" src="${h}"
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
							`)}),1<d.pages){if(l.push(`
							<span class="ib-pagn">
								${word_translate.page} ${p} ${word_translate.of} ${d.pages}
							</span>
						`),1<p&&l.push(`
								<a class="ib-pagfirst ib-paggo" data-page="1" href="#">
									<span>${word_translate.first_page}</span>
								</a>
              `),d.prev&&l.push(`
								<a class="ib-pagprev ib-paggo" data-page="${p-1}" href="#">
									<span>${word_translate.previous_page}</span>
								</a>
							`),d.range.length){l.push('<div class="ib-paglinks">');for(let e=0,t=d.range.length;e<t;e++)p==d.range[e]?l.push(`
										<a class="ib-plitem ib-plitem-active" 
											data-page="${d.range[e]}" href="#">
											${d.range[e]}
										</a>
                  `):l.push(`
										<a class="ib-plitem" 
											data-page="${d.range[e]}" href="#">
											${d.range[e]}
										</a>
									`);l.push("</div>")}d.next&&l.push(`
								<a class="ib-pagnext ib-paggo" data-page="${p+1}" href="#">
									<span>${word_translate.next_page}</span>
								</a>
							`),p<d.pages&&l.push(`
								<a class="ib-paglast ib-paggo" data-page="${d.pages}" href="#">
									<span>${word_translate.last_page}</span>
								</a>
              `)}}m.html(n.join("")),u.html(l.join("")),"slider"==ib_property_collection.mode&&(t=m,(a=g(t)).length&&(e="",r=a.parents(".featured-section").attr("data-item"),s=+a.parents(".featured-section").attr("auto-play"),i=a.parents(".featured-section").attr("speed-slider"),o=+a.parents(".featured-section").attr("data-gallery"),e=""!==s&&0<s,s=""!==i&&void 0!==i?+i:5e3,i=""!==r&&void 0!==r?+r:4,1==(o=""!==o&&void 0!==o&&0<o?1:0)?(i<2?i=2:4<i&&(i=4),a.parents(".featured-section").addClass("ms-colums-"+i)):a.greatSlider({type:"swipe",nav:!0,navSpeed:500,lazyLoad:!0,bullets:!1,items:1,autoplay:e,autoplaySpeed:s,layout:{bulletDefaultStyles:!1,wrapperBulletsClass:"clidxboost-gs-wrapper-bullets",arrowPrevContent:"Prev",arrowNextContent:"Next",arrowDefaultStyles:!1},breakPoints:{640:{items:2,slideBy:2,nav:!1,bullets:!0},991:{items:3,slideBy:3},1360:{items:i,slideBy:i}},onStepStart:function(){g(t).find(".flex-slider-current img").each(function(){var e;g(this).hasClass(".loaded")||(e=g(this).attr("data-original"),g(this).attr("data-was-processed","true").attr("src",e).addClass("initial loaded"))})},onInited:function(){var e=0,t=a.find(".gs-bullet");t.length&&t.each(function(){e+=1,g(this).text("View Slide "+e)})},onResized:function(){var e=0,t=a.find(".gs-bullet");t.length&&t.each(function(){e+=1,g(this).text("View Slide "+e)})}})),m.addClass("clidxboost-properties-slider")),w()}})}function w(){const o="sp-lazy";var e=g("."+o);e.length&&e.each(function(){let e=g(this);var t,a,s,i;t=e,a=l,a=(s=a.scrollTop())+a.height(),(i=g(t).offset().top)+g(t).height()>s&&i<a&&e.attr("src",e.attr("data-img")).on("load",function(){e.removeAttr("data-img").removeClass(o)})})}g.ajax({url:ib_property_collection.ajaxSetting,method:"POST",data:JSON.stringify({registration_key:ib_property_collection.rg,limit:ib_property_collection.limit}),dataType:"json",success:function(e,t,a){200==a.status&&(ib_property_collection.order=e.display_results,ib_property_collection.column=e.grid_column,isNaN(ib_property_collection.column)||("1"==ib_property_collection.column&&(r="one"),"2"==ib_property_collection.column&&(r="two"),"3"==ib_property_collection.column&&(r="three"),"4"==ib_property_collection.column&&(r="four"),"5"==ib_property_collection.column&&(r="five")),i.addClass("columns-"+r),["list_date-desc","price-asc","price-desc","sqft-asc","sqft-desc"].includes(ib_property_collection.order)&&(n=ib_property_collection.order),s.val(n),o=!0,d())}}),s.change(function(){0!=o&&d()}).trigger("change"),u.on("click","a",function(e){e.preventDefault(),g(this).hasClass("ib-plitem-active")||d(g(this).data("page"))}),l.on("scroll",function(){w()}),m.on("click",".gs-next-arrow",function(){var e=g(this).parents(".ib-pislider");e.hasClass("gs-builded")||(e.find(".ib-pifimg").removeClass("ib-pifimg"),e.find(".gs-container-navs").remove(),e.greatSlider({type:"fade",nav:!0,bullets:!1,autoHeight:!1,lazyLoad:!0,startPosition:2,layout:{arrowDefaultStyles:!1},onLoadedItem:function(e,t,a){"success"!=a&&setTimeout(function(){e.attr("src",v)},2e3)}}))});const C=g(".js-ib-sp-modals"),x=g(".js-ib-sp-handlebars-template"),p=g(".js-ib-sp-modal-website");g(".js-ib-sp-modal-contact"),g(".js-ib-sp-modal-privacy"),g(".js-ib-sp-modal-accessibility");const S=".js-ib-sps-page";function $(e){g.ajax({url:ib_property_collection.ajaxgetProperty,data:JSON.stringify({registration_key:ib_property_collection.rg,id:e}),method:"POST",dataType:"json",success:function(e){if(C.length&&x.length){var t,a,s,i,o=Handlebars.compile(x.html()),l=(C.html(o(e)),{fontFamily:o,buttons:n}=[e.stylesInput.themeSettings][0],o),r=("compass-sans-and-serif"==l?(document.querySelector(S).classList.add("CompassSansSerif"),l='"Compass Sans", Helvetica, Arial, sans-serif',document.querySelectorAll(S).forEach(e=>{e.style.setProperty("--sps-font-family",l)})):"'Compass Sans', Helvetica, Arial, sans-serif"==l?(l='"Compass Sans", Helvetica, Arial, sans-serif',document.querySelectorAll(S).forEach(e=>{e.style.setProperty("--sps-font-family",l)})):"'Compass Serif', Times, 'Times New Roman', serif"==l?(l='"Compass Serif", Times, "Times New Roman", serif',document.querySelectorAll(S).forEach(e=>{e.style.setProperty("--sps-font-family",l)})):"dinengschrift-and-open-sans"==l?(document.querySelector(S).classList.add("dinengschrift-and-open-sans"),l="Open Sans, sans-serif",document.querySelectorAll(S).forEach(e=>{e.style.setProperty("--sps-font-family",l)})):((o=document.createElement("script")).src="https://ajax.googleapis.com/ajax/libs/webfont/1.6.26/webfont.js",o.async=1,(d=document.getElementsByTagName("script")[0]).parentNode.insertBefore(o,d),setTimeout(()=>{WebFont.load({google:{families:[l+":400,500,600,700"]},fontactive:function(t,e){document.querySelectorAll(S).forEach(e=>{e.style.setProperty("--sps-font-family",t)})}})},1e3)),n);document.querySelectorAll(S).forEach(e=>{e.style.setProperty("--sps-button-text-color",r.color),e.style.setProperty("--sps-button-text-color-hover",r.hoverColor),e.style.setProperty("--sps-button-background-color",r.backgroundColor),e.style.setProperty("--sps-button-background-color-hover",r.backgroundHoverColor),e.style.setProperty("--sps-button-border-color",r.borderColor)});{o=g(".ib-sps-page .js-slider-home");o.length&&g.each(o,function(){g(this).greatSlider({type:"fade",nav:!1,lazyLoad:!0,bullets:!1,autoHeight:!1,autoplay:!0,autoplaySpeed:7e3})});const p=g(".sps-video-slider");if(p.length){let e=p.greatSlider({type:"swipe",nav:!1,lazyLoad:!0,bullets:!1,autoHeight:!1,autoplay:!0,autoplaySpeed:7e3,onInited:function(){p.parents("#sps-virtual").find(".sps-btn-next").click(function(){e.goTo("next")}),p.parents("#sps-virtual").find(".sps-btn-next").click(function(){e.goTo("prev")})}})}let i=0;const c=g("#sps-slider-video");c.length&&(c.find(".sps-item-video").each(function(){var e="video_item_"+(i+=1),t=g(this).attr("data-video"),e=(g(this).attr("id",e),t),a=g(this),e=e.toString(),{id:t,service:s}=getVideoId(e);"youtube"==s?a.append(`<img src="https://img.youtube.com/vi/${t}/0.jpg">`):"vimeo"==s?g.ajax({url:"https://vimeo.com/api/oembed.json?url=https://vimeo.com/"+t,async:!1,data:{format:"json",width:960},success:function(e){e.thumbnail_url&&a.append(`<img src="${e.thumbnail_url}">`)}}):-1!==e.indexOf("images")?a.append(`<img src="${e}">`):a.append(`<video autoplay="false" src="${e}" loop>`)}),o=1<i,c.greatSlider({type:"swipe",nav:o,navSpeed:500,lazyLoad:!0,bullets:!1,items:1,drag:!1,onInited:function(){c.find("iframe").each(function(){g(this).remove()}),c.find("video").each(function(){g(this)[0].pause(),g(this)[0].controls=!1}),c.find(".sps-play-video").each(function(){g(this).removeClass("hide")})},onStepStart:function(){c.find("video").each(function(){g(this)[0].pause(),g(this)[0].controls=!1,g(this)[0].currentTime=0}),c.find("iframe").each(function(){g(this).remove()}),c.find(".sps-play-video").each(function(){g(this).removeClass("hide")})},onStepEnd:function(){c.find("video").each(function(){g(this)[0].controls=!1}),c.find("iframe").each(function(){g(this).remove()}),c.find(".sps-play-video").each(function(){g(this).removeClass("hide")})}}));const m=g("#sps-slider-prop");if(m.length){const u=m.greatSlider({type:"swipe",nav:!1,navSpeed:500,lazyLoad:!0,bullets:!0,items:1,layout:{bulletDefaultStyles:!1,wrapperBulletsClass:"idx-gs-wrapper-bullets"},onInited:function(){let e=0,t=0,a,s,i="",o;m.find("img").each(function(){t+=1,a="View Slide "+t,s=g(this).attr("data-img"),i=""!==s&&void 0!==s?s:g(this).attr("src"),o=`background: url('${i}')`,m.find(`.gs-bullet:eq(${e})`).html(`<span style="${o}"></span>`),m.find(`.gs-bullet:eq(${e})`).attr("aria-label",a),e+=1}),m.parents("#sps-slider-wp").find(".sps-btn-next").click(function(){u.goTo("next")}),m.parents("#sps-slider-wp").find(".sps-btn-prev").click(function(){u.goTo("prev")}),setTimeout(function(){P()},300)},onResized:function(){setTimeout(function(){P()},300)}})}}(d=g(".js-ib-sp-contact-form")).length&&d.on("submit",function(e){e.preventDefault(),contactForm=g(this),g.ajax({url:ib_property_collection.ajaxUrl,type:"POST",data:contactForm.serialize(),success:function(e){e.success&&(contactForm.find('button[type="submit"]').html("Thank you!"),contactForm.find('button[type="submit"]').after('<span class="form-message">We will contact you shortly</span>'),contactForm.find(":input").prop("disabled",!0))}})});var n=g("#googleMap"),o=(n.length&&(o=n.attr("data-img"),t=n.attr("data-lat"),a=n.attr("data-lng"),n=parseInt(n.attr("data-zoom")),t={lat:parseFloat(t),lng:parseFloat(a)},a=new google.maps.Map(document.getElementById(o),{zoom:n,center:t,mapTypeControl:!0,fullscreenControl:!0}),new google.maps.Marker({position:t,map:a})),g(".sps-main-video"));o.length&&(o.html('<div id="player"></div>'),n=o.attr("data-img"),t=o.attr("data-title"),void 0!==n&&(a=n.toString(),{id:a,service:s}=getVideoId(a),"youtube"==s?f.append(`<script>var tag=document.createElement("script");tag.src="https://www.youtube.com/iframe_api";var player,firstScriptTag=document.getElementsByTagName("script")[0];function onYouTubeIframeAPIReady(){player=new YT.Player("player",{width:"100%",videoId:"${a}",host:"${window.location.protocol}//www.youtube.com",playerVars:{autoplay:1,playsinline:1,loop:1,rel:0,showinfo:0,origin:'${window.location.origin}'},events:{onReady:onPlayerReady,onStateChange:onPlayerStateChange}})}function onPlayerReady(e){e.target.mute(),e.target.playVideo()}function onPlayerStateChange(e){e.data==YT.PlayerState.ENDED&&(player.seekTo(0),player.playVideo())}function stopVideo(){player.stopVideo()}firstScriptTag.parentNode.insertBefore(tag,firstScriptTag);</script>`):"vimeo"==s?o.html(`<iframe allow="autoplay; encrypted-media" src="https://player.vimeo.com/video/${a}?autoplay=1&amp;muted=1&loop=1" frameborder="0" allowfullscreen title="${t}"></iframe>`):o.html(`<video class="video-layer" id="idx-video" src="${n}" title="${t}" tab-index="-1" preload="none" autoplay loop muted playsinline>`)),o.removeAttr("data-img")),void 0===Cookies.get("_ib_disabled_forcereg")&&(!0===y?(b=parseInt(Cookies.get("_ib_left_click_force_registration"),10)-1,Cookies.set("_ib_left_click_force_registration",b),parseInt(Cookies.get("_ib_left_click_force_registration"),10)<=0&&"yes"===__flex_g_settings.anonymous&&(k("add","Property Site, "+e.websiteName),g("#modal_login").addClass("active_modal").find("[data-tab]").removeClass("active"),g("#modal_login").addClass("active_modal").find("[data-tab]:eq(1)").addClass("active"),g("#modal_login").find(".item_tab").removeClass("active"),g("#tabRegister").addClass("active"),g("#modal_login #msRst").empty().html(g("#mstextRst").html()),g("button.close-modal").addClass("ib-close-mproperty"),g(".overlay_modal").css("background-color","rgba(0,0,0,0.8);"),g("#modal_login h2").html(g("#modal_login").find("[data-tab]:eq(1)").data("text-force")),i=g(".header-tab a[data-tab='tabRegister']").attr("data-text"),g("#modal_login .modal_cm .content_md .heder_md .ms-title-modal").html(i))):"yes"===__flex_g_settings.anonymous&&__flex_g_settings.hasOwnProperty("force_registration")&&1==__flex_g_settings.force_registration&&(console.info("Set IB TAG on modal force registration"),g("#modal_login").addClass("active_modal").find("[data-tab]").removeClass("active"),g("#modal_login").addClass("active_modal").find("[data-tab]:eq(1)").addClass("active"),g("#modal_login").find(".item_tab").removeClass("active"),g("#tabRegister").addClass("active"),g("#modal_login #msRst").empty().html(g("#mstextRst").html()),g("button.close-modal").addClass("ib-close-mproperty"),g(".overlay_modal").css("background-color","rgba(0,0,0,0.8);"),g("#modal_login h2").html(g("#modal_login").find("[data-tab]:eq(1)").data("text-force")),i=g(".header-tab a[data-tab='tabRegister']").attr("data-text"),g("#modal_login .modal_cm .content_md .heder_md .ms-title-modal").html(i)))}var d}})}function P(){var e=0,e=g("#sps-slider-wp .gs-container-items").outerHeight()/2;g("#sps-slider-wp .sps-wrap-action-btn").css({top:e}),g(window).on("resize",function(){var e=0,e=g("#sps-slider-wp .gs-container-items").outerHeight()/2;g("#sps-slider-wp .sps-wrap-action-btn").css({top:e})})}function k(e,t){a&&(a.value="add"===e?t:"")}m.on("click",".ib-pitem",function(e){g(e.target).hasClass("ib-pipermalink")&&(e.preventDefault(),f.addClass("ib-sp-modal-opened"),$(g(e.target).parent().data("id")))}),C.on("click",".ib-pbtnclose",function(){f.removeClass("ib-sp-modal-opened"),p.removeClass("ib-md-active"),C.empty()}),Handlebars.registerHelper("replaceDashBySpace",function(e){return e.replace("-"," ")}),Handlebars.registerHelper("ifequals",function(e,t,a){return e==t?a.fn(this):a.inverse(this)}),Handlebars.registerHelper("propertyHasFloorplans",function(e){return 1<e.length}),Handlebars.registerHelper("ifVisibility",function(e){return"true"==e||1==e}),Handlebars.registerHelper("ifCond",function(e,t,a){return e&&t?a.fn(this):a.inverse(this)}),Handlebars.registerHelper("ifCondOR",function(e,t,a){return e||t}),C.on("click",".sps-play-video",function(){var e=g(this).parents(".sps-item-video"),t=e.attr("data-video"),a=e.attr("data-title"),t=t.toString(),{id:t,service:s}=getVideoId(t);"youtube"==s?e.append(`
        <iframe id="ytIframe" allow="autoplay; encrypted-media" 
          src="https://www.youtube.com/embed/${t}?&autoplay=1&loop=1&rel=0&showinfo=0&enablejsapi=1&origin=${window.location.origin}&color=white&iv_load_policy=3&playlist=${t}" 
          frameborder="0" allowfullscreen title="${a}">
        </iframe>
      `).ready(function(){var e=document.createElement("script"),t=(e.type="text/javascript",e.src="https://www.youtube.com/iframe_api",g("head").append(e),document.getElementById("ytIframe"));window.onYouTubeIframeAPIReady=function(){new YT.Player(t,{events:{onStateChange:onPlayerStateChange}})},window.onPlayerStateChange=function(e){e.data!=YT.PlayerState.ENDED&&e.data!=YT.PlayerState.PAUSED||g("#slider-video .gs-item-active .ms-item-video").contents().find(".ytp-pause-overlay").remove()}}):"vimeo"==s?e.append(`
				<iframe allow="autoplay; encrypted-media" 
					src="https://player.vimeo.com/video/${t}?autoplay=1&amp;loop=1" 
					frameborder="0" allowfullscreen title="${a}">
				</iframe>
			`):(e.find("video")[0].play(),e.find("video")[0].controls=!0),g(this).addClass("hide")}),C.on("click",".sfm",function(){g(".js-ib-sp-modal-contact").addClass("ib-md-active")}),C.on("click",".ib-pbtnopen",function(){var e=g(this).data("permalink");window.open(e)}),g(document).on("click",".accordion-title",function(){var e=jQuery(this);e.hasClass("active")?(e.removeClass("active"),e.next().removeClass("active")):(e.addClass("active"),e.next().addClass("active"))}),g(document).on("click",".sp-show-modal",function(e){e.preventDefault();e=g(this).attr("data-modal");g(e).addClass("ib-md-active")}),g(document).on("click",".sps-modal-galery",function(e){e.preventDefault();var a,e=g(this).parents(".sps-sps-slider").attr("id"),t=g(this).parents(".sps-sl-item").index(),e="#"+e,s=0,i=g("#sps-modal-sp-slider").find("#sps-gen-slider");i.hasClass("gs-builded")||(g(e).find("img").each(function(){s++;var e=g(this).attr("data-bg"),t=g(this).attr("alt"),e='<img src="'+(""!==e&&void 0!==e?e:""!==(e=g(this).attr("data-img"))&&void 0!==e?e:g(this).attr("src"))+'">';a+=e=void 0!==t?'<div class="sps-gallery-img-wrapper">'+e+'<span class="alt-text">'+t+"</span></div>":e}),i.empty().html(a),e=t+1,t=1<s,i.greatSlider({type:"swipe",nav:t,lazyLoad:!0,bullets:!1,startPosition:e})),setTimeout(function(){g(".sps-modal-sp-slider").addClass("in")},300),g("body").addClass("sps-active-mds")}),g(document).on("click",".sps-modal-sp-slider .sps-close",function(e){e.preventDefault(),g("#sps-modal-sp-slider").find(".sps-wrap-slider").remove(),g("#sps-modal-sp-slider").append('<div class="sps-wrap-slider" id="sps-gen-slider"></div>'),g("body").removeClass("sps-active-mds"),g(".sps-modal-sp-slider").removeClass("in")}),m.on("click",".propertie",function(e){f.addClass("ib-sp-modal-opened"),$(g(this).data("id"))}),g(".js-ib-sp-list").on("click",".gs-next-arrow, .gs-prev-arrow",function(){"yes"===__flex_g_settings.anonymous&&__flex_g_settings.hasOwnProperty("force_registration")&&1==__flex_g_settings.force_registration&&3<=++t&&(g("#modal_login").addClass("active_modal").find("[data-tab]").removeClass("active"),g("#modal_login").addClass("active_modal").find("[data-tab]:eq(1)").addClass("active"),g("#modal_login").find(".item_tab").removeClass("active"),g("#tabRegister").addClass("active"),g("button.close-modal").addClass("ib-close-mproperty"),g(".overlay_modal").css("background-color","rgba(0,0,0,0.8);"),g("#modal_login h2").html(g("#modal_login").find("[data-tab]:eq(1)").data("text-force")),e=g(".header-tab a[data-tab='tabRegister']").attr("data-text"),g("#modal_login .modal_cm .content_md .heder_md .ms-title-modal").html(e),t=0);var e=g(this).parents(".ib-pislider");e.hasClass("gs-builded")||(e.find(".ib-pifimg").removeClass("ib-pifimg"),e.find(".gs-container-navs").remove(),e.greatSlider({type:"fade",nav:!0,bullets:!1,autoHeight:!1,lazyLoad:!0,startPosition:2,layout:{arrowDefaultStyles:!1},onLoadedItem:function(e,t,a){"success"!=a&&setTimeout(function(){e.attr("src","https://www.idxboost.com/i/default_thumbnail.jpg")},2e3)}}))}),g(".js-ib-sp-list").on("click",".gs-next-arrow",function(){"yes"===__flex_g_settings.anonymous&&__flex_g_settings.hasOwnProperty("force_registration")&&1==__flex_g_settings.force_registration&&3<=++t&&(g("#modal_login").addClass("active_modal").find("[data-tab]").removeClass("active"),g("#modal_login").addClass("active_modal").find("[data-tab]:eq(1)").addClass("active"),g("#modal_login").find(".item_tab").removeClass("active"),g("#tabRegister").addClass("active"),g("#modal_login #msRst").empty().html(g("#mstextRst").html()),g("button.close-modal").addClass("ib-close-mproperty"),g(".overlay_modal").css("background-color","rgba(0,0,0,0.8);"),g("#modal_login h2").html(g("#modal_login").find("[data-tab]:eq(1)").data("text-force")),t=0);var e=g(this).parents(".ib-pislider");e.hasClass("gs-builded")||(e.find(".ib-pifimg").removeClass("ib-pifimg"),e.find(".gs-container-navs").remove(),e.greatSlider({type:"fade",nav:!0,bullets:!1,autoHeight:!1,lazyLoad:!0,startPosition:2,layout:{arrowDefaultStyles:!1},onLoadedItem:function(e,t,a){"success"!=a&&setTimeout(function(){e.attr("src","https://www.idxboost.com/i/default_thumbnail.jpg")},2e3)}}))}),e&&e.addEventListener("click",()=>{if(!document.body.classList.contains("ib-sp-modal-opened"))return!1;k("remove")})}(jQuery);