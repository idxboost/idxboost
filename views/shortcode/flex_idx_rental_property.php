<style>
  @media screen and (min-width: 1024px){
    #full-main.ms-property-detail-page .aside.ib-mb-show .form-content {
      top: 210px;
    }
  }
  #full-main.ms-property-detail-page .breadcrumb-options .ms-wrapper-btn-new-share .ms-wrapper .ms-share-btn:hover {
      background-color: var(--color-black) !important;
      color: var(--color-white) !important; 
  }

</style>
<?php if (empty($property)){ ?>
<div class="gwr idx-mmg">
  <div class="message-alert idx_color_primary flex-property-not-available">
    <p>The property you requested with MLS <?php echo $GLOBALS['property_mls']; ?>. is not available.</p>
  </div>
</div>
<?php }else{ 

  $idxboost_term_condition = get_option('idxboost_term_condition');
  $idxboost_agent_info = get_option('idxboost_agent_info');
  $sd = (is_array($_GET) && array_key_exists("sd", $_GET)) ? @date_create($_GET["sd"]) : null;
  $ed = (is_array($_GET) && array_key_exists("ed", $_GET)) ? @date_create($_GET["ed"]) : null;

  $rental_stay = "N/A";
  if ( !empty($sd) && !empty($ed) ) {
    $rental_stay =  date_format($sd,"m/d/Y")." - ".date_format($ed,"m/d/Y");
  }

  $enlace_actual = $_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
  $flex_lead_credentials = isset($_COOKIE['ib_lead_token']) ? ($_COOKIE['ib_lead_token']) : '';

  $Phone_office_showing = false;
  $settings_rental_data = get_post_meta(999999991, '_settings_rental', true);
  if( is_array($settings_rental_data) && count($settings_rental_data)>0 && array_key_exists("idx_hidden_phone", $settings_rental_data) && $settings_rental_data["idx_hidden_phone"] == "1" ){
      $Phone_office_showing = true;
    }


  $office_code_send_email = "";
  if( is_array($settings_rental_data) && count($settings_rental_data)>0 && array_key_exists("office_code", $settings_rental_data) && !empty($settings_rental_data["office_code"])  ){
      $office_code_send_email = $settings_rental_data["office_code"];
  }

  $first_image = "";
  if (is_array($property) && array_key_exists("gallery",$property) && count($property["gallery"]) > 0 ) {
    $first_image = $property['gallery'][0];
  }
  


  $months=["January","February","March","April","May","June","July","August","September","October","November","December"];
  $weekdays = array('Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'); 
  $more_availability_info = $property["more_availability_info"];

  $Check_in_calendar = "";
  $Check_out_calendar = "";
  $Check_in_calendarRaw = "";

  if (is_array($more_availability_info) && count($more_availability_info) > 0) {
    $Check_in_calendar_arr = $more_availability_info[0];
    $Check_out_calendar_arr = $more_availability_info[ count($more_availability_info) - 1 ];

    if ( 
      is_array($Check_in_calendar_arr) && array_key_exists("CheckInDate", $Check_in_calendar_arr) &&
      is_array($Check_out_calendar_arr) && array_key_exists("CheckOutDate", $Check_out_calendar_arr) 
     ) {
      $Check_in_calendarRaw = $Check_in_calendar_arr["CheckInDate"];
      $Check_out_calendar = $Check_out_calendar_arr["CheckOutDate"];
    }
  }

  $date_now = new DateTime("now");
  $date_now->modify('first day of this months');

  $my_date_checkin = new DateTime($Check_in_calendarRaw);
  $my_date_checkin->modify('first day of this months');

  if ($date_now > $my_date_checkin) {
    $my_date_checkin = $date_now;
  }

  $Check_in_calendarRaw = $my_date_checkin->format('Y-m-d');


  //$my_date_end = $my_date_checkin;
  $my_date_end = new DateTime($Check_in_calendarRaw);
  $my_date_end->add(new DateInterval("P1Y")); 
  $my_date_end->modify('last day of this month');
  $Check_end_calendarRaw = $my_date_end->format('Y-m-d');

  $diff = $my_date_checkin->diff($my_date_end);
  $days = (int) $diff->days;

  for ($i= 0 ; $i < $days; $i++) { 
    $date_calendar = strtotime($Check_in_calendarRaw."+ {$i} day");
          $month = date('m', $date_calendar );
          $wk = date('W', $date_calendar );
          $wkDay = date('D', $date_calendar ); 
          $day = date('d', $date_calendar );
          $aniof = date('Y', $date_calendar );
          $dates[$aniof][$month][$wk][$wkDay] = $day;
  }
?>
    <div id="full-main" class="ms-property-detail-page ms-wrapper-actions-fs">
      <section class="title-conteiner gwr animated fixed-box">
        <div class="content-fixed">
          <div class="content-fixed-title">
            <h1 class="title-page ms-property-title"><?php echo str_replace('# ', '#', $property['address_short']); ?><span><?php echo $property['address_large']; ?></h1>
            <div class="breadcrumb-options">
              <div class="ms-property-search">
                <div class="ms-wrapper-btn-new-share">
                  <div class="ms-wrapper">
                    <button class="ms-share-btn"><?php echo __("Share", IDXBOOST_DOMAIN_THEME_LANG); ?></button>
                    <ul class="ms-share-list">
                    <!--
                      <li class="ib-pscitem ib-psemailfriend -emailtofriendbuilding" data-permalink="" data-mls="<?php echo $property["mls_num"]; ?>" data-status="">
                        <a rel="nofollow" href="javascript:void(0)" 
                          class="ib-psbtn showfriendEmail" 
                          data-modal="modal_email_to_friend" 
                          data-origin="1"
                          data-media="ib-pva-photos"
                          data-price="$<?php echo number_format($property['price']); ?>"
                          data-beds="<?php echo $property['bed']; ?>"
                          data-baths="<?php echo $property['bath']; ?>"
                          data-address="<?php echo str_replace('# ', '#', $property['address_short']); ?>, <?php echo $property['address_large']; ?>"
                          data-lg="<?php echo $property['lng']; ?>" 
                          data-lt="<?php echo $property['lat']; ?>">
                            <?php echo __("Email to a friend", IDXBOOST_DOMAIN_THEME_LANG); ?>
                        </a>
                      </li>
                    -->
                      <li><a href="#" class="ib-pllink -clipboard"><?php echo __("Copy Link", IDXBOOST_DOMAIN_THEME_LANG); ?> <span class="-copied"><?php echo __("copied", IDXBOOST_DOMAIN_THEME_LANG); ?></span></a></li>
                      <li><a class="ib-plsitem ib-plsifb property-detail-share-fb" data-share-url="<?php echo $property_permalink; ?>" data-share-title="<?php echo str_replace('# ', '#', $property['address_short']);; ?> <?php echo $property['address_large']; ?>" data-share-description="<?php echo strip_tags($property['remarks']); ?>" data-share-image="<?php echo $property['gallery'][0]; ?>" onclick="idxsharefb()" rel="nofollow">Faceboook</a></li>
                      <li><a class="ib-plsitem ib-plsitw" onclick="window.open('<?php echo $twitter_share_url; ?>','s_tw','width=600,height=400'); return false;" rel="nofollow">Twitter</a></li>
                    </ul>
                  </div>
                </div>
              </div>
              <a href="<?php echo wp_get_referer(); ?>" class="btn link-back clidxboost-icon-arrow-select">Back to results</a>
              <div class="ms-property-call-action">
                <a href="tel:<?php echo flex_agent_format_phone_number($agent_info_phone); ?>" class="ib-pbtnphone"><?php echo flex_agent_format_phone_number($agent_info_phone); ?></a>
              </div>
              <a href="https://testlgv2.staging.wpengine.com/search" class="btn link-search clidxboost-icon-search">New Search</a>
            </div>
          </div>
          <ul class="content-fixed-btn">
            <li><a href="<?php echo wp_get_referer(); ?>" class="clidxboost-icon-arrow"><span>Back to results</span></a></li>
            <li>
              <a href="javascript:void(0)" class="btn-request" style="padding: 0 10px">
                <span style="justify-content: center"><?php echo flex_agent_format_phone_number($agent_info_phone); ?></span>
              </a>
            </li>
          </ul>
        </div>
      </section>
      
      <div class="header-print">
        <img src="https://cdn.iconscout.com/icon/free/png-512/avatar-370-456322.png" title="IDXBoost">
        <ul>
          <li>Call me: <?php echo flex_agent_format_phone_number($agent_info_phone); ?></li>
          <li>anthony@dgtalliance.com</li>
        </ul>
      </div>
      
      <div id="imagen-print"></div>
      
      <div id="full-slider" class="show-slider-psl">
        <div class="clidxboost-full-slider">
          <?php if ($property['img_cnt'] > 0) : ?>
            <?php foreach ($property['gallery'] as $thumbnail) : ?>
              <img data-lazy="<?php echo $thumbnail; ?>" class="img-slider gs-lazy" alt="<?php echo str_replace('# ', '#', $property['address_short']).','.$property['address_large']; ?>">
            <?php endforeach; ?>
          <?php endif; ?>          
        </div>
        
        <div id="map-view">
            <div id="map-result" data-lat="<?php echo $property['lat']; ?>" data-lng="<?php echo $property['lng']; ?>"></div>
        </div>

        <div class="moptions">
          <ul class="slider-option">
            <li>
              <button class="option-switch active ms-gallery-fs" id="show-gallery" data-view="gallery">photos</button>
            </li>
            <li>
              <button class="option-switch ms-map-fs" id="show-map" data-view="map" data-view="map" data-lat="<?php echo $property['lat']; ?>" data-lng="<?php echo $property['lng']; ?>">map view</button>
            </li>
          </ul>
          <button id="clidxboost-btn-flight" class="full-screen js-open-full-screen" data-type="photo" data-initial="1" data-gallery=".clidxboost-full-slider">Full screen</button>
        </div>
      </div>

      <section class="main main-content">
        <h2 class="title-temp">Property details information</h2>
        <div class="temporal-content"></div>

        <div class="gwr">
          <div class="container ib-guests-search-detail">
            <div class="ib-pbia">
              <div class="ib-pwinfo">
                <div class="ib-pinfo">
                  <div class="ib-pilf">
                    <div class="ib-item-st -price">
                      <span class="ms-label">Rate</span>
                      <span class="ms-result"><?php echo ( !empty($property["price"]) ? "$".number_format($property["price"]):"$0");?></span>
                    </div>
                    <div class="ib-item-st">
                      <span class="ms-label">Bed(s)</span>
                      <span class="ms-result"><?php echo $property["bed"]; ?></span>
                    </div>
                    <div class="ib-item-st">
                      <span class="ms-label">Bath(s)</span>
                      <span class="ms-result"><?php echo $property["bath"]; ?></span>
                    </div>
                    <div class="ib-item-st">
                      <span class="ms-label">Half</span>
                      <span class="ms-result"><?php echo $property["baths_half"]; ?></span>
                    </div>
                    <div class="ib-item-st">
                      <span class="ms-label">Sleep(s)</span>
                      <span class="ms-result"><?php echo $property["occupancy_limit"]; ?></span>
                    </div>
                    <div class="ib-item-st -key">
                      <span class="ms-label">Key</span>
                      <span class="ms-result"><?php echo $property["key"]; ?></span>
                    </div>
                    
                    <div class="ib-item-st -rental">
                      <span class="ms-label">Rental Stay</span>
                      <span class="ms-result"><?php 
                      
                      function convertDate($date){                       
                        $array = explode('-', $date);
                        return  $array[0]." - ".$array[1];
                       } 

                      echo $rental_stay;
                      
                      ?></span>
                    </div>
                  </div>

                  <div class="ib-pdescription" style="margin-bottom: 0;">
                    <p><?php echo $property["remarks"]; ?></p>
                  </div>

                  <div class="ib-plist-details -border" style="margin-top: 30px;">
                    <div class="ib-plist-card">
                      <h2 class="ib-plist-card-title"><?php echo __("Property Amenities", IDXBOOST_DOMAIN_THEME_LANG); ?></h2>
                      <ul class="ib-bullet-list">
                        <?php foreach ($property["amenities_value"] as $amenities) { ?>
                          <li><?php echo $amenities["description"]; ?></li>
                        <?php } ?>
                      </ul>
                    </div>
                  </div>


                  <?php 
                  if (is_array($more_availability_info) && count($more_availability_info) > 0 ) {
                    foreach ($more_availability_info as &$week_available) {
                      $week_available["check_in"] = new \DateTime($week_available["CheckInDate"],new \DateTimeZone("UTC"));
                      $week_available["check_out"] = new \DateTime($week_available["CheckOutDate"],new \DateTimeZone("UTC"));
                    }
                  } 
                  

                  if (is_array($more_availability_info) && count($more_availability_info) > 0 ) { ?>

                    <div class="ib-plist-details -border">
                      <div class="ib-plist-card">
                        <div class="ib-flex-header">
                          <h2 class="ib-plist-card-title"><?php echo __("Availability Calendar", IDXBOOST_DOMAIN_THEME_LANG); ?></h2>
                          <div class="ib-flex-leyend">
                            <span class="active"><?php echo __("Available", IDXBOOST_DOMAIN_THEME_LANG); ?></span>
                            <span><?php echo __("Unavailable", IDXBOOST_DOMAIN_THEME_LANG); ?></span>
                          </div>
                        </div>                      
                        <div class="ib-wrapper-table">
                              <?php
                              foreach($dates  as $anio => $fmonths ) { 
                                   foreach($fmonths as $month => $weeks) {  ?>
                                    <div class="ib-item">
                                      <table width="100%" border="0" cellspacing="1" cellpadding="2" id="list12">
                                        <tr>
                                          <td colspan="7" align="center"><?php echo $months[intval($month)-1]." {$anio}"; ?></td>
                                        </tr>

                                        <tr>
                                          <th><?php echo implode('</th><th>', $weekdays); ?></th>
                                        </tr>
                                        <?php
                                          foreach($weeks as $week => $days){ ?>
                                          <tr>
                                            <?php foreach($weekdays as $day){ 
                                              $exist_available = [];

                                              if (isset($days[$day])) {
                                                $GLOBALS["day_filter_search"]= new \DateTime("$anio-$month-$days[$day]",new \DateTimeZone("UTC"));
                                                $GLOBALS["day_now"] = new \DateTime("now 00:00:00");

                                                $exist_available=
                                                array_values(
                                                  array_filter($more_availability_info,function($item){
                                                    return (
                                                        (  
                                                          $item["check_in"] <= $GLOBALS["day_filter_search"] && $GLOBALS["day_filter_search"] <= $item["check_out"] 
                                                        ) 
                                                        &&
                                                        ( $GLOBALS["day_filter_search"] >= $GLOBALS["day_now"]  )

                                                    );
                                                  })
                                                );
                                              }

                                                $bgcolor = "";
                                                if (is_array($exist_available) && count($exist_available) > 0) {
                                                  $bgcolor = 'bgcolor="#90EE90"';
                                                }

                                              ?>
                                              <td <?php echo $bgcolor; ?> !important="" align="center" valign="middle" height="18px"><?php echo isset($days[$day]) ? $days[$day] : '&nbsp'; ?></td>
                                            <?php } ?>
                                          </tr>
                                          <?php } ?>
                                        </table>
                                    </div>
                                  <?php } 
                              }
                              ?>
                        </div>
                      </div>
                    </div>
                    
                  <?php  } ?>


                  <?php
                  if (is_array($property) && array_key_exists("more_rate_info", $property) && is_array($property["more_rate_info"]) && count($property["more_rate_info"]) > 0 ) { ?>
                    <div class="ib-plist-details -border">
                      <div class="ib-plist-card">
                        <h2 class="ib-plist-card-title">Rate Info</h2>
                        <div class="ib-table-list">
                          <div class="ib-header">
                            <div class="ib-item">Rate Type</div>
                            <div class="ib-item">Rate</div>
                            <div class="ib-item">Check In</div>
                            <div class="ib-item">Check Out</div>
                          </div>
                          <div class="ib-body">
                            <?php foreach ($property["more_rate_info"] as $rates) { 
                              $temp_check_in = new \DateTime($rates["CheckInDate"],new \DateTimeZone("UTC"));
                              $temp_check_out = new \DateTime($rates["CheckOutDate"],new \DateTimeZone("UTC"));
                              ?>
                              <div class="ib-item">
                                <span class="ib-label">Rate Type</span> <span class="ib-td"><?php echo $rates["Description"]; ?></span> 
                                <span class="ib-label">Rate</span> <span class="ib-td"><?php echo ($rates["available"]=="1") ? "$".number_format($rates["Rate"], 2, '.', ','):__("Unavailable", IDXBOOST_DOMAIN_THEME_LANG); ?></span> 
                                <span class="ib-label">Check In</span> <span class="ib-td"><?php echo $temp_check_in->format("F d, Y"); ?></span>
                                <span class="ib-label">Check Out</span> <span class="ib-td"><?php echo $temp_check_out->format("F d, Y"); ?></span>
                              </div>
                            <?php } ?>
                          </div>
                        </div>
                      </div>
                    </div>
                  <?php } ?>

               
                  <div class="ib-wrapper-top-map list-details clidxboost-exterior-container active ms-loadmap" id="locationMap">
                        <div class="ib-pheader" style="padding-top: 15px">
                           <h2 class="ib-ptitle"><?php echo str_replace('# ', '#', $property['address_short']); ?></h2>
                           <span class="ib-pstitle"><?php echo $property['address_large']; ?></span>
                        </div>

                      <div id="ms-wrap-map">
                        <div id="googleMap" class="ms-map" data-real-type="mapa" data-img="googleMap" data-lat="<?php echo $property['lat']; ?>" data-lng="<?php echo $property['lng']; ?>"></div>
                      </div>
                    </div>



                  <div class="ib-bdisclaimer ib-bdisclaimer-desktop">
                    <p>The information contained in this website does not serve as a substitute for an on-site visit to the vacation rental unit and should not be relied upon solely in the decision to rent the vacation unit. COMPASS RE - Avalon makes no warranty of the accuracy of the information on this site or any site to which we link.</p>
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

                  <div class="content-avatar-image">
                    <img class="lazy-img active" title="<?php echo $agent_info_name;?>" alt="<?php echo $agent_info_name;?>" src="<?php echo  $property["owner"]["photo"];?>"></div>
                  <div class="avatar-information">
                    <h2><?php echo $agent_info_name;?></h2>
                    <?php if ($Phone_office_showing) { ?>
                      <a class="phone-avatar" href="tel:<?php echo $property['office_phone'];?>" title="Call to <?php echo flex_agent_format_phone_number($property["office_phone"]); ?>">Ph. <?php echo flex_agent_format_phone_number($property["office_phone"]); ?></a>
                    <?php }else{ ?>
                      <a class="phone-avatar" href="tel:<?php echo $agent_info_phone;?>" title="Call to <?php echo $agent_info_phone;?>">Ph. <?php echo $agent_info_phone;?></a>
                    <?php } ?>
                  </div>
                </div>

                <div class="ib-pilf">
                  <div class="ib-item-st -price">
                    <span class="ms-label">Rate</span>
                    <span class="ms-result"><?php echo ( !empty($property["price"]) ? "$".number_format($property["price"]):"$0");?></span>
                  </div>
                  <div class="ib-item-st">
                    <span class="ms-label">Bed(s)</span>
                    <span class="ms-result"><?php echo $property["bed"]; ?></span>
                  </div>
                  <div class="ib-item-st">
                    <span class="ms-label">Bath(s)</span>
                    <span class="ms-result"><?php echo $property["bath"]; ?></span>
                  </div>
                  <div class="ib-item-st">
                    <span class="ms-label">Half</span>
                    <span class="ms-result"><?php echo $property["baths_half"]; ?></span>
                  </div>
                  <div class="ib-item-st">
                    <span class="ms-label">Sleep(s)</span>
                    <span class="ms-result"><?php echo $property["occupancy_limit"]; ?></span>
                  </div>
                  <div class="ib-item-st -key">
                    <span class="ms-label">Key</span>
                    <span class="ms-result"><?php echo $property["key"]; ?></span>
                  </div>
                  <div class="ib-item-st -rental">
                    <span class="ms-label">Rental Stay</span>
                    <span class="ms-result"><?php echo $rental_stay;?></span>
                  </div>
                </div>
                
                <form method="post" id="flex-idx-property-form-rental" class="gtm_more_info_property iboost-secured-recaptcha-form iboost-form-validation">
                  <fieldset>
                    <legend><?php echo $agent_info_name;?></legend>
                    <input type="hidden" name="is_vacation_rentals" value="1">
                    <input type="hidden" name="sleep" value="<?php echo $property["occupancy_limit"]; ?>">
                    <input type="hidden" name="bed" value="<?php echo $property['bed']; ?>">
                    <input type="hidden" name="type_form" value="is_vacation_rentals">
                    <input type="hidden" name="bath" value="<?php echo $property['bath']; ?>">                    
                    <input type="hidden" name="rental_stay" value="<?php echo $rental_stay; ?>">
                    <input type="hidden" name="mls_num" value="<?php echo $property['mls_num']; ?>">
                    <input type="hidden" name="ib_tags" value="Vacation Rentals">
                    <input type="hidden" name="message" value="">
                    <input type="hidden" name="permalink" value="<?php echo $enlace_actual; ?>">
                    <input type="hidden" name="lead_credentials" value="<?php echo $flex_lead_credentials; ?>">
                    
                    <input type="hidden" name="action" value="flex_idx_request_property_form">
                    <input type="hidden" name="origin" value="<?php echo $property_permalink; ?>">
                    <input type="hidden" name="price" id="flex_idx_form_price" value="<?php echo intval($property['price']); ?>">
                    <input type="hidden" id="flex_idx_form_mls_num" name="mls_num" value="<?php echo $property['mls_num']; ?>">
                    <input type="hidden" class="name_share" name="address_short" value="<?php echo $property['address_short']; ?>">
                    <input type="hidden" class="address_large" name="address_large" value="<?php echo $property['address_large']; ?>">
                    <input type="hidden" class="name_share" value="<?php echo $property['address_short']; ?>">
                    <input type="hidden" class="link_share" value="<?php echo $property_permalink; ?>">
                    <input type="hidden" class="imagens" value="<?php echo $first_image; ?>">
                    <input type="hidden" class="caption_sahre" value="<?php echo $property['remarks']; ?>">
                    <input type="hidden" class="description_share" value="<?php echo $property['remarks']; ?>">

                    <input type="hidden" class="description_share" value="<?php echo $property['remarks']; ?>">
                    <input type="hidden" class="office_code_send_email"  name="office_code_send_email" value="<?php echo $office_code_send_email; ?>">

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
                        <li class="gfield">
                          <div class="ginput_container ginput_container_text">
                            <label class="gfield_label" for="_ib_fn_inq"><?php echo __("First Name", IDXBOOST_DOMAIN_THEME_LANG); ?></label>
                            <input required="" maxlength="50" class="medium" name="first_name" id="_ib_fn_inq" type="text" value="<?php if (isset($flex_idx_lead['lead_info']['first_name'])) : ?><?php echo $flex_idx_lead['lead_info']['first_name']; ?><?php endif; ?>" placeholder="<?php echo __('First Name', IDXBOOST_DOMAIN_THEME_LANG); ?>*" maxlength="50">
                          </div>
                        </li>
                        <li class="gfield">
                          <div class="ginput_container ginput_container_text">
                            <label class="gfield_label" for="_ib_ln_inq"><?php echo __("Last Name", IDXBOOST_DOMAIN_THEME_LANG); ?></label>
                            <input required="" maxlength="50" class="medium" name="last_name" id="_ib_ln_inq" type="text" value="<?php if (isset($flex_idx_lead['lead_info']['last_name'])) : ?><?php echo $flex_idx_lead['lead_info']['last_name']; ?><?php endif; ?>" placeholder="<?php echo __("Last Name", IDXBOOST_DOMAIN_THEME_LANG); ?>*" maxlength="50">
                          </div>
                        </li>
                        <li class="gfield">
                          <div class="ginput_container ginput_container_email">
                            <label class="gfield_label" for="_ib_em_inq"><?php echo __("Email", IDXBOOST_DOMAIN_THEME_LANG); ?></label>
                            <input required="" class="medium" name="email" id="_ib_em_inq" type="email" value="<?php if (isset($flex_idx_lead['lead_info']['email_address'])) : ?><?php echo $flex_idx_lead['lead_info']['email_address']; ?><?php endif; ?>" placeholder="<?php echo __("Email", IDXBOOST_DOMAIN_THEME_LANG); ?>*" maxlength="70">
                          </div>
                        </li>
                        <li class="gfield">
                          <div class="ginput_container ginput_container_email">
                            <label class="gfield_label" for="_ib_ph_inq"><?php echo __("Phone", IDXBOOST_DOMAIN_THEME_LANG); ?></label>
                            <input required="" class="medium" name="phone" id="_ib_ph_inq" type="tel" value="<?php echo $phoneContactNumber; ?>" placeholder="<?php echo __("Phone", IDXBOOST_DOMAIN_THEME_LANG); ?>*" maxlength="15">
                          </div>
                        </li>
                        <li class="gfield comments">
                          <div class="ginput_container">
                            <label class="gfield_label" for="ms-message"><?php echo __("Comments", IDXBOOST_DOMAIN_THEME_LANG); ?></label>
                            <textarea maxlength="300" class="medium textarea" name="comments" id="ms-message" type="text" value="" placeholder="<?php echo __("Comments", IDXBOOST_DOMAIN_THEME_LANG); ?> rows="10" cols="50">I am interested in <?php echo str_replace('# ', '#', $property['address_short']); ?>,<?php echo $property['address_large']; ?></textarea>
                          </div>
                        </li>
                        <?php if ( ($idxboost_agent_info["show_opt_in_message"]) ) {  ?>
                        <li class="gfield fub">

                          <div class="ms-flex-chk-ub">
                            <?php 
                              $follow_up_boss_api_key = $flex_idx_info['agent']['follow_up_boss_api_key'];
                              if(!empty($follow_up_boss_api_key)){
                            ?>
                            <div class="ms-item-chk">
                              <input type="checkbox" id="follow_up_boss_valid" required>
                              <label for="follow_up_boss_valid">Follow Up Boss</label>
                            </div>
                            <?php } ?>
                            <div class="ms-fub-disclaimer">
                              <p><?php echo __("By submitting this form you agree to be contacted by", IDXBOOST_DOMAIN_THEME_LANG); ?> <?php echo $idxboost_term_condition["company_name"]; ?> <?php echo __('via call, email, and text. To opt out, you can reply "stop" at any time or click the unsubscribe link in the emails. For more information see our', IDXBOOST_DOMAIN_THEME_LANG); ?> <a href="/terms-and-conditions/#follow-up-boss" target="_blank"><?php echo __("Terms and Conditions", IDXBOOST_DOMAIN_THEME_LANG); ?>.</a></p>
                            </div>
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
                  <p>The information contained in this website does not serve as a substitute for an on-site visit to the vacation rental unit and should not be relied upon solely in the decision to rent the vacation unit. COMPASS RE - Avalon makes no warranty of the accuracy of the information on this site or any site to which we link.</p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>
    </div>

<script>
  function idxsharefb(){
    window.open('http://www.facebook.com/sharer/sharer.php?u='+encodeURIComponent(window.location.href), 'facebook_share', 'height=320, width=640, toolbar=no, menubar=no, scrollbars=no, resizable=no, location=no, directories=no, status=no');
  }
</script>

    <script>
      function temporalHeight() {
        var finalTop = jQuery(".ib-pilf").outerHeight();
        var propertyDescription = jQuery(".ib-pdescription");
        if (propertyDescription.length) {
          var heightContent = propertyDescription.outerHeight();
          var finalHeight = heightContent;
        }else{
          var finalHeight = 0;
          jQuery(".temporal-content").css({'border-bottom':'0'});
        }
        jQuery(".temporal-content").height(finalHeight).css({
          'top': finalTop + 'px'
        }).animate({'opacity':'1'});
      }

      jQuery(window).load(function() { 
        temporalHeight(); 
        jQuery(".fixed-box").each(function () {
          var elemento = jQuery(this);
          scrollFixedElement(elemento);
        })
      })

      jQuery(window).scroll(function() { temporalHeight(); })


      // rental formt contact


    function loadMapLocation(){
        var elementSection = jQuery('.ms-loadmap');
        if (elementSection.length) {
          elementSection.each(function(e) {
            var sectionId = jQuery("#" + jQuery(this).attr('id'));
            if (viewMap(sectionId)) {
              var item = 0, el = jQuery(this);
              sectionId.find('[data-img]').each(function(e) {
                if (jQuery(this).attr('data-real-type') == "mapa") {
                  if (viewMap(jQuery(this))) {
                    var mapa = jQuery(this).attr('data-img');
                    var lat = jQuery(this).attr('data-lat');
                    var lng = jQuery(this).attr('data-lng');
  
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
  
                        if(jQuery(this).hasClass("is-active")){
                          jQuery(this).removeClass("is-active");
                          map.setMapTypeId(google.maps.MapTypeId.ROADMAP)
                        }else{
                          jQuery(this).addClass("is-active");
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
                      
                      jQuery(this).removeAttr('data-img');
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
        docViewTop = jQuery(window).scrollTop();  
        docViewBottom = docViewTop + jQuery(window).height();  
        elemTop = jQuery(elem).offset().top;  
        elemBottom = elemTop + jQuery(elem).height();
        return ((elemBottom > docViewTop) && (elemTop < docViewBottom));
      }

      jQuery(window).load(function() { 
        loadMapLocation();          
      });
      jQuery(window).scroll(function() { loadMapLocation(); });


      jQuery("#_ib_fn_inq, #_ib_ln_inq").bind('keypress', function(event) {
        var regex = new RegExp("^[a-zA-Z-ñ ]+$");
        var key = String.fromCharCode(!event.charCode ? event.which : event.charCode);
        console.log(key, !regex.test(key) );
        if (!regex.test(key) ) {
          event.preventDefault();
          return false;
        }
      });

      function phoneMask() { 
          var num = $(this).val().replace(/\D/g,''); 
          $(this).val(num.substring(0,1) + '(' + num.substring(1,4) + ')' + num.substring(4,7) + '-' + num.substring(7,11)); 
      }
      jQuery('#_ib_ph_inq').keyup(phoneMask);

    </script>
<?php } ?>
