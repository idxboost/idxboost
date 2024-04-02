<?php
if ( ! function_exists( 'flex_idx_setup_pages_fn' ) ) {
    function flex_idx_setup_pages_fn()
    {
        $current_user_id = get_current_user_id();
        $post_status     = 'publish';
        $post_type       = 'flex-idx-pages';

        $flex_idx_pages = array(
            0 => array(
                'post_title' => 'Advanced Search Form',
                'post_name' => 'search',
                'post_content' => '[ib_search]',
                'post_status' => $post_status,
                'post_author' => $current_user_id,
                'post_type' => $post_type,
                '_flex_id_page' => 'flex_idx_search'
            ),
            1 => array(
                'post_title' => 'Property Details',
                'post_name' => 'property',
                'post_content' => '[flex_idx_property_detail]',
                'post_status' => $post_status,
                'post_author' => $current_user_id,
                'post_type' => $post_type,
                '_flex_id_page' => 'flex_idx_property_detail'
            ),
            3 => array(
                'post_title' => 'My Saved Properties',
                'post_name' => 'my-saved-properties',
                'post_content' => '[flex_idx_favorites]',
                'post_status' => $post_status,
                'post_author' => $current_user_id,
                'post_type' => $post_type,
                '_flex_id_page' => 'flex_idx_favorites'
            ),
            4 => array(
                'post_title' => 'My Saved Searches',
                'post_name' => 'my-saved-searches',
                'post_content' => '[flex_idx_saved_searches]',
                'post_status' => $post_status,
                'post_author' => $current_user_id,
                'post_type' => $post_type,
                '_flex_id_page' => 'flex_idx_saved_searches'
            ),
            5 => array(
                'post_title' => 'My Saved Buildings',
                'post_name' => 'my-saved-buildings',
                'post_content' => '[flex_idx_buildings]',
                'post_status' => $post_status,
                'post_author' => $current_user_id,
                'post_type' => $post_type,
                '_flex_id_page' => 'flex_idx_saved_buildings'
            ),
            6 => array(
                'post_title' => 'My Profile',
                'post_name' => 'my-profile',
                'post_content' => '[flex_idx_profile]',
                'post_status' => $post_status,
                'post_author' => $current_user_id,
                'post_type' => $post_type,
                '_flex_id_page' => 'flex_idx_profile'
            ),
            7 => array(
                'post_title' => 'Terms and Conditions',
                'post_name' => 'terms-and-conditions',
                'post_content' => '[idxboost_terms_conditions]',
                'post_status' => $post_status,
                'post_author' => $current_user_id,
                'post_type' => $post_type,
                '_flex_id_page' => 'flex_idx_terms_conditions'
            )
        );


        if (false == get_option('idxboost_dinamic_pages')) {
            $wp_flex_page = wp_insert_post(array(
                'post_title' => 'Contact Page',
                'post_name' => 'contact',
                'post_content' => '[idxboost_contact_page]',
                'post_status' => $post_status,
                'post_author' => $current_user_id,
                'post_type' => $post_type
            ));

            update_post_meta($wp_flex_page, '_flex_id_page', 'flex_idx_page_contact');

            $wp_flex_page = wp_insert_post(array(
                'post_title' => 'Team Page',
                'post_name' => 'team',
                'post_content' => '[idxboost_team_page]',
                'post_status' => $post_status,
                'post_author' => $current_user_id,
                'post_type' => $post_type
            ));

            update_post_meta($wp_flex_page, '_flex_id_page', 'flex_idx_page_team');

            $wp_flex_page = wp_insert_post(array(
                'post_title' => 'Our Properties',
                'post_name' => 'our-properties',
                'post_content' => '[list_property_collection column="two"]',
                'post_status' => $post_status,
                'post_author' => $current_user_id,
                'post_type' => $post_type
            ));

            update_post_meta($wp_flex_page, '_flex_id_page', 'flex_idx_page_our_property_collection');
            
            add_option('idxboost_dinamic_pages', 'yes');
        }

        if (false == get_option('idxboost_import_initial_pages')) {
            foreach ($flex_idx_pages as $flex_idx_page) {
                $wp_flex_page = wp_insert_post(array(
                    'post_title' => $flex_idx_page['post_title'],
                    'post_name' => $flex_idx_page['post_name'],
                    'post_content' => $flex_idx_page['post_content'],
                    'post_status' => $flex_idx_page['post_status'],
                    'post_author' => $flex_idx_page['post_author'],
                    'post_type' => $flex_idx_page['post_type']
                ));

                update_post_meta($wp_flex_page, '_flex_id_page', $flex_idx_page['_flex_id_page']);
            }

            add_option('idxboost_import_initial_pages', 'yes');
        }

        if (false == get_option('idxboost_accesibility_initial_pages')) {
            $wp_flex_page = wp_insert_post(array(
                'post_title' => 'Accessibility',
                'post_name' => 'accessibility',
                'post_content' => '[idxboost_accesibility]',
                'post_status' => $post_status,
                'post_author' => $current_user_id,
                'post_type' => $post_type
            ));

            update_post_meta($wp_flex_page, '_flex_id_page', 'flex_idx_accesibility');
            add_option('idxboost_accesibility_initial_pages', 'yes');
        }

        if (false == get_option('idxboost_building_initial_pages')) {
            $wp_flex_page = wp_insert_post(array(
                'post_title' => 'building',
                'post_name' => 'building',
                'post_content' => '',
                'post_status' => $post_status,
                'post_author' => $current_user_id,
                'post_type' => $post_type
            ));

            update_post_meta($wp_flex_page, '_flex_id_page', 'flex_idx_building');
            add_option('idxboost_building_initial_pages', 'yes');
        }

        if (false == get_option('idxboost_sub_area_initial_pages')) {
            $wp_flex_page = wp_insert_post(array(
                'post_title' => 'Sub Area',
                'post_name' => 'sub-area',
                'post_content' => '',
                'post_status' => $post_status,
                'post_author' => $current_user_id,
                'post_type' => $post_type
            ));

            update_post_meta($wp_flex_page, '_flex_id_page', 'flex_idx_sub_area');
            add_option('idxboost_sub_area_initial_pages', 'yes');
        }

        if (false == get_option('idxboost_off_market_listings_initial_pages')) {
            $wp_flex_page = wp_insert_post(array(
                'post_title' => 'Off market listings',
                'post_name' => 'off-market-listing',
                'post_content' => '',
                'post_status' => $post_status,
                'post_author' => $current_user_id,
                'post_type' => $post_type
            ));

            update_post_meta($wp_flex_page, '_flex_id_page', 'flex_idx_off_market_listing');
            add_option('idxboost_off_market_listings_initial_pages', 'yes');
        }

        if (false == get_option('idxboost_init_pages')) {
            $page_home = wp_insert_post(array(
                'post_title' => 'Home',
                'post_name' => 'home',
                'post_content' => '',
                'post_status' => $post_status,
                'post_author' => $current_user_id,
                'post_type' => "page"
            ));

            update_option('show_on_front', "page");
            update_option('page_on_front', $page_home);

            $page_blog = wp_insert_post(array(
                'post_title' => 'Blog',
                'post_name' => 'blog',
                'post_content' => '',
                'post_status' => $post_status,
                'post_author' => $current_user_id,
                'post_type' => "page"
            ));

            update_option('page_for_posts', $page_blog);

            $page_buy = wp_insert_post(array(
                'post_title' => 'I Want To Buy',
                'post_name' => 'buy',
                'post_content' => '[idxboost_buyers_form]',
                'post_status' => $post_status,
                'post_author' => $current_user_id,
                'post_type' => "page"
            ));

            update_post_meta($page_buy, '_wp_page_template', 'page/forms-buy-sell-rent.php');

            $page_sell = wp_insert_post(array(
                'post_title' => 'I Want To Sell',
                'post_name' => 'sell',
                'post_content' => '[idxboost_sellers_form]',
                'post_status' => $post_status,
                'post_author' => $current_user_id,
                'post_type' => "page"
            ));

            update_post_meta($page_sell, '_wp_page_template', 'page/forms-buy-sell-rent.php');

            $page_rent = wp_insert_post(array(
                'post_title' => 'I Want To Rent',
                'post_name' => 'rent',
                'post_content' => '[idxboost_rentals_form]',
                'post_status' => $post_status,
                'post_author' => $current_user_id,
                'post_type' => "page"
            ));

            update_post_meta($page_rent, '_wp_page_template', 'page/forms-buy-sell-rent.php');

            $page_sell = wp_insert_post(array(
                'post_title' => 'Exclusive Listings',
                'post_name' => 'exclusive-listings',
                'post_content' => '',
                'post_status' => $post_status,
                'post_author' => $current_user_id,
                'post_type' => "flex-filter-pages"
            ));

            update_post_meta($page_sell, '_flex_filter_page_fl', '2');

            $page_rent = wp_insert_post(array(
                'post_title' => 'Sold Properties',
                'post_name' => 'sold-properties',
                'post_content' => '',
                'post_status' => $post_status,
                'post_author' => $current_user_id,
                'post_type' => "flex-filter-pages"
            ));

            update_post_meta($page_rent, '_flex_filter_page_fl', '1');
            add_option('idxboost_init_pages', 'yes');
        }
    }
}

function function_single_idx_off_market_listings($single_template)
{
    global $post;

    if ($post->post_type == 'idx-off-market') {
        if (file_exists(IDXBOOST_OVERRIDE_DIR . '/views/shortcode/single-off-market-listings.php')) {
            $single_template = IDXBOOST_OVERRIDE_DIR . '/views/shortcode/single-off-market-listings.php';
        } else {
            $single_template = FLEX_IDX_PATH . '/views/shortcode/single-off-market-listings.php';
        }
    }

    return $single_template;
}
add_filter('single_template', 'function_single_idx_off_market_listings');

function function_single_building($single_template)
{
    global $post;

    if ($post->post_type == 'flex-idx-building') {
        if (file_exists(IDXBOOST_OVERRIDE_DIR . '/views/shortcode/single-building.php')) {
            $single_template = IDXBOOST_OVERRIDE_DIR . '/views/shortcode/single-building.php';
        } else {
            $single_template = FLEX_IDX_PATH . '/views/shortcode/single-building.php';
        }
    }
    return $single_template;
}
add_filter('single_template', 'function_single_building');

function function_single_sub_area($single_template)
{
    global $post;

    if ($post->post_type == 'idx-sub-area') {
        if (file_exists(IDXBOOST_OVERRIDE_DIR . '/views/shortcode/single-sub-area.php')) {
            $single_template = IDXBOOST_OVERRIDE_DIR . '/views/shortcode/single-sub-area.php';
        } else {
            $single_template = FLEX_IDX_PATH . '/views/shortcode/single-sub-area.php';
        }
    }

    return $single_template;
}
add_filter('single_template', 'function_single_sub_area');

function function_idx_agent_page($single_template)
{
    global $flex_idx_info, $post, $wp;

    if ($post->post_type == 'idx-agents') {
        $wp_request     = $wp->request;
        $wp_request_exp = explode('/', $wp_request);

        if ($post->post_type == 'idx-agents') {
            if (1 == count($wp_request_exp)) {
                // For regular agent
                /*
                if (
                    isset($flex_idx_info['agent']['has_cms']) &&
                    $flex_idx_info['agent']['has_cms'] &&
                    isset($flex_idx_info['agent']['has_cms_team']) &&
                    $flex_idx_info['agent']['has_cms_team'] &&
                    isset($flex_idx_info['agent']['has_crm']) &&
                    !$flex_idx_info['agent']['has_crm']
                ) {
                    $single_template = FLEX_IDX_PATH . '/views/shortcode/idxboost_cms_page_agent.php';
                } else {
                    // For broker agent, home and defaults
                    $single_template = FLEX_IDX_PATH . '/views/shortcode/single-idx-agents-home.php';
                }
                */
                $single_template = FLEX_IDX_PATH . '/views/shortcode/idxboost_cms_page_agent.php';
            } else {
                list($agent_slug_name, $agent_page_name) = $wp_request_exp;

                if (3 === count($wp_request_exp)) {
                    if ('property' === $agent_page_name) {
                        $single_template = FLEX_IDX_PATH . '/views/shortcode/single-idx-agents-property.php';
                    } else {
                        $service_type = end($wp_request_exp);

                        switch ($service_type) {
                            case 'i-want-to-buy':
                                $single_template = FLEX_IDX_PATH . '/views/shortcode/single-idx-agents-want-to-buy.php';
                                break;
                            case 'i-want-to-rent':
                                $single_template = FLEX_IDX_PATH . '/views/shortcode/single-idx-agents-want-to-rent.php';
                                break;
                            case 'i-want-to-sell':
                                $single_template = FLEX_IDX_PATH . '/views/shortcode/single-idx-agents-want-to-sell.php';
                                break;
                            case 'property-management':
                                $single_template = FLEX_IDX_PATH . '/views/shortcode/single-idx-agents-property-management.php';
                                break;
                        }
                    }
                } else {
                    switch ($agent_page_name) {
                        case 'search':
                            $single_template = FLEX_IDX_PATH . '/views/shortcode/single-idx-agents-search.php';
                            break;

                        case 'featured-properties':
                            $single_template = FLEX_IDX_PATH . '/views/shortcode/single-idx-agents-listings.php';
                            break;

                        case 'recently-sold':
                            $single_template = FLEX_IDX_PATH . '/views/shortcode/single-idx-agents-sold-listings.php';
                            break;

                        case 'about':
                            $single_template = FLEX_IDX_PATH . '/views/shortcode/single-idx-agents-about.php';
                            break;

                        case 'contact':
                            $single_template = FLEX_IDX_PATH . '/views/shortcode/single-idx-agents-contact.php';
                            break;

                        default:
                            // for home and defaults
                            $single_template = FLEX_IDX_PATH . '/views/shortcode/single-idx-agents-home.php';
                            break;
                    }
                }
            }
        }
    }

    return $single_template;
}
add_filter('single_template', 'function_idx_agent_page');

function function_single_filter_page($single_template)
{
    global $post;

    if ($post->post_type == 'flex-filter-pages') {
        $single_template = FLEX_IDX_PATH . '/views/shortcode/single-flex-filter-pages.php';
    }

    return $single_template;
}
add_filter('single_template', 'function_single_filter_page');

function function_single_landing_filter_page($single_template)
{
    global $post;

    if ($post->post_type == 'flex-landing-pages') {
        $single_template = FLEX_IDX_PATH . '/views/shortcode/single-flex-landing-pages.php';
    }

    return $single_template;
}
add_filter('single_template', 'function_single_landing_filter_page');

function function_single_idx_page($single_template)
{
    global $post;

    if ($post->post_type == 'flex-idx-pages') {
        $single_template = FLEX_IDX_PATH . '/views/shortcode/single-flex-idx-pages.php';
    }

    return $single_template;
}
add_filter('single_template', 'function_single_idx_page');

//TITULO_PAGE
function func_filter_id()
{
    add_meta_box('tit-meta-box', 'Building ID', 'func_build_filterid', 'flex-idx-building', 'side', 'high');
}

function func_build_filterid($post)
{
    $flex_building_page_id = get_post_meta($post->ID, '_flex_building_page_id', true);
?>
    <input name="_flex_building_page_id" class="widefat" type="text" value="<?php echo $flex_building_page_id; ?>">
<?php
}
add_action('add_meta_boxes', 'func_filter_id');

function func_sub_area_filter_id()
{
    add_meta_box('tit-meta-box', 'Sub Area ID', 'func_sub_area_build_filterid', 'idx-sub-area', 'side', 'high');
}

function func_sub_area_build_filterid($post)
{
    $flex_building_page_id = get_post_meta($post->ID, '_flex_building_page_id', true);
?>
    <input name="_flex_building_page_id" class="widefat" type="text" value="<?php echo $flex_building_page_id; ?>">
<?php
}
add_action('add_meta_boxes', 'func_sub_area_filter_id');

function custom_save_filterid_build_subarea($post_id, $post)
{
    // return if autosave
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }

    // Check the user's permissions.
    if (!current_user_can('edit_post', $post_id)) {
        return;
    }

    if (isset($_POST['_flex_building_page_id'])) {
        update_post_meta($post_id, '_flex_building_page_id', sanitize_text_field($_POST['_flex_building_page_id']));
    }
}
add_action('save_post_idx-sub-area', 'custom_save_filterid_build_subarea', 10, 2);

/*OFF MARKET LISTINGS*/
function func_filter_id_off_market_listings()
{
    add_meta_box('tit-meta-box', 'Token ID', 'func_filterid_off_market_listing', 'idx-off-market', 'side', 'high');
}

function func_filterid_off_market_listing($post)
{
    $flex_building_page_id = get_post_meta($post->ID, '_flex_token_listing_page_id', true);
?>
    <input name="_flex_token_listing_page_id" class="widefat" type="text" value="<?php echo $flex_building_page_id; ?>">
    <?php
}
add_action('add_meta_boxes', 'func_filter_id_off_market_listings');
/*OFF MARKET LISTINGS*/

if ( ! function_exists( 'flex_filter_page_metaboxes_save' ) ) {
    function flex_filter_page_metaboxes_save($post_id)
    {
        global $wpdb;

        if (!isset($_POST['flex_filter_page_meta_box_nonce']) || !wp_verify_nonce($_POST['flex_filter_page_meta_box_nonce'], basename(__FILE__))) {
            return;
        }

        // return if autosave
        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
            return;
        }

        // Check the user's permissions.
        if (!current_user_can('edit_post', $post_id)) {
            return;
        }

        if (isset($_POST['_flex_filter_page_id'])) {
            update_post_meta($post_id, '_flex_filter_page_id', sanitize_text_field($_POST['_flex_filter_page_id']));
        }

        if (isset($_POST['_flex_filter_page_fl'])) {
            update_post_meta($post_id, '_flex_filter_page_fl', sanitize_text_field($_POST['_flex_filter_page_fl']));
        }

        if (isset($_POST['_flex_filter_page_references'])) {
            update_post_meta($post_id, '_flex_filter_page_references', sanitize_text_field($_POST['_flex_filter_page_references']));
        } else {
            update_post_meta($post_id, '_flex_filter_page_references', sanitize_text_field('0'));
        }

        if (isset($_POST['_flex_filter_page_show_home'])) {
            $wpdb->query("DELETE FROM {$wpdb->postmeta} WHERE meta_key = '_flex_filter_page_show_home'");

            update_post_meta($post_id, '_flex_filter_page_show_home', sanitize_text_field($_POST['_flex_filter_page_show_home']));
        }
    }

    add_action('save_post_flex-filter-pages', 'flex_filter_page_metaboxes_save', 10, 2);
}

function custom_save_filterid_build($post_id, $post)
{
    // return if autosave
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }

    // Check the user's permissions.
    if (!current_user_can('edit_post', $post_id)) {
        return;
    }

    if (isset($_POST['_flex_building_page_id'])) {
        update_post_meta($post_id, '_flex_building_page_id', sanitize_text_field($_POST['_flex_building_page_id']));
    }
}
add_action('save_post_flex-idx-building', 'custom_save_filterid_build', 10, 2);


function custom_save_filterid_off_market_listing($post_id, $post)
{
    // return if autosave
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }

    // Check the user's permissions.
    if (!current_user_can('edit_post', $post_id)) {
        return;
    }

    if (isset($_POST['_flex_token_listing_page_id'])) {
        update_post_meta($post_id, '_flex_token_listing_page_id', sanitize_text_field($_POST['_flex_token_listing_page_id']));
    }
}
add_action('save_post_idx-off-market', 'custom_save_filterid_off_market_listing', 10, 2);
//FIN TITLE_PAGE

if ( ! function_exists( 'flex_filter_page_id_cb' ) ) {
    function flex_filter_page_id_cb($post)
    {
        wp_nonce_field(basename(__FILE__), 'flex_filter_page_meta_box_nonce');

        // retrieve the _food_cholesterol current value
        $flex_filter_page_id = get_post_meta($post->ID, '_flex_filter_page_id', true);
    ?>
        <div class="inside">
            <input type="text" class="widefat" name="_flex_filter_page_id" value="<?php echo esc_html__($flex_filter_page_id); ?>">
        </div>
    <?php
    }
}

if ( ! function_exists( 'flex_filter_page_fl_cb' ) ) {
    function flex_filter_page_fl_cb($post)
    {
        wp_nonce_field(basename(__FILE__), 'flex_filter_page_meta_box_nonce');

        $flex_filter_page_fl = get_post_meta($post->ID, '_flex_filter_page_fl', true);
        if ("" == $flex_filter_page_fl) {
            $flex_filter_page_fl = 3;
        }
    ?>
        <div class="inside">
            <p><input type="radio" name="_flex_filter_page_fl" <?php checked($flex_filter_page_fl, 3); ?> value="3">
                Default</p>
            <p><input type="radio" name="_flex_filter_page_fl" <?php checked($flex_filter_page_fl, 1); ?> value="1">
                Recent Sales</p>
            <p><input type="radio" name="_flex_filter_page_fl" <?php checked($flex_filter_page_fl, 2); ?> value="2">
                Exclusive Listings</p>
            <p><input type="radio" name="_flex_filter_page_fl" <?php checked($flex_filter_page_fl, 0); ?> value="0">
                Hide Search Bar</p>
        </div>
    <?php
    }
}

if ( ! function_exists( 'flex_filter_page_references_fl_cb' ) ) {
    function flex_filter_page_references_fl_cb($post)
    {
        wp_nonce_field(basename(__FILE__), 'flex_filter_page_meta_box_nonce');

        $flex_filter_page_refrences = get_post_meta($post->ID, '_flex_filter_page_references', true);
        if ("" == $flex_filter_page_refrences) {
            $flex_filter_page_refrences = '0';
        }
    ?>
        <input type="checkbox" name="_flex_filter_page_references" value="1" <?php if (!empty($flex_filter_page_refrences) && $flex_filter_page_refrences == "1") {
                                                                                    echo "checked";
                                                                                } ?>> Active
    <?php
    }
}

if ( ! function_exists( 'flex_filter_page_show_home_cb' ) ) {
    function flex_filter_page_show_home_cb($post)
    {
        wp_nonce_field(basename(__FILE__), 'flex_filter_page_meta_box_nonce');

        $flex_filter_page_show_home = (int)get_post_meta($post->ID, '_flex_filter_page_show_home', true);
    ?>
        <div class="inside">
            <input type="checkbox" name="_flex_filter_page_show_home" <?php checked($flex_filter_page_show_home, 1); ?> value="1"> Show as featured in Homepage
        </div>
    <?php
    }
}

if ( ! function_exists( 'flex_filter_page_metaboxes' ) ) {
    function flex_filter_page_metaboxes($post)
    {
        add_meta_box('flex_filter_page_id', 'ID - Filter Page', 'flex_filter_page_id_cb', 'flex-filter-pages', 'side');
        add_meta_box('flex_filter_featured_page', 'Listing Type - Filter Page', 'flex_filter_page_fl_cb', 'flex-filter-pages', 'side');
        add_meta_box('flex_filter_references_active', 'References Page', 'flex_filter_page_references_fl_cb', 'flex-filter-pages', 'side');
        add_meta_box('flex_filter_show_in_home', 'Featured Listing - Filter Page', 'flex_filter_page_show_home_cb', 'flex-filter-pages', 'side');
    }
}
add_action('add_meta_boxes_flex-filter-pages', 'flex_filter_page_metaboxes');

if ( ! function_exists( 'flex_filter_page_metaboxes_save' ) ) {
    function flex_filter_page_metaboxes_save($post_id)
    {
        global $wpdb;

        if (!isset($_POST['flex_filter_page_meta_box_nonce']) || !wp_verify_nonce($_POST['flex_filter_page_meta_box_nonce'], basename(__FILE__))) {
            return;
        }

        // return if autosave
        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
            return;
        }

        // Check the user's permissions.
        if (!current_user_can('edit_post', $post_id)) {
            return;
        }

        if (isset($_POST['_flex_filter_page_id'])) {
            update_post_meta($post_id, '_flex_filter_page_id', sanitize_text_field($_POST['_flex_filter_page_id']));
        }

        if (isset($_POST['_flex_filter_page_fl'])) {
            update_post_meta($post_id, '_flex_filter_page_fl', sanitize_text_field($_POST['_flex_filter_page_fl']));
        }

        if (isset($_POST['_flex_filter_page_show_home'])) {
            $wpdb->query("DELETE FROM {$wpdb->postmeta} WHERE meta_key = '_flex_filter_page_show_home'");

            update_post_meta($post_id, '_flex_filter_page_show_home', sanitize_text_field($_POST['_flex_filter_page_show_home']));
        }
    }

    add_action('save_post_flex-filter-pages', 'flex_filter_page_metaboxes_save', 10, 2);
}

if ( ! function_exists( 'flex_idx_posttype_pages_pre_get_posts_fn' ) ) {
    function flex_idx_posttype_pages_pre_get_posts_fn($query)
    {
        if (!$query->is_main_query() || 2 != count($query->query) || !isset($query->query['page'])) {
            return;
        }

        if (!empty($query->query['name'])) {
            $query->set('post_type', array_merge(array('post', 'page'), array('flex-idx-pages', 'flex-filter-pages', 'flex-landing-pages', 'idx-agents')));
        }
    }

    add_action('pre_get_posts', 'flex_idx_posttype_pages_pre_get_posts_fn');
}

function iboost_remove_front_slug_types($post_link, $post, $leavename)
{
    if (false === in_array($post->post_type, ['flex-idx-pages', 'flex-filter-pages', 'flex-landing-pages', 'idx-agents']) || 'publish' !== $post->post_status) {
        return $post_link;
    }

    if (is_numeric($post->post_parent) && $post->post_parent > 0) {
        //$post_link = str_replace('/' . $post->post_type . '/', '/', $post_link);
    } else {
        $post_link = str_replace('/' . $post->post_type . '/', '/', $post_link);
    }

    return $post_link;
}
add_filter('post_type_link', 'iboost_remove_front_slug_types', 10, 3);

//POST_TYPE_ALERT_PAGE
function idx_alerts_page()
{
    register_post_type('idx-alerts-page', array(
        'public' => true,
        'has_archive' => true,
        'exclude_from_search' => true,
        'show_ui' => false,
        'show_in_nav_menus' => false,
        'show_in_menu' => false,
        'show_in_admin_bar' => false,
        'label' => 'IDX Settings Alert',
        'capabilities' => array(
            'create_posts' => false,
            'edit_post' => 'edit_flex_idx_alerts_page',
            'delete_post' => false
        ),
        'rewrite' => '/',
        'supports' => array('title'),
        'capability_type' => 'post',
    ));

    $current_user_id      = get_current_user_id();
    $post_status          = 'publish';
    $post_type            = 'idx-alerts-page';
    $flex_idx_pages_alert = array(
        0 => array(
            'post_title'  => 'flx-unsubscribe',
            'post_name'   => 'flx-unsubscribe',
            'post_status' => $post_status,
            'post_author' => $current_user_id,
            'post_type'   => $post_type,
        ),
        1 => array(
            'post_title'  => 'flx-edit-information',
            'post_name'   => 'flx-edit-information',
            'post_status' => $post_status,
            'post_author' => $current_user_id,
            'post_type'   => $post_type,
        ),
    );

    if (false == get_option('flex_idx_imported_initial_alerts')) {
        foreach ($flex_idx_pages_alert as $flex_idx_page_alert) {
            wp_insert_post(array(
                'post_title' => $flex_idx_page_alert['post_title'],
                'post_name' => $flex_idx_page_alert['post_name'],
                'post_status' => $flex_idx_page_alert['post_status'],
                'post_author' => $flex_idx_page_alert['post_author'],
                'post_type' => $flex_idx_page_alert['post_type'],
            ));
        }
    }

    add_option('flex_idx_imported_initial_alerts', 'yes');
}
add_action('init', 'idx_alerts_page');

function function_single_alerts($single_template)
{
    global $post;

    if ($post->post_type == 'idx-alerts-page') {
        $single_template = FLEX_IDX_PATH . '/views/notification/SwitchEmailFrequency.php';
    }

    return $single_template;
}
add_filter('single_template', 'function_single_alerts');

function idx_add_role_alerts()
{
    $admins = get_role('administrator');
    $admins->add_cap('edit_flex_idx_alerts_page');
}
add_action('admin_init', 'idx_add_role_alerts');
//POST_TYPE_ALERT_PAGE

//ADD_COLOR
function idx_style_add_role()
{
    $admins = get_role('administrator');
    $admins->add_cap('edit_flex_idx_building');
}
add_action('admin_init', 'idx_style_add_role');

$my_post    = array('post_title' => wp_strip_all_tags('Plugin Style'), 'post_content' => '', 'post_status' => 'publish', 'post_type' => 'idx-style');
$argumento  = array('post_type' => 'idx-style', 'post_status' => 'publish');
$wp_contact = new WP_Query($argumento);

if (!$wp_contact->have_posts()) {
    wp_insert_post($my_post);
}

function func_idx_meta_style()
{
    add_meta_box('idx-style-meta-box', __('Style Plugin'), 'func_idx_style', 'idx-style', 'normal', 'high', array('arg' => 'value'));
}

function func_idx_style($post)
{
    wp_nonce_field('cyb_meta_box', 'cyb_meta_box_idx_style');

    $post_meta              = get_post_custom($post->ID);
    $idx_style_boton        = '';
    $idx_style_texto        = '';
    $idx_style_body         = '';
    $idx_style_second_color = '';

    if (isset($post_meta['idx_style_second_color'][0])) {
        $idx_style_second_color = $post_meta['idx_style_second_color'][0];
    }

    if (isset($post_meta['idx_style_boton'][0])) {
        $idx_style_boton = $post_meta['idx_style_boton'][0];
    }

    if (isset($post_meta['idx_style_texto'][0])) {
        $idx_style_texto = $post_meta['idx_style_texto'][0];
    }

    if (isset($post_meta['idx_style_body'][0])) {
        $idx_style_body = $post_meta['idx_style_body'][0];
    }

    if (isset($post_meta['idx_select_image'][0])) {
        $idx_select_image = $post_meta['idx_select_image'][0];
    }

    if (isset($post_meta['idx_style_search_bar_body'][0])) {
        $idx_style_search_bar_body = $post_meta['idx_style_search_bar_body'][0];
    }

    if (isset($post_meta['idx_style_search_bar_bose'][0])) {
        $idx_style_search_bar_bose = $post_meta['idx_style_search_bar_bose'][0];
    }

    if (isset($post_meta['idx_style_search_bar_texto'][0])) {
        $idx_style_search_bar_texto = $post_meta['idx_style_search_bar_texto'][0];
    }

    if (isset($post_meta['idx_style_text_color'][0])) {
        $idx_style_text_color = $post_meta['idx_style_text_color'][0];
    }

    ?>
    <link rel="stylesheet" href="<?php echo FLEX_IDX_URI; ?>/css/vendor/color-picker.min.css" />
    <script src="<?php echo FLEX_IDX_URI; ?>/js/vendor/color-picker.min.js"></script>
    <div class="item_object">
        <label>Primary Plugin Color</label>
        <input class="idx_style_boton" name="idx_style_boton" id="idx_style_1" placeholder="#000000" type="text" value="<?php echo esc_attr($idx_style_boton); ?>">
        <div class="change_button" id="change_button_1" bo="1">Select Color</div>
    </div>

    <div class="item_object">
        <label>Secondary Plugin Color</label>
        <input class="idx_style_boton" name="idx_style_second_color" id="idx_style_6" placeholder="#000000" type="text" value="<?php echo esc_attr($idx_style_second_color); ?>">
        <div class="change_button" id="change_button_6" bo="6">Select Color</div>
    </div>

    <div class="item_object">
        <label>Text Color</label>
        <input class="idx_style_boton" name="idx_style_text_color" id="idx_style_7" placeholder="#000000" type="text" value="<?php echo esc_attr($idx_style_text_color); ?>">
        <div class="change_button" id="change_button_7" bo="7">Select Color</div>
    </div>

    <div class="item_object">
        <label>Headlines</label>
        <input class="idx_style_texto" name="idx_style_texto" id="idx_style_2" placeholder="#000000" type="text" value="<?php echo esc_attr($idx_style_texto); ?>">
        <div class="change_button" id="change_button_2" bo="2">Select Color</div>
    </div>

    <div class="item_object">
        <label>Body Text</label>
        <input class="idx_style_body" name="idx_style_body" id="idx_style_3" placeholder="#000000" type="text" value="<?php echo esc_attr($idx_style_body); ?>">
        <div class="change_button" id="change_button_3" bo="3">Select Color</div>
    </div>
    <div class="item_object">
        <label>search bar Text</label>
        <input class="idx_style_search_bar_texto" name="idx_style_search_bar_texto" id="idx_style_4" placeholder="#000000" type="text" value="<?php echo esc_attr($idx_style_search_bar_texto); ?>">
        <div class="change_button" id="change_button_4" bo="4">Select Color</div>
    </div>

    <div class="item_object">
        <label>search bar Background</label>
        <select name="idx_style_search_bar_bose" id="idx_style_search_bar_bose">
            <option value="transparent" <?php if (esc_attr($idx_style_search_bar_bose) == "transparent") {
                                            echo "selected";
                                        }
                                        ?>>transparent
            </option>
            <option value="fill" <?php if (esc_attr($idx_style_search_bar_bose) == "fill") {
                                        echo "selected";
                                    }
                                    ?>>fill
            </option>
        </select>
        <input class="idx_style_search_bar_body" name="idx_style_search_bar_body" id="idx_style_5" placeholder="#000000" type="text" value="<?php echo esc_attr($idx_style_search_bar_body); ?>">
        <div class="change_button" id="change_button_5" bo="5">Select Color</div>
    </div>

    <div class="item_object">
        <label>Favorites Button Style </label>
        <label><input type="radio" class="idx_select_image_heart" name="idx_select_image" value="corazon.png" <?php if (esc_attr($idx_select_image) == 'corazon.png') {
                                                                                                                    echo "checked";
                                                                                                                }
                                                                                                                ?>> Heart</label>
        <label><input type="radio" class="idx_select_image_square" name="idx_select_image" value="cuadrado.png" <?php if (esc_attr($idx_select_image) == 'cuadrado.png') {
                                                                                                                    echo "checked";
                                                                                                                }
                                                                                                                ?>> Square</label>
    </div>

    <div class="item_object">
        <div class="change_button_default" id="button_default">Default (Back to original)</div>
    </div>
    <div class="item_object">
        <iframe src="<?php echo FLEX_IDX_URI; ?>/preview_plugin/iframe_preview.html" id="iframeID" style="width:100%;height:1200px;"></iframe>
    </div>
    <style type="text/css">
        .change_button,
        .change_button_default {
            display: inline-block;
            background-color: gray;
            border-radius: 20px;
            width: 112px;
            text-align: center;
            color: white;
            padding: 5px;
            cursor: pointer;
        }

        .item_object input,
        .item_object .change_button {
            display: inline-block;
        }

        .item_object {
            margin-bottom: 20px;
        }

        .change_button:hover,
        .button_on,
        .change_button_default:hover {
            background-color: #403131;
        }

        div#button_default {
            width: 190px;
            right: 0px;
            position: relative;
        }
    </style>
    <script type="text/javascript">
        function hexToRgbNew(hex) {
            hex = hex.replace('#', '');
            var arrBuff = new ArrayBuffer(4);
            var vw = new DataView(arrBuff);
            vw.setUint32(0, parseInt(hex, 16), false);
            var arrByte = new Uint8Array(arrBuff);
            return 'rgba(' + arrByte[1] + ', ' + arrByte[2] + ', ' + arrByte[3] + ', 0.5)';
        }

        jQuery('#idx_style_search_bar_bose, input[name=idx_select_image]').change(function() {
            func_preview();
        });

        function func_preview() {
            var status_search = '';
            var style_search_bar_texto = '';
            var style_body_point_status_search = '';
            var style_boton_point = '';
            var style_texto_point = '';
            var select_image_point = '';
            if (jQuery('#idx_style_search_bar_bose').val() == 'transparent') status_search = hexToRgbNew(jQuery('#idx_style_5').val());
            else status_search = jQuery('#idx_style_5').val();
            if ((jQuery('.idx_style_texto').length) > 0) style_texto_point = 'h2.title-block.single{ color: ' + jQuery('.idx_style_texto').val() + '; } ';
            if ((jQuery('input[name=idx_select_image]:checked').length) > 0) select_image_point = '#wrap-result.view-grid #result-search .propertie .clidxboost-btn-check span:before, #wrap-result.view-grid .result-search .propertie .clidxboost-btn-check span:before, .wrap-result.view-grid #result-search .propertie .clidxboost-btn-check span:before, .wrap-result.view-grid .result-search .propertie .clidxboost-btn-check span:before{background-image: url("/wp-content/themes/flexidx/images/' + jQuery('input[name=idx_select_image]:checked').val() + '"); }';
            if ((jQuery('.idx_style_boton').length) > 0) style_boton_point = ' #wrap-filters #all-filters #mini-filters>li .wrap-item .wrap-checks ul li input:checked+label:after, #wrap-filters #all-filters #mini-filters>li.action-filter #apply-filters-min, #wrap-filters #all-filters #mini-filters>li .wrap-item .wrap-range .range-slide .ui-slider-range, #wrap-filters #all-filters #mini-filters>li.cities #cities-list li.active, #wrap-filters #all-filters #mini-filters>li.cities #cities-list li:hover, #wrap-filters #all-filters #mini-filters>li.filter-box .wrap-item #submit-ms-min:before, #wrap-filters #all-filters #mini-filters>li.filter-box .wrap-item .list-type-sr li button.active, #wrap-filters #all-filters #mini-filters>li.filter-box .wrap-item .list-type-sr li button:hover, .property-details.theme-3 .property-information.ltd li.rent:hover, .property-details.theme-3 .property-information.ltd li.sale:hover, .property-details.theme-3 .property-information.ltd li.sold:hover, .property-details.theme-3 .property-information.ltd li.sale:hover, .property-details.theme-3 .property-information.ltd li.active-fbc.rent, .property-details.theme-3 .property-information.ltd li.active-fbc.sale, .property-details.theme-3 .property-information.ltd li.active-fbc.sold, .tabs-btn li.active, .tabs-btn li:hover, #wrap-filters #filters li button.refresh-btn span:hover, #wrap-filters #filters li button.save-btn span:hover, #result-search .propertie .wrap-slider .next span, #result-search .propertie .wrap-slider .prev span, .wrap-result.view-grid #result-search .propertie .wrap-slider .next span, .wrap-result.view-grid #result-search .propertie .wrap-slider .prev, .wrap-result.view-grid .result-search .propertie .wrap-slider .next, .wrap-result.view-grid .result-search .propertie .wrap-slider .prev, #wrap-filters #filters>li.mini-search form #submit-ms input[type=submit], #slider-properties .nav .bullets button.active span:before, #slider-testimonial .nav .bullets button.active span:before, #wrap-result #nav-results #principal-nav li.active, #wrap-result #nav-results #principal-nav li:hover, #wrap-result #nav-results .arrow:hover, #wrap-result #nav-results .ad:hover, #wrap-result .nav-results .ad:hover, .wrap-result #nav-results .ad:hover, .wrap-result .nav-results .ad:hover { background-color: ' + jQuery('.idx_style_boton').val() + ' !important; } #wrap-subfilters #sub-filters #filter-views ul li.active, #wrap-filters #filters li button>span.clidxboost-icon-arrow-select:before, #wrap-filters #all-filters #mini-filters>li .wrap-item .wrap-select:before, .main-content .list-details.active .title-amenities:before, .main-content .list-details.active .title-details:before, .main-content .list-details .title-amenities:before, .main-content .list-details .title-details:before { color: ' + jQuery('.idx_style_boton').val() + '; } #wrap-filters #filters li.active:after{border-bottom-color: ' + jQuery('.idx_style_boton').val() + '; } #wrap-filters #all-filters #mini-filters{ border-top-color: ' + jQuery('.idx_style_boton').val() + '; }';
            if ((jQuery('#idx_style_5').length) > 0) style_body_point_status_search = ' #flex-bubble-search{ background-color: ' + status_search + ';}';
            if ((jQuery('.idx_style_search_bar_texto').length) > 0) style_search_bar_texto = '#flex-bubble-search input{ color: ' + jQuery('.idx_style_search_bar_texto').val() + '; } ';
            jQuery('#iframeID').contents().find('body').append('<style type="text/css">' + style_texto_point + select_image_point + style_boton_point + style_body_point_status_search + style_search_bar_texto + '</style>');
        }

        jQuery(window).on("load", function() {
            jQuery('.change_button').click(function() {
                jQuery('.color-picker').remove();
                if (jQuery(this).hasClass('button_on')) {
                    jQuery(this).removeClass('button_on');
                    jQuery(this).text('Select Color');
                    func_preview();
                } else {
                    jQuery(this).addClass('button_on');
                    jQuery(this).text('click to Preview');
                    var texto_id_input = '#idx_style_' + jQuery(this).attr('bo');
                    var button_id_input = 'change_button_' + jQuery(this).attr('bo');
                    var picker = new CP(jQuery(texto_id_input).get(0), false),
                        button = document.getElementById(button_id_input),
                        button_html = button.innerHTML;
                    picker.on("change", function(color) {
                        this.target.value = "#" + color;
                    });
                    picker[picker.visible ? "exit" : "enter"]();
                }
            });
            jQuery('#button_default').click(function() {
                jQuery('.idx_style_boton').val('');
                jQuery('.idx_style_texto').val('');
                jQuery('.idx_style_body').val('');
                jQuery('.idx_style_search_bar_body').val('');
                jQuery('.idx_style_search_bar_texto').val('');
                jQuery("input[name=idx_select_image][value='corazon.png']").prop("checked", true);
                func_preview();
            });

            func_preview();
        });
    </script>
<?php
}
add_action('add_meta_boxes', 'func_idx_meta_style');

function func_idx_save_style($post_id, $post)
{
    if (isset($_POST['idx_style_boton'])) {
        update_post_meta($post_id, 'idx_style_boton', sanitize_text_field($_POST['idx_style_boton']));
    } else
        if (isset($post_id)) {
        delete_post_meta($post_id, 'idx_style_boton');
    }

    if (isset($_POST['idx_style_second_color'])) {
        update_post_meta($post_id, 'idx_style_second_color', sanitize_text_field($_POST['idx_style_second_color']));
    } else
        if (isset($post_id)) {
        delete_post_meta($post_id, 'idx_style_second_color');
    }

    if (isset($_POST['idx_style_texto'])) {
        update_post_meta($post_id, 'idx_style_texto', sanitize_text_field($_POST['idx_style_texto']));
    } else
        if (isset($post_id)) {
        delete_post_meta($post_id, 'idx_style_texto');
    }

    if (isset($_POST['idx_style_body'])) {
        update_post_meta($post_id, 'idx_style_body', sanitize_text_field($_POST['idx_style_body']));
    } else
        if (isset($post_id)) {
        delete_post_meta($post_id, 'idx_style_body');
    }

    if (isset($_POST['idx_select_image'])) {
        update_post_meta($post_id, 'idx_select_image', sanitize_text_field($_POST['idx_select_image']));
    } else
        if (isset($post_id)) {
        delete_post_meta($post_id, 'idx_select_image');
    }

    if (isset($_POST['idx_style_search_bar_body'])) {
        update_post_meta($post_id, 'idx_style_search_bar_body', sanitize_text_field($_POST['idx_style_search_bar_body']));
    } else
        if (isset($post_id)) {
        delete_post_meta($post_id, 'idx_select_image');
    }

    if (isset($_POST['idx_style_search_bar_texto'])) {
        update_post_meta($post_id, 'idx_style_search_bar_texto', sanitize_text_field($_POST['idx_style_search_bar_texto']));
    } else
        if (isset($post_id)) {
        delete_post_meta($post_id, 'idx_style_search_bar_texto');
    }

    if (isset($_POST['idx_style_text_color'])) {
        update_post_meta($post_id, 'idx_style_text_color', sanitize_text_field($_POST['idx_style_text_color']));
    } else
        if (isset($post_id)) {
        delete_post_meta($post_id, 'idx_style_text_color');
    }

    if (isset($_POST['idx_style_search_bar_bose'])) {
        update_post_meta($post_id, 'idx_style_search_bar_bose', sanitize_text_field($_POST['idx_style_search_bar_bose']));
    } else
        if (isset($post_id)) {
        delete_post_meta($post_id, 'idx_style_search_bar_bose');
    }
}
add_action('save_post', 'func_idx_save_style', 10, 2);
//FIN DE LOS CAMPOS

function convert_rgba($hex)
{
    list($r, $g, $b) = sscanf($hex, "#%02x%02x%02x");
    return 'rgba(' . $r . ', ' . $g . ', ' . $b . ', 0.5)';
}

function idx_func_style_on()
{
    $my_post                                           = array('post_title' => wp_strip_all_tags('style plugin idx'), 'post_content' => '', 'post_status' => 'publish', 'post_type' => 'idx-style');
    $argumento                                         = array('post_type' => 'idx-style', 'post_status' => 'publish');
    $wp_contact                                        = new WP_Query($argumento);
    $count_ite                                         = 0;
    $idx_style_second_color_point                      = '';
    $style_texto_point                                 = '';
    $select_image_point                                = '';
    $style_boton_point                                 = '';
    $style_body_point_rgba_transparent                 = '';
    $style_search_bar_texto                            = '';
    $idx_style_texto_theme_point                       = '';
    $idx_style_body_text_theme_point                   = '';
    $idx_style_search_bar_bose_theme_transparent_point = '';
    $style_title_galery                                = '';
    $image_footer_firt                                 = '';
    $image_footer_second                               = '';
    $image_footer_third                                = '';
    $idx_style_plugin_sec_pri                          = '';

    while ($wp_contact->have_posts()) : $wp_contact->the_post();
        $custom_fields = get_post_custom();

        if (empty($custom_fields['idx_style_boton'][0])) {
            $idx_style_boton_point = '';
        } else {
            $idx_style_boton_point = $custom_fields['idx_style_boton'][0];
        }

        if (empty($custom_fields['idx_style_second_color'][0])) {
            $idx_style_second_color = '';
        } else {
            $idx_style_second_color = $custom_fields['idx_style_second_color'][0];
        }

        if (empty($custom_fields['idx_style_texto'][0])) {
            $idx_style_texto_point = '';
        } else {
            $idx_style_texto_point = $custom_fields['idx_style_texto'][0];
        }

        if (empty($custom_fields['idx_style_body'][0])) {
            $idx_style_body_point = '';
        } else {
            $idx_style_body_point = $custom_fields['idx_style_body'][0];
        }

        if (empty($custom_fields['idx_style_search_bar_bose'][0])) {
            $idx_style_search_bar_bose = '';
        } else {
            $idx_style_search_bar_bose = $custom_fields['idx_style_search_bar_bose'][0];
        }

        if (empty($custom_fields['idx_style_search_bar_body'][0])) {
            $idx_style_search_bar_body = '';
        } else {
            $idx_style_search_bar_body = $custom_fields['idx_style_search_bar_body'][0];
        }

        if (empty($custom_fields['idx_style_search_bar_body'][0])) {
            $idx_style_search_bar_body = '';
        } else {
            $idx_style_search_bar_body = $custom_fields['idx_style_search_bar_body'][0];
        }

        if (empty($custom_fields['idx_style_search_bar_texto'][0])) {
            $idx_style_search_bar_texto = '';
        } else {
            $idx_style_search_bar_texto = $custom_fields['idx_style_search_bar_texto'][0];
        }

        if (empty($custom_fields['idx_style_text_color'][0])) {
            $idx_style_text_color = '';
        } else {
            $idx_style_text_color = $custom_fields['idx_style_text_color'][0];
        }

        $idx_select_image = '/wp-content/themes/flexidx/images/' . $custom_fields['idx_select_image'][0];
        $count_ite++;
    endwhile;

    if ($idx_style_search_bar_bose == 'transparent') {
        $idx_style_body_point_rgba_transparent = convert_rgba($idx_style_search_bar_body);
    } else {
        $idx_style_body_point_rgba_transparent = $idx_style_search_bar_body;
    }

    if (strlen(($idx_style_texto_point)) > 0) {
        $style_texto_point = 'h2.title-block.single, .title-conteiner .title-page { color: ' . $idx_style_texto_point . '; } ';
    }

    $color_second = '';
    $color_primary = '';
    $color_texto = '';

    if (strlen($idx_style_second_color) > 0) {
        $color_second = $idx_style_second_color;
    }

    if (strlen(($idx_style_boton_point)) > 0) {
        $color_primary = $idx_style_boton_point;
    }

    if (strlen(($idx_style_text_color)) > 0) {
        $color_texto = $idx_style_text_color;
    }

    $idx_style_plugin_sec_pri = '
        #slider-main .nav .bullets button.active span:before,
        #slider-properties .nav .bullets button.active span:before,
        #slider-testimonial .nav .bullets button.active span:before,
        .clidxboost-btn-link span,
        .flex-newsletter-content,
        .special-hover>li>a:before,
        .social-networks li:before,
        .message-alert p button:hover{  background-color: ' . $color_primary . '; }
        .form-content .gform_body .gform_button {
            border-color: ' . $color_primary . ';
            color: ' . $color_texto . ';
            background-color: ' . $color_primary . ';
        }
        .form-content .gform_body .gform_button:hover {
            border-color: ' . $color_second . ';
            color: ' . $color_texto . ';
            background-color: ' . $color_second . ';
        }
        #menu-main .sub-menu li a:hover,
        .form_content .btn_form {
        background-color: ' . $color_primary . '; }
        border-color: ' . $color_primary . '; }
        }
        #available-languages li.active:after {
        border-top: 7px solid ' . $color_primary . ';
        }
        .flex-newsletter-content .flex-content-form li .button:hover {
        background-color: ' . $color_primary . ';
        border-color: ' . $color_second . ';
        color: white;
        }
        .clidxboost-btn-link span{ border: 1px solid ' . $color_primary . '; color: ' . $color_texto . '; }
        #wrap-subfilters #sub-filters #filter-by.clidxboost-icon-arrow-select:before, #wrap-subfilters #sub-filters #filter-views.clidxboost-icon-arrow-select:before{ color: ' . $color_primary . '; }
        .message-alert.info-color {
        background-color: ' . $color_primary . ';
        border-color: ' . $color_primary . ';
        }
        #view-list .tbl_properties_wrapper table {
            border-top: 2px solid ' . $color_primary . ';
        }
        .clidxboost-btn-link span.active, .clidxboost-btn-link span:hover, .message-alert p button {
            background-color: ' . $color_second . ';
            color: ' . $color_texto . ';
            border-color: ' . $color_second . ';
        }
        .flex-newsletter-content .flex-content-form li .button {
        border: 1px solid ' . $color_second . ';
        background-color: ' . $color_second . ';
        color: white;
        }
        .form_content .btn_form:hover{
        border-color: ' . $color_second . ';
        background-color: ' . $color_second . ';
        }
        .modal_cm .header-tab li a.active, .modal_cm .header-tab li a:focus,
        .modal_cm .header-tab li a:hover {
            border-bottom: 2px solid ' . $color_primary . ';
        }
        @media screen and (min-width: 768px){
        #wrap-filters #all-filters.individual #mini-filters {
            border-top: 3px solid ' . $color_primary . ';
        }
        }
        .show_modal_login_active .menu_login_active ul li a:hover {
            background-color: ' . $color_primary . ';
            border-color: ' . $color_primary . ';
        }
    ';

    if (strlen($idx_style_second_color) > 0) {
        $idx_style_second_color_point = '
        defs radialGradient:nth-child(1) stop{ stop-color: ' . $idx_style_second_color . ' !important; } .dgt-richmarker-group:after, .dgt-richmarker-single:after{ border-top: 5px solid ' . $idx_style_second_color . ' !important; } .mapview-container .mapviwe-header, .dgt-richmarker-group, .dgt-richmarker-single, .mapview-container .mapviwe-header .closeInfo, #wrap-result #nav-results #principal-nav li.active, #wrap-result #nav-results #principal-nav li:hover, #wrap-result #nav-results .arrow:hover, #wrap-result #nav-results .ad:hover,.mapview-container .mapviwe-header .build, .mapview-container .mapviwe-body::-webkit-scrollbar-thumb, .mapview-container .mapviwe-body::-webkit-scrollbar, .dgt-richmarker-group:before, .cir-sta.sale {background-color: ' . $idx_style_second_color . ' !important; }';
    }

    if (strlen(($idx_select_image)) > 0) {
        $select_image_point = '#wrap-result.view-grid #result-search .propertie .clidxboost-btn-check span:before, #wrap-result.view-grid .result-search .propertie .clidxboost-btn-check span:before, .wrap-result.view-grid #result-search .propertie .clidxboost-btn-check span:before, .wrap-result.view-grid .result-search .propertie .clidxboost-btn-check span:before{background-image: url("' . $idx_select_image . '"); }';
    }

    if (strlen(($idx_style_boton_point)) > 0) {
        $style_boton_point = '
        .cir-sta.rent{ background-color: ' . $idx_style_boton_point . '; }
        defs radialGradient:nth-child(2) stop{ stop-color:' . $idx_style_boton_point . ' !important; } #wrap-filters #all-filters #mini-filters>li .wrap-item .wrap-checks ul li input:checked+label:after, #wrap-filters #all-filters #mini-filters>li.action-filter #apply-filters-min, #wrap-filters #all-filters #mini-filters>li .wrap-item .wrap-range .range-slide .ui-slider-range, #wrap-filters #all-filters #mini-filters>li.cities #cities-list li.active, #wrap-filters #all-filters #mini-filters>li.cities #cities-list li:hover, #wrap-filters #all-filters #mini-filters>li.filter-box .wrap-item #submit-ms-min:before, #wrap-filters #all-filters #mini-filters>li.filter-box .wrap-item .list-type-sr li button.active, #wrap-filters #all-filters #mini-filters>li.filter-box .wrap-item .list-type-sr li button:hover, .property-details.theme-3 .property-information.ltd li.rent:hover, .property-details.theme-3 .property-information.ltd li.sale:hover, .property-details.theme-3 .property-information.ltd li.sold:hover, .property-details.theme-3 .property-information.ltd li.sale:hover, .property-details.theme-3 .property-information.ltd li.active-fbc.rent, .property-details.theme-3 .property-information.ltd li.active-fbc.sale, .property-details.theme-3 .property-information.ltd li.active-fbc.sold, .tabs-btn li.active, .tabs-btn li:hover, #wrap-filters #filters li button.refresh-btn span:hover, #wrap-filters #filters li button.save-btn span:hover, #result-search .propertie .wrap-slider .next span, #result-search .propertie .wrap-slider .prev span, .wrap-result.view-grid #result-search .propertie .wrap-slider .next span, .wrap-result.view-grid #result-search .propertie .wrap-slider .prev, .wrap-result.view-grid .result-search .propertie .wrap-slider .next, .wrap-result.view-grid .result-search .propertie .wrap-slider .prev, #wrap-filters #filters>li.mini-search form #submit-ms input[type=submit], #slider-properties .nav .bullets button.active span:before, #slider-testimonial .nav .bullets button.active span:before, #wrap-result .nav-results .ad:hover, .wrap-result #nav-results .ad:hover, .wrap-result .nav-results .ad:hover,
         #wrap-subfilters #sub-filters #filter-views ul li.active, #wrap-filters #filters li button>span.clidxboost-icon-arrow-select:before, #wrap-filters #all-filters #mini-filters>li .wrap-item .wrap-select:before, .main-content .list-details.active .title-amenities:before, .main-content .list-details.active .title-details:before, .main-content .list-details .title-amenities:before, .main-content .list-details .title-details:before { color: ' . $idx_style_boton_point . '; } #wrap-filters #filters li.active:after{border-bottom-color: ' . $idx_style_boton_point . '; } #wrap-filters #all-filters #mini-filters{ border-top-color: ' . $idx_style_boton_point . '; }';
    }

    if (strlen(($idx_style_body_point_rgba_transparent)) > 0) {
        $style_body_point_rgba_transparent = ' #flex-bubble-search{ background-color: ' . $idx_style_body_point_rgba_transparent . ';}';
    }

    if (strlen(($idx_style_search_bar_texto)) > 0) {
        $style_search_bar_texto = '#flex-bubble-search input{ color: ' . $idx_style_search_bar_texto . '; } ';
    }

    if (strlen((wp_get_attachment_url(get_option('footer_media_first_id')))) > 0) {
        $image_footer_firt = 'li.logo-footer img { content: url("' . wp_get_attachment_url(get_option('footer_media_first_id')) . '"); }';
    } else {
        $image_footer_firt = '';
    }
    if (strlen((wp_get_attachment_url(get_option('footer_media_second_id')))) > 0) {
        $image_footer_second = 'li.company-parnet img.realtor_footer { content: url("' . wp_get_attachment_url(get_option('footer_media_second_id')) . '"); }';
    } else {
        $image_footer_second = '';
    }
    if (strlen((wp_get_attachment_url(get_option('footer_media_third')))) > 0) {
        $image_footer_third = 'li.company-parnet img.realtor_footer_2 { content: url("' . wp_get_attachment_url(get_option('footer_media_third')) . '"); }';
    } else {
        $image_footer_third = '';
    }

    $argumento_theme = array('post_type' => 'idx-style-theme', 'post_status' => 'publish');
    $wp_contact_theme = new WP_Query($argumento_theme);

    while ($wp_contact_theme->have_posts()) : $wp_contact_theme->the_post();
        $custom_fields                   = get_post_custom();
        $idx_style_texto_theme           = $custom_fields['idx_style_texto_theme'][0];
        $idx_style_body_text_theme       = $custom_fields['idx_style_body_text_theme'][0];
        $idx_style_search_bar_bose_theme = $custom_fields['idx_style_search_bar_bose_theme'][0];
        $idx_style_search_bar_body_theme = $custom_fields['idx_style_search_bar_body_theme'][0];
        $post_thumbnail_id               = get_post_thumbnail_id(get_the_ID());
        $post_thumbnail_url              = wp_get_attachment_url($post_thumbnail_id);
    endwhile;

    wp_reset_postdata();

    if (strlen(($idx_style_texto_theme)) > 0) {
        $idx_style_texto_theme_point = '#header .wrap-options #user-options>li.login a, #header .wrap-options #user-options>li.register a, #header .wrap-menu nav ul li a { color: ' . $idx_style_texto_theme . '; } ';
    }
    if (strlen(($idx_style_body_text_theme)) > 0) {
        $idx_style_body_text_theme_point = '.flex-block-description, .flex-site-description li, .flex-footer-content .gwr .flex-company-site li.submenu-site .submenu-footer li a, .flex-footer-content .gwr .flex-company-site li { color: ' . $idx_style_body_text_theme . ' !important; } ';
    }

    if ($idx_style_search_bar_bose_theme == 'transparent') {
        $idx_style_search_bar_bose_theme_transparent = convert_rgba($idx_style_search_bar_body_theme);
    } else {
        $idx_style_search_bar_bose_theme_transparent = $idx_style_search_bar_body_theme;
    }

    if (strlen(($idx_style_search_bar_bose_theme_transparent)) > 0) {
        $idx_style_search_bar_bose_theme_transparent_point = ' .flex-newsletter-content{ background-color: ' . $idx_style_search_bar_bose_theme_transparent . ';}';
    }

    if (strlen(($post_thumbnail_url)) > 0) {
        $style_title_galery = '#header .wrap-menu .logo-content img.logo, #header .wrap-menu .menu-responsive .logo { content: url("' . $post_thumbnail_url . '"); }';
    } else {
        $style_title_galery = '#header .wrap-menu .logo-content img.logo { content: url("' . FLEX_IDX_URI . 'preview_plugin/images/logo.png"); }';
    }

    echo '<style type="text/css">' .
        $idx_style_second_color_point .
        $style_texto_point .
        $select_image_point .
        $style_boton_point .
        $style_body_point_rgba_transparent .
        $style_search_bar_texto .
        $idx_style_texto_theme_point .
        $idx_style_body_text_theme_point .
        $idx_style_search_bar_bose_theme_transparent_point .
        $style_title_galery .
        $image_footer_firt .
        $image_footer_second .
        $image_footer_third .
        $idx_style_plugin_sec_pri .
        ' </style>';
}
//add_action('wp_footer', 'idx_func_style_on');

/*THEME_STYLE_CUSTOMIZER*/
function idx_style_theme_func()
{
    $labels_theme_style = array('name' => 'Configuration Theme Style', 'menu_name' => 'Theme Style', 'name_admin_bar' => 'Theme Style', 'edit_item' => 'Edit Theme Style');
    register_post_type('idx-style-theme', array('public' => true, 'has_archive' => false, 'exclude_from_search' => true, 'show_ui' => true, 'show_in_nav_menus' => true, 'show_in_menu' => true, 'show_in_admin_bar' => false, 'labels' => $labels_theme_style, 'rewrite' => false, 'capabilities' => array('create_posts' => false, 'edit_post' => 'edit_flex_idx_theme_style', 'delete_post' => false), 'supports' => array('thumbnail'), 'capability_type' => 'post'));
}
// add_action('init', 'idx_style_theme_func');

function idx_style_add_theme_role()
{
    $admins = get_role('administrator');
    $admins->add_cap('edit_flex_idx_theme_style');
}
// add_action('admin_init', 'idx_style_add_theme_role');

/*$my_post_theme   = array('post_title' => wp_strip_all_tags('Theme Style'), 'post_content' => '', 'post_status' => 'publish', 'post_type' => 'idx-style-theme');
$argumento_theme = array('post_type' => 'idx-style-theme', 'post_status' => 'publish');
$wp_theme_arg    = new WP_Query($argumento_theme);
if (!$wp_theme_arg->have_posts()) {
    wp_insert_post($my_post_theme);
}
wp_reset_postdata();*/

function func_idx_meta_style_theme()
{
    add_meta_box('idx-style-meta-box', __('Style Theme'), 'func_idx_style_theme', 'idx-style-theme', 'side', 'high', array('arg' => 'value'));
}

function func_idx_style_theme($post)
{
    add_action('admin_footer', 'media_selector_print_scripts');
    wp_nonce_field('cyb_meta_box', 'cyb_meta_box_idx_style_theme');

    $post_meta       = get_post_custom($post->ID);
    $idx_style_boton = '';
    $idx_style_texto = '';
    $idx_style_body  = '';

    if (isset($post_meta['idx_style_texto_theme'][0])) {
        $idx_style_texto_theme = $post_meta['idx_style_texto_theme'][0];
    }

    if (isset($post_meta['idx_style_body_text_theme'][0])) {
        $idx_style_body_text_theme = $post_meta['idx_style_body_text_theme'][0];
    }

    if (isset($post_meta['idx_style_search_bar_bose_theme'][0])) {
        $idx_style_search_bar_bose_theme = $post_meta['idx_style_search_bar_bose_theme'][0];
    }

    if (isset($post_meta['idx_style_search_bar_body_theme'][0])) {
        $idx_style_search_bar_body_theme = $post_meta['idx_style_search_bar_body_theme'][0];
    }

?>
    <link rel="stylesheet" href="<?php echo FLEX_IDX_URI; ?>/css/vendor/color-picker.min.css" />
    <script src="<?php echo FLEX_IDX_URI; ?>/js/vendor/color-picker.min.js"></script>
    <div class="item_object">
        <label>Color Text Menu</label>
        <input class="idx_style_texto_theme" name="idx_style_texto_theme" id="idx_style_2" placeholder="#000000" type="text" value="<?php echo esc_attr($idx_style_texto_theme); ?>">
        <div class="change_button" id="change_button_2" bo="2">Select Color</div>
    </div>

    <div class="item_object">
        <label>Body Text</label>
        <input class="idx_style_body_text_theme" name="idx_style_body_text_theme" id="idx_style_3" placeholder="#000000" type="text" value="<?php echo esc_attr($idx_style_body_text_theme); ?>">
        <div class="change_button" id="change_button_3" bo="3">Select Color</div>
    </div>
    <div class="item_object">
        <label>Footer bar Background</label>
        <select name="idx_style_search_bar_bose_theme" id="idx_style_search_bar_bose_theme">
            <option value="transparent" <?php if (esc_attr($idx_style_search_bar_bose) == "transparent") {
                                            echo "selected";
                                        }
                                        ?>>transparent
            </option>
            <option value="fill" <?php if (esc_attr($idx_style_search_bar_bose) == "fill") {
                                        echo "selected";
                                    }
                                    ?>>fill
            </option>
        </select>
        <input class="idx_style_search_bar_body_theme" name="idx_style_search_bar_body_theme" id="idx_style_5" placeholder="#000000" type="text" value="<?php echo esc_attr($idx_style_search_bar_body_theme); ?>">
        <div class="change_button" id="change_button_5" bo="5">Select Color</div>
    </div>

    <div class="item_object">
        <div class="change_button_default" id="button_default">Default (Back to original)</div>
        <div class="change_button_default" id="button_sent">Send to Preview</div>
    </div>

    <div class="item_object">
        <?php wp_enqueue_media(); ?>
        <div class='image-preview-wrapper'>
            <img id='image-preview-first' src='<?php echo wp_get_attachment_url(get_option('footer_media_first_id')); ?>' height='100'>
        </div>
        <input id="upload_image_button" conjun="#footer_image_first" previ="#image-preview-first" type="button" class="button" value="<?php _e('Footer Logo'); ?>" />
        <input type='hidden' name='footer_image_first' id='footer_image_first' value='<?php echo get_option('footer_media_first_id'); ?>'>
    </div>

    <div class="item_object">
        <?php wp_enqueue_media(); ?>
        <div class='image-preview-wrapper'>
            <img id='image-preview-second' src='<?php echo wp_get_attachment_url(get_option('footer_media_second_id')); ?>' height='100'>
        </div>
        <input id="upload_image_button_second" type="button" previ="#image-preview-second" conjun="#footer_image_second" class="button" value="<?php _e('Broker Logo 1'); ?>" />
        <input type='hidden' name='footer_image_second' id='footer_image_second' value='<?php echo get_option('footer_media_second_id'); ?>'>
    </div>

    <div class="item_object">
        <?php wp_enqueue_media(); ?>
        <div class='image-preview-wrapper'>
            <img id='image-preview-third' src='<?php echo wp_get_attachment_url(get_option('footer_media_third')); ?>' height='100'>
        </div>
        <input id="upload_image_button_third" type="button" previ="#image-preview-third" conjun="#footer_image_third" class="button" value="<?php _e('Broker Logo 2'); ?>" />
        <input type='hidden' name='footer_image_third' id='footer_image_third' value='<?php echo get_option('footer_media_third'); ?>'>
    </div>

    <div class="item_object">
        <iframe src="<?php echo FLEX_IDX_URI; ?>preview_plugin/iframe_theme.html" id="iframeID" style="width:100%;height:550px;"></iframe>
    </div>
    <style type="text/css">
        .item_object img {
            max-width: 150px;
            height: auto;
        }

        .change_button,
        .change_button_default {
            display: inline-block;
            background-color: gray;
            border-radius: 20px;
            width: 112px;
            text-align: center;
            color: white;
            padding: 5px;
            cursor: pointer;
        }

        .item_object input,
        .item_object .change_button {
            display: inline-block;
        }

        .item_object {
            margin-bottom: 20px;
        }

        .change_button:hover,
        .button_on,
        .change_button_default:hover {
            background-color: #403131;
        }

        div#button_default {
            width: 190px;
            right: 0px;
            position: relative;
        }
    </style>
    <script type="text/javascript">
        function hexToRgbNew(hex) {
            hex = hex.replace('#', '');
            var arrBuff = new ArrayBuffer(4);
            var vw = new DataView(arrBuff);
            vw.setUint32(0, parseInt(hex, 16), false);
            var arrByte = new Uint8Array(arrBuff);
            return 'rgba(' + arrByte[1] + ', ' + arrByte[2] + ', ' + arrByte[3] + ', 0.5)';
        }

        jQuery('#idx_style_search_bar_bose_theme, input[name=idx_select_image]').change(function() {
            func_preview();
        });

        function func_preview() {
            var status_search = '';
            var style_body_point_status_search = '';
            var style_boton_point = '';
            var style_texto_point = '';
            var style_title_menu = '';
            var style_title_galery = '';
            var image_footer_firt = '';
            var image_footer_second = '';
            var image_footer_third = '';

            if ((jQuery('.idx_style_texto_theme').length) > 0) style_texto_point = '#header .wrap-options #user-options>li.login a, #header .wrap-options #user-options>li.register a, #header .wrap-menu nav ul li a { color: ' + jQuery('.idx_style_texto_theme').val() + '; } ';
            if (jQuery('#idx_style_search_bar_bose_theme').val() == 'transparent') status_search = hexToRgbNew(jQuery('#idx_style_5').val());
            else status_search = jQuery('#idx_style_5').val();

            if (jQuery('#image-preview-first').attr('src').length > 0) {
                image_footer_firt = 'li.logo-footer img { content: url("' + jQuery('#image-preview-first').attr('src') + '"); }';
            } else {
                image_footer_firt = '';
            }
            if (jQuery('#image-preview-second').attr('src').length > 0) {
                image_footer_second = 'li.company-parnet img.realtor_footer { content: url("' + jQuery('#image-preview-second').attr('src') + '"); }';
            } else {
                image_footer_second = '';
            }
            if (jQuery('#image-preview-third').attr('src').length > 0) {
                image_footer_third = 'li.company-parnet img.realtor_footer_2 { content: url("' + jQuery('#image-preview-third').attr('src') + '"); }';
            } else {
                image_footer_third = '';
            }

            if ((jQuery('#idx_style_5').val().length) > 0) style_body_point_status_search = ' .flex-newsletter-content{ background-color: ' + status_search + ';}';
            if ((jQuery('#idx_style_3').val().length) > 0) style_title_menu = '.flex-block-description, .flex-site-description li, .flex-footer-content .gwr .flex-company-site li.submenu-site .submenu-footer li a, .flex-footer-content .gwr .flex-company-site li { color: ' + jQuery('#idx_style_3').val() + ' !important; }';
            if ((jQuery('.thickbox img').attr('src')) != undefined) style_title_galery = '#header .wrap-menu .logo-content img.logo { content: url("' + jQuery('.thickbox img').attr('src') + '"); }';
            else style_title_galery = '#header .wrap-menu .logo-content img.logo { content: url("<?php echo FLEX_IDX_URI; ?>preview_plugin/images/logo.png"); }';
            //if ((jQuery('.idx_style_search_bar_texto').length)>0 ) style_search_bar_texto='#flex-bubble-search input{ color: '+jQuery('.idx_style_search_bar_texto').val()+'; } ';
            jQuery('#iframeID').contents().find('body').append('<style type="text/css">' + style_texto_point + style_boton_point + style_body_point_status_search + style_title_menu + style_title_galery + image_footer_firt + image_footer_second + image_footer_third + '</style>');
        }

        jQuery(window).on("load", function() {
            jQuery('#postimagediv h2.hndle.ui-sortable-handle span').text("Logo Theme");
            jQuery('.change_button').click(function() {
                jQuery('.color-picker').remove();
                if (jQuery(this).hasClass('button_on')) {
                    jQuery(this).removeClass('button_on');
                    jQuery(this).text('Select Color');
                    func_preview();
                } else {
                    jQuery(this).addClass('button_on');
                    jQuery(this).text('click to Preview');
                    var texto_id_input = '#idx_style_' + jQuery(this).attr('bo');
                    var button_id_input = 'change_button_' + jQuery(this).attr('bo');
                    var picker = new CP(jQuery(texto_id_input).get(0), false),
                        button = document.getElementById(button_id_input),
                        button_html = button.innerHTML;
                    picker.on("change", function(color) {
                        this.target.value = "#" + color;
                    });
                    picker[picker.visible ? "exit" : "enter"]();
                }
            });


            jQuery('#button_sent').click(function() {
                func_preview();
            });

            jQuery('#button_default').click(function() {
                jQuery('#idx_style_2').val('');
                jQuery('#idx_style_3').val('');
                jQuery('#idx_style_5').val('');
                func_preview();
            });

            func_preview();

            jQuery('#_thumbnail_id').change(function() {
                console.log(jQuery('.thickbox img').attr('src'));
            });

        });
    </script>
<?php
}
// add_action('add_meta_boxes', 'func_idx_meta_style_theme');

function func_idx_save_style_theme($post_id, $post)
{
    if (isset($_POST['idx_style_texto_theme'])) {
        update_post_meta($post_id, 'idx_style_texto_theme', sanitize_text_field($_POST['idx_style_texto_theme']));
    } else
        if (isset($post_id)) {
        delete_post_meta($post_id, 'idx_style_texto_theme');
    }

    if (isset($_POST['idx_style_body_text_theme'])) {
        update_post_meta($post_id, 'idx_style_body_text_theme', sanitize_text_field($_POST['idx_style_body_text_theme']));
    } else
        if (isset($post_id)) {
        delete_post_meta($post_id, 'idx_style_body_text_theme');
    }

    if (isset($_POST['idx_style_search_bar_bose_theme'])) {
        update_post_meta($post_id, 'idx_style_search_bar_bose_theme', sanitize_text_field($_POST['idx_style_search_bar_bose_theme']));
    } else
        if (isset($post_id)) {
        delete_post_meta($post_id, 'idx_style_search_bar_bose_theme');
    }

    if (isset($_POST['idx_style_search_bar_body_theme'])) {
        update_post_meta($post_id, 'idx_style_search_bar_body_theme', sanitize_text_field($_POST['idx_style_search_bar_body_theme']));
    } else
        if (isset($post_id)) {
        delete_post_meta($post_id, 'idx_style_search_bar_body_theme');
    }

    if (isset($_POST['footer_image_first'])) {
        update_option('footer_media_first_id', absint($_POST['footer_image_first']));
    }

    if (isset($_POST['footer_image_second'])) {
        update_option('footer_media_second_id', absint($_POST['footer_image_second']));
    }

    if (isset($_POST['footer_image_third'])) {
        update_option('footer_media_third', absint($_POST['footer_image_third']));
    }
}
// add_action('save_post', 'func_idx_save_style_theme', 10, 2);

function media_selector_print_scripts()
{
    $my_saved_attachment_post_id = get_option('footer_media_first_id', 0);
    $my_saved_attachment_post_id = get_option('footer_media_second_id', 0);
    $my_saved_attachment_post_id = get_option('footer_media_third', 0);

?>
    <script type='text/javascript'>
        jQuery(document).ready(function($) {

            var file_frame;
            var wp_media_post_id = wp.media.model.settings.post.id;
            var set_to_post_id = <?php echo $my_saved_attachment_post_id; ?>;
            var conjun = '';
            var previ = '';
            jQuery('#upload_image_button, #upload_image_button_second, #upload_image_button_third').on('click', function(event) {
                event.preventDefault();
                conjun = jQuery(this).attr('conjun');
                previ = jQuery(this).attr('previ');
                if (file_frame) {
                    file_frame.uploader.uploader.param('post_id', set_to_post_id);
                    file_frame.open();
                    return;
                } else {
                    wp.media.model.settings.post.id = set_to_post_id;
                }
                file_frame = wp.media.frames.file_frame = wp.media({
                    title: 'Select a image to upload',
                    button: {
                        text: 'Use this image',
                    },
                    multiple: false // Set to true to allow multiple files to be selected
                });
                file_frame.on('select', function() {
                    attachment = file_frame.state().get('selection').first().toJSON();
                    $(previ).attr('src', attachment.url).css('width', 'auto');
                    $(conjun).val(attachment.id);
                    wp.media.model.settings.post.id = wp_media_post_id;
                });
                file_frame.open();
            });
            jQuery('a.add_media').on('click', function() {
                wp.media.model.settings.post.id = wp_media_post_id;
            });
        });
    </script><?php
            }

            /*THEME_STYLE_CUSTOMIZER*/

            /*DINAMIC LABEL*/
            add_action('add_meta_boxes', 'dynamic_add_custom_box');
            /* Do something with the data entered */
            add_action('save_post', 'dynamic_save_postdata');
            function dynamic_add_custom_box()
            {
                add_meta_box('dynamic_sectionid', __('Slider Complements', 'myplugin_textdomain'), 'dynamic_inner_custom_box', 'dgt-slider');
            }

            function dynamic_inner_custom_box()
            {
                global $post;
                wp_nonce_field(plugin_basename(__FILE__), 'dynamicMeta_noncename');
                $post_meta = get_post_custom($post->ID);
                $headline_slider = '';
                if (isset($post_meta['headline_slider'][0])) {
                    $headline_slider = $post_meta['headline_slider'][0];
                }

                if (isset($post_meta['slider_url_dgt'][0])) {
                    $slider_url_dgt = $post_meta['slider_url_dgt'][0];
                }

                ?>

    <div id="meta_inner">
        <div class="item_complements">
            <div>Link</div>
            <input name="slider_url_dgt" size="28" id="slider_url_dgt" placeholder="http://dgtalliance.com" type="text" value="<?php echo esc_attr($slider_url_dgt); ?>">
        </div>
        <div class="item_complements">
            <div>Headline</div>
            <input name="headline_slider" id="headline_slider" placeholder="Headline text" type="text" value="<?php echo esc_attr($headline_slider); ?>">
        </div>
        <div class="item_complements">
            <div>Details</div>
            <?php

                $songs = null;
                $songs = get_post_meta($post->ID, 'defini', true);
                $c = 0;

                if (count($songs) > 0 && is_array($songs)) {
                    foreach ($songs as $track) {
                        if (isset($track['title']) || isset($track['track'])) {
                            printf('<p><input type="text" name="defini[%1$s][title]" value="%2$s" /><span class="remove">%4$s</span></p>', $c, $track['title'], $track['track'], __('Remove'));
                            $c = $c + 1;
                        }
                    }
                }

            ?>
            <span id="here"></span>
            <span class="add button button-primary button-large"><?php _e('Add'); ?></span>
        </div>
        <style type="text/css">
            .item_complements p {
                line-height: 3.5;
            }

            .item_complements div {
                font-weight: bold;
                margin-bottom: 8px;
            }

            .item_complements {
                margin-bottom: 15px;
            }

            span.remove:hover {
                background-color: #900c0c;
            }

            .item_complements input {
                width: 80%;
                height: 39px;
                padding-left: 15px;
            }

            span.remove {
                padding: 11px;
                background-color: red;
                color: white;
                cursor: pointer;
            }

            @media screen and (max-width: 680px) {
                .item_complements input {
                    width: 100%;
                }
            }
        </style>
        <script>
            var $ = jQuery.noConflict();
            $(document).ready(function() {
                var count = <?php echo $c; ?>;
                $(".add").click(function() {
                    count = count + 1;
                    $('#here').append('<p><input type="text" name="defini[' + count + '][title]" value="" /><span class="remove">Remove</span></p>');
                    return false;
                });
                $(".remove").live('click', function() {
                    $(this).parent().remove();
                });
            });
        </script>
    </div><?php

            }

            function dynamic_save_postdata($post_id)
            {
                if (isset($_POST['headline_slider'])) {
                    update_post_meta($post_id, 'headline_slider', sanitize_text_field($_POST['headline_slider']));
                } else if (isset($post_id)) {
                    delete_post_meta($post_id, 'headline_slider');
                }

                if (isset($_POST['slider_url_dgt'])) {
                    update_post_meta($post_id, 'slider_url_dgt', sanitize_text_field($_POST['slider_url_dgt']));
                } else if (isset($post_id)) {
                    delete_post_meta($post_id, 'slider_url_dgt');
                }

                if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
                    return;
                }

                if (!isset($_POST['dynamicMeta_noncename'])) {
                    return;
                }

                if (!wp_verify_nonce($_POST['dynamicMeta_noncename'], plugin_basename(__FILE__))) {
                    return;
                }

                $songs = $_POST['defini'];

                update_post_meta($post_id, 'defini', $songs);
            }

            /*DINAMIC LABEL*/

            function flexidx_custom_toolbar_link($wp_admin_bar)
            {                
                $args = array(
                    'id' => 'wpflexidx_toolbar',
                    'title' => '<div class="idxboost-toggle-admin" style="background-image: url(' . FLEX_IDX_URI . 'images/rocket.svg);width: 15px;height: 24px;background-position: center;background-repeat: no-repeat;position: relative;background-size: contain;display: inline-block;vertical-align: middle;margin-top: -3px;margin-right: 7px;" ></div><span class="ab-label">' . 'IDX Boost - MLS Search Technology' . '</span></a>',
                    'href' => '#',
                    'meta' => array(
                        'class' => 'wpflexidx_toolbar',
                        'title' => 'IDX Boost - MLS Search Technology',
                    ),
                );
                $wp_admin_bar->add_node($args);

                $args = array(
                    'id' => 'wpflexidx_toolbar-guides-map-search',
                    'title' => 'Map Search Filters',
                    'href' => admin_url('edit.php?post_type=flex-landing-pages'),
                    'parent' => 'wpflexidx_toolbar',
                    'meta' => array(
                        'class' => 'wpflexidx_toolbar-guides',
                        'title' => 'Map Search Filters',
                    ),
                );
                $wp_admin_bar->add_node($args);


                $args = array(
                    'id' => 'wpflexidx_toolbar-guides',
                    'title' => 'Display Filters',
                    'href' => admin_url('edit.php?post_type=flex-filter-pages'),
                    'parent' => 'wpflexidx_toolbar',
                    'meta' => array(
                        'class' => 'wpflexidx_toolbar-guides',
                        'title' => 'Display Filters',
                    ),
                );
                $wp_admin_bar->add_node($args);

                $args =
                    array(
                        'id' => 'My-IDX-Buildings',
                        'title' => 'My Buildings',
                        'href' => admin_url('edit.php?post_type=flex-idx-building'),
                        'parent' => 'wpflexidx_toolbar',
                        'meta' => array(
                            'class' => 'wpflexidx_toolbar-tutorials',
                            'title' => 'My Buildings',
                        ),
                    );
                $wp_admin_bar->add_node($args);

                $args =
                    array(
                        'id' => 'My-IDX-Sub-Area',
                        'title' => 'My Master Plans',
                        'href' => admin_url('edit.php?post_type=idx-sub-area'),
                        'parent' => 'wpflexidx_toolbar',
                        'meta' => array(
                            'class' => 'wpflexidx_toolbar-tutorials',
                            'title' => 'My Master Plans',
                        ),
                    );
                $wp_admin_bar->add_node($args);

                $args = array(
                    'id' => 'My-IDX-Pages',
                    'title' => 'Page’s URL Slug',
                    'href' => admin_url('edit.php?post_type=flex-idx-pages'),
                    'parent' => 'wpflexidx_toolbar',
                    'meta' => array(
                        'class' => 'wpflexidx_toolbar-tutorials',
                        'title' => 'Page’s URL Slug',
                    ),
                );
                $wp_admin_bar->add_node($args);
                global $flex_idx_info; 

                // Schema Seo
                if($flex_idx_info['agent']['has_generate_schema']){
                $args = array(
                    'id' => 'wpflexidx_toolbar-schemas',
                    'title' => 'Schemas',
                    'href' => admin_url('admin.php?page=flex-idx-schemas'),
                    'parent' => 'wpflexidx_toolbar',
                    'meta' => array(
                        'class' => 'wpflexidx_toolbar-guides',
                        'title' => 'Schemas',
                    ),
                );
                $wp_admin_bar->add_node($args);
                }

                // Settings Rental 
                                
                if($flex_idx_info['agent']['has_vacations_rentals']){
                $args = array(
                    'id' => 'wpflexidx_toolbar-settings-rental',
                    'title' => 'Settings for Rental',
                    'href' => admin_url('admin.php?page=flex-idx-settings-rental'),
                    'parent' => 'wpflexidx_toolbar',
                    'meta' => array(
                        'class' => 'wpflexidx_toolbar-guides',
                        'title' => 'Settings for Rental',
                    ),
                );
                $wp_admin_bar->add_node($args);
                }

            }

            add_action('admin_bar_menu', 'flexidx_custom_toolbar_link', 999);


            function custom_page_template($page_template)
            {
                global $post, $flex_idx_info;

                if (!empty($flex_idx_info['agent']['has_cms']) && $flex_idx_info['agent']['has_cms'] != false) {
                    $metas = get_post_meta($post->ID, 'idx_page_type');

                    if (!empty($metas) && $metas[0] == 'custom') {
                        $page_template = FLEX_IDX_PATH . '/views/pages/custom-page-template.php';
                    }

                    if (!empty($flex_idx_info['agent']['has_cms_form']) && $flex_idx_info['agent']['has_cms_form'] != false) {
                        if (!empty($metas) && $metas[0] == 'landing') {
                            $page_template = FLEX_IDX_PATH . '/views/pages/landing-page-template.php';
                        }
                    }
                }

                return $page_template;
            }

            add_filter('page_template', 'custom_page_template');
