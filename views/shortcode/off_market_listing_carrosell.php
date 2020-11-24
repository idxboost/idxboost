<?php
	$class_filter=ibCodRandow(5);
?>

<section data-item="<?php echo $atts['slider_item']; ?>" class="flex-block-description mtop-60 ib-off-market-listing-slider ib-off-market-listing-slider-<?php echo $class_filter; ?>" data-filter="<?php echo $class_filter; ?>" id="featured-section">
	
	<form method="post" id="flex-idx-off-market-listing-form" class="flex-idx-off-market-listing-form" >
	  <input type="hidden" name="action" value="idxboost_collection_off_market">
	  <input type="hidden" name="market_order" class="market_order" id="idx_sort" value="<?php echo $atts['order']; ?>">
	  <input type="hidden" name="market_tag" class="market_tag" id="idx_tag" value="<?php echo $atts['tag']; ?>">
	  <input type="hidden" name="market_limit" class="market_limit" id="idx_limit" value="<?php echo $atts['limit']; ?>">
	  <input type="hidden" name="market_page" class="market_page" id="idx_page" value="1">
	</form>	

  <?php  if (!empty($atts['title'])) { ?>
  	<h2 class="title-block single idx_txt_text_tit_property_front"><?php echo $atts['title']; ?></h2>
  <?php } ?>
  <div class="wrap-result view-grid">
    <div class="gs-container-slider ib-properties-slider"></div>

</div>
	<?php  if (!empty($atts['link'])) { ?>
	<a class="clidxboost-btn-link idx_txt_text_property_front" href="<?php echo $atts['link']; ?>" title="<?php echo $atts['name_button']; ?>"> <span><?php echo $atts['name_button']; ?></span></a>
	<?php } ?>

<input type="hidden" class="ib_type_offmarket_listing" value="<?php echo $atts['type']; ?>">
<input type="hidden" class="ib_id_offmarket_listing" value="<?php echo $atts['id']; ?>">
</section>

<script type="text/javascript">
	var view_grid_type='';
	<?php
	$sta_view_grid_type='0'; 
	if(isset($search_params) && array_key_exists('view_grid_type',$search_params)) $sta_view_grid_type=$search_params['view_grid_type']; ?>
	view_grid_type=<?php echo $sta_view_grid_type; ?>;
	if ( !jQuery('body').hasClass('clidxboost-ngrid') && view_grid_type==1) {
		jQuery('body').addClass('clidxboost-ngrid');
	}
</script>
