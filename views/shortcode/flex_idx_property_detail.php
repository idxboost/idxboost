<?php 
  if (!empty($_COOKIE) && is_array($_COOKIE) && array_key_exists("reference_force_registration",$_COOKIE) && $_COOKIE["reference_force_registration"] == "yes") {
    $flex_idx_info["agent"]["force_registration"]='0';
    $registration_is_forced=false;
  }
  
  if ("1" == $flex_idx_info["agent"]["force_registration"]): ?>
<script>
  var IB_PAGE_PROPERTY_DETAIL = true;
  <?php if (!empty($property['mls_num'])): ?>
  var IB_PAGE_PROPERTY_DETAIL_MLS_NUMBER = '<?php echo $property["mls_num"]; ?>';
  <?php endif; ?>
  jQuery(function() {
    //jQuery('button[data-id="modal_login"]').remove();
  });
</script>
<?php endif; ?>
<?php if (empty($property)): ?>
<div class="gwr idx-mmg">
  <div class="message-alert idx_color_primary flex-property-not-available">
    <p>The property you requested with MLS <?php echo $GLOBALS['property_mls']; ?>. is not available.</p>
  </div>
</div>
<?php else: ?>
<script>
  var lastOpenedProperty = "<?php echo $property['mls_num']; ?>";
  // // track listing view
  // $.ajax({
  //     type: "POST",
  //     url: __flex_g_settings.ajaxUrl,
  //     data: {
  //     action: "track_property_view",
  //     board_id: __flex_g_settings.boardId,
  //     mls_number: (typeof lastOpenedProperty === "undefined") ? "" : lastOpenedProperty
  //     },
  //     success: function(response) {
  //     console.log("track done for property #" + lastOpenedProperty);
  //     }
  // });
</script>
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
      var IB_HAS_LEFT_CLICKS = (__flex_g_settings.hasOwnProperty("signup_left_clicks") && (null != __flex_g_settings.signup_left_clicks));
      var currentUrl = new URLSearchParams(location.search);
      var disablePopup = currentUrl.has('nonmodal') ? true : false;
      //console.log(currentUrl.has('nonmodal=yes'))
  
      if (false === disablePopup) {
        if (true === IB_HAS_LEFT_CLICKS) {
        if ((parseInt(Cookies.get("_ib_left_click_force_registration"), 10) <= 0) && ("yes" === __flex_g_settings.anonymous)) {
            if (__flex_g_settings.hasOwnProperty("force_registration_forced") && ("yes" == __flex_g_settings.force_registration_forced)) {
              $("#modal_login").find(".close").remove();
            }
  
            // no left click then open popup registration
            $("#modal_login").addClass("active_modal")
            .find('[data-tab]').removeClass('active');
        
            $("#modal_login").addClass("active_modal")
                .find('[data-tab]:eq(1)')
                .addClass('active');
            
            $("#modal_login")
                .find(".item_tab")
                .removeClass("active");
            
            $("#tabRegister")
            .addClass("active");
  
              $("#modal_login #msRst").empty().html($("#mstextRst").html());
              $("button.close-modal").addClass("ib-close-mproperty");
              $(".overlay_modal").css("background-color", "rgba(0,0,0,0.8);");
              $("#modal_login h2").html($("#modal_login").find('[data-tab]:eq(1)').data("text-force"));
  
              /*Asigamos el texto personalizado*/
              var titleText = $(".header-tab a[data-tab='tabRegister']").attr('data-text')
              $("#modal_login .modal_cm .content_md .heder_md .ms-title-modal").html(titleText);
  
          }
        } else {
            if ("yes" === __flex_g_settings.anonymous) {
              if (__flex_g_settings.hasOwnProperty("force_registration_forced") && ("yes" == __flex_g_settings.force_registration_forced)) {
                $("#modal_login").find(".close").remove();
              }
  
              jQuery("#modal_login").find(".close").css("visibility", "hidden");
              jQuery("#modal_login").addClass("active_modal registration_forced");
              jQuery("#modal_login .header-tab li a").removeClass("active");
              jQuery("#modal_login .header-tab li a[data-tab='tabRegister']").addClass("active");
              jQuery("#modal_login .item_tab").removeClass("active");
              jQuery("#modal_login #tabRegister").addClass("active");
              var $dataTextForce = jQuery("#modal_login .header-tab li").eq(1).find("a").attr("data-text-force");
              var $registerText = $dataTextForce;
              jQuery("#modal_login h2").html($registerText);
              jQuery("#modal_login #msRst").empty().html(jQuery("#mstextRst").html());
  
              /*Asigamos el texto personalizado*/
              var titleText = $(".header-tab a[data-tab='tabRegister']").attr('data-text')
              $("#modal_login .modal_cm .content_md .heder_md .ms-title-modal").html(titleText);
  
            }
          }
      }
        });
      })(jQuery);
  
      <?php if ($property['img_cnt'] <= 0) { ?>
        jQuery('#show-map').click();
      <?php } ?>
    
</script>
<?php endif; ?>
<script>
  var IDX_BOOST_PROPERTY_TITLE = "<?php echo str_replace('# ', '#', $property['address_short']); ?> <?php echo str_replace(' ,', ',', $property['address_large']); ?>";
  document.title = IDX_BOOST_PROPERTY_TITLE;
</script>
<?php
  $logo_broker = '';
  $schoolRatio = '25';
  $CollapsedPreference = '';
  $CollapsedPreferenceDetailt = [];
  $descriptionEspe = '';
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
  ?>
<div id="full-main">
  <section class="title-conteiner gwr animated fixed-box">
    <div class="content-fixed">
      <div class="content-fixed-title">
        <h1 class="title-page"><?php echo str_replace('# ', '#', $property['address_short']); ?><span><?php echo $property['address_large']; ?></span></h1>
        <div class="breadcrumb-options">
          <?php if (wp_get_referer()): ?>
          <a href="<?php echo wp_get_referer(); ?>" class="btn link-back clidxboost-icon-arrow-select">
          <?php echo __("Back to results", IDXBOOST_DOMAIN_THEME_LANG); ?>
          </a>
          <?php endif?>
          <a href="javascript:void(0)" class="btn-request">
            <?php echo __("Request information", IDXBOOST_DOMAIN_THEME_LANG); ?>
          </a>
          <a href="<?php echo $flex_idx_info["pages"]["flex_idx_search"]["guid"]; ?>" class="btn link-search clidxboost-icon-search">
          <?php echo __("New Search", IDXBOOST_DOMAIN_THEME_LANG); ?>
          </a>
          <?php if (1 == $property['status']): ?>
          <?php if ($property['is_favorite']): ?>
          <button class="chk_save chk_save_property btn-active-favorite dgt-mark-favorite" data-address="<?php echo $property['address_short']; ?>" data-alert-token="<?php echo $property['token_alert']; ?>" data-mls="<?php echo $property['mls_num']; ?>" data-class-id="<?php echo $property['class_id']; ?>">
          <span class="active"></span>
          </button>
          <?php else: ?>
          <button class="chk_save chk_save_property btn-active-favorite" data-address="<?php echo $property['address_short']; ?>" data-mls="<?php echo $property['mls_num']; ?>" data-class-id="<?php echo $property['class_id']; ?>" class="dgt-mark-favorite">
          <span></span>
          </button>
          <?php endif;?>
          <?php endif; ?>
        </div>
      </div>
      <ul class="content-fixed-btn">
        <li><a href="<?php echo wp_get_referer(); ?>" class="clidxboost-icon-arrow"><span><?php echo __("Back to results", IDXBOOST_DOMAIN_THEME_LANG); ?></span></a></li>
        <li>
          <!--<button class="clidxboost-icon-envelope show-modal" data-modal="modal_email_to_friend">
            <span><?php echo __("Email to a friend", IDXBOOST_DOMAIN_THEME_LANG); ?></span>
            </button>-->
          <a href="javascript:void(0)" class="btn-request" style="padding: 0 10px">
            <span style="justify-content: center"><?php echo __("Request Information", IDXBOOST_DOMAIN_THEME_LANG); ?></span>
          </a>
        </li>
      </ul>
    </div>
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
      <?php if ($property['img_cnt'] > 0) : ?>
      <?php foreach ($property['gallery'] as $thumbnail) : ?>
      <img data-lazy="<?php echo $thumbnail; ?>" class="img-slider gs-lazy" alt="<?php echo str_replace('# ', '#', $property['address_short']).','.$property['address_large']; ?>">
      <?php endforeach; ?>
      <?php endif; ?>
    </div>
    <div class="moptions">
      <ul class="slider-option">
        <li>
          <button class="option-switch active" id="show-gallery" data-view="gallery"><?php echo __("photos", IDXBOOST_DOMAIN_THEME_LANG); ?></button>
        </li>
        <li>
          <button class="option-switch" id="show-map" data-view="map"><?php echo __("map view", IDXBOOST_DOMAIN_THEME_LANG); ?></button>
        </li>
        <?php if (!empty($property["virtual_tour"])) : ?>
        <li>
          <button class="option-switch" onclick="javascript:window.open('<?php echo strip_tags($property["virtual_tour"]); ?>');"><?php echo __("video", IDXBOOST_DOMAIN_THEME_LANG); ?></button>
        </li>
        <?php endif; ?>
      </ul>
      <?php /*<div id="min-map" data-map-img="https://maps.googleapis.com/maps/api/staticmap?center=<?php echo $property['lat']; ?>,<?php echo $property['lng']; ?>&amp;zoom=14&amp;size=163x87&amp;maptype=roadmap&amp;scale=false&amp;format=png&amp;key=AIzaSyBbcWAf3LnqNPxdZ5TP5resRxl3I3BPZb8&amp;visual_refresh=true&amp;markers=size:mid%7Ccolor:0xff4646%7Clabel:%7C<?php echo $property['lat']; ?>,<?php echo $property['lng']; ?>">
    </div>
    */ ?>
    <button class="full-screen" id="clidxboost-btn-flight"><?php echo __("Full screen", IDXBOOST_DOMAIN_THEME_LANG); ?></button>
  </div>
  <div id="map-view">
    <div id="map-result" data-lat="<?php echo $property['lat']; ?>" data-lng="<?php echo $property['lng']; ?>"></div>
  </div>
  <?php if(array_key_exists("oh_info", $property) && !empty($property['oh_info']) ) { 
    $oh_info=$property['oh_info'];
    $oh_info_de=@json_decode($oh_info,true);
    if (is_array($oh_info_de) && array_key_exists('date',$oh_info_de) && array_key_exists('timer',$oh_info_de)) {
      ?>
  <div class="ms-open">
    <span class="ms-wrap-open">
    <span class="ms-open-title"><?php echo __('Open House', IDXBOOST_DOMAIN_THEME_LANG); ?></span>    
    <span class="ms-open-date"><?php echo $oh_info_de['date'];  ?></span>
    <span class="ms-open-time"><?php echo $oh_info_de['timer']; ?></span>
    </span>
  </div>
  <?php
    }
    ?> 
  <?php } ?>  
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
        <?php if ($property["is_commercial"] != 1){ ?>
        <li><?php echo $property['bed']; ?> <span><?php if ($property['bed']>1) { echo __("Bedroom(s)", IDXBOOST_DOMAIN_THEME_LANG); }else{ echo __("Bedroom(s)", IDXBOOST_DOMAIN_THEME_LANG); } ?> </span></li>
        <li><?php echo $property['bath']; ?> <span><?php if($property['bath']>1){ echo __("Bathroom(s)", IDXBOOST_DOMAIN_THEME_LANG); }else{ echo __("Bathroom(s)", IDXBOOST_DOMAIN_THEME_LANG); } ?> </span></li>
        <li><?php echo $property['baths_half']; ?> <span><?php if ($property['baths_half']>1) { echo __("Half Baths", IDXBOOST_DOMAIN_THEME_LANG); }else{ echo __("Half Bath", IDXBOOST_DOMAIN_THEME_LANG); } ?></span></li>
        <?php }else{ ?>
        <li><?php echo $property['property_type']; ?> <span><?php echo __("Type", IDXBOOST_DOMAIN_THEME_LANG); ?>.</span></li>
        <?php } ?>
        <?php if(1 == $property["is_commercial"]): ?>
        <li><?php echo number_format($property['lot_size']); ?> <span><?php echo __("Approx Lot Size", IDXBOOST_DOMAIN_THEME_LANG); ?>.</span></li>
        <?php else: ?>
        <li><?php echo number_format($property['sqft']); ?> <span><?php echo __("size sq.ft", IDXBOOST_DOMAIN_THEME_LANG); ?>.</span></li>
        <?php endif; ?>
        <?php if ($property['status'] == 1): ?>
        <li class="btn-save">
          <?php if ($property['is_favorite']): ?>
          <button class="chk_save chk_save_property dgt-mark-favorite" data-address="<?php echo $property['address_short']; ?>" data-alert-token="<?php echo $property['token_alert']; ?>" data-mls="<?php echo $property['mls_num']; ?>" data-class-id="<?php echo $property['class_id']; ?>">
          <span class="active"><?php echo __("Remove", IDXBOOST_DOMAIN_THEME_LANG); ?></span>
          </button>
          <?php else: ?>
          <button class="chk_save chk_save_property dgt-mark-favorite" data-address="<?php echo $property['address_short']; ?>" data-mls="<?php echo $property['mls_num']; ?>" data-class-id="<?php echo $property['class_id']; ?>">
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
              <li><a data-share-url="<?php echo $property_permalink; ?>" data-share-title="<?php echo str_replace('# ', '#', $property['address_short']);; ?> <?php echo $property['address_large']; ?>" data-share-description="<?php echo strip_tags($property['remark']); ?>" data-share-image="<?php echo $property['gallery'][0]; ?>" class="ico-facebook property-detail-share-fb" onclick="idxsharefb()" title="Faceboook" rel="nofollow">Faceboook</a></li>
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
            <li> <span><?php echo __("Type", IDXBOOST_DOMAIN_THEME_LANG); ?></span><span><?php echo $property['property_type']; ?></span></li>
            <?php if ($property['status'] == "6"): // pending ?>
            <li><span><?php echo __("Status", IDXBOOST_DOMAIN_THEME_LANG); ?></span><span><?php echo $property['status_name']; ?></span></li>
            <?php elseif ($property['status'] == "5"): // rented ?>
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
            <?php if ($property["is_commercial"] == 1): ?>
            <li><span><?php echo __("Approx Lot Size", IDXBOOST_DOMAIN_THEME_LANG); ?></span><span><?php echo number_format($property['lot_size']); ?></span></li>
            <?php else: ?>
            <li><span><?php echo __("Lot Size", IDXBOOST_DOMAIN_THEME_LANG); ?></span><span><?php echo number_format($property['lot_size']); ?></span></li>
            <?php endif; ?>
            <?php if ($property["is_commercial"] == 0): ?>
            <li><span><?php echo __("Price / Sq.Ft.", IDXBOOST_DOMAIN_THEME_LANG); ?></span><span><?php echo '$'. number_format($property['price_sqft']); ?></span></li>
            <?php endif; ?>
            <?php if ($property["is_commercial"] == 1): ?>
            <li><span><?php echo __("Parking", IDXBOOST_DOMAIN_THEME_LANG); ?></span><span><?php echo $property['parking_desc']; ?></span></li>
            <?php else: ?>
            <li><span><?php echo __("Parking Spaces", IDXBOOST_DOMAIN_THEME_LANG); ?></span><span><?php echo (int) $property['parking']; ?></span></li>
            <?php endif; ?>
            <?php if ($property["is_commercial"] == 0): ?>
            <li><span><?php echo __("Swimming Pool", IDXBOOST_DOMAIN_THEME_LANG); ?></span><span><?php echo $property['pool'] == 1 ? 'Yes' : 'No'; ?></span></li>
            <?php endif; ?>
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
            <?php if ($property["is_commercial"] == 0): ?>
            <li><span><?php echo __("HOA Fees", IDXBOOST_DOMAIN_THEME_LANG); ?></span><span> <?php echo $property['assoc_fee']; ?></span></li>
            <?php endif; ?>
            <?php if ($property["is_commercial"] == 1): ?>
            <li><span><?php echo __("Cooling", IDXBOOST_DOMAIN_THEME_LANG); ?></span><span><?php echo $property['cooling']; ?></span></li>
            <li><span><?php echo __("Heating", IDXBOOST_DOMAIN_THEME_LANG); ?></span><span><?php echo $property['heating']; ?></span></li>
            <?php else: ?>
            <li><span><?php echo __("Cooling Type", IDXBOOST_DOMAIN_THEME_LANG); ?></span><span><?php echo $property['cooling']; ?></span></li>
            <li><span><?php echo __("Heating Type", IDXBOOST_DOMAIN_THEME_LANG); ?></span><span><?php echo $property['heating']; ?></span></li>
            <?php endif; ?>
            <li><span><?php echo __("Taxes Year", IDXBOOST_DOMAIN_THEME_LANG); ?></span><span><?php echo $property['tax_year']; ?></span></li>
            <li><span><?php echo __("Taxes", IDXBOOST_DOMAIN_THEME_LANG); ?></span><span>$<?php echo number_format($property['tax_amount']); ?></span></li>
          </ul>
        </div>
        <?php if (isset($property['amenities']) && is_array($property['amenities']) && !empty($property['amenities'])): ?>
        <div class="list-details clidxboost-amenities-container active">
          <h2 class="title-amenities"><?php echo __("Amenities", IDXBOOST_DOMAIN_THEME_LANG); ?></h2>
          <ul class="list-amenities">
            <?php foreach ($property['amenities'] as $amenity): ?>
            <li><?php echo $amenity; ?></li>
            <?php endforeach;?>
          </ul>
        </div>
        <?php endif;?>
        <?php if (isset($property['feature_interior']) && is_array($property['feature_interior']) && !empty($property['feature_interior'])): ?>
        <div class="list-details clidxboost-interior-container active">
          <h2 class="title-amenities"><?php echo __("Interior Features", IDXBOOST_DOMAIN_THEME_LANG); ?></h2>
          <ul class="list-amenities">
            <?php foreach ($property['feature_interior'] as $feature_interior): ?>
            <li><?php echo $feature_interior; ?></li>
            <?php endforeach;?>
          </ul>
        </div>
        <?php endif;?>
        <?php if (isset($property['feature_exterior']) && is_array($property['feature_exterior']) && !empty($property['feature_exterior'])): ?>
        <div class="list-details clidxboost-exterior-container active">
          <h2 class="title-amenities">
            <?php
              if ($property["is_commercial"] == 1){ 
               echo __("Miscellaneous Information", IDXBOOST_DOMAIN_THEME_LANG); 
              }else{
              echo __("Exterior Features", IDXBOOST_DOMAIN_THEME_LANG);
              }?>
          </h2>
          <ul class="list-amenities">
            <?php foreach ($property['feature_exterior'] as $feature_exterior): ?>
            <li><?php echo $feature_exterior; ?></li>
            <?php endforeach;?>
          </ul>
        </div>
        <?php endif;?>
        <div class="list-details clidxboost-exterior-container active ms-loadmap" id="locationMap">
          <h2 class="title-amenities"><?php echo __("Location", IDXBOOST_DOMAIN_THEME_LANG); ?></h2>
          <div id="ms-wrap-map">
            <div id="googleMap" class="ms-map" data-real-type="mapa" data-img="googleMap" data-lat="<?php echo $property['lat']; ?>" data-lng="<?php echo $property['lng']; ?>"></div>
          </div>
        </div>
        <?php /*
          <div class="list-details clidxboost-schools-container" id="clidxboost-schools-container">
            <h2 class="title-amenities"><?php echo __("School Information", IDXBOOST_DOMAIN_THEME_LANG); ?></h2>
        <div class="list-amenities school-list">
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
      */ ?>
      <?php if( in_array($flex_idx_info["board_id"], ["13","14"]) ){ ?>
      <div class="ib-idx-info">
        <div class="ms-msg">
          <?php if( array_key_exists('board_info', $property) && array_key_exists("last_check_timestamp", $property['board_info']) && !empty($property['board_info']["last_check_timestamp"])){ ?>
          <span>IDXBoost last checked <?php echo $property['board_info']["last_check_timestamp"];?></span>
          <?php } ?>
          <span>Data was last updated <?php echo $property["last_updated"];?></span>
        </div>
      </div>
      <?php } ?>
      <div class="property-contact">
        <div class="info-content">
          <div class="ib-bdisclaimer">
            <?php if( array_key_exists('board_info', $property) && array_key_exists("board_logo_url", $property['board_info']) && !empty($property['board_info']["board_logo_url"])){ ?>
            <div class="ms-logo-board">
              <img src="<?php echo $property['board_info']["board_logo_url"];?>">
            </div>
            <?php } ?>
            <?php if (isset($flex_idx_info["board_id"]) && ("7" == $flex_idx_info["board_id"])){ ?>
            <p>The multiple listing information is provided by the Houston Association of Realtors from a copyrighted compilation of listings. The compilation of listings and each individual listing are &copy;<?php echo date('Y'); ?>-present TEXAS All Rights Reserved. The information provided is for consumers' personal, noncommercial use and may not be used for any purpose other than to identify prospective properties consumers may be interested in purchasing. All properties are subject to prior sale or withdrawal. All information provided is deemed reliable but is not guaranteed accurate, and should be independently verified. Listing courtesy of: <span class="ib-bdcourtesy">{{office_name}}</span></p>
            <?php }else if("13" == $flex_idx_info["board_id"]){ ?>
            <?php if( array_key_exists('board_info', $property) && array_key_exists("board_disclaimer", $property['board_info']) && !empty($property['board_info']["board_disclaimer"])){ ?>
            <p><?php echo $property['board_info']["board_disclaimer"];?></p>
            <?php } ?>
            <?php }else{ ?>
            <p>The multiple listing information is provided by the <?php echo $property["board_name"]; ?>® from a copyrighted compilation of listings.
              The compilation of listings and each individual listing are &copy;<?php echo date('Y'); ?>-present <?php echo $property["board_name"]; ?>®.
              All Rights Reserved. The information provided is for consumers' personal, noncommercial use and may not be used for any purpose
              other than to identify prospective properties consumers may be interested in purchasing. All properties are subject to prior sale or withdrawal.
              All information provided is deemed reliable but is not guaranteed accurate, and should be independently verified.
              Listing courtesy of: <?php echo $property["office_name"]; ?>
            </p>
            <?php } ?>
            <p>Real Estate IDX Powered by: <a href="https://www.tremgroup.com" title="TREMGROUP" rel="nofollow" target="_blank">TREMGROUP</a></p>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="aside ib-mb-show">
    <div class="ms-form-detail msModalDetail">
      <div class="form-content">
        <div class="avatar-content">
          <?php
            $agent_info_name = $flex_idx_info['agent']['agent_first_name'] . ' ' . $flex_idx_info['agent']['agent_last_name'];
            $agent_info_phone = $flex_idx_info['agent']['agent_contact_phone_number'];
            ?>
          <div class="content-avatar-image"><img class="lazy-img" data-src="<?php echo $agent_info_photo; ?>" title="<?php echo $agent_info_name; ?>" alt="<?php echo $agent_info_name; ?>"></div>
          <div class="avatar-information">
            <h2><?php echo $agent_info_name; ?></h2>
            <?php if (!empty($agent_info_phone)): ?>
            <a class="phone-avatar" href="tel:<?php echo preg_replace('/[^\d]/', '', $agent_info_phone); ?>" title="Call to <?php echo flex_agent_format_phone_number($agent_info_phone); ?>"><?php echo __('Ph', IDXBOOST_DOMAIN_THEME_LANG);?>. <?php echo $agent_info_phone; ?></a>
            <?php endif; ?>
          </div>
        </div>
        <form method="post" id="flex-idx-property-form" class="gtm_more_info_property iboost-secured-recaptcha-form">
          <fieldset>
            <legend><?php echo $agent_info_name; ?></legend>
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
            <div class="gform_body">
              <ul class="gform_fields">
                <?php if (array_key_exists('track_gender', $flex_idx_info['agent'])) { 
                  if ($flex_idx_info['agent']['track_gender']==true) {  ?>
                <li class="gfield">
                  <div class="ginput_container ginput_container_text sp-box">
                    <label class="gfield_label" for="ms-gender"><?php echo __("Gender", IDXBOOST_DOMAIN_THEME_LANG); ?></label>
                    <select name="gender" class="gender" id="ms-gender">
                      <option value="<?php echo __('Mr.', IDXBOOST_DOMAIN_THEME_LANG); ?>"><?php echo __('Mr.', IDXBOOST_DOMAIN_THEME_LANG); ?></option>
                      <option value="<?php echo __('Mrs.', IDXBOOST_DOMAIN_THEME_LANG); ?>"><?php echo __('Mrs.', IDXBOOST_DOMAIN_THEME_LANG); ?></option>
                      <option value="<?php echo __('Miss', IDXBOOST_DOMAIN_THEME_LANG); ?>"><?php echo __('Miss', IDXBOOST_DOMAIN_THEME_LANG); ?></option>
                    </select>
                    <input required class="medium" name="first_name" id="first_name" type="text" value="<?php if (isset($flex_idx_lead['lead_info']['first_name'])) : ?><?php echo $flex_idx_lead['lead_info']['first_name']; ?><?php endif; ?>" placeholder="<?php echo __('First Name', IDXBOOST_DOMAIN_THEME_LANG); ?>*">
                  </div>
                </li>
                <?php } else { ?>
                <li class="gfield">
                  <div class="ginput_container ginput_container_text">
                    <label class="gfield_label" for="_ib_fn_inq"><?php echo __("First Name", IDXBOOST_DOMAIN_THEME_LANG); ?></label>
                    <input required class="medium" name="first_name" id="_ib_fn_inq" type="text" value="<?php if (isset($flex_idx_lead['lead_info']['first_name'])) : ?><?php echo $flex_idx_lead['lead_info']['first_name']; ?><?php endif; ?>" placeholder="<?php echo __("First Name", IDXBOOST_DOMAIN_THEME_LANG); ?>*">
                  </div>
                </li>
                <?php  }
                  } else { ?>
                <li class="gfield">
                  <div class="ginput_container ginput_container_text">
                    <label class="gfield_label" for="_ib_fn_inq"><?php echo __("First Name", IDXBOOST_DOMAIN_THEME_LANG); ?></label>
                    <input required class="medium" name="first_name" id="_ib_fn_inq" type="text" value="<?php if (isset($flex_idx_lead['lead_info']['first_name'])) : ?><?php echo $flex_idx_lead['lead_info']['first_name']; ?><?php endif; ?>" placeholder="<?php echo __("First Name", IDXBOOST_DOMAIN_THEME_LANG); ?>*">
                  </div>
                </li>
                <?php } ?>
                <li class="gfield">
                  <div class="ginput_container ginput_container_text">
                    <label class="gfield_label" for="_ib_ln_inq"><?php echo __("Last Name", IDXBOOST_DOMAIN_THEME_LANG); ?></label>
                    <input class="medium" name="last_name" id="_ib_ln_inq" type="text" value="<?php if (isset($flex_idx_lead['lead_info']['last_name'])) : ?><?php echo $flex_idx_lead['lead_info']['last_name']; ?><?php endif; ?>" placeholder="<?php echo __("Last Name", IDXBOOST_DOMAIN_THEME_LANG); ?>*">
                  </div>
                </li>
                <li class="gfield">
                  <div class="ginput_container ginput_container_email">
                    <label class="gfield_label" for="_ib_em_inq"><?php echo __("Email", IDXBOOST_DOMAIN_THEME_LANG); ?></label>
                    <input required class="medium" name="email" id="_ib_em_inq" type="email" value="<?php if (isset($flex_idx_lead['lead_info']['email_address'])) : ?><?php echo $flex_idx_lead['lead_info']['email_address']; ?><?php endif; ?>" placeholder="<?php echo __("Email", IDXBOOST_DOMAIN_THEME_LANG); ?>*">
                  </div>
                </li>
                <li class="gfield">
                  <div class="ginput_container ginput_container_email">
                    <label class="gfield_label" for="_ib_ph_inq"><?php echo __("Phone", IDXBOOST_DOMAIN_THEME_LANG); ?></label>
                    <input class="medium" name="phone" id="_ib_ph_inq" type="text" value="<?php if (isset($flex_idx_lead['lead_info']['phone_number'])) : ?><?php echo $flex_idx_lead['lead_info']['phone_number']; ?><?php endif; ?>" placeholder="<?php echo __("Phone", IDXBOOST_DOMAIN_THEME_LANG); ?>*">
                  </div>
                </li>
                <li class="gfield comments">
                  <div class="ginput_container">
                    <label class="gfield_label" for="ms-message"><?php echo __("Comments", IDXBOOST_DOMAIN_THEME_LANG); ?></label>
                    <textarea class="medium textarea" name="message" id="ms-message" type="text" value="" placeholder="<?php echo __("Comments", IDXBOOST_DOMAIN_THEME_LANG); ?>" rows="10" cols="50"><?php echo __("I am interested in", IDXBOOST_DOMAIN_THEME_LANG); ?> <?php echo str_replace('# ', '#', $property['address_short']); ?> <?php echo $property['address_large']; ?></textarea>
                  </div>
                </li>
                <li class="gfield requiredFields">* <?php echo __("Required Fields", IDXBOOST_DOMAIN_THEME_LANG); ?></li>
                <li class="gform_footer">
                  <input class="gform_button button gform_submit_button_5" type="submit" value="<?php echo __("Request Information", IDXBOOST_DOMAIN_THEME_LANG); ?>">
                </li>
              </ul>
            </div>
          </fieldset>
        </form>
        <button class="msCloseModalDetail ms-close">Close</button>
      </div>
      <div class="ms-layout-modal mslayoutModalDetail"></div>
    </div>
    <?php if (!empty($property['related_items'])) : ?>
    <div class="similar-properties">
      <h2 class="title-similar-list"><?php echo __("Similar Properties For", IDXBOOST_DOMAIN_THEME_LANG); ?> <?php echo $property['is_rental'] == 1 ? __("Rent", IDXBOOST_DOMAIN_THEME_LANG) : __("Sale", IDXBOOST_DOMAIN_THEME_LANG); ?></h2>
      <ul>
        <?php foreach ($property['related_items'] as $rel_item) : ?>
        <li>
          <article>
            <h3 class="ms-title">
              <a href="<?php echo rtrim($flex_idx_info["pages"]["flex_idx_property_detail"]["guid"], "/"); ?>/<?php echo $rel_item['slug']; ?>" title="<?php echo str_replace('# ', '#', $rel_item['address_short']); ?>">
              <?php echo str_replace('# ', '#', $rel_item['address_short']); ?>
              </a>
            </h3>
            <ul>
              <li class="address"><span><?php echo $rel_item['address_large']; ?></span></li>
              <li class="price">$<?php echo number_format($rel_item['price']); ?></li>
              <li> <span><?php echo $rel_item['bed']; ?> </span>
                <?php
                  if ($rel_item['bed'] > 1) {
                    echo __("Bed(s)", IDXBOOST_DOMAIN_THEME_LANG);
                  } else {
                    echo __("Bed(s)", IDXBOOST_DOMAIN_THEME_LANG);
                  }
                  ?>
              </li>
              <li> <span><?php echo $rel_item['bath']; ?><?php if ($rel_item['baths_half'] > 0) : ?>.5<?php endif; ?></span> <?php echo __("Baths", IDXBOOST_DOMAIN_THEME_LANG); ?></li>
              <li> <span><?php echo number_format($rel_item['sqft']); ?> </span><?php echo __("Sq.Ft", IDXBOOST_DOMAIN_THEME_LANG); ?>.</li>
            </ul>
            <a class="layout-img" href="<?php echo rtrim($flex_idx_info["pages"]["flex_idx_property_detail"]["guid"], "/"); ?>/<?php echo $rel_item['slug']; ?>">
            <img class="lazy-img" data-src="<?php echo $rel_item['gallery'][0]; ?>" alt="<?php echo str_replace('# ' , '#', $rel_item['address_short']); ?>">
            </a>
          </article>
        </li>
        <?php endforeach; ?>
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
    
    <?php if (is_numeric(array_search('school_information', $CollapsedPreferenceDetailt)) != false) { ?> 
      jQuery('.clidxboost-schools-container').addClass('active').ready(function(){ jQuery('.school-list').addClass('show'); }); 
    <?php } ?>
  
    <?php }else{ ?>
      jQuery('.clidxboost-property-container').addClass('active');
      jQuery('.clidxboost-schools-container').addClass('active').ready(function(){ jQuery('.school-list').addClass('show'); }); 
      <?php
    }
    
    }else{ ?>
      jQuery('.clidxboost-property-container').addClass('active');
      jQuery('.clidxboost-schools-container').addClass('active').ready(function(){ jQuery('.school-list').addClass('show'); }); 
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
  
      <?php if( (isset($flex_idx_info['agent']['has_dynamic_ads'])) && (true === $flex_idx_info['agent']['has_dynamic_ads']) ): ?>
        <?php
    $property_price = $property['is_sold'] ? $property['price_sold'] : $property['price'];
    ?>
      setTimeout(function () {
        if ("undefined" !== typeof dataLayer) {
          var _priceCalc = '<?php echo $property_price; ?>';
          var int_price = parseInt(_priceCalc.replace(/[^\d+]/g, ""));
          dataLayer.push({"event": "view_item","value": int_price,"items": [{"id": "22438195","google_business_vertical": "real_estate"}]});
        }
      }, 3000);
      <?php endif; ?>
  
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
  
      function loadMapLocation(){
        var elementSection = $('.ms-loadmap');
        if (elementSection.length) {
          elementSection.each(function(e) {
            var sectionId = $("#" + $(this).attr('id'));
            if (viewMap(sectionId)) {
              var item = 0, el = $(this);
              sectionId.find('[data-img]').each(function(e) {
                if ($(this).attr('data-real-type') == "mapa") {
                  if (viewMap($(this))) {
                    var mapa = $(this).attr('data-img');
                    var lat = $(this).attr('data-lat');
                    var lng = $(this).attr('data-lng');
  
                    if(mapa !== undefined && lat !== undefined && lng !== undefined){
                      var myLatLng = { lat: parseFloat(lat), lng: parseFloat(lng) };
                      var map = new google.maps.Map(document.getElementById(mapa), {
                        zoom: 18,
                        center: myLatLng,
                        styles: style_map,
                        gestureHandling: 'cooperative',
                        panControl: false,
                        scrollwheel: false,
                        disableDoubleClickZoom: true,
                        disableDefaultUI: true,
                        streetViewControl: true,
                      });
              
                      var marker = new google.maps.Marker({
                        position: myLatLng,
                        map: map
                      });
  
                      google.maps.event.addListenerOnce(map, 'tilesloaded', setupMapControls);
  
                      function handleSatelliteButton(event){
                        event.stopPropagation();
                        event.preventDefault();
                        map.setMapTypeId(google.maps.MapTypeId.HYBRID)
  
                        if($(this).hasClass("is-active")){
                          $(this).removeClass("is-active");
                          map.setMapTypeId(google.maps.MapTypeId.ROADMAP)
                        }else{
                          $(this).addClass("is-active");
                          map.setMapTypeId(google.maps.MapTypeId.HYBRID)
                        }
                      }
  
                      function handleZoomInButton(event) {
                        event.stopPropagation();
                        event.preventDefault();
                        map.setZoom(map.getZoom() + 1);
                      }
  
                      function handleZoomOutButton(event) {
                        event.stopPropagation();
                        event.preventDefault();
                        map.setZoom(map.getZoom() - 1);
                      }
  
                      function handlefullscreenButton() {
  
                        var elementToSendFullscreen = map.getDiv().firstChild;
  
                        if (isFullscreen(elementToSendFullscreen)) {
                          exitFullscreen();
                        } else {
                          requestFullscreen(elementToSendFullscreen);
                        }
  
                        document.onwebkitfullscreenchange = document.onmsfullscreenchange = document.onmozfullscreenchange = document.onfullscreenchange = function () {
                          if (isFullscreen(elementToSendFullscreen)) {
                            fullscreenControl.classList.add("is-fullscreen");
                          } else {
                            fullscreenControl.classList.remove("is-fullscreen");
                          }
                        };
                      }
  
                      function isFullscreen(element) {
                        return (
                          (document.fullscreenElement ||
                            document.webkitFullscreenElement ||
                            document.mozFullScreenElement ||
                            document.msFullscreenElement) == element
                        );
                      }
  
                      function requestFullscreen(element) {
                        if (element.requestFullscreen) {
                          element.requestFullscreen();
                        } else if (element.webkitRequestFullScreen) {
                          element.webkitRequestFullScreen();
                        } else if (element.mozRequestFullScreen) {
                          element.mozRequestFullScreen();
                        } else if (element.msRequestFullScreen) {
                          element.msRequestFullScreen();
                        }
                      }
  
                      function exitFullscreen() {
                        if (document.exitFullscreen) {
                          document.exitFullscreen();
                        } else if (document.webkitExitFullscreen) {
                          document.webkitExitFullscreen();
                        } else if (document.mozCancelFullScreen) {
                          document.mozCancelFullScreen();
                        } else if (document.msExitFullscreen) {
                          document.msExitFullscreen();
                        }
                      }
  
                      function setupMapControls() {
                        // setup buttons wrapper
                        mapButtonsWrapper = document.createElement("div");
                        mapButtonsWrapper.classList.add('flex-map-controls-ct');
  
                        // setup Full Screen button
                        fullscreenControl = document.createElement("div");
                        fullscreenControl.classList.add('flex-map-fullscreen');
                        mapButtonsWrapper.appendChild(fullscreenControl);
  
                        // setup zoom in button
                        mapZoomInButton = document.createElement("div");
                        mapZoomInButton.classList.add('flex-map-zoomIn');
                        mapButtonsWrapper.appendChild(mapZoomInButton);
  
                        // setup zoom out button
                        mapZoomOutButton = document.createElement("div");
                        mapZoomOutButton.classList.add('flex-map-zoomOut');
                        mapButtonsWrapper.appendChild(mapZoomOutButton);
  
                        // setup Satellite button
                        satelliteMapButton = document.createElement("div");
                        satelliteMapButton.classList.add('flex-satellite-button');
                        mapButtonsWrapper.appendChild(satelliteMapButton);
  
                        // add Buttons
                        google.maps.event.addDomListener(mapZoomInButton, "click", handleZoomInButton);
                        google.maps.event.addDomListener(mapZoomOutButton, "click", handleZoomOutButton);
                        google.maps.event.addDomListener(fullscreenControl, "click", handlefullscreenButton);
                        google.maps.event.addDomListener(satelliteMapButton, "click", handleSatelliteButton);
                        map.controls[google.maps.ControlPosition.TOP_RIGHT].push(mapButtonsWrapper);
                      }
                      
                      $(this).removeAttr('data-img');
                    }
                    item++;
                  }
                }
              });
              if (item == sectionId.find('[data-img]').size()) {
                el.addClass('ms-loaded').removeClass('ms-loadmap');
              }
            }
          });
        }
      }
  
      function viewMap(elem) {
        var docViewTop = 0;  
        var docViewBottom = 0;  
        var elemTop = 0;  
        var elemBottom = 0;  
        docViewTop = $(window).scrollTop();  
        docViewBottom = docViewTop + $(window).height();  
        elemTop = $(elem).offset().top;  
        elemBottom = elemTop + $(elem).height();
        return ((elemBottom > docViewTop) && (elemTop < docViewBottom));
      }
      
      $(window).load(function() { loadMapLocation(); });
      $(window).scroll(function() { loadMapLocation(); });
  
  
      $(document).on("click", ".btn-request", function (e) {
        e.preventDefault();
        $("body").addClass("ms-active-aside-form");
      });
  
      $(document).on("click", ".msCloseModalDetail, .mslayoutModalDetail", function (e) {
        e.preventDefault();
        $("body").removeClass("ms-active-aside-form");
      });
  
    });
  })(jQuery);
</script>