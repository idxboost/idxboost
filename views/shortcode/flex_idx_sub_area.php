<?php
  global $flex_idx_info, $post, $flex_social_networks, $wp;
  
  $wp_request = $wp->request;
  $wp_request_exp = explode('/', $wp_request);
  
  $building_slug = implode('/', array($wp_request_exp[0], $wp_request_exp[1]));
  
  $site_title = get_bloginfo('name');
  
  $building_permalink = get_permalink($post->ID);
  
  $amenities_build =json_decode($response['payload']['amenities_building'],true);
  
  $building_addresses = unserialize($response['payload']['address_building']);

  $sub_area_name = $response['payload']['name_building'];
  $logo = $response['payload']['logo'];

  $description_building = $response['payload']['description_building'];
  
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
        if (@count($response['payload']['properties']['sale']['items']) <= 0 || @count($response['payload']['properties']['rent']['items']) <= 0) { 
          if ($property_display_sold=='list') 
            $response['payload']['modo_view']=2;  
          else
            $response['payload']['modo_view']=1;
        }
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
    <p><?php echo __("The Sub Area you requested is not available.", IDXBOOST_DOMAIN_THEME_LANG); ?></p>
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


    /*INIT VALID FOR CHECKING IF HAS FLOOR PLAN ACTIVE*/
    $floor_plan_grid_keyplan='';
    if (array_key_exists('floor_plan_grid_keyplan', $response['payload']) && !empty($response['payload']['floor_plan_grid_keyplan']) ) {
      $floor_plan_grid_keyplan= $response['payload']['floor_plan_grid_keyplan'];
    }

    /*GET THE FLOOR PLAN THUMBS*/
    $floor_plan_view_thumbs= [];
    if (array_key_exists('type_floor_plan', $response['payload']) && $response['payload']['type_floor_plan'] =='1') {
      if (array_key_exists('floor_plan_view_thumbs', $response['payload']) && !empty($response['payload']['floor_plan_view_thumbs']) ) {
        $floor_plan_view_thumbs= json_decode($response['payload']['floor_plan_view_thumbs'],true);
      }
    }
    /*GET THE FLOOR PLAN THUMBS*/

    
    /*GET THE FLOOR PLAN GRID*/
    $floor_plan_view_grid = [];
    if (array_key_exists('type_floor_plan', $response['payload']) && $response['payload']['type_floor_plan'] =='2') {
      if (array_key_exists('floor_plan_view_grid', $response['payload']) && !empty($response['payload']['floor_plan_view_grid']) ) {        
        $floor_plan_view_grid= json_decode($response['payload']['floor_plan_view_grid'],true);
      }
    }
    /*GET THE FLOOR PLAN GRID*/   

    $exist_floor_plan=(
    ( 
      (
        array_key_exists('type_floor_plan', $response['payload']) && 
        in_array( $response['payload']['type_floor_plan'] ,['1','2'])
      ) 
        && 
      (
        ( in_array( $response['payload']['type_floor_plan'] ,['1']) && is_array($floor_plan_view_thumbs) && count($floor_plan_view_thumbs) > 0 ) ||
        ( in_array( $response['payload']['type_floor_plan'] ,['2']) && is_array($floor_plan_view_grid) && count($floor_plan_view_grid) > 0 ) 
      )        
    
    ) ||
      !empty($floor_plan_grid_keyplan)
    );
  /*INIT VALID FOR CHECKING IF HAS FLOOR PLAN ACTIVE*/

  /*INIT VALID FOR CHECKING IF HAS LOCATION ACTIVE*/
  $exist_geo_location = 
  (
    ( !empty($response['payload']['lat_building']) ) &&
    ( !empty($response['payload']['lng_building']) )
  );  

  $exist_section_location =
  ( 
    ( !empty($response['payload']['desc_location']) ) || $exist_geo_location    
  );
  /*INIT VALID FOR CHECKING IF HAS LOCATION ACTIVE*/


  /*INIT VALID FOR CHECKING IF HAS DOWNLOAD ACTIVE*/
  $exis_sheet_download =
  (
    (  !empty($response['payload']['sheet_one']) ) ||
    (  !empty($response['payload']['sheet_two']) ) ||
    (  !empty($response['payload']['sheet_three']) ) 
  );

  $exist_section_download =
  ( 
    $exis_sheet_download ||
    ( !empty($response['payload']['seo_download']) )
  );  
  /*INIT VALID FOR CHECKING IF HAS DOWNLOAD ACTIVE*/

  $size_min= $response['payload']["size_min"];
  $size_max= $response['payload']["size_max"];
  
?>

<div class="ms-content-page">
  <main class="community-page buildingPage">
    <section class="ms-community-header ms-animate" id="welcome-page">
      <h1 class="ms-title" title="<?php echo $sub_area_name; ?>"><?php echo $sub_area_name; ?> <span><?php echo $building_default_address; ?></span></h1>
      <?php if( !empty($logo) ){ ?>
      <img data-real-type="image" data-img="<?php echo $logo; ?>" src="<?php echo $logo; ?>" alt="<?php echo $sub_area_name; ?>" class="ms-broker-logo ms-lazy">        
      <?php } ?>
    </section>

    <div class="ms-community-wrap-nav">
      <nav class="ms-community-nav">
        <ul>
          <?php if( !empty($description_building) ) { ?><li><a href="#overview" title="Overview">Overview</a></li><?php } ?>
          <?php if( !empty($amenities_build) ) { ?><li><a href="#amenites" title="Amenities">Amenities</a></li><?php } ?>
          <li class="js-available-homes" ><a href="#full-main" title="Available Homes">Available Homes</a></li>
          
          <?php if ( $exist_section_location ) { ?>          
          <li><a href="#location" title="Location">Location</a></li>
        <?php } ?>


        <?php if( !empty($exist_floor_plan) ){ ?>
          <li><a href="#floorplans" title="Floorplans">Floorplans</a></li>
        <?php } ?>
          
          <?php if( $exist_section_download ){ ?>
            <li><a href="#downloads" title="Downloads">Downloads</a></li>
        <?php } ?>          
        </ul>
      </nav>
    </div>

    <div class="ms-community-info">
      <div class="ms-community-wrap-media ms-animate photo" id="media">
        <?php  if (count($response['payload']['gallery_building']) > 0) { ?>
          <div class="ms-community-slider" id="ms-slider-cm">
            <?php foreach ( $response['payload']['gallery_building'] as $key => $value) { ?>
              <div class="ms-item">
                <img data-real-type="image" data-img="<?php echo $value['url_image']; ?>" alt="<?php echo $value['name_image']; ?>" class="ms-lazy"  draggable="false">
              </div>              
            <?php } ?>
          </div>
        <?php } ?>

        <div class="ms-community-video" id="videoMap">
        </div>

        <div class="ms-wrap-btn">
          <button class="ms-btn-action active" data-type="photo">Photos</button>
          <?php if ( !empty($response['payload']['video'])) {
          echo '<button class="ms-btn-action" data-type="video" data-video="'.$response['payload']['video'].'">Video</button>';  
          }
          ?>

        <?php if($exist_geo_location ) { ?>
          <button class="ms-btn-action" data-type="map" data-lat="<?php echo $response['payload']['lat_building']; ?>" data-lng="<?php echo $response['payload']['lng_building']; ?>" data-map="videoMap">Map</button>
        <?php } ?>

        </div>
        <button class="ms-full-screen">Full Screen</button>
      </div>

      <div class="ms-community-wrap-submenu ms-animate" id="communityInfo">
        <?php
        $range_price=[];
        $range_price_txt = "";
        $status_price='js-price-upload';

        if (
          ( !empty($response['payload']['price_min']) && $response['payload']['price_min'] != '0') || 
          ( !empty($response['payload']['price_max']) && $response['payload']['price_max'] != '0')
        ) {
          $range_price= [];
          $status_price='';


          if (
            ( !empty($response['payload']['price_min']) && $response['payload']['price_min'] != '0')
          ) {
            $range_price[] ='From $'.number_format($response['payload']['price_min']);
          }
          

          if (
              ( !empty($response['payload']['price_max']) && $response['payload']['price_max'] != '0')
          ) {
            $range_price[] ='$'.number_format($response['payload']['price_max']);
          }
          
          if(is_array($range_price) && count($range_price) > 0 ){
            $range_price_txt = implode(" - " ,$range_price);
          }
      
        }
        ?>
        <span class="ms-label ms-price js-ms-price <?php echo $status_price;?>"><?php echo $range_price_txt; ?></span>
        <table>

          <?php if( !empty($response['payload']['hoa']) ) {
            echo "<tr><td>Total Homes</td><td>".$response['payload']['total_homes']."</td></tr>";
          } ?>

          <?php if( !empty($size_min)  && !empty($size_max)) {
            echo "<tr><td>Home Sizes</td><td>".$size_min." SqFt - ".$size_max." SqFt</td></tr>";
          } ?>


          <?php if( !empty($response['payload']['year_building']) ) {
            echo "<tr><td>Year Built</td><td>".$response['payload']['year_building']."</td></tr>";
          } ?>
          
          <?php if( !empty($response['payload']['city_building_name']) ) {
            echo "<tr><td>City</td><td>".$response['payload']['city_building_name']."</td></tr>";
          } ?>          

          <?php if( !empty($response['payload']['hoa']) ) {
            echo "<tr><td>HOA</td><td>".$response['payload']['hoa']."</td></tr>";
          } ?>          

          <?php  if ( !empty($response['payload']['image_map_thumb'])) { ?>
            <tr class="ms-wrap-img-map">
              <td class="ms-image-map" colspan="2">
                <div class="ms-wrap-img">
                  <img data-real-type="image" data-img="<?php echo $response['payload']['image_map_thumb']; ?>" src="<?php echo $response['payload']['image_map_thumb']; ?>" alt="mapa" class="ms-lazy">
                </div>
              </td>
            </tr>
          <?php } ?>

          
        </table>

        <div class="ms-float-actions">
          <!--<ul class="ms-float-btn ms-wrap-shared">
            <li>
              <button class="ms-btn-shared">Shared</button>
              <ul class="ms-shared">
                <li><a href="#" title="Facebook" class="ms-icon-facebook">Facebook</a></li>
                <li><a href="#" title="Twitter" class="ms-icon-twitter">Twitter</a></li>
                <li><a href="#" title="Instagram" class="ms-icon-instagram">Instagram</a></li>
              </ul>
            </li>
          </ul>
          <button class="ms-float-btn ms-btn-favorite">My favorite</button>-->
          <button class="ms-float-btn ms-btn-form">Inquire</button>
        </div>

        <div id="boostBoxCentral">
        </div>
      </div>
    </div>

    <?php if( !empty($description_building) ) {
            echo '
            <section class="ms-section ms-animate" id="overview">
              <h2 class="ms-sub-title">'.$sub_area_name.' Overview</h2>
              <p>'.$description_building.'</p>
            </section>';
    } ?>


    <?php if (!empty($amenities_build)) { ?>

      <section class="ms-section ms-animate" id="amenites">
        <h2 class="ms-sub-title"><?php echo $sub_area_name; ?> Amenites</h2>
        <div class="ms-community-body">
          <ul class="ms-community-amenities">
                <?php foreach ($amenities_build  as $key => $value) { ?>
                <li><?php echo $value; ?></li>
                <?php } ?>
          </ul>
        </div>
      </section>

    <?php } ?>

  <div class="ib-container-collection-sub-area">
    <?php echo do_shortcode('[idxboost_sub_area_inventory building_id="'.$atts['building_id'].'" load="ajax" template="detail-collection" ]'); ?>
  </div>

    <?php if($exist_section_location ) { ?>

    <section class="ms-section ms-animate" id="location">
      <h2 class="ms-sub-title"><?php echo $sub_area_name; ?> Location</h2>
      
      <?php if($exist_geo_location ) { ?>
        <div class="ms-community-wrap-map">
          <div id="googleMap" class="ms-map" data-real-type="mapa" data-img="googleMap" data-lat="<?php echo $response['payload']['lat_building']; ?>" data-lng="<?php echo $response['payload']['lng_building']; ?>"></div>
        </div>
      <?php } ?>

        <?php if ( !empty($response['payload']['desc_location'])) { ?>
          <p><?php echo $response['payload']['desc_location']; ?></p>  
        <?php } ?>
    </section>

    <?php } ?>
    

    <?php    
    if ($exist_floor_plan) { ?>
      <section class="ms-section ms-animate" id="floorplans">
        <h2 class="ms-sub-title"><?php echo $sub_area_name; ?> Floorplans</h2>
        <?php if (!empty($floor_plan_grid_keyplan)) { ?>
            <div class="ms-community-wrap-floorplans">
                <img data-real-type="image" data-img="<?php echo $floor_plan_grid_keyplan; ?>" src="<?php echo $floor_plan_grid_keyplan; ?>" alt="<?php echo $sub_area_name; ?>" class="ms-lazy">
            </div>  
        <?php } ?>

        <?php if (array_key_exists('type_floor_plan', $response['payload']) && $response['payload']['type_floor_plan'] =='1') {
            if( is_array($floor_plan_view_thumbs) && count($floor_plan_view_thumbs)>0 ) { ?>
              <ul class="ms-slider-floorplans ms-sp-slider" id="ms-slider-floorplans">
                <?php foreach ($floor_plan_view_thumbs as $value_thumbs) { ?>
                  <li>
                    <div class="ms-floorplans-item">
                      <a href="javascript:void(0)" class="ms-wrap-img ms-show-floorplans" title="Line 01">
                        <img data-real-type="image" data-img="<?php echo $value_thumbs['url']; ?>" src="<?php echo $value_thumbs['url']; ?>" class="ms-lazy" alt="<?php echo $value_thumbs['title']; ?>">
                      </a>
                      
                      <?php  if (!empty($value_thumbs['title'])) {
                        echo '<h3 class="ms-floorplans-name">'.$value_thumbs['title'].'</h3>';
                      } ?>              
                    </div>
                  </li>
                <?php } ?>
              </ul>
            <?php 
            }
        } ?>

        <?php 
            if (array_key_exists('type_floor_plan', $response['payload']) && $response['payload']['type_floor_plan'] =='2') {

              if ( is_array($floor_plan_view_grid) && count($floor_plan_view_grid) >0 ) { ?>

                <div class="ms-wrap-table">
                  <table class="dataTableCC nowrap">
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
                            <th class="dt-center sorting"><?php echo __('Size M2 Inside', IDXBOOST_DOMAIN_THEME_LANG); ?></th>
                          <?php } ?>

                          <?php if (!in_array('size_sqft', $default_floor_plan) ){ ?>
                            <th class="dt-center sorting"><?php echo __('Size SQ FT Exterior', IDXBOOST_DOMAIN_THEME_LANG); ?></th>
                          <?php } ?>

                          <?php if (!in_array('size_m2', $default_floor_plan) ){ ?>
                            <th class="dt-center sorting"><?php echo __('Size M2 Exterior', IDXBOOST_DOMAIN_THEME_LANG); ?></th>
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

              <?php 
              }
            }
          //FLOOR PLAN thumbs
          ?>

      </section>
      <?php } ?>

    
    <?php  if( $exist_section_download ) { ?>
      <section class="ms-section ms-animate" id="downloads">
        <h2 class="ms-sub-title"><?php echo $sub_area_name; ?> Downloads</h2>

        <?php if( $exis_sheet_download ){ ?>
            <div class="cbtns">
            <?php if( !empty($response['payload']['sheet_one']) ) { ?>
              <div>
                <h4 class="ms-title">Fact Sheet</h4>
                <a class="bmodal" download="" href="<?php echo $response['payload']['sheet_one']; ?>" target="_blank">VIEW FACT SHEET</a>
              </div>      
            <?php } ?>
            <?php if( !empty($response['payload']['sheet_two']) ) { ?>
              <div>
                <h4 class="ms-title">Brochure Sheet</h4>
                <a class="bmodal" download="" href="<?php echo $response['payload']['sheet_two']; ?>" target="_blank">VIEW BROCHURE</a>
              </div>
            <?php } ?>
            <?php if( !empty($response['payload']['sheet_three']) ) { ?>
              <div>
                <h4 class="ms-title">Floorplans Sheet</h4>
                <a class="bmodal" download="" href="<?php echo $response['payload']['sheet_three']; ?>" target="_blank">VIEW FLOORPLANS</a>
              </div>
            <?php } ?>
          </div>
        <?php } ?>
  
        <?php if ( !empty($response['payload']['seo_download'])) { ?>
          <?php echo $response['payload']['seo_download']; ?>
        <?php } ?>

      </section>

    <?php } ?>

  </main>

  <div class="ms-community-float-block ms-animate" id="float-block">
    <div class="ms-commuty-filters">
      <button id="sale-count-uni-cons" class="ms-item-filter fbc-group active-fbc sale-count-uni-cons">0 
        <span><?php echo __("For Sale", IDXBOOST_DOMAIN_THEME_LANG); ?></span>
      </button>

      <button id="rent-count-uni-cons" class="ms-item-filter fbc-group rent-count-uni-cons">0 
        <span><?php echo __("For Rent", IDXBOOST_DOMAIN_THEME_LANG); ?></span>
      </button>

      <button id="pending-count-uni-cons" class="ms-item-filter fbc-group pending-count-uni-cons">0 
        <span><?php echo __("Pending", IDXBOOST_DOMAIN_THEME_LANG); ?></span>
      </button>

      <button id="sold-count-uni-cons" class="ms-item-filter fbc-group sold-count-uni-cons">0 
        <span><?php echo __("Sold", IDXBOOST_DOMAIN_THEME_LANG); ?></span>
      </button>

    </div>

    <div id="boostBoxLateral" class="active">
            <?php           
            if (
                array_key_exists('payload', $response) && 
                array_key_exists('hackbox', $response['payload']) && 
                is_array($response['payload']['hackbox']) && 
                array_key_exists('status', $response['payload']['hackbox'] ) 
                && $response['payload']['hackbox']['status'] != false
              ) { ?>

              <div class="ms-wrap-boostbox ms-animate" id="wrap-boostbox">
                <?php 
                echo $response['payload']['hackbox']['result']['content']; ?>
              </div>
            <?php } ?>

    </div>

    <div class="ms-wrap-form">
      <div class="ms-community-fr">
        <div class="form-content">
        <?php
          $agent_info_name = $flex_idx_info['agent']['agent_first_name'];
          $agent_last_name = $flex_idx_info['agent']['agent_last_name'];
          $agent_info_phone = $flex_idx_info['agent']['agent_contact_phone_number'];
          $agent_info_photo = $flex_idx_info['agent']['agent_contact_photo_profile'];
        ?>

          <div class="avatar-content">
            <div class="content-avatar-image">
              <img src="<?php echo $agent_info_photo; ?>" alt="<?php echo $agent_info_name." ".$agent_last_name; ?>">
            </div>
            <div class="avatar-information">
              <span class="avt-title"><?php echo $agent_info_name." ".$agent_last_name; ?></span>
              <a class="phone-avatar" href="tel:<?php echo $agent_info_phone; ?>" title="Call to <?php echo $agent_info_phone; ?>">Ph. <?php echo $agent_info_phone; ?></a>
            </div>
          </div>
          <?php echo do_shortcode('[flex_idx_contact_form id_form="form_contact_sub_area"]'); ?>
          <button class="ms-commuty-close-modal" data-modal="float-block">Close modal</button>
          <script type="text/javascript">
            jQuery(".flex-content-form .pt-name .medium").attr('placeholder','Name*');
            jQuery(".flex-content-form .pt-lname .medium").attr('placeholder','Last Name*');
            jQuery(".flex-content-form .pt-email .medium").attr('placeholder','Email*');
            jQuery(".flex-content-form .pt-phone .medium").attr('placeholder','Phone');
            jQuery(".flex-content-form .textarea").attr('placeholder','Comment');
          </script>
        </div>
      </div>
    </div>

  </div>
</div>

<div class="ms-modal-sp-slider">
  <div id="ms-modal-sp-slider">
    <div class="ms-wrap-slider" id="ms-gen-slider"></div>
  </div>
  <button class="ms-close">Close</button>
</div>


<?php endif; ?>

<?php include FLEX_IDX_PATH . '/views/shortcode/idxboost_modals_filter.php';  ?>