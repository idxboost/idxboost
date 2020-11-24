<?php
	$class_filter=$atts['type'];
	if (!empty($atts['id']))
	$class_filter = md5($atts['id']);
?>

<section data-item="<?php echo $atts['slider_item']; ?>" auto-play="<?php echo $atts['slider_play']; ?>" speed-slider="<?php echo $atts['slider_speed']; ?>" class="flex-block-description mtop-60 ib-filter-slider ib-filter-slider-<?php echo $class_filter; ?>" data-filter="<?php echo $class_filter; ?>" id="featured-section">
  <?php  if (!empty($atts['title'])) { ?>
  	<h2 class="title-block single idx_txt_text_tit_property_front"><?php echo $atts['title']; ?></h2>
  <?php } ?>
  <div class="wrap-result view-grid">
    <div class="gs-container-slider ib-properties-slider"></div>

</div>
	<?php  if (!empty($atts['link'])) { ?>
	<a class="clidxboost-btn-link idx_txt_text_property_front" href="<?php echo $atts['link']; ?>" title="<?php echo $atts['name_button']; ?>"> <span><?php echo $atts['name_button']; ?></span></a>
	<?php } ?>

<input type="hidden" class="ib_type_filter" value="<?php echo $atts['type']; ?>">
<input type="hidden" class="ib_id_filter" value="<?php echo $atts['id']; ?>">
</section>

<script type="text/javascript">
	var view_grid_type='';
	<?php
	$sta_view_grid_type='0'; if(array_key_exists('view_grid_type',$search_params)) $sta_view_grid_type=$search_params['view_grid_type']; ?>
	view_grid_type=<?php echo $sta_view_grid_type; ?>;
	if ( !jQuery('body').hasClass('clidxboost-ngrid') && view_grid_type==1) {
		jQuery('body').addClass('clidxboost-ngrid');
	}
</script>