function idxloadSliderneighborhoods(e){var l=e;l.length&&l.greatSlider({type:"swipe",nav:!0,bullets:!1,layout:{arrowDefaultStyles:!1,arrowPrevContent:"Prev",arrowNextContent:"Next"},breakPoints:{768:{destroy:!0}},onInited:function(){var e=0,t=l.find(".gs-bullet");t.length&&t.each(function(){e+=1,$(this).text("View Slide "+e)})},onResized:function(){var e=0,t=l.find(".gs-bullet");t.length&&t.each(function(){e+=1,$(this).text("View Slide "+e)})}})}function loadFullSlider(e){var l=$(e);l.length&&l.greatSlider({type:"swipe",nav:!0,navSpeed:500,lazyLoad:!0,bullets:!1,items:1,fullscreen:!0,autoHeight:!1,layout:{arrowDefaultStyles:!1,arrowPrevContent:"Prev",arrowNextContent:"Next"},breakPoints:{640:{items:2},1024:{items:3}},onInited:function(){var e=l.parents("#full-slider"),t=(e.length&&e.addClass("show-slider-psl"),0),e=l.find(".gs-bullet");e.length&&e.each(function(){t+=1,$(this).text("View Slide "+t)})},onResized:function(){var e=0,t=l.find(".gs-bullet");t.length&&t.each(function(){e+=1,$(this).text("View Slide "+e)})}})}!function(n){const l=n("#lgr-neighborhoods-slider");l.length&&l.greatSlider({type:"swipe",nav:!0,bullets:!1,layout:{arrowDefaultStyles:!1,arrowPrevContent:"Prev",arrowNextContent:"Next"},breakPoints:{768:{destroy:!0}},onInited:function(){var e=0,t=l.find(".gs-bullet");t.length&&t.each(function(){e+=1,n(this).text("View Slide "+e)})},onResized:function(){var e=0,t=l.find(".gs-bullet");t.length&&t.each(function(){e+=1,n(this).text("View Slide "+e)})}});let i=n(".mg-sliderneighborhoods");i.length&&i.greatSlider({type:"swipe",bullets:!1,nav:!0,lazyLoad:!0,layout:{bulletDefaultStyles:!1,arrowPrevContent:"Prev",arrowNextContent:"Next"},breakPoints:{768:{destroy:!0}},onDestroyed:()=>{setTimeout(()=>{i.find(".gs-lazy").each(function(){var e=n(this).attr("data-lazy");void 0!==e&&n(this).attr("src",e).removeAttr("data-lazy")})},1e3)},onInited:function(){var e=0,t=i.find(".gs-bullet");t.length&&t.each(function(){e+=1,n(this).text("View Slide "+e)})},onResized:function(){var e=0,t=i.find(".gs-bullet");t.length&&t.each(function(){e+=1,n(this).text("View Slide "+e)})}});var e,t,s,a=n(".clidxboost-main-slider"),o=(a.length&&a.greatSlider({type:"fade",nav:!1,lazyLoad:!0,bullets:!0,autoHeight:!1,layout:{bulletDefaultStyles:!1,wrapperBulletsClass:"clidxboost-gs-wrapper-bullets",arrowPrevContent:"Prev",arrowNextContent:"Next"},onInited:function(){var e=0,t=a.find(".gs-bullet");t.length&&t.each(function(){e+=1,n(this).text("View slide "+e)})},onResized:function(){var e=0,t=a.find(".gs-bullet");t.length&&t.each(function(){e+=1,n(this).text("View Slide "+e)})}}),n(".clidxboost-properties-slider")),r=(o.length&&(t=o.parents(".featured-section").attr("data-item"),s=+o.parents(".featured-section").attr("auto-play"),e=o.parents(".featured-section").attr("speed-slider"),o.greatSlider({type:"swipe",nav:!0,navSpeed:500,lazyLoad:!0,bullets:!1,items:1,autoplay:""!==s&&0<s,autoplaySpeed:""!==e&&void 0!==e?+e:5e3,autoDestroy:!0,layout:{bulletDefaultStyles:!1,wrapperBulletsClass:"clidxboost-gs-wrapper-bullets",arrowPrevContent:"Prev",arrowNextContent:"Next",arrowDefaultStyles:!1},breakPoints:{640:{items:2,slideBy:2,nav:!1,bullets:!0},991:{items:3,slideBy:3},1360:{items:s=""!==t&&void 0!==t?+t:4,slideBy:s}},onStepStart:function(){n(".clidxboost-properties-slider").find(".flex-slider-current img").each(function(){var e;n(this).hasClass(".loaded")||(e=n(this).attr("data-original"),n(this).attr("data-was-processed","true").attr("src",e).addClass("initial loaded"))})},onInited:function(){var e=0,t=o.find(".gs-bullet");t.length&&t.each(function(){e+=1,n(this).text("View Slide "+e)})},onResized:function(){var e=0,t=o.find(".gs-bullet");t.length&&t.each(function(){e+=1,n(this).text("View Slide "+e)})}})),n(".clidxboost-testimonial-slider")),d=(r.length&&r.greatSlider({type:"swipe",nav:!1,bullets:!0,autoHeight:!0,autoDestroy:!0,layout:{bulletDefaultStyles:!1,wrapperBulletsClass:"clidxboost-gs-wrapper-bullets",arrowPrevContent:"Prev",arrowNextContent:"Next"},onInited:function(){var e=0,t=r.find(".gs-bullet");t.length&&t.each(function(){e+=1,n(this).text("View Slide "+e)})},onResized:function(){var e=0,t=r.find(".gs-bullet");t.length&&t.each(function(){e+=1,n(this).text("View Slide "+e)})}}),n(".clidxboost-full-slider").find("img"));if(d.length){const c=(d=n(".clidxboost-full-slider")).find(".img-slider").length;let i=d.greatSlider({type:"swipe",nav:!0,bullets:!1,lazyLoad:!0,navSpeed:150,fullscreen:!1,layout:{arrowDefaultStyles:!1,arrowPrevContent:"Prev",arrowNextContent:"Next"},breakPoints:{640:{items:2},768:{fullscreen:!0},1360:{items:3}},onInited:function(){var e=d.parents("#full-slider"),e=(e.length&&e.addClass("show-slider-psl"),n(window).width()),t=n(".clidxboost-full-slider").find(".gs-item-slider").length,l=(767<e&&d.find(".gs-item-slider").on("click",function(){i.fullscreen("in",n(this).index()+1)}),e<640&&t<2||639<e&&e<1360&&t<3||1359<e&&t<4?n(".clidxboost-full-slider").addClass("-control-nav"):n(".clidxboost-full-slider").removeClass("-control-nav"),0),e=d.find(".gs-bullet");e.length&&e.each(function(){l+=1,n(this).text("View Slide "+l)}),n("#full-slider").find(".ib-pvsinumber").length?n("#full-slider").find(".ib-pvsinumber").text(n("#full-slider").find(".gs-item-active").index()+1+" of "+c):n("#full-slider").find(".gs-container-items").append('<span class="ib-pvsinumber">'+(n("#full-slider").find(".gs-item-active").index()+1)+" of "+c+"</span>")},onResized:function(){var e=0,t=d.find(".gs-bullet"),t=(t.length&&t.each(function(){e+=1,n(this).text("View Slide "+e)}),n(window).width()),l=n(".clidxboost-full-slider").find(".gs-item-slider").length;t<640&&l<2||639<t&&t<1360&&l<3||1359<t&&l<4?n(".clidxboost-full-slider").addClass("-control-nav"):n(".clidxboost-full-slider").removeClass("-control-nav")},onFullscreenIn:()=>{d.find(".ib-pvsititle").length||d.find(".gs-container-items").append('<span class="ib-pvsititle">'+n(".title-page").text()+"</span>"),d.find(".gs-item-slider").length<2&&d.find(".gs-container-navs").css({display:"none"})},onStepEnd:(e,t)=>{n("#full-slider").find(".ib-pvsinumber").text(t+" of "+c)}})}else n(".clidxboost-full-slider").length&&!n("body").hasClass("flex-idx-building-template-default")&&(t=(e=n("#map-result")).attr("data-lat"),s=e.attr("data-lng"),0<t.length&&0<s.length?(n("#full-slider").addClass("show-slider-psl active"),e=n("#show-map"),t=n("#show-gallery"),e.length&&(e.trigger("click"),(s=n("#full-main")).length&&s.find(".showfriendEmail").attr("data-media","ib-pva-map")),t.length&&t.css({display:"none"})):n("#full-slider").css({display:"none"}));var u=n(".clidxboost-development"),f=(u.length&&u.greatSlider({type:"swipe",nav:!1,bullets:!0,lazyLoad:!0,layout:{bulletDefaultStyles:!1,arrowPrevContent:"Prev",arrowNextContent:"Next"},breakPoints:{640:{items:idx_develop_slider_item_mobile},991:{items:idx_develop_slider_item_medium},1280:{items:idx_develop_slider_item_large}},onInited:function(){var e=0,t=u.find(".gs-bullet");t.length&&t.each(function(){e+=1,n(this).text("View Slide "+e)})},onResized:function(){var e=0,t=u.find(".gs-bullet");t.length&&t.each(function(){e+=1,n(this).text("View Slide "+e)})}}),n("#neighborhood-shortcode"));f.length&&f.greatSlider({type:"swipe",nav:!0,bullets:!1,lazyLoad:!0,autoDestroy:!0,layout:{arrowPrevContent:"Prev",arrowNextContent:"Next"},breakPoints:{768:{items:8}},onInited:function(){var e=0,t=f.find(".gs-bullet");t.length&&t.each(function(){e+=1,n(this).text("View Slide "+e)})},onResized:function(){var e=0,t=f.find(".gs-bullet");t.length&&t.each(function(){e+=1,n(this).text("View Slide "+e)})}})}(jQuery);