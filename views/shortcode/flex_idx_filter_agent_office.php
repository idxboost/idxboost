<?php
  $idxboost_query_slug = $_SERVER['QUERY_STRING'];
  $idxboost_ver_bool=true;
?>
<?php
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

  $parking=$response['info']['parking_option'];
  $features_info=$response['info']['features'];
  $water_desc=$response['info']['waterfront_option'];
  $sta_view_grid_type='0'; if(array_key_exists('view_grid_type',$search_params)) $sta_view_grid_type=$search_params['view_grid_type'];
  $filter_type='0'; if(array_key_exists('filter_type',$response)) $filter_type=$response['filter_type'];
  ?>
<script>
  var ib_filter_metadata = <?php echo json_encode($response); ?>;
  var search_metadata = <?php echo trim(json_encode($search_params)); ?>;
</script>
<?php 
if (!empty($response) && is_array($response)) {
  if (array_key_exists('items',$response)) {
    if (count($response['items'])==0) {
      return false;
    }
  }
}else{
  return false;
}
?>
<h2 class="flex-page-title"><?php echo __("MY LISTINGS", IDXBOOST_DOMAIN_THEME_LANG); ?></h2>

<form method="post" id="flex-idx-filter-form" class="flex-idx-filter-form flex-idx-filter-form-<?php echo $class_multi; ?> idxboost-filter-form" data-filter-form-id="<?php echo $unique_filter_form_ID; ?>" filtemid="<?php echo $class_multi; ?>">
  <input type="hidden" name="action" value="filter_agent_office">
  <input type="hidden" name="search_count" id="search_count" value="<?php echo $response['counter']; ?>">  

  <input type="hidden" name="filter_id" id="filter_id" value="<?php echo $atts['id']; ?>">  
  <input type="hidden" name="listing_type" id="listing_type" value="<?php echo $typefilt; ?>">  
  
  <input type="hidden" name="idx[min_price]" id="idx_min_price" value="<?php echo $response['info']['min_price']; ?>">
  <input type="hidden" name="idx[max_price]" id="idx_max_price" value="<?php echo $response['info']['max_price']; ?>">
  
  <input type="hidden" name="idx[min_rent_price]" id="idx_min_rent_price" value="<?php echo $response['info']['min_price']; ?>">
  <input type="hidden" name="idx[max_rent_price]" id="idx_max_rent_price" value="<?php echo $response['info']['max_price']; ?>">

  <input type="hidden" name="idx[tab]" id="idx_property_type" value="<?php echo $response['info']['property_type']; ?>">
  <input type="hidden" name="idx[rental]" id="idx_rental" value="0|1">
  
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
  <input type="hidden" name="idx[view]" id="idx_view" value="<?php echo $response['view']; ?>">
  <input type="hidden" name="idx[sort]" id="idx_sort" value="<?php echo $response['order']; ?>">
  <input type="hidden" name="idx[page]" id="idx_page" value="<?php echo $response['pagination']['current_page_number']; ?>">
  <input type="hidden" name="filter_panel" id="filter_panel" value="<?php echo $atts['id']; ?>">
  <input type="hidden" name="filter_type" id="filter_type" value="<?php echo $atts['type']; ?>">
  <input type="hidden" name="limit" class="limit" value="<?php echo $atts['limit']; ?>">
</form>
<?php
  global $post;
  $filter_favorite_idxboost=0;
  $filter_type_fl = get_post_meta($post->ID, '_flex_filter_page_fl', true);
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
        <div id="header-filters">
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
                    }else{
                      if(in_array($property_type["value"], $ptypes_checked)){
                        $text_label_trans=$property_type['label'];
                      }
                    }      
                      if (!empty($text_label_trans)) {
                        $property_types_text[]=$text_label_trans;
                      }
                  }
                  if (count($property_types_text)===3) {
                    echo __('Any type(s)', IDXBOOST_DOMAIN_THEME_LANG);
                  }else{
                    echo implode(', ', $property_types_text);
                  }                
              }else{
                echo __('Any type(s)', IDXBOOST_DOMAIN_THEME_LANG);
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
            <li class="price">
              <div class="gwr">
                <h4 class="clidxboost-icon-arrow-select"><?php echo __("Price Range", IDXBOOST_DOMAIN_THEME_LANG); ?></h4>
                <div class="wrap-item price_range_for_sale price_ranges_ct" <?php if($response['info']['rental_type'] == 1): ?> style="display:none;" <?php endif; ?>>
                  <div class="wrap-inputs">
                    <input id="price_from" class="notranslate" type="text" value=""> <span><?php echo __("to", IDXBOOST_DOMAIN_THEME_LANG); ?></span>
                    <input id="price_to" class="notranslate" type="text" value="">
                  </div>
                  <div class="wrap-range">
                    <div id="range-price" class="range-slide"></div>
                  </div>
                </div>
                <div class="wrap-item price_range_for_rent price_ranges_ct" <?php if($response['info']['rental_type'] == 0): ?> style="display:none;" <?php endif; ?>>
                  <div class="wrap-inputs">
                    <input id="price_rent_from" class="notranslate" type="text" value=""><span><?php echo __("to", IDXBOOST_DOMAIN_THEME_LANG); ?></span>
                    <input id="price_rent_to" class="notranslate" type="text" value="">
                  </div>
                  <div class="wrap-range">
                    <div id="range-price-rent" class="range-slide"></div>
                  </div>
                </div>
              </div>
            </li>
            <li class="baths">
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
            <li class="beds">
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
            <li class="type">
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
            <li class="living">
              <div class="gwr">
                <h4 class="clidxboost-icon-arrow-select"><?php echo __("Living size", IDXBOOST_DOMAIN_THEME_LANG); ?></h4>
                <div class="wrap-item">
                  <div class="wrap-inputs">
                    <input id="living_from" class="notranslate" type="text" name="" value=""><span><?php echo __("to", IDXBOOST_DOMAIN_THEME_LANG); ?></span>
                    <input id="living_to" class="notranslate" type="text" name="" value="">
                  </div>
                  <div class="wrap-range">
                    <div class="range-slide" id="range-living"></div>
                  </div>
                </div>
              </div>
            </li>
            <li class="year">
              <div class="gwr">
                <h4 class="clidxboost-icon-arrow-select"><?php echo __("Year Built", IDXBOOST_DOMAIN_THEME_LANG); ?></h4>
                <div class="wrap-item">
                  <div class="wrap-inputs">
                    <input id="year_from" type="text" name="" value=""><span><?php echo __("to", IDXBOOST_DOMAIN_THEME_LANG); ?></span>
                    <input id="year_to" type="text" name="" value="">
                  </div>
                  <div class="wrap-range">
                    <div class="range-slide" id="range-year"></div>
                  </div>
                </div>
              </div>
            </li>
            <li class="waterfront">
              <div class="gwr">
                <h4 class="clidxboost-icon-arrow-select"><?php echo __("Waterfront description", IDXBOOST_DOMAIN_THEME_LANG); ?></h4>
                <div class="wrap-item">
                  <div class="wrap-select clidxboost-icon-arrow-select">
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
                      echo $text_label_trans; 
                      ?></option>
                      <?php endforeach; ?>
                    </select>
                  </div>
                </div>
              </div>
            </li>
            <li class="parking">
              <div class="gwr">
                <h4 class="clidxboost-icon-arrow-select"><?php echo __("Parking spaces", IDXBOOST_DOMAIN_THEME_LANG); ?></h4>
                <div class="wrap-item">
                  <div class="wrap-select clidxboost-icon-arrow-select">
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
            <li class="land">
              <div class="gwr">
                <h4 class="clidxboost-icon-arrow-select"><?php echo __("Land size", IDXBOOST_DOMAIN_THEME_LANG); ?></h4>
                <div class="wrap-item">
                  <div class="wrap-inputs">
                    <input id="land_from" class="notranslate" type="text" name="" value=""><span><?php echo __("to", IDXBOOST_DOMAIN_THEME_LANG); ?></span>
                    <input id="land_to" class="notranslate" type="text" name="" value="">
                  </div>
                  <div class="wrap-range">
                    <div class="range-slide" id="range-land"></div>
                  </div>
                </div>
              </div>
            </li>
            <li class="features">
              <div class="gwr">
                <h4 class="clidxboost-icon-arrow-select">
                  <label><?php echo __("Features", IDXBOOST_DOMAIN_THEME_LANG); ?></label>
                </h4>
                <div class="wrap-item">
                  <div class="wrap-checks">
                    <ul>
                      <?php foreach ($search_params['amenities'] as $amenity):
                        if ((5 != $board_id) && ("loft" == $amenity["code"])) { continue; }
                        if ((5 == $board_id) && ("water_front" == $amenity["code"])) { continue; }
                        ?>
                      <li>
                        <input class="amenities_checkbox" type="checkbox" <?php if (in_array($amenity['code'],$features_info) ) { echo 'checked'; } ?>
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
                        echo $text_label_trans;
                        ?></label>
                      </li>
                      <?php endforeach; ?>
                    </ul>
                  </div>
                </div>
              </div>
            </li>
            <li class="action-filter">
              <button id="apply-filters-min"><?php echo __("View", IDXBOOST_DOMAIN_THEME_LANG); ?> <span id="properties-found-2"><?php echo flex_idx_format_short_price_fn($response['pagination']['total_items_count']); ?> </span><?php echo __("Listings", IDXBOOST_DOMAIN_THEME_LANG); ?></button>
            </li>
            <button id="apply-filters"><span><?php echo __("Apply Filters", IDXBOOST_DOMAIN_THEME_LANG); ?></span></button>
          </ul>
        </div>
      </div>
    </div>
  </div>
  <div id="wrap-subfilters" style="margin-top:15px;">
    <div class="gwr">
      <ul id="sub-filters">
        <li id="link-favorites">
          <a href="#" title="<?php echo __("My Saved Listings", IDXBOOST_DOMAIN_THEME_LANG); ?>" class="clidxboost-icon-favorite">
          <span>
          <span><?php echo number_format($response_canti['count']); ?></span><?php echo __("Favorites", IDXBOOST_DOMAIN_THEME_LANG); ?></span>
          </a>
        </li>
        <li id="filter-by" class="clidxboost-icon-arrow-select">
          <span class="filter-text"><?php echo __("Newest Listings", IDXBOOST_DOMAIN_THEME_LANG); ?></span>
          <select id="flex_idx_sort" class="flex_idx_sort flex_idx_sort-<?php echo $class_multi; ?>" data-permalink="<?php the_permalink(); ?>" data-currpage="<?php echo $response['pagination']['current_page_number']; ?>" filtemid="<?php echo $class_multi; ?>">
              <option value="list_date-desc" <?php selected($response['order'], 'list_date-desc'); ?>><?php echo __("Newest Listings", IDXBOOST_DOMAIN_THEME_LANG); ?></option>
              <option value="price-desc" <?php selected($response['order'], 'price-desc'); ?>><?php echo __("Highest Price", IDXBOOST_DOMAIN_THEME_LANG); ?></option>
              <option value="price-asc" <?php selected($response['order'], 'price-asc'); ?>><?php echo __("Lowest Price", IDXBOOST_DOMAIN_THEME_LANG); ?></option>
              <option value="sqft-desc" <?php selected($response['order'], 'sqft-desc'); ?>><?php echo __("Highest Sq.Ft", IDXBOOST_DOMAIN_THEME_LANG); ?></option>
              <option value="sqft-asc" <?php selected($response['order'], 'sqft-asc'); ?>><?php echo __("Lowest Sq.Ft", IDXBOOST_DOMAIN_THEME_LANG); ?></option>
          </select>
        </li>
        <li id="filter-views" class="filter-views filter-views-<?php echo $class_multi; ?> clidxboost-icon-arrow-select <?php echo $response['view']; ?>" filtemid="<?php echo $class_multi; ?>">
          <select>
            <option value="grid" <?php selected($response['view'], 'grid'); ?>><?php echo __("Grid", IDXBOOST_DOMAIN_THEME_LANG); ?></option>
            <option value="list" <?php selected($response['view'], 'list'); ?>><?php echo __("List", IDXBOOST_DOMAIN_THEME_LANG); ?></option>
            <option value="map" <?php selected($response['view'], 'map'); ?>><?php echo __("Map", IDXBOOST_DOMAIN_THEME_LANG); ?></option>
          </select>
        </li>
      </ul>
      <?php if ( (!is_numeric($atts['limit']) && $atts['limit'] =='default')) { ?>
      <?php
        if($idxboost_ver_bool==false){ ?>
      <span id="info-subfilters"><span><?php //echo __("Scroll down for more.", IDXBOOST_DOMAIN_THEME_LANG); ?></span></span>
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
          <li class="price-sf"><?php echo __('Price', IDXBOOST_DOMAIN_THEME_LANG); ?> / SF </li>
          <li class="development"><?php echo __('Development', IDXBOOST_DOMAIN_THEME_LANG); ?> / <?php echo __('Subdivision', IDXBOOST_DOMAIN_THEME_LANG); ?></li>
        </ul>
        <ul id="result-search" class="slider-generator" style="overflow-y:auto;">
          <?php if (isset($response['items'])): $countimte=0; ?>
            <?php $tot_items=count($response['items']);
           foreach($response['items'] as $key_property => $property): ?>
          <?php $countimte=$countimte+1; ?>
          
          <li data-address="<?php echo $property['address_short']; ?>" data-mls="<?php echo $property['mls_num']; ?>" class="propertie" data-geocode="<?php echo $property['lat']; ?>:<?php echo $property['lng']; ?>" data-class-id="<?php echo $property['class_id']; ?>">
            <?php if (isset($property['status'])): ?>
            <?php if ($property['status'] == 5): ?>
            <div class="flex-property-new-listing"><?php echo __('rented', IDXBOOST_DOMAIN_THEME_LANG); ?>!</div>
            <?php elseif($property['status'] == 2): ?>
            <div class="flex-property-new-listing"><?php echo __('sold', IDXBOOST_DOMAIN_THEME_LANG); ?>!</div>
            <?php elseif($property['status'] != 1): ?>
            <div class="flex-property-new-listing"><?php echo __('pending', IDXBOOST_DOMAIN_THEME_LANG); ?>!</div>               
            <?php endif; ?>
            <?php else: ?>
            <?php if (isset($property['recently_listed']) && $property['recently_listed'] === 'yes'): ?>
            <div class="flex-property-new-listing"><?php echo __('new listing', IDXBOOST_DOMAIN_THEME_LANG); ?>!</div>
            <?php endif ?>
            <?php endif; ?>
            <?php
              $arraytemp = str_replace(' , ', ', ', $property["address_large"]);
              $final_address_parceada = $property['address_short'] . "<span>" . $arraytemp . "</span>";
              $final_address_parceada_new = "<span>".$property['address_short'] . $arraytemp . "</span>";
              ?>
            <h2 title="<?php echo $property['full_address']; ?>">
            <?php if ($sta_view_grid_type=='1') { ?>
              <span><?php echo $property['full_address_top']; ?></span>
              <span><?php echo $property['full_address_bottom']; ?></span>
            <?php }else{ ?>
              <span><?php echo $property['full_address']; ?></span>
            <?php } ?>
            </h2>
            <ul class="features">
              <li class="address"><?php echo $property['full_address']; ?></li>
              <li class="price">$<?php echo number_format($property['price']); ?></li>
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
              <li class="living-size"> <span><?php echo number_format($property['sqft']); ?></span>Sq.Ft <span>(<?php echo $property['living_size_m2']; ?> m2)</span></li>
              <li class="price-sf"><span>$<?php echo $property['price_sqft']; ?></span>/ Sq.Ft<span>($<?php echo $property['price_sqft_m2']; ?> m2)</span></li>
              <?php if (!empty($property['subdivision'])): ?>
              <li class="development"><span><?php echo $property['subdivision']; ?></span></li>
              <?php elseif (!empty($property['development'])): ?>
              <li class="development"><span><?php echo $property['development']; ?></span></li>
              <?php else: ?>
              <li class="development"><span><?php echo $property['complex']; ?></span></li>
              <?php endif; ?>
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
              <button class="prev flex-slider-prev"><span class="clidxboost-icon-arrow-select"></span></button>
              <button class="next flex-slider-next"><span class="clidxboost-icon-arrow-select"></span></button>
              <?php if (!isset($property['status'])): ?>
              <?php if ($property['is_favorite'] == true): ?>
              <?php $filter_favorite_idxboost=$filter_favorite_idxboost+1; ?>
              <button class="clidxboost-btn-check flex-favorite-btn" data-alert-token="<?php echo $property['token_alert'];?>">
              <span class="clidxboost-icon-check active"></span>
              </button>
              <?php else: ?>
              <button class="clidxboost-btn-check flex-favorite-btn">
              <span class="clidxboost-icon-check"></span>
              </button>
              <?php endif; ?>
              <?php endif; ?>
            </div>
            <?php if (isset($property["status"])): ?>
            <?php if (2 == $property["status"]): ?>
            <a class="view-detail" href="#"><?php echo $property['full_address']; ?></a>
            <?php elseif(5 == $property["status"]): ?>
            <a class="view-detail" href="#"><?php echo $property['full_address']; ?></a>
            <?php elseif(6 == $property["status"]): ?>
            <a class="view-detail" href="#"><?php echo $property['full_address']; ?></a>
            <?php else: ?>
            <a class="view-detail" href="#"><?php echo $property['full_address']; ?></a>
            <?php endif; ?>
            <?php else: ?>
            <a class="view-detail" href="#"><?php echo $property['full_address']; ?></a>
            <?php endif; ?>
            <a class="view-map-detail" data-geocode="<?php echo $property['lat']; ?>:<?php echo $property['lng']; ?>">View Map</a>
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
          <?php //if ( (is_numeric($atts['limit']) && $atts['limit'] !='default')  && $atts['limit']<=$countimte ) { break; }  ?>
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
    <?php //if ( (!is_numeric($atts['limit']) && $atts['limit'] =='default')) { ?>
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
</div>

<?php include FLEX_IDX_PATH . '/views/shortcode/idxboost_modals_filter.php';  ?>


<!--
<div class="content-rsp-btn">
  <div class="idx-btn-content">
    <div class="idx-bg-group">
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
</div>-->

<script type="text/javascript">
  var idxboost_hackbox_filter=[];
   
   <?php if(array_key_exists("hackbox", $response)){ ?>
    idxboost_hackbox_filter= <?php echo json_encode($response["hackbox"]); ?>;
   <?php } ?>

  jQuery(document).ready(function(){
    jQuery('.clidxboost-icon-favorite span span').text("<?php echo $filter_favorite_idxboost; ?>");
  });

/*
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
*/

  jQuery(".ib-btn-show").click(function() {
    jQuery(this).parents('.propertie').toggleClass('active-list');
  });

  var view_grid_type='';
  view_grid_type='<?php echo $sta_view_grid_type; ?>';
  if ( !jQuery('body').hasClass('clidxboost-ngrid') && view_grid_type==1) {
    jQuery('body').addClass('clidxboost-ngrid');
  }  
</script>
