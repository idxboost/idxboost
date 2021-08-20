<!-- modal property html -->
<div id="flex_idx_modal_wrapper"></div>

<?php 
$idx_contact_phone = isset($flex_idx_info['agent']['agent_contact_phone_number']) ? sanitize_text_field($flex_idx_info['agent']['agent_contact_phone_number']) : '';

                $c_search_settings = get_option("idxboost_search_settings");
                
                $label_waterfront_description = __('Waterfront Description', IDXBOOST_DOMAIN_THEME_LANG);
                if (isset($c_search_settings["board_id"]) && ("11" == $c_search_settings["board_id"])){
                  $label_waterfront_description = __("View Description", IDXBOOST_DOMAIN_THEME_LANG);
                }elseif ( isset($c_search_settings["board_id"]) && ("16" == $c_search_settings["board_id"]) ) {
                  $label_waterfront_description = __("View Features", IDXBOOST_DOMAIN_THEME_LANG);
                }

?>

<!-- modal actions -->
<div class="ib-modal-master" data-id="calculator" id="ib-mortage-calculator">
<div class="ib-mmcontent">
  <div class="ib-mwrapper ib-mgeneric">
    <div class="ib-mgheader">
      <h4 class="ib-mghtitle"><?php echo __("Mortgage calculator", IDXBOOST_DOMAIN_THEME_LANG); ?></h4>
    </div>
    <div class="ib-mgcontent">
      <?php echo __("Let's us know the best time for showing.", IDXBOOST_DOMAIN_THEME_LANG); ?> <a href="tel:<?php echo preg_replace('/[^\d]/', '', $flex_idx_info['agent']['agent_contact_phone_number']); ?>" title="Call Us <?php echo flex_agent_format_phone_number(preg_replace('/[^\d]/', '', $flex_idx_info['agent']['agent_contact_phone_number'])); ?>"><?php echo flex_agent_format_phone_number(preg_replace('/[^\d]/', '', $flex_idx_info['agent']['agent_contact_phone_number'])); ?></a>
      <div class="mb-mcform">
        <form method="post" class="ib-property-mortgage-f">
        <ul class="ib-mcinputs">
          <li class="ib-mcitem"><span class="ib-mgitxt"><?php echo __("Purchase Price", IDXBOOST_DOMAIN_THEME_LANG); ?></span>
            <div class="ib-mgiwrapper">
              <input class="ib-mcipurchase ib-property-mc-pp" value="" type="text" readonly>
            </div>
          </li>
          <li class="ib-mcitem"><span class="ib-mgitxt"><?php echo __("% Down Payment", IDXBOOST_DOMAIN_THEME_LANG); ?></span>
            <div class="ib-mgiwrapper">
              <input class="ib-mcidpayment ib-property-mc-dp" value="30" step="any" type="number" max="95" min="0">
            </div>
          </li>
          <li class="ib-mcitem"><span class="ib-mgitxt"><?php echo __("Term", IDXBOOST_DOMAIN_THEME_LANG); ?></span>
            <div class="ib-mgiwrapper ib-mgwselect">
              <select class="ib-mcsyears ib-property-mc-ty">
                <option value="30"><?php echo __("30 Years", IDXBOOST_DOMAIN_THEME_LANG); ?></option>
                <option value="15"><?php echo __("15 Years", IDXBOOST_DOMAIN_THEME_LANG); ?></option>
              </select>
            </div>
          </li>
          <li class="ib-mcitem"><span class="ib-mgitxt"><?php echo __("Interest Rate", IDXBOOST_DOMAIN_THEME_LANG); ?></span>
            <div class="ib-mgiwrapper">
              <input class="ib-mcidpayment ib-property-mc-ir" value="4" step="any" type="number" max="95" min="0">
            </div>
          </li>
        </ul>
        <button type="button" class="ib-mgsubmit ib-property-mortage-submit"><?php echo __("Calculate", IDXBOOST_DOMAIN_THEME_LANG); ?></button>
        </form>
      </div>
      <div class="mb-mcdata">
        <h5 class="ib-mcsubtitle"><?php echo __("Mortgage Breakdown", IDXBOOST_DOMAIN_THEME_LANG); ?></h5>
        <ul class="ib-mcdlist">
          <li class="ib-mcditem"><span class="ib-mcditxt"><?php echo __("Mortgage Amount", IDXBOOST_DOMAIN_THEME_LANG); ?></span><span class="ib-mcdinumbers ib-calc-mc-mortgage"></span></li>
          <li class="ib-mcditem"><span class="ib-mcditxt"><?php echo __("Down Payment Amount", IDXBOOST_DOMAIN_THEME_LANG); ?></span><span class="ib-mcdinumbers ib-calc-mc-down-payment"></span></li>
          <li class="ib-mcditem ib-mcdibig"><span class="ib-mcditxt"><?php echo __("Monthly Amount", IDXBOOST_DOMAIN_THEME_LANG); ?></span><span class="ib-mcdinumbers ib-calc-mc-monthly"></span></li>
          <li class="ib-mcditem ib-mcdibig">
            <div class="ib-mcditxt"><?php echo __("Total Monthly Amount", IDXBOOST_DOMAIN_THEME_LANG); ?> <span class="ib-mcdibold"><?php echo __("(Principal &amp; Interest, and PMI)", IDXBOOST_DOMAIN_THEME_LANG); ?></span></div><span class="ib-mcdinumbers ib-calc-mc-totalmonthly"></span>
          </li>
        </ul>
      </div>
    </div>
  </div>
  <div class="ib-mmclose"><span class="ib-mmctxt"><?php echo __("Close", IDXBOOST_DOMAIN_THEME_LANG); ?></span></div>
</div>
<div class="ib-mmbg"></div>
</div>

<div class="ib-modal-master" data-id="email-to-friend" id="ib-email-to-friend">
<div class="ib-mmcontent">
  <div class="ib-mwrapper ib-mgeneric">
    <div class="ib-mgheader">
      <h4 class="ib-mghtitle"><?php echo __("Email to a friend", IDXBOOST_DOMAIN_THEME_LANG); ?></h4>
    </div>
    <form method="post" class="ib-property-share-friend-f iboost-secured-recaptcha-form">
      <input type="hidden" name="mls_number" class="ib-property-share-mls-num" value="">
      <div class="ib-mgcontent"><?php echo __("Recommend this to a friend, just enter their email bellow", IDXBOOST_DOMAIN_THEME_LANG); ?>
        <div class="ib-meblock"><span class="ib-mgitxt"><?php echo __("Friend&#039s Information", IDXBOOST_DOMAIN_THEME_LANG); ?></span>
          <div class="ib-mgiwrapper">
            <input class="ib-meinput" name="friend_email" type="email" placeholder="<?php echo __("Friend&#039s Email", IDXBOOST_DOMAIN_THEME_LANG); ?>*" value="" required>
          </div>
          <div class="ib-mgiwrapper">
            <input class="ib-meinput" name="friend_name" type="text" placeholder="<?php echo __("Friend&#039s Name", IDXBOOST_DOMAIN_THEME_LANG); ?>*" value="" required>
          </div>
        </div>
        <div class="ib-meblock"><span class="ib-mgitxt"><?php echo __("Your Information", IDXBOOST_DOMAIN_THEME_LANG); ?></span>
          <div class="ib-mgiwrapper">
            <input class="ib-meinput" name="your_name" type="text" placeholder="<?php echo __("Your Name", IDXBOOST_DOMAIN_THEME_LANG); ?>*" value="" required>
          </div>
          <div class="ib-mgiwrapper">
            <input class="ib-meinput" name="your_email" type="email" placeholder="<?php echo __("Your Email", IDXBOOST_DOMAIN_THEME_LANG); ?>*" value="" required>
          </div>
          <div class="ib-mgiwrapper ib-mgtextarea">
            <textarea class="ib-metextarea" name="comments" type="text" placeholder="<?php echo __("Comments", IDXBOOST_DOMAIN_THEME_LANG); ?>*" required></textarea>
          </div>
        </div>
        <span class="ib-merequired">* <?php echo __("Required fields", IDXBOOST_DOMAIN_THEME_LANG); ?></span>
        <button type="submit" class="ib-mgsubmit"><?php echo __("Submit", IDXBOOST_DOMAIN_THEME_LANG); ?></button>
      </div>
    </form>
  </div>
  <div class="ib-mmclose"><span class="ib-mmctxt"><?php echo __("Close", IDXBOOST_DOMAIN_THEME_LANG); ?></span></div>
</div>
<div class="ib-mmbg"></div>
</div>

<div class="ib-modal-master" data-id="submit" id="ib-email-thankyou">
<div class="ib-mmcontent">
  <div class="ib-mgeneric ib-msubmit"><span class="ib-mssent ib-mstxt ib-icon-check"><?php echo __("Email Sent", IDXBOOST_DOMAIN_THEME_LANG); ?>! </span><span class="ib-mssucces ib-mstxt"><?php echo __("Your email was sent succesfully", IDXBOOST_DOMAIN_THEME_LANG); ?></span></div>
  <div class="ib-mmclose"><span class="ib-mmctxt"><?php echo __("Close", IDXBOOST_DOMAIN_THEME_LANG); ?></span></div>
</div>
<div class="ib-mmbg"></div>
</div>

<div class="ib-modal-master" data-id="save-search" id="ib-fsearch-save-modal">
  <div class="ib-mmcontent">
    <div class="ib-mwrapper ib-mgeneric">
      <div class="ib-mgheader">
        <h4 class="ib-mghtitle"><?php echo __("Save this search", IDXBOOST_DOMAIN_THEME_LANG); ?></h4>
      </div>
      <div class="ib-mgcontent"> 
        <ul class="ib-msavesearch">
          <li class="ib-mssitem"><span class="ib-mssitxt"><?php echo __("Search Name(*)", IDXBOOST_DOMAIN_THEME_LANG); ?></span>
            <div class="ib-mgiwrapper">
              <input class="ib-mssinput" name="search-name" type="text" placeholder="<?php echo __("Save Search", IDXBOOST_DOMAIN_THEME_LANG); ?>*">
            </div>
          </li>
          <li class="ib-mssitem"><span class="ib-mssitxt"><?php echo __("Email Updates", IDXBOOST_DOMAIN_THEME_LANG); ?></span>
            <div class="ib-mgiwrapper ib-mgwselect">
              <select class="ib-mssselect">
                <option value="--"><?php echo __("No Alert", IDXBOOST_DOMAIN_THEME_LANG); ?></option>
                <option value="1" selected=""><?php echo __("Daily", IDXBOOST_DOMAIN_THEME_LANG); ?></option>
                <option value="7"><?php echo __("Weekly", IDXBOOST_DOMAIN_THEME_LANG); ?></option>
                <option value="30"><?php echo __("Monthly", IDXBOOST_DOMAIN_THEME_LANG); ?></option>
              </select>
            </div>
          </li>
          <li class="ib-mssitem"><span class="ib-mssitxt"><?php echo __("Only Update me On", IDXBOOST_DOMAIN_THEME_LANG); ?></span>
            <ul class="ib-mssupdate">
              <li class="ib-mssuitem">
                <input class="ib-msscheckbox" type="checkbox" id="ib-check-new-listing" checked>
                <label class="ib-msslabel" for="ib-check-new-listing"><?php echo __("New Listing (Always)", IDXBOOST_DOMAIN_THEME_LANG); ?></label>
              </li>
              <li class="ib-mssuitem">
                <input class="ib-msscheckbox" type="checkbox" id="ib-check-price-change" checked>
                <label class="ib-msslabel" for="ib-check-price-change"><?php echo __("Price Change", IDXBOOST_DOMAIN_THEME_LANG); ?></label>
              </li>
              <li class="ib-mssuitem">
                <input class="ib-msscheckbox" type="checkbox" id="ib-check-status-change" checked>
                <label class="ib-msslabel" for="ib-check-status-change"><?php echo __("Status Change", IDXBOOST_DOMAIN_THEME_LANG); ?></label>
              </li>
            </ul>
          </li>
        </ul>
        <div class="ib-mgsubmit"><?php echo __("Save Search", IDXBOOST_DOMAIN_THEME_LANG); ?></div>
      </div>
    </div>
    <div class="ib-mmclose"><span class="ib-mmctxt"><?php echo __("Close", IDXBOOST_DOMAIN_THEME_LANG); ?></span></div>
  </div>
  <div class="ib-mmbg"></div>
</div>


<!-- filter for mobile device -->
<div class="ib-modal-filters-mobile" style="display:none;">
    <div class="ib-content-modal-filters-mobile">
        <!--Header modal-->
        <div class="ib-header-modal-filters-mobile">
            <!--<?php if ( isset($flex_idx_info["url_logo"]) && !empty($flex_idx_info["url_logo"]) ): ?>
          <img src="<?php echo $flex_idx_info["url_logo"]; ?>">
          <?php endif; ?>-->
          <h3 class="ib-mtitle"><?php echo __('Filters', IDXBOOST_DOMAIN_THEME_LANG); ?></h3>
          <button class="ib-close-modal-filters-mobile"><span><?php echo __('Close', IDXBOOST_DOMAIN_THEME_LANG); ?></span></button>
        </div>
        <!--Boby modal-->
        <div class="ib-body-modal-filters-mobile">
            <div class="ib-wrap-collapse">
                <!--PRICE RANGE FOR SALE-->
                <div class="ib-item-collapse ib-item-collapse-saleib-item-collapse-sale ib-item-collapse-sale ib-item-collapse">
                    <h2 class="ib-header-collapse"><?php echo __('Price Range', IDXBOOST_DOMAIN_THEME_LANG); ?></h2>
                    <div class="ib-body-collpase">
                        <div class="ib-wrap-fm">
                            <div class="ib-item-wrap-fm ib-wrap-content-select">
                              <select id="ib-min-price"></select>
                              <span class="ib-label-wrap-fm"><?php echo __('Min Price', IDXBOOST_DOMAIN_THEME_LANG); ?></span>
                            </div>
                            <div class="ib-item-wrap-fm ib-sp-fm ib-sp-fm-tp"><?php echo __('to', IDXBOOST_DOMAIN_THEME_LANG); ?></div>
                            <div class="ib-item-wrap-fm ib-wrap-content-select">
                              <select id="ib-max-price"></select>
                              <span class="ib-label-wrap-fm"><?php echo __('Max Price', IDXBOOST_DOMAIN_THEME_LANG); ?></span>
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
                              <select id="ib-min-beds"></select>
                              <span class="ib-label-wrap-fm"><?php echo __('Min Beds', IDXBOOST_DOMAIN_THEME_LANG); ?></span>
                            </div>
                            <div class="ib-item-wrap-fm ib-sp-fm ib-sp-fm-tp"><?php echo __('to', IDXBOOST_DOMAIN_THEME_LANG); ?></div>
                            <div class="ib-item-wrap-fm ib-wrap-content-select">
                              <select id="ib-max-beds"></select>
                              <span class="ib-label-wrap-fm"><?php echo __('Max Beds', IDXBOOST_DOMAIN_THEME_LANG); ?></span>
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
                            <select id="ib-min-baths"></select>
                            <span class="ib-label-wrap-fm"><?php echo __('Min Baths', IDXBOOST_DOMAIN_THEME_LANG); ?></span>
                            </div>
                            <div class="ib-item-wrap-fm ib-sp-fm ib-sp-fm-tp"><?php echo __('to', IDXBOOST_DOMAIN_THEME_LANG); ?></div>
                            <div class="ib-item-wrap-fm ib-wrap-content-select">
                            <select id="ib-max-baths"></select>
                            <span class="ib-label-wrap-fm"><?php echo __('Max Baths', IDXBOOST_DOMAIN_THEME_LANG); ?></span>
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
                            <select id="ib-min-living"></select>
                                <span class="ib-label-wrap-fm"><?php echo __('Min Size', IDXBOOST_DOMAIN_THEME_LANG); ?></span>
                            </div>
                            <div class="ib-item-wrap-fm ib-sp-fm ib-sp-fm-tp"><?php echo __('to', IDXBOOST_DOMAIN_THEME_LANG); ?></div>
                            <div class="ib-item-wrap-fm ib-wrap-content-select">
                            <select id="ib-max-living"></select>
                            <span class="ib-label-wrap-fm"><?php echo __('Max Size', IDXBOOST_DOMAIN_THEME_LANG); ?></span>
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
                            <select id="ib-min-land"></select>
                                <span class="ib-label-wrap-fm"><?php echo __('Min Size', IDXBOOST_DOMAIN_THEME_LANG); ?></span>
                            </div>
                            <div class="ib-item-wrap-fm ib-sp-fm ib-sp-fm-tp"><?php echo __('to', IDXBOOST_DOMAIN_THEME_LANG); ?></div>
                            <div class="ib-item-wrap-fm ib-wrap-content-select">
                            <select id="ib-max-land"></select>
                            <span class="ib-label-wrap-fm"><?php echo __('Max Size', IDXBOOST_DOMAIN_THEME_LANG); ?></span>
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
                            <select id="ib-min-year"></select>
                                <span class="ib-label-wrap-fm"><?php echo __('Min Year', IDXBOOST_DOMAIN_THEME_LANG); ?></span>
                            </div>
                            <div class="ib-item-wrap-fm ib-sp-fm ib-sp-fm-tp"><?php echo __('to', IDXBOOST_DOMAIN_THEME_LANG); ?></div>
                            <div class="ib-item-wrap-fm ib-wrap-content-select">
                            <select id="ib-max-year"></select>
                            <span class="ib-label-wrap-fm"><?php echo __('Max Year', IDXBOOST_DOMAIN_THEME_LANG); ?></span>
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
<!-- filter for mobile device -->
<div id="printMessageBox">Please wait while we create your document</div>
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
                  <a href="tel:<?php echo $idx_contact_phone; ?>" class="ib-pbtnphone"><?php echo __("Call Us", IDXBOOST_DOMAIN_THEME_LANG); ?></a>
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
                      <li class="ib-pilitem ib-pilprice"><span class="ib-pipn">{{price}}{{ isRentalType this }}</span>
                        <div class="ib-pipasking">
                          <div class="ib-pipatxt"><?php echo __("Asking Price", IDXBOOST_DOMAIN_THEME_LANG); ?></div>
                          {{{ idxReduced reduced }}}
                        </div>
                      </li>
                      <li class="ib-pilitem ib-pilbeds"><span class="ib-pilnumber">{{bed}}</span><span class="ib-piltxt"><?php echo __("Bedroom(s)", IDXBOOST_DOMAIN_THEME_LANG); ?></span></li>
                      <li class="ib-pilitem ib-pilbaths"><span class="ib-pilnumber">{{bath}}</span><span class="ib-piltxt"><?php echo __("Bathroom(s)", IDXBOOST_DOMAIN_THEME_LANG); ?></span></li>
                      <li class="ib-pilitem ib-pilhbaths"><span class="ib-pilnumber">{{baths_half}}</span><span class="ib-piltxt"><?php echo __("Half Bath(s)", IDXBOOST_DOMAIN_THEME_LANG); ?></span></li>
                      <li class="ib-pilitem ib-pilsize"><span class="ib-pilnumber">{{sqft}}</span><span class="ib-piltxt"><?php echo __("Size sq.ft.", IDXBOOST_DOMAIN_THEME_LANG); ?></span></li>
                    </ul>
                    <div class="ib-pfavorite {{ idxFavoriteClass this }}" data-mls="{{mls_num}}" data-token-alert="{{token_alert}}">
                      <div class="ib-pftxt">{{ idxFavoriteText this }}</div>
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
                      <div class="ib-psbtn"><span class="ib-pstxt"><?php echo __("Mortgage", IDXBOOST_DOMAIN_THEME_LANG); ?></span></div>
                    </li>
                    <li class="ib-pscitem ib-psemailfriend" data-mls="{{mls_num}}" data-status="{{status_type}}" data-permalink="">
                      <div class="ib-psbtn"><span class="ib-pstxt"><?php echo __("Email to a friend", IDXBOOST_DOMAIN_THEME_LANG); ?></span></div>
                    </li>
                    <li class="ib-pscitem ib-psprint">
                      <div class="ib-psbtn"><span class="ib-pstxt"><?php echo __("print", IDXBOOST_DOMAIN_THEME_LANG); ?></span></div>
                    </li>
                  </ul>
                  {{#if remark}}
                  <div class="ib-pdescription">
                    <p>{{remark}}</p>
                  </div>
                  {{/if}}

                  {{#if descriptionEspe}}
                  <div class="ib-description-especial">
                    {{{descriptionEspe}}}
                  </div>
                  {{/if}}


                  <ul class="ib-pacordeon">
                    <li class="ib-paitem ib-pai-active">
                      <h4 class="ib-paititle"><?php echo __("Property Details", IDXBOOST_DOMAIN_THEME_LANG); ?></h4>
                      <div class="ib-paicontent">
                        <ul class="ib-pldetails">
                        <li class="ib-plditem"><span class="ib-pltxta"><?php echo __('MLS #', IDXBOOST_DOMAIN_THEME_LANG); ?></span><span class="ib-pltxtb">{{mls_num}}</span></li>
                                                <li class="ib-plditem"><span class="ib-pltxta"><?php echo __('Type', IDXBOOST_DOMAIN_THEME_LANG); ?></span><span class="ib-pltxtb">{{property_type}}</span></li>
                                                <li class="ib-plditem"><span class="ib-pltxta"><?php echo __('Status', IDXBOOST_DOMAIN_THEME_LANG); ?></span><span class="ib-pltxtb">{{status_name}}</span></li>
                                                <li class="ib-plditem"><span class="ib-pltxta"><?php echo __('Development', IDXBOOST_DOMAIN_THEME_LANG); ?></span><span class="ib-pltxtb">{{development}}</span></li>
                                                <li class="ib-plditem"><span class="ib-pltxta"><?php echo __('Subdivision', IDXBOOST_DOMAIN_THEME_LANG); ?></span><span class="ib-pltxtb">{{subdivision}}</span></li>
                                                <li class="ib-plditem"><span class="ib-pltxta"><?php echo __('Sale Type', IDXBOOST_DOMAIN_THEME_LANG); ?></span><span class="ib-pltxtb">{{short_sale}}</span></li>
                                                {{#if is_commercial}}
                                                <li class="ib-plditem"><span class="ib-pltxta"><?php echo __('Approx Lot Size', IDXBOOST_DOMAIN_THEME_LANG); ?></span><span class="ib-pltxtb">{{lot_size}}</span></li>
                                                {{else}}
                                                <li class="ib-plditem"><span class="ib-pltxta"><?php echo __('Lot Size', IDXBOOST_DOMAIN_THEME_LANG); ?></span><span class="ib-pltxtb">{{lot_size}}</span></li>
                                                {{/if}}
                                                {{#unless is_commercial}}
                                                <li class="ib-plditem"><span class="ib-pltxta"><?php echo __('Price / Sq.Ft.', IDXBOOST_DOMAIN_THEME_LANG); ?></span><span class="ib-pltxtb">{{price_sqft}}</span></li>
                                                {{/unless}}
                                                {{#if is_commercial}}
                                                <li class="ib-plditem"><span class="ib-pltxta"><?php echo __('Parking', IDXBOOST_DOMAIN_THEME_LANG); ?></span><span class="ib-pltxtb">{{parking_desc}}</span></li>
                                                {{else}}
                                                <li class="ib-plditem"><span class="ib-pltxta"><?php echo __('Parking Spaces', IDXBOOST_DOMAIN_THEME_LANG); ?></span><span class="ib-pltxtb">{{parking}}</span></li>
                                                {{/if}}
                                                {{#unless is_commercial}}
                                                <li class="ib-plditem"><span class="ib-pltxta"><?php echo __('Swimming Pool', IDXBOOST_DOMAIN_THEME_LANG); ?></span><span class="ib-pltxtb">{{pool}}</span></li>
                                                {{/unless}}
                                                <li class="ib-plditem"><span class="ib-pltxta"><?php echo __('Days on Market', IDXBOOST_DOMAIN_THEME_LANG); ?></span><span class="ib-pltxtb">{{days_market}}</span></li>
                                                <li class="ib-plditem"><span class="ib-pltxta"><?php echo __('Year Built', IDXBOOST_DOMAIN_THEME_LANG); ?></span><span class="ib-pltxtb">{{year}}</span></li>

                                                <?php if (isset($c_search_settings["board_id"]) && ("11" == $c_search_settings["board_id"])){ ?>
                                                  <li class="ib-plditem"><span class="ib-pltxta"><?php echo __('View Description', IDXBOOST_DOMAIN_THEME_LANG); ?></span><span class="ib-pltxtb">{{wv}}</span></li>
                                                <?php }else{ ?>
                                                  <li class="ib-plditem"><span class="ib-pltxta"><?php echo __('Style', IDXBOOST_DOMAIN_THEME_LANG); ?></span><span class="ib-pltxtb">{{style}}</span></li>
                                                <?php } ?>

                                                <li class="ib-plditem"><span class="ib-pltxta"><?php echo __('Waterfront', IDXBOOST_DOMAIN_THEME_LANG); ?></span><span class="ib-pltxtb">{{water_front}}</span></li>
                                                <li class="ib-plditem"><span class="ib-pltxta"><?php echo __('Furnished', IDXBOOST_DOMAIN_THEME_LANG); ?></span><span class="ib-pltxtb">{{furnished}}</span></li>
                                                <li class="ib-plditem"><span class="ib-pltxta"><?php echo __('Flooring Type', IDXBOOST_DOMAIN_THEME_LANG); ?></span><span class="ib-pltxtb">{{floor}}</span></li>
                                                <li class="ib-plditem"><span class="ib-pltxta"><?php echo __('Date Listed', IDXBOOST_DOMAIN_THEME_LANG); ?></span><span class="ib-pltxtb">{{list_date}}</span></li>
                                                {{#unless is_commercial}}
                                                <li class="ib-plditem"><span class="ib-pltxta"><?php echo __('HOA Fees', IDXBOOST_DOMAIN_THEME_LANG); ?></span><span class="ib-pltxtb">{{assoc_fee}}</span></li>
                                                {{/unless}}
                                                {{#if is_commercial}}
                                                <li class="ib-plditem"><span class="ib-pltxta"><?php echo __('Cooling', IDXBOOST_DOMAIN_THEME_LANG); ?></span><span class="ib-pltxtb">{{cooling}}</span></li>
                                                <li class="ib-plditem"><span class="ib-pltxta"><?php echo __('Heating', IDXBOOST_DOMAIN_THEME_LANG); ?></span><span class="ib-pltxtb">{{heating}}</span></li>
                                                {{else}}
                                                <li class="ib-plditem"><span class="ib-pltxta"><?php echo __('Cooling Type', IDXBOOST_DOMAIN_THEME_LANG); ?></span><span class="ib-pltxtb">{{cooling}}</span></li>
                                                <li class="ib-plditem"><span class="ib-pltxta"><?php echo __('Heating Type', IDXBOOST_DOMAIN_THEME_LANG); ?></span><span class="ib-pltxtb">{{heating}}</span></li>
                                                {{/if}}
                                                <li class="ib-plditem"><span class="ib-pltxta"><?php echo __('Taxes Year', IDXBOOST_DOMAIN_THEME_LANG); ?></span><span class="ib-pltxtb">{{tax_year}}</span></li>
                                                <li class="ib-plditem"><span class="ib-pltxta"><?php echo __('Taxes', IDXBOOST_DOMAIN_THEME_LANG); ?></span><span class="ib-pltxtb">{{tax_amount}}</span></li>
                        <?php /*
                          <li class="ib-plditem"><span class="ib-pltxta"><?php echo __("MLS #", IDXBOOST_DOMAIN_THEME_LANG); ?></span><span class="ib-pltxtb">{{mls_num}}</span></li>
                          <li class="ib-plditem"><span class="ib-pltxta"><?php echo __("Type", IDXBOOST_DOMAIN_THEME_LANG); ?></span><span class="ib-pltxtb">{{class_id}}</span></li>
                          <li class="ib-plditem"><span class="ib-pltxta"><?php echo __("Status", IDXBOOST_DOMAIN_THEME_LANG); ?></span><span class="ib-pltxtb">{{status_type}}</span></li>
                          <li class="ib-plditem"><span class="ib-pltxta"><?php echo __("Development", IDXBOOST_DOMAIN_THEME_LANG); ?></span><span class="ib-pltxtb">{{development}}</span></li>
                          <li class="ib-plditem"><span class="ib-pltxta"><?php echo __("Subdivision", IDXBOOST_DOMAIN_THEME_LANG); ?></span><span class="ib-pltxtb">{{subdivision}}</span></li>
                          <li class="ib-plditem"><span class="ib-pltxta"><?php echo __("Sale Type", IDXBOOST_DOMAIN_THEME_LANG); ?></span><span class="ib-pltxtb">{{short_sale}}</span></li>
                          <li class="ib-plditem"><span class="ib-pltxta"><?php echo __("Lot Size", IDXBOOST_DOMAIN_THEME_LANG); ?></span><span class="ib-pltxtb">{{lot_size}}</span></li>
                          <li class="ib-plditem"><span class="ib-pltxta"><?php echo __("Price / Sq.Ft.", IDXBOOST_DOMAIN_THEME_LANG); ?></span><span class="ib-pltxtb">{{price_sqft}}</span></li>
                          <li class="ib-plditem"><span class="ib-pltxta"><?php echo __("Parking Spaces", IDXBOOST_DOMAIN_THEME_LANG); ?></span><span class="ib-pltxtb">{{parking}}</span></li>
                          <li class="ib-plditem"><span class="ib-pltxta"><?php echo __("Swimming Pool", IDXBOOST_DOMAIN_THEME_LANG); ?></span><span class="ib-pltxtb">{{pool}}</span></li>
                          <li class="ib-plditem"><span class="ib-pltxta"><?php echo __("Days on Market", IDXBOOST_DOMAIN_THEME_LANG); ?></span><span class="ib-pltxtb">{{days_market}}</span></li>
                          <li class="ib-plditem"><span class="ib-pltxta"><?php echo __("Year Built", IDXBOOST_DOMAIN_THEME_LANG); ?></span><span class="ib-pltxtb">{{year}}</span></li>
                          <li class="ib-plditem"><span class="ib-pltxta"><?php echo __("Style", IDXBOOST_DOMAIN_THEME_LANG); ?></span><span class="ib-pltxtb">{{style}}</span></li>
                          <li class="ib-plditem"><span class="ib-pltxta"><?php echo __("Waterfront", IDXBOOST_DOMAIN_THEME_LANG); ?></span><span class="ib-pltxtb">{{water_front}}</span></li>
                          <li class="ib-plditem"><span class="ib-pltxta"><?php echo __("Furnished", IDXBOOST_DOMAIN_THEME_LANG); ?></span><span class="ib-pltxtb">{{furnished}}</span></li>
                          <li class="ib-plditem"><span class="ib-pltxta"><?php echo __("Flooring Type", IDXBOOST_DOMAIN_THEME_LANG); ?></span><span class="ib-pltxtb">{{floor}}</span></li>
                          <li class="ib-plditem"><span class="ib-pltxta"><?php echo __("Date Listed", IDXBOOST_DOMAIN_THEME_LANG); ?></span><span class="ib-pltxtb">{{list_date}}</span></li>
                          <li class="ib-plditem"><span class="ib-pltxta"><?php echo __("HOA Fees", IDXBOOST_DOMAIN_THEME_LANG); ?></span><span class="ib-pltxtb">N/A</span></li>
                          <li class="ib-plditem"><span class="ib-pltxta"><?php echo __("Cooling Type", IDXBOOST_DOMAIN_THEME_LANG); ?></span><span class="ib-pltxtb">Central</span></li>
                          <li class="ib-plditem"><span class="ib-pltxta"><?php echo __("Heating Type", IDXBOOST_DOMAIN_THEME_LANG); ?></span><span class="ib-pltxtb">None</span></li>
                          <li class="ib-plditem"><span class="ib-pltxta"><?php echo __("Taxes Year", IDXBOOST_DOMAIN_THEME_LANG); ?></span><span class="ib-pltxtb">{{tax_year}}</span></li>
                          <li class="ib-plditem"><span class="ib-pltxta"><?php echo __("Taxes", IDXBOOST_DOMAIN_THEME_LANG); ?></span><span class="ib-pltxtb">{{tax_amount}}</span></li>
                          */ ?>
                        </ul>
                      </div>
                    </li>
                    {{#if amenities}}
                    <li class="ib-paitem">
                      <h4 class="ib-paititle"><?php echo __("Amenities", IDXBOOST_DOMAIN_THEME_LANG); ?></h4>
                      <div class="ib-paicontent">
                        <ul class="ib-plgeneric">
                            {{#each amenities}}
                            <li class="ib-plgitem">{{this}}</li>
                            {{/each}}
                        </ul>
                      </div>
                    </li>
                    {{/if}}
                    {{#if feature_interior}}
                    <li class="ib-paitem">
                      <h4 class="ib-paititle"><?php echo __("Interior Features", IDXBOOST_DOMAIN_THEME_LANG); ?></h4>
                      <div class="ib-paicontent">
                        <ul class="ib-plgeneric">
                            {{#each feature_interior}}
                            <li class="ib-plgitem">{{this}}</li>
                            {{/each}}
                        </ul>
                      </div>
                    </li>
                    {{/if}}
                    {{#if feature_exterior}}
                    <li class="ib-paitem">
                      <h4 class="ib-paititle"><?php echo __("Exterior Features", IDXBOOST_DOMAIN_THEME_LANG); ?></h4>
                      <div class="ib-paicontent">
                        <ul class="ib-plgeneric">
                            {{#each feature_exterior}}
                            <li class="ib-plgitem">{{this}}</li>
                            {{/each}}
                        </ul>
                      </div>
                    </li>
                    {{/if}}
                    
                    {{#if lat }}
                    <li class="ib-paitem ib-pai-active">
                        <h4 class="ib-paititle"><?php echo __('Location', IDXBOOST_DOMAIN_THEME_LANG); ?></h4>
                        <div class="ib-paicontent">
                            <div id="ib-modal-property-map" style="background-color:#EEE;height:300px;width:100%;margin:15px 0;"></div>
                        </div>
                    </li>
                    {{/if}}

                    <?php /*<li class="ib-paitem">
                      <h4 class="ib-paititle">School Information</h4>
                      <div class="ib-paicontent"></div>
                    </li>*/ ?>
                  </ul>
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

                  <div class="ib-bdisclaimer">
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
                          <li class="ib-spditem ib-spsqft"><span class="ib-spdbold">{{ formatSqft sqft }}</span> <?php echo __("Sq.Ft.", IDXBOOST_DOMAIN_THEME_LANG); ?></li>
                          <li class="ib-spditem ib-spsqft"><span class="ib-spdbold">${{ formatPriceSqft this }}</span> / <?php echo __("Sq.Ft.", IDXBOOST_DOMAIN_THEME_LANG); ?></li>
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
            </div>

            <button class="ib-btn-request ib-active-float-form"><?php echo __("Request information", IDXBOOST_DOMAIN_THEME_LANG); ?></button>
          </div>
        </article>
      </div>
      <div class="ib-mmbg"></div>
    </div>
</script>

<script id="ib-aside-template" type="text/x-handlebars-template">
{{#each this}}
{{{ capturePositionHackbox @index }}}
<li class="ib-pitem" data-geocode="{{ lat }}:{{ lng }}" data-mls="{{ mls_num }}">
    <ul class="ib-piinfo">
        <li class="ib-piitem ib-piprice">{{ formatPrice price }}</li>
        <li class="ib-piitem ib-pibeds">{{ bed }} <?php echo __("bed(s)", IDXBOOST_DOMAIN_THEME_LANG); ?></li>
        <li class="ib-piitem ib-pibaths">{{ bath }} <?php echo __("bath(s)", IDXBOOST_DOMAIN_THEME_LANG); ?></li>
        <li class="ib-piitem ib-pisqft">{{ formatSqft sqft }} <?php echo __("Sq.Ft.", IDXBOOST_DOMAIN_THEME_LANG); ?></li>
        <li class="ib-piitem ib-paddress">{{ address_short }} {{ address_large }}</li>
        <li class="ms-logo-board"><img src="{{board_info.board_logo_url}}"></li>  
    </ul>
    <div class="ib-pislider {{ idxImageEmpty this }} gs-container-slider" data-img-cnt="{{ img_cnt }}" data-mls="{{ mls_num }}">
        <img class="ib-pifimg" src="{{ idxImage this }}" alt="{{ address_short }} {{ address_large }}">
        <div class="gs-container-navs">
        <div class="gs-wrapper-arrows">
            <button class="gs-prev-arrow"></button>
            <button class="gs-next-arrow"></button>
        </div>
        </div>
    </div>
    <div class="ib-pfavorite {{ idxFavoriteClass this }}" data-mls="{{ mls_num }}" data-token-alert="{{token_alert}}"><?php /*<span>Add to Favorites</span> */ ?></div>
    <a class="ib-pipermalink" href="#" title="<?php echo __("View Detail of", IDXBOOST_DOMAIN_THEME_LANG); ?> {{ address_short }} {{ address_large }}"><span>{{ address_short }} {{ address_large }}</span></a>
</li>
{{/each}}
</script>
