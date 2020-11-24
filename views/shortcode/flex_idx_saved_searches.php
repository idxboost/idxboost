<?php if ($flex_idx_lead === false): ?>

<div class="clidxboost-msg-info" id="box_flex_alerts_msg" style="max-width: 90%">
  <p><?php echo __('You need to', IDXBOOST_DOMAIN_THEME_LANG); ?> <a class="flex-login-link" href="#"><?php echo __('login', IDXBOOST_DOMAIN_THEME_LANG); ?></a> <?php echo __('to view this page', IDXBOOST_DOMAIN_THEME_LANG); ?>.</p>
</div>

<?php else: ?>
<style type="text/css">
#wrap-result.saved-list.view-list { display: block !important; }
</style>

<script>
  (function ($) {
    $(function() {
      /************* INICIO FUNCIONALIDAD PARA EL SELECT ***************/
      $(".clidxboost-select-mb").on("click", function() {
        $(this).toggleClass('clidxboost-active');
      });

      $(".clidxboost-select-mb li a").on("click", function() {
        $(".clidxboost-select-mb li").removeClass('clidxboost-active');
        $(this).parent().addClass('clidxboost-active');
        $(".clidxboost-select-mb").removeClass('clidxboost-active');
      });
      /************** FINAL FUNCIONALIDAD PARA EL SELECT ***************/
    });
  })(jQuery);
</script>
<main class="home page-result">
   <section id="wrap-result" class="saved-list view-list">
      <h1 class="title"><?php echo __("Search results", IDXBOOST_DOMAIN_THEME_LANG); ?></h1>
      <div class="gwr">

        <div class="clidxboost-wrapper-smb">
          <div class="clidxboost-content-select-mb">
            <ul class="clidxboost-select-mb">
              <li>
                <a href="<?php echo $flex_idx_info['pages']['flex_idx_profile']['guid'] ?>">
                  <span><?php echo $flex_idx_info['pages']['flex_idx_profile']['post_title']; ?></span>
                </a>
              </li>
              <li>
                <a href="<?php echo $flex_idx_info['pages']['flex_idx_favorites']['guid']; ?>">
                  <span><?php echo $flex_idx_info['pages']['flex_idx_favorites']['post_title']; ?></span>
                </a>
              </li>
              <li class="clidxboost-active">
                <a href="<?php echo $flex_idx_info['pages']['flex_idx_saved_searches']['guid']; ?>">
                  <span><?php echo $flex_idx_info['pages']['flex_idx_saved_searches']['post_title']; ?></span>
                </a>
              </li>
              <li>
                <a href="<?php echo $flex_idx_info['pages']['flex_idx_saved_buildings']['guid']; ?>">
                  <span><?php echo $flex_idx_info['pages']['flex_idx_saved_buildings']['post_title']; ?></span>
                </a>
              </li>
            </ul>
          </div>
        </div>

         <div  class="default-body-tab">
            <div id="tab-saved-search" class="default-item-tab active">
               <div class="header-title-profile">
                  <h2 class="title-profile"><?php echo __("My Saved Searches", IDXBOOST_DOMAIN_THEME_LANG); ?> (<span id="ib-saved-searches-cnt"><?php echo count($saved_searches); ?></span>)</h2>
               </div>

              <?php
              if (empty($saved_searches)): ?>
              <div class="message-alert idx_color_primary flex-not-logged-in-msg" id="box_flex_alerts_msg">
                <p><?php echo __("You don't have any saved search.", IDXBOOST_DOMAIN_THEME_LANG); ?></p>
              </div>
              <?php else: ?>
                <div id="saved-search" class="flex-table">
                  <div class="flex-table-row table-header">
                    <div class="flex-table-row-item fwrap"><?php echo __("Address", IDXBOOST_DOMAIN_THEME_LANG); ?></div>
                    <div class="flex-table-row-item text-center"><?php echo __("Price Range", IDXBOOST_DOMAIN_THEME_LANG); ?></div>
                    <div class="flex-table-row-item text-center"><?php echo __("Bedrooms", IDXBOOST_DOMAIN_THEME_LANG); ?></div>
                    <div class="flex-table-row-item text-center"><?php echo __("Bathrooms", IDXBOOST_DOMAIN_THEME_LANG); ?></div>
                    <div class="flex-table-row-item text-center"><?php echo __("Living Size", IDXBOOST_DOMAIN_THEME_LANG); ?></div>
                    <div class="flex-table-row-item text-center"><?php echo __("Date Saved", IDXBOOST_DOMAIN_THEME_LANG); ?></div>
                    <div class="flex-table-row-item select-action text-center"><?php echo __("Action", IDXBOOST_DOMAIN_THEME_LANG); ?></div>
                  </div>

                  <?php
                  foreach ($saved_searches as $saved_search):
                    $saved_search_url_params = flex_idx_saved_search_url_params($saved_search['search_url']); ?>

                  <div class="flex-table-row flex-body flex_alert_cont_<?php echo $saved_search['id']; ?>" alertnotifications="<?php echo $saved_search['alert_notification_types']; ?>" namesearch="<?php echo $saved_search['name']; ?>" data-alert-token="<?php echo $saved_search['token_alert']; ?>"  alertinterval="<?php echo $saved_search['alert_interval']; ?>" posid="<?php echo $saved_search['id']; ?>">
                    <div class="flex-table-row-item fwrap">
                      <div class="info-sub-item">
                        <div class="info-a">
                          <div class="date-info"><?php echo (int) $saved_search['search_count']; ?><span><?php echo __("Listing", IDXBOOST_DOMAIN_THEME_LANG); ?></span></div>
                        </div>

                        <div class="info-b">

                          <h2 class="flex_tit_<?php echo $saved_search['id']; ?>"><?php echo $saved_search['name']; ?></h2>

                          <div class="notify"><?php echo __("Notifications", IDXBOOST_DOMAIN_THEME_LANG); ?>
                          
                            <div class="chk-cnt">
                              <label for="flex_saved_search_on_<?php echo $saved_search['id']; ?>" class="opt_content">
                                <input <?php if($saved_search['is_active']==1) echo " checked "; ?> type="radio" value="on" id="flex_saved_search_on_<?php echo $saved_search['id']; ?>" name="flex_saved_search[<?php echo $saved_search['id']; ?>]"><span taction="1" posid="<?php echo $saved_search['id']; ?>" ><?php echo __("On", IDXBOOST_DOMAIN_THEME_LANG); ?></span>
                              </label>

                              <label for="flex_saved_search_off_<?php echo $saved_search['id']; ?>" class="opt_content">
                                <input  <?php if($saved_search['is_active']==0) echo " checked "; ?> type="radio" value="off" id="flex_saved_search_off_<?php echo $saved_search['id']; ?>" name="flex_saved_search[<?php echo $saved_search['id']; ?>]"><span taction="0" posid="<?php echo $saved_search['id']; ?>"><?php echo __("Off", IDXBOOST_DOMAIN_THEME_LANG); ?></span>
                              </label>
                            </div>
                          </div>

                          <div class="action-info-b">
                            <button class="clidxboost-btn-show"><span class="s1"><?php echo __("View more", IDXBOOST_DOMAIN_THEME_LANG); ?></span><span class="s2"><?php echo __("Less", IDXBOOST_DOMAIN_THEME_LANG); ?></span></button>
                            <button class="flex-saved-search-remove clidxboost-btn-remove" data-id="<?php echo $saved_search['id']; ?>" data-search-url="<?php echo $saved_search['search_url']; ?>" data-alert-token="<?php echo $saved_search['token_alert']; ?>" data-search-count="<?php echo $saved_search['search_count']; ?>">
                              <span><?php echo __("Remove", IDXBOOST_DOMAIN_THEME_LANG); ?></span>
                            </button>
                          </div>
                        </div>
                      </div>
                    </div>

<?php
$text_price= __("Any Price", IDXBOOST_DOMAIN_THEME_LANG);
if ($saved_search_url_params["price"] != 'Any Price') {
  $text_price=$saved_search_url_params["price"];
}

$text_bed= __("Any Bed", IDXBOOST_DOMAIN_THEME_LANG);
if ($saved_search_url_params["beds"] != 'Any Bed') {
  $text_bed=$saved_search_url_params["beds"];
}

$text_baths= __("Any Bath", IDXBOOST_DOMAIN_THEME_LANG);
if ($saved_search_url_params["baths"] != 'Any Bath') {
  $text_baths=$saved_search_url_params["baths"];
}

$text_size= __("Any Size", IDXBOOST_DOMAIN_THEME_LANG);
if ($saved_search_url_params["size"] != 'Any Size') {
  $text_size=$saved_search_url_params["size"];
}

?>
                    <div class="flex-table-row-item text-center"><?php echo $text_price; ?></div>
                    <div class="flex-table-row-item text-center"><?php echo $text_bed; ?></div>
                    <div class="flex-table-row-item text-center"><?php echo $text_baths; ?></div>
                    <div class="flex-table-row-item text-center"><?php echo $text_size; ?></div>


                    <?php /*
                    <?php if ($saved_search_url_params['price_range'][0] == 'Any Price' && $saved_search_url_params['price_range'][1] == 'Any Price'): ?>
                      <div class="flex-table-row-item text-center"><?php echo __("Any Price", IDXBOOST_DOMAIN_THEME_LANG); ?></div>
                    <?php else: ?>
                      <?php
                        $min_price = strstr($saved_search_url_params['price_range'][0], 'Any') ? 'Any Price' : '$' . flex_idx_format_short_price_fn(preg_replace('/[^\d]/', '', $saved_search_url_params['price_range'][0]));
                        $max_price = strstr($saved_search_url_params['price_range'][1], 'Any') ? 'Any Price' : '$' . flex_idx_format_short_price_fn(preg_replace('/[^\d]/', '', $saved_search_url_params['price_range'][1]));
                      ?>
                      <div class="flex-table-row-item text-center"><?php echo $min_price; ?> - <?php echo $max_price; ?></div>
                    <?php endif; ?>
                    <?php if ($saved_search_url_params['beds_range'][0] == 'Any Bed' && $saved_search_url_params['beds_range'][1] == 'Any Bed'): ?>
                    <div class="flex-table-row-item text-center"><?php echo __("Any Bed", IDXBOOST_DOMAIN_THEME_LANG); ?></div>
                    <?php else: ?>
                    <div class="flex-table-row-item text-center"><?php echo $saved_search_url_params['beds_range'][0]; ?> - <?php echo $saved_search_url_params['beds_range'][1]; ?></div>
                    <?php endif; ?>
                    <?php if ($saved_search_url_params['baths_range'][0] == 'Any Bath' && $saved_search_url_params['baths_range'][1] == 'Any Bath'): ?>
                    <div class="flex-table-row-item text-center"><?php echo __("Any Bath", IDXBOOST_DOMAIN_THEME_LANG); ?></div>
                    <?php else: ?>
                    <div class="flex-table-row-item text-center"><?php echo $saved_search_url_params['baths_range'][0]; ?> - <?php echo $saved_search_url_params['baths_range'][1]; ?></div>
                    <?php endif; ?>
                    <?php if ($saved_search_url_params['sqft_range'][0] == 'Any Size' && $saved_search_url_params['sqft_range'][1] == 'Any Size'): ?>
                    <div class="flex-table-row-item text-center"><?php echo __("Any Size", IDXBOOST_DOMAIN_THEME_LANG); ?></div>
                    <?php else: ?>
                    <div class="flex-table-row-item text-center"><?php echo $saved_search_url_params['sqft_range'][0]; ?> - <?php echo $saved_search_url_params['sqft_range'][1]; ?></div>
                    <?php endif; ?>
                    */ ?>
                    <div class="flex-table-row-item text-center"><?php echo date('m/d/Y', strtotime($saved_search['created_at'])); ?></div>
                    <div class="flex-table-row-item select-action text-center">
                      <button class="flex-saved-search-remove clidxboost-btn-remove" data-id="<?php echo $saved_search['id']; ?>" data-search-url="<?php echo $saved_search['search_url']; ?>" data-alert-token="<?php echo $saved_search['token_alert']; ?>" data-search-count="<?php echo $saved_search['search_count']; ?>">
                      <span><?php echo __("Remove", IDXBOOST_DOMAIN_THEME_LANG); ?></span></button>
                    </div>

                    <?php /*
                    <div class="hiddenInformation">
                      <ul>
                        <li><span><?php echo __("Price Range", IDXBOOST_DOMAIN_THEME_LANG); ?>:</span> <?php echo $saved_search_url_params['price_range'][0]; ?> - <?php echo $saved_search_url_params['price_range'][1]; ?></li>
                        <li><span><?php echo __("Bedrooms", IDXBOOST_DOMAIN_THEME_LANG); ?>:</span> <?php echo $saved_search_url_params['beds_range'][0]; ?> - <?php echo $saved_search_url_params['beds_range'][1]; ?></li>
                        <li><span><?php echo __("Bathrooms", IDXBOOST_DOMAIN_THEME_LANG); ?>:</span> <?php echo $saved_search_url_params['baths_range'][0]; ?> - <?php echo $saved_search_url_params['baths_range'][1]; ?></li>
                        <li><span><?php echo __("Living Size", IDXBOOST_DOMAIN_THEME_LANG); ?>:</span> <?php echo $saved_search_url_params['sqft_range'][0]; ?> - <?php echo $saved_search_url_params['sqft_range'][1]; ?></li>
                        <li><span><?php echo __("Date Saved", IDXBOOST_DOMAIN_THEME_LANG); ?>:</span> <?php echo date('m/d/Y', strtotime($saved_search['created_at'])); ?></li>
                      </ul>
                    </div>
                    */ ?>

                    <a href="<?php echo $saved_search['search_url']; ?>" class="view-item"></a>
                  </div>

                  <?php endforeach; ?>
                </div>

              <?php endif; ?>
            </div>
         </div>
      </div>
   </section>
</main>
<?php endif; ?>
