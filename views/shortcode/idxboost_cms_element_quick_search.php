<?php 
global $flex_idx_info;

// Cambiar TODAS las referencias de $attr a $atts
$button_class_type = $atts['button_type'] === 'text' ? 'ibc-has-text' : 'ibc-has-icon';
$button_aria_label = $atts['button_type'] === 'text' ? $atts['button_text'] : __('Search', IDXBOOST_DOMAIN_THEME_LANG);
$button_text = $atts['button_type'] === 'text' ? $atts['button_text'] : '<span class="clidxboost-icon-search"></span>';

// Obtener las opciones del filtro
$filter_labels = array(
    'sale' => __('For Sale', IDXBOOST_DOMAIN_THEME_LANG),
    'rent' => __('For Rent', IDXBOOST_DOMAIN_THEME_LANG),
    'sold' => __('Sold', IDXBOOST_DOMAIN_THEME_LANG),
);

$filter_options = is_array($atts['filter_options']) ? $atts['filter_options'] : array('sale', 'rent');
$filter_type = $atts['filter_type'];
$search_params = $flex_idx_info['search'];
?>

<div id="flex-bubble-search">
    <div class="content-flex-bubble-search">
        <form id="flex_idx_single_autocomplete" method="post">
            <input type="hidden" name="action" value="flex_idx_single_autocomplete">
            
            <?php if (!empty($filter_options)): ?>
                <?php
                    // Mapping entre los valores string y numéricos esperados por el JS
                    $filter_value_map = [
                        'sale' => 0,
                        'rent' => 1,
                        'sold' => 2,
                    ];
                ?>
                
                <?php if ($filter_type === 'dropdown'): ?>
                    <!-- Dropdown Filter -->
                    <div class="form-item">
                        <label for="flex_ac_rental_slug" class="ms-hidden">Select</label>
                        <select name="rental" id="flex_ac_rental_slug" class="ibc-c-searchbar-select">
                            <?php foreach ($filter_options as $index => $option): ?>
                                <?php $mapped_value = $filter_value_map[$option] ?? $option; ?>
                                <option value="<?php echo esc_attr($mapped_value); ?>" <?php if ($index === 0) echo 'selected'; ?>>
                                    <?php echo isset($filter_labels[$option]) ? esc_html($filter_labels[$option]) : esc_html(ucfirst($option)); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <span class="select-arrow"></span>
                    </div>
                <?php else: ?>
                    <!-- Tabs Filter -->
                    <div class="ibc-c-searchbar-tabs">
                        <?php foreach ($filter_options as $index => $option): ?>
                            <?php $mapped_value = $filter_value_map[$option] ?? $option; ?>
                            <button 
                                class="ibc-c-searchbar-tab <?php echo $index === 0 ? 'ibc-is-active' : ''; ?>"
                                type="button"
                                data-value="<?php echo esc_attr($mapped_value); ?>">
                                <?php echo isset($filter_labels[$option]) ? esc_html($filter_labels[$option]) : esc_html(ucfirst($option)); ?>
                            </button>
                        <?php endforeach; ?>
                    </div>
                    
                    <!-- Hidden input to store selected tab value -->
                    <?php $first_option_mapped = $filter_value_map[$filter_options[0]] ?? $filter_options[0]; ?>
                    <input type="hidden" id="flex_ac_rental_slug" name="rental" value="<?php echo esc_attr($first_option_mapped); ?>">
                <?php endif; ?>
            <?php endif; ?>
            
            <label for="flex_idx_single_autocomplete_input" class="ms-hidden">
                <?php echo esc_attr($atts['input_placeholder']); ?>
            </label>
            
			<input 
                class="notranslate" 
                id="flex_idx_single_autocomplete_input"
                type="search" 
                name="autocomplete"
                placeholder="<?php echo esc_attr($atts['input_placeholder']); ?>"
                autocorrect="off" 
                autocapitalize="off" 
                spellcheck="false" 
                autocomplete="off">
            
            <button 
                class="ibc-c-searchbar-btn <?php echo $button_class_type; ?>" 
                id="clidxboost-btn-search" 
                type="submit" 
                aria-label="<?php echo esc_attr($button_aria_label); ?>">
                <?php echo $button_text; ?>
            </button>
            
            <div id="ib-autocomplete-add"></div>
        </form>
        
        <button id="clidxboost-modal-search">
            Active modal
        </button>
        
        <a class="flex-link" 
           href="<?php echo $flex_idx_info["pages"]["flex_idx_search"]["guid"]; ?>" 
           title="<?php echo esc_attr(__('Advanced search options', IDXBOOST_DOMAIN_THEME_LANG)); ?>">
            + <?php echo __('Advanced search options', IDXBOOST_DOMAIN_THEME_LANG); ?>
        </a>
    </div>
    <div class="flex-bubble-search-layout"></div>
</div>

<script type="text/javascript">
	var view_grid_type = '';
	<?php
		$sta_view_grid_type = '0'; 
		if (array_key_exists('view_grid_type', $search_params)) {
			$sta_view_grid_type = $search_params['view_grid_type']; 
		}
	?>
	view_grid_type = <?php echo $sta_view_grid_type; ?>;
	if (!jQuery('body').hasClass('clidxboost-ngrid') && view_grid_type == 1) {
		jQuery('body').addClass('clidxboost-ngrid');
	}

    const $tabs = jQuery('.ibc-c-searchbar-tab');
    const $hiddenInput = jQuery('#flex_ac_rental_slug');

    if ($tabs.length && $hiddenInput.length) {
      $tabs.on('click', function() {
        $tabs.removeClass('ibc-is-active');
        jQuery(this).addClass('ibc-is-active');
        $hiddenInput.val(jQuery(this).data('value'));
      });
    }
</script>