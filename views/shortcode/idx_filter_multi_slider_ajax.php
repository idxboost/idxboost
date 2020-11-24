<?php
  $text_button_style='';
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

      <li><button data-id="cw-tab-sale" class="cw-active"><span><?php echo $atts['title_exclusive']; ?></span></button></li>
      <li><button data-id="cw-tab-rent"><span><?php echo $atts['title_recent_sale']; ?></span></button></li>

    </ul>
    <div class="wrap-result view-grid">
      <div id="cw-tab-sale" class="cw-tab-item">
        <div class="tab-slider slider-exclusive-listing">
        </div>

        <a href="<?php echo $atts['link_exclusive']; ?>" title="<?php echo __("View all listings", IDXBOOST_DOMAIN_THEME_LANG); ?>" class="clidxboost-btn-link"> <span><?php echo __("View all listings", IDXBOOST_DOMAIN_THEME_LANG); ?></span></a>
      </div>
      <div id="cw-tab-rent" class="cw-tab-item cw-hidden-ov">
        <div class="tab-slider slider-recent-sale">
        </div>

        <a href="<?php echo $atts['link_recent_sale'];?>" title="<?php echo __("View all listings", IDXBOOST_DOMAIN_THEME_LANG); ?>" class="clidxboost-btn-link"> <span><?php echo __("View all listings", IDXBOOST_DOMAIN_THEME_LANG); ?></span></a>
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

  var view_grid_type='';
  var idxboost_hackbox_filter=[];

  jQuery('body').addClass('buildingPage');
  <?php
    $sta_view_grid_type='0'; 
    if (!empty($search_params)) {
    	if(array_key_exists('view_grid_type',$search_params)) 
    		$sta_view_grid_type=$search_params['view_grid_type']; 
    }
    ?>
  view_grid_type=<?php echo $sta_view_grid_type; ?>;
  if ( !jQuery('body').hasClass('clidxboost-ngrid') && view_grid_type==1) {
    jQuery('body').addClass('clidxboost-ngrid');
  }

</script>