<?php if (isset($atts["mode"]) && ("grid" === $atts["carrousel"])): ?>

<script type="text/javascript">
var NO_REFRESH_F_AJAX = true;
</script>
<?php endif; ?>
<div class="wrap-result view-grid">
  <div class="wrap-list-result multi-items slider-standar" id="slider-properties">
    <ul class="result-search idx_color_primary slider-generator built interval" id="result-search">
    <?php foreach($response['items'] as $property): ?>
    <li data-mls="<?php echo $property['mls_num']; ?>" class="propertie" data-geocode="<?php echo $property['lat']; ?>:<?php echo $property['lng']; ?>" data-class-id="<?php echo $property['class_id']; ?>">
        <h2 title="<?php echo $property['address_short']; ?> <?php echo $property['address_large']; ?>"><span><?php echo $property['address_short'].' <span>'.$property['address_large']; ?></span></span></h2>
        <ul class="features">
            <li class="address"><?php echo $property['address_large']; ?></li>
            <li class="price"><a href="<?php echo rtrim($flex_idx_info["pages"]["flex_idx_property_detail"]["guid"], "/"); ?>/<?php echo $property['slug']; ?>">$<?php echo number_format($property['price']); ?></a></li>
            <?php if ($property['reduced'] == ''): ?>
                <li class="pr"><?php echo $property['reduced']; ?></li>
            <?php elseif($property['reduced'] < 0): ?>
                <li class="pr down"><?php echo $property['reduced']; ?>%</li>
            <?php else: ?>
                <li class="pr up"><?php echo $property['reduced']; ?>%</li>
            <?php endif; ?>
            <li class="beds"><?php echo $property['bed']; ?> <span>
              <?php if ($property['bed']>1) {
                echo "Beds";
              }else {
                echo "Bed";
              }?></span></li>
            <li class="baths"><?php echo $property['bath']; ?> <span>
              <?php
              if ($property['bath']>1) {
                echo "Bath";
              }else{
                echo "Baths";
              }
              ?></span></li>
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
        <?php
        $totgallery='';
        if ( count($property['gallery'])<=1 ) $totgallery='no-zoom'; ?>
        <div class="wrap-slider <?php echo $totgallery; ?>">
            <ul>
                <?php foreach($property['gallery'] as $key =>  $property_photo): ?>
                <?php if ($key === 0): ?>
                <li class="flex-slider-current">
                <a href="<?php echo rtrim($flex_idx_info["pages"]["flex_idx_property_detail"]["guid"], "/"); ?>/<?php echo $property['slug']; ?>">
                <img class="flex-lazy-image" data-original="<?php echo $property_photo; ?>" title="<?php echo $property['address_short']; ?> <?php echo $property['address_large']; ?>" alt="<?php echo $property['address_short']; ?> <?php echo $property['address_large']; ?>">
                </a>
                </li>
              <?php else: ?>
                <li class="flex-slider-item-hidden">
                <a href="<?php echo rtrim($flex_idx_info["pages"]["flex_idx_property_detail"]["guid"], "/"); ?>/<?php echo $property['slug']; ?>">
                <img class="flex-lazy-image" data-original="<?php echo $property_photo; ?>" title="<?php echo $property['address_short']; ?> <?php echo $property['address_large']; ?>" alt="<?php echo $property['address_short']; ?> <?php echo $property['address_large']; ?>">
                </a>
                </li>
                <?php endif; ?>
                <?php endforeach; ?>
            </ul>
            <?php if ( count($property['gallery'])>1 ) { ?>
            <button class="prev flex-slider-prev" aria-label="Prev"><span class="clidxboost-icon-arrow-select"></span></button>
            <button class="next flex-slider-next" aria-label="Next"><span class="clidxboost-icon-arrow-select"></span></button>
            <?php } ?>
        
          <?php if ($property['is_favorite'] == true): ?>
            <button aria-label="Remove Favorite" class="clidxboost-btn-check flex-favorite-btn" data-alert-token="<?php echo $property['token_alert']; ?>">
              <span class="clidxboost-icon-check active"></span>
            </button>
          <?php else: ?>
            <button aria-label="Save Favorite" class="clidxboost-btn-check flex-favorite-btn" data-alert-token="<?php echo isset($property['token_alert']) ? $property['token_alert'] : ''; ?>">
              <span class="clidxboost-icon-check"></span>
            </button>
          <?php endif; ?>

        </div>

        <a href="<?php echo rtrim($flex_idx_info["pages"]["flex_idx_property_detail"]["guid"], "/"); ?>/<?php echo $property['slug']; ?>" class="view-detail"><?php echo $property['address_large']; ?></a>
    </li>
    <?php endforeach; ?>
    </ul>
  </div>
</div>
