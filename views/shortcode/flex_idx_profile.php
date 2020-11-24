<?php if (false === $flex_idx_lead): ?>
<style>
.flex-not-logged-in-msg {}
.flex-not-logged-in-msg p {
    font-size: 50px;
    margin: 50px 0;
    text-align: center;
}
.flex-not-logged-in-msg p a {
    background: #0072ac;
    color: #fff;
    text-decoration: none;
    padding: 10px;
    border-radius: 5px;
    text-transform: uppercase;
    font-size: 40px;
}
</style>
<div class="gwr flex-not-logged-in-msg">
   <p><?php echo __("You need to", IDXBOOST_DOMAIN_THEME_LANG); ?> <a class="flex-login-link" href="#"><?php echo __("login", IDXBOOST_DOMAIN_THEME_LANG); ?></a> <?php echo __("to view this page.", IDXBOOST_DOMAIN_THEME_LANG); ?></p>
</div>
<?php else: ?>
<style>
.favorite-list-save {max-width:1400px;margin-left:auto;margin-right:auto;}
</style>
<script>
  (function ($) {
    $(function() {
      /************* INICIO FUNCIONALIDAD PARA EL SELECT ***************/
      $(".clidxboost-select-mb").on("click", function() {
        $(this).toggleClass('clidxboost-active');
      });

      $(".clidxboost-select-mb li a").on("click", function() {
        $(".clidxboost-select-mb li").removeClass('clidxboost-active');
        $(this).parent().addClass('clidxboost-active');
        $(".clidxboost-select-mb").removeClass('clidxboost-active');
      });
      /************** FINAL FUNCIONALIDAD PARA EL SELECT ***************/
    });
  })(jQuery);
</script>
      <main class="home page-result">
         <section id="wrap-result" class="saved-list view-list">
            <h1 class="title"><?php echo __("Search results", IDXBOOST_DOMAIN_THEME_LANG); ?></h1>
            <div class="gwr">
                <div class="clidxboost-wrapper-smb">
                  <div class="clidxboost-content-select-mb">
                    <ul class="clidxboost-select-mb">
                      <li class="clidxboost-active">
                        <a href="<?php echo $flex_idx_info['pages']['flex_idx_profile']['guid'] ?>">
                          <span><?php echo $flex_idx_info['pages']['flex_idx_profile']['post_title']; ?></span>
                        </a>
                      </li>
                      <li>
                        <a href="<?php echo $flex_idx_info['pages']['flex_idx_favorites']['guid']; ?>">
                          <span><?php echo $flex_idx_info['pages']['flex_idx_favorites']['post_title']; ?></span>
                        </a>
                      </li>
                      <li>
                        <a href="<?php echo $flex_idx_info['pages']['flex_idx_saved_searches']['guid']; ?>">
                          <span><?php echo $flex_idx_info['pages']['flex_idx_saved_searches']['post_title']; ?></span>
                        </a>
                      </li>
                      <li>
                        <a href="<?php echo $flex_idx_info['pages']['flex_idx_saved_buildings']['guid']; ?>">
                          <span><?php echo $flex_idx_info['pages']['flex_idx_saved_buildings']['post_title']; ?></span>
                        </a>
                      </li>
                    </ul>
                  </div>
                </div>

               <div id="wrap-list-result" class="default-body-tab">
                  <div id="tab-profile" class="default-item-tab active">
                     <div class="header-title-profile">
                        <h2 class="title-profile"><?php echo __("My Profile", IDXBOOST_DOMAIN_THEME_LANG); ?></h2>
                     </div>
                     <div class="form-profile">
                        <form class="form-shared-saved" method="post" id="flex_idx_profile_form">
                           <input type="hidden" name="action" value="flex_profile_save">
                           <ul class="body-form">
<li class="content-form">
  <label for="flex_idx_profile_name"><?php echo __("Name", IDXBOOST_DOMAIN_THEME_LANG); ?>*</label>
  <input type="text" class="input-form" name="flex_idx_profile_name" id="flex_idx_profile_name" value="<?php echo esc_attr($flex_idx_lead['lead_info']['first_name']); ?>" required>
</li>
<li class="content-form">
  <label for="flex_idx_profile_last_name"><?php echo __("Last Name", IDXBOOST_DOMAIN_THEME_LANG); ?>*</label>
  <input type="text" class="input-form" name="flex_idx_profile_last_name" id="flex_idx_profile_last_name" value="<?php echo esc_attr($flex_idx_lead['lead_info']['last_name']); ?>" required></li>
<li class="content-form">
  <label for="flex_idx_profile_email"><?php echo __("Email", IDXBOOST_DOMAIN_THEME_LANG); ?>*</label>
  <input type="email" <?php if('email' !== $flex_idx_lead['lead_info']['logon_type']): ?> readonly <?php endif; ?>  class="input-form" name="flex_idx_profile_email" id="flex_idx_profile_email" value="<?php echo esc_attr($flex_idx_lead['lead_info']['email_address']); ?>" required>
</li>
<li class="content-form">
  <label for="flex_idx_profile_phone"><?php echo __("Phone", IDXBOOST_DOMAIN_THEME_LANG); ?>*</label>
  <input type="text" class="input-form" name="flex_idx_profile_phone" id="flex_idx_profile_phone" value="<?php echo esc_attr($flex_idx_lead['lead_info']['phone_number']); ?>">
</li>
<li class="content-form">
  <label for="flex_idx_profile_address"><?php echo __("Address", IDXBOOST_DOMAIN_THEME_LANG); ?></label>
  <input type="text" class="input-form" name="flex_idx_profile_address" id="flex_idx_profile_address" value="<?php echo esc_attr($flex_idx_lead['lead_info']['address']); ?>">
</li>
<li class="content-form">
  <label for="flex_idx_profile_city"><?php echo __("City", IDXBOOST_DOMAIN_THEME_LANG); ?></label>
  <input type="text" class="input-form" name="flex_idx_profile_city" id="flex_idx_profile_city" value="<?php echo esc_attr($flex_idx_lead['lead_info']['city']); ?>">
</li>
<li class="content-form">
  <label for="flex_idx_profile_state"><?php echo __("State", IDXBOOST_DOMAIN_THEME_LANG); ?></label>
  <input type="text" class="input-form" name="flex_idx_profile_state" id="flex_idx_profile_state" value="<?php echo esc_attr($flex_idx_lead['lead_info']['state']); ?>">
</li>
<li class="content-form">
  <label for="flex_idx_profile_zip"><?php echo __("Zip Code", IDXBOOST_DOMAIN_THEME_LANG); ?></label>
  <input type="text" class="input-form" name="flex_idx_profile_zip" id="flex_idx_profile_zip" value="<?php echo esc_attr($flex_idx_lead['lead_info']['zip_code']); ?>">
</li>                           
</ul>

                           <?php if ('email' === $flex_idx_lead['lead_info']['logon_type']): ?>
                             <div class="header-title-profile">
                                <h2 class="title-profile"><?php echo __("Change Password", IDXBOOST_DOMAIN_THEME_LANG); ?></h2>
                             </div>
                             <ul class="body-form">
                                
<li class="content-form">
<label for="flex_idx_new_password"><?php echo __("New Password", IDXBOOST_DOMAIN_THEME_LANG); ?>*</label>
<input type="password" name="new_password" class="input-form" id="flex_idx_new_password"></li>
                                <li class="content-form">
<label for="flex_idx_confirm_password"><?php echo __("Confirm Password", IDXBOOST_DOMAIN_THEME_LANG); ?>*</label>
<input type="password" name="confirm_password" class="input-form" id="flex_idx_confirm_password"></li>
                             </ul>
                           <?php endif; ?>

                           <p>*<?php echo __("Required fields. Your personal information is strictly confidential and will not be shared with any outside organizations.", IDXBOOST_DOMAIN_THEME_LANG); ?> </p>
                           <div class="content-btn">
                              <button type="button" onclick="javascript:location.reload();" class="clidxboost-btn-general clidxboost-btn-cancel" aria-label="<?php echo __("Cancel", IDXBOOST_DOMAIN_THEME_LANG); ?>"><span><?php echo __("Cancel", IDXBOOST_DOMAIN_THEME_LANG); ?></span></a>
                              <button type="submit" class="clidxboost-btn-general"><span><?php echo __("Save profile", IDXBOOST_DOMAIN_THEME_LANG); ?></span></button>
                           </div>
                        </form>
                     </div>
                  </div>
               </div>
            </div>
         </section>
      </main>
<!-- FORMULARIO -->
<?php endif; ?>
