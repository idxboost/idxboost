<style>
  .ms-wrapper-btn-new-share.active ul {
    z-index: 5;
  }

  #full-main .main-content .property-description {
    margin-bottom: 20px;
  }

  @media screen and (min-width: 768px){
    #full-main .container .property-information li.ms-share-hidden{
      display: none
    }
  }

  .ip-hackbox-btn { z-index: 2 !important;}

</style>
<?php
  global $flex_idx_info, $post, $flex_social_networks, $wp;

  $log_building_name = isset($response["payload"]["name_building"]) ? $response["payload"]["name_building"] : "";
  $log_building_address = isset($response["payload"]["address_building"]) ? unserialize($response["payload"]["address_building"])[0] : "";
  $log_building_city = isset($response["payload"]["city_building_name"]) ? $response["payload"]["city_building_name"] : "";

  $idxboost_term_condition = get_option('idxboost_term_condition');
  $idxboost_agent_info = get_option('idxboost_agent_info');

  $disclaimer_checked = $flex_idx_info['agent']['disclaimer_checked'];
  if($disclaimer_checked == "1"){
    $checked = "checked"; 
  }else{
    $checked = ""; 
  }

  $idx_v = isset($response["payload"]["idx_v"]) ? $response["payload"]["idx_v"] : "0";

  $cta = [];
  if ( is_array($response) && array_key_exists("payload",$response) && is_array($response["payload"]) && array_key_exists("cta",$response["payload"]) ) {
    $cta =  @json_decode($response['payload']["cta"],true);
  }
  
  $wp_request = $wp->request;
  $wp_request_exp = explode('/', $wp_request);
  
  $building_slug = implode('/', array($wp_request_exp[0], $wp_request_exp[1]));
  
  $site_title = get_bloginfo('name');
  
  $building_permalink = get_permalink($post->ID);
  
  $amenities_build =json_decode($response['payload']['amenities_building'],true);
  
  $building_addresses = unserialize($response['payload']['address_building']);
  
  $type_building = $response['payload']['type_building'];
  
  if (!empty($building_addresses)) {
    list($building_default_address) = $building_addresses;
  } else {
    $building_default_address = '';
  }
  
  $twitter_share_url_params = http_build_query(array(
      'text' => $post->post_title . ' - ' . $building_default_address,
      'url'  => $building_permalink,
  ));
  
  $twitter_share_url = 'https://twitter.com/intent/tweet?' . $twitter_share_url_params;
  
  $agent_info_name = $flex_idx_info['agent']['agent_first_name'];
  $agent_last_name = $flex_idx_info['agent']['agent_last_name'];
  $agent_info_phone = $flex_idx_info['agent']['agent_contact_phone_number'];
  
  $logo_broker='';
  
  if (array_key_exists('logo_broker', $response))  $logo_broker=$response['logo_broker'];

  if (array_key_exists('payload', $response)) { 
    if (array_key_exists('property_display_sold', $response['payload'])) { 
      $property_display_sold=$response['payload']['property_display_sold'];
      if ($property_display_sold=='list') 
      $response['payload']['modo_view']=2;  
      else
      $response['payload']['modo_view']=1;
    }
  }


  if (array_key_exists('payload', $response)) { 
    if (array_key_exists('property_display_sold', $response['payload'])) { 
        $property_display_sold=$response['payload']['property_display_sold'];
          if ($property_display_sold=='list')
            $response['payload']['modo_view']=2;  
          else
            $response['payload']['modo_view']=1;
    }
  }
  

  if (array_key_exists('payload', $response)) { 
    if (array_key_exists('property_display_active', $response['payload'])) { 
        $property_display_active=$response['payload']['property_display_active'];
          if ($property_display_active=='list') 
            $response['payload']['modo_view']=2;  
          else
            $response['payload']['modo_view']=1;
    }
  }  
  ?>

<?php if ($response['success']=== false ): ?>
<div class="gwr" style="margin: 20px 0">
  <div class="message-alert idx_color_primary flex-not-logged-in-msg" id="box_flex_alerts_msg">
    <p><?php echo __("The building you requested is not available.", IDXBOOST_DOMAIN_THEME_LANG); ?></p>
  </div>
</div>
<?php else: ?>
<?php
  $idx_social_mediamaps  = '';
  if (!empty( $flex_idx_info["agent"]["google_maps_api_key"] ))
      $idx_social_mediamaps  = $flex_idx_info["agent"]["google_maps_api_key"];
  
  if ((empty($response['payload']['lat_building'])) && (empty($response['payload']['lng_building']))){
    $chlatlong = curl_init();
    curl_setopt($chlatlong, CURLOPT_URL, 'https://maps.googleapis.com/maps/api/geocode/json?address='.urlencode($building_default_address).'&key='.$idx_social_mediamaps);
    curl_setopt($chlatlong, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($chlatlong, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($chlatlong, CURLOPT_FRESH_CONNECT, true);
    curl_setopt($chlatlong, CURLOPT_VERBOSE, true);
    $outputlatlong = curl_exec($chlatlong);
    curl_close($chlatlong);
  
    $outtemporali=json_decode($outputlatlong,true);
    if ($outtemporali['status']=='OK') {
       foreach ($outtemporali['results'] as $keygeom => $valuegeome) {
         $latAlternative=$valuegeome['geometry']['location']['lat'];
         $lngAlternative=$valuegeome['geometry']['location']['lng'];
       }
    }
  }


if (!empty($latAlternative) && !empty($lngAlternative)) {
  $response['payload']['lat_building'] = $latAlternative;
  $response['payload']['lng_building'] = $lngAlternative;
}
?>

<!-- <link rel="stylesheet" href="<?php include FLEX_IDX_PATH . '/css/floorplan.min.css';  ?>"> -->

<main class="property-details theme-3">
  <div id="full-main" class="ms-property-detail-page ms-wrapper-actions-fs">
    <section class="title-conteiner gwr animated fixed-box">
      <div class="content-fixed">
        <div class="content-fixed-title">
          <h1 class="title-page ms-property-title" 
            id="page_title" 
            data-building-name="<?php echo $log_building_name; ?>" 
            data-building-address="<?php echo $log_building_address; ?>" 
            data-building-city="<?php echo $log_building_city; ?>" 
            data-title="<?php echo $response['payload']['name_building']; ?>">
            <?php echo $response['payload']['name_building']; ?>
            <span><?php echo $building_default_address; ?></span>
          </h1>
          <input type="hidden" class="idx_name_building" value="<?php echo $response['payload']['name_building']; ?>">

          <div class="breadcrumb-options">
            <div class="ms-property-search">
              <div class="ms-wrapper-btn-new-share">
                <div class="ms-wrapper">
                  <button class="ms-share-btn"><?php echo __("Share", IDXBOOST_DOMAIN_THEME_LANG); ?></button>
                  <ul class="ms-share-list">
                    <li class="ib-pscitem ib-psemailfriend -emailtofriendbuilding" data-permalink="" data-mls="{{mls_num}}" data-status="{{status_type}}">
                      <a rel="nofollow" href="javascript:void(0)" 
                        class="ib-psbtn showfriendEmail" 
                        data-modal="modal_email_to_friend" 
                        data-origin="2"
                        data-media="ib-pva-map"
                        data-property="<?php echo $response['payload']['name_building']; ?>"
                        data-beds="<?php echo $response['payload']['bed_building']; ?>"
                        data-year="<?php echo $response['payload']['year_building']; ?>"
                        data-city="<?php echo $response['payload']['city_building_name']; ?>"
                        data-address="<?php echo $building_default_address; ?>"
                        data-lg="<?php echo $response['payload']['lng_building']; ?>" 
                        data-lt="<?php echo $response['payload']['lat_building']; ?>">
                      <?php echo __("Email to a friend", IDXBOOST_DOMAIN_THEME_LANG); ?>
                      </a>
                    </li>
                    <li><a href="#" class="ib-pllink -clipboard"><?php echo __("Copy Link", IDXBOOST_DOMAIN_THEME_LANG); ?> <span class="-copied"><?php echo __("copied", IDXBOOST_DOMAIN_THEME_LANG); ?></span></a></li>
                    <li>
                      <a class="ib-plsitem ib-plsifb" 
                        data-share-url="<?php echo $building_permalink; ?>" 
                        data-share-title="<?php echo $post->post_title; ?>" 
                        data-share-description="<?php echo $post->post_title . ' - ' . $building_default_address; ?>" 
                        data-share-image="<?php echo str_replace("https://idxboost.com","https://www.idxboost.com", $response['payload']['gallery_building'][0]["url_image"]); ?>" 
                        onclick="idxsharefb_building()" rel="nofollow">Facebook</a>
                    </li>
                    <li><a class="ib-plsitem ib-plsitw" onclick="window.open('<?php echo $twitter_share_url; ?>','s_tw','width=600,height=400'); return false;" rel="nofollow">Twitter</a></li>
                  </ul>
                </div>
              </div>
            </div>
            <div class="ms-property-call-action">
              <button class="btn-request" id="form-request-a"><?php echo __("INQUIRE", IDXBOOST_DOMAIN_THEME_LANG); ?></button>
            </div>
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
      <img src="<?php echo $logo_broker; ?>" alt="<?php echo $property['address_short']; ?> <?php echo $property['address_large']; ?>">
      <ul>
        <li><?php echo __('Call me', IDXBOOST_DOMAIN_THEME_LANG); ?>: <?php echo flex_phone_number_filter($flex_idx_info['agent']['agent_contact_phone_number']); ?></li>
        <li><?php echo $flex_idx_info['agent']['agent_contact_email_address'] ?></li>
      </ul>
    </div>
    <div id="imagen-print"></div>
    <div id="full-slider" class="show-slider-psl js-gallery-building">

      <!-- VISTA BUILDING IMAGES -->
      <?php
        if( is_array($response['payload']) && array_key_exists("type_gallery", $response['payload']) && !empty($response['payload']["type_gallery"]) ) {
          if ($response['payload']["type_gallery"]== "2") {
            if (count($response['payload']['gallery_building']) > 0) { ?>
            <div class="gs-container-slider clidxboost-full-slider">
              <?php foreach ($response['payload']['gallery_building'] as $key => $value) { ?>
              <img data-lazy="<?php echo $value['url_image']; ?>" alt="<?php echo $value['name_image']; ?>" class="img-slider gs-lazy">
              <?php } ?>
            </div>
            <?php }}elseif ($response['payload']["type_gallery"]=="1") { ?>
            <!-- NUEVA ESTRUCTURA SLIDER -->
            <div class="ms-slider-buildings">
              <div class="wrap-result view-grid ms-sm-grid">
                <div class="ib-filter-slider-building" data-filter="building" id="buildingSlider">
                  <div class="wrap-result view-grid">
                    <div class="gs-container-slider ib-properties-slider"></div>
                  </div>
                </div>
              </div>
            </div>
            <!-- NUEVA ESTRUCTURA SLIDER -->
      <?php }} ?>

      <!-- VISTA MAPA -->
      <div id="map-view">
        <div id="map-result" data-lat="<?php echo $response['payload']['lat_building']; ?>" data-lng="<?php echo $response['payload']['lng_building']; ?>"></div>
      </div>

      <!-- VISTA VIDEO -->
      <div id="video-view">
        <div class="ms-wrapper-video-cover">
          <div class="ms-header-video">
            <button 
            class="ms-video-play js-open-full-screen" 
            aria-label="Play Video" 
            data-type="video" 
            data-video="<?php echo $response['payload']['media_gallery_video_url']; ?>" 
            data-title="<?php echo $response['payload']['media_gallery_video_title']; ?>"></button>
            <h5 class="ms-video-title"><?php echo $response['payload']['media_gallery_video_title']; ?></h5>
          </div>
          <!--video de fondo-->
          <div class="ms-video-cover" id="js-temporal-video"></div>
          <button class="ms-close js-close-temp-video-view" aria-label="Close View Video"></button>
        </div>
      </div>

      <!-- OPCIONES -->
      <div class="moptions">
        <ul class="slider-option">
          <li>
            <button class="option-switch js-option-building js-option-building-photo ms-gallery-fs" id="show-gallery" data-view="gallery"><?php echo __('photos', IDXBOOST_DOMAIN_THEME_LANG); ?></button>
          </li>
          <?php if ((!empty($response['payload']['lat_building'])) && (!empty($response['payload']['lng_building']))) : ?>
          <li>
            <button class="option-switch js-option-building js-option-building-map ms-map-fs" id="show-map" data-view="map" data-lat="<?php echo $response['payload']['lat_building']; ?>" data-lng="<?php echo $response['payload']['lng_building']; ?>"><?php echo __('map view', IDXBOOST_DOMAIN_THEME_LANG); ?></button>
          </li>
          <?php else : ?>
            <?php if (!empty($latAlternative) && !empty($lngAlternative)) {
            $response['payload']['lat_building'] = $latAlternative;
            $response['payload']['lng_building'] = $lngAlternative; ?>
            <li>
              <button class="option-switch js-option-building js-option-building-map ms-map-fs" id="show-map" data-view="map" data-lat="<?php echo $latAlternative; ?>" data-lng="<?php echo $lngAlternative; ?>"><?php echo __('map view', IDXBOOST_DOMAIN_THEME_LANG); ?></button>
            </li>
            <?php } ?>
          <?php endif; ?>
          <?php if ((!empty($response['payload']['media_gallery_video_url']))) : ?>
          <li>
            <button 
              class="option-switch js-show-video-cover-bl ms-video-fs" 
              data-type="video" 
              id="show-video" 
              data-view="video"
              data-video="<?php echo $response['payload']['media_gallery_video_url']; ?>"
              data-title="<?php echo $response['payload']['media_gallery_video_title']; ?>"
              data-autoplay="<?php echo $response['payload']['media_gallery_video_auto_play']; ?>"
              data-gallery-type="<?php echo $response['payload']['media_gallery_type']; ?>"
              data-parent="#js-temporal-video">
            <?php echo __('video', IDXBOOST_DOMAIN_THEME_LANG); ?></button>
          </li>
          <?php endif; ?>
        </ul>
        <div id="min-map" data-map-img="https://maps.googleapis.com/maps/api/staticmap?center=<?php echo $response['payload']['lat_building']; ?>,<?php echo $response['payload']['lng_building']; ?>&amp;zoom=14&amp;size=163x87&amp;maptype=roadmap&amp;scale=false&amp;format=png&amp;key=<?php echo $idx_social_mediamaps; ?>&amp;visual_refresh=true&amp;markers=size:mid%7Ccolor:0x0684c8%7Clabel:%7C<?php echo $response['payload']['lat_building']; ?>,<?php echo $response['payload']['lng_building']; ?>"></div>
        <button id="clidxboost-btn-flight" class="full-screen js-open-full-screen" data-type="photo" data-initial="1" data-gallery=".clidxboost-full-slider">Full screen</button>
      </div>
    </div>



      <section class="main">
        <div class="temporal-content-bl"></div>
        <div class="gwr">
          <div class="container">
            <div class="property-details theme-2 r-hidden">

              <ul class="property-information">
                <?php if ($type_building == 0) { ?>
                  <li class="price">
                    $0 <?php echo __('to', IDXBOOST_DOMAIN_THEME_LANG); ?> $0
                    <span> <?php echo __("Today's Prices", IDXBOOST_DOMAIN_THEME_LANG); ?></span>
                  </li>
                <?php } else { ?>
                  <li class="price"><?php echo $response['payload']['price_building']; ?><span><?php echo __("Today's Prices", IDXBOOST_DOMAIN_THEME_LANG); ?></span></li>
                <?php } ?>

                <li class="sale"><button id="sale-count-uni-cons" class="fbc-group active-fbc sale-count-uni-cons">0 <span><?php echo __("For Sale", IDXBOOST_DOMAIN_THEME_LANG); ?></span></button></li>
                <li class="rent"><button id="rent-count-uni-cons" class="fbc-group rent-count-uni-cons">0 <span><?php echo __("For Rent", IDXBOOST_DOMAIN_THEME_LANG); ?></span></button></li>
                <li class="pending"><button id="pending-count-uni-cons" class="fbc-group pending-count-uni-cons">0 <span><?php echo __("Pending", IDXBOOST_DOMAIN_THEME_LANG); ?></span></button></li>
                <li class="sold"><button id="sold-count-uni-cons" class="fbc-group sold-count-uni-cons">0 <span><?php echo __("Sold", IDXBOOST_DOMAIN_THEME_LANG); ?></span></button></li>

                <li class="btn-save favorite">
                  <?php if ($response['payload']['is_favorite'] == 1) : ?>
                    <a href="javascript:void(0)" data-permalink="<?php echo $building_permalink; ?>" data-building-id="<?php echo $response['payload']['cod_building']; ?>" class="flex_b_mark_f flex_b_marked chk_save"><span class="active"><?php echo __("Remove", IDXBOOST_DOMAIN_THEME_LANG); ?></span></a>
                  <?php else : ?>
                    <a href="javascript:void(0)" data-permalink="<?php echo $building_permalink; ?>" data-building-id="<?php echo $response['payload']['cod_building']; ?>" class="flex_b_mark_f chk_save"><span><?php echo __("Save", IDXBOOST_DOMAIN_THEME_LANG); ?></span></a>
                  <?php endif; ?>
                </li>

                <li class="ms-share-hidden">
                  <div class="ms-wrapper-btn-new-share">
                    <div class="ms-wrapper">
                      <button class="ms-share-btn"><?php echo __("Share", IDXBOOST_DOMAIN_THEME_LANG); ?></button>
                      <ul class="ms-share-list">
                        <li class="ib-pscitem ib-psemailfriend -emailtofriendbuilding" data-permalink="" data-mls="<?php echo $property["mls_num"]; ?>" data-status="">
                          <a rel="nofollow" href="javascript:void(0)" 
                          class="ib-psbtn showfriendEmail" 
                          data-modal="modal_email_to_friend" 
                          data-origin="2"
                          data-media="ib-pva-map"
                          data-property="<?php echo $response['payload']['name_building']; ?>"
                          data-beds="<?php echo $response['payload']['bed_building']; ?>"
                          data-year="<?php echo $response['payload']['year_building']; ?>"
                          data-city="<?php echo $response['payload']['city_building_name']; ?>"
                          data-address="<?php echo $building_default_address; ?>"
                          data-lg="<?php echo $response['payload']['lng_building']; ?>" 
                          data-lt="<?php echo $response['payload']['lat_building']; ?>">
                            <?php echo __("Email to a friend", IDXBOOST_DOMAIN_THEME_LANG); ?>
                          </a>
                        </li>
                        <li><a href="#" class="ib-pllink -clipboard"><?php echo __("Copy Link", IDXBOOST_DOMAIN_THEME_LANG); ?><span class="-copied"><?php echo __("copied", IDXBOOST_DOMAIN_THEME_LANG); ?></span></a></li>
                        <li>
                          <a class="ib-plsitem ib-plsifb" 
                          data-share-url="<?php echo $building_permalink; ?>" 
                          data-share-title="<?php echo $post->post_title; ?>" 
                          data-share-description="<?php echo $post->post_title . ' - ' . $building_default_address; ?>" 
                          data-share-image="<?php echo str_replace("https://idxboost.com","https://www.idxboost.com", $response['payload']['gallery_building'][0]["url_image"]); ?>" 
                          onclick="idxsharefb_building()" rel="nofollow">Facebook</a></li>                        
                        <li><a class="ib-plsitem ib-plsitw" onclick="window.open('<?php echo $twitter_share_url; ?>','s_tw','width=600,height=400'); return false;" rel="nofollow">Twitter</a></li>
                      </ul>
                    </div>
                  </div>
                </li>
              </ul>
            </div>

            <?php 
            if ( wp_is_mobile() ) {
            if (
                array_key_exists('payload', $response) && 
                array_key_exists('hackbox', $response['payload']) && 
                is_array($response['payload']['hackbox']) && 
                array_key_exists('status', $response['payload']['hackbox'] ) 
                && $response['payload']['hackbox']['status'] != false
              ) { ?>

              <div class="ib-wrap-hackbox-building">
                <?php 
                echo $response['payload']['hackbox']['result']['content']; ?>
              </div>
            <?php }} ?>

          <div class="panel-options" style="padding: 0">
            <div class="options-list">
              
                <!--
              <div class="shared-content" style="display: none">
                <button id="show-shared"><?php echo __("share", IDXBOOST_DOMAIN_THEME_LANG); ?></button>
                <ul class="shared-list">
                  <li><a
                    data-share-url="<?php echo $building_permalink; ?>"
                    data-share-title="<?php echo $post->post_title; ?>"
                    data-share-description="<?php echo $post->post_title . ' - ' . $building_default_address; ?>"
                    data-share-image="<?php echo str_replace("https://idxboost.com","https://www.idxboost.com", $response['payload']['gallery_building'][0]["url_image"]); ?>"
                    class="ico-facebook property-detail-share-fb"
                    onclick="idxsharefb_building()"
                    title="Facebook"
                    rel="nofollow"><?php echo __("Facebook", IDXBOOST_DOMAIN_THEME_LANG); ?></a></li>
                  <li><a class="ico-twitter" href="#" onclick="window.open('<?php echo $twitter_share_url; ?>','s_tw','width=600,height=400'); return false;" title="Twitter" rel="nofollow"><?php echo __("Twitter", IDXBOOST_DOMAIN_THEME_LANG); ?></a></li>
                </ul>
              </div>
              <ul class="action-list" style="display: none">
                <li class="ib-pscitem -emailtofriendbuilding" data-permalink="" data-mls="{{mls_num}}" data-status="{{status_type}}">
                  <a rel="nofollow" href="javascript:void(0)" 
                  class="ib-psbtn showfriendEmail ico-envelope" 
                  data-modal="modal_email_to_friend" 
                  data-origin="2"
                  data-media="ib-pva-map"
                  data-property="<?php echo $response['payload']['name_building']; ?>"
                  data-beds="<?php echo $response['payload']['bed_building']; ?>"
                  data-year="<?php echo $response['payload']['year_building']; ?>"
                  data-city="<?php echo $response['payload']['city_building_name']; ?>"
                  data-address="<?php echo $building_default_address; ?>"
                  data-lg="<?php echo $response['payload']['lng_building']; ?>" 
                  data-lt="<?php echo $response['payload']['lat_building']; ?>">
                    <?php echo __("Email to a friend", IDXBOOST_DOMAIN_THEME_LANG); ?>
                  </a>
                </li>

                <li><a class="ico-printer" href="javascript:void(0)" title="<?php echo __('print', IDXBOOST_DOMAIN_THEME_LANG); ?>" rel="nofollow" id="print-btn"><?php echo __('print', IDXBOOST_DOMAIN_THEME_LANG); ?></a></li>
              </ul>
              <ul class="property-information" style="position: relative; top: 0; transform: none; margin-right: 0; margin-left: auto; margin-bottom: -15px;">
                <li class="btn-save favorite">
                  <?php if ($response['payload']['is_favorite'] == 1): ?>
                  <a href="javascript:void(0)" data-permalink="<?php echo $building_permalink; ?>" data-building-id="<?php echo $response['payload']['cod_building']; ?>" class="flex_b_mark_f flex_b_marked chk_save"><span class="active"><?php echo __('Remove', IDXBOOST_DOMAIN_THEME_LANG); ?></span></a>
                  <?php else: ?>
                  <a href="javascript:void(0)" data-permalink="<?php echo $building_permalink; ?>" data-building-id="<?php echo $response['payload']['cod_building']; ?>" class="flex_b_mark_f chk_save"><span><?php echo __('Save', IDXBOOST_DOMAIN_THEME_LANG); ?></span></a>
                  <?php endif; ?>
                </li>
              </ul>
                  -->

            </div>


          </div>


          <div class="main-content">
            <?php  if (is_array($cta) && count($cta) > 0  && array_key_exists("activeCTAs", $cta) && $cta["activeCTAs"] ) { 
              
              $format_cta = "";
              if ( !empty($cta["format"]) ) {
                $format_cta  = $cta["format"];
              }

              $columns_cta = "ip-columns-3";
              if ( !empty($cta["columns"]) ) {
                $columns_cta  = $cta["columns"];
              }

              ?>

              <div class="ib-cta-wrapper <?php echo $columns_cta; ?> <?php echo $format_cta; ?>" style="

              ">
                <?php
                  if ( array_key_exists("items", $cta) && is_array($cta["items"]) && count($cta["items"])> 0 ) {  
                  foreach ($cta["items"] as $keycta => $itemcta) { ?>
                    <div class="ib-cta-item <?php echo $itemcta["cssClass"] ?? ""; ?>" 
                    style="
                    <?php if( array_key_exists("background", $itemcta["button"]["style"])) { ?>
                      --ip-button-background-color: <?php echo $itemcta["button"]["style"]["background"]; ?>;
                    <?php } ?>
                    <?php if( array_key_exists("border", $itemcta["button"]["style"])) { ?>
                      --ip-button-border-color: <?php echo $itemcta["button"]["style"]["border"]; ?>;
                    <?php } ?>
                    <?php if( array_key_exists("color", $itemcta["button"]["style"])) { ?>
                      --ip-button-text-color: <?php echo $itemcta["button"]["style"]["color"]; ?>;
                    <?php } ?>
                    <?php if( array_key_exists("hoverBackground", $itemcta["button"]["style"])) { ?>
                      --ip-button-background-color-hover: <?php echo $itemcta["button"]["style"]["hoverBackground"]; ?>;
                    <?php } ?>
                    <?php if( array_key_exists("hoverBorder", $itemcta["button"]["style"])) { ?>
                      --ip-button-border-color-hover: <?php echo $itemcta["button"]["style"]["hoverBorder"]; ?>;
                    <?php } ?>
                    <?php if( array_key_exists("borderRadius", $itemcta["button"]["style"])) { ?>
                      --ip-button-border-radius: <?php echo $itemcta["button"]["style"]["borderRadius"]; ?>;
                    <?php } ?>
                    <?php if( array_key_exists("hoverColor", $itemcta["button"]["style"])) { ?>
                      --ip-button-text-color-hover: <?php echo $itemcta["button"]["style"]["hoverColor"]; ?>;
                    <?php } ?>
                    <?php if( array_key_exists("background", $itemcta["containerStyles"]["container"])) { ?>
                      --ib-cta-background-color: <?php echo $itemcta["containerStyles"]["container"]["background"]; ?>;
                    <?php } ?>
                    <?php if( array_key_exists("background", $itemcta["containerStyles"]["icon"])) { ?>
                      --ip-icon-background-color: <?php echo $itemcta["containerStyles"]["icon"]["background"]; ?>;
                    <?php } ?>
                    <?php if( array_key_exists("hoverBackground", $itemcta["containerStyles"]["icon"])) { ?>
                      --ip-icon-hover-background-color: <?php echo $itemcta["containerStyles"]["icon"]["hoverBackground"]; ?>;
                    <?php } ?>
                    <?php if( array_key_exists("borderRadius", $itemcta["containerStyles"]["container"])) { ?>
                      --ip-cta-border-radius: <?php echo $itemcta["containerStyles"]["container"]["borderRadius"]; ?>;
                    <?php } ?>
                    <?php if( array_key_exists("borderColor", $itemcta["containerStyles"]["container"])) { ?>
                      --ip-cta-border-color: <?php echo $itemcta["containerStyles"]["container"]["borderColor"]; ?>;
                    <?php } ?>
                    <?php if( array_key_exists("color", $itemcta["title"])) { ?>
                      --ip-cta-title-color: <?php echo $itemcta["title"]["color"]; ?>;
                    <?php } ?>
                    <?php if( array_key_exists("color", $itemcta["subtitle"])) { ?>
                      --ip-cta-text-color: <?php echo $itemcta["subtitle"]["color"]; ?>;
                    <?php } ?>
                    ">
                        <div class="ib-cta-background">
                            <img src="<?php echo $itemcta["imageIcon"]["path"]; ?>" alt="<?php echo $itemcta["imageIcon"]["name"]; ?>" />
                        </div>
                        <div class="ib-cta-content">
                            <header class="ip-title heading-3xs"><?php echo $itemcta["title"]["text"]; ?></header>
                            <p class="ip-text body-sm"><?php echo $itemcta["subtitle"]["text"]; ?></p>

                            <?php  if (array_key_exists("file", $itemcta) && is_array($itemcta["file"]) && array_key_exists("path", $itemcta["file"]) && !empty($itemcta["file"]["path"]) ) { ?>
                              <div class="ip-wrap-btn">
                                  <button  class="ip-button js-cta-download" type="button" id="button-modal-handler" id_file="<?php echo $keycta;?>"><span><?php echo $itemcta["button"]["text"]; ?></span></button>
                                  <?php  if (array_key_exists("file", $itemcta) && is_array($itemcta["file"]) && array_key_exists("path", $itemcta["file"]) && !empty($itemcta["file"]["path"]) ) { ?>
                                    <a class="js-download-cta-file js-download-<?php echo $keycta; ?>" href="<?php echo $itemcta['file']['path'];  ?>" style="display: none;"  target="_blank" download="" rel="nofollow">download</a>
                                  <?php } ?>
                              </div>
                            <?php } ?>
                        </div>
                    </div>                    
                <?php  } ?>
                <?php } ?>
              </div>
            <?php } ?>

            <?php if(!empty($response['payload']['description_building'])){  ?>
            <div class="ms-wrap-property-description">
              <div class="property-description" id="property-description">
                <p><?php echo $response['payload']['description_building']; ?></p>
              </div>
              <button class="ms-btn" data-before="<?php echo __('Read More', IDXBOOST_DOMAIN_THEME_LANG); ?>" data-after="<?php echo __('Read less', IDXBOOST_DOMAIN_THEME_LANG); ?>" id="ms-read"><?php echo __('Read More', IDXBOOST_DOMAIN_THEME_LANG); ?></button>
            </div>
            <?php } ?>


            <div class="list-details r-hidden">
              <ul class="list-detail">
                <?php  if( !empty($response['payload']['bed_building']) ) { ?>
                  <li class="item-list"> <span><?php echo __('Bedrooms', IDXBOOST_DOMAIN_THEME_LANG); ?></span><span><?php echo $response['payload']['bed_building']; ?></span></li>
                <?php   } ?>
                
                <?php  if( !empty($response['payload']['year_building']) ) { ?>
                  <li class="item-list"> <span><?php echo __('Year Built', IDXBOOST_DOMAIN_THEME_LANG); ?></span><span><?php echo $response['payload']['year_building']; ?></span></li>
                <?php   } ?>
                
                <?php  if( !empty($response['payload']['unit_building']) ) { ?>
                  <li class="item-list"> <span><?php echo __('Units', IDXBOOST_DOMAIN_THEME_LANG); ?></span><span><?php echo $response['payload']['unit_building']; ?></span></li>
                <?php   } ?>

                <?php  if( !empty($response['payload']['floor_building']) ) { ?>
                    <li class="item-list"> <span><?php echo __('Stories', IDXBOOST_DOMAIN_THEME_LANG); ?></span><span><?php echo $response['payload']['floor_building']; ?></span></li>
                <?php   } ?>

                <?php if($type_building==0){ ?>
                <li class="item-list"> <span><?php echo __('Average Price SqFt', IDXBOOST_DOMAIN_THEME_LANG); ?></span><span class="ib_inventory_avg_price">$0</span></li>
                <li class="item-list"> <span><?php echo __('Average Days on Market', IDXBOOST_DOMAIN_THEME_LANG); ?></span><span class="ib_inventory_days_market">0</span></li>
                <?php } ?>
                <li class="item-list"> <span><?php echo __('City', IDXBOOST_DOMAIN_THEME_LANG); ?></span><span><?php echo $response['payload']['city_building_name']; ?></span></li>
              </ul>
            </div>
            <?php if (!empty($amenities_build)): ?>
            <div class="list-details active">
              <h2 class="title-amenities no-tab"><?php echo __('Amenities at', IDXBOOST_DOMAIN_THEME_LANG); ?> <?php echo $response['payload']['name_building']; ?> </h2>
              <ul class="list-amenities show">
                <?php
                  foreach ($amenities_build  as $key => $value) { ?>
                <li><?php echo $value; ?></li>
                <?php } ?>
              </ul>
            </div>
            <?php endif; ?>
            
          <!--shortcode para mostrar resultado-->
          <?php echo do_shortcode('[idxboost_building_inventory building_id="'.$atts['building_id'].'" load="ajax" version="'.$idx_v.'" ]'); ?>


    <?php
    //FLOOR PLAN THUMBS
                if (array_key_exists('type_floor_plan', $response['payload']) && $response['payload']['type_floor_plan'] =='1') {

                  if (array_key_exists('floor_plan_view_thumbs', $response['payload']) && !empty($response['payload']['floor_plan_view_thumbs']) ) {
                    
                    $floor_plan_view_thumbs= json_decode($response['payload']['floor_plan_view_thumbs'],true);

                   if( is_array($floor_plan_view_thumbs) && count($floor_plan_view_thumbs)>0 ) { ?>

                      <h2 class="title-thumbs"><?php echo $response['payload']['name_building']; ?> Floorplans</h2>
                      <ul class="ib-wrap-floors">
                        <?php
                         foreach ($floor_plan_view_thumbs as $value_thumbs) {
                          $url_img_floorplan ="";
                          if (array_key_exists('url', $value_thumbs)) {
                            $url_img_floorplan = $value_thumbs["url"];
                          }else{
                            $url_img_floorplan = $value_thumbs[0];
                          }

                          $title_floorplan ="";
                          if (array_key_exists('title', $value_thumbs)) {
                            $title_floorplan = $value_thumbs["title"];
                          }else{
                            $title_floorplan = $value_thumbs[1];
                          }

                          $tag_floorplan ="";
                          if (array_key_exists('tag', $value_thumbs)) {
                            $tag_floorplan = $value_thumbs["tag"];
                          }else{
                            $tag_floorplan = $value_thumbs[2];
                          }
                          ?>
                        <li class="ib-item">
                          <a href="javascript:void(0)" class="ib-item-fp fp-btn">
                            <img src="<?php echo $url_img_floorplan; ?>" class="img-bz" alt="<?php echo $tag_floorplan; ?>" title="<?php echo $title_floorplan; ?>">
                            <?php  if (!empty($title_floorplan )) {
                              echo '<h3 class="ib-fp-caption">'.$title_floorplan.'</h3>';
                            }
                            ?>              
                          </a>
                        </li>    
                        <?php } ?>  
                      </ul>
                   <?php 
                  }
                }
              }
  if (array_key_exists('type_floor_plan', $response['payload']) && $response['payload']['type_floor_plan'] =='2') {

    if (array_key_exists('floor_plan_view_grid', $response['payload']) && !empty($response['payload']['floor_plan_view_grid']) ) {
      
      $floor_plan_view_grid= json_decode($response['payload']['floor_plan_view_grid'],true);
      $floor_plan_grid_keyplan='';
      if( is_array($floor_plan_view_grid) && count($floor_plan_view_grid)>0 ) { 
            if (array_key_exists('floor_plan_grid_keyplan', $response['payload']) && !empty($response['payload']['floor_plan_grid_keyplan']) ) {
              $floor_plan_grid_keyplan= $response['payload']['floor_plan_grid_keyplan'];
            }
      ?>

                    <div class="ib-grid-floorsplan tbl_properties_wrapper ">
                      <h3 class="title-thumbs"><?php echo $response['payload']['name_building']; ?> <?php echo __('FLOORPLANS', IDXBOOST_DOMAIN_THEME_LANG); ?></h3>

                      <?php if (!empty($floor_plan_grid_keyplan)) { ?>
                        <div class="ib-fp-img">
                          <img src="<?php echo $floor_plan_grid_keyplan; ?>" alt="<?php echo $response['payload']['name_building']; ?>">
                        </div>
                      <?php } ?>

      <div class="ib-fp-table">
        <table class="ib-display" id="dataTable-floorplan-grid" cellspacing="0" width="100%">
          <thead>
            <tr>
                <?php if (!in_array('model', $default_floor_plan) ){ ?>
                  <th class="dt-center sorting"><?php echo __('Model', IDXBOOST_DOMAIN_THEME_LANG); ?></th>
                <?php } ?>

                <?php if (!in_array('line', $default_floor_plan) ){ ?>
                <th class="dt-center sorting"><?php echo __('Line', IDXBOOST_DOMAIN_THEME_LANG); ?></th>
                <?php } ?>

                <?php if (!in_array('beds', $default_floor_plan) || !in_array('baths', $default_floor_plan) || !in_array('half_bath', $default_floor_plan) ){ ?>
                <th class="dt-center sorting">
                  <span class="ms-mb-text"><?php echo __('B/B/H', IDXBOOST_DOMAIN_THEME_LANG); ?></span>
                  <span class="ms-pc-text"><?php echo __('Beds/Baths/Half Bath', IDXBOOST_DOMAIN_THEME_LANG); ?></span>
                </th>
                <?php } ?>

                <?php if (!in_array('size_sqft_in', $default_floor_plan) ){ ?>
                  <th class="dt-center sorting"><?php echo __('Size SQ FT Inside', IDXBOOST_DOMAIN_THEME_LANG); ?></th>
                <?php } ?>

                <?php if (!in_array('size_m2_in', $default_floor_plan) ){ ?>
                  <th class="dt-center sorting"><?php echo __('Size m² Inside', IDXBOOST_DOMAIN_THEME_LANG); ?></th>
                <?php } ?>

                <?php if (!in_array('size_sqft', $default_floor_plan) ){ ?>
                  <th class="dt-center sorting"><?php echo __('Size SQ FT Exterior', IDXBOOST_DOMAIN_THEME_LANG); ?></th>
                <?php } ?>

                <?php if (!in_array('size_m2', $default_floor_plan) ){ ?>
                  <th class="dt-center sorting"><?php echo __('Size m² Exterior', IDXBOOST_DOMAIN_THEME_LANG); ?></th>
                <?php } ?>

                <?php if (!in_array('file', $default_floor_plan) ){ ?>
                  <th class="dt-center sorting"><?php echo __('Floorplans', IDXBOOST_DOMAIN_THEME_LANG); ?></th>
                <?php } ?>
            </tr>
            </thead>
            <tbody>
              <?php foreach ($floor_plan_view_grid as $value_grid) { ?>
                <?php 
                  $model='-';
                  $line='-';
                  $size_m2_in='';
                  $size_sqft_in='';
                  $beds='0';
                  $baths='0';
                  $file='';  
                  $half_bath='0';
                  $size_sqft='';
                  $size_m2='';             

                 if (array_key_exists('half_bath', $value_grid) && !empty($value_grid['half_bath']) && $value_grid['half_bath']!='undefined' )
                    $half_bath=$value_grid['half_bath'];

                 if (array_key_exists('model', $value_grid))
                    $model=$value_grid['model'];

                 if (array_key_exists('line', $value_grid) && !empty($value_grid['line']))
                    $line=$value_grid['line'];
                 
                 if (array_key_exists('size_m2_in', $value_grid))
                    $size_m2_in=$value_grid['size_m2_in'];                                                       

                 if (array_key_exists('size_sqft_in', $value_grid))
                    $size_sqft_in=$value_grid['size_sqft_in'];


                 if (array_key_exists('size_sqft', $value_grid))
                    $size_sqft=$value_grid['size_sqft'];                                                       

                 if (array_key_exists('size_m2', $value_grid))
                    $size_m2=$value_grid['size_m2'];


                 if (array_key_exists('beds', $value_grid) && !empty($value_grid['beds']))
                    $beds=$value_grid['beds'];

                 if (array_key_exists('baths', $value_grid) && !empty($value_grid['baths']))
                    $baths=$value_grid['baths'];

                 if (array_key_exists('file', $value_grid))
                    $file=$value_grid['file'];                  
                  
                  ?>
            <tr>
                <?php if (!in_array('model', $default_floor_plan) ){ ?>
                  <td class="table-beds show-desktop"><?php echo $model; ?></td>
              <?php } ?>

              <?php if (!in_array('line', $default_floor_plan) ){ ?>
                <td class="table-beds show-desktop"><?php echo $line; ?></td>
              <?php } ?>

              <?php if (!in_array('beds', $default_floor_plan) || !in_array('baths', $default_floor_plan) || !in_array('half_bath', $default_floor_plan) ){ ?>
                <td class="table-beds show-desktop"><?php echo  $beds.'/'.$baths.'/'.$half_bath; ?></td>
              <?php } ?>                



              <?php if (!in_array('size_sqft_in', $default_floor_plan) ){ ?>
                <td class="table-beds show-desktop"><?php echo $size_sqft_in; ?></td>
              <?php } ?>

              <?php if (!in_array('size_m2_in', $default_floor_plan) ){ ?>
                <td class="table-beds show-desktop"><?php echo $size_m2_in; ?></td>
              <?php } ?>


              <?php if (!in_array('size_sqft', $default_floor_plan) ){ ?>
                <td class="table-beds show-desktop"><?php echo $size_sqft; ?></td>
              <?php } ?>

                <?php if (!in_array('size_m2', $default_floor_plan) ){ ?>
                  <td class="table-beds show-desktop"><?php echo $size_m2; ?></td>
                <?php } ?>



                <?php if (!in_array('file', $default_floor_plan) ){ ?>

                <td class="table-beds show-desktop">
                  <?php if (!empty($file)) { ?>
                  <a class="ib-ms-btn" href="<?php echo $file; ?>" target="_blank"><?php echo __('Download', IDXBOOST_DOMAIN_THEME_LANG); ?></a>                    
                  <?php } ?>
                </td>
                <?php } ?>

            </tr>                  
              <?php } ?>  
            </tbody>
          </table>
        </div>
      </div>

     <?php 
    }
  }
//echo "<script type='text/javascript'>jQuery('#dataTable-floorplan-grid').DataTable({ 'paging': false }).order([3, 'desc']).draw(); </script>";
}
//FLOOR PLAN thumbs
?>







              <?php
              if (shortcode_exists('sc_news_to_building'))
                echo do_shortcode('[sc_news_to_building id_building="' . get_the_ID() . '"]'); ?>

              <div class="ms-form-detail">
                <div class="property-contact">
                  <div class="form-content large-form">
                    <div class="avatar-content">
                      <div class="content-avatar-image"><img class="lazy-img" data-src="<?php echo $agent_info_photo; ?>" title="<?php echo $agent_info_name; ?> <?php echo $agent_last_name; ?>" alt="<?php echo $agent_info_name; ?> <?php echo $agent_last_name; ?>"></div>
                      <div class="avatar-information">
                        <h2><?php echo $agent_info_name; ?> <?php echo $agent_last_name; ?></h2>
                        <?php if (!empty($agent_info_phone)) : ?>
                          <a class="phone-avatar" href="tel:<?php echo preg_replace('/[^\d]/', '', $agent_info_phone); ?>" title="<?php echo __('Call to', IDXBOOST_DOMAIN_THEME_LANG); ?> <?php echo $agent_info_phone; ?>"><?php echo __('Ph', IDXBOOST_DOMAIN_THEME_LANG); ?>. <?php echo $agent_info_phone; ?></a>
                        <?php endif; ?>
                      </div>
                    </div>
                    <form method="post" class="flex_idx_building_form gtm_more_info_building iboost-secured-recaptcha-form iboost-form-validation">
                      <fieldset>
                        <legend><?php echo $agent_info_name; ?> <?php echo $agent_last_name; ?></legend> 
                        <input type="hidden" name="ib_tags" value="">
                        <input type="hidden" name="slug" value="<?php echo $building_slug; ?>">
                        <input type="hidden" name="action" value="flex_idx_request_website_building_form">
                        <input type="hidden" name="building_ID" value="<?php echo get_the_ID(); ?>">
                        <input type="hidden" name="building_price_range" class="js-building-price-range" value="$0">

                        <?php if (array_key_exists('google_gtm', $flex_idx_info['agent']) && !empty($flex_idx_info['agent']['google_gtm'])) : ?>
                          <input type="hidden" name="gclid_field" id="gclid_field_building">
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
                              if ($flex_idx_info['agent']['track_gender'] == true) { ?>
                                <li class="gfield">
                                  <label class="gfield_label" for="first_name"><?php echo __("Gender", IDXBOOST_DOMAIN_THEME_LANG); ?></label>
                                  <div class="ginput_container ginput_container_text sp-box">
                                    <select name="gender" class="gender">
                                      <option value="<?php echo __('Mr.', IDXBOOST_DOMAIN_THEME_LANG); ?>"><?php echo __('Mr.', IDXBOOST_DOMAIN_THEME_LANG); ?></option>
                                      <option value="<?php echo __('Mrs.', IDXBOOST_DOMAIN_THEME_LANG); ?>"><?php echo __('Mrs.', IDXBOOST_DOMAIN_THEME_LANG); ?></option>
                                      <option value="<?php echo __('Miss', IDXBOOST_DOMAIN_THEME_LANG); ?>"><?php echo __('Miss', IDXBOOST_DOMAIN_THEME_LANG); ?></option>
                                    </select>
                                    <input autocorrect="off" autocapitalize="off" spellcheck="false" autocomplete="disabled" autocomplete="disabled" required class="medium" name="first_name" id="first_name" type="text" value="<?php if (isset($flex_idx_lead['lead_info']['first_name'])) : ?><?php echo $flex_idx_lead['lead_info']['first_name']; ?><?php endif; ?>" placeholder="<?php echo __('First Name', IDXBOOST_DOMAIN_THEME_LANG); ?>*">
                                  </div>
                                </li>
                              <?php } else { ?>
                                <li class="gfield">
                                  <div class="ginput_container ginput_container_text">
                                    <label class="gfield_label" for="first_name"><?php echo __('First Name', IDXBOOST_DOMAIN_THEME_LANG); ?></label>
                                    <input autocorrect="off" autocapitalize="off" spellcheck="false" autocomplete="disabled" autocomplete="disabled" required class="_ib_fn_inq medium" name="first_name" type="text" value="<?php if (isset($flex_idx_lead['lead_info']['first_name'])) : ?><?php echo $flex_idx_lead['lead_info']['first_name']; ?><?php endif; ?>" placeholder="<?php echo __('First Name', IDXBOOST_DOMAIN_THEME_LANG); ?>*">
                                  </div>
                                </li>
                              <?php }
                            } else { ?>
                              <li class="gfield">
                                <div class="ginput_container ginput_container_text">
                                  <label class="gfield_label" for="first_name"><?php echo __('First Name', IDXBOOST_DOMAIN_THEME_LANG); ?></label>
                                  <input autocorrect="off" autocapitalize="off" spellcheck="false" autocomplete="disabled" autocomplete="disabled" required class="_ib_fn_inq medium" name="first_name" type="text" value="<?php if (isset($flex_idx_lead['lead_info']['first_name'])) : ?><?php echo $flex_idx_lead['lead_info']['first_name']; ?><?php endif; ?>" placeholder="<?php echo __('First Name', IDXBOOST_DOMAIN_THEME_LANG); ?>*">
                                </div>
                              </li>
                            <?php } ?>

                            <li class="gfield">
                              <div class="ginput_container ginput_container_text">
                                <label class="gfield_label" for="first_name"><?php echo __('Last Name', IDXBOOST_DOMAIN_THEME_LANG); ?></label>
                                <input autocorrect="off" autocapitalize="off" spellcheck="false" autocomplete="disabled" autocomplete="disabled" class="_ib_ln_inq medium" name="last_name" type="text" value="<?php if (isset($flex_idx_lead['lead_info']['last_name'])) : ?><?php echo $flex_idx_lead['lead_info']['last_name']; ?><?php endif; ?>" placeholder="<?php echo __('Last Name', IDXBOOST_DOMAIN_THEME_LANG); ?>*">
                              </div>
                            </li>
                            <li class="gfield">
                              <div class="ginput_container ginput_container_email">
                                <label class="gfield_label" for="email"><?php echo __('Email', IDXBOOST_DOMAIN_THEME_LANG); ?></label>
                                <input autocorrect="off" autocapitalize="off" spellcheck="false" autocomplete="disabled" autocomplete="disabled" required class="_ib_em_inq medium" name="email" type="email" value="<?php if (isset($flex_idx_lead['lead_info']['email_address'])) : ?><?php echo $flex_idx_lead['lead_info']['email_address']; ?><?php endif; ?>" placeholder="<?php echo __('Email', IDXBOOST_DOMAIN_THEME_LANG); ?>*">
                              </div>
                            </li>
                            
                            <li class="gfield">
                              <div class="ginput_container ginput_container_email">
                                <label class="gfield_label" for="phone"><?php echo __('Phone', IDXBOOST_DOMAIN_THEME_LANG); ?></label>
                                <input autocorrect="off" autocapitalize="off" spellcheck="false" autocomplete="disabled" autocomplete="disabled" required class="_ib_ph_inq medium" name="phone" type="tel" value="<?php echo $phoneContactNumber; ?>" placeholder="<?php echo __('Phone', IDXBOOST_DOMAIN_THEME_LANG); ?>*">
                              </div>
                            </li>
                            <li class="gfield comments">
                              <div class="ginput_container">
                                <label class="gfield_label" for="message"><?php echo __('Comments', IDXBOOST_DOMAIN_THEME_LANG); ?></label>
                                <textarea autocorrect="off" autocapitalize="off" spellcheck="false" autocomplete="disabled" autocomplete="disabled" class="medium textarea" name="message" type="text" placeholder="Comments" rows="10" cols="50"><?php echo __('I am interested in', IDXBOOST_DOMAIN_THEME_LANG) . ' ' . $building_default_address; ?> <?php echo __('at', IDXBOOST_DOMAIN_THEME_LANG); ?> <?php echo $response['payload']['name_building']; ?></textarea>
                              </div>
                            </li>
                            <li class="gfield requiredFields">* <?php echo __('Required Fields', IDXBOOST_DOMAIN_THEME_LANG); ?></li>
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
                            <li class="gform_footer">
                              <input class="gform_button button gform_submit_button_5" type="submit" value="<?php echo __('Request Information', IDXBOOST_DOMAIN_THEME_LANG); ?>">
                            </li>
                          </ul>
                        </div>
                      </fieldset>
                    </form>
                  </div>
                </div>
              </div>

              <?php if( in_array($flex_idx_info["board_id"], ["33"]) ){ ?>
              <div class="property-contact">
                <div class="info-content">
                  <div class="ib-bdisclaimer">
                    <div class="ms-logo-board" style="max-width: 110px">
                      <img src="https://idxboost-spw-assets.idxboost.us/logos/NYCListingCompliance.jpg">
                    </div>
                    <?php if( $flex_idx_info["agent"]["restriction_idx"] == "1" ){ ?>
                    <p><?php echo $flex_idx_info["agent"]["broker_title_associate"]; ?></p>
                    <?php } ?>
                                        
                    <p>The Registrant acknowledges each other RLS Broker’s ownership of, and the validity of their respective copyright in, the Exlusive Listings that are transmitted over the RLS. The information is being provided by REBNY Listing Service, Inc. Information deemed reliable but not guaranteed. Information is provided for consumers’ personal, non-commercial use, and may not be used for any purpose other than the identification of potential properties for purchase. This information is not verified for authenticity or accuracy and is not guaranteed and may not reflect all real estate activity in the market. ©<?php echo date('Y'); ?> REBNY Listing Service, Inc. All rights reserved.</p>
                  </div>
                </div>
              </div>
              <?php } ?>
            </div>
          </div>

          <div class="aside">

            <ul class="property-information ltd d-hidden">
              <?php if ($type_building == 0) { ?>
                <li class="sale flex-open-tb-sale fbc-group idx-tab-building">
                  <button>0 <span><?php echo __('For Sale', IDXBOOST_DOMAIN_THEME_LANG); ?></span></button>
                </li>
                <li class="rent flex-open-tb-rent fbc-group idx-tab-building">
                  <button>0 <span><?php echo __('For Rent', IDXBOOST_DOMAIN_THEME_LANG); ?></span></button>
                </li>
                <li class="pending flex-open-tb-pending fbc-group idx-tab-building">
                  <button>0 <span><?php echo __('Pending', IDXBOOST_DOMAIN_THEME_LANG); ?></span></button>
                </li>
                <li class="sold flex-open-tb-sold fbc-group idx-tab-building">
                  <button>0 <span><?php echo __('Sold', IDXBOOST_DOMAIN_THEME_LANG); ?></span></button>
                </li>
              <?php } ?>

              <?php if (
                array_key_exists('payload', $response) &&
                array_key_exists('hackbox', $response['payload']) &&
                is_array($response['payload']['hackbox']) &&
                array_key_exists('status', $response['payload']['hackbox'])
                && $response['payload']['hackbox']['status'] != false
              ) { ?>

                <li class="ib-wrap-hackbox-building">
                  <?php
                  echo $response['payload']['hackbox']['result']['content']; ?>
                </li>
              <?php } ?>

            </ul>

            <!--<div class="form-content">
              <div class="avatar-content">
                <div class="content-avatar-image"><img class="lazy-img" data-src="<?php echo $agent_info_photo; ?>" title="<?php echo $agent_info_name; ?> <?php echo $agent_last_name; ?>" alt="<?php echo $agent_info_name; ?> <?php echo $agent_last_name; ?>"></div>
                <div class="avatar-information">
                  <h2><?php echo $agent_info_name; ?> <?php echo $agent_last_name; ?></h2>
                  <?php if (!empty($agent_info_phone)) : ?>
                    <a class="phone-avatar" href="tel:<?php echo preg_replace('/[^\d]/', '', $agent_info_phone); ?>" title="<?php echo __('Call to', IDXBOOST_DOMAIN_THEME_LANG); ?> <?php echo $agent_info_phone; ?>"><?php echo __('Ph', IDXBOOST_DOMAIN_THEME_LANG); ?>. <?php echo $agent_info_phone; ?></a>
                  <?php endif; ?>
                </div>
              </div>
              <form method="post" class="flex_idx_building_form gtm_more_info_building iboost-secured-recaptcha-form">
                <fieldset>
                  <legend><?php echo $agent_info_name; ?> <?php echo $agent_last_name; ?></legend> 
                  <input type="hidden" name="ib_tags" value="">
                  <input type="hidden" name="slug" value="<?php echo $building_slug; ?>">
                  <input type="hidden" name="action" value="flex_idx_request_website_building_form">
                  <input type="hidden" name="building_ID" value="<?php echo get_the_ID(); ?>">
                  <input type="hidden" name="building_price_range" class="js-building-price-range" value="$0">
                  <div class="gform_body">
                    <ul class="gform_fields">

                      <?php if (array_key_exists('track_gender', $flex_idx_info['agent'])) {
                        if ($flex_idx_info['agent']['track_gender'] == true) { ?>
                          <li class="gfield">
                            <label class="gfield_label"><?php echo __('First Name', IDXBOOST_DOMAIN_THEME_LANG); ?></label>
                            <div class="ginput_container ginput_container_text sp-box">
                              <select name="gender" class="gender medium">
                                <option value="<?php echo __('Mr.', IDXBOOST_DOMAIN_THEME_LANG); ?>"><?php echo __('Mr.', IDXBOOST_DOMAIN_THEME_LANG); ?></option>
                                <option value="<?php echo __('Mrs.', IDXBOOST_DOMAIN_THEME_LANG); ?>"><?php echo __('Mrs.', IDXBOOST_DOMAIN_THEME_LANG); ?></option>
                                <option value="<?php echo __('Miss', IDXBOOST_DOMAIN_THEME_LANG); ?>"><?php echo __('Miss', IDXBOOST_DOMAIN_THEME_LANG); ?></option>
                              </select>
                              <input autocorrect="off" autocapitalize="off" spellcheck="false" autocomplete="disabled" autocomplete="disabled" required class="_ib_fn_inq medium" name="first_name" type="text" value="<?php if (isset($flex_idx_lead['lead_info']['first_name'])) : ?><?php echo $flex_idx_lead['lead_info']['first_name']; ?><?php endif; ?>" placeholder="<?php echo __('First Name', IDXBOOST_DOMAIN_THEME_LANG); ?>*">
                            </div>
                          </li>
                        <?php } else { ?>
                          <li class="gfield">
                            <div class="ginput_container ginput_container_text">
                              <label class="gfield_label" for="first_name"><?php echo __("First Name", IDXBOOST_DOMAIN_THEME_LANG); ?></label>
                              <input required class="medium" name="first_name" id="_ib_fn_inq" type="text" value="<?php if (isset($flex_idx_lead['lead_info']['first_name'])) : ?><?php echo $flex_idx_lead['lead_info']['first_name']; ?><?php endif; ?>" placeholder="<?php echo __("First Name", IDXBOOST_DOMAIN_THEME_LANG); ?>*">
                            </div>
                          </li>
                        <?php }
                      } else { ?>
                        <li class="gfield">
                          <div class="ginput_container ginput_container_text">
                            <label class="gfield_label" for="first_name"><?php echo __("First Name", IDXBOOST_DOMAIN_THEME_LANG); ?></label>
                            <input required class="medium" name="first_name" id="_ib_fn_inq" type="text" value="<?php if (isset($flex_idx_lead['lead_info']['first_name'])) : ?><?php echo $flex_idx_lead['lead_info']['first_name']; ?><?php endif; ?>" placeholder="<?php echo __("First Name", IDXBOOST_DOMAIN_THEME_LANG); ?>*">
                          </div>
                        </li>
                      <?php } ?>
                      <li class="gfield">
                        <div class="ginput_container ginput_container_text">
                          <label class="gfield_label"><?php echo __('Last Name', IDXBOOST_DOMAIN_THEME_LANG); ?></label>
                          <input autocorrect="off" autocapitalize="off" spellcheck="false" autocomplete="disabled" autocomplete="disabled" required class="_ib_ln_inq medium" name="last_name" type="text" value="<?php if (isset($flex_idx_lead['lead_info']['last_name'])) : ?><?php echo $flex_idx_lead['lead_info']['last_name']; ?><?php endif; ?>" placeholder="<?php echo __('Last Name', IDXBOOST_DOMAIN_THEME_LANG); ?>*">
                        </div>
                      </li>
                      <li class="gfield">
                        <div class="ginput_container ginput_container_email">
                          <label class="gfield_label"><?php echo __('Email', IDXBOOST_DOMAIN_THEME_LANG); ?></label>
                          <input autocorrect="off" autocapitalize="off" spellcheck="false" autocomplete="disabled" autocomplete="disabled" required class="_ib_em_inq medium" name="email" type="email" value="<?php if (isset($flex_idx_lead['lead_info']['email_address'])) : ?><?php echo $flex_idx_lead['lead_info']['email_address']; ?><?php endif; ?>" placeholder="<?php echo __('Email', IDXBOOST_DOMAIN_THEME_LANG); ?>*">
                        </div>
                      </li>
                      <li class="gfield">
                        <div class="ginput_container ginput_container_email">
                          <label class="gfield_label"><?php echo __('Phone', IDXBOOST_DOMAIN_THEME_LANG); ?></label>
                          <input autocorrect="off" autocapitalize="off" spellcheck="false" autocomplete="disabled" autocomplete="disabled" class="_ib_ph_inq medium" name="phone" required type="text" value="<?php if (isset($flex_idx_lead['lead_info']['phone_number'])) : ?><?php echo $flex_idx_lead['lead_info']['phone_number']; ?><?php endif; ?>" placeholder="<?php echo __('Phone', IDXBOOST_DOMAIN_THEME_LANG); ?>*">
                        </div>
                      </li>
                      <li class="gfield comments">
                        <div class="ginput_container">
                          <label class="gfield_label"><?php echo __('Comments', IDXBOOST_DOMAIN_THEME_LANG); ?></label>
                          <textarea autocorrect="off" autocapitalize="off" spellcheck="false" autocomplete="disabled" autocomplete="disabled" class="medium textarea" name="message" type="text" placeholder="<?php echo __('Comments', IDXBOOST_DOMAIN_THEME_LANG); ?>" rows="10" cols="50"><?php echo __('I am interested in', IDXBOOST_DOMAIN_THEME_LANG); ?> <?php echo $building_default_address; ?> <?php echo __('at', IDXBOOST_DOMAIN_THEME_LANG); ?> <?php echo $response['payload']['name_building']; ?></textarea>
                        </div>
                      </li>
                      <li class="gfield requiredFields">* <?php echo __('Required Fields', IDXBOOST_DOMAIN_THEME_LANG); ?></li>
                      <div class="gform_footer">
                        <input class="gform_button button gform_submit_button_5" type="submit" value="<?php echo __('Request information', IDXBOOST_DOMAIN_THEME_LANG); ?>">
                      </div>
                    </ul>
                  </div>
                </fieldset>
              </form>
            </div>-->

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
                <form method="post" class="flex_idx_building_form gtm_more_info_building iboost-secured-recaptcha-form iboost-form-validation">
                  <fieldset>
                    <legend><?php echo $agent_info_name; ?> <?php echo $agent_last_name; ?></legend> 
                    <input type="hidden" name="ib_tags" value="">
                    <input type="hidden" name="slug" value="<?php echo $building_slug; ?>">
                    <input type="hidden" name="action" value="flex_idx_request_website_building_form">
                    <input type="hidden" name="building_ID" value="<?php echo get_the_ID(); ?>">
                    <input type="hidden" name="building_price_range" class="js-building-price-range" value="$0">
                    <?php if (array_key_exists('google_gtm', $flex_idx_info['agent']) && !empty($flex_idx_info['agent']['google_gtm'])) : ?>
                      <input type="hidden" name="gclid_field" id="gclid_field_building">
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
                          if ($flex_idx_info['agent']['track_gender'] == true) { ?>
                            <li class="gfield">
                              <label class="gfield_label"><?php echo __('First Name', IDXBOOST_DOMAIN_THEME_LANG); ?></label>
                              <div class="ginput_container ginput_container_text sp-box">
                                <select name="gender" class="gender medium">
                                  <option value="<?php echo __('Mr.', IDXBOOST_DOMAIN_THEME_LANG); ?>"><?php echo __('Mr.', IDXBOOST_DOMAIN_THEME_LANG); ?></option>
                                  <option value="<?php echo __('Mrs.', IDXBOOST_DOMAIN_THEME_LANG); ?>"><?php echo __('Mrs.', IDXBOOST_DOMAIN_THEME_LANG); ?></option>
                                  <option value="<?php echo __('Miss', IDXBOOST_DOMAIN_THEME_LANG); ?>"><?php echo __('Miss', IDXBOOST_DOMAIN_THEME_LANG); ?></option>
                                </select>
                                <input autocorrect="off" autocapitalize="off" spellcheck="false" autocomplete="disabled" autocomplete="disabled" required class="_ib_fn_inq medium" name="first_name" type="text" value="<?php if (isset($flex_idx_lead['lead_info']['first_name'])) : ?><?php echo $flex_idx_lead['lead_info']['first_name']; ?><?php endif; ?>" placeholder="<?php echo __('First Name', IDXBOOST_DOMAIN_THEME_LANG); ?>*">
                              </div>
                            </li>
                          <?php } else { ?>
                            <li class="gfield">
                              <div class="ginput_container ginput_container_text">
                                <label class="gfield_label" for="first_name"><?php echo __("First Name", IDXBOOST_DOMAIN_THEME_LANG); ?></label>
                                <input required class="medium" name="first_name" id="_ib_fn_inq" type="text" value="<?php if (isset($flex_idx_lead['lead_info']['first_name'])) : ?><?php echo $flex_idx_lead['lead_info']['first_name']; ?><?php endif; ?>" placeholder="<?php echo __("First Name", IDXBOOST_DOMAIN_THEME_LANG); ?>*">
                              </div>
                            </li>
                          <?php }
                        } else { ?>
                          <li class="gfield">
                            <div class="ginput_container ginput_container_text">
                              <label class="gfield_label" for="first_name"><?php echo __("First Name", IDXBOOST_DOMAIN_THEME_LANG); ?></label>
                              <input required class="medium" name="first_name" id="_ib_fn_inq" type="text" value="<?php if (isset($flex_idx_lead['lead_info']['first_name'])) : ?><?php echo $flex_idx_lead['lead_info']['first_name']; ?><?php endif; ?>" placeholder="<?php echo __("First Name", IDXBOOST_DOMAIN_THEME_LANG); ?>*">
                            </div>
                          </li>
                        <?php } ?>
                        <li class="gfield">
                          <div class="ginput_container ginput_container_text">
                            <label class="gfield_label"><?php echo __('Last Name', IDXBOOST_DOMAIN_THEME_LANG); ?></label>
                            <input autocorrect="off" autocapitalize="off" spellcheck="false" autocomplete="disabled" autocomplete="disabled" required class="_ib_ln_inq medium" name="last_name" type="text" value="<?php if (isset($flex_idx_lead['lead_info']['last_name'])) : ?><?php echo $flex_idx_lead['lead_info']['last_name']; ?><?php endif; ?>" placeholder="<?php echo __('Last Name', IDXBOOST_DOMAIN_THEME_LANG); ?>*">
                          </div>
                        </li>
                        <li class="gfield">
                          <div class="ginput_container ginput_container_email">
                            <label class="gfield_label"><?php echo __('Email', IDXBOOST_DOMAIN_THEME_LANG); ?></label>
                            <input autocorrect="off" autocapitalize="off" spellcheck="false" autocomplete="disabled" autocomplete="disabled" required class="_ib_em_inq medium" name="email" type="email" value="<?php if (isset($flex_idx_lead['lead_info']['email_address'])) : ?><?php echo $flex_idx_lead['lead_info']['email_address']; ?><?php endif; ?>" placeholder="<?php echo __('Email', IDXBOOST_DOMAIN_THEME_LANG); ?>*">
                          </div>
                        </li>
                        <li class="gfield">
                          <div class="ginput_container ginput_container_email">
                            <label class="gfield_label"><?php echo __('Phone', IDXBOOST_DOMAIN_THEME_LANG); ?></label>
                            <input autocorrect="off" autocapitalize="off" spellcheck="false" autocomplete="disabled" autocomplete="disabled" class="_ib_ph_inq medium" name="phone" required type="tel" value="<?php echo $phoneContactNumber; ?>" placeholder="<?php echo __('Phone', IDXBOOST_DOMAIN_THEME_LANG); ?>*">
                          </div>
                        </li>
                        <li class="gfield comments">
                          <div class="ginput_container">
                            <label class="gfield_label"><?php echo __('Comments', IDXBOOST_DOMAIN_THEME_LANG); ?></label>
                            <textarea autocorrect="off" autocapitalize="off" spellcheck="false" autocomplete="disabled" autocomplete="disabled" class="medium textarea" name="message" type="text" placeholder="<?php echo __('Comments', IDXBOOST_DOMAIN_THEME_LANG); ?>" rows="10" cols="50"><?php echo __('I am interested in', IDXBOOST_DOMAIN_THEME_LANG); ?> <?php echo $building_default_address; ?> <?php echo __('at', IDXBOOST_DOMAIN_THEME_LANG); ?> <?php echo $response['payload']['name_building']; ?></textarea>
                          </div>
                        </li>
                        <?php if ( ($idxboost_agent_info["show_opt_in_message"]) ) {  ?>
                        <li class="gfield fub">
                          <div class="ms-flex-chk-ub">
                            <div class="ms-item-chk">
                              <input type="checkbox" id="follow_up_boss_valid_" required <?php echo $checked; ?>>
                              <label for="follow_up_boss_valid_">Follow Up Boss</label>
                            </div>
                            <div class="ms-fub-disclaimer">
                              <p><?php echo __("By submitting this form you agree to be contacted by", IDXBOOST_DOMAIN_THEME_LANG); ?> <?php echo $idxboost_term_condition["company_name"]; ?> <?php echo __('via call, email, and text. To opt out, you can reply "stop" at any time or click the unsubscribe link in the emails. For more information see our', IDXBOOST_DOMAIN_THEME_LANG); ?> <a href="/terms-and-conditions/#follow-up-boss" target="_blank"><?php echo __("Terms and Conditions", IDXBOOST_DOMAIN_THEME_LANG); ?></a> <?php echo __("and", IDXBOOST_DOMAIN_THEME_LANG); ?> <a href="/terms-and-conditions/#atospp-privacy"><?php echo __("Privacy Policy", IDXBOOST_DOMAIN_THEME_LANG); ?></a></p>
                            </div>
                          </div>
                        </li>
                        <?php } ?>
                        <li class="gfield requiredFields">* <?php echo __('Required Fields', IDXBOOST_DOMAIN_THEME_LANG); ?></li>
                        <div class="gform_footer">
                          <input class="gform_button button gform_submit_button_5" type="submit" value="<?php echo __('Request information', IDXBOOST_DOMAIN_THEME_LANG); ?>">
                        </div>
                      </ul>
                    </div>
                  </fieldset>
                </form>
                <button class="msCloseModalDetail ms-close">Close</button>
              </div>
              <div class="ms-layout-modal mslayoutModalDetail"></div>
            </div>


            <ul class="property-information ltd d-hidden">
              <?php if ($type_building == 0) { ?>
                <li class="price"></li>
              <?php } else { ?>
                <li class="price"><?php echo $response['payload']['price_building']; ?><span><?php echo __("Today's Prices", IDXBOOST_DOMAIN_THEME_LANG); ?></span></li>
              <?php } ?>
              <?php if (!empty($response['payload']['bed_building'])) { ?>
                <li class="item-list"> <span><?php echo __('Bedrooms', IDXBOOST_DOMAIN_THEME_LANG); ?></span><span><?php echo $response['payload']['bed_building']; ?></span></li>
              <?php   } ?>

              <?php if (!empty($response['payload']['year_building'])) { ?>
                <li class="item-list"> <span><?php echo __('Year Built', IDXBOOST_DOMAIN_THEME_LANG); ?></span><span><?php echo $response['payload']['year_building']; ?></span></li>
              <?php   } ?>

              <?php if (!empty($response['payload']['unit_building'])) { ?>
                <li class="item-list"> <span><?php echo __('Units', IDXBOOST_DOMAIN_THEME_LANG); ?></span><span class="item-list-units-un"><?php echo $response['payload']['unit_building']; ?></span></li>
              <?php   } ?>

              <?php if (!empty($response['payload']['floor_building'])) { ?>
                <li class="item-list"> <span><?php echo __('Stories', IDXBOOST_DOMAIN_THEME_LANG); ?></span><span><?php echo $response['payload']['floor_building']; ?></span></li>
              <?php   } ?>
              <?php if ($type_building == 0) { ?>
                <li class="item-list"> <span><?php echo __('Average Price', IDXBOOST_DOMAIN_THEME_LANG); ?> <?php echo __('Sq.Ft.', IDXBOOST_DOMAIN_THEME_LANG); ?></span><span class="ib_inventory_avg_price">$0</span></li>
                <li class="item-list"> <span><?php echo __('Average Days on Market', IDXBOOST_DOMAIN_THEME_LANG); ?></span><span class="ib_inventory_days_market">0</span></li>
              <?php } ?>
              <li class="item-list"> <span><?php echo __('City', IDXBOOST_DOMAIN_THEME_LANG); ?></span><span><?php echo $response['payload']['city_building_name']; ?></span></li>
            </ul>

            <div class="wp-statisticss">
              <h2 class="subtitle-b" data-title="<?php echo __('Inventory', IDXBOOST_DOMAIN_THEME_LANG); ?>">
                <?php
                if ($response['payload']['is_marketing'] != false) {
                  echo $response['payload']['name_building'] . ' ' . __('Inventory', IDXBOOST_DOMAIN_THEME_LANG);
                } else {
                  echo __('Inventory', IDXBOOST_DOMAIN_THEME_LANG);
                } ?>
              </h2>
              <div id="chart-container"><?php echo __('FusionCharts will render here', IDXBOOST_DOMAIN_THEME_LANG); ?></div>
              <div class="cols inventory-sta">
                <h4><?php echo __('Inventory', IDXBOOST_DOMAIN_THEME_LANG); ?></h4>
                <div class="data-inventory group-flex">
                  <div class="div">
                    <div class="cir-sta sale">0</div>
                    <?php echo __('For sale', IDXBOOST_DOMAIN_THEME_LANG); ?>
                  </div>
                  <div class="div">
                    <div class="cir-sta rent">0</div>
                    <?php echo __('For rent', IDXBOOST_DOMAIN_THEME_LANG); ?>
                  </div>
                </div>
              </div>
            </div>
            <div class="condo-statics">
              <h2 class="subtitle-b" data-title="<?php echo __('Condo Statistics', IDXBOOST_DOMAIN_THEME_LANG); ?>">
                <?php
                if ($response['payload']['is_marketing'] != false) {
                  echo $response['payload']['name_building'] . ' ' . __('Statistics', IDXBOOST_DOMAIN_THEME_LANG);
                } else {
                  echo __('Condo Statistics', IDXBOOST_DOMAIN_THEME_LANG);
                } ?></h2>
              <ul class="condo-st">
                <li><span class="ib_inventory_min_max_price">$0</span><?php echo __('Price Range', IDXBOOST_DOMAIN_THEME_LANG); ?></li>
                <li><span class="ib_inventory_avg_price">$0</span><?php echo __('avg price', IDXBOOST_DOMAIN_THEME_LANG); ?> / Sq.Ft.</li>
                <li><span class="ib_inventory_days_market">0 </span><?php echo __('avg days on market', IDXBOOST_DOMAIN_THEME_LANG); ?></li>
                <li><?php echo __("of building is for sale", IDXBOOST_DOMAIN_THEME_LANG); ?><span class="ib_inventory_sale"> 0 %</span></li>
                <li><?php echo __("of building is for rent", IDXBOOST_DOMAIN_THEME_LANG); ?><span class="ib_inventory_rent"> 0 %</span></li>
                <li><?php echo __("of building sold in previous 12 months", IDXBOOST_DOMAIN_THEME_LANG); ?> <span class="ib_inventory_previous">0 %</span></li>
              </ul>
            </div>

            <input type="hidden" class="ib_building_unit" value="<?php echo $response['payload']['unit_building']; ?>">

          </div>
          <button class="ib-btn-request btn-request ib-active-float-form">Contact Agent</button>
        </div>
      </section>
    </div>
    <div id="printMessageBox"><?php echo __('Please wait while we create your document', IDXBOOST_DOMAIN_THEME_LANG); ?></div>
  </main>
  <input type="hidden" value="0" id="refentElement">

  <div class="fp-modal">
    <div id="fp-wrap-modal"></div>
    <button class="fp-close-fp" aria-label="Close">
      <span></span>
    </button>
  </div>

  <div class="ms-bs-modal-sp-slider fade">
    <div id="ms-bs-modal-sp-slider">
      <div class="ms-bs-wrap-slider" id="ms-bs-gen-slider"></div>
    </div>
    <button class="ms-bs-close">Close</button>
    <button class="ms-btn-detail">View detail</button>
  </div>

<input type="hidden" id="viewGallery" value="<?php echo $response['payload']['media_gallery_type']; ?>">

<script type="text/javascript">
  (function ($) {
  
  
  
  $(function() {
  
    $(document).on("ready", function() {
      $('#modal_img_propertie .title').text('<?php echo $building_default_address; ?>');
    });
    
    $('.group-flex.tabs-btn.show-desktop li:first').click();
    jQuery('.flex-open-tb-rent').click();
    jQuery('.flex-open-tb-sale').click();
  });
  
  })(jQuery);
</script>
<style type="text/css">
  .desactivo { display: none !important; }
  .green { color: green; }
</style>

<script type="text/javascript">
  
  (function($) {
  
      function active_modal($modal) {
          if ($modal.hasClass('active_modal')) {
              $('.overlay_modal').removeClass('active_modal');
              $("html, body").animate({
                  scrollTop: 0
              }, 1500);
          } else {
              $modal.addClass('active_modal');
              $modal.find('form').find('input').eq(0).focus();
              $('html').addClass('modal_mobile');
          }
          close_modal($modal);
      }
  
      function close_modal($obj) {
          var $this = $obj.find('.close');
          $this.click(function() {
              var $modal = $this.closest('.active_modal');
              $modal.removeClass('active_modal');
              $('html').removeClass('modal_mobile');
          });
      }
  
  $(function() {
  // setup favorite

    $(".flex_b_mark_f").on("click", function(event) {
      event.stopPropagation();
      event.preventDefault();
  
      if (__flex_g_settings.anonymous === "yes") {
       // active_modal($('#modal_login'));
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
        
      } else {
        var building_id = $(this).data("building-id");
  
        if ($(this).hasClass("flex_b_marked")) {
          // remove
          $(this).removeClass("flex_b_marked");
          $(this).find("span").removeClass("active").html("Save");
  
          //console.log('remove building from favorites');
  
          $.ajax({
              url: flex_idx_filter_params.ajaxUrl,
              method: "POST",
              data: {
                  action: "flex_favorite_building",
                  building_id: building_id,
                  type_action: 'remove'
              },
              dataType: "json",
              success: function(data) {
                  // console.log(data.message);
              }
          });
        } else {
          console.log('add building to favorites');
  
          // add
          $(this).addClass("flex_b_marked");
          $(this).find("span").addClass("active").html("Remove");
  
          var building_permalink = $(this).data("permalink");
  
          $.ajax({
              url: flex_idx_filter_params.ajaxUrl,
              method: "POST",
              data: {
                  action: "flex_favorite_building",
                  building_id: building_id,
                  building_permalink: building_permalink,
                  type_action: 'add'
              },
              dataType: "json",
              success: function(data) {
                  // console.log(data.message);
              }
          });
        }
      }
  
    });
  
  });
  
})(jQuery);
</script>

<script>
  function idxsharefb_building(){
    window.open('http://www.facebook.com/sharer/sharer.php?u='+window.location.href, 'facebook_share', 'height=320, width=640, toolbar=no, menubar=no, scrollbars=no, resizable=no, location=no, directories=no, status=no');
  }

  /*function idxsharefb(event){
		event.preventDefault();
		var shareURL = "https://www.facebook.com/sharer/sharer.php?"; //url base
		//params
		var params = {
			u: $(this).attr("data-share-url");
		};
		for(var prop in params) {
			shareURL += '&' + prop + '=' + encodeURIComponent(params[prop]);
		}
		var wo = window.open(shareURL, '', 'left=0,top=0,width=550,height=450,personalbar=0,toolbar=0,scrollbars=0,resizable=0');
		if (wo.focus) {
			wo.focus();
		}
	}*/
  
</script>
<?php endif; ?>
<script type="text/javascript">
    var idxboost_hackbox_filter=[];
    var idxboost_force_registration=false;
    var idx_is_marketing=false;

    <?php if ( !empty($response) && 
      array_key_exists('payload', $response) &&  
      array_key_exists('is_marketing', $response['payload']) &&  
      !empty($response['payload']['is_marketing'])  ) { ?>
      idx_is_marketing=true;
    <?php  } ?>
    
   
    <?php 

    $registration_is_forced = (isset($flex_idx_info['agent']['force_registration']) && (true == $flex_idx_info['agent']['force_registration']) ) ? true : false;

    if(
        ($registration_is_forced != false) || 
         (
          !empty($response) && 
          array_key_exists('payload', $response) &&  
          array_key_exists('force_registration', $response['payload']) &&  
          !empty($response['payload']['force_registration'])  
        ) 
      )
      { ?>
      idxboost_force_registration=true;
    <?php  } ?>

               <?php if (
                !empty($response) && 
                array_key_exists('payload', $response) && 
                array_key_exists('hackbox', $response['payload']) && 
                is_array($response['payload']['hackbox']) && 
                array_key_exists('status', $response['payload']['hackbox'] ) 
                && $response['payload']['hackbox']['status'] != false
              ) { ?>
    idxboost_hackbox_filter= <?php echo json_encode($response['payload']["hackbox"]); ?>;
   <?php } ?>

  var view_grid_type='';
  jQuery('body').addClass('buildingPage');
  <?php
    $sta_view_grid_type='0'; if(array_key_exists('view_grid_type',$search_params)) $sta_view_grid_type=$search_params['view_grid_type']; ?>
  view_grid_type=<?php echo $sta_view_grid_type; ?>;
  if ( !jQuery('body').hasClass('clidxboost-ngrid') && view_grid_type==1) {
    jQuery('body').addClass('clidxboost-ngrid');
  }

  //script floor plan
  jQuery(document).on('click', '.fp-btn', function (e) {
    e.preventDefault();
    var $mlist = '';
    var $elementSelected = jQuery(this).parent().index();
    jQuery('body').addClass('fp-active-modal');
    if(!jQuery("#fp-wrap-modal").hasClass("gs-builded")){
      /*RECUPERAMOS LAS IMAGENES*/
      jQuery('.ib-wrap-floors').find('img').each(function () {
        var $imaSlider = '<img src="'+jQuery(this).attr('src')+'">';
        $mlist = $mlist + $imaSlider;
        console.log($mlist);
      });
      /*ASIGNAMOS LAS IMAGENES AL SLIDER*/
      jQuery("#fp-wrap-modal").html($mlist);
      /*GENERAMOS EL SLIDER*/
      jQuery("#fp-wrap-modal").greatSlider({
        type: 'swipe',
        nav: true,
        lazyLoad: true,
        bullets: false,
      });
    }
    gs.slider['fp-wrap-modal'].goTo($elementSelected + 1);
  });

  jQuery(document).on('click', '.fp-close-fp', function () {
    jQuery('body').removeClass('fp-active-modal');
  });
  //script floor plan


  jQuery(document).on("click", ".btn-request", function (e) {
    e.preventDefault();
    jQuery("body").addClass("ms-active-aside-form");
  });

  jQuery(document).on("click", ".msCloseModalDetail, .mslayoutModalDetail", function (e) {
    e.preventDefault();
    jQuery("body").removeClass("ms-active-aside-form");
  });

  /********************************* */
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


  /*RECUPERANDO VIDEO*/
  jQuery(window).on("load", function (e) {
    var galleryType = jQuery("#viewGallery").val() * 1;
    //console.log("TIPO DE GALERIA="+galleryType);
    switch (galleryType) {
    case 2:
      console.log("TIPO VIDEO");
      jQuery("#show-video").trigger("click");
      break;
    case 1:
      console.log("TIPO MAPA");
      jQuery("#show-map").trigger("click");
      break;
    case 0:
      console.log("TIPO FOTO");
      jQuery("#show-gallery").trigger("click");
      break;
    }
	});

</script>

<?php include FLEX_IDX_PATH . '/views/shortcode/idxboost_modals_filter.php';  ?>
