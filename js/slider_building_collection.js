var response_ajax_idx = [], ib_obj_filter=[];
var html_recent_sale=[],html_exclusive_listing=[];

function genMultiSlider(element){
  var $multiSlider = $(element);
  if($multiSlider.length) {
    
    //RECUPERANDO LOS PARAMETROS
    var initialItems, autoPlaySpeed, autoPlay  = "";
    var dataItems = $multiSlider.parents("#featured-section").attr("data-item");
    var autoPlayStatus = ($multiSlider.parents("#featured-section").attr("auto-play")) * 1;
    var autoPlayspeed = $multiSlider.parents("#featured-section").attr("speed-slider");
    var styleFormat = ($multiSlider.parents("#featured-section").attr("data-gallery")) * 1; //PARAMETRO PARA EL FORMATO GRILLA O SLIDER

    //VALIDAMOS LA EXISTENCIA DE LOS PARAMETROS
    if(autoPlayStatus !== "" && autoPlayStatus !== undefined && autoPlayStatus > 0){
      autoPlay = true;
    }else{
      autoPlay = false;
    }

    if(autoPlayspeed !== "" && autoPlayspeed !== undefined){
      autoPlaySpeed = autoPlayspeed * 1;
    }else{
      autoPlaySpeed = 5000;
    }

    if(dataItems !== "" && dataItems !== undefined){
      initialItems = dataItems * 1;
    }else{
      initialItems = 4;
    }
    
    //CONSULTAMOS LA EXISTENCIA Y EL TIPO DE FORMATO "GRILLA/SLIDER"
    if(styleFormat !== "" && styleFormat !== undefined && styleFormat > 0){
      styleFormat = 1; //RECUPERAMOS EL PARAMETRO
    }else{
      styleFormat = 0;
    }

    //CONSULTAMOS EL FORMATO
    if(styleFormat == 1){
      //generamos las clases para el formato de columnas
      if(initialItems < 2){
        initialItems = 2;
      }else if(initialItems > 4){
        initialItems = 4;
      }else{
        initialItems = initialItems;
      }

      $multiSlider.parents("#featured-section").addClass("ms-colums-"+initialItems);
    }else{
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
        onStepStart: function(){
          $(element).find(".flex-slider-current img").each(function() {
            if(!$(this).hasClass(".loaded")){
              var dataImage = $(this).attr('data-original');
              $(this).attr("data-was-processed","true").attr("src",dataImage).addClass("initial loaded");
            }
          });
        },
        onInited: function(){
          var $a = 0;
          var $bulletBtn = $multiSlider.find(".gs-bullet");
          if($bulletBtn.length){
            $bulletBtn.each(function() {
              $a += 1;
              $(this).text('View Slide '+$a);
            });
          }
        },
        onResized: function(){
          var $a = 0;
          var $bulletBtn = $multiSlider.find(".gs-bullet");
          if($bulletBtn.length){
            $bulletBtn.each(function() {
              $a += 1;
              $(this).text('View Slide '+$a);
            });
          }
        }
      });
    }
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
    var ib_type_filter=$('.ib_type_filter').val();
    var ib_id_filter=$('.ib_id_filter').val();

  ib_obj_filter.forEach(function(itemFilter){

    $.ajax({
        url: idx_param_slider.ajaxUrl,
        type: "POST",
        data: filter_metadata_buiding,
        dataType: "json",
      success: function(response) {
        var html_listing=[];
        response.payload.properties[filter_metadata_buiding.type].items.forEach(function(item){
          html_exclusive_listing.push(idx_slider_html(item,'exclusve'));
          html_listing.push(idx_slider_html(item,'exclusve'));
        }); 

        //console.log(html_listing);
        
        if (html_listing.length>0){
          $(itemFilter.obj_container).html(html_listing.join(' ')).ready(function(){ idxboostTypeIcon(); });

          genMultiSlider(itemFilter.obj_container);
          $(itemFilter.obj_container).addClass('clidxboost-properties-slider');
          myLazyLoad.update();
        }
        
        response_ajax_idx=response;
        myLazyLoad.update();
      }
    }); 
  });
}


function idx_slider_html(info_item,type,vboard_info){
  var html_response=[];
  var slug_post=idx_param_slider.propertyDetailPermalink+'/'+info_item.slug;

  idx_param_slider.propertyDetailPermalink+'/'+info_item.slug
          html_response.push('<ul class="result-search slider-generator">');
            html_response.push('<li class="propertie" data-address="'+info_item.full_address+'"  data-id="'+info_item.mls_num+'" data-mls="'+info_item.mls_num+'" data-counter="0">');
            if (info_item.status=='5') {
              html_response.push('<div class="flex-property-new-listing">'+word_translate.rented+'</div>');
            }else if (info_item.status=='2') {
              html_response.push('<div class="flex-property-new-listing">'+word_translate.sold+'</div>');
            }else if (info_item.status !='1') {
              html_response.push('<div class="flex-property-new-listing">'+info_item.status_name+'</div>');
            }else if (info_item.hasOwnProperty('recently_listed') && info_item.recently_listed ==='yes') {
              html_response.push('<div class="flex-property-new-listing">'+word_translate.new_listing+'</div>');
            }
              //html_response.push('<h2 title="'+info_item.address_short+' '+info_item.address_large+'"><span>'+info_item.address_short+'</span></h2>');
              //html_response.push('<h2 title="' + info_item.full_address + '"><span>'+info_item.full_address_top+'</span><span>'+info_item.full_address_bottom+'</span></h2>');
              html_response.push('<h2 title="' + info_item.full_address + '" class="ms-property-address"><div class="ms-title-address -address-top">'+info_item.full_address_top+'</div><div class="ms-br-line">,</div><div class="ms-title-address -address-bottom">'+info_item.full_address_bottom+'</div></h2>');

              html_response.push('<ul class="features">');
                html_response.push('<li class="address">'+info_item.address_large+'</li>');
                html_response.push('<li class="price">$'+_.formatPrice(info_item.price)+'</li>');
                html_response.push('<li class="pr down">2.05%</li>');
                html_response.push('<li class="beds">'+info_item.bed+'  <span>'+word_translate.beds+' </span></li>');
                html_response.push('<li class="baths">'+info_item.bath+' <span>'+word_translate.baths+' </span></li>');
                html_response.push('<li class="living-size"> <span>'+_.formatPrice(info_item.sqft)+'</span> '+word_translate.sqft+' </li>');
                html_response.push('<li class="price-sf"><span>$'+info_item.price_sqft_m2+' </span>/ '+word_translate.sqft+'<span>($244 m²)</span></li>');
                html_response.push('<li class="build-year"><span>Built </span>2015</li>');
                html_response.push('<li class="development"><span></span></li>');
                //html_response.push('<li class="ms-logo-board"><img src="https://idxboost-spw-assets.idxboost.us/logos/fmls.png"></li>');

              html_response.push('</ul>');
              html_response.push('<div class="wrap-slider">');
                html_response.push('<ul>');

                info_item.gallery.forEach(function(gallery,index_gallery){
                  if (index_gallery==0){
                    html_response.push('<li class="flex-slider-current"><img class="flex-lazy-image" data-original="'+gallery+'" alt="'+info_item.address_short+' '+info_item.address_large+'"></li>');
                  }else{
                    html_response.push('<li class="flex-slider-item-hidden"><img class="flex-lazy-image" data-original="'+gallery+'" alt="'+info_item.address_short+' '+info_item.address_large+'"></li>');
                  }       
                });
                
                html_response.push('</ul>');

                if (info_item.gallery.length>1){
                  html_response.push('<button class="prev flex-slider-prev" aria-label="Next" tab-index="-1"><span class="clidxboost-icon-arrow-select"></span></button>');
                  html_response.push('<button class="next flex-slider-next" aria-label="Prev" tab-index="-1"><span class="clidxboost-icon-arrow-select"></span></button>');
                }

                if (info_item.status!='2') {
                  if (info_item.is_favorite==1){
                    html_response.push('<button class="clidxboost-btn-check" aria-label="Remove '+info_item.address_short+' of Favorites"><span class="flex-favorite-btn clidxboost-icon-check clidxboost-icon-check-list active" data-alert-token="'+info_item.token_alert+'"></span></button>');
                  }else{
                    html_response.push('<button class="clidxboost-btn-check" aria-label="Add '+info_item.address_short+' to Favorite"><span class="flex-favorite-btn clidxboost-icon-check clidxboost-icon-check-list"></span></button>');
                  }
                }
                
              html_response.push('</div>');
              html_response.push('<a class="ib-view-detailt" href="'+slug_post+'" rel="nofollow">'+word_translate.details+' of '+info_item.address_short+'</a>');
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

  $('.ib-filter-slider').each(function(){
    ib_obj_filter.push( { 'obj_container':'.ib-filter-slider-'+$(this).attr('data-filter')+' .ib-properties-slider', 'ib_type_filter':$(this).find('.ib_type_filter').val(), 'ib_id_filter':$(this).find('.ib_id_filter').val() } );
  });

  get_data_info();

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

                        /*Asigamos el texto personalizado*/
                        var titleText = $(".header-tab a[data-tab='tabRegister']").attr('data-text')
                        $("#modal_login .modal_cm .content_md .heder_md .ms-title-modal").html(titleText);
                        
                        countClickAnonymous = 0;
                    }
                }
            }
        });

        $('.ib-properties-slider').on("click", ".flex-favorite-btn", function(event) {
            event.stopPropagation();
            event.preventDefault();
            // active
            var buton_corazon = $(this);
            if (__flex_g_settings.anonymous === "yes") {
                //active_modal($('#modal_login'));
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

