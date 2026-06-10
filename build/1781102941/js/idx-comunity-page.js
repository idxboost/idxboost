  /**** SLIDER PRINCIPAL ****/
  var $sliderPrincipalCommunity = jQuery(".ms-community-slider");
  if($sliderPrincipalCommunity.length) {
    var activeHand = "";
    var widthSize = jQuery(window).width();
    if(widthSize < 768){
      activeHand = true;
    }else{
      activeHand = false;
    }

    $sliderPrincipalCommunity.greatSlider({
      type: 'swipe',
      navSpeed: 1000,
      lazyLoad: true,
      nav: true,
      bullets: false,
      items: 1,
      autoDestroy: true,

      dragHand: activeHand,
			drag: activeHand,
      touch: activeHand,
      
      layout: {
        bulletDefaultStyles: false,
        wrapperBulletsClass: 'clidxboost-gs-wrapper-bullets',
        resizeClass: 'ms-resize',
        arrowPrevContent: 'Prev',
        arrowNextContent: 'Next',
      }
    });
  }

  /**** NAVEGACION INTERNA ****/
  jQuery(document).on('click', '.ms-community-nav>ul>li>a', function(e) {
    e.preventDefault();
    jQuery('.ms-community-nav>ul>li>a').removeClass('active');
    jQuery(this).addClass('active');
    var idSection = jQuery(jQuery(this).attr('href'));
    var sectionPosition = idSection.offset();
    var finalPosition = (sectionPosition.top - 160) * 1;
    jQuery('html, body').animate({scrollTop: finalPosition}, 900);
  });

  /**** ACTIVAR FAVORITO ****/
  jQuery(document).on('click', '.ms-btn-favorite', function(e) {
    e.preventDefault();
    jQuery(this).toggleClass('active');
  });

  /**** SHOW GRID AND LIST ****/
  jQuery(document).on('click', '.ms-aviable-format', function(e) {
    e.preventDefault();
    var typeFormat = jQuery(this).attr('data-show');
    jQuery('.ms-aviable-format').removeClass('active');
    jQuery(this).addClass('active');
    if(typeFormat == 'ms-tab-list'){
      jQuery('.ms-tab-grid').removeClass('active');
      jQuery('.ms-tab-list').addClass('active');
    }else{
      jQuery('.ms-tab-grid').addClass('active');
      jQuery('.ms-tab-list').removeClass('active');
    }
  });

  /**** FILTROS ****/
  /*
  jQuery(document).on('click', '.ms-commuty-filters .ms-item-filter', function(e) {
    e.preventDefault();
    jQuery('.ms-item-filter').removeClass('active');
    var tabFilter = jQuery(this).attr('data-filter');
    jQuery('.tb-pane').removeClass('in active');
    jQuery('#'+tabFilter).addClass('in active');

    console.log(tabFilter);
    jQuery(".ms-item-filter[data-filter="+tabFilter+"]").addClass('active');
    jQuery(this).addClass('active');

    var sectionPosition = jQuery("#ms-commuty-filters").offset();
    var finalPosition = (sectionPosition.top - 140) * 1;
    jQuery('html, body').animate({scrollTop: finalPosition}, 900);
  });
  */

  /**** REPRODUCTOR DE VIDEO ****/
  jQuery(document).on('click', '.ms-btn-action', function(e) {
    e.preventDefault();
    var wrapperVideo = jQuery('.ms-community-video');
    var dataType = jQuery(this).attr('data-type');
    var parentMedia = jQuery('.ms-community-wrap-media');

    if(dataType == 'video'){
      if(!jQuery(this).hasClass("active")){
        var iframeVideo = createVideoCommunity(jQuery(this));
        if (iframeVideo) {
          wrapperVideo.append(iframeVideo);
        }
        parentMedia.removeClass('photo map').addClass('video');
      }
    }else if(dataType == 'map'){
      
      var element = jQuery(this).attr('data-map');
      var lat = jQuery(this).attr('data-lat');
      var lng = jQuery(this).attr('data-lng');

      if(!jQuery(this).hasClass("active")){
        wrapperVideo.empty();
        parentMedia.removeClass('active');
        createMapCommunity(element,lat,lng);
        parentMedia.removeClass('photo video').addClass('map active');
      }

    }else{
      wrapperVideo.empty();
      parentMedia.removeClass('video map video').addClass('photo');
    }

    parentMedia.find('.ms-btn-action').removeClass('active');
    jQuery(this).addClass('active');
  });

  /**** SHOW SHARED ****/
  jQuery(document).on('click', '.ms-btn-shared', function(e) {
    e.preventDefault();
    jQuery('.ms-wrap-shared').toggleClass('active');
  });

  /**** ACTIVE FORM ****/
  jQuery(document).on('click', '.ms-btn-form', function(e) {
    e.preventDefault();
    jQuery('.ms-community-float-block').addClass('active');
  });

  /**** ACTIVE COMUNITY SLIDER ****/
  jQuery(document).on('click', '.ms-commuty-close-modal', function(e) {
    e.preventDefault();
    jQuery('.ms-community-float-block').removeClass('active');
  });

  /**** GENERANDO SLIDER TIPO MODAL****/
  jQuery(document).on('click', '.ms-show-floorplans', function(e) {
    e.preventDefault();
    var parentId = jQuery(this).parents(".ms-sp-slider").attr("id");
    var elementSelected = jQuery(this).parents('.ms-floorplans-item').parent().index();
    sliderModal("#"+parentId,elementSelected);
    jQuery("body").addClass("ms-active-mds");
  });

  /**** REMOVIENDO SLIDER TIPO MODAL****/
  jQuery(document).on('click', '.ms-modal-sp-slider .ms-close', function(e) {
    e.preventDefault();
    removeSliderModal();
    jQuery("body").removeClass("ms-active-mds");
  });

  /**** GENERANDO LAS TABLAS ****/
  createDataTable('table.dataTableCC');
  function createDataTable(tableElement){
    jQuery(tableElement).DataTable();
  }


  /**** GENERANDO SLIDER TIPO MODAL****/
  jQuery(document).on('click', '.ms-full-screen', function(e) {
    e.preventDefault();
    var parentId = "ms-slider-cm";
    var elementSelected = jQuery("#ms-slider-cm").find(".gs-item-active").index();
    sliderModal("#"+parentId,elementSelected);
    jQuery("body").addClass("ms-active-mds");
  });


  /**** GENERANDO MODAL Y SLIDER FLOORPLAN ****/
  function sliderModal(element,slideinit){
    var mySliderList, temporalImage = "";
    var genSlider = jQuery("#ms-modal-sp-slider").find("#ms-gen-slider");
    if(!genSlider.hasClass("gs-builded")){
      jQuery(element).find('img').each(function () {
        var imgeSlider = jQuery(this).attr('data-img');
        if(imgeSlider !== "" && imgeSlider !== undefined){
          temporalImage = imgeSlider;
        }else{
          temporalImage = jQuery(this).attr('src');
        }
        var imgList = '<img src="'+temporalImage+'">';
        mySliderList = mySliderList + imgList;
      });
      genSlider.empty().html(mySliderList);
      var starItem = slideinit + 1;
      genSlider.greatSlider({
        type: 'swipe',
        nav: true,
        lazyLoad: true,
        bullets: false,
        startPosition: starItem
      });
    }
  }

  /**** REMOVER MODAL Y SLIDER FLOORPLAN ****/
  function removeSliderModal(){
    jQuery("#ms-modal-sp-slider").find(".ms-wrap-slider").remove();
    jQuery("#ms-modal-sp-slider").append('<div class="ms-wrap-slider" id="ms-gen-slider"></div>');
  }

  /**** VIDEO COMMUNITY ****/
  var $document = jQuery(document);
  function createVideoCommunity(elBoton){
    var $urlVideo = elBoton.attr('data-video');
    if ($urlVideo !== undefined) {
      var $urlVideo = $urlVideo.toString();
      if ($urlVideo.indexOf('youtube') !== -1) {
        var et = $urlVideo.lastIndexOf('&')
        if(et !== -1){
          $urlVideo = $urlVideo.substring(0, et)
        }
        var embed = $urlVideo.indexOf('embed');
        if (embed !== -1) {
          $urlVideo = 'https://www.youtube.com/watch?v=' + $urlVideo.substring(embed + 6, embed + 17);
        }
        var srcVideo = 'https://www.youtube.com/embed/' + $urlVideo.substring($urlVideo.length - 11, $urlVideo.length) + '?autoplay=1;rel=0&showinfo=0';
        return '<iframe allow="autoplay; encrypted-media" src="' + srcVideo + '" frameborder="0" allowfullscreen></iframe>';
      } else if ($urlVideo.indexOf('vimeo') !== -1) { // es un video de Vimeo, EJM: https://vimeo.com/206418873
        var srcVideo = 'https://player.vimeo.com/video/' + $urlVideo.substring(($urlVideo.indexOf('.com') + 5), $urlVideo.length).replace('/', '');
        return '<iframe allow="autoplay; encrypted-media" src="' + srcVideo + '" frameborder="0" allowfullscreen></iframe>';
      } else {
        return '<video controls autoplay src="' + $urlVideo + '" width="100%" height="100%">';
      }
    }
  }

  /**** MAPA ****/
  function createMapCommunity(element,lat,lng){
    var map = jQuery("#"+element);
    if(map.length){
      var myLatLng = {
        lat: parseFloat(lat),
        lng: parseFloat(lng)
      };
      var newMap = new google.maps.Map(document.getElementById(element), {
        zoom: 16,
        center: myLatLng,
        mapTypeControl: false,
        fullscreenControl: false
      });
      var marker = new google.maps.Marker({
        position: myLatLng,
        map: newMap
      });
    }
  }

  loadBoostBoxResize();

  /**** BOOSTBOX ****/
  function loadBoostBoxResize(){
    var initialBoox = jQuery("#boostBoxLateral");
    var boostBox = initialBoox.html();
    
    jQuery(window).on("load resize",function(e){
      var boostBoxLength = initialBoox.find(".ms-wrap-boostbox");
      var widthSize = jQuery(window).width();
      if(widthSize < 1023){
        if(!jQuery("#boostBoxCentral").hasClass("active")){
          jQuery("#boostBoxLateral").empty();
          jQuery("#boostBoxLateral").removeClass("active");
          jQuery("#boostBoxCentral").html(boostBox);
          jQuery("#boostBoxCentral").addClass("active");
          //chekSectionAnimate();
        }
      }else{
        if(!boostBoxLength.length){
          jQuery("#boostBoxCentral").empty();
          jQuery("#boostBoxCentral").removeClass("active");
          jQuery("#boostBoxLateral").html(boostBox);
          jQuery("#boostBoxLateral").addClass("active");
          //chekSectionAnimate();
        }
      }
    });
  }
  