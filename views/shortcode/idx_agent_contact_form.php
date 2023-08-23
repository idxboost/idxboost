<?php 
$idxboost_term_condition = get_option('idxboost_term_condition'); 
$idxboost_agent_info = get_option('idxboost_agent_info');
?>

<form id="<?php echo $atts['id_form']; ?>" class="form-search gtm_general_contact_form iboost-secured-recaptcha-form" method="post">
  <input type="hidden" name="ib_tags" value="">
  <input type="hidden" name="action" value="idxboost_agent_contact_inquiry">
  <input type="hidden" name="idx_agent_data_email" value="<?php echo addslashes($GLOBALS['data_agent']['email']); ?>">
  <input type="hidden" name="idx_agent_data_phone" value="<?php echo addslashes($GLOBALS['data_agent']['phone']); ?>">
  <input type="hidden" name="idx_agent_data_name" value="<?php echo addslashes($GLOBALS['data_agent']['name']); ?>">

  <?php  
    global $flex_idx_info;
    if (array_key_exists('track_gender', $flex_idx_info['agent'])) {
        if ($flex_idx_info['agent']['track_gender']==true) { 
          $nclass = "grender-active-form";
        }else{
          $nclass = "";
        }
    }else{
      $nclass = "";
    }
    ?>
  <ul class="flex-content-form <?php echo $nclass; ?>">
    <li class="form-item pt-name">
      <?php if ($nclass !== '') { ?>
       <span><?php echo __("First Name", IDXBOOST_DOMAIN_THEME_LANG); ?> *</span>
      <div class="sp-box">
        <select name="gender" class="gender">
          <option value="<?php echo __('Mr.', IDXBOOST_DOMAIN_THEME_LANG);?>"><?php echo __('Mr.', IDXBOOST_DOMAIN_THEME_LANG);?></option>
          <option value="<?php echo __('Mrs.', IDXBOOST_DOMAIN_THEME_LANG);?>"><?php echo __('Mrs.', IDXBOOST_DOMAIN_THEME_LANG);?></option>
          <option value="<?php echo __('Miss', IDXBOOST_DOMAIN_THEME_LANG);?>"><?php echo __('Miss', IDXBOOST_DOMAIN_THEME_LANG);?></option>          
        </select>
        <input class="medium" name="name" type="text" value="" required>
      </div>
      <?php }else{ ?>
      <label class="ms-hidden" for="for_user_firstname"><?php echo __("First Name", IDXBOOST_DOMAIN_THEME_LANG); ?> *</label>
      <input id="for_user_firstname" class="medium" name="name" type="text" value="" required>
      <?php  } ?>
    </li>
    <li class="form-item pt-lname">
      <label class="ms-hidden" for="for_user_lastname"><?php echo __("Last Name", IDXBOOST_DOMAIN_THEME_LANG); ?> *</label>
      <input id="for_user_lastname" autocorrect="off" autocapitalize="off" spellcheck="false" autocomplete="disabled" autocomplete="disabled" class="medium" name="lastname" type="text" value="" required>
    </li>
    <li class="form-item pt-email">
      <label class="ms-hidden" for="for_user_email"><?php echo __("Email", IDXBOOST_DOMAIN_THEME_LANG); ?> *</label>
      <input id="for_user_email" autocorrect="off" autocapitalize="off" spellcheck="false" autocomplete="disabled" autocomplete="disabled" class="medium" name="email" type="email" value="" required>
    </li>
    <li class="form-item pt-phone">
      <label class="ms-hidden" for="for_user_phone"><?php echo __("Phone", IDXBOOST_DOMAIN_THEME_LANG); ?> *</label>
      <input id="for_user_phone" autocorrect="off" autocapitalize="off" spellcheck="false" autocomplete="disabled" autocomplete="disabled" class="medium" name="phone" type="" value="" required>
    </li>
    <li class="form-item full-item">
      <label class="ms-hidden" for="for_user_comments"><?php echo __("Comments", IDXBOOST_DOMAIN_THEME_LANG); ?></label>
      <textarea id="for_user_comments" autocorrect="off" autocapitalize="off" spellcheck="false" autocomplete="disabled" autocomplete="disabled" class="textarea medium" name="message"></textarea>
    </li>
    <?php if ( isset($idxboost_agent_info["show_opt_in_message"]) ) {  ?>
    <li class="gfield fub form-item full-item">
      <div class="ms-fub-disclaimer">
        <p>By submitting this form, you are agree to be contacted by <?php echo $idxboost_term_condition["company_name"]; ?> via call, email, and text. For more information see our <a href="/terms-and-conditions/#follow-up-boss" target="_blank">Terms and Conditions.</a></p>
      </div>
    </li>
    <?php } ?>
    <li class="form-item full-item">
      <button class="clidxboost-btn-link" aria-label="<?php echo __('Submit', IDXBOOST_DOMAIN_THEME_LANG); ?>"><span><?php echo __('Submit', IDXBOOST_DOMAIN_THEME_LANG); ?></span></button>
    </li>
  </ul>
  <input type="hidden" class="idx_id_form" value="<?php echo $atts['id_form']; ?>">
</form>
