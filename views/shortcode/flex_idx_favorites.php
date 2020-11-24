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
              <li class="clidxboost-active">
                <a href="<?php echo $flex_idx_info['pages']['flex_idx_favorites']['guid']; ?>">
                  <span><?php echo $flex_idx_info['pages']['flex_idx_favorites']['post_title']; ?></span>
                </a>
              </li>
              <li>
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
         <div class="default-body-tab">
            <div id="tab-saved-list" class="default-item-tab active">
               <div class="header-title-profile">
                  <h2 class="title-profile"><?php echo __("My Saved Properties", IDXBOOST_DOMAIN_THEME_LANG); ?> (<span id="ib-saved-properties-cnt"><?php echo number_format($response['count']); ?></span>)</h2>
               </div>

              <?php if (!isset($response['success']) || (isset($response['items']) && empty($response['items']))): ?>
              <div class="message-alert idx_color_primary flex-not-logged-in-msg" id="box_flex_alerts_msg">
                <p><?php echo __("You don't have any saved property.", IDXBOOST_DOMAIN_THEME_LANG); ?></p>
              </div>

              <?php else: ?>
                <div id="saved-properties" class="flex-table">
                  <div class="flex-table-row table-header">
                  <div class="flex-table-row-item fwrap"><?php echo __("Address", IDXBOOST_DOMAIN_THEME_LANG); ?></div>
                  <div class="flex-table-row-item text-center"><?php echo __("Asking Price", IDXBOOST_DOMAIN_THEME_LANG); ?></div>
                  <div class="flex-table-row-item text-center"><?php echo __("Bed(s)", IDXBOOST_DOMAIN_THEME_LANG); ?></div>
                  <div class="flex-table-row-item text-center"><?php echo __("Bath(s)", IDXBOOST_DOMAIN_THEME_LANG); ?></div>
                  <div class="flex-table-row-item text-center">Sq.Ft.</div>
                  <div class="flex-table-row-item text-center"><?php echo __("MLS", IDXBOOST_DOMAIN_THEME_LANG); ?></div>
                  <div class="flex-table-row-item text-center"><?php echo __("Date Saved", IDXBOOST_DOMAIN_THEME_LANG); ?></div>
                  <div class="flex-table-row-item select-action text-center"><?php echo __("Action", IDXBOOST_DOMAIN_THEME_LANG); ?></div>
                  </div>
                  <?php foreach ($response['items'] as $property): ?>
                  <div class="flex-table-row flex-body" data-mls="<?php echo $property['mlsNum']; ?>">
                    <div class="flex-table-row-item fwrap">
                      <div class="info-sub-item">
                        <div class="info-a">
                          <div class="content-img">
                            <img src="<?php echo $property['thumbnail']; ?>" alt="<?php echo $property['addressShort']; ?>">
                          </div>
                        </div>
                        <div class="info-b">
                          <h3 class="info-b-title"><?php echo $property['addressShort']; ?></h3>
                          <span><?php echo str_replace(array(' FL, ', ' IL, '), array(', FL ', ', IL '), $property['addressLarge']); ?></span>
                          
                          <?php /*
                          <button data-mls="<?php echo $property['mlsNum']; ?>" data-permalink="<?php echo rtrim($flex_idx_info["pages"]["flex_idx_property_detail"]["guid"], "/"); ?>/<?php echo $property['slug']; ?>" data-address-short="<?php echo $property['addressShort']; ?>" data-address-large="<?php echo $property['addressLarge']; ?>" data-slug="<?php echo $property['slug']; ?>" data-price="<?php echo $property['price']; ?>" data-modal="modal_schedule" class="show-modal flex-property-request-showing request"> <span><?php echo __("request showing", IDXBOOST_DOMAIN_THEME_LANG); ?></span></button> */ ?>

                          <div class="action-info-b">
                            <button class="clidxboost-btn-show">
                            <span class="s1"><?php echo __("View more", IDXBOOST_DOMAIN_THEME_LANG); ?></span>
                            <span class="s2"><?php echo __("Less", IDXBOOST_DOMAIN_THEME_LANG); ?></span>
                            </button>
                            <button data-mls="<?php echo $property['mlsNum']; ?>" data-alert-token="<?php echo $property['tokenAlert']; ?>" class="clidxboost-btn-remove dgt-remove-favorite"> 
                            <span><?php echo __("Remove", IDXBOOST_DOMAIN_THEME_LANG); ?></span>
                            </button>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="flex-table-row-item text-center">$<?php echo number_format($property['price']); ?></div>
                    <div class="flex-table-row-item text-center">
                      <?php echo $property['bed']; ?>  <span><?php
                        if($property['bed']>1){
                          echo " ".__("Bed(s)", IDXBOOST_DOMAIN_THEME_LANG);
                        }else{
                          echo " ".__("Bed(s)", IDXBOOST_DOMAIN_THEME_LANG);
                        } ?> </span>
                    </div>
                    <div class="flex-table-row-item text-center">
                      <?php echo $property['bath']; ?> <span>
                      <?php
                        if ($property['bath']>1) {
                          echo " ".__("Bath(s)", IDXBOOST_DOMAIN_THEME_LANG);
                        }else{
                          echo " ".__("Bath(s)", IDXBOOST_DOMAIN_THEME_LANG);
                        }
                        ?></span>
                    </div>
                    <div class="flex-table-row-item text-center">
                      <?php echo number_format($property['sqft']); ?> <span> Sq.Ft</span>
                    </div>
                    <div class="flex-table-row-item text-center"><?php echo $property['mlsNum']; ?></div>
                    <div class="flex-table-row-item text-center"><?php echo date('m/d/Y', strtotime($property['createdAt']['date'])); ?></div>
                    <div class="flex-table-row-item select-action text-center">
                      <button data-mls="<?php echo $property['mlsNum']; ?>" data-alert-token="<?php echo $property['tokenAlert']; ?>" class="clidxboost-btn-remove dgt-remove-favorite"> <span><?php echo __("Remove", IDXBOOST_DOMAIN_THEME_LANG); ?></span></button>
                    </div>
                    
                    <?php /*
                    <div class="hiddenInformation">
                    <ul>
                      <li><span><?php echo __("Asking Price", IDXBOOST_DOMAIN_THEME_LANG); ?>:</span> $<?php echo number_format($property['price']); ?></li>
                      <li><span><?php echo __("Beds", IDXBOOST_DOMAIN_THEME_LANG); ?>:</span>
                        <?php echo $property['bed']; ?>  <label><?php
                          if($property['bed']>1){
                            echo " ".__("Beds", IDXBOOST_DOMAIN_THEME_LANG);
                          }else{
                            echo " ".__("Bed", IDXBOOST_DOMAIN_THEME_LANG);
                          } ?> </label>
                      </li>
                      <li><span>Baths:</span>
                        <?php echo $property['bath']; ?> <label>
                        <?php
                          if ($property['bath']>1) {
                            echo " ".__("Baths", IDXBOOST_DOMAIN_THEME_LANG);
                          }else{
                            echo " ".__("Bath", IDXBOOST_DOMAIN_THEME_LANG);
                          }
                          ?></label>
                      </li>
                      <li><span><?php echo __("Price", IDXBOOST_DOMAIN_THEME_LANG); ?> / Sq.Ft:</span> <?php echo number_format($property['sqft']); ?> Sq.Ft</li>
                      <li><span><?php echo __("MLS", IDXBOOST_DOMAIN_THEME_LANG); ?>:</span> <?php echo $property['mlsNum']; ?></li>
                    </ul>
                  </div>
                  */ ?>
                  <a href="<?php echo rtrim($flex_idx_info["pages"]["flex_idx_property_detail"]["guid"], "/"); ?>/<?php echo $property['slug']; ?>" class="view-item"></a>
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
<script type="text/javascript">
  var view_grid_type='';
  <?php
    $sta_view_grid_type='0'; if(array_key_exists('view_grid_type',$search_params)) $sta_view_grid_type=$search_params['view_grid_type']; ?>
  view_grid_type=<?php echo $sta_view_grid_type; ?>;
  if ( !jQuery('body').hasClass('clidxboost-ngrid') && view_grid_type==1) {
    jQuery('body').addClass('clidxboost-ngrid');
  }
</script>
