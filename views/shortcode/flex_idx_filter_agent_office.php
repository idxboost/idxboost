<style>
  .wrap-result.view-grid #result-search > li .features.ms-padding{padding-bottom: 56px !important}
</style>

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
/*
  if ($atts['method']==0)
    $filterid=get_the_ID();
*/
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
    $filter_type_fl="";
  }
  $viewfilter='';
  if (empty($response['view']))  $viewfilter='grid'; else $viewfilter=$response['view'];
  ?>

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
