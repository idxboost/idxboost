<?php
  $idxboost_query_slug = $_SERVER['QUERY_STRING'];
  $idxboost_query_slug_array = explode('&', $idxboost_query_slug );
  $idxboost_ver_bool=true;
  $idxbooststrpos=['pagenum','lotsize','parking','waterdesc','bath','sqft','bed','yearbuilt','price','sort','view','intervaldate'];
  
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
<div class="ms-shortcode-sold-properties-filters">
  <div class="clidxboost-sc-filters idxboost-content-filter-<?php echo $class_multi; ?>" id="sold_properties_filter">
    <div id="wrap-subfilters">
      <div class="gwr">
        <div class="ms-filter">
          <form action="#" method="post">
            <div class="ms-wrapper-month-list">
              <ul class="ms-month-list">
                <li class="ms-item">
                  <div class="ms-chk -radio">
                    <input id="m3" type="radio" name="month" value="3" class="f-interval-date" <?php if($atts['intervaldate']=='0-3') echo 'checked'; ?> >
                    <label for="m3">0-3 Months Back</label>
                  </div>
                </li>
                <li class="ms-item">
                  <div class="ms-chk -radio">
                    <input id="m6" type="radio" name="month" value="6" class="f-interval-date" <?php if($atts['intervaldate']=='3-6') echo 'checked'; ?>>
                    <label for="m6">3-6 Months Back</label>
                  </div>
                </li>
                <li class="ms-item">
                  <div class="ms-chk -radio">
                    <input id="m12" type="radio" name="month" value="12" class="f-interval-date" <?php if($atts['intervaldate']=='6-12') echo 'checked'; ?> >
                    <label for="m12">6-12 Months Back</label>
                  </div>
                </li>
                <li class="ms-item">
                  <div class="ms-chk -radio">
                    <input id="m24" type="radio" name="month" value="24" class="f-interval-date" <?php if($atts['intervaldate']=='12-24') echo 'checked'; ?> >
                    <label for="m24">12-24 Months Back</label>
                  </div>
                </li>
              </ul>
            </div>
            <div class="ms-wrapper-filters-list">
              <div class="ms-item fg">
                <label for="thecityid">Property Types</label>
                <select class="ms-select fc-select f-ptype" name="ptype" id="ptype">
                  <option value="2" <?php if($atts['class_id']=='2') echo 'selected'; ?>>Homes</option>
                  <option value="1" <?php if($atts['class_id']=='1') echo 'selected'; ?>>Condos</option>
                </select>
              </div>
              <div class="ms-item fg">
                <label for="thecityid">Neighborhood</label>
                        <select class="ms-select fc-select f-neighborhood" name="thecityid" id="thecityid">
                            <option value="12" <?php if($atts['city_id']=='12') echo 'selected'; ?> >Coconut Grove</option>
                            <option value="474" <?php if($atts['city_id']=='474') echo 'selected'; ?>>Aventura</option>
                            <option value="447" <?php if($atts['city_id']=='447') echo 'selected'; ?>>Broward</option>
                            <option value="1" <?php if($atts['city_id']=='1') echo 'selected'; ?>>Miami-Dade</option>
                            <option value="4" <?php if($atts['city_id']=='4') echo 'selected'; ?>>Miami Shore</option>
                            <option value="202" <?php if($atts['city_id']=='202') echo 'selected'; ?>>Edgewater</option>
                            <option value="475" <?php if($atts['city_id']=='475') echo 'selected'; ?>>Bal Harbour</option>
                            <option value="499" <?php if($atts['city_id']=='499') echo 'selected'; ?>>Fort Lauderdale</option>
                            <option value="144" <?php if($atts['city_id']=='144') echo 'selected'; ?>>Brickell</option>
                            <option value="486" <?php if($atts['city_id']=='486') echo 'selected'; ?>>Coral Gables</option>
                            <option value="520" <?php if($atts['city_id']=='520') echo 'selected'; ?>>Key Biscayne</option>
                            <option value="5" <?php if($atts['city_id']=='5') echo 'selected'; ?>>Kendall</option>
                            <option value="61" <?php if($atts['city_id']=='61') echo 'selected'; ?>>Downtown Miami</option>
                            <option value="173" <?php if($atts['city_id']=='173') echo 'selected'; ?>>High Pines and Ponce Davis</option>
                            <option value="533" <?php if($atts['city_id']=='533') echo 'selected'; ?>>Miami Beach</option>
                            <option value="552" <?php if($atts['city_id']=='552') echo 'selected'; ?>>Palmetto Bay</option>
                            <option value="568" <?php if($atts['city_id']=='568') echo 'selected'; ?>>South Miami</option>
                            <option value="557" <?php if($atts['city_id']=='557') echo 'selected'; ?>>Pinecrest</option>
                            <option value="229" <?php if($atts['city_id']=='229') echo 'selected'; ?>>South of Fifth</option>
                            <option value="230" <?php if($atts['city_id']=='230') echo 'selected'; ?>>South Beach</option>
                            <option value="572" <?php if($atts['city_id']=='572') echo 'selected'; ?>>Sunny Isles</option>                            
                            <option value="574" <?php if($atts['city_id']=='574') echo 'selected'; ?>>Surfside</option>
                            <option value="497" <?php if($atts['city_id']=='497') echo 'selected'; ?>>Fisher Island</option>
                            <option value="100" <?php if($atts['city_id']=='100') echo 'selected'; ?>>Venetian</option>
                        </select>
              </div>
              <div class="ms-item fg">
                <label for="thestyle">Property Style</label>
                <div class="ms-dropdown fc-dropdown f-pstyle js-fc-dropdown">
                  <button class="fc-dropdown__toggle" type="button"> <?php 
                  if($atts['property_style']=='waterfront'){
                   echo "Waterfront";
                  }
                  
                  if($atts['property_style']=='no_waterfront'){
                   echo "No Waterfront";
                  }  


                  if($atts['property_style']=='all'){
                   echo "All Properties";
                  }  

                  if($atts['property_style']=='new'){
                   echo "new";
                  }  

                  ?></button>
                  <ul class="ms-dropdown-list fc-dropdown__menu" id="thestyle">
                    <li class="ms-li fc-dropdown__item ms-chk -radio">
                      <input class="fc-dropdown__check thestylefield js-pstyle" id="all" name="thestyle[]" type="radio" value="1" <?php if($atts['property_style']=='all') echo 'checked';?> >
                      <label for="all">All Properties</label>
                    </li>

                    <li class="ms-li fc-dropdown__item ms-chk -radio">
                      <input class="fc-dropdown__check thestylefield js-pstyle" id="waterfront" name="thestyle[]" type="radio" value="1" <?php if($atts['property_style']=='waterfront') echo 'checked';?> >
                      <label for="waterfront">Waterfront</label>
                    </li>
                    <li class="ms-li fc-dropdown__item ms-chk -radio">
                      <input class="fc-dropdown__check thestylefield js-pstyle" id="no_waterfront" name="thestyle[]" type="radio" value="1" <?php if($atts['property_style']=='no_waterfront') echo 'checked';?> >
                      <label for="no_waterfront">No Waterfront</label>
                    </li>
                    <li class="ms-li fc-dropdown__item ms-chk -radio">
                      <input class="fc-dropdown__check thestylefield js-pstyle" id="new" name="thestyle[]" type="radio" value="1" <?php if($atts['property_style']=='new') echo 'checked';?> >
                      <label for="new">New</label>
                    </li>
                  </ul>
                </div>
              </div>
              <div class="ms-item fg">
                <label for="thepricerange">Price Range</label>
                <select class="ms-select fc-select f-pricerange" name="the_pricerange" id="the_pricerange">
                  <option value="1" <?php if($price_select=='1') echo 'selected'; ?> >Up to $1 M</option>
                  <!--
                  <option value="2" <?php if($price_select=='2') echo 'selected'; ?>>1M to 2M</option>
                  <option value="3" <?php if($price_select=='3') echo 'selected'; ?>>2M to 3M</option>-->
                  <option value="8" <?php if($price_select=='8') echo 'selected'; ?>>$1 M to $3 M</option>
                  <option value="4" <?php if($price_select=='4') echo 'selected'; ?>>$3 M to $5 M</option>
                  <option value="5" <?php if($price_select=='5') echo 'selected'; ?>>$5 M to $8 M</option>
                  <option value="6" <?php if($price_select=='6') echo 'selected'; ?>>$8 M+</option>
                  <option value="7" <?php if($price_select=='7') echo 'selected'; ?>>All Ranges</option>
                </select>
              </div>
            </div>
            <div class="ms-wrapper-card-list">
              <div class="ms-item">
                <div class="ms-card">
                  <span class="ms-label">MOI</span>
                  <span class="ms-dt js-moi"></span>
                </div>
              </div>

              <div class="ms-item">
                <div class="ms-card">
                  <span class="ms-label">AVG Property Size</span>
                  <span class="ms-dt js-sqft_sold"></span>
                </div>
              </div>
                            
              <div class="ms-item">
                <div class="ms-card">
                  <span class="ms-label">% Ratio List/Close Price</span>
                  <span class="ms-dt js-percent_sale_sold_price"></span>
                </div>
              </div>
              <div class="ms-item">
                <div class="ms-card">
                  <span class="ms-label">AVG $ / SQFT</span>
                  <span class="ms-dt js-pxsqft-sold"></span>
                </div>
              </div>
            </div>
          </form>
        </div>
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
              <option value="price_sqft-desc" <?php selected($atts['sort'], 'price_sqft-desc'); ?>><?php echo __("Highest Price/Sq.Ft", IDXBOOST_DOMAIN_THEME_LANG); ?></option>
              <option value="price_sqft-asc" <?php selected($atts['sort'], 'price_sqft-asc'); ?>><?php echo __("Lowest Price/Sq.Ft", IDXBOOST_DOMAIN_THEME_LANG); ?></option>
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
        <?php } ?>
        <?php } ?>
      </div>
    </div>
    <section id="wrap-result" class="ms-shortcode wrap-result wrap-result-<?php echo $class_multi; ?> view-<?php echo $viewfilter; ?>" filtemid="<?php echo $class_multi; ?>">
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

  <div class="ms-loading-result">
    <span>Loading results...</span>
	  <div class="ms-wrapper-dots">
    	<div class="ms-dots-loading"></div>
    </div>
  </div>
</div>
