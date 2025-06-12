<?php
  global $flex_idx_info, $post, $flex_social_networks, $wp;
  
  $wp_request = $wp->request;
  $wp_request_exp = explode('/', $wp_request);
  
  $building_permalink = get_permalink($post->ID);
  
  if($type_view=='sale') {
    $active_class='sale';
  }else if($type_view=='rent') {
    $active_class='rent';
  }else if ($type_view=='sold') {
    $active_class='sold';
  }else{
    $active_class='sale';
  }
  $type_building = $response['payload']['type_building'];
  
  $agent_info_name = $flex_idx_info['agent']['agent_first_name'];
  $agent_last_name = $flex_idx_info['agent']['agent_last_name'];
  $agent_info_phone = $flex_idx_info['agent']['agent_contact_phone_number'];
  $logo_broker='';
?>
<script type="text/javascript">
  var idxboostCollecBuil=[];
  idxboostCollecBuil=JSON.parse('<?php echo addslashes($server_output); ?>');
</script>
<div class="ib-inventory-building cw-featured-properties">
  <div id="featured-section" class="featured-section flex-block-description">
    
    <?php  if ( !empty($atts['title']) ) { ?>
      <h3 class="ib-cw-title"><?php echo $atts['title']; ?></h3>
    <?php } ?>

    <?php  if ( !empty($atts['sub_title']) ) { ?>
      <h4 class="ib-cw-subtitle"><?php echo $atts['sub_title']; ?></h4>
    <?php } ?>

    <ul id="cw-tab-rs" class="cw-tab-list" <?php echo $text_button_style; ?> >
      <?php  if (count($response['payload']['properties']['sale']['items']) > 0 && ($atts['type']=='all' || $atts['type']=='sale' )  ) { ?>
      <li><button data-id="cw-tab-sale" class="cw-active"><span><?php echo __("Available Sales", IDXBOOST_DOMAIN_THEME_LANG); ?></span></button></li>
      <?php  } ?>
      <?php  if (count($response['payload']['properties']['rent']['items']) > 0 && ($atts['type']=='all' || $atts['type']=='rent' )) { ?>
      <li><button data-id="cw-tab-rent"><span><?php echo __("Available Rentals", IDXBOOST_DOMAIN_THEME_LANG); ?></span></button></li>
      <?php  } ?>
      <?php  if (count($response['payload']['properties']['sold']['items']) > 0 && ($atts['type']=='all' || $atts['type']=='sold' )) { ?>
      <li><button data-id="cw-tab-sold"><span><?php echo __("Available Sold", IDXBOOST_DOMAIN_THEME_LANG); ?></span></button></li>
      <?php  } ?>
    </ul>
    <div class="wrap-result view-grid">
      <?php  if ( count($response['payload']['properties']['sale']['items']) > 0 ) { ?>
        <div id="cw-tab-sale" class="cw-tab-item">
          <div class="clidxboost-properties-slider gs-container-slider result-container-slider tab-slider" id="slider-sale">
            <?php $count_item=0; 
              foreach ($response['payload']['properties']['sale']['items'] as $key => $value) {
                 $count_item=$count_item+1; ?>  
            <ul class="result-search slider-generator">
              <li class="propertie" data-id="<?php echo $value['mls_num']; ?>" data-mls="<?php echo $value['mls_num']; ?>" data-counter="<?php echo $count_item; ?>">
                <?php if ($value['status'] == 5): ?>
                <div class="flex-property-new-listing"><?php echo __('rented', IDXBOOST_DOMAIN_THEME_LANG); ?></div>
                <?php elseif($value['status'] == 2): ?>
                <div class="flex-property-new-listing"><?php echo __('sold', IDXBOOST_DOMAIN_THEME_LANG); ?></div>
                <?php elseif($value['status'] != 1): ?>
                <div class="flex-property-new-listing"><?php echo __('pending', IDXBOOST_DOMAIN_THEME_LANG); ?></div>   
                <?php elseif(isset($value['recently_listed']) && $value['recently_listed'] === 'yes'): ?>
                <div class="flex-property-new-listing"><?php echo __('new listing', IDXBOOST_DOMAIN_THEME_LANG); ?></div>
                <?php endif; ?>
                <h2 title="<?php echo $value['address_short']; ?> <?php echo $value['address_large']; ?>"><?php echo str_replace('# ', '#', $value['address_short']); ?></h2>
                <ul class="features">
                  <li class="address"><?php echo $value['address_large']; ?></li>
                  <li class="price">$<?php echo number_format($value['price']); ?></li>
                  <li class="pr down">2.05%</li>
                  <li class="beds"><?php echo $value['bed']; ?>  <span><?php echo __("Beds", IDXBOOST_DOMAIN_THEME_LANG); ?> </span></li>
                  <li class="baths"><?php echo $value['bath']; ?> <span><?php echo __("Baths", IDXBOOST_DOMAIN_THEME_LANG); ?> </span></li>
                  <li class="living-size"> <span><?php echo $value['living_size_m2']; ?></span><?php echo __("Sq.Ft.", IDXBOOST_DOMAIN_THEME_LANG); ?> <span>(452 m²)</span></li>
                  <li class="price-sf"><span>$<?php echo $value['price_sqft_m2']; ?> </span>/ <?php echo __("Sq.Ft.", IDXBOOST_DOMAIN_THEME_LANG); ?><span>($244 m²)</span></li>
                  <li class="build-year"><span><?php echo __("Built", IDXBOOST_DOMAIN_THEME_LANG); ?> </span>2015</li>
                  <li class="development"><span>Star Island Corr</span></li>
                  
                </ul>
                <div class="wrap-slider">
                  <ul>
                    <?php foreach ($value['gallery'] as $kga => $vga) { ?>
                    <?php if ($kga === 0): ?>
                    <li class="flex-slider-current"><img class="flex-lazy-image" data-original="<?php echo $vga; ?>" alt="<?php echo $value['address_short']; ?> <?php echo $value['address_large']; ?>"></li>
                    <?php else: ?>
                    <li class="flex-slider-item-hidden"><img class="flex-lazy-image" data-original="<?php echo $vga; ?>" alt="<?php echo $value['address_short']; ?> <?php echo $value['address_large']; ?>"></li>
                    <?php endif; ?>
                    <?php } ?>
                  </ul>
                  <button class="prev flex-slider-prev" aria-label="Prev"><span class="clidxboost-icon-arrow-select"></span></button>
                  <button class="next flex-slider-next" aria-label="Next"><span class="clidxboost-icon-arrow-select"></span></button>
                  <?php if ($value['is_favorite'] == 1): ?>
                  <button class="clidxboost-btn-check" aria-label="Remove Favorite"><span class="flex-favorite-btn clidxboost-icon-check clidxboost-icon-check-list active" data-alert-token="<?php echo $value['token_alert']; ?>"></span></button>
                  <?php else: ?>
                  <button class="clidxboost-btn-check" aria-label="Save Favorite"><span class="flex-favorite-btn clidxboost-icon-check clidxboost-icon-check-list"></span></button>
                  <?php endif; ?>                                                  
                </div>
                <a class="view-detail show-modal" href="<?php echo rtrim($flex_idx_info["pages"]["flex_idx_property_detail"]["guid"], "/"); ?>/<?php echo $value['slug']; ?>" data-modal="modal_property_detail" data-position="0" rel="nofollow"><?php echo __("View detail", IDXBOOST_DOMAIN_THEME_LANG); ?></a>
              </li>
            </ul>
            <?php } ?>
          </div>
          <a href="/condos-for-sale/" title="View more listings" class="clidxboost-btn-link"> <span><?php echo __("View all listings", IDXBOOST_DOMAIN_THEME_LANG); ?></span></a>
        </div>
      <?php  } ?>

      <?php  if ( count($response['payload']['properties']['rent']['items']) > 0 ) { ?>
      <div id="cw-tab-rent" class="cw-tab-item cw-hidden-ov">
        <div class="clidxboost-properties-slider gs-container-slider tab-slider" id="slider-rent">
          <?php $count_item=0; 
            foreach ($response['payload']['properties']['rent']['items'] as $key => $value) {
               $count_item=$count_item+1; ?>  
          <ul class="result-search slider-generator">
            <li class="propertie" data-id="<?php echo $value['mls_num']; ?>" data-mls="<?php echo $value['mls_num']; ?>" data-counter="<?php echo $count_item; ?>">
                <?php if ($value['status'] == 5): ?>
                <div class="flex-property-new-listing"><?php echo __('rented', IDXBOOST_DOMAIN_THEME_LANG); ?></div>
                <?php elseif($value['status'] == 2): ?>
                <div class="flex-property-new-listing"><?php echo __('sold', IDXBOOST_DOMAIN_THEME_LANG); ?></div>
                <?php elseif($value['status'] != 1): ?>
                <div class="flex-property-new-listing"><?php echo __('pending', IDXBOOST_DOMAIN_THEME_LANG); ?></div>   
                <?php elseif(isset($value['recently_listed']) && $value['recently_listed'] === 'yes'): ?>
                <div class="flex-property-new-listing"><?php echo __('new listing', IDXBOOST_DOMAIN_THEME_LANG); ?></div>
                <?php endif; ?>

              <h2 title="<?php echo $value['address_short']; ?> <?php echo $value['address_large']; ?>"><?php echo str_replace('# ', '#', $value['address_short']); ?></h2>
              <ul class="features">
                <li class="address"><?php echo $value['address_large']; ?></li>
                <li class="price">$<?php echo number_format($value['price']); ?></li>
                <li class="pr down">2.05%</li>
                <li class="beds"><?php echo $value['bed']; ?>  <span><?php echo __("Beds", IDXBOOST_DOMAIN_THEME_LANG); ?> </span></li>
                <li class="baths"><?php echo $value['bath']; ?> <span><?php echo __("Baths", IDXBOOST_DOMAIN_THEME_LANG); ?> </span></li>
                <li class="living-size"> <span><?php echo $value['living_size_m2']; ?></span><?php echo __("Sq.Ft.", IDXBOOST_DOMAIN_THEME_LANG); ?> <span>(452 m²)</span></li>
                <li class="price-sf"><span>$<?php echo $value['price_sqft_m2']; ?> </span>/ <?php echo __("Sq.Ft.", IDXBOOST_DOMAIN_THEME_LANG); ?><span>($244 m²)</span></li>
                <li class="build-year"><span><?php echo __("Built", IDXBOOST_DOMAIN_THEME_LANG); ?> </span>2015</li>
                <li class="development"><span>Star Island Corr</span></li>
                
              </ul>
              <div class="wrap-slider">
                <ul>
                  <?php foreach ($value['gallery'] as $kga => $vga) { ?>
                  <?php if ($kga === 0): ?>
                  <li class="flex-slider-current"><img class="flex-lazy-image" data-original="<?php echo $vga; ?>" alt="<?php echo $value['address_short']; ?> <?php echo $value['address_large']; ?>"></li>
                  <?php else: ?>
                  <li class="flex-slider-item-hidden"><img class="flex-lazy-image" data-original="<?php echo $vga; ?>" alt="<?php echo $value['address_short']; ?> <?php echo $value['address_large']; ?>"></li>
                  <?php endif; ?>
                  <?php } ?>
                </ul>
                <button class="prev flex-slider-prev" aria-label="Prev"><span class="clidxboost-icon-arrow-select"></span></button>
                <button class="next flex-slider-next" aria-label="Next"><span class="clidxboost-icon-arrow-select"></span></button>
                <?php if ($value['is_favorite'] == 1): ?>
                <button class="clidxboost-btn-check" aria-label="Remove Favorite"><span class="flex-favorite-btn clidxboost-icon-check clidxboost-icon-check-list active" data-alert-token="<?php echo $value['token_alert']; ?>"></span></button>
                <?php else: ?>
                <button class="clidxboost-btn-check" aria-label="Save Favorite"><span class="flex-favorite-btn clidxboost-icon-check clidxboost-icon-check-list"></span></button>
                <?php endif; ?>                                    
              </div>
              <a class="view-detail show-modal" href="<?php echo rtrim($flex_idx_info["pages"]["flex_idx_property_detail"]["guid"], "/"); ?>/<?php echo $value['slug']; ?>" data-modal="modal_property_detail" data-position="0" rel="nofollow"><?php echo __("View detail", IDXBOOST_DOMAIN_THEME_LANG); ?></a>
            </li>
          </ul>
          <?php } ?>
        </div>
        <a href="/condos-for-rent/" title="View more listings" class="clidxboost-btn-link"> <span>View all listings</span></a>
      </div>
      <?php  } ?>

      <?php  if ( count($response['payload']['properties']['sold']['items']) > 0 ) { ?>
      <div id="cw-tab-sold" class="cw-tab-item cw-hidden-ov">
        <div class="clidxboost-properties-slider gs-container-slider tab-slider" id="slider-sold">
          <?php $count_item=0; 
            foreach ($response['payload']['properties']['sold']['items'] as $key => $value) {
               $count_item=$count_item+1; ?>  
          <ul class="result-search slider-generator">
            <li class="propertie" data-id="<?php echo $value['mls_num']; ?>" data-mls="<?php echo $value['mls_num']; ?>" data-counter="<?php echo $count_item; ?>">
              <div class="flex-property-new-listing"><?php echo __('sold', IDXBOOST_DOMAIN_THEME_LANG); ?></div>
              <h2 title="<?php echo $value['address_short']; ?> <?php echo $value['address_large']; ?>"><?php echo str_replace('# ', '#', $value['address_short']); ?></h2>
              <ul class="features">
                <li class="address"><?php echo $value['address_large']; ?></li>
                <li class="price">$<?php echo number_format($value['price']); ?></li>
                <li class="pr down">2.05%</li>
                <li class="beds"><?php echo $value['bed']; ?>  <span><?php echo __("Beds", IDXBOOST_DOMAIN_THEME_LANG); ?> </span></li>
                <li class="baths"><?php echo $value['bath']; ?> <span><?php echo __("Baths", IDXBOOST_DOMAIN_THEME_LANG); ?> </span></li>
                <li class="living-size"> <span><?php echo $value['living_size_m2']; ?></span><?php echo __("Sq.Ft.", IDXBOOST_DOMAIN_THEME_LANG); ?> <span>(452 m²)</span></li>
                <li class="price-sf"><span>$<?php echo $value['price_sqft_m2']; ?> </span>/ <?php echo __("Sq.Ft.", IDXBOOST_DOMAIN_THEME_LANG); ?><span>($244 m²)</span></li>
                <li class="build-year"><span><?php echo __("Built", IDXBOOST_DOMAIN_THEME_LANG); ?> </span>2015</li>
                <li class="development"><span>Star Island Corr</span></li>
              </ul>
              <div class="wrap-slider">
                <ul>
                  <?php foreach ($value['gallery'] as $kga => $vga) { ?>
                  <?php if ($kga === 0): ?>
                  <li class="flex-slider-current"><img class="flex-lazy-image" data-original="<?php echo $vga; ?>" alt="<?php echo $value['address_short']; ?> <?php echo $value['address_large']; ?>"></li>
                  <?php else: ?>
                  <li class="flex-slider-item-hidden"><img class="flex-lazy-image" data-original="<?php echo $vga; ?>" alt="<?php echo $value['address_short']; ?> <?php echo $value['address_large']; ?>"></li>
                  <?php endif; ?>
                  <?php } ?>
                </ul>
                <button class="prev flex-slider-prev" aria-label="Prev"><span class="clidxboost-icon-arrow-select"></span></button>
                <button class="next flex-slider-next" aria-label="Next"><span class="clidxboost-icon-arrow-select"></span></button>                                 
              </div>
              <a class="view-detail show-modal" href="<?php echo rtrim($flex_idx_info["pages"]["flex_idx_property_detail"]["guid"], "/"); ?>/sold-<?php echo $value['slug']; ?>" data-modal="modal_property_detail" data-position="0" rel="nofollow"><?php echo __("View detail", IDXBOOST_DOMAIN_THEME_LANG); ?></a>
            </li>
          </ul>
          <?php } ?>
        </div>
        <a role="button" title="View more listings" class="clidxboost-btn-link"> <span><?php echo __("View all listings", IDXBOOST_DOMAIN_THEME_LANG); ?></span></a>
      </div>
      <?php  } ?>
    </div>
  </div>
</div>
<script type="text/javascript">
  (function($) {
      var $tabRentSale = jQuery("#cw-tab-rs");
      if ($tabRentSale.length) {
        jQuery(document).on('click', '#cw-tab-rs button', function() {
          $tabRentSale.find('button').removeClass('cw-active');
          jQuery(this).addClass('cw-active');
          /*Obtenemos los valores a mostrar*/
          var $showTab = jQuery(this).attr('data-id');
          jQuery(".cw-featured-properties .cw-tab-item").addClass('cw-hidden cw-hidden-ov');
          jQuery("#"+$showTab).removeClass('cw-hidden cw-hidden-ov');

          jQuery('.tab-slider').find(".flex-slider-current img").each(function() {
            var dataImage = jQuery(this).attr('data-original');
            jQuery(this).attr('src',dataImage).addClass('initial loaded');
          });
        });
      };
  
      /*jQuery('.tab-slider').greatSlider({
        type: 'swipe',
        nav: true,
        navSpeed: 500,
        lazyLoad: true,
        bullets: false,
        items: 1,
        layout: {
          bulletDefaultStyles: false
        },
        breakPoints: {
          640: {
            items: 2,
            nav: true,
            bullets: false
          },
          991: {
            items: 3,
            nav: false,
            bullets: true
          },
          1360: {
            items: 4,
            nav: false,
            bullets: true
          }
        },
        onStepStart: function(){
          jQuery('.tab-slider').find(".flex-slider-current img").each(function() {
            var dataImage = jQuery(this).attr('data-original');
            jQuery(this).attr('src',dataImage);
          });
        }
      });*/
  
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
  
  $('.tab-slider').on("click", '.flex-favorite-btn', function(event) {
    event.stopPropagation();
  
    var _self = $(this);
  
    if (__flex_g_settings.anonymous === 'yes') {
      //active_modal($('#modal_login'));
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
      var mls_num = _self.parent().parent().data("mls");
  
      if (!_self.hasClass('flex-active-fav')) { // add
        _self.addClass('flex-active-fav');
        _self.addClass('active');
  
        $.ajax({
            url: __flex_g_settings.ajaxUrl,
            method: "POST",
            data: {
                action: "flex_favorite",
                mls_num: mls_num,
                type_action: 'add'
            },
            dataType: "json",
            success: function(data) {
                _self.attr("data-alert-token",data.token_alert);
            }
        });
      } else {
        // remove
        _self.removeClass('flex-active-fav');
        _self.removeClass('active');
  
        var token_alert = _self.attr("data-alert-token");
  
        $.ajax({
            url: __flex_g_settings.ajaxUrl,
            method: "POST",
            data: {
                action: "flex_favorite",
                mls_num: mls_num,
                type_action: 'remove',
                token_alert: token_alert
            },
            dataType: "json",
            success: function(data) {
                _self.removeAttr('data-alert-token');
            }
        });
      }
    }
  });
  
    $(".flex_b_mark_f").on("click", function(event) {
      event.stopPropagation();
      event.preventDefault();
  
      if (flex_idx_filter_params.anonymous === "yes") {
        //active_modal($('#modal_login'));
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
          $(this).find("span").removeClass("active").html("SAVE FAVORITE");
  
          console.log('remove building from favorites');
  
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
          $(this).find("span").addClass("active").html("REMOVE FAVORITE");
  
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
<script type="text/javascript">
  var view_grid_type='';
  jQuery('body').addClass('buildingPage');
  <?php
    $sta_view_grid_type='0'; if(array_key_exists('view_grid_type',$search_params)) $sta_view_grid_type=$search_params['view_grid_type']; ?>
  view_grid_type=<?php echo $sta_view_grid_type; ?>;
  if ( !jQuery('body').hasClass('clidxboost-ngrid') && view_grid_type==1) {
    jQuery('body').addClass('clidxboost-ngrid');
  }
</script>
