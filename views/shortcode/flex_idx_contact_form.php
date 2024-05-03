<?php global $flex_idx_info;?>
<form 
  class="form-search gtm_general_contact_form iboost-secured-recaptcha-form iboost-form-validation"
  id="<?php echo $atts['id_form']; ?>" method="post">

  <?php if ( !empty($atts['registration_key']) ): ?>
    <input type="hidden" name="registration_key" value="<?php echo $atts['registration_key']; ?>">
  <?php endif; ?>

  <fieldset>
    <legend>Contact</legend>  

    <input type="hidden" name="ib_tags" value="">
    <input type="hidden" name="action" value="idxboost_contact_inquiry">
    
    <?php if (array_key_exists('google_gtm', $flex_idx_info['agent']) && !empty($flex_idx_info['agent']['google_gtm'])) : ?>
      <input type="hidden" name="gclid_field" id="gclid_field_contact">
    <?php endif; ?>

    <input type="hidden" class="phoneCodeValidation" name="phoneCodeValidation" value="">
    
    <h3 class="ms-hidden"><?php echo __("Email Us", IDXBOOST_DOMAIN_THEME_LANG); ?></h3>
    
    <?php  

    $idxboost_term_condition = get_option('idxboost_term_condition');

    $idxboost_agent_info = get_option('idxboost_agent_info');
    
    $nclass = "";
    if ( 
      array_key_exists('track_gender', $flex_idx_info['agent']) && 
      $flex_idx_info['agent']['track_gender'] == true
    ) {
      $nclass = "grender-active-form";
    }
    ?>
    
    <ul class="flex-content-form <?php echo $nclass; ?>">
      <li class="form-item pt-name">
        <?php 
        if ($nclass !== '') { 
          ?>
          <span><?php echo __("First Name", IDXBOOST_DOMAIN_THEME_LANG); ?> *</span>
          
          <div class="sp-box">
            <select name="gender" class="gender">
              <option value="<?php echo __('Mr.', IDXBOOST_DOMAIN_THEME_LANG);?>">
                <?php echo __('Mr.', IDXBOOST_DOMAIN_THEME_LANG);?>
              </option>
              <option value="<?php echo __('Mrs.', IDXBOOST_DOMAIN_THEME_LANG);?>">
                <?php echo __('Mrs.', IDXBOOST_DOMAIN_THEME_LANG);?>
              </option>
              <option value="<?php echo __('Miss', IDXBOOST_DOMAIN_THEME_LANG);?>">
                <?php echo __('Miss', IDXBOOST_DOMAIN_THEME_LANG);?>
              </option>
            </select>
            
            <label class="ms-hidden" for="for_user_firstname">
              <?php echo __("First Name", IDXBOOST_DOMAIN_THEME_LANG); ?>
            </label>
            <input class="medium" name="name" id="for_user_firstname" type="text" value="" required>
          </div>
          <?php 
        } else { 
          ?>
          <label class="ms-hidden" for="for_user_firstname">
            <?php echo __("First Name", IDXBOOST_DOMAIN_THEME_LANG); ?> *
          </label>
          <input class="medium" name="name" id="for_user_firstname" type="text" value="" required>
          <?php 
        } 
        ?>
      </li>
     
      <li class="form-item pt-lname">
        <label class="ms-hidden" for="for_user_lastname">
          <?php echo __("Last Name", IDXBOOST_DOMAIN_THEME_LANG); ?> *
        </label>
        <input autocorrect="off" autocapitalize="off" spellcheck="false" autocomplete="disabled" autocomplete="disabled" class="medium" name="lastname" id="for_user_lastname" type="text" value="" required>
      </li>
     
      <li class="form-item pt-email">
        <label class="ms-hidden" for="for_user_email">
          <?php echo __("Email", IDXBOOST_DOMAIN_THEME_LANG); ?> *
        </label>
        <input autocorrect="off" autocapitalize="off" spellcheck="false" autocomplete="disabled" autocomplete="disabled" class="medium" name="email" id="for_user_email" type="email" value="" required>
      </li>
     
      <li class="form-item pt-phone">
        <label class="ms-hidden" for="for_user_phone">
          <?php echo __("Phone", IDXBOOST_DOMAIN_THEME_LANG); ?> *
        </label>
        <input autocorrect="off" autocapitalize="off" spellcheck="false" autocomplete="disabled" autocomplete="disabled" class="medium" name="phone" id="for_user_phone" type="tel" value="" required>
      </li>
     
      <li class="form-item full-item">
        <label class="ms-hidden" for="for_user_comments">
          <?php echo __("Comments", IDXBOOST_DOMAIN_THEME_LANG); ?>
        </label>
        <textarea autocorrect="off" autocapitalize="off" spellcheck="false" autocomplete="disabled" autocomplete="disabled" class="textarea medium" name="message" id="for_user_comments"></textarea>
      </li>
     
      <li class="form-item full-item">
        <span>
          <?php echo __("Best Time to Reach You", IDXBOOST_DOMAIN_THEME_LANG); ?>
        </span>
        <ul class="opt-list">
          <li class="opt-item radio-item"><input name="option_time" type="radio" value="am" id="choice_1_<?php echo $atts['id_form']; ?>" checked><label for="choice_1_<?php echo $atts['id_form']; ?>"><?php echo __('am', IDXBOOST_DOMAIN_THEME_LANG);?></label></li>
          <li class="opt-item radio-item"><input name="option_time" type="radio" value="pm" id="choice_2_<?php echo $atts['id_form']; ?>"><label for="choice_2_<?php echo $atts['id_form']; ?>"><?php echo __('pm', IDXBOOST_DOMAIN_THEME_LANG);?></label></li>
          <li class="opt-item chk-item full-item"><span><?php echo __('Receive Newsletter', IDXBOOST_DOMAIN_THEME_LANG); ?></span><input name="chk" type="checkbox" value="1" id="Newsletter"><label for="Newsletter"><?php echo __('Yes, I would like to receive your Newsletter', IDXBOOST_DOMAIN_THEME_LANG); ?></label></li>
        </ul>
      </li>

      <?php if ( ($idxboost_agent_info["show_opt_in_message"]) ) {  ?>
      <li class="form-item full-item gfield fub">
        <div class="ms-flex-chk-ub">
          <?php 
            $follow_up_boss_api_key = $flex_idx_info['agent']['follow_up_boss_api_key'];
            if(!empty($follow_up_boss_api_key)){
          ?>
          <div class="ms-item-chk">
            <input type="checkbox" id="follow_up_boss_valid" required>
            <label for="follow_up_boss_valid">Follow Up Boss</label>
          </div>
          <?php } ?>
          <div class="ms-fub-disclaimer">
            <p><?php echo __("By submitting this form you agree to be contacted by", IDXBOOST_DOMAIN_THEME_LANG); ?> <?php echo $idxboost_term_condition["company_name"]; ?> <?php echo __('via call, email, and text. To opt out, you can reply "stop" at any time or click the unsubscribe link in the emails. For more information see our', IDXBOOST_DOMAIN_THEME_LANG); ?> <a href="/terms-and-conditions/#follow-up-boss" target="_blank"><?php echo __("Terms and Conditions", IDXBOOST_DOMAIN_THEME_LANG); ?>.</a></p>
          </div>
        </div>
      </li>
      <?php } ?>
      
      <li class="form-item full-item">
        <button class="clidxboost-btn-link" aria-label="<?php echo __('Submit', IDXBOOST_DOMAIN_THEME_LANG); ?>">
          <span><?php echo __('Submit', IDXBOOST_DOMAIN_THEME_LANG); ?></span>
        </button>
      </li>
    </ul>
    
    <input type="hidden" class="idx_id_form" value="<?php echo $atts['id_form']; ?>">
  
  </fieldset>
</form>
