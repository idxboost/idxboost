var response_ajax_idx=[],ib_obj_filter=[],html_recent_sale=[],html_exclusive_listing=[];function genMultiSlider(e){var a,t,s,i,l=$(e);l.length&&(a="",s=l.parents(".featured-section").attr("data-item"),a=""!==(t=+l.parents(".featured-section").attr("auto-play"))&&0<t,t=""!==(t=l.parents(".featured-section").attr("speed-slider"))&&void 0!==t?+t:5e3,s=""!==s&&void 0!==s?+s:4,1==(i=""!==(i=+l.parents(".featured-section").attr("data-gallery"))&&void 0!==i&&0<i?1:0)?(s<2?s=2:4<s&&(s=4),l.parents(".featured-section").addClass("ms-colums-"+s)):l.greatSlider({type:"swipe",nav:!0,navSpeed:500,lazyLoad:!0,bullets:!1,items:1,autoplay:a,autoplaySpeed:t,layout:{bulletDefaultStyles:!1,wrapperBulletsClass:"clidxboost-gs-wrapper-bullets",arrowPrevContent:"Prev",arrowNextContent:"Next",arrowDefaultStyles:!1},breakPoints:{640:{items:2,slideBy:2,nav:!1,bullets:!0},991:{items:3,slideBy:3},1360:{items:s,slideBy:s}},onStepStart:function(){$(e).find(".flex-slider-current img").each(function(){var e;$(this).hasClass(".loaded")||(e=$(this).attr("data-original"),$(this).attr("data-was-processed","true").attr("src",e).addClass("initial loaded"))})},onInited:function(){var e=0,a=l.find(".gs-bullet");a.length&&a.each(function(){e+=1,$(this).text("View Slide "+e)})},onResized:function(){var e=0,a=l.find(".gs-bullet");a.length&&a.each(function(){e+=1,$(this).text("View Slide "+e)})}}))}function idxboostTypeIcon(){"1"==__flex_g_settings.params.view_icon_type?($(".clidxboost-btn-check").addClass("clidxboost-icon-star"),$(".chk_save").addClass("clidxboost-icon-star")):"2"==__flex_g_settings.params.view_icon_type?($(".clidxboost-btn-check").addClass("clidxboost-icon-square"),$(".chk_save").addClass("clidxboost-icon-square")):(__flex_g_settings.params.view_icon_type,$(".clidxboost-btn-check").addClass("clidxboost-icon-heart"),$(".chk_save").addClass("clidxboost-icon-heart"))}function get_data_info(){$(".ib_type_filter").val(),$(".ib_id_filter").val();ib_obj_filter.forEach(function(s){isNaN(s.limit)&&(s.limit=12),1==s.ib_type_filter?$.ajax({url:idx_param_slider.endpoint_v2,method:"POST",data:{type_filter:s.ib_type_filter,filter_id:s.ib_id_filter,registration_key:"undefined"!=typeof IB_AGENT_REGISTRATION_KEY?IB_AGENT_REGISTRATION_KEY:null,access_token:idx_param_slider.accessToken,version_endpoint:"old-services",limit:s.limit,flex_credentials:idx_param_slider.ib_lead_token},dataType:"json",success:function(e){var a=[],t=[];e.hasOwnProperty("board_info")&&(t=e.board_info),e.items.forEach(function(e){html_exclusive_listing.push(idx_slider_html(e,"exclusve",t)),a.push(idx_slider_html(e,"exclusve",t))}),0<a.length&&($(s.obj_container).html(a.join(" ")).ready(function(){idxboostTypeIcon()}),genMultiSlider(s.obj_container),$(s.obj_container).addClass("clidxboost-properties-slider"),myLazyLoad.update()),response_ajax_idx=e,myLazyLoad.update()}}):$.ajax({url:idx_param_slider.endpoint_v3,method:"POST",data:{type_filter:s.ib_type_filter,filter_id:s.ib_id_filter,registration_key:"undefined"!=typeof IB_AGENT_REGISTRATION_KEY?IB_AGENT_REGISTRATION_KEY:null,access_token:idx_param_slider.accessToken,version_endpoint:"new",limit:s.limit,flex_credentials:idx_param_slider.ib_lead_token},dataType:"json",success:function(e){var a=[],t=[];e.hasOwnProperty("board_info")&&(t=e.board_info),e.items.forEach(function(e){html_exclusive_listing.push(idx_slider_html(e,"exclusve",t)),a.push(idx_slider_html(e,"exclusve",t))}),0<a.length&&($(s.obj_container).html(a.join(" ")).ready(function(){idxboostTypeIcon()}),genMultiSlider(s.obj_container),$(s.obj_container).addClass("clidxboost-properties-slider"),myLazyLoad.update()),response_ajax_idx=e,myLazyLoad.update()}})})}function idx_slider_html(t,e,a){var s=[],i=idx_param_slider.propertyDetailPermalink+"/"+t.slug;return idx_param_slider.propertyDetailPermalink,t.slug,s.push('<ul class="result-search slider-generator">'),s.push('<li class="propertie" data-address="'+t.full_address+'"  data-id="'+t.mls_num+'" data-mls="'+t.mls_num+'" data-counter="0">'),!t.hasOwnProperty("recently_listed")||"yes"!==t.recently_listed&&""==t.min_ago_txt?1!=t.status&&s.push('<div class="flex-property-new-listing">'+t.status_name+"</div>"):0<t.min_ago&&""!=t.min_ago_txt?s.push('<div class="flex-property-new-listing">'+t.min_ago_txt+"</div>"):s.push('<div class="flex-property-new-listing">'+word_translate.new_listing+"</div>"),s.push('<h2 title="'+t.full_address+'" class="ms-property-address"><div class="ms-title-address -address-top">'+t.full_address_top+'</div><div class="ms-br-line">,</div><div class="ms-title-address -address-bottom">'+t.full_address_bottom+"</div></h2>"),s.push('<ul class="features">'),s.push('<li class="address">'+t.address_large+"</li>"),s.push('<li class="price">$'+_.formatPrice(t.price)+"</li>"),s.push('<li class="pr down">2.05%</li>'),s.push('<li class="beds">'+t.bed+"  <span>"+word_translate.beds+" </span></li>"),s.push('<li class="baths">'+t.bath+" <span>"+word_translate.baths+" </span></li>"),s.push('<li class="living-size"> <span>'+_.formatPrice(t.sqft)+"</span>"+word_translate.sqft+"</li>"),s.push('<li class="price-sf"><span>$'+t.price_sqft+" </span>/ "+word_translate.sqft+"</li>"),s.push('<li class="build-year"><span>Built </span>2015</li>'),s.push('<li class="development"><span></span></li>'),a.hasOwnProperty("board_logo_url")&&""!=a.board_logo_url&&null!=a.board_logo_url&&s.push('<li class="ms-logo-board"><img src="'+a.board_logo_url+'"></li>'),s.push("</ul>"),s.push('<div class="wrap-slider">'),s.push("<ul>"),t.gallery.forEach(function(e,a){s.push(0==a?'<li class="flex-slider-current"><img class="flex-lazy-image" data-original="'+e+'" alt="'+t.address_short+" "+t.address_large+'"></li>':'<li class="flex-slider-item-hidden"><img class="flex-lazy-image" data-original="'+e+'" alt="'+t.address_short+" "+t.address_large+'"></li>')}),s.push("</ul>"),1<t.gallery.length&&(s.push('<button class="prev flex-slider-prev" aria-label="Next" tab-index="-1"><span class="clidxboost-icon-arrow-select"></span></button>'),s.push('<button class="next flex-slider-next" aria-label="Prev" tab-index="-1"><span class="clidxboost-icon-arrow-select"></span></button>')),"2"!=t.status&&(1==t.is_favorite?"undefined"!=typeof IB_AGENT_REGISTRATION_KEY?s.push('<button class="clidxboost-btn-check" aria-label="Remove '+t.address_short+' of Favorites"><span class="flex-favorite-btn clidxboost-icon-check clidxboost-icon-check-list active" data-registration-key="'+IB_AGENT_REGISTRATION_KEY+'" data-alert-token="'+t.token_alert+'"></span></button>'):s.push('<button class="clidxboost-btn-check" aria-label="Remove '+t.address_short+' of Favorites"><span class="flex-favorite-btn clidxboost-icon-check clidxboost-icon-check-list active" data-alert-token="'+t.token_alert+'"></span></button>'):"undefined"!=typeof IB_AGENT_REGISTRATION_KEY?s.push('<button class="clidxboost-btn-check" aria-label="Add '+t.address_short+' to Favorite"><span class="flex-favorite-btn clidxboost-icon-check clidxboost-icon-check-list" data-registration-key="'+IB_AGENT_REGISTRATION_KEY+'"></span></button>'):s.push('<button class="clidxboost-btn-check" aria-label="Add '+t.address_short+' to Favorite"><span class="flex-favorite-btn clidxboost-icon-check clidxboost-icon-check-list"></span></button>')),s.push("</div>"),"undefined"!=typeof IB_AGENT_PERMALINK?s.push('<a class="ib-view-detailt" href="'+IB_AGENT_PERMALINK+"/property/"+t.slug+'" rel="nofollow">'+word_translate.details+" of "+t.address_short+"</a>"):s.push('<a class="ib-view-detailt" href="'+i+'" rel="nofollow">'+word_translate.details+" of "+t.address_short+"</a>"),s.push("</li>"),s.push("</ul>"),s.join("")}function ajax(){myLazyLoad=new LazyLoad({elements_selector:".flex-lazy-image",callback_load:function(){},callback_error:function(e){$(e).attr("src","https://idxboost.com/i/default_thumbnail.jpg").removeClass("error").addClass("loaded"),$(e).attr("data-origin","https://idxboost.com/i/default_thumbnail.jpg")}}),$(".ib-filter-slider").each(function(){ib_obj_filter.push({obj_container:".ib-filter-slider-"+$(this).attr("data-filter")+" .ib-properties-slider",ib_type_filter:$(this).find(".ib_type_filter").val(),ib_id_filter:$(this).find(".ib_id_filter").val(),limit:+$(this).attr("data-limit")})}),get_data_info(),$(".ib-properties-slider").on("click",".flex-slider-next",function(e){e.stopPropagation();var e=$(this).prev().prev().find("li.flex-slider-current").index();$(this).prev().prev().find("li").length-1<=e?e=0:e+=1,$(this).prev().prev().find("li").removeClass("flex-slider-current"),$(this).prev().prev().find("li").addClass("flex-slider-item-hidden"),$(this).prev().prev().find("li").eq(e).removeClass("flex-slider-item-hidden").addClass("flex-slider-current"),myLazyLoad.update(),"yes"===__flex_g_settings.anonymous&&__flex_g_settings.hasOwnProperty("force_registration")&&1==__flex_g_settings.force_registration&&3<=++countClickAnonymous&&($("#modal_login").addClass("active_modal").find("[data-tab]").removeClass("active"),$("#modal_login").addClass("active_modal").find("[data-tab]:eq(1)").addClass("active"),$("#modal_login").find(".item_tab").removeClass("active"),$("#tabRegister").addClass("active"),$("button.close-modal").addClass("ib-close-mproperty"),$(".overlay_modal").css("background-color","rgba(0,0,0,0.8);"),$("#modal_login h2").html($("#modal_login").find("[data-tab]:eq(1)").data("text-force")),e=$(".header-tab a[data-tab='tabRegister']").attr("data-text"),$("#modal_login .modal_cm .content_md .heder_md .ms-title-modal").html(e),countClickAnonymous=0)}),$(".ib-properties-slider").on("click",".flex-favorite-btn",function(e){e.stopPropagation(),e.preventDefault();var a,t,s,i=$(this);"yes"===__flex_g_settings.anonymous?($("#modal_login").addClass("active_modal").find("[data-tab]").removeClass("active"),$("#modal_login").addClass("active_modal").find("[data-tab]:eq(1)").addClass("active"),$("#modal_login").find(".item_tab").removeClass("active"),$("#tabRegister").addClass("active"),$("button.close-modal").addClass("ib-close-mproperty"),$(".overlay_modal").css("background-color","rgba(0,0,0,0.8);"),$("#modal_login h2").html($("#modal_login").find("[data-tab]:eq(1)").data("text-force")),e=$(".header-tab a[data-tab='tabRegister']").attr("data-text"),$("#modal_login .modal_cm .content_md .heder_md .ms-title-modal").html(e)):(e=$(this).parents(".propertie").data("class-id"),a=$(this).parents(".propertie").data("mls"),t=$(this).parents(".propertie").data("address"),$(this).hasClass("active")?($(i).removeClass("active"),s=$(this).attr("data-alert-token"),$.ajax({url:idx_param_slider.ajaxUrl,method:"POST",data:{action:"flex_favorite",class_id:e,mls_num:a,type_action:"remove",token_alert:s,registration_key:"undefined"!=typeof IB_AGENT_REGISTRATION_KEY?IB_AGENT_REGISTRATION_KEY:null},dataType:"json",success:function(e){$(i).attr("data-alert-token","")}})):($(this).addClass("active"),$.ajax({url:idx_param_slider.ajaxUrl,method:"POST",data:{action:"flex_favorite",class_id:e,mls_num:a,subject:t,search_url:window.location.href,type_action:"add",registration_key:"undefined"!=typeof IB_AGENT_REGISTRATION_KEY?IB_AGENT_REGISTRATION_KEY:null},dataType:"json",success:function(e){$(i).attr("data-alert-token",e.token_alert)}})))})}function loadAjax(){var e=$("#featured-section");e.length&&!e.hasClass("ajax-active")&&e.each(function(e){view($(this))&&(ajax(),$(this).addClass("ajax-active"))})}function view(e){var a,t=(a=$(window).scrollTop())+$(window).height();return a<(a=$(e).offset().top-150)+$(e).height()&&a<t}$(window).load(function(){loadAjax()}),$(window).scroll(function(){loadAjax()});