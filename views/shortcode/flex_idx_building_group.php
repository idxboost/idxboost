<?php
  global $flex_idx_info, $post, $flex_social_networks;
  
  /*
  $site_title = get_bloginfo('name');
  
  $facebook_share_url    = 'https://www.facebook.com/sharer/sharer.php';
  $facebook_share_params = http_build_query(array(
      'u'           => $building_permalink,
      'picture'     => $response['payload']['gallery_building'][0],
      'title'       => $post->post_title . ' - ' . $building_default_address,
      'caption'     => $site_title,
      'description' => $response['payload']['description_building'],
  ));
  
  $facebook_share_url .= '?' . $facebook_share_params;
  
  $agent_info_name = $flex_idx_info['agent']['agent_first_name'];
  $agent_last_name = $flex_idx_info['agent']['agent_last_name'];
  $agent_info_phone = $flex_idx_info['agent']['agent_phone_number'];
  
  ?>
<meta property="og:url"           content="<?php echo $building_permalink; ?>" />
<meta property="og:type"          content="website" />
<meta property="og:title"         content="<?php echo $post->post_title . ' - ' . $building_default_address; ?>" />
<meta property="og: "   content="<?php echo htmlspecialchars(stripslashes(addslashes($response['payload']['description_building']))); ?>" />
<meta property="og:image"         content="<?php echo $response['payload']['gallery_building'][0]; ?>" />
*/ ?>
<style>
  .flex-block-description{ margin-top: 3rem;  }
</style>
<?php if ($response['success']=== false ): ?>
<style>
  /*.flex-property-not-available { max-width: 1200px; margin-left: auto; margin-right: auto; }
  .flex-property-not-available h2 { font-size: 40px; text-align: center; margin: 40px auto; }*/
</style>
<div class="flex-property-not-available">
  <h2><?php echo __('The building Group you requested is not available.', IDXBOOST_DOMAIN_THEME_LANG); ?></h2>
</div>
<?php else: ?>
<div class="r-overlay"></div>
<?php if ($atts['type_view']=='grid') { ?>
<main class="property-details theme-3">
  <div id="full-main">
    <section class="main">
      <div class="container">
        <?php foreach ( $response as $valueBuildingGroup) { ?>
        <div class="main-content">
          <!--
            <?php if(!empty($valueBuildingGroup['name_group'])){  ?>
            <div class="property-description" id="property-description">
              <p><?php echo $valueBuildingGroup['name_group']; ?> </p>
            </div>
            <?php } ?>
            -->
          <div class="container wp-thumbs wrap-result view-grid" id="view-list">
            <div id="view_grip" class="activado">
              <ul class="result-search slider-generator">
                <?php $count_item=0;
                  if (is_array($valueBuildingGroup['data_building'])) {
                    foreach ($valueBuildingGroup['data_building'] as $value) {
                    $count_item=$count_item+1;
                    ?>
                <li class="propertie" data-counter="<?php echo $count_item; ?>">
                  <?php
                    $addressName='';
                    $adressList=unserialize($value['address']);
                    if (is_array($adressList)) { if (count($adressList) > 0) { $addressName = $adressList[0]; } } ?>
                  <div class="wrap-slider">
                    <ul>
                      <?php if ( count($value['list_gallery']) != 0  ) { ?>
                      <?php foreach ($value['list_gallery'] as $kga => $vga) { ?>
                      <?php if ($kga === 0): ?>
                      <li class="flex-slider-current"><img class="flex-lazy-image" data-original="<?php echo $vga; ?>"></li>
                      <?php else: ?>
                      <li class="flex-slider-item-hidden"><img class="flex-lazy-image" data-original="<?php echo $vga; ?>"></li>
                      <?php endif; ?>
                      <?php } ?>
                      <?php }else{ ?>
                      <li class="flex-slider-item-current"><img class="flex-lazy-image" data-original="http://idxboost.com/i/default_thumbnail.jpg"></li>
                      <?php } ?>
                    </ul>
                  </div>
                  <h3 class="title_building_name"><span><?php echo $value['name']; ?></span></h3>
                  <h3 class="title_building_address" title="<?php echo $addressName; ?>"><span><?php echo $addressName; ?></span></h3>
                  <?php
                    $args = array('post_type' => 'flex-idx-building','posts_per_page'   => 4,'no_found_rows'    => true,'suppress_filters' => false,
                        'meta_query'=> array( array( 'key' => '_flex_building_page_id','value' => $value['codBuilding'], 'compare' => '=', ) ), );
                    $query = new WP_Query( $args );
                    while ($query->have_posts()): $query->the_post(); ?>
                  <a class="view-detail" href="<?php echo get_the_permalink(); ?>" data-modal="modal_property_detail" data-position="0" rel="nofollow"><?php echo __('View detail', IDXBOOST_DOMAIN_THEME_LANG); ?></a>
                  <?php endwhile; ?>
                </li>
                <?php  } ?>
                <?php  } ?>
              </ul>
            </div>
          </div>
        </div>
        <?php } ?>
      </div>
    </section>
  </div>
  <div id="printMessageBox"><?php echo __('Please wait while we create your document', IDXBOOST_DOMAIN_THEME_LANG); ?></div>
</main>
<?php  }else{ ?>
<div class="similar-properties">
  <?php $count_item=0;
    foreach ( $response as $valueBuildingGroup) { ?>
  <div class="titpage"><?php if(!empty($valueBuildingGroup['name_group'])){  ?> <?php echo $valueBuildingGroup['name_group']; ?> <?php } ?></div>
  <?php
    if (is_array($valueBuildingGroup['data_building'])) {
      foreach ($valueBuildingGroup['data_building'] as $value) {
        $count_item=$count_item+1; ?>
  <article>
    <?php
      $args = array('post_type' => 'flex-idx-building','posts_per_page'   => 4,'no_found_rows'    => true,'suppress_filters' => false,
          'meta_query'=> array( array( 'key' => '_flex_building_page_id','value' => $value['codBuilding'], 'compare' => '=', ) ), );
      $query = new WP_Query( $args );
      while ($query->have_posts()): $query->the_post();
              $link_wp_Building=get_the_permalink();
       endwhile; ?>
    <?php
      $addressName='';
      $adressList=unserialize($value['address']);
      if (is_array($adressList)) { if (count($adressList) > 0) { $addressName = $adressList[0]; } } ?>
    <h2>
      <a href="<?php echo $link_wp_Building; ?>"><?php echo $value['name']; ?><span><?php echo $addressName; ?></span></a>
    </h2>
    <ul>
      <li class="price">$<?php echo $value['sale_min_max_price']['min']; ?> <span><span><?php echo __('to', IDXBOOST_DOMAIN_THEME_LANG); ?> </span></span> $<?php echo $value['sale_min_max_price']['max']; ?></li>
      <li class="for-sale"><span><?php echo $value['count_sale']; ?> </span><?php echo __('For Sale', IDXBOOST_DOMAIN_THEME_LANG); ?></li>
      <li class="for-rent"><span><?php echo $value['count_rental']; ?> </span><?php echo __('For Rent', IDXBOOST_DOMAIN_THEME_LANG); ?></li>
      <li class="sold"><span><?php echo $value['count_sold']; ?> </span><?php echo __('Sold', IDXBOOST_DOMAIN_THEME_LANG); ?></li>
    </ul>
    <a href="<?php echo $link_wp_Building; ?>" class="layout-img">
    <?php if ( count($value['list_gallery']) != 0  ) { ?>
    <?php foreach ($value['list_gallery'] as $kga => $vga) { ?>
    <img src="<?php echo $vga; ?>" class="lazy-img active" alt="<?php echo str_replace('# ' , '#', $rel_item['address_short']); ?>">
    <?php } }else{ ?>
    <img src="//www.idxboost.com/i/default_thumbnail.jpg" class="lazy-img active" alt="<?php echo str_replace('# ' , '#', $rel_item['address_short']); ?>">
    <?php } ?>
    </a>
  </article>
  <?php  } } } ?>
</div>
<?php  } ?>
<script type="text/javascript">
  (function ($) {
  
  $(function() {
  
    $(document).on("click", ".flex-tbl-link", function() {
      var permalink = $(this).data("permalink");
      if (permalink.length) {
        window.location.href = permalink;
      }
    });
  
      $("#sale-count-uni-cons, .flex-open-tb-sale").on("click", function() {
        if ($(this).hasClass("active-fbc")) {
          return;
        }
  
        $(".fbc-group").removeClass("active-fbc");
        $(this).addClass("active-fbc");
  
        $("#flex_tab_sale").click();
      });
      $("#rent-count-uni-cons, .flex-open-tb-rent").on("click", function() {
        if ($(this).hasClass("active-fbc")) {
          return;
        }
  
        $(".fbc-group").removeClass("active-fbc");
        $(this).addClass("active-fbc");
  
        $("#flex_tab_rent").click();
      });
      $("#sold-count-uni-cons, .flex-open-tb-sold").on("click", function() {
        if ($(this).hasClass("active-fbc")) {
          return;
        }
  
        $(".fbc-group").removeClass("active-fbc");
        $(this).addClass("active-fbc");
  
        $("#flex_tab_sold").click();
      });
  
    $( ".group-flex.tabs-btn.show-desktop li" ).click(function() {
      if ($(this).hasClass("active")) {
        return;
      }
  
      // sync aside btns
      var forTab = $(this).attr("fortab");
  
      $(".fbc-group").removeClass("active-fbc");
  
      switch(forTab) {
        case "tab_sale":
          $(".flex-open-tb-sale").addClass("active-fbc");
          break;
  
        case "tab_rent":
          $(".flex-open-tb-rent").addClass("active-fbc");
          break;
  
        case "tab_sold":
          $(".flex-open-tb-sold").addClass("active-fbc");
          break;
      }
  
      $('.group-flex.tabs-btn.show-desktop li').removeClass('active');
      $(this).addClass('active');
      $('.result-search.slider-generator').hide();
      $('.item_view_db').hide();
      $('#'+$('.group-flex.tabs-btn.show-desktop li.active').attr('fortab')).show();
      $('#'+$('.group-flex.tabs-btn.show-desktop li.active').attr('forview')).show();
    });
  
    $("#filter-views ul li" ).click(function() {
      console.log('clicked');
  
      if( $(this).text()=='Grid'){
        console.log('grid');
        $('#view_grip').removeClass('desactivo');
        $('#view_list').removeClass('desactivo');
        $('#view_grip').addClass('activado');
        $('#view_list').addClass('desactivo');
        $("#view-list").removeClass("view-list");
        $("#view-list").addClass("view-grid");
      }else{
        console.log('list');
        $('.item_view_db').hide();
        $('#'+$('.group-flex.tabs-btn.show-desktop li.active').attr('forview')).show();
        $('#view_grip').removeClass('desactivo');
        $('#view_list').removeClass('desactivo');
        $('#view_grip').addClass('desactivo');
        $('#view_list').addClass('activado');
        $("#view-list").removeClass("view-grid");
        $("#view-list").addClass("view-list");
      }
    });
  
    $('.group-flex.tabs-btn.show-desktop li:first').click();
    // $('#filter-views ul li:first').click();
    jQuery('.flex-open-tb-rent').click();
    jQuery('.flex-open-tb-sale').click();
  });
  
  })(jQuery);
</script>
<style type="text/css">
  .desactivo { display: none !important; }
  .green { color: green; }
</style>
<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.10&appId=<?php echo $flex_social_networks["facebook_social_api"]; ?>";
  fjs.parentNode.insertBefore(js, fjs);
  }(document, 'script', 'facebook-jssdk'));
</script>
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
  
  $(document).on("click", '.flex-favorite-btn', function(event) {
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
        _self.find('span').addClass('active');
  
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
                //active_modal($('#modal_add_favorities'));
  
                /*setTimeout(function() {
                    $('#modal_add_favorities').find('.close').click();
                }, 2000);*/
  
                _self.attr("data-alert-token",data.token_alert);
            }
        });
      } else {
        // remove
        _self.removeClass('flex-active-fav');
        _self.find('span').removeClass('active');
  
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
<?php endif; ?>
<script type="text/javascript">
  jQuery('body').addClass("customGroupPage <?php echo $atts['class']; ?>");
</script>
