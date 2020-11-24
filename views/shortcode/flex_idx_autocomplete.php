<?php
global $flex_idx_info;
?>
<div id="flex-bubble-search" class="idx_color_search_bar_background">
  <?php if (empty( get_theme_mod( 'idx_plugin_custom' )['idx_text_search_bar'] ))  $idx_text_search_bar  = ''; else  $idx_text_search_bar  = get_theme_mod( 'idx_plugin_custom' )['idx_text_search_bar']; ?>
  <?php if (empty( get_theme_mod( 'idx_plugin_custom' )['idx_text_sub_title_search_bar'] ))  $idx_text_sub_title_search_bar  = ''; else  $idx_text_sub_title_search_bar  = get_theme_mod( 'idx_plugin_custom' )['idx_text_sub_title_search_bar']; ?>
  <?php if (empty( get_theme_mod( 'idx_plugin_custom' )['has_button'] ))  $has_button  = ''; else  $has_button  = get_theme_mod( 'idx_plugin_custom' )['has_button']; ?>
  <?php if (empty( get_theme_mod( 'idx_plugin_custom' )['idx_text_button1_search_bar'] ))  $idx_text_button1_search_bar  = "I'm looking to buy"; else  $idx_text_button1_search_bar  = get_theme_mod( 'idx_plugin_custom' )['idx_text_button1_search_bar']; ?>
  <?php if (empty( get_theme_mod( 'idx_plugin_custom' )['idx_text_button2_search_bar'] ))  $idx_text_button2_search_bar  = "I'm looking to sell"; else  $idx_text_button2_search_bar  = get_theme_mod( 'idx_plugin_custom' )['idx_text_button2_search_bar']; ?>
  <?php if (empty( get_theme_mod( 'idx_plugin_custom' )['idx_link_button1_search_bar'] ))  $idx_link_button1_search_bar  = "#"; else  $idx_link_button1_search_bar  = get_theme_mod( 'idx_plugin_custom' )['idx_link_button1_search_bar']; ?>
  <?php if (empty( get_theme_mod( 'idx_plugin_custom' )['idx_link_button2_search_bar'] ))  $idx_link_button2_search_bar  = "#"; else  $idx_link_button2_search_bar  = get_theme_mod( 'idx_plugin_custom' )['idx_link_button2_search_bar']; ?>
  

  <div class="flex-bubble-header">
    <?php if(!empty($idx_text_search_bar)){ ?>
      <h2 class="flex-bubble-title idx_text_search_bar"><?php echo $idx_text_search_bar;?></h2>
    <?php } ?>
    <?php if(!empty($idx_text_sub_title_search_bar)){ ?>
      <h3 class="flex-bubble-sub-title"><?php echo $idx_text_sub_title_search_bar; ?></h3>
    <?php } ?>
  </div>
  <div class="content-flex-bubble-search">
    <form id="flex_idx_single_autocomplete" method="post">
      <input type="hidden" name="action" value="flex_idx_single_autocomplete">

      <div class="form-item">
        <label for="flex_ac_rental_slug" class="ms-hidden">Select</label>
        <select name="rental" id="flex_ac_rental_slug">
          <option value="0" <?php selected(0, $search_params['rental_types']); ?>><?php echo __('For Sale', IDXBOOST_DOMAIN_THEME_LANG); ?></option>
          <option value="1" <?php selected(1, $search_params['rental_types']); ?>><?php echo __('For Rent', IDXBOOST_DOMAIN_THEME_LANG); ?></option>
        </select>
        <span class="select-arrow"></span>
      </div>
      <label for="flex_idx_single_autocomplete_input" class="ms-hidden"><?php echo __('Enter an address, city, zip code or MLS number', IDXBOOST_DOMAIN_THEME_LANG); ?></label>
      <input autocorrect="off" autocapitalize="off" spellcheck="false" autocomplete="off"  id="flex_idx_single_autocomplete_input" class="notranslate" type="search" name="autocomplete" placeholder="<?php echo __('Enter an address, city, zip code or MLS number', IDXBOOST_DOMAIN_THEME_LANG); ?>">
      <button id="clidxboost-btn-search" type="submit" aria-label="Search Property">
        <span class="clidxboost-icon-search"></span>
      </button>

      <div id="ib-autocomplete-add"></div>
    </form>

    <button id="clidxboost-modal-search">Active modal</button>
    
    <a class="flex-link" href="<?php echo $flex_idx_info["pages"]["flex_idx_search"]["guid"]; ?>" title="<?php echo __('Advanced search options', IDXBOOST_DOMAIN_THEME_LANG); ?>">
      + <?php echo __('Advanced search options', IDXBOOST_DOMAIN_THEME_LANG); ?>
    </a>
  </div>
  <div class="flex-content-btn">
    <?php if (!empty($has_button)) { ?>
      <?php if(!empty($idx_text_button1_search_bar)){ ?>
      <a href="<?php echo $idx_link_button1_search_bar; ?>" class="flex-btn-link" title="<?php echo $idx_text_button1_search_bar; ?>"><span><?php echo $idx_text_button1_search_bar; ?></span></a>
      <?php } ?>
      <?php if(!empty($idx_text_button2_search_bar)){ ?>
        <a href="<?php echo $idx_link_button2_search_bar; ?>" class="flex-btn-link" title="<?php echo $idx_text_button2_search_bar; ?>"><span><?php echo $idx_text_button2_search_bar; ?></span></a>
      <?php } ?>
    <?php } ?>
  </div>
  <div class="flex-bubble-search-layout"></div>
</div>
<script type="text/javascript">
  var view_grid_type='';
  <?php
    $sta_view_grid_type='0'; if(array_key_exists('view_grid_type',$search_params)) $sta_view_grid_type=$search_params['view_grid_type']; ?>
  view_grid_type=<?php echo $sta_view_grid_type; ?>;
  if ( !jQuery('body').hasClass('clidxboost-ngrid') && view_grid_type==1) {
  	jQuery('body').addClass('clidxboost-ngrid');
  }
</script>
