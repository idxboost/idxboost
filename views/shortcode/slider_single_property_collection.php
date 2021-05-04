<?php $class_filter = 'js-slider-single-property'; ?>

<section class="flex-block-description mtop-60 ib-filter-slider-property-site ib-filter-slider-<?php echo $class_filter; ?>" id="featured-section"
  data-item="<?php echo $atts['slider_item']; ?>" data-filter="<?php echo $class_filter; ?>"
  auto-play="<?php echo $atts['slider_play']; ?>" speed-slider="<?php echo $atts['slider_speed']; ?>">

  <?php  if (! empty( $atts['title'] )) { ?>
  	<h2 class="title-block single idx_txt_text_tit_property_front"><?php echo $atts['title']; ?></h2>
  <?php } ?>
  
  <div class="wrap-result view-grid">
    <div class="gs-container-slider ib-properties-slider js-ib-sp-list"></div>
  </div>

	<?php  if (! empty( $atts['link'] )) { ?>
    <a class="clidxboost-btn-link idx_txt_text_property_front" 
      href="<?php echo $atts['link']; ?>" 
      title="<?php echo $atts['name_button']; ?>"> 
      <span><?php echo $atts['name_button']; ?></span>
    </a>
  <?php } ?>

  <input type="hidden" class="ib_type_filter" value="<?php echo $atts['type']; ?>">
  <input type="hidden" class="ib_id_filter" value="<?php echo $atts['id']; ?>">

</section>

<div class="js-ib-sp-modals" id="ib-sp-modals"></div><!-- js-ib-sp-modals -->

<script class="js-ib-sp-handlebars-template" id="ib-sp-handlebars-template" type="text/x-handlebars-template">

  <div class="ib-modal-master ib-mmpd ib-md-active js-ib-sp-modal-website" id="ib-sp-modal-website">
    <div class="ib-mmcontent">
      <article class="ib-property-detail ib-pdmodal">

        <div class="ib-pcheader">
          <div class="ib-pwheader {{stylesInput.headerSection.format}}">

            <header class="ib-pheader">
              {{#ifequals stylesInput.logo.logoType "text"}}
                <h2 class="ib-ptitle">{{websiteTitle}}</h2>
                <span class="ib-pstitle">{{websiteTagline}}</span>
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
                  <a class="ib-pbtnphone" href="tel:{{agentContactPhoneNumber}}">Call Us</a>
                {{/if}}
                <div class="ib-requestinfo ib-phbtn sfm">{{stylesInput.headerSection.button.text}}</div>
                {{#if websiteSlugnameDomain}}
                  <div class="ib-pbtnopen ib-phbtn" data-permalink="{{websiteSlugnameDomain}}">Open</div>
                {{/if}}
                <div class="ib-pbtnclose ib-phbtn">Close</div>
              </div>
            </div>

          </div>
        </div>

        <div class="ib-pcontent">
          <div class="ib-sp-page js-ib-sp-page">

            <div class="sp-header" id="ib-spc-header"></div>

            <main>
              {{#if (ifVisibility visibilityRegions.headerSection)}}
                <section class="sp-animate" id="sp-welcome">
                  <h2 class="sp-main-title">
                    {{#if bannerHeadingOne}}
                      <span>"{{bannerHeadingOne}}"</span>
                    {{/if}}
                    {{#if bannerHeadingTwo}}
                      {{bannerHeadingTwo}}
                    {{/if}}
                  </h2>

                  {{#if bannerHeadingThree}}
                    <span class="sp-main-slogan">{{bannerHeadingThree}}</span>
                  {{/if}}

                  <button class="sp-btn sfm">{{stylesInput.headerSection.button.text}}</button>

                  <!-- Background video -->
                  
                  {{#ifequals bannerType 1}}
                    {{#if bannerPhotoGallery}}
                      <div class="sp-main-slider">
                        {{#each bannerPhotoGallery}}
                          <div class="sp-item">
                            <img src="{{this.full}}" alt="{{this.name}}" draggable="false">
                          </div>
                        {{/each}}
                      </div>
                    {{/if}}
                  {{/ifequals}}
                  {{#ifequals bannerType 0}}
                    {{#if bannerVideoUrl}}
                      <div class="sp-main-video" data-img="{{ bannerVideoUrl }}"></div>
                    {{/if}}
                  {{/ifequals}}
                </section>
              {{/if}}

              {{#if (ifCondOR sections.details.showHeading sections.details.showDescription) }}
                <section class="sp-section" id="sp-details">

                  {{#if (ifVisibility sections.details.showHeading) }}
                    {{#if propertyMainDescription}}
                      <h2 class="sp-section-title">{{propertyMainDescription}}</h2>
                    {{/if}}

                    <ul class="sp-list">
                      <li>
                        {{#if propertyPrice}}
                          {{formatPrice propertyPrice}} 
                        {{else}}
                          $0
                        {{/if}}
                        <span>
                          {{#if stylesInput.propertyInformation.priceLabel}}
                            {{#if stylesInput.propertyInformation.customLabel}}
                              {{stylesInput.propertyInformation.customLabel}}
                            {{else}}
                              {{replaceDashBySpace stylesInput.propertyInformation.priceLabel}}
                            {{/if}}
                          {{else}}
                            Price
                          {{/if}}
                        </span>
                      </li>

                      <li>
                        {{#if propertyBeds}}
                          {{propertyBeds}}
                        {{else}}
                          0
                        {{/if}}
                        <span>Beds</span>
                      </li>

                      <li>
                        {{#if propertyBaths}}
                          {{propertyBaths}}
                        {{else}}
                          0
                        {{/if}}
                        <span>Baths</span>
                      </li>
                    
                      <li>
                        {{#if propertyLivingSize}}
                          {{formatSqft propertyLivingSize}}
                        {{else}}
                          0
                        {{/if}}
                        <span>Living Size</span>
                      </li>
                    </ul>
                  {{/if}}

                  {{#if (ifVisibility sections.details.showDescription) }}
                    {{#if propertySecondaryDescription}}
                      {{#each propertySecondaryDescription.blocks}}

                        {{#ifequals this.type "header"}}
                          {{#ifequals this.level 2}}
                            <h2 class="sps-h2">{{ this.data.text }}</h2>
                          {{/ifequals}}

                          {{#ifequals this.level 3}}
                            <h3 class="sps-h3">{{ block.data.text }}</h3>
                          {{/ifequals}}

                          {{#ifequals this.level 4}}
                            <h4 class="sps-h4">{{ block.data.text }}</h4>
                          {{/ifequals}}

                          {{#ifequals this.level 5}}
                            <h5 class="sps-h5">{{ block.data.text }}</h5>
                          {{/ifequals}}
                        {{/ifequals}}

                        {{#ifequals this.type "paragraph"}}
                          <div class="sps-paragraph">
                            <p>{{{this.data.text}}}</p>
                          </div>
                        {{/ifequals}}

                        {{#ifequals this.type "list"}}
                          {{#ifequals this.data.style "ordered"}}
                            <ol class="sps-olist">
                              {{#each this.data.items}}
                                <li>{{{this}}}</li>
                              {{/each}}
                            </ol>
                          {{/ifequals}}

                          {{#ifequals this.data.style "unordered"}}
                            <ul class="sps-ulist">
                              {{#each this.data.items}}
                                <li>{{{this}}}</li>
                              {{/each}}
                            </ul>
                          {{/ifequals}}
                        {{/ifequals}}

                      {{/each}}
                    {{/if}}
                  {{/if}}

                </section>
              {{/if}}

              {{#if (ifVisibility visibilityRegions.amenities)}}
                <section class="sp-section" id="sp-amenities">
                  <h2 class="sp-section-title">Amenities</h2>

                  {{#if propertyAmenities}}
                    <ul class="sp-amenities-list columns-{{stylesInput.amenities.columns}}">
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
                  <section class="sp-gallery sp-animate" id="sp-gallery">
                    <ul class="sp-slider sp-sp-slider" id="sp-slider-galery">
                      {{#each propertyPhotoGallery}}
                        <li class="sp-sl-item">
                          <a class="sp-item sp-modal-galery" href="#">
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
              
              <div class="sp-section sp-animate" id="sp-media">
                <div class="sp-wrap-media">
                {{#if (ifVisibility visibilityRegions.videoTour)}}
                  <div class="sp-tab-body" id="sp-media-tour">
                    <h2 class="sp-section-title">Video Tour</h2>

                    <div id="sp-virtual">
                      {{#if propertyMetadata.propertyVideos}}
                        <div class="sp-slider-video" id="sp-slider-video">
                          {{#each propertyMetadata.propertyVideos}}
                            {{#if this.videoUrl}}
                              <div class="sp-item sp-item-video" data-video="{{this.videoUrl}}" 
                                data-title="{{this.videoName}}">
                                <button class="sp-play-video">Play</button>
                              </div>
                            {{else}}
                              <div class="sp-item sp-item-video" 
                                data-video="<?php echo FLEX_IDX_URI; ?>images/single-property/medium-default-video.jpg" 
                                src="<?php echo FLEX_IDX_URI; ?>images/single-property/temp.png">
                              </div>
                            {{/if}}
                          {{/each}}
                        </div>
                      {{else}}
                        <div class="sp-slider-video">
                          <div class="sp-item sp-item-video">
                            <img class="sp-lazy" alt="" 
                              src="<?php echo FLEX_IDX_URI; ?>images/single-property/medium-default-video.jpg">
                          </div>
                        </div>
                      {{/if}}
                    </div>
                  </div>
                {{/if}}

                {{#if (ifVisibility visibilityRegions.floorplans)}}
                  <div class="sp-tab-body" id="sp-media-floorplan">
                    <h2 class="sp-section-title">Floorplans</h2>

                    {{#if propertyFloorplans}}
                      <div id="sp-floorplans">
                        <div class="sp-wrap-slider" id="sp-slider-wp">
                          <div id="sp-slider-prop" class="sp-slider sp-sp-slider">
                          {{#each propertyFloorplans}}
                            <div class="sp-item">
                              <div class="sp-sl-item">
                                <div class="sp-wrap-img sp-modal-galery" role="button" aria-label="Nombre del Floorplans #{{@index}}">
                                  <img class="sp-lazy" alt="{{this.altText}}" src="{{this.full}}" draggable="false">
                                </div>
                                <div class="sp-wrap-btn">
                                  <h3 class="sp-floorplan-title">
                                    {{this.altText}}
                                  </h3>
                                  <!--<a href="#" class="sp-link">Download PDF</a>-->
                                </div>
                              </div>
                            </div>
                          {{/each}}
                          </div>

                          {{#if (propertyHasFloorplans propertyFloorplans)}}
                            <div class="sp-wrap-action-btn">
                              <button class="sp-btn-prev">Prev</button>
                              <button class="sp-btn-next">Next</button>
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
                <div class="sp-section" id="sp-location">
                  <h2 class="sp-section-title">Location</h2>
                  {{#if propertyLocationCoords}}
                  <div class="sp-map" id="googleMap" data-img="googleMap"
                    data-zoom="{{#if propertyLocationCoords.zoom}} {{propertyLocationCoords.zoom}} {{else}}16{{/if}}"
                    data-lat="{{#if propertyLocationCoords.lat}} {{propertyLocationCoords.lat}} {{else}}43.542194{{/if}}" 
                    data-lng="{{#if propertyLocationCoords.lng}} {{propertyLocationCoords.lng}} {{else}}-5.676875{{/if}}">
                  </div>
                  {{else}}
                    <div class="sp-map">
                      <img class="sp-map-img" alt=""
                        src="<?php echo FLEX_IDX_URI; ?>images/single-property/medium-default-map.jpg">
                    </div>
                  {{/if}}
                </div>
              {{/if}}

              {{#if (ifVisibility visibilityRegions.contactUs)}}
                <div class="sp-section" id="sp-contact">
                  <div class="sp-wrap-form">

                    <h2 class="sp-form-title">Contact Us</h2>
                    <div class="sp-contact-header">
                      {{#if agentPhotoProfile.ObjectURL}}
                        <div class="sp-wrap-img">
                          <img class="sp-lazy" alt="" src="{{ agentPhotoProfile.ObjectURL }}">
                        </div>
                      {{/if}}
                      <ul class="sp-agent-info {{#unless agentPhotoProfile.ObjectURL }} sps-agent-info-alt {{/unless}}">
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

                    <div class="sp-contact-body">
                      <form class="js-ib-sp-contact-form" method="post" id="contact-us-form">
                        <fieldset>
                          <legend>{{stylesInput.headerSection.button.text}} Form</legend>
                          <input type="hidden" name="ib_tags" value="{{stylesInput.headerSection.button.text}} {{websiteName}}">
                          <input type="hidden" name="action" value="idxboost_contact_inquiry">
                          <ul>
                            <li>
                              <label for="input_name">Enter your Name</label>
                              <input type="text" placeholder="Name" name="name" id="input_name" required>
                            </li>
                            <li>
                              <label for="input_lastname">Enter your last name</label>
                              <input type="text" placeholder="Last Name" name="lastname" id="input_lastname" required>
                            </li>
                            <li>
                              <label for="input_email">Enter your email</label>
                              <input type="email" placeholder="Email" name="email" id="input_email" required>
                            </li>
                            <li>
                              <label for="input_phone">Enter your phone number</label>
                              <input type="text" placeholder="Phone" name="phone" id="input_phone" required>
                            </li>
                            <li>
                              <label for="input_comment">Enter a comment</label>
                              <textarea placeholder="Comments" name="message" cols="30" rows="10" id="input_comment" required></textarea>
                            </li>
                          </ul>
                          <button class="sp-btn" type="submit">{{stylesInput.headerSection.button.text}}</button>
                        </fieldset>
                      </form>
                    </div>

                  </div>
                </div><!-- #sp-contact -->
              {{/if}}
            </main>

            <div class="sp-section" id="sp-footer">
              <div class="sp-footer-img {{#ifCond brokerLogo propertyMetadata.associationLogo }} sp-footer-img-alt {{/ifCond }}">
                {{#if brokerLogo }}
                  <img class="sps-lazy" alt="" src="{{brokerLogo}}">
                {{/if}}
                {{#if propertyMetadata.associationLogo}}
                  <img class="sps-lazy" alt="" src="{{propertyMetadata.associationLogo}}">
                {{/if }}
              </div>

              <div class="sp-bottom-footer">
                <ul class="sp-sub-menu-footer">
                  <li>
                    <a class="sp-show-modal" href="/terms-and-conditions/" 
                      title="Go to Privacy page" data-modal=".js-ib-sp-modal-privacy">
                      Privacy</a>
                  </li>
                  <li>
                    <a class="sp-show-modal" href="terms-and-conditions/#atospp-privacy" 
                      title="Go to Terms of Service page" data-modal=".js-ib-sp-modal-privacy">
                      Terms and Conditions</a>
                  </li>
                  <li>
                    <a class="sp-show-modal" href="/accessibility/" 
                      title="Go to Accessibility page" data-modal=".js-ib-sp-modal-accessibility">
                      Accessibility</a>
                  </li>
                </ul>

                <p class="sp-copyright">&copy; Copyright <?php echo date('Y'); ?></p>

                <div class="sp-trem">
                  <div class="sp-trem-link">
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
          <div class="ib-sp-page js-ib-sp-page">
            <div class="sp-modal-body">
              <h4 class="sp-modal-title">{{stylesInput.headerSection.button.text}}</h4>
              <p>
                Call us now: 
                <a class="sp-black" href="tel:{{agentContactPhoneNumber}}">{{agentContactPhoneNumber}}</a> <br> 
                Fill the form below and we'll contact <br> you back promptly.
              </p>
              <form class="js-ib-sp-contact-form" method="post" id="request-details-form">
                <fieldset>
                  <legend>{{stylesInput.headerSection.button.text}} Form</legend>
                  <input type="hidden" name="ib_tags" value="{{stylesInput.headerSection.button.text}} {{websiteName}}">
                  <input type="hidden" name="action" value="idxboost_contact_inquiry">
                  <div class="sp-input-form">
                    <label for="inputName">Enter your Name</label>
                    <input type="text" placeholder="Name" name="name" id="inputName" required>
                  </div>
                  <div class="sp-input-form">
                    <label for="inputLastName">Enter your Last Name</label>
                    <input type="text" placeholder="Last Name" name="lastname" id="inputLastName" required>
                  </div>
                  <div class="sp-input-form">
                    <label for="inputEmail">Enter your Email</label>
                    <input type="email" placeholder="Email" name="email" id="inputEmail" required>
                  </div>
                  <div class="sp-input-form">
                    <label for="inputPhone">Enter your Phone number</label>
                    <input type="phone" placeholder="Phone" name="phone" id="inputPhone" required>
                  </div>
                  <div class="sp-input-form">
                    <label for="inputComment">Enter your Comment</label>
                    <textarea placeholder="Comments" name="message" id="inputComment" required></textarea>
                  </div>
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
        <span class="ib-mmctxt">Close</span>
      </button>
    </div><!-- .ib-mmcontent -->

    <div class="ib-mmbg"></div>
  </div><!-- #ib-sp-modal-contact -->

  <div class="ib-modal-master js-ib-sp-modal-privacy" id="ib-sp-modal-privacy">
    <div class="ib-mmcontent">
      <div class="ib-mwrapper ib-mgeneric">
        <div class="ib-mgcontent">
          <div class="ib-sp-page js-ib-sp-page">
            <div class="sp-body-modal">
              <div>
                <h4 class="sp-title">TERMS AND CONDITIONS</h2>
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
                  <h5 class="sp-sub-title">Privacy Policy:</h5>
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
        <span class="ib-mmctxt">Close</span>
      </button>
    </div><!-- .ib-mmcontent -->

    <div class="ib-mmbg"></div>
  </div><!-- #ib-sp-modal-privacy -->

  <div class="ib-modal-master js-ib-sp-modal-accessibility" id="ib-sp-modal-accessibility">
    <div class="ib-mmcontent">
      <div class="ib-mwrapper ib-mgeneric">
        <div class="ib-mgcontent">
          <div class="ib-sp-page js-ib-sp-page">
            <div class="sp-body-modal">
              <div class="sp-access-content-terms">
                <h4 class="sp-title">ACCESSIBILITY</h4>
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
        <span class="ib-mmctxt">Close</span>
      </button>
    </div><!-- .ib-mmcontent -->

    <div class="ib-mmbg"></div>
  </div><!-- #ib-sp-modal-accessibility -->

  <div class="sps-modal-sp-slider fade">
    <div id="sps-modal-sp-slider">
      <div class="sps-wrap-slider" id="sps-gen-slider"></div>
    </div>
    <button class="sps-close">Close</button>
  </div>

</script>