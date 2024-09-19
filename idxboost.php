<?php

/**
 * Plugin Name: IDX Boost - MLS Search Technology
 * Description: The IDX Boost WordPress plugin offers the most advanced and responsive MLS search tools available, plus user analytics and marketing automation.
 * Version: 4.9.22
 * Plugin URI: https://www.idxboost.com
 * Author: IDX Boost
 * Author URI: https://www.idxboost.com
 */

defined('ABSPATH') or exit;

/**
 * Define constants
 */
define('FLEX_IDX_PATH', plugin_dir_path(__FILE__));

if (!function_exists('ib_get_assets_uri')) {
    function ib_get_assets_uri() {
        $assets_uri = plugin_dir_url(__FILE__);

        if (defined('IB_ASSETS_DEV')) {
            return $assets_uri;
        }

        return $assets_uri
            . 'build/'
            . file_get_contents(FLEX_IDX_PATH . DIRECTORY_SEPARATOR . 'build' . DIRECTORY_SEPARATOR . 'manifest.json')
            . '/';
    }
}

if (!function_exists('ib_get_idx_path')) {
    function ib_get_idx_path() {
        if (defined('IB_ASSETS_DEV')) {
            return FLEX_IDX_PATH;
        }
        return FLEX_IDX_PATH
            . 'build/'
            . file_get_contents(FLEX_IDX_PATH . DIRECTORY_SEPARATOR . 'build' . DIRECTORY_SEPARATOR . 'manifest.json')
            . '/';
    }
}

define('FLEX_IDX_URI_WP', plugin_dir_url(__FILE__) );
define('FLEX_IDX_URI', ib_get_assets_uri());
define( 'UPLOAD_DIR_WP', trailingslashit( WP_CONTENT_DIR ) . 'uploads/' );
define('IDXBOOST_OVERRIDE_DIR', get_template_directory() . DIRECTORY_SEPARATOR . 'idxboost');

define('FLEX_IDX_BASE_URL', 'https://api.idxboost.com');
define('FLEX_IDX_CPANEL_URL', 'https://cpanel.idxboost.com');
define('FLEX_IDX_BACKOFFICE_CPANEL_URL', 'https://backoffice.idxboost.com');
define('FLEX_IDX_ALERTS_SUBSCRIBE', 'https://alerts.flexidx.com/consumer/subscribe');
define('FLEX_IDX_ALERTS_REGISTER', 'https://alerts.flexidx.com/alert/register');
define('FLEX_IDX_ALERTS_UPDATE', 'https://alerts.flexidx.com/alert/update_alert_parameters');
define('FLEX_IDX_ALERTS_UNREGISTER', 'https://alerts.flexidx.com/alert/unregister');
define('IDX_BOOTS_NICHE', 'https://alerts.flexidx.com/niche/filter/parameters');
define('FLEX_IDX_CPANEL_SINGLE_PROPERTY_URL', 'https://api-single-property.idxboost.com');
define('IDX_BOOST_SPW_BUILDER_SERVICE', 'https://api-cms.idxboost.com');
define('IDX_BOOST_SPW_ASSETS', 'https://idxboost-spw-assets.idxboost.us');
define('FLEX_IDX_SERVICE_SUGGESTIONS', 'https://autocomplete.idxboost.com');
define('IDXBOOST_MATOMO_URL', 'matomo.idxboost.com');

/**
 * API endpoints
 */
define('FLEX_IDX_API_SSO_TOKENS', FLEX_IDX_SSO_URL . '/realms/mci/protocol/openid-connect/token');
define('FLEX_IDX_SINGLE_PROPERTY_COLLECTION_SETTING', FLEX_IDX_CPANEL_SINGLE_PROPERTY_URL . '/api/property-site-setting-get');
define('FLEX_IDX_DISPLAY_FILTER_V3', FLEX_IDX_BASE_URL . '/filter_lookup_v3');
define('FLEX_IDX_DISPLAY_FILTER_V2_old', FLEX_IDX_BASE_URL . '/listings/recentsales');
define('FLEX_IDX_API_AGENT_LISTINGS_SOLD_V2', FLEX_IDX_BASE_URL . '/v2/listings/agent_office_sold');
define('FLEX_IDX_SINGLE_PROPERTY_COLLECTION', FLEX_IDX_CPANEL_SINGLE_PROPERTY_URL . '/api/list-property');
define('FLEX_IDX_GET_SINGLE_PROPERTY', FLEX_IDX_CPANEL_SINGLE_PROPERTY_URL . '/api/property-details');
define('FLEX_IDX_BASE_STATISTICS', FLEX_IDX_BASE_URL . '/listings/recentsales/filter');
define('FLEX_IDX_BASE_STATISTICS_CUSTOM', FLEX_IDX_BASE_URL . '/listings/recentsales/filter_statistics');
define('FLEX_IDX_BASE_TICKET', FLEX_IDX_BASE_URL . '/ticket_new');
define('FLEX_IDX_API_VERIFY_CREDENTIALS', FLEX_IDX_BASE_URL . '/account/verify_credentials');
define('FLEX_IDX_API_GENERATE_NEW_TOKEN', FLEX_IDX_BASE_URL . '/account/generate_access_token');
define('FLEX_IDX_API_IMPORT_DATA', FLEX_IDX_BASE_URL . '/account/import_data');
define('FLEX_IDX_API_GENERATE_TOKEN', FLEX_IDX_BASE_URL . '/oauth/v2/token');
define('FLEX_IDX_API_AUTOCOMPLETE', FLEX_IDX_BASE_URL . '/autocomplete');
define('FLEX_IDX_API_MARKET', FLEX_IDX_BASE_URL . '/filter_lookup');
define('FLEX_IDX_API_DISPLAY_FILTER_V4', FLEX_IDX_BASE_URL . '/filter_lookup_v4');
define('FLEX_IDX_API_MARKET_EXCLUSIVE_LISTINGS', FLEX_IDX_BASE_URL . '/listings/exclusive');
define('FLEX_IDX_API_MARKET_EXCLUSIVE_LISTINGS_COMMERCIAL', FLEX_IDX_BASE_URL . '/listings/commercial/exclusive');
define('FLEX_IDX_API_MARKET_AGENT_OFFICE_LISTINGS_SOLD', FLEX_IDX_BASE_URL . '/listings/agent_office_sold');
define('FLEX_IDX_API_MARKET_AGENT_OFFICE_LISTINGS', FLEX_IDX_BASE_URL . '/listings/agent_office');
define('FLEX_IDX_API_MARKET_RECENT_SALE', FLEX_IDX_BASE_URL . '/listings/recentsales');
define('FLEX_IDX_API_MARKET_COLLECTION', FLEX_IDX_BASE_URL . '/filter_collection_lookup');
define('FLEX_IDX_API_SEARCH', FLEX_IDX_BASE_URL . '/search');
define('FLEX_IDX_API_LOOKUP', FLEX_IDX_BASE_URL . '/property_lookup');
define('FLEX_IDX_API_LOOKUP_OUR_AGENTS', FLEX_IDX_BASE_URL . '/our_agents/{{registrationKey}}'); 
define('FLEX_IDX_API_LOOKUP_GET_AGENTS_DETAIL', FLEX_IDX_BASE_URL . '/agents/idx_get_agents_by_slug/{{registrationKey}}'); 
define('FLEX_IDX_API_LOOKUP_OFF_MARKET_LISTING', FLEX_IDX_BASE_URL . '/lookup_off_market_listing');
define('FLEX_IDX_API_LOOKUP_OFF_MARKET_LISTING_COLLECTION', FLEX_IDX_BASE_URL . '/lookup_off_market_listing_collection');
define('FLEX_IDX_API_BUILDING_LOOKUP', FLEX_IDX_BASE_URL . '/building_lookup');
define('FLEX_IDX_API_BUILDING_LOOKUP_v2', FLEX_IDX_BASE_URL . '/building_lookup_v2');
define('FLEX_IDX_API_BUILDING_COLLECTION_LOOKUP', FLEX_IDX_BASE_URL . '/building_collection_lookup');
define('FLEX_IDX_API_BUILDING_COLLECTION_LOOKUP_v3', FLEX_IDX_BASE_URL . '/v3/building_collection_lookup');
define('FLEX_IDX_API_SUB_AREA_LOOKUP', FLEX_IDX_BASE_URL . '/sub_area_lookup');
define('FLEX_IDX_API_SUB_AREA_COLLECTION_LOOKUP', FLEX_IDX_BASE_URL . '/sub_area_collection_lookup');
define('FLEX_IDX_API_BUILDING_GROUP_LOOKUP', FLEX_IDX_BASE_URL . '/building_group_lookup');
define('FLEX_IDX_API_FAVORITES_LIST', FLEX_IDX_BASE_URL . '/favorites');
define('FLEX_IDX_API_BUILDINGS_LIST', FLEX_IDX_BASE_URL . '/favorites/buildings');
define('FLEX_IDX_API_FAVORITES_RATE', FLEX_IDX_BASE_URL . '/favorites/rate');
define('FLEX_IDX_API_FAVORITES_COMMENT', FLEX_IDX_BASE_URL . '/favorites/comment');
define('FLEX_IDX_API_INQUIRY_PROPERTY_FORM', FLEX_IDX_BASE_URL . '/tracking/property_inquiries');
define('FLEX_IDX_API_INQUIRY_OFF_MARKET_LISTING_FORM', FLEX_IDX_BASE_URL . '/tracking/off_market_listing_inquiries');
define('FLEX_IDX_API_INQUIRY_CONTACT_FORM', FLEX_IDX_BASE_URL . '/tracking/contact_inquiries');
define('FLEX_IDX_API_INQUIRY_AGENT_CONTACT_FORM', FLEX_IDX_BASE_URL . '/tracking/agent_contact_inquiries');
define('FLEX_IDX_API_INQUIRY_BUILDING_FORM', FLEX_IDX_BASE_URL . '/tracking/building_inquiries');
define('FLEX_IDX_API_SCHEDULE_SHOWING_FORM', FLEX_IDX_BASE_URL . '/tracking/schedule_showings');
define('FLEX_IDX_API_FAVORITE_SAVE', FLEX_IDX_BASE_URL . '/tracking/favorites');
define('FLEX_IDX_API_SAVED_SEARCHES_LIST', FLEX_IDX_BASE_URL . '/saved_searches');
define('FLEX_IDX_API_SEARCH_SAVE', FLEX_IDX_BASE_URL . '/tracking/saved_searches');
define('FLEX_IDX_API_SEARCH_UPDATE', FLEX_IDX_BASE_URL . '/tracking/update_searches');
define('FLEX_IDX_API_UPDATE_SEARCH_SAVE_ALERT', FLEX_IDX_BASE_URL . '/saved_searches/update');
define('FLEX_IDX_API_TRACK_PROPERTY_DETAIL', FLEX_IDX_BASE_URL . '/tracking/property_views');
define('FLEX_IDX_API_TRACK_PROPERTY_LOOK_TOKEN', FLEX_IDX_BASE_URL . '/tracking/looking_searches');
define('FLEX_IDX_API_TRACK_UNSUBSCRIBE_LEAD_ALERT', FLEX_IDX_BASE_URL . '/tracking/unsubscribe_lead_alert');
define('FLEX_IDX_API_TRACK_PROPERTY_AGENT_OR_OFFICE', FLEX_IDX_BASE_URL . '/listings/broker');
define('FLEX_IDX_API_HISTORY', FLEX_IDX_BASE_URL . '/building_history_count');
define('FLEX_IDX_API_BUILDING_IMPORT', FLEX_IDX_BASE_URL . '/building/import_data');
define('FLEX_IDX_API_TERMS_CONDITIONS', FLEX_IDX_BASE_URL . '/terms_conditions');
define('FLEX_IDX_API_REGISTER_QUIZZ_SAVE', FLEX_IDX_BASE_URL . '/lead/quizz/save');
define('FLEX_IDX_API_LEAD_HIDE_LISTING', FLEX_IDX_BASE_URL . '/lead/hide/listing');
define('FLEX_IDX_API_SEARCH_V2_LOOKUP', FLEX_IDX_BASE_URL . '/search_lookup');
define('FLEX_IDX_API_COMMERCIAL_SEARCH_V2_LOOKUP', FLEX_IDX_BASE_URL . '/commercial_search_lookup');
define('FLEX_IDX_API_SEARCH_FILTER', FLEX_IDX_BASE_URL . '/search_filter_lookup');
define('FLEX_IDX_API_SEARCH_COMMERCIAL_FILTER', FLEX_IDX_BASE_URL . '/search_commercial_filter_lookup');
define('FLEX_IDX_API_SEARCH_LISTING', FLEX_IDX_BASE_URL . '/listings/{{mlsNumber}}');
define('FLEX_IDX_API_SEARCH_TRACK', FLEX_IDX_BASE_URL . '/listings/{{mlsNumber}}/track');
define('FLEX_IDX_API_SEARCH_FILTER_SAVE', FLEX_IDX_BASE_URL . '/listings/{{filterId}}/save');
define('FLEX_IDX_API_REGULAR_FILTER_SAVE', FLEX_IDX_BASE_URL . '/filter/{{filterId}}/auto_save');
define('FLEX_IDX_API_SHARE_PROPERTY', FLEX_IDX_BASE_URL . '/sharing/{{mlsNumber}}');
define('FLEX_IDX_API_SHARE_BUILDING', FLEX_IDX_BASE_URL . '/building/sharing/{{codBuilding}}');
define('FLEX_IDX_API_REQUEST_INFO_PROPERTY', FLEX_IDX_BASE_URL . '/inquiry/{{mlsNumber}}');
define('FLEX_IDX_API_REQUEST_GET_OFF_MARKET_LISTING', FLEX_IDX_BASE_URL . '/lookup_get_off_market_listing_for_item');
define('FLEX_IDX_API_LEADS_STATUS', FLEX_IDX_BASE_URL . '/leads/status');
define('FLEX_IDX_API_LEADS_LOGIN', FLEX_IDX_BASE_URL . '/leads/login');
define('FLEX_IDX_API_LEADS_SIGNUP', FLEX_IDX_BASE_URL . '/leads/signup');
define('FLEX_IDX_API_LEADS_CHECK_USERNAME', FLEX_IDX_BASE_URL . '/leads/check_username');
define('FLEX_IDX_API_LEADS_CHECK_CREDENTIALS', FLEX_IDX_BASE_URL . '/leads/check_credentials');
define('FLEX_IDX_API_LEADS_UPDATE_SETTINGS', FLEX_IDX_BASE_URL . '/leads/update_settings');
define('FLEX_IDX_API_LEADS_RESET_PASSWORD', FLEX_IDX_BASE_URL . '/reset_password');
define('FLEX_IDX_API_LEADS_GET_RESET_PASSWORD', FLEX_IDX_BASE_URL . '/get_reset_password');
define('FLEX_IDX_API_FETCH_LISTINGS', FLEX_IDX_BASE_URL . '/notifications/listings');
define('FLEX_IDX_API_SHARE_TO_FRIEND', FLEX_IDX_BASE_URL . '/share_to_friend');
define('FLEX_IDX_API_LEAD_SUBMISSION_BUY', FLEX_IDX_BASE_URL . '/leads/submissions/buy');
define('FLEX_IDX_API_LEAD_SUBMISSION_RENT', FLEX_IDX_BASE_URL . '/leads/submissions/rent');
define('FLEX_IDX_API_LEAD_SUBMISSION_SELL', FLEX_IDX_BASE_URL . '/leads/submissions/sell');
define('FLEX_IDX_API_LEAD_SUBMISSION_CONSULTATION', FLEX_IDX_BASE_URL . '/leads/submissions/consultation');
define('FLEX_IDX_API_TRACK_PROPERTY_VIEW', FLEX_IDX_BASE_URL . '/track/property/view');
define('FLEX_IDX_API_LEAD_FETCH_ACTIVITIES', FLEX_IDX_BASE_URL . '/leads/fetch_activities');
define('FLEX_IDX_API_LEAD_HIDE_TOOLTIP', FLEX_IDX_BASE_URL . '/leads/hide/tooltip');
define('FLEX_IDX_API_AGENT_FETCH_CUSTOM_SETTINGS', FLEX_IDX_BASE_URL . '/crm/agents/settings');
define('IDX_BOOST_SPW_BUILDER_SERVICE_AGENT_INFO', IDX_BOOST_SPW_BUILDER_SERVICE . '/api/get-info-agent');
define('IDX_BOOST_SPW_BUILDER_SERVICE_TEAM_PAGE', IDX_BOOST_SPW_BUILDER_SERVICE . '/api/get-team');
define('IDX_BOOST_LEAD_TRACKING_EVENTS', FLEX_IDX_BASE_URL . '/tracking/events');
define('IDX_BOOST_TRACK_COLLECTION_VIEWS', FLEX_IDX_BASE_URL . '/events/collections');
define('IDX_BOOST_UPDATE_CRITERIAL', FLEX_IDX_BASE_URL . '/tracking/update_lead_alert');
define('IDX_BOOST_SCHEMA_SEO', FLEX_IDX_BASE_URL . '/search_post_type');
define('IDXBOOST_LEAD_CHECK_SETTINGS', FLEX_IDX_BASE_URL . '/leads/check_settings');
define('IDX_BOOST_GET_COUNTRY_LEAD', FLEX_IDX_BASE_URL . '/get/ip_lead');

/**
 * Import Third Partie Libraries
 */
require FLEX_IDX_PATH . '/inc/JWT.php';
require FLEX_IDX_PATH . '/idxboost-updater.php';
require FLEX_IDX_PATH . '/idxboost-rest.php';

$flex_idx_token = null;
$flex_idx_info  = null;
$flex_idx_lead  = null;

/**
 * Define helpers
 */
require FLEX_IDX_PATH . '/inc/helpers_fn.php';

/**
 * Define global variables
 */
$flex_idx_info  = flex_idx_get_info();
$flex_idx_token = flex_idx_generate_access_token();
$flex_idx_lead  = is_flex_user_logged_in();


// init scripts for recaptcha

function iboost_print_googlerecaptcha()
{
    global $flex_idx_info;

    if ( is_admin() ) return;

    if (isset($flex_idx_info['agent']['has_enterprise_recaptcha'])) {
        if (!empty($flex_idx_info['agent']['has_enterprise_recaptcha'])) { // is recaptcha enterprise
            if (!isset($flex_idx_info['agent']['recaptcha_site_key']) || empty($flex_idx_info['agent']['recaptcha_site_key'])) {
                return;
            }
            
            $output = <<<HTML
            <script src="https://www.google.com/recaptcha/enterprise.js?render={$flex_idx_info['agent']['recaptcha_site_key']}"></script>
            HTML;
        } else { // regular recaptcha
            if (empty($flex_idx_info['agent']['google_captcha_public_key'])) {
                return;
            }

            $output = <<<HTML
            <script src="https://www.google.com/recaptcha/api.js?render={$flex_idx_info['agent']['google_captcha_public_key']}"></script>
            HTML;
        }
    } else { // regular recaptcha fallback
        if (empty($flex_idx_info['agent']['google_captcha_public_key'])) {
            return;
        }

        $output = <<<HTML
        <script src="https://www.google.com/recaptcha/api.js?render={$flex_idx_info['agent']['google_captcha_public_key']}"></script>
        HTML;
    }

    echo $output;
}

add_action('wp_head', 'iboost_print_googlerecaptcha');


/**
 * Define post types
 */
require FLEX_IDX_PATH . '/inc/posttypes_fn.php';

/**
 * Define actions
 */
require FLEX_IDX_PATH . '/inc/hooks_fn.php';

/**
 * Define shortcodes
 */
require FLEX_IDX_PATH . '/inc/shortcodes_fn.php';

/**
 * Define hooks for activation and deactivation plugin
 */
register_activation_hook(__FILE__, 'flex_idx_on_activation');
register_deactivation_hook(__FILE__, 'flex_idx_on_deactivation');
register_uninstall_hook(__FILE__, 'flex_idx_on_uninstall');
add_action('after_switch_theme', 'flex_idx_on_activation');

// plugin updater
$IDXBoostUpdater = new IDXBoostUpdater(__FILE__);
$IDXBoostUpdater->set_username('idxboost');
$IDXBoostUpdater->set_repository('idxboost');
$IDXBoostUpdater->initialize();
