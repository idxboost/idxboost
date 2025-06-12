<?php
  $idxboost_query_slug = $_SERVER['QUERY_STRING'];
  $idxboost_query_slug_array = explode('&', $idxboost_query_slug );
  $idxboost_ver_bool=true;
  $idxbooststrpos=['pagenum','lotsize','parking','waterdesc','bath','sqft','bed','yearbuilt','price','sort','view'];

  foreach ($idxbooststrpos as $valuestrpost) {
    $idxboostpost = strpos($idxboost_query_slug, $valuestrpost );
    if($idxboostpost === false ) {
      $idxboost_ver_bool=true;
    }else{
      $idxboost_ver_bool=false;
      break;
    }
  }
  $idxboost_ver_bool=true;
?>

<?php
  global $post;
  $filter_favorite_idxboost=0;
  $filter_type_fl = get_post_meta($post->ID, '_flex_filter_page_fl', true);
  if (empty($filter_type_fl)) {
    $filter_type_fl=$typeworked;
  }
  $viewfilter='';
  if (empty($atts['view']))  $viewfilter='grid'; else $viewfilter=$atts['view']; 

  ?>
<div class="clidxboost-sc-filters idxboost-content-filter-<?php echo $class_multi; ?>" id="sold_properties_filter">
  <div id="wrap-subfilters">
    <div class="gwr">


    <div class="filter">
            <form action="#" method="post">

                <div class="filter__middle">
                    <div class="fg">
                        <label for="thecityid">Property Types</label>
                        <select class="fc-select f-ptype" name="ptype" id="ptype">
                            <option value="2" <?php if($atts['class_id']=='2') echo 'selected'; ?>>Homes</option>
                            <option value="1" <?php if($atts['class_id']=='1') echo 'selected'; ?>>Condos</option>
                        </select>
                    </div>

                    <div class="fg">
                        <label for="thecityid">Neighborhood</label>
                        <select class="fc-select f-neighborhood" name="thecityid" id="thecityid">
                            <option value="12" <?php if($atts['city_id']=='12') echo 'selected'; ?> >Coconut Grove</option>
                            <option value="2" <?php if($atts['city_id']=='2') echo 'selected'; ?>>Aventura Real Estate</option>                            
                            <option value="202" <?php if($atts['city_id']=='202') echo 'selected'; ?>>Edgewater</option>
                            <option value="3" <?php if($atts['city_id']=='3') echo 'selected'; ?>>Bal Harbour</option>
                            <option value="27" <?php if($atts['city_id']=='27') echo 'selected'; ?>>Fort Lauderdale</option>
                            <option value="144" <?php if($atts['city_id']=='144') echo 'selected'; ?>>Brickell</option>
                            <option value="14" <?php if($atts['city_id']=='14') echo 'selected'; ?>>Coral Gables Real Estate</option>
                            <option value="49" <?php if($atts['city_id']=='49') echo 'selected'; ?>>Key Biscayne Real Estate</option>
                            <option value="61" <?php if($atts['city_id']=='61') echo 'selected'; ?>>Downtown Miami Real Estate</option>
                            <option value="62" <?php if($atts['city_id']=='62') echo 'selected'; ?>>Miami Beach Real Estate</option>
                            <option value="86" <?php if($atts['city_id']=='86') echo 'selected'; ?>>Palmetto Bay Real Estate</option>
                            <option value="91" <?php if($atts['city_id']=='91') echo 'selected'; ?>>Pinecrest Real Estate</option>
                            <option value="102" <?php if($atts['city_id']=='102') echo 'selected'; ?>>South Miami Real Estate</option>
                            <option value="229" <?php if($atts['city_id']=='229') echo 'selected'; ?>>South of Fifth</option>
                            <option value="230" <?php if($atts['city_id']=='230') echo 'selected'; ?>>South Beach</option>
                            <option value="106" <?php if($atts['city_id']=='106') echo 'selected'; ?>>Sunny Isles</option>                            
                            <option value="108" <?php if($atts['city_id']=='108') echo 'selected'; ?>>Surfside Real Estate</option>
                        </select>
                    </div>

                    <div class="fg">
                        <label for="thestyle">Property style</label>
                        <div class="fc-dropdown f-pstyle js-fc-dropdown">
                            <button class="fc-dropdown__toggle" type="button">Any Style</button>
                            <ul class="fc-dropdown__menu" id="thestyle">
                                <li class="fc-dropdown__item">
                                    <input class="fc-dropdown__check thestylefield js-pstyle" id="regular" name="thestyle[]" type="radio" value="1" <?php if($atts['property_style']=='regular') echo 'checked';?> >
                                    <label for="regular">All Properties</label>
                                </li>
                                <li class="fc-dropdown__item">
                                    <input class="fc-dropdown__check thestylefield js-pstyle" id="waterfront" name="thestyle[]" type="radio" value="1" <?php if($atts['property_style']=='waterfront') echo 'checked';?> >
                                    <label for="waterfront">Waterfront</label>
                                </li>
                                <li class="fc-dropdown__item">
                                    <input class="fc-dropdown__check thestylefield js-pstyle" id="no_waterfront" name="thestyle[]" type="radio" value="1" <?php if($atts['property_style']=='no_waterfront') echo 'checked';?> >
                                    <label for="no_waterfront">No Waterfront</label>
                                </li>
                                <li class="fc-dropdown__item">
                                    <input class="fc-dropdown__check thestylefield js-pstyle" id="new" name="thestyle[]" type="radio" value="1" <?php if($atts['property_style']=='new') echo 'checked';?> >
                                    <label for="new">New</label>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <div class="fg">
                        <label for="thepricerange">Price Range</label>
                        <select class="fc-select f-pricerange" name="the_pricerange" id="the_pricerange">
                            <option value="1" <?php if($price_select=='1') echo 'selected'; ?> >Up to 1M</option>
                            <option value="2" <?php if($price_select=='2') echo 'selected'; ?>>1M to 2M</option>
                            <option value="3" <?php if($price_select=='3') echo 'selected'; ?>>2M to 3M</option>
                            <option value="4" <?php if($price_select=='4') echo 'selected'; ?>>3M to 5M</option>
                            <option value="5" <?php if($price_select=='5') echo 'selected'; ?>>5M to 7.5M</option>
                            <option value="6" <?php if($price_select=='6') echo 'selected'; ?>>7.5M+</option>
                            <option value="7" <?php if($price_select=='7') echo 'selected'; ?>>All Ranges</option>
                        </select>
                    </div>

                </div>


            </form>
        </div>

      <ul id="sub-filters">
        <li id="link-favorites">
          <a role="button" title="<?php echo __("My Saved Listings", IDXBOOST_DOMAIN_THEME_LANG); ?>" class="clidxboost-icon-favorite">
          <span>
          <span><?php echo number_format($response_canti['count']); ?></span><?php echo __("Favorites", IDXBOOST_DOMAIN_THEME_LANG); ?></span>
          </a>
        </li>
        <li id="filter-by" class="clidxboost-icon-arrow-select">
          <span class="filter-text"><?php echo __("Newest Listings", IDXBOOST_DOMAIN_THEME_LANG); ?></span>
          <select id="flex_idx_sort" class="flex_idx_sort flex_idx_sort-<?php echo $class_multi; ?>" data-permalink="<?php the_permalink(); ?>" data-currpage="<?php echo $response['pagination']['current_page_number']; ?>" filtemid="<?php echo $class_multi; ?>">
              <option value="last_updated-desc" <?php selected($atts['sort'], 'last_updated-desc'); ?>><?php echo __('Modified Listings', IDXBOOST_DOMAIN_THEME_LANG); ?></option>
              <option value="price-desc" <?php selected($atts['sort'], 'price-desc'); ?>><?php echo __("Highest Price", IDXBOOST_DOMAIN_THEME_LANG); ?></option>
              <option value="price-asc" <?php selected($atts['sort'], 'price-asc'); ?>><?php echo __("Lowest Price", IDXBOOST_DOMAIN_THEME_LANG); ?></option>
              <option value="sqft-desc" <?php selected($atts['sort'], 'sqft-desc'); ?>><?php echo __("Highest Sq.Ft", IDXBOOST_DOMAIN_THEME_LANG); ?></option>
              <option value="sqft-asc" <?php selected($atts['sort'], 'sqft-asc'); ?>><?php echo __("Lowest Sq.Ft", IDXBOOST_DOMAIN_THEME_LANG); ?></option>
          </select>
        </li>
        <li id="filter-views" class="filter-views filter-views-<?php echo $class_multi; ?> clidxboost-icon-arrow-select <?php echo $response['view']; ?>" filtemid="<?php echo $class_multi; ?>">
          <select>
            <option value="grid" <?php selected($atts['view'], 'grid'); ?>><?php echo __("Grid", IDXBOOST_DOMAIN_THEME_LANG); ?></option>
            <option value="list" <?php selected($atts['view'], 'list'); ?>><?php echo __("List", IDXBOOST_DOMAIN_THEME_LANG); ?></option>
            <option value="map" <?php selected($atts['view'], 'map'); ?>><?php echo __("Map", IDXBOOST_DOMAIN_THEME_LANG); ?></option>
          </select>
        </li>
      </ul>
      <?php if ( (!is_numeric($atts['limit']) && $atts['limit'] =='default')) { ?>
      <?php
        if($idxboost_ver_bool==false){ ?>
      <span id="info-subfilters"><span></span></span>
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
          <li class="price-sf"><?php echo __('Price', IDXBOOST_DOMAIN_THEME_LANG); ?> / Sq.Ft. </li>
          <li class="development"><?php echo __('Development', IDXBOOST_DOMAIN_THEME_LANG); ?> / <?php echo __('Subdivision', IDXBOOST_DOMAIN_THEME_LANG); ?></li>
        </ul>
        <ul id="result-search" class="slider-generator" style="overflow-y:auto;">
        
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

    <div id="paginator-cnt" class="gwr">
      <nav id="nav-results" class="nav-results nav-results-<?php echo $class_multi; ?>" filtemid="<?php echo $class_multi; ?>">
      </nav>
    </div>
  </section>
</div>
