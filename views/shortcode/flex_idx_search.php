<style>
    .flex-breadcrumb { margin-bottom: 0 !important; }

    #footer { display: none !important; }

    .gwr {max-width: 100% !important;}

    .js-info-bubble-close { width: 30px; height: 30px; opacity: 0 !important; }

    .ib-search-marker-active .dgt-richmarker-single,
    .ib-search-marker-active .dgt-richmarker-group
    {
        background: rgb(255, 0, 72) !important;
    }

    .ib-search-marker-active .dgt-richmarker-group:after,
    .ib-search-marker-active .dgt-richmarker-single:after {
        border-top: 5px solid rgb(255, 0, 72) !important;
    }
    .ib-modal-filters-mobile {
        position: fixed !important;
    }

    /*@media (max-width: 989px) {
        .flex-map-controls-ct { display: none !important; }
    }*/


    .ui-autocomplete {
        max-height: 200px;
        overflow-y: auto;
        overflow-x: hidden;
    }
    .autocomplete-item-type {
        font-weight: bold;
        color: #c1c1c1;
        position: absolute;
        right: 0;
        top: 0;
        height: 40px;
        padding: 0 15px 0 15px;
        line-height: 40px;
        text-transform: capitalize;
    }
</style>

<?php 
$idx_contact_phone = isset($flex_idx_info['agent']['agent_contact_phone_number']) ? sanitize_text_field($flex_idx_info['agent']['agent_contact_phone_number']) : '';

                $c_search_settings = get_option("idxboost_search_settings");
                
                $label_waterfront_description = __('Waterfront Description', IDXBOOST_DOMAIN_THEME_LANG);
                if (isset($c_search_settings["board_id"]) && ("11" == $c_search_settings["board_id"])){
                  $label_waterfront_description = __("View Description", IDXBOOST_DOMAIN_THEME_LANG);
                }elseif (isset($c_search_settings["board_id"]) && ("16" == $c_search_settings["board_id"])){
                  $label_waterfront_description = __("View Features", IDXBOOST_DOMAIN_THEME_LANG);
                }
                ?>

<form id="flex_idx_search_filter_form" method="post">
    <input type="hidden" name="sale_type" value="">
    <input type="hidden" name="property_type" value="">
    <input type="hidden" name="filter_search_keyword_label" value="">
    <input type="hidden" name="filter_search_keyword_type" value="">
    <input type="hidden" name="waterfront_options" value="">

    <input type="hidden" name="polygon_search" value="">
    <input type="hidden" name="rect" value="<?php echo isset($_GET["rect"]) ? sanitize_text_field($_GET["rect"]) : ''; ?>">
    <input type="hidden" name="zm" value="<?php echo isset($_GET["zm"]) ? sanitize_text_field($_GET["zm"]) : ''; ?>">

    <input type="hidden" name="parking_options" value="">
    <input type="hidden" name="amenities" value="">

    <input type="hidden" name="min_sale_price" value="">
    <input type="hidden" name="max_sale_price" value="">

    <input type="hidden" name="min_rent_price" value="">
    <input type="hidden" name="max_rent_price" value="">

    <input type="hidden" name="min_beds" value="">
    <input type="hidden" name="max_beds" value="">

    <input type="hidden" name="min_baths" value="">
    <input type="hidden" name="max_baths" value="">

    <input type="hidden" name="min_living_size" value="">
    <input type="hidden" name="max_living_size" value="">

    <input type="hidden" name="min_lot_size" value="">
    <input type="hidden" name="max_lot_size" value="">

    <input type="hidden" name="min_year" value="">
    <input type="hidden" name="max_year" value="">

    <input type="hidden" name="sort_type" value="">
    <input type="hidden" name="page" value="">
</form>

<?php include FLEX_IDX_PATH . '/views/shortcode/flex_idx_search_filter_bar.php';  ?>

<div id="flex_idx_search_filter" class="ib-mapgrid-container ib-vgrid-active">
	<div class="content-rsp-btn">
		<div class="idx-btn-content">
			<div class="idx-bg-group">
				<button data-modal="modal_save_search" class="idx-btn-act save-button-responsive" aria-label="<?php echo __("Save", IDXBOOST_DOMAIN_THEME_LANG); ?>">
					<span><?php echo __("Save", IDXBOOST_DOMAIN_THEME_LANG); ?></span>
				</button>

				<button class="idx-btn-act idx-bta-grid" aria-label="<?php echo __("Grid", IDXBOOST_DOMAIN_THEME_LANG); ?>">
					<span><?php echo __("Grid", IDXBOOST_DOMAIN_THEME_LANG); ?></span>
				</button>

				<button class="idx-btn-act idx-bta-map" aria-label="<?php echo __("Map", IDXBOOST_DOMAIN_THEME_LANG); ?>">
					<span><?php echo __("Map", IDXBOOST_DOMAIN_THEME_LANG); ?></span>
				</button>

				<button class="idx-btn-act ib-show ib-removeb-tg ib-removeb-hide" aria-label="<?php echo __("Remove", IDXBOOST_DOMAIN_THEME_LANG); ?>">
					<span><?php echo __("Remove", IDXBOOST_DOMAIN_THEME_LANG); ?> <br> <?php echo __("Boundaries", IDXBOOST_DOMAIN_THEME_LANG); ?></span>
				</button>
			</div>
		</div>
	</div>
	<div class="ib-wmap">
		<div id="wrap-map-draw-actions" style="display:none;">
			<div>
				<p><?php echo __("Draw a shape around the region(s) you would like to live in", IDXBOOST_DOMAIN_THEME_LANG); ?></p>
			</div>
			<div class="flex-content-btn-draw">
				<button type="button" id="map-draw-cancel-tg"><?php echo __("Cancel", IDXBOOST_DOMAIN_THEME_LANG); ?></button>
				<button type="button" id="map-draw-apply-tg"><?php echo __("Apply", IDXBOOST_DOMAIN_THEME_LANG); ?></button>
			</div>
		</div>
		<div id="flex_idx_search_filter_map"></div>
		<?php /*
		<div class="content-rsp-btn">
			<div class="idx-btn-content">
				<div class="idx-bg-group">
					<button data-modal="modal_save_search" class="idx-btn-act save-button-responsive">
						<span><?php echo __("Save", IDXBOOST_DOMAIN_THEME_LANG); ?></span>
					</button>

					<button class="idx-btn-act idx-bta-grid">
						<span><?php echo __("Grid", IDXBOOST_DOMAIN_THEME_LANG); ?></span>
					</button>

					<button class="idx-btn-act idx-bta-map">
						<span><?php echo __("Map", IDXBOOST_DOMAIN_THEME_LANG); ?></span>
					</button>

					<button class="idx-btn-act ib-show ib-removeb-tg ib-removeb-hide">
						<span><?php echo __("Remove", IDXBOOST_DOMAIN_THEME_LANG); ?> <br> <?php echo __("Boundaries", IDXBOOST_DOMAIN_THEME_LANG); ?></span>
					</button>
				</div>
			</div>
		</div>
		*/ ?>
	</div>
	<div class="ib-wgrid">
		<div class="ib-gheader">
			<div class="ib-ghpa">
				<span class="ib-ghtypes ib-heading-ct">...</span>
				<div class="ib-gmfilters">
					<div class="ib-gwsort">
						<label class="ms-hidden" for="ib-gsort-b"><?php echo __('Select option', IDXBOOST_DOMAIN_THEME_LANG); ?></label>
						<select class="ib-gsort ib-sort-ctrl" id="ib-gsort-b">
							<option value="list_date-desc"><?php echo __('Newest Listings', IDXBOOST_DOMAIN_THEME_LANG); ?></option>
							<option value="price-desc"><?php echo __('Highest Price', IDXBOOST_DOMAIN_THEME_LANG); ?></option>
							<option value="price-asc"><?php echo __('Lowest Price', IDXBOOST_DOMAIN_THEME_LANG); ?></option>
							<option value="sqft-desc"><?php echo __('Highest Sq.Ft', IDXBOOST_DOMAIN_THEME_LANG); ?></option>
							<option value="sqft-asc"><?php echo __('Lowest Sq.Ft', IDXBOOST_DOMAIN_THEME_LANG); ?></option>
						</select>
					</div>
				</div>
			</div>
		</div>

		<div class="ib-gnopro">
			<span class="ib-gnpno"><?php echo __('No matching results...', IDXBOOST_DOMAIN_THEME_LANG); ?></span><?php echo __('Modify your', IDXBOOST_DOMAIN_THEME_LANG); ?> <span class="ib-gnpoall"><?php echo __('filter', IDXBOOST_DOMAIN_THEME_LANG); ?></span> <?php echo __('preferences to get new results or', IDXBOOST_DOMAIN_THEME_LANG); ?> <span class="ib-gnpclear"><?php echo __('clear', IDXBOOST_DOMAIN_THEME_LANG); ?></span> <?php echo __('your search.', IDXBOOST_DOMAIN_THEME_LANG); ?>
		</div>
		
		<div class="ib-cproperties">
			<div class="ib-wproperties">
				<ul class="ib-lproperties ib-listings-ct"></ul>
			</div>
			<div class="ib-cpagination">
				<nav class="ib-wpagination ib-pagination-ctrl"></nav>
			</div>
		</div>

		<?php if (in_array($flex_idx_info["board_id"], [13,14])) { ?>
			    
			<div class="ib-bdisclaimer">
				<?php
					if ( is_array($flex_idx_info) && 
						array_key_exists("board_info", $flex_idx_info) && 
						array_key_exists("board_logo_url", $flex_idx_info["board_info"]) && 
						!empty($flex_idx_info["board_info"]["board_logo_url"]) && 
						$flex_idx_info["board_info"]["board_logo_url"] !="" ) {
							?>
				<div class="ms-logo-board">
					<img src="<?php echo $flex_idx_info["board_info"]["board_logo_url"]; ?>">
				</div>				
					<?php } ?>
				<?php 
				if (isset($flex_idx_info["board_id"]) && ("7" == $flex_idx_info["board_id"])){ ?>
				<p>The multiple listing information is provided by the Houston Association of Realtors from a copyrighted compilation of listings. The compilation of listings and each individual listing are &copy;<?php echo date('Y'); ?>-present TEXAS All Rights Reserved. The information provided is for consumers' personal, noncommercial use and may not be used for any purpose other than to identify prospective properties consumers may be interested in purchasing. All properties are subject to prior sale or withdrawal. All information provided is deemed reliable but is not guaranteed accurate, and should be independently verified. Listing courtesy of: <span class="ib-bdcourtesy">{{office_name}}</span></p>
				<?php }else{ 
					if ( is_array($flex_idx_info) && 
						array_key_exists("board_info", $flex_idx_info) && 
						array_key_exists("board_disclaimer", $flex_idx_info["board_info"]) && 
						!empty($flex_idx_info["board_info"]["board_disclaimer"]) ) {
							?>
						<p><?php echo $flex_idx_info["board_info"]["board_disclaimer"]; ?></p>	
					<?php } ?>
				<?php } ?>
				<p>Real Estate IDX Powered by: <a href="https://www.tremgroup.com" title="TREMGROUP" rel="nofollow" target="_blank">TREMGROUP</a></p>
			</div>
		<?php } ?>
	</div>
</div>

<?php
/*
<div id="flex_idx_search_filter_tooltip" class="flex_idx_search_filter_tooltip"><?php echo __('Click to see all homes', IDXBOOST_DOMAIN_THEME_LANG); ?></div>
*/
?>

<!-- modal property html -->
<div id="flex_idx_modal_wrapper"></div>

<!-- modal actions
<div class="ib-modal-master" data-id="calculator" id="ib-mortage-calculator">
	<div class="ib-mmcontent">
		<div class="ib-mwrapper ib-mgeneric">
			<div class="ib-mgheader">
				<h4 class="ib-mghtitle"><?php echo __('Estimated Monthly Payment', IDXBOOST_DOMAIN_THEME_LANG); ?></h4>
			</div>
			<div class="ib-mgcontent">
				<?php echo __("Let's us know the best time for showing.", IDXBOOST_DOMAIN_THEME_LANG); ?> <a href="tel:<?php echo preg_replace('/[^\d]/', '', $flex_idx_info['agent']['agent_contact_phone_number']); ?>" title="Call Us <?php echo flex_agent_format_phone_number(preg_replace('/[^\d]/', '', $flex_idx_info['agent']['agent_contact_phone_number'])); ?>"><?php echo flex_agent_format_phone_number(preg_replace('/[^\d]/', '', $flex_idx_info['agent']['agent_contact_phone_number'])); ?></a>
				<div class="mb-mcform">
					<form method="post" class="ib-property-mortgage-f">
						<ul class="ib-mcinputs">
							<li class="ib-mcitem"><span class="ib-mgitxt"><?php echo __('Purchase Price', IDXBOOST_DOMAIN_THEME_LANG); ?></span>
								<div class="ib-mgiwrapper">
									<label class="ms-hidden" for="ib-property-mc-pp"><?php echo __('Purchase Price', IDXBOOST_DOMAIN_THEME_LANG); ?></label>
									<input id="ib-property-mc-pp" class="ib-mcipurchase ib-property-mc-pp" value="" type="text" readonly>
								</div>
							</li>
							<li class="ib-mcitem"><span class="ib-mgitxt"><?php echo __('% Down Payment', IDXBOOST_DOMAIN_THEME_LANG); ?></span>
								<div class="ib-mgiwrapper">
									<label class="ms-hidden" for="ib-property-mc-dp"><?php echo __('% Down Payment', IDXBOOST_DOMAIN_THEME_LANG); ?></label>
									<input class="ib-mcidpayment ib-property-mc-dp" value="30" step="any" type="number" max="95" min="0">
								</div>
							</li>
							<li class="ib-mcitem"><span class="ib-mgitxt"><?php echo __('Term', IDXBOOST_DOMAIN_THEME_LANG); ?></span>
								<div class="ib-mgiwrapper ib-mgwselect">
									<label class="ms-hidden" for="ib-property-mc-ty"><?php echo __('Select year', IDXBOOST_DOMAIN_THEME_LANG); ?></label>
									<select class="ib-mcsyears ib-property-mc-ty" id="ib-property-mc-ty">
										<option value="30"><?php echo __('30 Years', IDXBOOST_DOMAIN_THEME_LANG); ?></option>
										<option value="15"><?php echo __('15 Years', IDXBOOST_DOMAIN_THEME_LANG); ?></option>
									</select>
								</div>
							</li>
							<li class="ib-mcitem"><span class="ib-mgitxt"><?php echo __('Interest Rate', IDXBOOST_DOMAIN_THEME_LANG); ?></span>
								<div class="ib-mgiwrapper">
									<label class="ms-hidden" for="ib-property-mc-ir"><?php echo __('Interest Rate', IDXBOOST_DOMAIN_THEME_LANG); ?></label>
									<input class="ib-mcidpayment ib-property-mc-ir" value="4" step="any" type="number" max="95" min="0">
								</div>
							</li>
						</ul>
						<button type="button" class="ib-mgsubmit ib-property-mortage-submit"><?php echo __('Calculate', IDXBOOST_DOMAIN_THEME_LANG); ?></button>
					</form>
				</div>
				<div class="mb-mcdata">
					<h5 class="ib-mcsubtitle"><?php echo __('Mortgage Breakdown', IDXBOOST_DOMAIN_THEME_LANG); ?></h5>
					<ul class="ib-mcdlist">
						<li class="ib-mcditem"><span class="ib-mcditxt"><?php echo __('Mortgage Amount', IDXBOOST_DOMAIN_THEME_LANG); ?></span><span class="ib-mcdinumbers ib-calc-mc-mortgage"></span></li>
						<li class="ib-mcditem"><span class="ib-mcditxt"><?php echo __('Down Payment Amount', IDXBOOST_DOMAIN_THEME_LANG); ?></span><span class="ib-mcdinumbers ib-calc-mc-down-payment"></span></li>
						<li class="ib-mcditem ib-mcdibig"><span class="ib-mcditxt"><?php echo __('Monthly Amount', IDXBOOST_DOMAIN_THEME_LANG); ?></span><span class="ib-mcdinumbers ib-calc-mc-monthly"></span></li>
						<li class="ib-mcditem ib-mcdibig">
							<div class="ib-mcditxt"><?php echo __('Total Monthly Amount', IDXBOOST_DOMAIN_THEME_LANG); ?> <span class="ib-mcdibold"><?php echo __('(Principal &amp; Interest, and PMI)', IDXBOOST_DOMAIN_THEME_LANG); ?></span></div><span class="ib-mcdinumbers ib-calc-mc-totalmonthly"></span>
						</li>
					</ul>
				</div>
			</div>
		</div>
		<div class="ib-mmclose"><span class="ib-mmctxt"><?php echo __('Close', IDXBOOST_DOMAIN_THEME_LANG); ?></span></div>
	</div>
	<div class="ib-mmbg"></div>
</div> -->

<div class="ib-modal-master" data-id="calculator" id="ib-mortage-calculator">
  <div class="ib-mmcontent">
    <div class="ib-mwrapper ib-mgeneric">
      <div class="ib-mgheader">
        <h4 class="ib-mghtitle"><?php echo __('Estimated Monthly Payment', IDXBOOST_DOMAIN_THEME_LANG); ?></h4>
      </div>
      <div class="ib-mg-detail">
        <p style="margin-top: 0;"><?php echo __('Monthly Amount', IDXBOOST_DOMAIN_THEME_LANG); ?></p>
        <span class="ib-price-mont ib-mcdinumbers ib-calc-mc-monthly"></span>
        <div id="chart-container"></div>
        <p><?php echo __('Estimate includes principal and interest, taxes and insurance.', IDXBOOST_DOMAIN_THEME_LANG); ?></p>
      </div>
      <div class="ib-mgcontent">
        <div class="mb-mcform">
          <form method="post" class="ib-property-mortgage-f">
            <ul class="ib-mcinputs">
              <li class="ib-mcitem"><span class="ib-mgitxt"><?php echo __('Purchase Price', IDXBOOST_DOMAIN_THEME_LANG); ?></span>
                <div class="ib-mgiwrapper ib-property-mc-pp">
                  <label class="ms-hidden" for="ib-property-mc-pp"><?php echo __('Purchase Price', IDXBOOST_DOMAIN_THEME_LANG); ?></label>
                  <input id="ib-property-mc-pp" class="ib-mcipurchase ib-property-mc-pp" value="" type="text" readonly>
                </div>
              </li>
              <li class="ib-mcitem"><span class="ib-mgitxt"><?php echo __('Down Payment (%)', IDXBOOST_DOMAIN_THEME_LANG); ?></span>
                <div class="ib-mgiwrapper">
                  <label class="ms-hidden" for="ib-property-mc-dp"><?php echo __('Down Payment (%)', IDXBOOST_DOMAIN_THEME_LANG); ?></label>
                  <input class="ib-mcidpayment ib-property-mc-dp" value="30" step="any" type="number" max="95" min="0">
                </div>
              </li>
              <li class="ib-mcitem"><span class="ib-mgitxt"><?php echo __('Term', IDXBOOST_DOMAIN_THEME_LANG); ?> (<?php echo __('Years', IDXBOOST_DOMAIN_THEME_LANG); ?>)</span>
                <div class="ib-mgiwrapper ib-mgwselect">
                  <label class="ms-hidden" for="ib-property-mc-ty"><?php echo __('Select year', IDXBOOST_DOMAIN_THEME_LANG); ?></label>
                  <select class="ib-mcsyears ib-property-mc-ty" id="ib-property-mc-ty">
                    <option value="30"><?php echo __('30', IDXBOOST_DOMAIN_THEME_LANG); ?></option>
                    <option value="15"><?php echo __('15', IDXBOOST_DOMAIN_THEME_LANG); ?></option>
                  </select>
                </div>
              </li>
              <li class="ib-mcitem"><span class="ib-mgitxt"><?php echo __('Interest Rate (%)', IDXBOOST_DOMAIN_THEME_LANG); ?></span>
                <div class="ib-mgiwrapper">
                  <label class="ms-hidden" for="ib-property-mc-ir"><?php echo __('Interest Rate (%)', IDXBOOST_DOMAIN_THEME_LANG); ?></label>
                  <input class="ib-mcidpayment ib-property-mc-ir" value="4" step="any" type="number" max="95" min="0">
                </div>
              </li>
            </ul>
            <button type="button" class="ib-mgsubmit ib-property-mortage-submit"><?php echo __('Calculate', IDXBOOST_DOMAIN_THEME_LANG); ?></button>
          </form>
        </div>
        <div class="mb-mcdata">
          <!--<ul class="ib-mcdlist">
            <li class="ib-mcditem"><span class="ib-mcditxt">Mortgage Amount</span><span class="ib-mcdinumbers ib-calc-mc-mortgage">$185,500</span></li>
            <li class="ib-mcditem"><span class="ib-mcditxt">Down Payment Amount</span><span class="ib-mcdinumbers ib-calc-mc-down-payment">$79,500</span></li>
            <li class="ib-mcditem ib-mcdibig"><span class="ib-mcditxt">Monthly Amount</span><span class="ib-mcdinumbers ib-calc-mc-monthly">$885.61</span></li>
            <li class="ib-mcditem ib-mcdibig">
              <div class="ib-mcditxt">Total Monthly Amount <span class="ib-mcdibold">(Principal &amp; Interest, and PMI)</span></div><span class="ib-mcdinumbers ib-calc-mc-totalmonthly">$885.61</span>
            </li>
            </ul>-->
          <p><?php echo __("Let's us know the best time for showing.", IDXBOOST_DOMAIN_THEME_LANG); ?> <a href="tel:<?php echo preg_replace('/[^\d]/', '', $flex_idx_info['agent']['agent_contact_phone_number']); ?>" title="Call Us <?php echo flex_agent_format_phone_number(preg_replace('/[^\d]/', '', $flex_idx_info['agent']['agent_contact_phone_number'])); ?>"><?php echo flex_agent_format_phone_number(preg_replace('/[^\d]/', '', $flex_idx_info['agent']['agent_contact_phone_number'])); ?></a></p>
        </div>
      </div>
      <div class="ib-img-calculator"></div>
    </div>
    <div class="ib-mmclose"><span class="ib-mmctxt">Close</span></div>
  </div>
  <div class="ib-mmbg"></div>
</div>

<div class="ib-modal-master" data-id="email-to-friend" id="ib-email-to-friend">
    <div class="ib-mmcontent">
        <div class="ib-mwrapper ib-mgeneric">
            <div class="ib-mgheader">
                <h4 class="ib-mghtitle"><?php echo __('Email to a friend', IDXBOOST_DOMAIN_THEME_LANG); ?></h4>
            </div>
            <form method="post" class="ib-property-share-friend-f iboost-secured-recaptcha-form">
                <input type="hidden" name="mls_number" class="ib-property-share-mls-num" value="">
                <input type="hidden" name="status" class="ib-property-share-property-status" value="">

				<div class="ib-mgcontent"><?php echo __('Recommend this to a friend, just enter their email below.', IDXBOOST_DOMAIN_THEME_LANG); ?>
					<div class="ib-meblock"><span class="ib-mgitxt"><?php echo __('Friend&#039s Information', IDXBOOST_DOMAIN_THEME_LANG); ?></span>
						<div class="ib-mgiwrapper">
							<label class="ms-hidden" for="friend_email"><?php echo __('Friend&#039s Email*', IDXBOOST_DOMAIN_THEME_LANG); ?></label>
							<input id="friend_email" class="ib-meinput" name="friend_email" type="email" placeholder="<?php echo __('Friend&#039s Email*', IDXBOOST_DOMAIN_THEME_LANG); ?>" value="" required>
						</div>
						<div class="ib-mgiwrapper">
							<label class="ms-hidden" for="friend_name"><?php echo __('Friend&#039s Name*', IDXBOOST_DOMAIN_THEME_LANG); ?></label>
							<input id="friend_name" class="ib-meinput" name="friend_name" type="text" placeholder="<?php echo __('Friend&#039s Name*', IDXBOOST_DOMAIN_THEME_LANG); ?>" value="" required>
						</div>
					</div>
					<div class="ib-meblock"><span class="ib-mgitxt"><?php echo __('Your Information', IDXBOOST_DOMAIN_THEME_LANG); ?></span>
						<div class="ib-mgiwrapper">
							<label class="ms-hidden" for="_sf_name"><?php echo __('Your Name*', IDXBOOST_DOMAIN_THEME_LANG); ?></label>
							<input class="ib-meinput" id="_sf_name" name="your_name" type="text" placeholder="<?php echo __('Your Name*', IDXBOOST_DOMAIN_THEME_LANG); ?>" value="" required>
						</div>
						<div class="ib-mgiwrapper">
							<label class="ms-hidden" for="_sf_email"><?php echo __('Your Email*', IDXBOOST_DOMAIN_THEME_LANG); ?></label>
							<input class="ib-meinput" id="_sf_email" name="your_email" type="email" placeholder="<?php echo __('Your Email*', IDXBOOST_DOMAIN_THEME_LANG); ?>" value="" required>
						</div>
						<div class="ib-mgiwrapper ib-mgtextarea">
							<textarea class="ib-metextarea" name="comments" type="text" placeholder="<?php echo __('Comments*', IDXBOOST_DOMAIN_THEME_LANG); ?>" required></textarea>
						</div>
					</div>
					<span class="ib-merequired"><?php echo __('* Required fields', IDXBOOST_DOMAIN_THEME_LANG); ?></span>
					<button type="submit" class="ib-mgsubmit"><?php echo __('Submit', IDXBOOST_DOMAIN_THEME_LANG); ?></button>
				</div>
			</form>
		</div>
		<div class="ib-mmclose" role="button" aria-label="<?php echo __('Close', IDXBOOST_DOMAIN_THEME_LANG); ?>"><span class="ib-mmctxt"><?php echo __('Close', IDXBOOST_DOMAIN_THEME_LANG); ?></span></div>
	</div>
	<div class="ib-mmbg"></div>
</div>

<div class="ib-modal-master" data-id="submit" id="ib-email-thankyou">
	<div class="ib-mmcontent">
		<div class="ib-mgeneric ib-msubmit"><span class="ib-mssent ib-mstxt ib-icon-check"><?php echo __('Email Sent!', IDXBOOST_DOMAIN_THEME_LANG); ?> </span><span class="ib-mssucces ib-mstxt"><?php echo __('Your email was sent succesfully', IDXBOOST_DOMAIN_THEME_LANG); ?></span></div>
		<button class="ib-mmclose" aria-label="<?php echo __('Close', IDXBOOST_DOMAIN_THEME_LANG); ?>"><span class="ib-mmctxt"><?php echo __('Close', IDXBOOST_DOMAIN_THEME_LANG); ?></span></button>
	</div>
	<div class="ib-mmbg"></div>
</div>

<div class="ib-modal-master" data-id="save-search" id="ib-fsearch-save-modal">
	<div class="ib-mmcontent">
		<div class="ib-mwrapper ib-mgeneric">
			<div class="ib-mgheader">
				<h4 class="ib-mghtitle"><?php echo __('Save this search', IDXBOOST_DOMAIN_THEME_LANG); ?></h4>
			</div>
			<div class="ib-mgcontent">
				<form method="post" class="flex-save-search-modals">
					<ul class="ib-msavesearch">
						<li class="ib-mssitem"><span class="ib-mssitxt"><?php echo __('Search Name(*)', IDXBOOST_DOMAIN_THEME_LANG); ?></span>
							<div class="ib-mgiwrapper">
								<label class="ms-hidden" for="search_name"><?php echo __('Search Name', IDXBOOST_DOMAIN_THEME_LANG); ?></label>
								<input id="search_name" name="search_name" class="ib-mssinput ib-name_search" type="text" placeholder="<?php echo __('Save Search', IDXBOOST_DOMAIN_THEME_LANG); ?>*">
							</div>
						</li>
						<li class="ib-mssitem"><span class="ib-mssitxt"><?php echo __('Email Updates', IDXBOOST_DOMAIN_THEME_LANG); ?></span>
							<div class="ib-mgiwrapper ib-mgwselect">
								<label class="ms-hidden" for="notification_day"><?php echo __('Email Updates', IDXBOOST_DOMAIN_THEME_LANG); ?></label>
								<select class="ib-mssselect" name="notification_day" id="notification_day">
									<option value="--"><?php echo __('No Alert', IDXBOOST_DOMAIN_THEME_LANG); ?></option>
									<option value="1" selected=""><?php echo __('Daily', IDXBOOST_DOMAIN_THEME_LANG); ?></option>
									<option value="7"><?php echo __('Weekly', IDXBOOST_DOMAIN_THEME_LANG); ?></option>
									<option value="30"><?php echo __('Monthly', IDXBOOST_DOMAIN_THEME_LANG); ?></option>
								</select>
							</div>
						</li>
						<li class="ib-mssitem"><span class="ib-mssitxt"><?php echo __('Only Update me On', IDXBOOST_DOMAIN_THEME_LANG); ?></span>
							<ul class="ib-mssupdate">
								<li class="ib-mssuitem">
									<input class="ib-msscheckbox" type="checkbox" id="ib-check-new-listing" name="notification_type[]" value="new_listing" checked>
									<label class="ib-msslabel" for="ib-check-new-listing"><?php echo __('New Listing (Always)', IDXBOOST_DOMAIN_THEME_LANG); ?></label>
								</li>
								<li class="ib-mssuitem">
									<input class="ib-msscheckbox" type="checkbox" id="ib-check-price-change" name="notification_type[]" value="price_change" checked>
									<label class="ib-msslabel" for="ib-check-price-change"><?php echo __('Price Change', IDXBOOST_DOMAIN_THEME_LANG); ?></label>
								</li>
								<li class="ib-mssuitem">
									<input class="ib-msscheckbox" type="checkbox" id="ib-check-status-change" name="notification_type[]" value="status_change" checked>
									<label class="ib-msslabel" for="ib-check-status-change"><?php echo __('Status Change', IDXBOOST_DOMAIN_THEME_LANG); ?></label>
								</li>
							</ul>
						</li>
					</ul>
					<button class="ib-mgsubmit"><?php echo __('Save Search', IDXBOOST_DOMAIN_THEME_LANG); ?></button>
					<input type="hidden" name="action" value="idxboost_new_filter_save_search_xhr_fn">
				</form>
			</div>
		</div>
		<div class="ib-mmclose" role="button" aria-label="<?php echo __('Close', IDXBOOST_DOMAIN_THEME_LANG); ?>"><span class="ib-mmctxt"><?php echo __('Close', IDXBOOST_DOMAIN_THEME_LANG); ?></span></div>
	</div>
	<div class="ib-mmbg"></div>
</div>

<script id="ib-modal-template" type="text/x-handlebars-template">
<div class="ib-modal-master ib-mmpd ib-md-active">
      <div class="ib-mmcontent">
        <article class="ib-property-detail ib-pdmodal">
          <div class="ib-pcheader">
            <div class="ib-pwheader">
              <header class="ib-pheader">
                <h2 class="ib-ptitle">{{address_short}}</h2><span class="ib-pstitle">{{address_large}}</span>
              </header>
              <div class="ib-phcta">
                <div class="ib-phomodal">
                  <a href="tel:<?php echo $idx_contact_phone; ?>" class="ib-pbtnphone">{{agentPhone this}}</a>
                  <div class="ib-requestinfo ib-phbtn"><?php echo __("Inquire", IDXBOOST_DOMAIN_THEME_LANG); ?></div>
                  <div class="ib-pbtnopen ib-phbtn" data-permalink="{{ propertyPermalink slug }}"><?php echo __("Open", IDXBOOST_DOMAIN_THEME_LANG); ?></div>
                  <div class="ib-pbtnclose ib-phbtn"><?php echo __("Close", IDXBOOST_DOMAIN_THEME_LANG); ?></div>
                </div>
              </div>
            </div>
          </div>
          <div class="ib-pcontent">
            <div class="ib-pviews {{ markClassActiveTab this }}">
              <div class="ib-pvwcta">
                <ul class="ib-pvcta">
                  <li class="ib-pvitem {{ markPhotosActive this }}" data-id="photos"><?php echo __("Photos", IDXBOOST_DOMAIN_THEME_LANG); ?></li>
                  <li class="ib-pvitem {{ markMapActive this }}" data-id="map" data-loaded="no" data-lat="{{lat}}" data-lng="{{lng}}" data-><?php echo __("Map View", IDXBOOST_DOMAIN_THEME_LANG); ?></li>
                  {{#if virtual_tour}}
                  <li class="ib-pvitem" data-id="video">
                      <a class="ib-plvideo" href="{{virtual_tour}}" title="Video" target="_blank"><?php echo __("Video", IDXBOOST_DOMAIN_THEME_LANG); ?></a>
                  </li>
                  {{/if}}
                </ul>
                <div class="ib-btnfs"></div>
              </div>
              <div class="ib-pvlist">
                <div class="ib-pvphotos ib-pvlitem">
                  <div class="ib-pvslider gs-container-slider">
                      {{{ idxSliderLoop this }}}
                  </div>
                </div>
                <div class="ib-pvmap">
                  <div class="ib-pmap"></div>
                </div>

              {{#if oh_bool }}
                  <div class="ms-open">
                    <span class="ms-wrap-open">
                      <span class="ms-open-title"><?php echo __('Open House', IDXBOOST_DOMAIN_THEME_LANG); ?></span>    
                      <span class="ms-open-date">{{oh_info_parce_date}}</span>
                      <span class="ms-open-time">{{oh_info_parce_timer}}</span>
                    </span>
                  </div>
                {{/if}}

              </div>
            </div>

            <div class="ib-pbia">
              <div class="ib-pwinfo">
                <div class="ib-pinfo">
                  <div class="ib-pilf">
                    
                                 <ul class="ib-pilist">
                                    <li class="ib-pilitem ib-pilprice">
                                      <span class="ib-pipn">{{price}}{{ isRentalType this }}</span>
                                      <div class="ib-pipasking">
                                        <!--<div class="ib-pipatxt -pc"><?php echo __("Asking Price", IDXBOOST_DOMAIN_THEME_LANG); ?> <span>{{{ idxReduced reduced }}}</span></div>-->
                                        <div class="ib-pipatxt -mobile js-est-payment"><?php echo __("Est. Payment", IDXBOOST_DOMAIN_THEME_LANG); ?><button class="ib-price-calculator"></button></div>
                                      </div>
                                    </li>
                                    <li class="ib-pilitem ib-pilbeds"><span class="ib-pilnumber">{{bed}}</span><span class="ib-piltxt"><?php echo __("Bedroom(s)", IDXBOOST_DOMAIN_THEME_LANG); ?></span> <span class="ib-piltxt -min"><?php echo __("Beds(s)", IDXBOOST_DOMAIN_THEME_LANG); ?></span></li>
                                    <li class="ib-pilitem ib-pilbaths"><span class="ib-pilnumber">{{bath}}</span><span class="ib-piltxt"><?php echo __("Bathroom(s)", IDXBOOST_DOMAIN_THEME_LANG); ?></span> <span class="ib-piltxt -min"><?php echo __("Baths(s)", IDXBOOST_DOMAIN_THEME_LANG); ?></span></li>
                                    <li class="ib-pilitem ib-pilhbaths ms-hidden-mb"><span class="ib-pilnumber">{{baths_half}}</span><span class="ib-piltxt"><?php echo __("Half Bath(s)", IDXBOOST_DOMAIN_THEME_LANG); ?></span> <span class="ib-piltxt -min"><?php echo __("Half Bath(s)", IDXBOOST_DOMAIN_THEME_LANG); ?></span></li>
                                    <li class="ib-pilitem ib-pilsize"><span class="ib-pilnumber">{{sqft}}</span><span class="ib-piltxt"><?php echo __("Size sqft", IDXBOOST_DOMAIN_THEME_LANG); ?></span> <span class="ib-piltxt -min"><?php echo __("Sqft", IDXBOOST_DOMAIN_THEME_LANG); ?></span></li>
                                    <li class="ib-pilitem ib-pilsize ms-hidden-pc"><span class="ib-pilnumber">{{price_sqft}}</span><span class="ib-piltxt"><?php echo __("$/Sqft", IDXBOOST_DOMAIN_THEME_LANG); ?></span> <span class="ib-piltxt -min"><?php echo __("$/Sq.Ft", IDXBOOST_DOMAIN_THEME_LANG); ?></span></li>
                                 </ul>

                                 <div class="ib-pfavorite {{ idxFavoriteClass this }}" data-mls="{{mls_num}}" data-token-alert="{{token_alert}}">
                                    <div class="ib-pftxt">{{ idxFavoriteText this }}</div>
                                    <div class="ib-pftxt -text-min">Save</div>
                                  </div>
                  </div>

                              <ul class="ib-psc">
                                 <li class="ib-pscitem ib-pshared">
                                    <div class="ib-psbtn"><span class="ib-pstxt"><?php echo __("Share", IDXBOOST_DOMAIN_THEME_LANG); ?></span></div>
                                    <div class="ib-plsocials">
                                       <a class="ib-plsitem ib-plsifb" href="{{ propertyPermalink slug }}"><span class="ib-plsitxt">Facebook</span></a>
                                       <a class="ib-plsitem ib-plsitw" href="{{ propertyPermalink slug }}" data-address="{{ address_short }} {{ address_large}}" data-price="{{price}}" data-type="{{class_id}}" data-rental="{{is_rental}}" data-mls="{{mls_num}}"><span class="ib-plsitxt">Twitter</span></a>
                                    </div>
                                 </li>
                                 <li class="ib-pscitem ib-pscalculator" data-price="{{price}}">
                                    <button class="ib-psbtn" aria-label="Mortgage"><span class="ib-pstxt"><?php echo __("Mortgage", IDXBOOST_DOMAIN_THEME_LANG); ?></span></button>
                                 </li>
                                 <li class="ib-pscitem ib-psemailfriend" data-status="{{status_type}}" data-mls="{{mls_num}}" data-permalink="">
                                    <button class="ib-psbtn" aria-label="Email to a friend"><span class="ib-pstxt"><?php echo __("Email to a friend", IDXBOOST_DOMAIN_THEME_LANG); ?></span></button>
                                 </li>
                                 <li class="ib-pscitem ib-psprint">
                                    <button class="ib-psbtn" aria-label="Print"><span class="ib-pstxt"><?php echo __("print", IDXBOOST_DOMAIN_THEME_LANG); ?></span></button>
                                 </li>
                              </ul>
          
                              <div class="ib-plist-details -border">
                                 <div class="ib-plist-card">
                                    <h2 class="ib-plist-card-title">Basic Information</h2>
                                    <ul class="ib-plist-list">
                                       <li>
                                          <span class="ib-plist-st">MLS #</span>
                                          <span class="ib-plist-pt">{{mls_num}}</span>
                                       </li>
                                       <li>
                                          <span class="ib-plist-st">Type</span>
                                          <span class="ib-plist-pt">{{property_type}}</span>
                                       </li>
                                       <li>
                                          <span class="ib-plist-st">Status</span>
                                          <span class="ib-plist-pt">{{status_name}}</span>
                                       </li>
                                       <li>
                                          <span class="ib-plist-st">Suddivision/Complex</span>
                                          <span class="ib-plist-pt">{{subdivision}}</span>
                                       </li>
                                       <li>
                                          <span class="ib-plist-st">Year Built</span>
                                          <span class="ib-plist-pt">{{year}}</span>
                                       </li>
                                       <li>
                                          <span class="ib-plist-st">Total Sqft</span>
                                          <span class="ib-plist-pt">{{ total_sqft }}</span>
                                       </li>
                                       <li>
                                          <span class="ib-plist-st">Date Listed</span>
                                          <span class="ib-plist-pt">{{list_date}}</span>
                                       </li>
                                       {{#if days_market}}
                                       <li>
                                          <span class="ib-plist-st">Days on Market</span>
                                          <span class="ib-plist-pt">{{days_market}}</span>
                                       </li>
                                       {{/if}}

                                    </ul>
                                 </div>
                              </div>

                  {{#if descriptionEspe}}
                  <div class="ib-description-especial">
                    {{{descriptionEspe}}}
                  </div>
                  {{/if}}

                  {{#if remark}}
                    <div class="ib-pdescription">
                      <div class="ib-pdescription-title">Descrition</div>
                      <p>{{remark}}</p>
                    </div>
                  {{/if}}


                              <div class="ib-plist-details">
                  {{#if amenities}}
                                 <div class="ib-plist-card -amenities">
                                    <h2 class="ib-plist-card-title"><?php echo __("Amenities", IDXBOOST_DOMAIN_THEME_LANG); ?></h2>
                                    <ul class="ib-plist-list">
                                      {{#each amenities}}
                                        <li><span class="ib-plist-pt">{{this}}</span></li>
                                      {{/each}}
                                    </ul>
                                 </div>
                  {{/if}}

                                 <div class="ib-plist-card">
                                    <h2 class="ib-plist-card-title">Exterior Features</h2>
                                    <ul class="ib-plist-list">
                                       <li>
                                          <span class="ib-plist-st">Waterfront</span>
                                          <span class="ib-plist-pt">{{water_front}}</span>
                                       </li>
                                       {{#if wv}}
                                       <li>
                                          <span class="ib-plist-st">WF Description</span>
                                          <span class="ib-plist-pt">{{wv}}</span>
                                       </li>
                                       {{/if}}                                       
                                       <li>
                                          <span class="ib-plist-st">Pool</span>
                                          <span class="ib-plist-pt">{{pool}}</span>
                                       </li>
                                       {{#if more_info_info.view}}
                                         <li>
                                            <span class="ib-plist-st">View</span>
                                            <span class="ib-plist-pt">{{more_info_info.view}}</span>
                                         </li>
                                       {{/if}}
                                       {{#if more_info_info.construction}}
                                       <li>
                                          <span class="ib-plist-st">Construction Type</span>
                                          <span class="ib-plist-pt">{{more_info_info.construction}}</span>
                                       </li>
                                       {{/if}}
                                       {{#if more_info_info.architectural_style}}
                                         <li>
                                            <span class="ib-plist-st">Design Description</span>
                                            <span class="ib-plist-pt">{{more_info_info.architectural_style}}</span>
                                         </li>
                                       {{/if}}
                                       {{#if feature_exterior}}
                                         <li>
                                            <span class="ib-plist-st">Exterior Features</span>
                                            <span class="ib-plist-pt">{{#each feature_exterior}}{{this}}, {{/each}}</span>
                                         </li>
                                       {{/if}}
                                       {{#if has_parking}}
                                       <li>
                                          <span class="ib-plist-st">Parking Spaces</span>
                                          <span class="ib-plist-pt">{{parking}}</span>
                                       </li>
                                       {{/if}}
                                       <li>
                                          <span class="ib-plist-st">Parking Description</span>
                                          <span class="ib-plist-pt">{{parking_desc}}</span>
                                       </li>
                                       {{#if more_info_info.roof}}
                                       <li>
                                          <span class="ib-plist-st">Roof Description</span>
                                          <span class="ib-plist-pt">{{more_info_info.roof}}</span>
                                       </li>
                                       {{/if}}
                                       {{#if more_info_info.style}}
                                       <li>
                                          <span class="ib-plist-st">Style</span>
                                          <span class="ib-plist-pt">{{more_info_info.style}}</span>
                                       </li>
                                       {{/if}}
                                    </ul>
                                 </div>
                                 <div class="ib-plist-card">
                                    <h2 class="ib-plist-card-title"><?php echo __("Interior Features", IDXBOOST_DOMAIN_THEME_LANG); ?></h2>
                                    <ul class="ib-plist-list">
                                       <li>
                                          <span class="ib-plist-st">Adjusted Sqft</span>
                                          <span class="ib-plist-pt">{{sqft}}</span>
                                       </li>
                                       {{#if more_info_info.cooling}}
                                         <li>
                                            <span class="ib-plist-st">Cooling Description</span>
                                            <span class="ib-plist-pt">{{more_info_info.cooling}}</span>
                                         </li>
                                       {{/if}}                                       
                                       {{#if more_info_info.appliance}}
                                         <li>
                                            <span class="ib-plist-st">Equipment Appliances</span>
                                            <span class="ib-plist-pt">{{more_info_info.appliance}}</span>
                                         </li>
                                       {{/if}}   
                                       {{#if more_info_info.floor_desc}}
                                         <li>
                                            <span class="ib-plist-st">Floor Description</span>
                                            <span class="ib-plist-pt">{{more_info_info.floor_desc}}</span>
                                         </li>
                                       {{/if}}
                                       {{#if more_info_info.heating}}
                                       <li>
                                          <span class="ib-plist-st">Heating Description</span>
                                          <span class="ib-plist-pt">{{more_info_info.heating}}</span>
                                       </li>
                                       {{/if}}
                                       {{#if feature_interior}}
                                         <li>
                                            <span class="ib-plist-st">Interior Features</span>
                                            <span class="ib-plist-pt">{{#each feature_interior}}{{this}} , {{/each}}</span>
                                         </li>
                                       {{/if}}
                                       <li>
                                          <span class="ib-plist-st">Sqft</span>
                                          <span class="ib-plist-pt">{{sqft}}</span>
                                       </li>
                                    </ul>
                                 </div>
                                 <div class="ib-plist-card">
                                    <h2 class="ib-plist-card-title"><?php echo __("Property Features", IDXBOOST_DOMAIN_THEME_LANG); ?></h2>
                                    <ul class="ib-plist-list">
                                       {{#if more_info_info.addres}}
                                         <li>
                                            <span class="ib-plist-st">Address</span>
                                            <span class="ib-plist-pt">{{more_info_info.addres}}</span>
                                         </li>
                                       {{/if}}
                                       {{#if lot_size}}
                                       <li>
                                          <span class="ib-plist-st">Aprox. Lot Size</span>
                                          <span class="ib-plist-pt">{{lot_size}}</span>
                                       </li>
                                       {{/if}}
                                       {{#if more_info_info.architectural_style}}
                                         <li>
                                            <span class="ib-plist-st">Architectural Style</span>
                                            <span class="ib-plist-pt">{{more_info_info.architectural_style}}</span>
                                         </li>
                                       {{/if}}



                                       {{#if more_info_info.assoc_fee_paid}}
                                         <li>
                                            <span class="ib-plist-st">Association Fee Frequency</span>
                                            <span class="ib-plist-pt">{{more_info_info.assoc_fee_paid}}</span>
                                         </li>
                                       {{/if}}
                                       {{#if more_info_info.attached_garage}}
                                         <li>
                                            <span class="ib-plist-st">Attached Garage</span>
                                            <span class="ib-plist-pt">{{more_info_info.attached_garage}}</span>
                                         </li>
                                       {{/if}}
                                       {{#if more_info_info.city}}
                                         <li>
                                            <span class="ib-plist-st">City</span>
                                            <span class="ib-plist-pt">{{more_info_info.city}}</span>
                                         </li>
                                       {{/if}}
                                       {{#if more_info_info.community_features}}
                                         <li>
                                            <span class="ib-plist-st">Community Features</span>
                                            <span class="ib-plist-pt">{{more_info_info.community_features}}</span>
                                         </li>
                                       {{/if}}
                                       {{#if more_info_info.construction}}
                                         <li>
                                            <span class="ib-plist-st">Construction Materials</span>
                                            <span class="ib-plist-pt">{{more_info_info.construction}}</span>
                                         </li>
                                       {{/if}}
                                       {{#if more_info_info.county}}
                                       <li>
                                          <span class="ib-plist-st">County</span>
                                          <span class="ib-plist-pt">{{more_info_info.county}}</span>
                                       </li>
                                       {{/if}}
                                       {{#if more_info_info.covered_spaces}}
                                         <li>
                                            <span class="ib-plist-st">Covered Spaces</span>
                                            <span class="ib-plist-pt">{{more_info_info.covered_spaces}}</span>
                                         </li>
                                       {{/if}}
                                       {{#if more_info_info.faces}}
                                         <li>
                                            <span class="ib-plist-st">Direction Faces</span>
                                            <span class="ib-plist-pt">{{more_info_info.faces}}</span>
                                         </li>
                                       {{/if}}
                                       {{#if more_info_info.frontage_lenght}}
                                         <li>
                                            <span class="ib-plist-st">FrontageLength</span>
                                            <span class="ib-plist-pt">{{more_info_info.frontage_lenght}}</span>
                                         </li>
                                       {{/if}}
                                       <li>
                                          <span class="ib-plist-st">Furnished Info</span>
                                          <span class="ib-plist-pt">{{furnished}}</span>
                                       </li>
                                       {{#if more_info_info.garage}}
                                         <li>
                                            <span class="ib-plist-st">Garage</span>
                                            <span class="ib-plist-pt">{{more_info_info.garage}}</span>
                                         </li>
                                       {{/if}}
                                       {{#if more_info_info.levels}}
                                         <li>
                                            <span class="ib-plist-st">Levels</span>
                                            <span class="ib-plist-pt">{{more_info_info.levels}}</span>
                                         </li>
                                       {{/if}}
                                       {{#if more_info_info.terms}}
                                         <li>
                                            <span class="ib-plist-st">Listing Terms</span>
                                            <span class="ib-plist-pt">{{more_info_info.terms}}</span>
                                         </li>
                                       {{/if}}
                                       {{#if lot_desc}}
                                         <li>
                                            <span class="ib-plist-st">Lot Description</span>
                                            <span class="ib-plist-pt">{{lot_desc}}</span>
                                         </li>
                                        {{/if}}
                                       
                                       {{#if more_info_info.lot_features}}
                                         <li>
                                            <span class="ib-plist-st">Lot Features</span>
                                            <span class="ib-plist-pt">{{more_info_info.lot_features}}</span>
                                         </li>
                                       {{/if}}
                                       {{#if more_info_info.ocupant_type}}
                                         <li>
                                            <span class="ib-plist-st">Occupant Type</span>
                                            <span class="ib-plist-pt">{{more_info_info.ocupant_type}}</span>
                                         </li>
                                       {{/if}}
                                       {{#if more_info_info.parking_features}}
                                         <li>
                                            <span class="ib-plist-st">Parking Features</span>
                                            <span class="ib-plist-pt">{{more_info_info.parking_features}}</span>
                                         </li>
                                       {{/if}}
                                       {{#if more_info_info.patio_features}}
                                         <li>
                                            <span class="ib-plist-st">Patio And Porch Features</span>
                                            <span class="ib-plist-pt">{{more_info_info.patio_features}}</span>
                                         </li>
                                       {{/if}}
                                       {{#if more_info_info.pets}}
                                         <li>
                                            <span class="ib-plist-st">Pets Allowed</span>
                                            <span class="ib-plist-pt">{{more_info_info.pets}}</span>
                                         </li>
                                       {{/if}}
                                       
                                       {{#if more_info_info.pool_features}}
                                         <li>
                                            <span class="ib-plist-st">Pool Features</span>
                                            <span class="ib-plist-pt">{{more_info_info.pool_features}}</span>
                                         </li>
                                       {{/if}}
                                       {{#if more_info_info.possession}}
                                         <li>
                                            <span class="ib-plist-st">Possession</span>
                                            <span class="ib-plist-pt">{{more_info_info.possession}}</span>
                                         </li>
                                       {{/if}}
                                       {{#if more_info_info.postal_city}}
                                         <li>
                                            <span class="ib-plist-st">Postal City </span>
                                            <span class="ib-plist-pt">{{more_info_info.postal_city}}</span>
                                         </li>
                                       {{/if}}
                                       {{#if more_info_info.public_section}}
                                         <li>
                                            <span class="ib-plist-st">Public Survey Section</span>
                                            <span class="ib-plist-pt">{{more_info_info.public_section}}</span>
                                         </li>
                                       {{/if}}
                                       {{#if more_info_info.public_survey_township}}
                                         <li>
                                            <span class="ib-plist-st">Public Survey Township</span>
                                            <span class="ib-plist-pt">{{more_info_info.public_survey_township}}</span>
                                         </li>
                                       {{/if}}

                                       {{#if more_info_info.roof}}
                                         <li>
                                            <span class="ib-plist-st">Roof</span>
                                            <span class="ib-plist-pt">{{more_info_info.roof}}</span>
                                         </li>
                                       {{/if}}
                                       {{#if more_info_info.senior_community}}
                                         <li>
                                            <span class="ib-plist-st">Senior Community</span>
                                            <span class="ib-plist-pt">{{more_info_info.senior_community}}</span>
                                         </li>
                                       {{/if}}
                                       {{#if more_info_info.sewer}}
                                         <li>
                                            <span class="ib-plist-st">Sewer Description</span>
                                            <span class="ib-plist-pt">{{more_info_info.sewer}}</span>
                                         </li>
                                       {{/if}}
                                       <li>
                                          <span class="ib-plist-st">Short Sale</span>
                                          <span class="ib-plist-pt">{{short_sale}}</span>
                                       </li>
                                       {{#if more_info_info.stories}}
                                         <li>
                                            <span class="ib-plist-st">Stories</span>
                                            <span class="ib-plist-pt">{{more_info_info.stories}}</span>
                                         </li>
                                       {{/if}}
                                       {{#unless is_commercial}}
                                         {{#if assoc_fee}}
                                         <li>
                                            <span class="ib-plist-st">HOA Fees</span>
                                            <span class="ib-plist-pt">{{assoc_fee}}</span>
                                         </li>
                                         {{/if}}
                                       {{/unless}}
                                       <li>
                                          <span class="ib-plist-st">Subdivision Complex</span>
                                          <span class="ib-plist-pt">{{complex}}</span>
                                       </li>
                                       <li>
                                          <span class="ib-plist-st">Subdivision Info</span>
                                          <span class="ib-plist-pt">{{subdivision}}</span>
                                       </li>
                                         <li>
                                            <span class="ib-plist-st">Tax Amount</span>
                                            <span class="ib-plist-pt">{{tax_amount}}</span>
                                         </li>
                                       {{#if more_info_info.tax_information}}
                                       <li>
                                          <span class="ib-plist-st">Tax Legal desc</span>
                                          <span class="ib-plist-pt">{{more_info_info.tax_information}}</span>
                                       </li>
                                       {{/if}}
                                       <li>
                                          <span class="ib-plist-st">Tax Year</span>
                                          <span class="ib-plist-pt">{{tax_year}}</span>
                                       </li>
                                       {{#if more_info_info.terms}}
                                         <li>
                                            <span class="ib-plist-st">Terms Considered</span>
                                            <span class="ib-plist-pt">{{more_info_info.terms}}</span>
                                         </li>
                                       {{/if}}
                                       {{#if more_info_info.type_property}}
                                         <li>
                                            <span class="ib-plist-st">Type of Property</span>
                                            <span class="ib-plist-pt">{{more_info_info.type_property}}</span>
                                         </li>
                                       {{/if}}
                                       {{#if more_info_info.view}}
                                         <li>
                                            <span class="ib-plist-st">View</span>
                                            <span class="ib-plist-pt">{{more_info_info.view}}</span>
                                         </li>
                                       {{/if}}
                                       {{#if more_info_info.waterfront_frontage}}
                                         <li>
                                            <span class="ib-plist-st">Water Description</span>
                                            <span class="ib-plist-pt">{{more_info_info.waterfront_frontage}}</span>
                                         </li>
                                       {{/if}}
                                       {{#if more_info_info.water_source}}
                                         <li>
                                            <span class="ib-plist-st">Water Source</span>
                                            <span class="ib-plist-pt">{{more_info_info.water_source}}</span>
                                         </li>
                                       {{/if}}

                                       {{#if more_info_info.window_features}}
                                         <li>
                                            <span class="ib-plist-st">Window Features</span>
                                            <span class="ib-plist-pt">{{more_info_info.window_features}}</span>
                                         </li>
                                       {{/if}}
                                       {{#if more_info_info.year_built_details}}
                                         <li>
                                            <span class="ib-plist-st">Year Built Details</span>
                                            <span class="ib-plist-pt">{{more_info_info.year_built_details}}</span>
                                         </li>
                                       {{/if}}
                                       {{#if more_info_info.zoning}}
                                         <li>
                                            <span class="ib-plist-st">Zoning</span>
                                            <span class="ib-plist-pt">{{more_info_info.zoning}}</span>
                                         </li>
                                       {{/if}}
                                    </ul>
                                 </div>
                                 
                              </div>

                              {{#if lat }}
                                <div class="ib-wrapper-top-map -btn-mp">
                                   <div class="ib-pheader">
                                      <h2 class="ib-ptitle">{{address_short}}</h2>
                                      <span class="ib-pstitle">{{address_large}}</span>
                                   </div>
                                      <div class="ib-wrapper-map" id="ib-modal-property-map" style="background-color:#EEE;height:300px;width:100%;margin:15px 0;"></div>
                                </div>
                              {{/if}}

                              {{#if related_properties}}
                              
                                <div class="ib-pablock ib-bsproperties">
                                   <div class="ib-pasmtitle"><?php echo __("Similar Properties For sale", IDXBOOST_DOMAIN_THEME_LANG); ?></div>
                                  <ul class="ib-sproperties">
                                    {{#each related_properties}}
                                    <li class="ib-spitem ib-rel-property" data-mls="{{mls_num}}">
                                      <div class="ib-spipa">
                                        <h4 class="ib-sptitle">{{ address_short }}</h4>
                                        <ul class="ib-spdetails">
                                          <li class="ib-spditem ib-spaddress">{{address_large}}</li>
                                          <li class="ib-spditem ib-sprice">{{ formatPrice price }}</li>
                                          <li class="ib-spditem ib-spbeds"><span class="ib-spdbold">{{bed}}</span> <?php echo __("Bed(s)", IDXBOOST_DOMAIN_THEME_LANG); ?></li>
                                          <li class="ib-spditem ib-spbaths"><span class="ib-spdbold">{{bath}}</span> <?php echo __("Bath(s)", IDXBOOST_DOMAIN_THEME_LANG); ?></li>
                                          <li class="ib-spditem ib-spsqft"><span class="ib-spdbold">{{ formatSqft sqft }}</span> <?php echo __("Sqft", IDXBOOST_DOMAIN_THEME_LANG); ?></li>
                                          <li class="ib-spditem ib-spsqft"><span class="ib-spdbold">${{ formatPriceSqft this }}</span> / <?php echo __("Sqft", IDXBOOST_DOMAIN_THEME_LANG); ?></li>
                                        </ul>
                                      </div>
                                      <div class="ib-spipb">
                                          <img class="ib-spimg" src="{{ thumbnail }}">
                                      </div>
                                      <a class="ib-splink" href="#" title="<?php echo __("Details of", IDXBOOST_DOMAIN_THEME_LANG); ?> {{address_short}} {{address_large}}">
                                          <span class="ib-spltxt"><?php echo __("Details of", IDXBOOST_DOMAIN_THEME_LANG); ?> {{address_short}} {{address_large}}</span>
                                      </a>
                                    </li>
                                    {{/each}}
                                  </ul>
                                </div>

                              {{/if}}

                  </div>


                  <?php if( in_array($flex_idx_info["board_id"], ["13","14"]) ){ ?>
                    <div class="ib-idx-info">
                      <div class="ms-msg">
                        {{#if board_info.last_check_timestamp}}
                          <span>IDXBoost last checked {{board_info.last_check_timestamp}}</span>
                        {{/if}}
                        {{#if last_updated}}
                          <span>Data was last updated {{last_updated}}</span>
                        {{/if}}
                      </div>
                    </div>
                  <?php } ?>

                  <div class="ib-bdisclaimer ib-bdisclaimer-desktop">
                    {{#if board_info.board_logo_url}}
                      <div class="ms-logo-board">
                        <img src="{{board_info.board_logo_url}}">
                      </div>
                    {{/if}}
                    <?php if (isset($flex_idx_info["board_id"]) && ("7" == $flex_idx_info["board_id"])){ ?>
                      <p>The multiple listing information is provided by the Houston Association of Realtors from a copyrighted compilation of listings. The compilation of listings and each individual listing are &copy;<?php echo date('Y'); ?>-present TEXAS All Rights Reserved. The information provided is for consumers' personal, noncommercial use and may not be used for any purpose other than to identify prospective properties consumers may be interested in purchasing. All properties are subject to prior sale or withdrawal. All information provided is deemed reliable but is not guaranteed accurate, and should be independently verified. Listing courtesy of: <span class="ib-bdcourtesy">{{office_name}}</span></p>
                    <?php }else if("13" == $flex_idx_info["board_id"]){ ?>
                      <p>{{{board_info.board_disclaimer}}}</p>
                    <?php }else{ ?>
                      <p>The multiple listing information is provided by the  {{board_name}}® from a copyrighted compilation of listings.
                      The compilation of listings and each individual listing are &copy;<?php echo date('Y'); ?>-present  {{board_name}}®.
                      All Rights Reserved. The information provided is for consumers' personal, noncommercial use and may not be used for any purpose
                      other than to identify prospective properties consumers may be interested in purchasing. All properties are subject to prior sale or withdrawal.
                      All information provided is deemed reliable but is not guaranteed accurate, and should be independently verified.
                      Listing courtesy of: <span class="ib-bdcourtesy">{{office_name}}</span></p>
                    <?php } ?>
                    <p>Real Estate IDX Powered by: <a href="https://www.tremgroup.com" title="TREMGROUP" rel="nofollow" target="_blank">TREMGROUP</a></p>
                    

                </div>
                
              </div>
              <div class="ib-paside">
                <button class="ib-float-form"><span></span></button>
                <div class="ib-pablock ib-bcform">
                  <div class="ib-pacftitle">
                    <div class="ib-cftpa"><img class="ib-cftimg" src="{{agentPhoto this}}"></div>
                    <div class="ib-cftpb">
                      <h4 class="ib-cftname">{{agentFullName this}}</h4>
                      <a class="ib-cftphone" href="tel:{{agentPhoneNumber this}}" title="<?php echo __("Call to", IDXBOOST_DOMAIN_THEME_LANG); ?> {{agentPhone this}}"><?php echo __("Ph", IDXBOOST_DOMAIN_THEME_LANG); ?>. {{agentPhone this}}</a>
                    </div>
                  </div>
                  <div class="ib-pacform">
                    <form class="ib-cform ib-propery-inquiry-f gtm_more_info_property" method="post">
                      <input type="hidden" name="ib_tags" value="">
                      <input type="hidden" name="mls_number" value="{{mls_num}}">
                      <ul class="ib-cffields">
                        <li class="ib-cffitem">
                          <input class="ib-cfinput" name="first_name" type="text" placeholder="<?php echo __("First Name", IDXBOOST_DOMAIN_THEME_LANG); ?>*" value="{{ leadFirstName this }}" required>
                        </li>
                        <li class="ib-cffitem">
                          <input class="ib-cfinput" name="last_name" type="text" placeholder="<?php echo __("Last Name", IDXBOOST_DOMAIN_THEME_LANG); ?>*" value="{{ leadLastName this }}" required>
                        </li>
                        <li class="ib-cffitem">
                          <input class="ib-cfinput" name="email_address" type="email" placeholder="<?php echo __("Email", IDXBOOST_DOMAIN_THEME_LANG); ?>*" value="{{ leadEmailAddress this }} " required>
                        </li>
                        <li class="ib-cffitem">
                          <input class="ib-cfinput" name="phone_number" type="text" placeholder="<?php echo __("Phone", IDXBOOST_DOMAIN_THEME_LANG); ?>*" value="{{ leadPhoneNumber this }}" required>
                        </li>
                        <li class="ib-cffitem">
                          <textarea class="ib-cftextarea" name="message" type="text" placeholder="<?php echo __("Comments", IDXBOOST_DOMAIN_THEME_LANG); ?>" required><?php echo __("I am interested in", IDXBOOST_DOMAIN_THEME_LANG); ?> {{address_short}} {{address_large}}</textarea>
                        </li>
                      </ul>
                      <div class="ib-cfrequired">* <?php echo __("Required fields", IDXBOOST_DOMAIN_THEME_LANG); ?></div>
                      <div class="ib-cfwsubmit">
                        <button type="submit" class="ib-cfsubmit ib-modal-inquiry-form">
                          <span class="ib-m-text"><?php echo __("Submit", IDXBOOST_DOMAIN_THEME_LANG); ?></span>
                          <span class="ib-d-text"><?php echo __("Request information", IDXBOOST_DOMAIN_THEME_LANG); ?></span>
                        </button>
                      </div>
                    </form>
                  </div>
                </div>
              </div>

                  <div class="ib-bdisclaimer ib-bdisclaimer-mobile">
                    {{#if board_info.board_logo_url}}
                      <div class="ms-logo-board">
                        <img src="{{board_info.board_logo_url}}">
                      </div>
                    {{/if}}
                    <?php if (isset($flex_idx_info["board_id"]) && ("7" == $flex_idx_info["board_id"])){ ?>
                      <p>The multiple listing information is provided by the Houston Association of Realtors from a copyrighted compilation of listings. The compilation of listings and each individual listing are &copy;<?php echo date('Y'); ?>-present TEXAS All Rights Reserved. The information provided is for consumers' personal, noncommercial use and may not be used for any purpose other than to identify prospective properties consumers may be interested in purchasing. All properties are subject to prior sale or withdrawal. All information provided is deemed reliable but is not guaranteed accurate, and should be independently verified. Listing courtesy of: <span class="ib-bdcourtesy">{{office_name}}</span></p>
                    <?php }else if("13" == $flex_idx_info["board_id"]){ ?>
                      <p>{{{board_info.board_disclaimer}}}</p>
                    <?php }else{ ?>
                      <p>The multiple listing information is provided by the  {{board_name}}® from a copyrighted compilation of listings.
                      The compilation of listings and each individual listing are &copy;<?php echo date('Y'); ?>-present  {{board_name}}®.
                      All Rights Reserved. The information provided is for consumers' personal, noncommercial use and may not be used for any purpose
                      other than to identify prospective properties consumers may be interested in purchasing. All properties are subject to prior sale or withdrawal.
                      All information provided is deemed reliable but is not guaranteed accurate, and should be independently verified.
                      Listing courtesy of: <span class="ib-bdcourtesy">{{office_name}}</span></p>
                    <?php } ?>
                    <p>Real Estate IDX Powered by: <a href="https://www.tremgroup.com" title="TREMGROUP" rel="nofollow" target="_blank">TREMGROUP</a></p>
                    

            </div>

            <button class="ib-btn-request ib-active-float-form"><?php echo __("Contact Agent", IDXBOOST_DOMAIN_THEME_LANG); ?></button>
          </div>
        </article>
      </div>
      <div class="ib-mmbg"></div>
    </div>
</script>

<script id="ib-aside-template" type="text/x-handlebars-template">
    {{#each this}}
        <?php /*{{{ capturePositionHackbox @index }}}*/ ?>
        <li class="ib-pitem" data-geocode="{{ lat }}:{{ lng }}" data-mls="{{ mls_num }}" data-status="{{ status }}">
            <ul class="ib-piinfo">
                <li class="ib-piitem ib-piprice">{{ formatPrice price }}{{ isRentalTypeListing is_rental }}</li>
                <li class="ib-piitem ib-pibeds">{{ bed }} <?php echo __('Bed(s)', IDXBOOST_DOMAIN_THEME_LANG); ?></li>
                <li class="ib-piitem ib-pibaths">{{ bath }}{{ formatBathsHalf baths_half }} <?php echo __('Bath(s)', IDXBOOST_DOMAIN_THEME_LANG); ?></li>
                <li class="ib-piitem ib-pisqft">{{ formatSqft sqft }} <?php echo __('Sq.Ft.', IDXBOOST_DOMAIN_THEME_LANG); ?></li>
                <li class="ib-piitem ib-paddress">{{ full_address }}</li>
                {{{ handleStatusProperty this }}}
								<li class="ms-logo-board"><img src="{{board_info.board_logo_url}}"></li>  
            </ul>
            <div class="ib-pislider {{ idxImageEmpty this }} gs-container-slider" data-img-cnt="{{ img_cnt }}" data-mls="{{ mls_num }}" data-status="{{ status }}">
                {{{ idxGalleryImages this }}}
                <!-- <img class="ib-pifimg" src="{{ idxImage this }}" alt="{{ full_address }}"> -->
                <div class="gs-container-navs">
                    <div class="gs-wrapper-arrows">
                        <button class="gs-prev-arrow" tabindex="-1" aria-label="Prev"></button>
                        <button class="gs-next-arrow" tabindex="-1" aria-label="Next"></button>
                    </div>
                </div>
            </div>
            <div class="ib-pfavorite {{ idxFavoriteClass this }}" data-mls="{{ mls_num }}" data-status="{{ status }}" data-token-alert="{{token_alert}}"><?php /*<span>Add to Favorites</span> */ ?></div>
            <a class="ib-pipermalink" href="{{ idxPermalink this }}" title="<?php echo __('View Detail of', IDXBOOST_DOMAIN_THEME_LANG); ?> {{ full_address }}"><span>{{ full_address }}</span></a>       
        </li>
    {{/each}}
</script>

<div id="printMessageBox"><?php echo __('Please wait while we create your document', IDXBOOST_DOMAIN_THEME_LANG); ?></div>

<!-- filter for mobile device -->
<div class="ib-modal-filters-mobile" style="display:none;">
	<div class="ib-content-modal-filters-mobile">
		<!--Header modal-->
		<div class="ib-header-modal-filters-mobile">
			<!--<?php if (isset($flex_idx_info["url_logo"]) && !empty($flex_idx_info["url_logo"])) : ?>
		  <img src="<?php echo $flex_idx_info["url_logo"]; ?>">
		  <?php endif; ?>-->
			<h3 class="ib-mtitle"><?php echo __('Filters', IDXBOOST_DOMAIN_THEME_LANG); ?></h3>
			<button class="ib-close-modal-filters-mobile"><span><?php echo __('Close', IDXBOOST_DOMAIN_THEME_LANG); ?></span></button>
		</div>
		<!--Boby modal-->
		<div class="ib-body-modal-filters-mobile">
			<?php /*
			<div class="ib-filter-autocomplete">
				<div class="ib-filter-content-autocomplete"><input type="search" placeholder="Enter address, city, zip or MLS" id="ib-autocomplete-input" class="ib-autocomplete-input ui-autocomplete-input"><span class="ib-icon-search-ligth"></span><span class="ib-line-form"></span>
					<button
						id="ib-close-search-modal">Close</button>
						<!--button#ib-active-autocomplete-->
						<ul id="ui-id-1" tabindex="0" class="ui-menu ui-widget ui-widget-content ui-autocomplete ui-front" style="top: 45px; left: 0px; width: 383px; display: none;">
							<li class="ui-menu-item">
								<div id="ui-id-39" tabindex="-1" class="ui-menu-item-wrapper">Aventura</div>
							</li>
						</ul>
				</div>
			</div>
			*/ ?>
			<div class="ib-wrap-collapse">
				<!-- RENTAL TYPE -->
				<div class="ib-item-collapse">
					<div class="ib-body-collpase">
						<div class="ib-wrap-fm">
							<ul class="ib-wrap-fm ib-cl-2">
								<li class="ib-item-wrap-fm ib-btn-chk-fm">
									<input type="radio" name="ib_m_rental_type" value="0" id="ib_m_rental_type_s">
									<label for="ib_m_rental_type_s"><?php echo __('For sale', IDXBOOST_DOMAIN_THEME_LANG); ?></label>
								</li>
								<li class="ib-item-wrap-fm ib-btn-chk-fm">
									<input type="radio" name="ib_m_rental_type" value="1" id="ib_m_rental_type_r">
									<label for="ib_m_rental_type_r"><?php echo __('For Rent ', IDXBOOST_DOMAIN_THEME_LANG); ?></label>
								</li>
							</ul>
						</div>
					</div>
				</div>
				<!--PRICE RANGE FOR SALE-->
				<div class="ib-item-collapse ib-item-collapse-saletype ib-item-collapse-sale" style="display:none;">
					<h2 class="ib-header-collapse"><?php echo __('Price Range', IDXBOOST_DOMAIN_THEME_LANG); ?></h2>
					<div class="ib-body-collpase">
						<div class="ib-wrap-fm">
							<div class="ib-item-wrap-fm ib-wrap-content-select">
								<label class="ms-hidden" for="ib-min-price"><?php echo __('Select a minimum range price', IDXBOOST_DOMAIN_THEME_LANG); ?></label>
								<select id="ib-min-price"></select>
								<span class="ib-label-wrap-fm"><?php echo __('Minimum', IDXBOOST_DOMAIN_THEME_LANG); ?></span>
							</div>
							<div class="ib-item-wrap-fm ib-sp-fm ib-sp-fm-tp"><?php echo __('to', IDXBOOST_DOMAIN_THEME_LANG); ?></div>
							<div class="ib-item-wrap-fm ib-wrap-content-select">
								<label class="ms-hidden" for="ib-max-price"><?php echo __('Select a maximum range price', IDXBOOST_DOMAIN_THEME_LANG); ?></label>
								<select id="ib-max-price"></select>
								<span class="ib-label-wrap-fm"><?php echo __('Maximum', IDXBOOST_DOMAIN_THEME_LANG); ?></span>
							</div>
						</div>
					</div>
				</div>

				<!--PRICE RANGE FOR RENT-->
				<div class="ib-item-collapse ib-item-collapse-saletype ib-item-collapse-rent" style="display:none;">
					<h2 class="ib-header-collapse"><?php echo __('Price Range', IDXBOOST_DOMAIN_THEME_LANG); ?></h2>
					<div class="ib-body-collpase">
						<div class="ib-wrap-fm">
							<div class="ib-item-wrap-fm ib-wrap-content-select">
								<label class="ms-hidden" for="ib-min-rent-price"><?php echo __('Select a minimum range price', IDXBOOST_DOMAIN_THEME_LANG); ?></label>
								<select id="ib-min-rent-price"></select>
								<span class="ib-label-wrap-fm"><?php echo __('Minimum', IDXBOOST_DOMAIN_THEME_LANG); ?></span>
							</div>
							<div class="ib-item-wrap-fm ib-sp-fm ib-sp-fm-tp"><?php echo __('to', IDXBOOST_DOMAIN_THEME_LANG); ?></div>
							<div class="ib-item-wrap-fm ib-wrap-content-select">
								<label class="ms-hidden" for="ib-max-rent-price"><?php echo __('Select a maximum range price', IDXBOOST_DOMAIN_THEME_LANG); ?></label>
								<select id="ib-max-rent-price"></select>
								<span class="ib-label-wrap-fm"><?php echo __('Maximum', IDXBOOST_DOMAIN_THEME_LANG); ?></span>
							</div>
						</div>
					</div>
				</div>

				<!--BEDROOMS-->
				<div id="ib-bedrooms-collapse" class="ib-item-collapse">
					<h2 class="ib-header-collapse"><?php echo __('Bedrooms', IDXBOOST_DOMAIN_THEME_LANG); ?></h2>
					<div class="ib-body-collpase">
						<div class="ib-wrap-fm">
							<div class="ib-item-wrap-fm ib-wrap-content-select">
								<label class="ms-hidden" for="ib-min-beds"><?php echo __('Select a min bedrooms', IDXBOOST_DOMAIN_THEME_LANG); ?></label>
								<select id="ib-min-beds"></select>
								<span class="ib-label-wrap-fm"><?php echo __('Minimum', IDXBOOST_DOMAIN_THEME_LANG); ?></span>
							</div>
							<div class="ib-item-wrap-fm ib-sp-fm ib-sp-fm-tp"><?php echo __('to', IDXBOOST_DOMAIN_THEME_LANG); ?></div>
							<div class="ib-item-wrap-fm ib-wrap-content-select">
								<label class="ms-hidden" for="ib-max-beds"><?php echo __('Select a max bedrooms', IDXBOOST_DOMAIN_THEME_LANG); ?></label>
								<select id="ib-max-beds"></select>
								<span class="ib-label-wrap-fm"><?php echo __('Maximum', IDXBOOST_DOMAIN_THEME_LANG); ?></span>
							</div>
						</div>
					</div>
				</div>
				<!--BATHROOMS-->
				<div class="ib-item-collapse">
					<h2 class="ib-header-collapse"><?php echo __('Bathrooms', IDXBOOST_DOMAIN_THEME_LANG); ?></h2>
					<div class="ib-body-collpase">
						<div class="ib-wrap-fm">
							<div class="ib-item-wrap-fm ib-wrap-content-select">
								<label class="ms-hidden" for="ib-min-baths"><?php echo __('Select a min baths', IDXBOOST_DOMAIN_THEME_LANG); ?></label>
								<select id="ib-min-baths"></select>
								<span class="ib-label-wrap-fm"><?php echo __('Minimum', IDXBOOST_DOMAIN_THEME_LANG); ?></span>
							</div>
							<div class="ib-item-wrap-fm ib-sp-fm ib-sp-fm-tp"><?php echo __('to', IDXBOOST_DOMAIN_THEME_LANG); ?></div>
							<div class="ib-item-wrap-fm ib-wrap-content-select">
								<label class="ms-hidden" for="ib-max-baths"><?php echo __('Select a max baths', IDXBOOST_DOMAIN_THEME_LANG); ?></label>
								<select id="ib-max-baths"></select>
								<span class="ib-label-wrap-fm"><?php echo __('Maximum', IDXBOOST_DOMAIN_THEME_LANG); ?></span>
							</div>
						</div>
					</div>
				</div>
				<!--TYPE-->
				<div class="ib-item-collapse">
					<h2 class="ib-header-collapse"><?php echo __('Type', IDXBOOST_DOMAIN_THEME_LANG); ?></h2>
					<div class="ib-body-collpase">
						<div class="ib-wrap-fm">
							<ul class="ib-wrap-fm ib-cl-2" id="ib-flex-m-types"></ul>
						</div>
					</div>
				</div>
				<!--PARKING SPACES-->
				<div class="ib-item-collapse">
					<h2 class="ib-header-collapse"><?php echo __('Parking Spaces', IDXBOOST_DOMAIN_THEME_LANG); ?></h2>
					<div class="ib-body-collpase">
						<ul class="ib-wrap-fm" id="ib-flex-m-parking"></ul>
					</div>
				</div>
				<!--LIVING SIZE-->
				<div class="ib-item-collapse">
					<h2 class="ib-header-collapse"><?php echo __('Living Size', IDXBOOST_DOMAIN_THEME_LANG); ?></h2>
					<div class="ib-body-collpase">
						<div class="ib-wrap-fm">
							<div class="ib-item-wrap-fm ib-wrap-content-select">
								<label class="ms-hidden" for="ib-min-living"><?php echo __('Select min living size', IDXBOOST_DOMAIN_THEME_LANG); ?></label>
								<select id="ib-min-living"></select>
								<span class="ib-label-wrap-fm"><?php echo __('Minimum', IDXBOOST_DOMAIN_THEME_LANG); ?></span>
							</div>
							<div class="ib-item-wrap-fm ib-sp-fm ib-sp-fm-tp"><?php echo __('to', IDXBOOST_DOMAIN_THEME_LANG); ?></div>
							<div class="ib-item-wrap-fm ib-wrap-content-select">
								<label class="ms-hidden" for="ib-max-living"><?php echo __('Select max living size', IDXBOOST_DOMAIN_THEME_LANG); ?></label>
								<select id="ib-max-living"></select>
								<span class="ib-label-wrap-fm"><?php echo __('Maximum', IDXBOOST_DOMAIN_THEME_LANG); ?></span>
							</div>
						</div>
					</div>
				</div>
				<!--LAND SIZE-->
				<div class="ib-item-collapse">
					<h2 class="ib-header-collapse"><?php echo __('Land Size', IDXBOOST_DOMAIN_THEME_LANG); ?></h2>
					<div class="ib-body-collpase">
						<div class="ib-wrap-fm">
							<div class="ib-item-wrap-fm ib-wrap-content-select">
								<label class="ms-hidden" for="ib-min-land"><?php echo __('Select min land size', IDXBOOST_DOMAIN_THEME_LANG); ?></label>
								<select id="ib-min-land"></select>
								<span class="ib-label-wrap-fm"><?php echo __('Minimum', IDXBOOST_DOMAIN_THEME_LANG); ?></span>
							</div>
							<div class="ib-item-wrap-fm ib-sp-fm ib-sp-fm-tp"><?php echo __('to', IDXBOOST_DOMAIN_THEME_LANG); ?></div>
							<div class="ib-item-wrap-fm ib-wrap-content-select">
								<label class="ms-hidden" for="ib-max-land"><?php echo __('Select max land size', IDXBOOST_DOMAIN_THEME_LANG); ?></label>
								<select id="ib-max-land"></select>
								<span class="ib-label-wrap-fm"><?php echo __('Maximum', IDXBOOST_DOMAIN_THEME_LANG); ?></span>
							</div>
						</div>
					</div>
				</div>
				<!--YEAR BUILT-->
				<div class="ib-item-collapse">
					<h2 class="ib-header-collapse"><?php echo __('Year Built', IDXBOOST_DOMAIN_THEME_LANG); ?></h2>
					<div class="ib-body-collpase">
						<div class="ib-wrap-fm">
							<div class="ib-item-wrap-fm ib-wrap-content-select">
								<label class="ms-hidden" for="ib-min-year"><?php echo __('Select min year built', IDXBOOST_DOMAIN_THEME_LANG); ?></label>
								<select id="ib-min-year"></select>
								<span class="ib-label-wrap-fm"><?php echo __('Minimum', IDXBOOST_DOMAIN_THEME_LANG); ?></span>
							</div>
							<div class="ib-item-wrap-fm ib-sp-fm ib-sp-fm-tp"><?php echo __('to', IDXBOOST_DOMAIN_THEME_LANG); ?></div>
							<div class="ib-item-wrap-fm ib-wrap-content-select">
								<label class="ms-hidden" for="ib-max-year"><?php echo __('Select max year built', IDXBOOST_DOMAIN_THEME_LANG); ?></label>
								<select id="ib-max-year"></select>
								<span class="ib-label-wrap-fm"><?php echo __('Maximum', IDXBOOST_DOMAIN_THEME_LANG); ?></span>
							</div>
						</div>
					</div>
				</div>

				<!--WATERFRONT DESCRIPTION-->
				<div class="ib-item-collapse">              					
					<h2 class="ib-header-collapse"><?php echo $label_waterfront_description; ?></h2>
					<div class="ib-body-collpase">
						<div class="ib-wrap-fm">
							<div class="ib-item-wrap-fm ib-wrap-content-select">
								<label class="ms-hidden" for="ib-flex-waterfront-switch"><?php echo $label_waterfront_description; ?></label>
								<select id="ib-flex-waterfront-switch"></select></div>
						</div>
					</div>
				</div>
				<!--FEATURES-->
				<div class="ib-item-collapse">
					<h2 class="ib-header-collapse"><?php echo __('Features', IDXBOOST_DOMAIN_THEME_LANG); ?></h2>
					<div class="ib-body-collpase">
						<div class="ib-wrap-fm">
							<ul class="ib-wrap-fm ib-cl-2" id="ib-flex-m-features"></ul>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!--Footer modal-->
		<div class="ib-footer-modal-filters-mobile">
			<div class="ib-group-buttons-content"><button id="ib-apply-clear"><?php echo __('Clear', IDXBOOST_DOMAIN_THEME_LANG); ?></button>
				<button id="ib-apply-filters-btn"><?php echo __('View', IDXBOOST_DOMAIN_THEME_LANG); ?> <span>0 </span><?php echo __('Properties', IDXBOOST_DOMAIN_THEME_LANG); ?></button></div>
		</div>
	</div>
</div>