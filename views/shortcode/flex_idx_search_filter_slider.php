<script>
  var IS_SEARCH_FILTER_CARROUSEL = true;
</script>

<?php if ('slider' != $atts['mode']) { ?>
  <style>
    #footer {
      display: none !important;
    }
  </style>
<?php } ?>

<?php
$idx_contact_phone = isset($flex_idx_info['agent']['agent_contact_phone_number']) ? sanitize_text_field($flex_idx_info['agent']['agent_contact_phone_number']) : '';

$c_search_settings = get_option("idxboost_search_settings");

$label_waterfront_description = __('Waterfront Description', IDXBOOST_DOMAIN_THEME_LANG);
if (isset($c_search_settings["board_id"]) && ("11" == $c_search_settings["board_id"])) {
  $label_waterfront_description = __("View Description", IDXBOOST_DOMAIN_THEME_LANG);
} elseif (isset($c_search_settings["board_id"]) && ("16" == $c_search_settings["board_id"])) {
  $label_waterfront_description = __("View Features", IDXBOOST_DOMAIN_THEME_LANG);
}

?>
<!-- NOT CLEAN-->
<form id="flex_idx_search_filter_form" method="post">
  <?php if (isset($atts["agent_id"]) && !empty($atts["agent_id"])) : ?>
    <input type="hidden" name="agent_id" value="<?php echo trim(strip_tags($atts["agent_id"])); ?>">
  <?php endif; ?>
  <?php if (isset($atts["office_id"]) && !empty($atts["office_id"])) : ?>
    <input type="hidden" name="office_id" value="<?php echo trim(strip_tags($atts["office_id"])); ?>">
  <?php endif; ?>
  <input type="hidden" name="sale_type" value="">
  <input type="hidden" name="property_type" value="">
  <input type="hidden" name="filter_search_keyword_label" value="">
  <input type="hidden" name="filter_search_keyword_type" value="">
  <input type="hidden" name="waterfront_options" value="">

  <input type="hidden" name="polygon_search" value="">
  <input type="hidden" name="rect" value="<?php echo isset($_GET["rect"]) ? sanitize_text_field($_GET["rect"]) : ''; ?>">
  <input type="hidden" name="zm" value="<?php echo isset($_GET["zm"]) ? sanitize_text_field($_GET["zm"]) : ''; ?>">

  <input type="hidden" name="parking_options" value="">
  <input type="hidden" name="amenities" value="">

  <?php if (isset($atts["oh"]) && (1 == $atts["oh"])) : ?>
    <input type="hidden" name="oh" value="1">
  <?php endif; ?>

  <input type="hidden" name="min_sale_price" value="">
  <input type="hidden" name="max_sale_price" value="">

  <input type="hidden" name="min_rent_price" value="">
  <input type="hidden" name="max_rent_price" value="">

  <input type="hidden" name="min_beds" value="">
  <input type="hidden" name="max_beds" value="">

  <input type="hidden" name="min_baths" value="">
  <input type="hidden" name="max_baths" value="">

  <input type="hidden" name="min_living_size" value="">
  <input type="hidden" name="max_living_size" value="">

  <input type="hidden" name="min_lot_size" value="">
  <input type="hidden" name="max_lot_size" value="">

  <input type="hidden" name="min_year" value="">
  <input type="hidden" name="max_year" value="">

  <input type="hidden" name="sort_type" value="">
  <input type="hidden" name="page" value="">
</form>
<!-- NOT CLEAN-->


<div id="flex_idx_search_filter" data-filter-id="<?php echo $atts['id']; ?>" class="ib-mapgrid-container ib-vgrid-active" style="display:none !important;">
  <div class="content-rsp-btn">
    <div class="idx-btn-content">
      <div class="idx-bg-group">
        <button data-modal="modal_save_search" class="idx-btn-act save-button-responsive" aria-label="<?php echo __("Save", IDXBOOST_DOMAIN_THEME_LANG); ?>">
          <span><?php echo __("Save", IDXBOOST_DOMAIN_THEME_LANG); ?></span>
        </button>

        <button class="idx-btn-act idx-bta-grid" aria-label="<?php echo __('Grid', IDXBOOST_DOMAIN_THEME_LANG); ?>">
          <span><?php echo __('Grid', IDXBOOST_DOMAIN_THEME_LANG); ?></span>
        </button>

        <button class="idx-btn-act idx-bta-map" aria-label="<?php echo __('Map', IDXBOOST_DOMAIN_THEME_LANG); ?>">
          <span><?php echo __('Map', IDXBOOST_DOMAIN_THEME_LANG); ?></span>
        </button>

        <!-- <button class="idx-btn-act ib-show ib-removeb-tg ib-removeb-hide" aria-label="<?php echo __('Remove', IDXBOOST_DOMAIN_THEME_LANG); ?>">
					<span><?php echo __('Remove', IDXBOOST_DOMAIN_THEME_LANG); ?> <br> <?php echo __('Boundaries', IDXBOOST_DOMAIN_THEME_LANG); ?></span>
				</button> -->
        <button class="idx-btn-act ib-show ib-removeb-tg ib-removeb-hide" aria-label="<?php echo __("Search this area", IDXBOOST_DOMAIN_THEME_LANG); ?>"><span><?php echo __("Search this area", IDXBOOST_DOMAIN_THEME_LANG); ?></span></button>
      </div>
    </div>
  </div>
  <div class="ib-wmap">
    <div id="wrap-map-draw-actions" style="display:none;">
      <div>
        <p><?php echo __('Draw a shape around the region(s) you would like to live in', IDXBOOST_DOMAIN_THEME_LANG); ?></p>
      </div>
      <div class="flex-content-btn-draw">
        <button type="button" id="map-draw-cancel-tg"><?php echo __('Cancel', IDXBOOST_DOMAIN_THEME_LANG); ?></button>
        <button type="button" id="map-draw-apply-tg"><?php echo __('Apply', IDXBOOST_DOMAIN_THEME_LANG); ?></button>
      </div>
    </div>
    <div id="flex_idx_search_filter_map"></div>
  </div>
  <div class="ib-wgrid">
    <div class="ib-gheader">
      <div class="ib-ghpa">
        <span class="ib-ghtypes ib-heading-ct">...</span>
        <div class="ib-gmfilters">
          <div class="ib-gwsort">
            <label class="ms-hidden" for="ib-gsort-b"><?php echo __('Select option', IDXBOOST_DOMAIN_THEME_LANG); ?></label>
            <select class="ib-gsort ib-sort-ctrl" id="ib-gsort-b">
              <option value="list_date-desc"><?php echo __('Newest Listings', IDXBOOST_DOMAIN_THEME_LANG); ?></option>
              <option value="last_updated-desc"><?php echo __('Modified Listings', IDXBOOST_DOMAIN_THEME_LANG); ?></option>
              <option value="price-desc"><?php echo __('Highest Price', IDXBOOST_DOMAIN_THEME_LANG); ?></option>
              <option value="price-asc"><?php echo __('Lowest Price', IDXBOOST_DOMAIN_THEME_LANG); ?></option>
              <option value="sqft-desc"><?php echo __('Highest Sq.Ft', IDXBOOST_DOMAIN_THEME_LANG); ?></option>
              <option value="sqft-asc"><?php echo __('Lowest Sq.Ft', IDXBOOST_DOMAIN_THEME_LANG); ?></option>
            </select>
          </div>
        </div>
      </div>
    </div>

    <div class="ib-gnopro">
      <span class="ib-gnpno"><?php echo __('No matching results...', IDXBOOST_DOMAIN_THEME_LANG); ?></span>
      <span class="ib-rembounds" style="color:blue;font-weight:600;cursor:pointer;">Search this area</span> <?php echo __('or modify your', IDXBOOST_DOMAIN_THEME_LANG); ?> <span class="ib-gnpoall"><?php echo __('filter', IDXBOOST_DOMAIN_THEME_LANG); ?></span> <?php echo __('preferences to get new results or', IDXBOOST_DOMAIN_THEME_LANG); ?> <span class="ib-gnpclear"><?php echo __('clear', IDXBOOST_DOMAIN_THEME_LANG); ?></span> <?php echo __('your search.', IDXBOOST_DOMAIN_THEME_LANG); ?>
    </div>

    <div class="ib-cproperties">
      <div class="ib-wproperties">
        <ul class="ib-lproperties ib-listings-ct"></ul>
      </div>
      <div class="ib-cpagination">
        <nav class="ib-wpagination ib-pagination-ctrl"></nav>
      </div>
    </div>

    <?php if (in_array($flex_idx_info["board_id"], ["13", "14", "20"])) { ?>
      <div class="ib-bdisclaimer">
        <?php
        if (
            is_array($flex_idx_info) &&
            array_key_exists("board_info", $flex_idx_info) &&
            array_key_exists("board_logo_url", $flex_idx_info["board_info"]) &&
            !empty($flex_idx_info["board_info"]["board_logo_url"]) && $flex_idx_info["board_info"]["board_logo_url"] != ""
        ) {
          ?>
          <div class="ms-logo-board">
            <img src="<?php echo $flex_idx_info["board_info"]["board_logo_url"]; ?>">
          </div>
        <?php } ?>
        <?php
        if (isset($flex_idx_info["board_id"]) && ("7" == $flex_idx_info["board_id"])) { ?>
          <p><?php echo __("The multiple listing information is provided by the Houston Association of Realtors from a copyrighted compilation of listings. The compilation of listings and each individual listing are", IDXBOOST_DOMAIN_THEME_LANG); ?> &copy;<?php echo date('Y'); ?>-<?php echo __("present TEXAS All Rights Reserved. The information provided is for consumers' personal, noncommercial use and may not be used for any purpose other than to identify prospective properties consumers may be interested in purchasing. All properties are subject to prior sale or withdrawal. All information provided is deemed reliable but is not guaranteed accurate, and should be independently verified. Listing courtesy of", IDXBOOST_DOMAIN_THEME_LANG); ?>: <span class="ib-bdcourtesy">{{office_name}}</span> <a class="ib-phone-office" href="tel:{{phone_office}}">Ph.{{phone_office}}</a></p>
        <?php } else {
          if (
              is_array($flex_idx_info) &&
              array_key_exists("board_info", $flex_idx_info) &&
              array_key_exists("board_disclaimer", $flex_idx_info["board_info"]) &&
              !empty($flex_idx_info["board_info"]["board_disclaimer"])
          ) {
            ?>
            <p>
              <?php
              $disclaimer = str_replace('{officeName}', $property["office_name"], $property['board_info']["board_disclaimer"]);
              $disclaimer = str_replace('{office_phone}', '<a href="tel:'.$property["phone_office"].'">'.$property["phone_office"].'</a>', $disclaimer);
              echo $disclaimer;
              ?>
            </p>
          <?php } ?>
        <?php } ?>
        <p><?php echo __('Real Estate IDX Powered by', IDXBOOST_DOMAIN_THEME_LANG); ?>: <a href="https://www.tremgroup.com" title="TREMGROUP" rel="nofollow" target="_blank">TREMGROUP</a></p>
      </div>
    <?php } ?>

  </div>
</div>

<!-- NOT CLEAN-->
<!-- modal property html -->
<div id="flex_idx_modal_wrapper"></div>
<!-- NOT CLEAN-->

<!-- NOT CLEAN-->
<div class="ib-modal-master" data-id="save-search" id="ib-fsearch-save-modal">
  <div class="ib-mmcontent">
    <div class="ib-mwrapper ib-mgeneric">
      <div class="ib-mgheader">
        <h4 class="ib-mghtitle"><?php echo __('Save search', IDXBOOST_DOMAIN_THEME_LANG); ?></h4>
        <p id="msSmartAlertText" data-text-alert="<?php echo __('Save your preferred areas for future reference', IDXBOOST_DOMAIN_THEME_LANG); ?>" data-text-default="<?php echo __('You will receive automatic updates every time there are new listings and price reductions', IDXBOOST_DOMAIN_THEME_LANG); ?>">
        </p>
      </div>
      <div class="ib-mgcontent">
        <form method="post" class="flex-save-search-modals">
          <ul class="ib-msavesearch">
            <li class="ib-mssitem"><span class="ib-mssitxt"><?php echo __('Name your search', IDXBOOST_DOMAIN_THEME_LANG); ?>*</span>
              <div class="ib-mgiwrapper">
                <label class="ms-hidden" for="ib-name-search-a"><?php echo __('Name your search', IDXBOOST_DOMAIN_THEME_LANG); ?></label>
                <input class="ib-mssinput ib-name_search" name="search_name" type="text" placeholder="<?php echo __('Name your search', IDXBOOST_DOMAIN_THEME_LANG); ?>" id="ib-name-search-a">
              </div>
            </li>
            <li class="ib-mssitem"><span class="ib-mssitxt"><?php echo __('Email Updates', IDXBOOST_DOMAIN_THEME_LANG); ?></span>
              <div class="ib-mgiwrapper ib-mgwselect">
                <label class="ms-hidden" for="ib-mgwselect-a"><?php echo __('Email Updates', IDXBOOST_DOMAIN_THEME_LANG); ?></label>
                <select class="ib-mssselect" name="notification_day" id="ib-mgwselect-a">
                  <option value="--"><?php echo __('No Alert', IDXBOOST_DOMAIN_THEME_LANG); ?></option>
                  <option value="1" selected=""><?php echo __('Daily', IDXBOOST_DOMAIN_THEME_LANG); ?></option>
                  <option value="7"><?php echo __('Weekly', IDXBOOST_DOMAIN_THEME_LANG); ?></option>
                  <option value="30"><?php echo __('Monthly', IDXBOOST_DOMAIN_THEME_LANG); ?></option>
                </select>
              </div>
            </li>
            <li class="ib-mssitem"><span class="ib-mssitxt"><?php echo __('Only Update me On', IDXBOOST_DOMAIN_THEME_LANG); ?></span>
              <ul class="ib-mssupdate">
                <li class="ib-mssuitem">
                  <input class="ib-msscheckbox" type="checkbox" id="ib-check-new-listing" name="notification_type[]" value="new_listing" checked>
                  <label class="ib-msslabel" for="ib-check-new-listing"><?php echo __('New Listing (Always)', IDXBOOST_DOMAIN_THEME_LANG); ?></label>
                </li>
                <li class="ib-mssuitem">
                  <input class="ib-msscheckbox" type="checkbox" id="ib-check-price-change" name="notification_type[]" value="price_change" checked>
                  <label class="ib-msslabel" for="ib-check-price-change"><?php echo __('Price Change', IDXBOOST_DOMAIN_THEME_LANG); ?></label>
                </li>
                <li class="ib-mssuitem">
                  <input class="ib-msscheckbox" type="checkbox" id="ib-check-status-change" name="notification_type[]" value="status_change" checked>
                  <label class="ib-msslabel" for="ib-check-status-change"><?php echo __('Status Change', IDXBOOST_DOMAIN_THEME_LANG); ?></label>
                </li>
              </ul>
            </li>
          </ul>
          <button class="ib-mgsubmit"><?php echo __('Save Search', IDXBOOST_DOMAIN_THEME_LANG); ?></button>
          <input type="hidden" name="action" value="idxboost_new_filter_save_search_xhr_fn">
        </form>
      </div>
    </div>
    <div class="ib-mmclose" role="button" aria-label="<?php echo __('Close', IDXBOOST_DOMAIN_THEME_LANG); ?>"><span class="ib-mmctxt"><?php echo __('Close', IDXBOOST_DOMAIN_THEME_LANG); ?></span></div>
  </div>
  <div class="ib-mmbg"></div>
</div>
<!-- NOT CLEAN-->
<!-- SLIDER MAP SEARCH FILTER & DISPLAY FILTER -->
<section data-limit="<?php echo $atts["limit"]; ?>" data-gallery="<?php echo $atts['gallery']; ?>" data-item="<?php echo $atts['slider_item']; ?>" class="flex-block-description mtop-60 ib-filter-slider ib-filter-slider-2 featured-section js-slider-filter-search" data-filter="2" id="featured-section">
  <?php if (!empty($atts['title'])) { ?>
    <h2 class="title-block single idx_txt_text_tit_property_front"><?php echo $atts['title']; ?></h2>
  <?php } ?>
  <div class="wrap-result view-grid">
    <!-- wrapper for slider (search filter && display filter) -->
    <div class="gs-container-slider ib-properties-slider" id="search-filter-slider-<?php echo $atts['id']; ?>"></div>
  </div>
  <?php /*
	<?php  if (!empty($atts['link'])) { ?>
	<a class="clidxboost-btn-link idx_txt_text_property_front" href="<?php echo $atts['link']; ?>" title="<?php echo $atts['name_button']; ?>"> <span><?php echo $atts['name_button']; ?></span></a>
    <?php } ?>
    */ ?>
  <?php /*
<input type="hidden" class="ib_type_filter" value="<?php echo $atts['type']; ?>">
<input type="hidden" class="ib_id_filter" value="<?php echo $atts['id']; ?>"> */ ?>
</section>
<!-- SLIDER MAP SEARCH FILTER & DISPLAY FILTER -->