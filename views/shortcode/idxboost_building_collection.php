<?php
global $flex_idx_info, $post, $flex_social_networks, $wp;

$wp_request = $wp->request;
$wp_request_exp = explode('/', $wp_request);

$building_permalink = get_permalink($post->ID);

$view_url=$type_view_default;

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
<style>
.flex-slider-item-hidden {
    display: none !important;
}

.flex-lazy-image {
    -webkit-transform: scale(1) !important;
    -ms-transform: scale(1) !important;
    transform: scale(1) !important;
}

.flex-property-new-listing {
    position: absolute;
    left: 10px;
    top: 10px;
    z-index: 300;
    background: rgba(0, 0, 0, 0.5);
    color: #fff;
    font-size: 13px;
    text-transform: uppercase;
    padding: 5px;
}

.create-alert-footer {
    position: relative !important;
    width: 150px !important;
    background-color: white !important;
    opacity: 1 !important;
    padding: 0px !important;
    right: 0px !important;
    font-size: 15px !important;
    left: 10px;
    top: 0px !important;
}

.view-list .flex-property-new-listing {
    display: none;
}

@media screen and (max-width: 800px) {
    div#map-actions {
        display: none;
    }
}

.result-search .wrap-slider li img {
    opacity: 0;
    transition: opacity 0.5s linear;
}

.result-search .wrap-slider li img.flex-lazy-image.loaded {
    opacity: 1;
}
</style>

<?php if ($response['success']=== false ): ?>
  <style>
  .flex-property-not-available { max-width: 1200px; margin-left: auto; margin-right: auto; }
  .flex-property-not-available h2 { font-size: 40px; text-align: center; margin: 40px auto; }
</style>
<div class="flex-property-not-available">
  <h2>The building you requested is not available.</h2>
</div>
<?php else: ?>
<script type="text/javascript">
  var idxboostCollecBuil=[];
  idxboostCollecBuil=JSON.parse('<?php echo addslashes($server_output); ?>');
</script>
  <form name="idxboost_collection_xr" class="idxboost_collection_xr" id="idxboost_collection_xr">
    <input type="hidden" name="action" value="idxboost_collection_list">
    <input type="hidden" name="building_id" value="<?php echo $atts['building_id'];?>">
  </form>
  
<div class="r-overlay"></div>
    <main class="property-details theme-3">
      <div id="full-main">
        <section class="main">
          <div class="gwr">
            <div class="container">
              <div class="property-details theme-2 r-hidden">
                <ul class="property-information idxboost-collection-property-information">
                  <?php  if (count($response['payload']['properties']['sale']['items']) > 0 && ($type_view=='sale' || $type_view=='all')) { ?>
                  <li class="sale">
                    <button id="sale-count-uni-cons"><?php echo $response['payload']['properties']['sale']['count']; ?> <span>For Sale</span></button>
                  </li>
                  <?php  } 
                  ?>
                  <?php  if (count($response['payload']['properties']['rent']['items']) > 0  && ($type_view=='rent' || $type_view=='all') ) { ?>
                  <li class="rent">
                    <button id="rent-count-uni-cons"><?php echo $response['payload']['properties']['rent']['count']; ?> <span>For Rent</span></button>
                  </li>
                  <?php  } ?>
                  <?php  if (count($response['payload']['properties']['sold']['items']) > 0 && ($type_view=='sold' || $type_view=='all') ) { ?>
                  <li class="sold">
                    <button id="sold-count-uni-cons"><?php echo $response['payload']['properties']['sold']['count'] ;?> <span>Sold</span></button>
                  </li>
                  <?php  } ?>
                </ul>
              </div>

              <div class="main-content">
                <div class="group-flex tabs-btn show-desktop idxboost-collection-show-desktop">
                  <?php  if (count($response['payload']['properties']['sale']['items']) > 0 && ($type_view=='sale' || $type_view=='all')) { ?>                  
                    <li <?php if ($active_class=='sale') echo 'class="active"'; ?> fortab="tab_sale" forview="sale_list" id="flex_tab_sale">
                      <button> <span>for sale</span></button>
                    </li>
                  <?php } ?>

                  <?php  if (count($response['payload']['properties']['rent']['items']) > 0  && ($type_view=='rent' || $type_view=='all') ) { ?>
                    <li <?php if ($active_class=='rent') echo 'class="active"'; ?>  fortab="tab_rent" forview="rent_list" id="flex_tab_rent">
                      <button> <span>For Rent</span></button>
                    </li>
                  <?php } ?>
                  
                  <?php  if (count($response['payload']['properties']['sold']['items']) > 0 && ($type_view=='sold' || $type_view=='all') ) { ?>
                  <li <?php if ($active_class=='sold') echo 'class="active"'; ?>  fortab="tab_sold" forview="sold_list" id="flex_tab_sold">
                  <li fortab="tab_sold" forview="sold_list" id="flex_tab_sold">
                    <button> <span>Sold</span></button>
                  </li>
                  <?php } ?>

                </div>

                <div class="container wp-thumbs wrap-result idxboost-type-view-wrap-result" id="view-list">
                  <div id="wrap-subfilters">
                    <div class="gwr">
                      <ul id="sub-filters">
                        <li id="link-favorites">
                          <a class="clidxboost-icon-favorite" role="button" title="Save Favorites" rel="nofollow">
                            <span><span>0</span>Favorites</span>
                          </a>
                        </li>
                        <li id="filter-by" class="clidxboost-icon-arrow-select destock-hidden idxboost_collection_filterby">
                          <select>
                            <?php if($type_building==0){ ?>
                            <?php  if (count($response['payload']['properties']['sale']['items']) > 0 && ($type_view=='sale' || $type_view=='all')) { ?>
                              <option value="sale">For Sale</option>
                            <?php } ?>
                            <?php  if (count($response['payload']['properties']['rent']['items']) > 0 && ($type_view=='rent' || $type_view=='all') ) { ?>
                              <option value="rent">For Rent</option>
                            <?php } ?>
                            <?php  if (count($response['payload']['properties']['sold']['items']) > 0 && ($type_view=='sold' || $type_view=='all') ) { ?>
                              <option value="sold">Sold</option>
                            <?php } ?>
                            <?php } ?>
                          </select>
                        </li>
                        <li class="clidxboost-icon-arrow-select idxboost_collection_filterviews <?php if ($response['payload']['modo_view'] == 2): ?>list<?php else: ?>grid<?php endif; ?>" id="filter-views">
                          <?php  if ( (count($response['payload']['properties']['sale']['items']) > 0) || (count($response['payload']['properties']['rent']['items']) > 0) || (count($response['payload']['properties']['sold']['items']) > 0) ) { ?>
                          <select>
                            <option value="grid" <?php if (empty($view_url)) { selected($response['payload']['modo_view'], 1); }else{ if ($view_url=='grid') echo "selected"; } ?> forview="view_grip"><?php echo __('Grid', IDXBOOST_DOMAIN_THEME_LANG); ?></option>
                            <option value="list" <?php if (empty($view_url)) { selected($response['payload']['modo_view'], 2); }else{ if ($view_url=='list') echo "selected"; }  ?> forview="view_list"><?php echo __('List', IDXBOOST_DOMAIN_THEME_LANG); ?></option>
                          </select>
                          <?php } ?>
                        </li>
                      </ul>
                    </div>
                  </div>

                  <div id="view_list"<?php if ($response['payload']['modo_view'] == 1): ?> class="desactivo" <?php endif; ?>>

                  <div id="rent_list" class="item_view_db idxboost_collection_rent_list">
                    <input type="hidden" value="<?php echo $countar;?>" class="count_rent_building">
                  </div>

                  <div id="sale_list" class="item_view_db idxboost_collection_sale_list">
                    <input type="hidden" value="<?php echo $countar;?>" class="count_sale_building">
                  </div>

                  <div id="sold_list" class="item_view_db idxboost_collection_sold_list">
                    <input type="hidden" value="<?php echo $countar;?>" class="count_sold_building">
                  </div>

                  </div>

                  <div id="view_grip" <?php if ($response['payload']['modo_view'] == 2): ?> class="desactivo" <?php endif; ?>>
                  <ul class="result-search slider-generator idxboost_collection_tab_sale" id="tab_sale"></ul>
                  <ul class="result-search slider-generator idxboost_collection_tab_rent" id="tab_rent"></ul>
                  <ul class="result-search slider-generator idxboost_collection_tab_sold" id="tab_sold"></ul>

                  </div>

                </div>
              </div>
            </div>
          </div>
        </section>
      </div>
    </main>
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
    idxboosttabview();
  });

  $("#filter-by select" ).change(function() {
    var forTab = $(this).val();
    console.log(forTab);
    $('#view_list').removeClass('desactivo');
    $('#view_grip').removeClass('desactivo');

    if( $("#filter-views select" ).val()=='grid'){
      $('#view_grip').addClass('activado');
      $('#view_list').addClass('desactivo');
    }else{
      $('#view_list').addClass('activado');
      $('#view_grip').addClass('desactivo');
    }
    $('.result-search').hide();
    $('.item_view_db').hide();
    $('#tab_'+forTab).show();
    $('#'+forTab+'_list').show();
    idxboosttabview();
  });

  $("#filter-views select" ).change(function() {
    console.log($(this).val());
      $('#view_list').removeClass('desactivo');
      $('#view_grip').removeClass('desactivo');
    if( $(this).val()=='grid'){
      $('#view_grip').addClass('activado');
      $('#view_list').addClass('desactivo');
      $("#view-list").removeClass("view-list");
      $("#view-list").addClass("view-grid");
    }else{
      $('.item_view_db').hide();
      $('#'+$('.group-flex.tabs-btn.show-desktop li.active').attr('forview')).show();
      $('#view_grip').addClass('desactivo');
      $('#view_list').addClass('activado');
      $("#view-list").removeClass("view-grid");
      $("#view-list").addClass("view-list");
    }
    idxboosttabview();
  });

  $(document).on('click',"#filter-views ul li",function() {
    console.log('clicked');
    console.log($(this).text());

    if( $(this).text()=='Grid'){
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
    idxboosttabview();
  });
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
}(document, 'script', 'facebook-jssdk'));</script>

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

$(document).on('ready',function(event){
  jQuery('#filter-views li.active').click();
});

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
<?php endif; ?>

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
