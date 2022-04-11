<?php
// for WP-Customizer
add_action('customize_register', 'func_customizer_idxboost');

// register assets for public
add_action('wp_enqueue_scripts', 'flex_idx_register_assets');

// load initial theme css
add_action('wp_enqueue_scripts', 'idx_boots_main_css');

// load assets for admin
add_action('admin_init', 'flex_idx_admin_register_assets');

// load partial html
add_action('wp_footer', 'flex_include_html_partial');

// setup admin root menu
add_action('admin_menu', 'flex_idx_create_admin_root_menu');

add_action('wp_ajax_flex_statistics_filter_sold', 'flex_statistics_filter_sold_xhr_fn');
add_action('wp_ajax_nopriv_flex_statistics_filter_sold', 'flex_statistics_filter_sold_xhr_fn');

// share with friend a building
add_action('wp_ajax_flex_share_with_friend', 'flex_share_with_friend_xhr_fn');
add_action('wp_ajax_nopriv_flex_share_with_friend', 'flex_share_with_friend_xhr_fn');

add_action('wp_ajax_idxboost_import_building', 'idxboost_import_building_xhr_fn');
add_action('wp_ajax_nopriv_idxboost_import_building', 'idxboost_import_building_xhr_fn');

add_action('wp_ajax_idx_import_tgbuilding_update', 'idx_import_tgbuilding_update_xhr_fn');
add_action('wp_ajax_nopriv_idx_import_tgbuilding_update', 'idx_import_tgbuilding_update_xhr_fn');

add_action('wp_ajax_idxboost_get_data_slider', 'idxboost_get_data_slider_xhr_fn');
add_action('wp_ajax_nopriv_idxboost_get_data_slider', 'idxboost_get_data_slider_xhr_fn');

add_action('wp_ajax_ib_slider_filter_regular', 'ib_slider_filter_regular_xhr_fn');
add_action('wp_ajax_nopriv_ib_slider_filter_regular', 'ib_slider_filter_regular_xhr_fn');

add_action('wp_ajax_idxboost_agent_contact_inquiry', 'idxboost_agent_contact_inquiry_xhr_fn');
add_action('wp_ajax_nopriv_idxboost_agent_contact_inquiry', 'idxboost_agent_contact_inquiry_xhr_fn');

add_action('wp_ajax_idxboost_collection_list', 'idxboost_collection_list_fn');
add_action('wp_ajax_nopriv_idxboost_collection_list', 'idxboost_collection_list_fn');

add_action('wp_ajax_idxboost_sub_area_collection_list', 'idxboost_sub_area_collection_list_fn');
add_action('wp_ajax_nopriv_idxboost_sub_area_collection_list', 'idxboost_sub_area_collection_list_fn');

add_action('wp_ajax_ib_boost_commercial', 'ib_boost_commercial_xhr_fn');
add_action('wp_ajax_nopriv_ib_boost_commercial', 'ib_boost_commercial_xhr_fn');

add_action('wp_ajax_ib_boost_dinamic_data', 'ib_boost_dinamic_data_xhr_fn');
add_action('wp_ajax_nopriv_ib_boost_dinamic_data', 'ib_boost_dinamic_data_xhr_fn');

add_action('wp_ajax_ib_boost_dinamic_data_agent_office', 'ib_boost_dinamic_data_agent_office_xhr_fn');
add_action('wp_ajax_nopriv_ib_boost_dinamic_data_agent_office', 'ib_boost_dinamic_data_agent_office_xhr_fn');

add_action('wp_ajax_idxboost_collection_off_market', 'idxboost_collection_off_market_fn');
add_action('wp_ajax_nopriv_idxboost_collection_off_market', 'idxboost_collection_off_market_fn');

add_action('wp_ajax_idxboost_exclusive_slider', 'idx_exclusive_operation_slider_xhr_fn');
add_action('wp_ajax_nopriv_idxboost_exclusive_slider', 'idx_exclusive_operation_slider_xhr_fn');

add_action('wp_ajax_track_force_registration_building', 'idx_force_registration_building_xhr_fn');
add_action('wp_ajax_nopriv_track_force_registration_building', 'idx_force_registration_building_xhr_fn');

// search properties
add_action('wp_ajax_flex_search', 'flex_idx_search_xhr_fn');
add_action('wp_ajax_nopriv_flex_search', 'flex_idx_search_xhr_fn');

/*PASSWORD*/
add_action('wp_ajax_flex_idx_lead_resetpass', 'flex_idx_lead_resetpass_xhr_fn');
add_action('wp_ajax_nopriv_flex_idx_lead_resetpass', 'flex_idx_lead_resetpass_xhr_fn');

add_action('wp_ajax_flex_idx_get_resetpass', 'flex_idx_get_resetpass_xhr_fn');
add_action('wp_ajax_nopriv_flex_idx_get_resetpass', 'flex_idx_get_resetpass_xhr_fn');
/*PASSWORD*/

add_action('wp_ajax_idxboost_history_building', 'idxboost_history_building_xhr_fn');
add_action('wp_ajax_nopriv_idxboost_history_building', 'idxboost_history_building_xhr_fn');

// filter page
add_action('wp_ajax_filter_search', 'flex_idx_filter_page_xhr_fn');
add_action('wp_ajax_nopriv_filter_search', 'flex_idx_filter_page_xhr_fn');

add_action('wp_ajax_filter_search_exclusive_listing', 'filter_search_exclusive_listing_xhr_fn');
add_action('wp_ajax_nopriv_filter_search_exclusive_listing', 'filter_search_exclusive_listing_xhr_fn');

add_action('wp_ajax_filter_search_recent_sales', 'filter_search_recent_sales_xhr_fn');
add_action('wp_ajax_nopriv_filter_search_recent_sales', 'filter_search_recent_sales_xhr_fn');

add_action('wp_ajax_idxboost_filter_save_search', 'idxboost_filter_save_search_xhr_fn');
add_action('wp_ajax_nopriv_idxboost_filter_save_search', 'idxboost_filter_save_search_xhr_fn');

add_action('wp_ajax_idxboost_new_filter_save_search_xhr_fn', 'idxboost_new_filter_save_search_xhr_fn');
add_action('wp_ajax_nopriv_idxboost_new_filter_save_search_xhr_fn', 'idxboost_new_filter_save_search_xhr_fn');

// mortgage calculator
add_action('wp_ajax_dgt_mortgage_calculator', 'dgt_mortgage_calculator_fn');
add_action('wp_ajax_nopriv_dgt_mortgage_calculator', 'dgt_mortgage_calculator_fn');

// registration quizz save
add_action('wp_ajax_ib_register_quizz_save', 'ib_register_quizz_save_fn');
add_action('wp_ajax_nopriv_ib_register_quizz_save', 'ib_register_quizz_save_fn');

// filter page
add_action('wp_ajax_flex_look_building_xhr_fn', 'flex_look_building_xhr_fn');
add_action('wp_ajax_nopriv_flex_look_building_xhr_fn', 'flex_look_building_xhr_fn');

// autocomplete
add_action('wp_ajax_flex_autocomplete', 'flex_idx_autocomplete_xhr_fn');
add_action('wp_ajax_nopriv_flex_autocomplete', 'flex_idx_autocomplete_xhr_fn');

// try to save filter
add_action('wp_ajax_iboost_try_save_filter', 'iboost_try_save_filter_xhr_fn');
add_action('wp_ajax_nopriv_iboost_try_save_filter', 'iboost_try_save_filter_xhr_fn');

// autocomplete
add_action('wp_ajax_flex_autocomplete', 'flex_idx_autocomplete_xhr_fn');
add_action('wp_ajax_nopriv_flex_autocomplete', 'flex_idx_autocomplete_xhr_fn');

// autocomplete
add_action('wp_ajax_ib_schools_info', 'ib_schools_info_xhr_fn');
add_action('wp_ajax_nopriv_ib_schools_info', 'ib_schools_info_xhr_fn');

// lead signup
add_action('wp_ajax_flex_idx_lead_signup', 'flex_lead_signup_xhr_fn');
add_action('wp_ajax_nopriv_flex_idx_lead_signup', 'flex_lead_signup_xhr_fn');

// lead login
add_action('wp_ajax_flex_idx_lead_signin', 'flex_lead_signin_xhr_fn');
add_action('wp_ajax_nopriv_flex_idx_lead_signin', 'flex_lead_signin_xhr_fn');

// lead logout
add_action('wp_ajax_flex_idx_lead_logout', 'flex_lead_logout_xhr_fn');
add_action('wp_ajax_nopriv_flex_idx_lead_logout', 'flex_lead_logout_xhr_fn');

// save favorites
add_action('wp_ajax_flex_favorite', 'flex_idx_favorite_xhr_fn');
add_action('wp_ajax_nopriv_flex_favorite', 'flex_idx_favorite_xhr_fn');

// hide property view
add_action('wp_ajax_ib_hide_listing_view', 'ib_hide_listing_view_xhr_fn');
add_action('wp_ajax_nopriv_ib_hide_listing_view', 'ib_hide_listing_view_xhr_fn');

// save buildings
add_action('wp_ajax_flex_favorite_building', 'flex_idx_favorite_building_xhr_fn');
add_action('wp_ajax_nopriv_flex_favorite_building', 'flex_idx_favorite_building_xhr_fn');

// save sub area
add_action('wp_ajax_flex_favorite_sub_area', 'flex_favorite_sub_area_xhr_fn');
add_action('wp_ajax_nopriv_flex_favorite_sub_area', 'flex_favorite_sub_area_xhr_fn');

// rate favorites
add_action('wp_ajax_flex_favorite_rate', 'flex_idx_favorite_rate_xhr_fn');
add_action('wp_ajax_nopriv_flex_favorite_rate', 'flex_idx_favorite_rate_xhr_fn');

// save favorite comments
add_action('wp_ajax_flex_favorite_comments', 'flex_idx_favorite_comments_xhr_fn');
add_action('wp_ajax_nopriv_flex_favorite_comments', 'flex_idx_favorite_comments_xhr_fn');

// remove favorite comments
add_action('wp_ajax_flex_favorite_comments_remove', 'flex_idx_favorite_comments_remove_xhr_fn');
add_action('wp_ajax_nopriv_flex_favorite_comments_remove', 'flex_idx_favorite_comments_remove_xhr_fn');

// save search
add_action('wp_ajax_flex_save_search', 'flex_idx_save_search_xhr_fn');
add_action('wp_ajax_nopriv_flex_save_search', 'flex_idx_save_search_xhr_fn');

// update search
add_action('wp_ajax_flex_update_search', 'flex_update_search_xhr_fn');
add_action('wp_ajax_nopriv_flex_update_search', 'flex_update_search_xhr_fn');


add_action('wp_ajax_filter_agent_office', 'filter_agent_office_xhr_fn');
add_action('wp_ajax_nopriv_filter_agent_office', 'filter_agent_office_xhr_fn');


// load property detail into modal
add_action('wp_ajax_load_modal_property', 'iboost_load_property_xhr_fn');
add_action('wp_ajax_nopriv_load_modal_property', 'iboost_load_property_xhr_fn');

// update profile
add_action('wp_ajax_flex_profile_save', 'flex_idx_profile_save_xhr_fn');
add_action('wp_ajax_nopriv_flex_profile_save', 'flex_idx_profile_save_xhr_fn');

// track listing view
add_action('wp_ajax_track_property_view', 'flex_idx_track_property_view_xhr_fn');
add_action('wp_ajax_nopriv_track_property_view', 'flex_idx_track_property_view_xhr_fn');

// setup admin xhr actions
add_action('wp_ajax_flex_connect', 'flex_idx_connect_fn');

add_action('wp_ajax_idx_save_tools_admin_form', 'idx_save_tools_admin_form_fn');

add_action('wp_ajax_flex_importdata', 'flex_idx_import_data_fn');

add_action('wp_ajax_flex_skip_importdata', 'flex_idx_skip_import_data_fn');

add_action('wp_ajax_flex_connect_launch', 'flex_connect_launch_fn');

// inquiry forms
add_action('wp_ajax_flex_idx_request_property_form', 'flex_idx_request_property_form_fn');
add_action('wp_ajax_nopriv_flex_idx_request_property_form', 'flex_idx_request_property_form_fn');

add_action('wp_ajax_idxboost_contact_inquiry', 'idxboost_contact_inquiry_fn');
add_action('wp_ajax_nopriv_idxboost_contact_inquiry', 'idxboost_contact_inquiry_fn');

add_action('wp_ajax_flex_idx_request_website_building_form', 'flex_idx_request_website_building_form_fn');
add_action('wp_ajax_nopriv_flex_idx_request_website_building_form', 'flex_idx_request_website_building_form_fn');

add_action('wp_ajax_flex_schedule_showing', 'flex_schedule_showing_fn');
add_action('wp_ajax_nopriv_flex_schedule_showing', 'flex_schedule_showing_fn');

// property detail
add_action('wp_ajax_flex_track_property_detail', 'flex_track_property_detail_fn');
add_action('wp_ajax_nopriv_flex_track_property_detail', 'flex_track_property_detail_fn');

// lead submission for buy
add_action('wp_ajax_lead_submission_buy', 'ib_lead_submission_buy_xhr_fn');
add_action('wp_ajax_nopriv_lead_submission_buy', 'ib_lead_submission_buy_xhr_fn');

// lead submission for rent
add_action('wp_ajax_lead_submission_rent', 'ib_lead_submission_rent_xhr_fn');
add_action('wp_ajax_nopriv_lead_submission_rent', 'ib_lead_submission_rent_xhr_fn');

// lead submission for sell
add_action('wp_ajax_lead_submission_sell', 'ib_lead_submission_sell_xhr_fn');
add_action('wp_ajax_nopriv_lead_submission_sell', 'ib_lead_submission_sell_xhr_fn');

// lead submission for showing
add_action('wp_ajax_lead_submission_showing', 'ib_lead_submission_showing_xhr_fn');
add_action('wp_ajax_nopriv_lead_submission_showing', 'ib_lead_submission_showing_xhr_fn');

// register settings for configuration
add_action('admin_init', 'flex_idx_register_settings_configuration_fn');

// setup initial post types
add_action('init', 'flex_idx_posttype_pages_fn');

add_action('wp_footer', 'idxboost_autologin_alerts_fn', 25);

// Disable Open Graph meta on AMP pages
add_filter('aioseop_enable_amp_social_meta', '__return_false');

// Remove Yoast SEO OpenGraph Output From One Post/Page
add_filter('wpseo_opengraph_url', '__return_false');
add_filter('wpseo_opengraph_desc', '__return_false');
add_filter('wpseo_opengraph_title', '__return_false');
add_filter('wpseo_opengraph_type', '__return_false');
add_filter('wpseo_opengraph_site_name', '__return_false');

// print analytics script
add_action('wp_head', 'iboost_print_analytics_script');

add_action('idx_gtm_head', 'iboost_print_googlegtm_head_script', 0);

add_action('idx_gtm_body', 'iboost_print_googlegtm_body_script', 0);

// CMS. REST api
add_action('rest_api_init', ['IDXBoost_REST_API_Endpoints', 'registerEndpoints']);

function print_inline_js()
{
    if (is_admin()) {
        return;
    }

    global $post, $wp;

    if ('idx-agents' === $post->post_type) :
        $agent_registration_key = get_post_meta($post->ID, '_flex_agent_registration_key', true);
        $agent_slugname         = $post->post_name;
        $agent_permalink        = implode('/', [site_url(), $agent_slugname]);
        $wp_request_exp         = explode('/', $wp->request);
        $is_agent_page_featured = false;

        if (count($wp_request_exp) >= 2) {
            if ('featured-properties' === $wp_request_exp[1]) {
                $is_agent_page_featured = true;
            }
        }
?>
        <script type="text/javascript">
            var IB_AGENT_REGISTRATION_KEY = '<?php echo $agent_registration_key; ?>';
            var IB_AGENT_SLUGNAME = '<?php echo $agent_slugname; ?>';
            var IB_AGENT_PERMALINK = '<?php echo $agent_permalink; ?>';
            <?php if (true === $is_agent_page_featured) : ?>
                var IB_AGENT_FEATURED_PAGE = true;
            <?php endif; ?>
        </script>
<?php
    endif;
}

add_action('wp_print_scripts', 'print_inline_js');

// CMS. Register assets
add_action('wp_enqueue_scripts', 'idxboost_cms_register_assets');

// CMS. Enqueue assets
add_action('wp_enqueue_scripts', 'idxboost_cms_enqueue_assets');

// CMS. Setup
add_action('wp_head', 'idxboost_cms_setup', 101);

// CMS. Load assets
add_action('wp_head', 'idxboost_cms_assets', 100);

// CMS. Load SEO
add_action('wp_head', 'custom_seo_page', 0, 0);

// CMS. Load Integrations In heade
add_action('wp_head', 'idxboost_integrations_head', 0, 0);

// CMS. Load loader
add_action('idx_dinamic_body', 'idxboost_cms_loader', 10, 1);
add_action('idx_cms_loader', 'idxboost_cms_loader', 10, 1);

// CMS. Load cta modal
add_action('get_footer', 'idxboost_cms_cta_modal', 101, 1);

// CMS. Load tripwire
add_action('get_footer', 'idxboost_cms_tripwire', 101, 1);

// CMS. Load translate
add_action('get_footer', 'idxboost_cms_translate', 101, 1);

// CMS. Update post
add_action('edit_post', 'idx_edit_post', 10, 2);

// CMS. Disable WP editor for custom and landing pages
add_action('admin_init', 'hide_editor', 10, 2);

// Hook general init to login users if an autologin code is specified
add_action('init', 'idx_autologin_authenticate');

add_action('wp_ajax_update_criterial_alert', 'update_criterial_alert_xhr_fn');
add_action('wp_ajax_nopriv_update_criterial_alert', 'update_criterial_alert_xhr_fn');

// Remove canonical on flex-idx-pages post types
add_action('wp', 'remove_canonical');