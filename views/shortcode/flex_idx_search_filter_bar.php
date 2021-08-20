<style>
.ib-price-range-wrap { display: none; }
#ui-id-1 {max-width:500px !important;}
</style>

                <?php
                $c_search_settings = get_option("idxboost_search_settings");
                
                $label_waterfront_description = __('Waterfront Description', IDXBOOST_DOMAIN_THEME_LANG);
                if (isset($c_search_settings["board_id"]) && ("11" == $c_search_settings["board_id"])){
                  $label_waterfront_description = __("View Description", IDXBOOST_DOMAIN_THEME_LANG);
                }elseif ( isset($c_search_settings["board_id"]) && ("16" == $c_search_settings["board_id"]) ) {
                  $label_waterfront_description = __("View Features", IDXBOOST_DOMAIN_THEME_LANG);
                }
                ?>
                
<h1 class="ms-hidden"><?php the_title(); ?></h1>
<div class="ib-filter-container fixed-box">
  <div class="ib-fheader">
    <div class="ib-fhpa">
      <div class="ib-fhpa-minisearch">
        <label for="ib-fmsearch-a" class="ms-hidden"><?php echo __('Enter Address, City, Zip Code, Subdivision', IDXBOOST_DOMAIN_THEME_LANG); ?></label>
        <?php if ( (isset($atts["agent_id"]) && !empty($atts["agent_id"])) || (isset($atts["office_id"]) && !empty($atts["office_id"])) ): ?>
        <input id="ib-fmsearch-a" class="ib-fmsearch ib-fmsearchsuggestions ib-fcitiesnon-hide" autocorrect="off" autocapitalize="off" spellcheck="false" autocomplete="disabled" autocomplete="disabled" type="search" data-type="outer-ac" placeholder="<?php echo __('Enter Address, City, Zip Code, Subdivision', IDXBOOST_DOMAIN_THEME_LANG); ?>" disabled>
        <?php else: ?>
        <input id="ib-fmsearch-a" class="ib-fmsearch ib-fmsearchsuggestions ib-fcitiesnon-hide" autocorrect="off" autocapitalize="off" spellcheck="false" autocomplete="disabled" autocomplete="disabled" type="search" data-type="outer-ac" placeholder="<?php echo __('Enter Address, City, Zip Code, Subdivision', IDXBOOST_DOMAIN_THEME_LANG); ?>">
        <?php endif; ?>
        
        <div class="ib-fmsubmit ib-icon-search ib-kw-tg-search"><span class="ib-btext"><?php echo __('Search', IDXBOOST_DOMAIN_THEME_LANG); ?></span></div>
        <div class="ib-fcities ib-fcitiesnon-hide">
          <ul class="ib-lcities"></ul>
          </div>
        <div id="ib-autocomplete-add"></div>
      </div>
      <div class="ib-fhpa-advanced">
        <div class="ib-badvanced ib-icon-filters ib-oadbanced">
          <span class="ib-bmore"><?php echo __('More', IDXBOOST_DOMAIN_THEME_LANG); ?></span>
          <span class="ib-bfilters"><?php echo __('Filter', IDXBOOST_DOMAIN_THEME_LANG); ?></span>
        </div>
      </div>
      <div class="ib-fhpa-directbtns">
        <div class="ib-dbitem ib-dbclear ib-icon-carrow"><span class="ib-btext"><?php echo __('Clear', IDXBOOST_DOMAIN_THEME_LANG); ?></span></div>
        <div class="ib-dbitem ib-dbsave ib-icon-save js-alert-update-preferences"><span class="ib-btext"><?php echo __('Save', IDXBOOST_DOMAIN_THEME_LANG); ?></span></div>
      </div>
    </div>
    <div class="ib-fhpb">
      <ul class="ib-fhpb-openers">
        <li class="ib-oitem ib-oprice">
          <div class="ib-oiwrapper"><span class="ib-iotxt ib-lbl-price-ntf"><?php echo __('Any Price', IDXBOOST_DOMAIN_THEME_LANG); ?></span></div>
          <div class="ib-fimini">
            <div class="ib-fititle"><?php echo __('Price Range', IDXBOOST_DOMAIN_THEME_LANG); ?></div>
            <div class="ib-ficontent ib-price-range-outer">
              
              <div class="ib-price-range-wrap ib-price-range-wrap-sale">
                <div class="ib-wimputs">
                  <label for="ib-ffrom-sale-mrs" class="ms-hidden"><?php echo __('Enter a min price range sale', IDXBOOST_DOMAIN_THEME_LANG); ?></label>
                  <input id="ib-ffrom-sale-mrs" class="notranslate ib-iffrom ib-ffrom-sale ib-rprice-sale-lbl-lt" readonly type="text" readonly value="">
                  <span class="ib-iftxt"><?php echo __('to', IDXBOOST_DOMAIN_THEME_LANG); ?></span>
                  <label for="ib-ffrom-sale-mxrs" class="ms-hidden"><?php echo __('Enter a max price range sale', IDXBOOST_DOMAIN_THEME_LANG); ?></label>
                  <input id="ib-ffrom-sale-mxrs" class="notranslate ib-ifto ib-ifto-sale ib-rprice-sale-lbl-rt" readonly type="text" readonly value="">
                </div>
                <div class="ib-wrange">
                  <div class="ib-range ib-rprice-sale"></div>
                </div>
              </div>

              <div class="ib-price-range-wrap ib-price-range-wrap-rent">
                <div class="ib-wimputs">
                  <label for="ib-ffrom-rent-mrs" class="ms-hidden"><?php echo __('Enter a min price range rent', IDXBOOST_DOMAIN_THEME_LANG); ?></label>
                  <input id="ib-ffrom-rent-mrs" class="notranslate ib-iffrom ib-ffrom-rent ib-rprice-rent-lbl-lt" readonly type="text" readonly value="">
                  <span class="ib-iftxt"><?php echo __('to', IDXBOOST_DOMAIN_THEME_LANG); ?></span>
                  <label for="ib-ffrom-rent-mxrs" class="ms-hidden"><?php echo __('Enter a max price range rent', IDXBOOST_DOMAIN_THEME_LANG); ?></label>
                  <input id="ib-ffrom-rent-mxrs" class="notranslate ib-ifto ib-ifto-rent ib-rprice-rent-lbl-rt" readonly type="text" readonly value="">
                </div>
                <div class="ib-wrange">
                  <div class="ib-range ib-rprice-rent"></div>
                </div>
              </div>

            </div>
          </div>
        </li>
        <li class="ib-oitem ib-obed">
          <div class="ib-oiwrapper"><span class="ib-iotxt ib-lbl-bed-ntf"><?php echo __('Any Bed(s)', IDXBOOST_DOMAIN_THEME_LANG); ?></span></div>
          <div class="ib-fimini">
            <div class="ib-fititle"><?php echo __('Bedrooms', IDXBOOST_DOMAIN_THEME_LANG); ?></div>
            <div class="ib-ficontent">
              <div class="ib-wrange">
                <div class="ib-range ib-rbedrooms"></div>
                <ul class="ib-rmarkers">
                  <li class="ib-rmitem"><span class="ib-rmtxt"><?php echo __('Studio', IDXBOOST_DOMAIN_THEME_LANG); ?></span></li>
                  <li class="ib-rmitem">1</li>
                  <li class="ib-rmitem">2</li>
                  <li class="ib-rmitem">3</li>
                  <li class="ib-rmitem">4</li>
                  <li class="ib-rmitem">5</li>
                  <li class="ib-rmitem">5+</li>
                </ul>
              </div>
            </div>
          </div>
        </li>
        <li class="ib-oitem ib-obath">
          <div class="ib-oiwrapper"><span class="ib-iotxt ib-lbl-bath-ntf"><?php echo __('Any Bath(s)', IDXBOOST_DOMAIN_THEME_LANG); ?></span></div>
          <div class="ib-fimini">
            <div class="ib-fititle"><?php echo __('Bathrooms', IDXBOOST_DOMAIN_THEME_LANG); ?></div>
            <div class="ib-ficontent">
              <div class="ib-wrange">
                <div class="ib-range ib-rbathrooms"></div>
                <ul class="ib-rmarkers">
                  <li class="ib-rmitem">0</li>
                  <li class="ib-rmitem">1</li>
                  <li class="ib-rmitem">2</li>
                  <li class="ib-rmitem">3</li>
                  <li class="ib-rmitem">4</li>
                  <li class="ib-rmitem">5</li>
                  <li class="ib-rmitem">5+</li>
                </ul>
              </div>
            </div>
          </div>
        </li>
        <li class="ib-oitem ib-otype">
          <div class="ib-oiwrapper"><span class="ib-iotxt ib-lbl-types-ntf"><?php echo __('Any Type', IDXBOOST_DOMAIN_THEME_LANG); ?></span></div>
          <div class="ib-fimini">
            <div class="ib-fititle"><?php echo __('Any Type', IDXBOOST_DOMAIN_THEME_LANG); ?></div>
            <div class="ib-ficontent">
              <ul class="ib-wchecks ib-types-options" data-type="outer"></ul>
            </div>
          </div>
        </li>
        <li class="ib-oitem ib-oadbanced">
          <div class="ib-oiwrapper"><span class="ib-iotxt"><?php echo __('More Filters', IDXBOOST_DOMAIN_THEME_LANG); ?></span></div>
          <div class="ib-fdesktop ib-hack-all-filters">
            <div class="ib-fdcwrapper">
              <div class="ib-fdcol">
                <div class="ib-fitem">
                  <div class="ib-fititle"><?php echo __('Property Search', IDXBOOST_DOMAIN_THEME_LANG); ?></div>
                  <div class="ib-ficontent ib-ficontent-mod1">
                    <div class="ib-fforsr">
                      <div class="ib-ffsale ib-fifor" data-type="sale"><?php echo __('For Sale', IDXBOOST_DOMAIN_THEME_LANG); ?></div>
                      <div class="ib-ffrent ib-fifor" data-type="rent"><?php echo __('For Rent ', IDXBOOST_DOMAIN_THEME_LANG); ?></div>
                    </div>
                    <?php /*
                    <div class="ib-fhpa-minisearch">
                      <input class="ib-fmsearch" data-type="inner-ac" type="search" placeholder="<?php echo __('Enter Address, City, Zip Code, Subdivision', IDXBOOST_DOMAIN_THEME_LANG); ?>">
                      <div class="ib-fmsubmit ib-icon-search ib-kw-tg-search"><span class="ib-btext"><?php echo __('Search', IDXBOOST_DOMAIN_THEME_LANG); ?></span></div>
                    </div> */ ?>
                  </div>
                </div>
                <?php /*
                <div class="ib-fcities">
                  <ul class="ib-lcities"></ul>
                </div> */ ?>
                <div class="ib-fitem">
                  <div class="ib-fititle"><?php echo __('Price Range', IDXBOOST_DOMAIN_THEME_LANG); ?></div>
                  <div class="ib-ficontent ib-price-range-inner">
                    <div class="ib-price-range-wrap ib-price-range-wrap-sale">
                    <div class="ib-wimputs">
                      <label for="ib-price-mrs" class="ms-hidden"><?php echo __('Enter a min price range', IDXBOOST_DOMAIN_THEME_LANG); ?></label>
                      <input id="ib-price-mrs" class="notranslate ib-iffrom ib-ffrom-sale ib-rprice-sale-lbl-lt" readonly type="text" readonly value="">
                      <span class="ib-iftxt"><?php echo __('to', IDXBOOST_DOMAIN_THEME_LANG); ?></span>
                      <label for="ib-price-mxrs" class="ms-hidden"><?php echo __('Enter a max price range', IDXBOOST_DOMAIN_THEME_LANG); ?></label>
                      <input id="ib-price-mxrs" class="notranslate ib-ifto ib-ifto-sale ib-rprice-sale-lbl-rt" readonly type="text" readonly value="">
                    </div>
                    <div class="ib-wrange">
                      <div class="ib-range ib-rprice-sale"></div>
                    </div>
                  </div>

                  <div class="ib-price-range-wrap ib-price-range-wrap-rent">
                    <div class="ib-wimputs">
                      <label for="ib-price-rent-mrs" class="ms-hidden"><?php echo __('Enter a min rent price range', IDXBOOST_DOMAIN_THEME_LANG); ?></label>
                      <input class="notranslate ib-iffrom ib-ffrom-rent ib-rprice-rent-lbl-lt" readonly type="text" readonly value="">
                      <span class="ib-iftxt"><?php echo __('to', IDXBOOST_DOMAIN_THEME_LANG); ?></span>
                      <label for="ib-price-rent-mxrs" class="ms-hidden"><?php echo __('Enter a max rent price range', IDXBOOST_DOMAIN_THEME_LANG); ?></label>
                      <input class="notranslate ib-ifto ib-ifto-rent ib-rprice-rent-lbl-rt" readonly type="text" readonly value="">
                    </div>
                    <div class="ib-wrange">
                      <div class="ib-range ib-rprice-rent"></div>
                    </div>
                  </div>
                  </div>
                </div>
                <div class="ib-fitem">
                  <div class="ib-fititle"><?php echo __('Bedrooms', IDXBOOST_DOMAIN_THEME_LANG); ?></div>
                  <div class="ib-ficontent">
                    <div class="ib-wrange">
                      <div class="ib-range ib-rbedrooms"></div>
                      <ul class="ib-rmarkers">
                        <li class="ib-rmitem"><span class="ib-rmtxt"><?php echo __('Studio', IDXBOOST_DOMAIN_THEME_LANG); ?></span></li>
                        <li class="ib-rmitem">1</li>
                        <li class="ib-rmitem">2</li>
                        <li class="ib-rmitem">3</li>
                        <li class="ib-rmitem">4</li>
                        <li class="ib-rmitem">5</li>
                        <li class="ib-rmitem">5+</li>
                      </ul>
                    </div>
                  </div>
                </div>
                <div class="ib-fitem">
                  <div class="ib-fititle"><?php echo __('Living Size', IDXBOOST_DOMAIN_THEME_LANG); ?></div>
                  <div class="ib-ficontent">
                    <div class="ib-wimputs">
                      <label for="ib-min-living-size" class="ms-hidden"><?php echo __('Enter a min living size', IDXBOOST_DOMAIN_THEME_LANG); ?></label>
                      <input id="ib-min-living-size" class="notranslate ib-iffrom ib-rliving-lbl-lt" type="text" readonly value="">
                      <span class="ib-iftxt"><?php echo __('to', IDXBOOST_DOMAIN_THEME_LANG); ?></span>
                      <label for="ib-max-living-size" class="ms-hidden"><?php echo __('Enter a max living size', IDXBOOST_DOMAIN_THEME_LANG); ?></label>
                      <input id="ib-max-living-size" class="notranslate ib-ifto ib-rliving-lbl-rt" type="text" readonly value="">
                    </div>
                    <div class="ib-wrange">
                      <div class="ib-range ib-rliving"></div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="ib-fdcol">
                <div class="ib-fitem">
                  <div class="ib-fititle"><?php echo __('Parking Spaces', IDXBOOST_DOMAIN_THEME_LANG); ?></div>
                  <div class="ib-ficontent">
                    <div class="ib-wselect ib-icon-darrow">
                      <label for="ib-parking-options" class="ms-hidden"><?php echo __('Parking Spaces', IDXBOOST_DOMAIN_THEME_LANG); ?></label>
                      <select id="ib-parking-options" class="ib-fselect ib-parking-options">
                        <option value="--"><?php echo __('Any', IDXBOOST_DOMAIN_THEME_LANG); ?></option>
                      </select>
                    </div>
                  </div>
                </div>
                <div class="ib-fitem">
                  <div class="ib-fititle"><?php echo __('Year Built', IDXBOOST_DOMAIN_THEME_LANG); ?></div>
                  <div class="ib-ficontent">
                    <div class="ib-wimputs">
                      <label for="ib-max-yb" class="ms-hidden"><?php echo __('Enter a max year built', IDXBOOST_DOMAIN_THEME_LANG); ?></label>
                      <input id="ib-max-yb" class="notranslate ib-iffrom ib-ryear-lbl-lt" type="text" readonly value="">
                      <span class="ib-iftxt"><?php echo __('to', IDXBOOST_DOMAIN_THEME_LANG); ?></span>
                      <label for="ib-min-yb" class="ms-hidden"><?php echo __('Enter a min year built', IDXBOOST_DOMAIN_THEME_LANG); ?></label>
                      <input id="ib-min-yb" class="notranslate ib-ifto ib-ryear-lbl-rt" type="text" readonly value="">
                    </div>
                    <div class="ib-wrange">
                      <div class="ib-range ib-ryear"></div>
                    </div>
                  </div>
                </div>
                <div class="ib-fitem">
                  <div class="ib-fititle"><?php echo __('Bathrooms', IDXBOOST_DOMAIN_THEME_LANG); ?></div>
                  <div class="ib-ficontent">
                    <div class="ib-wrange">
                      <div class="ib-range ib-rbathrooms"></div>
                      <ul class="ib-rmarkers">
                        <li class="ib-rmitem">0</li>
                        <li class="ib-rmitem">1</li>
                        <li class="ib-rmitem">2</li>
                        <li class="ib-rmitem">3</li>
                        <li class="ib-rmitem">4</li>
                        <li class="ib-rmitem">5</li>
                        <li class="ib-rmitem">5+</li>
                      </ul>
                    </div>
                  </div>
                </div>
                <div class="ib-fitem">
                  <div class="ib-fititle"><?php echo __('Land Size', IDXBOOST_DOMAIN_THEME_LANG); ?></div>
                  <div class="ib-ficontent">
                    <div class="ib-wimputs">
                      <label for="ib-max-lz" class="ms-hidden"><?php echo __('Enter a max land size', IDXBOOST_DOMAIN_THEME_LANG); ?></label>
                      <input id="ib-max-lz" class="notranslate ib-iffrom ib-rland-lbl-lt" type="text" readonly value="">
                      <span class="ib-iftxt"><?php echo __('to', IDXBOOST_DOMAIN_THEME_LANG); ?></span>
                      <label for="ib-min-lz" class="ms-hidden"><?php echo __('Enter a min land size', IDXBOOST_DOMAIN_THEME_LANG); ?></label>
                      <input id="ib-min-lz" class="notranslate ib-ifto ib-rland-lbl-rt" type="text" readonly value="">
                    </div>
                    <div class="ib-wrange">
                      <div class="ib-range ib-rland"></div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="ib-fdcol">
                <div class="ib-fitem">
                  <div class="ib-fititle"><?php echo $label_waterfront_description; ?></div>
                  <div class="ib-ficontent">
                    <div class="ib-wselect ib-icon-darrow">
                      <label for="ib-wd-lz" class="ms-hidden"><?php echo $label_waterfront_description; ?></label>
                      <select class="ib-fselect ib-waterfront-options" id="ib-wd-lz">
                        <option value="--"><?php echo __('Any', IDXBOOST_DOMAIN_THEME_LANG); ?></option>
                      </select>
                    </div>
                  </div>
                </div>
                <div class="ib-fitem">
                  <div class="ib-fititle"><?php echo __('Type', IDXBOOST_DOMAIN_THEME_LANG); ?></div>
                  <div class="ib-ficontent">
                    <ul class="ib-wchecks ib-types-options" data-type="inner"></ul>
                  </div>
                </div>
                <div class="ib-fitem">
                  <div class="ib-fititle"><?php echo __('Features', IDXBOOST_DOMAIN_THEME_LANG); ?></div>
                  <div class="ib-ficontent">
                    <ul class="ib-wchecks ib-wchecks-col2 ib-amenities-options" data-type="inner-amt"></ul>
                  </div>
                  <div class="ib-fdmatching"><?php echo __('Searching...', IDXBOOST_DOMAIN_THEME_LANG); ?></div>
                </div>
              </div>
            </div>
          </div>
        </li>
      </ul>
      <div class="ib-fhpa-directbtns">
        <div class="ib-dbitem ib-dbclear ib-icon-carrow"><span class="ib-btext"><?php echo __('Clear', IDXBOOST_DOMAIN_THEME_LANG); ?></span></div>
        <div class="ib-dbitem ib-dbsave ib-icon-save js-alert-update-preferences"><span class="ib-btext"><?php echo __('Save', IDXBOOST_DOMAIN_THEME_LANG); ?></span></div>
      </div>
    </div>
    <div class="ib-fmobile">
      <ul class="ib-flist">
        <li class="ib-fitem ib-fitem-active">
          <div class="ib-fititle"><?php echo __('Price Range', IDXBOOST_DOMAIN_THEME_LANG); ?></div>
          <div class="ib-ficontent ib-price-range-mobile">

              <div class="ib-price-range-wrap ib-price-range-wrap-sale">
                <div class="ib-wimputs">
                  <label for="ib-min-lz-pr" class="ms-hidden"><?php echo __('Enter a min price range', IDXBOOST_DOMAIN_THEME_LANG); ?></label>
                  <input id="ib-min-lz-pr" class="notranslate ib-iffrom ib-ffrom-sale ib-rprice-sale-lbl-lt" readonly type="text" readonly value="">
                  <span class="ib-iftxt"><?php echo __('to', IDXBOOST_DOMAIN_THEME_LANG); ?></span>
                  <label for="ib-max-lz-pr" class="ms-hidden"><?php echo __('Enter a max price range', IDXBOOST_DOMAIN_THEME_LANG); ?></label>
                  <input id="ib-max-lz-pr" class="notranslate ib-ifto ib-ifto-sale ib-rprice-sale-lbl-rt" readonly type="text" readonly value="">
                </div>
                <div class="ib-wrange">
                  <div class="ib-range ib-rprice-sale"></div>
                </div>
              </div>

              <div class="ib-price-range-wrap ib-price-range-wrap-rent">
                <div class="ib-wimputs">
                    <label for="ib-min-lz-rent" class="ms-hidden"><?php echo __('Enter a min price rent range', IDXBOOST_DOMAIN_THEME_LANG); ?></label>
                    <input id="ib-min-lz-rent" class="notranslate ib-iffrom ib-ffrom-rent ib-rprice-rent-lbl-lt" readonly type="text" readonly value="">
                    <span class="ib-iftxt"><?php echo __('to', IDXBOOST_DOMAIN_THEME_LANG); ?></span>
                    <label for="ib-max-lz-rent" class="ms-hidden"><?php echo __('Enter a max price rent range', IDXBOOST_DOMAIN_THEME_LANG); ?></label>
                    <input id="ib-max-lz-rent" class="notranslate ib-ifto ib-ifto-rent ib-rprice-rent-lbl-rt" readonly type="text" readonly value="">
                </div>
                <div class="ib-wrange">
                  <div class="ib-range ib-rprice-rent"></div>
                </div>
              </div>

          </div>
        </li>
        <li class="ib-fitem">
          <div class="ib-fititle"><?php echo __('Bedrooms', IDXBOOST_DOMAIN_THEME_LANG); ?></div>
          <div class="ib-ficontent">
            <div class="ib-wrange">
              <div class="ib-range ib-rbedrooms"></div>
              <ul class="ib-rmarkers">
                <li class="ib-rmitem"><span class="ib-rmtxt"><?php echo __('Studio', IDXBOOST_DOMAIN_THEME_LANG); ?></span></li>
                <li class="ib-rmitem">1</li>
                <li class="ib-rmitem">2</li>
                <li class="ib-rmitem">3</li>
                <li class="ib-rmitem">4</li>
                <li class="ib-rmitem">5</li>
                <li class="ib-rmitem">5+</li>
              </ul>
            </div>
          </div>
        </li>
        <li class="ib-fitem">
          <div class="ib-fititle"><?php echo __('Bathrooms', IDXBOOST_DOMAIN_THEME_LANG); ?></div>
          <div class="ib-ficontent">
            <div class="ib-wrange">
              <div class="ib-range ib-rbathrooms"></div>
              <ul class="ib-rmarkers">
                <li class="ib-rmitem">0</li>
                <li class="ib-rmitem">1</li>
                <li class="ib-rmitem">2</li>
                <li class="ib-rmitem">3</li>
                <li class="ib-rmitem">4</li>
                <li class="ib-rmitem">5</li>
                <li class="ib-rmitem">5+</li>
              </ul>
            </div>
          </div>
        </li>
        <li class="ib-fitem">
          <div class="ib-fititle"><?php echo __('Type', IDXBOOST_DOMAIN_THEME_LANG); ?></div>
          <div class="ib-ficontent">
            <ul class="ib-wchecks ib-types-options" data-type="mobile"></ul>
          </div>
        </li>
        <li class="ib-fitem">
          <div class="ib-fititle"><?php echo __('Living Size', IDXBOOST_DOMAIN_THEME_LANG); ?></div>
          <div class="ib-ficontent">
            <div class="ib-wimputs">
              <label for="ib-min-lz-label" class="ms-hidden"><?php echo __('Enter a min living size', IDXBOOST_DOMAIN_THEME_LANG); ?></label>
              <input id="ib-min-lz-label" class="notranslate ib-iffrom ib-rliving-lbl-lt" type="text" readonly value="">
              <span class="ib-iftxt"><?php echo __('to', IDXBOOST_DOMAIN_THEME_LANG); ?></span>
              <label for="ib-max-lz-label" class="ms-hidden"><?php echo __('Enter a max living size', IDXBOOST_DOMAIN_THEME_LANG); ?></label>
              <input class="notranslate ib-ifto ib-rliving-lbl-rt" type="text" readonly value="">
            </div>
            <div class="ib-wrange">
              <div class="ib-range ib-rliving"></div>
            </div>
          </div>
        </li>
        <li class="ib-fitem">
          <div class="ib-fititle"><?php echo __('Year Built', IDXBOOST_DOMAIN_THEME_LANG); ?></div>
          <div class="ib-ficontent">
            <div class="ib-wimputs">
              <label for="ib-min-yb-label" class="ms-hidden"><?php echo __('Enter a min year built', IDXBOOST_DOMAIN_THEME_LANG); ?></label>
              <input id="ib-min-yb-label" class="notranslate ib-iffrom ib-ryear-lbl-lt" readonly type="text" value="">
              <span class="ib-iftxt"><?php echo __('to', IDXBOOST_DOMAIN_THEME_LANG); ?></span>
              <label for="ib-max-yb-label" class="ms-hidden"><?php echo __('Enter a max year built', IDXBOOST_DOMAIN_THEME_LANG); ?></label>
              <input id="ib-max-yb-label" class="notranslate ib-ifto ib-ryear-lbl-rt" readonly type="text" value="">
            </div>
            <div class="ib-wrange">
              <div class="ib-range ib-ryear"></div>
            </div>
          </div>
        </li>
        <li class="ib-fitem">
          <div class="ib-fititle"><?php echo $label_waterfront_description; ?></div>
          <div class="ib-ficontent">
            <div class="ib-wselect ib-icon-darrow">
              <label for="ib-waterfront-label" class="ms-hidden"><?php echo $label_waterfront_description; ?></label>
              <select class="ib-fselect ib-waterfront-options" id="ib-waterfront-label">
                <option value="--">Any</option>
              </select>
            </div>
          </div>
        </li>
        <li class="ib-fitem">
          <div class="ib-fititle"><?php echo __('Parking Spaces', IDXBOOST_DOMAIN_THEME_LANG); ?></div>
          <div class="ib-ficontent">
            <div class="ib-wselect ib-icon-darrow">
              <label for="ib-ps-label" class="ms-hidden"><?php echo __('Parking Spaces', IDXBOOST_DOMAIN_THEME_LANG); ?></label>
              <select class="ib-fselect ib-parking-option" id="ib-ps-label">
                <option value="--">Any</option>
              </select>
            </div>
          </div>
        </li>
        <li class="ib-fitem">
          <div class="ib-fititle"><?php echo __('Land Size', IDXBOOST_DOMAIN_THEME_LANG); ?></div>
          <div class="ib-ficontent">
            <div class="ib-wimputs">
              <label for="ib-ps-mc-ls" class="ms-hidden"><?php echo __('Enter a min Land Size', IDXBOOST_DOMAIN_THEME_LANG); ?></label>
              <input id="ib-ps-mc-ls" class="notranslate ib-iffrom ib-rland-lbl-lt" type="text" readonly value="">
              <span class="ib-iftxt"><?php echo __('to', IDXBOOST_DOMAIN_THEME_LANG); ?></span>
              <label for="ib-ps-mx-ls" class="ms-hidden"><?php echo __('Enter a max Land Size', IDXBOOST_DOMAIN_THEME_LANG); ?></label>
              <input id="ib-ps-mx-ls" class="notranslate ib-ifto ib-rland-lbl-rt" type="text" readonly value="">
            </div>
            <div class="ib-wrange">
              <div class="ib-range ib-rland"></div>
            </div>
          </div>
        </li>
        <li class="ib-fitem">
          <div class="ib-fititle"><?php echo __('Features', IDXBOOST_DOMAIN_THEME_LANG); ?></div>
          <div class="ib-ficontent">
            <ul class="ib-wchecks ib-wchecks-col2 ib-amenities-options" data-type="outer-amt"></ul>
          </div>
        </li>
      </ul>
      <div class="ib-fmapply"><?php echo __('Apply Filters', IDXBOOST_DOMAIN_THEME_LANG); ?></div>
    </div>
  </div>
</div>
