<?php if (isset($featured_filter_page) && !empty($featured_filter_page)): ?>

<section class="flex-block-description mtop-60" id="featured-section">
  <?php if (empty( get_theme_mod( 'idx_txt_text_tit_property_front' ) ))  $idx_txt_text_tit_property_front  = ''; else  $idx_txt_text_tit_property_front  = get_theme_mod( 'idx_txt_text_tit_property_front' ); ?>
  <h2 class="title-block single idx_txt_text_tit_property_front"><?php echo $idx_txt_text_tit_property_front; ?></h2>
  <div class="wrap-result view-grid">

  	<?php
  	if(is_array($response) && count($response) > 0){ ?>

    <div class="gs-container-slider clidxboost-properties-slider">
    	<?php foreach($response['items'] as $property): ?>
      <ul class="result-search idx_color_primary">
        <li data-mls="<?php echo $property['mls_num']; ?>" class="propertie" data-geocode="<?php echo $property['lat']; ?>:<?php echo $property['lng']; ?>" data-class-id="<?php echo $property['class_id']; ?>">
            <?php if ($property['status'] == 5): ?>
            <div class="flex-property-new-listing"><?php echo __('rented', IDXBOOST_DOMAIN_THEME_LANG); ?></div>
            <?php elseif($property['status'] == 2): ?>
            <div class="flex-property-new-listing"><?php echo __('sold', IDXBOOST_DOMAIN_THEME_LANG); ?></div>
            <?php elseif($property['status'] != 1): ?>
            <div class="flex-property-new-listing"><?php echo $property['status_name']; ?></div>
            <?php elseif(isset($property['recently_listed']) && $property['recently_listed'] === 'yes'): ?>
            <div class="flex-property-new-listing"><?php echo __('new listing', IDXBOOST_DOMAIN_THEME_LANG); ?></div>
            <?php endif; ?>        	
        	<?php $arraytemp = str_replace(' , ', ', ', $property["address_large"]); $final_address_parceada = $property['address_short'] . "<span>" . $arraytemp . "</span>"; ?>
        	
					<h2 title="<?php echo $property['full_address']; ?>" class="ms-property-address"><?php echo $property['full_address_top']; ?><span>,</span> <br><?php echo $property['full_address_bottom']; ?></h2>
					<!--<h2 title="<?php echo $property['address_short']; ?> <?php echo $property['address_large']; ?>"><?php echo $final_address_parceada; ?></h2>-->
					
					<ul class="features">
						<li class="address"><?php echo $property['address_large']; ?></li>
						<li class="price">$<?php echo number_format($property['price']); ?></li>
						<?php if ($property['reduced'] == ''): ?>
						<li class="pr"><?php echo $property['reduced']; ?></li>
						<?php elseif($property['reduced'] < 0): ?>
						<li class="pr down"><?php echo $property['reduced']; ?>%</li>
						<?php else: ?>
						<li class="pr up"><?php echo $property['reduced']; ?>%</li>
						<?php endif; ?>
						<li class="beds"><?php echo $property['bed']; ?> <span>
						<?php if ($property['bed']>1) {
		            		echo __("Beds", IDXBOOST_DOMAIN_THEME_LANG);
		            	}else {
		            		echo __("Bed", IDXBOOST_DOMAIN_THEME_LANG);
						}?></span></li>
						<li class="baths"><?php echo $property['bath']; ?> <span>
						<?php
						if ($property['bath']>1) {
	            			echo __("Bath", IDXBOOST_DOMAIN_THEME_LANG);
	            		}else{
	            			echo __("Baths", IDXBOOST_DOMAIN_THEME_LANG);
						}
						?></span></li>
						<li class="living-size"> <span><?php echo number_format($property['sqft']); ?></span><?php echo __("Sq.Ft.", IDXBOOST_DOMAIN_THEME_LANG); ?> <span>(<?php echo $property['living_size_m2']; ?> m2)</span></li>
						<li class="price-sf"><span>$<?php echo $property['price_sqft']; ?></span>/ <?php echo __("Sq.Ft.", IDXBOOST_DOMAIN_THEME_LANG); ?><span>($<?php echo $property['price_sqft_m2']; ?> m2)</span></li>
						<?php if (!empty($property['subdivision'])): ?>
						<li class="development"><span><?php echo $property['subdivision']; ?></span></li>
						<?php elseif (!empty($property['development'])): ?>
						<li class="development"><span><?php echo $property['development']; ?></span></li>
						<?php else: ?>
						<li class="development"><span><?php echo $property['complex']; ?></span></li>
						<?php endif; ?>
						
					</ul>
					<?php $totgallery=''; if ( count($property['gallery'])<=1 ) $totgallery='no-zoom'; ?>
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
						<button class="prev flex-slider-prev" tabindex="-1" aria-label="Prev"><span class="clidxboost-icon-arrow-select"></span></button>
						<button class="next flex-slider-next" tabindex="-1" aria-label="Next"><span class="clidxboost-icon-arrow-select"></span></button>
					<?php } ?>

					<?php if ($property['is_favorite'] == true): ?>
						<button aria-label="Remove Favorite" class="clidxboost-btn-check flex-favorite-btn" data-alert-token="<?php echo $property['token_alert']; ?>" tabindex="-1">
							<span class="clidxboost-icon-check active"></span>
						</button>
					<?php else: ?>

						<button aria-label="Save Favorite" class="clidxboost-btn-check flex-favorite-btn" tabindex="-1">
							<span class="clidxboost-icon-check"></span>
						</button>
					<?php endif; ?>

					</div>
					<a href="<?php echo rtrim($flex_idx_info["pages"]["flex_idx_property_detail"]["guid"], "/"); ?>/<?php echo $property['slug']; ?>" class="view-detail"><?php echo $property['address_large']; ?></a>
        </li>
      </ul>
      <?php endforeach; ?>
    </div>

<?php } else { ?>
<div class="message-alert info-color" id="box_flex_alerts_msg">
	<p><?php echo __('Please update your Filter ID key on your IDX Boost Dashboard to display live MLS data on your website.', IDXBOOST_DOMAIN_THEME_LANG); ?> <a href="http://cpanel.idxboost.com"><?php echo __('Click here to update', IDXBOOST_DOMAIN_THEME_LANG); ?></a></p>
</div>
<?php } ?>
</div>
<?php if (empty( get_theme_mod( 'idx_txt_text_property_front' ) ))  $idx_txt_text_property_front  = ''; else  $idx_txt_text_property_front  = get_theme_mod( 'idx_txt_text_property_front' ); ?>
<a class="clidxboost-btn-link idx_txt_text_property_front" href="<?php echo get_permalink($featured_filter_page['ID']); ?>" title="<?php echo $idx_txt_text_property_front; ?>"> <span><?php echo $idx_txt_text_property_front; ?></span></a>
</section>
<?php endif; ?>

<script type="text/javascript">
	var view_grid_type='';
	<?php
	$sta_view_grid_type='0'; if(array_key_exists('view_grid_type',$search_params)) $sta_view_grid_type=$search_params['view_grid_type']; ?>
	view_grid_type=<?php echo $sta_view_grid_type; ?>;
	if ( !jQuery('body').hasClass('clidxboost-ngrid') && view_grid_type==1) {
		jQuery('body').addClass('clidxboost-ngrid');
	}
</script>
