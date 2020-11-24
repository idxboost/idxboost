<!-- Show only on mobile devices -->
<div class="ib-quick-search-mini">
  <a class="ib-btn-sm" href="<?php echo $flex_idx_info["pages"]["flex_idx_search"]["guid"]; ?>#more-options" title="Sale"><?php echo __('sale', IDXBOOST_DOMAIN_THEME_LANG); ?></a>
  <a class="ib-btn-sm" href="<?php echo $flex_idx_info["pages"]["flex_idx_search"]["guid"]; ?>?for=rent#more-options" title="Rent"><?php echo __('rent', IDXBOOST_DOMAIN_THEME_LANG); ?></a>
</div>
<!-- Show only on desktop devices -->
<div class="ib-quick-search-form">
  <form method="post" id="__ib_quick_search_form">
    <input type="hidden" id="ib-quick-search-sale-values" value="">
    <input type="hidden" id="ib-quick-search-rent-values" value="">
    <input type="hidden" id="ib-quick-search-type-values" value="">

    <div class="ib-quick-search-nav">
      <div class="ib-quick-search-nav-item">
        <div class="ib-arrow">
          <select id="ib-quick-search-rental-type" class="ib-quick-item">
            <option value="0" <?php selected($flex_idx_info["search"]["rental_types"], 0); ?>><?php echo __('For Sale', IDXBOOST_DOMAIN_THEME_LANG); ?></option>
            <option value="1" <?php selected($flex_idx_info["search"]["rental_types"], 1); ?>><?php echo __('For Rent ', IDXBOOST_DOMAIN_THEME_LANG); ?></option>
          </select>
        </div>
      </div>
      <div class="ib-quick-search-nav-item">
        <div class="ib-arrow">
          <select id="ib-quick-search-city" class="ib-quick-item">
            <option value="--" selected><?php echo __('Select a City', IDXBOOST_DOMAIN_THEME_LANG); ?></option>
            <?php foreach($flex_idx_info["search"]["cities"] as $city): ?>
            <option value="<?php echo $city["name"]; ?>"><?php echo $city["name"]; ?></option>
            <?php endforeach; ?>
          </select>
        </div>
      </div>
      <div class="ib-quick-search-nav-item">
        <div class="ib-arrow">
          <a href="javascript:void(0)" class="ib-quick-item" id="ib-quick-search-price-range-lbl"><?php echo __('Any Price', IDXBOOST_DOMAIN_THEME_LANG); ?></a>
        </div>
        <div class="ib-sub-item">
          <div class="ib-ui-ranger">
            <div id="ib-quick-search-price-range-sale"></div>
            <div id="ib-quick-search-price-range-rent" style="display: none;"></div>
          </div>
        </div>
      </div>

      <div class="ib-quick-search-nav-item">
        <div>
          <div class="ib-arrow">
            <a href="javascript:void(0)" class="ib-quick-item"><?php echo __('Type', IDXBOOST_DOMAIN_THEME_LANG); ?></a>
          </div>
          <div class="ib-sub-item">
            <div class="ib-group">
              <?php foreach($flex_idx_info["search"]["property_types"] as $property_type): 
                
                if ($property_type['label']=='Single Family Homes') {
                  $text_label_trans=__("Single Family Homes", IDXBOOST_DOMAIN_THEME_LANG);

                }else if ($property_type['label']=='Condominiums'){
                  $text_label_trans=__("Condominiums", IDXBOOST_DOMAIN_THEME_LANG);

                }else if ($property_type['label']=='Townhouses'){
                  $text_label_trans=__("Townhouses", IDXBOOST_DOMAIN_THEME_LANG);

                }else if ($property_type['label']=='Multi-Family'){
                  $text_label_trans=__("Multi-Family", IDXBOOST_DOMAIN_THEME_LANG);

                }else if ($property_type['label']=='Vacant Land'){
                  $text_label_trans=__("Vacant Land", IDXBOOST_DOMAIN_THEME_LANG);
                }else{
                  $text_label_trans=$property_type['label'];
                }

              ?>
              <label class="ib-chk">
                  <input type="checkbox" class="ib-quick-search-types" value="<?php echo $property_type["value"]; ?>">
                  <span><?php echo $text_label_trans; ?></span>
              </label>
              <?php endforeach; ?>
            </div>
          </div>
        </div>
      </div>

      <div class="ib-quick-search-nav-item">
        <button type="submit" class="ib-quick-btn"><span><?php echo __('View Properties', IDXBOOST_DOMAIN_THEME_LANG); ?></span></button>
      </div>
    </div>
  </form>
</div>
<input type="hidden" class="idx_txt_min_slider" value="<?php echo __('Min.', IDXBOOST_DOMAIN_THEME_LANG); ?>">
<input type="hidden" class="idx_txt_max_slider" value="<?php echo __('Max.', IDXBOOST_DOMAIN_THEME_LANG); ?>">
<?php
  /*
  <pre>
  <?php print_r($flex_idx_info); ?>
</pre>
*/
?>