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
  <img class="ib-form-bg" src="/" alt="<?php echo __("What's Your Home Worth?", IDXBOOST_DOMAIN_THEME_LANG); ?>">
  
  <form class="ib-fbscontainer gtm_i_want_to_sell iboost-secured-recaptcha-form iboost-form-validation" method="post" id="lead_submission_sell_form">
    <fieldset>
      <legend>
        <?php echo __("What's Your Home Worth?", IDXBOOST_DOMAIN_THEME_LANG); ?>
      </legend>

      <?php if (!empty($atts['registration_key'])): ?>
        <input type="hidden" name="registration_key" value="<?php echo $atts['registration_key']; ?>">
      <?php endif; ?>
      
      <input type="hidden" name="ib_tags" value="">
      <input type="hidden" name="action" value="lead_submission_sell">
  
      <?php if (array_key_exists('google_gtm', $flex_idx_info['agent']) && !empty($flex_idx_info['agent']['google_gtm'])) : ?>
        <input type="hidden" name="gclid_field" id="gclid_field_form_lead_submission_sell">
      <?php endif; ?>
  
      <div class="ib-form-wrapper">

        <ul class="ib-fsteps">
          
          <li class="ib-fsitem ib-fsitem-active">
            <h1 class="ib-fstitle">
              <?php echo __("What's Your Home Worth?", IDXBOOST_DOMAIN_THEME_LANG); ?>
            </h1>
            <span class="ib-ftext">
              <?php echo __("Please fill out your address below to receive a", IDXBOOST_DOMAIN_THEME_LANG); ?><br>
              <?php echo __("complimentary market analysis from one of our experts!", IDXBOOST_DOMAIN_THEME_LANG); ?>
            </span>
            <div class="ib-fsifind">
              <label for="lead_address_acgoogle" class="ms-hidden">
                <?php echo __("Enter your address here", IDXBOOST_DOMAIN_THEME_LANG); ?>
              </label>
              <input autocorrect="off" autocapitalize="off" spellcheck="false" autocomplete="disabled" 
                class="ib-fsinput" name="address" type="text" id="lead_address_acgoogle" 
                placeholder="<?php echo __("Enter your address here", IDXBOOST_DOMAIN_THEME_LANG); ?>" value="">
              <div class="ib-fsifsubmit ib-fbtn-fnext">
                <?php echo __("Find out now", IDXBOOST_DOMAIN_THEME_LANG); ?>
              </div>
            </div>
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
              <?php echo __("Planning Stages", IDXBOOST_DOMAIN_THEME_LANG); ?>
            </h4>
            <ul class="ib-fsradios">
              <li class="ib-fsritem">
                <input class="ib-firadio" type="radio" value="I'm Ready" id="ib-form-imready" name="ib-fplanning">
                <label class="ib-filabel" for="ib-form-imready"><?php echo __("I&#039m Ready", IDXBOOST_DOMAIN_THEME_LANG); ?></label>
              </li>
              <li class="ib-fsritem">
                <input class="ib-firadio" type="radio" value="Almost There" id="ib-form-soon" name="ib-fplanning">
                <label class="ib-filabel" for="ib-form-soon"><?php echo __("Almost There", IDXBOOST_DOMAIN_THEME_LANG); ?></label>
              </li>
              <li class="ib-fsritem">
                <input class="ib-firadio" type="radio" value="Flexible" id="ib-form-flexible" name="ib-fplanning">
                <label class="ib-filabel" for="ib-form-flexible"><?php echo __("Flexible", IDXBOOST_DOMAIN_THEME_LANG); ?></label>
              </li>
              <li class="ib-fsritem">
                <input class="ib-firadio" type="radio" value="Planning Stages" id="ib-form-later" name="ib-fplanning">
                <label class="ib-filabel" for="ib-form-later"><?php echo __("Planning Stages", IDXBOOST_DOMAIN_THEME_LANG); ?></label>
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
                <label for="ms-email-fsftem" class="ms-hidden"><?php echo __("Email*", IDXBOOST_DOMAIN_THEME_LANG); ?></label>
                <input required class="ib-fsinput" type="email" name="email" placeholder="<?php echo __("Email*", IDXBOOST_DOMAIN_THEME_LANG); ?>" id="ms-email-fsftem">
              </li>
              <li class="ib-fsftem">
                <label for="ms-name-fsftem" class="ms-hidden"><?php echo __("Name*", IDXBOOST_DOMAIN_THEME_LANG); ?></label>
                <input required class="ib-fsinput" type="text" name="name" placeholder="<?php echo __("Name*", IDXBOOST_DOMAIN_THEME_LANG); ?>" id="ms-name-fsftem">
              </li>
              <li class="ib-fsftem">
                <label for="ms-phone-fsftem" class="ms-hidden"><?php echo __("Phone*", IDXBOOST_DOMAIN_THEME_LANG); ?></label>
                <input required class="ib-fsinput" type="tel" name="phone" placeholder="<?php echo __("Phone*", IDXBOOST_DOMAIN_THEME_LANG); ?>" id="ms-phone-fsftem">
              </li>
              <li class="ib-fsftem ib-fsftem-textarea">
                <label for="ms-comments-fsftem" class="ms-hidden"><?php echo __("Comments", IDXBOOST_DOMAIN_THEME_LANG); ?></label>
                <textarea class="ib-fstextarea" placeholder="<?php echo __("Comments", IDXBOOST_DOMAIN_THEME_LANG); ?>" name="comments" id="ms-comments-fsftem"></textarea>
              </li>
              <?php if ( ($idxboost_agent_info["show_opt_in_message"]) ) {  ?>
              <li class="gfield fub">
                <div class="ms-flex-chk-ub">
                  <?php 
                    //$follow_up_boss_api_key = $flex_idx_info['agent']['follow_up_boss_api_key'];
                    //if(!empty($follow_up_boss_api_key)){
                  ?>
                  <div class="ms-item-chk">
                    <input type="checkbox" id="follow_up_boss_valid" required <?php echo $checked; ?>>
                    <label for="follow_up_boss_valid">Follow Up Boss</label>
                  </div>
                  <?php //} ?>
                  <div class="ms-fub-disclaimer">
                    <p><?php echo __("By submitting this form you agree to be contacted by", IDXBOOST_DOMAIN_THEME_LANG); ?> <?php echo $idxboost_term_condition["company_name"]; ?> <?php echo __('via call, email, and text. To opt out, you can reply "stop" at any time or click the unsubscribe link in the emails. For more information see our', IDXBOOST_DOMAIN_THEME_LANG); ?> <a href="/terms-and-conditions/#follow-up-boss" target="_blank"><?php echo __("Terms and Conditions", IDXBOOST_DOMAIN_THEME_LANG); ?>.</a></p>
                  </div>
                </div>
              </li>
              <?php } ?>
            </ul>
          </li>
        
        </ul>
        
        <div class="ib-fbtns">
          <div class="ib-fbtn-back ib-fbtn">
            <?php echo __("Back", IDXBOOST_DOMAIN_THEME_LANG); ?>
          </div>
          <div class="ib-fbtn-next ib-fbtn ib-fbtn-fnext">
            <?php echo __("Next", IDXBOOST_DOMAIN_THEME_LANG); ?>
          </div>
          <input class="ib-fsubmit ib-fbtn" id="lead_submission_sell_submit" type="submit" 
            value="<?php echo __("Submit", IDXBOOST_DOMAIN_THEME_LANG); ?>">
        </div>
      
      </div>
    </fieldset>
  </form>
</article>
