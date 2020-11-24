<?php if (isset($atts["mode"]) && ("grid" === $atts["mode"])): ?>
<script type="text/javascript">
var NO_REFRESH_F_AJAX = true;
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
?>
<script>
var filter_metadata = <?php echo trim(json_encode($response)); ?>;
var search_metadata = <?php echo trim(json_encode($search_params)); ?>;
</script>
<form method="post" id="flex-idx-filter-form" class="flex-idx-filter-form flex-idx-filter-form-<?php echo $class_multi; ?>" filtemid="<?php echo $class_multi; ?>">
    <input type="hidden" name="action" value="filter_search">
    <input type="hidden" name="filter_ID" value="<?php echo get_the_ID(); ?>">
    <input type="hidden" name="idx[min_price]" id="idx_min_price" value="<?php echo $response['info']['min_price']; ?>">
    <input type="hidden" name="idx[max_price]" id="idx_max_price" value="<?php echo $response['info']['max_price']; ?>">
    <input type="hidden" name="idx[min_rent_price]" id="idx_min_rent_price" value="<?php echo $response['info']['min_price']; ?>">
    <input type="hidden" name="idx[max_rent_price]" id="idx_max_rent_price" value="<?php echo $response['info']['max_price']; ?>">
    <input type="hidden" name="idx[tab]" id="idx_property_type" value="<?php echo $response['info']['property_type']; ?>">
    <input type="hidden" name="idx[rental]" id="idx_rental" value="<?php echo $response['info']['rental_type'][0]; ?>">
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
<div class="idxboost-content-filter-<?php echo $class_multi; ?>" filtemid="<?php echo $class_multi; ?>">

<div class="content-filters" <?php if($filter_type_fl != 3): ?> style="display:none;" <?php endif; ?> >
  <div class="animated fixed-box" id="wrap-filters">
    <div class="gwr gwr-filters">
      <ul id="filters">
        <li class="price">
          <button> <span class="clidxboost-icon-arrow-select"> <span id="text-price"><?php echo __('Price Range', IDXBOOST_DOMAIN_THEME_LANG); ?></span></span></button>
        </li>
        <li class="beds">
          <button> <span class="clidxboost-icon-arrow-select"> <span id="text-beds"><?php echo __('Beds', IDXBOOST_DOMAIN_THEME_LANG); ?></span></span></button>
        </li>
        <li class="baths">
          <button> <span class="clidxboost-icon-arrow-select"> <span id="text-baths"><?php echo __('Baths', IDXBOOST_DOMAIN_THEME_LANG); ?></span></span></button>
        </li>
        <li class="type">
          <button> <span class="clidxboost-icon-arrow-select"> <span id="text-type"><?php echo __('Type', IDXBOOST_DOMAIN_THEME_LANG); ?></span></span></button>
        </li>
        <li class="all">
          <button><span class="clidxboost-icon-arrow-select"> <span><?php echo __('Advanced', IDXBOOST_DOMAIN_THEME_LANG); ?></span></span></button>
        </li>
        <li class="save">
          <button type="button" id="filter-save-search" data-count="<?php echo (int) $response['pagination']['total_items_count']; ?>" style="display: block;width: 100%;background: #333;height: 100%;color: #fff;margin: 0;"><?php echo __('Save Search', IDXBOOST_DOMAIN_THEME_LANG); ?></button>
        </li>
      </ul>
      <div id="all-filters">
        <ul class="hidden-sr" id="mini-filters">
          <li class="price">
            <div class="gwr">
              <h4 class="clidxboost-icon-arrow-select"><?php echo __('Price Range', IDXBOOST_DOMAIN_THEME_LANG); ?></h4>

                <div class="wrap-item price_range_for_sale price_ranges_ct" <?php if($response['info']['rental_type'] == 1): ?> style="display:none;" <?php endif; ?>>
                        <div class="wrap-inputs">
                            <input id="price_from" class="notranslate" type="text" value=""> <span><?php echo __('to', IDXBOOST_DOMAIN_THEME_LANG); ?></span>
                            <input id="price_to" class="notranslate" type="text" value="">
                        </div>
                        <div class="wrap-range">
                            <div id="range-price" class="range-slide"></div>
                        </div>
                </div>
                <div class="wrap-item price_range_for_rent price_ranges_ct" <?php if($response['info']['rental_type'] == 0): ?> style="display:none;" <?php endif; ?>>
                        <div class="wrap-inputs">
                            <input id="price_rent_from" class="notranslate" type="text" value=""><span>to</span>
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
              <h4 class="clidxboost-icon-arrow-select"><?php echo __('Bathrooms', IDXBOOST_DOMAIN_THEME_LANG); ?></h4>
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
              <h4 class="clidxboost-icon-arrow-select"><?php echo __('Bedrooms', IDXBOOST_DOMAIN_THEME_LANG); ?></h4>
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
              <h4 class="clidxboost-icon-arrow-select"><?php echo __('Type', IDXBOOST_DOMAIN_THEME_LANG); ?></h4>
              <div class="wrap-item">
                <div class="wrap-checks">
                  <ul>
                    <?php foreach ($search_params['property_types'] as $property_type): ?>
                    <li>
                        <input class="property_type_checkbox" type="checkbox" <?php if(in_array($property_type["value"], $ptypes_checked)): ?> checked <?php endif; ?> value="<?php echo $property_type['value']; ?>" id="_pt_<?php echo $property_type['value']; ?>">
                        <label for="_pt_<?php echo $property_type['value']; ?>"><?php echo $property_type['label']; ?></label>
                    </li>
                    <?php endforeach; ?>
                  </ul>
                </div>
              </div>
            </div>
          </li>
          <li class="living">
            <div class="gwr">
              <h4 class="clidxboost-icon-arrow-select"><?php echo __('Living size', IDXBOOST_DOMAIN_THEME_LANG); ?></h4>
              <div class="wrap-item">
                <div class="wrap-inputs">
                  <input id="living_from" class="notranslate" type="text" name="" value=""><span><?php echo __('to', IDXBOOST_DOMAIN_THEME_LANG); ?></span>
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
              <h4 class="clidxboost-icon-arrow-select"><?php echo __('Year Built', IDXBOOST_DOMAIN_THEME_LANG); ?></h4>
              <div class="wrap-item">
                <div class="wrap-inputs">
                  <input id="year_from" type="text" name="" value=""><span><?php echo __('to', IDXBOOST_DOMAIN_THEME_LANG); ?></span>
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
              <h4 class="clidxboost-icon-arrow-select"><?php echo __('Waterfront description', IDXBOOST_DOMAIN_THEME_LANG); ?></h4>
              <div class="wrap-item">
                <div class="wrap-select clidxboost-icon-arrow-select">
                <select id="flex_waterfront_switch">
                <option value="--"><?php echo __('Any', IDXBOOST_DOMAIN_THEME_LANG); ?></option>
                <?php foreach ($search_params['waterfront_options'] as $waterfront_option): ?>
                <option <?php selected((isset($water_desc) ? $water_desc : ''), $waterfront_option['code']); ?> value="<?php echo $waterfront_option['code']; ?>"><?php echo $waterfront_option['name']; ?></option>
                <?php endforeach; ?>
                </select>
                </div>
              </div>
            </div>
          </li>
          <li class="parking">
            <div class="gwr">
              <h4 class="clidxboost-icon-arrow-select"><?php echo __('Parking spaces', IDXBOOST_DOMAIN_THEME_LANG); ?></h4>
              <div class="wrap-item">
                <div class="wrap-select clidxboost-icon-arrow-select">
                <select id="flex_parking_switch">
                <option value="--"><?php echo __('Any', IDXBOOST_DOMAIN_THEME_LANG); ?></option>
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
              <h4 class="clidxboost-icon-arrow-select"><?php echo __('Land size', IDXBOOST_DOMAIN_THEME_LANG); ?></h4>
              <div class="wrap-item">
                <div class="wrap-inputs">
                  <input id="land_from" class="notranslate" type="text" name="" value=""><span><?php echo __('to', IDXBOOST_DOMAIN_THEME_LANG); ?></span>
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
                <label><?php echo __('Features', IDXBOOST_DOMAIN_THEME_LANG); ?></label>
              </h4>
              <div class="wrap-item">
                <div class="wrap-checks">
                    <ul>
                    <?php foreach ($search_params['amenities'] as $amenity): ?>
                    <li>
                        <input class="amenities_checkbox" type="checkbox" value="<?php echo $amenity['code']; ?>" id="_amenity_<?php echo $amenity['code']; ?>">
                        <label for="_amenity_<?php echo $amenity['code']; ?>"><?php echo $amenity['name']; ?></label>
                    </li>
                    <?php endforeach; ?>
                    </ul>
                </div>
              </div>
            </div>
          </li>
          <li class="action-filter">
            <button id="apply-filters-min"><?php echo __('Matching', IDXBOOST_DOMAIN_THEME_LANG); ?> <span id="properties-found-2"><?php echo flex_idx_format_short_price_fn($response['pagination']['total_items_count']); ?> </span><?php echo __('Listings', IDXBOOST_DOMAIN_THEME_LANG); ?></button>
          </li>
          <button id="apply-filters"><span><?php echo __('Apply Filters', IDXBOOST_DOMAIN_THEME_LANG); ?></span></button>
        </ul>
      </div>
    </div>
  </div>
</div>
<div id="wrap-subfilters" style="margin-top:15px;display:none !important;">
    <div class="gwr">
        <ul id="sub-filters">
            <li id="link-favorites"><a href="#" title="My Saved Listings" class="clidxboost-icon-favorite"><span><span><?php echo number_format($response_canti['count']); ?></span><?php echo __('Favorites', IDXBOOST_DOMAIN_THEME_LANG); ?></span></a></li>
            <li id="filter-by" class="clidxboost-icon-arrow-select">
                <select id="flex_idx_sort" class="flex_idx_sort flex_idx_sort-<?php echo $class_multi; ?>" data-permalink="<?php the_permalink(); ?>" data-currpage="<?php echo $response['pagination']['current_page_number']; ?>" filtemid="<?php echo $class_multi; ?>">
                  <option value="list_date-desc" <?php selected($response['order'], 'list_date-desc'); ?>><?php echo __("Newest Listings", IDXBOOST_DOMAIN_THEME_LANG); ?></option>
                  <option value="price-desc" <?php selected($response['order'], 'price-desc'); ?>><?php echo __("Highest Price", IDXBOOST_DOMAIN_THEME_LANG); ?></option>
                  <option value="price-asc" <?php selected($response['order'], 'price-asc'); ?>><?php echo __("Lowest Price", IDXBOOST_DOMAIN_THEME_LANG); ?></option>
                  <option value="sqft-desc" <?php selected($response['order'], 'sqft-desc'); ?>><?php echo __("Highest Sq.Ft", IDXBOOST_DOMAIN_THEME_LANG); ?></option>
                  <option value="sqft-asc" <?php selected($response['order'], 'sqft-asc'); ?>><?php echo __("Lowest Sq.Ft", IDXBOOST_DOMAIN_THEME_LANG); ?></option>
                <?php /*
                    <option <?php selected($response['order'], 'price-desc'); ?> value="price-desc">Highest Price</option>
                    <option <?php selected($response['order'], 'price-asc'); ?> value="price-asc">Lowest Price</option>
                    <option <?php selected($response['order'], 'bed-desc'); ?> value="bed-desc">Beds High to Low</option>
                    <option <?php selected($response['order'], 'bed-asc'); ?> value="bed-asc">Beds Low to High</option>
                    <option <?php selected($response['order'], 'sqft-desc'); ?> value="sqft-desc">Size High to Low</option>
                    <option <?php selected($response['order'], 'sqft-asc'); ?> value="sqft-asc">Size Low  to High </option>
                    <option <?php selected($response['order'], 'year-desc'); ?> value="year-desc">Year Newest</option>
                    <option <?php selected($response['order'], 'year-asc'); ?> value="year-asc">Year Oldest</option>
                    <?php if ($filter_type_fl != 1): ?>
                    <option <?php selected($response['order'], 'list_date-desc'); ?> value="list_date-desc"><?php echo __('Newest Listed', IDXBOOST_DOMAIN_THEME_LANG); ?></option>
                    <option <?php selected($response['order'], 'list_date-asc'); ?> value="list_date-asc"><?php echo __('Oldest Listed', IDXBOOST_DOMAIN_THEME_LANG); ?></option>
                    <?php endif; ?>
                    <option <?php selected($response['order'], 'list_date-asc'); ?> value="city_name-asc"><?php echo __('City Name', IDXBOOST_DOMAIN_THEME_LANG); ?></option>
                    <?php if ($filter_type_fl == 1): ?>
                    <option <?php selected($response['order'], 'date_close-desc'); ?> value="date_close-desc"><?php echo __('Date Sold', IDXBOOST_DOMAIN_THEME_LANG); ?></option>
                    <?php endif; ?>
                </select>
            </li>
            <li id="filter-views" class="filter-views filter-views-<?php echo $class_multi; ?> clidxboost-icon-arrow-select <?php echo $response['view']; ?>" filtemid="<?php echo $class_multi; ?>">
                <select>
                    <option value="grid" <?php selected($response['view'], 'grid'); ?>><?php echo __('Grid', IDXBOOST_DOMAIN_THEME_LANG); ?></option>
                    <option value="list" <?php selected($response['view'], 'list'); ?>><?php echo __('List', IDXBOOST_DOMAIN_THEME_LANG); ?></option>
                    <option value="map" <?php selected($response['view'], 'map'); ?>><?php echo __('Map', IDXBOOST_DOMAIN_THEME_LANG); ?></option>
                </select>
            </li>
        </ul>
            <?php if ( (!is_numeric($atts['limit']) && $atts['limit'] =='default')) { ?>
<span id="info-subfilters"><?php echo __('Showing', IDXBOOST_DOMAIN_THEME_LANG); ?> <?php echo $response['pagination']['offset']['start']; ?> <?php echo __('to', IDXBOOST_DOMAIN_THEME_LANG); ?> <?php echo $response['pagination']['offset']['end']; ?> <?php echo __('of', IDXBOOST_DOMAIN_THEME_LANG); ?> <?php echo number_format($response['pagination']['total_items_count']); ?> <?php echo __('Properties', IDXBOOST_DOMAIN_THEME_LANG); ?>.<span><?php echo __('Scroll down for more', IDXBOOST_DOMAIN_THEME_LANG); ?>.</span></span>
        <?php } ?>
    </div>
</div>

<section id="wrap-result" class="wrap-result wrap-result-<?php echo $class_multi; ?> view-<?php echo $viewfilter; ?>" filtemid="<?php echo $class_multi; ?>">
    <h2 class="title"><?php echo __('Search results', IDXBOOST_DOMAIN_THEME_LANG); ?></h2>
    <div class="gwr">
        <div id="wrap-list-result">
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
            <ul id="result-search" class="slider-generator">
                <?php if (isset($response['items'])): $countimte=0; ?>
                    <?php foreach($response['items'] as $key =>  $property):
                      if (isset($atts["max"]) && ($key >= intval($atts["max"]))) {
                        break;
                      }
                      ?>
                      <?php $countimte=$countimte+1; ?>
                    <li data-mls="<?php echo $property['mls_num']; ?>" class="propertie" data-geocode="<?php echo $property['lat']; ?>:<?php echo $property['lng']; ?>" data-class-id="<?php echo $property['class_id']; ?>">
                        <?php if (isset($property['status'])): ?>
                            <?php if ($property['status'] == 5): ?>
                                <div class="flex-property-new-listing"><?php echo __('rented', IDXBOOST_DOMAIN_THEME_LANG); ?>!</div>
                            <?php elseif($property['status'] == 2): ?>
                                <div class="flex-property-new-listing"><?php echo __('sold', IDXBOOST_DOMAIN_THEME_LANG); ?>!</div>
                            <?php endif; ?>
                        <?php else: ?>
                            <?php if (isset($property['recently_listed']) && $property['recently_listed'] === 'yes'): ?>
                            <div class="flex-property-new-listing"><?php echo __('new listing', IDXBOOST_DOMAIN_THEME_LANG); ?>!</div>
                            <?php endif ?>
                        <?php endif; ?>
                        <?php
                        $arraytemp = explode(" , ", $property['address_large']);
                        $final_address_parceada = $property['address_short'] . "<span>".$arraytemp[0]. ", " .$arraytemp[1] ."</span>";
                        ?>
                        <h2 title="<?php echo $property['address_short']; ?> <?php echo $property['address_large']; ?>"><span><?php echo $final_address_parceada; ?></span></h2>                        
                        <ul class="features">
                            <li class="address"><?php echo $property['address_large']; ?></li>
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
                               </span></li>
                            <li class="baths"><?php echo $property['bath']; ?> <span>
                              <?php
                              if ($property['bath']>1) {
                                echo __('Baths', IDXBOOST_DOMAIN_THEME_LANG);
                              }else{
                                echo __('Bath', IDXBOOST_DOMAIN_THEME_LANG);
                              }
                              ?></span></li>
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
                                    alt="<?php echo $property['address_short']; ?> <?php echo $property['address_large']; ?>"></li>
                                    <?php else: ?>
                                    <li class="flex-slider-item-hidden">
                                    <img
                                    class="flex-lazy-image"
                                    data-original="<?php echo $property_photo; ?>"
                                    title="<?php echo $property['address_short']; ?> <?php echo $property['address_large']; ?>"
                                    alt="<?php echo $property['address_short']; ?> <?php echo $property['address_large']; ?>"></li>
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

                        <a class="view-detail" href="<?php echo rtrim($flex_idx_info["pages"]["flex_idx_property_detail"]["guid"], "/"); ?>/<?php echo $property['slug']; ?>"><?php echo $property['address_large']; ?></a>
                    </li>
                    <?php if ( (is_numeric($atts['limit']) && $atts['limit'] !='default')  && $atts['limit']<=$countimte ) { break; }  ?>
                    <?php endforeach; ?>
                <?php endif; ?>
            </ul>

        </div>
        <div id="wrap-map">
            <div id="code-map" class="code-map code-map-<?php echo $class_multi; ?>"></div>
            <div id="map-actions">
                <button class="open-map"><?php echo __('Open', IDXBOOST_DOMAIN_THEME_LANG); ?></button>
                <button class="close-map hide"><?php echo __('Close', IDXBOOST_DOMAIN_THEME_LANG); ?></button>
            </div>
        </div>
    </div>

    <?php if ( (!is_numeric($atts['limit']) && $atts['limit'] =='default')) { ?>
    <div id="paginator-cnt" class="gwr" style="display:none !important;">
      <?php if (isset($response['pagination'])): ?>
      <nav id="nav-results" class="nav-results nav-results-<?php echo $class_multi; ?>" filtemid="<?php echo $class_multi; ?>">
          <span id="indicator">Pag <?php echo $response['pagination']['current_page_number']; ?> of <?php echo $response['pagination']['total_pages_count']; ?></span>
          <?php if ($response['pagination']['has_prev_page'] && ($response['pagination']['total_pages_count'] > 1)): ?>
          <a data-page="1" norefre="<?php the_permalink(); ?>order-<?php echo $response['order']; ?>/view-<?php echo $response['view']; ?>/page-1" title="First Page" id="firstp" class="ad visible firts_page">
              <span class="clidxboost-icon-arrow-select"></span>
              <span class="clidxboost-icon-arrow-select"></span>
              <span>First page</span>
          </a>
          <?php endif; ?>
        <?php if ($response['pagination']['has_prev_page']): ?>
          <a data-page="<?php echo ($response['pagination']['current_page_number'] - 1); ?>" norefre="<?php the_permalink(); ?>order-<?php echo $response['order']; ?>/view-<?php echo $response['view']; ?>/page-<?php echo ($response['pagination']['current_page_number'] - 1); ?>" title="Prev Page" id="prevn" class="arrow clidxboost-icon-arrow-select prevn visible"><span>Previous page</span></a>
          <?php endif; ?>
          <ul id="principal-nav">
              <?php foreach($response['pagination']['range'] as $pages): ?>

              <li id="page_<?php echo $pages; ?>" <?php if($response['pagination']['current_page_number'] == $pages): ?> class="active"<?php endif; ?>>
                  <a data-page="<?php echo $pages; ?>" norefre="<?php the_permalink(); ?>order-<?php echo $response['order']; ?>/view-<?php echo $response['view']; ?>/page-<?php echo $pages; ?>"><?php echo $pages; ?></a>
              </li>
              <?php endforeach; ?>
          </ul>
          <?php if ($response['pagination']['has_next_page']): ?>
          <a data-page="<?php echo ($response['pagination']['current_page_number'] + 1); ?>" norefre="<?php the_permalink(); ?>order-<?php echo $response['order']; ?>/view-<?php echo $response['view']; ?>/page-<?php echo ($response['pagination']['current_page_number'] + 1); ?>" title="Next Page" id="nextn" class="arrow clidxboost-icon-arrow-select nextn visible next_page"><span>Next page</span></a>
          <?php endif; ?>
        <?php if (($response['pagination']['total_pages_count'] > 1) && $response['pagination']['has_next_page']): ?>
          <a data-page="<?php echo $response['pagination']['total_pages_count']; ?>" norefre="<?php the_permalink(); ?>order-<?php echo $response['order']; ?>/view-<?php echo $response['view']; ?>/page-<?php echo $response['pagination']['total_pages_count']; ?>" title="Last Page" id="lastp" class="ad visible last_page">
              <span class="clidxboost-icon-arrow-select"></span>
              <span class="clidxboost-icon-arrow-select"></span>
              <span>Last page</span>
          </a>
          <?php endif; ?>
      </nav>
      <?php endif; ?>
    </div>
    <?php  }  ?>

</section>

<?php if (!empty($atts["target_id"])):
 $target_permalink = is_numeric($atts["target_id"]) ? get_permalink($atts["target_id"]) : esc_url($atts["target_id"]);
 $target_label = empty($atts["target_label"]) ? "VIEW MORE PROPERTIES!" : sanitize_text_field($atts["target_label"]);
?>
<a class="clidxboost-btn-link idx_txt_text_property_front" href="<?php echo $target_permalink; ?>" title="<?php echo $target_label; ?>"> <span><?php echo $target_label; ?></span></a>
<?php endif; ?>

</div>

<script type="text/javascript">
jQuery(document).ready(function(){
  jQuery('.clidxboost-icon-favorite span span').text("<?php echo $filter_favorite_idxboost; ?>");
});
</script>

<script type="text/javascript">
  var view_grid_type='';
  <?php
  $sta_view_grid_type='0'; if(array_key_exists('view_grid_type',$search_params)) $sta_view_grid_type=$search_params['view_grid_type']; ?>
  view_grid_type=<?php echo $sta_view_grid_type; ?>;
  if ( !jQuery('body').hasClass('clidxboost-ngrid') && view_grid_type==1) {
    jQuery('body').addClass('clidxboost-ngrid');
  }
</script>
