var response_ajax_idx = [], ib_obj_filter=[];
var html_recent_sale=[],html_exclusive_listing=[];

function genMultiSliderOffMarketListing(element){
	var $multiSlider = $(element);
	if($multiSlider.length) {

    var initialItems = "";
		var dataItems = $multiSlider.parents("#featured-section").attr("data-item");

		if(dataItems !== ""){
			initialItems = dataItems * 1;
		}else{
			initialItems = 4;
    }
    
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
	        items: initialItems,
	        slideBy: initialItems,
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

function get_data_info_carrosell_offmarket_listing(){
		var ib_type_offmarket_listing=$('.ib_type_offmarket_listing').val();
		var ib_id_offmarket_listing=$('.ib_id_offmarket_listing').val();
        var ibdata=$('.flex-idx-off-market-listing-form').serialize();

	ib_obj_filter.forEach(function(itemFilter){

		$.ajax({
			url: idx_param_off_market_slider.ajaxUrl,
			method: "POST",
			data: ibdata,
			dataType: "json",
			success: function(response) {
				var html_listing=[];
				response.items.forEach(function(item){
					html_exclusive_listing.push(idx_off_market_listing_slider_html(item,'exclusve'));
					html_listing.push(idx_off_market_listing_slider_html(item,'exclusve'));
				});	

				console.log(html_listing);
				if (html_listing.length>0){
					$(itemFilter.obj_container).html(html_listing.join(' ')).ready(function(){ idxboostTypeIcon(); });

					genMultiSliderOffMarketListing(itemFilter.obj_container);
					$(itemFilter.obj_container).addClass('clidxboost-properties-slider');
					myLazyLoad.update();
				}
				
				response_ajax_idx=response;
				myLazyLoad.update();
			}
		});	
	});



}

function idx_off_market_listing_slider_html(info_item,type){
	var html_response=[];
	var slug_post=idx_param_off_market_slider.propertyDetailPermalink+'/'+info_item.property_slug;

          html_response.push('<ul class="result-search slider-generator">');
            html_response.push('<li class="propertie" data-address="'+info_item.address+'"  data-id="'+info_item.id+'" data-mls="'+info_item.id+'" data-counter="0">');
            if (info_item.status=='5') {
            	html_response.push('<div class="flex-property-new-listing">'+word_translate.rented+'!</div>');
            }else if (info_item.status=='2') {
            	html_response.push('<div class="flex-property-new-listing">'+word_translate.sold+'!</div>');
            }else if (info_item.status !='1') {
            	html_response.push('<div class="flex-property-new-listing">'+word_translate.pending+'!</div>');
            }else if (info_item.hasOwnProperty('recently_listed') && info_item.recently_listed ==='yes') {
            	html_response.push('<div class="flex-property-new-listing">'+word_translate.new_listing+'!</div>');
            }
              html_response.push('<h2 title="'+info_item.address+'"><span>'+info_item.address+'</span></h2>');
              html_response.push('<ul class="features">');
                html_response.push('<li class="address">'+info_item.address+'</li>');
                html_response.push('<li class="price">$'+_.formatPrice(info_item.listing_price)+'</li>');
                html_response.push('<li class="pr down">2.05%</li>');
                html_response.push('<li class="beds">'+info_item.bedrooms+'  <span>'+word_translate.beds+' </span></li>');
                html_response.push('<li class="baths">'+info_item.full_bathrooms+' <span>'+word_translate.baths+' </span></li>');
                html_response.push('<li class="living-size"> <span>'+info_item.sqft+'</span>'+word_translate.sqft+' <span>(452 m2)</span></li>');
                html_response.push('<li class="price-sf"><span>$'+info_item.price_sqft+' </span>/ '+word_translate.sqft+'<span>($244 m2)</span></li>');
                html_response.push('<li class="build-year"><span>Built </span>2015</li>');
                html_response.push('<li class="development"><span></span></li>');
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
	                html_response.push('<button class="prev flex-slider-prev"><span class="clidxboost-icon-arrow-select"></span></button>');
	                html_response.push('<button class="next flex-slider-next"><span class="clidxboost-icon-arrow-select"></span></button>');
                }
                /*
                if (info_item.status!='2') {
	                if (info_item.is_favorite==1){
	                	html_response.push('<button class="clidxboost-btn-check"><span class="flex-favorite-btn clidxboost-icon-check clidxboost-icon-check-list active" data-alert-token="'+info_item.token_alert+'"></span></button>');
	                }else{
	                	html_response.push('<button class="clidxboost-btn-check"><span class="flex-favorite-btn clidxboost-icon-check clidxboost-icon-check-list"></span></button>');
	                }
                }
                */

              html_response.push('</div>');
              html_response.push('<a class="ib-view-detailt" href="'+slug_post+'" rel="nofollow">'+word_translate.details+'</a>');
            html_response.push('</li>');
          html_response.push('</ul>');
          return html_response.join('');
}

$(document).ready(function(event){
            myLazyLoad = new LazyLoad({
                elements_selector: ".flex-lazy-image",
                callback_load: function() {},
                callback_error: function(element){
                  $(element).attr('src','https://idxboost.com/i/default_thumbnail.jpg').removeClass('error').addClass('loaded');
                  $(element).attr('data-origin','https://idxboost.com/i/default_thumbnail.jpg');
                }
            });

	$('.ib-off-market-listing-slider').each(function(){
		ib_obj_filter.push( { 'obj_container':'.ib-off-market-listing-slider-'+$(this).attr('data-filter')+' .ib-properties-slider', 'ib_type_offmarket_listing':$(this).find('.ib_type_offmarket_listing').val(), 'ib_id_offmarket_listing':$(this).find('.ib_id_offmarket_listing').val() } );
	});

	get_data_info_carrosell_offmarket_listing();

        $('.ib-properties-slider').on("click", ".flex-slider-next", function(event) {
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
                        countClickAnonymous = 0;
                    }
                }
            }
        });


});

