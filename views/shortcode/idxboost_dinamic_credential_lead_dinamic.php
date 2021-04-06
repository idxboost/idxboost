<?php  global $flex_idx_lead ?>

<div class="ip-login">
    <?php if ( false === $flex_idx_lead ) : ?>
        <ul class="ip-login-wrap item-no-hea" id="user-options">
            <li class="ip-login-item login" data-modal="modal_login" data-tab="tabLogin">
                <button class="lg-login ip-login-btn"
                        aria-label="<?php echo __('Login', IDXBOOST_DOMAIN_THEME_LANG); ?>">
                    <span class="ip-login-icon idx-icon-user"></span>
                    <span class="ip-login-text">
                      <?php echo __('Login', IDXBOOST_DOMAIN_THEME_LANG); ?>
                    </span>
                </button>
            </li>
            <li class="ip-login-item register" data-modal="modal_login" data-tab="tabRegister">
                <button class="lg-register ip-login-btn"
                        aria-label="<?php echo __('Register', IDXBOOST_DOMAIN_THEME_LANG); ?>">
                    <span class="ip-login-text">
                      <?php echo __('Register', IDXBOOST_DOMAIN_THEME_LANG); ?>
                    </span>
                </button>
            </li>
        </ul>

    <?php else : $my_flex_pages = flex_user_list_pages(); ?>
        <ul class="ip-login-wrap item-lo-hea" id="user-options">
            <?php $lead_name = explode( ' ', esc_attr( $flex_idx_lead['lead_info']['first_name'] ) ); ?>
            <li class="ip-login-item login show_modal_login_active">
                <button class="ip-login-btn"
                        aria-label="<?php echo $lead_name[0]; ?>">
                    <span class="ip-login-text">
                      <?php echo $lead_name[0]; ?>
                    </span>
                    <span class="ip-login-icon idx-icon-triangle-down"></span>
                </button>
                <div class="menu_login_active disable_login">
                    <?php if ( !empty( $my_flex_pages ) ) : ?>
                        <ul>
                            <?php foreach ($my_flex_pages as $my_flex_page): ?>
                                <li>
                                    <a href="<?php echo $my_flex_page['permalink']; ?>"
                                       title="<?php echo $my_flex_page['post_title']; ?>">
                                        <?php echo $my_flex_page['post_title']; ?>
                                    </a>
                                </li>
                            <?php endforeach; ?>
                            <li>
                                <button class="flex-logout-link" id="flex-logout-link"
                                        title="<?php echo __( 'Logout', IDXBOOST_DOMAIN_THEME_LANG ); ?>">
                                    <?php echo __( 'Logout', IDXBOOST_DOMAIN_THEME_LANG ); ?>
                                </button>
                            </li>
                        </ul>
                    <?php endif; ?>
                </div>
            </li>
        </ul>
    <?php endif; ?>
</div>
