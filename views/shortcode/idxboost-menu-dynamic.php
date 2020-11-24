<?php if (false === $flex_idx_lead): ?>
<div class="external-login" id="user-options">
    <!-- ESTRUCTURA SIN LOGIN -->
    <div class="external-lg-btn">
      <a href="#" class="external-lg-item" data-modal="modal_login" data-tab="tabLogin"><?php echo __('Sign In', IDXBOOST_DOMAIN_THEME_LANG); ?></a>
      <a href="#" class="external-lg-item" data-modal="modal_login" data-tab="tabRegister"><?php echo __('Register', IDXBOOST_DOMAIN_THEME_LANG); ?></a>
    </div>
</div>
<?php else: $my_flex_pages = flex_user_list_pages(); ?>    
    <div class="external-login">
    <!-- ESTRUCTURA CUANDO TE LOGEAS -->
    <div class="external-lg-active-user">
    	<?php $lead_name_exp = explode(' ', esc_attr($flex_idx_lead['lead_info']['first_name'])); ?>

      <span class="external-lg-user"><?php echo __('Welcome', IDXBOOST_DOMAIN_THEME_LANG); ?> <?php echo $lead_name_exp[0]; ?></span>
      <?php if (!empty($my_flex_pages)): ?>
	      <ul class="external-lg-menu">
	      	<?php foreach ($my_flex_pages as $my_flex_page): ?>
	      		<li><a href="<?php echo $my_flex_page['permalink']; ?>"><?php echo $my_flex_page['post_title']; ?></a></li>
	      	<?php endforeach; ?>
	      		<li><a href="#" class="flex-logout-link" id="flex-logout-link"><?php echo __('Logout', IDXBOOST_DOMAIN_THEME_LANG); ?></a></li>
	      </ul>
      <?php endif; ?>	      
    </div>
  </div>

  <?php endif; ?>