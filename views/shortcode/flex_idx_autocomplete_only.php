<?php
global $flex_idx_info;
?>
<div id="flex-bubble-search" class="idx_color_search_bar_background">

<div class="content-flex-bubble-search">
<form id="flex_idx_single_autocomplete" method="post">

	<input type="hidden" name="rental" id="flex_ac_rental_slug" value="0">
	<input type="hidden" name="action" value="flex_idx_single_autocomplete">
	<input type="hidden" id="flex_ac_pt_slug" value="<?php echo $flex_ac_pt_slug; ?>">
	<input autocorrect="off" autocapitalize="off" spellcheck="false" autocomplete="off" id="flex_idx_single_autocomplete_input" class="notranslate" type="search" name="s" placeholder="Enter MLS, Address, Etc" value="">
	<button id="clidxboost-btn-search" type="submit"><span class="clidxboost-icon-search"></span></button>
</form>
<ul id="auc_city_dropdown" class="notranslate" style="display:none;">
<?php foreach ($flex_idx_info['search']['cities'] as $auc_city): ?>
<li title="<?php echo $auc_city['name']; ?>"><?php echo $auc_city['name']; ?></li>
<?php endforeach; ?>
</ul>
              </div>
          <div class="flex-bubble-search-layout"></div>
            </div>
<style type="text/css">
#auc_city_dropdown {
	height: 170px;
	overflow-y: auto;
	background-color: #fff;
	width: 100%;
	display: block;
	position: absolute;
	left: 0;
	top: 43px;
	box-shadow: 1px 2px 6px #CFCFCF;
}
#auc_city_dropdown > li {
    font-size: 14px;
    text-align: left;
    padding: 10px;
    line-height: 1;
    cursor: pointer;
}
#auc_city_dropdown > li:hover {
	background: rgb(177, 177, 177);
	color: #FFF;
}
}
</style>
<script type="text/javascript">
	var view_grid_type='';
	<?php
	$sta_view_grid_type='0'; if(array_key_exists('view_grid_type',$search_params)) $sta_view_grid_type=$search_params['view_grid_type']; ?>
	view_grid_type=<?php echo $sta_view_grid_type; ?>;
	if ( !jQuery('body').hasClass('clidxboost-ngrid') && view_grid_type==1) {
		jQuery('body').addClass('clidxboost-ngrid');
	}
</script>
