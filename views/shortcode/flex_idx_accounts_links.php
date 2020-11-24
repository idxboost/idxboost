<?php if (false === $flex_idx_lead): ?>
<ul class="item-no-hea item-header" id="user-options">
  <li class="login" data-modal="modal_login">
    <a title="Log in" data-modal="modal_login" rel="nofollow">
      <?php echo __('Sign In', IDXBOOST_DOMAIN_THEME_LANG); ?>
    </a>
  </li>
  <li class="register" data-modal="modal_login">
    <a title="Subscribe" data-modal="modal_login" rel="nofollow">
      <?php echo __('Register', IDXBOOST_DOMAIN_THEME_LANG); ?>
    </a>
  </li>
</ul>
<?php else: ?>
<ul class="item-lo-hea item-header" id="user-options">
  <?php $lead_name_exp = explode(' ', esc_attr($flex_idx_lead['lead_info']['first_name'])); ?>
  <li class="login show_modal_login_active">
    <a href="javascript:void(0)" rel="nofollow">
      <?php echo __('Welcome', IDXBOOST_DOMAIN_THEME_LANG); ?> <?php echo $lead_name_exp[0]; ?>
    </a>
    <div class="menu_login_active disable_login">
      <?php if (!empty($my_flex_pages)): ?>
      <ul>
        <?php foreach ($my_flex_pages as $my_flex_page): ?>
        <li><a href="<?php echo $my_flex_page['permalink']; ?>"><?php echo $my_flex_page['post_title']; ?></a></li>
        <?php endforeach; ?>
        <li><a href="#" class="flex-logout-link" id="flex-logout-link" rel="nofollow"><?php echo __('Logout', IDXBOOST_DOMAIN_THEME_LANG); ?></a></li>
      </ul>
      <?php endif; ?>
    </div>
  </li>
</ul>
<?php endif; ?>