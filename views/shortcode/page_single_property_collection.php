<?php 
$idxboost_term_condition = get_option('idxboost_term_condition');
$idxboost_agent_info = get_option('idxboost_agent_info');
?>
<main id="flex-filters-theme">
  <div class="gwr gwr-breadcrumb">
    <div class="flex-breadcrumb">
      <ol>
        <li><a href="<?php echo $flex_idx_info["website_url"]; ?>" title="<?php echo __("Home", IDXBOOST_DOMAIN_THEME_LANG); ?>"><?php echo __("Home", IDXBOOST_DOMAIN_THEME_LANG); ?></a></li>
        <li><?php echo __(the_title(), IDXBOOST_DOMAIN_THEME_LANG); ?></li>
      </ol>
    </div>
  </div>

  <section id="wrap-result" class="wrap-result">
    <h2 class="title"><?php echo __(the_title(), IDXBOOST_DOMAIN_THEME_LANG); ?></h2>
    <div class="gwr">
      <div class="ib-single-property-collection js-ib-sp">
        <div class="ib-gheader">
          <div class="ib-ghpa">
            <span class="ib-ghtypes js-ib-sp-total">...</span>

            <div class="ib-gmfilters">
              <div class="ib-gwsort">
                <label class="ms-hidden" for="ib-gsort-b"><?php echo __("Select option", IDXBOOST_DOMAIN_THEME_LANG); ?></label>
                <select class="ib-gsort ib-sort-ctrl" id="ib-gsort-b">
                  <option value="list_date-desc"><?php echo __("Newest Listings", IDXBOOST_DOMAIN_THEME_LANG); ?></option>
                  <option value="price-desc"><?php echo __("Highest Price", IDXBOOST_DOMAIN_THEME_LANG); ?></option>
                  <option value="price-asc"><?php echo __("Lowest Price", IDXBOOST_DOMAIN_THEME_LANG); ?></option>
                  <option value="sqft-desc"><?php echo __("Highest", IDXBOOST_DOMAIN_THEME_LANG); ?> Sq.Ft</option>
                  <option value="sqft-asc"><?php echo __("Lowest", IDXBOOST_DOMAIN_THEME_LANG); ?> Sq.Ft</option>
                </select>
              </div>

              <!--<div class="ib-gwsort">
                <label class="ms-hidden" for="ib-columns-filter">Select view</label>
                <select class="ib-gsort js-ib-sp-columns-filter" id="ib-columns-filter">
                  <option value="columns-one">One columns</option>
                  <option value="columns-two">Two columns</option>
                  <option value="columns-three">Three columns</option>
                  <option value="columns-four" selected>Four columns</option>
                  <option value="columns-five">Five columns</option>
                </select>
              </div>-->
            </div>
          </div>
        </div>

        <div class="ib-cproperties">
          <div class="ib-wproperties">
            <ul class="ib-lproperties js-ib-sp-list"></ul>
          </div>

          <div class="ib-cpagination">
            <nav class="ib-wpagination js-ib-sp-pagination"></nav>
          </div>
        </div>

        <div class="ib-gnopro">
          <span class="ib-gnpno"><?php echo __("No matching results", IDXBOOST_DOMAIN_THEME_LANG); ?>...</span>
          <?php echo __("Modify your", IDXBOOST_DOMAIN_THEME_LANG); ?> <span class="ib-gnpoall"><?php echo __("filter", IDXBOOST_DOMAIN_THEME_LANG); ?></span> 
          <?php echo __("preferences to get new results or", IDXBOOST_DOMAIN_THEME_LANG); ?> 
          <span class="ib-gnpclear"><?php echo __("clear", IDXBOOST_DOMAIN_THEME_LANG); ?></span> <?php echo __("your search", IDXBOOST_DOMAIN_THEME_LANG); ?>.
        </div>
      </div>
    </div>
  </section>
</main>

<!--<div class="ib-sp-modal js-ib-spc-modal" id="ib-spc-modal"></div> #ib-spc-modal -->

<div class="js-ib-sp-modals" id="ib-sp-modals"></div><!-- js-ib-sp-modals -->

<script class="js-ib-sp-handlebars-template" id="ib-sp-handlebars-template" type="text/x-handlebars-template">

  <div class="ib-modal-master ib-mmpd ib-md-active js-ib-sp-modal-website ms-wrapper-actions-fs" id="ib-sp-modal-website">
    <div class="ib-mmcontent">
      <article class="ib-property-detail ib-pdmodal">

        <div class="ib-pcheader">
          <div class="ib-pwheader {{stylesInput.headerSection.format}}">

            <header class="ib-pheader">
              {{#ifequals stylesInput.logo.logoType "text"}}
                <h2 class="ib-ptitle ms-property-title">{{websiteTitle}} <span class="ib-pstitle">{{websiteTagline}}</span></h2>
              {{/ifequals}}
              {{#ifequals stylesInput.logo.logoType "image"}}
                <div class="ib-logo">
                  <img src="{{stylesInput.logo.logoImage}}" alt="">
                </div>
              {{/ifequals}}
            </header>

            <div class="ib-phcta">
              <div class="ib-phomodal">
                {{#if agentContactPhoneNumber}}
                  <a class="ib-pbtnphone" href="tel:{{agentContactPhoneNumber}}">
                    <?php echo __("Call Us", IDXBOOST_DOMAIN_THEME_LANG); ?>
                  </a>
                {{/if}}
                <div class="ib-requestinfo ib-phbtn sfm">{{stylesInput.headerSection.button.text}}</div>
                {{#if websiteSlugnameDomain}}
                  <div class="ib-pbtnopen ib-phbtn" data-permalink="{{websiteSlugnameDomain}}">
                    <?php echo __("Open", IDXBOOST_DOMAIN_THEME_LANG); ?>
                  </div>
                {{/if}}
                <div class="ib-pbtnclose ib-phbtn">
                  <?php echo __("Close", IDXBOOST_DOMAIN_THEME_LANG); ?>
                </div>
              </div>
            </div>

          </div>
        </div>

        <div class="ib-pcontent">
          <div class="ib-sps-page js-ib-sps-page">

            <div class="sp-header" id="ib-spc-header"></div>

            {{#if sections.themeSettings.globalCss}}
            <style>{{ sections.themeSettings.globalCss }}</style>
            {{/if}}

            <main>
              {{#if (ifVisibility visibilityRegions.headerSection)}}
                <section class="sps-section-home sp-animate" id="sps-welcome"
                  style="
                    --sps-section-background-color:{{sections.home.style.section.background.color}};
                    --sps-section-background-opacity:{{sections.home.style.section.background.opacity}};
                  ">

                  <div class="sps-section-background">
                    {{#ifequals bannerType 1}}
                      {{#if bannerPhotoGallery}}
                        <div class="sps-slider sps-h-full sps-w-full js-slider-home">
                          {{#each bannerPhotoGallery}}
                            <div class="sps-item sps-h-full sps-w-full">
                              <img class="gs-lazy" data-lazy="{{this.full}}" 
                                alt="{{this.name}}" draggable="false">
                            </div>
                          {{/each}}
                        </div>
                      {{/if}}
                    {{/ifequals}}
                    {{#ifequals bannerType 0}}
                      {{#if bannerVideoUrl}}
                        <div class="sps-main-video sps-h-full sps-w-full" data-img="{{ bannerVideoUrl }}"></div>
                      {{/if}}
                    {{/ifequals}}

                    <div class="sps-section-background-overlay"></div>
                  </div>
                  
                  <h2 class="sps-main-title">
                    {{#if bannerHeadingOne}}
                      <span>"{{bannerHeadingOne}}"</span>
                    {{/if}}
                    {{#if bannerHeadingTwo}}
                      {{bannerHeadingTwo}}
                    {{/if}}
                  </h2>

                  {{#if bannerHeadingThree}}
                    <span class="sps-main-slogan">{{bannerHeadingThree}}</span>
                  {{/if}}

                  <button class="sps-btn sfm">{{stylesInput.headerSection.button.text}}</button>
                  
                </section>
              {{/if}}

              {{#if (ifCondOR sections.details.showHeading sections.details.showDescription) }}
                <section class="sps-section" id="sps-details">

                  {{#if (ifVisibility sections.details.showHeading) }}
                    {{#if propertyMainDescription}}
                      <h2 class="sps-section-title">{{propertyMainDescription}}</h2>
                    {{/if}}

                    <ul class="sps-list">
                      <li>
                        {{propertyPrice}}

                        {{#if propertyPriceLabel}}
                          <span>{{ propertyPriceLabel }}</span>
                        {{/if}}
                      </li>

                      <li>
                        {{propertyBeds}}

                        {{#if propertyBedsLabel}}
                          <span>{{ propertyBedsLabel }}</span>
                        {{/if}}
                      </li>

                      <li>
                        {{propertyBaths}}

                        {{#if propertyBathsLabel}}
                          <span>{{ propertyBathsLabel }}</span>
                        {{/if}}
                      </li>
                    
                      <li>
                        {{propertyLivingSize}}

                        {{#if propertyLivingSizeLabel}}
                          <span>{{ propertyLivingSizeLabel }}</span>
                        {{/if}}
                      </li>
                    </ul>
                  {{/if}}

                  {{#if (ifVisibility sections.details.showDescription) }}
                    {{#if propertySecondaryDescription}}
                      {{{ propertySecondaryDescription }}}
                    {{/if}}
                  {{/if}}
                </section>
              {{/if}}

              {{#if (ifVisibility visibilityRegions.amenities)}}
                <section class="sps-section" id="sps-amenities">
                  <h2 class="sps-section-title">
                    <?php echo __("Amenities", IDXBOOST_DOMAIN_THEME_LANG); ?>
                  </h2>

                  {{#if propertyAmenities}}
                    <ul class="sps-amenities-list columns-{{stylesInput.amenities.columns}}">
                    {{#each propertyAmenities}} 
                      {{#if this}}
                        <li>{{this}}</li>
                      {{/if}}
                    {{/each}}
                    </ul>
                  {{/if}}
                </section>
              {{/if}}

              {{#if (ifVisibility visibilityRegions.photoGallery)}}
                {{#if propertyPhotoGallery}}
                  <section class="sps-gallery sp-animate" id="sps-gallery">
                    <ul class="sps-slider sps-sps-slider" id="sps-slider-galery">
                      {{#each propertyPhotoGallery}}
                        <li class="sps-sl-item">
                          <a class="sps-item sps-modal-galery" href="#">
                            <img class="sp-lazy" src="{{this.full}}" 
                              alt="{{this.altText}}" title="Titulo de la imagen" 
                              data-bg="{{this.full}}">
                            <div class="text_hover">{{this.altText}}</div>
                          </a>
                        </li>
                      {{/each}}
                    </ul>
                  </section>
                {{/if}}
              {{/if}}
              
              <div class="sps-section sp-animate" id="sps-media">
                <div class="sps-wrap-media">
                {{#if (ifVisibility visibilityRegions.videoTour)}}
                  <div class="sps-tab-body" id="sps-media-tour">
                    <h2 class="sps-section-title">
                      <?php echo __("Video Tour", IDXBOOST_DOMAIN_THEME_LANG); ?>
                    </h2>

                    <div id="sps-virtual">
                      {{#if propertyMetadata.propertyVideos}}
                        <div class="sps-slider-video" id="sps-slider-video">
                          {{#each propertyMetadata.propertyVideos}}
                            {{#if this.videoUrl}}
                              <div class="sps-item sps-item-video" data-video="{{this.videoUrl}}" 
                                data-title="{{this.videoName}}">
                                <button class="sps-play-video">Play</button>
                              </div>
                            {{else}}
                              <div class="sps-item sps-item-video" 
                                data-video="<?php echo FLEX_IDX_URI; ?>images/single-property/medium-default-video.jpg" 
                                src="<?php echo FLEX_IDX_URI; ?>images/single-property/temp.png">
                              </div>
                            {{/if}}
                          {{/each}}
                        </div>
                      {{else}}
                        <div class="sps-slider-video">
                          <div class="sps-item sps-item-video">
                            <img class="sp-lazy" alt="" 
                              src="<?php echo FLEX_IDX_URI; ?>images/single-property/medium-default-video.jpg">
                          </div>
                        </div>
                      {{/if}}
                    </div>
                  </div>
                {{/if}}

                {{#if (ifVisibility visibilityRegions.floorplans)}}
                  <div class="sps-tab-body" id="sps-media-floorplan">
                    <h2 class="sps-section-title">
                      <?php echo __("Floorplans", IDXBOOST_DOMAIN_THEME_LANG); ?>
                    </h2>

                    {{#if propertyFloorplans}}
                      <div id="sps-floorplans">
                        <div class="sps-wrap-slider" id="sps-slider-wp">
                          <div id="sps-slider-prop" class="sps-slider sps-sps-slider">
                          {{#each propertyFloorplans}}
                            <div class="sps-item">
                              <div class="sps-sl-item">
                                <div class="sps-wrap-img sps-modal-galery" role="button" aria-label="Nombre del Floorplans #{{@index}}">
                                  <img class="sp-lazy" alt="{{this.altText}}" src="{{this.full}}" draggable="false">
                                </div>
                                <div class="sps-wrap-btn">
                                  <h3 class="sps-floorplan-title">
                                    {{this.altText}}
                                  </h3>
                                  <!--<a href="#" class="sps-link">Download PDF</a>-->
                                </div>
                              </div>
                            </div>
                          {{/each}}
                          </div>

                          {{#if (propertyHasFloorplans propertyFloorplans)}}
                            <div class="sps-wrap-action-btn">
                              <button class="sps-btn-prev">
                                <?php echo __("Prev", IDXBOOST_DOMAIN_THEME_LANG); ?>
                              </button>
                              <button class="sps-btn-next">
                                <?php echo __("Next", IDXBOOST_DOMAIN_THEME_LANG); ?>
                              </button>
                            </div>
                          {{/if}}
                        </div>
                      </div>
                    {{/if}}
                  </div>
                {{/if}}
                </div>
              </div>              

              {{#if (ifVisibility visibilityRegions.location)}}
                <div class="sps-section" id="sps-location">
                  <h2 class="sps-section-title">
                    <?php echo __("Location", IDXBOOST_DOMAIN_THEME_LANG); ?>
                  </h2>
                  {{#if propertyLocationCoords}}
                  <div class="sps-map" id="googleMap" data-img="googleMap"
                    data-zoom="{{#if propertyLocationCoords.zoom}} {{propertyLocationCoords.zoom}} {{else}}16{{/if}}"
                    data-lat="{{#if propertyLocationCoords.lat}} {{propertyLocationCoords.lat}} {{else}}43.542194{{/if}}" 
                    data-lng="{{#if propertyLocationCoords.lng}} {{propertyLocationCoords.lng}} {{else}}-5.676875{{/if}}">
                  </div>
                  {{else}}
                    <div class="sps-map">
                      <img class="sps-map-img" alt=""
                        src="<?php echo FLEX_IDX_URI; ?>images/single-property/medium-default-map.jpg">
                    </div>
                  {{/if}}
                </div>
              {{/if}}

              {{#if (ifVisibility visibilityRegions.contactUs)}}
                <div class="sps-section" id="sps-contact">
                  <div class="sps-wrap-form">

                    <h2 class="sps-form-title">
                      <?php echo __("Contact Us", IDXBOOST_DOMAIN_THEME_LANG); ?>
                    </h2>
                    
                    <div class="sps-contact-header">
                      {{#if agentPhotoProfile.ObjectURL}}
                        <div class="sps-wrap-img">
                          <img class="sp-lazy" alt="" src="{{ agentPhotoProfile.ObjectURL }}">
                        </div>
                      {{/if}}
                      <ul class="sps-agent-info {{#unless agentPhotoProfile.ObjectURL }} sps-agent-info-alt {{/unless}}">
                        <li>
                          {{#if agentName}}
                            <strong>{{agentName}}</strong>
                          {{/if}}
                          {{#if agentTagline}}
                            {{agentTagline}}
                          {{/if}}
                        </li>
                        <li>
                          {{#if agentContactPhoneNumber}}
                            <a href="tel:{{agentContactPhoneNumber}}">
                              {{agentContactPhoneNumber}}
                            </a>
                          {{/if}}
                          {{#if agentContactEmailAddress}}
                            <a href="mailto:{{agentContactEmailAddress}}">
                              {{agentContactEmailAddress}}
                            </a>
                          {{/if}}
                        </li>
                      </ul>
                    </div>

                    <div class="sps-contact-body">
                      <form class="js-ib-sp-contact-form" method="post" id="contact-us-form">
                        <fieldset>
                          <legend>{{stylesInput.headerSection.button.text}} Form</legend>
                          <input type="hidden" name="ib_tags" value="{{stylesInput.headerSection.button.text}} {{websiteName}}">
                          <input type="hidden" name="action" value="idxboost_contact_inquiry">
                          <ul>
                            <li>
                              <label for="input_name"><?php echo __("Enter your Name", IDXBOOST_DOMAIN_THEME_LANG); ?></label>
                              <input type="text" placeholder="<?php echo __("First Name *", IDXBOOST_DOMAIN_THEME_LANG); ?>" name="name" id="input_name" required>
                            </li>
                            <li>
                              <label for="input_lastname"><?php echo __("Enter your last name", IDXBOOST_DOMAIN_THEME_LANG); ?></label>
                              <input type="text" placeholder="<?php echo __("Last Name *", IDXBOOST_DOMAIN_THEME_LANG); ?>" name="lastname" id="input_lastname" required>
                            </li>
                            <li>
                              <label for="input_email"><?php echo __("Enter your email", IDXBOOST_DOMAIN_THEME_LANG); ?></label>
                              <input type="email" placeholder="<?php echo __("Email *", IDXBOOST_DOMAIN_THEME_LANG); ?>" name="email" id="input_email" required>
                            </li>
                            <li>
                              <label for="input_phone"><?php echo __("Enter your phone number", IDXBOOST_DOMAIN_THEME_LANG); ?></label>
                              <input type="text" placeholder="<?php echo __("Phone *", IDXBOOST_DOMAIN_THEME_LANG); ?>" name="phone" id="input_phone" required>
                            </li>
                            <li>
                              <label for="input_comment"><?php echo __("Comments", IDXBOOST_DOMAIN_THEME_LANG); ?></label>
                              <textarea placeholder="<?php echo __("Comments *", IDXBOOST_DOMAIN_THEME_LANG); ?>" name="message" cols="30" rows="10" id="input_comment" required></textarea>
                            </li>
                          </ul>
                          <?php if ( ($idxboost_agent_info["show_opt_in_message"]) ) {  ?>
                          <div class="gfield fub">
                            <div class="ms-fub-disclaimer">
                              <p><?php echo __("By submitting this form you agree to be contacted by", IDXBOOST_DOMAIN_THEME_LANG); ?> <?php echo $idxboost_term_condition["company_name"]; ?> <?php echo __('via call, email, and text. To opt out, you can reply "stop" at any time or click the unsubscribe link in the emails. For more information see our', IDXBOOST_DOMAIN_THEME_LANG); ?> <a href="/terms-and-conditions/#follow-up-boss" target="_blank"><?php echo __("Terms and Conditions", IDXBOOST_DOMAIN_THEME_LANG); ?>.</a></p>
                            </div>
                          </div>
                          <?php } ?>
                          <button class="sps-btn" type="submit">{{stylesInput.headerSection.button.text}}</button>
                        </fieldset>
                      </form>
                    </div>

                  </div>
                </div><!-- #sp-contact -->
              {{/if}}
            </main>

            <div class="sps-section" id="sps-footer">
              <div class="sps-footer-img {{#if brokerLogo }} sps-footer-img-alt {{/if }}">
                {{#if brokerLogo }}
                  <img class="sps-lazy" alt="" src="{{brokerLogo}}">
                {{/if}}
                {{#if propertyMetadata.associationLogo}}
                  <img class="sps-lazy" alt="" src="{{propertyMetadata.associationLogo}}">
                {{/if }}
              </div>

              {{#if agentDisclaimer }}
                <p>{{agentDisclaimer}}</p>
              {{/if }}

              <div class="sps-bottom-footer">
                <ul class="sps-sub-menu-footer">
                  <li>
                    <a class="sp-show-modal" href="/terms-and-conditions/" 
                      title="<?php echo __("Go to Privacy page", IDXBOOST_DOMAIN_THEME_LANG); ?>" data-modal=".js-ib-sp-modal-privacy">
                      <?php echo __("Privacy", IDXBOOST_DOMAIN_THEME_LANG); ?></a>
                  </li>
                  <li>
                    <a class="sp-show-modal" href="terms-and-conditions/#atospp-privacy" 
                      title="<?php echo __("Go to Terms of Service page", IDXBOOST_DOMAIN_THEME_LANG); ?>" data-modal=".js-ib-sp-modal-privacy">
                      <?php echo __("Terms and Conditions", IDXBOOST_DOMAIN_THEME_LANG); ?></a>
                  </li>
                  <li>
                    <a class="sp-show-modal" href="/accessibility/" 
                      title="<?php echo __("Go to Accessibility page", IDXBOOST_DOMAIN_THEME_LANG); ?>" data-modal=".js-ib-sp-modal-accessibility">
                      <?php echo __("Accessibility", IDXBOOST_DOMAIN_THEME_LANG); ?></a>
                  </li>
                </ul>

                <p class="sps-copyright">&copy; Copyright <?php echo date('Y'); ?></p>

                <div class="sps-trem">
                  <div class="sps-trem-link">
                    Design + Powered by 
                    <a href="https://www.idxboost.com" target="_blank" rel="noopener" 
                      title="Learn more about IDXBoost (Open new window)">
                      <img class="sp-lazy" alt="IDXBoost Logo" 
                        src="<?php echo FLEX_IDX_URI; ?>images/single-property/idxboost-logo.svg">
                    </a>
                </div>
              </div>
            </div>

          </div>
        </div>

      </article>
    </div><!-- .ib-mmcontent -->

    <div class="ib-mmbg"></div>
  </div><!-- #ib-sp-modal-website -->

  <div class="ib-modal-master js-ib-sp-modal-contact" id="ib-sp-modal-contact">
    <div class="ib-mmcontent">
      <div class="ib-mwrapper ib-mgeneric">
        <div class="ib-mgcontent">
          <div class="ib-sps-page js-ib-sps-page">
            <div class="sp-modal-body">
              <h4 class="sp-modal-title">{{stylesInput.headerSection.button.text}}</h4>
              <p>
                <?php echo __("Call us now", IDXBOOST_DOMAIN_THEME_LANG); ?>: 
                <a class="sp-black" href="tel:{{agentContactPhoneNumber}}">{{agentContactPhoneNumber}}</a> <br> 
                <?php echo __("Fill the form below and we'll contact <br> you back promptly", IDXBOOST_DOMAIN_THEME_LANG); ?>.
              </p>
              <form class="js-ib-sp-contact-form" method="post" id="request-details-form">
                <fieldset>
                  <legend>{{stylesInput.headerSection.button.text}} Form</legend>
                  <input type="hidden" name="ib_tags" value="{{stylesInput.headerSection.button.text}} {{websiteName}}">
                  <input type="hidden" name="action" value="idxboost_contact_inquiry">
                  <div class="sp-input-form">
                    <label for="inputName"><?php echo __("Enter your Name", IDXBOOST_DOMAIN_THEME_LANG); ?></label>
                    <input type="text" placeholder="<?php echo __("First Name *", IDXBOOST_DOMAIN_THEME_LANG); ?>" name="name" id="inputName" required>
                  </div>
                  <div class="sp-input-form">
                    <label for="inputLastName">?php echo __("Enter your last name", IDXBOOST_DOMAIN_THEME_LANG); ?></label>
                    <input type="text" placeholder="<?php echo __("Last Name *", IDXBOOST_DOMAIN_THEME_LANG); ?>" name="lastname" id="inputLastName" required>
                  </div>
                  <div class="sp-input-form">
                    <label for="inputEmail"><?php echo __("Enter your email", IDXBOOST_DOMAIN_THEME_LANG); ?></label>
                    <input type="email" placeholder="<?php echo __("Email *", IDXBOOST_DOMAIN_THEME_LANG); ?>" name="email" id="inputEmail" required>
                  </div>
                  <div class="sp-input-form">
                    <label for="inputPhone"><?php echo __("Enter your phone number", IDXBOOST_DOMAIN_THEME_LANG); ?></label>
                    <input type="phone" placeholder="<?php echo __("Phone *", IDXBOOST_DOMAIN_THEME_LANG); ?>" name="phone" id="inputPhone" required>
                  </div>
                  <div class="sp-input-form">
                    <label for="inputComment"><?php echo __("Comments", IDXBOOST_DOMAIN_THEME_LANG); ?></label>
                    <textarea placeholder="<?php echo __("Comments *", IDXBOOST_DOMAIN_THEME_LANG); ?>" name="message" id="inputComment" required></textarea>
                  </div>
                  <?php if ( ($idxboost_agent_info["show_opt_in_message"]) ) {  ?>
                  <div class="gfield fub sp-input-form">
                    <div class="ms-fub-disclaimer">
                      <p><?php echo __("By submitting this form you agree to be contacted by", IDXBOOST_DOMAIN_THEME_LANG); ?> <?php echo $idxboost_term_condition["company_name"]; ?> <?php echo __('via call, email, and text. To opt out, you can reply "stop" at any time or click the unsubscribe link in the emails. For more information see our', IDXBOOST_DOMAIN_THEME_LANG); ?> <a href="/terms-and-conditions/#follow-up-boss" target="_blank"><?php echo __("Terms and Conditions", IDXBOOST_DOMAIN_THEME_LANG); ?>.</a></p>
                    </div>
                  </div>
                  <?php } ?>
                  <div class="sp-input-form">
                    <button class="sp-button" type="submit">{{stylesInput.headerSection.button.text}}</button>
                  </div>
                </fieldset>
              </form>
            </div>
          </div>
        </div>
      </div>
      <button class="ib-mmclose">
        <span class="ib-mmctxt">
          <?php echo __("Close", IDXBOOST_DOMAIN_THEME_LANG); ?>
        </span>
      </button>
    </div><!-- .ib-mmcontent -->

    <div class="ib-mmbg"></div>
  </div><!-- #ib-sp-modal-contact -->

  <div class="ib-modal-master js-ib-sp-modal-privacy" id="ib-sp-modal-privacy">
    <div class="ib-mmcontent">
      <div class="ib-mwrapper ib-mgeneric">
        <div class="ib-mgcontent">
          <div class="ib-sps-page js-ib-sps-page">
            <div class="sp-body-modal">
              <div>
                <h4 class="sp-title">
                  <?php echo strtoupper( __("Terms and Conditions", IDXBOOST_DOMAIN_THEME_LANG) ); ?>
                </h4>
                <p><a href="#atospp-terms" data-section="#atospp-terms">Terms of Service</a> / <a href="#atospp-privacy" data-section="#atospp-privacy">Privacy Policy</a></p>
                </ul>
                <div id="atospp-terms">
                  <h5 class="sp-sub-title">Terms of Service:</h5>
                  <p>The following terms and conditions govern all use of the {{propertyMetadata.termsPrivacyAda.websiteDomain}} website and all content, services and products available at or through the website (taken together, the Website). The Website is owned and operated by {{propertyMetadata.termsPrivacyAda.companyAgentOrTeamName}} ("{{propertyMetadata.termsPrivacyAda.companyAgentOrTeamName}}"). The Website is offered subject to your acceptance without modification of all of the terms and conditions contained herein and all other operating rules, policies (including, without limitation, {{propertyMetadata.termsPrivacyAda.companyAgentOrTeamName}}'s Privacy Policy) and procedures that may be published from time to time on this Site by {{propertyMetadata.termsPrivacyAda.companyAgentOrTeamName}} (collectively, the "Agreement").</p>
                  <p>Please read this Agreement carefully before accessing or using the Website. By accessing or using any part of the web site, you agree to become bound by the terms and conditions of this agreement. If you do not agree to all the terms and conditions of this agreement, then you may not access the Website or use any services. If these terms and conditions are considered an offer by {{propertyMetadata.termsPrivacyAda.companyAgentOrTeamName}}, acceptance is expressly limited to these terms. The Website is available only to individuals who are at least 18 years old.</p>
                  <p><span>Your {{propertyMetadata.termsPrivacyAda.websiteDomain}} Account and Site.</span> If you create a blog/site on the Website, you are responsible for maintaining the security of your account and blog, and you are fully responsible for all activities that occur under the account and any other actions taken in connection with the blog. You must not describe or assign keywords to your blog in a misleading or unlawful manner, including in a manner intended to trade on the name or reputation of others, and {{propertyMetadata.termsPrivacyAda.companyAgentOrTeamName}} may change or remove any description or keyword that it considers inappropriate or unlawful, or otherwise likely to cause {{propertyMetadata.termsPrivacyAda.companyAgentOrTeamName}} liability. You must immediately notify {{propertyMetadata.termsPrivacyAda.companyAgentOrTeamName}} of any unauthorized uses of your blog, your account or any other breaches of security. {{propertyMetadata.termsPrivacyAda.companyAgentOrTeamName}} will not be liable for any acts or omissions by You, including any damages of any kind incurred as a result of such acts or omissions.</p>
                  <p><span>Responsibility of Contributors.</span> If you operate a blog, comment on a blog, post material to the Website, post links on the Website, or otherwise make (or allow any third party to make) material available by means of the Website (any such material, "Content"), You are entirely responsible for the content of, and any harm resulting from, that Content. That is the case regardless of whether the Content in question constitutes text, graphics, an audio file, or computer software. By making Content available, you represent and warrant that:</p>
                  <ul>
                    <li>the downloading, copying and use of the Content will not infringe the proprietary rights, including but not limited to the copyright, patent, trademark or trade secret rights, of any third party.</li>
                    <li>if your employer has rights to intellectual property you create, you have either (i) received permission from your employer to post or make available the Content, including but not limited to any software, or (ii) secured from your employer a waiver as to all rights in or to the Content.</li>
                    <li>you have fully complied with any third-party licenses relating to the Content, and have done all things necessary to successfully pass through to end users any required terms.</li>
                    <li>the Content does not contain or install any viruses, worms, malware, Trojan horses or other harmful or destructive content.</li>
                    <li>the Content is not spam, is not machine- or randomly-generated, and does not contain unethical or unwanted commercial content designed to drive traffic to third party sites or boost the search engine rankings of third party sites, or to further unlawful acts (such as phishing) or mislead recipients as to the source of the material (such as spoofing)</li>
                    <li>the Content is not pornographic, does not contain threats or incite violence towards individuals or entities, and does not violate the privacy or publicity rights of any third party.</li>
                    <li>your blog is not getting advertised via unwanted electronic messages such as spam links on newsgroups, email lists, other blogs and web sites, and similar unsolicited promotional methods.</li>
                    <li>your blog is not named in a manner that misleads your readers into thinking that you are another person or company. For example, your blog's URL or name is not the name of a person other than yourself or company other than your own; and you have, in the case of Content that includes computer code, accurately categorized and/or described the type, nature, uses and effects of the materials, whether requested to do so by {{propertyMetadata.termsPrivacyAda.companyAgentOrTeamName}} or otherwise.</li>
                  </ul>
                  <p>By submitting Content to {{propertyMetadata.termsPrivacyAda.companyAgentOrTeamName}} for inclusion on your Website, you grant {{propertyMetadata.termsPrivacyAda.companyAgentOrTeamName}} a world-wide, royalty-free, and non-exclusive license to reproduce, modify, adapt and publish the Content solely for the purpose of displaying, distributing and promoting your blog. If you delete Content, {{propertyMetadata.termsPrivacyAda.companyAgentOrTeamName}} will use reasonable efforts to remove it from the Website, but you acknowledge that caching or references to the Content may not be made immediately unavailable.</p>
                  <p>Without limiting any of those representations or warranties, {{propertyMetadata.termsPrivacyAda.companyAgentOrTeamName}} has the right (though not the obligation) to, in {{propertyMetadata.termsPrivacyAda.companyAgentOrTeamName}}'s sole discretion (i) refuse or remove any content that, in {{propertyMetadata.termsPrivacyAda.companyAgentOrTeamName}}'s reasonable opinion, violates any {{propertyMetadata.termsPrivacyAda.companyAgentOrTeamName}} policy or is in any way harmful or objectionable, or (ii) terminate or deny access to and use of the Website to any individual or entity for any reason, in {{propertyMetadata.termsPrivacyAda.companyAgentOrTeamName}}'s sole discretion. {{propertyMetadata.termsPrivacyAda.companyAgentOrTeamName}} will have no obligation to provide a refund of any amounts previously paid.</p>
                  <p><span>Responsibility of Website Visitors.</span> {{propertyMetadata.termsPrivacyAda.companyAgentOrTeamName}} has not reviewed, and cannot review, all of the material, including computer software, posted to the Website, and cannot therefore be responsible for that material's content, use or effects. By operating the Website, {{propertyMetadata.termsPrivacyAda.companyAgentOrTeamName}} does not represent or imply that it endorses the material there posted, or that it believes such material to be accurate, useful or non-harmful. You are responsible for taking precautions as necessary to protect yourself and your computer systems from viruses, worms, Trojan horses, and other harmful or destructive content. The Website may contain content that is offensive, indecent, or otherwise objectionable, as well as content containing technical inaccuracies, typographical mistakes, and other errors. The Website may also contain material that violates the privacy or publicity rights, or infringes the intellectual property and other proprietary rights, of third parties, or the downloading, copying or use of which is subject to additional terms and conditions, stated or unstated. {{propertyMetadata.termsPrivacyAda.companyAgentOrTeamName}} disclaims any responsibility for any harm resulting from the use by visitors of the Website, or from any downloading by those visitors of content there posted.</p>
                  <p><span>Content Posted on Other Websites.</span> We have not reviewed, and cannot review, all of the material, including computer software, made available through the websites and webpages to which {{propertyMetadata.termsPrivacyAda.websiteDomain}} links, and that link to {{propertyMetadata.termsPrivacyAda.websiteDomain}}. {{propertyMetadata.termsPrivacyAda.companyAgentOrTeamName}} does not have any control over those non-{{propertyMetadata.termsPrivacyAda.companyAgentOrTeamName}} websites and webpages, and is not responsible for their contents or their use. By linking to a non-{{propertyMetadata.termsPrivacyAda.companyAgentOrTeamName}} website or webpage, {{propertyMetadata.termsPrivacyAda.companyAgentOrTeamName}} does not represent or imply that it endorses such website or webpage. You are responsible for taking precautions as necessary to protect yourself and your computer systems from viruses, worms, Trojan horses, and other harmful or destructive content. {{propertyMetadata.termsPrivacyAda.companyAgentOrTeamName}} disclaims any responsibility for any harm resulting from your use of non-{{propertyMetadata.termsPrivacyAda.companyAgentOrTeamName}} websites and webpages.</p>
                  <p>Copyright Infringement and DMCA Policy.</span> As {{propertyMetadata.termsPrivacyAda.companyAgentOrTeamName}} asks others to respect its intellectual property rights, it respects the intellectual property rights of others. If you believe that material located on or linked to by {{propertyMetadata.termsPrivacyAda.websiteDomain}} violates your copyright, you are encouraged to notify {{propertyMetadata.termsPrivacyAda.companyAgentOrTeamName}} in accordance with {{propertyMetadata.termsPrivacyAda.companyAgentOrTeamName}}'s Digital Millennium Copyright Act ("DMCA") Policy. {{propertyMetadata.termsPrivacyAda.companyAgentOrTeamName}} will respond to all such notices, including as required or appropriate by removing the infringing material or disabling all links to the infringing material. {{propertyMetadata.termsPrivacyAda.companyAgentOrTeamName}} will terminate a visitor's access to and use of the Website if, under appropriate circumstances, the visitor is determined to be a repeat infringer of the copyrights or other intellectual property rights of {{propertyMetadata.termsPrivacyAda.companyAgentOrTeamName}} or others. In the case of such termination, {{propertyMetadata.termsPrivacyAda.companyAgentOrTeamName}} will have no obligation to provide a refund of any amounts previously paid to {{propertyMetadata.termsPrivacyAda.companyAgentOrTeamName}}.</p>
                  <p><span>Intellectual Property.</span> This Agreement does not transfer from {{propertyMetadata.termsPrivacyAda.companyAgentOrTeamName}} to you any {{propertyMetadata.termsPrivacyAda.companyAgentOrTeamName}} or third party intellectual property, and all right, title and interest in and to such property will remain (as between the parties) solely with {{propertyMetadata.termsPrivacyAda.companyAgentOrTeamName}}. {{propertyMetadata.termsPrivacyAda.companyAgentOrTeamName}}, {{propertyMetadata.termsPrivacyAda.websiteDomain}}, the {{propertyMetadata.termsPrivacyAda.websiteDomain}} logo, and all other trademarks, service marks, graphics and logos used in connection with {{propertyMetadata.termsPrivacyAda.websiteDomain}}, or the Website are trademarks or registered trademarks of {{propertyMetadata.termsPrivacyAda.companyAgentOrTeamName}} or {{propertyMetadata.termsPrivacyAda.companyAgentOrTeamName}}'s licensors. Other trademarks, service marks, graphics and logos used in connection with the Website may be the trademarks of other third parties. Your use of the Website grants you no right or license to reproduce or otherwise use any {{propertyMetadata.termsPrivacyAda.companyAgentOrTeamName}} or third-party trademarks.</p>
                  <p><span>Advertisements.</span> {{propertyMetadata.termsPrivacyAda.companyAgentOrTeamName}} reserves the right to display advertisements on your blog unless you have purchased an ad-free account.</p>
                  <p><span>Attribution.</span> {{propertyMetadata.termsPrivacyAda.companyAgentOrTeamName}} reserves the right to display attribution links such as 'Blog at {{propertyMetadata.termsPrivacyAda.websiteDomain}},' theme author, and font attribution in your blog footer or toolbar.</p>
                  <p><span>Partner Products.</span> By activating a partner product (e.g. theme) from one of our partners, you agree to that partner's terms of service. You can opt out of their terms of service at any time by de-activating the partner product.</p>
                  <p><span>Domain Names.</span> If you are registering a domain name, using or transferring a previously registered domain name, you acknowledge and agree that use of the domain name is also subject to the policies of the Internet Corporation for Assigned Names and Numbers ("ICANN"), including their <a href="https://www.icann.org/en/registrars/registrant-rights-responsibilities-en.htm">Registration Rights and Responsibilities.</a></p>
                  <p><span>Changes.</span> {{propertyMetadata.termsPrivacyAda.companyAgentOrTeamName}} reserves the right, at its sole discretion, to modify or replace any part of this Agreement. It is your responsibility to check this Agreement periodically for changes. Your continued use of or access to the Website following the posting of any changes to this Agreement constitutes acceptance of those changes. {{propertyMetadata.termsPrivacyAda.companyAgentOrTeamName}} may also, in the future, offer new services and/or features through the Website (including, the release of new tools and resources). Such new features and/or services shall be subject to the terms and conditions of this Agreement.</p>
                  <p><span>Termination.</span> {{propertyMetadata.termsPrivacyAda.companyAgentOrTeamName}} may terminate your access to all or any part of the Website at any time, with or without cause, with or without notice, effective immediately. If you wish to terminate this Agreement or your {{propertyMetadata.termsPrivacyAda.websiteDomain}} account (if you have one), you may simply discontinue using the Website. Notwithstanding the foregoing, if you have a paid services account, such account can only be terminated by {{propertyMetadata.termsPrivacyAda.companyAgentOrTeamName}} if you materially breach this Agreement and fail to cure such breach within thirty (30) days from {{propertyMetadata.termsPrivacyAda.companyAgentOrTeamName}}'s notice to you thereof; provided that, {{propertyMetadata.termsPrivacyAda.companyAgentOrTeamName}} can terminate the Website immediately as part of a general shut down of our service. All provisions of this Agreement which by their nature should survive termination shall survive termination, including, without limitation, ownership provisions, warranty disclaimers, indemnity and limitations of liability.</p>
                  <p><span>Disclaimer of Warranties.</span> The Website is provided "as is". {{propertyMetadata.termsPrivacyAda.companyAgentOrTeamName}} and its suppliers and licensors hereby disclaim all warranties of any kind, express or implied, including, without limitation, the warranties of merchantability, fitness for a particular purpose and non-infringement. Neither {{propertyMetadata.termsPrivacyAda.companyAgentOrTeamName}} nor its suppliers and licensors, makes any warranty that the Website will be error free or that access thereto will be continuous or uninterrupted. You understand that you download from, or otherwise obtain content or services through, the Website at your own discretion and risk.</p>
                  <p><span>Limitation of Liability.</span> In no event will {{propertyMetadata.termsPrivacyAda.companyAgentOrTeamName}}, or its suppliers or licensors, be liable with respect to any subject matter of this agreement under any contract, negligence, strict liability or other legal or equitable theory for: (i) any special, incidental or consequential damages; (ii) the cost of procurement for substitute products or services; (iii) for interruption of use or loss or corruption of data; or (iv) for any amounts that exceed the fees paid by you to {{propertyMetadata.termsPrivacyAda.companyAgentOrTeamName}} under this agreement during the twelve (12) month period prior to the cause of action. {{propertyMetadata.termsPrivacyAda.companyAgentOrTeamName}} shall have no liability for any failure or delay due to matters beyond their reasonable control. The foregoing shall not apply to the extent prohibited by applicable law.</p>
                  <p><span>General Representation and Warranty.</span> You represent and warrant that (i) your use of the Website will be in strict accordance with the {{propertyMetadata.termsPrivacyAda.companyAgentOrTeamName}} Privacy Policy, with this Agreement and with all applicable laws and regulations (including without limitation any local laws or regulations in your country, state, city, or other governmental area, regarding online conduct and acceptable content, and including all applicable laws regarding the transmission of technical data exported from the United States or the country in which you reside) and (ii) your use of the Website will not infringe or misappropriate the intellectual property rights of any third party.</p>
                  <p><span>Indemnification.</span> You agree to indemnify and hold harmless {{propertyMetadata.termsPrivacyAda.companyAgentOrTeamName}}, its contractors, and its licensors, and their respective directors, officers, employees and agents from and against any and all claims and expenses, including attorneys' fees, arising out of your use of the Website, including but not limited to your violation of this Agreement.</p>
                  <p><span>Miscellaneous.</span> This Agreement constitutes the entire agreement between {{propertyMetadata.termsPrivacyAda.companyAgentOrTeamName}} and you concerning the subject matter hereof, and they may only be modified by a written amendment signed by an authorized executive of {{propertyMetadata.termsPrivacyAda.companyAgentOrTeamName}}, or by the posting by {{propertyMetadata.termsPrivacyAda.companyAgentOrTeamName}} of a revised version. Except to the extent applicable law, if any, provides otherwise, this Agreement, any access to or use of the Website will be governed by the laws of the {{propertyMetadata.termsPrivacyAda.state}} excluding its conflict of law provisions, and the proper venue for any disputes arising out of or relating to any of the same will be the state and federal courts located in {{propertyMetadata.termsPrivacyAda.countyState}}. Except for claims for injunctive or equitable relief or claims regarding intellectual property rights (which may be brought in any competent court without the posting of a bond), any dispute arising under this Agreement shall be finally settled in accordance with the Comprehensive Arbitration Rules of the Judicial Arbitration and Mediation Service, Inc. ("JAMS") by three arbitrators appointed in accordance with such Rules. The arbitration shall take place in {{propertyMetadata.termsPrivacyAda.countyState}}, in the English language and the arbitral decision may be enforced in any court. The prevailing party in any action or proceeding to enforce this Agreement shall be entitled to costs and attorneys' fees. If any part of this Agreement is held invalid or unenforceable, that part will be construed to reflect the parties' original intent, and the remaining portions will remain in full force and effect. A waiver by either party of any term or condition of this Agreement or any breach thereof, in any one instance, will not waive such term or condition or any subsequent breach thereof. You may assign your rights under this Agreement to any party that consents to, and agrees to be bound by, its terms and conditions; {{propertyMetadata.termsPrivacyAda.companyAgentOrTeamName}} may assign its rights under this Agreement without condition. This Agreement will be binding upon and will inure to the benefit of the parties, their successors and permitted assigns.</p>
                </div>
              
                <div id="atospp-privacy">
                  <h5 class="sp-sub-title">
                    <?php echo __("Privacy Policy", IDXBOOST_DOMAIN_THEME_LANG); ?>:
                  </h5>
                  <p>{{propertyMetadata.termsPrivacyAda.companyAgentOrTeamName}} ("{{propertyMetadata.termsPrivacyAda.companyAgentOrTeamName}}") operates {{propertyMetadata.termsPrivacyAda.websiteDomain}} and may operate other websites. It is {{propertyMetadata.termsPrivacyAda.companyAgentOrTeamName}}'s policy to respect your privacy nregarding any information we may collect while operating our websites.</p>
                  <p><span>Website Visitors.</span> Like most website operators, {{propertyMetadata.termsPrivacyAda.companyAgentOrTeamName}} collects non-personally-identifying information of the sort that web browsers and servers typically make available, such as the browser type, language preference, referring site, and the date and time of each visitor request. {{propertyMetadata.termsPrivacyAda.companyAgentOrTeamName}}'s purpose in collecting non-personally identifying information is to better understand how {{propertyMetadata.termsPrivacyAda.companyAgentOrTeamName}}'s visitors use its website. From time to time, {{propertyMetadata.termsPrivacyAda.companyAgentOrTeamName}} may release non-personally-identifying information in the aggregate, e.g., by publishing a report on trends in the usage of its website.</p>
                  <p><span>{{propertyMetadata.termsPrivacyAda.companyAgentOrTeamName}}</span> also collects potentially personally-identifying information like Internet Protocol (IP) addresses for logged in users and for users leaving comments on {{propertyMetadata.termsPrivacyAda.websiteDomain}} blogs/sites. {{propertyMetadata.termsPrivacyAda.companyAgentOrTeamName}} only discloses logged in user and commenter IP addresses under the same circumstances that it uses and discloses personally-identifying information as described below, except that commenter IP addresses and email addresses are visible and disclosed to the administrators of the blog/site where the comment was left.</p>
                  <p><span>Gathering of Personally-Identifying Information.</span> Certain visitors to {{propertyMetadata.termsPrivacyAda.companyAgentOrTeamName}}'s websites choose to interact with {{propertyMetadata.termsPrivacyAda.companyAgentOrTeamName}} in ways that require {{propertyMetadata.termsPrivacyAda.companyAgentOrTeamName}} to gather personally-identifying information. The amount and type of information that {{propertyMetadata.termsPrivacyAda.companyAgentOrTeamName}} gathers depends on the nature of the interaction. For example, we ask visitors who sign up at <a href="{{propertyMetadata.termsPrivacyAda.websiteDomain}}">{{propertyMetadata.termsPrivacyAda.websiteDomain}}</a> to provide a username and email address. Those who engage in transactions with {{propertyMetadata.termsPrivacyAda.companyAgentOrTeamName}} are asked to provide additional information, including as necessary the personal and financial information required to process those transactions. In each case, {{propertyMetadata.termsPrivacyAda.companyAgentOrTeamName}} collects such information only insofar as is necessary or appropriate to fulfill the purpose of the visitor's interaction with {{propertyMetadata.termsPrivacyAda.companyAgentOrTeamName}}. {{propertyMetadata.termsPrivacyAda.companyAgentOrTeamName}} does not disclose personally-identifying information other than as described below. And visitors can always refuse to supply personally-identifying information, with the caveat that it may prevent them from engaging in certain website-related activities.</p>
                  <p><span>Aggregated Statistics.</span> {{propertyMetadata.termsPrivacyAda.companyAgentOrTeamName}} may collect statistics about the behavior of visitors to its websites. {{propertyMetadata.termsPrivacyAda.companyAgentOrTeamName}} may display this information publicly or provide it to others. However, {{propertyMetadata.termsPrivacyAda.companyAgentOrTeamName}} does not disclose personally-identifying information other than as described below.</p>
                  <p><span>Protection of Certain Personally-Identifying Information.</span> {{propertyMetadata.termsPrivacyAda.companyAgentOrTeamName}} discloses potentially personally-identifying and personally-identifying information only to those of its employees, contractors and affiliated organizations that (i) need to know that information in order to process it on {{propertyMetadata.termsPrivacyAda.companyAgentOrTeamName}}'s behalf or to provide services available at {{propertyMetadata.termsPrivacyAda.companyAgentOrTeamName}}'s websites, and (ii) that have agreed not to disclose it to others. Some of those employees, contractors and affiliated organizations may be located outside of your home country; by using {{propertyMetadata.termsPrivacyAda.companyAgentOrTeamName}}'s websites, you consent to the transfer of such information to them. {{propertyMetadata.termsPrivacyAda.companyAgentOrTeamName}} will not rent or sell potentially personally-identifying and personally-identifying information to anyone. Other than to its employees, contractors and affiliated organizations, as described above, {{propertyMetadata.termsPrivacyAda.companyAgentOrTeamName}} discloses potentially personally-identifying and personally-identifying information only in response to a subpoena, court order or other governmental request, or when {{propertyMetadata.termsPrivacyAda.companyAgentOrTeamName}} believes in good faith that disclosure is reasonably necessary to protect the property or rights of {{propertyMetadata.termsPrivacyAda.companyAgentOrTeamName}}, third parties or the public at large. If you are a registered user of an {{propertyMetadata.termsPrivacyAda.companyAgentOrTeamName}} website and have supplied your email address, {{propertyMetadata.termsPrivacyAda.companyAgentOrTeamName}} may occasionally send you an email to tell you about new features, solicit your feedback, or just keep you up to date with what's going on with {{propertyMetadata.termsPrivacyAda.companyAgentOrTeamName}} and our products. If you send us a request (for example via email or via one of our feedback mechanisms), we reserve the right to publish it in order to help us clarify or respond to your request or to help us support other users. {{propertyMetadata.termsPrivacyAda.companyAgentOrTeamName}} takes all measures reasonably necessary to protect against the unauthorized access, use, alteration or destruction of potentially personally-identifying and personally-identifying information.</p>
                  <p><span>Cookies.</span> Acookie is a string of information that a website stores on a visitor's computer, and that the visitor's browser provides to the website each time the visitor returns. {{propertyMetadata.termsPrivacyAda.companyAgentOrTeamName}} uses cookies to help {{propertyMetadata.termsPrivacyAda.companyAgentOrTeamName}} identify and track visitors, their usage of {{propertyMetadata.termsPrivacyAda.companyAgentOrTeamName}} website, and their website access preferences. {{propertyMetadata.termsPrivacyAda.companyAgentOrTeamName}} visitors who do not wish to have cookies placed on their  computers should set their browsers to refuse cookies before using {{propertyMetadata.termsPrivacyAda.companyAgentOrTeamName}}'s websites, with the drawback that certain features of {{propertyMetadata.termsPrivacyAda.companyAgentOrTeamName}}'s websites may not function properly without the aid of cookies.</p>
                  <p><span>Business Transfers.</span> If {{propertyMetadata.termsPrivacyAda.companyAgentOrTeamName}}, or substantially all of its assets, were acquired, or in the unlikely event that {{propertyMetadata.termsPrivacyAda.companyAgentOrTeamName}} goes out of business or enters bankruptcy, user information would be one of the assets that is transferred or acquired by a third party. You acknowledge that such transfers may occur, and that any acquirer of {{propertyMetadata.termsPrivacyAda.companyAgentOrTeamName}} may continue to use your personal information as set forth in this policy.</p>
                  <p><span>Ads.</span> Ads appearing on any of our websites may be delivered to users by advertising partners, who may set cookies. These cookies allow the ad server to recognize your computer each time they send you an online advertisement to compile information about you or others who use your computer. This information allows ad networks to, among other things, deliver targeted advertisements that they believe will be of most interest to you. This Privacy Policy covers the use of cookies by {{propertyMetadata.termsPrivacyAda.companyAgentOrTeamName}} and does not cover the use of cookies by any advertisers.</p>
                  <p><span>Privacy Policy Changes.</span> Although most changes are likely to be minor, {{propertyMetadata.termsPrivacyAda.companyAgentOrTeamName}} may change its Privacy Policy from time to time, and in {{propertyMetadata.termsPrivacyAda.companyAgentOrTeamName}}'s sole discretion. {{propertyMetadata.termsPrivacyAda.companyAgentOrTeamName}} encourages visitors to frequently check this page for any changes to its Privacy Policy. If you have a {{propertyMetadata.termsPrivacyAda.websiteDomain}} account, you might also receive an alert informing you of these changes. Your continued use of this site after any change in this Privacy Policy will constitute your acceptance of such change.</p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <button class="ib-mmclose">
        <span class="ib-mmctxt">
          <?php echo __("Close", IDXBOOST_DOMAIN_THEME_LANG); ?>
        </span>
      </button>
    </div><!-- .ib-mmcontent -->

    <div class="ib-mmbg"></div>
  </div><!-- #ib-sp-modal-privacy -->

  <div class="ib-modal-master js-ib-sp-modal-accessibility" id="ib-sp-modal-accessibility">
    <div class="ib-mmcontent">
      <div class="ib-mwrapper ib-mgeneric">
        <div class="ib-mgcontent">
          <div class="ib-sps-page js-ib-sps-page">
            <div class="sp-body-modal">
              <div class="sp-access-content-terms">
                <h4 class="sp-title">
                  <?php echo strtoupper( __("Accessibility", IDXBOOST_DOMAIN_THEME_LANG) ); ?>
                </h4>
                <p><strong>{{propertyMetadata.termsPrivacyAda.companyAgentOrTeamName}}</strong> is committed to providing an accessible website. If you have difficulty accessing content, have difficulty viewing a file on the website, or notice any accessibility problems, please contact us to <strong>(<a href="mailto:{{agentContactEmailAddress}}">{{agentContactEmailAddress}}</a> <a href="tel:{{agentContactPhoneNumber}}">{{agentContactPhoneNumber}}</a>)</strong> to specify the nature of the accessibility issue and any assistive technology you use. NAR will strive to provide the content you need in the format you require.</p>
                <p><strong>{{propertyMetadata.termsPrivacyAda.companyAgentOrTeamName}}</strong> welcomes your suggestions and comments about improving ongoing efforts to increase the accessibility of this website.</p>
          
                <h5 class="sp-sub-title">Web Accessibility Help</h5>
                <p>There are actions you can take to adjust your web browser to make your web experience more accessible.</p>
          
                <div class="sp-access-accordion">
                  <div class="accordion-item">
                    <a class="accordion-title">I am blind or can't see very well</a>
                    <div class="sp-access-content">
                      <p>If you have trouble seeing web pages, the US Social Security Administration offers these tips (link is external) for optimizing your computer and browser to improve your online experience.</p>
                      <ul>
                        <li><a href="https://www.ssa.gov/accessibility/browseAloud.html" rel="noopener" target="_blank">Use your computer to read web pages out loud</a></li>
                        <li><a href="https://www.ssa.gov/accessibility/keyboard_nav.html" rel="noopener" target="_blank">Use the keyboard to navigate screens</a></li>
                        <li><a href="https://www.ssa.gov/accessibility/textsize.html" rel="noopener" target="_blank">Increase text size</a></li>
                        <li><a href="https://www.ssa.gov/accessibility/magnifyscreen.html" rel="noopener" target="_blank">Magnify your screen</a></li>
                        <li><a href="https://www.ssa.gov/accessibility/changecolors.html" rel="noopener" target="_blank">Change background and text colors</a></li>
                        <li><a href="https://www.ssa.gov/accessibility/mousepointer.html" rel="noopener" target="_blank">Make your mouse pointer more visible</a></li>
                      </ul>
                    </div>
                  </div>
                  <div class="accordion-item">
                    <a class="accordion-title">I find a keyboard or mouse hard to use</a>
                    <div class="sp-access-content">
                      <p>If you find a keyboard or mouse difficult to use, speech recognition software such as <a href="{{propertyMetadata.termsPrivacyAda.websiteDomain}}" target="_blank">{{propertyMetadata.termsPrivacyAda.websiteDomain}}</a> may help you navigate web pages and online services. This software allows the user to move focus around a web page or application screen through voice controls.</p>
                    </div>
                  </div>
                  <div class="accordion-item">
                    <a class="accordion-title">I am deaf or hard of hearing</a>
                    <div class="sp-access-content">
                      <p>If you are deaf or hard of hearing, there are several accessibility features available to you.</p>
                      <strong>Transcripts</strong>
                      <p>A text transcript is a text equivalent of audio information that includes spoken words and non-spoken sounds such as sound effects. NAR is working on adding transcripts to all scripted video and audio content.</p>
                      <strong>Captioning</strong>
                      <p>A caption is transcript for the audio track of a video presentation that is synchronized with the video and audio tracks. Captions are generally rendered visually by being superimposed over the video, which benefits people who are deaf and hard-of-hearing, and anyone who cannot hear the audio (e.g., when in a crowded room). Most of NAR's video content includes captions. <a href="https://support.google.com/youtube/answer/100078?hl=en" target="_blank" rel="noopener">Learn how to turn captioning on and off in YouTube.</a></p>
                      <strong>Volume controls</strong>
                      <p>Your computer, tablet, or mobile device has volume control features. Each video and audio service has its own additional volume controls. Try adjusting both your device's volume controls and your media players' volume controls to optimize your listening experience.</p>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <button class="ib-mmclose">
        <span class="ib-mmctxt">
          <?php echo __("Close", IDXBOOST_DOMAIN_THEME_LANG); ?>
        </span>
      </button>
    </div><!-- .ib-mmcontent -->

    <div class="ib-mmbg"></div>
  </div><!-- #ib-sp-modal-accessibility -->

  <div class="sps-modal-sp-slider fade">
    <div id="sps-modal-sp-slider">
      <div class="sps-wrap-slider" id="sps-gen-slider"></div>
    </div>
    <button class="sps-close">
      <?php echo __("Close", IDXBOOST_DOMAIN_THEME_LANG); ?>
    </button>
  </div>

</script>
