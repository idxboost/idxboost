(function($) {

  /*----------------------------------------------------------------------------------*/
  /* Contenedor temporal - Detalle de propiedades
  /*----------------------------------------------------------------------------------*/
  function temporalHeightModal() {
    var finalTop = ($(".modal_property_detail .property-information").height()) + ($(".modal_property_detail .panel-options").height()) + 21;
    var propertyDescription = $(".modal_property_detail #property-description");
    if (propertyDescription.length) {
      var heightContent = propertyDescription.height();
      var finalHeight = heightContent + 31;
    }else{
      var finalHeight = 0;
      $(".modal_property_detail .temporal-content").css({'border-bottom':'0'});
    }
    $(".modal_property_detail .temporal-content").height(finalHeight).css({
      'top': finalTop + 'px'
    }).animate({'opacity':'1'});
  }

  /*----------------------------------------------------------------------------------*/
  /* Contenedor temporal - Detalle de propiedades Building
  /*----------------------------------------------------------------------------------*/
  function temporalHeightBuildingModal() {
    var finalTop = ($(".modal_property_detail .property-details.r-hidden").height()) + ($(".modal_property_detail .panel-options").height()) + 26;
    var propertyDescription = $(".modal_property_detail .property-description");
    if (propertyDescription.length) {
      var heightContent = propertyDescription.height();
      var finalHeight = heightContent + 35;
    }else{
      var finalHeight = 0;
      $(".modal_property_detail .temporal-content-bl").css({'border-bottom':'0'});
    }
    $(".modal_property_detail .temporal-content-bl").height(finalHeight).css({
      'top': finalTop + 'px'
    }).animate({'opacity':'1'});
  }

  $(window).on('load resize', function() {
    temporalHeightModal();
    temporalHeightBuildingModal();
  });

  /*----------------------------------------------------------------------------------*/
  /* FUNCION PARA GENERAR EL FULL SLIDER EN EL MODAL DE PROPIEDADES
  /*----------------------------------------------------------------------------------*/
  function createFullSlider(element){
    var $fullSlider = $(element);
    $fullSlider.greatSlider({
      type: 'swipe',
      nav: true,
      navSpeed: 500,
      lazyLoad: true,
      bullets: false,
      items: 1,
      fullscreen: true,
      autoHeight: false,
      layout: {
        arrowDefaultStyles: false
      },
      breakPoints: {
        640: {
          //itemsInFs: 1,
          items: 2
        },
        1360: {
          //itemsInFs: 1,
          items: 3
        }
      },
      onInited: function(){
        var $showSlider = $(".clidxboost-full-slider").parents('#full-slider');
        if($showSlider.length){
          $showSlider.addClass('show-slider-psl');
        }
      }
    });
  }

  /*------------------------------------------------------------------------------------------*/
  /* Modal detalle de propiedad en los resultados de busqueda (ACTIVAR LUEGO)
  /*------------------------------------------------------------------------------------------*/

  /*$(document).on('click', '.show-modal-properties', function(event) {
    event.preventDefault();
    var $urlSite = window.location.protocol+'//'+window.location.host+'/wp-content/plugins/idx-boost/views/form/formproperties.php';
    $("html").addClass("modal-properties-active");
    $('#modal_property_detail').addClass('active_modal');
    //Cargar en el Ajax
    var $slugItem = ""; //Slug del items seleccionado
    $.ajax({
      type: "POST",
      url: $urlSite, //Colocar la url final
      data: $slugItem,
      cache: false,
      success: function(data){
        $("#md-body").html(data);
      },
      complete: function(){
        temporalHeightModal();
        temporalHeightBuildingModal();
        createFullSlider("#modal-full-slider");
        $(window).on('resize', function() {
          temporalHeightModal();
          temporalHeightBuildingModal();
        });
      }
    });
  });*/

})(jQuery);