<style>
.ib-price-range-wrap { display: none; }
#ui-id-1 {max-width:500px !important;}
</style>
<h1 class="ms-hidden"><?php echo __(the_title(), IDXBOOST_DOMAIN_THEME_LANG); ?></h1>
<div class="ib-filter-container fixed-box">
  <div class="ib-fheader">
    <div class="ib-fhpa">
      <div class="ib-fhpa-minisearch">
        <label for="ib-fmsearch-a" class="ms-hidden"><?php echo __('Enter Address, City, Zip Code, Subdivision', IDXBOOST_DOMAIN_THEME_LANG); ?></label>
        <input id="ib-fmsearch-a" class="ib-fmsearch ib-fmsearchsuggestions ib-fcitiesnon-hide" autocorrect="off" autocapitalize="off" spellcheck="false" autocomplete="disabled" type="search" data-type="outer-ac" placeholder="<?php echo __('Enter Address, City, Zip Code, Subdivision', IDXBOOST_DOMAIN_THEME_LANG); ?>">
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
		  <label for="ms-price-a" class="ms-hidden"><?php echo __('Price Range', IDXBOOST_DOMAIN_THEME_LANG); ?></label>
                  <input class="notranslate ib-iffrom ib-ffrom-sale ib-rprice-sale-lbl-lt ib-comm-price-sale-outer-min" placeholder="Min"  type="text" value="" id="ms-price-a">
                  <span class="ib-iftxt"><?php echo __('to', IDXBOOST_DOMAIN_THEME_LANG); ?></span>
                  <label for="ms-price-b" class="ms-hidden"><?php echo __('Price Range', IDXBOOST_DOMAIN_THEME_LANG); ?></label>
		  <input class="notranslate ib-ifto ib-ifto-sale ib-rprice-sale-lbl-rt ib-comm-price-sale-outer-max"  placeholder="Max"  type="text" value="" id="ms-price-b">
                </div>
                <?php /*
                <div class="ib-wrange">
                  <div class="ib-range ib-rprice-sale"></div>
                </div> */ ?>
              </div>

              <div class="ib-price-range-wrap ib-price-range-wrap-rent">
                <div class="ib-wimputs">
		    <label for="ms-price-c" class="ms-hidden"><?php echo __('Price Range', IDXBOOST_DOMAIN_THEME_LANG); ?></label>
                    <input class="notranslate ib-iffrom ib-ffrom-rent ib-rprice-rent-lbl-lt ib-comm-price-rent-outer-min" placeholder="Min"  type="text"   value="" id="ms-price-c">
                    <span class="ib-iftxt"><?php echo __('to', IDXBOOST_DOMAIN_THEME_LANG); ?></span>
		    <label for="ms-price-d" class="ms-hidden"><?php echo __('Price Range', IDXBOOST_DOMAIN_THEME_LANG); ?></label>
                    <input class="notranslate ib-ifto ib-ifto-rent ib-rprice-rent-lbl-rt ib-comm-price-rent-outer-max"  placeholder="Max"  type="text"   value="" id="ms-price-d">
                </div>
                <?php /*
                <div class="ib-wrange">
                  <div class="ib-range ib-rprice-rent"></div>
                </div> */ ?>
              </div>

            </div>
          </div>
        </li>
        <?php /*
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
        </li> */ ?>
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
          <div class="ib-fdesktop ib-hack-all-filters ib-comercial-search">
            <div class="ib-fdcwrapper">
              <div class="ib-fdcol">
                <div class="ib-fitem">
                  <div class="ib-fititle"><?php echo __('Property Search', IDXBOOST_DOMAIN_THEME_LANG); ?></div>
                  <div class="ib-ficontent ib-ficontent-mod1">
                    <div class="ib-fforsr">
                      <div class="ib-ffsale ib-fifor" data-type="sale"><?php echo __('For Sale', IDXBOOST_DOMAIN_THEME_LANG); ?></div>
                      <div class="ib-ffrent ib-fifor" data-type="rent"><?php echo __('For Lease ', IDXBOOST_DOMAIN_THEME_LANG); ?></div>
                    </div>
                  </div>
                </div>

                <div class="ib-fitem">
                  <div class="ib-fititle"><?php echo __('Type', IDXBOOST_DOMAIN_THEME_LANG); ?></div>
                  <div class="ib-ficontent">
                    <ul class="ib-list-wchecks ib-types-options" data-type="inner"></ul>
                  </div>
                </div>

<?php /* <div class="ib-fitem">
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
                </div> */ ?>

              </div>
              <div class="ib-fdcol">
                <div class="ib-fitem">
                  <div class="ib-fititle"><?php echo __('Price Range', IDXBOOST_DOMAIN_THEME_LANG); ?></div>
                  <div class="ib-ficontent ib-price-range-inner" style="padding-bottom:2px;">
                    <div class="ib-price-range-wrap ib-price-range-wrap-sale">
                    <div class="ib-wimputs">
			<label for="ms-price-e" class="ms-hidden"><?php echo __('Minimum', IDXBOOST_DOMAIN_THEME_LANG); ?></label>
                      <input class="notranslate ib-iffrom ib-ffrom-sale ib-rprice-sale-lbl-lt ib-comm-price-sale-inner-min" placeholder="Min"  type="text"   value="" id="ms-price-e">
                      <span class="ib-iftxt"><?php echo __('to', IDXBOOST_DOMAIN_THEME_LANG); ?></span>
			<label for="ms-price-f" class="ms-hidden"><?php echo __('Maximum', IDXBOOST_DOMAIN_THEME_LANG); ?></label>
                      <input class="notranslate ib-ifto ib-ifto-sale ib-rprice-sale-lbl-rt ib-comm-price-sale-inner-max"  placeholder="Max"  type="text"   value="" id="ms-price-f">
                    </div>
                    <?php /*
                    <div class="ib-wrange">
                      <div class="ib-range ib-rprice-sale"></div>
                    </div> */ ?>
                  </div>

                  <div class="ib-price-range-wrap ib-price-range-wrap-rent">
                    <div class="ib-wimputs">
			<label for="ms-price-g" class="ms-hidden"><?php echo __('Minimum', IDXBOOST_DOMAIN_THEME_LANG); ?></label>
                        <input id="ms-price-g" class="notranslate ib-iffrom ib-ffrom-rent ib-rprice-rent-lbl-lt ib-comm-price-rent-inner-min" placeholder="Min"  type="text"   value="">
                        <span class="ib-iftxt"><?php echo __('to', IDXBOOST_DOMAIN_THEME_LANG); ?></span>
			<label for="ms-price-h" class="ms-hidden"><?php echo __('Maximum', IDXBOOST_DOMAIN_THEME_LANG); ?></label>
                        <input id="ms-price-h" class="notranslate ib-ifto ib-ifto-rent ib-rprice-rent-lbl-rt ib-comm-price-rent-inner-max" placeholder="Max"  type="text"   value="">
                    </div>
                    <?php /*
                    <div class="ib-wrange">
                      <div class="ib-range ib-rprice-rent"></div>
                    </div>
                    */ ?>
                  </div>
                  </div>
                </div>

                <div class="ib-fitem">
                  <div class="ib-fititle"><?php echo __('Space Size (SF)', IDXBOOST_DOMAIN_THEME_LANG); ?></div>
                  <div class="ib-ficontent">
                    <div class="ib-wimputs">
			<label for="ms-size-a" class="ms-hidden"><?php echo __('Minimum', IDXBOOST_DOMAIN_THEME_LANG); ?></label>

                      <input id="ms-size-a" class="notranslate ib-iffrom ib-rliving-lbl-lt ib-comm-sqft-inner-min" type="text" placeholder="Min"  value="">
                      <span class="ib-iftxt"><?php echo __('to', IDXBOOST_DOMAIN_THEME_LANG); ?></span>
<label for="ms-size-b" class="ms-hidden"><?php echo __('Maximum', IDXBOOST_DOMAIN_THEME_LANG); ?></label>
                      <input class="notranslate ib-ifto ib-rliving-lbl-rt ib-comm-sqft-inner-max" type="text"  placeholder="Max"  value="" id="ms-size-b">
                    </div>
                    <?php /*
                    <div class="ib-wrange">
                      <div class="ib-range ib-rliving"></div>
                    </div> */ ?>
                  </div>
                </div>

                <div class="ib-fitem">
                  <div class="ib-fititle"><?php echo __('Total Building Size (SF)', IDXBOOST_DOMAIN_THEME_LANG); ?></div>
                  <div class="ib-ficontent">
                    <div class="ib-wimputs">
<label for="ms-building-size-a" class="ms-hidden"><?php echo __('Minimum', IDXBOOST_DOMAIN_THEME_LANG); ?></label>
                        <input class="notranslate ib-iffrom ib-bsize-lbl-lt ib-comm-bsize-inner-min" type="text" placeholder="Min"  value="" id="ms-building-size-a">
                        <span class="ib-iftxt"><?php echo __('to', IDXBOOST_DOMAIN_THEME_LANG); ?></span>
<label for="ms-building-size-b" class="ms-hidden"><?php echo __('Maximum', IDXBOOST_DOMAIN_THEME_LANG); ?></label>
                        <input class="notranslate ib-ifto ib-bsize-lbl-rt ib-comm-bsize-inner-max" type="text" placeholder="Max"  value="" id="ms-building-size-b">
                    </div>

                    <?php /*
                    <div class="ib-wselect ib-icon-darrow">
                      <select class="ib-fselect ib-parking-options">
                        <option value="--"><?php echo __('Any', IDXBOOST_DOMAIN_THEME_LANG); ?></option>
                      </select>
                    </div> */ ?>
                  </div>
                </div>

                <div class="ib-fitem">
                  <div class="ib-fititle"><?php echo __('Total Lot Size Range', IDXBOOST_DOMAIN_THEME_LANG); ?></div>
                  <div class="ib-ficontent">
                    <div class="ib-wimputs">
<label for="ms-beds-range-a" class="ms-hidden"><?php echo __('Minimum', IDXBOOST_DOMAIN_THEME_LANG); ?></label>
                      <input class="notranslate ib-iffrom ib-rland-lbl-lt ib-comm-lotsize-inner-min" type="text" placeholder="Min"  value="" id="ms-beds-range-a">
                      <span class="ib-iftxt"><?php echo __('to', IDXBOOST_DOMAIN_THEME_LANG); ?></span>
<label for="ms-beds-range-b" class="ms-hidden"><?php echo __('Maximum', IDXBOOST_DOMAIN_THEME_LANG); ?></label>
                      <input class="notranslate ib-ifto ib-rland-lbl-rt ib-comm-lotsize-inner-max" type="text" placeholder="Max"  value="" id="ms-beds-range-b">
                    </div>

                      <div class="lotsize-measure-options" style="display:none !important;">
                          <div class="ib-item-lb">
                            <input type="radio" name="lotsize-measure-type" id="lotsize-measure-type-acres" value="acres" class="ib-icheck lotsize-measure-type">
                            <label for="lotsize-measure-type-acres" class="ib-clabel">ACRES</label>
                          </div>
                          
                          <div class="ib-item-lb"> 
                            <input type="radio" name="lotsize-measure-type" id="lotsize-measure-type-sf" value="sf" class="ib-icheck lotsize-measure-type">
                            <label for="lotsize-measure-type-sf" class="ib-clabel">SF</label>
                          </div>
                      </div>
                    <?php /*
                    <div class="ib-wrange">
                      <div class="ib-range ib-rland"></div>
                    </div> */ ?>
                  </div>
                </div>

                <?php /* <div class="ib-fitem">
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
                </div> */ ?>
              </div>
              <div class="ib-fdcol">
                <div class="ib-fitem">
                  <div class="ib-fititle"><?php echo __('Units / Beds Range', IDXBOOST_DOMAIN_THEME_LANG); ?></div>
                  <div class="ib-ficontent" style="padding-bottom:2px;">

                  <div class="ib-wimputs">
<label for="ms-range-ib-comm-beds-inner-min" class="ms-hidden"><?php echo __('Minimum', IDXBOOST_DOMAIN_THEME_LANG); ?></label>
                    <input class="notranslate ib-iffrom ib-ubrange-lbl-lt ib-comm-beds-inner-min" type="text" value="" placeholder="Min" id="ms-range-ib-comm-beds-inner-min">
                    <span class="ib-iftxt"><?php echo __('to', IDXBOOST_DOMAIN_THEME_LANG); ?></span>
<label for="ms-range-ib-comm-beds-inner-max" class="ms-hidden"><?php echo __('Maximum', IDXBOOST_DOMAIN_THEME_LANG); ?></label>
                    <input class="notranslate ib-ifto ib-ubrange-lbl-rt ib-comm-beds-inner-max" type="text"   value="" placeholder="Max" id="ms-range-ib-comm-beds-inner-max">
                  </div>

                  <?php /*
                  <div class="unit-beds-range-desc">
                    <p>Multifamily, Residential Income, etc.</p>
                  </div>
                  */ ?>

                  <?php /*
                    <div class="ib-wselect ib-icon-darrow">
                      <select class="ib-fselect ib-waterfront-options">
                        <option value="--"><?php echo __('Any', IDXBOOST_DOMAIN_THEME_LANG); ?></option>
                      </select>
                    </div>
                    */ ?>
                  </div>
                </div>

                <div class="ib-fitem">
                  <div class="ib-fititle"><?php echo __('Year Built', IDXBOOST_DOMAIN_THEME_LANG); ?></div>
                  <div class="ib-ficontent">
                    <div class="ib-wimputs">
                    <div class="ib-item-wrap-fm ib-wrap-content-select">
                        <label for="year-inner-min" class="ms-hidden"><?php echo __('Year Built', IDXBOOST_DOMAIN_THEME_LANG); ?></label>
                        <select class="ib-comm-year-inner-min ib-ryear-lbl-lt" id="year-inner-min">
                        <?php for($min_year = 1900; $min_year <= 2020; $min_year++): ?>
                        <option value="<?php echo $min_year; ?>"><?php echo $min_year; ?></option>
                        <?php endfor; ?>
                      </select>
                    </div>
                      <span class="ib-iftxt"><?php echo __('to', IDXBOOST_DOMAIN_THEME_LANG); ?></span>
                      <div class="ib-item-wrap-fm ib-wrap-content-select">
                          <label for="year-inner-max" class="ms-hidden"><?php echo __('Year Built', IDXBOOST_DOMAIN_THEME_LANG); ?></label>
                          <select class="ib-comm-year-inner-max ib-ryear-lbl-rt" id="year-inner-max">
                        <?php for($max_year = 2020; $max_year >= 1900; $max_year--): ?>
                        <option value="<?php echo $max_year; ?>"><?php echo $max_year; ?></option>
                        <?php endfor; ?>
                        </select>
                      </div>
                    </div>
                  </div>
                </div>

                <div class="ib-fitem">
                  <div class="ib-fititle"><?php echo __('Property Status', IDXBOOST_DOMAIN_THEME_LANG); ?></div>
                  <div class="ib-ficontent" style="padding:13px;">
                    <ul class="ib-wchecks ib-wchecks-col2 ib-status-types">
                          <li class="ib-citem">
                          <input type="checkbox" id="ib-amt-inner-amt_0" value="is_vacant" class="ib-icheck">
                          <label class="ib-clabel" for="ib-amt-inner-amt_0">Vacant</label>
                          </li>
                          <li class="ib-citem">
                          <input type="checkbox" id="ib-amt-inner-amt_1" value="foreclosure" class="ib-icheck">
                          <label class="ib-clabel" for="ib-amt-inner-amt_1">Foreclosure</label>
                          </li>
                          <li class="ib-citem">
                          <input type="checkbox" id="ib-amt-inner-amt_2" value="is_occupied" class="ib-icheck">
                          <label class="ib-clabel" for="ib-amt-inner-amt_2">Occupied</label>
                          </li>
                          <li class="ib-citem">
                          <input type="checkbox" id="ib-amt-inner-amt_3" value="short_sale" class="ib-icheck">
                          <label class="ib-clabel" for="ib-amt-inner-amt_3">Short Sale</label>
                          </li>
                    </ul>
                    <!-- <ul class="ib-wchecks ib-wchecks-col2 ib-amenities-options" data-type="inner-amt"></ul> -->
                  </div>
                  <div class="ib-fdmatching"><?php echo __('Searching...', IDXBOOST_DOMAIN_THEME_LANG); ?></div>
                </div>

                <div class="ib-fitem">
                  <div class="ib-fititle"><?php echo __('Cap Rate Range (%). ?', IDXBOOST_DOMAIN_THEME_LANG); ?></div>
                  <div class="ib-ficontent">
                    <div class="ib-wimputs">
                      <label for="rate-inner-min" class="ms-hidden"><?php echo __('Minimum', IDXBOOST_DOMAIN_THEME_LANG); ?></label>
                      <input class="notranslate ib-iffrom ib-raterange-lbl-lt ib-comm-rate-inner-min" type="text" value="" placeholder="Min" id="rate-inner-min">
                      <span class="ib-iftxt"><?php echo __('to', IDXBOOST_DOMAIN_THEME_LANG); ?></span>
                      <label for="rate-inner-max" class="ms-hidden"><?php echo __('Maximum', IDXBOOST_DOMAIN_THEME_LANG); ?></label>
                      <input class="notranslate ib-ifto ib-raterange-lbl-rt ib-comm-rate-inner-max" type="text" value="" placeholder="Max" id="rate-inner-max">
                    </div>

                    <div class="cap-rate-range-desc">
                      <h5><?php echo __('May buy:', IDXBOOST_DOMAIN_THEME_LANG); ?></h5>
                      <p><?php echo __('4% in high demand areas', IDXBOOST_DOMAIN_THEME_LANG); ?></p>
                      <p><?php echo __('10% (or even higher) in low-demand areas', IDXBOOST_DOMAIN_THEME_LANG); ?></p>
                    </div>

                    <?php /*
                    <div class="ib-wselect ib-icon-darrow">
                      <select class="ib-fselect ib-waterfront-options">
                        <option value="--"><?php echo __('Any', IDXBOOST_DOMAIN_THEME_LANG); ?></option>
                      </select>
                    </div> */ ?>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </li>
      </ul>
      <div class="ib-fhpa-directbtns">
        <button class="ib-dbitem ib-dbclear ib-icon-carrow" aria-label="<?php echo __('Clear', IDXBOOST_DOMAIN_THEME_LANG); ?>"><span class="ib-btext"><?php echo __('Clear', IDXBOOST_DOMAIN_THEME_LANG); ?></span></button>
        <button class="ib-dbitem ib-dbsave ib-icon-save" aria-label="<?php echo __('Save', IDXBOOST_DOMAIN_THEME_LANG); ?>"><span class="ib-btext"><?php echo __('Save', IDXBOOST_DOMAIN_THEME_LANG); ?></span></button>
      </div>
    </div>
    <div class="ib-fmobile">
      <ul class="ib-flist">
        <li class="ib-fitem ib-fitem-active">
          <div class="ib-fititle"><?php echo __('Price Range', IDXBOOST_DOMAIN_THEME_LANG); ?></div>
          <div class="ib-ficontent ib-price-range-mobile">

              <div class="ib-price-range-wrap ib-price-range-wrap-sale">
                <div class="ib-wimputs">
<label for="ms-price-i" class="ms-hidden"><?php echo __('Minimum', IDXBOOST_DOMAIN_THEME_LANG); ?></label>
                  <input id="ms-price-i" class="notranslate ib-iffrom ib-ffrom-sale ib-rprice-sale-lbl-lt"   type="text" placeholder="Min"  value="">
                  <span class="ib-iftxt"><?php echo __('to', IDXBOOST_DOMAIN_THEME_LANG); ?></span>
<label for="ms-price-j" class="ms-hidden"><?php echo __('Maximum', IDXBOOST_DOMAIN_THEME_LANG); ?></label>
                  <input id="ms-price-j" class="notranslate ib-ifto ib-ifto-sale ib-rprice-sale-lbl-rt"   type="text" placeholder="Max"   value="">
                </div>
                <div class="ib-wrange">
                  <div class="ib-range ib-rprice-sale"></div>
                </div>
              </div>

              <div class="ib-price-range-wrap ib-price-range-wrap-rent">
                <div class="ib-wimputs">
<label for="ms-price-k" class="ms-hidden"><?php echo __('Minimum', IDXBOOST_DOMAIN_THEME_LANG); ?></label>
                    <input id="ms-price-k" class="notranslate ib-iffrom ib-ffrom-rent ib-rprice-rent-lbl-lt"   type="text" placeholder="Min"  value="">
                    <span class="ib-iftxt"><?php echo __('to', IDXBOOST_DOMAIN_THEME_LANG); ?></span>
<label for="ms-price-l" class="ms-hidden"><?php echo __('Maximum', IDXBOOST_DOMAIN_THEME_LANG); ?></label>
                    <input id="ms-price-l" class="notranslate ib-ifto ib-ifto-rent ib-rprice-rent-lbl-rt"   type="text"  placeholder="Max"  value="">
                </div>
                <div class="ib-wrange">
                  <div class="ib-range ib-rprice-rent"></div>
                </div>
              </div>

          </div>
        </li>
        <?php /*
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
        */ ?>
        <li class="ib-fitem">
          <div class="ib-fititle"><?php echo __('Type', IDXBOOST_DOMAIN_THEME_LANG); ?></div>
          <div class="ib-ficontent">
            <ul class="ib-wchecks ib-types-options" data-type="mobile"></ul>
          </div>
        </li>
        <li class="ib-fitem">
          <div class="ib-fititle"><?php echo __('Space Size (SF)', IDXBOOST_DOMAIN_THEME_LANG); ?></div>
          <div class="ib-ficontent">
            <div class="ib-wimputs">
<label for="ms-price-o" class="ms-hidden"><?php echo __('Minimum', IDXBOOST_DOMAIN_THEME_LANG); ?></label>
              <input id="ms-price-o" class="notranslate ib-iffrom ib-rliving-lbl-lt" type="text"   value=""><span class="ib-iftxt"><?php echo __('to', IDXBOOST_DOMAIN_THEME_LANG); ?></span>
<label for="ms-price-p" class="ms-hidden"><?php echo __('Maximum', IDXBOOST_DOMAIN_THEME_LANG); ?></label>              
<input id="ms-price-p" class="notranslate ib-ifto ib-rliving-lbl-rt" type="text"   value="">
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
<label for="ms-price-q" class="ms-hidden"><?php echo __('Minimum', IDXBOOST_DOMAIN_THEME_LANG); ?></label>
              <input id="ms-price-q" class="notranslate ib-iffrom ib-ryear-lbl-lt"   type="text" value=""><span class="ib-iftxt"><?php echo __('to', IDXBOOST_DOMAIN_THEME_LANG); ?></span>
<label for="ms-price-r" class="ms-hidden"><?php echo __('Maximum', IDXBOOST_DOMAIN_THEME_LANG); ?></label>              
<input id="ms-price-r" class="notranslate ib-ifto ib-ryear-lbl-rt"   type="text" value="">
            </div>
            <div class="ib-wrange">
              <div class="ib-range ib-ryear"></div>
            </div>
          </div>
        </li>
        <li class="ib-fitem">
          <div class="ib-fititle"><?php echo __('Waterfront Description', IDXBOOST_DOMAIN_THEME_LANG); ?></div>
          <div class="ib-ficontent">
            <div class="ib-wselect ib-icon-darrow">
            <label class="ms-hidden" for="ib-waterfront-options-b"><?php echo __('Waterfront Description', IDXBOOST_DOMAIN_THEME_LANG); ?></label>
            <select class="ib-fselect ib-waterfront-options" id="ib-waterfront-options-b">
		<option value="--">Any</option>
              </select>
            </div>
          </div>
        </li>
        <?php /*
        <li class="ib-fitem">
          <div class="ib-fititle"><?php echo __('Parking Spaces', IDXBOOST_DOMAIN_THEME_LANG); ?></div>
          <div class="ib-ficontent">
            <div class="ib-wselect ib-icon-darrow">
              <select class="ib-fselect ib-parking-option">
                <option value="--">Any</option>
              </select>
            </div>
          </div>
        </li>
        */ ?>
        <li class="ib-fitem">
          <div class="ib-fititle"><?php echo __('Total Lot Size Range', IDXBOOST_DOMAIN_THEME_LANG); ?></div>
          <div class="ib-ficontent">
            <div class="ib-wimputs">
            <label for="ms-price-y" class="ms-hidden"><?php echo __('Minimum', IDXBOOST_DOMAIN_THEME_LANG); ?></label>
            <input class="notranslate ib-iffrom ib-rland-lbl-lt" type="text" value="" id="ms-price-y" readonly>
            <span class="ib-iftxt"><?php echo __('to', IDXBOOST_DOMAIN_THEME_LANG); ?></span>
            <label for="ms-price-w" class="ms-hidden"><?php echo __('Maximum', IDXBOOST_DOMAIN_THEME_LANG); ?></label>
            <input class="notranslate ib-ifto ib-rland-lbl-rt" type="text" value="" id="ms-price-w" readonly>
            </div>
            <div class="ib-wrange">
              <div class="ib-range ib-rland"></div>
            </div>
          </div>
        </li>
        <li class="ib-fitem">
          <div class="ib-fititle"><?php echo __('Property Status', IDXBOOST_DOMAIN_THEME_LANG); ?></div>
          <div class="ib-ficontent">
            <ul class="ib-wchecks ib-wchecks-col2 ib-amenities-options" data-type="outer-amt"></ul>
          </div>
        </li>
      </ul>
      <div class="ib-fmapply"><?php echo __('Apply Filters', IDXBOOST_DOMAIN_THEME_LANG); ?></div>
    </div>
  </div>
</div>
