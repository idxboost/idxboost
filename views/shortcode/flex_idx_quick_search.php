<div class="clidxboost-idxboost-quick-search-tm">
   <div class="idxboost-quick-search-ct">
  <form method="post" class="idxboost-quick-search-form">
    <input type="hidden" name="action" value="flex_search">
    <?php /*<input type="hidden" name="idx[tab]" id="idx_q_property_type" value="<?php if(count($flex_idx_info["search"]["property_types"])): ?>2|1<?php else: ?><?php echo $flex_idx_info["search"]["property_types"][0]["value"]; ?><?php endif; ?>"> <!-- 2|1 2 1 -->*/ ?>
    <input type="hidden" name="idx[tab]" id="idx_q_property_type" value="2"> <!-- 2|1 2 1 -->
    <input type="hidden" name="idx[rental]" id="idx_q_rental" value="<?php echo $flex_idx_info["search"]["rental_types"]; ?>">
    <input type="hidden" name="idx[keyword]" id="idx_q_keyword" value="">
    <input type="hidden" name="idx[polygon]" id="idx_q_polygon" value="">
    <input type="hidden" name="idx[min_price_sale]" id="idx_q_min_price_sale" value="0">
    <input type="hidden" name="idx[max_price_sale]" id="idx_q_max_price_sale" value="100000000">
    <input type="hidden" name="idx[min_price_rent]" id="idx_q_min_price_rent" value="0">
    <input type="hidden" name="idx[max_price_rent]" id="idx_q_max_price_rent" value="100000">
    <input type="hidden" name="idx[min_beds]" id="idx_q_min_beds" value="--">
    <input type="hidden" name="idx[max_beds]" id="idx_q_max_beds" value="--">
    <input type="hidden" name="idx[min_baths]" id="idx_q_min_baths" value="--">
    <input type="hidden" name="idx[max_baths]" id="idx_q_max_baths" value="--">
    <input type="hidden" name="idx[min_year]" id="idx_q_min_year" value="--">
    <input type="hidden" name="idx[max_year]" id="idx_q_max_year" value="--">
    <input type="hidden" name="idx[living_area_min]" id="idx_q_living_area_min" value="0">
    <input type="hidden" name="idx[living_area_max]" id="idx_q_living_area_max" value="80000">
    <input type="hidden" name="idx[lot_size_min]" id="idx_q_lot_size_min" value="0">
    <input type="hidden" name="idx[lot_size_max]" id="idx_q_lot_size_max" value="80000">
    <input type="hidden" name="idx[water_desc]" id="idx_q_water_desc" value="--">
    <input type="hidden" name="idx[parking]" id="idx_q_parking" value="--">
    <input type="hidden" name="idx[features]" id="idx_q_features" value="">
    <input type="hidden" name="idx[view]" id="idx_q_view" value="<?php echo $flex_idx_info["search"]["default_view"]; ?>">
    <input type="hidden" name="idx[sort]" id="idx_q_sort" value="<?php echo $flex_idx_info["search"]["default_sort"]; ?>">
    <input type="hidden" name="idx[page]" id="idx_q_page" value="1">

    <div class="idxboost-form-block clidxboost-item-forsale">
      <select class="idxboost-qsearch-rental">
        <option value="0" selected><?php echo __("For sale", IDXBOOST_DOMAIN_THEME_LANG); ?></option>
        <option value="1"><?php echo __("For rent", IDXBOOST_DOMAIN_THEME_LANG); ?></option>
      </select>
    </div>
    <div class="idxboost-form-block clidxboost-item-autocomplete">
      <input type="text" id="idxboost_quick_search_input" value="" placeholder="Search by address, zip code, neighborhood">
    </div>
    <div class="idxboost-form-block clidxboost-item-anyprice idxboost-slider-price-range idxboost-slider-price-sale-range">
      <button type="button"><span class="idxboost-slider-price-sale-label"><?php echo __("Any Price", IDXBOOST_DOMAIN_THEME_LANG); ?></button>
      <div class="idxboost-slider-prices-range">
        <div class="clidxboost-item-bubble">
          <div class="idxboost-qs-price-sale-slider"></div>
        </div>
      </div>
    </div>
    <div class="idxboost-form-block clidxboost-item-anyprice idxboost-slider-price-range idxboost-slider-price-rent-range" style="display:none;">
      <button type="button"><span class="idxboost-slider-price-rent-label"><?php echo __("Any Price", IDXBOOST_DOMAIN_THEME_LANG); ?></button>
      <div class="idxboost-slider-prices-range">
        <div class="clidxboost-item-bubble">
          <div class="idxboost-qs-price-rent-slider"></div>
        </div>
      </div>
    </div>
    <div class="idxboost-form-block clidxboost-item-beds">
      <button type="button"><span class="idxboost-slider-beds-label"><?php echo __("Any Bed", IDXBOOST_DOMAIN_THEME_LANG); ?></button>
      <div class="idxboost-slider-beds-range">
        <div class="clidxboost-item-bubble">
          <div class="idxboost-qs-beds-slider"></div>
        </div>
      </div>
    </div>
    <div class="idxboost-form-block clidxboost-item-baths">
      <button type="button"><span class="idxboost-slider-baths-label"><?php echo __("Any Bath", IDXBOOST_DOMAIN_THEME_LANG); ?></button>
      <div class="idxboost-slider-baths-range">
        <div class="clidxboost-item-bubble">
          <div class="idxboost-qs-baths-slider"></div>
        </div>
      </div>
    </div>
    <div class="idxboost-form-block clidxboost-item-type">
      <select class="idxboost-qsearch-ptype">
        <option value="2|1" selected><?php echo __("Property Type", IDXBOOST_DOMAIN_THEME_LANG); ?></option>
        <option value="2"><?php echo __("Single Family Homes", IDXBOOST_DOMAIN_THEME_LANG); ?></option>
        <option value="1"><?php echo __("Condominiums", IDXBOOST_DOMAIN_THEME_LANG); ?></option>
      </select>
    </div>
    <div class="idxboost-form-block clidxboost-item-search">
      <button type="submit"><span><?php echo __("Search", IDXBOOST_DOMAIN_THEME_LANG); ?></span></button>
    </div>
  </form>
  <div class="idxboost-form-extra clidxboost-item-adsearch">
    <p><a href="<?php echo $flex_idx_info["pages"]["flex_idx_search"]["guid"]; ?>" title="Go to Advanced Search">+ <?php echo __("Advanced Search Options", IDXBOOST_DOMAIN_THEME_LANG); ?></a></p>
  </div>
</div>
</div>
