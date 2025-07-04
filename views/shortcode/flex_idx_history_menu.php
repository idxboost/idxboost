<div class="ms-history-menu-wrap-profile-btn" id="ib-lead-history-menu-btn" style="display:none;">
  <button class="ms-history-menu-btn-profile js-open-history-menu" aria-label="Show profile">
    <span class="ib-lead-first-letter-name">&nbsp;</span>
  </button>
  <div class="msn-bubble" id="ib-lead-history-tooltip-help" style="display:none;">
    <h4><?php echo __("Thank you for registering!", IDXBOOST_DOMAIN_THEME_LANG); ?></h4>
    <p><?php echo __("Now you can look at your favorites and viewed listings from your", IDXBOOST_DOMAIN_THEME_LANG); ?> <span><?php echo __("personalized experience view", IDXBOOST_DOMAIN_THEME_LANG); ?></span></p>
    <a role="button" class="ms-history-menu-btn-bubble ib-lead-hide-bubble-exp"><?php echo __("Got it, thanks!", IDXBOOST_DOMAIN_THEME_LANG); ?></a>
  </div>
</div>

<div class="ms-history-menu-profile-menu">
  <div class="ms-history-menu-header-center">
    <button class="ms-history-menu-btn-back idx-icon-arrow-select" aria-label="<?php echo __('Close Menu', IDXBOOST_DOMAIN_THEME_LANG); ?>"></button>
    <div class="ms-history-menu-btn-profile">
      <span class="ib-lead-first-letter-name"></span>
    </div>
    <div class="ms-history-menu-wrap-name">
      <span class="ms-history-menu-title ib-lead-fullname"></span>
      <a rel="nofollow" href="<?php echo $flex_idx_info["pages"]["flex_idx_profile"]["guid"]; ?>" class="ms-history-menu-btn-edit idx-icon-edit-element" aria-label="<?php echo __('My Profile', IDXBOOST_DOMAIN_THEME_LANG); ?>"></a>
    </div>
    <div class="ms-history-menu-wrapper-back-logout">
      <i class="idx-icon-logout-exit"></i>
      <a role="button" class="flex-logout-link"><?php echo __('Logout', IDXBOOST_DOMAIN_THEME_LANG); ?></a>
    </div>
  </div>

  <div class="ms-history-menu-wrapper-scroll">
    <div class="ms-history-menu-header-agent">
      <div class="ms-history-menu-wrap-detail">
        <div class="ms-history-menu-wrapper-agent-info">
          <div class="ms-history-menu-info-agent">
            <div class="ms-history-menu-title ib-lead-firstname"></div>
            <p><?php echo __("Call us if you need immediate assistance. Thanks!", IDXBOOST_DOMAIN_THEME_LANG); ?></p>
          </div>
          <div class="ms-history-menu-wrap-img ib-agent-photo-thumbnail-wrapper"></div>
        </div>
        <div class="ms-history-menu-wrap-action">
          <a href="/" class="ms-history-menu-phone ib-agent-phonenumber"><?php echo __('Call Now', IDXBOOST_DOMAIN_THEME_LANG); ?></a>
          <a href="/" class="ms-history-menu-email ib-agent-emailaddress"><?php echo __('Send Message', IDXBOOST_DOMAIN_THEME_LANG); ?></a>
        </div>
      </div>
    </div>

    <div class="ms-history-menu-header-tab" id="_ib_lead_activity_tab">
      <button class="ms-history-menu-tab ms-history-menu-tab-history active" data-tab="history" aria-label="<?php echo __("History", IDXBOOST_DOMAIN_THEME_LANG); ?>"><span><?php echo __("History", IDXBOOST_DOMAIN_THEME_LANG); ?></span></button>
      <button class="ms-history-menu-tab ms-history-menu-tab-favorites" data-tab="favorites" aria-label="<?php echo __("Favorites", IDXBOOST_DOMAIN_THEME_LANG); ?>"><span><?php echo __("Favorites", IDXBOOST_DOMAIN_THEME_LANG); ?></span></button>
      <button class="ms-history-menu-tab ms-history-menu-tab-searches" data-tab="searches" aria-label="<?php echo __("Saved Searches", IDXBOOST_DOMAIN_THEME_LANG); ?>"><span><?php echo __("Saved Searches", IDXBOOST_DOMAIN_THEME_LANG); ?></span></button>
    </div>

    <div class="ms-history-menu-wrap-tab">
      <div class="ms-history-menu-profile-list">
        <div class="ms-history-menu-body-tab">
          <div class="ms-history-menu-wrap-items" id="_ib_lead_activity_rows"></div>
        </div>
      </div>
    </div>
  </div>

  <div class="ms-history-menu-footer-tab" id="_pagination_wrapper">
    <div class="ib-cpagination">
      <nav class="ib-wpagination ib-pagination-ctrl2" id="_ib_lead_activity_pagination" aria-label="Pagination"></nav>
    </div>
  </div>
</div>

<script>
(function ($) {
  $(function() {

    $(document).on('click', '.js-open-history-menu', function () {
      $("body").addClass("openHistoryMenu");
    });

      $(document).on('click', '.ms-history-menu-btn-back', function () {
        $("body").removeClass("openHistoryMenu");
      });

  	//show modal edit search
    $(document).on('click', '.js-edit-mds', function () {
      document.getElementById("ib-check-price-change-edit").checked = false;
      document.getElementById("ib-check-new-listing-edit").checked = false;
      document.getElementById("ib-check-status-change-edit").checked = false;

      var vtypenotify=$(this).attr("data-typeno").split(",");
      $("#ib-fsearch-edit-modal").addClass("ib-md-active");
      $("#ib-mgwselect-edit").val($(this).attr("data-interval"));
      $(".token_alert_update_criterial").val( $(this).attr("data-token-alert") );
      
      if( vtypenotify.includes("new_listing") ){
        document.getElementById("ib-check-new-listing-edit").checked = true;
      }

      if( vtypenotify.includes("status_change") ){
        document.getElementById("ib-check-status-change-edit").checked = true;
      }

      if( vtypenotify.includes("price_change") ){
        document.getElementById("ib-check-price-change-edit").checked = true;
      }

    });

      $(".flex-edit-search-modals").submit(function(event){
        event.preventDefault();
        $.ajax({
          url: __flex_g_settings.ajaxUrl,
          method: "POST",
          data: $(this).serialize(),
          dataType: "json",
          success: function (data) {
            console.log(data);
            if (data.status) {
              $(".ms-history-menu-tab-searches").click();
              $('#modal_properties_send .body_md .ico_ok').text(data.message);
              active_modal($('#modal_properties_send'));
            }
          }
        });
      });

    //Close modal edit search
    $(document).on('click', '.js-close-mds', function () {
      $("#ib-fsearch-edit-modal").removeClass("ib-md-active");
    });
    
    // for switch tabs (history, favorites, searches)
    $("#_ib_lead_activity_tab").on("click", "button", function() {
      // if ($(this).hasClass("active")) {
      //   return;
      // }

      $(this).parent().find("button").removeClass("active");
      $(this).addClass("active");

        if ($(this).hasClass("ms-history-menu-tab-history")) {
          //alert("load listing views");
          if (jQuery("#ib-lead-history-menu-btn").length) {
            jQuery.ajax({
              url :__flex_g_settings.fetchLeadActivitiesEndpoint,
              method: "POST",
              data: {
                access_token: __flex_g_settings.accessToken,
                flex_credentials: Cookies.get("ib_lead_token"),
                paging: "listing_views",
                page: 1
              },
              dataType: "json",
              success: function(response) {
                // fill activity lead
                jQuery("#_ib_lead_activity_rows").empty();
                jQuery("#_ib_lead_activity_pagination").empty();

              if (response.lead_info.listing_views.length) {
                var lead_listing_views = response.lead_info.listing_views;
                var lead_listing_views_html = [];

                  for (var i = 0, l = lead_listing_views.length; i < l; i++) {
                    lead_listing_views_html.push('<div class="ms-history-menu-item">');
                    lead_listing_views_html.push('<div class="ms-history-menu-wrap-img">');
                    lead_listing_views_html.push('<img src="'+lead_listing_views[i].thumbnail+'" alt="'+lead_listing_views[i].address_short+'">');
                    lead_listing_views_html.push('</div>');
                    lead_listing_views_html.push('<div class="ms-history-menu-property-detail">');
                    lead_listing_views_html.push('<h3 class="ms-history-menu-title">'+lead_listing_views[i].address_short+'</h3>');
                    lead_listing_views_html.push('<h4 class="ms-history-menu-address">'+lead_listing_views[i].address_large+'</h4>');
                    lead_listing_views_html.push('<h5 class="ms-history-menu-price">'+lead_listing_views[i].price+'</h5>');
                    lead_listing_views_html.push('<div class="ms-history-menu-details">');
                      lead_listing_views_html.push('<span>'+lead_listing_views[i].bed+' '+word_translate.beds+'</span>');
                      lead_listing_views_html.push('<span>'+lead_listing_views[i].bath+' '+word_translate.baths+'</span>');
                      lead_listing_views_html.push('<span>'+lead_listing_views[i].sqft+' '+word_translate.sqft+'</span>');
                    lead_listing_views_html.push('</div>');
                    lead_listing_views_html.push('</div>');
                    //console.log(lead_listing_views[i].mls_num);
                    lead_listing_views_html.push('<div class="ms-history-menu-property-actions">');
                    lead_listing_views_html.push('<button data-mls="'+lead_listing_views[i].mls_num+'" class="ib-la-hp ms-history-menu-delete" aria-label="Delete"><span>'+word_translate.delete+'</span></button>');
                    lead_listing_views_html.push('</div>');
                    //lead_listing_views_html.push('<div class="ms-history-menu-property-actions">');
                    //lead_listing_views_html.push('<button class="ms-history-menu-save"><span>save</span></button>');
                    //lead_listing_views_html.push('<button class="ms-history-menu-delete"><span>Delete</span></button>');
                    //lead_listing_views_html.push('</div>');
                    lead_listing_views_html.push('<a href="'+__flex_g_settings.propertyDetailPermalink+'/'+lead_listing_views[i].slug+'" target="_blank" class="ms-history-menu-link">'+lead_listing_views[i].address_short + ' ' +  lead_listing_views[i].address_large +'</a>');
                    lead_listing_views_html.push('</div>');
                  }

                jQuery("#_ib_lead_activity_rows").html(lead_listing_views_html.join(""));
              }

              // build pagination
              if (response.lead_info.hasOwnProperty('listing_views_pagination')) {
              if (response.lead_info.listing_views_pagination.total_pages > 1) {
                var lead_listing_views_paging = [];

                if (response.lead_info.listing_views_pagination.has_prev_page) {
                  lead_listing_views_paging.push('<a class="ib-pagprev ib-paggo" data-page="'+(response.lead_info.listing_views_pagination.current_page - 1 )+'" role="button"></a>');
                }

                lead_listing_views_paging.push('<div class="ib-paglinks">');

                var lead_listing_views_page_range = response.lead_info.listing_views_pagination.page_range_links;

                for (var i = 0, l =  lead_listing_views_page_range.length; i < l; i++) {
                  if (lead_listing_views_page_range[i] == response.lead_info.listing_views_pagination.current_page) {
                    lead_listing_views_paging.push('<a class="ib-plitem ib-plitem-active" data-page="'+lead_listing_views_page_range[i]+'" role="button">'+lead_listing_views_page_range[i]+'</a>');
                  } else {
                    lead_listing_views_paging.push('<a class="ib-plitem" data-page="'+lead_listing_views_page_range[i]+'" role="button">'+lead_listing_views_page_range[i]+'</a>');
                  }
                }

                lead_listing_views_paging.push('</div>');

                if (response.lead_info.listing_views_pagination.has_next_page) {
                  lead_listing_views_paging.push('<a class="ib-pagnext ib-paggo" data-page="'+(response.lead_info.listing_views_pagination.current_page + 1 )+'" role="button"></a>');
                }

                  jQuery("#_ib_lead_activity_pagination").html('<div class="ms-history-menu-wrapper-pagination">'+lead_listing_views_paging.join("")+'</div>');
                }
              }
              }
            });
          }
        }

        if ($(this).hasClass("ms-history-menu-tab-favorites")) {
          //alert("load saved favorites");
          if (jQuery("#ib-lead-history-menu-btn").length) {
            jQuery.ajax({
              url :__flex_g_settings.fetchLeadActivitiesEndpoint,
              method: "POST",
              data: {
                access_token: __flex_g_settings.accessToken,
                flex_credentials: Cookies.get("ib_lead_token"),
                paging: "saved_listings",
                page: 1
              },
              dataType: "json",
              success: function(response) {
                // fill activity lead
                jQuery("#_ib_lead_activity_rows").empty();
                jQuery("#_ib_lead_activity_pagination").empty();

              if (response.lead_info.saved_listings.length) {
                var lead_listing_views = response.lead_info.saved_listings;
                var lead_listing_views_html = [];

                  for (var i = 0, l = lead_listing_views.length; i < l; i++) {
                    lead_listing_views_html.push('<div class="ms-history-menu-item">');
                    lead_listing_views_html.push('<div class="ms-history-menu-wrap-img">');
                    lead_listing_views_html.push('<img src="'+lead_listing_views[i].thumbnail+'" alt="'+lead_listing_views[i].address_short+'">');
                    lead_listing_views_html.push('</div>');
                    lead_listing_views_html.push('<div class="ms-history-menu-property-detail">');
                    lead_listing_views_html.push('<h3 class="ms-history-menu-title">'+lead_listing_views[i].address_short+'</h3>');
                    lead_listing_views_html.push('<h4 class="ms-history-menu-address">'+lead_listing_views[i].address_large+'</h4>');
                    lead_listing_views_html.push('<h5 class="ms-history-menu-price">'+lead_listing_views[i].price+'</h5>');
                    lead_listing_views_html.push('<div class="ms-history-menu-details">');
                      lead_listing_views_html.push('<span>'+lead_listing_views[i].bed+' '+word_translate.beds+'</span>');
                      lead_listing_views_html.push('<span>'+lead_listing_views[i].bath+' '+word_translate.baths+'</span>');
                      lead_listing_views_html.push('<span>'+lead_listing_views[i].sqft+' '+word_translate.sqft+'</span>');
                    lead_listing_views_html.push('</div>');
                    lead_listing_views_html.push('</div>');
                    lead_listing_views_html.push('<div class="ms-history-menu-property-actions">'); 
                    lead_listing_views_html.push('<button data-mls="'+lead_listing_views[i].mls_num+'" data-token-alert="'+lead_listing_views[i].token_alert+'" class="ib-la-rf ms-history-menu-delete active" aria-label="'+word_translate.save+'"><span>'+word_translate.save+'</span></button>');
                    // lead_listing_views_html.push('<button class="ms-history-menu-delete"><span>Delete</span></button>');
                    lead_listing_views_html.push('</div>');
                    lead_listing_views_html.push('<a href="'+__flex_g_settings.propertyDetailPermalink+'/'+lead_listing_views[i].slug+'" target="_blank" class="ms-history-menu-link">'+lead_listing_views[i].address_short + ' ' +  lead_listing_views[i].address_large +'</a>');
                    lead_listing_views_html.push('</div>');
                  }

                jQuery("#_ib_lead_activity_rows").html(lead_listing_views_html.join(""));
              }

              // build pagination
              if (response.lead_info.hasOwnProperty('saved_listings_pagination')) {
              if (response.lead_info.saved_listings_pagination.total_pages > 1) {
                var lead_listing_views_paging = [];

                if (response.lead_info.saved_listings_pagination.has_prev_page) {
                  lead_listing_views_paging.push('<a class="ib-pagprev ib-paggo" data-page="'+(response.lead_info.saved_listings_pagination.current_page - 1 )+'" role="button"></a>');
                }

                lead_listing_views_paging.push('<div class="ib-paglinks">');

                var lead_listing_views_page_range = response.lead_info.saved_listings_pagination.page_range_links;

                for (var i = 0, l =  lead_listing_views_page_range.length; i < l; i++) {
                  if (lead_listing_views_page_range[i] == response.lead_info.saved_listings_pagination.current_page) {
                    lead_listing_views_paging.push('<a class="ib-plitem ib-plitem-active" data-page="'+lead_listing_views_page_range[i]+'" role="button">'+lead_listing_views_page_range[i]+'</a>');
                  } else {
                    lead_listing_views_paging.push('<a class="ib-plitem" data-page="'+lead_listing_views_page_range[i]+'" role="button">'+lead_listing_views_page_range[i]+'</a>');
                  }
                }

                lead_listing_views_paging.push('</div>');

                if (response.lead_info.saved_listings_pagination.has_next_page) {
                  lead_listing_views_paging.push('<a class="ib-pagnext ib-paggo" data-page="'+(response.lead_info.saved_listings_pagination.current_page + 1 )+'" role="button"></a>');
                }

                  jQuery("#_ib_lead_activity_pagination").html('<div class="ms-history-menu-wrapper-pagination">'+lead_listing_views_paging.join("")+'</div>');
                }
              }
              }
            });
          }
        }

        if ($(this).hasClass("ms-history-menu-tab-searches")) {
          //alert("load saved searches");
          if (jQuery("#ib-lead-history-menu-btn").length) {
            jQuery.ajax({
              url :__flex_g_settings.fetchLeadActivitiesEndpoint,
              method: "POST",
              data: {
                access_token: __flex_g_settings.accessToken,
                flex_credentials: Cookies.get("ib_lead_token"),
                paging: "saved_searches",
                page: 1
              },
              dataType: "json",
              success: function(response) {
                // fill activity lead
                jQuery("#_ib_lead_activity_rows").empty();
                jQuery("#_ib_lead_activity_pagination").empty();

              if (response.lead_info.saved_searches.length) {
                var lead_listing_views = response.lead_info.saved_searches;
                var lead_listing_views_html = [];

                  for (var i = 0, l = lead_listing_views.length; i < l; i++) {
                    lead_listing_views_html.push('<div class="ms-history-menu-item ms-history-menu-condo -align-st">');
                    lead_listing_views_html.push('<div class="ms-history-menu-wrap-img">');
                    lead_listing_views_html.push('<span class="ms-history-menu-count">'+formatShortPriceX(lead_listing_views[i].search_count)+'</span> <span class="ms-history-menu-listing">'+word_translate.listings+'</span>');
                    lead_listing_views_html.push('</div>');
                    lead_listing_views_html.push('<div class="ms-history-menu-property-detail">');
                    lead_listing_views_html.push('<h3 class="ms-history-menu-title">'+lead_listing_views[i].name+'</h3>');
                    lead_listing_views_html.push('<h4 class="ms-history-menu-date">'+word_translate.saved_on+' '+lead_listing_views[i].f_date+'</h4>');
                    lead_listing_views_html.push('<span class="ms-history-menu-note">'+lead_listing_views[i].interval_name+' - '+lead_listing_views[i].notification_types+'.</span>');
                    lead_listing_views_html.push('</div>');
                    lead_listing_views_html.push('<div class="ms-history-menu-property-actions -flex">');
                    lead_listing_views_html.push('<button data-id="'+lead_listing_views[i].id+'" data-token-alert="'+lead_listing_views[i].token_alert+'" class="ms-history-menu-edit js-edit-mds" data-interval="'+lead_listing_views[i].alert_interval+'" data-typeno="'+lead_listing_views[i].alert_notification_types+'"  aria-label="'+word_translate.edit+'"><span>'+word_translate.edit+'</span></button>');
                    lead_listing_views_html.push('<button data-id="'+lead_listing_views[i].id+'" data-token-alert="'+lead_listing_views[i].token_alert+'" class="ib-la-rss ms-history-menu-delete" aria-label="'+word_translate.delete+'"><span>'+word_translate.delete+'</span></button>');
                    lead_listing_views_html.push('</div>');
                    lead_listing_views_html.push('<a href="'+lead_listing_views[i].search_url+'" target="_blank" class="ms-history-menu-link">'+lead_listing_views[i].name +'</a>');
                    lead_listing_views_html.push('</div>');
                  }

                jQuery("#_ib_lead_activity_rows").html(lead_listing_views_html.join(""));
              }

              // build pagination
              if (response.lead_info.hasOwnProperty('saved_searches_pagination')) {
              if (response.lead_info.saved_searches_pagination.total_pages > 1) {
                var lead_listing_views_paging = [];

                if (response.lead_info.saved_searches_pagination.has_prev_page) {
                  lead_listing_views_paging.push('<a class="ib-pagprev ib-paggo" data-page="'+(response.lead_info.saved_searches_pagination.current_page - 1 )+'" role="button"></a>');
                }

                lead_listing_views_paging.push('<div class="ib-paglinks">');

                var lead_listing_views_page_range = response.lead_info.saved_searches_pagination.page_range_links;

                for (var i = 0, l =  lead_listing_views_page_range.length; i < l; i++) {
                  if (lead_listing_views_page_range[i] == response.lead_info.saved_searches_pagination.current_page) {
                    lead_listing_views_paging.push('<a class="ib-plitem ib-plitem-active" data-page="'+lead_listing_views_page_range[i]+'" role="button">'+lead_listing_views_page_range[i]+'</a>');
                  } else {
                    lead_listing_views_paging.push('<a class="ib-plitem" data-page="'+lead_listing_views_page_range[i]+'" role="button">'+lead_listing_views_page_range[i]+'</a>');
                  }
                }

                lead_listing_views_paging.push('</div>');

                if (response.lead_info.saved_searches_pagination.has_next_page) {
                  lead_listing_views_paging.push('<a class="ib-pagnext ib-paggo" data-page="'+(response.lead_info.saved_searches_pagination.current_page + 1 )+'" role="button"></a>');
                }

                  jQuery("#_ib_lead_activity_pagination").html('<div class="ms-history-menu-wrapper-pagination">'+lead_listing_views_paging.join("")+'</div>');
                }
              }
              }
            });
          }
        }
      });

    // for pagination
    $("#_ib_lead_activity_pagination").on("click", "a", function() {
      if ($(this).hasClass("ib-plitem-activ")) {
        return;
      }

      var tab_active = $("#_ib_lead_activity_tab").find("button.active:eq(0)").data("tab");
      var new_page = $(this).data("page");

      console.log(tab_active);
      console.log(new_page);

      switch(tab_active) {
        case "favorites":
        if (jQuery("#ib-lead-history-menu-btn").length) {
          jQuery.ajax({
            url :__flex_g_settings.fetchLeadActivitiesEndpoint,
            method: "POST",
            data: {
              access_token: __flex_g_settings.accessToken,
              flex_credentials: Cookies.get("ib_lead_token"),
              paging: "saved_listings",
              page: new_page
            },
            dataType: "json",
            success: function(response) {
              // fill activity lead
              jQuery("#_ib_lead_activity_rows").empty();
              jQuery("#_ib_lead_activity_pagination").empty();

              if (response.lead_info.saved_listings.length) {
                var lead_listing_views = response.lead_info.saved_listings;
                var lead_listing_views_html = [];

                  for (var i = 0, l = lead_listing_views.length; i < l; i++) {
                    lead_listing_views_html.push('<div class="ms-history-menu-item">');
                    lead_listing_views_html.push('<div class="ms-history-menu-wrap-img">');
                    lead_listing_views_html.push('<img src="'+lead_listing_views[i].thumbnail+'" alt="'+lead_listing_views[i].address_short+'">');
                    lead_listing_views_html.push('</div>');
                    lead_listing_views_html.push('<div class="ms-history-menu-property-detail">');
                    lead_listing_views_html.push('<h3 class="ms-history-menu-title">'+lead_listing_views[i].address_short+'</h3>');
                    lead_listing_views_html.push('<h4 class="ms-history-menu-address">'+lead_listing_views[i].address_large+'</h4>');
                    lead_listing_views_html.push('<h5 class="ms-history-menu-price">'+lead_listing_views[i].price+'</h5>');
                    lead_listing_views_html.push('<div class="ms-history-menu-details">');
                      lead_listing_views_html.push('<span>'+lead_listing_views[i].bed+' '+word_translate.beds+'</span>');
                      lead_listing_views_html.push('<span>'+lead_listing_views[i].bath+' '+word_translate.baths+'</span>');
                      lead_listing_views_html.push('<span>'+lead_listing_views[i].sqft+' '+word_translate.sqft+'</span>');
                    lead_listing_views_html.push('</div>');
                    lead_listing_views_html.push('</div>');
                    lead_listing_views_html.push('<div class="ms-history-menu-property-actions">');
                    lead_listing_views_html.push('<button data-mls="'+lead_listing_views[i].mls_num+'" data-token-alert="'+lead_listing_views[i].token_alert+'" class="ib-la-rf ms-history-menu-delete" aria-label="'+word_translate.save+'"><span>'+word_translate.save+'</span></button>');
                    // lead_listing_views_html.push('<button class="ms-history-menu-delete"><span>Delete</span></button>');
                    lead_listing_views_html.push('</div>');
                    lead_listing_views_html.push('<a href="'+__flex_g_settings.propertyDetailPermalink+'/'+lead_listing_views[i].slug+'" target="_blank" class="ms-history-menu-link">'+lead_listing_views[i].address_short + ' ' +  lead_listing_views[i].address_large +'</a>');
                    lead_listing_views_html.push('</div>');
                  }

                jQuery("#_ib_lead_activity_rows").html(lead_listing_views_html.join(""));
              }

              // build pagination
              if (response.lead_info.hasOwnProperty('saved_listings_pagination')) {
              if (response.lead_info.saved_listings_pagination.total_pages > 1) {
                var lead_listing_views_paging = [];

                if (response.lead_info.saved_listings_pagination.has_prev_page) {
                  lead_listing_views_paging.push('<a class="ib-pagprev ib-paggo" data-page="'+(response.lead_info.saved_listings_pagination.current_page - 1 )+'" role="button"></a>');
                }

                lead_listing_views_paging.push('<div class="ib-paglinks">');

                var lead_listing_views_page_range = response.lead_info.saved_listings_pagination.page_range_links;

                for (var i = 0, l =  lead_listing_views_page_range.length; i < l; i++) {
                  if (lead_listing_views_page_range[i] == response.lead_info.saved_listings_pagination.current_page) {
                    lead_listing_views_paging.push('<a class="ib-plitem ib-plitem-active" data-page="'+lead_listing_views_page_range[i]+'" role="button">'+lead_listing_views_page_range[i]+'</a>');
                  } else {
                    lead_listing_views_paging.push('<a class="ib-plitem" data-page="'+lead_listing_views_page_range[i]+'" role="button">'+lead_listing_views_page_range[i]+'</a>');
                  }
                }

                lead_listing_views_paging.push('</div>');

                if (response.lead_info.saved_listings_pagination.has_next_page) {
                  lead_listing_views_paging.push('<a class="ib-pagnext ib-paggo" data-page="'+(response.lead_info.saved_listings_pagination.current_page + 1 )+'" role="button"></a>');
                }

                  jQuery("#_ib_lead_activity_pagination").html('<div class="ms-history-menu-wrapper-pagination">'+lead_listing_views_paging.join("")+'</div>');
                }
              }
              }
            });
          }
          break;
          case "searches":
          if (jQuery("#ib-lead-history-menu-btn").length) {
            jQuery.ajax({
              url :__flex_g_settings.fetchLeadActivitiesEndpoint,
              method: "POST",
              data: {
                access_token: __flex_g_settings.accessToken,
                flex_credentials: Cookies.get("ib_lead_token"),
                paging: "saved_searches",
                page: new_page
              },
              dataType: "json",
              success: function(response) {
                // fill activity lead
                jQuery("#_ib_lead_activity_rows").empty();
                jQuery("#_ib_lead_activity_pagination").empty();

              if (response.lead_info.saved_searches.length) {
                var lead_listing_views = response.lead_info.saved_searches;
                var lead_listing_views_html = [];

                  for (var i = 0, l = lead_listing_views.length; i < l; i++) {
                    lead_listing_views_html.push('<div class="ms-history-menu-item ms-history-menu-condo">');
                    lead_listing_views_html.push('<div class="ms-history-menu-wrap-img">');
                    lead_listing_views_html.push('<span class="ms-history-menu-count">'+formatShortPriceX(lead_listing_views[i].search_count)+'</span> <span class="ms-history-menu-listing">'+word_translate.listings+'</span>');
                    lead_listing_views_html.push('</div>');
                    lead_listing_views_html.push('<div class="ms-history-menu-property-detail">');
                    lead_listing_views_html.push('<h3 class="ms-history-menu-title">'+lead_listing_views[i].name+'</h3>');
                    lead_listing_views_html.push('<h4 class="ms-history-menu-date">'+word_translate.saved_on+' '+lead_listing_views[i].f_date+'</h4>');
                    lead_listing_views_html.push('</div>');
                    lead_listing_views_html.push('<div class="ms-history-menu-property-actions">');
                    lead_listing_views_html.push('<button data-id="'+lead_listing_views[i].id+'" data-token-alert="'+lead_listing_views[i].token_alert+'" class="ib-la-rss ms-history-menu-delete" aria-label="'+word_translate.delete+'"><span>'+word_translate.delete+'</span></button>');
                    lead_listing_views_html.push('</div>');
                    lead_listing_views_html.push('<a href="'+lead_listing_views[i].search_url+'" target="_blank" class="ms-history-menu-link">'+lead_listing_views[i].name +'</a>');
                    lead_listing_views_html.push('</div>');
                  }

                jQuery("#_ib_lead_activity_rows").html(lead_listing_views_html.join(""));
              }

              // build pagination
              if (response.lead_info.hasOwnProperty('saved_searches_pagination')) {
              if (response.lead_info.saved_searches_pagination.total_pages > 1) {
                var lead_listing_views_paging = [];

                if (response.lead_info.saved_searches_pagination.has_prev_page) {
                  lead_listing_views_paging.push('<a class="ib-pagprev ib-paggo" data-page="'+(response.lead_info.saved_searches_pagination.current_page - 1 )+'" role="button"></a>');
                }

                lead_listing_views_paging.push('<div class="ib-paglinks">');

                var lead_listing_views_page_range = response.lead_info.saved_searches_pagination.page_range_links;

                for (var i = 0, l =  lead_listing_views_page_range.length; i < l; i++) {
                  if (lead_listing_views_page_range[i] == response.lead_info.saved_searches_pagination.current_page) {
                    lead_listing_views_paging.push('<a class="ib-plitem ib-plitem-active" data-page="'+lead_listing_views_page_range[i]+'" role="button">'+lead_listing_views_page_range[i]+'</a>');
                  } else {
                    lead_listing_views_paging.push('<a class="ib-plitem" data-page="'+lead_listing_views_page_range[i]+'" role="button">'+lead_listing_views_page_range[i]+'</a>');
                  }
                }

                lead_listing_views_paging.push('</div>');

                if (response.lead_info.saved_searches_pagination.has_next_page) {
                  lead_listing_views_paging.push('<a class="ib-pagnext ib-paggo" data-page="'+(response.lead_info.saved_searches_pagination.current_page + 1 )+'" role="button"></a>');
                }

                  jQuery("#_ib_lead_activity_pagination").html('<div class="ms-history-menu-wrapper-pagination">'+lead_listing_views_paging.join("")+'</div>');
                }
              }
              }
            });
          }
          break;
          case "history":
          default:
            if (jQuery("#ib-lead-history-menu-btn").length) {
            jQuery.ajax({
              url :__flex_g_settings.fetchLeadActivitiesEndpoint,
              method: "POST",
              data: {
                access_token: __flex_g_settings.accessToken,
                flex_credentials: Cookies.get("ib_lead_token"),
                paging: "listing_views",
                page: new_page
              },
              dataType: "json",
              success: function(response) {
                // fill activity lead
                jQuery("#_ib_lead_activity_rows").empty();
                jQuery("#_ib_lead_activity_pagination").empty();

              if (response.lead_info.listing_views.length) {
                var lead_listing_views = response.lead_info.listing_views;
                var lead_listing_views_html = [];

                  for (var i = 0, l = lead_listing_views.length; i < l; i++) {
                    lead_listing_views_html.push('<div class="ms-history-menu-item">');
                    lead_listing_views_html.push('<div class="ms-history-menu-wrap-img">');
                    lead_listing_views_html.push('<img src="'+lead_listing_views[i].thumbnail+'" alt="'+lead_listing_views[i].address_short+'">');
                    lead_listing_views_html.push('</div>');
                    lead_listing_views_html.push('<div class="ms-history-menu-property-detail">');
                    lead_listing_views_html.push('<h3 class="ms-history-menu-title">'+lead_listing_views[i].address_short+'</h3>');
                    lead_listing_views_html.push('<h4 class="ms-history-menu-address">'+lead_listing_views[i].address_large+'</h4>');
                    lead_listing_views_html.push('<h5 class="ms-history-menu-price">'+lead_listing_views[i].price+'</h5>');
                    lead_listing_views_html.push('<div class="ms-history-menu-details">');
                      lead_listing_views_html.push('<span>'+lead_listing_views[i].bed+' '+word_translate.beds+'</span>');
                      lead_listing_views_html.push('<span>'+lead_listing_views[i].bath+' '+word_translate.baths+'</span>');
                      lead_listing_views_html.push('<span>'+lead_listing_views[i].sqft+' '+word_translate.sqft+'</span>');
                    lead_listing_views_html.push('</div>');
                    lead_listing_views_html.push('</div>');
                    //console.log(lead_listing_views[i].mls_num);
                    lead_listing_views_html.push('<div class="ms-history-menu-property-actions">');
                    lead_listing_views_html.push('<button data-mls="'+lead_listing_views[i].mls_num+'" class="ib-la-hp ms-history-menu-delete" aria-label="'+word_translate.delete+'"><span>'+word_translate.delete+'</span></button>');
                    lead_listing_views_html.push('</div>');
                    //lead_listing_views_html.push('<div class="ms-history-menu-property-actions">');
                    //lead_listing_views_html.push('<button class="ms-history-menu-save"><span>save</span></button>');
                    //lead_listing_views_html.push('<button class="ms-history-menu-delete"><span>Delete</span></button>');
                    //lead_listing_views_html.push('</div>');
                    lead_listing_views_html.push('<a href="'+__flex_g_settings.propertyDetailPermalink+'/'+lead_listing_views[i].slug+'" target="_blank" class="ms-history-menu-link">'+lead_listing_views[i].address_short + ' ' +  lead_listing_views[i].address_large +'</a>');
                    lead_listing_views_html.push('</div>');
                  }

                jQuery("#_ib_lead_activity_rows").html(lead_listing_views_html.join(""));
              }

              // build pagination
              if (response.lead_info.hasOwnProperty('listing_views_pagination')) {
              if (response.lead_info.listing_views_pagination.total_pages > 1) {
                var lead_listing_views_paging = [];

                if (response.lead_info.listing_views_pagination.has_prev_page) {
                  lead_listing_views_paging.push('<a class="ib-pagprev ib-paggo" data-page="'+(response.lead_info.listing_views_pagination.current_page - 1 )+'" role="button"></a>');
                }

                lead_listing_views_paging.push('<div class="ib-paglinks">');

                var lead_listing_views_page_range = response.lead_info.listing_views_pagination.page_range_links;

                for (var i = 0, l =  lead_listing_views_page_range.length; i < l; i++) {
                  if (lead_listing_views_page_range[i] == response.lead_info.listing_views_pagination.current_page) {
                    lead_listing_views_paging.push('<a class="ib-plitem ib-plitem-active" data-page="'+lead_listing_views_page_range[i]+'" role="button">'+lead_listing_views_page_range[i]+'</a>');
                  } else {
                    lead_listing_views_paging.push('<a class="ib-plitem" data-page="'+lead_listing_views_page_range[i]+'" role="button">'+lead_listing_views_page_range[i]+'</a>');
                  }
                }

                lead_listing_views_paging.push('</div>');

                if (response.lead_info.listing_views_pagination.has_next_page) {
                  lead_listing_views_paging.push('<a class="ib-pagnext ib-paggo" data-page="'+(response.lead_info.listing_views_pagination.current_page + 1 )+'" role="button"></a>');
                }

                  jQuery("#_ib_lead_activity_pagination").html('<div class="ms-history-menu-wrapper-pagination">'+lead_listing_views_paging.join("")+'</div>');
                }
              }
              }
            });
          }
          break;
        }
      });

      // hide property from listings views
      $(document).on("click", ".ib-la-hp", function(event) {
        event.stopPropagation();
        var token_id = $(this).data("mls");
        var parent = $(this).parents(".ms-history-menu-item");
        //console.log(token_id);
        //console.log('removing...');
        //$(this).parent().parent().remove();
        parent.addClass("animation");
        setTimeout(function(){ 
          parent.remove();
        }, 600);

      $.ajax({
        url: __flex_g_settings.ajaxUrl,
        method: "POST",
        data: {
            action: "ib_hide_listing_view",
            mls_num: token_id
        },
        dataType: "json",
        success: function(data) {
          console.log('property view hidden');
          // if not available items, redirect page to 1
          // if (0 === jQuery("#_ib_lead_activity_rows").children().length) {
            jQuery("#_ib_lead_activity_tab button:eq(0)").click();
          // }
        }
      });
    });

      // remove favorite from personalized view widget
      $(document).on("click", ".ib-la-rf", function(event) {
        event.stopPropagation();
        var token_alert = $(this).data("token-alert");
        var token_id = $(this).data("mls");
        var parent = $(this).parents(".ms-history-menu-item");
        //console.log(token_alert);
        //console.log('removing...');
        parent.addClass("animation");
        setTimeout(function(){ 
          parent.remove();
        }, 600);
        //$(this).parent().parent().remove();

      $.ajax({
        url: __flex_g_settings.ajaxUrl,
        method: "POST",
        data: {
            action: "flex_favorite",
            type_action: "remove",
            mls_num: token_id,
            token_alert: token_alert
        },
        dataType: "json",
        success: function(data) {
          console.log('saved search removed');
          // if not available items, redirect page to 1
          // if (0 === jQuery("#_ib_lead_activity_rows").children().length) {
            jQuery("#_ib_lead_activity_tab button:eq(1)").click();
          // }
        }
      });
    });

      // remove saved search from personalized view widget
      $(document).on("click", ".ib-la-rss", function(event) {
        event.stopPropagation();
        var token_alert = $(this).data("token-alert");
        var token_id = $(this).data("id");
        //console.log(token_alert);
        //console.log('removing...');
        //$(this).parent().parent().remove();
        var parent = $(this).parents(".ms-history-menu-item");
        parent.addClass("animation");
        setTimeout(function(){ 
          parent.remove();
        }, 600);
        
        $.ajax({
          url: __flex_g_settings.ajaxUrl,
          method: "POST",
          data: {
              action: "flex_save_search",
              type: "remove",
              id: token_id,
              token_alert: token_alert
          },
          dataType: "json",
          success: function(data) {
            console.log('saved search removed');
            // if not available items, redirect page to 1
            // if (0 === jQuery("#_ib_lead_activity_rows").children().length) {
              jQuery("#_ib_lead_activity_tab button:eq(2)").click();
            // }
          }
        });
      });
    });
  })(jQuery);
</script>
