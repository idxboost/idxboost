var myLazyLoad;!function(r){r(function(){"undefined"!=typeof LazyLoad&&(myLazyLoad=new LazyLoad({elements_selector:".flex-lazy-image",callback_load:function(){}}),r(document).on("click","li.grid",function(){myLazyLoad.update()}),r(".tabs-btn > li").on("click",function(){myLazyLoad.update()}),r(document).on("click",".flex-slider-prev",function(i){i.stopPropagation();var i=r(this).prev().find("li.flex-slider-current").index(),e=r(this).prev().find("li").length,i=0===i?e-1:i-1;r(this).prev().find("li").removeClass("flex-slider-current"),r(this).prev().find("li").addClass("flex-slider-item-hidden"),r(this).prev().find("li").eq(i).removeClass("flex-slider-item-hidden").addClass("flex-slider-current"),myLazyLoad.update()}),r(document).on("click",".flex-slider-next",function(i){i.stopPropagation();i=r(this).prev().prev().find("li.flex-slider-current").index();r(this).prev().prev().find("li").length-1<=i?i=0:i+=1,r(this).prev().prev().find("li").removeClass("flex-slider-current"),r(this).prev().prev().find("li").addClass("flex-slider-item-hidden"),r(this).prev().prev().find("li").eq(i).removeClass("flex-slider-item-hidden").addClass("flex-slider-current"),myLazyLoad.update()}))});var e,s,t=r("body"),a=r(window),l=(a.width(),r("html, body")),n=(a.on("load",function(){t.removeClass("loading")}),r("#filter-views"));function o(i){i?1024<=a.width()&&(s.hasClass("ps-container")||(s.perfectScrollbar({suppressScrollX:!0}),s.on("ps-y-reach-end",function(){s.hasClass("loading-more")||(s.addClass("loading-more"),console.log("ahora cargaré más ITEMS"))}))):s.hasClass("ps-container")&&s.perfectScrollbar("destroy")}function d(i){var e,s;i?n.find("ul").length||(i=n.find("option:selected").val(),n.find("option").each(function(){r(this).replaceWith('<li class="'+r(this).val()+'">'+r(this).text()+"</li>")}),(e=n.find("select")).replaceWith("<ul>"+e.html()+"</ul>"),n.find("."+i).addClass("active"),n.removeClass(i)):n.find("select").length||(e=n.find(".active").index(),i=n.find(".active").attr("class").split(" ")[0],n.find("li").each(function(){r(this).replaceWith('<option value="'+r(this).attr("class").split(" ")[0]+'">'+r(this).text()+"</option>")}),(s=n.find("ul")).replaceWith("<select>"+s.html()+"</select>"),n.find("option").eq(e).prop("selected",!0).siblings().prop("selected",!1),n.addClass(i))}n.length&&(e=r("#wrap-result"),n.on("change","select",function(){switch(r(this).find("option:selected").val()){case"grid":n.removeClass("list map").addClass("grid"),e.removeClass("view-list view-map").addClass("view-grid"),t.removeClass("view-list view-map");break;case"list":n.removeClass("grid map").addClass("list"),e.removeClass("view-grid view-map").addClass("view-list"),t.addClass("view-list").removeClass("view-map");break;case"map":n.removeClass("list grid").addClass("map"),e.removeClass("view-list view-grid").addClass("view-map"),t.removeClass("view-list").addClass("view-map")}}),n.on("click","li",function(){switch(r(this).addClass("active").siblings().removeClass("active"),r(this).attr("class").split(" ")[0]){case"grid":e.removeClass("view-list view-map").addClass("view-grid"),t.removeClass("view-list view-map"),o(!1);break;case"list":e.removeClass("view-grid view-map").addClass("view-list"),t.addClass("view-list").removeClass("view-map"),o(!1);break;case"map":e.removeClass("view-list view-grid").addClass("view-map"),t.removeClass("view-list").addClass("view-map"),o(!0)}}),s=r("#wrap-list-result"),768<=a.width()&&d(!0),a.on("resize",function(){var i=a.width();768<=i?d(!0):i<768&&d(!1)}));var c=r(".slider-generator");var p,h,v,u,m=null,f=null,C=(c.on("touchstart",".propertie",function(i){m=i.touches[0].clientX,f=i.touches[0].clientY}),c.on("touchmove",".propertie",function(i){var e,s;m&&f&&(e=i.touches[0].clientX,s=i.touches[0].clientY,e=m-e,s=f-s,Math.abs(e)>Math.abs(s)&&(i.preventDefault(),(0<e?r(this).find(".next"):r(this).find(".prev")).click()),f=m=null)}),r("#cities-list")),g=(C.length&&a.on("resize",function(){C.hasClass("ps-container")&&C.perfectScrollbar("update")}),r("#mini-filters")),b=(g.length&&g.find("h4").on("click",function(){var i=r(this).parents("li");i.toggleClass("expanded").siblings().removeClass("expanded"),i.hasClass("cities")&&!C.hasClass("ps-container")&&(setTimeout(function(){C.perfectScrollbar({suppressScrollX:!0,minScrollbarLength:"42"})},1e3*Number(i.css("transition-duration").replace("s",""))*2),k(i,C))}),r("#filters")),w=(b.length&&(p=r("#all-filters"),h=r("#wrap-filters"),b.on("click","button",function(){r("#mini-filters .price").addClass("expanded");var i=r(this).parent(),e=i.attr("class").split(" ")[0],s=g.find("li."+e);!s.length&&"all"!==e||(i.toggleClass("active").siblings().removeClass("active"),"all"===e?(p.hasClass("visible")?p.hasClass("individual")&&p.hasClass("visible")?p.removeClass("individual"):!p.hasClass("individual")&&p.hasClass("visible")&&p.removeClass("visible"):p.addClass("visible"),h.width()<=768&&(t.toggleClass("fixed"),e=h.position().top-Number(h.css("margin-top").replace("px","")),a.scrollTop()!==e&&l.animate({scrollTop:e},800),p.hasClass("ps-container")||setTimeout(function(){p.perfectScrollbar({suppressScrollX:!0,minScrollbarLength:"42"})},1e3*Number(p.css("transition-duration").replace("s",""))*2)),h.width()<=640?p.css({top:h.outerHeight()+h.position().top+"px",left:"0px",height:"calc(100vh - "+(h.outerHeight()+b.find("li.save").outerHeight())+"px)"}):640<h.width()&&h.width()<=768?p.hasClass("neighborhood")?(p.removeAttr("style"),console.log("Widt all filter: "+p.width()+" | position left clicked: "+i.position().left+" | Li clicked widht: "+i.width()),p.css({top:h.outerHeight()+"px",right:"0",left:"auto",transform:"none"})):p.css({left:"0px",top:h.outerHeight()+"px",height:"calc(100vh - "+(h.outerHeight()+v.outerHeight())+"px)"}):(p.removeAttr("style"),p.css("top",h.outerHeight()+"px"),k(p,C))):(t.hasClass("fixed")&&t.removeClass("fixed"),p.hasClass("ps-container")&&p.perfectScrollbar("destroy"),i.hasClass("active")?(s.addClass("visible").siblings().removeClass("visible"),p.hasClass("individual")||(p.addClass("individual"),p.css("height","auto")),p.hasClass("visible")||p.addClass("visible"),p.css({top:h.outerHeight()+"px",left:i.position().left+i.outerWidth()/2-150+"px"})):(p.removeClass("visible"),s.removeClass("visible"),i.removeClass("active"),setTimeout(function(){p.removeClass("individual")},1e3*Number(p.css("transition-duration").replace("s",""))))))}),(v=r("#apply-filters")).length&&v.on("click",function(){b.find(".all button").trigger("click")}),r(document).on("mouseup",function(i){!p.hasClass("visible")||h.is(i.target)||0!==h.has(i.target).length||b.find(".active button").trigger("click")}),b.find(".mini-search, .save").on("click",function(){p.hasClass("visible")&&b.find(".active button").trigger("click")})),r("#neighborhood-menu")),c=(w.length&&w.on("click","li",function(){w.toggleClass("active"),r(this).addClass("active").siblings().removeClass("active")}),r("#map-actions")),x=(c.length&&c.on("click","button",function(){s.toggleClass("closed"),r(this).addClass("hide").siblings().removeClass("hide")}),setTimeout(function(){var i,e,s,t,a,l,n=w.find("li"),o=n.length;o&&(i=0,n.each(function(){i+=r(this).outerWidth()}),e=i+Number(n.eq(0).css("margin-right").replace("px",""))*(o-1),s=w.find("ul"),t=Number(w.find(".gwr").width()),e<w.width()?(w.find("button").addClass("hide"),65<=Math.floor(100*e/t)&&s.addClass("flex")):(s.css("width",e+"px"),a=w.find(".next-item"),l=w.find(".prev-item"),a.on("click",function(){var i=n.eq(o-1);s.css("margin-left",t-i.position().left+i.width()+"px"),r(this).addClass("hide"),l.removeClass("hide")}),l.on("click",function(){s.css("margin-left","0"),r(this).addClass("hide"),a.removeClass("hide")})))},300),y(),a.resize(function(){y()}),r(".map-actions button"));void 0!==x&&x.on("click",function(){x.removeClass("no-show"),r(this).addClass("no-show"),r("#wrap-list-result").toggleClass("hidden-results")}),r("html");function y(){var i,e=r("#md-title");void 0!==e&&(i=r("#md-body").width(),e.css({width:i+"px"}))}function k(i,e){e.hasClass("ps-container")||setTimeout(function(){e.perfectScrollbar({suppressScrollX:!0,minScrollbarLength:"42"})},1e3*Number(i.css("transition-duration").replace("s",""))*2)}r(document).on("click",".close-div",function(){r(".modal-welcome-login").fadeOut()}),r(document).on("click",".tab-list li a",function(){var i=r(this).attr("data-tab");r(".tab-list li a").removeClass("active"),r(this).addClass("active"),r(".body-tabs .item-tab").hide(),r(".body-tabs "+i).fadeIn()}),r(document).on("click",".register",function(){r(".header-tab li a").removeClass("active"),r(".item_tab").removeClass("active"),r(".header-tab li a[data-tab='tabRegister']").addClass("active"),r("#tabRegister").addClass("active")}),r(document).on("click",".login",function(){r(".header-tab li a").removeClass("active"),r(".item_tab").removeClass("active"),r(".header-tab li a[data-tab='tabLogin']").addClass("active"),r("#tabLogin").addClass("active")}),(u=jQuery).extend(!0,u.ui.slider.prototype,{pips:function(e){options={first:"number",last:"number",rest:"pip"},u.extend(options,e),this.element.addClass("ui-slider-pips").find(".ui-slider-pip").remove();var s=this.options.max-this.options.min;for(i=0;i<=s;i++){var t=u('<span class="ui-slider-pip"><span class="ui-slider-line"></span><span class="ui-slider-number">'+i+"</span></span>");0==i?(t.addClass("ui-slider-pip-first"),"number"==options.first&&t.addClass("ui-slider-pip-number"),0==options.first&&t.addClass("ui-slider-pip-hide")):s==i?(t.addClass("ui-slider-pip-last"),"number"==options.last&&t.addClass("ui-slider-pip-number"),0==options.last&&t.addClass("ui-slider-pip-hide")):("number"==options.rest&&t.addClass("ui-slider-pip-number"),0==options.rest&&t.addClass("ui-slider-pip-hide")),"horizontal"==this.options.orientation?t.css({left:100/s*i+"%"}):t.css({top:100/s*i+"%"}),this.element.append(t)}}})}(jQuery);