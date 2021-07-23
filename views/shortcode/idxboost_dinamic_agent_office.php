<?php
  $idxboost_query_slug = $_SERVER['QUERY_STRING'];
  $idxboost_query_slug_array = explode('&', $idxboost_query_slug );
  $idxboost_ver_bool=true;
  $idxbooststrpos=['pagenum','lotsize','parking','waterdesc','bath','sqft','bed','yearbuilt','price','sort','view'];
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
<?php
  global $post;
  $filter_favorite_idxboost=0;
  $filter_type_fl = get_post_meta($post->ID, '_flex_filter_page_fl', true);
  if (empty($filter_type_fl)) {
    $filter_type_fl=$typeworked;
  }
  $viewfilter='grid';
  ?>
<div class="clidxboost-sc-filters ms-shortcode-agent-office idxboost-content-filter-<?php echo $class_multi; ?>" filtemid="<?php echo $class_multi; ?>">
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
              <option value="list_date-desc" <?php selected($atts["order_by"], "list_date-desc"); ?> ><?php echo __("Newest Listings", IDXBOOST_DOMAIN_THEME_LANG); ?></option>
              <option value="price-desc" <?php selected($atts["order_by"], "price-desc"); ?>><?php echo __("Highest Price", IDXBOOST_DOMAIN_THEME_LANG); ?></option>
              <option value="price-asc" <?php selected($atts["order_by"], "price-asc"); ?>><?php echo __("Lowest Price", IDXBOOST_DOMAIN_THEME_LANG); ?></option>
              <option value="sqft-desc" <?php selected($atts["order_by"], "sqft-desc"); ?>><?php echo __("Highest Sq.Ft", IDXBOOST_DOMAIN_THEME_LANG); ?></option>
              <option value="sqft-asc" <?php selected($atts["order_by"], "sqft-asc"); ?>><?php echo __("Lowest Sq.Ft", IDXBOOST_DOMAIN_THEME_LANG); ?></option>
          </select>
        </li>
        <li id="filter-views" class="filter-views filter-views-<?php echo $class_multi; ?> clidxboost-icon-arrow-select <?php echo $response['view']; ?>" filtemid="<?php echo $class_multi; ?>">
          <select>
            <option value="grid" selected><?php echo __("Grid", IDXBOOST_DOMAIN_THEME_LANG); ?></option>
            <option value="list"><?php echo __("List", IDXBOOST_DOMAIN_THEME_LANG); ?></option>
            <option value="map"><?php echo __("Map", IDXBOOST_DOMAIN_THEME_LANG); ?></option>
          </select>
        </li>
      </ul>
      <span id="info-subfilters"><?php echo __("Showing", IDXBOOST_DOMAIN_THEME_LANG); ?> 0 <?php echo __("to", IDXBOOST_DOMAIN_THEME_LANG); ?> 0 <?php echo __("of", IDXBOOST_DOMAIN_THEME_LANG); ?> 0 <?php echo __("Properties", IDXBOOST_DOMAIN_THEME_LANG); ?>.<span></span></span>
    </div>
  </div>
  <section id="wrap-result" class="wrap-result wrap-result-<?php echo $class_multi; ?> view-grid" filtemid="<?php echo $class_multi; ?>">
    <h2 class="title"><?php echo __("Search results", IDXBOOST_DOMAIN_THEME_LANG); ?></h2>
    <div class="gwr">
      <div id="wrap-list-result">
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
        <ul id="result-search" class="slider-generator result-search-commercial" style="overflow-y:auto;">
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
    <div id="paginator-cnt" class="gwr">
      <nav id="nav-results" class="nav-results nav-results-<?php echo $class_multi; ?>" filtemid="<?php echo $class_multi; ?>">
      </nav>
    </div>
  </section>
</div>

<?php include FLEX_IDX_PATH . '/views/shortcode/idxboost_modals_filter.php';  ?>

<script type="text/javascript">
  var idxboost_force_registration=false;
<?php 
$registration_is_forced = (isset($flex_idx_info['agent']['force_registration']) && (true == $flex_idx_info['agent']['force_registration']) ) ? true : false;

if (
      ($registration_is_forced != false) || 
      (
         !empty($response) && 
         array_key_exists('force_registration', $response) &&  !empty($response['force_registration']) 
      )
   ) { ?>
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