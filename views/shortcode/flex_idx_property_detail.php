<style>
  .ib-idx-info{
    order: 5
  }
  @media (max-width:1023px){
    .ib-idx-info,
    #full-main.ms-property-detail-page .container .main-content .similar-properties {
      padding-left: 15px !important;
      padding-right: 15px !important;
    }
  }
</style>
<?php 

  $idxboost_term_condition = get_option('idxboost_term_condition');
  $idxboost_agent_info = get_option('idxboost_agent_info');

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
    <!--<p>The property you requested with MLS <?php echo $GLOBALS['property_mls']; ?>. is not available.</p>-->
    <?php
      global $wp_query;
      $wp_query->set_404();
      status_header( 404 );
      get_template_part( 404 ); exit();    
      ?>
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
<?php if (
  (!empty($flex_idx_info["agent"]["google_analytics"])) && (!empty($flex_idx_info["agent"]["google_adwords"]))
  && is_array($property) && array_key_exists('is_sold', $property) && array_key_exists('price_sold', $property)
): ?>
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
  
  $more_info_property = [];
  if (is_array($property) && array_key_exists("more_info_property", $property) && is_array($property["more_info_property"]) && count($property["more_info_property"]) > 0  ) {
  $more_info_property = $property["more_info_property"];
  }
  
  $agent_info_name = $flex_idx_info['agent']['agent_first_name'] . ' ' . $flex_idx_info['agent']['agent_last_name'];
  $agent_info_phone = $flex_idx_info['agent']['agent_contact_phone_number'];
  ?>
<div id="full-main" class="ms-property-detail-page ms-wrapper-actions-fs">
  <section class="title-conteiner gwr animated fixed-box">
    <div class="content-fixed">
      <div class="content-fixed-title">
        <h1 class="title-page ms-property-title"><?php echo str_replace('# ', '#', $property['address_short']); ?><span><?php echo $property['address_large']; ?></span></h1>
        <div class="breadcrumb-options">
          <div class="ms-property-search">
            <div class="ms-wrapper-btn-new-share">
              <div class="ms-wrapper">
                <button class="ms-share-btn"><?php echo __("Share", IDXBOOST_DOMAIN_THEME_LANG); ?></button>
                <ul class="ms-share-list">
                  <li class="ib-pscitem ib-psemailfriend -emailtofriendbuilding" data-permalink="" data-mls="<?php echo $property["mls_num"]; ?>" data-status="">
                    <a rel="nofollow" href="javascript:void(0)" 
                      class="ib-psbtn showfriendEmail" 
                      data-modal="modal_email_to_friend" 
                      data-origin="1"
                      data-media="ib-pva-photos"
                      data-price="$<?php echo number_format($property['price']); ?>"
                      data-beds="<?php echo $property['bed']; ?>"
                      data-baths="<?php echo $property['bath']; ?>"
                      data-sqft="<?php echo number_format($property['sqft']); ?>"
                      data-address="<?php echo str_replace('# ', '#', $property['address_short']); ?>, <?php echo $property['address_large']; ?>"
                      data-lg="<?php echo $property['lng']; ?>" 
                      data-lt="<?php echo $property['lat']; ?>">
                    <?php echo __("Email to a friend", IDXBOOST_DOMAIN_THEME_LANG); ?>
                    </a>
                  </li>
                  <li><a href="#" class="ib-pllink -clipboard"><?php echo __("Copy Link", IDXBOOST_DOMAIN_THEME_LANG); ?> <span class="-copied"><?php echo __("copied", IDXBOOST_DOMAIN_THEME_LANG); ?></span></a></li>
                  <li><a class="ib-plsitem ib-plsifb property-detail-share-fb" data-share-url="<?php echo $property_permalink; ?>" data-share-title="<?php echo str_replace('# ', '#', $property['address_short']);; ?> <?php echo $property['address_large']; ?>" data-share-description="<?php echo strip_tags($property['remark']); ?>" data-share-image="<?php echo $property['gallery'][0]; ?>" onclick="idxsharefb()" rel="nofollow">Facebook</a></li>
                  <li><a class="ib-plsitem ib-plsitw" onclick="window.open('<?php echo $twitter_share_url; ?>','s_tw','width=600,height=400'); return false;" rel="nofollow">Twitter</a></li>
                </ul>
              </div>
            </div>
          </div>
          <?php if (wp_get_referer()): ?>
          <a href="<?php echo wp_get_referer(); ?>" class="btn link-back clidxboost-icon-arrow-select">
          <?php echo __("Back to results", IDXBOOST_DOMAIN_THEME_LANG); ?>
          </a>
          <?php endif?>
          <div class="ms-property-call-action">
            <a href="tel:<?php echo flex_agent_format_phone_number($agent_info_phone); ?>" class="ib-pbtnphone">
            <?php echo flex_agent_format_phone_number($agent_info_phone); ?>
            </a>
          </div>
          <?php if (isset($agent_permalink) && !empty($agent_permalink)): ?>
          <a href="<?php echo $agent_permalink; ?>/search" class="btn link-search clidxboost-icon-search">
          <?php echo __("New Search", IDXBOOST_DOMAIN_THEME_LANG); ?>
          </a>
          <?php else: ?>
          <a href="<?php echo $flex_idx_info["pages"]["flex_idx_search"]["guid"]; ?>" class="btn link-search clidxboost-icon-search">
          <?php echo __("New Search", IDXBOOST_DOMAIN_THEME_LANG); ?>
          </a>
          <?php endif; ?>
          <?php if (1 == $property['status']): ?>
          <?php if ($property['is_favorite']): ?>
          <button class="chk_save chk_save_property btn-active-favorite dgt-mark-favorite" data-address="<?php echo $property['address_short']; ?>" data-alert-token="<?php echo $property['token_alert']; ?>" data-mls="<?php echo $property['mls_num']; ?>" data-class-id="<?php echo $property['class_id']; ?>" data-save="<?php echo __("Save", IDXBOOST_DOMAIN_THEME_LANG); ?>" data-remove="<?php echo __("Remove", IDXBOOST_DOMAIN_THEME_LANG); ?>">
          <span class="active"></span>
          </button>
          <?php else: ?>
          <button class="chk_save chk_save_property btn-active-favorite" data-address="<?php echo $property['address_short']; ?>" data-mls="<?php echo $property['mls_num']; ?>" data-class-id="<?php echo $property['class_id']; ?>" class="dgt-mark-favorite" data-save="<?php echo __("Save", IDXBOOST_DOMAIN_THEME_LANG); ?>" data-remove="<?php echo __("Remove", IDXBOOST_DOMAIN_THEME_LANG); ?>">
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
          <span style="justify-content: center"><?php echo flex_agent_format_phone_number($agent_info_phone); ?></span>
          </a>
        </li>
      </ul>
    </div>
  </section>
  <div class="header-print">
    <img src="<?php echo $logo_broker; ?>" title="IDXBoost">
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
    <!--
    <div class="ms-wrapper-pvsinumber">
      <span class="ib-pvsinumber -mx"></span>
    </div> -->
    
    <div id="map-view">
      <div id="map-result" data-lat="<?php echo $property['lat']; ?>" data-lng="<?php echo $property['lng']; ?>"></div>
    </div>

    <div class="moptions">
      <ul class="slider-option">
        <li>
          <button class="option-switch js-option-building ms-gallery-fs active" id="show-gallery" data-view="gallery"><?php echo __('photos', IDXBOOST_DOMAIN_THEME_LANG); ?></button>
        </li>
        <li>
          <button class="option-switch js-option-building-map ms-map-fs" id="show-map" data-view="map" data-lat="<?php echo $property['lat']; ?>" data-lng="<?php echo $property['lng']; ?>"><?php echo __('map view', IDXBOOST_DOMAIN_THEME_LANG); ?></button>
        </li>
        <?php if (!empty($property["virtual_tour"])) : ?>
        <li>
          <a class="ms-video-fs" href="<?php echo strip_tags($property["virtual_tour"]); ?>" data-type="link" title="Virtual Tour" target="_blank"><?php echo __("Video Tour", IDXBOOST_DOMAIN_THEME_LANG); ?></a>
        </li>
        <?php endif; ?>
      </ul>
      <button id="clidxboost-btn-flight" class="full-screen js-open-full-screen" data-type="photo" data-initial="1" data-gallery=".clidxboost-full-slider">Full screen</button>
    </div>
    
    <?php if(array_key_exists("oh_info", $property) && !empty($property['oh_info']) ) { 
      $oh_info=$property['oh_info'];
      $oh_info_de=@json_decode($oh_info,true);
      if (is_array($oh_info_de) && array_key_exists('date',$oh_info_de) && array_key_exists('timer',$oh_info_de)) {
      ?>
    <div class="ms-open">
      <span class="ms-wrap-open">
      <span class="ms-open-title"><?php echo __('Open House', IDXBOOST_DOMAIN_THEME_LANG); ?></span>    
      <span class="ms-open-date"><?php echo $oh_info_de['date']; ?></span>
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
          <li class="price-property">
            $<?php 
              $text_to_rent='';
              if($property['is_rental'] != 0)
              $text_to_rent='/'.__("month", IDXBOOST_DOMAIN_THEME_LANG);
              echo number_format($property['price']).$text_to_rent; ?>
            <!--
              <div class="ib-pipasking">
                <div class="ib-pipatxt -mobile">
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
                </div>
              </div>
              -->
            <?php 
              if( $property['is_rental'] =="0" && ($property['status_name'] !=" Closed" && $property['status_name'] !="Closed") ){ ?>
            <div class="ib-pipasking">
              <div class="ib-pipatxt -mobile"><?php echo __("Est. Payment", IDXBOOST_DOMAIN_THEME_LANG); ?><button class="ib-price-calculator show-modal ico-calculator" data-modal="modal_calculator" id="calculator-mortgage" data-price="$<?php echo number_format($property['price']); ?>"></button></div>
            </div>
            <?php } ?>
          </li>
          <?php if ($property["is_commercial"] != 1){ ?>
          <li class="ib-pilitem ib-pilbeds">
            <span class="ib-pilnumber"><?php echo $property['bed']; ?></span>
            <span class="ib-piltxt"><?php echo __("Bedroom(s)", IDXBOOST_DOMAIN_THEME_LANG); ?></span> 
            <span class="ib-piltxt -min"><?php echo __("Beds(s)", IDXBOOST_DOMAIN_THEME_LANG); ?></span>
          </li>
          <li class="ib-pilitem ib-pilbaths">
            <span class="ib-pilnumber"><?php echo $property['bath']; ?></span>
            <span class="ib-piltxt"><?php echo __("Bathroom(s)", IDXBOOST_DOMAIN_THEME_LANG); ?></span> 
            <span class="ib-piltxt -min"><?php echo __("Baths(s)", IDXBOOST_DOMAIN_THEME_LANG); ?></span>
          </li>
          <li class="ib-pilitem ib-pilhbaths ms-hidden-mb">
            <span class="ib-pilnumber"><?php echo $property['baths_half']; ?></span>
            <span class="ib-piltxt"><?php echo __("Half Bath(s)", IDXBOOST_DOMAIN_THEME_LANG); ?></span> 
            <span class="ib-piltxt -min"><?php echo __("Half Bath(s)", IDXBOOST_DOMAIN_THEME_LANG); ?></span>
          </li>
          <?php }else{ ?>
          <li class="ib-pilitem ib-pilbeds">
            <span class="ib-pilnumber"><?php echo $property['property_type']; ?></span>
            <span class="ib-piltxt"><?php echo __("Type", IDXBOOST_DOMAIN_THEME_LANG); ?></span> 
            <span class="ib-piltxt -min"><?php echo __("Type", IDXBOOST_DOMAIN_THEME_LANG); ?></span>
          </li>
          <?php } ?>
          <?php if(1 == $property["is_commercial"]): ?>
          <li class="ib-pilitem ib-pilsize">
            <span class="ib-pilnumber"><?php
              $inputLotsize = floatval( str_replace ( ",", "", $property["lot_size"] ) );
              $hasAcreLot = false;
              if ($inputLotsize >= 20000) {
               $res0 = floatval($inputLotsize/43560);
               $res0dec = 0;
               if(strpos($res0,".") !== false){
                 $res0dec = 2;
               }
               echo number_format($res0,$res0dec). " Acre";
               $hasAcreLot = true;
              }else{
              echo number_format($property["lot_size"] ); 
              }
              
              ?> </span>
            <span class="ib-piltxt"><?php echo __("Approx Lot Size", IDXBOOST_DOMAIN_THEME_LANG); ?>.</span> 
            <span class="ib-piltxt -min"><?php echo __("Lot Size", IDXBOOST_DOMAIN_THEME_LANG); ?>.</span>
          </li>
          <?php else: ?>
          <li class="ib-pilitem ib-pilsize">
            <span class="ib-pilnumber"><?php                                 
              $inputsqft = floatval( str_replace ( ",", "", $property["sqft"] ) );
              $hasAcre = false;
              if ($inputsqft >= 20000) {
               $res1 = floatval($inputsqft/43560);
               $res1dec = 0;
               if(strpos($res1,".") !== false){
                   $res1dec = 2;
               }
               echo number_format($res1,$res1dec). " Acre";
               $hasAcre = true;
              }else{
                if (empty($property["sqft"])) {
                  echo "N/A"; 
                }else{
                  echo number_format($property["sqft"] ); 
                }
              }
              ?></span>
            <span class="ib-piltxt"><?php 
              if ($hasAcre) {
                echo __("Size", IDXBOOST_DOMAIN_THEME_LANG); 
              }else{
                echo __("Size sq.ft.", IDXBOOST_DOMAIN_THEME_LANG); 
              }
              ?></span> 
            <span class="ib-piltxt -min"><?php echo __("Sq.Ft", IDXBOOST_DOMAIN_THEME_LANG); ?>.</span>
          </li>
          <?php endif; ?>
          <li class="ib-pilitem ib-pilsize ms-hidden-pc">
            <span class="ib-pilnumber"><?php echo '$'. number_format($property['price_sqft']); ?></span>
            <span class="ib-piltxt"><?php echo __("$/Sqft", IDXBOOST_DOMAIN_THEME_LANG); ?></span> 
            <span class="ib-piltxt -min"><?php echo __("$/Sqft", IDXBOOST_DOMAIN_THEME_LANG); ?></span>
          </li>
          <?php if ($property['status'] == 1): ?>
          <li class="btn-save">
            <?php if ($property['is_favorite']): ?>
            <button class="chk_save chk_save_property dgt-mark-favorite" data-address="<?php echo $property['address_short']; ?>" data-alert-token="<?php echo $property['token_alert']; ?>" data-mls="<?php echo $property['mls_num']; ?>" data-class-id="<?php echo $property['class_id']; ?>" data-save="<?php echo __("Save", IDXBOOST_DOMAIN_THEME_LANG); ?>" data-remove="<?php echo __("Remove", IDXBOOST_DOMAIN_THEME_LANG); ?>">
            <span class="ib-piltxt active"><?php echo __("Remove", IDXBOOST_DOMAIN_THEME_LANG); ?></span>
            </button>
            <?php else: ?>
            <button class="chk_save chk_save_property dgt-mark-favorite" data-address="<?php echo $property['address_short']; ?>" data-mls="<?php echo $property['mls_num']; ?>" data-class-id="<?php echo $property['class_id']; ?>" data-save="<?php echo __("Save", IDXBOOST_DOMAIN_THEME_LANG); ?>" data-remove="<?php echo __("Remove", IDXBOOST_DOMAIN_THEME_LANG); ?>">
            <span class="ib-piltxt"><?php echo __("Save", IDXBOOST_DOMAIN_THEME_LANG); ?></span>
            </button>
            <?php endif;?>
          </li>
          <?php endif; ?>
          <li class="ms-share-hidden">
            <div class="ms-wrapper-btn-new-share">
              <div class="ms-wrapper">
                <button class="ms-share-btn"><?php echo __("Share", IDXBOOST_DOMAIN_THEME_LANG); ?></button>
                <ul class="ms-share-list">
                  <li class="ib-pscitem ib-psemailfriend -emailtofriendbuilding" data-permalink="" data-mls="<?php echo $property["mls_num"]; ?>" data-status="">
                    <a rel="nofollow" href="javascript:void(0)" 
                      class="ib-psbtn showfriendEmail" 
                      data-modal="modal_email_to_friend" 
                      data-origin="1"
                      data-media="ib-pva-photos"
                      data-price="$<?php echo number_format($property['price']); ?>"
                      data-beds="<?php echo $property['bed']; ?>"
                      data-baths="<?php echo $property['bath']; ?>"
                      data-sqft="<?php echo number_format($property['sqft']); ?>"
                      data-address="<?php echo str_replace('# ', '#', $property['address_short']); ?>, <?php echo $property['address_large']; ?>"
                      data-lg="<?php echo $property['lng']; ?>" 
                      data-lt="<?php echo $property['lat']; ?>">
                    <?php echo __("Email to a friend", IDXBOOST_DOMAIN_THEME_LANG); ?>
                    </a>
                  </li>
                  <li><a href="#" class="ib-pllink -clipboard"><?php echo __("Copy Link", IDXBOOST_DOMAIN_THEME_LANG); ?><span class="-copied"><?php echo __("copied", IDXBOOST_DOMAIN_THEME_LANG); ?></span></a></li>
                  <li><a class="ib-plsitem ib-plsifb property-detail-share-fb" data-share-url="<?php echo $property_permalink; ?>" data-share-title="<?php echo str_replace('# ', '#', $property['address_short']);; ?> <?php echo $property['address_large']; ?>" data-share-description="<?php echo strip_tags($property['remark']); ?>" data-share-image="<?php echo $property['gallery'][0]; ?>" onclick="idxsharefb()" rel="nofollow">Facebook</a></li>
                  <li><a class="ib-plsitem ib-plsitw" onclick="window.open('<?php echo $twitter_share_url; ?>','s_tw','width=600,height=400'); return false;" rel="nofollow">Twitter</a></li>
                </ul>
              </div>
            </div>
          </li>
        </ul>
        <!--
          <ul class="property-information" data-inf="price:235000|beds:1|baths:1|sqft:822">
             <li class="price-property">
                $235,000 <span>asking price</span>
             </li>
             <li class="ib-pilitem ib-pilbeds">
                <span class="ib-pilnumber">4</span>
                <span class="ib-piltxt">Bedroom(s)</span>
                <span class="ib-piltxt -min">Beds(s)</span>
             </li>
             <li class="ib-pilitem ib-pilbaths">
                <span class="ib-pilnumber">3</span>
                <span class="ib-piltxt">Bathroom(s)</span>
                <span class="ib-piltxt -min">Baths(s)</span>
             </li>
             <li class="ib-pilitem ib-pilsize">
                <span class="ib-pilnumber">10,254</span>
                <span class="ib-piltxt">Size Sqft</span>
                <span class="ib-piltxt -min">Sqft</span>
             </li>
             <li class="ib-pilitem ib-pilsize">
                <span class="ib-pilnumber">$625</span>
                <span class="ib-piltxt">$/Sqft</span>
                <span class="ib-piltxt -min">$/Sq.Ft</span>
             </li>
             <li class="btn-save">
                <button class="chk_save chk_save_property dgt-mark-favorite clidxboost-icon-heart" data-address="3301 NE 5th Ave #417" data-mls="A11040602" data-class-id="1">
                <span class="ib-piltxt">Save Favorite</span>
                <span class="ib-piltxt -min">Save</span>
                </button>
             </li>
          </ul>
          -->
        <div class="panel-options" style="display:none; height: 0; overflow: hidden; padding: 0;">
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
              <!--<li><a data-price="$<?php echo number_format($property['price']); ?>" class="show-modal ico-calculator" href="#" title="Mortgage calculator" data-modal="modal_calculator" rel="nofollow" id="calculator-mortgage"><?php echo __("mortgage", IDXBOOST_DOMAIN_THEME_LANG); ?></a></li>-->
              <li><a class="show-modal ico-envelope" href="javascript:void(0)" title="Email to a firend" data-modal="modal_email_to_friend" rel="nofollow" id="email-friend"><?php echo __("email to a friend", IDXBOOST_DOMAIN_THEME_LANG); ?></a></li>
              <li><a class="ico-printer" href="javascript:void(0)" title="Print" rel="nofollow" id="print-btn"><?php echo __("print", IDXBOOST_DOMAIN_THEME_LANG); ?></a></li>
            </ul>
            <button class="ib-active-float-form"><?php echo __("Contact Agent", IDXBOOST_DOMAIN_THEME_LANG); ?></button>
          </div>
        </div>
        <div class="main-content">
          <!--
            <div class="ib-wrapper-top-map -btn-mp">
               <div class="ib-pheader">
                  <h2 class="ib-ptitle">3301 NE 5th Ave #417</h2>
                  <span class="ib-pstitle">Miami, FL 33137</span>
               </div>
               <div class="ib-wrapper-map">
                  <div id="googleMap2" class="ms-map2" data-real-type="mapa" data-lat="25.773575" data-lng="-80.190742" style="overflow: hidden;">
                     <div style="height: 100%; width: 100%; position: absolute; top: 0px; left: 0px; background-color: rgb(229, 227, 223);">
                        <div class="gm-style" style="position: absolute; z-index: 0; left: 0px; top: 0px; height: 100%; width: 100%; padding: 0px; border-width: 0px; margin: 0px;">
                           <div tabindex="0" aria-label="Map" aria-roledescription="map" role="group" style="position: absolute; z-index: 0; left: 0px; top: 0px; height: 100%; width: 100%; padding: 0px; border-width: 0px; margin: 0px; cursor: url(&quot;https://maps.gstatic.com/mapfiles/openhand_8_8.cur&quot;), default; touch-action: pan-x pan-y;">
                              <div style="z-index: 1; position: absolute; left: 50%; top: 50%; width: 100%; transform: translate(0px, 0px);">
                                 <div style="position: absolute; left: 0px; top: 0px; z-index: 100; width: 100%;">
                                    <div style="position: absolute; left: 0px; top: 0px; z-index: 0;">
                                       <div style="position: absolute; z-index: 982; transform: matrix(1, 0, 0, 1, -226, -72);">
                                          <div style="position: absolute; left: 256px; top: 0px; width: 256px; height: 256px;">
                                             <div style="width: 256px; height: 256px;"></div>
                                          </div>
                                          <div style="position: absolute; left: 0px; top: 0px; width: 256px; height: 256px;">
                                             <div style="width: 256px; height: 256px;"></div>
                                          </div>
                                          <div style="position: absolute; left: 0px; top: -256px; width: 256px; height: 256px;">
                                             <div style="width: 256px; height: 256px;"></div>
                                          </div>
                                          <div style="position: absolute; left: 256px; top: -256px; width: 256px; height: 256px;">
                                             <div style="width: 256px; height: 256px;"></div>
                                          </div>
                                          <div style="position: absolute; left: 512px; top: -256px; width: 256px; height: 256px;">
                                             <div style="width: 256px; height: 256px;"></div>
                                          </div>
                                          <div style="position: absolute; left: 512px; top: 0px; width: 256px; height: 256px;">
                                             <div style="width: 256px; height: 256px;"></div>
                                          </div>
                                          <div style="position: absolute; left: -256px; top: 0px; width: 256px; height: 256px;">
                                             <div style="width: 256px; height: 256px;"></div>
                                          </div>
                                          <div style="position: absolute; left: -256px; top: -256px; width: 256px; height: 256px;">
                                             <div style="width: 256px; height: 256px;"></div>
                                          </div>
                                          <div style="position: absolute; left: 768px; top: -256px; width: 256px; height: 256px;">
                                             <div style="width: 256px; height: 256px;"></div>
                                          </div>
                                          <div style="position: absolute; left: 768px; top: 0px; width: 256px; height: 256px;">
                                             <div style="width: 256px; height: 256px;"></div>
                                          </div>
                                          <div style="position: absolute; left: -512px; top: 0px; width: 256px; height: 256px;">
                                             <div style="width: 256px; height: 256px;"></div>
                                          </div>
                                          <div style="position: absolute; left: -512px; top: -256px; width: 256px; height: 256px;">
                                             <div style="width: 256px; height: 256px;"></div>
                                          </div>
                                       </div>
                                    </div>
                                 </div>
                                 <div style="position: absolute; left: 0px; top: 0px; z-index: 101; width: 100%;"></div>
                                 <div style="position: absolute; left: 0px; top: 0px; z-index: 102; width: 100%;"></div>
                                 <div style="position: absolute; left: 0px; top: 0px; z-index: 103; width: 100%;">
                                    <div style="position: absolute; left: 0px; top: 0px; z-index: -1;">
                                       <div style="position: absolute; z-index: 982; transform: matrix(1, 0, 0, 1, -226, -72);">
                                          <div style="width: 256px; height: 256px; overflow: hidden; position: absolute; left: 256px; top: 0px;"></div>
                                          <div style="width: 256px; height: 256px; overflow: hidden; position: absolute; left: 0px; top: 0px;"></div>
                                          <div style="width: 256px; height: 256px; overflow: hidden; position: absolute; left: 0px; top: -256px;"></div>
                                          <div style="width: 256px; height: 256px; overflow: hidden; position: absolute; left: 256px; top: -256px;"></div>
                                          <div style="width: 256px; height: 256px; overflow: hidden; position: absolute; left: 512px; top: -256px;"></div>
                                          <div style="width: 256px; height: 256px; overflow: hidden; position: absolute; left: 512px; top: 0px;"></div>
                                          <div style="width: 256px; height: 256px; overflow: hidden; position: absolute; left: -256px; top: 0px;"></div>
                                          <div style="width: 256px; height: 256px; overflow: hidden; position: absolute; left: -256px; top: -256px;"></div>
                                          <div style="width: 256px; height: 256px; overflow: hidden; position: absolute; left: 768px; top: -256px;"></div>
                                          <div style="width: 256px; height: 256px; overflow: hidden; position: absolute; left: 768px; top: 0px;"></div>
                                          <div style="width: 256px; height: 256px; overflow: hidden; position: absolute; left: -512px; top: 0px;"></div>
                                          <div style="width: 256px; height: 256px; overflow: hidden; position: absolute; left: -512px; top: -256px;"></div>
                                       </div>
                                    </div>
                                    <div style="width: 27px; height: 43px; overflow: hidden; position: absolute; left: -14px; top: -43px; z-index: 0;"><img alt="" src="https://maps.gstatic.com/mapfiles/api-3/images/spotlight-poi2.png" draggable="false" style="position: absolute; left: 0px; top: 0px; width: 27px; height: 43px; user-select: none; border: 0px; padding: 0px; margin: 0px; max-width: none;"></div>
                                 </div>
                                 <div style="position: absolute; left: 0px; top: 0px; z-index: 0;">
                                    <div style="position: absolute; z-index: 982; transform: matrix(1, 0, 0, 1, -226, -72);">
                                       <div style="position: absolute; left: 256px; top: 0px; width: 256px; height: 256px; transition: opacity 200ms linear 0s;"><img draggable="false" alt="" role="presentation" src="https://maps.googleapis.com/maps/vt?pb=!1m5!1m4!1i18!2i72679!3i111637!4i256!2m3!1e0!2sm!3i557280304!3m12!2ses-ES!3sUS!5e18!12m4!1e68!2m2!1sset!2sRoadmap!12m3!1e37!2m1!1ssmartmaps!4e0&amp;key=AIzaSyBdlczEuxYRH-xlD_EZH4jv0naeVT1JaA4&amp;token=86635" style="width: 256px; height: 256px; user-select: none; border: 0px; padding: 0px; margin: 0px; max-width: none;"></div>
                                       <div style="position: absolute; left: 0px; top: 0px; width: 256px; height: 256px; transition: opacity 200ms linear 0s;"><img draggable="false" alt="" role="presentation" src="https://maps.googleapis.com/maps/vt?pb=!1m5!1m4!1i18!2i72678!3i111637!4i256!2m3!1e0!2sm!3i557280292!3m12!2ses-ES!3sUS!5e18!12m4!1e68!2m2!1sset!2sRoadmap!12m3!1e37!2m1!1ssmartmaps!4e0&amp;key=AIzaSyBdlczEuxYRH-xlD_EZH4jv0naeVT1JaA4&amp;token=18294" style="width: 256px; height: 256px; user-select: none; border: 0px; padding: 0px; margin: 0px; max-width: none;"></div>
                                       <div style="position: absolute; left: 0px; top: -256px; width: 256px; height: 256px; transition: opacity 200ms linear 0s;"><img draggable="false" alt="" role="presentation" src="https://maps.googleapis.com/maps/vt?pb=!1m5!1m4!1i18!2i72678!3i111636!4i256!2m3!1e0!2sm!3i557280292!3m12!2ses-ES!3sUS!5e18!12m4!1e68!2m2!1sset!2sRoadmap!12m3!1e37!2m1!1ssmartmaps!4e0&amp;key=AIzaSyBdlczEuxYRH-xlD_EZH4jv0naeVT1JaA4&amp;token=7889" style="width: 256px; height: 256px; user-select: none; border: 0px; padding: 0px; margin: 0px; max-width: none;"></div>
                                       <div style="position: absolute; left: 256px; top: -256px; width: 256px; height: 256px; transition: opacity 200ms linear 0s;"><img draggable="false" alt="" role="presentation" src="https://maps.googleapis.com/maps/vt?pb=!1m5!1m4!1i18!2i72679!3i111636!4i256!2m3!1e0!2sm!3i557280292!3m12!2ses-ES!3sUS!5e18!12m4!1e68!2m2!1sset!2sRoadmap!12m3!1e37!2m1!1ssmartmaps!4e0&amp;key=AIzaSyBdlczEuxYRH-xlD_EZH4jv0naeVT1JaA4&amp;token=89027" style="width: 256px; height: 256px; user-select: none; border: 0px; padding: 0px; margin: 0px; max-width: none;"></div>
                                       <div style="position: absolute; left: 512px; top: -256px; width: 256px; height: 256px; transition: opacity 200ms linear 0s;"><img draggable="false" alt="" role="presentation" src="https://maps.googleapis.com/maps/vt?pb=!1m5!1m4!1i18!2i72680!3i111636!4i256!2m3!1e0!2sm!3i557280292!3m12!2ses-ES!3sUS!5e18!12m4!1e68!2m2!1sset!2sRoadmap!12m3!1e37!2m1!1ssmartmaps!4e0&amp;key=AIzaSyBdlczEuxYRH-xlD_EZH4jv0naeVT1JaA4&amp;token=55772" style="width: 256px; height: 256px; user-select: none; border: 0px; padding: 0px; margin: 0px; max-width: none;"></div>
                                       <div style="position: absolute; left: 512px; top: 0px; width: 256px; height: 256px; transition: opacity 200ms linear 0s;"><img draggable="false" alt="" role="presentation" src="https://maps.googleapis.com/maps/vt?pb=!1m5!1m4!1i18!2i72680!3i111637!4i256!2m3!1e0!2sm!3i557280304!3m12!2ses-ES!3sUS!5e18!12m4!1e68!2m2!1sset!2sRoadmap!12m3!1e37!2m1!1ssmartmaps!4e0&amp;key=AIzaSyBdlczEuxYRH-xlD_EZH4jv0naeVT1JaA4&amp;token=53380" style="width: 256px; height: 256px; user-select: none; border: 0px; padding: 0px; margin: 0px; max-width: none;"></div>
                                       <div style="position: absolute; left: -256px; top: 0px; width: 256px; height: 256px; transition: opacity 200ms linear 0s;"><img draggable="false" alt="" role="presentation" src="https://maps.googleapis.com/maps/vt?pb=!1m5!1m4!1i18!2i72677!3i111637!4i256!2m3!1e0!2sm!3i557280292!3m12!2ses-ES!3sUS!5e18!12m4!1e68!2m2!1sset!2sRoadmap!12m3!1e37!2m1!1ssmartmaps!4e0&amp;key=AIzaSyBdlczEuxYRH-xlD_EZH4jv0naeVT1JaA4&amp;token=68227" style="width: 256px; height: 256px; user-select: none; border: 0px; padding: 0px; margin: 0px; max-width: none;"></div>
                                       <div style="position: absolute; left: -256px; top: -256px; width: 256px; height: 256px; transition: opacity 200ms linear 0s;"><img draggable="false" alt="" role="presentation" src="https://maps.googleapis.com/maps/vt?pb=!1m5!1m4!1i18!2i72677!3i111636!4i256!2m3!1e0!2sm!3i557280292!3m12!2ses-ES!3sUS!5e18!12m4!1e68!2m2!1sset!2sRoadmap!12m3!1e37!2m1!1ssmartmaps!4e0&amp;key=AIzaSyBdlczEuxYRH-xlD_EZH4jv0naeVT1JaA4&amp;token=57822" style="width: 256px; height: 256px; user-select: none; border: 0px; padding: 0px; margin: 0px; max-width: none;"></div>
                                       <div style="position: absolute; left: 768px; top: 0px; width: 256px; height: 256px; transition: opacity 200ms linear 0s;"><img draggable="false" alt="" role="presentation" src="https://maps.googleapis.com/maps/vt?pb=!1m5!1m4!1i18!2i72681!3i111637!4i256!2m3!1e0!2sm!3i557280304!3m12!2ses-ES!3sUS!5e18!12m4!1e68!2m2!1sset!2sRoadmap!12m3!1e37!2m1!1ssmartmaps!4e0&amp;key=AIzaSyBdlczEuxYRH-xlD_EZH4jv0naeVT1JaA4&amp;token=3447" style="width: 256px; height: 256px; user-select: none; border: 0px; padding: 0px; margin: 0px; max-width: none;"></div>
                                       <div style="position: absolute; left: 768px; top: -256px; width: 256px; height: 256px; transition: opacity 200ms linear 0s;"><img draggable="false" alt="" role="presentation" src="https://maps.googleapis.com/maps/vt?pb=!1m5!1m4!1i18!2i72681!3i111636!4i256!2m3!1e0!2sm!3i557280292!3m12!2ses-ES!3sUS!5e18!12m4!1e68!2m2!1sset!2sRoadmap!12m3!1e37!2m1!1ssmartmaps!4e0&amp;key=AIzaSyBdlczEuxYRH-xlD_EZH4jv0naeVT1JaA4&amp;token=5839" style="width: 256px; height: 256px; user-select: none; border: 0px; padding: 0px; margin: 0px; max-width: none;"></div>
                                       <div style="position: absolute; left: -512px; top: 0px; width: 256px; height: 256px; transition: opacity 200ms linear 0s;"><img draggable="false" alt="" role="presentation" src="https://maps.googleapis.com/maps/vt?pb=!1m5!1m4!1i18!2i72676!3i111637!4i256!2m3!1e0!2sm!3i557280304!3m12!2ses-ES!3sUS!5e18!12m4!1e68!2m2!1sset!2sRoadmap!12m3!1e37!2m1!1ssmartmaps!4e0&amp;key=AIzaSyBdlczEuxYRH-xlD_EZH4jv0naeVT1JaA4&amp;token=105363" style="width: 256px; height: 256px; user-select: none; border: 0px; padding: 0px; margin: 0px; max-width: none;"></div>
                                       <div style="position: absolute; left: -512px; top: -256px; width: 256px; height: 256px; transition: opacity 200ms linear 0s;"><img draggable="false" alt="" role="presentation" src="https://maps.googleapis.com/maps/vt?pb=!1m5!1m4!1i18!2i72676!3i111636!4i256!2m3!1e0!2sm!3i557280304!3m12!2ses-ES!3sUS!5e18!12m4!1e68!2m2!1sset!2sRoadmap!12m3!1e37!2m1!1ssmartmaps!4e0&amp;key=AIzaSyBdlczEuxYRH-xlD_EZH4jv0naeVT1JaA4&amp;token=94958" style="width: 256px; height: 256px; user-select: none; border: 0px; padding: 0px; margin: 0px; max-width: none;"></div>
                                    </div>
                                 </div>
                              </div>
                              <div class="gm-style-pbc" style="z-index: 2; position: absolute; height: 100%; width: 100%; padding: 0px; border-width: 0px; margin: 0px; left: 0px; top: 0px; opacity: 0;">
                                 <p class="gm-style-pbt"></p>
                              </div>
                              <div style="z-index: 3; position: absolute; height: 100%; width: 100%; padding: 0px; border-width: 0px; margin: 0px; left: 0px; top: 0px; touch-action: pan-x pan-y;">
                                 <div style="z-index: 4; position: absolute; left: 50%; top: 50%; width: 100%; transform: translate(0px, 0px);">
                                    <div style="position: absolute; left: 0px; top: 0px; z-index: 104; width: 100%;"></div>
                                    <div style="position: absolute; left: 0px; top: 0px; z-index: 105; width: 100%;"></div>
                                    <div style="position: absolute; left: 0px; top: 0px; z-index: 106; width: 100%;">
                                       <div tabindex="-1" style="width: 27px; height: 43px; overflow: hidden; position: absolute; left: -14px; top: -43px; z-index: 0;">
                                          <img alt="" src="https://maps.gstatic.com/mapfiles/transparent.png" draggable="false" usemap="#gmimap0" style="width: 27px; height: 43px; user-select: none; border: 0px; padding: 0px; margin: 0px; max-width: none;">
                                          <map name="gmimap0" id="gmimap0">
                                             <area log="miw" coords="13.5,0,4,3.75,0,13.5,13.5,43,27,13.5,23,3.75" shape="poly" tabindex="-1" title="" style="cursor: pointer; touch-action: none;">
                                          </map>
                                       </div>
                                    </div>
                                    <div style="position: absolute; left: 0px; top: 0px; z-index: 107; width: 100%;"></div>
                                 </div>
                              </div>
                           </div>
                           <iframe aria-hidden="true" frameborder="0" tabindex="-1" style="z-index: -1; position: absolute; width: 100%; height: 100%; top: 0px; left: 0px; border: none;"></iframe>
                           <div style="pointer-events: none; width: 100%; height: 100%; box-sizing: border-box; position: absolute; z-index: 1000002; opacity: 0; border: 2px solid rgb(26, 115, 232);"></div>
                           <div></div>
                           <div></div>
                           <div>
                              <div class="flex-map-controls-ct" style="z-index: 0; position: absolute; right: 0px; top: 0px;">
                                 <div class="flex-map-fullscreen"></div>
                                 <div class="flex-map-zoomIn"></div>
                                 <div class="flex-map-zoomOut"></div>
                                 <div class="flex-satellite-button"></div>
                              </div>
                           </div>
                           <div></div>
                           <div><button draggable="false" title="Cambiar a la vista en pantalla completa" aria-label="Cambiar a la vista en pantalla completa" type="button" class="gm-control-active gm-fullscreen-control" style="background: none rgb(255, 255, 255); border: 0px; margin: 10px; padding: 0px; text-transform: none; appearance: none; position: absolute; cursor: pointer; user-select: none; border-radius: 2px; height: 40px; width: 40px; box-shadow: rgba(0, 0, 0, 0.3) 0px 1px 4px -1px; overflow: hidden; display: none; top: 164px; right: 0px;"><img src="data:image/svg+xml,%3Csvg%20xmlns%3D%22http%3A//www.w3.org/2000/svg%22%20viewBox%3D%220%200%2018%2018%22%3E%3Cpath%20fill%3D%22%23666%22%20d%3D%22M0%200v6h2V2h4V0H0zm16%200h-4v2h4v4h2V0h-2zm0%2016h-4v2h6v-6h-2v4zM2%2012H0v6h6v-2H2v-4z%22/%3E%3C/svg%3E" alt="" style="height: 18px; width: 18px;"><img src="data:image/svg+xml,%3Csvg%20xmlns%3D%22http%3A//www.w3.org/2000/svg%22%20viewBox%3D%220%200%2018%2018%22%3E%3Cpath%20fill%3D%22%23333%22%20d%3D%22M0%200v6h2V2h4V0H0zm16%200h-4v2h4v4h2V0h-2zm0%2016h-4v2h6v-6h-2v4zM2%2012H0v6h6v-2H2v-4z%22/%3E%3C/svg%3E" alt="" style="height: 18px; width: 18px;"><img src="data:image/svg+xml,%3Csvg%20xmlns%3D%22http%3A//www.w3.org/2000/svg%22%20viewBox%3D%220%200%2018%2018%22%3E%3Cpath%20fill%3D%22%23111%22%20d%3D%22M0%200v6h2V2h4V0H0zm16%200h-4v2h4v4h2V0h-2zm0%2016h-4v2h6v-6h-2v4zM2%2012H0v6h6v-2H2v-4z%22/%3E%3C/svg%3E" alt="" style="height: 18px; width: 18px;"></button></div>
                           <div></div>
                           <div></div>
                           <div></div>
                           <div></div>
                           <div>
                              <div class="gmnoprint gm-bundled-control gm-bundled-control-on-bottom" draggable="false" controlwidth="40" controlheight="40" style="margin: 10px; user-select: none; position: absolute; bottom: 54px; right: 40px;">
                                 <div class="gm-svpc" dir="ltr" title="Arrastra al hombrecito naranja al mapa para abrir Street View" controlwidth="40" controlheight="40" style="background-color: rgb(255, 255, 255); box-shadow: rgba(0, 0, 0, 0.3) 0px 1px 4px -1px; border-radius: 2px; width: 40px; height: 40px; cursor: url(&quot;https://maps.gstatic.com/mapfiles/openhand_8_8.cur&quot;), default; touch-action: none; position: absolute; left: 0px; top: 0px;">
                                    <div style="position: absolute; left: 50%; top: 50%;"></div>
                                    <div style="position: absolute; left: 50%; top: 50%;"><img src="data:image/svg+xml,%3Csvg%20xmlns%3D%22http%3A//www.w3.org/2000/svg%22%20viewBox%3D%220%200%2023%2038%22%3E%3Cpath%20d%3D%22M16.6%2038.1h-5.5l-.2-2.9-.2%202.9h-5.5L5%2025.3l-.8%202a1.53%201.53%200%2001-1.9.9l-1.2-.4a1.58%201.58%200%2001-1-1.9v-.1c.3-.9%203.1-11.2%203.1-11.2a2.66%202.66%200%20012.3-2l.6-.5a6.93%206.93%200%20014.7-12%206.8%206.8%200%20014.9%202%207%207%200%20012%204.9%206.65%206.65%200%2001-2.2%205l.7.5a2.78%202.78%200%20012.4%202s2.9%2011.2%202.9%2011.3a1.53%201.53%200%2001-.9%201.9l-1.3.4a1.63%201.63%200%2001-1.9-.9l-.7-1.8-.1%2012.7zm-3.6-2h1.7L14.9%2020.3l1.9-.3%202.4%206.3.3-.1c-.2-.8-.8-3.2-2.8-10.9a.63.63%200%2000-.6-.5h-.6l-1.1-.9h-1.9l-.3-2a4.83%204.83%200%20003.5-4.7A4.78%204.78%200%200011%202.3H10.8a4.9%204.9%200%2000-1.4%209.6l-.3%202h-1.9l-1%20.9h-.6a.74.74%200%2000-.6.5c-2%207.5-2.7%2010-3%2010.9l.3.1L4.8%2020l1.9.3.2%2015.8h1.6l.6-8.4a1.52%201.52%200%20011.5-1.4%201.5%201.5%200%20011.5%201.4l.9%208.4zm-10.9-9.6zm17.5-.1z%22%20style%3D%22isolation%3Aisolate%22%20fill%3D%22%23333%22%20opacity%3D%22.7%22/%3E%3Cpath%20d%3D%22M5.9%2013.6l1.1-.9h7.8l1.2.9%22%20fill%3D%22%23ce592c%22/%3E%3Cellipse%20cx%3D%2210.9%22%20cy%3D%2213.1%22%20rx%3D%222.7%22%20ry%3D%22.3%22%20style%3D%22isolation%3Aisolate%22%20fill%3D%22%23ce592c%22%20opacity%3D%22.5%22/%3E%3Cpath%20d%3D%22M20.6%2026.1l-2.9-11.3a1.71%201.71%200%2000-1.6-1.2H5.699999999999999a1.69%201.69%200%2000-1.5%201.3l-3.1%2011.3a.61.61%200%2000.3.7l1.1.4a.61.61%200%2000.7-.3l2.7-6.7.2%2016.8h3.6l.6-9.3a.47.47%200%2001.44-.5h.06c.4%200%20.4.2.5.5l.6%209.3h3.6L15.7%2020.3l2.5%206.6a.52.52%200%2000.66.31l1.2-.4a.57.57%200%2000.5-.7z%22%20fill%3D%22%23fdbf2d%22/%3E%3Cpath%20d%3D%22M7%2013.6l3.9%206.7%203.9-6.7%22%20style%3D%22isolation%3Aisolate%22%20fill%3D%22%23cf572e%22%20opacity%3D%22.6%22/%3E%3Ccircle%20cx%3D%2210.9%22%20cy%3D%227%22%20r%3D%225.9%22%20fill%3D%22%23fdbf2d%22/%3E%3C/svg%3E" aria-label="Control del hombrecito naranja de Street View" style="height: 30px; width: 30px; position: absolute; transform: translate(-50%, -50%); pointer-events: none;"><img src="data:image/svg+xml,%3Csvg%20xmlns%3D%22http%3A//www.w3.org/2000/svg%22%20viewBox%3D%220%200%2024%2038%22%3E%3Cpath%20d%3D%22M22%2026.6l-2.9-11.3a2.78%202.78%200%2000-2.4-2l-.7-.5a6.82%206.82%200%20002.2-5%206.9%206.9%200%2000-13.8%200%207%207%200%20002.2%205.1l-.6.5a2.55%202.55%200%2000-2.3%202s-3%2011.1-3%2011.2v.1a1.58%201.58%200%20001%201.9l1.2.4a1.63%201.63%200%20001.9-.9l.8-2%20.2%2012.8h11.3l.2-12.6.7%201.8a1.54%201.54%200%20001.5%201%201.09%201.09%200%2000.5-.1l1.3-.4a1.85%201.85%200%2000.7-2zm-1.2.9l-1.2.4a.61.61%200%2001-.7-.3l-2.5-6.6-.2%2016.8h-9.4L6.6%2021l-2.7%206.7a.52.52%200%2001-.66.31l-1.1-.4a.52.52%200%2001-.31-.66l3.1-11.3a1.69%201.69%200%20011.5-1.3h.2l1-.9h2.3a5.9%205.9%200%20113.2%200h2.3l1.1.9h.2a1.71%201.71%200%20011.6%201.2l2.9%2011.3a.84.84%200%2001-.4.7z%22%20fill%3D%22%23333%22%20fill-opacity%3D%22.2%22/%3E%26quot%3B%3C/svg%3E" aria-label="El hombrecito naranja está en la parte superior del mapa" style="display: none; height: 30px; width: 30px; position: absolute; transform: translate(-50%, -50%); pointer-events: none;"><img src="data:image/svg+xml,%3Csvg%20xmlns%3D%22http%3A//www.w3.org/2000/svg%22%20viewBox%3D%220%200%2040%2050%22%3E%3Cpath%20d%3D%22M34-30.4l-2.9-11.3a2.78%202.78%200%2000-2.4-2l-.7-.5a6.82%206.82%200%20002.2-5%206.9%206.9%200%2000-13.8%200%207%207%200%20002.2%205.1l-.6.5a2.55%202.55%200%2000-2.3%202s-3%2011.1-3%2011.2v.1a1.58%201.58%200%20001%201.9l1.2.4a1.63%201.63%200%20001.9-.9l.8-2%20.2%2012.8h11.3l.2-12.6.7%201.8a1.54%201.54%200%20001.5%201%201.09%201.09%200%2000.5-.1l1.3-.4a1.85%201.85%200%2000.7-2zm-1.2.9l-1.2.4a.61.61%200%2001-.7-.3L28.4-36l-.2%2016.8h-9.4L18.6-36l-2.7%206.7a.52.52%200%2001-.66.31l-1.1-.4a.52.52%200%2001-.31-.66l3.1-11.3a1.69%201.69%200%20011.5-1.3h.2l1-.9h2.3a5.9%205.9%200%20113.2%200h2.3l1.1.9h.2a1.71%201.71%200%20011.6%201.2l2.9%2011.3a.84.84%200%2001-.4.7zM34%2029.6l-2.9-11.3a2.78%202.78%200%2000-2.4-2l-.7-.5a6.82%206.82%200%20002.2-5%206.9%206.9%200%2000-13.8%200%207%207%200%20002.2%205.1l-.6.5a2.55%202.55%200%2000-2.3%202s-3%2011.1-3%2011.2v.1a1.58%201.58%200%20001%201.9l1.2.4a1.63%201.63%200%20001.9-.9l.8-2%20.2%2012.8h11.3l.2-12.6.7%201.8a1.54%201.54%200%20001.5%201%201.09%201.09%200%2000.5-.1l1.3-.4a1.85%201.85%200%2000.7-2zm-1.2.9l-1.2.4a.61.61%200%2001-.7-.3L28.4%2024l-.2%2016.8h-9.4L18.6%2024l-2.7%206.7a.52.52%200%2001-.66.31l-1.1-.4a.52.52%200%2001-.31-.66l3.1-11.3a1.69%201.69%200%20011.5-1.3h.2l1-.9h2.3a5.9%205.9%200%20113.2%200h2.3l1.1.9h.2a1.71%201.71%200%20011.6%201.2l2.9%2011.3a.84.84%200%2001-.4.7z%22%20fill%3D%22%23333%22%20fill-opacity%3D%22.2%22/%3E%3Cpath%20d%3D%22M15.4%2038.8h-4a1.64%201.64%200%2001-1.4-1.1l-3.1-8a.9.9%200%2001-.5.1l-1.4.1a1.62%201.62%200%2001-1.6-1.4L2.3%2015.4l1.6-1.3a6.87%206.87%200%2001-3-4.6A7.14%207.14%200%20012%204a7.6%207.6%200%20014.7-3.1A7.14%207.14%200%200112.2%202a7.28%207.28%200%20012.3%209.6l2.1-.1.1%201c0%20.2.1.5.1.8a2.41%202.41%200%20011%201s1.9%203.2%202.8%204.9c.7%201.2%202.1%204.2%202.8%205.9a2.1%202.1%200%2001-.8%202.6l-.6.4a1.63%201.63%200%2001-1.5.2l-.6-.3a8.93%208.93%200%2000.5%201.3%207.91%207.91%200%20001.8%202.6l.6.3v4.6l-4.5-.1a7.32%207.32%200%2001-2.5-1.5l-.4%203.6zm-10-19.2l3.5%209.8%202.9%207.5h1.6V35l-1.9-9.4%203.1%205.4a8.24%208.24%200%20003.8%203.8h2.1v-1.4a14%2014%200%2001-2.2-3.1%2044.55%2044.55%200%2001-2.2-8l-1.3-6.3%203.2%205.6c.6%201.1%202.1%203.6%202.8%204.9l.6-.4c-.8-1.6-2.1-4.6-2.8-5.8-.9-1.7-2.8-4.9-2.8-4.9a.54.54%200%2000-.4-.3l-.7-.1-.1-.7a4.33%204.33%200%2000-.1-.5l-5.3.3%202.2-1.9a4.3%204.3%200%2000.9-1%205.17%205.17%200%2000.8-4%205.67%205.67%200%2000-2.2-3.4%205.09%205.09%200%2000-4-.8%205.67%205.67%200%2000-3.4%202.2%205.17%205.17%200%2000-.8%204%205.67%205.67%200%20002.2%203.4%203.13%203.13%200%20001%20.5l1.6.6-3.2%202.6%201%2011.5h.4l-.3-8.2z%22%20fill%3D%22%23333%22/%3E%3Cpath%20d%3D%22M3.35%2015.9l1.1%2012.5a.39.39%200%2000.36.42h.14l1.4-.1a.66.66%200%2000.5-.4l-.2-3.8-3.3-8.6z%22%20fill%3D%22%23fdbf2d%22/%3E%3Cpath%20d%3D%22M5.2%2028.8l1.1-.1a.66.66%200%2000.5-.4l-.2-3.8-1.2-3.1z%22%20fill%3D%22%23ce592b%22%20fill-opacity%3D%22.25%22/%3E%3Cpath%20d%3D%22M21.4%2035.7l-3.8-1.2-2.7-7.8L12%2015.5l3.4-2.9c.2%202.4%202.2%2014.1%203.7%2017.1%200%200%201.3%202.6%202.3%203.1v2.9m-8.4-8.1l-2-.3%202.5%2010.1.9.4v-2.9%22%20fill%3D%22%23e5892b%22/%3E%3Cpath%20d%3D%22M17.8%2025.4c-.4-1.5-.7-3.1-1.1-4.8-.1-.4-.1-.7-.2-1.1l-1.1-2-1.7-1.6s.9%205%202.4%207.1a19.12%2019.12%200%20001.7%202.4z%22%20style%3D%22isolation%3Aisolate%22%20fill%3D%22%23cf572e%22%20opacity%3D%22.6%22/%3E%3Cpath%20d%3D%22M14.4%2037.8h-3a.43.43%200%2001-.4-.4l-3-7.8-1.7-4.8-3-9%208.9-.4s2.9%2011.3%204.3%2014.4c1.9%204.1%203.1%204.7%205%205.8h-3.2s-4.1-1.2-5.9-7.7a.59.59%200%2000-.6-.4.62.62%200%2000-.3.7s.5%202.4.9%203.6a34.87%2034.87%200%20002%206z%22%20fill%3D%22%23fdbf2d%22/%3E%3Cpath%20d%3D%22M15.4%2012.7l-3.3%202.9-8.9.4%203.3-2.7%22%20fill%3D%22%23ce592b%22/%3E%3Cpath%20d%3D%22M9.1%2021.1l1.4-6.2-5.9.5%22%20style%3D%22isolation%3Aisolate%22%20fill%3D%22%23cf572e%22%20opacity%3D%22.6%22/%3E%3Cpath%20d%3D%22M12%2013.5a4.75%204.75%200%2001-2.6%201.1c-1.5.3-2.9.2-2.9%200s1.1-.6%202.7-1%22%20fill%3D%22%23bb3d19%22/%3E%3Ccircle%20cx%3D%227.92%22%20cy%3D%228.19%22%20r%3D%226.3%22%20fill%3D%22%23fdbf2d%22/%3E%3Cpath%20d%3D%22M4.7%2013.6a6.21%206.21%200%20008.4-1.9v-.1a8.89%208.89%200%2001-8.4%202z%22%20fill%3D%22%23ce592b%22%20fill-opacity%3D%22.25%22/%3E%3Cpath%20d%3D%22M21.2%2027.2l.6-.4a1.09%201.09%200%2000.4-1.3c-.7-1.5-2.1-4.6-2.8-5.8-.9-1.7-2.8-4.9-2.8-4.9a1.6%201.6%200%2000-2.17-.65l-.23.15a1.68%201.68%200%2000-.4%202.1s2.3%203.9%203.1%205.3c.6%201%202.1%203.7%202.9%205.1a.94.94%200%20001.24.49l.16-.09z%22%20fill%3D%22%23fdbf2d%22/%3E%3Cpath%20d%3D%22M19.4%2019.8c-.9-1.7-2.8-4.9-2.8-4.9a1.6%201.6%200%2000-2.17-.65l-.23.15-.3.3c1.1%201.5%202.9%203.8%203.9%205.4%201.1%201.8%202.9%205%203.8%206.7l.1-.1a1.09%201.09%200%2000.4-1.3%2057.67%2057.67%200%2000-2.7-5.6z%22%20fill%3D%22%23ce592b%22%20fill-opacity%3D%22.25%22/%3E%3C/svg%3E" aria-label="Control del hombrecito naranja de Street View" style="display: none; height: 40px; width: 40px; position: absolute; transform: translate(-60%, -45%); pointer-events: none;"></div>
                                 </div>
                              </div>
                           </div>
                           <div>
                              <div style="margin-left: 5px; margin-right: 5px; z-index: 1000000; position: absolute; left: 0px; bottom: 0px;">
                                 <a target="_blank" rel="noopener" href="https://maps.google.com/maps?ll=25.773575,-80.190742&amp;z=18&amp;t=m&amp;hl=es-ES&amp;gl=US&amp;mapclient=apiv3" title="Abre esta zona en Google Maps (se abre en una nueva ventana)" style="position: static; overflow: visible; float: none; display: inline;">
                                    <div style="width: 66px; height: 26px; cursor: pointer;"><img alt="" src="https://maps.gstatic.com/mapfiles/api-3/images/google4.png" draggable="false" style="position: absolute; left: 0px; top: 0px; width: 66px; height: 26px; user-select: none; border: 0px; padding: 0px; margin: 0px;"></div>
                                 </a>
                              </div>
                           </div>
                           <div></div>
                           <div>
                              <div class="gmnoprint" style="z-index: 1000001; position: absolute; right: 298px; bottom: 0px; width: 193px;">
                                 <div draggable="false" class="gm-style-cc" style="user-select: none; height: 14px; line-height: 14px;">
                                    <div style="opacity: 0.7; width: 100%; height: 100%; position: absolute;">
                                       <div style="width: 1px;"></div>
                                       <div style="background-color: rgb(245, 245, 245); width: auto; height: 100%; margin-left: 1px;"></div>
                                    </div>
                                    <div style="position: relative; padding-right: 6px; padding-left: 6px; box-sizing: border-box; font-family: Roboto, Arial, sans-serif; font-size: 10px; color: rgb(0, 0, 0); white-space: nowrap; direction: ltr; text-align: right; vertical-align: middle; display: inline-block;"><button draggable="false" title="Datos del mapa" aria-label="Datos del mapa" type="button" style="background: none; display: none; border: 0px; margin: 0px; padding: 0px; text-transform: none; appearance: none; position: relative; cursor: pointer; user-select: none; color: rgb(0, 0, 0); font-family: inherit;">Datos del mapa</button><span>Datos de mapas ©2021 Google</span></div>
                                 </div>
                              </div>
                              <div class="gmnoprint gm-style-cc" draggable="false" style="z-index: 1000001; user-select: none; height: 14px; line-height: 14px; position: absolute; right: 190px; bottom: 0px;">
                                 <div style="opacity: 0.7; width: 100%; height: 100%; position: absolute;">
                                    <div style="width: 1px;"></div>
                                    <div style="background-color: rgb(245, 245, 245); width: auto; height: 100%; margin-left: 1px;"></div>
                                 </div>
                                 <div style="position: relative; padding-right: 6px; padding-left: 6px; box-sizing: border-box; font-family: Roboto, Arial, sans-serif; font-size: 10px; color: rgb(0, 0, 0); white-space: nowrap; direction: ltr; text-align: right; vertical-align: middle; display: inline-block;"><a href="https://www.google.com/intl/es-ES_US/help/terms_maps.html" target="_blank" rel="noopener" style="text-decoration: none; cursor: pointer; color: rgb(0, 0, 0);">Términos de uso</a></div>
                              </div>
                              <div draggable="false" class="gm-style-cc" style="user-select: none; height: 14px; line-height: 14px; position: absolute; right: 0px; bottom: 0px;">
                                 <div style="opacity: 0.7; width: 100%; height: 100%; position: absolute;">
                                    <div style="width: 1px;"></div>
                                    <div style="background-color: rgb(245, 245, 245); width: auto; height: 100%; margin-left: 1px;"></div>
                                 </div>
                                 <div style="position: relative; padding-right: 6px; padding-left: 6px; box-sizing: border-box; font-family: Roboto, Arial, sans-serif; font-size: 10px; color: rgb(0, 0, 0); white-space: nowrap; direction: ltr; text-align: right; vertical-align: middle; display: inline-block;"><a target="_blank" rel="noopener" title="Informar a Google acerca de errores en las imágenes o en el mapa de carreteras" dir="ltr" href="https://www.google.com/maps/@25.773575,-80.190742,18z/data=!10m1!1e1!12b1?source=apiv3&amp;rapsrc=apiv3" style="font-family: Roboto, Arial, sans-serif; font-size: 10px; color: rgb(0, 0, 0); text-decoration: none; position: relative;">Notificar un problema de Maps</a></div>
                              </div>
                              <div class="gmnoscreen" style="position: absolute; right: 0px; bottom: 0px;">
                                 <div style="font-family: Roboto, Arial, sans-serif; font-size: 11px; color: rgb(0, 0, 0); direction: ltr; text-align: right; background-color: rgb(245, 245, 245);">Datos de mapas ©2021 Google</div>
                              </div>
                           </div>
                           <div style="background-color: white; padding: 15px 21px; border: 1px solid rgb(171, 171, 171); font-family: Roboto, Arial, sans-serif; color: rgb(34, 34, 34); box-sizing: border-box; box-shadow: rgba(0, 0, 0, 0.2) 0px 4px 16px; z-index: 10000002; display: none; width: 300px; height: 180px; position: absolute; left: 395px; top: 60px;">
                              <div style="padding: 0px 0px 10px; font-size: 16px; box-sizing: border-box;">Datos del mapa</div>
                              <div style="font-size: 13px;">Datos de mapas ©2021 Google</div>
                              <button draggable="false" title="Cerrar" aria-label="Cerrar" type="button" class="gm-ui-hover-effect" style="background: none; display: block; border: 0px; margin: 0px; padding: 0px; text-transform: none; appearance: none; position: absolute; cursor: pointer; user-select: none; top: 0px; right: 0px; width: 37px; height: 37px;"><img src="data:image/svg+xml,%3Csvg%20xmlns%3D%22http%3A//www.w3.org/2000/svg%22%20viewBox%3D%220%200%2024%2024%22%3E%3Cpath%20d%3D%22M19%206.41L17.59%205%2012%2010.59%206.41%205%205%206.41%2010.59%2012%205%2017.59%206.41%2019%2012%2013.41%2017.59%2019%2019%2017.59%2013.41%2012z%22/%3E%3Cpath%20d%3D%22M0%200h24v24H0z%22%20fill%3D%22none%22/%3E%3C/svg%3E" alt="" style="pointer-events: none; display: block; width: 13px; height: 13px; margin: 12px;"></button>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
            -->
          <div class="ib-plist-details -border">
            <div class="ib-plist-card">
              <h2 class="ib-plist-card-title"><?php echo __('Basic Information', IDXBOOST_DOMAIN_THEME_LANG); ?></h2>
              <ul class="ib-plist-list">
                <li>
                  <span class="ib-plist-st"><?php echo __('MLS', IDXBOOST_DOMAIN_THEME_LANG); ?> #</span>
                  <span class="ib-plist-pt"><?php echo $property['mls_num']; ?></span>
                </li>
                <li>
                  <span class="ib-plist-st"><?php echo __('Type', IDXBOOST_DOMAIN_THEME_LANG); ?></span>
                  <span class="ib-plist-pt"><?php echo $property['property_type']; ?></span>
                </li>
                <?php
                  if ( ($property['tw']  == "1" || $property['mf'] == "1" || $property['is_vacant'] == "1") ) {
                    if (is_array($more_info_property) && array_key_exists("style", $more_info_property) && !empty($more_info_property["style"])) { ?>
                <li>
                  <span class="ib-plist-st"><?php echo __("Style", IDXBOOST_DOMAIN_THEME_LANG); ?></span>
                  <span class="ib-plist-pt"><?php echo $more_info_property["style"]; ?></span>
                </li>
                <?php
                  }
                  }
                  ?>                              
                
                <?php
                $status_name = $property['status_name'];
                 if($property["status"] == "2"){
                    $status_name = ($property["is_rental"] == "1") ? __('Rented', IDXBOOST_DOMAIN_THEME_LANG) : __('Sold', IDXBOOST_DOMAIN_THEME_LANG);
                 }
                ?>
                <li>
                  <span class="ib-plist-st"><?php echo __('Status', IDXBOOST_DOMAIN_THEME_LANG); ?></span>
                  <span class="ib-plist-pt"><?php echo $status_name; ?></span>
                </li>
                <li>
                  <span class="ib-plist-st"><?php echo __('Subdivision/Complex', IDXBOOST_DOMAIN_THEME_LANG); ?></span>
                  <span class="ib-plist-pt"><?php echo $property['subdivision']; ?></span>
                </li>
                <li>
                  <span class="ib-plist-st"><?php echo __('Year Built', IDXBOOST_DOMAIN_THEME_LANG); ?></span>
                  <span class="ib-plist-pt"><?php echo $property['year']; ?></span>
                </li>
                <li>
                  <?php 
                    $inputvalTotalsqft = floatval( str_replace ( ",", "", $property["total_sqft"] ) );
                    $valetvalTotalsqft = number_format($property["total_sqft"] );
                    $hasAcreTotalsqft = false;
                    
                    if ( !in_array($inputvalTotalsqft,[0,"undefined","","0"] ) ) {
                        if ($inputvalTotalsqft >= 20000) {
                         $res2 = floatval($inputvalTotalsqft/43560);
                    
                         $res2dec = 0;
                         if(strpos($res2,".") !== false){
                           $res2dec = 2;
                         }
                         $valetvalTotalsqft = number_format($property["total_sqft"] )." Sq.Ft / ".number_format( $res2 , $res2dec ). " Acre";
                         $hasAcreTotalsqft = true;
                       }else{
                       $valetvalTotalsqft = number_format($property["total_sqft"] ); 
                       }
                    }else{
                     $valetvalTotalsqft = "N/A";
                    }
                    
                    ?>                                
                  <span class="ib-plist-st"><?php 
                    if ($hasAcreTotalsqft) {
                      echo __('Total Size', IDXBOOST_DOMAIN_THEME_LANG); 
                    }else{
                     echo __('Total Sqft', IDXBOOST_DOMAIN_THEME_LANG); 
                    }
                    ?></span>
                  <span class="ib-plist-pt"><?php echo $valetvalTotalsqft; ?></span>
                </li>
                <?php if ($type_lookup == "sold") { ?>
                <li>
                  <span class="ib-plist-st"><?php echo __('Date Closed', IDXBOOST_DOMAIN_THEME_LANG); ?></span>
                  <span class="ib-plist-pt"><?php echo date('m/d/Y', $property['date_close']); ?></span>
                </li>
                <?php }else{ ?>
                <li>
                  <span class="ib-plist-st"><?php echo __('Date Listed', IDXBOOST_DOMAIN_THEME_LANG); ?></span>
                  <span class="ib-plist-pt"><?php echo date('m/d/Y', $property['list_date']); ?></span>
                </li>
                <?php } ?>
                <?php if( !empty($property['days_market']) ){  ?>
                <li>
                  <span class="ib-plist-st"><?php echo __('Days on Market', IDXBOOST_DOMAIN_THEME_LANG); ?></span>
                  <span class="ib-plist-pt"><?php echo $property['days_market']; ?></span>
                </li>
                <?php } ?>
              </ul>
            </div>
          </div>
          <?php if(!empty($descriptionEspe)){ ?>
          <div class="ib-description-especial property-description">
            <?php echo $descriptionEspe; ?>
          </div>
          <?php } ?>
          <?php if($property['remark'] != ''){ ?>
          <div class="ib-pdescription property-description" id="property-description">
            <div class="ib-pdescription-title"><?php echo __("Description", IDXBOOST_DOMAIN_THEME_LANG); ?></div>
            <p><?php echo $property['remark']; ?></p>
          </div>
          <?php } ?>

          <?php if (in_array($flex_idx_info["board_id"], ["31"])) { 
          if($property['status'] == "2"){ ?>
          <div class="ib-pdescription-title" style="display: block !important; position: relative; font-size: 14px; padding: 15px 0; margin-bottom: 0;border-bottom: 1px dashed #ccc; color: #858585; font-weight: normal;">Listing provided courtesy of <?php echo $property["office_name"]; ?>  | Sold by:  <?php echo $property["office_name_seller"]; ?> </div>
          <?php }else{ ?>
          <div class="ib-pdescription-title" style="display: block !important; position: relative; font-size: 14px; padding: 15px 0; margin-bottom: 0;border-bottom: 1px dashed #ccc; color: #858585; font-weight: normal;">Listing provided courtesy of <?php echo $property["office_name"]; ?></div>
          <?php } ?>  
          <?php } ?>

          <?php if (in_array($property["rg_id"], ["34"])) {  ?>
          <div class="ib-pdescription-title" style="display: block !important; position: relative; font-size: 14px; padding: 15px 0; margin-bottom: 0;border-bottom: 1px dashed #ccc; color: #858585; font-weight: normal;"><?php echo __("Presented by: ", IDXBOOST_DOMAIN_THEME_LANG).$property["agent_name"]." ".__("of", IDXBOOST_DOMAIN_THEME_LANG)." ".$property["office_name"]; ?>  </div>
          <?php } ?>

          <div class="ib-plist-details">
            <?php if (isset($property['amenities']) && is_array($property['amenities']) && !empty($property['amenities'])): ?>
            <div class="ib-plist-card -amenities">
              <h2 class="ib-plist-card-title"><?php echo __("Amenities", IDXBOOST_DOMAIN_THEME_LANG); ?></h2>
              <ul class="ib-plist-list">
                <?php foreach ($property['amenities'] as $amenity): ?>
                <li><span class="ib-plist-pt"><?php echo $amenity; ?></span></li>
                <?php endforeach;?>
              </ul>
            </div>
            <?php endif;?>
            <div class="ib-plist-card">
              <h2 class="ib-plist-card-title"><?php echo __("Exterior Features", IDXBOOST_DOMAIN_THEME_LANG); ?></h2>
              <ul class="ib-plist-list">
                <li>
                  <span class="ib-plist-st"><?php echo __("Waterfront", IDXBOOST_DOMAIN_THEME_LANG); ?></span>
                  <span class="ib-plist-pt"><?php echo $property['water_front'] == 1 ? 'Yes' : 'No'; ?></span>
                </li>
                <?php if( !empty($property['wv']) ){  ?>
                <li>
                  <span class="ib-plist-st"><?php echo __("WF Description", IDXBOOST_DOMAIN_THEME_LANG); ?></span>
                  <span class="ib-plist-pt"><?php echo $property['wv']; ?></span>
                </li>
                <?php } ?>
                <li>
                  <span class="ib-plist-st"><?php echo __("Pool", IDXBOOST_DOMAIN_THEME_LANG); ?></span>
                  <span class="ib-plist-pt"><?php echo $property['pool'] == 1 ? 'Yes' : 'No'; ?></span>
                </li>
                <?php if (is_array($more_info_property) && array_key_exists("view", $more_info_property) && !empty($more_info_property["view"])) { ?>
                <li>
                  <span class="ib-plist-st"><?php echo __("View", IDXBOOST_DOMAIN_THEME_LANG); ?></span>
                  <span class="ib-plist-pt"><?php echo $more_info_property["view"]; ?></span>
                </li>
                <?php } ?>
                <?php if (is_array($more_info_property) && array_key_exists("construction", $more_info_property) && !empty($more_info_property["construction"])) { ?>
                <li>
                  <span class="ib-plist-st"><?php echo __("Construction Type", IDXBOOST_DOMAIN_THEME_LANG); ?></span>
                  <span class="ib-plist-pt"><?php echo $more_info_property["construction"]; ?></span>
                </li>
                <?php } ?>
                <?php if (is_array($more_info_property) && array_key_exists("architectural_style", $more_info_property) && !empty($more_info_property["architectural_style"])) { ?>
                <li>
                  <span class="ib-plist-st"><?php echo __("Design Description", IDXBOOST_DOMAIN_THEME_LANG); ?></span>
                  <span class="ib-plist-pt"><?php echo $more_info_property["architectural_style"]; ?></span>
                </li>
                <?php } ?>
                <?php if (isset($property['feature_exterior']) && is_array($property['feature_exterior']) && !empty($property['feature_exterior'])){ ?>
                <li>
                  <span class="ib-plist-st"><?php echo __("Exterior Features", IDXBOOST_DOMAIN_THEME_LANG); ?></span>
                  <span class="ib-plist-pt"><?php echo implode(", ",$property['feature_exterior']); ?></span>
                </li>
                <?php } ?>
                <li>
                  <span class="ib-plist-st"><?php echo __("Parking Spaces", IDXBOOST_DOMAIN_THEME_LANG); ?></span>
                  <span class="ib-plist-pt"><?php echo $property["parking"]; ?></span>
                </li>
                <li>
                  <span class="ib-plist-st"><?php echo __("Parking Description", IDXBOOST_DOMAIN_THEME_LANG); ?></span>
                  <span class="ib-plist-pt"><?php echo $property["parking_desc"]; ?></span>
                </li>
                <?php if (is_array($more_info_property) && array_key_exists("roof", $more_info_property) && !empty($more_info_property["roof"])) { ?>
                <li>
                  <span class="ib-plist-st"><?php echo __("Roof Description", IDXBOOST_DOMAIN_THEME_LANG); ?></span>
                  <span class="ib-plist-pt"><?php echo $more_info_property["roof"]; ?></span>
                </li>
                <?php } ?>
                <?php  if (!($property['tw']  == "1" || $property['mf'] == "1" || $property['is_vacant'] == "1")) { ?>
                <?php if (is_array($more_info_property) && array_key_exists("style", $more_info_property) && !empty($more_info_property["style"])) { ?>
                <li>
                  <span class="ib-plist-st"><?php echo __("Style", IDXBOOST_DOMAIN_THEME_LANG); ?></span>
                  <span class="ib-plist-pt"><?php echo $more_info_property["style"]; ?></span>
                </li>
                <?php } ?>
                <?php } ?>
              </ul>
            </div>
            <div class="ib-plist-card">
              <h2 class="ib-plist-card-title"><?php echo __("Interior Features", IDXBOOST_DOMAIN_THEME_LANG); ?></h2>
              <ul class="ib-plist-list">
                <li>
                  <span class="ib-plist-st"><?php echo __("Adjusted Sqft", IDXBOOST_DOMAIN_THEME_LANG); ?></span>
                  <span class="ib-plist-pt"><?php 
                    $inputvalsqft = floatval( str_replace ( ",", "", $property["sqft"] ) );
                    if ($inputvalsqft >= 20000) {
                     $res3 = floatval($inputvalsqft/43560);
                     $res3dec = 0;
                     if(strpos($res3,".") !== false){
                       $res3dec = 2;
                     }
                    
                     echo number_format($res3,$res3dec). " Acre";
                    }else{
                      if (empty($property["sqft"])) {
                        echo "N/A"; 
                      }else{
                        echo number_format($property["sqft"] ); 
                      }                      
                    }
                    ?></span>
                </li>
                <?php if (is_array($more_info_property) && array_key_exists("cooling", $more_info_property) && !empty($more_info_property["cooling"])) { ?>
                <li>
                  <span class="ib-plist-st"><?php echo __("Cooling Description", IDXBOOST_DOMAIN_THEME_LANG); ?></span>
                  <span class="ib-plist-pt"><?php echo $more_info_property["cooling"]; ?></span>
                </li>
                <?php } ?>                                       
                <?php if (is_array($more_info_property) && array_key_exists("appliance", $more_info_property) && !empty($more_info_property["appliance"])) { ?>
                <li>
                  <span class="ib-plist-st"><?php echo __("Equipment Appliances", IDXBOOST_DOMAIN_THEME_LANG); ?></span>
                  <span class="ib-plist-pt"><?php echo $more_info_property["appliance"]; ?></span>
                </li>
                <?php } ?>   
                <?php if (is_array($more_info_property) && array_key_exists("floor_desc", $more_info_property) && !empty($more_info_property["floor_desc"])) { ?>
                <li>
                  <span class="ib-plist-st"><?php echo __("Floor Description", IDXBOOST_DOMAIN_THEME_LANG); ?></span>
                  <span class="ib-plist-pt"><?php echo $more_info_property["floor_desc"]; ?></span>
                </li>
                <?php } ?>
                <?php if (is_array($more_info_property) && array_key_exists("heating", $more_info_property) && !empty($more_info_property["heating"])) { ?>
                <li>
                  <span class="ib-plist-st"><?php echo __("Heating Description", IDXBOOST_DOMAIN_THEME_LANG); ?></span>
                  <span class="ib-plist-pt"><?php echo $more_info_property["heating"]; ?></span>
                </li>
                <?php } ?>
                <?php if (isset($property['feature_interior']) && is_array($property['feature_interior']) && !empty($property['feature_interior'])){ ?>
                <li>
                  <span class="ib-plist-st"><?php echo __("Interior Features", IDXBOOST_DOMAIN_THEME_LANG); ?></span>
                  <span class="ib-plist-pt"><?php echo implode(", ",$property['feature_interior']); ?></span>
                </li>
                <?php } ?>
                <li>
                  <span class="ib-plist-st"><?php echo __("Sqft", IDXBOOST_DOMAIN_THEME_LANG); ?></span>
                  <span class="ib-plist-pt"><?php 
                    $inputsqft2 = floatval( str_replace ( ",", "", $property["sqft"] ) );
                    $hasAcre2 = false;
                    if ($inputsqft2 >= 20000) {
                     $res4 = floatval($inputsqft2/43560);
                     $res4dec = 0;
                    
                     if(strpos($res4,".") !== false){
                       $res4dec = 2;
                     }
                     echo number_format($res4,$res4dec). " Acre";
                     $hasAcre2 = true;
                    }else{
                      if (empty($property["sqft"])) {
                        echo "N/A"; 
                      }else{
                        echo number_format($property["sqft"] ); 
                      }                    
                    }
                    ?></span>
                </li>
              </ul>
            </div>
            <div class="ib-plist-card">
              <h2 class="ib-plist-card-title"><?php echo __("Property Features", IDXBOOST_DOMAIN_THEME_LANG); ?></h2>
              <ul class="ib-plist-list">
                <?php if (is_array($more_info_property) && array_key_exists("addres", $more_info_property) && !empty($more_info_property["addres"])) { ?>
                <li>
                  <span class="ib-plist-st"><?php echo __("Address", IDXBOOST_DOMAIN_THEME_LANG); ?></span>
                  <span class="ib-plist-pt"><?php echo $more_info_property["addres"]; ?></span>
                </li>
                <?php } ?>
                <?php if( !empty($property["lot_size"])){ ?>
                <li>
                  <span class="ib-plist-st"><?php echo __("Aprox. Lot Size", IDXBOOST_DOMAIN_THEME_LANG); ?></span>
                  <span class="ib-plist-pt"><?php echo number_format($property["lot_size"]); ?></span>
                </li>
                <?php } ?>                                                                     
                <?php if (is_array($more_info_property) && array_key_exists("architectural_style", $more_info_property) && !empty($more_info_property["architectural_style"])) { ?>
                <li>
                  <span class="ib-plist-st"><?php echo __("Architectural Style", IDXBOOST_DOMAIN_THEME_LANG); ?></span>
                  <span class="ib-plist-pt"><?php echo $more_info_property["architectural_style"]; ?></span>
                </li>
                <?php } ?>
                <?php if (is_array($more_info_property) && array_key_exists("assoc_fee_paid", $more_info_property) && !empty($more_info_property["assoc_fee_paid"])) { ?>
                <li>
                  <span class="ib-plist-st"><?php echo __("Association Fee Frequency", IDXBOOST_DOMAIN_THEME_LANG); ?></span>
                  <span class="ib-plist-pt"><?php echo $more_info_property["assoc_fee_paid"]; ?></span>
                </li>
                <?php } ?>
                <?php if (is_array($more_info_property) && array_key_exists("attached_garage", $more_info_property) && !empty($more_info_property["attached_garage"])) { ?>
                <li>
                  <span class="ib-plist-st"><?php echo __("Attached Garage", IDXBOOST_DOMAIN_THEME_LANG); ?></span>
                  <span class="ib-plist-pt"><?php echo $more_info_property["attached_garage"]; ?></span>
                </li>
                <?php } ?>
                <?php if (is_array($more_info_property) && array_key_exists("city", $more_info_property) && !empty($more_info_property["city"])) { ?>
                <li>
                  <span class="ib-plist-st"><?php echo __("City", IDXBOOST_DOMAIN_THEME_LANG); ?></span>
                  <span class="ib-plist-pt"><?php echo $more_info_property["city"]; ?></span>
                </li>
                <?php } ?>
                <?php if (is_array($more_info_property) && array_key_exists("community_features", $more_info_property) && !empty($more_info_property["community_features"])) { ?>
                <li>
                  <span class="ib-plist-st"><?php echo __("Community Features", IDXBOOST_DOMAIN_THEME_LANG); ?></span>
                  <span class="ib-plist-pt"><?php echo $more_info_property["community_features"]; ?></span>
                </li>
                <?php } ?>
                <?php if (is_array($more_info_property) && array_key_exists("construction", $more_info_property) && !empty($more_info_property["construction"])) { ?>
                <li>
                  <span class="ib-plist-st"><?php echo __("Construction Materials", IDXBOOST_DOMAIN_THEME_LANG); ?></span>
                  <span class="ib-plist-pt"><?php echo $more_info_property["construction"]; ?></span>
                </li>
                <?php } ?>
                <?php if (is_array($more_info_property) && array_key_exists("county", $more_info_property) && !empty($more_info_property["county"])) { ?>
                <li>
                  <span class="ib-plist-st"><?php echo __("County", IDXBOOST_DOMAIN_THEME_LANG); ?></span>
                  <span class="ib-plist-pt"><?php echo $more_info_property["county"]; ?></span>
                </li>
                <?php } ?>
                <?php if (is_array($more_info_property) && array_key_exists("covered_spaces", $more_info_property) && !empty($more_info_property["covered_spaces"])) { ?>
                <li>
                  <span class="ib-plist-st"><?php echo __("Covered Spaces", IDXBOOST_DOMAIN_THEME_LANG); ?></span>
                  <span class="ib-plist-pt"><?php echo $more_info_property["covered_spaces"]; ?></span>
                </li>
                <?php } ?>
                <?php if (is_array($more_info_property) && array_key_exists("faces", $more_info_property) && !empty($more_info_property["faces"])) { ?>
                <li>
                  <span class="ib-plist-st"><?php echo __("Direction Faces", IDXBOOST_DOMAIN_THEME_LANG); ?></span>
                  <span class="ib-plist-pt"><?php echo $more_info_property["faces"]; ?></span>
                </li>
                <?php } ?>
                <?php if (is_array($more_info_property) && array_key_exists("frontage_lenght", $more_info_property) && !empty($more_info_property["frontage_lenght"])) { ?>
                <li>
                  <span class="ib-plist-st"><?php echo __("FrontageLength", IDXBOOST_DOMAIN_THEME_LANG); ?></span>
                  <span class="ib-plist-pt"><?php echo $more_info_property["frontage_lenght"]; ?></span>
                </li>
                <?php } ?>
                <li>
                  <span class="ib-plist-st"><?php echo __("Furnished Info", IDXBOOST_DOMAIN_THEME_LANG); ?></span>
                  <span class="ib-plist-pt"><?php echo $property["furnished"]; ?></span>
                </li>
                <?php if (is_array($more_info_property) && array_key_exists("garage", $more_info_property) && !empty($more_info_property["garage"])) { ?>
                <li>
                  <span class="ib-plist-st"><?php echo __("Garage", IDXBOOST_DOMAIN_THEME_LANG); ?></span>
                  <span class="ib-plist-pt"><?php echo $more_info_property["garage"]; ?></span>
                </li>
                <?php } ?>
                <?php if (is_array($more_info_property) && array_key_exists("levels", $more_info_property) && !empty($more_info_property["levels"])) { ?>
                <li>
                  <span class="ib-plist-st"><?php echo __("Levels", IDXBOOST_DOMAIN_THEME_LANG); ?></span>
                  <span class="ib-plist-pt"><?php echo $more_info_property["levels"]; ?></span>
                </li>
                <?php } ?>
                <?php if (is_array($more_info_property) && array_key_exists("terms", $more_info_property) && !empty($more_info_property["terms"])) { ?>
                <li>
                  <span class="ib-plist-st"><?php echo __("Listing Terms", IDXBOOST_DOMAIN_THEME_LANG); ?></span>
                  <span class="ib-plist-pt"><?php echo $more_info_property["terms"]; ?></span>
                </li>
                <?php } ?>
                <?php if ( !empty($property["lot_desc"])) { ?>
                <li>
                  <span class="ib-plist-st"><?php echo __("Lot Description", IDXBOOST_DOMAIN_THEME_LANG); ?></span>
                  <span class="ib-plist-pt"><?php echo $property["lot_desc"]; ?></span>
                </li>
                <?php } ?>
                <?php if (is_array($more_info_property) && array_key_exists("lot_features", $more_info_property) && !empty($more_info_property["lot_features"])) { ?>
                <li>
                  <span class="ib-plist-st"><?php echo __("Lot Features", IDXBOOST_DOMAIN_THEME_LANG); ?></span>
                  <span class="ib-plist-pt"><?php echo $more_info_property["lot_features"]; ?></span>
                </li>
                <?php } ?>
                <?php if (is_array($more_info_property) && array_key_exists("ocupant_type", $more_info_property) && !empty($more_info_property["ocupant_type"])) { ?>
                <li>
                  <span class="ib-plist-st"><?php echo __("Occupant Type", IDXBOOST_DOMAIN_THEME_LANG); ?></span>
                  <span class="ib-plist-pt"><?php echo $more_info_property["ocupant_type"]; ?></span>
                </li>
                <?php } ?>
                <?php if (is_array($more_info_property) && array_key_exists("parking_features", $more_info_property) && !empty($more_info_property["parking_features"])) { ?>
                <li>
                  <span class="ib-plist-st"><?php echo __("Parking Features", IDXBOOST_DOMAIN_THEME_LANG); ?></span>
                  <span class="ib-plist-pt"><?php echo $more_info_property["parking_features"]; ?></span>
                </li>
                <?php } ?>
                <?php if (is_array($more_info_property) && array_key_exists("patio_features", $more_info_property) && !empty($more_info_property["patio_features"])) { ?>
                <li>
                  <span class="ib-plist-st"><?php echo __("Patio And Porch Features", IDXBOOST_DOMAIN_THEME_LANG); ?></span>
                  <span class="ib-plist-pt"><?php echo $more_info_property["patio_features"]; ?></span>
                </li>
                <?php } ?>
                <?php if (is_array($more_info_property) && array_key_exists("pets", $more_info_property) && !empty($more_info_property["pets"])) { ?>
                <li>
                  <span class="ib-plist-st"><?php echo __("Pets Allowed", IDXBOOST_DOMAIN_THEME_LANG); ?></span>
                  <span class="ib-plist-pt"><?php echo $more_info_property["pets"]; ?></span>
                </li>
                <?php } ?>
                <?php if (is_array($more_info_property) && array_key_exists("pool_features", $more_info_property) && !empty($more_info_property["pool_features"])) { ?>
                <li>
                  <span class="ib-plist-st"><?php echo __("Pool Features", IDXBOOST_DOMAIN_THEME_LANG); ?></span>
                  <span class="ib-plist-pt"><?php echo $more_info_property["pool_features"]; ?></span>
                </li>
                <?php } ?>
                <?php if (is_array($more_info_property) && array_key_exists("possession", $more_info_property) && !empty($more_info_property["possession"])) { ?>
                <li>
                  <span class="ib-plist-st"><?php echo __("Possession", IDXBOOST_DOMAIN_THEME_LANG); ?></span>
                  <span class="ib-plist-pt"><?php echo $more_info_property["possession"]; ?></span>
                </li>
                <?php } ?>
                <?php if (is_array($more_info_property) && array_key_exists("postal_city", $more_info_property) && !empty($more_info_property["postal_city"])) { ?>
                <li>
                  <span class="ib-plist-st"><?php echo __("Postal City", IDXBOOST_DOMAIN_THEME_LANG); ?></span>
                  <span class="ib-plist-pt"><?php echo $more_info_property["postal_city"]; ?></span>
                </li>
                <?php } ?>
                <?php if (is_array($more_info_property) && array_key_exists("public_section", $more_info_property) && !empty($more_info_property["public_section"])) { ?>
                <li>
                  <span class="ib-plist-st"><?php echo __("Public Survey Section", IDXBOOST_DOMAIN_THEME_LANG); ?></span>
                  <span class="ib-plist-pt"><?php echo $more_info_property["public_section"]; ?></span>
                </li>
                <?php } ?>
                <?php if (is_array($more_info_property) && array_key_exists("public_survey_township", $more_info_property) && !empty($more_info_property["public_survey_township"])) { ?>
                <li>
                  <span class="ib-plist-st"><?php echo __("Public Survey Township", IDXBOOST_DOMAIN_THEME_LANG); ?></span>
                  <span class="ib-plist-pt"><?php echo $more_info_property["public_survey_township"]; ?></span>
                </li>
                <?php } ?>
                <?php if (is_array($more_info_property) && array_key_exists("roof", $more_info_property) && !empty($more_info_property["roof"])) { ?>
                <li>
                  <span class="ib-plist-st"><?php echo __("Roof", IDXBOOST_DOMAIN_THEME_LANG); ?></span>
                  <span class="ib-plist-pt"><?php echo $more_info_property["roof"]; ?></span>
                </li>
                <?php } ?>
                <?php if (is_array($more_info_property) && array_key_exists("senior_community", $more_info_property) && !empty($more_info_property["senior_community"])) { ?>
                <li>
                  <span class="ib-plist-st"><?php echo __("Senior Community", IDXBOOST_DOMAIN_THEME_LANG); ?></span>
                  <span class="ib-plist-pt"><?php echo $more_info_property["senior_community"]; ?></span>
                </li>
                <?php } ?>
                <?php if (is_array($more_info_property) && array_key_exists("sewer", $more_info_property) && !empty($more_info_property["sewer"])) { ?>
                <li>
                  <span class="ib-plist-st"><?php echo __("Sewer Description", IDXBOOST_DOMAIN_THEME_LANG); ?></span>
                  <span class="ib-plist-pt"><?php echo $more_info_property["sewer"]; ?></span>
                </li>
                <?php } ?>
                <li>
                  <span class="ib-plist-st"><?php echo __("Short Sale", IDXBOOST_DOMAIN_THEME_LANG); ?></span>
                  <span class="ib-plist-pt"><?php echo $property["short_sale"]; ?></span>
                </li>
                <?php if (is_array($more_info_property) && array_key_exists("stories", $more_info_property) && !empty($more_info_property["stories"])) { ?>
                <li>
                  <span class="ib-plist-st"><?php echo __("Stories", IDXBOOST_DOMAIN_THEME_LANG); ?></span>
                  <span class="ib-plist-pt"><?php echo $more_info_property["stories"]; ?></span>
                </li>
                <?php } ?>
                <?php if ($property["is_commercial"] == 0){ ?>
                <li>
                  <span class="ib-plist-st"><?php echo __("HOA Fees", IDXBOOST_DOMAIN_THEME_LANG); ?></span>
                  <span class="ib-plist-pt"><?php echo $property["assoc_fee"]; ?></span>
                </li>
                <?php } ?>
                <li>
                  <span class="ib-plist-st"><?php echo __("Subdivision Complex", IDXBOOST_DOMAIN_THEME_LANG); ?></span>
                  <span class="ib-plist-pt"><?php echo $property["complex"]; ?></span>
                </li>
                <li>
                  <span class="ib-plist-st"><?php echo __("Subdivision Info", IDXBOOST_DOMAIN_THEME_LANG); ?></span>
                  <span class="ib-plist-pt"><?php echo $property["subdivision"]; ?></span>
                </li>
                <li>
                  <span class="ib-plist-st"><?php echo __("Tax Amount", IDXBOOST_DOMAIN_THEME_LANG); ?></span>
                  <span class="ib-plist-pt"><?php echo "$".number_format($property["tax_amount"]); ?></span>
                </li>
                <?php if (is_array($more_info_property) && array_key_exists("tax_information", $more_info_property) && !empty($more_info_property["tax_information"])) { ?>
                <li>
                  <span class="ib-plist-st"><?php echo __("Tax Information", IDXBOOST_DOMAIN_THEME_LANG); ?></span>
                  <span class="ib-plist-pt"><?php echo $more_info_property["tax_information"]; ?></span>
                </li>
                <?php } ?>
                <li>
                  <span class="ib-plist-st"><?php echo __("Tax Year", IDXBOOST_DOMAIN_THEME_LANG); ?></span>
                  <span class="ib-plist-pt"><?php echo $property['tax_year']; ?></span>
                </li>
                <?php if (is_array($more_info_property) && array_key_exists("terms", $more_info_property) && !empty($more_info_property["terms"])) { ?>
                <li>
                  <span class="ib-plist-st"><?php echo __("Terms Considered", IDXBOOST_DOMAIN_THEME_LANG); ?></span>
                  <span class="ib-plist-pt"><?php echo $more_info_property["terms"]; ?></span>
                </li>
                <?php } ?>
                <?php if (is_array($more_info_property) && array_key_exists("type_property", $more_info_property) && !empty($more_info_property["type_property"])) { ?>
                <li>
                  <span class="ib-plist-st"><?php echo __("Type of Property", IDXBOOST_DOMAIN_THEME_LANG); ?></span>
                  <span class="ib-plist-pt"><?php echo $more_info_property["type_property"]; ?></span>
                </li>
                <?php } ?>
                <?php if (is_array($more_info_property) && array_key_exists("view", $more_info_property) && !empty($more_info_property["view"])) { ?>
                <li>
                  <span class="ib-plist-st"><?php echo __("View", IDXBOOST_DOMAIN_THEME_LANG); ?></span>
                  <span class="ib-plist-pt"><?php echo $more_info_property["view"]; ?></span>
                </li>
                <?php } ?>
                <?php if (is_array($more_info_property) && array_key_exists("waterfront_frontage", $more_info_property) && !empty($more_info_property["waterfront_frontage"])) { ?>
                <li>
                  <span class="ib-plist-st"><?php echo __("Water Description", IDXBOOST_DOMAIN_THEME_LANG); ?></span>
                  <span class="ib-plist-pt"><?php echo $more_info_property["waterfront_frontage"]; ?></span>
                </li>
                <?php } ?>
                <?php if (is_array($more_info_property) && array_key_exists("water_source", $more_info_property) && !empty($more_info_property["water_source"])) { ?>
                <li>
                  <span class="ib-plist-st"><?php echo __("Water Source", IDXBOOST_DOMAIN_THEME_LANG); ?></span>
                  <span class="ib-plist-pt"><?php echo $more_info_property["water_source"]; ?></span>
                </li>
                <?php } ?>
                <?php if (is_array($more_info_property) && array_key_exists("window_features", $more_info_property) && !empty($more_info_property["window_features"])) { ?>
                <li>
                  <span class="ib-plist-st"><?php echo __("Window Features", IDXBOOST_DOMAIN_THEME_LANG); ?></span>
                  <span class="ib-plist-pt"><?php echo $more_info_property["window_features"]; ?></span>
                </li>
                <?php } ?>
                <?php if (is_array($more_info_property) && array_key_exists("year_built_details", $more_info_property) && !empty($more_info_property["year_built_details"])) { ?>
                <li>
                  <span class="ib-plist-st"><?php echo __("Year Built Details", IDXBOOST_DOMAIN_THEME_LANG); ?></span>
                  <span class="ib-plist-pt"><?php echo $more_info_property["year_built_details"]; ?></span>
                </li>
                <?php } ?>
                <?php if (is_array($more_info_property) && array_key_exists("zoning", $more_info_property) && !empty($more_info_property["zoning"])) { ?>
                <li>
                  <span class="ib-plist-st"><?php echo __("Zoning", IDXBOOST_DOMAIN_THEME_LANG); ?></span>
                  <span class="ib-plist-pt"><?php echo $more_info_property["zoning"]; ?></span>
                </li>
                <?php } ?>
              </ul>
            </div>
          </div>
          <div class="ib-wrapper-top-map list-details clidxboost-exterior-container active ms-loadmap" id="locationMap">
            <div class="ib-pheader">
              <h2 class="ib-ptitle"><?php echo str_replace('# ', '#', $property['address_short']); ?></h2>
              <span class="ib-pstitle"><?php echo $property['address_large']; ?></span>
            </div>
            <div id="ms-wrap-map">
              <div id="googleMap" class="ms-map" data-real-type="mapa" data-img="googleMap" data-lat="<?php echo $property['lat']; ?>" data-lng="<?php echo $property['lng']; ?>"></div>
            </div>
          </div>
          <?php if (!empty($property['related_items'])) : ?>
          <div class="similar-properties">
            <h2 class="title-similar-list"><?php echo __("Similar Properties For", IDXBOOST_DOMAIN_THEME_LANG); ?> <?php echo $property['is_rental'] == 1 ? __("Rent", IDXBOOST_DOMAIN_THEME_LANG) : __("Sale", IDXBOOST_DOMAIN_THEME_LANG); ?></h2>
            <ul>
              <?php foreach ($property['related_items'] as $rel_item) : ?>
              <li>
                <article>
                  <h3 class="ms-title">
                    <?php if (isset($agent_permalink) && !empty($agent_permalink)): ?>
                    <a href="<?php echo $agent_permalink; ?>/property/<?php echo $rel_item['slug']; ?>" title="<?php echo str_replace('# ', '#', $rel_item['address_short']); ?>">
                    <?php echo str_replace('# ', '#', $rel_item['address_short']); ?>
                    </a>
                    <?php else: ?>
                    <a href="<?php echo rtrim($flex_idx_info["pages"]["flex_idx_property_detail"]["guid"], "/"); ?>/<?php echo $rel_item['slug']; ?>" title="<?php echo str_replace('# ', '#', $rel_item['address_short']); ?>">
                    <?php echo str_replace('# ', '#', $rel_item['address_short']); ?>
                    </a>
                    <?php endif; ?>
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
                    <li> <span><?php echo number_format($rel_item['sqft']); ?> </span><?php echo __("Sqft", IDXBOOST_DOMAIN_THEME_LANG); ?>.</li>
                  </ul>
                  <?php if (isset($agent_permalink) && !empty($agent_permalink)): ?>
                  <a class="layout-img" href="<?php echo $agent_permalink; ?>/property/<?php echo $rel_item['slug']; ?>">
                  <img class="lazy-img" data-src="<?php echo $rel_item['gallery'][0]; ?>" alt="<?php echo str_replace('# ' , '#', $rel_item['address_short']); ?>">
                  </a>
                  <?php else: ?>
                  <a class="layout-img" href="<?php echo rtrim($flex_idx_info["pages"]["flex_idx_property_detail"]["guid"], "/"); ?>/<?php echo $rel_item['slug']; ?>">
                  <img class="lazy-img" data-src="<?php echo $rel_item['gallery'][0]; ?>" alt="<?php echo str_replace('# ' , '#', $rel_item['address_short']); ?>">
                  </a>
                  <?php endif; ?>
                </article>
              </li>
              <?php endforeach; ?>
            </ul>
          </div>
          <?php endif; ?>
          <?php if( in_array($flex_idx_info["board_id"], ["13","14"]) ){ ?>
          <div class="ib-idx-info">
            <div class="ms-msg">
              <?php if( array_key_exists('board_info', $property) && array_key_exists("last_check_timestamp", $property['board_info']) && !empty($property['board_info']["last_check_timestamp"])){ ?>
              <span><?php echo __("IDXBoost last checked", IDXBOOST_DOMAIN_THEME_LANG); ?> <?php echo $property['board_info']["last_check_timestamp"];?></span>
              <?php } ?>
              <span><?php echo __("Data was last updated", IDXBOOST_DOMAIN_THEME_LANG); ?> <?php echo $property["last_updated"];?></span>
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
                <?php if( array_key_exists('board_info', $property) && array_key_exists("board_disclaimer", $property['board_info']) && !empty($property['board_info']["board_disclaimer"])){ ?>
                <p>
                  <?php 
                    $disclaimer = str_replace('{officeName}', $property["office_name"], $property['board_info']["board_disclaimer"]);
                    $disclaimer = str_replace('{office_phone}', '<a href="tel:'.$property["phone_office"].'">'.$property["phone_office"].'</a>', $disclaimer); 
                    echo $disclaimer;
                    ?>
                </p>
                <?php }else{ ?>
                <p><?php echo __('The multiple listing information is provided by the', IDXBOOST_DOMAIN_THEME_LANG); ?> <?php echo $property["board_name"]; ?>® <?php echo __('from a copyrighted compilation of listings. The compilation of listings and each individual listing are', IDXBOOST_DOMAIN_THEME_LANG); ?> &copy;<?php echo date('Y'); ?>-<?php echo __('present', IDXBOOST_DOMAIN_THEME_LANG); ?> <?php echo $property["board_name"]; ?>®. <?php echo __("All Rights Reserved. The information provided is for consumers' personal, noncommercial use and may not be used for any purpose other than to identify prospective properties consumers may be interested in purchasing. All properties are subject to prior sale or withdrawal. All information provided is deemed reliable but is not guaranteed accurate, and should be independently verified. Listing courtesy of", IDXBOOST_DOMAIN_THEME_LANG); ?>: <?php echo $property["office_name"]; ?> </p>
                <?php } ?>
                <p><?php echo __('Real Estate IDX Powered by', IDXBOOST_DOMAIN_THEME_LANG); ?>: <a href="https://www.tremgroup.com" title="TREMGROUP" rel="nofollow" target="_blank">TREMGROUP</a></p>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="aside ib-mb-show">
        <div class="ms-form-detail msModalDetail">
          <div class="form-content">
            <div class="avatar-content">
              <div class="content-avatar-image"><img class="lazy-img" data-src="<?php echo $agent_info_photo; ?>" title="<?php echo $agent_info_name; ?>" alt="<?php echo $agent_info_name; ?>"></div>
              <div class="avatar-information">
                <h2><?php echo $agent_info_name; ?></h2>
                <?php if (!empty($agent_info_phone)): ?>
                <a class="phone-avatar" href="tel:<?php echo preg_replace('/[^\d]/', '', $agent_info_phone); ?>" title="Call to <?php echo flex_agent_format_phone_number($agent_info_phone); ?>"><?php echo __('Ph', IDXBOOST_DOMAIN_THEME_LANG);?>. <?php echo $agent_info_phone; ?></a>
                <?php endif; ?>
              </div>
            </div>
            <form method="post" id="flex-idx-property-form" class="gtm_more_info_property iboost-secured-recaptcha-form iboost-form-validation">
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

                <?php if (array_key_exists('google_gtm', $flex_idx_info['agent']) && !empty($flex_idx_info['agent']['google_gtm'])) : ?>
                  <input type="hidden" name="gclid_field" id="gclid_field_form_more_info_property">
                <?php endif; ?>

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
                        <input required class="medium" name="phone" id="_ib_ph_inq" type="tel" value="<?php if (isset($flex_idx_lead['lead_info']['phone_number'])) : ?><?php echo $flex_idx_lead['lead_info']['phone_number']; ?><?php endif; ?>" placeholder="<?php echo __("Phone", IDXBOOST_DOMAIN_THEME_LANG); ?>*">
                      </div>
                    </li>
                    <li class="gfield comments">
                      <div class="ginput_container">
                        <label class="gfield_label" for="ms-message"><?php echo __("Comments", IDXBOOST_DOMAIN_THEME_LANG); ?></label>
                        <textarea class="medium textarea" name="message" id="ms-message" type="text" value="" placeholder="<?php echo __("Comments", IDXBOOST_DOMAIN_THEME_LANG); ?>" rows="10" cols="50"><?php echo __("I am interested in", IDXBOOST_DOMAIN_THEME_LANG); ?> <?php echo str_replace('# ', '#', $property['address_short']); ?> <?php echo $property['address_large']; ?></textarea>
                      </div>
                    </li>
                    <?php if ( ($idxboost_agent_info["show_opt_in_message"]) ) {  ?>
                    <li class="gfield fub">
                      <div class="ms-fub-disclaimer">
                        <p><?php echo __("By submitting this form you agree to be contacted by", IDXBOOST_DOMAIN_THEME_LANG); ?> <?php echo $idxboost_term_condition["company_name"]; ?> <?php echo __('via call, email, and text. To opt out, you can reply "stop" at any time or click the unsubscribe link in the emails. For more information see our', IDXBOOST_DOMAIN_THEME_LANG); ?> <a href="/terms-and-conditions/#follow-up-boss" target="_blank"><?php echo __("Terms and Conditions", IDXBOOST_DOMAIN_THEME_LANG); ?>.</a></p>
                      </div>
                    </li>
                    <?php } ?>
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
        <div class="property-contact">
          <div class="info-content">
            <div class="ib-bdisclaimer">
              <?php if( array_key_exists('board_info', $property) && array_key_exists("board_logo_url", $property['board_info']) && !empty($property['board_info']["board_logo_url"])){ ?>
              <div class="ms-logo-board">
                <img src="<?php echo $property['board_info']["board_logo_url"];?>">
              </div>
              <?php } ?>
              <?php if( array_key_exists('board_info', $property) && array_key_exists("board_disclaimer", $property['board_info']) && !empty($property['board_info']["board_disclaimer"])){ ?>
              <p>
                <?php 
                  $disclaimer = str_replace('{officeName}', $property["office_name"], $property['board_info']["board_disclaimer"]);
                  $disclaimer = str_replace('{office_phone}', '<a href="tel:'.$property["phone_office"].'">'.$property["phone_office"].'</a>', $disclaimer); 
                  echo $disclaimer;
                  ?>
              </p>
              <?php }else{ ?>
              <p>The multiple listing information is provided by the <?php echo $property["board_name"]; ?>® from a copyrighted compilation of listings.
                The compilation of listings and each individual listing are &copy;<?php echo date('Y'); ?>-present <?php echo $property["board_name"]; ?>®.
                All Rights Reserved. The information provided is for consumers' personal, noncommercial use and may not be used for any purpose
                other than to identify prospective properties consumers may be interested in purchasing. All properties are subject to prior sale or withdrawal.
                All information provided is deemed reliable but is not guaranteed accurate, and should be independently verified.
                Listing courtesy of: <?php echo $property["office_name"]; ?>
              </p>
              <?php } ?>
              <p><?php echo __('Real Estate IDX Powered by', IDXBOOST_DOMAIN_THEME_LANG); ?>: <a href="https://www.tremgroup.com" title="TREMGROUP" rel="nofollow" target="_blank">TREMGROUP</a></p>
            </div>
          </div>
        </div>
      </div>
    </div>
    <button class="ib-btn-request ib-active-float-form">
    <?php echo __("Contact Agent", IDXBOOST_DOMAIN_THEME_LANG); ?>
    </button>
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
  
      <?php if( (isset($flex_idx_info['agent']['has_dynamic_remarketing'])) && (true === $flex_idx_info['agent']['has_dynamic_remarketing']) 
        && is_array($property) && array_key_exists('is_sold', $property) && array_key_exists('price_sold', $property)
       ): ?>
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
      
      $(window).load(function() { 
        loadMapLocation(); 
          $("#calculatorYears").text(30+" "+word_translate.years);
          $(".ib-property-mc-ir, #interest_rate_txt").val(__flex_g_settings.interes_rate[30]);

          var pp = $(".ib-price-calculator").attr("data-price");
          var dp = $("#down_payment_txt").val();
          var ty = $("#term_txt").val();
          var ir = $("#interest_rate_txt").val();
          console.log(pp);
          console.log(dp);
          console.log(ty);
          console.log(ir);
  
          var calc_mg = calculate_mortgage(pp, dp, ty, ir);
          console.log(calc_mg);
          $(".ib-price-calculator").text("$" + calc_mg.monthly+"/mo");
  
      });
      $(window).scroll(function() { loadMapLocation(); });
  
    function calculate_mortgage(price, percent, year, interest) {
    price = price.replace(/[^\d]/g, "");
    percent = parseFloat(percent);
    year = year.replace(/[^\d]/g, "");
    interest = parseFloat(interest);
  
    var month_factor = 0;
    var month_term = year * 12;
    var down_payment = price * (percent / 100);
    
    interest = interest / 100;
    
    var month_interest = interest / 12;
    
    var financing_price = price - down_payment;
    var base_rate = 1 + month_interest;
    var denominator = base_rate;
    
    for (var i = 0; i < (year * 12); i++) {
      month_factor += (1 / denominator);
      denominator *= base_rate;
    }
    
    var month_payment = financing_price / month_factor;
    var pmi_per_month = 0;
    
    if (percent < 20) {
      pmi_per_month = 55 * (financing_price / 100000);
    }
    
    var total_monthly = month_payment + pmi_per_month;
    
    return {
      'mortgage': (financing_price),
      'down_payment': (down_payment),
      'monthly': (month_payment).toFixed(2),
      'total_monthly': (total_monthly).toFixed(2)
    };
  }  
  
      $(document).on("click", ".ib-active-float-form", function (e) {
        e.preventDefault();
        $("body").addClass("ms-active-aside-form");
      });
  
      $(document).on("click", ".msCloseModalDetail, .mslayoutModalDetail", function (e) {
        e.preventDefault();
        $("body").removeClass("ms-active-aside-form");
      });
  
      /**********************************/
      jQuery(document).on("click", "#ib-email-to-friend .ib-mmclose", function() {
        jQuery("#ib-email-to-friend").addClass('ib-md-hiding');
        setTimeout(function() {
          jQuery("#ib-email-to-friend").removeClass('ib-md-active ib-md-hiding');
        }, 250);
      });
  
      jQuery(document).on("click", ".-emailtofriendbuilding", function() {
        var mlsNumber = jQuery(this).data("mls");
        //jQuery(".ib-property-share-friend-f:eq(0)").trigger("reset");
        jQuery(".ib-property-share-mls-num:eq(0)").val(mlsNumber);
        jQuery("#ib-email-to-friend").addClass("ib-md-active");
      });
  
      jQuery(".ib-property-share-friend-f").on("submit", function(event) {
          event.preventDefault();
          var _self = jQuery(this);
  
          if (__flex_g_settings.hasOwnProperty("has_enterprise_recaptcha")) { // enterprise recaptcha
              if ("1" == __flex_g_settings.has_enterprise_recaptcha) {
                  // pending...
              } else { // regular recaptcha
  
                  grecaptcha.ready(function() {
                      grecaptcha
                      .execute(__flex_g_settings.google_recaptcha_public_key, { action: 'share_property_with_friend' })
                      .then(function(token) {
                          _self.prepend('<input type="hidden" name="recaptcha_response" value="'+token+'">');
          
                          var formData = _self.serialize();
                          var mlsNumber = _self.find("input[name='mls_number']:eq(0)").val();
                          //var shareWithFriendEndpoint = __flex_idx_filter_regular.shareWithFriendEndpoint.replace(<?php echo $property["mls_num"]; ?>, mlsNumber);
                          var shareWithFriendEndpoint = __flex_idx_filter_regular.shareWithFriendEndpoint.replace(/{{mlsNumber}}/g, mlsNumber);
              
                          jQuery.ajax({
                              type: "POST",
                              url: shareWithFriendEndpoint,
                              data: {
                                  access_token: IB_ACCESS_TOKEN,
                                  flex_credentials: Cookies.get("ib_lead_token"),
                                  form_data: formData
                              },
                              success: function(response) {
                                  // ...
                              }
                          });
              
                          jQuery("#ib-email-to-friend").removeClass("ib-md-active");
                          jQuery("#ib-email-thankyou").addClass("ib-md-active");
                      });
                  });
              }
  
          } else { // regular recaptcha
  
            grecaptcha.ready(function() {
                grecaptcha
                .execute(__flex_g_settings.google_recaptcha_public_key, { action: 'share_property_with_friend' })
                .then(function(token) {
                    _self.prepend('<input type="hidden" name="recaptcha_response" value="'+token+'">');
  
                    var formData = _self.serialize();
                    var mlsNumber = _self.find("input[name='mls_number']:eq(0)").val();
                    //var shareWithFriendEndpoint = __flex_idx_filter_regular.shareWithFriendEndpoint.replace(<?php echo $property["mls_num"]; ?>, mlsNumber);
                    var shareWithFriendEndpoint = __flex_idx_filter_regular.shareWithFriendEndpoint.replace(/{{mlsNumber}}/g, mlsNumber);
        
                    jQuery.ajax({
                        type: "POST",
                        url: shareWithFriendEndpoint,
                        data: {
                            access_token: IB_ACCESS_TOKEN,
                            flex_credentials: Cookies.get("ib_lead_token"),
                            form_data: formData
                        },
                        success: function(response) {
                        }
                    });
        
                    jQuery("#ib-email-to-friend").removeClass("ib-md-active");
                    jQuery("#ib-email-thankyou").addClass("ib-md-active");
                });
            });
  
          }
      });
  
      jQuery(document).on("click", "#ib-email-thankyou .ib-mmclose", function() {
        jQuery("#ib-email-thankyou").addClass('ib-md-hiding');
        setTimeout(function() {
          jQuery("#ib-email-thankyou").removeClass('ib-md-active ib-md-hiding');
        }, 250);
      });
    });

  })(jQuery);
</script>
