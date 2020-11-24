<?php 
	$sale_count=0; $rent_count=0; $sold_count=0;
 if ($result_data['success']) { 
	if ($result_data['payload']['properties']['sale']['count']>0){ $sale_count= $result_data['payload']['properties']['sale']['count']; } 
	if ($result_data['payload']['properties']['rent']['count']>0){ $rent_count= $result_data['payload']['properties']['rent']['count']; } 
	if ($result_data['payload']['properties']['sold']['count']>0){ $sold_count= $result_data['payload']['properties']['sold']['count']; }
 }  ?>
<ul class="ib-inventory-list">
	<?php if($sale_count>0){ ?>
		<li><a href="<?php echo $link_building; ?>#!for-sale"><span><?php echo $sale_count; ?></span><?php echo __("For sale", IDXBOOST_DOMAIN_THEME_LANG); ?></a></li>
	<?php } ?>
	<?php if($rent_count>0){ ?>
		<li><a href="<?php echo $link_building; ?>#!for-rent"><span><?php echo $rent_count; ?></span><?php echo __("For Rent", IDXBOOST_DOMAIN_THEME_LANG); ?></a></li>
	<?php } ?>
	<?php if($rent_count>0){ ?>
		<li><a href="<?php echo $link_building; ?>#!sold"><span><?php echo $sold_count; ?></span><?php echo __("Sold", IDXBOOST_DOMAIN_THEME_LANG); ?></a></li>
	<?php } ?>
</ul>