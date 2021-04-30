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
  $sta_view_grid_type='0'; if(array_key_exists('view_grid_type',$search_params)) $sta_view_grid_type=$search_params['view_grid_type'];
  if ($atts['method']==0)
    $filterid=get_the_ID();
  ?>
<script>
  //var filter_metadata = <?php //echo trim(json_encode($response)); ?>;
  var search_metadata = <?php echo trim(json_encode($search_params)); ?>;
</script>
<form method="post" id="flex-idx-filter-form" class="flex-idx-filter-form flex-idx-filter-form-<?php echo $class_multi; ?> idxboost-filter-form" data-filter-form-id="<?php echo $unique_filter_form_ID; ?>" filtemid="<?php echo $class_multi; ?>">
  <?php if ($atts["type"]=='2') { ?>
    <input type="hidden" name="action" value="filter_search_exclusive_listing">
  <?php }elseif($atts["type"]=='1'){ ?>
    <input type="hidden" name="action" value="filter_search_recent_sales">
  <?php } ?>
  <input type="hidden" name="filter_ID" value="<?php echo get_the_ID(); ?>">
  <input type="hidden" name="idx[min_price]" id="idx_min_price" value="<?php echo $response['info']['min_price']; ?>">
  <input type="hidden" name="search_count" id="search_count" value="<?php echo $response['counter']; ?>">
  <input type="hidden" name="idx[sale_type]" id="sale_type" value="<?php echo implode('',$sale_type); ?>">
  <input type="hidden" name="idx[max_price]" id="idx_max_price" value="<?php echo $response['info']['max_price']; ?>">
  <input type="hidden" name="idx[min_rent_price]" id="idx_min_rent_price" value="<?php echo $response['info']['min_price_rent']; ?>">
  <input type="hidden" name="idx[max_rent_price]" id="idx_max_rent_price" value="<?php echo $response['info']['max_price_rent']; ?>">
  <input type="hidden" name="idx[tab]" id="idx_property_type" value="<?php echo $response['info']['property_type']; ?>">
  <input type="hidden" name="idx[rental]" id="idx_rental" value="<?php echo $response['info']['rental_type']; ?>">
  <input type="hidden" name="idx[view]" id="idx_view" value="<?php echo $response['view']; ?>">
  <input type="hidden" name="idx[sort]" id="idx_sort" value="<?php echo $response['order']; ?>">
  <input type="hidden" name="idx[page]" id="idx_page" value="<?php echo $response['pagination']['current_page_number']; ?>">
  <input type="hidden" name="filter_panel" id="filter_panel" value="<?php echo $atts['id']; ?>">
  <input type="hidden" name="filter_type" id="filter_type" value="<?php echo $atts['type']; ?>">
  <input type="hidden" name="limit" class="limit" value="<?php echo $atts['limit']; ?>">
  <input type="hidden" name="idx[oh]" id="idx_oh" value="<?php echo $atts['oh']; ?>">
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
      <span id="info-subfilters"><span><?php // echo __("Scroll down for more.", IDXBOOST_DOMAIN_THEME_LANG); ?></span></span>
      <?php }else{ ?>
      <span id="info-subfilters"><?php echo __("Showing", IDXBOOST_DOMAIN_THEME_LANG); ?> <?php echo $response['pagination']['offset']['start']; ?> <?php echo __("to", IDXBOOST_DOMAIN_THEME_LANG); ?> <?php echo $response['pagination']['offset']['end']; ?> <?php echo __("of", IDXBOOST_DOMAIN_THEME_LANG); ?> <?php echo number_format($response['pagination']['total_items_count']); ?> <?php echo __("Properties", IDXBOOST_DOMAIN_THEME_LANG); ?>.<span><?php // echo __("Scroll down for more.", IDXBOOST_DOMAIN_THEME_LANG); ?></span></span>
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
          <?php if (isset($response['items'])): $countimte=0; ?>
          <?php foreach($response['items'] as $key_property => $property): ?>
          <?php $countimte=$countimte+1; ?>
          
          <li data-address="<?php echo $property['address_short']; ?>" data-mls="<?php echo $property['mls_num']; ?>" class="propertie" data-geocode="<?php echo $property['lat']; ?>:<?php echo $property['lng']; ?>" data-class-id="<?php echo $property['class_id']; ?>">
            <?php //if($atts['oh']=="0" ) { ?>
              <?php if ($property['status'] == 5): ?>
              <div class="flex-property-new-listing"><?php echo __('rented', IDXBOOST_DOMAIN_THEME_LANG); ?></div>
              <?php elseif($property['status'] == 2): ?>
              <div class="flex-property-new-listing"><?php echo __('sold', IDXBOOST_DOMAIN_THEME_LANG); ?></div>
              <?php elseif($property['status'] != 1): ?>
              <div class="flex-property-new-listing"><?php echo $property['status_name']; ?></div>
              <?php elseif(isset($property['recently_listed']) && $property['recently_listed'] === 'yes'): ?>
              <div class="flex-property-new-listing"><?php echo __('new listing', IDXBOOST_DOMAIN_THEME_LANG); ?></div>
              <?php endif; ?>
            <?php //} ?>
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
              <?php if (isset($property['status']) && $property['status']!=2): ?>
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

            <?php
            $url_property='#';
            if ($is_recent_sales=='yes') {
              $site_property=rtrim($flex_idx_info["pages"]["flex_idx_property_detail"]["guid"], "/"); 
              $url_property=$site_property.'/'.$property['slug'];
            }
            ?>
              <?php if (isset($property["status"])): ?>
              <?php if (2 == $property["status"]): ?>
              <a class="view-detail" href="<?php echo $url_property; ?>"><?php echo $property['full_address']; ?></a>
              <?php elseif(5 == $property["status"]): ?>
              <a class="view-detail" href="<?php echo $url_property; ?>"><?php echo $property['full_address']; ?></a>
              <?php elseif(6 == $property["status"]): ?>
              <a class="view-detail" href="<?php echo $url_property; ?>"><?php echo $property['full_address']; ?></a>
              <?php else: ?>
              <a class="view-detail" href="<?php echo $url_property; ?>"><?php echo $property['full_address']; ?></a>
              <?php endif; ?>
              <?php else: ?>
              <a class="view-detail" href="<?php echo $url_property; ?>"><?php echo $property['full_address']; ?></a>
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
           end($response['items']);
           if ($key_property === key($response['items']))
            $ib_position_hackbox=key($response['items']);

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
        <span id="indicator"><?php echo __('Page', IDXBOOST_DOMAIN_THEME_LANG); ?> <?php echo $response['pagination']['current_page_number']; ?> <?php echo __('of', IDXBOOST_DOMAIN_THEME_LANG); ?> <?php echo $response['pagination']['total_pages_count']; ?></span>
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
  var idxboost_force_registration=false;

<?php if ( !empty($response) && 
      array_key_exists('force_registration', $response) &&  
      !empty($response['force_registration'])  ) { ?>
      idxboost_force_registration=true;
    <?php  } ?>

  var idxboost_hackbox_filter=[];
   
   <?php
      if( !empty($response) ) {
        if(array_key_exists("hackbox", $response)){ ?>
        idxboost_hackbox_filter= <?php echo json_encode($response["hackbox"]); ?>;
       <?php } 
      }
    ?>

  jQuery(document).ready(function(){
    <?php if (!empty($filter_favorite_idxboost)) { ?>
      jQuery('.clidxboost-icon-favorite span span').text("<?php echo $filter_favorite_idxboost; ?>");
    <?php } ?>
  });

  var view_grid_type='';
  view_grid_type='<?php echo $sta_view_grid_type; ?>';
  if ( !jQuery('body').hasClass('clidxboost-ngrid') && view_grid_type==1) {
    jQuery('body').addClass('clidxboost-ngrid');
  }    
</script>