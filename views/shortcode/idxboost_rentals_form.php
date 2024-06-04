<?php global $flex_idx_info; 
$idxboost_term_condition = get_option('idxboost_term_condition');
$idxboost_agent_info = get_option('idxboost_agent_info');

$disclaimer_checked = $flex_idx_info['agent']['disclaimer_checked'];
if($disclaimer_checked == "1"){
  $checked = "checked"; 
}else{
  $checked = ""; 
}
?>
<article class="ib-form-buyandsell">
  <img class="ib-form-bg" src="/" alt="<?php echo __("What are you looking to rent?", IDXBOOST_DOMAIN_THEME_LANG); ?>">
  
  <form class="ib-fbscontainer gtm_i_want_to_rent iboost-secured-recaptcha-form iboost-form-validation" method="post" id="lead_submission_rent_form">
    <fieldset>
      <legend>
        <?php echo __("What are you looking to rent?", IDXBOOST_DOMAIN_THEME_LANG); ?>
      </legend>

      <?php if (!empty($atts['registration_key'])): ?>
        <input type="hidden" name="registration_key" value="<?php echo $atts['registration_key']; ?>">
      <?php endif; ?> 
    
      <input type="hidden" name="ib_tags" value="">
      <input type="hidden" name="action" value="lead_submission_rent">
    
      <?php if (array_key_exists('google_gtm', $flex_idx_info['agent']) && !empty($flex_idx_info['agent']['google_gtm'])) : ?>
        <input type="hidden" name="gclid_field" id="gclid_field_form_lead_submission_rent">
      <?php endif; ?>
    
      <div class="ib-form-wrapper">
        
        <ul class="ib-fsteps">
          
          <li class="ib-fsitem ib-fsitem-active">
            <h1 class="ib-fstitle">
              <?php echo __("What are you looking to rent?", IDXBOOST_DOMAIN_THEME_LANG); ?>
            </h1>
            <ul class="ib-fsradios">
              <li class="ib-fsritem">
                <input class="ib-firadio" type="radio" value="Condo" id="ib-form-condo" name="ib-ftobuy">
                <label class="ib-filabel" for="ib-form-condo"><?php echo __("Condo", IDXBOOST_DOMAIN_THEME_LANG); ?></label>
              </li>
              <li class="ib-fsritem">
                <input class="ib-firadio" type="radio" value="Single Family Home" id="ib-form-family" name="ib-ftobuy">
                <label class="ib-filabel" for="ib-form-family"><?php echo __("Single Family Home", IDXBOOST_DOMAIN_THEME_LANG); ?></label>
              </li>
              <li class="ib-fsritem">
                <input class="ib-firadio" type="radio" value="Townhouse" id="ib-form-townhouse" name="ib-ftobuy">
                <label class="ib-filabel" for="ib-form-townhouse"><?php echo __("Townhouse", IDXBOOST_DOMAIN_THEME_LANG); ?></label>
              </li>
            </ul>
          </li>
          
          <li class="ib-fsitem">
            <h4 class="ib-fstitle">
              <?php echo __("What’s your price range?", IDXBOOST_DOMAIN_THEME_LANG); ?>
            </h4>
            <ul class="ib-fsradios">
              <li class="ib-fsritem">
                <input class="ib-firadio" type="radio" value="Below $5K" id="ib-form-bellow" name="ib-fprice">
                <label class="ib-filabel" for="ib-form-bellow"><?php echo __("Below $5K", IDXBOOST_DOMAIN_THEME_LANG); ?></label>
              </li>
              <li class="ib-fsritem">
                <input class="ib-firadio" type="radio" value="$5K to $10K" id="ib-form-onetwo" name="ib-fprice">
                <label class="ib-filabel" for="ib-form-onetwo"><?php echo __("$5K to $10k", IDXBOOST_DOMAIN_THEME_LANG); ?></label>
              </li>
              <li class="ib-fsritem">
                <input class="ib-firadio" type="radio" value="$10K to $15K" id="ib-form-threefive" name="ib-fprice">
                <label class="ib-filabel" for="ib-form-threefive"><?php echo __("$10K to $15K", IDXBOOST_DOMAIN_THEME_LANG); ?></label>
              </li>
              <li class="ib-fsritem">
                <input class="ib-firadio" type="radio" value="$15K+" id="ib-form-morefive" name="ib-fprice">
                <label class="ib-filabel" for="ib-form-morefive"><?php echo __("$15K+", IDXBOOST_DOMAIN_THEME_LANG); ?></label>
              </li>
            </ul>
          </li>
          
          <li class="ib-fsitem">
            <h4 class="ib-fstitle">
              <?php echo __("How many bedrooms?", IDXBOOST_DOMAIN_THEME_LANG); ?>
            </h4>
            <ul class="ib-fsradios ib-fsrnumbers">
              <li class="ib-fsritem">
                <input class="ib-firadio" type="radio" value="1" id="ib-form-onebeds" name="ib-fbedrooms">
                <label class="ib-filabel" for="ib-form-onebeds">1</label>
              </li>
              <li class="ib-fsritem">
                <input class="ib-firadio" type="radio" value="2" id="ib-form-twobeds" name="ib-fbedrooms">
                <label class="ib-filabel" for="ib-form-twobeds">2</label>
              </li>
              <li class="ib-fsritem">
                <input class="ib-firadio" type="radio" value="3" id="ib-form-threebeds" name="ib-fbedrooms">
                <label class="ib-filabel" for="ib-form-threebeds">3</label>
              </li>
              <li class="ib-fsritem">
                <input class="ib-firadio" type="radio" value="4+" id="ib-form-morefourbeds" name="ib-fbedrooms">
                <label class="ib-filabel" for="ib-form-morefourbeds">4+</label>
              </li>
            </ul>
          </li>
          
          <li class="ib-fsitem">
            <h4 class="ib-fstitle">
              <?php echo __("How many bathrooms?", IDXBOOST_DOMAIN_THEME_LANG); ?>
            </h4>
            <ul class="ib-fsradios ib-fsrnumbers">
              <li class="ib-fsritem">
                <input class="ib-firadio" type="radio" value="1" id="ib-form-onebaths" name="ib-fbathsrooms">
                <label class="ib-filabel" for="ib-form-onebaths">1</label>
              </li>
              <li class="ib-fsritem">
                <input class="ib-firadio" type="radio" value="2" id="ib-form-twobaths" name="ib-fbathsrooms">
                <label class="ib-filabel" for="ib-form-twobaths">2</label>
              </li>
              <li class="ib-fsritem">
                <input class="ib-firadio" type="radio" value="3" id="ib-form-threebaths" name="ib-fbathsrooms">
                <label class="ib-filabel" for="ib-form-threebaths">3</label>
              </li>
              <li class="ib-fsritem">
                <input class="ib-firadio" type="radio" value="4+" id="ib-form-morefourbaths" name="ib-fbathsrooms">
                <label class="ib-filabel" for="ib-form-morefourbaths">4+</label>
              </li>
            </ul>
          </li>
          
          <li class="ib-fsitem">
            <h4 class="ib-fstitle">
              <?php echo __("Timeline to rent", IDXBOOST_DOMAIN_THEME_LANG); ?>
            </h4>
            <ul class="ib-fsradios">
              <li class="ib-fsritem">
                <input class="ib-firadio" type="radio" value="Now" id="ib-form-now" name="ib-ftimepurchase">
                <label class="ib-filabel" for="ib-form-now"><?php echo __("Now", IDXBOOST_DOMAIN_THEME_LANG); ?></label>
              </li>
              <li class="ib-fsritem">
                <input class="ib-firadio" type="radio" value="Soon" id="ib-form-soon" name="ib-ftimepurchase">
                <label class="ib-filabel" for="ib-form-soon"><?php echo __("Soon", IDXBOOST_DOMAIN_THEME_LANG); ?></label>
              </li>
              <li class="ib-fsritem">
                <input class="ib-firadio" type="radio" value="Later" id="ib-form-later" name="ib-ftimepurchase">
                <label class="ib-filabel" for="ib-form-later"><?php echo __("Later", IDXBOOST_DOMAIN_THEME_LANG); ?></label>
              </li>
            </ul>
          </li>
          
          <li class="ib-fsitem">
            <h4 class="ib-fstitle">
              <?php echo __("Contact Information", IDXBOOST_DOMAIN_THEME_LANG); ?>
            </h4>
            <span class="ib-ftext">
              <?php echo __("Please provide your contact information below and we will be in touch very soon!", IDXBOOST_DOMAIN_THEME_LANG); ?>
            </span>
            <ul class="ib-fsinformation">
              <li class="ib-fsftem">
                <label for="ms-fsinput-email" class="ms-hidden"><?php echo __("Email*", IDXBOOST_DOMAIN_THEME_LANG); ?></label>
                <input required class="ib-fsinput" type="email" name="email" placeholder="<?php echo __("Email*", IDXBOOST_DOMAIN_THEME_LANG); ?>" id="ms-fsinput-email">
              </li>
              <li class="ib-fsftem">
                <label for="ms-fsinput-name" class="ms-hidden"><?php echo __("Name*", IDXBOOST_DOMAIN_THEME_LANG); ?></label>
                <input required class="ib-fsinput" type="text" name="name" placeholder="<?php echo __("Name*", IDXBOOST_DOMAIN_THEME_LANG); ?>" id="ms-fsinput-name">
              </li>
              <li class="ib-fsftem">
                <label for="ms-fsinput-phone" class="ms-hidden"><?php echo __("Phone*", IDXBOOST_DOMAIN_THEME_LANG); ?></label>
                <input required class="ib-fsinput" type="tel" name="phone" placeholder="<?php echo __("Phone*", IDXBOOST_DOMAIN_THEME_LANG); ?>" id="ms-fsinput-phone">
              </li>
              <li class="ib-fsftem ib-fsftem-textarea">
                <label for="ms-fsinput-comments" class="ms-hidden"><?php echo __("Comment", IDXBOOST_DOMAIN_THEME_LANG); ?></label>
                <textarea class="ib-fstextarea" placeholder="<?php echo __("Comment", IDXBOOST_DOMAIN_THEME_LANG); ?>" name="comments" id="ms-fsinput-comments"></textarea>
              </li>
              <?php if ( ($idxboost_agent_info["show_opt_in_message"]) ) {  ?>
              <li class="gfield fub">
                <div class="ms-flex-chk-ub">
                  <div class="ms-item-chk">
                    <input type="checkbox" id="follow_up_boss_valid" required <?php echo $checked; ?>>
                    <label for="follow_up_boss_valid">Follow Up Boss</label>
                  </div>
                  <div class="ms-fub-disclaimer">
                    <p><?php echo __("By submitting this form you agree to be contacted by", IDXBOOST_DOMAIN_THEME_LANG); ?> <?php echo $idxboost_term_condition["company_name"]; ?> <?php echo __('via call, email, and text. To opt out, you can reply "stop" at any time or click the unsubscribe link in the emails. For more information see our', IDXBOOST_DOMAIN_THEME_LANG); ?> <a href="/terms-and-conditions/#follow-up-boss" target="_blank"><?php echo __("Terms and Conditions", IDXBOOST_DOMAIN_THEME_LANG); ?></a> <?php echo __("and", IDXBOOST_DOMAIN_THEME_LANG); ?> <a href="/terms-and-conditions/#atospp-privacy"><?php echo __("Privacy Policy", IDXBOOST_DOMAIN_THEME_LANG); ?></a></p>
                  </div>
                </div>
              </li>
              <?php } ?>
            </ul>
          </li>
        </ul>
        
        <div class="ib-fbtns ib-fbtns-continue">
          <div class="ib-fbtn-continue ib-fbtn ib-fbtn-fnext">
            <?php echo __("Continue", IDXBOOST_DOMAIN_THEME_LANG); ?>
          </div>
          <div class="ib-fbtn-back ib-fbtn">
            <?php echo __("Back", IDXBOOST_DOMAIN_THEME_LANG); ?>
          </div>
          <div class="ib-fbtn-next ib-fbtn ib-fbtn-fnext">
            <?php echo __("Next", IDXBOOST_DOMAIN_THEME_LANG); ?>
          </div>
          <input class="ib-fsubmit ib-fbtn" id="lead_submission_rent_submit" type="submit" 
            value="<?php echo __("Submit", IDXBOOST_DOMAIN_THEME_LANG); ?>">
        </div>
      
      </div>
    </fieldset>
  </form>
</article>
