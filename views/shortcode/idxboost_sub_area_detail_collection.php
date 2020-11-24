<?php
global $flex_idx_info, $post, $flex_social_networks, $wp;

$wp_request = $wp->request;
$wp_request_exp = explode('/', $wp_request);

$building_permalink = get_permalink($post->ID);

$view_url=$type_view_default;

if($type_view=='sale') {
  $active_class='sale';
}else if($type_view=='rent') {
  $active_class='rent';
}else if ($type_view=='sold') {
  $active_class='sold';
}else{
  $active_class='sale';
}
$agent_info_name = $flex_idx_info['agent']['agent_first_name'];
$agent_last_name = $flex_idx_info['agent']['agent_last_name'];
$agent_info_phone = $flex_idx_info['agent']['agent_contact_phone_number'];
$logo_broker='';
?>
<style>
.flex-slider-item-hidden {
    display: none !important;
}

.flex-lazy-image {
    -webkit-transform: scale(1) !important;
    -ms-transform: scale(1) !important;
    transform: scale(1) !important;
}

.flex-property-new-listing {
    position: absolute;
    left: 10px;
    top: 10px;
    z-index: 300;
    background: rgba(0, 0, 0, 0.5);
    color: #fff;
    font-size: 13px;
    text-transform: uppercase;
    padding: 5px;
}

.create-alert-footer {
    position: relative !important;
    width: 150px !important;
    background-color: white !important;
    opacity: 1 !important;
    padding: 0px !important;
    right: 0px !important;
    font-size: 15px !important;
    left: 10px;
    top: 0px !important;
}

.view-list .flex-property-new-listing {
    display: none;
}

/* STYLE FOR PAGINATION */
.nav_results_pag.active {
    display: flex !important;
}

.nav_results_pag {
    display: none !important;
}
/* STYLE FOR PAGINATION */

@media screen and (max-width: 800px) {
    div#map-actions {
        display: none;
    }
}

.result-search .wrap-slider li img {
    opacity: 0;
    transition: opacity 0.5s linear;
}

.result-search .wrap-slider li img.flex-lazy-image.loaded {
    opacity: 1;
}
</style>

<script type="text/javascript">
  var idxboostCollecBuil=[];
</script>
  <form name="idxboost_collection_sub_area_xr" class="idxboost_collection_sub_area_xr" id="idxboost_collection_sub_area_xr">
    <input type="hidden" name="action" value="idxboost_sub_area_collection_list">
    <input type="hidden" name="building_id" value="<?php echo $atts['building_id'];?>">
  </form>
  
<div class="r-overlay"></div>
    <main class="property-details theme-3">
      <div id="full-main">
        <section class="main">
          <div class="gwr ms-full-wrap">
            <div class="container">

              <div class="main-content">
                <div class="group-flex tabs-btn show-desktop idxboost-collection-show-desktop">
                    <li data-property="sale" fortab="tab_sale" forview="sale_list" id="flex_tab_sale"><button> <span><?php echo __('For Sale', IDXBOOST_DOMAIN_THEME_LANG); ?></span></button></li>
                    <li data-property="rent" fortab="tab_rent" forview="rent_list" id="flex_tab_rent"><button> <span><?php echo __('For Rent', IDXBOOST_DOMAIN_THEME_LANG); ?></span></button></li>
                    <li data-property="pending" fortab="tab_pending" forview="pending_list" id="flex_tab_pending"><button> <span><?php echo __('Pending', IDXBOOST_DOMAIN_THEME_LANG); ?></span></button></li>
                    <li data-property="sold" fortab="tab_sold" forview="sold_list" id="flex_tab_sold"><button> <span><?php echo __('Sold', IDXBOOST_DOMAIN_THEME_LANG); ?></span></button></li>
                </div>

                <div class="container wp-thumbs wrap-result idxboost-type-view-wrap-result ib_content_views_building ms-area-table" id="view-list">
                  <div id="wrap-subfilters">
                    <div class="gwr ms-full-wrap">
                      <ul id="sub-filters">
                        <li id="link-favorites">
                          <a class="clidxboost-icon-favorite" href="#" title="Save Favorites" rel="nofollow">
                            <span><span>0</span>Favorites</span>
                          </a>
                        </li>

                      <li id="filter-by" class="clidxboost-icon-arrow-select destock-hidden">
                        <span class="filter-text"><?php echo __('For Sale', IDXBOOST_DOMAIN_THEME_LANG); ?></span>
                        <select id="flex_filter_sort">
                          <option value="sale"><?php echo __('For Sale', IDXBOOST_DOMAIN_THEME_LANG); ?></option>
                          <option value="rent"><?php echo __('For Rent', IDXBOOST_DOMAIN_THEME_LANG); ?></option>
                          <option value="pending"><?php echo __('Pending', IDXBOOST_DOMAIN_THEME_LANG); ?></option>
                          <option value="sold"><?php echo __('Sold', IDXBOOST_DOMAIN_THEME_LANG); ?></option>
                        </select>
                      </li>

                        <li class="clidxboost-icon-arrow-select idxboost_collection_filterviews list" id="filter-views">
                          <select>
                            <option value="grid" 
                            <?php 
                            if (!empty($GLOBALS) && is_array($GLOBALS) &&  array_key_exists('result_detailt_building',$GLOBALS) && $GLOBALS['result_detailt_building']['payload']['property_display_active']=='grid') { 
                                echo "selected"; 
                              } 
                            ?>
                            forview="view_grip"><?php echo __('Grid', IDXBOOST_DOMAIN_THEME_LANG); ?></option>
                            <option value="list" 
                            <?php if (!empty($GLOBALS) && is_array($GLOBALS) && array_key_exists('result_detailt_building',$GLOBALS) && $GLOBALS['result_detailt_building']['payload']['property_display_active']=='list') { 
                              echo "selected"; 
                            } 
                            ?> forview="view_list"><?php echo __('List', IDXBOOST_DOMAIN_THEME_LANG); ?></option>
                          </select>
                        </li>
                      </ul>
                    </div>
                  </div>

                  <div class="mode_view" id="view_list">
                    <div id="rent_list" class="item_view_db idxboost_collection_rent_list"><input type="hidden" value="0" class="count_rent_building"></div>
                    <div id="sale_list" class="item_view_db idxboost_collection_sale_list"><input type="hidden" value="0" class="count_sale_building"></div>
                    <div id="pending_list" class="item_view_db idxboost_collection_pending_list"><input type="hidden" value="0" class="count_pending_building"></div>
                    <div id="sold_list" class="item_view_db idxboost_collection_sold_list"><input type="hidden" value="0" class="count_sold_building"></div>
                  </div>

                  <div class="mode_view" id="view_grid">
                    <ul class="result-search slider-generator idxboost_collection_tab_sale" id="tab_sale"></ul>
                    <ul class="result-search slider-generator idxboost_collection_tab_rent" id="tab_rent"></ul>
                    <ul class="result-search slider-generator idxboost_collection_tab_pending" id="tab_pending"></ul>
                    <ul class="result-search slider-generator idxboost_collection_tab_sold" id="tab_sold"></ul>
                  </div>

                  <div class="gwr" id="paginator-cnt">
                    <nav id="nav-results" class="nav_results_pag idx-group-subarea-sale"></nav>
                    <nav id="nav-results" class="nav_results_pag idx-group-subarea-rent"></nav>
                    <nav id="nav-results" class="nav_results_pag idx-group-subarea-pending"></nav>
                    <nav id="nav-results" class="nav_results_pag idx-group-subarea-sold"></nav>
                  </div>

                </div>
              </div>
            </div>
          </div>
        </section>
      </div>
    </main>
    
    <input type="hidden" class="ib_collection_view" value="list" >
    <input type="hidden" class="ib_collection_tab" value="tab_sale" >
<style type="text/css">
  .item_view_db{
    display: none;
  }
  #view_list .active {
      display: block;
    }
    .result-search{
      display: none !important;
    }
  .result-search.active {
      display: flex !important;
  }    
</style>
<script type="text/javascript">
var ib_collection_desk_li;
</script>
<style type="text/css">
.desactivo { display: none !important; }
.green { color: green; }
</style>

<script type="text/javascript">
  var objecto_test;
(function($) {

    function active_modal($modal) {
        if ($modal.hasClass('active_modal')) {
            $('.overlay_modal').removeClass('active_modal');
            $("html, body").animate({
                scrollTop: 0
            }, 1500);
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

$(function() {
// setup favorite

$(document).on('ready',function(event){
  jQuery('#filter-views li.active').click();
});

$(document).on("click", '.flex-favorite-btn', function(event) {
  event.stopPropagation();

  var _self = $(this);

  if (__flex_g_settings.anonymous === 'yes') {
   // active_modal($('#modal_login'));
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

    if (_self.parent().data("mls")!= undefined){
      var mls_num = _self.parent().data("mls");
    }else{
      var mls_num = _self.parent().parent().data("mls");
    }
    

    if (!_self.hasClass('flex-active-fav')) { // add
      _self.addClass('flex-active-fav');
      _self.find('span').addClass('active');

      $.ajax({
          url: __flex_g_settings.ajaxUrl,
          method: "POST",
          data: {
              action: "flex_favorite",
              mls_num: mls_num,
              type_action: 'add'
          },
          dataType: "json",
          success: function(data) {
              _self.attr("data-alert-token",data.token_alert);
          }
      });
    } else {
      // remove
      _self.removeClass('flex-active-fav');
      _self.find('span').removeClass('active');

      var token_alert = _self.attr("data-alert-token");

      $.ajax({
          url: __flex_g_settings.ajaxUrl,
          method: "POST",
          data: {
              action: "flex_favorite",
              mls_num: mls_num,
              type_action: 'remove',
              token_alert: token_alert
          },
          dataType: "json",
          success: function(data) {
              _self.removeAttr('data-alert-token');
          }
      });
    }
  }
});

});

})(jQuery);
</script>
<script type="text/javascript">
  var view_grid_type='';
  jQuery('body').addClass('buildingPage');
  <?php
  $sta_view_grid_type='0'; if(array_key_exists('view_grid_type',$search_params)) $sta_view_grid_type=$search_params['view_grid_type']; ?>
  view_grid_type=<?php echo $sta_view_grid_type; ?>;
  if ( !jQuery('body').hasClass('clidxboost-ngrid') && view_grid_type==1) {
    jQuery('body').addClass('clidxboost-ngrid');
  }
</script>

<?php
 if ($atts['sockets'] =='on') {
    include FLEX_IDX_PATH . '/views/shortcode/idxboost_modals_filter.php';  
} 
 
 ?>
