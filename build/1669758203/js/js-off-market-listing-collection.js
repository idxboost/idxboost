var view_options,sort_options,FILTER_PAGE_URL,FILTER_PAGE_CURRENT,myLazyLoad,arraytest,arrayother,baths_slider,beds_slider,sqft_slider,lotsize_slider,price_sale_slider,price_rent_slider,year_built_slider,flex_filter_sort,flex_pagination,flex_search_rental_switch,flex_waterfront_switch,flex_parking_switch,flex_autocomplete,flex_autocomplete_inner,IB_IS_REGULAR_FILTER_PAGE=!0,textprueba="",inifil_default=4,idxboost_filter_countacti=!1,idxboostcondition="",ib_event_mobile=(!function(t){var e;t(function(){e=t(".flex-idx-filter-form"),FILTER_PAGE_URL=t("#flex_idx_sort").data("permalink"),FILTER_PAGE_CURRENT=t("#flex_idx_sort").data("currpage"),e.length&&e.each(function(){var e=t(this).find("input");e.length&&e.on("change",function(){t(this).parent().serialize()})})})}(jQuery),!0),search_params=flex_idx_filter_params.params,baths_slider_values=_.pluck(search_params.baths_range,"value"),beds_slider_values=_.pluck(search_params.beds_range,"value"),sqft_slider_values=_.pluck(search_params.living_size_range,"value"),lotsize_slider_values=_.pluck(search_params.lot_size_range,"value"),price_rent_slider_values=_.pluck(search_params.price_rent_range,"value"),price_sale_slider_values=_.pluck(search_params.price_sale_range,"value"),year_built_slider_values=_.pluck(search_params.year_built_range,"value"),property_type_values=_.pluck(search_params.property_types,"value"),flex_ui_loaded=!1,$cuerpo=jQuery("body"),$ventana=jQuery(window),arraytest_pryueba="",currentfiltemid="",xDown=null,yDown=null;!function(m){m(function(){m("#filter-save-search").on("click",function(){var e,t=m(this).data("count");"yes"===__flex_g_settings.anonymous?(m("#modal_login").addClass("active_modal").find("[data-tab]").removeClass("active"),m("#modal_login").addClass("active_modal").find("[data-tab]:eq(1)").addClass("active"),m("#modal_login").find(".item_tab").removeClass("active"),m("#tabRegister").addClass("active"),m("button.close-modal").addClass("ib-close-mproperty"),m(".overlay_modal").css("background-color","rgba(0,0,0,0.8);"),m("#modal_login h2").html(m("#modal_login").find("[data-tab]:eq(1)").data("text-force")),e=m(".header-tab a[data-tab='tabRegister']").attr("data-text"),m("#modal_login .modal_cm .content_md .heder_md .ms-title-modal").html(e)):"no"===__flex_g_settings.anonymous&&500<t?sweetAlert(word_translate.oops,word_translate.you_cannot_save_search_with_more_than_500_properties,"error"):(C(m("#modal_save_search")),setTimeout(function(){m("#modal_properties_send").find(".close").click()},2e3))}),m("body").on("touchstart",".slider-generator .propertie",function(e){e.stopPropagation(),xDown=e.originalEvent.touches[0].clientX,yDown=e.originalEvent.touches[0].clientY}),m("body").on("touchmove",".slider-generator .propertie",function(e){var t,a;xDown&&yDown&&(t=e.originalEvent.touches[0].clientX,a=e.originalEvent.touches[0].clientY,t=xDown-t,a=yDown-a,Math.abs(t)>Math.abs(a)&&(e.preventDefault(),(0<t?m(this).find(".next"):m(this).find(".prev")).click()),yDown=xDown=null)}),m("#result-search").scroll(function(){new LazyLoad({callback_error:function(e){m(e).attr("src","https://idxboost.com/i/default_thumbnail.jpg").removeClass("error").addClass("loaded"),m(e).attr("data-origin","https://idxboost.com/i/default_thumbnail.jpg")}})});var i,s,l,o=m("#mini-filters"),r=(o.length&&o.find("h4").on("click",function(){m(this).parents("li").toggleClass("expanded").siblings().removeClass("expanded")}),m("#filters"));r.length&&(i=m("#all-filters"),s=m("#wrap-filters"),r.on("click","button",function(){m("#mini-filters .price").addClass("expanded");var e=m(this).parent(),t=e.attr("class").split(" ")[0],a=o.find("li."+t);!a.length&&"all"!==t||(e.toggleClass("active").siblings().removeClass("active"),"all"===t?(i.hasClass("visible")?i.hasClass("individual")&&i.hasClass("visible")?i.removeClass("individual"):!i.hasClass("individual")&&i.hasClass("visible")&&i.removeClass("visible"):i.addClass("visible"),s.width()<=959&&m("html").toggleClass("fixed"),s.width()<=640?i.css({top:s.outerHeight()+s.position().top+"px",left:"0px",height:"calc(100vh - "+(s.outerHeight()+r.find("li.save").outerHeight())+"px)"}):640<s.width()&&s.width()<=959?i.hasClass("neighborhood")?(i.removeAttr("style"),console.log("Widt all filter: "+i.width()+" | position left clicked: "+e.position().left+" | Li clicked widht: "+e.width()),i.css({top:s.outerHeight()+"px",right:"0",left:"auto",transform:"none"})):i.css({left:"0px",top:s.outerHeight()+"px",height:"calc(100vh - "+(s.outerHeight()+l.outerHeight())+"px)"}):(i.removeAttr("style"),i.css("top",s.outerHeight()+"px"))):(m("html").hasClass("fixed")&&m("html").removeClass("fixed"),e.hasClass("active")?(a.addClass("visible").siblings().removeClass("visible"),i.hasClass("individual")||(i.addClass("individual"),i.css("height","auto")),i.hasClass("visible")||i.addClass("visible"),i.css({top:s.outerHeight()+"px",left:e.position().left+e.outerWidth()/2-150+"px"})):(i.removeClass("visible"),a.removeClass("visible"),e.removeClass("active"),setTimeout(function(){i.removeClass("individual")},1e3*Number(i.css("transition-duration").replace("s",""))))))}),(l=m("#apply-filters")).length&&l.on("click",function(){r.find(".all button").trigger("click")}),m(document).on("mouseup",function(e){!i.hasClass("visible")||s.is(e.target)||0!==s.has(e.target).length||r.find(".active button").trigger("click")}),r.find(".mini-search, .save").on("click",function(){i.hasClass("visible")&&r.find(".active button").trigger("click")}))});var e,t,a=m("body"),s=m(window),l=(m("html, body"),s.on("load",function(){a.removeClass("loading")}),m(".filter-views"));function o(e){var t,a;e?l.find("ul").length||(e=l.find("option:selected").val(),l.find("option").each(function(){m(this).replaceWith('<li class="'+m(this).val()+'">'+m(this).text()+"</li>")}),(t=l.find("select")).replaceWith("<ul>"+t.html()+"</ul>"),l.find("."+e).addClass("active"),l.removeClass(e)):l.find("select").length||(t=l.find(".active").index(),e=l.find(".active").attr("class").split(" ")[0],l.find("li").each(function(){m(this).replaceWith('<option value="'+m(this).attr("class").split(" ")[0]+'">'+m(this).text()+"</option>")}),(a=l.find("ul")).replaceWith("<select>"+a.html()+"</select>"),l.find("option").eq(t).prop("selected",!0).siblings().prop("selected",!1),l.addClass(e))}l.length&&(e=m(".wrap-result"),l.on("change","select",function(){switch(console.log(l),m(this).find("option:selected").val()){case"grid":l.removeClass("list map").addClass("grid"),e.removeClass("view-list view-map").addClass("view-grid"),a.removeClass("view-list view-map"),m("#idx_view").val("grid");break;case"list":l.removeClass("grid map").addClass("list"),e.removeClass("view-grid view-map").addClass("view-list"),a.addClass("view-list").removeClass("view-map"),m("#idx_view").val("list");break;case"map":l.removeClass("list grid").addClass("map"),e.removeClass("view-list view-grid").addClass("view-map"),a.removeClass("view-list").addClass("view-map"),m("#idx_view").val("map"),setTimeout(function(){var e=d.getCenter(),t=d.getZoom();if(google.maps.event.trigger(d,"resize"),!1===v){for(var a=new google.maps.LatLngBounds,i=0,s=c.length;i<s;i++)a.extend(c[i].position);d.fitBounds(a)}else d.setCenter(e),d.setZoom(t)},100)}new LazyLoad({callback_error:function(e){m(e).attr("src","https://idxboost.com/i/default_thumbnail.jpg").removeClass("error").addClass("loaded"),m(e).attr("data-origin","https://idxboost.com/i/default_thumbnail.jpg")}})}),l.on("click","li",function(){switch(currentfiltemid=m(this).parent("ul").parent("li").attr("filtemid"),m(this).addClass("active").siblings().removeClass("active"),m(this).attr("class").split(" ")[0]){case"grid":m(".idxboost-content-filter-"+currentfiltemid+" ").find(e).removeClass("view-list view-map").addClass("view-grid"),a.removeClass("view-list view-map");break;case"list":m(".idxboost-content-filter-"+currentfiltemid+" ").find(e).removeClass("view-grid view-map").addClass("view-list"),a.addClass("view-list").removeClass("view-map");break;case"map":m(".idxboost-content-filter-"+currentfiltemid+" ").find(e).removeClass("view-list view-grid").addClass("view-map"),a.removeClass("view-list").addClass("view-map")}new LazyLoad({callback_error:function(e){m(e).attr("src","https://idxboost.com/i/default_thumbnail.jpg").removeClass("error").addClass("loaded"),m(e).attr("data-origin","https://idxboost.com/i/default_thumbnail.jpg")}})}),t=m("#wrap-list-result"),768<=s.width()&&o(!0),s.on("resize",function(){var e=s.width();768<=e?o(!0):e<768&&o(!1)}));var r=m("#result-search");r.length&&(r=m("#apply-filters")).length&&r.on("click",function(){$theFilters.find(".all button").trigger("click")});m("#neighborhood").length&&1280<=s.width()&&m("#neighborhood").perfectScrollbar({suppressScrollX:!0,minScrollbarLength:"42"});var n,d,c,f,p,u,h,v,g=m("#neighborhood-menu"),r=(g.length&&g.on("click","li",function(){g.toggleClass("active"),m(this).addClass("active").siblings().removeClass("active")}),m("#map-actions")),b=(r.length&&r.on("click","button",function(){t.toggleClass("closed"),m(this).addClass("hide").siblings().removeClass("hide"),setTimeout(function(){google.maps.event.trigger(d,"resize"),setTimeout(function(){google.maps.event.trigger(d,"resize")},200)},100)}),700<=g.width()&&setTimeout(function(){var e,t,a,i,s,l,o=g.find("li"),r=o.length;r&&(e=0,o.each(function(){e+=m(this).outerWidth()}),t=e+Number(o.eq(0).css("margin-right").replace("px",""))*(r-1),a=g.find("ul"),i=Number(g.find(".gwr").width()),t<g.width()?(g.find("button").addClass("hide"),65<=Math.floor(100*t/i)&&a.addClass("flex")):(a.css("width",t+"px"),s=g.find(".next-item"),l=g.find(".prev-item"),s.on("click",function(){var e=o.eq(r-1);a.css("margin-left","-"+(i-e.position().left+e.width())+"px"),m(this).addClass("hide"),l.removeClass("hide")}),l.on("click",function(){a.css("margin-left","0"),m(this).addClass("hide"),s.removeClass("hide")})))},0),y(),s.resize(function(){y()}),m(".map-actions button")),r=(void 0!==b&&b.on("click",function(){b.removeClass("no-show"),m(this).addClass("no-show"),m("#wrap-list-result").toggleClass("hidden-results")}),m(".show-modal")),x=(void 0!==r&&r.on("click",function(){var e=m(this).attr("data-modal"),t=(m(this).attr("data-position"),m("#"+e).find(".lazy-img").attr("data-src"));void 0!==t&&m("#"+e).find(".lazy-img").attr("src",t).removeAttr("data-src"),C(e)}),m(".modal_cm"),m("html"));function C(e,t){var a=m("#"+e);a.hasClass("active_modal")?m(".overlay_modal").removeClass("active_modal"):(a.addClass("active_modal"),0==t?x.addClass("modal_fmobile"):x.addClass("modal_mobile")),w(e)}function w(e,t){var a,i=0==t?(a=m("#"+e).find(".close-btn"),"modal_fmobile"):(a=m("#"+e).find(".close"),"modal_mobile");a.click(function(){a.closest(".active_modal").removeClass("active_modal"),x.removeClass(i)}),m("#"+e).find(".overlay_modal_closer").click(function(){m("#"+e).removeClass("active_modal"),x.removeClass("modal_mobile")})}function y(){var e,t=m("#md-title");void 0!==t&&(e=m("#md-body").width(),t.css({width:e+"px"}))}function C(e){e.hasClass("active_modal")?m(".overlay_modal").removeClass("active_modal"):(e.addClass("active_modal"),e.find("form").find("input").eq(0).focus(),m("html").addClass("modal_mobile")),w(e)}function w(e){var t=e.find(".close");t.click(function(){t.closest(".active_modal").removeClass("active_modal"),m("html").removeClass("modal_mobile")})}function k(e){e.stopPropagation(),e.preventDefault(),d.setZoom(d.getZoom()+1)}function L(e){e.stopPropagation(),e.preventDefault(),d.setZoom(d.getZoom()-1)}function z(){(p=document.createElement("div")).classList.add("flex-map-controls-ct"),(u=document.createElement("div")).classList.add("flex-map-zoomIn"),p.appendChild(u),(h=document.createElement("div")).classList.add("flex-map-zoomOut"),p.appendChild(h),google.maps.event.addDomListener(u,"click",k),google.maps.event.addDomListener(h,"click",L),d.controls[google.maps.ControlPosition.TOP_RIGHT].push(p)}function j(e){var c,p,u=parseInt(e,10);0<u||(u=0),!1!==flex_ui_loaded&&0!=idxboost_filter_countacti&&0!=ib_event_mobile&&(c=m(".flex-idx-filter-form:eq(0)").attr("filtemid"),(e=m(".flex-idx-filter-form-listing")).attr("class"),p=".idxboost-content-filter-"+c+" #nav-results",e.length&&(e=e.serialize(),"undefined"!=typeof ajax_request_filter&&ajax_request_filter.abort(),ajax_request_filter=m.ajax({url:flex_idx_filter_params.ajaxUrl,type:"POST",data:e,dataType:"json",success:function(e){"yes"===__flex_g_settings.anonymous&&(t={search_url:location.href,search_count:e.counter,name:e.title,search_query:e.condition},localStorage.setItem("IB_SAVE_FILTER_PAYLOAD",JSON.stringify(t)));for(var t=e.items,a=[],i=(e.pagination,0),s=t.length;i<s;i++){var l=e.items[i],o="",o=("1"==l.is_rental&&(o="/"+word_translate.month),a.push('<li data-geocode="'+l.lat+":"+l.lng+'" data-class-id="'+l.class_id+'" data-mls="'+l.mls_num+'" data-address="'+l.address+'" class="propertie">'),l.hasOwnProperty("status")?"5"==l.status?a.push('<div class="flex-property-new-listing">'+word_translate.rented+"</div>"):"2"==l.status&&a.push('<div class="flex-property-new-listing">'+word_translate.sold+"</div>"):"yes"===l.recently_listed&&a.push('<div class="flex-property-new-listing">'+word_translate.new_listing+"</div>"),a.push('<h2 title="'+l.address+'">'+l.address+"</h2>"),a.push('<ul class="features">'),a.push('<li class="address">'+l.address+"</li>"),a.push('<li class="price">$'+_.formatPrice(l.listing_price)+o+"</li>"),word_translate.bed),o=1<l.bedrooms?word_translate.beds:word_translate.bed,o=(a.push('<li class="beds">'+l.bedrooms+" <span>"+o+" </span></li>"),word_translate.bath),o=1<l.full_bathrooms?word_translate.baths:word_translate.bath,o=(0<l.half_bath?a.push('<li class="baths">'+l.full_bathrooms+".5 <span>"+o+" </span></li>"):a.push('<li class="baths">'+l.full_bathrooms+" <span>"+o+" </span></li>"),a.push('<li class="living-size"> '+_.formatPrice(l.sqft)+" "+word_translate.sqft+"</li>"),a.push('<li class="price-sf"><span>$'+l.price_sqft+" </span>/ "+word_translate.sqft+"</li>"),""!==l.development?a.push('<li class="development"><span>'+l.development+"</span></li>"):""!==l.complex?a.push('<li class="development"><span>'+l.complex+"</span></li>"):a.push('<li class="development"><span>'+l.subdivision+"</span></li>"),a.push("</ul>"),"");null!=l.gallery&&""!=l.gallery&&l.gallery.length<=1&&(o="no-zoom"),a.push('<div class="wrap-slider '+o+'">'),a.push("<ul>");for(var r=0,n=l.gallery.length;r<n;r++)a.push(r<=0?'<li class="flex-slider-current"><img class="flex-lazy-image" data-original="'+l.gallery[r]+'"></li>':'<li class="flex-slider-item-hidden"><img class="flex-lazy-image" data-original="'+l.gallery[r]+'"></li>');a.push("</ul>"),1<l.gallery.length&&(a.push('<div class="prev flex-slider-prev" aria-label="Prev" style="cursor:pointer"><span class="clidxboost-icon-arrow-select"></span></div>'),a.push('<div class="next flex-slider-next" aria-label="Next" style="cursor:pointer"><span class="clidxboost-icon-arrow-select"></span></div>')),l.hasOwnProperty("status")||(l.is_favorite?a.push('<button class="clidxboost-btn-check flex-favorite-btn" aria-label="Remove Favorite"><span class="clidxboost-icon-check active"></span></button>'):a.push('<button class="clidxboost-btn-check flex-favorite-btn" aria-label="Save Favorite"><span class="clidxboost-icon-check"></span></button>')),a.push("</div>"),a.push('<a href="'+flex_idx_filter_params.siteUrl+"/off-market-listing/"+l.property_slug+'" class="view-detail">'+l.full_address+"</a>"),a.push('<a class="view-map-detail" data-geocode="'+l.lat+":"+l.lng+'">View Map</a>'),a.push("</li>")}m(".idx-off-market-result-search").html(a.join("")).ready(function(){idxboostTypeIcon()}),m(p).html([].join("")),m(".flex-loading-ct").fadeIn();var d;e.hasOwnProperty("only_count")&&!0===e.only_count&&(d=(d=(d=(t=m("#flex-idx-filter-heading_"+c)).data("heading")).replace(/\{\{count\}\}/,_.formatPrice(e.counter))).replace(/\{\{rental\}\}/,1==e.info.rental_type?" For Rent ":" For Sale "),t.find("h4").html(d)),m("#search_count").val(e.counter),idxboostcondition=e.condition,void 0!==f&&f.isOpen()&&f.close(),m("#wrap-list-result").show(),m("#paginator-cnt").show(),jQuery("#form-save .list-check .flex-save-type-options").removeAttr("disabled"),m(".wrap-result").hasClass("view-map")&&m("#wrap-list-result").scrollTop(0),m("html, body").animate({scrollTop:u},0),myLazyLoad.update(),m("#wrap-result").find(".wrap-slider > ul li:first").each(function(){m(this).addClass("flex-slider-current")}),inifil_default=5}})))}(n=jQuery).extend(!0,n.ui.slider.prototype,{pips:function(e){options={first:"number",last:"number",rest:"pip"},n.extend(options,e),this.element.addClass("ui-slider-pips").find(".ui-slider-pip").remove();var t=this.options.max-this.options.min;for(i=0;i<=t;i++){var a=n('<span class="ui-slider-pip"><span class="ui-slider-line"></span><span class="ui-slider-number">'+i+"</span></span>");0==i?(a.addClass("ui-slider-pip-first"),"number"==options.first&&a.addClass("ui-slider-pip-number"),0==options.first&&a.addClass("ui-slider-pip-hide")):t==i?(a.addClass("ui-slider-pip-last"),"number"==options.last&&a.addClass("ui-slider-pip-number"),0==options.last&&a.addClass("ui-slider-pip-hide")):("number"==options.rest&&a.addClass("ui-slider-pip-number"),0==options.rest&&a.addClass("ui-slider-pip-hide")),"horizontal"==this.options.orientation?a.css({left:100/t*i+"%"}):a.css({top:100/t*i+"%"}),this.element.append(a)}}}),m(function(){m("#wrap-list-result").on("scroll",function(){myLazyLoad.update()}),m("#result-search, .result-search").on("click",".view-detail",function(){var e=m(this).parent("li").data("mls");loadPropertyInModal(e)}),m(".property_type_checkbox").change(function(e){var t=[],a=[];m(".property_type_checkbox:checked").each(function(){t.push(m(this).val())}),-1!=t.indexOf("2")&&a.push(word_translate.homes),-1!=t.indexOf("1")&&a.push(word_translate.condominiums),-1!=t.indexOf("tw")&&a.push(word_translate.townhouses),-1!=t.indexOf("mf")&&a.push(word_translate.multi_family),4!=a.length&&0<t.length?m("#text-type").text(a.join(", ")):m("#text-type").text(word_translate.any_type)}),m("#result-search, .result-search").on("click",".flex-favorite-btn",function(e){e.stopPropagation(),e.preventDefault();var t,a,i,s=m(this);"yes"===__flex_g_settings.anonymous?(m("#modal_login").addClass("active_modal").find("[data-tab]").removeClass("active"),m("#modal_login").addClass("active_modal").find("[data-tab]:eq(1)").addClass("active"),m("#modal_login").find(".item_tab").removeClass("active"),m("#tabRegister").addClass("active"),m("button.close-modal").addClass("ib-close-mproperty"),m(".overlay_modal").css("background-color","rgba(0,0,0,0.8);"),m("#modal_login h2").html(m("#modal_login").find("[data-tab]:eq(1)").data("text-force")),e=m(".header-tab a[data-tab='tabRegister']").attr("data-text"),m("#modal_login .modal_cm .content_md .heder_md .ms-title-modal").html(e)):(e=m(this).parents(".propertie").data("class-id"),t=m(this).parents(".propertie").data("mls"),a=m(this).parents(".propertie").data("address"),m(this).find(".clidxboost-icon-check").hasClass("active")?(m(this).find(".clidxboost-icon-check").removeClass("active"),i=m(this).attr("data-alert-token"),m.ajax({url:flex_idx_filter_params.ajaxUrl,method:"POST",data:{action:"flex_favorite",class_id:e,mls_num:t,type_action:"remove",token_alert:i},dataType:"json",success:function(e){m(s).attr("data-alert-token","")}})):(m(this).find(".clidxboost-icon-check").addClass("active"),m.ajax({url:flex_idx_filter_params.ajaxUrl,method:"POST",data:{action:"flex_favorite",class_id:e,mls_num:t,subject:a,search_url:window.location.href,type_action:"add"},dataType:"json",success:function(e){m(s).attr("data-alert-token",e.token_alert)}})))})}),null!==document.getElementById("code-map")&&(v=!(c=[]),view_options=m(".filter-views li"),(sort_options=m(".flex_idx_sort")).on("change",function(){currentfiltemid=m(this).attr("filtemid");m("#filter-views li.active:eq(0)").html();var e=m(this).val();m(".market_order").val(e),m(".market_page").val(1),j()}),google.maps.event.addDomListener(window,"load",function(){myLazyLoad=new LazyLoad({elements_selector:".flex-lazy-image",callback_load:function(){},callback_error:function(e){m(e).attr("src","https://idxboost.com/i/default_thumbnail.jpg").removeClass("error").addClass("loaded"),m(e).attr("data-origin","https://idxboost.com/i/default_thumbnail.jpg")}}),d=new google.maps.Map(document.getElementById("code-map"),{center:new google.maps.LatLng(25.76168,-80.19179),mapTypeId:google.maps.MapTypeId.ROADMAP,zoom:16,disableDoubleClickZoom:!0,scrollwheel:!1,panControl:!1,streetViewControl:!1,disableDefaultUI:!0,clickableIcons:!1,gestureHandling:"1"==__flex_g_settings.is_mobile?"greedy":"cooperative"}),google.maps.event.addListenerOnce(d,"tilesloaded",z),idxboost_filter_countacti=ib_event_mobile=flex_ui_loaded=!0,j()}),m(function(){m("#filter-views").on("click","li",function(){m(this).hasClass("map")?setTimeout(function(){var e=d.getCenter(),t=d.getZoom();if(google.maps.event.trigger(d,"resize"),!1===v){for(var a=new google.maps.LatLngBounds,i=0,s=c.length;i<s;i++)a.extend(c[i].position);d.fitBounds(a)}else d.setCenter(e),d.setZoom(t)},100):0,new LazyLoad({callback_error:function(e){m(e).attr("src","https://idxboost.com/i/default_thumbnail.jpg").removeClass("error").addClass("loaded"),m(e).attr("data-origin","https://idxboost.com/i/default_thumbnail.jpg")}})}),(flex_pagination=m(".nav-results")).length&&flex_pagination.on("click","a",function(e){e.preventDefault();e=m(this).data("page"),currentfiltemid=m(this).parent("li").parent("ul").parent("nav").attr("filtemid"),"nextn"!=m(this).attr("id")&&"lastp"!=m(this).attr("id")&&"firstp"!=m(this).attr("id")&&"prevn"!=m(this).attr("id")||(currentfiltemid=m(this).parent("nav").attr("filtemid")),m(".nav-results-"+currentfiltemid+" ul#principal-nav li").removeClass("active"),m(".nav-results-"+currentfiltemid+" ul#principal-nav #page_"+e).addClass("active"),m(".flex-idx-filter-form-"+currentfiltemid+" #idx_page").val(e),e=m(".clidxboost-sc-filters");j(e=e.length?+m(".clidxboost-sc-filters").offset().top-100:0)}),m("#result-search").on("mouseover",">li",function(e){if(m(this).hasClass("propertie")){var t=m(this).data("geocode");if(void 0!==t&&t.length)for(var a=0,i=c.length;a<i;a++)if(t==c[a].geocode){new google.maps.event.trigger(c[a],"click");break}}}),m("#result-search").on("mouseleave",">li",function(e){void 0!==f&&f.isOpen()&&f.close()}),m("#wrap-list-result").on("ps-y-reach-end",_.debounce(function(){filter_metadata.pagination.has_next_page,filter_metadata.pagination.current_page_number;m("#filter-views").find(".map:eq(0)").hasClass("active")},800))}),"undefined"!=typeof search_metadata&&(_.pluck(search_metadata.baths_range,"value"),_.pluck(search_metadata.beds_range,"value"),_.pluck(search_metadata.living_size_range,"value"),_.pluck(search_metadata.lot_size_range,"value"),_.pluck(search_metadata.year_built_range,"value"),_.pluck(search_metadata.price_sale_range,"value"),_.pluck(search_metadata.price_rent_range,"value"),m(function(){m(document).on("click","#modal_login .close-modal",function(e){e.preventDefault(),m(".ib-pbtnclose").click()}),m(".overlay_modal_closer").click(function(){event.preventDefault(),m(".ib-pbtnclose").click()})}),m("#flex-idx-filter-form"),m(function(){view_options.length&&view_options.on("click",function(){currentfiltemid=m(this).attr("filtemid"),m(this).hasClass("active")||(m(this).html().toLowerCase(),sort_options.val())}),flex_ui_loaded=!0})))}(jQuery),function(a){a(function(){void 0===myLazyLoad&&(myLazyLoad=new LazyLoad({elements_selector:".flex-lazy-image",callback_load:function(){},callback_error:function(e){a(e).attr("src","https://idxboost.com/i/default_thumbnail.jpg").removeClass("error").addClass("loaded"),a(e).attr("data-origin","https://idxboost.com/i/default_thumbnail.jpg")}})),a(document).on("click",".flex-slider-prev",function(e){e.stopPropagation();var e=a(this).prev().find("li.flex-slider-current").index(),t=a(this).prev().find("li").length,e=0===e?t-1:e-1;a(this).prev().find("li").removeClass("flex-slider-current"),a(this).prev().find("li").addClass("flex-slider-item-hidden"),a(this).prev().find("li").eq(e).removeClass("flex-slider-item-hidden").addClass("flex-slider-current"),myLazyLoad.update()}),a(document).on("click",".flex-slider-next",function(e){e.stopPropagation();e=a(this).prev().prev().find("li.flex-slider-current").index();a(this).prev().prev().find("li").length-1<=e?e=0:e+=1,a(this).prev().prev().find("li").removeClass("flex-slider-current"),a(this).prev().prev().find("li").addClass("flex-slider-item-hidden"),a(this).prev().prev().find("li").eq(e).removeClass("flex-slider-item-hidden").addClass("flex-slider-current"),myLazyLoad.update()})})}(jQuery);