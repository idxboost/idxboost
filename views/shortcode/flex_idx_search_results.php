<?php 
$useragent_for_mobile=$_SERVER['HTTP_USER_AGENT'];
if(preg_match('/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i',$useragent_for_mobile)||preg_match('/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i',substr($useragent_for_mobile,0,4))){
  $response['view']='map';
}
?>

<div id="flex_idx_search_form_hidden" style="display:none;">
	<form method="post" id="flex-idx-search-form">
		<input type="hidden" name="action" value="flex_search">
		<input type="hidden" name="idx[tab]" id="idx_property_type" value="<?php echo $property_type_slug; ?>">
		<input type="hidden" name="idx[rental]" id="idx_rental" value="<?php echo $is_rental; ?>">
		<input type="hidden" name="idx[keyword]" id="idx_keyword" value="<?php echo isset($keywords_slug) ? $keywords_slug : ''; ?>">

		<input type="hidden" name="idx[polygon]" id="idx_polygon" value="<?php echo isset($polygon_token) ? $polygon_token : ''; ?>">

		<input type="hidden" name="idx[min_price_sale]" id="idx_min_price_sale" value="<?php echo $min_price_sale; ?>">
		<input type="hidden" name="idx[max_price_sale]" id="idx_max_price_sale" value="<?php echo $max_price_sale; ?>">
		<input type="hidden" name="idx[min_price_rent]" id="idx_min_price_rent" value="<?php echo $min_price_rent; ?>">
		<input type="hidden" name="idx[max_price_rent]" id="idx_max_price_rent" value="<?php echo $max_price_rent; ?>">

		<input type="hidden" name="idx[min_beds]" id="idx_min_beds" value="<?php echo $min_bed; ?>">
		<input type="hidden" name="idx[max_beds]" id="idx_max_beds" value="<?php echo $max_bed; ?>">
		<input type="hidden" name="idx[min_baths]" id="idx_min_baths" value="<?php echo $min_bath; ?>">
		<input type="hidden" name="idx[max_baths]" id="idx_max_baths" value="<?php echo $max_bath; ?>">
		<input type="hidden" name="idx[min_year]" id="idx_min_year" value="<?php echo $min_year; ?>">
		<input type="hidden" name="idx[max_year]" id="idx_max_year" value="<?php echo $max_year; ?>">

		<input type="hidden" name="idx[living_area_min]" id="idx_living_area_min" value="<?php echo $living_area_min; ?>">
		<input type="hidden" name="idx[living_area_max]" id="idx_living_area_max" value="<?php echo $living_area_max; ?>">
		<input type="hidden" name="idx[lot_size_min]" id="idx_lot_size_min" value="<?php echo $lot_size_min; ?>">
		<input type="hidden" name="idx[lot_size_max]" id="idx_lot_size_max" value="<?php echo $lot_size_max; ?>">

		<input type="hidden" name="idx[water_desc]" id="idx_water_desc" value="<?php echo $water_desc; ?>">
		<input type="hidden" name="idx[parking]" id="idx_parking" value="<?php echo $parking; ?>">

		<input type="hidden" name="idx[features]" id="idx_features" value="<?php echo implode('|', $features); ?>">

		<input type="hidden" name="idx[view]" id="idx_view" value="<?php echo $default_view; ?>">
		<input type="hidden" name="idx[sort]" id="idx_sort" value="<?php echo $order; ?>">
		<input type="hidden" name="idx[page]" id="idx_page" value="<?php echo isset($page) ? $page : 1; ?>">

		<input type="hidden" name="idx[center]" id="idx_center" value="<?php echo $default_center; ?>">
		<input type="hidden" name="idx[zoom]" id="idx_zoom" value="<?php echo $default_zoom; ?>">
		<input type="hidden" name="idx[bounds]" id="idx_bounds" value="">
	</form>
</div>

<div class="wrap-page-idx">

<div class="content-filters">
	<div id="wrap-filters" class="animated fixed-box search-page-ft">
		<div class="gwr gwr-filters">
			<div id="header-filters">
        <div class="idx_logo_web">
			<?php if (function_exists('idx_the_custom_logo_header')): ?>
				<?php idx_the_custom_logo_header(); ?>
			<?php endif; ?>
        </div>
        <div class="text-wrapper">
          <div class="allf-callus"><?php echo __("Call us", IDXBOOST_DOMAIN_THEME_LANG); ?>: <a href="telf:<?php echo preg_replace('/[^\d+]/', '', $flex_idx_info['agent']['agent_contact_phone_number']); ?>"><?php echo flex_phone_number_filter($flex_idx_info['agent']['agent_contact_phone_number']); ?></a></div>
          <button class="allf-ss"><?php echo __("Save this Search", IDXBOOST_DOMAIN_THEME_LANG); ?></button>
          <button class="resp-btn" id="show-mobile-menu"><span></span></button>
        </div>
      </div>
			<ul id="filters">
				<li class="mb-options">
					<button id="mb-btn-save-search">
						<span><?php echo __("Save Search", IDXBOOST_DOMAIN_THEME_LANG); ?></span>
					</button>
					<button id="mb-btn-active-filter">
						<span><?php echo __("Filter", IDXBOOST_DOMAIN_THEME_LANG); ?></span>
					</button>
				</li>
				<li class="mini-search" id="autocomplete-dropdown-ct" style="position:relative;">
					<form id="flex_search_keyword_form">
						<input autocorrect="off" autocapitalize="off" spellcheck="false" autocomplete="disabled" autocomplete="disabled" type="search" placeholder="<?php echo __("Enter address, city, zip or MLS", IDXBOOST_DOMAIN_THEME_LANG); ?>" id="autocomplete-ajax" class="notranslate" value="<?php echo isset($keyword_label) ? $keyword_label : ''; ?>">
						<label class="line-form"></label>
						<div id="submit-ms" class="clidxboost-icon-search">
							<input id="flex_search_keyword_form_submit" type="submit" value="Submit">
						</div>
					</form>
				</li>
				<li class="price">
					<button> <span class="clidxboost-icon-arrow-select"> <span id="text-price"><?php echo __("Any Price", IDXBOOST_DOMAIN_THEME_LANG); ?></span></span></button>
				</li>
				<li class="beds">
					<button> <span class="clidxboost-icon-arrow-select"> <span id="text-beds"><?php echo __("Any Bed", IDXBOOST_DOMAIN_THEME_LANG); ?></span></span></button>
				</li>
				<li class="baths">
					<button> <span class="clidxboost-icon-arrow-select"> <span id="text-baths"><?php echo __("Any Bath", IDXBOOST_DOMAIN_THEME_LANG); ?></span></span></button>
				</li>
				<li class="type">
					<button> <span class="clidxboost-icon-arrow-select"> <span id="text-type">Type</span></span></button>
				</li>
				<li class="all">
					<button class="f-as-trigger">
						<span class="clidxboost-icon-arrow-select">
							<span class="idx-text-pc"><?php echo __("More Filters", IDXBOOST_DOMAIN_THEME_LANG); ?></span>
							<span class="idx-text-mb"><?php echo __("Filters", IDXBOOST_DOMAIN_THEME_LANG); ?></span>
						</span>
					</button>
				</li>
				<li class="save"><strong id="properties-found"><span>0</span><?php echo __("Properties", IDXBOOST_DOMAIN_THEME_LANG); ?></strong>
					<button class="refresh-btn" onclick="javascript:window.location.href=flex_idx_search_params.searchUrl;"><span><?php echo __("Clear", IDXBOOST_DOMAIN_THEME_LANG); ?></span></button>
					<button id="flex_save_search_btn" data-modal="modal_save_search" class="show-modal save-btn"><span><?php echo __("Save", IDXBOOST_DOMAIN_THEME_LANG); ?></span></button>
				</li>
			</ul>
			<div id="all-filters">
				<ul id="mini-filters">
					<li class="filter-box">
						<div class="gwr">
							<h4 class="clidxboost-icon-arrow-select"><?php echo __("Property search", IDXBOOST_DOMAIN_THEME_LANG); ?></h4>
							<div class="wrap-item">
								<ul class="list-type-sr">
									<li>
										<button class="flex_search_rental_switch<?php if($is_rental == 0): ?> active<?php endif; ?>" id="for-sale"> <span><?php echo __("For sale", IDXBOOST_DOMAIN_THEME_LANG); ?></span></button>
									</li>
									<li>
										<button class="flex_search_rental_switch<?php if($is_rental == 1): ?> active<?php endif; ?>" id="for-rent"> <span><?php echo __("For Rent", IDXBOOST_DOMAIN_THEME_LANG); ?></span></button>
									</li>
								</ul>
								<div id="flex_search_keyword_form_min">
									<input autocorrect="off" autocapitalize="off" spellcheck="false" autocomplete="disabled" autocomplete="disabled" type="search" placeholder="Enter address, city, zip or MLS" id="autocomplete-ajax-min" class="notranslate" value="<?php echo isset($keyword_label) ? $keyword_label : ''; ?>">
									<div id="submit-ms-min" class="clidxboost-icon-search">
										<input type="submit" value="Submit">
									</div>
								</div>
							</div>
						</div>
					</li>
					<li class="cities">
						<div class="gwr">
							<div class="wrap-item" id="cities-list-wrap">
								<div id="cities-list" class="notranslate">
									<ul>
										<?php foreach($search_params['cities'] as $city): ?>
										<li data-id="<?php echo $city['code']; ?>" data-slug="<?php echo $city['name']; ?>|city"><?php echo $city['name']; ?></li>
										<?php endforeach; ?>
									</ul>
								</div>
							</div>
						</div>
					</li>
					<li class="price">
						<div class="gwr">
							<h4 class="clidxboost-icon-arrow-select"><?php echo __("Price Range", IDXBOOST_DOMAIN_THEME_LANG); ?></h4>
							<div class="wrap-item price_range_for_sale price_ranges_ct" <?php if($is_rental == 1): ?> style="display:none;" <?php endif; ?>>
									<div class="wrap-inputs">
										<input id="price_from" class="notranslate" type="text" value=""> <span><?php echo __("to", IDXBOOST_DOMAIN_THEME_LANG); ?></span>
										<input id="price_to" class="notranslate" type="text" value="">
									</div>
									<div class="wrap-range">
										<div id="range-price" class="range-slide"></div>
									</div>
							</div>
							<div class="wrap-item price_range_for_rent price_ranges_ct" <?php if($is_rental == 0): ?> style="display:none;" <?php endif; ?>>
									<div class="wrap-inputs">
										<input id="price_rent_from" class="notranslate" type="text" value=""><span>to</span>
										<input id="price_rent_to" class="notranslate" type="text" value="">
									</div>
									<div class="wrap-range">
										<div id="range-price-rent" class="range-slide"></div>
									</div>
							</div>
						</div>
					</li>
					<li class="baths">
						<div class="gwr">
							<h4 class="clidxboost-icon-arrow-select"><?php echo __("Bathrooms", IDXBOOST_DOMAIN_THEME_LANG); ?></h4>
							<div class="wrap-item">
								<div class="wrap-range">
									<div id="range-baths" class="range-slide"></div>
								</div>
								<ul class="markers-range">
									<?php foreach ($search_params['baths_range'] as $index => $bath_range): ?>
										<?php if ($index == 0){ ?>
										<li><span><?php echo $bath_range['label']; ?></span></li>
										<?php }else{ ?>
										<li><?php echo $bath_range['label']; ?></li>
										<?php } ?>
									<?php endforeach; ?>
								</ul>
							</div>
						</div>
					</li>
					<li class="beds">
						<div class="gwr">
							<h4 class="clidxboost-icon-arrow-select"><?php echo __("Bedrooms", IDXBOOST_DOMAIN_THEME_LANG); ?></h4>
							<div class="wrap-item">
								<div class="wrap-range">
									<div id="range-beds" class="range-slide"></div>
								</div>
								<ul class="markers-range">
									<?php foreach ($search_params['beds_range'] as $index => $bath_range): ?>
										<?php if ($index == 0){ ?>
										<li><span><?php echo $bath_range['label']; ?></span></li>
										<?php }else{ ?>
										<li><?php echo $bath_range['label']; ?></li>
										<?php } ?>
									<?php endforeach; ?>
								</ul>
							</div>
						</div>
					</li>
					<li class="type">
						<div class="gwr">
							<h4 class="clidxboost-icon-arrow-select"><?php echo __("Type", IDXBOOST_DOMAIN_THEME_LANG); ?></h4>
							<div class="wrap-item">
								<div class="wrap-checks">
									<ul>
										<?php foreach ($search_params['property_types'] as $property_type): ?>
										<li>
											<input class="property_type_checkbox" type="checkbox" <?php if(in_array($property_type['value'], explode('|', $property_type_slug))): ?> checked <?php endif; ?> value="<?php echo $property_type['value']; ?>" id="_pt_<?php echo $property_type['value']; ?>">
											<label for="_pt_<?php echo $property_type['value']; ?>"><?php 
						                        $text_label_trans='';
						                        if($property_type['label']=='Homes'){
						                            $text_label_trans=__("Homes", IDXBOOST_DOMAIN_THEME_LANG);
						                        }else if($property_type['label']=='Condominiums'){
						                            $text_label_trans=__("Condominiums", IDXBOOST_DOMAIN_THEME_LANG);
						                        }else if($property_type['label']=='Townhouses'){
						                            $text_label_trans=__("Townhouses", IDXBOOST_DOMAIN_THEME_LANG);
						                        }else if ($property_type['label']=='Single Family Homes'){
						                            $text_label_trans=__("Single Family Homes", IDXBOOST_DOMAIN_THEME_LANG);
						                        }
						                        echo $text_label_trans; ?></label>
										</li>
										<?php endforeach; ?>
									</ul>
								</div>
							</div>
						</div>
					</li>
					<li class="living">
						<div class="gwr">
							<h4 class="clidxboost-icon-arrow-select"><?php echo __("Living size", IDXBOOST_DOMAIN_THEME_LANG); ?></h4>
							<div class="wrap-item">
								<div class="wrap-inputs">
									<input id="living_from" class="notranslate" type="text" value=""><span><?php echo __("to", IDXBOOST_DOMAIN_THEME_LANG); ?></span>
									<input id="living_to" class="notranslate" type="text" value="">
								</div>
								<div class="wrap-range">
									<div id="range-living" class="range-slide"></div>
								</div>
							</div>
						</div>
					</li>
					<li class="year">
						<div class="gwr">
							<h4 class="clidxboost-icon-arrow-select"><?php echo __("Year Built", IDXBOOST_DOMAIN_THEME_LANG); ?></h4>
							<div class="wrap-item">
								<div class="wrap-inputs">
									<input id="year_from" class="flex-input-year-min" type="text" value=""><span><?php echo __("to", IDXBOOST_DOMAIN_THEME_LANG); ?></span>
									<input id="year_to" class="flex-input-year-max" type="text" value="">
								</div>
								<div class="wrap-range">
									<div id="range-year" class="range-slide"></div>
								</div>
							</div>
						</div>
					</li>
					<li class="waterfront">
						<div class="gwr">
							<h4 class="clidxboost-icon-arrow-select"><?php echo __("Waterfront description", IDXBOOST_DOMAIN_THEME_LANG); ?></h4>
							<div class="wrap-item">
								<div class="wrap-select clidxboost-icon-arrow-select">
									<select id="flex_waterfront_switch">
									<option value="--"><?php echo __("Any", IDXBOOST_DOMAIN_THEME_LANG); ?></option>
									<?php foreach ($search_params['waterfront_options'] as $waterfront_option):
									// if (in_array($waterfront_option["code"], array("ocean-access", "ocean-front"))) { continue; }
									?>
									<option <?php selected($water_desc, $waterfront_option['code']); ?> value="<?php echo $waterfront_option['code']; ?>"><?php 
				                      $text_label_trans='';
				                      if($waterfront_option['name']=='Bay Front')
				                          $text_label_trans= __("Bay Front", IDXBOOST_DOMAIN_THEME_LANG);
				                      else if ($waterfront_option['name']=='Canal')
				                          $text_label_trans= __("Canal", IDXBOOST_DOMAIN_THEME_LANG);
				                      else if ($waterfront_option['name']=='Fixed Bridge')
				                          $text_label_trans= __("Fixed Bridge", IDXBOOST_DOMAIN_THEME_LANG);
				                      else if ($waterfront_option['name']=='Intracoastal')
				                          $text_label_trans=__("Intracoastal", IDXBOOST_DOMAIN_THEME_LANG);
				                      else if ($waterfront_option['name']=='Lake Front')
				                          $text_label_trans= __("Lake Front", IDXBOOST_DOMAIN_THEME_LANG);
				                      else if ($waterfront_option['name']=='Ocean Access')
				                          $text_label_trans=__("Ocean Access", IDXBOOST_DOMAIN_THEME_LANG);
				                      else if ($waterfront_option['name']=="Ocean Front")
				                          $text_label_trans=__("Ocean Front", IDXBOOST_DOMAIN_THEME_LANG);
				                      else if ($waterfront_option['name']=="Point Lot")
				                          $text_label_trans=__("Point Lot", IDXBOOST_DOMAIN_THEME_LANG);
				                      else if ($waterfront_option['name']=="River Front")
				                          $text_label_trans=__("River Front", IDXBOOST_DOMAIN_THEME_LANG);
				                      echo $text_label_trans;  ?></option>
									<?php endforeach; ?>
									</select>
								</div>
							</div>
						</div>
					</li>
					<li class="parking">
						<div class="gwr">
							<h4 class="clidxboost-icon-arrow-select"><?php echo __("Parking spaces", IDXBOOST_DOMAIN_THEME_LANG); ?></h4>
							<div class="wrap-item">
								<div class="wrap-select clidxboost-icon-arrow-select">
									<select id="flex_parking_switch">
										<option value="--"><?php echo __("Any", IDXBOOST_DOMAIN_THEME_LANG); ?></option>
										<?php foreach ($search_params['parking_options'] as $parking_option): ?>
										<option <?php selected($parking, $parking_option['value']); ?> value="<?php echo $parking_option['value']; ?>"><?php echo $parking_option['label']; ?></option>
										<?php endforeach; ?>
									</select>
								</div>
							</div>
						</div>
					</li>
					<li class="land">
						<div class="gwr">
							<h4 class="clidxboost-icon-arrow-select"><?php echo __("Land size", IDXBOOST_DOMAIN_THEME_LANG); ?></h4>
							<div class="wrap-item">
								<div class="wrap-inputs">
									<input id="land_from" class="notranslate" type="text" value=""><span><?php echo __("to", IDXBOOST_DOMAIN_THEME_LANG); ?></span>
									<input id="land_to" class="notranslate" type="text" value="">
								</div>
								<div class="wrap-range">
									<div id="range-land" class="range-slide"></div>
								</div>
							</div>
						</div>
					</li>
					<li class="features">
						<div class="gwr">
							<h4 class="clidxboost-icon-arrow-select">
								<label><?php echo __("Features", IDXBOOST_DOMAIN_THEME_LANG); ?></label>
							</h4>
							<div class="wrap-item">
								<div class="wrap-checks">
									<ul>
									<?php foreach ($search_params['amenities'] as $amenity):
										if ((5 != $board_id) && ("loft" == $amenity["code"])) { continue; }
										if ((5 == $board_id) && ("water_front" == $amenity["code"])) { continue; }
										?>
									<li>
										<input <?php if (in_array($amenity['code'], $features)): ?> checked <?php endif; ?> class="amenities_checkbox" type="checkbox" value="<?php echo $amenity['code']; ?>" id="_amenity_<?php echo $amenity['code']; ?>">
										<label for="_amenity_<?php echo $amenity['code']; ?>"><?php 
				                        $text_label_trans='';
				                        if($amenity['name']=='Swimming Pool')
				                            $text_label_trans= __("Swimming Pool", IDXBOOST_DOMAIN_THEME_LANG);
				                        else if ($amenity['name']=='Golf Course')
				                            $text_label_trans= __("Golf Course", IDXBOOST_DOMAIN_THEME_LANG);
				                        else if ($amenity['name']=='Tennis Courts')
				                            $text_label_trans= __("Tennis Courts", IDXBOOST_DOMAIN_THEME_LANG);
				                        else if ($amenity['name']=='Gated Community')
				                            $text_label_trans= __("Gated Community", IDXBOOST_DOMAIN_THEME_LANG);
				                        else if ($amenity['name']=='Lofts')
				                            $text_label_trans= __("Lofts", IDXBOOST_DOMAIN_THEME_LANG);
				                        else if ($amenity['name']=='Penthouse')
				                            $text_label_trans= __("Penthouse", IDXBOOST_DOMAIN_THEME_LANG);
				                        else if ($amenity['name']=="Waterfront")
				                            $text_label_trans= __("Waterfront", IDXBOOST_DOMAIN_THEME_LANG);
				                        else if ($amenity['name']=="Pets")
				                            $text_label_trans= __("Pets", IDXBOOST_DOMAIN_THEME_LANG);
				                        else if ($amenity['name']=="Furnished")
				                            $text_label_trans= __("Furnished", IDXBOOST_DOMAIN_THEME_LANG);
				                        else if ($amenity['name']=="Equestrian")
											$text_label_trans= __("Equestrian", IDXBOOST_DOMAIN_THEME_LANG);
										else if ($amenity['name'] == 'Boat Dock')
											$text_label_trans = 'Boat Dock';
										else if ($amenity['name'] == 'Short Sales')
											$text_label_trans = 'Short Sales';
										else if ($amenity['name'] == 'Foreclosures')
											$text_label_trans = 'Foreclosures';
				                        echo $text_label_trans; ?></label>
									</li>
									<?php endforeach; ?>
									</ul>
								</div>
							</div>
						</div>
					</li>
					<li class="action-filter">
						<button id="apply-filters-min"><?php echo __("Matching", IDXBOOST_DOMAIN_THEME_LANG); ?> <span id="fs_inner_c">0 </span> <?php echo __("Listings", IDXBOOST_DOMAIN_THEME_LANG); ?></button>
					</li>
					<button id="apply-filters"><span><?php echo __("Apply Filters", IDXBOOST_DOMAIN_THEME_LANG); ?></span></button>
				</ul>
			</div>
		</div>
		<div class="temporal-color-header"></div>
	</div>
</div>

<div id="wrap-subfilters" class="flex-loading-ct search-page-ft">
	<div class="gwr">
		<span id="title-subfilters"></span>
		<ul id="sub-filters">
			<li id="link-favorites"><a href="#" title="#" class="clidxboost-icon-favorite"><span><span><?php echo number_format($response_canti['count']); ?></span>Favorites</span></a></li>
			<li id="filter-by" class="clidxboost-icon-arrow-select">
			<span class="filter-text"><?php echo __("Highest Price", IDXBOOST_DOMAIN_THEME_LANG); ?></span>
			<select id="flex_filter_sort">

				<option value="list_date-desc" <?php selected($order, 'list_date-desc'); ?>><?php echo __("Newest Listings", IDXBOOST_DOMAIN_THEME_LANG); ?></option>
				<option value="price-desc" <?php selected($order, 'price-desc'); ?>><?php echo __("Highest Price", IDXBOOST_DOMAIN_THEME_LANG); ?></option>
				<option value="price-asc" <?php selected($order, 'price-asc'); ?>><?php echo __("Lowest Price", IDXBOOST_DOMAIN_THEME_LANG); ?></option>
				<?php /*<option value="bed-desc" <?php selected($order, 'bed-desc'); ?>>Beds (High to Low)</option>
				<option value="bed-asc" <?php selected($order, 'bed-asc'); ?>>Beds (Low to High)</option>*/ ?>
				<option value="sqft-desc" <?php selected($order, 'sqft-desc'); ?>><?php echo __("Highest Sq.Ft", IDXBOOST_DOMAIN_THEME_LANG); ?></option>
				<option value="sqft-asc" <?php selected($order, 'sqft-asc'); ?>><?php echo __("Lowest Sq.Ft", IDXBOOST_DOMAIN_THEME_LANG); ?></option>
				<?php /*
				<option value="year-desc" <?php selected($order, 'year-desc'); ?>>Year (High to Low)</option>
				<option value="year-asc" <?php selected($order, 'year-asc'); ?>>Year (Low to High)</option>*/ ?>
				<?php /*
				<option value="list_date-asc" <?php selected($order, 'list_date-asc'); ?>>Listing Date (Low to High)</option>
				<option value="status-desc" <?php selected($order, 'status-desc'); ?>>Pending</option> */ ?>
			</select>
			</li>
			<li id="filter-views" class="clidxboost-icon-arrow-select">
				<select>
					<option value="grid" <?php selected($default_view, 'grid'); ?>><?php echo __("Grid", IDXBOOST_DOMAIN_THEME_LANG); ?></option>
					<option value="list" <?php selected($default_view, 'list'); ?>><?php echo __("List", IDXBOOST_DOMAIN_THEME_LANG); ?></option>
					<option value="map" <?php selected($default_view, 'map'); ?>><?php echo __("Map", IDXBOOST_DOMAIN_THEME_LANG); ?></option>
				</select>
			</li>
		</ul><span id="info-subfilters"><span></span></span>
	</div>
</div>

<?php /*
<div id="flex-spinner-load">
	<div class="flex-spinner-content">
		<p><?php echo __("Loading Properties", IDXBOOST_DOMAIN_THEME_LANG); ?></p>
	</div>
</div>
*/ ?>

<section id="wrap-result" style="display:none;" class="flex-loading-ct view-<?php echo $default_view; ?>">
	<h2 class="title"><?php echo __("Search results", IDXBOOST_DOMAIN_THEME_LANG); ?></h2>
	<div class="gwr">
		<div id="wrap-list-result">
			<ul id="head-list">
				<li class="address"><?php echo __("Address", IDXBOOST_DOMAIN_THEME_LANG); ?></li>
				<li class="price"><?php echo __("Asking Price", IDXBOOST_DOMAIN_THEME_LANG); ?></li>
				<li class="pr">% / $</li>
				<li class="beds"><?php echo __("Beds", IDXBOOST_DOMAIN_THEME_LANG); ?></li>
				<li class="baths"><?php echo __("Baths", IDXBOOST_DOMAIN_THEME_LANG); ?></li>
				<li class="living-size"><?php echo __("Living Size", IDXBOOST_DOMAIN_THEME_LANG); ?></li>
				<li class="price-sf"><?php echo __("Price / SF", IDXBOOST_DOMAIN_THEME_LANG); ?> </li>
				<li class="development"><?php echo __("Development / Subdivision", IDXBOOST_DOMAIN_THEME_LANG); ?></li>
			</ul>
			<ul id="result-search" class="slider-generator"></ul>
			<span class="ib-loading-message">Updating results...</span>
<?php /*
	    <div class="message-alert info-color idx_color_primary" id="box_flex_alerts_msg" style="display:none;">
	      <p>Get email alerts for new properties matching this search <button id="flex_save_search_btn" data-modal="modal_save_search" class="show-modal save-btn create-alert-footer"><span>Create Alert</span></button></p>
	      <button class="close-message" id="hide_flex_alerts_msg">x</button>
	    </div>
			<nav id="nav-results" class="idx_color_second"></nav>
*/ ?>
		</div>
		<div id="wrap-map">
			<div id="wrap-map-draw-actions">
				<div>
					<p>Draw a shape around the region(s) you would like to live in</p>
				</div>
				<div class="flex-content-btn-draw">
					<button type="button" id="map-draw-cancel-tg">Cancel</button>
					<button type="button" id="map-draw-apply-tg">Apply</button>
				</div>
			</div>
			<div id="code-map"></div>
			<div id="map-actions">
				<button class="open-map"><?php echo __("Close", IDXBOOST_DOMAIN_THEME_LANG); ?></button>
				<button class="close-map hide"><?php echo __("Open", IDXBOOST_DOMAIN_THEME_LANG); ?></button>
			</div>
		</div>
	</div>

	<?php /*
	<div class="gwr">
		<div class="message-alert info-color idx_color_primary" id="box_flex_alerts_msg" style="display:none;">
			<p><?php echo __("Get email alerts for new properties matching this search", IDXBOOST_DOMAIN_THEME_LANG); ?> <button id="flex_save_search_btn" data-modal="modal_save_search" class="show-modal save-btn create-alert-footer"><span><?php echo __("Create Alert", IDXBOOST_DOMAIN_THEME_LANG); ?></span></button></p>
			<button class="close-message" id="hide_flex_alerts_msg">x</button>
		</div>
	</div> */ ?>

	<div id="paginator-cnt" class="gwr">
		<nav id="nav-results" class="idx_color_second"></nav>
	</div>
</section>

<?php /*
<div class="content-rsp-btn">
	<div class="idx-btn-content">
		<div class="idx-bg-group">
			<button data-modal="modal_save_search" id="save-button-responsive" class="idx-btn-act">
				<span><?php echo __("Save", IDXBOOST_DOMAIN_THEME_LANG); ?></span>
			</button>

			<button class="idx-btn-act" id="idx-bta-grid">
				<span>Grid</span>
			</button>

			<button class="idx-btn-act" id="idx-bta-list">
				<span>List</span>
			</button>

			<button class="idx-btn-act" id="idx-bta-map">
				<span>Map</span>
			</button>

			<button class="idx-btn-act" id="idx-bta-remove">
				<span>Remove<br>Boundaries</span>
			</button>
		</div>
	</div>
</div>
*/ ?>

</div>

<script type="text/javascript">
	var view_grid_type='', idxboost_view_type='';
	idxboost_view_type='<?php echo $default_view; ?>';
	<?php
	if (!empty($flex_idx_info['search']['default_view'])){
		if($flex_idx_info['search']['default_view']=='nmap'){ ?>
			jQuery('body').addClass('clidxboost-nmap view-map').find('#wrap-result').removeClass('view-grid view-list').addClass('view-map');

			jQuery(window).on("load resize",function(e){
				var widthWindows = jQuery(window).width();
				if(widthWindows > 1023){
					if (!jQuery('#content h1').hasClass('view-map')) {
						jQuery('body').removeClass('view-grid view-list').addClass('view-map').find('#wrap-result').removeClass('view-grid view-list').addClass('view-map');
					}
				}

			});
<?php
		}
	}

	$sta_view_grid_type='0'; if(array_key_exists('view_grid_type',$search_params)) $sta_view_grid_type=$search_params['view_grid_type']; ?>
	view_grid_type = <?php echo (int) $sta_view_grid_type; ?>;
	if ( !jQuery('body').hasClass('clidxboost-ngrid') && view_grid_type==1) {
		jQuery('body').addClass('clidxboost-ngrid');
	}
</script>

<script>
	jQuery(document).on('click', '.idx-btn-act', function() {
    var $cuerpo = jQuery('body');
    var $wrapResult = jQuery('#wrap-result');
    var $viewFilter = jQuery('#filter-views');
    jQuery("html, body").animate({ scrollTop: 0 }, 600);

    switch (jQuery(this).attr('id').split(' ')[0]){
      case 'idx-bta-grid':
        jQuery("#filter-views select").val("grid").trigger("change");
        $viewFilter.removeClass('list map').addClass('grid');
        $wrapResult.removeClass('view-list view-map').addClass('view-grid');
        $cuerpo.removeClass('view-list view-map view-grid').addClass('view-grid');
        break
      case 'idx-bta-list':
        jQuery("#filter-views select").val("list").trigger("change");
        $viewFilter.removeClass('grid map').addClass('list');
        $wrapResult.removeClass('view-grid view-map').addClass('view-list');
        $cuerpo.removeClass('view-list view-map view-grid').addClass('view-list');
        break
      case 'idx-bta-map':
        jQuery("#filter-views select").val("map").trigger("change");
        $viewFilter.removeClass('list grid').addClass('map');
        $wrapResult.removeClass('view-list view-grid').addClass('view-map');
        $cuerpo.removeClass('view-list view-map view-grid').addClass('view-map');
        break
    }
  });


	jQuery(".ib-btn-show").click(function() {
		jQuery(this).parents('.propertie').toggleClass('active-list');
	});
</script>