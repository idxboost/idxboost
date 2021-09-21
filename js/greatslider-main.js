(function($) {

	/*----------------------------------------------------------------------------------*/
	/* COLECCION DE NEIGHBORHOODS
	/*----------------------------------------------------------------------------------*/

	const $sliderNeighborhoods = $('#lgr-neighborhoods-slider');
	if ($sliderNeighborhoods.length) {
		$sliderNeighborhoods.greatSlider({
			type: 'swipe',
			nav: true,
			bullets: false,
			layout: {
				arrowDefaultStyles: false,

				arrowPrevContent: 'Prev',
				arrowNextContent: 'Next',
			},
			breakPoints: {
				768: {
					destroy: true
				}
			},
			onInited: function(){
	    	var $a = 0;
	    	var $bulletBtn = $sliderNeighborhoods.find(".gs-bullet");
	    	if($bulletBtn.length){
					$bulletBtn.each(function() {
						$a += 1;
						$(this).text('View Slide '+$a);
					});
	    	}
			},
			onResized: function(){
	    	var $a = 0;
	    	var $bulletBtn = $sliderNeighborhoods.find(".gs-bullet");
	    	if($bulletBtn.length){
					$bulletBtn.each(function() {
						$a += 1;
						$(this).text('View Slide '+$a);
					});
	    	}
	    }
		});
	}
	

	/*----------------------------------------------------------------------------------*/
	/* COLECCION DE NEIGHBORHOODS GRID - MAPA
	/*----------------------------------------------------------------------------------*/
	let $sliderNeighborhoodsGM = $('.mg-sliderneighborhoods');
	if($sliderNeighborhoodsGM.length) {
		$sliderNeighborhoodsGM.greatSlider({
			type: 'swipe',
			bullets: false,
			nav: true,
			lazyLoad: true,
			layout: {
				bulletDefaultStyles: false,

				arrowPrevContent: 'Prev',
				arrowNextContent: 'Next',
			},
			breakPoints: {
				768: {
					destroy: true
				}
			},
			onDestroyed: ()=> {
				setTimeout(()=>{
					$sliderNeighborhoodsGM.find('.gs-lazy').each(function(){
						let $dataLazy = $(this).attr('data-lazy');
						if($dataLazy !== undefined) $(this).attr('src', $dataLazy).removeAttr('data-lazy');
					});
				}, 1000);
			},

			onInited: function(){
	    	var $a = 0;
	    	var $bulletBtn = $sliderNeighborhoodsGM.find(".gs-bullet");
	    	if($bulletBtn.length){
					$bulletBtn.each(function() {
						$a += 1;
						$(this).text('View Slide '+$a);
					});
	    	}
	    },
			onResized: function(){
	    	var $a = 0;
	    	var $bulletBtn = $sliderNeighborhoodsGM.find(".gs-bullet");
	    	if($bulletBtn.length){
					$bulletBtn.each(function() {
						$a += 1;
						$(this).text('View Slide '+$a);
					});
	    	}
	    }
		});
	}

	/*----------------------------------------------------------------------------------*/
	/* SLIDER PRINCIPAL
	/*----------------------------------------------------------------------------------*/
	var $mainSlider = $(".clidxboost-main-slider");
	if($mainSlider.length) {
		$mainSlider.greatSlider({
			type: 'fade',
			nav: false,
			lazyLoad: true,
			bullets: true,
			autoHeight: false,
			/*autoplay: true,
			autoplaySpeed: 5000,*/
			layout: {
				bulletDefaultStyles: false,
				wrapperBulletsClass: 'clidxboost-gs-wrapper-bullets',

				arrowPrevContent: 'Prev',
				arrowNextContent: 'Next',
			},

			onInited: function(){
	    	var $a = 0;
	    	var $bulletBtn = $mainSlider.find(".gs-bullet");
	    	if($bulletBtn.length){
					$bulletBtn.each(function() {
						$a += 1;
						$(this).text('View slide '+$a);
					});
	    	}
	    },
			onResized: function(){
	    	var $a = 0;
	    	var $bulletBtn = $mainSlider.find(".gs-bullet");
	    	if($bulletBtn.length){
					$bulletBtn.each(function() {
						$a += 1;
						$(this).text('View Slide '+$a);
					});
	    	}
	    }
		});
	}

	/*----------------------------------------------------------------------------------*/
	/* COLECCION DE PROPIEDADES
	/*----------------------------------------------------------------------------------*/
	var $propertiesSlider = $(".clidxboost-properties-slider");
	if($propertiesSlider.length) {
		var initialItems, autoPlaySpeed, autoPlay  = "";
    var dataItems = $propertiesSlider.parents("#featured-section").attr("data-item");
    var autoPlayStatus = ($propertiesSlider.parents("#featured-section").attr("auto-play")) * 1;
    var autoPlayspeed = $propertiesSlider.parents("#featured-section").attr("speed-slider");

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
    
		$propertiesSlider.greatSlider({
			type: 'swipe',
			nav: true,
			navSpeed: 500,
			lazyLoad: true,
			bullets: false,
      items: 1,
      autoplay: autoPlay,
      autoplaySpeed: autoPlaySpeed,
			autoDestroy: true,
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
	      $(".clidxboost-properties-slider").find(".flex-slider-current img").each(function() {
	      	if(!$(this).hasClass(".loaded")){
	      		var dataImage = $(this).attr('data-original');
	      		$(this).attr("data-was-processed","true").attr("src",dataImage).addClass("initial loaded");
	      	}
	      });
	    },
	    onInited: function(){
	    	var $a = 0;
	    	var $bulletBtn = $propertiesSlider.find(".gs-bullet");
	    	if($bulletBtn.length){
					$bulletBtn.each(function() {
						$a += 1;
						$(this).text('View Slide '+$a);
					});
	    	}
	    },
			onResized: function(){
	    	var $a = 0;
	    	var $bulletBtn = $propertiesSlider.find(".gs-bullet");
	    	if($bulletBtn.length){
					$bulletBtn.each(function() {
						$a += 1;
						$(this).text('View Slide '+$a);
					});
	    	}
	    }
		});
	}

	/*----------------------------------------------------------------------------------*/
	/* TESTIMONIALES
	/*----------------------------------------------------------------------------------*/
	var $testimonialSlider = $(".clidxboost-testimonial-slider");
	if($testimonialSlider.length) {
		$testimonialSlider.greatSlider({
			type: 'swipe',
			nav: false,
			bullets: true,
			autoHeight: true,
			autoDestroy: true,
			layout: {
				bulletDefaultStyles: false,
				wrapperBulletsClass: 'clidxboost-gs-wrapper-bullets',

				arrowPrevContent: 'Prev',
				arrowNextContent: 'Next',
			},
	    onInited: function(){
	    	var $a = 0;
	    	var $bulletBtn = $testimonialSlider.find(".gs-bullet");
	    	if($bulletBtn.length){
					$bulletBtn.each(function() {
						$a += 1;
						$(this).text('View Slide '+$a);
					});
	    	}
	    },
			onResized: function(){
	    	var $a = 0;
	    	var $bulletBtn = $testimonialSlider.find(".gs-bullet");
	    	if($bulletBtn.length){
					$bulletBtn.each(function() {
						$a += 1;
						$(this).text('View Slide '+$a);
					});
	    	}
	    }
		});
	}

	/*----------------------------------------------------------------------------------*/
	/* FULL MAP DETALLE DE PROPIEDAD
	/*----------------------------------------------------------------------------------*/
	var $fullSlider = $(".clidxboost-full-slider");
	if($fullSlider.length) {
		const $totalItems = $fullSlider.find('.img-slider').length;
		let $fsSlider = $fullSlider.greatSlider({
			type: 'swipe',
			nav: true,
			navSpeed: 500,
			lazyLoad: true,
			bullets: false,
			items: 1,
			fullscreen: true,
			autoHeight: false,
			dragHand: false,
			drag: false,
			touch: false,
			layout: {
				arrowDefaultStyles: false,

				arrowPrevContent: 'Prev',
				arrowNextContent: 'Next',
			},
			breakPoints: {
		      640: {
		        items: 2
		      },
		      1360: {
		        items: 3
		      }
		    },
		    onInited: function(){
					var $showSlider = $fullSlider.parents('#full-slider');
					if($showSlider.length) $showSlider.addClass('show-slider-psl');
					// anidando FS con click sobre la imagen
					$fullSlider.find('.gs-item-slider').on('click', function(){
						$fsSlider.fullscreen('in', $(this).index() + 1);
					});

					var $a = 0;
		    	var $bulletBtn = $fullSlider.find(".gs-bullet");
		    	if($bulletBtn.length){
						$bulletBtn.each(function() {
							$a += 1;
							$(this).text('View Slide '+$a);
						});
		    	}
		    },
				onResized: function(){
					var $a = 0;
					var $bulletBtn = $fullSlider.find(".gs-bullet");
					if($bulletBtn.length){
						$bulletBtn.each(function() {
							$a += 1;
							$(this).text('View Slide '+$a);
						});
					}
				},
		    onFullscreenIn: ()=> {
				// creando el título en FS
				const $ibmpTitle = $fullSlider.find('.ib-pvsititle');
				if (!$ibmpTitle.length) {
					$fullSlider.find('.gs-container-items').append('<span class="ib-pvsititle">' + $('.title-page').text() + '</span>');
				}
				// Creando la numeración en FS
				const $ibmpNumbers = $fullSlider.find('.ib-pvsinumber');
				if (!$ibmpNumbers.length) {
					$fullSlider.find('.gs-container-items').append('<span class="ib-pvsinumber">' + ($fullSlider.find('.gs-item-active').index() + 1) + ' of ' + $totalItems + '</span>');
				} else {
					$fullSlider.find('.ib-pvsinumber').text(($fullSlider.find('.gs-item-active').index() + 1) + ' of ' + $totalItems)
				}
			},
			onStepEnd: ($itemActivo, indexIA)=> {
				if ($fullSlider.hasClass('gs-infs')) {
					$fullSlider.find('.ib-pvsinumber').text(indexIA + ' of ' + $totalItems)
				}
			}
		});
	}

	/*----------------------------------------------------------------------------------*/
	/* DEVELOPMENT SLIDER
	/*----------------------------------------------------------------------------------*/

	var $developmentSlider = $(".clidxboost-development");
	if($developmentSlider.length) {
		$developmentSlider.greatSlider({
			type: 'swipe',
			nav: false,
			bullets: true,
			lazyLoad: true,
			layout: {
				bulletDefaultStyles: false,

				arrowPrevContent: 'Prev',
				arrowNextContent: 'Next',
			},
			breakPoints: {
	      640: {
	        items: idx_develop_slider_item_mobile,
	      },
	      991: {
	        items: idx_develop_slider_item_medium,
	      },
	      1280: {
	        items: idx_develop_slider_item_large,
	      }	      
	    },
	    onInited: function(){
	    	var $a = 0;
	    	var $bulletBtn = $developmentSlider.find(".gs-bullet");
	    	if($bulletBtn.length){
					$bulletBtn.each(function() {
						$a += 1;
						$(this).text('View Slide '+$a);
					});
	    	}
	    },
			onResized: function(){
	    	var $a = 0;
	    	var $bulletBtn = $developmentSlider.find(".gs-bullet");
	    	if($bulletBtn.length){
					$bulletBtn.each(function() {
						$a += 1;
						$(this).text('View Slide '+$a);
					});
	    	}
	    }
		});
	}

	//loadFullSlider("#modal_property_detail .clidxboost-full-slider");

	/*----------------------------------------------------------------------------------*/
	/* DEVELOPMENT SLIDER
	/*----------------------------------------------------------------------------------*/
	var $neighborhoodSlider = $("#neighborhood-shortcode");
	if($neighborhoodSlider.length) {
		$neighborhoodSlider.greatSlider({
			type: 'swipe',
			nav: true,
			bullets: false,
			lazyLoad: true,
			autoDestroy: true,
			layout: {
				arrowPrevContent: 'Prev',
				arrowNextContent: 'Next',
			},
			breakPoints: {
	      768: {
	        items: 8,
	      }
	    },
	    onInited: function(){
	    	var $a = 0;
	    	var $bulletBtn = $neighborhoodSlider.find(".gs-bullet");
	    	if($bulletBtn.length){
					$bulletBtn.each(function() {
						$a += 1;
						$(this).text('View Slide '+$a);
					});
	    	}
	    },
			onResized: function(){
	    	var $a = 0;
	    	var $bulletBtn = $neighborhoodSlider.find(".gs-bullet");
	    	if($bulletBtn.length){
					$bulletBtn.each(function() {
						$a += 1;
						$(this).text('View Slide '+$a);
					});
	    	}
	    }
		});
	}

})(jQuery);

function idxloadSliderneighborhoods(elemento){
	var $sliderNeigh = elemento;
	if ($sliderNeigh.length) {
		$sliderNeigh.greatSlider({
			type: 'swipe',
			nav: true,
			bullets: false,
			layout: {
				arrowDefaultStyles: false,

				arrowPrevContent: 'Prev',
				arrowNextContent: 'Next',
			},
			breakPoints: {
				768: {
					destroy: true
				}
			},
	    onInited: function(){
	    	var $a = 0;
	    	var $bulletBtn = $sliderNeigh.find(".gs-bullet");
	    	if($bulletBtn.length){
					$bulletBtn.each(function() {
						$a += 1;
						$(this).text('View Slide '+$a);
					});
	    	}
	    },
			onResized: function(){
	    	var $a = 0;
	    	var $bulletBtn = $sliderNeigh.find(".gs-bullet");
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

function loadFullSlider(elemento){
	var $fullSliderModal = $(elemento);
	if($fullSliderModal.length) {
		$fullSliderModal.greatSlider({
			type: 'swipe',
			nav: true,
			navSpeed: 500,
			lazyLoad: true,
			bullets: false,
			items: 1,
			fullscreen: true,
			autoHeight: false,
			layout: {
				arrowDefaultStyles: false,

				arrowPrevContent: 'Prev',
				arrowNextContent: 'Next',
			},
			breakPoints: {
	      640: {
	      	//itemsInFs: 1,
	        items: 2
	      },
	      1024: {
	      	//itemsInFs: 1,
	        items: 3
	      }
	    },
	    onInited: function(){
	    	var $showSlider = $fullSliderModal.parents('#full-slider');
	    	if($showSlider.length){
	    		$showSlider.addClass('show-slider-psl');
	    	}

	    	var $a = 0;
	    	var $bulletBtn = $fullSliderModal.find(".gs-bullet");
	    	if($bulletBtn.length){
					$bulletBtn.each(function() {
						$a += 1;
						$(this).text('View Slide '+$a);
					});
	    	}
	    },
			onResized: function(){
	    	var $a = 0;
	    	var $bulletBtn = $fullSliderModal.find(".gs-bullet");
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
