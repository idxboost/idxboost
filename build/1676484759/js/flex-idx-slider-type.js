var response_ajax_idx=[],html_recent_sale=[],html_exclusive_listing=[];function genMultiSlider(a){var e=$(a);e.length&&e.greatSlider({type:"swipe",nav:!0,navSpeed:500,lazyLoad:!0,bullets:!1,items:1,layout:{bulletDefaultStyles:!1,wrapperBulletsClass:"clidxboost-gs-wrapper-bullets",arrowPrevContent:"Prev",arrowNextContent:"Next",arrowDefaultStyles:!1},breakPoints:{640:{items:2,slideBy:2,nav:!1,bullets:!0},991:{items:3,slideBy:3},1360:{items:4,slideBy:4}},onStepStart:function(){$(a).find(".flex-slider-current img").each(function(){var a;$(this).hasClass(".loaded")||(a=$(this).attr("data-original"),$(this).attr("data-was-processed","true").attr("src",a).addClass("initial loaded"))})}})}function idxboostTypeIcon(){"1"==__flex_g_settings.params.view_icon_type?($(".clidxboost-btn-check").addClass("clidxboost-icon-star"),$(".chk_save").addClass("clidxboost-icon-star")):"2"==__flex_g_settings.params.view_icon_type?($(".clidxboost-btn-check").addClass("clidxboost-icon-square"),$(".chk_save").addClass("clidxboost-icon-square")):(__flex_g_settings.params.view_icon_type,$(".clidxboost-btn-check").addClass("clidxboost-icon-heart"),$(".chk_save").addClass("clidxboost-icon-heart"))}function get_data_info(){idx_ajax_param_slider.type.forEach(function(a){$.ajax({url:idx_param_slider.ajaxUrl,method:"POST",data:{action:"idxboost_get_data_slider",type:a,limit:idx_ajax_param_slider.limit},dataType:"json",success:function(a){"recent-sale"==a.type?(a.data.items.forEach(function(a){html_recent_sale.push(idx_slider_html(a,"recent"))}),0<html_recent_sale.length&&($(".slider-recent-sale").html(html_recent_sale.join(" ")).ready(function(){$(".ib-inventory-building").show()}),genMultiSlider(".slider-recent-sale"),$(".slider-recent-sale").addClass("clidxboost-properties-slider"),myLazyLoad.update())):"exclusive-listing"==a.type&&(a.data.items.forEach(function(a){html_exclusive_listing.push(idx_slider_html(a,"exclusve"))}),0<html_exclusive_listing.length&&($(".slider-exclusive-listing").html(html_exclusive_listing.join(" ")).ready(function(){$(".ib-inventory-building").show(),idxboostTypeIcon()}),genMultiSlider(".slider-exclusive-listing"),$(".slider-exclusive-listing").addClass("clidxboost-properties-slider"),myLazyLoad.update())),response_ajax_idx=a,myLazyLoad.update()}})})}function idx_slider_html(a,e){var s=[],t=idx_param_slider.propertyDetailPermalink+"/"+a.slug;return idx_param_slider.propertyDetailPermalink,a.slug,s.push('<ul class="result-search slider-generator">'),s.push('<li class="propertie" data-id="'+a.mls_num+'" data-mls="'+a.mls_num+'" data-counter="0">'),s.push('<h2 title="'+a.address_short+" "+a.address_large+'">'+a.address_short+"</h2>"),s.push('<ul class="features">'),s.push('<li class="address">'+a.address_large+"</li>"),s.push('<li class="price">$'+_.formatPrice(a.price)+"</li>"),s.push('<li class="pr down">2.05%</li>'),s.push('<li class="beds">'+a.bed+"  <span>"+word_translate.beds+" </span></li>"),s.push('<li class="baths">'+a.bath+" <span>"+word_translate.baths+" </span></li>"),s.push('<li class="living-size"> <span>'+a.living_size_m2+"</span>"+word_translate.sqft+" <span>(452 m²)</span></li>"),s.push('<li class="price-sf"><span>$'+a.price_sqft_m2+" </span>/ "+word_translate.sqft+"<span>($244 m²)</span></li>"),s.push('<li class="build-year"><span>Built </span>2015</li>'),s.push('<li class="development"><span></span></li>'),s.push("</ul>"),s.push('<div class="wrap-slider">'),s.push("<ul>"),a.gallery.forEach(function(a,e){s.push(0==e?'<li class="flex-slider-current"><img class="flex-lazy-image" data-original="'+a+'"></li>':'<li class="flex-slider-item-hidden"><img class="flex-lazy-image" data-original="'+a+'"></li>')}),s.push("</ul>"),1<a.gallery.length&&(s.push('<button class="prev flex-slider-prev" aria-label="Prev"><span class="clidxboost-icon-arrow-select"></span></button>'),s.push('<button class="next flex-slider-next" aria-label="Next"><span class="clidxboost-icon-arrow-select"></span></button>')),1==a.is_favorite?s.push('<button class="clidxboost-btn-check" aria-label="Remove Favorite"><span class="flex-favorite-btn clidxboost-icon-check clidxboost-icon-check-list active" data-alert-token="'+a.token_alert+'"></span></button>'):s.push('<button class="clidxboost-btn-check" aria-label="Save Favorite"><span class="flex-favorite-btn clidxboost-icon-check clidxboost-icon-check-list"></span></button>'),s.push("</div>"),s.push('<a class="ib-view-detailt" href="'+t+'" rel="nofollow">'+word_translate.details+"</a>"),s.push("</li>"),s.push("</ul>"),s.join("")}$(document).ready(function(a){$(".ib-inventory-building").hide(),myLazyLoad=new LazyLoad({elements_selector:".flex-lazy-image",callback_load:function(){},callback_error:function(a){$(a).attr("src","https://idxboost.com/i/default_thumbnail.jpg").removeClass("error").addClass("loaded"),$(a).attr("data-origin","https://idxboost.com/i/default_thumbnail.jpg")}}),get_data_info(),$(".slider-exclusive-listing, .slider-recent-sale").on("click",".flex-slider-next",function(a){a.stopPropagation();var a=$(this).prev().prev().find("li.flex-slider-current").index();$(this).prev().prev().find("li").length-1<=a?a=0:a+=1,$(this).prev().prev().find("li").removeClass("flex-slider-current"),$(this).prev().prev().find("li").addClass("flex-slider-item-hidden"),$(this).prev().prev().find("li").eq(a).removeClass("flex-slider-item-hidden").addClass("flex-slider-current"),myLazyLoad.update(),"yes"===__flex_g_settings.anonymous&&__flex_g_settings.hasOwnProperty("force_registration")&&1==__flex_g_settings.force_registration&&3<=++countClickAnonymous&&($("#modal_login").addClass("active_modal").find("[data-tab]").removeClass("active"),$("#modal_login").addClass("active_modal").find("[data-tab]:eq(1)").addClass("active"),$("#modal_login").find(".item_tab").removeClass("active"),$("#tabRegister").addClass("active"),$("button.close-modal").addClass("ib-close-mproperty"),$(".overlay_modal").css("background-color","rgba(0,0,0,0.8);"),$("#modal_login h2").html($("#modal_login").find("[data-tab]:eq(1)").data("text-force")),a=$(".header-tab a[data-tab='tabRegister']").attr("data-text"),$("#modal_login .modal_cm .content_md .heder_md .ms-title-modal").html(a),countClickAnonymous=0)}),$(".slider-exclusive-listing, .slider-recent-sale").on("click",".flex-favorite-btn",function(a){a.stopPropagation(),a.preventDefault();var e,s,t,l=$(this);"yes"===__flex_g_settings.anonymous?($("#modal_login").addClass("active_modal").find("[data-tab]").removeClass("active"),$("#modal_login").addClass("active_modal").find("[data-tab]:eq(1)").addClass("active"),$("#modal_login").find(".item_tab").removeClass("active"),$("#tabRegister").addClass("active"),$("button.close-modal").addClass("ib-close-mproperty"),$(".overlay_modal").css("background-color","rgba(0,0,0,0.8);"),$("#modal_login h2").html($("#modal_login").find("[data-tab]:eq(1)").data("text-force")),a=$(".header-tab a[data-tab='tabRegister']").attr("data-text"),$("#modal_login .modal_cm .content_md .heder_md .ms-title-modal").html(a)):(a=$(this).parents(".propertie").data("class-id"),e=$(this).parents(".propertie").data("mls"),s=$(this).parents(".propertie").data("address"),$(this).hasClass("active")?($(l).removeClass("active"),t=$(this).attr("data-alert-token"),$.ajax({url:idx_param_slider.ajaxUrl,method:"POST",data:{action:"flex_favorite",class_id:a,mls_num:e,type_action:"remove",token_alert:t},dataType:"json",success:function(a){$(l).attr("data-alert-token","")}})):($(this).addClass("active"),$.ajax({url:idx_param_slider.ajaxUrl,method:"POST",data:{action:"flex_favorite",class_id:a,mls_num:e,subject:s,search_url:window.location.href,type_action:"add"},dataType:"json",success:function(a){$(l).attr("data-alert-token",a.token_alert)}})))})});