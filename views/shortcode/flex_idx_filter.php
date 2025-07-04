<?php
  $idxboost_query_slug = $_SERVER['QUERY_STRING'];
  $idxboost_ver_bool=true;

  if (is_array($response) && count($response) > 0 && array_key_exists("view", $response)) {
    $response["view"] = str_replace($response["view"], "view-", "");
  }
  

  if ((isset($_GET["savefilter"]) && ("1" == $_GET["savefilter"]))):
  // if ((isset($_GET["savefilter"]) && ("1" == $_GET["savefilter"])) || (is_singular('flex-filter-pages') && (true === $registration_is_forced))):
?>
<script type="text/javascript">
  (function ($) {
    $(function() {
      setTimeout(function () {
        if ("yes" == __flex_g_settings.anonymous) {
          $("button.close").css("visibility", "hidden");
          $("#filter-save-search").click();
        }
      }, 1500);
    });
  })(jQuery);
</script>
<?php endif; ?>
<?php
  $class_multi='0';
  if (empty($atts['id']))
    $class_multi=time();
  else
    $class_multi=$atts['id'];
  ?>
<?php
  $filterid='';
  if ($atts['method']==0)
    $filterid=get_the_ID();

  //$parking=$response['info']['parking_option'];
  $features_info=$response['info']['features'];
  $othersfeatures_info=$response['info']['othersamenities'];
  
  if (!is_array($othersfeatures_info) || empty($othersfeatures_info)) {
    $othersfeatures_info = [];
  }
  
  $water_desc=$response['info']['waterfront_option'];
  $sta_view_grid_type='0'; if(array_key_exists('view_grid_type',$search_params)) $sta_view_grid_type=$search_params['view_grid_type'];
  $filter_type='0'; if(array_key_exists('filter_type',$response)) $filter_type=$response['filter_type'];
  
  $filter_params_alert=array(
    "sale_type"=> isset($response['info']['rental_type']) ? $response['info']['rental_type'] : null,
    "min_beds"=> isset($response['info']['min_bedrooms']) ? $response['info']['min_bedrooms'] : null,
    "max_beds"=> isset($response['info']['max_bedrooms']) ? $response['info']['max_bedrooms'] : null,
    "min_baths"=> isset($response['info']['min_baths']) ? $response['info']['min_baths'] : null,
    "max_baths"=> isset($response['info']['max_baths']) ? $response['info']['max_baths'] : null,
    "min_living_size"=>isset($response['info']['min_living_size']) ? $response['info']['min_living_size'] : null,
    "max_living_size"=> isset($response['info']['max_living_size']) ? $response['info']['max_living_size'] : null
  );

  if ( isset($response) && $response['info']['rental_type']=='0') {
      $filter_params_alert["min_sale_price"] = isset($response['info']['min_price']) ? $response['info']['min_price'] : null;
      $filter_params_alert["max_sale_price"] = isset($response['info']['max_price']) ? $response['info']['max_price'] : null;
  }else{
      $filter_params_alert["min_rent_price"] = isset($response['info']['min_price']) ? $response['info']['min_price'] : null;
      $filter_params_alert["max_rent_price"] = isset($response['info']['max_price']) ? $response['info']['max_price'] : null;
  }
?>
<script>
  //var filter_metadata = <?php echo json_encode($response); ?>;
  var ib_filter_metadata = <?php echo json_encode($response); ?>;
  var search_metadata = <?php echo trim(json_encode($search_params)); ?>;
</script>
<style>
  #wrap-result.view-list #result-search > li .features li.address.-grid-map{display:none} 
  .wrap-result.view-grid #result-search > li .features.ms-padding{padding-bottom: 56px !important}
</style>
<form method="post" id="flex-idx-filter-form" class="flex-idx-filter-form flex-idx-filter-form-<?php echo $class_multi; ?> idxboost-filter-form" data-filter-form-id="<?php echo $unique_filter_form_ID; ?>" filtemid="<?php echo $class_multi; ?>">
  <input type="hidden" name="action" value="filter_search">
  <input type="hidden" name="filter_ID" value="<?php echo get_the_ID(); ?>">
  <?php if (flex_has_filter_url_params()): ?>
  <input type="hidden" name="filter_search_url_params" value='<?php echo flex_get_filter_url_params(); ?>'>
  <?php endif; ?> 
  <input type="hidden" name="search_count" id="search_count" value="<?php echo $response['counter']; ?>">
    
  <input type="hidden" name="hide_pending" id="hide_pending" value="<?php echo $atts["pending"]; ?>">
  <input type="hidden" name="dom" id="dom" value="<?php echo $atts["dom"]; ?>">
  <input type="hidden" name="county" id="county" value="<?php echo $atts["county"]; ?>">
  <input type="hidden" name="photores" id="idx_photores" value="<?php echo $atts["photo-res"]; ?>">

  <input type="hidden" name="idx[min_price]" id="idx_min_price" value="<?php echo $response['info']['min_price']; ?>">
  <input type="hidden" name="idx[max_price]" id="idx_max_price" value="<?php echo $response['info']['max_price']; ?>">
  
  <input type="hidden" name="idx[min_rent_price]" id="idx_min_rent_price" value="<?php echo $response['info']['min_price']; ?>">
  <input type="hidden" name="idx[max_rent_price]" id="idx_max_rent_price" value="<?php echo $response['info']['max_price']; ?>">

  <input type="hidden" name="idx[tab]" id="idx_property_type" value="<?php echo $response['info']['property_type']; ?>">
  <input type="hidden" name="idx[rental]" id="idx_rental" value="<?php echo $response['info']['rental_type']; ?>">
  
  <input type="hidden" name="idx[min_beds]" id="idx_min_beds" value="<?php echo $response['info']['min_bedrooms']; ?>">
  <input type="hidden" name="idx[max_beds]" id="idx_max_beds" value="<?php echo $response['info']['max_bedrooms']; ?>">

  <input type="hidden" name="idx[min_baths]" id="idx_min_baths" value="<?php echo $response['info']['min_baths']; ?>">
  <input type="hidden" name="idx[max_baths]" id="idx_max_baths" value="<?php echo $response['info']['max_baths']; ?>">

  <input type="hidden" name="idx[min_year]" id="idx_min_year" value="<?php echo $response['info']['min_year']; ?>">
  <input type="hidden" name="idx[max_year]" id="idx_max_year" value="<?php echo $response['info']['max_year']; ?>">

  <input type="hidden" name="idx[min_sqft]" id="idx_min_sqft" value="<?php echo $response['info']['min_living_size']; ?>">
  <input type="hidden" name="idx[max_sqft]" id="idx_max_sqft" value="<?php echo $response['info']['max_living_size']; ?>">

  <input type="hidden" name="idx[min_lotsize]" id="idx_min_lotsize" value="<?php echo $response['info']['min_lot_size']; ?>">
  <input type="hidden" name="idx[max_lotsize]" id="idx_max_lotsize" value="<?php echo $response['info']['max_lot_size']; ?>">

  <input type="hidden" name="idx[waterfront]" id="idx_water_desc" value="<?php echo $response['info']['waterfront_option']; ?>">
  <input type="hidden" name="idx[parking]" id="idx_parking" value="<?php echo $response['info']['parking_option']; ?>">
  <input type="hidden" name="idx[features]" id="idx_features" value="<?php echo (isset($response['info']['features']) && is_array($response['info']['features'])) ? implode('|', $response['info']['features']) : ''; ?>">
  <input type="hidden" name="idx[othersamenities]" id="idx_othersamenities" value="<?php echo (isset($response['info']['othersamenities']) && is_array($response['info']['othersamenities'])) ? implode('|', $response['info']['othersamenities']) : ''; ?>">

  <input type="hidden" name="idx[oh]" id="idx_oh" value="<?php echo $atts['oh']; ?>">


  <input type="hidden" name="idx[view]" id="idx_view" value="<?php echo $response['view']; ?>">
  <input type="hidden" name="idx[sort]" id="idx_sort" value="<?php echo $response['order']; ?>">
  <input type="hidden" name="idx[page]" id="idx_page" value="<?php echo $response['pagination']['current_page_number']; ?>">
  <input type="hidden" name="filter_panel" id="filter_panel" value="<?php echo $atts['id']; ?>">
  <input type="hidden" name="filter_type" id="filter_type" value="<?php echo $atts['type']; ?>">
  <input type="hidden" name="limit" class="limit" value="<?php echo $atts['limit']; ?>">

  <input type="hidden" name="filter_condition" id="idx_filter_condition" class="filter_condition" value="<?php echo htmlspecialchars(stripslashes(addslashes($response['condition']))); ?>">
  <input type="hidden" name="filter_params_alert" id="filter_params_alert" class="filter_params_alert" value=<?php echo json_encode($filter_params_alert); ?>>
</form>
<?php
  global $post;
  $filter_favorite_idxboost=0;
  //$filter_type_fl = get_post_meta($post->ID, '_flex_filter_page_fl', true);
  $filter_type_fl = 3;
  if (empty($filter_type_fl)) {
    $filter_type_fl=$typeworked;
  }
  $viewfilter='';
  if (empty($response['view']))  $viewfilter='grid'; else $viewfilter=$response['view'];
  ?>
<div class="clidxboost-sc-filters idxboost-content-filter-<?php echo $class_multi; ?>" filtemid="<?php echo $class_multi; ?>">
  <div class="content-filters" <?php if($filter_type_fl != 3): ?> style="display:none;" <?php endif; ?> >
    <div class="animated fixed-box" id="wrap-filters">
      <div class="gwr gwr-filters">
        <div id="header-filters" style="display: none">
          <div class="idx_logo_web">
            <?php if (function_exists('idx_the_custom_logo_header')): ?>
            <?php idx_the_custom_logo_header(); ?>
            <?php endif; ?>
          </div>
          <div class="text-wrapper">
            <div class="allf-callus"><?php echo __("Call us", IDXBOOST_DOMAIN_THEME_LANG); ?>: <a href="telf:<?php echo preg_replace('/[^\d+]/', '', $flex_idx_info['agent']['agent_contact_phone_number']); ?>">
              <?php echo flex_phone_number_filter($flex_idx_info['agent']['agent_contact_phone_number']); ?></a>
            </div>
          </div>
        </div>
        <!-- EN EL TYPE 4 NO VA LA BARRA BUSCADORA POR QUE ESTA OBTENIENDO POR LOS MLSNUM ES UNA VISTA PERSONALIZADA DE PROPIEDADES-->
        <?php if($filter_type !='4') { ?>
        <ul id="filters">
          <li class="price">
            <button> <span class="clidxboost-icon-arrow-select"> <span id="text-price"><?php echo __("Any Price", IDXBOOST_DOMAIN_THEME_LANG); ?></span></span></button>
          </li>
          <li class="beds">
            <button> <span class="clidxboost-icon-arrow-select"> <span id="text-beds"><?php echo __("Any Bed", IDXBOOST_DOMAIN_THEME_LANG); ?></span></span></button>
          </li>
          <li class="baths">
            <button> <span class="clidxboost-icon-arrow-select"> <span id="text-baths"><?php echo __("Any Bath", IDXBOOST_DOMAIN_THEME_LANG); ?></span></span></button>
          </li>
          <?php 
          //var_dump($search_params['property_types']);
          //if(in_array($property_type["value"], $ptypes_checked))
          $property_types_label=array_map(function($item){ return $item['label'];}, $search_params['property_types']);
          ?>
          <li class="type">
            <button> <span class="clidxboost-icon-arrow-select"> <span id="text-type">
              <?php
              $property_types_text=[];
              if (is_array($ptypes_checked) && count($ptypes_checked)>0 ) {

                foreach ($search_params['property_types'] as $property_type){
                    $text_label_trans='';
                    if($property_type['label']=='Homes'){
                      if(in_array($property_type["value"], $ptypes_checked)){
                        $text_label_trans=__("Homes", IDXBOOST_DOMAIN_THEME_LANG);
                      }
                    }else if($property_type['label']=='Condominiums'){
                      if(in_array($property_type["value"], $ptypes_checked)){
                        $text_label_trans=__("Condominiums", IDXBOOST_DOMAIN_THEME_LANG);
                      }
                    }else if($property_type['label']=='Townhouses'){
                      if(in_array($property_type["value"], $ptypes_checked)){
                        $text_label_trans=__("Townhouses", IDXBOOST_DOMAIN_THEME_LANG);
                      }
                    }else if ($property_type['label']=='Single Family Homes'){
                      if(in_array($property_type["value"], $ptypes_checked)){
                        $text_label_trans=__("Homes", IDXBOOST_DOMAIN_THEME_LANG);
                      }
                    }else if ($property_type['label']=='Vacant Land'){
                      if(in_array($property_type["value"], $ptypes_checked)){
                        $text_label_trans=__("Vacant Land", IDXBOOST_DOMAIN_THEME_LANG);
                      }
                    }else if ($property_type['label']=='Multi-Family'){
                      if(in_array($property_type["value"], $ptypes_checked)){
                        $text_label_trans=__("Multi-Family", IDXBOOST_DOMAIN_THEME_LANG);
                      }
                    }else if ($property_type['label']=='Co-op'){
                      if(in_array($property_type["value"], $ptypes_checked)){
                        $text_label_trans=__("Co-op", IDXBOOST_DOMAIN_THEME_LANG);
                      }
                    }else{
                      if ( !in_array($property_type['label'],["com","bus"]) ){

                        if(in_array($property_type["value"], $ptypes_checked)){
                          $text_label_trans=$property_type['label'];
                        }
                        
                      }

                    }
                      if (!empty($text_label_trans)) {
                        $property_types_text[]=$text_label_trans;
                      }
                  }
                  
                  if (count($property_types_text)===5) {
                    echo __('Any type', IDXBOOST_DOMAIN_THEME_LANG);
                  }else{
                    echo implode(', ', $property_types_text);
                  }                
              }else{
                echo __('Any type', IDXBOOST_DOMAIN_THEME_LANG);
              }              
              ?>              
              </span></span></button>
          </li>

          <li class="all ib-oadbanced">
            <button>
              <span class="clidxboost-icon-arrow-select">
                <span class="idx-text-pc"><?php echo __("More Filters", IDXBOOST_DOMAIN_THEME_LANG); ?></span>
                <span class="idx-text-mb"><?php echo __("Filters", IDXBOOST_DOMAIN_THEME_LANG); ?></span>
              </span>
            </button>
          </li>
          <li class="save">
            <button type="button" id="filter-save-search" data-count="<?php echo (int) $response['pagination']['total_items_count']; ?>" style="display: block;width: 100%;background: #333;height: 100%;color: #fff;margin: 0;"><?php echo __("Save Search", IDXBOOST_DOMAIN_THEME_LANG); ?></button>
          </li>
        </ul>
      <?php } ?>

      <div id="all-filters">
        <ul class="hidden-sr" id="mini-filters">
          <li class="price" style="order:0">
            <div class="gwr">
              <h4 class="clidxboost-icon-arrow-select"><?php echo __("Price Range", IDXBOOST_DOMAIN_THEME_LANG); ?></h4>
              <div class="wrap-item price_range_for_sale price_ranges_ct" <?php if($response['info']['rental_type'] == 1): ?> style="display:none;" <?php endif; ?>>
                <div class="wrap-inputs">
                  <label class="ms-hidden" for="price_from"><?php echo __("Price Range from", IDXBOOST_DOMAIN_THEME_LANG); ?></label>
                  <input id="price_from" class="notranslate" type="text" value=""> <span><?php echo __("to", IDXBOOST_DOMAIN_THEME_LANG); ?></span>
                  <label class="ms-hidden" for="price_to"><?php echo __("Price Range to", IDXBOOST_DOMAIN_THEME_LANG); ?></label>
                  <input id="price_to" class="notranslate" type="text" value="">
                </div>
                <div class="wrap-range">
                  <div id="range-price" class="range-slide"></div>
                </div>
              </div>
              <div class="wrap-item price_range_for_rent price_ranges_ct" <?php if($response['info']['rental_type'] == 0): ?> style="display:none;" <?php endif; ?>>
                <div class="wrap-inputs">
                  <label class="ms-hidden" for="price_rent_from"><?php echo __("Price rent from", IDXBOOST_DOMAIN_THEME_LANG); ?></label>
                  <input id="price_rent_from" class="notranslate" type="text" value=""><span><?php echo __("to", IDXBOOST_DOMAIN_THEME_LANG); ?></span>
                  <label class="ms-hidden" for="price_rent_to"><?php echo __("Price rent to", IDXBOOST_DOMAIN_THEME_LANG); ?></label>
                  <input id="price_rent_to" class="notranslate" type="text" value="">
                </div>
                <div class="wrap-range">
                  <div id="range-price-rent" class="range-slide"></div>
                </div>
              </div>
            </div>
          </li>
          <li class="baths" style="order:1">
            <div class="gwr">
              <h4 class="clidxboost-icon-arrow-select"><?php echo __("Bathrooms", IDXBOOST_DOMAIN_THEME_LANG); ?></h4>
              <div class="wrap-item">
                <div class="wrap-range">
                  <div class="range-slide" id="range-baths"></div>
                </div>
                <ul class="markers-range">
                  <?php foreach ($search_params['baths_range'] as $index => $bath_range): ?>
                  <?php if ($index == 0){ ?>
                  <li><span><?php echo $bath_range['label']; ?></span></li>
                  <?php }else{ ?>
                  <li><?php echo $bath_range['label']; ?></li>
                  <?php } ?>
                  <?php endforeach; ?>
                </ul>
              </div>
            </div>
          </li>
          <li class="beds" style="order:5">
            <div class="gwr">
              <h4 class="clidxboost-icon-arrow-select"><?php echo __("Bedrooms", IDXBOOST_DOMAIN_THEME_LANG); ?></h4>
              <div class="wrap-item">
                <div class="wrap-range">
                  <div class="range-slide" id="range-beds"></div>
                </div>
                <ul class="markers-range">
                  <?php foreach ($search_params['beds_range'] as $index => $bath_range): ?>
                  <?php if ($index == 0){ ?>
                  <li><span><?php echo $bath_range['label']; ?></span></li>
                  <?php }else{ ?>
                  <li><?php echo $bath_range['label']; ?></li>
                  <?php } ?>
                  <?php endforeach; ?>
                </ul>
              </div>
            </div>
          </li>
          <li class="type" style="order:8">
            <div class="gwr">
              <h4 class="clidxboost-icon-arrow-select"><?php echo __("Type", IDXBOOST_DOMAIN_THEME_LANG); ?></h4>
              <div class="wrap-item">
                <div class="wrap-checks">
                  <ul>
                    <?php
                      foreach ($search_params['property_types'] as $property_type): ?>
                    <li>
                      <input class="property_type_checkbox" type="checkbox" <?php if(in_array($property_type["value"], $ptypes_checked)): ?> checked <?php endif; ?> value="<?php echo $property_type['value']; ?>" id="_pt_<?php echo $property_type['value']; ?>">
                      <label for="_pt_<?php echo $property_type['value']; ?>"><?php 
                      $text_label_trans='';
                      if($property_type['label']=='Homes'){
                          $text_label_trans=__("Homes", IDXBOOST_DOMAIN_THEME_LANG);
                      }else if($property_type['label']=='Condominiums'){
                          $text_label_trans=__("Condominiums", IDXBOOST_DOMAIN_THEME_LANG);
                      }else if($property_type['label']=='Townhouses'){
                          $text_label_trans=__("Townhouses", IDXBOOST_DOMAIN_THEME_LANG);
                      }else if ($property_type['label']=='Single Family Homes'){
                          $text_label_trans=__("Single Family Homes", IDXBOOST_DOMAIN_THEME_LANG);
                      }else if ($property_type['label']=='Multi-Family'){
                          $text_label_trans=__("Multi-Family", IDXBOOST_DOMAIN_THEME_LANG);
                      }else if ($property_type['label']=='Vacant Land'){
                      $text_label_trans=__("Vacant Land", IDXBOOST_DOMAIN_THEME_LANG);
                      }else{
                        $text_label_trans = $property_type['label'];
                      }
                      echo $text_label_trans; 
                      ?></label>
                    </li>
                    <?php endforeach; ?>
                  </ul>
                </div>
              </div>
            </div>
          </li>
          <li class="living" style="order:4">
            <div class="gwr">
              <h4 class="clidxboost-icon-arrow-select"><?php echo __("Living size", IDXBOOST_DOMAIN_THEME_LANG); ?></h4>
              <div class="wrap-item">
                <div class="wrap-inputs">
                  <label class="ms-hidden" for="living_from"><?php echo __("Living size from", IDXBOOST_DOMAIN_THEME_LANG); ?></label>
                  <input id="living_from" class="notranslate" type="text" name="" value=""><span><?php echo __("to", IDXBOOST_DOMAIN_THEME_LANG); ?></span>
                  <label class="ms-hidden" for="living_to"><?php echo __("Living size to", IDXBOOST_DOMAIN_THEME_LANG); ?></label>
                  <input id="living_to" class="notranslate" type="text" name="" value="">
                </div>
                <div class="wrap-range">
                  <div class="range-slide" id="range-living"></div>
                </div>
              </div>
            </div>
          </li>
          <li class="year" style="order:2">
            <div class="gwr">
              <h4 class="clidxboost-icon-arrow-select"><?php echo __("Year Built", IDXBOOST_DOMAIN_THEME_LANG); ?></h4>
              <div class="wrap-item">
                <div class="wrap-inputs">
                  <label class="ms-hidden" for="year_from"><?php echo __("Year Built from", IDXBOOST_DOMAIN_THEME_LANG); ?></label>
                  <input id="year_from" type="text" name="" value=""><span><?php echo __("to", IDXBOOST_DOMAIN_THEME_LANG); ?></span>
                  <label class="ms-hidden" for="year_to"><?php echo __("Year Built to", IDXBOOST_DOMAIN_THEME_LANG); ?></label>
                  <input id="year_to" type="text" name="" value="">
                </div>
                <div class="wrap-range">
                  <div class="range-slide" id="range-year"></div>
                </div>
              </div>
            </div>
          </li>
          <li class="waterfront" style="order:7">
            <div class="gwr">
            <?php
            $c_search_settings = get_option("idxboost_search_settings");
            
            $label_waterfront_description = __('Waterfront Description', IDXBOOST_DOMAIN_THEME_LANG);
            if (isset($c_search_settings["board_id"]) && ("11" == $c_search_settings["board_id"])){
              $label_waterfront_description = __("View Description", IDXBOOST_DOMAIN_THEME_LANG);
            }elseif (isset($c_search_settings["board_id"]) && ("16" == $c_search_settings["board_id"])){
              $label_waterfront_description = __("View Features", IDXBOOST_DOMAIN_THEME_LANG);
            }
            ?>

              <h4 class="clidxboost-icon-arrow-select"><?php echo $label_waterfront_description; ?></h4>
              <div class="wrap-item">
                <div class="wrap-select clidxboost-icon-arrow-select">
                  <label class="ms-hidden" for="flex_waterfront_switch">Waterfront options</label>
                  <select id="flex_waterfront_switch">
                    <option value="--"><?php echo __("Any", IDXBOOST_DOMAIN_THEME_LANG); ?></option>
                    <?php foreach ($search_params['waterfront_options'] as $waterfront_option): ?>
                    <option <?php selected((isset($water_desc) ? $water_desc : ''), $waterfront_option['code']); ?> value="<?php echo $waterfront_option['code']; ?>"><?php 
                    $text_label_trans='';
                    if($waterfront_option['name']=='Bay Front')
                        $text_label_trans= __("Bay Front", IDXBOOST_DOMAIN_THEME_LANG);
                    else if ($waterfront_option['name']=='Canal')
                        $text_label_trans= __("Canal", IDXBOOST_DOMAIN_THEME_LANG);
                    else if ($waterfront_option['name']=='Fixed Bridge')
                        $text_label_trans= __("Fixed Bridge", IDXBOOST_DOMAIN_THEME_LANG);
                    else if ($waterfront_option['name']=='Intracoastal')
                        $text_label_trans=__("Intracoastal", IDXBOOST_DOMAIN_THEME_LANG);
                    else if ($waterfront_option['name']=='Lake Front')
                        $text_label_trans= __("Lake Front", IDXBOOST_DOMAIN_THEME_LANG);
                    else if ($waterfront_option['name']=='Ocean Access')
                        $text_label_trans=__("Ocean Access", IDXBOOST_DOMAIN_THEME_LANG);
                    else if ($waterfront_option['name']=="Ocean Front")
                        $text_label_trans=__("Ocean Front", IDXBOOST_DOMAIN_THEME_LANG);
                    else if ($waterfront_option['name']=="Point Lot")
                        $text_label_trans=__("Point Lot", IDXBOOST_DOMAIN_THEME_LANG);
                    else if ($waterfront_option['name']=="River Front")
                        $text_label_trans=__("River Front", IDXBOOST_DOMAIN_THEME_LANG);

                    else if ($waterfront_option['name']=="Park Greenbelt")
                        $text_label_trans=__("Park Greenbelt", IDXBOOST_DOMAIN_THEME_LANG);
                    else if ($waterfront_option['name']=="Mountains")
                        $text_label_trans=__("Mountains", IDXBOOST_DOMAIN_THEME_LANG);
                    else if ($waterfront_option['name']=="Strip View")
                        $text_label_trans=__("Strip View", IDXBOOST_DOMAIN_THEME_LANG);
                    else if ($waterfront_option['name']=="River")
                        $text_label_trans=__("River", IDXBOOST_DOMAIN_THEME_LANG);
                    else if ($waterfront_option['name']=="Lagoon")
                        $text_label_trans=__("Lagoon", IDXBOOST_DOMAIN_THEME_LANG);
                    else if ($waterfront_option['name']=="City")
                        $text_label_trans=__("City", IDXBOOST_DOMAIN_THEME_LANG);
                    else if ($waterfront_option['name']=="Ocean")
                        $text_label_trans=__("Ocean", IDXBOOST_DOMAIN_THEME_LANG);
                    else if ($waterfront_option['name']=="Garden")
                        $text_label_trans=__("Garden", IDXBOOST_DOMAIN_THEME_LANG);
                    else if ($waterfront_option['name']=="Tennis Court")
                        $text_label_trans=__("Tennis Court", IDXBOOST_DOMAIN_THEME_LANG);
                    else if ($waterfront_option['name']=="Water")
                        $text_label_trans=__("Water", IDXBOOST_DOMAIN_THEME_LANG);
                    else if ($waterfront_option['name']=="Pool")
                        $text_label_trans=__("Pool", IDXBOOST_DOMAIN_THEME_LANG);
                    else if ($waterfront_option['name']=="Golf Course")
                        $text_label_trans=__("Golf Course", IDXBOOST_DOMAIN_THEME_LANG);

                    else if ($waterfront_option['name']=="Bay")
                        $text_label_trans=__("Bay", IDXBOOST_DOMAIN_THEME_LANG);
                    else if ($waterfront_option['name']=="Gulf")
                        $text_label_trans=__("Gulf", IDXBOOST_DOMAIN_THEME_LANG);

                    else if ($waterfront_option['name']=="Creek")
                        $text_label_trans=__("Creek", IDXBOOST_DOMAIN_THEME_LANG);

                    else if ($waterfront_option['name']=="Lake")
                        $text_label_trans=__("Lake", IDXBOOST_DOMAIN_THEME_LANG);

                    else if ($waterfront_option['name']=="Mangrove")
                        $text_label_trans=__("Mangrove", IDXBOOST_DOMAIN_THEME_LANG);

                    else if ($waterfront_option['name']=="Navigable")
                        $text_label_trans=__("Navigable", IDXBOOST_DOMAIN_THEME_LANG);

                    else if ($waterfront_option['name']=="River Frontage")
                        $text_label_trans=__("River Frontage", IDXBOOST_DOMAIN_THEME_LANG);

                    else if ($waterfront_option['name']=="Basin")
                        $text_label_trans=__("Basin", IDXBOOST_DOMAIN_THEME_LANG);

                    else if ($waterfront_option['name']=="Seawall")
                        $text_label_trans=__("Seawall", IDXBOOST_DOMAIN_THEME_LANG);

                    echo $text_label_trans; 
                    ?></option>
                    <?php endforeach; ?>
                  </select>
                </div>
              </div>
            </div>
          </li>
          <li class="parking" style="order:3">
            <div class="gwr">
              <h4 class="clidxboost-icon-arrow-select"><?php echo __("Parking spaces", IDXBOOST_DOMAIN_THEME_LANG); ?></h4>
              <div class="wrap-item">
                <div class="wrap-select clidxboost-icon-arrow-select">
                  <label class="ms-hidden" for="flex_parking_switch">Parking spaces options</label>
                  <select id="flex_parking_switch">
                    <option value="--"><?php echo __("Any", IDXBOOST_DOMAIN_THEME_LANG); ?></option>
                    <?php foreach ($search_params['parking_options'] as $parking_option): ?>
                    <option <?php selected((isset($parking) ? $parking : ''), $parking_option['value']); ?> value="<?php echo $parking_option['value']; ?>"><?php echo $parking_option['label']; ?></option>
                    <?php endforeach; ?>
                  </select>
                </div>
              </div>
            </div>
          </li>
          <li class="land" style="order:6">
            <div class="gwr">
              <h4 class="clidxboost-icon-arrow-select"><?php echo __("Land size", IDXBOOST_DOMAIN_THEME_LANG); ?></h4>
              <div class="wrap-item">
                <div class="wrap-inputs">
                  <label class="ms-hidden" for="land_from"><?php echo __("Land size from", IDXBOOST_DOMAIN_THEME_LANG); ?></label>
                  <input id="land_from" class="notranslate" type="text" name="" value=""><span><?php echo __("to", IDXBOOST_DOMAIN_THEME_LANG); ?></span>
                  <label class="ms-hidden" for="land_to"><?php echo __("Land size to", IDXBOOST_DOMAIN_THEME_LANG); ?></label>
                  <input id="land_to" class="notranslate" type="text" name="" value="">
                </div>
                <div class="wrap-range">
                  <div class="range-slide" id="range-land"></div>
                </div>
              </div>
            </div>
          </li>
          <?php if (in_array($flex_idx_info["board_id"], [33])) { ?>
          <li class="features" style="order:9">
            <div class="gwr">
              <div class="clidxboost-icon-arrow-select ib-wrapper-tabs">
                <button class="ms-btn-tab js-tab-amt" data-tab="#featuresTab">
                  <span><?php echo __("Features", IDXBOOST_DOMAIN_THEME_LANG); ?></span>
                </button>
                <button class="ms-btn-tab js-tab-amt active" data-tab="#featuresExtraTab">
                  <span><?php echo __("Popular Features", IDXBOOST_DOMAIN_THEME_LANG); ?></span>
                </button>
              </div>
              <div class="wrap-item">
                <div class="wrap-checks js-body-amt" id="featuresTab" data-type="inner-amt">
                  <ul>
                    <?php
                      foreach ($search_params['amenities'] as $amenity):
                      if ((5 != $board_id) && ("loft" == $amenity["code"])) { continue; }
                      if ((5 == $board_id) && ("water_front" == $amenity["code"])) { continue; }
                      if ((!in_array($board_id,[1,2,3]) ) && ("hopa" == $amenity["code"])) { continue; }
                      ?>
                    <li>
                      <?php
                      if (!is_array($features_info) || empty($features_info)) {
                        $features_info = [];
                      }
                      ?>
                      <input class="amenities_checkbox" type="checkbox" 
                      <?php if (is_array($features_info) && in_array($amenity['code'], $features_info)) { echo 'checked'; } ?>
                      value="<?php echo $amenity['code']; ?>" id="_amenity_<?php echo $amenity['code']; ?>">

                      <label for="_amenity_<?php echo $amenity['code']; ?>"><?php 
                      $text_label_trans='';
                      if($amenity['name']=='Swimming Pool')
                          $text_label_trans= __("Swimming Pool", IDXBOOST_DOMAIN_THEME_LANG);
                      else if ($amenity['name']=='Golf Course')
                          $text_label_trans= __("Golf Course", IDXBOOST_DOMAIN_THEME_LANG);
                      else if ($amenity['name']=='Tennis Courts')
                          $text_label_trans= __("Tennis Courts", IDXBOOST_DOMAIN_THEME_LANG);
                      else if ($amenity['name']=='Gated Community')
                          $text_label_trans= __("Gated Community", IDXBOOST_DOMAIN_THEME_LANG);
                      else if ($amenity['name']=='Lofts')
                          $text_label_trans= __("Lofts", IDXBOOST_DOMAIN_THEME_LANG);
                      else if ($amenity['name']=='Penthouse')
                          $text_label_trans= __("Penthouse", IDXBOOST_DOMAIN_THEME_LANG);
                      else if ($amenity['name']=="Waterfront")
                          $text_label_trans= __("Waterfront", IDXBOOST_DOMAIN_THEME_LANG);
                      else if ($amenity['name']=="Pets")
                          $text_label_trans= __("Pets", IDXBOOST_DOMAIN_THEME_LANG);
                      else if ($amenity['name']=="Furnished")
                          $text_label_trans= __("Furnished", IDXBOOST_DOMAIN_THEME_LANG);
                      else if ($amenity['name']=="Equestrian")
                          $text_label_trans= __("Equestrian", IDXBOOST_DOMAIN_THEME_LANG);     
                      else if ($amenity['name'] == 'Boat Dock')
                          $text_label_trans = __("Boat Dock", IDXBOOST_DOMAIN_THEME_LANG);
                      else if ($amenity['name'] == 'Short Sales')
                          $text_label_trans = __("Short Sales", IDXBOOST_DOMAIN_THEME_LANG);
                      else if ($amenity['name'] == 'Foreclosures')
                          $text_label_trans = __("Foreclosures", IDXBOOST_DOMAIN_THEME_LANG);
                      // else if ($amenity['name'] == 'Open House')
                      //     $text_label_trans = __("Open House", IDXBOOST_DOMAIN_THEME_LANG);
                      else
                      $text_label_trans = $amenity['name'];
                      echo $text_label_trans;
                      ?></label>
                    </li>
                    <?php endforeach; ?>
                  </ul>
                </div>
                <div class="wrap-checks js-body-amt active" id="featuresExtraTab" data-type="inner-amt-extra">
                  <ul>
                    <?php
                      if (count($flex_idx_info["search"]) > 0 && array_key_exists("otherpopularfeatures", $flex_idx_info["search"]) && is_array($flex_idx_info["search"]["otherpopularfeatures"]) && 
                        count($flex_idx_info["search"]["otherpopularfeatures"]) > 0  ) { 
                        foreach ($flex_idx_info["search"]["otherpopularfeatures"] as $keyOther => $valueOther) { 
                          ?>
                          <li>
                            <input type="checkbox" 
                            <?php if (is_array($othersfeatures_info) && in_array($valueOther['code'], $othersfeatures_info)) { echo 'checked'; } ?>
                            id="ib-amt-extra-inner-amt_<?php echo $keyOther; ?>" value="<?php echo $valueOther['code']; ?>" class="amenities_extra_checkbox">
                            <label class="ib-amt-extra-inner-amt_<?php echo $keyOther; ?>" for="ib-amt-extra-inner-amt_<?php echo $keyOther; ?>"><?php echo __($valueOther['name'], IDXBOOST_DOMAIN_THEME_LANG); ?></label>
                          </li>
                         <?php 
                        }                    
                      } ?>
                  </ul>
                </div>
              </div>
            </div>
          </li>
          <?php }else{ ?>
          <li class="features" style="order:9">
            <div class="gwr">
              <h4 class="clidxboost-icon-arrow-select">
                <label><?php echo __("Features", IDXBOOST_DOMAIN_THEME_LANG); ?></label>
              </h4>
              <div class="wrap-item">
                <div class="wrap-checks">
                  <ul>
                    <?php
                      foreach ($search_params['amenities'] as $amenity):
                      if ((5 != $board_id) && ("loft" == $amenity["code"])) { continue; }
                      if ((5 == $board_id) && ("water_front" == $amenity["code"])) { continue; }
                      if ((!in_array($board_id,[1,2,3]) ) && ("hopa" == $amenity["code"])) { continue; }
                      ?>
                    <li>
                      <?php
                      if (!is_array($features_info) || empty($features_info)) {
                        $features_info = [];
                      }
                      ?>
                      <input class="amenities_checkbox" type="checkbox" 
                      <?php if (is_array($features_info) && in_array($amenity['code'], $features_info)) { echo 'checked'; } ?>
                      value="<?php echo $amenity['code']; ?>" id="_amenity_<?php echo $amenity['code']; ?>">

                      <label for="_amenity_<?php echo $amenity['code']; ?>"><?php 
                      $text_label_trans='';
                      if($amenity['name']=='Swimming Pool')
                          $text_label_trans= __("Swimming Pool", IDXBOOST_DOMAIN_THEME_LANG);
                      else if ($amenity['name']=='Golf Course')
                          $text_label_trans= __("Golf Course", IDXBOOST_DOMAIN_THEME_LANG);
                      else if ($amenity['name']=='Tennis Courts')
                          $text_label_trans= __("Tennis Courts", IDXBOOST_DOMAIN_THEME_LANG);
                      else if ($amenity['name']=='Gated Community')
                          $text_label_trans= __("Gated Community", IDXBOOST_DOMAIN_THEME_LANG);
                      else if ($amenity['name']=='Lofts')
                          $text_label_trans= __("Lofts", IDXBOOST_DOMAIN_THEME_LANG);
                      else if ($amenity['name']=='Penthouse')
                          $text_label_trans= __("Penthouse", IDXBOOST_DOMAIN_THEME_LANG);
                      else if ($amenity['name']=="Waterfront")
                          $text_label_trans= __("Waterfront", IDXBOOST_DOMAIN_THEME_LANG);
                      else if ($amenity['name']=="Pets")
                          $text_label_trans= __("Pets", IDXBOOST_DOMAIN_THEME_LANG);
                      else if ($amenity['name']=="Furnished")
                          $text_label_trans= __("Furnished", IDXBOOST_DOMAIN_THEME_LANG);
                      else if ($amenity['name']=="Equestrian")
                          $text_label_trans= __("Equestrian", IDXBOOST_DOMAIN_THEME_LANG);     
                      else if ($amenity['name'] == 'Boat Dock')
                          $text_label_trans = __("Boat Dock", IDXBOOST_DOMAIN_THEME_LANG);
                      else if ($amenity['name'] == 'Short Sales')
                          $text_label_trans = __("Short Sales", IDXBOOST_DOMAIN_THEME_LANG);
                      else if ($amenity['name'] == 'Foreclosures')
                          $text_label_trans = __("Foreclosures", IDXBOOST_DOMAIN_THEME_LANG);
                      // else if ($amenity['name'] == 'Open House')
                      //     $text_label_trans = __("Open House", IDXBOOST_DOMAIN_THEME_LANG);
                      else
                      $text_label_trans = $amenity['name'];
                      echo $text_label_trans;
                      ?></label>
                    </li>
                    <?php endforeach; ?>
                  </ul>
                </div>
              </div>
            </div>
          </li>
          <?php } ?>
          <li class="action-filter">
            <button id="apply-filters-min"><?php echo __("View", IDXBOOST_DOMAIN_THEME_LANG); ?> <span id="properties-found-2"><?php echo flex_idx_format_short_price_fn($response['pagination']['total_items_count']); ?> </span><?php echo __("Listings", IDXBOOST_DOMAIN_THEME_LANG); ?></button>
          </li>
          <button id="apply-filters"><span><?php echo __("Apply Filters", IDXBOOST_DOMAIN_THEME_LANG); ?></span></button>
        </ul>
      </div>
    </div>
  </div>
  <div id="wrap-subfilters" style="margin-top:15px;">
    <div class="gwr">
      <ul id="sub-filters">
        <li id="link-favorites">
          <a role="button" title="<?php echo __("My Saved Listings", IDXBOOST_DOMAIN_THEME_LANG); ?>" class="clidxboost-icon-favorite">
            <span>
              <span><?php echo number_format($response_canti['count']); ?></span>
              <?php echo __("Favorites", IDXBOOST_DOMAIN_THEME_LANG); ?>
            </span>
          </a>
        </li>
        <li id="filter-by" class="clidxboost-icon-arrow-select">
          <span class="filter-text"><?php echo __("Newest Listings", IDXBOOST_DOMAIN_THEME_LANG); ?></span>
          <label class="ms-hidden" for="flex_idx_sort"><?php echo __("Newest Listings by", IDXBOOST_DOMAIN_THEME_LANG); ?></label>
          <select id="flex_idx_sort" class="flex_idx_sort flex_idx_sort-<?php echo $class_multi; ?>" data-permalink="<?php the_permalink(); ?>" data-currpage="<?php echo $response['pagination']['current_page_number']; ?>" filtemid="<?php echo $class_multi; ?>">
              <option value="list_date-desc" <?php selected($response['order'], 'list_date-desc'); ?>><?php echo __("Newest Listings", IDXBOOST_DOMAIN_THEME_LANG); ?></option>
              <option value="last_updated-desc" <?php selected($response['order'], 'last_updated-desc'); ?>><?php echo __('Modified Listings', IDXBOOST_DOMAIN_THEME_LANG); ?></option>
              <option value="price-desc" <?php selected($response['order'], 'price-desc'); ?>><?php echo __("Highest Price", IDXBOOST_DOMAIN_THEME_LANG); ?></option>
              <option value="price-asc" <?php selected($response['order'], 'price-asc'); ?>><?php echo __("Lowest Price", IDXBOOST_DOMAIN_THEME_LANG); ?></option>
              <option value="sqft-desc" <?php selected($response['order'], 'sqft-desc'); ?>><?php echo __("Highest Sq.Ft", IDXBOOST_DOMAIN_THEME_LANG); ?></option>
              <option value="sqft-asc" <?php selected($response['order'], 'sqft-asc'); ?>><?php echo __("Lowest Sq.Ft", IDXBOOST_DOMAIN_THEME_LANG); ?></option>
              <option value="price_sqft-desc" <?php selected($response['order'], 'price_sqft-desc'); ?>><?php echo __("Highest Price/Sq.Ft", IDXBOOST_DOMAIN_THEME_LANG); ?></option>
              <option value="price_sqft-asc" <?php selected($response['order'], 'price_sqft-asc'); ?>><?php echo __("Lowest Price/Sq.Ft", IDXBOOST_DOMAIN_THEME_LANG); ?></option>

          </select>
        </li>
        <li id="filter-views" class="filter-views filter-views-<?php echo $class_multi; ?> clidxboost-icon-arrow-select <?php echo $response['view']; ?>" filtemid="<?php echo $class_multi; ?>">
          <label class="ms-hidden" for="flex_idx_type_view"><?php echo __("Display as", IDXBOOST_DOMAIN_THEME_LANG); ?></label>
          <select id="flex_idx_type_view">
            <option value="grid" <?php selected($response['view'], 'grid'); ?>><?php echo __("Grid", IDXBOOST_DOMAIN_THEME_LANG); ?></option>
            <option value="list" <?php selected($response['view'], 'list'); ?>><?php echo __("List", IDXBOOST_DOMAIN_THEME_LANG); ?></option>
            <option value="map" <?php selected($response['view'], 'map'); ?>><?php echo __("Map", IDXBOOST_DOMAIN_THEME_LANG); ?></option>
          </select>
        </li>
      </ul>
      <?php if ( (!is_numeric($atts['limit']) && $atts['limit'] =='default')) { ?>
      <?php
        if($idxboost_ver_bool==false){ ?>
          <span id="info-subfilters"></span>
      <?php }else{ ?>
      <span id="info-subfilters"><?php echo __("Showing", IDXBOOST_DOMAIN_THEME_LANG); ?> <?php echo $response['pagination']['offset']['start']; ?> <?php echo __("to", IDXBOOST_DOMAIN_THEME_LANG); ?> <?php echo $response['pagination']['offset']['end']; ?> <?php echo __("of", IDXBOOST_DOMAIN_THEME_LANG); ?> <?php echo number_format($response['pagination']['total_items_count']); ?> <?php echo __("Properties", IDXBOOST_DOMAIN_THEME_LANG); ?>.<span></span></span>
      <?php } ?>
      <?php } ?>
    </div>
  </div>
  <section id="wrap-result" class="wrap-result wrap-result-<?php echo $class_multi; ?> view-<?php echo $viewfilter; ?>" filtemid="<?php echo $class_multi; ?>">
    <h2 class="title"><?php echo __("Search results", IDXBOOST_DOMAIN_THEME_LANG); ?></h2>
    <div class="gwr">
      <div id="wrap-list-result" <?php if($idxboost_ver_bool==false){ ?> style="display: none;" <?php } ?> >
        <ul id="head-list">
          <li class="address"><?php echo __('Address', IDXBOOST_DOMAIN_THEME_LANG); ?></li>
          <li class="price"><?php echo __('Price', IDXBOOST_DOMAIN_THEME_LANG); ?></li>
          <li class="pr">% / $</li>
          <li class="beds"><?php echo __('Beds', IDXBOOST_DOMAIN_THEME_LANG); ?></li>
          <li class="baths"><?php echo __('Baths', IDXBOOST_DOMAIN_THEME_LANG); ?></li>
          <li class="living-size"><?php echo __('Living Size', IDXBOOST_DOMAIN_THEME_LANG); ?></li>
          <li class="price-sf"><?php echo __('Price', IDXBOOST_DOMAIN_THEME_LANG); ?> / Sq.Ft.</li>
          <li class="development"><?php echo __('Development', IDXBOOST_DOMAIN_THEME_LANG); ?> / <?php echo __('Subdivision', IDXBOOST_DOMAIN_THEME_LANG); ?></li>
        </ul>
        <ul id="result-search" class="slider-generator" style="overflow-y:auto;">
          <?php if (isset($response['items'])): $countimte=0; ?>
            <?php $tot_items=count($response['items']);
           foreach($response['items'] as $key_property => $property): ?>
          <?php $countimte=$countimte+1; ?>
          
          <li data-address="<?php echo $property['address_short']; ?>" data-mls="<?php echo $property['mls_num']; ?>" class="propertie" data-geocode="<?php echo $property['lat']; ?>:<?php echo $property['lng']; ?>" data-class-id="<?php echo $property['class_id']; ?>">

                <?php if ($property['status'] == 5): ?>
                <div class="flex-property-new-listing"><?php echo __('rented', IDXBOOST_DOMAIN_THEME_LANG); ?></div>
                <?php elseif($property['status'] == 2): ?>
                <div class="flex-property-new-listing"><?php echo __('sold', IDXBOOST_DOMAIN_THEME_LANG); ?></div>
                <?php elseif($property['status'] != 1): ?>
                <div class="flex-property-new-listing"><?php echo $property['status_name']; ?></div>   
                <?php elseif( (isset($property['recently_listed']) && $property['recently_listed'] === 'yes') || $property['min_ago_txt'] != "" ): ?>
                  <?php if( $property['min_ago'] > 0 &&  $property['min_ago_txt'] != "" ){ ?>
                    <div class="flex-property-new-listing"><?php echo $property['min_ago_txt']; ?></div>
                  <?php }else{  ?>
                    <div class="flex-property-new-listing"><?php echo __('new listing', IDXBOOST_DOMAIN_THEME_LANG); ?></div>
                  <?php } ?>

                <?php endif; ?>
   
        
            <?php
              $arraytemp = str_replace(' , ', ', ', $property["address_large"]);
              $final_address_parceada = $property['address_short'] . "<span>" . $arraytemp . "</span>";
              $final_address_parceada_new = "<span>".$property['address_short'] . $arraytemp . "</span>";
            ?>
            
            <h2 title="<?php echo $property['full_address']; ?>" class="ms-property-address">
              <div class="ms-title-address -address-top"><?php echo $property['full_address_top']; ?></div>
              <div class="ms-br-line">,</div>
              <div class="ms-title-address -address-bottom"><?php echo $property['full_address_bottom']; ?></div>
              <?php if (in_array($flex_idx_info["board_id"], ["31"])) { ?>
              <div>Listing Provided by NWMLS</div>
              <?php } ?>
              <?php if (in_array($flex_idx_info["board_id"], ["33"])) { ?>
              <div class="ms-ellipsis-dm">Listing Courtesy of <?php echo $property['office_name']; ?></div>
              <?php 
              $paddingClass = "ms-padding";
              } ?>
            </h2>

            <ul class="features <?php echo $paddingClass; ?>">
              <li class="address"><?php echo $property['full_address']; ?></li>
              <?php if( $property['is_rental']=='1' ) { ?>
                <li class="price">$<?php echo number_format($property['price']); ?>/<?php echo __('month', IDXBOOST_DOMAIN_THEME_LANG); ?></li>
              <?php }else{ ?>
                <li class="price">$<?php echo number_format($property['price']); ?></li>
              <?php } ?>
              
              <?php if ($property['reduced'] == ''): ?>
              <li class="pr"><?php echo $property['reduced']; ?></li>
              <?php elseif($property['reduced'] < 0): ?>
              <li class="pr down"><?php echo $property['reduced']; ?>%</li>
              <?php else: ?>
              <li class="pr up"><?php echo $property['reduced']; ?>%</li>
              <?php endif; ?>
              <li class="beds"><?php echo $property['bed']; ?> <span>
                <?php if ($property['bed']>1) {
                  echo __('Beds', IDXBOOST_DOMAIN_THEME_LANG);
                  }else {
                  echo __('Bed', IDXBOOST_DOMAIN_THEME_LANG);
                  } ?>
                </span>
              </li>
              <li class="baths"><?php echo $property['bath']; ?> <span>
                <?php
                  if ($property['bath']>1) {
                    echo __('Baths', IDXBOOST_DOMAIN_THEME_LANG);
                  }else{
                    echo __('Bath', IDXBOOST_DOMAIN_THEME_LANG);
                  }
                  ?></span>
              </li>
              <!-- <li class="living-size"> <span><?php echo number_format($property['sqft']); ?></span>Sq.Ft <span>(<?php echo $property['living_size_m2']; ?> m²)</span></li> -->
              <li class="living-size"> <span><?php echo number_format($property['sqft']); ?></span>Sq.Ft</li>
              <!-- <li class="price-sf"><span>$<?php echo $property['price_sqft']; ?></span>/ Sq.Ft<span>($<?php echo $property['price_sqft_m2']; ?> m²)</span></li> -->
              <li class="price-sf"><span>$<?php echo $property['price_sqft']; ?></span>/ Sq.Ft</li>
              <?php if (!empty($property['subdivision'])): ?>
              <li class="development"><span><?php echo $property['subdivision']; ?></span></li>
              <?php elseif (!empty($property['development'])): ?>
              <li class="development"><span><?php echo $property['development']; ?></span></li>
              <?php else: ?>
              <li class="development"><span><?php echo $property['complex']; ?></span></li>
              <?php endif; ?>
              
              <?php
              if(is_array($response) && count($response)>0 && array_key_exists("board_info",$response) && array_key_exists("board_logo_url", $response["board_info"]) && !empty($response["board_info"]["board_logo_url"])  ){ ?>
                <li class="ms-logo-board"><img src="<?php echo $response["board_info"]["board_logo_url"]; ?>"></li>
              <?php } ?>

            </ul>
            <div class="wrap-slider">
              <ul>
                <?php foreach($property['gallery'] as $key => $property_photo): ?>
                <?php if ($key === 0): ?>
                <li class="flex-slider-current">
                  <img
                    class="flex-lazy-image"
                    data-original="<?php echo $property_photo; ?>"
                    title="<?php echo $property['address_short']; ?> <?php echo $property['address_large']; ?>"
                    alt="<?php echo $property['address_short']; ?> <?php echo $property['address_large']; ?>">
                </li>
                <?php else: ?>
                <li class="flex-slider-item-hidden">
                  <img
                    class="flex-lazy-image"
                    data-original="<?php echo $property_photo; ?>"
                    title="<?php echo $property['address_short']; ?> <?php echo $property['address_large']; ?>"
                    alt="<?php echo $property['address_short']; ?> <?php echo $property['address_large']; ?>">
                </li>
                <?php endif; ?>
                <?php endforeach; ?>
              </ul>
              <button class="prev flex-slider-prev" aria-label="Prev"><span class="clidxboost-icon-arrow-select"></span></button>
              <button class="next flex-slider-next" aria-label="Next"><span class="clidxboost-icon-arrow-select"></span></button>
              <?php if (isset($property['status'])): ?>
              <?php if ($property['is_favorite'] == true): ?>
              <?php $filter_favorite_idxboost=$filter_favorite_idxboost+1; ?>
              <button aria-label="Remove Favorite" class="clidxboost-btn-check flex-favorite-btn" data-alert-token="<?php echo $property['token_alert'];?>">
              <span class="clidxboost-icon-check active"></span>
              </button>
              <?php else: ?>
              <button aria-label="Save Favorite" class="clidxboost-btn-check flex-favorite-btn">
              <span class="clidxboost-icon-check"></span>
              </button>
              <?php endif; ?>
              <?php endif; ?>
            </div>
            <?php
            $url_property='#';
            $class_for_recent = "view-detail view-detail-no-link";
            if ($is_recent_sales=='yes') {
              $class_for_recent = "view-detail";
            }
              $site_property=rtrim($flex_idx_info["pages"]["flex_idx_property_detail"]["guid"], "/"); 
              $url_property=$site_property.'/'.$property['slug'];

            ?>

            <?php if (isset($property["status"])): ?>
            <?php if (2 == $property["status"]): ?>
            <a class="<?php echo $class_for_recent; ?>" href="<?php echo $url_property; ?>"><?php echo $property['full_address']; ?></a>
            <?php elseif(5 == $property["status"]): ?>
            <a class="<?php echo $class_for_recent; ?>" href="<?php echo $url_property; ?>"><?php echo $property['full_address']; ?></a>
            <?php elseif(6 == $property["status"]): ?>
            <a class="<?php echo $class_for_recent; ?>" href="<?php echo $url_property; ?>"><?php echo $property['full_address']; ?></a>
            <?php else: ?>
            <a class="<?php echo $class_for_recent; ?>" href="<?php echo $url_property; ?>"><?php echo $property['full_address']; ?></a>
            <?php endif; ?>
            <?php else: ?>
            <a class="<?php echo $class_for_recent; ?>" href="<?php echo $url_property; ?>"><?php echo $property['full_address']; ?></a>
            <?php endif; ?>
            <a class="view-map-detail" data-geocode="<?php echo $property['lat']; ?>:<?php echo $property['lng']; ?>">View Map</a>
              <?php if($atts['oh']=="1" && array_key_exists("oh_info", $property)) { 
                $oh_info=$property['oh_info'];
                $oh_info_de=@json_decode($oh_info,true);
                if (is_array($oh_info_de) && array_key_exists('date',$oh_info_de) && array_key_exists('timer',$oh_info_de)) {
                  ?>
                <div class="ms-open">
                  <span class="ms-wrap-open">
                    <span class="ms-open-title"><?php echo __('Open House', IDXBOOST_DOMAIN_THEME_LANG); ?></span>    
                    <span class="ms-open-date"><?php echo $oh_info_de['date'];  ?></span>
                    <span class="ms-open-time"><?php echo $oh_info_de['timer']; ?></span>
                  </span>
                </div>                
                  <?php
                }
                ?> 
              <?php } ?>

          </li>

          <?php
          /*HACKEDBOX*/
          $ib_position_hackbox=2;
           
           if ($key_property === $tot_items )
            $ib_position_hackbox=$tot_items;

           if($key_property==$ib_position_hackbox){ 
            if(array_key_exists("hackbox", $response)){ 
              if ($response["hackbox"]['status'] != false) { 
                if (!empty($response["hackbox"]['result']['content']) ) { ?>
                  <li class="propertie button_properties"><div class="ppc-content ppc-video-box"><?php echo $response["hackbox"]['result']['content']; ?></div></li>
          <?php } } } }
          /*HACKEDBOX*/
           ?>                    
          <?php endforeach; ?>
          <?php endif; ?>
        </ul>
      </div>
      <div id="wrap-map">
        <div id="code-map" class="code-map code-map-<?php echo $class_multi; ?>"></div>
        <div id="map-actions">
          <button class="open-map hide"><?php echo __('Open', IDXBOOST_DOMAIN_THEME_LANG); ?></button>
          <button class="close-map"><?php echo __('Close', IDXBOOST_DOMAIN_THEME_LANG); ?></button>
        </div>
      </div>
    </div>
    <div id="paginator-cnt" class="gwr" <?php if($idxboost_ver_bool==false){ ?> style="display: none;" <?php } ?> >
      <?php if (isset($response['pagination'])): ?>
      <nav id="nav-results" class="nav-results nav-results-<?php echo $class_multi; ?>" filtemid="<?php echo $class_multi; ?>">
        <span id="indicator"><?php echo __('Pag', IDXBOOST_DOMAIN_THEME_LANG); ?> <?php echo $response['pagination']['current_page_number']; ?> <?php echo __('of', IDXBOOST_DOMAIN_THEME_LANG); ?> <?php echo $response['pagination']['total_pages_count']; ?></span>
        <?php if ($response['pagination']['has_prev_page'] && ($response['pagination']['total_pages_count'] > 1)): ?>
        <a data-page="1" norefre="<?php the_permalink(); ?>order-<?php echo $response['order']; ?>/view-<?php echo $response['view']; ?>/page-1" title="<?php echo __('First Page', IDXBOOST_DOMAIN_THEME_LANG); ?>" id="firstp" class="ad visible firts_page">
        <span class="clidxboost-icon-arrow-select"></span>
        <span class="clidxboost-icon-arrow-select"></span>
        <span><?php echo __('First page', IDXBOOST_DOMAIN_THEME_LANG); ?></span>
        </a>
        <?php endif; ?>
        <?php if ($response['pagination']['has_prev_page']): ?>
        <a data-page="<?php echo ($response['pagination']['current_page_number'] - 1); ?>" norefre="<?php the_permalink(); ?>order-<?php echo $response['order']; ?>/view-<?php echo $response['view']; ?>/page-<?php echo ($response['pagination']['current_page_number'] - 1); ?>" title="<?php echo __('Prev Page', IDXBOOST_DOMAIN_THEME_LANG); ?>" id="prevn" class="arrow clidxboost-icon-arrow-select prevn visible"><span><?php echo __('Previous page', IDXBOOST_DOMAIN_THEME_LANG); ?></span></a>
        <?php endif; ?>
        <ul id="principal-nav">
          <?php foreach($response['pagination']['range'] as $pages): ?>
          <li id="page_<?php echo $pages; ?>" <?php if($response['pagination']['current_page_number'] == $pages): ?> class="active"<?php endif; ?>>
            <a data-page="<?php echo $pages; ?>" norefre="<?php the_permalink(); ?>order-<?php echo $response['order']; ?>/view-<?php echo $response['view']; ?>/page-<?php echo $pages; ?>"><?php echo $pages; ?></a>
          </li>
          <?php endforeach; ?>
        </ul>
        <?php if ($response['pagination']['has_next_page']): ?>
        <a data-page="<?php echo ($response['pagination']['current_page_number'] + 1); ?>" norefre="<?php the_permalink(); ?>order-<?php echo $response['order']; ?>/view-<?php echo $response['view']; ?>/page-<?php echo ($response['pagination']['current_page_number'] + 1); ?>" title="<?php echo __('Next Page', IDXBOOST_DOMAIN_THEME_LANG); ?>" id="nextn" class="arrow clidxboost-icon-arrow-select nextn visible next_page"><span><?php echo __('Next Page', IDXBOOST_DOMAIN_THEME_LANG); ?></span></a>
        <?php endif; ?>
        <?php if (($response['pagination']['total_pages_count'] > 1) && $response['pagination']['has_next_page']): ?>
        <a data-page="<?php echo $response['pagination']['total_pages_count']; ?>" norefre="<?php the_permalink(); ?>order-<?php echo $response['order']; ?>/view-<?php echo $response['view']; ?>/page-<?php echo $response['pagination']['total_pages_count']; ?>" title="<?php echo __('Last Page', IDXBOOST_DOMAIN_THEME_LANG); ?>" id="lastp" class="ad visible last_page">
        <span class="clidxboost-icon-arrow-select"></span>
        <span class="clidxboost-icon-arrow-select"></span>
        <span><?php echo __('Last Page', IDXBOOST_DOMAIN_THEME_LANG); ?></span>
        </a>
        <?php endif; ?>
      </nav>
      <?php endif; ?>
    </div>
    <?php  //}  ?>
  </section>

  <?php if( in_array($flex_idx_info["board_id"], ["33"]) ){ ?>
  <div class="ib-bdisclaimer" style="max-width:90%; margin: 0 auto">
     <img src="https://idxboost-spw-assets.idxboost.us/logos/NYCListingCompliance.jpg" style="width: 110px;height: auto;display:inline-block;margin-top: -30px;">
                    <?php if( $flex_idx_info["agent"]["restriction_idx"] == "1" ){ ?>
                    <p><?php echo $flex_idx_info["agent"]["broker_title_associate"]; ?></p>
                    <?php } ?>
     
     <p>The Registrant acknowledges each other RLS Broker’s ownership of, and the validity of their respective copyright in, the Exlusive Listings that are transmitted over the RLS. The information is being provided by REBNY Listing Service, Inc. Information deemed reliable but not guaranteed. Information is provided for consumers’ personal, non-commercial use, and may not be used for any purpose other than the identification of potential properties for purchase. This information is not verified for authenticity or accuracy and is not guaranteed and may not reflect all real estate activity in the market. ©<?php echo date("Y"); ?> REBNY Listing Service, Inc. All rights reserved.</p>
  </div>
<?php } ?>
</div>

<?php include FLEX_IDX_PATH . '/views/shortcode/idxboost_modals_filter.php';  ?>



<div class="content-rsp-btn">
  <div class="idx-btn-content">
    <div class="idx-bg-group">
      <button data-modal="modal_save_search" id="save-button-responsive" class="idx-btn-act">
        <span><?php echo __("Save", IDXBOOST_DOMAIN_THEME_LANG); ?></span>
      </button>

      <button class="idx-btn-act" id="idx-bta-grid">
        <span><?php echo __("Grid", IDXBOOST_DOMAIN_THEME_LANG); ?></span>
      </button>

      <button class="idx-btn-act" id="idx-bta-list">
        <span><?php echo __("List", IDXBOOST_DOMAIN_THEME_LANG); ?></span>
      </button>

      <button class="idx-btn-act" id="idx-bta-map">
        <span><?php echo __("Map", IDXBOOST_DOMAIN_THEME_LANG); ?></span>
      </button>
    </div>
  </div>
</div>

<?php if ($atts['row'] != 'default') {  ?>

<style type="text/css">
@media screen and (min-width: 640px){
  .view-grid li.propertie {
      width: 48% !important;
  }  
}
</style>
<?php } ?>


<script type="text/javascript">
  var idxboost_hackbox_filter=[];
  var idxboost_force_registration=false;

<?php
$registration_is_forced = (isset($flex_idx_info['agent']['force_registration']) && (true == $flex_idx_info['agent']['force_registration']) ) ? true : false;

 if ( 
      ($registration_is_forced != false) || 
      (
        !empty($response) && 
            array_key_exists('force_registration', $response) &&  
            !empty($response['force_registration'])     
      )
  ) { ?>
      idxboost_force_registration=true;
    <?php  } ?>

   <?php if( !empty($response) && array_key_exists("hackbox", $response)){ ?>
    idxboost_hackbox_filter= <?php echo @json_encode($response["hackbox"]); ?>;
   <?php } ?>

  jQuery(document).ready(function(){
    jQuery('.clidxboost-icon-favorite span span').text("<?php echo $filter_favorite_idxboost; ?>");
  });

  jQuery(document).on('click', '.idx-btn-act', function() {
    var $cuerpo = jQuery('body');
    var $wrapResult = jQuery('#wrap-result');
    var $viewFilter = jQuery('#filter-views');
    jQuery("html, body").animate({ scrollTop: 0 }, 600);

    switch (jQuery(this).attr('id').split(' ')[0]){
      case 'idx-bta-grid':
        jQuery("#filter-views select").val("grid").trigger("change");
        $viewFilter.removeClass('list map').addClass('grid');
        $wrapResult.removeClass('view-list view-map').addClass('view-grid');
        $cuerpo.removeClass('view-list view-map view-grid').addClass('view-grid');
        break
      case 'idx-bta-list':
        jQuery("#filter-views select").val("list").trigger("change");
        $viewFilter.removeClass('grid map').addClass('list');
        $wrapResult.removeClass('view-grid view-map').addClass('view-list');
        $cuerpo.removeClass('view-list view-map view-grid').addClass('view-list');
        break
      case 'idx-bta-map':
        jQuery("#filter-views select").val("map").trigger("change");
        $viewFilter.removeClass('list grid').addClass('map');
        $wrapResult.removeClass('view-list view-grid').addClass('view-map');
        $cuerpo.removeClass('view-list view-map view-grid').addClass('view-map');
        break
    }
  });


  jQuery(".ib-btn-show").click(function() {
    jQuery(this).parents('.propertie').toggleClass('active-list');
  });

  var view_grid_type='';
  view_grid_type='<?php echo $sta_view_grid_type; ?>';
  if ( !jQuery('body').hasClass('clidxboost-ngrid') && view_grid_type==1) {
    jQuery('body').addClass('clidxboost-ngrid');
  }  
</script>
