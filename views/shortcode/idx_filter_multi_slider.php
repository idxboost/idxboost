<?php
 $link_collection_slider_for_sale= $atts["sale_link"]; 
 $link_collection_slider_for_rent= $atts["rent_link"]; 
 ?>

<div class="ib-inventory-building cw-featured-properties">
  <div id="featured-section" class="flex-block-description">
    
    <?php  if ( !empty($atts['title']) ) { ?>
      <h3 class="ib-cw-title"><?php echo $atts['title']; ?></h3>
    <?php } ?>

    <?php  if ( !empty($atts['sub_title']) ) { ?>
      <h4 class="ib-cw-subtitle"><?php echo $atts['sub_title']; ?></h4>
    <?php } ?>

    <ul id="cw-tab-rs" class="cw-tab-list" <?php echo $text_button_style; ?> >

      <li><button data-id="cw-tab-sale" class="cw-active"><span><?php echo __("Available Sales", IDXBOOST_DOMAIN_THEME_LANG); ?></span></button></li>
      <li><button data-id="cw-tab-rent"><span><?php echo __("Available Rentals", IDXBOOST_DOMAIN_THEME_LANG); ?></span></button></li>

    </ul>
    <div class="wrap-result view-grid">
      <div id="cw-tab-sale" class="cw-tab-item">
        <div class="clidxboost-properties-slider gs-container-slider result-container-slider tab-slider" id="slider-sale">
        <?php foreach($response['items'] as $value){ ?>
          <ul class="result-search slider-generator">
            <li class="propertie" data-id="<?php echo $value['mls_num']; ?>" data-mls="<?php echo $value['mls_num']; ?>" data-counter="<?php echo $count_item; ?>">
              <h2 title="<?php echo $value['address_short']; ?> <?php echo $value['address_large']; ?>"><span><?php echo str_replace('# ', '#', $value['address_short']); ?></span></h2>
              <ul class="features">
                <li class="address"><?php echo $value['address_large']; ?></li>
                <li class="price">$<?php echo number_format($value['price']); ?></li>
                <li class="pr down">2.05%</li>
                <li class="beds"><?php echo $value['bed']; ?>  <span><?php echo __("Beds", IDXBOOST_DOMAIN_THEME_LANG); ?> </span></li>
                <li class="baths"><?php echo $value['bath']; ?> <span><?php echo __("Baths", IDXBOOST_DOMAIN_THEME_LANG); ?> </span></li>
                <li class="living-size"> <span><?php echo $value['living_size_m2']; ?></span><?php echo __("Sq.Ft.", IDXBOOST_DOMAIN_THEME_LANG); ?> <span>(452 m2)</span></li>
                <li class="price-sf"><span>$<?php echo $value['price_sqft_m2']; ?> </span>/ <?php echo __("Sq.Ft.", IDXBOOST_DOMAIN_THEME_LANG); ?><span>($244 m2)</span></li>
                <li class="build-year"><span><?php echo __("Built", IDXBOOST_DOMAIN_THEME_LANG); ?> </span>2015</li>
                <li class="development"><span>Star Island Corr</span></li>
              </ul>
              <div class="wrap-slider">
                <ul>
                  <?php foreach ($value['gallery'] as $kga => $vga) { ?>
                  <?php if ($kga === 0): ?>
                  <li class="flex-slider-current"><img class="flex-lazy-image" data-original="<?php echo $vga; ?>"></li>
                  <?php else: ?>
                  <li class="flex-slider-item-hidden"><img class="flex-lazy-image" data-original="<?php echo $vga; ?>"></li>
                  <?php endif; ?>
                  <?php } ?>
                </ul>
                <button class="prev flex-slider-prev"><span class="clidxboost-icon-arrow-select"></span></button>
                <button class="next flex-slider-next"><span class="clidxboost-icon-arrow-select"></span></button>
                <?php if ($value['is_favorite'] == 1): ?>
                <button class="clidxboost-btn-check"><span class="flex-favorite-btn clidxboost-icon-check clidxboost-icon-check-list active" data-alert-token="<?php echo $value['token_alert']; ?>"></span></button>
                <?php else: ?>
                <button class="clidxboost-btn-check"><span class="flex-favorite-btn clidxboost-icon-check clidxboost-icon-check-list"></span></button>
                <?php endif; ?>                                                  
              </div>
              <a class="ib-view-detailt" href="<?php echo rtrim($flex_idx_info["pages"]["flex_idx_property_detail"]["guid"], "/"); ?>/<?php echo $value['slug']; ?>" rel="nofollow"><?php echo __("View detail", IDXBOOST_DOMAIN_THEME_LANG); ?></a>
            </li>
          </ul>
          <?php } ?>
        </div>
        <a href="<?php echo $link_collection_slider_for_sale; ?>" title="View more listings" class="clidxboost-btn-link"> <span><?php echo __("View all listings", IDXBOOST_DOMAIN_THEME_LANG); ?></span></a>
      </div>
      <div id="cw-tab-rent" class="cw-tab-item cw-hidden-ov">
        <div class="clidxboost-properties-slider gs-container-slider tab-slider" id="slider-rent">
        <?php foreach($response_rentals['items'] as $value){ ?>
          <ul class="result-search slider-generator">
            <li class="propertie" data-id="<?php echo $value['mls_num']; ?>" data-mls="<?php echo $value['mls_num']; ?>" data-counter="<?php echo $count_item; ?>">
              <h2 title="<?php echo $value['address_short']; ?> <?php echo $value['address_large']; ?>"><span><?php echo str_replace('# ', '#', $value['address_short']); ?></span></h2>
              <ul class="features">
                <li class="address"><?php echo $value['address_large']; ?></li>
                <li class="price">$<?php echo number_format($value['price']); ?></li>
                <li class="pr down">2.05%</li>
                <li class="beds"><?php echo $value['bed']; ?>  <span><?php echo __("Beds", IDXBOOST_DOMAIN_THEME_LANG); ?> </span></li>
                <li class="baths"><?php echo $value['bath']; ?> <span><?php echo __("Baths", IDXBOOST_DOMAIN_THEME_LANG); ?> </span></li>
                <li class="living-size"> <span><?php echo $value['living_size_m2']; ?></span><?php echo __("Sq.Ft.", IDXBOOST_DOMAIN_THEME_LANG); ?> <span>(452 m2)</span></li>
                <li class="price-sf"><span>$<?php echo $value['price_sqft_m2']; ?> </span>/ <?php echo __("Sq.Ft.", IDXBOOST_DOMAIN_THEME_LANG); ?><span>($244 m2)</span></li>
                <li class="build-year"><span><?php echo __("Built", IDXBOOST_DOMAIN_THEME_LANG); ?> </span>2015</li>
                <li class="development"><span>Star Island Corr</span></li>
              </ul>
              <div class="wrap-slider">
                <ul>
                  <?php foreach ($value['gallery'] as $kga => $vga) { ?>
                  <?php if ($kga === 0): ?>
                  <li class="flex-slider-current"><img class="flex-lazy-image" data-original="<?php echo $vga; ?>"></li>
                  <?php else: ?>
                  <li class="flex-slider-item-hidden"><img class="flex-lazy-image" data-original="<?php echo $vga; ?>"></li>
                  <?php endif; ?>
                  <?php } ?>
                </ul>
                <button class="prev flex-slider-prev"><span class="clidxboost-icon-arrow-select"></span></button>
                <button class="next flex-slider-next"><span class="clidxboost-icon-arrow-select"></span></button>
                <?php if ($value['is_favorite'] == 1): ?>
                <button class="clidxboost-btn-check"><span class="flex-favorite-btn clidxboost-icon-check clidxboost-icon-check-list active" data-alert-token="<?php echo $value['token_alert']; ?>"></span></button>
                <?php else: ?>
                <button class="clidxboost-btn-check"><span class="flex-favorite-btn clidxboost-icon-check clidxboost-icon-check-list"></span></button>
                <?php endif; ?>                                                  
              </div>
              <a class="ib-view-detailt" href="<?php echo rtrim($flex_idx_info["pages"]["flex_idx_property_detail"]["guid"], "/"); ?>/<?php echo $value['slug']; ?>" rel="nofollow"><?php echo __("View detail", IDXBOOST_DOMAIN_THEME_LANG); ?></a>
            </li>
          </ul>
          <?php } ?>
        </div>
        <a href="<?php echo $link_collection_slider_for_rent;?>" title="View more listings" class="clidxboost-btn-link"> <span>View all listings</span></a>
      </div>

    </div>
  </div>
</div>

<?php include FLEX_IDX_PATH . '/views/shortcode/idxboost_modals_filter.php';  ?>


<script type="text/javascript">
  (function($) {
      var $tabRentSale = jQuery("#cw-tab-rs");
      if ($tabRentSale.length) {
        jQuery(document).on('click', '#cw-tab-rs button', function() {
          $tabRentSale.find('button').removeClass('cw-active');
          jQuery(this).addClass('cw-active');
          /*Obtenemos los valores a mostrar*/
          var $showTab = jQuery(this).attr('data-id');
          jQuery(".cw-featured-properties .cw-tab-item").addClass('cw-hidden cw-hidden-ov');
          jQuery("#"+$showTab).removeClass('cw-hidden cw-hidden-ov');
          myLazyLoad.update();
        });
      };
    
  })(jQuery);
</script>
<script type="text/javascript">
  var view_grid_type='';
  var idxboost_hackbox_filter=[];
   
  jQuery('body').addClass('buildingPage');
  <?php
    $sta_view_grid_type='0'; if(array_key_exists('view_grid_type',$search_params)) $sta_view_grid_type=$search_params['view_grid_type']; ?>
  view_grid_type=<?php echo $sta_view_grid_type; ?>;
  if ( !jQuery('body').hasClass('clidxboost-ngrid') && view_grid_type==1) {
    jQuery('body').addClass('clidxboost-ngrid');
  }

</script>