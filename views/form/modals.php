<?php
  global $flex_idx_info, $flex_idx_lead;
  $idxboost_term_condition = get_option('idxboost_term_condition');
  $mkting_client = get_option('mkting_client');
  $idxboost_agent_info = get_option('idxboost_agent_info');
  $disclaimer_checked = $flex_idx_info['agent']['disclaimer_checked'];
  $show_why_register = $flex_idx_info['agent']['show_why_register'];
  $idxboost_term_condition = get_option('idxboost_term_condition');

  $idx_v = ( array_key_exists("idx_v", $flex_idx_info["agent"] ) && !empty($flex_idx_info["agent"]["idx_v"]) ) ? $flex_idx_info["agent"]["idx_v"] : '0';

  if($disclaimer_checked == "1"){
    $checked = "checked";
    $checked_active = "";
  }else{
    $checked = "";
    $checked_active = "disabled";
  }

?>
<script type="text/javascript">
  var SIGNUP_EXTENDS_QUIZZ = '<?php echo (isset($flex_idx_info["agent"]["user_show_quizz"]) && ("1" == $flex_idx_info["agent"]["user_show_quizz"])) ? '1' : '0'; ?>';
  window.idx_company_info = {company_name : '<?php echo $idxboost_term_condition["company_name"]; ?>' };

  var IS_CUSTOM_SIGNUP = false;

  // console.log(SIGNUP_EXTENDS_QUIZZ);

  //var SIGNUP_EXTENDS_QUIZZ = '<?php echo (isset($flex_idx_info["agent"]["force_registration"]) && ("1" == $flex_idx_info["agent"]["force_registration"])) ? '1' : '0'; ?>';

  if (typeof originalPositionY === "undefined") {
    var originalPositionY;
  }
</script>



<?php if( $idx_v == "1" ) {  ?>
<div id="root-property-modal"></div>
<div id="tutorial-ai-modal"></div>
<div id="property-modal"></div>
<div id="gallery-modal"></div>
<div id="share-modal"></div>
<div id="contact-modal"></div>
<div id="video-modal"></div>
<div id="calculator-modal"></div>
<div id="save-modal"></div>
<?php } ?>



<!--MODAL EDIT ALERT FORM HISTORY MENU-->
<div class="ib-modal-master" data-id="edit-search" id="ib-fsearch-edit-modal">
  <div class="ib-mmcontent">
    <div class="ib-mwrapper ib-mgeneric">
      <div class="ib-mgheader">
        <h4 class="ib-mghtitle"><?php echo __('Edit Search', IDXBOOST_DOMAIN_THEME_LANG); ?></h4>
      </div>
      <div class="ib-mgcontent">
        <form method="post" class="flex-edit-search-modals">
          <input type="hidden" name="action" value="update_criterial_alert">

          <input type="hidden" name="token_alert" class="token_alert_update_criterial" value="">
          <ul class="ib-msavesearch">
            <li class="ib-mssitem"><span class="ib-mssitxt"><?php echo __('Email Updates', IDXBOOST_DOMAIN_THEME_LANG); ?></span>
              <div class="ib-mgiwrapper ib-mgwselect">
                <label class="ms-hidden" for="ib-mgwselect-edit"><?php echo __('Email Updates', IDXBOOST_DOMAIN_THEME_LANG); ?></label>
                <select class="ib-mssselect" name="notification_day" id="ib-mgwselect-edit">
                  <option value="--"><?php echo __('No Alert', IDXBOOST_DOMAIN_THEME_LANG); ?></option>
                  <option value="1" selected=""><?php echo __('Daily', IDXBOOST_DOMAIN_THEME_LANG); ?></option>
                  <option value="7"><?php echo __('Weekly', IDXBOOST_DOMAIN_THEME_LANG); ?></option>
                  <option value="30"><?php echo __('Monthly', IDXBOOST_DOMAIN_THEME_LANG); ?></option>
                </select>
              </div>
            </li>
            <li class="ib-mssitem"><span class="ib-mssitxt"><?php echo __('Only Update me On', IDXBOOST_DOMAIN_THEME_LANG); ?></span>
              <ul class="ib-mssupdate">
                <li class="ib-mssuitem">
                  <input class="ib-msscheckbox" type="checkbox" id="ib-check-new-listing-edit" name="notification_type_edit[]" value="new_listing" checked>
                  <label class="ib-msslabel" for="ib-check-new-listing-edit"><?php echo __('New Listing (Always)', IDXBOOST_DOMAIN_THEME_LANG); ?></label>
                </li>
                <li class="ib-mssuitem">
                  <input class="ib-msscheckbox" type="checkbox" id="ib-check-price-change-edit" name="notification_type_edit[]" value="price_change" checked>
                  <label class="ib-msslabel" for="ib-check-price-change-edit"><?php echo __('Price Change', IDXBOOST_DOMAIN_THEME_LANG); ?></label>
                </li>
                <li class="ib-mssuitem">
                  <input class="ib-msscheckbox" type="checkbox" id="ib-check-status-change-edit" name="notification_type_edit[]" value="status_change" checked>
                  <label class="ib-msslabel" for="ib-check-status-change-edit"><?php echo __('Status Change', IDXBOOST_DOMAIN_THEME_LANG); ?></label>
                </li>
              </ul>
            </li>
          </ul>
          <button class="ib-mgsubmit"><?php echo __('Save Search', IDXBOOST_DOMAIN_THEME_LANG); ?></button>
        </form>
      </div>
    </div>
    <div class="ib-mmclose js-close-mds" role="button" aria-label="Close"><span class="ib-mmctxt"><?php echo __('Close', IDXBOOST_DOMAIN_THEME_LANG); ?></span></div>
  </div>
  <div class="ib-mmbg"></div>
</div>

<!--MODAL GALLERY-->
<div id="content-modals">

  <!-- FULL SLIDER
  <div class="overlay_modal" id="modal_img_propertie">
    <div class="content-modal-full-slider">
      <div class="modal-full-slider">
        <span class="title worked"></span>
        <div class="wrapper-img">
          <ul class="actions-buttons">
            <li class="close-modal"><button><span class="icon-close"><?php //echo __('Close', IDXBOOST_DOMAIN_THEME_LANG); ?></span></button></li>
          </ul>
          <span class="numeration"><span>2</span> <?php //echo __('of', IDXBOOST_DOMAIN_THEME_LANG); ?> <span>14</span></span>
          <img src="/" class="img" alt="Idxboost" width="1" height="1">
          <button class="prev nav" aria-label="Prev"><span class="icon-arrow-select"></span></button>
          <button class="next nav" aria-label="Next"><span class="icon-arrow-select"> </span></button>
        </div>
      </div>
    </div>
    <div class="overlay_modal_closer" data-id="modal_img_propertie"></div>
  </div> -->

  <!-- REGISTER LOGIN registration_forced-->
  <div class="overlay_modal modalReferentFUB" id="modal_login">

    <div class="ms-new-wrapper-modal-login-register">
      <div class="modal_cm">

        <?php if($show_why_register == "1"): ?>
        <div class="ms-box-info" id="msboxinfo">
          <div class="ms-box-info-wrapper">
            <div class="ms-box-header">
              <h5 class="ms-title"><?php echo __('Why Create An Account?', IDXBOOST_DOMAIN_THEME_LANG); ?></h5>
              <button class="ms-close-box js-close-why-register" aria-label="<?php echo __('Close Modal', IDXBOOST_DOMAIN_THEME_LANG); ?>">
                <i class="idx-icon-close"></i>
              </button>
            </div>
            <div class="ms-box-body">
              <ul class="ms-list">
                <li>
                  <div class="ms-img-icon">
                    <i class="idx-icon-alert"></i>
                  </div>
                  <div class="ms-info-detail">
                    <strong><?php echo __('Get new alerts', IDXBOOST_DOMAIN_THEME_LANG); ?></strong>
                    <p><?php echo __('We will notify you when a new listing that matches your search criteria hits the market. Be the first to know of new listings!', IDXBOOST_DOMAIN_THEME_LANG); ?></p>
                  </div>
                </li>
                <li>
                  <div class="ms-img-icon">
                    <i class="idx-icon-check-active"></i>
                  </div>
                  <div class="ms-info-detail">
                    <strong><?php echo __('Save your favorite listings', IDXBOOST_DOMAIN_THEME_LANG); ?></strong>
                    <p><?php echo __('Save an unlimited number of listings on our site for easy access when you return', IDXBOOST_DOMAIN_THEME_LANG); ?>.</p>
                  </div>
                </li>
                <li>
                  <div class="ms-img-icon">
                    <i class="idx-icon-shared"></i>
                  </div>
                  <div class="ms-info-detail">
                    <strong><?php echo __('Share properties with friends', IDXBOOST_DOMAIN_THEME_LANG); ?></strong>
                    <p><?php echo __('Easily share your favorite properties with your friends and family via email', IDXBOOST_DOMAIN_THEME_LANG); ?>.</p>
                  </div>
                </li>
                <li>
                  <div class="ms-img-icon">
                    <i class="idx-icon-checkmark"></i>
                  </div>
                  <div class="ms-info-detail">
                    <strong><?php echo __('View property history', IDXBOOST_DOMAIN_THEME_LANG); ?></strong>
                    <p><?php echo __('View property history and keep track of listings you have recently viewed', IDXBOOST_DOMAIN_THEME_LANG); ?>.</p>
                  </div>
                </li>
              </ul>
            </div>
          </div>
        </div>
        <?php endif ?>

        <div class="content_md">
          <div class="heder_md">
            <span class="ms-title-modal">
              <?php echo __('Welcome Back', IDXBOOST_DOMAIN_THEME_LANG); ?>
            </span>
          </div>

          <div class="body_md">
            <ul class="header-tab">
              <li>
                <a role="button" 
                data-tab="tabLogin" 
                class="ib-tabLogin active" 
                data-text="<?php echo __('Welcome Back', IDXBOOST_DOMAIN_THEME_LANG); ?>" 
                data-text-force="<?php echo __('Welcome Back', IDXBOOST_DOMAIN_THEME_LANG); ?>">
                  <?php echo __('Log in', IDXBOOST_DOMAIN_THEME_LANG); ?>
                </a>
              </li>
              <li>
                <a role="button" data-tab="tabRegister" data-text="<?php echo __('Register for a personalized experience', IDXBOOST_DOMAIN_THEME_LANG); ?>" data-text-force="<?php echo __('Register for a personalized experience', IDXBOOST_DOMAIN_THEME_LANG); ?>">
                  <?php echo __('Register', IDXBOOST_DOMAIN_THEME_LANG); ?>
                </a>
              </li>
              <li>
                <a role="button" data-tab="tabReset" data-text="<?php echo __('Reset Password', IDXBOOST_DOMAIN_THEME_LANG); ?>" data-text-force="<?php echo __('Reset Password', IDXBOOST_DOMAIN_THEME_LANG); ?>">
                  <?php echo __('Reset Password', IDXBOOST_DOMAIN_THEME_LANG); ?>
                </a>
              </li>
            </ul>

            <div id="tabLogin" class="item_tab active" data-text="<?php echo __('Welcome Back', IDXBOOST_DOMAIN_THEME_LANG); ?>">
              <div class="ms-text">
                <?php echo __('Not registered yet?', IDXBOOST_DOMAIN_THEME_LANG); ?> <a role="button" class="ms-strong ms-tab" data-tab="tabRegister" data-text="<?php echo __('Register for a personalized experience', IDXBOOST_DOMAIN_THEME_LANG); ?>"><?php echo __('Register now', IDXBOOST_DOMAIN_THEME_LANG); ?></a>
              </div>
              <div class="form_content">
                <form id="formLogin" method="post">
                <fieldset>
                    <legend><?php echo __('Register', IDXBOOST_DOMAIN_THEME_LANG); ?></legend>                <input type="hidden" name="ib_tags" id="formLogin_ib_tags" value="">
                  <input type="hidden" name="window_width" class="formRegister_windowWidth" value="">
                  <input type="hidden" name="logon_type" value="email">
                  <input name="action" type="hidden" value="flex_idx_lead_signin">
                  <ul class="form_md" id="cntLoginForm">
                    <li class="form_input">
                      <label for="txt_user"><?php echo __('Enter email', IDXBOOST_DOMAIN_THEME_LANG); ?></label>
                      <input id="txt_user" autocomplete="disabled" autocorrect="off" autocapitalize="off" spellcheck="false" name="user_name" placeholder="<?php echo __('Enter email', IDXBOOST_DOMAIN_THEME_LANG); ?>" required type="email" value="">
                    </li>
                    <li class="form_input">
                      <label for="txt_pwd"><?php echo __('Enter password', IDXBOOST_DOMAIN_THEME_LANG); ?></label>
                      <input id="txt_pwd" name="user_pass" autocomplete="new-password" placeholder="<?php echo __('Enter password', IDXBOOST_DOMAIN_THEME_LANG); ?>" required type="password" value="">
                      <span action="hide" class="showpassord"></span>
                    </li>
                  </ul>
                  <button class="btn_form" id="clidxboost-btn-user-login" type="submit"><?php echo __('Continue with email', IDXBOOST_DOMAIN_THEME_LANG); ?></button>
                </fieldset>
                </form>
              </div>
            </div>

            <div id="tabRegister" class="item_tab" data-text="<?php echo __('Register for a personalized experience', IDXBOOST_DOMAIN_THEME_LANG); ?>">
              <div class="ms-back">
                <button class="ms-icon-back" aria-label="<?php echo __("Back", IDXBOOST_DOMAIN_THEME_LANG); ?>">
                  <span></span>
                </button>
              </div>

              <div class="form_content">
                <div id="push-registration">

                  <form id="formRegister" method="post" class="gtm_lead_registration iboost-form-validation">
                  <?php
                    global $agent_registration_key;

                    if (isset($agent_registration_key)) : ?>
                    <input type="hidden" name="registration_key" value="<?php echo $agent_registration_key; ?>">
                  <?php endif; ?>
                  <fieldset>
                    <legend><?php echo __('Register', IDXBOOST_DOMAIN_THEME_LANG); ?></legend>
                    <input type="hidden" name="ib_tags" id="formRegister_ib_tags" value="">
                    <input type="hidden" name="logon_type" id="formRegister_logonType" value="email">
                    <input type="hidden" name="register_password" id="formRegister_password" value="">
                    <input type="hidden" name="window_width" class="formRegister_windowWidth" value="">
                    <input type="hidden" class="ib_property_signup_price" name="__property_signup_price" value="">
                    <input type="hidden" name="action" value="flex_idx_lead_signup">

                    <?php if (array_key_exists('google_gtm', $flex_idx_info['agent']) && !empty($flex_idx_info['agent']['google_gtm'])) : ?>
                      <input type="hidden" name="gclid_field" id="gclid_field_form_lead_registration">
                    <?php endif; ?>

                    <ul class="pr-steps-container">
                      <li class="pr-step active">
                        <label class="ms-sub-text small" for="agilefield-9"><?php echo __('Register with your email address', IDXBOOST_DOMAIN_THEME_LANG); ?></label>
                        <div class="wrapper-input">
                          <p class="dgt-email-error"><?php echo __('Looks like you already have an account with us.. Try logging in or resetting your password.', IDXBOOST_DOMAIN_THEME_LANG); ?></p>
                          <input id="agilefield-9" name="register_email" type="email" class="agile-height-default" placeholder="Email" required value="">
                        </div>
                        <button class="pr-redbtn pr-next-step" type="button"><?php echo __('Continue with email', IDXBOOST_DOMAIN_THEME_LANG); ?></button>
                      </li>

                      <li class="pr-step email-registration">
                        <div class="ms-header-md">
                          <span class="ms-title-modal ms-no-mb"><?php echo __('Enter name and password', IDXBOOST_DOMAIN_THEME_LANG); ?></span>
                          <span class="pr-dgray"><?php echo __('Just a few more details so we can help you.', IDXBOOST_DOMAIN_THEME_LANG); ?></span>
                        </div>
                        
                        <div class="name-input-content">
                          <div class="wrapper-input item-name">
                              <label class="agile-label" for="agilefield-6"><?php echo __('First Name', IDXBOOST_DOMAIN_THEME_LANG); ?></label>
                              <input id="agilefield-6" name="register_name" type="text" class="agile-height-default" placeholder="<?php echo __('First Name', IDXBOOST_DOMAIN_THEME_LANG); ?>" required value="">
                          </div>
                          <div class="wrapper-input item-name">
                              <label class="agile-label" for="agilefield-7"><?php echo __('Last Name', IDXBOOST_DOMAIN_THEME_LANG); ?></label>
                              <input id="agilefield-7" name="register_last_name" type="text" class="agile-height-default" placeholder="<?php echo __('Last Name', IDXBOOST_DOMAIN_THEME_LANG); ?>" required value="">
                          </div>
                        </div>

                        <div class="wrapper-input">
                          <label class="agile-label ms-strong" for="agilefield-8"><?php echo __('Use phone number as password', IDXBOOST_DOMAIN_THEME_LANG); ?></label>
                          <input id="agilefield-8" name="register_phone" type="tel" placeholder="<?php echo __('Phone number', IDXBOOST_DOMAIN_THEME_LANG); ?>" class="phoneRegisterValidation" required value="">
                        </div>
                        <button class="pr-redbtn pr-registering" type="button"><?php echo __("I'm finished", IDXBOOST_DOMAIN_THEME_LANG); ?></button>
                      </li>

                      <?php if ((isset($flex_idx_info["agent"]["user_show_quizz"]) && ("1" == $flex_idx_info["agent"]["user_show_quizz"])) ): ?>
                      <li class="pr-step pr-radio">
                        <div class="ms-header-md">
                          <span class="ms-title-modal ms-no-mb"><?php echo __("Thank You For Registering", IDXBOOST_DOMAIN_THEME_LANG); ?></span>
                          <div class="ms-text">
                            <p><?php echo __('Just a few more details so we can help you.', IDXBOOST_DOMAIN_THEME_LANG); ?></p>
                            <p><?php echo __('(All fields are required)', IDXBOOST_DOMAIN_THEME_LANG); ?></p>
                          </div>
                          <div class="ms-icon ms-time"></div>
                          <span class="ms-sub-title ms-no-mb"><?php echo __('When are you looking to purchase?', IDXBOOST_DOMAIN_THEME_LANG); ?></span>
                        </div>
                        <ul class="pr-radio-list">
                          <li>
                            <input class="ibregister-btn" type="radio" name="timeline_for_purchase" id="inline_radios_1513789754550-0" value="1_3_months">
                            <label for="inline_radios_1513789754550-0" class="i-checks"><?php echo __("Within 1-3 months", IDXBOOST_DOMAIN_THEME_LANG); ?></label>
                          </li>
                          <li>
                            <input class="ibregister-btn" type="radio" name="timeline_for_purchase" id="inline_radios_1513789754550-1" value="3_6_months">
                            <label for="inline_radios_1513789754550-1" class="i-checks"><?php echo __("Within 3-6 months", IDXBOOST_DOMAIN_THEME_LANG); ?></label>
                          </li>
                          <li>
                            <input class="ibregister-btn" type="radio" name="timeline_for_purchase" id="inline_radios_1513789754550-2" value="6_months_more">
                            <label for="inline_radios_1513789754550-2" class="i-checks"><?php echo __("More than 6 months", IDXBOOST_DOMAIN_THEME_LANG); ?></label>
                          </li>
                        </ul>
                      </li>
                      <li class="pr-step pr-radio">
                        <div class="ms-header-md">
                          <span class="ms-title-modal ms-no-mb"><?php echo __("Thank You For Registering", IDXBOOST_DOMAIN_THEME_LANG); ?></span>
                          <div class="ms-text">
                            <p><?php echo __('Just a few more details so we can help you.', IDXBOOST_DOMAIN_THEME_LANG); ?></p>
                            <p><?php echo __('(All fields are required)', IDXBOOST_DOMAIN_THEME_LANG); ?></p>
                          </div>
                          <div class="ms-icon ms-financing"></div>
                          <span class="ms-sub-title ms-no-mb"><?php echo __('Need assistance with financing?', IDXBOOST_DOMAIN_THEME_LANG); ?></span>
                        </div>
                        <ul class="pr-radio-list">
                          <li>
                            <input class="ibregister-btn" type="radio" name="mortgage_approved" id="inline_radios_1513789825341-0" value="yes">
                            <label for="inline_radios_1513789825341-0" class="i-checks"><?php echo __("I am pre-approved", IDXBOOST_DOMAIN_THEME_LANG); ?></label>
                          </li>
                          <li>
                            <input class="ibregister-btn" type="radio" name="mortgage_approved" id="inline_radios_1513789825341-1" value="no">
                            <label for="inline_radios_1513789825341-1" class="i-checks"><?php echo __("Not pre-approved yet", IDXBOOST_DOMAIN_THEME_LANG); ?></label>
                          </li>
                          <li>
                            <input class="ibregister-btn" type="radio" name="mortgage_approved" id="inline_radios_1513789825341-2" value="buying_with_cash">
                            <label for="inline_radios_1513789825341-2" class="i-checks"><?php echo __("I prefer to buy with cash", IDXBOOST_DOMAIN_THEME_LANG); ?></label>
                          </li>
                        </ul>
                      </li>
                      <li class="pr-step pr-radio">
                        <div class="ms-header-md">
                          <span class="ms-title-modal ms-no-mb"><?php echo __("Thank You For Registering", IDXBOOST_DOMAIN_THEME_LANG); ?></span>
                          <div class="ms-text">
                            <p><?php echo __('Just a few more details so we can help you.', IDXBOOST_DOMAIN_THEME_LANG); ?></p>
                            <p><?php echo __('(All fields are required)', IDXBOOST_DOMAIN_THEME_LANG); ?></p>
                          </div>
                          <div class="ms-icon ms-sale"></div>
                          <span class="ms-sub-title ms-no-mb"><?php echo __('Need to also sell your property?', IDXBOOST_DOMAIN_THEME_LANG); ?></span>
                        </div>
                        <ul class="pr-radio-list">
                          <li>
                            <input type="radio" name="sell_a_home" id="inline_radios_15137898580630-0" value="yes">
                            <label class="ibregister-tg-submit" for="inline_radios_15137898580630-0"><?php echo __("Looking to sell too", IDXBOOST_DOMAIN_THEME_LANG); ?></label>
                          </li>
                          <li>
                            <input type="radio" name="sell_a_home" id="inline_radios_15137898580631-1" value="no">
                            <label class="ibregister-tg-submit" for="inline_radios_15137898580631-1"><?php echo __("Not looking to sell", IDXBOOST_DOMAIN_THEME_LANG); ?></label>
                          </li>
                          <li>
                            <input type="radio" name="sell_a_home" id="inline_radios_15137898580632-2" value="not_sure_yet">
                            <label class="ibregister-tg-submit" for="inline_radios_15137898580632-2"><?php echo __("Not sure yet", IDXBOOST_DOMAIN_THEME_LANG); ?></label>
                          </li>
                        </ul>
                      </li>
                      <?php endif; ?>
                    </ul>
                    <span id="agile-error-msg"></span>
                  </fieldset>
                  </form>
                </div>
              </div>
            </div>

            <div id="tabReset" class="item_tab" data-text="<?php echo __('Reset Password', IDXBOOST_DOMAIN_THEME_LANG); ?>">
              
              <div class="ms-back">
                <button class="ms-icon-back" aria-label="<?php echo __("Back", IDXBOOST_DOMAIN_THEME_LANG); ?>">
                  <span></span>
                </button>
              </div>

              <div class="form_content">
                <form  id="formReset" method="post" name="formReset">
                  <fieldset>
                    <legend><?php echo __('Reset password', IDXBOOST_DOMAIN_THEME_LANG); ?></legend>
                  <p id="ms-recovery-password-text"><?php echo __("Enter your email address and we'll send you a link to be able to change your password", IDXBOOST_DOMAIN_THEME_LANG); ?></p>
                  <p style="display: none" id="ms-new-password-text"><?php echo __("Enter your new password", IDXBOOST_DOMAIN_THEME_LANG); ?></p>

                  <ul class="form_md" id="cntResetForm">
                    <li class="form_input" id="ms-recovery-password">
                      <label  for="reset_email" class="agile-label ms-xt"><?php echo __("Email Address", IDXBOOST_DOMAIN_THEME_LANG); ?></label>
                      <input id="reset_email" autocorrect="off" autocapitalize="off" spellcheck="false" autocomplete="disabled" name="reset_email" placeholder="<?php echo __("Enter E-mail", IDXBOOST_DOMAIN_THEME_LANG); ?>" required type="email"/>
                    </li>
                    <li class="form_input" style="display: none" id="ms-new-password">
                      <label class="agile-label" for="reset_password"><?php echo __("Use phone number as password", IDXBOOST_DOMAIN_THEME_LANG); ?></label>
                      <input id="reset_password" autocorrect="off" autocapitalize="off" spellcheck="false" autocomplete="disabled" name="reset_password" placeholder="<?php echo __("Phone number", IDXBOOST_DOMAIN_THEME_LANG); ?>" type="password"/>
                      <span action="hide" class="showpassord"></span>
                    </li>
                  </ul>
                  
                  <button class="btn_form" id="clidxboost-btn-user-reset" type="submit">
                  <?php echo __("Send", IDXBOOST_DOMAIN_THEME_LANG); ?>
                  </button>

                  <input name="action" class="action" type="hidden" value="flex_idx_lead_resetpass">
                  <input name="tokepa" class="tokepa" type="hidden" value="">
                  </fieldset>
                </form>
              </div>
            </div>
            
            <?php if ((isset($flex_idx_info["agent"]["google_login_enabled"]) && "1" == $flex_idx_info["agent"]["google_login_enabled"]) || (isset($flex_idx_info["agent"]["facebook_login_enabled"]) && "1" == $flex_idx_info["agent"]["facebook_login_enabled"])): ?>

              <div class="line_or"><span><?php echo __('or', IDXBOOST_DOMAIN_THEME_LANG); ?></span></div>

              <div class="ms-wrapper-sml">
                <ul class="social_login <?php echo $checked_active; ?>" id="socialMediaRegister">
                  <?php if (isset($flex_idx_info["agent"]["facebook_login_enabled"]) && "1" == $flex_idx_info["agent"]["facebook_login_enabled"]): ?>
                    <li>
                      <a role="button" class="ico-facebook flex-social-login-fb" onclick="fb_login();">
                        <?php echo __('Login with Facebook', IDXBOOST_DOMAIN_THEME_LANG); ?>
                      </a>
                      <button type="submit" aria-label="Login with Facebook" class="social_login_btn_temporal"></button>
                    </li>
                  <?php endif; ?>
                  <?php if (isset($flex_idx_info["agent"]["google_login_enabled"]) && "1" == $flex_idx_info["agent"]["google_login_enabled"]): ?>
                  <li class="ms-wrapper-login-google">
                      <div id="g_id_onload"
                              data-client_id="<?php echo $flex_idx_info["agent"]["google_client_id"]; ?>"
                              data-context="signin"
                              data-ux_mode="popup"
                              data-callback="handleCredentialResponse"
                              data-auto_prompt="false">
                      </div>
                      <div class="g_id_signin"
                            data-type="standard"
                            data-shape="rectangular"
                            data-theme="outline"
                            data-text="signin_with"
                            data-size="large"
                            data-logo_alignment="left"
                            data-width="360"
                      ></div>
                    <div class="ms-google-login-btn">
                      <div class="ms-svg">
                        <svg version="1.1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 48 48" class="LgbsSe-Bz112c"><g><path fill="#EA4335" d="M24 9.5c3.54 0 6.71 1.22 9.21 3.6l6.85-6.85C35.9 2.38 30.47 0 24 0 14.62 0 6.51 5.38 2.56 13.22l7.98 6.19C12.43 13.72 17.74 9.5 24 9.5z"></path><path fill="#4285F4" d="M46.98 24.55c0-1.57-.15-3.09-.38-4.55H24v9.02h12.94c-.58 2.96-2.26 5.48-4.78 7.18l7.73 6c4.51-4.18 7.09-10.36 7.09-17.65z"></path><path fill="#FBBC05" d="M10.53 28.59c-.48-1.45-.76-2.99-.76-4.59s.27-3.14.76-4.59l-7.98-6.19C.92 16.46 0 20.12 0 24c0 3.88.92 7.54 2.56 10.78l7.97-6.19z"></path><path fill="#34A853" d="M24 48c6.48 0 11.93-2.13 15.89-5.81l-7.73-6c-2.15 1.45-4.92 2.3-8.16 2.3-6.26 0-11.57-4.22-13.47-9.91l-7.98 6.19C6.51 42.62 14.62 48 24 48z"></path><path fill="none" d="M0 0h48v48H0z"></path></g></svg>
                      </div>
                      <div class="ms-gl-text">
                        <?php echo __('Login with Google', IDXBOOST_DOMAIN_THEME_LANG); ?>
                      </div>
                    </div>
                    <button type="submit" aria-label="Login with Google" class="social_login_btn_temporal"></button>
                  </li>
                  <?php endif; ?>
                  <li>
                    <span class="ms-label" id="msRst">
                      <span id="ms-text"><?php echo __('Forgot your password?', IDXBOOST_DOMAIN_THEME_LANG); ?></span>
                      <a role="button" id="ms-link" class="ms-tab" data-tab="tabReset" data-text="<?php echo __('Reset Password', IDXBOOST_DOMAIN_THEME_LANG); ?>"><?php echo __('Reset now', IDXBOOST_DOMAIN_THEME_LANG); ?></a>
                    </span>
                    <!--
                    <div class="ms-wrapper-btn -wr">
                      <button class="ms-btn js-active-why-register">Why Register?</button>
                    </div>-->
                  </li>
                </ul>
              </div>

              <?php else: ?>

              <div class="line_or"><span><?php echo __('or', IDXBOOST_DOMAIN_THEME_LANG); ?></span></div>
              <ul class="social_login">
                <li>
                    <span class="ms-label" id="msRst">
                      <span id="ms-text"><?php echo __('Forgot your password?', IDXBOOST_DOMAIN_THEME_LANG); ?></span>
                      <a role="button" id="ms-link" class="ms-tab" data-tab="tabReset" data-text="<?php echo __('Reset Password', IDXBOOST_DOMAIN_THEME_LANG); ?>"><?php echo __('Reset now', IDXBOOST_DOMAIN_THEME_LANG); ?></a>
                    </span>
                </li>
              </ul>
            <?php endif; ?>
          </div>

          <div class="footer_md terms-md" style="position: relative !important;text-align: left;font-size: 11px !important;">
            <?php 
              if (($idxboost_agent_info["show_opt_in_message"])){
                $class_ft = "ms-footer-sm";
            ?>
              <div class="ms-fub-register">
                <div class="ms-flex-chk-ub">
                  <div class="ms-item-chk">
                    <input type="checkbox" id="follow_up_boss_valid_register" class="follow_up_boss_valid_register" required <?php echo $checked; ?>>
                    <label for="follow_up_boss_valid_register" aria-label="Follow Up Boss"></label>
                  </div>
                  <div class="ms-fub-disclaimer">
                    <p><?php echo $flex_idx_info['agent']['disclaimer_fub']; ?></p>
                  </div>
                </div>
              </div>
            <?php }else{
              $class_ft = "ms-footer-sn";
            } ?>

            <div class="<?php echo $class_ft; ?>">
              <p><?php echo __("In agreement with our", IDXBOOST_DOMAIN_THEME_LANG); ?> 
              <a rel="nofollow" target="_blank" href="/terms-and-conditions/" title="<?php echo __("Terms of Use", IDXBOOST_DOMAIN_THEME_LANG); ?> (Opens a new window)">
                <?php echo __("Terms of Use", IDXBOOST_DOMAIN_THEME_LANG); ?>
              </a> 
              <span><?php echo __("and", IDXBOOST_DOMAIN_THEME_LANG); ?> <a href="/terms-and-conditions/#atospp-privacy" rel="nofollow" target="_blank"><?php echo __("Privacy Policy", IDXBOOST_DOMAIN_THEME_LANG); ?></a></span></p>
            </div>
          </div>
        </div>

        <button data-id="modal_login" class="close close-modal" data-frame="modal_mobile">
          <?php echo __('Close', IDXBOOST_DOMAIN_THEME_LANG); ?><span></span>
        </button>
      </div>

    </div>

    <div class="overlay_modal_closer" data-frame="modal_mobile" data-id="modal_login"></div>

    <div class="ms-hidden-text">
      <span id="mstextRst">
        <span><?php echo __('Already registered?', IDXBOOST_DOMAIN_THEME_LANG); ?></span>
        <a role="button" class="ms-tab" data-tab="tabLogin" data-text="<?php echo __('Welcome Back', IDXBOOST_DOMAIN_THEME_LANG); ?>"><?php echo __('Log in ', IDXBOOST_DOMAIN_THEME_LANG); ?></a>
      </span>

      <span id="mstextFst">
        <span><?php echo __('Forgot your password?', IDXBOOST_DOMAIN_THEME_LANG); ?></span>
        <a role="button" class="ms-tab" data-tab="tabReset" data-text="<?php echo __('Reset Password', IDXBOOST_DOMAIN_THEME_LANG); ?>"><?php echo __('Reset now', IDXBOOST_DOMAIN_THEME_LANG); ?></a>
      </span>
    </div>
  </div>


  <!-- ADD SEARCH MODAL -->
  <div class="overlay_modal" id="modal_save_search">
    <div class="modal_cm">
      <button data-id="modal_save_search" class="close close-modal" data-frame="modal_mobile"><?php echo __("Close", IDXBOOST_DOMAIN_THEME_LANG); ?><span> </span></button>
      <div class="content_md">
        <div class="heder_md">
          <span class="ms-modal-title"><?php echo __('Save search', IDXBOOST_DOMAIN_THEME_LANG); ?></span>
          <p id="msSmartAlertText" 
          data-text-alert="<?php echo __('Save your preferred areas for future reference', IDXBOOST_DOMAIN_THEME_LANG); ?>" 
          data-text-default="<?php echo __('You will receive automatic updates every time there are new listings and price reductions', IDXBOOST_DOMAIN_THEME_LANG); ?>">
          </p>
        </div>
        <div class="body_md">
          <div class="form_content">
            <form id="form-save" method="POST">
		          <fieldset>
                <legend><?php echo __('Save This Search', IDXBOOST_DOMAIN_THEME_LANG); ?></legend>
              <div class="gform_body">
                <ul class="gform_fields">
                  <!--<li class="gfield field_sublabel_below">
                    Search Name(*)
                  </li>-->
                  <li class="gfield">
                    <label class="gfield_label" for="input_sname_search">
                    <?php echo __("Search Name(*)", IDXBOOST_DOMAIN_THEME_LANG); ?>
                    </label>
                    <div class="ginput_container">
                      <input class="medium" id="input_sname_search" name="input_sname" placeholder="<?php echo __("Search Name", IDXBOOST_DOMAIN_THEME_LANG); ?>*" required type="text" value="">
                    </div>
                  </li>
                  <!--<li class="gfield field_sublabel_below">
                    Email Updates
                  </li>-->
                  <li class="gfield">
                    <label class="gfield_label" for="iboost-alert-change-interval">
                    <?php echo __("Email Updates", IDXBOOST_DOMAIN_THEME_LANG); ?>
                    </label>
                    <div class="ginput_container">
                      <select class="iboost-alert-change-interval notification_day_class medium" id="iboost-alert-change-interval">
                        <option value="--">
                          <?php echo __("No Alert", IDXBOOST_DOMAIN_THEME_LANG); ?>
                        </option>
                        <option value="1" selected>
                          <?php echo __("Daily", IDXBOOST_DOMAIN_THEME_LANG); ?>
                        </option>
                        <option value="7">
                          <?php echo __("Weekly", IDXBOOST_DOMAIN_THEME_LANG); ?>
                        </option>
                        <option value="30">
                          <?php echo __("Monthly", IDXBOOST_DOMAIN_THEME_LANG); ?>
                        </option>
                      </select>
                    </div>
                  </li>
                  <!--<li class="gfield field_sublabel_below">
                    Only Update Me On
                  </li>-->
                  <li class="gfield">
                    <span class="gfield_label">
                    <?php echo __("Only Update Me On", IDXBOOST_DOMAIN_THEME_LANG); ?>
                    </span>
                    <div class="ginput_container">
                      <ul class="list-check">
                        <li>
                          <input  class="flex-save-type-options" id="new-listing" name="notification_type[]" type="checkbox" value="new_listing" checked>
                          <label for="new-listing">
                          <?php echo __("New Listing (Always)", IDXBOOST_DOMAIN_THEME_LANG); ?>
                          </label>
                        </li>
                        <li>
                          <input  class="flex-save-type-options" id="price-change" name="notification_type[]" type="checkbox" value="price_change" checked>
                          <label for="price-change">
                          <?php echo __("Price Change", IDXBOOST_DOMAIN_THEME_LANG); ?>
                          </label>
                        </li>
                        <li>
                          <input  class="flex-save-type-options" id="status-change" name="notification_type[]" type="checkbox" value="status_change" checked>
                          <label for="status-change">
                          <?php echo __("Status Change", IDXBOOST_DOMAIN_THEME_LANG); ?>
                          </label>
                        </li>
                      </ul>
                    </div>
                  </li>
                </ul>
                <div class="gform_footer">
                  <input class="form_submit_button_search gform_button button gform_submit_button_5" type="submit" value="<?php echo __('Save Search', IDXBOOST_DOMAIN_THEME_LANG); ?>">
                </div>
              </div>
		          </fieldset>
            </form>
          </div>
        </div>
      </div>
    </div>
    <div class="overlay_modal_closer" data-frame="modal_mobile" data-id="modal_save_search"></div>
  </div>

  <!-- UPDATE SEARCH MODAL -->
  <div class="overlay_modal" id="modal_update_search">
    <div class="modal_cm">
      <button data-id="modal_update_search" class="close close-modal" data-frame="modal_mobile"><?php echo __("Close", IDXBOOST_DOMAIN_THEME_LANG); ?><span> </span></button>
      <div class="content_md">
        <div class="heder_md">
          <span class="ms-modal-title"><?php echo __("Saved Search", IDXBOOST_DOMAIN_THEME_LANG); ?></span>
        </div>
        <div class="body_md">
          <div class="form_content">
            <form id="form-update-alert" method="POST">
		          <fieldset>
                <legend><?php echo __('Save Search', IDXBOOST_DOMAIN_THEME_LANG); ?></legend>
              <div class="gform_body">
                <ul class="gform_fields">
                  <!--<li class="gfield field_sublabel_below">Saved Search Name(*)</li>-->
                  <li class="gfield">
                    <label class="gfield_label" for="input_update_name_search"><?php echo __("Search Name(*)", IDXBOOST_DOMAIN_THEME_LANG); ?></label>
                    <div class="ginput_container">
                      <input class="medium" id="input_update_name_search" name="input_sname" placeholder="<?php echo __("Search Name", IDXBOOST_DOMAIN_THEME_LANG); ?>*" required type="text" value=""></input>
                    </div>
                  </li>
                  <!--<li class="gfield field_sublabel_below">Email Updates</li>-->
                  <li class="gfield">
                    <label class="gfield_label" for="iboost-alert-change-interval-2"><?php echo __("Email Updates", IDXBOOST_DOMAIN_THEME_LANG); ?></label>
                    <div class="ginput_container">
                      <select class="iboost-alert-change-interval notification_day_class_update medium" id="iboost-alert-change-interval-2">
                        <option value="0"><?php echo __("No Alert", IDXBOOST_DOMAIN_THEME_LANG); ?></option>
                        <option value="1"><?php echo __("Daily", IDXBOOST_DOMAIN_THEME_LANG); ?></option>
                        <option value="7"><?php echo __("Weekly", IDXBOOST_DOMAIN_THEME_LANG); ?></option>
                        <option value="30"><?php echo __("Monthly", IDXBOOST_DOMAIN_THEME_LANG); ?></option>
                      </select>
                    </div>
                  </li>
                  <!--<li class="gfield field_sublabel_below">Only Update Me On</li>-->
                  <li class="gfield">
                    <span class="gfield_label"><?php echo __("Only Update Me On", IDXBOOST_DOMAIN_THEME_LANG); ?></span>
                    <div class="ginput_container">
                      <ul class="list-check">
                        <li>
                          <input  class="flex-save-type-options" id="update-listing-alert" name="notification_type_update[]" type="checkbox" value="new_listing">
                          <label for="update-listing-alert">
                          <?php echo __("New Listing (Always)", IDXBOOST_DOMAIN_THEME_LANG); ?>
                          </label>
                        </li>
                        <li>
                          <input  class="flex-save-type-options" id="update-price-change-alert" name="notification_type_update[]" type="checkbox" value="price_change">
                          <label for="update-price-change-alert">
                          <?php echo __("Price Change", IDXBOOST_DOMAIN_THEME_LANG); ?>
                          </label>
                        </li>
                        <li>
                          <input  class="flex-save-type-options" id="update-status-change-alert" name="notification_type_update[]" type="checkbox" value="status_change">
                          <label for="update-status-change-alert">
                          <?php echo __("Status Change", IDXBOOST_DOMAIN_THEME_LANG); ?>
                          </label>
                        </li>
                      </ul>
                    </div>
                  </li>
                </ul>
                <div class="gform_footer">
                  <input class="form_submit_button_search gform_button button gform_submit_button_5" type="submit" value="<?php echo __("Update Saved Search", IDXBOOST_DOMAIN_THEME_LANG); ?>"></input>
                </div>
              </div>
              <input type="hidden" name="token_alert" class="token_alert">
		        </fieldset>
            </form>
          </div>
        </div>
      </div>
    </div>
    <div class="overlay_modal_closer" data-frame="modal_mobile" data-id="modal_update_search"></div>
  </div>

  <!-- ADD FAVORITES -->
  <div class="overlay_modal" id="modal_add_favorities">
    <div class="modal_cm">
      <button data-id="modal_add_favorities" class="close close-modal" data-frame="modal_mobile"><?php echo __('Close', IDXBOOST_DOMAIN_THEME_LANG); ?> <span></span></button>
      <div class="content_md">
        <div class="body_md">
          <div class="confirm-message">
            <span class="confirmation-icon"></span>
            <span class="ms-modal-title"><?php echo __("Property added to favorites", IDXBOOST_DOMAIN_THEME_LANG); ?></span>
            <p><?php echo __("You can see your saved properties", IDXBOOST_DOMAIN_THEME_LANG); ?> <br><?php echo __("under your account", IDXBOOST_DOMAIN_THEME_LANG); ?></p>
          </div>
        </div>
      </div>
    </div>
    <div class="overlay_modal_closer" data-id="modal_add_favorities" data-frame="modal_mobile"></div>
  </div>

  <!-- ADD FAVORITES -->
  <div class="overlay_modal" id="modal_update_favorities">
    <div class="modal_cm">
      <button data-id="modal_update_favorities" class="close close-modal" data-frame="modal_mobile"><?php echo __("Close", IDXBOOST_DOMAIN_THEME_LANG); ?> <span></span></button>
      <div class="content_md">
        <div class="body_md">
          <div class="confirm-message">
            <span class="confirmation-icon"></span>
            <p><?php echo __("Your changes have been saved successfully", IDXBOOST_DOMAIN_THEME_LANG); ?></p>
          </div>
        </div>
      </div>
    </div>
    <div class="overlay_modal_closer" data-id="modal_update_favorities" data-frame="modal_mobile"></div>
  </div>

  <!-- REQUEST A SHOWING -->
  <div class="overlay_modal" id="modal_schedule">
    <div class="modal_cm">
      <button data-id="modal_schedule" class="close close-modal" data-frame="modal_mobile">
        <?php echo __("Close", IDXBOOST_DOMAIN_THEME_LANG); ?><span></span>
      </button>
      <div class="content_md">
        <div class="heder_md">
          <span class="ms-modal-title"><?php echo __("Schedule a Consultation", IDXBOOST_DOMAIN_THEME_LANG); ?></span>
        </div>
        <div class="body_md">
          <p>
            <?php echo __("Please provide your contact information and one of our real estate professionals will be in touch.", IDXBOOST_DOMAIN_THEME_LANG); ?>
            <br>
            <?php if (isset($flex_idx_info['agent']['agent_contact_phone_number'])): ?>
            <?php echo __('CALL US', IDXBOOST_DOMAIN_THEME_LANG); ?> 
            <a href="tel:<?php echo preg_replace('/[^\d]/', '', $flex_idx_info['agent']['agent_contact_phone_number']); ?>"><?php echo flex_phone_number_filter($flex_idx_info['agent']['agent_contact_phone_number']); ?></a>
            <?php endif ?>
          </p>
          <div class="form_content">
            <form id="form-scheduled" method="post" class="gtm_schedule_a_consultation iboost-form-validation">
		          <fieldset>
                <legend><?php echo __('Schedule a Consultation', IDXBOOST_DOMAIN_THEME_LANG); ?></legend>
              <input type="hidden" name="action" value="lead_submission_showing">

              <?php if (array_key_exists('google_gtm', $flex_idx_info['agent']) && !empty($flex_idx_info['agent']['google_gtm'])) : ?>
                <input type="hidden" name="gclid_field" id="gclid_field_form_scheduled">
              <?php endif; ?>

              <div class="gform_body">
                <ul class="gform_fields">
                  <li class="gfield">
                    <div class="ginput_container ginput_container_email">
                      <label for="ms-autocomplete-name" class="ms-hidden"><?php echo __("First Name", IDXBOOST_DOMAIN_THEME_LANG); ?></label>
                        <input id="ms-autocomplete-name" autocapitalize="off" spellcheck="false" class="medium" name="first_name" placeholder='<?php echo __("First Name", IDXBOOST_DOMAIN_THEME_LANG); ?>' type="text" value="<?php if (isset($flex_idx_lead['lead_info']['first_name'])): ?><?php echo $flex_idx_lead['lead_info']['first_name']; ?><?php endif;?>" required />
                    </div>
                  </li>
                  <li class="gfield">
                    <div class="ginput_container ginput_container_email">
                      <label for="ms-autocomplete-lastname" class="ms-hidden"><?php echo __("Last Name", IDXBOOST_DOMAIN_THEME_LANG); ?></label>
                        <input id="ms-autocomplete-lastname" autocapitalize="off" spellcheck="false" class="medium" name="last_name" placeholder='<?php echo __("Last Name", IDXBOOST_DOMAIN_THEME_LANG); ?>' type="text" value="<?php if (isset($flex_idx_lead['lead_info']['last_name'])): ?><?php echo $flex_idx_lead['lead_info']['last_name']; ?><?php endif;?>" required />
                    </div>
                  </li>
                  <li class="gfield">
                    <div class="ginput_container ginput_container_email">
                      <label for="ms-autocomplete-email" class="ms-hidden"><?php echo __("Email Address", IDXBOOST_DOMAIN_THEME_LANG); ?></label>                      
                      <input id="ms-autocomplete-email" autocorrect="off" autocapitalize="off" spellcheck="false" autocomplete="disabled" class="medium" name="email_address" placeholder='<?php echo __("Email Address", IDXBOOST_DOMAIN_THEME_LANG); ?>' type="email" value="<?php if (isset($flex_idx_lead['lead_info']['email_address'])): ?><?php echo $flex_idx_lead['lead_info']['email_address']; ?><?php endif;?>" required />
                    </div>
                  </li>
                  <li class="gfield">
                    <div class="ginput_container ginput_container_email">
                      <label for="ms-autocomplete-phone" class="ms-hidden"><?php echo __("Phone Number", IDXBOOST_DOMAIN_THEME_LANG); ?></label>
                        <input id="ms-autocomplete-phone" autocapitalize="off" spellcheck="false" class="medium" name="phone_number" placeholder='<?php echo __("Phone Number", IDXBOOST_DOMAIN_THEME_LANG); ?>' type="tel" value="<?php if (isset($flex_idx_lead['lead_info']['phone_number'])): ?><?php echo $flex_idx_lead['lead_info']['phone_number']; ?><?php endif;?>" required />
                    </div>
                  </li>
                  <li class="gfield comments">
                    <div class="ginput_container">
                      <label for="ms-autocomplete-comments" class="ms-hidden"><?php echo __("Comments", IDXBOOST_DOMAIN_THEME_LANG); ?></label>
                        <textarea id="ms-autocomplete-comments" autocapitalize="off" spellcheck="false" class="medium textarea" cols="50" name="comments" placeholder='<?php echo __("Comments", IDXBOOST_DOMAIN_THEME_LANG); ?>' rows="10"></textarea>
                    </div>
                  </li>
                  <li class="gfield field_sublabel_below"><?php echo __("Prefered Time and Date", IDXBOOST_DOMAIN_THEME_LANG); ?></li>
                  <li class="gfield time">
                    <div class="ginput_container ginput_container_time">
			                  <label for="ss_preferred_time" class="ms-hidden"><?php echo __("Morning", IDXBOOST_DOMAIN_THEME_LANG); ?></label>
                        <select name="preferred_time" class="medium" id="ss_preferred_time">
                          <option value="Morning" selected><?php echo __("Morning", IDXBOOST_DOMAIN_THEME_LANG); ?></option>
                          <option value="Afternoon"><?php echo __("Afternoon", IDXBOOST_DOMAIN_THEME_LANG); ?></option>
                          <option value="Evening"><?php echo __("Evening", IDXBOOST_DOMAIN_THEME_LANG); ?></option>
                        </select>
                    </div>
                  </li>
                  <li class="gfield date">
                    <div class="ginput_container ginput_container_date">
			                <label for="ss_preferred_date" class="ms-hidden"><?php echo __("Choose Date", IDXBOOST_DOMAIN_THEME_LANG); ?></label>
                      <input type="text" name="preferred_date" id="ss_preferred_date" value="" placeholder='<?php echo __("Choose Date", IDXBOOST_DOMAIN_THEME_LANG); ?>' class="medium">
                    </div>
                  </li>
                  <?php if (($idxboost_agent_info["show_opt_in_message"])){  ?>
                  <li class="gfield fub">
                    <div class="ms-flex-chk-ub">
                      <div class="ms-item-chk">
                        <input type="checkbox" id="follow_up_boss_valid" required <?php echo $checked; ?>>
                        <label for="follow_up_boss_valid" aria-label="Follow Up Boss"></label>
                      </div>
                      <div class="ms-fub-disclaimer">
                        <p><?php echo $flex_idx_info['agent']['disclaimer_fub']; ?></p>
                      </div>
                    </div>
                  </li>
                  <?php } ?>
                </ul>
                <div class="gform_footer">
                  <input class="gform_button button gform_submit_button_6" type="submit" value="<?php echo __('Submit', IDXBOOST_DOMAIN_THEME_LANG); ?>"/>
                </div>
              </div>
		        </fieldset>
            </form>
          </div>
        </div>
      </div>
    </div>
    <div class="overlay_modal_closer" data-frame="modal_mobile" data-id="modal_schedule">
    </div>
  </div>

  <!-- SHARE TO FRIEND 
  <div class="overlay_modal" id="modal_email_to_friend">
    <div class="modal_cm">
      <button data-id="modal_email_to_friend" class="close close-modal" data-frame="modal_mobile"><?php echo __("Close", IDXBOOST_DOMAIN_THEME_LANG); ?> <span></span></button>
      <div class="content_md">
        <div class="heder_md">
          <span class="ms-modal-title"><?php echo __("Email to a friend", IDXBOOST_DOMAIN_THEME_LANG); ?></span>
        </div>
        <div class="body_md">
          <p>
            <?php echo __("Recomend this to a friend, just enter their email below", IDXBOOST_DOMAIN_THEME_LANG); ?>
          </p>
          <div class="form_content">
            <form id="form-email-friend" class="iboost-secured-recaptcha-form" method="post">
            <?php
                  global $agent_registration_key;

                  if (isset($agent_registration_key)): ?>
                  <input type="hidden" name="registration_key" value="<?php echo $agent_registration_key; ?>">
                  <?php endif; ?>
              <?php
                global $wp, $post;
                $wp_request = $wp->request;
                $wp_request_exp = explode('/', $wp_request);
                ?>
              <fieldset>
                    <legend><?php echo __('Email to a friend', IDXBOOST_DOMAIN_THEME_LANG); ?></legend>              


              <input type="hidden" name="share_permalink" value="<?php echo $flex_idx_info["website_url"]; ?>/<?php echo $wp_request; ?>">
              <?php if (isset($wp_request_exp[0]) && $wp_request_exp[0] === 'building'): ?>
              <input type="hidden" name="share_type" value="building">
              <input type="hidden" name="building_ID" value="<?php echo get_post_meta(get_the_ID(), '_flex_building_page_id', true); ?>">
              <?php elseif(isset($wp_request_exp[0]) && $wp_request_exp[0] === 'property'):
                list($page, $slug) = $wp_request_exp;
                
                if (strstr($slug, '-rx-')) {
                    $exp_slug = explode('-', $slug);
                    $mls_num  = 'rx-' . end($exp_slug);
                } else {
                    $exp_slug = explode('-', $slug);
                    $mls_num  = end($exp_slug);
                }
                
                $type_lookup = 'active';
              
                if (preg_match('/^[sold\-(.*)]+/', $slug)) {
                    $type_lookup = 'sold';
                } else if (preg_match('/^[rent\-(.*)]+/', $slug)) {
                    $type_lookup = 'rent';
                } else if (preg_match('/^[pending\-(.*)]+/', $slug)) {
                    $type_lookup = 'pending';
                } else {
                    $type_lookup = 'active';
                }
                ?>
              
              <fieldset>
                    <legend><?php echo __('Email to a friend', IDXBOOST_DOMAIN_THEME_LANG); ?></legend>

              <input type="hidden" name="share_type" value="property">
              <input type="hidden" name="mls_number" value="<?php echo $mls_num; ?>">
              <input type="hidden" name="status" value="">
              <input type="hidden" name="type_property" value="<?php echo $type_lookup; ?>">
              <?php endif; ?>
              <input type="hidden" name="action" value="flex_share_with_friend">
              <div class="gform_body">
                <ul class="gform_fields">
                  <li class="gfield field_sublabel_below">
                    <?php echo __("Friend&#039s Information", IDXBOOST_DOMAIN_THEME_LANG); ?>
                  </li>
                  <li class="gfield">
                    <label class="gfield_label" for="ms-friend-email"><?php echo __("Friend&#039s email", IDXBOOST_DOMAIN_THEME_LANG); ?></label>
                    <div class="ginput_container ginput_container_email">
                      <input id="ms-friend-email" autocorrect="off" autocapitalize="off" spellcheck="false" autocomplete="disabled" autocomplete="disabled" required class="medium" name="friend_email" placeholder="<?php echo __("Friend&#039s Email", IDXBOOST_DOMAIN_THEME_LANG); ?>*" type="email" value="" />
                    </div>
                  </li>
                  <li class="gfield">
                    
                    <div class="ginput_container ginput_container_email">
		                  <label class="gfield_label" for="ms-friend-name"><?php echo __("Friend name", IDXBOOST_DOMAIN_THEME_LANG); ?></label>
                      <input id="ms-friend-name" autocorrect="off" autocapitalize="off" spellcheck="false" autocomplete="disabled" autocomplete="disabled" required class="medium" name="friend_name" placeholder="<?php echo __("Friend&#039s Name", IDXBOOST_DOMAIN_THEME_LANG); ?>*" type="text" value="">
                    </div>
                  </li>
                  <li class="gfield field_sublabel_below"><?php echo __("Your Information", IDXBOOST_DOMAIN_THEME_LANG); ?></li>
                  <li class="gfield">
                    
                    <div class="ginput_container ginput_container_email">		
		                  <label for="ms-your-name" class="gfield_label"><?php echo __("Your Name", IDXBOOST_DOMAIN_THEME_LANG); ?></label>
                      <input id="ms-your-name" autocorrect="off" autocapitalize="off" spellcheck="false" autocomplete="disabled" autocomplete="disabled" required class="medium" name="your_name" placeholder="<?php echo __("Your Name", IDXBOOST_DOMAIN_THEME_LANG); ?>*" type="text" value="">
                    </div>
                  </li>
                  <li class="gfield">
                    
                    <div class="ginput_container ginput_container_email">
			                <label for="ms-your-email" class="gfield_label"><?php echo __("Your Email", IDXBOOST_DOMAIN_THEME_LANG); ?></label>
                      <input id="ms-your-email" autocorrect="off" autocapitalize="off" spellcheck="false" autocomplete="disabled" autocomplete="disabled" required class="medium" name="your_email" placeholder="<?php echo __("Your Email", IDXBOOST_DOMAIN_THEME_LANG); ?>*" type="email" value="">
                    </div>
                  </li>
                  <li class="gfield comments">
                    
                    <div class="ginput_container">
			                <label class="gfield_label" for="ms-friend-comments"><?php echo __("Comments", IDXBOOST_DOMAIN_THEME_LANG); ?></label>
                      <textarea id="ms-friend-comments" autocorrect="off" autocapitalize="off" spellcheck="false" autocomplete="disabled" autocomplete="disabled" class="medium textarea" cols="50" name="comments" placeholder="<?php echo __("Comments", IDXBOOST_DOMAIN_THEME_LANG); ?>" rows="10" type="text"></textarea>
                    </div>
                  </li>
                  <li class="gfield requiredFields">* <?php echo __("Required Fields", IDXBOOST_DOMAIN_THEME_LANG); ?></li>
                </ul>
                <div class="gform_footer">
                  <input class="gform_button button gform_submit_button_6" type="submit" value="<?php echo __("Submit", IDXBOOST_DOMAIN_THEME_LANG); ?>">
                </div>
              </div>
		          </fieldset>
            </form>
          </div>
        </div>
      </div>
    </div>
    <div class="overlay_modal_closer" data-frame="modal_mobile" data-id="modal_email_to_friend">
    </div>
  </div>-->

  <div class="ib-modal-master" data-id="email-to-friend" id="ib-email-to-friend"
    data-text-beds="<?php echo __("Bed", IDXBOOST_DOMAIN_THEME_LANG); ?>"
    data-text-bath="<?php echo __("Bath", IDXBOOST_DOMAIN_THEME_LANG); ?>"
    data-text-beds-full="<?php echo __("Bedrooms", IDXBOOST_DOMAIN_THEME_LANG); ?>"
    data-text-year="<?php echo __("Year Built", IDXBOOST_DOMAIN_THEME_LANG); ?>"
    data-text-address="<?php echo __("Address", IDXBOOST_DOMAIN_THEME_LANG); ?>"
    data-text-city="<?php echo __("City", IDXBOOST_DOMAIN_THEME_LANG); ?>">
    <div class="ib-mmcontent modal_cm">
      <div class="ib-mwrapper ib-mgeneric ms-wrapper-modal">
        <div class="ms-modal-header">
          <span class="ms-title"><?php echo __("Share this property", IDXBOOST_DOMAIN_THEME_LANG); ?></span>
        </div>
        <div class="ms-modal-body">
          <div class="ms-paragraph">
            <p><?php echo __("Recomend this to a friend, just enter their email below", IDXBOOST_DOMAIN_THEME_LANG); ?>.</p>
          </div>

          <div class="ib-property-share-friend-f msx">
            <div class="ms-flex">
              <div class="ms-form-item">
                <div class="ms-wrapper-img" id="mediaModal"></div>
              </div>

              <div class="ms-form-item">
                <div class="ms-wrapper-details" id="msInfoPropertyModal"></div>
              </div>
            </div>
          </div>

          <div class="ms-sf-wrapper-share-options -newView">
            <div class="ms-sf-share-options">
              <ul>
                <li><button class="ms-sf-btn -xl -clipboard js-copy-link" aria-label="Copy Link"><i class="idx-icon-copy"></i><span>Copy Link <span class="-copied"><?php echo __("copied", IDXBOOST_DOMAIN_THEME_LANG); ?></span></span></button></li>
                <li><button class="ms-sf-btn -xl js-show-share-friend" aria-label="Email"><i class="idx-icon-envelope"></i><span>Email</span></button></li>
                <li><button class="ms-sf-btn -xl js-show-facebook" aria-label="Facebook"><i class="idx-icon-facebook"></i><span>Facebook</span></button></li>
                <li><button class="ms-sf-btn -xl js-show-whatsApp" aria-label="WhatsApp"><i class="idx-icon-whatsapp"></i><span>WhatsApp</span></button></li>
                <li><button class="ms-sf-btn -xl js-show-linkedin" aria-label="Linkedin"><i class="idx-icon-linkedin2"></i><span>Linkedin</span></button></li>
                <li><button class="ms-sf-btn -xl js-show-twitter" aria-label="Twitter"><i class="idx-icon-twitter"></i><span>Twitter</span></button></li>
                <li><button class="ms-sf-btn -xl js-show-telegram" aria-label="Telegram"><i class="idx-icon-telegram"></i><span>Telegram</span></button></li>
                <li><button class="ms-sf-btn -xl js-show-pinterest" aria-label="Pinterest"><i class="idx-icon-pinterest-p"></i><span>Pinterest</span></button></li>
              </ul>
            </div>
            <div class="ms-sf-form-hidden">
              <form method="post" class="ib-property-share-friend-f iboost-secured-recaptcha-form">
                <input type="hidden" name="mls_number" class="ib-property-share-mls-num" value="">
                <div class="ms-flex">
                  <div class="ms-form-item">
                    <div class="ms-group-input">
                      <span class="ms-to"><?php echo __("To", IDXBOOST_DOMAIN_THEME_LANG); ?></span>
                      <label class="ms-hidden" for="friend-email"><?php echo __("To", IDXBOOST_DOMAIN_THEME_LANG); ?>*</label>
                      <input class="ib-meinput" id="friend-email" name="friend_email" placeholder="<?php echo __("Recipient Email", IDXBOOST_DOMAIN_THEME_LANG); ?>*" type="email" value="" required>
                    </div>
                  </div>

                  <div class="ms-form-item">
                    <div class="ms-group-input">
                      <label class="ms-hidden" for="friend-name"><?php echo __("Name", IDXBOOST_DOMAIN_THEME_LANG); ?>*</label>
                      <input class="ib-meinput" id="friend-name" name="friend_name" placeholder="<?php echo __("Recipient Name", IDXBOOST_DOMAIN_THEME_LANG); ?>*" type="text" value="" required>
                    </div>
                  </div>

                  <div class="ms-form-item">
                    <div class="ms-group-input">
                      <label for="ms-your-email" class="ms-hidden"><?php echo __("From", IDXBOOST_DOMAIN_THEME_LANG); ?>*</label>
                      <input class="ib-meinput" id="your-email" name="your_email" placeholder="<?php echo __("Enter your email", IDXBOOST_DOMAIN_THEME_LANG); ?>*" type="email" value="<?php if (isset($flex_idx_lead['lead_info']['email_address'])) : ?><?php echo $flex_idx_lead['lead_info']['email_address']; ?><?php endif; ?>" required>
                    </div>
                  </div>

                  <div class="ms-form-item">
                    <div class="ms-group-input">
                      <label for="ms-your-name" class="ms-hidden"><?php echo __("Name", IDXBOOST_DOMAIN_THEME_LANG); ?>*</label>
                      <input class="ib-meinput" id="your-name" name="your_name" placeholder="<?php echo __("Enter Your Full Name*", IDXBOOST_DOMAIN_THEME_LANG); ?>*" type="text" value="<?php if (isset($flex_idx_lead['lead_info']['first_name'])) : ?><?php echo $flex_idx_lead['lead_info']['first_name']; ?><?php endif; ?>" required>
                    </div>
                  </div>

                  <div class="ms-form-item -full">
                    <div class="ms-group-input">
                      <label for="friend-comments"><?php echo __("Message", IDXBOOST_DOMAIN_THEME_LANG); ?></label>
                      <textarea class="ib-metextarea" id="friend-comments" name="comments" type="text" placeholder="<?php echo __("Comments", IDXBOOST_DOMAIN_THEME_LANG); ?>*" data-comment="<?php echo __("Hi. Check out the property I found on", IDXBOOST_DOMAIN_THEME_LANG); ?>"></textarea>
                    </div>
                  </div>

                  <div class="ms-form-item -full">
                    <span class="ms-sf-small-text">* <?php echo __("Required fields", IDXBOOST_DOMAIN_THEME_LANG); ?></span>
                  </div>

                  <div class="ms-wrapper-btn">
                    <button class="ms-sf-btn -silver -xl js-hidden-share-friend" type="button"><?php echo __("Cancel", IDXBOOST_DOMAIN_THEME_LANG); ?></button>
                    <button class="ms-btn ib-mgsubmit" aria-label="<?php echo __("Continue", IDXBOOST_DOMAIN_THEME_LANG); ?>" type="submit">
                      <span><?php echo __("Continue", IDXBOOST_DOMAIN_THEME_LANG); ?></span>
                    </button>
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
      <div class="ib-mmclose"><span class="ib-mmctxt"><?php echo __("Close", IDXBOOST_DOMAIN_THEME_LANG); ?></span></div>
    </div>
    <div class="ib-mmbg"></div>
  </div>

  <div class="ib-modal-master" data-id="submit" id="ib-email-thankyou">
    <div class="ib-mmcontent">
      <div class="ib-mgeneric ib-msubmit"><span class="ib-mssent ib-mstxt ib-icon-check"><?php echo __("Email Sent", IDXBOOST_DOMAIN_THEME_LANG); ?>! </span><span class="ib-mssucces ib-mstxt"><?php echo __("Your email was sent successfully", IDXBOOST_DOMAIN_THEME_LANG); ?></span></div>
      <div class="ib-mmclose"><span class="ib-mmctxt"><?php echo __("Close", IDXBOOST_DOMAIN_THEME_LANG); ?></span></div>
    </div>
    <div class="ib-mmbg"></div>
  </div>

  <!-- MORTGAGE CALCULATOR -->
  <div class="overlay_modal" id="modal_calculator">
    <div class="modal_cm">
      <button data-id="modal_calculator" class="close close-modal" data-frame="modal_mobile"><?php echo __("Close", IDXBOOST_DOMAIN_THEME_LANG); ?> <span></span></button>
      <div class="content_md">
        <div class="heder_md">
          <span class="ms-modal-title"><?php echo __("Estimated Monthly Payment", IDXBOOST_DOMAIN_THEME_LANG); ?></span>
        </div>
        <div class="ib-mg-detail">
          <p style="margin-top: 0;"><?php echo __('Monthly Amount', IDXBOOST_DOMAIN_THEME_LANG); ?></p>
          <span id="monthly-amount" class="text-bold mtotal js-est-payment"></span>
          <p><?php echo __('Estimate includes principal and interest. Does not include taxes and insurance.', IDXBOOST_DOMAIN_THEME_LANG); ?></p>
        </div>
        <div class="body_md">
          <div class="form_content">
            <form id="form-calculator">
		          <fieldset>
                <legend><?php echo __('Mortgage calculator', IDXBOOST_DOMAIN_THEME_LANG); ?></legend>
              <div class="gform_body">
                <ul class="gform_fields">
                  <li class="gfield">
                    <label class="gfield_label" for="ms-purchase">
                    <?php echo __("Purchase Price", IDXBOOST_DOMAIN_THEME_LANG); ?>
                    </label>
                    <div class="ginput_container ginput_container_email">
                      <input class="medium purchase_price_txt" name="input_1" readonly="" type="text" value="<?php echo isset($property['price']) ? '$' . number_format($property['price']) : ''; ?>" id="ms-purchase">
                    </div>
                  </li>
                  <li class="gfield">
                    <label class="gfield_label" for="term_txt"><?php echo __('Year Term', IDXBOOST_DOMAIN_THEME_LANG); ?> (<?php echo __('Years', IDXBOOST_DOMAIN_THEME_LANG); ?>)</label>
                    <div class="ginput_container ginput_container_years">  
                      <input class="ib-mcsyears ib-property-mc-ty" id="term_txt" value="30">
                      <div class="ms-wrapper-dropdown-menu medium">
                        <button id="calculatorYears"><?php echo __('30 Years', IDXBOOST_DOMAIN_THEME_LANG); ?></button>
                        <ul id="calculatorYearsList" class="ms-dropdown-menu" role="menu">
                          <li><a role="button" data-value="30" class="-js-item-cl"><?php echo __('30 Years', IDXBOOST_DOMAIN_THEME_LANG); ?></a></li>
                          <li><a role="button" data-value="20" class="-js-item-cl"><?php echo __('20 Years', IDXBOOST_DOMAIN_THEME_LANG); ?></a></li>
                          <li><a role="button" data-value="15" class="-js-item-cl"><?php echo __('15 Years', IDXBOOST_DOMAIN_THEME_LANG); ?></a></li>
                          <li><a role="button" data-value="10" class="-js-item-cl"><?php echo __('10 Years', IDXBOOST_DOMAIN_THEME_LANG); ?></a></li>
                        </ul>
                      </div>
                    </div>
                  </li>
                  <li class="gfield">
                    <label class="gfield_label" for="interest_rate_txt"><?php echo __("Interest Rate(%)", IDXBOOST_DOMAIN_THEME_LANG); ?></label>
                    <div class="ginput_container ginput_container_rate ms-item-input">
                      <input id="interest_rate_txt" class="ib-mcidpayment medium interest_rate_txt" data-default="3.215" value="3.215" step="any" type="text" max="100" min="0">
                      <span>%</span>
                    </div>
                  </li>
                  <li class="gfield">
                    <label class="gfield_label" for="down_payment_txt"><?php echo __("Down Payment(%)", IDXBOOST_DOMAIN_THEME_LANG); ?></label>
                    <div class="ginput_container ginput_container_payment ms-item-input">
                      <input id="down_payment_txt" class="ib-mcidpayment medium down_payment_txt" data-default="20" value="20" step="any" type="text" max="100" min="0">
                      <span>%</span>
                    </div>
                  </li>
                </ul>
                <div class="gform_footer">
                  <input class="buton_calculator gform_button button gform_submit_button_5" type="submit" value="<?php echo __("Calculate", IDXBOOST_DOMAIN_THEME_LANG); ?>">
                  </input>
                </div>
              </div>
              <input class="input_ura" type="hidden" value="<?php echo FLEX_IDX_URI . 'inc/post_response.php'; ?>">
              </input>
            </form>
          </div>
          <p class="ms-info-txt"><?php echo __("Let’s us know the best time for showing.", IDXBOOST_DOMAIN_THEME_LANG); ?> <a href="tel:<?php echo preg_replace('/[^\d]+/', '', $flex_idx_info['agent']['agent_contact_phone_number']) ?>"><?php echo $flex_idx_info['agent']['agent_contact_phone_number']; ?></a></p>
          <div class="detail-mortgage" style="display: none">
            <span class="ms-md-calc-title"><?php echo __("Mortgage Breakdown", IDXBOOST_DOMAIN_THEME_LANG); ?></span>
            <ul>
              <li><span><?php echo __("Mortgage Amount", IDXBOOST_DOMAIN_THEME_LANG); ?></span><span id="mortgage-amount" class="text-bold mortgage_mount_txt"></span></li>
              <li><span><?php echo __("Down Payment Amount", IDXBOOST_DOMAIN_THEME_LANG); ?></span><span id="down-payment" class="text-bold down_paymentamount_txt"></span></li>
              <li class="line-top"><span><?php echo __("Total Monthly Amount", IDXBOOST_DOMAIN_THEME_LANG); ?> <strong> <?php echo __("(Principal & Interest, and PMI)", IDXBOOST_DOMAIN_THEME_LANG); ?></strong></span><span id="total-monthly" class="text-bold mtotal mortgage_amount_txt"></span></li>
            </ul>
          </div>
        </div>
        <div class="ib-img-calculator"></div>
      </div>
    </div>
    <div class="overlay_modal_closer" data-frame="modal_mobile" data-id="modal_calculator"></div>
  </div>

  <!-- ADD FAVORITIES -->
  <div class="overlay_modal" id="modal_remove_favorities">
    <div class="modal_cm">
      <button data-id="modal_remove_favorities" class="close close-modal" data-frame="modal_mobile"><?php echo __("Close", IDXBOOST_DOMAIN_THEME_LANG); ?> <span></span></button>
      <div class="content_md">
        <div class="body_md">
          <div class="confirm-message">
            <span class="confirmation-icon"></span>
            <p><?php echo __("Information has been updated!", IDXBOOST_DOMAIN_THEME_LANG); ?></p>
          </div>
        </div>
      </div>
    </div>
    <div class="overlay_modal_closer" data-id="modal_remove_favorities" data-frame="modal_mobile"></div>
  </div>

  <!-- SEARCH SAVED -->
  <div class="overlay_modal" id="modal_properties_send">
    <div class="modal_cm">
      <button data-id="modal_properties_send" class="close close-modal" data-frame="modal_mobile"><?php echo __("Close", IDXBOOST_DOMAIN_THEME_LANG); ?> <span></span></button>
      <div class="content_md">
        <div class="body_md">
          <div class="confirm-message">
            <span class="confirmation-icon"></span>
            <span class="ms-confirmation-title"><?php echo __("Email Sent!", IDXBOOST_DOMAIN_THEME_LANG); ?></span>
            <p><?php echo __("Your email was sent successfully", IDXBOOST_DOMAIN_THEME_LANG); ?></p>
          </div>
        </div>
      </div>
    </div>
    <div class="overlay_modal_closer" data-id="modal_properties_send" data-frame="modal_mobile"></div>
  </div>

  <!-- SEARCH SAVED -->
  <div class="overlay_modal" id="modal_search_saved">
    <div class="modal_cm">
      <button data-id="modal_search_saved" class="close close-modal" data-frame="modal_mobile"><?php echo __("Close", IDXBOOST_DOMAIN_THEME_LANG); ?> <span></span></button>
      <div class="content_md">
        <div class="body_md">
          <div class="confirm-message">
            <span class="confirmation-icon"></span>
            <span class="ms-confirmation-title"><?php echo __("Search Saved", IDXBOOST_DOMAIN_THEME_LANG); ?></span>
            <p><?php echo __("Your search has been saved successfuly.", IDXBOOST_DOMAIN_THEME_LANG); ?></p>
          </div>
        </div>
      </div>
    </div>
    <div class="overlay_modal_closer" data-id="modal_search_saved" data-frame="modal_mobile"></div>
  </div>

  <!-- MODAL PROPERTIES -->
  <div class="overlay_modal modal_property_detail" id="modal_property_detail">
    <div id="md-body" class="modal_cm detail-modal"></div>
    <div class="overlay_modal_closer_pt" data-id="modal_property_detail"></div>
  </div>

  <!-- ALERTS -->
  <div class="overlay_modal" id="modal_subscribe">
    <div class="modal_cm">
      <button data-id="modal_subscribe" class="close close-modal" data-frame="modal_mobile"><?php echo __('Close', IDXBOOST_DOMAIN_THEME_LANG); ?> <span></span></button>
      <div class="content_md">
        <div class="body_md">
          <div class="confirm-message alt-ss">
            <span class="alt-ss-title"><?php echo __('Subscribe Alert', IDXBOOST_DOMAIN_THEME_LANG); ?></span>
            <p></p>
            <a role="button" class="btn-link"><?php echo __('Continue searching for homes', IDXBOOST_DOMAIN_THEME_LANG); ?></a>
          </div>
        </div>
      </div>
    </div>
    <div class="overlay_modal_closer" data-id="modal_subscribe" data-frame="modal_mobile"></div>
  </div>
</div>

<script>
<?php
$ib_track_signup = (isset($_GET["ibtrack_signup"]) && ("1" == $_GET["ibtrack_signup"])) ? true : false;
?>
(function($) {
  function validateEmail(email) {
      var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
      return re.test(email.toLowerCase());
  }

$(function() {
  <?php if (true === $ib_track_signup): ?>
  $(".login-modal .close").css("visibility", "hidden");
  if ("yes" === __flex_g_settings.anonymous) {
    $("#modal_login").addClass("active_modal");
  }
  <?php endif; ?>
  $(".ib-switch-login-tab").on("click", function(event) {
    event.stopPropagation();
    event.preventDefault();

    $(".ib-tabLogin:eq(0)").click();
    $("#txt_user").focus();
  });

  $("#formRegister").find('input[name="register_email"]').on("focus", function() {
    $(".dgt-email-error").hide();
  });

  $(".pr-next-step").on("click", function() {
    var _self = $(this);

    var emailField = $("#agilefield-9").val().trim();
    var fub_chk = _self.parents(".content_md").find(jQuery(".follow_up_boss_valid_register"));
    if(fub_chk.length){
      if(!fub_chk.prop('checked')){
        alert("You must accept the terms and conditions, and the privacy policy to continue");
        fub_chk.addClass("error");
        return;
      }
    }
      
    if (!validateEmail(emailField)) {
      alert("invalid email address");
      return;
    }

    // @todo check email address
    $.ajax({
        url: __flex_g_settings.checkLeadUsername,
        method: "POST",
        data: {
          access_token: __flex_g_settings.accessToken,
          email: emailField
        },
        dataType: "json",
        success: function(response) {
          if (response.is_available) {
            _self.parent().removeClass("active");
            _self.parent().next().addClass("active");
            $('#modal_login .content_md').addClass('ms-hidden-extras');
          } else {
            // alert("checking...");
            if ('USERNAME_NOT_AVAILABLE' == response.error) {
              var msg_err = response.message;

              msg_err += ' <a role="button" class="ms-tab" data-tab="tabLogin" data-text="Welcome Back">Login here</a> ';

              $(".dgt-email-error").html(msg_err);
            } else if ('INVALID_EMAIL_ADDRESS' == response.error) {
              var msg_err = response.message;
              $(".dgt-email-error").html(msg_err);
            }

            $(".dgt-email-error").show();
            $("#formRegister").find("register_email:eq(0)").blur();
            $('#modal_login .content_md').removeClass('ms-hidden-extras');
          }
        }
    });
    
    // alert("checking...");

    // return;

    // _self.parent().removeClass("active");
    // _self.parent().next().addClass("active");
    
    
    /*HIDDEN HEADERS*/
  });

  $(".pr-registering").on("click", function() {
    var _self = $(this);

    var parentId = jQuery("#"+_self.parents(".modalReferentFUB").attr("id"));
    var fub_chk = parentId.find(jQuery(".follow_up_boss_valid_register"));

    if (_self.hasClass("pr-populate-phone")) {
      if ("" === $("#__signup_fb_phone").val().trim()) {
        alert("Please provide a phone number.");
        return;
      }

      if(fub_chk.length){
        if(!fub_chk.prop('checked')){
          alert("You must accept the terms and conditions, and the privacy policy to continue");
          fub_chk.addClass("error");
          return;
        }
      }

      $("#__quizz_type_phone_ct").hide().removeClass("ib-active");
      $("#__quizz_type_phone_ct").next().addClass("ib-active");
    }

    var firstNameField = $("#agilefield-6").val().trim();
    var lastNameField = $("#agilefield-7").val().trim();
    var phoneNumberField = $("#agilefield-8").val().trim();

    //REGISTRO RG
    if(Cookies.get("social_register") !== "activo"){

      Cookies.remove("_ib_user_phone");
      Cookies.remove("_ib_user_code_phone");
      Cookies.remove("_ib_user_new_phone_number");

      var codePhone = jQuery("#formRegister").find(".country_code").val();
      var codePhoneClean = codePhone.replace(/ /g, "");
      var numberPhone = jQuery("#formRegister").find("#agilefield-8").val();
      var numberPhoneClean = numberPhone.replace(/ /g, "");
      var phoneRegisterQuizz = codePhoneClean.trim()+numberPhoneClean.trim();

      Cookies.set("_ib_user_phone", numberPhoneClean.trim());
      Cookies.set("_ib_user_code_phone", codePhoneClean.trim());
      Cookies.set("_ib_user_new_phone_number", phoneRegisterQuizz);

      var loadForm = jQuery(".iboost-form-validation-loaded");
      if(loadForm.length){
        jQuery(".iboost-form-validation-loaded").each(function () {
          var id = jQuery(this).attr("data-id");
          if(typeof id === "undefined" || id === "null" || id === ""){
            //console.log("No tiene valor");
          }else{
            //console.log("id="+id);
            iti[id].setNumber(Cookies.get("_ib_user_new_phone_number"));
          }
        });
      }
    }

    if ("regular" === $("#__quizz_type").val()) {
      if (("" === firstNameField) || ("" === phoneNumberField) || ("" === lastNameField)) {
        alert("Please fill the fields");
        return;
      }

      if(fub_chk.length){
        if(!fub_chk.prop('checked')){
          alert("You must accept the terms and conditions, and the privacy policy to continue");
          fub_chk.addClass("error");
          return;
        }
      }
    }

    if ( (typeof SIGNUP_EXTENDS_QUIZZ !== "undefined") && ("1" == SIGNUP_EXTENDS_QUIZZ) ) {
      console.log("show the quizz before submit the form");

      _self.parent().removeClass("active");
      _self.parent().next().addClass("active");

      if (!_self.hasClass("pr-populate-phone")) {
        $("#modal_login button.close-modal").addClass("signup-regular-submit-close");
        $(".signup-regular-submit-close").one("click", function() {
          //$("button.close").click();
          $("#formRegister").submit();
          $(this).removeClass("signup-regular-submit-close");
        });
      }
    } else {
      if (true === IS_CUSTOM_SIGNUP) {
          $("#ib-register-form-quizz").submit();
          $("#ib-push-registration-quizz-ct").removeClass('ib-md-active');
          swal(word_translate.thank_you, word_translate.your_info_has_been_saved, "success");
      } else {
        $("#formRegister").submit();
      }
      // swal(word_translate.thank_you, word_translate.your_info_has_been_saved, "success");
      //return;
      // console.log('submit only pho form');
      // console.log("submit the form");
      // ib_register_form_quizz.submit();
      //$("#formRegister").submit();
    }

    // if (typeof SIGNUP_EXTENDS_QUIZZ === "undefined" || ((typeof SIGNUP_EXTENDS_QUIZZ !== "undefined") && ("0" === SIGNUP_EXTENDS_QUIZZ))) {
    //   $("#modal_login .close").click();
    //   $("#formRegister").submit();
    //   alert("dont do this!");
    // }
  });

  $(".i-checks").on("click", function() {
    var _self = $(this);
    _self.parent().parent().parent().removeClass('active');
    _self.parent().parent().parent().next().addClass('active');
  });

  $(".ibregister-tg-submit").on("click", function() {
    var _self = $(this);

    _self.prev().prop("checked", true);

    $("#formRegister").submit();
  });

  $("#agilefield-8").on("change", function () {
    var _value = $(this).val().trim();
    $("#formRegister_password").val(_value);
  });

  /*
  $("#form-email-friend").on("submit", function(event) {
      event.preventDefault();

      var _self = $(this);

      if (__flex_g_settings.hasOwnProperty("has_enterprise_recaptcha")) { // enterprise recaptcha
        if ("1" == __flex_g_settings.has_enterprise_recaptcha) {
            // pending...
        } else { // regular recaptcha
          grecaptcha.ready(function() {
              grecaptcha
              .execute(__flex_g_settings.google_recaptcha_public_key, { action: 'share_property_with_friend' })
              .then(function(token) {
                  _self.prepend('<input type="hidden" name="recaptcha_response" value="'+token+'">');

                  var formData = _self.serialize();
                  var mlsNumber = _self.find("input[name='mls_number']:eq(0)").val();

                  if (mlsNumber!=undefined && mlsNumber !='' && mlsNumber!="undefined") {
                    var shareWithFriendEndpoint = __flex_g_settings.shareWithFriendEndpoint.replace(/{{mlsNumber}}/g, mlsNumber);
                    var dataSubmit={
                            access_token: __flex_g_settings.accessToken,
                            flex_credentials: Cookies.get("ib_lead_token"),
                            form_data: formData
                        };
                  }else{
                    var shareWithFriendEndpoint = __flex_g_settings.ajaxUrl;
                    var dataSubmit=formData;
                  }
          
                    $.ajax({
                        type: "POST",
                        url: shareWithFriendEndpoint,
                        data: dataSubmit,
                        success: function(response) {
                            // ...
                            _self.trigger('reset');
                            $('#form-email-friend').find('input[name="recaptcha_response"]').remove();
                        },
                        error: function() {
                        _self.trigger('reset');
                        $('#form-email-friend').find('input[name="recaptcha_response"]').remove();
                      }
                    });

                  // $(this).trigger("reset");
                  // $('.close').click();
                  $("#modal_email_to_friend").removeClass("active_modal");
                  $("html").removeClass("modal_mobile");
                  
                  swal(word_translate.good_job, word_translate.your_message_has_been_sent, "success");
              });
          });
      }
    } else { // regular recaptcha
        grecaptcha.ready(function() {
            grecaptcha
            .execute(__flex_g_settings.google_recaptcha_public_key, { action: 'share_property_with_friend' })
            .then(function(token) {
                _self.prepend('<input type="hidden" name="recaptcha_response" value="'+token+'">');

                var formData = _self.serialize();
                var mlsNumber = _self.find("input[name='mls_number']:eq(0)").val();

                if (mlsNumber!=undefined && mlsNumber !='' && mlsNumber!="undefined") {
                  var shareWithFriendEndpoint = __flex_g_settings.shareWithFriendEndpoint.replace(/{{mlsNumber}}/g, mlsNumber);
                  var dataSubmit={
                          access_token: __flex_g_settings.accessToken,
                          flex_credentials: Cookies.get("ib_lead_token"),
                          form_data: formData
                      };
                }else{
                  var shareWithFriendEndpoint = __flex_g_settings.ajaxUrl;
                  var dataSubmit=formData;
                }
        
                  $.ajax({
                      type: "POST",
                      url: shareWithFriendEndpoint,
                      data: dataSubmit,
                      success: function(response) {
                          // ...
                          _self.trigger('reset');
                          $('#form-email-friend').find('input[name="recaptcha_response"]').remove();
                      },
                      error: function() {
                        _self.trigger('reset');
                        $('#form-email-friend').find('input[name="recaptcha_response"]').remove();
                      }
                  });

                // $(this).trigger("reset");
                // $('.close').click();
                $("#modal_email_to_friend").removeClass("active_modal");
                $("html").removeClass("modal_mobile");
                
                swal(word_translate.good_job, word_translate.your_message_has_been_sent, "success");
            });
        });
    }

      // var formData = $(this).serialize();
      // var mlsNumber = $(this).find("input[name='mls_number']:eq(0)").val();

      // if (mlsNumber!=undefined && mlsNumber !='' && mlsNumber!="undefined") {
      //   var shareWithFriendEndpoint = __flex_g_settings.shareWithFriendEndpoint.replace(/{{mlsNumber}}/g, mlsNumber);
      //   var dataSubmit={
      //           access_token: __flex_g_settings.accessToken,
      //           flex_credentials: Cookies.get("ib_lead_token"),
      //           form_data: formData
      //       };
      // }else{
      //   var shareWithFriendEndpoint = __flex_g_settings.ajaxUrl;
      //   var dataSubmit=formData;
      // }

      //   $.ajax({
      //       type: "POST",
      //       url: shareWithFriendEndpoint,
      //       data: dataSubmit,
      //       success: function(response) {
      //           // ...
      //       }
      //   });

      // $(this).trigger("reset");
      // // $('.close').click();
      // $("#modal_email_to_friend").removeClass("active_modal");
      // $("html").removeClass("modal_mobile");
      
      // swal(word_translate.good_job, word_translate.your_message_has_been_sent, "success");
  });
  */

  $(".property-detail-share-fb").on("click", function(event) {
      event.preventDefault();

      console.log('sharing fb url');

      var og_url = $(this).data('share-url');
      var og_title = $(this).data('share-title');
      var og_description = $(this).data('share-description');
      var og_image = $(this).data('share-image');

      FB.ui({
          method: 'share_open_graph',
          action_type: 'og.shares',
          action_properties: JSON.stringify({
              object : {
                  'og:url': og_url, // your url to share
                  'og:title': og_title,
                  'og:description': og_description,
                  'og:image': og_image
              }
          })
      });
  });


  $(".ms-skip").on("click", function() {
    if ("yes" === __flex_g_settings.has_facebook_login_enabled) {
      if ($("#__signup_fb_phone").is(":visible")) {
        alert("Please provide a phone number.");
        return;
      }
    }

    if ($(this).hasClass('ms-close-step')) {
      $("#ib-push-registration-quizz-ct").removeClass('ib-md-active');
    } else {
      $("#ib-push-registration-quizz-ct .facebook-registration").removeClass('ib-active').css({'display':'none'});
      $("#ib-push-registration-quizz-ct .ib-pr-step").eq(0).addClass('ib-active active');
    }
  });
  
});

})(jQuery);
</script>

<?php if (isset($flex_idx_info["agent"]["google_login_enabled"]) && "1" == $flex_idx_info["agent"]["google_login_enabled"]): ?>
<script src="https://accounts.google.com/gsi/client" async defer></script>
<script>
function handleCredentialResponse(token) {
  if (!token || !token.hasOwnProperty("credential")) {
    return;
  }

  var jwt = token.credential.split(".");
  var profile = JSON.parse(atob(jwt[1]));

  var google_user_info = {
    'name': profile.name,
    'first_name': profile.given_name,
    'last_name': profile.family_name,
    'email': profile.email,
    'id': profile.sub,
    'photo_profile_url': profile.hasOwnProperty("picture") ? profile.picture : ""
  };

  console.dir(google_user_info);

  // hide registration form
  jQuery("#modal_login").removeClass("active_modal");

  swal({
    title: word_translate.your_account_is_being_created,
    text: word_translate.this_might_take_a_while_do_not_reload_thepage,
    type: "info",
    showConfirmButton: false,
    closeOnClickOutside: false,
    closeOnEsc: false
  });

  //GOOGLE REGISTER
  jQuery.ajax({
                url: __flex_g_settings.ajaxUrl,
                method: "POST",
                data: {
                    window_width: window.innerWidth,
                    user_info: google_user_info,
                    logon_type: "google",
                    action: "flex_idx_lead_signin",
                    ib_tags: jQuery("#formRegister_ib_tags").val(),
                    registration_key: (typeof IB_AGENT_REGISTRATION_KEY !== "undefined") ? IB_AGENT_REGISTRATION_KEY : null                    
                },
                dataType: "json",
                success: function(response) {
                    var ib_log_message = response.message;

                    IS_CUSTOM_SIGNUP = true;

                    if (response.message=='Logged in succesfully.'){
                        ib_log_message=word_translate.logged_in_succesfully;
                        // if ("undefined" !== typeof redirectregister) {
                        //     custom_modal_redirect(redirectregister);
                        // }
                    }else if(response.message=='Your account has been created successfully.'){
                        ib_log_message=word_translate.your_account_has_been_created_successfully;
                        // if ("undefined" !== typeof redirectregister) {
                        //     custom_modal_redirect(redirectregister);
                        // }
                      // track google signup
                      if (typeof dataLayer !== "undefined") {
                        dataLayer.push({'event': 'google_signin'});
                      }
                    }else if(response.message=='Invalid credentials, try again.'){
                        ib_log_message=word_translate.invalid_credentials_try_again;
                    }

                    if (response.success === true) {


                      if ("signup" === response.logon_type) {
                        if (typeof dataLayer !== "undefined") {
                          dataLayer.push({'event': 'google_register'});
                        }
                      } else if ("signin" === response.logon_type) {
                        if (typeof dataLayer !== "undefined") {
                          dataLayer.push({'event': 'google_signin'});
                        }
                      }

                      idx_auto_save_building(response);

                      Cookies.set("_ib_left_click_force_registration", 0);
                      // Cookies.set('ib_lead_token', response.lead_token, { expires: 30 });
                        Cookies.set('ib_lead_token', response.lead_token);

                        // if available history menu for lead
                        if (jQuery("#ib-lead-history-menu-btn").length) {
                          jQuery.ajax({
                            url :__flex_g_settings.fetchLeadActivitiesEndpoint,
                            method: "POST",
                            data: {
                              access_token: __flex_g_settings.accessToken,
                              flex_credentials: Cookies.get("ib_lead_token")
                            },
                            dataType: "json",
                            success: function(response) {
                              if ("yes" === response.lead_info.show_help_tooltip) {
                                jQuery("#ib-lead-history-tooltip-help").show();
                              }

                              jQuery("#ib-lead-history-menu-btn").show();

                              // fill generated values
                              var fill_first_letter_name_values = [];

                              if (response.lead_info.first_name.length) {
                                fill_first_letter_name_values.push(response.lead_info.first_name.charAt(0));
                              }

                              if (response.lead_info.last_name.length) {
                                fill_first_letter_name_values.push(response.lead_info.last_name.charAt(0));
                              }


                              if (__flex_g_settings.has_cms == "1") {
                                jQuery("body").addClass("logged");
                                jQuery(".js-login").addClass("ip-d-none");
                              }
                                  

                              jQuery(".ib-lead-first-letter-name").html(fill_first_letter_name_values.join(""));
                              
                              if (response.lead_info.hasOwnProperty('photo_url') && response.lead_info.photo_url.length) {
                                jQuery(".ib-lead-first-letter-name").css({
                                  'background-color': 'transparent',
                                  'background-image': 'url(' + response.lead_info.photo_url + ')',
                                  'background-repeat': 'no-repeat',
                                  'background-size': 'contain',
                                  'background-position': 'center center',
                                  'text-indent': '-9999px'
                                });
                              }

                              jQuery(".ib-lead-fullname").html(response.lead_info.first_name + " " + response.lead_info.last_name);
                              jQuery(".ib-lead-firstname").html(word_translate.hello+" " + response.lead_info.first_name + "!");

                              jQuery(".ib-agent-fullname").html(response.agent_info.first_name + " " + response.agent_info.last_name);
                              //jQuery(".ib-agent-phonenumber").html(response.agent_info.phone_number);
                              jQuery(".ib-agent-phonenumber").attr("href", "tel:" + response.agent_info.phone_number.replace(/[^\d]/g, ""));
                              jQuery(".ib-agent-emailaddress").attr("href", "mailto:" + response.agent_info.email_address);
                              jQuery(".ib-agent-photo-thumbnail-wrapper").empty();
                              jQuery(".ib-agent-photo-thumbnail-wrapper").append('<img src="' + response.agent_info.photo_url + '">');

                              // fill activity lead
                              jQuery("#_ib_lead_activity_rows").empty();
                              jQuery("#_ib_lead_activity_pagination").empty();

                              if (response.lead_info.listing_views.length) {
                                var lead_listing_views = response.lead_info.listing_views;
                                var lead_listing_views_html = [];

                                for (var i = 0, l = lead_listing_views.length; i < l; i++) {
                                  lead_listing_views_html.push('<div class="ms-history-menu-item">');
                                  lead_listing_views_html.push('<div class="ms-history-menu-wrap-img ib-agent-photo-thumbnail-wrapper">');
                                  lead_listing_views_html.push('<img src="'+lead_listing_views[i].thumbnail+'">');
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
                                  //lead_listing_views_html.push('<div class="ms-property-actions">');
                                  //lead_listing_views_html.push('<button class="ms-save"><span>save</span></button>');
                                  //lead_listing_views_html.push('<button class="ms-delete"><span>Delete</span></button>');
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
                                    lead_listing_views_paging.push('<a role="button" class="ib-pagprev ib-paggo" data-page="'+(response.lead_info.listing_views_pagination.current_page - 1 )+'"></a>');
                                  }

                                  lead_listing_views_paging.push('<div class="ib-paglinks">');

                                  var lead_listing_views_page_range = response.lead_info.listing_views_pagination.page_range_links;

                                  for (var i = 0, l =  lead_listing_views_page_range.length; i < l; i++) {
                                    if (lead_listing_views_page_range[i] == response.lead_info.listing_views_pagination.current_page) {
                                      lead_listing_views_paging.push('<a role="button" class="ib-plitem ib-plitem-active" data-page="'+lead_listing_views_page_range[i]+'">'+lead_listing_views_page_range[i]+'</a>');
                                    } else {
                                      lead_listing_views_paging.push('<a role="button" class="ib-plitem" data-page="'+lead_listing_views_page_range[i]+'">'+lead_listing_views_page_range[i]+'</a>');
                                    }
                                  }

                                  lead_listing_views_paging.push('</div>');

                                  if (response.lead_info.listing_views_pagination.has_next_page) {
                                    lead_listing_views_paging.push('<a role="button" class="ib-pagnext ib-paggo" data-page="'+(response.lead_info.listing_views_pagination.current_page + 1 )+'"></a>');
                                  }

                                  jQuery("#_ib_lead_activity_pagination").html('<div class="ms-history-menu-wrapper-pagination">'+lead_listing_views_paging.join("")+'</div>');
                                }
                              }
                            }
                          });
                        }

                        // socket.subscribe(__flex_g_settings.pusher.presence_channel);
                        if ("undefined" !== typeof socket) {
                            socket.disconnect();

                            socket = new Pusher(__flex_g_settings.pusher.app_key, {
                              cluster: __flex_g_settings.pusher.app_cluster,
                              encrypted: true,
                              authEndpoint: __flex_g_settings.socketAuthUrl + "?ib_lead_token=" + Cookies.get("ib_lead_token")
                            });
                            
                            socket.subscribe(__flex_g_settings.pusher.presence_channel);
                          }

                        // callback [login]

                        // jQuery(".close").click();

                        // updates lead list menu HTML
                        jQuery("#user-options").html(response.output);
                        jQuery(".lg-wrap-login:eq(0)").html(response.output);
                        jQuery(".lg-wrap-login:eq(0)").addClass("active");

                        // // reset registration form
                        // _self.trigger('reset');
                        Cookies.set("social_register","activo");

                        // save last logged in username
                        Cookies.set("_ib_last_logged_in_username", response.last_logged_in_username);

                        // store first name
                        Cookies.set("_ib_user_firstname", response.first_name);

                        // store last name
                        Cookies.set("_ib_user_lastname", response.last_name);

                        // store email
                        Cookies.set("_ib_user_email", response.email);

                        Cookies.set("_ib_user_phone", response.phone);
                        Cookies.set("_ib_user_code_phone", response.country_code_phone);

                        var newPhoneNumber = Cookies.get("_ib_user_phone");
                        var newPhoneCode = Cookies.get("_ib_user_code_phone");

                        if(typeof newPhoneNumber === "undefined" || newPhoneNumber === "null"){
                          Cookies.remove("_ib_user_phone");
                          Cookies.remove("_ib_user_code_phone");
                          Cookies.set("_ib_user_phone","");
                          Cookies.set("_ib_user_code_phone","");
                        }else{
                          var newPhoneNumberFormat = "+"+newPhoneCode+newPhoneNumber;
                          Cookies.set("_ib_user_new_phone_number", newPhoneNumberFormat);
                          /*jQuery(".iboost-form-validation-loaded").each(function () {
                            var id = jQuery(this).attr("data-id");
                            console.log("id="+id+"/"+newPhoneNumberFormat);
                            iti[id].setNumber(newPhoneNumberFormat);
                          });*/
                        }

                        jQuery("#_ib_fn_inq").val(response.first_name);
                        jQuery("#_ib_ln_inq").val(response.last_name);
                        jQuery("#_ib_em_inq").val(response.email);
                        jQuery("#_ib_ph_inq").val(response.phone);

                        jQuery("._ib_fn_inq").val(response.first_name);
                        jQuery("._ib_ln_inq").val(response.last_name);
                        jQuery("._ib_em_inq").val(response.email);
                        jQuery("._ib_ph_inq").val(response.phone);

                        jQuery('[name="firstName"]').val(response.first_name);
                        jQuery('[name="lastName"]').val(response.last_name);
                        jQuery('[name="email"]').val(response.email);
                        jQuery('[name="phone"]').val(response.phone);

                        jQuery('[name="name"]').val(response.first_name);
                        jQuery('[name="lastname"]').val(response.last_name);
                        jQuery('[name="email"]').val(response.email);
                        jQuery('[name="phone"]').val(response.phone);

                        // Sets user information on CMS Forms
                        if (
                          typeof idxpages === 'object' && 
                          idxpages.forms && 
                          typeof idxpages.forms.init === 'function'
                        ) {
                          idxpages.forms.init();
                        }

                        jQuery('html').removeClass('modal_mobile');

                        // overwrite lead status globally
                        __flex_g_settings.anonymous = "no";

                        //if ("undefined" !== lastOpenedProperty) {
                        if (typeof lastOpenedProperty !== "undefined") {
                          if (typeof loadPropertyInModal !== "undefined") {
                            loadPropertyInModal(lastOpenedProperty);
                          }
                        }

                        if ((typeof lastOpenedProperty !== "undefined") && lastOpenedProperty.length) {
                          // track listing view
                          jQuery.ajax({
                            type: "POST",
                            url: __flex_g_settings.ajaxUrl,
                            data: {
                              action: "track_property_view",
                              board_id: __flex_g_settings.boardId,
                              mls_number: (typeof lastOpenedProperty === "undefined") ? "" : lastOpenedProperty,
                              mls_opened_list: ((Cookies.get("_ib_user_listing_views") === "undefined") ? [] : JSON.parse(Cookies.get("_ib_user_listing_views")) )
                            },
                            success: function(response) {
                              console.log("track done for property #" + lastOpenedProperty);
                              Cookies.set("_ib_user_listing_views", JSON.stringify([]));
                            }
                          });
                        }

                        // notify user with success message

                        swal({
                          title: word_translate.congratulations,
                          text: ib_log_message,
                          type: "success",
                          showConfirmButton: false,
                          closeOnClickOutside: true,
                          closeOnEsc: true,
                          timer: 3000
                        });

                        setTimeout(function () {
                            if (typeof originalPositionY !== "undefined") {
                              if (!jQuery(".ib-modal-master.ib-mmpd").hasClass("ib-md-active")) {
                                console.log('restoring to: ' + originalPositionY);
                                window.scrollTo(0,originalPositionY);
                              }
                            }
                        }, 3000);

                        if ( ("undefined" !== typeof IB_IS_SEARCH_FILTER_PAGE) && (true === IB_IS_SEARCH_FILTER_PAGE) ||
                             ("undefined" !== typeof IB_IS_REGULAR_FILTER_PAGE) && (true === IB_IS_REGULAR_FILTER_PAGE) ) {
                          // save filter for lead is it doesnt exists
                          saveFilterSearchForLead();
                        }

                        //to generate the google tag conversion of sigened in user
                        if (typeof gtagfucntion == 'function') {
                          gtagfucntion();
                        }

                        setTimeout(function () {
                            console.group('[googleSignup]');
                            console.log(__flex_g_settings.user_show_quizz);
                            console.dir(response);
                            console.groupEnd('[googleSignup]');

                            //if ( ("1" == __flex_g_settings.user_show_quizz) && ("signup" == response.logon_type) ) {
                            //if ( ("yes" == __flex_g_settings.has_facebook_login_enabled) && ("signup" == response.logon_type) ) {
                            // @todo open view
                            if ("signup" == response.logon_type) {

                              jQuery("#__quizz_type").val("google");
                              jQuery("#__quizz_type_phone_ct").show();
                              jQuery("#__quizz_cancel_on_fb").removeClass("ib-active");
                              jQuery("#__quizz_type_phone_ct").addClass("ib-active");
                              jQuery("#ib-push-registration-quizz-ct").addClass("ib-md-pa ib-md-active");
                              jQuery("#msboxinfo").remove();

                            }

                            var loadForm = jQuery(".iboost-form-validation-loaded");
                            if(loadForm.length){
                              jQuery(".iboost-form-validation-loaded").each(function () {
                                var id = jQuery(this).attr("data-id");
                                if(typeof id === "undefined" || id === "null" || id === ""){
                                  //console.log("No tiene valor");
                                }else{
                                  //console.log("id="+id);
                                  iti[id].setNumber(Cookies.get("_ib_user_new_phone_number"));
                                }
                              });
                            }

                          }, 3000);

                        // setTimeout(function () {
                        //   if ( ("1" == __flex_g_settings.user_show_quizz) && ("signup" == response.logon_type) ) {
                        //     jQuery("#ib-push-registration-quizz-ct").addClass("ib-md-pa ib-md-active");
                        //   }
                        // }, 3000);
                    } else {
                        sweetAlert("Oops...", ib_log_message, "error");
                    }
                }
            });
}
</script>
<?php /*
<script src="https://apis.google.com/js/api:client.js"></script>
<script>
  var googleUser = {};
  var startApp = function() {
    gapi.load('auth2', function(){
      // Retrieve the singleton for the GoogleAuth library and set up the client.
      auth2 = gapi.auth2.init({
        client_id: "<?php echo $flex_idx_info["agent"]["google_client_id"]; ?>",
        cookiepolicy: 'none',
        ux_mode: 'popup'
        // Request scopes in addition to 'profile' and 'email'
        //scope: 'additional_scope'
      });

      attachSignin(document.getElementById('gSignIn'));
    });
  };

  function attachSignin(element) {
    auth2.attachClickHandler(element, {},
        function(googleUser) {
          var profile = googleUser.getBasicProfile();
          
          console.log('Fetching data from google...');
          // console.dir({
          //   id: profile.getId(),
          //   name: profile.getName(),
          //   givenName: profile.getGivenName(),
          //   familyName: profile.getFamilyName(),
          //   imageUrl: profile.getImageUrl() + "?sz=100",
          //   email: profile.getEmail()
          // });

          // return;

          var google_user_info = {
            'name': profile.getName(),
            'first_name': profile.getGivenName(),
            'last_name': profile.getFamilyName(),
            'email': profile.getEmail(),
            'id': profile.getId(),
            'photo_profile_url': profile.getImageUrl() + "?sz=100"
          };

          // hide registration form
          jQuery("#modal_login").removeClass("active_modal");

          swal({
            title: word_translate.your_account_is_being_created,
            text: word_translate.this_might_take_a_while_do_not_reload_thepage,
            type: "info",
            showConfirmButton: false,
            closeOnClickOutside: false,
            closeOnEsc: false
          });

          console.dir(google_user_info);

            jQuery.ajax({
                url: __flex_g_settings.ajaxUrl,
                method: "POST",
                data: {
                    window_width: window.innerWidth,
                    user_info: google_user_info,
                    logon_type: "google",
                    action: "flex_idx_lead_signin",
                    ib_tags: jQuery("formRegister_ib_tags").val(),
                    registration_key: (typeof IB_AGENT_REGISTRATION_KEY !== "undefined") ? IB_AGENT_REGISTRATION_KEY : null                    
                },
                dataType: "json",
                success: function(response) {
                    var ib_log_message = response.message;

                    IS_CUSTOM_SIGNUP = true;

                    if (response.message=='Logged in succesfully.'){
                        ib_log_message=word_translate.logged_in_succesfully;
                        // if ("undefined" !== typeof redirectregister) {
                        //     custom_modal_redirect(redirectregister);
                        // }
                    }else if(response.message=='Your account has been created successfully.'){
                        ib_log_message=word_translate.your_account_has_been_created_successfully;
                        // if ("undefined" !== typeof redirectregister) {
                        //     custom_modal_redirect(redirectregister);
                        // }
                      // track google signup
                      if (typeof dataLayer !== "undefined") {
                        dataLayer.push({'event': 'google_signin'});
                      }
                    }else if(response.message=='Invalid credentials, try again.'){
                        ib_log_message=word_translate.invalid_credentials_try_again;
                    }

                    if (response.success === true) {
                      if ("signup" === response.logon_type) {
                        if (typeof dataLayer !== "undefined") {
                          dataLayer.push({'event': 'google_register'});
                        }
                      } else if ("signin" === response.logon_type) {
                        if (typeof dataLayer !== "undefined") {
                          dataLayer.push({'event': 'google_signin'});
                        }
                      }

                      idx_auto_save_building(response);
                      
                      Cookies.set('ib_lead_token', response.lead_token, { expires: 30 });

                        // if available history menu for lead
                        if (jQuery("#ib-lead-history-menu-btn").length) {
                          jQuery.ajax({
                            url :__flex_g_settings.fetchLeadActivitiesEndpoint,
                            method: "POST",
                            data: {
                              access_token: __flex_g_settings.accessToken,
                              flex_credentials: Cookies.get("ib_lead_token")
                            },
                            dataType: "json",
                            success: function(response) {
                              if ("yes" === response.lead_info.show_help_tooltip) {
                                jQuery("#ib-lead-history-tooltip-help").show();
                              }

                              jQuery("#ib-lead-history-menu-btn").show();

                              // fill generated values
                              var fill_first_letter_name_values = [];

                              if (response.lead_info.first_name.length) {
                                fill_first_letter_name_values.push(response.lead_info.first_name.charAt(0));
                              }

                              if (response.lead_info.last_name.length) {
                                fill_first_letter_name_values.push(response.lead_info.last_name.charAt(0));
                              }


                              if (__flex_g_settings.has_cms == "1") {
                                jQuery("body").addClass("logged");
                                jQuery(".js-login").addClass("ip-d-none");
                              }
                                  

                              jQuery(".ib-lead-first-letter-name").html(fill_first_letter_name_values.join(""));
                              
                              if (response.lead_info.hasOwnProperty('photo_url') && response.lead_info.photo_url.length) {
                                jQuery(".ib-lead-first-letter-name").css({
                                  'background-color': 'transparent',
                                  'background-image': 'url(' + response.lead_info.photo_url + ')',
                                  'background-repeat': 'no-repeat',
                                  'background-size': 'contain',
                                  'background-position': 'center center',
                                  'text-indent': '-9999px'
                                });
                              }

                              jQuery(".ib-lead-fullname").html(response.lead_info.first_name + " " + response.lead_info.last_name);
                              jQuery(".ib-lead-firstname").html(word_translate.hello+" " + response.lead_info.first_name + "!");

                              jQuery(".ib-agent-fullname").html(response.agent_info.first_name + " " + response.agent_info.last_name);
                              //jQuery(".ib-agent-phonenumber").html(response.agent_info.phone_number);
                              jQuery(".ib-agent-phonenumber").attr("href", "tel:" + response.agent_info.phone_number.replace(/[^\d]/g, ""));
                              jQuery(".ib-agent-emailaddress").attr("href", "mailto:" + response.agent_info.email_address);
                              jQuery(".ib-agent-photo-thumbnail-wrapper").empty();
                              jQuery(".ib-agent-photo-thumbnail-wrapper").append('<img src="' + response.agent_info.photo_url + '">');

                              // fill activity lead
                              jQuery("#_ib_lead_activity_rows").empty();
                              jQuery("#_ib_lead_activity_pagination").empty();

                              if (response.lead_info.listing_views.length) {
                                var lead_listing_views = response.lead_info.listing_views;
                                var lead_listing_views_html = [];

                                for (var i = 0, l = lead_listing_views.length; i < l; i++) {
                                  lead_listing_views_html.push('<div class="ms-item">');
                                  lead_listing_views_html.push('<div class="ms-wrap-img ib-agent-photo-thumbnail-wrapper">');
                                  lead_listing_views_html.push('<img src="'+lead_listing_views[i].thumbnail+'">');
                                  lead_listing_views_html.push('</div>');
                                  lead_listing_views_html.push('<div class="ms-property-detail">');
                                  lead_listing_views_html.push('<h3 class="ms-title">'+lead_listing_views[i].address_short+'</h3>');
                                  lead_listing_views_html.push('<h4 class="ms-address">'+lead_listing_views[i].address_large+'</h4>');
                                  lead_listing_views_html.push('<h5 class="ms-price">'+lead_listing_views[i].price+'</h5>');
                                  lead_listing_views_html.push('<div class="ms-details">');
                                    lead_listing_views_html.push('<span>'+lead_listing_views[i].bed+' '+word_translate.beds+'</span>');
                                    lead_listing_views_html.push('<span>'+lead_listing_views[i].bath+' '+word_translate.baths+'</span>');
                                    lead_listing_views_html.push('<span>'+lead_listing_views[i].sqft+' '+word_translate.sqft+'</span>');
                                  lead_listing_views_html.push('</div>');
                                  lead_listing_views_html.push('</div>');
                                  //lead_listing_views_html.push('<div class="ms-property-actions">');
                                  //lead_listing_views_html.push('<button class="ms-save"><span>save</span></button>');
                                  //lead_listing_views_html.push('<button class="ms-delete"><span>Delete</span></button>');
                                  //lead_listing_views_html.push('</div>');
                                  lead_listing_views_html.push('<a href="'+__flex_g_settings.propertyDetailPermalink+'/'+lead_listing_views[i].slug+'" target="_blank" class="ms-link">'+lead_listing_views[i].address_short + ' ' +  lead_listing_views[i].address_large +'</a>');
                                  lead_listing_views_html.push('</div>');
                                }

                                jQuery("#_ib_lead_activity_rows").html(lead_listing_views_html.join(""));
                              }

                              // build pagination
                              if (response.lead_info.hasOwnProperty('listing_views_pagination')) {
                                if (response.lead_info.listing_views_pagination.total_pages > 1) {
                                  var lead_listing_views_paging = [];

                                  if (response.lead_info.listing_views_pagination.has_prev_page) {
                                    lead_listing_views_paging.push('<a class="ib-pagprev ib-paggo" data-page="'+(response.lead_info.listing_views_pagination.current_page - 1 )+'" href="#"></a>');
                                  }

                                  lead_listing_views_paging.push('<div class="ib-paglinks">');

                                  var lead_listing_views_page_range = response.lead_info.listing_views_pagination.page_range_links;

                                  for (var i = 0, l =  lead_listing_views_page_range.length; i < l; i++) {
                                    if (lead_listing_views_page_range[i] == response.lead_info.listing_views_pagination.current_page) {
                                      lead_listing_views_paging.push('<a class="ib-plitem ib-plitem-active" data-page="'+lead_listing_views_page_range[i]+'" href="#">'+lead_listing_views_page_range[i]+'</a>');
                                    } else {
                                      lead_listing_views_paging.push('<a class="ib-plitem" data-page="'+lead_listing_views_page_range[i]+'" href="#">'+lead_listing_views_page_range[i]+'</a>');
                                    }
                                  }

                                  lead_listing_views_paging.push('</div>');

                                  if (response.lead_info.listing_views_pagination.has_next_page) {
                                    lead_listing_views_paging.push('<a class="ib-pagnext ib-paggo" data-page="'+(response.lead_info.listing_views_pagination.current_page + 1 )+'" href="#"></a>');
                                  }

                                  jQuery("#_ib_lead_activity_pagination").html('<div class="ms-wrapper-pagination">'+lead_listing_views_paging.join("")+'</div>');
                                }
                              }
                            }
                          });
                        }

                        // socket.subscribe(__flex_g_settings.pusher.presence_channel);
                        if ("undefined" !== typeof socket) {
                            socket.disconnect();

                            socket = new Pusher(__flex_g_settings.pusher.app_key, {
                              cluster: __flex_g_settings.pusher.app_cluster,
                              encrypted: true,
                              authEndpoint: __flex_g_settings.socketAuthUrl + "?ib_lead_token=" + Cookies.get("ib_lead_token")
                            });
                            
                            socket.subscribe(__flex_g_settings.pusher.presence_channel);
                          }

                        // callback [login]

                        // jQuery(".close").click();

                        // updates lead list menu HTML
                        jQuery("#user-options").html(response.output);
                        jQuery(".lg-wrap-login:eq(0)").html(response.output);
                        jQuery(".lg-wrap-login:eq(0)").addClass("active");

                        // // reset registration form
                        // _self.trigger('reset');

                        // save last logged in username
                        Cookies.set("_ib_last_logged_in_username", response.last_logged_in_username);

                        // store first name
                        Cookies.set("_ib_user_firstname", response.first_name);

                        // store last name
                        Cookies.set("_ib_user_lastname", response.last_name);

                        // store phone
                        Cookies.set("_ib_user_phone", response.phone);

                        // store email
                        Cookies.set("_ib_user_email", response.email);

                        jQuery("#_ib_fn_inq").val(response.first_name);
                        jQuery("#_ib_ln_inq").val(response.last_name);
                        jQuery("#_ib_em_inq").val(response.email);
                        jQuery("#_ib_ph_inq").val(response.phone);

                        jQuery("._ib_fn_inq").val(response.first_name);
                        jQuery("._ib_ln_inq").val(response.last_name);
                        jQuery("._ib_em_inq").val(response.email);
                        jQuery("._ib_ph_inq").val(response.phone);

                        jQuery('html').removeClass('modal_mobile');

                        // overwrite lead status globally
                        __flex_g_settings.anonymous = "no";

                        //if ("undefined" !== lastOpenedProperty) {
                        if (typeof lastOpenedProperty !== "undefined") {
                          if (typeof loadPropertyInModal !== "undefined") {
                            window.loadPropertyInModal(lastOpenedProperty);
                          }
                        }

                        if ((typeof lastOpenedProperty !== "undefined") && lastOpenedProperty.length) {
                          // track listing view
                          jQuery.ajax({
                            type: "POST",
                            url: __flex_g_settings.ajaxUrl,
                            data: {
                              action: "track_property_view",
                              board_id: __flex_g_settings.boardId,
                              mls_number: (typeof lastOpenedProperty === "undefined") ? "" : lastOpenedProperty,
                              mls_opened_list: ((Cookies.get("_ib_user_listing_views") === "undefined") ? [] : JSON.parse(Cookies.get("_ib_user_listing_views")) )
                            },
                            success: function(response) {
                              console.log("track done for property #" + lastOpenedProperty);
                              Cookies.set("_ib_user_listing_views", JSON.stringify([]));
                            }
                          });
                        }

                        // notify user with success message

                        swal({
                          title: word_translate.congratulations,
                          text: ib_log_message,
                          type: "success",
                          showConfirmButton: false,
                          closeOnClickOutside: true,
                          closeOnEsc: true,
                          timer: 3000
                        });

                        setTimeout(function () {
                            if (typeof originalPositionY !== "undefined") {
                              if (!$(".ib-modal-master.ib-mmpd").hasClass("ib-md-active")) {
                                console.log('restoring to: ' + originalPositionY);
                                window.scrollTo(0,originalPositionY);
                              }
                            }
                        }, 3000);

                        if ( ("undefined" !== typeof IB_IS_SEARCH_FILTER_PAGE) && (true === IB_IS_SEARCH_FILTER_PAGE) ||
                             ("undefined" !== typeof IB_IS_REGULAR_FILTER_PAGE) && (true === IB_IS_REGULAR_FILTER_PAGE) ) {
                          // save filter for lead is it doesnt exists
                          saveFilterSearchForLead();
                        }

                        //to generate the google tag conversion of sigened in user
                        if (typeof gtagfucntion == 'function') {
                          gtagfucntion();
                        }

                        setTimeout(function () {
                            console.group('[googleSignup]');
                              console.log(__flex_g_settings.user_show_quizz);
                              console.dir(response);
                            console.groupEnd('[googleSignup]');

                            //if ( ("1" == __flex_g_settings.user_show_quizz) && ("signup" == response.logon_type) ) {
                            //if ( ("yes" == __flex_g_settings.has_facebook_login_enabled) && ("signup" == response.logon_type) ) {
                              // @todo open view
                              if ("signup" == response.logon_type) {

                              jQuery("#__quizz_type").val("google");
                              jQuery("#__quizz_type_phone_ct").show();
                              jQuery("#__quizz_cancel_on_fb").removeClass("ib-active");
                              jQuery("#__quizz_type_phone_ct").addClass("ib-active");
                              jQuery("#ib-push-registration-quizz-ct").addClass("ib-md-pa ib-md-active");
                            }
                          }, 3000);

                        // setTimeout(function () {
                        //   if ( ("1" == __flex_g_settings.user_show_quizz) && ("signup" == response.logon_type) ) {
                        //     jQuery("#ib-push-registration-quizz-ct").addClass("ib-md-pa ib-md-active");
                        //   }
                        // }, 3000);
                    } else {
                        sweetAlert("Oops...", ib_log_message, "error");
                    }
                }
            });

        }, function(error) {
          console.error(error);
          // alert(JSON.stringify(error, undefined, 2));
        });
  }

   startApp();
  </script>
  */ ?>
<?php endif; ?>

<?php if (isset($flex_idx_info["agent"]["facebook_login_enabled"]) && "1" == $flex_idx_info["agent"]["facebook_login_enabled"]): ?>
<script>

window.fbAsyncInit = function() {
  FB.init({
      appId: "<?php echo $flex_idx_info["agent"]["facebook_app_id"]; ?>",
      cookie: true,
      xfbml: true,
      version: 'v2.8'
  });

  FB.AppEvents.logPageView();
};

function fb_login() {

  FB.login(function(response) {
      if (response.status === "connected") {
          var userID = response.authResponse.userID;

          FB.api('/me?fields=name,first_name,last_name,email,picture.width(100).height(100)', function(response) {
              console.log("Fetching data from facebook...");
              console.dir(response);
              response.photo_profile_url = response.hasOwnProperty('picture') ? response.picture.data.url : null;
              // return;

              if (!response.hasOwnProperty("email")) {
                jQuery("#modal_login").removeClass("active_modal");
                sweetAlert(word_translate.oops, "We couldn't find an email address linked to your Facebook account, please provide one.", "error");
                jQuery(document).one("click", ".confirm", function() {
                  setTimeout(function () {
                    jQuery("#modal_login").addClass("active_modal");
                    jQuery("#tabLogin").removeClass("active");
                    jQuery("#tabReset").removeClass("active");
                    jQuery("#tabRegister").addClass("active");
                  }, 200);
                });
                return;
              }

              // hide registration form
              jQuery("#modal_login").removeClass("active_modal");

              swal({
                title: word_translate.your_account_is_being_created,
                text: word_translate.this_might_take_a_while_do_not_reload_thepage,
                type: "info",
                showConfirmButton: false,
                closeOnClickOutside: false,
                closeOnEsc: false
              });

              //FACEBOOK REGISTER
                jQuery.ajax({
                    url: __flex_g_settings.ajaxUrl,
                    method: "POST",
                    data: {
                        window_width: window.innerWidth,
                        user_info: response,
                        logon_type: "facebook",
                        action: "flex_idx_lead_signin",
                        __property_signup_price: jQuery('.ib_property_signup_price:eq(0)').val(),
                        source_registration_title: (typeof IB_SEARCH_FILTER_PAGE_TITLE !== 'undefined') ? IB_SEARCH_FILTER_PAGE_TITLE : null,
                        source_registration_url: (typeof IB_SEARCH_FILTER_PAGE_TITLE !== 'undefined') ? location.href : null,
                        ib_tags: jQuery("#formRegister_ib_tags").val(),
                        registration_key: (typeof IB_AGENT_REGISTRATION_KEY !== "undefined") ? IB_AGENT_REGISTRATION_KEY : null
                    },
                    dataType: "json",
                    success: function(response) {
                        var ib_log_message = response.message;

                        IS_CUSTOM_SIGNUP = true;

                        if (response.message=='Logged in succesfully.') {
                            ib_log_message=word_translate.logged_in_succesfully;
                            if ("undefined" !== typeof redirectregister) {
                              custom_modal_redirect(redirectregister);
                            }
                            // if ( redirectregister !== undefined) {custom_modal_redirect(redirectregister)}

                        } else if(response.message=='Your account has been created successfully.') {
                            ib_log_message=word_translate.your_account_has_been_created_successfully;
                            // if ( redirectregister !== undefined) {custom_modal_redirect(redirectregister)}
                            if ("undefined" !== typeof redirectregister) {
                              custom_modal_redirect(redirectregister);
                            }
                        } else if(response.message=='Invalid credentials, try again.') {
                            ib_log_message=word_translate.invalid_credentials_try_again;
                        }

                        if (response.success === true) {
                          if ("signup" === response.logon_type) {
                            if (typeof dataLayer !== "undefined") {
                              dataLayer.push({'event': 'facebook_register'});
                            }
                          } else if ("signin" === response.logon_type) {
                            if (typeof dataLayer !== "undefined") {
                              dataLayer.push({'event': 'facebook_register'});
                              dataLayer.push({'event': 'facebook_signin'});
                            }
                          }

                            Cookies.set("_ib_left_click_force_registration", 0);
                            Cookies.set('ib_lead_token', response.lead_token);
                            // Cookies.set('ib_lead_token', response.lead_token, {
                            //   expires: 30
                            // });

                            // if available history menu for lead
                            if (jQuery("#ib-lead-history-menu-btn").length) {
                              jQuery.ajax({
                                url :__flex_g_settings.fetchLeadActivitiesEndpoint,
                                method: "POST",
                                data: {
                                  access_token: __flex_g_settings.accessToken,
                                  flex_credentials: Cookies.get("ib_lead_token")
                                },
                                dataType: "json",
                                success: function(response) {
                                  if ("yes" === response.lead_info.show_help_tooltip) {
                                    jQuery("#ib-lead-history-tooltip-help").show();
                                  }

                                  jQuery("#ib-lead-history-menu-btn").show();

                                  // fill generated values
                                  var fill_first_letter_name_values = [];

                                  if (response.lead_info.first_name.length) {
                                    fill_first_letter_name_values.push(response.lead_info.first_name.charAt(0));
                                  }

                                  if (response.lead_info.last_name.length) {
                                    fill_first_letter_name_values.push(response.lead_info.last_name.charAt(0));
                                  }

                                  if (__flex_g_settings.has_cms == "1") {
                                    jQuery("body").addClass("logged");
                                    jQuery(".js-login").addClass("ip-d-none");
                                  }

                                  jQuery(".ib-lead-first-letter-name").html(fill_first_letter_name_values.join(""));
                                  
                                  if (response.lead_info.hasOwnProperty('photo_url') && response.lead_info.photo_url.length) {
                                    jQuery(".ib-lead-first-letter-name").css({
                                      'background-color': 'transparent',
                                      'background-image': 'url(' + response.lead_info.photo_url + ')',
                                      'background-repeat': 'no-repeat',
                                      'background-size': 'contain',
                                      'background-position': 'center center',
                                      'text-indent': '-9999px'
                                    });
                                  }

                                  jQuery(".ib-lead-fullname").html(response.lead_info.first_name + " " + response.lead_info.last_name);
                                  jQuery(".ib-lead-firstname").html(word_translate.hello+" " + response.lead_info.first_name + "!");

                                  jQuery(".ib-agent-fullname").html(response.agent_info.first_name + " " + response.agent_info.last_name);
                                  //jQuery(".ib-agent-phonenumber").html(response.agent_info.phone_number);
                                  jQuery(".ib-agent-phonenumber").attr("href", "tel:" + response.agent_info.phone_number.replace(/[^\d]/g, ""));
                                  jQuery(".ib-agent-emailaddress").attr("href", "mailto:" + response.agent_info.email_address);
                                  jQuery(".ib-agent-photo-thumbnail-wrapper").empty();
                                  jQuery(".ib-agent-photo-thumbnail-wrapper").append('<img src="' + response.agent_info.photo_url + '">');

                                  // fill activity lead
                                  jQuery("#_ib_lead_activity_rows").empty();
                                  jQuery("#_ib_lead_activity_pagination").empty();

                                  if (response.lead_info.listing_views.length) {
                                    var lead_listing_views = response.lead_info.listing_views;
                                    var lead_listing_views_html = [];

                                    for (var i = 0, l = lead_listing_views.length; i < l; i++) {
                                      lead_listing_views_html.push('<div class="ms-history-menu-item">');
                                      lead_listing_views_html.push('<div class="ms-history-menu-wrap-img ib-agent-photo-thumbnail-wrapper">');
                                      lead_listing_views_html.push('<img src="'+lead_listing_views[i].thumbnail+'">');
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
                                        lead_listing_views_paging.push('<a role="button" class="ib-pagprev ib-paggo" data-page="'+(response.lead_info.listing_views_pagination.current_page - 1 )+'"></a>');
                                      }

                                      lead_listing_views_paging.push('<div class="ib-paglinks">');

                                      var lead_listing_views_page_range = response.lead_info.listing_views_pagination.page_range_links;

                                      for (var i = 0, l =  lead_listing_views_page_range.length; i < l; i++) {
                                        if (lead_listing_views_page_range[i] == response.lead_info.listing_views_pagination.current_page) {
                                          lead_listing_views_paging.push('<a role="button" class="ib-plitem ib-plitem-active" data-page="'+lead_listing_views_page_range[i]+'">'+lead_listing_views_page_range[i]+'</a>');
                                        } else {
                                          lead_listing_views_paging.push('<a role="button" class="ib-plitem" data-page="'+lead_listing_views_page_range[i]+'">'+lead_listing_views_page_range[i]+'</a>');
                                        }
                                      }

                                      lead_listing_views_paging.push('</div>');

                                      if (response.lead_info.listing_views_pagination.has_next_page) {
                                        lead_listing_views_paging.push('<a role="button" class="ib-pagnext ib-paggo" data-page="'+(response.lead_info.listing_views_pagination.current_page + 1 )+'"></a>');
                                      }

                                      jQuery("#_ib_lead_activity_pagination").html('<div class="ms-history-menu-wrapper-pagination">'+lead_listing_views_paging.join("")+'</div>');
                                    }
                                  }
                                }
                              });
                            }

                            //socket.subscribe(__flex_g_settings.pusher.presence_channel);
                            if ("undefined" !== typeof socket) {
                              socket.disconnect();

                              socket = new Pusher(__flex_g_settings.pusher.app_key, {
                                cluster: __flex_g_settings.pusher.app_cluster,
                                encrypted: true,
                                authEndpoint: __flex_g_settings.socketAuthUrl + "?ib_lead_token=" + Cookies.get("ib_lead_token")
                              });
                              
                              socket.subscribe(__flex_g_settings.pusher.presence_channel);
                            }
                        
                            // updates lead list menu HTML
                            jQuery("#user-options").html(response.output);
                            jQuery(".lg-wrap-login:eq(0)").html(response.output);
                            jQuery(".lg-wrap-login:eq(0)").addClass("active");

                            Cookies.set("social_register","activo");

                            // callback [login]

                            // // reset registration form
                            // _self.trigger('reset');

                            // save last logged in username
                            Cookies.set("_ib_last_logged_in_username", response.last_logged_in_username);

                            // store first name
                            Cookies.set("_ib_user_firstname", response.first_name);

                            // store last name
                            Cookies.set("_ib_user_lastname", response.last_name);

                            // store email
                            Cookies.set("_ib_user_email", response.email);

                            Cookies.set("_ib_user_phone", response.phone);
                            Cookies.set("_ib_user_code_phone", response.country_code_phone);

                            var newPhoneNumber = Cookies.get("_ib_user_phone");
                            var newPhoneCode = Cookies.get("_ib_user_code_phone");

                            if(typeof newPhoneNumber === "undefined" || newPhoneNumber === "null"){
                              Cookies.remove("_ib_user_phone");
                              Cookies.remove("_ib_user_code_phone");
                              Cookies.set("_ib_user_phone","");
                              Cookies.set("_ib_user_code_phone","");
                            }else{
                              var newPhoneNumberFormat = "+"+newPhoneCode+newPhoneNumber;
                              Cookies.set("_ib_user_new_phone_number", newPhoneNumberFormat);
                            }

                            idx_auto_save_building(response);

                            jQuery("#_ib_fn_inq").val(response.first_name);
                            jQuery("#_ib_ln_inq").val(response.last_name);
                            jQuery("#_ib_em_inq").val(response.email);
                            jQuery("#_ib_ph_inq").val(response.phone);

                            jQuery("._ib_fn_inq").val(response.first_name);
                            jQuery("._ib_ln_inq").val(response.last_name);
                            jQuery("._ib_em_inq").val(response.email);
                            jQuery("._ib_ph_inq").val(response.phone);

                            jQuery('[name="name"]').val(response.first_name);
                            jQuery('[name="lastname"]').val(response.last_name);
                            jQuery('[name="email"]').val(response.email);
                            jQuery('[name="phone"]').val(response.phone);

                            // Sets user information on CMS Forms
                            if (
                              typeof idxpages === 'object' && 
                              idxpages.forms && 
                              typeof idxpages.forms.init === 'function'
                            ) {
                              idxpages.forms.init();
                            }

                            jQuery('html').removeClass('modal_mobile');

                            // overwrite lead status globally
                            __flex_g_settings.anonymous = "no";

                            //if ("undefined" !== lastOpenedProperty) {
                            if (typeof lastOpenedProperty !== "undefined") {
                              if (typeof loadPropertyInModal !== "undefined") {
                                loadPropertyInModal(lastOpenedProperty);
                              }
                            }

                            if ((typeof lastOpenedProperty !== "undefined") && lastOpenedProperty.length) {
                              // track listing view
                              jQuery.ajax({
                                type: "POST",
                                url: __flex_g_settings.ajaxUrl,
                                data: {
                                  action: "track_property_view",
                                  board_id: __flex_g_settings.boardId,
                                  mls_number: (typeof lastOpenedProperty === "undefined") ? "" : lastOpenedProperty,
                                  mls_opened_list: ((Cookies.get("_ib_user_listing_views") === "undefined") ? [] : JSON.parse(Cookies.get("_ib_user_listing_views")) )
                                },
                                success: function(response) {
                                  console.log("track done for property #" + lastOpenedProperty);
                                  Cookies.set("_ib_user_listing_views", JSON.stringify([]));
                                }
                              });
                            }

                              // notify user with success message
                            swal({
                              title: word_translate.congratulations,
                              text: ib_log_message,
                              type: "success",
                              showConfirmButton: false,
                              closeOnClickOutside: true,
                              closeOnEsc: true,
                              timer: 3000
                            });
                            
                            setTimeout(function () {
                              if (typeof originalPositionY !== "undefined") {
                                if (!$(".ib-modal-master.ib-mmpd").hasClass("ib-md-active")) {
                                  console.log('restoring to: ' + originalPositionY);
                                  window.scrollTo(0,originalPositionY);
                                }
                              }
                            }, 3000);

                            if ( ("undefined" !== typeof IB_IS_SEARCH_FILTER_PAGE) && (true === IB_IS_SEARCH_FILTER_PAGE) ||
                             ("undefined" !== typeof IB_IS_REGULAR_FILTER_PAGE) && (true === IB_IS_REGULAR_FILTER_PAGE) ) {
                              // save filter for lead is it doesnt exists
                              saveFilterSearchForLead();
                            }
                           
                            //to generate the google tag conversion of sigened in user
							              if (typeof gtagfucntion == 'function') {
                              gtagfucntion();
                            }

                          setTimeout(function () {
                            console.group('[facebookSignup]');
                            console.log(__flex_g_settings.user_show_quizz);
                            console.dir(response);
                            console.groupEnd('[facebookSignup]')

                             //if ( ("1" == __flex_g_settings.user_show_quizz) && ("signup" == response.logon_type) ) {
                            //if ( ("yes" == __flex_g_settings.has_facebook_login_enabled) && ("signup" == response.logon_type) ) {
                            if ("signup" == response.logon_type) {
                              // @todo open view
                              jQuery("#__quizz_type").val("facebook");
                              jQuery("#__quizz_type_phone_ct").show();
                              jQuery("#__quizz_cancel_on_fb").removeClass("ib-active");
                              jQuery("#__quizz_type_phone_ct").addClass("ib-active");
                              jQuery("#ib-push-registration-quizz-ct").addClass("ib-md-pa ib-md-active");
                              jQuery("#msboxinfo").remove();
                            }

                            var loadForm = jQuery(".iboost-form-validation-loaded");
                            if(loadForm.length){
                              jQuery(".iboost-form-validation-loaded").each(function () {
                                var id = jQuery(this).attr("data-id");
                                if(typeof id === "undefined" || id === "null" || id === ""){
                                  //console.log("No tiene valor");
                                }else{
                                  //console.log("id="+id);
                                  iti[id].setNumber(Cookies.get("_ib_user_new_phone_number"));
                                }
                              });
                            }

                          }, 3000);
                        } else {
                          var textmessage='';
                          if (response.message=='Invalid credentials, try again.') 
                            textmessage=word_translate.invalid_credentials_try_again;
                          else if (response.message=='Logged in succesfully.')
                            textmessage=word_translate.logged_in_succesfully;
                            sweetAlert(word_translate.oops, textmessage, "error");

                        }
                    }
                });
          });
      }
  }, { scope:"public_profile,email" });
}

function fb_logout() {
  FB.logout(function(response) {
      window.location.reload(false);
  });
}

(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) {
      return;
  }
  js = d.createElement(s);
  js.id = id;
  js.src = "//connect.facebook.net/en_US/sdk.js";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));
</script>
<?php endif; ?>

<div class="ib-modal-master modalReferentFUB" data-id="push-registration" id="ib-push-registration-quizz-ct">
  <div class="ib-mmcontent">
    <div class="ib-mwrapper ib-mgeneric">
      <div class="ib-mgcontent"> 
        <div id="ib-push-registration">
          <!--<button class="ms-skip ms-close ms-close-step" aria-label="Close"><span></span></button>-->
          <form id="ib-register-form-quizz" class="iboost-form-validation" method="post">
            <fieldset>
              <legend><?php echo __('Register', IDXBOOST_DOMAIN_THEME_LANG); ?></legend>
              <input type="hidden" name="action" value="ib_register_quizz_save">
              <input type="hidden" id="__quizz_type" name="__quizz_type" value="regular">
              <input type="hidden" class="ib_property_signup_price" name="__property_signup_price" value="">

              <ul class="ib-pr-steps-container">
                <li class="pr-step facebook-registration" id="__quizz_type_phone_ct" style="display: none; min-height: 380px">
                  <div class="ms-header-md">
                    <span class="ms-title-modal ms-no-mb"><?php echo __('Thank you for registering!', IDXBOOST_DOMAIN_THEME_LANG); ?></span>
                    <span class="ms-sub-title"><?php echo __('Use Phone Number For Password', IDXBOOST_DOMAIN_THEME_LANG); ?></span>
                  </div>

                  <div class="name-input-content">
                    <div class="wrapper-input">
                      <label class="agile-label" for="__signup_fb_phone">
                        <?php echo __('Phone number', IDXBOOST_DOMAIN_THEME_LANG); ?>
                        <span class="txtgray">(<?php echo __('Used as password', IDXBOOST_DOMAIN_THEME_LANG); ?>)</span>
                      </label>
                      <input id="__signup_fb_phone" name="register_phone_facebook" type="tel" class="agile-height-default phoneRegisterValidation" placeholder="<?php echo __('Phone number', IDXBOOST_DOMAIN_THEME_LANG); ?>" required value="">
                    </div>
                  </div>
                  <button class="pr-redbtn pr-populate-phone pr-registering" type="button"><?php echo __("I'm finished", IDXBOOST_DOMAIN_THEME_LANG); ?></button>
                    <!--<div class="ms-center">
                    <a href="javascript:void(0)" class="ms-skip"><?php echo __('Skip this step', IDXBOOST_DOMAIN_THEME_LANG); ?></a>
                  </div>-->
              </li>
              <li class="ib-pr-step ib-pr-radio ib-active" id="__quizz_cancel_on_fb">
                <div class="ms-header-md">
                  <span class="ms-title-modal ms-no-mb"><?php echo __("Thank You For Registering", IDXBOOST_DOMAIN_THEME_LANG); ?></span>
                  <div class="ms-text">
                  <p><?php echo __("Just a few more details so we can help you", IDXBOOST_DOMAIN_THEME_LANG); ?></p>
                  <p><?php echo __("(All fields are required)", IDXBOOST_DOMAIN_THEME_LANG); ?></p>
                  </div>
                  <div class="ms-icon ms-time"></div>
                  <span class="ms-sub-title ms-no-mb"><?php echo __("When are you looking to purchase?", IDXBOOST_DOMAIN_THEME_LANG); ?></span>
                </div>
                <ul class="ib-pr-radio-list">
                  <li>
                    <input class="ibregister-btn" id="inline_quizz_radios_1513789754550-0" type="radio" name="timeline_for_purchase" value="1_3_months">
                    <label class="i-checks ib-rquizz-step2" for="inline_quizz_radios_1513789754550-0"><?php echo __("Within 1-3 months", IDXBOOST_DOMAIN_THEME_LANG); ?></label>
                  </li>
                  <li>
                    <input class="ibregister-btn" id="inline_quizz_radios_1513789754550-1" type="radio" name="timeline_for_purchase" value="3_6_months">
                    <label class="i-checks ib-rquizz-step2" for="inline_quizz_radios_1513789754550-1"><?php echo __("Within 3-6 months", IDXBOOST_DOMAIN_THEME_LANG); ?></label>
                  </li>
                  <li>
                    <input class="ibregister-btn" id="inline_quizz_radios_1513789754550-2" type="radio" name="timeline_for_purchase" value="6_months_more">
                    <label class="i-checks ib-rquizz-step2" for="inline_quizz_radios_1513789754550-2"><?php echo __("More than 6 months", IDXBOOST_DOMAIN_THEME_LANG); ?></label>
                  </li>
                </ul>
                <!--<div class="ms-center">
                  <a href="javascript:void(0)" class="ms-skip ms-close-step skip-quizz-btn">Skip this step</a>
                </div>-->
              </li>
              <li class="ib-pr-step ib-pr-radio">
                <div class="ms-header-md">
                  <span class="ms-title-modal ms-no-mb"><?php echo __("Thank You For Registering", IDXBOOST_DOMAIN_THEME_LANG); ?></span>
                  <div class="ms-text">
                  <p><?php echo __("Just a few more details so we can help you", IDXBOOST_DOMAIN_THEME_LANG); ?></p>
                  <p><?php echo __("(All fields are required)", IDXBOOST_DOMAIN_THEME_LANG); ?></p>
                  </div>
                  <div class="ms-icon ms-financing"></div>
                  <span class="ms-sub-title ms-no-mb"><?php echo __("Need assistance with financing?", IDXBOOST_DOMAIN_THEME_LANG); ?></span>
                </div>
                <ul class="ib-pr-radio-list">
                  <li>
                    <input class="ibregister-btn" id="inline_quizz_radios_1513789825341-0" type="radio" name="mortgage_approved" value="yes">
                    <label class="i-checks ib-rquizz-step3" for="inline_quizz_radios_1513789825341-0"><?php echo __("I am pre-approved", IDXBOOST_DOMAIN_THEME_LANG); ?></label>
                  </li>
                  <li>
                    <input class="ibregister-btn" id="inline_quizz_radios_1513789825341-1" type="radio" name="mortgage_approved" value="no">
                    <label class="i-checks ib-rquizz-step3" for="inline_quizz_radios_1513789825341-1"><?php echo __("Not pre-approved yet", IDXBOOST_DOMAIN_THEME_LANG); ?></label>
                  </li>
                  <li>
                    <input class="ibregister-btn" id="inline_quizz_radios_1513789825341-2" type="radio" name="mortgage_approved" value="buying_with_cash">
                    <label class="i-checks ib-rquizz-step3" for="inline_quizz_radios_1513789825341-2"><?php echo __("I prefer to buy with cash", IDXBOOST_DOMAIN_THEME_LANG); ?></label>
                  </li>
                </ul>
                <!--<div class="ms-center">
                  <a href="javascript:void(0)" class="ms-skip ms-close-step skip-quizz-btn">Skip this step</a>
                </div>-->
              </li>
              <li class="ib-pr-step ib-pr-radio">
                <div class="ms-header-md">
                  <span class="ms-title-modal ms-no-mb"><?php echo __("Thank You For Registering", IDXBOOST_DOMAIN_THEME_LANG); ?></span>
                  <div class="ms-text">
                  <p><?php echo __("Just a few more details so we can help you", IDXBOOST_DOMAIN_THEME_LANG); ?></p>
                  <p><?php echo __("(All fields are required)", IDXBOOST_DOMAIN_THEME_LANG); ?></p>
                  </div>
                  <div class="ms-icon ms-sale"></div>
                  <span class="ms-sub-title ms-no-mb"><?php echo __("Need to also sell your property?", IDXBOOST_DOMAIN_THEME_LANG); ?></span>
                </div>
                <ul class="ib-pr-radio-list">
                  <li>
                    <input id="inline_quizz_radios_15137898580630-0" type="radio" name="sell_a_home" value="yes">
                    <label class="ibregister-tg-submit-quizz" for="inline_quizz_radios_15137898580630-0"><?php echo __("Looking to sell too", IDXBOOST_DOMAIN_THEME_LANG); ?></label>
                  </li>
                  <li>
                    <input id="inline_quizz_radios_15137898580631-1" type="radio" name="sell_a_home" value="no">
                    <label class="ibregister-tg-submit-quizz" for="inline_quizz_radios_15137898580631-1"><?php echo __("Not looking to sell", IDXBOOST_DOMAIN_THEME_LANG); ?></label>
                  </li>
                  <li>
                    <input id="inline_quizz_radios_15137898580632-2" type="radio" name="sell_a_home" value="not_sure_yet">
                    <label class="ibregister-tg-submit-quizz" for="inline_quizz_radios_15137898580632-2"><?php echo __("Not sure yet", IDXBOOST_DOMAIN_THEME_LANG); ?></label>
                  </li>
                </ul>
                <!--<div class="ms-center">
                  <a href="javascript:void(0)" class="ms-skip ms-close-step skip-quizz-btn">Skip this step</a>
                </div>-->
              </li>
            </ul>
            <span class="agile-error-msg"></span>
		        </fieldset>
          </form>
          <div class="footer_md terms-md" style="position: relative !important;text-align: left;font-size: 11px !important;">
            <?php if (($idxboost_agent_info["show_opt_in_message"])){  ?>
              <div class="ms-fub-register">
                <div class="ms-flex-chk-ub">
                  <div class="ms-item-chk">
                    <input type="checkbox" id="follow_up_boss_valid_register_" class="follow_up_boss_valid_register" required <?php echo $checked; ?>>
                    <label for="follow_up_boss_valid_register_" aria-label="Follow Up Boss"></label>
                  </div>
                  <div class="ms-fub-disclaimer">
                    <p><?php echo $flex_idx_info['agent']['disclaimer_fub']; ?></p>
                  </div>
                </div>
              </div>
            <?php }else{ ?>
            
              <div class="ms-footer-sm">
                <p><?php echo __("In agreement with our", IDXBOOST_DOMAIN_THEME_LANG); ?> 
                <a rel="nofollow" target="_blank" href="/terms-and-conditions/" title="<?php echo __("Terms of Use", IDXBOOST_DOMAIN_THEME_LANG); ?> (Opens a new window)">
                  <?php echo __("Terms of Use", IDXBOOST_DOMAIN_THEME_LANG); ?>
                </a> 
                <span><?php echo __("and", IDXBOOST_DOMAIN_THEME_LANG); ?> <a href="/terms-and-conditions/#atospp-privacy"><?php echo __("Privacy Policy", IDXBOOST_DOMAIN_THEME_LANG); ?></a></span></p>
              </div>
            <?php } ?>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="ib-mmbg"></div>
</div>

<script>
(function ($) {
var ib_register_form_quizz;

$(function() {

  $(document).on('click', '.social_login_btn_temporal', function () {
    $("#formRegister").submit();
  });

  ib_register_form_quizz = jQuery("#ib-register-form-quizz");

  if (ib_register_form_quizz.length) {
    ib_register_form_quizz.on("submit", function(event) {
      event.preventDefault();

      //REGISTRO RS
      var dataForm = $(this).serialize();
      console.log(dataForm);

      if(Cookies.get("social_register") == "activo"){

        Cookies.remove("_ib_user_phone");
        Cookies.remove("_ib_user_code_phone");
        Cookies.remove("_ib_user_new_phone_number");

        var codePhone = jQuery("#ib-register-form-quizz").find(".country_code").val();
        var codePhoneClean = codePhone.replace(/ /g, "");
        var numberPhone = jQuery("#ib-register-form-quizz").find("#__signup_fb_phone").val();
        var numberPhoneClean = numberPhone.replace(/ /g, "");
        var phoneRegisterQuizz = codePhoneClean.trim()+numberPhoneClean.trim();

        Cookies.set("_ib_user_phone", numberPhoneClean.trim());
        Cookies.set("_ib_user_code_phone", codePhoneClean.trim());
        Cookies.set("_ib_user_new_phone_number", phoneRegisterQuizz);

        var loadForm = jQuery(".iboost-form-validation-loaded");
        if(loadForm.length){
          jQuery(".iboost-form-validation-loaded").each(function () {
            var id = jQuery(this).attr("data-id");
            if(typeof id === "undefined" || id === "null" || id === ""){
              //console.log("No tiene valor");
            }else{
              //console.log("id="+id);
              iti[id].setNumber(Cookies.get("_ib_user_new_phone_number"));
            }
          });
        }

        var ob_form_building_footer;
        ob_form_building_footer = jQuery('.flex_idx_building_form');
        if (ob_form_building_footer.length>0){
          ob_form_building_footer.find('input[name="phone"]').val(numberPhoneClean);
          ob_form_building_footer.find('input[name="phoneCodeValidation"]').val(Cookies.get("_ib_user_code_phone"));
        }
        
        /*var ob_form_regular_contact_form;
        ob_form_regular_contact_form = jQuery('#flex_idx_contact_form');
        if (ob_form_regular_contact_form.length>0){
          ob_form_modal.find('input[name="phone_number"]').val(numberPhoneClean);
          ob_form_modal.find('input[name="phoneCodeValidation"]').val(Cookies.get("_ib_user_code_phone"));
        }*/

        var ob_form_off_market_listing;
        ob_form_off_market_listing = jQuery('#flex-idx-property-form');
        if (ob_form_off_market_listing.length>0){
          ob_form_off_market_listing.find('input[name="phone"]').val(numberPhoneClean);
          ob_form_off_market_listing.find('input[name="phoneCodeValidation"]').val(Cookies.get("_ib_user_code_phone"));
        }

        var ob_form_modal;
        ob_form_modal = jQuery('.ib-propery-inquiry-f');
        if (ob_form_modal.length>0){
          ob_form_modal.find('input[name="phone_number"]').val(numberPhoneClean);
          ob_form_modal.find('input[name="phoneCodeValidation"]').val(Cookies.get("_ib_user_code_phone"));
        }

        var ob_contact_form;
        ob_contact_form = jQuery('#ip-form');
        if (ob_contact_form.length>0){
          ob_contact_form.find('input[name="phone"]').val(numberPhoneClean);
          ob_contact_form.find('input[name="phoneCodeValidation"]').val(Cookies.get("_ib_user_code_phone"));
        }

        //Property form react Vacation Rentals
        var ob_property_form_vacation_rentals;
        ob_property_form_vacation_rentals=$('#propertyForm');
        if (ob_property_form_vacation_rentals.length>0){
          ob_property_form_vacation_rentals.find('input[name="firstName"]').val(Cookies.get("_ib_user_firstname"));
          ob_property_form_vacation_rentals.find('input[name="lastName"]').val(Cookies.get("_ib_user_lastname"));
          ob_property_form_vacation_rentals.find('input[name="email"]').val(Cookies.get("_ib_user_email"));
          ob_property_form_vacation_rentals.find('input[name="phone"]').val(numberPhoneClean);
          ob_property_form_vacation_rentals.find('input[name="phoneCodeValidation"]').val(Cookies.get("_ib_user_code_phone"));
        }

        var ob_form_regular_contact_form;
        ob_form_regular_contact_form = jQuery('#flex_idx_contact_form');
        if (ob_form_regular_contact_form.length>0){
          ob_form_regular_contact_form.find('[name="name"]').val(Cookies.get("_ib_user_firstname"));
          ob_form_regular_contact_form.find('[name="lastname"]').val(Cookies.get("_ib_user_lastname"));
          ob_form_regular_contact_form.find('[name="email"]').val(Cookies.get("_ib_user_email"));
          ob_form_regular_contact_form.find('[name="phone_number"]').val(numberPhoneClean);
          ob_form_regular_contact_form.find('[name="phoneCodeValidation"]').val(Cookies.get("_ib_user_code_phone"));
        }
      }

      $.ajax({
        url: __flex_g_settings.ajaxUrl,
        method: "POST",
        data: dataForm,
        dataType: "json",
        success: function(data) {
        }
      });

    });

    ib_register_form_quizz.on("click", "label", function() {
      if ($(this).hasClass("ib-rquizz-step2")) {
        // show step 2
        ib_register_form_quizz.find(".ib-pr-step").removeClass("ib-active");
        ib_register_form_quizz.find(".ib-pr-step:eq(1)").addClass("ib-active");
      }

      if ($(this).hasClass("ib-rquizz-step3")) {
        // show step 3
        ib_register_form_quizz.find(".ib-pr-step").removeClass("ib-active");
        ib_register_form_quizz.find(".ib-pr-step:eq(2)").addClass("ib-active");
      }

      if ($(this).hasClass("ibregister-tg-submit-quizz")) {
        // submit the form

        var parentId = jQuery("#"+ib_register_form_quizz.parents(".modalReferentFUB").attr("id"));
        var fub_chk = parentId.find(jQuery(".follow_up_boss_valid_register"));

        if(fub_chk.length){

          if(!fub_chk.prop('checked')){

            alert("You must accept the terms and conditions, and the privacy policy to continue");
            fub_chk.addClass("error");
            return;

          }else{

            setTimeout(function () {
              ib_register_form_quizz.trigger("submit");
              $("#ib-push-registration-quizz-ct").removeClass("ib-md-pa ib-md-active");
              swal(word_translate.thank_you, word_translate.your_info_has_been_saved, "success");
            }, 100);

          }

        }else{

          setTimeout(function () {
            ib_register_form_quizz.trigger("submit");
            $("#ib-push-registration-quizz-ct").removeClass("ib-md-pa ib-md-active");
            swal(word_translate.thank_you, word_translate.your_info_has_been_saved, "success");
          }, 100);

        }

        
      }
    });
  }

  if (typeof ib_register_form_quizz !== "undefined") {
    $(".skip-quizz-btn").one("click", function() {
      setTimeout(function () {
        ib_register_form_quizz.submit();
      }, 300);
    });
  }

  $(document).on('click', '.ms-tab', function () {
    var dataTab = $(this).attr('data-tab');
    var titleText = $(this).attr('data-text');

    $(".header-tab a[data-tab='"+dataTab+"']").trigger("click");

    if ($('#modal_login .email-registration').hasClass('active') || $('#modal_login .pr-radio').hasClass('active')){
      $("#modal_login .content_md").addClass('ms-hidden-extras');
    }

    if(dataTab == "tabReset"){
      $("#modal_login .content_md").removeClass('ms-hidden-extras');
    }

    if(dataTab == "tabLogin"){
      $("#modal_login .modal_cm .content_md .heder_md .ms-title-modal").html(titleText);
      $("#socialMediaRegister").removeClass("disabled");
      

    }else if(dataTab == "tabRegister"){
      $("#modal_login .modal_cm .content_md .heder_md .ms-title-modal").html(titleText);

      if ($('#follow_up_boss_valid_register').is(':checked')) {
        $("#socialMediaRegister").removeClass("disabled");
      }else{
        $("#socialMediaRegister").addClass("disabled");
      }

    }else if(dataTab == "tabReset"){
      $("#modal_login .modal_cm .content_md .heder_md .ms-title-modal").html(titleText);

      if ($('follow_up_boss_valid_register').is(':checked')) {
        $("#socialMediaRegister").removeClass("disabled");
      }else{
        $("#socialMediaRegister").addClass("disabled");
      }
    }

  });

  $(document).on('click', '.ms-icon-back', function () {
    $(".header-tab a[data-tab='tabLogin']").trigger("click");
    $("#modal_login .content_md").removeClass('ms-hidden-extras');
    $("#socialMediaRegister").removeClass("disabled");

    var titleText = $(".header-tab a[data-tab='tabLogin']").attr('data-text')
    $("#modal_login .modal_cm .content_md .heder_md .ms-title-modal").html(titleText);

    jQuery(".ms-fub-register").addClass("hidden");
		jQuery(".ms-footer-sm").removeClass("hidden");
  });

})
})(jQuery);
</script>

<script>
(function ($) {

$(function() {
  $(".formRegister_windowWidth").val(window.innerWidth);
});

})(jQuery);
</script>

<script>
(function ($) {

var schedule_form;

$(function() {
  // datepicker for schedule form
  var dateToday = new Date();
  $("#ss_preferred_date").datepicker({
    minDate: dateToday,
    beforeShow:function(){
      $("#ss_preferred_date").parent().append($('#ui-datepicker-div'));
    }
  });
  
  // handle submission for schedule form
  schedule_form = $("#form-scheduled");

  if (schedule_form.length) {
    schedule_form.on("submit", function(event) {
      event.preventDefault();

      var _self = $(this);
      var form_data = _self.serialize();

      $.ajax({
        url: __flex_g_settings.ajaxUrl,
        method: "POST",
        data: form_data,
        dataType: "json",
        success: function (data) {
          _self.trigger("reset");
          $('.close-modal').click();

          active_modal($("#modal_properties_send"));
          setTimeout(function () {
            $('.close-modal').click();
          }, 1000);
        }
      });
    });
  }
});

})(jQuery);
</script>

<style type="text/css">
.smart-alert-disabled .ib-modal-master .ib-msavesearch .ib-mssitem,
.smart-alert-disabled #modal_save_search #form-save .gform_fields .gfield
{
  display: none;
}
.smart-alert-disabled .ib-modal-master .ib-msavesearch .ib-mssitem:first-child,
.smart-alert-disabled #modal_save_search #form-save .gform_fields .gfield:first-child
{
  display: block;
}

</style>

<script type="text/javascript">
  jQuery(document).ready(function(){
    jQuery("#msSmartAlertText").html(jQuery("#msSmartAlertText").attr("data-text-default")+".");
    <?php if($has_smart_property_alerts == false){ ?>  
      jQuery("body").addClass("smart-alert-disabled");
      jQuery("#msSmartAlertText").html(jQuery("#msSmartAlertText").attr("data-text-alert")+".");    
    <?php } ?>  
  });
</script>

<script id="ib-template-property-sale-rent-sold" type="text/x-handlebars-template">
{{#properties}}

<li data-geocode="{{lat}}:{{lng}}" data-class-id="{{class_id}}" data-mls="{{mls_num}}" data-address="{{address_short}}" class="propertie">
  {{{DFhandleStatusProperty this }}}
  {{{DFhandleTypeView this }}}

  <ul class="features">
    <li class="address">{{{DFhandleFormatAddress this}}}</li>
      
      <?php if( $idx_v == "1" ) {  ?>
        {{#if ../is_sold}}
          <li class="price">{{DFformatPrice price_sold}} {{DFrentalType is_rental status }}</li>
        {{else}}
          <li class="price">{{DFformatPrice price}} {{DFrentalType is_rental status }}</li>
        {{/if}}
      <?php }else{ ?>
        <li class="price">{{DFformatPrice price}} {{DFrentalType is_rental status }}</li>
      <?php } ?>
    
    {{{DFidxReduced reduced}}}
    <li class="beds">{{bed}} <?php echo __('beds', IDXBOOST_DOMAIN_THEME_LANG); ?><span></span></li>
    <li class="baths">{{bath}} {{DFformatBathsHalf baths_half}} <span><?php echo __('baths', IDXBOOST_DOMAIN_THEME_LANG); ?> </span></li>
    <li class="living-size"> <span>{{DFformatSqft sqft}} <?php echo __("Sq.Ft.", IDXBOOST_DOMAIN_THEME_LANG); ?></li>
    <li class="price-sf"><span>{{DFformatPrice price_sqft}} </span>/ <?php echo __("Sq.Ft.", IDXBOOST_DOMAIN_THEME_LANG); ?> </li>

    {{{DFhandleDevelopment this}}}

  </ul>

  {{{DFidxGalleryImages this}}}
  <a href="{{DFidxPermalink slug}}" class="view-detail"> {{DFhandleFormatAddress this}}</a>
  <a class="view-map-detail" data-geocode="{{lat}}:{{lng}}">View Map</a>
  {{{DFhandleOhContent this}}}
</li>
{{/properties}}
</script>

<script id="ib-template-property" type="text/x-handlebars-template">
{{#properties}}

<li data-geocode="{{lat}}:{{lng}}" data-class-id="{{class_id}}" data-mls="{{mls_num}}" data-address="{{address_short}}" class="propertie">
  {{{DFhandleStatusProperty this }}}
  {{{DFhandleTypeView this }}}

  <ul class="features">
    <li class="address">{{{DFhandleFormatAddress this}}}</li>
    <li class="price">{{DFformatPrice price}} {{DFrentalType is_rental}}</li>
    <li class="beds">{{class_name}} <span></span></li>
    <li class="living-size"> <span>{{DFformatSqft lot_size}} </span><?php echo __('sqft', IDXBOOST_DOMAIN_THEME_LANG); ?> <span>({{DFformatSqft living_size_m2}} m²)</span></li>
  </ul>

  {{{DFidxGalleryImages this}}}
  <a href="{{DFidxPermalink slug}}" class="view-detail"> {{DFhandleFormatAddress this}}</a>
  <a class="view-map-detail" data-geocode="{{lat}}:{{lng}}">View Map</a>
  {{{DFhandleOhContent this}}}
</li>
{{/properties}}
</script>

<script id="ib-template-display-pagination" type="text/x-handlebars-template">
{{#pagination}}
  <span id="indicator"><?php echo __('Page', IDXBOOST_DOMAIN_THEME_LANG); ?> {{current_page_number}} <?php echo __('of', IDXBOOST_DOMAIN_THEME_LANG); ?> {{total_pages_count }}</span>
  {{{paginationBlock this}}}
{{/pagination}}
</script>
