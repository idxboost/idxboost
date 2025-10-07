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
  <img class="ib-form-bg" src="/" alt="<?php echo __("What are you looking to buy?", IDXBOOST_DOMAIN_THEME_LANG); ?>">
  
  <form class="ib-fbscontainer gtm_i_want_to_buy iboost-secured-recaptcha-form iboost-form-validation" method="post" id="lead_submission_buy_form">
    <?php if (!empty($atts['registration_key'])): ?>
      <input type="hidden" name="registration_key" value="<?php echo $atts['registration_key']; ?>">
    <?php endif; ?> 
    
    <input type="hidden" name="ib_tags" value="i want to buy">
    <input type="hidden" name="action" value="lead_submission_buy">
    
    <?php if (array_key_exists('google_gtm', $flex_idx_info['agent']) && !empty($flex_idx_info['agent']['google_gtm'])) : ?>
      <input type="hidden" name="gclid_field" id="gclid_field_form_lead_submission_buy">
    <?php endif; ?>
    
    <div class="ib-form-wrapper">
      
      <ul class="ib-fsteps">
        
        <li class="ib-fsitem ib-fsitem-active">
          <h1 class="ib-fstitle">
            <?php echo __("What are you looking to buy?", IDXBOOST_DOMAIN_THEME_LANG); ?>
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
            <?php echo __("What's your price range?", IDXBOOST_DOMAIN_THEME_LANG); ?>
          </h4>
          <ul class="ib-fsradios">
            <li class="ib-fsritem">
              <input class="ib-firadio" type="radio" value="Below $1M" id="ib-form-bellow" name="ib-fprice">
              <label class="ib-filabel" for="ib-form-bellow"><?php echo __("Below $1M", IDXBOOST_DOMAIN_THEME_LANG); ?></label>
            </li>
            <li class="ib-fsritem">
              <input class="ib-firadio" type="radio" value="$1M to $3M" id="ib-form-onetwo" name="ib-fprice">
              <label class="ib-filabel" for="ib-form-onetwo"><?php echo __("$1M to $3M", IDXBOOST_DOMAIN_THEME_LANG); ?></label>
            </li>
            <li class="ib-fsritem">
              <input class="ib-firadio" type="radio" value="$3M to $5M" id="ib-form-threefive" name="ib-fprice">
              <label class="ib-filabel" for="ib-form-threefive"><?php echo __("$3M to $5M", IDXBOOST_DOMAIN_THEME_LANG); ?></label>
            </li>
            <li class="ib-fsritem">
              <input class="ib-firadio" type="radio" value="$5M+" id="ib-form-morefive" name="ib-fprice">
              <label class="ib-filabel" for="ib-form-morefive"><?php echo __("$5M+", IDXBOOST_DOMAIN_THEME_LANG); ?></label>
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
            <?php echo __("Timeline to purchase", IDXBOOST_DOMAIN_THEME_LANG); ?>
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
              <input required class="ib-fsinput" type="email" name="email" placeholder="<?php echo __("Email*", IDXBOOST_DOMAIN_THEME_LANG); ?>">
            </li>
            <li class="ib-fsftem">
              <input required class="ib-fsinput" type="text" name="name" placeholder="<?php echo __("Name*", IDXBOOST_DOMAIN_THEME_LANG); ?>">
            </li>
            <li class="ib-fsftem">
              <input required class="ib-fsinput" type="tel" name="phone" placeholder="<?php echo __("Phone*", IDXBOOST_DOMAIN_THEME_LANG); ?>">
            </li>
            <li class="ib-fsftem ib-fsftem-textarea">
              <textarea class="ib-fstextarea" placeholder="<?php echo __("Comments", IDXBOOST_DOMAIN_THEME_LANG); ?>" name="comments"></textarea>
            </li>
            <?php if ( ($idxboost_agent_info["show_opt_in_message"]) ) {  ?>
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
        <input class="ib-fsubmit ib-fbtn" id="lead_submission_buy_submit" type="submit" 
          value="<?php echo __("Submit", IDXBOOST_DOMAIN_THEME_LANG); ?>">
      </div>
    
    </div>
  </form>
</article>
