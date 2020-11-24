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
              <li>
                <a href="<?php echo $flex_idx_info['pages']['flex_idx_saved_searches']['guid']; ?>">
                  <span><?php echo $flex_idx_info['pages']['flex_idx_saved_searches']['post_title']; ?></span>
                </a>
              </li>
              <li class="clidxboost-active">
                <a href="<?php echo $flex_idx_info['pages']['flex_idx_saved_buildings']['guid']; ?>">
                  <span><?php echo $flex_idx_info['pages']['flex_idx_saved_buildings']['post_title']; ?></span>
                </a>
              </li>
            </ul>
          </div>
        </div>
         <div class="default-body-tab">
            <div id="tab-saved-builing" class="default-item-tab active">
               <div class="header-title-profile">
                  <h2 class="title-profile"><?php echo __('My Saved Buildings', IDXBOOST_DOMAIN_THEME_LANG); ?> (<?php echo number_format(isset($response['count']) ? $response["count"] : 0); ?>)</h2>
               </div>
              <?php //if (empty($saved_searches)): ?>
              <?php if (!isset($response['success']) || (isset($response['items']) && empty($response['items']))): ?>

              <div class="message-alert idx_color_primary flex-not-logged-in-msg" id="box_flex_alerts_msg">
                <p><?php echo __("You don't have any saved building.", IDXBOOST_DOMAIN_THEME_LANG); ?></p>
              </div>

              <?php else: ?>
                <div id="saved-building" class="flex-table">
                  <div class="flex-table-row table-header">
                    <div class="flex-table-row-item fwrap"><?php echo __('Building Name', IDXBOOST_DOMAIN_THEME_LANG); ?></div>
                    <div class="flex-table-row-item text-center"><?php echo __('Building Address', IDXBOOST_DOMAIN_THEME_LANG); ?></div>
                    <div class="flex-table-row-item text-center"><?php echo __('Year Built', IDXBOOST_DOMAIN_THEME_LANG); ?></div>
                    <div class="flex-table-row-item text-center"><?php echo __('Total Units', IDXBOOST_DOMAIN_THEME_LANG); ?></div>
                    <div class="flex-table-row-item text-center"><?php echo __('Date Saved', IDXBOOST_DOMAIN_THEME_LANG); ?></div>
                    <div class="flex-table-row-item select-action text-center"><?php echo __('Action', IDXBOOST_DOMAIN_THEME_LANG); ?></div>
                  </div>
                  <?php foreach ($response['items'] as $property):
                    $property_address = unserialize($property['address']);
                    $property_address = isset($property_address[0]) ? $property_address[0] : '';
                  ?>
                  <div class="flex-table-row flex-body" data-building-id="<?php echo $property['codBuilding']; ?>">
                    <div class="flex-table-row-item fwrap">
                      <div class="info-sub-item">
                        <div class="info-a">
                          <div class="content-img">
                            <img src="<?php echo $property['thumbnail']; ?>" alt="<?php echo $property['addressShort']; ?>">
                          </div>
                        </div>
                        <div class="info-b">
                          <h3 class="info-b-title"><?php echo $property['name']; ?></h2>
                          <div class="action-info-b">
                            <button class="clidxboost-btn-show"><span class="s1"><?php echo __('View more', IDXBOOST_DOMAIN_THEME_LANG); ?></span><span class="s2"><?php echo __('Less', IDXBOOST_DOMAIN_THEME_LANG); ?></span></button>
                            <button data-building-id="<?php echo $property['codBuilding']; ?>" class="clidxboost-btn-remove dgt-remove-favorite"> <span><?php echo __('Remove', IDXBOOST_DOMAIN_THEME_LANG); ?></span></button>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="flex-table-row-item text-center"><?php echo $property_address; ?></div>
                    <div class="flex-table-row-item text-center"><?php echo $property['year']; ?></div>
                    <div class="flex-table-row-item text-center"><?php echo $property['unitBuilding']; ?></div>
                    <div class="flex-table-row-item text-center"><?php echo date('m/d/Y', strtotime($property['created_at']['date'])); ?></div>
                    <div class="flex-table-row-item select-action text-center">
                      <button data-building-id="<?php echo $property['codBuilding']; ?>" class="clidxboost-btn-remove dgt-remove-favorite">
                        <span><?php echo __('Remove', IDXBOOST_DOMAIN_THEME_LANG); ?></span>
                      </button>
                    </div>
                    <?php /*
                    <div class="hiddenInformation">
                      <ul>
                        <li><span><?php echo __('Building Address', IDXBOOST_DOMAIN_THEME_LANG); ?>:</span> <?php echo $property_address; ?></li>
                        <li><span><?php echo __('Year Built', IDXBOOST_DOMAIN_THEME_LANG); ?>:</span> <?php echo $property['year']; ?></li>
                        <li><span><?php echo __('Total Units', IDXBOOST_DOMAIN_THEME_LANG); ?>:</span> <?php echo $property['unitBuilding']; ?></li>
                        <li><span><?php echo __('Date Saved', IDXBOOST_DOMAIN_THEME_LANG); ?>:</span> <?php echo date('m/d/Y', strtotime($property['created_at']['date'])); ?></li>
                      </ul>
                    </div>
                    */ ?>
                    <a href="<?php echo empty($property['permalink']) ? '#' : $property['permalink']; ?>" class="view-item"></a>
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
