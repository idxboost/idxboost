var xDown = null;
var yDown = null;

(function($) {
    $(function() {
        // fix touch slider
        $('body').on('touchstart', '#full-slider', function(evt) {
            evt.stopPropagation();
            xDown = evt.originalEvent.touches[0].clientX;
            yDown = evt.originalEvent.touches[0].clientY;
        });
        $('body').on('touchstart', '#modal_img_propertie .wrapper-img', function(evt) {
            evt.stopPropagation();
            xDown = evt.originalEvent.touches[0].clientX;
            yDown = evt.originalEvent.touches[0].clientY;
        });
        $('body').on('touchmove', '#full-slider', function(evt) {
            if (!xDown || !yDown) {
                return;
            }
            var xUp = evt.originalEvent.touches[0].clientX;
            var yUp = evt.originalEvent.touches[0].clientY;
            var xDiff = xDown - xUp;
            var yDiff = yDown - yUp;
            if (Math.abs(xDiff) > Math.abs(yDiff)) { // si se mueve derecha o izquierda
                evt.preventDefault();
                if (xDiff > 0) { // izquierda
                    $(this).find('.next').click();
                } else { // derecha
                    $(this).find('.prev').click();
                }
            }
            xDown = null;
            yDown = null;
        });
        $('body').on('touchmove', '#modal_img_propertie .wrapper-img', function(evt) {
            if (!xDown || !yDown) {
                return;
            }
            var xUp = evt.originalEvent.touches[0].clientX;
            var yUp = evt.originalEvent.touches[0].clientY;
            var xDiff = xDown - xUp;
            var yDiff = yDown - yUp;
            if (Math.abs(xDiff) > Math.abs(yDiff)) { // si se mueve derecha o izquierda
                evt.preventDefault();
                if (xDiff > 0) { // izquierda
                    $(this).find('.next').click();
                } else { // derecha
                    $(this).find('.prev').click();
                }
            }
            xDown = null;
            yDown = null;
        });
    });

    $(document).ready(function(){
        Cookies.set("reference_force_registration", "no" );
    });    

    $(window).on('load', function() {
        var avatarImg = $(".content-avatar-image .lazy-img").attr("data-src");
        if (typeof(avatarImg) != 'undefined') {
            $(".content-avatar-image .lazy-img").attr("src", avatarImg).removeAttr("data-src").addClass("active");
        }
        var mapImg = $("#min-map").attr("data-map-img");
        if (typeof(mapImg) != 'undefined') {
            $("#min-map").css("background-image", "url('" + mapImg + "')").removeAttr("data-map-img");
        }
        $(window).scroll(function() {
            window_y = $(window).scrollTop();
            var mapLat = $("#content-map #map").attr("data-lat");
            var mapLng = $("#content-map #map").attr("data-lng");
            if (window_y >= 300) {
                $(".similar-properties .lazy-img").each(function() {
                    var imagen = $(this).attr("data-src");
                    if (typeof(imagen) != 'undefined') {
                        $(this).attr("src", imagen).removeAttr("data-src").addClass("active");
                    }
                });
                if ((typeof(mapLat) != 'undefined') && (typeof(mapLng) != 'undefined')) {
                    showFullMap();
                }
            } else {}
        });
        temporalHeight();
        temporalHeightBuilding();
    });
    
    $(window).resize(function() {
        temporalHeight();
        temporalHeightBuilding();
    });

    function showFullMap() {
        var flex_map_mini_view = $("#map");
        var myLatLng2 = {
            lat: parseFloat(flex_map_mini_view.data('lat')),
            lng: parseFloat(flex_map_mini_view.data('lng'))
        };
        var miniMap = new google.maps.Map(document.getElementById('map'), {
            zoom: 16,
            center: myLatLng2
        });
        var marker = new google.maps.Marker({
            position: myLatLng2,
            map: miniMap
        });
        $("#map").removeAttr("data-lat");
        $("#map").removeAttr("data-lng");
    }

    /*function temporalHeight() {
      var finalTop = ($(".property-information").height()) + ($(".panel-options").height()) + 21;
      var propertyDescription = $("#property-description");
      if (propertyDescription.length) {
        var heightContent = propertyDescription.height();
        var finalHeight = heightContent + 31;
      }else{
        var finalHeight = 0;
        $(".temporal-content").css({'border-bottom':'0'});
      }
      $(".temporal-content").height(finalHeight).css({
        'top': finalTop + 'px'
      }).animate({'opacity':'1'});
    }

    function temporalHeightBuilding() {
      var finalTop = ($(".property-details.r-hidden").height()) + ($(".panel-options").height()) + 26;
      var propertyDescription = $(".property-description");
      if (propertyDescription.length) {
        var heightContent = propertyDescription.height();
        var finalHeight = heightContent + 35;
      }else{
        var finalHeight = 0;
        $(".temporal-content-bl").css({'border-bottom':'0'});
      }
      $(".temporal-content-bl").height(finalHeight).css({
        'top': finalTop + 'px'
      }).animate({'opacity':'1'});
    }*/

    function temporalHeight() {
        var finalTop = ($(".property-information").outerHeight() + $(".panel-options").outerHeight() + $(".ib-pdescription-title").outerHeight()) - 1;
        var propertyDescription = $("#property-description");
        if (propertyDescription.length) {
          var heightContent = propertyDescription.outerHeight();
          var finalHeight = heightContent;
        }else{
          var finalHeight = 0;
          $(".temporal-content").css({'border-bottom':'0'});
        }
        $(".temporal-content").height(finalHeight).css({
          'top': finalTop + 'px'
        }).animate({'opacity':'1'});
      }
  
      function temporalHeightBuilding() {
          var contentDetail = $(".ms-wrap-property-description");
          contentDetail.css({'display':'block'});
  
          if(contentDetail.length){
              var contentDetailHeight = contentDetail.outerHeight();
              console.log(contentDetailHeight);
              
              if(contentDetailHeight > 200){                  
                  if(!contentDetail.hasClass('ms-rd')){
                      contentDetail.addClass('ms-rd');
                  }
              }
          }
      }
  
      jQuery(document).on("click", "#ms-read", function() {
          if($(this).hasClass('show')){
              $(this).removeClass('show');
              $(this).text($(this).attr('data-before'));
              $(".ms-wrap-property-description").removeClass('active');
          }else{
              $(this).addClass('show');
              $(this).text($(this).attr('data-after'));
              $(".ms-wrap-property-description").addClass('active');
          }
      });

    //FULL SLIDER
    var $ventana = $(window);
    var $widthVentana = $ventana.width();

    function anchoRelativoSlider(wrapper, frames) {
        if (typeof frames !== 'undefined' && frames.length) {
            var nframes = frames.length;
            wrapper.css('width', ((nframes / lisATomar) * 100) + '%');
            frames.css('width', (100 / nframes) + '%');
        }
    }

    function framesPorSwipe() {
        switch (true) {
            case ($widthVentana < 768):
                lisATomar = 1;
                break
            case ($widthVentana >= 768 && $widthVentana < 1024):
                lisATomar = 2;
                break
            case ($widthVentana >= 1024):
                lisATomar = 3;
                break
        }
    }
    $ventana.on('resize', function() {
        $widthVentana = $ventana.width();
        setTimeout(function() {
            framesPorSwipe();
            anchoRelativoSlider($wrapperSlide, $frames);
        }, 100)
    });
    // Saber cuantos LI tomar
    var lisATomar = 0;
    framesPorSwipe(); // averiguo cuantos LI debo tomar, dependiendo la resolución de la pantalla
    var $fullMain = $('#full-main');
    var $fullSlider = $('#full-slider .wrap-slider');
    if ($fullSlider.length) {
        var $wrapperSlide = $fullSlider.find('ul');
        var $frames = $wrapperSlide.find('li');
        var nframes = $frames.length;
        if (nframes > 1) {
            anchoRelativoSlider($wrapperSlide, $frames);
            $wrapperSlide.data('frame', '1');
        } else {
            $fullSlider.find('.next, .prev').css('display', 'none');
            console.log('no hay frames para crear el slider');
        }
    }

    function active_modal($modal) {
        if ($modal.hasClass('active_modal')) {
            $('.overlay_modal').removeClass('active_modal');
            // $("html, body").animate({
            //     scrollTop: 0
            // }, 1500);
        } else {
            $modal.addClass('active_modal');
            $modal.find('form').find('input').eq(0).focus();
            $('html').addClass('modal_mobile');
        }
        close_modal($modal);
    }

    function close_modal($obj) {
        var $this = $obj.find('.close');
        $this.click(function() {
            var $modal = $this.closest('.active_modal');
            $modal.removeClass('active_modal');
            $('html').removeClass('modal_mobile');
        });
    }

    // ********** START 
    $(function() {

	      // favorites
        $('.chk_save_property').click(function(event){
            event.stopPropagation();
            event.preventDefault();
            var _self = $(this);
            if ($('.chk_save').hasClass('working')) return false;

            if (__flex_g_settings.anonymous == 'yes'){
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
                return; 
                //active_modal($('#modal_login'));
            }

            //var $realBtn = _self.find('.dgt-mark-favorite');
            var class_id = _self.data('class-id');
            var mls_num = _self.data("mls");
            var token_alert = _self.attr("data-alert-token");
            var vsubject =_self.attr("data-address");

            $('.chk_save').addClass('working');
            if ($(this).find('span').hasClass("active")) { // remove
                $.ajax({
                    url: flex_idx_property_params.ajaxUrl,
                    method: "POST",
                    data: {
                        action: "flex_favorite",
                        class_id: class_id,
                        mls_num: mls_num,
                        type_action: 'remove',
                        token_alert: token_alert,
                        registration_key: (typeof IB_AGENT_REGISTRATION_KEY !== "undefined") ? IB_AGENT_REGISTRATION_KEY : null
                    },
                    dataType: "json",
                    success: function(data) {
                        var textLabel = _self.attr("data-save");
                        if(textLabel !== "" && textLabel !== undefined){
                            textLabel = textLabel;
                        }else{
                            textLabel = "Save";
                        }

                        $('.chk_save').removeClass('working');
                        $('.chk_save').removeAttr('data-alert-token').find('span').removeClass('active').text(textLabel);
                    }
                });

            } else {

              $.ajax({
                    url: flex_idx_property_params.ajaxUrl,
                    method: "POST",
                    data: {
                        action: "flex_favorite",
                        class_id: class_id,
                        mls_num: mls_num,
                        subject: vsubject,
                        type_action: 'add',
                        registration_key: (typeof IB_AGENT_REGISTRATION_KEY !== "undefined") ? IB_AGENT_REGISTRATION_KEY : null
                    },
                    dataType: "json",
                    success: function(data) {

                        var textLabel = _self.attr("data-remove");
                        if(textLabel !== "" && textLabel !== undefined){
                            textLabel = textLabel;
                        }else{
                            textLabel = "Remove";
                        }

                      $('.chk_save').removeClass('working');
                      //$('.chk_save').attr('data-alert-token', data.token_alert).find('span').addClass('active').text('remove favorite');
                        $('.chk_save').attr('data-alert-token', data.token_alert).find('span').addClass('active').text(textLabel);
                    }
                });
            }
        });

        // inquiry property form
        /*$("#flex-idx-property-form").on("submit", function(event) {
            event.preventDefault();
            var _self = $(this);
            $.ajax({
                url: flex_idx_property_params.ajaxUrl,
                method: "POST",
                data: _self.serialize(),
                dataType: "json",
                success: function(data) {
                    //data.message
                    $('#modal_properties_send .body_md .ico_ok').text(word_translate.email_sent);
                    active_modal($('#modal_properties_send'));
                    setTimeout(function() { 
                    $('#modal_properties_send').find('.close').click();
                    }, 2000);                            
                }
            });
        });*/
    });
}(jQuery));
