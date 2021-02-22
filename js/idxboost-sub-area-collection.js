var obj_nav;

var listbedsold=[],listbedpending=[],listbedsale=[],listbedrent=[],responseitemsale=[],responseitempending=[],responseitemrent=[],responseitemsold=[],responseitemsalegrid='',responseitemrentgrid='',responseitemsoldgrid='',responseitemsoldpending='',myLazyLoad,auxscreensold=0,auxscreenrent=0,auxscreensale=0,auxscreenpending=0;
var temp_sale=[],temp_rent=[],temp_sold=[],temp_pending=[];
var tablasidx;
var idxarealimit={
  'sale':0,
  'rent':0,
  'pending':0,
  'sold':0,
  'limit':24

};

var avg_price_listing={
  sale:{avg:0,text:word_translate.average_listing_price},
  rent:{avg:0,text:word_translate.average_rental_price},
  pending:{avg:0,text:word_translate.average_pending_price},
  sold:{avg:0,text:word_translate.average_sold_price}
};
var status_xhmr={'xhr1':false,'xhr2':false};
var auxtextsalehtml='',auxtextrenthtml='',auxtextsoldhtml='',data_mls_sold=[];
var tab_idx=document.location.hash;
var textmp;
(function($) {

function ib_change_view_object_device(object,tabbuil,object_val){
  var viebuil='list';
  if (object.val() != undefined && object.val() !=0 ){
    viebuil=object.val();
  }else{
    if ( object.hasClass( "grid" ) ){
      viebuil='grid';
    }    
  }
  textmp=object;
  object_val.val(viebuil);
  
  //SE MOSTRARA LA VISTA LISTA O GRILLA
  ib_change_view( viebuil ,tabbuil );
}

function ib_change_avg_listing(obj_data){
  $('.ib_inventory_listing_price').html( '$'+_.formatShortPrice(Math.round(obj_data.avg)) );
  $('.ib_inventory_listing_text').text(obj_data.text);
}

function ib_change_view(view,tab){
  var property_type='';
  $=jQuery;
  /*BOTONES TABS*/
  ib_collection_desk_li=$('.idxboost-collection-show-desktop li');
  ib_collection_desk_li.removeClass('active');
  $('.nav_results_pag').removeClass('active');
  /*habilitar vista en desktop*/
  var builhash='';
  ib_collection_desk_li.each(function(){
    if ($(this).attr('fortab')==tab){
      $(this).addClass("active");
      $('.idxboost-collection-property-information li button').removeClass('active');
      property_type=$(this).attr('data-property');
      if (property_type=='sale'){
        builhash='#!for-sale';
        $('.filter-text').text('For Sale');
        $('#sale-count-uni-cons').addClass('active');
        $('#flex_filter_sort').val('sale');        
        $('.idx-group-subarea-sale').addClass('active');
        ib_change_avg_listing(avg_price_listing.sale);
      }else if(property_type=='rent') {
        builhash='#!for-rent';
        $('.filter-text').text('For Rent');
        $('#rent-count-uni-cons').addClass('active');
        $('#flex_filter_sort').val('rent');
        $('.idx-group-subarea-rent').addClass('active');
        ib_change_avg_listing(avg_price_listing.rent);
      }else if(property_type=='sold') {
        builhash='#!sold';
        $('.filter-text').text('Sold');
        $('#sold-count-uni-cons').addClass('active');
        $('#flex_filter_sort').val('sold');
        $('.idx-group-subarea-sold').addClass('active');
        ib_change_avg_listing(avg_price_listing.sold);
      }else if(property_type=='pending') {
        builhash='#!pending';
        $('.filter-text').text('Pending');
        $('#pending-count-uni-cons').addClass('active');
        $('#flex_filter_sort').val('pending');
        $('.idx-group-subarea-pending').addClass('active');
        ib_change_avg_listing(avg_price_listing.pending);
      }
      var boolcaracter=idxboost_collection_params.wpsite.substr(idxboost_collection_params.wpsite.length-1,idxboost_collection_params.wpsite.length);
      web_page=idxboost_collection_params.wpsite;
      if (boolcaracter=='/'){
        web_page=idxboost_collection_params.wpsite.slice(0,-1);
      }
      web_page=web_page;

      
      history.pushState(null, '', web_page );
    }
  });
  /*BOTONES TABS*/
  var view_active=property_type+'_'+view;
  /*ACTIVE EL CONTENT TO DESKTOP*/
  var objec_name_id='#view_'+view;
  $('.mode_view').hide();
  $(objec_name_id).show();
  if (view=='list'){
    var view_desk=$('#view_'+view).find('.item_view_db');
    view_desk.removeClass('active');
    view_desk.each(function(){
      if ($(this).attr('id')== view_active ){
        $(this).addClass("active");
      }
    });
  }else if(view=='grid'){
    $(objec_name_id).find('.result-search').removeClass('active');
    $(objec_name_id).find('.result-search').each(function(){
      if ($(this).attr('id')== tab ){
        $(this).addClass("active");
      }
    });
  }
  
  idxboosttabview();
}

function ib_generate_struct(response){
  
  if (status_xhmr.xhr1==false && status_xhmr.xhr2==false) {
    return false;
  }
  $('.js-available-homes').hide();

  if (response.success === true) {
    tot_sale=response.payload.properties.sale.count;
    tot_rent=response.payload.properties.rent.count;
    tot_pending=response.payload.properties.pending.count;
    tot_sold=data_mls_sold.count;
    tot_porc=jQuery('.item-list-units-un').text();
    tot_rest= parseInt(tot_porc)-tot_sale-tot_rent;
    tot_porc_label=tot_porc;

    if ( (tot_sale>0 || tot_rent>0 || tot_sold>0)  && response.payload.type_building =='0'){
      $('.idxboost-collection-show-desktop, .fbc-group, #filter-views, .ib_content_views_building, .idx-tab-building').attr('style','');
      if (tot_sale>0){
        $('.sale-count-uni-cons').parent('.sale').show();
        avg_price_listing.sale.avg=response.payload.properties.sale.items.map(function(item){ return parseFloat(item.price); }).reduce(function(tot,itera){ return tot+itera })/tot_sale;
        $('.js-available-homes').show();
      }else{
        $('#flex_filter_sort').find('option').each(function(keys_option){
          if($(this).val()=='sale')
            $(this).hide();
        });                                          
      }

      if (tot_pending>0){
        $('.pending-count-uni-cons').parent('.pending').show();
        avg_price_listing.pending.avg=response.payload.properties.pending.items.map(function(item){ return parseFloat(item.price); }).reduce(function(tot,itera){ return tot+itera })/tot_pending;
        $('.js-available-homes').show();
      }else{
        $('#flex_filter_sort').find('option').each(function(keys_option){
          if($(this).val()=='pending')
            $(this).hide();
        });
        $('.pending-count-uni-cons').parent('.pending').hide();
      }

      if (tot_sold>0){
        $('.sold-count-uni-cons').parent('.sold').show()
        avg_price_listing.sold.avg=data_mls_sold.items.map(function(item){ return parseFloat(item.price_sold); }).reduce(function(tot,itera){ return tot+itera })/tot_sold;
        $('.js-available-homes').show();
      }else{
        $('#flex_filter_sort').find('option').each(function(keys_option){
          if($(this).val()=='sold')
            $(this).hide();
        });                                          
      }

      if (tot_rent>0){
        $('.rent-count-uni-cons').parent('.rent').show();
        avg_price_listing.rent.avg=response.payload.properties.rent.items.map(function(item){ return parseFloat(item.price); }).reduce(function(tot,itera){ return tot+itera })/tot_rent;
        $('.js-available-homes').show();
      }else{
        $('#flex_filter_sort').find('option').each(function(keys_option){
          if($(this).val()=='rent')
            $(this).hide();
        });                                          
      }

    }else{
      $('.idx-tab-building').hide();
      $('.rent-count-uni-cons').parent('.rent').hide();
      $('.sold-count-uni-cons').parent('.sold').hide();
      $('.pending-count-uni-cons').parent('.pending').hide();
      $('.sale-count-uni-cons').parent('.sale').hide();
    }

    if(tot_sale>0){
      $('.ib_collection_tab').val('tab_sale');
      $('.flex-open-tb-sale').addClass('active-fbc');
    }else if (tot_rent>0){
      $('.ib_collection_tab').val('tab_rent');
      $('.flex-open-tb-rent').addClass('active-fbc');
    }else if (tot_sold>0){
      $('.ib_collection_tab').val('tab_sold');
      $('.flex-open-tb-sold').addClass('active-fbc');
    }else if (tot_pending>0){
      $('.ib_collection_tab').val('tab_pending');
      $('.flex-open-tb-pending').addClass('active-fbc');
    }


    console.log(response);
    var label_price='';
    var avg_price_sqft='';
    var building_avg_days="";
    if (
        (
          response.hasOwnProperty("payload") &&
          response.hasOwnProperty("meta")
        ) &&
        (
          response.payload.meta.sale_min_max_price.min != undefined && response.payload.meta.sale_min_max_price !='' && response.payload.type_building =='0'
        )
      ){
      $('.aside .property-information .price').show();
      label_price='$'+_.formatShortPrice(response.payload.meta.sale_min_max_price.min)+' '+word_translate.to+' '+'$'+_.formatShortPrice(response.payload.meta.sale_min_max_price.max);
      avg_price_sqft=response.payload.meta.avg_price_sqft;
      building_avg_days=response.payload.meta.building_avg_days;
      $('.property-information .price').html(label_price+"<span>"+word_translate.todays_prices+"</span>" );
      $('.ib_inventory_min_max_price').html(label_price );
      $('.js-building-price-range').val(label_price);
    }

    $('.ib_inventory_listing_price').html(label_price );
    $('.data-inventory').find('.cir-sta.sale').text(tot_sale);
    $('.data-inventory').find('.cir-sta.rent').text(tot_rent);

    var idx_porc_sale=0;
    var idx_porc_rent=0;
    var idx_porc_sold=0;

    if(tot_porc !='' && tot_porc!="0" ){
      idx_porc_sale=Math.round((tot_sale/tot_porc)*100);
      idx_porc_rent=Math.round((tot_rent/tot_porc)*100);
    }

    if($('.ib_building_unit').val() !='' && $('.ib_building_unit').val()!="0" ){
      idx_porc_sold=Math.round(tot_sold*100/parseInt($('.ib_building_unit').val()));
    }             
    $('.condo-statics .ib_inventory_sale').html( idx_porc_sale +'%' );
    $('.condo-statics .ib_inventory_rent').html( idx_porc_rent +'%' );
    $('.ib_inventory_avg_price').html( '$'+_.formatShortPrice(Math.round(avg_price_sqft)) );
    $('.condo-statics .ib_inventory_previous').html( idx_porc_sold +'%' );
    $('.ib_inventory_days_market').html(building_avg_days);                  
    $('.flex-open-tb-sale button, #sale-count-uni-cons').html(' '+tot_sale+'<span>'+word_translate.for_sale+'</span>');
    $('.flex-open-tb-rent button, #rent-count-uni-cons').html(' '+tot_rent+'<span>'+word_translate.for_rent+'</span>');
    $('.flex-open-tb-pending button, #pending-count-uni-cons').html(' '+tot_pending+'<span>'+word_translate.pending+'</span>');
    $('.flex-open-tb-sold button, #sold-count-uni-cons').html(' '+tot_sold+'<span>'+word_translate.sold+'</span>');
    
    if (response.payload.properties.sale.count==0){
      $('#flex_tab_sale, #sale-count-uni-cons').hide();
    }

    if (response.payload.properties.rent.count==0){
      $('#flex_tab_rent, #rent-count-uni-cons').hide();
    }
    
    if (response.payload.properties.pending.count==0){
      $('#flex_tab_pending, #pending-count-uni-cons').hide();
    }                  
    
    if (data_mls_sold.count==0){
      $('#flex_tab_sold, #sold-count-uni-cons').hide();
    }
    
    if(response.payload.meta != undefined && ( (tot_sale>0|| tot_rent>0) && response.payload.type_building =='0' ) ){
      $('.condo-statics').show();
    }

    chart_container_obj = $("#chart-container");
    if( (tot_sale>0|| tot_rent>0) && response.payload.type_building =='0' ){
      $('.wp-statisticss').show();
      if (chart_container_obj.length) {
        FusionCharts.ready(function () {
          var revenueChart = new FusionCharts({type: 'doughnut2d',renderAt: 'chart-container',width: 380,height: 250,events: { chartClick: { cancelled: true } },
            dataSource: {
              "chart": {"numberPrefix": "$","paletteColors": "#0072ac,#434343,#99999a","bgColor": "#ffffff","showBorder": "0","use3DLighting": "0","showShadow": "0","enableSmartLabels": "0","startingAngle": "330","showLabels": "0","showPercentValues": "1","showLegend": "1","legendShadow": "0","legendBorderAlpha": "0","defaultCenterLabel": tot_porc_label + " "+word_translate.units,"centerLabelBold": "2","showTooltip": "0","decimals": "0","captionFontSize": "18","subcaptionFontSize": "14","subcaptionFontBold": "0" },"data": [ {"value": tot_sale}, {"value": tot_rent},{"value": tot_rest} ]
            }
          }).render();
        });
      }
    }
    idxboostCollectiIn();
    ib_change_view( $('.ib_collection_view').val() ,$('.ib_collection_tab').val() );
  }
}

$('#paginator-cnt').on('click', '.pagfilajax', function() {
  obj_nav=$(this).parent('li').parent('ul').parent('nav');
  var datapage=$(this).attr('data-page');

  if (obj_nav.length==0) {
    obj_nav=$(this).parent('nav');
  }
  if (obj_nav.hasClass('idx-group-subarea-sale')) {
    tab_idx='#!for-sale';                      
    idxarealimit.sale=parseFloat(datapage);
    idxboostCollectiIn(ibevent = 'pagination',ibtype='sale');
  }else if (obj_nav.hasClass('idx-group-subarea-rent')) {
    tab_idx='#!for-rent';
    idxarealimit.rent=parseFloat(datapage);
    idxboostCollectiIn(ibevent = 'pagination',ibtype='rent');
  }else if (obj_nav.hasClass('idx-group-subarea-pending')) {
    tab_idx='#!pending';
    idxarealimit.pending=parseFloat(datapage);
    idxboostCollectiIn(ibevent = 'pagination',ibtype='pending');
  }else if (obj_nav.hasClass('idx-group-subarea-sold')) {
    tab_idx='#!sold';
    idxarealimit.sold=parseFloat(datapage);
    idxboostCollectiIn(ibevent = 'pagination',ibtype='sold');
  }

});

function ib_init_script(){ 
  var tot_sale=0, tot_rent=0,tot_sold=0,tot_porc=0,tot_porc_label=0,label_price='';
  $('.aside .property-information .price, .wp-statisticss, .condo-statics, .idxboost-collection-show-desktop, .fbc-group, #filter-views, .ib_content_views_building').hide();
    if(ib_building_inventory.load_item=='ajax'){
      jQuery('#dataTable-floorplan-grid').DataTable({ "paging": false }).order([3, 'desc']).draw();

                   jQuery.ajax({
                      url: idxboost_collection_params.ajaxUrl,
                      method: "POST",
                      data: jQuery('.idxboost_collection_sub_area_xr').serialize()+'&idxrequest=sold',
                      dataType: "json",
                      success: function(response) {
                        data_mls_sold=response.payload.properties.sold;                       
                      },complete: function() {
                        status_xhmr.xhr2=true;
                        ib_generate_struct(idxboostCollecBuil);
                      }
                    });


             jQuery.ajax({
                 url: idxboost_collection_params.ajaxUrl,
                 method: "POST",
                 data: jQuery('.idxboost_collection_sub_area_xr').serialize()+'&idxrequest=for_sale',
                 dataType: "json",
                 success: function(response) {
                  idxboostCollecBuil=response;
                 },complete: function() {
                  status_xhmr.xhr1=true;
                  if ( $('.js-ms-price').hasClass('js-price-upload') ) {
                    $('.js-ms-price').html("From $"+_.formatPrice(idxboostCollecBuil.payload.meta.sale_min_max_price.min)+' - $'+_.formatPrice(idxboostCollecBuil.payload.meta.sale_min_max_price.max));
                  }
                  //set the form contact
                  $("#form_contact_sub_area input[name='ib_tags']").val(idxboostCollecBuil.payload.name);
                  //set the form contact
                  ib_generate_struct(idxboostCollecBuil);
                 }
             });
    }
}

$(function() {

        $('.idxboost_collection_tab_sale, .idxboost_collection_tab_rent, .idxboost_collection_tab_sold').on("click", ".flex-slider-prev", function(event) {
            event.stopPropagation();
            var node = $(this).prev().find('li.flex-slider-current');
            var index = node.index();
            var total = $(this).prev().find('li').length;
            index = (index === 0) ? (total - 1) : (index - 1);
            $(this).prev().find('li').removeClass('flex-slider-current');
            $(this).prev().find('li').addClass('flex-slider-item-hidden');
            $(this).prev().find('li').eq(index).removeClass('flex-slider-item-hidden').addClass('flex-slider-current');
            myLazyLoad.update();
        });
        $('.idxboost_collection_tab_sale, .idxboost_collection_tab_rent, .idxboost_collection_tab_sold').on("click", ".flex-slider-next", function(event) {
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
        });

    $(document).ready(function(){
      myLazyLoad = new LazyLoad();

      if(ib_building_inventory.load_item !='ajax'){
        idxboostCollectiIn();
        jQuery('.group-flex.tabs-btn.show-desktop li:first').click();
        jQuery('.flex-open-tb-rent').click();
        jQuery('.flex-open-tb-sale').click();   
        $('.result-search li.propertie a').removeClass('show-modal');         
      }else{
        $('.sale-count-uni-cons').parent('.sale').hide();
        $('.sold-count-uni-cons').parent('.sold').hide();
        $('.rent-count-uni-cons').parent('.rent').hide();

        ib_init_script();

        $(document).on('change','#filter-by select',function() {
          var value_item=$(this).val();
          $('.idxboost-collection-show-desktop li').each(function(){
            if ($(this).attr('data-property')==value_item ){
              $(this).click();
            }
          });
        });    

        $(document).on('click','.idxboost-collection-show-desktop li',function() {
          var tabbuil=$(this).attr('fortab');
          var viebuil=$('.ib_collection_view').val();
          $('.ib_collection_tab').val(tabbuil);
          $('.fbc-group').removeClass('active-fbc active');
          
          /*botones tabs lateral mobile*/
          if (tabbuil == 'tab_sale') {
            $('.fbc-group.sale').addClass('active-fbc');
            //loadTitleBuilding('For Sale');
          } else if (tabbuil == 'tab_rent') {
            $('.fbc-group.rent').addClass('active-fbc');
            //loadTitleBuilding('For Rent');
          } else if (tabbuil == 'tab_sold') {
            $('.fbc-group.sold').addClass('active-fbc');
            //loadTitleBuilding('Sold');
          } else if (tabbuil == 'tab_pending') {
            $('.fbc-group.pending').addClass('active-fbc');
            //loadTitleBuilding('Pending');
          }
          /*botones tabs lateral mobile*/
          ib_change_view( viebuil ,tabbuil );
        });


        $(document).on('change','#filter-views select',function() {
          var tabbuil=$('.ib_collection_tab').val();
          ib_change_view_object_device($(this),tabbuil,$('.ib_collection_view'));
        });                   

        $(document).on('click','#filter-views li',function() {
          var tabbuil=$('.ib_collection_tab').val();
          ib_change_view_object_device($(this),tabbuil,$('.ib_collection_view'));
        });

        $(document).on('click','.flex-open-tb-sale button, .flex-open-tb-rent button, .flex-open-tb-sold button, .flex-open-tb-pending button',function() {
          $('.fbc-group').removeClass('active-fbc');

          if($(this).parent('li').hasClass('sale')){
            $('#flex_tab_sale').click();
          }else if ($(this).parent('li').hasClass('rent')){
            $('#flex_tab_rent').click();
          }else if ($(this).parent('li').hasClass('sold')){
            $('#flex_tab_sold').click();
          }else if ($(this).parent('li').hasClass('pending')){
            $('#flex_tab_pending').click();
          }
          $(this).parent('li').addClass('active-fbc');          

          if (idxboostCollecBuil.success != undefined && idxboostCollecBuil.success != false){
            var elementPosition = $(".idxboost-collection-show-desktop").offset();
            var positionMove = (elementPosition.top) - 300;
            $("html, body").animate({scrollTop:positionMove},'slow');

          }
                    
        });                

        $(document).on("click", "#modal_login .close-modal", function(event) {
            event.preventDefault();
            $(".ib-pbtnclose").click();
        });                

        $('.overlay_modal_closer').click(function(){
                event.preventDefault();
                $(".ib-pbtnclose").click();
        });

        $(document).on("click", ".flex-tbl-link", function(event) {
          event.preventDefault();
          if (idxboostCollecBuil.payload.type_filter !='2') {
            var mlsNumber = $(this).data('mls');
            var isSold = $(this).data('type');
            if (isSold=='sold'){
              var permalink = $(this).data("permalink");
              if (permalink.length) {
                window.open(permalink, '_blank');
              }
            }else{
                originalPositionY = Math.max(window.pageYOffset, document.documentElement.scrollTop, document.body.scrollTop);

              loadPropertyInModal(mlsNumber);
            }
          }else{
              var permalink = $(this).data("permalink");
              if (permalink.length) {
                window.open(permalink, '_blank');
              }
          }

        });

        $('.idxboost_collection_tab_sale, .idxboost_collection_tab_rent,.idxboost_collection_tab_pending').on('click','.view-detail ',function(event) {
          event.preventDefault();
            var mlsNumber = $(this).parent('li').data('mls');
            originalPositionY = Math.max(window.pageYOffset, document.documentElement.scrollTop, document.body.scrollTop);
            loadPropertyInModal(mlsNumber);          
        });

        $(document).on('click','#sale-count-uni-cons',function() {
          $('#flex_tab_sale').click();
          var elementPosition = $(".idxboost-type-view-wrap-result").offset();  
          var positionMove = (elementPosition.top) - 300;
          $("html, body").animate({scrollTop:positionMove},'slow');                              
        });                

        $(document).on('click','#rent-count-uni-cons',function() {
          $('#flex_tab_rent').click();
          var elementPosition = $(".idxboost-type-view-wrap-result").offset();  
          var positionMove = (elementPosition.top) - 300;
          $("html, body").animate({scrollTop:positionMove},'slow');                              
        });

        $(document).on('click','#pending-count-uni-cons',function() {
          $('#flex_tab_pending').click();
          var elementPosition = $(".idxboost-type-view-wrap-result").offset();  
          var positionMove = (elementPosition.top) - 300;
          $("html, body").animate({scrollTop:positionMove},'slow');                              
        });
        
        
        $(document).on('click','#sold-count-uni-cons',function() {
          $('#flex_tab_sold').click();
          var elementPosition = $(".idxboost-type-view-wrap-result").offset();  
          var positionMove = (elementPosition.top) - 300;
          $("html, body").animate({scrollTop:positionMove},'slow');                              
        });


      }
    });
});

})(jQuery);
function idxboostListobj(response_data,list_bed,name_table,type){
  var auxincre=0;
  auxtextobj='';
  list_bed.sort(function(a,b){ if (a > b) return -1; if (a < b) return 1; if  (a == b) return 0; });
  var hide_title_thumbs=true;
  if (list_bed.length==1 ) {
    hide_title_thumbs=false;
  }
  list_bed.forEach(function(element) {
      auxincre=auxincre+1;
      
      var txtnameprice=word_translate.asking_price;
      var txtdom='DOM';
      //var txtnamefoot=word_translate.days_on_market;
      var txtnamefoot='DOM';
      var title_beds='';

      if (type=='sold') {
        txtdom='Date';
        txtnameprice=word_translate.sold_price;
        txtnamefoot=word_translate.sold_date;
      }
      
      //if (hide_title_thumbs) {
        if (element==0)  { 
          auxtextobj +='<h2 class="title-thumbs">Studio</h2>';  
        }else {
          if (element>5) 
            title_beds='5+';
          else
            title_beds=element;
          
          auxtextobj +='<h2 class="title-thumbs">'+title_beds+' '+word_translate.bedrooms+'</h2>';
        }
      //}

      auxtextobj +='<div class="tbl_properties_wrapper">';
      auxtextobj += '<table class="display" id="dataTable-'+name_table+'-'+auxincre+'" cellspacing="0" width="100%">'+
      '<thead>'+
        '<tr><th class="dt-center sorting">'+word_translate.address+'</th>'+
          '<th class="dt-center sorting class_asking_prince">'+'<span class="ms-mb-text">List Price</span>'+'<span class="ms-pc-text">'+txtnameprice+'</span>'+'</th>'+
          '<th class="dt-center sorting">'+'<span class="ms-mb-text">B/B</span>'+'<span class="ms-pc-text">'+word_translate.sbeds+'/'+word_translate.sbaths+'</span>'+'</th>'+
          '<th class="dt-center sorting show-desktop">'+'<span class="ms-mb-text">Size</span>'+'<span class="ms-pc-text">'+word_translate.living_size+'</span>'+'</th>'+
          '<th class="dt-center sorting show-desktop">'+'<span class="ms-mb-text">$/sqft</span>'+'<span class="ms-pc-text">'+word_translate.price+'/'+word_translate.sqft+'</span>'+'</th>'+
          '</tr>'+
        '</thead>'+
        '<tbody>';
        var responseauxtext=[];

        response_data.forEach(function(elementsec) {
          if (elementsec[1]==element) {
            responseauxtext.push(elementsec[0]);
          }
        });

        auxtextobj += responseauxtext.join('');
        auxtextobj +='</tbody></table></div>';
  });
  return auxtextobj;
}



  function idxboostCollectiIn(ibevent = 'default',ibtype=''){
    var listsale='',listrent='',listsold='',idxboostcollectionsale='',idxboostcollectionrent='',textmodeview='',optionsale='',optionrent='',optionsold='';

    if (ibevent != 'pagination') {

      if (idxboostCollecBuil["payload"]["properties"]["sale"]["count"]>0){
        listsale='<li class="sale"><button id="sale-count-uni-cons">'+idxboostCollecBuil["payload"]["properties"]["sale"]["count"]+'<span>For Sale</span></button></li>';
        idxboostcollectionsale='<li class="active" fortab="tab_sale" forview="sale_list" id="flex_tab_sale"><button> <span>for sale</span></button></li>';
        optionsale='<option value="sale">For Sale</option>';
      }

      if (idxboostCollecBuil["payload"]["properties"]["rent"]["count"]>0){
        listrent='<li class="sale"><button id="sale-count-uni-cons">'+idxboostCollecBuil["payload"]["properties"]["rent"]["count"]+'<span>For Rent</span></button></li>';
        idxboostcollectionrent='<li fortab="tab_rent" forview="rent_list" id="flex_tab_rent"><button> <span>For Rent</span></button></li>';
        optionrent='<option value="rent">For Rent</option>';
      }

      if (data_mls_sold["count"]>0){
        listsold='<li class="sale"><button id="sale-count-uni-cons">'+data_mls_sold["count"]+'<span>Sold</span></button></li>';
        idxboostcollectionsold='<li fortab="tab_sold" forview="sold_list" id="flex_tab_sold"><button> <span>Sold</span></button></li>';
        optionsold='<option value="sold">Sold</option>';
      }

    }

    if(ibevent != 'pagination') {
      if (idxboostCollecBuil.payload.modo_view==2){ textmodeview='list'; }else{textmodeview='grid';  }
      jQuery('.idxboost-type-view-wrap-result').addClass('view-'+textmodeview);
      jQuery('.idxboost_collection_filterviews select option').addClass(textmodeview);
    }
    /*OPERACIONES*/

    //data sale
    if (ibtype=='sale' || ibtype=='') {
      var ib_sale='';
responseitemsale=[];
responseitemsalegrid='';
/*      
                       if (idxboostCollecBuil.payload.properties.sale.count>=150) {
                          temp_sale=idxboostCollecBuil.payload.properties.sale.items.slice((idxarealimit.sale*idxarealimit.limit),(idxarealimit.sale*idxarealimit.limit)+idxarealimit.limit);
                          ib_sale='pagination';
                       }else{
                          temp_sale=idxboostCollecBuil.payload.properties.sale.items;
                       }
*/
                        temp_sale=idxboostCollecBuil.payload.properties.sale.items;
                       temp_sale.forEach(function(element,index) {
                        var bedfil=parseFloat(element['bed']);
                        if (bedfil>=5 ) bedfil=6;
                        
                        if (listbedsale.indexOf(parseFloat(bedfil) )==-1) {
                            listbedsale.push(parseFloat(bedfil));
                        }
                        responseitemsale.push(idxboostListCollection(element,ib_sale,idxboostCollecBuil.payload.type_filter));
                        responseitemsalegrid +=idxboostListCollectionGrid(element,index,'sale',idxboostCollecBuil.payload.type_filter);
                       });

                       //sale list print
                       var htmlsale=idxboostListobj(responseitemsale,listbedsale,'sale','sale');
                       jQuery('.idxboost_collection_sale_list').html('');
                       jQuery('.idxboost_collection_sale_list').html(htmlsale).ready(function() {  
                        idxboostTypeIcon();                          
                        /*
                        if (idxboostCollecBuil.payload.properties.sale.count>=150) {
                          idx_page_for_type('.idx-group-subarea-sale',idxboostCollecBuil.payload.properties.sale.count,idxarealimit.sale,'sale');
                        }*/

                      });
                       //sale list print
    }

    if (ibtype=='pending' || ibtype=='') {
      var ib_pending='';
      responseitempending=[];
      responseitemsoldpending='';
                       //data pending
                       /*
                       if (idxboostCollecBuil.payload.properties.pending.count>=150) {
                          temp_pending=idxboostCollecBuil.payload.properties.pending.items.slice((idxarealimit.pending*idxarealimit.limit),(idxarealimit.pending*idxarealimit.limit)+idxarealimit.limit);
                          ib_pending='pagination';
                       }else{
                          temp_pending=idxboostCollecBuil.payload.properties.pending.items;
                       }
                       */
                        
                      temp_pending=idxboostCollecBuil.payload.properties.pending.items;

                       temp_pending.forEach(function(element,index) {
                        var bedfil=parseFloat(element['bed']);
                        if (bedfil>=5 ) bedfil=6;

                        if (listbedpending.indexOf(parseFloat(bedfil))==-1) {
                          listbedpending.push(parseFloat(bedfil));
                        }
                        responseitempending.push(idxboostListCollection(element,ib_pending,idxboostCollecBuil.payload.type_filter));
                        responseitemsoldpending +=idxboostListCollectionGrid(element,index,'pending',idxboostCollecBuil.payload.type_filter);
                       });

                       var htmlpending=idxboostListobj(responseitempending,listbedpending,'pending','pending');
                       jQuery('.idxboost_collection_pending_list').html(htmlpending).ready(function() {  
                        idxboostTypeIcon();   
                        /*
                        if (idxboostCollecBuil.payload.properties.pending.count>=150) {
                          idx_page_for_type('.idx-group-subarea-pending',idxboostCollecBuil.payload.properties.pending.count,idxarealimit.pending,'pending');
                        }
                        */
                      });
                       //data pending
    }

    if (ibtype=='rent' || ibtype=='') {
      var ib_rent='';
      responseitemrent=[];
      responseitemrentgrid='';
                       //data rent
                       /*
                       if (idxboostCollecBuil.payload.properties.rent.count>=150) {
                          temp_rent=idxboostCollecBuil.payload.properties.rent.items.slice((idxarealimit.rent*idxarealimit.limit),(idxarealimit.rent*idxarealimit.limit)+idxarealimit.limit);
                          ib_rent='pagination';
                       }else{
                          temp_rent=idxboostCollecBuil.payload.properties.rent.items;
                       }
                       */
                       temp_rent=idxboostCollecBuil.payload.properties.rent.items;
                       temp_rent.forEach(function(element,index) {
                        var bedfil=parseFloat(element['bed']);
                        if (bedfil>=5 ) bedfil=6;

                        if (listbedrent.indexOf(parseFloat(bedfil))==-1) {
                          listbedrent.push(parseFloat(bedfil));
                        }
                        responseitemrent.push(idxboostListCollection(element,ib_rent,idxboostCollecBuil.payload.type_filter));
                        responseitemrentgrid +=idxboostListCollectionGrid(element,index,'rent',idxboostCollecBuil.payload.type_filter);
                       });
                       var htmlrent=idxboostListobj(responseitemrent,listbedrent,'rent','rent');
                       jQuery('.idxboost_collection_rent_list').html(htmlrent).ready(function() {  
                        idxboostTypeIcon();
                        /*
                        if (idxboostCollecBuil.payload.properties.rent.count>=150) {
                          idx_page_for_type('.idx-group-subarea-rent',idxboostCollecBuil.payload.properties.rent.count,idxarealimit.rent,'rent');
                        }
                        */                        
                      });
                       //data rent
    }

    if (ibtype=='sold' || ibtype=='') {
var ib_sold='';
responseitemsold=[];
responseitemsoldgrid='';
/*
                       //data sold
                       if (data_mls_sold.count>=150) {
                          temp_sold=data_mls_sold.items.slice((idxarealimit.sold*idxarealimit.limit),(idxarealimit.sold*idxarealimit.limit)+idxarealimit.limit);;
                          ib_sold='pagination';
                       }else{
                          temp_sold=data_mls_sold.items;
                       }
                       */
                       console.log(data_mls_sold);
                       temp_sold = [];
                       if( data_mls_sold.hasOwnProperty("items") &&  data_mls_sold.items.length > 0 ){
                        temp_sold=data_mls_sold.items;
                       }
                       if(  temp_sold.length > 0 ){

                          temp_sold.forEach(function(element,index) {
                            var bedfil=parseFloat(element['bed']);
                            if (bedfil>=5 ) bedfil=6;
    
                            if (listbedsold.indexOf(parseFloat(bedfil))==-1) {
                              listbedsold.push(parseFloat(bedfil));
                            }
                            responseitemsold.push(idxboostListCollectionForSold(element,ib_sold));
                            responseitemsoldgrid +=idxboostListCollectionGrid(element,index,'sold',idxboostCollecBuil.payload.type_filter);
                          });

                       }

                       //sold list print 
                       var htmlsold=idxboostListobj(responseitemsold,listbedsold,'sold','sold');
                       jQuery('.idxboost_collection_sold_list').html(htmlsold).ready(function() {  
                        idxboostTypeIcon();   
                        /*
                        if (data_mls_sold.count>=150) {
                          idx_page_for_type('.idx-group-subarea-sold',data_mls_sold.count,idxarealimit.sold,'sold');
                        }
                        */
                      });
                       //data sold
      }

                      /*FIN OPERACIONES*/
                      idxboosttabview();

                      if (tab_idx=='#!for-sale' && idxboostCollecBuil.payload.properties.sale.count > 0 ) {
                        $('#flex_tab_sale').click();
                      }else if(tab_idx=='#!for-rent' && idxboostCollecBuil.payload.properties.rent.count > 0 ) {
                        $('#flex_tab_rent').click();
                      }else if (tab_idx=='#!sold' && data_mls_sold.count > 0 ) {
                        $('#flex_tab_sold').click();
                      }else if (tab_idx=='#!pending' && idxboostCollecBuil.payload.properties.pending.count > 0 ) {
                        $('#flex_tab_pending').click();
                      }

    if (ibevent != 'pagination') {
      var list_tables_object=jQuery('.tbl_properties_wrapper .display'); 

      for(i=0;i<list_tables_object.length;i++){ 
        var idtable=list_tables_object.eq(i).attr('id');  
        jQuery('#'+idtable).DataTable({ "paging": false }).order([1, 'desc']).draw();
      }

    }else{
      jQuery('#dataTable-'+ibtype+'-1').DataTable({ "paging": false }).order([1, 'desc']).draw();
    }

//change filter for ajax

var filter_view=$('#filter-views ul li');

if(filter_view.length==0){
  filter_view=$('#filter-views select option');

  filter_view=$('#filter-views select option');
  filter_view.each(function(){
    if($(this).attr('value')== idxboostCollecBuil.payload.property_display_active )
      $(this).change();
  }); 
}else{

  filter_view.each(function(){
    if($(this).hasClass(idxboostCollecBuil.payload.property_display_active) )
      $(this).click();
  });
  
}



  }


function idx_page_for_type(obj_pagination,item_count,pag_fil,typePost){
  var paginationHTML=[];
  var pag_filnext=0;
  var totpag=0;
  var urlpageante=0;
  totpag=Math.round(item_count/24);
  pag_fil=parseInt(pag_fil);
if(pag_fil==1 || pag_fil==0) {
    urlpageante=0;
}else{
    urlpageante=pag_fil-1;
}

if( (totpag-1)==pag_fil) {
  pag_filnext=0;
}else{
  pag_filnext=parseInt(pag_fil)+1;
}

var paginationHTML=[];
                if (totpag > 1) {
                    paginationHTML.push('<span id="indicator">Pag ' + (pag_fil+1) + ' of ' + totpag + '</span>');
                    if (urlpageante && totpag > 1) {
                        paginationHTML.push('<a data-page="0" title="First Page" id="firstp" class="ad visible pagfilajax">');
                        paginationHTML.push('<span class="clidxboost-icon-arrow-select"></span>');
                        paginationHTML.push('<span class="clidxboost-icon-arrow-select"></span>');
                        paginationHTML.push('<span>First page</span>');
                        paginationHTML.push('</a>');
                    }
                    if (pag_fil) {
                        paginationHTML.push('<a data-page="' + (parseInt(pag_fil) - 1) + '" title="Prev Page" id="prevn" class="arrow clidxboost-icon-arrow-select prevn visible pagfilajax">');
                        paginationHTML.push('<span>Previous page</span>');
                        paginationHTML.push('</a>');
                    }
                    paginationHTML.push('<ul id="principal-nav">');
                    var variFil=5+parseInt(pag_fil);
                    if (variFil > totpag)  {
                      for (var i = 0 , l = 5 ; i <= l; i++) {
                        var loopPage = (parseInt(totpag)-l)+i;
                        if (loopPage>0) {
                          if (parseInt(pag_fil+1) === loopPage) {
                              paginationHTML.push('<li class="active"><a class="pagfilajax" data-page="' +(loopPage-1)+ '">' + loopPage+ '</a></li>');
                          } else {
                              paginationHTML.push('<li><a class="pagfilajax" data-page="' + (loopPage-1) + '">' + loopPage + '</a></li>');
                          }
                        }
                     }
                    }else{
                      for (var i = 0, l = 5 ; i <= l; i++) {
                        var loopPage = parseInt(pag_fil)+i;
                          if (loopPage>0) {
                        if (parseInt(pag_fil+1) === loopPage) {
                            paginationHTML.push('<li class="active"><a class="pagfilajax" data-page="' +(loopPage-1)+ '">' + loopPage+ '</a></li>');
                        } else {
                            paginationHTML.push('<li><a class="pagfilajax" data-page="' + (loopPage-1) + '">' + loopPage + '</a></li>');
                        }
                      }
                    }
                  }
                    paginationHTML.push('</ul>');
                    if (pag_filnext)  {
                        paginationHTML.push('<a data-page="' + pag_filnext + '" title="Prev Page" id="nextn" class="arrow clidxboost-icon-arrow-select nextn visible pagfilajax">');
                        paginationHTML.push('<span>Next page</span>');
                        paginationHTML.push('</a>');
                    }
                      if (pag_filnext && totpag > 1) {
                        paginationHTML.push('<a data-page="' + (totpag-1) + '" title="End Page" id="lastp" class="ad visible pagfilajax">');
                        paginationHTML.push('<span class="clidxboost-icon-arrow-select"></span>');
                        paginationHTML.push('<span class="clidxboost-icon-arrow-select"></span>');
                        paginationHTML.push('<span>Last page</span>');
                        paginationHTML.push('</a>');
                    }
                }
                jQuery(obj_pagination).html(paginationHTML.join(""));

                if (typePost=='sale') {
                  idxarealimit.sale=pag_filnext;
                }else if (typePost=='rent') {
                  idxarealimit.rent=pag_filnext;
                }else if (typePost=='pending') {
                  idxarealimit.pending=pag_filnext;
                }else if (typePost=='sold') {
                  idxarealimit.sold=pag_filnext;
                }
}


function idxboostListCollectionForSold(element,ibstatus){
    var responseitems='',arraylist=[];

    if (idxboostCollecBuil.payload.type_filter=='2') {
      var slug_property=idxboost_collection_params.off_market_listing_link+'/'+element['slug'];
    }else{
      var slug_property=idxboost_collection_params["siteUrl"]+'/property/sold-'+element['slug'];
    }

                        //LISTINI
                        address_large="";
                        if (element['address_short'] != '' && element['address_short'] != undefined ) {
                          address_large= element['address_short'];
                        }
                        
                        responseitems +='<tr class="flex-tbl-link" data-mls="'+element['mls_num']+'" data-type="sold" data-permalink="'+slug_property+'">';
                        responseitems += '<td><div class="unit propertie" data-mls="'+element['mls_num']+'">';
                        
                        if (idxboostCollecBuil.payload.type_filter !='2') {
                          if (element['is_favorite']==1) {
                            responseitems +='<button class="clidxboost-btn-check flex-favorite-btn" data-alert-token="'+element['token_alert']+'"><span class="clidxboost-icon-check clidxboost-icon-check-list active flex-active-fav"></span></button><span>'+element['unit']+'</span>';
                          }else{
                            responseitems +='<button class="clidxboost-btn-check flex-favorite-btn"><span class="clidxboost-icon-check clidxboost-icon-check-list"></span></button><span>'+address_large+'</span>';
                          }
                        }                        
                        

                        responseitems +='</div></td><td><div class="asking-number blue">$ '+_.formatPrice(element['price_sold'])+'</div></td>';
                        var textreduced='';
                        if (element['reduced'] !== '' && element['reduced'] < 0 ) {
                          textreduced='red';
                        }else if(element['reduced'] !== '' && element['reduced'] >= 0 ){
                          textreduced='green';
                        }else{
                          textreduced='black';
                        }
                        var textreducedmon=0;

                        if (element['reduced'] !== 0  )
                          textreducedmon=element['reduced']+'%';
                        else
                          textreducedmon='0%';

                        responseitems +='<td><div class="beds">'+element['bed']+' / '+element['bath']+' / '+element['baths_half']+'</div></td>';
                        responseitems +='<td class="table-beds show-desktop"><div class="beds">'+_.formatPrice(element['sqft'])+' <span> Sq.Ft.</span></div></td>';
                        responseitems +='<td class="table-beds show-desktop"><div class="price">$'+element['price_sqft']+'</div></td>';
                        //LISTFIN
                        var bedfil=parseFloat(element['bed']);
                        if (bedfil>=5 ) bedfil=6;


                        arraylist.push(responseitems);
                        arraylist.push(bedfil);
                        return arraylist;
  }  

  function idxboostListCollection(element,ibstatus,type_filter){
    var responseitems='',arraylist=[];
    if (type_filter=='2') {
      var slug_property=idxboost_collection_params.off_market_listing_link+'/'+element['slug'];
    }else{
      var slug_property=idxboost_collection_params["siteUrl"]+'/property/'+element['slug'];
      /*
      if (type_property=='sold'){
        slug_property=idxboost_collection_params["siteUrl"]+'/property/sold-'+element['slug'];
      }
      */
    }

                        //LISTINI
                        address_large="";
                        if (element['address_short'] != '' && element['address_short'] != undefined ) {
                          address_large= element['address_short'];
                        }
                        
                        responseitems +='<tr class="flex-tbl-link" data-mls="'+element['mls_num']+'" data-type="no-sold" data-permalink="'+slug_property+'" href="'+slug_property+'">';
                        responseitems += '<td><div class="unit propertie" data-mls="'+element['mls_num']+'">';

                        if (idxboostCollecBuil.payload.type_filter !='2') {
                          if (element['is_favorite']==1) {
                            responseitems +='<button class="clidxboost-btn-check flex-favorite-btn" data-alert-token="'+element['token_alert']+'"><span class="clidxboost-icon-check clidxboost-icon-check-list active flex-active-fav"></span></button><span>'+element['unit']+'</span>';
                          }else{
                            responseitems +='<button class="clidxboost-btn-check flex-favorite-btn"><span class="clidxboost-icon-check clidxboost-icon-check-list"></span></button><span>'+address_large+'</span>';
                          }                          
                        }else{
                          responseitems +=address_large;
                        }
                        
                        responseitems +='</div></td><td><div class="asking-number blue">$ '+_.formatPrice(element['price'])+'</div></td>';
                        var textreduced='';
                        if (element['reduced'] !== '' && element['reduced'] < 0 ) {
                          textreduced='red';
                        }else if(element['reduced'] !== '' && element['reduced'] >= 0 ){
                          textreduced='green';
                        }else{
                          textreduced='black';
                        }
                        var textreducedmon=0;

                        if (element['reduced'] !== 0  )
                          textreducedmon=element['reduced']+'%';
                        else
                          textreducedmon='0%';

                        var pricetexsale=0;
                        if (element['sqft'] > 0 ) { pricetexsale=element['price']/element['sqft'] }else { pricetexsale=0; }

                        responseitems +='<td><div class="beds">'+element['bed']+' / '+element['bath']+' / '+element['baths_half']+'</div></td>';
                        responseitems +='<td class="table-beds show-desktop"><div class="beds">'+_.formatPrice(element['sqft'])+' <span> Sq.Ft.</span></div></td>';
                        responseitems +='<td class="table-beds show-desktop"><div class="price">$'+_.formatPrice(pricetexsale)+'</div></td>';
                        //LISTFIN
                        var bedfil=parseFloat(element['bed']);
                        if (bedfil>=5) bedfil=6;

                        arraylist.push(responseitems);
                        arraylist.push(bedfil);
                        return arraylist;
  }

  function idxboostListCollectionGrid(element,count_item,type_property,type_filter) {
    var htmlgrid='';
    var price=_.formatPrice(element['price']);
    if (type_filter=='2') {
      var slug_property=idxboost_collection_params.off_market_listing_link+'/'+element['slug'];
    }else{

      var slug_property=idxboost_collection_params["siteUrl"]+'/property/'+element['slug'];
      if (type_property=='sold'){
        price=_.formatPrice(element['price_sold']);
        slug_property=idxboost_collection_params["siteUrl"]+'/property/sold-'+element['slug'];
      }
    }


    htmlgrid +='<li class="propertie" data-id="'+element['mls_num']+'" data-mls="'+element['mls_num']+'" data-counter="'+count_item+'">';
      
      if (element['status']!=null || element['status']!=undefined ){
          if(element['status'] == 5){
            htmlgrid +='<div class="flex-property-new-listing">'+word_translate.rented+'!</div>';
          }else if(element['status']== 2){
             htmlgrid +='<div class="flex-property-new-listing">'+word_translate.sold+'!</div>';
          }else if(element['status'] != 1){
            htmlgrid +='<div class="flex-property-new-listing">'+word_translate.pending+'!</div>';
          }else if(element['recently_listed'] == 'yes'){
            htmlgrid +='<div class="flex-property-new-listing">'+word_translate.new_listing+'!</div>';
          }
      }
    htmlgrid +='<h2 title="'+element['address_short']+' '+element['address_large']+'"><span>'+element['address_short'].replace('# ','#')+'</span></h2>';
    htmlgrid +='<ul class="features">';
    htmlgrid +='<li class="address">'+element['address_large']+'</li>';
    htmlgrid +='<li class="price">$'+price+'</li>';
    htmlgrid +='<li class="pr down">2.05%</li>';
    htmlgrid +='<li class="beds">'+element['bed']+' <span>'+word_translate.beds+' </span></li>';
    htmlgrid +='<li class="baths">'+element['bath']+' <span>'+word_translate.baths+' </span></li>';
    htmlgrid +='<li class="living-size"> <span>'+_.formatPrice(element['sqft'])+'</span>'+word_translate.sqft+' <span>(452 m2)</span></li>';
    htmlgrid +='<li class="price-sf"><span>$'+_.formatPrice(element['price_sqft']) + ' </span>/ '+word_translate.sqft+'<span>($' + element['price_sqft_m2'] + ' m2)</span></li>';
    htmlgrid +='<li class="build-year"><span>Built </span>2015</li>';
    htmlgrid +='<li class="development"><span>'+element['city_name']+'</span></li>';
    htmlgrid +='</ul>';
    htmlgrid +='<div class="wrap-slider">';
    htmlgrid +='<ul>';
    var elementgallery='';

    if (idxboostCollecBuil.payload.type_filter =='2') {
        element["gallery"].forEach(function(itemimage,aux) {
          var pathImage=itemimage;

          if( Array.isArray(itemimage) ){
            pathImage=itemimage[0];
          }

          if (aux==0) {
        elementgallery +='<li class="flex-slider-current"><img class="flex-lazy-image" data-original="'+pathImage+'" alt="'+element['address_short']+' '+element['address_large']+'"></li>';
      }else{
        elementgallery +='<li class="flex-slider-item-hidden"><img class="flex-lazy-image" data-original="'+pathImage+'" alt="'+element['address_short']+' '+element['address_large']+'"></li>';
      }
        });

    }else{
      element["gallery"].forEach(function(itemimage,aux) {
          var pathImage=itemimage;

          if( Array.isArray(itemimage) ){
            pathImage=itemimage[0];
          }

          
        if (aux==0) {
          elementgallery +='<li class="flex-slider-current"><img class="flex-lazy-image" data-original="'+pathImage+'" alt="'+element['address_short']+' '+element['address_large']+'"></li>';
        }else{
          elementgallery +='<li class="flex-slider-item-hidden"><img class="flex-lazy-image" data-original="'+pathImage+'" alt="'+element['address_short']+' '+element['address_large']+'"></li>';
        }
      });
    }
    
    htmlgrid +=elementgallery;
    htmlgrid +='</ul><button class="prev flex-slider-prev" aria-label="Prev"><span class="clidxboost-icon-arrow-select"></span></button><button class="next flex-slider-next" aria-label="Next"><span class="clidxboost-icon-arrow-select"></span></button>';

    if (idxboostCollecBuil.payload.type_filter !='2') {
      if (type_property!='sold'){
        if(element['is_favorite']==1) {
        htmlgrid +='<button class="clidxboost-btn-check flex-favorite-btn" data-alert-token="'+element['token_alert']+'" aria-label="Remove Favorite"><span class="clidxboost-icon-check clidxboost-icon-check-list active"></span></button>';
      }else{
        htmlgrid +='<button class="clidxboost-btn-check flex-favorite-btn" aria-label="Save Favorite"><span class="clidxboost-icon-check clidxboost-icon-check-list"></span></button>';
        }
      }
    }

    htmlgrid +='</div>';
    
    var classHiperlink='',hasTargetBlank='';
    if (type_filter=='2') {
      classHiperlink='';
      hasTargetBlank='target="_blank"'
    }else{
      classHiperlink='class="view-detail "';
    }

    htmlgrid +='<a '+classHiperlink+' href="'+slug_property+'" '+hasTargetBlank+' data-modal="modal_property_detail" data-position="0" rel="nofollow">'+'</a></li>';
    return htmlgrid;
}

var fortab,type_view;
  function idxboosttabview(){
          fortab=jQuery('.idxboost-collection-show-desktop li.active').attr('fortab');
          type_view=jQuery('.idxboost_collection_filterviews ul li.active');
          var is_class_active=0;
          
          if (type_view.length > 0 )
            is_class_active = type_view.attr('class').indexOf("grid");

        if(fortab=="tab_sale"){
          jQuery('.idxboost_collection_tab_sale').html(responseitemsalegrid).ready(function() {  idxboostTypeIcon();   });

          if( is_class_active != -1 && jQuery('.idxboost_collection_tab_sale').find('li').length==0  ){
            //if( jQuery('.idxboost_collection_tab_sale').find('li').length==0 ) auxscreensale=0; 
            //if (auxscreensale==0){auxscreensale=auxscreensale+1; jQuery('.idxboost_collection_tab_sale').html(responseitemsalegrid).ready(function() {  idxboostTypeIcon();   }); console.log('entro sale'); }
          }
        }else  if(fortab=="tab_rent" && jQuery('.idxboost_collection_tab_rent').find('li').length==0 ) {
          jQuery('.idxboost_collection_tab_rent').html(responseitemrentgrid).ready(function() {  idxboostTypeIcon();   }); 
          if( is_class_active != -1){
            //if( jQuery('.idxboost_collection_tab_rent').find('li').length==0 ) auxscreensale=0; 
            //if (auxscreenrent==0){auxscreenrent=auxscreenrent+1; jQuery('.idxboost_collection_tab_rent').html(responseitemrentgrid).ready(function() {  idxboostTypeIcon();   }); console.log('entro rent'); }
          }

        }else  if(fortab=="tab_sold" && jQuery('.idxboost_collection_tab_sold').find('li').length==0 ) {
          jQuery('.idxboost_collection_tab_sold').html(responseitemsoldgrid).ready(function() {  idxboostTypeIcon();   });
          if( is_class_active != -1){
            //if( jQuery('.idxboost_collection_tab_sold').find('li').length==0 ) auxscreensold=0; 
            //if (auxscreensold==0){auxscreensold=auxscreensold+1; jQuery('.idxboost_collection_tab_sold').html(responseitemsoldgrid).ready(function() {  idxboostTypeIcon();   }); console.log('entro sold'); }
          }
        }else  if(fortab=="tab_pending" && jQuery('.idxboost_collection_tab_pending').find('li').length==0 ) {
          jQuery('.idxboost_collection_tab_pending').html(responseitemsoldpending).ready(function() {  idxboostTypeIcon();   });
          if( is_class_active != -1){
            //if( jQuery('.idxboost_collection_tab_pending').find('li').length==0 ) auxscreenpending=0; 
            //if (auxscreenpending==0){auxscreenpending=auxscreenpending+1; jQuery('.idxboost_collection_tab_pending').html(responseitemsoldpending).ready(function() {  idxboostTypeIcon();   }); console.log('entro pending'); }
          }
        }
        /*INICIALIZAMOS LA VARIABLE DE LAZYLOAD*/
        if (myLazyLoad != undefined){
          myLazyLoad.update();
        }else{
          myLazyLoad = new LazyLoad();
          myLazyLoad.update();
        }        
  }
