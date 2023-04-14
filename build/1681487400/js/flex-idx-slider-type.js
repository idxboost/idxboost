var response_ajax_idx = [];
var html_recent_sale=[],html_exclusive_listing=[];

function genMultiSlider(element){
	var $multiSlider = $(element);
	if($multiSlider.length) {
		$multiSlider.greatSlider({
			type: 'swipe',
			nav: true,
			navSpeed: 500,
			lazyLoad: true,
			bullets: false,
			items: 1,
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
	        items: 4,
	        slideBy: 4,
	      }
	    },
	    onStepStart: function(){
	      $(element).find(".flex-slider-current img").each(function() {
	      	if(!$(this).hasClass(".loaded")){
	      		var dataImage = $(this).attr('data-original');
	      		$(this).attr("data-was-processed","true").attr("src",dataImage).addClass("initial loaded");
	      	}
	      });
	    }
		});
	}
}

function idxboostTypeIcon() {
  if (__flex_g_settings["params"]["view_icon_type"] == '1') {
    $('.clidxboost-btn-check').addClass('clidxboost-icon-star');
    $('.chk_save').addClass('clidxboost-icon-star');
  } else if (__flex_g_settings["params"]["view_icon_type"] == '2') {
    $('.clidxboost-btn-check').addClass('clidxboost-icon-square');
    $('.chk_save').addClass('clidxboost-icon-square');
  } else if (__flex_g_settings["params"]["view_icon_type"] == '0') {
    $('.clidxboost-btn-check').addClass('clidxboost-icon-heart');
    $('.chk_save').addClass('clidxboost-icon-heart');
  } else {
    $('.clidxboost-btn-check').addClass('clidxboost-icon-heart');
    $('.chk_save').addClass('clidxboost-icon-heart');
  }
}

function get_data_info(){
idx_ajax_param_slider["type"].forEach(function(item_request){
	$.ajax({
		url: idx_param_slider.ajaxUrl,
		method: "POST",
		data: {
			action: "idxboost_get_data_slider",
			type: item_request,
            limit: idx_ajax_param_slider["limit"]
		},
		dataType: "json",
		success: function(response) {
			
			if (response.type=="recent-sale"){
				response.data.items.forEach(function(item){
					html_recent_sale.push(idx_slider_html(item,'recent'));
				});

				if (html_recent_sale.length>0){
					var $developmentSliderExclusive = $(".slider-recent-sale");
					$developmentSliderExclusive.html(html_recent_sale.join(' ')).ready(function(){ $('.ib-inventory-building').show(); });

					genMultiSlider('.slider-recent-sale');
					$('.slider-recent-sale').addClass('clidxboost-properties-slider');
					myLazyLoad.update();


				}

			}else if(response.type=="exclusive-listing"){
				response.data.items.forEach(function(item){
					html_exclusive_listing.push(idx_slider_html(item,'exclusve'));
				});	
				

				if (html_exclusive_listing.length>0){
					var $developmentSliderRecent = $(".slider-exclusive-listing");
					$developmentSliderRecent.html(html_exclusive_listing.join(' ')).ready(function(){ $('.ib-inventory-building').show(); idxboostTypeIcon(); });

					genMultiSlider('.slider-exclusive-listing');
					$('.slider-exclusive-listing').addClass('clidxboost-properties-slider');
					myLazyLoad.update();

				}
			}

			response_ajax_idx=response;
			myLazyLoad.update();
		}
	});		
});
}

function idx_slider_html(info_item,type){
	var html_response=[];
	var slug_post=idx_param_slider.propertyDetailPermalink+'/'+info_item.slug;

	idx_param_slider.propertyDetailPermalink+'/'+info_item.slug
          html_response.push('<ul class="result-search slider-generator">');
            html_response.push('<li class="propertie" data-id="'+info_item.mls_num+'" data-mls="'+info_item.mls_num+'" data-counter="0">');
              html_response.push('<h2 title="'+info_item.address_short+' '+info_item.address_large+'">'+info_item.address_short+'</h2>');
              html_response.push('<ul class="features">');
                html_response.push('<li class="address">'+info_item.address_large+'</li>');
                html_response.push('<li class="price">$'+_.formatPrice(info_item.price)+'</li>');
                html_response.push('<li class="pr down">2.05%</li>');
                html_response.push('<li class="beds">'+info_item.bed+'  <span>'+word_translate.beds+' </span></li>');
                html_response.push('<li class="baths">'+info_item.bath+' <span>'+word_translate.baths+' </span></li>');
                html_response.push('<li class="living-size"> <span>'+info_item.living_size_m2+'</span>'+word_translate.sqft+' <span>(452 m²)</span></li>');
                html_response.push('<li class="price-sf"><span>$'+info_item.price_sqft_m2+' </span>/ '+word_translate.sqft+'<span>($244 m²)</span></li>');
                html_response.push('<li class="build-year"><span>Built </span>2015</li>');
                html_response.push('<li class="development"><span></span></li>');
                //html_response.push('<li class="ms-logo-board"><img src="https://idxboost-spw-assets.idxboost.us/logos/fmls.png"></li>');
              html_response.push('</ul>');
              html_response.push('<div class="wrap-slider">');
            html_response.push('<ul>');

              info_item.gallery.forEach(function(gallery,index_gallery){
                if (index_gallery==0){
                  html_response.push('<li class="flex-slider-current"><img class="flex-lazy-image" data-original="'+gallery+'"></li>');
                }else{
                  html_response.push('<li class="flex-slider-item-hidden"><img class="flex-lazy-image" data-original="'+gallery+'"></li>');
                }				
              });
                html_response.push('</ul>');

                if (info_item.gallery.length>1){
	                html_response.push('<button class="prev flex-slider-prev" aria-label="Prev"><span class="clidxboost-icon-arrow-select"></span></button>');
	                html_response.push('<button class="next flex-slider-next" aria-label="Next"><span class="clidxboost-icon-arrow-select"></span></button>');
                }
                if (info_item.is_favorite==1){
                	html_response.push('<button class="clidxboost-btn-check" aria-label="Remove Favorite"><span class="flex-favorite-btn clidxboost-icon-check clidxboost-icon-check-list active" data-alert-token="'+info_item.token_alert+'"></span></button>');
                }else{
                	html_response.push('<button class="clidxboost-btn-check" aria-label="Save Favorite"><span class="flex-favorite-btn clidxboost-icon-check clidxboost-icon-check-list"></span></button>');
                }
              html_response.push('</div>');
              html_response.push('<a class="ib-view-detailt" href="'+slug_post+'" rel="nofollow">'+word_translate.details+'</a>');
            html_response.push('</li>');
          html_response.push('</ul>');
          return html_response.join('');
}

$(document).ready(function(event){
	$('.ib-inventory-building').hide();
            myLazyLoad = new LazyLoad({
                elements_selector: ".flex-lazy-image",
                callback_load: function() {},
                callback_error: function(element){
                  $(element).attr('src','https://idxboost.com/i/default_thumbnail.jpg').removeClass('error').addClass('loaded');
                  $(element).attr('data-origin','https://idxboost.com/i/default_thumbnail.jpg');
                }
            });

	get_data_info();

        $('.slider-exclusive-listing, .slider-recent-sale').on("click", ".flex-slider-next", function(event) {
            event.stopPropagation();
            var node = $(this).prev().prev().find('li.flex-slider-current');
            var index = node.index();
            var total = $(this).prev().prev().find('li').length;
            if (index >= (total - 1)) {
                index = 0;
            } else {
                index = index + 1;
            }
            // index = (index >= (total - 1)) ? 0 : (index + 1);
            $(this).prev().prev().find('li').removeClass('flex-slider-current');
            $(this).prev().prev().find('li').addClass('flex-slider-item-hidden');
            $(this).prev().prev().find('li').eq(index).removeClass('flex-slider-item-hidden').addClass('flex-slider-current');
            myLazyLoad.update();

            // Open Registration popup after 3 property pictures are showed [force registration]
            if ("yes" === __flex_g_settings.anonymous) {
                if ( (__flex_g_settings.hasOwnProperty("force_registration")) && (1 == __flex_g_settings.force_registration) ) {
                    countClickAnonymous++;
            
                    if (countClickAnonymous >= 3) {
                        $("#modal_login").addClass("active_modal")
                        .find('[data-tab]').removeClass('active');
                
                        $("#modal_login").addClass("active_modal")
                            .find('[data-tab]:eq(1)')
                            .addClass('active');
                        
                        $("#modal_login")
                            .find(".item_tab")
                            .removeClass("active");
                        
                        $("#tabRegister")
                            .addClass("active");
            
                        $("button.close-modal").addClass("ib-close-mproperty");
                        $(".overlay_modal").css("background-color", "rgba(0,0,0,0.8);");
            
                        $("#modal_login h2").html($("#modal_login").find('[data-tab]:eq(1)').data("text-force"));

                        /*Asigamos el texto personalizado*/
                        var titleText = $(".header-tab a[data-tab='tabRegister']").attr('data-text')
                        $("#modal_login .modal_cm .content_md .heder_md .ms-title-modal").html(titleText);
                        
                        countClickAnonymous = 0;
                    }
                }
            }
        });

        $('.slider-exclusive-listing, .slider-recent-sale').on("click", ".flex-favorite-btn", function(event) {
            event.stopPropagation();
            event.preventDefault();
            // active
            var buton_corazon = $(this);
            if (__flex_g_settings.anonymous === "yes") {
               // active_modal($('#modal_login'));

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


            } else {
                // ajax favorite
                var class_id = $(this).parents('.propertie').data('class-id');
                var mls_num = $(this).parents('.propertie').data("mls");
                var property_subject = $(this).parents('.propertie').data("address");

                if (!$(this).hasClass('active')) {
                    //console.log('mark as favorite');
                    $(this).addClass('active');
                    $.ajax({
                        url: idx_param_slider.ajaxUrl,
                        method: "POST",
                        data: {
                            action: "flex_favorite",
                            class_id: class_id,
                            mls_num: mls_num,
                            subject:property_subject,
                            search_url: window.location.href,
                            type_action: 'add'
                        },
                        dataType: "json",
                        success: function(data) {
                            $(buton_corazon).attr("data-alert-token", data.token_alert);
                        }
                    });
                } else {
                    $(buton_corazon).removeClass('active');
                    var token_alert = $(this).attr("data-alert-token");
                    $.ajax({
                        url: idx_param_slider.ajaxUrl,
                        method: "POST",
                        data: {
                            action: "flex_favorite",
                            class_id: class_id,
                            mls_num: mls_num,
                            type_action: 'remove',
                            token_alert: token_alert
                        },
                        dataType: "json",
                        success: function(data) {
                            $(buton_corazon).attr("data-alert-token", '');
                        }
                    });
                }
            }
        });

});

