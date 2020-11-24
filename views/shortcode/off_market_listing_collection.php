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

<form method="post" id="flex-idx-filter-form" class="flex-idx-filter-form-listing idxboost-filter-form" >
  <input type="hidden" name="action" value="idxboost_collection_off_market">
  <input type="hidden" name="market_order" class="market_order" id="idx_sort" value="<?php echo $atts['order']; ?>">
  <input type="hidden" name="market_tag" class="market_tag" id="idx_tag" value="<?php echo $atts['tag']; ?>">
  <input type="hidden" name="market_limit" class="market_limit" id="idx_limit" value="<?php echo $atts['limit']; ?>">  
  <input type="hidden" name="market_page" class="market_page" id="idx_page" value="1">
</form>
<?php
  global $post;
  $typeworked='';
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
          
          <li class="all ib-oadbanced">
            <button>
              <span class="clidxboost-icon-arrow-select">
                <span class="idx-text-pc"><?php echo __("More Filters", IDXBOOST_DOMAIN_THEME_LANG); ?></span>
                <span class="idx-text-mb"><?php echo __("Filters", IDXBOOST_DOMAIN_THEME_LANG); ?></span>
              </span>
            </button>
          </li>
        </ul>
      <?php } ?>
      </div>
    </div>
  </div>
  <div id="wrap-subfilters" style="margin-top:15px;">
    <div class="gwr">
      <ul id="sub-filters">
        <li id="filter-by" class="clidxboost-icon-arrow-select">
          <span class="filter-text"><?php echo __("Newest Listings", IDXBOOST_DOMAIN_THEME_LANG); ?></span>
          <select id="flex_idx_sort" class="flex_idx_sort flex_idx_sort-<?php echo $class_multi; ?>" data-permalink="<?php the_permalink(); ?>" data-currpage="<?php echo $response['pagination']['current_page_number']; ?>" filtemid="<?php echo $class_multi; ?>">
              <option value="year-desc"><?php echo __("Newest Listings", IDXBOOST_DOMAIN_THEME_LANG); ?></option>
              <option value="listing_price-desc"><?php echo __("Highest Price", IDXBOOST_DOMAIN_THEME_LANG); ?></option>
              <option value="listing_price-asc"><?php echo __("Lowest Price", IDXBOOST_DOMAIN_THEME_LANG); ?></option>
              <option value="living_area-desc"><?php echo __("Highest Sq.Ft", IDXBOOST_DOMAIN_THEME_LANG); ?></option>
              <option value="living_area-asc"><?php echo __("Lowest Sq.Ft", IDXBOOST_DOMAIN_THEME_LANG); ?></option>
          </select>
        </li>
        <li id="filter-views" class="filter-views filter-views-<?php echo $class_multi; ?> clidxboost-icon-arrow-select grid" filtemid="<?php echo $class_multi; ?>">
          <select>
            <option value="grid" selected="selected"><?php echo __("Grid", IDXBOOST_DOMAIN_THEME_LANG); ?></option>
            <option value="list"><?php echo __("List", IDXBOOST_DOMAIN_THEME_LANG); ?></option>
          </select>
        </li>
      </ul>
      <?php if ( (!is_numeric($atts['limit']) && $atts['limit'] =='default')) { ?>
      <?php
        if($idxboost_ver_bool==false){ ?>
          <span id="info-subfilters"></span>
      <?php }else{ ?>
      <!--<span id="info-subfilters"><?php echo __("Showing", IDXBOOST_DOMAIN_THEME_LANG); ?>  <?php echo __("to", IDXBOOST_DOMAIN_THEME_LANG); ?> <?php echo __("of", IDXBOOST_DOMAIN_THEME_LANG); ?>  <?php echo __("Properties", IDXBOOST_DOMAIN_THEME_LANG); ?>.<span></span></span>-->
      <?php } ?>
      <?php } ?>
    </div>
  </div>
  <section id="wrap-result" class="wrap-result wrap-result-idx_off_market_listing_collection view-grid" filtemid="idx_off_market_listing_collection">
    <h2 class="title"><?php echo __("Search results", IDXBOOST_DOMAIN_THEME_LANG); ?></h2>
    <div class="gwr">
      <div id="wrap-list-result" <?php if($idxboost_ver_bool==false){ ?> style="display: none;" <?php } ?> >
        <ul id="head-list">
          <li class="address"><?php echo __('Address', IDXBOOST_DOMAIN_THEME_LANG); ?></li>
          <li class="price"><?php echo __('Price', IDXBOOST_DOMAIN_THEME_LANG); ?></li>
          <!--<li class="pr">% / $</li>-->
          <li class="beds"><?php echo __('Beds', IDXBOOST_DOMAIN_THEME_LANG); ?></li>
          <li class="baths"><?php echo __('Baths', IDXBOOST_DOMAIN_THEME_LANG); ?></li>
          <li class="living-size"><?php echo __('Living Size', IDXBOOST_DOMAIN_THEME_LANG); ?></li>
          <li class="price-sf"><?php echo __('Price', IDXBOOST_DOMAIN_THEME_LANG); ?> / SF </li>
          <li class="development"><?php echo __('Development', IDXBOOST_DOMAIN_THEME_LANG); ?> / <?php echo __('Subdivision', IDXBOOST_DOMAIN_THEME_LANG); ?></li>
        </ul>
        <ul id="result-search" class="slider-generator idx-off-market-result-search" style="overflow-y:auto;">
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
  </section>
</div>

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

      <!--<button class="idx-btn-act" id="idx-bta-map">
        <span><?php echo __("Map", IDXBOOST_DOMAIN_THEME_LANG); ?></span>
      </button>-->
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
   
   <?php if(array_key_exists("hackbox", $response)){ ?>
    idxboost_hackbox_filter= <?php echo json_encode($response["hackbox"]); ?>;
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
</script>
