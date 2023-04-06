var map,bounds;!function(P){view_grid_type="grid";var s,L,M,e,t,a,r,O=[],j=[],z=[],I=[],p=[],i=jQuery("body"),l=jQuery(window);function setupMapControls(){(e=document.createElement("div")).classList.add("flex-map-controls-ct"),(t=document.createElement("div")).classList.add("flex-map-zoomIn"),e.appendChild(t),(a=document.createElement("div")).classList.add("flex-map-zoomOut"),e.appendChild(a),google.maps.event.addDomListener(t,"click",handleZoomInButton),google.maps.event.addDomListener(a,"click",handleZoomOutButton),map.controls[google.maps.ControlPosition.TOP_RIGHT].push(e)}function handleZoomInButton(e){e.stopPropagation(),e.preventDefault(),map.setZoom(map.getZoom()+1)}function handleZoomOutButton(e){e.stopPropagation(),e.preventDefault(),map.setZoom(map.getZoom()-1)}function setupMarkers(e){if(arrayother=e,bounds=new google.maps.LatLngBounds,marker=[],property=[],row=null,s=0,(L=new InfoBubble({map:map,disableAutoPan:!0,shadowStyle:0,padding:0,borderRadius:0,borderWidth:0,disableAnimation:!0,maxWidth:380})).addListener("domready",function(){P(".ib-load-property-iw").on("click",function(e){e.preventDefault(),e.stopPropagation();var s,e=P(this).data("mls");"yes"===__flex_g_settings.anonymous?(P("#modal_login").addClass("active_modal").find("[data-tab]").removeClass("active"),P("#modal_login").addClass("active_modal").find("[data-tab]:eq(1)").addClass("active"),P("#modal_login").find(".item_tab").removeClass("active"),P("#tabRegister").addClass("active"),P("button.close-modal").addClass("ib-close-mproperty"),P(".overlay_modal").css("background-color","rgba(0,0,0,0.8);"),P("#modal_login h2").html(P("#modal_login").find("[data-tab]:eq(1)").data("text-force")),s=P(".header-tab a[data-tab='tabRegister']").attr("data-text"),P("#modal_login .modal_cm .content_md .heder_md .ms-title-modal").html(s),localStorage.setItem("ib_anon_mls",e)):(P("html").addClass("modal_mobile"),P("#modal_property_detail").addClass("active_modal"),P("#modal_property_detail .detail-modal").html('<span class="ib-modal-property-loading">Loading property details...</span>'),P.ajax({type:"POST",url:__flex_g_settings.ajaxUrl,data:{mlsNumber:e,action:"load_modal_property"},success:function(e){P(document.body).addClass("modal-property-active"),P("#modal_property_detail .detail-modal").html(e)},complete:function(){P("#full-main #clidxboost-data-loadMore-niche").trigger("click"),loadFullSlider(".clidxboost-full-slider")}}))})}),null!=e){for(var s=0,t=e.length;s<t;s++)row=e[s],r=row.lat+":"+row.lng,-1===_.indexOf(j,r)&&(j.push(r),z.push(row));for(s=0,t=z.length;s<t;s++){row=z[s],r=[row.lat,row.lng];for(var a=[],i=0,l=e.length;i<l;i++)(inner=e[i]).lat==r[0]&&inner.lng==r[1]&&a.push(inner);I.push({item:row,group:a})}for(s=0;s<I.length;s++)property=I[s],(marker=new RichMarker({position:new google.maps.LatLng(parseFloat(property.item.lat),parseFloat(property.item.lng)),map:map,flat:!0,draggable:!1,content:1<property.group.length?'<div class="dgt-richmarker-group"><strong>'+property.group.length+"</strong><span>Units</span></div>":'<div class="dgt-richmarker-single"><strong>$'+_.formatShortPrice(property.item.price)+"</strong></div>",anchor:RichMarkerPosition.TOP})).geocode=property.item.lat+":"+property.item.lng,bounds.extend(marker.position),O.push(marker),google.maps.event.addListener(marker,"click",function handleMarkerClick(o,d,n){return function(){if(1<d.group.length){p.push('<div class="mapview-container">'),p.push('<div class="mapviwe-header">'),p.push("<h2>"+d.item.heading+"</h2>"),p.push('<span class="build">'+d.group.length+"</span>"),p.push('<button class="closeInfo"><span>'+word_translate.close+"</span></button>"),p.push("</div>"),p.push('<div class="mapviwe-body">');for(var e=0,s=d.group.length;e<s;e++){var t=d.group[e],a=(p.push('<div class="mapviwe-item">'),p.push('<h2 title="'+t.address_short.replace(/# /,"#")+'"><span>'+t.address_short.replace(/# /,"#")+"</span></h2>"),p.push("<ul>"),p.push('<li class="address"><span>'+t.address_large.replace(/ , /,", ")+"</span></li>"),p.push('<li class="price">$'+_.formatPrice(t.price)+"</li>"),word_translate.beds),i=word_translate.baths,a=1<t.bed?word_translate.beds:word_translate.bed,i=1<t.bath?word_translate.baths:word_translate.bath;p.push('<li class="beds"><b>'+t.bed+"</b> <span> "+a+"</span></li>"),p.push('<li class="baths"><b>'+t.bath+"</b> <span> "+i+"</span></li>"),p.push('<li class="living-size"> <span>'+_.formatPrice(t.sqft)+"</span> Sq.Ft.<span>("+t.living_size_m2+" m²)</span></li>"),p.push('<li class="price-sf"><span>$'+t.price_sqft+" </span>/ Sq.Ft.<span>($"+t.price_sqft_m2+" m²)</span></li>"),p.push("</ul>"),p.push('<div class="mapviwe-img">'),__flex_g_settings.hasOwnProperty("board_info")&&__flex_g_settings.board_info.hasOwnProperty("board_logo_url")&&!["",null,void 0,"undefined","null"].includes(__flex_g_settings.board_info.board_logo_url)?p.push('<img title="'+t.address_short.replace(/# /,"#")+", "+t.address_large.replace(/ , /,", ")+'" alt="'+t.address_short.replace(/# /,"#")+", "+t.address_large.replace(/ , /,", ")+'" src="'+t.gallery[0]+'"><img src="'+__flex_g_settings.board_info.board_logo_url+'" style="position: absolute;bottom: 10px;z-index: 2;width: 80px;right: 10px;height:auto">'):p.push('<img title="'+t.address_short.replace(/# /,"#")+", "+t.address_large.replace(/ , /,", ")+'" alt="'+t.address_short.replace(/# /,"#")+", "+t.address_large.replace(/ , /,", ")+'" src="'+t.gallery[0]+'">'),p.push("</div>"),p.push('<a class="ib-load-property-iw" data-mls="'+t.mls_num+'" href="'+flex_idx_sold_statistics.propertyDetailPermalink+"/"+t.slug+'" title="'+t.address_short.replace(/# /,"#")+", "+t.address_large.replace(/ , /,", ")+'">'+t.address_short.replace(/# /,"#")+", "+t.address_large.replace(/ , /,", ")+"</a>"),p.push("</div>")}}else{var l="",l=("1"==d.item.is_rental&&(l="/"+word_translate.month),p.push('<div class="mapview-container">'),p.push('<div class="mapviwe-header">'),p.push("<h2>"+d.item.heading+"</h2>"),p.push('<button class="closeInfo"><span>'+word_translate.close+"</span></button>"),p.push("</div>"),p.push('<div class="mapviwe-body">'),p.push('<div class="mapviwe-item">'),p.push('<h2 title="'+d.item.address_short.replace(/# /,"#")+'"><span>'+d.item.address_short.replace(/# /,"#")+"</span></h2>"),p.push("<ul>"),p.push('<li class="address"><span>'+d.item.address_large.replace(/ , /,", ")+"</span></li>"),p.push('<li class="price">$'+_.formatPrice(d.item.price)+l+"</li>"),word_translate.beds),r=word_translate.baths,l=1<d.item.bed?word_translate.beds:word_translate.bed,r=1<d.item.bath?word_translate.baths:word_translate.bath;p.push('<li class="beds"><b>'+d.item.bed+"</b> <span> "+l+"</span></li>"),p.push('<li class="baths"><b>'+d.item.bath+"</b> <span> "+r+"</span></li>"),p.push('<li class="living-size"> <span>'+_.formatPrice(d.item.sqft)+"</span> Sq.Ft.<span>("+d.item.living_size_m2+" m²)</span></li>"),p.push('<li class="price-sf"><span>$'+d.item.price_sqft+" </span>/ Sq.Ft.<span>($"+d.item.price_sqft_m2+" m²)</span></li>"),p.push("</ul>"),p.push('<div class="mapviwe-img">'),__flex_g_settings.hasOwnProperty("board_info")&&__flex_g_settings.board_info.hasOwnProperty("board_logo_url")&&!["",null,void 0,"undefined","null"].includes(__flex_g_settings.board_info.board_logo_url)?p.push('<img title="'+d.item.address_short.replace(/# /,"#")+", "+d.item.address_large.replace(/ , /,", ")+'" alt="'+d.item.address_short.replace(/# /,"#")+", "+d.item.address_large.replace(/ , /,", ")+'" src="'+d.item.gallery[0]+'"><img src="'+__flex_g_settings.board_info.board_logo_url+'" style="position: absolute;bottom: 10px;z-index: 2;width: 80px;right: 10px;height:auto">'):p.push('<img title="'+d.item.address_short.replace(/# /,"#")+", "+d.item.address_large.replace(/ , /,", ")+'" alt="'+d.item.address_short.replace(/# /,"#")+", "+d.item.address_large.replace(/ , /,", ")+'" src="'+d.item.gallery[0]+'">'),p.push("</div>"),p.push('<a class="ib-load-property-iw" data-mls="'+d.item.mls_num+'" href="'+flex_idx_sold_statistics.propertyDetailPermalink+"/"+d.item.slug+'" title="'+d.item.address_short.replace(/# /,"#")+", "+d.item.address_large.replace(/ , /,", ")+'">'+d.item.address_short.replace(/# /,"#")+", "+d.item.address_large.replace(/ , /,", ")+"</a>"),p.push("</div>")}p.push("</div>"),p.push("</div>"),p.length&&(L.setContent(p.join("")),L.open(n,o),p.length=0)}}(marker,property,map)),google.maps.event.addListener(marker,"mouseover",function handleMarkerMouseOver(e){return function(){e.setZIndex(google.maps.Marker.MAX_ZINDEX+1)}}(marker)),google.maps.event.addListener(marker,"mouseout",function handleMarkerMouseOut(e){return function(){e.setZIndex(google.maps.Marker.MAX_ZINDEX-1)}}(marker))}void 0!==map&&map.fitBounds(bounds)}function idx_search_filter(){var e=flex_idx_sold_statistics.class_form,b=(P(".flex-idx-filter-form-"+e).attr("class"),".flex-idx-filter-form-"+flex_idx_sold_statistics.class_form),y=".idxboost-content-filter-"+e+" #nav-results",C=".idxboost-content-filter-"+e+" #result-search",k=P("input[name='idx[oh]']").val();void 0!==s&&s.abort(),s=P.ajax({url:flex_idx_sold_statistics.ajaxUrl,method:"POST",data:{action:"flex_statistics_filter_sold",class_id:flex_idx_sold_statistics.class_id,city_id:flex_idx_sold_statistics.city_id,price_min:flex_idx_sold_statistics.price_min,price_max:flex_idx_sold_statistics.price_max,property_type:flex_idx_sold_statistics.property_type,property_style:flex_idx_sold_statistics.property_style,page:flex_idx_sold_statistics.page,order:flex_idx_sold_statistics.sort,close_date_start:flex_idx_sold_statistics.close_date_start,close_date_end:flex_idx_sold_statistics.close_date_end},dataType:"json",success:function(e){"yes"===__flex_g_settings.anonymous&&(s={search_url:location.href,search_count:e.counter,name:e.title,search_query:e.condition},localStorage.setItem("IB_SAVE_FILTER_PAYLOAD",JSON.stringify(s)));var s=e.items,t=[],a=[],i=e.pagination;if("undefined"!=typeof dataLayer&&__flex_g_settings.hasOwnProperty("has_dynamic_ads")&&"1"==__flex_g_settings.has_dynamic_ads&&"undefined"!=typeof dataLayer&&e.hasOwnProperty("items")&&e.items.length){for(var l=_.pluck(e.items,"mls_num"),r=[],o=0,d=l.length;o<d;o++)r.push({id:l[o],google_business_vertical:"real_estate"});r.length&&(dataLayer.push({event:"view_item_list",items:r}),r.length=0)}for(o=0,d=s.length;o<d;o++){var n=e.items[o],p=(""!=n.address_short&&null!=n.address_short&&(n.address_short=n.address_short.replace(/# /,"#")),""!=n.address_large&&null!=n.address_large&&(n.address_large=n.address_large.replace(/ , /,", ")),""),c=("1"==n.is_rental&&(p="/"+word_translate.month),n.address_large.split(", ")),m=(c[1].replace(/[\d\s]/g,""),n.address_short,c[0],n.address_short,c[0],c[1],""),c=(null!=n.address_short&&""!=n.address_short&&(m=" <span>"+n.address_short.replace(/# /,"#")+", "+c[0]+", "+c[1]+"</span>"),t.push('<li data-geocode="'+n.lat+":"+n.lng+'" data-class-id="'+n.class_id+'" data-mls="'+n.mls_num+'" data-address="'+n.address_short+'" class="propertie">'),n.hasOwnProperty("status")?"5"==n.status?t.push('<div class="flex-property-new-listing">'+word_translate.rented+"</div>"):"2"==n.status?t.push('<div class="flex-property-new-listing">'+word_translate.sold+"</div>"):"1"!=n.status&&t.push('<div class="flex-property-new-listing">'+n.status_name+"</div>"):"yes"===n.recently_listed&&t.push('<div class="flex-property-new-listing">'+word_translate.new_listing+"</div>"),"1"==view_grid_type?t.push('<h2 title="'+n.full_address+'" class="ms-property-address"><div class="ms-title-address -address-top">'+n.full_address_top+'</div><div class="ms-br-line">,</div><div class="ms-title-address -address-bottom">'+n.full_address_bottom+"</div></h2>"):t.push('<h2 title="'+n.full_address+'" class="ms-property-address"><div class="ms-title-address -address-top">'+n.full_address+"</div></h2>"),t.push('<ul class="features">'),t.push('<li class="address">'+m+"</li>"),t.push('<li class="price">$'+_.formatPrice(n.price)+p+"</li>"),""==n.reduced?t.push('<li class="pr">'+n.reduced+"</li>"):n.reduced<0?t.push('<li class="pr down">'+n.reduced+"%</li>"):t.push('<li class="pr up">'+n.reduced+"%</li>"),word_translate.bed),c=1<n.bed?word_translate.beds:word_translate.bed,p=(t.push('<li class="beds">'+n.bed+" <span>"+c+" </span></li>"),word_translate.bath),p=1<n.bath?word_translate.baths:word_translate.bath,c=(0<n.baths_half?t.push('<li class="baths">'+n.bath+".5 <span>"+p+" </span></li>"):t.push('<li class="baths">'+n.bath+" <span>"+p+" </span></li>"),t.push('<li class="living-size"> <span>'+_.formatPrice(n.sqft)+"</span>"+word_translate.sqft+" <span>("+n.living_size_m2+" m²)</span></li>"),t.push('<li class="price-sf"><span>$'+n.price_sqft+" </span>/ "+word_translate.sqft+"<span>($"+n.price_sqft_m2+" m²)</span></li>"),""!==n.development?t.push('<li class="development"><span>'+n.development+"</span></li>"):""!==n.complex?t.push('<li class="development"><span>'+n.complex+"</span></li>"):t.push('<li class="development"><span>'+n.subdivision+"</span></li>"),t.push("</ul>"),"");n.gallery.length<=1&&(c="no-zoom"),t.push('<div class="wrap-slider '+c+'">'),t.push("<ul>");for(var u=0,h=n.gallery.length;u<h;u++)t.push(u<=0?'<li class="flex-slider-current"><img class="flex-lazy-image" data-original="'+n.gallery[u]+'"></li>':'<li class="flex-slider-item-hidden"><img class="flex-lazy-image" data-original="'+n.gallery[u]+'"></li>');t.push("</ul>"),1<n.gallery.length&&(t.push('<button class="prev flex-slider-prev"><span class="clidxboost-icon-arrow-select"></span></button>'),t.push('<button class="next flex-slider-next"><span class="clidxboost-icon-arrow-select"></span></button>')),t.push("</div>"),t.push('<a href="'+flex_idx_sold_statistics.propertyDetailPermalink+"/"+n.slug+'" class="view-detail">'+m+"</a>"),t.push('<a class="view-map-detail" data-geocode="'+n.lat+":"+n.lng+'">View Map</a>'),"1"!=k||!n.hasOwnProperty("oh_info")||"object"==typeof(p=JSON.parse(n.oh_info))&&p.hasOwnProperty("date")&&p.hasOwnProperty("timer")&&t.push('<div class="ms-open"><span class="ms-wrap-open"><span class="ms-open-title">Open House</span><span class="ms-open-date">'+p.date+'</span><span class="ms-open-time">'+p.timer+"</span></span></div>"),t.push("</li>")}if(P(C).html(t.join("")).ready(function(){idxboostTypeIcon(),"function"==typeof ppchack&&ppchack(),"function"==typeof idxboost_Hackedbox_cpanel&&idxboost_Hackedbox_cpanel()}),1<i.total_pages_count){a.push('<span id="indicator">'+word_translate.page+" "+i.current_page_number+" "+word_translate.of+" "+_.formatPrice(i.total_pages_count)+"</span>"),i.has_prev_page&&1<i.total_pages_count&&(a.push('<a href="#" data-page="1" title="First Page" id="firstp" class="ad visible">'),a.push('<span class="clidxboost-icon-arrow-select"></span>'),a.push('<span class="clidxboost-icon-arrow-select"></span>'),a.push("<span>First page</span>"),a.push("</a>")),i.has_prev_page&&(a.push('<a href="#" data-page="'+(i.current_page_number-1)+'" title="Prev Page" id="prevn" class="arrow clidxboost-icon-arrow-select prevn visible">'),a.push("<span>Previous page</span>"),a.push("</a>")),a.push('<ul id="principal-nav">');for(o=0,d=i.range.length;o<d;o++){var g=i.range[o];i.current_page_number===g?a.push('<li class="active"><a href="#" data-page="'+g+'">'+g+"</a></li>"):a.push('<li><a href="#" data-page="'+g+'">'+g+"</a></li>")}a.push("</ul>"),i.has_next_page&&(a.push('<a href="#" data-page="'+(i.current_page_number+1)+'" title="Prev Page" id="nextn" class="arrow clidxboost-icon-arrow-select nextn visible">'),a.push("<span>Next page</span>"),a.push("</a>")),i.has_next_page&&1<i.total_pages_count&&(a.push('<a href="#" data-page="'+i.total_pages_count+'" title="First Page" id="lastp" class="ad visible">'),a.push('<span class="clidxboost-icon-arrow-select"></span>'),a.push('<span class="clidxboost-icon-arrow-select"></span>'),a.push("<span>Last page</span>"),a.push("</a>"))}P(y).html(a.join("")),P(".flex-loading-ct").fadeIn();P("#search_count").val(e.counter),idxboostcondition=e.condition,P(b+" #flex-idx-search-form").data("save_count",e.counter),P(b+" #flex-idx-search-form").data("next_page",e.pagination.has_next_page),P(b+" #flex-idx-search-form").data("current_page",e.pagination.current_page_number),void 0!==L&&L.isOpen()&&L.close(),idx_param_url=[];var f,v,s=0,x=0,s=(""!=flex_idx_sold_statistics.price_min&&(s=parseInt(flex_idx_sold_statistics.price_min)),(x=""!=flex_idx_sold_statistics.price_max?parseInt(flex_idx_sold_statistics.price_max):x)<s&&(s=0,x=1e6),idx_param_url.push("price="+s+"~"+x),""!=flex_idx_sold_statistics.city_id&&idx_param_url.push("city="+flex_idx_sold_statistics.city_id),""!=flex_idx_sold_statistics.class_id&&idx_param_url.push("property_type="+flex_idx_sold_statistics.class_id),""!=flex_idx_sold_statistics.property_style&&idx_param_url.push("property_style="+flex_idx_sold_statistics.property_style),""!=flex_idx_sold_statistics.page&&idx_param_url.push("page="+flex_idx_sold_statistics.page),""!=flex_idx_sold_statistics.sort&&idx_param_url.push("sort=price-desc"),0),x=0,w=(""!=flex_idx_sold_statistics.close_date_start&&(s=parseInt(flex_idx_sold_statistics.close_date_start)),(x=""!=flex_idx_sold_statistics.close_date_end?parseInt(flex_idx_sold_statistics.close_date_end):x)<s&&((v=new Date).getMonth()+1<10&&(f="0"+(v.getMonth()+1)),f=v.getFullYear()+f+v.getDate(),w=(v=function add_months(e,s){return new Date(e.setMonth(e.getMonth()+s))}(v=new Date,-6)).getMonth()+1<10?"0"+(v.getMonth()+1):v.getMonth()+1,s=v.getFullYear()+""+w+v.getDate(),x=f),idx_param_url.push("close_date="+s+"~"+x),flex_idx_sold_statistics.wpsite+"?"+idx_param_url.join("&"));history.pushState(null,"",w),P("#wrap-list-result").show(),P("#paginator-cnt").show(),jQuery("#form-save .list-check .flex-save-type-options").removeAttr("disabled"),P(".wrap-result").hasClass("view-map")&&P("#wrap-list-result").scrollTop(0),function removeMarkers(){if(j.length&&(j.length=0),z.length&&(z.length=0),I.length&&(I.length=0),O.length){for(var e=0,s=O.length;e<s;e++)O[e].setMap(null);O.length=0}}(),setupMarkers(e.map_items),void 0!==M&&M.update(),function setInitialStateSlider(){P("#wrap-result").find(".wrap-slider > ul li:first").each(function(){P(this).addClass("flex-slider-current")})}()}})}P(document).ready(function(){idx_search_filter()}),google.maps.event.addDomListener(window,"load",function initialize(){var e=[];null!=style_map_idxboost&&""!=style_map_idxboost&&(e=JSON.parse(style_map_idxboost)),void 0===M&&(M=new LazyLoad({elements_selector:".flex-lazy-image",callback_load:function(){},callback_error:function(e){P(e).attr("src","https://idxboost.com/i/default_thumbnail.jpg").removeClass("error").addClass("loaded"),P(e).attr("data-origin","https://idxboost.com/i/default_thumbnail.jpg")}})),map=new google.maps.Map(document.getElementById("code-map"),{center:new google.maps.LatLng(25.76168,-80.19179),mapTypeId:google.maps.MapTypeId.ROADMAP,zoom:16,disableDoubleClickZoom:!0,scrollwheel:!1,panControl:!1,streetViewControl:!1,disableDefaultUI:!0,clickableIcons:!1,styles:e,gestureHandling:"1"==__flex_g_settings.is_mobile?"greedy":"cooperative"}),google.maps.event.addListenerOnce(map,"tilesloaded",setupMapControls)}),P(".f-pricerange").change(function(){var e=P(this).val();"1"==e?(flex_idx_sold_statistics.price_min=0,flex_idx_sold_statistics.price_max=1e6):"2"==e?(flex_idx_sold_statistics.price_min=1000001,flex_idx_sold_statistics.price_max=2e6):"3"==e?(flex_idx_sold_statistics.price_min=2000001,flex_idx_sold_statistics.price_max=3e6):"4"==e?(flex_idx_sold_statistics.price_min=3000001,flex_idx_sold_statistics.price_max=5e6):"5"==e?(flex_idx_sold_statistics.price_min=5000001,flex_idx_sold_statistics.price_max=75e5):"6"==e?(flex_idx_sold_statistics.price_min=7500001,flex_idx_sold_statistics.price_max=1e8):"7"==e&&(flex_idx_sold_statistics.price_min=0,flex_idx_sold_statistics.price_max=1e8),flex_idx_sold_statistics.page=1,idx_search_filter()}),P(".f-neighborhood").change(function(){flex_idx_sold_statistics.city_id=P(this).val(),flex_idx_sold_statistics.page=1,idx_search_filter()}),P(".f-ptype").change(function(){flex_idx_sold_statistics.class_id=P(this).val(),flex_idx_sold_statistics.page=1,idx_search_filter()}),P(".js-pstyle").click(function(){var e="regular";jQuery("#regular").is(":checked")&&(e="regular"),jQuery("#new").is(":checked")&&(e="new"),jQuery("#no_waterfront").is(":checked")&&(e="no_waterfront"),jQuery("#waterfront").is(":checked")&&(e="waterfront"),flex_idx_sold_statistics.property_style=e,flex_idx_sold_statistics.page=1,idx_search_filter()}),P(".flex_idx_sort").change(function(){flex_idx_sold_statistics.sort=P(this).val(),flex_idx_sold_statistics.page=1,idx_search_filter()}),P(document).on("click",".flex-slider-prev",function(e){e.stopPropagation();var e=P(this).prev().find("li.flex-slider-current").index(),s=P(this).prev().find("li").length,e=0===e?s-1:e-1;P(this).prev().find("li").removeClass("flex-slider-current"),P(this).prev().find("li").addClass("flex-slider-item-hidden"),P(this).prev().find("li").eq(e).removeClass("flex-slider-item-hidden").addClass("flex-slider-current"),M.update()}),P(document).on("click",".flex-slider-next",function(e){e.stopPropagation();e=P(this).prev().prev().find("li.flex-slider-current").index();P(this).prev().prev().find("li").length-1<=e?e=0:e+=1,P(this).prev().prev().find("li").removeClass("flex-slider-current"),P(this).prev().prev().find("li").addClass("flex-slider-item-hidden"),P(this).prev().prev().find("li").eq(e).removeClass("flex-slider-item-hidden").addClass("flex-slider-current"),M.update()}),(flex_pagination=P(".nav-results")).length&&flex_pagination.on("click","a",function(e){e.preventDefault();e=P(this).data("page");currentfiltemid=P(this).parent("li").parent("ul").parent("nav").attr("filtemid"),"nextn"!=P(this).attr("id")&&"lastp"!=P(this).attr("id")&&"firstp"!=P(this).attr("id")&&"prevn"!=P(this).attr("id")||(currentfiltemid=P(this).parent("nav").attr("filtemid")),P(".nav-results-"+currentfiltemid+" ul#principal-nav li").removeClass("active"),P(".nav-results-"+currentfiltemid+" ul#principal-nav #page_"+e).addClass("active"),flex_idx_sold_statistics.page=e,idx_search_filter()}),(view_options=P(".filter-views li")).length&&view_options.on("click",function(){currentfiltemid=P(this).attr("filtemid"),P(this).hasClass("active")||(P(this).html().toLowerCase(),sort_options.val())});var o,d,n=P(".filter-views");{function mutaSelectViews(e){var s,t;e?n.find("ul").length||(e=n.find("option:selected").val(),n.find("option").each(function(){P(this).replaceWith('<li class="'+P(this).val()+'">'+P(this).text()+"</li>")}),(s=n.find("select")).replaceWith("<ul>"+s.html()+"</ul>"),n.find("."+e).addClass("active"),n.removeClass(e)):n.find("select").length||(s=n.find(".active").index(),e=n.find(".active").attr("class").split(" ")[0],n.find("li").each(function(){P(this).replaceWith('<option value="'+P(this).attr("class").split(" ")[0]+'">'+P(this).text()+"</option>")}),(t=n.find("ul")).replaceWith("<select>"+t.html()+"</select>"),n.find("option").eq(s).prop("selected",!0).siblings().prop("selected",!1),n.addClass(e))}n.length&&(o=P(".wrap-result"),n.on("change","select",function(){switch(P(this).find("option:selected").val()){case"grid":n.removeClass("list map").addClass("grid"),o.removeClass("view-list view-map").addClass("view-grid"),i.removeClass("view-list view-map"),P("#idx_view").val("grid");break;case"list":n.removeClass("grid map").addClass("list"),o.removeClass("view-grid view-map").addClass("view-list"),i.addClass("view-list").removeClass("view-map"),P("#idx_view").val("list");break;case"map":n.removeClass("list grid").addClass("map"),o.removeClass("view-list view-grid").addClass("view-map"),i.removeClass("view-list").addClass("view-map"),P("#idx_view").val("map"),google.maps.event.trigger(map,"resize"),setTimeout(function(){map.getCenter(),map.getZoom();google.maps.event.trigger(map,"resize");for(var e=new google.maps.LatLngBounds,s=0,t=O.length;s<t;s++)e.extend(O[s].position);map.fitBounds(e)},1e3)}new LazyLoad({callback_error:function(e){P(e).attr("src","https://idxboost.com/i/default_thumbnail.jpg").removeClass("error").addClass("loaded"),P(e).attr("data-origin","https://idxboost.com/i/default_thumbnail.jpg")}})}),n.on("click","li",function(){switch(currentfiltemid=P(this).parent("ul").parent("li").attr("filtemid"),P(this).addClass("active").siblings().removeClass("active"),P(this).attr("class").split(" ")[0]){case"grid":P(".idxboost-content-filter-"+currentfiltemid+" ").find(o).removeClass("view-list view-map").addClass("view-grid"),i.removeClass("view-list view-map");break;case"list":P(".idxboost-content-filter-"+currentfiltemid+" ").find(o).removeClass("view-grid view-map").addClass("view-list"),i.addClass("view-list").removeClass("view-map");break;case"map":P(".idxboost-content-filter-"+currentfiltemid+" ").find(o).removeClass("view-list view-grid").addClass("view-map"),i.removeClass("view-list").addClass("view-map"),google.maps.event.trigger(map,"resize"),setTimeout(function(){map.getCenter(),map.getZoom();google.maps.event.trigger(map,"resize");for(var e=new google.maps.LatLngBounds,s=0,t=O.length;s<t;s++)e.extend(O[s].position);map.fitBounds(e)},1e3)}new LazyLoad({callback_error:function(e){P(e).attr("src","https://idxboost.com/i/default_thumbnail.jpg").removeClass("error").addClass("loaded"),P(e).attr("data-origin","https://idxboost.com/i/default_thumbnail.jpg")}})}),d=P("#wrap-list-result"),768<=l.width()&&mutaSelectViews(!0),l.on("resize",function(){var e=l.width();768<=e?mutaSelectViews(!0):e<768&&mutaSelectViews(!1)}))}function mutaSelectViews(e){var s,t;e?n.find("ul").length||(e=n.find("option:selected").val(),n.find("option").each(function(){P(this).replaceWith('<li class="'+P(this).val()+'">'+P(this).text()+"</li>")}),(s=n.find("select")).replaceWith("<ul>"+s.html()+"</ul>"),n.find("."+e).addClass("active"),n.removeClass(e)):n.find("select").length||(s=n.find(".active").index(),e=n.find(".active").attr("class").split(" ")[0],n.find("li").each(function(){P(this).replaceWith('<option value="'+P(this).attr("class").split(" ")[0]+'">'+P(this).text()+"</option>")}),(t=n.find("ul")).replaceWith("<select>"+t.html()+"</select>"),n.find("option").eq(s).prop("selected",!0).siblings().prop("selected",!1),n.addClass(e))}768<=l.width()&&mutaSelectViews(!0),l.on("resize",function(){var e=l.width();768<=e?mutaSelectViews(!0):e<768&&mutaSelectViews(!1)});var c=P("#map-actions");c.length&&c.on("click","button",function(){d.toggleClass("closed"),P(this).addClass("hide").siblings().removeClass("hide"),setTimeout(function(){google.maps.event.trigger(map,"resize"),setTimeout(function(){google.maps.event.trigger(map,"resize")},200)},100)}),P(document).click(function(e){P(".js-fc-dropdown").removeClass("show")}),P(".js-fc-dropdown").on("click",function(e){e.stopPropagation(),P(this).toggleClass("show")})}(jQuery);