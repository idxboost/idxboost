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

<style type="text/css">
  .ms-wrap-shortcode-inventory .desactivo { display: none !important; }
  .ms-wrap-shortcode-inventory .green { color: green; }

  .ms-wrap-shortcode-inventory .property-information {
    border: 1px solid #e5e5e5;
    display: flex;
    flex-wrap: wrap;
    justify-content: space-between;
    position: relative;
    align-items: flex-end;
    margin-bottom: 1rem;
    padding-bottom: 0.625rem;
    background-color: #FFF;
  }

  .ms-wrap-shortcode-inventory .property-information li {
    position: relative;
  }

  .ms-wrap-shortcode-inventory .property-information li.price {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    width: 100%;
    background-color: #f3f3f3;
    font-size: 1.25rem;
    order: 2;
    margin: 0.625rem;
    height: 80px;
    font-size: 1.25rem;
    font-family: "Open Sans", sans-serif;
    font-weight: 600;
  }

  .ms-wrap-shortcode-inventory .property-information li.price span {
    font-weight: 600;
    color: #5f5f5f;
    font-size: 0.875rem;
    display: block;
  }

  .ms-wrap-shortcode-inventory .property-information li.item-list {
    width: 100%;
    display: flex;
    justify-content: space-between;
    height: 40px;
    border-bottom: 1px solid #d9d9d9;
    align-items: center;
    margin: 0 0.9375rem;
    order: 3;
  }

  .ms-wrap-shortcode-inventory .property-information li.item-list {
    height: auto!important;
    min-height: 40px;
    padding: 7px 0;
  }

  .ms-wrap-shortcode-inventory .property-information li.item-list:last-child {
    border-bottom: 0;
  }

  .ms-wrap-shortcode-inventory .property-information li.item-list span {
    font-size: 0.875rem;
    text-transform: none;
    color: #808080;
  }

  .ms-wrap-shortcode-inventory .wp-statisticss{
    margin-bottom: 15px
  }

  .ms-wrap-shortcode-inventory .condo-statics{
    margin-bottom: 0
  }

  .ms-wrap-shortcode-inventory .condo-statics,
  .ms-wrap-shortcode-inventory .wp-statisticss{
    border: 1px solid #e5e5e5;
    padding: 0 15px 25px 15px;
  }

  .ms-wrap-shortcode-inventory .ms-wrap-content-st{
    display:flex;
    flex-wrap: wrap;
  }

  .ms-wrap-shortcode-inventory .ms-wrap-content-st .ms-item{
    width: 100%
  }

  .ms-wrap-shortcode-inventory .ms-wrap-content-st .ms-item.ms-order-c{
    order: 1
  }

  .ms-wrap-shortcode-inventory .ms-wrap-content-st .ms-item.ms-order-a{
    order: 2
  }

  .ms-wrap-shortcode-inventory .ms-wrap-content-st .ms-item.ms-order-b{
    order: 3
  }

  @media screen and (min-width: 1024px){
    .ms-wrap-shortcode-inventory .ms-wrap-content-st{
      align-items: flex-start;
      flex-wrap: nowrap;
    }

    .ms-wrap-shortcode-inventory .ms-wrap-content-st .ms-item{
      width: 32%;
      margin-right: 2%;
    }

    .ms-wrap-shortcode-inventory .ms-wrap-content-st .ms-item:last-child{
      margin-right: 0
    }

    .ms-wrap-shortcode-inventory .ms-wrap-content-st .ms-item.ms-order-a{
      order: 1
    }

    .ms-wrap-shortcode-inventory .ms-wrap-content-st .ms-item.ms-order-b{
      order: 2
    }

    .ms-wrap-shortcode-inventory .ms-wrap-content-st .ms-item.ms-order-c{
      order: 3
    }

    .ms-wrap-shortcode-inventory .ms-wrap-content-st .ms-item .condo-statics .condo-st li {
      font-size: 0.875rem;
      margin-bottom: 5px;
    }
  }

</style>

<script type="text/javascript">
  var idxboostCollecBuil=[];
</script>

<div class="ms-wrap-shortcode-inventory">
  <form name="idxboost_collection_xr" class="idxboost_collection_xr" id="idxboost_collection_xr">
    <input type="hidden" name="action" value="idxboost_collection_list">
    <input type="hidden" name="building_id" value="<?php echo $atts['building_id'];?>">
  </form>
  <div class="r-overlay"></div>
  <div class="property-details theme-3">
    <div class="full-main">
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
              <div class="container wp-thumbs wrap-result idxboost-type-view-wrap-result ib_content_views_building" id="view-list">
                <div id="wrap-subfilters">
                  <div class="gwr ms-full-wrap">
                    <ul id="sub-filters">
                      <li id="link-favorites">
                        <a class="clidxboost-icon-favorite" role="button" title="Save Favorites" rel="nofollow">
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
                            <?php if ($GLOBALS['result_detailt_building']['payload']['property_display_active']=='grid') { echo "selected"; } ?>
                            forview="view_grip"><?php echo __('Grid', IDXBOOST_DOMAIN_THEME_LANG); ?></option>
                          <option value="list" <?php if ($GLOBALS['result_detailt_building']['payload']['property_display_active']=='list') { echo "selected"; } ?> forview="view_list"><?php echo __('List', IDXBOOST_DOMAIN_THEME_LANG); ?></option>
                        </select>
                      </li>
                    </ul>
                  </div>
                </div>
                <div class="mode_view" id="view_list">
                  <div id="sale_list" class="item_view_db idxboost_collection_sale_list"><input type="hidden" value="0" class="count_sale_building">
                    <?php
                      if (
                        (!empty($result_data_collection) &&  is_array($result_data_collection) && array_key_exists('success', $result_data_collection) && $result_data_collection['success']) &&
                        ( !empty($result_data_collection['payload']) &&  is_array($result_data_collection['payload']) && count($result_data_collection['payload'])>0   ) && 
                        ( !empty($result_data_collection['payload']['properties']) &&  is_array($result_data_collection['payload']['properties']) && count($result_data_collection['payload']['properties'])>0   ) && 
                        ( array_key_exists('sale', $result_data_collection['payload']['properties']) && is_array($result_data_collection['payload']['properties']['sale']) && count($result_data_collection['payload']['properties']['sale']) >0 )
                      ) 
                      {
                        flex_idx_get_building_noscript_inventory($result_data_collection['payload']['properties']['sale']['items'],__('For Sale', IDXBOOST_DOMAIN_THEME_LANG),'for_sale' );
                      }
                        ?>
                  </div>
                  <div id="rent_list" class="item_view_db idxboost_collection_rent_list"><input type="hidden" value="0" class="count_rent_building">
                    <?php
                      if (
                        (!empty($result_data_collection) &&  is_array($result_data_collection) && array_key_exists('success', $result_data_collection) && $result_data_collection['success']) &&
                        ( !empty($result_data_collection['payload']) &&  is_array($result_data_collection['payload']) && count($result_data_collection['payload'])>0   ) && 
                        ( !empty($result_data_collection['payload']['properties']) &&  is_array($result_data_collection['payload']['properties']) && count($result_data_collection['payload']['properties'])>0   ) && 
                        ( array_key_exists('rent', $result_data_collection['payload']['properties']) && is_array($result_data_collection['payload']['properties']['rent']) && count($result_data_collection['payload']['properties']['rent']) >0 )
                      ) 
                      {
                        flex_idx_get_building_noscript_inventory($result_data_collection['payload']['properties']['rent']['items'],__('For Rent', IDXBOOST_DOMAIN_THEME_LANG),'for_rent');
                        }
                      ?>
                    <input type="hidden" value="<?php echo $countar;?>" class="count_rent_building">
                  </div>
                  <div id="pending_list" class="item_view_db idxboost_collection_pending_list"><input type="hidden" value="0" class="count_pending_building">
                    <?php
                      if (
                        (!empty($result_data_collection) &&  is_array($result_data_collection) && array_key_exists('success', $result_data_collection) && $result_data_collection['success']) &&
                        ( !empty($result_data_collection['payload']) &&  is_array($result_data_collection['payload']) && count($result_data_collection['payload'])>0   ) && 
                        ( !empty($result_data_collection['payload']['properties']) &&  is_array($result_data_collection['payload']['properties']) && count($result_data_collection['payload']['properties'])>0   ) && 
                        ( array_key_exists('pending', $result_data_collection['payload']['properties']) && is_array($result_data_collection['payload']['properties']['pending']) && count($result_data_collection['payload']['properties']['pending']) >0 )
                      ) 
                      {
                        flex_idx_get_building_noscript_inventory($result_data_collection['payload']['properties']['pending']['items'],__('Pending', IDXBOOST_DOMAIN_THEME_LANG),'pending');
                      }
                        ?>
                  </div>
                  <div id="sold_list" class="item_view_db idxboost_collection_sold_list"><input type="hidden" value="0" class="count_sold_building">
                    <?php
                      if (
                        (!empty($result_data_collection) &&  is_array($result_data_collection) && array_key_exists('success', $result_data_collection) && $result_data_collection['success']) &&
                        ( !empty($result_data_collection['payload']) &&  is_array($result_data_collection['payload']) && count($result_data_collection['payload'])>0   ) && 
                        ( !empty($result_data_collection['payload']['properties']) &&  is_array($result_data_collection['payload']['properties']) && count($result_data_collection['payload']['properties'])>0   ) && 
                        ( array_key_exists('sold', $result_data_collection['payload']['properties']) && is_array($result_data_collection['payload']['properties']['sold']) && count($result_data_collection['payload']['properties']['sold']) >0 )
                      ) 
                      {
                        flex_idx_get_building_noscript_inventory($result_data_collection['payload']['properties']['sold']['items'],__('Sold', IDXBOOST_DOMAIN_THEME_LANG),'sold');
                      }
                        ?>
                  </div>
                </div>
                <div class="mode_view" id="view_grid">
                  <ul class="result-search slider-generator idxboost_collection_tab_sale" id="tab_sale"></ul>
                  <ul class="result-search slider-generator idxboost_collection_tab_rent" id="tab_rent"></ul>
                  <ul class="result-search slider-generator idxboost_collection_tab_pending" id="tab_pending"></ul>
                  <ul class="result-search slider-generator idxboost_collection_tab_sold" id="tab_sold"></ul>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>
    </div>
  </div>
  <div class="ms-wrap-content-st">

    <div class="ms-item ms-order-a">
      <div class="wp-statisticss">
        <h2 class="subtitle-b" data-title="<?php echo __('Inventory', IDXBOOST_DOMAIN_THEME_LANG); ?>">
          <?php
            if ($response['payload']['is_marketing'] != false) {
              echo $response['payload']['name_building'] . ' ' . __('Inventory', IDXBOOST_DOMAIN_THEME_LANG);
            } else {
              echo __('Inventory', IDXBOOST_DOMAIN_THEME_LANG);
            } ?>
        </h2>
        <div id="chart-container"><?php echo __('FusionCharts will render here', IDXBOOST_DOMAIN_THEME_LANG); ?></div>
        <div class="cols inventory-sta">
          <h4><?php echo __('Inventory', IDXBOOST_DOMAIN_THEME_LANG); ?></h4>
          <div class="data-inventory group-flex">
            <div class="div">
              <div class="cir-sta sale">0</div>
              <?php echo __('For sale', IDXBOOST_DOMAIN_THEME_LANG); ?>
            </div>
            <div class="div">
              <div class="cir-sta rent">0</div>
              <?php echo __('For rent', IDXBOOST_DOMAIN_THEME_LANG); ?>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="ms-item ms-order-b">
      <div class="condo-statics">
        <h2 class="subtitle-b" data-title="<?php echo __('Condo Statistics', IDXBOOST_DOMAIN_THEME_LANG); ?>">
          <?php
            if ($response['payload']['is_marketing'] != false) {
              echo $response['payload']['name_building'] . ' ' . __('Statistics', IDXBOOST_DOMAIN_THEME_LANG);
            } else {
              echo __('Condo Statistics', IDXBOOST_DOMAIN_THEME_LANG);
            } ?>
        </h2>
        <ul class="condo-st">
          <li><span class="ib_inventory_min_max_price">$0</span><?php echo __('Price Range', IDXBOOST_DOMAIN_THEME_LANG); ?></li>
          <li><span class="ib_inventory_avg_price">$0</span><?php echo __('avg price', IDXBOOST_DOMAIN_THEME_LANG); ?> / Sq.Ft.</li>
          <li><span class="ib_inventory_days_market">0 </span><?php echo __('avg days on market', IDXBOOST_DOMAIN_THEME_LANG); ?></li>
          <li><?php echo __("of building is for sale", IDXBOOST_DOMAIN_THEME_LANG); ?><span class="ib_inventory_sale"> 0 %</span></li>
          <li><?php echo __("of building is for rent", IDXBOOST_DOMAIN_THEME_LANG); ?><span class="ib_inventory_rent"> 0 %</span></li>
          <li><?php echo __("of building sold in previous 12 months", IDXBOOST_DOMAIN_THEME_LANG); ?> <span class="ib_inventory_previous">0 %</span></li>
        </ul>
      </div>
    </div>

    <div class="ms-item ms-order-c js-block-detail-building" style="display: none;">
      <ul class="property-information ltd d-hidden">
                <li class="price"></li>
                <li class="item-list"> <span><?php echo __('Bedrooms', IDXBOOST_DOMAIN_THEME_LANG); ?></span><span class="js-bedroom"></span></li>
                <li class="item-list"> <span><?php echo __('Year Built', IDXBOOST_DOMAIN_THEME_LANG); ?></span><span class="js-year"></span></li>
                <li class="item-list"> <span><?php echo __('Units', IDXBOOST_DOMAIN_THEME_LANG); ?></span><span class="item-list-units-un js-unit_building"></span></li>
                <li class="item-list"> <span><?php echo __('Stories', IDXBOOST_DOMAIN_THEME_LANG); ?></span><span class="js-floor_building"></span></li>
                <li class="item-list"> <span><?php echo __('Average Price', IDXBOOST_DOMAIN_THEME_LANG); ?> <?php echo __('Sq.Ft.', IDXBOOST_DOMAIN_THEME_LANG); ?></span><span class="ib_inventory_avg_price">$0</span></li>
                <li class="item-list"> <span><?php echo __('Average Days on Market', IDXBOOST_DOMAIN_THEME_LANG); ?></span><span class="ib_inventory_days_market">0</span></li>
      </ul>
    </div>
  </div>
  <input type="hidden" class="ib_building_unit">
  <input type="hidden" class="ib_collection_view" value="list">
  <input type="hidden" class="ib_collection_tab" value="tab_sale">
</div>

<script type="text/javascript">
  var ib_collection_desk_li;
</script>

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
          active_modal($('#modal_login'));
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

<?php include FLEX_IDX_PATH . '/views/shortcode/idxboost_modals_filter.php';  ?> 
