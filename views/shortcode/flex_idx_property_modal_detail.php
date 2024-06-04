<?php if (empty($property)): ?>
<style>
  /*.flex-property-not-available { max-width: 1200px; margin-left: auto; margin-right: auto; }
  .flex-property-not-available h2 { font-size: 40px; text-align: center; margin: 40px auto; }*/
</style>
<div class="gwr idx-mmg">
  <div class="message-alert idx_color_primary flex-property-not-available">
    <p>The property you requested is not available.</p>
  </div>
</div>
<?php else: ?>
<?php if ((!empty($flex_idx_info["agent"]["google_analytics"])) && (!empty($flex_idx_info["agent"]["google_adwords"]))): ?>
<script>
  gtag('event', 'Listing_view', {
      'send_to': '<?php echo $flex_idx_info["agent"]["google_adwords"]; ?>',
      'listing_id': '<?php echo $property['mls_num']; ?>',
      'listing_pagetype': 'pagedetail',
      'listing_totalvalue': '<?php echo isset($property['is_sold']) ? $property['price_sold'] : $property['price']; ?>'
  });
  //google tag view content
  gtag('event', 'Listing Viewers', {
      'send_to': '<?php echo $flex_idx_info["agent"]["google_adwords"]; ?>',
      'listing_id': '<?php echo $property['mls_num']; ?>',
      'listing_pagetype': 'offerdetail',
      'listing_totalvalue': '<?php echo isset($property['is_sold']) ? $property['price_sold'] : $property['price']; ?>'
  });
</script>
<?php endif; ?>
<?php if (true === $registration_is_forced): ?>
<script type="text/javascript">
  (function ($) {
    $(function () {
      if ("yes" === __flex_g_settings.anonymous) {
        $("#modal_login").find(".close").css("visibility", "hidden");
        $("#modal_login").addClass("active_modal registration_forced");
        jQuery(".active_modal .header-tab li .active").click();
        jQuery("#modal_login #msRst").empty().html(jQuery("#mstextRst").html());
      }
    });
  })(jQuery);
  
  <?php if($property['img_cnt'] <= 0 ){ ?>
    jQuery('#show-map').click();
  <?php } ?>
  
</script>
<?php endif; ?>
<script>
  var IDX_BOOST_PROPERTY_TITLE = "<?php echo str_replace('# ', '#', $property['address_short']); ?> <?php echo str_replace(' ,', ',', $property['address_large']); ?>";
  document.title = IDX_BOOST_PROPERTY_TITLE;
</script>
<?php

  $idxboost_term_condition = get_option('idxboost_term_condition');
  $idxboost_agent_info = get_option('idxboost_agent_info');

  $disclaimer_checked = $flex_idx_info['agent']['disclaimer_checked'];
  if($disclaimer_checked == "1"){
    $checked = "checked"; 
  }else{
    $checked = ""; 
  }

  $logo_broker='';
  $schoolRatio='25';
  $CollapsedPreference='';
  $CollapsedPreferenceDetailt=[];
  $descriptionEspe='';
  $agent_contact_email_address = $flex_idx_info['agent']['agent_contact_email_address'];
  
  if (array_key_exists('logo_broker', $response))  $logo_broker=$response['logo_broker'];
  if (array_key_exists('descriptionEspe', $response))  $descriptionEspe=$response['descriptionEspe'];
  if (array_key_exists('schoolRatio', $response))  $schoolRatio=$response['schoolRatio'];
  if (array_key_exists('CollapsedPreference', $response))  $CollapsedPreference=$response['CollapsedPreference'];
  if (array_key_exists('CollapsedPreferenceDetailt', $response))  $CollapsedPreferenceDetailt=$response['CollapsedPreferenceDetailt'];
  
  ?>
<?php
  $arraydata=[];
  
  $arraydata['range_la_lo']= array(
    'lat' => $property['lat'] ,
    'long' => $property['lng'],
    'distance' => $schoolRatio
  );
  $sendParams = array('parameter'     => $arraydata);
  $chlatlong = curl_init();
  
  curl_setopt($chlatlong, CURLOPT_URL, IDX_BOOTS_NICHE);
  curl_setopt($chlatlong, CURLOPT_POST, 1);
  curl_setopt($chlatlong, CURLOPT_POSTFIELDS, http_build_query($sendParams));
  curl_setopt($chlatlong, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($chlatlong, CURLOPT_REFERER, ib_get_http_referer());
  
  $outputlatlong = curl_exec($chlatlong);
  curl_close($chlatlong);
  $outtemporali=json_decode($outputlatlong,true);

  echo '<!-- ';
  print_r($outtemporali);
  echo '-->';
  ?>
<div id="full-main">
  <section id="md-title">
    <div class="content-fixed-title">
      <h2 class="title-page" id="ib_main-heading"><?php echo $property['address_short']; ?><span><?php echo $property['address_large']; ?></span></h2>
    </div>
    <ul class="options-modal">
      <li>
        <a href="<?php echo $property_permalink; ?>" id="ib_main-link" target="_blank" title="View all detail" class="expand-btn"><span>Open</span></a>
      </li>
      <li>
        <button data-id="modal_property_detail" class="close-modal-pt">
          <span>Close</span>
        </button>
      </li>
    </ul>
  </section>

  <div class="header-print">
    <img src="<?php echo $logo_broker; ?>" title="FlexIdx">
    <ul>
      <li><?php echo __("Call me", IDXBOOST_DOMAIN_THEME_LANG); ?>: <?php echo flex_agent_format_phone_number($agent_info_phone); ?></li>
      <li><?php echo $agent_contact_email_address; ?></li>
    </ul>
  </div>
  <div id="imagen-print"></div>
  <div id="full-slider">
    <div class="gs-container-slider clidxboost-full-slider">
      <?php if($property['img_cnt'] > 0 ): ?>
      <?php foreach ($property['gallery'] as $thumbnail): ?>
      <img data-lazy="<?php echo $thumbnail; ?>" class="img-slider gs-lazy">
      <?php endforeach;?>
      <?php endif;?>
    </div>
    <div class="moptions">
      <ul class="slider-option">
        <li>
          <button class="option-switch active" id="show-gallery" data-view="gallery"><?php echo __("photos", IDXBOOST_DOMAIN_THEME_LANG); ?></button>
        </li>
        <li>
          <button class="option-switch" id="show-map" data-view="map"><?php echo __("map view", IDXBOOST_DOMAIN_THEME_LANG); ?></button>
        </li>
        <?php if (!empty($property["virtual_tour"])): ?>
        <li>
          <button class="option-switch" onclick="javascript:window.open('<?php echo strip_tags($property["virtual_tour"]); ?>');"><?php echo __("video", IDXBOOST_DOMAIN_THEME_LANG); ?></button>
        </li>
        <?php endif; ?>
      </ul>
      <button class="full-screen" id="clidxboost-btn-flight"><?php echo __("Full screen", IDXBOOST_DOMAIN_THEME_LANG); ?></button>
    </div>
    <div id="map-view">
      <div id="map-result" data-lat="<?php echo $property['lat']; ?>" data-lng="<?php echo $property['lng']; ?>"></div>
    </div>
  </div>
<section class="main">
  <h2 class="title-temp"><?php echo __("Property details information", IDXBOOST_DOMAIN_THEME_LANG); ?></h2>
  <div class="temporal-content"></div>
  <div class="gwr">
    <div class="container">
      <ul class="property-information" data-inf="price:<?php echo isset($property['is_sold']) ? $property['price_sold'] : $property['price']; ?>|beds:<?php echo $property['bed']; ?>|baths:<?php echo $property['bath']; ?>|sqft:<?php echo $property['sqft']; ?>">
        <li class="price-property">$<?php 
        $text_to_rent='';
        if($property['is_rental'] != 0)
          $text_to_rent='/'.__("month", IDXBOOST_DOMAIN_THEME_LANG);
          echo number_format($property['price']).$text_to_rent; ?> <span>
          <?php if ($property['status'] == "5"): // rented ?>
          <?php echo __("rented price", IDXBOOST_DOMAIN_THEME_LANG); ?>
          <?php elseif($property['status'] == "2"): // sold ?>
          <?php echo __("sold price", IDXBOOST_DOMAIN_THEME_LANG); ?>
          <?php elseif($property['status'] == "6"): // pending ?>
          <?php echo __("pending price", IDXBOOST_DOMAIN_THEME_LANG); ?>
          <?php else: ?>
          <?php echo __("asking price", IDXBOOST_DOMAIN_THEME_LANG); ?>
          <?php endif; ?>
          <?php if (in_array($property['status'], array(5,2,1))): ?>
          <?php if ($property['reduced'] == ''): ?>
          <?php elseif ($property['reduced'] < 0): ?>
          <span class="down-price"><?php echo $property['reduced']; ?>%</span>
          <?php else: ?>
          <span class="up-price"><?php echo $property['reduced']; ?>%</span>
          <?php endif; ?>
          <?php endif; ?>
          </span>
        </li>
        <li><?php echo $property['bed']; ?> <span><?php if ($property['bed']>1) { echo __("Bedrooms", IDXBOOST_DOMAIN_THEME_LANG); }else{ echo __("Bedroom", IDXBOOST_DOMAIN_THEME_LANG); } ?> </span></li>
        <li><?php echo $property['bath']; ?> <span><?php if($property['bath']>1){ echo __("Bathrooms", IDXBOOST_DOMAIN_THEME_LANG); }else{ echo __("Bathroom", IDXBOOST_DOMAIN_THEME_LANG); } ?> </span></li>
        <li><?php echo $property['baths_half']; ?> <span><?php if ($property['baths_half']>1) { echo __("Half Baths", IDXBOOST_DOMAIN_THEME_LANG); }else{ echo __("Half Bath", IDXBOOST_DOMAIN_THEME_LANG); } ?></span></li>
        <li><?php echo number_format($property['sqft']); ?> <span><?php echo __("size sq.ft", IDXBOOST_DOMAIN_THEME_LANG); ?>.</span></li>
        <?php if ($property['status'] == 1): ?>
        <li class="btn-save">

          <?php if ($property['is_favorite']): ?>
          <button class="chk_save dgt-mark-favorite" data-alert-token="<?php echo $property['token_alert']; ?>" data-mls="<?php echo $property['mls_num']; ?>" data-class-id="<?php echo $property['class_id']; ?>">
          <span class="active"><?php echo __("Remove", IDXBOOST_DOMAIN_THEME_LANG); ?></span>
          </button>
          <?php else: ?>
          <button class="chk_save dgt-mark-favorite" data-mls="<?php echo $property['mls_num']; ?>" data-class-id="<?php echo $property['class_id']; ?>">
          <span><?php echo __("save favorite", IDXBOOST_DOMAIN_THEME_LANG); ?></span>
          </button>
          <?php endif;?>
        </li>
        <?php endif; ?>
      </ul>
      <div class="panel-options">
        <a style="display:none;" class="show-modal btn clidxboost-btn-blue" href="#" title="Schedule a showing now" data-modal="modal_schedule" rel="nofollow" id="schedule-now"><?php echo __("Schedule a showing now", IDXBOOST_DOMAIN_THEME_LANG); ?></a>
        <div class="options-list">
          <div class="shared-content">
            <button id="show-shared"><?php echo __("share", IDXBOOST_DOMAIN_THEME_LANG); ?></button>
            <ul class="shared-list">
              <li><a data-share-url="<?php echo $property_permalink; ?>" data-share-title="<?php echo str_replace('# ', '#', $property['address_short']);; ?> <?php echo $property['address_large']; ?>" data-share-description="<?php echo strip_tags($property['remark']); ?>" data-share-image="<?php echo $property['gallery'][0]; ?>" class="ico-facebook property-detail-share-fb" onclick="idxsharefb()" title="Facebook" rel="nofollow">Facebook</a></li>
              <li><a class="ico-twitter" href="#" onclick="window.open('<?php echo $twitter_share_url; ?>','s_tw','width=600,height=400'); return false;" title="Twitter" rel="nofollow">Twitter</a></li>
            </ul>
          </div>
          <ul class="action-list">
            <li><a data-price="$<?php echo number_format($property['price']); ?>" class="show-modal ico-calculator" href="#" title="Mortgage calculator" data-modal="modal_calculator" rel="nofollow" id="calculator-mortgage"><?php echo __("mortgage", IDXBOOST_DOMAIN_THEME_LANG); ?></a></li>
            <li><a class="show-modal ico-envelope" href="javascript:void(0)" title="Email to a firend" data-modal="modal_email_to_friend" rel="nofollow" id="email-friend"><?php echo __("email to a friend", IDXBOOST_DOMAIN_THEME_LANG); ?></a></li>
            <li><a class="ico-printer" href="javascript:void(0)" title="Print" rel="nofollow" id="print-btn"><?php echo __("print", IDXBOOST_DOMAIN_THEME_LANG); ?></a></li>
          </ul>
        </div>
      </div>
      <div class="main-content">
        <?php if($property['remark'] != ''){ ?>
        <div class="property-description" id="property-description">
          <p><?php echo $property['remark']; ?></p>
        </div>
        <?php } ?>
        <?php if(!empty($descriptionEspe)){ ?>
        <?php 
          echo $descriptionEspe;
          ?>
        <?php } ?>
        <div class="list-details clidxboost-property-container">
          <h2 class="title-details"><?php echo __("Property Details", IDXBOOST_DOMAIN_THEME_LANG); ?></h2>
          <ul class="list-detail">
            <li><span><?php echo __("MLS", IDXBOOST_DOMAIN_THEME_LANG); ?> #</span><span><?php echo $property['mls_num']; ?></span></li>
            <li> <span><?php echo __("Type", IDXBOOST_DOMAIN_THEME_LANG); ?></span><span><?php echo (1 == $property['class_id']) ? 'Condominiums' : 'Single Family Homes'; ?></span></li>
            <?php if ($property['status'] == "5"): // rented ?>
            <li><span><?php echo __("Status", IDXBOOST_DOMAIN_THEME_LANG); ?></span><span><?php echo __("Rented", IDXBOOST_DOMAIN_THEME_LANG); ?></span></li>
            <?php elseif ($property['status'] == "2"): // closed ?>
            <li><span><?php echo __("Status", IDXBOOST_DOMAIN_THEME_LANG); ?></span><span><?php echo __("Closed", IDXBOOST_DOMAIN_THEME_LANG); ?></span></li>
            <?php else: ?>
            <li><span><?php echo __("Status", IDXBOOST_DOMAIN_THEME_LANG); ?></span><span><?php echo __("Active", IDXBOOST_DOMAIN_THEME_LANG); ?></span></li>
            <?php endif; ?>
            <li><span><?php echo __("Development", IDXBOOST_DOMAIN_THEME_LANG); ?></span><span><?php echo empty($property['development']) ? $property['complex'] : $property['development']; ?></span></li>
            <li><span><?php echo __("Subdivision", IDXBOOST_DOMAIN_THEME_LANG); ?></span><span><?php echo $property['subdivision']; ?></span></li>
            <?php if ($property['is_rental'] == 0): ?>
            <li><span><?php echo __("Sale Type", IDXBOOST_DOMAIN_THEME_LANG); ?></span><span><?php echo $property['short_sale'] == 1 ? 'Short Sale' : 'Regular Sale'; ?></span></li>
            <?php endif; ?>
            <li><span><?php echo __("Lot Size", IDXBOOST_DOMAIN_THEME_LANG); ?></span><span><?php echo number_format($property['lot_size']); ?></span></li>
            <li><span><?php echo __("Price / Sq.Ft.", IDXBOOST_DOMAIN_THEME_LANG); ?></span><span><?php echo '$'. number_format($property['price_sqft']); ?></span></li>
            <li><span><?php echo __("Parking Spaces", IDXBOOST_DOMAIN_THEME_LANG); ?></span><span><?php echo (int) $property['parking']; ?></span></li>
            <li><span><?php echo __("Swimming Pool", IDXBOOST_DOMAIN_THEME_LANG); ?></span><span><?php echo $property['pool'] == 1 ? 'Yes' : 'No'; ?></span></li>
            <li><span><?php echo __("Days on Market", IDXBOOST_DOMAIN_THEME_LANG); ?></span><span><?php echo $property['days_market']; ?></span></li>
            <li><span><?php echo __("Year Built", IDXBOOST_DOMAIN_THEME_LANG); ?></span><span><?php echo $property['year']; ?></span></li>
            
            <?php  if ($flex_idx_info["board_id"] == 11 ) { ?>
              <li><span><?php echo __("View Description", IDXBOOST_DOMAIN_THEME_LANG); ?></span><span><?php echo $property['wv']; ?></span></li>
            <?php }else{ ?>
              <li><span><?php echo __("Style", IDXBOOST_DOMAIN_THEME_LANG); ?></span><span><?php echo $property['style']; ?></span></li>
            <?php } ?>            

            <li> <span><?php echo __("Waterfront", IDXBOOST_DOMAIN_THEME_LANG); ?></span><span><?php echo $property['water_front'] == 1 ? 'Yes' : 'No'; ?></span></li>
            <li><span><?php echo __("Furnished", IDXBOOST_DOMAIN_THEME_LANG); ?></span><span><?php echo $property['furnished'] >= 1 ? 'Yes' : 'No'; ?></span></li>
            <li><span><?php echo __("Flooring Type", IDXBOOST_DOMAIN_THEME_LANG); ?></span><span><?php echo $property['floor']; ?></span></li>
            <?php if ($property['status'] == "5"): // rented ?>
            <li><span><?php echo __("Date Rented", IDXBOOST_DOMAIN_THEME_LANG); ?></span><span><?php echo date('m/d/Y', $property['date_close']); ?></span></li>
            <?php elseif ($property['status'] == "2"): // closed ?>
            <li><span><?php echo __("Date Sold", IDXBOOST_DOMAIN_THEME_LANG); ?></span><span><?php echo date('m/d/Y', $property['date_close']); ?></span></li>
            <?php else: ?>
            <li><span><?php echo __("Date Listed", IDXBOOST_DOMAIN_THEME_LANG); ?></span><span><?php echo date('m/d/Y', $property['list_date']); ?></span></li>
            <?php endif; ?>
            <li><span><?php echo __("HOA Fees", IDXBOOST_DOMAIN_THEME_LANG); ?></span><span> <?php echo $property['assoc_fee']; ?></span></li>
            <li><span><?php echo __("Cooling Type", IDXBOOST_DOMAIN_THEME_LANG); ?></span><span><?php echo __("Central", IDXBOOST_DOMAIN_THEME_LANG); ?></span></li>
            <li><span><?php echo __("Heating Type", IDXBOOST_DOMAIN_THEME_LANG); ?></span><span><?php echo __("None", IDXBOOST_DOMAIN_THEME_LANG); ?></span></li>
            <li><span><?php echo __("Taxes Year", IDXBOOST_DOMAIN_THEME_LANG); ?></span><span><?php echo $property['tax_year']; ?></span></li>
            <li><span><?php echo __("Taxes", IDXBOOST_DOMAIN_THEME_LANG); ?></span><span>$<?php echo number_format($property['tax_amount']); ?></span></li>
          </ul>
        </div>
        <?php if (isset($property['amenities']) && is_array($property['amenities']) && !empty($property['amenities'])): ?>
        <div class="list-details clidxboost-amenities-container">
          <h2 class="title-amenities"><?php echo __("Amenities", IDXBOOST_DOMAIN_THEME_LANG); ?></h2>
          <ul class="list-amenities">
            <?php foreach ($property['amenities'] as $amenity): ?>
            <li><?php echo $amenity; ?></li>
            <?php endforeach;?>
          </ul>
        </div>
        <?php endif;?>
        <?php if (isset($property['feature_interior']) && is_array($property['feature_interior']) && !empty($property['feature_interior'])): ?>
        <div class="list-details clidxboost-interior-container">
          <h2 class="title-amenities"><?php echo __("Interior Features", IDXBOOST_DOMAIN_THEME_LANG); ?></h2>
          <ul class="list-amenities">
            <?php foreach ($property['feature_interior'] as $feature_interior): ?>
            <li><?php echo $feature_interior; ?></li>
            <?php endforeach;?>
          </ul>
        </div>
        <?php endif;?>
        <?php if (isset($property['feature_exterior']) && is_array($property['feature_exterior']) && !empty($property['feature_exterior'])): ?>
        <div class="list-details clidxboost-exterior-container">
          <h2 class="title-amenities"><?php echo __("Exterior Features", IDXBOOST_DOMAIN_THEME_LANG); ?></h2>
          <ul class="list-amenities">
            <?php foreach ($property['feature_exterior'] as $feature_exterior): ?>
            <li><?php echo $feature_exterior; ?></li>
            <?php endforeach;?>
          </ul>
        </div>
        <?php endif;?>
        <div class="list-details clidxboost-schools-container" id="clidxboost-schools-container">
          <h2 class="title-amenities"><?php echo __("School Information", IDXBOOST_DOMAIN_THEME_LANG); ?></h2>
          <div class="list-amenities show school-list">
            <h3 class="school-title"><?php echo __("Schools for", IDXBOOST_DOMAIN_THEME_LANG); ?> <?php echo str_replace('# ', '#', $property['address_short']); ?>, <span><?php echo $property['address_large']; ?></span></h3>
            <div class="clidxboost-niche-tab-filters">
              <div class="clidxboost-niche-tab">
                <button class="active" data-filter="all"><span><?php echo __("All Schools", IDXBOOST_DOMAIN_THEME_LANG); ?></span></button>
              </div>
              <div class="clidxboost-niche-tab">
                <button data-filter="elementary"><span><?php echo __("Elementary", IDXBOOST_DOMAIN_THEME_LANG); ?></span></button>
              </div>
              <div class="clidxboost-niche-tab">
                <button data-filter="middle"><span><?php echo __("Middle", IDXBOOST_DOMAIN_THEME_LANG); ?></span></button>
              </div>
              <div class="clidxboost-niche-tab">
                <button data-filter="high"><span><?php echo __("High", IDXBOOST_DOMAIN_THEME_LANG); ?></span></button>
              </div>
            </div>
            <div class="clidxboost-header-niche">
              <div class="clidxboost-header-th"><?php echo __("School", IDXBOOST_DOMAIN_THEME_LANG); ?>  </div>
              <div class="clidxboost-header-th"><?php echo __("Rating", IDXBOOST_DOMAIN_THEME_LANG); ?>  </div>
              <div class="clidxboost-header-th"><?php echo __("Grades", IDXBOOST_DOMAIN_THEME_LANG); ?>  </div>
              <div class="clidxboost-header-th"><?php echo __("Safety", IDXBOOST_DOMAIN_THEME_LANG); ?>  </div>
              <div class="clidxboost-header-th"><?php echo __("Distance", IDXBOOST_DOMAIN_THEME_LANG); ?>  </div>
              <div class="clidxboost-header-th"><?php echo __("Type", IDXBOOST_DOMAIN_THEME_LANG); ?></div>
            </div>
            <div class="clidxboost-body-niche">
              <?php
                $textAcade='';
                $textBest='';
                if ($outtemporali['success']) {
                 foreach ($outtemporali['data'] as $keygeom => $valuegeome) {
                  if (empty($valuegeome['grade_best_school'])) {
                    $textBest='overall-not-graded.png';
                  }else{
                    $textBest=strtolower($valuegeome['grade_best_school']);
                    $textBest=str_replace("-","-minus",$textBest);
                    $textBest='overall-'.str_replace("+","-plus",$textBest).'.png';
                  }
                
                  if (empty($valuegeome['grade_academics_school'])) {
                    $textAcade='overall-not-graded.png';
                  }else{
                    $textAcade=strtolower($valuegeome['grade_academics_school']);
                    $textAcade=str_replace("-","-minus",$textAcade);
                    $textAcade='overall-'.str_replace("+","-plus",$textAcade).'.png';
                  }
                  $pathImageBest='https://alerts.flexidx.com/img/grades/'.$textBest;
                  $pathImageAca='https://alerts.flexidx.com/img/grades/'.$textAcade;
                  $filtextSchool='';
                
                  if ( strpos($valuegeome['name_school'],'Elementary') ) {
                    $filtextSchool='elementary';
                  }elseif  ( strpos($valuegeome['name_school'],'Middle') ) {
                    $filtextSchool='elementary';
                  }elseif  ( strpos($valuegeome['name_school'],'High') ) {
                    $filtextSchool='high';
                  }
                ?>
              <div class="clidxboost-td-niche <?php echo $filtextSchool;?> clidxboost-td-niche-hide">
                <div class="clidxboost-data-item">
                  <a target="blank" rel="nofollow" href="<?php echo  $valuegeome['url'] ;?>"><?php echo $valuegeome['name_school']; ?></a>
                </div>
                <div class="clidxboost-data-item"> <img class="clidxboost-rangeSchools" src="<?php echo $pathImageBest; ?>"></div>
                <div class="clidxboost-data-item"><?php echo $valuegeome['grades_offered']; ?></div>
                <div class="clidxboost-data-item"><img class="clidxboost-safelySchools" src="<?php echo $pathImageAca;?> "></div>
                <div class="clidxboost-data-item"><?php echo number_format(($valuegeome['distancePoint']* 0.62137), 1, '.', ''); ?> <?php echo __("Miles", IDXBOOST_DOMAIN_THEME_LANG); ?>   </div>
                <div class="clidxboost-data-item"><?php echo $valuegeome['character']; ?></div>
              </div>
              <?php   }
                }
                ?>
              <div id="clidxboost-container-loadMore-niche" class="clidxboost-container-loadMore-niche">
                <div class="clidxboost-count-niche">0 <?php echo __("more schools", IDXBOOST_DOMAIN_THEME_LANG); ?></div>
                <div id="clidxboost-data-loadMore-niche"><?php echo __("Expand", IDXBOOST_DOMAIN_THEME_LANG); ?></div>
              </div>
              <div class="uc-listingSchools-disclaimer">
                <p>
                  <a class="uc-listingSchools-attributionLink" href="https://www.niche.com/k12" target="_blank">
                  <?php echo __("K12 School Data", IDXBOOST_DOMAIN_THEME_LANG); ?>
                  </a>
                  <?php echo __("provided by", IDXBOOST_DOMAIN_THEME_LANG); ?>
                  <a href="//www.niche.com/" target="_blank">
                    <svg id="niche-logotype" viewBox="0 0 501.59 76.61" width="100%" height="100%">
                      <path d="M418.36 17.89a34.14 34.14 0 0 0 6.31 3.89 37.4 37.4 0 0 0 18 3.91c6.54-.25 12.5-2.45 18-4.68 4.44-1.78 9.65-3.69 15.25-3.69h1.55a33.94 33.94 0 0 1 14.33 4.58 29.47 29.47 0 0 1 5.46 3.77 3 3 0 0 0 2 .79 2.26 2.26 0 0 0 2.08-1.34 2.48 2.48 0 0 0-.18-2.39 5.25 5.25 0 0 0-1.14-1.21l-.1-.08a38.92 38.92 0 0 0-6-3.87 39.74 39.74 0 0 0-17.6-4.8c-6.4-.19-12.34 1.79-17.79 4l-.14.06c-5.37 2.15-10.93 4.37-17 4.45h-.37a31 31 0 0 1-19.81-7.42 2.47 2.47 0 0 0-2-.56 2.35 2.35 0 0 0-1.67 1.08 2.68 2.68 0 0 0 0 2.58 3.54 3.54 0 0 0 .82.93zM418.36 37.55a34.34 34.34 0 0 0 6.31 3.89 37.26 37.26 0 0 0 18 3.91c6.52-.25 12.49-2.45 18-4.68 4.44-1.78 9.64-3.69 15.25-3.69h1.55a33.94 33.94 0 0 1 14.33 4.59 29.57 29.57 0 0 1 5.46 3.77 3 3 0 0 0 2 .79 2.26 2.26 0 0 0 2.08-1.34 2.44 2.44 0 0 0-.18-2.39 5.26 5.26 0 0 0-1.14-1.21l-.1-.08a39.05 39.05 0 0 0-6-3.87 39.75 39.75 0 0 0-17.6-4.8c-6.41-.2-12.34 1.79-17.79 4l-.15.06c-5.37 2.15-10.92 4.37-17 4.45h-.36a31 31 0 0 1-19.82-7.42 2.47 2.47 0 0 0-2-.56 2.35 2.35 0 0 0-1.67 1.07 2.68 2.68 0 0 0 0 2.59 3.59 3.59 0 0 0 .83.92zM500.04 60.84l-.1-.08a38.89 38.89 0 0 0-6-3.87 39.75 39.75 0 0 0-17.6-4.8c-6.42-.19-12.34 1.79-17.79 4l-.15.06c-5.37 2.15-10.92 4.37-17 4.45h-.37a31 31 0 0 1-19.81-7.43 2.45 2.45 0 0 0-2-.56 2.35 2.35 0 0 0-1.67 1.07 2.68 2.68 0 0 0 0 2.59 3.56 3.56 0 0 0 .83 1 34.3 34.3 0 0 0 6.31 3.89 37.23 37.23 0 0 0 18 3.91c6.54-.25 12.5-2.45 18-4.68 4.45-1.78 9.66-3.69 15.25-3.69h1.55a34 34 0 0 1 14.31 4.53 29.35 29.35 0 0 1 5.46 3.76 3 3 0 0 0 2 .79 2.26 2.26 0 0 0 2.08-1.34 2.47 2.47 0 0 0-.18-2.39 5.25 5.25 0 0 0-1.12-1.21zM398.18 8.64A39.3 39.3 0 0 0 365.59.8a38.27 38.27 0 0 0-2.65 74.3 37.26 37.26 0 0 0 10.54 1.5 39.81 39.81 0 0 0 22.58-7.09A38.68 38.68 0 0 0 412.3 38.3a38.48 38.48 0 0 0-14.12-29.66zm9.38 29.66a34.85 34.85 0 0 1-14.19 27.8 34 34 0 1 1-19.44-61.94h1.49a34.07 34.07 0 0 1 32.14 34.14z"></path>
                      <path d="M389.36 17.69a2.5 2.5 0 0 0-2.49 2.49v29.71L360.4 18.51a2.32 2.32 0 0 0-2.14-.82 2.49 2.49 0 0 0-2.49 2.49v36.79a2.5 2.5 0 0 0 5 0V27.04l26.57 31.5a2.26 2.26 0 0 0 1 .69 2.46 2.46 0 0 0 1 .24 2.5 2.5 0 0 0 2.49-2.49v-36.8a2.5 2.5 0 0 0-2.47-2.49zM81.46 5.99c-2 0-3.54 1.19-3.54 4.18v56.42a3.54 3.54 0 0 0 7.07 0V10.25c0-2.95-1.58-4.26-3.53-4.26zM52.61 5.99c-2 0-3.54 1.19-3.54 4.18V56.3L6.55 7.37a3.25 3.25 0 0 0-1-.78 3.4 3.4 0 0 0-2-.64c-2 0-3.54 1.19-3.54 4.18v56.42a3.54 3.54 0 0 0 7.07 0V18.21L49.8 68.88a3.27 3.27 0 0 0 1.88 1.1 3.49 3.49 0 0 0 4.45-3.4V10.25c.01-2.95-1.57-4.26-3.52-4.26zM234.5 5.99c-2 0-3.53 1.19-3.53 4.18v24.44h-42V10.25c0-2.91-1.58-4.26-3.53-4.26h-.08c-2 0-3.53 1.19-3.53 4.18v56.42a3.54 3.54 0 0 0 3.53 3.53h.08a3.53 3.53 0 0 0 3.53-3.53v-26h42v26a3.535 3.535 0 0 0 7.07 0V10.25c0-2.95-1.58-4.26-3.54-4.26zM124.96 13.78c10.1-5.06 22.05-2.17 29.77 5.71a3.84 3.84 0 0 0 5.31.45 3.36 3.36 0 0 0 0-4.93c-9.51-9.71-23.66-12.35-36.27-7.78-11 4-19.16 14.57-20.7 26.1a32.73 32.73 0 0 0 13.32 30.7 34.05 34.05 0 0 0 36.41 1.85 33.57 33.57 0 0 0 6.45-4.83c1.77-1.68.85-4-.61-5.08a3.59 3.59 0 0 0-4.66.6 25.8 25.8 0 0 1-29.6 4.61c-9.07-4.54-14.29-14.31-14.17-24.27a26.6 26.6 0 0 1 14.75-23.13zM307.27 11.95c2.45 0 3.59-1.33 3.59-3s-1-3-3.52-3h-43.31c-2 0-3.53 1.19-3.53 4.18v56.42a3.54 3.54 0 0 0 3.53 3.53h43.24c2.45 0 3.59-1.33 3.59-3s-1-3-3.52-3h-39.7V40.56h32c2.45 0 3.59-1.33 3.59-3s-1-3-3.51-3h-32.07V11.95zM325.74 20.01a7 7 0 1 1 7-7 7 7 0 0 1-7 7zm0-13.1a6.14 6.14 0 1 0 6 6.1 6.1 6.1 0 0 0-6-6.11z"></path>
                      <path d="M326.66 13.4a2.11 2.11 0 0 0 2-2.22 2.25 2.25 0 0 0-2.13-2.25h-2.75a.38.38 0 0 0-.38.46.87.87 0 0 0 0 .1v7.08c0 .5.12.65.46.65s.44-.17.44-.65v-3.14h1.49l1.58 3.15s.34.76.75.55 0-.94 0-.94zm-2.41-3.71h2.11a1.47 1.47 0 0 1 1.35 1.48 1.45 1.45 0 0 1-1.31 1.46h-2.15z"></path>
                    </svg>
                  </a>
                </p>
                <p>
                  <?php echo __("School data provided as-is by", IDXBOOST_DOMAIN_THEME_LANG); ?>
                  <a class="uc-listingSchools-disclaimerLink" href="https://www.niche.com" target="_blank">
                  Niche</a>,
                  <?php echo __("a third party. It is the responsibility of the user to evaluate all sources of information. Users should visit all school district web sites and visit all the schools in person to verify and consider all data, including eligibility.", IDXBOOST_DOMAIN_THEME_LANG); ?>
                </p>
              </div>
            </div>
            <div class="idxboost-line-properties"></div>
          </div>
        </div>
        <div class="property-contact">
          <div class="info-content">
            <p>
              The multiple listing information is provided by the <?php echo $property["board_name"]; ?>® from a copyrighted compilation of listings.
              The compilation of listings and each individual listing are ©<?php echo date('Y'); ?>-present <?php echo $property["board_name"]; ?>®.
              All Rights Reserved. The information provided is for consumers' personal, noncommercial use and may not be used for any purpose
              other than to identify prospective properties consumers may be interested in purchasing. All properties are subject to prior sale or withdrawal.
              All information provided is deemed reliable but is not guaranteed accurate, and should be independently verified.
              Listing courtesy of: <?php echo $property['office_name']; ?>
            </p>
            <span><?php echo __("Real Estate IDX Powered by:", IDXBOOST_DOMAIN_THEME_LANG); ?> <a href="https://www.idxboost.com" title="IDX Boost" rel="nofollow">IDX Boost</a></span>
          </div>
        </div>
      </div>
    </div>
    <div class="aside">
      <div class="form-content">
        <div class="avatar-content">
          <?php
            $agent_info_name = $flex_idx_info['agent']['agent_first_name'] . ' ' . $flex_idx_info['agent']['agent_last_name'];
            $agent_info_phone = $flex_idx_info['agent']['agent_contact_phone_number'];
            ?>
          <div class="content-avatar-image">
            <img src="<?php echo $agent_info_photo; ?>" title="<?php echo $agent_info_name; ?>" alt="<?php echo $agent_info_name; ?>">
          </div>
          <div class="avatar-information">
            <h2><?php echo $agent_info_name; ?></h2>
            <?php if (!empty($agent_info_phone)): ?>
            <a class="phone-avatar" href="tel:<?php echo preg_replace('/[^\d]/', '', $agent_info_phone); ?>" title="Call to <?php echo flex_agent_format_phone_number($agent_info_phone); ?>"><?php echo __('Ph', IDXBOOST_DOMAIN_THEME_LANG);?>. <?php echo flex_agent_format_phone_number($agent_info_phone); ?></a>
            <?php endif; ?>
          </div>
        </div>
        <form method="post" id="flex-idx-property-form" class="gtm_more_info_property iboost-secured-recaptcha-form iboost-form-validation">
          <input type="hidden" name="ib_tags" value="">
          <input type="hidden" name="action" value="flex_idx_request_property_form">
          <input type="hidden" name="origin" value="<?php echo $property_permalink; ?>">
          <input type="hidden" name="price" id="flex_idx_form_price" value="<?php echo intval($property['price']); ?>">
          <input type="hidden" id="flex_idx_form_mls_num" name="mls_num" value="<?php echo $property['mls_num']; ?>">
          <input type="hidden"  class="name_share" value="<?php echo $property['address_short']; ?>">
          <input type="hidden"  class="link_share" value="<?php echo $property_permalink; ?>">
          <input type="hidden"  class="picture_share" value="<?php echo $property['gallery'][0]; ?>">
          <input type="hidden"  class="caption_sahre" value="<?php echo $property['remark']; ?>">
          <input type="hidden"  class="description_share" value="<?php echo $property['remark']; ?>">

          <?php if (array_key_exists('google_gtm', $flex_idx_info['agent']) && !empty($flex_idx_info['agent']['google_gtm'])) : ?>
            <input type="hidden" name="gclid_field" id="gclid_field_form_more_info_property">
          <?php endif; ?>

          <?php 
            $phoneCode = $flex_idx_lead['lead_info']['country_code_phone'];
            $phoneNumber = $flex_idx_lead['lead_info']['phone_number'];
            $phoneContactNumber = "";
          
            if (!empty($phoneNumber)){
              if (!empty($phoneCode) && ($phoneCode !== "0")){
                $phoneContactNumber = "+".$phoneCode.$phoneNumber;
              }else{
                $phoneContactNumber = $phoneNumber;
              }
            }
          ?>
          <input type="hidden" class="phoneCodeValidation" name="phoneCodeValidation" value="<?php echo $phoneCode; ?>">

          <div class="gform_body">
            <ul class="gform_fields">
              <?php if (array_key_exists('track_gender', $flex_idx_info['agent'])) { 
                if ($flex_idx_info['agent']['track_gender']==true) {  ?>
              <li class="gfield">
                <label class="gfield_label" for="first_name"><?php echo __("Gender", IDXBOOST_DOMAIN_THEME_LANG); ?></label>
                <div class="ginput_container ginput_container_text sp-box">
                  <select name="gender" class="gender">
                    <option value="<?php echo __('Mr.', IDXBOOST_DOMAIN_THEME_LANG);?>"><?php echo __('Mr.', IDXBOOST_DOMAIN_THEME_LANG);?></option>
                    <option value="<?php echo __('Mrs.', IDXBOOST_DOMAIN_THEME_LANG);?>"><?php echo __('Mrs.', IDXBOOST_DOMAIN_THEME_LANG);?></option>
                    <option value="<?php echo __('Miss', IDXBOOST_DOMAIN_THEME_LANG);?>"><?php echo __('Miss', IDXBOOST_DOMAIN_THEME_LANG);?></option>
                  </select>
                  <input required class="medium" name="first_name" id="first_name" type="text" value="<?php if (isset($flex_idx_lead['lead_info']['first_name'])): ?><?php echo $flex_idx_lead['lead_info']['first_name']; ?><?php endif;?>" placeholder="<?php echo __('First Name', IDXBOOST_DOMAIN_THEME_LANG);?>*">
                </div>
              </li>
              <?php }else{ ?>
              <li class="gfield">
                <label class="gfield_label" for="first_name"><?php echo __("First Name", IDXBOOST_DOMAIN_THEME_LANG); ?></label>
                <div class="ginput_container ginput_container_text">
                  <input required class="medium" name="first_name" id="first_name" type="text" value="<?php if (isset($flex_idx_lead['lead_info']['first_name'])): ?><?php echo $flex_idx_lead['lead_info']['first_name']; ?><?php endif;?>" placeholder="<?php echo __("First Name", IDXBOOST_DOMAIN_THEME_LANG); ?>*">
                </div>
              </li>
              <?php  } }else{ ?>
              <li class="gfield">
                <label class="gfield_label" for="first_name"><?php echo __("First Name", IDXBOOST_DOMAIN_THEME_LANG); ?></label>
                <div class="ginput_container ginput_container_text">
                  <input required class="medium" name="first_name" id="first_name" type="text" value="<?php if (isset($flex_idx_lead['lead_info']['first_name'])): ?><?php echo $flex_idx_lead['lead_info']['first_name']; ?><?php endif;?>" placeholder="<?php echo __("First Name", IDXBOOST_DOMAIN_THEME_LANG); ?>*">
                </div>
              </li>
              <?php } ?>
              <li class="gfield">
                <label class="gfield_label" for="first_name"><?php echo __("Last Name", IDXBOOST_DOMAIN_THEME_LANG); ?></label>
                <div class="ginput_container ginput_container_text">
                  <input class="medium" name="last_name" id="last_name" type="text" value="<?php if (isset($flex_idx_lead['lead_info']['last_name'])): ?><?php echo $flex_idx_lead['lead_info']['last_name']; ?><?php endif;?>" placeholder="<?php echo __("Last Name", IDXBOOST_DOMAIN_THEME_LANG); ?>*">
                </div>
              </li>
              <li class="gfield">
                <label class="gfield_label" for="email"><?php echo __("Email", IDXBOOST_DOMAIN_THEME_LANG); ?></label>
                <div class="ginput_container ginput_container_email">
                  <input required class="medium" name="email" id="email" type="email" value="<?php if (isset($flex_idx_lead['lead_info']['email_address'])): ?><?php echo $flex_idx_lead['lead_info']['email_address']; ?><?php endif;?>" placeholder="<?php echo __("Email", IDXBOOST_DOMAIN_THEME_LANG); ?>*">
                </div>
              </li>
              <li class="gfield">
                <label class="gfield_label" for="phone"><?php echo __("Phone", IDXBOOST_DOMAIN_THEME_LANG); ?></label>
                <div class="ginput_container ginput_container_email">
                  <input class="medium" name="phone" id="phone" type="tel" value="<?php echo $phoneContactNumber; ?>" placeholder="<?php echo __("Phone", IDXBOOST_DOMAIN_THEME_LANG); ?>*">
                </div>
              </li>
              <li class="gfield comments">
                <label class="gfield_label" for="message"><?php echo __("Comments", IDXBOOST_DOMAIN_THEME_LANG); ?></label>
                <div class="ginput_container">
                  <textarea class="medium textarea" name="message" id="message" type="text" value="" placeholder="<?php echo __("Comments", IDXBOOST_DOMAIN_THEME_LANG); ?>" rows="10" cols="50"><?php echo __("I am interested in", IDXBOOST_DOMAIN_THEME_LANG); ?> <?php echo str_replace('# ', '#', $property['address_short']); ?> <?php echo $property['address_large']; ?></textarea>
                </div>
              </li>
              <?php if ( ($idxboost_agent_info["show_opt_in_message"]) ) {  ?>
              <li class="gfield fub">
                <div class="ms-flex-chk-ub">
                  <div class="ms-item-chk">
                    <input type="checkbox" id="follow_up_boss_valid" required <?php echo $checked; ?>>
                    <label for="follow_up_boss_valid">Follow Up Boss</label>
                  </div>
                  <div class="ms-fub-disclaimer">
                    <p><?php echo __("By submitting this form you agree to be contacted by", IDXBOOST_DOMAIN_THEME_LANG); ?> <?php echo $idxboost_term_condition["company_name"]; ?> <?php echo __('via call, email, and text. To opt out, you can reply "stop" at any time or click the unsubscribe link in the emails. For more information see our', IDXBOOST_DOMAIN_THEME_LANG); ?> <a href="/terms-and-conditions/#follow-up-boss" target="_blank"><?php echo __("Terms and Conditions", IDXBOOST_DOMAIN_THEME_LANG); ?></a> <?php echo __("and", IDXBOOST_DOMAIN_THEME_LANG); ?> <a href="/terms-and-conditions/#atospp-privacy"><?php echo __("Privacy Policy", IDXBOOST_DOMAIN_THEME_LANG); ?></a></p>
                  </div>
                </div>
              </li>
              <?php } ?>
              <li class="gfield requiredFields">* <?php echo __("Required Fields", IDXBOOST_DOMAIN_THEME_LANG); ?></li>
              <div class="gform_footer">
                <input class="gform_button button gform_submit_button_5" type="submit" value="<?php echo __("Request information", IDXBOOST_DOMAIN_THEME_LANG); ?>">
              </div>
            </ul>
          </div>
        </form>
      </div>
      <div class="info-content">
      <?php if (isset($flex_idx_info["board_id"]) && ("7" == $flex_idx_info["board_id"])): ?>
        <p>The multiple listing information is provided by the Houston Association of Realtors from a copyrighted compilation of listings. The compilation of listings and each individual listing are &copy;<?php echo date('Y'); ?>-present TEXAS All Rights Reserved. The information provided is for consumers' personal, noncommercial use and may not be used for any purpose other than to identify prospective properties consumers may be interested in purchasing. All properties are subject to prior sale or withdrawal. All information provided is deemed reliable but is not guaranteed accurate, and should be independently verified. Listing courtesy of: <span class="ib-bdcourtesy"><?php echo $property['office_name']; ?></span></p>
        <?php else: ?>
        <p>The multiple listing information is provided by the  <?php echo $property["board_name"]; ?>® from a copyrighted compilation of listings.
        The compilation of listings and each individual listing are &copy;<?php echo date('Y'); ?>-present  <?php echo $property["board_name"]; ?>®.
        All Rights Reserved. The information provided is for consumers' personal, noncommercial use and may not be used for any purpose
        other than to identify prospective properties consumers may be interested in purchasing. All properties are subject to prior sale or withdrawal.
        All information provided is deemed reliable but is not guaranteed accurate, and should be independently verified.
        Listing courtesy of: <span class="ib-bdcourtesy"><?php echo $property['office_name']; ?></span></p>
    <?php endif; ?>
        <span>Real Estate IDX Powered by: <a href="https://www.idxboost.com" title="IDX Boost" rel="nofollow">IDX Boost</a></span>
      </div>
      <?php if (!empty($property['related_items'])): ?>
      <div class="similar-properties">
        <h2 class="title-similar-list"><?php echo __("Similar Properties For", IDXBOOST_DOMAIN_THEME_LANG); ?> <?php echo $property['is_rental'] == 1 ? 'Rent' : 'Sale'; ?></h2>
        <ul>
          <?php foreach ($property['related_items'] as $rel_item): ?>
          <li>
            <article>
              <h2>
                <a
                  href="<?php echo rtrim($flex_idx_info["pages"]["flex_idx_property_detail"]["guid"], "/"); ?>/<?php echo $rel_item['slug']; ?>"
                  title="<?php echo str_replace('# ' , '#', $rel_item['address_short']); ?>">
                <?php echo str_replace('# ' , '#', $rel_item['address_short']); ?>
                </a>
              </h2>
              <ul>
                <li class="address"><span><?php echo $rel_item['address_large']; ?></span></li>
                <li class="price">$<?php echo number_format($rel_item['price']); ?></li>
                <li> <span><?php echo $rel_item['bed']; ?> </span>
                  <?php
                    if ($rel_item['bed']>1) {
                      echo __("Beds", IDXBOOST_DOMAIN_THEME_LANG);
                    }else{
                      echo __("Bed", IDXBOOST_DOMAIN_THEME_LANG);
                    }
                    ?>
                </li>
                <li> <span><?php echo $rel_item['bath']; ?><?php if($rel_item['baths_half'] > 0): ?>.5<?php endif; ?></span> <?php echo __("Baths", IDXBOOST_DOMAIN_THEME_LANG); ?></li>
                <li> <span><?php echo number_format($rel_item['sqft']); ?> </span><?php echo __("Sq.Ft", IDXBOOST_DOMAIN_THEME_LANG); ?>.</li>
              </ul>
              <a class="layout-img" href="<?php echo rtrim($flex_idx_info["pages"]["flex_idx_property_detail"]["guid"], "/"); ?>/<?php echo $rel_item['slug']; ?>">
              <img class="lazy-img" data-src="<?php echo $rel_item['gallery'][0]; ?>">
              </a>
            </article>
          </li>
          <?php endforeach;?>
        </ul>
      </div>
      <?php endif; ?>
    </div>
  </div>
</section>
</div>
<div id="printMessageBox"><?php echo __("Please wait while we create your document", IDXBOOST_DOMAIN_THEME_LANG); ?></div>
<!--
  <script type="text/javascript">
    (function ($) {
      $(function() {
        $(document).on("ready", function() {
          $('#modal_img_propertie .title').html('<?php echo str_replace("# ", "#", $property["address_short"]); ?>, <span><?php echo $property["address_large"]; ?></span>');
        });
      });
    })(jQuery);
  </script>
  -->
<script>
  function idxsharefb(){
    window.open('http://www.facebook.com/sharer/sharer.php?u='+window.location.href, 'facebook_share', 'height=320, width=640, toolbar=no, menubar=no, scrollbars=no, resizable=no, location=no, directories=no, status=no');
  }
</script>
<!--
  <script type="text/javascript">
  (function ($) {
    $(function () {
      // ACTIVAR ACORDEONES DEL DETALLE
      var $itemAcordeon = $(".list-details");
      if ($itemAcordeon.length) {
        $(".list-details:first").addClass('active');
      }
  
      $(document).on('click', '.list-details >h2', function(e) {
        e.preventDefault();
        var $this = $(this);
        $('.list-details').removeClass('active');
        $this.parent().addClass('active');
        if ($this.next().hasClass('show')) {
          $this.next().removeClass('show');
          $this.parent().removeClass('active');
        } else {
          $('.list-detail').removeClass('show');
          $('.list-amenities').removeClass('show');
          $this.next().toggleClass('show');
        }
      });
    });
  })(jQuery);
  </script>
  -->
<?php endif; ?>
<script type="text/javascript">
  <?php
    if (!empty($CollapsedPreference)){
      if ($CollapsedPreference=='1'){ ?>
      jQuery('.list-details').removeClass('active');
  
    <?php if (is_numeric(array_search('property_detail', $CollapsedPreferenceDetailt))  != false) { ?> jQuery('.clidxboost-property-container').addClass('active'); <?php } ?>
    <?php if (is_numeric(array_search('amenities', $CollapsedPreferenceDetailt)) != false) {  ?> jQuery('.clidxboost-amenities-container').addClass('active'); <?php } ?>
    <?php if (is_numeric(array_search('interior_features', $CollapsedPreferenceDetailt)) != false) { ?> jQuery('.clidxboost-interior-container').addClass('active'); <?php } ?>
    <?php if (is_numeric(array_search('exterior_features', $CollapsedPreferenceDetailt)) != false) {  ?> jQuery('.clidxboost-exterior-container').addClass('active'); <?php } ?>
    <?php if (is_numeric(array_search('school_information', $CollapsedPreferenceDetailt)) != false) { ?> jQuery('.clidxboost-schools-container').addClass('active'); <?php } ?>
    <?php  }else{ ?>
      jQuery('.clidxboost-property-container').addClass('active');
      jQuery('.clidxboost-schools-container').addClass('active');
      <?php
    }
    }else{ ?>
      jQuery('.clidxboost-property-container').addClass('active');
      jQuery('.clidxboost-schools-container').addClass('active');
  <?php  } ?>
  
  var view_grid_type='';
  <?php
    $sta_view_grid_type='0'; if(array_key_exists('view_grid_type',$search_params)) $sta_view_grid_type= (int) $search_params['view_grid_type']; ?>
  view_grid_type=<?php echo $sta_view_grid_type; ?>;
  if ( !jQuery('body').hasClass('clidxboost-ngrid') && view_grid_type==1) {
    jQuery('body').addClass('clidxboost-ngrid');
  }
</script>

<script>
  (function ($) {
    $(function() {
      /*----------------------------------------------------------------------------------*/
      /* Icono de favoritos
      /*----------------------------------------------------------------------------------*/
      if (typeof idxboostTypeIcon !== "undefined") {
        idxboostTypeIcon();
      }

      /*----------------------------------------------------------------------------------*/
      /* Boton de save
      /*----------------------------------------------------------------------------------*/
      $('#full-main .chk_save').click(function(event){
          event.stopPropagation();
          event.preventDefault();
          var _self = $(this);

          if (_self.hasClass('working')) return false;
          
          //VERIFICAR ESTO XK ME SALE ERROR
          //if (__flex_g_settings.anonymous == 'yes') return active_modal($('#modal_login'));

          if ("yes" === __flex_g_settings.anonymous) {
            if ($(".register").length) {
              /*$(".register").click();
              $(".overlay_modal").css("background-color", "rgba(0,0,0,0.95);");
              $("#modal_login").addClass("active_modal");       
              $("#modal_login .header-tab li a").removeClass("active");
              $("#modal_login .header-tab li a[data-tab='tabRegister']").addClass("active");
              $("#modal_login .item_tab").removeClass("active");
              $("#modal_login #tabRegister").addClass("active");*/

              $("#modal_login").addClass("active_modal").find('[data-tab]').removeClass('active');
              $("#modal_login").addClass("active_modal").find('[data-tab]:eq(1)').addClass('active');
              $("#modal_login").find(".item_tab").removeClass("active");
              $("#tabRegister").addClass("active");
              $("button.close-modal").addClass("ib-close-mproperty");
              $(".overlay_modal").css("background-color", "rgba(0,0,0,0.8);");
              $("#modal_login h2").html(
              $("#modal_login").find("[data-tab]:eq(1)").data("text-force"));
              /*Asigamos el texto personalizado*/
              var titleText = $(".header-tab a[data-tab='tabRegister']").attr('data-text')
              $("#modal_login .modal_cm .content_md .heder_md .ms-title-modal").html(titleText);


              return false;
            }
          }

          //var $realBtn = _self.find('.dgt-mark-favorite');
          var class_id = _self.data('class-id');
          var mls_num = _self.data("mls");
          var token_alert = _self.attr("data-alert-token");

          _self.addClass('working');
          if (_self.find('span').hasClass("active")) { // remove
              $.ajax({
                  url: __flex_g_settings.ajaxUrl,
                  method: "POST",
                  data: {
                      action: "flex_favorite",
                      class_id: class_id,
                      mls_num: mls_num,
                      type_action: 'remove',
                      token_alert: token_alert
                  },
                  dataType: "json",
                  success: function(data) {
                      removeFavoriteIcon(token_alert);
                      _self.removeClass('working');
                      _self.removeAttr('data-alert-token').find('span').removeClass('active').text('save favorite');
                  }
              });

          } else {

            $.ajax({
                  url: __flex_g_settings.ajaxUrl,
                  method: "POST",
                  data: {
                      action: "flex_favorite",
                      class_id: class_id,
                      mls_num: mls_num,
                      type_action: 'add'
                  },
                  dataType: "json",
                  success: function(data) {
                    addFavoriteIcon(mls_num,data.token_alert);
                    _self.removeClass('working');
                    _self.attr('data-alert-token', data.token_alert).find('span').addClass('active').text('remove favorite');
                  }
              });
          }



      });

      /*------------------------------------------------------------------------------------------*/
      /* Incializando las funciones respectivas para las escuelas (NICHE)
      /*------------------------------------------------------------------------------------------*/
      var nicheContent = $(".clidxboost-body-niche .clidxboost-td-niche");
      if(nicheContent.length){

        size_li = $(".clidxboost-body-niche .clidxboost-td-niche").length;
        size_li_actives = 0;

        if (size_li == 0) { $("#clidxboost-container-loadMore-niche").hide(); }

        x = 8;

        $(document).on('click', '#clidxboost-data-loadMore-niche', function() {
          x = (x + 8 <= size_li) ? x + 8 : size_li;
          $('.clidxboost-body-niche .clidxboost-td-niche:lt(' + x + ')').slideDown();
          $('.clidxboost-body-niche .clidxboost-td-niche:lt(' + x + ')').addClass('clidxboost-td-niche-show');
          if (x == size_li) {
            $('#clidxboost-container-loadMore-niche').hide();
          }
          size_li_actives = $('.clidxboost-body-niche .clidxboost-td-niche-show').length;
          var result_item=(parseInt(size_li)-parseInt(size_li_actives));
          $('.clidxboost-count-niche').text( result_item+ ' more schools' );
        });

        $(document).on('click', '.clidxboost-niche-tab-filters button', function() {
          $('#clidxboost-container-loadMore-niche').show();
          $('.clidxboost-td-niche').removeClass('clidxboost-td-niche-show');
          if ($(this).attr('data-filter')=='all') {
            x=8; $('#clidxboost-data-loadMore-niche').click();
          }else if($(this).attr('data-filter')=='elementary'){
            $('.clidxboost-td-niche.elementary').addClass('clidxboost-td-niche-show');
            $('#clidxboost-container-loadMore-niche').hide();
          }else if($(this).attr('data-filter')=='middle'){
            $('.clidxboost-td-niche.middle').addClass('clidxboost-td-niche-show');
            $('#clidxboost-container-loadMore-niche').hide();
          }else if($(this).attr('data-filter')=='high'){
            $('.clidxboost-td-niche.high').addClass('clidxboost-td-niche-show');
            $('#clidxboost-container-loadMore-niche').hide();
          }
        });

        $('#clidxboost-data-loadMore-niche').click();

        $(document).on('click', '.clidxboost-niche-tab-filters button', function() {
          $('.clidxboost-niche-tab-filters button').removeClass('active');
          $(this).addClass('active');
          var $dataFilter = $(this).attr('data-filter');
          $('.clidxboost-td-niche').addClass('td-hidden');
          $('.clidxboost-body-niche .'+$dataFilter).removeClass('td-hidden');
          if ($dataFilter == 'all') {
            $('.clidxboost-td-niche').removeClass('td-hidden');
          }
        });
      }

      function temporalHeightModal() {
        var finalTop = ($(".modal_property_detail .property-information").height()) + ($(".modal_property_detail .panel-options").height()) + 21;
        var propertyDescription = $(".modal_property_detail #property-description");
        if (propertyDescription.length) {
          var heightContent = propertyDescription.height();
          var finalHeight = heightContent + 31;
        }else{
          var finalHeight = 0;
          $(".modal_property_detail .temporal-content").css({'border-bottom':'0'});
        }
        $(".modal_property_detail .temporal-content").height(finalHeight).css({
          'top': finalTop + 'px'
        }).animate({'opacity':'1'});
      }

      temporalHeightModal();
      $(window).on('resize', function() {
        temporalHeightModal();
      });

    });
  })(jQuery);

  function demostracion(){
    $("#info-subfilters").empty().html('lorem ipsum');
  }

  function removeFavoriteIcon(token){
    var _this = $('#result-search button[data-alert-token="'+token+'"]');
    _this.find('span').removeClass('active');
    _this.removeAttr('data-alert-token');
  }

  function addFavoriteIcon(mls,token){
    var _this = $('#result-search .propertie[data-mls="'+mls+'"]').find('.clidxboost-btn-check');
    _this.attr('data-alert-token', token).find('span').addClass('active');
  }

</script>