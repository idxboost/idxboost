<?php get_header();
  /*OBTENCION_DATA_TOKEN*/
    global $wpdb;
          $access_token = flex_idx_get_access_token();
          $sendParams = array('access_token'     => $access_token, 'alert_token' => $_GET['token']);
  
          $ch = curl_init();
          curl_setopt($ch, CURLOPT_URL, FLEX_IDX_API_TRACK_PROPERTY_LOOK_TOKEN);
          curl_setopt($ch, CURLOPT_POST, 1);
          curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($sendParams));
          curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
          curl_setopt($ch, CURLOPT_REFERER, ib_get_http_referer());
          $server_output = curl_exec($ch);
  
          $dataTokentem=json_decode($server_output,true);
          curl_close($ch);
          $datanotifi=explode(',', $dataTokentem[0]['alert_notification_types']);
  /*OBTENCION_DATA_TOKEN*/
  wp_enqueue_script('flex-idx-alerts-js');
  
  if (is_array($_COOKIE)) {   
      if (array_key_exists('ib_lead_token', $_COOKIE) == false ) {
          if (is_array($dataTokentem)) {
              if (array_key_exists('encode_token', $dataTokentem)) {
                  if (!empty($dataTokentem['encode_token'])) {
                      $encode_token = $dataTokentem['encode_token'];
                      echo '<script type="text/javascript"> Cookies.set("ib_lead_token","'.$encode_token.'"); location.reload(); </script>';            
                  }
              }
          }        
      }
  }
  
  
  while ( have_posts() ) : the_post(); ?>
<?php if (get_the_title()=='flx-unsubscribe' ) { 
  $save_alert_params = ['wp_web_id'=> get_option('flex_idx_alerts_app_id'),'rk'=> get_option('flex_idx_alerts_keys'),'wp_user_id'=> $_GET['token'] ];
  $update_alert_q    = flex_http_request(FLEX_IDX_ALERTS_UNREGISTER, $save_alert_params);
  $response['alert'] = $update_alert_q;

  $save_alert_params_cpanel = array('access_token'     => $access_token, 'alert_token' => $_GET['token']);
  $update_alert_q_cpanel    = flex_http_request(FLEX_IDX_API_TRACK_UNSUBSCRIBE_LEAD_ALERT, $save_alert_params_cpanel);

  ?>
<!-- UPDATE SEARCH MODAL -->
<div class="idxboost_subscribe">
  
  <div class="idx_body_alert_unsubscribe">
    <div class="idxboost_tile">
      <h2><?php echo __('UNSUBSCRIBE ALERT', IDXBOOST_DOMAIN_THEME_LANG); ?></h2>
    </div>
    <div class="idxboost_description">
      <p><?php echo __('You’ve been unsubscribed from My Saved Search.', IDXBOOST_DOMAIN_THEME_LANG); ?></p>
      <p><?php echo __('You’ll still receive other ', IDXBOOST_DOMAIN_THEME_LANG); ?><?php echo get_bloginfo(); ?> <?php echo __('emails that you have subscribed to.', IDXBOOST_DOMAIN_THEME_LANG); ?></p>
    </div>
  </div>
  
  <div class="idxboost_description_footer">
    <form id="form-update-alert-for-token" method="POST">
      <div class="gform_body">
        <ul class="list-check"  style="display:none;" >
          <li><input  <?php if (in_array('new_listing',$datanotifi) ) echo "checked"; ?> class="flex-save-type-options" id="update-listing-alert" name="notification_type_update_token[]" type="checkbox" value="new_listing"/><label for="update-listing-alert"><?php echo __('New Listing (Always)', IDXBOOST_DOMAIN_THEME_LANG); ?></label>
          </li>
          <li><input <?php if(in_array('price_changes',$datanotifi) ) echo "checked"; ?> class="flex-save-type-options" id="update-price-change-alert" name="notification_type_update_token[]" type="checkbox" value="price_changes"><label for="update-price-change-alert"><?php echo __('Price Changes', IDXBOOST_DOMAIN_THEME_LANG); ?></label>
          </li>
          <li><input  <?php if(in_array('status_changes',$datanotifi) )  echo "checked"; ?> class="flex-save-type-options" id="update-status-change-alert" name="notification_type_update_token[]" type="checkbox" value="status_changes"/><label for="update-status-change-alert"><?php echo __('status changes', IDXBOOST_DOMAIN_THEME_LANG); ?></label>
          </li>
        </ul>
      </div>
      <input class="medium" id="input_update_name_search_token" name="input_sname" type="hidden" value="<?php echo $dataTokentem[0]['name']; ?>">
      <input type="hidden" name="token_alert_status" class="iboost-alert-change-interval notification_day_update_flo" value="1">
      <input type="hidden" name="token_alert_flo" class="token_alert_flo" value="<?php echo $_GET['token']; ?>">
      <input type="hidden" name="type_alert" class="type_alert" value="delete">
      <div class="idxboost_footer_resbuscribe idx_body_alert_unsubscribe">
        <p><?php echo __('Oops, was it a mistake? ', IDXBOOST_DOMAIN_THEME_LANG); ?>
        <div class="form_submit_button_search_desuscribe gform_button button gform_submit_button_5"><?php echo __('Resubscribe', IDXBOOST_DOMAIN_THEME_LANG); ?></div>
      </div>
      <div class="idxboost_footer_thank" style="display: none;">
        <p><?php echo __('Hooray! You have resubscribed.', IDXBOOST_DOMAIN_THEME_LANG); ?></p>
        <p><?php echo __('Thanks for staying with us.', IDXBOOST_DOMAIN_THEME_LANG); ?></p>
      </div>
    </form>
  </div>
</div>
<!-- ALERTS -->
<div class="overlay_modal" id="modal_subscribe">
  <div class="modal_cm">
    <button data-id="modal_subscribe" class="close close-modal" data-frame="modal_mobile"><?php echo __('Close', IDXBOOST_DOMAIN_THEME_LANG); ?> <span></span></button>
    <div class="content_md">
      <div class="body_md">
        <div class="confirm-message alt-ss">
          <h3 class="alt-ss-title"><?php echo __('SUBSCRIBE ALERT', IDXBOOST_DOMAIN_THEME_LANG); ?></h3>
          <p><?php echo __('Hooray! You have resubscribied. Thanks for staying with us.', IDXBOOST_DOMAIN_THEME_LANG); ?></p>
          <a href="<?php echo home_url('/'); ?>" class="btn-link"><?php echo __('Continue searching for homes', IDXBOOST_DOMAIN_THEME_LANG); ?></a>
        </div>
      </div>
    </div>
  </div>
  <div class="overlay_modal_closer" data-id="modal_subscribe" data-frame="modal_mobile"></div>
</div>
<?php }elseif(get_the_title()=='flx-edit-information') { ?>
<!-- UPDATE SEARCH MODAL -->
<div class="idxboost_subscribe">
  <div class="idxboost_tile">
    <h2><?php echo __('EDIT ALERT', IDXBOOST_DOMAIN_THEME_LANG); ?></h2>
  </div>
  <div class="content_md modal_cm ib-st-modal-pg" style="max-width: 300px; margin: 0 auto;">
    <div class="body_md">
      <div class="form_content" id="ib-edit-alert-st">
        <form id="form-update-alert-for-token" method="POST">
          <div class="gform_body">
            <ul class="gform_fields">
              <li class="gfield">
                <label class="gfield_label"><?php echo __('Search Name(*)', IDXBOOST_DOMAIN_THEME_LANG); ?></label>
                <div class="ginput_container"><input class="medium" id="input_update_name_search_token" name="input_sname" placeholder="Search Name*" required type="text" value="<?php echo $dataTokentem[0]['name']; ?>"/></div>
              </li>
              <li class="gfield">
                <label class="gfield_label"><?php echo __('Email Updates', IDXBOOST_DOMAIN_THEME_LANG); ?></label>
                <div class="ginput_container">
                  <select class="iboost-alert-change-interval notification_day_update_flo medium">
                    <option value="0" <?php if($dataTokentem[0]['alert_interval']==0) echo "selected"; ?> ><?php echo __('No Alert', IDXBOOST_DOMAIN_THEME_LANG); ?></option>
                    <option value="1" <?php if($dataTokentem[0]['alert_interval']==1) echo "selected"; ?> ><?php echo __('Daily (each morning)', IDXBOOST_DOMAIN_THEME_LANG); ?></option>
                    <option value="7" <?php if($dataTokentem[0]['alert_interval']==7) echo "selected"; ?> ><?php echo __('Weekly', IDXBOOST_DOMAIN_THEME_LANG); ?></option>
                    <option value="30" <?php if($dataTokentem[0]['alert_interval']==30) echo "selected"; ?> ><?php echo __('Monthly', IDXBOOST_DOMAIN_THEME_LANG); ?></option>
                  </select>
                </div>
              </li>
              <li class="gfield">
                <label class="gfield_label"><?php echo __('Only Update Me On', IDXBOOST_DOMAIN_THEME_LANG); ?></label>
                <div class="ginput_container">
                  <ul class="list-check">
                    <li><input  <?php if (in_array('new_listing',$datanotifi) ) echo "checked"; ?> class="flex-save-type-options" id="update-listing-alert" name="notification_type_update_token[]" type="checkbox" value="new_listing">
                      <label for="update-listing-alert"><?php echo __('New Listing (Always)', IDXBOOST_DOMAIN_THEME_LANG); ?></label>
                    </li>
                    <li><input <?php if(in_array('price_changes',$datanotifi) ) echo "checked"; ?> class="flex-save-type-options" id="update-price-change-alert" name="notification_type_update_token[]" type="checkbox" value="price_changes">
                      <label for="update-price-change-alert"><?php echo __('Price Changes', IDXBOOST_DOMAIN_THEME_LANG); ?></label>
                    </li>
                    <li><input  <?php if(in_array('status_changes',$datanotifi) )  echo "checked"; ?> class="flex-save-type-options" id="update-status-change-alert" name="notification_type_update_token[]" type="checkbox" value="status_changes">
                      <label for="update-status-change-alert"><?php echo __('status changes', IDXBOOST_DOMAIN_THEME_LANG); ?></label>
                    </li>
                  </ul>
                  <div class="gform_footer"><input class="form_submit_button_search gform_button button gform_submit_button_5" type="submit" value="<?php echo __('Update Search', IDXBOOST_DOMAIN_THEME_LANG); ?>"></div>
                </div>
              </li>
              <input type="hidden" name="token_alert_flo" class="token_alert_flo" value="<?php echo $_GET['token']; ?>">
              <input type="hidden" name="type_alert" class="type_alert" value="update">
            </ul>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<div class="idxboost_edit_info_alert" style="display: none;">
  <p class="idx_txt_message_susscess"><?php echo __('Your alert ', IDXBOOST_DOMAIN_THEME_LANG); ?> <span><?php echo $dataTokentem[0]['name']; ?></span> <?php echo __('is updated.', IDXBOOST_DOMAIN_THEME_LANG); ?></p>
  <p><?php echo __('Thanks for staying with us.', IDXBOOST_DOMAIN_THEME_LANG); ?></p>
</div>

<?php } ?>
<style type="text/css">
  .idxboost_subscribe {
  width: 494px;
  margin: auto;
  //margin-bottom: 60px;
  }
  .idxboost_tile {
    font-size: 26px;
    text-align: center;
    margin-bottom: 1.25rem;
    font-weight: 600;
  }
  .idxboost_tile h2:after {
  content: "";
  width: 34px;
  height: 2px;
  display: block;
  margin: 10px auto 0 auto;
  background-color: #333;
  }
  .idxboost_description, .idxboost_description_footer {
  text-align: center;
  font-size: 0.885rem;
  }
  .idxboost_description p {
  padding-top: 5px;
  }
  .idxboost_description {
  margin-bottom: 26px;
  }
  .idxboost_footer_resbuscribe, .idxboost_footer_thank {
  width: fit-content;
  margin: auto;
  padding-bottom: 5px;
  }
  .idxboost_footer_resbuscribe p, .form_submit_button_search_desuscribe.gform_button.button.gform_submit_button_5 {
  float: left;
  position: relative;
  padding-left: 6px;
  }
  .idxboost_footer_thank p {
  padding-bottom: 4px;
  }
  .idxboost_footer_thank {
  margin-top: 18px;
  }
  .form_submit_button_search_desuscribe.gform_button.button.gform_submit_button_5 {
  cursor: pointer;
  color: #434343;
  font-weight: bold;
  }
  @media screen and (max-width: 530px){
    .idxboost_subscribe {
      width: 100%;
      padding: 5px;
    }
  }

  .ib-st-modal-pg{
    background-color: transparent;
    font-size: 14px;
  }

  .ib-st-modal-pg .gform_footer{
    margin-top: 15px;
  }

</style>
<?php endwhile; get_footer(); ?>